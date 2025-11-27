@extends('layouts.adminnav')

@section('content')
<style>
    #frname {
        color: red;
    }

    .form-control {
        background-color: #ffffff !important;
    }

    .form-control:disabled,
    .form-control[readonly] {
        background-color: #e9ecef !important;
        opacity: 1;
    }

    .is-coordinate {
        justify-content: center;
    }

    .centerid {
        width: 100%;
        text-align: center;
    }

    .select2-container {
        width: 100% !important;
    }

    .select2-container--default .select2-selection--multiple .select2-selection__choice {
        color: black !important;
    }
</style>



<div class="main-content">
    {{ Breadcrumbs::render('ovm_allocation.edit' , $rows[0]['id'] ) }}
    <!-- Main Content -->
    <section class="section">
        <div class="section-body mt-1">
            <h5 class="text-center" style="color:darkblue"> OVM Alteration Screen</h5>
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            @foreach($rows as $key=>$row)
                            <form action="{{route('ovm_allocation.update', $row['id'])}}" method="POST" id="ovm_meet" enctype="multipart/form-data">
                                {{ csrf_field() }}
                                @method('PUT')
                                <div class="row is-coordinate">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="control-label required">Enrollment ID</label>
                                            <input class="form-control" name="enrollment_child_num" value="{{ $row['enrollment_child_num']}}" readonly required>
                                        </div>
                                    </div>
                                    <input type="hidden" id="user_id" name="user_id" value="{{$row['user_id']}}">
                                    <input type="hidden" id="meeting_status" name="meeting_status" value="{{ $row['meeting_status']}}">
                                    <input type="hidden" id="reschedule_count" name="reschedule_count" value="{{ $row['reschedule_count']}}">

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="control-label required">Child ID</label>
                                            <input class="form-control" type="text" id="child_id" name="child_id" value="{{ $row['child_id']}}" readonly placeholder="OVM1 Meeting" required autocomplete="off">
                                        </div>
                                    </div>



                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="control-label required">Child Name</label>
                                            <input class="form-control" type="text" id="child_name" name="child_name" value="{{ $row['child_name']}}" readonly placeholder="Enter Name" required autocomplete="off">
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group ">
                                            <label class="control-label">IS Co-ordinator-1<span class="error-star" style="color:red;">*</span></label>
                                            <div style="display: flex;">
                                                <select class="form-control" id="is_coordinator1" name="is_coordinator1" readonly style="pointer-events: none !important;">
                                                    <option>Select-IS-Coordinator-1</option>
                                                    @foreach($iscoordinators as $key=>$row1)
                                                    <option value="{{$row1['id']}}" {{ $rows[0]['is_coordinator1'] == $row1['id'] ? 'selected' : '' }}>{{ $row1['name']}}</option>
                                                    @endforeach
                                                </select>
                                                <button style="display: none;" id="co_one" title="Availability Calendar" class="btn" data-toggle="modal" data-target="#calModal" type="button">
                                                    <i style="color: blue;font-size: 20px;" class="fa fa-calendar" aria-hidden="true"></i></button>
                                            </div>
                                            <input type="hidden" id="is_coordinator1old" data-attr='<?php echo json_encode($iscoordinators); ?>'>
                                            <input type="hidden" id="is_coordinator1current">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="control-label">IS Co-ordinator-2</label>
                                            <div style="display: flex;">
                                                <select class="form-control" id="is_coordinator2" name="is_coordinator2" onchange="iscoordinatorfn(event)" readonly style="pointer-events: none !important;">
                                                    <option>Select-IS-Coordinator-2</option>
                                                    @foreach($iscoordinators as $key=>$row1)
                                                    <option value="{{$row1['id']}}" {{ $rows[0]['is_coordinator2'] == $row1['id'] ? 'selected' : '' }}>{{ $row1['name']}}</option>
                                                    @endforeach
                                                </select>
                                                <button style="display: none;" id="co_two" title="Availability Calendar" class="btn" data-toggle="modal" data-target="#calModal2" type="button">
                                                    <i style="color: blue;font-size: 20px;" class="fa fa-calendar" aria-hidden="true"></i></button>
                                            </div>
                                            <input type="hidden" id="is_coordinator2old" data-attr='<?php echo json_encode($iscoordinators); ?>'>
                                            <input type="hidden" id="is_coordinator2current">
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="control-label">Status</label>
                                            <div style="display: flex;">
                                                @if($row['rsvp1'] =='')
                                                <select class="form-control" id="status" name="status" style="display: block;" onchange="coonotes()">
                                                    <option value="">Select Status</option>
                                                    <option value="Accept">Force Acceptance</option>
                                                    <option value="Declined">Declined</option>
                                                    <!-- <option value="Reschedule">Reschedule</option> -->
                                                </select>
                                                @elseif($row['rsvp1'] =='Accept' && $row['rsvp2'] =='Accept')
                                                <select class="form-control" id="status" name="status" style="display: block;" onchange="coonotes()">
                                                    <option value="">Select Status</option>
                                                    <option value="Accept" selected>Force Acceptance</option>
                                                    <option value="Declined">Declined</option>
                                                </select>
                                                @elseif($row['rsvp1'] =='Accept' && $row['rsvp2'] =='Reschedule' && $row['reschedule_count'] < 2) <select class="form-control" id="status" name="status" style="display: block;" onchange="coonotes()">
                                                    <option value="" selected>Select Status</option>
                                                    <option value="Accept">Force Acceptance</option>
                                                    <option value="Declined">Declined</option>
                                                    <option value="Reschedule" selected>Reschedule</option>
                                                    </select>
                                                    @elseif($row['rsvp1'] =='Declined')
                                                    <select class="form-control" id="status" name="status" style="display: block;" disabled>
                                                        <option value="">Select Status</option>
                                                        <option value="Accept">Force Acceptance</option>
                                                        <option value="Declined" selected>Declined</option>
                                                    </select>
                                                    @elseif($row['rsvp1'] == 'Reschedule' && $row['reschedule_count'] < 2) <select class="form-control" id="status" name="status" style="display: block;" onchange="coonotes()">
                                                        <option value="">Select Status</option>
                                                        <option value="Accept">Force Acceptance</option>
                                                        <option value="Declined">Declined</option>
                                                        <option value="Reschedule" selected>Reschedule</option>
                                                        </select>
                                                        @elseif($row['rsvp2'] == 'Reschedule' && $row['reschedule_count'] < 2) <select class="form-control" id="status" name="status" style="display: block;" onchange="coonotes()">
                                                            <option value="">Select Status</option>
                                                            <option value="Accept">Force Acceptance</option>
                                                            <option value="Declined">Declined</option>
                                                            <option value="Reschedule" selected>Reschedule</option>
                                                            </select>
                                                            @elseif($row['reschedule_count'] == 2)
                                                            <select class="form-control" id="status" name="status" style="display: block;" onchange="coonotes()">
                                                                <option value="">Select Status</option>
                                                                <option value="Reschedule" selected>Reschedule</option>
                                                                <option value="Declined">Declined</option>
                                                                <option value="Accept">Force Acceptance</option>
                                                                <option value="Forced Closure">Force Closure</option>
                                                            </select>
                                                            @elseif($row['rsvp1'] == 'Accept' && $row['rsvp2'] == 'Reschedule' && $row['reschedule_count'] > 2) <select class="form-control" id="status" name="status" style="display: block;" onchange="coonotes()">
                                                            <option value="">Select Status</option>
                                                            <option value="Accept">Force Acceptance</option>
                                                            <option value="Declined">Declined</option>
                                                            </select>
                                                            @elseif($row['rsvp1'] == 'Reschedule' &&$row['rsvp2'] == 'Accept' && $row['reschedule_count'] > 2) <select class="form-control" id="status" name="status" style="display: block;" onchange="coonotes()">
                                                            <option value="">Select Status</option>
                                                            <option value="Accept">Force Acceptance</option>
                                                            <option value="Declined">Declined</option>
                                                            </select>
                                                            @elseif($row['rsvp1'] == 'Forced Closure')
                                                            <select class="form-control" id="status" name="status" style="display: block;" onchange="coonotes()">
                                                                <option value="">Select Status</option>
                                                                <option value="Accept">Force Acceptance</option>
                                                                <option value="Declined">Declined</option>
                                                                <option value="Forced Closure" selected>Force Closure</option>
                                                            </select>

                                                            @endif

                                            </div>

                                        </div>
                                    </div>

                                    @if(($row['cnotes'] != "")&&($row['reschedule_count'] < 2)) <div class="col-sm-12">
                                        <div class="form-group">
                                            <label class="control-label">Coordinator Notes</label>
                                            <textarea class="form-control" name="coord_notes">{{$row['cnotes']}}</textarea>
                                        </div>
                                </div>

                                @elseif(($row['rsvp1'] == 'Reschedule' || $row['rsvp2'] == 'Reschedule') && ($row['reschedule_count'] < 2)) <div class="col-sm-12 " style="display: block !important;">
                                    <div class="form-group">
                                        <label class="control-label">Coordinator Notes</label>
                                        <textarea class="form-control" class="coord_notes" name="coord_notes"></textarea>
                                    </div>
                        </div>
                        @else
                        <div class="col-sm-12 coord_notes" style="display: none !important;">
                            <div class="form-group">
                                <label class="control-label">Coordinator Notes</label>
                                <textarea class="form-control" class="coord_notes" name="coord_notes"></textarea>
                            </div>
                        </div>
                        @endif

                        <!-- <select class="form-control" id="status" name="status">
                                                    @if($row['rsvp1'] =='')
                                                    <option>Select Status</option>

                                                    <option value="Accepted">Accepted</option>
                                                    <option value="Declined">Declined</option>
                                                    @elseif($row['rsvp1'] =='Accepted')
                                                    <option>Select Status</option>
                                                    <option value="Accepted" selected readonly>Accepted</option>
                                                    <option value="Declined">Declined</option>
                                                    @elseif($row['rsvp1'] =='Declined')
                                                    <option>Select Status</option>
                                                    <option value="Accepted">Accepted</option>
                                                    <option value="Declined" selected readonly>Declined</option>
                                                    @endif


                                                </select> -->


                    </div>
                </div>
            </div>
        </div>




        <div class="row" style="margin: 10px 0px 0px 0px;">
            <div class="col-12">

                <div class="card">
                    <div class="card-body">
                        <h5 class="text-center" style="color:darkblue">OVM 1 Meeting Details</h5>
                        <!-- <div class="form-group row">
                                    <label class="col-sm-2 col-form-label required">Subject</label>
                                    <div class="col-sm-4">
                                        <input class="form-control" type="text" id="meeting_subject" name="meeting_subject" value="" placeholder="OVM1 Meeting" required autocomplete="off">
                                    </div>
                                </div> -->

                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label required">Location</label>
                            <div class="col-sm-4">
                                <input class="form-control" type="text" id="meeting_location" name="meeting_location" value="{{ $row['meeting_location']}}" placeholder="Enter Location" required autocomplete="off">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label required">Start Date and Time</label>
                            <div class="col-sm-4">
                                <div class="inner-addon right-addon">
                                    <i class="glyphicon fas fa-calendar-alt"></i>
                                    <input type='text' class="form-control meeting_date" id='meeting_startdate' name="meeting_startdate" onchange="autodateupdate(this)" value="{{ $row['meeting_startdate']}}" required>
                                </div>
                            </div>
                            <div class="col-sm-2">
                                <div class="content">
                                    <input class="form-control" type="time" id="meeting_starttime" name="meeting_starttime" value="{{ $row['meeting_starttime']}}" onchange="autoupdatedescription1()" required>
                                </div>
                            </div>

                        </div>



                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label required">End Date and Time</label>
                            <div class="col-sm-4">
                                <div class="inner-addon right-addon">
                                    <i class="glyphicon fas fa-calendar-alt"></i>
                                    <input type='text' class="form-control meeting_date" id="meeting_enddate" name="meeting_enddate" onchange="autodateupdate(this)" value="{{ $row['meeting_enddate']}}" required placeholder="MM/DD/YYYY">
                                </div>
                            </div>
                            <div class="col-sm-2">

                                <div class="content">
                                    <input class="form-control" type="time" id="meeting_endtime" name="meeting_endtime" value="{{ $row['meeting_endtime']}}" onchange="autoupdatedescription1()" required>
                                </div>
                                <br>

                            </div>


                        </div>

                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label"> Confirm Availability</label>
                            <div class="col-sm-4">
                                <input class="form-control" type="text" name="rsvp1" value="{{$row['rsvp1']}}" readonly>
                            </div>
                            <div class="col-sm-12">
                                <textarea class="form-control" readonly>{{$row['notes1']}}</textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row" style="margin: 10px 0px 0px 0px;">
            <div class="col-12">

                <div class="card">
                    <div class="card-body">
                        <h5 class="text-center" style="color:darkblue">OVM 2 Meeting Details</h5>

                        <!-- <div class="form-group row">
                                    <label class="col-sm-2 col-form-label required">Subject</label>
                                    <div class="col-sm-4">
                                        <input class="form-control" type="text" id="meeting_subject" name="meeting_subject" value="" placeholder="OVM1 Meeting" required autocomplete="off">
                                    </div>
                                </div> -->

                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label required">Location</label>
                            <div class="col-sm-4">
                                <input class="form-control" type="text" id="meeting_location2" name="meeting_location2" value="{{ $row['meeting_location2']}}" placeholder="Enter Location" required autocomplete="off">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label required">Start Date and Time</label>
                            <div class="col-sm-4">
                                <div class="inner-addon right-addon">
                                    <i class="glyphicon fas fa-calendar-alt"></i>
                                    <input type='text' class="form-control meeting_date" id='meeting_startdate2' name="meeting_startdate2" onchange="autodateupdate2(this)" value="{{ $row['meeting_startdate2']}}" required>
                                </div>
                            </div>
                            <div class="col-sm-2">
                                <div class="content">
                                    <input class="form-control" type="time" id="meeting_starttime2" name="meeting_starttime2" value="{{ $row['meeting_starttime2']}}" required onchange="autoupdatedescription2()">
                                </div>
                            </div>

                        </div>



                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label required">End Date and Time</label>
                            <div class="col-sm-4">
                                <div class="inner-addon right-addon">
                                    <i class="glyphicon fas fa-calendar-alt"></i>
                                    <input type='text' class="form-control meeting_date" id="meeting_enddate2" name="meeting_enddate2" onchange="autodateupdate2(this)" value="{{ $row['meeting_enddate2']}}" required placeholder="MM/DD/YYYY">
                                </div>
                            </div>
                            <div class="col-sm-2">

                                <div class="content">
                                    <input class="form-control" type="time" id="meeting_endtime2" name="meeting_endtime2" value="{{ $row['meeting_endtime2']}}" required onchange="autoupdatedescription2()">
                                </div>
                                <br>

                            </div>


                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Confirm Availability</label>
                            <div class="col-sm-4">
                                <input class="form-control" type="text" name="rsvp2" value="{{$row['rsvp2']}}" readonly>
                            </div>
                            <div class="col-sm-12">
                                <textarea class="form-control" disabled>{{$row['notes2']}}</textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row" style="margin: 10px 0px 0px 0px;">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="form-group">
                            <label class="form-label">Meeting Description</label>
                            <textarea class="form-control" id="meeting_description" name="meeting_description">
                                                @if($email_allocation != [])
                                                {{$email_allocation[0]['email_body']}}
                                                @endif
                                            </textarea>
                            <!-- <p style="color: red;margin: 0px 0px 0px 5px;">Note : Do not add <strong>Thanks and Regards</strong> at the end of the meeting description</p> -->

                        </div>
                    </div>
                </div>
            </div>
        </div>


        <div class="row text-center">
            <div class="col-md-12">
                <!-- <a type="button" class="btn btn-success text-white" onclick="validateForm('Accept')">Accept</a> -->
                @if(($row['meeting_status'] == "Sent" && $row['rsvp1'] ==""))
                <a type="button" class="btn btn-warning text-white" id="actionButton" onclick="validateForm('Reschedule')" style="display:none !important;">Reschedule</a>
                @elseif(($row['rsvp1'] == "Accept") &&($row['rsvp2'] == "Accept"))<a type="button" class="btn btn-warning text-white" id="actionButton" onclick="validateForm('Reschedule')" style="display:none !important;">Reschedule</a>
                @elseif(($row['rsvp1'] != "Declined") && ($row['reschedule_count'] < 2)) <a type="button" class="btn btn-warning text-white" id="actionButton" onclick="validateForm('Reschedule')" style="color:black !important;display:inline-block !important;">Reschedule</a>

                    @else
                    <a type="button" class="btn btn-warning text-white" id="actionButton" onclick="validateForm('Reschedule')" style="display:none !important;">Reschedule</a>

                    @endif

                    <a type="button" class="btn btn-labeled back-btn" title="Back" href="{{route('ovm_allocation.index')}}" style="color:white !important;background-color: blue !important;">
                        <span class="btn-label" style="font-size:13px !important;"><i class="fa fa-arrow-left"></i></span> Back</a>
            </div>
        </div>
        </form>
        @endforeach


