@extends('layouts.adminnav')

@section('content')

<style>
    input[type=checkbox] {
        display: inline-block;
    }

    .no-arrow {
        -moz-appearance: textfield;
    }

    .no-arrow::-webkit-inner-spin-button {
        display: none;
    }

    .no-arrow::-webkit-outer-spin-button,
    .no-arrow::-webkit-inner-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }

    .nav-tabs {
        background-color: #0068a7 !important;
        border-radius: 29px !important;
        padding: 1px !important;
    }

    .nav-item.active {
        background-color: #0e2381 !important;
        border-radius: 31px !important;
        height: 100% !important;
    }

    .nav-link.active {
        background-color: #0e2381 !important;
        border-radius: 31px !important;
        height: 100% !important;
    }

    .nav-justified {
        display: flex !important;
        align-items: center !important;
    }

    hr {
        border-top: 1px solid #6c757d !important;
    }

    .dateformat {
        height: 41px;
        padding: 8px 10px !important;
        width: 100%;
        border-radius: 5px !important;
        border-color: #bec4d0 !important;
        box-shadow: 2px 2px 4px rgb(0 0 0 / 15%);
        border-style: outset;
    }

    h4 {
        text-align: center;
    }

    .question {
        background-color: white;
        border-radius: 12px !important;
        margin-top: 2rem;
    }

    .question label {
        text-align: center;
    }

    .questionnaire {
        text-align: center;
    }

    .btn-success {
        margin: auto;
    }

    #footerDiv {
        display: flex;
        justify-content: flex-end;
        align-items: center;
        padding: 10px;
        width: 100%;
    }

    #footerDiv .col-md-12 {
        display: flex;
        align-items: center;
    }

    #footerDiv .dropdown {
        margin-right: 10px;
    }

    #footerDiv .fa {
        font-size: 25px;
    }

    #footerDiv label {
        margin-right: 10px;
    }

    /* ============================================================
       MOBILE RESPONSIVE – with the new layout
       ============================================================ */
    @media (max-width: 768px) {

        /* Reset paddings and prevent horizontal scroll */
        .main-content,
        .card,
        .card-body,
        .form-group,
        .table-wrapper,
        .table-responsive,
        .dataTables_wrapper {
            padding-left: 0 !important;
            padding-right: 0 !important;
            margin-left: 0 !important;
            margin-right: 0 !important;
            overflow-x: hidden !important;
            max-width: 100% !important;
        }

        .row,
        .col-12,
        .col-md-4,
        .col-md-6,
        .col-md-9,
        .col-md-3,
        .col-lg-12,
        .col-6,
        .col-4 {
            padding-left: 5px !important;
            padding-right: 5px !important;
            margin-left: 0 !important;
            margin-right: 0 !important;
        }

        .main-content {
            padding-top: 0 !important;
        }

        /* ---- Breadcrumbs: keep on one line ---- */
        .breadcrumb {
            font-size: 10px !important;
            margin: 60px 10px 10px 10px !important;
            white-space: nowrap !important;
            overflow: hidden !important;
            text-overflow: ellipsis !important;
            display: flex !important;
            flex-wrap: nowrap !important;
            padding: 6px 10px !important;
        }

        .breadcrumb li {
            display: inline !important;
            white-space: nowrap !important;
        }

        .card {
            margin-top: 0 !important;
        }

        /* ---- Page header: Back button first, then title ---- */
        .page-header {
            display: flex !important;
            flex-direction: column !important;
            align-items: stretch !important;
            margin-bottom: 15px !important;
        }

        .page-header .back-btn {
            order: 1 !important;
            align-self: flex-start !important;
            margin-left: 10px !important;
            margin-bottom: 6px !important;
            font-size: 14px !important;
            padding: 6px 14px !important;
            background-color: #2196f3ab !important;
            color: #fff !important;
            border-radius: 4px !important;
            text-decoration: none !important;
            display: inline-block !important;
        }

        .page-header .back-btn i {
            margin-right: 5px !important;
        }

        .page-header h4 {
            order: 2 !important;
            font-size: 18px !important;
            text-align: center !important;
            margin: 0 !important;
            color: darkblue !important;
        }

        /* ---- No.Of.Questions – center the row ---- */
        .col-md-4 .form-group > div[style*="display: flex;"] {
            justify-content: center !important;
            flex-wrap: nowrap !important;
            align-items: center !important;
        }

        .col-md-4 .form-group > div[style*="display: flex;"] input,
        .col-md-4 .form-group > div[style*="display: flex;"] p {
            font-size: 13px !important;
            height: 32px !important;
            padding: 4px 6px !important;
            margin: 0 4px !important;
            text-align: center !important;
        }

        .col-md-4 .form-group > div[style*="display: flex;"] input[type="text"],
        .col-md-4 .form-group > div[style*="display: flex;"] input[type="number"] {
            width: 30% !important;
            min-width: 50px !important;
            flex: 0 0 auto !important;
        }

        .col-md-4 .form-group > div[style*="display: flex;"] p {
            width: 10% !important;
            min-width: 30px !important;
            margin: 0 !important;
            line-height: 32px !important;
        }

        /* ---- Stack columns ---- */
        .col-md-4,
        .col-md-6,
        .col-md-9,
        .col-md-3,
        .col-6,
        .col-4 {
            width: 100% !important;
            flex: 0 0 100% !important;
            max-width: 100% !important;
        }

        .col-md-12 {
            width: 100% !important;
            flex: 0 0 100% !important;
            max-width: 100% !important;
            padding-left: 0 !important;
            padding-right: 0 !important;
        }

        /* Form inputs full width */
        .form-control,
        .form-control[type="text"],
        .form-control[type="number"],
        textarea.form-control,
        select.form-control {
            font-size: 14px !important;
            height: auto !important;
            padding: 8px 10px !important;
        }

        /* Labels */
        .control-label {
            font-size: 13px !important;
        }

        /* TinyMCE editor – adapt to container */
        .tox-tinymce {
            max-width: 100% !important;
        }

        /* ---- Buttons in top card: full width with spacing ---- */
        .question .row .btn {
            width: 100% !important;
            margin: 6px 0 !important;
            font-size: 14px !important;
            padding: 8px !important;
        }

        .question .row .btn + .btn {
            margin-top: 8px !important;
        }

        /* ---- Dynamic fields – keep inputs and X inline ---- */
        .multi-field {
            display: flex !important;
            flex-wrap: nowrap !important;
            align-items: center !important;
            gap: 6px !important;
            margin-bottom: 8px !important;
        }

        .multi-field input[type="text"] {
            flex: 1 1 0 !important;
            min-width: 0 !important;
            width: auto !important;
            margin: 0 !important;
        }

        .multi-field .remove-field {
            flex: 0 0 auto !important;
            padding: 4px 10px !important;
            font-size: 14px !important;
            margin: 0 !important;
            line-height: 1.4 !important;
        }

        .add-field {
            width: 100% !important;
            margin-top: 6px !important;
            font-size: 14px !important;
            padding: 8px !important;
        }

        .otherBtn {
            display: inline-block !important;
            margin: 6px 0 !important;
        }

        /* Footer controls – wrap and align left */
        #footerDiv {
            justify-content: flex-start !important;
            padding: 10px 5px !important;
        }

        #footerDiv .col-md-12 {
            flex-wrap: wrap !important;
            gap: 8px !important;
        }

        #footerDiv label {
            margin-right: 5px !important;
            font-size: 13px !important;
        }

        #footerDiv .dropdown {
            margin-right: 5px !important;
        }

        #footerDiv .fa {
            font-size: 20px !important;
        }

        /* ---- Table – accordion card layout (OVM‑1 style) ---- */
        #length5 thead {
            display: none !important;
        }

        #length5 tbody tr {
            display: flex !important;
            flex-direction: column !important;
            align-items: stretch !important;
            border: 1px solid #e0e0e0 !important;
            border-radius: 8px !important;
            margin: 8px 5px !important;
            padding: 12px 40px 12px 40px !important;
            background: #fff !important;
            box-shadow: 0 1px 4px rgba(0,0,0,0.05) !important;
            cursor: pointer !important;
            position: relative !important;
            width: calc(100% - 10px) !important;
            transition: background 0.2s;
        }

        #length5 tbody tr:active {
            background: #f5f9ff !important;
        }

        #length5 tbody td {
            display: block !important;
            border: none !important;
            padding: 2px 0 !important;
            text-align: left !important;
            white-space: normal !important;
            width: 100% !important;
            background: transparent !important;
            line-height: 1.3 !important;
            font-size: 13px !important;
            color: #34495e !important;
        }

        /* Sl.No – left badge */
        #length5 tbody td:first-child {
            position: absolute !important;
            left: 12px !important;
            top: 50% !important;
            transform: translateY(-50%) !important;
            width: auto !important;
            font-weight: 700 !important;
            font-size: 14px !important;
            color: #2c3e50 !important;
            padding: 0 !important;
            background: transparent !important;
        }

        #length5 tbody tr.expanded-row td:first-child {
            top: 14px !important;
            transform: none !important;
        }

        /* Question – always visible, bold */
        #length5 tbody td:nth-child(2) {
            font-weight: 600 !important;
            font-size: 16px !important;
            color: #2c3e50 !important;
            margin-bottom: 2px !important;
            order: 1 !important;
            padding-right: 25px !important;
            word-break: break-word;
        }

        /* Action and Active Status – hidden by default */
        #length5 tbody td:nth-child(3),
        #length5 tbody td:nth-child(4) {
            display: none !important;
        }

        /* Expanded row shows Action */
        #length5 tbody tr.expanded-row td:nth-child(3) {
            display: flex !important;
            align-items: center !important;
            flex-wrap: wrap !important;
            gap: 4px !important;
            margin-top: 6px !important;
            order: 2 !important;
        }

        #length5 tbody tr.expanded-row td:nth-child(3)::before {
            content: "Action: ";
            font-weight: 600 !important;
            color: #000 !important;
            margin-right: 4px !important;
        }

        #length5 tbody tr.expanded-row td:nth-child(3) a {
            display: inline-flex !important;
            align-items: center !important;
            justify-content: center !important;
            padding: 2px 4px !important;
            font-size: 16px !important;
            margin: 0 !important;
        }

        #length5 tbody tr.expanded-row td:nth-child(3) a i {
            font-size: 16px !important;
        }

        /* Expanded row shows Active Status */
        #length5 tbody tr.expanded-row td:nth-child(4) {
            display: flex !important;
            align-items: center !important;
            gap: 8px !important;
            margin-top: 6px !important;
            order: 3 !important;
        }

        #length5 tbody tr.expanded-row td:nth-child(4)::before {
            content: "Active: ";
            font-weight: 600 !important;
            color: #000 !important;
        }

        #length5 tbody tr.expanded-row td:nth-child(4) .switch {
            display: inline-block !important;
        }

        /* Right‑side arrow */
        #length5 tbody tr::after {
            content: '\f054';
            font-family: 'FontAwesome';
            position: absolute;
            right: 14px;
            top: 50%;
            transform: translateY(-50%);
            color: #bdc3c7;
            font-size: 16px;
            transition: transform 0.25s ease;
        }

        #length5 tbody tr.expanded-row::after {
            transform: translateY(-50%) rotate(90deg);
            top: 35px;
        }

        /* Empty row – ignore */
        #length5 tbody tr:has(td.dataTables_empty) {
            display: table-row !important;
            border: none !important;
            box-shadow: none !important;
            padding: 0 !important;
            background: transparent !important;
            cursor: default !important;
        }

        #length5 tbody tr:has(td.dataTables_empty) td {
            display: table-cell !important;
            text-align: center !important;
            padding: 20px !important;
            font-size: 13px !important;
            color: #666 !important;
        }

        #length5 tbody tr:has(td.dataTables_empty)::after {
            display: none !important;
        }

        /* DataTable controls (if any) */
        .dataTables_wrapper .row:first-child {
            margin: 0 !important;
            display: flex !important;
            flex-wrap: wrap !important;
            justify-content: space-between !important;
        }

        .dataTables_wrapper .dataTables_length {
            float: left !important;
            margin-left: 8px !important;
        }

        .dataTables_wrapper .dataTables_filter {
            float: right !important;
            padding-right: 8px !important;
        }

        .dataTables_wrapper .dataTables_length,
        .dataTables_wrapper .dataTables_filter,
        .dataTables_wrapper .dataTables_info,
        .dataTables_wrapper .dataTables_paginate {
            font-size: 10px !important;
        }

        .dataTables_wrapper .dataTables_length select {
            font-size: 11px !important;
            height: 32px !important;
            width: 60px !important;
        }

        .dataTables_wrapper .dataTables_filter input {
            width: 90px !important;
            height: 24px !important;
            font-size: 10px !important;
        }

        .card-body h4 {
            font-size: 18px !important;
        }

        /* Heading */
        h3 {
            font-size: 18px !important;
            word-break: break-word;
        }
    }
