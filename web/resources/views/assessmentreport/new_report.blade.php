@extends('layouts.reports_nav')
@section('content')
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />
<style>
    .tab {
        overflow: hidden;
        background-color: #d4d0cf;
        border-radius: 36px;
        width: 20000px;
        margin: auto;
        text-align: center;
        align-items: center;
    }

    .tab button {
        background-color: #d4d0cf;
        /* float: left; */
        border: none;
        outline: none;
        cursor: pointer;
        padding: 6px 3.1rem;
        transition: 0.3s;
        font-size: 17px;
        border-radius: 36px;
    }

    .tab button:hover {
        background-color: #f37020;
    }

    .tab button.active {
        background-color: #f37020;
    }

    .tabcontent {
        display: none;
        padding: 6px 12px;
        flex-direction: column;
        /* margin-top: 20px; */
        /* border: 1px solid #ccc; */
        /* border-top: none; */
    }

    .swiper-container {
        width: 85%;
        /* height: 50%; */
        border: 3px solid #f37020;
        border-radius: 35px;
    }

    .swiper-slide {
        text-align: center;
        font-size: 18px;
        background: #fff;
        display: -webkit-box;
        display: -ms-flexbox;
        display: -webkit-flex;
        display: flex;
        -webkit-box-pack: center;
        -ms-flex-pack: center;
        -webkit-justify-content: center;
        justify-content: center;
        -webkit-box-align: center;
        -ms-flex-align: center;
        -webkit-align-items: center;
        align-items: center;
    }

    .divClass {
        margin-bottom: 10px;
    }

    .swiper-slide-active {
        background-color: #f37020 !important;

    }

    .form-group .control-label,
    .form-group>label {
        font-size: 20px !important;
        margin-top: 10px;
    }

    .tablinks {
        flex-basis: fit-content;
    }

    .swipenav {
        /* height: 25px; */
        /* margin-top: -305px; */
        /* margin-top: 0px; */
        /* width: 150px; */
        /* transform: translateY(-50%); */
        /* margin-top: -14px; */
        /* width: 160px; */
    }

    input[type=checkbox] {
        transform: scale(1.5);
        margin: 0 14px 0 20px;
    }

    .wizard {
        position: relative;
        display: flex;
        width: 100%;
    }

    .wizard:before {
        content: "";
        position: absolute;
        background-color: #0a0a0a;
        height: 2px;
        width: 100%;
        top: 50%;
        left: 0;
        transform: translateY(-50%);
    }

    .wizard-bar {
        position: absolute;
        background-color: #1e4dba;
        height: 2px;
        top: 50%;
        left: 0;
        transform: translateY(-50%);
        transition: 0.3s ease;
    }

    .wizard-list {
        display: flex;
        align-items: center;
        justify-content: space-between;
        width: 100%;
    }

    .wizard-item {
        z-index: 2;
        transition: 0.4s ease;
        min-width: 32px;
        height: 32px;
        border-radius: 50%;
        border: 2px solid #1E4DBA;
        color: #1E4DBA;
        display: -webkit-box;
        display: -ms-flexbox;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 500;
        background-color: #f4f4f4;
    }

    .wizard-item.active {
        background-color: #1E4DBA;
        color: #fff;
    }

    .md-stepper-horizontal {
        display: table;
        width: 100%;
        margin: 0 auto;
        background-color: #FFFFFF;
    }

    .md-stepper-horizontal .md-step {
        display: table-cell;
        position: relative;
        padding: 20px;
    }

    .md-stepper-horizontal .md-step:active {
        border-radius: 15% / 75%;
    }

    .md-stepper-horizontal .md-step:first-child:active {
        border-top-left-radius: 0;
        border-bottom-left-radius: 0;
    }

    .md-stepper-horizontal .md-step:last-child:active {
        border-top-right-radius: 0;
        border-bottom-right-radius: 0;
    }

    .md-stepper-horizontal .md-step:first-child .md-step-bar-left,
    .md-stepper-horizontal .md-step:last-child .md-step-bar-right {
        display: none;
    }

    .md-stepper-horizontal .md-step .md-step-circle {
        width: 30px;
        height: 30px;
        margin: 0 auto;
        background-color: #999999;
        border-radius: 50%;
        text-align: center;
        line-height: 30px;
        font-size: 16px;
        font-weight: 600;
        color: #FFFFFF;
        cursor: pointer;
    }

    .md-stepper-horizontal.green .md-step.active .md-step-circle {
        background-color: #00AE4D;

    }

    .md-stepper-horizontal.orange .md-step.active .md-step-circle {
        background-color: #F96302;
    }

    .md-stepper-horizontal .md-step.active .md-step-circle {
        background-color: rgb(33, 150, 243);
    }

    .md-stepper-horizontal .md-step.done .md-step-circle:before {
        font-family: 'FontAwesome';
        font-weight: 100;
        content: "\f00c";
    }

    .md-stepper-horizontal .md-step.done .md-step-circle *,
    .md-stepper-horizontal .md-step.editable .md-step-circle * {
        display: none;
    }

    .md-stepper-horizontal .md-step.editable .md-step-circle {
        -moz-transform: scaleX(-1);
        -o-transform: scaleX(-1);
        -webkit-transform: scaleX(-1);
        transform: scaleX(-1);
    }

    .md-stepper-horizontal .md-step.editable .md-step-circle:before {
        font-family: 'FontAwesome';
        font-weight: 100;
        content: "\f040";
    }

    .md-stepper-horizontal .md-step .md-step-title {
        margin-top: 16px;
        font-size: 16px;
        font-weight: 600;
    }

    .md-stepper-horizontal .md-step .md-step-title,
    .md-stepper-horizontal .md-step .md-step-optional {
        text-align: center;
        color: rgba(0, 0, 0, .26);
    }

    .md-stepper-horizontal .md-step.active .md-step-title {
        font-weight: 600;
        color: rgba(0, 0, 0, .87);
    }

    .md-stepper-horizontal .md-step .md-step-optional {
        font-size: 12px;
    }

    .md-stepper-horizontal .md-step.active .md-step-optional {
        color: rgba(0, 0, 0, .54);
    }

    .md-stepper-horizontal .md-step .md-step-bar-left,
    .md-stepper-horizontal .md-step .md-step-bar-right {
        position: absolute;
        top: 36px;
        height: 20px;
        border-top: 3px solid #DDDDDD;
    }

    .md-stepper-horizontal .md-step .md-step-bar-right {
        right: 0;
        left: 50%;
        margin-left: 20px;
    }

    .md-stepper-horizontal .md-step .md-step-bar-left {
        left: 0;
        right: 50%;
        margin-right: 20px;
    }

    .md-stepper-horizontal .md-step.done .md-step-circle {
        background: #84D768;
    }

    .md-stepper-horizontal .md-step.editable .md-step-circle {
        background: #f05a00;
    }

    .form__input {
        border: 1px solid #ced4da;
        border-radius: 0.25rem;
    }

    .form__div {
        font-size: 16px;
        margin: 10px 20px 10px 20px;
        display: flex;
        flex-wrap: wrap;
    }

    .form__card {
        /* width: 85%; */
        /* align-self: center; */
        /* left: 6%; */
        margin: 15px 20px 10px 20px;
        border: 1px solid;
    }

    .scrollable,
    #scroll {
        -ms-overflow-style: none;
        scrollbar-width: none;
        /* height: 300px; */
        display: flex;
        flex-direction: column;
        overflow-y: scroll;
    }

    .scrollable::-webkit-scrollbar {
        display: none;
    }

    table {
        text-align: left;
        position: relative;
        border-collapse: collapse;
    }

    th,
    td {
        margin: 0;

    }

    th {
        background: #62acde;
        position: sticky;
        top: 0;
        margin: 0 !important;
        box-shadow: 0 2px 2px -1px rgba(0, 0, 0, 0.4);
    }

    .table thead th {
        vertical-align: inherit !important;
        text-align: center;
    }

    .table_input {
        width: 100%;
        height: 46px;
        outline: none;
        border: none;
    }

    .swiper-button-prev {
        margin: -33px 0px 0px 25px !important;
        /* background-image: url('/images/arrowL.png') !important; */
    }

    .swiper-button-next {
        margin: -35px 25px 0 0 !important;
        /* background-image: url('/images/arrowR.png') !important; */
    }

    .swiper-button-prev.swiper-button-disabled,
    .swiper-button-next.swiper-button-disabled {
        opacity: 0;
    }

    .btn-circle {
        width: 30px;
        height: 30px;
        padding: 6px 0px;
        border-radius: 15px;
        text-align: center;
        font-size: 12px;
        line-height: 1.42857;
    }

    .addR {
        display: none;
    }

    .my-select {
        appearance: none;
        -webkit-appearance: none;
        background-image: none;
        padding: 5px;
    }

    .check {
        -webkit-appearance: none;
        height: 22px;
        width: 21px;
        transition: 0.10s;
        border: 1px solid black;
        text-align: center;
        color: white;
        border-radius: 3px;
        background: white;
    }

    .check:checked:before {
        content: "✖";
        color: red;
        margin: 16px 0 15px 0 !important;
    }

    .switch_radio {
        -webkit-appearance: none;
        height: 22px;
        width: 21px;
        transition: 0.10s;
        border: 1px solid black;
        text-align: center;
        color: white;
        border-radius: 3px;
        background: white;
    }

    .switch_radio:checked:before {
        content: "✔";
        /* Change tick symbol */
        color: green;
        /* Change color to green */
        margin: 16px 0 15px 0 !important;
        height: 22px;
        width: 21px;
    }
