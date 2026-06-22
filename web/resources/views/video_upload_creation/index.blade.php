@extends('layouts.adminnav')

@section('content')

<style>
    /* ================================================================
       MOBILE RESPONSIVE – same pattern as OVM‑1
       ================================================================ */

    /* ---- General Mobile Overrides ---- */
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

        /* ---- Top action buttons: centered, inline, wrap if needed ---- */
        .d-flex.justify-content-end {
            justify-content: center !important;
            flex-direction: row !important;
            flex-wrap: wrap !important;
            gap: 8px !important;
        }

        .d-flex.justify-content-end .btn {
            width: auto !important;
            margin: 0 !important;
            flex: 0 0 auto !important;
            font-size: 13px !important;
            padding: 6px 14px !important;
        }

        /* ---- Toggle button group: centered, inline, wrap if needed ---- */
        .btn-group {
            display: flex !important;
            flex-direction: row !important;
            flex-wrap: wrap !important;
            justify-content: center !important;
            width: 100% !important;
            gap: 6px !important;
        }

        .btn-group .btn {
            width: auto !important;
            flex: 0 0 auto !important;
            border-radius: 4px !important;
            margin: 0 !important;
            font-size: 13px !important;
            padding: 6px 14px !important;
        }

        .btn-group .btn:first-child {
            border-radius: 4px !important;
        }

        .btn-group .btn:last-child {
            border-radius: 4px !important;
        }

        /* ---- Center the table headings on mobile ---- */
        #activityTable .card-body h5,
        #pendingTable .card-body h5 {
            text-align: center !important;
        }

        /* ---- Table: card layout (both tables) ---- */
        /* Hide table headers */
        #activityTableTbl thead,
        #pendingTableTbl thead {
            display: none !important;
        }

        /* Each row becomes a card */
        #activityTableTbl tbody tr,
        #pendingTableTbl tbody tr {
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

        #activityTableTbl tbody td,
        #pendingTableTbl tbody td {
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

        /* Sl.No – left badge (always visible) */
        #activityTableTbl tbody td:first-child,
        #pendingTableTbl tbody td:first-child {
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

        #activityTableTbl tbody tr.expanded-row td:first-child,
        #pendingTableTbl tbody tr.expanded-row td:first-child {
            top: 20px !important;
            transform: translateY(0) !important;
        }

        /* ---- Activity name – bold, always visible ---- */
        #activityTableTbl tbody td:nth-child(4) {
            display: block !important;
            font-weight: 600 !important;
            font-size: 16px !important;
            color: #2c3e50 !important;
            margin-bottom: 4px !important;
            padding-right: 25px !important;
            order: 1 !important;
        }

        /* Age Group & Type – hidden by default, shown on expand with labels */
        #activityTableTbl tbody td:nth-child(2),
        #activityTableTbl tbody td:nth-child(3) {
            display: none !important;
        }

        #activityTableTbl tbody tr.expanded-row td:nth-child(2) {
            display: block !important;
            margin-top: 8px !important;
            font-size: 12px !important;
            color: #34495e !important;
            order: 2 !important;
        }
        #activityTableTbl tbody tr.expanded-row td:nth-child(2)::before {
            content: "Age Group: ";
            font-weight: 600 !important;
            color: #000 !important;
        }

        #activityTableTbl tbody tr.expanded-row td:nth-child(3) {
            display: block !important;
            margin-top: 6px !important;
            font-size: 12px !important;
            color: #34495e !important;
            order: 3 !important;
        }
        #activityTableTbl tbody tr.expanded-row td:nth-child(3)::before {
            content: "Type: ";
            font-weight: 600 !important;
            color: #000 !important;
        }

        /* Actions – hidden, shown on expand */
        #activityTableTbl tbody td:nth-child(5) {
            display: none !important;
        }

        #activityTableTbl tbody tr.expanded-row td:nth-child(5) {
            display: flex !important;
            align-items: center !important;
            flex-wrap: wrap !important;
            gap: 6px !important;
            margin-top: 6px !important;
            order: 4 !important;
        }

        #activityTableTbl tbody tr.expanded-row td:nth-child(5)::before {
            content: "Actions: ";
            font-weight: 600 !important;
            color: #000 !important;
            margin-right: 6px !important;
            flex-shrink: 0 !important;
        }

        #activityTableTbl tbody tr.expanded-row td:nth-child(5) a {
            display: inline-flex !important;
            align-items: center !important;
            justify-content: center !important;
            margin-right: 0 !important;
            padding: 2px !important;
            font-size: 14px !important;
        }

        /* ---- Pending Table: different column mapping ---- */
        /* Activity name is second column */
        #pendingTableTbl tbody td:nth-child(2) {
            display: block !important;
            font-weight: 600 !important;
            font-size: 16px !important;
            color: #2c3e50 !important;
            margin-bottom: 4px !important;
            padding-right: 25px !important;
            order: 1 !important;
        }

        /* Actions (Review button) – hidden, shown on expand */
        #pendingTableTbl tbody td:nth-child(3) {
            display: none !important;
        }

        #pendingTableTbl tbody tr.expanded-row td:nth-child(3) {
            display: flex !important;
            align-items: center !important;
            flex-wrap: wrap !important;
            gap: 6px !important;
            margin-top: 6px !important;
            order: 2 !important;
        }

        #pendingTableTbl tbody tr.expanded-row td:nth-child(3)::before {
            content: "Action: ";
            font-weight: 600 !important;
            color: #000 !important;
            margin-right: 6px !important;
            flex-shrink: 0 !important;
        }

        #pendingTableTbl tbody tr.expanded-row td:nth-child(3) .btn {
            font-size: 12px !important;
            padding: 4px 10px !important;
        }

        /* ---- Right‑side arrow (both tables) ---- */
        #activityTableTbl tbody tr::after,
        #pendingTableTbl tbody tr::after {
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

        #activityTableTbl tbody tr.expanded-row::after,
        #pendingTableTbl tbody tr.expanded-row::after {
            transform: translateY(-50%) rotate(90deg);
            top: 35px;
        }

        /* ---- No records row – keep as table row ---- */
        #activityTableTbl tbody tr:has(td.dataTables_empty),
        #pendingTableTbl tbody tr:has(td.dataTables_empty) {
            display: table-row !important;
            border: none !important;
            box-shadow: none !important;
            padding: 0 !important;
            background: transparent !important;
            cursor: default !important;
        }

        #activityTableTbl tbody tr:has(td.dataTables_empty) td,
        #pendingTableTbl tbody tr:has(td.dataTables_empty) td {
            display: table-cell !important;
            text-align: center !important;
            padding: 15px !important;
            font-size: 13px !important;
            font-weight: 600 !important;
            color: #666 !important;
        }

        #activityTableTbl tbody tr:has(td.dataTables_empty)::after,
        #pendingTableTbl tbody tr:has(td.dataTables_empty)::after {
            display: none !important;
        }

        /* ---- DataTable controls (if used) ---- */
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

        .card-body h5 {
            font-size: 16px !important;
        }
    }
</style>

<div class="main-content">
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
    {{ Breadcrumbs::render('video_creation.index') }}

    <!-- Page Heading -->
    <div class="d-flex justify-content-center align-items-center mb-4">
        <h4 style="color:darkblue;">Activity Creation List</h4>
    </div>

    <!-- Top Action Buttons (centered on mobile) -->
    <div class="d-flex justify-content-end mb-3">
        <a href="{{ route('video_creation.create') }}" class="btn btn-primary me-2 mr-3">
            <i class="fa fa-plus me-1"></i> Add Activity
        </a>
        <a href="{{ route('privacy.update', \Crypt::encrypt('4')) }}" class="btn btn-secondary">
            <i class="fa fa-info-circle me-1"></i> General Instructions
        </a>
    </div>

    <!-- Toggle Button Group (centered on mobile) -->
    <div class="mb-4 text-center">
        <div class="btn-group" role="group" aria-label="Toggle Tables">
            <button type="button" id="btnAllActivities" class="btn btn-outline-primary active" onclick="showTable('all')">
                <i class="fas fa-list me-1"></i> All Activities
            </button>
            <button type="button" id="btnPending" class="btn btn-outline-primary" onclick="showTable('pending')">
                <i class="fas fa-clock me-1"></i> Pending Approvals
            </button>
        </div>
    </div>

    <!-- Activity List Table (All Activities) -->
    <div class="card shadow-sm mb-4" id="activityTable">
        <div class="card-body">
            <h5 class="mb-3 text-dark">All Activities</h5>
            <div class="table-responsive">
                <table class="table table-bordered table-hover align-middle" id="activityTableTbl">
                    <thead class="table-light">
                        <tr>
                            <th>SI NO</th>
                            <th>Age Group</th>
                            <th>Type</th>
                            <th>Activity</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($rows as $row)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $row['group'] }}</td>
                            <td>
                                @if($row['category'] == '1') Parent
                                @elseif($row['category'] == '2') Child
                                @else All
                                @endif
                            </td>
                            <td>{{ $row['activity_name'] }}</td>
                            <td>
                                <a href="{{ route('activitymaster.show_1', Crypt::encrypt($row['activity_id'])) }}" title="View" class="btn btn-sm btn-outline-success me-1"><i class="fas fa-eye"></i></a>
                                <a href="{{ route('activitymaster.edit_1', Crypt::encrypt($row['activity_id'])) }}" title="Edit" class="btn btn-sm btn-outline-primary me-1"><i class="fas fa-edit"></i></a>
                                <a href="{{ route('activitymaster.mapping', Crypt::encrypt($row['activity_id'])) }}" title="Mapping" class="btn btn-sm btn-outline-info me-1"><i class="fa fa-link"></i></a>
                                <a href="javascript:void(0)" onclick=" myFunction('{{ encrypt($row['activity_id']) }}')" title="Delete" class="btn btn-sm btn-outline-danger"><i class="fas fa-trash-alt"></i></a>
                                <input type="hidden" id="delete_id_{{ $row['activity_id'] }}" value="{{ route('video_creation.delete', $row['activity_id']) }}">
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Pending Approval Table -->
    <div class="card shadow-sm d-none mb-4" id="pendingTable">
        <div class="card-body">
            <h5 class="mb-3 text-dark">Pending Approvals</h5>
            <div class="table-responsive">
                <table class="table table-bordered table-hover align-middle" id="pendingTableTbl">
                    <thead class="table-light">
                        <tr>
                            <th>SI No</th>
                            <th>Activity</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($pendingActivities as $index => $pending)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $pending['activity_name'] }}</td>
                            <td>
                                <button class="btn btn-sm btn-outline-primary" onclick="openApprovalModal({{ $pending['activity_id'] }}, '{{ $pending['activity_name'] }}')">
                                    <i class="fas fa-edit me-1"></i> Review
                                </button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="approvalModal" tabindex="-1" aria-labelledby="approvalModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form id="approvalForm" method="POST" action="{{route('activity.skill.action')}}">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Review Activity: <span id="modalActivityName"></span></h5>
                        <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="activity_id" id="modalActivityId">
                        <p>Do you want to approve or reject this activity?</p>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" name="action" value="approve" class="btn btn-success">Approve</button>
                        <button type="submit" name="action" value="reject" class="btn btn-danger">Reject</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- JavaScript -->
