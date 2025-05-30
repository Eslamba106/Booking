@extends('layouts.dashboard')

@section('title')
    {{ __('roles.create_booking') }}
@endsection

@section('css')
    <link rel="stylesheet" href="{{ asset('css/select2.min.css') }}">
    <!-- Link to Bootstrap 5 CSS -->
    {{-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KyZXEJzQd5R2E4v6l3mY7E3B1s6cS2rC0vN1OiwVwC0Fjz5Vc6T9Frr2bWvnm+2T" crossorigin="anonymous"> --}}

    <!-- Link to Bootstrap 5 JS (Optional, for JavaScript components) -->
    {{-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-pzjw8f+ua7Kw1TIq0hXr8rxzNkdyh0I7l2zH2Lz7g/ti1Hpc5OgPUb5fX38pkhB4" crossorigin="anonymous"></script> --}}

    <style>
        /* .select2-container--default .select2-selection--multiple .select2-selection__choice {
                                    background-color: #dedede;
                                    border: 1px solid #dedede;
                                    border-radius: 2px;
                                    color: #222;
                                    display: flex;
                                    gap: 4px;
                                    align-items: center;
                                } */
        .d-flex {
            display: flex;
        }

        .align-items-end {
            align-items: flex-end;
        }

        .gap-3 {
            gap: 1rem;
        }

        .card-body {
            padding: 10px;
        }

        .form-group {
            margin-bottom: 1rem;
        }


        .step {
            display: none;
            animation: fadeIn 0.3s ease-in-out;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
            }

            to {
                opacity: 1;
            }
        }

        /* Currency Toggle Container */
        .currency-toggle .btn-check:checked+.btn {
            background-color: #0d6efd;
            color: #fff;
            border-color: #0d6efd;
        }

        .currency-toggle .btn {
            border-radius: 30px;
            padding: 6px 16px;
            margin: 0 4px 8px 0;
            transition: all 0.3s ease;
        }

        .currency-toggle {
            display: flex;
            flex-wrap: wrap;
            gap: 5px;
        }

        input[name="days_count"],
        input[name="canceled_period"] {
            border: 1px solid #ced4da;
            border-radius: 0.375rem !important;
            /* أو استخدم 0.25rem حسب الشكل العام */
        }

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
            /* نفس ارتفاع input */
            padding: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 0;
            /* بدون زوايا لو داخل input-group */
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

        .input-group input.form-control {
            height: 38px;
            padding: 0;
            text-align: center;
            border-radius: 0;
            border-left: 0;
            border-right: 0;
            font-weight: bold;
        }

        /* Form Container */


        /* Form Group */
        .form-group {
            margin-bottom: 20px;
        }

        /* Label */
        .form-group label {
            font-weight: 600;
            margin-bottom: 6px;
            display: block;
            color: #333;
        }

        /* Input & Select */
        .form-control {
            border: 1px solid #ccc;
            border-radius: 6px;
            padding: 10px 12px;
            width: 100%;
            font-size: 14px;
            transition: border 0.3s;
        }

        .form-control:focus {
            border-color: #007bff;
            outline: none;
        }

        /* Radio Toggle Buttons */
        .btn-group-toggle {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
        }

        .btn-check {
            display: none;
        }

        .btn-outline-primary,
        .btn-outline-secondary,
        .btn-outline-info {
            padding: 10px 20px;
            border-radius: 6px;
            border: 2px solid #ccc;
            background-color: #f1f1f1;
            cursor: pointer;
            transition: all 0.3s ease;
            font-weight: 500;
        }

        .btn-outline-primary:hover,
        .btn-outline-secondary:hover,
        .btn-outline-info:hover {
            background-color: #e9ecef;
        }

        .btn-check:checked+.btn-outline-primary {
            background-color: #007bff;
            color: white;
            border-color: #007bff;
        }

        .btn-check:checked+.btn-outline-secondary {
            background-color: #6c757d;
            color: white;
            border-color: #6c757d;
        }

        .btn-check:checked+.btn-outline-info {
            background-color: #17a2b8;
            color: white;
            border-color: #17a2b8;
        }

        /* Error Text */
        .text-danger {
            color: #dc3545;
            font-size: 12px;
        }

        /* Section spacing */
        .card-body .row>div {
            margin-bottom: 20px;
        }
    </style>
@endsection

@section('content')
    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-5 align-self-center">
                <h4 class="page-title">{{ __('roles.create_booking') }}</h4>
            </div>
            <div class="col-7 align-self-center">
                <div class="d-flex no-block justify-content-end align-items-center">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="{{ route('dashboard') }}">{{ __('dashboard.home') }}</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">{{ __('dashboard.dashboard') }}</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>

    <div class="mb-5"></div>

    <div class="container-fluid">
        <form action="{{ route('admin.booking.store') }}" method="post" enctype="multipart/form-data">
            @csrf

            <div class="row">
                <div class="col-12">
                    <div class="card">

                        <input type="hidden" name="file_id" value="{{ request('file_id') }}">

                        <div class="card-body" id="form-steps">
                            <div class="step">@include('general.booking.customer_details')</div>
                            <div class="step">@include('general.booking.hotel_details')</div>
                            <div class="step">@include('general.booking.finance_details')</div>
                        </div>

                        <div class="card-footer d-flex justify-content-between">

                            <div>
                                <button type="button" id="prevBtn" class="btn btn-secondary"
                                    onclick="nextPrev(-1)">Previous</button>
                            </div>

                            <div>
                                <button type="button" id="nextBtn" class="btn btn-primary"
                                    onclick="nextPrev(1)">Next</button>
                                <button type="submit" id="submitBtn"
                                    class="btn btn-success d-none">{{ __('dashboard.save') }}</button>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </form>
    </div>







    <div class="modal fade" id="add_tenant" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">{{ __('roles.create_customer') }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="card-body">
                        <form action="{{ route('admin.customer.store_for_any') }}" method="post"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-12">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="row">

                                                <div class="col-md-6 col-lg-4 col-xl-6">

                                                    <div class="form-group">
                                                        <label for="">{{ __('roles.name') }} <span
                                                                class="text-danger">*</span></label>
                                                        <input type="text" name="name" class="form-control"
                                                            id="clientName" oninput="validateName(this)"
                                                            style="text-transform:uppercase;" />

                                                        @error('name')
                                                            <span class="error text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-md-6 col-lg-4 col-xl-6">
                                                    <div class="form-group">
                                                        <label for="">{{ __('roles.email') }} </label>
                                                        <input type="text" name="email" class="form-control">
                                                        @error('email')
                                                            <span class="error text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>

                                                <div class="col-md-6 col-lg-4 col-xl-6">
                                                    <div class="form-group">
                                                        <label for="">{{ __('login.phone') }}<span
                                                                class="text-danger">*</span></label>

                                                        <input id="phone" name="phone" type="tel"
                                                            class="form-control" value="+"
                                                            oninput="keepPlusSign(this)">
                                                        @error('phone')
                                                            <span class="error text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-md-6 col-lg-4 col-xl-6">
                                                    <div class="form-group">
                                                        <label for="">{{ __('general.nationality') }} <span
                                                                class="text-danger">*</span></label>
                                                        <select name="nationality_id"
                                                            class="form-control js-select2-custom"
                                                            data-placeholder="{{ __('general.select') }}">
                                                            <option value="">{{ __('general.select') }}</option>
                                                            @foreach ($countries as $item)
                                                                <option value="{{ $item->id }}">{{ $item->name }}
                                                                </option>
                                                            @endforeach
                                                        </select>


                                                        @error('nationality_id')
                                                            <span class="error text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group mt-2"
                                                style="text-align: {{ Session::get('locale') == 'en' ? 'right;margin-right:10px' : 'left;margin-left:10px' }}">
                                                <button type="submit"
                                                    class="btn btn-primary mt-2">{{ __('dashboard.save') }}</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="add_meal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog " role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">{{ __('roles.create_customer') }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="card-body">
                        <form action="{{ route('admin.meal.store_any') }}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-12">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="row">



                                                <div class="form-group m-2">
                                                    <label for="">{{ __('Name of meal') }} <span
                                                            class="text-danger">*</span></label>
                                                    <input type="text" name="name" class="form-control">
                                                    @error('name')
                                                        <span class="error text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>

                                        </div>

                                        <div class="form-group mt-2"
                                            style="text-align: {{ Session::get('locale') == 'en' ? 'right;margin-right:10px' : 'left;margin-left:10px' }}">
                                            <button type="submit"
                                                class="btn btn-primary mt-2">{{ __('dashboard.save') }}</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="add_cancel" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">{{ __('create cancellation') }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="card-body">
                        <form action="{{ route('admin.cancel.store_any') }}" method="post"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-12">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="row">

                                                <div class="form-group m-3">
                                                    <label for="">{{ __('Period') }} <span
                                                            class="text-danger">*</span></label>
                                                    <input type="text" name="period" class="form-control">
                                                    @error('name')
                                                        <span class="error text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>

                                        </div>

                                        <div class="form-group mt-2"
                                            style="text-align: {{ Session::get('locale') == 'en' ? 'right;margin-right:10px' : 'left;margin-left:10px' }}">
                                            <button type="submit"
                                                class="btn btn-primary mt-2">{{ __('dashboard.save') }}</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    </div>
    <div class="modal fade" id="add_hotel" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">{{ __('roles.create_hotel') }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="card-body">
                        <form action="{{ route('admin.hotel.store_for_any') }}" method="post"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-12">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="row">

                                                <div class="col-md-6 col-lg-4 col-xl-6">

                                                    <div class="form-group">
                                                        <label for="">{{ __('roles.name') }} <span
                                                                class="text-danger">*</span></label>
                                                        <input type="text" name="name" class="form-control">
                                                        @error('name')
                                                            <span class="error text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-md-6 col-lg-4 col-xl-6">
                                                    <div class="form-group">
                                                        <label for="">{{ __('general.hotel_type') }} <span
                                                                class="text-danger">*</span></label>
                                                        <select name="hotel_type" class="form-control js-select2-custom ">
                                                            <option value="Hotel">Hotel</option>
                                                            <option value="Villa">Villa</option>
                                                            <option value="Bungalov">Bungalov</option>
                                                            <option value="Hotel Apartments Resort">Hotel Apartments Resort
                                                            </option>
                                                        </select>
                                                        @error('hotel_type')
                                                            <span class="error text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-md-6 col-lg-4 col-xl-6">
                                                    <div class="form-group">
                                                        <label for="">{{ __('general.hotel_rate') }} </label>
                                                        <select name="hotel_rate" class="form-control js-select2-custom">
                                                            <option value="1"> ⭐</option>
                                                            <option value="2"> ⭐⭐</option>
                                                            <option value="3"> ⭐⭐⭐</option>
                                                            <option value="4"> ⭐⭐⭐⭐</option>
                                                            <option value="5"> ⭐⭐⭐⭐⭐</option>
                                                        </select>
                                                        @error('hotel_rate')
                                                            <span class="error text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>

                                                <div class="col-md-6 col-lg-4 col-xl-6">
                                                    <div class="form-group">
                                                        <label for="">{{ __('general.country') }} <span
                                                                class="text-danger">*</span></label>
                                                        <select name="country_id" class="form-control js-select2-custom"
                                                            id="country_select">
                                                            <option value="">{{ __('select country') }}</option>
                                                            @foreach ($countries as $countries_item)
                                                                <option value="{{ $countries_item->id }}">
                                                                    {{ $countries_item->name }}</option>
                                                            @endforeach
                                                        </select>
                                                        @error('country_id')
                                                            <span class="error text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-md-6 col-lg-4 col-xl-6">
                                                    <div class="form-group">
                                                        <label for="">{{ __('general.city') }} <span
                                                                class="text-danger">*</span></label>
                                                        <select name="city" class="form-control" id="city_select">
                                                            <option value="">{{ __('select city') }}</option>
                                                        </select>
                                                        @error('city')
                                                            <span class="error text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-md-6 col-lg-4 col-xl-6">
                                                    <div class="form-group">
                                                        <label for="">{{ __('roles.all_unit_types') }} <span
                                                                class="text-danger">*</span></label>
                                                        <select name="unit_type_ids[]"
                                                            class="form-control js-select2-custom " multiple>
                                                            <option disabled selected hidden>
                                                                {{ __('general.select_unit_type') }}</option>
                                                            @foreach ($unit_types as $unit_types_item)
                                                                <option value="{{ $unit_types_item->id }}">
                                                                    {{ $unit_types_item->name }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                        @error('unit_type_id')
                                                            <span class="error text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group mt-2"
                                                style="text-align: {{ Session::get('locale') == 'en' ? 'right;margin-right:10px' : 'left;margin-left:10px' }}">
                                                <button type="submit"
                                                    class="btn btn-primary mt-2">{{ __('dashboard.save') }}</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('js')
    <script src="{{ asset('js/select2.min.js') }}"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            let currentStep = 0;
            const steps = document.querySelectorAll('.step');

            function showStep(n) {
                steps.forEach((step, i) => step.style.display = i === n ? 'block' : 'none');
                document.getElementById('prevBtn').style.display = n === 0 ? 'none' : 'inline-block';
                document.getElementById('nextBtn').style.display = n === steps.length - 1 ? 'none' : 'inline-block';
                document.getElementById('submitBtn').classList.toggle('d-none', n !== steps.length - 1);
            }

            function validateStep() {
                const inputs = steps[currentStep].querySelectorAll('input, select, textarea');
                let valid = true;
                inputs.forEach(input => {
                    if (!input.checkValidity()) {
                        input.classList.add('is-invalid');
                        valid = false;
                    } else {
                        input.classList.remove('is-invalid');
                    }
                });
                return valid;
            }

            window.nextPrev = function(n) {
                if (n === 1 && !validateStep()) return;
                currentStep += n;
                showStep(currentStep);
            }

            showStep(currentStep);
        });
    </script>
    <script>
        function calculateServiceTotal() {
            const service_price = parseFloat($('#price').val()) || 0;
            const qty = parseFloat($('#qty').val()) || 0;
            const total_price = service_price * qty;
            $('#total_price').val(total_price.toFixed(2));
            return total_price;
        }

        function calculate_earn() {
            const buyPrice = parseFloat($('input[name="buy_price"]').val()) || 0;
            const salePrice = parseFloat($('input[name="price"]').val()) || 0;
            const night_count = parseFloat($('input[name="days_count"]').val()) || 1;
            const commission_percentage = parseFloat($('input[name="commission_percentage"]').val()) || 0;
            const commission_night = parseFloat($('input[name="commission_night"]').val()) || 0;
            const broker_amount = parseFloat($('input[name="broker_amount"]').val()) || 0;
            const units_count = parseFloat($('input[name="units_count"]').val()) || 0;
            const commission_type = $('#commission_type').val();

            const totalBookingPrice = salePrice * night_count * units_count;
            const totalBuyPrice = buyPrice * night_count * units_count;
            const extraServiceTotal = calculateServiceTotal();

            let broker = 0;
            if ($('#broker_yes').is(':checked')) {
                broker = broker_amount * units_count * night_count;
            }
            let commission = 0;
            if ($('#commission_yes').is(':checked')) {
                if (commission_type === 'percentage') {
                    commission = (buyPrice * commission_percentage / 100) * night_count * units_count;
                } else if (commission_type === 'night') {
                    commission = commission_night * night_count * units_count;
                }
            }

            const hotelTotalCost = totalBuyPrice - commission + broker;
            const earn = (totalBookingPrice + extraServiceTotal) - hotelTotalCost;

            const revenuePerRoom = salePrice - buyPrice;

            // تعبئة الحقول
            $('input[name="revenue_per_room"]').val(revenuePerRoom.toFixed(2));
            $('input[name="hotel_total_cost"]').val(hotelTotalCost.toFixed(2));
            $('input[name="total"]').val((totalBookingPrice + extraServiceTotal).toFixed(2));
            $('input[name="earn"]').val(earn.toFixed(2));
            $('input[name="total_commission"]').val(commission.toFixed(2));
            $('input[name="total_broker_commission"]').val(broker.toFixed(2));
        }


        function toggleCommissionFields() {
            const type = $('#commission_type').val();
            if (type === 'percentage') {
                $('.percentage_html').show();
                $('.night_html').hide();
            } else if (type === 'night') {
                $('.percentage_html').hide();
                $('.night_html').show();
            } else {
                $('.percentage_html, .night_html').hide();
            }
        }

        function toggleServiceFields() {
            const toggle = $('input[name="toggle_service"]:checked').val();
            if (toggle === 'yes') {
                $('#serviceFormContainer').show();
            } else {
                $('#serviceFormContainer').hide();
                $('#total_price').val('0');
            }
        }

        $(document).ready(function() {
            toggleCommissionFields();
            toggleServiceFields();
            calculate_earn();

            $('input[name="buy_price"], input[name="price"], input[name="days_count"], input[name="commission_percentage"], input[name="commission_night"], input[name="broker_amount"], #price, #qty')
                .on('keyup change', function() {
                    calculate_earn();
                });

            $('#commission_type').on('change', function() {
                toggleCommissionFields();
                calculate_earn();
            });

            $('input[name="toggle_service"]').on('change', function() {
                toggleServiceFields();
                calculate_earn();
            });

            $('input[name="commission"]').on('change', function() {
                calculate_earn();
            });

            $('input[name="broker"]').on('change', function() {
                calculate_earn();
            });
        });
    </script>



    <script>
        function calculateNights() {
            const checkIn = new Date($('#arrival_date').val());
            const checkOut = new Date($('#check_out_date').val());

            if (!isNaN(checkIn) && !isNaN(checkOut) && checkOut > checkIn) {
                const diffTime = Math.abs(checkOut - checkIn);
                const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));
                $('#days_count').val(diffDays);
            } else {
                $('#days_count').val('');
            }
        }

        $('#arrival_date, #check_out_date').on('change', calculateNights);
    </script>
    <script>
        function updateTotal() {
            const adults = parseInt(document.getElementById("adults_count").value) || 0;
            const children = parseInt(document.getElementById("childerns_count").value) || 0;
            const infants = parseInt(document.getElementById("babes_count").value) || 0;
            const total = adults + children + infants;
            document.getElementById("total_person_count").value = total;
        }

        function increase(id) {
            const input = document.getElementById(id);
            input.value = parseInt(input.value || 0) + 1;
            updateTotal();
        }

        function decrease(id) {
            const input = document.getElementById(id);
            const min = parseInt(input.min || 0);
            if (parseInt(input.value || 0) > min) {
                input.value = parseInt(input.value) - 1;
            }
            updateTotal();
        }

        document.addEventListener('DOMContentLoaded', function() {
            updateTotal();
            ["adults_count", "childerns_count", "babes_count"].forEach(id => {
                document.getElementById(id).addEventListener("input", updateTotal);
            });
        });
    </script>



    <script>
        function toggleCommissionFields() {
            let commission = $('#commission').val();
            let type = $('#commission_type').val();

            if (commission === 'yes') {
                $('.commission_html').show();
            } else {
                $('.commission_html').hide();
                $('.percentage_html').hide();
                $('.night_html').hide();
            }

            if (type === 'percentage') {
                $('.percentage_html').show();
                $('.night_html').hide();
            } else if (type === 'night') {
                $('.night_html').show();
                $('.percentage_html').hide();
            } else {
                $('.percentage_html, .night_html').hide();
            }
        }

        $(document).ready(function() {
            $('.commission_html, .percentage_html, .night_html').hide();
            $('#commission, #commission_type').on('change', toggleCommissionFields);
        });
    </script>
    <script>
        $(document).ready(function() {
            $('.broker_html').hide();
            $('#has_broker').on('change', function() {
                if ($(this).val() === 'yes') {
                    $('.broker_html').show();
                } else {
                    $('.broker_html').hide();
                }
            });
        });
    </script>

    <script>
        $(document).ready(function() {
            $('select[name=hotel_id]').on('change', function() {
                var hotel_id = $(this).val();
                if (hotel_id) {
                    $.ajax({
                        url: "{{ route('booking.get_country', ':id') }}".replace(':id', hotel_id),
                        type: "GET",
                        data: {
                            _token: "{{ csrf_token() }}"
                        },
                        dataType: "json",
                        success: function(response) {
                            $('select[name="country"]').empty();
                            $('input[name="city"]').empty();
                            // console.log(response.city);
                            $('input[name="city"]').val(response.city);
                            $('select[name="country"]').append('<option value="' + response
                                .country.id +
                                '">' + response.country.name + '</option>');
                        },
                        error: function(xhr, status, error) {
                            console.error("Error occurred:", error);

                        }
                    });
                }
            });
        })
        document.addEventListener('DOMContentLoaded', function() {
            const input = document.querySelector("#phone");

            const iti = window.intlTelInput(input, {
                nationalMode: false,
                autoHideDialCode: false,
                separateDialCode: false,
                utilsScript: "{{ asset('intel/js/utils.js') }}" // تأكد من المسار الصحيح
            });

            // تحديث العلم يدويًا عند كتابة كود الدولة
            input.addEventListener('input', function() {
                const val = input.value;
                const countryData = window.intlTelInputGlobals.getCountryData();

                for (let i = 0; i < countryData.length; i++) {
                    const code = '+' + countryData[i].dialCode;
                    if (val.startsWith(code)) {
                        iti.setCountry(countryData[i].iso2);
                        break;
                    }
                }
            });
        });

        function keepPlusSign(input) {
            if (!input.value.startsWith("+")) {
                input.value = "+" + input.value.replace(/[^0-9]/g, '');
            }
        }

        function validateDate() {
            const arrivalInput = document.getElementById('arrival_date');
            const checkoutInput = document.getElementById('check_out_date');

            const arrivalError = document.getElementById('arrivalDateError');
            const checkoutError = document.getElementById('checkoutDateError');

            const arrivalDate = new Date(arrivalInput.value);
            const checkoutDate = new Date(checkoutInput.value);

            const today = new Date();
            today.setHours(0, 0, 0, 0);

            // إخفاء الأخطاء أولاً
            arrivalError.style.display = 'none';
            checkoutError.style.display = 'none';

            let hasError = false;

            // التحقق من تاريخ الوصول
            if (!arrivalInput.value || arrivalDate < today) {
                arrivalError.style.display = 'inline';
                hasError = true;
            }

            // التحقق من تاريخ المغادرة
            if (!checkoutInput.value || checkoutDate <= arrivalDate) {
                checkoutError.style.display = 'inline';
                hasError = true;
            }

            return !hasError;
        }
    </script>
    <script>
        $(document).ready(function() {
            $('#country_select').on('change', function() {
                var countryId = $(this).val();
                if (countryId) {
                    $.ajax({
                        url: '/get-cities/' + countryId,
                        type: 'GET',
                        dataType: 'json',
                        success: function(data) {
                            $('#city_select').empty().append(
                                '<option value="">{{ __('select city') }}</option>');
                            $.each(data, function(key, value) {
                                $('#city_select').append('<option value="' + value
                                    .name + '">' + value.name + '</option>');
                            });
                        }
                    });
                } else {
                    $('#city_select').empty().append('<option value="">{{ __('select city') }}</option>');
                }
            });
        });
    </script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // إظهار أو إخفاء حقول العمولة بناءً على اختيار نعم أو لا
            document.querySelectorAll('input[name="commission"]').forEach(el => {
                el.addEventListener("change", function() {
                    const isYes = this.value === 'yes';
                    document.querySelectorAll('.commission_html').forEach(div => {
                        div.style.display = isYes ? 'block' : 'none';
                    });

                    // استدعاء دالة لتحديث الحقول الخاصة بنوع العمولة
                    toggleCommissionFields();
                });
            });

            // إظهار أو إخفاء حقول الوسيط بناءً على اختيار نعم أو لا
            document.querySelectorAll('input[name="broker"]').forEach(el => {
                el.addEventListener("change", function() {
                    const isYes = this.value === 'yes';
                    document.querySelectorAll('.broker_html').forEach(div => {
                        div.style.display = isYes ? 'block' : 'none';
                    });
                });
            });

            // تفعيل الحالة الافتراضية
            document.querySelector('input[name="commission"]:checked')?.dispatchEvent(new Event('change'));
            document.querySelector('input[name="broker"]:checked')?.dispatchEvent(new Event('change'));
        });

        // دالة لتبديل الحقول بناءً على نوع العمولة (نسبة أو ليالي)
        function toggleCommissionFields() {
            var commission = document.querySelector('input[name="commission"]:checked').value;
            var commissionType = document.getElementById('commission_type').value;

            // Show or hide the commission fields based on "Yes" selection
            if (commission === "yes") {
                document.querySelector('.commission_html').style.display = 'block';

                // Show specific fields based on commission type
                if (commissionType === "percentage") {
                    document.querySelector('.percentage_html').style.display = 'block';
                    document.querySelector('.night_html').style.display = 'none';
                } else {
                    document.querySelector('.night_html').style.display = 'block';
                    document.querySelector('.percentage_html').style.display = 'none';
                }
            } else {
                document.querySelector('.commission_html').style.display = 'none';
                document.querySelector('.percentage_html').style.display = 'none';
                document.querySelector('.night_html').style.display = 'none';
            }
        }

        // Call the function on load to set the initial state
        toggleCommissionFields();
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            function checkCurrencyMatch() {
                const buyCurrency = document.querySelector('input[name="buy_currency"]:checked').value;
                const sellCurrency = document.querySelector('input[name="currency"]:checked').value;
                const errorBox = document.getElementById('currency-error');

                if (buyCurrency !== sellCurrency) {
                    errorBox.classList.remove('d-none');
                } else {
                    errorBox.classList.add('d-none');
                }
            }

            // Add event listeners to all currency radios
            document.querySelectorAll('input[name="buy_currency"], input[name="currency"]').forEach(radio => {
                radio.addEventListener('change', checkCurrencyMatch);
            });

            // تشغيل أولي عند تحميل الصفحة
            checkCurrencyMatch();
        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const priceInput = document.getElementById('price');
            const qtyInput = document.getElementById('qty');
            const totalInput = document.getElementById('total_price');

            function updateTotal() {
                const price = parseFloat(priceInput.value) || 0;
                const qty = parseFloat(qtyInput.value) || 0;
                totalInput.value = (price * qty).toFixed(2); // رقم عشري من خانتين
            }

            priceInput.addEventListener('input', updateTotal);
            qtyInput.addEventListener('input', updateTotal);
        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const yesBtn = document.getElementById('service_yes');
            const noBtn = document.getElementById('service_no');
            const formContainer = document.getElementById('serviceFormContainer');

            if (yesBtn && noBtn && formContainer) {
                // عرض النموذج إذا كان "نعم" محددة
                if (yesBtn.checked) {
                    formContainer.style.display = 'block';
                } else if (noBtn.checked) {
                    formContainer.style.display = 'none';
                }

                // استمع لتغيير القيمة
                yesBtn.addEventListener('change', function() {
                    if (this.checked) {
                        formContainer.style.display = 'block';
                    }
                });

                noBtn.addEventListener('change', function() {
                    if (this.checked) {
                        formContainer.style.display = 'none';
                    }
                });
            }
        });
    </script>

    <script>
        function initializeSelect2(context = document) {
            $(context).find('.js-select2-custom').each(function() {
                const $select = $(this);

                if ($select.hasClass("select2-hidden-accessible")) {
                    $select.select2('destroy');
                }

                $select.select2({
                    dropdownParent: $select.closest('.modal').length ? $select.closest('.modal') : $(
                        'body'),
                    width: '100%',
                    placeholder: $select.data('placeholder') || '{{ __('general.select') }}',
                    allowClear: true
                });
            });
        }

        $(document).ready(function() {
            initializeSelect2();

            // عند فتح أي مودال
            $('.modal').on('shown.bs.modal', function() {
                initializeSelect2(this);
            });
        });
    </script>
@endsection
