@extends('layouts.adminnav')

@section('content')
<style>
  #frname {
    color: red;
  }

  .centerid {
    width: 100%;
    text-align: center;
  }

  .paymentdetails {
    color: darkblue;
    padding-top: 1rem;
    margin: auto;
    justify-content: center;
  }

  .payinitiate {
    margin: auto;
  }

  .form-note {
    width: 30%;
    display: flex;
    justify-content: center;
    margin: auto;
  }

  .control-notes {
    display: flex;
    justify-content: center;
    font-weight: 800 !important;
    color: #34395e !important;
    font-size: 15px !important;
  }

  .scroll_flow_class {
    padding: 1rem !important;
    box-shadow: 0 2px 3px 3px rgb(0 0 0 / 14%), 0 1px 5px 0 rgb(0 0 0 / 12%), 0 3px 1px -2px rgb(0 0 0 / 20%);
    -webkit-transition: .5s all ease;
    -moz-transition: .5s all ease;
    transition: .5s all ease;
    overflow-y: scroll;
    height: 150px !important;
  }

  /* .modal-backdrop.show
  {
    display: none !important;
  } */

  /* #invite{
    display: none;
  } */
  .commentslabel {
    font-weight: 800;
    color: #34395e;
    font-size: 15px;
    letter-spacing: .5px;
  }
</style>

