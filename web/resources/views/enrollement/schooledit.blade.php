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
   
    

    
</style>
<div class="main-content">
    <div class="row justify-content-center">
        <div class="col-lg-12 col-md-12">
            <div class="card" style="height:100%; padding: 15px">
            @foreach($rows as $key=>$row)
                <form action="{{route('enrollement.update', $row['school_enrollment_id'])}}" method="POST" id="newenrollement" enctype="multipart/form-data" onsubmit="return false">
                    @csrf


                    <div class="tile" id="tile-1" style="margin-top:10px !important; margin-bottom:10px !important;">

                        <!-- Nav tabs -->
                        <ul class="nav nav-tabs nav-justified" id="tabs" role="tablist">
                            <div class="slider"></div>
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
                                       

                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label class="control-label childname">School Name: </label><span class="error-star" style="color:red;">*</span>
                                                <input class="form-control default" type="text" id="school_name" name="school_name" oninput="SchoolName(event)" maxlength="20" value="{{ $row['school_name']}}"  autocomplete="off">
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label class="control-label childname">Principal Name: </label><span class="error-star" style="color:red;">*</span>
                                                <input class="form-control default school_principal_name" type="text" id="school_principal_name" name="school_principal_name" oninput="PrincipalName(event)" maxlength="20" value="{{ $row['school_principal_name']}}" autocomplete="off">
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label class="control-label childname">Building Name: </label><span class="error-star" style="color:red;">*</span>
                                                <input class="form-control default" type="text" id="school_building_name" name="school_building_name" oninput="BuildingName(event)" maxlength="20" value="{{ $row['school_building_name']}}" autocomplete="off">
                                            </div>
                                        </div>
                                        
                                       

                                    </div>


                                   

                                    <div class="row">
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label class="control-label childname">Building Address: </label><span class="error-star" style="color:red;">*</span>
                                                    <input class="form-control default" type="text" id="school_builiding_address" name="school_builiding_address" value="{{ $row['school_builiding_address']}}"  autocomplete="off">
                                                </div>
                                            </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label class="control-label childname">School District:</label><span class="error-star" style="color:red;">*</span>
                                                        <input class="form-control default" type="text" id="school_district" name="school_district" oninput="DistrictName(event)" maxlength="20" value="{{ $row['school_district']}}"  autocomplete="off">
                                                    </div>
                                                </div>

                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label class="control-label childname">Building Contact:</label><span class="error-star" style="color:red;">*</span>
                                                        <input class="form-control default" type="text" id="building_contract" name="building_contract" oninput="BuildingContact(event)" maxlength="10" value="{{ $row['building_contract']}}"  autocomplete="off">
                                                    </div>
                                                </div>

                                    </div>

                                    <div class="row">
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label class="control-label childname">Administration Contact: </label><span class="error-star" style="color:red;">*</span>
                                                    <input class="form-control default" type="text" id="admin_contract" name="admin_contract" oninput="Admincontact(event)" maxlength="10" value="{{ $row['admin_contract']}}"  autocomplete="off">
                                                </div>
                                            </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label class="control-label childname">Phone Number:</label><span class="error-star" style="color:red;">*</span>
                                                        <input class="form-control default" type="text" id="phone_number" name="phone_number" oninput="PhoneNumber(event)" maxlength="10" value="{{ $row['phone_number']}}"  autocomplete="off">
                                                    </div>
                                                </div>

                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label class="control-label childname">Telephone Number:</label><span class="error-star" style="color:red;">*</span>
                                                        <input class="form-control default" type="text" id="telephone_number" name="telephone_number" oninput="TelephoneNumber(event)" maxlength="10" value="{{ $row['telephone_number']}}"  autocomplete="off">
                                                    </div>
                                                </div>






                                    </div>

                                    <div class="row">
                                        

                                <div class="col-md-4">
                                            <div class="form-group">
                                                <label class="control-label internlabel" style="font-size: medium;font-family: 'Barlow Condensed', sans-serif;">School Type: </label><span class="error-star" style="color:red;">*</span>
                                                <div class="d-flex">
                                                    @if(in_array('Primary',$schooltype))
                                                    <input class="form-control " type="checkbox" id="primary1" name="school_type[]" value="Primary"checked required autocomplete="off">
                                                    <label for="primary1">Primary</label>
                                                    @else
                                                    <input class="form-control " type="checkbox" id="primary1" name="school_type[]" value="Primary" required autocomplete="off">
                                                    <label for="primary1">Primary</label>
                                                    @endif

                                                    @if(in_array('HS',$schooltype))
                                                    <input class="form-control " type="checkbox" id="primary2" name="school_type[]" value="HS" checked required autocomplete="off">
                                                    <label for="primary2">HS</label>
                                                    @else
                                                    <input class="form-control " type="checkbox" id="primary2" name="school_type[]" value="HS" required autocomplete="off">
                                                    <label for="primary2">HS</label>
                                                    @endif

                                                    @if(in_array('IE',$schooltype))
                                                    <input class="form-control" type="checkbox" id="primary3" name="school_type[]" value="IE" checked required autocomplete="off">
                                                    <label for="primary3">IE </label>
                                                    @else
                                                    <input class="form-control" type="checkbox" id="primary3" name="school_type[]" value="IE"  required autocomplete="off">
                                                    <label for="primary3">IE </label>
                                                    @endif
                                                </div>
                                            </div>     



                                    </div>

                                            <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label class="control-label childname">Year of Establishment:</label><span class="error-star" style="color:red;">*</span>
                                                        <input class="form-control default" type="text" id="year_of_establishment" name="year_of_establishment" oninput="Establishment(event)" maxlength="20" value="{{ $row['year_of_establishment']}}"  autocomplete="off">
                                                    </div>
                                            </div>

                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label class="control-label childname">Total Number of Student Population:</label><span class="error-star" style="color:red;">*</span>
                                                        <input class="form-control default" type="text" id="totalstudent_population" name="totalstudent_population" oninput="Studentpopulation(event)" maxlength="20" value="{{ $row['totalstudent_population']}}"  autocomplete="off">
                                                    </div>
                                                </div>

                                </div>

                                <div class="row">
                                        <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label class="control-label childname">Total Number of Teacher Population:</label><span class="error-star" style="color:red;">*</span>
                                                        <input class="form-control default" type="text" id="totalteacher_population" name="totalteacher_population" oninput="TeacherPopulation(event)" maxlength="20" value="{{ $row['totalteacher_population']}}"  autocomplete="off">
                                                    </div>
                                                </div>

                                    <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="control-label" style="font-size: medium;font-family: 'Barlow Condensed', sans-serif;">Student Teacher-Ratio: </label><span class="error-star" style="color:red;">*</span>
                                                <div class="d-flex">
                                                    @if(in_array('Primary',$schoolteacherratio))
                                                    <input class="form-control " type="checkbox" id="primary4" name="school_teacher_ratio[]" value="Primary" checked required autocomplete="off">
                                                    <label for="primary4">Primary</label>
                                                    @else
                                                    <input class="form-control " type="checkbox" id="primary4" name="school_teacher_ratio[]" value="Primary" required autocomplete="off">
                                                    <label for="primary4">Primary</label>
                                                    @endif

                                                    @if(in_array('Secondary',$schoolteacherratio))
                                                    <input class="form-control " type="checkbox" id="primary5" name="school_teacher_ratio[]" value="Secondary" checked required autocomplete="off">
                                                    <label for="primary5">Secondary</label>
                                                    @else
                                                    <input class="form-control " type="checkbox" id="primary5" name="school_teacher_ratio[]" value="Secondary" required autocomplete="off">
                                                    <label for="primary5">Secondary</label>
                                                    @endif

                                                    @if(in_array('Higher Secondary',$schoolteacherratio))
                                                    <input class="form-control" type="checkbox" id="primary6" name="school_teacher_ratio[]" value="Higher Secondary" checked required autocomplete="off">
                                                    <label for="primary6">Higher Secondary </label>
                                                    @else
                                                    <input class="form-control" type="checkbox" id="primary6" name="school_teacher_ratio[]" value="Higher Secondary " required autocomplete="off">
                                                    <label for="primary6">Higher Secondary </label>
                                                    @endif
                                                </div>
                                            </div>     



                                    </div>          



                                </div>
                                <div class="col-md-12 text-center">

                                    <button class="btn btn-primary" type="reset"><i class="fa fa-undo"></i> Clear</button>&nbsp;

                                    <a type="button" onclick="save('submitted')" id="submitbutton" class="btn btn-labeled btn-succes" title="save" style="background: green !important; border-color:green !important; color:white !important">
                                        <span class="btn-label" style="font-size:13px !important;"><i class="fa fa-check"></i></span> Save</a>




                                    <a type="button" class="btn btn-labeled btn-info" onclick="DoAction('tab2');" title="next" style="background: blue !important; border-color:#4d94ff !important; color:white !important">
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
                                            @if(in_array('Science Labs',$infrastructure))
                                            <input class="form-control" type="checkbox" id="primary7" name="infra_facility[]" value="Science Labs" checked required autocomplete="off">
                                            <label for="primary7">Science Labs</label>
                                            @else
                                            <input class="form-control" type="checkbox" id="primary7" name="infra_facility[]" value="Science Labs" required autocomplete="off">
                                            <label for="primary7">Science Labs</label>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="infra_options px-0">
                                        <div class="form-group">
                                            @if(in_array('Library',$infrastructure))
                                            <input class="form-control " type="checkbox" id="primary8" name="infra_facility[]" value="Library" checked required autocomplete="off">
                                            <label for="primary8">Library</label>
                                            @else
                                            <input class="form-control " type="checkbox" id="primary8" name="infra_facility[]" value="Library" required autocomplete="off">
                                            <label for="primary8">Library</label>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="infra_options px-0">
                                        <div class="form-group">
                                            @if(in_array('Art Room',$infrastructure))
                                            <input class="form-control" type="checkbox" id="primary9" name="infra_facility[]" value="Art Room" checked required autocomplete="off">
                                            <label for="primary9">Art Room</label>
                                            @else
                                            <input class="form-control" type="checkbox" id="primary9" name="infra_facility[]" value="Art Room" required autocomplete="off">
                                            <label for="primary9">Art Room</label>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="infra_options px-0">
                                        <div class="form-group">
                                            @if(in_array('Sports(Indoor and Outdoor)',$infrastructure))
                                            <input class="form-control " type="checkbox" id="primary10" name="infra_facility[]" value="Sports(Indoor and Outdoor)" checked required autocomplete="off">
                                            <label for="primary10">Sports(Indoor and Outdoor)</label>
                                            @else
                                            <input class="form-control " type="checkbox" id="primary10" name="infra_facility[]" value="Sports(Indoor and Outdoor)" required autocomplete="off">
                                            <label for="primary10">Sports(Indoor and Outdoor)</label>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="infra_options px-0">
                                        <div class="form-group">
                                            @if(in_array('Playgrounds',$infrastructure))
                                            <input class="form-control " type="checkbox" id="primary11" name="infra_facility[]" value="Playgrounds" checked required autocomplete="off">
                                            <label for="primary11">Playgrounds</label>
                                            @else
                                            <input class="form-control " type="checkbox" id="primary11" name="infra_facility[]" value="Playgrounds" required autocomplete="off" >
                                            <label for="primary11">Playgrounds</label>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="infra_options px-0">
                                        <div class="form-group">
                                            @if(in_array('Auditorium',$infrastructure))
                                            <input class="form-control" type="checkbox" id="primary12" name="infra_facility[]" value="Auditorium" checked required autocomplete="off">
                                            <label for="primary12">Auditorium </label>
                                            @else
                                            <input class="form-control" type="checkbox" id="primary12" name="infra_facility[]" value="Auditorium" required autocomplete="off">
                                            <label for="primary12">Auditorium </label>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="infra_options px-0">
                                        <div class="form-group">
                                            @if(in_array('Extra Curricular Activities',$infrastructure))
                                            <input class="form-control" type="checkbox" id="primary13" name="infra_facility[]" value="Extra Curricular Activities" checked required autocomplete="off">
                                            <label for="primary13">Extra Curricular Activities</label>
                                            @else
                                            <input class="form-control" type="checkbox" id="primary13" name="infra_facility[]" value="Extra Curricular Activities" required autocomplete="off">
                                            <label for="primary13">Extra Curricular Activities</label>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="infra_options px-0">
                                        <div class="form-group">
                                            @if(in_array('Cafeteria',$infrastructure))
                                            <input class="form-control" type="checkbox" id="primary14" name="infra_facility[]" value="Cafeteria" checked required autocomplete="off">
                                            <label for="primary14">Cafeteria</label>
                                            @else
                                            <input class="form-control" type="checkbox" id="primary14" name="infra_facility[]" value="Cafeteria" required autocomplete="off">
                                            <label for="primary14">Cafeteria</label>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="infra_options px-0">
                                        <div class="form-group">
                                            @if(in_array('Counselling Suport',$infrastructure))
                                            <input class="form-control" type="checkbox" id="primary15" name="infra_facility[]" value="Counselling Suport" checked required autocomplete="off">
                                            <label for="primary15">Counselling Suport</label>
                                            @else
                                            <input class="form-control" type="checkbox" id="primary15" name="infra_facility[]" value="Counselling Suport" required autocomplete="off">
                                            <label for="primary15">Counselling Suport</label>
                                            @endif
                                        </div>
                                    </div> 
                                    <div class="infra_options px-0">
                                        <div class="form-group">
                                             @if(in_array('Special Education Support',$infrastructure))
                                            <input class="form-control" type="checkbox" id="primary16" name="infra_facility[]" value="Special Education Support" checked required autocomplete="off">
                                            <label for="primary16">Special Education Support</label>
                                            @else
                                            <input class="form-control" type="checkbox" id="primary16" name="infra_facility[]" value="Special Education Support" required autocomplete="off">
                                            <label for="primary16">Special Education Support</label>
                                            @endif
                                        </div>
                                    </div> 
                                    <div class="infra_options px-0">
                                        <div class="form-group">
                                            @if(in_array('Resource Room',$infrastructure))
                                            <input class="form-control" type="checkbox" id="primary17" name="infra_facility[]" value="Resource Room" checked required autocomplete="off">
                                            <label for="primary17">Resource Room</label>
                                            @else
                                            <input class="form-control" type="checkbox" id="primary17" name="infra_facility[]" value="Resource Room" required autocomplete="off">
                                            <label for="primary17">Resource Room</label>
                                            @endif
                                        </div>
                                    </div>  
                                    <div class="infra_options px-0">
                                        <div class="form-group">
                                            @if(in_array('First Aid Support',$infrastructure))
                                            <input class="form-control" type="checkbox" id="primary18" name="infra_facility[]" value="First Aid Support" checked required autocomplete="off">
                                            <label for="primary18">First Aid Support</label>
                                            @else
                                            <input class="form-control" type="checkbox" id="primary18" name="infra_facility[]" value="First Aid Support" required autocomplete="off">
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
                                            <input class="form-control" type="checkbox" id="primary19" name="school_curriculam[]" value="Experimental Learning" checked required autocomplete="off">
                                            <label for="primary19">Experimental Learning</label>
                                            @else
                                            <input class="form-control" type="checkbox" id="primary19" name="school_curriculam[]" value="Experimental Learning" required autocomplete="off">
                                            <label for="primary19">Experimental Learning</label>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="infra_options px-0">
                                        <div class="form-group">
                                            @if(in_array('Differentiated Learning',$curriculam))
                                            <input class="form-control " type="checkbox" id="primary20" name="school_curriculam[]" value="Differentiated Learning" checked required autocomplete="off">
                                            <label for="primary20">Differentiated Learning</label>
                                            @else
                                            <input class="form-control " type="checkbox" id="primary20" name="school_curriculam[]" value="Differentiated Learning" required autocomplete="off">
                                            <label for="primary20">Differentiated Learning</label>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="infra_options px-0">
                                        <div class="form-group">
                                            @if(in_array('Multiple Intelligence',$curriculam))
                                            <input class="form-control" type="checkbox" id="primary21" name="school_curriculam[]" value="Multiple Intelligence" checked required autocomplete="off">
                                            <label for="primary21">Multiple Intelligence</label>
                                            @else
                                            <input class="form-control" type="checkbox" id="primary21" name="school_curriculam[]" value="Multiple Intelligence" required autocomplete="off">
                                            <label for="primary21">Multiple Intelligence</label>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="infra_options px-0">
                                        <div class="form-group">
                                            @if(in_array('Learning Style',$curriculam))
                                            <input class="form-control " type="checkbox" id="primary22" name="school_curriculam[]" value="Learning Style" checked required autocomplete="off">
                                            <label for="primary22">Learning Style</label>
                                            @else
                                            <input class="form-control " type="checkbox" id="primary22" name="school_curriculam[]" value="Learning Style" required autocomplete="off">
                                            <label for="primary22">Learning Style</label>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="infra_options px-0">
                                        <div class="form-group">
                                            @if(in_array('Universal design for Learning',$curriculam))
                                            <input class="form-control " type="checkbox" id="primary23" name="school_curriculam[]" value="Universal design for Learning" checked required autocomplete="off">
                                            <label for="primary23">Universal design for Learning</label>
                                            @else
                                            <input class="form-control " type="checkbox" id="primary23" name="school_curriculam[]" value="Universal design for Learning" required autocomplete="off">
                                            <label for="primary23">Universal design for Learning</label>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="infra_options px-0">
                                        <div class="form-group">
                                            @if(in_array('Social Emotional Curriculam',$curriculam))
                                            <input class="form-control" type="checkbox" id="primary24" name="school_curriculam[]" value="Social Emotional Curriculam" checked required autocomplete="off">
                                            <label for="primary24">Social Emotional Curriculam</label>
                                            @else
                                            <input class="form-control" type="checkbox" id="primary24" name="school_curriculam[]" value="Social Emotional Curriculam" required autocomplete="off">
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
                                            <input class="form-control" type="checkbox" id="primary25" name="school_policy[]" value="Child Protection Policy" checked required autocomplete="off">
                                            <label for="primary25">Child Protection Policy</label>
                                            @else
                                            <input class="form-control" type="checkbox" id="primary25" name="school_policy[]" value="Child Protection Policy" required autocomplete="off">
                                            <label for="primary25">Child Protection Policy</label>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="infra_options px-0">
                                        <div class="form-group">
                                            @if(in_array('Health & Safety',$policy))
                                            <input class="form-control " type="checkbox" id="primary26" name="school_policy[]" value="Health & Safety" checked required autocomplete="off">
                                            <label for="primary26">Health & Safety</label>
                                            @else
                                            <input class="form-control " type="checkbox" id="primary26" name="school_policy[]" value="Health & Safety" required autocomplete="off">
                                            <label for="primary26">Health & Safety</label>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="infra_options px-0">
                                        <div class="form-group">
                                            @if(in_array('RTE Act 2009',$policy))
                                            <input class="form-control" type="checkbox" id="primary27" name="school_policy[]" value="RTE Act 2009" checked required autocomplete="off">
                                            <label for="primary27">RTE Act 2009</label>
                                            @else
                                            <input class="form-control" type="checkbox" id="primary27" name="school_policy[]" value="RTE Act 2009" required autocomplete="off">
                                            <label for="primary27">RTE Act 2009</label>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="infra_options px-0">
                                        <div class="form-group">
                                            @if(in_array('Barrier Free Environment(Accessibility)',$policy))
                                            <input class="form-control " type="checkbox" id="primary28" name="school_policy[]" value="Barrier Free Environment(Accessibility)" checked required autocomplete="off">
                                            <label for="primary28">Barrier Free Environment(Accessibility)</label>
                                            @else
                                            <input class="form-control " type="checkbox" id="primary28" name="school_policy[]" value="Barrier Free Environment(Accessibility)" required autocomplete="off">
                                            <label for="primary28">Barrier Free Environment(Accessibility)</label>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="infra_options px-0">
                                        <div class="form-group">
                                            @if(in_array('Grievance Redressal Committee',$policy))
                                            <input class="form-control " type="checkbox" id="primary29" name="school_policy[]" value="Grievance Redressal Committee" checked required autocomplete="off">
                                            <label for="primary29">Grievance Redressal Committee</label>
                                            @else
                                            <input class="form-control " type="checkbox" id="primary29" name="school_policy[]" value="Grievance Redressal Committee" required autocomplete="off">
                                            <label for="primary29">Grievance Redressal Committee</label>
                                            @endif
                                        </div>
                                    </div>
                                   
                                              
                                </div>
                            </div>

                                    
                                </div>

                                
                                <div class="col-md-12 text-center">

                                    <button class="btn btn-primary" type="reset"><i class="fa fa-undo"></i> Clear</button>&nbsp;

                                    <a type="button" onclick="save('submitted')" id="submitbutton" class="btn btn-labeled btn-succes" title="save" style="background: green !important; border-color:green !important; color:white !important">
                                        <span class="btn-label" style="font-size:13px !important;"><i class="fa fa-check"></i></span> Save</a>




                                    <a type="button" class="btn btn-labeled btn-info" onclick="DoAction('tab3');" title="next" style="background: blue !important; border-color:#4d94ff !important; color:white !important">
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
                                                    <label class="control-label heading">1.Does the School have an Enclusion Policy that specifies action for including children with special needs?:</label><span class="error-star" style="color:red;">*</span>
                                                    
                                                    <input type="radio" id="question1" name="have_exclusion_policy" value="Yes" {{ ($row['have_exclusion_policy']=="Yes")? "checked" : "" }} onchange="profileval(this)"><label class="questionpadding"for="featured-1">YES</label>

                                                
                                                    <input type="radio" id="question2" name="have_exclusion_policy" value="No" {{ ($row['have_exclusion_policy']=="No")? "checked" : "" }} onchange="profileval(this)"><label class="questionpadding" for="featured-2">NO</label>
                                                </div>
                                            </div>

                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="control-label heading">2.Is a Multidisciplinary team approches in your school to provide alternatives to suspension or expulsion for students with complex needs?:<span class="error-star" style="color:red;">*</span></label>
                                                    
                                                    <input type="radio" id="question3" name="multidisciplinary_team" value="Yes" {{ ($row['multidisciplinary_team']=="Yes")? "checked" : "" }} onclick="question()"><label class="questionpadding" for="featured-1">YES</label>

                                                
                                                    <input type="radio" id="question4" name="multidisciplinary_team" value="No" {{ ($row['multidisciplinary_team']=="No")? "checked" : "" }} onchange="profileval(this)"><label class="questionpadding" for="featured-2">NO</label>
                                                </div>
                                            </div>

                                            <div class="col-md-12" id="question5">
                                                <div class="form-group" >
                                                    <label class="control-label heading">3.Is there a shared framework for goals and outcomes of multidisciplinary teams work in your school:</label><span class="error-star" style="color:red;">*</span>
                                                    
                                                    <textarea class="form-control"  name="multidisciplinary_team_desc" value="{{ $row['multidisciplinary_team_desc']}}" onchange="profileval(this)"></textarea>

                                                
                                                    
                                                </div>
                                            </div>
                                    
                                    </div>
                                <div class="col-md-12 text-center">

                                    <a type="button" class="btn btn-labeled btn-info" onclick="DoAction('tab1');" title="back" style="background: blue !important; border-color:blue !important; color:white !important">
                                        <span class="btn-label" style="font-size:13px !important;"><i class="fa fa-arrow-left"></i></span> Back</a>

                                    <a type="button" onclick="submit('submitted')" id="submitbutton" class="btn btn-labeled btn-succes" title="submit" style="background: green !important; border-color:green !important; color:white !important">
                                        <span class="btn-label" style="font-size:13px !important;"><i class="fa fa-check"></i></span> Submit</a>

                                    <button class="btn btn-primary" type="reset"><i class="fa fa-undo"></i> Clear</button>&nbsp;

                                </div>
                            </section>

                        </div>





                    </div>



                </form>
                @endforeach
            </div>

        </div>
        <div class="col-md-12 text-center " style="    margin-top: 5px;">

        </div>
    </div>
