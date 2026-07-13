@extends('layouts.adminnav')

@section('content')
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=yes">

<style>
    /* MOBILE STYLES - FORCED OVERRIDES */
    @media (max-width: 768px) {
        .col-md-12.text-center {
            display: flex !important;
            flex-direction: row !important;
            flex-wrap: nowrap !important;
            justify-content: center !important;
            align-items: center !important;
            gap: 6px !important;
            width: 100% !important;
            padding: 0 !important;
            margin: 0 !important;
        }
        .col-md-12.text-center .btn,
        .col-md-12.text-center a.btn,
        .col-md-12.text-center .btn-labeled,
        .col-md-12.text-center .btn-info,
        .col-md-12.text-center .back-btn {
            display: inline-flex !important;
            flex: 1 1 0 !important;
            width: auto !important;
            min-width: 0 !important;
            max-width: 100% !important;
            margin: 0 !important;
            padding: 6px 4px !important;
            font-size: 11px !important;
            font-weight: 500 !important;
            white-space: nowrap !important;
            border-radius: 4px !important;
            justify-content: center !important;
            align-items: center !important;
            text-align: center !important;
            box-shadow: none !important;
            text-shadow: none !important;
            border: 1px solid !important;
            transition: none !important;
            text-decoration: none !important;
            line-height: normal !important;
            height: auto !important;
            background: none !important;
        }
        .col-md-12.text-center .btn i,
        .col-md-12.text-center .btn .btn-label i,
        .col-md-12.text-center .btn span i,
        .col-md-12.text-center a.btn i,
        .col-md-12.text-center .btn-labeled i,
        .col-md-12.text-center .btn-info i,
        .col-md-12.text-center .back-btn i,
        .col-md-12.text-center .btn .fa,
        .col-md-12.text-center .btn .fas,
        .col-md-12.text-center .btn .far,
        .col-md-12.text-center .btn .fa-arrow-left,
        .col-md-12.text-center .btn .fa-arrow-right,
        .col-md-12.text-center .btn .fa-times {
            display: none !important;
            background: transparent !important;
        }
        .col-md-12.text-center .btn .btn-label {
            display: inline !important;
            margin-right: 0 !important;
            font-size: 11px !important;
            background: transparent !important;
        }
        .col-md-12.text-center .btn-info,
        .col-md-12.text-center a.btn-info,
        .col-md-12.text-center .btn-labeled.btn-info {
            background: transparent !important;
            background-color: transparent !important;
            border-color: #007bff !important;
            color: #007bff !important;
        }
        .col-md-12.text-center .btn-info[style],
        .col-md-12.text-center a.btn-info[style],
        .col-md-12.text-center .btn-info[style*="background"],
        .col-md-12.text-center a.btn-info[style*="background"],
        .col-md-12.text-center .btn-info[style*="color"],
        .col-md-12.text-center a.btn-info[style*="color"] {
            background: transparent !important;
            background-color: transparent !important;
            color: #007bff !important;
        }
        .col-md-12.text-center .back-btn,
        .col-md-12.text-center a.back-btn {
            background: #FF0000 !important;
            background-color: #FF0000 !important;
            border-color: #cc0000 !important;
            color: white !important;
        }
        .col-md-12.text-center .back-btn[style*="color"],
        .col-md-12.text-center a.back-btn[style*="color"] {
            color: white !important;
        }
        .col-md-12.text-center .btn:hover,
        .col-md-12.text-center .btn:focus,
        .col-md-12.text-center .btn:active {
            box-shadow: none !important;
            outline: none !important;
            background: transparent !important;
        }
        .col-md-12.text-center .back-btn:hover,
        .col-md-12.text-center .back-btn:focus,
        .col-md-12.text-center .back-btn:active {
            background: #FF0000 !important;
        }
        .col-md-12.text-center {
            overflow-x: auto !important;
            -webkit-overflow-scrolling: touch !important;
        }
    }
</style>

