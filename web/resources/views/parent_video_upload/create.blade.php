@extends('layouts.parent')

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
  {{ Breadcrumbs::render('parent_video_upload.parent_create', $rows[0]['activity_description_id']) }}
  @if (session('success'))
  <input type="hidden" name="session_data" id="session_data" class="session_data" value="{{ session('success') }}">
  <script type="text/javascript">
    window.onload = function() {
      var message = $('#session_data').val();
      Swal.fire('Success!', message, 'success');
    }
  </script>
  @elseif(session('info'))
  <input type="hidden" name="session_data" id="session_data1" class="session_data" value="{{ session('info') }}">
  <input type="hidden" name="session_page" id="session_page" class="session_page" value="{{ session('page') }}">
  <script type="text/javascript">
    window.onload = function() {
      var message = $('#session_data1').val();
      var session_page = $('#session_page').val();

      // Role - Parent :: The Modal Restore after save has been removed as per the request by Elina Team; on 28th Oct 2025;
      // "Activity upload - after saving the video it says video upload success, after that why does the same activity window appear again?";

      // swal.fire("Success", message, "success").then(function() {
      //   $("#cuModal" + session_page).modal('show');
      // })

      Swal.fire('Success!', message, 'info');
    }
  </script>
  @endif
  <!-- Main Content -->
  <section class="section">


    <div class="section-body mt-1">
      <div class="col-lg-12 text-center">
        <h4 class="screen-title"> Parent Video Upload</h4>
      </div>

      @csrf
      <div class="row">
        <div class="col-12">

          <div class="card">
            <div class="card-body">



              <div class="row">
                <div class="col-md-6">
                  <div class="form-group">
                    <label class="control-label">Activity Name</label><span class="error-star" style="color:red;">*</span>
                    <input class="form-control" type="text" id="activity_id" name="activity_id" value="{{ $rows[0]['activity_name']}}" autocomplete="off" readonly>
                  </div>
                </div>

                <div>{!! $general_instruction !!}</div>

              </div>




            </div>
          </div>
        </div>






        <div class="">
          <div class="" style="padding-top: 45px;">


            <div class="card">
              <div class="card-body">
                <div class="table-wrapper">
                  <div class="table-responsive">
                    <table class="table table-bordered" id="tableList">
                      <thead>
                        <tr>
                          <!-- <th>S.No</th> -->
                          <th>Activity Description</th>

                          <th>Status</th>
                          <th>Instruction</th>
                          <th>Action</th>
                        </tr>
                      </thead>
                      <tbody>
                        @php $cuModaliteration = 0 @endphp
                        @foreach($activitylist as $key=>$row)
                        <tr>
                          <!-- <td>{{ $loop->iteration }}</td> -->
                          <td <?= $row['required'] == 1 ? 'class="required"' : '' ?>>{{ $row['description'] }}</td>

                          @if($row['f2f_flag'] == 1)
                          <td>In-Progress</td>
                          @else
                          @if($row['save_flag'] == 1)
                          <td>Saved</td>
                          @else
                          @if($row['current_status'] == 'Complete')
                          <td>Approved</td>
                          @else
                          <td>{{$row['current_status']}}</td>
                          @endif
                          @endif
                          @endif
                          <td style="text-wrap: wrap">{!! $row['instructionset'] !!}</td>
                          <td>
                            @if($row['current_status'] == 'Re-Sent' || $row['current_status'] == 'Submitted' || $row['current_status'] == 'Close' || $row['current_status'] == 'Complete')
                            <a href="#ViewModal" data-toggle="modal" data-target="#ViewModal{{$row['parent_video_upload_id']}}" class="btn btn-info" title="View" data-toggle="modal" data-target="#templates" style="margin-inline:5px"><i class="fa fa-eye" style="color:white!important"></i></a>
                            @elseif($row['current_status'] == 'Rejected' || $row['current_status'] == 'Reject')
                            <a onclick="newupload('editModal{{$row['parent_video_upload_id']}}' , '{{$row['activity_description_id']}}')" data-toggle="modal" data-target="#editModal{{$row['parent_video_upload_id']}}" class="btn btn-warning" title="View" data-toggle="modal" data-target="#templates" style="margin-inline:5px">Re Send</a>
                            @else
                            @php $cuModaliteration = $cuModaliteration+1; @endphp
                            <a onclick="newupload('cuModal{{$row['activity_description_id']}}' , '{{$row['activity_description_id']}}')" class="btn btn-success" data-toggle="modal" title="View" style="margin-inline:5px"><i class="fas fa-pencil-alt"></i></a>
                            <!-- <a href="#addModal" data-toggle="modal" data-target="#addModal{{$row['parent_video_upload_id']}}" class="btn btn-success" title="View" data-toggle="modal" data-target="#templates" style="margin-inline:5px"><i class="fa fa-plus"></i></span><span style="font-size:15px !important; padding:8px !important">Upload</a> -->
                            @endif
                          </td>
                          <!-- <td><input type="url" id="video_link" name="video_link"></td>
                                <td><input type="text" id="video_link" name="video_link"></td> -->
                          <!-- <td>{{ $row['status']}}</td> -->
                          <!-- <td> -->
                          <!-- <a class="btn btn-link" title="show" href=""><i class="fas fa-eye" style="color:green"></i></a>
                                                                            <a class="btn btn-link" title="Edit" href=""><i class="fas fa-pencil-alt"  style="color: blue !important"></i></a>
                                                                            @csrf -->
                          <!-- <input type="hidden" name="delete_id" id="" value="">
                                                                            <a class="btn btn-link" title="Delete" onclick="return myFunction" class="btn btn-link"><i class="far fa-trash-alt"></i></a> -->
                          <!-- </td> -->
                        </tr>
                        <input type="hidden" class="cfn" id="fn" value="0">
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
      <div class="col-md-12 text-center">
        @if($previous != '')
        <a type="button" href="{{ route('parent_video_upload.parent_create', \Crypt::encrypt($activityNav['firstActivityID'])) }}" class="btn btn-labeled responsive-button button-style step-back-button" title="First Activity">
          <i class="fa fa-fast-backward"></i><span> </span>
        </a>
        <a type="button" href="{{ route('parent_video_upload.parent_create', \Crypt::encrypt($previous)) }}" class="btn btn-labeled responsive-button button-style back-button" title="Previous">
          <i class="fas fa-arrow-left"></i><span> Previous</span>
        </a>
        @endif

        <a type="button" href="{{ route('parent_video_upload.parentindex') }}" class="btn btn-labeled responsive-button button-style cancel-button" title="Cancel">
          <i class="fas fa-times"></i><span> Cancel </span>
        </a>
        @if($next != '')
        <a type="button" href="{{ route('parent_video_upload.parent_create', \Crypt::encrypt($next)) }}" class="btn btn-labeled responsive-button next-button button-style" title="Next">
          <i class="fas fa-arrow-right"></i><span> Next </span></a>
        <a type="button" href="{{ route('parent_video_upload.parent_create', \Crypt::encrypt($activityNav['lastActivityID'])) }}" class="btn btn-labeled responsive-button step-next-button button-style" title="Last Activity">
          <i class="fa fa-fast-forward"></i><span> </span></a>
        @endif
      </div>
  </section>