</style>

<div class="main-content">
    {{ Breadcrumbs::render('assessmentreport.create') }}
    <div class="section-body mt-1">
        <h5 class="text-center align" style="color:darkblue">Compilation of Assessment Report</h5>
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row is-coordinate">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="control-label">Enrollment ID<span class="error-star" style="color:red;">*</span></label>
                                    <select class="form-control" id="enrollment_child_num" name="enrollment_child_num" onchange="GetChilddetails()">
                                        <option value="">Select-Enrollment</option>
                                        @foreach($enrollment_details as $key=>$row)
                                        <option value="{{$row['enrollment_child_num']}}">{{ $row['enrollment_child_num']}} ( {{$row['child_name']}} )</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <input type="hidden" id="user_id" name="user_id">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="control-label">Child ID</label>
                                    <input class="form-control readonly" type="text" id="child_id" name="child_id" placeholder="Child ID" autocomplete="off" readonly>
                                    <input type="hidden" id="enrollment_id" name="enrollment_id" autocomplete="off" readonly>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="control-label">Child Name</label>
                                    <input class="form-control readonly" type="text" id="child_name" name="child_name" oninput="Childname(event)" maxlength="20" value="" placeholder="Enter Name" autocomplete="off" readonly>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="control-label">Date of Reporting</label>
                                    <input class="form-control default" type="date" onchange="document.getElementById('dor').value = this.value" value="<?php echo date('Y-m-d'); ?>">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="control-label"></label>
                                    <button class="form-control default" style="margin: 20px 0 0px 0;" onclick="openPopup()">Observation</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @include('assessmentreport.observation_details')
            @include('assessmentreport.observation_modal')
            <div class="row" id="r1">
                <div class="col-md-12 col-lg-12 mlr-auto" style="padding-top: 20px;">
                    <div class="md-stepper-horizontal" style="    margin-bottom: 20px;">
                        @foreach($pages as $page)
                        <div class="md-step" onclick="stepClick('{{$page['page']}}')" id="stepper{{$page['page']}}" data-slide="{{$page['page']}}">
                            <div class="md-step-circle" data-slide="{{$page['page']}}"><span class="" data-slide="{{$page['page']}}">{{$page['page']}}</span></div>
                            <div class="md-step-bar-left"></div>
                            <div class="md-step-bar-right"></div>
                        </div>
                        @endforeach
                    </div>
                </div>

                <div class="scroll-break-div"></div>
                <div class="col-12">
                    <div class="swiper-container" style="margin-bottom: 30px;">
                        <div class="swiper-wrapper tab" id="categoryTab">
                            @foreach($pages as $page)
                            @if($page['tab_name'] != '')
                            <button class="swiper-slide tablinks" id="Tab{{$page['page']}}" onclick="openCity('{{$page['page']}}');">{{$page['tab_name']}}<input type="checkbox" name="switch[]" value="{{$page['page']}}" class="check" onclick="handleCheckboxChange(this)"></button>
                            @else
                            <button class="swiper-slide tablinks" id="Tab{{$page['page']}}" onclick="openCity('{{$page['page']}}')">PAGE11 - {{$page['page']}}<input type="checkbox" name="switch[]" value="{{$page['page']}}" class="check" onclick="handleCheckboxChange(this)"></button>
                            @endif
                            @endforeach

                        </div>
                    </div>
                </div>
            </div>

        </div>
        <div id="r2">
            <form name="edit_form" action="{{ route('report.new')}}" method="POST" id="form_report">
                {{ csrf_field() }}
                <input type="hidden" id="state" name="state">
                <input type="hidden" id="enrollmentId" name="enrollmentId">
                <input type="hidden" value="{{$report}}" name="reports_id" id="reports_id">
                <input type="hidden" id="currentPage" name="currentPage">
                <input type="hidden" id="removedPages" name="removedPages">
                <input type="hidden" id="switch_radio_values" name="switch_radio_values">

                <input type="hidden" id="dor" name="dor" value="<?php echo date('Y-m-d'); ?>">
                <div class="row" style="    margin: 25px 0px 0px 0px;">
                    @foreach($pages as $page)
                    <div class="col-12">
                        @if(!in_array((int)$page['page'], $excludedSteps))
                        <a class="btn observation_info" id="observation_info_{{$page['page']}}" style="display: none;" onclick="detailsuggestion('Step{{$page['page']}}','create')"> <i class="fa fa-info-circle" aria-hidden="true"></i> {{$page['tab_name']}} info</a>
                        @endif
                        <div id="card content">
                            <div id="Step{{$page['page']}}" class="card-body tabcontent paginationTab{{$page['page']}}">
                                <textarea class="meeting_description" page-order="{{$page['page']}}" id="meeting_description{{$loop->iteration}}" name="meeting_description[{{$page['page']}}]" {{ $page['page'] == '14' ? 'style=display:none;' : '' }}>
                                {{$page['page_description']}}
                                </textarea>
                                @if($page['assesment_skill_id'])
                                @foreach($perskill as $perskills)
                                @if($perskills['performance_area_id'] == $page['assesment_skill_id'])
                                @if($perskills['skill_type'] == 1)
                                @include('assessmentreport.skill_type_1', ['page' => $page, 'perskills' => $perskills, 'activitys' => $activitys, 'observations' => $observations])
                                @elseif($perskills['skill_type'] == 2)
                                @include('assessmentreport.skill_type_2', ['page' => $page, 'perskills' => $perskills, 'activitys' => $activitys, 'observations' => $observations])
                                @elseif($perskills['skill_type'] == 3)
                                @include('assessmentreport.skill_type_3', ['page' => $page, 'perskills' => $perskills, 'subskill' => $subskill, 'activitys' => $activitys, 'observations' => $observations])
                                @endif
                                @endif
                                @endforeach
                                @endif
                            </div>
                        </div>
                    </div>
                    @endforeach

                    <div class="col-12 scrollable fixTableHead title-padding" style="display: none;" id="page8">
                        <div class="table-responsive">
                            <table class="table table-bordered card-body" id="main" style="table-layout: fixed; width: 100%;">
                                <thead>
                                    <tr>
                                        <th width="30%">Quadrants</th>
                                        <th width="30%">Evidence</th>
                                        <th width="30%">Recommendations</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td width="50%" style="border: 1px solid #040404 !important;color: #141414;background-color: white !important;">
                                            Seeks out and is attracted to a stimulating sensory environment
                                        </td>
                                        <td style="background: white;border: 1px solid #0e0e0e !important;vertical-align: initial !important;">
                                            <textarea style="width: 100%;height:150px;" class="tinymce-textarea" id="" name="rows2[1]"></textarea>
                                        </td>
                                        <td style="background: white;border: 1px solid #0e0e0e !important;vertical-align: initial !important;">
                                            <textarea style="width: 100%;height:150px;" class="tinymce-textarea" id="" name="rec_rows2[1]"></textarea>
                                        </td>
                                    </tr>

                                    <tr id="row">
                                        <th width="50%" style="border: 1px solid #040404 !important;color: #141414;background-color: white !important;">
                                            Distressed by a stimulating sensory environment and attempts to leave the environment
                                        </th>
                                        <td style="background: white;border: 1px solid #0e0e0e !important;vertical-align: initial !important;">
                                            <textarea style="width: 100%;height:150px;" class="tinymce-textarea" id="" name="rows2[2]"></textarea>
                                        </td>
                                        <td style="background: white;border: 1px solid #0e0e0e !important;vertical-align: initial !important;">
                                            <textarea style="width: 100%;height:150px;" class="tinymce-textarea" id="" name="rec_rows2[2]"></textarea>
                                        </td>
                                    </tr>

                                    <tr>
                                        <th width="50%" style="border: 1px solid #040404 !important;color: #141414;background-color: white !important;">
                                            Sensitivity to stimuli, distractibility, discomfort with sensory stimuli
                                        </th>
                                        <td style="background: white;border: 1px solid #0e0e0e !important;vertical-align: initial !important;">
                                            <textarea style="width: 100%;height:150px;" class="tinymce-textarea" id="" name="rows2[3]"></textarea>
                                        </td>
                                        <td style="background: white;border: 1px solid #0e0e0e !important;vertical-align: initial !important;">
                                            <textarea style="width: 100%;height:150px;" class="tinymce-textarea" id="" name="rec_rows2[3]"></textarea>
                                        </td>
                                    </tr>

                                    <tr id="row">
                                        <th width="50%" style="border: 1px solid #040404 !important;color: #141414;background-color: white !important;">
                                            Missing stimuli, responding slowly
                                        </th>
                                        <td style="background: white;border: 1px solid #0e0e0e !important;vertical-align: initial !important;">
                                            <textarea style="width: 100%;height:150px;" class="tinymce-textarea" id="" name="rows2[4]"></textarea>
                                        </td>
                                        <td style="background: white;border: 1px solid #0e0e0e !important;vertical-align: initial !important;">
                                            <textarea style="width: 100%;height:150px;" class="tinymce-textarea" id="" name="rec_rows2[4]"></textarea>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="col-12 scrollable fixTableHead title-padding" style="display: none;" id="page14">
                        <div class="table-responsive">
                            <table class="table table-bordered card-body">
                                <tbody>
                                    <tr>
                                        <td style="background: white;border: 1px solid #0e0e0e !important;vertical-align: initial !important;">
                                            <textarea class="tinymce-textarea" style="width: 100%;height:150px;" id="signature_1" name="signature[1]"></textarea>
                                        </td>
                                        <td style="background: white;border: 1px solid #0e0e0e !important;vertical-align: initial !important;">
                                            <textarea class="tinymce-textarea" style="width: 100%;height:150px;" id="signature_2" name="signature[2]"></textarea>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </form>
            <div class="col-md-12 text-center">
                <a type="button" class="btn btn-labeled btn-info" onclick="PrevTab();" id="Previous" title="Previous" style="display:none;height: 35px;background: blue !important; border-color:blue !important; color:white !important">
                    <span class="btn-label" style="font-size:13px !important;"><i class="fa fa-arrow-left"></i></span> Previous</a>
                <a type="button" onclick="save('Saved')" id="submitbutton" class="btn btn-labeled btn-succes" title="Save" style="background: green !important; border-color:green !important; color:white !important">
                    <span class="btn-label" style="font-size:13px !important;"><i class="fa fa-check"></i></span> Save</a>
                <a type="button" onclick="save('Submitted')" id="submitbutton" class="btn btn-labeled btn-succes" title="Submit" style="background: orange !important; color:white !important">
                    <span class="btn-label" style="font-size:13px !important;"><i class="fa fa-check"></i></span> Submit</a>
                <a type="button" class="btn btn-labeled btn-info" onclick="NextTab();" id="Next" title="Next" style="background: blue !important; border-color:#4d94ff !important; color:white !important;height: 35px;">
                    <span class="btn-label" style="font-size:13px !important;">Next</span> <i class="fa fa-arrow-right"></i></a>
            </div>
            <div class="col-md-12 text-center" style="    margin: 10px 0 0 0;">
                <a type="button" class="btn btn-labeled back-btn" title="Back" href="{{ route('assessmentreport.index') }}" style="color:white !important">
                    <span class="btn-label" style="font-size:13px !important;"><i class="fa fa-arrow-left"></i></span> Back</a>
            </div>
        </div>
    </div>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Swiper/4.5.1/js/swiper.min.js"></script>

