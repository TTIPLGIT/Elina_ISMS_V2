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

<div class="main-content">

  <!-- Main Content -->
  <section class="section">

    {{ Breadcrumbs::render('Newmeetinginvite2') }}

    <div class="section-body mt-1">
      <h5 class="text-center" style="color:darkblue">OVM-2 Meeting Invite</h5>
      <div class="row">
        <div class="col-12">
          <form action="{{route('ovm2.store')}}" method="POST" id="ovm2" enctype="multipart/form-data">
            @csrf
            <div class="card">
              <div class="card-body">
                <div class="row is-coordinate">
                  <div class="col-md-4">
                    <div class="form-group">
                      <label class="control-label required">Enrollment ID</label>
                      <select class="form-control" id="enrollment_child_num" name="enrollment_child_num" onchange="GetChilddetails()" required>
                        <option value="">Select-Enrollment</option>
                        @foreach($rows['enrollment_details'] as $key=>$row)
                        <option value="{{$row['enrollment_child_num']}}">{{ $row['enrollment_child_num']}} ( {{$row['child_name']}} )</option>
                        @endforeach

                      </select>


                    </div>
                  </div>


                  <div class="col-md-4">
                    <div class="form-group ">
                      <label class="control-label required">Child ID</label>
                      <input class="form-control readonly" type="text" id="child_id" name="child_id" placeholder="Child ID" autocomplete="off" readonly>
                      <input type="hidden" id="enrollment_id" name="enrollment_id" autocomplete="off" readonly>
                    </div>
                  </div>



                  <div class="col-md-4">
                    <div class="form-group ">
                      <label class="control-label required">Child Name</label>
                      <input class="form-control readonly" type="text" id="child_name" name="child_name" placeholder="Enter Name" readonly autocomplete="off">
                    </div>
                  </div>

                  <div class="col-md-4">
                    <div class="form-group ">
                      <label class="control-label required">IS Co-ordinator1</label>
                      <div style="display: flex;">
                        <select class="form-control" id="is_coordinator1" name="is_coordinator1" onchange="iscoordinatorfn(event)" required readonly style="pointer-events: none !important;">
                          <option>Select-IS-Coordinator-1</option>
                          @foreach($rows['iscoordinators'] as $key=>$row)
                          <option value="{{$row['id']}}">{{ $row['name']}}</option>
                          @endforeach
                        </select>
                        <button style="display: none;" id="co_one" title="Availability Calendar" class="btn" data-toggle="modal" data-target="#calModal" type="button">
                          <i style="color: blue;font-size: 20px;" class="fa fa-calendar" aria-hidden="true"></i></button>
                      </div>
                      <input type="hidden" id="is_coordinator1old" data-attr='<?php echo json_encode($rows['iscoordinators']); ?>'>
                      <input type="hidden" id="is_coordinator1current">
                    </div>
                  </div>



                  <div class="col-md-4">
                    <div class="form-group">
                      <label class="control-label">IS Co-ordinator2</label>
                      <div style="display: flex;">
                        <select class="form-control" id="is_coordinator2" name="is_coordinator2" onchange="iscoordinatorfn(event)" required readonly style="pointer-events: none !important;">
                          <option>Select-IS-Coordinator-2</option>
                          @foreach($rows['iscoordinators'] as $key=>$row)
                          <option value="{{$row['id']}}">{{ $row['name']}}</option>
                          @endforeach
                        </select>
                        <button style="display: none;" id="co_two" title="Availability Calendar" class="btn" data-toggle="modal" data-target="#calModal2" type="button">
                          <i style="color: blue;font-size: 20px;" class="fa fa-calendar" aria-hidden="true"></i></button>
                      </div>
                      <input type="hidden" id="is_coordinator2old" data-attr='<?php echo json_encode($rows['iscoordinators']); ?>'>
                      <input type="hidden" id="is_coordinator2current">
                    </div>
                  </div>


                </div>
              </div>
            </div>




            <div class="row text-center mt-4">
              <div class="col-md-12">
                <a type="button" onclick="newmeeting()" class="btn btn-success text-white">Initiate</a>
              </div>
            </div>





            <div class="row" id="invite">
              <div class="col-12">

                <div class="card">
                  <div class="card-body">

                    <div class="form-group row" style="margin-bottom: 5px;">
                      <label class="col-sm-2 col-form-label required">To</label>
                      <div class="col-sm-4">
                        <input class="form-control" type="text" id="meeting_to" name="meeting_to" placeholder="Parents Email" required autocomplete="off">
                      </div>
                      <div class="col-md-2">
                      </div>
                      <div class="col-md-2">
                        <label class="control-label centerid">Status</label> <br>
                        <input class="form-control" type="text" id="meeting_status" name="meeting_status" placeholder="New" readonly required autocomplete="off">
                      </div>



                    </div>

                    <div class="form-group row">
                      <label class="col-sm-2 col-form-label">CC<span class="error-star" style="color:red;">*</span></label>
                      <div class="col-sm-4">
                        <select class="form-control mail_cc js-select2" id="mail_cc" multiple="multiple" name="mail_cc[]">
                          <option></option>
                          @foreach($users as $user)
                          <option value="{{$user['email']}}" {{ in_array($user['email'], $default_cc) ? 'selected' : '' }}>{{$user['name']}} : {{$user['email']}}</option>
                          @endforeach
                        </select>
                      </div>
                    </div>


                    <div class="form-group row">
                      <label class="col-sm-2 col-form-label required">Subject</label>
                      <div class="col-sm-4">
                        @if($email != [])
                        <input class="form-control" type="text" id="meeting_subject" name="meeting_subject" placeholder="OVM2 Meeting" value="{{$email[0]['email_subject']}}" required autocomplete="off">
                        @else
                        <input class="form-control" type="text" id="meeting_subject" name="meeting_subject" placeholder="OVM2 Meeting" required autocomplete="off">
                        @endif

                      </div>

                    </div>


                    <div class="form-group row">
                      <label class="col-sm-2 col-form-label required">Location</label>
                      <div class="col-sm-4">
                        <!-- <input id="pac-input" class="controls" type="text" placeholder="Search Box"/> -->
                        <input class="form-control controls" type="text" id="meeting_location" name="meeting_location" placeholder="Enter Location" required autocomplete="off">
                      </div>


                    </div>

                    <div class="form-group row">
                      <label class="col-sm-2 col-form-label required">Start Date and Time</label>
                      <div class="col-sm-4">
                        <div class="inner-addon right-addon">
                          <i class="glyphicon fas fa-calendar-alt"></i>
                          <input type='text' class="form-control meeting_date" id='meeting_startdate' name="meeting_startdate" onchange="autodateupdate(this)" required placeholder="DD/MM/YYYY">
                        </div>
                      </div>
                      <div class="col-sm-2">
                        <div class="content">
                          <input class="form-control" type="time" id="meeting_starttime" name="meeting_starttime" required onchange="autoupdatedescription1()">
                        </div>

                      </div>

                    </div>



                    <div class="form-group row">
                      <label class="col-sm-2 col-form-label required">End Date and Time</label>
                      <div class="col-sm-4">
                        <div class="inner-addon right-addon">
                          <i class="glyphicon fas fa-calendar-alt"></i>
                          <input type='text' class="form-control meeting_date" id="meeting_enddate" name="meeting_enddate" onchange="autodateupdate(this)" required placeholder="DD/MM/YYYY">
                        </div>
                      </div>
                      <div class="col-sm-2">

                        <div class="content">
                          <input class="form-control" type="time" id="meeting_endtime" name="meeting_endtime" required onchange="autoupdatedescription1()">
                        </div>

                      </div>

                      <div class="form-group row">
                        <label class="col-sm-2 col-form-label">File Attachment</label>
                        <div class="col-sm-4">
                          <input class="form-control" type="file" id="file" name="file" oninput="" maxlength="20" value="" placeholder="Enter Location" autocomplete="off">
                          <!-- <a href="#" id="viewLink" style="display:none" target="_blank"><i class="fa fa-file"></i> View Uploaded Document</a> -->
                          <!-- <div style="color: rgb(246, 15, 15); display: block;margin: 5px 0px 0px 3px;">File Size must be below 2MB.<br>Only Following extension files could be uploaded .PDF, MS Word, .JPG & .JPEG.</div> -->
                        </div>
                        <div class="col-sm-2">
                          <a href="#" id="viewLink" class="btn btn-info" title="View Attachment" style="display:none;" target="_blank"><i class="fa fa-eye" style="color:white!important"></i> View</a>
                        </div>

                      </div>


                      <div class="col-lg-12" style="margin: 20px 0px 0px 0px;">
                        <div class="form-group">
                          <label class="form-label">Meeting Description</label>
                          <textarea class="form-control" id="description" name="meeting_description">
                          @if($email != [])
                          {{$email[0]['email_body']}}
                          @endif
                          </textarea>
                        </div>
                      </div>


                    </div>
                    <div class="row text-center">
                      <div class="col-md-12">
                        <a type="button" class="btn btn-warning text-white" onclick="validateForm('Saved')" name="type" value="Saved">Save</a>
                        <a type="button" class="btn btn-success text-white" onclick="validateForm('Sent')" name="type" value="Sent">Send</a>
                        <a type="button" class="btn btn-labeled back-btn" title="Back" href="{{ route('ovm2.index') }}" style="color:white !important">
                          <span class="btn-label" style="font-size:13px !important;"><i class="fa fa-arrow-left"></i></span> Back</a>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>

          </form>

        </div>


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
<script>
  const fileInput = document.getElementById('file');
  const viewLink = document.getElementById('viewLink');

  fileInput.addEventListener('change', () => {
    const file = fileInput.files[0];
    if (file) {
      viewLink.setAttribute('href', URL.createObjectURL(file));
      viewLink.style.display = 'inline-block';
    } else {
      viewLink.style.display = 'none';
    }
  });