</div>
<!-- Bulk -->
<form action="{{route('video.parentstore.bulk')}}" id="bulkStore" method="POST">
  @csrf
  <input class="form-control" type="hidden" id="activity_name" name="activity_name" value="{{ $rows[0]['activity_name']}}" readonly>
  <input type="hidden" id="enrollment_id" name="enrollment_id" value="{{$rows[0]['enrollment_id']}}">
  <input type="hidden" id="submit_type" name="submit_type">
  <input type="hidden" id="openID" name="openID">
  <input type="hidden" id="saved_stage" name="saved_stage">
  @php $cuModaliteration1 = 0 @endphp

  @foreach($activitylist_nav as $key=>$row)
  @if($row['current_status'] == 'New')
  @php $cuModaliteration1 = $cuModaliteration1 + 1; $extra = 0 @endphp
  <div class="modal fade" id="cuModal{{$row['activity_description_id']}}">
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
                        <input class="form-control" class="set_name" type="text" value="{{$row['activity_name']}}" readonly>
                      </div>
                    </div>
                    <div class="col-md-12">
                      <div class="form-group">
                        <label class="control-label">Activity Description</label>
                        <input class="form-control activity-description" type="text" value="{{$row['description']}}" readonly>
                      </div>
                    </div>
                    <div class="col-12" style="display: flex;">
                      <div class="col-md-6">
                        <div class="form-group">
                          <label class="control-label">Video Link</label>
                          <div class="multi-field-wrapper">
                            <div class="multi-fields">
                              <!-- <div class="multi-field" style="display: flex;margin-bottom: 5px;">
                                <input class="form-control" type="url" id="video_link{{$row['parent_video_upload_id']}}" name="video_link[{{$row['parent_video_upload_id']}}][]" autocomplete="off" required>
                                <button class="remove-field btn btn-danger pull-right" id="remove-f" type='button'>X </button>
                                &nbsp;
                              </div> -->
                              @if($video_link != [])
                              @foreach($video_link as $data2)
                              @if($row['parent_video_upload_id'] == $data2['parent_video_upload_id'])
                              @php $extra = 1 @endphp
                              <div class="multi-field" style="display: flex;margin-bottom: 5px;">
                                <input class="form-control" type="url" id="video_link{{$row['parent_video_upload_id']}}" name="video_link[{{$row['parent_video_upload_id']}}][]" autocomplete="off" required value="{{$data2['video_link']}}">
                                <button class="remove-field btn btn-danger pull-right" id="remove-f" type='button'>X </button>
                                &nbsp;
                              </div>
                              @endif
                              @endforeach
                              @else
                              @php $extra = 1 @endphp
                              <div class="multi-field" style="display: flex;margin-bottom: 5px;">
                                <input class="form-control" type="url" id="video_link{{$row['parent_video_upload_id']}}" name="video_link[{{$row['parent_video_upload_id']}}][]" autocomplete="off" required>
                                <button class="remove-field btn btn-danger pull-right" id="remove-f" type='button'>X </button>
                                &nbsp;
                              </div>
                              @endif
                              @if($extra == 0)
                              @if(!in_array($vidAll , explode(',', $row['parent_video_upload_id']) ))
                              <div class="multi-field" style="display: flex;margin-bottom: 5px;">
                                <input class="form-control" type="url" id="video_link{{$row['parent_video_upload_id']}}" name="video_link[{{$row['parent_video_upload_id']}}][]" autocomplete="off" required>
                                <button class="remove-field btn btn-danger pull-right" id="remove-f" type='button'>X </button>
                                &nbsp;
                              </div>
                              @endif
                              @endif
                            </div>
                            <button type="button" class="add-field btn btn-success">Add video</button>
                          </div>
                          <div style="color: rgb(246, 15, 15); display: block;margin: 5px 0px 0px 0px;">Google Drive Link Only</div>
                        </div>
                      </div>
                      <input type="hidden" id="activity_description_id" name="activity_description_id[{{$row['parent_video_upload_id']}}]" value="{{$row['activity_description_id']}}">
                      <input type="hidden" id="parent_video_upload_id" name="parent_video_upload_id[{{$row['parent_video_upload_id']}}]" value="{{$row['parent_video_upload_id']}}">
                      <input type="hidden" id="current_status" name="current_status[{{$row['parent_video_upload_id']}}]" value="{{$row['current_status']}}">
                      <input type="hidden" id="save_flag" name="save_flag[{{$row['parent_video_upload_id']}}]" value="{{$row['save_flag']}}">


                      <?php
                      $currentComment = "";
                      if ($row['save_flag'] == 0 || $row['save_flag'] == 1) {
                        foreach ($comments as $key1 => $note_data) {
                          if ($row['parent_video_upload_id'] == $note_data['parent_video_upload_id']) {
                            $currentComment = $note_data['comments'];
                            break;
                          }
                        }
                      }
                      ?>
                      <div class="col-md-6">
                        <div class="form-group">
                          <label class="control-label">Comments</label>
                          <textarea class="form-control" name="comments[{{$row['parent_video_upload_id']}}]" id="comments">{{$currentComment}}</textarea>


                        </div>
                      </div>
                    </div>
                  </div>


                  <div class="col-md-12  text-center" style="padding-top: 1rem;">

                    <a type="button" onclick="saveBulk('Submit' , '{{$row['activity_description_id']}}')" id="submitbuttonbulk" class="btn btn-labeled btn-succes" title="Submit" style="background: green !important; border-color:green !important; color:white !important">
                      <span class="btn-label" style="font-size:13px !important;"><i class="fa fa-check"></i></span>Submit</a>

                    <a type="button" onclick="saveBulk('Save' , '{{$row['activity_description_id']}}')" id="submitbuttonbulk" class="btn btn-labeled btn-succes" title="Save" style="background: green !important; border-color:green !important; color:white !important">
                      <span class="btn-label" style="font-size:13px !important;"><i class="fa fa-bookmark-o"></i></span>Save</a>

                    <a type="button" data-dismiss="modal" aria-hidden="true" class="btn btn-labeled responsive-button button-style back-button" title="Back">
                      <i class="fas fa-arrow-left"></i><span> Back </span>
                    </a>
                  </div>
                  <div class="col-md-12  text-center" style="padding-top: 1rem;">
                    @if ($loop->iteration > 1)
                    <a type="button" class="btn btn-labeled btn-info" onclick="showModalPrev('{{isset($activitylist_nav[$key-1]) ? $activitylist_nav[$key-1]['activity_description_id'] : 'helo'}}')" ontouchstart="showModalPrev('{{isset($activitylist_nav[$key-1]) ? $activitylist_nav[$key-1]['activity_description_id'] : 'helo'}}')" id="Previous" title="Previous" style="height: 35px; background: blue !important; border-color: blue !important; color: white !important">
                      <span class="btn-label" style="font-size: 13px !important;"><i class="fa fa-arrow-left"></i></span> Previous
                    </a>
                    @endif
                    @if ($loop->iteration != count($activitylist_nav))
                    <a type="button" class="btn btn-labeled btn-info" onclick="showModalNext('{{isset($activitylist_nav[$key+1]) ? $activitylist_nav[$key+1]['activity_description_id'] : null}}')" ontouchstart="showModalNext('{{isset($activitylist_nav[$key+1]) ? $activitylist_nav[$key+1]['activity_description_id'] : null}}')" id="Next" title="Next" style="background: blue !important; border-color: #4d94ff !important; color: white !important; height: 35px;">
                      <span class="btn-label" style="font-size: 13px !important;">Next</span> <i class="fa fa-arrow-right"></i>
                    </a>
                    @endif
                  </div>
                </div>
          </section>
        </div>
      </div>
    </div>
  </div>
  @endif
  @endforeach

