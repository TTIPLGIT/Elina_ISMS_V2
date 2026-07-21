@extends('layouts.adminnav')

@section('content')
<style>
    /* ===== Your existing styles (unchanged) ===== */
    input[type=checkbox] { display: inline-block; }
    .no-arrow { -moz-appearance: textfield; }
    .no-arrow::-webkit-inner-spin-button { display: none; }
    .no-arrow::-webkit-outer-spin-button,
    .no-arrow::-webkit-inner-spin-button { -webkit-appearance: none; margin: 0; }
    .nav-tabs { background-color: #0068a7 !important; border-radius: 29px !important; padding: 1px !important; }
    .nav-item.active { background-color: #0e2381 !important; border-radius: 31px !important; height: 100% !important; }
    .nav-link.active { background-color: #0e2381 !important; border-radius: 31px !important; height: 100% !important; }
    :root { --borderWidth: 5px; --height: 24px; --width: 12px; --borderColor: #78b13f; }
    .check { display: inline-block; transform: rotate(50deg); height: var(--height); width: var(--width); border-bottom: var(--borderWidth) solid var(--borderColor); border-right: var(--borderWidth) solid var(--borderColor); }
    .nav-justified { display: flex !important; align-items: center !important; }
    .gender { display: flex; align-items: center; justify-content: space-evenly; }
    .egc { display: flex; border: 1px solid #350756; padding: 8px 25px 8px 8px; align-items: center; justify-content: space-between; }
    .dq { font-size: 16px; width: 80%; font-weight: 600; }
    .answer { width: 15%; display: flex; color: #04092e !important; justify-content: space-around; }
    .questions { color: #000c62 !important; }
    input[type='radio']:checked:after { background-color: #34395e !important; }
    input[type='radio']:after { background-color: #34395e !important; }
    .switch-field { display: flex; }
    .switch-field input { position: absolute !important; clip: rect(0, 0, 0, 0); height: 1px; width: 1px; border: 0; overflow: hidden; }
    .switch-field label { background-color: #e4e4e4; color: rgba(0,0,0,0.6); font-size: 14px; line-height: 1; text-align: center; padding: 8px 16px; margin-right: -1px; border: 1px solid rgba(0,0,0,0.2); box-shadow: inset 0 1px 3px rgba(0,0,0,0.3), 0 1px rgba(255,255,255,0.1); transition: all 0.1s ease-in-out; }
    .switch-field label:hover { cursor: pointer; }
    .switch-field input:checked+label { background-color: #a5dc86; box-shadow: none; }
    .switch-field label:first-of-type { border-radius: 4px 0 0 4px; }
    .switch-field label:last-of-type { border-radius: 0 4px 4px 0; }
    .vl { border-left: 1px solid #350756; height: 40px; }
    .close { color: white; opacity: 1; }

    /* =========================================================================
       MOBILE RESPONSIVE – FIXED EXPANSION (USING !important)
       ========================================================================= */
    @media (max-width: 768px) {
        .main-content, .card, .card-body, .table-wrapper, .table-responsive {
            padding-left: 0 !important;
            padding-right: 0 !important;
            margin-left: 0 !important;
            margin-right: 0 !important;
        }
        .row, .col-12, .col-lg-12 {
            padding-left: 5px !important;
            padding-right: 5px !important;
        }
        .main-content { padding-top: 0 !important; }
        .breadcrumb {
            font-size: 11px !important;
            margin-bottom: 10px !important;
            margin-top: 60px !important;
            margin-left: 10px !important;
        }
        .card { margin-top: 0 !important; }
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

        #align1 thead { display: none !important; }
        #align1 tbody { background: transparent !important; }
        #align1 { width: 100% !important; margin: 0 !important; }

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

        /* Sl.No – absolute */
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

        /* ---- Visible initially: Type (col2) and Name (col3) ---- */
        #align1 td:nth-of-type(2) {
            display: block !important;
            font-size: 13px !important;
            color: #34495e !important;
            order: 2 !important;
            margin-top: 2px !important;
        }
        #align1 td:nth-of-type(3) {
            display: block !important;
            font-weight: 600 !important;
            font-size: 16px !important;
            color: #2c3e50 !important;
            margin-bottom: 2px !important;
            padding-right: 25px !important;
            order: 1 !important;
        }

        /* ---- HIDDEN initially: Version (col4), Status (col5), Action (col6) ---- */
        #align1 td:nth-of-type(4),
        #align1 td:nth-of-type(5),
        #align1 td:nth-of-type(6) {
            display: none !important;
        }

        /* ---- Arrow ---- */
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

        /* ---- EXPANDED: show Version, Status, Action with !important ---- */
        #align1 tr.expanded-row td:nth-of-type(4) {
            display: block !important;
            margin-top: 6px !important;
            font-size: 12px !important;
            color: #34495e !important;
            order: 3 !important;
        }
        #align1 tr.expanded-row td:nth-of-type(4):before {
            content: "Version: ";
            font-weight: 600 !important;
            color: #000 !important;
        }

        #align1 tr.expanded-row td:nth-of-type(5) {
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

        #align1 tr.expanded-row td:nth-of-type(6) {
            display: block !important;
            margin-top: 8px !important;
            order: 5 !important;
            white-space: nowrap !important;
        }
        #align1 tr.expanded-row td:nth-of-type(6):before {
            content: "Action: ";
            font-weight: 600 !important;
            color: #000 !important;
            margin-right: 6px !important;
            flex-shrink: 0 !important;
        }
        #align1 tr.expanded-row td:nth-of-type(6) a {
            display: inline-flex !important;
            align-items: center !important;
            justify-content: center !important;
            margin-right: 0 !important;
            padding: 2px !important;
            font-size: 14px !important;
        }

        /* No records row */
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
        #align1 tr:has(td.dataTables_empty)::after { display: none !important; }

        /* Create button */
        .col-lg-12.text-center .btn-labeled {
            width: 100% !important;
            display: block !important;
            margin: 0.5rem 0 !important;
            font-size: 14px !important;
            padding: 10px !important;
            white-space: normal !important;
        }

        /* DataTable controls – if any */
        .dataTables_wrapper .row:first-child { margin: 0 !important; }
        .dataTables_wrapper .dataTables_length { float: left !important; margin-left: 8px !important; }
        .dataTables_wrapper .dataTables_filter { float: right !important; padding-right: 8px !important; }
        .dataTables_wrapper .dataTables_length,
        .dataTables_wrapper .dataTables_filter,
        .dataTables_wrapper .dataTables_info,
        .dataTables_wrapper .dataTables_paginate { font-size: 10px !important; }
        .dataTables_wrapper .dataTables_length select { font-size: 11px !important; height: 32px !important; width: 60px !important; }
        .dataTables_wrapper .dataTables_filter input { width: 90px !important; height: 24px !important; font-size: 10px !important; }
        .card-body h4 { font-size: 18px !important; }
    }
</style>

<div class="main-content">
    {{ Breadcrumbs::render('asessmentreportmaster.index') }}

    <div class="row justify-content-center">
        <div class="col-md-12">
            <form method="POST" id="registration_form" enctype="multipart/form-data" onsubmit="return false">
                @csrf
                <section class="section">
                    <div class="section-body mt-0">
                        <div class="row">
                            <div class="col-12">
                                <div class="col-lg-12 text-center">
                                    <h4 style="color:darkblue;">Report Templates List</h4>
                                </div>
                                <a type="button" href="{{route('asessmentreportmaster.create')}}" class="btn btn-labeled btn-info" style="background: #044a95 !important; border-color:#a9ca !important; color:white !important;margin-top: 0.5rem;">
                                    <span class="btn-label" style="font-size:15px !important; padding:8px !important"><i class="fa fa-plus"></i></span><span style="font-size:15px !important; padding:8px !important">Create New Template</span></a>
                                <div class="card mt-3">
                                    <div class="card-body">
                                        <div class="table-wrapper">
                                            <div class="table-responsive">
                                                <table class="table table-bordered" id="align1">
                                                    <thead>
                                                        <tr>
                                                            <th>Sl.No</th>
                                                            <th>Type</th>
                                                            <th>Name</th>
                                                            <th>Version</th>
                                                            <th>Status</th>
                                                            <th>Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach($rows as $data)
                                                        <tr>
                                                            <td>{{$loop->iteration}}</td>
                                                            <td>{{$data['report_type']}}</td>
                                                            <td>{{$data['report_name']}}</td>
                                                            <td>{{$data['version']}}</td>
                                                            <td>{{$data['status']}}</td>
                                                            <td>
                                                                <a class="btn btn-link" title="Show" href="{{ route('reports_master.show', \Crypt::encrypt($data['reports_id'])) }}"><i class="fas fa-eye" style="color: green !important"></i></a>
                                                                <a class="btn btn-link" title="Edit" href="{{ route('reports_master.edit', \Crypt::encrypt($data['reports_id'])) }}"><i class="fas fa-pencil-alt" style="color: blue !important"></i></a>
                                                                @if($data['status'] == 'Approved')
                                                                <a class="btn btn-link" title="New Version" href="{{ route('reportmaster.newversion', \Crypt::encrypt($data['reports_id'])) }}"><i class="fa fa-upload" style="color: blue !important"></i></a>
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
            </form>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-1.7.2.min.js"></script>
<script type="application/javascript">
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
        },
        function(isConfirm) {
            if (isConfirm) {
                swal.fire("Deleted!", "Data Deleted successfully!", "success");
                var url = $('#' + id).val();
                window.location.href = url;
            } else {
                swal.fire("Cancelled", "Your file is safe :)", "error");
                e.preventDefault();
            }
        });
    }

    // ===== SIMPLE, GUARANTEED TOGGLE =====
    $(document).ready(function() {
        // Attach click directly to each row
        $('#align1 tbody tr').on('click', function(e) {
            // Ignore if the click was on an <a> tag (action links)
            if ($(e.target).closest('a').length) {
                return;
            }
            // Toggle the expanded class
            $(this).toggleClass('expanded-row');
            // Optional: log for debugging
            console.log('Toggled row:', $(this).hasClass('expanded-row'));
            // You can uncomment the next line to see an alert for testing
            // alert('Row clicked!');
        });
    });
</script>

@endsection