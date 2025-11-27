@extends('layouts.adminnav')
<script type="text/javascript" src="https://cdn.rawgit.com/t4t5/sweetalert/v0.2.0/lib/sweet-alert.min.js"></script>

@section('content')
<style>
  #frname {
    color: red;
  }
  
  .is-coordinate{
    justify-content: center;
  }

  .centerid {
    width: 100%;
    text-align: center;
  }

  .form-control
    {
        background-color: rgb(128 128 128 / 34%) !important;
    }
</style>

<div class="main-content">

  <!-- Main Content -->
  <section class="section">

  {{ Breadcrumbs::render('therapistreviewshow',1) }}
    <div class="section-body mt-1">
      <h5 class="text-center" style="color:darkblue">Monthly Therapist Review Meeting Invite View</h5>
      <div class="row">
        <div class="col-12">

          <div class="card">
            <div class="card-body">
            
              <form method="POST" action="{{ route('ovm1.store') }}">
          
                @csrf
                <div class="row is-coordinate">
                  <div class="col-md-4">
                    <div class="form-group">
                      <label class="control-label">Enrollment ID</label>
                      <input class="form-control" name="enrollment_id" value="EN/2022/12/025" placeholder="Enrollment ID" required>
                    </div>
                  </div>


                  <div class="col-md-4">
                    <div class="form-group">
                      <label class="control-label">Child ID</label>
                      <input class="form-control" type="text" id="child_id" name="child_id"  value="CH/2022/025" disabled="" placeholder="OVM1 Meeting" required autocomplete="off">
                    </div>
                  </div>
                  


                  <div class="col-md-4">
                    <div class="form-group">
                      <label class="control-label">Child Name</label>
                      <input class="form-control" type="text" id="child_name" name="child_name"  value="Kaviya" disabled="" placeholder="Enter Name" required autocomplete="off">
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group " >
                      <label class="control-label">IS Co-ordinator-1</label>
                      <input class="form-control" type="text" id="is_coordinator" name="is_coordinator"  value="Robert" disabled=""required autocomplete="off">


                    </div>
                  </div>

                  <div class="col-md-4 sp1">
                      <div class="form-group">
                        <label class="control-label required">Specialization</label>
                        <input class="form-control" type="text" id="Specialization" name="Specialization"  value="Speech Therapist" disabled=""required autocomplete="off">
                      </div>
                    </div>

                  
                
                  <div class="col-md-4">
                    <div class="form-group">
                      <label class="control-label">Therapist</label>
                      <input class="form-control" type="text" id="Therapist" name="Therapist"  value="Malini" disabled=""required autocomplete="off">
                    </div>
                  </div>

                  <div class="col-md-4 sp1">
                      <div class="form-group">
                        <label class="control-label required">Specialization</label>
                        <input class="form-control" type="text" id="Specialization" name="Specialization"  value="Occupational Therapist" disabled=""required autocomplete="off">
                      </div>
                    </div>

                  
                
                  <div class="col-md-4">
                    <div class="form-group">
                      <label class="control-label">Therapist</label>
                      <input class="form-control" type="text" id="Therapist" name="Therapist"  value="robert" disabled=""required autocomplete="off">
                    </div>
                  </div>

                  



                </div>
                </div>
                </div>
                </div>
                <br>
            



                


         


                <div class="row">
                  <div class="col-12">

                    <div class="card">
                      <div class="card-body">

                        <div class="form-group row" style="margin-bottom: 5px;">
                          <label class="col-sm-2 col-form-label">To</label>
                          <div class="col-sm-4">

                          <input class="form-control" type="text" id="meeting_to" name="meeting_to" value="malini12@gmail.com" disabled="" placeholder="" required autocomplete="off">
                            
                          </div>
                          <div class="col-md-2">
                          </div>
                          <div class="col-md-2">
                            <label class="control-label centerid">Status</label> <br>
                            <input class="form-control" type="text" id="meeting_status" name="meeting_status" value="Saved" disabled="" placeholder="" required autocomplete="off">
                          </div>



                        </div>

                        <div class="form-group row" style="margin-bottom: 5px;">
                                    <label class="col-sm-2 col-form-label">CC<span class="error-star" style="color:red;">*</span></label>
                                    <div class="col-sm-4">

                                        <input class="form-control" type="text" id="meeting_to" name="meeting_to" placeholder="Email Id" value="robert@gmail.com" disabled="" required autocomplete="off">


                                    </div>
                                </div>
                                <br>



                        <div class="form-group row">
                          <label class="col-sm-2 col-form-label">Subject</label>
                          <div class="col-sm-4">
                            <input class="form-control" type="text" id="meeting_subject" name="meeting_subject"  value="Review Meeting" disabled="" placeholder="ORM Meeting" required autocomplete="off">
                          </div>

                        </div>


                        <div class="form-group row">
                          <label class="col-sm-2 col-form-label">Location</label>
                          <div class="col-sm-4">
                            <input class="form-control" type="text" id="meeting_location" name="meeting_location"  value="Chennai" disabled="" placeholder="Enter Location" required autocomplete="off">
                          </div>


                        </div>

                        <div class="form-group row">
                          <label class="col-sm-2 col-form-label">Start Date and Time</label>
                          <div class="col-sm-4">

                            <input type='date' class="form-control" id='meeting_startdate' name="meeting_startdate" value="2023-01-23" disabled="" required >

                          </div>
                          <div class="col-sm-2">
                            <div class="content">
                              <input class="form-control" type="time" id="meeting_starttime" name="meeting_starttime" value="10:00:00" disabled="" required >
                            </div>

                          </div>

                        </div>



                        <div class="form-group row">
                          <label class="col-sm-2 col-form-label">End Date and Time</label>
                          <div class="col-sm-4">
                            <input type='date' class="form-control" id="meeting_enddate" name="meeting_enddate" value="2023-01-23" required disabled="" placeholder="MM/DD/YYYY">
                          </div>
                          <div class="col-sm-2">

                            <div class="content">
                              <input class="form-control" type="time" id="meeting_endtime" name="meeting_endtime" value="11:00:00" disabled="" required>
                            </div>
                            <br>

                          </div>
                          <div class="col-lg-12">
                            <div class="form-group">
                            <label class="col-form-label">Description</label>

                            <textarea class="form-control" id="description" name="meeting_description" value="ORM Meeting" readonly>Kindly Attend the Review Meeting</textarea>                             
                            </div>
                          </div>

                        </div>
                        <!-- <div class="row text-center">
                          <div class="col-md-12">

                            <button type="submit" class="btn btn-warning">Save</button>
                            <button type="" class="btn btn-success">Send</button>
                            <button type="" class="btn btn-danger">Cancel</button>
                          </div>
                        </div> -->
                      </div>
                    </div>
                  </div>
                </div>

              </form>

            
          
        </div>
      </div>




      <br>

      <div class="row text-center">
                <div class="col-md-12">
                    <a type="button" class="btn btn-labeled back-btn" title="Back" href="{{route('Therapistreviewinvite')}}" style="color:white !important">
                        <span class="btn-label" style="font-size:13px !important;"><i class="fa fa-arrow-left"></i></span> Back</a>
                </div>
            </div>

    </div>
  </section>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/tinymce/4.5.6/tinymce.min.js"></script>
<script src="http://cdnjs.cloudflare.com/ajax/libs/tinymce/4.5.6/jquery.tinymce.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.26.0/moment.min.js"></script>
<script type="text/javascript">
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
  }
    );  
  
</script>

























@endsection