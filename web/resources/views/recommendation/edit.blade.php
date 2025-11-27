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
        background-image: url('/images/arrowL.png') !important;
    }

    .swiper-button-next {
        margin: -35px 25px 0 0 !important;
        background-image: url('/images/arrowR.png') !important;
    }

    .swiper-button-prev.swiper-button-disabled,
    .swiper-button-next.swiper-button-disabled {
        opacity: 0;
    }

    .select2-container {
        width: 1% !important;
        display: table-cell !important;
    }

    .select2-container--default .select2-selection--multiple .select2-selection__choice {
        color: black !important;
    }

    .select2-container .select2-selection--multiple .select2-selection__rendered {
        white-space: normal !important;
        max-height: 100px;
        overflow-y: scroll;
    }

    .select2-container--default .select2-results__option--highlighted[aria-selected=true] {
        background-color: gray;
    }

    .select2-container--default .select2-results__option--highlighted[aria-selected=false] {
        background-color: #0daf0dbf;
    }

    .select2-container {
        width: 1% !important;
        display: table-cell !important;
    }

    .select2-results__option:before {
        content: "";
        display: inline-block;
        position: relative;
        height: 20px;
        width: 20px;
        border: 2px solid #e9e9e9;
        border-radius: 4px;
        background-color: #fff;
        margin-right: 20px;
        vertical-align: middle;
    }

    .select2-results__option[aria-selected=true]:before {
        font-family: fontAwesome;
        content: "\f00c";
        color: #fff;
        background-color: #f77750;
        border: 0;
        display: inline-block;
        padding-left: 3px;
    }

    textarea {
        height: 120px;
    }

    .picture-in-picture {
        position: fixed;
        top: 380px;
        right: 20px;
        width: 200px;
        /* Initial width */
        height: 156px;
        /* Initial height */
        background-color: #fff;
        border: 1px solid #ccc;
        border-radius: 8px;
        overflow: hidden;
        transition: width 0.3s, height 0.3s;
    }

    .picture-in-picture i {
        display: flex;
        position: fixed;
        top: 475px;
        right: 101px;
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
</style>
@if (session('page'))
<input type="hidden" name="session_data" id="session_data" class="session_data" value="{{ session('page') }}">
<script type="text/javascript">
    window.onload = function() {
        var openpage = $('#session_data').val();
        if (openpage != '' || openpage != null) {
            stepClick(openpage);
        }
        swal.fire("Success", 'The  Recommendation  Report saved successfully', "success");
    }
</script>
@else
<input type="hidden" name="session_data" id="session_data" class="session_data" value="{{ $currentPage }}">
<script type="text/javascript">
    window.onload = function() {
        var openpage = $('#session_data').val();
        if (openpage != '' || openpage != null) {
            stepClick(openpage);
        }
    }
</script>
@endif
<div class="main-content">
    {{ Breadcrumbs::render('recommendation.edit', $report[0]['enrollment_child_num'] ) }}

    <!-- Main Content -->
    <section class="section">


        <div class="section-body mt-1">
            <h5 class="text-center align" style="color:darkblue">Compilation of Recommendation Report</h5>
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">







                            <div class="row is-coordinate">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="control-label">Enrollment ID<span class="error-star" style="color:red;">*</span></label>
                                        <input class="form-control readonly" type="text" id="child_id" name="child_id" placeholder="Child ID" value="{{$report[0]['enrollment_child_num']}}" autocomplete="off" readonly>
                                        <input type="hidden" id="enrollment_id" name="enrollment_id" autocomplete="off" readonly>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="control-label">Child ID</label>
                                        <input class="form-control readonly" type="text" id="child_id" name="child_id" placeholder="Child ID" value="{{$report[0]['child_id']}}" autocomplete="off" readonly>
                                        <input type="hidden" id="enrollment_id" name="enrollment_id" autocomplete="off" readonly>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="control-label">Child Name</label>
                                        <input class="form-control readonly" type="text" id="child_name" name="child_name" value="{{$report[0]['child_name']}}" oninput="Childname(event)" maxlength="20" value="" placeholder="Enter Name" autocomplete="off" readonly>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="control-label">Date of Reporting</label>
                                        @if($report[0]['dor'] == '')
                                        <input class="form-control default" type="date" onchange="document.getElementById('dor').value = this.value" value="<?php echo date('Y-m-d'); ?>">
                                        @else
                                        <input class="form-control default" type="date" onchange="document.getElementById('dor').value = this.value" value="{{$report[0]['dor']}}">
                                        @endif
                                    </div>
                                </div>

                            </div>

                        </div>
                    </div>
                </div>





                <div class="row" id="r1">
                    <div class="col-md-12 col-lg-12 mlr-auto" style="padding-top: 20px;">

                        <div class="md-stepper-horizontal" style="    margin-bottom: 20px;">
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
                                <button class="swiper-slide tablinks" id="Tab{{$page['page']}}" onclick="openCity('{{$page['page']}}')">PAGE - {{$page['page']}}</button>
                                @endforeach
                                <a class="swiper-slide" id="Tab13" onclick="openCity('13')"></a>
                                <a class="swiper-slide" id="Tab13" onclick="openCity('13')"></a>

                            </div>
                        </div>
                        <!-- <div class="swiper-button-prev swipenav" onclick="swipeprev()" id="swiper_prev"></div> -->
                        <!-- <div class="swiper-button-next swipenav" onclick="swipenext()" id="swiper_next"></div> -->
                    </div>
                </div>

            </div>
            <div id="r2">
                <form name="edit_form" action="{{ route('report.recommendationupdate')}}" method="POST" id="form_report">
                    {{ csrf_field() }}
                    <input type="hidden" id="state" name="state">
                    <input type="hidden" value="{{$report[0]['enrollment_id']}}" id="enrollmentId" name="enrollmentId">
                    <input type="hidden" value="{{$report[0]['report_id']}}" name="reports_id" id="reports_id">
                    <input type="hidden" id="currentPage" name="currentPage">
                    @if($report[0]['dor'] == '')
                    <input type="hidden" id="dor" name="dor" value="<?php echo date('Y-m-d'); ?>">
                    @else
                    <input type="hidden" id="dor" name="dor" value="{{$report[0]['dor']}}">
                    @endif
                    <div class="row" style="margin: 25px 0px 0px 0px;">
                        @foreach($pages as $page)
                        <div class="col-12">
                            <div id="card content">
                                <div id="Step{{$page['page']}}" class="card-body tabcontent paginationTab{{$page['page']}}">
                                    @if($page['page'] == 4)
                                    <textarea id="meeting_description{{$loop->iteration}}" name="meeting_description[{{$page['page']}}]">
                                    {{$page['page_description']}}
                                    </textarea>
                                    @else
                                    <textarea id="meeting_description{{$loop->iteration}}" name="meeting_description[{{$page['page']}}]">
                                    {{$page['page_description']}}
                                    </textarea>
                                    @endif
                                </div>
                            </div>
                        </div>
                        @endforeach

                        <!-- components -->
                        <div class="col-12 scrollable fixTableHead title-padding" style="display: none;" id="page2">
                            <div class="table-responsive">
                                <table class="table table-bordered card-body" id="main">
                                    <thead>
                                        <tr>
                                            <th width="35%"> Components in the process of learning </th>
                                            <th width="65%"> Recommendations based on child's strength </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($components as $component)
                                        <tr>
                                            <td style="border: 1px solid black !important;">{{$component['area_name']}}</td>
                                            <td style="border: 1px solid black !important;"><textarea class="form-control default components_textarea" name="components[{{$component['recommendation_detail_area_id']}}]">{{ isset($component['description']) ? $component['description'] : '' }}</textarea></td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <!-- End components -->

                        <!-- page 6 -->
                        <div class="col-12 scrollable fixTableHead title-padding" style="display: none;" id="page3">
                            <div class="table-responsive">
                                <table class="table table-bordered card-body" id="main">
                                    <thead>
                                        <tr>
                                            <th>Areas </th>
                                            <th>Strength</th>
                                            <th>Recommendation strategies and Environment </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($page6 as $table6)
                                        <tr id="row{{$loop->iteration}}">
                                            <td width="20%"><input type="hidden" name="rows[row{{$loop->iteration}}][0]" value="{{$table6['recommendation_detail_area_id']}}">{{$table6['area_name']}}</td>
                                            <td width="40%"><textarea class="form-control default" name="rows[row{{$loop->iteration}}][1]">{{$table6['strengths']}}</textarea></td>
                                            <td width="40%">
                                                @php
                                                $words = explode('_', $table6['recommended_enviroment']);
                                                $formatted = implode(PHP_EOL, $words);
                                                @endphp
                                                <textarea class="form-control default" name="rows[row{{$loop->iteration}}][2][]" id="recommended_id{{$loop->iteration}}">{{$formatted}}</textarea>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <!-- End 6 -->
                        <!-- Page 8 -->
                        <div class="col-12 scrollable title-padding" style="display: none;height:500px" id="page5">
                            <div class="table-responsive" style="border: 1px solid #0e0e0e !important;">
                                @php $iteration = 0; @endphp
                                @foreach($areas as $table7)
                                @php $iteration = $iteration+1; @endphp
                                <table class="table table-bordered card-body" id="main" style="width: 100%;border-spacing: 0px;border-collapse: collapse;">
                                    <thead>
                                        <tr>
                                            <th colspan="2" style="z-index: 999999;font-family: Barlow !important;padding:0 !important;font-size: 20px;border: 1px solid #040404 !important;color: white;background-color: blue !important;">Area : {{ $table7['area_name']}}
                                                <table width="100%">
                                                    <tr>
                                                        <th width="35%" style="font-family: Barlow !important;padding:4px;font-size: 20px;border: 1px solid #040404 !important;color: #141414;background-color: yellow !important;">Factors</th>
                                                        <th width="65%" style="font-family: Barlow !important;padding:4px;font-size: 20px;border: 1px solid #040404 !important;color: #141414;background-color: yellow !important;">Observation</th>
                                                    </tr>
                                                </table>
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php $sub_iteration = 0; @endphp
                                        @foreach($page7 as $factors)
                                        @if($factors['recommendation_detail_area_id']==$table7['recommendation_detail_area_id'])
                                        @php $sub_iteration = $sub_iteration+1; @endphp
                                        <tr>
                                            <td width="35%" style="font-size: 20px;font-weight:bold;border: 1px solid black !important;"> <input type="hidden" name="rows2[table_column{{$iteration}}][row{{$sub_iteration}}][{{$factors['recommendation_report_detail2_id']}}]" value="{{ $factors['factor_name']}}" style="font-size: 24px;font-weight:bold">{{ $factors['factor_name']}}</td>
                                            <td width="65%" style="border: 1px solid black !important;"><textarea class="components_textarea" style="width: 100% !important;" name="rows2[table_column{{$iteration}}][row{{$sub_iteration}}][2]">{{ $factors['detail']}}</textarea></td>
                                        </tr>
                                        @endif
                                        @endforeach
                                    </tbody>
                                </table>
                                @endforeach
                            </div>
                        </div>
                        <!-- End Page 8 -->
                         <!-- Page 4 -->
                    <div class="col-12 scrollable fixTableHead title-padding" style="display: none;" id="page4">
                        <div class="table-responsive">
                            <table class="table table-bordered card-body" id="main">
                                <thead>
                                    <tr>
                                        <th>Tier</th>
                                        <th>Focus Area</th>
                                        <th>Key Strategies</th>
                                        <th>Intended Outcomes</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($tiers as $tierIndex => $tier)
                                    @php $focusCount = count($tier['focus_areas'] ?? []); @endphp
                                    @foreach ($tier['focus_areas'] ?? [] as $focusIndex => $focus)
                                    <tr>
                                        @if ($focusIndex == 0)
                                        <td rowspan="{{ $focusCount }}">{{ $tier['name'] }}</td>
                                        @endif
                                        <td>{{ $focus['name'] }}</td>
                                        <td>
                                            <textarea class="form-control"
                                                name="tiers[{{ $tier['id'] }}][focus_areas][{{ $focus['id'] }}][key_strategies]"
                                                id="key_strategies_{{ $tier['id'] }}_{{ $focus['id'] }}">{{ $focus['detail']['key_strategies'] ?? '' }}</textarea>
                                        </td>
                                        <td>
                                            <textarea class="form-control"
                                                name="tiers[{{ $tier['id'] }}][focus_areas][{{ $focus['id'] }}][intended_outcomes]"
                                                id="intended_outcomes_{{ $tier['id'] }}_{{ $focus['id'] }}">{{ $focus['detail']['intended_outcomes'] ?? '' }}</textarea>
                                        </td>
                                    </tr>
                                    @endforeach
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <!-- End Page 4 -->
                        <!-- Sign -->
                        <div class="col-12 scrollable fixTableHead title-padding" style="display: none;" id="signTable">
                            <div class="table-responsive">
                                <table class="table table-bordered card-body">
                                    <tbody>
                                        <tr>
                                            <td style="background: white;border: 1px solid #0e0e0e !important;vertical-align: initial !important;">
                                                @if(isset($signature[1]))
                                                <textarea class="tinymce-textarea" style="width: 100%;height:150px;" id="signature_1" name="signature[1]">{{$signature[1]}}</textarea>
                                                @else
                                                <textarea class="tinymce-textarea" style="width: 100%;height:150px;" id="signature_1" name="signature[1]"></textarea>
                                                @endif
                                            </td>
                                            <td style="background: white;border: 1px solid #0e0e0e !important;vertical-align: initial !important;">
                                                @if(isset($signature[2]))
                                                <textarea class="tinymce-textarea" style="width: 100%;height:150px;" id="signature_2" name="signature[2]">{{$signature[2]}}</textarea>
                                                @else
                                                <textarea class="tinymce-textarea" style="width: 100%;height:150px;" id="signature_2" name="signature[2]"></textarea>
                                                @endif
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <!-- End Sign -->

                </form>
                <div class="col-md-12 text-center">
                    <a type="button" class="btn btn-labeled btn-info" onclick="PrevTab();" id="Previous" title="Previous" style="display:none;height: 35px;background: blue !important; border-color:blue !important; color:white !important">
                        <span class="btn-label" style="font-size:13px !important;"><i class="fa fa-arrow-left"></i></span> Previous</a>
                    <a type="button" onclick="save('Submitted')" id="submitbutton" class="btn btn-labeled btn-succes" title="Submit" style="background: Orange !important; color:white !important">
                        <span class="btn-label" style="font-size:13px !important;"><i class="fa fa-check"></i></span> Submit</a>
                    <a type="button" onclick="save('Saved')" id="submitbutton" class="btn btn-labeled btn-succes" title="Save" style="background: green !important; border-color:green !important; color:white !important">
                        <span class="btn-label" style="font-size:13px !important;"><i class="fa fa-check"></i></span> Save</a>
                    <a type="button" class="btn btn-labeled back-btn" title="Back" href="{{ route('recommendation.index') }}" style="color:white !important">
                        <span class="btn-label" style="font-size:13px !important;"><i class="fa fa-arrow-left"></i></span> Back</a>
                    <a type="button" class="btn btn-labeled btn-info" onclick="NextTab();" id="Next" title="Next" style="background: blue !important; border-color:#4d94ff !important; color:white !important;height: 35px;">
                        <span class="btn-label" style="font-size:13px !important;">Next</span> <i class="fa fa-arrow-right"></i></a>
                </div>
            </div>


        </div>
        <!-- Picture-in-Picture View -->

        <div class="picture-in-picture">
            <div class="row reportheading">
                <h6>Report Preview</h6>
                <a type="button" class="close_p2p" onclick="closePictureInPicture('closep2p')" style="color: white !important;font-size: 20px !important;">
                    <span class="closep2p" style="color: white !important;">&times;</span>
                </a>
            </div>

            <i class="fas fa-expand" id="maximizeIcon" onclick="togglePictureInPicture('p2p')"></i> <!-- Maximize icon -->
            <div id="pdfContainer" class="pdf-container" onclick="togglePictureInPicture('p2p')" title="Click to see the Report Preview">
                <iframe id="pdfViewerPIP" src="{{ asset('/recommendation_report/' . $c_report . '/recommendation_report.pdf')}}#page=2&toolbar=0&navpanes=0" scrolling="no"></iframe>

            </div>
            <!-- Close button -->
            <div id="overlay" onclick="togglePictureInPicture('p2p')"></div> <!-- Invisible overlay -->

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
                        <h4 class="modal-title">Recommendation Report Preview</h4>
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

<div class="card conversation" id="reportPreview popup" style="display: none;">

    <div class="card-header conversation_header popup-header" id="header">
        <div class="chating-with">Report Preview</div>
        <div class="icons_chip">
            <button class="icon closenote_btn" title="Close" onclick="closeCard()"><i class="far fa-window-close"></i></button>
        </div>
    </div>
    <div class="card-body chipview" style="display: none;">
        <div class="iframe-container">
            <iframe id="pdfviewnote" src="{{ asset('/recommendation_report/' . $c_report . '/recommendation_report.pdf') }}"></iframe>
        </div>
        <div class="resize-handle" id="resize-handle"></div>

    </div>

</div>
<script>
    $(".js-select5").select2({
            scrollAfterSelect: true,
            closeOnSelect: false,
            placeholder: " Please Select the value ",
            allowHtml: true,
            allowClear: true,
            tags: true // создает новые опции на лету
        }).on('select2:selecting', e => $(e.currentTarget).data('scrolltop', $('.select2-results__options').scrollTop()))
        .on('select2:select', e => $('.select2-results__options').scrollTop($(e.currentTarget).data('scrolltop')));
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/tinymce/4.5.6/tinymce.min.js"></script>
<script src="http://cdnjs.cloudflare.com/ajax/libs/tinymce/4.5.6/jquery.tinymce.min.js"></script>

<script>
    function save(a) {
        document.getElementById('state').value = a;
        var tabIDs = $('.tablinks.swiper-slide-active').attr('id');
        var ret1 = tabIDs.replace('Tab', '');
        document.getElementById('currentPage').value = ret1;
        $('.loader').show();
        document.getElementById('form_report').submit();
    }
</script>
<script>
    $(document).ready(function() {

        var pages = <?php echo json_encode($pages); ?>;
        var fixheight = 500;
        for (p = 0; p < pages.length; p++) {
            var k = p + 1;
            if (k == 4) {
                fixheight = 200;
            } else {
                fixheight = 500;
            }
            tinymce.init({
                selector: 'textarea#meeting_description' + k,
                height: fixheight,
                plugins: 'preview importcss searchreplace autolink autosave save directionality code visualblocks visualchars fullscreen image link media codesample table charmap pagebreak nonbreaking anchor insertdatetime advlist lists wordcount help charmap quickbars emoticons',
                imagetools_cors_hosts: ['picsum.photos'],
                menubar: 'file edit view insert format tools table help',
                toolbar: 'undo redo | bold italic underline strikethrough | fontfamily fontsize blocks | alignleft aligncenter alignright alignjustify | outdent indent |  numlist bullist | forecolor backcolor removeformat | pagebreak | charmap emoticons | fullscreen  preview save print | insertfile image media link anchor codesample | ltr rtl',
                toolbar_sticky: true,
                autosave_ask_before_unload: true,
                autosave_interval: "30s",
                autosave_prefix: "{path}{query}-{id}-",
                autosave_restore_when_empty: false,
                autosave_retention: "2m",
                image_advtab: true,
                content_css: "{{url('assets/css/css2.css')}}",
                font_formats: "Andale Mono=andale mono,times; Arial=arial,helvetica,sans-serif; Arial Black=arial black,avant garde; Barlow=Barlow, sans-serif; Barlow Condensed=Barlow Condensed, sans-serif; Barlow Semi Condensed=Barlow Semi Condensed, sans-serif; Plain Barlow Black=Barlow Black, sans-serif; Plain Barlow Bold=Barlow Bold, sans-serif; Plain Barlow Light=Barlow Light, sans-serif; Plain Barlow Medium=Barlow Medium, sans-serif; Plain Barlow Thin=Barlow Thin, sans-serif; Book Antiqua=book antiqua,palatino; Comic Sans MS=comic sans ms,sans-serif; Courier New=courier new,courier; Georgia=georgia,palatino; Helvetica=helvetica; Impact=impact,chicago; Oswald=oswald; Symbol=symbol; Tahoma=tahoma,arial,helvetica,sans-serif; Terminal=terminal,monaco; Times New Roman=times new roman,times; Trebuchet MS=trebuchet ms,geneva; Verdana=verdana,geneva; Webdings=webdings; Wingdings=wingdings,zapf dingbats",
                content_style: "@import url('https://fonts.googleapis.com/css2?family=Barlow&display=swap');",
                content_style: "@import url(https://fonts.googleapis.com/css2?family=Barlow+Condensed:wght@400;display=swap);",
                content_style: "@import url(https://fonts.googleapis.com/css2?family=Barlow+Condensed:wght@700&display=swap);",
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

                            /* call the callback and populate the Title field with the file name */
                            cb(blobInfo.blobUri(), {
                                title: file.name
                            });
                        };
                        reader.readAsDataURL(file);
                    };

                    input.click();
                },

                height: fixheight,
                image_caption: true,
                quickbars_selection_toolbar: 'bold italic | quicklink h2 h3 blockquote quickimage quicktable',
                noneditable_noneditable_class: "mceNonEditable",
                toolbar_mode: 'sliding',
                contextmenu: "link image imagetools table",

            });
        }
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
        tinymce.init({
            selector: '.components_textarea',
            height: 200,
            // menubar: false,
            branding: false,
            plugins: 'preview importcss searchreplace autolink autosave save directionality code visualblocks visualchars fullscreen image link media codesample table charmap pagebreak nonbreaking anchor insertdatetime advlist lists wordcount help charmap quickbars emoticons',
            toolbar: 'undo redo | bold italic underline strikethrough | fontselect | alignleft aligncenter alignright alignjustify | outdent indent |  numlist bullist | forecolor backcolor removeformat | pagebreak | charmap emoticons | fullscreen  preview save print | insertfile image media link anchor codesample | ltr rtl',
            content_css: "{{url('assets/css/css2.css')}}",
            font_formats: "Andale Mono=andale mono,times; Arial=arial,helvetica,sans-serif; Arial Black=arial black,avant garde; Barlow=Barlow, sans-serif; Barlow Condensed=Barlow Condensed, sans-serif; Barlow Semi Condensed=Barlow Semi Condensed, sans-serif; Plain Barlow Black=Barlow Black, sans-serif; Plain Barlow Bold=Barlow Bold, sans-serif; Plain Barlow Light=Barlow Light, sans-serif; Plain Barlow Medium=Barlow Medium, sans-serif; Plain Barlow Thin=Barlow Thin, sans-serif; Book Antiqua=book antiqua,palatino; Comic Sans MS=comic sans ms,sans-serif; Courier New=courier new,courier; Georgia=georgia,palatino; Helvetica=helvetica; Impact=impact,chicago; Oswald=oswald; Symbol=symbol; Tahoma=tahoma,arial,helvetica,sans-serif; Terminal=terminal,monaco; Times New Roman=times new roman,times; Trebuchet MS=trebuchet ms,geneva; Verdana=verdana,geneva; Webdings=webdings; Wingdings=wingdings,zapf dingbats",
            content_style: "@import url('https://fonts.googleapis.com/css2?family=Barlow&display=swap');",
            content_style: "@import url('https://fonts.googleapis.com/css2?family=Barlow+Condensed:wght@400;display=swap');",
            content_style: "@import url('https://fonts.googleapis.com/css2?family=Barlow+Condensed:wght@700&display=swap');",
            content_style: "@import url('https://fonts.googleapis.com/css2?family=Barlow+Semi+Condensed:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap');",
            content_style: 'body {font-family :Barlow Condensed, sans-serif;}',
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
                // var category_id = json.parse(data);
                console.log(data);

                if (data != '[]') {
                    $('#r1').show();
                    $('#r2').show();
                    // var user_select = data;
                    var optionsdata = "";

                    document.getElementById('child_id').value = data[0].child_id;
                    document.getElementById('child_name').value = data[0].child_name;
                    document.getElementById('enrollmentId').value = data[0].enrollment_id;
                    document.getElementById('meeting_to').value = data[0].child_contact_email;
                    document.getElementById('enrollment_id').value = data[0].enrollment_id;

                    // console.log(data)


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

        document.getElementById('saved').value = (role === "ishead") ? 'Submitted' : 'Saved';

    });

    $("#submit").click(function() {


        const getAllFormElements = element => Array.from(element.elements).filter(tag => ["textarea"].includes(tag.tagName.toLowerCase()));
        const pageFormElements = getAllFormElements(document.getElementById("ovmisc"));
        for (i = 0; i < pageFormElements.length; i++) {
            if (pageFormElements[i].value == "") {
                let text = "Please Enter Field ";
                text += pageFormElements[i].title;
                let tab = " in ";
                tab += pageFormElements[i].parentElement.parentElement.parentElement.parentElement.parentElement.parentElement.title;
                tab += " Section"
                text += tab;
                swal.fire({
                    title: "Warning",
                    text: text,
                    type: "warning"
                }, );
                return false;
            }
        }
    });
    tinymce.init({
        selector: 'textarea#description',
        height: 180,
        menubar: false,
        branding: false,
        plugins: [
            'advlist autolink lists link image charmap print preview anchor',
            'searchreplace visualblocks code fullscreen',
            'insertdatetime media table paste code help wordcount'
        ],
        toolbar: 'undo redo | formatselect | ' +
            'bold italic backcolor | alignleft aligncenter ' +
            'alignright alignjustify | bullist numlist outdent indent | ' +
            'removeformat | help',
        content_style: 'body { font-family:Helvetica,Arial,sans-serif; font-size:14px }'
    });
</script>



<script type="text/javascript">
    const statusfn = (event) => {
        let status = event.target.value;
        let currenetstatus = document.getElementById("resch");
        currenetstatus.style.display = (status === "Rescheduled") ? "inline-block" : "none";
        //...
    }
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Swiper/4.5.1/js/swiper.min.js"></script>
<script>
    function swipenext() {
        $('.swiper-slide-next').each(function(i, el) {
            var tabID = $(el).attr('id');
            var ret = tabID.replace('Tab', ''); //alert(ret);
            openCity(ret);
        });
    }

    function swipeprev() {
        $('.swiper-slide-prev').each(function(i, el) {
            var tabID = $(el).attr('id');
            var ret = tabID.replace('Tab', ''); //alert(ret);
            openCity(ret);
        });
    }

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
        $('#page3').toggle(stepNum == 3);
        $('#page4').toggle(stepNum == 4);
        $('#page5').toggle(stepNum == 5);
        $('#page2').toggle(stepNum == 2);
        $('#signTable').toggle(stepNum == 6);
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
        document.getElementById(cityName).style.display = "flex";

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
    // function navcheck(){

    // }
</script>

<script>
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
</script>
<script>
    function checkCharCount(textarea) {
        var maxChar = 100;

        if (textarea.value.length >= maxChar) {
            textarea.value = textarea.value.substring(0, maxChar);
            textarea.removeEventListener("input", checkCharCount);
            swal.fire("Info", "Note : Each column will hold maximum of 100 Words. If needed, for additional comments, use 'Notes-1,2,..'. If No notes column available, contact IS Head/Manager.", "info");
        }

        var remainingChars = maxChar - textarea.value.length;
        // console.log("Remaining characters: " + remainingChars);
    }

    function checkWordCount(textarea) {
        var maxWords = 10;

        var words = textarea.value.trim().split(/\s+/);
        var wordCount = words.length;

        if (wordCount >= maxWords) {
            textarea.value = words.slice(0, maxWords).join(' ');
            textarea.removeEventListener("input", checkWordCount);
            swal.fire("Info", "Note: Each column will hold a maximum of 100 words. If needed, for additional comments, use 'Notes-1,2,..'. If no notes column is available, contact IS Head/Manager.", "info");
        }

        var remainingWords = maxWords - wordCount;
        // console.log("Remaining words: " + remainingWords);
    }
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
            var pdfSrc = $('#pdfViewerPIP').attr('src');
            $('#pdfViewerModal').attr('src', pdfSrc);
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
    function closeCard() {
        var card = document.querySelector('.card.conversation');
        card.style.display = 'none';
    }
    $(document).ready(function() {

        // Define the handleDragging function for dragging behavior
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
<!-- Floating Window -->
<script>
    // Make the popup draggable
    const header = document.getElementById('header');
    let isDragging = false;
    let offsetX, offsetY;

    header.addEventListener('mousedown', startDragging);
    header.addEventListener('mouseup', stopDragging);
    document.addEventListener('mousemove', drag);

    // Define the handleDragging function for dragging behavior
    function handleDragging(event) {
        if (isDragging) {
            var deltaX = event.clientX - initialMouseX;
            var newCardX = initialCardX + deltaX;
            document.querySelector('.conversation').style.left = newCardX + 'px';
        }
    }

    function startDragging(e) {

        isDragging = true;
        initialMouseY = event.clientY;
        initialHeaderHeight = document.querySelector('.conversation_header').offsetHeight;
        initialBodyHeight = document.querySelector('.chipview').offsetHeight;
        initialMouseX = event.clientX;
        initialCardX = document.querySelector('.conversation').offsetLeft;
        // Show the card-body when dragging starts
        document.querySelector('.chipview').style.display = 'block';
        document.addEventListener('mousemove', handleDragging);
        document.addEventListener('mouseup', stopDragging);
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
        document.querySelector('.chipview').style.display = 'block';
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
                document.querySelector('.chipview').style.display = 'block';
                // Resize the chipview
                const chipview = document.querySelector('.chipview');
                const chipviewHeight = newHeight - headerHeight; // Exclude header height
                chipview.style.height = chipviewHeight + 'px';

                // // Resize the iframe inside the chipview
                // const iframe = document.getElementById('pdfviewnote');
                // iframe.style.height = chipviewHeight + 'px';
            }

            prevX = e.clientX;
            prevY = e.clientY;
        }
    }
</script>
<script>
    $(function() {
        // Make reportPreview draggable
        $("#reportPreview").draggable();


    });
</script>
@endsection