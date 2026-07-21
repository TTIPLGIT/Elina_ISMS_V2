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

    /* =========================================================================
       RESPONSIVE MOBILE STYLING (Matches Enrollment List)
       ========================================================================= */
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

        .table-responsive thead {
            display: none !important;
        }

        .table-responsive tbody {
            background: transparent !important;
        }

        #align1 {
            width: 100% !important;
            margin: 0 !important;
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

        /* S.No */
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

        /* Child Name - main visible field */
        #align1 td:nth-of-type(2) {
            display: block !important;
            font-weight: 600 !important;
            font-size: 16px !important;
            color: #2c3e50 !important;
            margin-bottom: 4px !important;
            padding-right: 25px !important;
            order: 1 !important;
        }

        /* Child ID - visible on collapsed row */
        #align1 td:nth-of-type(3) {
            display: block !important;
            font-size: 13px !important;
            color: #34495e !important;
            margin-bottom: 10px !important;
            order: 2 !important;
        }
        #align1 td:nth-of-type(3):before {
            content: "Child ID: ";
            font-weight: 600 !important;
            color: #000 !important;
        }

        /* Hidden fields (Status, Action) */
        #align1 td:nth-of-type(4),
        #align1 td:nth-of-type(5) {
            display: none !important;
        }

        /* Arrow */
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

        /* Expanded row shows hidden fields */
        #align1 tr.expanded-row td:nth-of-type(4) {
            display: block !important;
            margin-top: 8px !important;
            font-size: 13px !important;
            color: #000 !important;
            order: 3 !important;
        }
        #align1 tr.expanded-row td:nth-of-type(4):before {
            content: "Status: ";
            font-weight: 600 !important;
            color: #000 !important;
            margin-right: 4px !important;
        }

        #align1 tr.expanded-row td:nth-of-type(5) {
            display: flex !important;
            align-items: center !important;
            gap: 10px !important;
            margin-top: 8px !important;
            font-size: 13px !important;
            order: 4 !important;
        }
        #align1 tr.expanded-row td:nth-of-type(5):before {
            content: "Action: ";
            font-weight: 600 !important;
            color: #000 !important;
            margin-right: 4px !important;
        }
        
        /* Action icons - no background, green color */
        #align1 tr.expanded-row td:nth-of-type(5) a {
            display: inline-flex !important;
            align-items: center !important;
            margin-right: 8px !important;
            font-size: 16px !important;
            background: transparent !important;
            border: none !important;
            padding: 0 !important;
            text-decoration: none !important;
        }
        #align1 tr.expanded-row td:nth-of-type(5) a i {
            color: green !important;
        }
        .btn-link {
            background: transparent !important;
        }

        /* No data row fix */
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

        /* DataTable controls */
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
            margin-right: 8px !important;
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
            line-height: 32px !important;
            min-width: 60px !important;
            width: 60px !important;
            padding: 0 18px 0 6px !important;
            margin-bottom: 8px !important;
            box-sizing: border-box !important;
        }
        .dataTables_wrapper .dataTables_filter input {
            width: 90px !important;
            height: 24px !important;
            font-size: 10px !important;
            margin-left: 4px !important;
        }
        .dataTables_wrapper .paginate_button {
            font-size: 10px !important;
            padding: 2px 4px !important;
        }
        .dt-buttons .btn {
            font-size: 10px !important;
            padding: 2px 6px !important;
        }

        /* Breadcrumb */
        .breadcrumb {
            font-size: 11px !important;
        }

        /* Heading */
        .card-body h4 {
            font-size: 18px !important;
        }
    }
</style>

<div class="main-content">
    {{ Breadcrumbs::render('ovm_allocation.index') }}

    @if (session('success'))
        <input type="hidden" name="session_data" id="session_data" class="session_data" value="{{ session('success') }}">
        <script type="text/javascript">
            window.onload = function() {
                var message = $('#session_data').val();
                Swal.fire('Success!', message, 'success');
            }
        </script>
    @elseif(session('Saved'))
        <input type="hidden" name="session_data" id="session_data" class="session_data" value="{{ session('Saved') }}">
        <script type="text/javascript">
            window.onload = function() {
                var message = $('#session_data').val();
                Swal.fire('Saved!', message, 'success');
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

    <div class="row">
        <div class="col-12">
            @php
                $authID = session()->get('userID');
                $role_name = DB::select("SELECT ur.role_name,ur.role_id FROM uam_roles AS ur INNER JOIN users as us ON (us.array_roles=ur.role_id) WHERE us.id=$authID");
                $role_id = $role_name[0]->role_id;
            @endphp

            @if(strpos($screen_permission['permissions'], 'Create') !== false)
                <a type="button" href="{{ route('ovm_allocation.create') }}" class="btn btn-labeled btn-info" title="create" style="background: #044a95 !important; border-color:#a9ca !important; color:white !important; margin-top: 0.5rem;">
                    <span class="btn-label" style="font-size:15px !important; padding:8px !important"><i class="fa fa-plus"></i></span>
                    <span style="font-size:15px !important; padding:8px !important">Create</span>
                </a>
            @endif

            <div class="card">
                <div class="card-body">
                    <div class="col-lg-12 text-center mb-3">
                        <h4 style="color:darkblue;">OVM Meeting Scheduling</h4>
                    </div>
                    <div class="table-wrapper">
                        <div class="table-responsive">
                            <table class="table table-bordered" id="align1">
                                <thead>
                                    <tr>
                                        <th>S.No</th>
                                        <th>Child Name</th>
                                        <th>Child ID</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($rows as $row)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $row['child_name'] }}</td>
                                        <td>{{ $row['child_id'] }}</td>
                                        <td>
                                            @if($row['rsvp1'] == "")
                                                {{ $row['meeting_status'] }}
                                            @else
                                                OVM-1 {{ $row['rsvp1'] }}, OVM-2 {{ $row['rsvp2'] }}
                                            @endif
                                        </td>
                                        <td>
                                            @if($row['meeting_status'] == 'Saved')
                                                <a class="btn btn-link" title="Edit" href="{{ route('ovm_allocation.saved', Crypt::encrypt($row['id'])) }}">
                                                    <i class="fas fa-pencil-alt" style="color:green"></i>
                                                </a>
                                            @else
                                                <a class="btn btn-link" title="Edit" href="{{ route('ovm_allocation.edit', Crypt::encrypt($row['id'])) }}">
                                                    <i class="fas fa-pencil-alt" style="color:green"></i>
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

<script src="https://code.jquery.com/jquery-1.7.2.min.js"></script>
<script>
    // Mobile row expansion logic
    $(document).ready(function() {
        $('#align1 tbody').on('click', 'tr', function(e) {
            if ($(e.target).closest('a, button').length) {
                return;
            }
            if ($(window).width() <= 768) {
                $(this).toggleClass('expanded-row');
            }
        });

        $(document).on('click', '#align1 tbody tr td:last-child a', function(e) {
            if ($(window).width() <= 768) {
                e.stopPropagation();
            }
        });
    });

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
        }, function(isConfirm) {
            if (isConfirm) {
                swal.fire("Deleted!", "Data Deleted successfully!", "success");
                var url = $('#' + id).val();
                window.location.href = url;
            } else {
                swal.fire("Cancelled", "Your Data is safe :)", "error");
                e.preventDefault();
            }
        });
    }
</script>
@endsection