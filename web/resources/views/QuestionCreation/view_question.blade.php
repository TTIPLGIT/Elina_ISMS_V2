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

    /* ============================================================
       MOBILE RESPONSIVE – FIXED OVERLAPPING & WRAPPING
       ============================================================ */
    @media (max-width: 768px) {

        /* Reset paddings and prevent horizontal scroll */
        .main-content,
        .card,
        .card-body,
        .form-group,
        .table-wrapper,
        .dataTables_wrapper,
        .table-responsive {
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
        .col-lg-12 {
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
        .col-md-4 {
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

        /* ==========================================================
           TABLE – CARD LAYOUT WITH WRAPPING
           ========================================================== */
        #length5 thead {
            display: none !important;
        }

        #length5 tbody tr {
            display: flex !important;
            flex-wrap: wrap !important;      /* ← CRITICAL: allows text to wrap under number */
            align-items: flex-start !important;
            width: 100% !important;
            border: 1px solid #ddd !important;
            border-radius: 8px !important;
            padding: 12px !important;
            margin-bottom: 10px !important;
            box-sizing: border-box !important;
            background: #fff !important;
            box-shadow: 0 1px 4px rgba(0,0,0,0.05) !important;
        }

        #length5 tbody td {
            border: none !important;
            padding: 0 !important;
            text-align: left !important;
            white-space: normal !important;
            word-break: break-word !important;
            background: transparent !important;
            line-height: 1.4 !important;
            font-size: 14px !important;
            color: #34495e !important;
            display: block !important;
            width: auto !important;
        }

        /* Sl.No – fixed width, stays on left */
        #length5 tbody td:first-child {
            width: 35px !important;
            min-width: 35px !important;
            flex: 0 0 35px !important;
            font-weight: 700 !important;
            font-size: 14px !important;
            color: #2c3e50 !important;
            margin-right: 10px !important;
            padding: 0 !important;
        }

        /* Question text – takes remaining width, wraps freely */
        #length5 tbody td:nth-child(2) {
            flex: 1 1 auto !important;          /* grow, shrink, auto basis */
            min-width: 0 !important;            /* allows shrinking below content width */
            width: calc(100% - 45px) !important; /* fallback for older browsers */
            max-width: calc(100% - 45px) !important;
            white-space: normal !important;
            word-break: break-word !important;
            overflow-wrap: anywhere !important;
            word-wrap: break-word !important;
            font-weight: 500 !important;
            font-size: 15px !important;
            line-height: 1.6 !important;
            padding: 0 !important;
            margin: 0 !important;
        }

        /* Empty row – keep as table row */
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

        /* DataTable controls */
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

        h3 {
            font-size: 18px !important;
            word-break: break-word;
        }
    }
</style>

<div class="main-content">
    {{ Breadcrumbs::render('question_creation.view_questions', request()->route('id')) }}
    <div class="section-body mt-0">

        <!-- Page header: Back button first, then title -->
        <div class="page-header">
            <a class="back-btn" href="{{ route('question_creation.index') }}">
                <i class="fa fa-arrow-left" aria-hidden="true"></i> Back
            </a>
            <h4>Questionnaire Creation Show</h4>
        </div>

        <div class="card question">
            <div class="row" style="margin-bottom: 15px;margin-top: 20px;">
                <div class="col-md-4">
                    <div class="form-group questionnaire">
                        <label class="control-label required">Questionnaire Name </label>
                        <select class="form-control" name="questionnaire_id" id="questionnaire_id" disabled>
                            <option value="{{$questionnaire_list[0]['questionnaire_id']}}">{{$questionnaire_list[0]['questionnaire_name']}}</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group questionnaire">
                        <div>
                            <label class="control-label required">No.Of.Questions</label><br>
                        </div>
                        <div style="display: flex;">
                            <input class="form-control" type="text" disabled value="{{$questionnaire_list[0]['question_count']}}" style="width:40%" readonly />
                            <p style="width:10%"> Of </p>
                            <input class="form-control" type="number" disabled id="no_of_ques" name="no_of_ques" value="{{$questionnaire_list[0]['no_questions']}}" style="width:50%" autocomplete="off">
                        </div>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group questionnaire" disabled>
                        <label class="control-label required">Description</label>
                        <textarea class="form-control bg-light" id="discription1" name="discription" autocomplete="off" readonly>{{ $questionnaire_list[0]['q_desc'] }}</textarea>
                    </div>
                </div>
                <input type="hidden" id="questionnaire_details_id" name="questionnaire_details_id" value="{{$questionnaire_list[0]['questionnaire_details_id']}}">
            </div>
        </div>

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
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($question_details as $data)
                                        <tr>
                                            <td>{{$loop->iteration}}</td>
                                            <td>{{$data['question']}}</td>
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
    $(document).ready(function() {

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

            success: function(data) {

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
            error: function(data) {
                console.log(data);
            }
        });
    }
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