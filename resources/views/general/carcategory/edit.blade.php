@extends('layouts.dashboard')
@section('title')
    {{ __('Edit Car Category') }}
@endsection
@section('css')
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
                <h4 class="page-title">{{ __('Edit Car Category') }}</h4>
            </div>
            <div class="col-7 align-self-center">
                <div class="d-flex no-block justify-content-end align-items-center">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="{{ route('dashboard') }}">{{ __('dashboard.home') }}</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">{{ __('Edit Car Category') }}</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>

    <div class="mb-5"></div>
    <div class="container-fluid">
        <form action="{{ route('category.update', $category->id) }}" method="post" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">

                                <div class="col-md-6 col-lg-4 col-xl-6">
                                    <div class="form-group">
                                        <label>{{ __('Add new category') }} <span class="text-danger">*</span></label>
                                        <input type="text" name="category" class="form-control" value="{{ old('category', $category->category) }}">
                                        @error('category')
                                            <span class="error text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6 col-lg-4 col-xl-6">
                                    <div class="form-group">
                                        <label>{{ __('Lisance number') }} <span class="text-danger">*</span></label>
                                        <input type="text" name="car_number" class="form-control" value="{{ old('car_number', $category->car_number) }}">
                                        @error('car_number')
                                            <span class="error text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6 col-lg-4 col-xl-6">
                                    <div class="form-group">
                                        <label>{{ __('model') }} <span class="text-danger">*</span></label>
                                        <input type="number" name="model" class="form-control" value="{{ old('model', $category->model) }}">
                                        @error('model')
                                            <span class="error text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6 col-lg-4 col-xl-6">
                                    <div class="form-group">
                                        <label>{{ __('Price for one day') }} <span class="text-danger">*</span></label>
                                        <input type="number" name="price_per_day" class="form-control" value="{{ old('price_per_day', $category->price_per_day) }}">
                                        @error('price_per_day')
                                            <span class="error text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                            </div>

                            <div class="form-group mt-2" style="text-align: {{ Session::get('locale') == 'en' ? 'right;margin-right:10px' : 'left;margin-left:10px' }}">
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
@endsection
