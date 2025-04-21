@extends('layouts.dashboard')
@section('title')
    {{ __('roles.edit_hotel') }}
@endsection
@section('content')
    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-5 align-self-center">
                <h4 class="page-title">{{ __('roles.edit_hotel') }}</h4>
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
        <form action="{{ route('admin.hotel.update', $hotel->id) }}" method="post" enctype="multipart/form-data">
            @csrf
            @method('patch')
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">

                                <div class="col-md-6 col-lg-4 col-xl-6">

                                    <div class="form-group">
                                        <label for="">{{ __('roles.name') }} <span
                                                class="text-danger">*</span></label>
                                        <input type="text" name="name" class="form-control" value="{{ $hotel->name }}">
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
                                            <option value="Hotel" {{ ('Hotel' == $hotel->hotel_type) ? 'selected' : '' }}>Hotel</option> 
                                            <option value="Villa" {{ ('Villa' == $hotel->hotel_type) ? 'selected' : '' }}>Villa</option> 
                                            <option value="Bungalov" {{ ( 'Bungalov'== $hotel->hotel_type) ? 'selected' : '' }}>Bungalov</option> 
                                            <option value="Hotel Apartments Resort" {{ ( "Hotel Apartments Resort" == $hotel->hotel_type) ? 'selected' : '' }}>Hotel Apartments Resort</option>  
                                        </select>
                                        @error('hotel_type')
                                            <span class="error text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6 col-lg-4 col-xl-6">

                                    <div class="form-group">
                                        <label for="">{{ __('general.hotel_rate') }}  </label>
                                        <input type="number" min="0" value="{{ $hotel->hotel_rate }}" name="hotel_rate" class="form-control">
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
                                                <option value="{{ $countries_item->id }}" {{ ($countries_item->id == $hotel->country_id) ? 'selected' : '' }}>{{ $countries_item->name }}
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
                                        <input type="text" name="city" class="form-control" value="{{ $hotel->city }}">
                                        @error('city')
                                            <span class="error text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6 col-lg-4 col-xl-6">
                                    <div class="form-group">
                                        <label for="">{{ __('roles.all_unit_types') }} <span class="text-danger">*</span></label>
                                        <select name="unit_type_ids[]" class="form-control js-select2-custom " multiple   >
                                            <option disabled selected hidden>{{ __('general.select_unit_type') }}</option> 
                                            @foreach ($unit_types as $unit_types_item)
                                                <option value="{{ $unit_types_item->id }}" 
                                                    {{ ($hotel->unit_types) ? selected($hotel->unit_types->contains($unit_types_item->id))  : '' }}
                                                    >{{ $unit_types_item->name }}
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
