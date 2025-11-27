@extends('layouts.app')

@section('content')
<style>
    .col.text-center.align {
        font-size: initial !important;
        font-weight: 700 !important;
    }

    #loader {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        width: 100%;
        background: rgba(0, 0, 0, 0.75) url("/your_loading_image.gif") no-repeat center center;
        z-index: 99999;
    }

    .loader_div {
        position: fixed;
        left: 0px;
        top: 0px;
        width: 100%;
        height: 100%;
        z-index: 9999;
        background: url('/images/loader.gif') 50% 50% no-repeat rgb(249, 249, 249);
    }
</style>
<div class="container_fluid ">

    <div class="justify-content-center">
        <div clas="col-10">
            <h1 class="text-center fwcolor">
                <a type="button" href="{{Config::get('setting.web_portal')}}" class="btn btn-primary bg-243c92 font-weight-bold rounded-halfpill ml-3 login-back-button"><i class="fa fa-arrow-circle-left login-back" aria-hidden="true" style="  font-size: 1.4rem; display: flex;align-items: center;"></i> </a>

                <span class="mx-auto title title2-login">ELINA ISMS PORTAL</span>
            </h1>
        </div>
    </div>
</div>
@if (session('success'))
<input type="hidden" name="session_data" id="session_data" class="session_data" value="{{ session('success') }}">
<script type="text/javascript">
    window.onload = function() {
        var message = $('#session_data').val();
        Swal('Success!', message, 'success');
    }
</script>
@elseif(session('fail'))
<input type="hidden" name="session_data" id="session_data1" class="session_data" value="{{ session('fail') }}">
<script type="text/javascript">
    window.onload = function() {
        var message = $('#session_data1').val();
        Swal('Info!', message, 'info');
    }
</script>
@endif

@if(session('loginfail'))
<input type="hidden" name="session_loginfail" id="session_loginfail" value="{{ session('loginfail') }}">
<script type="text/javascript">
    window.onload = function() {
        var messageloginfail = $('#session_loginfail').val();
        console.log(messageloginfail);

        swal({
            title: "Info",
            text: messageloginfail,
            type: "info",
        });
    }
</script>
@endif

@if($errors->any())
@foreach ($errors->all() as $error)
<input type="hidden" name="session_error" id="session_error" value="{{ $error }}">
<script type="text/javascript">
    window.onload = function() {
        var messageerror = $('#session_error').val();
        console.log(messageerror);
        swal({
            title: "Info",
            text: messageerror,
            type: "info",
        });
    }
</script>
@endforeach
@endif

