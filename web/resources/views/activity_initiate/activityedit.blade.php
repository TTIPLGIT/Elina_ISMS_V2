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
<style>
  .wrapper {
    margin-inline: auto;
    padding-top: 1rem;
    display: flex;
    flex-direction: column;
  }

  button {
    all: unset;
  }

  .tabs {
    border: 1px solid rgba(0, 0, 0, 0.125);
    border-radius: 0.25rem;
  }

  .tabs__nav {
    border-bottom: 1px solid rgba(0, 0, 0, 0.125);
    /* background-color: #fafafa; */
    background-color: #09306ed4;
  }

  .tabs__btn {
    position: relative;
    padding: 1rem 1.25rem;
    cursor: pointer;
    color: white;
    transition: opacity 0.3s;
  }

  .tabs__btn:not(.is-active) {
    /* opacity: 0.6; */
  }

  .tabs__btn:not(.is-active):hover {
    opacity: 1;
  }

  .tabs__btn.is-active {
    color: #6158de;
    background-color: #fafafa;
    font-weight: 900;
    border-right: 2px solid rgb(34 34 34);
    border-left: 2px solid rgb(34 34 34) !important;
    border-top: 2px solid rgb(34 34 34);
  }

  .tabs__btn.is-active::after {
    content: "";
    position: absolute;
    /* bottom: -1px; */
    left: 0;
    /* height: 1px; */
    width: 100%;
    background-color: #fff;
  }

  .tabs__btn:first-child.is-active {
    border-left: none;
  }

  .tabs__pane {
    display: none;
    /* padding: 2rem 1.25rem; */
  }

  .tabs__pane.is-visible {
    display: block;
  }

  h3 {
    font-size: 1.8rem;
    margin-bottom: 1rem;
  }

  p+p {
    margin-top: 1rem;
  }
</style>
<style>
  .dropdown-content {
    display: none;
    position: absolute;
    background-color: #f1f1f1;
    min-width: 300px;
    box-shadow: 0px 8px 16px 0px rgba(0, 0, 0, 0.2);
    z-index: 1;
  }

  .dropdown-content a {
    color: black;
    padding: 12px 16px;
    text-decoration: none;
    display: block;
  }

  .dropdown:hover .dropdown-content {
    display: block;
  }

  .dropdown-content a:hover {
    background-color: white;
  }

  .badgeact {
    position: relative;
  }

  .badgeact::after {
    content: attr(data-badge);
    position: absolute;
    top: -8px;
    right: -8px;
    width: 10px;
    height: 10px;
    border-radius: 50%;
    background-color: #FF5151;
    color: white;
    font-size: 10px;
    text-align: center;
    line-height: 16px;
  }
</style>
<style>
  .liked {
    color: red;
    font-weight: bold;
  }

  .control-label,
  .comments_label {
    font-weight: 800 !important;
    color: #34395e !important;
    font-size: 15px !important;
  }

  .scrollmodal {
    height: 350px !important;
    overflow-y: scroll !important;
  }

  .video-link-cell.expanded {
    white-space: normal !important;
    max-width: 500px;
    overflow: visible;
    cursor: pointer;
  }
