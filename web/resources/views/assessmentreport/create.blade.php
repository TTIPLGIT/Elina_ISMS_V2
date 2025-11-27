@extends('layouts.adminnav')

@section('content')
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />
<style>
    .tab {
        overflow: hidden;
        /* border: 1px solid #f37020; */
        background-color: #d4d0cf;
        border-radius: 36px;
        /* justify-content: center; */
        width: 20000px;
        margin: auto;
        text-align: center;
        /* margin-bottom: 10px; */
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
</style>

<style>
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
</style>

<style>
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
</style>
<style>
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
<style>
    .popup {
        display: none;
        position: fixed;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        width: 50%;
        height: 400px;
        background-color: #ffffff;
        border: 1px solid #ccc;
        box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.5);
        z-index: 9999;
        overflow: hidden;
    }

    .popup-header {
        background-color: #f0f0f0;
        padding: 5px;
        cursor: move;
    }

    .popup-body {
        /* padding: 20px; */
        height: 100%;
        overflow-y: scroll;
        width: 100%;
    }

    .popup-header-btns {
        float: right;
    }

    .resize-handle {
        position: absolute;
        width: 10px;
        height: 10px;
        background-color: #333;
        cursor: nwse-resize;
    }

    .resize-handle-bottom-right {
        bottom: 0;
        right: 0;
    }
