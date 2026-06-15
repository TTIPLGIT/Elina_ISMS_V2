@extends('layouts.adminnav')
@section('content')

<style>
    /* ========== Mobile Accordion (only <=768px) ========== */
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

        .table-responsive table,
        .table-responsive thead,
        .table-responsive tbody,
        .table-responsive th,
        .table-responsive td {
            display: block !important;
            width: 100% !important;
        }

        .table-responsive thead {
            display: none !important;
        }

        .table-responsive tbody {
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

        /* S.No column */
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

        /* Professionals Name column */
        #align td:nth-of-type(2) {
            display: block !important;
            font-weight: 600 !important;
            font-size: 16px !important;
            color: #2c3e50 !important;
            margin-bottom: 4px !important;
            padding-right: 25px !important;
            order: 1 !important;
        }

        /* Hidden Fields (Unexpanded state) */
        #align td:nth-of-type(3),
        #align td:nth-of-type(4),
        #align td:nth-of-type(5),
        #align td:nth-of-type(6),
        #align td:nth-of-type(7) {
            display: none !important;
        }

        /* FontAwesome Arrow Icon */
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

        /* Email Address field */
        #align tr.expanded-row td:nth-of-type(3) {
            display: block !important;
            margin-top: 8px !important;
            font-size: 12px !important;
            color: #34495e !important;
            order: 2 !important;
        }

        #align tr.expanded-row td:nth-of-type(3):before {
            content: "Email Address: ";
            font-weight: 600 !important;
            color: #000 !important;
            margin-right: 4px !important;
        }

        /* Contact Number field */
        #align tr.expanded-row td:nth-of-type(4) {
            display: block !important;
            margin-top: 6px !important;
            font-size: 12px !important;
            color: #34495e !important;
            order: 3 !important;
        }

        #align tr.expanded-row td:nth-of-type(4):before {
            content: "Contact number: ";
            font-weight: 600 !important;
            color: #000 !important;
            margin-right: 4px !important;
        }

        /* Type of Service field */
        #align tr.expanded-row td:nth-of-type(5) {
            display: block !important;
            margin-top: 6px !important;
            font-size: 12px !important;
            color: #34495e !important;
            order: 4 !important;
        }

        #align tr.expanded-row td:nth-of-type(5):before {
            content: "Type of Service: ";
            font-weight: 600 !important;
            color: #000 !important;
            margin-right: 4px !important;
        }

        /* Charge Per Session field */
        #align tr.expanded-row td:nth-of-type(6) {
            display: block !important;
            margin-top: 6px !important;
            font-size: 12px !important;
            color: #34495e !important;
            order: 5 !important;
        }

        #align tr.expanded-row td:nth-of-type(6):before {
            content: "Charge Per Session: ";
            font-weight: 600 !important;
            color: #000 !important;
            margin-right: 4px !important;
        }

        /* Action Buttons field */
        #align tr.expanded-row td:nth-of-type(7) {
            display: flex !important;
            align-items: center !important;
            gap: 10px !important;
            margin-top: 8px !important;
            font-size: 12px !important;
            order: 6 !important;
        }

        #align tr.expanded-row td:nth-of-type(7):before {
            content: "Action: ";
            font-weight: 600 !important;
            color: #000 !important;
            margin-right: 4px !important;
        }

        #align tr.expanded-row td:nth-of-type(7) a {
            display: inline-flex !important;
            align-items: center !important;
            margin-right: 8px !important;
            font-size: 15px !important;
        }

        /* Action icons styling */
        #align td a {
            font-size: 12px !important;
            padding: 2px !important;
        }

        /* Empty Records Handle */
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

        /* Heading */
        .card-body h4 {
            font-size: 18px !important;
        }

        /* ==========================================
           DATATABLES CONTROLS (Entries & Search Box Fixes)
           ========================================== */
        .dataTables_wrapper .row:first-child {
            margin: 0 !important;
            display: flex !important;
            justify-content: space-between !important;
            align-items: center !important;
            width: 100% !important;
        }

        .dataTables_wrapper .row:first-child > div {
            flex: 0 0 auto !important;
            width: auto !important;
            max-width: 50% !important;
        }

        .dataTables_wrapper .dataTables_length {
            float: left !important;
            margin-left: 8px !important;
            text-align: left !important;
        }

        .dataTables_wrapper .dataTables_filter {
            float: right !important;
            margin-right: 8px !important;
            text-align: right !important;
        }

        /* Reduce font sizes matching the reference screen */
        .dataTables_wrapper .dataTables_length,
        .dataTables_wrapper .dataTables_filter,
        .dataTables_wrapper .dataTables_info,
        .dataTables_wrapper .dataTables_paginate {
            font-size: 10px !important;
        }

        /* Entries selection dropdown sizing logic */
        .dataTables_wrapper .dataTables_length select {
            font-size: 11px !important;
            height: 32px !important;
            line-height: 32px !important;
            min-width: 60px !important;
            width: 60px !important;
            padding: 0 18px 0 6px !important;
            margin-bottom: 8px !important;
            box-sizing: border-box !important;
            display: inline-block !important;
        }

        /* Search inputs sizing logic */
        .dataTables_wrapper .dataTables_filter input {
            width: 90px !important;
            height: 24px !important;
            font-size: 10px !important;
            margin-left: 4px !important;
            display: inline-block !important;
        }

        .dataTables_wrapper .dataTables_filter label,
        .dataTables_wrapper .dataTables_length label {
            font-size: 10px !important;
            margin-bottom: 0 !important;
        }

        .dataTables_wrapper .paginate_button {
            font-size: 10px !important;
            padding: 2px 4px !important;
        }
    }
</style>

<div class="main-content">
    <div class="row">
        <div class="col-12">
            {{ Breadcrumbs::render('servicelist') }}
            <div class="card">
                <div class="card-body">
                    <div class="col-lg-12 text-center mb-3">
                        <h4 style="color:darkblue;">Enrolled Professionals List</h4>
                    </div>
                    <div class="table-wrapper">
                        <div class="table-responsive">
                            <table class="table table-bordered" id="align">
                                <thead>
                                    <tr>
                                        <th>S.No</th>
                                        <th>Professionals Name</th>
                                        <th>Email Address</th>
                                        <th>Contact number</th>
                                        <th>Type of Service</th>
                                        <th>Charge Per Session</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($rows as $key=>$row)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $row['name'] }}</td>
                                        <td>{{ $row['email_address'] }}</td>
                                        <td>{{ $row['phone_number'] }}</td>
                                        <td>{{ $row['type_of_service'] }}</td>
                                        <td>{{ $row['profession_charges_per_session'] }}</td>
                                        <td>
                                            @php $row['id'] = Crypt::encrypt($row['id']); @endphp
                                            <a class="btn btn-link" title="show" href="{{ route('serviceproviderview', $row['id']) }}">
                                                <i class="fas fa-eye" style="color:green"></i>
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

<script src="https://code.jquery.com/jquery-1.7.2.min.js"></script>
<script>
    // Mobile Dynamic Collapsible Accordion Row View Click Handler
    $(document).ready(function() {
        $('#align tbody').on('click', 'tr', function(e) {
            // Do not trigger accordion if clicking inside actual links/buttons
            if ($(e.target).closest('a, button, input').length) {
                return;
            }
            if ($(window).width() <= 768) {
                $(this).toggleClass('expanded-row');
            }
        });
    });
</script>

@endsection