</div>
</div>






</div>
</section>
</div>
<script>
    $(".js-select2").select2({
        closeOnSelect: false,
        placeholder: "Please Select User",
        allowHtml: true,
        tags: true
    });


    $(function() {
        $('.meeting_date').datepicker({
            dateFormat: 'dd/mm/yy',
            minDate: 0,
            changeMonth: true,
            changeYear: true,
        });
    });
</script>
<!-- Calander -->
<div class="modal fade row" id="calModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered col-12" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <div id="calendar1"></div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="calModal2" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <div id="calendar2"></div>
            </div>
        </div>
    </div>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.26.0/moment.min.js"></script>
@include('ovm1.cal')
<!-- End -->

<script>
    meeting_startdate.min = new Date().toISOString().split("T")[0];
    meeting_enddate.min = new Date().toISOString().split("T")[0];
</script>
<script>
    $(document).ready(function() {
        tinymce.init({
            selector: 'textarea#meeting_description',
            height: 180,
            menubar: false,
            branding: false,
            toolbar: 'undo redo | formatselect | ' +
                'bold italic backcolor | alignleft aligncenter ' +
                'alignright alignjustify | bullist numlist outdent indent | ' +
                'removeformat | help',
            content_style: 'body { font-family:Helvetica,Arial,sans-serif; font-size:14px }',
            setup: function(editor) {
                editor.on('init', function() {
                    updateEditorContent(editor); // Call the function initially

                    // Add an onchange event handler for the status field
                    const statusField = document.querySelector('#status');
                    statusField.addEventListener('change', function() {
                        updateEditorContent(editor);
                    });
                });
            }
        });
    });
</script>
<script>
    function updateEditorContent(editor) {
        var content = editor.getContent();
        var mDate1 = document.getElementById('meeting_startdate').value;

        var mTime1_s = document.getElementById('meeting_starttime').value;
        mTime1_s = convertTimeFormat(mTime1_s)
        var mTime1_e = document.getElementById('meeting_endtime').value;
        mTime1_e = convertTimeFormat(mTime1_e)
        var text1 = mDate1 + ' from ' + mTime1_s + ' to ' + mTime1_e +'(IST)';

        const status = document.querySelector('#status').value;
        var reschedule_count = parseInt(document.getElementById('reschedule_count').value, 10); // Parse as an integer

        if (status === "Declined") {
            // Replace "re-scheduled" with "declined"
            content = content.replace(/re-scheduled/g, 'declined');
            content = content.replace(/accept/g, 'declined');
            content = content.replace(/reschedule - 1/g, 'declined');
            content = content.replace(/reschedule - 2/g, 'declined');
            content = content.replace(/reschedule - 3/g, 'declined');
            content = content.replace(/reschedule - 4/g, 'declined');

            content = content.replace(/Forced Closure/g, 'declined');

        }
        if (status === "Accept") {
            // Replace "re-scheduled" with "declined"
            content = content.replace(/re-scheduled/g, 'accept');
            content = content.replace(/declined/g, 'accept');
            content = content.replace(/Forced Closure/g, 'accept');
            content = content.replace(/reschedule - 1/g, 'accept');
            content = content.replace(/reschedule - 2/g, 'accept');
            content = content.replace(/reschedule - 3/g, 'accept');
            content = content.replace(/reschedule - 4/g, 'accept');

        }
        if (status === "Forced Closure") {
            // Replace "re-scheduled" with "declined"
            content = content.replace(/re-scheduled/g, 'Forced Closure');
            content = content.replace(/accept/g, 'Forced Closure');
            content = content.replace(/declined/g, 'Forced Closure');

        } else {
            content = content.replace(/ovm1MeetingDetails/g, text1);
            reschedule_count += 1;
            content = content.replace(/re-scheduled/g, 'reschedule(d) - ' + (reschedule_count));



        }

        var mDate2 = document.getElementById('meeting_startdate2').value;
        var mTime2_s = document.getElementById('meeting_starttime2').value;
        mTime2_s = convertTimeFormat(mTime2_s)
        var mTime2_e = document.getElementById('meeting_endtime2').value;
        mTime2_e = convertTimeFormat(mTime2_e)
        var text2 = mDate2 + ' from ' + mTime2_s + ' to ' + mTime2_e +'(IST)';
        content = content.replace(/ovm2MeetingDetails/g, text2);
        content = content.replace(/re-scheduled/g, 'reschedule(d) - ' + (reschedule_count + 1));


        editor.setContent(content);
    }
