@extends('layouts.adminnav')

@section('content')
<style>
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

        #align1 thead {
            display: none !important;
        }

        #align1,
        #align1 tbody,
        #align1 tr,
        #align1 td {
            display: block !important;
            width: 100% !important;
        }

        #align1 tbody {
            background: transparent !important;
        }

        #align1 tr {
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

        #align1 td {
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
        #align1 td:nth-of-type(1) {
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

        #align1 tr.expanded-row td:nth-of-type(1) {
            top: 20px !important;
            transform: translateY(0) !important;
        }

        /* Enrollment ID – primary field (2nd column) */
        #align1 td:nth-of-type(2) {
            display: block !important;
            font-weight: 600 !important;
            font-size: 16px !important;
            color: #2c3e50 !important;
            margin-bottom: 4px !important;
            padding-right: 25px !important;
            order: 1 !important;
        }

        /* IS-Coordinator's – hidden initially (3rd column) */
        #align1 td:nth-of-type(3) {
            display: none !important;
        }

        /* Allocation Date – hidden initially (4th column) */
        #align1 td:nth-of-type(4) {
            display: none !important;
        }

        /* Status – hidden initially (5th column) */
        #align1 td:nth-of-type(5) {
            display: none !important;
        }

        /* Action – hidden initially (6th column) */
        #align1 td:nth-of-type(6) {
            display: none !important;
        }

        /* Arrow indicator */
        #align1 tr::after {
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

        #align1 tr.expanded-row::after {
            transform: translateY(-50%) rotate(90deg);
            top: 35px;
        }

        /* Expanded fields */
        #align1 tr.expanded-row td:nth-of-type(3) { /* IS-Coordinator's */
            display: block !important;
            margin-top: 8px !important;
            font-size: 12px !important;
            color: #34495e !important;
            order: 2 !important;
        }
        #align1 tr.expanded-row td:nth-of-type(3):before {
            content: "IS-Coordinator's: ";
            font-weight: 600 !important;
            color: #000 !important;
        }

        #align1 tr.expanded-row td:nth-of-type(4) { /* Allocation Date */
            display: block !important;
            margin-top: 6px !important;
            font-size: 12px !important;
            color: #34495e !important;
            order: 3 !important;
        }
        #align1 tr.expanded-row td:nth-of-type(4):before {
            content: "Allocation Date: ";
            font-weight: 600 !important;
            color: #000 !important;
        }

        #align1 tr.expanded-row td:nth-of-type(5) { /* Status */
            display: block !important;
            margin-top: 6px !important;
            font-size: 12px !important;
            color: #34495e !important;
            order: 4 !important;
        }
        #align1 tr.expanded-row td:nth-of-type(5):before {
            content: "Status: ";
            font-weight: 600 !important;
            color: #000 !important;
        }

        #align1 tr.expanded-row td:nth-of-type(6) { /* Action */
            display: flex !important;
            align-items: center !important;
            flex-wrap: wrap !important;
            gap: 4px !important;
            margin-top: 6px !important;
            order: 5 !important;
        }
        #align1 tr.expanded-row td:nth-of-type(6):before {
            content: "Action:";
            font-weight: 600 !important;
            color: #000 !important;
            margin-right: 6px !important;
            flex-shrink: 0 !important;
        }

        /* Action buttons – inline, small, touch-friendly */
        #align1 tr.expanded-row td:nth-of-type(6) .btn {
            font-size: 11px !important;
            padding: 4px 8px !important;
            margin: 0 !important;
            display: inline-flex !important;
            align-items: center !important;
        }

        #align1 tr.expanded-row td:nth-of-type(6) .btn i {
            font-size: 12px !important;
        }

        /* No records message */
        #align1 td.dataTables_empty {
            display: table-cell !important;
            width: 100% !important;
            text-align: center !important;
            white-space: nowrap !important;
            padding: 15px !important;
            font-size: 13px !important;
            font-weight: 600 !important;
            color: #666 !important;
        }

        #align1 tr:has(td.dataTables_empty) {
            display: table-row !important;
            border: none !important;
            box-shadow: none !important;
            padding: 0 !important;
            background: transparent !important;
        }

        #align1 tr:has(td.dataTables_empty)::after {
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

        .card-body h5 {
            font-size: 18px !important;
        }
    }
</style>