<script>
    $(document).ready(function() {

        var allpro = <?php echo json_encode($pages); ?>;
        $('.remove').click(function(e) {
            $(this).parents('tr').find('textarea').each(function() {
                if ($(this).val() == '') {
                    $(this).parents('tr').remove();
                } else {
                    Swal.fire({
                        title: 'Do you want to remove Skill from the report?',
                        text: 'Click Yes to remove the point. Please note that this action cannot be reversed',
                        icon: 'question',
                        showCancelButton: true,
                        confirmButtonText: 'Yes',
                        cancelButtonText: 'No',
                    }).then((result) => {
                        if (result.isConfirmed) {
                            $(this).parents('tr').remove();
                        }
                    });
                }
            });
        });

        $('.remove_a').click(function(e) {
            $(this).parents('tr').find('textarea').each(function() {
                if ($(this).val() == '') {
                    $(this).parents('tr').remove();
                } else {
                    Swal.fire({
                        title: 'Do you want to remove Skill from the report?',
                        text: 'Click Yes to remove the point. Please note that this action cannot be reversed',
                        icon: 'question',
                        showCancelButton: true,
                        confirmButtonText: 'Yes',
                        cancelButtonText: 'No',
                    }).then((result) => {
                        if (result.isConfirmed) {
                            $(this).parents('tr').remove();
                        }
                    });
                }
            });
        });

        $('.remove_b').click(function(e) {
            $(this).parents('tr').find('textarea').each(function() {
                if ($(this).val() == '') {
                    $(this).parents('tr').remove();
                } else {
                    Swal.fire({
                        title: 'Do you want to remove Skill from the report?',
                        text: 'Click Yes to remove the point. Please note that this action cannot be reversed',
                        icon: 'question',
                        showCancelButton: true,
                        confirmButtonText: 'Yes',
                        cancelButtonText: 'No',
                    }).then((result) => {
                        if (result.isConfirmed) {
                            $(this).parents('tr').remove();
                        }
                    });
                }
            });
        });

    });