</style>
<div class="main-content">


    <!-- <script type="text/javascript">
        
        window.onload = function() { 
            alert('onload');
        };
        $(document).ready(function() {
            alert('doc');
        });
    </script> -->


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
            <div id="popup" class="popup">
                <div class="popup-header" id="header">
                    Activity Observation Notes
                    <div class="popup-header-btns">
                        <button onclick="minimize()">-</button>
                        <button onclick="maximize()">□</button>
                        <button onclick="closePopup()">x</button>
                    </div>
                </div>
                <div class="popup-body" style="display: none;">
                    <select id="firstSelect" onchange="activityFilter()">
                        <option value="all">Activity Set</option>
                        <option value="activity1">Activity 1</option>
                        <option value="activity2">Activity 2</option>
                        <option value="activity3">Activity 3</option>
                    </select>

                    <select id="secondSelect">
                        <option value="all">Activity Description</option>
                        <option value="1" data-activity-set="activity1">Write A to Z</option>
                        <option value="2" data-activity-set="activity1">Read A to Z</option>
                        <option value="3" data-activity-set="activity2">Count 1 to 10</option>
                    </select>
                </div>
                <div class="popup-body">
                    <div class="table-responsive">
                        <table class="table table-bordered card-body">
                            <thead>
                                <tr>
                                    <th>Activity Set</th>
                                    <th>Activity Description</th>
                                    <th>Observation</th>
                                </tr>
                            </thead>
                            <tbody id="activity-table">

                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="resize-handle" id="resize-handle"></div>
            </div>
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
                            <button class="swiper-slide tablinks" id="Tab{{$page['page']}}" onclick="openCity('{{$page['page']}}');detailsuggestion('Step{{$page['page']}}','create')">{{$page['tab_name']}}<input type="checkbox" name="switch[]" value="{{$page['page']}}" class="check" onclick="handleCheckboxChange(this)"></button>
                            @else
                            <button class="swiper-slide tablinks" id="Tab{{$page['page']}}" onclick="openCity('{{$page['page']}}')">PAGE - {{$page['page']}}<input type="checkbox" name="switch[]" value="{{$page['page']}}" class="check" onclick="handleCheckboxChange(this)"></button>
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
                        <div id="card content">
                            <div id="Step{{$page['page']}}" class="card-body tabcontent paginationTab{{$page['page']}}">
                                @if($page['page'] != '14')
                                <textarea class="meeting_description" page-order="{{$page['page']}}" id="meeting_description{{$loop->iteration}}" name="meeting_description[{{$page['page']}}]">
                                {{$page['page_description']}}
                                </textarea>
                                @else
                                <textarea style="display: none;" class="meeting_description" page-order="{{$page['page']}}" id="meeting_description{{$loop->iteration}}" name="meeting_description[{{$page['page']}}]"></textarea>
                                @endif
                                @if($page['assesment_skill_id'] != null)
                                @foreach($perskill as $perskills)
                                @if($perskills['performance_area_id'] == $page['assesment_skill_id'] && $perskills['skill_type'] == 1)
                                <div style="font-weight:bold;font-style: italic;font-size: 15px;display: flex;align-items: center;">
                                    <p style="color:red">* </p> &nbsp; Note: Text in the 'Evidence' column not to be exceeded more than 1500 characters.
                                </div>
                                <div style="font-weight:bold;font-style: italic;font-size: 15px;display: flex;align-items: center;">
                                    <p style="color:red">* </p> &nbsp; Note: To pause pulling the evidence data to the corresponding executive field when you check the checkbox.

                                </div>
                                <div class="row">
                                    <div class="col-md-12" style="text-align: center;">
                                        <input type="checkbox" name="switch_radio" value="" class="switch_radio">
                                    </div>
                                </div>
                                <div id="table{{$page['page']}}">
                                    <div class="table-responsive">
                                        <table class="table table-bordered card-body">
                                            <thead>
                                                <tr>
                                                    @if($perskills['skill_name'] != null || $perskills['skill_name'] != '')
                                                    <th width="30%">{{$perskills['skill_name']}}</th>
                                                    @else
                                                    <th width="30%">{{$page['tab_name']}}</th>
                                                    @endif
                                                    <th width="30%">Observation</th>
                                                    <th class="required" width="40%">Evidence
                                                        <!-- <input type="checkbox" style="float:right" name="switch[]" value="{{$page['page']}}" class="check" > -->
                                                    </th>
                                                </tr>
                                            </thead>
                                            <tbody id="tablebody{{$page['page']}}">
                                                @foreach($activitys as $activity)
                                                @if($page['assesment_skill_id'] == $activity['performance_area_id'] && $activity['skill_type'] == 1 && $activity['skill_id'] == $perskills['skill_id'])
                                                <tr class="firstrow">
                                                    <td width="30%">
                                                        <select class="form-control default observationSelect activitySelect my-select activity{{$page['page']}}" id="activity{{$page['page']}}" name="activity[{{$page['assesment_skill_id']}}][]">
                                                            <option value="{{$activity['activity_id']}}" selected>{{$activity['activity_name']}}</option>
                                                        </select>
                                                    </td>
                                                    <td width="30%">
                                                        <select class="form-control default observationSelect" name="observation[{{$page['assesment_skill_id']}}][]">
                                                            @foreach($observations as $observation)
                                                            <option value="{{$observation['observation_id']}}">{{$observation['observation_name']}}</option>
                                                            @endforeach
                                                        </select>
                                                    </td>
                                                    <td style="display: flex;align-items: center;height: fit-content;">
                                                        <textarea style="width: 100% !important;" class="observationSelect" id="evidence{{$activity['activity_id']}}" oninput="checkCharCount(this)" name="evidence[{{$page['assesment_skill_id']}}][]"></textarea>
                                                        <a class="btn remove" order="{{$page['page']}}" title="Remove" id="removeProduct"><i class="fa fa-times" order="{{$page['page']}}"></i></a>
                                                    </td>
                                                </tr>
                                                @endif
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                @elseif($perskills['performance_area_id'] == $page['assesment_skill_id'] && $perskills['skill_type'] == 2)
                                <div class="table-responsive" id="table_a{{$page['page']}}">
                                    <table class="table table-bordered card-body">
                                        <thead>
                                            <tr>
                                                <th colspan="3" style="background-color: white !important;color: #141414;text-align: left;border: 1px solid #040404 !important;">{{$perskills['skill_name']}}<input type="checkbox" style="float:right" name="switch[]" onclick="handleCheckboxTable(this)" value="{{$perskills['skill_id']}}" class="check"></th>
                                            </tr>
                                        </thead>
                                        <tbody id="tablebody_a{{$page['page']}}">
                                            @foreach($activitys as $activity)
                                            @if($page['assesment_skill_id'] == $activity['performance_area_id'] && $activity['skill_type'] == 2 && $activity['skill_id'] == $perskills['skill_id'])
                                            <tr class="firstrow">
                                                <td width="30%">
                                                    <select class="form-control default observationSelect activitySelect activity_a{{$page['page']}}" name="activity[{{$page['assesment_skill_id']}}][]">
                                                        <option value="{{$activity['activity_id']}}" selected>{{$activity['activity_name']}}</option>
                                                    </select>
                                                </td>
                                                <td width="30%">
                                                    <select class="form-control default observationSelect" name="observation[{{$page['assesment_skill_id']}}][]">
                                                        @foreach($observations as $observation)
                                                        <option value="{{$observation['observation_id']}}">{{$observation['observation_name']}}</option>
                                                        @endforeach
                                                    </select>
                                                </td>
                                                <td style="display: flex;align-items: center;height: fit-content;">
                                                    <textarea style="width: 100% !important;" class="observationSelect" id="evidence{{$activity['activity_id']}}" oninput="checkCharCount(this)" name="evidence[{{$page['assesment_skill_id']}}][]"></textarea>
                                                    <a class="btn remove_a" order="{{$page['page']}}" title="Add" id="removeProduct"><i class="fa fa-times" order="{{$page['page']}}"></i></a>
                                                </td>
                                            </tr>
                                            @endif
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                @elseif($perskills['performance_area_id'] == $page['assesment_skill_id'] && $perskills['skill_type'] == 3)
                                <!--  -->
                                <div style="font-weight:bold;font-style: italic;font-size: 15px;display: flex;align-items: center;">
                                    <p style="color:red">* </p> &nbsp; Note: Text in the 'Evidence' column not to be exceeded more than 1500 characters.
                                </div>
                                <div style="font-weight:bold;font-style: italic;font-size: 15px;display: flex;align-items: center;">
                                    <p style="color:red">* </p> &nbsp; Note: To pause pulling the evidence data to the corresponding executive field when you check the checkbox.

                                </div>
                                <div class="row">
                                    <div class="col-md-12" style="text-align: center;">
                                        <input type="checkbox" name="switch_radio" value="" class="switch_radio">
                                    </div>
                                </div>
                                <div id="table{{$page['page']}}">
                                    <div class="table-responsive">
                                        <table class="table table-bordered card-body">
                                            <thead>
                                                <tr>
                                                    @if($perskills['skill_name'] != null || $perskills['skill_name'] != '')
                                                    <th width="30%">{{$perskills['skill_name']}}</th>
                                                    @else
                                                    <th width="30%">{{$page['tab_name']}}</th>
                                                    @endif
                                                    <th width="30%">Observation</th>
                                                    <th class="required" width="40%">Evidence<input type="checkbox" style="float:right" onclick="handleCheckboxTable(this)" name="switch[]" value="{{$perskills['skill_id']}}" class="check"></th>
                                                </tr>
                                            </thead>
                                        </table>
                                    </div>
                                </div>
                                @foreach($subskill as $sskill)
                                @if($page['assesment_skill_id'] == $sskill['performance_area_id'] && $sskill['primary_skill_id'] == $perskills['skill_id'])
                                <div class="table-responsive" id="table_b{{$sskill['skill_id']}}">
                                    <table class="table table-bordered card-body">
                                        <thead>
                                            <tr>
                                                <th colspan="3" style="background-color: white !important;color: #141414;text-align: left;border: 1px solid #040404 !important;">{{$sskill['skill_name']}}<input type="checkbox" style="float:right" onclick="handleCheckboxTable(this)" name="switch2[]" value="{{$sskill['skill_id']}}" class="check"></th>
                                            </tr>
                                        </thead>
                                        <tbody id="tablebody_b{{$sskill['skill_id']}}">
                                            @foreach($activitys as $activity)
                                            @if($sskill['skill_id'] == $activity['sub_skill'])
                                            <tr class="firstrow">
                                                <td width="30%">
                                                    <select class="form-control default observationSelect activitySelect activity_c{{$sskill['skill_id']}}" name="activity[{{$page['assesment_skill_id']}}][]">
                                                        <option value="{{$activity['activity_id']}}" selected>{{$activity['activity_name']}}</option>
                                                    </select>
                                                </td>
                                                <td width="30%">
                                                    <select class="form-control default observationSelect" name="observation[{{$page['assesment_skill_id']}}][]">
                                                        @foreach($observations as $observation)
                                                        <option value="{{$observation['observation_id']}}">{{$observation['observation_name']}}</option>
                                                        @endforeach
                                                    </select>
                                                </td>
                                                <td style="display: flex;align-items: center;height: fit-content;">
                                                    <textarea style="width: 100% !important;" class="observationSelect" id="evidence{{$activity['activity_id']}}" oninput="checkCharCount(this)" name="evidence[{{$page['assesment_skill_id']}}][]"></textarea>
                                                    <a class="btn remove_b" order="{{$page['page']}}" table="{{$sskill['skill_id']}}" title="Add" id="removeProduct"><i class="fa fa-times" order="{{$page['page']}}" table="{{$sskill['skill_id']}}"></i></a>
                                                </td>
                                            </tr>
                                            @endif
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                @endif
                                @endforeach
                                <!--  -->
                                @endif
                                @endforeach
                                @endif
                            </div>
                        </div>
                    </div>

                    @endforeach
                    <div class="col-12 scrollable fixTableHead title-padding" style="display: none;" id="page8">
                        <div class="table-responsive">
                            <table class="table table-bordered card-body" id="main">
                                <thead>
                                    <tr>
                                        <th width="50%" style="border: 1px solid #040404 !important;color: #141414;background-color: white !important;">Seeking/Seeker
                                            <br>
                                            <p style="line-height: initial;font-weight: lighter;">Seeks out and is attracted to a stimulating sensory environment</p>
                                        </th>
                                        <th width="50%" style="border: 1px solid #040404 !important;color: #141414;background-color: white !important;">Avoiding/Avoider
                                            <p style="line-height: initial;font-weight: lighter;">Distressed by a stimulating sensory environment and attempts to leave the environment</p>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr id="row">
                                        <td style="background: white;border: 1px solid #0e0e0e !important;vertical-align: initial !important;">
                                            <textarea style="width: 100%;height:150px;" class="tinymce-textarea" id="" name="rows2[1]"></textarea>
                                        </td>
                                        <td style="background: white;border: 1px solid #0e0e0e !important;vertical-align: initial !important;">
                                            <textarea style="width: 100%;height:150px;" class="tinymce-textarea" id="" name="rows2[2]"></textarea>
                                        </td>
                                    </tr>
                                </tbody>
                                <thead>
                                    <tr>
                                        <th width="50%" style="border: 1px solid #040404 !important;color: #141414;background-color: white !important;">Sensitivity/Sensor
                                            <br>
                                            <p style="line-height: initial;font-weight: lighter;">Distractibility, discomfort with sensory stimuli</p>
                                        </th>
                                        <th width="50%" style="border: 1px solid #040404 !important;color: #141414;background-color: white !important;">Registration/Bystander
                                            <p style="line-height: initial;font-weight: lighter;">Missing stimuli, responding slowly</p>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr id="row">
                                        <td style="background: white;border: 1px solid #0e0e0e !important;vertical-align: initial !important;">
                                            <textarea style="width: 100%;height:150px;" class="tinymce-textarea" id="" name="rows2[3]"></textarea>
                                        </td>
                                        <td style="background: white;border: 1px solid #0e0e0e !important;vertical-align: initial !important;">
                                            <textarea style="width: 100%;height:150px;" class="tinymce-textarea" id="" name="rows2[4]"></textarea>
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
        $('#firstSelect').select2();
        $('#secondSelect').select2();
    });
