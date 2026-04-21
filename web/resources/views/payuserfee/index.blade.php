@extends('layouts.parent')
@section('content')
<style>
    /* Space between DataTable buttons */
    .dt-buttons .btn {
        margin-right: 8px;
        /* space between buttons */
        margin-bottom: 5px;
        /* small vertical space (mobile safe) */
    }

    /* Space between "Show entries" and buttons */
    .dataTables_length {
        margin-bottom: 12px;
    }

    /* Align buttons nicely */
    .dt-buttons {
        margin-left: 10px;
    }

    /* Mobile Responsive Table styling */
    @media (max-width: 767px) {
        #tableList, 
        #tableList tbody, 
        #tableList tr, 
        #tableList td {
            display: block;
            width: 100%;
            box-sizing: border-box;
        }

        #tableList thead {
            display: none;
        }

        #tableList tbody tr {
            margin-bottom: 15px;
            border: 1px solid #ddd;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            background: #fff;
            padding: 10px;
        }

        #tableList tbody td {
            display: flex;
            justify-content: space-between;
            align-items: center;
            text-align: right !important;
            border-bottom: 1px solid #eee;
            padding: 10px 5px;
            word-break: break-word;
            white-space: normal;
        }

        #tableList tbody td:last-child {
            border-bottom: none;
            justify-content: space-between;
        }
        
        #tableList tbody td:last-child .btn, 
        #tableList tbody td:last-child a.btn {
            margin-left: 0;
            margin-right: 0;
        }
        
        #tableList tbody td::before {
            content: attr(data-label);
            font-weight: bold;
            display: block;
            flex-basis: 45%;
            text-align: left;
            margin-bottom: 0px;
            color: #333;
        }
        
        .dt-buttons .btn {
            padding: 4px 8px !important;
            font-size: 11px !important;
        }
        
        .btn {
            padding: 5px 10px !important;
            font-size: 11px !important;
        }

        div.dataTables_wrapper div.dataTables_length label,
        div.dataTables_wrapper div.dataTables_filter label,
        div.dataTables_wrapper div.dataTables_info,
        div.dataTables_wrapper div.dataTables_paginate {
            font-size: 12px !important;
        }

        div.dataTables_wrapper div.dataTables_length select,
        div.dataTables_wrapper div.dataTables_filter input {
            padding: 2px 5px !important;
            font-size: 12px !important;
            height: auto !important;
        }
        
        div.dataTables_wrapper div.dataTables_filter input {
            width: 120px !important;
        }
    }
</style>

