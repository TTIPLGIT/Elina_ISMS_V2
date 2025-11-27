@extends('layouts.public')

@section('content')
<style>
    .scrollmenu {
        font-size: 19px !important;
        font-weight: bold;
    }

    .default {
        background-color: #ffffff !important;
    }


    /* Calander Icon Position */
    /* enable absolute positioning */
    .inner-addon {
        position: relative;
    }

    /* style glyph */
    .inner-addon .glyphicon {
        position: absolute;
        padding: 15px;
    }

    /* align glyph */
    .left-addon .glyphicon {
        left: 0px;
    }

    .right-addon .glyphicon {
        right: 0px;
    }

    /* add padding  */
    .left-addon input {
        padding-left: 30px;
    }

    .right-addon input {
        padding-right: 30px;
    }

    /*  Calander Icon Position - End */
</style>
<style>
    div.scrollmenu {
        overflow: auto;
        white-space: nowrap;
        display: flex;
        justify-content: center;
    }

    div.scrollmenu a {
        display: inline-block;
        color: black;
        text-align: center;
        /* padding: 14px; */
        cursor: pointer;
    }

    /* div.scrollmenu a:hover {
        background-color: #777;
    } */

    .activenav {
        /* background-color: #00ffb5; */
        /* border-radius: 50px; */
        border-bottom: 3.5px solid #004987;
    }

    div#ui-datepicker-div {
        z-index: 999999 !important;
    }



    @media (max-width: 767px) {
        .sweet-alert h2 {
            font-size: 18px;
        }

        div.scrollmenu {
            display: flex;
            justify-content: space-evenly;
        }

        .logomobile {
            display: flex;
            justify-content: center;
        }

        div.scrollmenu a {
            font-size: 14px;
            padding-right: 0;
        }

        .nav-link {
            padding: 0.1rem;
        }

        .background12 {
            display: none;
        }

        .checkbox-wrapper-31 {
            width: 14px;
            height: 15px;
        }

        .enrollsubmit {
            font-size: 12px;
        }


    }
</style>
<style>
    .checkbox-wrapper-31:hover .check {
        stroke-dashoffset: 0;
    }

    .checkbox-wrapper-31 {
        position: relative;
        display: inline-block;
        width: 13px;
        height: 20px;
    }

    .checkbox-wrapper-31 .background {
        fill: #ccc;
        transition: ease all 0.6s;
        -webkit-transition: ease all 0.6s;
    }

    .checkbox-wrapper-31 .stroke {
        fill: none;
        stroke: #fff;
        stroke-miterlimit: 10;
        stroke-width: 2px;
        stroke-dashoffset: 100;
        stroke-dasharray: 100;
        transition: ease all 0.6s;
        -webkit-transition: ease all 0.6s;
    }

    .checkbox-wrapper-31 .check {
        fill: none;
        stroke: #fff;
        stroke-linecap: round;
        stroke-linejoin: round;
        stroke-width: 2px;
        stroke-dashoffset: 22;
        stroke-dasharray: 22;
        transition: ease all 0.6s;
        -webkit-transition: ease all 0.6s;
    }

    .checkbox-wrapper-31 input[type=checkbox] {
        position: absolute;
        width: 100%;
        height: 100%;
        left: 0;
        top: 0;
        margin: 0;
        opacity: 0;
        -appearance: none;
        -webkit-appearance: none;
    }

    .checkbox-wrapper-31 input[type=checkbox]:hover {
        cursor: pointer;
    }

    .checkbox-wrapper-31 input[type=checkbox]:checked+svg .background {
        fill: #6cbe45;
    }

    .checkbox-wrapper-31 input[type=checkbox]:checked+svg .stroke {
        stroke-dashoffset: 0;
    }

    .checkbox-wrapper-31 input[type=checkbox]:checked+svg .check {
        stroke-dashoffset: 0;
    }

    .iti.iti--allow-dropdown.iti--separate-dial-code {
        width: 100%;
    }

    .knowelina {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
    }

    .card {
        background-image: url('/images/ocean.png');
        background-size: cover;
        background-position: center;
    }