<div class="main-content" style="min-height:'60px'">
  {{ Breadcrumbs::render('child_video_upload.child_create', 1) }}


  <!-- Main Content -->
  <section class="section">


    <div class="section-body mt-1">
      <h5 class="text-center" style="color:darkblue">Child Video Upload</h5>

      @csrf
      <div class="row">
        <div class="col-12">

          <div class="card">
            <div class="card-body">



              <div class="row">
                <div class="col-md-6">
                  <div class="form-group">
                    <label class="control-label">Activity Name</label><span class="error-star" style="color:red;">*</span>
                    <input class="form-control" type="text" id="activity_id" name="activity_id" value="Activity Set-1" autocomplete="off" readonly>
                  </div>
                </div>

                <div>
                  <div>
                    <div>
                      <div><strong>&nbsp; &nbsp; &nbsp;General Instruction:</strong></div>
                      <div>&nbsp;</div>
                    </div>
                    &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; 1. Please attempt all activities as much as possible. Do not worry about completion or perfection.<br>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; 2. Please keep the original lighting and sounds. Do not use any filters before sending.<br>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; 3. Please involve siblings/the other parent in case the activity requires interaction.<br>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; 4. Please use any natural/normal language that you use at home while doing the activity with your child.<br>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; 5. We suggest shooting the video candidly as much as possible, as the child may become conscious.
                  </div>
                </div>

              </div>




            </div>
          </div>
        </div>






        <div class="row activity-section" id="act_1">
          <div class="col-12" style="padding-top: 45px;">



            <div class="card-body">
              <div class="table-wrapper">
                <div class="table-responsive">
                  <table class="table table-bordered" id="alignq1">
                    <thead>
                      <tr>
                        <th>S.No</th>
                        <th>Activity Description</th>
                        <th width="30%">Instruction</th>
                        <th>Status</th>
                        <th>Action</th>
                      </tr>
                    </thead>
                    <tbody>

                      <tr>
                        <td>1</td>
                        <td>Speak about any object or puzzle</td>
                        <td>Please click on this
                          <link> to view and complete the activity
                        </td>
                        <td>Completed</td>



                        <td>
                          <a href="#ViewModal" data-toggle="modal" data-target="#ViewModal1" class="btn btn-info" title="View" data-toggle="modal" data-target="#templates" style="margin-inline:5px"><i class="fa fa-eye" style="color:white!important"></i></a>
                          <!-- <a href="#editModal" data-toggle="modal" data-target="#editModal1" class="btn btn-warning" title="View" data-toggle="modal" data-target="#templates" style="margin-inline:5px">Re Send</a> -->

                          <!-- <a href="#cuModal1" class="btn btn-success" data-toggle="modal" title="View" style="margin-inline:5px"><i class="fa fa-pencil"></i></a> -->
                        </td>

                      </tr>
                      <tr>
                        <td class="sorting_1">2</td>
                        <td>Rolling and kicking a ball</td>
                        <td></td>
                        <td>New</td>
                        <td>
                          <a href="#cuModal1" class="btn btn-success" data-toggle="modal" title="View" style="margin-inline:5px"><i class="fa fa-pencil"></i></a>

                      </tr>
                      <tr>
                        <td class="sorting_1">3</td>
                        <td>Scooping pulses / rice/ sugar from a box or container</td>
                        <td></td>
                        <td>Rejected</td>
                        <td>
                          <a href="#editModal" data-toggle="modal" data-target="#editModal1" class="btn btn-warning" title="View" style="margin-inline:5px">Re Send</a>
                        </td>

                      </tr>
                      <input type="hidden" class="cfn" id="fn" value="0">
                    </tbody>
                  </table>
                </div>
              </div>
            </div>


          </div>
        </div>

        <div class="row activity-section" id="act_2">
          <div class="col-12" style="padding-top: 45px;">



            <div class="card-body">
              <div class="table-wrapper">
                <div class="table-responsive">
                  <table class="table table-bordered" id="alignq2">
                    <thead>
                      <tr>
                        <th>S.No</th>
                        <th>Activity Description</th>
                        <th width="30%">Instruction</th>
                        <th>Status</th>
                        <th>Action</th>
                      </tr>
                    </thead>
                    <tbody>

                      <tr>
                        <td>1</td>
                        <td>Shoe lacing activity</td>
                        <td>Please click on this
                          <link> to view and complete the activity
                        </td>
                        <td>Completed</td>



                        <td>
                          <a href="#ViewModal" data-toggle="modal" data-target="#ViewModal1" class="btn btn-info" title="View" data-toggle="modal" data-target="#templates" style="margin-inline:5px"><i class="fa fa-eye" style="color:white!important"></i></a>
                          <!-- <a href="#editModal" data-toggle="modal" data-target="#editModal1" class="btn btn-warning" title="View" data-toggle="modal" data-target="#templates" style="margin-inline:5px">Re Send</a> -->

                          <!-- <a href="#cuModal1" class="btn btn-success" data-toggle="modal" title="View" style="margin-inline:5px"><i class="fa fa-pencil"></i></a> -->
                        </td>

                      </tr>
                      <tr>
                        <td class="sorting_1">2</td>
                        <td>Colour/paint the given Mandala design (OR) Create own mandala using template.
                        </td>
                        <td></td>
                        <td>New</td>
                        <td>
                          <a href="#cuModal1" class="btn btn-success" data-toggle="modal" title="View" style="margin-inline:5px"><i class="fa fa-pencil"></i></a>

                      </tr>
                      <tr>
                        <td class="sorting_1">3</td>
                        <td>Create a doodle.</td>
                        <td></td>
                        <td>Rejected</td>
                        <td>
                          <a href="#editModal" data-toggle="modal" data-target="#editModal1" class="btn btn-warning" title="View" style="margin-inline:5px">Re Send</a>
                        </td>

                      </tr>
                      <input type="hidden" class="cfn" id="fn" value="0">
                    </tbody>
                  </table>
                </div>
              </div>
            </div>


          </div>
        </div>
        <div class="row activity-section" id="act_3">
          <div class="col-12" style="padding-top: 45px;">



            <div class="card-body">
              <div class="table-wrapper">
                <div class="table-responsive">
                  <table class="table table-bordered" id="alignq3">
                    <thead>
                      <tr>
                        <th>S.No</th>
                        <th>Activity Description</th>
                        <th width="30%">Instruction</th>
                        <th>Status</th>
                        <th>Action</th>
                      </tr>
                    </thead>
                    <tbody>

                      <tr>
                        <td>1</td>
                        <td>Read a newspaper</td>
                        <td>you can choose a small part from your favourite section
                        </td>
                        <td>Completed</td>



                        <td>
                          <a href="#ViewModal" data-toggle="modal" data-target="#ViewModal1" class="btn btn-info" title="View" data-toggle="modal" data-target="#templates" style="margin-inline:5px"><i class="fa fa-eye" style="color:white!important"></i></a>
                          <!-- <a href="#editModal" data-toggle="modal" data-target="#editModal1" class="btn btn-warning" title="View" data-toggle="modal" data-target="#templates" style="margin-inline:5px">Re Send</a> -->

                          <!-- <a href="#cuModal1" class="btn btn-success" data-toggle="modal" title="View" style="margin-inline:5px"><i class="fa fa-pencil"></i></a> -->
                        </td>

                      </tr>
                      <tr>
                        <td class="sorting_1">2</td>
                        <td>Talking about current events for 1 min.</td>
                        <td></td>
                        <td>New</td>
                        <td>
                          <a href="#cuModal1" class="btn btn-success" data-toggle="modal" title="View" style="margin-inline:5px"><i class="fa fa-pencil"></i></a>

                      </tr>
                      <tr>
                        <td class="sorting_1">3</td>
                        <td>Folding clothes</td>
                        <td></td>
                        <td>Rejected</td>
                        <td>
                          <a href="#editModal" data-toggle="modal" data-target="#editModal1" class="btn btn-warning" title="View" style="margin-inline:5px">Re Send</a>
                        </td>

                      </tr>
                      <input type="hidden" class="cfn" id="fn" value="0">
                    </tbody>
                  </table>
                </div>
              </div>
            </div>


          </div>
        </div>

      </div>
      <div class="col-md-12  text-center" style="padding-top: 1rem;">
        <a type="button" class="btn btn-labeled btn-info" id="Previous1" title="Previous" style="height: 35px;background: blue !important; border-color:blue !important; color:white !important">
          <span class="btn-label" style="font-size:13px !important;"><i class="fa fa-arrow-left"></i></span> Previous Activity</a>
        <a type="button" class="btn btn-labeled back-btn" title="Cancel" href="{{ route('child_video_upload.childindex') }}" style="color:white !important">
          <span class="btn-label" style="font-size:13px !important;"><i class="fa fa-times-circle-o"></i></span> Cancel</a>
        <a type="button" class="btn btn-labeled btn-info" id="Next1" title="Next" style="background: blue !important; border-color:#4d94ff !important; color:white !important;height: 35px;">
          <span class="btn-label" style="font-size:13px !important;">Next Activity</span> <i class="fa fa-arrow-right"></i></a>
      </div>
  </section>