</style>

<div class="main-content">
    {{ Breadcrumbs::render('question_creation.add_questions', ['question_details_id']) }}
    <div class="section-body mt-0">

        <!-- Page header: Back button first, then title -->
        <div class="page-header">
            <a class="back-btn" href="{{ route('question_creation.index') }}">
                <i class="fa fa-arrow-left" aria-hidden="true"></i> Back
            </a>
            <h4>Questionnaire Creation</h4>
        </div>

        <div class="card question">
            <div class="row" style="margin-bottom: 15px;margin-top: 20px;">
                <div class="col-md-4">
                    <div class="form-group questionnaire">
                        <label class="control-label required">Questionnaire Name </label>
                        <select class="form-control" name="questionnaire_id" id="questionnaire_id">
                            <option value="{{$questionnaire_list[0]['questionnaire_id']}}">
                                {{$questionnaire_list[0]['questionnaire_name']}}</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group questionnaire">
                        <div>
                            <label class="control-label required">No.Of.Questions</label><br>
                        </div>
                        <div style="display: flex;">
                            <input class="form-control" type="text" value="{{$questionnaire_list[0]['question_count']}}"
                                   style="width:40%" readonly />
                            <p style="width:10%"> Of </p>
                            <input class="form-control" type="number" id="no_of_ques" name="no_of_ques"
                                   value="{{$questionnaire_list[0]['no_questions']}}" style="width:50%" autocomplete="off">
                        </div>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group questionnaire">
                        <label class="control-label required">Description</label>
                        <textarea class="form-control" type="text" id="discription1" name="discription" placeholder=""
                                  autocomplete="off">{{$questionnaire_list[0]['q_desc']}}</textarea>
                    </div>
                </div>
                <input type="hidden" id="questionnaire_details_id" name="questionnaire_details_id"
                       value="{{$questionnaire_list[0]['questionnaire_details_id']}}">
                <button type="button" class="btn btn-success" id="saveButton">Update</button>
            </div>
        </div>

        @if($questionnaire_list[0]['question_count'] != $questionnaire_list[0]['no_questions'])
            <form action="{{ route('question_creation.store') }}" id="add_Question" method="POST">
                {{ csrf_field() }}

                <div class="card question" id="next-section">
                    <div class="row" style="margin-bottom: 15px;margin-top: 20px;">
                        <div class="col-md-9" id="question_field">
                            <div class="form-group questionnaire">
                                <label class="control-label required">Question</label>
                                <input class="form-control default" type="text" id="field_question" name="field_question"
                                       autocomplete="off">
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group questionnaire">
                                <label class="control-label required">Question Type</label>
                                <select class="form-control default" name="field_type_id" id="field_type_id"
                                        onChange="typeChange()">
                                    @foreach($field_types as $data)
                                        <option value="{{$data['questionnaire_field_types_id']}}">
                                            {{$data['questionnaire_field_type']}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-12" id="question_descriptionDiv" style="display: none;">
                            <div class="form-group questionnaire">
                                <label class="control-label required">Question Description</label>
                                <textarea class="form-control default" name="add_question_description"
                                          id="add_question_description" autocomplete="off"></textarea>
                            </div>
                        </div>

                        <input type="hidden" name="client_data"
                               value="{{$questionnaire_list[0]['questionnaire_details_id']}}">
                        <div class="col-6" style="display: none;" id="option">
                            <div class="form-group">
                                <label class="required">Option</label>
                                <div class="multi-field-wrapper">
                                    <div class="multi-fields" id="add_other">
                                        <div class="multi-field" style="display: flex;margin-bottom: 5px;">
                                            <input type="text" class="form-control" name="options_questions[]"
                                                   style="background-color: white !important;" id="options_question[]"
                                                   style="margin-right: 10px;">
                                            <button class="remove-field btn btn-danger pull-right" id="remove-f"
                                                    type='button'>X </button>
                                            &nbsp;
                                        </div>
                                    </div>
                                    <button type="button" class="add-field btn btn-success">Add Option</button>
                                    <b class="otherBtn"> or </b>
                                    <a type="button" onclick="add_other()" class="otherBtn" title="Add other"
                                       style="color: blue;"><b>Add other</b></a>
                                </div>
                            </div>
                        </div>
                        <div class="w-100"></div>
                        <div class="col-12" style="display: none;" id="header_field">
                            <div class="form-group questionnaire">
                                <label class="control-label required">Title</label>
                                <input class="form-control" type="text" id="header_title" name="header_title"
                                       style="background-color: white !important;" autocomplete="off">
                            </div>
                            <div class="form-group questionnaire">
                                <label class="control-label required">Description</label>
                                <input class="form-control" type="text" id="header_description" name="header_description"
                                       style="background-color: white !important;" autocomplete="off">
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

                                                <input type="text" class="form-control"
                                                       style="background-color: white !important;" name="sub_question[]"
                                                       id="sub_question[]" style="margin-right: 10px;">
                                                <button class="remove-field btn btn-danger pull-right" id="remove-f"
                                                        type='button'>X </button>
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

                                                <input type="text" class="form-control"
                                                       style="background-color: white !important;" name="sub_options[]"
                                                       id="sub_options[]" style="margin-right: 10px;">
                                                <button class="remove-field btn btn-danger pull-right" id="remove-f"
                                                        type='button'>X </button>
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
                                    <select class="form-control" name="quadrant" id="quadrant"
                                            style="background-color: white !important;">
                                        <option value="">Select Quadrant</option>
                                        @foreach($fields as $quadrant)
                                            @if($quadrant['type_id'] == '1')
                                                <option value="{{$quadrant['field']}}">{{$quadrant['field']}}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-6">
                                <div class="form-group">
                                    <label class="required">Category</label>
                                    <select class="form-control" style="background-color: white !important;"
                                            name="quadrant_type_id" id="quadrant_type_id">
                                        <option value="">Select Quadrant Category</option>
                                        @foreach($fields as $category)
                                            @if($category['type_id'] == '2')
                                                <option value="{{$category['field']}}">{{$category['field']}}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="w-100"></div>
                            <div class="col-6">
                                <div class="form-group">
                                    <!-- <label class="required">Options</label> -->
                                    <div class="multi-field-wrapper">
                                        <div class="multi-fields">
                                            @foreach($options as $option)
                                                <div class="multi-field" style="display: flex;margin-bottom: 5px;">
                                                    <input type="text" class="form-control"
                                                           value="{{$option['option']}} = {{$option['value']}}"
                                                           name="options_questions1[]" id="options_question[]"
                                                           style="margin-right: 10px;" readonly>
                                                    <!-- <button class="remove-field btn btn-danger pull-right" id="remove-f" type='button'>X </button> -->
                                                    &nbsp;
                                                </div>
                                            @endforeach
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
                                    <select class="form-control" name="validation_type" id="validation_type"
                                            onChange="validationType()">
                                        <option value="">Select</option>
                                        <option value="1">Number</option>
                                        <option value="2">Text</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-4" id="validation_operationDiv" style="display: none;">
                                <div class="form-group">
                                    <select class="form-control" name="validation_operation" id="validation_operation"
                                            onchange="validationoperation()">

                                    </select>
                                </div>
                            </div>
                            <div class="col-4" id="validation_conditionDiv" style="display: none;">
                                <input class="form-control default" type="text" id="validation_condition"
                                       name="validation_condition" autocomplete="off">
                            </div>
                        </div>

                        <div id="footerDiv" style="border-top: 1px solid #888;">
                            <div class="col-md-12">
                                <label>Required:</label>
                                <label class='switch' data-bs-toggle='tooltip' data-bs-placement='top'
                                       title='Enable / Disable'>
                                    <input type='checkbox' class='toggle_status' id="required" name='required' checked
                                           value="1">
                                    <span class='slider round'></span>
                                </label>
                                <div class="dropdown">
                                    <a href="#" data-toggle="dropdown">
                                        <i class="fa fa-ellipsis-v"></i>
                                    </a>
                                    <ul class="dropdown-menu">
                                        <li><label class="dropdown-checkbox"><input type="checkbox"
                                                                                    name="dropdown-checkbox['add_description']" id="add_description"
                                                                                    onclick="open_description()">Description</label></li>
                                        <!-- <li><label class="dropdown-checkbox"><input type="checkbox" name="dropdown-checkbox['response_validation]" id="response_validation" onclick="responsevalidation()">Response validation</label></li> -->
                                        <!-- <li><label class="dropdown-checkbox"><input type="checkbox" value="option3"> Option 3</label></li> -->
                                    </ul>
                                </div>

                            </div>
                        </div>
                        <!--  -->
                        <div class="w-100"></div>
                        @if((($questionnaire_list[0]['question_count']) + 1) == $questionnaire_list[0]['no_questions'])
                            <input type="hidden" name="status" value="submit">
                            <a type="button" onclick="submit()" id="submitbutton" class="btn btn-success"
                               title="submit">Submit</a>
                        @else
                            <input type="hidden" name="status" value="save">
                            <a type="button" onclick="submit()" id="submitbutton" class="btn btn-success"
                               title="submit">Save</a>
                        @endif
                    </div>
                </div>

                </section>
            </form>
        @endif

        @if($question_details != [])
            <div class="card question" id="list_section">
                <div class="card-body">
                    <div class="table-wrapper">
                        <div class="table-responsive">
                            <table class="table table-bordered" id="length5">
                                <thead>
                                    <tr>
                                        <th>Sl.No</th>
                                        <th>Question</th>
                                        <th width="20%">Action</th>
                                        <th>Active Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($question_details as $data)
                                        <tr>
                                            <td>{{$loop->iteration}}</td>
                                            <td>{{$data['question']}}</td>
                                            <td>
                                                <a class="btn btn-link"
                                                   onclick="edit_question('{{$data['question_details_id']}}')" title="Edit"
                                                   data-toggle="modal"
                                                   data-target="#editmodulemodal{{$data['question_details_id']}}"
                                                   style="color:darkblue"><i class="fas fa-pencil-alt"></i></a>
                                                @csrf
                                                <a class="btn btn-link" title="Delete"
                                                   onclick="confirmDelete('{{ route('question_creation.data_delete', $data['question_details_id']) }}')"
                                                   style="color:red">
                                                    <i class="far fa-trash-alt"></i>
                                                </a>
                                            </td>
                                            <td style="text-align: center;">
                                                <label class="switch " data-bs-toggle="tooltip" data-bs-placement="top"
                                                       title="Enable / Disable">
                                                    <input type="hidden" name="toggle_id"
                                                           value="{{$data['question_details_id']}}">
                                                    <input type="checkbox" class="toggle_status"
                                                           onclick="functiontoggle('{{$data['question_details_id']}}')"
                                                           id="is_active{{$data['question_details_id']}}" name="is_active"
                                                           @if($data['enable_flag'] == '1') checked @endif>
                                                    <span class="slider round"></span>
                                                </label>

                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        @endif

    </div>
</div>

@include('QuestionCreation.edit')

<script src="https://cdnjs.cloudflare.com/ajax/libs/tinymce/4.5.6/tinymce.min.js"></script>
<script src="http://cdnjs.cloudflare.com/ajax/libs/tinymce/4.5.6/jquery.tinymce.min.js"></script>
<script>
    $(document).ready(function () {

        tinymce.init({
            selector: 'textarea#discription1',
            height: 180,
            menubar: false,
            branding: false,
            toolbar: 'undo redo | formatselect | ' +
                'bold italic backcolor | alignleft aligncenter ' +
                'alignright alignjustify | bullist numlist outdent indent | ' +
                'removeformat | help',
            content_style: 'body { font-family:Helvetica,Arial,sans-serif;background-color:#E2E4E6 !important; color: #000000; font-size:14px }'
        });
        // event.preventDefault()

        // Initialize form sections based on the pre-selected question type on page load.
        typeChange();
    });

    function edit_question(id) {

        edit_question_id = id;

        $.ajax({
            url: "{{ url('/question_creation/get_options') }}",
            type: "POST",
            data: {
                _token: '{{csrf_token()}}',
                edit_question_id: edit_question_id,
            },

            success: function (data) {

                if (data == 3 || data == 4 || data == 5) {
                    $('#edit_option' + id).show();
                } else if (data == 6 || data == 7 || data == 12) {
                    $('#edit_option' + id).hide();
                    $('#edit_sub_questions' + id).show();
                } else if (data == 8) {
                    $('#edit_option' + id).hide();
                    $('#edit_multiple_questions' + id).show();
                } else {
                    $('#edit_option' + id).hide();
                }
            },
            error: function (data) {
                console.log(data);
            }
        });
    }
</script>
<script>
    $("#saveButton").click(function (event) {
        event.preventDefault();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        var questionnaire_id = document.getElementById("questionnaire_id").value;
        if (questionnaire_id == null || questionnaire_id == "") {
            swal.fire("Please Select Questionnaire Name", "", "error");
            return false;
        }
        var editor = tinymce.get('discription1');
        var content = editor.getContent();
        // var discription1 = document.getElementById("discription1").value;
        var discription1 = content;
        // console.log(content);
        if (discription1 == null || discription1 == '') {
            swal.fire("Please Fill Description", "", "error");
            return false;
        }

        var no_of_ques = document.getElementById("no_of_ques").value;
        if (no_of_ques == '' || no_of_ques == null) {
            swal.fire("Please Enter No Of Questions", "", "error");
            return false;
        }

        var questionnaire_details_id = document.getElementById("questionnaire_details_id").value;

        $('#saveButton').prop('disabled', true);

        $.ajax({
            url: "{{ url('/question_creation/question_update') }}",
            type: "POST",
            data: {
                _token: '{{csrf_token()}}',
                questionnaire_id: questionnaire_id,
                discription: discription1,
                no_of_ques: no_of_ques,
                questionnaire_details_id: questionnaire_details_id
            },

            success: function (data) {
                window.location.href = "/question_creation/add_questions/" + data;
            },
            error: function (data) {
                swal.fire({
                    title: "Error",
                    text: data,
                    type: "error",
                    confirmButtonColor: '#e73131',
                    confirmButtonText: 'OK',
                });

            }
        });

    });
</script>
<script>
    function newsection() {
        document.getElementById('next-section').style.display = "block";

    }
</script>
<script type="text/javascript">
    $('.multi-field-wrapper').each(function () {
        var $wrapper = $('.multi-fields', this);
        $(".add-field", $(this)).click(function (e) {
            $('.multi-field:first-child', $wrapper).clone(true).appendTo($wrapper).find('input').val('').focus();
        });
        $('.multi-field .remove-field', $wrapper).click(function () {
            if ($('.multi-field', $wrapper).length > 2)
                $(this).parent('.multi-field').remove();
            else swal.fire("Required Two Option", "", "error");
        });
    });
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
        } else if (fieldtype == 3) {
            $('#option').show();
            $('#sub_questions').hide();
            $('#multiple_questions').hide();
            $('#question_field').show();
            $('#header_field').hide();
            $('#footerDiv').show();
            $('.otherBtn').hide();
        } else if (fieldtype == 6 || fieldtype == 7 || fieldtype == 12) {
            $('#option').hide();
            $('#header_field').hide();
            $('#sub_questions').show();
            $('#question_field').show();
            $('#multiple_questions').hide();
            $('#footerDiv').show();
            $('.otherBtn').hide();
        } else if (fieldtype == 8) {
            $('#header_field').hide();
            $('#multiple_questions').show();
            $('#sub_questions').hide();
            $('#option').hide();
            $('#question_field').show();
            $('#footerDiv').show();
            $('.otherBtn').hide();
        } else if (fieldtype == 9) {
            $('#header_field').hide();
            $('#footerDiv').hide();
            $('#option').hide();
            $('#sub_questions').hide();
            $('#multiple_questions').hide();
            $('#question_field').show();
            $('#question_descriptionDiv').show();
            $('.otherBtn').hide();
        } else {
            $('#footerDiv').show();
            $('#header_field').hide();
            $('#question_field').show();
            $('#option').hide();
            $('#sub_questions').hide();
            $('#multiple_questions').hide();
            $('.otherBtn').hide();
        }
    }
