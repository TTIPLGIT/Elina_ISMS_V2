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

    #invite {
        display: none;
    }

    #co_one,
    #co_two {
        padding: 0 0 0 5px;
        background: transparent;
    }

    .readonly {
        background-color: #8080803d !important;
    }

    .select2-container {
        width: 100% !important;
    }

    .select2-container--default .select2-selection--multiple .select2-selection__choice {
        color: black !important;
    }
</style>

<div class="main-content" style="position:absolute !important; z-index: -2!important; ">

    <!-- Main Content -->
    <section class="section">

        {{ Breadcrumbs::render('ovm_allocation.create') }}

        <div class="section-body mt-1">
            <h5 class="text-center" style="color:darkblue">Allocation of OVM Meeting</h5>
            <div class="row">
                <div class="col-12">
                    <form action="{{route('ovm_allocation.store')}}" method="POST" id="ovmmeet1" enctype="multipart/form-data">
                        @csrf
                        <div class="card">
                            <div class="card-body">

                                <div class="row is-coordinate">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="control-label">Enrollment ID<span class="error-star" style="color:red;">*</span></label>
                                            <select class="form-control" id="enrollment_child_num" name="enrollment_child_num" onchange="GetChilddetails()">
                                                <option value="">Select-Enrollment</option>
                                                @foreach($rows['enrollment_details'] as $key=>$row)
                                                @php
                                                $enrollmentId = $row['enrollment_id'];
                                                $count = DB::table('ovm_allocation')
                                                ->where('enrollment_id', $enrollmentId)
                                                ->count();
                                                @endphp
                                                @if ($count === 1)
                                                <option value="{{$row['enrollment_child_num']}}">{{ $row['enrollment_child_num']}} ( {{$row['child_name']}} )</option>
                                                @endif
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <input type="hidden" id="user_id" name="user_id">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="control-label">Child ID</label>
                                            <input class="form-control readonly" type="text" id="child_id" name="child_id" placeholder="Child ID" autocomplete="off" readonly>
                                            <input type="hidden" id="enrollment_id" name="enrollment_id" autocomplete="off" readonly>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="control-label">Child Name</label>
                                            <input class="form-control readonly" type="text" id="child_name" name="child_name" oninput="Childname(event)" maxlength="20" value="" placeholder="Enter Name" autocomplete="off" readonly>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group ">
                                            <label class="control-label">IS Co-ordinator-1<span class="error-star" style="color:red;">*</span></label>
                                            <div style="display: flex;">
                                                <input class="form-control readonly" type="text" id="is_coordinator1" name="is_coordinator1" maxlength="20" placeholder="Enter Name" autocomplete="off" readonly>
                                                <button style="display: none;" id="co_one" title="Availability Calendar" class="btn" data-toggle="modal" data-target="#calModal" type="button">
                                                    <i style="color: blue;font-size: 20px;" class="fa fa-calendar" aria-hidden="true"></i></button>

                                            </div>
                                            <input type="hidden" id="is_coordinator1id" name="is_coordinator1id" value="">
                                            <input type="hidden" id="is_coordinator1current">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="control-label">IS Co-ordinator-2</label>
                                            <div style="display: flex;">
                                                <input class="form-control readonly" type="text" id="is_coordinator2" name="is_coordinator2" maxlength="20" placeholder="Enter Name" autocomplete="off" readonly>
                                            </div>
                                            <input type="hidden" id="is_coordinator2id" name="is_coordinator2id" value="">

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card" style="margin: 10px 0px 0px 0px;">
                            <div class="card-body">
                                <h5 class="text-center" style="color:darkblue">OVM 1 Meeting Details</h5>
                                <div class="row is-coordinate">
                                    <div class="form-group row">
                                        <label class="col-sm-2 col-form-label">Location<span class="error-star" style="color:red;">*</span></label>
                                        <div class="col-sm-4">
                                            <input class="form-control" type="text" id="meeting_location" name="meeting_location" title="Meeting Location" maxlength="20" value="" placeholder="Enter Location" autocomplete="off">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-2 col-form-label">Start Date and Time<span class="error-star" style="color:red;">*</span></label>
                                        <div class="col-sm-4">
                                            <div class="inner-addon right-addon">
                                                <i class="glyphicon fas fa-calendar-alt"></i>
                                                <input type='text' class="form-control meeting_date" id='meeting_startdate' name="meeting_startdate" title="Meeting Start Date" onchange="autodateupdate(this)" placeholder="DD/MM/YYYY" autocomplete="off">
                                            </div>
                                        </div>
                                        <div class="col-sm-2">
                                            <div class="content">
                                                <input class="form-control" type="time" id="meeting_starttime" name="meeting_starttime" title="Meeting Start Time" onchange="autoupdatedescription1()">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-2 col-form-label">End Date and Time<span class="error-star" style="color:red;">*</span></label>
                                        <div class="col-sm-4">
                                            <div class="inner-addon right-addon">
                                                <i class="glyphicon fas fa-calendar-alt"></i>
                                                <input type='text' class="form-control meeting_date" id="meeting_enddate" name="meeting_enddate" title="Meeting End Date" onchange="autodateupdate(this)" placeholder="DD/MM/YYYY" autocomplete="off">
                                            </div>
                                        </div>
                                        <div class="col-sm-2">
                                            <div class="content">
                                                <input class="form-control" type="time" id="meeting_endtime" name="meeting_endtime" title="Meeting End Time" onchange="autoupdatedescription1()">
                                            </div>
                                        </div>
                                    </div>
                                    <input type="hidden" name="meeting_status" id="meeting_status">
                                </div>
                            </div>
                        </div>

                        <div class="card" style="margin: 10px 0px 0px 0px;">
                            <div class="card-body">
                                <h5 class="text-center" style="color:darkblue">OVM 2 Meeting Details</h5>
                                <div class="row is-coordinate">
                                    <div class="form-group row">
                                        <label class="col-sm-2 col-form-label">Location<span class="error-star" style="color:red;">*</span></label>
                                        <div class="col-sm-4">
                                            <input class="form-control" type="text" id="meeting_location2" name="meeting_location2" title="Meeting Location" maxlength="20" value="" placeholder="Enter Location" autocomplete="off">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-2 col-form-label">Start Date and Time<span class="error-star" style="color:red;">*</span></label>
                                        <div class="col-sm-4">
                                            <div class="inner-addon right-addon">
                                                <i class="glyphicon fas fa-calendar-alt"></i>
                                                <input type='text' class="form-control meeting_date" id="meeting_startdate2" name="meeting_startdate2" title="Meeting Start Date" onchange="autodateupdate2(this)" placeholder="DD/MM/YYYY" autocomplete="off">
                                            </div>
                                        </div>
                                        <div class="col-sm-2">
                                            <div class="content">
                                                <input class="form-control" type="time" id="meeting_starttime2" name="meeting_starttime2" title="Meeting Start Time" onchange="autoupdatedescription2()">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-2 col-form-label">End Date and Time<span class="error-star" style="color:red;">*</span></label>
                                        <div class="col-sm-4">
                                            <div class="inner-addon right-addon">
                                                <i class="glyphicon fas fa-calendar-alt"></i>
                                                <input type='text' class="form-control meeting_date" id="meeting_enddate2" name="meeting_enddate2" title="Meeting End Date" onchange="autodateupdate2(this)" placeholder="DD/MM/YYYY" autocomplete="off">
                                            </div>
                                        </div>
                                        <div class="col-sm-2">
                                            <div class="content">
                                                <input class="form-control" type="time" id="meeting_endtime2" name="meeting_endtime2" title="Meeting End Time" onchange="autoupdatedescription2()">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card" style="margin: 10px 0px 0px 0px;">
                            <div class="card-body">
                                <div class="form-group">
                                    <label class="form-label">Meeting Description</label>
                                    <textarea class="form-control" id="meeting_description" name="meeting_description">
                                                @if($email_allocation != [])
                                                {{$email_allocation[0]['email_body']}}
                                                @endif
                                            </textarea>
                                    <p style="color: red;margin: 0px 0px 0px 5px;">Note : Do not add <strong>Thanks and Regards</strong> at the end of the meeting description</p>
                                </div>
                            </div>
                        </div>
                    </form>

                </div>
                <br>
            </div>
        </div>
        <div class="row text-center" style="    margin: 5px;">
            <div class="col-md-12">
                <a type="button" class="btn btn-warning text-white" onclick="validateForm('Saved')" name="type" value="Saved">Save</a>
                <a type="button" class="btn btn-success text-white" onclick="validateForm('Sent')" name="type" value="Sent">Send</a>
                <a type="button" class="btn btn-labeled back-btn" title="Back" href="{{ route('ovm_allocation.index') }}" style="color:white !important">
                    <span class="btn-label" style="font-size:13px !important;"><i class="fa fa-arrow-left"></i></span> Back</a>
            </div>
        </div>
    </section>
