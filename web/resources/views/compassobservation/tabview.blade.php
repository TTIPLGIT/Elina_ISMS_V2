@extends('layouts.adminnav')

@section('content')
<!-- <link rel="stylesheet" href="https://pagination.js.org/dist/2.5.0/pagination.css">
<script src="https://pagination.js.org/dist/2.5.0/pagination.js"></script> -->
<style>
    .nav-link {
        padding-right: 79px;
    }

    #frname {
        color: red;
    }

    .form-control {
        background-color: #ffffff !important;
    }

    .is-coordinate {
        justify-content: center;
    }


    .centerid {
        width: 100%;
        text-align: center;
    }

    #invite {
        display: none;
    }

    #co_one,
    #co_two {
        padding: 0 0 0 5px;
        background: transparent;
    }

    #tabs {
        overflow: hidden;
        width: 100%;
        margin: 0;
        flex-wrap: nowrap;
        padding: 0;
        list-style: none;
        font-size: 16px !important;

    }

    #tabs::-webkit-scrollbar {
        /* width: 10px; */
        height: 4px !important;
    }

    #tabs::-webkit-scrollbar-track {
        background-color: lightcyan !important;
    }

    #tabs::-webkit-scrollbar-thumb {
        box-shadow: inset 0 0 6px rgba(0, 0, 0, 0.3);
    }

    .wholecheck {
        animation: fadeInAnimation ease 1s;
        animation-iteration-count: 1;
        animation-fill-mode: forwards;
    }

    @keyframes fadeInAnimation {
        0% {
            opacity: 0;
        }

        100% {
            opacity: 1;
        }
    }

    #tabs li {
        float: left;
        margin: 0 .5em 0 0;

    }

    #tabs a {
        color: white !important;
        position: relative;
        background: #8D3F81;
        /* background-image: linear-gradient(to bottom, #1c92d2, #f2fcfe); */
        float: left;
        text-decoration: none;
        color: #444;
        text-shadow: 0 1px 0 rgba(255, 255, 255, .8);
        border-radius: 5px 0 0 0;
        box-shadow: 0 2px 2px rgba(0, 0, 0, .4);
    }

    #tabs a:hover,
    #tabs a:hover::after,
    #tabs a:focus,
    #tabs a:focus::after {
        background: #a9cadb;
    }

    #tabs a:focus {
        outline: 0;
    }

    .nav-items.navv.active a::after {
        /* background-color: #3e86bd !important; */
        background-color: lime !important;
    }

    #tabs a::after {
        content: '';
        position: absolute;
        z-index: 1;
        top: 0;
        right: -.5em;
        bottom: 0;
        width: 1em;
        background: #8D3F81;
        /* background-image: linear-gradient(to bottom, #1c92d2, #f2fcfe); */
        box-shadow: 2px 2px 2px rgba(0, 0, 0, .4);
        transform: skew(10deg);
        border-radius: 0 5px 0 0;
    }

    #tabs #current a,
    #tabs #current a::after {
        background: #265077;
        z-index: 3;
        color: white !important;

    }

    #tabs .strengthtab a::after {
        background: #265077;
        z-index: 3;
        color: white !important;

    }

    .observation {
        line-height: 12px !important;
    }

    #record {
        display: flex;
        accent-color: white;
        width: 33px;
        height: 35px;

    }

    #evidence {
        display: flex;
        flex-direction: column;
        align-items: center;
    }

    .week1 {
        position: relative;
        background-color: #8D3F81;
        border: 1px solid transparent;
        border-radius: 5px 20px 5px 5px;
        color: #fff;
        padding: 10px 20px;

        font-size: 16px !important;
        font-weight: 900 !important;
        cursor: pointer;
        outline: 0;
        margin-right: 19px;
    }

    .week1::after {
        content: '';
        position: absolute;
        z-index: 1;
        top: -1px;
        right: -6px;
        bottom: 0;
        width: 1em;
        background: #8D3F81;
        /* background-image: linear-gradient(to bottom, #1c92d2, #f2fcfe); */
        box-shadow: 2px 2px 2px rgba(0, 0, 0, .4);
        transform: skew(10deg);
        border-radius: 0 5px 0 0;
    }

    .active-btn {
        background-color: #8D3F81 !important;
        box-shadow: none !important;
    }

    .active-btn:focus {
        background-color: #8D3F81 !important;
        box-shadow: none !important;

    }

    .btn-info {
        border-color: none !important;
    }

    .nav-link.active {
        background-color: lime !important;


    }

    a b {
        pointer-events: none;
    }

    .btn.previous_btn_tab,
    .next_btn_tab {
        font-weight: 900;
        font-size: larger;
        font-size: 23px !important;
        background-color: lightpink;
    }

    .btn_whole {
        display: flex;
        width: 99%;
        position: relative;
        justify-content: space-between;
        top: -4px;
        z-index: 100;
    }
</style>

