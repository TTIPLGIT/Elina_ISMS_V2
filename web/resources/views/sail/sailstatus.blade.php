@extends('layouts.adminnav')

@section('content')
<style>
/* =========================================================================
   MOBILE RESPONSIVE STYLING - SAME AS ENROLLMENT LIST / OVM1 PAGE
   ========================================================================= */

.table-responsive {
    overflow-x: auto;
    -webkit-overflow-scrolling: touch;
}

@media (max-width: 768px) {

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

    /* Sl. No. - absolute positioned left */
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

    /* Child Name (always visible) */
    #align td:nth-of-type(2) {
        display: block !important;
        font-weight: 600 !important;
        font-size: 16px !important;
        color: #2c3e50 !important;
        margin-bottom: 4px !important;
        padding-right: 25px !important;
        order: 1 !important;
    }

    /* Status - always visible (replaces Enrollment Number on card) */
    #align td:nth-of-type(5) {
        display: block !important;
        font-size: 13px !important;
        color: #34495e !important;
        margin-bottom: 10px !important;
        order: 2 !important;
    }

    #align td:nth-of-type(5):before {
        content: "Status: ";
        font-weight: 600 !important;
        color: #000 !important;
    }

    /* Hidden fields initially (Enrollment, Coordinator, Action) */
    #align td:nth-of-type(3),
    #align td:nth-of-type(4),
    #align td:nth-of-type(6) {
        display: none !important;
    }

    /* Arrow indicator for expand */
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

    /* Enrollment Number (expanded) */
    #align tr.expanded-row td:nth-of-type(3) {
        display: block !important;
        margin-top: 8px !important;
        font-size: 12px !important;
        color: #34495e !important;
        order: 3 !important;
    }

    #align tr.expanded-row td:nth-of-type(3):before {
        content: "Enrollment: ";
        font-weight: 600 !important;
        color: #000 !important;
    }

    /* Coordinator (expanded) */
    #align tr.expanded-row td:nth-of-type(4) {
        display: block !important;
        margin-top: 6px !important;
        font-size: 12px !important;
        color: #34495e !important;
        order: 4 !important;
    }

    #align tr.expanded-row td:nth-of-type(4):before {
        content: "Coordinator: ";
        font-weight: 600 !important;
        color: #000 !important;
    }

    /* Action Row (expanded) - inline flex */
    #align tr.expanded-row td:nth-of-type(6) {
        display: flex !important;
        align-items: center !important;
        flex-wrap: nowrap !important;
        gap: 6px !important;
        margin-top: 12px !important;
        order: 5 !important;
        white-space: nowrap !important;
    }

    #align tr.expanded-row td:nth-of-type(6):before {
        content: "Action:";
        font-weight: 600 !important;
        color: #000 !important;
        margin-right: 6px !important;
        flex-shrink: 0 !important;
    }

    #align tr.expanded-row td:nth-of-type(6) a {
        display: inline-flex !important;
        align-items: center !important;
        justify-content: center !important;
        margin-right: 0 !important;
        padding: 2px !important;
        font-size: 14px !important;
    }

    /* No records row */
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

    /* DataTable controls if any */
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

    .card-body h4 {
        font-size: 18px !important;
    }
}

/* ==========================================
   SAIL Activity Modal - Mobile Responsive
   ========================================== */

@media (max-width: 768px) {

    .modal-dialog.modal-xl {
        max-width: 95% !important;
        margin: 10px auto !important;
    }

    .modal-body {
        padding: 10px !important;
    }

    .modal-body .table-responsive {
        overflow-x: hidden !important;
    }

    /* Hide table header in modal on mobile */
    .modal-body table thead {
        display: none !important;
    }

    .modal-body table,
    .modal-body tbody,
    .modal-body tr,
    .modal-body td {
        display: block !important;
        width: 100% !important;
    }

    /* Card design for audit log */
    .modal-body tbody tr {
        border: 1px solid #dcdcdc !important;
        border-radius: 10px !important;
        background: #fff !important;
        padding: 12px !important;
        margin-bottom: 12px !important;
        box-shadow: 0 2px 5px rgba(0,0,0,0.08) !important;
        position: relative;
    }

    .modal-body tbody td {
        border: none !important;
        padding: 3px 0 !important;
        text-align: left !important;
        font-size: 13px !important;
        line-height: 1.4 !important;
    }

    /* Labels for audit fields */
    .modal-body tbody td:nth-child(1):before {
        content: "Sl No : ";
        font-weight: 600;
        color: #000;
    }

    .modal-body tbody td:nth-child(2):before {
        content: "Enrollment : ";
        font-weight: 600;
        color: #000;
    }

    .modal-body tbody td:nth-child(3):before {
        content: "Child Name : ";
        font-weight: 600;
        color: #000;
    }

    .modal-body tbody td:nth-child(4):before {
        content: "Status : ";
        font-weight: 600;
        color: #000;
    }

    .modal-body tbody td:nth-child(5):before {
        content: "Date : ";
        font-weight: 600;
        color: #000;
    }

    .modal-body tbody td:nth-child(6):before {
        content: "Last Actioned : ";
        font-weight: 600;
        color: #000;
    }

    .modal-header h4 {
        font-size: 18px !important;
    }

    .modal-header .close {
        font-size: 22px !important;
    }

    #card_header {
        padding: 0 !important;
    }
}
</style>

<div class="main-content">
    {{ Breadcrumbs::render('sailstatus') }}
    <section class="section">
        <div class="section-body mt-2">
            <div class="row">
                @if (session('success'))
                <input type="hidden" name="session_data" id="session_data" class="session_data" value="{{ session('success') }}">
                <script type="text/javascript">
                    window.onload = function() {
                        var message = $('#session_data').val();
                        Swal.fire("Success", message, "success");
                    }
                </script>
                @elseif(session('fail'))
                <input type="hidden" name="session_data" id="session_data1" class="session_data" value="{{ session('fail') }}">
                <script type="text/javascript">
                    window.onload = function() {
                        var message = $('#session_data1').val();
                        Swal.fire("Info", message, "info");
                    }
                </script>
                @endif

                <div class="col-12 mb-2">
                    <a type="button" href="{{route('sailstatus.initiate')}}" class="btn btn-labeled btn-info" title="create" style="background: #044a95 !important; border-color:#a9ca !important; color:white !important; margin: 0 0 2px 15px;">
                        <span class="btn-label" style="font-size:15px !important; padding:8px !important"><i class="fa fa-plus"></i></span>
                        <span style="font-size:15px !important; padding:8px !important">Initiation</span>
                    </a>
                </div>

                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-12 text-center">
                                    <h4 style="color:darkblue;">SAIL Status List View</h4>
                                </div>
                            </div>
                            <div class="table-wrapper">
                                <div class="table-responsive searchResultStudent">
                                    <table class="table table-bordered" id="align">
                                        <thead>
                                            <tr>
                                                <th>Sl. No.</th>
                                                <th>Child Name</th>
                                                <th>Enrollment Number</th>
                                                <th>Coordinator</th>
                                                <th>Status</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($rows as $key=>$row)
                                            <tr>
                                                <td>{{$loop->iteration}}</td>
                                                <td>{{ $row['child_name'] }}</td>
                                                <td>{{$row['enrollment_child_num']}}</td>
                                                <td>
                                                    @if($row['is_coordinator2'] == [])
                                                        {{ $row['is_coordinator1']['name'] }}
                                                    @else
                                                        {{ $row['is_coordinator1']['name'] }},<br>{{ $row['is_coordinator2']['name'] }}
                                                    @endif
                                                </td>
                                                <td>
                                                    @if($row['current_status'] == 'Initiated')
                                                        Consent Form Sent
                                                    @else
                                                        {{ $row['current_status'] }}
                                                    @endif
                                                </td>
                                                <td class="text-center">
                                                    <!-- View Activity Log (bars icon) -->
                                                    <a href="#addModal" data-toggle="modal" data-target="#addModal{{$row['user_id']}}" class="btn btn-primary" title="View Activity" style="margin-inline:3px">
                                                        <i class="fa fa-bars" style="color:white!important"></i>
                                                    </a>
                                                    <!-- View Document (download icon) -->
                                                    @php
                                                        $folderPath = $row['child_id'];
                                                        $consent = '/sail_consent/'.$folderPath.'/consent_form_sail.pdf';
                                                    @endphp
                                                    <a class="btn btn-primary" title="View Document" data-toggle="modal" data-target="#templates" onclick="getproposaldocument('{{$consent}}')" style="margin-inline:3px">
                                                        <i class="fa fa-download" style="color:white!important"></i>
                                                    </a>
                                                    <!-- Edit link (if permission exists) -->
                                                    @if(strpos($screen_permission['permissions'], 'Edit') !== false)
                                                        <a class="btn btn-link" title="Edit" href="{{ route('sail.status.edit', \Crypt::encrypt($row['enrollment_id'])) }}" style="margin-inline:3px">
                                                            <i class="fas fa-pencil-alt" style="color: blue !important"></i>
                                                        </a>
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
    </section>
