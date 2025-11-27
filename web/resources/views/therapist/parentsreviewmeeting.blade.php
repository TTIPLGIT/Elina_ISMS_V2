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
  #is_coordinator1
  {
    background-color: rgb(128 128 128 / 34%) !important;

  }

  #invite {
    display: none;
  }

  #co_one,
  #co_two {
    padding: 0 0 0 5px;
    background: transparent;
  }

  .select2-container {
    width: 100% !important;
  }

  .select2-container--default .select2-selection--multiple .select2-selection__choice {
    color: black !important;
  }
</style>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.16/dist/sweetalert2.all.min.js"></script>


<div class="main-content" style="position:absolute !important; z-index: -2!important; ">

  <!-- Main Content -->
  <section class="section">

    {{ Breadcrumbs::render('Therapistreviewinvite') }}

    <div class="section-body mt-1">
      <h5 class="text-center" style="color:darkblue">Monthly Parents Review Meeting Invite</h5>
      <div class="row">
        <div class="col-12">

          <div class="card">
            <div class="card-body">

              <!-- <form method="POST" action="{{ route('ovm1.store') }}"> onsubmit="return validateForm()" -->
              <form action="{{route('therapist.store')}}" method="POST" id="ormeet" enctype="multipart/form-data">

                @csrf

                <div class="row is-coordinate">
                  <div class="col-md-4">
                    <div class="form-group">
                      <label class="control-label">Enrollment ID<span class="error-star" style="color:red;">*</span></label>
                      <select class="form-control" id="enrollment_child_num" name="enrollment_child_num" onchange="GetChilddetails()" required>
                        <option value="">Select-Enrollment</option>

                        @foreach($rows as $key=>$row)

                        <option value="{{ $row['enrollment_child_num'] }}">{{ $row['enrollment_child_num'] }}( {{$row['child_name']}} )</option>
                        @endforeach
                      </select>
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group">
                      <label class="control-label">Child ID</label>
                      <input class="form-control" type="text" id="child_id" name="child_id" placeholder="Child ID" autocomplete="off" readonly>
                      <input type="hidden" id="enrollment_id" name="enrollment_id" autocomplete="off" readonly>
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group">
                      <label class="control-label">Child Name</label>
                      <input class="form-control" type="text" id="child_name" name="child_name" oninput="Childname(event)" maxlength="20" value="" placeholder="Enter Name" autocomplete="off" readonly>
                    </div>
                  </div>
                </div>
                <div class="row check" style="display:none !important;">
                  <div class="col-md-4">
                    <div class="form-group ">
                      <label class="control-label">IS Co-ordinator<span class="error-star" style="color:red;">*</span></label>
                      <div style="display: flex;">
                        <select class="form-control" id="is_coordinator1" name="is_coordinator1" onchange="iscoordinatorfn(event)" disabled required>
                          <option>Select-IS-Coordinator</option>

                          <option value="131">Robert</option>

                        </select>
                        <button style="display: none;" id="co_one" title="Availability Calendar" class="btn" data-toggle="modal" data-target="#calModal" type="button">
                          <i style="color: blue;font-size: 20px;" class="fa fa-calendar" aria-hidden="true"></i></button>
                      </div>
                      <input type="hidden" id="is_coordinator1old">
                      <input type="hidden" id="is_coordinator1current">
                    </div>
                  </div>
                  <!-- <div class="col-md-4">
                    <div class="form-group">
                      <label class="control-label">IS Co-ordinator-2<span class="error-star" style="color:red;">*</span></label>
                      <div style="display: flex;">
                        <select class="form-control" id="is_coordinator2" name="is_coordinator2" onchange="iscoordinatorfn(event)" required>
                          <option>Select-IS-Coordinator-2</option>
                          
                          <option value="132">Robert</option>
                        </select>
                        <button style="display: none;" id="co_two" title="Availability Calendar" class="btn" data-toggle="modal" data-target="#calModal2" type="button">
                          <i style="color: blue;font-size: 20px;" class="fa fa-calendar" aria-hidden="true"></i></button>
                      </div>
                      <input type="hidden" id="is_coordinator2old">
                      <input type="hidden" id="is_coordinator2current">
                    </div>
                  </div> -->
                </div>
            </div>
          </div>
        </div>
      </div>
      <br>

      <!-- <div id="calendar"></div> -->

      <div class="row text-center">
        <div class="col-md-12">
          <button onclick="newmeeting()" class="btn btn-success mb-1">Initiate</button>
        </div>
      </div>
      <div class="row" id="invite">
        <div class="col-12">
          <div class="card">
            <div class="card-body">
              <div class="form-group row" style="margin-bottom: 5px;">
                <label class="col-sm-2 col-form-label">To<span class="error-star" style="color:red;">*</span></label>
                <div class="col-sm-4">
                  <input class="form-control" type="text" id="meeting_to" name="meeting_to" placeholder="Email Id" required autocomplete="off">
                </div>
                <div class="col-md-2">
                </div>
                <div class="col-md-2">
                  <label class="control-label centerid">Status</label> <br>
                  <input class="form-control" type="text" id="meeting_status" name="meeting_status" placeholder="New" autocomplete="off" readonly>
                </div>
              </div>
              <div class="form-group row">
                <label class="col-sm-2 col-form-label">CC<span class="error-star" style="color:red;">*</span></label>
                <div class="col-sm-4">
                  <select class="form-control mail_cc js-select2" id="mail_cc" multiple="multiple" name="mail_cc[]">
                    <option> </option>

                    <option value="robert@talentakeaways.com" selected>Robert</option>
                    <option value="deena@talentakeaways.com">deena</option>


                  </select>
                </div>
              </div>

              <div class="form-group row">
                <label class="col-sm-2 col-form-label">Subject<span class="error-star" style="color:red;">*</span></label>
                <div class="col-sm-4">
                  <input class="form-control" type="text" id="meeting_subject" name="meeting_subject" placeholder="Review Meeting" title="Meeting Subject" required autocomplete="off">
                </div>
              </div>
              <div class="form-group row">
                <label class="col-sm-2 col-form-label">Location<span class="error-star" style="color:red;">*</span></label>
                <div class="col-sm-4">
                  <input class="form-control" type="text" id="meeting_location" name="meeting_location" oninput="location(event)" title="Meeting Location" maxlength="20" value="" placeholder="Enter Location" required autocomplete="off">
                </div>
              </div>
              <div class="form-group row">
                <label class="col-sm-2 col-form-label">Start Date and Time<span class="error-star" style="color:red;">*</span></label>
                <div class="col-sm-4">

                  <input type='date' class="form-control" id='meeting_startdate' name="meeting_startdate" title="Meeting Start Date" onchange="autodateupdate(this)" required>

                </div>
                <div class="col-sm-2">
                  <div class="content">
                    <input class="form-control" type="time" id="meeting_starttime" name="meeting_starttime" title="Meeting Start Time" required>
                  </div>

                </div>

              </div>
              <div class="form-group row">
                <label class="col-sm-2 col-form-label">End Date and Time<span class="error-star" style="color:red;">*</span></label>
                <div class="col-sm-4">
                  <input type='date' class="form-control" id="meeting_enddate" name="meeting_enddate" title="Meeting End Date" onchange="autodateupdate(this)" required placeholder="MM/DD/YYYY">
                </div>
                <div class="col-sm-2">

                  <div class="content">
                    <input class="form-control" type="time" id="meeting_endtime" name="meeting_endtime" title="Meeting End Time" required>
                  </div>

                </div>
                <div class="col-lg-12">
                  <div class="form-group">
                    <label class="col-form-label">Description</label>

                    <textarea class="form-control" id="meeting_description" name="meeting_description" required></textarea>
                  </div>
                </div>

                <br>

              </div>
              <div class="row text-center">
                <div class="col-md-12">


                  <a type="button" class="btn btn-warning text-white" onclick="validateForm('Saved')" name="type" value="Saved">Save</a>
                  <a type="button" class="btn btn-success text-white" onclick="validateForm1('Sent')" name="type" value="Sent">Send</a>
                  <a type="button" class="btn btn-labeled back-btn" title="Back" href="{{ route('TherapistInit') }}" style="color:white !important">
                    <span class="btn-label" style="font-size:13px !important;"><i class="fa fa-arrow-left"></i></span> Back</a>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      </form>
    </div>

    <div class="row">
      <div class="col-12">
        <div class="card">
          <div class="card-body">
            <div class="row">

            </div>
            <div class="table-wrapper">
              <div class="table-responsive">
                <table class="table table-bordered" id="tableExport">
                  <thead>

                    <th width="7%">Sl. No.</th>
                    <th width="15%">Enrollment Id</th>
                    <th width="10%">Type</th>
                    <th width="10%">IS-Coord</th>
                    <!-- <th width="10%">Therapist</th>
                    <th width="12%">Specialization</th> -->
                    <th width="10%">Session Date & Time</th>
                    <th width="12%">Status</th>
                    <th width="13%">Action</th>
                    </tr>
                  </thead>
                  <tbody>




                    <tr>
                      <td>1</td>
                      <td>EN/2022/12/025(Kaviya)</td>
                      <td>Monthly(P)</td>
                      <td>Robert</td>
                      <!-- <td>-</td>
                      <td>-</td> -->
                      <td>2022-12-30&14:06:00<br></td>
                      <td id="reviewsaved">Saved</td>

                      <td>
                        <a type="button" onclick="send()" id="reviewsend" class="btn btn-labeled btn-succes" title="Sent" style="background-color:green !important;color:white !important;height: 32px;">Send</a>
                        <a class="btn btn-link" title="Show" href="{{ route('Parentsreviewshow',1) }}" style="background-color: darkturquoise;color:white"><i class="fas fa-eye"></i></a>
                        <a class="btn btn-link edit1" title="Edit" href="{{ route('Parentsreviewedit','2') }}" style="background-color: crimson;margin-top: 7px !important;color:white"><i class="fas fa-pencil-alt"></i></a>
                        <a class="btn btn-danger" type="submit" title="Delete" class="btn btn-link" style="color:navy;color:white"><i class="far fa-trash-alt"></i></a>

                      </td>
                    </tr>

                    <tr>
                      <td>2</td>
                      <td>EN/2022/12/025(Kaviya)</td>
                      <td>Monthly(P)</td>
                      <td>Robert</td>
                      <!-- <td>-</td>
                      <td>-</td> -->
                      <td>2022-12-30&14:06:00</td>
                      <td>Sent</td>

                      <td>
                        <a class="btn btn-link" title="Show" href="{{ route('Parentsreviewsentshow',1) }}" style="background-color: darkturquoise;color:white"><i class="fas fa-eye"></i></a>
                        <a class="btn btn-link" title="Reschedule" href="{{ route('Parentsreviewsentedit','2') }}" style="background-color: crimson;color:white"><i class="fas fa-pencil-alt"></i></a>
                      </td>
                    </tr>


                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>


    </div>



  </section>