</script>
<script>
    function save(a) {
        if (document.getElementById('enrollment_child_num').value == "") {
            swal.fire("Please Select Enrolment Number", "", "error");
            return false;
        }
        var tabIDs = $('.tablinks.swiper-slide-active').attr('id');
        var ret1 = tabIDs.replace('Tab', '');
        document.getElementById('state').value = a;
        document.getElementById('currentPage').value = ret1;

        $('.loader').show();
        document.getElementById('form_report').submit();

    }
</script>
<script>
    $(document).ready(function() {
        tinymce.init({
            selector: '.meeting_description',
            plugins: 'preview importcss searchreplace autolink autosave save directionality code visualblocks visualchars fullscreen image link media codesample table charmap pagebreak nonbreaking anchor insertdatetime advlist lists wordcount help charmap quickbars emoticons',
            imagetools_cors_hosts: ['picsum.photos'],
            menubar: 'file edit view insert format table help',
            toolbar: 'undo redo | bold italic underline strikethrough | fontfamily fontsize blocks | alignleft aligncenter alignright alignjustify | outdent indent |  numlist bullist | forecolor backcolor removeformat | pagebreak | charmap emoticons | fullscreen  preview save print | insertfile image media link anchor codesample | ltr rtl',
            toolbar_sticky: true,
            autosave_ask_before_unload: false, //Set True to for confirmation on unload
            autosave_interval: "30s",
            autosave_prefix: "{path}{query}-{id}-",
            autosave_restore_when_empty: false,
            autosave_retention: "2m",
            image_advtab: true,
            content_css: "{{url('assets/css/css2.css')}}",
            font_formats: "Andale Mono=andale mono,times; Arial=arial,helvetica,sans-serif; Arial Black=arial black,avant garde; Barlow=Barlow, sans-serif; Barlow Condensed=Barlow Condensed, sans-serif; Barlow Semi Condensed=Barlow Semi Condensed, sans-serif; Plain Barlow Black=Barlow Black, sans-serif; Plain Barlow Bold=Barlow Bold, sans-serif; Plain Barlow Light=Barlow Light, sans-serif; Plain Barlow Medium=Barlow Medium, sans-serif; Plain Barlow Thin=Barlow Thin, sans-serif; Book Antiqua=book antiqua,palatino; Comic Sans MS=comic sans ms,sans-serif; Courier New=courier new,courier; Georgia=georgia,palatino; Helvetica=helvetica; Impact=impact,chicago; Oswald=oswald; Symbol=symbol; Tahoma=tahoma,arial,helvetica,sans-serif; Terminal=terminal,monaco; Times New Roman=times new roman,times; Trebuchet MS=trebuchet ms,geneva; Verdana=verdana,geneva; Webdings=webdings; Wingdings=wingdings,zapf dingbats",
            content_style: "@import url('https://fonts.googleapis.com/css2?family=Barlow&display=swap');",
            content_style: "@import url('https://fonts.googleapis.com/css2?family=Barlow+Condensed:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap');",
            content_style: "@import url('https://fonts.googleapis.com/css2?family=Barlow+Semi+Condensed:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap');",
            importcss_append: true,

            file_picker_callback: function(cb, value, meta) {
                var input = document.createElement('input');
                input.setAttribute('type', 'file');
                input.setAttribute('accept', 'image/*');
                input.onchange = function() {
                    var file = this.files[0];
                    var reader = new FileReader();
                    reader.onload = function() {
                        var id = 'blobid' + (new Date()).getTime();
                        var blobCache = tinymce.activeEditor.editorUpload.blobCache;
                        var base64 = reader.result.split(',')[1];
                        var blobInfo = blobCache.create(id, file, base64);
                        blobCache.add(blobInfo);
                        cb(blobInfo.blobUri(), {
                            title: file.name
                        });
                    };
                    reader.readAsDataURL(file);
                };
                input.click();
            },
            height: 520,
            image_caption: true,
            quickbars_selection_toolbar: 'bold italic | quicklink h2 h3 blockquote quickimage quicktable',
            noneditable_noneditable_class: "mceNonEditable",
            toolbar_mode: 'sliding',
            contextmenu: "link image imagetools table",
        });

        tinymce.init({
            selector: '.tinymce-textarea',
            height: 200,
            branding: false,
            plugins: 'importcss link',
            toolbar: 'undo redo | bold italic underline | link | fontsizeselect fontselect',
            autosave_ask_before_unload: false, //Set True to for confirmation on unload
            toolbar: '',
            font_formats: "Andale Mono=andale mono,times; Arial=arial,helvetica,sans-serif; Arial Black=arial black,avant garde; Barlow=Barlow, sans-serif; Barlow Condensed=Barlow Condensed, sans-serif; Barlow Semi Condensed=Barlow Semi Condensed, sans-serif; Plain Barlow Black=Barlow Black, sans-serif; Plain Barlow Bold=Barlow Bold, sans-serif; Plain Barlow Light=Barlow Light, sans-serif; Plain Barlow Medium=Barlow Medium, sans-serif; Plain Barlow Thin=Barlow Thin, sans-serif; Book Antiqua=book antiqua,palatino; Comic Sans MS=comic sans ms,sans-serif; Courier New=courier new,courier; Georgia=georgia,palatino; Helvetica=helvetica; Impact=impact,chicago; Oswald=oswald; Symbol=symbol; Tahoma=tahoma,arial,helvetica,sans-serif; Terminal=terminal,monaco; Times New Roman=times new roman,times; Trebuchet MS=trebuchet ms,geneva; Verdana=verdana,geneva; Webdings=webdings; Wingdings=wingdings,zapf dingbats",
            content_style: "@import url('https://fonts.googleapis.com/css2?family=Barlow&display=swap');",
            content_style: "@import url('https://fonts.googleapis.com/css2?family=Barlow+Condensed:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap');",
            content_style: "@import url(https://fonts.googleapis.com/css2?family=Barlow+Condensed:wght@400;display=swap);",
            content_style: "@import url(https://fonts.googleapis.com/css2?family=Barlow+Condensed:wght@700&display=swap);",
            content_style: "@import url('https://fonts.googleapis.com/css2?family=Barlow+Semi+Condensed:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap');",
            content_style: 'body {font-family :Barlow Condensed, sans-serif; font-size:14px }',

        });
    });
