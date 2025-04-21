@extends('layouts.dashboard')
@section('title')
    {{ __('roles.edit_customer') }}
@endsection
@section('content')
    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-5 align-self-center">
                <h4 class="page-title">{{ __('roles.edit_customer') }}</h4>
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
        <form action="{{ route('admin.customer.update', $customer->id) }}" method="post" enctype="multipart/form-data">
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
                                        <input type="text" name="name" class="form-control"
                                            value="{{ $customer->name }}">
                                        @error('name')
                                            <span class="error text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6 col-lg-4 col-xl-6">

                                    <div class="form-group">
                                        <label for="">{{ __('roles.email') }} </label>
                                        <input type="text" name="email" class="form-control"
                                            value="{{ $customer->email }}">
                                        @error('email')
                                            <span class="error text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6 col-lg-4 col-xl-2">
                                    <div class="form-group">
                                        <label for="phone_dail_code" class="title-color">{{ __('general.dial_code') }}</label>
                                        <select class="js-select2-custom form-control" name="phone_dial_code">
                                            <option selected>{{ __('general.select') }}</option>
                                            @foreach ($dail_code_main as $item_dail_code)
                                                <option value="{{ '+' . $item_dail_code->dial_code }}" {{ $item_dail_code->dial_code == $customer->dial_code ? 'selected' : '' }}>
                                                    {{ '+' . $item_dail_code->dial_code }}
                                                </option>
                                            @endforeach
                                        </select>
    
                                    </div>
                                </div>
                                <div class="col-md-6 col-lg-4 col-xl-6">
                                    <div class="form-group">
                                        <label for="">{{ __('login.phone') }}</label>
                                        <input type="text" name="phone" class="form-control"
                                            value="{{ $customer->phone }}">
                                        @error('phone')
                                            <span class="error text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6 col-lg-4 col-xl-6">
                                    <div class="form-group">
                                        <label for="">{{ __('general.nationality') }} <span
                                                class="text-danger">*</span></label>
                                        <select name="nationality_id" class="form-control js-select2-custom ">
                                            @foreach ($countries as $countries_item)
                                                <option value="{{ $countries_item->id }}"
                                                    {{ $countries_item->id == $customer->country_id ? 'selected' : '' }}>
                                                    {{ $countries_item->name }}</option>
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
                                <button type="submit" class="btn btn-primary mt-2">{{ __('dashboard.save') }}</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection
