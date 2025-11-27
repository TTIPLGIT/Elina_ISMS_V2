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

    {{ Breadcrumbs::render('inperson_meeting.create') }}

    <div class="section-body mt-1">
      <h5 class="text-center" style="color:darkblue">Face To Face Meeting Invite</h5>
      <div class="row">
        <div class="col-12">
          <div class="card">
            <div class="card-body">
              <form action="{{route('inperson_meeting.store')}}" method="POST" id="formmeeting" enctype="multipart/form-data">
                @csrf
                <div class="row is-coordinate">
                  <div class="col-md-4">
                    <div class="form-group">
                      <label class="control-label">Enrollment ID<span class="error-star" style="color:red;">*</span></label>
                      <select class="form-control" id="enrollment_id" name="enrollment_id" onchange="GetChilddetails()">
                        <option value="">Select-Enrollment</option>
                        @foreach($rows['enrollment_details'] as $key=>$row)
                        <option value="{{$row['enrollment_id']}}">{{ $row['enrollment_child_num']}} ( {{$row['child_name']}} )</option>
                        @endforeach
                      </select>
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group">
                      <label class="control-label">Child ID</label>
                      <input class="form-control readonly" type="text" id="child_id" name="child_id" placeholder="Child ID" autocomplete="off" readonly>
                      <input type="hidden" id="enrollment_child_num" name="enrollment_child_num" autocomplete="off" readonly>
                      <input type="hidden" id="user_id" name="user_id">
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
                      <label class="control-label">IS Co-ordinator 1<span class="error-star" style="color:red;">*</span></label>
                      <div style="display: flex;">
                        <select class="form-control" id="is_coordinator1" name="is_coordinator1" onchange="iscoordinatorfn(event)" style="pointer-events: none;">
                          <option>Select-IS-Coordinator-1</option>
                          @foreach($rows['iscoordinators'] as $key=>$row)
                          <option value="{{$row['id']}}" id="a{{$row['id']}}">{{ $row['name']}}</option>
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
                      <label class="control-label required">IS Co-ordinator-2</label>
                      <div style="display: flex;">
                        <select class="form-control" id="is_coordinator2" name="is_coordinator2" onchange="iscoordinatorfn(event)" style="pointer-events: none;">
                          <option value="">Select-IS-Coordinator-2</option>
                          @foreach($iscoordinators as $key=>$row)
                          <option value="{{$row['id']}}" id="b{{$row['id']}}">{{ $row['name']}}</option>
                          @endforeach
                        </select>
                      </div>
                      <input type="hidden" id="is_coordinator2old" data-attr='<?php echo json_encode($iscoordinators); ?>'>
                      <input type="hidden" id="is_coordinator2current">
                    </div>
                  </div>
                </div>
            </div>
          </div>
        </div>
      </div>
      <br>
      <div class="row text-center">
        <div class="col-md-12">
          <a type="button" onclick="newmeeting()" class="btn btn-success mb-1">Initiate</a>
        </div>
      </div>
      <div class="row" id="invite">
        <div class="col-12">
          <div class="card">
            <div class="card-body">
              <div class="form-group row" style="margin-bottom: 5px;">
                <label class="col-sm-2 col-form-label">To<span class="error-star" style="color:red;">*</span></label>
                <div class="col-sm-4">
                  <input class="form-control" type="text" id="meeting_to" name="meeting_to" placeholder="Email Id" autocomplete="off">
                </div>
                <div class="col-md-2">
                </div>
                <div class="col-md-2">
                  <label class="control-label centerid">Status</label> <br>
                  <input class="form-control" type="text" id="meeting_status" name="meeting_status" placeholder="New" autocomplete="off" readonly>
                </div>
              </div>
              <div class="form-group row">
                <label class="col-sm-2 col-form-label">CC</label>
                <div class="col-sm-4">
                  <select class="form-control mail_cc js-select2" id="mail_cc" multiple="multiple" name="mail_cc[]">
                    <option></option>
                    @foreach($users as $user)
                    <option value="{{$user['email']}}">{{$user['name']}} : {{$user['email']}}</option>
                    @endforeach
                  </select>
                </div>
              </div>
              <div class="form-group row">
                <label class="col-sm-2 col-form-label">Subject<span class="error-star" style="color:red;">*</span></label>
                <div class="col-sm-4">
                  @if($email != [])
                  <input class="form-control" type="text" id="meeting_subject" name="meeting_subject" placeholder="Meeting Subject" title="Meeting Subject" value="{{$email[0]['email_subject']}}" autocomplete="off">
                  @else
                  <input class="form-control" type="text" id="meeting_subject" name="meeting_subject" placeholder="Meeting Subject" title="Meeting Subject" autocomplete="off">
                  @endif

                </div>
              </div>
              <div class="form-group row">
                <label class="col-sm-2 col-form-label">Meeting Mode<span class="error-star" style="color:red;">*</span></label>
                <div class="col-sm-4">
                  <label class='switch' data-bs-toggle='tooltip' data-bs-placement='top' title='Online / Offline'>
                    <input type='checkbox' class='toggle_status' onclick="functiontoggle()" id="meeting_mode" name='meeting_mode' value="1">
                    <span class='slider round'></span>
                  </label>
                  <span style="font-size: 16px;padding: 0px 0px 0px 5px;" id="meeting_mode_text">Offline</span>
                </div>
              </div>
              <div class="form-group row">
                <label class="col-sm-2 col-form-label">Location<span class="error-star" style="color:red;">*</span></label>
                <div class="col-sm-4">
                  <input class="form-control" oninput="changeLocation(this)" type="text" id="meeting_location" name="meeting_location" title="Meeting Location" value="" placeholder="Enter Location" autocomplete="off">
                </div>
              </div>
              <div class="form-group row">
                <label class="col-sm-2 col-form-label">Start Date and Time<span class="error-star" style="color:red;">*</span></label>
                <div class="col-sm-4">
                  <div class="inner-addon right-addon">
                    <i class="glyphicon fas fa-calendar-alt"></i>
                    <input type='text' autocomplete="off" class="form-control meeting_date" id='meeting_startdate' name="meeting_startdate" title="Meeting Start Date" onchange="autodateupdate(this)" placeholder="DD/MM/YYYY">
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
                    <input type='text' autocomplete="off" class="form-control meeting_date" id="meeting_enddate" name="meeting_enddate" title="Meeting End Date" onchange="autodateupdate(this)" placeholder="DD/MM/YYYY">
                  </div>
                </div>
                <div class="col-sm-2">

                  <div class="content">
                    <input class="form-control" type="time" id="meeting_endtime" name="meeting_endtime" title="Meeting End Time" onchange="autoupdatedescription1()">
                  </div>

                </div>
                <div class="w-100"></div>
                <div class="col-lg-12" style="margin: 20px 0px 0px 0px;">
                  <div class="form-group">
                    <label class="form-label">Meeting Description</label>
                    <textarea class="form-control" id="meeting_description" name="meeting_description">
                    @if($email != [])
                    {{$email[0]['email_body']}}
                    @endif
                    </textarea>
                  </div>
                </div>

                <br>

              </div>
              <div class="row text-center">
                <div class="col-md-12">


                  <a type="button" class="btn btn-warning text-white" onclick="validateForm('Saved')" name="type" value="Saved">Save</a>
                  <a type="button" class="btn btn-success text-white" onclick="validateForm('Sent')" name="type" value="Sent">Send</a>
                  <a type="button" class="btn btn-labeled back-btn" title="Back" href="{{ route('ovm1.index') }}" style="color:white !important">
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
<br>
</div>
</section>
</div>
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
    
    var meeting_locationtext = document.getElementById("meeting_location");
    meeting_locationtext.value = 'C1 - 301, Pelican Nest, Creek Street, OMR Chennai Tamil Nadu 600097 India.';
    // console.log(meeting_locationtext.value);
    changeLocation(meeting_locationtext);
    // event.preventDefault()
  });

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
</script>
<script>
  // meeting_startdate.min = new Date().toISOString().split("T")[0];
  // meeting_enddate.min = new Date().toISOString().split("T")[0];