</script>
<script>
  $(".js-select2").select2({
    closeOnSelect: false,
    placeholder: " Please Select Users",
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/tinymce/4.5.6/tinymce.min.js"></script>
<script src="http://cdnjs.cloudflare.com/ajax/libs/tinymce/4.5.6/jquery.tinymce.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.26.0/moment.min.js"></script>
@include('ovm1.cal')
<script>
  $(document).ready(function() {
    tinymce.init({
      selector: 'textarea#description',
      height: 180,
      menubar: false,
      branding: false,
      toolbar: 'undo redo | formatselect | ' +
        'bold italic backcolor | alignleft aligncenter ' +
        'alignright alignjustify | bullist numlist outdent indent | ' +
        'removeformat | help',
      content_style: 'body { font-family:Helvetica,Arial,sans-serif; font-size:14px }'
    });
  });
</script>
<script type="text/javascript">
  let meeting_startdate = document.getElementById("meeting_startdate");

  meeting_startdate.min = new Date().toISOString().slice(0, new Date().toISOString().lastIndexOf(":"));

  meeting_startdate.min = new Date().toISOString().split("T")[0];
  meeting_enddate.min = new Date().toISOString().split("T")[0];

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
      if (currentcoordinatorname !== "") {
        alternatecoordinator.value = currentcoordinatorname;
      }
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
      if (currentcoordinatorname !== "") {
        alternatecoordinator.value = currentcoordinatorname;
      }
    }
    getEventsDB(currentcoordinator);
    //...

  }
