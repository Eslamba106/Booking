@extends('layouts.dashboard')
@section('title')
    {{ __('roles.create_service') }}
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
                <h4 class="page-title">{{ __('roles.create_service') }}</h4>
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
        <form action="{{ route('admin.service.store') }}" method="post" enctype="multipart/form-data">
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
                                                 style="text-transform:uppercase;" />

                                        @error('name')
                                            <span class="error text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                              <div class="form-group">
                                    <label for="">{{ __('Price') }} <span class="text-danger">*</span></label>
                                    <input type="number" name="price" class="form-control" id="price" style="text-transform:uppercase;" />
                                    @error('price') <span class="error text-danger">{{ $message }}</span> @enderror
                                </div>

                                <div class="form-group">
                                    <label for="">{{ __('Qunatity') }} <span class="text-danger">*</span></label>
                                    <input type="number" name="qty" class="form-control" id="qty" style="text-transform:uppercase;" />
                                    @error('qty') <span class="error text-danger">{{ $message }}</span> @enderror
                                </div>

                                <div class="form-group">
                                    <label>{{ __('booking.total') }}</label>
                                    <input type="number" name="total_price" class="form-control" id="total_price" readonly />
                                    @error('total') <span class="error text-danger">{{ $message }}</span> @enderror
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
    <script>
document.addEventListener('DOMContentLoaded', function () {
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


@endsection
