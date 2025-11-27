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

    .infra_options {
        width: calc(100% / 3);
    }

    .infra_options .form-group {
        margin-bottom: 0rem;
    }

    .heading {
        font-weight: bold !important;
    }

    .containerpadding {
        padding: 1rem;
    }

    #question5 {
        display: none;
    }

    .questionpadding {
        padding: 5px;
    }
</style>

<div class="main-content">
    {{ Breadcrumbs::render('enrollement.schoolshow',$rows[0]['school_enrollment_id']) }}

    <div class="row justify-content-center">

        <div class="col-12">
            <div class="card" style="height:100%; padding: 15px; background-color:white">
                <div class="col-lg-12 text-center" style="padding: 10px;">
                    <h4 style="color:darkblue;">Enrolled Campus Summary</h4>
                </div>
                @foreach($rows as $key=>$row)

                <div class="tile" id="tile-1" style="margin-top:10px !important; margin-bottom:10px !important;">

                    <!-- Nav tabs -->
                    <ul class="nav nav-tabs nav-justified" style="width:75%; margin:auto;" id="tabs" role="tablist">

                        <li class="nav-item">
                            <a class="nav-link active internlabel" style="cursor: pointer; border:none;font-size: 19px; font-family: 'Barlow Condensed', sans-serif;" id="home-tab" name="tab1" data-toggle="tab" role="tab" aria-controls="home" aria-selected="true">School Details</a>
                            <div class="check" id="gct"></div>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link  internlabel" style="cursor: pointer; border:none;font-size: 19px; font-family: 'Barlow Condensed', sans-serif;" id="service-tab" name="tab2" data-toggle="tab" role="tab" aria-controls="home" aria-selected="true">School Policy</a>
                            <div class="check" id="expct"></div>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link internlabel" style="cursor: pointer; border:none;font-size: 19px; font-family: 'Barlow Condensed', sans-serif;" id="contact-tab" name="tab3" data-toggle="tab" role="tab" aria-controls="contact" aria-selected="false">General Questions</a>
                            <div class="check" id="expct"></div>
                        </li>



                    </ul>
                </div>

                <br>

                <div class="tab-content" id="tab-content">
                    <div class="tab-pane fade show active" id="tab1" role="tabpanel" aria-labelledby="home-tab">


                        <section class="section">
                            <div class="section-body mt-1">
                                <hr>
                                <h5 style=" display:flex;   width: fit-content; padding: -13px;   margin-top: -19px;margin-left: auto;margin-right: auto;padding: 5px;background-color: white; font-family: 'Barlow Condensed', sans-serif;">School Details</h5>


                                <div class="row">
                                    <input type="hidden" id="selected_id" name="selected_id" value="">

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="control-label childname">School Name: </label><span class="error-star" style="color:red;">*</span>
                                            <input class="form-control default" type="text" id="school_name" name="school_name" oninput="SchoolName(event)" maxlength="20" value="{{ $row['school_name']}}" autocomplete="off" disabled>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="control-label childname">Principal Name: </label><span class="error-star" style="color:red;">*</span>
                                            <input class="form-control default school_principal_name" type="text" id="school_principal_name" name="school_principal_name" oninput="PrincipalName(event)" maxlength="20" value="{{ $row['school_principal_name']}}" autocomplete="off" disabled>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="control-label childname">Building Name: </label><span class="error-star" style="color:red;">*</span>
                                            <input class="form-control default" type="text" id="school_building_name" name="school_building_name" oninput="BuildingName(event)" maxlength="20" value="{{ $row['school_building_name']}}" autocomplete="off" disabled>
                                        </div>
                                    </div>



                                </div>




                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="control-label childname">Building Address: </label><span class="error-star" style="color:red;">*</span>
                                            <input class="form-control default" type="text" id="school_builiding_address" name="school_builiding_address" value="{{ $row['school_builiding_address']}}" autocomplete="off" disabled>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="control-label childname">School District:</label><span class="error-star" style="color:red;">*</span>
                                            <input class="form-control default" type="text" id="school_district" name="school_district" oninput="DistrictName(event)" maxlength="20" value="{{ $row['school_district']}}" autocomplete="off" disabled>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="control-label childname">Building Contact:</label><span class="error-star" style="color:red;">*</span>
                                            <input class="form-control default" type="text" id="building_contract" name="building_contract" oninput="BuildingContact(event)" maxlength="10" value="{{ $row['building_contract']}}" autocomplete="off" disabled>
                                        </div>
                                    </div>

                                </div>

                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="control-label childname">Administration Contact: </label><span class="error-star" style="color:red;">*</span>
                                            <input class="form-control default" type="text" id="admin_contract" name="admin_contract" oninput="Admincontact(event)" maxlength="10" value="{{ $row['admin_contract']}}" autocomplete="off" disabled>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="control-label childname">Phone Number:</label><span class="error-star" style="color:red;">*</span>
                                            <input class="form-control default" type="text" id="phone_number" name="phone_number" oninput="PhoneNumber(event)" maxlength="10" value="{{ $row['phone_number']}}" autocomplete="off" disabled>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="control-label childname">Telephone Number:</label><span class="error-star" style="color:red;">*</span>
                                            <input class="form-control default" type="text" id="telephone_number" name="telephone_number" oninput="TelephoneNumber(event)" maxlength="10" value="{{ $row['telephone_number']}}" autocomplete="off" disabled>
                                        </div>
                                    </div>






                                </div>

                                <div class="row">


                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="control-label">School Type: </label><span class="error-star" style="color:red;">*</span>
                                            <div class="d-flex">
                                                <div class="d-flex" style="align-items: center;">
                                                    @if(in_array('Primary',$schooltype))
                                                    <input type="checkbox" id="primary1" name="school_type[]" value="Primary" checked required autocomplete="off" onclick="return false" style="margin: 5px;">Primary
                                                    <!-- <label for="primary1" style="padding: 5px;">Primary</label> -->
                                                    @else
                                                    <input type="checkbox" id="primary1" name="school_type[]" value="Primary" required autocomplete="off" disabled style="margin: 5px;">Primary
                                                    <!-- <label for="primary1" style="padding: 5px;">Primary</label> -->
                                                    @endif
                                                </div>
                                                <div class="d-flex" style="align-items: center;">
                                                    @if(in_array('HS',$schooltype))
                                                    <input type="checkbox" id="primary2" name="school_type[]" value="HS" checked required autocomplete="off" onclick="return false" style="margin: 5px;">HS
                                                    <!-- <label for="primary2" style="padding: 5px;">HS</label> -->
                                                    @else
                                                    <input type="checkbox" id="primary2" name="school_type[]" value="HS" required autocomplete="off" disabled style="margin: 5px;">Hs
                                                    <!-- <label for="primary2" style="padding: 5px;">HS</label> -->
                                                    @endif
                                                </div>
                                                <div class="d-flex" style="align-items: center;">
                                                    @if(in_array('IE',$schooltype))
                                                    <input type="checkbox" id="primary3" name="school_type[]" value="IE" checked required autocomplete="off" onclick="return false" style="margin: 5px;">IE
                                                    <!-- <label for="primary3" style="padding: 5px;">IE </label> -->
                                                    @else
                                                    <input type="checkbox" id="primary3" name="school_type[]" value="IE" required autocomplete="off" disabled style="margin: 5px;">IE
                                                    <!-- <label for="primary3" style="padding: 5px;">IE </label> -->
                                                    @endif
                                                </div>
                                            </div>
                                        </div>



                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="control-label childname">Year of Establishment:</label><span class="error-star" style="color:red;">*</span>
                                            <input class="form-control default" type="text" id="year_of_establishment" name="year_of_establishment" oninput="Establishment(event)" maxlength="20" value="{{ $row['year_of_establishment']}}" autocomplete="off" disabled>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="control-label childname">Total Number of Student Population:</label><span class="error-star" style="color:red;">*</span>
                                            <input class="form-control default" type="text" id="totalstudent_population" name="totalstudent_population" oninput="Studentpopulation(event)" maxlength="20" value="{{ $row['totalstudent_population']}}" autocomplete="off" disabled>
                                        </div>
                                    </div>

                                </div>

                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="control-label childname">Total Number of Teacher Population:</label><span class="error-star" style="color:red;">*</span>
                                            <input class="form-control default" type="text" id="totalteacher_population" name="totalteacher_population" oninput="TeacherPopulation(event)" maxlength="20" value="{{ $row['totalteacher_population']}}" autocomplete="off" disabled>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="control-label" style="font-size: medium;font-family: 'Barlow Condensed', sans-serif;">Student Teacher-Ratio: </label><span class="error-star" style="color:red;">*</span>
                                            <div class="d-flex">
                                                <div class="d-flex" style="align-items: center;">
                                                    @if(in_array('Primary',$schoolteacherratio))
                                                    <input type="checkbox" id="primary4" name="school_teacher_ratio[]" value="Primary" checked required autocomplete="off" onclick="return false" style="margin: 5px;">Primary
                                                    <!-- <label for="primary4">Primary</label> -->
                                                    @else
                                                    <input type="checkbox" id="primary4" name="school_teacher_ratio[]" value="Primary" required autocomplete="off" disabled style="margin: 5px;">Primary
                                                    <!-- <label for="primary4">Primary</label> -->
                                                    @endif
                                                </div>

                                                <div class="d-flex" style="align-items: center;">
                                                    @if(in_array('Secondary',$schoolteacherratio))

                                                    <input type="checkbox" id="primary5" name="school_teacher_ratio[]" value="Secondary" checked required autocomplete="off" onclick="return false" style="margin: 5px;">Secondary
                                                    <!-- <label for="primary5">Secondary</label> -->
                                                    @else
                                                    <input type="checkbox" id="primary5" name="school_teacher_ratio[]" value="Secondary" required autocomplete="off" disabled style="margin: 5px;">Secondary
                                                    <!-- <label for="primary5">Secondary</label> -->
                                                    @endif
                                                </div>

                                                <div class="d-flex" style="align-items: center;">
                                                    @if(in_array('Higher Secondary',$schoolteacherratio))
                                                    <input type="checkbox" id="primary6" name="school_teacher_ratio[]" value="Higher Secondary" checked required autocomplete="off" onclick="return false" style="margin: 5px;">Higher Secondary
                                                    <!-- <label for="primary6">Higher Secondary </label> -->
                                                    @else
                                                    <input type="checkbox" id="primary6" name="school_teacher_ratio[]" value="Higher Secondary " required autocomplete="off" disabled style="margin: 5px;">Higher Secondary
                                                    <!-- <label for="primary6">Higher Secondary </label> -->
                                                    @endif
                                                </div>
                                            </div>
                                        </div>



                                    </div>



                                </div>
                                <div class="col-md-12 text-center">

                                    <a type="button" class="btn btn-labeled back-btn" title="Cancel" href="{{ route('enrollement.schoollist') }}" style="color:white !important">
                                        <span class="btn-label" style="font-size:13px !important;"><i class="fa fa-times"></i></span> Cancel</a>
                                    <a type="button" class="btn btn-labeled btn-info" onclick="DoAction('tab2');" title="Next" style="background: blue !important; border-color:#4d94ff !important; color:white !important">
                                        <span class="btn-label" style="font-size:13px !important;">Next</span> <i class="fa fa-arrow-right"></i></a>

                                </div>
                        </section>

                    </div>









                    <div class="tab-pane fade show" id="tab2" role="tabpanel" aria-labelledby="contact-tab">



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
                                                @if(in_array('Science Labs',$infrastructure))
                                                <input type="checkbox" id="primary7" name="infra_facility[]" value="Science Labs" checked required autocomplete="off" onclick="return false">
                                                <label for="primary7">Science Labs</label>
                                                @else
                                                <input type="checkbox" id="primary7" name="infra_facility[]" value="Science Labs" required autocomplete="off" disabled>
                                                <label for="primary7">Science Labs</label>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="infra_options px-0">
                                            <div class="form-group">
                                                @if(in_array('Library',$infrastructure))
                                                <input type="checkbox" id="primary8" name="infra_facility[]" value="Library" checked required autocomplete="off" onclick="return false">
                                                <label for="primary8">Library</label>
                                                @else
                                                <input type="checkbox" id="primary8" name="infra_facility[]" value="Library" required autocomplete="off" disabled>
                                                <label for="primary8">Library</label>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="infra_options px-0">
                                            <div class="form-group">
                                                @if(in_array('Art Room',$infrastructure))
                                                <input type="checkbox" id="primary9" name="infra_facility[]" value="Art Room" checked required autocomplete="off" onclick="return false">
                                                <label for="primary9">Art Room</label>
                                                @else
                                                <input type="checkbox" id="primary9" name="infra_facility[]" value="Art Room" required autocomplete="off" disabled>
                                                <label for="primary9">Art Room</label>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="infra_options px-0">
                                            <div class="form-group">
                                                @if(in_array('Sports(Indoor and Outdoor)',$infrastructure))
                                                <input type="checkbox" id="primary10" name="infra_facility[]" value="Sports(Indoor and Outdoor)" checked required autocomplete="off" onclick="return false">
                                                <label for="primary10">Sports(Indoor and Outdoor)</label>
                                                @else
                                                <input type="checkbox" id="primary10" name="infra_facility[]" value="Sports(Indoor and Outdoor)" required autocomplete="off" disabled>
                                                <label for="primary10">Sports(Indoor and Outdoor)</label>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="infra_options px-0">
                                            <div class="form-group">
                                                @if(in_array('Playgrounds',$infrastructure))
                                                <input type="checkbox" id="primary11" name="infra_facility[]" value="Playgrounds" checked required autocomplete="off" onclick="return false">
                                                <label for="primary11">Playgrounds</label>
                                                @else
                                                <input type="checkbox" id="primary11" name="infra_facility[]" value="Playgrounds" required autocomplete="off" disabled>
                                                <label for="primary11">Playgrounds</label>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="infra_options px-0">
                                            <div class="form-group">
                                                @if(in_array('Auditorium',$infrastructure))
                                                <input type="checkbox" id="primary12" name="infra_facility[]" value="Auditorium" checked required autocomplete="off" onclick="return false">
                                                <label for="primary12">Auditorium </label>
                                                @else
                                                <input type="checkbox" id="primary12" name="infra_facility[]" value="Auditorium" required autocomplete="off" disabled>
                                                <label for="primary12">Auditorium </label>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="infra_options px-0">
                                            <div class="form-group">
                                                @if(in_array('Extra Curricular Activities',$infrastructure))
                                                <input type="checkbox" id="primary13" name="infra_facility[]" value="Extra Curricular Activities" checked required autocomplete="off" onclick="return false">
                                                <label for="primary13">Extra Curricular Activities</label>
                                                @else
                                                <input type="checkbox" id="primary13" name="infra_facility[]" value="Extra Curricular Activities" required autocomplete="off" disabled>
                                                <label for="primary13">Extra Curricular Activities</label>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="infra_options px-0">
                                            <div class="form-group">
                                                @if(in_array('Cafeteria',$infrastructure))
                                                <input type="checkbox" id="primary14" name="infra_facility[]" value="Cafeteria" checked required autocomplete="off" onclick="return false">
                                                <label for="primary14">Cafeteria</label>
                                                @else
                                                <input type="checkbox" id="primary14" name="infra_facility[]" value="Cafeteria" required autocomplete="off" disabled>
                                                <label for="primary14">Cafeteria</label>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="infra_options px-0">
                                            <div class="form-group">
                                                @if(in_array('Counselling Suport',$infrastructure))
                                                <input type="checkbox" id="primary15" name="infra_facility[]" value="Counselling Suport" checked required autocomplete="off" onclick="return false">
                                                <label for="primary15">Counselling Suport</label>
                                                @else
                                                <input type="checkbox" id="primary15" name="infra_facility[]" value="Counselling Suport" required autocomplete="off" disabled>
                                                <label for="primary15">Counselling Suport</label>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="infra_options px-0">
                                            <div class="form-group">
                                                @if(in_array('Special Education Support',$infrastructure))
                                                <input type="checkbox" id="primary16" name="infra_facility[]" value="Special Education Support" checked required autocomplete="off" onclick="return false">
                                                <label for="primary16">Special Education Support</label>
                                                @else
                                                <input type="checkbox" id="primary16" name="infra_facility[]" value="Special Education Support" required autocomplete="off" disabled>
                                                <label for="primary16">Special Education Support</label>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="infra_options px-0">
                                            <div class="form-group">
                                                @if(in_array('Resource Room',$infrastructure))
                                                <input type="checkbox" id="primary17" name="infra_facility[]" value="Resource Room" checked required autocomplete="off" onclick="return false">
                                                <label for="primary17">Resource Room</label>
                                                @else
                                                <input type="checkbox" id="primary17" name="infra_facility[]" value="Resource Room" required autocomplete="off" disabled>
                                                <label for="primary17">Resource Room</label>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="infra_options px-0">
                                            <div class="form-group">
                                                @if(in_array('First Aid Support',$infrastructure))
                                                <input type="checkbox" id="primary18" name="infra_facility[]" value="First Aid Support" checked required autocomplete="off" onclick="return false">
                                                <label for="primary18">First Aid Support</label>
                                                @else
                                                <input type="checkbox" id="primary18" name="infra_facility[]" value="First Aid Support" required autocomplete="off" disabled>
                                                <label for="primary18">First Aid Support</label>
                                                @endif
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
                                                @if(in_array('Experimental Learning',$curriculam))
                                                <input type="checkbox" id="primary19" name="school_curriculam[]" value="Experimental Learning" checked required autocomplete="off" onclick="return false">
                                                <label for="primary19">Experimental Learning</label>
                                                @else
                                                <input type="checkbox" id="primary19" name="school_curriculam[]" value="Experimental Learning" required autocomplete="off" disabled>
                                                <label for="primary19">Experimental Learning</label>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="infra_options px-0">
                                            <div class="form-group">
                                                @if(in_array('Differentiated Learning',$curriculam))
                                                <input type="checkbox" id="primary20" name="school_curriculam[]" value="Differentiated Learning" checked required autocomplete="off" onclick="return false">
                                                <label for="primary20">Differentiated Learning</label>
                                                @else
                                                <input type="checkbox" id="primary20" name="school_curriculam[]" value="Differentiated Learning" required autocomplete="off" disabled>
                                                <label for="primary20">Differentiated Learning</label>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="infra_options px-0">
                                            <div class="form-group">
                                                @if(in_array('Multiple Intelligence',$curriculam))
                                                <input type="checkbox" id="primary21" name="school_curriculam[]" value="Multiple Intelligence" checked required autocomplete="off" onclick="return false">
                                                <label for="primary21">Multiple Intelligence</label>
                                                @else
                                                <input type="checkbox" id="primary21" name="school_curriculam[]" value="Multiple Intelligence" required autocomplete="off" disabled>
                                                <label for="primary21">Multiple Intelligence</label>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="infra_options px-0">
                                            <div class="form-group">
                                                @if(in_array('Learning Style',$curriculam))
                                                <input type="checkbox" id="primary22" name="school_curriculam[]" value="Learning Style" checked required autocomplete="off" onclick="return false">
                                                <label for="primary22">Learning Style</label>
                                                @else
                                                <input type="checkbox" id="primary22" name="school_curriculam[]" value="Learning Style" required autocomplete="off" disabled>
                                                <label for="primary22">Learning Style</label>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="infra_options px-0">
                                            <div class="form-group">
                                                @if(in_array('Universal design for Learning',$curriculam))
                                                <input type="checkbox" id="primary23" name="school_curriculam[]" value="Universal design for Learning" checked required autocomplete="off" onclick="return false">
                                                <label for="primary23">Universal design for Learning</label>
                                                @else
                                                <input type="checkbox" id="primary23" name="school_curriculam[]" value="Universal design for Learning" required autocomplete="off" disabled>
                                                <label for="primary23">Universal design for Learning</label>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="infra_options px-0">
                                            <div class="form-group">
                                                @if(in_array('Social Emotional Curriculam',$curriculam))
                                                <input type="checkbox" id="primary24" name="school_curriculam[]" value="Social Emotional Curriculam" checked required autocomplete="off" onclick="return false">
                                                <label for="primary24">Social Emotional Curriculam</label>
                                                @else
                                                <input type="checkbox" id="primary24" name="school_curriculam[]" value="Social Emotional Curriculam" required autocomplete="off" disabled>
                                                <label for="primary24">Social Emotional Curriculam</label>
                                                @endif
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
                                                @if(in_array('Child Protection Policy',$policy))
                                                <input type="checkbox" id="primary25" name="school_policy[]" value="Child Protection Policy" checked required autocomplete="off" onclick="return false">
                                                <label for="primary25">Child Protection Policy</label>
                                                @else
                                                <input type="checkbox" id="primary25" name="school_policy[]" value="Child Protection Policy" required autocomplete="off" disabled>
                                                <label for="primary25">Child Protection Policy</label>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="infra_options px-0">
                                            <div class="form-group">
                                                @if(in_array('Health & Safety',$policy))
                                                <input type="checkbox" id="primary26" name="school_policy[]" value="Health & Safety" checked required autocomplete="off" onclick="return false">
                                                <label for="primary26">Health & Safety</label>
                                                @else
                                                <input type="checkbox" id="primary26" name="school_policy[]" value="Health & Safety" required autocomplete="off" disabled>
                                                <label for="primary26">Health & Safety</label>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="infra_options px-0">
                                            <div class="form-group">
                                                @if(in_array('RTE Act 2009',$policy))
                                                <input type="checkbox" id="primary27" name="school_policy[]" value="RTE Act 2009" checked required autocomplete="off" onclick="return false">
                                                <label for="primary27">RTE Act 2009</label>
                                                @else
                                                <input type="checkbox" id="primary27" name="school_policy[]" value="RTE Act 2009" required autocomplete="off" disabled>
                                                <label for="primary27">RTE Act 2009</label>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="infra_options px-0">
                                            <div class="form-group">
                                                @if(in_array('Barrier Free Environment(Accessibility)',$policy))
                                                <input type="checkbox" id="primary28" name="school_policy[]" value="Barrier Free Environment(Accessibility)" checked required autocomplete="off" onclick="return false">
                                                <label for="primary28">Barrier Free Environment(Accessibility)</label>
                                                @else
                                                <input type="checkbox" id="primary28" name="school_policy[]" value="Barrier Free Environment(Accessibility)" required autocomplete="off" disabled>
                                                <label for="primary28">Barrier Free Environment(Accessibility)</label>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="infra_options px-0">
                                            <div class="form-group">
                                                @if(in_array('Grievance Redressal Committee',$policy))
                                                <input type="checkbox" id="primary29" name="school_policy[]" value="Grievance Redressal Committee" checked required autocomplete="off" onclick="return false">
                                                <label for="primary29">Grievance Redressal Committee</label>
                                                @else
                                                <input type="checkbox" id="primary29" name="school_policy[]" value="Grievance Redressal Committee" required autocomplete="off" disabled>
                                                <label for="primary29">Grievance Redressal Committee</label>
                                                @endif
                                            </div>
                                        </div>


                                    </div>
                                </div>


                            </div>


                            <div class="col-md-12 text-center">


                                <a type="button" class="btn btn-labeled btn-info" onclick="DoAction('tab1');" title="Previous" style="background: blue !important; border-color:#4d94ff !important; color:white !important">
                                    <span class="btn-label" style="font-size:13px !important;"><i class="fa fa-arrow-left"></i></span>Previous</a>
                                <a type="button" class="btn btn-labeled back-btn" title="Cancel" href="{{ route('enrollement.schoollist') }}" style="color:white !important">
                                    <span class="btn-label" style="font-size:13px !important;"><i class="fa fa-times"></i></span> Cancel</a>
                                <a type="button" class="btn btn-labeled btn-info" onclick="DoAction('tab3');" title="Next" style="background: blue !important; border-color:#4d94ff !important; color:white !important">
                                    <span class="btn-label" style="font-size:13px !important;">Next</span> <i class="fa fa-arrow-right"></i></a>

                            </div>
                        </section>
                    </div>




                    <div class="tab-pane fade show" id="tab3" role="tabpanel" aria-labelledby="contact-tab">



                        <section class="section">
                            <div class="section-body mt-1">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="control-label heading">1.Does the School have an Enclusion Policy that specifies action for including children with special needs?:</label><span class="error-star" style="color:red;">*</span>
                                            <br>
                                            <input type="radio" id="question1" name="have_exclusion_policy" value="Yes" {{ ($row['have_exclusion_policy']=="Yes")? "checked" : "disabled" }} onchange="profileval(this)"><label class="questionpadding" for="featured-1">YES</label>


                                            <input type="radio" id="question2" name="have_exclusion_policy" value="No" {{ ($row['have_exclusion_policy']=="No")? "checked" : "disabled" }} onchange="profileval(this)"><label class="questionpadding" for="featured-2">NO</label>
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="control-label heading">2.Is a Multidisciplinary team approches in your school to provide alternatives to suspension or expulsion for students with complex needs?:<span class="error-star" style="color:red;">*</span></label>
                                            <br>
                                            <input type="radio" id="question3" name="multidisciplinary_team" value="Yes" {{ ($row['multidisciplinary_team']=="Yes")? "checked" : "disabled" }} onclick="question()"><label class="questionpadding" for="featured-1">YES</label>


                                            <input type="radio" id="question4" name="multidisciplinary_team" value="No" {{ ($row['multidisciplinary_team']=="No")? "checked" : "disabled" }} onchange="profileval(this)"><label class="questionpadding" for="featured-2">NO</label>
                                        </div>
                                    </div>

                                    <div class="col-md-12" id="question5">
                                        <div class="form-group">
                                            <label class="control-label heading">3.Is there a shared framework for goals and outcomes of multidisciplinary teams work in your school:</label><span class="error-star" style="color:red;">*</span>

                                            <textarea class="form-control" name="multidisciplinary_team_desc" value="{{ $row['multidisciplinary_team_desc']}}" onchange="profileval(this)" disabled></textarea>



                                        </div>
                                    </div>

                                </div>
                                <div class="col-md-12 text-center">

                                    <a type="button" class="btn btn-labeled btn-info" onclick="DoAction('tab2');" title="Previous" style="background: blue !important; border-color:#4d94ff !important; color:white !important">
                                        <span class="btn-label" style="font-size:13px !important;"><i class="fa fa-arrow-left"></i></span>Previous</a>
                                    <a type="button" class="btn btn-labeled back-btn" title="Cancel" href="{{ route('enrollement.schoollist') }}" style="color:white !important">
                                        <span class="btn-label" style="font-size:13px !important;"><i class="fa fa-times"></i></span> Cancel</a>

                                </div>
                        </section>

                    </div>










                </div>
                @endforeach
            </div>

        </div>


    </div>