<div id="loader_div" class="loader_div"></div>
<div class="row image-1" style="width:100%">
    <div class="col-lg-8 col-md-6 col-sm-0">
    </div>
    <div class="col-lg-4 col-md-6 col-sm-12">

        <div class="container-fluid mt-lg-4" id="gmail" style=" display: none;">
            <div class="row justify-content-start loginformcontainer">
                <div class="" style="padding-left:3%;">
                    <div class="card border border-4 border-243c92 rounded-3 ">
                        <div class="row justify-content-center">
                            <img class="col-6 m-6 p-2" src="images\Elina Images\elina-logo-2.png" alt="logo" loading="lazy">
                        </div>

                        <div class="card-body">
                            <form method="POST" action="{{ route('login') }}" id="login" onsubmit="return validateForm()">
                                @csrf
                                <a class="formfont">
                                    Using Email Id
                                </a>
                                <div class="row mb-3">

                                    <!-- <label for="email" class="col-md-4 col-form-label text-md-end">{{ __('Email Address') }}</label> -->

                                    <div class="form-label-group col-12">
                                        <i class="bi bi-person-fill login_email_icon"></i>
                                        <input id="email" type="email" class="form-control border border-2 border-243c92 rounded-halfpill @error('email') is-invalid @enderror" name="email" placeholder="Email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                                        @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>


                                <div class="row mb-3">
                                    <!-- <label for="password" class="col-md-4 col-form-label text-md-end">{{ __('Password') }}</label> -->

                                    <div class="form-label-group col-12">
                                        <i class="fa fa-eye login_pass_icon" id="togglePassword"></i>
                                        <input id="password" type="password" class="form-control border border-2 border-243c92 rounded-halfpill login_pass @error('password') is-invalid @enderror" name="password" placeholder="Password" required autocomplete="current-password">

                                        @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>



                                <hr>
                                <h5 class="centerid">OR</h5>

                                <a class="formfont" onclick="mobile()">
                                    Signin Using OTP
                                </a>




                                <div class="row mb-3 justify-content-center">
                                    <div class="col">
                                        <div class="form-check text-center font-weight-bold">
                                            <div class="Rember">
                                                <input class="form-check-input border border-2 border-243c92" type="checkbox" name="remember" id="remember" checked {{ old('remember') ? 'checked' : '' }}>
                                                <label class="form-check-label" for="remember">
                                                    {{ __('Remember Me') }}
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row mb-0 ">
                                    <div class="col text-center">
                                        <button type="button" onclick="validateForm()" class="btn btn-primary bg-243c92 font-weight-bold font-family: 'Barlow Condensed', sans-serif; rounded-halfpill">
                                            {{ __('SIGN IN') }}
                                        </button>
                                    </div>
                                </div>


                                <div class="row mb-0 justify-content-center ">
                                    <div class="col text-center">
                                        @if (Route::has('password.request'))
                                        <a class="btn btn-link p-0 m-0 text-danger font-weight-bold" href="{{ route('password.request') }}">
                                            Forgot Password
                                        </a>
                                        @endif
                                    </div>
                                </div>

                                @include('partials.logincardfooter')
                            </form>
                        </div>
                    </div>
                    <h6 class="alignment"><i>ISMS-Intervention Service Management System</i></h6>



                </div>
            </div>
        </div>
        <div class="container-fluid mt-lg-4" id="mobileno">
            <div class="row justify-content-start loginformcontainer">
                <div class="" style="padding-left:3%; ">
                    <div class="card border border-4 border-243c92 rounded-3 ">
                        <div class="row justify-content-center">
                            <img class="col-6 m-6 p-2" src="images\Elina Images\elina-logo-2.png" alt="logo" loading="lazy">
                        </div>
                        @if (session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                        @endif

                        @if (session('loginfail'))
                        <div class="alert alert-danger" style="color: red;    font-weight: 550;">
                            {{ session('loginfail') }}
                        </div>
                        @endif

                        @if ($errors->any())
                        <div class="alert alert-danger">

                            @foreach ($errors->all() as $error)
                            {{ $error }}
                            @endforeach

                        </div>
                        @endif
                        <div class="card-body">
                            <form method="POST" action="{{ route('login') }}" id="login" onsubmit="return load()">
                                @csrf
                                <a class="formfont" onclick="mail()">
                                    Using Email Id
                                </a>
                                <div class="row mb-3">

                                    <!-- <label for="email" class="col-md-4 col-form-label text-md-end">{{ __('Email Address') }}</label> -->

                                    <div class="form-label-group col-12">
                                        <i class="bi bi-person-fill login_email_icon"></i>
                                        <input id="email" type="email" class="form-control border border-2 border-243c92 rounded-halfpill @error('email') is-invalid @enderror" name="email" placeholder="Email" value="{{ old('email') }}" required autocomplete="email" onfocus="mail()">

                                        @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                                <br>




                                <hr>
                                <h5 class="centerid">OR</h5>

                                <a class="formfont" onclick="mobile()">

                                    Using Mobile number
                                </a>
                                <div class="row mb-3">

                                    <div class="form-label-group col-12">

                                        <input id="mobile_nos" type="text" class="form-control border border-2 border-243c92 rounded-halfpill" name="Mobile_nos" oninput="span(this,'spanmobileno','fnu')" placeholder="Mobile No" maxlength="15" required inputmode="numeric" onfocus="mobile()">
                                    </div>
                                </div>




                                <div class="row mb-3 justify-content-center">
                                    <div class="col">
                                        <div class="form-check text-center font-weight-bold">
                                            <div class="Rember">
                                                <input class="form-check-input border border-2 border-243c92" type="checkbox" name="remember" id="remember" checked {{ old('remember') ? 'checked' : '' }}>
                                                <label class="form-check-label" for="remember">
                                                    {{ __('Remember Me') }}
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row mb-0 ">
                                    <div class="col text-center">
                                        <button type="submit" class="btn btn-primary bg-243c92 font-weight-bold font-family: 'Barlow Condensed', sans-serif; rounded-halfpill">
                                            {{ __('SIGN IN') }}
                                        </button>
                                    </div>
                                    <!-- <div class="col text-center">
                                        <a class="btn btn-primary bg-243c92 font-weight-bold font-family: 'Barlow Condensed', sans-serif; rounded-halfpill" href="{{route('register')}}">
                                            New User?
                                        </a>

                                    </div> -->
                                </div>


                                <div class="row mb-0 justify-content-center">
                                    <div class="col text-center">
                                        @if (Route::has('password.request'))
                                        <a class="btn btn-link p-0 m-0 text-danger font-weight-bold" href="{{ route('password.request') }}">
                                            Forgot Password
                                        </a>
                                        @endif
                                    </div>
                                </div>

                                @include('partials.logincardfooter')
                            </form>
                        </div>
                    </div>
                    <h6 class="alignment"><i>ISMS-Intervention Service Management System</i></h6>
                </div>
            </div>





        </div>
        <div class="container-fluid mt-lg-4" id="otp" style=" display: none;">
            <div class="row justify-content-start loginformcontainer">
                <div class="" style="padding-left:3%;">
                    <div class="card border border-4 border-243c92 rounded-3 ">
                        <div class="row justify-content-center">
                            <img class="col-6 m-6 p-4" src="images\Elina Images\elina-logo-2.png" alt="logo" loading="lazy">
                        </div>
                        @if (session('success'))

                        <input type="hidden" name="session_data" id="session_data" class="session_data" value="{{ session('success') }}">
                        <script type="text/javascript">
                            window.onload = function() {
                                var message = $('#session_data').val();
                                swal({
                                    title: "Success",
                                    text: message,
                                    type: "success",
                                });

                            }
                        </script>
                        @elseif(session('error'))

                        <input type="hidden" name="session_data" id="session_data1" class="session_data" value="{{ session('error') }}">
                        <script type="text/javascript">
                            window.onload = function() {
                                var message = $('#session_data1').val();
                                swal({
                                    title: "Info",
                                    text: message,
                                    type: "info",
                                });

                            }
                        </script>
                        @endif
                        <div class="card-body">
                            <div style="margin-bottom:2rem;">
                                <form method="POST" class="mb-3" action="{{ route('VerifyOTP') }}" id="onetimepassword">
                                    @csrf
                                    <a class="formfont" style="display: flex !important;justify-content: center !important;width: 100% !important;">
                                        Signin With OTP
                                    </a>

                                    <div class="row mb-3" style="display: none;">
                                        <div class="form-label-group col-12">
                                            <input id="mobile_no" type="text" class="form-control border border-2 border-243c92 rounded-halfpill" name="mobile_no" oninput="span(this,'spanmobileno','fnu')" placeholder="Mobile No" maxlength="15" required inputmode="numeric" oninput="formatNumber(event)">
                                            <span class="error-star" id="spanmobileno" style="color:red; position: absolute;top: 5px;left: 88px;">*</span>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="form-label-group col-12">
                                            <input id="email_otp" type="text" class="form-control border border-2 border-243c92 rounded-halfpill" name="email_otp" placeholder="Email" required>
                                            <!-- <span class="error-star" id="spanmobileno" style="color:red; position: absolute;top: 5px;left: 88px;">*</span> -->
                                        </div>
                                    </div>
                                    <div class="row mb-6">

                                        <div class="form-label-group col-4">
                                            <input id="otpn" type="text" class="form-control border border-2 border-243c92 rounded-halfpill" name="otp" oninput="span(this,'spanotp','fnu')" placeholder="OTP" maxlength="4" inputmode="numeric" oninput="formatNumber(event)">
                                            <!-- <span class="error-star" id="spanotp" style="color:red; position: absolute;top: 5px;left: 68px;">*</span> -->
                                        </div>

                                        <div class="form-label-group col-5">
                                            <button type="Submit" id="btngetotp" onclick="StartOTPTimer();" class="btn btn-primary bg-243c92 font-weight-bold font-family: 'Barlow Condensed', sans-serif; rounded-halfpill">
                                                Send-OTP
                                            </button>
                                        </div>

                                    </div>


                                    <hr>
                                    <h5 class="centerid">OR</h5>
                                    <div class="text-center">
                                        <a class="formfont" onclick="mail()">
                                            Signin Using Email
                                        </a>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="form-label-group col-5">

                                        </div>
                                        <div class="form-label-group col-4">


                                        </div>
                                        <div class="form-label-group col-3">
                                        </div>
                                    </div>



                                    <div class="row mb-0 ">
                                        <div class="col text-center">
                                            <a type="button" onclick="verifyotp()" id="verifybtnotp" class="btn btn-primary bg-243c92 font-weight-bold font-family: 'Barlow Condensed', sans-serif; rounded-halfpill" style="pointer-events: none; background:gray">
                                                {{ __('Verify OTP') }}
                                            </a>
                                        </div>
                                        <!-- <div class="col text-center">
                                            <a class="btn btn-primary bg-243c92 font-weight-bold font-family: 'Barlow Condensed', sans-serif; rounded-halfpill" href="{{route('register')}}">
                                                New User?
                                            </a>

                                        </div> -->
                                    </div>

                                    <div class="row mb-0 justify-content-center">
                                        <div class="col text-center">
                                            @if (Route::has('password.request'))
                                            <a class="btn btn-link p-0 m-0 text-danger font-weight-bold" href="{{ route('password.request') }}">
                                                Forgot Password
                                            </a>
                                            @endif
                                        </div>
                                    </div>

                                    @include('partials.logincardfooter')
                                </form>
                            </div>
                        </div>
                    </div>
                    <h6 class="alignment"><i>ISMS-Intervention Service Management System</i></h6>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // $(document).ready(function(){
    //     $(".loader").hide();
    //   $("button").bind("click", function(){
    //     alert('login');
    //     $(".loader").show();
    //   });


    // });
    function hasUpperCase(str) {
        return str !== str.toLowerCase();
    }

    function validateForm() {


        var email = $('#email').val();
        if (email == '') {
            swal("Please Enter Email", "", "error");
            return false;
        }
        var checkemail = hasUpperCase(email);
        if (checkemail == true) {
            swal("Email Should Only Contain Lowercase", "", "error");
            return false;
        }
        var password = $('#password').val();
        if (password == '') {
            swal("Please Enter Password", "", "error");
            return false;
        }

        $(".loader").show();
        document.getElementById('login').submit();

    }
</script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<script type="application/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery-cookie/1.4.1/jquery.cookie.min.js"></script>
<script>
    function StartOTPTimer() {

        var mobile_no = document.getElementById('mobile_no').value;
        // if (mobile_no == '') {
        //     swal("Please Enter Mobile Number", "", "error");
        //     return false;
        // }

        var email_otp = document.getElementById('email_otp').value;
        if (email_otp == '') {
            swal("Please Enter Email", "", "error");
            return false;
        }

        $("#btngetotp").attr("disabled", true);
        // setTimeout(function() {
        //     $("#btngetotp").attr("disabled", false);
        // }, 120000);
        let timerOn = true;
        let stoptimer = true;

        function timer(remaining) {
            if(stoptimer){
            var m = Math.floor(remaining / 60);
            var s = remaining % 60;

            m = m < 10 ? '0' + m : m;
            s = s < 10 ? '0' + s : s;
            document.getElementById('btngetotp').innerHTML = m + ':' + s;
            remaining -= 1;

            if (remaining >= 0 && timerOn) {
                setTimeout(function() {
                    timer(remaining);
                }, 1000);
                return;
            }

            if (!timerOn) {
                // Do validate stuff here
                return;
            }
            $("#btngetotp").attr("disabled", false);
            // Do timeout stuff here
            document.getElementById('btngetotp').innerHTML = "Resend-Otp";
        }else{
            $("#btngetotp").attr("disabled", false);
            document.getElementById('btngetotp').innerHTML = "Resend-Otp";
        }
        }

        timer(120);

        $.ajax({
            url: "{{ route('onetimepassword') }}",
            type: 'POST',
            data: {
                mobile_no: mobile_no,
                email_otp: email_otp,
                _token: '{{csrf_token()}}'
            },
            error: function() {
                alert('Something is wrong');
            },
            success: function(data) {
                if (data == 404) {
                    swal({
                        title: "Info",
                        text: "No Record Found",
                        type: "info"
                    });
                    
                    // $("#btngetotp").attr("disabled", false);
                    // document.getElementById('btngetotp').innerHTML = "Resend-Otp";
                    stoptimer = false;
                    // return true;
                } else {
                    swal({
                        title: "Success",
                        text: "OTP have been sent to your Registered Email",
                        type: "success"
                    });
                }
                document.getElementById('verifybtnotp').style.pointerEvents = "auto";
                document.getElementById('verifybtnotp').style.background = "#243c92";
                return true;
            }
        });

    }

    function verifyotp() {

        var mobile_no = document.getElementById('mobile_no').value;
        var email_otp = document.getElementById('email_otp').value;
        var otp = document.getElementById('otpn').value;


        // try{


        if ((otp === "")) {
            swal("Please Enter OTP", "", "error");
            return false;
        }

        document.getElementById('verifybtnotp').style.pointerEvents = "none";
        document.getElementById('verifybtnotp').style.background = "gray";
        // setTimeout(function() {
        //     $("#verifyotpbtn").attr("disabled", false);
        // }, 10000);
        $.ajax({
            url: "{{ route('VerifyOTP') }}",
            type: 'POST',
            data: {
                mobile_no: mobile_no,
                email_otp:email_otp,
                otp: otp,
                _token: '{{csrf_token()}}'
            },
            error: function() {
                swal({
                        title: "Failed",
                        text: "OTP Mismatched",
                        type: "fail"
                    },

                );
                return false;
            },
            success: function(response) {

                let fnstatus = response.success;

                if (fnstatus === "Success") {
                    swal({
                        title: "Success",
                        text: "OTP Verified",
                        type: "success"
                    }, );
                    window.location.href = "{{ url('home') }}"
                    return true;
                } else {
                    swal({
                        title: "Warning",
                        text: "Incorrect OTP",
                        type: "warning"
                    }, );
                    document.getElementById('verifybtnotp').style.pointerEvents = "auto";
                    document.getElementById('verifybtnotp').style.background = "#243c92";
                    return true;
                }
            }
        });

    }
</script>

<script>
    $(document).ready(function() {


        var remember = $.cookie('remember');
        if (remember == 'true') {
            var email = $.cookie('email');
            var password = $.cookie('password');
            // autofill the fields
            $('#email').val(email);
            $('#password').val(password);
        }


        $("#login").submit(function() {

            if ($('#remember').is(':checked')) {

                var email = $('#email').val();
                var password = $('#password').val();

                // set cookies to expire in 14 days
                $.cookie('email', email, {
                    expires: 14
                });
                $.cookie('password', password, {
                    expires: 14
                });
                $.cookie('remember', true, {
                    expires: 14
                });
            } else {
                // reset cookies
                $.cookie('email', null);
                $.cookie('password', null);
                $.cookie('remember', null);
            }
        });
    });

    function mail()

    {
        document.getElementById('gmail').style.display = "block";
        document.getElementById('mobileno').style.display = "none";
        document.getElementById('otp').style.display = "none";

    }




    function mobile() {
        document.getElementById('otp').style.display = "block";
        document.getElementById('gmail').style.display = "none";
        document.getElementById('mobileno').style.display = "none";
    }

    function span(a, b, c) {
        var a = a.value;
        if (a == "") {
            document.getElementById(b).style.display = "block";

        } else {
            document.getElementById(b).style.display = "none";
        }
        if (c == "fnu") {
            let value = event.target.value || '';
            value = value.replace(/[^0-9+ ]/, '', );
            event.target.value = value;
        } else if (c == "fna") {
            let value = event.target.value || '';
            value = value.replace(/[^a-z A-Z ]/, '', );
            event.target.value = value;

        } else {

        }
    }

    function verifyc()

    {
        document.getElementById('otpc').value = document.getElementById('OTP').value;

        document.getElementById('mobilec').value = document.getElementById('mobile_no').value;
        document.getElementById('btnverifyotp').submit();
    }
    $(document).ready(function() {
        const togglePassword = document.querySelector('#togglePassword');
        const password = document.querySelector('#password');

        togglePassword.addEventListener('click', function(e) {
            // toggle the type attribute
            const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
            password.setAttribute('type', type);
            // toggle the eye slash icon
            this.classList.toggle('fa-eye-slash');
        });
    });
</script>
<script>
    $("document").ready(function() {
        mail();
    });
</script>
@endsection