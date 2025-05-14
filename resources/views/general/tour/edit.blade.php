@extends('layouts.dashboard')
@section('title')
    {{ __('Edit Car Tour') }}
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
                <h4 class="page-title">{{ __('Edit Car Tour') }}</h4>
            </div>
        </div>
    </div>

    <div class="container-fluid">
        <form action="{{ route('tour.update', $tour->id) }}" method="post" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6 col-lg-4 col-xl-6">
                                    <div class="form-group">
                                        <label>{{ __('Add new tour') }} <span class="text-danger">*</span></label>
                                        <input type="text" name="tour" class="form-control" value="{{ old('tour', $tour->tour) }}">
                                        @error('tour')
                                            <span class="error text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6 col-lg-4 col-xl-6">
                                    <div class="form-group">
                                        <label>{{ __('Price for tour') }} <span class="text-danger">*</span></label>
                                        <input type="number" name="price" class="form-control" id="price" value="{{ old('price', $tour->price) }}">
                                        @error('price')
                                            <span class="error text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="form-group mt-2"
                                style="text-align: {{ Session::get('locale') == 'en' ? 'right;margin-right:10px' : 'left;margin-left:10px' }};">
                                <button type="submit" class="btn btn-primary mt-2">{{ __('dashboard.update') }}</button>
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
