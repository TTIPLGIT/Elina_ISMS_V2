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
        color: #000c62 !important
    }
    input[type='radio']:checked:after {
        background-color: #34395e !important;
    }
    input[type='radio']:after {
        background-color: #34395e !important;
    }
    /* radiocss */
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
    /* endcss */
    .vl {
        border-left: 1px solid #350756;
        height: 40px;
    }
    .close {
        color: white;
        opacity: 1;
    }

    /* ==============================================================
       FIX: Prevent Status header & cell text from wrapping
       ============================================================== */
    #align thead th {
        white-space: nowrap;
    }
    /* Prevent status values like "submitted" from wrapping */
    #align td:nth-of-type(5) {
        white-space: nowrap;
    }

    /* ==============================================================
       RESPONSIVE MOBILE STYLING (No Horizontal Scroll, Auto-Adjusts UI Layout)
       ============================================================== */
    .table-responsive {
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
    }

    @media (max-width: 768px) {

        /* Remove unwanted left/right spacing */
        .main-content,
        .card,
        .card-body,
        .table-wrapper,
        .searchResultStudent,
        .table-responsive {
            padding-left: 0 !important;
            padding-right: 0 !important;
            margin-left: 0 !important;
            margin-right: 0 !important;
        }

        .row,
        .col-12,
        .col-lg-12 {
            padding-left: 5px !important;
            padding-right: 5px !important;
        }

        .table-responsive {
            overflow-x: hidden !important;
            overflow-y: auto !important;
            max-height: 80vh;
        }

        .table-responsive table {
            font-size: 12px;
            min-width: 100% !important;
            width: 100% !important;
        }

        .searchResultStudent table,
        .searchResultStudent thead,
        .searchResultStudent tbody,
        .searchResultStudent th,
        .searchResultStudent td {
            display: block !important;
            width: 100% !important;
        }

        .searchResultStudent thead {
            display: none !important;
        }

        .searchResultStudent tbody {
            background: transparent !important;
        }

        #align {
            width: 100% !important;
            margin: 0 !important;
        }

        #align tr {
            display: flex !important;
            flex-direction: column !important;
            align-items: stretch !important;
            border: 1px solid #e0e0e0 !important;
            border-radius: 8px !important;
            margin: 8px 5px !important;
            position: relative !important;
            padding: 10px 15px 10px 45px !important;
            background: #fff !important;
            box-shadow: 0 1px 4px rgba(0,0,0,0.05) !important;
            cursor: pointer;
            width: calc(100% - 10px) !important;
        }

        #align td {
            display: block !important;
            border: none !important;
            padding: 0 !important;
            text-align: left !important;
            white-space: normal !important;
            width: 100% !important;
            background: transparent !important;
            height: auto !important;
            min-height: 0 !important;
            line-height: 1.2 !important;
        }

        /* S.No */
        #align td:nth-of-type(1) {
            position: absolute !important;
            left: 15px !important;
            top: 50% !important;
            transform: translateY(-50%) !important;
            width: 25px !important;
            display: flex !important;
            font-weight: bold !important;
            font-size: 13px !important;
            color: #2c3e50 !important;
        }

        #align tr.expanded-row td:nth-of-type(1) {
            top: 20px !important;
            transform: translateY(0) !important;
        }

        #align td:nth-of-type(2) {
            display: block !important;
            font-weight: 600 !important;
            font-size: 16px !important;
            color: #2c3e50 !important;
            margin-bottom: 4px !important;
            padding-right: 25px !important;
            order: 1 !important;
        }
        #align td:nth-of-type(4) {
            display: block !important;
            font-size: 13px !important;
            color: #34495e !important;
            margin-bottom: 10px !important;
            order: 2 !important;
        }
        #align td:nth-of-type(4):before {
            content: "ID: ";
            font-weight: 600 !important;
            color: #000 !important;
        }

        /* Hidden Fields */
        #align td:nth-of-type(3),
        #align td:nth-of-type(5),
        #align td:nth-of-type(6) {
            display: none !important;
        }

        /* Arrow */
        #align tr::after {
            content: '\f054';
            font-family: 'FontAwesome';
            position: absolute;
            right: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: #bdc3c7;
            transition: transform 0.3s;
            font-size: 12px;
        }

        #align tr.expanded-row::after {
            transform: translateY(-50%) rotate(90deg);
            top: 35px;
        }

        #align tr.expanded-row td:nth-of-type(3) {
            display: block !important;
            margin-top: 8px !important;
            font-size: 12px !important;
            color: #34495e !important;
            order: 3 !important;
        }

        #align tr.expanded-row td:nth-of-type(3):before {
            content: "Email: ";
            font-weight: 600 !important;
            color: #000 !important;
            margin-right: 4px !important;
        }

        #align tr.expanded-row td:nth-of-type(5) {
            display: block !important;
            margin-top: 6px !important;
            font-size: 12px !important;
            color: #34495e !important;
            order: 4 !important;
            white-space: nowrap !important; /* Keep status value on one line even in expanded view */
        }

        /* No Matching Records Found - Mobile Fix */
        #align td.dataTables_empty {
            display: table-cell !important;
            width: 100% !important;
            text-align: center !important;
            white-space: nowrap !important;
            padding: 15px !important;
            font-size: 13px !important;
            font-weight: 600 !important;
            color: #666 !important;
        }

        #align tr:has(td.dataTables_empty) {
            display: table-row !important;
            border: none !important;
            box-shadow: none !important;
            padding: 0 !important;
            background: transparent !important;
        }

        #align tr:has(td.dataTables_empty)::after {
            display: none !important;
        }

        #align tr.expanded-row td:nth-of-type(5):before {
            content: "Status: ";
            font-weight: 600 !important;
            color: #000 !important;
            margin-right: 4px !important;
        }

        #align tr.expanded-row td:nth-of-type(6) {
            display: flex !important;
            align-items: center !important;
            gap: 10px !important;
            margin-top: 8px !important;
            font-size: 12px !important;
            order: 5 !important;
        }

        #align tr.expanded-row td:nth-of-type(6) a {
            display: inline-flex !important;
            align-items: center !important;
            margin-right: 8px !important;
            font-size: 15px !important;
        }

        #align tr.expanded-row td:nth-of-type(6):before {
            content: "Action: ";
            font-weight: 600 !important;
            color: #000 !important;
            margin-right: 4px !important;
        }

        /* Action icons smaller */
        #align td a {
            font-size: 12px !important;
            padding: 2px !important;
        }

        /* DataTable controls */
        .dataTables_wrapper,
        .dataTables_wrapper .dataTables_length,
        .dataTables_wrapper .dataTables_filter,
        .dataTables_wrapper .dataTables_info,
        .dataTables_wrapper .dataTables_paginate {
            font-size: 11px !important;
        }

        .dataTables_wrapper .dataTables_length select {
            font-size: 11px !important;
            height: 26px !important;
            padding: 2px 4px !important;
        }

        .dataTables_wrapper .dataTables_filter input {
            font-size: 11px !important;
            height: 26px !important;
            width: 110px !important;
        }

        .dataTables_wrapper .paginate_button {
            font-size: 11px !important;
            padding: 2px 5px !important;
        }

        /* PDF / Excel / Copy / Print Buttons */
        .dt-buttons .btn,
        .buttons-copy,
        .buttons-csv,
        .buttons-excel,
        .buttons-pdf,
        .buttons-print {
            font-size: 10px !important;
            padding: 4px 6px !important;
        }

        /* Breadcrumb */
        .breadcrumb {
            font-size: 11px !important;
        }

        /* Heading */
        .card-body h4 {
            font-size: 18px !important;
        }

        /* DataTable Top Controls - Mobile */
        .dataTables_wrapper .row:first-child {
            margin: 0 !important;
        }

        .dataTables_wrapper .row:first-child > div:first-child {
            padding-left: 0 !important;
            text-align: left !important;
        }

        .dataTables_wrapper .row:first-child > div:last-child {
            padding-right: 0 !important;
            text-align: right !important;
        }

        .dataTables_wrapper .dataTables_length {
            float: left !important;
            margin-left: 8px !important;
        }

        .dataTables_wrapper .dataTables_filter {
            float: right !important;
            margin-right: 0 !important;
        }

        .dataTables_wrapper .dataTables_filter {
            text-align: right !important;
            padding-right: 8px !important;
        }

        /* Reduce font size */
        .dataTables_wrapper .dataTables_length,
        .dataTables_wrapper .dataTables_filter,
        .dataTables_wrapper .dataTables_info,
        .dataTables_wrapper .dataTables_paginate {
            font-size: 10px !important;
        }

        .dataTables_wrapper .dataTables_length select {
            font-size: 11px !important;
            height: 32px !important;
            line-height: 32px !important;
            min-width: 60px !important;
            width: 60px !important;
            padding: 0 18px 0 6px !important;
            margin-bottom: 8px !important;
            box-sizing: border-box !important;
        }
        /* Search box */
        .dataTables_wrapper .dataTables_filter input {
            width: 90px !important;
            height: 24px !important;
            font-size: 10px !important;
            margin-left: 4px !important;
        }

        /* Search label */
        .dataTables_wrapper .dataTables_filter label,
        .dataTables_wrapper .dataTables_length label {
            font-size: 10px !important;
            margin-bottom: 0 !important;
        }

        /* Pagination buttons */
        .dataTables_wrapper .paginate_button {
            font-size: 10px !important;
            padding: 2px 4px !important;
        }
    }
