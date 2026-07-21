@extends('layouts.adminnav')

@section('content')
<style>
    #frname {
        color: red;
    }

    .form-control {
        background-color: #ffffff !important;
    }

    .is-coordinate {
        justify-content: center;
    }

    .centerid {
        width: 100%;
        text-align: center;
    }

    #item_no_label,
    #item_label {
        text-transform: capitalize !important;
    }

    /* Tabs styling */
    #tabs {
        overflow: hidden;
        width: 100%;
        margin: 0;
        flex-wrap: nowrap;
        padding: 0;
        list-style: none;
        font-size: 16px !important;
    }

    #tabs li {
        float: left;
        margin: 0 .5em 0 0;
    }

    #tabs a {
        color: white !important;
        position: relative;
        background: #3e86bd;
        float: left;
        text-decoration: none;
        text-shadow: 0 1px 0 rgba(255, 255, 255, .8);
        border-radius: 5px 0 0 0;
        box-shadow: 0 2px 2px rgba(0, 0, 0, .4);
    }

    #tabs a:hover,
    #tabs a:hover::after,
    #tabs a:focus,
    #tabs a:focus::after {
        background: #a9cadb;
    }

    #tabs a:focus {
        outline: 0;
    }

    #tabs a::after {
        content: '';
        position: absolute;
        z-index: 1;
        top: 0;
        right: -.5em;
        bottom: 0;
        width: 1em;
        background: #3e86bd;
        box-shadow: 2px 2px 2px rgba(0, 0, 0, .4);
        transform: skew(10deg);
        border-radius: 0 5px 0 0;
    }

    #tabs #current a,
    #tabs #current a::after {
        background: #265077;
        z-index: 3;
        color: white !important;
    }

    .form-control:disabled,
    .form-control[readonly] {
        background-color: #e9ecef !important;
    }

    textarea {
        resize: none;
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
        }

        /* Hide table headers on mobile */
        .searchResultStudent thead {
            display: none !important;
        }

        /* Accordion Container Overhaul */
        #align1,
        #align {
            width: 100% !important;
            margin: 0 !important;
            border: none !important;
            display: block !important;
        }

        #align1 tbody, 
        #align tbody {
            display: block !important;
            width: 100% !important;
        }

        /* Card Row Setup */
        #align1 tr,
        #align tr {
            display: block !important;
            position: relative !important;
            width: 100% !important;
            margin: 12px 0 !important;
            padding: 14px 40px 14px 45px !important; /* Left space for Serial No, Right for Arrow */
            border: 1px solid #e0e0e0 !important;
            border-radius: 8px !important;
            background: #ffffff !important;
            box-shadow: 0 2px 5px rgba(0,0,0,0.06) !important;
            box-sizing: border-box !important;
            cursor: pointer !important;
            height: auto !important; /* Forces row to expand naturally */
            min-height: 0 !important; /* Clears blocking heights */
            overflow: hidden !important;
        }

        #align1 tr.expanded-row,
        #align tr.expanded-row {
            background: #fafafa !important;
            border-color: #bce0fd !important;
        }

        /* Standardize Table Cells as Blocks */
        #align1 td,
        #align td {
            display: block !important;
            border: none !important;
            padding: 0 !important;
            text-align: left !important;
            white-space: normal !important;
            width: 100% !important;
            background: transparent !important;
            height: auto !important;
        }

        /* Absolute placement for Serial Number only */
        #align1 td:nth-of-type(1),
        #align td:nth-of-type(1) {
            position: absolute !important;
            left: 14px !important;
            top: 14px !important;
            width: 25px !important;
            font-weight: bold !important;
            font-size: 13px !important;
            color: #265077 !important;
        }

        /* Main Row Headers (Always visible) */
        #align1 td:nth-of-type(2),
        #align td:nth-of-type(2) {
            font-weight: 600 !important;
            font-size: 14px !important;
            color: #2c3e50 !important;
            padding-right: 5px !important;
            line-height: 1.4 !important;
        }

        /* Target Hidden Data Elements to Toggle Safely */
        #align1 td:nth-of-type(3),
        #align td:nth-of-type(3),
        #align1 td:nth-of-type(4),
        #align td:nth-of-type(4) {
            display: none !important;
        }

        /* Accordion Chevron Icon Rules */
        #align tr:after,
        #align1 tr:after {
            content: '\f054';
            font-family: 'FontAwesome';
            position: absolute;
            right: 16px;
            top: 15px;
            color: #999;
            transition: transform 0.3s ease;
            z-index: 10;
            font-size: 12px;
        }

        #align tr.expanded-row:after,
        #align1 tr.expanded-row:after {
            transform: rotate(90deg) !important;
        }

        /* Expanded State Block Structuring - Prevents text overlaps */
        #align1 tr.expanded-row td:nth-of-type(3) {
            display: block !important;
            margin-top: 10px !important;
            font-size: 13px !important;
            color: #555555 !important;
            line-height: 1.5 !important;
        }

        #align tr.expanded-row td:nth-of-type(3) {
            display: block !important;
            margin-top: 10px !important;
        }

        #align tr.expanded-row td:nth-of-type(3):before {
            content: "Progress: ";
            font-weight: 600;
            color: #000;
            display: block;
            margin-bottom: 4px;
            font-size: 12px;
        }

        /* Expanded Action Alignment Block Setup */
        #align1 tr.expanded-row td:nth-of-type(4),
        #align tr.expanded-row td:nth-of-type(4) {
            display: block !important;
            margin-top: 12px !important;
            padding-top: 10px !important;
            border-top: 1px dashed #e4e4e4 !important;
        }

        #align1 tr.expanded-row td:nth-of-type(4):before,
        #align tr.expanded-row td:nth-of-type(4):before {
            content: "Action: ";
            font-weight: 600;
            color: #000;
            display: inline-block;
            margin-bottom: 6px;
            font-size: 12px;
            width: 100%;
        }

        /* Ensure Action Elements Render Well inside Card */
        #align1 tr.expanded-row td:nth-of-type(4) a,
        #align tr.expanded-row td:nth-of-type(4) a {
            display: inline-block !important;
            text-align: center !important;
            margin-top: 2px;
        }

        /* Progress Bar sizing fix */
        .progress {
            height: 22px !important;
            margin: 4px 0 !important;
            border-radius: 4px !important;
            background-color: #f0f0f0 !important;
        }
        
        .progress-bar {
            line-height: 22px !important;
            font-size: 11px !important;
        }

        /* Form spacing and buttons updates */
        .form-group {
            margin-bottom: 12px;
        }
        
        .btn {
            font-size: 11px;
            padding: 6px 12px;
        }
        
        .row.text-center .col-md-12 {
            display: flex;
            justify-content: center;
            gap: 8px;
            flex-wrap: wrap;
        }

        /* DataTables Layout tweaks */
        .dataTables_wrapper .dataTables_length,
        .dataTables_wrapper .dataTables_filter {
            font-size: 10px;
        }
        .dataTables_wrapper .dataTables_filter input {
            width: 120px;
            height: 28px;
            font-size: 10px;
        }
        .dataTables_wrapper .dataTables_length select {
            font-size: 10px;
            height: 28px;
        }
        .dataTables_wrapper .dataTables_length {
            float: left !important;
            width: 45% !important;
            text-align: left !important;
            margin-bottom: 10px !important;
        }
        .dataTables_wrapper .dataTables_filter {
            float: right !important;
            width: 55% !important;
            text-align: right !important;
            margin-bottom: 10px !important;
        }
        .dataTables_wrapper .dataTables_filter label {
            display: flex !important;
            justify-content: flex-end !important;
            align-items: center !important;
        }
        .dataTables_wrapper .dataTables_filter input {
            width: 110px !important;
            margin-left: 5px !important;
        }
        .dataTables_wrapper:after {
            content: "";
            display: block;
            clear: both;
        }
    }
