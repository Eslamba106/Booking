<!DOCTYPE html>
<html dir="rtl">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('assets/images/main_logo.jpg') }}">
    <title>{{ __('login.login') }}</title>
    <!-- Custom CSS -->
    <link href="{{ asset('dist/css/style.min.css') }}" rel="stylesheet">
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
<![endif]-->
</head>

<body>
    <div class="main-wrapper">
        <!-- ============================================================== -->
        <!-- Preloader - style you can find in spinners.css -->
        <!-- ============================================================== -->
        <div class="preloader">
            <div class="lds-ripple">
                <div class="lds-pos"></div>
                <div class="lds-pos"></div>
            </div>
        </div>
        <!-- ============================================================== -->
        <!-- Preloader - style you can find in spinners.css -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- Login box.scss -->
        <!-- ============================================================== -->
        <div class="auth-wrapper d-flex no-block justify-content-center align-items-center" style="background:url({{ asset('assets/images/big/auth-bg.jpg') }}) no-repeat center center;background-size: cover;    width: 100vw;height: 100vh;">
            <div class="auth-box">
                <div id="loginform">
                    <div class="logo">
                        <span class="db"><img src="{{ asset('assets/images/logo-icon.png') }}" alt="logo" /></span>
                        <h5 class="font-medium m-b-20">{{ __('login.sign_in') }}</h5>
                    </div>
                    <!-- Form -->
                    <div class="row">
                        <div class="col-12">
                            <form class="form-horizontal m-t-20" id="loginform" action="{{ route('login') }}" method="POST">
                                @csrf
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="basic-addon1"><i class="ti-user"></i></span>
                                    </div>
                                    <input type="text" name="user_name" class="form-control form-control-lg" placeholder="{{ __('login.email_or_username') }}" aria-label="Username" aria-describedby="basic-addon1">
                                    @error('email') <span class="error text-danger">{{ $message }}</span> @enderror
                                    @error('user_name') <span class="error text-danger">{{ $message }}</span> @enderror
                                </div>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="basic-addon2"><i class="ti-pencil"></i></span>
                                    </div>
                                    <input type="text" class="form-control form-control-lg" name="password" placeholder="{{ __('login.password') }}" aria-label="Password" aria-describedby="basic-addon1">
                                    @error('password') <span class="error text-danger">{{ $message }}</span> @enderror
                                </div>
                                <!-- <div class="form-group row">
                                    <div class="col-md-12">
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" id="customCheck1">
                                            {{-- <label class="custom-control-label" for="customCheck1">Remember me</label> --}}
                                            <a href="javascript:void(0)" id="to-recover" class="text-dark float-right"><i class="fa fa-lock m-r-5"></i> {{ __('login.forgot') }}</a>
                                            {{-- <a href="{{ route('register-page') }}" class="custom-control-label">{{ __('login.register') }}</a> --}}
                                        </div>
                                    </div>
                                </div> -->
                                <div class="form-group text-center">
                                    <div class="col-xs-12 p-b-20">
                                        <button class="btn btn-block btn-lg btn-info" type="submit">{{ __('login.login') }}</button>
                                    </div>
                                </div>
                                {{-- <div class="row">
                                    <div class="col-xs-12 col-sm-12 col-md-12 m-t-10 text-center">
                                        <div class="social">
                                            <a href="javascript:void(0)" class="btn  btn-facebook" data-toggle="tooltip" title="" data-original-title="Login with Facebook"> <i aria-hidden="true" class="fab  fa-facebook"></i> </a>
                                            <a href="javascript:void(0)" class="btn btn-googleplus" data-toggle="tooltip" title="" data-original-title="Login with Google"> <i aria-hidden="true" class="fab  fa-google-plus"></i> </a>
                                        </div>
                                    </div>
                                </div> --}}
                               
                            </form>
                        </div>
                    </div>
                </div>
                {{-- <div id="recoverform">
                    <div class="logo">
                        <span class="db"><img src="../../assets/images/logo-icon.png" alt="logo" /></span>
                        <h5 class="font-medium m-b-20">Recover Password</h5>
                        <span>Enter your Email and instructions will be sent to you!</span>
                    </div>
                    <div class="row m-t-20">
                        <!-- Form -->
                        <form class="col-12" action="index.html">
                            <!-- email -->
                            <div class="form-group row">
                                <div class="col-12">
                                    <input class="form-control form-control-lg" type="email" required="" placeholder="Username">
                                </div>
                            </div>
                            <!-- pwd -->
                            <div class="row m-t-20">
                                <div class="col-12">
                                    <button class="btn btn-block btn-lg btn-danger" type="submit" name="action">Reset</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div> --}}
            </div>
        </div>
        <!-- ============================================================== -->
        <!-- Login box.scss -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- Page wrapper scss in scafholding.scss -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- Page wrapper scss in scafholding.scss -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- Right Sidebar -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- Right Sidebar -->
        <!-- ============================================================== -->
    </div>
    {{-- <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 d-flex justify-content-center">
            <button class="btn btn-primary" onclick="serviceCharge()">{{ __('Add Service Charge') }}</button>
        </div>
        <div id="formsContainer" class="col-lg-12 col-md-12 col-sm-12 col-xs-12 mt-3">
            <!-- سيتم إضافة النماذج هنا -->
        </div>
    </div> --}}
    