</script>
<script>
  function newmeeting() {
    if (document.getElementById('enrollment_id').value == "") {
      swal.fire("Please Select Enrolment Number", "", "error");
      return false;
    }
    var co_one = $('#is_coordinator1').val();
    var co_two = $('#is_coordinator2').val();

    if (co_one == "Select-IS-Coordinator-1") {
      swal.fire("Please Select IS Coordinator1 ", "", "error");
      return false;
    }
    document.getElementById('invite').style.display = "block";
  }
</script>

<!-- //validation -->
<script>
  function Childname(event) {
    let value = event.target.value || '';
    value = value.replace(/[^a-z A-Z ]/, '', );
    event.target.value = value;

  }
</script>

<script type="text/javascript">
  $.ajaxSetup({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  });

  function GetChilddetails() {
    var enrollment_id = $("select[name='enrollment_id']").val();
    // alert(enrollment_id);
    if (enrollment_id != "") {
      $.ajax({
        url: "{{ url('/get/sail/details') }}",
        type: 'POST',
        data: {
          'enrollment_id': enrollment_id,
          _token: '{{csrf_token()}}'
        }
      }).done(function(response) {
        var enrollment = response.enrollment;
        console.log(enrollment);
        var sail = response.sail;
        if (enrollment != '[]') {
          var optionsdata;
          document.getElementById('child_id').value = enrollment[0].child_id;
          document.getElementById('child_name').value = enrollment[0].child_name;
          document.getElementById('meeting_to').value = enrollment[0].child_contact_email;
          document.getElementById('enrollment_child_num').value = enrollment[0].enrollment_child_num;
          document.getElementById('user_id').value = enrollment[0].user_id;

          var content = tinymce.get('meeting_description').getContent();
          content = content.replace('childName', enrollment[0].child_name);
          tinymce.get('meeting_description').setContent(content);
          // console.log(sail);
          if (sail != '') {
            var coordinator = sail[0].coordinator;
            coordinator = 'a'.concat(coordinator);
            var is_coordinator1 = document.getElementById("is_coordinator1");
            $('select option[id=' + coordinator + ']').attr("selected", true);

            var coordinator2 = sail[0].coordinator2;
            coordinator2 = 'b'.concat(coordinator2);
            var is_coordinator2 = document.getElementById("is_coordinator2");
            $('select option[id=' + coordinator2 + ']').attr("selected", true);
          }
        } else {
          document.getElementById('child_name');
          var ddd = '<option value="child_name">Select Enrollment</option>';
          var demonew = $('#child_name').html(ddd);
        }
      })
    } else {
      document.getElementById('initiated_by');
      var ddd = '<option value="initiated_by">Select Enrollment</option>';
      var demonew = $('#initiated_by').html(ddd);
    }
  };
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
        // console.log(data1.length);

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

  function validateForm(a) {


    var co_one = $('#is_coordinator1').val();
    var co_two = $('#is_coordinator2').val();
    var startdate = $('#meeting_startdate').val();

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
      swal.fire("IS Co-ordinator-1 has Two Appointment on the same day", "", "error");
      return false;
    }

    data2 = data2.filter(j => startdate.includes(j.idate));
    const data2Len = data2.length;
    if (data2Len >= 2) {
      swal.fire("IS Co-ordinator-2 has Two Appointment on the same day", "", "error");
      return false;
    }

    if (document.getElementById('meeting_to').value == "") {
      swal.fire("Please Enter Email Id", "", "error");
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
    // if (tsTime < 900) {
    //   swal.fire("Meeting Can be Scheduled from 9AM to 6PM only", "", "error");
    //   return false;
    // }
    // if (teTime > 1800) {
    //   swal.fire("Meeting Can be Scheduled from 9AM to 6PM only", "", "error");
    //   return false;
    // }

    document.getElementById('meeting_status').value = a;
    if (a == 'Saved') {
      var swalText = 'Save';
    } else if (a == 'Sent') {
      var swalText = 'Schedule';
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
        document.getElementById('formmeeting').submit(a);
      }
    })
  }

  function autodateupdate(datev) {
    $('#meeting_startdate').val(datev.value);
    $('#meeting_enddate').val(datev.value);
    autoupdatedescription1();
  }