</style>

<div class="main-content">
    <section class="section">
        {{ Breadcrumbs::render('sail.status.edit',$rows[0]['enrollment_id']) }}

        <div class="section-body mt-1">
            <h5 class="text-center" style="color:darkblue">Sail Reallocation (Coordinator) Screen</h5>
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <form action="{{route('sail.complete',$rows[0]['enrollment_id'])}}" method="POST" id="submitform" name="submitform" enctype="multipart/form-data">
                                {{ csrf_field() }}
                                @method('PUT')
                                <div class="row is-coordinate">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="control-label required">Enrollment Number</label>
                                            <input class="form-control" name="enrollment_child_num" value="{{ $rows[0]['enrollment_child_num']}}" placeholder="Enrollment ID" readonly>
                                        </div>
                                    </div>
                                    <input type="hidden" value="{{ $rows[0]['enrollment_id']}}" name="enrollment_id">
                                    <input type="hidden" value="{{$rows[0]['user_id']}}" id="user_id" name="user_id">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="control-label required">Child ID</label>
                                            <input class="form-control" type="text" id="child_id" name="child_id" value="{{ $rows[0]['child_id']}}" readonly>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="control-label required">Child Name</label>
                                            <input class="form-control" type="text" id="child_name" name="child_name" value="{{ $rows[0]['child_name']}}" readonly>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="control-label required">IS Coordinator 1</label>
                                            <select class="form-control" id="is_1" name="is_1" required onchange="removeSelectedOption('is_1', 'is_2')">
                                                @foreach($iscoordinators as $row)
                                                    @if($rows[0]['is_coordinator1']['id'] == $row['id'])
                                                        <option value="{{$row['id']}}" selected>{{$row['name']}}</option>
                                                    @else
                                                        <option value="{{$row['id']}}">{{$row['name']}}</option>
                                                    @endif
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="control-label required">IS Coordinator 2</label>
                                            <select class="form-control" id="is_2" name="is_2" required onchange="removeSelectedOption('is_2', 'is_1')">
                                                @if($rows[0]['is_coordinator2'] != null)
                                                    @foreach($iscoordinators as $row)
                                                        @if($rows[0]['is_coordinator2']['id'] == $row['id'])
                                                            <option value="{{$row['id']}}" selected>{{$row['name']}}</option>
                                                        @else
                                                            <option value="{{$row['id']}}">{{$row['name']}}</option>
                                                        @endif
                                                    @endforeach
                                                @else
                                                    <option value="">Select</option>
                                                    @foreach($iscoordinators as $row)
                                                        <option value="{{$row['id']}}">{{$row['name']}}</option>
                                                    @endforeach
                                                @endif
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="control-label required">Payment Status</label>
                                            @if($payment[0]['payment_status'] == 'New')
                                                <input class="form-control" type="text" id="payment_status" name="payment_status" value="Pending" readonly>
                                            @else
                                                <input class="form-control" type="text" id="payment_status" name="payment_status" value="{{$payment[0]['payment_status']}}" readonly>
                                            @endif
                                        </div>
                                    </div>
                                    <input type="hidden" id="action_btn" name="action_btn">
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="row text-center" style="margin: 15px 0;">
                    <div class="col-md-12">
                        <button type="button" id="closeBtn" class="btn btn-info" onclick="submitformaction('Completed')">Close</button>
                        <button type="button" id="updateBtn" class="btn btn-success" onclick="submitformaction('Submitted')">Update</button>
                        <a href="{{ url()->previous() }}" class="btn btn-danger">Cancel</a>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="tile" id="tile-1" style="margin-top:10px !important; margin-bottom:15px !important;">
                                    <ul class="nav nav-tabs nav-justified" id="tabs" role="tablist">
                                        <li class="nav-items navv" style="flex-basis: 1 !important;">
                                            <a class="nav-link active" id="tab1-link" data-tab="tab1" href="javascript:void(0);"><b>Activity</b></a>
                                        </li>
                                        <li class="nav-items navv" style="flex-basis: 1 !important;">
                                            <a class="nav-link" id="tab2-link" data-tab="tab2" href="javascript:void(0);"><b>Questionnaire Forms</b></a>
                                        </li>
                                    </ul>
                                </div>
                                <div id="content">
                                    <div id="tab1" class="tab-content" style="display:block;">
                                        <div class="table-wrapper">
                                            <div class="table-responsive searchResultStudent">
                                                <table class="table table-bordered" id="align1">
                                                    <thead>
                                                        <tr>
                                                            <th>Sl.No</th>
                                                            <th>Activity Name</th>
                                                            <th>Description</th>
                                                            <th>Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach($video as $key=>$data2)
                                                        <tr>
                                                            <td>{{ $loop->iteration }}</td>
                                                            <td>{{ $data2['activity_name']}}</td>
                                                            <td>{{ $data2['description']}}</td>
                                                            <td>
                                                                <a class="btn btn-link" title="View Activity" target="_blank" href="{{$data2['video_link']}}">
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
                                    <div id="tab2" class="tab-content" style="display:none;">
                                        <div class="table-wrapper">
                                            <div class="table-responsive searchResultStudent">
                                                <table class="table table-bordered" id="align">
                                                    <thead>
                                                        <tr>
                                                            <th>Sl.No</th>
                                                            <th>Questionnaire Name</th>
                                                            <th style="width: 30%">Status</th>
                                                            <th>Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach($questionnaire as $data)
                                                        <tr>
                                                            <td>{{$loop->iteration}}</td>
                                                            <td>{{$data['questionnaire_name']}}</td>
                                                            <td>
                                                                <div class="progress" style="height: 25px;">
                                                                    <div class="progress-bar" role="progressbar" id="{{$data['questionnaire_initiation_id']}}" aria-valuemax="100" style="font-weight: bolder; color: black;"></div>
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <a class="btn" style="cursor: pointer;" id="a{{$data['questionnaire_initiation_id']}}" href="{{ route('questionnaire_for_user.form.edit', \Crypt::encrypt($data['questionnaire_initiation_id'])) }}"></a>
                                                            </td>
                                                        </tr>
                                                        @endforeach
                                                        <input type="hidden" class="cfn" id="fn" value="0">
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
            </div>
        </div>
    </section>
