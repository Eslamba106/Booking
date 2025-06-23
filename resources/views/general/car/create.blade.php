@extends('layouts.dashboard')

@section('title', 'New Car Booking')

@section('css')
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <!-- Select2 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <style>
        .input-group input.form-control {
            height: 38px;
            padding: 0 10px;
            text-align: center;
            font-weight: bold;
            border-radius: 6px;
            border: 1px solid #ced4da;
            box-shadow: none;
            transition: border-color 0.3s ease-in-out;
        }

        .input-group .btn-outline-third {
            background-color: #f8f9fa;
            border: 1px solid #ced4da;
            color: #333;
            font-size: 18px;
            font-weight: bold;
            width: 40px;
            height: 38px;
            padding: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 0;
            transition: all 0.2s ease-in-out;
        }

        .input-group .btn-outline-third:first-child {
            border-top-left-radius: 6px;
            border-bottom-left-radius: 6px;
        }

        .input-group .btn-outline-third:last-child {
            border-top-right-radius: 6px;
            border-bottom-right-radius: 6px;
        }

        .booking-card {
            border-radius: 10px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
        }

        .form-section {
            margin-bottom: 30px;
            padding-bottom: 20px;
            border-bottom: 1px solid #eee;
        }

        .form-section-title {
            color: #2c3e50;
            font-weight: 600;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
        }

        .form-section-title i {
            margin-right: 10px;
            font-size: 1.2rem;
        }

        .price-display {
            background-color: #f8f9fa;
            border-radius: 8px;
            padding: 15px;
            border-left: 4px solid #4e73df;
        }

        .total-display {
            background-color: #e8f4fd;
            border-radius: 8px;
            padding: 15px;
            border-left: 4px solid #36b9cc;
            font-weight: 600;
        }

        .btn-group-toggle .btn {
            border-radius: 0.25rem !important;
        }

        .btn-group-toggle .btn:first-child {
            border-top-right-radius: 0 !important;
            border-bottom-right-radius: 0 !important;
        }

        .btn-group-toggle .btn:last-child {
            border-top-left-radius: 0 !important;
            border-bottom-left-radius: 0 !important;
        }

        .is-invalid {
            border-color: #dc3545 !important;
        }

        .invalid-feedback {
            display: none;
            width: 100%;
            margin-top: 0.25rem;
            font-size: 80%;
            color: #dc3545;
        }

        .is-invalid~.invalid-feedback {
            display: block;
        }
    </style>
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row mb-4">
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-center">
                    <h3 class="page-title">New Car Booking</h3>
                    <a href="{{ route('car.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left mr-2"></i> Back to List
                    </a>
                </div>
            </div>
        </div>

        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="card booking-card">
                    <div class="card-header bg-primary text-white">
                        <h4 class="mb-0">Booking Details</h4>
                    </div>

                    <div class="card-body">
                        <form id="bookingForm" action="{{ route('car.store') }}" method="POST">
                            @csrf
                            <input type="hidden" name="file_id" value="{{ request('file_id') }}">
                            <!-- Customer Section -->
                            <div class="form-section">
                                <h5 class="form-section-title">
                                    <i class="fas fa-user"></i> Customer Information
                                </h5>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="customer_id">Customer <span class="text-danger">*</span></label>
                                            <select name="customer_id" id="customer_id"
                                                class="form-control select2-customer" required>
                                                <option value="">Select Customer</option>
                                                @foreach ($customers as $customer)
                                                    <option value="{{ $customer->id }}" data-phone="{{ $customer->phone }}"
                                                        data-email="{{ $customer->email }}"
                                                        {{ request('customer_id') == $customer->id ? 'selected' : '' }}>
                                                        {{ $customer->name }} ({{ $customer->phone }})
                                                    </option>
                                                @endforeach
                                            </select>
                                            <div class="invalid-feedback">Please select a customer</div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Customer Details</label>
                                            <div class="customer-details p-2 bg-light rounded">
                                                <small class="text-muted">Select a customer to view details</small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Vehicle Section -->
                            <div class="form-section">
                                <h5 class="form-section-title">
                                    <i class="fas fa-car"></i> Vehicle Information
                                </h5>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="category_id">Car Category <span class="text-danger">*</span></label>
                                            <select name="category_id" id="category_id" class="form-control" required>
                                                <option value="">Select category</option>
                                                @foreach ($categories as $category)
                                                    <option value="{{ $category->id }}" data-model="{{ $category->model }}"
                                                        data-price="{{ $category->price_per_day }}"
                                                        data-car_number="{{ $category->car_number }}">
                                                        {{ $category->category }}
                                                        ({{ number_format($category->price_per_day, 2) }} $/day)
                                                    </option>
                                                @endforeach
                                            </select>
                                            <div class="invalid-feedback">Please select a car category</div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Category details</label>
                                            <div class="category-description p-2 bg-light rounded">
                                                <div class="mb-1"><strong>Daily Rate:</strong> <span
                                                        id="daily-rate-text">0.00</span> $</div>
                                                <div class="mb-1"><strong>Model:</strong> <span id="category-model"
                                                        class="text-primary">Not selected</span></div>
                                                <div><strong>Plate Number:</strong> <span id="category-car_number"
                                                        class="text-secondary">Not selected</span></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- <input type="hidden" name="tour_id" value="1"> --}}
                            {{-- <input type="hidden" name="note" value="ok"> --}}

                            <!-- Rental Period Section -->
                            <div class="form-section">
                                <h5 class="form-section-title">
                                    <i class="far fa-calendar-alt"></i> Rental Period
                                </h5>
                                <div class="row">
                                    <!-- Pickup Date -->
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="arrival_date">Pickup Date <span class="text-danger">*</span></label>
                                            <input type="date" id="arrival_date" name="arrival_date" class="form-control"
                                                min="{{ \Carbon\Carbon::today()->toDateString() }}"
                                                onchange="validateDate()" required>
                                            <span id="arrivalDateError" style="color:red; display:none;">Pickup date cannot
                                                be in the past</span>
                                            <div class="invalid-feedback">Please select a valid pickup date</div>
                                        </div>
                                    </div>

                                    <!-- Pickup Time -->
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="arrival_time">Pickup Time <span class="text-danger">*</span></label>
                                            <input type="time" id="arrival_time" name="arrival_time" class="form-control"
                                                required>
                                            <div class="invalid-feedback">Please select a pickup time</div>
                                        </div>
                                    </div>

                                    <!-- Return Date -->
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="leave_date">Return Date <span class="text-danger">*</span></label>
                                            <input type="date" id="leave_date" name="leave_date" class="form-control"
                                                min="{{ \Carbon\Carbon::tomorrow()->toDateString() }}"
                                                onchange="validateDate()" required>
                                            <span id="leaveDateError" style="color:red; display:none;">Return date must be
                                                after pickup date</span>
                                            <div class="invalid-feedback">Please select a valid return date</div>
                                        </div>
                                    </div>

                                    <!-- Return Time -->
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="leave_time">Return Time <span class="text-danger">*</span></label>
                                            <input type="time" id="leave_time" name="leave_time" class="form-control"
                                                required>
                                            <div class="invalid-feedback">Please select a return time</div>
                                        </div>
                                    </div>

                                    <!-- Pickup Location -->
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="from_location">Pickup Location <span
                                                    class="text-danger">*</span></label>
                                            <input type="text" name="from_location" id="from_location"
                                                class="form-control" required>
                                            <div class="invalid-feedback">Please enter a pickup location</div>
                                        </div>
                                    </div>

                                    <!-- Return Location -->
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="to_location">Return Location <span
                                                    class="text-danger">*</span></label>
                                            <input type="text" name="to_location" id="to_location"
                                                class="form-control" required>
                                            <div class="invalid-feedback">Please enter a return location</div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Extra Services Section -->
                            <div class="form-section">
                                <h5 class="form-section-title">
                                    <i class="fas fa-plus-circle"></i> Extra Services
                                </h5>

                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="card">
                                            <div class="card-body">
                                                <h6 class="card-title">Tour Packages</h6>
                                                <div class="row">
                                                    @foreach ($tours as $tour)
                                                        <div class="col-md-4 mb-3">
                                                            <div class="custom-control custom-checkbox">
                                                                <input type="radio" class="custom-control-input"
                                                                    id="tour_{{ $tour->id }}" name="tour_id"
                                                                    value="{{ $tour->id }}"
                                                                    data-price="{{ $tour->price }}">
                                                                <label
                                                                    class="custom-control-label d-flex justify-content-between align-items-center"
                                                                    for="tour_{{ $tour->id }}">
                                                                    <span>{{ $tour->tour }}
                                                                        <span
                                                                            class="badge badge-primary">{{ number_format($tour->price, 2) }}
                                                                            $</span>
                                                                    </span>

                                                                </label>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>


                            <!-- Pricing Section -->
                            <div class="form-section">
                                <h5 class="form-section-title">
                                    <i class="fas fa-calculator"></i> Pricing Information
                                </h5>
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Daily Rate ($)</label>
                                            <div class="price-display">
                                                <div id="daily_rate_display" class="h5 mb-0">0.00</div>
                                                <input type="hidden" name="car_price" id="car_price">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="days_count">Rental Days <span class="text-danger">*</span></label>
                                            <div class="input-group">
                                                <input type="number" id="days_count" name="days_count"
                                                    class="form-control text-center" value="1" min="1"
                                                    required readonly>
                                            </div>
                                            <div class="invalid-feedback">Please enter valid number of days</div>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Total Amount ($)</label>
                                            <div class="total-display">
                                                <div id="total_display" class="h5 mb-0">0.00</div>
                                                <input type="hidden" name="total" id="total">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <div class="form-group w-100">
                                        <label for="note">Note <span class="text-danger">*</span></label>
                                        <textarea name="note" id="note" required rows="4"
                                            class="form-control @error('note') is-invalid @enderror" placeholder="Write your note here..."></textarea>

                                        @error('note')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <hr>

                            <div class="form-group text-right mt-4">
                                <button type="submit" class="btn btn-primary px-4">
                                    <i class="fas fa-save mr-2"></i> Save Booking
                                </button>
                                <button type="reset" class="btn btn-outline-secondary px-4 ml-2">
                                    <i class="fas fa-undo mr-2"></i> Reset
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <!-- Select2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        function validateDate() {
            const arrivalInput = document.getElementById('arrival_date');
            const leaveInput = document.getElementById('leave_date');

            const arrivalError = document.getElementById('arrivalDateError');
            const leaveError = document.getElementById('leaveDateError');

            const arrivalDate = new Date(arrivalInput.value);
            const leaveDate = new Date(leaveInput.value);

            const today = new Date();
            today.setHours(0, 0, 0, 0);

            // Reset error messages
            arrivalError.style.display = 'none';
            leaveError.style.display = 'none';

            let hasError = false;

            if (!arrivalInput.value || arrivalDate < today) {
                arrivalError.style.display = 'inline';
                hasError = true;
            }

            if (!leaveInput.value || leaveDate <= arrivalDate) {
                leaveError.style.display = 'inline';
                hasError = true;
            }

            return !hasError;
        }
    </script>

    <script>
        $(document).ready(function() {
            // Initialize elements
            initSelect2();
            setupEventHandlers();
            updateServiceFormVisibility();

            // Trigger initial calculations
            calculateTotal();

            // Trigger initial customer details update if a customer is pre-selected
            if ($('#customer_id').val()) {
                updateCustomerDetails.call($('#customer_id'));
            }
        });

        function initSelect2() {
            $('.select2-customer').select2({
                placeholder: "Select a customer",
                allowClear: true
            });
        }

        function setupEventHandlers() {
            // Customer selection
            $('#customer_id').on('change', updateCustomerDetails);

            // Vehicle selection
            $('#category_id').on('change', updateVehicleDetails);

            // Date changes
            $('#arrival_date, #leave_date').on('change', handleDateChanges);

            // Days input
            $('#days_count').on('input', calculateTotal);

            // Service toggle
            $('input[name="toggle_service"]').on('change', updateServiceFormVisibility);

            // Tour selection
            $('#tour_id').on('change', updateTourPrice);

            // Form submission
            $('#bookingForm').on('submit', validateFormBeforeSubmit);
        }

        function updateCustomerDetails() {
            const selected = $(this).find('option:selected');
            const phone = selected.data('phone');
            const email = selected.data('email');

            let details = '';
            if (phone) details += `<div><i class="fas fa-phone mr-2"></i> ${phone}</div>`;
            if (email) details += `<div><i class="fas fa-envelope mr-2"></i> ${email}</div>`;

            $('.customer-details').html(details || '<small class="text-muted">No details available</small>');
        }

        function updateVehicleDetails() {
            const selected = $(this).find('option:selected');
            const price = parseFloat(selected.data('price')) || 0;
            const model = selected.data('model') || 'Not specified';
            const carNumber = selected.data('car_number') || 'Not specified';

            // Update displays
            $('#daily-rate-text').text(price.toFixed(2));
            $('#category-model').text(model);
            $('#category-car_number').text(carNumber);
            $('#daily_rate_display').text(price.toFixed(2));
            $('#car_price').val(price);

            calculateTotal();
        }

        function handleDateChanges() {
            validateDates();
            calculateRentalDays();
        }

        function validateDates() {
            const arrival = new Date($('#arrival_date').val());
            const leave = new Date($('#leave_date').val());

            if (arrival && leave) {
                if (leave < arrival) {
                    alert('Return date must be after pickup date');
                    $('#leave_date').val('');
                    $('#days_count').val(1);
                    $('#leave_date').addClass('is-invalid');
                    return false;
                }
                $('#leave_date').removeClass('is-invalid');
            }
            return true;
        }

        function calculateRentalDays() {
            if (!validateDates()) return;

            const arrival = $('#arrival_date').val();
            const leave = $('#leave_date').val();

            if (arrival && leave) {
                const oneDay = 24 * 60 * 60 * 1000;
                const start = new Date(arrival);
                const end = new Date(leave);
                const diffDays = Math.round(Math.abs((end - start) / oneDay)) + 1;

                $('#days_count').val(diffDays).trigger('input');
            }
        }


        function calculateTotal() {
            const price = parseFloat($('#car_price').val()) || 0;
            const days = parseInt($('#days_count').val()) || 1;

            let totalTourPrice = 0;

            $('input[name="tour_id"]:checked').each(function() {
                totalTourPrice += parseFloat($(this).data('price')) || 0;
            });

            const total = (price * days) + totalTourPrice;

            $('#total_display').text(total.toFixed(2));
            $('#total').val(total.toFixed(2));
        }

        $(document).ready(function() {
            $('input[name="tour_id"]').on('change', calculateTotal);
            $('#car_price, #days_count').on('input', calculateTotal);
            calculateTotal(); // حساب مبدئي عند فتح الصفحة
        });




        function validateFormBeforeSubmit(e) {
            if (!validateForm()) {
                e.preventDefault();
            }
        }

        function validateForm() {
            let isValid = true;

            // Check required fields
            $('[required]').each(function() {
                if (!$(this).val()) {
                    $(this).addClass('is-invalid');
                    isValid = false;
                } else {
                    $(this).removeClass('is-invalid');
                }
            });

            // Additional validation
            if ($('#leave_date').val() && $('#arrival_date').val()) {
                const arrival = new Date($('#arrival_date').val());
                const leave = new Date($('#leave_date').val());

                if (leave <= arrival) {
                    $('#leave_date').addClass('is-invalid');
                    isValid = false;
                }
            }

            return isValid;
        }

        // Helper functions for days counter
        function increase(id) {
            const input = $('#' + id);
            input.val(parseInt(input.val() || 0) + 1);
            calculateTotal();
        }

        function decrease(id) {
            const input = $('#' + id);
            const min = parseInt(input.attr('min') || 0);
            if (parseInt(input.val() || 0) > min) {
                input.val(parseInt(input.val()) - 1);
            }
            calculateTotal();
        }
    </script>
@endsection