</form>
<script>
  function showModalNext(id) {
    var id = Number(id);
    $(".modal").each(function() {
      $(this).modal("hide");
    });

    // $(".modal").removeClass('show');
    // $(".modal-backdrop").removeClass('show');
    setTimeout(() => {
      $("#cuModal" + id).modal('show');
    }, 500);


  }

  function showModalPrev(id) {

    var id = Number(id);
    $(".modal").each(function() {
      $(this).modal("hide");
    });
    // $(".modal").removeClass('show');
    //  $(".modal-backdrop").removeClass('show');
    // $("#cuModal" + id).modal('show');
    setTimeout(() => {
      $("#cuModal" + id).modal('show');
    }, 500);
    //$("#cuModal" + id).addClass('show');


  }

  // function saveBulk(type, id) {
  //   // 
  //   document.getElementById('submit_type').value = type;
  //   document.getElementById('openID').value = id;
  //   if (type == 'Submit') {
  //     Swal.fire({
  //       title: 'Are you sure you want to upload the Activity Video?',
  //       text: 'Please take a moment to review the videos carefully, as this action cannot be undone.',
  //       icon: 'question',
  //       showCancelButton: true,
  //       confirmButtonColor: "#3085d6",
  //       cancelButtonColor: "#d33",
  //       confirmButtonText: "Upload",
  //     }).then((result) => {
  //       if (result.isConfirmed) {
  //         document.getElementById('bulkStore').submit();
  //       }
  //     })
  //   } else {
  //     document.getElementById('bulkStore').submit();
  //   }
  // }

  function saveBulk(type, id) {
    document.getElementById('submit_type').value = type;
    document.getElementById('openID').value = id;

    const videoInputs = document.querySelectorAll(`#cuModal${id} input[name^="video_link"]`);
    const activityDescriptionInput = document.querySelector(`#cuModal${id} .activity-description`);
    const activityDescription = activityDescriptionInput ? activityDescriptionInput.value : "This activity";

    let isValid = true;
    let hasAtLeastOneLink = false;

    // Google Drive link pattern
    const googleDrivePattern = /^(https?:\/\/)?(www\.)?(drive\.google\.com)\/[^\s]+$/;

    videoInputs.forEach(input => {
      const value = input.value.trim();

      input.style.border = "";

      if (value !== "") {
        hasAtLeastOneLink = true;
        // Uncomment for Google Drive Validation (Optional)
        // if (!googleDrivePattern.test(value)) {
        //   isValid = false;
        //   input.style.border = "2px solid red";
        // }
      }
    });

    if (!hasAtLeastOneLink) {
      Swal.fire({
        title: 'Please Add Activity Video Link',
        text: `Activity "${activityDescription}" requires at least one video link.`,
        icon: 'error',
        confirmButtonColor: '#d33'
      });
      return;
    }

    if (!isValid) {
      Swal.fire({
        title: 'Invalid Video Link',
        text: 'Please ensure all links are valid Google Drive URLs (e.g., https://drive.google.com/...).',
        icon: 'error',
        confirmButtonColor: '#d33'
      });
      return;
    }

    if (type === 'Submit') {
      Swal.fire({
        title: 'Are you sure you want to upload the Activity Video?',
        text: 'Please review your videos carefully, as this action cannot be undone.',
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Upload",
      }).then((result) => {
        if (result.isConfirmed) {
          document.getElementById('bulkStore').submit();
        }
      });
    } else {
      document.getElementById('bulkStore').submit();
    }
  }
