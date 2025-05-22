@extends('layouts.dashboard')
@section('title', __('Booking Details'))

@section('css')
<link rel="stylesheet" href="{{ asset('css/select2.min.css') }}">
<style>
    .select2-container {
        width: 100% !important;
    }
    .customer-details-box {
        border: 1px solid #ddd;
        padding: 15px;
        border-radius: 5px;
        background: #f9f9f9;
    }
</style>
@endsection

@section('content')
<div class="card">
    <div class="card-header">
        <h4 class="mb-0">{{ __('Booking Details') }}</h4>
    </div>
    <div class="card-body">
        <form id="bookingForm" method="POST" action="{{route('admin.store.file')}}">
            @csrf

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="customer_id">{{ __('Customer') }} <span class="text-danger">*</span></label>
                        <select name="customer_id" id="customer_id" class="form-control select2" required>
                            <option value="">{{ __('Select Customer') }}</option>
                            @foreach($customers as $customer)
                            <option value="{{ $customer->id }}"
                                data-phone="{{ $customer->phone }}"
                                data-email="{{ $customer->email }}"
                                data-bookings="{{ $customer->bookings->map(function($b) {
                                    return ['id' => $b->id, 'text' => 'Booking #'.$b->id];
                                }) }}"
                                data-cars="{{ $customer->cars->map(function($c) {
                                    return ['id' => $c->id, 'text' => 'Car #'.$c->id.' ('.$c->model.')'];
                                }) }}">
                                {{ $customer->name }} ({{ $customer->phone }})
                            </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="customer-details-box">
                        <div class="detail-item">
                            <strong>{{ __('Phone') }}:</strong>
                            <span id="customer-phone">{{ __('Not selected') }}</span>
                        </div>
                        <div class="detail-item">
                            <strong>{{ __('Email') }}:</strong>
                            <span id="customer-email">{{ __('Not selected') }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row mt-3">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="booking_id">{{ __('Bookings') }}</label>
                        <select name="booking_id[]" id="booking_id" class="form-control select2 js-select2-custom" multiple disabled>
                            <option value="">{{ __('No bookings available') }}</option>
                        </select>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label for="car_id">{{ __('Cars') }}</label>
                        <select name="car_id[]" id="car_id" class="form-control select2 js-select2-custom" multiple disabled>
                            <option value="">{{ __('No cars available') }}</option>
                        </select>
                    </div>
                </div>
            </div>
            <hr>
            <div class="row">
                            <div class="col-md-4">
                            <p class="mb-1"><strong>{{ __('Total booking price') }}:</strong></p>
                            <input type="number" class="form-control" name="total" readonly>
                        </div>
                            <div class="col-md-4">
                            <p class="mb-1"><strong>{{ __('paid') }}:</strong></p>
                            <input type="number" class="form-control" name="paid" >
                        </div>
                            <div class="col-md-4">
                            <p class="mb-1"><strong>{{ __('remain') }}:</strong></p>
                            <input type="number" class="form-control" name="remain" readonly>
                        </div>
            </div>
            <div class="form-group mt-4">
                <button type="submit" class="btn btn-primary">{{ __('Save') }}</button>
            </div>

        </form>
    </div>
</div>
@endsection

@section('js')
<script src="{{ asset('js/select2.min.js') }}"></script>
<script>
$(document).ready(function () {
    // تهيئة Select2
    $('.js-select2-custom').select2({
        placeholder: "{{ __('Select an option') }}",
        allowClear: true,
        multiple: true
    });

    $('#customer_id').select2({
        placeholder: "{{ __('Select Customer') }}",
        allowClear: true
    });

    // بيانات الأسعار من السيرفر
    const bookingPrices = {!! $bookingPricesJson ?? '{}' !!}; // booking_id => price
    const carPrices = {!! $carPricesJson ?? '{}' !!}; // car_id => price

    // تحديث الحقول عند تغيير العميل
    $('#customer_id').on('change', function () {
        const selected = $(this).find('option:selected');
        const phone = selected.data('phone');
        const email = selected.data('email');

        // تحديث بيانات العميل
        $('#customer-phone').text(phone || '{{ __("N/A") }}');
        $('#customer-email').text(email || '{{ __("N/A") }}');

        // الحصول على بيانات الحجوزات والسيارات
        let bookings = selected.data('bookings');
        let cars = selected.data('cars');

        try {
            if (typeof bookings === 'string') bookings = JSON.parse(bookings);
            if (typeof cars === 'string') cars = JSON.parse(cars);
        } catch (err) {
            console.error('JSON parse error:', err);
            bookings = [];
            cars = [];
        }

        // تحديث القوائم المنسدلة
        updateDropdown('#booking_id', bookings, '{{ __("No bookings available") }}');
        updateDropdown('#car_id', cars, '{{ __("No cars available") }}');

        // تصفير المدفوعات
        resetPaymentFields();
    });

    // عند اختيار حجز أو سيارة
    $('#booking_id, #car_id').on('change', calculateTotal);

    // عند إدخال المدفوع
    $('input[name="paid"]').on('input', calculateRemaining);

    // دالة تحديث القوائم
    function updateDropdown(selector, data, emptyMessage) {
        const dropdown = $(selector);
        dropdown.empty();

        if (Array.isArray(data) && data.length > 0) {
            dropdown.append(new Option('{{ __("Select options") }}', '', false, false));
            data.forEach(item => {
                dropdown.append(new Option(item.text, item.id, false, false));
            });
            dropdown.prop('disabled', false).trigger('change');
        } else {
            dropdown.append(new Option(emptyMessage, '', true, true));
            dropdown.prop('disabled', true).trigger('change');
        }
    }

    // دالة تصفير الحقول
    function resetPaymentFields() {
        $('input[name="total"]').val('0.00');
        $('input[name="paid"]').val('0.00');
        $('input[name="remain"]').val('0.00');
        $('#price-breakdown').remove(); // لو كان في تفاصيل سابقة
    }

    // دالة حساب الإجمالي
    function calculateTotal() {
        const selectedBookings = $('#booking_id').val() || [];
        const selectedCars = $('#car_id').val() || [];

        let bookingTotal = 0;
        let carTotal = 0;

        // حساب أسعار الحجوزات
        selectedBookings.forEach(id => {
            const price = parseFloat(bookingPrices[id]);
            if (!isNaN(price)) {
                bookingTotal += price;
            }
        });

        // حساب أسعار السيارات
        selectedCars.forEach(id => {
            const price = parseFloat(carPrices[id]);
            if (!isNaN(price)) {
                carTotal += price;
            }
        });

        const total = bookingTotal + carTotal;

        $('input[name="total"]').val(total.toFixed(2));

        // تحديث الباقي
        calculateRemaining();

        // إظهار التفاصيل
        showPriceBreakdown(bookingTotal, carTotal, total);
    }

    // دالة حساب الباقي
    function calculateRemaining() {
        const total = parseFloat($('input[name="total"]').val()) || 0;
        const paid = parseFloat($('input[name="paid"]').val()) || 0;
        const remain = Math.max(total - paid, 0);
        $('input[name="remain"]').val(remain.toFixed(2));
    }

    // إظهار تفاصيل السعر
    function showPriceBreakdown(bookingTotal, carTotal, total) {
        $('#price-breakdown').remove();

        const breakdownHTML = `
            <div id="price-breakdown" class="mt-3 alert alert-info">
                <strong>{{ __('Breakdown') }}:</strong><br>
                {{ __('Bookings') }}: ${bookingTotal.toFixed(2)}<br>
                {{ __('Cars') }}: ${carTotal.toFixed(2)}<br>
                <strong>{{ __('Total') }}: ${total.toFixed(2)}</strong>
            </div>
        `;

        $('form#bookingForm').append(breakdownHTML);
    }
});
</script>


@endsection