</script>
<script type="text/javascript">
    const firstSelect = document.getElementById("firstSelect");
    const addedOptions = new Set();

    function GetChilddetails() {
        var enrollment_child_num = $("select[name='enrollment_child_num']").val();

        if (enrollment_child_num != "") {
            $.ajax({
                url: "{{ url('/userregisterfee/enrollmentlist') }}",
                type: 'POST',
                data: {
                    'enrollment_child_num': enrollment_child_num,
                    _token: '{{csrf_token()}}'
                }
            }).done(function(data) {
                if (data != '[]') {
                    var optionsdata = "";
                    document.getElementById('child_id').value = data[0].child_id;
                    document.getElementById('child_name').value = data[0].child_name;
                    document.getElementById('enrollmentId').value = data[0].enrollment_id;
                    document.getElementById('enrollment_id').value = data[0].enrollment_id;
                    document.getElementById('user_id').value = data[0].user_id;
                    // var user_id = data[0].user_id;
                    // $('#a' + user_id).show();
                    var gender = (data[0].child_gender == "Male") ? 'He' : 'She';
                    for (p = 0; p < pages.length; p++) {
                        var k = p + 1;
                        // console.log('k', k);
                        if (k != 14) {
                            console.log('k', k);
                            var content = tinymce.get('meeting_description' + k).getContent();
                            content = content.replace(/ChildName/g, data[0].child_name);
                            content = content.replace(/He/g, gender);
                            content = content.replace(/She/g, gender);
                            tinymce.get('meeting_description' + k).setContent(content);
                        }
                    }
                    // 
                    // console.log('sensory');
                    $.ajax({
                        url: "{{ url('/sensory/enrollmentlist') }}",
                        type: 'POST',
                        data: {
                            'enrollment_child_num': enrollment_child_num,
                            _token: '{{csrf_token()}}'
                        }
                    }).done(function(data) {
                        console.log('sensory', data);
                        var evidence = data.evidence;
                        var matrix = data.matrix;
                        var sign = data.sign;
                        for (i = 0; i < matrix.length; i++) {
                            var evidenceObservation = '';
                            var skill_activity_id = matrix[i].skill_activity_id;
                            var activity_description = matrix[i].activity_description_id;
                            for (j = 0; j < evidence.length; j++) {
                                var activity_description_id = evidence[j].activity_description_id;
                                var comments = evidence[j].comments;
                                var isInArray = activity_description.includes(activity_description_id);
                                if (isInArray == true) {
                                    // console.log('comments' , comments);
                                    if (comments != null) {
                                        evidenceObservation += comments + ',';
                                    }
                                }
                            }
                            var evidenceElement = document.getElementById('evidence' + skill_activity_id);
                            if (evidenceElement) {
                                evidenceElement.value = evidenceObservation;
                            }
                            // document.getElementById('evidence' + skill_activity_id).value = evidenceObservation;
                        }
                        
                        for (var si = 0; si < sign.length; si++) {
                            var sii = si + 1;
                            var sign_content = sign[si].additional_details || ''; 
                            var editor = tinymce.get('signature_' + sii);
                            if (editor) {
                                editor.setContent(sign_content);
                            } else {
                                console.warn("TinyMCE editor 'signature_" + sii + "' is not initialized.");
                            }
                        }

                        var body_content = "";
                        
                        for (ei = 0; ei < evidence.length; ei++) {
                            var description = evidence[ei].description;
                            var activity = evidence[ei].activity_name;
                            var activityID = evidence[ei].activity_id;
                            var descriptionID = evidence[ei].activity_description_id;
                            var observationcomments = evidence[ei].comments;
                            if (observationcomments == null) {
                                observationcomments = '';
                            }

                            const activityKey = activity.replace(/\s+/g, "");
                            if (!addedOptions.has(activityKey)) {
                                const option = document.createElement("option");
                                option.value = activityKey;
                                option.textContent = activity;
                                firstSelect.appendChild(option);
                                addedOptions.add(activityKey);
                            }

                            body_content += `<tr data-activity-set="${activityKey}">`;

                            body_content += observationcomments ?
                                '<td><input type="checkbox" class="row-checkbox" /></td>' :
                                '<td></td>';

                            body_content += `
                                <td>${activity}</td>
                                <td>${description}</td>
                                <td>
                                    <span class="observation-text">${observationcomments || ''}</span>
                                    ${observationcomments ? '<span class="copy-icon" onclick="copyObservation(this)" title="Copy"><i class="fa fa-clipboard" aria-hidden="true"></i></span>' : ''}
                                </td>
                            </tr>`;
                        }

                        $('#activity-table').append(body_content);
                    })
                    // 
                } else {
                    document.getElementById('child_name');
                    var ddd = '<option value="child_name">Select Enrollment_child_num</option>';
                    var demonew = $('#child_name').html(ddd);
                }


            })

        } else {
            document.getElementById('initiated_by');
            var ddd = '<option value="initiated_by">Select Enrollment_child_num</option>';
            var demonew = $('#initiated_by').html(ddd);
        }
    };
