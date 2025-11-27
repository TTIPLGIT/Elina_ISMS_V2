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
    opacity: 1;
    transition: opacity 500ms;
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
</style>
<div class="main-content" style="min-height:'60px'">
  <!-- Main Content -->
  {{ Breadcrumbs::render('activity_initiate.edit', 1 ) }}

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
      <h5 class="text-center" style="color:darkblue">Uploaded Video List for 13+</h5>

      <form action="" id="activeStatus" method="">
        @csrf
        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-body">
                <div class="row">
                  <div class="col-md-4">
                    <div class="form-group">
                      <label class="control-label">Enrollment Number</label><span class="error-star" style="color:red;">*</span>
                      <input class="form-control" type="text" id="enrollment_id" name="enrollment_id" value="EN/2023/12/070(Pavani)" disabled autocomplete="off">
                    </div>
                  </div>
                  <input type="hidden" value="1" id="aID" name="aID">
                  <div class="col-md-4">
                    <div class="form-group">
                      <label class="control-label">Child ID</label><span class="error-star" style="color:red;">*</span>
                      <input class="form-control" type="text" id="child_id" name="child_id" autocomplete="off" value="CH/2023/070" readonly>
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group">
                      <label class="control-label">Child Name</label><span class="error-star" style="color:red;">*</span>
                      <input class="form-control" type="text" id="child_name" name="child_name" autocomplete="off" value="Pavani" readonly>
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group">
                      <label class="control-label">Category</label><span class="error-star" style="color:red;">*</span>
                      <input class="form-control" type="text" id="child_name" name="child_name" autocomplete="off" value="Parent" readonly>
                    </div>
                  </div>

                </div>

                <div class="col-md-12  text-center" style="padding-top: 1rem;">
                  <!-- <a type="button" onclick="activeStatus()" id="submitbutton" class="btn btn-labeled btn-succes" title="save" style="background: green !important; border-color:green !important; color:white !important">
                      <span class="btn-label" style="font-size:13px !important;"><i class="fa fa-check"></i></span>Submit</a> -->
                  <a type="button" class="btn btn-labeled back-btn" title="Back" href="{{ route('activity_allocation13.index') }}" style="color:white !important">
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
            <input type="hidden" name="session_key" id="session_key" value="57">
            <script type="text/javascript">
              $(document).ready(function() {
                document.getElementById('is_active_tab').value = document.getElementById('session_key').value;
              });
            </script>
            <button class="tabs__btn is-active" value="56" onclick="triggerTab(event)" data-tab-target="tab-1" type="button" role="tab" aria-selected="true">Activity Set-1[Both]<span id="badge1" class=""></span></button>
            <button class="tabs__btn" value="57" onclick="triggerTab(event)" data-tab-target="tab-2" type="button" role="tab" aria-selected="false">Activity Set-2[13+]<span id="badge1" class=""></span></button>
            <button class="tabs__btn " value="58" onclick="triggerTab(event)" data-tab-target="tab-3" type="button" role="tab" aria-selected="true">Activity Set-2[Both]<span id="badge1" class=""></span></button>
            <!-- <button class="tabs__btn" value="59" onclick="triggerTab(event)" data-tab-target="tab-4" type="button" role="tab" aria-selected="false">Activity Set-3[13+]<span id="badge1" class=""></span></button> -->

          </nav>
          @php $cuModaliteration = 0 @endphp
          @php $cuModaliteration1 = 0 @endphp
          <div class="tabs__content">


            <div class="tabs__pane is-visible" id="tab-1" role="tabpanel">

              <div class="card-body">
                <div class="table-wrapper">
                  <div class="table-responsive">
                    <!-- <a class="btn btn-success" style="float:right;margin-right:20px;" href="https://codepen.io/collection/XKgNLN/" target="_blank">Other examples on Codepen</a> -->
                    <!--  -->
                    <div class="col-2 form-group" style="float:right;">
                      <select class="form-control selectView" id="Tableview" /*onchange="view_change()" * />
                      <option value="1">Status</option>
                      <option value="2">Observation</option>
                      </select>
                    </div>
                    <div class="col-3 dropdown form-control bulkapproved" style="float:right; display:none" name="bulkapproved" id="bulkapproved1">
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
                    <table class="table table-bordered Tableview View1" id="activity1">
                      <thead>
                        <tr>
                          <th>Sl.No</th>
                          <th>Activity Description</th>
                          <th>Status</th>
                          <th>F2F Status</th>
                          <th>Action</th>
                        </tr>
                      </thead>
                      <tbody>
                        @php $iteration = 0; @endphp

                        @php $iteration = $iteration+1; @endphp
                        <tr>
                          <td>{{ $iteration }}</td>
                          <td>
                            <!--  -->
                            <label>
                              <span id="likeText">run, gallop, hop, leap, horizontal jump, slide.<i class="far fa-star"></i></span>
                            </label>
                            <!--  -->
                          </td>

                          <td>New</td>

                          <td>Enabled</td>
                          <td>
                            <div style="display: flex;">

                              <!-- <a href="#addModal" data-toggle="modal" data-target="#addModal2" class="btn btn-success" title="View" data-toggle="modal" data-target="#templates" style="margin-inline:5px"><i class="fa fa-pencil"></i></a> -->
                              <button class="btn btn-info" style="margin-inline:5px" disabled><i class="fa fa-pencil"></i></button>
                              @php $cuModaliteration = $cuModaliteration+1; @endphp
                              <!-- <a href="#cuModal{{$cuModaliteration}}" class="btn btn-success" data-toggle="modal" title="View" style="margin-inline:5px"><i class="fa fa-pencil"></i></a> -->
                              <label class='switch' data-bs-toggle='tooltip' data-bs-placement='top' title='Enable / Disable'><input type='checkbox' class='toggle_status' onclick="functiontoggle('1')" id="is_active1" name='is_active' checked><span class='slider round'></span></label>
                            </div>
                          </td>

                        </tr>
                        <tr>
                          <td>2</td>
                          <td>
                            <!--  -->
                            <label>
                              <span id="likeText">striking a stationary ball, stationary dribble, kick, catch, overhand throw,and underhand roll.<i class="far fa-star"></i></span>
                            </label>
                            <!--  -->
                          </td>

                          <td>Approved</td>

                          <td>-</td>

                          <td>
                            <div style="display: flex;">

                              <!-- <a href="#addModal" data-toggle="modal" data-target="#addModal2" class="btn btn-success" title="View" data-toggle="modal" data-target="#templates" style="margin-inline:5px"><i class="fa fa-pencil"></i></a> -->
                              <!-- <button class="btn btn-info" style="margin-inline:5px" disabled><i class="fa fa-pencil"></i></button> -->
                              @php $cuModaliteration = $cuModaliteration+1; @endphp
                              <a href="#cuModal{{$cuModaliteration}}" class="btn btn-success" data-toggle="modal" title="View" style="margin-inline:5px"><i class="fa fa-pencil"></i></a>
                              <label class='switch' data-bs-toggle='tooltip' data-bs-placement='top' title='Enable / Disable'><input type='checkbox' class='toggle_status' onclick="functiontoggle('1')" id="is_active1" name='is_active' checked><span class='slider round'></span></label>
                            </div>
                          </td>

                        </tr>

                      </tbody>
                    </table>
                    <!-- View - 1 End -->

                    <!-- View - 2 -->
                    <table class="table table-bordered Tableview View2" id="activity1" style="display:none">
                      <thead>
                        <tr>
                          <th>Sl.No</th>
                          <th>Activity Description</th>
                          <th>Status</th>
                          <th>F2F Status</th>
                          <th>Observation</th>
                          <th>Action</th>
                        </tr>
                      </thead>
                      <tbody>
                        @php $iteration = 0; @endphp

                        @php $iteration = $iteration+1; @endphp
                        <tr>
                          <td>{{ $iteration }}</td>
                          <td>run, gallop, hop, leap, horizontal jump, slide.</td>

                          <td>Approved</td>
                          <td>Enabled</td>
                          <td>dcscjnks</td>
                          <td>
                            <div style="display: flex;">
                              <!-- <a href="#addModal" data-toggle="modal" data-target="#addModal10" class="btn btn-success" title="View" data-toggle="modal" data-target="#templates" style="margin-inline:5px"><i class="fa fa-pencil"></i></a>
                              <button class="btn btn-info" style="margin-inline:5px" disabled><i class="fa fa-pencil"></i></button> -->

                              @php $cuModaliteration1 = $cuModaliteration1+1; @endphp
                              <a href="#cuModal2" class="btn btn-success" data-toggle="modal" title="View" style="margin-inline:5px"><i class="fa fa-pencil"></i></a>

                              <label class='switch' data-bs-toggle='tooltip' data-bs-placement='top' title='Enable / Disable'><input type='checkbox' class='toggle_status' onclick="functiontoggle('1')" id="is_active1" name='is_active' checked><span class='slider round'></span></label>
                            </div>
                          </td>

                        </tr>

                      </tbody>
                    </table>
                    <!-- View 2 End -->
                  </div>
                </div>
              </div>
            </div>
            <div class="tabs__pane" id="tab-2" role="tabpanel">

              <div class="card-body">
                <div class="table-wrapper">
                  <div class="table-responsive">
                    <!-- <a class="btn btn-success" style="float:right;margin-right:20px;" href="https://codepen.io/collection/XKgNLN/" target="_blank">Other examples on Codepen</a> -->
                    <!--  -->
                    <div class="col-2 form-group" style="float:right;">
                      <select class="form-control selectView" id="Tableview" /*onchange="view_change()" * />
                      <option value="1">Status</option>
                      <option value="2">Observation</option>
                      </select>
                    </div>
                    <div class="col-3 dropdown form-control bulkapproved" style="float:right; display:none" name="bulkapproved" id="bulkapproved1">
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
                    <table class="table table-bordered Tableview View1" id="activity2">
                      <thead>
                        <tr>
                          <th>Sl.No</th>
                          <th>Activity Description</th>
                          <th>Status</th>
                          <th>F2F Status</th>
                          <th>Action</th>
                        </tr>
                      </thead>
                      <tbody>
                        @php $iteration = 0; @endphp

                        @php $iteration = $iteration+1; @endphp
                        <tr>
                          <td>{{ $iteration }}</td>
                          <td>
                            <!--  -->
                            <label>
                              <span id="likeText">run, gallop, hop, leap, horizontal jump, slide.<i class="far fa-star"></i></span>
                            </label>
                            <!--  -->
                          </td>

                          <td>New</td>
                          <td>-</td>


                          <td>
                            <div style="display: flex;">

                              <!-- <a href="#addModal" data-toggle="modal" data-target="#addModal2" class="btn btn-success" title="View" data-toggle="modal" data-target="#templates" style="margin-inline:5px"><i class="fa fa-pencil"></i></a> -->
                              <button class="btn btn-info" style="margin-inline:5px" disabled><i class="fa fa-pencil"></i></button>
                              @php $cuModaliteration = $cuModaliteration+1; @endphp
                              <!-- <a href="#cuModal{{$cuModaliteration}}" class="btn btn-success" data-toggle="modal" title="View" style="margin-inline:5px"><i class="fa fa-pencil"></i></a> -->
                              <label class='switch' data-bs-toggle='tooltip' data-bs-placement='top' title='Enable / Disable'><input type='checkbox' class='toggle_status' onclick="functiontoggle('1')" id="is_active1" name='is_active' checked><span class='slider round'></span></label>
                            </div>
                          </td>

                        </tr>
                        <tr>
                          <td>2</td>
                          <td>
                            <!--  -->
                            <label>
                              <span id="likeText">striking a stationary ball, stationary dribble, kick, catch, overhand throw,and underhand roll.<i class="far fa-star"></i></span>
                            </label>
                            <!--  -->
                          </td>

                          <td>Approved</td>
                          <td>Enabled</td>

                          <td>
                            <div style="display: flex;">

                              <!-- <a href="#addModal" data-toggle="modal" data-target="#addModal2" class="btn btn-success" title="View" data-toggle="modal" data-target="#templates" style="margin-inline:5px"><i class="fa fa-pencil"></i></a> -->
                              <!-- <button class="btn btn-info" style="margin-inline:5px" disabled><i class="fa fa-pencil"></i></button> -->
                              @php $cuModaliteration = $cuModaliteration+1; @endphp
                              <a href="#cuModal{{$cuModaliteration}}" class="btn btn-success" data-toggle="modal" title="View" style="margin-inline:5px"><i class="fa fa-pencil"></i></a>
                              <label class='switch' data-bs-toggle='tooltip' data-bs-placement='top' title='Enable / Disable'><input type='checkbox' class='toggle_status' onclick="functiontoggle('1')" id="is_active1" name='is_active' checked><span class='slider round'></span></label>
                            </div>
                          </td>

                        </tr>

                      </tbody>
                    </table>
                    <!-- View - 1 End -->

                    <!-- View - 2 -->
                    <table class="table table-bordered Tableview View2" id="activity1" style="display:none">
                      <thead>
                        <tr>
                          <th>Sl.No</th>
                          <th>Activity Description</th>
                          <th>Status</th>
                          <th>F2F Status</th>
                          <th>Observation</th>
                          <th>Action</th>
                        </tr>
                      </thead>
                      <tbody>
                        @php $iteration = 0; @endphp

                        @php $iteration = $iteration+1; @endphp
                        <tr>
                          <td>{{ $iteration }}</td>
                          <td>striking a stationary ball, stationary dribble, kick, catch, overhand throw,and underhand roll.</td>

                          <td>Approved</td>
                          <td>Enabled</td>

                          <td>dcscjnks</td>
                          <td>
                            <div style="display: flex;">
                              <!-- <a href="#addModal" data-toggle="modal" data-target="#addModal10" class="btn btn-success" title="View" data-toggle="modal" data-target="#templates" style="margin-inline:5px"><i class="fa fa-pencil"></i></a>
                              <button class="btn btn-info" style="margin-inline:5px" disabled><i class="fa fa-pencil"></i></button> -->

                              @php $cuModaliteration1 = $cuModaliteration1+1; @endphp
                              <a href="#cuModal2" class="btn btn-success" data-toggle="modal" title="View" style="margin-inline:5px"><i class="fa fa-pencil"></i></a>

                              <label class='switch' data-bs-toggle='tooltip' data-bs-placement='top' title='Enable / Disable'><input type='checkbox' class='toggle_status' onclick="functiontoggle('1')" id="is_active1" name='is_active' checked><span class='slider round'></span></label>
                            </div>
                          </td>

                        </tr>

                      </tbody>
                    </table>
                    <!-- View 2 End -->
                  </div>
                </div>
              </div>
            </div>
            <div class="tabs__pane" id="tab-3" role="tabpanel">

              <div class="card-body">
                <div class="table-wrapper">
                  <div class="table-responsive">
                    <!-- <a class="btn btn-success" style="float:right;margin-right:20px;" href="https://codepen.io/collection/XKgNLN/" target="_blank">Other examples on Codepen</a> -->
                    <!--  -->
                    <div class="col-2 form-group" style="float:right;">
                      <select class="form-control selectView" id="Tableview" /*onchange="view_change()" * />
                      <option value="1">Status</option>
                      <option value="2">Observation</option>
                      </select>
                    </div>
                    <div class="col-3 dropdown form-control bulkapproved" style="float:right; display:none" name="bulkapproved" id="bulkapproved1">
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
                    <table class="table table-bordered Tableview View1" id="activity3">
                      <thead>
                        <tr>
                          <th>Sl.No</th>
                          <th>Activity Description</th>
                          <th>Status</th>
                          <th>F2F Status</th>
                          <th>Action</th>
                        </tr>
                      </thead>
                      <tbody>
                        @php $iteration = 0; @endphp

                        @php $iteration = $iteration+1; @endphp
                        <tr>
                          <td>{{ $iteration }}</td>
                          <td>
                            <!--  -->
                            <label>
                              <span id="likeText">run, gallop, hop, leap, horizontal jump, slide.<i class="far fa-star"></i></span>
                            </label>
                            <!--  -->
                          </td>

                          <td>New</td>
                          <td>Enabled</td>


                          <td>
                            <div style="display: flex;">

                              <!-- <a href="#addModal" data-toggle="modal" data-target="#addModal2" class="btn btn-success" title="View" data-toggle="modal" data-target="#templates" style="margin-inline:5px"><i class="fa fa-pencil"></i></a> -->
                              <button class="btn btn-info" style="margin-inline:5px" disabled><i class="fa fa-pencil"></i></button>
                              @php $cuModaliteration = $cuModaliteration+1; @endphp
                              <!-- <a href="#cuModal{{$cuModaliteration}}" class="btn btn-success" data-toggle="modal" title="View" style="margin-inline:5px"><i class="fa fa-pencil"></i></a> -->
                              <label class='switch' data-bs-toggle='tooltip' data-bs-placement='top' title='Enable / Disable'><input type='checkbox' class='toggle_status' onclick="functiontoggle('1')" id="is_active1" name='is_active' checked><span class='slider round'></span></label>
                            </div>
                          </td>

                        </tr>
                        <tr>
                          <td>2</td>
                          <td>
                            <!--  -->
                            <label>
                              <span id="likeText">striking a stationary ball, stationary dribble, kick, catch, overhand throw,and underhand roll.<i class="far fa-star"></i></span>
                            </label>
                            <!--  -->
                          </td>

                          <td>Approved</td>
                          <td>-</td>


                          <td>
                            <div style="display: flex;">

                              <!-- <a href="#addModal" data-toggle="modal" data-target="#addModal2" class="btn btn-success" title="View" data-toggle="modal" data-target="#templates" style="margin-inline:5px"><i class="fa fa-pencil"></i></a> -->
                              <!-- <button class="btn btn-info" style="margin-inline:5px" disabled><i class="fa fa-pencil"></i></button> -->
                              @php $cuModaliteration = $cuModaliteration+1; @endphp
                              <a href="#cuModal{{$cuModaliteration}}" class="btn btn-success" data-toggle="modal" title="View" style="margin-inline:5px"><i class="fa fa-pencil"></i></a>
                              <label class='switch' data-bs-toggle='tooltip' data-bs-placement='top' title='Enable / Disable'><input type='checkbox' class='toggle_status' onclick="functiontoggle('1')" id="is_active1" name='is_active' checked><span class='slider round'></span></label>
                            </div>
                          </td>

                        </tr>

                      </tbody>
                    </table>
                    <!-- View - 1 End -->

                    <!-- View - 2 -->
                    <table class="table table-bordered Tableview View2" id="activity1" style="display:none">
                      <thead>
                        <tr>
                          <th>Sl.No</th>
                          <th>Activity Description</th>
                          <th>Status</th>
                          <th>F2F Status</th>
                          <th>Observation</th>
                          <th>Action</th>
                        </tr>
                      </thead>
                      <tbody>
                        @php $iteration = 0; @endphp

                        @php $iteration = $iteration+1; @endphp
                        <tr>
                          <td>{{ $iteration }}</td>
                          <td>striking a stationary ball, stationary dribble, kick, catch, overhand throw,and underhand roll.</td>

                          <td>Approved</td>
                          <td>-</td>
                          <td>Approved By IS-C1</td>
                          <td>
                            <div style="display: flex;">
                              <!-- <a href="#addModal" data-toggle="modal" data-target="#addModal10" class="btn btn-success" title="View" data-toggle="modal" data-target="#templates" style="margin-inline:5px"><i class="fa fa-pencil"></i></a>
                              <button class="btn btn-info" style="margin-inline:5px" disabled><i class="fa fa-pencil"></i></button> -->

                              @php $cuModaliteration1 = $cuModaliteration1+1; @endphp
                              <a href="#cuModal2" class="btn btn-success" data-toggle="modal" title="View" style="margin-inline:5px"><i class="fa fa-pencil"></i></a>

                              <label class='switch' data-bs-toggle='tooltip' data-bs-placement='top' title='Enable / Disable'><input type='checkbox' class='toggle_status' onclick="functiontoggle('1')" id="is_active1" name='is_active' checked><span class='slider round'></span></label>
                            </div>
                          </td>

                        </tr>

                      </tbody>
                    </table>
                    <!-- View 2 End -->
                  </div>
                </div>
              </div>
            </div>

          </div>
        </div>
      </div>
    </div>

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
      selects.forEach(s => {
        if (selects.length > 1) {
          if (s !== select) {
            s.value = selectedValue;
            $('.Tableview').hide();
            $('.View' + selectedValue).show();
          }
        } else {
          $('.Tableview').hide();
          $('.View' + selectedValue).show();
        }
      });
    });
  });

  function selectall(sId) {
    var selectall = 10;
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

  // $(document).ready(function() {
  //   var actbadges = 10;
  //   for (actbadge of actbadges) {
  //     if (actbadge.status == 'Submitted' || actbadge.status == 'Re-Sent') {
  //       var actID = actbadge.activity_id;
  //       $("#badge" + actID).addClass("badgeact");
  //     }
  //   }
  // });

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
<form action="" id="video_update" method="POST">
  @csrf
  <input type="hidden" id="check_video" name="check_video">
  <input type="hidden" id="enrollment_id" name="enrollment_id" value="">
  <input type="hidden" id="is_active_tab" name="is_active_tab">

  <div class="modal fade cuModalPopup" id="cuModal2" role="dialog">
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
                      <input class="form-control" type="text" id="activity_id" name="activity_id1" value="Activity Set-1" autocomplete="off" readonly>
                    </div>
                  </div>

                  <div class="col-md-6">
                    <div class="form-group">
                      <label class="control-label">Activity Description</label><span class="error-star" style="color:red;">*</span>
                      <input class="form-control" type="text" id="description_id" name="description_id1" value="run, gallop, hop, leap, horizontal jump, slide." autocomplete="off" readonly>
                    </div>
                  </div>
                  <div class="w-100"></div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label class="control-label">Video Link</label><span class="error-star" style="color:red;">*</span>

                      <div style="display: flex;">
                        <input type="checkbox" value="1" name="video_check" id="video_check" checked>
                        <input class="form-control" type="text" id="video_link" name="video_link" autocomplete="off" value="https://www.videolinks.com/">
                        <a class="btn btn-link" title="show" target="_blank" href=""><i class="fas fa-eye" style="color:green"></i></a>
                        <!-- <div style="color: rgb(246, 15, 15); display: block;margin: 5px 0px 0px 0px;">Google Drive Link Only</div> -->
                      </div>

                    </div>

                    <div class="form-group">
                      <label class="control-label">Approval Status</label><span class="error-star" style="color:red;">*</span>
                      <select class="form-control cuModalSelect bsjcxsd" name="approval_status10" id="approval_status1" onchange="app_status('10')">
                        <option value="">Select Status</option>

                        <option value="Complete" selected>Approve</option>


                        <option value="Rejected">Reject</option>

                      </select>
                    </div>
                    <input type="checkbox" name="enablef2f1" id="enablef2f1}" onclick="openf2ftable('1')"><label for="enablef2f"> Face To Face</label>

                  </div>

                  <input type="hidden" id="activity_description_id" name="activity_description_id[]" value="1">
                  <input type="hidden" id="parent_video_upload_id" name="parent_video_upload_id[]" value="1">
                  <input type="hidden" id="activity_initiation_id" name="activity_initiation_id1" value="1">
                  <div class="col-md-6">
                    <label class="control-label comments_label">Previous Notes </label><br>
                    <div class="form-group scroll_flow_class">

                      <span></span> <br>

                      <span> - </span> <br><br>

                    </div>
                  </div>

                  <div class="col-md-6">
                    <div class="form-group" id="observationDiv1">

                      <label class="control-label">Observation</label>
                      <textarea class="form-control cuModaltextarea" name="observation1" id="observation1"></textarea>
                    </div>
                  </div>

                  <div class="col-md-6">
                    <div class="form-group">
                      <label class="control-label">Comments for Parent</label>
                      <textarea class="form-control cuModaltextarea" name="comments1" id="comments"></textarea>
                    </div>
                  </div>
                  <!-- F2F -->
                  <div class="col-md-12" style="padding: 0">
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
                              <td>


                                <!-- f2f_observation -->

                                <select data-placeholder="Select Materials" multiple class="chosen-select" name="material" style="width: 100% !important;">

                                  <option value="Bat" selected>Bat</option>
                                  <option value="Ball" selected>Ball</option>
                                  <option value="paper" selected>Paper</option>
                                  <option value="balloon" selected>Ballon</option>
                                  <option value="pen" selected>Pen</option>
                                  <option value="pencil" selected>Pencil</option>
                                </select>

                              </td>
                              <td><textarea class="form-control" name="to_observe1" id=""></textarea></td>
                              <td><textarea class="form-control" name="to_ask_parents1" id=""></textarea></td>
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

              <a type="button" class="btn btn-labeled btn-info" onclick="showModalPrev('1')" id="Previous" title="Previous" style="height: 35px;background: blue !important; border-color:blue !important; color:white !important">
                <span class="btn-label" style="font-size:13px !important;"><i class="fa fa-arrow-left"></i></span> Previous</a>

              <a type="button" onclick="tempSave('1')" id="submitbutton" class="btn btn-labeled btn-succes" title="Save" style="background: green !important; border-color:green !important; color:white !important">
                <span class="btn-label" style="font-size:13px !important;"><i id="checkIcon1" class="fa fa-check"></i></span>Save</a>
              <a type="button" onclick="saveall()" id="submitbutton" class="btn btn-labeled btn-succes" title="Submit" style="background: green !important; border-color:green !important; color:white !important">
                <span class="btn-label" style="font-size:13px !important;"><i class="fa fa-check"></i></span>Submit</a>
              <a type="button" class="btn btn-labeled back-btn" onclick="confirmclose('1')" data-dismiss="modal" aria-hidden="true" title="Close" style="color:white !important"><span class="btn-label" style="font-size:13px !important;"><i class="fa fa-times-circle-o"></i></span> Close</a>

              <a type="button" class="btn btn-labeled btn-info" onclick="showModalNext('1')" id="Next" title="Next" style="background: blue !important; border-color:#4d94ff !important; color:white !important;height: 35px;">
                <span class="btn-label" style="font-size:13px !important;">Next</span> <i class="fa fa-arrow-right"></i></a>
            </div>

          </div>
        </div>
      </div>
    </div>
  </div>
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



<div class="modal fade editModal1" id="addModal1">
  <form action="" id="userregistration1" method="POST">

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
                      <div class="card-body">
                        <div class="row">
                          <div class="col-md-6">
                            <div class="form-group">
                              <label class="control-label">Activity Name</label><span class="error-star" style="color:red;">*</span>
                              <input class="form-control" type="text" id="activity_id" name="activity_id" value="Activity Set-1" autocomplete="off" readonly>
                            </div>
                          </div>

                          <div class="col-md-6">
                            <div class="form-group">
                              <label class="control-label">Activity Description</label><span class="error-star" style="color:red;">*</span>
                              <input class="form-control" type="text" id="description_id" name="description_id" value="" autocomplete="off" readonly>
                            </div>
                          </div>
                          <div class="w-100"></div>
                          <input type="hidden" id="check_video1" name="check_video">
                          <div class="col-md-6">
                            <div class="form-group">
                              <label class="control-label">Video Link</label><span class="error-star" style="color:red;">*</span>

                              <div style="display: flex;">
                                <input class="form-control" type="text" id="video_link" name="video_link" autocomplete="off" value="">
                                <a class="btn btn-link" title="show" target="_blank" href=""><i class="fas fa-eye" style="color:green"></i></a>
                              </div>

                            </div>

                            <div class="form-group">
                              <label class="control-label">Approval Status</label><span class="error-star" style="color:red;">*</span>
                              <select class="form-control" name="approval_status" id="approval_status1" onchange="app_status('1')">
                                <!-- <option value="">Select Status</option> -->
                                <option value="Complete">Approved</option>
                                <!-- <option value="Close">Close</option> -->
                              </select>
                            </div>
                          </div>

                          <input type="hidden" id="activity_description_id" name="activity_description_id" value="1">
                          <input type="hidden" id="parent_video_upload_id" name="parent_video_upload_id" value="1">
                          <div class="col-md-6">
                            <label class="control-label comments_label">Previous Notes </label><br>
                            <div class="form-group scroll_flow_class">

                              <span> </span> <br>

                              <span> </span> <br><br>

                            </div>
                          </div>

                          <div class="col-md-6">
                            <div class="form-group" id="observationDiv1">
                              <label class="control-label">Observation</label>
                              <textarea class="form-control" name="observation" id="observation1"></textarea>
                            </div>
                          </div>

                          <div class="col-md-6">
                            <div class="form-group">
                              <label class="control-label">Comments for Parent</label>
                              <textarea class="form-control" name="comments" id="comments"></textarea>
                            </div>
                          </div>

                        </div>
                      </div>
                    </div>
                  </div>
                </div>

                <div class="col-md-12  text-center" style="padding-top: 1rem;">

                  <a type="button" class="btn btn-labeled btn-info Previoussubmission" onclick="showPrevModal('1')" id="Previoussubmission" title="Previous" style="height: 35px;background: blue !important; border-color:blue !important; color:white !important;">
                    <span class="btn-label" style="font-size:13px !important;"><i class="fa fa-arrow-left"></i></span> Previous</a>

                  <a type="button" onclick="save('1')" id="submitbutton" class="btn btn-labeled btn-succes" title="save" style="background: green !important; border-color:green !important; color:white !important">
                    <span class="btn-label" style="font-size:13px !important;"><i class="fa fa-check"></i></span>Submit</a>
                  <a type="button" class="btn btn-labeled btn-info Nextsubmission" onclick="showNextModal('1')" id="Nextsubmission" title="Next" style="background: blue !important; border-color:#4d94ff !important; color:white !important;height: 35px;">
                    <span class="btn-label" style="font-size:13px !important;">Next</span> <i class="fa fa-arrow-right"></i></a>

                </div>

              </div>
          </section>
        </div>
      </div>
    </div>
  </form>
</div>

@php $modalIndex++; @endphp


<script>
  var lastActivity = {

  };
  // JavaScript/jQuery code to control modal navigation
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
    console.log("Current modalIndex:", modalIndex);
    console.log("lastActivity length:", lastActivity.length);
    if (modalIndex == lastActivity.length - 1) {
      $('.Nextsubmission').hide();
      console.log("Hiding 'Next' button");
    } else {
      $('.Nextsubmission').show();
      console.log("Showing 'Next' button");
    }
  }
</script>

<form action="" id="userregistrationb1" method="">
  @csrf
  <div class="modal fade" id="viewModal1">
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
                      <div class="card-body">
                        <div class="row">
                          <div class="col-md-6">
                            <div class="form-group">
                              <label class="control-label">Activity Name</label><span class="error-star" style="color:red;">*</span>
                              <input class="form-control" type="text" id="activity_id" name="activity_id" value="" autocomplete="off" readonly>
                            </div>
                          </div>

                          <div class="col-md-6">
                            <div class="form-group">
                              <label class="control-label">Activity Description</label><span class="error-star" style="color:red;">*</span>
                              <input class="form-control" type="text" id="description_id" name="description_id" value="" autocomplete="off" readonly>
                            </div>
                          </div>
                          <div class="w-100"></div>
                          <div class="col-md-6">
                            <div class="form-group">

                              <label class="control-label">Video Link</label><span class="error-star" style="color:red;">*</span>

                              <div style="display: flex;">
                                <input class="form-control" type="text" id="video_link" name="video_link" autocomplete="off" value="">
                                <a class="btn btn-link" title="show" target="_blank" href=""><i class="fas fa-eye" style="color:green"></i></a>

                                <!-- <div style="color: rgb(246, 15, 15); display: block;margin: 5px 0px 0px 0px;">Google Drive Link Only</div> -->
                              </div>

                            </div>

                            <div class="form-group">
                              <label class="control-label">Observation</label>
                              <textarea class="form-control" name="observation" id="observation1" readonly></textarea>
                            </div>

                          </div>

                          <input type="hidden" id="activity_description_id" name="activity_description_id" value="1">
                          <input type="hidden" id="parent_video_upload_id" name="parent_video_upload_id" value="1">
                          <div class="col-md-6">
                            <label class="control-label">Previous Notes </label><br>
                            <div class="form-group scroll_flow_class">

                              <span></span> <br>

                              <span> - </span> <br><br>

                            </div>
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
</form>
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

    var lastactivity = 10;
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

    $(".loader").show();
    document.getElementById('userregistrationa' + id).submit('saved');


  }

  function saveall() {
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
    // $(".loader").show();
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
    var formData = form.serialize();
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
        console.log('Success');
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
  const tabPanes = document.querySelectorAll(".tabs__pane");

  function fadeOut(target) {
    target.style.opacity = 1;
    target.style.transition = `opacity 500ms`;
    target.style.opacity = 0;
    setTimeout(() => {
      target.style.display = "none";
    }, 500);
  }

  function fadeIn(target) {
    target.style.opacity = 0;
    target.style.transition = `opacity 500ms`;
    target.style.opacity = 1;
    setTimeout(() => {
      target.style.display = "block";
    }, 500);
  }

  function tabshow(tab_id) {

    tabPanes.forEach((pane) => {
      if (pane.classList.contains("is-visible")) {
        fadeOut(pane);
      }
      pane.classList.remove("is-visible");
    });

    const targetPane = document.getElementById(tab_id);
    if (targetPane) {
      fadeIn(targetPane);
      targetPane.classList.add("is-visible");
    }
  }



  function triggerTab(elt) {
    const tabTarget = elt.currentTarget.getAttribute("data-tab-target");
    tabshow(tabTarget);
  }

  tabBtns.forEach((tab) => {
    tab.addEventListener("click", triggerTab);
  });
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


    $("#requiredmodal").modal();
  }
</script>
@endsection