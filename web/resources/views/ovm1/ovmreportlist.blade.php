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
       RESPONSIVE MOBILE STYLING (No Horizontal Scroll, Auto-Adjusts UI Layout)
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

        /* Sl. No. positioning */
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

        /* Child Name (Primary Display) */
        #align td:nth-of-type(3) {
            display: block !important;
            font-weight: 600 !important;
            font-size: 16px !important;
            color: #2c3e50 !important;
            margin-bottom: 4px !important;
            padding-right: 25px !important;
            order: 1 !important;
        }

        /* OVM ID Display */
        #align td:nth-of-type(2) {
            display: block !important;
            font-size: 13px !important;
            color: #34495e !important;
            margin-bottom: 10px !important;
            order: 2 !important;
        }
        #align td:nth-of-type(2):before {
            content: "OVM ID: ";
            font-weight: 600 !important;
            color: #000 !important;
        }

        /* Hidden in Mobile view until Accordion Expansion */
        #align td:nth-of-type(4),
        #align td:nth-of-type(5),
        #align td:nth-of-type(6),
        #align td:nth-of-type(7) {
            display: none !important;
        }

        /* Dynamic Expand/Collapse Indicator Arrow */
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

        /* Expanded State Fields mapping */
        #align tr.expanded-row td:nth-of-type(4) {
            display: block !important;
            margin-top: 8px !important;
            font-size: 12px !important;
            color: #34495e !important;
            order: 3 !important;
        }
        #align tr.expanded-row td:nth-of-type(4):before {
            content: "Enrollment ID: ";
            font-weight: 600 !important;
            color: #000 !important;
            margin-right: 4px !important;
        }

        #align tr.expanded-row td:nth-of-type(5) {
            display: block !important;
            margin-top: 6px !important;
            font-size: 12px !important;
            color: #34495e !important;
            order: 4 !important;
        }
        #align tr.expanded-row td:nth-of-type(5):before {
            content: "Child ID: ";
            font-weight: 600 !important;
            color: #000 !important;
            margin-right: 4px !important;
        }

        #align tr.expanded-row td:nth-of-type(6) {
            display: block !important;
            margin-top: 6px !important;
            font-size: 12px !important;
            color: #000000 !important;
            order: 5 !important;
        }
        #align tr.expanded-row td:nth-of-type(6):before {
            content: "Status: ";
            font-weight: 600 !important;
            color: #000000 !important;
            margin-right: 4px !important;
        }

        #align tr.expanded-row td:nth-of-type(7) {
            display: flex !important;
            align-items: center !important;
            flex-wrap: wrap !important;
            gap: 10px !important;
            margin-top: 8px !important;
            font-size: 12px !important;
            order: 6 !important;
        }
        
        /* Forces buttons to match same height, size & eliminates rogue shadows */
        #align tr.expanded-row td:nth-of-type(7) a.btn {
            display: inline-flex !important;
            align-items: center !important;
            justify-content: center !important;
            margin-right: 6px !important;
            padding: 6px 12px !important;
            font-size: 13px !important;
            height: 32px !important;
            box-sizing: border-box !important;
            box-shadow: none !important;
            text-shadow: none !important;
        }
        #align tr.expanded-row td:nth-of-type(7) a.btn:after,
        #align tr.expanded-row td:nth-of-type(7) a.btn:before {
            box-shadow: none !important;
            display: none !important;
        }
        #align tr.expanded-row td:nth-of-type(7):before {
            content: "Action: ";
            font-weight: 600 !important;
            color: #000 !important;
            margin-right: 4px !important;
        }

        /* Empty Data Row Fix */
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

        /* DataTables Layout Controls */
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
            text-align: right !important;
            padding-right: 8px !important;
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
        .dataTables_wrapper .dataTables_filter label,
        .dataTables_wrapper .dataTables_length label {
            font-size: 10px !important;
            margin-bottom: 0 !important;
        }
        .dataTables_wrapper .paginate_button {
            font-size: 10px !important;
            padding: 2px 4px !important;
        }
        .dt-buttons .btn,
        .buttons-copy, .buttons-csv, .buttons-excel, .buttons-pdf, .buttons-print {
            font-size: 10px !important;
            padding: 4px 6px !important;
        }
        .card-body h4 {
            font-size: 18px !important;
        }
    }
</style>

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