</script>
<script>
  var meetingDate;
  var meetingTime;

  function autoupdatedescription1() {
    var mDate1 = document.getElementById('meeting_startdate').value;
    var mTime1_s = document.getElementById('meeting_starttime').value;
    var mTime1_e = document.getElementById('meeting_endtime').value;

    if (mDate1 != '' && mTime1_s != '' && mTime1_e != '') {
      mTime1_s = convertTimeFormat(mTime1_s);
      mTime1_e = convertTimeFormat(mTime1_e);
      var text1 = mTime1_s + ' to ' + mTime1_e;
      var content = tinymce.get('meeting_description').getContent();
      if (meetingDate == undefined) {
        content = content.replace(/meetingDate/g, mDate1);
        content = content.replace(/meetingTime/g, text1);
      } else {
        content = content.replace(meetingDate, mDate1);
        content = content.replace(meetingTime, text1);
      }
      tinymce.get('meeting_description').setContent(content);
      meetingDate = mDate1;
      meetingTime = text1;
    }
  }

  var typedLocation = 'meetingLocation';

  function changeLocation(location) {
    curLoc = location.value;
    var content = tinymce.get('meeting_description').getContent();
    content = content.replace(typedLocation, curLoc);
    tinymce.get('meeting_description').setContent(content);
    typedLocation = location.value;

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

  function functiontoggle() {
    var checkbox = document.getElementById("meeting_mode");
    var likeText = document.getElementById("meeting_mode_text");
    var meeting_locationtext = document.getElementById("meeting_location");

    if (checkbox.checked) {
      likeText.innerHTML = 'Online';
      meeting_locationtext.value = 'Online';
    } else {
      likeText.innerHTML = 'Offline';
      meeting_locationtext.value = 'C1 - 301, Pelican Nest, Creek Street, OMR Chennai Tamil Nadu 600097 India.';
    }
    changeLocation(meeting_locationtext);
  }
</script>
@endsection