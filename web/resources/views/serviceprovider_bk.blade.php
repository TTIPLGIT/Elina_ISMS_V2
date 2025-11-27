@extends('layouts.serviceproviderlayout')

@section('content')
<style>
    input[type=checkbox] {
        display: inline-block;
    }

    /* .no-arrow {
        -moz-appearance: textfield;
    } */

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

    .radioall {
        display: flex !important;
    }

    .internlabel {
        font-family: "Barlow Condensed", sans-serif !important;

    }
</style>
<div class="main-content">
    <div class="row justify-content-center">
        <div class="col-lg-12 col-md-12">
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
                            window.location.href = "{{Config::get('setting.web_portal')}}";
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

                <form action="{{route('serviceprovider.store')}}" method="POST" id="serviceprovider" enctype="multipart/form-data" onsubmit="return false">
                    @csrf


                    <div class="tile" id="tile-1" style="margin-top:10px !important; margin-bottom:10px !important;">

                        <!-- Nav tabs -->
                        <ul class="nav nav-tabs nav-justified" id="tabs" role="tablist">
                            <div class="slider"></div>
                            <li class="nav-item">
                                <a class="nav-link active internlabel" style="font-size: 19px; font-family: 'Barlow Condensed', sans-serif;" id="home-tab" name="tab1" data-toggle="tab" role="tab" aria-controls="home" aria-selected="true">General Details </a>

                            </li>
                            <li class="nav-item">
                                <a class="nav-link  internlabel" style="font-size: 19px; font-family: 'Barlow Condensed', sans-serif;" id="service-tab" name="tab2" data-toggle="tab" role="tab" aria-controls="home" aria-selected="true">Service Information </a>

                            </li>

                            <li class="nav-item">
                                <a class="nav-link internlabel" style="font-size: 19px; font-family: 'Barlow Condensed', sans-serif;" id="contact-tab" name="tab3" data-toggle="tab" role="tab" aria-controls="contact" aria-selected="false"><i class="fa fa-map-signs"></i>Acknowledgement </a>
                            </li>


                        </ul>
                    </div>
                    <!-- Tab panes -->

                    <div class="tab-content" id="tab-content">
                        <div class="tab-pane fade show active" id="tab1" role="tabpanel" title="General Details" aria-labelledby="home-tab">


                            <section class="section">
                                <div class="section-body mt-1">

                                    <hr>
                                    <h5 style=" display:flex;   width: fit-content; padding: -13px;   margin-top: -32px;margin-left: auto;margin-right: auto;padding: 5px;background-color: white; font-family: 'Barlow Condensed', sans-serif;">Personal Details</h5>

                                    <div class="row">

                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label class="control-label internlabel" style="font-size: medium; font-family: 'Barlow Condensed', sans-serif;">Name: </label><span class="error-star" style="color:red;">*</span>
                                                <input class="form-control default" type="text" id="name" name="name" title="Name" oninput="childName(event)" maxlength="20" value="" autocomplete="off" required>
                                            </div>
                                        </div>

                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <div class="row col-md-6 control-label internlabel" style="font-size: medium;font-family: 'Barlow Condensed', sans-serif;">Gender: <span class="error-star" style="color:red;">*</span></div>
                                                <input type="radio" id="Male" name="gender" title="Gender" value="Male" required><label for="Male" style="padding:5px 10px;font-family: 'Barlow Condensed', sans-serif;">Male</label>
                                                <input type="radio" id="Female" name="gender" title="Gender" value="Female" required><label for="Female" style="padding:5px 10px;font-family: 'Barlow Condensed', sans-serif;">Female</label>

                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label class="control-label internlabel" style="font-size: medium;font-family: 'Barlow Condensed', sans-serif;">Phone Number: </label><span class="error-star" style="color:red;">*</span>
                                                <input class="form-control indent no-arrow" type="text" id="phone_number" title="Phone Number" minlength="10" maxlength="10" name="phone_number" autocomplete="off" inputmode="numeric" oninput="contactphonenumber(event)" value="" required>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label class="control-label internlabel" style="font-size: medium;font-family: 'Barlow Condensed', sans-serif;">Email Address:</label><span class="error-star" style="color:red;">*</span>
                                                <input class="form-control indent no-arrow" type="text" id="email_address" title="Email Address" minlength="10" maxlength="50" name="email_address" autocomplete="off" value="" required>
                                            </div>
                                        </div>

                                    </div>


                                    <hr>
                                    <h4 style=" font-family: 'Barlow Condensed', sans-serif; display:flex;   width: fit-content; padding: -13px;margin-top: -34px;margin-left: auto;margin-right: auto;padding: 5px;background-color: white;">Specialization</h4>


                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">

                                                <label class="control-label internlabel" style="font-size: medium;font-family: 'Barlow Condensed', sans-serif;">Areas of Specialization:</label><span class="error-star" style="color:red;">*</span>
                                                <div class="row justify-content inputcheck">
                                                    @foreach($specialization as $data)
                                                    <input class="form-control checks area_of_specializtion" type="checkbox" id="therapist{{$data['id']}}" name="area_of_specializtion[{{$data['id']}}]" title="Areas of Specialization" value="{{$data['specialization']}}" required autocomplete="off">
                                                    <label for="therapist{{$data['id']}}">{{$data['specialization']}}</label>
                                                    @endforeach
                                                    {{-- <input class="form-control checks " type="checkbox" id="occupational_therapist" name="area_of_specializtion[]" title="Areas of Specialization" value="Occupational Therapist" required autocomplete="off">
                                                    <label for="occupational_therapist">Occupational Therapist</label>
                                                    <input class="form-control checks" type="checkbox" id="speech_therapist" name="area_of_specializtion[]" title="Areas of Specialization" value="Speech Therapist" required autocomplete="off">
                                                    <label for="speech_therapist" class="">Speech Therapist</label>
                                                    <input class="form-control checks" type="checkbox" id="special_education" name="area_of_specializtion[]" title="Areas of Specialization" value="Special Education" required autocomplete="off">
                                                    <label for="special_education" class="">Special Education</label>
                                                    <input class="form-control checks" type="checkbox" id="physical_trainer" name="area_of_specializtion[]" title="Areas of Specialization" value="Physical Trainer" required autocomplete="off">
                                                    <label for="physical_trainer" class="">Physical Trainer</label>

                                                    <input class="form-control checks" type="checkbox" id="art_therapist" name="area_of_specializtion[]" title="Areas of Specialization" value="Art Therapist" required autocomplete="off">
                                                    <label for="art_therapist" class="">Art Therapist</label>
                                                    <input class="form-control checks" type="checkbox" id="music_therapist" name="area_of_specializtion[]" title="Areas of Specialization" value="Music Therapist" required autocomplete="off">
                                                    <label for="music_therapist" class="">Music Therapist</label>
                                                    <input class="form-control checks" type="checkbox" id="physiotherapy" name="area_of_specializtion[]" title="Areas of Specialization" value="Physiotherapy" required autocomplete="off">
                                                    <label for="physiotherapy" class="">Physiotherapy</label>
                                                    <input class="form-control checks" type="checkbox" id="yoga_therapist" name="area_of_specializtion[]" title="Areas of Specialization" value="Yoga therapist" required autocomplete="off">
                                                    <label for="yoga_therapist" class="">Yoga Therapist</label> --}}

                                                    <!-- </div>
                                                <div class="row offset-1 col-6 justify-content"> -->
                                                    <br />
                                                    <input class="form-control checks" type="checkbox" id="other" name="area_of_specializtion[0]" value="Other" title="Areas of Specialization" required autocomplete="off" onchange="inputchange(event)">
                                                    <label for="other">Other</label>
                                                    <div class="col-4">
                                                        <input class="form-control " type="text" id="other_specialist" title="Areas of Specialization" value="" style="display:none" required autocomplete="off">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                                <div class="col-md-12 text-center">

                                    <a type="button" class="btn btn-labeled btn-info" href="{{Config::get('setting.web_portal')}}" title="back" style="background: blue !important; border-color:blue !important; color:white !important">
                                        <span class="btn-label" style="font-size:13px !important;"><i class="fa fa-arrow-left"></i></span> Back</a>

                                    <button class="btn btn-primary" type="reset" title="Clear"><i class="fa fa-undo"></i> Clear</button>&nbsp;

                                    <!-- <a type="button" onclick="submitfn()" id="submitbutton" class="btn btn-labeled btn-succes" title="save" style="background: green !important; border-color:green !important; color:white !important">
                                        <span class="btn-label" style="font-size:13px !important;"><i class="fa fa-check"></i></span> Save</a> -->




                                    <a type="button" class="btn btn-labeled btn-info" onclick="DoAction('tab2');" title="Next" style="background: blue !important; border-color:#4d94ff !important; color:white !important">
                                        <span class="btn-label" style="font-size:13px !important;">Next <i class="fa fa-arrow-right"></i></a>

                                </div>
                            </section>

                        </div>
                        <div class="tab-pane fade show" id="tab2" role="tabpanel" title="Service Information" aria-labelledby="addition-tab">



                            <section class="section">
                                <div class="section-body mt-1">

                                    <hr>
                                    <h5 style=" display:flex;   width: fit-content; padding: -13px;   margin-top: -32px;margin-left: auto;margin-right: auto;padding: 5px;background-color: white; font-family: 'Barlow Condensed', sans-serif;">Service Details</h5>

                                    <div class="row">
                                        <input type="hidden" id="selected_id" name="selected_id" value="">

                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <div class="control-label row internlabel pl-3" style="font-size: medium; font-family: 'Barlow Condensed', sans-serif;">Mode of operation: <span class="error-star" style="color:red;">*</span></div>
                                                <!-- <div class="row"> -->
                                                <input type="radio" id="individual" name="type_of_service" title="Type of Service" value="individual" onchange="service(event)" required><label for="individual" style="padding:10px;font-family: 'Barlow Condensed', sans-serif;">Individual</label>
                                                <input type="radio" id="organisation" name="type_of_service" title="Type of Service" value="Organisation" onchange="service(event)" required><label for="organisation" style="padding:10px;font-family: 'Barlow Condensed', sans-serif;">Organisation</label>
                                                <!-- </div> -->
                                            </div>
                                        </div>

                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <div class="row  control-label internlabel" style="font-size: medium;font-family: 'Barlow Condensed', sans-serif;">Mode of deliviery: <span class="error-star" style="color:red;">*</span></div>
                                                <input type="radio" id="Yes" name="providing_home_service" title="Interest in Providing Home Service" value="Yes" onchange="profileval(this)" required><label for="Yes" style="padding:10px;font-family: 'Barlow Condensed', sans-serif;">Yes</label>
                                                <input type="radio" id="No" name="providing_home_service" title="Interest in Providing Home Service" value="No" onchange="profileval(this)" required><label for="No" style="padding:10px;font-family: 'Barlow Condensed', sans-serif;">No</label>

                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label class="control-label internlabel" style="font-size: medium;font-family: 'Barlow Condensed', sans-serif;">Mode of Service: </label><span class="error-star" style="color:red;">*</span>
                                                <div class="d-flex">
                                                    <input class="form-control " type="checkbox" id="online" name="mode_of_service[]" title="Mode of Service" value="online" required autocomplete="off">
                                                    <label for="online">Online</label>
                                                    <input class="form-control " type="checkbox" id="offline" name="mode_of_service[]" title="Mode of Service" value="offline" required autocomplete="off">
                                                    <label for="offline">Offline</label>
                                                    <input class="form-control " type="checkbox" id="hybrid" name="mode_of_service[]" title="Mode of Service" value="Hybrid" required autocomplete="off">
                                                    <label for="hybrid">Hybrid </label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <div class="row  control-label internlabel" style="font-size: medium;font-family: 'Barlow Condensed', sans-serif;margin: 0 0 0 0px;">Professional Charges Per Session: <span class="error-star" style="color:red;">*</span></div>
                                                <input class="form-control " type="text" id="profession_charges_per_session" name="profession_charges_per_session" title="Professional charges per session" value="" onchange="profileval(this)">
                                                <!-- <input type="radio" id="No" name="child_gender" value="No" onchange="profileval(this)"><label for="featured-2" style="padding:5px;font-family: 'Barlow Condensed', sans-serif;">No</label> -->

                                            </div>
                                        </div>

                                    </div>
                                    <div id="organisationd" style="display:none">

                                        <hr>
                                        <h4 style=" font-family: 'Barlow Condensed', sans-serif; display:flex;   width: fit-content; padding: -13px;margin-top: -34px;margin-left: auto;margin-right: auto;padding: 5px;background-color: white;">Organisation</h4>


                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="form-group">

                                                    <label class="control-label internlabel" style="font-size: medium;font-family: 'Barlow Condensed', sans-serif;">Name Of The Organisation:</label><span class="error-star" style="color:red;">*</span>
                                                    <input class="form-control " type="text" id="organisation_name" name="organisation_name" title="Name Of The Organisation" value="" required autocomplete="off">
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">

                                                    <label class="control-label internlabel" style="font-size: medium;font-family: 'Barlow Condensed', sans-serif;">Name of the Head of Organisation:</label><span class="error-star" style="color:red;">*</span>
                                                    <input class="form-control " type="text" id="organisation_head_name" name="organisation_head_name" title="Name of the Head of Organisation" value="" required autocomplete="off">
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">

                                                    <label class="control-label internlabel" style="font-size: medium;font-family: 'Barlow Condensed', sans-serif;">Email Address of the Organisation:</label><span class="error-star" style="color:red;">*</span>
                                                    <input class="form-control " type="text" id="organisation_email_address" name="organisation_email_address" title="Email address of the organisation" value="" required autocomplete="off">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="form-group">

                                                    <label class="control-label internlabel" style="font-size: medium;font-family: 'Barlow Condensed', sans-serif;">Website/ Info of Organization:</label><span class="error-star" style="color:red;">*</span>
                                                    <input class="form-control " type="text" id="organisation_website_info" name="organisation_website_info" title="Website/ Info of Organization" value="" required autocomplete="off">
                                                </div>
                                            </div>
                                            <div class="col-md-8">
                                                <div class="form-group">

                                                    <label class="control-label internlabel" style="font-size: medium;font-family: 'Barlow Condensed', sans-serif;">Please let us know of any specifications, limitations or constraints that you would like to mention:</label><span class="error-star" style="color:red;">*</span>
                                                    <input class="form-control " type="text" id="specification_limitation_constraint" name="specification_limitation_constraint" title="specifications, limitations or constraints " value="" required autocomplete="off">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12 text-center">

                                    <a type="button" class="btn btn-labeled btn-info" onclick="DoAction('tab1');" title="back" style="background: blue !important; border-color:blue !important; color:white !important">
                                        <span class="btn-label" style="font-size:13px !important;"><i class="fa fa-arrow-left"></i></span> Back</a>

                                    <button class="btn btn-primary" type="reset" title="Clear"><i class="fa fa-undo"></i> Clear</button>&nbsp;

                                    <!-- <a type="button" onclick="submitfn()" id="submitbutton" class="btn btn-labeled btn-succes" title="save" style="background: green !important; border-color:green !important; color:white !important">
                                        <span class="btn-label" style="font-size:13px !important;"><i class="fa fa-check"></i></span> Save</a> -->




                                    <a type="button" class="btn btn-labeled btn-info" onclick="DoAction('tab3');" title="Next" style="background: blue !important; border-color:#4d94ff !important; color:white !important">
                                        <span class="btn-label" style="font-size:13px !important;">Next <i class="fa fa-arrow-right"></i></a>

                                </div>
                            </section>
                        </div>

                        <div class="tab-pane fade show" id="tab3" role="tabpanel" title="Acknowledgement" aria-labelledby="contact-tab">



                            <section class="section">
                                <div class="section-body mt-1">
                                    <hr>
                                    <h5 style=" display:flex;   width: fit-content; padding: -13px;   margin-top: -32px;margin-left: auto;margin-right: auto;padding: 5px;background-color: white; font-family: 'Barlow Condensed', sans-serif;">Education Details</h5>

                                    <div class="row">
                                        <input type="hidden" id="selected_id" name="selected_id" value="">

                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label class="control-label internlabel" style="font-size: medium; font-family: 'Barlow Condensed', sans-serif;">University Name: </label><span class="error-star" style="color:red;">*</span>
                                                <input class="form-control default" type="text" id="universtiy_name" name="universtiy_name" title="University Name" oninput="childName(event)" value="" autocomplete="off" required>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <div class="row col-md-12 control-label internlabel" style="font-size: medium;font-family: 'Barlow Condensed', sans-serif;">Professional Qualification: <span class="error-star" style="color:red;">*</span></div>
                                                <input type="radio" id="Diploma" name="profession_qualification" value="Diploma" title="Professional Qualification" onchange="profileval(this)"><label for="Diploma" style="padding:5px;font-family: 'Barlow Condensed', sans-serif;">Diploma</label>
                                                <input type="radio" id="Bachelors" name="profession_qualification" value="Bachelors" title="Professional Qualification" onchange="profileval(this)"><label for="Bachelors" style="padding:5px;font-family: 'Barlow Condensed', sans-serif;">Bachelors</label>
                                                <br>
                                                <input type="radio" id="Masters" name="profession_qualification" value="Masters" title="Professional Qualification" onchange="profileval(this)"><label for="Masters" style="padding:5px;font-family: 'Barlow Condensed', sans-serif;">Masters</label>
                                                <input type="radio" id="Phd" name="profession_qualification" value="Phd" title="Professional Qualification" onchange="profileval(this)"><label for="Phd" style="padding:5px;font-family: 'Barlow Condensed', sans-serif;">Phd</label>


                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label class="control-label internlabel" style="font-size: medium; font-family: 'Barlow Condensed', sans-serif;">Year Of Completion: </label><span class="error-star" style="color:red;">*</span>
                                                <input class="form-control default" type="date" id="year_of_completion" title="" name="year_of_completion" value="Year Of Completion" autocomplete="off" required>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label class="control-label internlabel" style="font-size: medium;font-family: 'Barlow Condensed', sans-serif;">Specialist in: </label><span class="error-star" style="color:red;">*</span>
                                                <input class="form-control indent no-arrow" type="text" id="specialist_in" title="Specialist in" name="specialist_in" autocomplete="off" inputmode="numeric" oninput="childName(event)" value="" required>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label class="control-label internlabel" style="font-size: medium;font-family: 'Barlow Condensed', sans-serif;">Work Experience:</label><span class="error-star" style="color:red;">*</span>
                                                <input class="form-control indent no-arrow" type="text" id="work_experience" title="Work Experience" minlength="10" maxlength="15" name="work_experience" autocomplete="off" value="" required>
                                            </div>
                                        </div>

                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group d-flex flex-column">
                                                <label class="control-label internlabel" style="font-family: 'Barlow Condensed', sans-serif;">I hereby agree to be part of Elina network for Professionals who enable inclusion. By being part of Elina network for professionals, I understand that</label>
                                                <label class="control-label internlabel" style="font-family: 'Barlow Condensed', sans-serif;">--I shall provide services to the child referred by Elina according to my availability.</label>
                                                <label class="control-label internlabel" style="font-family: 'Barlow Condensed', sans-serif;">--I shall share reports and other observations about the child with Elina.</label>
                                                <label class="control-label internlabel" style="font-family: 'Barlow Condensed', sans-serif;">--I shall seek information from Elina about the child </label>
                                                <label class="control-label internlabel" style="font-family: 'Barlow Condensed', sans-serif;">--I shall adopt an open door policy with the parents so as to enable and empower them to be part of their child’s progress</label>
                                                <label class="control-label internlabel" style="font-family: 'Barlow Condensed', sans-serif;">--I shall operate on trust and transparency with Elina</label>
                                                <label class="control-label internlabel" style="font-family: 'Barlow Condensed', sans-serif;">--I do not have any financial arrangements with Elina and all my professional charges towards providing service to the child will be charged to the Parents/ Guardian </label>

                                                <input class="form-control " type="checkbox" id="agree_of_acknowledgement" title=" Agreement" name="agree_of_acknowledgement" value="Agreed" required autocomplete="off">
                                                <label for="agree_of_acknowledgement"> I Agree <span class="error-star" style="color:red;">*</span></label>

                                            </div>
                                        </div>

                                    </div>
                                </div>
                                <div class="col-md-12 text-center">

                                    <a type="button" class="btn btn-labeled btn-info" onclick="DoAction('tab2');" title="back" style="background: blue !important; border-color:blue !important; color:white !important">
                                        <span class="btn-label" style="font-size:13px !important;"><i class="fa fa-arrow-left"></i></span> Back</a>

                                    <a type="button" id="submit" class="btn btn-labeled btn-succes" onclick="submitfn();" title="submit" style="background: green !important; border-color:green !important; color:white !important">
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
    var today = new Date();
    var dd = String(today.getDate()).padStart(2, '0');
    var mm = String(today.getMonth() + 1).padStart(2, '0');
    var yyyy = today.getFullYear();

    today = yyyy + '-' + mm + '-' + dd;
    $('#date_of_stay_from').attr('min', today);
    $('#date_of_stay_to').attr('min', today);