</script>
<!-- End Bulk -->
<!-- Add -->
@foreach($activitylist as $key=>$row)
<div class="modal fade" id="addModal{{$row['parent_video_upload_id']}}">
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
              <form action="{{route('videocreation.parentstore')}}" id="userregistration{{$row['parent_video_upload_id']}}" method="POST">
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
                                <input class="form-control" type="url" id="video_link{{$row['parent_video_upload_id']}}" name="video_link[]" autocomplete="off" required>
                                <button class="remove-field btn btn-danger pull-right" id="remove-f" type='button'>X </button>
                                &nbsp;
                              </div>
                            </div>
                            <button type="button" class="add-field btn btn-success">Add video</button>
                          </div>
                          <!-- <input class="form-control" type="url" id="video_link{{$row['parent_video_upload_id']}}" name="video_link" autocomplete="off" required> -->
                          <div style="color: rgb(246, 15, 15); display: block;margin: 5px 0px 0px 0px;">Google Drive Link Only</div>
                        </div>

                        <!-- <div style="color: rgb(246, 15, 15); display: block;">Add your Google Drive Link Only</div> -->
                      </div>

                      <input type="hidden" id="current_status" name="current_status" value="{{$row['current_status']}}">
                      <input type="hidden" id="activity_description_id" name="activity_description_id" value="{{$row['activity_description_id']}}">
                      <input type="hidden" id="parent_video_upload_id" name="parent_video_upload_id" value="{{$row['parent_video_upload_id']}}">
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

                <a type="button" onclick="save('{{$row['parent_video_upload_id']}}')" id="submitbutton{{$row['parent_video_upload_id']}}" class="btn btn-labeled btn-succes" title="Submit" style="background: green !important; border-color:green !important; color:white !important">
                  <span class="btn-label" style="font-size:13px !important;"><i class="fa fa-check"></i></span>Submit</a>

                <a type="button" class="btn btn-labeled back-btn" data-dismiss="modal" aria-hidden="true" title="Back" style="color:white !important">
                  <span class="btn-label" style="font-size:13px !important;"><i class="fa fa-arrow-left"></i></span> Back</a>
                <!-- <a class="btn btn-danger" href=""><i class="fa fa-times" aria-hidden="true"></i>Back</a>&nbsp; -->
                <!-- <a type="button" class="btn btn-labeled back-btn" title="Back" href="{{ route('parent_video_upload.parentindex') }}" style="color:white !important">
                  <span class="btn-label" style="font-size:13px !important;"><i class="fa fa-arrow-left"></i></span> Back</a> -->
              </div>
            </div>
        </section>
      </div>
    </div>
  </div>