</div>

<!-- Calander -->
<div class="modal fade row" id="calModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered col-12" role="document">
    <div class="modal-content">
      <!-- <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Modal title</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div> -->
      <div class="modal-body">
        <div id="calendar1"></div>
      </div>
      <!-- <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div> -->
    </div>
  </div>
</div>
<div class="modal fade" id="calModal2" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <!-- <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Modal title</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div> -->
      <div class="modal-body">
        <div id="calendar2"></div>
      </div>
      <!-- <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div> -->
    </div>
  </div>
</div>
<script>
  $(".js-select2").select2({
    closeOnSelect: false,
    placeholder: " Please Select Users",
    allowHtml: true,
    tags: true
  });
</script>
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
    event.preventDefault()
  });

  const iscoordinatorfn = (event) => {

    let coordinatorname = event.target.value;
    let currentcoordinator = event.target.name;


    getEventsDB(currentcoordinator);

    //...
  }
</script>
<script>
  meeting_startdate.min = new Date().toISOString().split("T")[0];
  meeting_enddate.min = new Date().toISOString().split("T")[0];
</script>
<script>
  function newmeeting()

  {
    if (document.getElementById('enrollment_child_num').value == "") {
      swal("Please Select Enrolment Number: ", "", "error");
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

  function location(event) {
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
        // var category_id = json.parse(data);
        console.log(data);

        if (data != '[]') {

          // var user_select = data;
          var optionsdata = "";

          document.getElementById('child_id').value = data[0].child_id;
          document.getElementById('child_name').value = data[0].child_name;
          document.getElementById('meeting_to').value = data[0].child_contact_email;
          document.getElementById('enrollment_id').value = data[0].enrollment_id;

          // console.log(data)


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
    document.querySelector('.check').style.display = 'flex';
    document.querySelector('#is_coordinator1').value = '131';
    $('#is_coordinator1').change();
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
    data1 = data1.filter(i => startdate.includes(i.idate));
    const data1Len = data1.length;
    if (data1Len >= 2) {
      try {
        swal("IS Co-ordinator-2 has Two Appointment", "", "error");
        return false;
      } catch (err) {
        console.log(err);
        return false;
      }

    }

    data2 = data2.filter(j => startdate.includes(j.idate));
    const data2Len = data2.length;
    if (data2Len >= 2) {
      Swal.fire("IS Co-ordinator-2 has Two Appointment", "", "error");
      return false;
    }
    if (document.getElementById('meeting_subject').value == "") {
      Swal.fire("Please Enter Meeting Subject ", "", "error");
      return false;
    }
    if (co_one == "Select-IS-Coordinator-1") {
      Swal.fire("Please Select IS Coordinator1 ", "", "error");
      return false;
    }
    if (co_two == "Select-IS-Coordinator-2") {
      Swal.fire("Please Select IS Coordinator2 ", "", "error");
      return false;
    }
    if (document.getElementById('meeting_location').value == "") {
      Swal.fire("Please Enter Meeting Location", "", "error");
      return false;
    }
    if (document.getElementById('meeting_startdate').value == "") {
      Swal.fire("Please Select Meeting  Start Date ", "", "error");
      return false;
    }
    if (document.getElementById('meeting_starttime').value == "") {
      Swal.fire("Please Select Meeting Start Time", "", "error");
      return false;
    }
    if (document.getElementById('meeting_enddate').value == "") {
      Swal.fire("Please Select Meeting End Date", "", "error");
      return false;
    }
    if (document.getElementById('meeting_endtime').value == "") {
      Swal.fire("Please Select Meeting End Time", "", "error");
      return false;
    }
    var timefrom = new Date();
    temp = $('#meeting_starttime').val().split(":");
    timefrom.setHours((parseInt(temp[0]) - 1 + 24) % 24);
    timefrom.setMinutes(parseInt(temp[1]));

    var timeto = new Date();
    temp = $('#meeting_endtime').val().split(":");
    timeto.setHours((parseInt(temp[0]) - 1 + 24) % 24);
    timeto.setMinutes(parseInt(temp[1]));

    if (timeto < timefrom) {
      Swal.fire("Please Select Valid Time", "", "error");
      return false;
    }

    document.getElementById('meeting_status').value = a;

    tinyMCE.triggerSave();
    console.log($("#meeting_description").val().trim().length < 1);
    var tds = $("#meeting_description");
    console.log(tds);
    if ($("#meeting_description").val().trim().length < 1) {
      Swal.fire("Please Enter Description", "", "error");
      return false;
    }
    const message3 = "Valuer List Approved Successfully";
    location.replace(`/parents/review/invite?message3="${message3}"`);

    //document.getElementById('ormeet').submit(a);

  }

  function validateForm1(a) {
    var co_one = $('#is_coordinator1').val();
    var co_two = $('#Therapist').val();
    var startdate = $('#meeting_startdate').val();
    data1 = data1.filter(i => startdate.includes(i.idate));
    const data1Len = data1.length;
    if (data1Len >= 2) {
      try {
        Swal.fire("IS Co-ordinator-2 has Two Appointment", "", "error");
        return false;
      } catch (err) {
        console.log(err);
        return false;
      }

    }

    data2 = data2.filter(j => startdate.includes(j.idate));
    const data2Len = data2.length;
    if (data2Len >= 2) {
      Swal.fire("IS Co-ordinator-2 has Two Appointment", "", "error");
      return false;
    }
    if (document.getElementById('meeting_subject').value == "") {
      Swal.fire("Please Enter Meeting Subject ", "", "error");
      return false;
    }
    if (co_one == "Select-IS-Coordinator-1") {
      Swal.fire("Please Select IS Coordinator1 ", "", "error");
      return false;
    }
    if (co_two == "Select-IS-Coordinator-2") {
      Swal.fire("Please Select IS Coordinator2 ", "", "error");
      return false;
    }
    if (document.getElementById('meeting_location').value == "") {
      Swal.fire("Please Enter Meeting Location", "", "error");
      return false;
    }
    if (document.getElementById('meeting_startdate').value == "") {
      Swal.fire("Please Select Meeting  Start Date ", "", "error");
      return false;
    }
    if (document.getElementById('meeting_starttime').value == "") {
      Swal.fire("Please Select Meeting Start Time", "", "error");
      return false;
    }
    if (document.getElementById('meeting_enddate').value == "") {
      Swal.fire("Please Select Meeting End Date", "", "error");
      return false;
    }
    if (document.getElementById('meeting_endtime').value == "") {
      Swal.fire("Please Select Meeting End Time", "", "error");
      return false;
    }
    document.getElementById('meeting_status').value = a;

    tinyMCE.triggerSave();
    console.log($("#meeting_description").val().trim().length < 1);
    var tds = $("#meeting_description");
    console.log(tds);
    if ($("#meeting_description").val().trim().length < 1) {
      Swal.fire("Please Enter Description", "", "error");
      return false;
    }
    Swal.fire({

      title: "Are you want to Schedule the Monthly Review Meeting for Parents ?",
      text: "Please click 'Yes' to Schedule the Monthly Parent's Review Meeting.",
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
        const message4 = "Valuer List Approved Successfully";
        location.replace(`/parents/review/invite?message4="${message4}"`);
        //document.getElementById('ormeet').submit(a);


      }
    })

  }

  function autodateupdate(datev) {
    $('#meeting_startdate').val(datev.value);
    $('#meeting_enddate').val(datev.value);
  }

  // ! function() {

  //   var calendar = new Calendar('#calendar', data);

  // }();
</script>
<script>
  setTimeout(func, 2000);

  function func() {
    let url = new URL(window.location.href)

    let message = url.searchParams.get("message3");

    if (message != null) {
      Swal.fire({
        title: "Success",
        text: "Monthly Parents Review Meeting Saved Successfully",
        icon: "success",
      });
    }
  };
</script>
<script>
  setTimeout(func, 2000);

  function func() {
    let url = new URL(window.location.href)

    let message = url.searchParams.get("message7");

    if (message != null) {
      Swal.fire({
        title: "Success",
        text: "Monthly Parents Review Meeting Updated Successfully",
        icon: "success",
      });
    }
  };
</script>

<script>
  setTimeout(func, 2000);

  function func() {
    let url = new URL(window.location.href)

    let message = url.searchParams.get("message4");

    if (message != null) {
      Swal.fire({
        title: "Success",
        text: "Monthly Parents Review Meeting Sent Successfully",
        icon: "success",
      });
    }
  };
</script>

<script>
  function send()

  {
    const message4 = "Valuer List Approved Successfully";
    location.replace(`/parents/review/invite?message4="${message4}"`);


    // window.location.href = "/therapist";
  }
</script>

<script>
window.onload = function() { 

  Swal.fire({
        
        text: "Monthly Parents Review Meeting for EN/2022/12/025(Kaviya) Saved Successfully",
        type: "info",
        icon: "warning",
      });

}

</script>
@endsection