<script>
    function toggleTable() {
        document.getElementById('activityTable').classList.toggle('d-none');
        document.getElementById('pendingTable').classList.toggle('d-none');
    }

    function openApprovalModal(id, name) {
        document.getElementById('modalActivityId').value = id;
        document.getElementById('modalActivityName').innerText = name;
        new bootstrap.Modal(document.getElementById('approvalModal')).show();
    }

    function showTable(type) {
        const activityTable = document.getElementById('activityTable');
        const pendingTable = document.getElementById('pendingTable');
        const btnAll = document.getElementById('btnAllActivities');
        const btnPending = document.getElementById('btnPending');

        if (type === 'all') {
            activityTable.classList.remove('d-none');
            pendingTable.classList.add('d-none');
            btnAll.classList.add('active');
            btnPending.classList.remove('active');
        } else {
            activityTable.classList.add('d-none');
            pendingTable.classList.remove('d-none');
            btnAll.classList.remove('active');
            btnPending.classList.add('active');
        }
    }

    function myFunction(activityId) {
        Swal.fire({
            title: 'Are you sure?',
            text: "This record will be permanently deleted!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Yes, delete it!',
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = "/activity/delete/" + activityId;
            }
        });
    }

    // ================================================================
    // MOBILE ACCORDION – for both tables (like OVM‑1)
    // ================================================================
    $(document).ready(function() {
        // All Activities table
        $('#activityTableTbl tbody').on('click', 'tr', function(e) {
            if ($(e.target).closest('a, button, input, form').length) {
                return;
            }
            if ($(window).width() <= 768) {
                $(this).toggleClass('expanded-row');
            }
        });

        // Pending Approvals table
        $('#pendingTableTbl tbody').on('click', 'tr', function(e) {
            if ($(e.target).closest('a, button, input, form').length) {
                return;
            }
            if ($(window).width() <= 768) {
                $(this).toggleClass('expanded-row');
            }
        });
    });
</script>

@endsection