<style>
    @media (max-width:768px){
        .main-content{ padding:10px !important; }
        .card{ padding:10px !important; }
        .nav-tabs{ width:100% !important; display:flex !important; flex-direction:column !important; border-radius:10px !important; }
        .nav-tabs .nav-item{ width:100% !important; margin-bottom:5px !important; }
        .nav-tabs .nav-link{ font-size:14px !important; text-align:center !important; padding:10px !important; }
        .row{ margin-left:0 !important; margin-right:0 !important; }
        .col-md-4, .col-md-6, .col-md-12{ width:100% !important; max-width:100% !important; flex:0 0 100% !important; padding-left:5px !important; padding-right:5px !important; }
        .form-group{ margin-bottom:12px !important; }
        .form-control{ font-size:13px !important; height:auto !important; min-height:38px !important; }
        label{ font-size:13px !important; font-weight:600 !important; }
        .infra_options{ width:100% !important; margin-bottom:6px !important; }
        .infra_options label{ font-size:13px !important; }
        .d-flex.flex-wrap{ display:block !important; }
        h4{ font-size:18px !important; }
        h5{ font-size:16px !important; }
        textarea{ min-height:100px !important; }
        #phone_number, #telephone_number{ padding-left:80px !important; padding-right:10px !important; }
        .iti{ width:100% !important; }
    }
    
    input[type=checkbox] { display: inline-block; }
    .nav-tabs { background-color: #0068a7 !important; border-radius: 29px !important; padding: 1px !important; }
    .nav-item.active { background-color: #0e2381 !important; border-radius: 31px !important; height: 100% !important; }
    .nav-link.active { background-color: #0e2381 !important; border-radius: 31px !important; height: 100% !important; }
    .nav-justified { display: flex !important; align-items: center !important; }
    hr { border-top: 1px solid #6c757d !important; }
    .infra_options { width: calc(100% / 3); }
    .infra_options .form-group { margin-bottom: 0rem; }
    .heading { font-weight: bold !important; }
    .containerpadding { padding: 1rem; }
    .questionpadding { padding: 5px; }

    /* ==============================================================
       TABLET-ONLY FIX (769px - 1024px) – phone number visibility
       ============================================================== */
    @media (min-width: 769px) and (max-width: 1024px) {
        /* ----- Phone & Telephone inputs: override global padding with !important ----- */
        #phone_number,
        #telephone_number {
            padding-left: 45px !important;      /* reduced to show the number */
            padding-right: 10px !important;
            width: 100% !important;
            box-sizing: border-box !important;
            height: 40px !important;
            min-height: 40px !important;
            line-height: normal !important;
            font-size: 14px !important;
            overflow: visible !important;
            white-space: nowrap !important;
            text-overflow: clip !important;
        }

        /* Ensure the intl-tel-input container doesn't clip the number */
        .iti {
            width: 100% !important;
            overflow: visible !important;
        }
        .iti__flag-container {
            overflow: visible !important;
            padding-left: 0 !important;
        }
        .form-group .iti {
            overflow: visible !important;
        }

        /* Keep label + asterisk on same line (already fixed) */
        .form-group label.control-label {
            display: inline !important;
            white-space: normal !important;
            word-break: normal !important;
            overflow-wrap: break-word !important;
        }
        .form-group .error-star,
        .form-group label + .error-star {
            display: inline !important;
            white-space: nowrap !important;
            margin-left: 2px !important;
        }

        /* School Policy Tab – two columns */
        .infra_options {
            width: calc(100% / 2) !important;
            padding: 0 5px !important;
        }
        .infra_options .form-group {
            display: flex !important;
            align-items: center !important;
            margin-bottom: 6px !important;
        }
        .infra_options .form-group input[type="checkbox"] {
            margin-right: 6px !important;
            flex-shrink: 0 !important;
        }
        .infra_options .form-group label {
            margin-bottom: 0 !important;
            font-size: 13px !important;
            word-break: break-word !important;
        }
        .container.containerpadding .infra_options {
            flex: 0 0 calc(50% - 10px) !important;
            max-width: calc(50% - 10px) !important;
            box-sizing: border-box !important;
        }
        .container.containerpadding .d-flex.flex-wrap {
            display: flex !important;
            flex-wrap: wrap !important;
        }
        .container:not(.containerpadding) .infra_options {
            width: calc(100% / 2) !important;
        }

        /* General Questions – asterisk stays inline */
        .col-md-12 .form-group label.control-label.heading {
            display: inline !important;
            white-space: normal !important;
            word-break: normal !important;
            overflow-wrap: break-word !important;
        }
        .col-md-12 .form-group .error-star {
            display: inline !important;
            white-space: nowrap !important;
            margin-left: 2px !important;
        }
        .col-md-4, .col-md-6, .col-md-12 {
            overflow: hidden !important;
        }
    }
</style>

<style>
    /* Phone number padding fix */
    input[type="tel"]#phone_number,
    .form-control.default#phone_number,
    .main-content .card .section-body .row .col-md-4 .form-group input#phone_number {
        padding-left: 95px !important;
        padding-right: 95px !important;
    }
    input[type="tel"]#telephone_number,
    .form-control.default#telephone_number,
    .main-content .card .section-body .row .col-md-4 .form-group input#telephone_number {
        padding-left: 95px !important;
        padding-right: 95px !important;
    }
</style>

<div class="main-content">
    <div class="mt-5">
        {{ Breadcrumbs::render('enrollement.schoolshow',$rows[0]['school_enrollment_id']) }}
    </div>

    <div class="row justify-content-center">
        <div class="col-12">
            <div class="card" style="height:100%; padding: 15px; background-color:white">
                <div class="col-lg-12 text-center" style="padding: 10px;">
                    <h4 style="color:darkblue;">Enrolled Campus Summary</h4>
                </div>
                @foreach($rows as $key=>$row)

                <div class="tile" id="tile-1" style="margin-top:10px !important; margin-bottom:10px !important;">
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
                    <!-- TAB 1 -->
                    <div class="tab-pane fade show active" id="tab1" role="tabpanel" aria-labelledby="home-tab">
                        <section class="section">
                            <div class="section-body mt-1">
                                <hr>
                                <h5 style="display:flex; width:fit-content; margin-top:-19px; margin-left:auto; margin-right:auto; padding:5px; background-color:white; font-family:'Barlow Condensed', sans-serif;">School Details</h5>
                                <div class="row">
                                    <input type="hidden" id="selected_id" name="selected_id" value="">
                                    <div class="col-md-4"><div class="form-group"><label class="control-label childname">School Name: </label><span class="error-star" style="color:red;">*</span><input class="form-control default" type="text" id="school_name" name="school_name" oninput="SchoolName(event)" maxlength="20" value="{{ $row['school_name']}}" autocomplete="off" disabled></div></div>
                                    <div class="col-md-4"><div class="form-group"><label class="control-label childname">Principal Name: </label><span class="error-star" style="color:red;">*</span><input class="form-control default school_principal_name" type="text" id="school_principal_name" name="school_principal_name" oninput="PrincipalName(event)" maxlength="20" value="{{ $row['school_principal_name']}}" autocomplete="off" disabled></div></div>
                                    <div class="col-md-4"><div class="form-group"><label class="control-label childname">Building Name: </label><span class="error-star" style="color:red;">*</span><input class="form-control default" type="text" id="school_building_name" name="school_building_name" oninput="BuildingName(event)" maxlength="20" value="{{ $row['school_building_name']}}" autocomplete="off" disabled></div></div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4"><div class="form-group"><label class="control-label childname">Building Address: </label><span class="error-star" style="color:red;">*</span><input class="form-control default" type="text" id="school_builiding_address" name="school_builiding_address" value="{{ $row['school_builiding_address']}}" autocomplete="off" disabled></div></div>
                                    <div class="col-md-4"><div class="form-group"><label class="control-label childname">School District:</label><span class="error-star" style="color:red;">*</span><input class="form-control default" type="text" id="school_district" name="school_district" oninput="DistrictName(event)" maxlength="20" value="{{ $row['school_district']}}" autocomplete="off" disabled></div></div>
                                    <div class="col-md-4"><div class="form-group"><label class="control-label childname">Building Contact:</label><span class="error-star" style="color:red;">*</span><input class="form-control default" type="text" id="building_contract" name="building_contract" oninput="BuildingContact(event)" maxlength="10" value="{{ $row['building_contract']}}" autocomplete="off" disabled></div></div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4"><div class="form-group"><label class="control-label childname">Administration Contact: </label><span class="error-star" style="color:red;">*</span><input class="form-control default" type="text" id="admin_contract" name="admin_contract" oninput="Admincontact(event)" maxlength="10" value="{{ $row['admin_contract']}}" autocomplete="off" disabled></div></div>
                                    <div class="col-md-4"><div class="form-group"><label class="control-label childname">Phone Number:</label><span class="error-star" style="color:red;">*</span><input class="form-control default" type="tel" id="phone_number" name="phone_number" oninput="PhoneNumber(event)" value="{{ $row['phone_number']}}" autocomplete="off" disabled></div></div>
                                    <div class="col-md-4"><div class="form-group"><label class="control-label childname">Telephone Number:</label><span class="error-star" style="color:red;">*</span><input class="form-control default" type="text" id="telephone_number" name="telephone_number" oninput="TelephoneNumber(event)" value="{{ $row['telephone_number']}}" autocomplete="off" disabled></div></div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4"><div class="form-group"><label class="control-label">School Type: </label><span class="error-star" style="color:red;">*</span>
                                        <div class="d-flex">
                                            <div class="d-flex" style="align-items: center;">@if(in_array('Primary',$schooltype))<input type="checkbox" id="primary1" name="school_type[]" value="Primary" checked required autocomplete="off" onclick="return false" style="margin:5px;">Primary @else <input type="checkbox" id="primary1" name="school_type[]" value="Primary" required autocomplete="off" disabled style="margin:5px;">Primary @endif</div>
                                            <div class="d-flex" style="align-items: center;">@if(in_array('HS',$schooltype))<input type="checkbox" id="primary2" name="school_type[]" value="HS" checked required autocomplete="off" onclick="return false" style="margin:5px;">HS @else <input type="checkbox" id="primary2" name="school_type[]" value="HS" required autocomplete="off" disabled style="margin:5px;">HS @endif</div>
                                            <div class="d-flex" style="align-items: center;">@if(in_array('IE',$schooltype))<input type="checkbox" id="primary3" name="school_type[]" value="IE" checked required autocomplete="off" onclick="return false" style="margin:5px;">IE @else <input type="checkbox" id="primary3" name="school_type[]" value="IE" required autocomplete="off" disabled style="margin:5px;">IE @endif</div>
                                        </div>
                                    </div></div>
                                    <div class="col-md-4"><div class="form-group"><label class="control-label childname">Year of Establishment:</label><span class="error-star" style="color:red;">*</span><input class="form-control default" type="text" id="year_of_establishment" name="year_of_establishment" oninput="Establishment(event)" maxlength="20" value="{{ $row['year_of_establishment']}}" autocomplete="off" disabled></div></div>
                                    <div class="col-md-4"><div class="form-group"><label class="control-label childname">Total Number of Student Population:</label><span class="error-star" style="color:red;">*</span><input class="form-control default" type="text" id="totalstudent_population" name="totalstudent_population" oninput="Studentpopulation(event)" maxlength="20" value="{{ $row['totalstudent_population']}}" autocomplete="off" disabled></div></div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4"><div class="form-group"><label class="control-label childname">Total Number of Teacher Population:</label><span class="error-star" style="color:red;">*</span><input class="form-control default" type="text" id="totalteacher_population" name="totalteacher_population" oninput="TeacherPopulation(event)" maxlength="20" value="{{ $row['totalteacher_population']}}" autocomplete="off" disabled></div></div>
                                    <div class="col-md-6"><div class="form-group"><label class="control-label" style="font-size:medium; font-family:'Barlow Condensed', sans-serif;">Student Teacher-Ratio: </label><span class="error-star" style="color:red;">*</span>
                                        <div class="d-flex">
                                            <div class="d-flex" style="align-items: center;">@if(in_array('Primary',$schoolteacherratio))<input type="checkbox" id="primary4" name="school_teacher_ratio[]" value="Primary" checked required autocomplete="off" onclick="return false" style="margin:5px;">Primary @else <input type="checkbox" id="primary4" name="school_teacher_ratio[]" value="Primary" required autocomplete="off" disabled style="margin:5px;">Primary @endif</div>
                                            <div class="d-flex" style="align-items: center;">@if(in_array('Secondary',$schoolteacherratio))<input type="checkbox" id="primary5" name="school_teacher_ratio[]" value="Secondary" checked required autocomplete="off" onclick="return false" style="margin:5px;">Secondary @else <input type="checkbox" id="primary5" name="school_teacher_ratio[]" value="Secondary" required autocomplete="off" disabled style="margin:5px;">Secondary @endif</div>
                                            <div class="d-flex" style="align-items: center;">@if(in_array('Higher Secondary',$schoolteacherratio))<input type="checkbox" id="primary6" name="school_teacher_ratio[]" value="Higher Secondary" checked required autocomplete="off" onclick="return false" style="margin:5px;">Higher Secondary @else <input type="checkbox" id="primary6" name="school_teacher_ratio[]" value="Higher Secondary" required autocomplete="off" disabled style="margin:5px;">Higher Secondary @endif</div>
                                        </div>
                                    </div></div>
                                </div>
                                <div class="col-md-12 text-center">
                                    <a type="button" class="btn btn-labeled back-btn" title="Cancel" href="{{ route('enrollement.schoollist') }}" style="color:white !important"><span class="btn-label"><i class="fa fa-times"></i></span> Cancel</a>
                                    <a type="button" class="btn btn-labeled btn-info" onclick="DoAction('tab2');" title="Next" style="background: blue !important; border-color:#4d94ff !important; color:white !important"><span class="btn-label">Next</span> <i class="fa fa-arrow-right"></i></a>
                                </div>
                            </div>
                        </section>
                    </div>

                    <!-- TAB 2 -->
                    <div class="tab-pane fade show" id="tab2" role="tabpanel" aria-labelledby="contact-tab">
                        <section class="section">
                            <div class="section-body mt-1">
                                <div class="container"><label class="control-label heading">1.Infrastructure Facility:</label><span class="error-star" style="color:red;">*</span>
                                    <div class="d-flex flex-wrap">
                                        <div class="infra_options px-0"><div class="form-group">@if(in_array('Science Labs',$infrastructure))<input type="checkbox" id="primary7" name="infra_facility[]" value="Science Labs" checked onclick="return false"><label for="primary7">Science Labs</label>@else<input type="checkbox" id="primary7" name="infra_facility[]" value="Science Labs" disabled><label for="primary7">Science Labs</label>@endif</div></div>
                                        <div class="infra_options px-0"><div class="form-group">@if(in_array('Library',$infrastructure))<input type="checkbox" id="primary8" name="infra_facility[]" value="Library" checked onclick="return false"><label for="primary8">Library</label>@else<input type="checkbox" id="primary8" name="infra_facility[]" value="Library" disabled><label for="primary8">Library</label>@endif</div></div>
                                        <div class="infra_options px-0"><div class="form-group">@if(in_array('Art Room',$infrastructure))<input type="checkbox" id="primary9" name="infra_facility[]" value="Art Room" checked onclick="return false"><label for="primary9">Art Room</label>@else<input type="checkbox" id="primary9" name="infra_facility[]" value="Art Room" disabled><label for="primary9">Art Room</label>@endif</div></div>
                                        <div class="infra_options px-0"><div class="form-group">@if(in_array('Sports(Indoor and Outdoor)',$infrastructure))<input type="checkbox" id="primary10" name="infra_facility[]" value="Sports(Indoor and Outdoor)" checked onclick="return false"><label for="primary10">Sports(Indoor and Outdoor)</label>@else<input type="checkbox" id="primary10" name="infra_facility[]" value="Sports(Indoor and Outdoor)" disabled><label for="primary10">Sports(Indoor and Outdoor)</label>@endif</div></div>
                                        <div class="infra_options px-0"><div class="form-group">@if(in_array('Playgrounds',$infrastructure))<input type="checkbox" id="primary11" name="infra_facility[]" value="Playgrounds" checked onclick="return false"><label for="primary11">Playgrounds</label>@else<input type="checkbox" id="primary11" name="infra_facility[]" value="Playgrounds" disabled><label for="primary11">Playgrounds</label>@endif</div></div>
                                        <div class="infra_options px-0"><div class="form-group">@if(in_array('Auditorium',$infrastructure))<input type="checkbox" id="primary12" name="infra_facility[]" value="Auditorium" checked onclick="return false"><label for="primary12">Auditorium</label>@else<input type="checkbox" id="primary12" name="infra_facility[]" value="Auditorium" disabled><label for="primary12">Auditorium</label>@endif</div></div>
                                        <div class="infra_options px-0"><div class="form-group">@if(in_array('Extra Curricular Activities',$infrastructure))<input type="checkbox" id="primary13" name="infra_facility[]" value="Extra Curricular Activities" checked onclick="return false"><label for="primary13">Extra Curricular Activities</label>@else<input type="checkbox" id="primary13" name="infra_facility[]" value="Extra Curricular Activities" disabled><label for="primary13">Extra Curricular Activities</label>@endif</div></div>
                                        <div class="infra_options px-0"><div class="form-group">@if(in_array('Cafeteria',$infrastructure))<input type="checkbox" id="primary14" name="infra_facility[]" value="Cafeteria" checked onclick="return false"><label for="primary14">Cafeteria</label>@else<input type="checkbox" id="primary14" name="infra_facility[]" value="Cafeteria" disabled><label for="primary14">Cafeteria</label>@endif</div></div>
                                        <div class="infra_options px-0"><div class="form-group">@if(in_array('Counselling Suport',$infrastructure))<input type="checkbox" id="primary15" name="infra_facility[]" value="Counselling Suport" checked onclick="return false"><label for="primary15">Counselling Suport</label>@else<input type="checkbox" id="primary15" name="infra_facility[]" value="Counselling Suport" disabled><label for="primary15">Counselling Suport</label>@endif</div></div>
                                        <div class="infra_options px-0"><div class="form-group">@if(in_array('Special Education Support',$infrastructure))<input type="checkbox" id="primary16" name="infra_facility[]" value="Special Education Support" checked onclick="return false"><label for="primary16">Special Education Support</label>@else<input type="checkbox" id="primary16" name="infra_facility[]" value="Special Education Support" disabled><label for="primary16">Special Education Support</label>@endif</div></div>
                                        <div class="infra_options px-0"><div class="form-group">@if(in_array('Resource Room',$infrastructure))<input type="checkbox" id="primary17" name="infra_facility[]" value="Resource Room" checked onclick="return false"><label for="primary17">Resource Room</label>@else<input type="checkbox" id="primary17" name="infra_facility[]" value="Resource Room" disabled><label for="primary17">Resource Room</label>@endif</div></div>
                                        <div class="infra_options px-0"><div class="form-group">@if(in_array('First Aid Support',$infrastructure))<input type="checkbox" id="primary18" name="infra_facility[]" value="First Aid Support" checked onclick="return false"><label for="primary18">First Aid Support</label>@else<input type="checkbox" id="primary18" name="infra_facility[]" value="First Aid Support" disabled><label for="primary18">First Aid Support</label>@endif</div></div>
                                    </div>
                                </div>
                                <div class="container containerpadding"><label class="control-label heading">2.Is the School Curriculam Supportive of these Educational Components:</label><span class="error-star" style="color:red;">*</span>
                                    <div class="d-flex flex-wrap">
                                        <div class="infra_options px-0"><div class="form-group">@if(in_array('Experimental Learning',$curriculam))<input type="checkbox" id="primary19" name="school_curriculam[]" value="Experimental Learning" checked onclick="return false"><label for="primary19">Experimental Learning</label>@else<input type="checkbox" id="primary19" name="school_curriculam[]" value="Experimental Learning" disabled><label for="primary19">Experimental Learning</label>@endif</div></div>
                                        <div class="infra_options px-0"><div class="form-group">@if(in_array('Differentiated Learning',$curriculam))<input type="checkbox" id="primary20" name="school_curriculam[]" value="Differentiated Learning" checked onclick="return false"><label for="primary20">Differentiated Learning</label>@else<input type="checkbox" id="primary20" name="school_curriculam[]" value="Differentiated Learning" disabled><label for="primary20">Differentiated Learning</label>@endif</div></div>
                                        <div class="infra_options px-0"><div class="form-group">@if(in_array('Multiple Intelligence',$curriculam))<input type="checkbox" id="primary21" name="school_curriculam[]" value="Multiple Intelligence" checked onclick="return false"><label for="primary21">Multiple Intelligence</label>@else<input type="checkbox" id="primary21" name="school_curriculam[]" value="Multiple Intelligence" disabled><label for="primary21">Multiple Intelligence</label>@endif</div></div>
                                        <div class="infra_options px-0"><div class="form-group">@if(in_array('Learning Style',$curriculam))<input type="checkbox" id="primary22" name="school_curriculam[]" value="Learning Style" checked onclick="return false"><label for="primary22">Learning Style</label>@else<input type="checkbox" id="primary22" name="school_curriculam[]" value="Learning Style" disabled><label for="primary22">Learning Style</label>@endif</div></div>
                                        <div class="infra_options px-0"><div class="form-group">@if(in_array('Universal design for Learning',$curriculam))<input type="checkbox" id="primary23" name="school_curriculam[]" value="Universal design for Learning" checked onclick="return false"><label for="primary23">Universal design for Learning</label>@else<input type="checkbox" id="primary23" name="school_curriculam[]" value="Universal design for Learning" disabled><label for="primary23">Universal design for Learning</label>@endif</div></div>
                                        <div class="infra_options px-0"><div class="form-group">@if(in_array('Social Emotional Curriculam',$curriculam))<input type="checkbox" id="primary24" name="school_curriculam[]" value="Social Emotional Curriculam" checked onclick="return false"><label for="primary24">Social Emotional Curriculam</label>@else<input type="checkbox" id="primary24" name="school_curriculam[]" value="Social Emotional Curriculam" disabled><label for="primary24">Social Emotional Curriculam</label>@endif</div></div>
                                    </div>
                                </div>
                                <div class="container containerpadding"><label class="control-label heading">3.Has Your School Implemented the Policies:</label><span class="error-star" style="color:red;">*</span>
                                    <div class="d-flex flex-wrap">
                                        <div class="infra_options px-0"><div class="form-group">@if(in_array('Child Protection Policy',$policy))<input type="checkbox" id="primary25" name="school_policy[]" value="Child Protection Policy" checked onclick="return false"><label for="primary25">Child Protection Policy</label>@else<input type="checkbox" id="primary25" name="school_policy[]" value="Child Protection Policy" disabled><label for="primary25">Child Protection Policy</label>@endif</div></div>
                                        <div class="infra_options px-0"><div class="form-group">@if(in_array('Health & Safety',$policy))<input type="checkbox" id="primary26" name="school_policy[]" value="Health & Safety" checked onclick="return false"><label for="primary26">Health & Safety</label>@else<input type="checkbox" id="primary26" name="school_policy[]" value="Health & Safety" disabled><label for="primary26">Health & Safety</label>@endif</div></div>
                                        <div class="infra_options px-0"><div class="form-group">@if(in_array('RTE Act 2009',$policy))<input type="checkbox" id="primary27" name="school_policy[]" value="RTE Act 2009" checked onclick="return false"><label for="primary27">RTE Act 2009</label>@else<input type="checkbox" id="primary27" name="school_policy[]" value="RTE Act 2009" disabled><label for="primary27">RTE Act 2009</label>@endif</div></div>
                                        <div class="infra_options px-0"><div class="form-group">@if(in_array('Barrier Free Environment(Accessibility)',$policy))<input type="checkbox" id="primary28" name="school_policy[]" value="Barrier Free Environment(Accessibility)" checked onclick="return false"><label for="primary28">Barrier Free Environment(Accessibility)</label>@else<input type="checkbox" id="primary28" name="school_policy[]" value="Barrier Free Environment(Accessibility)" disabled><label for="primary28">Barrier Free Environment(Accessibility)</label>@endif</div></div>
                                        <div class="infra_options px-0"><div class="form-group">@if(in_array('Grievance Redressal Committee',$policy))<input type="checkbox" id="primary29" name="school_policy[]" value="Grievance Redressal Committee" checked onclick="return false"><label for="primary29">Grievance Redressal Committee</label>@else<input type="checkbox" id="primary29" name="school_policy[]" value="Grievance Redressal Committee" disabled><label for="primary29">Grievance Redressal Committee</label>@endif</div></div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12 text-center">
                                <a type="button" class="btn btn-labeled btn-info" onclick="DoAction('tab1');" title="Previous" style="background: blue !important; border-color:#4d94ff !important; color:white !important"><span class="btn-label"><i class="fa fa-arrow-left"></i></span>Previous</a>
                                <a type="button" class="btn btn-labeled back-btn" title="Cancel" href="{{ route('enrollement.schoollist') }}" style="color:white !important"><span class="btn-label"><i class="fa fa-times"></i></span> Cancel</a>
                                <a type="button" class="btn btn-labeled btn-info" onclick="DoAction('tab3');" title="Next" style="background: blue !important; border-color:#4d94ff !important; color:white !important"><span class="btn-label">Next</span> <i class="fa fa-arrow-right"></i></a>
                            </div>
                        </section>
                    </div>

                    <!-- TAB 3 -->
                    <div class="tab-pane fade show" id="tab3" role="tabpanel" aria-labelledby="contact-tab">
                        <section class="section">
                            <div class="section-body mt-1">
                                <div class="row">
                                    <div class="col-md-12"><div class="form-group"><label class="control-label heading">1.Does the School have an Enclusion Policy that specifies action for including children with special needs?:</label><span class="error-star" style="color:red;">*</span><br><input type="radio" id="question1" name="have_exclusion_policy" value="Yes" {{ ($row['have_exclusion_policy']=="Yes")? "checked" : "disabled" }}><label class="questionpadding">YES</label><input type="radio" id="question2" name="have_exclusion_policy" value="No" {{ ($row['have_exclusion_policy']=="No")? "checked" : "disabled" }}><label class="questionpadding">NO</label></div></div>
                                    <div class="col-md-12"><div class="form-group"><label class="control-label heading">2.Is a Multidisciplinary team approches in your school to provide alternatives to suspension or expulsion for students with complex needs?:<span class="error-star" style="color:red;">*</span></label><br><input type="radio" id="question3" name="multidisciplinary_team" value="Yes" {{ ($row['multidisciplinary_team']=="Yes")? "checked" : "disabled" }}><label class="questionpadding">YES</label><input type="radio" id="question4" name="multidisciplinary_team" value="No" {{ ($row['multidisciplinary_team']=="No")? "checked" : "disabled" }}><label class="questionpadding">NO</label></div></div>
                                    @if($row['multidisciplinary_team']==="Yes")
                                    <div class="col-md-12" id="question5"><div class="form-group"><label class="control-label heading">3.Is there a shared framework for goals and outcomes of multidisciplinary teams work in your school:</label><span class="error-star" style="color:red;">*</span><textarea class="form-control" name="multidisciplinary_team_desc" disabled>{{ $row['multidisciplinary_team_desc']}}</textarea></div></div>
                                    @endif
                                </div>
                                <div class="col-md-12 text-center">
                                    <a type="button" class="btn btn-labeled btn-info" onclick="DoAction('tab2');" title="Previous" style="background: blue !important; border-color:#4d94ff !important; color:white !important"><span class="btn-label"><i class="fa fa-arrow-left"></i></span>Previous</a>
                                    <a type="button" class="btn btn-labeled back-btn" title="Cancel" href="{{ route('enrollement.schoollist') }}" style="color:white !important"><span class="btn-label"><i class="fa fa-times"></i></span> Cancel</a>
                                </div>
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
<script>
    function ndate(d) {
        date = d.value;
        var date_from = document.getElementById("date_of_stay_from").value;
        var date_to = document.getElementById("date_of_stay_to").value;
        if (date_from != "" && date_to != "") {
            const date1 = new Date(date_from);
            const date2 = new Date(date_to);
            function getDifferenceInDays(date1, date2) {
                const diffInMs = Math.abs(date2 - date1);
                document.getElementById("date_of_stay").value = diffInMs / (1000 * 60 * 60 * 24);
            }
            window.addval(date);
        }
    }
    $(document).ready(function() {
        $("#content").find("[id^='tab']").hide();
        $("#home-tab").addClass("active");
        $("#tab1").fadeIn();
    });
    $("#tile-1 .nav-tabs a").click(function() {
        var position = $(this).parent().position();
        var width = $(this).parent().width();
        $("#tile-1 .slider").css({ "left": +position.left, "width": width });
        $("#tab-content").find("[id^='tab']").hide();
        $('#' + $(this).attr('name')).fadeIn();
    });
    function DoAction(id) {
        $("#tab-content").find("[id^='tab']").hide();
        $("#tabs a").removeClass("active");
        $("a[name='" + id + "']").addClass("active");
        var position = $("a[name='" + id + "']").position();
        var width = $("a[name='" + id + "']").width();
        $("#tile-1 .slider").css({ "left": +position.left, "width": width });
        $('#' + (id)).fadeIn();
    }
    function childName(event) { let value = event.target.value || ''; value = value.replace(/[^a-z A-Z ]/, ''); event.target.value = value; }
    function childfatherName(event) { let value = event.target.value || ''; value = value.replace(/[^a-z A-Z ]/, ''); event.target.value = value; }
    function childmotherName(event) { let value = event.target.value || ''; value = value.replace(/[^a-z A-Z ]/, ''); event.target.value = value; }
    function contactphonenumber(event) { let value = event.target.value || ''; value = value.replace(/[^0-9+ ]/, ''); event.target.value = value; }
    function save() {
        var child_name = $('#child_name').val();
        if (child_name == '') { swal("Please Enter Child's Name: ", "", "error"); return false; }
        var child_dob = $('.child_dob').val();
        if (child_dob == '') { swal("Please Enter Child's Date of Birth:", "", "error"); return false; }
        var child_gender = $('input[name="child_gender"]:checked').val();
        if (child_gender !== "Male" && child_gender !== "Female") { swal({ title: "Error", text: "select Child's Gender", type: 'error', confirmButtontext: "OK" }); return false; }
        var child_school_name_address = $('.child_school_name_address').val();
        if (child_school_name_address == '') { swal("Please Enter Child's current school name and address:", "", "error"); return false; }
        var child_father_guardian_name = $('#child_father_guardian_name').val();
        if (child_father_guardian_name == '') { swal("Please Enter Child's Father/ Guardian Name:  ", "", "error"); return false; }
        var child_mother_caretaker_name = $('#child_mother_caretaker_name').val();
        if (child_mother_caretaker_name == '') { swal("Please Enter Child's Mother/Primary caretaker's Name:  ", "", "error"); return false; }
        var child_contact_email = $('#child_contact_email').val();
        if (child_contact_email == '') { swal("Please Enter Email Address:  ", "", "error"); return false; }
        var child_contact_phone = $('#child_contact_phone').val();
        if (child_contact_phone == '') { swal("Please Enter Contact Phone number:  ", "", "error"); return false; }
        var child_contact_address = $('#child_contact_address').val();
        if (child_contact_address == '') { swal("Please Enter Address:  ", "", "error"); return false; }
        document.getElementById('newenrollement').submit('saved');
    }
    function submit() {
        var featured3 = document.getElementById("featured-3");
        var featured4 = document.getElementById("featured-4");
        var featured11 = document.getElementById("featured-11");
        var featured12 = document.getElementById("featured-12");
        if ((featured3.checked == false) && (featured4.checked == false) && (featured11.checked == false) && (featured12.checked == false)) {
            swal({ title: "Error", text: "Please Select atleast one Question from Services from Elina", type: 'error', confirmButtontext: "OK" });
            return false;
        }
        var featured5 = document.getElementById("featured-5");
        var featured6 = document.getElementById("featured-6");
        var featured7 = document.getElementById("featured-7");
        var featured8 = document.getElementById("featured-8");
        var featured9 = document.getElementById("featured-9");
        var featured10 = document.getElementById("featured-10");
        if ((featured5.checked == false) && (featured6.checked == false) && (featured7.checked == false) && (featured8.checked == false) && (featured9.checked == false) && (featured10.checked == false)) {
            swal({ title: "Error", text: "Please Select atleast one Qusetion from About Elina", type: 'error', confirmButtontext: "OK" });
            return false;
        }
        document.getElementById('newenrollement').submit('saved');
    }
</script>
<script>
    var phone_number = document.querySelector("#phone_number");
    var phone_number2 = document.querySelector("#telephone_number");
    if (typeof intlTelInput !== 'undefined') {
        var iti = window.intlTelInput(phone_number, { initialCountry: "in", separateDialCode: true, utilsScript: "//cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.3/js/utils.js" });
        var iti2 = window.intlTelInput(phone_number2, { initialCountry: "in", separateDialCode: true, utilsScript: "//cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.3/js/utils.js" });
    }
</script>

@endsection