</div>

<!-- ========== MODAL FOR SAIL ACTIVITY LOG (per child) ========== -->
@foreach($rows as $key=>$row)
<div class="modal fade" id="addModal{{$row['user_id']}}">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="main-contents">
                <section class="section">
                    <div class="modal-header bg-primary" style="background-color: rgb(0 103 172) !important;">
                        <h4 class="modal-title">Sail Overview of {{$row['child_name']}}</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    </div>
                    <div class="modal-body" style="background-color: #edfcff !important;">
                        <div class="section-body mt-2">
                            <div class="row">
                                <div class="col-12">
                                    <div class="mt-0">
                                        <div class="card-body" id="card_header">
                                            <div class="table-wrapper">
                                                <div class="table-responsive p-3">
                                                    <table class="table table-bordered">
                                                        <thead>
                                                            <tr>
                                                                <th>S.No.</th>
                                                                <th>Status</th>
                                                                <th>Date</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @foreach($actions as $audit)
                                                                @if($row['child_id'] == $audit['child_id'])
                                                                <tr>
                                                                    <td>{{$loop->iteration}}</td>
                                                                    <td>{{$audit['audit_action']}}</td>
                                                                    <td>
                                                                        <script>
                                                                            var dateString = "{{ $audit['action_date_time'] }}";
                                                                            var formattedDateString = dateString.replace(/-/g, '/') + ' UTC';
                                                                            var utcDate = new Date(formattedDateString);
                                                                            var options = {
                                                                                timeZone: 'Asia/Kolkata',
                                                                                year: 'numeric',
                                                                                month: 'numeric',
                                                                                day: 'numeric',
                                                                                hour: 'numeric',
                                                                                minute: 'numeric',
                                                                                second: 'numeric'
                                                                            };
                                                                            var istDate = new Intl.DateTimeFormat('en-IN', options).format(utcDate);
                                                                            istDate = istDate.replace(/\b(?:am|pm)\b/gi, match => match.toUpperCase());
                                                                            document.write(istDate);
                                                                        </script>
                                                                    </td>
                                                                </tr>
                                                                @endif
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
                    </div>
                </section>
            </div>
        </div>
    </div>
</div>
@endforeach

<!-- ========== MODAL FOR DOCUMENT PREVIEW (IFRAME) ========== -->
<div class="modal fade" id="templates" tabindex="-1" role="dialog" aria-labelledby="documentModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary" style="background-color: rgb(0 103 172) !important;">
                <h5 class="modal-title" id="documentModalLabel">SAIL Consent Form</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="modalviewdiv" style="height: 80vh; padding: 0;">
                <div id="loading_gif" style="text-align:center; display:none;">Loading PDF...</div>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-1.7.2.min.js"></script>
<script>
    function getproposaldocument(url) {
        $('#modalviewdiv').html('');
        $("#loading_gif").show();
        var iframeHtml = "<iframe src='" + url + "' class='document_ifarme_view' style='width:100%; height:100%; border:none;'></iframe>";
        $("#loading_gif").hide();
        $('#modalviewdiv').html(iframeHtml);
    }

    // Mobile row expand/collapse - only on screens <= 768px, prevent toggling when clicking on action icons/links
    $(document).ready(function() {
        $('#align tbody').on('click', 'tr', function(e) {
            // If clicked element is inside an action link/button or modal trigger, do not toggle row
            if ($(e.target).closest('a, button, .btn, .fa, .fas').length) {
                return;
            }
            if ($(window).width() <= 768) {
                $(this).toggleClass('expanded-row');
            }
        });
    });
</script>

@include('newenrollement.formmodal')  {{-- includes additional modal if needed --}}
@endsection