{{-- <div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 d-flex justify-content-center">
        <button class="btn btn-primary" onclick="serviceCharge()">{{ __('Add Service Charge') }}</button>
    </div>
    <div id="formsContainer" class="col-lg-12 col-md-12 col-sm-12 col-xs-12 mt-3">
    </div>
</div>

<script>
    function serviceCharge() {
        var formDiv = document.createElement('div');
        formDiv.classList.add('mb-3');

        var uniqueId = 'form-' + new Date().getTime();
        formDiv.id = uniqueId;

        formDiv.innerHTML = `
            <form>
                <div class="form-group">
                    <label for="serviceName">Service Name</label>
                    <input type="text" class="form-control" id="serviceName" placeholder="Enter service name">
                </div>
                <div class="form-group">
                    <label for="serviceCharge">Service Charge</label>
                    <input type="number" class="form-control" id="serviceCharge" placeholder="Enter service charge">
                </div>
                <button type="submit" class="btn btn-success">Submit</button>
                <button type="button" class="btn btn-danger" onclick="removeForm('${uniqueId}')">Remove</button>
            </form>
        `;

        document.getElementById('formsContainer').appendChild(formDiv);
    }

    function removeForm(id) {
        var formDiv = document.getElementById(id);
        if (formDiv) {
            formDiv.remove();
        }
    }

</script> --}}
    
    <!-- ============================================================== -->
    <!-- All Required js -->
    <!-- ============================================================== -->
    <script src="{{ asset('assets/libs/jquery/dist/jquery.min.js') }}"></script>
    <!-- Bootstrap tether Core JavaScript -->
    <script src="{{ asset('assets/libs/popper.js/dist/umd/popper.min.js') }}"></script>
    <script src="{{ asset('assets/libs/bootstrap/dist/js/bootstrap.min.js') }}"></script>
    <!-- ============================================================== -->
    <!-- This page plugin js -->
    <!-- ============================================================== -->
    <script>
    $('[data-toggle="tooltip"]').tooltip();
    $(".preloader").fadeOut();
    // ============================================================== 
    // Login and Recover Password 
    // ============================================================== 
    $('#to-recover').on("click", function() {
        $("#loginform").slideUp();
        $("#recoverform").fadeIn();
    });
    </script>
{{-- <body>
    <div class="form-container" >
        <form action="{{ route('login') }}" method="POST" style="width:500px">
            @csrf

            <div class="from-group">
                <label for="email">البريد الالكتروني : </label><br>
                <input class="form-control" type="email" id="email" name="email"><br><br>
            </div>
            <div class="from-group">
                <label for="name">كلمة المرور :</label><br>
                <input class="form-control" type="password" id="name" name="password"><br><br>
            </div>


            <button class="btn btn-primary" type="submit" value="Submit">تسجيل دخول</button>
            <div class="d-flex justify-content-between align-items-center mt-4 mr-3">

                <a class="fs-1" href="{{ route('register-page') }}">تسجيل</a>
                <a class="fs-1 ml-3" href="">هل نسيت كلمة المرور</a>
            </div>
        </form>
        
    </div> --}}


    <!-- ============================================================== -->
    <!-- All Jquery -->
    <!-- ============================================================== -->
    {{-- <script src="../../assets/libs/jquery/dist/jquery.min.js "></script>
    <!-- Bootstrap tether Core JavaScript -->
    <script src="../../assets/libs/popper.js/dist/umd/popper.min.js "></script>
    <script src="../../assets/libs/bootstrap/dist/js/bootstrap.min.js "></script> --}}
    {{-- <!-- apps -->
    <script src="../../dist/js/app.min.js "></script>
    <script src="../../dist/js/app.init.js "></script>
    <script src="../../dist/js/app-style-switcher.js "></script>
    <!-- slimscrollbar scrollbar JavaScript -->
    <script src="../../assets/libs/perfect-scrollbar/dist/perfect-scrollbar.jquery.min.js "></script>
    <script src="../../assets/extra-libs/sparkline/sparkline.js "></script>
    <!--Wave Effects -->
    <script src="../../dist/js/waves.js "></script>
    <!--Menu sidebar -->
    <script src="../../dist/js/sidebarmenu.js "></script>
    <!--Custom JavaScript --> --}}
    {{-- <script src="../../dist/js/custom.min.js "></script> --}}
</body>

</html>