</div>
<!-- Bulk -->
<form action="{{route('child_video_upload.child_create','1')}}" id="bulkStore" method="POST">
  @csrf
  <input class="form-control" type="hidden" id="activity_name" name="activity_name" value="Activity Set-1" readonly>
  <input type="hidden" id="enrollment_id" name="enrollment_id" value="">
  <input type="hidden" id="submit_type" name="submit_type">
  <input type="hidden" id="openID" name="openID">


  <div class="modal fade" id="cuModal1">
    <div class="modal-dialog modal-xl">
      <div class="modal-content">
        <div class="main-contents">
          <section class="section">
            <div class="modal-header bg-primary" style=" background-color: rgb(0 103 172) !important;">
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            </div>
            <div class="modal-body modal-body1" style="background-color: #edfcff !important;">
              <div class="section-body mt-2">
                <div class="row">
                  <div class="card-body" id="card_header">

                    <div class="col-md-12">
                      <div class="form-group">
                        <label class="control-label">Activity Name</label>
                        <input class="form-control" type="text" value="Activity Set-1" readonly>
                      </div>
                    </div>
                    <div class="col-md-12">
                      <div class="form-group">
                        <label class="control-label">Activity Description</label>
                        <input class="form-control" type="text" value="Running" readonly>
                      </div>
                    </div>
                    <div class="col-12" style="display: flex;">
                      <div class="col-md-6">
                        <div class="form-group">
                          <label class="control-label">Video Link</label>
                          <div class="multi-field-wrapper">
                            <div class="multi-fields">


                              <div class="multi-field" style="display: flex;margin-bottom: 5px;">
                                <input class="form-control" type="url" id="video_link1" name="video_link1" autocomplete="off" required value="">
                                <button class="remove-field btn btn-danger pull-right" id="remove-f" type='button'>X </button>
                                &nbsp;
                              </div>


                            </div>
                            <button type="button" class="add-field btn btn-success">Add video</button>
                          </div>
                          <div style="color: rgb(246, 15, 15); display: block;margin: 5px 0px 0px 0px;">Google Drive Link Only</div>
                        </div>
                      </div>
                      <input type="hidden" id="activity_description_id" name="activity_description_id1" value="1">
                      <input type="hidden" id="parent_video_upload_id" name="parent_video_upload_id1" value="1">
                      <input type="hidden" id="current_status" name="current_status1" value="">
                      <input type="hidden" id="save_flag" name="save_flag1" value="1">
                      <div class="col-md-6">
                        <div class="form-group">
                          <label class="control-label">Comments</label>
                          <textarea class="form-control" name="comments1" id="comments"></textarea>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>


                <div class="col-md-12  text-center" style="padding-top: 1rem;">
                  <a type="button" class="btn btn-labeled btn-info" onclick="showModalPrev('2')" id="Previous" title="Previous" style="height: 35px; background: blue !important; border-color: blue !important; color: white !important">
                    <span class="btn-label" style="font-size: 13px !important;"><i class="fa fa-arrow-left"></i></span> Previous
                  </a>
                  <a type="button" onclick="saveBulk('Submit' , '1')" id="submitbuttonbulk" class="btn btn-labeled btn-succes" title="Submit" style="background: green !important; border-color:green !important; color:white !important">
                    <span class="btn-label" style="font-size:13px !important;"><i class="fa fa-check"></i></span>Submit</a>

                  <a type="button" onclick="saveBulk('Save' , '1')" id="submitbuttonbulk" class="btn btn-labeled btn-succes" title="Save" style="background: green !important; border-color:green !important; color:white !important">
                    <span class="btn-label" style="font-size:13px !important;"><i class="fa fa-bookmark-o"></i></span>Save</a>

                  <a type="button" class="btn btn-labeled back-btn" data-dismiss="modal" aria-hidden="true" title="Back" style="color:white !important">
                    <span class="btn-label" style="font-size:13px !important;"><i class="fa fa-arrow-left"></i></span> Back</a>
                  <a type="button" class="btn btn-labeled btn-info" onclick="showModalNext('1')" id="Next" title="Next" style="background: blue !important; border-color: #4d94ff !important; color: white !important; height: 35px;">
                    <span class="btn-label" style="font-size: 13px !important;">Next</span> <i class="fa fa-arrow-right"></i>
                  </a>
                </div>
              </div>
          </section>
        </div>
      </div>
    </div>
  </div>

