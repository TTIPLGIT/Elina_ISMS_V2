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
        padding: 0.5rem !important;

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
    }

    .swiper-button-next {
        margin: -35px 25px 0 0 !important;
    }

    .swiper-button-prev.swiper-button-disabled,
    .swiper-button-next.swiper-button-disabled {
        opacity: 0;
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

    textarea {
        height: 120px;
    }
</style>
<div class="main-content">
    {{ Breadcrumbs::render('recommendation.create') }}
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
                                    <select class="form-control" id="enrollment_child_num" name="enrollment_child_num" onchange="GetChilddetails()">
                                        <option value="">Select-Enrollment</option>
                                        @foreach($enrollment_details as $key=>$row)
                                        <option value="{{$row['enrollment_child_num']}}">{{ $row['enrollment_child_num']}} ( {{$row['child_name']}} )</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
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
            <form name="edit_form" action="{{ route('report.recommendation_new_store')}}" method="POST" id="form_report">
                {{ csrf_field() }}
                <input type="hidden" id="state" name="state">
                <input type="hidden" id="enrollmentId" name="enrollmentId">
                <input type="hidden" value="{{$report['reports_id']}}" name="reports_id" id="reports_id">
                <input type="hidden" id="currentPage" name="currentPage">
                <input type="hidden" id="dor" name="dor" value="<?php echo date('Y-m-d'); ?>">
                <div class="row" style="    margin: 25px 0px 0px 0px;">
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
                                        <td style="border: 1px solid black !important;"><textarea class="form-control default components_textarea" name="components[{{$component['recommendation_detail_area_id']}}]"></textarea></td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <!-- End components -->
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
                    <!-- page 6 -->
                    <div class="col-12 scrollable fixTableHead title-padding" style="display: none;" id="page3">
                        <div class="table-responsive">
                            <table class="table table-bordered card-body" id="main">
                                <thead>
                                    <tr>
                                        <th> Areas </th>
                                        <th>Strength</th>
                                        <th>Recommendation strategies and Environment </th>
                                        {{-- <th>Some strategies recommended</th> --}}
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($page6 as $table6)
                                    <tr id="row{{$loop->iteration}}">
                                        <td width="20%">{{$table6['area_name']}}
                                            <input type="hidden" name="rows[row{{$loop->iteration}}][0]" value="{{$table6['recommendation_detail_area_id']}}">
                                        </td>
                                        <td width="40%"><textarea class="form-control default" name="rows[row{{$loop->iteration}}][1]">{{$table6['strengths']}}</textarea></td>
                                        <td width="40%">
                                            <!-- <select class="js-select5 form-control" name="rows[row{{$loop->iteration}}][2][]" multiple="multiple" id="recommended_id{{$loop->iteration}}">
                                                @foreach($description as $derow)
                                                @if($derow['recommendation_detail_area_id'] === $table6['recommendation_detail_area_id'])
                                                <option value="{{$derow['recommended_environment']}}">{{$derow['recommended_environment']}}</option>
                                                @endif
                                                @endforeach
                                            </select> -->
                                            <textarea class="form-control default" name="rows[row{{$loop->iteration}}][2][]" multiple="multiple" id="recommended_id{{$loop->iteration}}"></textarea>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <!-- <div class="text-center" style="    padding: 0 0 10px 0px;"><button onclick="addRow2();" class="btn-success"><i class="fa fa-plus"></i> ADD NEW ROW</button></div> -->

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
                                        <td width="35%" style="border: 1px solid black !important;font-size: 20px;font-weight:bold"><input type="hidden" name="rows2[table_column{{$iteration}}][row{{$sub_iteration}}][{{$factors['recommendation_report_detail2_id']}}]" value="{{ $factors['factor_name']}}" style="font-size: 24px;font-weight:bold">{{ $factors['factor_name']}}</td>
                                        <td width="65%" style="border: 1px solid black !important;"><textarea class="components_textarea" style="width: 100% !important;" name="rows2[table_column{{$iteration}}][row{{$sub_iteration}}][2]">{{ $factors['detail']}}</textarea></td>
                                    </tr>
                                    @endif
                                    @endforeach
                                </tbody>
                            </table>
                            @endforeach
                        </div>
                    </div>
                    <!-- End 8 -->
                    <!-- Sign -->
                    <div class="col-12 scrollable fixTableHead title-padding" style="display: none;" id="signTable">
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
                    <!-- End Sign -->
                </div>
            </form>
            <div class="col-md-12 text-center">
                <a type="button" class="btn btn-labeled btn-info" onclick="PrevTab();" id="Previous" title="Previous" style="display:none;height: 35px;background: blue !important; border-color:blue !important; color:white !important">
                    <span class="btn-label" style="font-size:13px !important;"><i class="fa fa-arrow-left"></i></span> Previous</a>
                <a type="button" onclick="save('Saved')" id="submitbutton" class="btn btn-labeled btn-succes" title="Save" style="background: green !important; border-color:green !important; color:white !important">
                    <span class="btn-label" style="font-size:13px !important;"><i class="fa fa-check"></i></span> Save</a>
                <a type="button" onclick="save('Submitted')" id="submitbutton" class="btn btn-labeled btn-succes" title="Submit" style="background: orange !important; color:white !important">
                    <span class="btn-label" style="font-size:13px !important;"><i class="fa fa-check"></i></span> Submit</a>
                <a type="button" class="btn btn-labeled back-btn" title="Back" href="{{ route('recommendation.index') }}" style="color:white !important">
                    <span class="btn-label" style="font-size:13px !important;"><i class="fa fa-arrow-left"></i></span> Back</a>
                <a type="button" class="btn btn-labeled btn-info" onclick="NextTab();" id="Next" title="Next" style="background: blue !important; border-color:#4d94ff !important; color:white !important;height: 35px;">
                    <span class="btn-label" style="font-size:13px !important;">Next</span> <i class="fa fa-arrow-right"></i></a>
            </div>
        </div>
    </div>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/tinymce/4.5.6/tinymce.min.js"></script>
<script src="http://cdnjs.cloudflare.com/ajax/libs/tinymce/4.5.6/jquery.tinymce.min.js"></script>
<script>
    // $(document).ready(function() {
    //     var paTotal = <?php echo json_encode($page6); ?>;
    //     for (var i = 0; i < paTotal.length; i++) {
    //         var area_name = paTotal[i].recommendation_detail_area_id;
    //         var order = i + 1;
    //         if (area_name != "") {
    //             $.ajax({
    //                 url: "{{ url('/areaname/master/ajax') }}",
    //                 type: 'POST',
    //                 data: {
    //                     'area_name': area_name,
    //                     _token: '{{csrf_token()}}'
    //                 }
    //             }).done(function(data) {
    //                 if (data != '[]') {
    //                     var optionsdata;
    //                     var optionsdata2;
    //                     for (var i = 0; i < data.length; i++) {
    //                         var name = data[i]['recommended_environment'];
    //                         var id = data[i]['recommendation_area_description_id'];
    //                         optionsdata += "<option value=" + id + " >" + name + "</option>";
    //                         var strategies = data[i]['strategies_recommended'];
    //                         optionsdata2 += "<option value=" + id + " >" + name + "</option>";
    //                     }
    //                     var demonew = $(`#recommended_id${order}`).html(optionsdata);
    //                     var demonew2 = $(`#strategies_id${order}`).html(optionsdata2);

    //                 } else {
    //                     document.getElementById('child_name');
    //                     var ddd = '<option>No Data</option>';
    //                     var demonew = $('#child_name').html(ddd);
    //                 }

    //             })
    //         } else {
    //             document.getElementById('initiated_by');
    //             var ddd = '<option value="initiated_by">Select Enrollment_child_num</option>';
    //             var demonew = $('#initiated_by').html(ddd);
    //         }
    //     }
    // });
</script>
<script>
    function save(a) {
        if (document.getElementById('enrollment_child_num').value == "") {
            swal.fire("Please Select Enrolment Number", "", "error");
            return false;
        }
        var tabIDs = $('.tablinks.swiper-slide-active').attr('id');
        var ret1 = tabIDs.replace('Tab', '');
        document.getElementById('currentPage').value = ret1;
        document.getElementById('state').value = a;
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
            toolbar: 'undo redo | bold italic underline strikethrough | fontselect fontsizeinput | alignleft aligncenter alignright alignjustify | outdent indent |  numlist bullist | forecolor backcolor removeformat | pagebreak | charmap emoticons | fullscreen  preview save print | insertfile image media link anchor codesample | ltr rtl',
            content_css: "{{url('assets/css/css2.css')}}",
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
                // var category_id = json.parse(data);
                // console.log(data);

                if (data != '[]') {
                    $('#r1').show();
                    $('#r2').show();
                    // var user_select = data;
                    var optionsdata = "";

                    document.getElementById('child_id').value = data[0].child_id;
                    document.getElementById('child_name').value = data[0].child_name;
                    document.getElementById('enrollmentId').value = data[0].enrollment_id;
                    document.getElementById('enrollment_id').value = data[0].enrollment_id;

                    // console.log(data)
                    var user_id = data[0].user_id;
                    $('#a' + user_id).show();
                    var gender = (data[0].child_gender == "Male") ? 'He' : 'She';
                    for (p = 0; p < pages.length; p++) {
                        var k = p + 1;
                        var content = tinymce.get('meeting_description' + k).getContent();
                        content = content.replace(/childName/g, data[0].child_name);
                        content = content.replace(/He/g, gender);
                        content = content.replace(/She/g, gender);
                        tinymce.get('meeting_description' + k).setContent(content);
                    }

                } else {
                    document.getElementById('child_name');
                    var ddd = '<option value="child_name">Select Enrollment_child_num</option>';
                    var demonew = $('#child_name').html(ddd);
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
                    var sign = data.sign;
                    for (si = 0; si < sign.length; si++) {
                        var sii = si + 1;
                        var sign_content = sign[si].additional_details;
                        tinymce.get('signature_' + sii).setContent(sign_content);
                    }
                })
                // 

            })
        } else {
            document.getElementById('initiated_by');
            var ddd = '<option value="initiated_by">Select Enrollment_child_num</option>';
            var demonew = $('#initiated_by').html(ddd);
        }
    };