</script>
<script type="text/javascript">
    const iscoordinatorfn = (event) => {
        let coordinatorname = event.target.value;
        let currentcoordinator = event.target.name;
        if (currentcoordinator === "is_coordinator1") {
            let iscoordinater2new = JSON.parse($('#is_coordinator2old').attr('data-attr'));
            intcoordinatorname = parseInt(coordinatorname);
            iscoordinater2new = iscoordinater2new.filter(name => name.id !== intcoordinatorname)
            alternatecoordinator = document.getElementById('is_coordinator2')
            var ddd = '<option >Select-IS-Coordinator-2</option>';
            for (i = 0; i < iscoordinater2new.length; i++) {
                ddd += '<option value="' + iscoordinater2new[i].id + '">' + iscoordinater2new[i].name + '</option>';
            }
            let currentcoordinatorname = alternatecoordinator.value;
            alternatecoordinator.innerHTML = "";
            alternatecoordinator.innerHTML = ddd;
            alternatecoordinator.value = currentcoordinatorname;
        } else {
            let iscoordinater1new = JSON.parse($('#is_coordinator1old').attr('data-attr'));
            intcoordinatorname = parseInt(coordinatorname);
            iscoordinater1new = iscoordinater1new.filter(name => name.id !== intcoordinatorname)
            alternatecoordinator = document.getElementById('is_coordinator1');
            var ddd = '<option >Select-IS-Coordinator-1</option>';
            for (i = 0; i < iscoordinater1new.length; i++) {
                ddd += '<option value="' + iscoordinater1new[i].id + '">' + iscoordinater1new[i].name + '</option>';
            }
            let currentcoordinatorname = alternatecoordinator.value;
            alternatecoordinator.innerHTML = "";
            alternatecoordinator.innerHTML = ddd;
            alternatecoordinator.value = currentcoordinatorname;
        }

        getEventsDB(currentcoordinator);

    }
</script>
<script>
    function createDateFromDateString(dateString) {
        // Use a regular expression to extract day, month, and year
        var dateParts = dateString.match(/(\d{2})\/(\d{2})\/(\d{4})/);

        if (dateParts === null) {
            // Date string is not in the expected format
            return null;
        }

        // Extract day, month, and year from the regular expression match
        var day = parseInt(dateParts[1], 10);
        var month = parseInt(dateParts[2], 10) - 1; // Months are 0-based
        var year = parseInt(dateParts[3], 10);

        // Create a Date object
        var dateObject = new Date(year, month, day);

        // Check if the Date object is valid
        if (isNaN(dateObject.getTime())) {
            return null;
        }

        return dateObject;
    }
    var co = <?php echo (json_encode($rows)); ?>;

    var co1 = co[0].is_coordinator1.id;
    var co2a = co[0].is_coordinator2;
    var co2 = co[0].is_coordinator2.id;

    var selectobject1 = document.getElementById("is_coordinator1");
    var selectobject2 = document.getElementById("is_coordinator2");

    for (var i = 0; i < selectobject2.length; i++) {
        if (selectobject2.options[i].value == co1)
            selectobject2.remove(i);
    }
    if (co2a != []) {
        for (var i = 0; i < selectobject1.length; i++) {
            if (selectobject1.options[i].value == co2)
                selectobject1.remove(i);
        }
    }

    // $(document).ready(function() {
    //     getEventsDB("is_coordinator1");
    //     if (co2a != []) {
    //         getEventsDB('is_coordinator2');
    //     }
    // });