</script>

<script src="https://code.jquery.com/jquery-1.7.2.min.js"></script>

<script type="text/javascript">
    const inputchange = (event) => {
        // other_specialist
        let other = document.getElementById('other');
        let otherspecialist = document.getElementById('other_specialist');
        otherspecialist.style.display = (other.checked == true) ? "inline-block" : "none";
        name = "area_of_specializtion[0]"
    }
    const service = (event) => {
        document.getElementById('organisationd').style.display = (document.getElementById('organisation').checked == true) ? "block" : "none";
    }

    function submitfn() {
        event.preventDefault();
        var area_of_specializtion_checked;
        const getAllFormElements = element => Array.from(element.elements).filter(tag => ["input"].includes(tag.tagName.toLowerCase()));
        // console.log(getAllFormElements);
        const pageFormElements = getAllFormElements(document.getElementById("serviceprovider"));
        let organisationd = document.getElementById('organisationd').style.display
        for (i = 0; i < pageFormElements.length; i++) {
            // console.log(pageFormElements);
            if (pageFormElements[i].value == "" || (pageFormElements[i].type == "radio" || pageFormElements[i].type == "checkbox")) {
                if (pageFormElements[i].type == "radio" || pageFormElements[i].type == "checkbox") {
                    if (pageFormElements[i].classList.contains('area_of_specializtion')) {
                        if(area_of_specializtion_checked == null || area_of_specializtion_checked == false)
                        var specialization = <?php echo json_encode($specialization);?>;
                        var n = specialization.length;
                        area_of_specializtion_checked = false;
                        for (var i = 0; i < n; i++) {
                            var j = specialization[i].id;
                            let checkbox = document.querySelector('input[name="area_of_specializtion['+j+']"]:checked');
                            
                            if (checkbox) {
                                area_of_specializtion_checked = true;
                                break;
                            }
                        }

                        if (area_of_specializtion_checked == false) {
                            let text = "Please Enter Field ";
                            text += pageFormElements[i].title;
                            let tab = " in ";
                            tab += pageFormElements[i].parentElement.parentElement.parentElement.parentElement.parentElement.parentElement.title;
                            tab += " Section"
                            text += tab;
                            swal({
                                title: "Warning",
                                text: text,
                                type: "error"
                            });

                            return false;
                        }

                    } else {
                        let radiocheck = document.querySelector('input[name="' + pageFormElements[i].name + '"]:checked');

                        if (radiocheck === null) {
                            let text = "Please Enter Field ";
                            text += pageFormElements[i].title;
                            let tab = " in ";
                            tab += pageFormElements[i].parentElement.parentElement.parentElement.parentElement.parentElement.parentElement.title;
                            tab += " Section"
                            text += tab;
                            swal({
                                title: "Warning",
                                text: text,
                                type: "error"
                            });

                            return false;
                        }
                    }

                }
                if ((pageFormElements[i].type == "text" && pageFormElements[i].style.display !== "none" && pageFormElements[i].parentElement.parentElement.parentElement.parentElement.style.display !== "none") || (pageFormElements[i].type == "date")) {
                    if (pageFormElements[i].value == "") {
                        let text = "Please Enter Field ";
                        text += pageFormElements[i].title;
                        let tab = " in ";
                        tab += pageFormElements[i].parentElement.parentElement.parentElement.parentElement.parentElement.parentElement.title;
                        tab += " Section"
                        text += tab;

                        swal({
                            title: "Warning",
                            text: text,
                            type: "error"
                        });
                        return false;
                    }

                }


            }

            if (pageFormElements[i].type == "text" && ((pageFormElements[i].name == "organisation_email_address" && pageFormElements[i].parentElement.parentElement.parentElement.parentElement.style.display !== "none") || pageFormElements[i].name == "email_address") || pageFormElements[i].name == "phone_number") {
                let testemail = (pageFormElements[i].name == "phone_number") ? /^[+0-9]{10,15}/ : /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;

                if (!testemail.test(pageFormElements[i].value)) {

                    let text = "Please Enter Valid  ";
                    text += pageFormElements[i].title;
                    let tab = " in ";
                    tab += pageFormElements[i].parentElement.parentElement.parentElement.parentElement.parentElement.parentElement.title;
                    tab += " Section"
                    text += tab;

                    swal({
                        title: "Warning",
                        text: text,
                        type: "error"
                    });
                    event.preventDefault();

                    return false;
                }

            }
        }
        document.getElementById('serviceprovider').submit();

    }
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
<script type="application/javascript">
    //validation

    function childName(event) {
        let value = event.target.value || '';
        value = value.replace(/[^a-z A-Z ]/, '', );
        event.target.value = value;

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

    function contactphonenumber(event) {
        let value = event.target.value || '';
        value = value.replace(/[^0-9+ ]/, '', );
        event.target.value = value;

    }

    function save() {
        const getAllFormElements = element => Array.from(element.elements).filter(tag => ["text", "radio", "checkbox", "date"].includes(tag.tagName.toLowerCase()));
        const pageFormElements = getAllFormElements(document.getElementById("serviceprovider"));
        for (i = 0; i < pageFormElements.length; i++) {
            if (pageFormElements[i].value == "") {
                let text = "Please Enter Field ";
                text += pageFormElements[i].title;
                let tab = " in ";
                tab += pageFormElements[i].parentElement.parentElement.parentElement.parentElement.parentElement.parentElement.title;
                tab += " Section"
                text += tab;
                swal({
                    title: "Warning",
                    text: text,
                    type: "warning"
                }, );
                return false;
            }
        }

        var child_name = $('#child_name').val();

        if (child_name == '') {
            swal("Please Enter Child's Name: ", "", "error");
            return false;
        }

        var child_dob = $('.child_dob').val();

        if (child_dob == '') {
            swal("Please Enter Child's Date of Birth:", "", "error");
            return false;
        }

        var child_gender = $('input[name="child_gender"]:checked').val();



        if (child_gender !== "Male" && child_gender !== "Female") {

            swal({
                title: "Error",
                text: "select Child's Gender",
                type: 'error',
                confirmButtontext: "OK"
            });

            return false;

        }

        var child_school_name_address = $('.child_school_name_address').val();

        if (child_school_name_address == '') {
            swal("Please Enter Child's current school name and address:", "", "error");
            return false;
        }

        var child_father_guardian_name = $('#child_father_guardian_name').val();

        if (child_father_guardian_name == '') {
            swal("Please Enter Child's Father/ Guardian Name:  ", "", "error");
            return false;
        }

        var child_mother_caretaker_name = $('#child_mother_caretaker_name').val();

        if (child_mother_caretaker_name == '') {
            swal("Please Enter Child's Mother/Primary caretaker's Name:  ", "", "error");
            return false;
        }

        var child_contact_email = $('#child_contact_email').val();

        if (child_contact_email == '') {
            swal("Please Enter Email Address:  ", "", "error");
            return false;
        }

        var child_contact_phone = $('#child_contact_phone').val();

        if (child_contact_phone == '') {
            swal("Please Enter Contact Phone number:  ", "", "error");
            return false;
        }

        var child_contact_address = $('#child_contact_address').val();

        if (child_contact_address == '') {
            swal("Please Enter Address:  ", "", "error");
            return false;
        }



        document.getElementById('newenrollement').submit('saved');
    }

    function submit() {

        var featured3 = document.getElementById("featured-3");
        var featured4 = document.getElementById("featured-4");
        var featured11 = document.getElementById("featured-11");
        var featured12 = document.getElementById("featured-12");


        if ((featured3.checked == false) && (featured4.checked == false) && (featured11.checked == false) && (featured12.checked == false)) {

            swal({
                title: "Error",
                text: "Please Select atleast one Question from Services from Elina",
                type: 'error',
                confirmButtontext: "OK"
            });

            return false;

        }


        var featured5 = document.getElementById("featured-5");
        var featured6 = document.getElementById("featured-6");
        var featured7 = document.getElementById("featured-7");
        var featured8 = document.getElementById("featured-8");
        var featured9 = document.getElementById("featured-9");
        var featured10 = document.getElementById("featured-10");

        if ((featured5.checked == false) && (featured6.checked == false) && (featured7.checked == false) && (featured8.checked == false) && (featured9.checked == false) && (featured10.checked == false)) {

            swal({
                title: "Error",
                text: "Please Select atleast one Qusetion from About Elina",
                type: 'error',
                confirmButtontext: "OK"
            });

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