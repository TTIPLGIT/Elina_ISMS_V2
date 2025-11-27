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

  .select2-container--default .select2-selection--single .select2-selection__rendered {
    color: #444;
    line-height: 42px !important;
  }

  .centerid {
    width: 100%;
    text-align: center;
  }



  #co_one,
  #co_two {
    padding: 0 0 0 5px;
    background: transparent;
  }

  .fas.fa-eye {
    color: black;
  }

  .btn-danger {

    margin-top: 7px !important;
  }

  .fa-trash-alt {
    color: white;
  }

  .fa-pencil-alt {
    color: white;
  }
</style>


<div class="main-content" style="position:absolute !important; z-index: -2!important; ">
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.16/dist/sweetalert2.all.min.js"></script>

  {{ Breadcrumbs::render('Session') }}
  <!-- Main Content -->
  <section class="section">


    <div class="section-body mt-1">
      <h5 class="text-center" style="color:darkblue">Therapist Session Initiative</h5>
      <div class="row">
        <div class="col-12">

          <div class="card">
            <div class="card-body">

              <!-- <form method="POST" action="{{ route('ovm1.store') }}"> onsubmit="return validateForm()" -->
              <form action="{{route('compass_store')}}" method="POST" id="compassinitiate" enctype="multipart/form-data">

                @csrf


                <div class="row is-coordinate ">
                  <div class="col-md-4">
                    <div class="form-group">
                      <label class="control-label">Enrollment ID<span class="error-star" style="color:red;">*</span></label>
                      <input class="form-control default" type="text" id="enrollment_child_num" name="enrollment_child_num" onchange="GetChilddetails()" value="EN/2022/12/025 (Kaviya)" autocomplete="off" style="background-color:white!important;" readonly>
                      <!-- <select class="form-control" id="enrollment_child_num" name="enrollment_child_num" onchange="GetChilddetails()" required>
                        <option value="">Select-Enrollment</option>
                        <option>EN/2022/12/025</option>

                      </select> -->
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group">
                      <label class="control-label">Child ID</label>
                      <input class="form-control default" type="text" id="child_id" name="child_id" placeholder="Child ID" autocomplete="off" value="CH/2022/025" style="background-color:white!important;" readonly>
                      <!-- <input type="hidden" id="enrollment_id" name="enrollment_id" autocomplete="off" readonly> -->
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group">
                      <label class="control-label">Child Name</label>
                      <input class="form-control default" type="text" id="child_name" name="child_name" oninput="Childname(event)" maxlength="20" value="Kaviya" style="background-color:white!important;" autocomplete="off" readonly>
                    </div>
                  </div>



                  <div class="row check">
                    <div class="col-md-6 sp1">
                      <div class="form-group">
                        <label class="control-label required">Specialization</label>
                        <select class="form-control 1" value="1" name="Specialization" id="1">
                          <option value="">Select Specialization</option>
                          <option value="Speech Therapist">Speech Therapist</option>
                          <option value="Occupational Therapist">Occupational Therapist</option>
                          <option value="Physical Education">Physical Education</option>
                          <option value="Special Education">Special Education</option>
                        </select>
                      </div>
                    </div>





                    <div class="col-md-6 th1">
                      <div class="form-group">
                        <label class="control-label">Therapist</label><span class="error-star" style="color:red;">*</span>
                        <div class="plus" style="display:flex;">
                          <select class="form-control" name="Therapist" id="Therapist1" autocomplete="off" onchange="iscoordinatorfn(event)" readonly>
                            <option value="">Select Therapist</option>

                          </select>
                          <button style="display: none;" id="co_two" title="Availability Calendar" class="btn" data-toggle="modal" data-target="#calModal" type="button">
                            <i style="color: blue;font-size: 20px;" class="fa fa-calendar" aria-hidden="true"></i></button>

                          <button id="Add_therapist1" name="Add_therapist_btn" title="Add Specialization" class="btn" type="button" value="1">
                            <i style="color: blue;font-size: 20px;" id="plus1" class="fa fa-plus-circle" aria-hidden="true"></i></button>
                        </div>
                      </div>
                    </div>
                  



                    <!-- <div class="row">
                      <div class="col-md-7">
                        
                          <label class="control-label">Start Date and Time</label><span class="error-star" style="color:red;">*</span>

                          <div class="col-sm-4">
                            <input type='date' class="form-control" id='meeting_startdate' name="meeting_startdate" title="Meeting Start Date" onchange="autodateupdate(this)" required>
                          </div>
                        
                        <div class="col-sm-3">

                          <input class="form-control" type="time" id="meeting_starttime" name="meeting_starttime" title="Meeting Start Time" required>

                        </div>
                      </div>

                    </div> -->

                    <div class="row form-group">
                      <div class="col-md-6">
                        <div class="row" style="display:flex !important;justify-content: center !important;">
                          <label class="control-label">Start Date and Time</label><span class="error-star" style="color:red;">*</span>
                        </div>
                        <div class="row" >

                          <div class="col-6">
                            <input type='date' class="form-control" id='meeting_startdate' name="meeting_startdate" title="Meeting Start Date" onchange="autodateupdate(this)" required>
                          </div>
                          <div class="col-6">
                            <input class="form-control" type="time" id="meeting_starttime" name="meeting_starttime" title="Meeting Start Time" required>
                          </div>

                        </div>

                      </div>
                      <div class="col-md-6">
                        <div class="row" style="display:flex !important;justify-content: center !important;">
                          <label class="control-label">End Date and Time</label><span class="error-star" style="color:red;">*</span>
                        </div>
                        <div class="row">

                          <div class="col-6">
                            <input type='date' class="form-control" id='meeting_enddate' name="meeting_enddate" title="Meeting End Date" onchange="autodateupdate(this)" required>
                          </div>
                          <div class="col-6">
                            <input class="form-control" type="time" id="meeting_endtime" name="meeting_endtime" title="Meeting End Time" required>
                          </div>

                        </div>

                      </div>
                    </div>




                    <!-- <div class="overall form-group row"> -->
                    <!-- <div class="date_time form-group row"> -->
                    <!-- <div class="col-md-10">
                      <div class="row form-group">
                        <label class="col-sm-2 col-form-label">Start Date and Time<span class="error-star" style="color:red;">*</span></label>
                        <div class="col-sm-4">
                          <input type='date' class="form-control" id='meeting_startdate' name="meeting_startdate" title="Meeting Start Date" onchange="autodateupdate(this)" required>
                        </div>

                        <div class="col-sm-3">
                          <div class="content">
                            <input class="form-control" type="time" id="meeting_starttime" name="meeting_starttime" title="Meeting Start Time" required>
                          </div>

                        </div>
                      </div>
                    </div>
                    <div class="col-md-10">
                      <div class="row form-group">
                        <label class="col-sm-2 col-form-label">End Date and Time<span class="error-star" style="color:red;">*</span></label>
                        <div class="col-sm-4">
                          <input type='date' class="form-control" id='meeting_enddate' name="meeting_enddate" title="Meeting End Date" onchange="autodateupdate(this)" required>
                        </div>

                        <div class="col-sm-3">
                          <div class="content">
                            <input class="form-control" type="time" id="meeting_endtime" name="meeting_endtime" title="Meeting Start Time" required>
                          </div>

                        </div>
                      </div>
                    </div> -->
                    <div class="row apply">
                      <div class="col-md-12" style="display: inline-flex;justify-content: center;">
                        <div class="col-md-3">
                          <input type="radio" id="contactChoice1" class="contactChoice1"name="contact" value="email" checked>
                          <label for="contactChoice1">Apply for 8 months</label>
                        </div>
                        <div class="col-md-3">
                          <input type="radio" id="contactChoice2" name="contact" value="phone">
                          <label for="contactChoice2">Apply for this week</label>
                        </div>
                      </div>
                    </div>
                    <!-- </div> -->

                    

                    <div class="col-md-12">
                      <div class="row form-group">

                        <div class="col-sm-3">
                          <label class="control-label">Notes</label><span class="error-star" style="color:red;">*</span>
                          </label>
                          <div class="col-md-8">
                            <textarea id="meeting_description" name="meeting_description" rows="6" cols="80" required></textarea>
                          </div>
                        </div>
                      </div>
                    </div>


                  </div>
                </div>
            </div>
          </div>
          <br>

          <div class="col-md-12  text-center" style="padding-top: 1rem;">
            <a type="button" onclick="save()" id="submitbutton" class="btn btn-labeled btn-succes" title="Submit" style="background:orange !important; border-color:green !important; color:white !important">
              <span class="btn-label" style="font-size:13px !important;"><i class="fa fa-check"></i></span>Save</a>

            <a type="button" onclick="invite()" id="submitbutton" class="btn btn-labeled btn-succes" title="Submit" style="background: green !important; border-color:green !important; color:white !important">
              <span class="btn-label" style="font-size:13px !important;"><i class="fa fa-check"></i></span>Initiate</a>


            <a type="button" class="btn btn-labeled back-btn" title="Back" href="{{ route('therapist.weeeklycal') }}" style="color:white !important">

              <span class="btn-label" style="font-size:13px !important;"><i class="fa fa-arrow-left"></i></span> Back</a>

          </div>

          </form>
        </div>
      </div>
      <br>
      <div class="row" id="secondrow">
        <div class="col-12">
          <div class="card">
            <div class="card-body">
              <div class="row">

              </div>
              <div class="table-wrapper">
                <div class="table-responsive">
                  <table class="table table-bordered" id="align">
                    <thead>

                      <th width="7%">Sl. No.</th>
                      <th width="15%">Enrollment Id</th>
                      <th width="10%">Type</th>
                      <!-- <th width="10%">IS-Coord</th> -->
                      <th width="10%">Therapist</th>
                      <th width="12%">Specialization</th>
                      <th width="10%">Session Date & Time</th>
                      <th width="12%">Status</th>
                      <th width="13%">Action</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <td>1</td>
                        <td>EN/2022/12/025(Kaviya)</td>
                        <td>Weekly</td>
                        <!-- <td>-</td> -->
                        <td>Malini</td>
                        <td>Speech</td>
                        <td>2023-02-06&14:06:00</td>
                        <td>Sent</td>

                        <td>
                          <a class="btn btn-link" title="Show" href="{{ route('SessionMeetingSentShow',1) }}" style="background-color: darkturquoise;color:white;"><i class="fas fa-eye"></i></a>
                          <a class="btn btn-link" title="Reschedule" href="{{ route('SessionMeetingSentEdit',1) }}" style="background-color: crimson;color:white;"><i class="fas fa-pencil-alt"></i></a>
                        </td>
                      </tr>
                      <tr>
                        <td>2</td>
                        <td>EN/2022/12/025(Kaviya)</td>
                        <td>Weekly</td>
                        <!-- <td>-</td> -->
                        <td>Malini <br></td>
                        <td>Speech<br></td>
                        <td>2023-01-23&10:00:00<br></td>
                        <td>Saved</td>

                        <td>
                          <a type="button" onclick="send()" id="sendbutton" class="btn btn-labeled btn-succes" title="Sent" style="background-color:green !important;color:white !important;height: 32px;">Send</a>
                          <a class="btn btn-link" title="Show" href="{{ route('TherapistWeeklyShow',1) }}" style="background-color: darkturquoise;color:white;"><i class="fas fa-eye"></i></a>
                          <a class="btn btn-link edit" title="Edit" href="{{ route('TherapistWeeklyEdit','2') }}" style="background-color: crimson;margin-top: 7px !important;color:white;"><i class="fas fa-pencil-alt"></i></a>
                          <a class="btn btn-danger" type="submit" title="Delete" class="btn btn-link" style="color:navy;color:white;"><i class="far fa-trash-alt"></i></a>

                        </td>
                      </tr>
                      <tr>
                        <td>3</td>
                        <td>EN/2022/12/025(Kaviya)</td>
                        <td>Weekly</td>
                        <!-- <td>-</td> -->
                        <td>Malini <br></td>
                        <td>Speech<br></td>
                        <td>2023-01-30&10:00:00<br></td>
                        <td id="sent">Saved</td>

                        <td>
                          <a type="button" onclick="send()" id="sendbutton" class="btn btn-labeled btn-succes" title="Sent" style="background-color:green !important;color:white !important;height: 32px;">Send</a>
                          <a class="btn btn-link" title="Show" href="{{ route('TherapistWeeklyShow',1) }}" style="background-color: darkturquoise;color:white;"><i class="fas fa-eye"></i></a>
                          <a class="btn btn-link edit" title="Edit" href="{{ route('TherapistWeeklyEdit','2') }}" style="background-color: crimson;margin-top: 7px !important;color:white;"><i class="fas fa-pencil-alt"></i></a>
                          <a class="btn btn-danger" type="submit" title="Delete" class="btn btn-link" style="color:navy;color:white;"><i class="far fa-trash-alt"></i></a>

                        </td>
                      </tr>



                      <tr>
                        <td>4</td>
                        <td>EN/2022/12/025(Kaviya)</td>
                        <td>Weekly</td>
                        <!-- <td>-</td> -->
                        <td>Malini <br></td>
                        <td>Speech<br></td>
                        <td>2023-02-06&10:00:00<br></td>
                        <td id="sent">Saved</td>

                        <td>
                          <a type="button" onclick="send()" id="sendbutton" class="btn btn-labeled btn-succes" title="Sent" style="background-color:green !important;color:white !important;height: 32px;">Send</a>
                          <a class="btn btn-link" title="Show" href="{{ route('TherapistWeeklyShow',1) }}" style="background-color: darkturquoise;color:white;"><i class="fas fa-eye"></i></a>
                          <a class="btn btn-link edit" title="Edit" href="{{ route('TherapistWeeklyEdit','2') }}" style="background-color: crimson;margin-top: 7px !important;color:white;"><i class="fas fa-pencil-alt"></i></a>
                          <a class="btn btn-danger" type="submit" title="Delete" class="btn btn-link" style="color:navy;color:white;"><i class="far fa-trash-alt"></i></a>

                        </td>
                      </tr>

                      <tr>
                        <td>5</td>
                        <td>EN/2022/12/025(Kaviya)</td>
                        <td>Weekly</td>
                        <!-- <td>-</td> -->
                        <td>Malini <br></td>
                        <td>Speech<br></td>
                        <td>2023-02-13&10:00:00<br></td>
                        <td id="sent">Saved</td>

                        <td>
                          <a type="button" onclick="send()" id="sendbutton" class="btn btn-labeled btn-succes" title="Sent" style="background-color:green !important;color:white !important;height: 32px;">Send</a>
                          <a class="btn btn-link" title="Show" href="{{ route('TherapistWeeklyShow',1) }}" style="background-color: darkturquoise;color:white;"><i class="fas fa-eye"></i></a>
                          <a class="btn btn-link edit" title="Edit" href="{{ route('TherapistWeeklyEdit','2') }}" style="background-color: crimson;margin-top: 7px !important;color:white;"><i class="fas fa-pencil-alt"></i></a>
                          <a class="btn btn-danger" type="submit" title="Delete" class="btn btn-link" style="color:navy;color:white;"><i class="far fa-trash-alt"></i></a>

                        </td>
                      </tr>

                      <tr>
                        <td>6</td>
                        <td>EN/2022/12/025(Kaviya)</td>
                        <td>Weekly</td>
                        <!-- <td>-</td> -->
                        <td>Malini <br></td>
                        <td>Speech<br></td>
                        <td>2023-02-20&10:00:00<br></td>
                        <td id="sent">Saved</td>

                        <td>
                          <a type="button" onclick="send()" id="sendbutton" class="btn btn-labeled btn-succes" title="Sent" style="background-color:green !important;color:white !important;height: 32px;">Send</a>
                          <a class="btn btn-link" title="Show" href="{{ route('TherapistWeeklyShow',1) }}" style="background-color: darkturquoise;color:white;"><i class="fas fa-eye"></i></a>
                          <a class="btn btn-link edit" title="Edit" href="{{ route('TherapistWeeklyEdit','2') }}" style="background-color: crimson;margin-top: 7px !important;color:white;"><i class="fas fa-pencil-alt"></i></a>
                          <a class="btn btn-danger" type="submit" title="Delete" class="btn btn-link" style="color:navy;color:white;"><i class="far fa-trash-alt"></i></a>

                        </td>
                      </tr>

                      <tr>
                        <td>7</td>
                        <td>EN/2022/12/025(Kaviya)</td>
                        <td>Weekly</td>
                        <!-- <td>-</td> -->
                        <td>Malini <br></td>
                        <td>Speech<br></td>
                        <td>2023-02-27&10:00:00<br></td>
                        <td id="sent">Saved</td>

                        <td>
                          <a type="button" onclick="send()" id="sendbutton" class="btn btn-labeled btn-succes" title="Sent" style="background-color:green !important;color:white !important;height: 32px;">Send</a>
                          <a class="btn btn-link" title="Show" href="{{ route('TherapistWeeklyShow',1) }}" style="background-color: darkturquoise;color:white;"><i class="fas fa-eye"></i></a>
                          <a class="btn btn-link edit" title="Edit" href="{{ route('TherapistWeeklyEdit','2') }}" style="background-color: crimson;margin-top: 7px !important;color:white;"><i class="fas fa-pencil-alt"></i></a>
                          <a class="btn btn-danger" type="submit" title="Delete" class="btn btn-link" style="color:navy;color:white;"><i class="far fa-trash-alt"></i></a>

                        </td>
                      </tr>

                      <tr>
                        <td>8</td>
                        <td>EN/2022/12/025(Kaviya)</td>
                        <td>Weekly</td>
                        <!-- <td>-</td> -->
                        <td>Malini <br></td>
                        <td>Speech<br></td>
                        <td>2023-03-06&10:00:00<br></td>
                        <td id="sent">Saved</td>

                        <td>
                          <a type="button" onclick="send()" id="sendbutton" class="btn btn-labeled btn-succes" title="Sent" style="background-color:green !important;color:white !important;height: 32px;">Send</a>
                          <a class="btn btn-link" title="Show" href="{{ route('TherapistWeeklyShow',1) }}" style="background-color: darkturquoise;color:white;"><i class="fas fa-eye"></i></a>
                          <a class="btn btn-link edit" title="Edit" href="{{ route('TherapistWeeklyEdit','2') }}" style="background-color: crimson;margin-top: 7px !important;color:white;"><i class="fas fa-pencil-alt"></i></a>
                          <a class="btn btn-danger" type="submit" title="Delete" class="btn btn-link" style="color:navy;color:white;"><i class="far fa-trash-alt"></i></a>

                        </td>
                      </tr>

                      <tr>
                        <td>9</td>
                        <td>EN/2022/12/025(Kaviya)</td>
                        <td>Weekly</td>
                        <!-- <td>-</td> -->
                        <td>Malini <br></td>
                        <td>Speech<br></td>
                        <td>2023-03-13&10:00:00<br></td>
                        <td id="sent">Saved</td>

                        <td>
                          <a type="button" onclick="send()" id="sendbutton" class="btn btn-labeled btn-succes" title="Sent" style="background-color:green !important;color:white !important;height: 32px;">Send</a>
                          <a class="btn btn-link" title="Show" href="{{ route('TherapistWeeklyShow',1) }}" style="background-color: darkturquoise;color:white;"><i class="fas fa-eye"></i></a>
                          <a class="btn btn-link edit" title="Edit" href="{{ route('TherapistWeeklyEdit','2') }}" style="background-color: crimson;margin-top: 7px !important;color:white;"><i class="fas fa-pencil-alt"></i></a>
                          <a class="btn btn-danger" type="submit" title="Delete" class="btn btn-link" style="color:navy;color:white;"><i class="far fa-trash-alt"></i></a>

                        </td>
                      </tr>

                      <tr>
                        <td>10</td>
                        <td>EN/2022/12/025(Kaviya)</td>
                        <td>Weekly</td>
                        <!-- <td>-</td> -->
                        <td>Malini <br></td>
                        <td>Speech<br></td>
                        <td>2023-03-20&10:00:00<br></td>
                        <td id="sent">Saved</td>

                        <td>
                          <a type="button" onclick="send()" id="sendbutton" class="btn btn-labeled btn-succes" title="Sent" style="background-color:green !important;color:white !important;height: 32px;">Send</a>
                          <a class="btn btn-link" title="Show" href="{{ route('TherapistWeeklyShow',1) }}" style="background-color: darkturquoise;color:white;"><i class="fas fa-eye"></i></a>
                          <a class="btn btn-link edit" title="Edit" href="{{ route('TherapistWeeklyEdit','2') }}" style="background-color: crimson;margin-top: 7px !important;color:white;"><i class="fas fa-pencil-alt"></i></a>
                          <a class="btn btn-danger" type="submit" title="Delete" class="btn btn-link" style="color:navy;color:white;"><i class="far fa-trash-alt"></i></a>

                        </td>
                      </tr>

                      <tr>
                        <td>11</td>
                        <td>EN/2022/12/025(Kaviya)</td>
                        <td>Weekly</td>
                        <!-- <td>-</td> -->
                        <td>Malini <br></td>
                        <td>Speech<br></td>
                        <td>2023-02-20&10:00:00<br></td>
                        <td id="sent">Saved</td>

                        <td>
                          <a type="button" onclick="send()" id="sendbutton" class="btn btn-labeled btn-succes" title="Sent" style="background-color:green !important;color:white !important;height: 32px;">Send</a>
                          <a class="btn btn-link" title="Show" href="{{ route('TherapistWeeklyShow',1) }}" style="background-color: darkturquoise;color:white;"><i class="fas fa-eye"></i></a>
                          <a class="btn btn-link edit" title="Edit" href="{{ route('TherapistWeeklyEdit','2') }}" style="background-color: crimson;margin-top: 7px !important;color:white;"><i class="fas fa-pencil-alt"></i></a>
                          <a class="btn btn-danger" type="submit" title="Delete" class="btn btn-link" style="color:navy;color:white;"><i class="far fa-trash-alt"></i></a>

                        </td>
                      </tr>

                      <tr>
                        <td>12</td>
                        <td>EN/2022/12/025(Kaviya)</td>
                        <td>Weekly</td>
                        <!-- <td>-</td> -->
                        <td>Malini <br></td>
                        <td>Speech<br></td>
                        <td>2023-03-27&10:00:00<br></td>
                        <td id="sent">Saved</td>

                        <td>
                          <a type="button" onclick="send()" id="sendbutton" class="btn btn-labeled btn-succes" title="Sent" style="background-color:green !important;color:white !important;height: 32px;">Send</a>
                          <a class="btn btn-link" title="Show" href="{{ route('TherapistWeeklyShow',1) }}" style="background-color: darkturquoise;color:white;"><i class="fas fa-eye"></i></a>
                          <a class="btn btn-link edit" title="Edit" href="{{ route('TherapistWeeklyEdit','2') }}" style="background-color: crimson;margin-top: 7px !important;color:white;"><i class="fas fa-pencil-alt"></i></a>
                          <a class="btn btn-danger" type="submit" title="Delete" class="btn btn-link" style="color:navy;color:white;"><i class="far fa-trash-alt"></i></a>

                        </td>
                      </tr>



                      <tr>
                        <td>13</td>
                        <td>EN/2022/12/025(Kaviya)</td>
                        <td>Weekly</td>
                        <!-- <td>-</td> -->
                        <td>Malini <br></td>
                        <td>Speech<br></td>
                        <td>2023-04-03&10:00:00<br></td>
                        <td id="sent">Saved</td>

                        <td>
                          <a type="button" onclick="send()" id="sendbutton" class="btn btn-labeled btn-succes" title="Sent" style="background-color:green !important;color:white !important;height: 32px;">Send</a>
                          <a class="btn btn-link" title="Show" href="{{ route('TherapistWeeklyShow',1) }}" style="background-color: darkturquoise;color:white;"><i class="fas fa-eye"></i></a>
                          <a class="btn btn-link edit" title="Edit" href="{{ route('TherapistWeeklyEdit','2') }}" style="background-color: crimson;margin-top: 7px !important;color:white;"><i class="fas fa-pencil-alt"></i></a>
                          <a class="btn btn-danger" type="submit" title="Delete" class="btn btn-link" style="color:navy;color:white;"><i class="far fa-trash-alt"></i></a>

                        </td>
                      </tr>

                      <tr>
                        <td>14</td>
                        <td>EN/2022/12/025(Kaviya)</td>
                        <td>Weekly</td>
                        <!-- <td>-</td> -->
                        <td>Malini <br></td>
                        <td>Speech<br></td>
                        <td>2023-04-10&10:00:00<br></td>
                        <td id="sent">Saved</td>

                        <td>
                          <a type="button" onclick="send()" id="sendbutton" class="btn btn-labeled btn-succes" title="Sent" style="background-color:green !important;color:white !important;height: 32px;">Send</a>
                          <a class="btn btn-link" title="Show" href="{{ route('TherapistWeeklyShow',1) }}" style="background-color: darkturquoise;color:white;"><i class="fas fa-eye"></i></a>
                          <a class="btn btn-link edit" title="Edit" href="{{ route('TherapistWeeklyEdit','2') }}" style="background-color: crimson;margin-top: 7px !important;color:white;"><i class="fas fa-pencil-alt"></i></a>
                          <a class="btn btn-danger" type="submit" title="Delete" class="btn btn-link" style="color:navy;color:white;"><i class="far fa-trash-alt"></i></a>

                        </td>
                      </tr>

                      <tr>
                        <td>15</td>
                        <td>EN/2022/12/025(Kaviya)</td>
                        <td>Weekly</td>
                        <!-- <td>-</td> -->
                        <td>Malini <br></td>
                        <td>Speech<br></td>
                        <td>2023-04-17&10:00:00<br></td>
                        <td id="sent">Saved</td>

                        <td>
                          <a type="button" onclick="send()" id="sendbutton" class="btn btn-labeled btn-succes" title="Sent" style="background-color:green !important;color:white !important;height: 32px;">Send</a>
                          <a class="btn btn-link" title="Show" href="{{ route('TherapistWeeklyShow',1) }}" style="background-color: darkturquoise;color:white;"><i class="fas fa-eye"></i></a>
                          <a class="btn btn-link edit" title="Edit" href="{{ route('TherapistWeeklyEdit','2') }}" style="background-color: crimson;margin-top: 7px !important;color:white;"><i class="fas fa-pencil-alt"></i></a>
                          <a class="btn btn-danger" type="submit" title="Delete" class="btn btn-link" style="color:navy;color:white;"><i class="far fa-trash-alt"></i></a>

                        </td>
                      </tr>

                      <tr>
                        <td>16</td>
                        <td>EN/2022/12/025(Kaviya)</td>
                        <td>Weekly</td>
                        <!-- <td>-</td> -->
                        <td>Malini <br></td>
                        <td>Speech<br></td>
                        <td>2023-04-24&10:00:00<br></td>
                        <td id="sent">Saved</td>

                        <td>
                          <a type="button" onclick="send()" id="sendbutton" class="btn btn-labeled btn-succes" title="Sent" style="background-color:green !important;color:white !important;height: 32px;">Send</a>
                          <a class="btn btn-link" title="Show" href="{{ route('TherapistWeeklyShow',1) }}" style="background-color: darkturquoise;color:white;"><i class="fas fa-eye"></i></a>
                          <a class="btn btn-link edit" title="Edit" href="{{ route('TherapistWeeklyEdit','2') }}" style="background-color: crimson;margin-top: 7px !important;color:white;"><i class="fas fa-pencil-alt"></i></a>
                          <a class="btn btn-danger" type="submit" title="Delete" class="btn btn-link" style="color:navy;color:white;"><i class="far fa-trash-alt"></i></a>

                        </td>
                      </tr>

                      <tr>
                        <td>17</td>
                        <td>EN/2022/12/025(Kaviya)</td>
                        <td>Weekly</td>
                        <!-- <td>-</td> -->
                        <td>Malini <br></td>
                        <td>Speech<br></td>
                        <td>2023-05-01&10:00:00<br></td>
                        <td id="sent">Saved</td>

                        <td>
                          <a type="button" onclick="send()" id="sendbutton" class="btn btn-labeled btn-succes" title="Sent" style="background-color:green !important;color:white !important;height: 32px;">Send</a>
                          <a class="btn btn-link" title="Show" href="{{ route('TherapistWeeklyShow',1) }}" style="background-color: darkturquoise;color:white;"><i class="fas fa-eye"></i></a>
                          <a class="btn btn-link edit" title="Edit" href="{{ route('TherapistWeeklyEdit','2') }}" style="background-color: crimson;margin-top: 7px !important;color:white;"><i class="fas fa-pencil-alt"></i></a>
                          <a class="btn btn-danger" type="submit" title="Delete" class="btn btn-link" style="color:navy;color:white;"><i class="far fa-trash-alt"></i></a>

                        </td>
                      </tr>

                      <tr>
                        <td>18</td>
                        <td>EN/2022/12/025(Kaviya)</td>
                        <td>Weekly</td>
                        <!-- <td>-</td> -->
                        <td>Malini <br></td>
                        <td>Speech<br></td>
                        <td>2023-05-08&10:00:00<br></td>
                        <td id="sent">Saved</td>

                        <td>
                          <a type="button" onclick="send()" id="sendbutton" class="btn btn-labeled btn-succes" title="Sent" style="background-color:green !important;color:white !important;height: 32px;">Send</a>
                          <a class="btn btn-link" title="Show" href="{{ route('TherapistWeeklyShow',1) }}" style="background-color: darkturquoise;color:white;"><i class="fas fa-eye"></i></a>
                          <a class="btn btn-link edit" title="Edit" href="{{ route('TherapistWeeklyEdit','2') }}" style="background-color: crimson;margin-top: 7px !important;color:white;"><i class="fas fa-pencil-alt"></i></a>
                          <a class="btn btn-danger" type="submit" title="Delete" class="btn btn-link" style="color:navy;color:white;"><i class="far fa-trash-alt"></i></a>

                        </td>
                      </tr>

                      <tr>
                        <td>19</td>
                        <td>EN/2022/12/025(Kaviya)</td>
                        <td>Weekly</td>
                        <!-- <td>-</td> -->
                        <td>Malini <br></td>
                        <td>Speech<br></td>
                        <td>2023-05-15&10:00:00<br></td>
                        <td id="sent">Saved</td>

                        <td>
                          <a type="button" onclick="send()" id="sendbutton" class="btn btn-labeled btn-succes" title="Sent" style="background-color:green !important;color:white !important;height: 32px;">Send</a>
                          <a class="btn btn-link" title="Show" href="{{ route('TherapistWeeklyShow',1) }}" style="background-color: darkturquoise;color:white;"><i class="fas fa-eye"></i></a>
                          <a class="btn btn-link edit" title="Edit" href="{{ route('TherapistWeeklyEdit','2') }}" style="background-color: crimson;margin-top: 7px !important;color:white;"><i class="fas fa-pencil-alt"></i></a>
                          <a class="btn btn-danger" type="submit" title="Delete" class="btn btn-link" style="color:navy;color:white;"><i class="far fa-trash-alt"></i></a>

                        </td>
                      </tr>

                      <tr>
                        <td>20</td>
                        <td>EN/2022/12/025(Kaviya)</td>
                        <td>Weekly</td>
                        <!-- <td>-</td> -->
                        <td>Malini <br></td>
                        <td>Speech<br></td>
                        <td>2023-05-22&10:00:00<br></td>
                        <td id="sent">Saved</td>

                        <td>
                          <a type="button" onclick="send()" id="sendbutton" class="btn btn-labeled btn-succes" title="Sent" style="background-color:green !important;color:white !important;height: 32px;">Send</a>
                          <a class="btn btn-link" title="Show" href="{{ route('TherapistWeeklyShow',1) }}" style="background-color: darkturquoise;color:white;"><i class="fas fa-eye"></i></a>
                          <a class="btn btn-link edit" title="Edit" href="{{ route('TherapistWeeklyEdit','2') }}" style="background-color: crimson;margin-top: 7px !important;color:white;"><i class="fas fa-pencil-alt"></i></a>
                          <a class="btn btn-danger" type="submit" title="Delete" class="btn btn-link" style="color:navy;color:white;"><i class="far fa-trash-alt"></i></a>

                        </td>
                      </tr>

                      <tr>
                        <td>21</td>
                        <td>EN/2022/12/025(Kaviya)</td>
                        <td>Weekly</td>
                        <!-- <td>-</td> -->
                        <td>Malini <br></td>
                        <td>Speech<br></td>
                        <td>2023-05-29&10:00:00<br></td>
                        <td id="sent">Saved</td>

                        <td>
                          <a type="button" onclick="send()" id="sendbutton" class="btn btn-labeled btn-succes" title="Sent" style="background-color:green !important;color:white !important;height: 32px;">Send</a>
                          <a class="btn btn-link" title="Show" href="{{ route('TherapistWeeklyShow',1) }}" style="background-color: darkturquoise;color:white;"><i class="fas fa-eye"></i></a>
                          <a class="btn btn-link edit" title="Edit" href="{{ route('TherapistWeeklyEdit','2') }}" style="background-color: crimson;margin-top: 7px !important;color:white;"><i class="fas fa-pencil-alt"></i></a>
                          <a class="btn btn-danger" type="submit" title="Delete" class="btn btn-link" style="color:navy;color:white;"><i class="far fa-trash-alt"></i></a>

                        </td>
                      </tr>

                      <tr>
                        <td>22</td>
                        <td>EN/2022/12/025(Kaviya)</td>
                        <td>Weekly</td>
                        <!-- <td>-</td> -->
                        <td>Malini <br></td>
                        <td>Speech<br></td>
                        <td>2023-06-05&10:00:00<br></td>
                        <td id="sent">Saved</td>

                        <td>
                          <a type="button" onclick="send()" id="sendbutton" class="btn btn-labeled btn-succes" title="Sent" style="background-color:green !important;color:white !important;height: 32px;">Send</a>
                          <a class="btn btn-link" title="Show" href="{{ route('TherapistWeeklyShow',1) }}" style="background-color: darkturquoise;color:white;"><i class="fas fa-eye"></i></a>
                          <a class="btn btn-link edit" title="Edit" href="{{ route('TherapistWeeklyEdit','2') }}" style="background-color: crimson;margin-top: 7px !important;color:white;"><i class="fas fa-pencil-alt"></i></a>
                          <a class="btn btn-danger" type="submit" title="Delete" class="btn btn-link" style="color:navy;color:white;"><i class="far fa-trash-alt"></i></a>

                        </td>
                      </tr>

                      <tr>
                        <td>23</td>
                        <td>EN/2022/12/025(Kaviya)</td>
                        <td>Weekly</td>
                        <!-- <td>-</td> -->
                        <td>Malini <br></td>
                        <td>Speech<br></td>
                        <td>2023-06-12&10:00:00<br></td>
                        <td id="sent">Saved</td>

                        <td>
                          <a type="button" onclick="send()" id="sendbutton" class="btn btn-labeled btn-succes" title="Sent" style="background-color:green !important;color:white !important;height: 32px;">Send</a>
                          <a class="btn btn-link" title="Show" href="{{ route('TherapistWeeklyShow',1) }}" style="background-color: darkturquoise;color:white;"><i class="fas fa-eye"></i></a>
                          <a class="btn btn-link edit" title="Edit" href="{{ route('TherapistWeeklyEdit','2') }}" style="background-color: crimson;margin-top: 7px !important;color:white;"><i class="fas fa-pencil-alt"></i></a>
                          <a class="btn btn-danger" type="submit" title="Delete" class="btn btn-link" style="color:navy;color:white;"><i class="far fa-trash-alt"></i></a>

                        </td>
                      </tr>

                      <tr>
                        <td>24</td>
                        <td>EN/2022/12/025(Kaviya)</td>
                        <td>Weekly</td>
                        <!-- <td>-</td> -->
                        <td>Malini <br></td>
                        <td>Speech<br></td>
                        <td>2023-06-12&10:00:00<br></td>
                        <td id="sent">Saved</td>

                        <td>
                          <a type="button" onclick="send()" id="sendbutton" class="btn btn-labeled btn-succes" title="Sent" style="background-color:green !important;color:white !important;height: 32px;">Send</a>
                          <a class="btn btn-link" title="Show" href="{{ route('TherapistWeeklyShow',1) }}" style="background-color: darkturquoise;color:white;"><i class="fas fa-eye"></i></a>
                          <a class="btn btn-link edit" title="Edit" href="{{ route('TherapistWeeklyEdit','2') }}" style="background-color: crimson;margin-top: 7px !important;color:white;"><i class="fas fa-pencil-alt"></i></a>
                          <a class="btn btn-danger" type="submit" title="Delete" class="btn btn-link" style="color:navy;color:white;"><i class="far fa-trash-alt"></i></a>

                        </td>
                      </tr>


                      <tr>
                        <td>25</td>
                        <td>EN/2022/12/025(Kaviya)</td>
                        <td>Weekly</td>
                        <!-- <td>-</td> -->
                        <td>Malini <br></td>
                        <td>Speech<br></td>
                        <td>2023-06-19&10:00:00<br></td>
                        <td id="sent">Saved</td>

                        <td>
                          <a type="button" onclick="send()" id="sendbutton" class="btn btn-labeled btn-succes" title="Sent" style="background-color:green !important;color:white !important;height: 32px;">Send</a>
                          <a class="btn btn-link" title="Show" href="{{ route('TherapistWeeklyShow',1) }}" style="background-color: darkturquoise;color:white;"><i class="fas fa-eye"></i></a>
                          <a class="btn btn-link edit" title="Edit" href="{{ route('TherapistWeeklyEdit','2') }}" style="background-color: crimson;margin-top: 7px !important;color:white;"><i class="fas fa-pencil-alt"></i></a>
                          <a class="btn btn-danger" type="submit" title="Delete" class="btn btn-link" style="color:navy;color:white;"><i class="far fa-trash-alt"></i></a>

                        </td>
                      </tr>

                      <tr>
                        <td>26</td>
                        <td>EN/2022/12/025(Kaviya)</td>
                        <td>Weekly</td>
                        <!-- <td>-</td> -->
                        <td>Malini <br></td>
                        <td>Speech<br></td>
                        <td>2023-06-19&10:00:00<br></td>
                        <td id="sent">Saved</td>

                        <td>
                          <a type="button" onclick="send()" id="sendbutton" class="btn btn-labeled btn-succes" title="Sent" style="background-color:green !important;color:white !important;height: 32px;">Send</a>
                          <a class="btn btn-link" title="Show" href="{{ route('TherapistWeeklyShow',1) }}" style="background-color: darkturquoise;color:white;"><i class="fas fa-eye"></i></a>
                          <a class="btn btn-link edit" title="Edit" href="{{ route('TherapistWeeklyEdit','2') }}" style="background-color: crimson;margin-top: 7px !important;color:white;"><i class="fas fa-pencil-alt"></i></a>
                          <a class="btn btn-danger" type="submit" title="Delete" class="btn btn-link" style="color:navy;color:white;"><i class="far fa-trash-alt"></i></a>

                        </td>
                      </tr>

                      <tr>
                        <td>27</td>
                        <td>EN/2022/12/025(Kaviya)</td>
                        <td>Weekly</td>
                        <!-- <td>-</td> -->
                        <td>Malini <br></td>
                        <td>Speech<br></td>
                        <td>2023-06-26&10:00:00<br></td>
                        <td id="sent">Saved</td>

                        <td>
                          <a type="button" onclick="send()" id="sendbutton" class="btn btn-labeled btn-succes" title="Sent" style="background-color:green !important;color:white !important;height: 32px;">Send</a>
                          <a class="btn btn-link" title="Show" href="{{ route('TherapistWeeklyShow',1) }}" style="background-color: darkturquoise;color:white;"><i class="fas fa-eye"></i></a>
                          <a class="btn btn-link edit" title="Edit" href="{{ route('TherapistWeeklyEdit','2') }}" style="background-color: crimson;margin-top: 7px !important;color:white;"><i class="fas fa-pencil-alt"></i></a>
                          <a class="btn btn-danger" type="submit" title="Delete" class="btn btn-link" style="color:navy;color:white;"><i class="far fa-trash-alt"></i></a>

                        </td>
                      </tr>

                      <tr>
                        <td>28</td>
                        <td>EN/2022/12/025(Kaviya)</td>
                        <td>Weekly</td>
                        <!-- <td>-</td> -->
                        <td>Malini <br></td>
                        <td>Speech<br></td>
                        <td>2023-07-03&10:00:00<br></td>
                        <td id="sent">Saved</td>

                        <td>
                          <a type="button" onclick="send()" id="sendbutton" class="btn btn-labeled btn-succes" title="Sent" style="background-color:green !important;color:white !important;height: 32px;">Send</a>
                          <a class="btn btn-link" title="Show" href="{{ route('TherapistWeeklyShow',1) }}" style="background-color: darkturquoise;color:white;"><i class="fas fa-eye"></i></a>
                          <a class="btn btn-link edit" title="Edit" href="{{ route('TherapistWeeklyEdit','2') }}" style="background-color: crimson;margin-top: 7px !important;color:white;"><i class="fas fa-pencil-alt"></i></a>
                          <a class="btn btn-danger" type="submit" title="Delete" class="btn btn-link" style="color:navy;color:white;"><i class="far fa-trash-alt"></i></a>

                        </td>
                      </tr>

                      <tr>
                        <td>29</td>
                        <td>EN/2022/12/025(Kaviya)</td>
                        <td>Weekly</td>
                        <!-- <td>-</td> -->
                        <td>Malini <br></td>
                        <td>Speech<br></td>
                        <td>2023-07-10&10:00:00<br></td>
                        <td id="sent">Saved</td>

                        <td>
                          <a type="button" onclick="send()" id="sendbutton" class="btn btn-labeled btn-succes" title="Sent" style="background-color:green !important;color:white !important;height: 32px;">Send</a>
                          <a class="btn btn-link" title="Show" href="{{ route('TherapistWeeklyShow',1) }}" style="background-color: darkturquoise;color:white;"><i class="fas fa-eye"></i></a>
                          <a class="btn btn-link edit" title="Edit" href="{{ route('TherapistWeeklyEdit','2') }}" style="background-color: crimson;margin-top: 7px !important;color:white;"><i class="fas fa-pencil-alt"></i></a>
                          <a class="btn btn-danger" type="submit" title="Delete" class="btn btn-link" style="color:navy;color:white;"><i class="far fa-trash-alt"></i></a>

                        </td>
                      </tr>

                      <tr>
                        <td>30</td>
                        <td>EN/2022/12/025(Kaviya)</td>
                        <td>Weekly</td>
                        <!-- <td>-</td> -->
                        <td>Malini <br></td>
                        <td>Speech<br></td>
                        <td>2023-07-17&10:00:00<br></td>
                        <td id="sent">Saved</td>

                        <td>
                          <a type="button" onclick="send()" id="sendbutton" class="btn btn-labeled btn-succes" title="Sent" style="background-color:green !important;color:white !important;height: 32px;">Send</a>
                          <a class="btn btn-link" title="Show" href="{{ route('TherapistWeeklyShow',1) }}" style="background-color: darkturquoise;color:white;"><i class="fas fa-eye"></i></a>
                          <a class="btn btn-link edit" title="Edit" href="{{ route('TherapistWeeklyEdit','2') }}" style="background-color: crimson;margin-top: 7px !important;color:white;"><i class="fas fa-pencil-alt"></i></a>
                          <a class="btn btn-danger" type="submit" title="Delete" class="btn btn-link" style="color:navy;color:white;"><i class="far fa-trash-alt"></i></a>

                        </td>
                      </tr>

                      <tr>
                        <td>31</td>
                        <td>EN/2022/12/025(Kaviya)</td>
                        <td>Weekly</td>
                        <!-- <td>-</td> -->
                        <td>Malini <br></td>
                        <td>Speech<br></td>
                        <td>2023-07-24&10:00:00<br></td>
                        <td id="sent">Saved</td>

                        <td>
                          <a type="button" onclick="send()" id="sendbutton" class="btn btn-labeled btn-succes" title="Sent" style="background-color:green !important;color:white !important;height: 32px;">Send</a>
                          <a class="btn btn-link" title="Show" href="{{ route('TherapistWeeklyShow',1) }}" style="background-color: darkturquoise;color:white;"><i class="fas fa-eye"></i></a>
                          <a class="btn btn-link edit" title="Edit" href="{{ route('TherapistWeeklyEdit','2') }}" style="background-color: crimson;margin-top: 7px !important;color:white;"><i class="fas fa-pencil-alt"></i></a>
                          <a class="btn btn-danger" type="submit" title="Delete" class="btn btn-link" style="color:navy;color:white;"><i class="far fa-trash-alt"></i></a>

                        </td>
                      </tr>

                      <tr>
                        <td>32</td>
                        <td>EN/2022/12/025(Kaviya)</td>
                        <td>Weekly</td>
                        <!-- <td>-</td> -->
                        <td>Malini <br></td>
                        <td>Speech<br></td>
                        <td>2023-07-31&10:00:00<br></td>
                        <td id="sent">Saved</td>

                        <td>
                          <a type="button" onclick="send()" id="sendbutton" class="btn btn-labeled btn-succes" title="Sent" style="background-color:green !important;color:white !important;height: 32px;">Send</a>
                          <a class="btn btn-link" title="Show" href="{{ route('TherapistWeeklyShow',1) }}" style="background-color: darkturquoise;color:white;"><i class="fas fa-eye"></i></a>
                          <a class="btn btn-link edit" title="Edit" href="{{ route('TherapistWeeklyEdit','2') }}" style="background-color: crimson;margin-top: 7px !important;color:white;"><i class="fas fa-pencil-alt"></i></a>
                          <a class="btn btn-danger" type="submit" title="Delete" class="btn btn-link" style="color:navy;color:white;"><i class="far fa-trash-alt"></i></a>

                        </td>
                      </tr>

                      <tr>
                        <td>33</td>
                        <td>EN/2022/12/025(Kaviya)</td>
                        <td>Weekly</td>
                        <!-- <td>-</td> -->
                        <td>Malini <br></td>
                        <td>Speech<br></td>
                        <td>2023-08-07&10:00:00<br></td>
                        <td id="sent">Saved</td>

                        <td>
                          <a type="button" onclick="send()" id="sendbutton" class="btn btn-labeled btn-succes" title="Sent" style="background-color:green !important;color:white !important;height: 32px;">Send</a>
                          <a class="btn btn-link" title="Show" href="{{ route('TherapistWeeklyShow',1) }}" style="background-color: darkturquoise;color:white;"><i class="fas fa-eye"></i></a>
                          <a class="btn btn-link edit" title="Edit" href="{{ route('TherapistWeeklyEdit','2') }}" style="background-color: crimson;margin-top: 7px !important;color:white;"><i class="fas fa-pencil-alt"></i></a>
                          <a class="btn btn-danger" type="submit" title="Delete" class="btn btn-link" style="color:navy;color:white;"><i class="far fa-trash-alt"></i></a>

                        </td>
                      </tr>

                      <tr>
                        <td>34</td>
                        <td>EN/2022/12/025(Kaviya)</td>
                        <td>Weekly</td>
                        <!-- <td>-</td> -->
                        <td>Malini <br></td>
                        <td>Speech<br></td>
                        <td>2023-08-14&10:00:00<br></td>
                        <td id="sent">Saved</td>

                        <td>
                          <a type="button" onclick="send()" id="sendbutton" class="btn btn-labeled btn-succes" title="Sent" style="background-color:green !important;color:white !important;height: 32px;">Send</a>
                          <a class="btn btn-link" title="Show" href="{{ route('TherapistWeeklyShow',1) }}" style="background-color: darkturquoise;color:white;"><i class="fas fa-eye"></i></a>
                          <a class="btn btn-link edit" title="Edit" href="{{ route('TherapistWeeklyEdit','2') }}" style="background-color: crimson;margin-top: 7px !important;color:white;"><i class="fas fa-pencil-alt"></i></a>
                          <a class="btn btn-danger" type="submit" title="Delete" class="btn btn-link" style="color:navy;color:white;"><i class="far fa-trash-alt"></i></a>

                        </td>
                      </tr>

                      <tr>
                        <td>35</td>
                        <td>EN/2022/12/025(Kaviya)</td>
                        <td>Weekly</td>
                        <!-- <td>-</td> -->
                        <td>Malini <br></td>
                        <td>Speech<br></td>
                        <td>2023-08-21&10:00:00<br></td>
                        <td id="sent">Saved</td>

                        <td>
                          <a type="button" onclick="send()" id="sendbutton" class="btn btn-labeled btn-succes" title="Sent" style="background-color:green !important;color:white !important;height: 32px;">Send</a>
                          <a class="btn btn-link" title="Show" href="{{ route('TherapistWeeklyShow',1) }}" style="background-color: darkturquoise;color:white;"><i class="fas fa-eye"></i></a>
                          <a class="btn btn-link edit" title="Edit" href="{{ route('TherapistWeeklyEdit','2') }}" style="background-color: crimson;margin-top: 7px !important;color:white;"><i class="fas fa-pencil-alt"></i></a>
                          <a class="btn btn-danger" type="submit" title="Delete" class="btn btn-link" style="color:navy;color:white;"><i class="far fa-trash-alt"></i></a>

                        </td>
                      </tr>
                      <tr>
                        <td>36</td>
                        <td>EN/2022/12/025(Kaviya)</td>
                        <td>Weekly</td>
                        <!-- <td>-</td> -->
                        <td>Malini <br></td>
                        <td>Speech<br></td>
                        <td>2023-08-27&10:00:00<br></td>
                        <td id="sent">Saved</td>

                        <td>
                          <a type="button" onclick="send()" id="sendbutton" class="btn btn-labeled btn-succes" title="Sent" style="background-color:green !important;color:white !important;height: 32px;">Send</a>
                          <a class="btn btn-link" title="Show" href="{{ route('TherapistWeeklyShow',1) }}" style="background-color: darkturquoise;color:white;"><i class="fas fa-eye"></i></a>
                          <a class="btn btn-link edit" title="Edit" href="{{ route('TherapistWeeklyEdit','2') }}" style="background-color: crimson;margin-top: 7px !important;color:white;"><i class="fas fa-pencil-alt"></i></a>
                          <a class="btn btn-danger" type="submit" title="Delete" class="btn btn-link" style="color:navy;color:white;"><i class="far fa-trash-alt"></i></a>

                        </td>
                      </tr>



                      <tr>
                        <td>37</td>
                        <td>EN/2022/12/025(Kaviya)</td>
                        <td>Weekly</td>
                        <!-- <td>-</td> -->
                        <td>Sumi</td>
                        <td>OT</td>
                        <td>2022-12-10&14:06:00</td>
                        <td id="sent">Saved</td>

                        <td>
                          <a type="button" onclick="send()" id="send" class="btn btn-labeled btn-succes" title="Sent" style="background-color:green !important;color:white !important;height: 32px;">Send</a>
                          <a class="btn btn-link" title="Show" href="{{ route('TherapistWeeklyShow',1) }}" style="background-color: darkturquoise;color:white;"><i class="fas fa-eye"></i></a>
                          <a class="btn btn-link " title="Edit" href="{{ route('TherapistWeeklyEdit','2') }}" style="background-color: crimson;margin-top: 7px !important;color:white;"><i class="fas fa-pencil-alt"></i></a>
                          <a class="btn btn-danger" type="submit" title="Delete" class="btn btn-link" style="color:navy;color:white;"><i class="far fa-trash-alt"></i></a>

                        </td>
                      </tr>



                      <tr>
                        <td>38</td>
                        <td>EN/2022/12/025(Kaviya)</td>
                        <td>Weekly</td>
                        <!-- <td>-</td> -->
                        <td>Sumi</td>
                        <td>OT</td>
                        <td>2022-12-11&14:06:00</td>
                        <td>Sent</td>

                        <td>
                          <a class="btn btn-link" title="Show" href="{{ route('SessionMeetingSentShow',1) }}" style="background-color: darkturquoise;color:white;"><i class="fas fa-eye"></i></a>
                          <a class="btn btn-link" title="Reschedule" href="{{ route('SessionMeetingSentEdit',1) }}" style="background-color: crimson;color:white;"><i class="fas fa-pencil-alt"></i></a>
                        </td>
                      </tr>
                      <tr>
                        <td>39</td>
                        <td>EN/2022/12/025(Kaviya)</td>
                        <td>Weekly</td>
                        <!-- <td>-</td> -->
                        <td>Sumi</td>
                        <td>OT</td>
                        <td>2022-12-10&14:06:00</td>
                        <td>Sent</td>

                        <td>
                          <a class="btn btn-link" title="Show" href="{{ route('SessionMeetingSentShow',1) }}" style="background-color: darkturquoise;color:white;"><i class="fas fa-eye"></i></a>
                          <a class="btn btn-link" title="Reschedule" href="{{ route('SessionMeetingSentEdit',1) }}" style="background-color: crimson;color:white;"><i class="fas fa-pencil-alt"></i></a>
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



      <div class="row" id="saved" style="display:none;">
        <div class="col-12">
          <div class="card">
            <div class="card-body">
              <div class="row">

              </div>
              <div class="table-wrapper">
                <div class="table-responsive">
                  <table class="table table-bordered" id="align1">
                    <thead>

                      <th width="7%">Sl. No.</th>
                      <th width="15%">Enrollment Id</th>
                      <th width="10%">Type</th>
                      <th width="10%">Therapist</th>
                      <th width="12%">Specialization</th>
                      <th width="10%">Session Date & Time</th>
                      <th width="12%">Status</th>
                      <th width="13%">Action</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <td>1</td>
                        <td>EN/2022/12/025(Kaviya)</td>
                        <td>Weekly</td>
                        <!-- <td>-</td> -->
                        <td>Malini</td>
                        <td>Speech</td>
                        <td>2023-02-06&14:06:00</td>
                        <td>Sent</td>

                        <td>
                          <a class="btn btn-link" title="Show" href="{{ route('SessionMeetingSentShow',1) }}" style="background-color: darkturquoise;color:white;"><i class="fas fa-eye"></i></a>
                          <a class="btn btn-link" title="Reschedule" href="{{ route('SessionMeetingSentEdit',1) }}" style="background-color: crimson;color:white;"><i class="fas fa-pencil-alt"></i></a>
                        </td>
                      </tr>
                      <tr>
                        <td>2</td>
                        <td>EN/2022/12/025(Kaviya)</td>
                        <td>Weekly</td>
                        <!-- <td>-</td> -->
                        <td>Malini <br></td>
                        <td>Speech<br></td>
                        <td>2023-01-23&10:00:00<br></td>
                        <td>Saved</td>

                        <td>
                          <a type="button" onclick="send()" id="sendbutton" class="btn btn-labeled btn-succes" title="Sent" style="background-color:green !important;color:white !important;height: 32px;">Send</a>
                          <a class="btn btn-link" title="Show" href="{{ route('TherapistWeeklyShow',1) }}" style="background-color: darkturquoise;color:white;"><i class="fas fa-eye"></i></a>
                          <a class="btn btn-link edit" title="Edit" href="{{ route('TherapistWeeklyEdit','2') }}" style="background-color: crimson;margin-top: 7px !important;color:white;"><i class="fas fa-pencil-alt"></i></a>
                          <a class="btn btn-danger" type="submit" title="Delete" class="btn btn-link" style="color:navy;color:white;"><i class="far fa-trash-alt"></i></a>

                        </td>
                      </tr>
                      <tr>
                        <td>3</td>
                        <td>EN/2022/12/025(Kaviya)</td>
                        <td>Weekly</td>
                        <!-- <td>-</td> -->
                        <td>Malini <br></td>
                        <td>Speech<br></td>
                        <td>2023-01-30&10:00:00<br></td>
                        <td id="sent">Saved</td>

                        <td>
                          <a type="button" onclick="send()" id="sendbutton" class="btn btn-labeled btn-succes" title="Sent" style="background-color:green !important;color:white !important;height: 32px;">Send</a>
                          <a class="btn btn-link" title="Show" href="{{ route('TherapistWeeklyShow',1) }}" style="background-color: darkturquoise;color:white;"><i class="fas fa-eye"></i></a>
                          <a class="btn btn-link edit" title="Edit" href="{{ route('TherapistWeeklyEdit','2') }}" style="background-color: crimson;margin-top: 7px !important;color:white;"><i class="fas fa-pencil-alt"></i></a>
                          <a class="btn btn-danger" type="submit" title="Delete" class="btn btn-link" style="color:navy;color:white;"><i class="far fa-trash-alt"></i></a>

                        </td>
                      </tr>



                      <tr>
                        <td>4</td>
                        <td>EN/2022/12/025(Kaviya)</td>
                        <td>Weekly</td>
                        <!-- <td>-</td> -->
                        <td>Malini <br></td>
                        <td>Speech<br></td>
                        <td>2023-02-06&10:00:00<br></td>
                        <td id="sent">Saved</td>

                        <td>
                          <a type="button" onclick="send()" id="sendbutton" class="btn btn-labeled btn-succes" title="Sent" style="background-color:green !important;color:white !important;height: 32px;">Send</a>
                          <a class="btn btn-link" title="Show" href="{{ route('TherapistWeeklyShow',1) }}" style="background-color: darkturquoise;color:white;"><i class="fas fa-eye"></i></a>
                          <a class="btn btn-link edit" title="Edit" href="{{ route('TherapistWeeklyEdit','2') }}" style="background-color: crimson;margin-top: 7px !important;color:white;"><i class="fas fa-pencil-alt"></i></a>
                          <a class="btn btn-danger" type="submit" title="Delete" class="btn btn-link" style="color:navy;color:white;"><i class="far fa-trash-alt"></i></a>

                        </td>
                      </tr>

                      <tr>
                        <td>5</td>
                        <td>EN/2022/12/025(Kaviya)</td>
                        <td>Weekly</td>
                        <!-- <td>-</td> -->
                        <td>Malini <br></td>
                        <td>Speech<br></td>
                        <td>2023-02-13&10:00:00<br></td>
                        <td id="sent">Saved</td>

                        <td>
                          <a type="button" onclick="send()" id="sendbutton" class="btn btn-labeled btn-succes" title="Sent" style="background-color:green !important;color:white !important;height: 32px;">Send</a>
                          <a class="btn btn-link" title="Show" href="{{ route('TherapistWeeklyShow',1) }}" style="background-color: darkturquoise;color:white;"><i class="fas fa-eye"></i></a>
                          <a class="btn btn-link edit" title="Edit" href="{{ route('TherapistWeeklyEdit','2') }}" style="background-color: crimson;margin-top: 7px !important;color:white;"><i class="fas fa-pencil-alt"></i></a>
                          <a class="btn btn-danger" type="submit" title="Delete" class="btn btn-link" style="color:navy;color:white;"><i class="far fa-trash-alt"></i></a>

                        </td>
                      </tr>

                      <tr>
                        <td>6</td>
                        <td>EN/2022/12/025(Kaviya)</td>
                        <td>Weekly</td>
                        <!-- <td>-</td> -->
                        <td>Malini <br></td>
                        <td>Speech<br></td>
                        <td>2023-02-20&10:00:00<br></td>
                        <td id="sent">Saved</td>

                        <td>
                          <a type="button" onclick="send()" id="sendbutton" class="btn btn-labeled btn-succes" title="Sent" style="background-color:green !important;color:white !important;height: 32px;">Send</a>
                          <a class="btn btn-link" title="Show" href="{{ route('TherapistWeeklyShow',1) }}" style="background-color: darkturquoise;color:white;"><i class="fas fa-eye"></i></a>
                          <a class="btn btn-link edit" title="Edit" href="{{ route('TherapistWeeklyEdit','2') }}" style="background-color: crimson;margin-top: 7px !important;color:white;"><i class="fas fa-pencil-alt"></i></a>
                          <a class="btn btn-danger" type="submit" title="Delete" class="btn btn-link" style="color:navy;color:white;"><i class="far fa-trash-alt"></i></a>

                        </td>
                      </tr>

                      <tr>
                        <td>7</td>
                        <td>EN/2022/12/025(Kaviya)</td>
                        <td>Weekly</td>
                        <!-- <td>-</td> -->
                        <td>Malini <br></td>
                        <td>Speech<br></td>
                        <td>2023-02-27&10:00:00<br></td>
                        <td id="sent">Saved</td>

                        <td>
                          <a type="button" onclick="send()" id="sendbutton" class="btn btn-labeled btn-succes" title="Sent" style="background-color:green !important;color:white !important;height: 32px;">Send</a>
                          <a class="btn btn-link" title="Show" href="{{ route('TherapistWeeklyShow',1) }}" style="background-color: darkturquoise;color:white;"><i class="fas fa-eye"></i></a>
                          <a class="btn btn-link edit" title="Edit" href="{{ route('TherapistWeeklyEdit','2') }}" style="background-color: crimson;margin-top: 7px !important;color:white;"><i class="fas fa-pencil-alt"></i></a>
                          <a class="btn btn-danger" type="submit" title="Delete" class="btn btn-link" style="color:navy;color:white;"><i class="far fa-trash-alt"></i></a>

                        </td>
                      </tr>

                      <tr>
                        <td>8</td>
                        <td>EN/2022/12/025(Kaviya)</td>
                        <td>Weekly</td>
                        <!-- <td>-</td> -->
                        <td>Malini <br></td>
                        <td>Speech<br></td>
                        <td>2023-03-06&10:00:00<br></td>
                        <td id="sent">Saved</td>

                        <td>
                          <a type="button" onclick="send()" id="sendbutton" class="btn btn-labeled btn-succes" title="Sent" style="background-color:green !important;color:white !important;height: 32px;">Send</a>
                          <a class="btn btn-link" title="Show" href="{{ route('TherapistWeeklyShow',1) }}" style="background-color: darkturquoise;color:white;"><i class="fas fa-eye"></i></a>
                          <a class="btn btn-link edit" title="Edit" href="{{ route('TherapistWeeklyEdit','2') }}" style="background-color: crimson;margin-top: 7px !important;color:white;"><i class="fas fa-pencil-alt"></i></a>
                          <a class="btn btn-danger" type="submit" title="Delete" class="btn btn-link" style="color:navy;color:white;"><i class="far fa-trash-alt"></i></a>

                        </td>
                      </tr>

                      <tr>
                        <td>9</td>
                        <td>EN/2022/12/025(Kaviya)</td>
                        <td>Weekly</td>
                        <!-- <td>-</td> -->
                        <td>Malini <br></td>
                        <td>Speech<br></td>
                        <td>2023-03-13&10:00:00<br></td>
                        <td id="sent">Saved</td>

                        <td>
                          <a type="button" onclick="send()" id="sendbutton" class="btn btn-labeled btn-succes" title="Sent" style="background-color:green !important;color:white !important;height: 32px;">Send</a>
                          <a class="btn btn-link" title="Show" href="{{ route('TherapistWeeklyShow',1) }}" style="background-color: darkturquoise;color:white;"><i class="fas fa-eye"></i></a>
                          <a class="btn btn-link edit" title="Edit" href="{{ route('TherapistWeeklyEdit','2') }}" style="background-color: crimson;margin-top: 7px !important;color:white;"><i class="fas fa-pencil-alt"></i></a>
                          <a class="btn btn-danger" type="submit" title="Delete" class="btn btn-link" style="color:navy;color:white;"><i class="far fa-trash-alt"></i></a>

                        </td>
                      </tr>

                      <tr>
                        <td>10</td>
                        <td>EN/2022/12/025(Kaviya)</td>
                        <td>Weekly</td>
                        <!-- <td>-</td> -->
                        <td>Malini <br></td>
                        <td>Speech<br></td>
                        <td>2023-03-20&10:00:00<br></td>
                        <td id="sent">Saved</td>

                        <td>
                          <a type="button" onclick="send()" id="sendbutton" class="btn btn-labeled btn-succes" title="Sent" style="background-color:green !important;color:white !important;height: 32px;">Send</a>
                          <a class="btn btn-link" title="Show" href="{{ route('TherapistWeeklyShow',1) }}" style="background-color: darkturquoise;color:white;"><i class="fas fa-eye"></i></a>
                          <a class="btn btn-link edit" title="Edit" href="{{ route('TherapistWeeklyEdit','2') }}" style="background-color: crimson;margin-top: 7px !important;color:white;"><i class="fas fa-pencil-alt"></i></a>
                          <a class="btn btn-danger" type="submit" title="Delete" class="btn btn-link" style="color:navy;color:white;"><i class="far fa-trash-alt"></i></a>

                        </td>
                      </tr>

                      <tr>
                        <td>11</td>
                        <td>EN/2022/12/025(Kaviya)</td>
                        <td>Weekly</td>
                        <!-- <td>-</td> -->
                        <td>Malini <br></td>
                        <td>Speech<br></td>
                        <td>2023-02-20&10:00:00<br></td>
                        <td id="sent">Saved</td>

                        <td>
                          <a type="button" onclick="send()" id="sendbutton" class="btn btn-labeled btn-succes" title="Sent" style="background-color:green !important;color:white !important;height: 32px;">Send</a>
                          <a class="btn btn-link" title="Show" href="{{ route('TherapistWeeklyShow',1) }}" style="background-color: darkturquoise;color:white;"><i class="fas fa-eye"></i></a>
                          <a class="btn btn-link edit" title="Edit" href="{{ route('TherapistWeeklyEdit','2') }}" style="background-color: crimson;margin-top: 7px !important;color:white;"><i class="fas fa-pencil-alt"></i></a>
                          <a class="btn btn-danger" type="submit" title="Delete" class="btn btn-link" style="color:navy;color:white;"><i class="far fa-trash-alt"></i></a>

                        </td>
                      </tr>

                      <tr>
                        <td>12</td>
                        <td>EN/2022/12/025(Kaviya)</td>
                        <td>Weekly</td>
                        <!-- <td>-</td> -->
                        <td>Malini <br></td>
                        <td>Speech<br></td>
                        <td>2023-03-27&10:00:00<br></td>
                        <td id="sent">Saved</td>

                        <td>
                          <a type="button" onclick="send()" id="sendbutton" class="btn btn-labeled btn-succes" title="Sent" style="background-color:green !important;color:white !important;height: 32px;">Send</a>
                          <a class="btn btn-link" title="Show" href="{{ route('TherapistWeeklyShow',1) }}" style="background-color: darkturquoise;color:white;"><i class="fas fa-eye"></i></a>
                          <a class="btn btn-link edit" title="Edit" href="{{ route('TherapistWeeklyEdit','2') }}" style="background-color: crimson;margin-top: 7px !important;color:white;"><i class="fas fa-pencil-alt"></i></a>
                          <a class="btn btn-danger" type="submit" title="Delete" class="btn btn-link" style="color:navy;color:white;"><i class="far fa-trash-alt"></i></a>

                        </td>
                      </tr>



                      <tr>
                        <td>13</td>
                        <td>EN/2022/12/025(Kaviya)</td>
                        <td>Weekly</td>
                        <!-- <td>-</td> -->
                        <td>Malini <br></td>
                        <td>Speech<br></td>
                        <td>2023-04-03&10:00:00<br></td>
                        <td id="sent">Saved</td>

                        <td>
                          <a type="button" onclick="send()" id="sendbutton" class="btn btn-labeled btn-succes" title="Sent" style="background-color:green !important;color:white !important;height: 32px;">Send</a>
                          <a class="btn btn-link" title="Show" href="{{ route('TherapistWeeklyShow',1) }}" style="background-color: darkturquoise;color:white;"><i class="fas fa-eye"></i></a>
                          <a class="btn btn-link edit" title="Edit" href="{{ route('TherapistWeeklyEdit','2') }}" style="background-color: crimson;margin-top: 7px !important;color:white;"><i class="fas fa-pencil-alt"></i></a>
                          <a class="btn btn-danger" type="submit" title="Delete" class="btn btn-link" style="color:navy;color:white;"><i class="far fa-trash-alt"></i></a>

                        </td>
                      </tr>

                      <tr>
                        <td>14</td>
                        <td>EN/2022/12/025(Kaviya)</td>
                        <td>Weekly</td>
                        <!-- <td>-</td> -->
                        <td>Malini <br></td>
                        <td>Speech<br></td>
                        <td>2023-04-10&10:00:00<br></td>
                        <td id="sent">Saved</td>

                        <td>
                          <a type="button" onclick="send()" id="sendbutton" class="btn btn-labeled btn-succes" title="Sent" style="background-color:green !important;color:white !important;height: 32px;">Send</a>
                          <a class="btn btn-link" title="Show" href="{{ route('TherapistWeeklyShow',1) }}" style="background-color: darkturquoise;color:white;"><i class="fas fa-eye"></i></a>
                          <a class="btn btn-link edit" title="Edit" href="{{ route('TherapistWeeklyEdit','2') }}" style="background-color: crimson;margin-top: 7px !important;color:white;"><i class="fas fa-pencil-alt"></i></a>
                          <a class="btn btn-danger" type="submit" title="Delete" class="btn btn-link" style="color:navy;color:white;"><i class="far fa-trash-alt"></i></a>

                        </td>
                      </tr>

                      <tr>
                        <td>15</td>
                        <td>EN/2022/12/025(Kaviya)</td>
                        <td>Weekly</td>
                        <!-- <td>-</td> -->
                        <td>Malini <br></td>
                        <td>Speech<br></td>
                        <td>2023-04-17&10:00:00<br></td>
                        <td id="sent">Saved</td>

                        <td>
                          <a type="button" onclick="send()" id="sendbutton" class="btn btn-labeled btn-succes" title="Sent" style="background-color:green !important;color:white !important;height: 32px;">Send</a>
                          <a class="btn btn-link" title="Show" href="{{ route('TherapistWeeklyShow',1) }}" style="background-color: darkturquoise;color:white;"><i class="fas fa-eye"></i></a>
                          <a class="btn btn-link edit" title="Edit" href="{{ route('TherapistWeeklyEdit','2') }}" style="background-color: crimson;margin-top: 7px !important;color:white;"><i class="fas fa-pencil-alt"></i></a>
                          <a class="btn btn-danger" type="submit" title="Delete" class="btn btn-link" style="color:navy;color:white;"><i class="far fa-trash-alt"></i></a>

                        </td>
                      </tr>

                      <tr>
                        <td>16</td>
                        <td>EN/2022/12/025(Kaviya)</td>
                        <td>Weekly</td>
                        <!-- <td>-</td> -->
                        <td>Malini <br></td>
                        <td>Speech<br></td>
                        <td>2023-04-24&10:00:00<br></td>
                        <td id="sent">Saved</td>

                        <td>
                          <a type="button" onclick="send()" id="sendbutton" class="btn btn-labeled btn-succes" title="Sent" style="background-color:green !important;color:white !important;height: 32px;">Send</a>
                          <a class="btn btn-link" title="Show" href="{{ route('TherapistWeeklyShow',1) }}" style="background-color: darkturquoise;color:white;"><i class="fas fa-eye"></i></a>
                          <a class="btn btn-link edit" title="Edit" href="{{ route('TherapistWeeklyEdit','2') }}" style="background-color: crimson;margin-top: 7px !important;color:white;"><i class="fas fa-pencil-alt"></i></a>
                          <a class="btn btn-danger" type="submit" title="Delete" class="btn btn-link" style="color:navy;color:white;"><i class="far fa-trash-alt"></i></a>

                        </td>
                      </tr>

                      <tr>
                        <td>17</td>
                        <td>EN/2022/12/025(Kaviya)</td>
                        <td>Weekly</td>
                        <!-- <td>-</td> -->
                        <td>Malini <br></td>
                        <td>Speech<br></td>
                        <td>2023-05-01&10:00:00<br></td>
                        <td id="sent">Saved</td>

                        <td>
                          <a type="button" onclick="send()" id="sendbutton" class="btn btn-labeled btn-succes" title="Sent" style="background-color:green !important;color:white !important;height: 32px;">Send</a>
                          <a class="btn btn-link" title="Show" href="{{ route('TherapistWeeklyShow',1) }}" style="background-color: darkturquoise;color:white;"><i class="fas fa-eye"></i></a>
                          <a class="btn btn-link edit" title="Edit" href="{{ route('TherapistWeeklyEdit','2') }}" style="background-color: crimson;margin-top: 7px !important;color:white;"><i class="fas fa-pencil-alt"></i></a>
                          <a class="btn btn-danger" type="submit" title="Delete" class="btn btn-link" style="color:navy;color:white;"><i class="far fa-trash-alt"></i></a>

                        </td>
                      </tr>

                      <tr>
                        <td>18</td>
                        <td>EN/2022/12/025(Kaviya)</td>
                        <td>Weekly</td>
                        <!-- <td>-</td> -->
                        <td>Malini <br></td>
                        <td>Speech<br></td>
                        <td>2023-05-08&10:00:00<br></td>
                        <td id="sent">Saved</td>

                        <td>
                          <a type="button" onclick="send()" id="sendbutton" class="btn btn-labeled btn-succes" title="Sent" style="background-color:green !important;color:white !important;height: 32px;">Send</a>
                          <a class="btn btn-link" title="Show" href="{{ route('TherapistWeeklyShow',1) }}" style="background-color: darkturquoise;color:white;"><i class="fas fa-eye"></i></a>
                          <a class="btn btn-link edit" title="Edit" href="{{ route('TherapistWeeklyEdit','2') }}" style="background-color: crimson;margin-top: 7px !important;color:white;"><i class="fas fa-pencil-alt"></i></a>
                          <a class="btn btn-danger" type="submit" title="Delete" class="btn btn-link" style="color:navy;color:white;"><i class="far fa-trash-alt"></i></a>

                        </td>
                      </tr>

                      <tr>
                        <td>19</td>
                        <td>EN/2022/12/025(Kaviya)</td>
                        <td>Weekly</td>
                        <!-- <td>-</td> -->
                        <td>Malini <br></td>
                        <td>Speech<br></td>
                        <td>2023-05-15&10:00:00<br></td>
                        <td id="sent">Saved</td>

                        <td>
                          <a type="button" onclick="send()" id="sendbutton" class="btn btn-labeled btn-succes" title="Sent" style="background-color:green !important;color:white !important;height: 32px;">Send</a>
                          <a class="btn btn-link" title="Show" href="{{ route('TherapistWeeklyShow',1) }}" style="background-color: darkturquoise;color:white;"><i class="fas fa-eye"></i></a>
                          <a class="btn btn-link edit" title="Edit" href="{{ route('TherapistWeeklyEdit','2') }}" style="background-color: crimson;margin-top: 7px !important;color:white;"><i class="fas fa-pencil-alt"></i></a>
                          <a class="btn btn-danger" type="submit" title="Delete" class="btn btn-link" style="color:navy;color:white;"><i class="far fa-trash-alt"></i></a>

                        </td>
                      </tr>

                      <tr>
                        <td>20</td>
                        <td>EN/2022/12/025(Kaviya)</td>
                        <td>Weekly</td>
                        <!-- <td>-</td> -->
                        <td>Malini <br></td>
                        <td>Speech<br></td>
                        <td>2023-05-22&10:00:00<br></td>
                        <td id="sent">Saved</td>

                        <td>
                          <a type="button" onclick="send()" id="sendbutton" class="btn btn-labeled btn-succes" title="Sent" style="background-color:green !important;color:white !important;height: 32px;">Send</a>
                          <a class="btn btn-link" title="Show" href="{{ route('TherapistWeeklyShow',1) }}" style="background-color: darkturquoise;color:white;"><i class="fas fa-eye"></i></a>
                          <a class="btn btn-link edit" title="Edit" href="{{ route('TherapistWeeklyEdit','2') }}" style="background-color: crimson;margin-top: 7px !important;color:white;"><i class="fas fa-pencil-alt"></i></a>
                          <a class="btn btn-danger" type="submit" title="Delete" class="btn btn-link" style="color:navy;color:white;"><i class="far fa-trash-alt"></i></a>

                        </td>
                      </tr>

                      <tr>
                        <td>21</td>
                        <td>EN/2022/12/025(Kaviya)</td>
                        <td>Weekly</td>
                        <!-- <td>-</td> -->
                        <td>Malini <br></td>
                        <td>Speech<br></td>
                        <td>2023-05-29&10:00:00<br></td>
                        <td id="sent">Saved</td>

                        <td>
                          <a type="button" onclick="send()" id="sendbutton" class="btn btn-labeled btn-succes" title="Sent" style="background-color:green !important;color:white !important;height: 32px;">Send</a>
                          <a class="btn btn-link" title="Show" href="{{ route('TherapistWeeklyShow',1) }}" style="background-color: darkturquoise;color:white;"><i class="fas fa-eye"></i></a>
                          <a class="btn btn-link edit" title="Edit" href="{{ route('TherapistWeeklyEdit','2') }}" style="background-color: crimson;margin-top: 7px !important;color:white;"><i class="fas fa-pencil-alt"></i></a>
                          <a class="btn btn-danger" type="submit" title="Delete" class="btn btn-link" style="color:navy;color:white;"><i class="far fa-trash-alt"></i></a>

                        </td>
                      </tr>

                      <tr>
                        <td>22</td>
                        <td>EN/2022/12/025(Kaviya)</td>
                        <td>Weekly</td>
                        <!-- <td>-</td> -->
                        <td>Malini <br></td>
                        <td>Speech<br></td>
                        <td>2023-06-05&10:00:00<br></td>
                        <td id="sent">Saved</td>

                        <td>
                          <a type="button" onclick="send()" id="sendbutton" class="btn btn-labeled btn-succes" title="Sent" style="background-color:green !important;color:white !important;height: 32px;">Send</a>
                          <a class="btn btn-link" title="Show" href="{{ route('TherapistWeeklyShow',1) }}" style="background-color: darkturquoise;color:white;"><i class="fas fa-eye"></i></a>
                          <a class="btn btn-link edit" title="Edit" href="{{ route('TherapistWeeklyEdit','2') }}" style="background-color: crimson;margin-top: 7px !important;color:white;"><i class="fas fa-pencil-alt"></i></a>
                          <a class="btn btn-danger" type="submit" title="Delete" class="btn btn-link" style="color:navy;color:white;"><i class="far fa-trash-alt"></i></a>

                        </td>
                      </tr>

                      <tr>
                        <td>23</td>
                        <td>EN/2022/12/025(Kaviya)</td>
                        <td>Weekly</td>
                        <!-- <td>-</td> -->
                        <td>Malini <br></td>
                        <td>Speech<br></td>
                        <td>2023-06-12&10:00:00<br></td>
                        <td id="sent">Saved</td>

                        <td>
                          <a type="button" onclick="send()" id="sendbutton" class="btn btn-labeled btn-succes" title="Sent" style="background-color:green !important;color:white !important;height: 32px;">Send</a>
                          <a class="btn btn-link" title="Show" href="{{ route('TherapistWeeklyShow',1) }}" style="background-color: darkturquoise;color:white;"><i class="fas fa-eye"></i></a>
                          <a class="btn btn-link edit" title="Edit" href="{{ route('TherapistWeeklyEdit','2') }}" style="background-color: crimson;margin-top: 7px !important;color:white;"><i class="fas fa-pencil-alt"></i></a>
                          <a class="btn btn-danger" type="submit" title="Delete" class="btn btn-link" style="color:navy;color:white;"><i class="far fa-trash-alt"></i></a>

                        </td>
                      </tr>

                      <tr>
                        <td>24</td>
                        <td>EN/2022/12/025(Kaviya)</td>
                        <td>Weekly</td>
                        <!-- <td>-</td> -->
                        <td>Malini <br></td>
                        <td>Speech<br></td>
                        <td>2023-06-12&10:00:00<br></td>
                        <td id="sent">Saved</td>

                        <td>
                          <a type="button" onclick="send()" id="sendbutton" class="btn btn-labeled btn-succes" title="Sent" style="background-color:green !important;color:white !important;height: 32px;">Send</a>
                          <a class="btn btn-link" title="Show" href="{{ route('TherapistWeeklyShow',1) }}" style="background-color: darkturquoise;color:white;"><i class="fas fa-eye"></i></a>
                          <a class="btn btn-link edit" title="Edit" href="{{ route('TherapistWeeklyEdit','2') }}" style="background-color: crimson;margin-top: 7px !important;color:white;"><i class="fas fa-pencil-alt"></i></a>
                          <a class="btn btn-danger" type="submit" title="Delete" class="btn btn-link" style="color:navy;color:white;"><i class="far fa-trash-alt"></i></a>

                        </td>
                      </tr>


                      <tr>
                        <td>25</td>
                        <td>EN/2022/12/025(Kaviya)</td>
                        <td>Weekly</td>
                        <!-- <td>-</td> -->
                        <td>Malini <br></td>
                        <td>Speech<br></td>
                        <td>2023-06-19&10:00:00<br></td>
                        <td id="sent">Saved</td>

                        <td>
                          <a type="button" onclick="send()" id="sendbutton" class="btn btn-labeled btn-succes" title="Sent" style="background-color:green !important;color:white !important;height: 32px;">Send</a>
                          <a class="btn btn-link" title="Show" href="{{ route('TherapistWeeklyShow',1) }}" style="background-color: darkturquoise;color:white;"><i class="fas fa-eye"></i></a>
                          <a class="btn btn-link edit" title="Edit" href="{{ route('TherapistWeeklyEdit','2') }}" style="background-color: crimson;margin-top: 7px !important;color:white;"><i class="fas fa-pencil-alt"></i></a>
                          <a class="btn btn-danger" type="submit" title="Delete" class="btn btn-link" style="color:navy;color:white;"><i class="far fa-trash-alt"></i></a>

                        </td>
                      </tr>

                      <tr>
                        <td>26</td>
                        <td>EN/2022/12/025(Kaviya)</td>
                        <td>Weekly</td>
                        <!-- <td>-</td> -->
                        <td>Malini <br></td>
                        <td>Speech<br></td>
                        <td>2023-06-19&10:00:00<br></td>
                        <td id="sent">Saved</td>

                        <td>
                          <a type="button" onclick="send()" id="sendbutton" class="btn btn-labeled btn-succes" title="Sent" style="background-color:green !important;color:white !important;height: 32px;">Send</a>
                          <a class="btn btn-link" title="Show" href="{{ route('TherapistWeeklyShow',1) }}" style="background-color: darkturquoise;color:white;"><i class="fas fa-eye"></i></a>
                          <a class="btn btn-link edit" title="Edit" href="{{ route('TherapistWeeklyEdit','2') }}" style="background-color: crimson;margin-top: 7px !important;color:white;"><i class="fas fa-pencil-alt"></i></a>
                          <a class="btn btn-danger" type="submit" title="Delete" class="btn btn-link" style="color:navy;color:white;"><i class="far fa-trash-alt"></i></a>

                        </td>
                      </tr>

                      <tr>
                        <td>27</td>
                        <td>EN/2022/12/025(Kaviya)</td>
                        <td>Weekly</td>
                        <!-- <td>-</td> -->
                        <td>Malini <br></td>
                        <td>Speech<br></td>
                        <td>2023-06-26&10:00:00<br></td>
                        <td id="sent">Saved</td>

                        <td>
                          <a type="button" onclick="send()" id="sendbutton" class="btn btn-labeled btn-succes" title="Sent" style="background-color:green !important;color:white !important;height: 32px;">Send</a>
                          <a class="btn btn-link" title="Show" href="{{ route('TherapistWeeklyShow',1) }}" style="background-color: darkturquoise;color:white;"><i class="fas fa-eye"></i></a>
                          <a class="btn btn-link edit" title="Edit" href="{{ route('TherapistWeeklyEdit','2') }}" style="background-color: crimson;margin-top: 7px !important;color:white;"><i class="fas fa-pencil-alt"></i></a>
                          <a class="btn btn-danger" type="submit" title="Delete" class="btn btn-link" style="color:navy;color:white;"><i class="far fa-trash-alt"></i></a>

                        </td>
                      </tr>

                      <tr>
                        <td>28</td>
                        <td>EN/2022/12/025(Kaviya)</td>
                        <td>Weekly</td>
                        <!-- <td>-</td> -->
                        <td>Malini <br></td>
                        <td>Speech<br></td>
                        <td>2023-07-03&10:00:00<br></td>
                        <td id="sent">Saved</td>

                        <td>
                          <a type="button" onclick="send()" id="sendbutton" class="btn btn-labeled btn-succes" title="Sent" style="background-color:green !important;color:white !important;height: 32px;">Send</a>
                          <a class="btn btn-link" title="Show" href="{{ route('TherapistWeeklyShow',1) }}" style="background-color: darkturquoise;color:white;"><i class="fas fa-eye"></i></a>
                          <a class="btn btn-link edit" title="Edit" href="{{ route('TherapistWeeklyEdit','2') }}" style="background-color: crimson;margin-top: 7px !important;color:white;"><i class="fas fa-pencil-alt"></i></a>
                          <a class="btn btn-danger" type="submit" title="Delete" class="btn btn-link" style="color:navy;color:white;"><i class="far fa-trash-alt"></i></a>

                        </td>
                      </tr>

                      <tr>
                        <td>29</td>
                        <td>EN/2022/12/025(Kaviya)</td>
                        <td>Weekly</td>
                        <!-- <td>-</td> -->
                        <td>Malini <br></td>
                        <td>Speech<br></td>
                        <td>2023-07-10&10:00:00<br></td>
                        <td id="sent">Saved</td>

                        <td>
                          <a type="button" onclick="send()" id="sendbutton" class="btn btn-labeled btn-succes" title="Sent" style="background-color:green !important;color:white !important;height: 32px;">Send</a>
                          <a class="btn btn-link" title="Show" href="{{ route('TherapistWeeklyShow',1) }}" style="background-color: darkturquoise;color:white;"><i class="fas fa-eye"></i></a>
                          <a class="btn btn-link edit" title="Edit" href="{{ route('TherapistWeeklyEdit','2') }}" style="background-color: crimson;margin-top: 7px !important;color:white;"><i class="fas fa-pencil-alt"></i></a>
                          <a class="btn btn-danger" type="submit" title="Delete" class="btn btn-link" style="color:navy;color:white;"><i class="far fa-trash-alt"></i></a>

                        </td>
                      </tr>

                      <tr>
                        <td>30</td>
                        <td>EN/2022/12/025(Kaviya)</td>
                        <td>Weekly</td>
                        <!-- <td>-</td> -->
                        <td>Malini <br></td>
                        <td>Speech<br></td>
                        <td>2023-07-17&10:00:00<br></td>
                        <td id="sent">Saved</td>

                        <td>
                          <a type="button" onclick="send()" id="sendbutton" class="btn btn-labeled btn-succes" title="Sent" style="background-color:green !important;color:white !important;height: 32px;">Send</a>
                          <a class="btn btn-link" title="Show" href="{{ route('TherapistWeeklyShow',1) }}" style="background-color: darkturquoise;color:white;"><i class="fas fa-eye"></i></a>
                          <a class="btn btn-link edit" title="Edit" href="{{ route('TherapistWeeklyEdit','2') }}" style="background-color: crimson;margin-top: 7px !important;color:white;"><i class="fas fa-pencil-alt"></i></a>
                          <a class="btn btn-danger" type="submit" title="Delete" class="btn btn-link" style="color:navy;color:white;"><i class="far fa-trash-alt"></i></a>

                        </td>
                      </tr>

                      <tr>
                        <td>31</td>
                        <td>EN/2022/12/025(Kaviya)</td>
                        <td>Weekly</td>
                        <!-- <td>-</td> -->
                        <td>Malini <br></td>
                        <td>Speech<br></td>
                        <td>2023-07-24&10:00:00<br></td>
                        <td id="sent">Saved</td>

                        <td>
                          <a type="button" onclick="send()" id="sendbutton" class="btn btn-labeled btn-succes" title="Sent" style="background-color:green !important;color:white !important;height: 32px;">Send</a>
                          <a class="btn btn-link" title="Show" href="{{ route('TherapistWeeklyShow',1) }}" style="background-color: darkturquoise;color:white;"><i class="fas fa-eye"></i></a>
                          <a class="btn btn-link edit" title="Edit" href="{{ route('TherapistWeeklyEdit','2') }}" style="background-color: crimson;margin-top: 7px !important;color:white;"><i class="fas fa-pencil-alt"></i></a>
                          <a class="btn btn-danger" type="submit" title="Delete" class="btn btn-link" style="color:navy;color:white;"><i class="far fa-trash-alt"></i></a>

                        </td>
                      </tr>

                      <tr>
                        <td>32</td>
                        <td>EN/2022/12/025(Kaviya)</td>
                        <td>Weekly</td>
                        <!-- <td>-</td> -->
                        <td>Malini <br></td>
                        <td>Speech<br></td>
                        <td>2023-07-31&10:00:00<br></td>
                        <td id="sent">Saved</td>

                        <td>
                          <a type="button" onclick="send()" id="sendbutton" class="btn btn-labeled btn-succes" title="Sent" style="background-color:green !important;color:white !important;height: 32px;">Send</a>
                          <a class="btn btn-link" title="Show" href="{{ route('TherapistWeeklyShow',1) }}" style="background-color: darkturquoise;color:white;"><i class="fas fa-eye"></i></a>
                          <a class="btn btn-link edit" title="Edit" href="{{ route('TherapistWeeklyEdit','2') }}" style="background-color: crimson;margin-top: 7px !important;color:white;"><i class="fas fa-pencil-alt"></i></a>
                          <a class="btn btn-danger" type="submit" title="Delete" class="btn btn-link" style="color:navy;color:white;"><i class="far fa-trash-alt"></i></a>

                        </td>
                      </tr>

                      <tr>
                        <td>33</td>
                        <td>EN/2022/12/025(Kaviya)</td>
                        <td>Weekly</td>
                        <!-- <td>-</td> -->
                        <td>Malini <br></td>
                        <td>Speech<br></td>
                        <td>2023-08-07&10:00:00<br></td>
                        <td id="sent">Saved</td>

                        <td>
                          <a type="button" onclick="send()" id="sendbutton" class="btn btn-labeled btn-succes" title="Sent" style="background-color:green !important;color:white !important;height: 32px;">Send</a>
                          <a class="btn btn-link" title="Show" href="{{ route('TherapistWeeklyShow',1) }}" style="background-color: darkturquoise;color:white;"><i class="fas fa-eye"></i></a>
                          <a class="btn btn-link edit" title="Edit" href="{{ route('TherapistWeeklyEdit','2') }}" style="background-color: crimson;margin-top: 7px !important;color:white;"><i class="fas fa-pencil-alt"></i></a>
                          <a class="btn btn-danger" type="submit" title="Delete" class="btn btn-link" style="color:navy;color:white;"><i class="far fa-trash-alt"></i></a>

                        </td>
                      </tr>

                      <tr>
                        <td>34</td>
                        <td>EN/2022/12/025(Kaviya)</td>
                        <td>Weekly</td>
                        <!-- <td>-</td> -->
                        <td>Malini <br></td>
                        <td>Speech<br></td>
                        <td>2023-08-14&10:00:00<br></td>
                        <td id="sent">Saved</td>

                        <td>
                          <a type="button" onclick="send()" id="sendbutton" class="btn btn-labeled btn-succes" title="Sent" style="background-color:green !important;color:white !important;height: 32px;">Send</a>
                          <a class="btn btn-link" title="Show" href="{{ route('TherapistWeeklyShow',1) }}" style="background-color: darkturquoise;color:white;"><i class="fas fa-eye"></i></a>
                          <a class="btn btn-link edit" title="Edit" href="{{ route('TherapistWeeklyEdit','2') }}" style="background-color: crimson;margin-top: 7px !important;color:white;"><i class="fas fa-pencil-alt"></i></a>
                          <a class="btn btn-danger" type="submit" title="Delete" class="btn btn-link" style="color:navy;color:white;"><i class="far fa-trash-alt"></i></a>

                        </td>
                      </tr>

                      <tr>
                        <td>35</td>
                        <td>EN/2022/12/025(Kaviya)</td>
                        <td>Weekly</td>
                        <!-- <td>-</td> -->
                        <td>Malini <br></td>
                        <td>Speech<br></td>
                        <td>2023-08-21&10:00:00<br></td>
                        <td id="sent">Saved</td>

                        <td>
                          <a type="button" onclick="send()" id="sendbutton" class="btn btn-labeled btn-succes" title="Sent" style="background-color:green !important;color:white !important;height: 32px;">Send</a>
                          <a class="btn btn-link" title="Show" href="{{ route('TherapistWeeklyShow',1) }}" style="background-color: darkturquoise;color:white;"><i class="fas fa-eye"></i></a>
                          <a class="btn btn-link edit" title="Edit" href="{{ route('TherapistWeeklyEdit','2') }}" style="background-color: crimson;margin-top: 7px !important;color:white;"><i class="fas fa-pencil-alt"></i></a>
                          <a class="btn btn-danger" type="submit" title="Delete" class="btn btn-link" style="color:navy;color:white;"><i class="far fa-trash-alt"></i></a>

                        </td>
                      </tr>
                      <tr>
                        <td>36</td>
                        <td>EN/2022/12/025(Kaviya)</td>
                        <td>Weekly</td>
                        <!-- <td>-</td> -->
                        <td>Malini <br></td>
                        <td>Speech<br></td>
                        <td>2023-08-27&10:00:00<br></td>
                        <td id="sent">Saved</td>

                        <td>
                          <a type="button" onclick="send()" id="sendbutton" class="btn btn-labeled btn-succes" title="Sent" style="background-color:green !important;color:white !important;height: 32px;">Send</a>
                          <a class="btn btn-link" title="Show" href="{{ route('TherapistWeeklyShow',1) }}" style="background-color: darkturquoise;color:white;"><i class="fas fa-eye"></i></a>
                          <a class="btn btn-link edit" title="Edit" href="{{ route('TherapistWeeklyEdit','2') }}" style="background-color: crimson;margin-top: 7px !important;color:white;"><i class="fas fa-pencil-alt"></i></a>
                          <a class="btn btn-danger" type="submit" title="Delete" class="btn btn-link" style="color:navy;color:white;"><i class="far fa-trash-alt"></i></a>

                        </td>
                      </tr>



                      <tr>
                        <td>37</td>
                        <td>EN/2022/12/025(Kaviya)</td>
                        <td>Weekly</td>
                        <!-- <td>-</td> -->
                        <td>Sumi</td>
                        <td>OT</td>
                        <td>2022-12-10&14:06:00</td>
                        <td id="sent">Saved</td>

                        <td>
                          <a type="button" onclick="send()" id="send" class="btn btn-labeled btn-succes" title="Sent" style="background-color:green !important;color:white !important;height: 32px;">Send</a>
                          <a class="btn btn-link" title="Show" href="{{ route('TherapistWeeklyShow',1) }}" style="background-color: darkturquoise;color:white;"><i class="fas fa-eye"></i></a>
                          <a class="btn btn-link " title="Edit" href="{{ route('TherapistWeeklyEdit','2') }}" style="background-color: crimson;margin-top: 7px !important;color:white;"><i class="fas fa-pencil-alt"></i></a>
                          <a class="btn btn-danger" type="submit" title="Delete" class="btn btn-link" style="color:navy;color:white;"><i class="far fa-trash-alt"></i></a>

                        </td>
                      </tr>



                      <tr>
                        <td>38</td>
                        <td>EN/2022/12/025(Kaviya)</td>
                        <td>Weekly</td>
                        <!-- <td>-</td> -->
                        <td>Sumi</td>
                        <td>OT</td>
                        <td>2022-12-11&14:06:00</td>
                        <td>Sent</td>

                        <td>
                          <a class="btn btn-link" title="Show" href="{{ route('SessionMeetingSentShow',1) }}" style="background-color: darkturquoise;color:white;"><i class="fas fa-eye"></i></a>
                          <a class="btn btn-link" title="Reschedule" href="{{ route('SessionMeetingSentEdit',1) }}" style="background-color: crimson;color:white;"><i class="fas fa-pencil-alt"></i></a>
                        </td>
                      </tr>
                      <tr>
                        <td>39</td>
                        <td>EN/2022/12/025(Kaviya)</td>
                        <td>Weekly</td>
                        <!-- <td>-</td> -->
                        <td>Sumi</td>
                        <td>OT</td>
                        <td>2022-12-10&14:06:00</td>
                        <td>Sent</td>

                        <td>
                          <a class="btn btn-link" title="Show" href="{{ route('SessionMeetingSentShow',1) }}" style="background-color: darkturquoise;color:white;"><i class="fas fa-eye"></i></a>
                          <a class="btn btn-link" title="Reschedule" href="{{ route('SessionMeetingSentEdit',1) }}" style="background-color: crimson;color:white;"><i class="fas fa-pencil-alt"></i></a>
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

      <div class="row" id="invite" style="display: none !important;">
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
                      <th width="10%">Therapist</th>
                      <th width="12%">Specialization</th>
                      <th width="10%">Session Date & Time</th>
                      <th width="12%">Status</th>
                      <th width="13%">Action</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <td>1</td>
                        <td>EN/2022/12/025(Kaviya)</td>
                        <td>Weekly</td>
                        <!-- <td>-</td> -->
                        <td>Malini</td>
                        <td>Speech</td>
                        <td>2023-02-06&14:06:00</td>
                        <td>Sent</td>

                        <td>
                          <a class="btn btn-link" title="Show" href="{{ route('SessionMeetingSentShow',1) }}" style="background-color: darkturquoise;color:white;"><i class="fas fa-eye"></i></a>
                          <a class="btn btn-link" title="Reschedule" href="{{ route('SessionMeetingSentEdit',1) }}" style="background-color: crimson;color:white;"><i class="fas fa-pencil-alt"></i></a>
                        </td>
                      </tr>
                      <tr>
                        <td>2</td>
                        <td>EN/2022/12/025(Kaviya)</td>
                        <td>Weekly</td>
                        <!-- <td>-</td> -->
                        <td>Malini <br></td>
                        <td>Speech<br></td>
                        <td>2023-01-23&10:00:00<br></td>
                        <td>Saved</td>

                        <td>
                          <a type="button" onclick="send()" id="sendbutton" class="btn btn-labeled btn-succes" title="Sent" style="background-color:green !important;color:white !important;height: 32px;">Send</a>
                          <a class="btn btn-link" title="Show" href="{{ route('TherapistWeeklyShow',1) }}" style="background-color: darkturquoise;color:white;"><i class="fas fa-eye"></i></a>
                          <a class="btn btn-link edit" title="Edit" href="{{ route('TherapistWeeklyEdit','2') }}" style="background-color: crimson;margin-top: 7px !important;color:white;"><i class="fas fa-pencil-alt"></i></a>
                          <a class="btn btn-danger" type="submit" title="Delete" class="btn btn-link" style="color:navy;color:white;"><i class="far fa-trash-alt"></i></a>

                        </td>
                      </tr>
                      <tr>
                        <td>3</td>
                        <td>EN/2022/12/025(Kaviya)</td>
                        <td>Weekly</td>
                        <!-- <td>-</td> -->
                        <td>Malini <br></td>
                        <td>Speech<br></td>
                        <td>2023-01-30&10:00:00<br></td>
                        <td id="sent">Saved</td>

                        <td>
                          <a type="button" onclick="send()" id="sendbutton" class="btn btn-labeled btn-succes" title="Sent" style="background-color:green !important;color:white !important;height: 32px;">Send</a>
                          <a class="btn btn-link" title="Show" href="{{ route('TherapistWeeklyShow',1) }}" style="background-color: darkturquoise;color:white;"><i class="fas fa-eye"></i></a>
                          <a class="btn btn-link edit" title="Edit" href="{{ route('TherapistWeeklyEdit','2') }}" style="background-color: crimson;margin-top: 7px !important;color:white;"><i class="fas fa-pencil-alt"></i></a>
                          <a class="btn btn-danger" type="submit" title="Delete" class="btn btn-link" style="color:navy;color:white;"><i class="far fa-trash-alt"></i></a>

                        </td>
                      </tr>



                      <tr>
                        <td>4</td>
                        <td>EN/2022/12/025(Kaviya)</td>
                        <td>Weekly</td>
                        <!-- <td>-</td> -->
                        <td>Malini <br></td>
                        <td>Speech<br></td>
                        <td>2023-02-06&10:00:00<br></td>
                        <td id="sent">Saved</td>

                        <td>
                          <a type="button" onclick="send()" id="sendbutton" class="btn btn-labeled btn-succes" title="Sent" style="background-color:green !important;color:white !important;height: 32px;">Send</a>
                          <a class="btn btn-link" title="Show" href="{{ route('TherapistWeeklyShow',1) }}" style="background-color: darkturquoise;color:white;"><i class="fas fa-eye"></i></a>
                          <a class="btn btn-link edit" title="Edit" href="{{ route('TherapistWeeklyEdit','2') }}" style="background-color: crimson;margin-top: 7px !important;color:white;"><i class="fas fa-pencil-alt"></i></a>
                          <a class="btn btn-danger" type="submit" title="Delete" class="btn btn-link" style="color:navy;color:white;"><i class="far fa-trash-alt"></i></a>

                        </td>
                      </tr>

                      <tr>
                        <td>5</td>
                        <td>EN/2022/12/025(Kaviya)</td>
                        <td>Weekly</td>
                        <!-- <td>-</td> -->
                        <td>Malini <br></td>
                        <td>Speech<br></td>
                        <td>2023-02-13&10:00:00<br></td>
                        <td id="sent">Saved</td>

                        <td>
                          <a type="button" onclick="send()" id="sendbutton" class="btn btn-labeled btn-succes" title="Sent" style="background-color:green !important;color:white !important;height: 32px;">Send</a>
                          <a class="btn btn-link" title="Show" href="{{ route('TherapistWeeklyShow',1) }}" style="background-color: darkturquoise;color:white;"><i class="fas fa-eye"></i></a>
                          <a class="btn btn-link edit" title="Edit" href="{{ route('TherapistWeeklyEdit','2') }}" style="background-color: crimson;margin-top: 7px !important;color:white;"><i class="fas fa-pencil-alt"></i></a>
                          <a class="btn btn-danger" type="submit" title="Delete" class="btn btn-link" style="color:navy;color:white;"><i class="far fa-trash-alt"></i></a>

                        </td>
                      </tr>

                      <tr>
                        <td>6</td>
                        <td>EN/2022/12/025(Kaviya)</td>
                        <td>Weekly</td>
                        <!-- <td>-</td> -->
                        <td>Malini <br></td>
                        <td>Speech<br></td>
                        <td>2023-02-20&10:00:00<br></td>
                        <td id="sent">Saved</td>

                        <td>
                          <a type="button" onclick="send()" id="sendbutton" class="btn btn-labeled btn-succes" title="Sent" style="background-color:green !important;color:white !important;height: 32px;">Send</a>
                          <a class="btn btn-link" title="Show" href="{{ route('TherapistWeeklyShow',1) }}" style="background-color: darkturquoise;color:white;"><i class="fas fa-eye"></i></a>
                          <a class="btn btn-link edit" title="Edit" href="{{ route('TherapistWeeklyEdit','2') }}" style="background-color: crimson;margin-top: 7px !important;color:white;"><i class="fas fa-pencil-alt"></i></a>
                          <a class="btn btn-danger" type="submit" title="Delete" class="btn btn-link" style="color:navy;color:white;"><i class="far fa-trash-alt"></i></a>

                        </td>
                      </tr>

                      <tr>
                        <td>7</td>
                        <td>EN/2022/12/025(Kaviya)</td>
                        <td>Weekly</td>
                        <!-- <td>-</td> -->
                        <td>Malini <br></td>
                        <td>Speech<br></td>
                        <td>2023-02-27&10:00:00<br></td>
                        <td id="sent">Saved</td>

                        <td>
                          <a type="button" onclick="send()" id="sendbutton" class="btn btn-labeled btn-succes" title="Sent" style="background-color:green !important;color:white !important;height: 32px;">Send</a>
                          <a class="btn btn-link" title="Show" href="{{ route('TherapistWeeklyShow',1) }}" style="background-color: darkturquoise;color:white;"><i class="fas fa-eye"></i></a>
                          <a class="btn btn-link edit" title="Edit" href="{{ route('TherapistWeeklyEdit','2') }}" style="background-color: crimson;margin-top: 7px !important;color:white;"><i class="fas fa-pencil-alt"></i></a>
                          <a class="btn btn-danger" type="submit" title="Delete" class="btn btn-link" style="color:navy;color:white;"><i class="far fa-trash-alt"></i></a>

                        </td>
                      </tr>

                      <tr>
                        <td>8</td>
                        <td>EN/2022/12/025(Kaviya)</td>
                        <td>Weekly</td>
                        <!-- <td>-</td> -->
                        <td>Malini <br></td>
                        <td>Speech<br></td>
                        <td>2023-03-06&10:00:00<br></td>
                        <td id="sent">Saved</td>

                        <td>
                          <a type="button" onclick="send()" id="sendbutton" class="btn btn-labeled btn-succes" title="Sent" style="background-color:green !important;color:white !important;height: 32px;">Send</a>
                          <a class="btn btn-link" title="Show" href="{{ route('TherapistWeeklyShow',1) }}" style="background-color: darkturquoise;color:white;"><i class="fas fa-eye"></i></a>
                          <a class="btn btn-link edit" title="Edit" href="{{ route('TherapistWeeklyEdit','2') }}" style="background-color: crimson;margin-top: 7px !important;color:white;"><i class="fas fa-pencil-alt"></i></a>
                          <a class="btn btn-danger" type="submit" title="Delete" class="btn btn-link" style="color:navy;color:white;"><i class="far fa-trash-alt"></i></a>

                        </td>
                      </tr>

                      <tr>
                        <td>9</td>
                        <td>EN/2022/12/025(Kaviya)</td>
                        <td>Weekly</td>
                        <!-- <td>-</td> -->
                        <td>Malini <br></td>
                        <td>Speech<br></td>
                        <td>2023-03-13&10:00:00<br></td>
                        <td id="sent">Saved</td>

                        <td>
                          <a type="button" onclick="send()" id="sendbutton" class="btn btn-labeled btn-succes" title="Sent" style="background-color:green !important;color:white !important;height: 32px;">Send</a>
                          <a class="btn btn-link" title="Show" href="{{ route('TherapistWeeklyShow',1) }}" style="background-color: darkturquoise;color:white;"><i class="fas fa-eye"></i></a>
                          <a class="btn btn-link edit" title="Edit" href="{{ route('TherapistWeeklyEdit','2') }}" style="background-color: crimson;margin-top: 7px !important;color:white;"><i class="fas fa-pencil-alt"></i></a>
                          <a class="btn btn-danger" type="submit" title="Delete" class="btn btn-link" style="color:navy;color:white;"><i class="far fa-trash-alt"></i></a>

                        </td>
                      </tr>

                      <tr>
                        <td>10</td>
                        <td>EN/2022/12/025(Kaviya)</td>
                        <td>Weekly</td>
                        <!-- <td>-</td> -->
                        <td>Malini <br></td>
                        <td>Speech<br></td>
                        <td>2023-03-20&10:00:00<br></td>
                        <td id="sent">Saved</td>

                        <td>
                          <a type="button" onclick="send()" id="sendbutton" class="btn btn-labeled btn-succes" title="Sent" style="background-color:green !important;color:white !important;height: 32px;">Send</a>
                          <a class="btn btn-link" title="Show" href="{{ route('TherapistWeeklyShow',1) }}" style="background-color: darkturquoise;color:white;"><i class="fas fa-eye"></i></a>
                          <a class="btn btn-link edit" title="Edit" href="{{ route('TherapistWeeklyEdit','2') }}" style="background-color: crimson;margin-top: 7px !important;color:white;"><i class="fas fa-pencil-alt"></i></a>
                          <a class="btn btn-danger" type="submit" title="Delete" class="btn btn-link" style="color:navy;color:white;"><i class="far fa-trash-alt"></i></a>

                        </td>
                      </tr>

                      <tr>
                        <td>11</td>
                        <td>EN/2022/12/025(Kaviya)</td>
                        <td>Weekly</td>
                        <!-- <td>-</td> -->
                        <td>Malini <br></td>
                        <td>Speech<br></td>
                        <td>2023-02-20&10:00:00<br></td>
                        <td id="sent">Saved</td>

                        <td>
                          <a type="button" onclick="send()" id="sendbutton" class="btn btn-labeled btn-succes" title="Sent" style="background-color:green !important;color:white !important;height: 32px;">Send</a>
                          <a class="btn btn-link" title="Show" href="{{ route('TherapistWeeklyShow',1) }}" style="background-color: darkturquoise;color:white;"><i class="fas fa-eye"></i></a>
                          <a class="btn btn-link edit" title="Edit" href="{{ route('TherapistWeeklyEdit','2') }}" style="background-color: crimson;margin-top: 7px !important;color:white;"><i class="fas fa-pencil-alt"></i></a>
                          <a class="btn btn-danger" type="submit" title="Delete" class="btn btn-link" style="color:navy;color:white;"><i class="far fa-trash-alt"></i></a>

                        </td>
                      </tr>

                      <tr>
                        <td>12</td>
                        <td>EN/2022/12/025(Kaviya)</td>
                        <td>Weekly</td>
                        <!-- <td>-</td> -->
                        <td>Malini <br></td>
                        <td>Speech<br></td>
                        <td>2023-03-27&10:00:00<br></td>
                        <td id="sent">Saved</td>

                        <td>
                          <a type="button" onclick="send()" id="sendbutton" class="btn btn-labeled btn-succes" title="Sent" style="background-color:green !important;color:white !important;height: 32px;">Send</a>
                          <a class="btn btn-link" title="Show" href="{{ route('TherapistWeeklyShow',1) }}" style="background-color: darkturquoise;color:white;"><i class="fas fa-eye"></i></a>
                          <a class="btn btn-link edit" title="Edit" href="{{ route('TherapistWeeklyEdit','2') }}" style="background-color: crimson;margin-top: 7px !important;color:white;"><i class="fas fa-pencil-alt"></i></a>
                          <a class="btn btn-danger" type="submit" title="Delete" class="btn btn-link" style="color:navy;color:white;"><i class="far fa-trash-alt"></i></a>

                        </td>
                      </tr>



                      <tr>
                        <td>13</td>
                        <td>EN/2022/12/025(Kaviya)</td>
                        <td>Weekly</td>
                        <!-- <td>-</td> -->
                        <td>Malini <br></td>
                        <td>Speech<br></td>
                        <td>2023-04-03&10:00:00<br></td>
                        <td id="sent">Saved</td>

                        <td>
                          <a type="button" onclick="send()" id="sendbutton" class="btn btn-labeled btn-succes" title="Sent" style="background-color:green !important;color:white !important;height: 32px;">Send</a>
                          <a class="btn btn-link" title="Show" href="{{ route('TherapistWeeklyShow',1) }}" style="background-color: darkturquoise;color:white;"><i class="fas fa-eye"></i></a>
                          <a class="btn btn-link edit" title="Edit" href="{{ route('TherapistWeeklyEdit','2') }}" style="background-color: crimson;margin-top: 7px !important;color:white;"><i class="fas fa-pencil-alt"></i></a>
                          <a class="btn btn-danger" type="submit" title="Delete" class="btn btn-link" style="color:navy;color:white;"><i class="far fa-trash-alt"></i></a>

                        </td>
                      </tr>

                      <tr>
                        <td>14</td>
                        <td>EN/2022/12/025(Kaviya)</td>
                        <td>Weekly</td>
                        <!-- <td>-</td> -->
                        <td>Malini <br></td>
                        <td>Speech<br></td>
                        <td>2023-04-10&10:00:00<br></td>
                        <td id="sent">Saved</td>

                        <td>
                          <a type="button" onclick="send()" id="sendbutton" class="btn btn-labeled btn-succes" title="Sent" style="background-color:green !important;color:white !important;height: 32px;">Send</a>
                          <a class="btn btn-link" title="Show" href="{{ route('TherapistWeeklyShow',1) }}" style="background-color: darkturquoise;color:white;"><i class="fas fa-eye"></i></a>
                          <a class="btn btn-link edit" title="Edit" href="{{ route('TherapistWeeklyEdit','2') }}" style="background-color: crimson;margin-top: 7px !important;color:white;"><i class="fas fa-pencil-alt"></i></a>
                          <a class="btn btn-danger" type="submit" title="Delete" class="btn btn-link" style="color:navy;color:white;"><i class="far fa-trash-alt"></i></a>

                        </td>
                      </tr>

                      <tr>
                        <td>15</td>
                        <td>EN/2022/12/025(Kaviya)</td>
                        <td>Weekly</td>
                        <!-- <td>-</td> -->
                        <td>Malini <br></td>
                        <td>Speech<br></td>
                        <td>2023-04-17&10:00:00<br></td>
                        <td id="sent">Saved</td>

                        <td>
                          <a type="button" onclick="send()" id="sendbutton" class="btn btn-labeled btn-succes" title="Sent" style="background-color:green !important;color:white !important;height: 32px;">Send</a>
                          <a class="btn btn-link" title="Show" href="{{ route('TherapistWeeklyShow',1) }}" style="background-color: darkturquoise;color:white;"><i class="fas fa-eye"></i></a>
                          <a class="btn btn-link edit" title="Edit" href="{{ route('TherapistWeeklyEdit','2') }}" style="background-color: crimson;margin-top: 7px !important;color:white;"><i class="fas fa-pencil-alt"></i></a>
                          <a class="btn btn-danger" type="submit" title="Delete" class="btn btn-link" style="color:navy;color:white;"><i class="far fa-trash-alt"></i></a>

                        </td>
                      </tr>

                      <tr>
                        <td>16</td>
                        <td>EN/2022/12/025(Kaviya)</td>
                        <td>Weekly</td>
                        <!-- <td>-</td> -->
                        <td>Malini <br></td>
                        <td>Speech<br></td>
                        <td>2023-04-24&10:00:00<br></td>
                        <td id="sent">Saved</td>

                        <td>
                          <a type="button" onclick="send()" id="sendbutton" class="btn btn-labeled btn-succes" title="Sent" style="background-color:green !important;color:white !important;height: 32px;">Send</a>
                          <a class="btn btn-link" title="Show" href="{{ route('TherapistWeeklyShow',1) }}" style="background-color: darkturquoise;color:white;"><i class="fas fa-eye"></i></a>
                          <a class="btn btn-link edit" title="Edit" href="{{ route('TherapistWeeklyEdit','2') }}" style="background-color: crimson;margin-top: 7px !important;color:white;"><i class="fas fa-pencil-alt"></i></a>
                          <a class="btn btn-danger" type="submit" title="Delete" class="btn btn-link" style="color:navy;color:white;"><i class="far fa-trash-alt"></i></a>

                        </td>
                      </tr>

                      <tr>
                        <td>17</td>
                        <td>EN/2022/12/025(Kaviya)</td>
                        <td>Weekly</td>
                        <!-- <td>-</td> -->
                        <td>Malini <br></td>
                        <td>Speech<br></td>
                        <td>2023-05-01&10:00:00<br></td>
                        <td id="sent">Saved</td>

                        <td>
                          <a type="button" onclick="send()" id="sendbutton" class="btn btn-labeled btn-succes" title="Sent" style="background-color:green !important;color:white !important;height: 32px;">Send</a>
                          <a class="btn btn-link" title="Show" href="{{ route('TherapistWeeklyShow',1) }}" style="background-color: darkturquoise;color:white;"><i class="fas fa-eye"></i></a>
                          <a class="btn btn-link edit" title="Edit" href="{{ route('TherapistWeeklyEdit','2') }}" style="background-color: crimson;margin-top: 7px !important;color:white;"><i class="fas fa-pencil-alt"></i></a>
                          <a class="btn btn-danger" type="submit" title="Delete" class="btn btn-link" style="color:navy;color:white;"><i class="far fa-trash-alt"></i></a>

                        </td>
                      </tr>

                      <tr>
                        <td>18</td>
                        <td>EN/2022/12/025(Kaviya)</td>
                        <td>Weekly</td>
                        <!-- <td>-</td> -->
                        <td>Malini <br></td>
                        <td>Speech<br></td>
                        <td>2023-05-08&10:00:00<br></td>
                        <td id="sent">Saved</td>

                        <td>
                          <a type="button" onclick="send()" id="sendbutton" class="btn btn-labeled btn-succes" title="Sent" style="background-color:green !important;color:white !important;height: 32px;">Send</a>
                          <a class="btn btn-link" title="Show" href="{{ route('TherapistWeeklyShow',1) }}" style="background-color: darkturquoise;color:white;"><i class="fas fa-eye"></i></a>
                          <a class="btn btn-link edit" title="Edit" href="{{ route('TherapistWeeklyEdit','2') }}" style="background-color: crimson;margin-top: 7px !important;color:white;"><i class="fas fa-pencil-alt"></i></a>
                          <a class="btn btn-danger" type="submit" title="Delete" class="btn btn-link" style="color:navy;color:white;"><i class="far fa-trash-alt"></i></a>

                        </td>
                      </tr>

                      <tr>
                        <td>19</td>
                        <td>EN/2022/12/025(Kaviya)</td>
                        <td>Weekly</td>
                        <!-- <td>-</td> -->
                        <td>Malini <br></td>
                        <td>Speech<br></td>
                        <td>2023-05-15&10:00:00<br></td>
                        <td id="sent">Saved</td>

                        <td>
                          <a type="button" onclick="send()" id="sendbutton" class="btn btn-labeled btn-succes" title="Sent" style="background-color:green !important;color:white !important;height: 32px;">Send</a>
                          <a class="btn btn-link" title="Show" href="{{ route('TherapistWeeklyShow',1) }}" style="background-color: darkturquoise;color:white;"><i class="fas fa-eye"></i></a>
                          <a class="btn btn-link edit" title="Edit" href="{{ route('TherapistWeeklyEdit','2') }}" style="background-color: crimson;margin-top: 7px !important;color:white;"><i class="fas fa-pencil-alt"></i></a>
                          <a class="btn btn-danger" type="submit" title="Delete" class="btn btn-link" style="color:navy;color:white;"><i class="far fa-trash-alt"></i></a>

                        </td>
                      </tr>

                      <tr>
                        <td>20</td>
                        <td>EN/2022/12/025(Kaviya)</td>
                        <td>Weekly</td>
                        <!-- <td>-</td> -->
                        <td>Malini <br></td>
                        <td>Speech<br></td>
                        <td>2023-05-22&10:00:00<br></td>
                        <td id="sent">Saved</td>

                        <td>
                          <a type="button" onclick="send()" id="sendbutton" class="btn btn-labeled btn-succes" title="Sent" style="background-color:green !important;color:white !important;height: 32px;">Send</a>
                          <a class="btn btn-link" title="Show" href="{{ route('TherapistWeeklyShow',1) }}" style="background-color: darkturquoise;color:white;"><i class="fas fa-eye"></i></a>
                          <a class="btn btn-link edit" title="Edit" href="{{ route('TherapistWeeklyEdit','2') }}" style="background-color: crimson;margin-top: 7px !important;color:white;"><i class="fas fa-pencil-alt"></i></a>
                          <a class="btn btn-danger" type="submit" title="Delete" class="btn btn-link" style="color:navy;color:white;"><i class="far fa-trash-alt"></i></a>

                        </td>
                      </tr>

                      <tr>
                        <td>21</td>
                        <td>EN/2022/12/025(Kaviya)</td>
                        <td>Weekly</td>
                        <!-- <td>-</td> -->
                        <td>Malini <br></td>
                        <td>Speech<br></td>
                        <td>2023-05-29&10:00:00<br></td>
                        <td id="sent">Saved</td>

                        <td>
                          <a type="button" onclick="send()" id="sendbutton" class="btn btn-labeled btn-succes" title="Sent" style="background-color:green !important;color:white !important;height: 32px;">Send</a>
                          <a class="btn btn-link" title="Show" href="{{ route('TherapistWeeklyShow',1) }}" style="background-color: darkturquoise;color:white;"><i class="fas fa-eye"></i></a>
                          <a class="btn btn-link edit" title="Edit" href="{{ route('TherapistWeeklyEdit','2') }}" style="background-color: crimson;margin-top: 7px !important;color:white;"><i class="fas fa-pencil-alt"></i></a>
                          <a class="btn btn-danger" type="submit" title="Delete" class="btn btn-link" style="color:navy;color:white;"><i class="far fa-trash-alt"></i></a>

                        </td>
                      </tr>

                      <tr>
                        <td>22</td>
                        <td>EN/2022/12/025(Kaviya)</td>
                        <td>Weekly</td>
                        <!-- <td>-</td> -->
                        <td>Malini <br></td>
                        <td>Speech<br></td>
                        <td>2023-06-05&10:00:00<br></td>
                        <td id="sent">Saved</td>

                        <td>
                          <a type="button" onclick="send()" id="sendbutton" class="btn btn-labeled btn-succes" title="Sent" style="background-color:green !important;color:white !important;height: 32px;">Send</a>
                          <a class="btn btn-link" title="Show" href="{{ route('TherapistWeeklyShow',1) }}" style="background-color: darkturquoise;color:white;"><i class="fas fa-eye"></i></a>
                          <a class="btn btn-link edit" title="Edit" href="{{ route('TherapistWeeklyEdit','2') }}" style="background-color: crimson;margin-top: 7px !important;color:white;"><i class="fas fa-pencil-alt"></i></a>
                          <a class="btn btn-danger" type="submit" title="Delete" class="btn btn-link" style="color:navy;color:white;"><i class="far fa-trash-alt"></i></a>

                        </td>
                      </tr>

                      <tr>
                        <td>23</td>
                        <td>EN/2022/12/025(Kaviya)</td>
                        <td>Weekly</td>
                        <!-- <td>-</td> -->
                        <td>Malini <br></td>
                        <td>Speech<br></td>
                        <td>2023-06-12&10:00:00<br></td>
                        <td id="sent">Saved</td>

                        <td>
                          <a type="button" onclick="send()" id="sendbutton" class="btn btn-labeled btn-succes" title="Sent" style="background-color:green !important;color:white !important;height: 32px;">Send</a>
                          <a class="btn btn-link" title="Show" href="{{ route('TherapistWeeklyShow',1) }}" style="background-color: darkturquoise;color:white;"><i class="fas fa-eye"></i></a>
                          <a class="btn btn-link edit" title="Edit" href="{{ route('TherapistWeeklyEdit','2') }}" style="background-color: crimson;margin-top: 7px !important;color:white;"><i class="fas fa-pencil-alt"></i></a>
                          <a class="btn btn-danger" type="submit" title="Delete" class="btn btn-link" style="color:navy;color:white;"><i class="far fa-trash-alt"></i></a>

                        </td>
                      </tr>

                      <tr>
                        <td>24</td>
                        <td>EN/2022/12/025(Kaviya)</td>
                        <td>Weekly</td>
                        <!-- <td>-</td> -->
                        <td>Malini <br></td>
                        <td>Speech<br></td>
                        <td>2023-06-12&10:00:00<br></td>
                        <td id="sent">Saved</td>

                        <td>
                          <a type="button" onclick="send()" id="sendbutton" class="btn btn-labeled btn-succes" title="Sent" style="background-color:green !important;color:white !important;height: 32px;">Send</a>
                          <a class="btn btn-link" title="Show" href="{{ route('TherapistWeeklyShow',1) }}" style="background-color: darkturquoise;color:white;"><i class="fas fa-eye"></i></a>
                          <a class="btn btn-link edit" title="Edit" href="{{ route('TherapistWeeklyEdit','2') }}" style="background-color: crimson;margin-top: 7px !important;color:white;"><i class="fas fa-pencil-alt"></i></a>
                          <a class="btn btn-danger" type="submit" title="Delete" class="btn btn-link" style="color:navy;color:white;"><i class="far fa-trash-alt"></i></a>

                        </td>
                      </tr>


                      <tr>
                        <td>25</td>
                        <td>EN/2022/12/025(Kaviya)</td>
                        <td>Weekly</td>
                        <!-- <td>-</td> -->
                        <td>Malini <br></td>
                        <td>Speech<br></td>
                        <td>2023-06-19&10:00:00<br></td>
                        <td id="sent">Saved</td>

                        <td>
                          <a type="button" onclick="send()" id="sendbutton" class="btn btn-labeled btn-succes" title="Sent" style="background-color:green !important;color:white !important;height: 32px;">Send</a>
                          <a class="btn btn-link" title="Show" href="{{ route('TherapistWeeklyShow',1) }}" style="background-color: darkturquoise;color:white;"><i class="fas fa-eye"></i></a>
                          <a class="btn btn-link edit" title="Edit" href="{{ route('TherapistWeeklyEdit','2') }}" style="background-color: crimson;margin-top: 7px !important;color:white;"><i class="fas fa-pencil-alt"></i></a>
                          <a class="btn btn-danger" type="submit" title="Delete" class="btn btn-link" style="color:navy;color:white;"><i class="far fa-trash-alt"></i></a>

                        </td>
                      </tr>

                      <tr>
                        <td>26</td>
                        <td>EN/2022/12/025(Kaviya)</td>
                        <td>Weekly</td>
                        <!-- <td>-</td> -->
                        <td>Malini <br></td>
                        <td>Speech<br></td>
                        <td>2023-06-19&10:00:00<br></td>
                        <td id="sent">Saved</td>

                        <td>
                          <a type="button" onclick="send()" id="sendbutton" class="btn btn-labeled btn-succes" title="Sent" style="background-color:green !important;color:white !important;height: 32px;">Send</a>
                          <a class="btn btn-link" title="Show" href="{{ route('TherapistWeeklyShow',1) }}" style="background-color: darkturquoise;color:white;"><i class="fas fa-eye"></i></a>
                          <a class="btn btn-link edit" title="Edit" href="{{ route('TherapistWeeklyEdit','2') }}" style="background-color: crimson;margin-top: 7px !important;color:white;"><i class="fas fa-pencil-alt"></i></a>
                          <a class="btn btn-danger" type="submit" title="Delete" class="btn btn-link" style="color:navy;color:white;"><i class="far fa-trash-alt"></i></a>

                        </td>
                      </tr>

                      <tr>
                        <td>27</td>
                        <td>EN/2022/12/025(Kaviya)</td>
                        <td>Weekly</td>
                        <!-- <td>-</td> -->
                        <td>Malini <br></td>
                        <td>Speech<br></td>
                        <td>2023-06-26&10:00:00<br></td>
                        <td id="sent">Saved</td>

                        <td>
                          <a type="button" onclick="send()" id="sendbutton" class="btn btn-labeled btn-succes" title="Sent" style="background-color:green !important;color:white !important;height: 32px;">Send</a>
                          <a class="btn btn-link" title="Show" href="{{ route('TherapistWeeklyShow',1) }}" style="background-color: darkturquoise;color:white;"><i class="fas fa-eye"></i></a>
                          <a class="btn btn-link edit" title="Edit" href="{{ route('TherapistWeeklyEdit','2') }}" style="background-color: crimson;margin-top: 7px !important;color:white;"><i class="fas fa-pencil-alt"></i></a>
                          <a class="btn btn-danger" type="submit" title="Delete" class="btn btn-link" style="color:navy;color:white;"><i class="far fa-trash-alt"></i></a>

                        </td>
                      </tr>

                      <tr>
                        <td>28</td>
                        <td>EN/2022/12/025(Kaviya)</td>
                        <td>Weekly</td>
                        <!-- <td>-</td> -->
                        <td>Malini <br></td>
                        <td>Speech<br></td>
                        <td>2023-07-03&10:00:00<br></td>
                        <td id="sent">Saved</td>

                        <td>
                          <a type="button" onclick="send()" id="sendbutton" class="btn btn-labeled btn-succes" title="Sent" style="background-color:green !important;color:white !important;height: 32px;">Send</a>
                          <a class="btn btn-link" title="Show" href="{{ route('TherapistWeeklyShow',1) }}" style="background-color: darkturquoise;color:white;"><i class="fas fa-eye"></i></a>
                          <a class="btn btn-link edit" title="Edit" href="{{ route('TherapistWeeklyEdit','2') }}" style="background-color: crimson;margin-top: 7px !important;color:white;"><i class="fas fa-pencil-alt"></i></a>
                          <a class="btn btn-danger" type="submit" title="Delete" class="btn btn-link" style="color:navy;color:white;"><i class="far fa-trash-alt"></i></a>

                        </td>
                      </tr>

                      <tr>
                        <td>29</td>
                        <td>EN/2022/12/025(Kaviya)</td>
                        <td>Weekly</td>
                        <!-- <td>-</td> -->
                        <td>Malini <br></td>
                        <td>Speech<br></td>
                        <td>2023-07-10&10:00:00<br></td>
                        <td id="sent">Saved</td>

                        <td>
                          <a type="button" onclick="send()" id="sendbutton" class="btn btn-labeled btn-succes" title="Sent" style="background-color:green !important;color:white !important;height: 32px;">Send</a>
                          <a class="btn btn-link" title="Show" href="{{ route('TherapistWeeklyShow',1) }}" style="background-color: darkturquoise;color:white;"><i class="fas fa-eye"></i></a>
                          <a class="btn btn-link edit" title="Edit" href="{{ route('TherapistWeeklyEdit','2') }}" style="background-color: crimson;margin-top: 7px !important;color:white;"><i class="fas fa-pencil-alt"></i></a>
                          <a class="btn btn-danger" type="submit" title="Delete" class="btn btn-link" style="color:navy;color:white;"><i class="far fa-trash-alt"></i></a>

                        </td>
                      </tr>

                      <tr>
                        <td>30</td>
                        <td>EN/2022/12/025(Kaviya)</td>
                        <td>Weekly</td>
                        <!-- <td>-</td> -->
                        <td>Malini <br></td>
                        <td>Speech<br></td>
                        <td>2023-07-17&10:00:00<br></td>
                        <td id="sent">Saved</td>

                        <td>
                          <a type="button" onclick="send()" id="sendbutton" class="btn btn-labeled btn-succes" title="Sent" style="background-color:green !important;color:white !important;height: 32px;">Send</a>
                          <a class="btn btn-link" title="Show" href="{{ route('TherapistWeeklyShow',1) }}" style="background-color: darkturquoise;color:white;"><i class="fas fa-eye"></i></a>
                          <a class="btn btn-link edit" title="Edit" href="{{ route('TherapistWeeklyEdit','2') }}" style="background-color: crimson;margin-top: 7px !important;color:white;"><i class="fas fa-pencil-alt"></i></a>
                          <a class="btn btn-danger" type="submit" title="Delete" class="btn btn-link" style="color:navy;color:white;"><i class="far fa-trash-alt"></i></a>

                        </td>
                      </tr>

                      <tr>
                        <td>31</td>
                        <td>EN/2022/12/025(Kaviya)</td>
                        <td>Weekly</td>
                        <!-- <td>-</td> -->
                        <td>Malini <br></td>
                        <td>Speech<br></td>
                        <td>2023-07-24&10:00:00<br></td>
                        <td id="sent">Saved</td>

                        <td>
                          <a type="button" onclick="send()" id="sendbutton" class="btn btn-labeled btn-succes" title="Sent" style="background-color:green !important;color:white !important;height: 32px;">Send</a>
                          <a class="btn btn-link" title="Show" href="{{ route('TherapistWeeklyShow',1) }}" style="background-color: darkturquoise;color:white;"><i class="fas fa-eye"></i></a>
                          <a class="btn btn-link edit" title="Edit" href="{{ route('TherapistWeeklyEdit','2') }}" style="background-color: crimson;margin-top: 7px !important;color:white;"><i class="fas fa-pencil-alt"></i></a>
                          <a class="btn btn-danger" type="submit" title="Delete" class="btn btn-link" style="color:navy;color:white;"><i class="far fa-trash-alt"></i></a>

                        </td>
                      </tr>

                      <tr>
                        <td>32</td>
                        <td>EN/2022/12/025(Kaviya)</td>
                        <td>Weekly</td>
                        <!-- <td>-</td> -->
                        <td>Malini <br></td>
                        <td>Speech<br></td>
                        <td>2023-07-31&10:00:00<br></td>
                        <td id="sent">Saved</td>

                        <td>
                          <a type="button" onclick="send()" id="sendbutton" class="btn btn-labeled btn-succes" title="Sent" style="background-color:green !important;color:white !important;height: 32px;">Send</a>
                          <a class="btn btn-link" title="Show" href="{{ route('TherapistWeeklyShow',1) }}" style="background-color: darkturquoise;color:white;"><i class="fas fa-eye"></i></a>
                          <a class="btn btn-link edit" title="Edit" href="{{ route('TherapistWeeklyEdit','2') }}" style="background-color: crimson;margin-top: 7px !important;color:white;"><i class="fas fa-pencil-alt"></i></a>
                          <a class="btn btn-danger" type="submit" title="Delete" class="btn btn-link" style="color:navy;color:white;"><i class="far fa-trash-alt"></i></a>

                        </td>
                      </tr>

                      <tr>
                        <td>33</td>
                        <td>EN/2022/12/025(Kaviya)</td>
                        <td>Weekly</td>
                        <!-- <td>-</td> -->
                        <td>Malini <br></td>
                        <td>Speech<br></td>
                        <td>2023-08-07&10:00:00<br></td>
                        <td id="sent">Saved</td>

                        <td>
                          <a type="button" onclick="send()" id="sendbutton" class="btn btn-labeled btn-succes" title="Sent" style="background-color:green !important;color:white !important;height: 32px;">Send</a>
                          <a class="btn btn-link" title="Show" href="{{ route('TherapistWeeklyShow',1) }}" style="background-color: darkturquoise;color:white;"><i class="fas fa-eye"></i></a>
                          <a class="btn btn-link edit" title="Edit" href="{{ route('TherapistWeeklyEdit','2') }}" style="background-color: crimson;margin-top: 7px !important;color:white;"><i class="fas fa-pencil-alt"></i></a>
                          <a class="btn btn-danger" type="submit" title="Delete" class="btn btn-link" style="color:navy;color:white;"><i class="far fa-trash-alt"></i></a>

                        </td>
                      </tr>

                      <tr>
                        <td>34</td>
                        <td>EN/2022/12/025(Kaviya)</td>
                        <td>Weekly</td>
                        <!-- <td>-</td> -->
                        <td>Malini <br></td>
                        <td>Speech<br></td>
                        <td>2023-08-14&10:00:00<br></td>
                        <td id="sent">Saved</td>

                        <td>
                          <a type="button" onclick="send()" id="sendbutton" class="btn btn-labeled btn-succes" title="Sent" style="background-color:green !important;color:white !important;height: 32px;">Send</a>
                          <a class="btn btn-link" title="Show" href="{{ route('TherapistWeeklyShow',1) }}" style="background-color: darkturquoise;color:white;"><i class="fas fa-eye"></i></a>
                          <a class="btn btn-link edit" title="Edit" href="{{ route('TherapistWeeklyEdit','2') }}" style="background-color: crimson;margin-top: 7px !important;color:white;"><i class="fas fa-pencil-alt"></i></a>
                          <a class="btn btn-danger" type="submit" title="Delete" class="btn btn-link" style="color:navy;color:white;"><i class="far fa-trash-alt"></i></a>

                        </td>
                      </tr>

                      <tr>
                        <td>35</td>
                        <td>EN/2022/12/025(Kaviya)</td>
                        <td>Weekly</td>
                        <!-- <td>-</td> -->
                        <td>Malini <br></td>
                        <td>Speech<br></td>
                        <td>2023-08-21&10:00:00<br></td>
                        <td id="sent">Saved</td>

                        <td>
                          <a type="button" onclick="send()" id="sendbutton" class="btn btn-labeled btn-succes" title="Sent" style="background-color:green !important;color:white !important;height: 32px;">Send</a>
                          <a class="btn btn-link" title="Show" href="{{ route('TherapistWeeklyShow',1) }}" style="background-color: darkturquoise;color:white;"><i class="fas fa-eye"></i></a>
                          <a class="btn btn-link edit" title="Edit" href="{{ route('TherapistWeeklyEdit','2') }}" style="background-color: crimson;margin-top: 7px !important;color:white;"><i class="fas fa-pencil-alt"></i></a>
                          <a class="btn btn-danger" type="submit" title="Delete" class="btn btn-link" style="color:navy;color:white;"><i class="far fa-trash-alt"></i></a>

                        </td>
                      </tr>
                      <tr>
                        <td>36</td>
                        <td>EN/2022/12/025(Kaviya)</td>
                        <td>Weekly</td>
                        <!-- <td>-</td> -->
                        <td>Malini <br></td>
                        <td>Speech<br></td>
                        <td>2023-08-27&10:00:00<br></td>
                        <td id="sent">Saved</td>

                        <td>
                          <a type="button" onclick="send()" id="sendbutton" class="btn btn-labeled btn-succes" title="Sent" style="background-color:green !important;color:white !important;height: 32px;">Send</a>
                          <a class="btn btn-link" title="Show" href="{{ route('TherapistWeeklyShow',1) }}" style="background-color: darkturquoise;color:white;"><i class="fas fa-eye"></i></a>
                          <a class="btn btn-link edit" title="Edit" href="{{ route('TherapistWeeklyEdit','2') }}" style="background-color: crimson;margin-top: 7px !important;color:white;"><i class="fas fa-pencil-alt"></i></a>
                          <a class="btn btn-danger" type="submit" title="Delete" class="btn btn-link" style="color:navy;color:white;"><i class="far fa-trash-alt"></i></a>

                        </td>
                      </tr>



                      <tr>
                        <td>37</td>
                        <td>EN/2022/12/025(Kaviya)</td>
                        <td>Weekly</td>
                        <!-- <td>-</td> -->
                        <td>Sumi</td>
                        <td>OT</td>
                        <td>2022-12-10&14:06:00</td>
                        <td id="sent">Saved</td>

                        <td>
                          <a type="button" onclick="send()" id="send" class="btn btn-labeled btn-succes" title="Sent" style="background-color:green !important;color:white !important;height: 32px;">Send</a>
                          <a class="btn btn-link" title="Show" href="{{ route('TherapistWeeklyShow',1) }}" style="background-color: darkturquoise;color:white;"><i class="fas fa-eye"></i></a>
                          <a class="btn btn-link " title="Edit" href="{{ route('TherapistWeeklyEdit','2') }}" style="background-color: crimson;margin-top: 7px !important;color:white;"><i class="fas fa-pencil-alt"></i></a>
                          <a class="btn btn-danger" type="submit" title="Delete" class="btn btn-link" style="color:navy;color:white;"><i class="far fa-trash-alt"></i></a>

                        </td>
                      </tr>



                      <tr>
                        <td>38</td>
                        <td>EN/2022/12/025(Kaviya)</td>
                        <td>Weekly</td>
                        <!-- <td>-</td> -->
                        <td>Sumi</td>
                        <td>OT</td>
                        <td>2022-12-11&14:06:00</td>
                        <td>Sent</td>

                        <td>
                          <a class="btn btn-link" title="Show" href="{{ route('SessionMeetingSentShow',1) }}" style="background-color: darkturquoise;color:white;"><i class="fas fa-eye"></i></a>
                          <a class="btn btn-link" title="Reschedule" href="{{ route('SessionMeetingSentEdit',1) }}" style="background-color: crimson;color:white;"><i class="fas fa-pencil-alt"></i></a>
                        </td>
                      </tr>
                      <tr>
                        <td>39</td>
                        <td>EN/2022/12/025(Kaviya)</td>
                        <td>Weekly</td>
                        <!-- <td>-</td> -->
                        <td>Sumi</td>
                        <td>OT</td>
                        <td>2022-12-10&14:06:00</td>
                        <td>Sent</td>

                        <td>
                          <a class="btn btn-link" title="Show" href="{{ route('SessionMeetingSentShow',1) }}" style="background-color: darkturquoise;color:white;"><i class="fas fa-eye"></i></a>
                          <a class="btn btn-link" title="Reschedule" href="{{ route('SessionMeetingSentEdit',1) }}" style="background-color: crimson;color:white;"><i class="fas fa-pencil-alt"></i></a>
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
    </div>
  </section>
