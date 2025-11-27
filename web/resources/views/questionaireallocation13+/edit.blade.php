@extends('layouts.adminnav')

@section('content')
<style>
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

    .select2-container {
        width: 100% !important;
    }

    .select2-container--default .select2-selection--multiple .select2-selection__choice {
        color: black !important;
    }

    .select2-container--default .select2-results__option--highlighted[aria-selected=true] {
        background-color: gray;
    }
</style>
<style>
    @import url("https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&display=swap");

    :root {
        --primary-color: #185ee0;
        --secondary-color: #e6eef9;
    }

    *,
    *:after,
    *:before {
        box-sizing: border-box;
    }

    body {
        font-family: "Inter", sans-serif;
        background-color: rgba(#e6eef9, 0.5);
    }

    .container {
        position: absolute;
        left: 0;
        top: 0;
        right: 0;
        bottom: 0;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .tabs {
        display: flex;
        position: relative;
        background-color: #fff;
        box-shadow: 0 0 1px 0 rgba(#185ee0, 0.15), 0 6px 12px 0 rgba(#185ee0, 0.15);
        padding: 0.75rem;
        border-radius: 99px; // just a high number to create pill effect

        * {
            z-index: 2;
        }
    }

    input[type="radio"] {
        display: none;
    }

    .tab {
        display: flex;
        align-items: center;
        justify-content: center;
        height: 54px;
        width: 200px;
        font-size: 1.25rem;
        font-weight: 500;
        border-radius: 99px; // just a high number to create pill effect
        cursor: pointer;
        transition: color 0.15s ease-in;
    }

    .notification {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 2rem;
        height: 2rem;
        margin-left: 0.75rem;
        border-radius: 50%;
        background-color: #f37020;
        transition: 0.15s ease-in;
    }

    input[type="radio"] {
        &:checked {
            &+label {
                color: #fff;
                background-color: #351e90;

                &>.notification {
                    background-color: #fff;
                    color: black;
                }
            }
        }
    }

    input[id="radio-1"] {
        &:checked {
            &~.glider {
                transform: translateX(0);
            }
        }
    }

    input[id="radio-2"] {
        &:checked {
            &~.glider {
                transform: translateX(100%);
            }
        }
    }

    input[id="radio-3"] {
        &:checked {
            &~.glider {
                transform: translateX(200%);
            }
        }
    }

    .glider {
        position: absolute;
        display: flex;
        height: 54px;
        width: 200px;
        /* background-color: #083572; */
        z-index: 1;
        border-radius: 99px; // just a high number to create pill effect
        transition: 0.25s ease-out;
        color: white;
    }

    @media (max-width: 700px) {
        .tabs {
            transform: scale(0.6);
        }
    }

    /* .nav-link {
        color: black !important;
    } */

    .nav-link1:checked {
        color: black !important;
    }

    #myTabs {
        /* border: 1px solid background-color: #351e90;; */

        border: 1px solid #351e90;
        /* background-color: #d4d0cf; */
        border-radius: 36px;
        justify-content: center;
        width: fit-content;
        /* margin: auto; */
        text-align: center;
    }

    .trash {
        color: red !important;
    }

    .selectedQuestionnaire {
        height: 100px !important;
        overflow-y: scroll;
    }

    .stepwizard-step p {
        margin-top: 10px;
    }

    .stepwizard-row {
        display: table-row;
    }

    .stepwizard {
        display: table;
        width: 100%;
        position: relative;
    }

    .stepwizard-step button[disabled] {
        opacity: 1 !important;
        filter: alpha(opacity=100) !important;
    }

    .stepwizard-row:before {
        top: 14px;
        bottom: 0;
        position: absolute;
        content: " ";
        width: 100%;
        height: 1px;
        background-color: #ccc;
        z-order: 0;
    }

    .stepwizard-step {
        display: table-cell;
        text-align: center;
        position: relative;
    }

    .btn-circle {
        width: 30px;
        height: 30px;
        text-align: center;
        padding: 6px 0;
        font-size: 12px;
        line-height: 1.428571429;
        border-radius: 15px;
    }

    .check-mark {
        display: none;
        position: absolute;
        top: -10px;
        left: 50%;
        transform: translateX(-50%);
        font-size: 20px;
        color: green;
        /* Adjust color based on your design */
    }

    .wrong-mark {
        display: none;
        position: absolute;
        top: -10px;
        left: 50%;
        transform: translateX(-50%);
        font-size: 20px;
        color: red;
        /* Adjust color based on your design */
    }

    .md-stepper-horizontal {
        display: table;
        width: 100%;
        margin: 0 auto;
        background-color: #FFFFFF;
        box-shadow: 0 3px 8px -6px rgba(0, 0, 0, .50);
    }

    .md-stepper-horizontal .md-step {
        display: table-cell;
        position: relative;
        padding: 24px;
    }

    .md-stepper-horizontal .md-step:hover,
    .md-stepper-horizontal .md-step:active {
        background-color: rgba(0, 0, 0, 0.04);
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

    /* .md-stepper-horizontal .md-step.done .md-step-circle:before {
	font-family:'FontAwesome';
	font-weight:100;
	content: "\f00c";
} */
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

    .gfg_tooltip {

        font-size: 16px;
    }

    .gfg_tooltip .gfg_text {
        visibility: visible;
        width: 79px;
        background-color: #F96302;
        color: white;
        text-align: center;
        border-radius: 14px;
        padding: 5px 0;
        position: absolute;
        z-index: 1;
        top: -20%;
        right: 36%;
    }

    /*           
        .gfg_tooltip .gfg_text::after { 
            content: "";
    position: absolute;
    top: 53%;
    left: 100%;
    margin-top: 4px;
    border-width: 5px;
    border-style: solid;
    border-color: transparent transparent transparent black;
        }  */

    /* .gfg_tooltip:hover .gfg_text { 
            visibility: visible; 
        } 
   */
</style>

<div class="main-content">
    <!-- Main Content -->
    <section class="section">
        {{ Breadcrumbs::render('questionnaire_allocation13.create') }}
        <div class="section-body mt-1">
            <h5 class="text-center" style="color:darkblue">13+Questionnaire Allocation Edit</h5>
            <div class="row">
                <div class="col-12">

                    <div class="card">
                        <div class="card-body">

                            <!-- <form method="POST" action="{{ route('ovm1.store') }}"> -->
                            <form action="" method="" id="enrollement" enctype="multipart/form-data">



                                <input type="hidden" name="stage" value="sail">

                                <div class="row is-coordinate">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="control-label required">Enrollment Number</label>
                                            <input class="form-control" type="text" id="enrollment_id" name="enrollment_id" placeholder="enrollment_id" value="EN/2023/12/070(Pavani)"autocomplete="off">




                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="control-label required">Child ID</label>
                                            <input class="form-control" type="text" id="child_id" name="child_id" placeholder="Child ID" value="CH/2023/070" autocomplete="off">
                                        </div>
                                    </div>



                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="control-label required">Child Name</label>
                                            <input class="form-control" type="text" id="child_name" name="child_name"  maxlength="20" value="Pavani" placeholder="Enter Name" autocomplete="off">
                                        </div>
                                    </div>



                                    <div class="form-group row" style="margin-bottom: 5px;" id="chooseQuestionnaire">
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label class="control-label required">Category</label>

                                                <select class="form-control" id="Category" name="Category" onchange="categorizedquestion()" disable>
                                                    <option value="">Select-Category</option>


                                                    <option value="1" selected>Parent</option>
                                                    <option value="2">Child</option>



                                                </select>



                                            </div>
                                        </div>
                                        <div class="col-md-6 versionlist">
                                            <label class="col-sm-8 control-label col-form-label">Questionnaire Name<span class="error-star" style="color:red;">*</span></label>
                                            <div class="row">
                                                <a href="#addModal2" data-toggle="modal" data-target="#addModal2" class="btn btn-primary modalbtn" title="View" data-toggle="modal" data-target="#templates" style="margin-inline:5px;height: 36px;"><i class="fa fa-bars" style="color:white!important"></i></a>
                                                <div id="selectedQuestionnaire" class="col-md-10 form-control selectedQuestionnaire" multiple="multiple" data-value="0">
                                                    <!-- <input class="form-control" id="questionnaire_id" multiple="multiple" name="questionnaire_id[]"> -->
                                                    <div class="col-md-12 pb-2">
                        <span type="text" class="col-md-9  btn" value="Study skills" readonly="" style="background: darkblue;color: white;">Study skills<a onclick="removeQuestionnaire(this)"><i class="fa fa-times col-md-3"></i></a></span>
                    </div>

                                                </div>
                                            </div>

                                        </div>

                                        
                                        <input type="hidden" id="paymenttokentime" name="paymenttokentime" value="">
                                        <div class="col-md-3">
                                            <label class="col-sm-3 control-label col-form-label">Status</label> <br>
                                            <input class="form-control" type="text" id="payment_status" name="status" value="Saved" placeholder="New" autocomplete="off" readonly>
                                        </div>
                                        <input type="hidden" id="btn_status" name="btn_status" value="">
                                        <input type="hidden" id="userID" name="userID" value="">



                                    </div>



                                </div>
                                <div class="col-md-12  text-center" style="padding-top: 1rem;">
                                    <!-- <a type="button" onclick="buttonAction('Saved')" class="btn btn-warning" name="type" value="save">Save</a>
                    <a type="button" onclick="buttonAction('Sent')" class="btn btn-success" name="type" value="sent">Submit</a>
                    <button type="" class="btn btn-danger">Cancel</button> -->
                                    <a type="button" onclick="buttonAction('Save')" id="savebutton" class="btn btn-labeled" title="Save Questionnaire" style="background: darkblue !important;color:white !important">
                                        <span class="btn-label" style="font-size:13px !important;"><i class="fa fa-check"></i></span>Save</a>
                                    <a type="button" class="btn btn-labeled back-btn" title="Back" href="{{ route('questionnaire_allocation13.index') }}" style="color:white !important">
                                        <span class="btn-label" style="font-size:13px !important;"><i class="fa fa-arrow-left"></i></span> Back</a>

                                </div>
                        </div>
                    </div>
                </div>

            </div>
            <br>


        </div>

        </br>

        <div class="row qtabs" style="">
            <div class="col-12">

                <div class="card">
                    <div class="card-body">

                        <form method="" id="enrollement" enctype="multipart/form-data">
                            <div class="col-md-12">
                                <div class="">
                                    <div class="">

                                        <div class="md-stepper-horizontal orange">

                                            <div class="md-step active done">
                                                <div class="md-step-circle" onclick="switchTab(1)">
                                                </div>
                                                <div class="md-step-content" style="display:block !important;">
                                                    <a class="gfg_tooltip">
                                                        <span class="gfg_text">
                                                            0/9
                                                        </span>
                                                    </a>

                                                </div>


                                                <!-- <div class="md-step-title">Step 1</div> -->
                                                <div class="md-step-bar-left"></div>
                                                <div class="md-step-bar-right"></div>
                                            </div>
                                            <div class="md-step">
                                                <div class="md-step-circle" onclick="switchTab(2)">
                                                </div>
                                                <div class="md-step-content" style="display:block !important;">
                                                    <a class="gfg_tooltip">
                                                        <span class="gfg_text">
                                                            0/30
                                                        </span>
                                                    </a>

                                                </div>
                                                <!-- <div class="md-step-title">Step 2</div> -->
                                                <div class="md-step-bar-left"></div>
                                                <div class="md-step-bar-right"></div>
                                            </div>
                                            <div class="md-step">
                                                <div class="md-step-circle" onclick="switchTab(3)">
                                                </div>
                                                <div class="md-step-content" style="display:block !important;">
                                                    <a class="gfg_tooltip">
                                                        <span class="gfg_text">
                                                            0/30
                                                        </span>
                                                    </a>

                                                </div>
                                                <!-- <div class="md-step-title">Step 3</div> -->
                                                <div class="md-step-bar-left"></div>
                                                <div class="md-step-bar-right"></div>
                                            </div>
                                        </div>

                                    </div>
                                    <br>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <ul class="nav" id="myTabs">
                                                <li class="nav-item">
                                                    <input type="radio" id="radio-1" name="tabs" class="nav-link1" checked />
                                                    <label class="tab nav-link1 mb-0" for="radio-1">Questionnaire1</label>
                                                </li>
                                                <li class="nav-item">
                                                    <input type="radio" id="radio-2" name="tabs" class="nav-link1" />
                                                    <label class="tab nav-link1 mb-0" for="radio-2">Questionnaire2</label>
                                                </li>
                                                <li class="nav-item">
                                                    <input type="radio" id="radio-3" name="tabs" class="nav-link1" />
                                                    <label class="tab nav-link1 mb-0" for="radio-3">Questionnaire3</label>
                                                </li>
                                            </ul>
                                            <div class="tab-content">
                                                <div class="tab-pane fade show setup-content active" id="tabContent1">

                                                    <div class="card question" id="list_section">
                                                        <div class="card-body">
                                                            <div class="table-wrapper">
                                                                <div class="table-responsive">

                                                                    <table class="table table-bordered" id="alignq1">
                                                                        <thead>
                                                                            <tr>
                                                                                <th>Sl.No</th>
                                                                                <th>Question Name</th>
                                                                                <th width="20%">Action</th>
                                                                                <th>Active Status</th>
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody>

                                                                            <tr>
                                                                                <td>1</td>
                                                                                <td>Your Name</td>
                                                                                <td>
                                                                                    <a class="btn btn-link" onclick="edit_question('1')" title="Edit" data-toggle="modal" data-target="#editmodulemodal{{'1'}}" style="color:darkblue"><i class="fas fa-pencil-alt"></i></a>
                                                                                    <a type="button" value="Cancel" class="" data-toggle="modal" data-target="#addmodulemodal" title="Add a question" style="color:green !important">
                                                                                        <i class="fa fa-plus"></i></a>

                                                                                </td>
                                                                                <td style="text-align: center;">
                                                                                    <label class="switch " data-bs-toggle="tooltip" data-bs-placement="top" title="Enable">
                                                                                        <input type="hidden" name="toggle_id" value="1">
                                                                                        <input type="checkbox" class="toggle_status" onclick="functiontoggle('1')" id="is_active{{'1'}}" name="is_active" checked disabled>
                                                                                        <span class="slider round"></span>
                                                                                    </label>

                                                                                </td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td>2</td>
                                                                                <td>D.O.B</td>
                                                                                <td>
                                                                                    <a class="btn btn-link" onclick="edit_question('1')" title="Edit" data-toggle="modal" data-target="#editmodulemodal{{'1'}}" style="color:darkblue"><i class="fas fa-pencil-alt"></i></a>
                                                                                    <a type="button" value="Cancel" class="" data-toggle="modal" data-target="#addmodulemodal" title="Add a question" style="color:green !important">
                                                                                        <i class="fa fa-plus"></i></a>

                                                                                </td>
                                                                                <td style="text-align: center;">
                                                                                    <label class="switch " data-bs-toggle="tooltip" data-bs-placement="top" title="Enable / Disable">
                                                                                        <input type="hidden" name="toggle_id" value="1">
                                                                                        <input type="checkbox" class="toggle_status" onclick="functiontoggle('1')" id="is_active{{'1'}}" name="is_active" checked disabled>
                                                                                        <span class="slider round"></span>
                                                                                    </label>

                                                                                </td>
                                                                            </tr>

                                                                            <tr>
                                                                                <td>3</td>
                                                                                <td>My child has trouble following multi-step instructions</td>
                                                                                <td>
                                                                                    <a class="btn btn-link" onclick="edit_question('1')" title="Edit" data-toggle="modal" data-target="#editmodulemodal{{'1'}}" style="color:darkblue"><i class="fas fa-pencil-alt"></i></a>
                                                                                    <a type="button" value="Cancel" class="" data-toggle="modal" data-target="#addmodulemodal" title="Add a question" style="color:green !important">
                                                                                        <i class="fa fa-plus"></i></a>

                                                                                </td>
                                                                                <td style="text-align: center;">
                                                                                    <label class="switch " data-bs-toggle="tooltip" data-bs-placement="top" title="Enable / Disable">
                                                                                        <input type="hidden" name="toggle_id" value="1">
                                                                                        <input type="checkbox" class="toggle_status" onclick="functiontoggle('1')" id="is_active{{'1'}}" name="is_active" checked>
                                                                                        <span class="slider round"></span>
                                                                                    </label>

                                                                                </td>
                                                                            </tr>

                                                                            <tr>
                                                                                <td>4</td>
                                                                                <td>My child acts like or reports being bored</td>
                                                                                <td>
                                                                                    <a class="btn btn-link" onclick="edit_question('1')" title="Edit" data-toggle="modal" data-target="#editmodulemodal{{'1'}}" style="color:darkblue"><i class="fas fa-pencil-alt"></i></a>
                                                                                    <a type="button" value="Cancel" class="" data-toggle="modal" data-target="#addmodulemodal" title="Add a question" style="color:green !important">
                                                                                        <i class="fa fa-plus"></i></a>

                                                                                </td>
                                                                                <td style="text-align: center;">
                                                                                    <label class="switch " data-bs-toggle="tooltip" data-bs-placement="top" title="Enable / Disable">
                                                                                        <input type="hidden" name="toggle_id" value="1">
                                                                                        <input type="checkbox" class="toggle_status" onclick="functiontoggle('1')" id="is_active{{'1'}}" name="is_active" checked>
                                                                                        <span class="slider round"></span>
                                                                                    </label>

                                                                                </td>
                                                                            </tr>

                                                                            <tr>
                                                                                <td>5</td>
                                                                                <td>My child is easily distracted by noises, activities, and other external stimulation</td>
                                                                                <td>
                                                                                    <a class="btn btn-link" onclick="edit_question('1')" title="Edit" data-toggle="modal" data-target="#editmodulemodal{{'1'}}" style="color:darkblue"><i class="fas fa-pencil-alt"></i></a>
                                                                                    <a type="button" value="Cancel" class="" data-toggle="modal" data-target="#addmodulemodal" title="Add a question" style="color:green !important">
                                                                                        <i class="fa fa-plus"></i></a>

                                                                                </td>
                                                                                <td style="text-align: center;">
                                                                                    <label class="switch " data-bs-toggle="tooltip" data-bs-placement="top" title="Enable / Disable">
                                                                                        <input type="hidden" name="toggle_id" value="1">
                                                                                        <input type="checkbox" class="toggle_status" onclick="functiontoggle('1')" id="is_active{{'1'}}" name="is_active" checked>
                                                                                        <span class="slider round"></span>
                                                                                    </label>

                                                                                </td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td>6</td>
                                                                                <td>My child doesn't procrastinate</td>
                                                                                <td>
                                                                                    <a class="btn btn-link" onclick="edit_question('1')" title="Edit" data-toggle="modal" data-target="#editmodulemodal{{'1'}}" style="color:darkblue"><i class="fas fa-pencil-alt"></i></a>
                                                                                    <a type="button" value="Cancel" class="" data-toggle="modal" data-target="#addmodulemodal" title="Add a question" style="color:green !important">
                                                                                        <i class="fa fa-plus"></i></a>

                                                                                </td>
                                                                                <td style="text-align: center;">
                                                                                    <label class="switch " data-bs-toggle="tooltip" data-bs-placement="top" title="Enable / Disable">
                                                                                        <input type="hidden" name="toggle_id" value="1">
                                                                                        <input type="checkbox" class="toggle_status" onclick="functiontoggle('1')" id="is_active{{'1'}}" name="is_active" checked>
                                                                                        <span class="slider round"></span>
                                                                                    </label>

                                                                                </td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td>7</td>
                                                                                <td>My child has difficulty switching from one activity to another</td>
                                                                                <td>
                                                                                    <a class="btn btn-link" onclick="edit_question('1')" title="Edit" data-toggle="modal" data-target="#editmodulemodal{{'1'}}" style="color:darkblue"><i class="fas fa-pencil-alt"></i></a>
                                                                                    <a type="button" value="Cancel" class="" data-toggle="modal" data-target="#addmodulemodal" title="Add a question" style="color:green !important">
                                                                                        <i class="fa fa-plus"></i></a>

                                                                                </td>
                                                                                <td style="text-align: center;">
                                                                                    <label class="switch " data-bs-toggle="tooltip" data-bs-placement="top" title="Enable / Disable">
                                                                                        <input type="hidden" name="toggle_id" value="1">
                                                                                        <input type="checkbox" class="toggle_status" onclick="functiontoggle('1')" id="is_active{{'1'}}" name="is_active" checked>
                                                                                        <span class="slider round"></span>
                                                                                    </label>

                                                                                </td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td>8</td>
                                                                                <td>My child can disagree with friends and still like them</td>
                                                                                <td>
                                                                                    <a class="btn btn-link" onclick="edit_question('1')" title="Edit" data-toggle="modal" data-target="#editmodulemodal{{'1'}}" style="color:darkblue"><i class="fas fa-pencil-alt"></i></a>
                                                                                    <a type="button" value="Cancel" class="" data-toggle="modal" data-target="#addmodulemodal" title="Add a question" style="color:green !important">
                                                                                        <i class="fa fa-plus"></i></a>

                                                                                </td>
                                                                                <td style="text-align: center;">
                                                                                    <label class="switch " data-bs-toggle="tooltip" data-bs-placement="top" title="Enable / Disable">
                                                                                        <input type="hidden" name="toggle_id" value="1">
                                                                                        <input type="checkbox" class="toggle_status" onclick="functiontoggle('1')" id="is_active{{'1'}}" name="is_active" checked>
                                                                                        <span class="slider round"></span>
                                                                                    </label>

                                                                                </td>
                                                                            </tr>

                                                                        </tbody>
                                                                    </table>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!-- <a type="button" class="prevButton" onclick="prevTab()" class="btn btn-primary">Previous</a>
                                                    <a type="button" class="nextButton" onclick="nextTab()" class="btn btn-primary">Next</a> -->
                                                </div>
                                                <div class="tab-pane fade" id="tabContent2">

                                                    <div class="card question" id="list_section">
                                                        <div class="card-body">
                                                            <div class="table-wrapper">
                                                                <div class="table-responsive">
                                                                    <table class="table table-bordered" id="alignq3">
                                                                        <thead>
                                                                            <tr>
                                                                                <th>Sl.No</th>
                                                                                <th>Question Name</th>
                                                                                <th width="20%">Action</th>
                                                                                <th>Active Status</th>
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody>

                                                                            <tr>
                                                                                <td>1</td>
                                                                                <td>Your Name</td>
                                                                                <td>
                                                                                    <a class="btn btn-link" onclick="edit_question('1')" title="Edit" data-toggle="modal" data-target="#editmodulemodal{{'1'}}" style="color:darkblue"><i class="fas fa-pencil-alt"></i></a>

                                                                                    <input type="hidden" name="delete_id" id="1" value="{{ route('question_creation.data_delete',1) }}">
                                                                                    <a type="button" value="Cancel" class="" data-toggle="modal" data-target="#addmodulemodal" title="Add a question" style="color:green !important">
                                                                                        <i class="fa fa-plus"></i></a>

                                                                                </td>
                                                                                <td style="text-align: center;">
                                                                                    <label class="switch " data-bs-toggle="tooltip" data-bs-placement="top" title="Enable/Disable">
                                                                                        <input type="hidden" name="toggle_id" value="1">
                                                                                        <input type="checkbox" class="toggle_status" onclick="functiontoggle('1')" id="is_active{{'1'}}" name="is_active" checked>
                                                                                        <span class="slider round"></span>
                                                                                    </label>

                                                                                </td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td>2</td>
                                                                                <td>D.O.B</td>
                                                                                <td>
                                                                                    <a class="btn btn-link" onclick="edit_question('1')" title="Edit" data-toggle="modal" data-target="#editmodulemodal{{'1'}}" style="color:darkblue"><i class="fas fa-pencil-alt"></i></a>
                                                                                    <a type="button" value="Cancel" class="" data-toggle="modal" data-target="#addmodulemodal" title="Add a question" style="color:green !important">
                                                                                        <i class="fa fa-plus"></i></a>

                                                                                    <input type="hidden" name="delete_id" id="1" value="{{ route('question_creation.data_delete',1) }}">
                                                                                </td>
                                                                                <td style="text-align: center;">
                                                                                    <label class="switch " data-bs-toggle="tooltip" data-bs-placement="top" title="Enable / Disable">
                                                                                        <input type="hidden" name="toggle_id" value="1">
                                                                                        <input type="checkbox" class="toggle_status" onclick="functiontoggle('1')" id="is_active{{'1'}}" name="is_active" checked>
                                                                                        <span class="slider round"></span>
                                                                                    </label>

                                                                                </td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td>3</td>
                                                                                <td>I don’t jump to conclusions</td>
                                                                                <td>
                                                                                    <a class="btn btn-link" onclick="edit_question('1')" title="Edit" data-toggle="modal" data-target="#editmodulemodal{{'1'}}" style="color:darkblue"><i class="fas fa-pencil-alt"></i></a>
                                                                                    <a type="button" value="Cancel" class="" data-toggle="modal" data-target="#addmodulemodal" title="Add a question" style="color:green !important">
                                                                                        <i class="fa fa-plus"></i></a>

                                                                                    <input type="hidden" name="delete_id" id="1" value="{{ route('question_creation.data_delete',1) }}">
                                                                                </td>
                                                                                <td style="text-align: center;">
                                                                                    <label class="switch " data-bs-toggle="tooltip" data-bs-placement="top" title="Enable / Disable">
                                                                                        <input type="hidden" name="toggle_id" value="1">
                                                                                        <input type="checkbox" class="toggle_status" onclick="functiontoggle('1')" id="is_active{{'1'}}" name="is_active" checked>
                                                                                        <span class="slider round"></span>
                                                                                    </label>

                                                                                </td>
                                                                            </tr>

                                                                        </tbody>
                                                                    </table>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!-- <a type="button" class="prevButton" onclick="prevTab()" class="btn btn-primary">Previous</a>
                                                    <a type="button" class="nextButton" onclick="nextTab()" class="btn btn-primary">Next</a> -->
                                                </div>
                                                <div class="tab-pane fade" id="tabContent3">

                                                    <div class="card question" id="list_section">
                                                        <div class="card-body">
                                                            <div class="table-wrapper">
                                                                <div class="table-responsive">
                                                                    <table class="table table-bordered" id="alignq2">
                                                                        <thead>
                                                                            <tr>
                                                                                <th>Sl.No</th>
                                                                                <th>Question Name</th>
                                                                                <th width="20%">Action</th>
                                                                                <th>Active Status</th>
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody>

                                                                            <tr>
                                                                                <td>1</td>
                                                                                <td>Your Name</td>
                                                                                <td>
                                                                                    <a class="btn btn-link" onclick="edit_question('1')" title="Edit" data-toggle="modal" data-target="#editmodulemodal{{'1'}}" style="color:darkblue"><i class="fas fa-pencil-alt"></i></a>
                                                                                    <a type="button" value="Cancel" class="" data-toggle="modal" data-target="#addmodulemodal" title="Add a question" style="color:green !important">
                                                                                        <i class="fa fa-plus"></i></a>

                                                                                    <input type="hidden" name="delete_id" id="1" value="{{ route('question_creation.data_delete',1) }}">
                                                                                </td>
                                                                                <td style="text-align: center;">
                                                                                    <label class="switch " data-bs-toggle="tooltip" data-bs-placement="top" title="Enable / Disable">
                                                                                        <input type="hidden" name="toggle_id" value="1">
                                                                                        <input type="checkbox" class="toggle_status" onclick="functiontoggle('1')" id="is_active{{'1'}}" name="is_active" checked>
                                                                                        <span class="slider round"></span>
                                                                                    </label>

                                                                                </td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td>2</td>
                                                                                <td>D.O.B</td>
                                                                                <td>
                                                                                    <a class="btn btn-link" onclick="edit_question('1')" title="Edit" data-toggle="modal" data-target="#editmodulemodal{{'1'}}" style="color:darkblue"><i class="fas fa-pencil-alt"></i></a>
                                                                                    <a type="button" value="Cancel" class="" data-toggle="modal" data-target="#addmodulemodal" title="Add a question" style="color:green !important">
                                                                                        <i class="fa fa-plus"></i></a>

                                                                                    <input type="hidden" name="delete_id" id="1" value="{{ route('question_creation.data_delete',1) }}">
                                                                                </td>
                                                                                <td style="text-align: center;">
                                                                                    <label class="switch " data-bs-toggle="tooltip" data-bs-placement="top" title="Enable / Disable">
                                                                                        <input type="hidden" name="toggle_id" value="1">
                                                                                        <input type="checkbox" class="toggle_status" onclick="functiontoggle('1')" id="is_active{{'1'}}" name="is_active" checked>
                                                                                        <span class="slider round"></span>
                                                                                    </label>

                                                                                </td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td>3</td>
                                                                                <td>I don’t jump to conclusions</td>
                                                                                <td>
                                                                                    <a class="btn btn-link" onclick="edit_question('1')" title="Edit" data-toggle="modal" data-target="#editmodulemodal{{'1'}}" style="color:darkblue"><i class="fas fa-pencil-alt"></i></a>
                                                                                    <a type="button" value="Cancel" class="" data-toggle="modal" data-target="#addmodulemodal" title="Add a question" style="color:green !important">
                                                                                        <i class="fa fa-plus"></i></a>

                                                                                    <input type="hidden" name="delete_id" id="1" value="{{ route('question_creation.data_delete',1) }}">
                                                                                </td>
                                                                                <td style="text-align: center;">
                                                                                    <label class="switch " data-bs-toggle="tooltip" data-bs-placement="top" title="Enable / Disable">
                                                                                        <input type="hidden" name="toggle_id" value="1">
                                                                                        <input type="checkbox" class="toggle_status" onclick="functiontoggle('1')" id="is_active{{'1'}}" name="is_active" checked>
                                                                                        <span class="slider round"></span>
                                                                                    </label>

                                                                                </td>
                                                                            </tr>

                                                                        </tbody>
                                                                    </table>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!-- <a type="button" class="prevButton" onclick="prevTab()" class="btn btn-primary">Previous</a>
                                                    <a type="button" class="nextButton" onclick="nextTab()" class="btn btn-primary">Next</a> -->
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>



                            </div>


                    </div>
                </div>
                <div class="col-md-12  text-center" style="padding-top: 1rem;">
                    <!-- <a type="button" onclick="buttonAction('Saved')" class="btn btn-warning" name="type" value="save">Save</a>
                    <a type="button" onclick="buttonAction('Sent')" class="btn btn-success" name="type" value="sent">Submit</a>
                    <button type="" class="btn btn-danger">Cancel</button> -->
                    <a type="button" onclick="buttonAction('Save')" id="savebutton" class="btn btn-labeled" title="Save Questionnaire" style="background: darkblue !important;color:white !important">
                        <span class="btn-label" style="font-size:13px !important;"><i class="fa fa-check"></i></span>Save</a>

                    <a type="button" onclick="buttonAction('Sent')" id="submitbutton" class="btn btn-labeled btn-succes" title="Allocate Questionnaire" style="background: green !important; border-color:green !important; color:white !important">
                        <span class="btn-label" style="font-size:13px !important;"><i class="fa fa-check"></i></span>Allocate</a>
                    <a type="button" href="{{ route('questionnaire_allocation13.get_preview') }}" id="previewbutton" class="btn btn-labeled btn-warning" title="Preview Questionnaire" style="background: orange !important; border-color:orange !important; color:white !important">
                        <span class="btn-label" style="font-size:13px !important;"><i class="fa fa-check"></i></span>Preview</a>


                </div>
            </div>
        </div>


        </form>
    </section>
</div>


</div>
</div>





</div>
</div>
<div class="modal fade" id="addModal2">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="main-contents">
                <section class="section">
                    <div class="modal-header bg-primary" style=" background-color: rgb(0 103 172) !important;">
                        <h4 class="modal-title">Questionnaire Versions</h4>
                        <!-- <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button> -->
                    </div>
                    <div class="modal-body" style="">
                        <div class="section-body mt-2">
                            <div class="row">
                                <div class="col-12">
                                    <div class="mt-0 ">
                                        <div class="card-body" id="" style="background-color: #a0c4e3 !important;">
                                            <div class="row">
                                            </div>
                                            <div class="table-wrapper">
                                                <div class="table-responsive  p-3">
                                                    <table class="table table-bordered">
                                                        <thead>
                                                            <tr>
                                                                <th>Sl.No.</th>
                                                                <th>Questionnaire Name</th>
                                                                <th>Versions</th>
                                                                <th>Author</th>
                                                                <th>Action</th>

                                                            </tr>
                                                        </thead>
                                                        <tbody>



                                                            <tr>
                                                                <td>1</td>
                                                                <td>Executive Functioning</td>
                                                                <td>Version 1</td>
                                                                <td>IS-head</td>
                                                                <td>
                                                                    <label>
                                                                        <input class="markRequired" type="checkbox" name="markRequired" id="likeCheckbox1" data-title="" value="">
                                                                    </label>

                                                                </td>


                                                            </tr>
                                                            <tr>
                                                                <td>2</td>
                                                                <td>Study skills</td>
                                                                <td>Version 2</td>
                                                                <td>IS-head</td>

                                                                <td>
                                                                    <label>
                                                                        <input class="markRequired" type="checkbox" name="markRequired" id="likeCheckbox1" data-title="" value="" checked>
                                                                    </label>
                                                                </td>


                                                            </tr>
                                                            <tr>
                                                                <td>3</td>
                                                                <td>Getting to know your child</td>
                                                                <td>Version 3</td>
                                                                <td>IS-head</td>

                                                                <td>
                                                                    <label>
                                                                        <input class="markRequired" type="checkbox" name="markRequired" id="likeCheckbox1" data-title="" value="">
                                                                    </label>

                                                                </td>


                                                            </tr>







                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12  text-center" style="padding-top: 1rem;">

                                <a type="button" onclick="questionselect('Select')" id="selectbutton" class="btn btn-labeled" title="Select Questionnaire" style="background: darkblue !important;color:white !important">
                                    <span class="btn-label" style="font-size:13px !important;"><i class="fa fa-check"></i></span>Select</a>

                                <a type="button" onclick="questionselect('Cancel')" id="cancelbutton" class="btn btn-labeled btn-succes" title="Close" style="background: red !important; border-color:red !important; color:white !important">
                                    <span class="btn-label" style="font-size:13px !important;"><i class="fa fa-times"></i></span>Close</a>


                            </div>
                        </div>

                    </div>
                </section>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="addmodulemodal">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <form name="edit_form" action="" method="" id="edit_question_form10">

                <div class="modal-header" style="background-color:DarkSlateBlue;">
                    <h5 class="modal-title" id="#editModal">Add Question</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>

                <div class="modal-body">
                    <form action="" id="add_Question" method="">


                        <div class="card question" id="next-section">
                            <div class="row" style="margin-bottom: 15px;margin-top: 20px;">
                                <div class="col-md-9" id="question_field">
                                    <div class="form-group questionnaire">
                                        <label class="control-label required">Question</label>
                                        <input class="form-control default" type="text" id="field_question" name="field_question" autocomplete="off">
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group questionnaire">
                                        <label class="control-label required">Question Type</label>
                                        <select class="form-control default" name="field_type_id" id="field_type_id" onChange="typeChange()">
                                            <!-- <option value="">Select Question Type</option> -->

                                            <option value="1">Short Answer</option>
                                            <option value="2">Paragraph</option>
                                            <option value="3">Dropdown</option>
                                            <option value="4">Multiple Choice Radio</option>
                                            <option value="5">Check Box</option>
                                            <option value="7">Grid-Multiple Choice Radio</option>
                                            <option value="8">Qudrant Dropdown</option>
                                            <option value="9">Title and Description</option>
                                            <option value="10">Time</option>
                                            <option value="11">Date</option>
                                            <option value="12">Grid-Multiple Choice Checkbox</option>
                                            <option value="13">Qudrant Radio</option>
                                            <option value="14">Qudrant Grid</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-12" id="question_descriptionDiv" style="display: none;">
                                    <div class="form-group questionnaire">
                                        <label class="control-label required">Question Description</label>
                                        <textarea class="form-control default" name="question_description" id="question_description" autocomplete="off"></textarea>
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group seqno">
                                        <label class="control-label required">Sequence Number</label>
                                        <select class="form-control default" name="seqno" id="seqno">
                                            <!-- <option value="">Select Question Type</option> -->

                                            <option value="1">1</option>
                                            <option value="2">2</option>
                                            <option value="3">3</option>
                                            <option value="4">4</option>
                                            <option value="5">5</option>
                                            <option value="6">6</option>
                                            <option value="7">7</option>
                                            <option value="8">8</option>
                                        </select>
                                    </div>
                                </div>
                                <input type="hidden" name="client_data" value="27">
                                <div class="col-6" style="display: none;" id="option">
                                    <div class="form-group">
                                        <label class="required">Option</label>
                                        <div class="multi-field-wrapper">
                                            <div class="multi-fields" id="add_other">
                                                <div class="multi-field" style="display: flex;margin-bottom: 5px;">
                                                    <input type="text" class="form-control" name="options_questions[]" id="options_question[]" style="margin-right: 10px;">
                                                    <button class="remove-field btn btn-danger pull-right" id="remove-f" type='button'>X </button>
                                                    &nbsp;
                                                </div>
                                            </div>
                                            <button type="button" class="add-field btn btn-success">Add Option</button>
                                            <b class="otherBtn"> or </b>
                                            <a type="button" onclick="add_other()" class="otherBtn" title="Add other" style="color: blue;"><b>Add other</b></a>
                                        </div>
                                    </div>
                                </div>
                                <div class="w-100"></div>
                                <div class="col-12" style="display: none;" id="header_field">
                                    <div class="form-group questionnaire">
                                        <label class="control-label">Title</label>
                                        <input class="form-control" type="text" id="header_title" name="header_title" placeholder="optional" autocomplete="off">
                                    </div>
                                    <div class="form-group questionnaire">
                                        <label class="control-label">Description</label>
                                        <input class="form-control" type="text" id="header_description" name="header_description" placeholder="optional" autocomplete="off">
                                    </div>
                                </div>
                                <div class="w-100"></div>
                                <div class="row" style="display: none;" id="sub_questions">
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label class="required">Sub Question</label>
                                            <div class="multi-field-wrapper">
                                                <div class="multi-fields">
                                                    <div class="multi-field" style="display: flex;margin-bottom: 5px;">

                                                        <input type="text" class="form-control" name="sub_question[]" id="sub_question[]" style="margin-right: 10px;">
                                                        <button class="remove-field btn btn-danger pull-right" id="remove-f" type='button'>X </button>
                                                        <!-- <button class="add-field btn btn-danger pull-right" id="" type='button'>+ </button> -->
                                                        &nbsp;
                                                    </div>
                                                </div>
                                                <button type="button" class="add-field btn btn-success">Add Question</button>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-6">
                                        <div class="form-group">
                                            <label class="required">Option</label>
                                            <div class="multi-field-wrapper">
                                                <div class="multi-fields">
                                                    <div class="multi-field" style="display: flex;margin-bottom: 5px;">

                                                        <input type="text" class="form-control" name="sub_options[]" id="sub_options[]" style="margin-right: 10px;">
                                                        <button class="remove-field btn btn-danger pull-right" id="remove-f" type='button'>X </button>
                                                        <!-- <button class="add-field btn btn-danger pull-right" id="" type='button'>+ </button> -->
                                                        &nbsp;
                                                    </div>
                                                </div>
                                                <button type="button" class="add-field btn btn-success">Add Option</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!--  -->
                                <div class="row" style="display: none;" id="multiple_questions">
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label class="required">Quadrant</label>
                                            <select class="form-control" name="quadrant" id="quadrant">
                                                <option value="">Select Quadrant</option>
                                                <option value="1">Study Method</option>
                                                <option value="2">In Classroom</option>
                                                <option value="3">Home work</option>
                                                <option value="4">Regarding Examination</option>

                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-6">
                                        <div class="form-group">
                                            <label class="required">Category</label>
                                            <select class="form-control" name="quadrant_type_id" id="quadrant_type_id">
                                                <option value="">Select Quadrant Category</option>

                                            </select>
                                        </div>
                                    </div>
                                    <div class="w-100"></div>
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label class="required">Options</label>
                                            <div class="multi-field-wrapper">
                                                <div class="multi-fields">

                                                    <div class="multi-field" style="display: flex;margin-bottom: 5px;">
                                                        <input type="text" class="form-control" value="" name="options_questions1[]" id="options_question[]" style="margin-right: 10px;" readonly>
                                                        <!-- <button class="remove-field btn btn-danger pull-right" id="remove-f" type='button'>X </button> -->
                                                        &nbsp;
                                                    </div>

                                                </div>
                                                <!-- <button type="button" class="add-field btn btn-success">Add Options</button> -->
                                            </div>
                                        </div>
                                    </div>
                                    <div class="w-100"></div>

                                </div>
                                <!--  -->
                                <hr>
                                <div class="row" id="response_validationDiv" style="display:none">
                                    <div class="col-4">
                                        <div class="form-group">
                                            <select class="form-control" name="validation_type" id="validation_type" onChange="validationType()">
                                                <option value="">Select</option>
                                                <option value="1">Number</option>
                                                <option value="2">Text</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-4" id="validation_operationDiv" style="display: none;">
                                        <div class="form-group">
                                            <select class="form-control" name="validation_operation" id="validation_operation" onchange="validationoperation()">

                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-4" id="validation_conditionDiv" style="display: none;">
                                        <input class="form-control default" type="text" id="validation_condition" name="validation_condition" autocomplete="off">
                                    </div>
                                </div>

                                <div id="footerDiv">
                                    <div class="col-md-12" style="display: flex;justify-content:space-between;">
                                        <label>Required:</label>
                                        <label class='switch' data-bs-toggle='tooltip' data-bs-placement='top' title='Enable / Disable'>
                                            <input type='checkbox' class='toggle_status' id="required" name='required' checked value="1">
                                            <span class='slider round'></span>
                                        </label>
                                        <div class="col-md-2 dropdown">
                                            <a href="#" data-toggle="dropdown">
                                                <i class="fa fa-ellipsis-v"></i>
                                            </a>
                                            <ul class="dropdown-menu">
                                                <li><label class="dropdown-checkbox"><input type="checkbox" name="dropdown-checkbox['add_description']" id="add_description" onclick="open_description()">Description</label></li>
                                                <!-- <li><label class="dropdown-checkbox"><input type="checkbox" name="dropdown-checkbox['response_validation]" id="response_validation" onclick="responsevalidation()">Response validation</label></li> -->
                                                <!-- <li><label class="dropdown-checkbox"><input type="checkbox" value="option3"> Option 3</label></li> -->
                                            </ul>
                                        </div>

                                    </div>
                                </div>
                                <!--  -->
                                <div class="w-100"></div>
                                <div class="row" style="display: none;" id="multiple_radioquestions">
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label class="required">Quadrant</label>
                                            <select class="form-control" name="quadrant" id="quadrant">
                                                <option value="">Select Quadrant</option>
                                                <option value="1">Study Method</option>
                                                <option value="2">In Classroom</option>
                                                <option value="3">Home work</option>
                                                <option value="4">Regarding Examination</option>

                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-6">
                                        <div class="form-group">
                                            <label class="required">Category</label>
                                            <select class="form-control" name="quadrant_type_id" id="quadrant_type_id">
                                                <option value="">Select Quadrant Category</option>

                                            </select>
                                        </div>
                                    </div>
                                    <div class="w-100"></div>
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label class="required">Options</label>
                                            <div class="multi-field-wrapper">
                                                <div class="multi-fields">

                                                    <div class="multi-field">
                                                        <input type="text" class="form-control" value="Yes-1" name="options_questions1[]" id="options_question[]" style="margin-right: 10px;width:100% !important;" readonly>
                                                        </br>
                                                        <input type="text" class="form-control" value="No-0" name="options_questions1[]" id="options_question[]" style="margin-right: 10px;width:100% !important;" readonly>

                                                        <!-- <button class="remove-field btn btn-danger pull-right" id="remove-f" type='button'>X </button> -->
                                                        &nbsp;
                                                    </div>

                                                </div>
                                                <!-- <button type="button" class="add-field btn btn-success">Add Options</button> -->
                                            </div>
                                        </div>
                                    </div>
                                    <div class="w-100"></div>

                                </div>
                                <div class="row" style="display: none;" id="multiple_gridqudrant">
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label class="required">Quadrant</label>
                                            <select class="form-control" name="quadrant" id="quadrant">
                                                <option value="">Select Quadrant</option>
                                                <option value="1">Study Method</option>
                                                <option value="2">In Classroom</option>
                                                <option value="3">Home work</option>
                                                <option value="4">Regarding Examination</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-6">
                                        <div class="form-group">
                                            <label class="">Category</label>
                                            <select class="form-control" name="quadrant_type_id" id="quadrant_type_id">
                                                <option value="">Select Quadrant Category</option>

                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-10">
                                        <div class="form-group">
                                            <label class="required">Sub Question</label>
                                            <div class="multi-field-wrapper">
                                                <div class="multi-fields">
                                                    <div class="multi-field" style="display: flex;margin-bottom: 5px;">

                                                        <input type="text" class="form-control" name="sub_question[]" id="sub_question[]" style="margin-right: 10px;">
                                                        <button class="remove-field btn btn-danger pull-right" id="remove-f" type='button'>X </button>
                                                        <!-- <button class="add-field btn btn-danger pull-right" id="" type='button'>+ </button> -->
                                                        &nbsp;
                                                    </div>
                                                </div>
                                                <button type="button" class="add-field btn btn-success">Add Question</button>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-4">
                                        <div class="form-group">
                                            <label class="required">Options</label>
                                            <div class="multi-field-wrapper">
                                                <div class="multi-fields">

                                                    <div class="multi-field" style="">
                                                        <input type="text" class="form-control" value="Yes-1" name="options_questions1[]" id="options_question[]" style="margin-right: 10px;width:100% !important;" readonly>
                                                        </br>
                                                        <input type="text" class="form-control" value="No-0" name="options_questions1[]" id="options_question[]" style="margin-right: 10px;width:100% !important;" readonly>

                                                        <!-- <button class="remove-field btn btn-danger pull-right" id="remove-f" type='button'>X </button>
                                &nbsp; -->
                                                    </div>

                                                </div>
                                                <!-- <button type="button" class="add-field btn btn-success">Add Options</button>  -->
                                            </div>
                                        </div>
                                    </div>
                                    <div class="w-100"></div>

                                </div>

                                <div class="col-md-12" style="display:flex;justify-content: center;">
                                    <input type="hidden" name="status" value="save">
                                    <a type="button" onclick="saveQuestion()" id="savebtn" class="btn btn-success" title="Submit Question" style="color:white !important">
                                        <span class="btn-label" style="font-size:13px !important;"><i class="fa fa-check"></i></span>Save</a>
                                    <a type="button" class="btn btn-labeled back-btn" title="Back" href="{{ route('questionnaire_allocation13.index') }}" style="color:white !important">
                                        <span class="btn-label" style="font-size:13px !important;"><i class="fa fa-arrow-left"></i></span> Back</a>

                                    <!-- <a type="button" onclick="submit()" id="submitbutton" class="btn btn-success" title="submit"><span class="btn-label" style="font-size:13px !important;"><i class="fa fa-check"></i></span>Save</a> -->
                                </div>
                            </div>
                        </div>

                        </section>
                    </form>
                </div>

            </form>


        </div>
    </div>
</div>
<div class="modal fade" id="editmodulemodal1">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <form name="edit_form" action="" method="" id="edit_question_form10">

                <div class="modal-header" style="background-color:DarkSlateBlue;">
                    <h5 class="modal-title" id="#editModal">Edit Question</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row register-form">


                        <div class="row" style="margin-bottom: 15px;margin-top: 20px;">

                            <div class="col-md-12">
                                <div class="form-group questionnaire">
                                    <label class="control-label">Questions</label>
                                    <input class="form-control" type="text" id="edit_field_question" name="edit_field_question" value="Your Name" autocomplete="off">
                                </div>
                            </div>
                            <input type="hidden" name="client_data" value="1">
                            <input type="hidden" value="1" name="edit_field_types_id" id="edit_field_types_id">

                            <div class="col-12" id="edit_option1">
                                <div class="form-group">
                                    <label>Option</label>
                                    <div class="multi-field-wrapper">
                                        <div class="multi-fields">


                                            <div class="multi-field" style="display: flex;margin-bottom: 5px;">
                                                <input type="text" value="" class="form-control" name="options_question[]" id="options_question[]">
                                                <button class="remove-field btn btn-danger pull-right" id="remove-f" type='button'>X </button>
                                                <!-- <button class="add-field btn btn-danger pull-right" id="" type='button'>+ </button> -->
                                                &nbsp;
                                            </div>

                                        </div>
                                        <!-- <button class="add-field btn btn-danger" id="" type='button'>+ </button> -->
                                        <button type="button" class="add-field btn btn-success">Add Option</button>
                                    </div>
                                </div>
                            </div>

                            <div class="w-100"></div>

                            <div class="row" id="edit_sub_questions{{'1'}}">
                                <div class="col-6">
                                    <div class="form-group">
                                        <label>Sub Question</label>
                                        <div class="multi-field-wrapper">
                                            <div class="multi-fields">

                                                <div class="multi-field" style="display: flex;margin-bottom: 5px;">
                                                    <input type="text" value="" class="form-control" name="sub_questions[]" id="sub_questions[]">
                                                    <button class="remove-field btn btn-danger pull-right" id="remove-f" type='button'>X </button>
                                                    <!-- <button class="add-field btn btn-danger pull-right" id="" type='button'>+ </button> -->
                                                    &nbsp;
                                                </div>

                                            </div>
                                            <button type="button" class="add-field btn btn-success">Add Question</button>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="form-group">
                                        <label>Option</label>
                                        <div class="multi-field-wrapper">
                                            <div class="multi-fields">

                                                <div class="multi-field" style="display: flex;margin-bottom: 5px;">
                                                    <input type="text" value="1" class="form-control" name="edit_sub_options[]" id="edit_sub_options[]">
                                                    <button class="remove-field btn btn-danger pull-right" id="remove-f" type='button'>X </button>
                                                    <!-- <button class="add-field btn btn-danger pull-right" id="" type='button'>+ </button> -->
                                                    &nbsp;
                                                </div>

                                            </div>
                                            <!-- <button class="add-field btn btn-danger" id="" type='button'>+ </button> -->
                                            <button type="button" class="add-field btn btn-success">Add Option</button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="w-100"></div>
                        </div>
                        <div class="col-md-12">
                            <label>Required:</label>
                            <label class='switch' data-bs-toggle='tooltip' data-bs-placement='top' title='Enable / Disable'>
                                <input type='checkbox' class='toggle_status' id="required" name='required' checked value="1">
                                <span class='slider round'></span>
                            </label>
                        </div>

                    </div>

                    <div class="modal-footer">
                        <div class="mx-auto">

                            <a type="button" onclick="editbuttonclick('10')" class="btn btn-labeled btn-succes" title="Update" style="background: green !important; border-color:green !important; color:white !important">
                                <span class="btn-label" style="font-size:13px !important;"><i class="fa fa-check"></i></span>Update</a>
                            <a type="button" data-dismiss="modal" aria-label="Close" value="Cancel" class="btn btn-labeled btn-space" title="Cancel" style="background: red !important; border-color:red !important; color:white !important">
                                <span class="btn-label" style="font-size:13px !important;"><i class="fa fa-remove"></i></span>Cancel</a>


                        </div>
                    </div>

            </form>

        </div>
    </div>
</div>


<div class="card" style="margin-left:22%;margin-right:2%;" id="invite">

    <div class="card-body">
        <div class="table-wrapper">
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Sl.No.</th>
                            <th>Questionnaire Name</th>
                            <th>Status</th>

                        </tr>
                    </thead>
                    <tbody id="sailview">

                    </tbody>
                </table>
            </div>

        </div>
    </div>
</div>
</section>
</div>
<script>
    $(".js-select2").select2({
        closeOnSelect: false,
        placeholder: " Please Select",
        allowHtml: true,
        tags: true
    });
</script>

<script>
    function Childname(event) {
        let value = event.target.value || '';
        value = value.replace(/[^a-z A-Z ]/, '', );
        event.target.value = value;

    }
</script>

<script type="text/javascript">
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    function GetChilddetails() {
        var enrollment_id = $("select[name='enrollment_id']").val();
        console.log(enrollment_id);
        if (enrollment_id != "") {
            $.ajax({
                url: '{{url('/userregisterfee/enrollmentlist')}}',
                type: 'POST',
                data: {
                    'enrollment_child_num': enrollment_id,
                    _token: '{{csrf_token()}}'
                }
            }).done(function(data) {
                console.log(data);
                if (data != '[]') {
                    var optionsdata = "";
                    document.getElementById('child_id').value = data[0].child_id;
                    document.getElementById('child_name').value = data[0].child_name;
                    document.getElementById('userID').value = data[0].user_id;
                    $('#chooseQuestionnaire').show();
                    // document.getElementById('meeting_to').value = data[0].child_contact_email;
                    // document.getElementById('enrollment_id').value = data[0].enrollment_id;

                    // if (enrollment_id != "") {
                    // alert(enrollment_id);

                    $.ajax({
                        url: '{{url('/sail/GetQuestionnaire')}}',
                        type: "POST",
                        dataType: "json",
                        data: {
                            enrollment_id: enrollment_id,
                            type: '1',
                            stage: 'SAIL',
                            _token: '{{csrf_token()}}'
                        },
                        success: function(data) {
                            //alert(data);

                            if (data != '[]') {
                                var user_select = data.rows;
                                var optionsdata = "";
                                var ddd;
                                for (var i = 0; i < user_select.length; i++) {
                                    var questionnaire_name = user_select[i]['questionnaire_name'];
                                    var questionnaire_id = user_select[i]['questionnaire_id'];
                                    ddd += "<option value=" + questionnaire_id + ">" + questionnaire_name + "</option>";
                                }
                                var stageoption = ddd.concat(optionsdata);
                                var demonew = $('#questionnaire_id').html(stageoption);

                                // 
                                var activity = data.activity;



                            } else {
                                var stageoption = ddd.concat(optionsdata);
                                // var demonew = $('#questionnaire_id').html(stageoption);
                            }


                            $('#chooseQuestionnaire').show();


                        }
                    });



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
<script>
    function buttonAction(status) {
      
        document.getElementById('btn_status').value = status;
        document.querySelector('.qtabs').style.display = "block";
        // document.getElementById('enrollement').submit();
        Swal.fire({
                title: "Success",
                text: "Questionnaire Saved Successfully",
                icon: "success",
            });
        if (status == "Sent") {
            Swal.fire({

                title: "Are you Sure you want to Allocate the Questionnaire?",
                text: "Please click 'Yes' to Create.",
                icon: "warning",
                customClass: 'swalalerttext',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                confirmButtonText: "Yes",
                cancelButtonText: "No",
                closeOnConfirm: false,
                closeOnCancel: true,
                showLoaderOnConfirm: true,
                width: '550px',
            }).then((result) => {
                if (result.value) {
                    const message = "Questionnaire Allocated Successfully";
                    location.replace(`/questionnaire_allocation13?message=${encodeURIComponent(message)}`);
                }
            })
        }


    }

    // function Description() {
    //     var activity_id = $("select[name='activity_id']").val();
    //     var enrollment_id = $("select[name='enrollment_id']").val();
    //     if (enrollment_id == '') {
    //         swal.fire("Please Select Enrollment Child Number: ", "", "error");
    //         return false;
    //     }
    //     if (activity_id != "") {
    //         $.ajax({
    //             url: "{{ route('parentvideo.description') }}",
    //             type: 'POST',
    //             data: {
    //                 'activity_id': activity_id,
    //                 'enrollment_id': enrollment_id,
    //                 _token: '{{csrf_token()}}'
    //             }
    //         }).done(function(data) {
    //             // var category_id = json.parse(data);
    //             // console.log(data);

    //             if (data != '[]') {

    //                 var data = data.desc;
    //                 // var user_select = data;
    //                 if (data != '[]') {
    //                     var optionsdata = '<option value="">Select description</option>';
    //                     for (var i = 0; i < data.length; i++) {
    //                         var id = data[i].activity_description_id;
    //                         var name = data[i].description;
    //                         // console.log(name)
    //                         // var ddd = '<option value="">Select description</option>';
    //                         optionsdata += '<option value="' + id + '"> ' + name + ' </option>';

    //                     }
    //                 } else {
    //                     var optionsdata = '<option value="">No Data Found</option>';
    //                 }
    //                 var demonew = $('#actity_discription').html(optionsdata);

    //             } else {

    //                 // var ddd = '<option value="">Select description</option>';
    //                 // var demonew = $('#alignq2').html(ddd);
    //             }
    //         })
    //     } else {
    //         // var ddd = '<option value="">Select description</option>';
    //         // var demonew = $('#alignq2').html(ddd);
    //     }
    // };
</script>



<script>
    function categorizedquestion() {
        var category = document.getElementById('Category').value;
        //  var questionnaireSelect = document.getElementById('questionnaire_id');

        // Clear existing options
        // questionnaireSelect.innerHTML = '<option value="">Select Questionnaire Name</option>';

        if (category == 1) {
            // Add options for category 1
            document.querySelector('.versionlist').style.display = "block";
            // questionnaireSelect.innerHTML += '<option value="1">Getting to know your child</option>';
            // questionnaireSelect.innerHTML += '<option value="2">Executive functioning</option>';
            // questionnaireSelect.innerHTML += '<option value="3">Sensory Profiling</option>';
            // questionnaireSelect.innerHTML += '<option value="4">Study skills questionnaire</option>';
            // Add more options as needed 
        } else if (category == 2) {
            document.querySelector('.versionlist').style.display = "block";

            // Add options for category 2
            // questionnaireSelect.innerHTML += '<option value="5">Executive functioning - The way I process</option>';
            // questionnaireSelect.innerHTML += '<option value="6">Sensory Profiling - The way I function</option>';
            // questionnaireSelect.innerHTML += '<option value="7">Study skills questionnaire</option>';
            // questionnaireSelect.innerHTML += '<option value="8">High school transition questionnaire</option>';


            // Add more options as needed
        } else {
            document.querySelector('.versionlist').style.display = "none";

            // No options for other categories
            // questionnaireSelect.innerHTML = '<option value="">No result found</option>';

        }
    }
</script>

<script>
    function functiontoggle(id) {

        if ($('#is_active' + id).prop('checked')) {
            var is_active = '1';
        } else {
            var is_active = '0';
        }
        var f_id = id;

        $.ajax({
            url: "{{ route('thirteenquestionnaire.update_toggle') }}",
            type: 'POST',
            data: {
                is_active: is_active,
                f_id: f_id,
                _token: '{{csrf_token()}}'
            },
            error: function() {
                alert('Something is wrong');
            },
            success: function(data) {

                var data_convert = $.parseJSON(data);

                // console.log(data_convert.Data);
                if (data_convert.Data == 0) {
                    swal.fire({
                        title: "Success",
                        text: "Question Deactivated",
                        type: "success"
                    }, );
                } else {
                    swal.fire({
                        title: "Success",
                        text: "Question Activated",
                        type: "success"
                    }, );
                }

            }


        });
    }
    // Activate the first tab on page load
    $(document).ready(function() {
        $("#myTabs li:first-child input").prop('checked', true);
    });

    // Show corresponding tab content on tab click
    $('#myTabs input').on('change', function() {
        var tabId = $(this).attr('id');
        $('.tab-content .tab-pane').removeClass('show active');
        $('#tabContent' + tabId.slice(-1)).addClass('show active');
    });
</script>
<script>
    function myFunction(id) {
        swal.fire({
                title: "Confirmation For Delete ?",
                text: "Are You Sure to delete this data.",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: '#DD6B55',
                confirmButtonText: 'Yes, I am sure!',
                cancelButtonText: "No, cancel it!",
                closeOnConfirm: false,
                closeOnCancel: false
            },
            function(isConfirm) {

                if (isConfirm) {
                    swal.fire("Deleted!", "Data Deleted successfully!", "success");
                    var url = $('#' + id).val();
                    window.location.href = url;
                } else {
                    swal.fire("Cancelled", "Your Data is safe :)", "error");
                    e.preventDefault();
                }
            });
    }
    $(document).ready(function() {
        // Enable sortable feature on the table
        $("#alignq1 tbody").sortable({
            items: "tr",
            cursor: "move",
            axis: "y",
            start: function(event, ui) {
                // Change cursor to pointer during sorting
                ui.helper.css("cursor", "pointer");

                // Update the order of rows in the backend or perform any necessary actions
                var newOrder = $(this).sortable('toArray');
                console.log(newOrder);
            },
            update: function(event, ui) {

                // // Update the order of rows in the backend or perform any necessary actions
                // var newOrder = $(this).sortable('toArray');
                // console.log(newOrder);

                // Update the Sl.No in the displayed table
                updateSlNo2();
            }
        }).disableSelection();

        // Function to update Sl.No values in the table
        function updateSlNo2() {
            $("#alignq1 tbody tr").each(function(index) {
                // Update the Sl.No in the first column (assuming it's the first <td> in each row)
                $(this).find("td:first").text(index + 1);
            });
        }
    });
    $(document).ready(function() {
        // Enable sortable feature on the table
        $("#alignq3 tbody").sortable({
            items: "tr",
            cursor: "move",
            axis: "y",
            update: function(event, ui) {
                // Update the order of rows in the backend or perform any necessary actions
                var newOrder = $(this).sortable('toArray');
                console.log(newOrder);

                // Update the Sl.No in the displayed table
                updateSlNo1();
            }
        }).disableSelection();

        // Function to update Sl.No values in the table
        function updateSlNo1() {
            $("#alignq3 tbody tr").each(function(index) {
                // Update the Sl.No in the first column (assuming it's the first <td> in each row)
                $(this).find("td:first").text(index + 1);
            });
        }
    });
    $(document).ready(function() {
        // Enable sortable feature on the table
        $("#alignq2 tbody").sortable({
            items: "tr",
            cursor: "move",
            axis: "y",
            update: function(event, ui) {
                // Update the order of rows in the backend or perform any necessary actions
                var newOrder = $(this).sortable('toArray');
                console.log(newOrder);

                // Update the Sl.No in the displayed table
                updateSlNo();
            }
        }).disableSelection();

        // Function to update Sl.No values in the table
        function updateSlNo() {
            $("#alignq2 tbody tr").each(function(index) {
                // Update the Sl.No in the first column (assuming it's the first <td> in each row)
                $(this).find("td:first").text(index + 1);
            });
        }
    });
</script>
<script>
    function edit_question(id) {

        edit_question_id = id;

        $.ajax({
            url: "{{ url('/thirteenquestion_creation/get_options') }}",
            type: "POST",
            data: {
                _token: '{{csrf_token()}}',
                edit_question_id: edit_question_id,
            },

            success: function(data) {

                if (data == 3 || data == 4 || data == 5 || data == 9 || data == 8) {
                    $('#edit_option' + id).show();
                } else if (data == 6 || data == 7) {
                    $('#edit_option' + id).hide();
                    $('#edit_sub_questions' + id).show();
                } else {
                    $('#edit_option' + id).hide();
                }
            },
            error: function(data) {
                console.log(data);
            }
        });
    }
</script>
<script type="text/javascript">
    function typeChange() {
        var fieldtype = $('#field_type_id').val();
      

        if (fieldtype == 4 || fieldtype == 5) {
            $('#option').show();
            $('#sub_questions').hide();
            $('#multiple_questions').hide();
            $('#question_field').show();
            $('#header_field').hide();
            $('#footerDiv').show();
            $('.otherBtn').show();
            $('#multiple_gridqudrant').hide();
            $('#multiple_radioquestions').hide();
        } else if (fieldtype == 3) {
            $('#option').show();
            $('#sub_questions').hide();
            $('#multiple_questions').hide();
            $('#question_field').show();
            $('#header_field').hide();
            $('#footerDiv').show();
            $('.otherBtn').hide();
            $('#multiple_gridqudrant').hide();
            $('#multiple_radioquestions').hide();
        } else if (fieldtype == 6 || fieldtype == 7) {
            $('#option').hide();
            $('#header_field').hide();
            $('#sub_questions').show();
            $('#question_field').show();
            $('#multiple_questions').hide();
            $('#footerDiv').show();
            $('.otherBtn').hide();
            $('#multiple_gridqudrant').hide();
            $('#multiple_radioquestions').hide();
        } else if (fieldtype == 8) {
            $('#header_field').hide();
            $('#multiple_questions').show();
            $('#sub_questions').hide();
            $('#option').hide();
            $('#question_field').show();
            $('#footerDiv').show();
            $('.otherBtn').hide();
            $('#multiple_gridqudrant').hide();
            $('#multiple_radioquestions').hide();
        } else if (fieldtype == 9) {
            $('#header_field').show();
            $('#footerDiv').hide();
            $('#option').hide();
            $('#sub_questions').hide();
            $('#multiple_questions').hide();
            $('#question_field').hide();
            $('.otherBtn').hide();
            $('#multiple_gridqudrant').hide();
            $('#multiple_radioquestions').hide();
        } else if (fieldtype == 13) {
           
            $('#header_field').hide();
            $('#multiple_questions').hide();
            $('#multiple_radioquestions').show();
            $('#sub_questions').hide();
            $('#option').hide();
            $('#question_field').show();
            $('#footerDiv').show();
            $('.otherBtn').hide();
            $('#multiple_gridqudrant').hide();
        } else if (fieldtype == 14) {
            $('#option').hide();
            $('#multiple_questions').hide();
            $('#multiple_radioquestions').hide();
            $('#header_field').hide();
            $('#multiple_gridqudrant').show();
            $('#question_field').show();

            $('#footerDiv').show();
            $('.otherBtn').hide();
        } else {
            $('#footerDiv').show();
            $('#header_field').hide();
            $('#question_field').show();
            $('#option').hide();
            $('#sub_questions').hide();
            $('#multiple_questions').hide();
            $('#multiple_gridqudrant').hide();
            $('.otherBtn').hide();
            $('#multiple_radioquestions').hide();
        }
    }
</script>
<script>
    function add_other() {
        var others = '<div class="multi-field" style="display: flex;margin-bottom: 5px;" id="others_field">';
        others += '<input type="hidden" id="other_option" name="other_option" value="1"><input type="text" class="form-control" readonly style="margin-right: 10px;">';
        others += '<button class="remove-field btn btn-danger pull-right" id="remove" onclick="remove_other()" type="button">X </button>&nbsp;</div>';
        $('#add_other').append(others);
        $('.otherBtn').hide();
    }

    function remove_other() {
        // alert('remove_other');
        var divToRemove = document.getElementById("others_field");
        divToRemove.remove();
        $('.otherBtn').show();
    }

    function open_description() {
        if ($('#add_description').prop('checked')) {
            $('#question_descriptionDiv').show();
        } else {
            $('#question_descriptionDiv').hide();
        }
    }
    $('.multi-field-wrapper').each(function() {
        var $wrapper = $('.multi-fields', this);
        $(".add-field", $(this)).click(function(e) {
            $('.multi-field:first-child', $wrapper).clone(true).appendTo($wrapper).find('input').val('').focus();
        });
        $('.multi-field .remove-field', $wrapper).click(function() {
            if ($('.multi-field', $wrapper).length > 2)
                $(this).parent('.multi-field').remove();
            else swal.fire("Required Two Option", "", "error");
        });
    });

    function nextTab() {
        var tabs = document.querySelectorAll('.nav-link1:checked');
        console.log(tabs);
        var activeTabIndex = Array.from(document.querySelectorAll('.nav-link1')).indexOf(tabs[0]);
        console.log(activeTabIndex);
        if (activeTabIndex < tabs.length - 1) {
            var nextTab = tabs[activeTabIndex + 1];
            if (nextTab) {
                nextTab.click();
            }
        }
    }

    function questionselect(action) {
        if (action === 'Select') {
            // Get the selected checkboxes
            var selectedCheckboxes = document.querySelectorAll('.markRequired:checked');

            // Check if at least one checkbox is selected
            if (selectedCheckboxes.length > 0) {
                var selectedQuestionnaireNames = [];

                // Iterate over selected checkboxes and collect questionnaire names
                selectedCheckboxes.forEach(function(checkbox) {
                    var row = checkbox.closest('tr');
                    var questionnaireName = row.cells[1].textContent; // Assuming the name is in the second column
                    selectedQuestionnaireNames.push(questionnaireName);
                });
                console.log(selectedQuestionnaireNames);
                // Display a success message using Swal
                Swal.fire({
                    title: 'Selected Questionnaires',
                    html: 'Selected Questionnaires:<br>' + selectedQuestionnaireNames.map(formatQuestionnaire).join('<br>'),
                    icon: 'success',
                }).then((result) => {
                    // Check if the user clicked "OK"
                    if (result.isConfirmed) {
                        // Close the modal after the success message is closed
                        $('#addModal2').modal('hide');
                    }
                });

                // Show selected questionnaire names in a div
                var selectedQuestionnaireDiv = document.getElementById('selectedQuestionnaire');

                selectedQuestionnaireDiv.innerHTML = '';
                selectedQuestionnaireNames.forEach(function(questionnaireName) {
                    var inputDiv = document.createElement('div');
                    inputDiv.className = 'col-md-12 pb-2'; // Add your desired class here
                    inputDiv.innerHTML = `
                        <span type="text" class="col-md-9  btn" value="${questionnaireName}" readonly style="background: darkblue;color: white;">${questionnaireName}<a onclick="removeQuestionnaire(this)"><i class="fa fa-times col-md-3"></i></a></span>
                    `;
                    selectedQuestionnaireDiv.value = 1;
                    selectedQuestionnaireDiv.appendChild(inputDiv);
                    selectedQuestionnaireDiv.setAttribute('data-value', '1');
                });

            } else {
                // Display a warning message using Swal if no checkbox is selected
                Swal.fire({
                    title: 'No Questionnaire Selected',
                    text: 'Please select at least one questionnaire.',
                    icon: 'warning',
                });
            }
        } else if (action === 'Cancel') {
            // Close the modal if 'Cancel' button is clicked
            $('#addModal2').modal('hide');
        }
    }

    function formatQuestionnaire(questionnaireName) {
        return questionnaireName;
    }

    function removeQuestionnaire(button) {
        // Remove the parent div containing the input and remove button
        var inputDiv = button.parentNode;
        var questionnaireName = inputDiv.textContent.trim();
        // Remove the corresponding checkbox in the original modal
        var checkboxes = document.querySelectorAll('.markRequired');
        checkboxes.forEach(function(checkbox) {
            var row = checkbox.closest('tr');
            var nameInRow = row.cells[1].textContent;
            if (nameInRow === questionnaireName) {
                checkbox.checked = false;
            }
        });

        inputDiv.parentNode.removeChild(inputDiv);
    }
</script>
<!-- <script>
    // Function to switch tabs based on step
    function switchTab(step) {
        // Remove 'active' class from all tabs and tab content
        document.querySelectorAll('.nav-link1').forEach(tab => tab.checked = false);
        document.querySelectorAll('.tab-pane').forEach(tabContent => tabContent.classList.remove('active', 'show'));

        // Add 'active' class to the selected tab and tab content
        document.querySelector(`#radio-${step}`).checked = true;
        document.querySelector(`#tabContent${step}`).classList.add('active', 'show');
        // document.querySelectorAll('.check-mark').forEach(mark => mark.style.display = 'none');
        // document.querySelector(`#check-mark-${step}`).style.display = 'inline-block';

    }
</script> -->
<script>
    // Function to switch tabs based on step
    function switchTab(step) {
        // Remove 'active' class from all steps
        document.querySelectorAll('.md-step').forEach(mdStep => mdStep.classList.remove('active'));

        // Add 'active' class to the selected step
        const selectedStep = document.querySelector(`.md-step:nth-child(${step})`);
        selectedStep.classList.add('active');


        // Remove 'active' class from all tabs and tab content
        document.querySelectorAll('.nav-link1').forEach(tab => tab.checked = false);
        document.querySelectorAll('.tab-pane').forEach(tabContent => tabContent.classList.remove('active', 'show'));

        // Add 'active' class to the selected tab and tab content
        document.querySelector(`#radio-${step}`).checked = true;
        document.querySelector(`#tabContent${step}`).classList.add('active', 'show');
    }
</script>
<script>
    // Function to handle the Save button click
    function saveQuestion() {
        // Perform your validation here
        if (validateForm()) {
            // Show confirmation swal
            showConfirmationSwal();
        }
    }

    function showConfirmationSwal() {
        Swal.fire({
            title: "Are you sure?",
            text: "Do you want to add this question?",
            icon: "info",
            buttons: ["Cancel", "Yes"],
        }).then((willAdd) => {
            if (willAdd) {
                // Insert the new row into the table
                insertTableRow();
                // Hide the modal
                $('#addmodulemodal').modal('hide');
                // Optionally, reset the form
                // resetForm();
            }
        });
    }

    // Function to insert a new row into the table
    // function insertTableRow() {
    //     var seqNo = $('#seqno').val(); // Get the selected sequence number

    //     var field_question = $('#field_question').val();

    //     // Find the table
    //     var table = $('#alignq1');


    //    // Shift existing rows down
    //    table.find('tr').each(function () {
    //         var currentSeqNo = parseInt($(this).find('td:first').text());
    //         if (!isNaN(currentSeqNo) && currentSeqNo >= seqNo) {
    //             var newSeqNo = currentSeqNo + 1;
    //             $(this).find('td:first').text(newSeqNo); // Update the content of the first cell
    //         }
    //     });
    //     // Insert the new row at the calculated index
    //     var newRow = `<tr SI.NO='${seqNo}'><td>${seqNo}</td><td>${field_question}</td><td><a class='btn btn-link' onclick='edit_question("1")' title='Edit' data-toggle='modal' data-target='#editmodulemodal1' style='color:darkblue'><i class='fas fa-pencil-alt'></i></a><a type='button' value='Cancel' class='' data-toggle='modal' data-target='#addmodulemodal' title='Add a question' style='color:green !important'><i class='fa fa-plus'></i></a></td><td style='text-align: center;'><label class='switch' data-bs-toggle='tooltip' data-bs-placement='top' title='Enable / Disable'><input type='hidden' name='toggle_id' value='1'><input type='checkbox' class='toggle_status' onclick='functiontoggle("1")' id='is_active1' name='is_active' checked><span class='slider round'></span></label></td></tr>`;

    //       // Append the new row to the specified index (seqNo - 1 as index is 0-based)
    //       table.find('tr').eq(seqNo - 1).after(newRow);
    //       // Get the updated row count
    //   // Get the updated row count using DataTables API
    //   var rowCount = table.rows().count();
    //   console.log(rowCount);

    // // Update the DataTable entries dynamically
    // $('#alignq1_info').text('Showing 1 to ' + rowCount + ' of ' + rowCount + ' entries');



    // }

    // Function to insert a new row into the table
    // Function to insert a new row into the table
    function insertTableRow() {
        var seqNo = parseInt($('#seqno').val()); // Get the selected sequence number as an integer
        var field_question = $('#field_question').val();

        // Find the table and initialize DataTable
        var table = $('#alignq1').DataTable();

        // Shift existing rows down using DataTables API
        table.rows().every(function(rowIdx) {
            var currentSeqNo = parseInt(this.data()[0]);
            if (!isNaN(currentSeqNo) && currentSeqNo >= seqNo) {
                var newSeqNo = currentSeqNo + 1;
                table.cell({
                    row: rowIdx,
                    column: 0
                }).data(newSeqNo); // Update the content of the first cell
            }
        });

        // // Insert the new row at the specified index using DataTables API
        // var newRowData = [seqNo, field_question /* Add other data as needed */ ];
        // table.row.add(newRowData).draw();
        // Create buttons for the new row
        var editButton = `<a class='btn btn-link' onclick='edit_question("${seqNo}")' title='Edit' data-toggle='modal' data-target='#editmodulemodal1' style='color:darkblue'><i class='fas fa-pencil-alt'></i></a>`;
        var cancelButton = `<a type='button' value='Cancel' class='' data-toggle='modal' data-target='#addmodulemodal' title='Add a question' style='color:green !important'><i class='fa fa-plus'></i></a>`;
        var enableDisableSwitch = `<label class='switch' data-bs-toggle='tooltip' data-bs-placement='top' title='Enable / Disable'><input type='hidden' name='toggle_id' value='${seqNo}'><input type='checkbox' class='toggle_status' onclick='functiontoggle("${seqNo}")' id='is_active${seqNo}' name='is_active' checked><span class='slider round'></span></label>`;

        // Create the new row HTML
        var newRow = `<tr SI.NO='${seqNo}'><td>${seqNo}</td><td>${field_question}</td><td>${editButton} ${cancelButton}</td><td style='text-align: center;'>${enableDisableSwitch}</td></tr>`;

        // Append the new row to the specified index (seqNo - 1 as index is 0-based)
        // table.find('tr').eq(seqNo - 1).after(newRow);
        table.row.add($(newRow)).draw();

        // Get the updated row count using DataTables API
        var rowCount = table.rows().count();

        // Update the DataTable entries dynamically
        $('#alignq1_info').text('Showing 1 to ' + rowCount + ' of ' + rowCount + ' entries');
        resetForm();
    }




    // Function to reset the form fields if needed
    function resetForm() {
        // Hide all md-step-content elements
        var mdStepContents = document.querySelectorAll('.md-step-content');
        mdStepContents.forEach(function(stepContent) {
            stepContent.style.display = 'block';
        });
    }

    // Function to perform your form validation
    function validateForm() {
        // Add your validation logic here
        // Return true if validation passes, false otherwise
        return true;
    }
</script>

@endsection