</div>

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
<script src="https://cdnjs.cloudflare.com/ajax/libs/tinymce/4.5.6/tinymce.min.js"></script>
<script src="http://cdnjs.cloudflare.com/ajax/libs/tinymce/4.5.6/jquery.tinymce.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.26.0/moment.min.js"></script>
@include('ovm1.cal')
<!-- End -->




<script type="text/javascript">
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
            content_style: 'body { font-family:Helvetica,Arial,sans-serif; font-size:14px }'
        });
        // event.preventDefault()
    });

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    function GetChilddetails() {
        var enrollment_child_num = $("select[name='enrollment_child_num']").val();

        if (enrollment_child_num != "") {
            $.ajax({
                url: "{{ url('/userregisterfee/enrollmentlist') }}",
                type: 'POST',
                data: {
                    'enrollment_child_num': enrollment_child_num,
                    _token: '{{csrf_token()}}'
                }
            }).done(function(data) {
                // console.log(data);
                if (data != '[]') {
                    var optionsdata = "";
                    document.getElementById('child_id').value = data[3].child_id;
                    document.getElementById('child_name').value = data[3].child_name;
                    document.getElementById('enrollment_id').value = data[3].enrollment_id;
                    document.getElementById('is_coordinator1').value = data[3].is_coordinator1_name;

                    document.getElementById('is_coordinator1id').value = data[3].is_coordinator1;
                    document.getElementById('is_coordinator2').value = data[3].is_coordinator2_name;

                    document.getElementById('is_coordinator2id').value = data[3].is_coordinator2;


                    document.getElementById('user_id').value = data[0].user_id;
                    //iscoordinatorfn(data[3].is_coordinator1);
                } else {
                    document.getElementById('child_name');
                    var ddd = '<option value="child_name">Select Enrollment_child_num</option>';
                    var demonew = $('#child_name').html(ddd);
                }
            })
        } else {
            document.getElementById('initiated_by');
            var ddd = '<option value="initiated_by">Select Enrollment_child_num</option>';
            var demonew = $('#initiated_by').html(ddd);
        }
    };