</div>
@endforeach
<!-- End Add -->
<!-- View -->

@foreach($activitylist as $key=>$data1)
<div class="modal fade" id="ViewModal{{$data1['parent_video_upload_id']}}">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <div class="main-contents">
        <section class="section">
          <div class="modal-header bg-primary" style=" background-color: rgb(0 103 172) !important;">
            <!-- <h4 class="modal-title">Sail Activity</h4> -->
            <button type="button" class="close_btn" data-dismiss="modal" aria-hidden="true" onclick="closeModalAndRemoveBackdrop1('#ViewModal{{$data1['parent_video_upload_id']}}')">&times;</button>
          </div>
          <div class="modal-body" style="background-color: #edfcff !important;">
            <div class="section-body mt-2">
              <form action="{{route('videocreation.parentstore')}}" id="userregistration{{$data1['parent_video_upload_id']}}" method="POST">
                @csrf
                <div class="row">
                  <div class="card-body" id="card_header">
                    <div class="col-12" style="display: flex;">
                      <div class="col-md-6">
                        <div class="form-group">
                          <label class="control-label">Video Link</label>
                          @foreach($video_link as $data2)
                          @if($data1['parent_video_upload_id'] == $data2['parent_video_upload_id'])
                          <div style="display: flex;">
                            <input class="form-control" type="text" id="video_link" name="video_link" autocomplete="off" value="{{$data2['video_link']}}" readonly>
                            <a class="btn btn-link" title="show" target="_blank" href="{{$data2['video_link']}}"><i class="fas fa-eye" style="color:green"></i></a>
                            <!-- <div style="color: rgb(246, 15, 15); display: block;margin: 5px 0px 0px 0px;">Google Drive Link Only</div> -->
                          </div>
                          @endif
                          @endforeach
                        </div>
                      </div>
                      <input type="hidden" id="activity_description_id" name="activity_description_id" value="{{$data1['activity_description_id']}}">
                      <input type="hidden" id="parent_video_upload_id" name="parent_video_upload_id" value="{{$data1['parent_video_upload_id']}}">
                      <div class="col-md-6">
                        <label class="control-label commentslabel">Previous Notes </label><br>
                        <div class="form-group scroll_flow_class">
                          @foreach($comments as $key=>$note_data)
                          @if($data1['parent_video_upload_id'] == $note_data['parent_video_upload_id'])
                          <span> {{ $note_data['role'] }} ({{ $note_data['user_name'] }}) - {{ $note_data['active_status'] }} </span> <br>
                          <?php
                          // Assuming $note_data['created_at'] contains the date and time in UTC
                          $utcTimestamp = strtotime($note_data['created_at']);

                          // Add 5 hours and 30 minutes for IST
                          $istTimestamp = $utcTimestamp + (5 * 60 * 60) + (30 * 60);

                          $istDateTime =  gmdate('d/m/Y h:i:s A', $istTimestamp);
                          ?>
                          <span>{{$istDateTime}} - {{ $note_data['comments'] }}</span> <br><br>
                          @endif
                          @endforeach
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
@endforeach
<!-- End View -->
<!-- Edit -->

