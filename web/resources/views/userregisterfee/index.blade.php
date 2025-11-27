@extends('layouts.adminnav')
@section('content')

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
                                    <th>S.No</th>
                                    <!-- <th>Enrollment ID</th> -->
                                    <th>Child Name</th>
                                    <th>Reference id</th>
                                    <th>Payment For</th>
                                    <!-- <th>Transaction ID</th> -->
                                    <!-- <th>Receipt Num</th> -->
                                    <th>Payment Date</th>
                                    <th>Mode of Payment</th>
                                    <th width="80px">Status</th>
                                    <th width="150px">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                
                                @foreach($rows as $key=>$row)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <!-- <td>{{ $row['enrollment_child_num']}}</td> -->
                                    <td>{{ $row['child_name']}}</td>
                                    <td>{{ $row['reference_id']}}</td>
                                    <td>{{$row['payment_for']}}</td>
                                    <!-- <td>{{ $row['transaction_id']}}</td> -->
                                    <!-- <td>{{ $row['receipt_num']}}</td> -->
                                    <td>{{ $row['payment_date']}}</td>
                                    @if($row['payment_type'] == 1)
                                    <td>Offline</td>
                                    @else
                                    <td>{{ ($row['payment_status'] == 'New' && $row['payment_type'] == 0) ? 'New' : 'Online' }}</td>
                                    @endif

                                    <td>{{ ($row['payment_status'] == 'New' && $row['payment_type'] == 1) ? 'Pending' : $row['payment_status'] }}</td>

                                    <td>
                                        @php
                                        $folder = $row['initiated_to'];
                                        $consent = $row['payment_for'] == 'User Register Fee'? "/invoice_document/{$folder}/Registration_invoice_receipt.pdf": "/sail_invoice_document/{$folder}/PAYMENT_INVOICE_RECEIPT.pdf";
                                        $receipt = $row['payment_for'] == 'User Register Fee'? "/receipt_document/{$folder}/registration_receipt.pdf": "/sail_receipt_document/{$folder}/registration_receipt.pdf";
                                        @endphp


                                        <a class="btn btn-primary" title="View Document" data-toggle="modal" data-target="#templates" onclick="getproposaldocument('{{$row['transaction_id'] ? $receipt : $consent}}')" style="margin-inline:5px;cursor:pointer"><i class="fa fa-download" style="color:white!important"></i></a>

                                        <a class="btn btn-link" title="show" href="{{ route('userregisterfee.show',\Crypt::encrypt($row['payment_status_id'])) }}"><i class="fas fa-eye" style="color:green"></i></a>
                                        @if(in_array($row['payment_status_id'], $payment_id))
                                        <!-- <a class="btn btn-link" title="Refund Details" href="#addModal{{$row['payment_status_id']}}" data-toggle="modal" data-target="#addModal{{$row['payment_status_id']}}"><i style="transform:scaleY(-1) rotate(152deg);color:green" class="fas fa-repeat"></i></a> -->
                                        @endif
                                        @if($row['payment_status'] != 'SUCCESS' && $row['payment_type'] == 1)
                                        <a class="btn btn-link" title="Offline Payment" href="{{ route('userregisterfee.offline_payment',\Crypt::encrypt($row['payment_status_id'])) }}"><i class="fa fa-money" style="color:green"></i></a>
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
</script>


@include('newenrollement.formmodal')

@endsection