</script>
<script src="https://cdn.jsdelivr.net/jquery.validation/1.15.1/jquery.validate.min.js"></script>
<script>
    function submit() {

        var fieldtype = $('#field_type_id').val();

        if (fieldtype == null || fieldtype == "") {
            Swal.fire("Please Select Question Type", "", "error");
            return false;
        }

        if (fieldtype == 9) {
            var header_title = $('#header_title').val();
            var header_description = $('#header_description').val();

            if (header_title == "" || header_title == null) {
                // If the specific header_title field is hidden, check the main field_question
                header_title = $('#field_question').val();
                header_description = $('#question_description').val();
                if (header_title == "" || header_title == null) {
                    Swal.fire("Please Enter Header Title", "", "error");
                    return false;
                }
            }
        } else {
            var field_question = $('#field_question').val();

            if (field_question == null || field_question == "") {
                Swal.fire("Please Enter Question", "", "error");
                return false;
            }

            if ($('#add_description').is(':checked')) {
                var description = $('#add_question_description').val().trim();

                if (description == "" || description == null) {
                    Swal.fire("Please Enter Question Description", "", "error");
                    return false;
                }
            }
        }

        if (fieldtype == 8) {
            var quadrant = $('#quadrant').val();
            if (quadrant == null || quadrant == "") {
                Swal.fire("Please Select Quadrant", "", "error");
                return false;
            }
            var category = $('#quadrant_type_id').val();
            if (category == null || category == "") {
                Swal.fire("Please Select Category", "", "error");
                return false;
            }
        }

        // Scope lookups to the add form only, to avoid picking up
        // option inputs from the hidden edit modals on the same page.
        var addForm = document.getElementById('add_Question');

        if (fieldtype == 3 || fieldtype == 4 || fieldtype == 5) {

            var que = addForm.querySelectorAll('input[name="options_questions[]"]');
            var QueLength = que.length;

            if (QueLength < 2) {
                Swal.fire("Required Two Option!", "", "error");
                return false;
            }

            for (i = 0; i < QueLength; i++) {
                if (que[i].value == "") {
                    Swal.fire("Please Fill Option Field!", "", "error");
                    return false;
                }
            }

        } else if (fieldtype == 6 || fieldtype == 7 || fieldtype == 12) {

            var Subque = addForm.querySelectorAll('input[name="sub_question[]"]');
            var SubLength = Subque.length;

            if (SubLength < 1) {
                Swal.fire("Required Two Question!", "", "error");
                return false;
            }

            for (i = 0; i < SubLength; i++) {
                if (Subque[i].value == "") {
                    Swal.fire("Please Fill Sub Question Field!", "", "error");
                    return false;
                }
            }

            var queOpt = addForm.querySelectorAll('input[name="sub_options[]"]');
            var QueOpLength = queOpt.length;

            if (QueOpLength < 2) {
                Swal.fire("Required Two Option!", "", "error");
                return false;
            }

            for (i = 0; i < QueOpLength; i++) {
                if (queOpt[i].value == "") {
                    Swal.fire("Please Fill Option Field!", "", "error");
                    return false;
                }
            }
        }

        // ✅ FINAL CONFIRMATION
        Swal.fire({
            title: "Are you sure?",
            text: "Do you want to create this questionnaire?",
            icon: "question",
            showCancelButton: true,
            confirmButtonText: "Yes, Create",
            cancelButtonText: "No",
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('add_Question').submit();
            }
        });
    }
