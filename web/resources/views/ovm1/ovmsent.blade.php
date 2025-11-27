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

  .form-control:disabled,
  .form-control[readonly] {
    background-color: #e9ecef !important;
    opacity: 1;
  }

  .centerid {
    width: 100%;
    text-align: center;
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
    {{ Breadcrumbs::render('ovmsent' , $rows[0]['ovm_meeting_id']) }}

    <div class="section-body mt-1">
      <h5 class="text-center" style="color:darkblue">OVM -1 Session Closure</h5>
      <div class="row">
        <div class="col-12">

          <div class="card">
            <div class="card-body">
              @foreach($rows as $key=>$row)
              <form action="{{route('ovm1.update', $row['ovm_meeting_id'])}}" method="POST" id="ovm" enctype="multipart/form-data">
                {{ csrf_field() }}
                @method('PUT')


                <div class="row is-coordinate">
                  <div class="col-md-3">
                    <div class="form-group">
                      <label class="control-label required">OVM Meeting ID</label>
                      <input class="form-control readonly" name="ovm_meeting_unique" value="{{ $row['ovm_meeting_unique']}}" required readonly>
                    </div>
                  </div>
                  <div class="col-md-3">
                    <div class="form-group">
                      <label class="control-label required">Enrollment ID</label>
                      <input class="form-control readonly" name="enrollment_id" placeholder="Enrollment ID" value="{{ $row['enrollment_id']}}" required readonly>
                    </div>
                  </div>

                  <input type="hidden" value="{{$row['created_by']}}" id="created_by" name="created_by">
                  <div class="col-md-3">
                    <div class="form-group">
                      <label class="control-label required">Child ID</label>
                      <input class="form-control readonly" type="text" id="child_id" name="child_id" value="{{ $row['child_id']}}" placeholder="OVM1 Meeting" readonly required autocomplete="off">
                    </div>
                  </div>



                  <div class="col-md-3">
                    <div class="form-group">
                      <label class="control-label required">Child Name</label>
                      <input class="form-control readonly" type="text" id="child_name" name="child_name" value="{{ $row['child_name']}}" readonly placeholder="Enter Name" required autocomplete="off">
                    </div>
                  </div>

                  <div class="col-md-4">
                    <div class="form-group ">
                      <label class="control-label required">IS Co-ordinator-1</label>
                      <input class="form-control" type="text" value="{{$row['is_coordinator1']['name']}}" readonly required>
                      <input class="form-control" type="hidden" id="Is Co-ordinator" name="is_coordinator1" value="{{$row['is_coordinator1']['id']}}" readonly required>
                    </div>
                  </div>

                  @if($row['is_coordinator2'] != [])
                  <div class="col-md-4">
                    <div class="form-group ">
                      <label class="control-label required">IS Co-ordinator-2</label>
                      <input class="form-control" type="text" value="{{$row['is_coordinator2']['name']}}" readonly required>
                      <input class="form-control" type="hidden" id="Is Co-ordinator" name="is_coordinator2" value="{{$row['is_coordinator2']['id']}}" readonly required>
                    </div>
                  </div>
                  @endif

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
                    <input class="form-control readonly" type="text" readonly id="meeting_to" name="meeting_to" value="{{ $row['meeting_to']}}" placeholder="Email Id" readonly required autocomplete="off">
                  </div>
                  <!-- <div class="col-md-2">
                  </div> -->
                  <div class="col-md-2">
                    <label class="control-label centerid required">Status</label> <br>
                    <Select class="form-control" type="text" id="meeting_status" name="meeting_status" value="{{ $row['meeting_status']}}" required autocomplete="off" onchange="statusfn(event)">

                      @if($authID != $row['created_by'])

                        @if(in_array( $authID , $attendeeID))
                          @foreach($attendee as $aa)
                            @if($authID == $aa['attendee'])
                            <option id="meeting_status1" value="{{ $aa['overall_status']}}">{{ $aa['overall_status']}}</option>
                              @if($aa['overall_status']!="Accepted")
                              <option value="Accepted">Accepted</option>
                              @endif
                              @if($aa['overall_status']!="Declined")
                              <option value="Declined">Declined</option>
                              @endif
                              @if($aa['overall_status']!="Hold")
                              <option value="Hold">Hold</option>
                              @endif
                              @if($aa['overall_status']!="Rescheduled")

                                @if($authID == $row['created_by'])
                                <option value="Rescheduled">Reschedule</option>
                                @else
                                <option value="Reschedule Request">Reschedule</option>
                                @endif
                
                              @endif
                            @endif
                          @endforeach
                        @else
                          <!-- <option value="">Need Action</option> -->
                          <option id="meeting_status1" value="{{ $row['meeting_status']}}">{{ $row['meeting_status']}}</option>
                          <!-- <option value="Accepted">Accepted</option> -->
                          <option value="Declined">Declined</option>
                          <option value="Hold">Hold</option>
                          <option value="Reschedule Request">Reschedule</option>
                        @endif

                      @else
                      <option id="meeting_status1" value="{{ $row['meeting_status']}}">{{ $row['meeting_status']}}</option>
                      @if($row['meeting_status']!="Accepted")
                      <option value="Accepted">Accepted</option>
                      @endif
                      @if($row['meeting_status']!="Declined")
                      <option value="Declined">Declined</option>
                      @endif
                      @if($row['meeting_status']!="Hold")
                      <option value="Hold">Hold</option>
                      @endif
                      @if($row['meeting_status']!="Rescheduled" && $row['meeting_status'] !="Reschedule Request")
                      <option value="Rescheduled">Reschedule</option>
                      @endif
                      @endif


                    </Select>

                  </div>
                  <div class="col-md-3" id="notesdiv" style="display: none;">
                    <label class="control-label centerid">Note</label> <br>
                    <textarea class="form-control" name="notes" id=""></textarea>
                  </div>
                  <div class="col-md-1" style="margin: -8px 0px 0px -20px;">
                    <label class="control-label centerid"></label> <br><br>
                    <a href="#addModal" data-toggle="modal" data-target="#addModal" class="btn btn-primary" title="Attendee Status" data-toggle="modal" data-target="#templates" style="margin-inline:5px"><i class="fa fa-bars" style="color:white!important"></i></a>
                  </div>
                </div>

                <div class="form-group row">
                  <label class="col-sm-2 col-form-label">CC</label>
                  <div class="col-sm-4">
                    <select class="form-control mail_cc js-select2" id="mail_cc" multiple="multiple" disabled>
                      <option></option>
                      @foreach($users as $user)
                      @if(in_array($user['email'],$cc))
                      <option value="{{$user['email']}}" selected>{{$user['name']}} : {{$user['email']}}</option>
                      @endif
                      @endforeach
                    </select>
                  </div>
                  <!--  -->
                  <div class="col-sm-4" style="display: none;">
                    <select class="form-control mail_cc js-select2" id="mail_cc" multiple="multiple" name="mail_cc[]">
                      <option></option>
                      @foreach($users as $user)
                      @if(in_array($user['email'],$cc))
                      <option value="{{$user['email']}}" selected>{{$user['name']}} : {{$user['email']}}</option>
                      @endif
                      @endforeach
                    </select>
                  </div>
                  <!--  -->
                </div>


                <div class="form-group row">
                  <label class="col-sm-2 col-form-label required">Subject</label>
                  <div class="col-sm-4">
                    <input class="form-control" readonly type="text" id="meeting_subject" name="meeting_subject" value="{{ $row['meeting_subject']}}" placeholder="OVM1 Meeting" required autocomplete="off">
                  </div>
                  <!-- <div class="col-md-2"></div>
                  <div class="col-md-2">
                    <textarea name="" id=""></textarea>
                  </div> -->
                </div>


                <div class="form-group row">
                  <label class="col-sm-2 col-form-label required">Location</label>
                  <div class="col-sm-4">
                    <input class="form-control" type="text" readonly id="meeting_location" name="meeting_location" value="{{ $row['meeting_location']}}" placeholder="Enter Location" required autocomplete="off">
                  </div>
                </div>

                <div class="form-group row">
                  <label class="col-sm-2 col-form-label required">Start Date and Time</label>
                  <div class="col-sm-4">
                    <div class="inner-addon right-addon">
                      <i class="glyphicon fas fa-calendar-alt"></i>
                      <input type='text' class="form-control meeting_date" id='meeting_startdate' name="meeting_startdate" onchange="autodateupdate(this)" value="{{ $row['meeting_startdate']}}" required placeholder="DD/MM/YYYY" required readonly>
                    </div>
                  </div>
                  <div class="col-sm-2">
                    <div class="content">
                      <input class="form-control" type="time" id="meeting_starttime" name="meeting_starttime" value="{{ $row['meeting_starttime']}}" required readonly onchange="autoupdatedescription1()">
                    </div>
                  </div>
                </div>
                <div class="form-group row">
                  <label class="col-sm-2 col-form-label required">End Date and Time</label>
                  <div class="col-sm-4">
                    <div class="inner-addon right-addon">
                      <i class="glyphicon fas fa-calendar-alt"></i>
                      <input type='text' class="form-control meeting_date" id="meeting_enddate" name="meeting_enddate" onchange="autodateupdate(this)" value="{{ $row['meeting_enddate']}}" required placeholder="DD/MM/YYYY" required readonly>
                    </div>
                  </div>
                  <div class="col-sm-2">
                    <div class="content">
                      <input class="form-control" type="time" id="meeting_endtime" name="meeting_endtime" value="{{ $row['meeting_endtime']}}" required readonly onchange="autoupdatedescription1()">
                    </div>
                    <br>
                  </div>
                  <input type="hidden" id="type" name="type">
                  @if($row['meeting_status'] == 'Accepted')
                  <div class="form-group row" id="video_link1">
                    <label class="col-sm-2 col-form-label">Video Link</label>
                    <div class="col-sm-4">
                      <input class="form-control" type="url" id="video_link" name="video_link" autocomplete="off">
                      <div style="color: rgb(246, 15, 15); display: block;margin: 5px 0px 0px 0px;">Google Drive Link Only</div>
                    </div>
                  </div>
                  @endif

                  <div class="col-lg-12" style="margin: 20px 0px 0px 0px;">
                    <div class="form-group">
                      <label class="form-label">Meeting Description</label>
                      <textarea class="form-control" id="description" name="meeting_description" value="{{ $row['meeting_description']}}">{{ $row['meeting_description']}}</textarea>
                    </div>
                  </div>

                </div>
                <div class="row text-center">
                  <div class="col-md-12">
                    <a type="button" class="btn btn-warning text-white" id="savebutton" onclick="validateForm1('Completed')" name="type" value="Saved">Close</a>
                    
                    @if($authID == $row['created_by'])
                    @if($row['meeting_status'] == 'Accepted')
                    <!-- <a type="button" class="btn btn-warning text-white" id="savebutton" onclick="validateForm1('Completed')" name="type" value="Saved">Close</a> -->
                    @elseif($row['meeting_status'] == 'Declined')
                    <button type="submit" id="savebutton" class="btn btn-warning" name="type" value="Saved"> Declined </button>
                    @elseif($row['meeting_status'] == 'Reschedule Request')
                    <a type="button" id="savebutton" class="btn btn-warning text-white" onclick="validateForm2('Reschedule')" name="type" value="Reschedule">Reschedule</a>
                    @elseif($row['meeting_status'] == 'Completed')
                    @else
                    <button type="submit" id="savebutton" class="btn btn-warning" name="type" value="Saved">Save</button>
                    @endif
                    @else
                    @if($row['meeting_status'] == 'Accepted')
                    <!-- <a type="button" class="btn btn-warning text-white" id="savebutton" onclick="validateForm1('Completed')" name="type" value="Saved">Close</a> -->
                    @endif
                    <button type="submit" id="savebutton" class="btn btn-warning" name="type" value="Saved">Save</button>
                    @endif

                    @if($authID == $row['created_by'])
                    <!-- <button type="submit" id="resch" class="btn btn-success" name="type" value="Sent" style="display:none">Send</button> -->
                    <a type="button" id="resch" class="btn btn-success text-white" onclick="validateForm('Sent')" style="display:none" name="type" value="Sent">Send</a>
                    @else
                    <!-- <button type="submit" id="resch" class="btn btn-success" name="type" value="Reschedule" style="display:none">Send</button> -->
                    <a type="button" id="resch" class="btn btn-success text-white" onclick="validateForm('Reschedule')" style="display:none" name="type" value="Reschedule">Reschedule</a>
                    @endif
                    <a type="button" class="btn btn-labeled back-btn" title="Back" href="{{route('ovm1.index')}}" style="color:white !important">
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
<div class="modal fade" id="addModal">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <div class="main-contents">
        <section class="section">
          <div class="modal-header bg-primary" style=" background-color: rgb(0 103 172) !important;">
            <h4 class="modal-title">Attendee Status</h4>
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          </div>
          <div class="modal-body" style="background-color: #edfcff !important;">
            <div class="section-body mt-2">
              <div class="row">
                <div class="col-12">
                  <div class="mt-0 ">
                    <div class="card-body" id="card_header">
                      <div class="row">
                      </div>
                      <div class="table-wrapper">
                        <div class="table-responsive  p-3">
                          <table class="table table-bordered">
                            <thead>
                              <tr>
                                <th>Sl. No.</th>
                                <th>Attendee</th>
                                <th>Status</th>
                                <th>Notes</th>
                              </tr>
                            </thead>
                            <tbody>
                              @foreach($attendee as $key => $data)
                              <tr>
                                <td>{{$loop->iteration}}</td>
                                <td>{{$data['name']}}</td>
                                <td>{{$data['status']}}</td>
                                <td>{{$data['notes']}}</td>
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
    </div>
  </div>
</div>
</div>
<script>
  $(".js-select2").select2({
    closeOnSelect: false,
    placeholder: "No Data Available",
    allowHtml: true,
    tags: true
  });

  $(function() {
    $('.meeting_date').datepicker({
      dateFormat: 'dd/mm/yy',
      changeMonth: true,
      changeYear: true,
      yearRange: '-100:+0',
      minDate: 0,
      beforeShow: function(input, inst) {
        if ($(input).is('[readonly]')) {
          return false;
        }
      }
    });
  });

  $(document).ready(function() {
    $('.meeting_date').click(function(e) {
      if ($(this).prop('readonly')) {
        e.preventDefault(); // prevent datepicker from showing
      }
    });
  });
</script>
<script>
  function autodateupdate(datev) {
    $('#meeting_startdate').val(datev.value);
    $('#meeting_enddate').val(datev.value);
    autoupdatedescription1();
  }
  meeting_startdate.min = new Date().toISOString().split("T")[0];
  meeting_enddate.min = new Date().toISOString().split("T")[0];
</script>
<script type="text/javascript">
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

<script>
  function validateForm(a) {

    // alert(a);
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
    // if (data1.length > 5) {
    //   swal.fire("IS Co-ordinator-1 has Already Assigned with Five Child", "", "error");
    //   return false;
    // }
    // if (data2.length > 5) {
    //   swal.fire("IS Co-ordinator-2 has Already Assigned with Five Child", "", "error");
    //   return false;
    // }

    // data1 = data1.filter(i => startdate.includes(i.idate));
    // const data1Len = data1.length;
    // if (data1Len >= 2) {
    //   swal.fire("IS Co-ordinator-2 has Two Appointment", "", "error");
    //   return false;
    // }

    // data2 = data2.filter(j => startdate.includes(j.idate));
    // const data2Len = data2.length;
    // if (data2Len >= 2) {
    //   swal.fire("IS Co-ordinator-2 has Two Appointment", "", "error");
    //   return false;
    // }

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

    var length = 5;
    var meeting_starttime_u = meeting_starttime.substring(0, length);
    var meeting_endtime_U = meeting_endtime.substring(0, length);
    document.getElementById('meeting_starttime').value = meeting_starttime_u;
    document.getElementById('meeting_endtime').value = meeting_endtime_U;

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
    } else if (a == 'Completed') {
      var swalText = 'Complete';
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
        document.getElementById('ovm').submit(a);
      }
    })
  }

  function validateForm1(a) {

    const today = new Date().setHours(0, 0, 0, 0);
    const givenDateStr = document.getElementById('meeting_startdate').value;
    const day = givenDateStr.substring(0, 2);
    const month = givenDateStr.substring(2, 4) - 1;
    const year = givenDateStr.substring(4, 8);
    const givenDate = new Date(year, month, day);
    givenDate.setHours(0, 0, 0, 0);

    if (givenDate.getTime() < today) {
      confirmComplete(a);
    } else if (givenDate.getTime() === today) {
      confirmComplete(a);
    } else {
      confirmComplete(a);
      // swal.fire("This Meeting is currently in progress.This Meeting Can't be Closed", "", "error");
      // return false;
    }

  }

  function confirmComplete(a) {
    document.getElementById("meeting_status1").value = a;
    document.getElementById('type').value = 'Saved';
    // console.log(document.getElementById('meeting_status').value);
    if (a == 'Saved') {
      var swalText = 'Save';
    } else if (a == 'Sent') {
      var swalText = 'Schedule';
    } else if (a == 'Completed') {
      var swalText = 'Complete';
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
      width: '550px',
    }).then((result) => {
      if (result.value) {
        document.getElementById('ovm').submit(a);
      }
    })
  }

  function validateForm2(a) {

    var co_one = $('#is_coordinator1').val();
    var co_two = $('#is_coordinator2').val();
    var startdate = $('#meeting_startdate').val();

    if (co_one == "Select-IS-Coordinator-1") {
      swal.fire("Please Select IS Coordinator1 ", "", "error");
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

    var length = 5;
    var meeting_starttime_u = meeting_starttime.substring(0, length);
    var meeting_endtime_U = meeting_endtime.substring(0, length);
    document.getElementById('meeting_starttime').value = meeting_starttime_u;
    document.getElementById('meeting_endtime').value = meeting_endtime_U;

    document.getElementById("meeting_status1").value = a;
    document.getElementById('type').value = 'Sent';
    console.log(document.getElementById('meeting_status').value);
    tinyMCE.triggerSave();

    if (a == 'Saved') {
      var swalText = 'Save';
    } else if (a == 'Sent') {
      var swalText = 'Schedule';
    } else if (a == 'Completed') {
      var swalText = 'Complete';
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
        document.getElementById('ovm').submit(a);
      }
    })
  }