</form>
<script>
  function showModalNext(id) {
    var id = Number(id);
    $(".modal").modal('hide');
    $("#cuModal" + id).modal();
  }

  function showModalPrev(id) {

    var id = Number(id);
    $(".modal").modal('hide');
    $("#cuModal" + id).modal();
  }

  function saveBulk(type, id) {
    // console.log(id);
    if (type == "Save") {
      document.getElementById('submit_type').value = type;
      document.getElementById('openID').value = id;
      // $("#submitbuttonbulk").addClass("disable-click");
      //document.getElementById('bulkStore').submit();
      $(".modal").modal('hide');
    } else if (type == "Submit") {
      Swal.fire({
          title: "Are you sure?",
          text: "Uploading the video is irreversible. Do you want to proceed?",
          icon: "warning",
          showCancelButton: true,
          confirmButtonColor: "#3085d6",
          cancelButtonColor: "#d33",
          confirmButtonText: "Yes, proceed!",
          cancelButtonText: "Cancel",
        })
        .then((result) => {
          // If the user clicks "Yes" in the Swal.fire confirmation
          if (result.isConfirmed) {
            // Continue with the saveBulk logic
            document.getElementById('submit_type').value = type;
            document.getElementById('openID').value = id;
            // $("#submitbuttonbulk").addClass("disable-click");
            //document.getElementById('bulkStore').submit();
            $(".modal").modal('hide');
          } else {
            // If the user clicks "Cancel" in the Swal.fire confirmation
            // You can add any additional logic here if needed
            console.log("SaveBulk operation canceled");
          }
        });
    }

  }
