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
            margin-bottom: 20px;
        }

        .price-summary {
            background: #f8f9fa;
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 20px;
        }

        .price-summary .form-control[readonly] {
            background-color: #fff;
        }

        .table-responsive {
            margin-top: 20px;
        }

        .card-header {
            padding-bottom: 10px;
        }

        .card-header h4 {
            margin-bottom: 0;
        }

        hr {
            margin-top: 15px;
            margin-bottom: 15px;
        }
    </style>
@endsection

@section('content')
    <div class="card">
        <div class="card-header">
            <h4 class="mb-0">{{ $file->customer->name }}`s Files</h4>
            <hr>
        </div>

        <div class="card-body">


            <div class="customer-details-box">
                <div class="row">
                    <div class="col-md-4">
                        <p><strong>{{ __('Customer Name') }}:</strong> {{ $file->customer->name }}</p>
                    </div>
                    <div class="col-md-4">
                        <p><strong>{{ __('Email') }}:</strong> {{ $file->customer->email }}</p>
                    </div>
                    <div class="col-md-4">
                        <p><strong>{{ __('Phone') }}:</strong> {{ $file->customer->phone }}</p>
                    </div>
                </div>
            </div>

            {{-- <div class="price-summary">
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="total"><strong>{{ __('Total booking price') }}:</strong></label>
                            <input type="number" class="form-control" name="total" readonly>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="paid"><strong>{{ __('Paid') }}:</strong></label>
                            <input type="number" class="form-control" name="paid">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="remain"><strong>{{ __('Remain') }}:</strong></label>
                            <input type="number" class="form-control" name="remain" readonly>
                        </div>
                    </div>
                </div>
            </div> --}}

            <div class="form-group text-right mt-4">
                <a href="{{ route('admin.booking.create', ['file_id' => $file->id]) }}" class="btn btn-primary">create
                    hotel
                    booking</a>
                <a href="{{ route('car.create', ['file_id' => $file->id]) }}" class="btn btn-primary">create car
                    booking</a>
            </div>



            <h4>{{ __('Hotel Bookings') }}</h4>
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header bg-primary text-white">
                            <h4 class="mb-0">{{ __('All bookings') }}</h4>
                        </div>

                        <div class="card-body">

                            <!-- Bulk Actions -->



                            <div class="table-responsive">
                                <table class="table table-bordered table-hover" style="width:100%">
                                    <thead class="thead-light">
                                        <tr>
                                            <th width="50"><input type="checkbox" id="selectAll"></th>
                                            <th>{{ __('Booking NO') }}</th>
                                            <th>{{ __('booking.customer_name') }}</th>
                                            <th>{{ __('booking.hotel_name') }}</th>
                                            <th>{{ __('Pickup date') }}</th>
                                            <th>{{ __('Return_date') }}</th>
                                            <th>{{ __('Total') }}</th>
                                            <th>{{ __('roles.status') }}</th>
                                            <th>change status </th>
                                            <th>{{ __('roles.Actions') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($bookings as $booking)
                                            <tr>
                                                <td><input type="checkbox" name="bulk_ids[]" value="{{ $booking->id }}">
                                                </td>
                                                <td>#{{ $booking->id }}</td>
                                                <td>{{ $booking->customer->name }}</td>
                                                <td>{{ $booking->hotel->name }}</td>
                                                <td>{{ \Carbon\Carbon::parse($booking->arrival_date)->format('d M Y') }}
                                                </td>
                                                <td>{{ \Carbon\Carbon::parse($booking->leave_date)->format('d M Y') }}
                                                </td>
                                                <td>{{ number_format($booking->total, 2) }} {{ $booking->currency }}
                                                </td>
                                                <td>
                                                    <span
                                                        class="badge badge-pill
                                                @if ($booking->status == 'pending') badge-warning
                                                @elseif($booking->status == 'confirmed') badge-success
                                                @elseif($booking->status == 'cancelled') badge-danger
                                                @else badge-info @endif">
                                                        {{ ucfirst($booking->status) }}
                                                    </span>
                                                </td>
                                                <td>
                                                    <form action="{{ route('booking.updateStatus', $booking->id) }}"
                                                        method="POST" class="form-inline d-inline-block">
                                                        @csrf
                                                        @method('PUT')
                                                        <div class="form-group">
                                                            <select name="status" class="form-control form-control-sm"
                                                                onchange="this.form.submit()">
                                                                <option value="pending"
                                                                    {{ $booking->status == 'pending' ? 'selected' : '' }}>
                                                                    Pending
                                                                </option>
                                                                <option value="confirmed"
                                                                    {{ $booking->status == 'confirmed' ? 'selected' : '' }}>
                                                                    confirmed
                                                                </option>
                                                                <option value="cancelled"
                                                                    {{ $booking->status == 'cancelled' ? 'selected' : '' }}>
                                                                    cancelled
                                                                </option>

                                                                {{-- <option value="completed" {{ $booking->status == 'completed' ? 'selected' : '' }}>Completed</option> --}}
                                                            </select>
                                                        </div>
                                                    </form>
                                                </td>
                                                <td>
                                                    <div class="d-flex">
                                                        @can('edit_booking')
                                                            <a href="{{ route('admin.booking.show', $booking->id) }}"
                                                                class="btn btn-sm btn-info action-btn"
                                                                title="{{ __('view') }}">
                                                                <i class="fas fa-eye"></i>
                                                            </a>
                                                            <a href="{{ route('admin.booking.edit', $booking->id) }}"
                                                                class="btn btn-sm btn-primary action-btn"
                                                                title="{{ __('edit') }}">
                                                                <i class="fas fa-edit"></i>
                                                            </a>
                                                        @endcan



                                                        @can('edit_booking')
                                                            <a href="{{ route('booking.voucher.pdf', $booking->id) }}"
                                                                class="btn btn-sm btn-secondary action-btn"
                                                                title="{{ __('PDF') }}">
                                                                <i class="fas fa-file-pdf"></i>
                                                            </a>
                                                        @endcan

                                                        <a href="{{ route('admin.customer.show', $booking->customer_id) }}"
                                                            class="btn btn-sm btn-light action-btn"
                                                            title="{{ __('customer_profile') }}">
                                                            <i class="fas fa-user"></i>
                                                        </a>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>


                            <!-- Pagination -->


                        </div>
                    </div>
                </div>
            </div>

            <h4>{{ __('Car Bookings') }}</h4>
            <div class="card-body">

                <!-- Bookings Table -->
                <div class="table-responsive">
                    <table id="bookingsTable" class="table table-bordered table-hover" style="width:100%">
                        <thead class="thead-light">
                            <tr>
                                <th>Booking ID</th>
                                <th>Customer</th>
                                <th>Car</th>
                                <th>Pickup Date</th>
                                <th>Return Date</th>
                                <th>Total </th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($cars as $booking)
                                <tr>
                                    <td>#{{ $booking->id }}</td>
                                    <td>{{ $booking->customer->name }}</td>
                                    <td>{{ $booking->category->category }} ({{ $booking->category->model }})</td>
                                    <td>{{ \Carbon\Carbon::parse($booking->arrival_date)->format('d M Y') }} at
                                        {{ $booking->arrival_time }}</td>
                                    <td>{{ \Carbon\Carbon::parse($booking->leave_date)->format('d M Y') }} at
                                        {{ $booking->leave_time }}</td>
                                    <td>{{ number_format($booking->total, 2) }} $</td>
                                    <td>
                                        <span
                                            class="badge badge-pill
                                                @if ($booking->status == 'pending') badge-warning
                                                @elseif($booking->status == 'approved') badge-success
                                                @elseif($booking->status == 'rejected') badge-danger
                                                @else badge-info @endif">
                                            {{ ucfirst($booking->status) }}
                                        </span>
                                    </td>
                                    <td>
                                        <div class="d-flex">
                                            <a href="{{ route('car.show', $booking->id) }}"
                                                class="btn btn-sm btn-info action-btn" title="View">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('car.edit', $booking->id) }}"
                                                class="btn btn-sm btn-primary action-btn" title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form action="{{ route('car.updateStatus', $booking->id) }}" method="POST"
                                                class="form-inline d-inline-block">
                                                @csrf
                                                @method('PUT')
                                                <div class="form-group">
                                                    <select name="status" class="form-control form-control-sm"
                                                        onchange="this.form.submit()">
                                                        <option value="pending"
                                                            {{ $booking->status == 'pending' ? 'selected' : '' }}>Pending
                                                        </option>
                                                        <option value="approved"
                                                            {{ $booking->status == 'approved' ? 'selected' : '' }}>Approved
                                                        </option>
                                                        <option value="rejected"
                                                            {{ $booking->status == 'rejected' ? 'selected' : '' }}>Rejected
                                                        </option>
                                                        {{-- <option value="completed" {{ $booking->status == 'completed' ? 'selected' : '' }}>Completed</option> --}}
                                                    </select>
                                                </div>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>



            </div>
            @php
                $bookingTotal = $bookings->sum('total');
                $carTotal = $cars->sum('total');
            @endphp

            <div class="alert alert-info">
                <strong>{{ __('Price Summary') }}:</strong><br>
                {{ __('Bookings Total') }}: {{ number_format($bookingTotal, 2) }}<br>
                {{ __('Cars Total') }}: {{ number_format($carTotal, 2) }}<br>
                <strong>{{ __('Total') }}: {{ number_format($bookingTotal + $carTotal, 2) }}</strong>
            </div>
        </div>
    </div>
    <div class="card-body">
        <!-- ... (بقية المحتوى الحالي حتى قسم الملخص) ... -->

        @php
            $bookingTotal = $bookings->sum('total');
            $carTotal = $cars->sum('total');
            $grandTotal = $bookingTotal + $carTotal;
            $paidTotal = $file->paid;
            $remainTotal = $file->remain;
        @endphp

        <div class="price-summary">
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="total"><strong>{{ __('Total booking price') }}:</strong></label>
                        <input type="number" class="form-control" id="grand_total"
                            value="{{ number_format($grandTotal, 2) }}" readonly>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="paid"><strong>{{ __('Paid') }}:</strong></label>
                        <input type="number" class="form-control" id="paid_total"
                            value="{{ number_format($paidTotal, 2) }}" readonly>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="remain"><strong>{{ __('Remain') }}:</strong></label>
                        <input type="number" class="form-control" id="remain_total"
                            value="{{ number_format($remainTotal, 2) }}" readonly>
                    </div>
                </div>
            </div>
        </div>

        <!-- نموذج إضافة دفعة جديدة -->
        <div class="card mt-4">
            <div class="card-header">
                <h5>{{ __('Add New Payment') }}</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('payments.store', $file->id) }}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="amount">{{ __('Amount') }}</label>
                                <input type="number" step="0.01" class="form-control" name="amount"
                                    id="payment_amount" required>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="payment_date">{{ __('Payment Date') }}</label>
                                <input type="date" class="form-control" name="payment_date"
                                    value="{{ date('Y-m-d') }}" required>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="payment_method">{{ __('Payment Method') }}</label>
                                <select class="form-control" name="payment_method" required>
                                    <option value="cash">{{ __('Cash') }}</option>
                                    <option value="bank_transfer">{{ __('Bank Transfer') }}</option>
                                    <option value="credit_card">{{ __('Credit Card') }}</option>
                                    <option value="check">{{ __('Check') }}</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="notes">{{ __('Notes') }}</label>
                        <textarea class="form-control" name="notes" rows="2"></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">{{ __('Add Payment') }}</button>
                </form>
            </div>
        </div>


        <div class="payment-history">
            <h5>{{ __('Payment History') }}</h5>
            @if ($file->payments->count() > 0)
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>{{ __('Date') }}</th>
                            <th>{{ __('Amount') }}</th>
                            <th>{{ __('Method') }}</th>
                            <th>{{ __('Notes') }}</th>
                            <th>{{ __('Actions') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($file->payments as $payment)
                            <tr>
                                <td>{{ $payment->payment_date }}</td>
                                <td>{{ number_format($payment->amount, 2) }}</td>
                                <td>{{ ucfirst($payment->payment_method) }}</td>
                                <td>{{ $payment->notes }}</td>
                                {{-- <td>
                            <form action="{{ route('payments.destroy', $payment->id) }}" method="POST"
                                onsubmit="return confirm('Are you sure?')" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </td> --}}
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <p>{{ __('No payments recorded yet') }}</p>
            @endif
        </div>


    </div>
    </div>
@endsection


</div>


@section('js')
    <script>
        $(document).ready(function() {

            function updateTotals() {
                let grandTotal = parseFloat('{{ $grandTotal }}');
                let paidTotal = parseFloat('{{ $paidTotal }}');
                let remainTotal = grandTotal - paidTotal;

                $('#paid_total').val(paidTotal.toFixed(2));
                $('#remain_total').val(remainTotal > 0 ? remainTotal.toFixed(2) : '0.00');
            }

            updateTotals();
        });
    </script>
    <script src="{{ asset('js/select2.min.js') }}"></script>
    <script>
        $(document).ready(function() {

            $('.js-select2-custom').select2({
                placeholder: "{{ __('Select an option') }}",
                allowClear: true,
                multiple: true
            });


            function calculateTotal() {
                const selectedBookings = $('#booking_id').val() || [];
                const selectedCars = $('#car_id').val() || [];

                let bookingTotal = 0;
                let carTotal = 0;


                selectedBookings.forEach(id => {
                    const price = parseFloat(bookingPrices[id]);
                    if (!isNaN(price)) {
                        bookingTotal += price;
                    }
                });


                selectedCars.forEach(id => {
                    const price = parseFloat(carPrices[id]);
                    if (!isNaN(price)) {
                        carTotal += price;
                    }
                });

                const total = bookingTotal + carTotal;
                $('input[name="total"]').val(total.toFixed(2));
                calculateRemaining();
                showPriceBreakdown(bookingTotal, carTotal, total);
            }

            function calculateRemaining() {
                const total = parseFloat($('input[name="total"]').val()) || 0;
                const paid = parseFloat($('input[name="paid"]').val()) || 0;
                const remain = Math.max(total - paid, 0);
                $('input[name="remain"]').val(remain.toFixed(2));
            }

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


            $('#booking_id, #car_id').on('change', calculateTotal);
            $('input[name="paid"]').on('input', calculateRemaining);
        });
    </script>
@endsection