<style>
    html {
        -webkit-font-smoothing: antialiased !important;
        -moz-osx-font-smoothing: grayscale !important;
        -ms-font-smoothing: antialiased !important;
    }



    .md-stepper-horizontal {
        display: table;
        width: 100%;
        margin: 0 auto;
        background-color: transparent;
        /* box-shadow: 0 3px 8px -6px rgba(0,0,0,.50); */
    }

    .md-stepper-horizontal .md-step {
        display: table-cell;
        position: relative;
        padding: 24px;
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

    .md-stepper-horizontal .md-step:hover .md-step-circle {
        background-color: #757575;
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

    .md-stepper-horizontal .md-step.active.done .md-step-title,
    .md-stepper-horizontal .md-step.active.editable .md-step-title {
        font-weight: 600;
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
        height: 1px;
        border-top: 1px solid #DDDDDD;
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

    .swiper-button-prev {
        margin: -33px 0px 0px 25px !important;
        background-image: url('/images/arrowL.png') !important;
    }

    .swiper-button-prev,
    .swiper-container-rtl .swiper-button-next {
        left: 9px;
        right: auto;
        top: 50px;
    }

    .swiper-button-next,
    .swiper-container-rtl .swiper-button-prev {
        right: 10px;
        left: auto;
        top: 44px;
    }
</style>
<div class="main-content" style="position:absolute !important; z-index: -2!important; ">

    <!-- Main Content -->
    <section class="section">

        {{ Breadcrumbs::render('monthlytab') }}

        <div class="section-body mt-1">
        <div class="row">
                        <div class="col-lg-12 text-center">
                            <h4 style="color:darkblue;">Weekly Observation View</h4>
                        </div>
                    </div>


            <!-- <h5 class="text-center" style="color:darkblue">Home Tracker Initiate</h5> -->
            <div class="row">
                <div class="col-12">

                    <div class="card">
                        <div class="card-body">

                            <!-- <form method="POST" action="{{ route('ovm1.store') }}" onsubmit="return validateForm()"> -->
                            <form action="{{route('monthlytab')}}" method="GET" id="compassobservation" enctype="multipart/form-data">

                                @csrf
                                <div class="row is-coordinate">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="control-label">Enrollment ID<span class="error-star" style="color:red;">*</span></label>
                                            <input class="form-control default" type="text" id="enrollment_child_num" name="enrollment_child_num" onchange="GetChilddetails()" value="EN/2022/12/025 (Kaviya)" autocomplete="off" style="background-color: rgb(128 128 128 / 34%) !important;" readonly>

                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="control-label">Child ID</label>
                                            <input class="form-control default" type="text" id="child_id" name="child_id" placeholder="Child ID" autocomplete="off" value="CH/2022/025" style="background-color: rgb(128 128 128 / 34%) !important;" readonly>
                                            <!-- <input type="hidden" id="enrollment_id" name="enrollment_id" autocomplete="off" readonly> -->
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="control-label">Child Name</label>
                                            <input class="form-control default" type="text" id="child_name" name="child_name" oninput="Childname(event)" maxlength="20" value="Kaviya" style="background-color: rgb(128 128 128 / 34%) !important;" autocomplete="off" readonly>
                                        </div>
                                    </div>






                                    <div class="form-group row">
                                        <div class="col-md-4">
                                            <label class="control-label">Month</label>
                                            <div style="display: flex;">
                                                <input class="form-control" type="text" id="month" name="month" value="Month1 12-2022" style="background-color: rgb(128 128 128 / 34%) !important;" readonly autocomplete="off">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <label class="control-label">Status</label>
                                            <div style="display: flex;">
                                                <input class="form-control" type="text" id="Status" name="Status" value="InProgress" style="background-color: rgb(128 128 128 / 34%) !important;" readonly autocomplete="off">
                                            </div>
                                        </div>

                                    </div>
                                </div>
                        </div>
                    </div>
                </div>
                <br>

            </div>

            <br>
            <div class="offset-9 col-3">

                <a type="button" onclick="send()" id="submitbutton" class="btn btn-labeled btn-succes" title="Sent" style="background-color:green !important;color:white !important;">
                    <span class="btn-label" style="font-size:13px !important;"><i class="fa fa-calendar"></i></span>Monthly Observation</a>
            </div>

            <!-- <div id="calendar"></div> -->


            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-12">
                                    <div class="swiper-button-prev swipenav" onclick="previousnexttab(event)" id="swiper_prev" tabindex="0" role="button" aria-label="Previous slide" aria-disabled="false" style="display: block;"></div>
                                    <div class="swiper-button-next swipenav" onclick="previousnexttab(event)" id="swiper_next" tabindex="0" role="button" aria-label="Next slide" aria-disabled="false" style="display: block;"></div>


                                    <div class="md-stepper-horizontal col-8 ">

                                        <div class="md-step active" value='1' name="tab_1" onclick="ticker(1)">

                                            <div class="md-step-circle"><span>1</span></div>
                                            <div class="md-step-bar-left"></div>
                                            <div class="md-step-bar-right"></div>


                                        </div>
                                        <div class="md-step" value='2' name="tab_2" onclick="ticker(2)">
                                            <div class="md-step-circle"><span>2</span></div>
                                            <div class="md-step-bar-left"></div>
                                            <div class="md-step-bar-right"></div>

                                        </div>
                                        <div class="md-step" value='3' name="tab_3" onclick="ticker(3)">
                                            <div class="md-step-circle"><span>3</span></div>
                                            <div class="md-step-bar-left"></div>
                                            <div class="md-step-bar-right"></div>

                                        </div>
                                        <div class="md-step" value='4' name="tab_4" onclick="ticker(4)">
                                            <div class="md-step-circle"><span>4</span></div>
                                            <div class="md-step-bar-left"></div>
                                            <div class="md-step-bar-right"></div>

                                        </div>
                                        <div class="md-step" value='5' name="tab_5" onclick="ticker(5)">
                                            <div class="md-step-circle"><span>5</span></div>
                                            <div class="md-step-bar-left"></div>
                                            <div class="md-step-bar-right"></div>

                                        </div>
                                        <div class="md-step" value='6' name="tab_6" onclick="ticker(6)">
                                            <div class="md-step-circle"><span>6</span></div>
                                            <div class="md-step-bar-left"></div>
                                            <div class="md-step-bar-right"></div>

                                        </div>
                                        <div class="md-step" value='7' name="tab_7" onclick="ticker(7)">
                                            <div class="md-step-circle"><span>7</span></div>
                                            <div class="md-step-bar-left"></div>
                                            <div class="md-step-bar-right"></div>

                                        </div>
                                        <div class="md-step" value='8' name="tab_8" onclick="ticker(8)">
                                            <div class="md-step-circle"><span>8</span></div>
                                            <div class="md-step-bar-left"></div>
                                            <div class="md-step-bar-right"></div>

                                        </div>
                                        <div class="md-step" value='9' name="tab_9" onclick="ticker(9)">
                                            <div class="md-step-circle"><span>9</span></div>
                                            <div class="md-step-bar-left"></div>
                                            <div class="md-step-bar-right"></div>
                                        </div>
                                        <div class="md-step" value='10' name="tab_10" onclick="ticker(10)">
                                            <div class="md-step-circle"><span>10</span></div>
                                            <div class="md-step-bar-left"></div>
                                            <div class="md-step-bar-right"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>


                            <div class="tile" id="tile-1" style="margin-top:10px !important; margin-bottom:15px !important;">

                                <!-- Nav tabs -->
                                <!-- <div class="btn_whole">
                                    <div class="row">
                                        <div class="col-11">
                                            <button class="btn previous_btn_tab d-none" onclick="tabnavigation(event)">
                                                < </button>

                                        </div>
                                        <div class="col">
                                            <button class="btn next_btn_tab " onclick="ticker(event)">></button>

                                        </div>
                                    </div>


                                </div> -->
                                <ul class="nav nav-tabs nav-justified observation" id="tabs" role="tablist">

                                    <li class="nav-items navv active" class="active" id="tab_1" style="flex-basis: 1 !important;">
                                        <a class="nav-link active " id="home-tab" name="tab1" data-toggle="tab" role="tab" aria-controls="home" aria-selected="true" class="strengthtab"><b>Strength</b><i class="fa fa-check" aria-hidden="true" id="tab1tick" name="step_value1" style="display:none;"></i><input type="checkbox" class="checkg" id="profile" name="nationality" value="0" onchange="submitval(this)" readonly style="background-color:solid green !important; color:green !important; visibility:hidden !important; ">
                                            <input type="hidden" id="step_value" value="no">
                                            <div class="check"></div>
                                        </a>

                                    </li>



                                    <li class="nav-items navv" class="active" id="tab_2" style="flex-basis: 1 !important;">
                                        <a class="nav-link  " id="home-tab" name="tab2" data-toggle="tab" role="tab" aria-controls="home" aria-selected="true"><b>Stretches</b><i class="fa fa-check" aria-hidden="true" id="tab2tick" name="step_value1" style="display:none;"></i><input type="checkbox" class="checkg" id="profile" name="nationality" value="0" onchange="submitval(this)" readonly style="background-color:solid green !important; color:green !important; visibility:hidden !important; ">
                                            <input type="hidden" id="step_value2" value="">

                                            <div class="check"></div>
                                        </a>
                                    </li>
                                    <li class="nav-items navv" class="active" id="tab_3" style="flex-basis: 1 !important;">
                                        <a class="nav-link  " id="home-tab" name="tab3" data-toggle="tab" role="tab" aria-controls="home" aria-selected="true"><b>Opportunities</b><i class="fa fa-check" aria-hidden="true" id="tab3tick" name="step_value1" style="display:none;"></i><input type="checkbox" class="checkg" id="profile" name="nationality" value="0" onchange="submitval(this)" readonly style="background-color:solid green !important; color:green !important; visibility:hidden !important; ">
                                            <input type="hidden" id="step_value3" value="">
                                            <div class="check"></div>
                                        </a>
                                    </li>
                                    <li class="nav-items navv" class="active" id="tab_4" style="flex-basis: 1 !important;">
                                        <a class="nav-link  " id="home-tab" name="tab4" data-toggle="tab" role="tab" aria-controls="home" aria-selected="true"><b>Highlights</b><i class="fa fa-check" aria-hidden="true" id="tab4tick" name="step_value1" style="display:none;"></i><input type="checkbox" class="checkg" id="profile" name="nationality" value="0" onchange="submitval(this)" readonly style="background-color:solid green !important; color:green !important; visibility:hidden !important; ">
                                            <input type="hidden" id="step_value4" value="">

                                            <div class="check"></div>
                                        </a>
                                    </li>

                                    <li class="nav-items navv" class="active" id="tab_5" style="flex-basis: 1 !important;">
                                        <a class="nav-link  " id="home-tab" name="tab5" data-toggle="tab" role="tab" aria-controls="home" aria-selected="true"><b>Vitals</b><i class="fa fa-check" aria-hidden="true" id="tab5tick" name="step_value1" style="display:none;"></i> <input type="checkbox" class="checkg" id="profile" name="nationality" value="0" onchange="submitval(this)" readonly style="background-color:solid green !important; color:green !important; visibility:hidden !important; ">
                                            <input type="hidden" id="step_value5" value="">
                                            <div class="check"></div>
                                        </a>



                                    </li>


                                    <li class="nav-items navv" class="active" id="tab_6" style="flex-basis: 1 !important;">
                                        <a class="nav-link  " id="home-tab" name="tab6" data-toggle="tab" role="tab" aria-controls="home" aria-selected="true"><b>Environmental</b><i class="fa fa-check" aria-hidden="true" id="tab6tick" name="step_value1" style="display:none;"></i> <input type="checkbox" class="checkg" id="profile" name="nationality" value="0" onchange="submitval(this)" readonly style="background-color:solid green !important; color:green !important; visibility:hidden !important; ">
                                            <input type="hidden" id="step_value6" value="">
                                            <div class="check"></div>
                                        </a>
                                    </li>

                                    <li class="nav-items navv" class="active" id="tab_7" style="flex-basis: 1 !important;">
                                        <a class="nav-link  " id="home-tab" name="tab7" data-toggle="tab" role="tab" aria-controls="home" aria-selected="true"><b>Emotional</b><i class="fa fa-check" aria-hidden="true" id="tab7tick" name="step_value1" style="display:none;"></i> <input type="checkbox" class="checkg" id="profile" name="nationality" value="0" onchange="submitval(this)" readonly style="background-color:solid green !important; color:green !important; visibility:hidden !important; ">
                                            <input type="hidden" id="step_value7" value="">
                                            <div class="check"></div>
                                        </a>
                                    </li>

                                    <li class="nav-items navv" class="active" id="tab_8" style="flex-basis: 1 !important;">
                                        <a class="nav-link  " id="home-tab" name="tab8" data-toggle="tab" role="tab" aria-controls="home" aria-selected="true"><b>Sociological</b><i class="fa fa-check" aria-hidden="true" id="tab8tick" name="step_value1" style="display:none;"></i> <input type="checkbox" class="checkg" id="profile" name="nationality" value="0" onchange="submitval(this)" readonly style="background-color:solid green !important; color:green !important; visibility:hidden !important; ">
                                            <input type="hidden" id="step_value8" value="">
                                            <div class="check"></div>
                                        </a>
                                    </li>

                                    <li class="nav-items navv" class="active" id="tab_9" style="flex-basis: 1 !important;">
                                        <a class="nav-link  " id="home-tab" name="tab9" data-toggle="tab" role="tab" aria-controls="home" aria-selected="true"><b>Physiological</b><i class="fa fa-check" aria-hidden="true" id="tab9tick" name="step_value1" style="display:none;"></i> <input type="checkbox" class="checkg" id="profile" name="nationality" value="0" onchange="submitval(this)" readonly style="background-color:solid green !important; color:green !important; visibility:hidden !important; ">
                                            <input type="hidden" id="step_value9" value="">
                                            <div class="check"></div>
                                        </a>
                                    </li>

                                    <li class="nav-items navv" class="active" id="tab_10" style="flex-basis: 1 !important;">
                                        <a class="nav-link  " id="home-tab" name="tab10" data-toggle="tab" role="tab" aria-controls="home" aria-selected="true"><b>Psychological</b><i class="fa fa-check" aria-hidden="true" id="tab10tick" name="step_value1" style="display:none;"></i> <input type="checkbox" class="checkg" id="profile" name="nationality" value="0" onchange="submitval(this)" readonly style="background-color:solid green !important; color:green !important; visibility:hidden !important; ">
                                            <input type="hidden" id="step_value10" value="">
                                            <div class="check"></div>
                                        </a>
                                    </li>



                                </ul>
                            </div>




                            <!-- Tab panes -->


                            <div id="content">
                                <div id="tab1" title="Strength">
                                    <section class="section weekpage1">
                                        <div class="section-body mt-1">
                                            <div class="offset-9 col-3" style="display: flex;justify-content: flex-end;">
                                                <button class="week1" value='1'>Week1</button>


                                            </div>
                                            <div class="row">

                                                <div class="col-12">
                                                    <div class="card wholecheck">
                                                        <div class="card-body check1">
                                                            <div class="row check">

                                                                <div class="col-md-4">
                                                                    <div class="form-group ">
                                                                        <label class="control-label">Strength<span class="error-star" style="color:red;">*</span></label>
                                                                        <div style="display: flex;">
                                                                            <select class="form-control" id="Strength" name="Strength" required>
                                                                                <option>Strength1</option>
                                                                                <option>Strength2</option>
                                                                                <option>Strength3</option>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="col-md-4">
                                                                    <div class="form-group ">
                                                                        <label class="control-label">Source Document<span class="error-star" style="color:red;">*</span></label>
                                                                        <div style="display: flex;">
                                                                            <select class="form-control" id="Source" name="Source" required>
                                                                                <option>Hometracker(20-12)(20)</option>
                                                                                <option>Weekly Feedback(10-12)(20)</option>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="col-sm-1">
                                                                    <div class="form-group" style="display: flex; flex-direction: column;align-items: center;">
                                                                        <label class="control-label" style="margin-left: 16px;">Record<span class="error-star" style="color:red;">*</span></label>
                                                                        <input type="checkbox" id="record" name="record" value="record">

                                                                    </div>
                                                                </div>

                                                                <div class="col-md-3">
                                                                    <div class="form-group ">
                                                                        <label class="control-label">Environment<span class="error-star" style="color:red;">*</span></label>
                                                                        <div style="display: flex;">
                                                                            <select class="form-control" id="Environment" name="Environment" required>
                                                                                <option>Home</option>
                                                                                <option>Home-OT</option>
                                                                                <option>School-Spl ed</option>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                </div>



                                                                <div class="form-group row">
                                                                    <div class="col-md-10" style="display: flex;flex-direction: column;align-items: center;">
                                                                        <label class="control-label">Evidence<span class="error-star" style="color:red;">*</span></label>

                                                                        <textarea id="evidence" name="evidence" rows="6" cols="80"></textarea>
                                                                    </div>

                                                                    <div class="col-md-2"><button id="Addstrength1" name="Add_strength" title="Add Strength" class="btn" type="button" value="plus1">
                                                                            <i style="color: blue;font-size: 20px;" id="plus1" class="fa fa-plus-circle" aria-hidden="true"></i></button>
                                                                    </div>


                                                                </div>


                                                            </div>

                                                        </div>
                                                        <div class="row text-center">
                                                            <div class="col-md-12">
                                                                <button type="save" class="btn btn-warning" name="type" value="tab1saved" onclick="validateForm(event)">Save</button>
                                                                <button type="submit" class="btn btn-success" name="type" value="submit" onclick="validateForm(event)">Submit</button>
                                                                <a type="" href="{{route('monthlyindex')}}" class="btn btn-danger text-white">Cancel</a>

                                                            </div>
                                                        </div>

                                                        <br>
                                                    </div>

                                                </div>

                                            </div>

                                        </div>



                                    </section>
                                </div>
                                <div id="tab2" title="Stretch">
                                    <section class="section weekpage1">
                                        <div class="section-body mt-1">
                                            <div class="offset-9 col-3" style="display: flex;justify-content: flex-end;">
                                                <button class="week1" value="2">Week1</button>


                                            </div>
                                            <div class="row">

                                                <div class="col-12">
                                                    <div class="card wholecheck">
                                                        <div class="card-body check2">
                                                            <div class="row check">

                                                                <div class="col-md-4">
                                                                    <div class="form-group ">
                                                                        <label class="control-label">Stretch<span class="error-star" style="color:red;">*</span></label>
                                                                        <div style="display: flex;">
                                                                            <select class="form-control" id="Stretch" name="Stretch" required="">
                                                                                <option>Stretch1</option>
                                                                                <option>Stretch2</option>
                                                                                <option>Stretch3</option>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="col-md-4">
                                                                    <div class="form-group ">
                                                                        <label class="control-label">Source Document<span class="error-star" style="color:red;">*</span></label>
                                                                        <div style="display: flex;">
                                                                            <select class="form-control" id="StretchSource" name="StretchSource" required="">
                                                                                <option>Hometracker(20-12)(20)</option>
                                                                                <option>Weekly Feedback(10-12(20)</option>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="col-sm-1">
                                                                    <div class="form-group" style="display: flex; flex-direction: column;align-items: center;">
                                                                        <label class="control-label" style="margin-left: 16px;">Record<span class="error-star" style="color:red;">*</span></label>
                                                                        <input type="checkbox" id="record" name="stretchrecord" value="record">

                                                                    </div>
                                                                </div>

                                                                <div class="col-md-3">
                                                                    <div class="form-group ">
                                                                        <label class="control-label">Environment<span class="error-star" style="color:red;">*</span></label>
                                                                        <div style="display: flex;">
                                                                            <select class="form-control" id="Environment" name="Environment" required="">
                                                                                <option>Home</option>
                                                                                <option>Home-OT</option>
                                                                                <option>School-Spl ed</option>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                </div>



                                                                <div class="form-group row">
                                                                    <div class="col-md-10" style="display: flex;flex-direction: column;align-items: center;">
                                                                        <label class="control-label">Evidence<span class="error-star" style="color:red;">*</span></label>

                                                                        <textarea id="evidence" name="evidence" rows="6" cols="80"></textarea>
                                                                    </div>

                                                                    <div class="col-md-2"><button id="Addstretch1" name="Addstretch1" title="Add Stretch" class="btn" type="button" value="plus1">
                                                                            <i style="color: blue;font-size: 20px;" id="plus2" class="fa fa-plus-circle" aria-hidden="true"></i></button>
                                                                    </div>


                                                                </div>


                                                            </div>
                                                        </div>

                                                        <div class="row text-center">
                                                            <div class="col-md-12">
                                                                <button type="save" class="btn btn-warning" name="type" value="tab2saved" onclick="validateForm(event)">Save</button>
                                                                <button type="submit" class="btn btn-success" name="type" value="submit" onclick="validateForm(event)">Submit</button>
                                                                <a type="" href="{{route('monthlyindex')}}" class="btn btn-danger text-white">Cancel</a>

                                                            </div>
                                                        </div>
                                                        <br>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>




                                    </section>





                                </div>




                                <div id="tab3" title="Opportunity">
                                    <section class="section weekpage1">
                                        <div class="section-body mt-1">
                                            <div class="offset-9 col-3" style="display: flex;justify-content: flex-end;">
                                                <button class="week1" value="2">Week1</button>


                                            </div>
                                            <div class="row">

                                                <div class="col-12">
                                                    <div class="card wholecheck">
                                                        <div class="card-body check2">
                                                            <div class="row check">

                                                                <div class="col-md-4">
                                                                    <div class="form-group ">
                                                                        <label class="control-label">Opportunites<span class="error-star" style="color:red;">*</span></label>
                                                                        <div style="display: flex;">
                                                                            <select class="form-control" id="Opportunites" name="Opportunites" required="">
                                                                                <option>Opportunity1</option>
                                                                                <option>Opportunity2</option>
                                                                                <option>Opportunity3</option>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="col-md-4">
                                                                    <div class="form-group ">
                                                                        <label class="control-label">Source Document<span class="error-star" style="color:red;">*</span></label>
                                                                        <div style="display: flex;">
                                                                            <select class="form-control" id="opportunitySource" name="opportunitySource" required="">
                                                                                <option>Hometracker(20-12)(20)</option>
                                                                                <option>Weekly Feedback(10-12(20)</option>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="col-sm-1">
                                                                    <div class="form-group" style="display: flex; flex-direction: column;align-items: center;">
                                                                        <label class="control-label" style="margin-left: 16px;">Record<span class="error-star" style="color:red;">*</span></label>
                                                                        <input type="checkbox" id="record" name="record" value="record">

                                                                    </div>
                                                                </div>

                                                                <div class="col-md-3">
                                                                    <div class="form-group ">
                                                                        <label class="control-label">Environment<span class="error-star" style="color:red;">*</span></label>
                                                                        <div style="display: flex;">
                                                                            <select class="form-control" id="Environment" name="Environment" required="">
                                                                                <option>Home</option>
                                                                                <option>Home-OT</option>
                                                                                <option>School-Spl ed</option>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                </div>



                                                                <div class="form-group row">
                                                                    <div class="col-md-10" style="display: flex;flex-direction: column;align-items: center;">
                                                                        <label class="control-label">Evidence<span class="error-star" style="color:red;">*</span></label>

                                                                        <textarea id="evidence" name="evidence" rows="6" cols="80"></textarea>
                                                                    </div>

                                                                    <div class="col-md-2"><button id="Addopportunity" name="Addopportunity" title="Add Opportunity" class="btn" type="button" value="plus1">
                                                                            <i style="color: blue;font-size: 20px;" id="plus2" class="fa fa-plus-circle" aria-hidden="true"></i></button>
                                                                    </div>


                                                                </div>


                                                            </div>
                                                        </div>



                                                        <div class="row text-center">
                                                            <div class="col-md-12">
                                                                <button type="save" class="btn btn-warning" name="type" value="tab3saved" onclick="validateForm(event)">Save</button>
                                                                <button type="submit" class="btn btn-success" name="type" value="submit" onclick="validateForm(event)">Submit</button>
                                                                <a type="" href="{{route('monthlyindex')}}" class="btn btn-danger text-white">Cancel</a>

                                                            </div>
                                                        </div>
                                                        <br>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>




                                    </section>





                                </div>


                                <div id="tab4" title="Highlights">
                                    <section class="section weekpage1">
                                        <div class="section-body mt-1">
                                            <div class="offset-9 col-3" style="display: flex;justify-content: flex-end;">
                                                <button class="week1" value="2">Week1</button>


                                            </div>
                                            <div class="row">

                                                <div class="col-12">
                                                    <div class="card wholecheck">
                                                        <div class="card-body check2">
                                                            <div class="row check">


                                                                <div class="form-group row">
                                                                    <div class="col-md-10" style="display: flex;flex-direction: column;align-items: center;">
                                                                        <label class="control-label">Highlights<span class="error-star" style="color:red;">*</span></label>

                                                                        <textarea class="form-control" id="meeting_description" name="meeting_description" required></textarea>
                                                                    </div>



                                                                </div>
                                                            </div>
                                                            <div class="row text-center">
                                                                <div class="col-md-12">
                                                                    <button type="save" class="btn btn-warning" name="type" value="tab4saved" onclick="validateForm(event)">Save</button>
                                                                    <button type="submit" class="btn btn-success" name="type" value="submit" onclick="validateForm(event)">Submit</button>
                                                                    <a type="" href="{{route('monthlyindex')}}" class="btn btn-danger text-white">Cancel</a>

                                                                </div>
                                                            </div>
                                                            <br>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>




                                    </section>





                                </div>


                                <div id="tab5" title="Vitals">
                                    <section class="section weekpage1">
                                        <div class="section-body mt-1">
                                            <div class="offset-9 col-3" style="display: flex;justify-content: flex-end;">
                                                <button class="week1" value="2">Week1</button>


                                            </div>
                                            <div class="row">

                                                <div class="col-12">
                                                    <div class="card wholecheck">
                                                        <div class="card-body check3">


                                                            <div class="aftertherapist">
                                                                <div class="row check">
                                                                    <div class="col-md-3">
                                                                        <div class="form-group ">
                                                                            <label class="control-label">Vitals<span class="error-star" style="color:red;">*</span></label>
                                                                            <div style="display: flex;">
                                                                                <select class="form-control" id="Vitals" name="Vitals" required="">
                                                                                    <option>Sleep routine</option>
                                                                                    <option>Food Habits</option>
                                                                                    <option>Screen time</option>
                                                                                    <option>Self Engagement time</option>
                                                                                    <option>Attendance</option>
                                                                                    <option> Consistency goals</option>
                                                                                    <option>Assigned Home Activities</option>
                                                                                </select>
                                                                            </div>
                                                                        </div>
                                                                    </div>



                                                                    <div class="form-group ">
                                                                        <div class="col-md-7">
                                                                            <label class="control-label">Notes<span class="error-star" style="color:red;">*</span></label>
                                                                            <textarea id="evidence" name="evidence" rows="6" cols="60"></textarea>
                                                                        </div>
                                                                    </div>


                                                                    <div class="col-sm-1">
                                                                        <button id="Addvitals" name="Addvitals" title="Add Vitals" class="btn" type="button" value="plus1">
                                                                            <i style="color: blue;font-size: 20px;" id="plus2" class="fa fa-plus-circle" aria-hidden="true"></i></button>
                                                                    </div>



                                                                </div>
                                                            </div>
                                                            <div class="row" style="display: flex;justify-content: center;">
                                                                <div class="col-md-4">
                                                                    <div class="form-group ">
                                                                        <label class="control-label">Therapist Satisfaction<span class="error-star" style="color:red;">*</span></label>
                                                                        <div style="display: flex;">
                                                                            <textarea id="Therapist" name="Therapist" rows="4" cols="80"></textarea>

                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="col-md-4">
                                                                    <div class="form-group ">
                                                                        <label class="control-label">Parent Satisfaction<span class="error-star" style="color:red;">*</span></label>
                                                                        <div style="display: flex;">
                                                                            <textarea id="Parent" name="Parent" rows="4" cols="80"></textarea>

                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="row text-center">
                                                                <div class="col-md-12">
                                                                    <button type="save" class="btn btn-warning" name="type" value="tab5saved" onclick="validateForm(event)">Save</button>
                                                                    <button type="submit" class="btn btn-success" name="type" value="submit" onclick="validateForm(event)">Submit</button>
                                                                    <a type="" href="{{route('monthlyindex')}}" class="btn btn-danger text-white">Cancel</a>

                                                                </div>
                                                            </div>
                                                            <br>


                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>




                                    </section>





                                </div>


                                <div id="tab6" title="Environmental">
                                    <section class="section weekpage1">
                                        <div class="section-body mt-1">
                                            <div class="offset-9 col-3" style="display: flex;justify-content: flex-end;">
                                                <button class="week1" value="2">Week1</button>


                                            </div>
                                            <div class="row">

                                                <div class="col-12">
                                                    <div class="card wholecheck">
                                                        <div class="card-body check2">
                                                            <div class="row check">



                                                                <div class="col-md-4">
                                                                    <div class="form-group ">
                                                                        <label class="control-label">Source Document<span class="error-star" style="color:red;">*</span></label>
                                                                        <div style="display: flex;">
                                                                            <select class="form-control" id="StretchSource" name="StretchSource" required="">
                                                                                <option>Hometracker(20-12)(20)</option>
                                                                                <option>Weekly Feedback(10-12(20)</option>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="col-sm-1" style="max-width: none !important;">
                                                                    <div class="form-group" style="display: flex; flex-direction: column;align-items: center;">
                                                                        <label class="control-label" style="margin-left: 16px;">Sound<span class="error-star" style="color:red;">*</span></label>
                                                                        <input type="checkbox" id="record" name="stretchrecord" value="record">

                                                                    </div>
                                                                </div>

                                                                <div class="col-sm-1" style="max-width: none !important;">
                                                                    <div class="form-group" style="display: flex; flex-direction: column;align-items: center;">
                                                                        <label class="control-label" style="margin-left: 18px;">Temperature<span class="error-star" style="color:red;">*</span></label>
                                                                        <input type="checkbox" id="record" name="stretchrecord" value="record">

                                                                    </div>
                                                                </div>

                                                                <div class="col-sm-1" style="max-width: none !important;">
                                                                    <div class="form-group" style="display: flex; flex-direction: column;align-items: center;">
                                                                        <label class="control-label" style="margin-left: 18px;">Light<span class="error-star" style="color:red;">*</span></label>
                                                                        <input type="checkbox" id="record" name="stretchrecord" value="record">

                                                                    </div>
                                                                </div>

                                                                <div class="col-sm-1" style="max-width: none !important;">
                                                                    <div class="form-group" style="display: flex; flex-direction: column;align-items: center;">
                                                                        <label class="control-label" style="margin-left: 18px;">Seating<span class="error-star" style="color:red;">*</span></label>
                                                                        <input type="checkbox" id="record" name="stretchrecord" value="record">

                                                                    </div>
                                                                </div>

                                                                <div class="form-group row">
                                                                    <div class="col-md-10" style="display: flex;flex-direction: column;align-items: center;">
                                                                        <label class="control-label">Comments/Evidence<span class="error-star" style="color:red;">*</span></label>

                                                                        <textarea id="evidence" name="evidence" rows="6" cols="80"></textarea>
                                                                    </div>


                                                                </div>




                                                            </div>
                                                        </div>

                                                        <div class="row text-center">
                                                            <div class="col-md-12">
                                                                <button type="save" class="btn btn-warning" name="type" value="tab6saved" onclick="validateForm(event)">Save</button>
                                                                <button type="submit" class="btn btn-success" name="type" value="submit" onclick="validateForm(event)">Submit</button>
                                                                <a type="" href="{{route('monthlyindex')}}" class="btn btn-danger text-white">Cancel</a>

                                                            </div>
                                                        </div>
                                                        <br>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>




                                    </section>





                                </div>


                                <div id="tab7" title="Emotional">
                                    <section class="section weekpage1">
                                        <div class="section-body mt-1">
                                            <div class="offset-9 col-3" style="display: flex;justify-content: flex-end;">
                                                <button class="week1" value="2">Week1</button>


                                            </div>
                                            <div class="row">

                                                <div class="col-12">
                                                    <div class="card wholecheck">
                                                        <div class="card-body check2">
                                                            <div class="row check">



                                                                <div class="col-md-4">
                                                                    <div class="form-group ">
                                                                        <label class="control-label">Source Document<span class="error-star" style="color:red;">*</span></label>
                                                                        <div style="display: flex;">
                                                                            <select class="form-control" id="StretchSource" name="StretchSource" required="">
                                                                                <option>Hometracker(20-12)(20)</option>
                                                                                <option>Weekly Feedback(10-12(20)</option>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="col-sm-3">
                                                                    <div class="form-group" style="display: flex; flex-direction: column;align-items: center;">
                                                                        <label class="control-label" style="margin-left: 16px;">Level of Motivation<span class="error-star" style="color:red;">*</span></label>
                                                                        <input type="checkbox" id="record" name="stretchrecord" value="record">

                                                                    </div>
                                                                </div>

                                                                <div class="col-md-3" style="max-width: none !important;">
                                                                    <div class="form-group" style="display: flex; flex-direction: column;align-items: center;">
                                                                        <label class="control-label" style="margin-left: 18px;">Task Persistence<span class="error-star" style="color:red;">*</span></label>
                                                                        <input type="checkbox" id="record" name="stretchrecord" value="record">

                                                                    </div>
                                                                </div>

                                                                <div class="col-md-4" style="max-width: none !important;">
                                                                    <div class="form-group" style="display: flex; flex-direction: column;align-items: center;">
                                                                        <label class="control-label" style="margin-left: 18px;">Conformity/Responsibility<span class="error-star" style="color:red;">*</span></label>
                                                                        <input type="checkbox" id="record" name="stretchrecord" value="record">

                                                                    </div>
                                                                </div>

                                                                <div class="col-sm-3" style="max-width: none !important;">
                                                                    <div class="form-group" style="display: flex; flex-direction: column;align-items: center;width:max-content;">
                                                                        <label class="control-label" style="margin-left: 18px;">Need for a Structured Environment<span class="error-star" style="color:red;">*</span></label>
                                                                        <input type="checkbox" id="record" name="stretchrecord" value="record">

                                                                    </div>
                                                                </div>

                                                                <div class="form-group row">
                                                                    <div class="col-md-12" style="display: flex;flex-direction: column;align-items: center;">
                                                                        <label class="control-label">Comments/Evidence<span class="error-star" style="color:red;">*</span></label>

                                                                        <textarea id="evidence" name="evidence" rows="6" cols="80"></textarea>
                                                                    </div>


                                                                </div>




                                                            </div>
                                                        </div>

                                                        <div class="row text-center">
                                                            <div class="col-md-12">
                                                                <button type="save" class="btn btn-warning" name="type" value="tab7saved" onclick="validateForm(event)">Save</button>
                                                                <button type="submit" class="btn btn-success" name="type" value="submit" onclick="validateForm(event)">Submit</button>
                                                                <a type="" href="{{route('monthlyindex')}}" class="btn btn-danger text-white">Cancel</a>

                                                            </div>
                                                        </div>
                                                        <br>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>




                                    </section>





                                </div>

                                <div id="tab8" title="Sociological">
                                    <section class="section weekpage1">
                                        <div class="section-body mt-1">
                                            <div class="offset-9 col-3" style="display: flex;justify-content: flex-end;">
                                                <button class="week1" value="2">Week1</button>


                                            </div>
                                            <div class="row">

                                                <div class="col-12">
                                                    <div class="card wholecheck">
                                                        <div class="card-body check2">
                                                            <div class="row check">



                                                                <div class="col-md-4">
                                                                    <div class="form-group ">
                                                                        <label class="control-label">Source Document<span class="error-star" style="color:red;">*</span></label>
                                                                        <div style="display: flex;">
                                                                            <select class="form-control" id="StretchSource" name="StretchSource" required="">
                                                                                <option>Hometracker(20-12)(20)</option>
                                                                                <option>Weekly Feedback(10-12(20)</option>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="col-md-2">
                                                                    <div class="form-group" style="display: flex; flex-direction: column;align-items: center;width:max-content;">
                                                                        <label class="control-label" style="margin-left: 16px;">Alone<span class="error-star" style="color:red;">*</span></label>
                                                                        <input type="checkbox" id="record" name="stretchrecord" value="record">

                                                                    </div>
                                                                </div>

                                                                <div class="col-md-2" style="max-width: none !important;">
                                                                    <div class="form-group" style="display: flex; flex-direction: column;align-items: center;width:max-content;">
                                                                        <label class="control-label" style="margin-left: 18px;">With an Adult as a Teacher<span class="error-star" style="color:red;">*</span></label>
                                                                        <input type="checkbox" id="record" name="stretchrecord" value="record">

                                                                    </div>
                                                                </div>

                                                                <div class="col-md-2" style="max-width:13.333333% !important;">
                                                                    <div class="form-group" style="display: flex; flex-direction: column;align-items: center;width:max-content;">
                                                                        <label class="control-label" style="margin-left: 18px;">With Peers<span class="error-star" style="color:red;">*</span></label>
                                                                        <input type="checkbox" id="record" name="stretchrecord" value="record">

                                                                    </div>
                                                                </div>

                                                                <div class="col-md-2" style="max-width: none !important;">
                                                                    <div class="form-group" style="display: flex; flex-direction: column;align-items: center;width:max-content;">
                                                                        <label class="control-label" style="margin-left: 18px;">In a Team<span class="error-star" style="color:red;">*</span></label>
                                                                        <input type="checkbox" id="record" name="stretchrecord" value="record">

                                                                    </div>
                                                                </div>

                                                                <div class="col-md-2" style="max-width: none !important;">
                                                                    <div class="form-group" style="display: flex; flex-direction: column;align-items: center;width:max-content;">
                                                                        <label class="control-label" style="margin-left: 18px;">In Pairs<span class="error-star" style="color:red;">*</span></label>
                                                                        <input type="checkbox" id="record" name="stretchrecord" value="record">

                                                                    </div>
                                                                </div>

                                                                <div class="col-sm-3" style="max-width: none !important;">
                                                                    <div class="form-group" style="display: flex; flex-direction: column;align-items: center;width:max-content;">
                                                                        <label class="control-label" style="margin-left: 18px;">Variety of Social Setting<span class="error-star" style="color:red;">*</span></label>
                                                                        <input type="checkbox" id="record" name="stretchrecord" value="record">

                                                                    </div>
                                                                </div>

                                                                <div class="form-group row">
                                                                    <div class="col-md-12" style="display: flex;flex-direction: column;align-items: center;">
                                                                        <label class="control-label">Comments/Evidence<span class="error-star" style="color:red;">*</span></label>

                                                                        <textarea id="evidence" name="evidence" rows="6" cols="80"></textarea>
                                                                    </div>


                                                                </div>




                                                            </div>
                                                        </div>

                                                        <div class="row text-center">
                                                            <div class="col-md-12">
                                                                <button type="save" class="btn btn-warning" name="type" value="tab8saved" onclick="validateForm(event)">Save</button>
                                                                <button type="submit" class="btn btn-success" name="type" value="submit" onclick="validateForm(event)">Submit</button>
                                                                <a type="" href="{{route('monthlyindex')}}" class="btn btn-danger text-white">Cancel</a>

                                                            </div>
                                                        </div>
                                                        <br>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>




                                    </section>





                                </div>


                                <div id="tab9" title="Physiological">
                                    <section class="section weekpage1">
                                        <div class="section-body mt-1">
                                            <div class="offset-9 col-3" style="display: flex;justify-content: flex-end;">
                                                <button class="week1" value="2">Week1</button>


                                            </div>
                                            <div class="row">

                                                <div class="col-12">
                                                    <div class="card wholecheck">
                                                        <div class="card-body check2">
                                                            <div class="row check">



                                                                <div class="col-md-4">
                                                                    <div class="form-group ">
                                                                        <label class="control-label">Source Document<span class="error-star" style="color:red;">*</span></label>
                                                                        <div style="display: flex;">
                                                                            <select class="form-control" id="StretchSource" name="StretchSource" required="">
                                                                                <option>Hometracker(20-12)(20)</option>
                                                                                <option>Weekly Feedback(10-12(20)</option>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="col-sm-1" style="max-width: none !important;">
                                                                    <div class="form-group" style="display: flex; flex-direction: column;align-items: center;">
                                                                        <label class="control-label" style="margin-left: 16px;">Auditory<span class="error-star" style="color:red;">*</span></label>
                                                                        <input type="checkbox" id="record" name="stretchrecord" value="record">

                                                                    </div>
                                                                </div>

                                                                <div class="col-sm-1" style="max-width: none !important;">
                                                                    <div class="form-group" style="display: flex; flex-direction: column;align-items: center;">
                                                                        <label class="control-label" style="margin-left: 18px;">Visual<span class="error-star" style="color:red;">*</span></label>
                                                                        <input type="checkbox" id="record" name="stretchrecord" value="record">

                                                                    </div>
                                                                </div>

                                                                <div class="col-sm-1" style="max-width: none !important;">
                                                                    <div class="form-group" style="display: flex; flex-direction: column;align-items: center;">
                                                                        <label class="control-label" style="margin-left: 18px;">Tactile<span class="error-star" style="color:red;">*</span></label>
                                                                        <input type="checkbox" id="record" name="stretchrecord" value="record">

                                                                    </div>
                                                                </div>

                                                                <div class="col-sm-1" style="max-width: none !important;">
                                                                    <div class="form-group" style="display: flex; flex-direction: column;align-items: center;">
                                                                        <label class="control-label" style="margin-left: 18px;">Kinesthetic<span class="error-star" style="color:red;">*</span></label>
                                                                        <input type="checkbox" id="record" name="stretchrecord" value="record">

                                                                    </div>
                                                                </div>

                                                                <div class="form-group row">
                                                                    <div class="col-md-10" style="display: flex;flex-direction: column;align-items: center;">
                                                                        <label class="control-label">Comments/Evidence<span class="error-star" style="color:red;">*</span></label>

                                                                        <textarea id="evidence" name="evidence" rows="6" cols="80"></textarea>
                                                                    </div>


                                                                </div>




                                                            </div>
                                                        </div>

                                                        <div class="row text-center">
                                                            <div class="col-md-12">
                                                                <button type="save" class="btn btn-warning" name="type" value="tab9saved" onclick="validateForm(event)">Save</button>
                                                                <button type="submit" class="btn btn-success" name="type" value="submit" onclick="validateForm(event)">Submit</button>
                                                                <a type="" href="{{route('monthlyindex')}}" class="btn btn-danger text-white">Cancel</a>

                                                            </div>
                                                        </div>
                                                        <br>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>




                                    </section>





                                </div>

                                <div id="tab10" title="Psychological">
                                    <section class="section weekpage1">
                                        <div class="section-body mt-1">
                                            <div class="offset-9 col-3" style="display: flex;justify-content: flex-end;">
                                                <button class="week1" value="2">Week1</button>


                                            </div>
                                            <div class="row">

                                                <div class="col-12">
                                                    <div class="card wholecheck">
                                                        <div class="card-body check2">
                                                            <div class="row check">



                                                                <div class="col-md-4">
                                                                    <div class="form-group ">
                                                                        <label class="control-label">Source Document<span class="error-star" style="color:red;">*</span></label>
                                                                        <div style="display: flex;">
                                                                            <select class="form-control" id="StretchSource" name="StretchSource" required="">
                                                                                <option>Hometracker(20-12)(20)</option>
                                                                                <option>Weekly Feedback(10-12(20)</option>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="col-sm-1" style="max-width: none !important;">
                                                                    <div class="form-group" style="display: flex; flex-direction: column;align-items: center;width:max-content;">
                                                                        <label class="control-label" style="margin-left: 16px;">Global/Analytical<span class="error-star" style="color:red;">*</span></label>
                                                                        <input type="checkbox" id="record" name="stretchrecord" value="record">

                                                                    </div>
                                                                </div>

                                                                <div class="col-sm-1" style="max-width: none !important;">
                                                                    <div class="form-group" style="display: flex; flex-direction: column;align-items: center;width:max-content;">
                                                                        <label class="control-label" style="margin-left: 18px;">Impulsive/Reflective<span class="error-star" style="color:red;">*</span></label>
                                                                        <input type="checkbox" id="record" name="stretchrecord" value="record">

                                                                    </div>
                                                                </div>


                                                                <div class="form-group row">
                                                                    <div class="col-md-10" style="display: flex;flex-direction: column;align-items: center;">
                                                                        <label class="control-label">Comments/Evidence<span class="error-star" style="color:red;">*</span></label>

                                                                        <textarea id="evidence" name="evidence" rows="6" cols="80"></textarea>
                                                                    </div>


                                                                </div>




                                                            </div>
                                                        </div>

                                                        <div class="row text-center">
                                                            <div class="col-md-12">
                                                                <button type="save" class="btn btn-warning" name="type" value="tab10saved" onclick="validateForm(event)">Save</button>
                                                                <button type="submit" class="btn btn-success" name="type" value="submit" onclick="validateForm(event)">Submit</button>
                                                                <a type="" href="{{route('monthlyindex')}}" class="btn btn-danger text-white">Cancel</a>

                                                            </div>
                                                        </div>
                                                        <br>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>




                                    </section>





                                </div>










                            </div>




                            <br>
                            <div class="row d-flex justify-content-center">
                                <a class="btn previous_btn d-none pagination_btn" style="font-weight: 100px;">
                                    < </a>
                                        <button class="btn btn-info week_btn active-btn" id='Week1' value="1" onclick="WeeklyWise(event)">Week1</button>
                                        <button class="btn btn-info week_btn " id='Week2' value="2" onclick="WeeklyWise(event)">Week2</button>
                                        <button class="btn btn-info week_btn" id='Week3' value="3" onclick="WeeklyWise(event)">Week3</button>
                                        <button class="btn btn-info week_btn" id='Week4' value="4" onclick="WeeklyWise(event)">Week4</button>
                                        <!-- <button class="btn btn-info">Week1</button> -->
                                        <a class="btn next_btn pagination_btn">></a>


                            </div>



                        </div>



                    </div>
                </div>
            </div>
        </div>






        <br>

        <br>
        <div class="col-12  card_custom" id="card1">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-12 text-center">
                            <h4 style="color:darkblue;"></h4>
                        </div>
                    </div>
                    <div class="table-wrapper">
                        <div class="table-responsive">
                            <table class="table table-bordered" id="align">
                                <thead>
                                    <tr>
                                        <th width="4%">Sl.No.</th>
                                        <th width="9%">Strength</th>
                                        <th width="15%">Source Document</th>
                                        <th width="5%">Record</th>
                                        <th width="7%">Environment</th>
                                        <th width="32%">Evidence</th>
                                        <th width="7%">Status</th>
                                        <th width="11%">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>1</td>
                                        <td>Strength1</td>
                                        <td>Hometracker(20-12)(20)</td>
                                        <td>true</td>
                                        <td>Home</td>
                                        <td>He directly said no for work though he was aware, he bargained with the adult to do work. He tried to interact with other children. Theatre- He then turned at me and said - "Amma I helped that aunty" When mother wore saree for a function- "asked me why I was wearing paati's dress" He reasoned out verbally why he did not want to play with balloons </td>
                                        <td>week1 saved</td>

                                        <td>

                                            <a class="btn btn-link" title="Show" href="{{ route('hometracker.show',1) }}"><i class="fas fa-eye" style="color: blue !important"></i></a>
                                            <a class="btn btn-link" title="Edit" href="{{ route('hometracker.edit','2') }}"><i class="fas fa-pencil-alt" style="color:green"></i></a>

                                        </td>
                                    </tr>





                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <div class="col-12 d-none card_custom" id="card2">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-12 text-center">
                            <h4 style="color:darkblue;"></h4>
                        </div>
                    </div>
                    <div class="table-wrapper">
                        <div class="table-responsive">
                            <table class="table table-bordered" id="align1">
                                <thead>
                                    <tr>
                                        <th>Sl.No.</th>
                                        <th>Stretch</th>
                                        <th>Source Document</th>
                                        <th>Record</th>
                                        <th>Environment</th>
                                        <th style="width:50px !important;">Evidence</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>1</td>
                                        <td>Stretch1</td>
                                        <td>Hometracker(20-12)(20)</td>
                                        <td>true</td>
                                        <td>Home</td>
                                        <td>Learnt to trace sand paper letters which was part of school activity,drawing curvy figures- He gets upset when he is unable to do it perfectly.However, he tries to do it.</td>
                                        <td>week1 saved</td>

                                        <td>

                                            <a class="btn btn-link" title="Show" href="{{ route('hometracker.show',1) }}"><i class="fas fa-eye" style="color: blue !important"></i></a>
                                            <a class="btn btn-link" title="Edit" href="{{ route('hometracker.edit','2') }}"><i class="fas fa-pencil-alt" style="color:green"></i></a>

                                        </td>
                                    </tr>





                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12 d-none card_custom" id="card3">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-12 text-center">
                            <h4 style="color:darkblue;"></h4>
                        </div>
                    </div>
                    <div class="table-wrapper">
                        <div class="table-responsive">
                            <table class="table table-bordered" id="align2">
                                <thead>
                                    <tr>
                                        <th>Sl.No.</th>
                                        <th>Opportunites</th>
                                        <th>Source Document</th>
                                        <th>Record</th>
                                        <th>Environment</th>
                                        <th style="width:50px !important;">Evidence</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>1</td>
                                        <td>Opportunity1</td>
                                        <td>Hometracker(20-12)(20)</td>
                                        <td>true</td>
                                        <td>Home</td>
                                        <td>Learnt to trace sand paper letters which was part of school activity, drawing curvy figures- He gets upset when he is unable to do it perfectly. However, he tries to do it. </td>
                                        <td>week1 saved</td>

                                        <td>

                                            <a class="btn btn-link" title="Show" href="{{ route('hometracker.show',1) }}"><i class="fas fa-eye" style="color: blue !important"></i></a>
                                            <a class="btn btn-link" title="Edit" href="{{ route('hometracker.edit','2') }}"><i class="fas fa-pencil-alt" style="color:green"></i></a>

                                        </td>
                                    </tr>





                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12 d-none card_custom" id="card4">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-12 text-center">
                            <h4 style="color:darkblue;"></h4>
                        </div>
                    </div>
                    <div class="table-wrapper">
                        <div class="table-responsive">
                            <table class="table table-bordered" id="align3">
                                <thead>
                                    <tr>
                                        <th>Sl.No.</th>
                                        <th style="width:50px !important;">Highlights</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>1</td>
                                        <td>1)Movements were on higher side, refused to take work; It was not a productive week- School<br>
                                            2) Refused to come for doing activity. Disturbed by occassional and unexpected cracker sound- showed him videos from old memory where he sang rhymes.<br>
                                            3)He was very normal with his routine, however he dislikes loud noises.


                                        </td>

                                        <td>week1 saved</td>

                                        <td>

                                            <a class="btn btn-link" title="Show" href="{{ route('hometracker.show',1) }}"><i class="fas fa-eye" style="color: blue !important"></i></a>
                                            <a class="btn btn-link" title="Edit" href="{{ route('hometracker.edit','2') }}"><i class="fas fa-pencil-alt" style="color:green"></i></a>

                                        </td>
                                    </tr>





                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <div class="col-12 d-none card_custom" id="card5">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-12 text-center">
                            <h4 style="color:darkblue;"></h4>
                        </div>
                    </div>
                    <div class="table-wrapper">
                        <div class="table-responsive">
                            <table class="table table-bordered" id="align4">
                                <thead>
                                    <tr>
                                        <th>Sl.No.</th>
                                        <th>Vitals</th>
                                        <th style="width:50px !important;">Notes</th>
                                        <th>Therapist Satisfaction</th>
                                        <th>Parent Satisfaction</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>1</td>
                                        <td>Sleep Routine</td>
                                        <td>Sleep time- 9 to 10 pm; wake up time- 7 to 8 am; had difficulty falling sleep, disturbed sleep on a day</td>
                                        <td>School- No, OT- Neutral </td>
                                        <td> Yes in OT</td>
                                        <td>week1 saved</td>

                                        <td>

                                            <a class="btn btn-link" title="Show" href="{{ route('hometracker.show',1) }}"><i class="fas fa-eye" style="color: blue !important"></i></a>
                                            <a class="btn btn-link" title="Edit" href="{{ route('hometracker.edit','2') }}"><i class="fas fa-pencil-alt" style="color:green"></i></a>

                                        </td>
                                    </tr>





                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12 d-none card_custom" id="card6">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-12 text-center">
                            <h4 style="color:darkblue;"></h4>
                        </div>
                    </div>
                    <div class="table-wrapper">
                        <div class="table-responsive">
                            <table class="table table-bordered" id="align6">
                                <thead>
                                    <tr>
                                        <th width="4%">Sl.No.</th>
                                        <th>Source Document</th>
                                        <th>Sound</th>
                                        <th style="width:10px !important;">Temperature</th>
                                        <th>Light</th>
                                        <th>Seating</th>
                                        <th style="width:70px !important;">Comments/Evidence</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>1</td>
                                        <td>Hometracker(20-12)(20)</td>
                                        <td>true</td>
                                        <td>true</td>
                                        <td>true</td>
                                        <td>false</td>
                                        <td>School- Comfortable seating, Consistent work setting, Safe; OT- Quiet, Comfortable seating, Consistent work setting, Safe, Consistent device, Optimal lighting and ventilation.</td>
                                        <td>week1 saved</td>

                                        <td>

                                            <a class="btn btn-link" title="Show" href="{{ route('hometracker.show',1) }}"><i class="fas fa-eye" style="color: blue !important"></i></a>
                                            <a class="btn btn-link" title="Edit" href="{{ route('hometracker.edit','2') }}"><i class="fas fa-pencil-alt" style="color:green"></i></a>

                                        </td>
                                    </tr>





                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12 d-none card_custom" id="card7">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-12 text-center">
                            <h4 style="color:darkblue;"></h4>
                        </div>
                    </div>
                    <div class="table-wrapper">
                        <div class="table-responsive">
                            <table class="table table-bordered" id="align7">
                                <thead>
                                    <tr>
                                        <th width="4%">Sl.No.</th>
                                        <th>Source Document</th>
                                        <th>Level of Motivation</th>
                                        <th>Task persistence</th>
                                        <th style="width:2px !important;">conformity/Responsibility</th>
                                        <th>Need for a structured environment</th>
                                        <th style="width:70px !important;">Comments/Evidence</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>1</td>
                                        <td>Hometracker(20-12)(20)</td>
                                        <td>true</td>
                                        <td>true</td>
                                        <td>true</td>
                                        <td>false</td>
                                        <td>School- Looked Distracted, Avoidance of tasks, Communicated dislike in the task; OT - Motivated, communicated dislike of the task Cranky at home too.</td>
                                        <td>week1 saved</td>

                                        <td>

                                            <a class="btn btn-link" title="Show" href="{{ route('hometracker.show',1) }}"><i class="fas fa-eye" style="color: blue !important"></i></a>
                                            <a class="btn btn-link" title="Edit" href="{{ route('hometracker.edit','2') }}"><i class="fas fa-pencil-alt" style="color:green"></i></a>

                                        </td>
                                    </tr>









                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12 d-none card_custom" id="card8">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-12 text-center">
                            <h4 style="color:darkblue;"></h4>
                        </div>
                    </div>
                    <div class="table-wrapper">
                        <div class="table-responsive">
                            <table class="table table-bordered" id="align8">
                                <thead>
                                    <tr>
                                        <th width="4%">Sl.No.</th>
                                        <th>Source Document</th>
                                        <th>Alone</th>
                                        <th>With an Adult as a Teacher</th>
                                        <th style="width:2px !important;">With Peers</th>
                                        <th>In a Team</th>
                                        <th>Variety of Social Setting</th>
                                        <th>Comments/Evidence</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>1</td>
                                        <td>Hometracker(20-12)(20)</td>
                                        <td>true</td>
                                        <td>true</td>
                                        <td>true</td>
                                        <td>false</td>
                                        <td>true</td>
                                        <td>School- cooperation level-3; OT-3</td>
                                        <td>week1 saved</td>

                                        <td>

                                            <a class="btn btn-link" title="Show" href="{{ route('hometracker.show',1) }}"><i class="fas fa-eye" style="color: blue !important"></i></a>
                                            <a class="btn btn-link" title="Edit" href="{{ route('hometracker.edit','2') }}"><i class="fas fa-pencil-alt" style="color:green"></i></a>

                                        </td>
                                    </tr>









                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <div class="col-12 d-none card_custom" id="card9">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-12 text-center">
                            <h4 style="color:darkblue;"></h4>
                        </div>
                    </div>
                    <div class="table-wrapper">
                        <div class="table-responsive">
                            <table class="table table-bordered" id="align9">
                                <thead>
                                    <tr>
                                        <th width="4%">Sl.No.</th>
                                        <th>Source Document</th>
                                        <th>Auditory</th>
                                        <th>Visual</th>
                                        <th style="width:2px !important;">Tactile</th>
                                        <th>Kinesthetic</th>

                                        <th style="width:20px !important;">Comments/Evidence</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>1</td>
                                        <td>Hometracker(20-12)(20)</td>
                                        <td>true</td>
                                        <td>true</td>
                                        <td>true</td>
                                        <td>false</td>
                                        <td>Avoidance of loud noise</td>
                                        <td>week1 saved</td>

                                        <td>

                                            <a class="btn btn-link" title="Show" href="{{ route('hometracker.show',1) }}"><i class="fas fa-eye" style="color: blue !important"></i></a>
                                            <a class="btn btn-link" title="Edit" href="{{ route('hometracker.edit','2') }}"><i class="fas fa-pencil-alt" style="color:green"></i></a>

                                        </td>
                                    </tr>









                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12 d-none card_custom" id="card10">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-12 text-center">
                            <h4 style="color:darkblue;"></h4>
                        </div>
                    </div>
                    <div class="table-wrapper">
                        <div class="table-responsive">
                            <table class="table table-bordered" id="align10">
                                <thead>
                                    <tr>
                                        <th>Sl.No.</th>
                                        <th>Source Document</th>
                                        <th>Global/Analytical</th>
                                        <th>Impulsive/Reflective</th>

                                        <th>Comments/Evidence</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>1</td>
                                        <td>Hometracker(20-12)(20)</td>
                                        <td>true</td>
                                        <td>false</td>
                                        <td>Avoidance of loud noise</td>
                                        <td>week1 saved</td>

                                        <td>

                                            <a class="btn btn-link" title="Show" href="{{ route('hometracker.show',1) }}"><i class="fas fa-eye" style="color: blue !important"></i></a>
                                            <a class="btn btn-link" title="Edit" href="{{ route('hometracker.edit','2') }}"><i class="fas fa-pencil-alt" style="color:green"></i></a>

                                        </td>
                                    </tr>









                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>








    </section>
</div>









<script src="https://cdnjs.cloudflare.com/ajax/libs/tinymce/4.5.6/tinymce.min.js"></script>
<script src="http://cdnjs.cloudflare.com/ajax/libs/tinymce/4.5.6/jquery.tinymce.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.26.0/moment.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.16/dist/sweetalert2.all.min.js"></script>


@include('ovm1.cal')
<!-- End -->
<script type="text/javascript">
    const iscoordinatorfn = (event) => {
        let coordinatorname = event.target.value;
        let currentcoordinator = event.target.name;
        if (currentcoordinator === "is_coordinator1") {
            let iscoordinater2new = JSON.parse($('#is_coordinator2old').attr('data-attr'));
            intcoordinatorname = parseInt(coordinatorname);
            iscoordinater2new = iscoordinater2new.filter(name => name.id !== intcoordinatorname)
            alternatecoordinator = document.getElementById('is_coordinator2')
            var ddd = '<option value="">Select-IS-Coordinator-2</option>';
            for (i = 0; i < iscoordinater2new.length; i++) {
                ddd += '<option value="' + iscoordinater2new[i].id + '">' + iscoordinater2new[i].name + '</option>';
            }
            let currentcoordinatorname = alternatecoordinator.value;
            alternatecoordinator.innerHTML = "";
            alternatecoordinator.innerHTML = ddd;
            alternatecoordinator.value = currentcoordinatorname;
        } else {
            let iscoordinater1new = JSON.parse($('#is_coordinator1old').attr('data-attr'));
            intcoordinatorname = parseInt(coordinatorname);
            iscoordinater1new = iscoordinater1new.filter(name => name.id !== intcoordinatorname)
            alternatecoordinator = document.getElementById('is_coordinator1');
            var ddd = '<option value="">Select-IS-Coordinator-1</option>';
            for (i = 0; i < iscoordinater1new.length; i++) {
                ddd += '<option value="' + iscoordinater1new[i].id + '">' + iscoordinater1new[i].name + '</option>';
            }
            let currentcoordinatorname = alternatecoordinator.value;
            alternatecoordinator.innerHTML = "";
            alternatecoordinator.innerHTML = ddd;
            alternatecoordinator.value = currentcoordinatorname;
        }
        //...
    }
</script>

<script>
    let addstrength = document.querySelector('#Addstrength1');

    function addStrengthFunction(e) {
        //alert("hii");


        if (document.querySelector('[name="Strength"]').value == "") {
            Swal.fire("Please Select Strength: ", "", "error");
            return false;
        }
        if (document.querySelector('[name="Source"]').value == "") {
            Swal.fire("Please Select Source: ", "", "error");
            return false;
        } else {

        }


        if (e.target.id == 'plus1') {

            if (e.target.className == 'fa fa-minus-circle') {
                e.target.parentElement.parentElement.parentElement.parentElement.style.display = "none";


            } else {
                $('.check1').append('<div class="row remove"><div class="col-md-4"><div class="form-group"><label class="control-label">Strength<span class="error-star" style="color:red;">*</span></label><div style="display: flex;"><select class="form-control" id="Strength" name="Strength" required><option>Strength1</option> <option>Strength2</option><option>Strength3</option></select></div></div></div><div class="col-md-4"><div class="form-group "><label class="control-label">Source Document<span class="error-star" style="color:red;">*</span></label> <div style="display: flex;"><select class="form-control" id="Source" name="Source" required><option>Hometracker(20-12)(20)</option><option>Weekly Feedback(10-12)(20)</option><option>Monthly Objectives</option></select></div></div></div><div class="col-sm-1"><div class="form-group" style="display: flex; flex-direction: column;align-items: center;"><label class="control-label" style="margin-left: 16px;">Record<span class="error-star" style="color:red;">*</span></label><input type="checkbox" id="record" name="record" value="record"></div></div><div class="col-md-3"><div class="form-group "><label class="control-label">Environment<span class="error-star"style="color:red;">*</span></label><div style="display: flex;"><select class="form-control" id="Environment" name="Environment" required><option>Home</option><option>Home-OT</option><option>School-Spled</option></select></div></div></div><div class="form-group row"><div class="col-md-10" style="display: flex;flex-direction: column;align-items: center;"><label class="control-label">Evidence<span class="error-star" style="color:red;">*</span></label><textarea id="evidence" name="evidence" rows="6" cols="80"></textarea></div><div class="col-md-2"><button id="Addstrength1" name="Add_strength" title="Remove Strength" class="btn" type="button"> <i style="color: blue;font-size: 20px;" id="plus1" class="fa fa-minus-circle" aria-hidden="true"></i></button></div></div></div></div></div>');
                console.log(e.target.value);
            }

        } else {
            if (e.target.children[0].className == 'fa fa-minus-circle') {
                e.target.parentElement.parentElement.parentElement.style.display = "none";


            } else {
                $('.check1').append('<div class="row remove"><div class="col-md-4"><div class="form-group"><label class="control-label">Strength<span class="error-star" style="color:red;">*</span></label><div style="display: flex;"><select class="form-control" id="Strength" name="Strength" required><option>Strength1</option> <option>Strength2</option><option>Strength3</option></select></div></div></div><div class="col-md-4"><div class="form-group "><label class="control-label">Source Document<span class="error-star" style="color:red;">*</span></label> <div style="display: flex;"><select class="form-control" id="Source" name="Source" required><option>Hometracker(20-12)(20)</option><option>Weekly Feedback(10-12)(20)</option><option>Monthly Objectives</option></select></div></div></div><div class="col-sm-1"><div class="form-group" style="display: flex; flex-direction: column;align-items: center;"><label class="control-label" style="margin-left: 16px;">Record<span class="error-star" style="color:red;">*</span></label><input type="checkbox" id="record" name="record" value="record"></div></div><div class="col-md-3"><div class="form-group "><label class="control-label">Environment<span class="error-star"style="color:red;">*</span></label> <div style="display: flex;"><select class="form-control" id="Environment" name="Environment" required><option>Home</option><option>Home-OT</option><option>School-Spled</option></select></div></div></div><div class="form-group row"><div class="col-md-10" style="display: flex;flex-direction: column;align-items: center;"><label class="control-label">Evidence<span class="error-star" style="color:red;">*</span></label><textarea id="evidence" name="evidence" rows="6" cols="80"></textarea></div><div class="col-md-2"><button id="Addstrength1" name="Add_strength" title="Remove Strength" class="btn" type="button"> <i style="color: blue;font-size: 20px;" id="plus1" class="fa fa-minus-circle" aria-hidden="true"></i></button></div></div></div></div></div>');
                console.log(e.target.value);
            }


        }
        //alert('fw');



        const plusaddbox = document.querySelectorAll('#Addstrength1');
        //alert("bjs");
        //alert(plusaddbox.length);
        for (let i = 0; i < plusaddbox.length; i++) {
            // alert(i);
            plusaddbox[i].addEventListener("click", addStrengthFunction);
        }
    }
    addstrength.addEventListener('click', addStrengthFunction);
</script>

<script>
    let addstretch = document.querySelector('#Addstretch1');

    function addStretchFunction(e) {
        //alert("hii");


        if (document.querySelector('[name="Stretch"]').value == "") {
            Swal.fire("Please Select Stretch: ", "", "error");
            return false;
        }
        if (document.querySelector('[name="StretchSource"]').value == "") {
            Swal.fire("Please Select Source: ", "", "error");
            return false;
        } else {

        }


        if (e.target.id == 'plus2') {

            if (e.target.className == 'fa fa-minus-circle') {
                e.target.parentElement.parentElement.parentElement.parentElement.style.display = "none";


            } else {
                $('.check2').append('<div class="row remove"><div class="col-md-4"><div class="form-group"><label class="control-label">Stretch<span class="error-star" style="color:red;">*</span></label><div style="display: flex;"><select class="form-control" id="Stretch" name="Stretch" required><option>Stretch1</option><option>Stretch2</option><option>Stretch3</option></select></div></div></div><div class="col-md-4"><div class="form-group "><label class="control-label">Source Document<span class="error-star" style="color:red;">*</span></label> <div style="display: flex;"><select class="form-control" id="StretchSource" name="StretchSource" required><option>Hometracker(20-12)(20)</option><option>Weekly Feedback(10-12)(20)</option><option>Monthly Objectives</option></select></div></div></div><div class="col-sm-1"><div class="form-group" style="display: flex; flex-direction: column;align-items: center;"><label class="control-label" style="margin-left: 16px;">Record<span class="error-star" style="color:red;">*</span></label><input type="checkbox" id="record" name="record" value="record"></div></div><div class="col-md-3"><div class="form-group "><label class="control-label">Environment<span class="error-star"style="color:red;">*</span></label><div style="display: flex;"><select class="form-control" id="Environment" name="Environment" required><option>Home</option><option>Home-OT</option><option>School-Spled</option></select></div></div></div><div class="form-group row"><div class="col-md-10" style="display: flex;flex-direction: column;align-items: center;"><label class="control-label">Evidence<span class="error-star" style="color:red;">*</span></label><textarea id="evidence" name="evidence" rows="6" cols="80"></textarea></div><div class="col-md-2"><button id="Addstretch1" name="Addstretch1" title="Remove Stretch" class="btn" type="button"> <i style="color: blue;font-size: 20px;" id="plus2" class="fa fa-minus-circle" aria-hidden="true"></i></button></div></div></div></div></div>');
                console.log(e.target.value);
            }

        } else {
            if (e.target.children[0].className == 'fa fa-minus-circle') {
                e.target.parentElement.parentElement.parentElement.style.display = "none";


            } else {
                $('.check2').append('<div class="row remove"><div class="col-md-4"><div class="form-group"><label class="control-label">Stretch<span class="error-star" style="color:red;">*</span></label><div style="display: flex;"><select class="form-control" id="Stretch" name="Stretch" required><option>Stretch1</option><option>Stretch2</option><option>Stretch3</option></select></div></div></div><div class="col-md-4"><div class="form-group "><label class="control-label">Source Document<span class="error-star" style="color:red;">*</span></label> <div style="display: flex;"><select class="form-control" id="StretchSource" name="StretchSource" required><option>Hometracker(20-12)(20)</option><option>Weekly Feedback(10-12)(20)</option><option>Monthly Objectives</option></select></div></div></div><div class="col-sm-1"><div class="form-group" style="display: flex; flex-direction: column;align-items: center;"><label class="control-label" style="margin-left: 16px;">Record<span class="error-star" style="color:red;">*</span></label><input type="checkbox" id="record" name="record" value="record"></div></div><div class="col-md-3"><div class="form-group "><label class="control-label">Environment<span class="error-star"style="color:red;">*</span></label> <div style="display: flex;"><select class="form-control" id="Environment" name="Environment" required><option>Home</option><option>Home-OT</option><option>School-Spled</option></select></div></div></div><div class="form-group row"><div class="col-md-10" style="display: flex;flex-direction: column;align-items: center;"><label class="control-label">Evidence<span class="error-star" style="color:red;">*</span></label><textarea id="evidence" name="evidence" rows="6" cols="80"></textarea></div><div class="col-md-2"><button id="Addstretch1" name="Addstretch1" title="Remove Stretch" class="btn" type="button"> <i style="color: blue;font-size: 20px;" id="plus2" class="fa fa-minus-circle" aria-hidden="true"></i></button></div></div></div></div></div>');
                console.log(e.target.value);
            }


        }
        //alert('fw');



        const plusaddbox = document.querySelectorAll('#Addstretch1');
        //alert("bjs");
        //alert(plusaddbox.length);
        for (let i = 0; i < plusaddbox.length; i++) {
            // alert(i);
            plusaddbox[i].addEventListener("click", addStretchFunction);
        }
    }
    addstretch.addEventListener('click', addStretchFunction);
</script>



<script>
    let addopportunity = document.querySelector('#Addopportunity');

    function addOpportunityFunction(e) {
        //alert("hii");


        if (document.querySelector('[name="Opportunites"]').value == "") {
            Swal.fire("Please Select Opportunites: ", "", "error");
            return false;
        }
        if (document.querySelector('[name="opportunitySource"]').value == "") {
            Swal.fire("Please Select Source: ", "", "error");
            return false;
        } else {

        }


        if (e.target.id == 'plus2') {

            if (e.target.className == 'fa fa-minus-circle') {
                e.target.parentElement.parentElement.parentElement.parentElement.style.display = "none";


            } else {
                $('.check2').append('<div class="row remove"><div class="col-md-4"><div class="form-group"><label class="control-label">Opportunites<span class="error-star" style="color:red;">*</span></label><div style="display: flex;"><select class="form-control" id="Opportunites" name="Opportunites" required><option>Opportunity1</option><option>Opportunity2</option><option>Opportunity3</option></select></div></div></div><div class="col-md-4"><div class="form-group "><label class="control-label">Source Document<span class="error-star" style="color:red;">*</span></label> <div style="display: flex;"><select class="form-control" id="opportunitySource" name="opportunitySource" required><option>Hometracker(20-12)(20)</option><option>Weekly Feedback(10-12)(20)</option><option>Monthly Objectives</option></select></div></div></div><div class="col-sm-1"><div class="form-group" style="display: flex; flex-direction: column;align-items: center;"><label class="control-label" style="margin-left: 16px;">Record<span class="error-star" style="color:red;">*</span></label><input type="checkbox" id="record" name="record" value="record"></div></div><div class="col-md-3"><div class="form-group "><label class="control-label">Environment<span class="error-star"style="color:red;">*</span></label><div style="display: flex;"><select class="form-control" id="Environment" name="Environment" required><option>Home</option><option>Home-OT</option><option>School-Spled</option></select></div></div></div><div class="form-group row"><div class="col-md-10" style="display: flex;flex-direction: column;align-items: center;"><label class="control-label">Evidence<span class="error-star" style="color:red;">*</span></label><textarea id="evidence" name="evidence" rows="6" cols="80"></textarea></div><div class="col-md-2"><button id="Addopportunity" name="Addopportunity" title="Remove Opportunity" class="btn" type="button"> <i style="color: blue;font-size: 20px;" id="plus2" class="fa fa-minus-circle" aria-hidden="true"></i></button></div></div></div></div></div>');
                console.log(e.target.value);
            }

        } else {
            if (e.target.children[0].className == 'fa fa-minus-circle') {
                e.target.parentElement.parentElement.parentElement.style.display = "none";


            } else {
                $('.check2').append('<div class="row remove"><div class="col-md-4"><div class="form-group"><label class="control-label">Opportunites<span class="error-star" style="color:red;">*</span></label><div style="display: flex;"><select class="form-control" id="Opportunites" name="Opportunites" required><option>Opportunity1</option><option>Opportunity2</option><option>Opportunity3</option></select></div></div></div><div class="col-md-4"><div class="form-group "><label class="control-label">Source Document<span class="error-star" style="color:red;">*</span></label> <div style="display: flex;"><select class="form-control" id="opportunitySource" name="opportunitySource" required><option>Hometracker(20-12)(20)</option><option>Weekly Feedback(10-12)(20)</option><option>Monthly Objectives</option></select></div></div></div><div class="col-sm-1"><div class="form-group" style="display: flex; flex-direction: column;align-items: center;"><label class="control-label" style="margin-left: 16px;">Record<span class="error-star" style="color:red;">*</span></label><input type="checkbox" id="record" name="record" value="record"></div></div><div class="col-md-3"><div class="form-group "><label class="control-label">Environment<span class="error-star"style="color:red;">*</span></label> <div style="display: flex;"><select class="form-control" id="Environment" name="Environment" required><option>Home</option><option>Home-OT</option><option>School-Spled</option></select></div></div></div><div class="form-group row"><div class="col-md-10" style="display: flex;flex-direction: column;align-items: center;"><label class="control-label">Evidence<span class="error-star" style="color:red;">*</span></label><textarea id="evidence" name="evidence" rows="6" cols="80"></textarea></div><div class="col-md-2"><button id="Addopportunity" name="Addopportunity" title="Remove Opportunity" class="btn" type="button"> <i style="color: blue;font-size: 20px;" id="plus2" class="fa fa-minus-circle" aria-hidden="true"></i></button></div></div></div></div></div>');
                console.log(e.target.value);
            }


        }
        //alert('fw');



        const plusaddbox = document.querySelectorAll('#Addstretch1');
        //alert("bjs");
        //alert(plusaddbox.length);
        for (let i = 0; i < plusaddbox.length; i++) {
            // alert(i);
            plusaddbox[i].addEventListener("click", addOpportunityFunction);
        }
    }
    addopportunity.addEventListener('click', addOpportunityFunction);
</script>

<script>
    let addvitals = document.querySelector('#Addvitals');

    function addVitalsFunction(e) {
        //(e.target.id);



        if (document.querySelector('[name="Vitals"]').value == "") {
            Swal.fire("Please Select Vitals: ", "", "error");
            return false;
        }
        // if (document.querySelector('[name="evidence"]').value == "") {
        //     Swal.fire("Please Enter Evidence: ", "", "error");
        //     return false;
        // } 


        if (e.target.id == 'plus2') {

            if (e.target.className == 'fa fa-minus-circle') {
                e.target.parentElement.parentElement.style.display = "none";


            } else {
                $('.aftertherapist').append('<div class="row remove"><div class="col-md-3"><div class="form-group "><label class="control-label">Vitals<span class="error-star" style="color:red;">*</span></label><div style="display: flex;"><select class="form-control" id="Vitals" name="Vitals" required=""><option>Sleep routine</option><option>Food Habits</option><option>Screen time</option><option>Self Engagement time</option><option>Attendance</option><option> Consistency goals</option><option>Assigned Home Activities</option></select></div></div></div><div class="form-group"><div class="col-md-7"><label class="control-label">Notes<span class="error-star" style="color:red;">*</span></label><textarea id="evidence" name="evidence" rows="6" cols="60"></textarea></div></div><div class="col-sm-1"><button id="Addvitals" name="Addvitals" title="Remove Vitals" class="btn" type="button" value="plus1"><i style="color: blue;font-size: 20px;" id="plus2" class="fa fa-minus-circle" aria-hidden="true"></i></button></div></div></div>');
                //console.log(e.target.value);
            }

        } else {
            if (e.target.children[0].className == 'fa fa-minus-circle') {
                // console.log(e.target.parentElement.parentElement);
                e.target.parentElement.parentElement.style.display = "none";


            } else {
                $('.aftertherapist').append('<div class="row remove"><div class="col-md-3"><div class="form-group "><label class="control-label">Vitals<span class="error-star" style="color:red;">*</span></label><div style="display: flex;"><select class="form-control" id="Vitals" name="Vitals" required=""><option>Sleep routine</option><option>Food Habits</option><option>Screen time</option><option>Self Engagement time</option><option>Attendance</option><option> Consistency goals</option><option>Assigned Home Activities</option></select></div></div></div><div class="form-group"><div class="col-md-7"><label class="control-label">Notes<span class="error-star" style="color:red;">*</span></label><textarea id="evidence" name="evidence" rows="6" cols="60"></textarea></div></div><div class="col-sm-1"><button id="Addvitals" name="Addvitals" title="Remove Vitals" class="btn" type="button" value="plus1"><i style="color: blue;font-size: 20px;" id="plus2" class="fa fa-minus-circle" aria-hidden="true"></i></button></div></div></div>');
                // console.log(e.target.value);
            }


        }
        //alert('fw');



        const plusaddbox = document.querySelectorAll('#Addvitals');
        //alert("bjs");
        //alert(plusaddbox.length);
        for (let i = 0; i < plusaddbox.length; i++) {
            // alert(i);
            plusaddbox[i].addEventListener("click", addVitalsFunction);
        }
    }
    addvitals.addEventListener('click', addVitalsFunction);
</script>




<script>
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



    });
</script>
<script>
    function validateForm(e) {
        //alert("nkscn");


        //document.querySelector('.btn.btn-warning').value = e.target.value;

        //alert(e.target.value);

        if (e.target.value == "tab1saved") {
            //alert("tick");
            document.getElementById("step_value").value = "checked";
            document.querySelector('.md-step.active').children[0].style.backgroundColor = 'lime';
            document.querySelector('.md-step.active').children[0].innerHTML = '';

            document.querySelector('.md-step.active').children[0].innerHTML = '&#10003';
            document.querySelector('.md-step.active').children[0].style.display = "inline-block";
            document.querySelector('.md-step.active').children[0].style.fontSize = "20px";

            document.getElementById("tab1tick").style.display = "inline-block";
            document.getElementById("tab1tick").style.color = "white";
            document.getElementById("tab1tick").style.fontSize = "20px";
            document.getElementById("tab1tick").style.position = "absolute";
            document.getElementById("tab1tick").style.top = "6px";
            document.getElementById("tab1tick").style.left = "88px";
            document.getElementById("tab1tick").style.zIndex = "3";

        }

        if (e.target.value == "tab2saved") {
            // alert("tick");
            document.getElementById("step_value2").value = "checked";
            document.querySelector('.md-step.active').children[0].style.backgroundColor = 'lime';
            document.querySelector('.md-step.active').children[0].innerHTML = '';

            document.querySelector('.md-step.active').children[0].innerHTML = '&#10003';
            document.querySelector('.md-step.active').children[0].style.display = "inline-block";
            document.querySelector('.md-step.active').children[0].style.fontSize = "20px";

            document.getElementById("tab2tick").style.display = "inline-block";
            document.getElementById("tab2tick").style.color = "white";
            document.getElementById("tab2tick").style.fontSize = "20px";
            document.getElementById("tab2tick").style.position = "absolute";
            document.getElementById("tab2tick").style.top = "6px";
            document.getElementById("tab2tick").style.left = "93px";
            document.getElementById("tab2tick").style.zIndex = "3";

        }

        if (e.target.value == "tab3saved") {
            // alert("tick");
            document.getElementById("step_value3").value = "checked";
            document.querySelector('.md-step.active').children[0].style.backgroundColor = 'lime';
            document.querySelector('.md-step.active').children[0].innerHTML = '';

            document.querySelector('.md-step.active').children[0].innerHTML = '&#10003';
            document.querySelector('.md-step.active').children[0].style.display = "inline-block";
            document.querySelector('.md-step.active').children[0].style.fontSize = "20px";

            document.getElementById("tab3tick").style.display = "inline-block";
            document.getElementById("tab3tick").style.color = "white";
            document.getElementById("tab3tick").style.fontSize = "20px";
            document.getElementById("tab3tick").style.position = "absolute";
            document.getElementById("tab3tick").style.top = "6px";
            document.getElementById("tab3tick").style.left = "133px";
            document.getElementById("tab3tick").style.zIndex = "3";

        }

        if (e.target.value == "tab4saved") {
            // alert("tick");
            document.getElementById("step_value4").value = "checked";
            document.querySelector('.md-step.active').children[0].style.backgroundColor = 'lime';
            document.querySelector('.md-step.active').children[0].innerHTML = '';

            document.querySelector('.md-step.active').children[0].innerHTML = '&#10003';
            document.querySelector('.md-step.active').children[0].style.display = "inline-block";
            document.querySelector('.md-step.active').children[0].style.fontSize = "20px";

            document.getElementById("tab4tick").style.display = "inline-block";
            document.getElementById("tab4tick").style.color = "white";
            document.getElementById("tab4tick").style.fontSize = "20px";
            document.getElementById("tab4tick").style.position = "absolute";
            document.getElementById("tab4tick").style.top = "6px";
            document.getElementById("tab4tick").style.left = "102px";
            document.getElementById("tab4tick").style.zIndex = "3";

        }
        if (e.target.value == "tab5saved") {
            // alert("tick");
            document.getElementById("step_value5").value = "checked";
            document.querySelector('.md-step.active').children[0].style.backgroundColor = 'lime';
            document.querySelector('.md-step.active').children[0].innerHTML = '';

            document.querySelector('.md-step.active').children[0].innerHTML = '&#10003';
            document.querySelector('.md-step.active').children[0].style.display = "inline-block";
            document.querySelector('.md-step.active').children[0].style.fontSize = "20px";

            document.getElementById("tab5tick").style.display = "inline-block";
            document.getElementById("tab5tick").style.color = "white";
            document.getElementById("tab5tick").style.fontSize = "20px";
            document.getElementById("tab5tick").style.position = "absolute";
            document.getElementById("tab5tick").style.top = "6px";
            document.getElementById("tab5tick").style.left = "66px";
            document.getElementById("tab5tick").style.zIndex = "3";

        }
        if (e.target.value == "tab6saved") {
            // alert("tick");
            document.getElementById("step_value6").value = "checked";
            document.querySelector('.md-step.active').children[0].style.backgroundColor = 'lime';
            document.querySelector('.md-step.active').children[0].innerHTML = '';

            document.querySelector('.md-step.active').children[0].innerHTML = '&#10003';
            document.querySelector('.md-step.active').children[0].style.display = "inline-block";
            document.querySelector('.md-step.active').children[0].style.fontSize = "20px";

            document.getElementById("tab6tick").style.display = "inline-block";
            document.getElementById("tab6tick").style.color = "white";
            document.getElementById("tab6tick").style.fontSize = "20px";
            document.getElementById("tab6tick").style.position = "absolute";
            document.getElementById("tab6tick").style.top = "6px";
            document.getElementById("tab6tick").style.left = "140px";
            document.getElementById("tab6tick").style.zIndex = "3";

        }
        if (e.target.value == "tab7saved") {
            // alert("tick");
            document.getElementById("step_value7").value = "checked";
            document.querySelector('.md-step.active').children[0].style.backgroundColor = 'lime';
            document.querySelector('.md-step.active').children[0].innerHTML = '';

            document.querySelector('.md-step.active').children[0].innerHTML = '&#10003';
            document.querySelector('.md-step.active').children[0].style.display = "inline-block";
            document.querySelector('.md-step.active').children[0].style.fontSize = "20px";

            document.getElementById("tab7tick").style.display = "inline-block";
            document.getElementById("tab7tick").style.color = "white";
            document.getElementById("tab7tick").style.fontSize = "20px";
            document.getElementById("tab7tick").style.position = "absolute";
            document.getElementById("tab7tick").style.top = "6px";
            document.getElementById("tab7tick").style.left = "101px";
            document.getElementById("tab7tick").style.zIndex = "3";

        }

        if (e.target.value == "tab8saved") {
            // alert("tick");
            document.getElementById("step_value8").value = "checked";
            document.querySelector('.md-step.active').children[0].style.backgroundColor = 'lime';
            document.querySelector('.md-step.active').children[0].innerHTML = '';

            document.querySelector('.md-step.active').children[0].innerHTML = '&#10003';
            document.querySelector('.md-step.active').children[0].style.display = "inline-block";
            document.querySelector('.md-step.active').children[0].style.fontSize = "20px";

            document.getElementById("tab8tick").style.display = "inline-block";
            document.getElementById("tab8tick").style.color = "white";
            document.getElementById("tab8tick").style.fontSize = "20px";
            document.getElementById("tab8tick").style.position = "absolute";
            document.getElementById("tab8tick").style.top = "6px";
            document.getElementById("tab8tick").style.left = "111px";
            document.getElementById("tab8tick").style.zIndex = "3";

        }

        if (e.target.value == "tab9saved") {
            // alert("tick");
            document.getElementById("step_value9").value = "checked";
            document.querySelector('.md-step.active').children[0].style.backgroundColor = 'lime';
            document.querySelector('.md-step.active').children[0].innerHTML = '';

            document.querySelector('.md-step.active').children[0].innerHTML = '&#10003';
            document.querySelector('.md-step.active').children[0].style.display = "inline-block";
            document.querySelector('.md-step.active').children[0].style.fontSize = "20px";

            document.getElementById("tab9tick").style.display = "inline-block";
            document.getElementById("tab9tick").style.color = "white";
            document.getElementById("tab9tick").style.fontSize = "20px";
            document.getElementById("tab9tick").style.position = "absolute";
            document.getElementById("tab9tick").style.top = "6px";
            document.getElementById("tab9tick").style.left = "123px";
            document.getElementById("tab9tick").style.zIndex = "3";

        }

        if (e.target.value == "tab10saved") {
            // alert("tick");
            document.getElementById("step_value10").value = "checked";
            document.querySelector('.md-step.active').children[0].style.backgroundColor = 'lime';
            document.querySelector('.md-step.active').children[0].innerHTML = '';

            document.querySelector('.md-step.active').children[0].innerHTML = '&#10003';
            document.querySelector('.md-step.active').children[0].style.display = "inline-block";
            document.querySelector('.md-step.active').children[0].style.fontSize = "20px";

            document.getElementById("tab10tick").style.display = "inline-block";
            document.getElementById("tab10tick").style.color = "white";
            document.getElementById("tab10tick").style.fontSize = "20px";
            document.getElementById("tab10tick").style.position = "absolute";
            document.getElementById("tab10tick").style.top = "6px";
            document.getElementById("tab10tick").style.left = "125px";
            document.getElementById("tab10tick").style.zIndex = "3";

        }
        // document.getElementById('compassobservation').submit();

        //alert(step2);

    }
</script>

<script>
    function WeeklyWise(e) {


        var week1 = document.querySelectorAll('.week_btn');
        for (let i = 0; i < week1.length; i++) {
            //alert(i);
            week1[i].classList.remove('active-btn');

        }
        e.target.classList.add('active-btn');
        //alert("nkscn");
        var weekpagination = document.querySelectorAll('.week1');
        for (let i = 0; i < weekpagination.length; i++) {
            //alert(i);
            weekpagination[i].innerHTML = e.target.id;
            weekpagination[i].value = e.target.value;


        }

        var reflection = document.querySelectorAll('.wholecheck');
        for (let i = 0; i < reflection.length; i++) {
            //alert(i);
            reflection[i].style.display = 'none';

            setTimeout(func, 100);

            function func() {
                reflection[i].style.display = 'block';

            }

        }


        // document.querySelector('.week1').innerHTML = e.target.id;
        // document.querySelector('.week1').value = e.target.value;

        // document.querySelector('.wholecheck').style.display = 'none';


        if (e.target.id != 'week1') {
            //alert("previous");
            $('.previous_btn').removeClass('d-none');
        } else {
            $('.previous_btn').addClass('d-none');

        }

        if (e.target.id == 'week4') {
            // alert("previous");
            $('.next_btn').addClass('d-none');
        } else {
            $('.next_btn').removeClass('d-none');

        }


        // setTimeout(func, 100);

        // function func() {
        //     document.querySelector('.wholecheck').style.display = 'block';

        // }

    }
    $('.pagination_btn').click(pagination_custom);

    function pagination_custom(e) {


        if (e.target.innerText == '<') {
            var current_btn = $('.week1').val();

            var previous_btn = --current_btn;
            if (previous_btn >= 1) {
                $(`#week${previous_btn}`).click();

            }
        } else {
            var current_btn = $('.week1').val();

            var previous_btn = ++current_btn;

            if (previous_btn <= 4) {
                $(`#week${previous_btn}`).click();

            }

        }

    }
</script>
<script>
    function tabnavigation(e) {

        document.querySelector('.md-step.active').classList.remove('active');
        $(`[name='${e.target.parentElement.id}']`).addClass('active');
        window.location.href = `#${e.target.parentElement.id}`;
        help();
    }
</script>

<script>
    function previousnexttab(e) {
        if (e.target.className == 'swiper-button-prev swipenav') {
            let current_tab = document.querySelector('.md-step.active').getAttribute('value');
            let previous_tab = --current_tab;
            previous_tab = 'tab_'.concat(previous_tab);
            //numbers
            document.querySelector('.md-step.active').classList.remove('active');
            $(`[name='${previous_tab}']`).addClass('active');
            //tabs
            $(`#${previous_tab}`).children().click();
            window.location.href = `#${previous_tab}`;
        } else {
            let current_tab = document.querySelector('.md-step.active').getAttribute('value');
            let previous_tab = ++current_tab;
            previous_tab = 'tab_'.concat(previous_tab);
            //numbers
            document.querySelector('.md-step.active').classList.remove('active');
            $(`[name='${previous_tab}']`).addClass('active');
            //tabs
            $(`#${previous_tab}`).children().click();
            window.location.href = `#${previous_tab}`;

        }




        help();

    }

    function help() {
        let tab_name = document.querySelector('.md-step.active').getAttribute('name');
        //alert(tab_name);
        if (tab_name == 'tab_1') {
            document.querySelector('.swiper-button-prev').style.visibility = "hidden";
        } else {
            document.querySelector('.swiper-button-prev').style.visibility = "visible";

        }
        if (tab_name == 'tab_10') {
            //alert("ggh");
            document.querySelector('.swiper-button-next').style.visibility = "hidden";

        } else {
            document.querySelector('.swiper-button-next').style.visibility = "visible";

        }
        let tab_value = document.querySelector('.md-step.active').getAttribute('value');

        let card_id = 'card'.concat(tab_value);

        const all_cards = document.querySelectorAll('.card_custom');
        for (const all_card of all_cards) {


            all_card.classList.add('d-none');

        }
        $(`#${card_id}`).removeClass('d-none');



    }
</script>

<script>
    function ticker(value) {
        document.querySelector('.md-step.active').classList.remove('active');

        //value=6;
        let tab_id = 'tab_'.concat(value);
        //window.location.href='#tab_6';

        $(`[name='${tab_id}']`).addClass('active');
        // alert(tab_id);
        $(`#${tab_id}`).children().click();
        window.location.href = `#${tab_id}`;
        if (value == '6') {
            window.location.href = '#tab_10';
        }

        help();

    }
</script>
<script type="text/javascript">
    $(document).ready(function() {
        const tab_button = document.querySelectorAll('#home-tab');
        for (const tab_buttons of tab_button) {
            tab_buttons.addEventListener('click', tabnavigation);

        }
    });
    //validation -->
</script>
<script type="text/javascript">
    $(document).ready(function() {

        tinymce.init({
            selector: 'textarea#meeting_description',
            height: 200,

            menubar: false,
            branding: false,
            toolbar: 'undo redo | formatselect | ' +
                'bold italic backcolor | alignleft aligncenter ' +
                'alignright alignjustify | bullist numlist outdent indent | ' +
                'removeformat | help',
            content_style: 'body { font-family:Helvetica,Arial,sans-serif; font-size:14px }'
        });
        event.preventDefault()

    });
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-U1DAWAznBHeqEIlVSCgzq+c9gqGAJn5c/t99JyeKa9xxaYpSvHU5awsuZVVFIhvj" crossorigin="anonymous"></script>
<!-- Stepper JavaScript -->
<script>
    const stepButtons = document.querySelectorAll('.step-button');
    const progress = document.querySelector('#progress');

    Array.from(stepButtons).forEach((button, index) => {
        button.addEventListener('click', () => {
            progress.setAttribute('value', index * 100 / (stepButtons.length - 1)); //there are 3 buttons. 2 spaces.

            stepButtons.forEach((item, secindex) => {
                if (index > secindex) {
                    item.classList.add('done');
                }
                if (index < secindex) {
                    item.classList.remove('done');
                }
            })
        })
    })
</script>

<script>
  function send()

  {
    window.location.href = "/monthlycompassobservation";
  }
</script>








@endsection