</div>

<script>
    // Submit form with action type
    function submitformaction(a) {
        document.getElementById('action_btn').value = a;
        document.getElementById('submitform').submit();
    }

    // Tabs switching
    $(document).ready(function() {
        $("#tab1-link").click(function(e) {
            e.preventDefault();
            $("#tab1").show();
            $("#tab2").hide();
            $("#tab1-link").addClass("active");
            $("#tab2-link").removeClass("active");
        });
        $("#tab2-link").click(function(e) {
            e.preventDefault();
            $("#tab2").show();
            $("#tab1").hide();
            $("#tab2-link").addClass("active");
            $("#tab1-link").removeClass("active");
        });
    });

    // Remove selected coordinator from the other dropdown (avoid duplicate selection)
    function removeSelectedOption(selectedId, otherId) {
        var selectedOption = document.getElementById(selectedId).value;
        var otherSelect = document.getElementById(otherId);
        for (let i = 0; i < otherSelect.options.length; i++) {
            if (otherSelect.options[i].value === selectedOption) {
                otherSelect.remove(i);
                break;
            }
        }
    }
    $(document).ready(function() {
        removeSelectedOption('is_1', 'is_2');
        removeSelectedOption('is_2', 'is_1');
    });

    // Progress bar filling for questionnaires
    var progress_status = <?php echo json_encode($questionnaire); ?>;
    for (i = 0; i < progress_status.length; i++) {
        var a = progress_status[i];
        var percent = a.question_progress;
        var id = a.questionnaire_initiation_id;
        var no_questions = a.no_questions;
        var per = ((percent / no_questions) * 100).toFixed(3);
        var title = 'Completed '.concat(percent) + ' of '.concat(no_questions);
        var idi = '#' + id;
        var aidi = 'a' + id;
        $(idi).attr('aria-valuenow', title).css('width', per + '%');
        var div = document.getElementById(id);
        div.innerHTML += percent + ' / ' + no_questions;
        if (per == 0) {
            document.getElementById(aidi).innerHTML = "New";
            document.getElementById(aidi).classList.add('btn-danger');
        } else if (per == 100) {
            document.getElementById(aidi).innerHTML = "View";
            document.getElementById(aidi).classList.add('btn-success');
        } else {
            document.getElementById(aidi).classList.add('btn-primary');
            document.getElementById(aidi).innerHTML = "Edit";
        }
        if (per < 25) {
            document.getElementById(id).classList.add('bg-danger');
        } else if (per < 80) {
            document.getElementById(id).classList.add('bg-warning');
        } else if (per >= 80) {
            document.getElementById(id).classList.add('bg-success');
        }
    }

    $(document).ready(function () {
        $('#align tbody, #align1 tbody').on('click', 'tr', function(e) {
            if ($(e.target).closest('a,button,.btn,i,.fas,.fa').length) {
                return;
            }

            if ($(window).width() <= 768) {
                $(this)
                    .toggleClass('expanded-row')
                    .siblings()
                    .removeClass('expanded-row');
            }
        });
    });
</script>

@include('newenrollement.formmodal')
@endsection