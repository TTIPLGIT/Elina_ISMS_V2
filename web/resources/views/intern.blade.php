@extends('layouts.internlayout')

@section('content')
<style>
    input[type=checkbox] {
        display: inline-block;
    }

    .no-arrow {
        -moz-appearance: textfield;
    }

    .no-arrow::-webkit-inner-spin-button {
        display: none;
    }

    .no-arrow::-webkit-outer-spin-button,
    .no-arrow::-webkit-inner-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }

    body {
        background-color: white !important;
    }

    label.internlabel {
        font-family: "Barlow Condensed", sans-serif !important;
    }
    .iti.iti--allow-dropdown.iti--separate-dial-code {
        width: 100%;
    }
</style>
<div class="main-content">
    <div class="row justify-content-center">
        <div class="col-lg-12 col-md-12" style="padding: 0;">
            <div class="card" style="height:100%; padding: 15px">
                @if (session('success'))
                <input type="hidden" name="session_data" id="session_data" class="session_data" value="{{ session('success') }}">
                <script type="text/javascript">
                    window.onload = function() {
                        var message = $('#session_data').val();
                        swal({
                            title: "Success",
                            text: message,
                            type: "success",
                        }, function() {
                            window.location.href = "{{Config::get('setting.web_portal')}}"
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
                <form action="{{route('internship.store')}}" method="POST" id="newenrollement" enctype="multipart/form-data" onsubmit="return false">
                    @csrf


                    <div class="tile" id="tile-1" style="margin-top:10px !important; margin-bottom:10px !important;">

                        <!-- Nav tabs -->
                        <ul class="nav nav-tabs nav-justified" id="tabs" role="tablist">
                            <div class="slider"></div>
                            <li class="nav-item">
                                <a class="nav-link active internlabel" style="font-size: 19px; font-family: 'Barlow Condensed', sans-serif;" id="home-tab" name="tab1" data-toggle="tab" role="tab" aria-controls="home" aria-selected="true">Personal Details </a>

                            </li>

                            <li class="nav-item">
                                <a class="nav-link internlabel" style="font-size: 19px; font-family: 'Barlow Condensed', sans-serif;" id="contact-tab" name="tab3" data-toggle="tab" role="tab" aria-controls="contact" aria-selected="false"><i class="fa fa-map-signs"></i>Attachments </a>
                            </li>


                        </ul>
                    </div>
                    <!-- Tab panes -->

                    <div class="tab-content" id="tab-content">
                        <div class="tab-pane fade show active" id="tab1" role="tabpanel" aria-labelledby="home-tab">


                            <section class="section">
                                <div class="section-body mt-1">
                                    <hr>
                                    <h5 style=" display:flex;   width: fit-content; padding: -13px;   margin-top: -32px;margin-left: auto;margin-right: auto;padding: 5px;background-color: white; font-family: 'Barlow Condensed', sans-serif;">Personal Details</h5>

                                    <div class="row">
                                        <input type="hidden" id="selected_id" name="selected_id" value="">

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="control-label internlabel" style="font-size: medium; font-family: 'Barlow Condensed', sans-serif;">Name: </label><span class="error-star" style="color:red;">*</span>
                                                <input class="form-control default" type="text" id="name" name="name" oninput="childName(event)" autocomplete="off" required>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="control-label internlabel" style="font-size: medium;font-family: 'Barlow Condensed', sans-serif;">Date of Birth:</label><span class="error-star" style="color:red;">*</span>
                                                <input class="form-control datepicker" type="date" id="date_of_birth" data-date-format="dd/mm/yyyy" value="" name="date_of_birth" autocomplete="off" required>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="control-label internlabel" style="font-size: medium;font-family: 'Barlow Condensed', sans-serif;">Contact Number: </label><span class="error-star" style="color:red;">*</span>
                                                <input class="form-control indent no-arrow" type="text" id="contact_number" name="contact_number" autocomplete="off" maxlength="10" inputmode="numeric" oninput="contactphonenumber(event)" value="" required>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="control-label internlabel" style="font-size: medium;font-family: 'Barlow Condensed', sans-serif;">Parent / Guardian Contact Number:</label><span class="error-star" style="color:red;">*</span>
                                                <input class="form-control indent no-arrow" type="text" id="parent_guardian_contact_number" name="parent_guardian_contact_number" maxlength="10" autocomplete="off" inputmode="numeric" oninput="contactphonenumber(event)" value="" required>




                                            </div>
                                        </div>

                                    </div>


                                    <hr>
                                    <h4 style=" font-family: 'Barlow Condensed', sans-serif; display:flex;   width: fit-content; padding: -13px;margin-top: -34px;margin-left: auto;margin-right: auto;padding: 5px;background-color: white;">Additional Details</h4>


                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label class="control-label internlabel" style="font-size: medium;font-family: 'Barlow Condensed', sans-serif;">When Could You Start Interning with Elina?<span class="error-star" style="color:red;">*</span></label>
                                                <input class="form-control datepicker" type="date" id="start_date_with_elina" data-date-format="dd/mm/yyyy" value="" name="start_date_with_elina" required autocomplete="off">
                                            </div>
                                        </div>
                                        <div class="col-md-5">
                                            <div class="form-group">
                                                <label class="control-label internlabel" style="font-size: medium;font-family: 'Barlow Condensed', sans-serif;">How Many Hours Can you Intern with Elina per week?<span class="error-star" style="color:red;">*</span></label>
                                                <input class="form-control default" type="text" id="hours_intern_elina_per_week" name="hours_intern_elina_per_week" maxlength="3" required autocomplete="off" oninput="validInput(event)">
                                            </div>
                                        </div>

                                        <div class="col-md-3">

                                            <div class="form-group">
                                                <label class="control-label internlabel" style="font-size: medium;font-family: 'Barlow Condensed', sans-serif;">Email Address:<span class="error-star" style="color:red;">*</span> </label>
                                                <input id="email_address" type="email" class="form-control indent @error('email') is-invalid @enderror" name="email_address" required autocomplete="off" oninput="validInput(event)">
                                                @error('email')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12 text-center">

                                    <button class="btn btn-primary" type="reset" title="Clear"><i class="fa fa-undo"></i> Clear</button>&nbsp;





                                    <a type="button" class="btn btn-labeled btn-info" onclick="DoAction('tab3');" title="Next" style="background: blue !important; border-color:#4d94ff !important; color:white !important">
                                        <span class="btn-label" style="font-size:13px !important;">Next <i class="fa fa-arrow-right"></i></a>

                                </div>
                            </section>

                        </div>
                        <div class="tab-pane fade show" id="tab2" role="tabpanel" aria-labelledby="addition-tab">



                            <section class="section">
                                <div class="section-body mt-1">
                                    <div class="row">




                                    </div>
                                </div>

                            </section>
                        </div>

                        <div class="tab-pane fade show" id="tab3" role="tabpanel" aria-labelledby="contact-tab">



                            <section class="section">
                                <div class="section-body mt-1">
                                    <div class="row">

                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="control-label internlabel" style="font-family: 'Barlow Condensed', sans-serif;">A Short Introduction about Yourself?<span class="error-star" style="color:red;">*</span> </label>

                                                <input class="form-control " type="file" id="short_introduction" name="short_introduction" value="" required autocomplete="off" accept=".image/*,.doc, .docx,.pdf" data-max-size="2000000">

                                                @error('short_introduction')
                                                <div class="error" style="color: red;">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="control-label internlabel" style="font-family: 'Barlow Condensed', sans-serif;">What do you know about Elina?<span class="error-star" style="color:red;">*</span> </label>

                                                <input class="form-control " type="file" id="about_elina" name="about_elina" value="" required autocomplete="off" accept=".image/*,.doc, .docx,.pdf" data-max-size="2000000">
                                                @error('about_elina')
                                                <div class="error" style="color: red;">{{ $message }}</div>
                                                @enderror

                                            </div>
                                        </div>

                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="control-label internlabel" style="font-family: 'Barlow Condensed', sans-serif;">What are you looking forward to while interning with Elina? <span class="error-star" style="color:red;">*</span></label>

                                                <input class="form-control " type="file" id="intern_with_elina" name="intern_with_elina" value="" required autocomplete="off" accept=".image/*,.doc, .docx,.pdf" data-max-size="2000000">

                                                @error('intern_with_elina')
                                                <div class="error" style="color: red;">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                    </div>
                                    <div style="color: rgb(246, 15, 15); display: block;">All File Size must be below 2MB. </br> Only Following extension files could be uploaded .PDF, MS Word, .JPG &amp; .JPEG.</div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label class="control-label childname">Declaration: </label><span class="error-star" style="color:red;">*</span>
                                                <textarea class="form-control border border-2 border-243c92 rounded-halfpill" disabled>I hereby declare that the details and information given above are complete and true to the best of my knowledge and I will abide by the policies of the organisation.</textarea>
                                                <input class="form-control " type="checkbox" id="agreement" name="agreement" value="Agreed" required autocomplete="off"><label for="agreement"> I Agree</label>
                                            </div>
                                        </div>
                                        <div class="col-md-12" style="display: flex;justify-content: center;margin: 0 0 5px 0;">
                                            {!! app('captcha')->display() !!}
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12 text-center">

                                    <a type="button" class="btn btn-labeled btn-info" onclick="DoAction('tab1');" title="Back" style="background: blue !important; border-color:blue !important; color:white !important">
                                        <span class="btn-label" style="font-size:13px !important;"><i class="fa fa-arrow-left"></i></span> Back</a>

                                    <a type="button" onclick="save()" id="submitbutton" class="btn btn-labeled btn-succes" title="Submit" style="background: green !important; border-color:green !important; color:white !important">
                                        <span class="btn-label" style="font-size:13px !important;"><i class="fa fa-check"></i></span> Submit</a>

                                    <button class="btn btn-primary" type="reset" title="Clear"><i class="fa fa-undo"></i> Clear</button>&nbsp;

                                </div>
                            </section>

                        </div>





                    </div>



                </form>
            </div>

        </div>
        <div class="col-md-12 text-center " style="    margin-top: 5px;">

        </div>
    </div>
</div>
<script language="javascript">

</script>

<script src="https://code.jquery.com/jquery-1.7.2.min.js"></script>

<script type="text/javascript">

</script>
<script>

</script>
<script>
    date_of_birth.max = new Date().toISOString().split("T")[0];
    start_date_with_elina.min = new Date().toISOString().split("T")[0];
</script>
<script type="application/javascript">
    $("#tile-1 .nav-tabs a").click(function() {

        var position = $(this).parent().position();
        var width = $(this).parent().width();
        $("#tile-1 .slider").css({
            "left": +position.left,
            "width": width
        });

        $("#tab-content").find("[id^='tab']").hide(); // Hide all content

        $('#' + $(this).attr('name')).fadeIn(); // Show content for the current tab

    });
    var actWidth = $("#tile-1 .nav-tabs").find(".active").parent("li").width();
    var actPosition = $("#tile-1 .nav-tabs .active").position();
    $("#tile-1 .slider").css({
        "left": +actPosition.left,
        "width": actWidth
    });


    function DoAction(id) {

        $("#tab-content").find("[id^='tab']").hide(); // Hide all content
        $("#tabs li").removeClass("active"); //Reset id's
        $("a[name='" + id + "']").parent().addClass("active");
        var position = $("a[name='" + id + "']").parent().position();
        var width = $("a[name='" + id + "']").parent().width();
        $("#tile-1 .slider").css({
            "left": +position.left,
            "width": width
        });
        $('#' + (id)).fadeIn(); // Show content for the current tab


    }
</script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const checkbox = document.getElementById("agreement");
        const acceptButton = document.getElementById("submitbutton");
        checkbox.addEventListener("change", () => {
            if (checkbox.checked) {
                swal("Please click on the submit button to proceed.");
                acceptButton.style.backgroundColor = "green";
                acceptButton.style.pointerEvents = "";
            } else {
                swal("For further processing, you must agree and click the submit button to proceed further");
                acceptButton.style.backgroundColor = "gray";
                acceptButton.style.pointerEvents = "";
            }
        });
    });
</script>
<script>
    // var phone_number = document.querySelector("#contact_number");
    // var phone_number2 = document.querySelector("#parent_guardian_contact_number");

    // var iti = window.intlTelInput(phone_number, {
    //     initialCountry: "in",
    //     separateDialCode: true,
    //     utilsScript: "//cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.3/js/utils.js"
    // });

    // var iti = window.intlTelInput(phone_number2, {
    //     initialCountry: "in",
    //     separateDialCode: true,
    //     utilsScript: "//cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.3/js/utils.js"
    // });
</script>
<script type="application/javascript">
    //validation
    const urlPatternValidator = /^(https?:\/\/)?(localhost|[\w-]+(\.[\w-]+)+\/?)([^\s]*)?$/;
    function removeURLs(text) {
        const urlPattern = /(https?:\/\/\S+)/g;
        return text.replace(urlPattern, '');
    }
    function childName(event) {
        let value = event.target.value || '';
        console.log(value);
        if (urlPatternValidator.test(value)) {
            event.target.value = "";
            return false;
        }
        value = removeURLs(value);
        // console.log(value1);
        value = value.replace(/[^a-z A-Z ]/, '', );
        event.target.value = value;

    }

    function childfatherName(event) {
        let value = event.target.value || '';
        if (urlPatternValidator.test(value)) {
            event.target.value = "";
            return false;
        }
        value = value.replace(/[^a-z A-Z ]/, '', );
        event.target.value = value;

    }

    function childmotherName(event) {
        let value = event.target.value || '';
        if (urlPatternValidator.test(value)) {
            event.target.value = "";
            return false;
        }
        value = value.replace(/[^a-z A-Z ]/, '', );
        event.target.value = value;

    }

    function contactphonenumber(event) {
        let value = event.target.value || '';
        value = value.replace(/[^0-9]/g, '');
        if (urlPatternValidator.test(value)) {
            event.target.value = "";
            return false;
        }
        value = value.replace(/[^0-9+ ]/, '', );
        event.target.value = value;

    }

    function validInput(event) {
        let value = event.target.value || '';
        if (urlPatternValidator.test(value)) {
            event.target.value = "";
            return false;
        }
    }

    function save() {


        var child_name = $('#name').val();

        if (child_name == '') {
            swal("Please Enter  Name ", "", "error");
            return false;
        }

        var child_dob = $('#date_of_birth').val();

        if (child_dob == '') {
            swal("Please Enter  Date of Birth", "", "error");
            return false;
        }

        var child_gender = $('input[name="child_gender"]:checked').val();

        var contact_number = $('#contact_number').val();
        if (contact_number == '') {
            swal("Please Enter Contact Number", "", "error");
            return false;
        }
        let testmobile = /^[+0-9]{10,15}/;
        if (!testmobile.test(contact_number)) {
            swal("Please Enter Valid Contact Number", "", "error");
            return false;
        }

        var parent_guardian_contact_number = $('#parent_guardian_contact_number').val();
        if (parent_guardian_contact_number == '') {
            swal("Please Enter Parent or Gaurdian Contact Number", "", "error");
            return false;
        }
        if (!testmobile.test(parent_guardian_contact_number)) {
            swal("Please Enter Valid Parent Contact Number", "", "error");
            return false;
        }

        if (contact_number == parent_guardian_contact_number) {
            swal("Parent Number and Contact Number should not be same", "", "error");
            return false;
        }
        var child_father_guardian_name = $('#start_date_with_elina').val();

        if (child_father_guardian_name == '') {
            swal("Please Enter When could you start interning with Elina  ", "", "error");
            return false;
        }
        var hours_intern_elina_per_week = $('#hours_intern_elina_per_week').val();

        if (hours_intern_elina_per_week == '') {
            swal("Please Enter How many hours can you intern with Elina per week  ", "", "error");
            return false;
        }
        var email_address = $('#email_address').val();

        if (email_address == '') {
            swal("Please Enter Email Adress", "", "error");
            return false;

        }
        let testemail = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;

        if (!testemail.test(email_address)) {
            swal("Please Enter Valid Email Adress", "", "error");
            return false;

        }

        var short_intro = document.getElementById('short_introduction').files.length;
        if (short_intro == 0) {
            swal("Please Choose file in Short Inroduction  ", "", "error");
            return false;
        }

        var short_introext = document.getElementById('short_introduction').value;
        var ext = short_introext.split('.').pop();
        if (ext != "pdf" && ext != "docx" && ext != "doc") {
            swal("Please Upload Valid File Format in Short Inroduction", "", "error");
            return false;
        }
        //
        var fileInput = $('#short_introduction');
        var maxSize = fileInput.data('max-size');
        var fileSize = fileInput.get(0).files[0].size;
        if (fileSize > maxSize) {
            swal("File size is more than 2MB in Short Inroduction", "", "error");
            return false;
        }
        //

        var about_elina = document.getElementById('about_elina').files.length;
        if (about_elina == 0) {
            swal("Please Choose file in About Elina  ", "", "error");
            return false;
        }
        var about_elina = document.getElementById('about_elina').value;
        var ext1 = about_elina.split('.').pop();
        if (ext1 != "pdf" && ext1 != "docx" && ext1 != "doc") {
            swal("Please Upload Valid File Format in About Elina", "", "error");
            return false;
        }
        //
        var fileInput2 = $('#about_elina');
        var maxSize2 = fileInput2.data('max-size');
        var fileSize2 = fileInput2.get(0).files[0].size;
        if (fileSize2 > maxSize2) {
            swal("File size is more than 2MB in About Elina", "", "error");
            return false;
        }
        //

        var intern_with_elina = document.getElementById('intern_with_elina').files.length;
        if (intern_with_elina == 0) {
            swal("Please Choose file in Intern with Elina  ", "", "error");
            return false;
        }
        var intern_with_elina = document.getElementById('intern_with_elina').value;
        var ext2 = intern_with_elina.split('.').pop();
        if (ext2 != "pdf" && ext2 != "docx" && ext2 != "doc") {
            swal("Please Upload Valid File Format in Intern with Elina", "", "error");
            return false;
        }
        //
        var fileInput3 = $('#intern_with_elina');
        var maxSize3 = fileInput3.data('max-size');
        var fileSize3 = fileInput3.get(0).files[0].size;
        if (fileSize3 > maxSize3) {
            swal("File size is more than 2MB in Intern with Elina", "", "error");
            return false;
        }
        //
        if (!$('#agreement').is(':checked')) {
            swal("For further processing, you must agree and click the submit button to proceed further");
            return false;
        }

        var response = grecaptcha.getResponse();
        if (response.length == 0) {
            swal("Recaptcha Required", "", "error");
            return false;
        }
        swal({
                html: true,
                title: "Are you sure you want to submit this Form?",
                // text: "<h5><b>Please click 'Yes', you will be successfully enrolled, Consent form will be sent to your registered mail and it will take to the User Registration Page. Use your mail id as your 'User Id' you used during the 'Enrollment Process' and enjoy the Integrated Solution Management System (ISMS) advantage. Next step will be a payment process for the ISMS Registration.</b></h5>",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: '#00a2ed',
                confirmButtonText: "Yes",
                cancelButtonText: "No",
                reverseButtons: true,
                closeOnConfirm: false,
                closeOnCancel: false,
                showLoaderOnConfirm: true,
            },
            function(isConfirm) {

                if (isConfirm) {
                    document.getElementById('newenrollement').submit('saved');
                } else {
                    swal.close();
                }
            });



    }
</script>
@endsection