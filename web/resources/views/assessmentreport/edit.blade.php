@extends('layouts.adminnav')

@section('content')
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

    .addR {
        display: none;
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

    .checkRemovePages {
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

    .checkRemovePages:checked:before {
        content: "✖";
        color: red;
        margin: 16px 0 15px 0 !important;
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

    .exclamation-btn {
        position: absolute;
        top: -17px;
        margin-left: -27px;
        color: red;
        background: transparent !important;
    }

    .picture-in-picture {
        position: fixed;
        bottom: 20px;
        right: 20px;
        width: 200px;
        /* Initial width */
        height: 150px;
        /* Initial height */
        background-color: #fff;
        border: 1px solid #ccc;
        border-radius: 8px;
        overflow: hidden;
        transition: width 0.3s, height 0.3s;
    }

    .picture-in-picture i {
        display: flex;
        position: absolute;
        top: 90px;
        right: 83px;
        font-size: 25px;
        color: red !important;
        z-index: 9999999;
        cursor: pointer;
        justify-content: center;
        align-items: center;
        transform: translate(-50%, -50%);
        transition: color 0.3s ease;
    }

    .picture-in-picture i::after {

        /* Tooltip text */
        position: absolute;
        top: calc(100% + 5px);
        /* Position tooltip below the icon */
        left: 50%;
        transform: translateX(-50%);
        display: none;

        /* padding: 5px; */
        border-radius: 5px;
        font-size: 14px;

    }

    .picture-in-picture i:hover::after {
        display: block;
        /* Show tooltip on hover */
    }

    .picture-in-picture i:hover {
        color: blue;
        /* Change color on hover */
    }

    .pdf-container {
        width: 100%;
        height: 100%;
        overflow: hidden !important;
        cursor: pointer;
    }

    .pdf-container iframe {
        width: 108%;
        height: 100%;
        border: none;
        overflow-x: auto;
        overflow: hidden !important;
        scrollbar-width: none;
    }

    .pdf-container iframe::-webkit-scrollbar {
        display: none !important;
        /* Hide scrollbar on Chrome, Safari, and Opera */
    }

    .pdf-container::-webkit-scrollbar {
        display: none !important;
        /* Hide scrollbar on Chrome, Safari, and Opera */
    }


    .picture-in-picture.maximized {
        width: 90vw;
        /* Maximized width */
        height: 80vh;
        /* Maximized height */
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        z-index: 1000;
    }

    .reportheading {
        display: flex;
        justify-content: space-around;
        align-items: baseline;
        flex-direction: row;
        background-color: navy !important;
        color: white !important;
    }

    .conversation {
        position: fixed;
        display: block;
        bottom: 20px;
        right: 20px;
        display: contents;
        z-index: 999;
        transition: width 0.3s, height 0.3s;

    }

    .conversation .card-header {
        background: navy !important;
        border-radius: 8px !important;
        overflow: hidden !important;
        color: white !important;
        cursor: move !important;
        display: flex;
        justify-content: space-between;
        border-top-left-radius: 3px !important;
        border-top-right-radius: 3px !important;
        user-select: none;
        /* transition: width 0.3s, height 0.3s; */
    }

    .icons_chip {
        display: flex;
        gap: 4px;
    }


    .conversation .card-header.has-new-messages {
        background: #53a93f;
    }

    .conversation .card-header>* {
        display: table-cell;
        vertical-align: middle;
    }


    .conversation .card-header .chating-with {

        font-weight: 400;

    }

    .conversation .card-header button {
        border-radius: 3px;
        border: none;
        cursor: inherit;
    }

    .conversation .card-header button:hover,
    .conversation .card-header button:active {
        /* opacity: 1; */
        background-color: white !important;
    }



    .conversation .card-header aside {
        visibility: hidden;
        /* toggled by JavaScript */
        background: white;
        /* width: 10rem; */
        padding: 0.5rem 1rem 1rem;
        position: absolute;
        top: calc(3rem - 1px);
        border: none;
        right: 0;
    }

    .conversation.chipview {
        overflow: hidden !important;
        transition: height 0.3s;
        width: 100% !important;
        height: 0px !important;
    }

    .conversation .card-header aside.visible {
        visibility: visible;
    }

    #pdfviewnote {
        /* width: 600px !important;
        height: 300px !important; */
        width: 100vh !important;
        height: 50vh;
        overflow-x: scroll !important;
        overflow-y: scroll !important;
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

    #toaster.show {
        visibility: visible;
        opacity: 1;
    }
</style>

@if($page != " ")
<input type="hidden" name="session_data" id="session_data" class="session_data" value="{{ $page }}">
<script type="text/javascript">
    window.onload = function() {

        var openpage = "<?php echo $page ?>";

        if (openpage != '' || openpage != null) {

            stepClick(openpage);
        }
        // Swal.fire("Success", 'The  Assessment Report  saved successfully.', "success");
        Swal.fire({
            title: 'Success',
            text: "The  Assessment Report  saved successfully",
            icon: 'success',
            showCancelButton: false,
            confirmButtonText: 'Okay!',
        }).then((result) => {
            if (result.isConfirmed) {
                localStorage.setItem('reportPreviewGenerate', 'false');
                const url = `${window.location.origin}/assessment-report-save/${id}`;
                const features = 'width=1,height=1,left=9999,top=9999,noopener,noreferrer';
                const newWindow = window.open(url, '_blank', features);

                if (newWindow) {
                    newWindow.blur();
                    window.focus();
                }
            }
        });

    }
</script>
@else
<input type="hidden" name="session_data" id="session_data" class="session_data" value="{{ $currentPage }}">
<script type="text/javascript">
    window.onload = function() {
        var openpage = "<?php echo $currentPage ?>";
        if (openpage != '' || openpage != null) {
            // console.log(openpage);
            stepClick(openpage);
            reportPreviewGenrate();
        }
    }
</script>
@endif
<div class="main-content">

    {{ Breadcrumbs::render('assessmentreport.edit', $report['enrollment_child_num'] ) }}

    <!-- Main Content -->
    <section class="section">


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
                                        <input class="form-control readonly" type="text" id="child_id" name="child_id" placeholder="Child ID" value="{{$report['enrollment_child_num']}}" autocomplete="off" readonly>
                                        <input type="hidden" id="enrollment_id" name="enrollment_id" autocomplete="off" readonly>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="control-label">Child ID</label>
                                        <input class="form-control readonly" type="text" id="child_id" name="child_id" placeholder="Child ID" value="{{$report['child_id']}}" autocomplete="off" readonly>
                                        <input type="hidden" id="enrollment_id" name="enrollment_id" autocomplete="off" readonly>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="control-label">Child Name</label>
                                        <input class="form-control readonly" type="text" id="child_name" name="child_name" value="{{$report['child_name']}}" oninput="Childname(event)" maxlength="20" value="" placeholder="Enter Name" autocomplete="off" readonly>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="control-label">Date of Reporting</label>
                                        @if($report['dor'] == '')
                                        <input class="form-control default" type="date" onchange="document.getElementById('dor').value = this.value" value="<?php echo date('Y-m-d'); ?>">
                                        @else
                                        <input class="form-control default" type="date" onchange="document.getElementById('dor').value = this.value" value="{{$report['dor']}}">
                                        @endif
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

                @include('assessmentreport.observation_modal')
                <div class="row" id="r1">
                    <div class="col-md-12 col-lg-12 mlr-auto" style="padding-top: 20px;">

                        <div class="md-stepper-horizontal" style="margin-bottom: 20px;">
                            @foreach($pages as $page)
                            <div class="md-step" onclick="stepClick('{{$page['page']}}')" id="stepper{{$page['page']}}">
                                <div class="md-step-circle"><span>{{$page['page']}}</span></div>
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
                                <button class="swiper-slide tablinks" id="Tab{{$page['page']}}" onclick="openCity('{{$page['page']}}');detailsuggestion('Step{{$page['page']}}','edit')">
                                    {{ $page['tab_name'] != '' ? $page['tab_name'] : 'PAGE - ' . $page['page'] }}
                                    <input type="checkbox" name="switch" value="{{$page['page']}}" class="checkRemovePages" onclick="handleCheckboxChange(this)" @if($page['enable_flag']=='1' ) checked @endif>
                                </button>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <div id="r2">

                <form name="edit_form" action="{{ route('report.update')}}" method="POST" id="form_report">
                    {{ csrf_field() }}
                    <input type="hidden" id="state" name="state">
                    <input type="hidden" value="{{$report['enrollment_id']}}" id="enrollmentId" name="enrollmentId">
                    <input type="hidden" value="{{$report['report_id']}}" name="reports_id" id="reports_id">
                    <input type="hidden" id="currentPage" name="currentPage">
                    <input type="hidden" id="removedPages" name="removedPages">
                    <input type="hidden" id="Page" name="Page">
                    <input type="hidden" id="switch_radio_values" name="switch_radio_values">

                    @if($report['dor'] == '')
                    <input type="hidden" id="dor" name="dor" value="<?php echo date('Y-m-d'); ?>">
                    @else
                    <input type="hidden" id="dor" name="dor" value="{{$report['dor']}}">
                    @endif
                    <div class="row" style="    margin: 25px 0px 0px 0px;">
                        @foreach($pages as $page)
                        <div class="col-12">
                            <div id="card content">
                                <div id="Step{{$page['page']}}" class="card-body tabcontent paginationTab{{$page['page']}}">
                                    @if($page['page'] != '14')
                                    <textarea class="meeting_description" id="meeting_description{{$loop->iteration}}" name="meeting_description[{{$page['page']}}]">
                                    {{$page['page_description']}}
                                    </textarea>
                                    <p class="appending_input"></p>
                                    @else
                                    <textarea style="display: none;" class="meeting_description" id="meeting_description{{$loop->iteration}}" name="meeting_description[{{$page['page']}}]"></textarea>
                                    @endif
                                    @if($page['assessment_skill'] != null)
                                    @foreach($perskill as $perskills)
                                    @if($perskills['performance_area_id'] == $page['assessment_skill'] && $perskills['skill_type'] == 1)

                                    @include('assessmentreport.skills_edit.skill_1')

                                    @elseif($perskills['performance_area_id'] == $page['assessment_skill'] && $perskills['skill_type'] == 2)
                                    @include('assessmentreport.skills_edit.skill_2')

                                    @elseif($perskills['performance_area_id'] == $page['assessment_skill'] && $perskills['skill_type'] == 3)

                                    @include('assessmentreport.skills_edit.skill_3')

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
                                                <textarea style="width: 100%;height:150px;" class="tinymce-textarea" id="" name="rows2[1]">{{ isset($page8['sensory_profiling1']) ? $page8['sensory_profiling1'] : '' }}</textarea>
                                            </td>
                                            <td style="background: white;border: 1px solid #0e0e0e !important;vertical-align: initial !important;">
                                                <textarea style="width: 100%;height:150px;" class="tinymce-textarea" id="" name="rec_rows2[1]">{{ isset($sensory_recommendation[1]) ? $sensory_recommendation[1] : '' }}</textarea>
                                            </td>
                                        </tr>

                                        <tr id="row">
                                            <th width="50%" style="border: 1px solid #040404 !important;color: #141414;background-color: white !important;">
                                                Distressed by a stimulating sensory environment and attempts to leave the environment
                                            </th>
                                            <td style="background: white;border: 1px solid #0e0e0e !important;vertical-align: initial !important;">
                                                <textarea style="width: 100%;height:150px;" class="tinymce-textarea" id="" name="rows2[2]">{{ $page8['sensory_profiling2'] ?? '' }}</textarea>
                                            </td>
                                            <td style="background: white;border: 1px solid #0e0e0e !important;vertical-align: initial !important;">
                                                <textarea style="width: 100%;height:150px;" class="tinymce-textarea" id="" name="rec_rows2[2]">{{ $sensory_recommendation[2] ?? '' }}</textarea>
                                            </td>
                                        </tr>

                                        <tr>
                                            <th width="50%" style="border: 1px solid #040404 !important;color: #141414;background-color: white !important;">
                                                Sensitivity to stimuli, distractibility, discomfort with sensory stimuli
                                            </th>
                                            <td style="background: white;border: 1px solid #0e0e0e !important;vertical-align: initial !important;">
                                                <textarea style="width: 100%;height:150px;" class="tinymce-textarea" id="" name="rows2[3]">{{ $page8['sensory_profiling3'] ?? '' }}</textarea>
                                            </td>
                                            <td style="background: white;border: 1px solid #0e0e0e !important;vertical-align: initial !important;">
                                                <textarea style="width: 100%;height:150px;" class="tinymce-textarea" id="" name="rec_rows2[3]">{{ $sensory_recommendation[3] ?? '' }}</textarea>
                                            </td>
                                        </tr>

                                        <tr id="row">
                                            <th width="50%" style="border: 1px solid #040404 !important;color: #141414;background-color: white !important;">
                                                Missing stimuli, responding slowly
                                            </th>
                                            <td style="background: white;border: 1px solid #0e0e0e !important;vertical-align: initial !important;">
                                                <textarea style="width: 100%;height:150px;" class="tinymce-textarea" id="" name="rows2[4]">{{ $page8['sensory_profiling4'] ?? '' }}</textarea>
                                            </td>
                                            <td style="background: white;border: 1px solid #0e0e0e !important;vertical-align: initial !important;">
                                                <textarea style="width: 100%;height:150px;" class="tinymce-textarea" id="" name="rec_rows2[4]">{{ $sensory_recommendation[4] ?? '' }}</textarea>
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
                                                <textarea class="tinymce-textarea" style="width: 100%;height:150px;" id="signature_1" name="signature[1]">{{$signature[1]}}</textarea>
                                            </td>
                                            <td style="background: white;border: 1px solid #0e0e0e !important;vertical-align: initial !important;">
                                                <textarea class="tinymce-textarea" style="width: 100%;height:150px;" id="signature_2" name="signature[2]">{{$signature[2]}}</textarea>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <!-- End 8 -->
                    </div>
                </form>
                <div class="col-md-12 text-center">
                    <a type="button" class="btn btn-labeled btn-info" onclick="PrevTab();" id="Previous" title="Previous" style="display:none;height: 35px;background: blue !important; border-color:blue !important; color:white !important">
                        <span class="btn-label" style="font-size:13px !important;"><i class="fa fa-arrow-left"></i></span> Previous</a>
                    <a type="button" onclick="save('Saved')" id="submitbutton" class="btn btn-labeled btn-succes" title="Save" style="background: green !important; border-color:green !important; color:white !important;">
                        <span class="btn-label" style="font-size:13px !important;"><i class="fa fa-check"></i></span> Save</a>
                    <a type="button" onclick="save('Submitted')" id="submitbutton" class="btn btn-labeled btn-succes" title="Submit" style="background: orange !important; color:white !important; position: relative;">
                        <span class="btn-label" style="font-size:13px !important;"><i class="fa fa-check"></i></span> Submit </a>
                    @if(!empty($observation_act))
                    <button class="btn btn-circle exclamation-btn">
                        <i class="fa fa-exclamation-circle" style="font-size: 16px !important;font-weight: 900 !important;"></i>
                    </button>
                    @endif


                    <a type="button" class="btn btn-labeled btn-info" onclick="NextTab();" id="Next" title="Next" style="background: blue !important; border-color:#4d94ff !important; color:white !important;height: 35px;">
                        <span class="btn-label" style="font-size:13px !important;">Next</span> <i class="fa fa-arrow-right"></i></a>
                </div>
                <div class="col-md-12 text-center" style="margin: 10px 0 0 0;">
                    <a type="button" class="btn btn-labeled back-btn" title="Back" href="{{ route('assessmentreport.index') }}" style="color:white !important">
                        <span class="btn-label" style="font-size:13px !important;"><i class="fa fa-arrow-left"></i></span> Back</a>
                </div>
            </div>


        </div>

        <!-- Picture-in-Picture View -->

        <div class="picture-in-picture" id="pip-preview" style="display: none;">
            <div class="row reportheading">
                <h6>Report Preview</h6>
                <a type="button" class="close_p2p" onclick="closePictureInPicture('closep2p')" style="color: white !important;font-size: 20px !important;">
                    <span class="closep2p" style="color: white !important;">&times;</span>
                </a>
            </div>

            <i class="fas fa-expand" id="maximizeIcon" onclick="togglePictureInPicture('p2p')"></i> <!-- Maximize icon -->
            <div id="pdfContainer" class="pdf-container" onclick="togglePictureInPicture('p2p')" title="Click to see the Report Preview">

                <!-- ✅ Thumbnail Text -->
                <div id="thumbnailText" class="thumbnail-text" style="margin: 10px 0; padding: 8px 12px; background-color: #f8f9fa; border-left: 4px solid #007bff; border-radius: 4px; font-size: 14px; color: #333;">
                    📄 <strong>Click to preview Assessment Report </strong>
                </div>

                <iframe id="pdfViewerPIP" src="{{ asset('/assessment_report/' . $c_report . '/Assessment_Detail_Summary_Report.pdf') }}?v={{ time() }}#page=2&toolbar=0&navpanes=0" scrolling="no"></iframe>

            </div>
            <!-- Close button -->
            <div id="overlay" onclick="togglePictureInPicture('p2p')"></div> <!-- Invisible overlay -->

        </div>


    </section>


</div>


<div class="modal fade" id="dataModal">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="main-contents">
                <section class="section">
                    <div class="modal-header bg-primary" style=" background-color: rgb(0 103 172) !important;">
                        <h4 class="modal-title">Activity Observation Report</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    </div>
                    <div class="modal-body" style="background-color: #edfcff !important;">
                        <div class="section-body mt-2">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="mt-0 ">
                                        <div class="card-body" id="card_header">
                                            <table style="width: 100%; max-width: 100%;" class="table table-bordered Tableview View1" id="activity">

                                                <thead style="overflow-y: auto; max-height: 400px;">

                                                    <tr>
                                                        <th style="width: 10%;">SI.No</th>
                                                        <th style="width: 10%;">Activity Sets</th>
                                                        <th style="width: 30%;">Activity Description</th>
                                                        <th style="width: 15%;">Observation</th>
                                                        <th style="width: 15%;">Username</th>

                                                    </tr>
                                                </thead>
                                                <tbody id="activityobserv">

                                                </tbody>

                                            </table>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>
</div>




<br>

</div>

</section>
</div>
<div class="modal fade" id="pdfModal" tabindex="-1" role="dialog" aria-labelledby="pdfModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <!-- <span class="close">&times;</span> -->
            <div class="main-contents">
                <section class="section">
                    <div class="modal-header bg-primary" style=" background-color: rgb(0 103 172) !important;">
                        <h4 class="modal-title">Assessment Detail Summary Preview</h4>
                        <!-- Minimize Button -->
                        <div class="" style="display:flex;justify-content: space-between;">
                            <button type="button" class="minimize-btn" id="edit_row_btn" onclick="chip();">
                                <i class="fas fa-window-minimize" style="pointer-events:none;"></i>
                            </button>
                            <button type="button" class="closepdfmodal close" data-dismiss="modal" aria-hidden="true" onclick="closepdfmodal();">&times;</button>
                        </div>
                    </div>
                    <div class="modal-body" style="background-color: #edfcff !important;">
                        <iframe src="" id="pdfViewerModal" style="width: 100%; height: 600px; border: none;"></iframe>
                    </div>
                </section>
            </div>
        </div>
    </div>
</div>
<div class="card conversation" id="reportPreview" style="display: none;">

    <div class="card-header conversation_header">
        <div class="chating-with">Report Preview</div>
        <div class="icons_chip">
            <button class="icon closenote_btn" title="Close" onclick="closeCard()"><i class="far fa-window-close"></i></button>
        </div>
    </div>
    <div class="card-body chipview" style="display: none;">
        <div class="iframe-container">
            <iframe id="pdfviewnote" src="{{ asset('/assessment_report/' . $c_report . '/Assessment_Detail_Summary_Report.pdf') }}"></iframe>
        </div>
    </div>

</div>

<script>
    function closeCard() {
        var card = document.querySelector('.card.conversation');
        card.style.display = 'none';
    }
    $(document).ready(function() {
        function handleDragging(event) {
            if (isDragging) {
                var deltaX = event.clientX - initialMouseX;
                var newCardX = initialCardX + deltaX;
                document.querySelector('.conversation').style.left = newCardX + 'px';
            }
        }

        function adjustCardAndPDFDimensions(width, height) {
            var conversation = document.querySelector('.conversation');
            var chipView = document.querySelector('.chipview');
            var pdfObject = document.getElementById('pdfviewnote');

            // Set minimum size for the PDF viewer
            var minWidth = 200;
            var minHeight = 150;

            if (width < minWidth) {
                width = minWidth;
            }
            if (height < minHeight) {
                height = minHeight;
            }

            conversation.style.width = width + 'px';
            conversation.style.height = height + 'px';
            // Get the original dimensions of the PDF content
            var originalWidth = pdfObject.offsetWidth;
            var originalHeight = pdfObject.offsetHeight;
            // Calculate the zoom factor based on the new dimensions
            var zoomFactor = Math.min(width / originalWidth, height / originalHeight);
            var minZoomFactor = 0.5; // Adjust as needed

            zoomFactor = Math.max(zoomFactor, minZoomFactor);

            // Set the new dimensions for the PDF viewer
            pdfObject.style.width = (originalWidth * zoomFactor) + 'px';
            pdfObject.style.height = (originalHeight * zoomFactor) + 'px';

        }


    });
</script>

<script>
    function chip() {
        // hidePictureInPicture();
        $('#pdfModal').modal('hide');
        document.querySelector('#pdfModal').classList.add('not-close');
        const conversationSection = document.querySelector(".conversation");
        conversationSection.style.display = 'block';
        const chipview = document.querySelector(".chipview");
        chipview.style.display = 'none';
        document.querySelector('.picture-in-picture').style.display = 'none';
    }


    function hidePictureInPicture() {
        document.querySelector('.picture-in-picture').style.display = 'none';
    }

    function showPictureInPicture() {
        if (!document.querySelector('#pdfModal').classList.contains('not-close')) {
            var pip = document.querySelector('.picture-in-picture');
            pip.style.display = 'block'; // Show picture-in-picture view
            document.querySelector('#pdfModal').classList.remove('not-close');

        }

    }

    function closepdfmodal() {
        showPictureInPicture();
        const conversationSection = document.querySelector(".conversation");
        conversationSection.style.display = 'none';
    }

    function togglePictureInPicture() {


        var pip = document.querySelector('.picture-in-picture');
        var pdfModal = $('#pdfModal');

        pip.classList.toggle('maximized');

        if (pip.classList.contains('maximized')) {
            hidePictureInPicture();
            // Show modal and set iframe src
            // var pdfSrc = $('#pdfViewerPIP').attr('src');
            // console.log('pdfSrc',pdfSrc);
            // $('#pdfViewerModal').attr('src', pdfSrc);
            // pdfModal.modal('show');

            var pdfSrc = $('#pdfViewerPIP').attr('src');
var newSrc = pdfSrc.split('#')[0] + '?v=' + new Date().getTime() + '#' + pdfSrc.split('#')[1];

$('#pdfViewerModal').attr('src', newSrc);
pdfModal.modal('show');

        } else {
            // Hide modal
            pdfModal.modal('hide');
            showPictureInPicture();
        }

        // When modal is closed, revert to picture-in-picture view
        pdfModal.on('hidden.bs.modal', function() {
            showPictureInPicture();
            pip.classList.remove('maximized');
        });
    }

    var maximizeIcon = document.getElementById('maximizeIcon');
    var pdfContainer = document.getElementById('pdfContainer');

    maximizeIcon.addEventListener('click', function(event) {
        event.stopPropagation();
        togglePictureInPicture();
    });

    // Overlay div
    var overlay = document.getElementById('overlay');
    overlay.style.position = 'absolute';
    overlay.style.top = '35px';
    overlay.style.left = 0;
    overlay.style.width = '100%';
    overlay.style.height = '100%';
    overlay.style.background = 'transparent';
    overlay.style.zIndex = 1; // Ensure it's above the iframe
    overlay.style.cursor = 'pointer';
    overlay.title = 'Click to see the Report Preview';

    pdfContainer.addEventListener('click', function(event) {
        event.stopPropagation();
        togglePictureInPicture();
    });

    function closePictureInPicture(event) {
        // Prevent the event from propagating to the overlay

        var pip = document.querySelector('.picture-in-picture');
        pip.style.display = 'none'; // Hide picture-in-picture view
        // document.querySelector('#pdfModal').classList.add('not-close');
    }
</script>

<script>
    document.querySelector('.exclamation-btn').addEventListener('click', function() {
        // Perform an AJAX GET request
        var enrollment_id = <?php echo json_encode($report['enrollment_id']); ?>;


        $.ajax({
            url: '/report/assessmentreport/observation',
            type: 'POST',
            data: {
                'enrollment_id': enrollment_id,
                _token: '{{csrf_token()}}'
            },
            success: function(data) {

                var observationAct = data.observation_act;

                var tableBody = $('#activityobserv');

                // Clear existing table rows
                tableBody.empty();

                // Loop through the observation data and append rows to the table
                for (var i = 0; i < observationAct.length; i++) {
                    // console.log(observationAct); // Check each observation object
                    var observation = observationAct[i];

                    var row = '<tr>' +
                        '<td>' + (i + 1) + '</td>' +
                        '<td><b>' + observation.activity_name + '</b></td>' +
                        '<td>' + observation.description + '</td>' +
                        '<td>' + observation.observation + '</td>' +
                        '<td><b>' + observation.user_display + ':-' + observation.name + '</b></td>' +
                        '</tr>';
                    tableBody.append(row);
                }

                // Show the modal
                $('#dataModal').modal('show');
            },
            error: function(xhr, status, error) {
                // Code to handle errors
                console.error(xhr.responseText);
            }
        });
    });
    // Add click event listener to the Summary button
</script>

<script>
    $(document).ready(function() {
        $(".activitySelect").each(function() {
            var prevValue = $(this).data('previous');
            $('.activitySelect').not(this).find('option[value="' + prevValue + '"]').show();
            var value = $(this).val();
            $(this).data('previous', value);
            $('.activitySelect').not(this).find('option[value="' + value + '"]').hide();
        });
    });
    $(document).ready(function() {
        $('.activitySelect').on('change', function(event) {
            var valuesArray = [];
            var prevValue = $(this).data('previous');
            $('.activitySelect').not(this).find('option[value="' + prevValue + '"]').show();
            var value = $(this).val();
            $(this).data('previous', value);
            $('.activitySelect').not(this).find('option[value="' + value + '"]').hide();
            $("activitySelect option").each(function() {
                var optionValue = $(this).val();
                if (valuesArray.indexOf(optionValue) === -1) {
                    valuesArray.push(optionValue);
                } else {
                    $(this).remove();
                }
            });
        });
    });
</script>
<script>
    function save(a) {
        var checkboxPullInChecked = true;
        document.getElementById('state').value = a;

        var tabIDs = $('.tablinks.swiper-slide-active').attr('id');
        var ret1 = tabIDs.replace('Tab', '');
        document.getElementById('currentPage').value = ret1;
        document.getElementById('Page').value = ret1;

        var switch_radio_values = {};

        var pages = <?php echo json_encode($pages); ?>;

        for (var i = 0; i < pages.length; i++) {
            var page = pages[i];
            var pageId = "Step" + page.page;
            var parentElement = document.getElementById(pageId);

            if (parentElement) {
                var switch_radio = parentElement.querySelector('.switch_radio');
                if (switch_radio) {
                    var isChecked = switch_radio.checked;
                    switch_radio_values[page.page] = isChecked ? 1 : 0;
                    if (!isChecked) {
                        checkboxPullInChecked = false;
                    }
                } else {
                    console.error("Element with class 'switch_radio' not found in page:", pageId);
                }
            } else {
                console.error("Parent element with ID not found:", pageId);
            }
        }

        document.getElementById('switch_radio_values').value = JSON.stringify(switch_radio_values);
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

    $(document).ready(function() {
        var pages = <?php echo json_encode($pages); ?>;
        for (p = 0; p < pages.length; p++) {
            var pageno = pages[p].page;
            $(".pageno" + pageno).not(":last").addClass("addR");
            $(".pageno_a" + pageno).not(":last").addClass("addR");
            $(".pageno_c" + pageno).each(function() {
                $(this).find('tr:not(:last) .pageskill_c').addClass("addR");
            });
        }
    });

    $(document).ready(function() {

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
<script type="text/javascript">
    $(document).ready(function() {

        $("#content").find("[id^='tab']").hide(); // Hide all content
        $("#tabs li:first").addClass("active"); // Activate the first tab
        $("#tab1").fadeIn(); // Show first tab's content



        $('#tabs a').click(function(e) {
            e.preventDefault();
            if ($(this).closest("li").attr("id") == "current") { //detection for current tab
                return;
            } else {
                $("#content").find("[id^='tab']").hide(); // Hide all content
                $("#tabs li").removeClass("active"); //Reset id's
                $(this).parent().addClass("active"); // Activate this
                $('#' + $(this).attr('name')).fadeIn(); // Show content for the current tab


            }
        });

        // document.getElementById('saved').value = (role === "ishead") ? 'Submitted' : 'Saved';

    });
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

        // mySwiperSlide(step);
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
        // console.log('1');
        var tabIDs = $('.tablinks.swiper-slide-active').attr('id');
        var ret1 = tabIDs.replace('Tab', '');
        var i, tabcontent, tablinks;
        var cityName = 'Step'.concat(stepNum);
        var tabName = 'Tab'.concat(stepNum);
        // alert(tabName);
        var stepper = 'stepper'.concat(stepNum);
        tabcontent = document.getElementsByClassName("tabcontent");
        for (i = 0; i < tabcontent.length; i++) {
            tabcontent[i].style.display = "none";
        }
        // console.log('2');
        // document.getElementById(cityName).style.display = "flex";
        var element = document.getElementById(cityName);
        if (element) {
            element.style.display = "flex";
        }

        editingStep = document.getElementsByClassName("md-step");
        for (i = 0; i < editingStep.length; i++) {
            editingStep[i].className = editingStep[i].className.replace(" editable", "");
        }
        // console.log('3');
        document.getElementById(stepper).classList.add('editable');
        // console.log(stepNum , ret1);
        // if (stepNum == 1) {
        //     document.getElementById('swiper_prev').style.display = "none";
        // } else if (stepNum == pages.length) {
        //     document.getElementById('swiper_next').style.display = "none";
        // } else {
        //     document.getElementById('swiper_prev').style.display = "block";
        //     document.getElementById('swiper_next').style.display = "block";
        // }
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
        // console.log(nexttabID);
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

        //initialize swiper when document ready  
        var mySwiper = new Swiper('.swiper-container', {
            // Optional parameters
            direction: 'horizontal',
            loop: false,

            // centeredSlides: true,

            // spaceBetween: '2%',

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
            //event.preventDefault()
            if (!mySwiper.animating) {
                console.log('NOTanimating - so click thru');
            } else {
                console.log('animating');
                return false;
            }
        });

        function mySwiperSlide(step) {
            // alert(step);
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
        document.getElementById('swiper_prev').style.display = "none";
        // navcheck();
    });
</script>

<script>
    var removedPages = [];

    var checkboxes = document.querySelectorAll('.checkRemovePages');
    checkboxes.forEach(function(checkbox) {
        if (checkbox.checked) {
            removedPages.push(checkbox.value);
            document.getElementById('removedPages').value = removedPages.join(',');
            console.log('c', document.getElementById('removedPages').value);
        }
    });

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

                    const isCheckAll = [...checkbox.classList].some(cls => cls.startsWith("checkAll"));
                    
                    if (isCheckAll) {
                        handleCheckboxTableAll(checkbox);
                        return; 
                    }

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
        }else {
            const isCheckAll = [...checkbox.classList].some(cls => cls.startsWith("checkAll"));
                    
                    if (isCheckAll) {
                        handleCheckboxTableAll(checkbox);
                        return; 
                    }
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
</script>

<script>
    $(document).ready(function() {
        var enrollment_child_num = <?php echo json_encode($report['enrollment_child_num']); ?>;
        // 
        // console.log(enrollment_child_num);
        const firstSelect = document.getElementById("firstSelect");
        const addedOptions = new Set();
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
    });
    // Function to call detailsuggestion on change or input events
    function attachEventListeners(step) {
        let stepContainer = document.querySelector(`#${step}`);
        let inputElements = stepContainer.querySelectorAll('.observationSelect, .meeting_description');

        inputElements.forEach((element) => {
            element.addEventListener('change', function() {
                detailsuggestion(step, 'edit'); // Call detailsuggestion with action as edit on change
            });

            element.addEventListener('input', function() {
                detailsuggestion(step, 'edit'); // Call detailsuggestion with action as edit on input
            });
        });
    }

    // window.onload = function() {
    let stepsToProcess = ['Step4', 'Step5', 'Step7', 'Step8', 'Step9', 'Step10', 'Step11']; // List of steps to process

    stepsToProcess.forEach((step, index) => {
        setTimeout(function() {
            detailsuggestion(step, 'edit'); // Specify action as create
        }, index * 100); // Delay each execution by index * 100 milliseconds
    });
    // };
    // // Convert the PHP array to a JavaScript variable

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

        let switch_radio = stepContainer.querySelectorAll('.switch_radio');

        switch_radio.forEach(function(checkbox) {

            if (!checkbox.checked) {
                // if (appendingInput && action == 'edit') {
                let existingDataRegex = new RegExp('\\b' + activityValuesString.replace(/[-\/\\^$*+?.()|[\]{}]/g, '\\$&') + '\\b', 'g');
                appendingInput.value = activityValuesString;
                //}
            }
        });


    }
</script>

<script>
    $(function() {
        // Make reportPreview draggable
        $("#reportPreview").draggable();

        // Make reportPreview resizable with minimum size
        // $("#reportPreview").resizable({
        //     handles: "n, e, s, w",
        //     minWidth: 500, // Minimum width
        //     minHeight: 350, // Minimum height
        //     resize: function(event, ui) {
        //         var newWidth = ui.size.width - 22; // Adjusted width for padding
        //         var newHeight = ui.size.height; // Adjusted height for padding and header
        //         console.log($(this).find('iframe'));
        //         $(this).find('iframe').css({
        //             width: newWidth,
        //             height: newHeight
        //         });
        //     }
        // });
    });
</script>
<script>
    $(window).on('load', function() {
        var id = @json($id);

        Swal.fire({
            title: 'Success',
            text: "",
            icon: 'success',
            showCancelButton: false,
            confirmButtonText: 'Okay!',
        }).then((result) => {
            if (result.isConfirmed) {
                localStorage.setItem('reportPreviewGenerate', 'false');
                const url = `${window.location.origin}/assessment-report-save/${id}`;
                const features = 'width=1,height=1,left=9999,top=9999,noopener,noreferrer';
                const newWindow = window.open(url, '_blank', features);

                if (newWindow) {
                    newWindow.blur();
                    window.focus();
                }
            }
        });
    });

    const checkInterval = setInterval(() => {
        const previewFlag = localStorage.getItem('reportPreviewGenerate');

        if (previewFlag === 'true') {
            console.log('Report preview generation flag is true. Starting next process...');
            clearInterval(checkInterval);
            localStorage.setItem('reportPreviewGenerate', 'false');
            Swal.fire({
                toast: true,
                position: 'top-end',
                icon: 'success',
                title: 'Report Preview is Ready now.',
                showConfirmButton: false,
                timer: 2000,
                timerProgressBar: true
            });

            var c_report = @json($c_report);
            // console.log(c_report);
            updateIframeAndShow(c_report);
        }
    }, 10000);

    function updateIframeAndShow(reportName) {
        const iframe = document.getElementById('pdfViewerPIP');
        const pipContainer = document.getElementById('pip-preview');

        if (!reportName) {
            console.error('Report name is missing.');
            return;
        }

        // Update the iframe src with cache buster
        const newSrc = `/assessment_report/${reportName}/Assessment_Detail_Summary_Report.pdf#page=2&toolbar=0&navpanes=0&v=${Date.now()}`;
        iframe.setAttribute('src', newSrc);

        // Show the picture-in-picture container
        pipContainer.style.display = 'block';
    }
</script>
@include('assessmentreport.add_activity');
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