@extends('layouts.schoollayout')

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

    /* #tile-1 .nav-tabs .active {
        border-bottom: 2px solid black !important;
    } */
</style>
<div class="main-content">
    <div class="row justify-content-center">
        <div class="">
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
                <form action="{{route('schoolenrollement.store')}}" method="POST" id="newenrollement" enctype="multipart/form-data" onsubmit="return false">
                    @csrf


                    <div class="tile" id="tile-1" style="margin-top:10px !important; margin-bottom:10px !important;">

                        <!-- Nav tabs -->
                        <ul class="nav nav-tabs nav-justified" id="tabs" role="tablist">
                            <!-- <div class="slider"></div> -->
                            <li class="nav-item">
                                <a class="nav-link active internlabel" style="font-size: 19px; font-family: 'Barlow Condensed', sans-serif;" id="home-tab" name="tab1" data-toggle="tab" role="tab" aria-controls="home" aria-selected="true">School Details</a>

                            </li>
                            <li class="nav-item">
                                <a class="nav-link  internlabel" style="font-size: 19px; font-family: 'Barlow Condensed', sans-serif;" id="service-tab" name="tab2" data-toggle="tab" role="tab" aria-controls="home" aria-selected="true">School Policy</a>

                            </li>

                            <li class="nav-item">
                                <a class="nav-link internlabel" style="font-size: 19px; font-family: 'Barlow Condensed', sans-serif;" id="contact-tab" name="tab3" data-toggle="tab" role="tab" aria-controls="contact" aria-selected="false"><i class="fa fa-map-signs"></i>General Questions</a>
                            </li>


                        </ul>
                    </div>
                    <!-- Tab panes -->

                    <div class="tab-content" id="tab-content">
                        <div class="tab-pane fade show active" id="tab1" role="tabpanel" aria-labelledby="home-tab">


                            <section class="section">
                                <div class="section-body mt-1">

                                    <hr>
                                    <h5 style=" display:flex;   width: fit-content; padding: -13px;   margin-top: -32px;margin-left: auto;margin-right: auto;padding: 5px;background-color: white; font-family: 'Barlow Condensed', sans-serif;">School Details</h5>

                                    <div class="row">
                                        <input type="hidden" id="selected_id" name="selected_id" value="">

                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label class="control-label childname">School Name: </label><span class="error-star" style="color:red;">*</span>
                                                <input class="form-control default" type="text" id="school_name" name="school_name" oninput="textCheck(event)" value="" autocomplete="off">
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label class="control-label childname">Principal Name: </label><span class="error-star" style="color:red;">*</span>
                                                <input class="form-control default school_principal_name" type="text" id="school_principal_name" name="school_principal_name" oninput="textCheck(event)" autocomplete="off">
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label class="control-label childname">Building Name: </label><span class="error-star" style="color:red;">*</span>
                                                <input class="form-control default" type="text" id="school_building_name" name="school_building_name" oninput="textCheck(event)" value="" autocomplete="off">
                                            </div>
                                        </div>



                                    </div>




                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label class="control-label childname">Building Address: </label><span class="error-star" style="color:red;">*</span>
                                                <input class="form-control default" type="text" id="school_builiding_address" name="school_builiding_address" oninput="textAddress(event)" value="" autocomplete="off">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label class="control-label childname">School District:</label><span class="error-star" style="color:red;">*</span>
                                                <input class="form-control default" type="text" id="school_district" name="school_district" oninput="textCheck(event)" autocomplete="off">
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label class="control-label childname">Building Contact:</label><span class="error-star" style="color:red;">*</span>
                                                <input class="form-control default" type="text" id="building_contract" name="building_contract" oninput="NumericCheck(event)" maxlength="10" value="" autocomplete="off">
                                            </div>
                                        </div>

                                    </div>

                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label class="control-label childname">Administration Contact: </label><span class="error-star" style="color:red;">*</span>
                                                <input class="form-control default" type="text" id="admin_contract" name="admin_contract" oninput="NumericCheck(event)" maxlength="10" value="" autocomplete="off">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label class="control-label childname">Phone Number:</label><span class="error-star" style="color:red;">*</span>
                                                <input class="form-control default" type="text" id="phone_number" name="phone_number" oninput="NumericCheck(event)" maxlength="10" value="" autocomplete="off">
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label class="control-label childname">Telephone Number:</label><span class="error-star" style="color:red;">*</span>
                                                <input class="form-control default" type="text" id="telephone_number" name="telephone_number" oninput="NumericCheck(event)" maxlength="10" value="" autocomplete="off">
                                            </div>
                                        </div>






                                    </div>

                                    <div class="row">

                                        <div class="col-md-4">

                                            <div class="form-group">
                                                <label class="control-label">Email Address: </label><span class="error-star" style="color:red;">*</span>
                                                <input id="school_email" type="email" class="form-control  @error('email') is-invalid @enderror" oninput="textAddress(event)" name="school_email" required>
                                                @error('email')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>
                                        </div>




                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label class="control-label childname">Year of Establishment:</label><span class="error-star" style="color:red;">*</span>
                                                <input class="form-control default" type="text" id="year_of_establishment" name="year_of_establishment" oninput="NumericCheck(event)" maxlength="4" value="" autocomplete="off">
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label class="control-label childname">Total Number of Student Population:</label><span class="error-star" style="color:red;">*</span>
                                                <input class="form-control default" type="text" id="totalstudent_population" name="totalstudent_population" oninput="NumericCheck(event)" autocomplete="off">
                                            </div>
                                        </div>

                                    </div>

                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label class="control-label childname">Total Number of Teacher Population:</label><span class="error-star" style="color:red;">*</span>
                                                <input class="form-control default" type="text" id="totalteacher_population" name="totalteacher_population" oninput="NumericCheck(event)" autocomplete="off">
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label class="control-label internlabel" style="font-size: medium;font-family: 'Barlow Condensed', sans-serif;">School Type: </label><span class="error-star" style="color:red;">*</span>
                                                <div class="d-flex">
                                                    <input class="form-control " type="checkbox" id="primary1" name="school_type[]" value="Primary" required autocomplete="off">
                                                    <label for="primary1">Primary</label>
                                                    <input class="form-control " type="checkbox" id="primary2" name="school_type[]" value="HS" required autocomplete="off">
                                                    <label for="primary2">HS</label>
                                                    <input class="form-control" type="checkbox" id="primary3" name="school_type[]" value="IE" required autocomplete="off">
                                                    <label for="primary3">IE </label>
                                                </div>
                                            </div>



                                        </div>

                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label class="control-label" style="font-size: medium;font-family: 'Barlow Condensed', sans-serif;">Student Teacher-Ratio: </label><span class="error-star" style="color:red;">*</span>
                                                <div class="d-flex">
                                                    <input class="form-control " type="checkbox" id="primary4" name="school_teacher_ratio[]" value="Primary" required autocomplete="off">
                                                    <label for="primary4">Primary</label>
                                                    <input class="form-control " type="checkbox" id="primary5" name="school_teacher_ratio[]" value="Secondary" required autocomplete="off">
                                                    <label for="primary5">Secondary</label>
                                                    <input class="form-control" type="checkbox" id="primary6" name="school_teacher_ratio[]" value="Higher Secondary " required autocomplete="off">
                                                    <label for="primary6">Higher Secondary </label>
                                                </div>
                                            </div>



                                        </div>



                                    </div>
                                    <div class="col-md-12 text-center">

                                        <a type="button" class="btn btn-labeled btn-info" href="{{Config::get('setting.web_portal')}}" title="Back" style="background: blue !important; border-color:blue !important; color:white !important">
                                            <span class="btn-label" style="font-size:13px !important;"><i class="fa fa-arrow-left"></i></span> Back</a>

                                        <button class="btn btn-primary" type="reset" title="Clear"><i class="fa fa-undo"></i> Clear</button>&nbsp;

                                        <!-- <a type="button" onclick="save('submitted')" id="submitbutton" class="btn btn-labeled btn-succes" title="save" style="background: green !important; border-color:green !important; color:white !important">
                                        <span class="btn-label" style="font-size:13px !important;"><i class="fa fa-check"></i></span> Save</a> -->




                                        <a type="button" class="btn btn-labeled btn-info" onclick="DoAction('tab2');" title="Next" style="background: blue !important; border-color:#4d94ff !important; color:white !important">
                                            <span class="btn-label" style="font-size:13px !important;">Next <i class="fa fa-arrow-right"></i></a>

                                    </div>
                            </section>

                        </div>
                        <div class="tab-pane fade show" id="tab2" role="tabpanel" aria-labelledby="addition-tab">



                            <section class="section">
                                <div class="section-body mt-1">

                                    <div class="container">
                                        <label class="control-label heading" style="font-size: medium;font-family: 'Barlow Condensed', sans-serif;">
                                            1.Infrastructure Facility:
                                        </label>
                                        <span class="error-star" style="color:red;">*</span>
                                        <div class="d-flex flex-wrap ">
                                            <div class="infra_options px-0">
                                                <div class="form-group">
                                                    <input class="form-control" type="checkbox" id="primary7" name="infra_facility[]" value="Science Labs" required autocomplete="off">
                                                    <label for="primary7">Science Labs</label>
                                                </div>
                                            </div>
                                            <div class="infra_options px-0">
                                                <div class="form-group">
                                                    <input class="form-control " type="checkbox" id="primary8" name="infra_facility[]" value="Library" required autocomplete="off">
                                                    <label for="primary8">Library</label>
                                                </div>
                                            </div>
                                            <div class="infra_options px-0">
                                                <div class="form-group">
                                                    <input class="form-control" type="checkbox" id="primary9" name="infra_facility[]" value="Art Room" required autocomplete="off">
                                                    <label for="primary9">Art Room</label>
                                                </div>
                                            </div>
                                            <div class="infra_options px-0">
                                                <div class="form-group">
                                                    <input class="form-control " type="checkbox" id="primary10" name="infra_facility[]" value="Sports(Indoor and Outdoor)" required autocomplete="off">
                                                    <label for="primary10">Sports(Indoor and Outdoor)</label>
                                                </div>
                                            </div>
                                            <div class="infra_options px-0">
                                                <div class="form-group">
                                                    <input class="form-control " type="checkbox" id="primary11" name="infra_facility[]" value="Playgrounds" required autocomplete="off">
                                                    <label for="primary11">Playgrounds</label>
                                                </div>
                                            </div>
                                            <div class="infra_options px-0">
                                                <div class="form-group">
                                                    <input class="form-control" type="checkbox" id="primary12" name="infra_facility[]" value="Auditorium" required autocomplete="off">
                                                    <label for="primary12">Auditorium </label>
                                                </div>
                                            </div>
                                            <div class="infra_options px-0">
                                                <div class="form-group">
                                                    <input class="form-control" type="checkbox" id="primary13" name="infra_facility[]" value="Extra Curricular Activities" required autocomplete="off">
                                                    <label for="primary13">Extra Curricular Activities</label>
                                                </div>
                                            </div>
                                            <div class="infra_options px-0">
                                                <div class="form-group">
                                                    <input class="form-control" type="checkbox" id="primary14" name="infra_facility[]" value="Cafeteria" required autocomplete="off">
                                                    <label for="primary14">Cafeteria</label>
                                                </div>
                                            </div>
                                            <div class="infra_options px-0">
                                                <div class="form-group">
                                                    <input class="form-control" type="checkbox" id="primary15" name="infra_facility[]" value="Counselling Suport" required autocomplete="off">
                                                    <label for="primary15">Counselling Suport</label>
                                                </div>
                                            </div>
                                            <div class="infra_options px-0">
                                                <div class="form-group">
                                                    <input class="form-control" type="checkbox" id="primary16" name="infra_facility[]" value="Special Education Support" required autocomplete="off">
                                                    <label for="primary16">Special Education Support</label>
                                                </div>
                                            </div>
                                            <div class="infra_options px-0">
                                                <div class="form-group">
                                                    <input class="form-control" type="checkbox" id="primary17" name="infra_facility[]" value="Resource Room" required autocomplete="off">
                                                    <label for="primary17">Resource Room</label>
                                                </div>
                                            </div>
                                            <div class="infra_options px-0">
                                                <div class="form-group">
                                                    <input class="form-control" type="checkbox" id="primary18" name="infra_facility[]" value="First Aid Support" required autocomplete="off">
                                                    <label for="primary18">First Aid Support</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="container containerpadding">
                                        <label class="control-label heading" style="font-size: medium;font-family: 'Barlow Condensed', sans-serif;">
                                            2.Is the School Curriculam Supportive of these Educational Components:
                                        </label>
                                        <span class="error-star" style="color:red;">*</span>
                                        <div class="d-flex flex-wrap ">
                                            <div class="infra_options px-0">
                                                <div class="form-group">
                                                    <input class="form-control" type="checkbox" id="primary19" name="school_curriculam[]" value="Experimental Learning" required autocomplete="off">
                                                    <label for="primary19">Experimental Learning</label>
                                                </div>
                                            </div>
                                            <div class="infra_options px-0">
                                                <div class="form-group">
                                                    <input class="form-control " type="checkbox" id="primary20" name="school_curriculam[]" value="Differentiated Learning" required autocomplete="off">
                                                    <label for="primary20">Differentiated Learning</label>
                                                </div>
                                            </div>
                                            <div class="infra_options px-0">
                                                <div class="form-group">
                                                    <input class="form-control" type="checkbox" id="primary21" name="school_curriculam[]" value="Multiple Intelligence" required autocomplete="off">
                                                    <label for="primary21">Multiple Intelligence</label>
                                                </div>
                                            </div>
                                            <div class="infra_options px-0">
                                                <div class="form-group">
                                                    <input class="form-control " type="checkbox" id="primary22" name="school_curriculam[]" value="Learning Style" required autocomplete="off">
                                                    <label for="primary22">Learning Style</label>
                                                </div>
                                            </div>
                                            <div class="infra_options px-0">
                                                <div class="form-group">
                                                    <input class="form-control " type="checkbox" id="primary23" name="school_curriculam[]" value="Universal design for Learning" required autocomplete="off">
                                                    <label for="primary23">Universal Design for Learning</label>
                                                </div>
                                            </div>
                                            <div class="infra_options px-0">
                                                <div class="form-group">
                                                    <input class="form-control" type="checkbox" id="primary24" name="school_curriculam[]" value="Social Emotional Curriculam" required autocomplete="off">
                                                    <label for="primary24">Social Emotional curriculum</label>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                    <div class="container containerpadding">
                                        <label class="control-label heading" style="font-size: medium;font-family: 'Barlow Condensed', sans-serif;">
                                            3.Has Your School Implemented the Policies:
                                        </label>
                                        <span class="error-star" style="color:red;">*</span>
                                        <div class="d-flex flex-wrap ">
                                            <div class="infra_options px-0">
                                                <div class="form-group">
                                                    <input class="form-control" type="checkbox" id="primary25" name="school_policy[]" value="Child Protection Policy" required autocomplete="off">
                                                    <label for="primary25">Child Protection Policy</label>
                                                </div>
                                            </div>
                                            <div class="infra_options px-0">
                                                <div class="form-group">
                                                    <input class="form-control " type="checkbox" id="primary26" name="school_policy[]" value="Health & Safety" required autocomplete="off">
                                                    <label for="primary26">Health & Safety</label>
                                                </div>
                                            </div>
                                            <div class="infra_options px-0">
                                                <div class="form-group">
                                                    <input class="form-control" type="checkbox" id="primary27" name="school_policy[]" value="RTE Act 2009" required autocomplete="off">
                                                    <label for="primary27">RTE Act 2009</label>
                                                </div>
                                            </div>
                                            <div class="infra_options px-0">
                                                <div class="form-group">
                                                    <input class="form-control " type="checkbox" id="primary28" name="school_policy[]" value="Barrier Free Environment(Accessibility)" required autocomplete="off">
                                                    <label for="primary28">Barrier Free Environment(Accessibility)</label>
                                                </div>
                                            </div>
                                            <div class="infra_options px-0">
                                                <div class="form-group">
                                                    <input class="form-control " type="checkbox" id="primary29" name="school_policy[]" value="Grievance Redressal Committee" required autocomplete="off">
                                                    <label for="primary29">Grievance Redressal Committee</label>
                                                </div>
                                            </div>


                                        </div>
                                    </div>


                                </div>


                                <div class="col-md-12 text-center">

                                    <a type="button" class="btn btn-labeled btn-info" onclick="DoAction('tab1');" title="Back" style="background: blue !important; border-color:blue !important; color:white !important">
                                        <span class="btn-label" style="font-size:13px !important;"><i class="fa fa-arrow-left"></i></span> Back</a>

                                    <button class="btn btn-primary" type="reset" title="Clear"><i class="fa fa-undo"></i> Clear</button>&nbsp;

                                    <!-- <a type="button" onclick="save('submitted')" id="submitbutton" class="btn btn-labeled btn-succes" title="save" style="background: green !important; border-color:green !important; color:white !important">
                                        <span class="btn-label" style="font-size:13px !important;"><i class="fa fa-check"></i></span> Save</a>
 -->



                                    <a type="button" class="btn btn-labeled btn-info" onclick="DoAction('tab3');" title="Next" style="background: blue !important; border-color:#4d94ff !important; color:white !important">
                                        <span class="btn-label" style="font-size:13px !important;">Next <i class="fa fa-arrow-right"></i></a>

                                </div>
                            </section>
                        </div>

                        <div class="tab-pane fade show" id="tab3" role="tabpanel" aria-labelledby="contact-tab">



                            <section class="section">
                                <div class="section-body mt-1">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label class="control-label heading">1.Does the School have an Enclusion Policy that specifies action for including children with special needs?</label><span class="error-star" style="color:red;">*</span>
                                                <br>
                                                <input type="radio" id="question1" name="have_exclusion_policy" value="Yes" onchange="profileval(this)"><label class="questionpadding" for="featured-1">YES</label>


                                                <input type="radio" id="question2" name="have_exclusion_policy" value="No" onchange="profileval(this)"><label class="questionpadding" for="featured-2">NO</label>
                                            </div>
                                        </div>

                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label class="control-label heading">2.Is a Multidisciplinary team approches in your school to provide alternatives to suspension or expulsion for students with complex needs?<span class="error-star" style="color:red;">*</span></label>
                                                <br>
                                                <input type="radio" id="question3" name="multidisciplinary_team" value="Yes" onclick="question(this)"><label class="questionpadding" for="featured-1">YES</label>


                                                <input type="radio" id="question4" name="multidisciplinary_team" value="No" onclick="question(this)"><label class="questionpadding" for="featured-2">NO</label>
                                            </div>
                                        </div>

                                        <div class="col-md-12" id="question5">
                                            <div class="form-group">
                                                <label class="control-label heading">3.Is there a shared framework for goals and outcomes of multidisciplinary teams work in your school:</label><span class="error-star" style="color:red;">*</span>

                                                <textarea class="form-control" name="multidisciplinary_team_desc" value="" oninput="textAddress(event)"></textarea>



                                            </div>
                                        </div>

                                        <div class="col-md-12" style="display: flex;justify-content: center;margin: 0 0 5px 0;">
                                            {!! app('captcha')->display() !!}
                                        </div>

                                    </div>
                                    <div class="col-md-12 text-center">

                                        <a type="button" class="btn btn-labeled btn-info" onclick="DoAction('tab2');" title="Back" style="background: blue !important; border-color:blue !important; color:white !important">
                                            <span class="btn-label" style="font-size:13px !important;"><i class="fa fa-arrow-left"></i></span> Back</a>

                                        <a type="button" onclick="submit('submitted')" id="submitbutton" class="btn btn-labeled btn-succes" title="Submit" style="background: green !important; border-color:green !important; color:white !important">
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
<script>
    function question(a)

    {

        document.getElementById('question5').style.display = (a.value === "Yes") ? "block" : "none";

    }
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