</script>
<script>
    function getEventsDB(current_co) {
        if (current_co == 'is_coordinator1') {
            var co_one = $('#is_coordinator1').val();
            if (co_one != null) {
                $('#co_one').hide();
                getEventData(co_one, 'col1');
                $('#co_one').show();
            } else {
                $('#co_one').hide();
            }
        } else {
            var co_two = $('#is_coordinator2').val();
            if (co_two != null) {
                $('#co_two').hide();
                getEventData(co_two, 'col2');
                $('#co_two').show();
            } else {
                $('#co_two').hide();
            }
        }
    }

    var data1 = [];
    var data2 = [];

    function getEventData(is_ID, col) {

        $.ajax({
            url: '/calendar/event/getdata',
            type: 'GET',
            async: false,
            data: {
                fieldID: is_ID,
                _token: '{{csrf_token()}}'
            }
        }).done(function(data) {
            var response = JSON.parse(data);

            if (col == 'col1') {
                data1 = [];
                for (let index = 0; index < response.length; index++) {
                    const eventvalue = response[index];
                    data1.push(eventvalue);
                }
                $('#calendar1').html('');
                var calendar = new Calendar('#calendar1', data1);
                console.log(data1.length);

            } else if (col == 'col2') {
                data2 = [];
                for (let index = 0; index < response.length; index++) {
                    const eventvalue = response[index];
                    data2.push(eventvalue);
                }
                $('#calendar2').html('');
                var calendar = new Calendar('#calendar2', data2);

            }

        });

    }

    function autodateupdate(datev) {
        $('#meeting_startdate').val(datev.value);
        $('#meeting_enddate').val(datev.value);
        autoupdatedescription1();
    }

    function autodateupdate2(datev) {
        $('#meeting_startdate2').val(datev.value);
        $('#meeting_enddate2').val(datev.value);
        autoupdatedescription2();
    }

    var repeate1;
    var repeate2;

    function autoupdatedescription1() {


        var mDate1 = document.getElementById('meeting_startdate').value;

        var mTime1_s = document.getElementById('meeting_starttime').value;
        mTime1_s = convertTimeFormat(mTime1_s)
        var mTime1_e = document.getElementById('meeting_endtime').value;
        mTime1_e = convertTimeFormat(mTime1_e)
        if (mDate1 != '' && mTime1_s != '' && mTime1_e != '') {
            var text1 = mDate1 + ' from ' + mTime1_s + ' to ' + mTime1_e +'(IST) (OVM1 date and time)' ;
            console.log(text1);

            var content = tinymce.get('meeting_description').getContent();
            console.log(content);
            if (repeate1 == undefined) {
                content = content.replace(/(\d{2}\/\d{2}\/\d{4} from \d{1,2}:\d{2} [APMapm]{2} to \d{1,2}:\d{2} [APMapm]{2})\(IST\) \(OVM1 date and time\)/g, text1);
                // content = content.replace(/\(OVM1 date and time\)/g, text1 + " (OVM1 date and time)");


            } else {
                content = content.replace(repeate1, text1);
            }
            tinymce.get('meeting_description').setContent(content);
            repeate1 = text1;
           
        }

    }

    function autoupdatedescription2() {
        var mDate2 = document.getElementById('meeting_startdate2').value;
        var mTime2_s = document.getElementById('meeting_starttime2').value;
        mTime2_s = convertTimeFormat(mTime2_s)
        var mTime2_e = document.getElementById('meeting_endtime2').value;
        mTime2_e = convertTimeFormat(mTime2_e)
        // 
        if (mDate2 != '' && mTime2_s != '' && mTime2_e != '') {
            var text2 = mDate2 + ' from ' + mTime2_s + ' to ' + mTime2_e +'(IST) (OVM2 date and time)';
            var content = tinymce.get('meeting_description').getContent();
            if (repeate2 == undefined) {
                // content = content.replace(/ovm2MeetingDetails/g, text2);
                content = content.replace(/(\d{2}\/\d{2}\/\d{4} from \d{1,2}:\d{2} [APMapm]{2} to \d{1,2}:\d{2} [APMapm]{2})\(IST\) \(OVM2 date and time\)/g, text2);

            } else {
                content = content.replace(repeate2, text2);
            }
            tinymce.get('meeting_description').setContent(content);
            repeate2 = text2;
        }
    }

    function validateForm(a) {

        if (a == "Reschedule") {
            var co_one = $('#is_coordinator1').val();
            var co_two = $('#is_coordinator2').val();
            var startdate = $('#meeting_startdate').val();

            if (co_one == "Select-IS-Coordinator-1") {
                swal.fire("Please Select IS Coordinator1 ", "", "error");
                return false;
            }

            if (data1.length > 10) {
                swal.fire("IS Co-ordinator-1 has Already Assigned with Ten Child", "", "error");
                return false;
            }
            if (data2.length > 10) {
                swal.fire("IS Co-ordinator-2 has Already Assigned with Ten Child", "", "error");
                return false;
            }

            data1 = data1.filter(i => startdate.includes(i.idate));
            const data1Len = data1.length;
            if (data1Len >= 2) {
                swal.fire("IS Co-ordinator-1 has Two Appointment on the same day", "", "error");
                return false;
            }

            data2 = data2.filter(j => startdate.includes(j.idate));
            const data2Len = data2.length;
            if (data2Len >= 2) {
                swal.fire("IS Co-ordinator-2 has Two Appointment on the same day", "", "error");
                return false;
            }

            // if (document.getElementById('meeting_startdate').value == document.getElementById('meeting_startdate2').value) {
            //     swal.fire("OVM 1 and OVM 2 Meeting date should not be same", "", "error");
            //     return false;
            // }

            // OVM 1 - Validation
            var meeting_startdate = document.getElementById('meeting_startdate').value;
            if (meeting_startdate == "") {
                swal.fire("Please Select OVM 1 Meeting Start Date ", "", "error");
                return false;
            }

            var meeting_starttime = document.getElementById('meeting_starttime').value;
            if (meeting_starttime == "") {
                swal.fire("Please Select OVM 1 Meeting Start Time", "", "error");
                return false;
            }

            var meeting_enddate = document.getElementById('meeting_enddate').value;
            if (meeting_enddate == "") {
                swal.fire("Please Select OVM 1 Meeting End Date", "", "error");
                return false;
            }

            var meeting_endtime = document.getElementById('meeting_endtime').value;
            if (meeting_endtime == "") {
                swal.fire("Please Select OVM 1 Meeting End Time", "", "error");
                return false;
            }

            // for (k = 0; k < data1.length; k++) {
            //     if (data1[k].idate == meeting_startdate) {
            //         var tiLen = 5;
            //         var timeDB1 = data1[k].meeting_starttime.substring(0, tiLen);
            //         var timeDB2 = data1[k].meeting_endtime.substring(0, tiLen);

            //         var timeBlockedStart = timeDB1.replace(/:/g, "");
            //         var startTime = meeting_starttime.replace(/:/g, "");

            //         var timeBlockedEnd = timeDB2.replace(/:/g, "");
            //         var endTime = meeting_endtime.replace(/:/g, "");
            //         valid = timeBlockedStart <= startTime && timeBlockedEnd >= startTime;
            //         valid1 = timeBlockedStart <= endTime && timeBlockedEnd >= endTime;

            //         if (valid == true || valid1 == true) {
            //             swal.fire("IS Co-ordinator-1 has Appointment on the same time", "", "error");
            //             return false;
            //         }
            //     }
            // }

            // for (h = 0; h < data2.length; h++) {
            //     if (data2[h].idate == meeting_startdate) {
            //         var tiLen = 5;
            //         var timeDB3 = data2[h].meeting_starttime.substring(0, tiLen);
            //         var timeDB4 = data2[h].meeting_endtime.substring(0, tiLen);

            //         var timeBlockedStart = timeDB3.replace(/:/g, "");
            //         var startTime = meeting_starttime.replace(/:/g, "");

            //         var timeBlockedEnd = timeDB4.replace(/:/g, "");
            //         var endTime = meeting_endtime.replace(/:/g, "");
            //         valid = timeBlockedStart <= startTime && timeBlockedEnd >= startTime;
            //         valid1 = timeBlockedStart <= endTime && timeBlockedEnd >= endTime;

            //         if (valid == true || valid1 == true) {
            //             swal.fire("IS Co-ordinator-2 has Appointment on the same time", "", "error");
            //             return false;
            //         }
            //     }
            // }

            var date = new Date();
            var currentDate = date.toLocaleString("en-GB", {
                year: "numeric",
                month: "2-digit",
                day: "2-digit",
            });

            var date1 = new Date(meeting_startdate);
            var MSdate1 = date1.toLocaleString("en-GB", {
                year: "numeric",
                month: "2-digit",
                day: "2-digit",
            });

            var twentyMinutesLater = new Date();
            twentyMinutesLater.setMinutes(twentyMinutesLater.getMinutes() + 2);
            var currentTime = new Date(twentyMinutesLater).toLocaleTimeString("en-GB");
            if (currentDate == MSdate1) {
                var th = 5;
                var currentTime1 = currentTime.substring(0, th);
                var s11 = meeting_starttime.replace(/:/g, "");
                var c11 = currentTime1.replace(/:/g, "");
                if (s11 < c11) {
                    swal.fire("Please Select Valid OVM 1 Meeting Time", "", "error");
                    return false;
                }
            }

            if (meeting_starttime == meeting_endtime) {
                swal.fire("OVM 1 Meeting Start Time and End Time should not be same", "", "error");
                return false;
            }
            if (meeting_starttime > meeting_endtime) {
                swal.fire("Please Select Valid OVM 1 Meeting Time", "", "error");
                return false;
            }

            var sTime = meeting_starttime.replace(/:/g, "");
            var eTime = meeting_endtime.replace(/:/g, "");
            var length = 4;
            var tsTime = sTime.substring(0, length);
            var teTime = eTime.substring(0, length);
            var diff = teTime - tsTime;
            if (diff > 200) {
                swal.fire("OVM 1 Meeting Maximum Time Duration is Two Hours", "", "error");
                return false;
            }
            if (diff < 30) {
                swal.fire("OVM 1 Meeting Minimum Time Duration is 30 Minutes", "", "error");
                return false;
            }
            // if (tsTime < 900) {
            //     swal.fire("OVM 1 Meeting Meeting Can be Scheduled from 9AM to 6PM only", "", "error");
            //     return false;
            // }
            // if (teTime > 1800) {
            //     swal.fire("OVM 1 Meeting Meeting Can be Scheduled from 9AM to 6PM only", "", "error");
            //     return false;
            // }

            // OVM 2 - Validation
            var meeting_startdate2 = document.getElementById('meeting_startdate2').value;
            if (meeting_startdate2 == "") {
                swal.fire("Please Select OVM 2 Meeting Start Date ", "", "error");
                return false;
            }

            var meeting_starttime2 = document.getElementById('meeting_starttime2').value;
            if (meeting_starttime2 == "") {
                swal.fire("Please Select OVM 2 Meeting Start Time", "", "error");
                return false;
            }

            var meeting_enddate2 = document.getElementById('meeting_enddate2').value;
            if (meeting_enddate2 == "") {
                swal.fire("Please Select OVM 2 Meeting End Date", "", "error");
                return false;
            }

            var meeting_endtime2 = document.getElementById('meeting_endtime2').value;
            if (meeting_endtime2 == "") {
                swal.fire("Please Select OVM 2 Meeting End Time", "", "error");
                return false;
            }

            // for (k = 0; k < data1.length; k++) {
            //     if (data1[k].idate == meeting_startdate) {
            //         var tiLen = 5;
            //         var timeDB1 = data1[k].meeting_starttime.substring(0, tiLen);
            //         var timeDB2 = data1[k].meeting_endtime.substring(0, tiLen);

            //         var timeBlockedStart = timeDB1.replace(/:/g, "");
            //         var startTime = meeting_starttime.replace(/:/g, "");

            //         var timeBlockedEnd = timeDB2.replace(/:/g, "");
            //         var endTime = meeting_endtime.replace(/:/g, "");
            //         valid = timeBlockedStart <= startTime && timeBlockedEnd >= startTime;
            //         valid1 = timeBlockedStart <= endTime && timeBlockedEnd >= endTime;

            //         if (valid == true || valid1 == true) {
            //             swal.fire("IS Co-ordinator-1 has Appointment on the same time", "", "error");
            //             return false;
            //         }
            //     }
            // }

            // for (h = 0; h < data2.length; h++) {
            //     if (data2[h].idate == meeting_startdate) {
            //         var tiLen = 5;
            //         var timeDB3 = data2[h].meeting_starttime.substring(0, tiLen);
            //         var timeDB4 = data2[h].meeting_endtime.substring(0, tiLen);

            //         var timeBlockedStart = timeDB3.replace(/:/g, "");
            //         var startTime = meeting_starttime.replace(/:/g, "");

            //         var timeBlockedEnd = timeDB4.replace(/:/g, "");
            //         var endTime = meeting_endtime.replace(/:/g, "");
            //         valid = timeBlockedStart <= startTime && timeBlockedEnd >= startTime;
            //         valid1 = timeBlockedStart <= endTime && timeBlockedEnd >= endTime;

            //         if (valid == true || valid1 == true) {
            //             swal.fire("IS Co-ordinator-2 has Appointment on the same time", "", "error");
            //             return false;
            //         }
            //     }
            // }

            var date = new Date();
            var currentDate = date.toLocaleString("en-GB", {
                year: "numeric",
                month: "2-digit",
                day: "2-digit",
            });

            var date1 = new Date(meeting_startdate);
            var MSdate1 = date1.toLocaleString("en-GB", {
                year: "numeric",
                month: "2-digit",
                day: "2-digit",
            });

            var twentyMinutesLater = new Date();
            twentyMinutesLater.setMinutes(twentyMinutesLater.getMinutes() + 2);
            var currentTime = new Date(twentyMinutesLater).toLocaleTimeString("en-GB");
            if (currentDate == MSdate1) {
                var th = 5;
                var currentTime1 = currentTime.substring(0, th);
                var s11 = meeting_starttime.replace(/:/g, "");
                var c11 = currentTime1.replace(/:/g, "");
                if (s11 < c11) {
                    swal.fire("Please Select Valid OVM 2 Meeting Time", "", "error");
                    return false;
                }
            }
            if (meeting_starttime2 == meeting_endtime2) {
                swal.fire("OVM 2 Meeting Start Time and End Time should not be same", "", "error");
                return false;
            }
            if (meeting_starttime2 > meeting_endtime2) {
                swal.fire("Please Select Valid OVM 2 Meeting Time", "", "error");
                return false;
            }

            var sTime = meeting_starttime2.replace(/:/g, "");
            var eTime = meeting_endtime2.replace(/:/g, "");
            var length = 4;
            var tsTime = sTime.substring(0, length);
            var teTime = eTime.substring(0, length);
            var diff = teTime - tsTime;
            if (diff > 200) {
                swal.fire("OVM 2 Meeting Maximum Time Duration is Two Hours", "", "error");
                return false;
            }
            if (diff < 30) {
                swal.fire("OVM 2 Meeting Minimum Time Duration is 30 Minutes", "", "error");
                return false;
            }
            // if (tsTime < 900) {
            //     swal.fire("OVM 2 Meeting Meeting Can be Scheduled from 9AM to 6PM only", "", "error");
            //     return false;
            // }
            // if (teTime > 1800) {
            //     swal.fire("OVM 2 Meeting Meeting Can be Scheduled from 9AM to 6PM only", "", "error");
            //     return false;
            // }
           

            if (createDateFromDateString(meeting_startdate) > createDateFromDateString(meeting_startdate2)) {

                swal.fire("OVM 1 Meeting should start after OVM 2 Meeting", "", "error");
                return false;
            }

            if (createDateFromDateString(meeting_startdate) === createDateFromDateString(meeting_startdate2)) {
          
                if (meeting_endtime >= meeting_starttime2) {
                    swal.fire("OVM 1 Meeting should end before OVM 2 Meeting starts", "", "error");
                    return false;
                }
            }

            // Check if OVM 1 Meeting starts before OVM 2 Meeting ends
            // if (createDateFromDateString(meeting_startdate) === createDateFromDateString(meeting_startdate2)) {
                
            //     if (meeting_endtime > meeting_starttime2) {
            //         swal.fire("OVM 1 Meeting should end before OVM 2 Meeting starts", "", "error");
            //         return false;
            //     }
            // }
            var date1 = createDateFromDateString(meeting_startdate);
            var date2 = createDateFromDateString(meeting_startdate2);

            if (date1.getTime() === date2.getTime()) {
                // Dates are the same, compare times
                if (meeting_endtime >= meeting_starttime2) {
                    swal.fire("OVM 1 Meeting should start after OVM 2 Meeting", "", "error");
                    return false;
                }
            }

            document.getElementById('meeting_status').value = a;
            if (a == 'Saved') {
                var swalText = 'Save';
            } else if (a == 'Sent') {
                var swalText = 'Schedule';
            } else {
                var swalText = a;
            }

            Swal.fire({

                title: "Do you want to " + swalText + " the Meeting?",
                text: "Please click 'Yes' to " + swalText + " the Meeting",
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
                    $(".loader").show();
                    document.getElementById('ovm_meet').submit(a);
                }
            })
        } else if (a == "Forced Closure") {
            var co_one = $('#is_coordinator1').val();
            var co_two = $('#is_coordinator2').val();
            var startdate = $('#meeting_startdate').val();

            if (co_one == "Select-IS-Coordinator-1") {
                swal.fire("Please Select IS Coordinator1 ", "", "error");
                return false;
            }

            if (data1.length > 10) {
                swal.fire("IS Co-ordinator-1 has Already Assigned with Ten Child", "", "error");
                return false;
            }
            if (data2.length > 10) {
                swal.fire("IS Co-ordinator-2 has Already Assigned with Ten Child", "", "error");
                return false;
            }

            data1 = data1.filter(i => startdate.includes(i.idate));
            const data1Len = data1.length;
            if (data1Len >= 2) {
                swal.fire("IS Co-ordinator-1 has Two Appointment on the same day", "", "error");
                return false;
            }

            data2 = data2.filter(j => startdate.includes(j.idate));
            const data2Len = data2.length;
            if (data2Len >= 2) {
                swal.fire("IS Co-ordinator-2 has Two Appointment on the same day", "", "error");
                return false;
            }

            // if (document.getElementById('meeting_startdate').value == document.getElementById('meeting_startdate2').value) {
            //     swal.fire("OVM 1 and OVM 2 Meeting date should not be same", "", "error");
            //     return false;
            // }

            // OVM 1 - Validation
            var meeting_startdate = document.getElementById('meeting_startdate').value;
            if (meeting_startdate == "") {
                swal.fire("Please Select OVM 1 Meeting Start Date ", "", "error");
                return false;
            }

            var meeting_starttime = document.getElementById('meeting_starttime').value;
            if (meeting_starttime == "") {
                swal.fire("Please Select OVM 1 Meeting Start Time", "", "error");
                return false;
            }

            var meeting_enddate = document.getElementById('meeting_enddate').value;
            if (meeting_enddate == "") {
                swal.fire("Please Select OVM 1 Meeting End Date", "", "error");
                return false;
            }

            var meeting_endtime = document.getElementById('meeting_endtime').value;
            if (meeting_endtime == "") {
                swal.fire("Please Select OVM 1 Meeting End Time", "", "error");
                return false;
            }

            // for (k = 0; k < data1.length; k++) {
            //     if (data1[k].idate == meeting_startdate) {
            //         var tiLen = 5;
            //         var timeDB1 = data1[k].meeting_starttime.substring(0, tiLen);
            //         var timeDB2 = data1[k].meeting_endtime.substring(0, tiLen);

            //         var timeBlockedStart = timeDB1.replace(/:/g, "");
            //         var startTime = meeting_starttime.replace(/:/g, "");

            //         var timeBlockedEnd = timeDB2.replace(/:/g, "");
            //         var endTime = meeting_endtime.replace(/:/g, "");
            //         valid = timeBlockedStart <= startTime && timeBlockedEnd >= startTime;
            //         valid1 = timeBlockedStart <= endTime && timeBlockedEnd >= endTime;

            //         if (valid == true || valid1 == true) {
            //             swal.fire("IS Co-ordinator-1 has Appointment on the same time", "", "error");
            //             return false;
            //         }
            //     }
            // }

            // for (h = 0; h < data2.length; h++) {
            //     if (data2[h].idate == meeting_startdate) {
            //         var tiLen = 5;
            //         var timeDB3 = data2[h].meeting_starttime.substring(0, tiLen);
            //         var timeDB4 = data2[h].meeting_endtime.substring(0, tiLen);

            //         var timeBlockedStart = timeDB3.replace(/:/g, "");
            //         var startTime = meeting_starttime.replace(/:/g, "");

            //         var timeBlockedEnd = timeDB4.replace(/:/g, "");
            //         var endTime = meeting_endtime.replace(/:/g, "");
            //         valid = timeBlockedStart <= startTime && timeBlockedEnd >= startTime;
            //         valid1 = timeBlockedStart <= endTime && timeBlockedEnd >= endTime;

            //         if (valid == true || valid1 == true) {
            //             swal.fire("IS Co-ordinator-2 has Appointment on the same time", "", "error");
            //             return false;
            //         }
            //     }
            // }

            var date = new Date();
            var currentDate = date.toLocaleString("en-GB", {
                year: "numeric",
                month: "2-digit",
                day: "2-digit",
            });

            var date1 = new Date(meeting_startdate);
            var MSdate1 = date1.toLocaleString("en-GB", {
                year: "numeric",
                month: "2-digit",
                day: "2-digit",
            });

            var twentyMinutesLater = new Date();
            twentyMinutesLater.setMinutes(twentyMinutesLater.getMinutes() + 2);
            var currentTime = new Date(twentyMinutesLater).toLocaleTimeString("en-GB");
            if (currentDate == MSdate1) {
                var th = 5;
                var currentTime1 = currentTime.substring(0, th);
                var s11 = meeting_starttime.replace(/:/g, "");
                var c11 = currentTime1.replace(/:/g, "");
                if (s11 < c11) {
                    swal.fire("Please Select Valid OVM 1 Meeting Time", "", "error");
                    return false;
                }
            }

            if (meeting_starttime == meeting_endtime) {
                swal.fire("OVM 1 Meeting Start Time and End Time should not be same", "", "error");
                return false;
            }
            if (meeting_starttime > meeting_endtime) {
                swal.fire("Please Select Valid OVM 1 Meeting Time", "", "error");
                return false;
            }

            var sTime = meeting_starttime.replace(/:/g, "");
            var eTime = meeting_endtime.replace(/:/g, "");
            var length = 4;
            var tsTime = sTime.substring(0, length);
            var teTime = eTime.substring(0, length);
            var diff = teTime - tsTime;
            if (diff > 200) {
                swal.fire("OVM 1 Meeting Maximum Time Duration is Two Hours", "", "error");
                return false;
            }
            if (diff < 30) {
                swal.fire("OVM 1 Meeting Minimum Time Duration is 30 Minutes", "", "error");
                return false;
            }
            // if (tsTime < 900) {
            //     swal.fire("OVM 1 Meeting Meeting Can be Scheduled from 9AM to 6PM only", "", "error");
            //     return false;
            // }
            // if (teTime > 1800) {
            //     swal.fire("OVM 1 Meeting Meeting Can be Scheduled from 9AM to 6PM only", "", "error");
            //     return false;
            // }

            // OVM 2 - Validation
            var meeting_startdate2 = document.getElementById('meeting_startdate2').value;
            if (meeting_startdate2 == "") {
                swal.fire("Please Select OVM 2 Meeting Start Date ", "", "error");
                return false;
            }

            var meeting_starttime2 = document.getElementById('meeting_starttime2').value;
            if (meeting_starttime2 == "") {
                swal.fire("Please Select OVM 2 Meeting Start Time", "", "error");
                return false;
            }

            var meeting_enddate2 = document.getElementById('meeting_enddate2').value;
            if (meeting_enddate2 == "") {
                swal.fire("Please Select OVM 2 Meeting End Date", "", "error");
                return false;
            }

            var meeting_endtime2 = document.getElementById('meeting_endtime2').value;
            if (meeting_endtime2 == "") {
                swal.fire("Please Select OVM 2 Meeting End Time", "", "error");
                return false;
            }

            // for (k = 0; k < data1.length; k++) {
            //     if (data1[k].idate == meeting_startdate) {
            //         var tiLen = 5;
            //         var timeDB1 = data1[k].meeting_starttime.substring(0, tiLen);
            //         var timeDB2 = data1[k].meeting_endtime.substring(0, tiLen);

            //         var timeBlockedStart = timeDB1.replace(/:/g, "");
            //         var startTime = meeting_starttime.replace(/:/g, "");

            //         var timeBlockedEnd = timeDB2.replace(/:/g, "");
            //         var endTime = meeting_endtime.replace(/:/g, "");
            //         valid = timeBlockedStart <= startTime && timeBlockedEnd >= startTime;
            //         valid1 = timeBlockedStart <= endTime && timeBlockedEnd >= endTime;

            //         if (valid == true || valid1 == true) {
            //             swal.fire("IS Co-ordinator-1 has Appointment on the same time", "", "error");
            //             return false;
            //         }
            //     }
            // }

            // for (h = 0; h < data2.length; h++) {
            //     if (data2[h].idate == meeting_startdate) {
            //         var tiLen = 5;
            //         var timeDB3 = data2[h].meeting_starttime.substring(0, tiLen);
            //         var timeDB4 = data2[h].meeting_endtime.substring(0, tiLen);

            //         var timeBlockedStart = timeDB3.replace(/:/g, "");
            //         var startTime = meeting_starttime.replace(/:/g, "");

            //         var timeBlockedEnd = timeDB4.replace(/:/g, "");
            //         var endTime = meeting_endtime.replace(/:/g, "");
            //         valid = timeBlockedStart <= startTime && timeBlockedEnd >= startTime;
            //         valid1 = timeBlockedStart <= endTime && timeBlockedEnd >= endTime;

            //         if (valid == true || valid1 == true) {
            //             swal.fire("IS Co-ordinator-2 has Appointment on the same time", "", "error");
            //             return false;
            //         }
            //     }
            // }

            var date = new Date();
            var currentDate = date.toLocaleString("en-GB", {
                year: "numeric",
                month: "2-digit",
                day: "2-digit",
            });

            var date1 = new Date(meeting_startdate);
            var MSdate1 = date1.toLocaleString("en-GB", {
                year: "numeric",
                month: "2-digit",
                day: "2-digit",
            });

            var twentyMinutesLater = new Date();
            twentyMinutesLater.setMinutes(twentyMinutesLater.getMinutes() + 2);
            var currentTime = new Date(twentyMinutesLater).toLocaleTimeString("en-GB");
            if (currentDate == MSdate1) {
                var th = 5;
                var currentTime1 = currentTime.substring(0, th);
                var s11 = meeting_starttime.replace(/:/g, "");
                var c11 = currentTime1.replace(/:/g, "");
                if (s11 < c11) {
                    swal.fire("Please Select Valid OVM 2 Meeting Time", "", "error");
                    return false;
                }
            }
            if (meeting_starttime2 == meeting_endtime2) {
                swal.fire("OVM 2 Meeting Start Time and End Time should not be same", "", "error");
                return false;
            }
            if (meeting_starttime2 > meeting_endtime2) {
                swal.fire("Please Select Valid OVM 2 Meeting Time", "", "error");
                return false;
            }

            var sTime = meeting_starttime2.replace(/:/g, "");
            var eTime = meeting_endtime2.replace(/:/g, "");
            var length = 4;
            var tsTime = sTime.substring(0, length);
            var teTime = eTime.substring(0, length);
            var diff = teTime - tsTime;
            if (diff > 200) {
                swal.fire("OVM 2 Meeting Maximum Time Duration is Two Hours", "", "error");
                return false;
            }
            if (diff < 30) {
                swal.fire("OVM 2 Meeting Minimum Time Duration is 30 Minutes", "", "error");
                return false;
            }
            // if (tsTime < 900) {
            //     swal.fire("OVM 2 Meeting Meeting Can be Scheduled from 9AM to 6PM only", "", "error");
            //     return false;
            // }
            // if (teTime > 1800) {
            //     swal.fire("OVM 2 Meeting Meeting Can be Scheduled from 9AM to 6PM only", "", "error");
            //     return false;
            // }
            // alert(meeting_startdate);

            if (createDateFromDateString(meeting_startdate) > createDateFromDateString(meeting_startdate2)) {

                swal.fire("OVM 1 Meeting should start after OVM 2 Meeting", "", "error");
                return false;
            }

            if (createDateFromDateString(meeting_startdate) === createDateFromDateString(meeting_startdate2) && meeting_starttime >= meeting_starttime2) {

                swal.fire("OVM 1 Meeting should start after OVM 2 Meeting", "", "error");
                return false;
            }

            // Check if OVM 1 Meeting starts before OVM 2 Meeting ends
            if (createDateFromDateString(meeting_startdate) === createDateFromDateString(meeting_startdate2) && meeting_starttime > meeting_endtime2) {
                swal.fire("OVM 1 Meeting should start after OVM 2 Meeting ends", "", "error");
                return false;
            }

            document.getElementById('meeting_status').value = a;
            if (a == 'Saved') {
                var swalText = 'Save';
            } else if (a == 'Sent') {
                var swalText = 'Schedule';
            } else {
                var swalText = a;
            }

            Swal.fire({

                title: "Do you want to " + swalText + " the Meeting?",
                text: "Please click 'Yes' to " + swalText + " the Meeting",
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
                    $(".loader").show();
                    document.getElementById('ovm_meet').submit(a);
                }
            })
        }
        if (a == "Declined") {
            var co_one = $('#is_coordinator1').val();
            var co_two = $('#is_coordinator2').val();
            var startdate = $('#meeting_startdate').val();

            if (co_one == "Select-IS-Coordinator-1") {
                swal.fire("Please Select IS Coordinator1 ", "", "error");
                return false;
            }

            if (data1.length > 10) {
                swal.fire("IS Co-ordinator-1 has Already Assigned with Ten Child", "", "error");
                return false;
            }
            if (data2.length > 10) {
                swal.fire("IS Co-ordinator-2 has Already Assigned with Ten Child", "", "error");
                return false;
            }

            data1 = data1.filter(i => startdate.includes(i.idate));
            const data1Len = data1.length;
            if (data1Len >= 2) {
                swal.fire("IS Co-ordinator-1 has Two Appointment on the same day", "", "error");
                return false;
            }

            data2 = data2.filter(j => startdate.includes(j.idate));
            const data2Len = data2.length;
            if (data2Len >= 2) {
                swal.fire("IS Co-ordinator-2 has Two Appointment on the same day", "", "error");
                return false;
            }

            // if (document.getElementById('meeting_startdate').value == document.getElementById('meeting_startdate2').value) {
            //     swal.fire("OVM 1 and OVM 2 Meeting date should not be same", "", "error");
            //     return false;
            // }

            // OVM 1 - Validation
            var meeting_startdate = document.getElementById('meeting_startdate').value;
            if (meeting_startdate == "") {
                swal.fire("Please Select OVM 1 Meeting Start Date ", "", "error");
                return false;
            }

            var meeting_starttime = document.getElementById('meeting_starttime').value;
            if (meeting_starttime == "") {
                swal.fire("Please Select OVM 1 Meeting Start Time", "", "error");
                return false;
            }

            var meeting_enddate = document.getElementById('meeting_enddate').value;
            if (meeting_enddate == "") {
                swal.fire("Please Select OVM 1 Meeting End Date", "", "error");
                return false;
            }

            var meeting_endtime = document.getElementById('meeting_endtime').value;
            if (meeting_endtime == "") {
                swal.fire("Please Select OVM 1 Meeting End Time", "", "error");
                return false;
            }

            // for (k = 0; k < data1.length; k++) {
            //     if (data1[k].idate == meeting_startdate) {
            //         var tiLen = 5;
            //         var timeDB1 = data1[k].meeting_starttime.substring(0, tiLen);
            //         var timeDB2 = data1[k].meeting_endtime.substring(0, tiLen);

            //         var timeBlockedStart = timeDB1.replace(/:/g, "");
            //         var startTime = meeting_starttime.replace(/:/g, "");

            //         var timeBlockedEnd = timeDB2.replace(/:/g, "");
            //         var endTime = meeting_endtime.replace(/:/g, "");
            //         valid = timeBlockedStart <= startTime && timeBlockedEnd >= startTime;
            //         valid1 = timeBlockedStart <= endTime && timeBlockedEnd >= endTime;

            //         if (valid == true || valid1 == true) {
            //             swal.fire("IS Co-ordinator-1 has Appointment on the same time", "", "error");
            //             return false;
            //         }
            //     }
            // }

            // for (h = 0; h < data2.length; h++) {
            //     if (data2[h].idate == meeting_startdate) {
            //         var tiLen = 5;
            //         var timeDB3 = data2[h].meeting_starttime.substring(0, tiLen);
            //         var timeDB4 = data2[h].meeting_endtime.substring(0, tiLen);

            //         var timeBlockedStart = timeDB3.replace(/:/g, "");
            //         var startTime = meeting_starttime.replace(/:/g, "");

            //         var timeBlockedEnd = timeDB4.replace(/:/g, "");
            //         var endTime = meeting_endtime.replace(/:/g, "");
            //         valid = timeBlockedStart <= startTime && timeBlockedEnd >= startTime;
            //         valid1 = timeBlockedStart <= endTime && timeBlockedEnd >= endTime;

            //         if (valid == true || valid1 == true) {
            //             swal.fire("IS Co-ordinator-2 has Appointment on the same time", "", "error");
            //             return false;
            //         }
            //     }
            // }

            var date = new Date();
            var currentDate = date.toLocaleString("en-GB", {
                year: "numeric",
                month: "2-digit",
                day: "2-digit",
            });

            var date1 = new Date(meeting_startdate);
            var MSdate1 = date1.toLocaleString("en-GB", {
                year: "numeric",
                month: "2-digit",
                day: "2-digit",
            });

            var twentyMinutesLater = new Date();
            twentyMinutesLater.setMinutes(twentyMinutesLater.getMinutes() + 2);
            var currentTime = new Date(twentyMinutesLater).toLocaleTimeString("en-GB");
            if (currentDate == MSdate1) {
                var th = 5;
                var currentTime1 = currentTime.substring(0, th);
                var s11 = meeting_starttime.replace(/:/g, "");
                var c11 = currentTime1.replace(/:/g, "");
                if (s11 < c11) {
                    swal.fire("Please Select Valid OVM 1 Meeting Time", "", "error");
                    return false;
                }
            }

            if (meeting_starttime == meeting_endtime) {
                swal.fire("OVM 1 Meeting Start Time and End Time should not be same", "", "error");
                return false;
            }
            if (meeting_starttime > meeting_endtime) {
                swal.fire("Please Select Valid OVM 1 Meeting Time", "", "error");
                return false;
            }

            var sTime = meeting_starttime.replace(/:/g, "");
            var eTime = meeting_endtime.replace(/:/g, "");
            var length = 4;
            var tsTime = sTime.substring(0, length);
            var teTime = eTime.substring(0, length);
            var diff = teTime - tsTime;
            if (diff > 200) {
                swal.fire("OVM 1 Meeting Maximum Time Duration is Two Hours", "", "error");
                return false;
            }
            if (diff < 30) {
                swal.fire("OVM 1 Meeting Minimum Time Duration is 30 Minutes", "", "error");
                return false;
            }
            // if (tsTime < 900) {
            //     swal.fire("OVM 1 Meeting Meeting Can be Scheduled from 9AM to 6PM only", "", "error");
            //     return false;
            // }
            // if (teTime > 1800) {
            //     swal.fire("OVM 1 Meeting Meeting Can be Scheduled from 9AM to 6PM only", "", "error");
            //     return false;
            // }

            // OVM 2 - Validation
            var meeting_startdate2 = document.getElementById('meeting_startdate2').value;
            if (meeting_startdate2 == "") {
                swal.fire("Please Select OVM 2 Meeting Start Date ", "", "error");
                return false;
            }

            var meeting_starttime2 = document.getElementById('meeting_starttime2').value;
            if (meeting_starttime2 == "") {
                swal.fire("Please Select OVM 2 Meeting Start Time", "", "error");
                return false;
            }

            var meeting_enddate2 = document.getElementById('meeting_enddate2').value;
            if (meeting_enddate2 == "") {
                swal.fire("Please Select OVM 2 Meeting End Date", "", "error");
                return false;
            }

            var meeting_endtime2 = document.getElementById('meeting_endtime2').value;
            if (meeting_endtime2 == "") {
                swal.fire("Please Select OVM 2 Meeting End Time", "", "error");
                return false;
            }

            // for (k = 0; k < data1.length; k++) {
            //     if (data1[k].idate == meeting_startdate) {
            //         var tiLen = 5;
            //         var timeDB1 = data1[k].meeting_starttime.substring(0, tiLen);
            //         var timeDB2 = data1[k].meeting_endtime.substring(0, tiLen);

            //         var timeBlockedStart = timeDB1.replace(/:/g, "");
            //         var startTime = meeting_starttime.replace(/:/g, "");

            //         var timeBlockedEnd = timeDB2.replace(/:/g, "");
            //         var endTime = meeting_endtime.replace(/:/g, "");
            //         valid = timeBlockedStart <= startTime && timeBlockedEnd >= startTime;
            //         valid1 = timeBlockedStart <= endTime && timeBlockedEnd >= endTime;

            //         if (valid == true || valid1 == true) {
            //             swal.fire("IS Co-ordinator-1 has Appointment on the same time", "", "error");
            //             return false;
            //         }
            //     }
            // }

            // for (h = 0; h < data2.length; h++) {
            //     if (data2[h].idate == meeting_startdate) {
            //         var tiLen = 5;
            //         var timeDB3 = data2[h].meeting_starttime.substring(0, tiLen);
            //         var timeDB4 = data2[h].meeting_endtime.substring(0, tiLen);

            //         var timeBlockedStart = timeDB3.replace(/:/g, "");
            //         var startTime = meeting_starttime.replace(/:/g, "");

            //         var timeBlockedEnd = timeDB4.replace(/:/g, "");
            //         var endTime = meeting_endtime.replace(/:/g, "");
            //         valid = timeBlockedStart <= startTime && timeBlockedEnd >= startTime;
            //         valid1 = timeBlockedStart <= endTime && timeBlockedEnd >= endTime;

            //         if (valid == true || valid1 == true) {
            //             swal.fire("IS Co-ordinator-2 has Appointment on the same time", "", "error");
            //             return false;
            //         }
            //     }
            // }

            var date = new Date();
            var currentDate = date.toLocaleString("en-GB", {
                year: "numeric",
                month: "2-digit",
                day: "2-digit",
            });

            var date1 = new Date(meeting_startdate);
            var MSdate1 = date1.toLocaleString("en-GB", {
                year: "numeric",
                month: "2-digit",
                day: "2-digit",
            });

            var twentyMinutesLater = new Date();
            twentyMinutesLater.setMinutes(twentyMinutesLater.getMinutes() + 2);
            var currentTime = new Date(twentyMinutesLater).toLocaleTimeString("en-GB");
            if (currentDate == MSdate1) {
                var th = 5;
                var currentTime1 = currentTime.substring(0, th);
                var s11 = meeting_starttime.replace(/:/g, "");
                var c11 = currentTime1.replace(/:/g, "");
                if (s11 < c11) {
                    swal.fire("Please Select Valid OVM 2 Meeting Time", "", "error");
                    return false;
                }
            }
            if (meeting_starttime2 == meeting_endtime2) {
                swal.fire("OVM 2 Meeting Start Time and End Time should not be same", "", "error");
                return false;
            }
            if (meeting_starttime2 > meeting_endtime2) {
                swal.fire("Please Select Valid OVM 2 Meeting Time", "", "error");
                return false;
            }

            var sTime = meeting_starttime2.replace(/:/g, "");
            var eTime = meeting_endtime2.replace(/:/g, "");
            var length = 4;
            var tsTime = sTime.substring(0, length);
            var teTime = eTime.substring(0, length);
            var diff = teTime - tsTime;
            if (diff > 200) {
                swal.fire("OVM 2 Meeting Maximum Time Duration is Two Hours", "", "error");
                return false;
            }
            if (diff < 30) {
                swal.fire("OVM 2 Meeting Minimum Time Duration is 30 Minutes", "", "error");
                return false;
            }
            // if (tsTime < 900) {
            //     swal.fire("OVM 2 Meeting Meeting Can be Scheduled from 9AM to 6PM only", "", "error");
            //     return false;
            // }
            // if (teTime > 1800) {
            //     swal.fire("OVM 2 Meeting Meeting Can be Scheduled from 9AM to 6PM only", "", "error");
            //     return false;
            // }
            // alert(meeting_startdate);

            if (createDateFromDateString(meeting_startdate) > createDateFromDateString(meeting_startdate2)) {

                swal.fire("OVM 1 Meeting should start after OVM 2 Meeting", "", "error");
                return false;
            }

            if (createDateFromDateString(meeting_startdate) === createDateFromDateString(meeting_startdate2) && meeting_starttime >= meeting_starttime2) {

                swal.fire("OVM 1 Meeting should start after OVM 2 Meeting", "", "error");
                return false;
            }

            // Check if OVM 1 Meeting starts before OVM 2 Meeting ends
            if (createDateFromDateString(meeting_startdate) === createDateFromDateString(meeting_startdate2) && meeting_starttime > meeting_endtime2) {
                swal.fire("OVM 1 Meeting should start after OVM 2 Meeting ends", "", "error");
                return false;
            }

            document.getElementById('meeting_status').value = a;
            if (a == 'Saved') {
                var swalText = 'Save';
            } else if (a == 'Sent') {
                var swalText = 'Schedule';
            } else {
                var swalText = a;
            }

            Swal.fire({

                title: "Do you want to " + swalText + " the Meeting?",
                text: "Please click 'Yes' to " + swalText + " the Meeting",
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
                    $(".loader").show();
                    document.getElementById('ovm_meet').submit(a);
                }
            })
        } else {
            var co_one = $('#is_coordinator1').val();
            var co_two = $('#is_coordinator2').val();
            var startdate = $('#meeting_startdate').val();

            if (co_one == "Select-IS-Coordinator-1") {
                swal.fire("Please Select IS Coordinator1 ", "", "error");
                return false;
            }

            if (data1.length > 10) {
                swal.fire("IS Co-ordinator-1 has Already Assigned with Ten Child", "", "error");
                return false;
            }
            if (data2.length > 10) {
                swal.fire("IS Co-ordinator-2 has Already Assigned with Ten Child", "", "error");
                return false;
            }

            data1 = data1.filter(i => startdate.includes(i.idate));
            const data1Len = data1.length;
            if (data1Len >= 2) {
                swal.fire("IS Co-ordinator-1 has Two Appointment on the same day", "", "error");
                return false;
            }

            data2 = data2.filter(j => startdate.includes(j.idate));
            const data2Len = data2.length;
            if (data2Len >= 2) {
                swal.fire("IS Co-ordinator-2 has Two Appointment on the same day", "", "error");
                return false;
            }

            // if (document.getElementById('meeting_startdate').value == document.getElementById('meeting_startdate2').value) {
            //     swal.fire("OVM 1 and OVM 2 Meeting date should not be same", "", "error");
            //     return false;
            // }

            // OVM 1 - Validation
            var meeting_startdate = document.getElementById('meeting_startdate').value;
            if (meeting_startdate == "") {
                swal.fire("Please Select OVM 1 Meeting Start Date ", "", "error");
                return false;
            }

            var meeting_starttime = document.getElementById('meeting_starttime').value;
            if (meeting_starttime == "") {
                swal.fire("Please Select OVM 1 Meeting Start Time", "", "error");
                return false;
            }

            var meeting_enddate = document.getElementById('meeting_enddate').value;
            if (meeting_enddate == "") {
                swal.fire("Please Select OVM 1 Meeting End Date", "", "error");
                return false;
            }

            var meeting_endtime = document.getElementById('meeting_endtime').value;
            if (meeting_endtime == "") {
                swal.fire("Please Select OVM 1 Meeting End Time", "", "error");
                return false;
            }

            // for (k = 0; k < data1.length; k++) {
            //     if (data1[k].idate == meeting_startdate) {
            //         var tiLen = 5;
            //         var timeDB1 = data1[k].meeting_starttime.substring(0, tiLen);
            //         var timeDB2 = data1[k].meeting_endtime.substring(0, tiLen);

            //         var timeBlockedStart = timeDB1.replace(/:/g, "");
            //         var startTime = meeting_starttime.replace(/:/g, "");

            //         var timeBlockedEnd = timeDB2.replace(/:/g, "");
            //         var endTime = meeting_endtime.replace(/:/g, "");
            //         valid = timeBlockedStart <= startTime && timeBlockedEnd >= startTime;
            //         valid1 = timeBlockedStart <= endTime && timeBlockedEnd >= endTime;

            //         if (valid == true || valid1 == true) {
            //             swal.fire("IS Co-ordinator-1 has Appointment on the same time", "", "error");
            //             return false;
            //         }
            //     }
            // }

            // for (h = 0; h < data2.length; h++) {
            //     if (data2[h].idate == meeting_startdate) {
            //         var tiLen = 5;
            //         var timeDB3 = data2[h].meeting_starttime.substring(0, tiLen);
            //         var timeDB4 = data2[h].meeting_endtime.substring(0, tiLen);

            //         var timeBlockedStart = timeDB3.replace(/:/g, "");
            //         var startTime = meeting_starttime.replace(/:/g, "");

            //         var timeBlockedEnd = timeDB4.replace(/:/g, "");
            //         var endTime = meeting_endtime.replace(/:/g, "");
            //         valid = timeBlockedStart <= startTime && timeBlockedEnd >= startTime;
            //         valid1 = timeBlockedStart <= endTime && timeBlockedEnd >= endTime;

            //         if (valid == true || valid1 == true) {
            //             swal.fire("IS Co-ordinator-2 has Appointment on the same time", "", "error");
            //             return false;
            //         }
            //     }
            // }

            var date = new Date();
            var currentDate = date.toLocaleString("en-GB", {
                year: "numeric",
                month: "2-digit",
                day: "2-digit",
            });

            var date1 = new Date(meeting_startdate);
            var MSdate1 = date1.toLocaleString("en-GB", {
                year: "numeric",
                month: "2-digit",
                day: "2-digit",
            });

            var twentyMinutesLater = new Date();
            twentyMinutesLater.setMinutes(twentyMinutesLater.getMinutes() + 2);
            var currentTime = new Date(twentyMinutesLater).toLocaleTimeString("en-GB");
            if (currentDate == MSdate1) {
                var th = 5;
                var currentTime1 = currentTime.substring(0, th);
                var s11 = meeting_starttime.replace(/:/g, "");
                var c11 = currentTime1.replace(/:/g, "");
                if (s11 < c11) {
                    swal.fire("Please Select Valid OVM 1 Meeting Time", "", "error");
                    return false;
                }
            }
            if (meeting_starttime == meeting_endtime) {
                swal.fire("OVM 1 Meeting Start Time and End Time should not be same", "", "error");
                return false;
            }
            if (meeting_starttime > meeting_endtime) {
                swal.fire("Please Select Valid OVM 1 Meeting Time", "", "error");
                return false;
            }

            var sTime = meeting_starttime.replace(/:/g, "");
            var eTime = meeting_endtime.replace(/:/g, "");
            var length = 4;
            var tsTime = sTime.substring(0, length);
            var teTime = eTime.substring(0, length);
            var diff = teTime - tsTime;
            if (diff > 200) {
                swal.fire("OVM 1 Meeting Maximum Time Duration is Two Hours", "", "error");
                return false;
            }
            if (diff < 30) {
                swal.fire("OVM 1 Meeting Minimum Time Duration is 30 Minutes", "", "error");
                return false;
            }
            // if (tsTime < 900) {
            //     swal.fire("OVM 1 Meeting Meeting Can be Scheduled from 9AM to 6PM only", "", "error");
            //     return false;
            // }
            // if (teTime > 1800) {
            //     swal.fire("OVM 1 Meeting Meeting Can be Scheduled from 9AM to 6PM only", "", "error");
            //     return false;
            // }

            // OVM 2 - Validation
            var meeting_startdate = document.getElementById('meeting_startdate2').value;
            if (meeting_startdate == "") {
                swal.fire("Please Select OVM 2 Meeting Start Date ", "", "error");
                return false;
            }

            var meeting_starttime = document.getElementById('meeting_starttime2').value;
            if (meeting_starttime == "") {
                swal.fire("Please Select OVM 2 Meeting Start Time", "", "error");
                return false;
            }

            var meeting_enddate = document.getElementById('meeting_enddate2').value;
            if (meeting_enddate == "") {
                swal.fire("Please Select OVM 2 Meeting End Date", "", "error");
                return false;
            }

            var meeting_endtime = document.getElementById('meeting_endtime2').value;
            if (meeting_endtime == "") {
                swal.fire("Please Select OVM 2 Meeting End Time", "", "error");
                return false;
            }

            // for (k = 0; k < data1.length; k++) {
            //     if (data1[k].idate == meeting_startdate) {
            //         var tiLen = 5;
            //         var timeDB1 = data1[k].meeting_starttime.substring(0, tiLen);
            //         var timeDB2 = data1[k].meeting_endtime.substring(0, tiLen);

            //         var timeBlockedStart = timeDB1.replace(/:/g, "");
            //         var startTime = meeting_starttime.replace(/:/g, "");

            //         var timeBlockedEnd = timeDB2.replace(/:/g, "");
            //         var endTime = meeting_endtime.replace(/:/g, "");
            //         valid = timeBlockedStart <= startTime && timeBlockedEnd >= startTime;
            //         valid1 = timeBlockedStart <= endTime && timeBlockedEnd >= endTime;

            //         if (valid == true || valid1 == true) {
            //             swal.fire("IS Co-ordinator-1 has Appointment on the same time", "", "error");
            //             return false;
            //         }
            //     }
            // }

            // for (h = 0; h < data2.length; h++) {
            //     if (data2[h].idate == meeting_startdate) {
            //         var tiLen = 5;
            //         var timeDB3 = data2[h].meeting_starttime.substring(0, tiLen);
            //         var timeDB4 = data2[h].meeting_endtime.substring(0, tiLen);

            //         var timeBlockedStart = timeDB3.replace(/:/g, "");
            //         var startTime = meeting_starttime.replace(/:/g, "");

            //         var timeBlockedEnd = timeDB4.replace(/:/g, "");
            //         var endTime = meeting_endtime.replace(/:/g, "");
            //         valid = timeBlockedStart <= startTime && timeBlockedEnd >= startTime;
            //         valid1 = timeBlockedStart <= endTime && timeBlockedEnd >= endTime;

            //         if (valid == true || valid1 == true) {
            //             swal.fire("IS Co-ordinator-2 has Appointment on the same time", "", "error");
            //             return false;
            //         }
            //     }
            // }

            var date = new Date();
            var currentDate = date.toLocaleString("en-GB", {
                year: "numeric",
                month: "2-digit",
                day: "2-digit",
            });

            var date1 = new Date(meeting_startdate);
            var MSdate1 = date1.toLocaleString("en-GB", {
                year: "numeric",
                month: "2-digit",
                day: "2-digit",
            });

            var twentyMinutesLater = new Date();
            twentyMinutesLater.setMinutes(twentyMinutesLater.getMinutes() + 2);
            var currentTime = new Date(twentyMinutesLater).toLocaleTimeString("en-GB");
            if (currentDate == MSdate1) {
                var th = 5;
                var currentTime1 = currentTime.substring(0, th);
                var s11 = meeting_starttime.replace(/:/g, "");
                var c11 = currentTime1.replace(/:/g, "");
                if (s11 < c11) {
                    swal.fire("Please Select Valid OVM 2 Meeting Time", "", "error");
                    return false;
                }
            }
            if (meeting_starttime == meeting_endtime) {
                swal.fire("OVM 2 Meeting Start Time and End Time should not be same", "", "error");
                return false;
            }
            if (meeting_starttime > meeting_endtime) {
                swal.fire("Please Select Valid OVM 2 Meeting Time", "", "error");
                return false;
            }

            var sTime = meeting_starttime.replace(/:/g, "");
            var eTime = meeting_endtime.replace(/:/g, "");
            var length = 4;
            var tsTime = sTime.substring(0, length);
            var teTime = eTime.substring(0, length);
            var diff = teTime - tsTime;
            if (diff > 200) {
                swal.fire("OVM 2 Meeting Maximum Time Duration is Two Hours", "", "error");
                return false;
            }
            if (diff < 30) {
                swal.fire("OVM 2 Meeting Minimum Time Duration is 30 Minutes", "", "error");
                return false;
            }
            // if (tsTime < 900) {
            //     swal.fire("OVM 2 Meeting Meeting Can be Scheduled from 9AM to 6PM only", "", "error");
            //     return false;
            // }
            // if (teTime > 1800) {
            //     swal.fire("OVM 2 Meeting Meeting Can be Scheduled from 9AM to 6PM only", "", "error");
            //     return false;
            // }

            // document.getElementById('meeting_status').value = a;
            if (a == 'Saved') {
                var swalText = 'Save';
            } else if (a == 'Sent') {
                var swalText = 'Allocate';
            } else {
                var swalText = a;
            }

            Swal.fire({

                title: "Do you want to " + swalText + " the Meeting?",
                text: "Please click 'Yes' to " + swalText + " the Meeting",
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
                    $(".loader").show();
                    document.getElementById('ovm_meet').submit(a);
                }
            })
        }

    }

    function convertTimeFormat(input) {
        var inputValue = input;
        var timeParts = inputValue.split(':');
        let hours = parseInt(timeParts[0]);
        var minutes = timeParts[1];
        let meridian = '';

        if (hours >= 12) {
            meridian = ' PM';
            if (hours > 12) {
                hours -= 12;
            }
        } else {
            meridian = ' AM';
            if (hours === 0) {
                hours = 12;
            }
        }

        var formattedTime = `${hours}:${minutes}${meridian}`;
        return formattedTime;
    }