</script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/Swiper/4.5.1/js/swiper.min.js"></script>
<script>
    function stepClick(step) {

        var tabName = 'Tab'.concat(step);
        document.getElementById(tabName).click();

        var tabIDs = $('.tablinks.swiper-slide-active').attr('id');
        var ret1 = tabIDs.replace('Tab', '');
        if (step < ret1) {
            PrevTab1(step);
        } else {
            NextTab1(step);
        }
    }

    function openCity(stepNum) { //alert(stepNum);
        if (stepNum == 6) {
            $('#page8').show();
        } else {
            $('#page8').hide();
        }
        if (stepNum == 14) {
            $('#page14').show();
        } else {
            $('#page14').hide();
        }
        var tabIDs = $('.tablinks.swiper-slide-active').attr('id');
        var ret1 = tabIDs.replace('Tab', '');
        var i, tabcontent, tablinks;
        var cityName = 'Step'.concat(stepNum);
        var tabName = 'Tab'.concat(stepNum);
        var stepper = 'stepper'.concat(stepNum);
        tabcontent = document.getElementsByClassName("tabcontent");
        for (i = 0; i < tabcontent.length; i++) {
            tabcontent[i].style.display = "none";
        }
        // document.getElementById(cityName).style.display = "flex";
        var element = document.getElementById(cityName);
        if (element) {
            element.style.display = "flex";
        }

        editingStep = document.getElementsByClassName("md-step");
        for (i = 0; i < editingStep.length; i++) {
            editingStep[i].className = editingStep[i].className.replace(" editable", "");
        }
        document.getElementById(stepper).classList.add('editable');
        if (stepNum < ret1) {
            PrevTab1(stepNum);
        } else {
            NextTab1(stepNum);
        }

        $('.observation_info').hide();
        $('#observation_info_' + stepNum).show();

    }
