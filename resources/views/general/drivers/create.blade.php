@extends('layouts.dashboard')
@section('title')
    {{ __('roles.create_driver') }}
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
                <h4 class="page-title">{{ __('roles.create_driver') }}</h4>
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
        <form action="{{ route('admin.driver.store') }}" method="post" enctype="multipart/form-data">
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
                                                <input type="text" name="name" class="form-control" id="clientName" 
                                                oninput="validateName(this)" style="text-transform:uppercase;" />
                                         
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
                                        <label for="phone_dail_code" class="title-color">{{ __('general.dial_code') }}</label>
                                        <select class="js-select2-custom form-control" name="phone_dial_code">
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
                                        <select name="nationality_id" class="form-control js-select2-custom ">
                                            @foreach ($countries as $countries_item)
                                                <option value="{{ $countries_item->id }}">{{ $countries_item->name }}
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
        function validateName(input) {
             let regex = /^[A-Za-z\s]*$/;
            if (!regex.test(input.value)) {
                input.value = input.value.replace(/[^A-Za-z\s]/g, '');
            }
    
             input.value = input.value.toUpperCase();
        }
    </script>
    
@endsection
