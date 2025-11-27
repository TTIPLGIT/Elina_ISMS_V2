@extends('layouts.adminnav')

@section('content')
<style>
    input[type=checkbox] {
        display: inline-block;

    }

    .nav-tabs {
        background-color: #0068a7 !important;
        border-radius: 29px !important;
        padding: 1px !important;

    }

    .nav-item.active {
        background-color: #0e2381 !important;
        border-radius: 31px !important;
        height: 100% !important;
    }

    .nav-link.active {
        background-color: #0e2381 !important;
        border-radius: 31px !important;
        height: 100% !important;
    }

    .nav-justified {
        display: flex !important;
        align-items: center !important;
    }

    hr {
        border-top: 1px solid #6c757d !important;
    }

    .dateformat {
        height: 41px;
        padding: 8px 10px !important;
        width: 100%;
        border-radius: 5px !important;
        border-color: #bec4d0 !important;
        box-shadow: 2px 2px 4px rgb(0 0 0 / 15%);
        border-style: outset;
    }

    .page {
        /* padding: 50px 80px; */
        margin: 50px;
        background: white;
        /* box-shadow: 2px 2px 2px rgba(0, 0, 0, 0.6); */
        /* max-width: 800px; */
        /* min-width: 500px; */
    }

    .container {
        display: flex;
        flex-direction: column;
        box-sizing: border-box;
        max-height: 500px !important;
    }

    .container__heading {
        padding: 1rem 0;
        border-bottom: 1px solid #ccc;
        text-align: center;
    }

    .container__heading>h2 {
        font-size: 1.75rem;
        line-height: 1.75rem;
        margin: 0;
    }

    .container__content {
        flex-grow: 1;
        overflow-y: scroll;
        margin: 25px;
    }

    .container__nav {
        border-top: 1px solid #ccc;
        text-align: center;
        font-size: 16px;
        font-weight: bold;
        padding: 2rem 0 1rem;
    }

    .container__nav1 {
        border-top: 1px solid #ccc;
    }

    .container__nav>.button {
        background-color: #444499;
        box-shadow: 0rem 0.5rem 1rem -0.125rem rgba(0, 0, 0, 0.25);
        padding: 0.8rem 2rem;
        border-radius: 0.5rem;
        color: #fff;
        text-decoration: none;
        font-size: 0.9rem;
        transition: transform 0.25s, box-shadow 0.25s;
    }

    .container__nav>.button:hover {
        box-shadow: 0rem 0rem 1rem -0.125rem rgba(0, 0, 0, 0.25);
        transform: translateY(-0.5rem);
    }

    .container__nav>small {
        color: #777;
        margin-right: 1rem;
    }

    .hidden {
        display: none;
    }

    .phoneStyle {
        padding-left: 83px;
        border-radius: 5px !important;
        border-color: #bec4d0 !important;
        box-shadow: 2px 2px 4px rgba(0, 0, 0, 0.15);
        border-style: outset;
        height: 40px;
        display: block;
        font-size: 1rem;
        font-weight: 400;
        line-height: 1.5;
        color: #495057;
        background-color: #fff;
        background-clip: padding-box;
        border: 1px solid #ced4da;
        border-radius: 0.25rem;
        -webkit-transition: border-color .15s ease-in-out, -webkit-box-shadow .15s ease-in-out;
        transition: border-color .15s ease-in-out, -webkit-box-shadow .15s ease-in-out;
        transition: border-color .15s ease-in-out, box-shadow .15s ease-in-out;
        transition: border-color .15s ease-in-out, box-shadow .15s ease-in-out, -webkit-box-shadow .15s ease-in-out;
    }