</script>
<script>
    var pages = <?php echo json_encode($pages); ?>;
    var divCount = pages.length;

    function NextTab() {
        var tabIDs = $('.tablinks.swiper-slide-active').attr('id');
        var ret1 = tabIDs.replace('Tab', '');
        nexttabID = Number(ret1) + 1;
        // if(nexttabID == 14){
        //     nexttabID = 15;
        // }
        stepClick(nexttabID);

        $('html,body').animate({
            scrollTop: $(".scroll-break-div").offset().top
        }, 'slow');
        if (nexttabID == divCount) {
            $('#Previous').show();
            $('#Next').hide();
        } else {
            $('#Previous').show();
            $('#Next').show();
        }
    }

    function PrevTab() {
        var tabIDs = $('.tablinks.swiper-slide-active').attr('id');
        var ret1 = tabIDs.replace('Tab', '');
        nexttabID = Number(ret1) - 1;
        // if(nexttabID == 14){
        //     nexttabID = 13;
        // }
        stepClick(nexttabID);

        $('html,body').animate({
            scrollTop: $(".scroll-break-div").offset().top
        }, 'slow');
        if (nexttabID == 1) {
            $('#Previous').hide();
            $('#Next').show();
        } else {
            $('#Previous').show();
            $('#Next').show();
        }
    }

    function NextTab1(stepNum) {
        var tabIDs = $('.tablinks.swiper-slide-active').attr('id');
        var ret1 = tabIDs.replace('Tab', '');
        nexttabID = stepNum;
        mySwiperSlide(nexttabID);
        $('html,body').animate({
            scrollTop: $(".scroll-break-div").offset().top
        }, 'slow');
        if (nexttabID == divCount) {
            $('#Previous').show();
            $('#Next').hide();
        } else {
            $('#Previous').show();
            $('#Next').show();
        }

    }

    function PrevTab1(stepNum) {
        // alert(StepNum);
        var tabIDs = $('.tablinks.swiper-slide-active').attr('id');
        var ret1 = tabIDs.replace('Tab', '');
        nexttabID = stepNum;
        mySwiperSlide(nexttabID);
        $('html,body').animate({
            scrollTop: $(".scroll-break-div").offset().top
        }, 'slow');
        if (nexttabID == 1) {
            $('#Previous').hide();
            $('#Next').show();
        } else {
            $('#Previous').show();
            $('#Next').show();
        }
    }
</script>
<script>
    $(document).ready(function() {
        var mySwiper = new Swiper('.swiper-container', {
            direction: 'horizontal',
            loop: false,
            grabCursor: true,
            centerInsufficientSlides: true,
            slidesPerView: 'auto',
            spaceBetween: 10,
            navigation: {
                nextEl: '.swiper-button-next',
                prevEl: '.swiper-button-prev',
            },
            scrollbar: '.swiper-scrollbar',
            slideToClickedSlide: true
        });

        $('.swiper-slide a').click(function() {
            if (!mySwiper.animating) {
                console.log('NOTanimating - so click thru');
            } else {
                console.log('animating');
                return false;
            }
        });

        function mySwiperSlide(step) {
            var slide = Number(step) - 1;
            mySwiper.slideTo(slide);

            if (slide > 2) {
                mySwiper.params.centeredSlides = true;
                mySwiper.update();
            } else {
                mySwiper.params.centeredSlides = false
                mySwiper.update();
            }

        }
        window.mySwiperSlide = mySwiperSlide;

    });

    $(document).ready(function() {
        document.getElementById('Step1').style.display = "flex";
        document.getElementById('stepper1').classList.add('editable');
        // document.getElementById('swiper_prev').style.display = "none";
        // navcheck();
    });
</script>