<form action="{{route('videocreation.parentstore.reupload.bulk')}}" id="reupload_submit" method="POST">
  @csrf
  <input type="hidden" name="rejectedReOpen" id="rejectedReOpen">
  @php $cuModaliteration2 = 0 @endphp
  @foreach($activitylist_rejection as $key=> $row)
  @php $cuModaliteration2 = $cuModaliteration2 + 1;@endphp

  <div class="modal fade editModal{{$row['activity_description_id']}}" id="editModal{{$row['parent_video_upload_id']}}">
    <div class="modal-dialog modal-xl">
      <div class="modal-content">
        <div class="main-contents">
          <section class="section">
            <div class="modal-header bg-primary" style=" background-color: rgb(0 103 172) !important;">
              <!-- <h4 class="modal-title">Sail Activity</h4> -->
              <button type="button" class="close_btn" data-dismiss="modal" aria-hidden="true" onclick="closeModalAndRemoveBackdrop('#editModal{{$row['parent_video_upload_id']}}')">&times;</button>
            </div>
            <div class="modal-body" style="background-color: #edfcff !important;">
              <div class="section-body mt-2">

                <div class="row">
                  <div class="card-body" id="card_header">
                    <div class="col-12" style="display: flex;flex-wrap: wrap;">
                      <div class="col-md-4">
                        <div class="form-group">
                          <label class="control-label">Activity Name</label>
                          <input class="form-control" type="text" value="{{$row['activity_name']}}" readonly>
                        </div>
                      </div>
                      <div class="col-md-8">
                        <div class="form-group">
                          <label class="control-label">Activity Description</label>
                          <input class="form-control" type="text" value="{{$row['description']}}" readonly>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                          <label class="control-label">Video Link</label>
                          <!-- <input class="form-control" type="url" id="video_linka{{$row['parent_video_upload_id']}}" name="video_link" autocomplete="off" required> -->
                          <div class="multi-field-wrapper">
                            <div class="multi-fields">
                              @foreach($video_link as $data2)
                              @if($row['parent_video_upload_id'] == $data2['parent_video_upload_id'])
                              <div class="multi-field" style="display: flex;margin-bottom: 5px;">
                                <!-- <input type="text" class="form-control" name="description[]" id="description"> -->
                                @if($data2['status'] == '1')
                                <input class="form-control video_linka{{$row['parent_video_upload_id']}}" type="text" id="video_link" name="video_link[{{$row['parent_video_upload_id']}}][]" autocomplete="off" value="{{$data2['video_link']}}" readonly>
                                @elseif($data2['status'] == '0')
                                <input class="form-control video_linka{{$row['parent_video_upload_id']}}" style="background-color:white !important" type="text" id="video_link" name="video_link[{{$row['parent_video_upload_id']}}][]" autocomplete="off" value="{{$data2['video_link']}}" readonly oncopy="return false;" oncut="return false;">
                                @endif
                                <button class="remove-field btn btn-danger pull-right {{ $data2['status'] == '0' ? 'rejectedVideo' : '' }}" id="remove-f" type='button'>X </button>
                                &nbsp;
                              </div>
                              @endif
                              @endforeach
                            </div>
                            <!-- <label style="padding: 5px;" for="sameVideoLink"><input type="checkbox" name="sameVideoLink[{{$row['parent_video_upload_id']}}]" id="sameVideoLink{{$row['parent_video_upload_id']}}" onclick="sameVideoLink11('{{$row['parent_video_upload_id']}}')" value="1">Updated the video on the same Google Drive link</label> -->
                             <p style="color: red;margin: 0;">Click Add Video and insert the new or updated video link.</p>
                            <br>
                            <button type="button" class="add-field btn btn-success">Add video</button>
                            <label style="padding: 10px;"> <input type="checkbox" onclick="unable_activity('{{$row['parent_video_upload_id']}}')" name="unable[{{$row['parent_video_upload_id']}}]" id="unable{{$row['parent_video_upload_id']}}" value="1" data-rej="{{$row['parent_video_upload_id']}}" style="margin-right: 0.3rem!important;">My child is unable to do this activity</label>
                          </div>

                          <div style="color: rgb(246, 15, 15); display: block;margin: 5px 0px 0px 0px;">Google Drive Link Only</div>
                        </div>
                        <!-- <div style="color: rgb(246, 15, 15); display: block;">Add your Google Drive Link Only</div> -->
                      </div>

                      <div class="col-md-6">
                        <label class="control-label commentslabel">Previous Notes</label><br>
                        <div class="form-group scroll_flow_class">

                          @foreach($comments as $key1=>$note_data)
                          @if($row['parent_video_upload_id'] == $note_data['parent_video_upload_id'])
                          <span> {{ $note_data['role'] }} ({{ $note_data['user_name'] }}) - {{ $note_data['active_status'] }} </span> <br>
                          <?php
                          // Assuming $note_data['created_at'] contains the date and time in UTC
                          $utcTimestamp = strtotime($note_data['created_at']);

                          // Add 5 hours and 30 minutes for IST
                          $istTimestamp = $utcTimestamp + (5 * 60 * 60) + (30 * 60);

                          $istDateTime =  gmdate('d/m/Y h:i:s A', $istTimestamp);
                          ?>
                          <span>{{ $istDateTime }} - {{ $note_data['comments'] }}</span> <br><br>
                          @endif
                          @endforeach
                        </div>
                      </div>
                      <div class="w-100"></div>
                      <input type="hidden" id="current_status" name="current_status[{{$row['parent_video_upload_id']}}]" value="{{$row['current_status']}}">
                      <input type="hidden" id="activity_description_id" name="activity_description_id[{{$row['parent_video_upload_id']}}]" value="{{$row['activity_description_id']}}">
                      <input type="hidden" id="parent_video_upload_id" name="parent_video_upload_id[{{$row['parent_video_upload_id']}}]" value="{{$row['parent_video_upload_id']}}">
                      <div class="col-md-6">
                        <div class="form-group">
                          <label class="control-label">Comments</label>
                          <textarea class="form-control" name="comments[{{$row['parent_video_upload_id']}}]" id="comments_rej{{$row['parent_video_upload_id']}}"></textarea>
                        </div>
                      </div>
                    </div>
                  </div>

                </div>


                <div class="col-md-12  text-center" style="padding-top: 1rem;">
                  @if ($loop->iteration > 1)
                  <a type="button" class="btn btn-labeled btn-info" onclick="showModalPrev1('{{isset($activitylist_rejection[$key-1]) ? $activitylist_rejection[$key-1]['activity_description_id'] : 'helo'}}')" id="Previous" title="Previous" style="height: 35px; background: blue !important; border-color: blue !important; color: white !important;">
                    <span class="btn-label" style="font-size: 13px !important;"><i class="fa fa-arrow-left"></i></span> Previous
                  </a>
                  @endif
                  <a type="button" onclick="save1('{{$row['parent_video_upload_id']}}')" id="editbutton{{$row['parent_video_upload_id']}}" class="btn btn-labeled btn-succes" title="Submit" style="background: green !important; border-color:green !important; color:white !important">
                    <span class="btn-label" style="font-size:13px !important;"><i class="fa fa-check"></i></span>Submit</a>

                  <a type="button" class="btn btn-labeled back-btn" data-dismiss="modal" aria-hidden="true" title="Back" style="color:white !important;background: red !important;">
                    <span class="btn-label" style="font-size:13px !important;"><i class="fa fa-arrow-left"></i></span> Back</a>
                  @if ($loop->iteration != count($activitylist_rejection))
                  <a type="button" class="btn btn-labeled btn-info" onclick="showModalNext1('{{isset($activitylist_rejection[$key+1]) ? $activitylist_rejection[$key+1]['activity_description_id'] : null}}')" id="Next" title="Next" style="background: blue !important; border-color: #4d94ff !important; color: white !important; height: 35px;">
                    <span class="btn-label" style="font-size: 13px !important;">Next</span> <i class="fa fa-arrow-right"></i>
                  </a>
                  @endif
                </div>
              </div>
          </section>
        </div>
      </div>
    </div>
  </div>
  @endforeach
