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
        <h5 class="text-center align" style="color:darkblue">Assessment Report</h5>
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
                            <div class="col-md-4"></div>
                            @foreach($enrollment_details as $key=>$row1)
                            <div class="col-md-4" id="a{{$row1['user_id']}}" style="display: none;margin: 0 0 0 85px;">
                                <div class="form-group">
                                    <a class="btn btn-info btn-lg" title="View Record" target="_blank" href="{{ route('sail.status.edit', \Crypt::encrypt($row1['getID']))}}">Records</a>
                                </div>
                            </div>
                            @endforeach
                            <div class="col-md-4"></div>
                        </div>
                    </div>
                </div>
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
                            <button class="swiper-slide tablinks" id="Tab{{$page['page']}}" onclick="openCity('{{$page['page']}}')">{{$page['tab_name']}}</button>
                            @else
                            <button class="swiper-slide tablinks" id="Tab{{$page['page']}}" onclick="openCity('{{$page['page']}}')">PAGE - {{$page['page']}}</button>
                            @endif
                            @endforeach

                        </div>
                    </div>
                    <!-- <div class="swiper-button-prev swipenav" onclick="swipeprev()" id="swiper_prev"></div> -->
                    <!-- <div class="swiper-button-next swipenav" onclick="swipenext()" id="swiper_next"></div> -->
                </div>
            </div>

        </div>
        <div id="r2">
            <form name="edit_form" action="{{ route('report.new')}}" method="POST" id="form_report">
                {{ csrf_field() }}
                <input type="hidden" id="state" name="state">
                <input type="hidden" id="enrollmentId" name="enrollmentId">
                <input type="hidden" value="{{$report[0]['reports_id']}}" name="reports_id" id="reports_id">
                <input type="hidden" id="currentPage" name="currentPage">
                <div class="row" style="    margin: 25px 0px 0px 0px;">
                    @foreach($pages as $page)
                    <div class="col-12">
                        <div id="card content">
                            <div id="Step{{$page['page']}}" class="card-body tabcontent paginationTab{{$page['page']}}">
                                <textarea class="meeting_description" page-order="{{$page['page']}}" id="meeting_description{{$loop->iteration}}" name="meeting_description[{{$page['page']}}]">
                                {{$page['page_description']}}
                                </textarea>
                                @if($page['assesment_skill_id'] != null)
                                @foreach($perskill as $perskills)
                                @if($perskills['performance_area_id'] == $page['assesment_skill_id'] && $perskills['skill_type'] == 1)
                                <div id="table{{$page['page']}}">
                                    <div class="table-responsive">
                                        <table class="table table-bordered card-body">
                                            <thead>
                                                <tr>
                                                    <th width="30%">{{$page['tab_name']}}</th>
                                                    <th width="30%">Observation</th>
                                                    <th width="40%">Evidence</th>
                                                </tr>
                                            </thead>
                                            <tbody id="tablebody{{$page['page']}}">
                                                <tr class="firstrow" draggable="true" ondragstart="dragit(event)" ondragover="dragover(event)" ondragend="reOrder()">
                                                    <td width="30%">
                                                        <select class="form-control default activitySelect activity{{$page['page']}}" id="activity{{$page['page']}}" name="activity[{{$page['assesment_skill_id']}}][]">
                                                            <option value="">Select</option>
                                                            @foreach($activitys as $activity)
                                                            @if($page['assesment_skill_id'] == $activity['performance_area_id'] && $activity['skill_type'] == 1)
                                                            <option value="{{$activity['activity_id']}}">{{$activity['activity_name']}}</option>
                                                            @endif
                                                            @endforeach
                                                        </select>
                                                    </td>
                                                    <td width="30%">
                                                        <select class="form-control default" name="observation[{{$page['assesment_skill_id']}}][]">
                                                            @foreach($observations as $observation)
                                                            @if($page['assesment_skill_id'] == $observation['performance_area_id'])
                                                            <option value="{{$observation['observation_id']}}">{{$observation['observation_name']}}</option>
                                                            @endif
                                                            @endforeach
                                                        </select>
                                                    </td>
                                                    <td style="display: flex;align-items: center;"><textarea style="height: 50px !important;" class="form-control default addProducttext{{$page['page']}}" name="evidence[{{$page['assesment_skill_id']}}][]"></textarea>
                                                        <div onclick="addProduct_aa(event)">
                                                            <a class="btn addProduct{{$page['page']}}" title="Add" order="{{$page['page']}}"><i class="fa fa-plus-circle" order="{{$page['page']}}"></i></a>
                                                        </div>
                                                        <a class="btn remove removeR" order="{{$page['page']}}" title="Add" id="removeProduct"><i class="fa fa-times" order="{{$page['page']}}"></i></a>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                @elseif($perskills['performance_area_id'] == $page['assesment_skill_id'] && $perskills['skill_type'] == 2)
                                <div class="table-responsive" id="table_a{{$page['page']}}">
                                    <table class="table table-bordered card-body">
                                        <thead>
                                            <tr>
                                                <th colspan="3" style="background-color: white !important;color: #141414;text-align: left;border: 1px solid #040404 !important;">{{$perskills['skill_name']}}</th>
                                            </tr>
                                        </thead>
                                        <tbody id="tablebody_a{{$page['page']}}">
                                            <tr class="firstrow">
                                                <td width="30%">
                                                    <select class="form-control default activitySelect activity_a{{$page['page']}}" name="activity[{{$page['assesment_skill_id']}}][]">
                                                        <option value="">Select</option>
                                                        @foreach($activitys as $activity)
                                                        @if($page['assesment_skill_id'] == $activity['performance_area_id'] && $activity['skill_type'] == 2)
                                                        <option value="{{$activity['activity_id']}}">{{$activity['activity_name']}}</option>
                                                        @endif
                                                        @endforeach
                                                    </select>
                                                </td>
                                                <td width="30%">
                                                    <select class="form-control default" name="observation[{{$page['assesment_skill_id']}}][]">
                                                        @foreach($observations as $observation)
                                                        @if($page['assesment_skill_id'] == $observation['performance_area_id'])
                                                        <option value="{{$observation['observation_id']}}">{{$observation['observation_name']}}</option>
                                                        @endif
                                                        @endforeach
                                                    </select>
                                                </td>
                                                <td style="display: flex;align-items: center;">
                                                    <textarea style="height: 50px !important;" class="form-control default addProducttext_a{{$page['page']}}" name="evidence[{{$page['assesment_skill_id']}}][]"></textarea>
                                                    <div onclick="addProduct(event)">
                                                        <a class="btn addProduct_a{{$page['page']}}" title="Add" order="{{$page['page']}}" id="addProduct_a{{$page['page']}}"><i class="fa fa-plus-circle" order="{{$page['page']}}" id="addProduct_a{{$page['page']}}"></i></a>
                                                    </div>
                                                    <a class="btn remove_a removeR" order="{{$page['page']}}" title="Add" id="removeProduct"><i class="fa fa-times" order="{{$page['page']}}"></i></a>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                @elseif($perskills['performance_area_id'] == $page['assesment_skill_id'] && $perskills['skill_type'] == 3)
                                <!--  -->
                                <div id="table{{$page['page']}}">
                                    <div class="table-responsive">
                                        <table class="table table-bordered card-body">
                                            <thead>
                                                <tr>
                                                    <th width="30%">{{$page['tab_name']}}</th>
                                                    <th width="30%">Observation</th>
                                                    <th width="40%">Evidence</th>
                                                </tr>
                                            </thead>
                                        </table>
                                    </div>
                                </div>
                                @foreach($subskill as $sskill)
                                @if($page['assesment_skill_id'] == $sskill['performance_area_id'])
                                <div class="table-responsive" id="table_b{{$sskill['skill_id']}}">
                                    <table class="table table-bordered card-body">
                                        <thead>
                                            <tr>
                                                <th colspan="3" style="background-color: white !important;color: #141414;text-align: left;border: 1px solid #040404 !important;">{{$sskill['skill_name']}}</th>
                                            </tr>
                                        </thead>
                                        <tbody id="tablebody_b{{$sskill['skill_id']}}">
                                            <tr class="firstrow">
                                                <td width="30%">
                                                    <select class="form-control default activitySelect activity_c{{$sskill['skill_id']}}" name="activity[{{$page['assesment_skill_id']}}][]">
                                                        <option value="">Select</option>
                                                        @foreach($activitys as $activity)
                                                        @if($sskill['skill_id'] == $activity['sub_skill'])
                                                        <option value="{{$activity['activity_id']}}">{{$activity['activity_name']}}</option>
                                                        @endif
                                                        @endforeach
                                                    </select>
                                                </td>
                                                <td width="30%">
                                                    <select class="form-control default" name="observation[{{$page['assesment_skill_id']}}][]">
                                                        @foreach($observations as $observation)
                                                        @if($page['assesment_skill_id'] == $observation['performance_area_id'])
                                                        <option value="{{$observation['observation_id']}}">{{$observation['observation_name']}}</option>
                                                        @endif
                                                        @endforeach
                                                    </select>
                                                </td>
                                                <td style="display: flex;align-items: center;">
                                                    <textarea style="height: 50px !important;" class="form-control default addProducttext_b{{$sskill['skill_id']}}" name="evidence[{{$page['assesment_skill_id']}}][]"></textarea>
                                                    <div onclick="addProduct_b(event)">
                                                        <a class="btn addProduct_b{{$sskill['skill_id']}}" title="Add" order="{{$page['page']}}" table="{{$sskill['skill_id']}}" id="addProduct_b{{$sskill['skill_id']}}"><i class="fa fa-plus-circle" order="{{$page['page']}}" table="{{$sskill['skill_id']}}" id="addProduct_b{{$sskill['skill_id']}}"></i></a>
                                                    </div>
                                                    <a class="btn remove_b removeR" order="{{$page['page']}}" table="{{$sskill['skill_id']}}" title="Add" id="removeProduct"><i class="fa fa-times" order="{{$page['page']}}" table="{{$sskill['skill_id']}}"></i></a>
                                                </td>
                                            </tr>
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
                    <!-- Page 8 -->
                    <div class="col-12 scrollable fixTableHead title-padding" style="display: none;" id="page8">
                        <div class="table-responsive">
                            <table class="table table-bordered card-body" id="main2">
                                <thead>
                                    <tr>
                                        <th>Seeks out and is attracted to a stimulating sensory environment</th>
                                        <th>Distressed by a stimulating sensory environment and attemptsto leave the environment</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($page8 as $table8)
                                    <tr id="row2">
                                        <td><textarea class="form-control row2C row_loop default" row-loop-id="[row{{$loop->iteration}}][1]" name="rows2[row{{$loop->iteration}}][1]">{{$table8['sensory_profiling1']}}</textarea></td>
                                        <td style="display: flex;align-items: center;"><textarea class="form-control row_loop default" row-loop-id="[row{{$loop->iteration}}][2]" name="rows2[row{{$loop->iteration}}][2]">{{$table8['sensory_profiling2']}}</textarea>
                                            <div onclick="removeRow(this)"><a class="btn" title="Remove"><i class="fa fa-times"></i></a></div>
                                        </td>
                                    </tr>
                                    @endforeach
                                    <tr>
                                        <td colspan="2">
                                            <input id='add-row' class='btn btn-primary' onclick="addRow2(event)" type='button' value='Add' />
                                            <!-- <a class="btn" onclick="addRow2(event)" title="Add"><i class="fa fa-plus-circle"></i> Add </a> -->
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
                <a type="button" onclick="save('Submitted')" id="submitbutton" class="btn btn-labeled btn-succes" title="Publish" style="background: orange !important; color:white !important">
                    <span class="btn-label" style="font-size:13px !important;"><i class="fa fa-check"></i></span> Submit</a>
                <a type="button" onclick="save('Saved')" id="submitbutton" class="btn btn-labeled btn-succes" title="Save" style="background: green !important; border-color:green !important; color:white !important">
                    <span class="btn-label" style="font-size:13px !important;"><i class="fa fa-check"></i></span> Save</a>
                <a type="button" class="btn btn-labeled back-btn" title="Back" href="{{ route('assessmentreport.index') }}" style="color:white !important">
                    <span class="btn-label" style="font-size:13px !important;"><i class="fa fa-arrow-left"></i></span> Back</a>
                <a type="button" class="btn btn-labeled btn-info" onclick="NextTab();" id="Next" title="Next" style="background: blue !important; border-color:#4d94ff !important; color:white !important;height: 35px;">
                    <span class="btn-label" style="font-size:13px !important;">Next</span> <i class="fa fa-arrow-right"></i></a>
            </div>
        </div>
    </div>
