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

  /* .custom-file-upload {
    border: 1px solid #ccc;
    padding: 6px 12px;
    cursor: pointer;
    background: white;
    margin: 5px 0px 0px 3px;
    height: 35px;
  } */

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
    {{ Breadcrumbs::render('ovm2.edit',$rows[0]['ovm_meeting_id']) }}


    <div class="section-body mt-1">
      <h5 class="text-center" style="color:darkblue">OVM-2 Meeting Invite Edit</h5>
      <div class="row">
        <div class="col-12">

          <div class="card">
            <div class="card-body">
              @foreach($rows as $key=>$row)
              @php $row['ovm_meeting_id'] = Crypt::encrypt($row['ovm_meeting_id']) @endphp
              <form action="{{route('ovm2.update', $row['ovm_meeting_id'])}}" method="POST" id="ovm" enctype="multipart/form-data">
                {{ csrf_field() }}
                @method('PUT')





                <div class="row is-coordinate">
                  <div class="col-md-3">
                    <div class="form-group">
                      <label class="control-label required">OVM Meeting ID</label>

                      <input class="form-control" name="ovm_meeting_unique" readonly value="{{ $row['ovm_meeting_unique']}}" required>
                    </div>
                  </div>
                  <div class="col-md-3">
                    <div class="form-group">
                      <label class="control-label required">Enrollment ID</label>

                      <input class="form-control" name="enrollment_id" readonly placeholder="Enrollment ID" value="{{ $row['enrollment_id']}}" required>
                    </div>
                  </div>


                  <div class="col-md-3">
                    <div class="form-group">
                      <label class="control-label required">Child ID</label>
                      <input class="form-control" type="text" id="child_id" readonly name="child_id" value="{{ $row['child_id']}}" placeholder="OVM1 Meeting" required autocomplete="off">
                    </div>
                  </div>

                  <input type="hidden" id="type" name="type">


                  <div class="col-md-3">
                    <div class="form-group">
                      <label class="control-label required">Child Name</label>
                      <input class="form-control" type="text" id="child_name" readonly name="child_name" value="{{ $row['child_name']}}" placeholder="Enter Name" required autocomplete="off">
                    </div>
                  </div>

                  <div class="col-md-4">
                    <div class="form-group ">
                      <label class="control-label required">IS Co-ordinator-1</label>
                      <div style="display: flex;">
                        <select class="form-control" id="is_coordinator1" name="is_coordinator1" onchange="iscoordinatorfn(event)" @if($modules['user_role'] != 'IS Head') disabled @endif>
                          <option>Select-IS-Coordinator-1</option>
                          @foreach($iscoordinators as $key=> $data1)
                          <option value="{{ $data1['id'] }}" {{ $data1['id'] ==  $row['is_coordinator1']['id'] ? 'selected':'' }}>{{$data1['name']}}</option>
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
                      <label class="control-label required">IS Co-ordinator-2</label>
                      <div style="display: flex;">
                        <select class="form-control" id="is_coordinator2" name="is_coordinator2" onchange="iscoordinatorfn(event)" @if($modules['user_role'] != 'IS Head') disabled @endif>
                          <option>Select-IS-Coordinator-2</option>
                          @foreach($iscoordinators as $key=> $data2)
                          @if($row['is_coordinator2'] != [])
                          <option value="{{ $data2['id'] }}" {{ $data2['id'] ==  $row['is_coordinator2']['id'] ? 'selected':'' }}>{{$data2['name']}}</option>
                          @else
                          <option value="{{$data2['id']}}">{{ $data2['name']}}</option>
                          @endif
                          @endforeach
                        </select>
                        <button style="display: none;" id="co_two" title="Availability Calendar" class="btn" data-toggle="modal" data-target="#calModal2" type="button">
                          <i style="color: blue;font-size: 20px;" class="fa fa-calendar" aria-hidden="true"></i></button>
                      </div>
                      <input type="hidden" id="is_coordinator2old" data-attr='<?php echo json_encode($iscoordinators); ?>'>
                      <input type="hidden" id="is_coordinator2current">
                    </div>
                  </div>










                </div>
            </div>
          </div>
        </div>




        <div class="row">
          <div class="col-12">

            <div class="card">
              <div class="card-body">

                <div class="form-group row" style="margin-bottom: 5px;">
                  <label class="col-sm-2 col-form-label required">To</label>
                  <div class="col-sm-4">
                    <input class="form-control" type="text" readonly id="meeting_to" name="meeting_to" value="{{ $row['meeting_to']}}" placeholder="Email Id" required autocomplete="off">
                  </div>
                  <div class="col-md-2">
                  </div>
                  <div class="col-md-2">
                    <label class="control-label centerid">Status</label> <br>
                    <input class="form-control" type="text" id="meeting_status" readonly name="meeting_status" value="{{ $row['meeting_status']}}" required autocomplete="off">


                  </div>

                </div>
                <input type="hidden" value="{{$parentID}}" name="parentID">

                <div class="form-group row">
                  <label class="col-sm-2 col-form-label">CC</label>
                  <div class="col-sm-4">
                    <select class="form-control mail_cc js-select2" id="mail_cc" multiple="multiple" name="mail_cc[]">
                      <option></option>
                      @foreach($users as $user)
                      @if(in_array($user['email'],$cc))
                      <option value="{{$user['email']}}" selected>{{$user['name']}} : {{$user['email']}}</option>
                      @else
                      <option value="{{$user['email']}}">{{$user['name']}} : {{$user['email']}}</option>
                      @endif
                      @endforeach
                    </select>
                  </div>
                </div>

                <div class="form-group row">
                  <label class="col-sm-2 col-form-label required">Subject</label>
                  <div class="col-sm-4">
                    <input class="form-control" type="text" id="meeting_subject" name="meeting_subject" value="{{ $row['meeting_subject']}}" placeholder="OVM1 Meeting" required autocomplete="off">
                  </div>

                </div>


                <div class="form-group row">
                  <label class="col-sm-2 col-form-label required">Location</label>
                  <div class="col-sm-4">
                    <input class="form-control" type="text" id="meeting_location" name="meeting_location" value="{{ $row['meeting_location']}}" placeholder="Enter Location" required autocomplete="off">
                  </div>
                </div>

                <div class="form-group row">
                  <label class="col-sm-2 col-form-label required">Start Date and Time</label>
                  <div class="col-sm-4">
                    <input type='text' class="form-control meeting_date" id='meeting_startdate' name="meeting_startdate" onchange="autodateupdate(this)" value="{{ $row['meeting_startdate']}}" required placeholder="DD/MM/YYYY" autocomplete="off">
                  </div>
                  <div class="col-sm-2">
                    <div class="content">
                      <input class="form-control" type="time" id="meeting_starttime" name="meeting_starttime" value="{{ $row['meeting_starttime']}}" required onchange="autoupdatedescription1()">
                    </div>
                  </div>

                </div>



                <div class="form-group row">
                  <label class="col-sm-2 col-form-label required">End Date and Time</label>
                  <div class="col-sm-4">
                    <input type='text' class="form-control meeting_date" id="meeting_enddate" name="meeting_enddate" onchange="autodateupdate(this)" value="{{ $row['meeting_enddate']}}" required placeholder="DD/MM/YYYY" autocomplete="off">
                  </div>
                  <div class="col-sm-2">

                    <div class="content">
                      <input class="form-control" type="time" id="meeting_endtime" name="meeting_endtime" value="{{ $row['meeting_endtime']}}" required onchange="autoupdatedescription2()">
                    </div>
                    <br>

                  </div>

                  <input class="form-control" type="hidden" id="attachment" name="attachment" value="{{ $row['attachment']}}" required autocomplete="off">
                  <input class="form-control" type="hidden" id="oldattachment" name="oldattachment" value="{{ config('setting.base_url') }}{{ $row['attachment']}}" required autocomplete="off">
                  <input type="hidden" id="attachmentID" name="attachmentID" value="{{$attachment}}">
                  <div class="form-group row">
                    <label class="col-sm-2 col-form-label">File Attachment</label>
                    <div class="col-sm-4">
                      <input class="form-control" type="file" id="file" name="file" oninput="" maxlength="20" value="" autocomplete="off">
                      <!-- <a href="#" id="viewLink" style="display:none" target="_blank"><i class="fa fa-file"></i> View Uploaded Document</a> -->
                      <!-- <div style="color: rgb(246, 15, 15); display: block;margin: 5px 0px 0px 3px;">File Size must be below 2MB.<br>Only Following extension files could be uploaded .PDF, MS Word, .JPG & .JPEG.</div> -->
                    </div>
                    <div class="col-sm-2">
                      <a href="#" id="viewLink" class="btn btn-info" title="View Attachment" style="display:none;" target="_blank"><i class="fa fa-eye" style="color:white!important"></i> View</a>
                    </div>
                  </div>
                  <div class="col-lg-12">
                    <div class="form-group">
                      <label class="form-label">Meeting Description</label>
                      <textarea class="form-control" id="description" name="meeting_description" value="{{ $row['meeting_description']}}">{{ $row['meeting_description']}}</textarea>
                    </div>
                  </div>

                </div>



                <div class="row text-center">
                  <div class="col-md-12">
                    <a type="button" class="btn btn-warning text-white" onclick="validateForm('Saved')" name="type" value="Saved">Save</a>
                    <a type="button" class="btn btn-success text-white" onclick="validateForm('Sent')" name="type" value="Sent">Send</a>
                    <a type="button" class="btn btn-labeled back-btn" title="Back" href="{{route('ovm2.index')}}" style="color:white !important">
                      <span class="btn-label" style="font-size:13px !important;"><i class="fa fa-arrow-left"></i></span> Back</a>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

        </form>
        @endforeach


      </div>
    </div>




    <br>