</form>
<script>
  $(document).ready(function() {
    $(".modal").on("hidden.bs.modal", function() {
      $(".modal-body1").find('form').trigger('reset');
    });
  });

  function showModalNext1(id) {
    var id = Number(id);
    document.getElementById('rejectedReOpen').value = id;
    // $(".modal").modal('hide');
    $(".modal").each(function() {
      $(this).modal("hide");
    });
    // $(".modal-backdrop").removeClass('show');
    setTimeout(() => {
      $(".editModal" + id).modal('show');
    }, 500);
  }

  function showModalPrev1(id) {
    var id = Number(id);
    document.getElementById('rejectedReOpen').value = id;
    // $(".modal").modal('hide');
    $(".modal").each(function() {
      $(this).modal("hide");
    });
    // $(".modal-backdrop").removeClass('show');
    setTimeout(() => {
      $(".editModal" + id).modal('show');
    }, 500);
  }
  // Function to close the modal and remove the backdrop
  function closeModalAndRemoveBackdrop(modalId) {

    // Close the modal using jQuery
    $(modalId).modal('hide');
    // Remove the modal backdrop
    $('body').removeClass('modal-open');
    $('.modal-backdrop').css('display', 'none');
  }
  // Function to close the modal and remove the backdrop
  function closeModalAndRemoveBackdrop1(modalId) {

    // Close the modal using jQuery
    $(modalId).modal('hide');
    $(modalId).css('display', 'none');
    // Remove the modal backdrop
    $('body').removeClass('modal-open');
    $('.modal-backdrop').css('display', 'none');
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
      $('#comments_rej' + val).val('My child is unable to do this activity. ' + content);
    } else {
      content = content.replace('My child is unable to do this activity.', '');
      $('#comments_rej' + val).val(content);
    }

  }

  var rejected = <?php echo json_encode($activitylist_rejection); ?>;
  var rejectedId = [];

  rejected.forEach(function(item) {
    if (item.parent_video_upload_id) {
      rejectedId.push(item.parent_video_upload_id);
    }
  });

  function save1(id) {

    var hasClonedInput = false;
    var clonedFoundId = null;

    for (var i = 0; i < rejectedId.length; i++) {
      var inputs = document.querySelectorAll('.video_linka' + rejectedId[i]);
      var checkbox = document.querySelector(`input[type="checkbox"][data-rej="${rejectedId[i]}"]`);
      var clonedFound = false;
      var sameVideoLink = $('#sameVideoLink' + rejectedId[i]);

      if (!checkbox.checked && !sameVideoLink.prop('checked')) {
        for (var j = 0; j < inputs.length; j++) {
          var input = inputs[j];
          if (input.getAttribute('isClone') === 'true') {
            hasClonedInput = true;
            clonedFound = true;
            break;
          } else {
            hasClonedInput = false;
          }
        }

        if (!clonedFound) {
          clonedFoundId = rejectedId[i];
          break;
        }
      }
    }

    if (!hasClonedInput) {
      var emptyActivityVideo = '';

      for (var k = 0; k < rejected.length; k++) {
        var item = rejected[k];
        if (item.parent_video_upload_id == clonedFoundId) {
          if (item.description) {
            emptyActivityVideo = ' "' + item.description + '" in ' + item.activity_name;
          } else {
            emptyActivityVideo = ' in ' + item.activity_name;
          }
          break;
        } else {
          emptyActivityVideo = item.description;
        }
      }

      // alert('Please add new videos to the activity : ' + emptyActivityVideo);
      Swal.fire({
        title: 'Missing Videos',
        html: 'We noticed that you have not added any new video(s) for the activity <br>' + emptyActivityVideo,
        // text : "We noticed that you have not added any new video for the activity ",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Proceed without adding",
      }).then((result) => {
        if (result.isConfirmed) {
          Swal.fire({
            title: 'Submission Warning',
            text: 'Only activities with the new video(s) will be submitted. All other activities will remain in their current status. You still need to add the videos.',
            icon: 'info',
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            confirmButtonText: "Continue",
          }).then(() => {
            Swal.fire({
              title: 'Review Videos',
              text: 'Please review the video(s) carefully, as this cannot be undone.',
              icon: 'warning',
              showCancelButton: true,
              confirmButtonColor: "#3085d6",
              cancelButtonColor: "#d33",
              confirmButtonText: "Upload",
            }).then((finalResult) => {
              if (finalResult.isConfirmed) {
                document.getElementById('reupload_submit').submit();
              }
            });
          });
        }
      });
      return false;
    } else {
      Swal.fire({
        title: 'Review Videos',
        text: 'Please review the video(s) carefully, as this cannot be undone.',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Upload",
      }).then((finalResult) => {
        if (finalResult.isConfirmed) {
          document.getElementById('reupload_submit').submit();
        }
      });
    }
  }

  function newupload(id, activity_description_id) {
    document.getElementById('rejectedReOpen').value = activity_description_id;
    $(`#${id}`).modal('show')
  }