</style>
<div class="main-content" style="min-height:'60px'">
  <!-- Main Content -->
  {{ Breadcrumbs::render('activity_initiate.edit', $rows[0]['child_id'] ) }}

  @if (session('success'))
  <input type="hidden" name="session_data" id="session_data" class="session_data" value="{{ session('success') }}">
  <script type="text/javascript">
    window.onload = function() {
      var message = $('#session_data').val();
      const activeActivityId = document.getElementById('session_key').value;
      document.getElementById('is_active_tab').value = activeActivityId;
      document.querySelector(`button[value="${activeActivityId}"]`).click();
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
      <h5 class="text-center" style="color:darkblue">Uploaded Video List</h5>
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
                  <input type="hidden" value="{{$row['activity_initiation_id']}}" id="aID" name="aID">
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
                  {{-- <div class="col-md-6">
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
              </div>--}}

              <a href="#dataModal" data-toggle="modal" data-target="#dataModal" class="btn btn-primary" title="View" data-toggle="modal" data-target="#templates" style="margin-inline:5px"><i class="fa fa-bars" style="color:white!important"></i></a>

              <div class="col-md-12  text-center" style="padding-top: 1rem;">
                <!-- <a type="button" onclick="activeStatus()" id="submitbutton" class="btn btn-labeled btn-succes" title="save" style="background: green !important; border-color:green !important; color:white !important">
                      <span class="btn-label" style="font-size:13px !important;"><i class="fa fa-check"></i></span>Submit</a> -->
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
</div>


<div class="col-12" style="padding-top: 45px;">
  <h5 class="text-center" style="color:darkblue">Uploaded Video List</h5>
  <div class="wrapper">
    <div class="tabs">
      <nav class="tabs__nav" role="tablist">
        <input type="hidden" value="" id="scroll_view" name="scroll_view">
        @foreach($activity as $row1)
        @if($loop->iteration == 1)
        <button class="tabs__btn is-active" value="{{$row1['activity_id']}}" onclick="document.getElementById('is_active_tab').value = this.value;" data-tab-target="tab-{{$row1['activity_id']}}" type="button" role="tab" aria-selected="true">{{$row1['activity_name']}}<span id="badge{{$row1['activity_id']}}" class=""></span></button>
        @else
        <button class="tabs__btn" value="{{$row1['activity_id']}}" onclick="document.getElementById('is_active_tab').value = this.value;" data-tab-target="tab-{{$row1['activity_id']}}" type="button" role="tab" aria-selected="false">{{$row1['activity_name']}}<span id="badge{{$row1['activity_id']}}" class=""></span></button>
        @endif
        @endforeach
        <input type="hidden" name="session_key" id="session_key" value="{{ session('key') }}">
      </nav>

      <!-- <nav class="tabs__nav" role="tablist">
        <input type="hidden" value="" id="scroll_view" name="scroll_view">
        @if (session('key'))
        @foreach($activity as $row1)
        @if($row1['activity_id'] == session('key'))
        <input type="hidden" name="session_key" id="session_key" value="{{ session('key') }}">
        <script type="text/javascript">
          $(document).ready(function() {
            document.getElementById('is_active_tab').value = document.getElementById('session_key').value;
          });
        </script>
        <button class="tabs__btn is-active" value="{{$row1['activity_id']}}" onclick="document.getElementById('is_active_tab').value = this.value;" data-tab-target="tab-{{$row1['activity_id']}}" type="button" role="tab" aria-selected="true">{{$row1['activity_name']}}<span id="badge{{$row1['activity_id']}}" class=""></span></button>
        @else
        <button class="tabs__btn" value="{{$row1['activity_id']}}" onclick="document.getElementById('is_active_tab').value = this.value;" data-tab-target="tab-{{$row1['activity_id']}}" type="button" role="tab" aria-selected="false">{{$row1['activity_name']}}<span id="badge{{$row1['activity_id']}}" class=""></span></button>
        @endif
        @endforeach
        @else
        @foreach($activity as $row1)
        @if($loop->iteration == 1)
        <button class="tabs__btn is-active" value="{{$row1['activity_id']}}" onclick="document.getElementById('is_active_tab').value = this.value;" data-tab-target="tab-{{$row1['activity_id']}}" type="button" role="tab" aria-selected="true">{{$row1['activity_name']}}<span id="badge{{$row1['activity_id']}}" class=""></span></button>
        @else
        <button class="tabs__btn" value="{{$row1['activity_id']}}" onclick="document.getElementById('is_active_tab').value = this.value;" data-tab-target="tab-{{$row1['activity_id']}}" type="button" role="tab" aria-selected="false">{{$row1['activity_name']}}<span id="badge{{$row1['activity_id']}}" class=""></span></button>
        @endif
        @endforeach
        @endif
      </nav> -->

      @php $cuModaliteration = 0 @endphp
      @php $cuModaliteration1 = 0 @endphp
      <div class="tabs__content">
        @foreach($activity as $row1)

        @if (session('key'))
        @if($row1['activity_id'] == session('key'))
        <div class="tabs__pane is-visible" id="tab-{{$row1['activity_id']}}" role="tabpanel">
          @else
          <div class="tabs__pane" id="tab-{{$row1['activity_id']}}" role="tabpanel">
            @endif
            @else
            @if($loop->iteration == 1)
            <div class="tabs__pane is-visible" id="tab-{{$row1['activity_id']}}" role="tabpanel">
              @else
              <div class="tabs__pane" id="tab-{{$row1['activity_id']}}" role="tabpanel">
                @endif
                @endif
                <div class="card-body">
                  <div class="table-wrapper">
                    <div class="table-responsive">
                      <!-- <a class="btn btn-success" style="float:right;margin-right:20px;" href="https://codepen.io/collection/XKgNLN/" target="_blank">Other examples on Codepen</a> -->
                      <!--  -->
                      <div class="col-2 form-group" style="float:right;">
                        <select class="form-control selectView" id="Tableview" /*onchange="view_change()" * />
                        <option value="1">Status</option>
                        <option value="2">Observation</option>
                        <option value="3">Instruction</option>
                        </select>
                      </div>
                      <div class="col-3 dropdown form-control bulkapproved" style="float:right; display:none" name="bulkapproved" id="bulkapproved{{$row1['activity_id']}}">
                        <div class="dropbtn" style="color: #212529;font-size: 15px;"> Selected Approval Status </div>
                        <div class="dropdown-content">
                          <a href="#" onclick="setBulkAction('Complete')">Approve</a>
                          <a href="#" onclick="setBulkAction('Reject')">Reject</a>
                        </div>
                      </div>
                      <div class="col-2 dropdown form-control SelectmarkRequired" style="float:right; display:none" name="" id="">
                        <div class="dropbtn" style="color: #212529;font-size: 15px;"> Required </div>
                        <div class="dropdown-content">
                          <a href="#" onclick="setAsRequired()"> Mark as Required </a>
                        </div>
                      </div>
                      <!--  -->

                      <!-- View - 1 -->
                      <table class="table table-bordered Tableview View1" id="activity{{$loop->iteration}}">
                        <thead>
                          <tr>
                            <th>Sl.No</th>
                            <!-- <th>Activity Name</th> -->
                            <th>Activity Description</th>
                            <!-- <th>F2F</th> -->
                            <th>Status</th>
                            <!-- <th>Actioned Date</th> -->
                            <th>Action</th>
                            <!-- <th width="10%"><input id="selectAll{{$row1['activity_id']}}" type="checkbox" title="Select All" onclick="selectall('{{$row1['activity_id']}}')"></th> -->
                            <th>F2F Status</th>
                          </tr>
                        </thead>
                        <tbody>
                          @php $iteration = 0; @endphp
                          @foreach($lastactivity as $key=>$data2)
                          @if($data2['activity_id'] == $row1['activity_id'])
                          @php $iteration = $iteration+1; @endphp
                          <tr>
                            <td>{{ $iteration }}</td>
                            <!-- <td>{{$data2['activity_name']}}</td> -->
                            <td>{{$data2['description']}}
                              <!--  -->
                              @if($data2['required'] == 1)
                              <label style="pointer-events:none !important;">
                                <input class="markRequired" type="checkbox" name="markRequired" id="likeCheckbox{{$data2['parent_video_upload_id']}}" data-title="{{$data2['description']}}" value="{{$data2['parent_video_upload_id']}}" onchange="toggleLike('{{$data2['parent_video_upload_id']}}')" style="display: none;">
                                <span id="likeText{{$data2['parent_video_upload_id']}}" class="liked"><i class="far fa-star"></i></span>
                              </label>
                              @else
                              <label>
                                <input class="markRequired" type="checkbox" name="markRequired" id="likeCheckbox{{$data2['parent_video_upload_id']}}" data-title="{{$data2['description']}}" value="{{$data2['parent_video_upload_id']}}" onchange="toggleLike('{{$data2['parent_video_upload_id']}}')" style="display: none;">
                                <span id="likeText{{$data2['parent_video_upload_id']}}"><i class="far fa-star"></i></span>
                                @endif
                              </label>
                              <!--  -->
                            </td>
                            <!-- <td><input type="checkbox" name="f2f" id="f2f" onclick="alert('F2F')"></td> -->
                            <!-- <td><label class="switch"><input type="checkbox" id="f2f{{$data2['parent_video_upload_id']}}" name="f2f{{$data2['parent_video_upload_id']}}" data-lable="{{$data2['description']}}" onclick="f2f_toggle(this)"><span class="slider"></span></label></td> -->
                            @if($data2['status'] == 'Complete')
                            <td>Approved</td>
                            @elseif($data2['save_status'] == 'Saved')
                            <td>Saved</td>
                            @else
                            <td>{{$data2['status']}}</td>
                            @endif


                            <!-- <td>{{$data2['last_modified_date']}}</td> -->
                            <td>
                              <div style="display: flex;">
                                @if($data2['status'] == 'Complete' || $data2['status'] == 'Close')
                                <a href="#addModal" data-toggle="modal" data-target="#addModal{{$data2['parent_video_upload_id']}}" class="btn btn-success" title="View" data-toggle="modal" data-target="#templates" style="margin-inline:5px"><i class="fa fa-pencil"></i></a>
                                @elseif($data2['status'] == 'New' || $data2['status'] == 'Rejected')
                                <button class="btn btn-info" style="margin-inline:5px" disabled><i class="fa fa-pencil"></i></button>
                                @else
                                @php $cuModaliteration = $cuModaliteration+1; @endphp
                                <a href="#cuModal{{$cuModaliteration}}" class="btn btn-success" data-toggle="modal" title="View" style="margin-inline:5px"><i class="fa fa-pencil"></i></a>
                                @endif
                                <label class='switch' data-bs-toggle='tooltip' data-bs-placement='top' title='Enable / Disable'><input type='checkbox' class='toggle_status' onclick="functiontoggle('{{$data2['parent_video_upload_id']}}')" id="is_active{{$data2['parent_video_upload_id']}}" name='is_active' @if($data2['enableflag']=='0' ) checked @endif><span class='slider round'></span></label>
                              </div>
                            </td>
                            <!-- <td>
                              @if($data2['status'] == 'Submitted' || $data2['status'] == 'Re-Sent')
                              <input type="checkbox" class="approved selectAll_id{{$row1['activity_id']}}" id="approved{{$data2['parent_video_upload_id']}}" name="approved" order="{{$row1['activity_id']}}" value="{{$data2['parent_video_upload_id']}}">
                              @else
                              <input type="checkbox" onclick="return false;" value="{{$data2['parent_video_upload_id']}}">
                              @endif
                            </td> -->
                            @if($data2['f2f_flag'] == 1)
                            <td> <input type="checkbox" class="Enabled" id="approved{{$data2['parent_video_upload_id']}}" name="enabled" value="1" checked onclick="return false;"></td>
                            <!-- Enabled</td> -->
                            @else
                            <td> <input type="checkbox" class="Not Enabled" id="approved{{$data2['parent_video_upload_id']}}" name="enabled" value="0" onclick="return false;"></td>
                            <!-- Not Enabled</td> -->
                            @endif
                          </tr>
                          @endif
                          @endforeach
                        </tbody>
                      </table>
                      <!-- View - 1 End -->

                      <!-- View - 2 -->
                      <table class="table table-bordered Tableview View2" id="activity{{$loop->iteration}}" style="display:none">
                        <thead>
                          <tr>
                            <th>Sl.No</th>
                            <th>Activity Description</th>
                            <th>Status</th>
                            <th>Observation</th>
                            <th>Action</th>
                          </tr>
                        </thead>
                        <tbody>
                          @php $iteration = 0; @endphp
                          @foreach($lastactivity as $key=>$data2)
                          @if($data2['activity_id'] == $row1['activity_id'])
                          @php $iteration = $iteration+1; @endphp
                          <tr>
                            <td>{{ $iteration }}</td>
                            <td>{{$data2['description']}}</td>
                            @if($data2['status'] == 'Complete')
                            <td>Approved</td>
                            @elseif($data2['f2f_flag'] == 1)
                            <td>F2F</td>
                            @else
                            <td>{{$data2['status']}}</td>
                            @endif
                            <td>{{$data2['comments']}}</td>
                            <td>
                              <div style="display: flex;">
                                @if($data2['status'] == 'Complete' || $data2['status'] == 'Close')
                                <a href="#addModal" data-toggle="modal" data-target="#addModal{{$data2['parent_video_upload_id']}}" class="btn btn-success" title="View" data-toggle="modal" data-target="#templates" style="margin-inline:5px"><i class="fa fa-pencil"></i></a>
                                @elseif($data2['status'] == 'New' || $data2['status'] == 'Rejected')
                                <button class="btn btn-info" style="margin-inline:5px" disabled><i class="fa fa-pencil"></i></button>
                                @else
                                @php $cuModaliteration1 = $cuModaliteration1+1; @endphp
                                <a href="#cuModal{{$cuModaliteration1}}" class="btn btn-success" data-toggle="modal" title="View" style="margin-inline:5px"><i class="fa fa-pencil"></i></a>
                                @endif
                                <label class='switch' data-bs-toggle='tooltip' data-bs-placement='top' title='Enable / Disable'><input type='checkbox' class='toggle_status' onclick="functiontoggle('{{$data2['parent_video_upload_id']}}')" id="is_active{{$data2['parent_video_upload_id']}}" name='is_active' @if($data2['enableflag']=='0' ) checked @endif><span class='slider round'></span></label>
                              </div>
                            </td>
                            <!-- <td>
                          @if($data2['status'] == 'Submitted' || $data2['status'] == 'Re-Sent')
                          <input type="checkbox" class="approved selectAll_id{{$row1['activity_id']}}" id="approved{{$data2['parent_video_upload_id']}}" name="approved" order="{{$row1['activity_id']}}" value="{{$data2['parent_video_upload_id']}}">
                          @else
                          <input type="checkbox" onclick="return false;" value="{{$data2['parent_video_upload_id']}}">
                          @endif
                        </td> -->
                          </tr>
                          @endif
                          @endforeach
                        </tbody>
                      </table>
                      <!-- View 2 End -->

                      <!-- View 3 -->
                      <!-- View - 2 -->
                      <table class="table table-bordered Tableview View3" id="activity{{$loop->iteration}}" style="display:none">
                        <thead>
                          <tr>
                            <th>Sl.No</th>
                            <th>Activity Description</th>

                            <th>Instruction</th>
                          </tr>
                        </thead>
                        <tbody>
                          @php $iteration = 0; @endphp
                          @foreach($lastactivity as $key=>$data2)
                          @if($data2['activity_id'] == $row1['activity_id'])
                          @if($data2['enableflag'] == 0)
                          @php $iteration = $iteration+1; @endphp
                          <tr>
                            <td>{{ $iteration }}</td>
                            <td>{{$data2['description']}}</td>
                            <td>{!! $data2['instruction'] !!}</td>


                          </tr>
                          @endif
                          @endif
                          @endforeach
                        </tbody>
                      </table>

                      <!-- View 3 End -->
                    </div>
                  </div>
                </div>
              </div>
              @endforeach
            </div>
          </div>
        </div>
      </div>
      @endforeach
    </div>
    <br>
    <div class="col-md-12 d-flex justify-content-center">
      <a type="button" class="btn btn-labeled btn-info" id="Previous_tab" title="Previous" style="height: 35px; background: blue !important; border-color: blue !important; color: white !important;display:none !important;">
        <span class="btn-label" style="font-size: 13px !important;"><i class="fa fa-arrow-left"></i></span> Previous
      </a>


      <a type="button" class="btn btn-labeled btn-info" id="Next_tab" title="Next" style="background: blue !important; border-color: #4d94ff !important; color: white !important; height: 35px;">
        <span class="btn-label" style="font-size: 13px !important;">Next</span> <i class="fa fa-arrow-right"></i>
      </a>
    </div>
    </section>
  </div>
  <script>
    function toggleLike(id) {
      var checkbox = document.getElementById("likeCheckbox" + id);
      var likeText = document.getElementById("likeText" + id);

      if (checkbox.checked) {
        likeText.innerHTML = '<i class="fas fa-star"></i>';
        likeText.classList.add("liked");
      } else {
        likeText.innerHTML = '<i class="far fa-star"></i>';
        likeText.classList.remove("liked");
      }
    }

    function f2f_toggle(e) {
      document.getElementById('f2f_activity').innerHTML = e.getAttribute('data-lable');
      $("#f2fmodal").modal();
    }
  </script>
  <script>
    // function view_change() {
    //   var Tableview = $('#Tableview').val();
    //   $('.Tableview').hide();
    //   $('.View' + Tableview).show();

    //   // var selects = document.querySelectorAll('.selectView');
    //   // selects.forEach(select => {
    //   //   select.value = Tableview;
    //   // });

    // }

    const selects = document.querySelectorAll('.selectView');
    selects.forEach(select => {
      select.addEventListener('change', e => {
        const selectedValue = e.target.value;

        // Hide all views first
        $('.Tableview').hide();
        $('.View').hide();

        // Show the view corresponding to the selected value
        $('.View' + selectedValue).show();
      });
    });


    function selectall(sId) {
      var selectall = <?php echo json_encode($lastactivity); ?>;
      var selectallButton = 0;
      for (select of selectall) {
        if (select.activity_id == sId) {
          if (select.status == 'Submitted' || select.status == 'Re-Sent') {
            var pId = select.parent_video_upload_id; //console.log(pId);
            selectallButton = 1;
            if ($('#selectAll' + sId).prop('checked')) {
              document.getElementById("approved" + pId).checked = true;
            } else {
              document.getElementById("approved" + pId).checked = false;
            }
          }
        }
      }

      if (selectallButton == 0) {
        document.getElementById("selectAll" + sId).checked = false;
      }

      var showcomplete = $('.approved:checkbox:checked').length;
      if (showcomplete > 0) {
        $(".bulkapproved").show();
      } else {
        $(".bulkapproved").hide();
      }

    }

    $(document).ready(function() {
      var actbadges = <?php echo json_encode($lastactivity); ?>;
      for (actbadge of actbadges) {
        if (actbadge.status == 'Submitted' || actbadge.status == 'Re-Sent') {
          var actID = actbadge.activity_id;
          $("#badge" + actID).addClass("badgeact");
        }
      }
    });

    function functiontoggle(id) {
      // alert($('#is_active' + id).prop('checked'));
      if ($('#is_active' + id).prop('checked')) {
        var is_active = '0';
      } else {
        var is_active = '1';
      }
      var f_id = id;

      $.ajax({
        url: "{{ route('activity_initiate.update_toggle') }}",
        type: 'POST',
        data: {
          is_active: is_active,
          f_id: f_id,
          _token: '{{csrf_token()}}'
        },
        error: function() {
          alert('Something is wrong');
        },
        success: function(data) {

          var data_convert = $.parseJSON(data);

          // console.log(data_convert.Data);
          if (data_convert.Data == 1) {
            swal.fire("Success", "Activity Deactivated", "success");
          } else {
            swal.fire("Success", "Activity Activated", "success");
          }

        }


      });
    }
  </script>
  <form action="{{route('activity.update.video')}}" id="video_update" method="POST">
    @csrf
    <input type="hidden" id="check_video" name="check_video">
    <input type="hidden" id="enrollment_id" name="enrollment_id" value="{{$rows[0]['enrollment_id']}}">
    <input type="hidden" id="is_active_tab" name="is_active_tab">

    @foreach($currentactivity as $key => $data)
    <div class="modal fade cuModalPopup" id="cuModal{{$loop->iteration}}" role="dialog">
      <div class="modal-dialog modal-xl">
        <div class="modal-content">
          <div class="main-contents">
            <div class="modal-body" style="padding: 0; /*background-color: #edfcff !important; */">
              <div class="">
                <div class="card-body" style="height: 520px !important;overflow-y: scroll;">
                  <div class="row">
                    <div class="col-md-6">
                      <div class="form-group">
                        <label class="control-label">Activity Name</label><span class="error-star" style="color:red;">*</span>
                        <input class="form-control" type="text" id="activity_id" name="activity_id[{{$data['parent_video_upload_id']}}]" value="{{ $data['activity_name']}}" autocomplete="off" readonly>
                      </div>
                    </div>

                    <div class="col-md-6">
                      <div class="form-group">
                        <label class="control-label">Activity Description</label><span class="error-star" style="color:red;">*</span>
                        <input class="form-control" type="text" id="description_id" name="description_id[{{$data['parent_video_upload_id']}}]" value="{{ $data['description']}}" autocomplete="off" readonly>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                        <label class="control-label">Instruction</label><span class="error-star" style="color:red;">*</span>
                        <p>{!! html_entity_decode($data['instruction']) !!}</p>
                      </div>
                    </div>
                    <div class="w-100"></div>
                    <div class="col-md-6">
                      <div class="form-group">
                        <label class="control-label">Video Link</label><span class="error-star" style="color:red;">*</span>
                        @foreach($video_link as $data1)
                        @if($data['parent_video_upload_id'] == $data1['parent_video_upload_id'])
                        <div style="display: flex;">
                          <input type="checkbox" value="{{$data1['video_link_id']}}" name="video_check" id="video_check" checked>
                          <input class="form-control" type="text" id="video_link" name="video_link" autocomplete="off" value="{{ $data1['video_link']}}">
                          <a class="btn btn-link" title="show" target="_blank" href="{{ $data1['video_link']}}"><i class="fas fa-eye" style="color:green"></i></a>
                          <!-- <div style="color: rgb(246, 15, 15); display: block;margin: 5px 0px 0px 0px;">Google Drive Link Only</div> -->
                        </div>
                        @endif
                        @endforeach
                      </div>

                      <div class="form-group">
                        <label class="control-label">Approval Status</label><span class="error-star" style="color:red;">*</span>
                        <select class="form-control cuModalSelect bsjcxsd" name="approval_status[{{$data['parent_video_upload_id']}}]" id="approval_status{{$data['parent_video_upload_id']}}" onchange="app_status('{{$data['parent_video_upload_id']}}')">
                          <option value="">Select Status</option>
                          @if($data['save_status1'] == 'Complete')
                          <option value="Complete" selected>Approve</option>
                          @else
                          <option value="Complete">Approve</option>
                          @endif
                          @if($data['save_status1'] == 'Rejected' && $data['status'] != 'Re-Sent')
                          <option value="Rejected" selected>Reject</option>
                          @else
                          <option value="Rejected">Reject</option>
                          @endif

                          <!-- <option value="Close">Close</option> -->
                        </select>
                      </div>
                      <input type="checkbox" @if($data['f2f_flag']==1) checked @endif name="enablef2f[{{$data['parent_video_upload_id']}}]" id="enablef2f{{$data['parent_video_upload_id']}}" onclick="openf2ftable('{{$data['parent_video_upload_id']}}')"><label for="enablef2f"> Face To Face</label>

                    </div>

                    <input type="hidden" id="activity_description_id" name="activity_description_id[]" value="{{$data['activity_description_id']}}">
                    <input type="hidden" id="parent_video_upload_id" name="parent_video_upload_id[]" value="{{$data['parent_video_upload_id']}}">
                    <input type="hidden" id="activity_initiation_id" name="activity_initiation_id[{{$data['parent_video_upload_id']}}]" value="{{$data['activity_initiation_id']}}">
                    <div class="col-md-6">
                      <label class="control-label comments_label">Previous Notes </label><br>
                      <div class="form-group scroll_flow_class">
                        @foreach($comments as $key=>$note_data)
                        @if($data['parent_video_upload_id'] == $note_data['parent_video_upload_id'])
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

                    <div class="col-md-6">
                      @if($data['save_status1'] == 'Complete')
                      <div class="form-group" id="observationDiv{{$data['parent_video_upload_id']}}">
                        @else
                        <div class="form-group" id="observationDiv{{$data['parent_video_upload_id']}}" style="display: none;">
                          @endif
                          <label class="control-label">Observation</label>
                          <textarea class="form-control cuModaltextarea" name="observation[{{$data['parent_video_upload_id']}}]" id="observation{{$data['parent_video_upload_id']}}">{{$data['comments']}}</textarea>
                        </div>
                      </div>

                      <div class="col-md-6">
                        <div class="form-group">
                          <label class="control-label">Comments for Parent</label>
                          <textarea class="form-control cuModaltextarea" name="comments[{{$data['parent_video_upload_id']}}]" id="comments"></textarea>
                        </div>
                      </div>
                      <!-- F2F -->
                      <div class="col-md-12" @if($data['f2f_flag']==1) style="padding: 0" @else style="display: none;padding: 0" @endif id="f2ftable{{$data['parent_video_upload_id']}}">
                        <div class="table-wrapper">
                          <div class="table-responsive">
                            <table class="table table-bordered" id="activity">
                              <thead>
                                <tr>
                                  <th width="40%" style="height: 20px;">Materials required</th>
                                  <th width="30%" style="height: 20px;">To observe</th>
                                  <th width="30%" style="height: 20px;">To ask parents</th>
                                </tr>
                              </thead>
                              <tbody>
                                <tr>
                                  <!-- <td><textarea class="form-control" name="materials_required[{{$data['parent_video_upload_id']}}]" id=""></textarea></td> -->
                                  <td>

                                    @php $activity_materials_id = 0; @endphp
                                    @foreach($activity_materials_mapping as $mapping)
                                    @if($data['activity_description_id'] == $mapping['activity_description_id'])
                                    @php $activity_materials_id = $mapping['activity_materials_id']; @endphp
                                    @break
                                    @endif
                                    @endforeach
                                    <!-- f2f_observation -->

                                    <select data-placeholder="Select Materials" multiple class="chosen-select" name="material[{{$data['parent_video_upload_id']}}][]" style="width: 100% !important;">
                                      @foreach($activity_materials as $material)
                                      @if(in_array($material['id'] , explode(',', $activity_materials_id) ))
                                      @if(in_array($material['materials'] , explode(',', $data['materials_required']) ))
                                      <option value="{{$material['materials']}}" selected>{{$material['materials']}}</option>
                                      @else
                                      <option value="{{$material['materials']}}">{{$material['materials']}}</option>
                                      @endif
                                      @endif
                                      @endforeach
                                      <optgroup label="------------------------------------------------">
                                        @foreach($activity_materials as $material)
                                        @if(!in_array($material['id'] , explode(',', $activity_materials_id) ))
                                        @if(in_array($material['materials'] , explode(',', $data['materials_required']) ))
                                        <option value="{{$material['materials']}}" selected>{{$material['materials']}}</option>
                                        @else
                                        <option value="{{$material['materials']}}">{{$material['materials']}}</option>
                                        @endif
                                        @endif
                                        @endforeach
                                    </select>

                                  </td>
                                  <td><textarea class="form-control" name="to_observe[{{$data['parent_video_upload_id']}}]" id="">{{$data['to_observe']}}</textarea></td>
                                  <td><textarea class="form-control" name="to_ask_parents[{{$data['parent_video_upload_id']}}]" id="">{{$data['to_ask_parents']}}</textarea></td>
                                </tr>
                              </tbody>
                            </table>
                          </div>
                        </div>
                      </div>
                      <!--  -->
                    </div>
                  </div>
                </div>
                <div class="col-md-12  text-center" style="padding: 5px;">
                  @if($loop->iteration > 1)
                  <a type="button" class="btn btn-labeled btn-info" onclick="showModalPrev('{{$loop->iteration}}')" id="Previous" title="Previous" style="height: 35px;background: blue !important; border-color:blue !important; color:white !important">
                    <span class="btn-label" style="font-size:13px !important;"><i class="fa fa-arrow-left"></i></span> Previous</a>
                  @endif
                  <a type="button" onclick="tempSave('{{$data['parent_video_upload_id']}}')" id="submitbutton" class="btn btn-labeled btn-succes" title="Save" style="background: green !important; border-color:green !important; color:white !important">
                    <span class="btn-label" style="font-size:13px !important;"><i id="checkIcon{{$data['parent_video_upload_id']}}" class="fa fa-check"></i></span>Save</a>
                  <a type="button" onclick="saveall('{{$data['parent_video_upload_id']}}')" id="submitbutton" class="btn btn-labeled btn-succes" title="Submit" style="background: green !important; border-color:green !important; color:white !important">
                    <span class="btn-label" style="font-size:13px !important;"><i class="fa fa-check"></i></span>Submit</a>
                  <a type="button" class="btn btn-labeled back-btn" onclick="confirmclose('{{$loop->iteration}}')" data-dismiss="modal" aria-hidden="true" title="Close" style="color:white !important"><span class="btn-label" style="font-size:13px !important;"><i class="fa fa-times-circle-o"></i></span> Close</a>
                  @if($loop->iteration != count($currentactivity))
                  <a type="button" class="btn btn-labeled btn-info" onclick="showModalNext('{{$loop->iteration}}')" id="Next" title="Next" style="background: blue !important; border-color:#4d94ff !important; color:white !important;height: 35px;">
                    <span class="btn-label" style="font-size:13px !important;">Next</span> <i class="fa fa-arrow-right"></i></a>
                  @endif
                </div>

              </div>
            </div>
          </div>
        </div>
      </div>
      @endforeach
  </form>
  <script>
    $(".chosen-select").select2({
      closeOnSelect: false,
      placeholder: " Please Select Users",
      allowHtml: true,
      tags: true
    });
    // $(".chzn-select").chosen();
  </script>
  <script>
    function openf2ftable(fid) {
      if ($('#enablef2f' + fid).prop('checked')) {
        $('#f2ftable' + fid).show();
      } else {
        $('#f2ftable' + fid).hide();
      }
    }

    function showModalNext(id) {
      var id = Number(id) + 1;
      $(".modal").modal('hide');
      $("#cuModal" + id).modal();
    }

    function showModalPrev(id) {
      var id = Number(id) - 1;
      $(".modal").modal('hide');
      $("#cuModal" + id).modal();
    }

    function confirmclose(pvid) {
      $("#cuModal" + pvid).modal();
      // Swal.fire({
      //   title: 'Are you sure you want to close?',
      //   text: 'Your data will be lost',
      //   icon: 'question',
      //   showCancelButton: true,
      //   confirmButtonText: 'Yes',
      //   cancelButtonText: 'No'
      // }).then((result) => {
      //   if (result.isConfirmed) {
      //     var selectFields = document.querySelectorAll('.cuModalPopup .cuModalSelect');
      //     selectFields.forEach(function(select) {
      //       select.value = "";
      //       select.selectedIndex = 0;
      //     });

      //     var textareaFields = document.querySelectorAll('.cuModalPopup .cuModaltextarea');
      //     textareaFields.forEach(function(textarea) {
      //       textarea.value = null;
      //     });
      //     // location.reload();
      //     // window.location = "/activity_initiate_reload/"+1;
      //   } else {
      //     $("#cuModal" + pvid).modal();
      //   }
      // });

    }
  </script>
  @php $modalIndex = 0; @endphp

  @foreach($lastactivity1 as $key => $data)

  <div class="modal fade editModal{{$data['activity_description_id']}}" id="addModal{{$data['parent_video_upload_id']}}">
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
                    <div class="col-12">
                      <div class="card">
                        <div class="card-body scrollmodal">
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
                            <div class="col-md-6">
                              <div class="form-group">
                                <label class="control-label">Instruction</label><span class="error-star" style="color:red;">*</span>
                                <p>{!! html_entity_decode($data['instruction']) !!}</p>
                              </div>
                            </div>
                            <div class="w-100"></div>
                            <input type="hidden" id="check_video{{$data['parent_video_upload_id']}}" name="check_video">
                            <div class="col-md-6">
                              <div class="form-group">
                                <label class="control-label">Video Link</label><span class="error-star" style="color:red;">*</span>
                                @foreach($video_link as $data1)
                                @if($data['parent_video_upload_id'] == $data1['parent_video_upload_id'])
                                <div style="display: flex;">
                                  <!-- <input type="checkbox" value="{{$data1['video_link_id']}}" name="video_check" id="video_check" checked> -->
                                  <input class="form-control" type="text" id="video_link" name="video_link" autocomplete="off" value="{{ $data1['video_link']}}">
                                  <a class="btn btn-link" title="show" target="_blank" href="{{ $data1['video_link']}}"><i class="fas fa-eye" style="color:green"></i></a>
                                  <!-- <div style="color: rgb(246, 15, 15); display: block;margin: 5px 0px 0px 0px;">Google Drive Link Only</div> -->
                                </div>
                                @endif
                                @endforeach
                              </div>

                              <div class="form-group">
                                <label class="control-label">Approval Status</label><span class="error-star" style="color:red;">*</span>
                                <select class="form-control" name="approval_status" id="approval_status{{$data['parent_video_upload_id']}}" onchange="app_status('{{$data['parent_video_upload_id']}}')">
                                  <!-- <option value="">Select Status</option> -->
                                  <option value="Complete" {{ $data['status'] == 'Complete' ? 'selected' : '' }}>Approved</option>
                                  <!-- <option value="Rejected" {{ $data['status'] == 'Rejected' ? 'selected' : '' }}>Reject</option> -->
                                  <!-- <option value="Close">Close</option> -->
                                </select>
                              </div>
                            </div>

                            <input type="hidden" id="activity_description_id" name="activity_description_id" value="{{$data['activity_description_id']}}">
                            <input type="hidden" id="parent_video_upload_id" name="parent_video_upload_id" value="{{$data['parent_video_upload_id']}}">
                            <div class="col-md-6">
                              <label class="control-label comments_label">Previous Notes </label><br>
                              <div class="form-group scroll_flow_class">
                                @foreach($comments as $key1=>$note_data)
                                @if($data['parent_video_upload_id'] == $note_data['parent_video_upload_id'])
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

                            <div class="col-md-6">
                              <div class="form-group" id="observationDiv{{$data['parent_video_upload_id']}}">
                                <label class="control-label">Observation</label>
                                <textarea class="form-control" name="observation" id="observation{{$data['parent_video_upload_id']}}">{{$data['comments']}}</textarea>
                              </div>
                            </div>

                            <!-- <div class="col-md-6">
                              <div class="form-group">
                                <label class="control-label">Comments for Parent</label>
                                <textarea class="form-control" name="comments" id="comments"></textarea>
                              </div>
                            </div> -->

                          </div>
                        </div>
                      </div>
                    </div>
                  </div>

                  <div class="col-md-12  text-center" style="padding-top: 1rem;">
                    @if(isset($lastactivity1[$key-1]))
                    <a type="button" class="btn btn-labeled btn-info Previoussubmission" onclick="showPrevModal('{{isset($lastactivity1[$key-1]) ? $lastactivity1[$key-1]['activity_description_id'] : 'helo'}}')" id="Previoussubmission" title="Previous" style="height: 35px;background: blue !important; border-color:blue !important; color:white !important;">
                      <span class="btn-label" style="font-size:13px !important;"><i class="fa fa-arrow-left"></i></span> Previous</a>
                    @endif
                    <a type="button" onclick="save('{{$data['parent_video_upload_id']}}')" id="submitbutton" class="btn btn-labeled btn-succes" title="save" style="background: green !important; border-color:green !important; color:white !important">
                      <span class="btn-label" style="font-size:13px !important;"><i class="fa fa-check"></i></span>Update</a>
                    @if ($loop->iteration != count($lastactivity1))
                    <a type="button" class="btn btn-labeled btn-info Nextsubmission" onclick="showNextModal('{{isset($lastactivity1[$key+1]) ? $lastactivity1[$key+1]['activity_description_id'] : 'null'}}')" id="Nextsubmission" title="Next" style="background: blue !important; border-color:#4d94ff !important; color:white !important;height: 35px;">
                      <span class="btn-label" style="font-size:13px !important;">Next</span> <i class="fa fa-arrow-right"></i></a>

                    @endif
                  </div>

                </div>
            </section>
          </div>
        </div>
      </div>
    </form>
  </div>

  @php $modalIndex++; @endphp

  @endforeach
  <script>
    var lastActivity = <?php echo json_encode($lastactivity1); ?>; // JavaScript/jQuery code to control modal navigation
    var modalIndex = 0; // Initial modal index
    // alert(modalIndex);
    // console.log(lastActivity);

    function showPrevModal(id) {
      var id = Number(id);

      $(".modal").modal('hide');

      $(".editModal" + id).modal();

    }

    function showNextModal(id) {
      var id = Number(id);
      $(".modal").modal('hide');

      $(".editModal" + id).modal();
    }

    function updateNavigationButtons() {
      // Show or hide the "Next" button based on the current modal index
      // console.log("Current modalIndex:", modalIndex);
      // console.log("lastActivity length:", lastActivity.length);
      if (modalIndex == lastActivity.length - 1) {
        $('.Nextsubmission').hide();
        // console.log("Hiding 'Next' button");
      } else {
        $('.Nextsubmission').show();
        // console.log("Showing 'Next' button");
      }
    }
  </script>

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
                    <div class="col-12">
                      <div class="card">
                        <div class="card-body scrollmodal">
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
                            <div class="col-md-6">
                              <div class="form-group">
                                <label class="control-label">Instruction</label><span class="error-star" style="color:red;">*</span>
                                <p>{!! html_entity_decode($data['instruction']) !!}</p>
                              </div>
                            </div>
                            <div class="w-100"></div>
                            <div class="col-md-6">
                              <div class="form-group">

                                <label class="control-label">Video Link</label><span class="error-star" style="color:red;">*</span>
                                @foreach($video_link as $data1)
                                @if($data['parent_video_upload_id'] == $data1['parent_video_upload_id'])

                                <div style="display: flex;">
                                  <input class="form-control" type="text" id="video_link" name="video_link" autocomplete="off" value="{{ $data1['video_link']}}">
                                  <a class="btn btn-link" title="show" target="_blank" href="{{ $data1['video_link']}}"><i class="fas fa-eye" style="color:green"></i></a>

                                  <!-- <div style="color: rgb(246, 15, 15); display: block;margin: 5px 0px 0px 0px;">Google Drive Link Only</div> -->
                                </div>
                                @endif
                                @endforeach
                              </div>

                              <div class="form-group">
                                <label class="control-label">Observation</label>
                                <textarea class="form-control" name="observation" id="observation{{$data['parent_video_upload_id']}}" readonly>{{$data['comments']}}</textarea>
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
                    </div>
                  </div>

                  <!-- <div class="col-md-12  text-center" style="padding-top: 1rem;">
                  <a type="button" onclick="save('{{$data['parent_video_upload_id']}}')" id="submitbutton" class="btn btn-labeled btn-succes" title="save" style="background: green !important; border-color:green !important; color:white !important">
                    <span class="btn-label" style="font-size:13px !important;"><i class="fa fa-check"></i></span>Submit</a>
                </div> -->

                </div>
            </section>
          </div>
        </div>
      </div>
    </div>
  </form>
  @endforeach
  <input type="hidden" id="action" name="action">
  <div class="modal fade" id="chartmodal">
    <div class="modal-dialog modal-lg">

      <div class="modal-content">
        <!-- <button type="button" class="close" data-dismiss="modal" style="background-color: black;" aria-label="Close"><span aria-hidden="true">&times;</span></button>   -->
        <div class="modal-body">
          <div>
            <div class="table-wrapper">
              <div class="table-responsive">


                <table class="table table-bordered" id="activity">
                  <thead>
                    <tr>
                      <th width="5%">Sl.No</th>
                      <th>Activity Name</th>
                      <th>Observation</th>
                      <th>Comment</th>
                    </tr>
                  </thead>
                  <tbody id="newtable">
                    <tr>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" style="background: dodgerblue;" class="btn btn-default" onclick="finalsub()">Submit</button>
            <button type="button" style="background: dodgerblue;" class="btn btn-default" id="btnclose" data-dismiss="modal">Close</button>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="modal fade" id="f2fmodal">
    <div class="modal-dialog modal-xl">
      <div class="modal-content">
        <div class="modal-body">
          <div>
            <div class="table-wrapper">
              <div class="table-responsive">
                <table class="table table-bordered" id="activity">
                  <thead>
                    <tr>
                      <th width="5%">Sl.No</th>
                      <th>Activity Name</th>
                      <th>Materials required</th>
                      <th>To observe</th>
                      <th>To ask parents</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td>1</td>
                      <td id="f2f_activity"></td>
                      <td><input type="text"></td>
                      <td><input type="text"></td>
                      <td><input type="text"></td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" style="background: dodgerblue;" class="btn btn-default" onclick="finalsub()">Submit</button>
            <button type="button" style="background: dodgerblue;" class="btn btn-default" id="btnclose" data-dismiss="modal">Close</button>
          </div>
        </div>
      </div>
    </div>
  </div>
  @foreach($activity as $row1)

  <div class="modal fade" id="dataModal">
    <div class="modal-dialog modal-xl">
      <div class="modal-content">
        <div class="main-contents">
          <section class="section">
            <div class="modal-header bg-primary" style=" background-color: rgb(0 103 172) !important;">
              <h4 class="modal-title">Overall Activity Observation Preview</h4>
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            </div>
            <div class="modal-body" style="background-color: #edfcff !important;">
              <div class="section-body mt-2">
                <div class="row">
                  <div class="col-md-12">
                    <div class="mt-0 ">
                      <div class="card-body" id="card_header" style="overflow-y: auto; max-height: 300px;">
                        <table style="width: 100%; max-width: 100%;" class="table table-bordered Tableview View1" id="activity{{$loop->iteration}}">
                          @foreach($datalist as $key=>$data)
                          <thead>

                            <tr>
                              <th colspan="6">{{$key}}</th>
                            </tr>

                            <tr>
                              <th style="width: 10%;">Sl.No</th>
                              <th style="width: 30%;">Activity Description</th>
                              <th style="width: 10%;">Status</th>
                              <th style="width: 20%;">Comment</th>
                              <th style="width: 15%;">Video link</th>
                              <th style="width: 15%;">Observation</th>

                            </tr>
                          </thead>
                          <tbody>
                            @foreach($data as $innerKey => $item)
                            <tr>
                              <td>{{ $innerKey + 1 }}</td>
                              <td>{{ $item->description }}</td>
                              @if($item->f2f_flag == '1')
                              <td>F2F</td>
                              @elseif($item->status == 'Complete')
                              <td>Approved</td>
                              @else
                              <td>{{ $item->status }}</td>
                              @endif
                              <td>{{ $item->parent_comment }}</td>
                              <td class="video-link-cell" title="Click to view the link" style="max-width: 200px; overflow: hidden; text-overflow: ellipsis;">{{ $item->video_link }}</td>
                              <td>{{ $item->comments}}</td>

                            </tr>
                            @endforeach
                          </tbody>
                          @endforeach
                        </table>

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
  @endforeach
  <script>
    document.addEventListener('DOMContentLoaded', function() {
      var videoLinkCells = document.querySelectorAll('.video-link-cell');

      videoLinkCells.forEach(function(cell) {
        cell.addEventListener('click', function(event) {
          var url = cell.textContent.trim();

          if (url && !cell.classList.contains('expanded')) {
            event.preventDefault();
            window.open(url, '_blank');
          } else {
            cell.classList.toggle('expanded');
          }
        });
      });
    });
  </script>

  <script>
    function app_status(id) {
      var approvalstatus = $('#approval_status' + id).val();
      if (approvalstatus == 'Complete') {
        $('#observationDiv' + id).show();
      } else {
        $('#observationDiv' + id).hide();
      }
    }
    var ckbox = $("input[name='approved']");
    $('.approved').on('click', function(e) {
      // console.log(e.target.getAttribute('order'));
      var order = e.target.getAttribute('order');
      if (ckbox.is(':checked')) {
        $(".bulkapproved").show();
      } else {
        $(".bulkapproved").hide();
      }

      var hidecomplete = $('.selectAll_id' + order + ':checkbox:checked').length;
      var hidecomplete1 = $('.selectAll_id' + order + ':checkbox').length;
      if (hidecomplete == 0) {
        document.getElementById("selectAll" + order).checked = false;
      } else {
        if (hidecomplete == hidecomplete1) {
          document.getElementById("selectAll" + order).checked = true;
        } else {
          document.getElementById("selectAll" + order).checked = false;
        }
      }

    });

    function setBulkAction(action) {
      var action = action;
      document.getElementById('action').value = action;

      var lastactivity = <?php echo json_encode($lastactivity); ?>;
      var optionsdata;
      var ii = 0;
      $("input[name='approved']:checked").each(function() {
        chkId = $(this).val();

        for (ai = 0; ai < lastactivity.length; ai++) {
          activity = lastactivity[ai];
          if (activity.parent_video_upload_id == chkId) {
            ii = ii + 1;
            var name = activity.description;
            var parent_video_upload_id = activity.parent_video_upload_id;
            optionsdata += "<tr><td >" + (parseInt(ii)) + "</td><td>" + name + "</td>";
            optionsdata += "<td><textarea class='form-control' name='observation_bulk' id='observation_bulk" + parent_video_upload_id + "'></textarea></td>"
            optionsdata += "<td><textarea class='form-control' name='comment_bulk' id='comment_bulk" + parent_video_upload_id + "'></textarea></td></tr>"
          }
        }
      });
      var demonew = $('#newtable').html(optionsdata);

      if (action == 'Complete') {
        $("#chartmodal").modal();
      } else {
        finalsub();
      }

    }

    function finalsub() {
      Swal.fire({
        title: 'Are you sure?',
        text: "Please click Yes to Update  the status of activity",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes'
      }).then((result) => {
        if (result.isConfirmed) {
          var allchecked = {};
          $("input[name='approved']:checked").each(function() {
            var chkId1 = $(this).val();
            var chkval = document.getElementById('observation_bulk' + chkId1).value;
            // console.log(document.getElementById('observation_bulk' + chkId1).value);
            allchecked[chkId1] = chkval;
          });

          var comment = {};
          $("input[name='approved']:checked").each(function() {
            var chkId1 = $(this).val();
            var chkval = document.getElementById('comment_bulk' + chkId1).value;
            // console.log(document.getElementById('observation_bulk' + chkId1).value);
            comment[chkId1] = chkval;
          });

          // console.log(allchecked);
          var approval = document.getElementById('action').value;
          var aID = document.getElementById('aID').value;

          $.ajax({
            url: "{{ url('/activity/edit/bulk') }}",
            type: 'POST',
            data: {
              'approval': approval,
              'pvID': allchecked,
              'aID': aID,
              'comment': comment,
              _token: '{{csrf_token()}}'
            }
          }).done(function(data) {
            if (data != '[]') {
              if (data.Code == 200) {

                swal.fire("Success!", "Activity Status and Observation Submitted successfully.", "success").then(function() {
                  location.reload();
                });

              } else {
                Swal.fire('Info!', data.Message, 'info');
                return false;
                // location.reload();
              }
            }
          })
        } else {
          return false;
        }
      });

    }
  </script>
  <script type="text/javascript">
    function save(id) {
      // const video_checks = document.querySelectorAll('#video_check');
      // var check = [];
      // var checkindex = 0;
      // for (let i = 0; i < video_checks.length; i++) {
      //   if(video_checks[i].checked==false){
      //     check[i]= video_checks[i].value;
      //   }
      // }
      // var i = 0;
      // for (let video_check of video_checks) {
      //   if (video_check.checked == false) {

      //     check[i] = video_check.value;
      //     i++;
      //   }
      // }
      // document.getElementById('check_video' + id).value = check;
      // console.log(document.getElementById('check_video' + id).value);
      // var approval_status = $('#approval_status' + id).val();
      // if (approval_status == '' || approval_status == null) {
      //   swal.fire("Please Select Approval Status", "", "error");
      //   return false;
      // }
      // alert(id);
      $(".loader").show();
      document.getElementById('userregistrationa' + id).submit('saved');


    }

    function saveall(parent_video_upload_id) {

      const approvalSelect = document.querySelector('#approval_status' + parent_video_upload_id);
      if (!approvalSelect.value) {
        swal.fire("Please select Approval Status for the current activity", "", "error");
        return false;
      }

      const f2fCheckbox = document.getElementById('enablef2f' + parent_video_upload_id);
      if (f2fCheckbox && f2fCheckbox.checked) {
        const materialsSelect = document.querySelector('select[name="material[' + parent_video_upload_id + '][]"]');
        if (!materialsSelect || !materialsSelect.selectedOptions.length) {
          swal.fire("Please select at least one Material Required for Face To Face activity.", "", "error");
          return;
        }
      }

      const video_checks = document.querySelectorAll('#video_check');
      var check = [];
      var i = 0;
      for (let video_check of video_checks) {
        if (video_check.checked == false) {
          check[i] = video_check.value;
          i++;
        }
      }
      document.getElementById('check_video').value = check;
      $(".loader").show();
      document.getElementById('video_update').submit();

    }

    function tempSave(pID) {
      const video_checks = document.querySelectorAll('#video_check');
      var check = [];
      var i = 0;
      for (let video_check of video_checks) {
        if (video_check.checked == false) {
          check[i] = video_check.value;
          i++;
        }
      }
      document.getElementById('check_video').value = check;

      var form = $('#video_update');
      var formData = form.serialize()  + "&pvID=" + pID ;
      // console.log(formData);

      var checkIcon = document.getElementById("checkIcon" + pID);
      checkIcon.classList.remove("fa-check");
      checkIcon.classList.add("fa-spinner", "fa-spin");

      $.ajax({
        url: "{{ route('activity.save.video') }}",
        type: 'POST',
        data: formData,
        error: function() {
          // alert('Something is wrong');
          console.log('Something went wrong');
        },
        success: function(data) {
          // console.log('Success');
          checkIcon.classList.remove("fa-spinner", "fa-spin");
          checkIcon.classList.add("fa-check");
          Swal.fire('Info!', 'Activity Status and Observation  saved successfully.', 'info');
          // alert('Success');
          // var softAlert = document.createElement("div");
          // softAlert.textContent = "This is a soft alert!";
          // softAlert.className = "soft-alert";
          // document.body.appendChild(softAlert);
          // setTimeout(function() {
          //   softAlert.parentNode.removeChild(softAlert);
          // }, 3000);
        }
      });

    }
  </script>
  <script>
    function activeStatus() {
      var approval_status = $('#approval_status').val();

      if (approval_status == '' || approval_status == null) {
        swal.fire("Please Select Approval Status", "", "error");
        return false;
      }
      $(".loader").show();
      document.getElementById('activeStatus').submit();
    }
  </script>
  <script>
    // Tabs
    const tabBtns = document.querySelectorAll(".tabs__btn");
    const tabPanes = document.getElementsByClassName("tabs__pane");

    let fadeTime = 200;

    function fadeOut(target) {
      target.style.opacity = 1;
      target.style.transition = `opacity ${fadeTime}ms`;
      target.style.opacity = 0;
      setTimeout(() => {
        target.style.display = "none";
      }, fadeTime);
    }

    function fadeIn(target) {
      target.style.opacity = 0;
      target.style.transition = `opacity ${fadeTime}ms`;
      target.style.opacity = 1;
      setTimeout(() => {
        target.style.display = "block";
      }, fadeTime);
    }

    function triggerTab(elt) {
      elt.preventDefault();

      tabBtns.forEach((btn) => {
        btn.classList.remove("is-active");
        btn.setAttribute("aria-selected", false);
      });

      [].forEach.call(tabPanes, (pane) => {
        fadeOut(pane);
      });

      elt.target.classList.add("is-active");
      elt.target.setAttribute("aria-selected", true);
      let clickedTab = elt.target.dataset.tabTarget;
      fadeIn(document.querySelector(`#${clickedTab}`));
      // togglePreviousNextButtons();
    }

    tabBtns.forEach((tab) => {
      tab.addEventListener("click", triggerTab);
    });
  </script>
  <script>
    // $(document).ready(function() {
    //   var table = <?php echo json_encode($activity); ?>;
    //   console.log(table);
    //   for (ti = 0; ti < table.length; ti++) {
    //     var index = ti + 1;
    //     console.log(index);
    //     $('#activity' + index).DataTable({
    //       "lengthMenu": [
    //         [10, 50, 100, 250, -1],
    //         [10, 50, 100, 250, "All"]
    //       ], // page length options
    //       dom: 'lrtip', //lBfrtip
    //     });
    //   }
    // });
  </script>
  <script>
    var ckbox = $("input[name='markRequired']");
    $('.markRequired').on('click', function() {
      // var order = e.target.getAttribute('order');
      if (ckbox.is(':checked')) {
        $(".SelectmarkRequired").show();
      } else {
        $(".SelectmarkRequired").hide();
      }
    });

    function setAsRequired() {
      var activitydata, title, id;
      var ii = 1;

      $("input[name='markRequired']:checked").each(function() {
        id = $(this).val();
        title = $(this).attr('data-title');
        activitydata += (parseInt(ii)) + "." + title + "<br>";
        ii++;
      });
      // console.log(activitydata);
      // var content = tinymce.get('emaildraft').getContent();
      // content = content.replace('listActivity', activitydata);
      // tinymce.get('emaildraft').setContent(content);

      // var content = tinymce.get('emaildraft').getContent();
      // content = content.replace('undefined', '');
      // tinymce.get('emaildraft').setContent(content);

      $("#requiredmodal").modal();
    }
  </script>
  <script>
    document.addEventListener('DOMContentLoaded', function() {
      const tabButtons = document.querySelectorAll('.tabs__btn');
      const tabPanes = document.querySelectorAll('.tabs__pane');
      const nextButton = document.querySelector('#Next_tab');
      const prevButton = document.querySelector('#Previous_tab');
      const scrollViewInput = document.getElementById('scroll_view');
      let currentTab = 0;

      // Add event listeners to each tab button
      tabButtons.forEach((button, index) => {
        button.addEventListener('click', () => {
          changeTab(index);
          scrollToTab(index);
        });
      });

      // Change to a specific tab
      function changeTab(index) {
        tabButtons[currentTab].classList.remove('is-active');
        tabButtons[currentTab].setAttribute('aria-selected', 'false');
        tabPanes[currentTab].classList.remove('is-visible');

        tabButtons[index].classList.add('is-active');
        tabButtons[index].setAttribute('aria-selected', 'true');
        tabPanes[index].classList.add('is-visible');

        currentTab = index;
        checkButtonsVisibility();
      }

      // Check button visibility based on the current tab
      function checkButtonsVisibility() {
        if (currentTab === 0) {
          prevButton.style.display = 'none';
          scrollToTab(currentTab);
        } else {
          prevButton.style.display = 'block';
        }

        if (currentTab === tabButtons.length - 1) {
          nextButton.style.display = 'none';
          scrollToTab(currentTab);
        } else {
          nextButton.style.display = 'block';
        }
      }

      // Scroll to the specified tab
      function scrollToTab(index) {

        // if (index < 0 || index > tabButtons.length) {
        //   return; // Exit early if index is out of bounds
        // }

        const tabButton = tabButtons[index];
        // console.log(tabButton);

        tabButton.scrollIntoView({
          behavior: 'smooth',
          block: 'center',
          inline: 'center'
        });

      }

      // Scroll to the tab specified in the hidden input on page load
      function scrollToViewTab() {
        const scrollViewValue = scrollViewInput.value;
        if (scrollViewValue) {
          const targetIndex = Array.from(tabButtons).findIndex(button => button.value === scrollViewValue);
          if (targetIndex !== -1) {
            changeTab(targetIndex);
            scrollToTab(targetIndex);
          }
        }
      }

      // Add event listeners for Next and Previous buttons
      // nextButton.addEventListener('click', () => {
      //   if (currentTab < tabButtons.length - 1) {
      //     changeTab(currentTab + 1);
      //     scrollToTab(currentTab + 1);
      //   }
      // });

      // prevButton.addEventListener('click', () => {
      //   if (currentTab > 0) {
      //     changeTab(currentTab - 1);
      //     scrollToTab(currentTab - 1);
      //   }
      // });

      nextButton.addEventListener('click', () => {

        if (currentTab < tabButtons.length - 1) {

          changeTab(currentTab + 1);

          var table = @json($activity);
          let checkActivity = Number(document.getElementById('is_active_tab').value);
          console.log('checkActivity', checkActivity);

          let nextActivity = null;

          if (checkActivity === 0) {
            // Special case: next = 2nd item
            nextActivity = table[1] || null;
          } else {
            let checkIndex = table.findIndex(a => a.activity_id === checkActivity);
            nextActivity = (checkIndex !== -1 && checkIndex + 1 < table.length) ?
              table[checkIndex + 1] :
              null;
          }

          if (nextActivity) {
            document.querySelector(`button[value="${nextActivity.activity_id}"]`)?.click();
          }

          scrollToTab(currentTab + 1);

        }
      });

      prevButton.addEventListener('click', () => {


        if (currentTab > 0) {

          changeTab(currentTab - 1);

          var table = @json($activity);
          let checkActivity = Number(document.getElementById('is_active_tab').value);
          console.log('checkActivity', checkActivity);

          let prevActivity = null;

          if (checkActivity === 0) {
            // Special case: previous = 2nd last item
            prevActivity = table[table.length - 2] || null;
          } else {
            let checkIndex = table.findIndex(a => a.activity_id === checkActivity);
            prevActivity = (checkIndex > 0) ?
              table[checkIndex - 1] :
              null;
          }

          if (prevActivity) {
            document.querySelector(`button[value="${prevActivity.activity_id}"]`)?.click();
          }

          scrollToTab(currentTab - 1);

        }
      });


      // Initialize tab and button visibility
      changeTab(currentTab);
      checkButtonsVisibility();
      scrollToViewTab();
    });
  </script>

  <script>
    $(document).ready(function() {
      // Restore the Active Activity Tab
      const urlParams = new URLSearchParams(window.location.search);
      let restoreActivity = urlParams.get('restoreActivity');

      if (restoreActivity) {
        document.getElementById('is_active_tab').value = restoreActivity;
        document.querySelector(`button[value="${restoreActivity}"]`).click();
      } else {
        console.error('restoreActivity not found');
      }
    });
  </script>
  @include('activity_initiate.model')
  @endsection