</div>
</section>
</div>
<script>
  const viewLink = document.getElementById('viewLink');
  const defaultFile = document.getElementById('attachment').value;
  const defaultFileUrl = document.getElementById('oldattachment').value;
  if (defaultFile != '' && defaultFile != null) {
    viewLink.setAttribute('href', defaultFileUrl);
    viewLink.style.display = 'inline-block';
  }

  const fileInput = document.getElementById('file');
  fileInput.addEventListener('change', () => {
    const file = fileInput.files[0];
    if (file) {
      viewLink.setAttribute('href', URL.createObjectURL(file));
      viewLink.style.display = 'inline-block';
    } else {
      viewLink.setAttribute('href', defaultFileUrl);
      viewLink.style.display = 'inline-block';
    }
  });
</script>
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/tinymce/4.5.6/tinymce.min.js"></script>
<script src="http://cdnjs.cloudflare.com/ajax/libs/tinymce/4.5.6/jquery.tinymce.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.26.0/moment.min.js"></script>
<script>
  $('#fileup').click(function() {
    $('#file').click();
  });
  $('#file-upload').change(function() {
    var i = $(this).prev('label').clone();
    var file = $('#file-upload')[0].files[0].name;
    var trimmedString = file.substring(0, 15);
    $(this).prev('label').text(trimmedString);
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
  //   getEventsDB("is_coordinator1");
  //   if (co2a != '') {
  //     getEventsDB('is_coordinator2');
  //   }
  // });

  const iscoordinatorfn = (event) => {
    let coordinatorname = event.target.value;
    let currentcoordinator = event.target.name;
    if (currentcoordinator === "is_coordinator1") {
      let iscoordinater2new = JSON.parse($('#is_coordinator2old').attr('data-attr'));
      iscoordinater2new = iscoordinater2new.filter(name => name.name !== coordinatorname)
      alternatecoordinator = document.getElementById('is_coordinator2')
      var ddd = '<option >Select-IS-Coordinator-2</option>';
      for (i = 0; i < iscoordinater2new.length; i++) {
        ddd += '<option value="' + iscoordinater2new[i].name + '">' + iscoordinater2new[i].name + '</option>';
      }
      let currentcoordinatorname = alternatecoordinator.value;
      alternatecoordinator.innerHTML = "";
      alternatecoordinator.innerHTML = ddd;
      alternatecoordinator.value = currentcoordinatorname;
    } else {
      let iscoordinater1new = JSON.parse($('#is_coordinator1old').attr('data-attr'));
      iscoordinater1new = iscoordinater1new.filter(name => name.name !== coordinatorname)
      alternatecoordinator = document.getElementById('is_coordinator1');
      var ddd = '<option >Select-IS-Coordinator-1</option>';
      for (i = 0; i < iscoordinater1new.length; i++) {
        ddd += '<option value="' + iscoordinater1new[i].name + '">' + iscoordinater1new[i].name + '</option>';
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
    if (data1.length > 5) {
      swal.fire("IS Co-ordinator-1 has Already Assigned with Five Child", "", "error");
      return false;
    }
    if (data2.length > 5) {
      swal.fire("IS Co-ordinator-2 has Already Assigned with Five Child", "", "error");
      return false;
    }

    data1 = data1.filter(i => startdate.includes(i.idate));
    const data1Len = data1.length;
    if (data1Len >= 2) {
      swal.fire("IS Co-ordinator-1 has Two Appointment", "", "error");
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

    const date = new Date();
    let day = date.getDate();
    let month = date.getMonth() + 1;
    let year = date.getFullYear();
    let currentDate = `${year}-${month}-${day}`;

    var twentyMinutesLater = new Date();
    twentyMinutesLater.setMinutes(twentyMinutesLater.getMinutes() + 2);
    var currentTime = new Date(twentyMinutesLater).toLocaleTimeString("en-GB");

    if (currentDate == meeting_startdate) {
      if (meeting_starttime < currentTime) {
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

    var filedoc = document.getElementById('file');
    // console.log(filedoc);
    // if (filedoc != null) {
    //   var fileInput3 = $('#file');
    //   var maxSize3 = fileInput3.data('max-size');
    //   var fileSize3 = fileInput3.get(0).files[0].size;
    //   if (fileSize3 > maxSize3) {
    //     swal.fire("File size is more than 2MB in Intern with Elina", "", "error");
    //     return false;
    //   }
    // }

    var length = 5;
    var meeting_starttime_u = meeting_starttime.substring(0, length);
    var meeting_endtime_U = meeting_endtime.substring(0, length);

    document.getElementById('meeting_starttime').value = meeting_starttime_u;
    document.getElementById('meeting_endtime').value = meeting_endtime_U;

    document.getElementById('meeting_status').value = a;
    document.getElementById('type').value = a;

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
    select_coordinator1.disabled = false; select_coordinator2.disabled = false;
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
        $(".loader").show();
        document.getElementById('ovm').submit(a);
      }
    })
  }
</script>


<script>
  function getproposaldocument(id) {
    var id = (id);
    var id1 = id.substring(id.indexOf("/") + 1);
    $('#modalviewdiv').html('');
    $("#loading_gif").show();
    // console.log(id1);
    $.ajax({
      url: "{{url('view_attachment_documents')}}",
      type: 'post',
      data: {
        id: id1,
        _token: '{{csrf_token()}}'
      },
      error: function() {
        alert('File Format not supports');
      },
      success: function(data) {
        // console.log(data.length);
        if (data.length > 0) {
          $("#loading_gif").hide();
          var proposaldocuments = "<div class='removeclass' id='modalviewdiv' style=' height:100%'><iframe src='" + data + "' class='document_ifarme_view' style='width:100%; height:100%'></iframe></div>";
          $('.removeclass').remove();
          var document = $('#template').append(proposaldocuments);
        }

      }
    });
  };

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

  var m1 = document.getElementById('meeting_startdate').value;
  var m2 = document.getElementById('meeting_starttime').value;
  var m3 = document.getElementById('meeting_endtime').value;
  m2 = convertTimeFormat(m2);
  m3 = convertTimeFormat(m3);

  function autodateupdate(datev) {
    $('#meeting_startdate').val(datev.value);
    $('#meeting_enddate').val(datev.value);

    var mDate1 = document.getElementById('meeting_startdate').value;
    var content = tinymce.get('description').getContent();
    if (mDate1 != '') {
      content = content.replace(m1, mDate1);
      m1 = mDate1;
    }
    tinymce.get('description').setContent(content);

  }
</script>
<script>
  function autoupdatedescription1() {
    var mTime1_s = document.getElementById('meeting_starttime').value;
    mTime1_s = convertTimeFormat(mTime1_s);
    var content = tinymce.get('description').getContent();
    if (mTime1_s != '') {
      content = content.replace(m2, mTime1_s);
      tinymce.get('description').setContent(content);
      m2 = mTime1_s;
    }
  }

  function autoupdatedescription2() {
    var mTime1_e = document.getElementById('meeting_endtime').value;
    mTime1_e = convertTimeFormat(mTime1_e);
    var content = tinymce.get('description').getContent();
    if (mTime1_e != '') {
      content = content.replace(m3, mTime1_e);
      tinymce.get('description').setContent(content);
      m3 = mTime1_e;
    }
  }
</script>
@include('newenrollement.formmodal')
@endsection