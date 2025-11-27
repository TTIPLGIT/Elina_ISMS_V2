@extends('layouts.adminnav')

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.16/dist/sweetalert2.all.min.js"></script>


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

    {{ Breadcrumbs::render('compass.edit',1) }}
    <div class="section-body mt-1">
      <h5 class="text-center" style="color:darkblue">CoMPASS Orientation Meeting Invite</h5>
      <div class="row">
        <div class="col-12">

          <div class="card">
            <div class="card-body">

              <form action="{{route('compassmeeting.update',1)}}" method="POST" id="orm" enctype="multipart/form-data">
                {{ csrf_field() }}

                <div class="row is-coordinate">
                  <div class="col-md-3">
                    <div class="form-group">
                      <label class="control-label">ORM Meeting ID</label>

                      <input class="form-control" name="orm_meeting_unique" value="ORM/2022/08/001" disabled required>
                    </div>
                  </div>
                  <div class="col-md-3">
                    <div class="form-group">
                      <label class="control-label">Enrollment ID</label>

                      <input class="form-control" name="enrollment_id" placeholder="Enrollment ID" value="EN/2022/12/025" disabled required>
                    </div>
                  </div>


                  <div class="col-md-3">
                    <div class="form-group">
                      <label class="control-label">Child ID</label>
                      <input class="form-control" type="text" id="child_id" name="child_id" value="CH/2022/025" placeholder="OVM1 Meeting" required autocomplete="off">
                    </div>
                  </div>



                  <div class="col-md-3">
                    <div class="form-group">
                      <label class="control-label">Child Name</label>
                      <input class="form-control" type="text" id="child_name" name="child_name" value="Kaviya" placeholder="Enter Name" required autocomplete="off">
                    </div>
                  </div>

                  <div class="row check">
                    <div class="col-md-4">
                      <div class="form-group ">
                        <label class="control-label">IS Co-ordinator<span class="error-star" style="color:red;">*</span></label>
                        <div style="display: flex;">
                          <select class="form-control" id="is_coordinator1" name="is_coordinator1" onchange="iscoordinatorfn(event)" required>
                            <option>Select-IS-Coordinator</option>
                            <option value="131" selected>Robert</option>


                          </select>
                          <button style="display: none;" id="co_one" title="Availability Calendar" class="btn" data-toggle="modal" data-target="#calModal" type="button">
                            <i style="color: blue;font-size: 20px;" class="fa fa-calendar" aria-hidden="true"></i></button>
                        </div>
                        <input type="hidden" id="is_coordinator1old">
                        <input type="hidden" id="is_coordinator1current">
                      </div>
                    </div>


                    <div class="col-md-4 sp1">
                      <div class="form-group">
                        <label class="control-label required">Specialization</label>
                        <select class="form-control 1" value="1" name="Specialization" id="1">
                          <option value="">Select Specialization</option>
                          <option value="Speech Therapist" selected>Speech Therapist</option>
                          <option value="Occupational Therapist">Occupational Therapist</option>
                          <option value="Physical Education">Physical Education</option>
                          <option value="Special Education">Special Education</option>
                        </select>
                      </div>
                    </div>

                    <div class="col-md-4 th1">
                      <div class="form-group">
                        <label class="control-label">Therapist</label><span class="error-star" style="color:red;">*</span>
                        <div class="plus" style="display:flex;">
                          <select class="form-control" name="Therapist" id="Therapist" autocomplete="off" data="1" onchange="iscoordinatorfn(event)" readonly>
                            <option value="">Select Therapist</option>
                            <option value="" selected>Malini</option>

                          </select>
                          <button style="display: none;" id="co_two" title="Availability Calendar" class="btn calendarbtn" data-toggle="modal" data-target="#calModal" type="button" value="1">
                            <i style="color: blue;font-size: 20px;" class="fa fa-calendar" aria-hidden="true"></i></button>

                          <button id="Add_therapist1" name="Add_therapist_btn" title="Add Specialization" class="btn" type="button" value="plus1">
                            <i style="color: blue;font-size: 20px;" id="plus1" class="fa fa-plus-circle" aria-hidden="true"></i></button>
                        </div>


                      </div>
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
                  <label class="col-sm-2 col-form-label">To</label>
                  <div class="col-sm-4">
                    <input class="form-control" type="text" id="meeting_to" name="meeting_to" value="Kaviya@talentakeaways.com" placeholder="Email Id" required autocomplete="off">
                  </div>
                  <div class="col-md-2">
                  </div>

                  <div class="col-md-2">
                    <label class="control-label centerid">Status</label> <br>
                    <Select class="form-control" type="text" id="meeting_status" name="meeting_status" value="Saved" required autocomplete="off">

                      <option value="Accepted">Accepted</option>
                      <option value="Declined">Declined</option>
                      <option value="Hold">Hold</option>
                      <option value="Rescheduled">Rescheduled</option>
                      <option value="Completed">Completed</option>


                    </Select>

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
                    <label class="col-sm-2 col-form-label">Subject</label>
                    <div class="col-sm-4">
                      <input class="form-control" type="text" id="meeting_subject" name="meeting_subject" value="ORM Meeting" placeholder="ORM Meeting" required autocomplete="off">
                    </div>

                  </div>


                  <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Location</label>
                    <div class="col-sm-4">
                      <input class="form-control" type="text" id="meeting_location" name="meeting_location" value="Chennai" placeholder="Enter Location" required autocomplete="off">
                    </div>
                  </div>

                  <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Start Date and Time</label>
                    <div class="col-sm-4">
                      <input type='date' class="form-control" id='meeting_startdate' name="meeting_startdate" value="2023-01-22" required>
                    </div>
                    <div class="col-sm-2">
                      <div class="content">
                        <input class="form-control" type="time" id="meeting_starttime" name="meeting_starttime" value="10:00:00" required>
                      </div>
                    </div>

                  </div>



                  <div class="form-group row">
                    <label class="col-sm-2 col-form-label">End Date and Time</label>
                    <div class="col-sm-4">
                      <input type='date' class="form-control" id="meeting_enddate" name="meeting_enddate" value="2023-01-22" required placeholder="MM/DD/YYYY">
                    </div>
                    <div class="col-sm-2">

                      <div class="content">
                        <input class="form-control" type="time" id="meeting_endtime" name="meeting_endtime" value="11:00:00" required>
                      </div>
                      <br>

                    </div>
                    <div class="col-lg-12">
                      <div class="form-group">
                        <label class="col-form-label">Description</label>

                        <textarea class="form-control" id="description" name="meeting_description" value="ORM Meeting">kindly attend the meeting</textarea>
                      </div>
                    </div>

                  </div>
                  <div class="row text-center">
                    <div class="col-md-12">
                      <button type="submit" class="btn btn-warning" name="type" value="saved">Save</button>
                      <button type="submit" class="btn btn-success" name="type" value="sent">Send</button>
                      <a type=""href="{{route('compassmeeting')}}" class="btn btn-danger text-white">Cancel</a>

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
<script>
  $(".js-select2").select2({
    closeOnSelect: false,
    placeholder: " Please Select Users",
    allowHtml: true,
    tags: true
  });
