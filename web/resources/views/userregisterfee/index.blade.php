@extends('layouts.adminnav')
@section('content')

<style>
    /* ==========================================
       MOBILE RESPONSIVE – CARD STYLE
       ========================================== */
    @media (max-width: 768px) {
        .main-content,
        .card,
        .card-body,
        .table-wrapper,
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

        .main-content {
            padding-top: 0 !important;
        }

        .breadcrumb {
            display: flex !important;
            flex-wrap: nowrap !important;
            overflow-x: auto !important;
            white-space: nowrap !important;
            -webkit-overflow-scrolling: touch;
            font-size: 11px !important;
            margin-bottom: 10px !important;
            margin-top: 60px !important;
            margin-left: 10px !important;
        }

        .card {
            margin-top: 0 !important;
        }

        .table-responsive {
            overflow-x: hidden !important;
            overflow-y: visible !important;
            max-height: none !important;
        }

        .table-responsive table {
            font-size: 12px;
            min-width: 100% !important;
            width: 100% !important;
        }

        #align thead {
            display: none !important;
        }

        #align,
        #align tbody,
        #align tr,
        #align td {
            display: block !important;
            width: 100% !important;
        }

        #align tbody {
            background: transparent !important;
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

        /* Sl. No. – floating badge */
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

        /* Child Name – primary field (2nd column) */
        #align td:nth-of-type(2) {
            display: block !important;
            font-weight: 600 !important;
            font-size: 16px !important;
            color: #2c3e50 !important;
            margin-bottom: 4px !important;
            padding-right: 25px !important;
            order: 1 !important;
        }

        /* Reference id – hidden initially (3rd column) */
        #align td:nth-of-type(3) {
            display: none !important;
        }

        /* Payment For – hidden initially (4th column) */
        #align td:nth-of-type(4) {
            display: none !important;
        }

        /* Payment Date – hidden initially (5th column) */
        #align td:nth-of-type(5) {
            display: none !important;
        }

        /* Mode of Payment – hidden initially (6th column) */
        #align td:nth-of-type(6) {
            display: none !important;
        }

        /* Status – hidden initially (7th column) */
        #align td:nth-of-type(7) {
            display: none !important;
        }

        /* Action – hidden initially (8th column) */
        #align td:nth-of-type(8) {
            display: none !important;
        }

        /* Arrow indicator */
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

        /* Expanded fields */
        #align tr.expanded-row td:nth-of-type(3) { /* Reference id */
            display: block !important;
            margin-top: 8px !important;
            font-size: 12px !important;
            color: #34495e !important;
            order: 2 !important;
        }
        #align tr.expanded-row td:nth-of-type(3):before {
            content: "Reference ID: ";
            font-weight: 600 !important;
            color: #000 !important;
        }

        #align tr.expanded-row td:nth-of-type(4) { /* Payment For */
            display: block !important;
            margin-top: 6px !important;
            font-size: 12px !important;
            color: #34495e !important;
            order: 3 !important;
        }
        #align tr.expanded-row td:nth-of-type(4):before {
            content: "Payment For: ";
            font-weight: 600 !important;
            color: #000 !important;
        }

        #align tr.expanded-row td:nth-of-type(5) { /* Payment Date */
            display: block !important;
            margin-top: 6px !important;
            font-size: 12px !important;
            color: #34495e !important;
            order: 4 !important;
        }
        #align tr.expanded-row td:nth-of-type(5):before {
            content: "Payment Date: ";
            font-weight: 600 !important;
            color: #000 !important;
        }

        #align tr.expanded-row td:nth-of-type(6) { /* Mode of Payment */
            display: block !important;
            margin-top: 6px !important;
            font-size: 12px !important;
            color: #34495e !important;
            order: 5 !important;
        }
        #align tr.expanded-row td:nth-of-type(6):before {
            content: "Mode: ";
            font-weight: 600 !important;
            color: #000 !important;
        }

        #align tr.expanded-row td:nth-of-type(7) { /* Status */
            display: block !important;
            margin-top: 6px !important;
            font-size: 12px !important;
            color: #34495e !important;
            order: 6 !important;
        }
        #align tr.expanded-row td:nth-of-type(7):before {
            content: "Status: ";
            font-weight: 600 !important;
            color: #000 !important;
        }

        #align tr.expanded-row td:nth-of-type(8) { /* Action */
            display: flex !important;
            align-items: center !important;
            flex-wrap: wrap !important;
            gap: 4px !important;
            margin-top: 6px !important;
            order: 7 !important;
        }
        #align tr.expanded-row td:nth-of-type(8):before {
            content: "Action:";
            font-weight: 600 !important;
            color: #000 !important;
            margin-right: 6px !important;
            flex-shrink: 0 !important;
        }

        /* Action buttons – inline, small, touch-friendly */
        #align tr.expanded-row td:nth-of-type(8) .btn {
            font-size: 11px !important;
            padding: 4px 8px !important;
            margin: 0 !important;
        }

        /* No records message */
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

        /* DataTable controls (if any) */
        .dataTables_wrapper .row:first-child {
            margin: 0 !important;
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
    }

    /* ==========================================
       TABLET-ONLY (769px - 1024px) – full visibility with scrolling
       ========================================== */
    @media (min-width: 769px) and (max-width: 1024px) {
        /* Allow the table to expand horizontally if needed */
        .table-responsive {
            overflow-x: auto !important;
            -webkit-overflow-scrolling: touch !important;
        }

        #align {
            table-layout: auto !important;     /* let columns size themselves */
            width: 100% !important;
            min-width: 100% !important;
        }

        /* All headers and cells – wrap at spaces, never break words */
        #align th,
        #align td {
            white-space: normal !important;
            word-break: normal !important;        /* break only at spaces */
            overflow-wrap: break-word !important;
            hyphens: none !important;
        }

        /* Protect single‑word values (like SUCCESS) from breaking */
        #align td:nth-child(7) {
            word-break: keep-all !important;
        }

        /* Give extra breathing room to key columns */
        #align th:nth-child(2),
        #align td:nth-child(2) {
            min-width: 120px !important;
        }
        #align th:nth-child(3),
        #align td:nth-child(3) {
            min-width: 130px !important;
        }
        #align th:nth-child(4),
        #align td:nth-child(4) {
            min-width: 130px !important;
        }

        /* Action buttons – keep them compact */
        #align td:nth-child(8) .btn {
            font-size: 11px !important;
            padding: 2px 4px !important;
            margin: 0 1px !important;
        }
    }

    /* Breadcrumb – keep on one line (desktop fallback) */
    .breadcrumb {
        display: flex !important;
        flex-wrap: nowrap !important;
        overflow-x: auto !important;
        white-space: nowrap !important;
        -webkit-overflow-scrolling: touch;
        padding: 8px 15px;
    }
    .breadcrumb-item + .breadcrumb-item {
        padding-left: 0.5rem;
    }
    .breadcrumb-item + .breadcrumb-item::before {
        content: "/";
        padding-right: 0.5rem;
    }
