@extends('layouts.app')
@section('content')
<style>
    p {
        color: #000000c7 !important;
        font-weight: bolder !important;
    }
</style>
<div class="container_fluid ">
    <div class="justify-content-center">
        <div clas="col-10">
            <h1 class="text-center fwcolor">
                <a type="button" href="{{Config::get('setting.web_portal')}}" class="btn btn-primary bg-243c92 font-weight-bold rounded-halfpill ml-3"><i class="fa fa-arrow-circle-left" aria-hidden="true" style="    font-size: 1.4rem; display: flex;align-items: center;"></i> </a>
                <span class="mx-auto">ELINA ISMS PORTAL</span>
            </h1>
        </div>
    </div>
</div>

<div class="row image-2" style="width:100%">
    <div class="col-8 sm-0">
    </div>
    <div class="col-4 sm-12">
        <div class="container-fluid mt-lg-4" style="padding-bottom: 100px;">
            <div class="row justify-content-start">
                <div class="px-4">
                    <div class="card border border-4 border-243c92 rounded-3 contentcenter">
                        <div class="row justify-content-center">
                            <img class="col-4 mi-3 mt-3 col-sm-5 col-md-4 col-lg-4 col-xl-4 col-xxl-4" src="images\Elina Images\elina-logo (1).png" alt="logo">
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
                            @if ($message = Session::get('success'))
                            <div class="alert alert-success">
                                <strong>{{ $message }}</strong>
                            </div>
                            @endif
                            <form method="POST" id="registerstore" action="{{ route('registerstore') }}" onsubmit="validateForm()">
                                @csrf
                                <div class="row ">
                                    <div class="offset-md-6 col-md-6 "><span id="spandor" style="color: #243c92; font-weight: 700;font-family: 'Barlow Condensed', sans-serif;">Registration Date</span><span class="error-star" id="spandor" style="color:red; position: absolute;bottom: 4px; left: 110px;">*</span></div>
                                </div>
                                <div class="row mb-3">

                                    <div class="form-label-group col-6">
                                        <input id="name" type="text" class="form-control border border-2 border-243c92 rounded-halfpill @error('name') is-invalid @enderror" name="name" placeholder="Name" oninput="span(this,'spanname','fna')" value="" required autocomplete="name" inputmode="numeric" oninput="formatName(event)" autofocus>
                                        <span class="error-star" id="spanname" style="color:red;    position: absolute;top: 2px;left: 65px;">*</span>
                                        @error('name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                    <div class="form-label-group col-6">
                                        <input placeholder="Date of Registration" id="dor" type="text" date-forma class="form-control border border-2 border-243c92 rounded-halfpill dor" name="dor" data-date-format="dd/mm/yyyy" readonly required>
                                    </div>
                                    <span id="invalid-spanname" style="display:none; color:red;margin: 0 0 0 20px;">Special Characters (.:<>/%#&?) are not allowed</span>
                                </div>

                                <div class="row mb-3">
                                    <!-- <label for="email" class="col-md-4 col-form-label text-md-end">{{ __('Email Address') }}</label> -->

                                    <div class="form-label-group col-12">
                                        <input id="email" type="email" class="form-control border border-2 border-243c92 rounded-halfpill @error('email') is-invalid @enderror" oninput="span(this,'spanemail','fne')" name="email" placeholder="Email" value="{{ old('email') }}" required autocomplete="email">
                                        <span class="error-star" id="spanemail" style="color:red;position: absolute;top: 2px;left: 67px;">*</span>

                                        @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                                <span id="invalid-spanemail" style="display:none; color:red;margin: 0 0 0 20px;">Not a valid Email</span>
                                <div class="row mb-3">
                                    <!-- <label for="password" class="col-md-4 col-form-label text-md-end">{{ __('Password') }}</label> -->
                                    <div class="form-label-group col-12">
                                        <i class="fa fa-eye login_pass_icon" id="togglePassword"></i>
                                        <input id="password" type="password" class="form-control border border-2 border-243c92 rounded-halfpill  pr-password" onkeyup='check()' oninput="span(this,'spanpassword','fne')" name="password" placeholder="Password" required autocomplete="current-password">
                                        <span class="error-star" id="spanpassword" style="color:red;     position: absolute;top: 2px;left: 88px;">*</span>
                                        <div id="pwd_format" style="display: none;">
                                            <span id="letter" style="color: red;">A <b>Lowercase</b> letter</span><br>
                                            <span id="capital" style="color: red;">A <b>Uppercase</b> letter</span><br>
                                            <span id="number" style="color: red;">A <b>Number</b></span><br>
                                            <span id="Special" style="color: red;">A <b>Special characters</b></span><br>
                                            <span id="length" style="color: red;">Minimum <b>8 Characters</b></span>
                                        </div>
                                        @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror

                                    </div>
                                </div>

                                <div class="row mb-2 justify-content-md-end">
                                    <div class="form-label-group col-12">
                                        <i class="fa fa-eye login_pass_icon" id="togglePassword1"></i>
                                        <input id="password-confirm" type="password" class="form-control border border-2 border-243c92 rounded-halfpill " onkeyup='check()' oninput="span(this,'spancpassword','fne')" name="password_confirmation" placeholder="Confirm Password" required autocomplete="current-password">
                                        <span class="error-star" id="spancpassword" style="color:red;     position: absolute;top: 2px;left: 130px;">*</span>
                                        <span id='message'></span>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="form-label-group col-12">
                                        <input id="mobile_no" type="text" class="form-control border border-2 border-243c92 rounded-halfpill" name="Mobile_no" oninput="span(this,'spanmobileno','fnu')" placeholder="Mobile No" maxlength="10" required inputmode="numeric" oninput="formatNumber(event)">
                                        <span class="error-star" id="spanmobileno" style="color:red;     position: absolute;top: 2px;left: 88px;">*</span>
                                    </div>
                                    <span id="invalid-spanmobileno" style="display:none; color:red;margin: 0 0 0 20px;">Not a valid Phone Number</span>
                                </div>


                                <div class="row mb-0">
                                    <div class="col-md-12 p-16 12 m-2" style="display:flex; justify-content:space-evenly;font-family: 'Barlow Condensed', sans-serif;">
                                        <button type="button" onclick="validateForm()" class="btn btn-primary bg-243c92 font-weight-bold rounded-halfpill">
                                            {{ __('SIGN UP') }}
                                        </button>
                                        <a type="button" href="{{route('/')}}" class="btn btn-primary bg-243c92 font-weight-bold rounded-halfpill">
                                            {{ __('LOGIN') }}
                                        </a>
                                    </div>
                                </div>
                            </form>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<style>
    .swalalerttext.p.span {
        font-weight: bold !important;
    }
</style>
<script>
    function hasUpperCase(str) {
        return str !== str.toLowerCase();
    }

    function validateForm() {

        var name = $('#name').val();
        if (name == '') {
            swal("Please Enter Name", "", "error");
            return false;
        }

        var child_contact_email = $('#email').val();
        if (child_contact_email == '') {
            swal("Please Enter Email Address", "", "error");
            return false;
        }

        let testemail = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
        if (!testemail.test(child_contact_email)) {
            swal("Please Enter Valid Email Adress", "", "error");
            return false;
        }

        var checkemail = hasUpperCase(child_contact_email);
        if (checkemail == true) {
            swal("Email Should Only Contain Lowercase", "", "error");
            return false;
        }

        var password = $('#password').val();
        if (password == '') {
            swal("Please Enter Password", "", "error");
            return false;
        }

        var password_confirmation = document.getElementById('password-confirm').value;
        if (password_confirmation == '') {
            swal("Please Enter Confirm Password", "", "error");
            return false;
        }

        var child_contact_phone = document.getElementById('mobile_no').value;
        if (child_contact_phone == '') {
            swal("Please Enter Mobile number", "", "error");
            return false;
        }

        let testmobile = /^[+0-9]{10,15}/;
        if (!testmobile.test(child_contact_phone)) {
            swal("Please Enter Valid Mobile Number", "", "error");
            return false;
        }

        if (password != password_confirmation) {
            swal("Password Don't Match", "", "error");
            return false;
        }

        swal({
                html: true,
                title: "",
                text: "<h5><b>By clicking Yes, you will be registering with us which enables us to schedule a meeting with you to understand your requirements/concerns and also explain how we can be part of your journey.<br/>1. You have given an email ID and phone number that is active.<br/>2. You have gone through the Elina <a href='https://drive.google.com/file/d/1wK4x8hbHQnXajA0qGtIqu9GD7lzfr2nM/view?usp=share_link' target='_blank'>roadmap</a> to understand the processes that follow.<br/>Thank you! </b></h5>",
                type: "warning",
                customClass: 'swalalerttext',
                showCancelButton: true,
                confirmButtonColor: '#00a2ed',
                confirmButtonText: "Yes",
                cancelButtonText: "No",
                reverseButtons: true,
                closeOnConfirm: false,
                closeOnCancel: false,
                showLoaderOnConfirm: true,
                width: '950px'
            },
            function(isConfirm) {

                if (isConfirm) {
                    document.getElementById('registerstore').submit();
                } else {
                    swal.close();
                    window.location.href = "{{route('/')}}";
                }
            });
    }
</script>


<script src="https://code.jquery.com/jquery-1.7.2.min.js"></script>

<script type="text/javascript">
    $(document).ready(function() {
        var cd;
        var today = new Date();
        var dd = String(today.getDate()).padStart(2, '0');
        var mm = String(today.getMonth() + 1).padStart(2, '0'); //January is 0!
        var yyyy = today.getFullYear();
        var dor = "Date of Registration ";
        cd = dd + '/' + mm + '/' + yyyy;
        document.getElementById('dor').value = cd;
    });
    $(document).ready(function() {
        const togglePassword = document.querySelector('#togglePassword');
        const password = document.querySelector('#password');

        togglePassword.addEventListener('click', function(e) {
            const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
            password.setAttribute('type', type);
            this.classList.toggle('fa-eye-slash');

            setTimeout(function() {
                password.setAttribute('type', 'password');
                togglePassword.classList.toggle('fa-eye-slash');
            }, 10000);

        });

        const togglePassword1 = document.querySelector('#togglePassword1');
        const password1 = document.querySelector('#password-confirm');

        togglePassword1.addEventListener('click', function(e) {
            const type = password1.getAttribute('type') === 'password' ? 'text' : 'password';
            password1.setAttribute('type', type);
            this.classList.toggle('fa-eye-slash');

            setTimeout(function() {
                password1.setAttribute('type', 'password');
                togglePassword1.classList.toggle('fa-eye-slash');
            }, 10000);

        });
    });
    // 

    function span(a, b, c) {
        var a = a.value;
        if (a == "") {
            document.getElementById(b).style.display = "block";
        } else {
            document.getElementById(b).style.display = "none";
        }
        if (c == "fnu") {
            document.getElementById('invalid-' + b).style.display = 'none';
            let value = event.target.value || '';
            value = value.replace(/[^0-9+ ]/, '', );
            if (value != event.target.value) {
                document.getElementById('invalid-' + b).style.display = 'inline';
            }
            event.target.value = value;
        } else if (c == "fna") {
            document.getElementById('invalid-' + b).style.display = 'none';
            let value = event.target.value || '';
            value = value.replace(/[^a-z A-Z ]/, '', );
            if (value != event.target.value) {
                document.getElementById('invalid-' + b).style.display = 'inline';
            }
            event.target.value = value;
        } else {

        }
    }

    function formatNumber(event) {
        let value = event.target.value || '';
        value = value.replace(/[^0-9+ ]/, '', );
        event.target.value = value;

    }

    function formatName(event) {
        let value = event.target.value || '';
        value = value.replace(/[^a-z A-Z ]/, '', );
        event.target.value = value;

    }

    var check = function() {
        // alert ("dfd");exit;
        if (document.getElementById('password').value ==
            document.getElementById('password_confirmation').value) {

            document.getElementById('message').style.color = 'green';
            document.getElementById('message').innerHTML = '';
        } else {

            document.getElementById('message').style.color = 'red';
            document.getElementById('message').innerHTML = 'Passwords do not match';
        }
    }


    var check = function() {
        // alert ("dfd");exit;
        pwd1 = document.getElementById('password').value;
        var myInput = document.getElementById('password');
        var letter = document.getElementById("letter");
        var capital = document.getElementById("capital");
        var number = document.getElementById("number");
        var length = document.getElementById("length");
        var Special = document.getElementById("Special");

        document.getElementById("pwd_format").style.display = "block";
        var pwd_format = false;
        var lowerCaseLetters = /[a-z]/g;
        if (myInput.value.match(lowerCaseLetters)) {
            pwd_format = true;
            document.getElementById('letter').style.color = 'green';
        } else {
            pwd_format = false;
            document.getElementById('letter').style.color = 'red';
        }

        // Validate capital letters
        var upperCaseLetters = /[A-Z]/g;
        if (myInput.value.match(upperCaseLetters)) {
            pwd_format = true;
            document.getElementById('capital').style.color = 'green';
        } else {
            pwd_format = false;
            document.getElementById('capital').style.color = 'red';
        }

        var Special = /^(?=.*[~`!@#$%^&*()--+={}\[\]|\\:;"'<>,.?/_₹]).*$/;
        if (myInput.value.match(Special)) {
            pwd_format = true;
            document.getElementById('Special').style.color = 'green';
        } else {
            pwd_format = false;
            document.getElementById('Special').style.color = 'red';
        }

        // Validate numbers
        var numbers = /[0-9]/g;
        if (myInput.value.match(numbers)) {
            pwd_format = true;
            document.getElementById('number').style.color = 'green';
        } else {
            pwd_format = false;
            document.getElementById('number').style.color = 'red';
        }

        // Validate length
        if (myInput.value.length >= 8) {
            pwd_format = true;
            document.getElementById('length').style.color = 'green';
        } else {
            pwd_format = false;
            document.getElementById('length').style.color = 'red';
        }

        if(pwd_format == true) {
            document.getElementById("pwd_format").style.display = "none";
        }
        var pwd_validation = /^(?=.*[0-9])(?=.*[!@#$%^&*])[a-zA-Z0-9!@#$%^&*]{8,16}$/;

        if (document.getElementById('password-confirm').value != '') {
            var pwd_check = pwd_validation.test(pwd1);
            if (pwd_check == true) {
                document.getElementById("pwd_format").style.display = "none";
            }
            if (document.getElementById('password').value == document.getElementById('password-confirm').value) {
                document.getElementById('message').style.color = 'green';
                document.getElementById('message').innerHTML = 'Password Matched';
            } else {
                document.getElementById('message').style.color = 'red';
                document.getElementById('message').innerHTML = 'Passwords Not Match';
            }
        } else {
            document.getElementById('message').innerHTML = '';
        }
    }
</script>
@endsection