</div>
<script>

function question()

{
    document.getElementById('question5').style.display = "block";
     
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
    const service = (event) => {document.getElementById('organisationd').style.display = (document.getElementById('organisation').checked == true) ? "block" : "none";}

   
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
    //validation

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
    function StudentPopulation(event) {
        let value = event.target.value || '';
        value = value.replace(/[^0-9+ ]/, '', );
        event.target.value = value;

    }
    function TeacherPopulation(event) {
        let value = event.target.value || '';
        value = value.replace(/[^0-9+ ]/, '', );
        event.target.value = value;

    }

    function save() {


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

        var primary1 = document.getElementById("primary1");
        var primary2 = document.getElementById("primary2");
        var primary3 = document.getElementById("primary3");
        


        if (( primary1.checked == false) && ( primary2.checked == false) && ( primary3.checked == false)) {

            swal({
                title: "Error",
                text: "Please Select School Type",
                type: 'error',
                confirmButtontext: "OK"
            });

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
        var primary4 = document.getElementById("primary4");
        var primary5 = document.getElementById("primary5");
        var primary6 = document.getElementById("primary6");
        


        if (( primary4.checked == false) && ( primary5.checked == false) && ( primary6.checked == false)) {

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
        if (( primary7.checked == false) && ( primary8.checked == false) && ( primary9.checked == false)  && ( primary10.checked == false)  && ( primary11.checked == false)  && ( primary12.checked == false) && ( primary13.checked == false) && ( primary14.checked == false) && ( primary15.checked == false) && ( primary16.checked == false) && ( primary17.checked == false) && ( primary18.checked == false)) {

            swal({
                title: "Error",
                text: "Please Infrastructure Facility",
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
       
        if (( primary19.checked == false) && ( primary20.checked == false) && ( primary21.checked == false)  && ( primary22.checked == false)  && ( primary23.checked == false)  && ( primary24.checked == false)) {

            swal({
                title: "Error",
                text: "Please School Curriculam",
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
        
       
        if (( primary25.checked == false) && ( primary26.checked == false) && ( primary27.checked == false)  && ( primary28.checked == false)  && ( primary29.checked == false)) {

            swal({
                title: "Error",
                text: "Please Has Your School Implemented the Policies",
                type: 'error',
                confirmButtontext: "OK"
            });

            return false;

        }
       
        

        document.getElementById('newenrollement').submit('saved');

    }

    function submit() {

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

            if (multidisciplinary_team_desc == '') {
            swal("Please Enter Multidiscilinary Team in Your School  ", "", "error");
            return false;
            }
        document.getElementById('newenrollement').submit('saved');
    }
</script>
@endsection