<div class="main-content">
    <section class="section">
        {{ Breadcrumbs::render('ovmreport') }}
        <div class="section-body mt-2">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-12 text-center mb-3">
                                    <h4 style="color:darkblue;">OVM Report List</h4>
                                </div>
                            </div>

                            <input type="hidden" id="sendReport" name="sendReport">
                            <div class="table-wrapper">
                                <div class="table-responsive searchResultStudent">
                                    <table class="table table-bordered" id="align">
                                        <thead>
                                            <tr>
                                                <th width="50px">Sl. No.</th>
                                                <th>OVM ID</th>
                                                <th>Child Name</th>
                                                <th>Enrollment Id</th>
                                                <th>Child Id</th>
                                                <th>Status</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($rows as $key=>$row)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $row['ovm_meeting_unique'] }}</td>
                                                <td>{{ $row['child_name'] }}</td>
                                                <td>{{ $row['enrollment_id'] }}</td>
                                                <td>{{ $row['child_id'] }}</td>
                                                
                                                <td style="color: #000000 !important;">
                                                    @if(in_array($row['ovm_meeting_id'] , $completed) || $row['status'] == 'Completed')
                                                        Completed
                                                    @else
                                                        @if($row['report_flag'] == 0)
                                                            New
                                                        @elseif($row['report_flag'] == 2)
                                                            Saved
                                                        @elseif($row['report_flag'] == 3)
                                                            Submitted
                                                        @else
                                                            {{ $row['status'] }}
                                                        @endif
                                                    @endif
                                                </td>

                                                <form action="{{route('send_report')}}" method="POST" id="submit_report{{$row['child_id']}}">
                                                    @csrf
                                                    <input type="hidden" value="{{$row['is_coordinator_id']}}" name="is_coordinator_id" id="is_coordinator_id">
                                                    <input type="hidden" value="{{$row['child_id']}}" name="child_id" id="child_id">
                                                    <input type="hidden" value="{{$row['child_name']}}" name="child_name" id="child_name">
                                                </form>

                                                <td class="text-center">
                                                    <form method="POST" action="">
                                                        @php
                                                        $folderPath = $row['child_contact_email'];
                                                        $folderPath1 = $row['child_id'];
                                                        $reportflag = $row['report_flag'];
                                                        if($reportflag == 0 || $reportflag == 2){
                                                            $consent = '/ovm_report/'.$folderPath.'/ovm_report.pdf';
                                                        }else{
                                                            $consent = '/ovm_assessment/'.$folderPath.'/sail_guide.pdf';
                                                        }
                                                        $omd = Crypt::encrypt($row['ovm_meeting_id']);
                                                        @endphp

                                                        <a class="btn btn-labeled btn-warning" style="background: warning !important; border-color:warning !important; color:warning !important" title="Report" href="{{ route('ovmreportview', $omd) }}">
                                                            <span class="btn-label" style="font-size:13px !important;"><i class="fa fa-file-o"></i></span>Report
                                                        </a>
                                                        
                                                        @if(strpos($screen_permission['permissions'], 'Compare') !== false)
                                                            @if($reportflag == 0 || $reportflag == 2)
                                                                <a class="btn btn-primary" title="Conversation Report" data-toggle="modal" data-target="#templates" onclick="getproposaldocument('{{$consent}}')" style="margin-inline:5px"><i class="fa fa-files-o" style="color:white!important"></i></a>
                                                            @else
                                                                <a class="btn btn-info" title="SAIL Guide" data-toggle="modal" data-target="#templates" onclick="getproposaldocument('{{$consent}}')" style="margin-inline:5px"><i class="fa fa-file-pdf-o" style="color:white!important"></i></a>
                                                            @endif
                                                        @endif
                                                        @csrf
                                                    </form>
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

<script src="https://code.jquery.com/jquery-1.7.2.min.js"></script>
<script>
    function getproposaldocument(id) {
        var data = (id);
        console.log(data);
        $("#loading_gif").show();
        var proposaldocuments = "<div class='removeclass' id='modalviewdiv' style=' height:100%'><iframe src='" + data + "' class='document_ifarme_view' style='width:100%; height:100%'></iframe></div>";
        $('.removeclass').remove();
        $('#template').html('');
        $('#template1').html('');
        $("#loading_gif").hide();
        var document = $('#template').append(proposaldocuments);
    };

    function getproposaldocument1(cid) {
        var child_id = cid;
        var child_name = '';
        document.getElementById('sendReport').value = child_id;
        $('#modalviewdiv').html('');
        $("#loading_gif").show();

        $.ajax({
            url: "{{ route('report_download') }}",
            type: 'post',
            data: {
                child_id: child_id,
                child_name: child_name,
                _token: '{{csrf_token()}}'
            },
            error: function() {
                alert('Something is wrong');
            },
            success: function(data) {
                console.log(data.length);
                if (data.length > 0) {
                    $("#loading_gif").hide();
                    var proposaldocuments = "<div class='removeclass' id='modalviewdiv' style=' height:100%'><iframe src='" + data + "' class='document_ifarme_view' style='width:100%; height:100%'></iframe></div>";
                    $('.removeclass').remove();
                    $('#template').html('');
                    $('#template1').html('');
                    var document = $('#template1').append(proposaldocuments);
                }
            }
        });
    };

    function send_form() {
        var f = document.getElementById('sendReport').value;
        document.getElementById('submit_report' + f).submit();
    }

    $(document).ready(function() {
        // Dynamic Collapsible Accordion Logic
        $('#align tbody').on('click', 'tr', function(e) {
            if ($(e.target).closest('a, button, input, form').length) {
                return;
            }
            if ($(window).width() <= 768) {
                $(this).toggleClass('expanded-row');
            }
        });

        // Prevent click bubble-up triggers on mobile devices
        $(document).on('click', '.table-responsive td a.btn, .table-responsive td button', function(e) {
            if($(window).width() <= 768) {
                e.stopPropagation();
            }
        });
    });
</script>
@include('newenrollement.formmodal')
@include('ovm1.formmodal2')
@endsection