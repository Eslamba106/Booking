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

        /* New styles for payments */
        .payment-card {
            border-left: 4px solid #4e73df;
            margin-bottom: 15px;
        }

        .payment-history {
            max-height: 300px;
            overflow-y: auto;
        }

        .installment-plan {
            border: 1px dashed #ddd;
            padding: 10px;
            margin-bottom: 15px;
            background: #f8f9fa;
        }

        .payment-form {
            background: #f1f8ff;
            padding: 15px;
            border-radius: 5px;
        }

        .summary-card {
            border: 1px solid #dee2e6;
            border-radius: 5px;
            margin-bottom: 20px;
        }

        .summary-card-header {
            background-color: #f8f9fa;
            padding: 10px 15px;
            border-bottom: 1px solid #dee2e6;
            font-weight: bold;
        }

        .summary-card-body {
            padding: 15px;
        }

        .nav-tabs .nav-link.active {
            font-weight: bold;
            border-bottom: 2px solid #4e73df;
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

            @php
                $bookingTotal = $bookings->sum('total');
                $carTotal = $cars->sum('total');
                $grandTotal = $bookingTotal + $carTotal;
                $totalPaid = $file->payments->sum('amount');
                $balance = $grandTotal - $totalPaid;
            @endphp

            <div class="row">
                <div class="col-md-12">
                    <ul class="nav nav-tabs" id="bookingTabs" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="summary-tab" data-toggle="tab" href="#summary"
                                role="tab">Summary</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="hotel-tab" data-toggle="tab" href="#hotel" role="tab">Hotel
                                Bookings</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="car-tab" data-toggle="tab" href="#car" role="tab">Car
                                Bookings</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="payments-tab" data-toggle="tab" href="#payments"
                                role="tab">Payments</a>
                        </li>
                    </ul>

                    <div class="tab-content" id="bookingTabsContent">
                        <!-- Summary Tab -->
                        <div class="tab-pane fade show active" id="summary" role="tabpanel">
                            <div class="row mt-3">
                                <div class="col-md-6">
                                    <div class="summary-card">
                                        <div class="summary-card-header">
                                            Financial Summary
                                        </div>
                                        <div class="summary-card-body">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <p><strong>Hotel Bookings Total:</strong></p>
                                                    <p><strong>Car Bookings Total:</strong></p>
                                                    <p><strong>Grand Total:</strong></p>
                                                    <p><strong>Total Paid:</strong></p>
                                                    <p><strong>Balance:</strong></p>
                                                </div>
                                                <div class="col-md-6 text-right">
                                                    <p>{{ number_format($bookingTotal, 2) }}</p>
                                                    <p>{{ number_format($carTotal, 2) }}</p>
                                                    <p class="font-weight-bold">{{ number_format($grandTotal, 2) }}</p>
                                                    <p class="text-success">{{ number_format($totalPaid, 2) }}</p>
                                                    <p class="{{ $balance > 0 ? 'text-danger' : 'text-success' }}">
                                                        {{ number_format($balance, 2) }}
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="summary-card">
                                        <div class="summary-card-header">
                                            Quick Actions
                                        </div>
                                        <div class="summary-card-body text-center">
                                            <a href="{{ route('admin.booking.create', ['file_id' => $file->id, 'customer_id' => $file->customer_id]) }}"
                                                class="btn btn-primary m-2">
                                                <i class="fas fa-hotel"></i> Create Hotel Booking
                                            </a>
                                            <a href="{{ route('car.create', ['file_id' => $file->id]) }}"
                                                class="btn btn-primary m-2">
                                                <i class="fas fa-car"></i> Create Car Booking
                                            </a>
                                            <button class="btn btn-success m-2" data-toggle="modal"
                                                data-target="#addPaymentModal">
                                                <i class="fas fa-money-bill-wave"></i> Add Payment
                                            </button>
                                            @if ($balance > 0)
                                                <button class="btn btn-info m-2" data-toggle="modal"
                                                    data-target="#createInstallmentModal">
                                                    <i class="fas fa-calendar-alt"></i> Create Installment Plan
                                                </button>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Hotel Bookings Tab -->
                        <div class="tab-pane fade" id="hotel" role="tabpanel">
                            <div class="table-responsive mt-3">
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
                                            <th>Change Status</th>
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
                                                <td>{{ \Carbon\Carbon::parse($booking->leave_date)->format('d M Y') }}</td>
                                                <td>{{ number_format($booking->total, 2) }} {{ $booking->currency }}</td>
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
                                                                    Pending</option>
                                                                <option value="confirmed"
                                                                    {{ $booking->status == 'confirmed' ? 'selected' : '' }}>
                                                                    Confirmed</option>
                                                                <option value="cancelled"
                                                                    {{ $booking->status == 'cancelled' ? 'selected' : '' }}>
                                                                    Cancelled</option>
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
                        </div>

                        <!-- Car Bookings Tab -->
                        <div class="tab-pane fade" id="car" role="tabpanel">
                            <div class="table-responsive mt-3">
                                <table id="bookingsTable" class="table table-bordered table-hover" style="width:100%">
                                    <thead class="thead-light">
                                        <tr>
                                            <th>Booking ID</th>
                                            <th>Customer</th>
                                            <th>Car</th>
                                            <th>Pickup Date</th>
                                            <th>Return Date</th>
                                            <th>Total</th>
                                            <th>Status</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($cars as $booking)
                                            <tr>
                                                <td>#{{ $booking->id }}</td>
                                                <td>{{ $booking->customer->name }}</td>
                                                <td>{{ $booking->category->category }} ({{ $booking->category->model }})
                                                </td>
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
                                                        <form action="{{ route('car.updateStatus', $booking->id) }}"
                                                            method="POST" class="form-inline d-inline-block">
                                                            @csrf
                                                            @method('PUT')
                                                            <div class="form-group">
                                                                <select name="status"
                                                                    class="form-control form-control-sm"
                                                                    onchange="this.form.submit()">
                                                                    <option value="pending"
                                                                        {{ $booking->status == 'pending' ? 'selected' : '' }}>
                                                                        Pending</option>
                                                                    <option value="approved"
                                                                        {{ $booking->status == 'approved' ? 'selected' : '' }}>
                                                                        Approved</option>
                                                                    <option value="rejected"
                                                                        {{ $booking->status == 'rejected' ? 'selected' : '' }}>
                                                                        Rejected</option>
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

                        <!-- Payments Tab -->
                        <div class="tab-pane fade" id="payments" role="tabpanel">
                            <div class="row mt-3">
                                <div class="col-md-8">
                                    <div class="card payment-card">
                                        <div class="card-header">
                                            <h5>Payment History</h5>
                                        </div>
                                        <div class="card-body payment-history">
                                            @if ($file->payments->count() > 0)
                                                <table class="table table-striped">
                                                    <thead>
                                                        <tr>
                                                            <th>Date</th>
                                                            <th>Amount</th>
                                                            <th>Method</th>
                                                            <th>Notes</th>
                                                            <th>Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($file->payments as $payment)
                                                            <tr>
                                                                <td>{{ $payment->payment_date->format('d M Y') }}</td>
                                                                <td>{{ number_format($payment->amount, 2) }}</td>
                                                                <td>{{ ucfirst($payment->payment_method) }}</td>
                                                                <td>{{ $payment->notes ?? '-' }}</td>
                                                                <td>
                                                                    <a href="{{ route('payment.edit', $payment->id) }}"
                                                                        class="btn btn-sm btn-primary">
                                                                        <i class="fas fa-edit"></i>
                                                                    </a>
                                                                    <form
                                                                        action="{{ route('payment.destroy', $payment->id) }}"
                                                                        method="POST" style="display:inline">
                                                                        @csrf
                                                                        @method('DELETE')
                                                                        <button type="submit"
                                                                            class="btn btn-sm btn-danger"
                                                                            onclick="return confirm('Are you sure?')">
                                                                            <i class="fas fa-trash"></i>
                                                                        </button>
                                                                    </form>
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            @else
                                                <p>No payments recorded yet.</p>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="card">
                                        <div class="card-header">
                                            <h5>Payment Summary</h5>
                                        </div>
                                        <div class="card-body">
                                            <div class="form-group">
                                                <label>Total Amount</label>
                                                <input type="text" class="form-control"
                                                    value="{{ number_format($grandTotal, 2) }}" readonly>
                                            </div>
                                            <div class="form-group">
                                                <label>Total Paid</label>
                                                <input type="text" class="form-control"
                                                    value="{{ number_format($totalPaid, 2) }}" readonly>
                                            </div>
                                            <div class="form-group">
                                                <label>Balance</label>
                                                <input type="text"
                                                    class="form-control {{ $balance > 0 ? 'bg-danger text-white' : 'bg-success text-white' }}"
                                                    value="{{ number_format($balance, 2) }}" readonly>
                                            </div>
                                        </div>
                                    </div>

                                    @if ($file->installments->count() > 0)
                                        <div class="card mt-3">
                                            <div class="card-header">
                                                <h5>Installment Plan</h5>
                                            </div>
                                            <div class="card-body">
                                                @foreach ($file->installments as $installment)
                                                    <div class="installment-plan">
                                                        <p><strong>Amount:</strong>
                                                            {{ number_format($installment->amount, 2) }}</p>
                                                        <p><strong>Due Date:</strong>
                                                            {{ $installment->due_date->format('d M Y') }}</p>
                                                        <p><strong>Status:</strong>
                                                            <span
                                                                class="badge badge-{{ $installment->status == 'paid' ? 'success' : ($installment->is_overdue ? 'danger' : 'warning') }}">
                                                                {{ ucfirst($installment->status) }}
                                                                @if ($installment->is_overdue && $installment->status != 'paid')
                                                                    (Overdue)
                                                                @endif
                                                            </span>
                                                        </p>
                                                        @if ($installment->status == 'pending')
                                                            <a href="{{ route('installment.pay', $installment->id) }}"
                                                                class="btn btn-sm btn-success">
                                                                Mark as Paid
                                                            </a>
                                                        @endif
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Add Payment Modal -->
    <div class="modal fade" id="addPaymentModal" tabindex="-1" role="dialog" aria-labelledby="addPaymentModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addPaymentModalLabel">Add New Payment</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('payment.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="file_id" value="{{ $file->id }}">
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="amount">Amount</label>
                            <input type="number" step="0.01" class="form-control" id="amount" name="amount"
                                required>
                        </div>
                        <div class="form-group">
                            <label for="payment_date">Payment Date</label>
                            <input type="date" class="form-control" id="payment_date" name="payment_date"
                                value="{{ now()->format('Y-m-d') }}" required>
                        </div>
                        <div class="form-group">
                            <label for="payment_method">Payment Method</label>
                            <select class="form-control" id="payment_method" name="payment_method" required>
                                <option value="cash">Cash</option>
                                <option value="credit_card">Credit Card</option>
                                <option value="bank_transfer">Bank Transfer</option>
                                <option value="check">Check</option>
                                <option value="other">Other</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="notes">Notes</label>
                            <textarea class="form-control" id="notes" name="notes" rows="3"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save Payment</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Create Installment Plan Modal -->
    <div class="modal fade" id="createInstallmentModal" tabindex="-1" role="dialog"
        aria-labelledby="createInstallmentModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="createInstallmentModalLabel">Create Installment Plan</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('installment.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="file_id" value="{{ $file->id }}">
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Total Balance</label>
                            <input type="text" class="form-control" value="{{ number_format($balance, 2) }}"
                                readonly>
                        </div>
                        <div class="form-group">
                            <label for="installment_count">Number of Installments</label>
                            <select class="form-control" id="installment_count" name="installment_count" required>
                                <option value="2">2</option>
                                <option value="3">3</option>
                                <option value="4">4</option>
                                <option value="6">6</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="first_payment_date">First Payment Date</label>
                            <input type="date" class="form-control" id="first_payment_date" name="first_payment_date"
                                value="{{ now()->addDays(7)->format('Y-m-d') }}" required>
                        </div>
                        <div class="form-group">
                            <label for="interval_days">Interval Between Payments (days)</label>
                            <input type="number" class="form-control" id="interval_days" name="interval_days"
                                value="30" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Create Plan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script src="{{ asset('js/select2.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            // Initialize Select2
            $('.js-select2-custom').select2({
                placeholder: "{{ __('Select an option') }}",
                allowClear: true,
                multiple: true
            });

            // Calculate balance when payment amount changes
            $('input[name="paid"]').on('input', function() {
                const total = parseFloat($('input[name="total"]').val()) || 0;
                const paid = parseFloat($(this).val()) || 0;
                const remain = Math.max(total - paid, 0);
                $('input[name="remain"]').val(remain.toFixed(2));
            });

            // Tab functionality
            $('a[data-toggle="tab"]').on('shown.bs.tab', function(e) {
                localStorage.setItem('lastTab', $(e.target).attr('href'));
            });

            // Get last active tab from localStorage
            var lastTab = localStorage.getItem('lastTab');
            if (lastTab) {
                $('[href="' + lastTab + '"]').tab('show');
            }

            // Set max payment amount to balance
            $('#amount').attr('max', {{ $balance }});
        });
    </script>
@endsection

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
                        <input type="date" class="form-control" name="payment_date" value="{{ date('Y-m-d') }}"
                            required>
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
