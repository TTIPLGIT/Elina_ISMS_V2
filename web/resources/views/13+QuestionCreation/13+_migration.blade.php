@extends('layouts.adminnav')

@section('content')
    <style>
        .decision-tabs {
            display: flex;
            justify-content: center;
            gap: 15px;
            margin-bottom: 25px;
            flex-wrap: wrap;
        }

        .decision-tab-btn {
            border: 1px solid #d5d5d5;
            background: #fff;
            color: #555;
            padding: 10px 28px;
            border-radius: 30px;
            font-weight: 600;
            transition: 0.3s;
            cursor: pointer;
        }

        .decision-tab-btn.active {
            background: #1f2b8f;
            color: #fff;
            border-color: #1f2b8f;
        }

        .modal-header-custom {
            background: #1f2b8f;
            color: #fff;
        }

        .section-title-custom {
            color: #1f2b8f;
            font-weight: 700;
            margin-top: 10px;
            margin-bottom: 10px;
        }

        .detail-label {
            font-weight: 700;
            color: #333;
        }

        .detail-value {
            color: #555;
        }

        .swal2-popup {
            border-radius: 10px !important;
        }

        .swal2-confirm {
            background-color: #1db954 !important;
        }

        .swal2-cancel {
            background-color: #6c757d !important;
        }

        #dynamicHeading {
            color: #1F2B8F !important;
            font-size: 40px;
            font-weight: 700;
        }

        .decision-tab-btn.active {
            background: #1F2B8F !important;
            border-color: #1F2B8F !important;
            color: #fff !important;
        }

        /* Unified table styling for all three tables */
        .unified-table {
            width: 100%;
            border-collapse: collapse;
        }

        .unified-table thead th {
            text-align: center;
            vertical-align: middle;
            padding: 12px 10px;
            font-size: 14px;
            font-weight: 600;
            white-space: nowrap;
        }

        .unified-table tbody td {
            text-align: center;
            vertical-align: middle;
            padding: 10px 10px;
            font-size: 14px;
        }

        .isms-remigration-legend {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 12px;
            font-weight: 600;
            color: #333;
        }

        .isms-remigration-legend i {
            font-size: 1.1rem;
            color: #1F2B8F;
        }

        .isms-status-icon-only i {
            font-size: 1.15rem;
            color: #1F2B8F;
        }
    </style>

    <div class="main-content">

        <section class="section">

            <div class="section-body mt-2">

                <div class="row">

                    @if (session('success'))
                        <input type="hidden" id="session_data" value="{{ session('success') }}">

                        <script>
                            window.onload = function() {

                                var message = $('#session_data').val();

                                Swal.fire(
                                    "Success",
                                    message,
                                    "success"
                                );

                            }
                        </script>
                    @elseif(session('fail'))
                        <input type="hidden" id="session_data1" value="{{ session('fail') }}">

                        <script>
                            window.onload = function() {

                                var message = $('#session_data1').val();

                                Swal.fire(
                                    "Info",
                                    message,
                                    "info"
                                );

                            }
                        </script>
                    @endif



                    <div class="col-12">

                        <div class="card shadow-sm">

                            <div class="card-body">

                                <div class="row mb-2">

                                    <div class="col-lg-12 text-center">

                                        <h2 class="font-weight-bold" id="dynamicHeading" style="color:#1F2B8F !important;">
                                            Transition Decisions
                                        </h2>

                                    </div>

                                </div>



                                <div class="decision-tabs">

                                    <button type="button" class="decision-tab-btn active" data-table="decisionTable">

                                        Transition Decisions

                                    </button>



                                    <button type="button" class="decision-tab-btn" data-table="ismsTable">

                                        SAIL Foundation

                                    </button>



                                    <button type="button" class="decision-tab-btn" data-table="migration13Table">

                                        SAIL Adolescent

                                    </button>

                                </div>



                                {{-- ============================================================ --}}
                                {{-- DECISION TABLE --}}
                                {{-- ============================================================ --}}

                                <div class="table-responsive table-section" id="decisionTable">
  <div class="d-flex justify-content-end">
                                        <div class="isms-remigration-legend" style="margin-bottom: 12px;">
                                            <span>Note: Children returning between pathways are marked with <i class="fas fa-exchange-alt" aria-hidden="true"></i></span>
                                        </div>
                                    </div>
                                    <table class="table table-bordered table-hover table-striped unified-table"
                                        id="align">

                                        <thead class="bg-primary text-white">

                                            <tr>

                                                <th width="8%">Sl. No.</th>

                                                <th>Enrollment ID</th>

                                                <th>Child Name</th>

                                                <th>Status</th>

                                                <th width="12%">Action</th>

                                            </tr>

                                        </thead>



                                        <tbody>

                                            @php
                                                $decisionRowNum = 0;
                                                $hasDecisionRows = (isset($sail_status_details) && count($sail_status_details) > 0)
                                                    || (isset($remigration_decision_list) && count($remigration_decision_list) > 0);
                                            @endphp

                                            @if ($hasDecisionRows)
                                            @foreach($sail_status_details as $key => $data)
                                                @php $decisionRowNum++; @endphp
                                                @php

                                                    $coordinator1 = json_decode($data['iscoordinator1_id'], true);

                                                    $jsonData = [
                                                        'child_details' => [
                                                            'name' => $data['ed_child_name'] ?? '',
                                                            'dob' => $data['child_dob'] ?? '',
                                                            'enrollment' => $data['enrollment_child_num'] ?? '',
                                                            'user_id' => $data['user_id'] ?? '',
                                                            'email' => $data['child_contact_email'] ?? '',
                                                        ],

                                                        'parent_details' => [
                                                            'parent_name' => $data['parent_name'] ?? '',
                                                        ],

                                                        'is_coordinator' => [
                                                            'id' => $coordinator1['id'] ?? '',
                                                            'name' => $coordinator1['name'] ?? '',
                                                            'email' => $coordinator1['email'] ?? '',
                                                        ],
                                                    ];

                                                @endphp

                                                <tr>

                                                    <td>{{ $decisionRowNum }}</td>

                                                    <td>{{ $data['enrollment_child_num'] ?? '-' }}</td>

                                                    <td>{{ $data['ed_child_name'] ?? '-' }}</td>

                                                    <td>{{ $data['current_status'] ?? '-' }}</td>

                                                    <td class="text-center">
                                                            <button type="button"
                                                                class="btn btn-success btn-sm openMigrationModal"
                                                                data-toggle="modal" data-target="#childModal"
                                                                data-enrollment="{{ $data['enrollment_child_num'] ?? '' }}"
                                                                data-child="{{ $data['ed_child_name'] ?? '' }}"
                                                                data-parent="{{ $data['parent_name'] ?? '' }}"
                                                                data-email="{{ $data['child_contact_email'] ?? '' }}"
                                                                data-status="{{ $data['current_status'] ?? '' }}"
                                                                data-dob="{{ $data['child_dob'] ?? '' }}"
                                                                data-userid="{{ $data['user_id'] ?? '' }}"
                                                                data-coordinatorid="{{ $coordinator1['id'] ?? '' }}"
                                                                data-coordinatorname="{{ $coordinator1['name'] ?? '' }}"
                                                                data-coordinatoremail="{{ $coordinator1['email'] ?? '' }}"
                                                                data-json='@json($jsonData)' title="Transition">

                                                                <i class="fas fa-exchange-alt"></i>

                                                            </button>
                                                    </td>

                                                </tr>

                                            @endforeach

                                            @foreach($remigration_decision_list ?? [] as $remigData)
                                                @php
                                                    $decisionRowNum++;
                                                    $remigArr = (array) $remigData;
                                                    $remigJson = [
                                                        'child_details' => [
                                                            'name' => $remigArr['name'] ?? '',
                                                            'dob' => $remigArr['dob'] ?? '',
                                                            'enrollment' => $remigArr['enrollment'] ?? '',
                                                            'user_id' => $remigArr['user_id'] ?? '',
                                                            'email' => $remigArr['email'] ?? '',
                                                        ],
                                                        'parent_details' => [
                                                            'parent_name' => $remigArr['parent_name'] ?? '',
                                                        ],
                                                        'is_coordinator' => [
                                                            'id' => $remigArr['coordinator_id'] ?? '',
                                                            'name' => $remigArr['coordinator_name'] ?? '',
                                                            'email' => $remigArr['coordinator_email'] ?? '',
                                                        ],
                                                    ];
                                                @endphp
                                                <tr>
                                                    <td>{{ $decisionRowNum }}</td>
                                                    <td>{{ $remigArr['enrollment'] ?? '-' }}</td>
                                                    <td>{{ $remigArr['name'] ?? '-' }}</td>
                                                    <td>{{$remigArr['current_status']}}</td>       
                                             <td class="text-center">
                                                        <button type="button"
                                                            class="btn btn btn-sm text-blue openRemigrationModal"
                                                            data-toggle="modal" data-target="#remigrationModal"
                                                            data-enrollment="{{ $remigArr['enrollment'] ?? '' }}"
                                                            data-child="{{ $remigArr['name'] ?? '' }}"
                                                            data-parent="{{ $remigArr['parent_name'] ?? '' }}"
                                                            data-email="{{ $remigArr['email'] ?? '' }}"
                                                            data-dob="{{ $remigArr['dob'] ?? '' }}"
                                                            data-userid="{{ $remigArr['user_id'] ?? '' }}"
                                                            data-coordinatorid="{{ $remigArr['coordinator_id'] ?? '' }}"
                                                            data-coordinatorname="{{ $remigArr['coordinator_name'] ?? '' }}"
                                                            data-coordinatoremail="{{ $remigArr['coordinator_email'] ?? '' }}"
                                                            data-json='@json($remigJson)' title="Remigration">
                                                            <i class="fas fa-exchange-alt"></i>
                                                        </button>
                                                    </td>
                                                </tr>
                                            @endforeach
                                            @else
                                                <tr>
                                                    <td colspan="5" class="text-center text-danger font-weight-bold">
                                                        No Records Found
                                                    </td>
                                                </tr>
                                            @endif

                                        </tbody>

                                    </table>

                                </div>



                                {{-- ============================================================ --}}
                                {{-- ISMS MIGRATION TABLE --}}
                                {{-- ============================================================ --}}

                                <div class="table-responsive table-section d-none" id="ismsTable">

                                    <div class="d-flex justify-content-end">
                                        <div class="isms-remigration-legend" style="margin-bottom: 12px;">
                                            <span>Note: Children returning between pathways are marked with <i class="fas fa-exchange-alt" aria-hidden="true"></i></span>
                                        </div>
                                    </div>

                                    <table class="table table-bordered table-hover table-striped unified-table">

                                        <thead class="bg-primary text-white">

                                            <tr>

                                                <th width="8%">Sl. No.</th>

                                                <th>Enrollment ID</th>

                                                <th>Child Name</th>

                                                <th>Notes</th>

                                                <th width="12%">Status</th>

                                            </tr>

                                        </thead>

                                        <tbody>

                                            @forelse($isms_migration_data as $key => $ismsData)
                                                @php
                                                    $ismsArr = (array) $ismsData;
                                                @endphp
                                                <tr>

                                                    <td>{{ $key + 1 }}</td>

                                                    <td>{{ $ismsArr['enrollment'] ?? '-' }}</td>

                                                    <td>{{ $ismsArr['name'] ?? '-' }}</td>

                                                    <td>{{ $ismsArr['notes'] ?? '-' }}</td>

                                                    <td>
                                                        @if (($ismsArr['migration_status'] ?? '') == 4)
                                                            <span class="isms-status-icon-only" title="Children returning between pathways">
                                                                <i class="fas fa-exchange-alt" aria-hidden="true"></i>
                                                            </span>
                                                         @elseif(($ismsArr['migration_status'] ?? '') == 1)
                                                             <span style="display: inline-block; padding: 4px 8px; font-size: 12px; font-weight: 700; line-height: 1.4; text-align: center; white-space: normal; vertical-align: middle; border-radius: 4px; color: #fff; background-color: #17a2b8;">Transition Completed</span>
                                                        @else
                                                            {{-- --}}
                                                        @endif
                                                    </td>

                                                </tr>

                                            @empty

                                                <tr>

                                                    <td colspan="5" class="text-center text-danger font-weight-bold">

                                                        No Records Found

                                                    </td>

                                                </tr>
                                            @endforelse

                                        </tbody>

                                    </table>

                                </div>



                                {{-- ============================================================ --}}
                                {{-- 13+ MIGRATION TABLE --}}
                                {{-- ============================================================ --}}

                                <div class="table-responsive table-section d-none" id="migration13Table">

                                    <table class="table table-bordered table-hover table-striped unified-table">

                                        <thead class="bg-primary text-white">

                                            <tr>

                                                <th width="8%">Sl. No.</th>

                                                <th>Enrollment ID</th>

                                                <th>Child Name</th>

                                                <th>Notes</th>

                                                <th width="12%">Status</th>

                                            </tr>

                                        </thead>

                                        <tbody>

                                            @forelse($migration_to_13_plus as $key => $migData)
                                                @php
                                                    $migArr = (array) $migData;
                                                @endphp
                                                <tr>

                                                    <td>{{ $key + 1 }}</td>

                                                    <td>{{ $migArr['enrollment'] ?? '-' }}</td>

                                                    <td>{{ $migArr['name'] ?? '-' }}</td>

                                                    <td>{{ $migArr['notes'] ?? '-' }}</td>
                                                     <td><span style="display: inline-block; padding: 4px 8px; font-size: 12px; font-weight: 700; line-height: 1; text-align: center; white-space: nowrap; vertical-align: middle; border-radius: 4px; color: #fff; background-color: #28a745;">Transitioned to SAIL Adolescent </span></td>


                                                  
                                                </tr>

                                            @empty

                                                <tr>

                                                    <td colspan="5" class="text-center text-danger font-weight-bold">

                                                        No Records Found

                                                    </td>

                                                </tr>
                                            @endforelse

                                        </tbody>

                                    </table>

                                </div>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </section>

    </div>



    {{-- ============================================================ --}}
    {{-- MIGRATION MODAL (existing) --}}
    {{-- ============================================================ --}}

    <div class="modal fade" id="childModal" tabindex="-1" role="dialog" aria-hidden="true">

        <div class="modal-dialog modal-lg" role="document">

            <div class="modal-content">

                <div class="modal-header modal-header-custom">

                    <h5 class="modal-title font-weight-bold">
                        Enrollment Details
                    </h5>

                    <button type="button" class="close text-white" data-dismiss="modal" style="opacity:1;">

                        <span>&times;</span>

                    </button>

                </div>



                <form action="{{ route('13plus.migration') }}" method="POST" id="migrationForm">

                    @csrf

                    <input type="hidden" name="migration_json" id="migration_json">

                    <input type="hidden" name="migration_type" id="migration_type">



                    <div class="modal-body">

                        <h6 class="section-title-custom">
                            Child Details
                        </h6>

                        <hr>

                        <div class="row mb-2">

                            <div class="col-md-4 detail-label">
                                Name
                            </div>

                            <div class="col-md-8 detail-value" id="modal_child"></div>

                        </div>



                        <div class="row mb-2">

                            <div class="col-md-4 detail-label">
                                DOB
                            </div>

                            <div class="col-md-8 detail-value" id="modal_dob"></div>

                        </div>



                        <div class="row mb-2">

                            <div class="col-md-4 detail-label">
                                Enrollment
                            </div>

                            <div class="col-md-8 detail-value" id="modal_enrollment"></div>

                        </div>



                        <div class="row mb-2">

                            <div class="col-md-4 detail-label">
                                User ID
                            </div>

                            <div class="col-md-8 detail-value" id="modal_userid"></div>

                        </div>



                        <div class="row mb-3">

                            <div class="col-md-4 detail-label">
                                Email
                            </div>

                            <div class="col-md-8 detail-value" id="modal_email"></div>

                        </div>



                        <h6 class="section-title-custom">
                            Parent Details
                        </h6>

                        <hr>

                        <div class="row mb-3">

                            <div class="col-md-4 detail-label">
                                Parent Name
                            </div>

                            <div class="col-md-8 detail-value" id="modal_parent"></div>

                        </div>



                        <h6 class="section-title-custom">
                            IS Coordinator
                        </h6>

                        <hr>

                        <div class="row mb-2">

                            <div class="col-md-4 detail-label">
                                ID
                            </div>

                            <div class="col-md-8 detail-value" id="modal_coordinatorid"></div>

                        </div>



                        <div class="row mb-2">

                            <div class="col-md-4 detail-label">
                                Name
                            </div>

                            <div class="col-md-8 detail-value" id="modal_coordinatorname"></div>

                        </div>



                        <div class="row mb-3">

                            <div class="col-md-4 detail-label">
                                Email
                            </div>

                            <div class="col-md-8 detail-value" id="modal_coordinatoremail"></div>

                        </div>



                        <div class="row mt-4">

                            <div class="col-md-12">

                                <label>
                                    <b>Notes <span class="text-danger">*</span></b>
                                </label>

                                <textarea  style ="background-color: white !important" class="form-control" name="notes" id="notes" rows="3" placeholder="Enter Notes"></textarea>

                                <span class="text-danger" id="notes_error"></span>

                            </div>

                        </div>

                    </div>



                    <div class="modal-footer">

                        <button type="button" class="btn btn-danger" data-dismiss="modal">

                            Close

                        </button>



                        <button type="button" class="btn btn-warning text-white" id="ismsBtn">

                            Sail Foundation

                        </button>



                        <button type="button" class="btn btn-success" id="migrate13PlusBtn">

                            Sail Adolescent

                        </button>

                    </div>

                </form>

            </div>

        </div>

    </div>



    {{-- ============================================================ --}}
    {{-- REMIGRATION MODAL --}}
    {{-- ============================================================ --}}

    <div class="modal fade" id="remigrationModal" tabindex="-1" role="dialog" aria-hidden="true">

        <div class="modal-dialog modal-lg" role="document">

            <div class="modal-content">

                <div class="modal-header modal-header-custom">

                    <h5 class="modal-title font-weight-bold">
                        Remigration
                    </h5>

                    <button type="button" class="close text-white" data-dismiss="modal" style="opacity:1;">

                        <span>&times;</span>

                    </button>

                </div>



                <form action="{{ route('13plus.migration.remigrate') }}" method="POST" id="remigrationForm">

                    @csrf

                    <input type="hidden" name="migration_json" id="remigration_json">



                    <div class="modal-body">

                        <h6 class="section-title-custom">
                            Child Details
                        </h6>

                        <hr>

                        <div class="row mb-2">

                            <div class="col-md-4 detail-label">
                                Name
                            </div>

                            <div class="col-md-8 detail-value" id="remigrate_modal_child"></div>

                        </div>



                        <div class="row mb-2">

                            <div class="col-md-4 detail-label">
                                DOB
                            </div>

                            <div class="col-md-8 detail-value" id="remigrate_modal_dob"></div>

                        </div>



                        <div class="row mb-2">

                            <div class="col-md-4 detail-label">
                                Enrollment
                            </div>

                            <div class="col-md-8 detail-value" id="remigrate_modal_enrollment"></div>

                        </div>



                        <div class="row mb-2">

                            <div class="col-md-4 detail-label">
                                User ID
                            </div>

                            <div class="col-md-8 detail-value" id="remigrate_modal_userid"></div>

                        </div>



                        <div class="row mb-3">

                            <div class="col-md-4 detail-label">
                                Email
                            </div>

                            <div class="col-md-8 detail-value" id="remigrate_modal_email"></div>

                        </div>



                        <h6 class="section-title-custom">
                            Parent Details
                        </h6>

                        <hr>

                        <div class="row mb-3">

                            <div class="col-md-4 detail-label">
                                Parent Name
                            </div>

                            <div class="col-md-8 detail-value" id="remigrate_modal_parent"></div>

                        </div>



                        <h6 class="section-title-custom">
                            IS Coordinator
                        </h6>

                        <hr>

                        <div class="row mb-2">

                            <div class="col-md-4 detail-label">
                                ID
                            </div>

                            <div class="col-md-8 detail-value" id="remigrate_modal_coordinatorid"></div>

                        </div>



                        <div class="row mb-2">

                            <div class="col-md-4 detail-label">
                                Name
                            </div>

                            <div class="col-md-8 detail-value" id="remigrate_modal_coordinatorname"></div>

                        </div>



                        <div class="row mb-3">

                            <div class="col-md-4 detail-label">
                                Email
                            </div>

                            <div class="col-md-8 detail-value" id="remigrate_modal_coordinatoremail"></div>

                        </div>



                        <div class="row mt-4">

                            <div class="col-md-12">

                                <label>
                                    <b>Notes <span class="text-danger">*</span></b>
                                </label>

                                <textarea class="form-control" name="notes" id="remigrate_notes" rows="3" placeholder="Enter Notes" style="background-color: white !important;"></textarea>

                                <span class="text-danger" id="remigrate_notes_error"></span>

                            </div>

                        </div>

                    </div>



                    <div class="modal-footer">

                        <button type="button" class="btn btn-danger" data-dismiss="modal">
                            Close
                        </button>

                        <button type="button" class="btn btn-warning text-white" id="remigrateIsmsBtn">
                            Sail Foundation
                        </button>

                    </div>

                </form>

            </div>

        </div>

    </div>



    <script>
        $(document).ready(function() {

            let selectedJsonData = {};
            let childName = '';

            let remigrationJsonData = {};
            let remigrationChildName = '';

            let savedNotes = {};
            let savedRemigrationNotes = {};


            // TABLE SWITCHING

            // TABLE SWITCHING

            $('.decision-tab-btn').on('click', function() {

                $('.decision-tab-btn').removeClass('active');

                $(this).addClass('active');

                let tableId = $(this).data('table');

                $('.table-section').addClass('d-none');

                $('#' + tableId).removeClass('d-none');



                // DYNAMIC HEADING

                if (tableId == 'decisionTable') {

                    $('#dynamicHeading').text('SAIL Transition Decisions');

                } else if (tableId == 'ismsTable') {

                    $('#dynamicHeading').text('SAIL Transition Review');

                } else if (tableId == 'migration13Table') {

                    $('#dynamicHeading').text('SAIL Transition Review');

                }

            });




            // OPEN MIGRATION MODAL

            $('.openMigrationModal').on('click', function() {

                let enrollment = $(this).data('enrollment');
                $('#modal_enrollment').text(enrollment);

                $('#modal_child').text($(this).data('child'));

                $('#modal_parent').text($(this).data('parent'));

                $('#modal_email').text($(this).data('email'));

                $('#modal_status').text($(this).data('status'));

                $('#modal_dob').text($(this).data('dob'));

                $('#modal_userid').text($(this).data('userid'));

                $('#modal_coordinatorid').text($(this).data('coordinatorid'));

                $('#modal_coordinatorname').text($(this).data('coordinatorname'));

                $('#modal_coordinatoremail').text($(this).data('coordinatoremail'));

                // Restore typed notes if any, else clear
                $('#notes').val(savedNotes[enrollment] || '');

                $('#notes_error').text('');

                selectedJsonData = $(this).data('json');

                childName = $(this).data('child');

            });

            // Save Migration Modal notes on typing
            $(document).on('input', '#notes', function() {
                let enrollment = $('#modal_enrollment').text().trim();
                if (enrollment) {
                    savedNotes[enrollment] = $(this).val();
                }
            });


            // OPEN REMIGRATION MODAL

            $('.openRemigrationModal').on('click', function() {

                let enrollment = $(this).data('enrollment');
                $('#remigrate_modal_enrollment').text(enrollment);

                $('#remigrate_modal_child').text($(this).data('child'));

                $('#remigrate_modal_parent').text($(this).data('parent'));

                $('#remigrate_modal_email').text($(this).data('email'));

                $('#remigrate_modal_dob').text($(this).data('dob'));

                $('#remigrate_modal_userid').text($(this).data('userid'));

                $('#remigrate_modal_coordinatorid').text($(this).data('coordinatorid'));

                $('#remigrate_modal_coordinatorname').text($(this).data('coordinatorname'));

                $('#remigrate_modal_coordinatoremail').text($(this).data('coordinatoremail'));

                // Restore typed notes if any, else clear
                $('#remigrate_notes').val(savedRemigrationNotes[enrollment] || '');

                $('#remigrate_notes_error').text('');

                remigrationJsonData = $(this).data('json');

                remigrationChildName = $(this).data('child');

            });

            // Save Remigration Modal notes on typing
            $(document).on('input', '#remigrate_notes', function() {
                let enrollment = $('#remigrate_modal_enrollment').text().trim();
                if (enrollment) {
                    savedRemigrationNotes[enrollment] = $(this).val();
                }
            });




            // 13+ BUTTON

            $('#migrate13PlusBtn').on('click', function() {

                submitMigrationForm('13plus');

            });




            // ISMS BUTTON (in Migration Modal)

            $('#ismsBtn').on('click', function() {

                submitMigrationForm('isms');

            });



            // ISMS BUTTON (in Remigration Modal)

            $('#remigrateIsmsBtn').on('click', function() {

                submitRemigrationForm();

            });




            function submitMigrationForm(type) {

                let notes = $('#notes').val().trim();

                $('#notes_error').text('');



                if (notes == '') {

                    $('#notes_error').text('Notes field is required');

                    return false;

                }



                selectedJsonData.notes = notes;



                let titleText = '';
                let confirmText = '';
                let buttonText = '';


                if (type == '13plus') {

                    titleText = 'Confirm Transition';

                    confirmText = 'Are you sure you want to move ' + childName + ' to Sail Adolescent?';

                    buttonText = 'Yes, Move';

                } else {

                    titleText = 'Confirm Transition';

                    confirmText = 'Are you sure you want to move ' + childName + ' to Sail Foundation?';

                    buttonText = 'Yes, Move';

                }



                Swal.fire({

                    title: titleText,

                    html: '<div style="font-size:20px;font-weight:500;">' + confirmText + '</div>',

                    icon: 'warning',

                    showCancelButton: true,

                    confirmButtonColor: '#28a745',

                    cancelButtonColor: '#6c757d',

                    confirmButtonText: buttonText,
                    cancelButtonText: 'Cancel'

                }).then((result) => {

                    if (result.isConfirmed) {

                        var jsonData = JSON.stringify(selectedJsonData);

                        $('#migration_json').val(jsonData);

                        $('#migration_type').val(type);

                        $('#migrationForm').submit();

                    }

                });

            }



            function submitRemigrationForm() {

                let notes = $('#remigrate_notes').val().trim();

                $('#remigrate_notes_error').text('');



                if (notes == '') {

                    $('#remigrate_notes_error').text('Notes field is required');

                    return false;

                }



                remigrationJsonData.notes = notes;



                Swal.fire({

                    title: 'Confirm Remigration',

                    html: '<div style="font-size:20px;font-weight:500;">Are you sure you want to remigrate ' +
                        remigrationChildName + ' to ISMS?</div>',

                    icon: 'warning',

                    showCancelButton: true,

                    confirmButtonColor: '#28a745',

                    cancelButtonColor: '#6c757d',

                    confirmButtonText: 'Yes, Remigrate',
                    cancelButtonText: 'Cancel'

                }).then((result) => {

                    if (result.isConfirmed) {

                        var jsonData = JSON.stringify(remigrationJsonData);

                        $('#remigration_json').val(jsonData);

                        $('#remigrationForm').submit();

                    }

                });

            }

        });
    </script>
@endsection