</script>
<script>
  meeting_startdate.min = new Date().toISOString().split("T")[0];
  meeting_enddate.min = new Date().toISOString().split("T")[0];
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/tinymce/4.5.6/tinymce.min.js"></script>
<script src="http://cdnjs.cloudflare.com/ajax/libs/tinymce/4.5.6/jquery.tinymce.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.26.0/moment.min.js"></script>



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


    getEventsDB(currentcoordinator, event);

    //...
  }
</script>
<script>
  meeting_startdate.min = new Date().toISOString().split("T")[0];
  meeting_enddate.min = new Date().toISOString().split("T")[0];
</script>

<!-- //validation -->
<script>
  function Childame(event) {
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
  };
</script>

<script>
  let ajax = document.querySelector('[name="Specialization"]');
  ajax.addEventListener("change", GetSpecialist);

  function GetSpecialist(e) {
    alert(e.target.value);
    var Specialization = e.target.value;
    //alert(Specialization);
    if (Specialization != "") {
      $.ajax({
        url: "{{ url('/compassmeeting/therapist/specialization') }}",
        type: 'POST',
        data: {
          'Specialization': Specialization,
          _token: '{{csrf_token()}}',

        }
      }).done(function(data) {
        
        console.log(data);

        if (data.length != 0) {
          var optionsdata = "";
          for (var i = 0; i < data.length; i++) {
            var id = data[i]['id'];
            var name = data[i]['name'];
            var option = '<option value="">Select Therapist </option>';
            optionsdata += "<option value=" + name + " >" + name + "</option>";
          }
          // console.log(e.target.parentElement.parentElement.parentElement)
          if (e.target.parentElement.parentElement.parentElement.classList[1] == "check") {

            var stageoption = option.concat(optionsdata);
            var demonew = $(`#Therapist`).html(stageoption);
          } else {

            var stageoption = option.concat(optionsdata);

            var Option = e.target.parentElement.parentElement.nextElementSibling.firstChild.firstChild.nextElementSibling.nextElementSibling.firstChild.innerHTML = stageoption;


          }


        }
      })
    };
  }