</script>

<script>
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

        //...
    }

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
                var unavailableDates = ['2023-04-08', '2023-04-09', '2023-04-15']; // Array of unavailable dates
                var calendar = new Calendar('#calendar1', data1, unavailableDates);
                // console.log(data1.length);

            } else if (col == 'col2') {
                data2 = [];
                for (let index = 0; index < response.length; index++) {
                    const eventvalue = response[index];
                    data2.push(eventvalue);
                }
                $('#calendar2').html('');
                var unavailableDates = ['2023-04-08', '2023-04-09', '2023-04-15']; // Array of unavailable dates
                var calendar = new Calendar('#calendar2', data2, unavailableDates);

            }

        });

    }

    function validateForm(a) {
        if (document.getElementById('enrollment_child_num').value == "") {
            swal.fire("Please Select Enrolment Number", "", "error");
            return false;
        }

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

        // OVM 1 - Validation
        if (document.getElementById('meeting_location').value == "") {
            swal.fire("Please Enter OVM 1 Meeting Location", "", "error");
            return false;
        }

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

        if (meeting_startdate == currentDate) {
            // If the meeting start date is the same as the current date, compare the times
            var meeting_starttime = document.getElementById('meeting_starttime').value;
            var currentHourMinute = currentTime.substring(0, 5); // Extract the HH:MM part

            if (meeting_starttime < currentHourMinute) {
                swal.fire("Please Select a Valid OVM 1 Meeting Time", "", "error");
                return false;
            }
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
        //     swal.fire("OVM 1 Meeting Meeting Can be Schedule from 9AM to 6PM only", "", "error");
        //     return false;
        // }
        // if (teTime > 1800) {
        //     swal.fire("OVM 1 Meeting Meeting Can be Schedule from 9AM to 6PM only", "", "error");
        //     return false;
        // }

        // OVM 2 - Validation
        if (document.getElementById('meeting_location2').value == "") {
            swal.fire("Please Enter OVM 2 Meeting Location", "", "error");
            return false;
        }

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
        //     swal.fire("OVM 2 Meeting Can be Schedule from 9AM to 6PM only", "", "error");
        //     return false;
        // }
        // if (teTime > 1800) {
        //     swal.fire("OVM 2 Meeting Can be Schedule from 9AM to 6PM only", "", "error");
        //     return false;
        // }
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
        // if (document.getElementById('meeting_startdate').value == document.getElementById('meeting_startdate2').value) {
        //     swal.fire("OVM 1 and OVM 2 Meeting date should not be same", "", "error");
        //     return false;
        // }
        if (document.getElementById('meeting_startdate').value == document.getElementById('meeting_startdate2').value) {
            const meeting1Date = document.getElementById('meeting_startdate').value;
            const meeting1TimeStart = document.getElementById('meeting_starttime').value;
            const meeting1TimeEnd = document.getElementById('meeting_endtime').value;
            const [m1Day, m1Month, m1Year] = meeting1Date.split('/').map(Number);
            const [m1HoursStart, m1MinutesStart] = meeting1TimeStart.split(':').map(Number);
            const [m1HoursEnd, m1MinutesEnd] = meeting1TimeEnd.split(':').map(Number);
            const meeting1StartTime = new Date(m1Year, m1Month - 1, m1Day, m1HoursStart, m1MinutesStart);
            const meeting1EndTime = new Date(m1Year, m1Month - 1, m1Day, m1HoursEnd, m1MinutesEnd);
            const meeting2Date = document.getElementById('meeting_startdate2').value;
            const meeting2TimeStart = document.getElementById('meeting_starttime2').value;
            const [m2HoursStart, m2MinutesStart] = meeting2TimeStart.split(':').map(Number);
            const meeting2StartTime = new Date(m1Year, m1Month - 1, m1Day, m2HoursStart, m2MinutesStart);
            if (meeting2StartTime < meeting1StartTime) {
                swal.fire("OVM 2 cannot be scheduled before OVM 1", "", "error");
                return false;
            } else if (meeting2StartTime >= meeting1StartTime && meeting2StartTime < meeting1EndTime) {
                swal.fire("OVM 2 cannot be scheduled at the same time as OVM 1", "", "error");
                return false;
            }
        }
        document.getElementById('meeting_status').value = a;
        if (a == 'Saved') {
            var swalText = 'Save';
        } else if (a == 'Sent') {
            var swalText = 'Allocate';
        }
        var meeting_startdate1 = document.querySelector('#meeting_startdate').value;

        var meeting_enddate1 = document.querySelector('#meeting_enddate').value;

        var meeting_starttime1 = document.querySelector('#meeting_starttime').value;

        var meeting_endtime1 = document.querySelector('#meeting_endtime').value;

        var meeting_startdate2 = document.querySelector('#meeting_startdate2').value;

        var meeting_enddate2 = document.querySelector('#meeting_enddate2').value;

        var meeting_starttime2 = document.querySelector('#meeting_starttime2').value;

        var meeting_endtime2 = document.querySelector('#meeting_endtime2').value;
        var is_coo1 = document.querySelector('#is_coordinator1id').value;

        var is_coo2 = document.querySelector('#is_coordinator2id').value;
        var enrollment_id = document.querySelector('#enrollment_id').value;

        $.ajax({
            type: 'GET', // Adjust HTTP method as needed
            url: '/meeting/date/validation',
            data: {
                // Add data to be sent with the AJAX request, if any
                'meeting_startdate1': meeting_startdate1,
                'meeting_starttime1': meeting_starttime1,
                'meeting_endtime1': meeting_endtime1,
                'meeting_startdate2': meeting_startdate2,
                'meeting_starttime2': meeting_starttime2,
                'meeting_endtime2': meeting_endtime2,
                'is_coo1': is_coo1,
                'is_coo2': is_coo2,
                'enrollment_id': enrollment_id,
                _token: '{{ csrf_token() }}',
            },
            success: function(response) {
                // console.log(response);
                // Handle the success response
                // Display the Swal confirmation dialog
                if (response.rows.length === 0) {
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
                            document.getElementById('ovmmeet1').submit(a);
                        }
                    });
                } else {
                    Swal.fire({
                        title: "Error",
                        text: "The IS-Coordinator is not available to " + swalText + " the Meeting.",
                        icon: "error"
                    });

                }
            },
            error: function(error) {
                // Handle errors, e.g., display an error message
                Swal.fire({
                    title: "Error",
                    text: "The IS-Coordinator is not available to " + swalText + " the Meeting.",
                    icon: "error"
                });
            }
        });




    }

    function autodateupdate(datev) {
        var md1 = datev.value;
        var md2 = $('#meeting_startdate2').val();
        // console.log(md2 != '');
        if (md1 != '' && md2 != '') {
            var [d1, m1, y1] = md1.split("/");
            var [d2, m2, y2] = md2.split("/");
            var dateObj1 = new Date(`${y1}/${m1}/${d1}`);
            var dateObj2 = new Date(`${y2}/${m2}/${d2}`);
            dateObj1.setHours(0, 0, 0, 0);
            dateObj2.setHours(0, 0, 0, 0);
            if (dateObj1.getTime() === dateObj2.getTime()) {
                // swal.fire("OVM 1 and OVM 2 Meeting Cant be Schedule on the same day", "", "error");
                // $('#meeting_startdate').val('');
                // $('#meeting_enddate').val('');
                // return false;
            } else {
                if (dateObj1 > dateObj2) {
                    swal.fire("OVM 1 can't able to Schedule before OVM 2", "", "error");
                    $('#meeting_startdate').val('');
                    $('#meeting_enddate').val('');
                    return false;
                }
            }
        }
        $('#meeting_startdate').val(datev.value);
        $('#meeting_enddate').val(datev.value);
        autoupdatedescription1();
    }

    function autodateupdate2(datev) {
        var md1 = $('#meeting_startdate').val();
        var md2 = datev.value;
        if (md1 != '' && md2 != '') {
            var [d1, m1, y1] = md1.split("/");
            var [d2, m2, y2] = md2.split("/");
            var dateObj1 = new Date(`${y1}/${m1}/${d1}`);
            var dateObj2 = new Date(`${y2}/${m2}/${d2}`);
            dateObj1.setHours(0, 0, 0, 0);
            dateObj2.setHours(0, 0, 0, 0);
            if (dateObj1.getTime() === dateObj2.getTime()) {
                // swal.fire("OVM 1 and OVM 2 Meeting Cant be Schedule on the same day", "", "error");
                // $('#meeting_startdate2').val('');
                // $('#meeting_enddate2').val('');
                // return false;
            } else {
                if (dateObj1 > dateObj2) {
                    swal.fire("OVM 2 can't able to Schedule before OVM 1", "", "error");
                    $('#meeting_startdate2').val('');
                    $('#meeting_enddate2').val('');
                    return false;
                }
            }
        }
        $('#meeting_startdate2').val(datev.value);
        $('#meeting_enddate2').val(datev.value);
        autoupdatedescription2();
    }

    var repeate1;
    var repeate2;

    function autoupdatedescription1() {
        var mDate1 = document.getElementById('meeting_startdate').value;
        var mTime1_s = document.getElementById('meeting_starttime').value;
        mTime1_s = convertTimeFormat(mTime1_s);
        var mTime1_e = document.getElementById('meeting_endtime').value;
        mTime1_e = convertTimeFormat(mTime1_e);

        if (mDate1 != '' && mTime1_s != '' && mTime1_e != '') {
            var text1 = mDate1 + ' from ' + mTime1_s + ' to ' + mTime1_e + '(IST) (OVM1 date and time)';
            var content = tinymce.get('meeting_description').getContent();
            if (repeate1 == undefined) {
                content = content.replace(/ovm1MeetingDetails/g, text1);
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
        mTime2_s = convertTimeFormat(mTime2_s);
        var mTime2_e = document.getElementById('meeting_endtime2').value;
        mTime2_e = convertTimeFormat(mTime2_e);
        // 
        if (mDate2 != '' && mTime2_s != '' && mTime2_e != '') {
            var text2 = mDate2 + ' from ' + mTime2_s + ' to ' + mTime2_e + '(IST) (OVM2 date and time)';
            var content = tinymce.get('meeting_description').getContent();
            if (repeate2 == undefined) {
                content = content.replace(/ovm2MeetingDetails/g, text2);
            } else {
                content = content.replace(repeate2, text2);
            }
            tinymce.get('meeting_description').setContent(content);
            repeate2 = text2;
        }
    }

    $(function() {
        $('.meeting_date').datepicker({
            dateFormat: 'dd/mm/yy',
            minDate: 0,
            changeMonth: true,
            changeYear: true,
        });
    });

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
@endsection