</style>

@if (session('success'))
<input type="hidden" name="session_data" id="session_data" class="session_data" value="{{ session('success') }}">
<script type="text/javascript">
    window.onload = function() {
        var message = $('#session_data').val();
        Swal.fire('Success!', message, 'success');
    }
</script>
@elseif(session('fail'))
<input type="hidden" name="session_data" id="session_data1" class="session_data" value="{{ session('fail') }}">
<script type="text/javascript">
    window.onload = function() {
        var message = $('#session_data1').val();
        Swal.fire('Info!', message, 'info');
    }
</script>
@endif

<div class="main-content">
    {{ Breadcrumbs::render('newenrollment.index') }}
    <div class="row">
        <div class="col-12">
            @if ($rows==[])
            @if(strpos($screen_permission['permissions'], 'Create') !== false)
            <a type="button" href="{{ route('newenrollment.create') }}" value="Cancel" class="btn btn-labeled btn-info" title="create" style="background: #044a95 !important; border-color:#a9ca !important; color:white !important;margin-top: 0.5rem;">
                <span class="btn-label" style="font-size:15px !important; padding:8px !important"><i class="fa fa-plus"></i></span><span style="font-size:15px !important; padding:8px !important">NewEnrollment</span></a>
            @endif
            @endif
            <div class="card">
                <div class="card-body">
                    <div class="col-lg-12 text-center mb-3">
                        <h4 style="color:darkblue;">Child Enrollment Details</h4>
                    </div>
                    <div class="table-wrapper">
                        <div class="table-responsive searchResultStudent">
                            <table class="table table-bordered" id="align">
                                <thead>
                                    <tr>
                                        <th>S.No</th>
                                        <th>Child Name</th>
                                        <th>Email Address</th>
                                        <th>Enrollment number</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($rows as $key=>$row)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $row['child_name']}}</td>
                                        <td>{{ $row['child_contact_email']}}</td>
                                        <td>{{ $row['enrollment_child_num']}}</td>
                                        @if($row['consent_aggrement'] == null)
                                        <td>Saved</td>
                                        @else
                                        <td>{{ $row['status']}}</td>
                                        @endif
                                        <td>
                                            @php
                                            $folderPath = $row['child_contact_email'];
                                            $consent = '/demo_document/'.$folderPath.'/Consent_form_'.$row['child_name'].'.pdf';
                                            @endphp
                                            @if(strpos($screen_permission['permissions'], 'Show') !== false)
                                            <a class="btn btn-link" title="Show" href="{{ route('newenrollment.show',\Crypt::encrypt($row['enrollment_id'])) }}"><i class="fas fa-eye" style="color:green"></i></a>
                                            @endif
                                            @if(strpos($screen_permission['permissions'], 'Edit') !== false)
                                            @if($row['consent_aggrement'] != [])
                                            <a class="btn btn-link" title="Edit" href="{{ route('newenrollment.edit',\Crypt::encrypt($row['enrollment_id'])) }}"><i class="fas fa-pencil-alt" style="color: blue !important"></i></a>
                                            @endif
                                            @endif
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-1.7.2.min.js"></script>
<script>
    function getproposaldocument(id) {
        var data = (id);
        $('#modalviewdiv').html('');
        $("#loading_gif").show();
        console.log(id);
        $("#loading_gif").hide();
        var proposaldocuments = "<div class='removeclass' id='modalviewdiv' style=' height:100%'><iframe src='" + data + "' class='document_ifarme_view' style='width:100%; height:100%'></iframe></div>";
        $('.removeclass').remove();
        var document = $('#template').append(proposaldocuments);
    };

    // Mobile Dynamic Collapsible Accordion Row View Click Handler
    $(document).ready(function() {
        $('#align tbody').on('click', 'tr', function(e) {
            // Do not trigger accordion if clicking inside actual links/buttons
            if ($(e.target).closest('a, button, input').length) {
                return;
            }
            if ($(window).width() <= 768) {
                $(this).toggleClass('expanded-row');
            }
        });
    });
</script>
@include('newenrollement.formmodal')
@endsection