</div>

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
<div class="modal fade row" id="calModal3" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/tinymce/4.5.6/tinymce.min.js"></script>
<script src="http://cdnjs.cloudflare.com/ajax/libs/tinymce/4.5.6/jquery.tinymce.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.26.0/moment.min.js"></script>
<script src="https://code.jquery.com/jquery-1.7.2.min.js"></script>
@include('ovm1.cal')


<script type="text/javascript">
  const iscoordinatorfn = (event) => {
    //alert();

    let coordinatorname = event.target.value;
    let currentcoordinator = event.target.name;


    getEventsDB(currentcoordinator);

    //...
  }
</script>

<script>
  function send()

  {
    const message2 = "Valuer List Approved Successfully";
    location.replace(`/therapist?message2="${message2}"`);

    // window.location.href = "/therapist";
  }
</script>


<script>
  function newmeeting()

  {
    if (document.getElementById('enrollment_child_num').value == "") {
      Swal.fire("Please Select Enrolment Number: ", "", "error");
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
          document.getElementById('enrollment_id').value = data[0].enrollment_id;
          document.getElementById('user_id').value = data[0].user_id;


          console.log(data[0].user_id);


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
  var addevent = document.querySelector('[name="Specialization"]');
  addevent.addEventListener('change', GetTherapist);


  function iconchange(e) {
    //alert(e.target.id);
    var ajaxselect = document.getElementById(`${e.target.id}`);
    //alert(ajaxselect.getAttribute('selectnew'));
    e.target.nextElementSibling.style.display = "block";
    var x = ajaxselect.getAttribute('selectnew');
    if (ajaxselect.getAttribute('selectnew') >= 1) {
      // alert("if");
      document.getElementById(`plus${x}`).classList.remove("fa-minus-circle");
      document.getElementById(`plus${x}`).classList.add("fa-plus-circle");
    }

  }

  function GetTherapist(e) {
    //alert("ajax");
    if (e.target.id > 1) {
      document.querySelector(`#plus${e.target.id}`)
    }



    var Specialization = e.target.value;


    if (Specialization != "") {
      //alert("in");

      //  alert("out");
      $.ajax({
        url: "{{ url('/therapist/specialization') }}",
        type: 'POST',
        data: {
          'Specialization': Specialization,
          _token: '{{csrf_token()}}',

        }
      }).done(function(data) {
        //console.log(data);


        if (data.length != 0) {

          // var user_select = data;
          var optionsdata = "";

          for (var i = 0; i < data.length; i++) {
            var id = data[i]['id'];
            var name = data[i]['name'];
            var option = '<option value="">Select Therapist </option>';
            optionsdata += "<option value=" + name + " >" + name + "</option>";
          }
          var stageoption = option.concat(optionsdata);
          console.log(stageoption);
          var demonew = $(`#Therapist${e.target.id}`).html(stageoption);



        } else {
          document.getElementById('Therapist').value = " ";
          var ddd = '<option value="child_name">Select Therapist</option>';
          var demonew = $(`#Therapist${e.target.id}`).html(ddd);

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
  function save() {

    var enrollment_child_num = $('#enrollment_child_num').val();
    if (enrollment_child_num == "") {
      Swal.fire("Please Select Enrolment Number", "", "error");
      return false;
    }
    var child_id = $('#child_id').val();
    if (child_id == "") {
      Swal.fire("Please Enter Child ID", "", "error");
      return false;
    }
    var child_name = $('#child_name').val();
    if (child_name == "") {
      Swal.fire("Please Enter Child Name", "", "error");
      return false;
    }
    if (document.querySelector('[name="Specialization"]').value == "") {
      Swal.fire("Please Select Specialization: ", "", "error");
      return false;
    }
    if (document.querySelector('[name="Therapist"]').value == "") {
      Swal.fire("Please Select Therapist: ", "", "error");
      return false;
    }
    var meeting_startdate = $('#meeting_startdate').val();
    if (meeting_startdate == "") {
      Swal.fire("Please Enter Start Date", "", "error");
      return false;
    }
    var meeting_starttime = $('#meeting_starttime').val();
    if (meeting_starttime == "") {
      Swal.fire("Please Enter Start Time", "", "error");
      return false;
    }
    var meeting_enddate = $('#meeting_enddate').val();
    if (meeting_enddate == "") {
      Swal.fire("Please Enter Start Date", "", "error");
      return false;
    }

    var meeting_endtime = $('#meeting_endtime').val();
    if (meeting_endtime == "") {
      Swal.fire("Please Enter End Time", "", "error");
      return false;
    }

    var meeting_description = $('#meeting_description').val();
    if (meeting_description == "") {
      Swal.fire("Please Enter Description", "", "error");
      return false;
    }


    document.getElementById('saved').style.display = "block";
    document.getElementById('secondrow').style.display = "none";
    document.getElementById('invite').style.display = "none";

    return true;
  }
</script>
<script>
  function invite() {
    var enrollment_child_num = $('#enrollment_child_num').val();
    if (enrollment_child_num == "") {
      Swal.fire("Please Select Enrolment Number", "", "error");
      return false;
    }
    var child_id = $('#child_id').val();
    if (child_id == "") {
      Swal.fire("Please Enter Child ID", "", "error");
      return false;
    }
    var child_name = $('#child_name').val();
    if (child_name == "") {
      Swal.fire("Please Enter Child Name", "", "error");
      return false;
    }
    if (document.querySelector('[name="Specialization"]').value == "") {
      Swal.fire("Please Select Specialization: ", "", "error");
      return false;
    }
    if (document.querySelector('[name="Therapist"]').value == "") {
      Swal.fire("Please Select Therapist: ", "", "error");
      return false;
    }
    var meeting_startdate = $('#meeting_startdate').val();
    if (meeting_startdate == "") {
      Swal.fire("Please Enter Start Date", "", "error");
      return false;
    }
    var meeting_starttime = $('#meeting_starttime').val();
    if (meeting_starttime == "") {
      Swal.fire("Please Enter Start Time", "", "error");
      return false;
    }
    //meeting_enddate
    var meeting_enddate = $('#meeting_enddate').val();
    if (meeting_enddate == "") {
      Swal.fire("Please Enter Start Date", "", "error");
      return false;
    }
    var meeting_endtime = $('#meeting_endtime').val();
    if (meeting_endtime == "") {
      Swal.fire("Please Enter End Time", "", "error");
      return false;
    }

    var meeting_description = $('#meeting_description').val();
    if (meeting_description == "") {
      Swal.fire("Please Enter Description", "", "error");
      return false;
    }
    // Swal.fire({
    //     title: "Success",
    //     text: "Session Updated Successfully",
    //     icon: "success",
    //   });

    document.getElementById('saved').style.display = "none";
    document.getElementById('secondrow').style.display = "none";
    document.getElementById('invite').style.display = "block";
  }
</script>
<script>
  function message() {
    //alert("cgfyh");
    invite();
    const specialzation = document.querySelector('[name="Specialization"]').value;
    //alert(specialzation);

    const therapist = document.querySelector('[name="Therapist"]').value;
    //alert(therapist);
    const meeting_startdate = document.querySelector('#meeting_startdate').value;
    //alert(meeting_startdate);
    var meeting_starttime = document.querySelector('#meeting_starttime').value;
    //alert(meeting_starttime);
    var meeting_enddate = document.querySelector('#meeting_enddate').value;
    //alert(meeting_enddate);
    var meeting_endtime = document.querySelector('#meeting_endtime').value;
    //alert(meeting_endtime);

    if ((specialzation != '') && (therapist != '') && (meeting_startdate != '') && (meeting_starttime != '') && (meeting_enddate != '') && (meeting_endtime != '')) {
      //alert('bjabc');
      Swal.fire("Please Save or Initate the Therapist Session", "", "error");
      return false;
    }

  }
</script>

<script type="text/javascript">
  $("#enrollment_child_num").select2({
    tags: false
  });
</script>

<script>
  let addTherapist = document.querySelector('[name="Add_therapist_btn"]');

  let addedTherapists = document.querySelectorAll('[name="Add_therapist_btn"]');
  // console.log(addedTherapists);

  function switchiconFunction(e) {
    //alert("switchicon");
    var refresh_id = e.target.getAttribute('value');
    // alert(refresh_id);
    var refresh = document.getElementById(`${refresh_id}`);
    // alert(refresh.className);
    var valid_id = e.target.getAttribute('Data');

    if (refresh.className == "fa fa-minus-circle") {
      //alert("huhds");
      if (document.getElementById(`${valid_id}`).value == "") {
        Swal.fire("Please Select Specialization: ", "", "error");
        return false;
      }
      if (document.querySelector(`#Therapist${valid_id}`).value == "") {
        Swal.fire("Please Select Therapist: ", "", "error");
        return false;
      }

    } else {

      document.getElementById(`${refresh_id}`).classList.remove("fa-plus-circle");
      document.getElementById(`${refresh_id}`).classList.add("fa-minus-circle");
    }



  }

  function addTherapistFunction(e) {

    if (document.querySelector('[name="Specialization"]').value == "") {
      Swal.fire("Please Select Specialization: ", "", "error");
      return false;
    }
    if (document.querySelector('[name="Therapist"]').value == "") {
      Swal.fire("Please Select Therapist: ", "", "error");
      return false;
    }
    var meeting_startdate = $('#meeting_startdate').val();
    if (meeting_startdate == "") {
      Swal.fire("Please Enter Start Date", "", "error");
      return false;
    }
    var meeting_starttime = $('#meeting_starttime').val();
    if (meeting_starttime == "") {
      Swal.fire("Please Enter Start Time", "", "error");
      return false;
    }
    var meeting_endtime = $('#meeting_endtime').val();
    if (meeting_endtime == "") {
      Swal.fire("Please Enter End Time", "", "error");
      return false;
    }
    var meeting_description = $('#meeting_description').val();
    if (meeting_description == "") {
      Swal.fire("Please Enter Description", "", "error");
      return false;
    }

    if (e.target.tagName == "I") {
      // alert("i");
      var btid = document.getElementById(`${e.target.parentElement.id}`);
      // alert(btid);
      console.log(btid);
      var plus = document.querySelector(`#plus${btid.value}`);
      // alert(plus); 
    } else {
      var btid = document.getElementById(`${e.target.id}`);

      var plus = document.querySelector(`#plus${btid.value}`);
    }

    plus = plus.className;

    var x = btid.value
    var btid_new = ++x;

    if (plus == 'fa fa-plus-circle') {


      $('.check').append('<div class="col-md-6 sp' + btid_new + '"><div class="form-group"><label class="control-label required">Specialization</label><select class="form-control ' + btid_new + '" name="Specialization" id="' + btid_new + '"><option value="">Select Specialization</option><option value="Speech Therapist">Speech Therapist</option><option value="Occupational Therapist">Occupational Therapist</option><option value="Physical Education">Physical Education</option><option value="Special Education">Special Education</option></select></div></div><div class="col-md-6 th' + btid_new + '"><div class="form-group"><label class="control-label">Therapist</label><span class="error-star" style="color:red;">*</span><div class="plus' + btid_new + ' refreshicon " style="display:flex;font-size:25px;align-items:center;">  <select class="form-control" name="Therapist" selectnew="' + btid_new + '" id="Therapist' + btid_new + '" autocomplete="off" readonly><option value="">Select Therapist</option></select><button  style="display: none;" id="co_one" title="Availability Calendar" class="btn" data-toggle="modal" data-target="#calModal" type="button"><i style="color: blue;font-size: 20px;" class="fa fa-calendar" aria-hidden="true"></i></button><button  id="Add_therapist' + btid_new + '" name="Add_therapist_btn" title="Add therapist" class="btn" value="' + btid_new + '"  type="button"><i style="color: blue;font-size: 20px;color:blue;" id="plus' + btid_new + '"  class="fa fa-minus-circle"  value="' + btid_new + '" aria-hidden="true" disabled></i></button><div class="refreshdelete' + btid_new + '"><i class="fa fa-refresh" name="switch" Data="' + btid_new + '"value="plus' + btid_new + '" aria-hidden="true"></i></div></div></div></div><div class="meetingdetails' + btid_new + '"><div class="row form-group"><div class="col-md-5"><div style="display:flex !important;justify-content: center !important;"class="row apply"'+ btid_new +'"><label class="control-label">Start Date and Time</label><span class="error-star" style="color:red;">*</span></div><div class="row"><div class="col-6"><input type="date"class="form-control" id="meeting_startdate" name="meeting_startdate" title="Meeting Start Date" onchange="autodateupdate(this)" required></div><div class="col-6"><input class="form-control" type="time" id="meeting_starttime" name="meeting_starttime" title="Meeting Start Time" required></div></div></div><div class="col-md-5"><div class="row" style="display:flex !important;justify-content: center !important;"><label class="control-label">End Date and Time</label><span class="error-star" style="color:red;">*</span></div><div class="row"><div class="col-6"><input type="date" class="form-control" id="meeting_enddate" name="meeting_enddate" title="Meeting End Date" onchange="autodateupdate(this)" required></div><div class="col-6"><input class="form-control" type="time" id="meeting_endtime" name="meeting_endtime" title="Meeting End Time" required></div></div></div><div class="col-md-2" style="display:contents !important;"><div class="col-md-1"><input type="radio" id="contactChoice1" class="contactChoice1" name="contact" value="email" checked><label for="contactChoice1">Apply for 8 months</label></div><div class="col-md-1"><input type="radio" id="contactChoice2" name="contact" value="phone"><label for="contactChoice2">Apply for this week</label></div></div><div class="col-md-12"><div class="row form-group"><div class="col-sm-3"><label class="control-label">Notes</label><span class="error-star" style="color:red;">*</span></label><div class="col-md-8"><textarea id="meeting_description" name="meeting_description" rows="6" cols="80" required></textarea></div></div></div></div></div></div></div></div>');


      var deleterefresh = document.querySelector(`.refreshdelete${btid.value}`);
      //alert("remove3:"+btid_old);
      if (deleterefresh != null) {
        document.querySelector(`.refreshdelete${btid.value}`).style.display = "none";
      }

      // alert(`.Add_therapist${btid.value}`);
      document.querySelector(`#Add_therapist${btid.value}`).style.display = "none";

    } else {
      if (e.target.tagName == "I") {

        var btid = document.getElementById(`${e.target.parentElement.id}`);


        var plus = document.querySelector(`#plus${btid.value}`);
        //alert(plus); 
      } else {
        var btid = document.getElementById(`${e.target.id}`);
        //console.log(btid);
        var plus = document.querySelector(`#plus${btid.value}`);
      }
      //alert('minus');
      document.querySelector(`.th${btid.value}`).style.display = "none";

      document.querySelector(`.sp${btid.value}`).style.display = "none";
      document.querySelector(`.meetingdetails${btid.value}`).style.display = 'none'

      // document.querySelector(`.sp${btid.value}`).style.display = "none";
      var y = btid.value
      // alert("y:" + y);
      var btid_old = --y;
      // alert("name:" + btid_old);
      document.querySelector(`#Add_therapist${btid_old}`).style.display = "block";

      var deleterefresh = document.querySelector(`.refreshdelete${btid_old}`);
      //alert("remove3:"+btid_old);
      if (deleterefresh != null) {
        document.querySelector(`.refreshdelete${btid_old}`).style.display = "block";
      }
      //alert(plus);

    }
    const dbox = document.querySelectorAll('[name="Therapist"]');

    for (let i = 0; i < dbox.length; i++) {
      // alert(i);
      dbox[i].addEventListener("change", iconchange);
    }

    const cbox = document.querySelectorAll('[name="Specialization"]');

    for (let i = 0; i < cbox.length; i++) {
      //alert(i);
      cbox[i].addEventListener("change", GetTherapist);

    }
    const plusaddbox = document.querySelectorAll('[name="Add_therapist_btn"]');

    for (let i = 0; i < plusaddbox.length; i++) {
      //alert(i);
      plusaddbox[i].addEventListener("click", addTherapistFunction);
    }
    const selectrefershbox = document.querySelectorAll('[name="switch"]');

    for (let i = 0; i < selectrefershbox.length; i++) {
      // alert(i);
      selectrefershbox[i].addEventListener("click", switchiconFunction);
    }

    //alert("cal");
    const cal = document.querySelectorAll('[name="Therapist"]');
    console.log(cal);
    for (let i = 0; i < cal.length; i++) {
      //alert(i);
      cal[i].addEventListener("change", getEventsDB2);
    }


  }
  addTherapist.addEventListener('click', addTherapistFunction);
</script>

<script>
  function getEventsDB(e) {


    //alert("hii");
    var co_two = $('#Therapist1').val();
    //alert(co_two);
    if (co_two != null) {
      // $('#co_two').show();
      //$('#co_two').hide();
      data1 = [];
      $('#calendar1').html('');
      //alert(data1);
      var calendar = new Calendar('#calendar1', data1);
      // alert("innn");
      $('#co_two').show();
    } else {
      //alert("co_");
      $('#co_two').show();
    }
  }

  function getEventsDB2(e) {
    //alert("jio");
    data1 = [];
    $('#calendar1').html('');

    var calendar = new Calendar('#calendar1', data1);
    e.target.nextElementSibling.style.display = "block";
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
</script>

<script>
  setTimeout(func, 3000);

  function func() {
    let url = new URL(window.location.href)

    let message = url.searchParams.get("message5");

    if (message != null) {
      var send = document.getElementById('sent').innerText = '';
      var sent = document.getElementById('sent').innerText = 'Sent';
      // var sent=document.getElementById('sent1').innerText='sent';

      const edit = document.querySelectorAll('.edit');

      for (let i = 0; i < edit.length; i++) {
        // alert(i);
        edit[i].title = "Reschedule";
      }

      document.getElementById('sendbutton').style.display = 'none';

      Swal.fire({
        title: "Success",
        text: "Session Updated Successfully",
        icon: "success",
      });
      window.history.pushState("object or string", "Title", "/therapist/initation/");



    }
  };
</script>


<script>
  setTimeout(func, 3000);

  function func() {
    let url = new URL(window.location.href)

    let message = url.searchParams.get("message6");

    if (message != null) {
      var send = document.getElementById('sent').innerText = '';
      var sent = document.getElementById('reviewsaved').innerText = 'Sent';
      // var sent=document.getElementById('sent1').innerText='sent';

      const edit = document.querySelectorAll('.edit1');

      for (let i = 0; i < edit.length; i++) {
        // alert(i);
        edit[i].title = "Reschedule";
      }


      document.getElementById('reviewsend').style.display = 'none';

      Swal.fire({
        title: "Success",
        text: "Monthly Review Meeting Updated Successfully",
        icon: "success",
      });
      window.history.pushState("object or string", "Title", "/therapist/initation/");



    }
  };
</script>



<script>
  setTimeout(func, 3000);

  function func() {
    let url = new URL(window.location.href)

    let message = url.searchParams.get("message7");

    if (message != null) {
      var send = document.getElementById('sent').innerText = '';
      var sent = document.getElementById('therapistreviewsaved').innerText = 'Sent';
      // var sent=document.getElementById('sent1').innerText='sent';
      const edit = document.querySelectorAll('.edit2');

      for (let i = 0; i < edit.length; i++) {
        // alert(i);
        edit[i].title = "Reschedule";
      }

      document.getElementById('sendreview').style.display = 'none';

      Swal.fire({
        title: "Success",
        text: "Monthly Review Meeting Updated Successfully",
        icon: "success",
      });
      window.history.pushState("object or string", "Title", "/therapist/initation/");



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
        text: "Monthly Review Meeting Sent Successfully",
        icon: "success",
      });
    }
  };
</script>

<script>
  setTimeout(func, 2000);

  function func() {
    let url = new URL(window.location.href)

    let message = url.searchParams.get("message3");

    if (message != null) {
      Swal.fire({
        title: "Success",
        text: "Monthly Review Meeting Saved Successfully",
        icon: "success",
      });
    }
  };
</script>







@endsection