<div class="main-content">
    @if (session('success'))

    <input type="hidden" name="session_data" id="session_data" class="session_data" value="{{ session('success') }}">

    <script type="text/javascript">
        window.onload = function() {
            var message = '<?php echo session('success'); ?>';
            // alert(message);exit;
            Swal.fire({
                title: "Success",
                text: message,
                icon: 'success',
                type: "success",
            });
        }
    </script>
    @elseif(session('fail'))
    <input type="hidden" name="session_data" id="session_data1" class="session_data" value="{{ session('fail') }}">
    <script type="text/javascript">
        window.onload = function() {
            var message = $('#session_data1').val();
            Swal.fire({
                title: "Success",
                text: "message",
                type: "success",
            });
        }
    </script>
    @endif


    {{ Breadcrumbs::render('coordinator.list') }}

    <div class="row">
        <div class="col-12">
            <!-- <a type="button" style="font-size:15px;" class="btn btn-success btn-lg" title="Create" id="gcb" href="{{ route('newenrollment.create') }}">NewEnrollment<i class="fa fa-plus" aria-hidden="true"></i></a> -->
            <div class="card">
                <div class="card-body">
                    <h5 class="text-center" style="color:darkblue">IS-Coordinator's Allocation List </h5>

                    <div class="table-wrapper">
                        <div class="table-responsive">
                            <table class="table table-bordered" id="align1">
                                <thead>
                                    <tr>
                                        <th class="col-1">Sl.No</th>
                                        <th class="col-2">Enrollment ID(Child Name) </th>
                                        <th class="col-3">IS-Coordinator's</th>
                                        <th>Allocation Date</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($rows['rows'] as $data)
                                    <tr>
                                        <td data-label="Sl.No">{{ $loop->iteration }}</td>
                                        <td data-label="Enrollment ID(Child Name)">{{ $data['enrollment_child_num'] }} ({{ $data['child_name'] }})</td>
                                        <td data-label="IS-Coordinator's">
                                            {{ $data['is_coordinator1_name'] }}(1),<br>
                                            {{ $data['is_coordinator2_name'] }}(2)
                                        </td>
                                        <td data-label="Allocation Date">{{ date('d-m-Y', strtotime($data['created_date'])) }}</td>
                                        <td data-label="Status">
                                            @if($data['status'] == 1)
                                            <p>Allocated</p>
                                            @elseif($data['status'] == 2)
                                            <p>Reallocated</p>
                                            @elseif($data['status'] == 3)
                                            <p>Cancelled</p>
                                            @endif
                                        </td>
                                        <td data-label="Action">
                                            @if($data['status'] == 1)
                                            <a class="btn btn-link"
                                                title="Reallocation"
                                                href="{{ route('coordinator.edit', Crypt::encrypt($data['id'])) }}"
                                                style="background-color: orange;color:white;text-decoration: none; padding: 4px 8px; border-radius: 4px;">
                                                Reallocation
                                            </a>
                                            @endif

                                            @if($data['status'] != 3)
                                            @php
                                            $encryptedId = Crypt::encrypt($data['id']);
                                            @endphp
                                            <a class="btn btn-link"
                                                title="Cancel"
                                                onclick="validateAndAllocate('Cancel', '{{$encryptedId}}', '{{$data['child_name']}}')"
                                                style="background-color:red;color:white;text-decoration: none; padding: 4px 8px; border-radius: 4px;">
                                                Cancellation
                                            </a>
                                            @endif

                                            <a class="btn btn-link"
                                                title="View"
                                                href="{{ route('coordinator.show', Crypt::encrypt($data['id'])) }}">
                                                <i class="fas fa-eye" style="color:blue"></i>
                                            </a>
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

<script>
    function showSuccessAlert() {
        Swal.fire({
            title: "Success",
            text: "IS-Coordinator Allocation Cancelled Successfully",
            icon: "success",
        });
    }

    function validateAndAllocate(allocationType, id, childName) {
        if (allocationType == "Cancel") {
            Swal.fire({
                title: `Do you want to Cancel the IS-Coordinator Allocation for the child of ${childName}?`,
                text: "Please click 'Yes' to Cancel the Allocation",
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
                    const cancelUrl = `\/coordinator/cancellation/${id}`;
                    setTimeout(() => {
                        window.location.href = cancelUrl;
                    }, 1000);
                }
            });
        }
    }

    // Toggle expand/collapse on mobile (same as other indices)
    $(document).ready(function() {
        $('#align1 tbody').on('click', 'tr', function(e) {
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
@endsection