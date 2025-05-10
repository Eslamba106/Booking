<!DOCTYPE html>
<html @if (session()->has('locale') && session()->get('locale') == 'ar') dir="rtl" lang="ar" @else dir="ltr" lang="en" @endif>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('assets/images/main_logo.jpg') }}">
    <title> @yield('title', 'Dashboard') </title>
    <!-- Custom CSS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    {{-- <link rel="stylesheet" href="{{ asset('assets/libs/select2/dist/css/select2.min.css') }}"> --}}
    <link rel="stylesheet" href="{{ asset('select2-4.0.3/css/select2.css') }}">

    <link href="{{ asset('assets/libs/chartist/dist/chartist.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/extra-libs/c3/c3.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/libs/morris.js/morris.css') }}" rel="stylesheet">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">


    <link href="{{ asset('dist/css/style.min.css') }}" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('intel/css/intlTelInput.min.css') }}">
    <script src="{{ asset('intel/js/intlTelInput.min.js') }}"></script>
    <script src="{{ asset('intel/js/utils.js') }}"></script>

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    @yield('css')

    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
<![endif]-->
</head>

<body>


    <div class="preloader">
        <div class="lds-ripple">
            <div class="lds-pos"></div>
            <div class="lds-pos"></div>
        </div>
    </div>
    <!-- ============================================================== -->
    <!-- Main wrapper - style you can find in pages.scss -->
    <!-- ============================================================== -->
    <div id="main-wrapper">

        @include('layouts.header')
        @include('layouts.sidebar')
        <div class="page-wrapper">
            @yield('content')
            @include('layouts.footer')
        </div>

    </div>


    @if (Session::has('success'))
        <script>
            swal("Message", "{{ Session::get('success') }}", 'success', {
                button: true,
                button: "Ok",
                timer: 3000,
            })
        </script>
    @endif
    @if (Session::has('info'))
        <script>
            swal("Message", "{{ Session::get('info') }}", 'info', {
                button: true,
                button: "Ok",
                timer: 3000,
            })
        </script>
    @endif
    @if (Session::has('error'))
        <script>
            swal("Message", "{{ Session::get('error') }}", 'error', {
                button: true,
                button: "Ok",
                timer: 3000,
            })
        </script>
    @endif




    <script src="https://cdn.jsdelivr.net/npm/alpinejs@2.8.2" defer></script>


    <script src="{{ asset('assets/libs/jquery/dist/jquery.min.js') }}"></script>
    <!-- Bootstrap tether Core JavaScript -->
    <script src="{{ asset('assets/libs/popper.js/dist/umd/popper.min.js') }}"></script>
    <script src="{{ asset('assets/libs/bootstrap/dist/js/bootstrap.min.js') }}"></script>
    <!-- apps -->
    <script src="{{ asset('dist/js/app.min.js') }}"></script>
    <script src="{{ asset('dist/js/app.init.js') }}"></script>
    <script src="{{ asset('dist/js/app-style-switcher.js') }}"></script>
    <!-- slimscrollbar scrollbar JavaScript -->
    <script src="{{ asset('assets/libs/perfect-scrollbar/dist/perfect-scrollbar.jquery.min.js') }}"></script>
    <script src="{{ asset('assets/extra-libs/sparkline/sparkline.js') }}"></script>
    <!--Wave Effects -->
    <script src="{{ asset('dist/js/waves.js') }}"></script>
    <!--Menu sidebar -->
    <script src="{{ asset('dist/js/sidebarmenu.js') }}"></script>
    <!--Custom JavaScript -->
    <script src="{{ asset('dist/js/custom.min.js') }}"></script>
    <!--This page JavaScript -->
    <!--chartis chart-->
    <script src="{{ asset('assets/libs/chartist/dist/chartist.min.js') }}"></script>
    <script src="{{ asset('assets/libs/chartist-plugin-tooltips/dist/chartist-plugin-tooltip.min.js') }}"></script>
    <!--c3 charts -->
    <script src="{{ asset('assets/extra-libs/c3/d3.min.js') }}"></script>
    <script src="{{ asset('assets/extra-libs/c3/c3.min.js') }}"></script>
    <!--chartjs -->
    <script src="{{ asset('assets/libs/raphael/raphael.min.js') }}"></script>
    <script src="{{ asset('assets/libs/morris.js/morris.min.js') }}"></script>
    {{-- <script src="{{ asset('assets/libs/select2/dist/js/select2.min.js') }}"></script> --}}
    <script src="{{ asset('select2-4.0.3/js/select2.min.js') }}"></script>

    <script src="{{ asset('dist/js/pages/dashboards/dashboard1.js') }}"></script>

    <script>
        $(document).on('change', '.bulk_check_all', function() {
            $('input.check_bulk_item:checkbox').not(this).prop('checked', this.checked);
        });
    </script>
    <script>
        $(document).ready(function() {
            $('.js-select2-custom').select2({
                width: '100%',
                allowClear: true
            });
        });
    </script>
    {{-- <script src="{{ asset('custom-js/documents1001.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
    <script src="{{ asset('custom-js/documents1001.js') }}"></script>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.css">
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script> --}}
    @yield('js')
</body>

</html>
