@extends('layouts.dashboard')

@section('title', 'Edit Car Booking')

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

    .is-invalid ~ .invalid-feedback {
        display: block;
    }

    .status-badge {
        font-size: 0.8rem;
        padding: 0.35rem 0.65rem;
        border-radius: 50rem;
    }

    .status-confirmed {
        background-color: #d1e7dd;
        color: #0f5132;
    }

    .status-completed {
        background-color: #cfe2ff;
        color: #084298;
    }

    .status-cancelled {
        background-color: #f8d7da;
        color: #842029;
    }
</style>
@endsection

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <h3 class="page-title">Edit Car Booking <span class="status-badge status-{{ $car->status }}">{{ ucfirst($car->status) }}</span></h3>
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
                    <form id="bookingForm" action="{{ route('car.update', $car->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <!-- Customer Section -->
                        <div class="form-section">
                            <h5 class="form-section-title">
                                <i class="fas fa-user"></i> Customer Information
                            </h5>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="customer_id">Customer <span class="text-danger">*</span></label>
                                        <select name="customer_id" id="customer_id" class="form-control select2-customer" required>
                                            <option value="">Select Customer</option>
                                            @foreach($customers as $customer)
                                            <option value="{{ $customer->id }}"
                                                data-phone="{{ $customer->phone }}"
                                                data-email="{{ $customer->email }}"
                                                {{ $car->customer_id == $customer->id ? 'selected' : '' }}>
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
                                            @if($car->customer)
                                                <div><i class="fas fa-phone mr-2"></i> {{ $car->customer->phone }}</div>
                                                @if($car->customer->email)
                                                <div><i class="fas fa-envelope mr-2"></i> {{ $car->customer->email }}</div>
                                                @endif
                                            @else
                                                <small class="text-muted">Select a customer to view details</small>
                                            @endif
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
                                            @foreach($categories as $category)
                                                <option value="{{ $category->id }}"
                                                        data-model="{{ $category->model }}"
                                                        data-price="{{ $category->price_per_day }}"
                                                        data-car_number="{{ $category->car_number }}"
                                                        {{ $car->category_id == $category->id ? 'selected' : '' }}>
                                                    {{ $category->category }} ({{ number_format($category->price_per_day, 2) }} SAR/day)
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
                                            <div class="mb-1"><strong>Daily Rate:</strong> <span id="daily-rate-text">{{ $car->category->price_per_day ??  number_format($car->daily_rate, 2) }}</span> SAR</div>
                                            <div class="mb-1"><strong>Model:</strong> <span id="category-model" class="text-primary">{{ $car->category->model ?? 'Not selected' }}</span></div>
                                            <div><strong>Plate Number:</strong> <span id="category-car_number" class="text-secondary">{{ $car->category->car_number ?? 'Not selected' }}</span></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- <input type="hidden" name="tour_id" value="{{ $car->tour_id ?? '' }}"> --}}
                        <input type="hidden" name="note" value="{{ $car->notes ?? 'ok' }}">

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
                                              value="{{$car->arrival_date}}"   required>
                                        <div class="invalid-feedback">Please select a valid pickup date</div>
                                    </div>
                                </div>

                                <!-- Pickup Time -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="arrival_time">Pickup Time <span class="text-danger">*</span></label>
                                        <input type="time" id="arrival_time" name="arrival_time" class="form-control"
                                             value="{{$car->arrival_time}}"   required>
                                        <div class="invalid-feedback">Please select a pickup time</div>
                                    </div>
                                </div>

                                <!-- Return Date -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="leave_date">Return Date <span class="text-danger">*</span></label>
                                        <input type="date" id="leave_date" name="leave_date" class="form-control"
                                             value="{{$car->leave_date}}"   required>
                                        <div class="invalid-feedback">Please select a valid return date</div>
                                    </div>
                                </div>

                                <!-- Return Time -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="leave_time">Return Time <span class="text-danger">*</span></label>
                                        <input type="time" id="leave_time" name="leave_time" class="form-control"
                                            value="{{$car->leave_time}}"   required>
                                        <div class="invalid-feedback">Please select a return time</div>
                                    </div>
                                </div>

                                <!-- Pickup Location -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="from_location">Pickup Location <span class="text-danger">*</span></label>
                                        <input type="text" name="from_location" id="from_location" class="form-control"
                                               value="{{ $car->from_location }}" required>
                                        <div class="invalid-feedback">Please enter a pickup location</div>
                                    </div>
                                </div>

                                <!-- Return Location -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="to_location">Return Location <span class="text-danger">*</span></label>
                                        <input type="text" name="to_location" id="to_location" class="form-control"
                                               value="{{ $car->to_location }}" required>
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
                                <div class="col-12">
                                    <div class="form-group">
                                        <label class="form-label">Extra service</label><br>
                                        <div class="btn-group btn-group-toggle w-100" data-toggle="buttons">
                                            <label class="btn btn-outline-success {{ $car->tour_id ? 'active' : '' }}">
                                                <input type="radio" name="toggle_service" id="service_yes" value="yes" {{ $car->tour_id ? 'checked' : '' }}> Yes
                                            </label>
                                            <label class="btn btn-outline-danger {{ !$car->tour_id ? 'active' : '' }}">
                                                <input type="radio" name="toggle_service" id="service_no" value="no" {{ !$car->tour_id ? 'checked' : '' }}> No
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div id="serviceFormContainer" style="display: none;">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="tour_id">Tour Package</label>
                                            <select name="tour_id" id="tour_id" class="form-control">
                                            <option value="">No Services</option>  <!-- الخيار الجديد No Services -->
                                            @foreach($tours as $tour)
                                                <option value="{{ $tour->id }}" data-price="{{ $tour->price }}">
                                                    {{ $tour->tour }} ({{ number_format($tour->price, 2) }} SAR)
                                                </option>
                                            @endforeach
                                        </select>
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
                                        <label>Daily Rate (SAR)</label>
                                        <div class="price-display">
                                            <div id="daily_rate_display" class="h5 mb-0">{{ number_format($car->daily_rate, 2) }}</div>
                                            <input type="hidden" name="car_price" id="car_price" value="{{ $car->daily_rate }}">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="days_count">Rental Days <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <button type="button" class="btn btn-outline-third" onclick="decrease('days_count')">-</button>
                                            <input type="number" id="days_count" name="days_count" class="form-control text-center"
                                                   value="{{ $car->days_count }}" min="1" required>
                                            <button type="button" class="btn btn-outline-third" onclick="increase('days_count')">+</button>
                                        </div>
                                        <div class="invalid-feedback">Please enter valid number of days</div>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Total Amount (SAR)</label>
                                        <div class="total-display">
                                            <div id="total_display" class="h5 mb-0">{{ number_format($car->total_amount, 2) }}</div>
                                            <input type="hidden" name="total" id="total" value="{{ $car->total_amount }}">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Status Section -->
                        <div class="form-section">
                            <h5 class="form-section-title">
                                <i class="fas fa-info-circle"></i> Booking Status
                            </h5>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="status">Status <span class="text-danger">*</span></label>
                                        <select name="status" id="status" class="form-control" required>
                                            <option value="confirmed" {{ $car->status == 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                                            <option value="completed" {{ $car->status == 'completed' ? 'selected' : '' }}>Completed</option>
                                            <option value="cancelled" {{ $car->status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group text-right mt-4">
                            <button type="submit" class="btn btn-primary px-4">
                                <i class="fas fa-save mr-2"></i> Update Booking
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
$(document).ready(function() {
    // Initialize elements
    initSelect2();
    setupEventHandlers();
    updateServiceFormVisibility();

    // Trigger initial calculations
    calculateTotal();
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


    let servicePrice = 0;
    let tourId = $('#tour_id').val();


    if ($('#service_none').is(':checked') || tourId === "null") {
        tourId = null;
        $('#tour_id').val(null);
    }

    if ($('#service_yes').is(':checked')) {
        servicePrice = parseFloat($('#tour_id').find(':selected').data('price')) || 0;
    }

    const total = (price * days) + servicePrice;

    // Display the total
    $('#total_display').text(total.toFixed(2));
    $('#total').val(total.toFixed(2));
    $('#tour_id').val(tourId);
}

function updateServiceFormVisibility() {
    const formContainer = $('#serviceFormContainer');


    if ($('#service_yes').is(':checked')) {
        formContainer.show();
    } else {
        formContainer.hide();
        $('#tour_id').val("null");
    }
    calculateTotal();
}

function updateTourPrice() {

    calculateTotal();
}

$(document).ready(function() {

    $('input[name="toggle_service"]').on('change', function() {
        updateServiceFormVisibility();
    });


    updateServiceFormVisibility();


    $('#tour_id').on('change', function() {
        updateTourPrice();
    });
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