</script>
<!-- End Bulk -->
<!-- Add -->
<div class="modal fade" id="addModal1">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <div class="main-contents">
        <section class="section">
          <div class="modal-header bg-primary" style=" background-color: rgb(0 103 172) !important;">
            <!-- <h4 class="modal-title">Sail Activity</h4> -->
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          </div>
          <div class="modal-body modal-body1" style="background-color: #edfcff !important;">
            <div class="section-body mt-2">
              <form action="{{route('videocreation.parentstore')}}" id="userregistration1" method="POST">
                @csrf
                <div class="row">
                  <div class="card-body" id="card_header">
                    <div class="col-12" style="display: flex;">
                      <div class="col-md-6">
                        <div class="form-group">
                          <label class="control-label">Video Link</label>
                          <div class="multi-field-wrapper">
                            <div class="multi-fields">
                              <div class="multi-field" style="display: flex;margin-bottom: 5px;">
                                <!-- <input type="text" class="form-control" name="description[]" id="description"> -->
                                <input class="form-control" type="url" id="video_link1" name="video_link[]" autocomplete="off" required>
                                <button class="remove-field btn btn-danger pull-right" id="remove-f" type='button'>X </button>
                                &nbsp;
                              </div>
                            </div>
                            <button type="button" class="add-field btn btn-success">Add video</button>
                          </div>
                          <div style="color: rgb(246, 15, 15); display: block;margin: 5px 0px 0px 0px;">Google Drive Link Only</div>
                        </div>

                        <!-- <div style="color: rgb(246, 15, 15); display: block;">Add your Google Drive Link Only</div> -->
                      </div>

                      <input type="hidden" id="current_status" name="current_status" value="">
                      <input type="hidden" id="activity_description_id" name="activity_description_id" value="1">
                      <input type="hidden" id="parent_video_upload_id" name="parent_video_upload_id" value="1">
                      <div class="col-md-6">
                        <div class="form-group">
                          <label class="control-label">Comments</label>
                          <textarea class="form-control" name="comments" id="comments"></textarea>
                          <!-- <input class="form-control" type="text" id="description_id" name="description_id" autocomplete="off"> -->
                        </div>
                      </div>

                      <!-- <div class="col-md-4">
                    <div class="form-group">
                      <label class="control-label">Status</label><span class="error-star" style="color:red;">*</span>
                      <input class="form-control" type="text" id="status" name="status" autocomplete="off" value="0/10" readonly>
                    </div>
                  </div> -->
                    </div>
                  </div>

                </div>
              </form>
              <div class="col-md-12  text-center" style="padding-top: 1rem;">

                <a type="button" onclick="save('1')" id="submitbutton1" class="btn btn-labeled btn-succes" title="Submit" style="background: green !important; border-color:green !important; color:white !important">
                  <span class="btn-label" style="font-size:13px !important;"><i class="fa fa-check"></i></span>Submit</a>

                <a type="button" class="btn btn-labeled back-btn" data-dismiss="modal" aria-hidden="true" title="Back" style="color:white !important">
                  <span class="btn-label" style="font-size:13px !important;"><i class="fa fa-arrow-left"></i></span> Back</a>
              </div>
            </div>
        </section>
      </div>
    </div>
  </div>
