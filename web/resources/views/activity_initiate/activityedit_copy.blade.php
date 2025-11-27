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

  /* #invite{
    display: none;
  } */
</style>

<div class="main-content" style="min-height:'60px'">
  <!-- Main Content -->
  {{ Breadcrumbs::render('activity_initiate.edit', $rows[0]['child_id'] ) }}

  @if (session('success'))
  <input type="hidden" name="session_data" id="session_data" class="session_data" value="{{ session('success') }}">
  <script type="text/javascript">
    window.onload = function() {
      var message = $('#session_data').val();
      Swal.fire('Success!', message, 'success');
    }
  </script>
  @elseif(session('fail'))
  <input type="hidden" name="session_data" id="session_data1" class="session_data" value="{{ session('fail') }}">
  <script type="text/javascript">
    window.onload = function() {
      var message = $('#session_data1').val();
      Swal.fire('Info!', message, 'info');
    }
  </script>
  @endif

  <section class="section">
    <div class="section-body mt-1">
      <h5 class="text-center" style="color:darkblue">Parent Activity Video</h5>
      @foreach($rows as $key=>$row)
      <form action="{{route('activity_initiate.activeStatus', $row['activity_initiation_id'])}}" id="activeStatus" method="POST">
        @csrf
        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-body">
                <div class="row">
                  <div class="col-md-4">
                    <div class="form-group">
                      <label class="control-label">Enrollment Number</label><span class="error-star" style="color:red;">*</span>
                      <input class="form-control" type="text" id="enrollment_id" name="enrollment_id" value="{{ $row['enrollment_child_num'] }}" disabled autocomplete="off">
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group">
                      <label class="control-label">Child ID</label><span class="error-star" style="color:red;">*</span>
                      <input class="form-control" type="text" id="child_id" name="child_id" autocomplete="off" value="{{ $row['child_id'] }}" readonly>
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group">
                      <label class="control-label">Child Name</label><span class="error-star" style="color:red;">*</span>
                      <input class="form-control" type="text" id="child_name" name="child_name" autocomplete="off" value="{{ $row['child_name'] }}" readonly>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label class="control-label">Active Set</label><span class="error-star" style="color:red;">*</span>
                      <input class="form-control" type="text" id="activity_name" name="activity_name" autocomplete="off" value="{{ $row['activity_name'] }}" readonly>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label class="control-label">Approval Status</label><span class="error-star" style="color:red;">*</span>
                      <select class="form-control" name="approval_status" id="approval_status">
                        <option value="">Select Status</option>
                        @if($row['status'] == "Close")
                        <option value="Close" selected>Close</option>
                        @else
                        <option value="Close">Close</option>
                        @endif
                      </select>
                    </div>
                  </div>
                  <div class="col-md-12  text-center" style="padding-top: 1rem;">
                    <a type="button" onclick="activeStatus()" id="submitbutton" class="btn btn-labeled btn-succes" title="save" style="background: green !important; border-color:green !important; color:white !important">
                      <span class="btn-label" style="font-size:13px !important;"><i class="fa fa-check"></i></span>Update Activity</a>
                    <a type="button" class="btn btn-labeled back-btn" title="Back" href="{{ route('activity_initiate.index') }}" style="color:white !important">
                      <span class="btn-label" style="font-size:13px !important;"><i class="fa fa-arrow-left"></i></span> Back</a>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div>
      </form>

      <div class="col-12" style="padding-top: 45px;">
        <h5 class="text-center" style="color:darkblue">Uploaded Video List</h5>
        <div class="card mt-3">
          <div class="card-body">
           
            <div class="table-wrapper">
              <div class="table-responsive">
                <table class="table table-bordered" id="align1">
                  <thead>
                    <tr>
                      <th>Sl.No</th>
                      <th>Activity Name</th>
                      <th>Activity Description</th>
                      <th>Status</th>
                      <th>Actioned Date</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach($lastactivity as $key=>$data2)
                    <tr>
                      <td>{{ $loop->iteration }}</td>
                      <td>{{$data2['activity_name']}}</td>
                      <td>{{$data2['description']}}</td>
                      <td>{{$data2['status']}}</td>
                      <td>{{$data2['last_modified_date']}}</td>
                      <td>
                        @if($data2['status'] == 'Complete' || $data2['status'] == 'Close')
                        <a href="#viewModal" data-toggle="modal" data-target="#viewModal{{$data2['parent_video_upload_id']}}" class="btn btn-success" title="View" data-toggle="modal" data-target="#templates" style="margin-inline:5px"><i class="fa fa-eye"></i></span><span style="font-size:15px !important; padding:8px !important">View</a>
                        @else
                        <a href="#addModal" data-toggle="modal" data-target="#addModal{{$data2['parent_video_upload_id']}}" class="btn btn-success" title="View" data-toggle="modal" data-target="#templates" style="margin-inline:5px"><i class="fa fa-pencil"></i></span><span style="font-size:15px !important; padding:8px !important">Edit</a>
                        @endif
                        <!-- <a class="btn btn-link" title="show" target="_blank" href="{{$data2['video_link']}}"><i class="fas fa-eye" style="color:green"></i></a> -->
                      </td>
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
    @endforeach