</div>

<script src="https://code.jquery.com/jquery-1.7.2.min.js"></script>



<script type="text/javascript">
    function ndate(d) {

        date = d.value;


        var date_from = document.getElementById("date_of_stay_from").value;

        var date_to = document.getElementById("date_of_stay_to").value;
        if (date_from != "" && date_to != "") {
            const date1 = new Date(date_from);
            const date2 = new Date(date_to);
            console.log(getDifferenceInDays(date1, date2));

            function getDifferenceInDays(date1, date2) {
                const diffInMs = Math.abs(date2 - date1);
                document.getElementById("date_of_stay").value = diffInMs / (1000 * 60 * 60 * 24);
            }

            window.addval(date);
        }

    };
</script>
<script type="text/javascript">
    $(document).ready(function() {
        $("#content").find("[id^='tab']").hide(); // Hide all content
        $("#home-tab").addClass("active"); // Activate the first tab
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

        $("#tab-content").find("[id^='tab']").hide(); // Hide all content
        $('#' + $(this).attr('name')).fadeIn(); // Show content for the current tab

    });
    var actWidth = $("#tile-1 .nav-tabs").find(".active").parent("li").width();
    var actPosition = $("#tile-1 .nav-tabs .active").position();
    // $("#tile-1 .slider").css({
    //     "left": +actPosition.left,
    //     "width": actWidth
    // });


    function DoAction(id) {

        $("#tab-content").find("[id^='tab']").hide(); // Hide all content
        $("#tabs a").removeClass("active"); //Reset id's
        $("a[name='" + id + "']").addClass("active");
        var position = $("a[name='" + id + "']").position();
        var width = $("a[name='" + id + "']").width();
        $("#tile-1 .slider").css({
            "left": +position.left,
            "width": width
        });
        $('#' + (id)).fadeIn(); // Show content for the current tab


    }
</script>
<script type="application/javascript">
    var inputs = document.querySelectorAll('.file-input')

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

        document.getElementById('newenrollement').submit('saved');
    }
</script>


@endsection