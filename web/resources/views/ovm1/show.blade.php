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
    /* Mobile Responsive Overrides */
    @media (max-width: 768px) {
        .main-content {
            padding: 5px !important;
            margin-top: 60px !important;
            position: relative !important;
            z-index: 1 !important;
        }

        /* Breadcrumbs - Single Line */
        .breadcrumb {
            padding: 2px 5px !important;
            margin: 10px 0 10px 15px !important;
            width: 90% !important;
            height: auto !important;
            font-size: 9px !important;
            background-color: transparent !important;
            display: flex !important;
            flex-wrap: nowrap !important;
            overflow: hidden !important;
            border: none !important;
            box-shadow: none !important;
            justify-content: flex-start !important;
            align-items: center !important;
            white-space: nowrap !important;
        }
        
        .breadcrumb li span, 
        .breadcrumb .number,
        .breadcrumb-item::before {
            width: 14px !important;
            height: 14px !important;
            line-height: 14px !important;
            font-size: 8px !important;
            margin-right: 3px !important;
        }

        .breadcrumb-item, .breadcrumb-item a {
            font-size: 9px !important;
            display: flex !important;
            align-items: center !important;
        }

        /* Titles */
        h5.text-center {
            font-size: 14px !important;
            margin-top: 10px !important;
            font-weight: bold !important;
            color: darkblue !important;
        }

        /* Form Controls */
        .card {
            margin: 5px 0 !important;
        }
        .card-body {
            padding: 10px !important;
        }
        
        .form-group {
            margin-bottom: 8px !important;
        }
        
        .control-label, .col-form-label, label {
            font-size: 10px !important;
            font-weight: bold !important;
            margin-bottom: 2px !important;
            color: #333 !important;
        }
        
        .form-control {
            height: 30px !important;
            font-size: 10px !important;
            padding: 5px !important;
        }

        /* Grid Adjustments */
        .col-md-4, .col-sm-2, .col-sm-4, .col-md-2, .col-md-3 {
            width: 100% !important;
            max-width: 100% !important;
            flex: 0 0 100% !important;
        }

        .centerid {
            text-align: left !important;
        }

        /* Date/Time Pickers side-by-side */
        .form-group.row {
            margin-bottom: 5px !important;
            display: flex !important;
            flex-wrap: wrap !important;
        }
        
        .form-group.row .col-sm-4 {
            width: 100% !important; 
            max-width: 100% !important;
            flex: 0 0 100% !important;
            padding-right: 15px !important;
        }

        .form-group.row:has(.meeting_date) .col-sm-4,
        .form-group.row:has(#meeting_startdate) .col-sm-4,
        .form-group.row:has(#meeting_enddate) .col-sm-4 {
            width: 55% !important;
            max-width: 55% !important;
            flex: 0 0 55% !important;
            padding-right: 2px !important;
        }
        
        .form-group.row:has(.meeting_date) div.col-sm-2,
        .form-group.row:has(#meeting_starttime) div.col-sm-2,
        .form-group.row:has(#meeting_endtime) div.col-sm-2 {
            width: 45% !important;
            max-width: 45% !important;
            flex: 0 0 45% !important;
        }

        .form-group.row label.col-sm-2 {
            width: 100% !important;
            max-width: 100% !important;
            flex: 0 0 100% !important;
            display: block !important;
        }

        /* Status and Yellow Button Alignment */
        .form-group.row:has(#meeting_status) > .col-md-2 {
            width: 80% !important;
            max-width: 80% !important;
            flex: 0 0 80% !important;
            padding-right: 5px !important;
        }
        .form-group.row:has(#meeting_status) > .col-md-1 {
            width: 20% !important;
            max-width: 20% !important;
            flex: 0 0 20% !important;
            display: flex !important;
            align-items: flex-end !important;
            justify-content: center !important;
            margin: 0 !important;
        }

        .btn i {
            margin-right: 6px !important;
        }
        .back-btn .btn-label {
            margin-right: 5px !important;
            padding: 0 !important;
            background: transparent !important;
        }

        /* Calendar Icon - Centered like Timer Icon */
        .inner-addon i {
            top: 50% !important;
            right: 10px !important;
            transform: translateY(-50%) !important;
            font-size: 14px !important;
            margin-top: 0 !important;
        }
        
        /* Note at bottom */
        .card-body p {
            font-size: 9px !important;
            line-height: 1.2 !important;
        }
        .is-coordinate .col-md-4, .is-coordinate .col-md-3 {
             padding-bottom: 10px;
        }
    }
</style>

<div class="main-content" style="position:absolute !important; z-index: -2!important; ">

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
                  @if($row['video_link'])
                  <div class="col-lg-6" style="margin: 20px 0px 0px 0px;">
                    <div class="form-group">
                      <label class="form-label">Video Link</label>
                      <textarea class="form-control" id="video_link" name="video_link" readonly>{{ $row['video_link']}}</textarea>
                    </div>
                  </div>
                  @endif
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
        <a type="button" class="btn btn-labeled btn-danger" title="Cancel" href="{{route('ovm1.index')}}" style="color:white !important">
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