</div>
</section>
</div>

@foreach($lastactivity as $key => $data)

<div class="modal fade" id="addModal{{$data['parent_video_upload_id']}}">
  <form action="{{route('activity_initiate.update', $data['parent_video_upload_id'])}}" id="userregistrationa{{$data['parent_video_upload_id']}}" method="POST">
    @csrf
    @method('PUT')
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
                <div class="row">
                  <div class="col-12" style="padding-top: 45px;">
                    <div class="card">
                      <div class="card-body">
                        <div class="row">
                          <div class="col-md-6">
                            <div class="form-group">
                              <label class="control-label">Activity Name</label><span class="error-star" style="color:red;">*</span>
                              <input class="form-control" type="text" id="activity_id" name="activity_id" value="{{ $data['activity_name']}}" autocomplete="off" readonly>
                            </div>
                          </div>

                          <div class="col-md-6">
                            <div class="form-group">
                              <label class="control-label">Activity Description</label><span class="error-star" style="color:red;">*</span>
                              <input class="form-control" type="text" id="description_id" name="description_id" value="{{ $data['description']}}" autocomplete="off" readonly>
                            </div>
                          </div>
                          <div class="w-100"></div>
                          <div class="col-md-6">
                            <div class="form-group">
                              <label class="control-label">Video Link</label><span class="error-star" style="color:red;">*</span>
                              <div style="display: flex;">
                                <input class="form-control" type="url" id="video_link" name="video_link" autocomplete="off" readonly value="{{$data['video_link']}}">
                                <a class="btn btn-link" title="show" target="_blank" href="{{$data['video_link']}}"><i class="fas fa-eye" style="color:green"></i></a>
                                <!-- <div style="color: rgb(246, 15, 15); display: block;margin: 5px 0px 0px 0px;">Google Drive Link Only</div> -->
                              </div>
                            </div>
                          </div>

                          <input type="hidden" id="activity_description_id" name="activity_description_id" value="{{$data['activity_description_id']}}">
                          <input type="hidden" id="parent_video_upload_id" name="parent_video_upload_id" value="{{$data['parent_video_upload_id']}}">
                          <div class="col-md-6">
                            <label class="control-label">Previous Notes </label><br>
                            <div class="form-group scroll_flow_class">
                              @foreach($comments as $key=>$note_data)
                              @if($data['parent_video_upload_id'] == $note_data['parent_video_upload_id'])
                              <span> {{ $note_data['role'] }} ({{ $note_data['user_name'] }}) - {{ $note_data['active_status'] }} </span> <br>
                              <span>{{ date('d/m/Y H:i:s', strtotime($note_data['created_at']))  }} - {{ $note_data['comments'] }}</span> <br><br>
                              @endif
                              @endforeach
                            </div>
                          </div>

                          <div class="col-md-6">
                            <div class="form-group">
                              <label class="control-label">Approval Status</label><span class="error-star" style="color:red;">*</span>
                              <select class="form-control" name="approval_status" id="approval_status{{$data['parent_video_upload_id']}}">
                                <option value="">Select Status</option>
                                <option value="Complete">Complete</option>
                                <option value="Rejected">Reject</option>
                                <!-- <option value="Close">Close</option> -->
                              </select>
                            </div>
                          </div>

                          <div class="col-md-6">
                            <div class="form-group">
                              <label class="control-label">Comments</label>
                              <textarea class="form-control" name="comments" id="comments"></textarea>
                            </div>
                          </div>

                        </div>
                      </div>
                    </div>
                  </div>
                </div>

                <div class="col-md-12  text-center" style="padding-top: 1rem;">
                  <a type="button" onclick="save('{{$data['parent_video_upload_id']}}')" id="submitbutton" class="btn btn-labeled btn-succes" title="save" style="background: green !important; border-color:green !important; color:white !important">
                    <span class="btn-label" style="font-size:13px !important;"><i class="fa fa-check"></i></span>Update Activity</a>
                </div>

              </div>
          </section>
        </div>
      </div>
    </div>
  </form>
