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

    :root {
        --borderWidth: 5px;
        --height: 24px;
        --width: 12px;
        --borderColor: #78b13f;
    }

    .check {
        display: inline-block;
        transform: rotate(50deg);
        height: var(--height);
        width: var(--width);
        border-bottom: var(--borderWidth) solid var(--borderColor);
        border-right: var(--borderWidth) solid var(--borderColor);
    }

    .nav-justified {
        display: flex !important;
        align-items: center !important;
    }

    .gender {
        display: flex;
        align-items: center;
        justify-content: space-evenly;
    }

    .egc {
        display: flex;
        border: 1px solid #350756;
        padding: 8px 25px 8px 8px;
        align-items: center;
        justify-content: space-between;
    }

    .dq {
        font-size: 16px;
        width: 80%;
        font-weight: 600;
    }

    .answer {
        width: 15%;
        display: flex;
        color: #04092e !important;
        justify-content: space-around;
    }

    .questions {
        color: #000c62 !important;
    }

    input[type='radio']:checked:after {
        background-color: #34395e !important;
    }

    input[type='radio']:after {
        background-color: #34395e !important;
    }

    .switch-field {
        display: flex;
    }

    .switch-field input {
        position: absolute !important;
        clip: rect(0, 0, 0, 0);
        height: 1px;
        width: 1px;
        border: 0;
        overflow: hidden;
    }

    .switch-field label {
        background-color: #e4e4e4;
        color: rgba(0, 0, 0, 0.6);
        font-size: 14px;
        line-height: 1;
        text-align: center;
        padding: 8px 16px;
        margin-right: -1px;
        border: 1px solid rgba(0, 0, 0, 0.2);
        box-shadow: inset 0 1px 3px rgba(0, 0, 0, 0.3), 0 1px rgba(255, 255, 255, 0.1);
        transition: all 0.1s ease-in-out;
    }

    .switch-field label:hover {
        cursor: pointer;
    }

    .switch-field input:checked+label {
        background-color: #a5dc86;
        box-shadow: none;
    }

    .switch-field label:first-of-type {
        border-radius: 4px 0 0 4px;
    }

    .switch-field label:last-of-type {
        border-radius: 0 4px 4px 0;
    }

    .vl {
        border-left: 1px solid #350756;
        height: 40px;
    }

    .close {
        color: white;
        opacity: 1;
    }

    /* ---- Button alignment & spacing ---- */
    .btn-create-wrapper {
        text-align: left;
        margin-bottom: 1rem;
    }

    .btn-create {
        background: #044a95 !important;
        border-color: #a9ca !important;
        color: white !important;
        font-size: 15px;
        padding: 8px 16px;
        display: inline-block;
        border-radius: 4px;
        text-decoration: none;
    }

    .btn-create .btn-label {
        font-size: 15px;
        padding: 8px;
    }

    .btn-create:hover,
    .btn-create:focus {
        color: white !important;
        text-decoration: none;
    }

    /* ============================================================
       MOBILE ACCORDION – EXACTLY LIKE OVM‑1 + overflow fixes
       ============================================================ */
    @media (max-width: 768px) {

        /* Reset paddings and prevent horizontal scroll */
        .main-content,
        .card,
        .card-body,
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
        .col-lg-12 {
            padding-left: 5px !important;
            padding-right: 5px !important;
            margin-left: 0 !important;
            margin-right: 0 !important;
        }

        .main-content {
            padding-top: 0 !important;
        }

        .breadcrumb {
            font-size: 11px !important;
            margin: 60px 10px 10px 10px !important;
        }

        .card {
            margin-top: 0 !important;
        }

        .table-responsive {
            overflow-x: hidden !important;
            max-height: none !important;
        }

        /* Force table to be full width and not overflow */
        .table-responsive table {
            min-width: 100% !important;
            width: 100% !important;
            table-layout: fixed !important;
        }

        /* DataTables wrapper */
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

        /* ---- "Create Questionnaire" button – smaller + left margin ---- */
        .btn-create-wrapper {
            margin-bottom: 0.75rem !important;
            padding-left: 10px !important;  /* add left spacing on mobile */
        }

        .btn-create {
            font-size: 12px !important;
            padding: 4px 10px !important;
        }

        .btn-create .btn-label {
            font-size: 12px !important;
            padding: 4px 6px !important;
        }

        /* ---- Hide table header on mobile ---- */
        #align1 thead {
            display: none !important;
        }

        /* ---- Each row becomes a card ---- */
        #align1 tbody tr {
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

        #align1 tbody tr:active {
            background: #f5f9ff;
        }

        /* --- Each cell becomes a block --- */
        #align1 tbody td {
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

        /* ---- Sl.No – left side badge ---- */
        #align1 tbody td:first-child {
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

        #align1 tbody tr.expanded-row td:first-child {
            top: 14px !important;
            transform: none !important;
        }

        /* ---- Questionnaire Name – always visible, bold ---- */
        #align1 tbody td:nth-child(2) {
            font-weight: 600 !important;
            font-size: 16px !important;
            color: #2c3e50 !important;
            margin-bottom: 2px !important;
            order: 1 !important;
            padding-right: 25px !important;
            word-break: break-word;
        }

        /* ---- No. of Questions, Type, Action – hidden by default ---- */
        #align1 tbody td:nth-child(3),
        #align1 tbody td:nth-child(4),
        #align1 tbody td:nth-child(5) {
            display: none !important;
        }

        /* ---- Expanded row shows No. of Questions ---- */
        #align1 tbody tr.expanded-row td:nth-child(3) {
            display: block !important;
            margin-top: 4px !important;
            order: 2 !important;
        }
        #align1 tbody tr.expanded-row td:nth-child(3)::before {
            content: "No. of Questions: ";
            font-weight: 600 !important;
            color: #000 !important;
        }

        /* ---- Expanded row shows Type ---- */
        #align1 tbody tr.expanded-row td:nth-child(4) {
            display: block !important;
            margin-top: 4px !important;
            order: 3 !important;
        }
        #align1 tbody tr.expanded-row td:nth-child(4)::before {
            content: "Type: ";
            font-weight: 600 !important;
            color: #000 !important;
        }

        /* ---- Expanded row shows Action ---- */
        #align1 tbody tr.expanded-row td:nth-child(5) {
            display: flex !important;
            align-items: center !important;
            flex-wrap: nowrap !important;
            gap: 4px !important;
            margin-top: 6px !important;
            order: 4 !important;
            white-space: nowrap !important;
            overflow-x: auto;
        }
        #align1 tbody tr.expanded-row td:nth-child(5)::before {
            content: "Action:";
            font-weight: 600 !important;
            color: #000 !important;
            margin-right: 6px !important;
            flex-shrink: 0 !important;
        }
        #align1 tbody tr.expanded-row td:nth-child(5) a {
            display: inline-flex !important;
            align-items: center !important;
            justify-content: center !important;
            padding: 2px 4px !important;
            font-size: 14px !important;
            margin: 0 !important;
        }
        #align1 tbody tr.expanded-row td:nth-child(5) a i {
            font-size: 14px !important;
        }

        /* ---- Right‑side arrow ---- */
        #align1 tbody tr::after {
            content: '\f054';
            font-family: 'FontAwesome';
            position: absolute;
            right: 14px;
            top: 50%;
            transform: translateY(-50%);
            color: #bdc3c7;
            font-size: 14px;
            transition: transform 0.25s ease;
        }
        #align1 tbody tr.expanded-row::after {
            transform: translateY(-50%) rotate(90deg);
        }

        /* ---- Empty row (no data) ---- */
        #align1 tbody tr:has(td.dataTables_empty) {
            display: table-row !important;
            border: none !important;
            box-shadow: none !important;
            padding: 0 !important;
            background: transparent !important;
            cursor: default !important;
        }
        #align1 tbody tr:has(td.dataTables_empty) td {
            display: table-cell !important;
            text-align: center !important;
            padding: 20px !important;
            font-size: 13px !important;
            color: #666 !important;
        }
        #align1 tbody tr:has(td.dataTables_empty)::after {
            display: none !important;
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
    {{ Breadcrumbs::render('question_creation.index') }}

    <!-- Create button wrapper – left aligned with bottom spacing -->
    <div class="btn-create-wrapper">
        <a href="{{ route('question_creation.create') }}" class="btn btn-labeled btn-info btn-create" title="Create Questionnaire">
            <span class="btn-label"><i class="fa fa-plus"></i></span> Create Questionnaire
        </a>
    </div>

    <div class="row">
        <div class="card-body">
            <div class="table-wrapper">
                <div class="table-responsive">
                    <table class="table table-bordered" id="align1">
                        <h3 style="text-align: center; color: #00008B;">
                            Questionnaire Creation List View
                        </h3>
                        <thead>
                            <tr>
                                <th>Sl.No</th>
                                <th>Questionnaire Name</th>
                                {{-- <th>Description</th>--}}
                                <th>No. of. Questions</th>
                                <th>Type</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($questionnaire_index as $data)
                            <tr>
                                <td>{{$loop->iteration}}</td>
                                <td>{{$data['questionnaire_name']}}</td>
                                {{--<td>{!! $data['q_desc'] !!}</td>--}}
                                <td>{{$data['no_questions']}}</td>
                                <td>{{$data['questionnaire_type']}}</td>
                                <td>
                                    <!-- <a class="btn btn-link" title="View" href="{{ route('question_creation.show', \Crypt::encrypt($data['questionnaire_details_id'])) }}"><i class="fas fa-eye" style="color:green"></i></a> -->
                                    <a class="btn btn-link" title="Edit" href="{{ route('question_creation.add_questions', \Crypt::encrypt($data['questionnaire_details_id'])) }}"><i class="fas fa-pencil-alt" style="color: blue !important"></i></a>
                                    @csrf
                                    <a class="btn btn-link" title="View"
                                        href="{{ route('question_creation.view_questions', Crypt::encrypt($data['questionnaire_details_id'])) }}">
                                        <i class="fas fa-eye" style="color: green !important"></i>
                                    </a>
                                    <!-- <a href="javascript:void(0)"
                                        class="btn btn-link"
                                        title="Delete"
                                        onclick="confirmDelete('{{ route('question_creation.delete', $data['questionnaire_id']) }}')">
                                        <i class="far fa-trash-alt" style="color:red !important"></i>
                                    </a> -->
                                </td>
                            </tr>
                            @endforeach
                            <input type="hidden" class="cfn" id="fn" value="0">
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-1.7.2.min.js"></script>
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
            function(isConfirm) {

                if (isConfirm) {
                    swal.fire("Deleted!", "Data Deleted successfully!", "success");
                    var url = $('#' + id).val();

                    window.location.href = url;

                } else {
                    swal.fire("Cancelled", "Your file is safe :)", "error");
                    e.preventDefault();
                }
            });
    }
</script>
<script>
    function confirmDelete(url) {
        Swal.fire({
            title: 'Are you sure?',
            text: "Do you really want to delete this question?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Yes, Delete',
            cancelButtonText: 'No, Cancel'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = url;
            }
        });
    }

    // ============================================================
    // MOBILE ACCORDION – click row to expand (like OVM-1)
    // ============================================================
    $(document).ready(function() {
        $('#align1 tbody').on('click', 'tr', function(e) {
            // Ignore clicks on action links/buttons
            if ($(e.target).closest('a, button, input, form').length) {
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
        confirmButtonText: 'OK',
        allowOutsideClick: false
    });
</script>
@endif

@if(session('fail'))
<script>
    Swal.fire({
        icon: 'error',
        title: 'Error',
        text: "{{ session('fail') }}",
        confirmButtonText: 'OK',
        allowOutsideClick: false
    });
</script>
@endif

@endsection