</script>
<script>
  function getEventsDB(current_co, event) {

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

      var co_two = $('#Therapist').val();

      if (co_two != null) {

        data1 = [];
        $('#calendar1').html('');

        var calendar = new Calendar('#calendar1', data1);

        if (event.target.nextElementSibling.classList[2] != 'customcal') {

          document.querySelector(`.${event.target.nextElementSibling.classList[1]}`).style.display = "block";

        } else {

          event.target.nextElementSibling.style.display = "block";

        }

      } else {
        //alert("co_");
        $('#co_two').show();
      }
    }
  }

  var data1 = [];
  var data2 = [];

  function getEventData(is_ID, col) {
    // alert(col);

    $.ajax({
      url: '/calendar/event/getdata',
      type: 'GET',
      async: false,
      data: {
        fieldID: is_ID,
        _token: '{{csrf_token()}}'
      }
    }).done(function(data) {
      //alert(data);
      var response = JSON.parse(data);

      if (col == 'col1') {
        data1 = [];
        //data3 = [];
        for (let index = 0; index < response.length; index++) {
          const eventvalue = response[index];
          data1.push(eventvalue);
        }
        $('#calendar1').html('');
        //alert(data1);
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

  function calendarfn() {

    data1 = [];
    $('#calendar1').html('');
    //alert(data1);
    var calendar = new Calendar('#calendar1', data1);


  }
  //co_two

  function validateForm(a) {


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


    document.getElementById('ormeet').submit(a);



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

      title: "Are you want to Schedule the Orientation Meeting ?",
      text: "Please click 'Yes' to Schedule the ORM Meeting.",
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
        document.getElementById('ormeet').submit(a);


      }
    })

  }


  function autodateupdate(datev) {
    $('#meeting_startdate').val(datev.value);
    $('#meeting_enddate').val(datev.value);
  }
</script>
<script>
  let addTherapist = document.querySelector('[name="Add_therapist_btn"]');

  function addTherapistFunction(e) {
    //alert("hii");


    if (document.querySelector('[name="Specialization"]').value == "") {
      Swal.fire("Please Select Specialization: ", "", "error");
      return false;
    }
    if (document.querySelector('[name="Therapist"]').value == "") {
      Swal.fire("Please Select Therapist: ", "", "error");
      return false;
    } else {

    }


    if ((e.target.value == 'plus1') || (e.target.tagName == "I")) {
      // alert("add");
      console.log(e.target.previousElementSibling);
      plus = e.target.previousElementSibling.value;

      var x = plus;
      //alert(x);
      var btid_new = ++x;
      // alert(btid_new);


      $('.check').append('<div class="row remove"><div class="col-md-4 sp1"><div class="form-group"><label class="control-label required">Specialization</label><select class="form-control 1" value="1" name="Specialization" id="1" ><option value="">Select Specialization</option><option value="Speech Therapist">Speech Therapist</option><option value="Occupational Therapist">Occupational Therapist</option><option value="Physical Education">Physical Education</option><option value="Special Education">Special Education</option> </select></div></div> <div class="col-md-4 th1"><div class="form-group"><label class="control-label">Therapist</label><span class="error-star" style="color:red;">*</span><div class="plus" style="display:flex;"><select class="form-control" name="Therapist" id="Therapist" autocomplete="off" onchange="iscoordinatorfn(event)" readonly><option value="">Select Therapist</option></select><button style="display: none;" id="co_two" title="Availability Calendar" class="btn calendarbtn customcal cal ' + btid_new + ' " data-toggle="modal" data-target="#calModal" value=" ' + btid_new + ' "type="button"><i style="color: blue;font-size: 20px;" class="fa fa-calendar" aria-hidden="true"></i></button></div></div></div><button id="Add_therapist1" name="Add_therapist_btn" title="Add Specialization" style="height: 50%;margin-top: 25px;" class="btn" type="button" ><i style="color: blue;font-size: 20px;" id="plus1" class="fa fa-minus-circle" aria-hidden="true"></i></button></div>');
    } else if (e.target.value != 'plus1') {

      e.target.parentElement.style.display = "none";

    }


    const cbox = document.querySelectorAll('[name="Specialization"]');

    for (let i = 0; i < cbox.length; i++) {
      //alert(i);
      cbox[i].addEventListener("change", GetSpecialist);
    }
    const plusaddbox = document.querySelectorAll('[name="Add_therapist_btn"]');

    for (let i = 0; i < plusaddbox.length; i++) {
      //alert(i);
      plusaddbox[i].addEventListener("click", addTherapistFunction);
    }
  }
  addTherapist.addEventListener('click', addTherapistFunction);
</script>


@endsection