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
            <form id="bookingForm" method="POST" action="{{ route('admin.store.file') }}">
                @csrf

                <hr>
                <div class="row">
                    <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="customer_id">{{ __('Customer') }} <span class="text-danger">*</span></label>
                            <select name="customer_id" id="customer_id" class="form-control select2" required>
                                <option value="">{{ __('Select Customer') }}</option>
                                @foreach ($customers as $customer)
                                    <option value="{{ $customer->id }}" data-phone="{{ $customer->phone }}"
                                        data-email="{{ $customer->email }}"
                                        data-bookings="{{ $customer->bookings->map(function ($b) {
                                            return ['id' => $b->id, 'text' => 'Booking #' . $b->id];
                                        }) }}"
                                        data-cars="{{ $customer->cars->map(function ($c) {
                                            return ['id' => $c->id, 'text' => 'Car #' . $c->id . ' (' . $c->model . ')'];
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
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>{{ __('File`s Name') }} <span class="text-danger">*</span></label>
                            <input type="text" name="name" class="form-control">
                            @error('name')
                                <span class="error text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <p class="mb-1"><strong>{{ __('Total booking price') }}:</strong></p>
                            <input type="number" class="form-control" name="total" readonly>
                        </div>
                        <div class="col-md-4">
                            <p class="mb-1"><strong>{{ __('paid') }}:</strong></p>
                            <input type="number" class="form-control" name="paid">
                        </div>
                        <div class="col-md-4">
                            <p class="mb-1"><strong>{{ __('remain') }}:</strong></p>
                            <input type="number" class="form-control" name="remain" readonly>
                        </div>
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
        $('#customer_id').on('change', function() {
            const selected = $(this).find('option:selected');
            const phone = selected.data('phone');
            const email = selected.data('email');

            // ✅ تحديث بيانات الاتصال
            $('#customer-phone').text(phone || '{{ __('N/A') }}');
            $('#customer-email').text(email || '{{ __('N/A') }}');

            // ✅ توليد اسم الملف: اسم العميل + رقم عشوائي
            const customerName = selected.text().split('(')[0].trim(); // فقط الاسم بدون رقم الهاتف
            const randomNum = Math.floor(Math.random() * 1000000);
            const fileName = customerName + '-' + randomNum;

            $('input[name="name"]').val(fileName);
        });
    </script>



@endsection
