@extends('layouts.dashboard')
@section('title')
    {{ __('roles.edit_booking') }}
@endsection
@section('css')
    {{-- <link href="{{ asset('css/tags-input.min.css') }}" rel="stylesheet"> --}}
    <link rel="stylesheet" href="{{ asset('css/select2.min.css') }}">

    <style>
        .select2-container--default .select2-selection--multiple .select2-selection__choice {
            background-color: #dedede;
            border: 1px solid #dedede;
            border-radius: 2px;
            color: #222;
            display: flex;
            gap: 4px;
            align-items: center;
        }
    </style>
@endsection
@section('content')
    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-5 align-self-center">
                <h4 class="page-title">{{ __('roles.edit_booking') }}</h4>
                <div class="d-flex align-items-center">

                </div>
            </div>
            <div class="col-7 align-self-center">
                <div class="d-flex no-block justify-content-end align-items-center">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="{{ route('dashboard') }}">{{ __('dashboard.home') }} </a>
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
        <!-- ============================================================== -->
        <!-- Start Page Content -->
        <!-- ============================================================== -->
        <form action="{{ route('admin.booking.update' , $booking->id) }}" method="post" enctype="multipart/form-data">
            @csrf
            @method('patch')
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="d-flex gap-2">
                                <h4 class="mb-0">{{ __('booking.booking_details') }}</h4>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6 col-lg-4 col-xl-6">
                                    <div class="form-group">
                                        <label for="">{{ __('booking.customer_name') }} <span
                                                class="text-danger">*</span></label>
                                        <select name="customer_id" class="form-control js-select2-custom ">
                                            @foreach ($customers as $customers_item)
                                                <option value="{{ $customers_item->id }}" {{ ($booking->customer_id == $customers_item->id )? 'selected' : '' }}>{{ $customers_item->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('customer_id')
                                            <span class="error text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6 col-lg-4 col-xl-3">

                                    <div class="form-group">
                                        <label for="">{{ __('booking.check_in_date') }} <span
                                                class="text-danger">*</span></label>
                                        <input type="date" id="arrival_date" onchange="calculate_earn()" value="{{ $booking->arrival_date }}" name="arrival_date" class="form-control">
                                        @error('arrival_date')
                                            <span class="error text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6 col-lg-4 col-xl-3">

                                    <div class="form-group">
                                        <label for="">{{ __('booking.check_out_date') }} <span
                                                class="text-danger">*</span></label>
                                        <input type="date" id="check_out_date" onchange="calculate_earn()"  value="{{ $booking->check_out_date }}" name="check_out_date"
                                            class="form-control">
                                        @error('check_out_date')
                                            <span class="error text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6 col-lg-4 col-xl-3">

                                    <div class="form-group">
                                        <label for="">{{ __('booking.days_count') }} </label>
                                        <input type="number" name="days_count" id="days_count" readonly
                                            class="form-control"  value="{{ $booking->days_count }}" >
                                        @error('days_count')
                                            <span class="error text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6 col-lg-4 col-xl-6">
                                    <div class="form-group">
                                        <label for="">{{ __('booking.cancellation_period') }} <span
                                                class="text-danger">*</span></label>
                                        <input type="number" name="canceled_period" value="{{ $booking->canceled_period }}" class="form-control">
                                        @error('canceled_period')
                                            <span class="error text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>


                            </div>
                        </div>

                    </div>
                    <div class="card mt-2">
                        <div class="card-header">
                            <div class="d-flex gap-2">
                                <h4 class="mb-0">{{ __('booking.guest_details') }}</h4>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6 col-lg-4 col-xl-6">
                                    <div class="form-group">
                                        <label for="">{{ __('booking.number_of_adults') }} <span
                                                class="text-danger">*</span></label>
                                        <input type="number" required id="adults_count"  value="{{ $booking->booking_details->adults_count }}"  name="adults_count" class="form-control">
                                        @error('adults_count')
                                            <span class="error text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6 col-lg-4 col-xl-6">
                                    <div class="form-group">
                                        <label for="">{{ __('booking.number_of_children') }} <span
                                                class="text-danger">*</span></label>
                                        <input type="number" id="childerns_count"  value="{{ $booking->booking_details->childerns_count }}"  name="childerns_count"
                                            class="form-control">
                                        @error('childerns_count')
                                            <span class="error text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6 col-lg-4 col-xl-6">
                                    <div class="form-group">
                                        <label for="">{{ __('booking.number_of_infants') }} <span
                                                class="text-danger">*</span></label>
                                        <input type="number" id="babes_count"  value="{{ $booking->booking_details->babes_count }}"  name="babes_count" class="form-control">
                                        @error('babes_count')
                                            <span class="error text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6 col-lg-4 col-xl-6">
                                    <div class="form-group">
                                        <label for="">{{ __('booking.total_person_count') }} <span
                                                class="text-danger">*</span></label>
                                        <input  type="number" readonly id="total_person_count"  value="{{ $booking->booking_details->total_person_count }}"  name="total_person_count"
                                            class="form-control">
                                        @error('total_person_count')
                                            <span class="error text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card mt-2">
                        <div class="card-header">
                            <div class="d-flex gap-2">
                                <h4 class="mb-0">{{ __('booking.hotel_details') }}</h4>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6 col-lg-4 col-xl-6">
                                    <div class="form-group">
                                        <label for="">{{ __('general.hotel') }} <span
                                                class="text-danger">*</span></label>
                                        <select required name="hotel_id" class="form-control js-select2-custom ">
                                            <option value="">{{ __('general.select') }}</option>
                                            @foreach ($hotels as $hotel_item)
                                                <option value="{{ $hotel_item->id }}" {{ ($hotel_item->id == $booking->hotel_id) ? 'selected' : '' }}>{{ $hotel_item->name }}</option>
                                            @endforeach
                                        </select>
                                        @error('hotel_id')
                                            <span class="error text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6 col-lg-4 col-xl-6">
                                    <div class="form-group">
                                        <label for="">{{ __('general.country') }} <span
                                                class="text-danger">*</span></label>
                                        <select name="country" disabled class="form-control js-select2-custom ">
                                            <option value="">{{ $booking->hotel->country->name }}</option>
                                        </select>
                                        @error('country')
                                            <span class="error text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6 col-lg-4 col-xl-6">
                                    <div class="form-group">
                                        <label for="">{{ __('general.city') }} </label>
                                        <input type="text" value="{{ $booking->hotel->city }}" name="city" readonly class="form-control">
                                        @error('city')
                                            <span class="error text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6 col-lg-4 col-xl-6">
                                    <div class="form-group">
                                        <label for="">{{ __('booking.booking_no') }}<span class="text-danger">
                                                *</span> </label>
                                        <input type="text" required  value="{{ $booking->booking_no }}" name="booking_no" class="form-control">
                                        @error('booking_no')
                                            <span class="error text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6 col-lg-4 col-xl-6">
                                    <div class="form-group">
                                        <label for="">{{ __('roles.all_unit_types') }} <span
                                                class="text-danger">*</span></label>
                                        <select name="unit_type_id" required class="form-control js-select2-custom ">
                                            @foreach ($unit_types as $unit_type_item)
                                                <option value="{{ $unit_type_item->id }}" {{ ($booking->booking_unit->unit_type ==$unit_type_item->id ) ? 'selected' : '' }}>{{ $unit_type_item->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('unit_type_id')
                                            <span class="error text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6 col-lg-4 col-xl-6">
                                    <div class="form-group">
                                        <label for="">{{ __('booking.food_type') }} <span
                                                class="text-danger">*</span></label>
                                        <input type="text" name="food_type" value="{{ $booking->booking_details->food_type }}" required class="form-control">

                                        @error('food_type')
                                            <span class="error text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6 col-lg-4 col-xl-6">
                                    <div class="form-group">
                                        <label for="">{{ __('booking.number_of_units') }} <span
                                                class="text-danger">*</span></label>
                                        <input type="number" name="units_count"  value="{{ $booking->booking_details->units_count }}" class="form-control">
                                        @error('units_count')
                                            <span class="error text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card mt-2">
                        <div class="card-header">
                            <div class="d-flex gap-2">
                                <h4 class="mb-0">{{ __('booking.finance_details') }}</h4>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6 col-lg-4 col-xl-6">
                                    <div class="form-group">
                                        <label for="">{{ __('booking.buy_price') }} </label>
                                        <input type="number" onkeyup="calculate_earn()"   value="{{ $booking->buy_price  }}"  name="buy_price"
                                            class="form-control">
                                        @error('buy_price')
                                            <span class="error text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6 col-lg-4 col-xl-6">
                                    <div class="form-group">
                                        <label for="">{{ __('booking.sale_price') }} </label>
                                        <input type="number" onkeyup="calculate_earn()"   value="{{ $booking->price  }}" name="price"
                                            class="form-control">
                                        @error('price')
                                            <span class="error text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6 col-lg-4 col-xl-6">
                                    <div class="form-group">
                                        <label for="">{{ __('booking.currency') }} <span
                                                class="text-danger">*</span></label>
                                        <select name="currency" class="form-control js-select2-custom ">
                                            <option value="euro"  {{ ($booking->booking_unit->currency == 'euro' ) ? 'selected' : '' }}>{{ __('booking.euro') }}</option>
                                            <option value="dolar"  {{ ($booking->booking_unit->currency == 'dolar' ) ? 'selected' : '' }}>{{ __('booking.dolar') }}</option>
                                            <option value="lira"  {{ ($booking->booking_unit->currency == 'lira' ) ? 'selected' : '' }}>{{ __('booking.lira') }}</option>
                                        </select>
                                        @error('currency')
                                            <span class="error text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6 col-lg-4 col-xl-6">
                                    <div class="form-group">
                                        <label for="">{{ __('booking.commission') }} <span
                                                class="text-danger">*</span></label>
                                        <select name="commission" id="commission"
                                            class="form-control js-select2-custom ">
                                            <option value="no" {{ ($booking->commission == 'no' ) ? 'selected' : '' }}>{{ __('booking.no') }}</option>
                                            <option value="yes" {{ ($booking->commission == 'yes' ) ? 'selected' : '' }}>{{ __('booking.yes') }}</option>
                                        </select>
                                        @error('commission')
                                            <span class="error text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6 col-lg-4 col-xl-6 commission_html">
                                    <div class="form-group">
                                        <label for="">{{ __('booking.commission_type') }} <span
                                                class="text-danger">*</span></label>
                                        <select name="commission_type" onchange="calculate_earn()" id="commission_type"
                                            class="form-control js-select2-custom ">
                                            <option value="percentage"  {{ ($booking->commission_type == 'percentage' ) ? 'selected' : '' }}>{{ __('booking.percentage') }}</option>
                                            <option value="night"  {{ ($booking->commission_type == 'night' ) ? 'selected' : '' }}>{{ __('booking.night') }}</option>
                                        </select>
                                        @error('commission_type')
                                            <span class="error text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6 col-lg-4 col-xl-6 commission_html percentage_html">
                                    <div class="form-group">
                                        <label for="">{{ __('booking.commission_percentage') }} <span
                                                class="text-danger">*</span></label>
                                        <input type="number" name="commission_percentage"  value="{{ $booking->commission_percentage }}" onkeyup="calculate_earn()"
                                            class="form-control">

                                        @error('commission_percentage')
                                            <span class="error text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6 col-lg-4 col-xl-6 commission_html night_html">
                                    <div class="form-group">
                                        <label for="">{{ __('booking.days_count') }} <span
                                                class="text-danger">*</span></label>
                                        <input type="number" name="commission_night" value="{{ $booking->commission_night }}" onkeyup="calculate_earn()"
                                            class="form-control">

                                        @error('commission_night')
                                            <span class="error text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6 col-lg-4 col-xl-6">
                                    <div class="form-group">
                                        <label for="">{{ __('booking.broker') }} <span
                                                class="text-danger">*</span></label>
                                        <select name="broker" id="has_broker" class="form-control js-select2-custom ">
                                            <option value="no" {{ ($booking->commission_type == 'no' ) ? 'selected' : '' }}>{{ __('booking.no') }}</option>
                                            <option value="yes" {{ ($booking->commission_type == 'yes' ) ? 'selected' : '' }}>{{ __('booking.yes') }}</option>
                                        </select>
                                        @error('broker')
                                            <span class="error text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6 col-lg-4 col-xl-6 broker_html">
                                    <div class="form-group">
                                        <label for="">{{ __('booking.broker_name') }} <span
                                                class="text-danger">*</span></label>
                                        <select name="broker" class="form-control js-select2-custom ">
                                            @foreach ($brokers as $broker_item)
                                                <option value="{{ $broker_item->id }}" {{ ($booking->broker == $broker_item->id ) ? 'selected' : '' }}>{{ $broker_item->name }}</option>
                                            @endforeach
                                        </select>
                                        @error('broker')
                                            <span class="error text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6 col-lg-4 col-xl-6 broker_html">
                                    <div class="form-group">
                                        <label for="">{{ __('booking.broker_amount') }} </label>
                                        <input type="number" name="broker_amount"  value="{{ $booking->commission_night }}"  class="form-control"
                                            onkeyup="calculate_earn()">
                                        @error('broker_amount')
                                            <span class="error text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                 <div class="col-12">
                        <div class="form-group">
                        <label class="form-label">{{ __('Extra service') }}</label><br>





                                <div class="3">
                                    <div class="form-group">
                                        <label for="clientName">{{ __('roles.name') }} <span class="text-danger">*</span></label>
                                        <input type="text" name="name" class="form-control" id="clientName" style="text-transform:uppercase;" />
                                        @error('name')
                                            <span class="error text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>


                                <div class="form-group">
                                    <label>{{ __('Price') }} <span class="text-danger">*</span></label>
                                    <input type="number" name="service_price" class="form-control" id="price" />
                                    @error('price') <span class="error text-danger">{{ $message }}</span> @enderror
                                </div>

                                <div class="form-group">
                                    <label>{{ __('Quantity') }} <span class="text-danger">*</span></label>
                                    <input type="number" name="qyt" class="form-control" id="qty" />
                                    @error('qty') <span class="error text-danger">{{ $message }}</span> @enderror
                                </div>

                                <div class="form-group">
                                    <label>{{ __('Services Price') }}</label>
                                    <input type="number" name="total_price" class="form-control" id="total_price" readonly />
                                    @error('total') <span class="error text-danger">{{ $message }}</span> @enderror
                                </div>

                            </div>



                        </div>
                                <div class="col-md-6 col-lg-4 col-xl-6">
                                    <div class="form-group">
                                        <label for="">{{ __('booking.earn') }} </label>
                                        <input type="number" name="earn" class="form-control"  value="{{ $booking->earned }}"  readonly>
                                        @error('earn')
                                            <span class="error text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6 col-lg-4 col-xl-6">
                                    <div class="form-group">
                                        <label for="">{{ __('booking.total') }} </label>
                                        <input type="number" readonly name="total" value="{{ $booking->total }}"  class="form-control">
                                        @error('total')
                                            <span class="error text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-group mt-2"
                style="text-align: {{ Session::get('locale') == 'en' ? 'right;margin-right:10px' : 'left;margin-left:10px' }}">
                <button type="submit" class="btn btn-primary mt-2">{{ __('dashboard.save') }}</button>
            </div>
        </form>
    </div>
@endsection
@section('js')
    <script src="{{ asset('js/select2.min.js') }}"></script>
    <script>
        function calculate_earn() {
            var buyPrice = parseFloat($('input[name="buy_price"]').val()) || 0;
            var salePrice = parseFloat($('input[name="price"]').val()) || 0;
            var night_count = parseFloat($('input[name="days_count"]').val()) || 0;
            var commission_percentage = parseFloat($('input[name="commission_percentage"]').val()) || 0;
            var commission_night = parseFloat($('input[name="commission_night"]').val()) || 0;
            var broker_amount = parseFloat($('input[name="broker_amount"]').val()) || 0;
            var commission_type = $('#commission_type').val();
            if (commission_type === 'percentage') {
                var commission = (buyPrice * commission_percentage) / 100;
                var earn = ((salePrice - (buyPrice - commission) ) * night_count);
                var total = (salePrice * night_count) + broker_amount;
            } else if (commission_type == 'night') {
                var commission = commission_night;
                var earn = ((salePrice - (buyPrice - commission) ) * night_count)
                var total = (salePrice * night_count) + broker_amount;
            } else {
                var commission = 0;
            }

            $('input[name="total"]').empty();
            $('input[name="earn"]').empty();
            $('input[name="total"]').val(total.toFixed(2));
            $('input[name="earn"]').val(earn.toFixed(2));
        }
        $(document).ready(function() {
            $('input[name="buy_price"], input[name="price"]').on('keyup change', function() {
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
        function calculateTotalPersons() {
            const adults = parseInt($('#adults_count').val()) || 0;
            const children = parseInt($('#childerns_count').val()) || 0;
            const babies = parseInt($('#babes_count').val()) || 0;

            const total = adults + children + babies;
            $('#total_person_count').val(total);
        }

        $('#adults_count, #childerns_count, #babes_count').on('input', calculateTotalPersons);
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
                            $('select[name="country"]').append('<option value="' + response.country.id +
                                '">' + response.country.name + '</option>');
                        },
                        error: function(xhr, status, error) {
                            console.error("Error occurred:", error);

                        }
                    });
                }
            });
        })
    </script>
@endsection