</style>

<div class="main-content">
    @if (session('success'))
    <input type="hidden" name="session_data" id="session_data" class="session_data" value="{{ session('success') }}">
    <script type="text/javascript">
        window.onload = function() {
            var message = $('#session_data').val();
            Swal.fire({
                title: "Success",
                text: message,
                icon: "success",
            });
        }
    </script>
    @elseif(session('fail'))
    <input type="hidden" name="session_data" id="session_data1" class="session_data" value="{{ session('fail') }}">
    <script type="text/javascript">
        window.onload = function() {
            var message = $('#session_data1').val();
            Swal.fire({
                title: "Info",
                text: message,
                icon: "info",
            });
        }
    </script>
    @endif

    {{ Breadcrumbs::render('userregisterfee.index') }}

    <div class="row">
        <div class="col-12">
            <a type="button" style="display:none;font-size:15px; padding: 8px; background-color: green;" class="btn btn-success btn-lg mb-2" title="Create" id="gcb" href="{{ route('userregisterfee.create') }}">Payment Initiation</a>
            <div class="card-body">
                <div class="col-lg-12 text-center">
                    <h5 class="text-center" style="color:darkblue">Payment Status List</h5>
                </div>
                <div class="table-wrapper">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="align">
                            <thead>
                                <tr>
                                    <th class='col-1'>SI.No</th>
                                    <th class='col-2'>Child Name</th>
                                    <th>Reference id</th>
                                    <th>Payment For</th>
                                    <th>Payment Date</th>
                                    <th>Mode of Payment</th>
                                    <th width="80px">Status</th>
                                    <th width="150px">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($rows as $key=>$row)
                                <tr>
                                    <td data-label="SI.No">{{ $loop->iteration }}</td>
                                    <td data-label="Child Name">{{ $row['child_name']}}</td>
                                    <td data-label="Reference ID">{{ $row['reference_id']}}</td>
                                    <td data-label="Payment For">{{$row['payment_for']}}</td>
                                    <td data-label="Payment Date">{{ $row['payment_date']}}</td>
                                    @if($row['payment_type'] == 1)
                                    <td data-label="Mode">Offline</td>
                                    @else
                                    <td data-label="Mode">{{ ($row['payment_status'] == 'New' && $row['payment_type'] == 0) ? 'New' : 'Online' }}</td>
                                    @endif

                                    <td data-label="Status">{{ ($row['payment_status'] == 'New' && $row['payment_type'] == 1) ? 'Pending' : $row['payment_status'] }}</td>

                                    <td data-label="Action">
                                        @php
                                        $folder = $row['initiated_to'];
                                        $consent = $row['payment_for'] == 'User Register Fee'? "/invoice_document/{$folder}/Registration_invoice_receipt.pdf": "/sail_invoice_document/{$folder}/PAYMENT_INVOICE_RECEIPT.pdf";
                                        $receipt = $row['payment_for'] == 'User Register Fee'? "/receipt_document/{$folder}/registration_receipt.pdf": "/sail_receipt_document/{$folder}/registration_receipt.pdf";
                                        @endphp

                                        <a class="btn btn-primary btn-sm" title="View Document" data-toggle="modal" data-target="#templates" onclick="getproposaldocument('{{$row['transaction_id'] ? $receipt : $consent}}')" style="margin-inline:5px;cursor:pointer"><i class="fa fa-download" style="color:white!important"></i></a>

                                        <a class="btn btn-link btn-sm" title="show" href="{{ route('userregisterfee.show',\Crypt::encrypt($row['payment_status_id'])) }}"><i class="fas fa-eye" style="color:green"></i></a>
                                        @if(in_array($row['payment_status_id'], $payment_id))
                                        <!-- <a class="btn btn-link" title="Refund Details" href="#addModal{{$row['payment_status_id']}}" data-toggle="modal" data-target="#addModal{{$row['payment_status_id']}}"><i style="transform:scaleY(-1) rotate(152deg);color:green" class="fas fa-repeat"></i></a> -->
                                        @endif
                                        @if($row['payment_status'] != 'SUCCESS' && $row['payment_type'] == 1)
                                        <a class="btn btn-link btn-sm" title="Offline Payment" href="{{ route('userregisterfee.offline_payment',\Crypt::encrypt($row['payment_status_id'])) }}"><i class="fa fa-money" style="color:green"></i></a>
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

    @foreach($rows as $details)
    @if(in_array($details['payment_status_id'], $payment_id))

    <div class="modal fade" id="addModal{{$details['payment_status_id']}}">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="main-contents">
                    <section class="section">
                        <div class="modal-header bg-primary px-4 py-3 d-flex flex-row justify-content-between align-items-center" style=" background-color: rgb(0 103 172) !important;">
                            <h4 class="modal-title position-static">
                                Refund Details
                            </h4>
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        </div>
                        <div class="modal-body" style="background-color: #edfcff !important;">
                            <div class="section-body mt-2">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="mt-0 ">
                                            <div class="card-body" id="card_header">
                                                <div class="row">
                                                    <div class='col-md-4'>
                                                        <label class="control-label" for="enrollment_id" style="font-weight:bold">Enrollment ID</label><span class="error-star" style="color:red;">*</span>
                                                        <input class="form-control" type="text" value="{{ $details['enrollment_child_num']}}" disabled>
                                                    </div>
                                                    <div class='col-md-4'>
                                                        <label class="control-label" for="child_name" style="font-weight:bold">Child Name</label><span class="error-star" style="color:red;">*</span>
                                                        <input class="form-control" type="text" value="{{ $details['child_name']}}" disabled>
                                                    </div>
                                                    <div class='col-md-4'>
                                                        <label class="control-label" for="payment_for" style="font-weight:bold">Payment For</label><span class="error-star" style="color:red;">*</span>
                                                        <input class="form-control" type="text" value="{{$details['payment_for']}}" disabled>
                                                    </div>
                                                    <div class='col-md-4 mt-3'>
                                                        <label class="control-label" for="receipt_num" style="font-weight:bold">Receipt number</label><span class="error-star" style="color:red;">*</span>
                                                        <input class="form-control" class="form-control" type="text" value="{{$refund_details[$details['payment_status_id']][0]->cf_payment_id}}" disabled>
                                                    </div>
                                                    <div class='col-md-4 mt-3'>
                                                        <label class="control-label" for="refund_num" style="font-weight:bold">Refund number</label><span class="error-star" style="color:red;">*</span>
                                                        <input class="form-control" type="text" value="{{$refund_details[$details['payment_status_id']][0]->cf_refund_id}}" disabled>
                                                    </div>
                                                    <div class='col-md-4 mt-3'>
                                                        <label class="control-label" for="refund_amount" style="font-weight:bold">Refund amount</label><span class="error-star" style="color:red;">*</span>
                                                        <input class="form-control" type="text" value="{{$refund_details[$details['payment_status_id']][0]->refund_amount}}" disabled>
                                                    </div>
                                                    <div class='col-md-4 mt-3'>
                                                        <label class="control-label" for="rund_status" style="font-weight:bold">Refund status</label><span class="error-star" style="color:red;">*</span>
                                                        <input class="form-control" type="text" value="{{$refund_details[$details['payment_status_id']][0]->refund_status}}" disabled>
                                                    </div>
                                                    <div class='col-md-4 mt-3'>
                                                        <label class="control-label" for="description" style="font-weight:bold">Status description</label><span class="error-star" style="color:red;">*</span>
                                                        <input class="form-control" type="text" value="{{$refund_details[$details['payment_status_id']][0]->status_description}}" disabled>
                                                    </div>
                                                </div>
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
    @endif
    @endforeach
</div>

<script src="https://code.jquery.com/jquery-1.7.2.min.js"></script>
<script type="application/javascript">
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

    // Toggle expand/collapse on mobile (same as other indices)
    $(document).ready(function() {
        $('#align tbody').on('click', 'tr', function(e) {
            // Ignore clicks inside action buttons/links
            if ($(e.target).closest('a, button, input, .btn').length) {
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