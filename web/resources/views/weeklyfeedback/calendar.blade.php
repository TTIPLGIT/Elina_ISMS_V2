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

  .main-content {
    padding-top: 55px !important;
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
</style>
<style>
  .week5 {
    background-color: grey !important;
    color: white !important;
  }
.breadcrumb{
   padding:0px !important;
   margin: 0px !important;

}

</style>

<div class="main-content" style="position:absolute !important; z-index: -1!important; ">

  <!-- Main Content -->
  <section class="section">


    <div class="section-body mt-1">

      {{ Breadcrumbs::render('calendar') }}

      <h5 class="text-center" style="color:darkblue">Weekly Feedback </h5>
     

      

      <div class="row">

        <div class="col-12">

          <div class="card">
            
            <div class="card-body" style="padding-bottom: 0px !important;padding-top: 9px;">
              <div class="box-header with-border">
                @csrf

                <div class="row is-coordinate">
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

                  <div class="col-md-4">
                    <div class="form-group ">
                      <label class="control-label">IS Co-ordinator<span class="error-star" style="color:red;">*</span></label>
                      <div style="display: flex;">
                        <input class="form-control default" type="text" id="is_coordinator1" name="is_coordinator1" placeholder="Child ID" autocomplete="off" value="Robert" style="background-color:white!important;" readonly>
                        <!-- <select class="form-control" id="is_coordinator1" name="is_coordinator1" onchange="iscoordinatorfn(event)" required>
                          <option>Select-IS-Coordinator</option>
                          <option value="131">Robert</option>


                        </select> -->
                        <button style="display: none;" id="co_one" title="Availability Calendar" class="btn" data-toggle="modal" data-target="#calModal" type="button">
                          <i style="color: blue;font-size: 20px;" class="fa fa-calendar" aria-hidden="true"></i></button>
                      </div>
                      <input type="hidden" id="is_coordinator1old">
                      <input type="hidden" id="is_coordinator1current">
                    </div>
                  </div>


                  <div class="col-md-4">
                    <div class="form-group">
                      <label class="control-label">Therapist<span class="error-star" style="color:red;">*</span></label>
                      <div style="display: flex;">
                        <input class="form-control default" type="text" id="is_therapist" name="is_therapist" autocomplete="off" value="Malini" style="background-color:white!important;" readonly>
                        <!-- <select class="form-control" id="is_coordinator2" name="is_coordinator2" onchange="iscoordinatorfn(event)" required>
                          <option>Select-Therapist</option>
                          <option value="134">Malini</option>
                        </select> -->
                        <button style="display: none;" id="co_two" title="Availability Calendar" class="btn" data-toggle="modal" data-target="#calModal2" type="button">
                          <i style="color: blue;font-size: 20px;" class="fa fa-calendar" aria-hidden="true"></i></button>
                      </div>
                      <input type="hidden" id="is_coordinator2old">
                      <input type="hidden" id="is_coordinator2current">
                    </div>
                  </div>
                  <div class="form-group row">
                    <div class="col-md-4">
                      <div class="form-group">
                        <label class="control-label">Duration<span class="error-star" style="color:red;">*</span></label>
                        <input class="form-control default" type="text" id="duration" name="duration" maxlength="20" value="Week3" style="background-color:white!important;" autocomplete="off" required readonly>
                      </div>
                    </div>
                    <div class="col-md-4">
                      <div class="form-group">
                        <label class="col-form-label">Start Date <span class="error-star" style="color:red;">*</span></label>
                        <input type='date' class="form-control" id='meeting_startdate' name="meeting_startdate" title="Week Start Date" value="2023-01-23" disabled="" required>
                      </div>
                    </div>

                    <div class="col-md-4">
                      <div class="form-group">
                        <label class="col-form-label">End Date<span class="error-star" style="color:red;">*</span></label>
                        <input type='date' class="form-control" id="meeting_enddate" name="meeting_enddate" title="Week End Date" value="2023-01-29" disabled="" required>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <br>
          <div class="offset-9 col-3">

          <a type="button" onclick="send()" id="submitbutton" class="btn btn-labeled btn-succes" title="Sent" style="background-color:green !important;color:white !important;">
      <span class="btn-label" style="font-size:13px !important;"><i class="fa fa-calendar" ></i></span>Monthly Objectives</a>
      </div>
          <div class="col-12" id="weekly">
            <div class="card">
              <div class="card-body" style="background-color:#008eff99 !important;padding-top: 0px; padding-bottom: 0px;">
                <div class="row">
                  <div class="col-lg-12 text-center">
                    <h4 style="color:darkblue;"></h4>
                  </div>
                </div>
                <button id="calender_show" href="#addModal" style="display: none;" data-toggle="modal" data-target="#addModal" class="btn btn-primary" title="View" data-toggle="modal" data-target="#templates" style="margin-inline:5px"><i class="fa fa-bars" style="color:white!important"></i></button>


                <div class="table-wrapper">
                  <div class="table-responsive  p-3">
                    <table class="table table-bordered ">
                      <thead>
                        <tr>
                          <th colspan="4">Weeks</th>

                        </tr>
                      </thead>
                      <tbody>
                        <tr>
                          <td class="" style="background-color:limegreen !important;color:white !important;">Week1(Nov 27-Dec 03)
                            <div class="tablesize" style="width: 50px;">
                              <div class="fc-event-container" style="width: 164px !important;padding-left: 39px !important;">
                                <a class="fc-day-grid-event fc-h-event fc-event fc-start fc-end fc-draggable fc-resizable" href="/weekly/therapistquestion/new/13" style="background-color:blue;border-color:blue;text-align:center !important;">
                                  <div class="fc-content"> <span class="fc-title"> 27/27</span></div>
                                  <div class="fc-resizer fc-end-resizer"></div>
                                </a>
                              </div>
                            </div>
                          </td>


                          <td class="" style="background-color:limegreen !important;color:white !important;">Week2(Dec 04-Dec 10)
                            <div class="tablesize" style="width: 50px;">
                              <div class="fc-event-container" style="width: 164px !important;padding-left: 39px !important;">
                                <a class="fc-day-grid-event fc-h-event fc-event fc-start fc-end fc-draggable fc-resizable" href="/weekly/therapistquestion/new/13" style="background-color:blue;border-color:blue;text-align:center !important;">
                                  <div class="fc-content"> <span class="fc-title"> 27/27</span></div>
                                  <div class="fc-resizer fc-end-resizer"></div>
                                </a>
                              </div>
                              
                            </div>
                          </td>
                          <td class="" style="background-color:limegreen !important;color:white !important;">Week3(Dec 11-Dec 17)
                            <div class="tablesize" style="width: 50px;">
                              <div class="fc-event-container" style="width: 164px !important;padding-left: 39px !important;">
                                <a class="fc-day-grid-event fc-h-event fc-event fc-start fc-end fc-draggable fc-resizable" href="/weekly/therapistquestion/new/13" style="background-color:blue;border-color:blue;text-align:center !important;">
                                  <div class="fc-content"> <span class="fc-title">27/27</span></div>
                                  <div class="fc-resizer fc-end-resizer"></div>
                                </a>
                              </div>
                             
                            </div>
                          </td>
                          <td class="" style="background-color:limegreen !important;color:white !important;">Week4(Dec 18-Dec 24)
                            <div class="tablesize" style="width: 50px;">
                              <div class="fc-event-container" style="width: 164px !important;padding-left: 39px !important;">
                                <a class="fc-day-grid-event fc-h-event fc-event fc-start fc-end fc-draggable fc-resizable" href="/weekly/therapistquestion/new/13" style="background-color:blue;border-color:blue;text-align:center !important;">
                                  <div class="fc-content"> <span class="fc-title">27/27</span></div>
                                  <div class="fc-resizer fc-end-resizer"></div>
                                </a>
                              </div>
                             
                            </div>
                          </td>
                        </tr>
                        <tr>
                        <td class="week5" >Week5(Dec 25-Dec 31)</td>


                          <td class="week5" >Week6(January)</td>

                          <td class="week5" >Week7(January)</td>
                          <td class="week5" >Week8(January)</td>
                        </tr>
                        <tr>
                          <td class="week5">Week9(Feburary)</td>

                          <td class="week5">Week10(Feburary)</td>

                          <td class="week5">Week11(Feburary)</td>
                          <td class="week5">Week12(Feburary)</td>
                        </tr>
                        <tr>
                          <td class="week5">Week13(March)</td>

                          <td class="week5">Week14(March)</td>

                          <td class="week5">Week15(March)</td>

                          <td class="week5">Week16(March)</td>
                        </tr>

                        <tr>
                          <td class="week5">Week17(April)</td>

                          <td class="week5">Week18(April)</td>

                          <td class="week5">Week19(April)</td>

                          <td class="week5">Week20(April) </td>


                        </tr>
                        <tr>
                          <td class="week5">Week21(May)</td>


                          <td class="week5">Week22(May)</td>

                          <td class="week5">Week23(May)</td>

                          <td class="week5">Week24(May)</td>
                        </tr>
                        <tr>
                          <td class="week5">Week25(June)</td>
                          <td class="week5">Week26(June) </td>
                          <td class="week5">Week27(June)</td>
                          <td class="week5">Week28(June)</td>
                        </tr>
                        <tr>
                          <td class="week5">Week29(July)</td>

                          <td class="week5">Week30(July)</td>

                          <td class="week5">Week31(July) </td>
                          <td class="week5">Week32(July)</td>
                          <!-- <td class="" style="background-color:grey !important;color:white !important;">Month5(April)</td>

                          <td class="" style="background-color:grey !important;color:white !important;">Month6(June)</td>
                          <td class="" style="background-color:grey !important;color:white !important;">Month7(July)</td>
                          <td class="" style="background-color:grey!important;color:white !important;">Month8(August)</td> -->
                        </tr>


                      </tbody>
                    </table>
                   
                  </div>
                </div>
              </div>
            </div>
            <div class="col-md-12  text-center" style="padding-top: 1rem;">



<a type="button" class="btn btn-labeled back-btn" title="Back" href="{{ route('monthlyobjective.index') }}" style="color:white !important">
  <span class="btn-label" style="font-size:13px !important;"><i class="fa fa-arrow-left"></i></span> Back</a>

</div>
          </div>
  </section>
</div>

<script>
  function send()

  {
    window.location.href = "/monthly/viewcal";
  }
</script>







<style>
  .specificdate {
    background-color: orangered;
  }
</style>

@endsection