</script>
<script>
    // $(document).ready(function() {
    //     $('.activitySelect').on('change', function(event) {
    //         var prevValue = $(this).data('previous');
    //         $('.activitySelect').not(this).find('option[value="' + prevValue + '"]').show();
    //         var value = $(this).val();
    //         $(this).data('previous', value);
    //         $('.activitySelect').not(this).find('option[value="' + value + '"]').hide();
    //     });
    // });

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
    // Function to update switch_radio_values based on checkbox status
    function updateSwitchRadioValues() {
        var pages = <?php echo json_encode($pages); ?>;
        let stepsToProcess = ['Step4', 'Step5', 'Step7', 'Step8', 'Step9', 'Step10', 'Step11']; // List of steps to process

        for (var i = 0; i < pages.length; i++) {
            var page = pages[i];
            var pageId = "Step" + page.page;

            if (stepsToProcess.includes(pageId)) {
                var switch_radio = document.getElementById(pageId)?.querySelector('.switch_radio');
                if (switch_radio) {
                    switch_radio_values[page.page] = switch_radio.checked ? 1 : 0;
                } else {
                    console.error("Element with class 'switch_radio' not found in page:", pageId);
                }
            }
            document.getElementById('switch_radio_values').value = JSON.stringify(switch_radio_values);

        }
    }
    document.querySelectorAll('.switch_radio').forEach(function(checkbox) {
        checkbox.addEventListener('change', function() {
            updateSwitchRadioValues();
        });
    });
    updateSwitchRadioValues();
    // Event listener for checkbox change
    document.querySelectorAll('.switch_radio').forEach(function(checkbox) {
        checkbox.addEventListener('change', function() {
            updateSwitchRadioValues();
        });
    });

    // Initial update of switch_radio_values
    // Initial update of switch_radio_values
    updateSwitchRadioValues();

    function save(a) {
        if (document.getElementById('enrollment_child_num').value == "") {
            swal.fire("Please Select Enrolment Number", "", "error");
            return false;
        }
        var tabIDs = $('.tablinks.swiper-slide-active').attr('id');
        var ret1 = tabIDs.replace('Tab', '');
        document.getElementById('state').value = a;
        document.getElementById('currentPage').value = ret1;
        updateSwitchRadioValues();
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
            plugins: 'importcss',
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
                        console.log(k);
                        if (k != 14) {
                            var content = tinymce.get('meeting_description' + k).getContent();
                            content = content.replace(/ChildName/g, data[0].child_name);
                            content = content.replace(/He/g, gender);
                            content = content.replace(/She/g, gender);
                            tinymce.get('meeting_description' + k).setContent(content);
                        }
                    }
                    // 
                    $.ajax({
                        url: "{{ url('/sensory/enrollmentlist') }}",
                        type: 'POST',
                        data: {
                            'enrollment_child_num': enrollment_child_num,
                            _token: '{{csrf_token()}}'
                        }
                    }).done(function(data) {
                        // console.log(data);
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
                        for (si = 0; si < sign.length; si++) {
                            var sii = si + 1;
                            var sign_content = sign[si].additional_details;
                            tinymce.get('signature_' + sii).setContent(sign_content);
                            // $("#signature_" + sii).val(sign[si].additional_details);
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
                            body_content += "<tr data-activity=" + activityID + ">";
                            body_content += "<td>" + activity + "</td> ";
                            body_content += "<td>" + description + "</td>";
                            body_content += "<td>" + observationcomments + "</td>";
                            body_content += "</tr>";
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
            let stepsToProcess = ['Step4', 'Step5', 'Step7', 'Step8', 'Step9', 'Step10', 'Step11']; // List of steps to process

            document.addEventListener("DOMContentLoaded", function() {
                stepsToProcess.forEach((step, index) => {
                    setTimeout(function() {
                        detailsuggestion(step, "create");
                    }, index * 100); // Delay each execution by index * 100 milliseconds
                })
            });
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
        detailsuggestion("Step" + (step), "create");

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

<!-- <script>
    var textareas = document.getElementsByTagName('textarea');

    for (var i = 0; i < textareas.length; i++) {
        textareas[i].addEventListener('keydown', function(e) {
            if (e.key === 'Enter') {
                e.preventDefault();
                var startPos = this.selectionStart;
                var endPos = this.selectionEnd;
                this.value = this.value.substring(0, startPos) + '\n\r' + this.value.substring(endPos, this.value.length);
                this.selectionStart = startPos + 2;
                this.selectionEnd = startPos + 2;
            }
        });
    }
</script> -->
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
</script>

<!-- Floating Window -->
<script>
    // Open the popup window
    function openPopup() {
        document.getElementById('popup').style.display = 'block';
    }

    // Minimize the popup
    function minimize() {
        document.getElementById('popup').style.display = 'none';
    }

    // Maximize the popup
    function maximize() {
        const popup = document.getElementById('popup');
        if (popup.style.width === '100%' && popup.style.height === '100%') {
            popup.style.width = '400px';
            popup.style.height = '200px';
            popup.style.left = '50%';
            popup.style.top = '50%';
            popup.style.transform = 'translate(-50%, -50%)';
        } else {
            popup.style.width = '100%';
            popup.style.height = '100%';
            popup.style.left = '0';
            popup.style.top = '0';
            popup.style.transform = 'none';
        }
    }

    // Close the popup
    function closePopup() {
        document.getElementById('popup').style.display = 'none';
    }

    // Make the popup draggable
    const header = document.getElementById('header');
    let isDragging = false;
    let offsetX, offsetY;

    header.addEventListener('mousedown', startDragging);
    header.addEventListener('mouseup', stopDragging);
    document.addEventListener('mousemove', drag);

    function startDragging(e) {
        isDragging = true;
        offsetX = e.clientX - document.getElementById('popup').offsetLeft;
        offsetY = e.clientY - document.getElementById('popup').offsetTop;
    }

    function stopDragging() {
        isDragging = false;
    }

    function drag(e) {
        if (isDragging) {
            document.getElementById('popup').style.left = e.clientX - offsetX + 'px';
            document.getElementById('popup').style.top = e.clientY - offsetY + 'px';
        }
    }

    // Resize the popup
    const resizeHandle = document.getElementById('resize-handle');
    let isResizing = false;
    let prevX, prevY;

    resizeHandle.addEventListener('mousedown', startResizing);
    document.addEventListener('mouseup', stopResizing);
    document.addEventListener('mousemove', resize);

    function startResizing(e) {
        isResizing = true;
        prevX = e.clientX;
        prevY = e.clientY;
    }

    function stopResizing() {
        isResizing = false;
    }

    function resize(e) {
        if (isResizing) {
            const popup = document.getElementById('popup');
            const headerHeight = document.getElementById('header').offsetHeight;
            const width = parseInt(getComputedStyle(popup, null).getPropertyValue('width'));
            const height = parseInt(getComputedStyle(popup, null).getPropertyValue('height'));

            // Limit resizing to the header's height
            const newWidth = width + e.clientX - prevX;
            const newHeight = height + e.clientY - prevY;
            if (newHeight >= headerHeight) {
                popup.style.width = newWidth + 'px';
                popup.style.height = newHeight + 'px';
            }

            prevX = e.clientX;
            prevY = e.clientY;
        }
    }

    function detailsuggestion(Step, action) {
        // List of excluded steps
        const excludedSteps = ['Step1', 'Step2', 'Step3', 'Step6', 'Step12', 'Step13', 'Step14', 'Step15'];

        // Check if the Step parameter is in the excludedSteps list
        if (excludedSteps.includes(Step)) {
            console.log(`${Step} is excluded from the function.`);
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

        // Append activityValuesString to the corresponding meeting_description input of the current step
        let appendingInput = stepContainer.querySelector('.meeting_description');
        if (appendingInput) {
            appendingInput.value = activityValuesString;
        }
    }

    let stepsToProcess = ['Step4', 'Step5', 'Step7', 'Step8', 'Step9', 'Step10', 'Step11']; // List of steps to process

    stepsToProcess.forEach((step, index) => {

        detailsuggestion(step, 'create'); // Specify action as create
        // Delay each execution by index * 100 milliseconds
    });
</script>
<script>
    // function activityFilter() {
    //     var activities = $('#firstSelect').val();
    //     var rows = document.querySelectorAll('tr[data-activity]');
    //     rows.forEach(function(row) {
    //         var shouldDisplay = activities.includes("all");
    //         if (!shouldDisplay) {
    //             activities.forEach(function(activity) {
    //                 if (row.getAttribute('data-activity') === activity) {
    //                     shouldDisplay = true;
    //                 }
    //             });
    //         }
    //         row.style.display = shouldDisplay ? "" : "none";
    //     });
    //     // 
    //     var selectedActivities = $("#firstSelect").val();
    //     $("#secondSelect option").each(function() {
    //         var $option = $(this);
    //         var dataActivitySet = $option.data('activity-set');
    //         var shouldShow = selectedActivities.includes("all") || selectedActivities.includes(dataActivitySet);
    //         if (!shouldShow) {
    //             $option.remove();
    //         }
    //     });
    //     $("#secondSelect").trigger("change");
    //     // 
    // }
</script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll('.switch_radio').forEach(function(element) {
            element.addEventListener('change', function() {
                var isChecked = this.checked;
                var message = isChecked ? 'Are you sure you want to pause pulling the evidence data to the corresponding executive field?' : 'Are you sure you want to pause pulling the evidence data to the corresponding executive field?';

                Swal.fire({
                    title: 'Confirmation',
                    text: message,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes'
                }).then((result) => {
                    if (result.isConfirmed) {
                        var reports_id = document.getElementById('reports_id').value;
                        // Find the parent tab of the current switch_radio
                        var activeTab = document.querySelector('.swiper-slide.tablinks.swiper-slide-active');

                        // Extract the step id from the parent tab's id attribute
                        var step_id = activeTab.id.replace('Tab', '');

                        console.log(step_id); // This will log the step id of the active tab

                        $.ajax({
                            url: '/meeting_description_ass/update',
                            type: 'POST',
                            data: {
                                'step': step_id,
                                'reports_id': reports_id,
                                'checking': isChecked ? 1 : 0, // Send 1 if checked, 0 if unchecked
                                _token: '{{csrf_token()}}'
                            },
                            success: function(response) {
                                console.log(response);
                                // location.reload();
                                //alert('Flag updated successfully!');
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Successfully Done',
                                    showConfirmButton: true,
                                   
                                });
                            },
                            error: function(xhr, status, error) {
                                console.error(xhr.responseText);
                            }
                        });
                    } else {
                        // Reset the checkbox state if user clicks 'Cancel' in the confirmation dialog
                        this.checked = !isChecked;
                    }
                });
            });
        });

    });
</script>
@endsection