</script>
<script type="application/javascript">
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
            function (isConfirm) {

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
</script>
<script>
    function open_description() {
        if ($('#add_description').prop('checked')) {
            $('#question_descriptionDiv').show();
        } else {
            $('#question_descriptionDiv').hide();
        }
    }

    function responsevalidation() {
        if ($('#response_validation').prop('checked')) {
            $('#response_validationDiv').show();
        } else {
            $('#response_validationDiv').hide();
        }
    }

    function validationType() {

        $('#validation_conditionDiv').hide();
        $('#validation_operationDiv').hide();
        var validation_type = document.getElementById('validation_type').value;
        $.ajax({
            url: "{{ route('questionnaire.validation') }}",
            type: 'POST',
            data: {
                validation_type: validation_type,
                _token: '{{csrf_token()}}'
            },
            error: function () {
                alert('Something is wrong');
            },
            success: function (data) {
                var ddd = "<option value=''>Select</option>";
                for (var i = 0; i < data.length; i++) {
                    var id = data[i]['id'];
                    var operation = data[i]['operation'];
                    ddd += "<option value=" + id + ">" + operation + "</option>";
                }
                $('#validation_operation').html(ddd);
                $('#validation_operationDiv').show();
            }


        });
    }

    function validationoperation() {
        $('#validation_conditionDiv').show();
    }

    function functiontoggle(id) {
        // alert(id);
        if ($('#is_active' + id).prop('checked')) {
            var is_active = '1';
        } else {
            var is_active = '0';
        }
        var f_id = id;

        $.ajax({
            url: "{{ route('questionnaire.update_toggle') }}",
            type: 'POST',
            data: {
                is_active: is_active,
                f_id: f_id,
                _token: '{{csrf_token()}}'
            },
            error: function () {
                alert('Something is wrong');
            },
            success: function (data) {

                var data_convert = $.parseJSON(data);

                // console.log(data_convert.Data);
                if (data_convert.Data == 0) {
                    swal.fire({
                        title: "Success",
                        text: "Question Deactivated",
                        type: "success"
                    },);
                } else {
                    swal.fire({
                        title: "Success",
                        text: "Question Activated",
                        type: "success"
                    },);
                }

            }


        });
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
</script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    function confirmDelete(url) {
        Swal.fire({
            title: 'Are you sure?',
            text: "This action cannot be undone!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Yes, delete it!',
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = url;
            }
        });
    }
</script>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        var inputs = document.querySelectorAll("input.form-control");
        var questionCount = inputs[0].value;
        var totalQuestions = inputs[1].value;

        if (parseInt(questionCount) === parseInt(totalQuestions)) {
            // Hide the form container that adds new questions, but keep the count visible
            document.getElementById('next-section').style.display = "none";
        }
    });

    // ============================================================
    // MOBILE ACCORDION – click table row to expand (like OVM-1)
    // ============================================================
    $(document).ready(function() {
        $('#length5 tbody').on('click', 'tr', function(e) {
            // Ignore clicks on action links/buttons or toggle switches
            if ($(e.target).closest('a, button, input, form, .switch, label').length) {
                return;
            }
            // Only on mobile (≤ 768px)
            if ($(window).width() <= 768) {
                // Close any other open row (single-expand)
                $(this).siblings().removeClass('expanded-row');
                $(this).toggleClass('expanded-row');
            }
        });
    });
</script>

@if(session('success'))
    <script>
        Swal.fire({
            icon: 'success',
            title: 'Success',
            text: "{{ session('success') }}",
            confirmButtonText: 'OK'
        });
    </script>
@endif

@endsection