</script>
<script>
  $('.multi-field-wrapper').each(function() {

    var $wrapper = $('.multi-fields', this);
    // console.log($wrapper);

    var pvuID = <?php echo ($row['parent_video_upload_id']) ?>;
    $(".add-field", $(this)).click(function(e) {
      $('.multi-field:first-child', $wrapper).clone(true).appendTo($wrapper).find('input').val('').focus().removeAttr('readonly').attr('isClone', true).end().find('.remove-field').removeClass('rejectedVideo');
      $('#file_field').append('<div class="multi-field" style="display: flex;margin-bottom: 5px;"><input class="form-control" type="url" id="video_link' + pvuID + '"name="video_link[]" autocomplete="off" required></div>');
    });

    $('.multi-field .remove-field', $wrapper).click(function() {

      var $field = $(this);
      var $removeButton = $field.find('.remove-field');

      if ($field.hasClass('rejectedVideo')) {
        // alert('This Video link cannot be removed.');
        Swal.fire('Info!', 'The previously uploaded video cannot be removed. Click Add Video and insert the new or updated video link.', 'info');
        return false;
      }

      if ($('.multi-field', $wrapper).length > 1)
        $(this).parent('.multi-field').remove();

      else 
        // alert('Atleast one video is needed!');
      Swal.fire('Info!', 'Atleast one video is needed!', 'info');
      return false;

    });
  });
  $(document).ready(function() {
    $('.back-btn').click(function() {
      $('#myModal').modal('hide'); // Hide the modal
      $('.modal-backdrop').remove(); // Remove the backdrop manually
    });
  });
</script>
<script>
  function sameVideoLink11(val) {
    var content = $('#comments_rej' + val).val();

    if ($('#sameVideoLink' + val).prop('checked')) {
      $('#comments_rej' + val).val('Updated the video on the same Google Drive link. ' + content);
    } else {
      content = content.replace('Updated the video on the same Google Drive link.', '');
      $('#comments_rej' + val).val(content);
    }
  }
</script>
@endsection