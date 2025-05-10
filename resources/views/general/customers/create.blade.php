@extends('layouts.dashboard')

@section('title')
    {{ __('roles.create_customer') }}
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
                <h4 class="page-title">{{ __('roles.create_customer') }}</h4>
            </div>
            <div class="col-7 align-self-center">
                <div class="d-flex justify-content-end align-items-center">
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
        <form action="{{ route('admin.customer.store') }}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                {{-- الاسم --}}
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>{{ __('roles.name') }} <span class="text-danger">*</span></label>
                                        <input type="text" name="name" class="form-control" id="clientName"
                                            oninput="validateName(this)" style="text-transform: uppercase;">
                                        @error('name')
                                            <span class="error text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                {{-- البريد الإلكتروني --}}
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>{{ __('roles.email') }}</label>
                                        <input type="text" name="email" class="form-control">
                                        @error('email')
                                            <span class="error text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                {{-- رقم الهاتف --}}
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>{{ __('login.phone') }}</label>
                                        <br>
                                        <input id="phone" name="phone" type="tel" class="form-control" value="+" oninput="keepPlusSign(this)">                                        @error('phone')
                                            <span class="error text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                {{-- الجنسية --}}
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>{{ __('general.nationality') }} <span class="text-danger">*</span></label>
                                        <select name="nationality_id" class="form-control js-select2-custom">
                                            @foreach ($countries as $countries_item)
                                                <option value="{{ $countries_item->id }}">{{ $countries_item->name }}</option>
                                            @endforeach
                                        </select>
                                        @error('nationality_id')
                                            <span class="error text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            {{-- زر الحفظ --}}
                            <div class="form-group mt-4 text-end"
                                style="{{ Session::get('locale') == 'en' ? 'margin-right:10px' : 'margin-left:10px' }}">
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
    <script src="{{ asset('intel/js/utils.js') }}"></script>

    <script>
        // دالة التحقق من الاسم
        function validateName(input) {
            const regex = /^[A-Za-z\s]*$/;
            if (!regex.test(input.value)) {
                input.value = input.value.replace(/[^A-Za-z\s]/g, '');
            }
            input.value = input.value.toUpperCase();
        }

        // إعداد الهاتف الدولي
        document.addEventListener('DOMContentLoaded', function () {
            const input = document.querySelector("#phone");

            const iti = window.intlTelInput(input, {
                nationalMode: false,
                autoHideDialCode: false,
                separateDialCode: false,
                utilsScript: "{{ asset('intel/js/utils.js') }}"
            });

            input.addEventListener('input', function () {
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
    </script>
@endsection
