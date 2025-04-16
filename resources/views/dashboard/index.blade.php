@extends('layouts.dashboard')

@section('content')
 
    <div class="page-breadcrumb" >
        <div class="row">
            <div class="col-5 align-self-center">
                <h4 class="page-title">{{ __('dashboard.dashboard') }}</h4>
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

   
@endsection
@section('js')
    <script>
        Morris.Area({
            element: 'product-sales_new',
            data: [{
                    period: '2012',
                    iphone: 50,
                    ipad: 80,
                    itouch: 20
                },
                {
                    period: '2013',
                    iphone: 130,
                    ipad: 100,
                    itouch: 80
                },
                {
                    period: '2014',
                    iphone: 80,
                    ipad: 60,
                    itouch: 70
                },
                {
                    period: '2015',
                    iphone: 70,
                    ipad: 200,
                    itouch: 140
                },
                {
                    period: '2016',
                    iphone: 180,
                    ipad: 150,
                    itouch: 140
                },
                {
                    period: '2017',
                    iphone: 105,
                    ipad: 100,
                    itouch: 80
                },
                {
                    period: '2018',
                    iphone: 250,
                    ipad: 150,
                    itouch: 200
                }
            ],
            xkey: 'period',
            ykeys: ['iphone', 'ipad'],
            labels: ['iPhone', 'iPad'],
            pointSize: 2,
            fillOpacity: 0,
            pointStrokeColors: ['#ccc', '#4798e8', '#9675ce'],
            behaveLikeLine: true,
            gridLineColor: '#e0e0e0',
            lineWidth: 2,
            hideHover: 'auto',
            lineColors: ['#ccc', '#4798e8', '#9675ce'],
            resize: true
        });
    </script>
@endsection