</div>
<script>
    function addProduct(e) {

        var order = e.target.getAttribute("order");
        var $TABLE = $('#table_a' + order);
        var $clone = $TABLE.find('tr:eq(1)').clone(true);
        let allchecked1 = [];
        $(".activity_a" + order).each(function() {
            allchecked1.push($(this).val());
        });
        $('option:selected', $clone).prop("selected", false);
        $('#tablebody_a' + order).append($clone);
        var c = $('#tablebody_a' + order).find('tr').length;

        $(".activitySelect").each(function() {
            //console.log('activitySelect');
            var prevValue = $(this).data('previous');
            var validate = allchecked1.includes(prevValue);
            if (validate == false) {
                $('.activitySelect').not(this).find('option[value="' + prevValue + '"]').show();
            }
            var value = $(this).val();
            $(this).data('previous', value);
            $('.activitySelect').not(this).find('option[value="' + value + '"]').hide();
        });

        var oldActive1 = document.querySelectorAll('.addProducttext_a' + order);
        for (var i = 0; i < oldActive1.length; i++) {
            min = i + 1;
            max = oldActive1.length;
            if (c == min) {
                oldActive1[i].value = "";
            }
        }

        var oldActive = document.querySelectorAll('.addProduct_a' + order);
        for (var i = 0; i < oldActive.length; i++) {
            min = i + 1;
            max = oldActive.length;
            if (c == min) {
                oldActive[i].classList.remove("addR");
            }
        }

        for (var i = 0; i < oldActive.length; i++) {
            min = i + 1;
            max = oldActive.length;
            if (min != max) {
                oldActive[i].classList.add("addR");
            }
        }
    }

    function addProduct_b(e) {
        var order = e.target.getAttribute("table");
        var $TABLE = $('#table_b' + order);
        var $clone = $TABLE.find('tr:eq(1)').clone(true);
        let allchecked2 = [];
        $(".activity_c" + order).each(function() {
            allchecked2.push($(this).val());
        });
        $('option:selected', $clone).prop("selected", false);
        $('#tablebody_b' + order).append($clone);
        var c = $('#tablebody_b' + order).find('tr').length;

        $(".activitySelect").each(function() {
            //console.log('activitySelect');
            var prevValue = $(this).data('previous');
            var validate = allchecked2.includes(prevValue);
            if (validate == false) {
                $('.activitySelect').not(this).find('option[value="' + prevValue + '"]').show();
            }
            var value = $(this).val();
            $(this).data('previous', value);
            $('.activitySelect').not(this).find('option[value="' + value + '"]').hide();
        });

        var oldActive1 = document.querySelectorAll('.addProducttext_b' + order);
        for (var i = 0; i < oldActive1.length; i++) {
            min = i + 1;
            max = oldActive1.length;
            if (c == min) {
                oldActive1[i].value = "";
            }
        }

        var oldActive = document.querySelectorAll('.addProduct_b' + order);
        for (var i = 0; i < oldActive.length; i++) {
            min = i + 1;
            max = oldActive.length;
            if (c == min) {
                oldActive[i].classList.remove("addR");
            }
        }

        for (var i = 0; i < oldActive.length; i++) {
            min = i + 1;
            max = oldActive.length;
            if (min != max) {
                oldActive[i].classList.add("addR");
            }
        }
    }
    $(document).ready(function() {
        $('.activitySelect').on('change', function(event) {
            var prevValue = $(this).data('previous');
            $('.activitySelect').not(this).find('option[value="' + prevValue + '"]').show();
            var value = $(this).val();
            $(this).data('previous', value);
            $('.activitySelect').not(this).find('option[value="' + value + '"]').hide();
        });
    });

    function addProduct_aa(e) {
        var order = e.target.getAttribute("order");
        var $TABLE = $('#table' + order);

        var $clone = $TABLE.find('tr:eq(1)').clone(true).removeClass('firstrow');
        $('option:selected', $clone).prop("selected", false);
        $('#tablebody' + order).append($clone);
        var c = $('#tablebody' + order).find('tr').length;
        let allchecked = [];
        $(".activity" + order).each(function() {
            allchecked.push($(this).val());
        });
        $(".activitySelect").each(function() {
            //console.log('activitySelect');
            var prevValue = $(this).data('previous');
            var validate = allchecked.includes(prevValue);
            if (validate == false) {
                $('.activitySelect').not(this).find('option[value="' + prevValue + '"]').show();
            }
            var value = $(this).val();
            $(this).data('previous', value);
            $('.activitySelect').not(this).find('option[value="' + value + '"]').hide();
        });

        var oldActive1 = document.querySelectorAll('.addProducttext' + order);
        for (var i = 0; i < oldActive1.length; i++) {
            min = i + 1;
            max = oldActive1.length;
            if (c == min) {
                oldActive1[i].value = "";
            }
        }

        var oldActive = document.querySelectorAll('.addProduct' + order);
        for (var i = 0; i < oldActive.length; i++) {
            min = i + 1;
            max = oldActive.length;
            if (c == min) {
                oldActive[i].classList.remove("addR");
            }
        }

        for (var i = 0; i < oldActive.length; i++) {
            min = i + 1;
            max = oldActive.length;
            if (min != max) {
                oldActive[i].classList.add("addR");
            }
        }

    }
    $(document).ready(function() {

        var allpro = <?php echo json_encode($pages); ?>;
        $('.remove').click(function(e) {
            var order = e.target.getAttribute("order");
            var check = document.querySelectorAll('.addProduct' + order).length;
            var sel = $(this).parent().parent().find('.activitySelect');
            var selVal = sel.val();
            var selectedOptionHtml = sel.find('option').filter(':selected').removeAttr("selected").prop('outerHTML');
            if (check > 1) {
                $(this).parents('tr').remove();
                $(this).parents('tbody').length;
                var $TABLE = $('#table' + order);
                if (selVal != '') {
                    var $clone = $TABLE.find('.activitySelect');
                    $clone.find('option[value="' + selVal + '"]').show();
                    // $clone.append(selectedOptionHtml);
                }
                var c = $('#tablebody' + order).find('tr').length;
                var oldActive = document.querySelectorAll('.addProduct' + order); //console.log(oldActive.length);
                let allchecked_a = [];
                $(".activity" + order).each(function() {
                    allchecked_a.push($(this).val());
                });
                $(".activitySelect").each(function() {
                    //console.log('activitySelect');
                    var prevValue = $(this).data('previous');
                    var validate = allchecked_a.includes(prevValue);
                    if (validate == false) {
                        $('.activitySelect').not(this).find('option[value="' + prevValue + '"]').show();
                    }
                    var value = $(this).val();
                    $(this).data('previous', value);
                    $('.activitySelect').not(this).find('option[value="' + value + '"]').hide();
                });

                for (var i = 0; i < oldActive.length; i++) {
                    min = i + 1;
                    max = oldActive.length;
                    if (c != max) {
                        oldActive[i].classList.add("addR");
                    }
                }

                for (var i = 0; i < oldActive.length; i++) {
                    min = i + 1;
                    max = oldActive.length;
                    if (min == max) {
                        oldActive[i].classList.remove("addR");
                    }
                }
            } else {
                swal.fire("Required One Row", "", "error");
            }

        });

        $('.remove_a').click(function(e) {
            var order = e.target.getAttribute("order");
            var checka = document.querySelectorAll('.addProduct_a' + order).length;
            var sel = $(this).parent().parent().find('.activitySelect');
            var selVal = sel.val();
            var selectedOptionHtml = sel.find('option').filter(':selected').removeAttr("selected").prop('outerHTML');
            if (checka > 1) {
                $(this).parents('tr').remove();
                $(this).parents('tbody').length;

                var $TABLE = $('#table_a' + order);
                if (selVal != '') {
                    var $clone = $TABLE.find('.activitySelect');
                    $clone.find('option[value="' + selVal + '"]').show();
                    // $clone.append(selectedOptionHtml);
                }
                let allchecked_b = [];
                $(".activity_a" + order).each(function() {
                    allchecked_b.push($(this).val());
                });
                var c = $('#tablebody_a' + order).find('tr').length;
                var oldActive = document.querySelectorAll('.addProduct_a' + order); //console.log(oldActive.length);
                $(".activitySelect").each(function() {
                    //console.log('activitySelect');
                    var prevValue = $(this).data('previous');
                    var validate = allchecked_b.includes(prevValue);
                    if (validate == false) {
                        $('.activitySelect').not(this).find('option[value="' + prevValue + '"]').show();
                    }
                    var value = $(this).val();
                    $(this).data('previous', value);
                    $('.activitySelect').not(this).find('option[value="' + value + '"]').hide();
                });

                for (var i = 0; i < oldActive.length; i++) {
                    min = i + 1;
                    max = oldActive.length;
                    if (c != max) {
                        oldActive[i].classList.add("addR");
                    }
                }

                for (var i = 0; i < oldActive.length; i++) {
                    min = i + 1;
                    max = oldActive.length;
                    if (min == max) {
                        oldActive[i].classList.remove("addR");
                    }
                }
            } else {
                swal.fire("Required One Row", "", "error");
            }

        });

        $('.remove_b').click(function(e) {
            var order = e.target.getAttribute("table");
            var checkb = document.querySelectorAll('.addProduct_b' + order).length;
            var sel = $(this).parent().parent().find('.activitySelect');
            var selVal = sel.val();
            var selectedOptionHtml = sel.find('option').filter(':selected').removeAttr("selected").prop('outerHTML');
            if (checkb > 1) {
                $(this).parents('tr').remove();
                $(this).parents('tbody').length;

                var $TABLE = $('#table_b' + order);
                if (selVal != '') {
                    var $clone = $TABLE.find('.activitySelect');
                    $clone.find('option[value="' + selVal + '"]').show();
                    // $clone.append(selectedOptionHtml);
                }
                var c = $('#tablebody_b' + order).find('tr').length;
                var oldActive = document.querySelectorAll('.addProduct_b' + order); //console.log(oldActive.length);
                
                let allchecked_c = [];
                $(".activity_c" + order).each(function() {
                    allchecked_c.push($(this).val());
                });
                $(".activitySelect").each(function() {
                    //console.log('activitySelect');
                    var prevValue = $(this).data('previous');
                    var validate = allchecked_c.includes(prevValue);
                    if (validate == false) {
                        $('.activitySelect').not(this).find('option[value="' + prevValue + '"]').show();
                    }
                    var value = $(this).val();
                    $(this).data('previous', value);
                    $('.activitySelect').not(this).find('option[value="' + value + '"]').hide();
                });

                for (var i = 0; i < oldActive.length; i++) {
                    min = i + 1;
                    max = oldActive.length;
                    if (c != max) {
                        oldActive[i].classList.add("addR");
                    }
                }

                for (var i = 0; i < oldActive.length; i++) {
                    min = i + 1;
                    max = oldActive.length;
                    if (min == max) {
                        oldActive[i].classList.remove("addR");
                    }
                }
            } else {
                swal.fire("Required One Row", "", "error");
            }

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
        document.getElementById('form_report').submit();

    }

    // function temp_save(a) {
    //     // if (document.getElementById('enrollment_child_num').value == "") {
    //     //     swal.fire("Please Select Enrolment Number", "", "error");
    //     //     return false;
    //     // }
    //     // document.getElementById('state').value = a;

    //     var state = a;
    //     var enrollmentId = document.getElementById('enrollment_child_num').value;
    //     var meeting_description = [];
    //     $(".meeting_description").each(function() {
    //         meeting_description[$(this).attr('page-order')] = $(this).val();
    //     });
    //     var reports_id = document.getElementById('reports_id').value;
    //     var rows2 = [];
    //     $(".row_loop").each(function() {
    //         // console.log($(this).attr('row-loop-id'));
    //         rows2[$(this).attr('row-loop-id')] = $(this).val();
    //     });
    //     console.log(rows2);

    //     // const element = document.getElementById("row2");
    //     // const idLength = element.id.length;
    //     // console.log(idLength);
    //     // var rows2 = [];
    //     // for (let rows_loop = 1; rows_loop < idLength + 1; rows_loop) {
    //     //     window["row" + rows_loop];
    //     //     $(".row_loop" + rows_loop).each(function() {
    //     //         var loop = $(this).attr('row-loop-id');
    //     //         window["row" + rows_loop][loop] = $(this).val();
    //     //     });
    //     //     rows2.push(window["row" + rows_loop]);
    //     // }
    //     // console.log(rows2);

    //     $.ajax({
    //         url: "{{ url('/report/assessment/new/store/auto') }}",
    //         type: 'POST',
    //         data: {
    //             'state': state,
    //             'enrollmentId': enrollmentId,
    //             'dataForm': rows2,
    //             _token: '{{csrf_token()}}'
    //         }
    //     }).done(function(data) {

    //     })

    // }

    function addRow2() {
        var table = document.getElementById("main2");
        var row = document.getElementById("row2");
        var rws = table.rows;
        var rowlength = rws.length;
        var cols = table.rows[0].cells.length;
        var row = table.insertRow(rws.length - 1);
        var cell;
        for (var i = 0; i < cols; i++) {
            cell = row.insertCell(i);
            j = i + 1;
            if (j == 1) {
                cell.innerHTML = '<textarea class="form-control row_loop row2C default" name="rows2[row' + rowlength + '][' + j + ']"></textarea>';
            }
            if (j == 2) {
                cell.style.cssText = "display: flex;align-items: center;";
                cell.innerHTML = '<textarea class="form-control row_loop default" name="rows2[row' + rowlength + '][' + j + ']"></textarea> <div onclick="removeRow(this)"><a class="btn" title="Remove"><i class="fa fa-times"></i></a></div>';
            }
        }
    }

    function removeRow(button) {
        var rowlength = $('.row2C').length - 1;
        console.log(rowlength);
        if (rowlength == 0) {
            swal.fire("Required One Row", "", "error");
        } else {
            button.closest('tr').remove();
        }
    }
</script>
<script>
    $(document).ready(function() {

        var pages = <?php echo json_encode($pages); ?>;
        for (p = 0; p < pages.length; p++) {
            var k = p + 1;
            tinymce.init({
                selector: 'textarea#meeting_description' + k,
                height: 400,
                max_chars: 10,
                menubar: false,
                branding: false,
                statusbar: false,
                plugins: 'searchreplace',
                toolbar: 'undo redo | formatselect | ' +
                    'bold italic backcolor | alignleft aligncenter ' +
                    'alignright alignjustify | bullist numlist outdent indent | ' +
                    'removeformat | searchreplace',
                content_style: 'body { font-family:Helvetica,Arial,sans-serif; font-size:14px }',
            });
        }
    });
</script>
<script type="text/javascript">
    var page6che = '1';

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
                    // document.getElementById('meeting_to').value = data[0].child_contact_email;
                    document.getElementById('enrollment_id').value = data[0].enrollment_id;
                    document.getElementById('user_id').value = data[0].user_id;

                    // console.log(data)
                    var user_id = data[0].user_id;
                    $('#a' + user_id).show();
                    // 
                    $.ajax({
                        url: "{{ url('/sensory/enrollmentlist') }}",
                        type: 'POST',
                        data: {
                            'enrollment_child_num': enrollment_child_num,
                            _token: '{{csrf_token()}}'
                        }
                    }).done(function(data) {
                        // var category_id = json.parse(data);
                        // console.log(data);

                        if (data != '[]') {
                            var qu1 = "";
                            var qu2 = "";
                            var qu3 = "";
                            var qu4 = "";
                            var quc1 = 0;
                            var quc2 = 0;
                            var quc3 = 0;
                            var quc4 = 0;
                            for (var i = 0; i < data.length; i++) {
                                var quadrant_type = data[i]['quadrant']; //console.log(quadrant_type);
                                var question = data[i]['question'];
                                if (quadrant_type == 'SEEKING') {
                                    quc1++;
                                    if (quc1 < 10)
                                        qu1 += '<li style="float: left;">' + question + '</li><br>';
                                }
                                if (quadrant_type == 'AVOIDING') {
                                    quc2++;
                                    if (quc2 < 10)
                                        qu2 += '<li style="float: left;">' + question + '</li><br>';
                                }
                                if (quadrant_type == 'SENSITIVITY') {
                                    quc3++;
                                    if (quc3 < 10)
                                        qu3 += '<li style="float: left;">' + question + '</li><br>';
                                }
                                if (quadrant_type == 'REGISTRATION') {
                                    quc4++;
                                    if (quc4 < 10)
                                        qu4 += '<li style="float: left;">' + question + '</li><br>';
                                }
                            }
                            var demonew1 = $('#qu1').append(qu1);
                            var demonew2 = $('#qu2').append(qu2);
                            var demonew3 = $('#qu3').append(qu3);
                            var demonew4 = $('#qu4').append(qu4);
                            var page6che = '2';

                        }


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
        if (stepNum == 6) {
            $('#page8').show();
        } else {
            $('#page8').hide();
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
    let shadow

    function dragit(event) {
        shadow = event.target;
    }

    function dragover(e) {
        let children = Array.from(e.target.parentNode.parentNode.children);
        if (children.indexOf(e.target.parentNode) > children.indexOf(shadow))
            e.target.parentNode.after(shadow);
        else
            e.target.parentNode.before(shadow);
    }

    function reOrder() {
        document.querySelectorAll(".myTable > tbody > tr > td:first-child").forEach(function(elem, index) {
            elem.innerHTML = (index + 1);
        });
    }
</script>
@endsection