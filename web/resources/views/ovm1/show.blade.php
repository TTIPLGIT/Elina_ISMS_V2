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

  .form-control:disabled,
  .form-control[readonly] {
    background-color: #e9ecef !important;
    opacity: 1;
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
    @if($modules['user_role'] != 'Parent')
    {{ Breadcrumbs::render('ovm1.show',$rows[0]['ovm_meeting_id']) }}
    @endif
    <div class="section-body mt-1">
      <h5 class="text-center" style="color:darkblue">OVM-1 Invite Details</h5>
      <div class="row">
        <div class="col-12">

          <div class="card">
            <div class="card-body">
              @foreach($rows as $key=>$row)
              <form method="POST" action="{{ route('ovm1.store') }}">
                @endforeach
                @csrf
                <div class="row is-coordinate">
                  <div class="col-md-4">
                    <div class="form-group">
                      <label class="control-label required">Enrollment ID</label>
                      <input class="form-control" name="enrollment_id" readonly value="{{ $row['enrollment_id']}}" placeholder="Enrollment ID" required>
                    </div>
                  </div>

                  <div class="col-md-4">
                    <div class="form-group">
                      <label class="control-label required">Child ID</label>
                      <input class="form-control" type="text" id="child_id" readonly name="child_id" value="{{ $row['child_id']}}" disabled="" placeholder="OVM1 Meeting" required autocomplete="off">
                    </div>
                  </div>

                  <div class="col-md-4">
                    <div class="form-group">
                      <label class="control-label required">Child Name</label>
                      <input class="form-control" type="text" id="child_name" readonly name="child_name" value="{{ $row['child_name']}}" disabled="" placeholder="Enter Name" required autocomplete="off">
                    </div>
                  </div>

                  <div class="col-md-4">
                    <div class="form-group ">
                      <label class="control-label required">IS Co-ordinator-1</label>
                      <input class="form-control" type="text" value="{{$row['is_coordinator1']['name']}}" readonly required>
                      <input class="form-control" type="hidden" id="Is Co-ordinator" name="is_coordinator1" value="{{$row['is_coordinator1']['id']}}" readonly required>
                    </div>
                  </div>

                  @if($row['is_coordinator2'] != [])
                  <div class="col-md-4">
                    <div class="form-group ">
                      <label class="control-label required">IS Co-ordinator-2</label>
                      <input class="form-control" type="text" value="{{$row['is_coordinator2']['name']}}" readonly required>
                      <input class="form-control" type="hidden" id="Is Co-ordinator" name="is_coordinator2" value="{{$row['is_coordinator2']['id']}}" readonly required>
                    </div>
                  </div>
                  @endif
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
                  <label class="col-sm-2 col-form-label required">To</label>
                  <div class="col-sm-4">
                    <input class="form-control" type="text" id="meeting_to" readonly name="meeting_to" value="{{ $row['meeting_to']}}" disabled="" placeholder="" required autocomplete="off">
                  </div>
                  <div class="col-md-2">
                  </div>
                  <div class="col-md-2">
                    <label class="control-label centerid required">Status</label> <br>
                    <input class="form-control" type="text" id="meeting_status" readonly name="meeting_status" value="{{ $row['meeting_status']}}" disabled="" placeholder="" required autocomplete="off">
                  </div>
                </div>
                @if($modules['user_role'] != 'Parent')
                <div class="form-group row">
                  <label class="col-sm-2 col-form-label">CC</label>
                  <div class="col-sm-4">
                    <select class="form-control mail_cc js-select2" id="mail_cc" disabled multiple="multiple" name="mail_cc[]">
                      <option></option>
                      @foreach($users as $user)
                      @if(in_array($user['email'],$cc))
                      <option value="{{$user['email']}}" selected>{{$user['name']}} : {{$user['email']}}</option>
                      @else
                      <option value="{{$user['email']}}">{{$user['name']}} : {{$user['email']}}</option>
                      @endif
                      @endforeach
                    </select>
                  </div>
                </div>
                @endif
                <div class="form-group row">
                  <label class="col-sm-2 col-form-label required">Subject</label>
                  <div class="col-sm-4">
                    <input class="form-control" type="text" id="meeting_subject" readonly name="meeting_subject" value="{{ $row['meeting_subject']}}" disabled="" placeholder="OVM1 Meeting" required autocomplete="off">
                  </div>
                </div>

                <div class="form-group row">
                  <label class="col-sm-2 col-form-label required">Location</label>
                  <div class="col-sm-4">
                    <input class="form-control" type="text" id="meeting_location" readonly name="meeting_location" value="{{ $row['meeting_location']}}" disabled="" placeholder="Enter Location" required autocomplete="off">
                  </div>
                </div>

                <div class="form-group row">
                  <label class="col-sm-2 col-form-label required">Start Date and Time</label>
                  <div class="col-sm-4">
                    <input type='text' class="form-control" id='meeting_startdate' readonly name="meeting_startdate" value="{{ $row['meeting_startdate']}}" disabled="" required>
                  </div>
                  <div class="col-sm-2">
                    <div class="content">
                      <input class="form-control" type="time" id="meeting_starttime" readonly name="meeting_starttime" value="{{ $row['meeting_starttime']}}" disabled="" required>
                    </div>
                  </div>
                </div>

                <div class="form-group row">
                  <label class="col-sm-2 col-form-label required">End Date and Time</label>
                  <div class="col-sm-4">
                    <input type='text' class="form-control" id="meeting_enddate" readonly name="meeting_enddate" value="{{ $row['meeting_enddate']}}" required disabled="" placeholder="MM/DD/YYYY">
                  </div>
                  <div class="col-sm-2">
                    <div class="content">
                      <input class="form-control" type="time" id="meeting_endtime" readonly name="meeting_endtime" value="{{ $row['meeting_endtime']}}" disabled="" required>
                    </div>
                    <br>
                  </div>
                  <div class="col-lg-12" style="margin: 20px 0px 0px 0px;">
                    <div class="form-group">
                      <label class="form-label">Meeting Description</label>
                      <textarea class="form-control" id="description" name="meeting_description" readonly>{{ $row['meeting_description']}}</textarea>
                    </div>
                  </div>

                </div>

              </div>
            </div>
          </div>
        </div>

        </form>



      </div>
    </div>

    @if($modules['user_role'] != 'Parent')
    <div class="row text-center" style="margin: 10px">
      <div class="col-md-12">
        <a type="button" class="btn btn-labeled back-btn" title="Cancel" href="{{route('ovm1.index')}}" style="color:white !important">
          <span class="btn-label" style="font-size:13px !important;"><i class="fa fa-times"></i></span> Cancel</a>
      </div>
    </div>
    @endif

  </section>
</div>
<script>
  $(".js-select2").select2({
    closeOnSelect: false,
    placeholder: "Please Select User",
    allowHtml: true,
    tags: true
  });
</script>
<script>
  $(document).ready(function() {

    tinymce.init({
      selector: 'textarea#description',
      height: 180,
      menubar: false,
      branding: false,
      toolbar: 'undo redo | formatselect | ' +
        'bold italic backcolor | alignleft aligncenter ' +
        'alignright alignjustify | bullist numlist outdent indent | ' +
        'removeformat | help',
      content_style: 'body { font-family:Helvetica,Arial,sans-serif; font-size:14px;background-color: #e9ecef; }'
    });

    tinymce.activeEditor.mode.set("readonly");
  });
</script>
@endsection