</div>
<!-- End Add -->
<!-- View -->

<div class="modal fade" id="ViewModal1">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <div class="main-contents">
        <section class="section">
          <div class="modal-header bg-primary" style=" background-color: rgb(0 103 172) !important;">
            <!-- <h4 class="modal-title">Sail Activity</h4> -->
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          </div>
          <div class="modal-body" style="background-color: #edfcff !important;">
            <div class="section-body mt-2">
              <form action="" id="userregistration1" method="POST">
                @csrf
                <div class="row">
                  <div class="card-body" id="card_header">
                    <div class="col-12" style="display: flex;">
                      <div class="col-md-6">
                        <div class="form-group">
                          <label class="control-label">Video Link</label>
                          <div style="display: flex;">
                            <input class="form-control" type="text" id="video_link" name="video_link" autocomplete="off" value="https://elinaservices.com/">
                            <a class="btn btn-link" title="show" target="_blank" href=""><i class="fas fa-eye" style="color:green"></i></a>
                            <!-- <div style="color: rgb(246, 15, 15); display: block;margin: 5px 0px 0px 0px;">Google Drive Link Only</div> -->
                          </div>

                        </div>
                      </div>
                      <input type="hidden" id="activity_description_id" name="activity_description_id" value="1">`
                      <input type="hidden" id="parent_video_upload_id" name="parent_video_upload_id" value="1">
                      <div class="col-md-6">
                        <label class="control-label commentslabel">Previous Notes </label><br>
                        <div class="form-group scroll_flow_class">
                          <span> Parent (Durairaj) - Completed</span> <br>
                          <span>29/01/2024 10:48:10 AM -Walking</span> <br><br>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </form>
            </div>
        </section>
      </div>
    </div>
  </div>
</div>
<!-- End View -->
<!-- Edit -->


<div class="modal fade editModal1" id="editModal1">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <div class="main-contents">
        <section class="section">
          <div class="modal-header bg-primary" style=" background-color: rgb(0 103 172) !important;">
            <!-- <h4 class="modal-title">Sail Activity</h4> -->
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          </div>
          <div class="modal-body" style="background-color: #edfcff !important;">
            <div class="section-body mt-2">
              <form action="" id="userregistrationa1" method="POST">
                @csrf
                <div class="row">
                  <div class="card-body" id="card_header">
                    <div class="col-12" style="display: flex;flex-wrap: wrap;">
                      <div class="col-md-4">
                        <div class="form-group">
                          <label class="control-label">Activity Name</label>
                          <input class="form-control" type="text" value="Activity Set-1" readonly>
                        </div>
                      </div>
                      <div class="col-md-8">
                        <div class="form-group">
                          <label class="control-label">Activity Description</label>
                          <input class="form-control" type="text" value="Running" readonly>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                          <label class="control-label">Video Link</label>
                          <div class="multi-field-wrapper">
                            <div class="multi-fields">

                              <div class="multi-field" style="display: flex;margin-bottom: 5px;">
                                <!-- <input type="text" class="form-control" name="description[]" id="description"> -->

                                <input class="form-control video_linka1" type="text" id="video_link" name="video_link[]" autocomplete="off" value="http://localhost:60161/child_video_upload/parent_create/1" readonly>


                                <button class="remove-field btn btn-danger pull-right" id="remove-f" type='button'>X </button>
                                &nbsp;
                              </div>

                            </div>
                            <button type="button" class="add-field btn btn-success">Add video</button>
                            <label style="padding: 5px;"> <input type="checkbox" onclick="unable_activity('1')" name="unable" id="unable1" value="1" style="margin-right: 0.3rem!important;">My child unable to do this activity</label>
                          </div>

                          <div style="color: rgb(246, 15, 15); display: block;margin: 5px 0px 0px 0px;">Google Drive Link Only</div>
                        </div>
                        <!-- <div style="color: rgb(246, 15, 15); display: block;">Add your Google Drive Link Only</div> -->
                      </div>

                      <div class="col-md-6">
                        <label class="control-label commentslabel">Previous Notes</label><br>
                        <div class="form-group scroll_flow_class">


                          <span></span> <br>

                          <span></span> <br><br>

                        </div>
                      </div>
                      <div class="w-100"></div>
                      <input type="hidden" id="current_status" name="current_status" value="">
                      <input type="hidden" id="activity_description_id" name="activity_description_id" value="">
                      <input type="hidden" id="parent_video_upload_id" name="parent_video_upload_id" value="1">
                      <div class="col-md-6">
                        <div class="form-group">
                          <label class="control-label">Comments</label>
                          <textarea class="form-control" name="comments" id="comments_rej1"></textarea>
                        </div>
                      </div>
                    </div>
                  </div>

                </div>
              </form>

              <div class="col-md-12  text-center" style="padding-top: 1rem;">
                <a type="button" class="btn btn-labeled btn-info" onclick="showModalPrev1('1')" id="Previous" title="Previous" style="height: 35px; background: blue !important; border-color: blue !important; color: white !important">
                  <span class="btn-label" style="font-size: 13px !important;"><i class="fa fa-arrow-left"></i></span> Previous
                </a>

                <a type="button" onclick="save1('1')" id="editbutton1" class="btn btn-labeled btn-succes" title="Submit" style="background: green !important; border-color:green !important; color:white !important">
                  <span class="btn-label" style="font-size:13px !important;"><i class="fa fa-check"></i></span>Submit</a>

                <a type="button" class="btn btn-labeled back-btn" data-dismiss="modal" aria-hidden="true" title="Back" style="color:white !important">
                  <span class="btn-label" style="font-size:13px !important;"><i class="fa fa-arrow-left"></i></span> Back</a>
                <a type="button" class="btn btn-labeled btn-info" onclick="showModalNext1('1')" id="Next" title="Next" style="background: blue !important; border-color: #4d94ff !important; color: white !important; height: 35px;">
                  <span class="btn-label" style="font-size: 13px !important;">Next</span> <i class="fa fa-arrow-right"></i>
                </a>
              </div>
            </div>
        </section>
      </div>
    </div>
  </div>
</div>
<script>
  $(document).ready(function() {
    $(".modal").on("hidden.bs.modal", function() {
      $(".modal-body1").find('form').trigger('reset');
    });
  });

  function showModalNext1(id) {
    var id = Number(id);
    $(".modal").modal('hide');

    $(".editModal" + id).modal();
  }

  function showModalPrev1(id) {
    var id = Number(id);

    $(".modal").modal('hide');

    $(".editModal" + id).modal();
  }
</script>
<!-- End Edit -->
<script type="text/javascript">
  $.ajaxSetup({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  });

  function myFunction() {
    var enrollment_id = $("select[name='enrollment_id']").val();

    if (enrollment_id != "") {
      $.ajax({
        url: "{{ url('/activityinitiate/ajax') }}",
        type: 'POST',
        data: {
          'enrollment_id': enrollment_id,
          _token: '{{csrf_token()}}'
        }
      }).done(function(data) {
        // var category_id = json.parse(data);
        // console.log(data);

        if (data != '[]') {

          // var user_select = data;
          var optionsdata = "";

          document.getElementById('child_id').value = data[0].child_id;
          document.getElementById('child_name').value = data[0].child_name;
          document.getElementById('initiated_to').value = data[0].child_contact_email;
          document.getElementById('user_id').value = data[0].user_id;
          // console.log(name)


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

  function isValidHttpUrl(string) {
    let url;
    try {
      url = new URL(string);
    } catch (_) {
      return false;
    }
    return url.protocol === "http:" || url.protocol === "https:";
  }

  function save(id) {
    var video_link = $('#video_link' + id).val();
    if (video_link == '') {
      swal.fire("Please Enter Your Video Link", "", "error");
      return false;
    }
    $("#submitbutton" + id).addClass("disable-click");
    document.getElementById('userregistration' + id).submit();
  }

  function unable_activity(val) {

    var content = $('#comments_rej' + val).val();

    if ($('#unable' + val).prop('checked')) {
      $('#comments_rej' + val).val('My child unable to do this activity. ' + content);
    } else {
      content = content.replace('My child unable to do this activity.', '');
      $('#comments_rej' + val).val(content);
    }

  }

  function save1(id) {
    var video_link1 = $('.video_linka' + id).val();
    if (!$('#unable' + id).prop('checked')) {
      if (video_link1 == '') {
        swal.fire("Please Enter Your Video Link", "", "error");
        return false;
      }
    }
    $("#editbutton" + id).addClass("disable-click");
    document.getElementById('userregistrationa' + id).submit();
  }
</script>
<script>
  $('.multi-field-wrapper').each(function() {

    var $wrapper = $('.multi-fields', this);
    // console.log($wrapper);


    $(".add-field", $(this)).click(function(e) {
      $('.multi-field:first-child', $wrapper).clone(true).appendTo($wrapper).find('input').val('').focus().removeAttr('readonly');
      $('#file_field').append('<div class="multi-field" style="display: flex;margin-bottom: 5px;"><input class="form-control" type="url" id="video_link" name="video_link[]" autocomplete="off" required></div>');
    });

    $('.multi-field .remove-field', $wrapper).click(function() {
      if ($('.multi-field', $wrapper).length > 1)
        $(this).parent('.multi-field').remove();

      else alert('This Process cannot be done');

    });
  });
</script>
<!-- Add this script in the <head> or at the end of the <body> section -->
<script>
  $(document).ready(function() {
    var currentActivity = 1; // Variable to keep track of the current activity

    // Initial setup
    updateActivityName(currentActivity);
    // Hide all sections except the first one initially
    $('.activity-section').hide();

    // Show the first section
    $('#act_1').show();

    // Hide the "Previous" button initially
    $('#Previous1').hide();

    // Event handler for the "Next" button
    $('#Next1').on('click', function() {
      var currentSection = $('.activity-section:visible');
      var nextSection = currentSection.next('.activity-section');

      if (nextSection.length > 0) {
        currentSection.hide();
        nextSection.show();
        // Update the activity name based on the current section
        currentActivity++;
        updateActivityName(currentActivity);

        // Show the "Previous" button
        $('#Previous1').show();

        // If it's the last section, hide the "Next" button
        if (!nextSection.next('.activity-section').length) {
          $('#Next1').hide();
        }
      }
    });

    // Event handler for the "Previous" button
    $('#Previous1').on('click', function() {
      var currentSection = $('.activity-section:visible');
      var prevSection = currentSection.prev('.activity-section');

      if (prevSection.length > 0) {
        currentSection.hide();
        prevSection.show();

        currentActivity--;
        updateActivityName(currentActivity);
        // Show the "Next" button
        $('#Next1').show();

        // If it's the first section, hide the "Previous" button
        if (!prevSection.prev('.activity-section').length) {
          $('#Previous1').hide();
        }
      }
    });
  });

  // Function to update the activity name
  function updateActivityName(activityNumber) {
    var activityName = 'Activity Set-' + activityNumber;
    $('#activity_id').val(activityName);
  }
</script>


























@endsection