</style>
<div class="main-content">
    {{ Breadcrumbs::render('newenrollment.create') }}
    <h5 class="text-center" style="color:darkblue">New Enrollment</h5>

    <div class="row justify-content-center">
        <div class="col-lg-12 col-md-12">

            <div class="card" style="height:100%; padding: 15px; background-color:white">
                <form action="{{route('newenrollment.store')}}" method="POST" id="newenrollement" enctype="multipart/form-data">
                    @csrf

                    <input type="hidden" id="btn_status" name="btn_status" value="">

                    <div class="tile" id="tile-1" style="margin-top:10px !important; margin-bottom:10px !important;">

                        <!-- Nav tabs -->
                        <ul class="nav nav-tabs nav-justified" style="width:75%; margin:auto;" id="tabs" role="tablist">

                            <li class="nav-item" class="active">
                                <a class="nav-link" style="border: none;cursor: pointer;" id="home-tab" name="tab1" data-toggle="tab" role="tab" aria-controls="home" aria-selected="true"><i class="fa fa-home"></i><b style="padding: 2px;">Personal Details</b> <input type="checkbox" class="checkg" id="gencheckbox" name="nationality" value="0" onchange="submitval(this)" readonly style="background-color:solid green !important; color:green !important; visibility:hidden !important; ">
                                    <div class="check"></div>
                                </a>

                            </li>

                            <li class="nav-item" class="">
                                <a class="nav-link" style="border: none;cursor: pointer;" id="contact-tab" name="tab2" data-toggle="tab" role="tab" aria-controls="contact" aria-selected="false"><i class="fas fa-map-signs"></i><b>General Questions</b> <input type="checkbox" class="checkg" id="expcheckbox" name="nationality" value="0" onchange="submitval(this)" style="background-color:solid green !important; color:green !important; visibility:hidden !important; ">
                                    <div class="check"></div>
                                </a>
                            </li>

                            <li class="nav-item" class="">
                                <a class="nav-link" style="border: none;cursor: pointer;" id="contact-tab" name="tab3" data-toggle="tab" role="tab" aria-controls="contact" aria-selected="false"><i class="fas fa-map-signs"></i><b>Consent Form</b> <input type="checkbox" class="checkg" id="expcheckbox" name="nationality" value="0" onchange="submitval(this)" style="background-color:solid green !important; color:green !important; visibility:hidden !important; ">
                                    <div class="check"></div>
                                </a>
                            </li>


                        </ul>
                    </div>
                    <br>



                    <!-- Tab panes -->

                    <div class="tab-content" id="tab-content">
                        <div class="tab-pane fade show active" id="tab1" role="tabpanel" aria-labelledby="home-tab">
                            @if(Session::has('message'))
                            <div class="alert alert-{{session('message')['type']}}">
                                {{session('message')['text']}}
                            </div>
                            @endif
                            <section class="section">
                                <div class="section-body mt-1">
                                    <hr>
                                    <h5 style="font-weight: bold; display:flex;   width: fit-content; padding: -13px;margin-top: -18px;margin-left: auto;margin-right: auto;padding: 5px;background-color: white;">Child Enrollment Details</h5>

                                    <div class="row">

                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label class="control-label" style="font-size: medium;">Child's Name: </label><span class="error-star" style="color:red;">*</span>
                                                <input class="form-control default" type="text" id="child_name" name="child_name" oninput="childName(event)" maxlength="50" value="" autocomplete="off">
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label class="control-label" style="font-size: medium;">Child's Date of Birth:</label><span class="error-star" style="color:red;">*</span>
                                                <input type="text" class="form-control default dob_field" placeholder="DD/MM/YYYY" autocomplete="off" id="child_dob" name="child_dob" oninput="validateDublication()" onchange="validateDublication()">
                                                {{--<input placeholder="dd-mm-yyyy" class="form dateformat child_dob" type="text" onfocus="(this.type='date')" id="child_dob" name="child_dob">--}}
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label class="control-label" style="font-size: medium;">Child's Gender:</label><span class="error-star" style="color:red;">*</span>
                                                <br>
                                                <input type="radio" id="child_gender" name="child_gender" value="Male"><label for="featured-1" style="padding: 5px;">Male</label>


                                                <input type="radio" id="child_gender" name="child_gender" value="Female"><label for="featured-2" style="padding: 5px;">Female</label>






                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="control-label" style="font-size: medium;">Child's Current School Name and Address: </label><span class="error-star" style="color:red;">*</span>
                                                <textarea class="form-control default child_school_name_address" type="textarea" id="child_school_name_address" name="child_school_name_address" value="" autocomplete="off"></textarea>
                                            </div>
                                        </div>

                                    </div>

                                    <hr>
                                    <h5 style="font-weight: bold; display:flex;   width: fit-content; padding: -13px;margin-top: -18px;margin-left: auto;margin-right: auto;padding: 5px;background-color: white;">Contact Details</h5>


                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="control-label" style="font-size: medium;">Child's Father/Guardian Name: </label>
                                                <input class="form-control default" type="text" id="child_father_guardian_name" name="child_father_guardian_name" oninput="childfatherName(event)" maxlength="50" value="" autocomplete="off">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="control-label" style="font-size: medium;">Child's Mother/Primary Caretaker's Name</label>
                                                <input class="form-control default" type="text" id="child_mother_caretaker_name" name="child_mother_caretaker_name" oninput="childmotherName(event)" maxlength="50" value="" autocomplete="off">
                                            </div>
                                        </div>






                                    </div>



                                    <div class="row">


                                        <div class="col-md-4">

                                            <div class="form-group">
                                                <label class="control-label" style="font-size: medium;">Email Address: </label><span class="error-star" style="color:red;">*</span>
                                                <input id="child_contact_email" type="email" class="form-control default @error('email') is-invalid @enderror readonly" name="child_contact_email" value="{{$email[0]['email'] }}" readonly>
                                                @error('email')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label class="control-label" style="font-size: medium;">Contact Phone Number: </label><span class="error-star" style="color:red;">*</span>
                                                <input class="phoneStyle readonly" type="text" id="child_contact_phone" name="child_contact_phone" autocomplete="off" inputmode="numeric" oninput="contactphonenumber(event , 'one')" value="{{$email[0]['mobile_no'] }}" readonly>
                                                <br><span id='phone_message_one'></span>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label class="control-label" style="font-size: medium;">Alternative Phone Number: </label>
                                                <input class="phoneStyle default" type="text" id="child_alter_phone" name="child_alter_phone" autocomplete="off" inputmode="numeric" oninput="contactphonenumber(event,'two')" value="">
                                                <br><span id='phone_message_two'></span>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="control-label" style="font-size: medium;">Address: </label><span class="error-star" style="color:red;">*</span>
                                                <textarea class="form-control default" type="textarea" id="child_contact_address" name="child_contact_address" value="" autocomplete="off"></textarea>

                                            </div>

                                        </div>



                                    </div>



                                </div>

                                <div class="col-md-12 text-center">
                                    <a type="button" onclick="save('submitted')" id="submitbutton" class="btn btn-labeled btn-succes" title="save" style="background: green !important; border-color:green !important; color:white !important">
                                        <span class="btn-label" style="font-size:13px !important;"><i class="fa fa-check"></i></span> Save</a>


                                    <!-- <button class="btn btn-primary" type="reset" style="height: 32px;"><i class="fa fa-undo"></i> Clear</button>&nbsp; -->

                                    <a type="button" class="btn btn-labeled btn-info" onclick="DoAction('tab2');" title="Next" style="background: #4d94ff !important; border-color:#4d94ff !important; color:white !important">
                                        <span class="btn-label" style="font-size:13px !important;"><i class="fa fa-arrow-right"></i></span>Next</a>


                                </div>
                            </section>

                        </div>
                        <div class="tab-pane fade show" id="tab2" role="tabpanel" aria-labelledby="contact-tab">



                            <section class="section">
                                <div class="section-body mt-1">
                                    <div class="row">
                                        <!-- <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="control-label" style="font-weight: bold;">Q1.Service that you would want to avail from Elina? </label><span class="error-star" style="color:red;">*</span>
                                                <label for="featured-3" style="padding: 5px;display:flex"> <input type="checkbox" id="featured-3" name="services_from_elina[]" value="Consultancy and Referal" onchange="addval(this)" style="margin-right: 0.3rem!important;">Consultancy and Referal</label>
                                                <label for="featured-4" style="padding: 5px;display:flex"> <input type="checkbox" id="featured-4" name="services_from_elina[]" value="Assesment and Recommendation" onchange="addval(this)" style="margin-right: 0.3rem!important;">Assesment and Recommendation</label>
                                                <label for="featured-11" style="padding: 5px;display:flex"><input type="checkbox" id="featured-11" name="services_from_elina[]" value="Integrated 8 month Program" onchange="addval(this)" style="margin-right: 0.3rem!important;">Integrated 8 month Program</label>
                                                <label for="featured-12" style="padding: 5px;display:flex"><input type="checkbox" id="featured-12" name="services_from_elina[]" value="Dream Mapping" onchange="addval(this)" style="margin-right: 0.3rem!important;">Dream Mapping</label>
                                                <label for="featured-13" style="padding: 5px;display:flex"><input type="checkbox" id="featured-13" name="services_from_elina[]" value="Through HLC Admission" onchange="addval(this)" style="margin-right: 0.3rem!important;">Through HLC Admission</label>
                                            </div>
                                        </div> -->
                                        <div class="col-md-6">
                                            <div class="form-group questions">
                                                <label class="control-label">Q1.What is your expectation from Elina?</label><span class="error-star" style="color:red;">*</span>
                                                <textarea class="form-control default expectation" type="text" id="expectation" name="expectation" value="" autocomplete="off" oninput="completeCheck(1)"></textarea>

                                            </div>
                                        </div>


                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="control-label" style="font-weight: bold;">Q2.How did you come to know about Elina? </label><span class="error-star" style="color:red;">*</span>


                                                <label for="featured-5" style="padding: 5px;display:flex"><input type="checkbox" id="featured-5" name="how_knowabt_elina[]" value="From a Friend" onchange="addval(this)" style="margin-right: 0.3rem!important;">From a Friend</label>

                                                <label for="featured-6" style="padding: 5px;display:flex"><input type="checkbox" id="featured-6" name="how_knowabt_elina[]" value="Recommended by Child's therapist" Fonchange="addval(this)" style="margin-right: 0.3rem!important;">Recommended by Child's therapist</label>

                                                <label for="featured-7" style="padding: 5px;display:flex"><input type="checkbox" id="featured-7" name="how_knowabt_elina[]" value="Through Elina's Website" onchange="addval(this)" style="margin-right: 0.3rem!important;">Through Elina's Website</label>

                                                <label for="featured-8" style="padding: 5px;display:flex"><input type="checkbox" id="featured-8" name="how_knowabt_elina[]" value="Through HLC Admission" onchange="addval(this)" style="margin-right: 0.3rem!important;">Through HLC Admission</label>

                                                <label for="featured-9" style="padding: 5px;display:flex"><input type="checkbox" id="featured-9" name="how_knowabt_elina[]" value="Through Facebook and Social Media" onchange="addval(this)" style="margin-right: 0.3rem!important;">Through Facebook and Social Media</label>

                                                <label for="featured-10" style="padding: 5px;display:flex"><input type="checkbox" id="featured-10" name="how_knowabt_elina[]" value="Through Beyond 8" onchange="addval(this)" style="margin-right: 0.3rem!important;">Through Beyond 8</label>



                                            </div>
                                        </div>







                                    </div>
                                </div>
                                <div class="col-md-12 text-center">

                                    <a type="button" class="btn btn-labeled btn-info" onclick="DoAction('tab1');" title="Back" style="background: blue !important; border-color:blue !important; color:white !important">
                                        <span class="btn-label" style="font-size:13px !important;"><i class="fa fa-arrow-left"></i></span> Back</a>

                                    <a type="button" onclick="save('submitted')" id="submitbutton" class="btn btn-labeled btn-succes" title="save" style="background: green !important; border-color:green !important; color:white !important">
                                        <span class="btn-label" style="font-size:13px !important;"><i class="fa fa-check"></i></span> Save</a>


                                    <!-- <button class="btn btn-primary" type="reset" style="height: 32px;"><i class="fa fa-undo"></i> Clear</button>&nbsp; -->

                                    <a type="button" class="btn btn-labeled btn-info" onclick="DoAction('tab3');" title="Next" style="background: #4d94ff !important; border-color:#4d94ff !important; color:white !important">
                                        <span class="btn-label" style="font-size:13px !important;"><i class="fa fa-arrow-right"></i></span>Next</a>

                                </div>
                            </section>

                        </div>



                        <!-- Consent Form Tab -->
                        <div class="tab-pane fade show" id="tab3" role="tabpanel" aria-labelledby="contact-tab">
                            <div class="container">
                                <div class="container__nav1"></div>
                                <div class="container__content" id="terms-and-conditions">
                                    {!! $consent[0]['policy_content'] !!}
                                </div>

                            </div>
                            <div class="container__nav">
                                <label id="accept-label" /*class="hidden" * />
                                <input type="checkbox" name="consent_aggrement" value="Agreed" id="accept-checkbox" style="margin-right: 0.3rem!important;">I have read and accept the terms and conditions.
                                </label>
                            </div>
                            <div class="col-md-12 text-center">
                                <a type="button" class="btn btn-labeled btn-info" onclick="DoAction('tab2');" title="Back" style="background: blue !important; border-color:blue !important; color:white !important">
                                    <span class="btn-label" style="font-size:13px !important;"><i class="fa fa-arrow-left"></i></span> Back</a>
                                <a type="button" onclick="submit('submitted')" id="accept-button" class="btn btn-labeled btn-succes disable-click" title="Submit" style="background: green !important; border-color:green !important; color:white !important">
                                    <span class="btn-label" style="font-size:13px !important;"><i class="fa fa-check"></i></span> Submit</a>
                                <!-- <button class="btn btn-primary" type="reset" style="height: 32px;"><i class="fa fa-undo"></i> Clear</button>&nbsp; -->
                            </div>

                        </div>
                        <!-- End Tab -->

                    </div>



                </form>
            </div>

        </div>
        <div class="col-md-12 text-center " style="    margin-top: 5px;">

        </div>
    </div>
</div>



<script>
    const termsContainer = document.querySelector('.container__content');
    const acceptLabel = document.querySelector('#accept-label');
    const checkbox = document.getElementById("accept-checkbox");
    const acceptButton = document.getElementById("accept-button");

    checkbox.addEventListener("change", () => {
        if (checkbox.checked) {
            // alert("You have accepted the terms and conditions.");
            swal.fire("You have accepted the terms and conditions. Please click on the submit button to proceed further.", "", "info");
            document.getElementById('accept-button').style.backgroundColor = "green";
            acceptButton.classList.remove('disable-click');
        } else {
            document.getElementById('accept-button').style.backgroundColor = "red";
            acceptButton.classList.add('disable-click');
        }
    });

    function checkScroll() {
        const scrollHeight = termsContainer.scrollHeight;
        const offsetHeight = termsContainer.offsetHeight;
        const scrollTop = termsContainer.scrollTop;
        if (scrollHeight === offsetHeight + scrollTop) {
            acceptLabel.classList.remove('hidden');
        } else {
            acceptLabel.classList.add('hidden');
        }
    }
</script>

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
    $('.dob_field').datepicker({
        dateFormat: 'dd/mm/yy',
        maxDate: 0,
        changeMonth: true,
        changeYear: true,
    });

    function updateDateFormat(i, elem) {

        var d = $(elem).datepicker('getDate');

        $(elem).datepicker('destroy');
        $(elem).datepicker({
            autoclose: true,
            format: dateformat
        });
        $(elem).datepicker('setDate', d);

    }
</script>

<script type="text/javascript">
    child_dob.max = new Date().toISOString().split("T")[0];

    $(document).ready(function() {
        $("#content").find("[id^='tab']").hide();
        $("#home-tab").addClass("active");
        $("#tab1").fadeIn();

    });
</script>
<script type="application/javascript">
    $("#tile-1 .nav-tabs a").click(function() {
        var position = $(this).parent().position();
        var width = $(this).parent().width();
        $("#tile-1 .slider").css({
            "left": +position.left,
            "width": width
        });

        $("#tab-content").find("[id^='tab']").hide();
        $('#' + $(this).attr('name')).fadeIn();

    });
    var actWidth = $("#tile-1 .nav-tabs").find(".active").parent("li").width();
    var actPosition = $("#tile-1 .nav-tabs .active").position();

    function DoAction(id) {
        $("#tab-content").find("[id^='tab']").hide();
        $("#tabs a").removeClass("active");
        $("a[name='" + id + "']").addClass("active");
        var position = $("a[name='" + id + "']").position();
        var width = $("a[name='" + id + "']").width();
        $("#tile-1 .slider").css({
            "left": +position.left,
            "width": width
        });
        $('#' + (id)).fadeIn();
    }
</script>
<script type="application/javascript">
    var inputs = document.querySelectorAll('.file-input')
    console.log(inputs);
    for (var i = 0, len = inputs.length; i < len; i++) {
        customInput(inputs[i])
    }

    function customInput(el) {
        const fileInput = el.querySelector('[type="file"]')
        const label = el.querySelector('[data-js-label]')

        fileInput.onchange =
            fileInput.onmouseout = function() {
                if (!fileInput.value) return

                var value = fileInput.value.replace(/^.*[\\\/]/, '')
                el.className += ' -chosen'
                label.innerText = value
            }
    }
    //validation

    function childName(event) {
        let value = event.target.value || '';
        value = value.replace(/[^a-z A-Z ]/, '', );
        event.target.value = value;
        validateDublication();
    }

    function childfatherName(event) {
        let value = event.target.value || '';
        value = value.replace(/[^a-z A-Z ]/, '', );
        event.target.value = value;

    }

    function childmotherName(event) {
        let value = event.target.value || '';
        value = value.replace(/[^a-z A-Z ]/, '', );
        event.target.value = value;

    }

    function contactphonenumber(event, field) {
        let value = event.target.value || '';
        value = value.replace(/[^0-9+ ]/, '', );
        event.target.value = value;

        if (field == 'one') {
            var p1 = window.intlTelInputGlobals.getInstance(phone_number).isValidNumber();
        } else if (field == 'two') {
            var p1 = window.intlTelInputGlobals.getInstance(phone_number2).isValidNumber();
        }

        if (p1 == true) {
            document.getElementById('phone_message_' + field).style.color = 'green';
            document.getElementById('phone_message_' + field).innerHTML = 'Valid Number';
        } else {
            document.getElementById('phone_message_' + field).style.color = 'red';
            document.getElementById('phone_message_' + field).innerHTML = 'Invalid Number';
        }
    }
    
    var validate = 0;
    function validateDublication(){
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
                'InputDoB':InputDoB,
                _token: '{{csrf_token()}}'
                }
            }).done(function(data) {
                // console.log(data);
                validate = data;
            })
        }
    }

    function save() {
        var child_name = $('#child_name').val();
        if (child_name == '') {
            swal.fire("Please Enter Child's Name: ", "", "error");
            return false;
        }
        if(validate == 1){
            swal.fire("You have Already Enrolled With Elina", "", "error");
            return false;
        }
        document.getElementById('btn_status').value = 'saved';
        $('.loader').show();
        document.getElementById('newenrollement').submit('saved');
    }

    function submit() {
        if(validate == 1){
            swal.fire("You have Already Enrolled With Elina", "", "error");
            return false;
        }
        var child_name = $('#child_name').val();
        if (child_name == '') {
            swal.fire("Please Enter Child's Name: ", "", "error");
            return false;
        }

        var child_dob = $('#child_dob').val();
        if (child_dob == '') {
            swal.fire("Please Enter Child's Date of Birth:", "", "error");
            return false;
        }

        var child_gender = $('input[name="child_gender"]:checked').val();
        if (child_gender !== "Male" && child_gender !== "Female") {
            swal.fire("Please Select Child's Gender", "", "error");
            return false;
        }

        var child_school_name_address = $('.child_school_name_address').val();
        if (child_school_name_address == '') {
            swal.fire("Please Enter Child's current school name and address:", "", "error");
            return false;
        }

        var child_father_guardian_name = $('#child_father_guardian_name').val();
        var child_mother_caretaker_name = $('#child_mother_caretaker_name').val();

        var child_contact_email = $('#child_contact_email').val();
        if (child_contact_email == '') {
            swal.fire("Please Enter Email Address:  ", "", "error");
            return false;
        }

        var child_contact_phone = $('#child_contact_phone').val();
        if (child_contact_phone == '') {
            swal.fire("Please Enter Contact Phone number:  ", "", "error");
            return false;
        }

        var child_alter_phone = $('#child_alter_phone').val();
        let testmobile = /^[+0-9]{10,15}/;
        if (child_alter_phone != '') {
            if (!testmobile.test(child_alter_phone)) {
                swal.fire("Please Enter Valid Contact Number:", "", "error");
                return false;
            }
        }

        if (child_contact_phone == child_alter_phone) {
            swal.fire("Contact Number and Alternative Number should not be same", "", "error");
            return false;
        }

        var child_contact_address = $('#child_contact_address').val();
        if (child_contact_address == '') {
            swal.fire("Please Enter Address:  ", "", "error");
            return false;
        }

        var featured3 = document.getElementById("featured-3");
        var featured4 = document.getElementById("featured-4");
        var featured11 = document.getElementById("featured-11");
        var featured12 = document.getElementById("featured-12");
        // var featured13 = document.getElementById("featured-13");

        if ((featured3.checked == false) && (featured4.checked == false) && (featured11.checked == false) && (featured12.checked == false)) {
            swal.fire("Please Select atleast one Question from Services from Elina", "", "error");
            return false;
        }

        var featured5 = document.getElementById("featured-5");
        var featured6 = document.getElementById("featured-6");
        var featured7 = document.getElementById("featured-7");
        var featured8 = document.getElementById("featured-8");
        var featured9 = document.getElementById("featured-9");
        var featured10 = document.getElementById("featured-10");

        if ((featured5.checked == false) && (featured6.checked == false) && (featured7.checked == false) && (featured8.checked == false) && (featured9.checked == false) && (featured10.checked == false)) {
            swal.fire("Please Select atleast one Qusetion from About Elina", "", "error");
            return false;
        }
        document.getElementById('btn_status').value = 'Submitted';
        Swal.fire({
            title: "Do you want to Submit?",
            text: "Please click 'Yes' to Submit the Enrollment",
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Yes',
            cancelButtonText: 'No'
        }).then((result) => {
            if (result.isConfirmed) {
                $('.loader').show();
                document.getElementById('newenrollement').submit('saved');
            } else {
                return false;
            }
        });
    }
</script>


@endsection