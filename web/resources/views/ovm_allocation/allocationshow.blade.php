@extends('layouts.adminnav')
<script type="text/javascript" src="https://cdn.rawgit.com/t4t5/sweetalert/v0.2.0/lib/sweet-alert.min.js"></script>

@section('content')
<style>
    #frname {
        color: red;
    }

    .is-coordinate {
        justify-content: center;
    }

    .centerid {
        width: 100%;
        text-align: center;
    }

    .form-control {
        background-color: rgb(128 128 128 / 34%) !important;
    }

    /* Breadcrumb – keep on one line */
    .breadcrumb {
        display: flex !important;
        flex-wrap: nowrap !important;
        overflow-x: auto !important;
        white-space: nowrap !important;
        -webkit-overflow-scrolling: touch;
        padding: 8px 15px;
        margin-bottom: 10px;
    }
    .breadcrumb-item + .breadcrumb-item {
        padding-left: 0.5rem;
    }
    .breadcrumb-item + .breadcrumb-item::before {
        content: "/";
        padding-right: 0.5rem;
    }

    /* ==========================================
       MOBILE RESPONSIVE – FORM PAGES
       ========================================== */
    @media (max-width: 768px) {
        .main-content,
        .card,
        .card-body,
        .section-body {
            padding-left: 10px !important;
            padding-right: 10px !important;
        }

        .row {
            margin-left: 0 !important;
            margin-right: 0 !important;
        }

        [class*="col-"] {
            padding-left: 5px !important;
            padding-right: 5px !important;
            flex: 0 0 100% !important;
            max-width: 100% !important;
        }

        .form-group {
            margin-bottom: 15px !important;
        }

        .form-group label {
            display: block !important;
            width: 100% !important;
            text-align: left !important;
            margin-bottom: 5px !important;
            font-weight: 600 !important;
        }

        .form-control,
        .form-control[readonly] {
            width: 100% !important;
            height: 40px !important;
            font-size: 14px !important;
        }

        select.form-control {
            height: 40px !important;
        }

        /* BUTTON – inline and centered */
        .row.text-center .col-md-12 {
            display: flex !important;
            flex-wrap: wrap !important;
            justify-content: center !important;
            gap: 6px !important;
        }

        .row.text-center .col-md-12 .btn {
            width: auto !important;
            margin: 2px !important;
            padding: 6px 12px !important;
            font-size: 14px !important;
            white-space: nowrap !important;
        }

        h5 {
            font-size: 20px !important;
        }

        /* Textarea – adjust for mobile */
        textarea.form-control {
            height: auto !important;
            min-height: 80px !important;
            font-size: 14px !important;
        }
    }
</style>

<div class="main-content">

    <!-- Main Content -->
    <section class="section">

        {{ Breadcrumbs::render('coordinator.show', $rows[0]['id']) }}

        <div class="section-body mt-1">
            <div class="row">
                <div class="col-12">

                    <div class="card">
                        <div class="card-body">
                            <h5 class="text-center" style="color:darkblue">IS-Coordinator Allocation View</h5>

                            <form method="" action="">
                                @csrf

                                <div class="row is-coordinate pt-4">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="control-label">Enrollment ID</label>
                                            <input class="form-control" name="enrollment_id" value="{{ $rows[0]['enrollment_child_num']}}" placeholder="Enrollment ID" readonly>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="control-label">Child ID</label>
                                            <input class="form-control" type="text" id="child_id" name="child_id" value="{{$rows[0]['child_id']}}" disabled="" placeholder="OVM1 Meeting" required autocomplete="off">
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="control-label">Child Name</label>
                                            <input class="form-control" type="text" id="child_name" name="child_name" value="{{$rows[0]['child_name']}}" disabled="" placeholder="Enter Name" required autocomplete="off">
                                        </div>
                                    </div>

                                    <div class="col-md-5">
                                        <div class="form-group ">
                                            <label class="control-label">IS Co-ordinator-1</label>
                                            <input class="form-control" type="text" id="is_coordinator" name="is_coordinator" value="{{$rows[0]['is_coordinator1_name']}}" disabled="" required autocomplete="off">
                                        </div>
                                    </div>

                                    <div class="col-md-5">
                                        <div class="form-group ">
                                            <label class="control-label">IS Co-ordinator-2</label>
                                            <input class="form-control" type="text" id="is_coordinator" name="is_coordinator" value="{{$rows[0]['is_coordinator2_name']}}" disabled="" required autocomplete="off">
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="form-group ">
                                            <label class="control-label centerid">Status</label> <br>
                                            <input class="form-control" type="text" id="coordinator_status" name="coordinator_status" value="{{$rows[0]['meeting_status']}}" disabled="" placeholder="" required autocomplete="off">
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label class="control-label centerid">Allocated Date</label> <br>
                                            <?php
                                            $createdDate = $rows[0]['created_date'];
                                            $formattedDate = date('d-m-Y', strtotime($createdDate));
                                            ?>
                                            <input class="form-control" type="text" id="allocated_date" name="allocated_date" value="{{$formattedDate}}" disabled="" placeholder="" required autocomplete="off">
                                        </div>
                                    </div>

                                    @if($rows[0]['status']!= 1)
                                    <div class="col-lg-12" style="margin: 20px 0px 0px 0px;">
                                        <div class="form-group">
                                            <label class="form-label">Special Instruction (if Any)</label>
                                            <textarea class="form-control" id="description" name="description" readonly>{{ $rows[0]['comments']}}</textarea>
                                        </div>
                                    </div>
                                    @endif
                                </div>

                                <div class="row text-center">
                                    <div class="col-md-12">
                                        <a type="button" class="btn btn-labeled back-btn" title="Back" href="{{route('coordinator.list')}}" style="color:white !important">
                                            <span class="btn-label" style="font-size:13px !important;"><i class="fa fa-arrow-left"></i></span> Back</a>
                                    </div>
                                </div>
                            </form>
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

<!-- (All original scripts remain untouched; no changes were made to any JavaScript) -->

@endsection