</script>

<script type="text/javascript">
  const statusfn = (event) => {
    let status = event.target.value;
    let currenetstatus = document.getElementById("resch");
    let savebutton = document.getElementById("savebutton");
    let ovmdat = document.getElementById("ovmdat");
    savebutton.value = status;
    currenetstatus.style.display = (status === "Rescheduled") ? "inline-block" : "none";
    currenetstatus.innerHTML = (status === "Rescheduled") ? "Reschedule" : status;
    // ovmdat.style.display = (status === "Completed") ? "inline-block" : "none";

    var authID = <?php echo json_decode($authID) ?>;
    var createdby = document.getElementById('created_by').value;
    if (authID == createdby) {
      if (status == "Rescheduled") {
        $('#meeting_startdate').prop('readonly', false);
        $('#meeting_starttime').prop('readonly', false);
        $('#meeting_enddate').prop('readonly', false);
        $('#meeting_endtime').prop('readonly', false);
        $('#meeting_subject').prop('readonly', false);
        $('#meeting_location').prop('readonly', false);
      } else {
        $('#meeting_startdate').prop('readonly', true);
        $('#meeting_starttime').prop('readonly', true);
        $('#meeting_enddate').prop('readonly', true);
        $('#meeting_endtime').prop('readonly', true);
        $('#meeting_subject').prop('readonly', true);
        $('#meeting_location').prop('readonly', true);
      }
    }

    if (status == "Hold" || status == "Declined" || status == "Rescheduled" || status == "Reschedule Request") {
      $('#notesdiv').show();
      $('#notes').prop('required', true);
    } else {
      $('#notesdiv').hide();
      $('#notes').prop('required', false);
    }

    if (status == "Completed") {
      $('#video_link1').show();
      $('#video_link').prop(true);
    } else {
      $('#video_link1').hide();
      $('#video_link').prop(false);
    }
    //...video_link
  }

  $(document).ready(function() {
    var authID = <?php echo json_decode($authID) ?>;
    var createdby = document.getElementById('created_by').value;
    if (authID == createdby) {
      var state = document.getElementById('meeting_status').value;
      if (state == 'Reschedule Request') {
        $('#meeting_startdate').prop('readonly', false);
        $('#meeting_starttime').prop('readonly', false);
        $('#meeting_enddate').prop('readonly', false);
        $('#meeting_endtime').prop('readonly', false);
        $('#meeting_subject').prop('readonly', false);
        $('#meeting_location').prop('readonly', false);
      }
    }

  });
</script>
<script>
  var m1 = document.getElementById('meeting_startdate').value;
  var m2 = document.getElementById('meeting_starttime').value;
  m2 = convertTimeFormat(m2);
  var m3 = document.getElementById('meeting_endtime').value;
  m3 = convertTimeFormat(m3);
  var repeate1 = m1 + ' from ' + m2 + ' to ' + m3;

  function autoupdatedescription1() {
    var mDate1 = document.getElementById('meeting_startdate').value;
    var mTime1_s = document.getElementById('meeting_starttime').value;
    mTime1_s = convertTimeFormat(mTime1_s);
    var mTime1_e = document.getElementById('meeting_endtime').value;
    mTime1_e = convertTimeFormat(mTime1_e);

    if (mDate1 != '' && mTime1_s != '' && mTime1_e != '') {
      var text1 = mDate1 + ' from ' + mTime1_s + ' to ' + mTime1_e;
      var content = tinymce.get('description').getContent();
      // if (repeate1 == undefined) {
      //   content = content.replace(/ovm1MeetingDetails/g, text1);
      // } else {
      content = content.replace(repeate1, text1);
      // }
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