</script>
<script>
    var co = <?php echo (json_encode($rows)); ?>;
    // console.log(co);
    var co1 = co[0].is_coordinator1;
    var co2 = co[0].is_coordinator2;

    var selectobject1 = document.getElementById("is_coordinator1");
    var selectobject2 = document.getElementById("is_coordinator2");

    for (var i = 0; i < selectobject2.length; i++) {
        if (selectobject2.options[i].value == co1)
            selectobject2.remove(i);
    }
    if (co2 != 0) {
        for (var i = 0; i < selectobject1.length; i++) {
            if (selectobject1.options[i].value == co2)
                selectobject1.remove(i);
        }
    }

    $(document).ready(function() {
        getEventsDB("is_coordinator1");
        if (co2 != []) {
            getEventsDB('is_coordinator2');
        }
    });

    function coonotes() {
        const status = document.querySelector('#status').value;
        var meetingLocation = document.querySelector('#meeting_location');
        var meeting_startdate = document.querySelector('#meeting_startdate');
        var meeting_enddate = document.querySelector('#meeting_enddate');
        var meeting_starttime = document.querySelector('#meeting_starttime');
        var meeting_endtime = document.querySelector('#meeting_endtime');
        var meeting_location2 = document.querySelector('#meeting_location2');
        var meeting_startdate2 = document.querySelector('#meeting_startdate2');
        var meeting_enddate2 = document.querySelector('#meeting_enddate2');
        var meeting_starttime2 = document.querySelector('#meeting_starttime2');
        var meeting_endtime2 = document.querySelector('#meeting_endtime2');
        var meeting_startdate = document.querySelector('#meeting_startdate');
        const actionButton = document.querySelector('#actionButton');
        const coord_notes = document.querySelector('.coord_notes');
        const meeting_status = document.querySelector('#meeting_status');

        if (status == "") {
            document.querySelector('.coord_notes').style.display = "none";
            meetingLocation.readOnly = false;

        } else if (status == "Declined") {
            document.querySelector('.coord_notes').style.display = "block";
            meetingLocation.readOnly = true;
            meeting_startdate.readOnly = true;
            meeting_enddate.readOnly = true;
            meeting_starttime.readOnly = true;
            meeting_endtime.readOnly = true;
            meeting_location2.readOnly = true;
            meeting_startdate2.readOnly = true;
            meeting_enddate2.readOnly = true;
            meeting_starttime2.readOnly = true;
            meeting_endtime2.readOnly = true;
            meeting_startdate.readOnly = true;
            actionButton.textContent = "Decline";
            actionButton.style.backgroundColor = "Orange";
            actionButton.style.color = "black";
            actionButton.style.display = "inline-block";
            meeting_status.value = "Declined";
            actionButton.setAttribute('onclick', "validateForm('Decline')");
            // if (coord_notes == "") {
            //     swal.fire("Please Enter the Coordinator Notes", "", "error");
            //     return false;
            // }


        } else if (status == "Accept") {
            document.querySelector('.coord_notes').style.display = "block";
            meetingLocation.readOnly = true;
            meeting_startdate.readOnly = true;
            meeting_enddate.readOnly = true;
            meeting_starttime.readOnly = true;
            meeting_endtime.readOnly = true;
            meeting_location2.readOnly = true;
            meeting_startdate2.readOnly = true;
            meeting_enddate2.readOnly = true;
            meeting_starttime2.readOnly = true;
            meeting_endtime2.readOnly = true;
            meeting_startdate.readOnly = true;
            actionButton.textContent = "Accept";
            actionButton.style.backgroundColor = "Green";
            actionButton.style.color = "white";
            actionButton.style.display = "inline-block";
            meeting_status.value = "Accept";
            actionButton.setAttribute('onclick', "validateForm('Accept')");
            // if (coord_notes == "") {
            //     swal.fire("Please Enter the Coordinator Notes", "", "error");
            //     return false;
            // }

        } else if (status == "Forced Closure") {
            document.querySelector('.coord_notes').style.display = "block";
            meetingLocation.readOnly = false;
            meeting_startdate.readOnly = false;
            meeting_enddate.readOnly = false;
            meeting_starttime.readOnly = false;
            meeting_endtime.readOnly = false;
            meeting_location2.readOnly = false;
            meeting_startdate2.readOnly = false;
            meeting_enddate2.readOnly = false;
            meeting_starttime2.readOnly = false;
            meeting_endtime2.readOnly = false;
            meeting_startdate.readOnly = false;

            actionButton.textContent = "Forced Closure";
            // Add CSS styling
            actionButton.style.backgroundColor = "red";
            actionButton.style.color = "white";
            actionButton.style.display = "inline-block";

            actionButton.setAttribute('onclick', "validateForm('Forced Closure')");
            // if (coord_notes == "") {
            //     swal.fire("Please Enter the Coordinator Notes", "", "error");
            //     return false;
            // }

        } else {
            document.querySelector('.coord_notes').style.display = "none";
            meetingLocation.readOnly = false;
        }

    }
</script>
@endsection