</script>
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>

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

  function minFromMidnight(tm) {
    var ampm = tm.substr(-2)
    var clk = tm.substr(0, 5);
    var m = parseInt(clk.match(/\d+$/)[0], 10);
    var h = parseInt(clk.match(/^\d+/)[0], 10);
    h += (ampm.match(/pm/i)) ? 12 : 0;
    return h * 60 + m;
  }
  
  function isValidDate(dateString) {
    const currentDate = new Date();
    const parts = dateString.split('/');
    const givenDate = new Date(parts[2], parts[1] - 1, parts[0]);
    if (givenDate < currentDate) {
      return true;
    } else if (givenDate.toDateString() === currentDate.toDateString()) {
      return true;
    } else {
      return true;
    }
  }

  function validateForm(a) {


    var co_one = $('#is_coordinator1').val();
    var co_two = $('#is_coordinator2').val();
    var startdate = $('#meeting_startdate').val();
    var dateValid = isValidDate(startdate);
    if(!dateValid){
      swal.fire("Please Select Valid Date", "", "error");
      return false;
    }
    if (co_one == "Select-IS-Coordinator-1") {
      swal.fire("Please Select IS Coordinator1 ", "", "error");
      return false;
    }
    // if (co_two == "Select-IS-Coordinator-2") {
    //   swal.fire("Please Select IS Coordinator2 ", "", "error");
    //   return false;
    // }
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
      swal.fire("IS Co-ordinator-2 has Two Appointment", "", "error");
      return false;
    }

    data2 = data2.filter(j => startdate.includes(j.idate));
    const data2Len = data2.length;
    if (data2Len >= 2) {
      swal.fire("IS Co-ordinator-2 has Two Appointment", "", "error");
      return false;
    }

    if (document.getElementById('meeting_subject').value == "") {
      swal.fire("Please Enter Meeting Subject ", "", "error");
      return false;
    }
    if (document.getElementById('meeting_location').value == "") {
      swal.fire("Please Enter Meeting Location", "", "error");
      return false;
    }

    var meeting_startdate = document.getElementById('meeting_startdate').value;
    if (meeting_startdate == "") {
      swal.fire("Please Select Meeting  Start Date ", "", "error");
      return false;
    }

    var meeting_starttime = document.getElementById('meeting_starttime').value;
    if (meeting_starttime == "") {
      swal.fire("Please Select Meeting Start Time", "", "error");
      return false;
    }

    var meeting_enddate = document.getElementById('meeting_enddate').value;
    if (meeting_enddate == "") {
      swal.fire("Please Select Meeting End Date", "", "error");
      return false;
    }

    var meeting_endtime = document.getElementById('meeting_endtime').value;
    if (meeting_endtime == "") {
      swal.fire("Please Select Meeting End Time", "", "error");
      return false;
    }

    for (k = 0; k < data1.length; k++) {
      if (data1[k].idate == meeting_startdate) {
        var tiLen = 5;
        var timeDB1 = data1[k].meeting_starttime.substring(0, tiLen);
        var timeDB2 = data1[k].meeting_endtime.substring(0, tiLen);

        var timeBlockedStart = timeDB1.replace(/:/g, "");
        var startTime = meeting_starttime.replace(/:/g, "");

        var timeBlockedEnd = timeDB2.replace(/:/g, "");
        var endTime = meeting_endtime.replace(/:/g, "");
        valid = timeBlockedStart <= startTime && timeBlockedEnd >= startTime;
        valid1 = timeBlockedStart <= endTime && timeBlockedEnd >= endTime;

        if (valid == true || valid1 == true) {
          swal.fire("IS Co-ordinator-1 has Appointment on the same time", "", "error");
          return false;
        }
      }
    }

    for (h = 0; h < data2.length; h++) {
      if (data2[h].idate == meeting_startdate) {
        var tiLen = 5;
        var timeDB3 = data2[h].meeting_starttime.substring(0, tiLen);
        var timeDB4 = data2[h].meeting_endtime.substring(0, tiLen);

        var timeBlockedStart = timeDB3.replace(/:/g, "");
        var startTime = meeting_starttime.replace(/:/g, "");

        var timeBlockedEnd = timeDB4.replace(/:/g, "");
        var endTime = meeting_endtime.replace(/:/g, "");
        valid = timeBlockedStart <= startTime && timeBlockedEnd >= startTime;
        valid1 = timeBlockedStart <= endTime && timeBlockedEnd >= endTime;

        if (valid == true || valid1 == true) {
          swal.fire("IS Co-ordinator-2 has Appointment on the same time", "", "error");
          return false;
        }
      }
    }

    var date = new Date();
    // let day = date.getDate();
    // let month = date.getMonth() + 1;
    // let year = date.getFullYear();
    // let currentDate = `${year}-${month}-${day}`;
    var currentDate = date.toLocaleString("en-GB", {
      year: "numeric",
      month: "2-digit",
      day: "2-digit",
    });
    // console.log(currentDate);

    var date1 = new Date(meeting_startdate);
    var MSdate1 = date1.toLocaleString("en-GB", {
      year: "numeric",
      month: "2-digit",
      day: "2-digit",
    });
    // console.log(MSdate1);

    var twentyMinutesLater = new Date();
    twentyMinutesLater.setMinutes(twentyMinutesLater.getMinutes() + 2);
    var currentTime = new Date(twentyMinutesLater).toLocaleTimeString("en-GB");
    // console.log(currentDate);
    // console.log(meeting_startdate);
    if (currentDate == MSdate1) {
      var th = 5;
      var currentTime1 = currentTime.substring(0, th);
      var s11 = meeting_starttime.replace(/:/g, "");
      var c11 = currentTime1.replace(/:/g, "");
      // console.log(meeting_starttime);
      // console.log(currentTime);
      if (s11 < c11) {
        swal.fire("Please Select Valid Time", "", "error");
        return false;
      }
    }

    if (meeting_starttime == meeting_endtime) {
      swal.fire("Start Time and End Time should not be same", "", "error");
      return false;
    }
    if (meeting_starttime > meeting_endtime) {
      swal.fire("Please Select Valid Time", "", "error");
      return false;
    }


    var sTime = meeting_starttime.replace(/:/g, "");
    var eTime = meeting_endtime.replace(/:/g, "");
    // var diff = eTime - sTime;
    var length = 4;
    var tsTime = sTime.substring(0, length);
    var teTime = eTime.substring(0, length);
    var diff = teTime - tsTime;

    if (diff > 200) {
      swal.fire("Maximum Time Duration is Two Hours", "", "error");
      return false;
    }
    if (diff < 30) {
      swal.fire("Minimum Time Duration is 30 Minutes", "", "error");
      return false;
    }
    var length = 4;
    var tsTime = sTime.substring(0, length);
    var teTime = eTime.substring(0, length);
    // if (tsTime < 900) {
    //   swal.fire("Meeting Can be Scheduled from 9AM to 6PM only", "", "error");
    //   return false;
    // }
    // if (teTime > 1800) {
    //   swal.fire("Meeting Can be Scheduled from 9AM to 6PM only", "", "error");
    //   return false;
    // }

    var filedoc = document.getElementById('file').value;
    // if (filedoc == "") {
    //   swal.fire("Please Select File Attachement", "", "error");
    //   return false;
    // }
    // if (filedoc != "") {
    //   var ext2 = filedoc.split('.').pop();
    //   if (ext2 != "pdf" && ext2 != "docx" && ext2 != "doc" && ext2 != "JPG" && ext2 != "JPEG" && ext2 != "jpg" && ext2 != "jpeg") {
    //     swal.fire("Please Upload Valid File Format", "", "error");
    //     return false;
    //   }
    // }

    document.getElementById('meeting_status').value = a;

    tinyMCE.triggerSave();
    // if ($("#description").val().trim().length < 1) {
    //   swal.fire("Please Enter Description", "", "error");
    //   return false;
    // }

    if (a == 'Saved') {
      var swalText = 'Save';
    } else if (a == 'Sent') {
      var swalText = 'Schedule';
    }
    
    const select_coordinator1 = document.getElementById("is_coordinator1");const select_coordinator2 = document.getElementById("is_coordinator2");
    select_coordinator1.readonly = true; select_coordinator2.readonly = true;

    Swal.fire({

      title: "Do you want to " + swalText + " the Meeting?",
      text: "Please click 'Yes' to Schedule the Meeting",
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
        document.getElementById('ovm2').submit(a);
      }
    })
  }