</script>

<script type="text/javascript">
    function typechange(e) {
        var area_name = e.target.value;
        var order = e.target.getAttribute("order");




        if (area_name != "") {
            $.ajax({
                url: "{{ url('/areaname/master/ajax') }}",
                type: 'POST',

                data: {
                    'area_name': area_name,
                    _token: '{{csrf_token()}}'
                }


            }).done(function(data) {
                // var category_id = json.parse(data);
                // console.log(area_name);
                // console.log(data);

                if (data != '[]') {

                    var optionsdata;
                    var optionsdata2;

                    for (var i = 0; i < data.length; i++) {

                        var name = data[i]['recommended_environment']; //console.log(name);
                        var id = data[i]['recommendation_area_description_id'];
                        optionsdata += "<option value=" + id + " >" + name + "</option>";
                        var strategies = data[i]['strategies_recommended'];
                        optionsdata2 += "<option value=" + id + " >" + name + "</option>";

                    }

                    // var stageoption = option.concat(optionsdata);
                    var demonew = $(`#recommended_id${order}`).html(optionsdata);
                    // var stageoption2 = option2.concat(optionsdata2);
                    var demonew2 = $(`#strategies_id${order}`).html(optionsdata2);

                } else {
                    document.getElementById('child_name');
                    var ddd = '<option>No Data</option>';
                    var demonew = $('#child_name').html(ddd);
                }


                // for (i = 1; i < paTotal.length + 1; i++) {
                //     if (i != order) {
                //         console.log(i);
                //         var selectobject2 = document.getElementById("area_name"+order);
                //         if (selectobject2.options[i].value == area_name) {
                //             selectobject2.remove(i);
                //         }
                //     }
                // }

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

    var totalPage = <?php echo json_decode($totalPage) ?>;

    function openCity(stepNum) { //alert(stepNum);
        $('#page3').toggle(stepNum == 3);
        $('#page5').toggle(stepNum == 5);
        $('#page4').toggle(stepNum == 4);
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
        if (ret1 == 1) {
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
        // document.getElementById('swiper_prev').style.display = "none";
        // document.getElementById('r1').style.display = "none";
        // document.getElementById('r2').style.display = "none";
        // navcheck();
    });
    // function navcheck(){

    // }
</script>

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

        var words = textarea.value.trim().split(/\s+/); // Split text into an array of words
        var wordCount = words.length; // Count the number of words

        if (wordCount >= maxWords) {
            textarea.value = words.slice(0, maxWords).join(' '); // Truncate text to maxWords
            textarea.removeEventListener("input", checkWordCount);
            swal.fire("Info", "Note: Each column will hold a maximum of 100 words. If needed, for additional comments, use 'Notes-1,2,..'. If no notes column is available, contact IS Head/Manager.", "info");
        }

        var remainingWords = maxWords - wordCount;
        // console.log("Remaining words: " + remainingWords);
    }
</script>

@endsection