</style>
<div class="main-content">
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
    <div class="row justify-content-center">
        <div class="col-lg-12 col-md-12">
            <form action="{{route('enrollement.store')}}" method="POST" id="newenrollement" enctype="multipart/form-data" onsubmit="return false">

                <div class="card" style="height:100%; padding: 15px">

                    <div class="row">
                        <input type="hidden" id="selected_id" name="selected_id" value="">
                        <input type="hidden" id="btn_status" name="btn_status" value="Submitted">

                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label childname">Child's Name: </label><span class="error-star" style="color:red;">*</span>
                                <input class="form-control default" type="text" id="child_name" name="child_name" oninput="childName(event)" maxlength="50" value="" autocomplete="off">
                                <span id="invalid-childName" style="display:none; color:red;">Special Characters (.:<>/%#&?) are not allowed</span>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label childname">Child's Date of Birth:</label><span class="error-star" style="color:red;">*</span>
                                <div class="inner-addon right-addon">
                                    <i class="glyphicon fa fa-calendar" id="togglePassword"></i>
                                    <input class="form-control default child_dob" type="text" id="child_dob" data-date-format="DD/MM/YYYY" name="child_dob" autocomplete="off" inputmode="none" oninput="validateDublication()" readonly onchange="validateDublication()">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label childname">Child's School Name: </label><span class="error-star" style="color:red;">*</span>
                                <select class="form-control default" id="child_school" name="child_school" onchange="toggleSchoolAddress()">
                                    <option value="">Select School</option>
                                    @foreach($schools as $school)
                                    <option value="{{$school->school_id}}">{{$school->school_name}}</option>
                                    @endforeach
                                    <option value="others">Others</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6" id="divSchool" style="display: none;">
                            <div class="form-group">
                                <label class="control-label childname">Child's Current School Name and Address: </label><span class="error-star" style="color:red;">*</span>
                                <textarea class="form-control default child_school_name_address" type="text" id="child_school_name_address" name="child_school_name_address" value="" autocomplete="off" oninput="completeCheck(1)"></textarea>
                            </div>
                        </div>
                        <div class="w-100"></div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label childname">Child's Gender:</label><span class="error-star" style="color:red;">*</span>
                                <br>
                                <input type="radio" id="child_gender" onclick="completeCheck(1)" name="child_gender" value="Male"><label for="featured-1" style="padding:5px 10px;font-family: 'Barlow Condensed', sans-serif;"> Male</label>
                                <input type="radio" id="child_gender" onclick="completeCheck(1)" name="child_gender" value="Female"><label for="featured-2" style="padding:5px 10px;font-family: 'Barlow Condensed', sans-serif;"> Female</label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label childname">Child's Father/Guardian Name: </label><!-- <span class="error-star" style="color:red;">*</span> -->
                                <input class="form-control default" type="text" id="child_father_guardian_name" name="child_father_guardian_name" oninput="childfatherName(event)" maxlength="50" value="" autocomplete="off">
                                <span id="invalid-childfatherName" style="display:none; color:red;">Special Characters (.:<>/%#&?) are not allowed</span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label childname">Child's Mother/Primary Caretaker's Name:</label> <!-- <span class="error-star" style="color:red;">*</span> -->
                                <input class="form-control default" type="text" id="child_mother_caretaker_name" name="child_mother_caretaker_name" oninput="childmotherName(event)" maxlength="50" value="" autocomplete="off">
                                <span id="invalid-childmotherName" style="display:none; color:red;">Special Characters (.:<>/%#&?) are not allowed</span>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="control-label childname">Email Address: </label><span class="error-star" style="color:red;">*</span>
                                <input id="child_contact_email" type="email" class="form-control @error('email') is-invalid @enderror default" oninput="spanemail()" name="child_contact_email" required autocomplete="off">
                                <div style="color:navy; display: block;">You can use this Email to Login.</div>
                                @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="control-label childname">Contact Phone Number: </label><span class="error-star" style="color:red;">*</span>
                                <input class="form-control indent" type="text" id="child_contact_phone" name="child_contact_phone" autocomplete="off" inputmode="numeric" oninput="contactphonenumber(event)" value="">
                                <br><span id='phone_message'></span>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="control-label childname">Alternative Phone Number: </label>
                                <input class="form-control indent" type="text" id="child_alter_phone" name="child_alter_phone" autocomplete="off" inputmode="numeric" oninput="contactphonenumber1(event)" value="">
                                <br><span id='phone_message2'></span>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="control-label childname">Address:</label><span class="error-star" style="color:red;">*</span>
                                <textarea class="form-control default" type="textarea" id="child_contact_address" name="child_contact_address" autocomplete="off" oninput="completeCheck(1)"></textarea>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group questions">
                                <label class="control-label">What is your expectation from Elina?<span class="error-star" style="color:red;">*</span></label>
                                <textarea class="form-control default expectation" type="text" id="services_from_elina" name="services_from_elina[]" value="" autocomplete="off" oninput="completeCheck(2)"></textarea>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group questions">
                                <label class="control-label ">How did you come to know about Elina? <span class="error-star" style="color:red;">*</span></label>
                                <div class="knowelina">
                                    <div class="row">
                                        <input type="checkbox" id="featured-5" name="how_knowabt_elina[]" value="From a Friend"><label for="featured-5">From a Friend</label>
                                    </div>
                                    <div class="row">
                                        <input type="checkbox" id="featured-6" name="how_knowabt_elina[]" value="Recommended by Child's therapist"><label for="featured-6">Recommended by Child's therapist</label>
                                    </div>
                                    <div class="row">
                                        <input type="checkbox" id="featured-7" name="how_knowabt_elina[]" value="Through Elina's Website"><label for="featured-7">Through Elina's Website</label>
                                    </div>
                                    <div class="row">
                                        <input type="checkbox" id="featured-8" name="how_knowabt_elina[]" value="Through HLC Admission"><label for="featured-8">Through HLC Admission</label>
                                    </div>
                                    <div class="row">
                                        <input type="checkbox" id="featured-9" name="how_knowabt_elina[]" value="Through Facebook and Social Media"><label for="featured-9">Through Facebook and Social Media</label>
                                    </div>
                                    <div class="row">
                                        <input type="checkbox" id="featured-10" name="how_knowabt_elina[]" value="Through Beyond 8"><label for="featured-10">Through Beyond 8</label>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <input type="hidden" name="dor" id="dor">
                        <input id="email" type="hidden" class="form-control border border-2 border-243c92 rounded-halfpill @error('email') is-invalid @enderror" oninput="span(this,'spanemail','fne')" name="email" placeholder="Email" value="{{ old('email') }}" required readonly autocomplete="off">
                        <input id="name" name="name" type="hidden" class="form-control border border-2 border-243c92 rounded-halfpill @error('name') is-invalid @enderror" placeholder="Name" oninput="span(this,'spanname','fna')" value="" required autocomplete="off" oninput="formatName(event)" autofocus>
                        <input id="mobile_no" type="hidden" class="form-control border border-2 border-243c92 rounded-halfpill" name="Mobile_no" oninput="span(this,'spanmobileno','fnu')" placeholder="Mobile No" maxlength="10" required inputmode="numeric" readonly autocomplete="off" oninput="formatNumber(event)">

                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label childname">Password: </label><span class="error-star" style="color:red;">*</span>
                                <div class="inner-addon right-addon">
                                    <i class="glyphicon fa fa-eye-slash login_pass_icon" id="togglePassword"></i>
                                    <input id="password" type="password" class="form-control border border-2 border-243c92 rounded-halfpill  pr-password" onkeyup='check()' oninput="span(this,'spanpassword','fne')" name="password" placeholder="Password" required autocomplete="off">
                                </div>
                                <div id="pwd_format" style="display: none;">
                                    <span id="letter" style="color: red;">A <b>Lowercase</b> letter</span><br>
                                    <span id="capital" style="color: red;">A <b>Uppercase</b> letter</span><br>
                                    <span id="number" style="color: red;">A <b>Number</b></span><br>
                                    <span id="Special" style="color: red;">A <b>Special characters</b></span><br>
                                    <span id="length" style="color: red;">Minimum <b>8 Characters</b></span>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label childname">Confirm Password: </label><span class="error-star" style="color:red;">*</span>
                                <div class="inner-addon right-addon">
                                    <i class="glyphicon  fa fa-eye-slash login_pass_icon" id="togglePassword1"></i>
                                    <input id="password-confirm" type="password" class="form-control border border-2 border-243c92 rounded-halfpill " onkeyup='check()' oninput="span(this,'spancpassword','fne')" name="password_confirmation" placeholder="Confirm Password" required autocomplete="off">
                                </div>
                                <span id='message'></span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div style="color:navy; display: block;">Note : Please ensure the accuracy of the email address and password before proceeding.</div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label childname">Declaration: </label><span class="error-star" style="color:red;">*</span>
                                <div>
                                    <textarea class="form-control border border-2 border-243c92 rounded-halfpill" disabled>I hereby declare that the entries made by me in the Application Form are complete and true to my knowledge.</textarea>
                                </div>
                                <div style="font-size: 18px;justify-content: left;display: flex;"><input type="checkbox" class="" style="display: block;margin: 5px;width:18px;height: 18px;" name="declaration" id="declaration"> I Agree </div>
                            </div>
                        </div>

                        <div class="col-md-12" style="display: flex;justify-content: center;margin: 0 0 5px 0;">
                            {!! app('captcha')->display() !!}
                        </div>
                    </div>

                    <div class="col-md-12 text-center">
                        <a type="button" onclick="submit('submitted')" id="submitbutton" class="btn btn-labeled btn-succes disable-click" title="Submit" style="background: gray !important; color:white !important;">
                            <span class="btn-label" style="font-size:13px !important;"><i class="fa fa-check"></i></span>Submit</a>
                        <button class="btn btn-primary" type="reset" title="Clear"><i class="fa fa-undo"></i>Clear</button>
                    </div>

                </div>
            </form>
        </div>
    </div>
</div>
<script>
    var phone_number = document.querySelector("#child_contact_phone");
    var phone_number2 = document.querySelector("#child_alter_phone");

    var iti = window.intlTelInput(phone_number, {
        initialCountry: "in",
        separateDialCode: true,
        utilsScript: "//cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.3/js/utils.js"
    });

    var iti = window.intlTelInput(phone_number2, {
        initialCountry: "in",
        separateDialCode: true,
        utilsScript: "//cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.3/js/utils.js"
    });
</script>
<script>
    const checkbox = document.getElementById("declaration");
    const acceptButton = document.getElementById("submitbutton");

    checkbox.addEventListener("change", () => {
        if (checkbox.checked) {
            swal("Please click on the submit button to proceed for Payment.");
            acceptButton.style.backgroundColor = "green";
            acceptButton.style.pointerEvents = "";
        } else {
            swal({
                title: "To proceed with further processing,</br> please check the <b>'I Agree'</b> box.",
                html: "You must <b>agree</b> and click the submit button to proceed further",
                icon: "info",
            });
            acceptButton.style.backgroundColor = "gray";
            acceptButton.style.pointerEvents = "";
        }
    });
</script>
<script language="javascript">
    var today = new Date();
    var dd = String(today.getDate()).padStart(2, '0');
    var mm = String(today.getMonth() + 1).padStart(2, '0');
    var yyyy = today.getFullYear();

    today = yyyy + '-' + mm + '-' + dd;
    $('#date_of_stay_from').attr('min', today);
    $('#date_of_stay_to').attr('min', today);
</script>
<script type="text/javascript">
    // child_dob.max = new Date().toISOString().split("T")[0];
    $(function() {
        $('.child_dob').datepicker({
            dateFormat: 'dd/mm/yy',
            maxDate: 0,
            yearRange: "-24:+0",
            changeMonth: true,
            changeYear: true,
        });
    });
</script>
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

    function span(a1, b, c) {
        var a = a1.value;
        a = removeURLs(a);
        if (urlPattern.test(a)) {
            a1.value = "";
            return false;
        }
        if (c == "fnu") {
            let value = event.target.value || '';
            value = value.replace(/[^0-9+ ]/, '', );
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
        completeCheck(3);
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

    function spanemail() {
        var get_email = $('#child_contact_email').val();
        //get_email = removeURLs(get_email);
        // if (urlPattern.test(get_email)) {
        // $('#child_contact_email').val('');
        // return false;
        // }console.log(get_email);
        $('#child_contact_email').val(get_email);
        document.getElementById("email").innerHTML = get_email;
        document.getElementById('email').value = get_email;
        validateDublication();
        completeCheck(1);
    }

    function spanmobile() {
        var get_phone = $('#child_contact_phone').val();
        document.getElementById("mobile_no").innerHTML = get_phone;
        document.getElementById('mobile_no').value = get_phone;

    }

    var check = function() {
        alert("dfd");
        if (document.getElementById('password').value == document.getElementById('password_confirmation').value) {

            document.getElementById('message').style.color = 'green';
            document.getElementById('message').innerHTML = '';
        } else {

            document.getElementById('message').style.color = 'red';
            document.getElementById('message').innerHTML = 'Passwords do not match';
        }
    }


    var check = function() {
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

        if (pwd_format == true) {
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
    $(document).ready(function() {
        const togglePasswords = document.querySelectorAll('#togglePassword');
        const password = document.querySelector('#password');

        
        togglePasswords.forEach(function(togglePassword) {
            togglePassword.addEventListener('click', function(e) {
                const type = password.getAttribute('type') == 'password' ? 'text' : 'password';
                password.setAttribute('type', type);
                this.classList.toggle('fa-eye-slash');
                this.classList.toggle('fa-eye');

                // setTimeout(function() {
                //     password.setAttribute('type', 'password');
                //     togglePassword.classList.remove('fa-eye');
                // }, 10000);
            });
            document.addEventListener('click', function(event) {
                const target = event.target;
                const isClickInside1 = password.contains(target) || togglePassword[0].contains(target);
                if (isClickInside1 == "false") {
                    togglePassword.classList.remove('fa-eye-slash');
                }
            });

    });
        

        // 
        const togglePassword1 = document.querySelector('#togglePassword1');
        const passwordconfirm = document.querySelector('#password-confirm');

        togglePassword1.addEventListener('click', function(e) {
            const type = passwordconfirm.getAttribute('type') == 'password' ? 'text' : 'password';
            passwordconfirm.setAttribute('type', type);
            this.classList.toggle('fa-eye-slash');
            this.classList.toggle('fa-eye');

            // setTimeout(function() {
            //     passwordconfirm.setAttribute('type', 'password');
            //     togglePassword1.classList.remove('fa-eye');
            // }, 10000);
        });
        // Event listener to hide eye icon when clicked outside the password input field
        document.addEventListener('click', function(event) {
            const target = event.target;
            const isClickInside = passwordconfirm.contains(target) || togglePassword1.contains(target);
            
            if (isClickInside == "false") {
                togglePassword1.classList.remove('fa-eye-slash');
            }
        });

    });
</script>

<script type="application/javascript">
    const urlPattern = /^(https?:\/\/)?(localhost|[\w-]+(\.[\w-]+)+\/?)([^\s]*)?$/;

    function removeURLs(text) {
        const urlPattern = /(https?:\/\/\S+)/g;
        return text.replace(urlPattern, '');
    }

    function childName(event) {
        document.getElementById('invalid-childName').style.display = 'none';
        let value = event.target.value || '';
        value = removeURLs(value);
        if (urlPattern.test(value)) {
            event.target.value = "";
            return false;
        }
        value = value.replace(/[^a-z A-Z ]/, '', );
        if (value != event.target.value) {
            document.getElementById('invalid-childName').style.display = 'inline';
        }
        event.target.value = value;
        // childName
        validateDublication();
        completeCheck(1);
    }

    function childfatherName(event) {
        document.getElementById('invalid-childfatherName').style.display = 'none';
        let value = event.target.value || '';
        value = removeURLs(value);
        if (urlPattern.test(value)) {
            event.target.value = "";
            return false;
        }
        value = value.replace(/[^a-z A-Z ]/, '', );
        if (value != event.target.value) {
            document.getElementById('invalid-childfatherName').style.display = 'inline';
        }
        event.target.value = value;
        document.getElementById('name').value = value;
        completeCheck(1);
    }

    function childmotherName(event) {
        document.getElementById('invalid-childmotherName').style.display = 'none';
        let value = event.target.value || '';
        value = removeURLs(value);
        if (urlPattern.test(value)) {
            event.target.value = "";
            return false;
        }
        value = value.replace(/[^a-z A-Z ]/, '', );
        if (value != event.target.value) {
            document.getElementById('invalid-childmotherName').style.display = 'inline';
        }
        event.target.value = value;
        completeCheck(1);

    }

    function contactphonenumber(event) {
        let value = event.target.value || '';
        value = removeURLs(value);
        if (urlPattern.test(value)) {
            event.target.value = "";
            return false;
        }
        value = value.replace(/[^0-9+ ]/, '', );
        event.target.value = value;
        var get_phone = $('#child_contact_phone').val();
        var p1 = window.intlTelInputGlobals.getInstance(phone_number).isValidNumber();
        if (p1 == true) {
            document.getElementById('phone_message').style.color = 'green';
            document.getElementById('phone_message').innerHTML = 'Valid Number';
        } else {
            document.getElementById('phone_message').style.color = 'red';
            document.getElementById('phone_message').innerHTML = 'Invalid Number';
        }

        document.getElementById("mobile_no").innerHTML = get_phone;
        document.getElementById('mobile_no').value = get_phone;
        completeCheck(1);
    }

    function contactphonenumber1(event) {
        let value = event.target.value || '';
        value = removeURLs(value);
        if (urlPattern.test(value)) {
            event.target.value = "";
            return false;
        }
        value = value.replace(/[^0-9+ ]/, '', );
        event.target.value = value;
        var p2 = window.intlTelInputGlobals.getInstance(phone_number2).isValidNumber();
        if (p2 == true) {
            document.getElementById('phone_message2').style.color = 'green';
            document.getElementById('phone_message2').innerHTML = 'Valid Number';
        } else {
            document.getElementById('phone_message2').style.color = 'red';
            document.getElementById('phone_message2').innerHTML = 'Invalid Number';
        }
        completeCheck(1);
    }

    function hasUpperCase(str) {
        return str !== str.toLowerCase();
    }
    var validate = 0;

    function validateDublication() {
        var InputName = $('#child_name').val();
        var InputEmail = $('#child_contact_email').val();
        var InputDoB = $('#child_dob').val();
        // console.log(InputName, InputEmail , InputDoB);
        if (InputName != "" && InputDoB != "") {
            $.ajax({
                url: "{{ url('/validate/enrollment/user') }}",
                type: 'POST',
                data: {
                    'InputName': InputName,
                    'InputDoB': InputDoB,
                    _token: '{{csrf_token()}}'
                }
            }).done(function(data) {
                // console.log(data);
                validate = data;
            })
        }
        completeCheck(1);
    }

    function submit() {
        if (validate == 1) {
            swal("You have Already Enrolled With Elina", "", "error");
            return false;
        }
        var child_name = $('#child_name').val();
        if (child_name == '') {
            swal("Please Enter Child's Name", "", "error");
            return false;
        }

        var child_dob = $('#child_dob').val();
        if (child_dob == '') {
            swal("Please Enter Child's Date of Birth", "", "error");
            return false;
        }

        var child_school_name_address = $('#child_school_name_address').val();
        const childSchoolSelected = document.getElementById("child_school");
        if (childSchoolSelected.value === ""){
            swal("Please Enter Child's school", "", "error");
            return false;
        }

        if (childSchoolSelected.value === "others"){
            if (child_school_name_address == '') {
            swal("Please Enter Child's current school name and address", "", "error");
            return false;
        }
        }

        var child_gender = $('input[name="child_gender"]:checked').val();
        if (child_gender !== "Male" && child_gender !== "Female") {
            swal("Please Select Child's Gender", "", "error");
            return false;
        }

        var child_father_guardian_name = $('#child_father_guardian_name').val();
        // if (child_father_guardian_name == '') {
        //     swal("Please Enter Child's Father/ Guardian Name", "", "error");
        //     return false;
        // }

        var child_mother_caretaker_name = $('#child_mother_caretaker_name').val();
        // if (child_mother_caretaker_name == '') {
        //     swal("Please Enter Child's Mother/Primary caretaker's Name", "", "error");
        //     return false;
        // }
        var expectation = $('#services_from_elina').val();

        var child_contact_email = $('#child_contact_email').val();
        if (child_contact_email == '') {
            swal("Please Enter Email Address", "", "error");
            return false;
        }

        let testemail = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
        if (!testemail.test(child_contact_email)) {
            swal("Please Enter Valid Email Adress", "", "error");
            return false;
        }

        var child_contact_address = $('#child_contact_address').val();
        if (child_contact_address == '') {
            swal("Please Enter Address", "", "error");
            return false;
        }

        var child_contact_phone = $('#child_contact_phone').val();
        if (child_contact_phone == '') {
            swal("Please Enter Contact Phone number", "", "error");
            return false;
        }

        // let testmobile = /^[+0-9]{10,15}/;
        var p1 = window.intlTelInputGlobals.getInstance(phone_number).isValidNumber();
        if (p1 == false) {
            swal("Please Enter Valid Contact Number", "", "error");
            return false;
        }

        var child_alter_phone = $('#child_alter_phone').val();
        if (child_alter_phone != '') {
            var p2 = window.intlTelInputGlobals.getInstance(phone_number2).isValidNumber();
            if (p2 == false) {
                swal("Please Enter Valid Alternative Contact Number", "", "error");
                return false;
            }
        }

        if (child_contact_phone == child_alter_phone) {
            swal("Contact Number and Alternative Number should not be same", "", "error");
            return false;
        }
        if (expectation == '') {
            swal("Please Enter your expectation from Elina", "", "error");
            return false;
        }

        // var featured3 = document.getElementById("featured-3");
        // var featured4 = document.getElementById("featured-4");
        // var featured11 = document.getElementById("featured-11");
        // var featured12 = document.getElementById("featured-12");
        // var featured13 = document.getElementById("featured-13");

        // if ((featured3.checked == false) && (featured4.checked == false) && (featured11.checked == false) && (featured12.checked == false)) {
        //     swal("Please Select atleast one Question from Services from Elina", "", "error");
        //     return false;
        // }

        // if ((featured3.checked == false) && (featured4.checked == false) && (featured11.checked == false) && (featured12.checked == false) && (featured13.checked == false)) {
        //     swal("Please Select atleast one Question from Services from Elina", "", "error");
        //     return false;
        // }

        var featured5 = document.getElementById("featured-5");
        var featured6 = document.getElementById("featured-6");
        var featured7 = document.getElementById("featured-7");
        var featured8 = document.getElementById("featured-8");
        var featured9 = document.getElementById("featured-9");
        var featured10 = document.getElementById("featured-10");

        if ((featured5.checked == false) && (featured6.checked == false) && (featured7.checked == false) && (featured8.checked == false) && (featured9.checked == false) && (featured10.checked == false)) {
            swal("Please Select atleast one Qusetion from About Elina", "", "error");
            return false;
        }

        var name = $('#name').val();
        if (name == '') {
            swal("Please Enter Name", "", "error");
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

        var pwd_validation = /^(?=.*[0-9])(?=.*[!@#$%^&*])[a-zA-Z0-9!@#$%^&*]{8,16}$/;
        var pwd_check = pwd_validation.test(password);
        if (pwd_check == false) {
            swal("Please choose a strong password! ", "", "error");
            return false;
        }

        if (password != password_confirmation) {
            swal("Password Don't Match", "", "error");
            return false;
        }

        if (validate == 1) {
            swal("You have Already Enrolled With Elina", "", "error");
            return false;
        }

        var declaration = document.getElementById('declaration');
        if (!declaration.checked) {
            swal({
                title: "For further processing, you must agree and click the submit button to proceed further",
                html: "You must <b>agree</b> and click the submit button to proceed further",
                icon: "info",
            });
            return false;
        }

        var response = grecaptcha.getResponse();
        if (response.length == 0) {
            swal("Recaptcha Required", "", "error");
            return false;
        }

        swal({
                html: true,
                title: "<h5>Before you submit, please ensure the following<h5>",
                text: "<h6 class='enrollsubmit'><b>By clicking Yes, you will be registering with us which enables us to schedule a meeting with you to understand your requirements/concerns and also explain how we can be part of your journey.<br/>1. You have given an email ID and phone number that is active.<br/>2. You have gone through the Elina <a href='#' data-toggle='modal' data-target='#exampleModalCenter'>roadmap</a> to understand the processes that follow.<br/>Thank you! </b></h6>",
                // type: "warning",
                showCancelButton: false,
                confirmButtonColor: '#00a2ed',
                confirmButtonText: "Yes",
                // cancelButtonText: "No",
                reverseButtons: true,
                closeOnConfirm: false,
                closeOnCancel: false,
                showLoaderOnConfirm: true,
            },
            function(isConfirm) {

                if (isConfirm) {

                    document.getElementById("child_contact_phone").value = window.intlTelInputGlobals.getInstance(phone_number).getNumber();
                    if (child_alter_phone != '') {
                        document.getElementById("child_alter_phone").value = window.intlTelInputGlobals.getInstance(phone_number2).getNumber();
                    }

                    document.getElementById('newenrollement').submit('saved');
                } else {
                    swal.close();
                }
            });
    }
</script>
<script>
function toggleSchoolAddress() {
    const childSchoolSelect = document.getElementById("child_school");
    const divSchool = document.getElementById("divSchool");
    const schoolAddressTextarea = document.getElementById("child_school_name_address");
    
    if (childSchoolSelect.value === "others") {
        $('#divSchool').show()
    } else {
        $('#divSchool').hide() // Disable the textarea
        schoolAddressTextarea.value = ''; // Clear the textarea if not needed
    }
}
</script>





@include('enrollement.completeCheck')

@endsection