<script>
    var removedPages = [];

    function handleCheckboxChange(checkbox) {
        if (checkbox.checked) {
            Swal.fire({
                title: 'Do you want to remove this page from report?',
                text: 'Click Yes to remove this page.',
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'Yes',
                cancelButtonText: 'No',
            }).then((result) => {
                if (result.isConfirmed) {
                    checkbox.checked = true;
                    var value = checkbox.value;
                    var index = removedPages.indexOf(value);

                    if (index === -1) {
                        removedPages.push(value);
                    } else {
                        removedPages.splice(index, 1);
                    }
                    document.getElementById('removedPages').value = removedPages.join(',');
                    // console.log(document.getElementById('removedPages').value);
                } else {
                    checkbox.checked = false;
                }
            });
        } else {
            var value = checkbox.value;
            var index = removedPages.indexOf(value);

            if (index === -1) {
                removedPages.push(value);
            } else {
                removedPages.splice(index, 1);
            }
            document.getElementById('removedPages').value = removedPages.join(',');
            // console.log(document.getElementById('removedPages').value);
        }

    }

    function handleCheckboxTable(checkbox) {
        if (checkbox.checked) {
            Swal.fire({
                title: 'Do you want to remove this table from report?',
                text: 'Click Yes to remove this page.',
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'Yes',
                cancelButtonText: 'No',
            }).then((result) => {
                if (result.isConfirmed) {
                    checkbox.checked = true;

                    var tableBody = checkbox.closest('tbody');
                    var tableRows = tableBody.getElementsByTagName("tr");
                    for (var i = 0; i < tableRows.length; i++) {
                        if (checkbox.checked) {
                            tableRows[i].style.display = "none";
                        } else {
                            tableRows[i].style.display = "";
                        }
                    }

                } else {
                    checkbox.checked = false;
                }
            });
        }
    }
</script>

<script>
    function checkCharCount(textarea) {
        var maxChar = 1500;

        if (textarea.value.length >= maxChar) {
            textarea.value = textarea.value.substring(0, maxChar);
            textarea.removeEventListener("input", checkCharCount);
            swal.fire("Info", "Note: Text in the 'Evidence' column not to be exceeded more than 1500 characters.", "info");
        }

        var remainingChars = maxChar - textarea.value.length;
        // console.log("Remaining characters: " + remainingChars);
    }

    function checkWordCount(textarea) {
        var maxWords = 1500;

        var words = textarea.value.trim().split(/\s+/);
        var wordCount = words.length;

        if (wordCount >= maxWords) {
            textarea.value = words.slice(0, maxWords).join(' ');
            textarea.removeEventListener("input", checkWordCount);
            swal.fire("Info", "Note: Text in the 'Evidence' column not to be exceeded more than 1500 Words.", "info");
        }

        var remainingWords = maxWords - wordCount;
        // console.log("Remaining words: " + remainingWords);
    }

    function detailsuggestion(Step, action) {

        const excludedSteps = ['Step1', 'Step2', 'Step3', 'Step6', 'Step12', 'Step13', 'Step14', 'Step15'];

        if (excludedSteps.includes(Step)) {
            console.error(`${Step} is excluded from the function.`);
            return; // Exit the function early
        }

        let stepContainer = document.querySelector(`#${Step}`);
        let activityValues = [];

        // Handle select elements and textareas
        let selectOptions = stepContainer.querySelectorAll('.observationSelect');
        Array.from(selectOptions).forEach((element) => {
            if (element.tagName == 'SELECT') {
                let selectedOption = element.querySelector('option:checked');
                if (selectedOption) {
                    activityValues.push(selectedOption.innerText);
                }
            } else if (element.tagName == 'TEXTAREA') {
                let lines = element.value.split('\n'); // Split textarea content by line breaks
                lines.forEach((line) => {
                    activityValues.push(line.trim()); // Trim whitespace from each line and push it to activityValues
                });
            }
        });

        let activityValuesString = activityValues.join('-');
        document.getElementById("copyText").innerText = activityValuesString;
        $('#xlModal').modal('show');
    }
</script>
@include('assessmentreport.add_activity')
<!-- Modal for Recommendation -->
<div class="modal fade" id="recommendationModal" tabindex="-1" role="dialog" aria-labelledby="recommendationModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="fa fa-edit"></i> Compose Recommendation</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="closeRecommendationModal()">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <textarea id="modalRecommendationInput" class="form-control tinymce-textarea" rows="10" maxlength="1500" style="resize: vertical;"></textarea>
                
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" onclick="closeRecommendationModal()">Cancel</button>
                <button type="button" class="btn btn-primary" onclick="saveRecommendation()">Save</button>
            </div>
        </div>
    </div>
</div>
<script>
    let activeRecommendationTextarea = null;

    document.addEventListener('click', function(e) {
        if (e.target && e.target.matches('textarea[name^="recommendation["]')) {
            activeRecommendationTextarea = e.target;
            const currentText = activeRecommendationTextarea.value;
            console.log('asd', currentText);
            // document.getElementById('modalRecommendationInput').value = currentText;
            // updateCharCount();
            tinyMCE.get('modalRecommendationInput').setContent(currentText);
            $('#recommendationModal').modal('show');
        }
        $(document).off('focusin.bs.modal');
    });

    function saveRecommendation() {
        // const modalText = document.getElementById('modalRecommendationInput').value;
        const modalText = tinyMCE.get('modalRecommendationInput').getContent();
        if (activeRecommendationTextarea) {
            activeRecommendationTextarea.value = modalText;
        }
        $('#recommendationModal').modal('hide');
    }

    function closeRecommendationModal() {
        $('#recommendationModal').modal('hide');
    }

    document.getElementById('modalRecommendationInput').addEventListener('input', updateCharCount);

    function updateCharCount() {
        const val = document.getElementById('modalRecommendationInput').value;
        document.getElementById('charCount').textContent = `${val.length} / 1500 characters`;
    }
</script>
@endsection