</script>
<script>
  function newmeeting()

  {
    if (document.getElementById('enrollment_child_num').value == "") {
      swal.fire("Please Select Enrolment Number", "", "error");
      return false;
    }

    var co_one = $('#is_coordinator1').val();
    var co_two = $('#is_coordinator2').val();
    if (co_one == "Select-IS-Coordinator-1") {
      swal.fire("Please Select IS Coordinator1 ", "", "error");
      return false;
    }
    // if (co_two == "Select-IS-Coordinator-2") {
    //   swal.fire("Please Select IS Coordinator2 ", "", "error");
    //   return false;
    // }
    document.getElementById('invite').style.display = "block";

  }
</script>

<script type="text/javascript">
  var userRole = <?php echo json_encode($modules['user_role']); ?>;
  $.ajaxSetup({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  });

  function autodateupdate(datev) {
    $('#meeting_startdate').val(datev.value);
    $('#meeting_enddate').val(datev.value);
    autoupdatedescription1();
  }

  function GetChilddetails() {
    var enrollment_child_num = $("select[name='enrollment_child_num']").val();
    // console.log(enrollment_child_num);
    if (enrollment_child_num != "") {
      $.ajax({
        url: "{{ url('/userregisterfee/enrollmentlist') }}",
        type: 'POST',
        data: {
          'enrollment_child_num': enrollment_child_num,
          _token: '{{csrf_token()}}'
        }
      }).done(function(data) {
        if (data != '[]') {
          var optionsdata = "";
          document.getElementById('child_id').value = data[0].child_id;
          document.getElementById('child_name').value = data[0].child_name;
          document.getElementById('meeting_to').value = data[0].child_contact_email;
          document.getElementById('enrollment_id').value = data[0].enrollment_id;
          document.getElementById('meeting_subject').value = 'OVM 2 Meeting - ' + data[0].child_name;
          if (data[2] != undefined) {
            var co1 = data[2].is_coordinator1;
            var co2 = data[2].is_coordinator2;

            const select_coordinator1 = document.getElementById("is_coordinator1");
            select_coordinator1.value = co1;
            if(userRole != 'IS'){
              select_coordinator1.readonly = true;
            }
            if (co2 != 0) {
              const select_coordinator2 = document.getElementById("is_coordinator2");
              select_coordinator2.value = co2;
              if(userRole != 'IS'){
                select_coordinator2.readonly = true;
              }
            }

            var select_meeting_location = data[2].meeting_location2;
            document.getElementById('meeting_location').value = select_meeting_location;

            var select_meeting_startdate = data[2].meeting_startdate2;
            document.getElementById('meeting_startdate').value = select_meeting_startdate;

            var select_meeting_enddate = data[2].meeting_enddate2;
            document.getElementById('meeting_enddate').value = select_meeting_startdate;

            var select_meeting_starttime = data[2].meeting_starttime2;
            document.getElementById('meeting_starttime').value = select_meeting_starttime;
            select_meeting_starttime = convertTimeFormat(select_meeting_starttime);

            var select_meeting_endtime = data[2].meeting_endtime2;
            document.getElementById('meeting_endtime').value = select_meeting_endtime;
            select_meeting_endtime = convertTimeFormat(select_meeting_endtime);

            var text1 = select_meeting_starttime + ' to ' + select_meeting_endtime;
            var content = tinymce.get('description').getContent();
            content = content.replace('ovmMeetingDate', select_meeting_startdate);
            content = content.replace('ovmMeetingTime', text1);

            tinymce.get('description').setContent(content);
            updateExistingTime();
          }
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
  var repeate1;

  function updateExistingTime() {
    var m1 = document.getElementById('meeting_startdate').value;
    var m2 = document.getElementById('meeting_starttime').value;
    m2 = convertTimeFormat(m2);
    var m3 = document.getElementById('meeting_endtime').value;
    m3 = convertTimeFormat(m3);
    repeate1 = m1 + ' at ' + m2 + ' to ' + m3;
  }

  function autoupdatedescription1() {
    var mDate1 = document.getElementById('meeting_startdate').value;
    var mTime1_s = document.getElementById('meeting_starttime').value;
    mTime1_s = convertTimeFormat(mTime1_s);
    var mTime1_e = document.getElementById('meeting_endtime').value;
    mTime1_e = convertTimeFormat(mTime1_e);

    if (mDate1 != '' && mTime1_s != '' && mTime1_e != '') {
      var text1 = mDate1 + ' from ' + mTime1_s + ' to ' + mTime1_e;
      var content = tinymce.get('description').getContent();
      content = content.replace(repeate1, text1);
      tinymce.get('description').setContent(content);
      repeate1 = text1;
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
@endsection