@extends('layouts.dashboard')
@section('title')
    {{ __('roles.create_hotel') }}
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
                <h4 class="page-title">{{ __('roles.create_hotel') }}</h4>
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
        <form action="{{ route('admin.hotel.store') }}" method="post" enctype="multipart/form-data">
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
                                        <label for="">{{ __('general.hotel_rate') }} </label>
                                        <select name="hotel_rate" class="form-control js-select2-custom">

                                            <option value="3 stars"> ⭐⭐⭐</option>
                                            <option value="4 stars"> ⭐⭐⭐⭐</option>
                                            <option value="5 stars"> ⭐⭐⭐⭐⭐</option>
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
                                                <select name="country_id" class="form-control js-select2-custom" id="country_select">
                                                    <option value="">{{ __('select country') }}</option>
                                                    @foreach ($countries as $countries_item)
                                                        <option value="{{ $countries_item->id }}">{{ $countries_item->name }}</option>
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
@endsection
@section('js')
    <script src="{{ asset('js/select2.min.js') }}"></script>

<script>
    $(document).ready(function () {
        $('#country_select').on('change', function () {
            var countryId = $(this).val();
            if (countryId) {
                $.ajax({
                    url: '/get-cities/' + countryId,
                    type: 'GET',
                    dataType: 'json',
                    success: function (data) {
                        $('#city_select').empty().append('<option value="">{{ __('select city') }}</option>');
                        $.each(data, function (key, value) {
                            $('#city_select').append('<option value="' + value.name + '">' + value.name + '</option>');
                        });
                    }
                });
            } else {
                $('#city_select').empty().append('<option value="">{{ __('select city') }}</option>');
            }
        });
    });
</script>


@endsection