<div class="main-content">
    @if (session('success'))
    <input type="hidden" name="session_data" id="session_data" class="session_data" value="{{ session('success') }}">
    <script type="text/javascript">
        window.onload = function() {
            var message = $('#session_data').val();
            swal.fire("Success", message, "success");
        }
    </script>
    @elseif(session('fail'))
    <input type="hidden" name="session_data" id="session_data1" class="session_data" value="{{ session('fail') }}">
    <script type="text/javascript">
        window.onload = function() {
            var message = $('#session_data1').val();
            swal.fire("Info", message, "info");
        }
    </script>
    @endif
    <style>
        #tableList th,
        #tableList td {
            text-align: center;
            vertical-align: middle;
        }
    </style>

    {{ Breadcrumbs::render('payuserfee.index') }}
    <h5 class="text-center" style="color:darkblue">Payment Detail for {{ $rows[0]['child_name']}} ({{ $rows[0]['enrollment_child_num']}})</h5>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="table-wrapper">
                        <div class="table-responsive">
                            <table id="tableList" class="table table-striped" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>Payment For</th>
                                        <th>Transaction ID</th>
                                        <th>Receipt Num</th>
                                        <th>Status</th>
                                        <th style="table-layout: auto;">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($rows as $key=>$row)
                                    <tr>
                                        <td data-label="Payment For">{{ $row['payment_for']}}</td>
                                        <td data-label="Transaction ID">{{ $row['transaction_id']}}</td>
                                        <td data-label="Receipt Num">{{ $row['receipt_num']}}</td>
                                        <td data-label="Status">{{ $row['payment_status']}}</td>
                                        <td data-label="Action">

                                            @if($row['payment_status'] == 'SUCCESS' || $row['payment_status'] == 'REFUND SUCCESS')
                                            <a class="btn btn-link" title="show" href="{{ route('payuserfee.show',\Crypt::encrypt($row['payment_status_id'])) }}"><i class="fas fa-eye" style="color:green"></i></a>
                                            @if(in_array($row['payment_status_id'], $payment_id))
                                            <a class="btn btn-link" title="Refund Details" href="#addModal" data-toggle="modal" data-target="#addModal"><i style="transform:scaleY(-1) rotate(152deg);color:green" class="fas fa-repeat"></i></a>
                                            @endif
                                            @endif
                                            @if($row['payment_status'] == 'New' && $row['payment_status'] != 'NEW')
                                            @if($row['payment_type'] == 0)
                                            <a class="btn btn-success" title="Pay" type="button" href="{{ route('payuserfee.create')}}">Pay Here</a>
                                            @else
                                            <a class="btn btn-success" title="Payment Pending" type="button" href="{{ route('payment.payment_details',\Crypt::encrypt($row['payment_status_id'])) }}">Payment Pending</a>
                                            @endif
                                            <!-- <a class="btn btn-success" title="Pay" type="button" href="{{ route('payuserfee.create')}}">Pay Here</a> -->
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
@if(in_array($row['payment_status_id'], $payment_id))


<div class="modal fade" id="addModal">
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
                                                    <input class="form-control" type="text" value="{{ $row['enrollment_child_num']}}" disabled>
                                                </div>
                                                <div class='col-md-4'>
                                                    <label class="control-label" for="child_name" style="font-weight:bold">Child Name</label><span class="error-star" style="color:red;">*</span>
                                                    <input class="form-control" type="text" value="{{ $row['child_name']}}" disabled>
                                                </div>
                                                <div class='col-md-4'>
                                                    <label class="control-label" for="payment_for" style="font-weight:bold">Payment For</label><span class="error-star" style="color:red;">*</span>
                                                    <input class="form-control" type="text" value="{{$row['payment_for']}}" disabled>
                                                </div>
                                                <div class='col-md-4 mt-3'>
                                                    <label class="control-label" for="receipt_num" style="font-weight:bold">Receipt number</label><span class="error-star" style="color:red;">*</span>
                                                    <input class="form-control" class="form-control" type="text" value="{{$refund_details[0][0]->cf_payment_id}}" disabled>
                                                </div>
                                                <div class='col-md-4 mt-3'>
                                                    <label class="control-label" for="refund_num" style="font-weight:bold">Refund number</label><span class="error-star" style="color:red;">*</span>
                                                    <input class="form-control" type="text" value="{{$refund_details[0][0]->cf_refund_id}}" disabled>
                                                </div>
                                                <div class='col-md-4 mt-3'>
                                                    <label class="control-label" for="refund_amount" style="font-weight:bold">Refund amount</label><span class="error-star" style="color:red;">*</span>
                                                    <input class="form-control" type="text" value="{{$refund_details[0][0]->refund_amount}}" disabled>
                                                </div>
                                                <div class='col-md-4 mt-3'>
                                                    <label class="control-label" for="rund_status" style="font-weight:bold">Refund status</label><span class="error-star" style="color:red;">*</span>
                                                    <input class="form-control" type="text" value="{{$refund_details[0][0]->refund_status}}" disabled>
                                                </div>
                                                <div class='col-md-4 mt-3'>
                                                    <label class="control-label" for="description" style="font-weight:bold">Status description</label><span class="error-star" style="color:red;">*</span>
                                                    <input class="form-control" type="text" value="{{$refund_details[0][0]->status_description}}" disabled>
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
@endsection