</div>

@endforeach
@foreach($lastactivity as $key => $data)
<form action="{{route('activity_initiate.update', $row['activity_initiation_id'])}}" id="userregistrationb{{$data['parent_video_upload_id']}}" method="POST">
  @csrf
  @method('PUT')
  <div class="modal fade" id="viewModal{{$data['parent_video_upload_id']}}">
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
                <div class="row">
                  <div class="col-12" style="padding-top: 45px;">
                    <div class="card">
                      <div class="card-body">
                        <div class="row">
                          <div class="col-md-6">
                            <div class="form-group">
                              <label class="control-label">Activity Name</label><span class="error-star" style="color:red;">*</span>
                              <input class="form-control" type="text" id="activity_id" name="activity_id" value="{{ $data['activity_name']}}" autocomplete="off" readonly>
                            </div>
                          </div>

                          <div class="col-md-6">
                            <div class="form-group">
                              <label class="control-label">Activity Description</label><span class="error-star" style="color:red;">*</span>
                              <input class="form-control" type="text" id="description_id" name="description_id" value="{{ $data['description']}}" autocomplete="off" readonly>
                            </div>
                          </div>
                          <div class="w-100"></div>
                          <div class="col-md-6">
                            <div class="form-group">
                              <label class="control-label">Video Link</label><span class="error-star" style="color:red;">*</span>
                              <div style="display: flex;">
                                <input class="form-control" type="url" id="video_link" name="video_link" autocomplete="off" value="{{$data['video_link']}}">
                                <a class="btn btn-link" title="show" target="_blank" href="{{$data['video_link']}}"><i class="fas fa-eye" style="color:green"></i></a>
                                <!-- <div style="color: rgb(246, 15, 15); display: block;margin: 5px 0px 0px 0px;">Google Drive Link Only</div> -->
                              </div>
                            </div>
                          </div>

                          <input type="hidden" id="activity_description_id" name="activity_description_id" value="{{$data['activity_description_id']}}">
                          <input type="hidden" id="parent_video_upload_id" name="parent_video_upload_id" value="{{$data['parent_video_upload_id']}}">
                          <div class="col-md-6">
                            <label class="control-label">Previous Notes </label><br>
                            <div class="form-group scroll_flow_class">
                              @foreach($comments as $key=>$note_data)
                              @if($data['activity_initiation_id'] == $note_data['activity_initiation_id'])
                              <span> {{ $note_data['role'] }} ({{ $note_data['user_name'] }}) - {{ $note_data['active_status'] }} </span> <br>
                              <span>{{ date('d/m/Y H:i:s', strtotime($note_data['created_at']))  }} - {{ $note_data['comments'] }}</span> <br><br>
                              @endif
                              @endforeach
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>

                <!-- <div class="col-md-12  text-center" style="padding-top: 1rem;">
                  <a type="button" onclick="save('{{$data['parent_video_upload_id']}}')" id="submitbutton" class="btn btn-labeled btn-succes" title="save" style="background: green !important; border-color:green !important; color:white !important">
                    <span class="btn-label" style="font-size:13px !important;"><i class="fa fa-check"></i></span>Update Activity</a>
                </div> -->

              </div>
          </section>
        </div>
      </div>
    </div>
  </div>
</form>
@endforeach
<script type="text/javascript">
  function save(id) {

    var approval_status = $('#approval_status' + id).val();

    if (approval_status == '' || approval_status == null) {
      swal.fire("Please Select Approval Status", "", "error");
      return false;
    }

    document.getElementById('userregistrationa' + id).submit('saved');
  }
</script>
<script>
  function activeStatus() {
    var approval_status = $('#approval_status').val();

    if (approval_status == '' || approval_status == null) {
      swal.fire("Please Select Approval Status", "", "error");
      return false;
    }

    document.getElementById('activeStatus').submit();
  }
</script>
@endsection