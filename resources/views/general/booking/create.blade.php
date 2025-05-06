@extends('layouts.dashboard')
@section('title')
    {{ __('roles.create_booking') }}
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
                <h4 class="page-title">{{ __('roles.create_booking') }}</h4>
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
        <form action="{{ route('admin.booking.store') }}" method="post" enctype="multipart/form-data">
            @csrf
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
                                        <label for="">{{ __('booking.customer_name') }} <button type="button"
                                                data-target="#add_tenant" data-add_tenant="" data-toggle="modal"
                                                class="btn btn--primary btn-sm">
                                                <i class="fa fa-plus-square"></i>
                                            </button> <span class="text-danger">*</span> </label>
                                        <select name="customer_id" class="form-control js-select2-custom ">
                                            @foreach ($customers as $customers_item)
                                                <option value="{{ $customers_item->id }}">{{ $customers_item->name }}
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
                                        <input type="date" id="arrival_date" name="arrival_date" onchange="calculate_earn()" class="form-control">
                                        @error('arrival_date')
                                            <span class="error text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6 col-lg-4 col-xl-3">

                                    <div class="form-group">
                                        <label for="">{{ __('booking.check_out_date') }} <span
                                                class="text-danger">*</span></label>
                                        <input type="date" id="check_out_date" onchange="calculate_earn()" name="check_out_date"
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
                                            class="form-control">
                                        @error('days_count')
                                            <span class="error text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6 col-lg-4 col-xl-6">
                                    <div class="form-group">
                                        <label for="">{{ __('booking.cancellation_period') }} <span
                                                class="text-danger">*</span></label>
                                        <input type="number" name="canceled_period" class="form-control">
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
                                        <input type="number" required id="adults_count" name="adults_count"
                                            class="form-control">
                                        @error('adults_count')
                                            <span class="error text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6 col-lg-4 col-xl-6">
                                    <div class="form-group">
                                        <label for="">{{ __('booking.number_of_children') }} <span
                                                class="text-danger">*</span></label>
                                        <input type="number" id="childerns_count" name="childerns_count"
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
                                        <input type="number" id="babes_count" name="babes_count" class="form-control">
                                        @error('babes_count')
                                            <span class="error text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6 col-lg-4 col-xl-6">
                                    <div class="form-group">
                                        <label for="">{{ __('booking.total_person_count') }} <span
                                                class="text-danger">*</span></label>
                                        <input type="number" readonly id="total_person_count" name="total_person_count"
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
                                        <label for="">{{ __('general.hotel') }}<button type="button"
                                            data-target="#add_hotel" data-add_hotel="" data-toggle="modal"
                                            class="btn btn--primary btn-sm">
                                            <i class="fa fa-plus-square"></i>
                                        </button> <span
                                                class="text-danger">*</span></label>
                                        <select required name="hotel_id" class="form-control js-select2-custom ">
                                            <option value="">{{ __('general.select') }}</option>
                                            @foreach ($hotels as $hotel_item)
                                                <option value="{{ $hotel_item->id }}">{{ $hotel_item->name }}</option>
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
                                        </select>
                                        @error('country')
                                            <span class="error text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6 col-lg-4 col-xl-6">
                                    <div class="form-group">
                                        <label for="">{{ __('general.city') }} </label>
                                        <input type="text" name="city" readonly class="form-control">
                                        @error('city')
                                            <span class="error text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6 col-lg-4 col-xl-6">
                                    <div class="form-group">
                                        <label for="">{{ __('booking.booking_no') }}<span class="text-danger">
                                                *</span> </label>
                                        <input type="text" required name="booking_no" class="form-control">
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
                                                <option value="{{ $unit_type_item->id }}">{{ $unit_type_item->name }}
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
                                        <input type="text" name="food_type" required class="form-control">

                                        @error('food_type')
                                            <span class="error text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6 col-lg-4 col-xl-6">
                                    <div class="form-group">
                                        <label for="">{{ __('booking.number_of_units') }} <span
                                                class="text-danger">*</span></label>
                                        <input type="number" name="units_count" class="form-control">
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
                                        <input type="number" onkeyup="calculate_earn()" name="buy_price"
                                            class="form-control">
                                        @error('buy_price')
                                            <span class="error text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6 col-lg-4 col-xl-6">
                                    <div class="form-group">
                                        <label for="">{{ __('booking.sale_price') }} </label>
                                        <input type="number" onkeyup="calculate_earn()" name="price"
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
                                            <option value="euro">{{ __('booking.euro') }}</option>
                                            <option value="dolar">{{ __('booking.dolar') }}</option>
                                            <option value="lira">{{ __('booking.lira') }}</option>
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
                                            <option value="no">{{ __('booking.no') }}</option>
                                            <option value="yes">{{ __('booking.yes') }}</option>
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
                                            <option value="percentage">{{ __('booking.percentage') }}</option>
                                            <option value="night">{{ __('booking.night') }}</option>
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
                                        <input type="number" name="commission_percentage" onkeyup="calculate_earn()"
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
                                        <input type="number" name="commission_night" onkeyup="calculate_earn()"
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
                                            <option value="no">{{ __('booking.no') }}</option>
                                            <option value="yes">{{ __('booking.yes') }}</option>
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
                                                <option value="{{ $broker_item->id }}">{{ $broker_item->name }}</option>
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
                                        <input type="number" name="broker_amount" class="form-control"
                                            onkeyup="calculate_earn()">
                                        @error('broker_amount')
                                            <span class="error text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6 col-lg-4 col-xl-6">
                                    <div class="form-group">
                                        <label for="">{{ __('booking.earn') }} </label>
                                        <input type="number" name="earn" class="form-control" readonly>
                                        @error('earn')
                                            <span class="error text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6 col-lg-4 col-xl-6">
                                    <div class="form-group">
                                        <label for="">{{ __('booking.total') }} </label>
                                        <input type="number" readonly name="total" class="form-control">
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
                                                <div class="col-md-6 col-lg-4 col-xl-2">
                                                    <div class="form-group">
                                                        <label for="phone_dail_code"
                                                            class="title-color">{{ __('general.dial_code') }}</label>
                                                        <select class="js-select2-custom form-control"
                                                            name="phone_dial_code">
                                                            <option selected>{{ __('general.select') }}</option>
                                                            @foreach ($dail_code_main as $item_dail_code)
                                                                <option value="{{ '+' . $item_dail_code->dial_code }}">
                                                                    {{ '+' . $item_dail_code->dial_code }}
                                                                </option>
                                                            @endforeach
                                                        </select>

                                                    </div>
                                                </div>
                                                <div class="col-md-6 col-lg-4 col-xl-4">
                                                    <div class="form-group">
                                                        <label for="">{{ __('login.phone') }}</label>
                                                        <input type="text" name="phone" class="form-control">
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
                                                            class="form-control js-select2-custom ">
                                                            @foreach ($countries as $countries_item)
                                                                <option value="{{ $countries_item->id }}">
                                                                    {{ $countries_item->name }}
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
                        <form action="{{ route('admin.hotel.store_for_any') }}" method="post" enctype="multipart/form-data">
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
                                                            <option value="Hotel Apartments Resort">Hotel Apartments Resort</option>  
                                                        </select>
                                                        @error('hotel_type')
                                                            <span class="error text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-md-6 col-lg-4 col-xl-6">
                
                                                    <div class="form-group">
                                                        <label for="">{{ __('general.hotel_rate') }}  </label>
                                                        <input type="number" min="0" name="hotel_rate" class="form-control">
                                                        @error('hotel_rate')
                                                            <span class="error text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-md-6 col-lg-4 col-xl-6">
                                                    <div class="form-group">
                                                        <label for="">{{ __('general.country') }} <span
                                                                class="text-danger">*</span></label>
                                                        <select name="country_id" class="form-control js-select2-custom ">
                                                            @foreach ($countries as $countries_item)
                                                                <option value="{{ $countries_item->id }}">{{ $countries_item->name }}
                                                                </option>
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
                                                        <input type="text" name="city" class="form-control">
                                                        @error('city')
                                                            <span class="error text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-md-6 col-lg-4 col-xl-6">
                                                    <div class="form-group">
                                                        <label for="">{{ __('roles.all_unit_types') }} <span
                                                                class="text-danger">*</span></label>
                                                        <select name="unit_type_ids[]" class="form-control js-select2-custom " multiple>
                                                            <option disabled selected hidden>{{ __('general.select_unit_type') }}</option>
                                                            @foreach ($unit_types as $unit_types_item)
                                                                <option value="{{ $unit_types_item->id }}">{{ $unit_types_item->name }}
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
                                                <button type="submit" class="btn btn-primary mt-2">{{ __('dashboard.save') }}</button>
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
                var earn = ((salePrice - (buyPrice - commission) - broker_amount) * night_count);
                var total = (salePrice * night_count);
            } else if (commission_type == 'night') {
                var commission = commission_night;
                var earn = ((salePrice - (buyPrice - commission)  - broker_amount) * night_count)
                var total = (salePrice * night_count) ;
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
    </script>
@endsection