<script src="https://code.jquery.com/jquery-1.7.2.min.js"></script>

<script type="text/javascript">
    const inputchange = (event) => {
        // other_specialist
        let other = document.getElementById('other');
        let otherspecialist = document.getElementById('other_specialist');
        otherspecialist.style.display = (other.checked == true) ? "inline-block" : "none";
    }
    const service = (event) => {
        document.getElementById('organisationd').style.display = (document.getElementById('organisation').checked == true) ? "block" : "none";
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
    const urlPattern = /^(https?:\/\/)?(localhost|[\w-]+(\.[\w-]+)+\/?)([^\s]*)?$/;

    function extractURLs(text) {
        const urlPattern = /(https?:\/\/\S+)/g;
        return text.match(urlPattern) || [];
    }

    function removeURLs(text) {
        const urlPattern = /(https?:\/\/\S+)/g;
        return text.replace(urlPattern, '');
    }

    function SchoolName(event) {
        let value = event.target.value || '';
        value = value.replace(/[^a-z A-Z ]/, '', );
        event.target.value = value;

    }

    function PrincipalName(event) {
        let value = event.target.value || '';
        value = value.replace(/[^a-z A-Z ]/, '', );
        event.target.value = value;

    }

    function BuildingName(event) {
        let value = event.target.value || '';
        value = value.replace(/[^a-z A-Z ]/, '', );
        event.target.value = value;

    }

    function DistrictName(event) {
        let value = event.target.value || '';
        value = value.replace(/[^a-z A-Z ]/, '', );
        event.target.value = value;

    }

    function BuildingContact(event) {
        let value = event.target.value || '';
        value = value.replace(/[^0-9+ ]/, '', );
        event.target.value = value;

    }

    function Admincontact(event) {
        let value = event.target.value || '';
        value = value.replace(/[^0-9+ ]/, '', );
        event.target.value = value;

    }

    function PhoneNumber(event) {
        let value = event.target.value || '';
        value = value.replace(/[^0-9+ ]/, '', );
        event.target.value = value;

    }

    function TelephoneNumber(event) {
        let value = event.target.value || '';
        value = value.replace(/[^0-9+ ]/, '', );
        event.target.value = value;

    }

    function Establishment(event) {
        let value = event.target.value || '';
        value = value.replace(/[^0-9+ ]/, '', );
        event.target.value = value;

    }

    function Studentpopulation(event) {
        let value = event.target.value || '';
        value = value.replace(/[^0-9+ ]/, '', );
        event.target.value = value;

    }

    function TeacherPopulation(event) {
        let value = event.target.value || '';
        value = value.replace(/[^0-9+ ]/, '', );
        event.target.value = value;

    }

    function textCheck(event) {
        let value = event.target.value || '';
        // value = extractURLs(value);
        value = removeURLs(value);
        value = value.replace(/[^a-z A-Z ]/, '', );
        event.target.value = value;
    }

    function textAddress(event) {
        let value = event.target.value || '';
        // value = extractURLs(value);
        value = removeURLs(value);
        // value = value.replace(/[^a-z A-Z ]/, '', );
        event.target.value = value;
    }

    function NumericCheck(event) {
        let value = event.target.value || '';
        // value = extractURLs(value);
        value = removeURLs(value);
        value = value.replace(/[^0-9+ ]/, '', );
        event.target.value = value;
    }

    function submit() {


        var school_name = $('#school_name').val();

        if (school_name == '') {
            swal("Please Enter School Name: ", "", "error");
            return false;
        }

        var school_principal_name = $('.school_principal_name').val();

        if (school_principal_name == '') {
            swal("Please Enter Principal Name:", "", "error");
            return false;
        }

        var school_building_name = $('#school_building_name').val();

        if (school_building_name == '') {
            swal("Please Enter Building Name:", "", "error");
            return false;
        }

        var school_builiding_address = $('#school_builiding_address').val();

        if (school_builiding_address == '') {
            swal("Please Enter Building Address:", "", "error");
            return false;
        }

        var school_district = $('#school_district').val();

        if (school_district == '') {
            swal("Please Enter School District:", "", "error");
            return false;
        }

        var building_contract = $('#building_contract').val();

        if (building_contract == '') {
            swal("Please Enter Building Contact:", "", "error");
            return false;
        }

        var admin_contract = $('#admin_contract').val();

        if (admin_contract == '') {
            swal("Please Enter Administration Contact:", "", "error");
            return false;
        }

        var phone_number = $('#phone_number').val();

        if (phone_number == '') {
            swal("Please Enter Phone Number:", "", "error");
            return false;
        }

        var telephone_number = $('#telephone_number').val();

        if (telephone_number == '') {
            swal("Please Enter Telephone Number:", "", "error");
            return false;
        }

        var school_email = $('#school_email').val();

        if (school_email == '') {
            swal("Please Enter  Email Address:", "", "error");
            return false;
        }




        var year_of_establishment = $('#year_of_establishment').val();

        if (year_of_establishment == '') {
            swal("Please Enter Year of Establishment:", "", "error");
            return false;
        }

        var totalstudent_population = $('#totalstudent_population').val();

        if (totalstudent_population == '') {
            swal("Please Enter Total no.of Student Population  ", "", "error");
            return false;
        }

        var totalteacher_population = $('#totalteacher_population').val();

        if (totalteacher_population == '') {
            swal("Please Enter Total no. of Teacher Population  ", "", "error");
            return false;
        }
        // building_contract // admin_contract // phone_number // telephone_number
        if (building_contract == admin_contract) {
            swal("Building Contact and Administration Contact Should not be same", "", "error");
            return false;
        }
        if (building_contract == phone_number) {
            swal("Building Contact and Phone Number Should not be same", "", "error");
            return false;
        }
        if (building_contract == telephone_number) {
            swal("Building Contact and Telephone Number Should not be same", "", "error");
            return false;
        }
        // 
        // building_contract // admin_contract // phone_number // telephone_number
        if (admin_contract == building_contract) {
            swal("Building Contact and Administration Contact Should not be same", "", "error");
            return false;
        }
        if (admin_contract == phone_number) {
            swal("Administration Contact and Phone Number Should not be same", "", "error");
            return false;
        }
        if (admin_contract == telephone_number) {
            swal("Telephone Number and Administration Contact Should not be same", "", "error");
            return false;
        }
        // 
        // building_contract // admin_contract // phone_number // telephone_number
        if (phone_number == admin_contract) {
            swal("Phone Number and Administration Contact Should not be same", "", "error");
            return false;
        }
        if (phone_number == building_contract) {
            swal("Phone Number and Building Contact Should not be same", "", "error");
            return false;
        }
        if (phone_number == telephone_number) {
            swal("Phone Number and Telephone Number Should not be same", "", "error");
            return false;
        }
        // 
        // building_contract // admin_contract // phone_number // telephone_number
        if (telephone_number == admin_contract) {
            swal("Telephone Number and Administration Contact Should not be same", "", "error");
            return false;
        }
        if (telephone_number == building_contract) {
            swal("Building Contact and Telephone Number Should not be same", "", "error");
            return false;
        }
        if (telephone_number == phone_number) {
            swal("Telephone Number and Phone Number Should not be same", "", "error");
            return false;
        }
        // 
        var primary1 = document.getElementById("primary1");
        var primary2 = document.getElementById("primary2");
        var primary3 = document.getElementById("primary3");



        if ((primary1.checked == false) && (primary2.checked == false) && (primary3.checked == false)) {

            swal({
                title: "Error",
                text: "Please Select School Type",
                type: 'error',
                confirmButtontext: "OK"
            });

            return false;

        }

        var primary4 = document.getElementById("primary4");
        var primary5 = document.getElementById("primary5");
        var primary6 = document.getElementById("primary6");



        if ((primary4.checked == false) && (primary5.checked == false) && (primary6.checked == false)) {

            swal({
                title: "Error",
                text: "Please Student Teacher Ratio",
                type: 'error',
                confirmButtontext: "OK"
            });

            return false;

        }

        var primary7 = document.getElementById("primary7");
        var primary8 = document.getElementById("primary8");
        var primary9 = document.getElementById("primary9");
        var primary10 = document.getElementById("primary10");
        var primary11 = document.getElementById("primary11");
        var primary12 = document.getElementById("primary12");
        var primary13 = document.getElementById("primary13");
        var primary14 = document.getElementById("primary14");
        var primary15 = document.getElementById("primary15");
        var primary16 = document.getElementById("primary16");
        var primary17 = document.getElementById("primary17");
        var primary18 = document.getElementById("primary18");
        if ((primary7.checked == false) && (primary8.checked == false) && (primary9.checked == false) && (primary10.checked == false) && (primary11.checked == false) && (primary12.checked == false) && (primary13.checked == false) && (primary14.checked == false) && (primary15.checked == false) && (primary16.checked == false) && (primary17.checked == false) && (primary18.checked == false)) {

            swal({
                title: "Error",
                text: "Please Enter Infrastructure Facility",
                type: 'error',
                confirmButtontext: "OK"
            });

            return false;

        }

        var primary19 = document.getElementById("primary19");
        var primary20 = document.getElementById("primary20");
        var primary21 = document.getElementById("primary21");
        var primary22 = document.getElementById("primary22");
        var primary23 = document.getElementById("primary23");
        var primary24 = document.getElementById("primary24");

        if ((primary19.checked == false) && (primary20.checked == false) && (primary21.checked == false) && (primary22.checked == false) && (primary23.checked == false) && (primary24.checked == false)) {

            swal({
                title: "Error",
                text: "Please Enter School Curriculam",
                type: 'error',
                confirmButtontext: "OK"
            });

            return false;

        }
        var primary25 = document.getElementById("primary25");
        var primary26 = document.getElementById("primary26");
        var primary27 = document.getElementById("primary27");
        var primary28 = document.getElementById("primary28");
        var primary29 = document.getElementById("primary29");


        if ((primary25.checked == false) && (primary26.checked == false) && (primary27.checked == false) && (primary28.checked == false) && (primary29.checked == false)) {

            swal({
                title: "Error",
                text: "Please Enter Has Your School Implemented the Policies",
                type: 'error',
                confirmButtontext: "OK"
            });

            return false;

        }









        var have_exclusion_policy = $('input[name="have_exclusion_policy"]:checked').val();



        if (have_exclusion_policy !== "Yes" && have_exclusion_policy !== "No") {

            swal({
                title: "Error",
                text: "Please Choose Yes/No from Exclusion Policy",
                type: 'error',
                confirmButtontext: "OK"
            });

            return false;
        }

        var multidisciplinary_team = $('input[name="multidisciplinary_team"]:checked').val();



        if (multidisciplinary_team !== "Yes" && multidisciplinary_team !== "No") {

            swal({
                title: "Error",
                text: "Please Choose Yes/No from Multidiscilinary Team",
                type: 'error',
                confirmButtontext: "OK"
            });

            return false;

        }

        var multidisciplinary_team_desc = $('#multidisciplinary_team_desc').val();

        if (multidisciplinary_team_desc == '' && multidisciplinary_team !== "No") {
            swal("Please Enter Multidiscilinary Team in Your School  ", "", "error");
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

        // document.getElementById('newenrollement').submit('saved');
    }
</script>
@endsection