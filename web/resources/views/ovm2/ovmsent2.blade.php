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

  .centerid {
    width: 100%;
    text-align: center;
  }

  .readonly {
    background-color: #8080803d !important;
  }

  .select2-container {
    width: 100% !important;
  }

  .select2-container--default .select2-selection--multiple .select2-selection__choice {
    color: black !important;
  }

  /* Mobile Font Reduction Only */
  /* Mobile Optimized Layout */
  @media (max-width: 768px) {
    .main-content {
      padding: 10px !important;
      padding-top: 80px !important;
    }
    .breadcrumb, .breadcrumb-item {
      font-size: 9px !important;
    }
    h5.text-center {
      font-size: 15px !important;
    }
    .control-label, label {
      font-size: 10px !important;
    }
    .centerid {
      text-align: left !important;
      width: auto !important;
    }
    .form-control {
      font-size: 10px !important;
      height: 32px !important;
      box-shadow: none !important;
    }

    /* Requested UI Layout for Location & Date/Time */
    .datetime-row {
      display: grid !important;
      grid-template-columns: 58% 38% !important;
      gap: 4% !important;
      margin-bottom: 25px !important;
      width: 100% !important;
    }
    .datetime-row label {
      grid-column: 1 / span 2 !important;
      display: block !important;
      margin-bottom: 8px !important;
      font-weight: 700 !important;
      font-size: 16px !important;
      color: #34395e !important;
      text-align: left !important;
    }
    .datetime-row label.required::after {
      content: " *" !important;
      color: red !important;
    }
    .datetime-row .col-sm-4, 
    .datetime-row .col-sm-2 {
      width: 100% !important;
      max-width: 100% !important;
      padding: 0 !important;
      margin: 0 !important;
    }
    /* If it's a single input like Location, make it full width */
    .datetime-row:not(:has(.col-sm-2)) {
      grid-template-columns: 100% !important;
    }
    .datetime-row:not(:has(.col-sm-2)) .col-sm-4 {
      grid-column: 1 / span 2 !important;
    }

    .datetime-row .form-control {
      width: 100% !important;
      height: 44px !important;
      border-radius: 8px !important;
      border: 1px solid #ced4da !important;
      box-shadow: 0 2px 4px rgba(0,0,0,0.05) !important;
      background-color: #fff !important;
      padding: 10px 15px !important;
      font-size: 12px !important;
    }

    /* Yellow Button Centering */
    .col-md-1:has(.btn-primary[title="Attendee Status"]) {
      margin: 10px 0 !important;
      display: flex !important;
      justify-content: center !important;
      width: 100% !important;
      max-width: 100% !important;
      flex: 0 0 100% !important;
    }

    /* Action Buttons Uniform Sizing */
    .row.text-center .col-md-12 {
      display: flex !important;
      justify-content: center !important;
      gap: 5px !important;
      padding: 10px 5px !important;
    }
    .row.text-center .btn {
      flex: 1 1 auto !important;
      min-width: 80px !important;
      padding: 6px 2px !important;
      font-size: 10px !important;
      height: 34px !important;
      display: flex !important;
      align-items: center !important;
      justify-content: center !important;
      box-shadow: none !important;
      border-radius: 4px !important;
    }
    /* Respect inline display:none */
    .row.text-center .btn[style*="display:none"],
    .row.text-center .btn[style*="display: none"] {
      display: none !important;
    }
    .back-btn {
      background-color: #ff0000 !important;
    }
    .back-btn .btn-label {
      display: none !important;
    }
    
    table.table, .table th, .table td {
      font-size: 9px !important;
    }
    .card-body {
      padding: 12px !important;
    }
  }

  /* ==========================================
     TABLET-ONLY (769px - 1024px)
     ========================================== */
  @media (min-width: 769px) and (max-width: 1024px) {
    /* Top section – two columns */
    .is-coordinate .col-md-3 {
      flex: 0 0 50% !important;
      max-width: 50% !important;
      width: 50% !important;
    }
    .is-coordinate .col-md-4 {
      flex: 0 0 50% !important;
      max-width: 50% !important;
      width: 50% !important;
    }

    /* ====== Invite Details Form – clean alignment ====== */
    .card .form-group.row {
      display: flex !important;
      flex-wrap: wrap !important;
      align-items: center !important;
      margin-bottom: 12px !important;
    }

    /* Labels – fixed width, left-aligned text */
    .card .form-group.row label.col-sm-2,
    .card .form-group.row label.col-form-label,
    .card .form-group.row .col-form-label {
      flex: 0 0 25% !important;
      max-width: 25% !important;
      width: 25% !important;
      text-align: left !important;
      padding-right: 10px !important;
      white-space: nowrap !important;
      font-weight: 600 !important;
    }

    /* Input fields – take remaining width */
    .card .form-group.row .col-sm-4,
    .card .form-group.row .col-sm-8,
    .card .form-group.row .col-sm-2,
    .card .form-group.row .col-md-2 {
      flex: 1 1 auto !important;
      max-width: none !important;
      width: auto !important;
      padding-left: 5px !important;
      padding-right: 5px !important;
    }

    /* ====== TO + STATUS row – side by side ====== */
    .card .form-group.row:has(#meeting_to) {
      display: flex !important;
      flex-wrap: nowrap !important;
      align-items: center !important;
    }
    /* To input – 55% */
    .card .form-group.row:has(#meeting_to) > .col-sm-4 {
      flex: 0 0 55% !important;
      max-width: 55% !important;
      width: 55% !important;
    }
    /* Status label – 12% */
    .card .form-group.row:has(#meeting_to) > .col-md-2:has(label) {
      flex: 0 0 12% !important;
      max-width: 12% !important;
      width: 12% !important;
      text-align: left !important;
      padding-left: 10px !important;
    }
    /* Status input – 22% */
    .card .form-group.row:has(#meeting_to) > .col-md-2:has(select) {
      flex: 0 0 22% !important;
      max-width: 22% !important;
      width: 22% !important;
      flex-shrink: 1 !important;
      min-width: 0 !important;
      overflow: hidden !important;
    }
    .card .form-group.row:has(#meeting_to) > .col-md-2:has(select) select {
      width: 100% !important;
      min-width: 0 !important;
    }
    /* Notes column – adjust if shown */
    .card .form-group.row:has(#meeting_to) > .col-md-3:has(textarea) {
      flex: 0 0 30% !important;
      max-width: 30% !important;
      width: 30% !important;
    }
    /* Attendee Status button – inline */
    .card .form-group.row:has(#meeting_to) > .col-md-1 {
      flex: 0 0 8% !important;
      max-width: 8% !important;
      width: 8% !important;
      margin-left: 0 !important;
    }
    /* Remove the empty spacer column if present */
    .card .form-group.row:has(#meeting_to) > .col-md-2:empty {
      display: none !important;
    }
    /* Override centerid for status label to left-align */
    .card .form-group.row:has(#meeting_to) .centerid {
      text-align: left !important;
    }

    /* CC – select takes 65% */
    .card .form-group.row:has(#mail_cc) .col-sm-4 {
      flex: 0 0 65% !important;
      max-width: 65% !important;
      width: 65% !important;
    }

    /* Subject, Location – input 65% */
    .card .form-group.row:has(#meeting_subject) .col-sm-4,
    .card .form-group.row:has(#meeting_location) .col-sm-4 {
      flex: 0 0 65% !important;
      max-width: 65% !important;
      width: 65% !important;
    }

    /* Date + Time row: date 40%, time 35% */
    .card .form-group.row:has(.meeting_date) .col-sm-4 {
      flex: 0 0 40% !important;
      max-width: 40% !important;
      width: 40% !important;
    }
    .card .form-group.row:has(.meeting_date) .col-sm-2:has(input[type="time"]) {
      flex: 0 0 35% !important;
      max-width: 35% !important;
      width: 35% !important;
    }

    /* File attachment – if present */
    .card .form-group.row:has(#oldattachment) .col-sm-2 {
      flex: 0 0 20% !important;
      max-width: 20% !important;
      width: 20% !important;
    }
    .card .form-group.row:has(#oldattachment) .col-sm-8 {
      flex: 0 0 60% !important;
      max-width: 60% !important;
      width: 60% !important;
    }

    /* Ensure the "required" asterisk stays inline */
    .card .form-group.row label.required {
      white-space: nowrap !important;
    }
    .card .form-group.row label.required::after {
      content: " *";
      color: red;
    }

    /* Description textarea – full width */
    .card .col-lg-12 {
      padding-left: 15px !important;
      padding-right: 15px !important;
    }
  }
</style>

<div class="main-content">

  <!-- Main Content -->
  <section class="section">
    {{ Breadcrumbs::render('ovmsent2',$rows[0]['ovm_meeting_id']) }}


    <div class="section-body mt-1">
      <h5 class="text-center" style="color:darkblue">OVM-2 Meeting Invite Edit</h5>
      <div class="row">
        <div class="col-12">

          <div class="card">
            <div class="card-body">
              @foreach($rows as $key=>$row)
              @php $row['ovm_meeting_id'] = Crypt::Encrypt($row['ovm_meeting_id']) @endphp
              <form action="{{route('ovm2.update', $row['ovm_meeting_id'])}}" method="POST" id="ovm" enctype="multipart/form-data">
                {{ csrf_field() }}
                @method('PUT')


                <div class="row is-coordinate">
                  <div class="col-md-3">
                    <div class="form-group">
                      <label class="control-label">OVM Meeting ID</label>

                      <input class="form-control readonly" name="ovm_meeting_unique" value="{{ $row['ovm_meeting_unique']}}" readonly required>
                    </div>
                  </div>
                  <div class="col-md-3">
                    <div class="form-group">
                      <label class="control-label">Enrollment ID</label>
                      <input class="form-control readonly" name="enrollment_id" placeholder="Enrollment ID" readonly value="{{ $row['enrollment_id']}}" required>
                    </div>
                  </div>


                  <div class="col-md-3">
                    <div class="form-group">
                      <label class="control-label">Child ID</label>
                      <input class="form-control readonly" type="text" id="child_id" name="child_id" readonly value="{{ $row['child_id']}}" placeholder="OVM1 Meeting" required autocomplete="off">
                    </div>
                  </div>



                  <div class="col-md-3">
                    <div class="form-group">
                      <label class="control-label">Child Name</label>
                      <input class="form-control readonly" type="text" id="child_name" name="child_name" readonly value="{{ $row['child_name']}}" placeholder="Enter Name" required autocomplete="off">
                    </div>
                  </div>
                  <input type="hidden" value="{{$row['created_by']}}" id="created_by" name="created_by">


                  <div class="col-md-4">
                    <div class="form-group ">
                      <label class="control-label">IS Co-ordinator-1</label>
                      <select class="form-control readonly" id="Is Co-ordinator" name="is_coordinator1" required>
                        <option value="{{$row['is_coordinator1']['id']}}">{{$row['is_coordinator1']['name']}}</option>

                      </select>

                    </div>
                  </div>

                  <input class="form-control" type="hidden" id="attachment" name="attachment" value="{{ $row['attachment']}}" placeholder="Enter Location" required autocomplete="off">

                  @if($row['is_coordinator2'] != [])

                  <div class="col-md-4">
                    <div class="form-group">
                      <label class="control-label">IS Co-ordinator-2</label>
                      <select class="form-control readonly" id="Is Co-ordinator" name="is_coordinator2" required>
                        <option value="{{$row['is_coordinator2']['id']}}">{{$row['is_coordinator2']['name']}}</option>

                      </select>
                    </div>
                  </div>
                  @endif









                </div>
            </div>
          </div>
        </div>




        <div class="row">
          <div class="col-12">

            <div class="card">
              <div class="card-body">

                <div class="form-group row" style="margin-bottom: 5px;">
                  <label class="col-sm-2 col-form-label">To</label>
                  <div class="col-sm-4">
                    <input class="form-control readonly" type="text" id="meeting_to" name="meeting_to" readonly value="{{ $row['meeting_to']}}" placeholder="Email Id" required autocomplete="off">
                  </div>
                  <!-- <div class="col-md-2">
                  </div> -->
                  <div class="col-md-2">
                    <label class="control-label centerid">Status</label> <br>
                    <Select class="form-control" type="text" id="meeting_status" name="meeting_status" value="{{ $row['meeting_status']}}" required autocomplete="off" onchange="statusfn(event)">

                      @if($authID != $row['created_by'])

                      @if(in_array( $authID , $attendeeID))
                      @foreach($attendee as $aa)
                      @if($authID == $aa['attendee'])
                      <option id="meeting_status1" value="{{ $aa['overall_status']}}">{{ $aa['overall_status']}}</option>
                      @if($aa['overall_status']!="Accepted")
                      <option value="Accepted">Accepted</option>
                      @endif
                      @if($aa['overall_status']!="Declined")
                      <option value="Declined">Declined</option>
                      @endif
                      @if($aa['overall_status']!="Hold")
                      <option value="Hold">Hold</option>
                      @endif
                      @if($aa['overall_status']!="Rescheduled")
                      @if($authID == $row['created_by'])
                      <option value="Rescheduled">Rescheduled</option>
                      @else
                      <option value="Reschedule Request">Reschedule</option>
                      @endif
                      @endif
                      @endif
                      @endforeach
                      @else
                      <!-- <option value="">Need Action</option> -->
                      <option id="meeting_status1" value="{{ $row['meeting_status']}}">{{ $row['meeting_status']}}</option>
                      <!-- <option value="Accepted">Accepted</option> -->
                      <option value="Declined">Declined</option>
                      <option value="Hold">Hold</option>
                      <option value="Reschedule Request">Reschedule</option>
                      @endif

                      @else
                      <option id="meeting_status1" value="{{ $row['meeting_status']}}">{{ $row['meeting_status']}}</option>
                      @if($row['meeting_status']!="Accepted")
                      <option value="Accepted">Accepted</option>
                      @endif
                      @if($row['meeting_status']!="Declined")
                      <option value="Declined">Declined</option>
                      @endif
                      @if($row['meeting_status']!="Hold")
                      <option value="Hold">Hold</option>
                      @endif
                      @if($row['meeting_status']!="Rescheduled" && $row['meeting_status'] !="Reschedule Request")
                      <option value="Rescheduled">Rescheduled</option>
                      @endif
                      <!-- @if($row['meeting_status']!="Rescheduled")
                      @if($authID == $row['created_by'])
                      <option value="Rescheduled">Rescheduled</option>
                      @else
                      <option value="Reschedule Request">Reschedule</option>
                      @endif
                      @endif -->
                      @endif

                      <!-- @if($row['meeting_status']!="Completed")
                      <option value="Completed">Completed</option>
                      @endif -->
                    </Select>

                  </div>
                  <div class="col-md-3" id="notesdiv" style="display: none;">
                    <label class="control-label centerid">Note</label> <br>
                    <textarea class="form-control" name="notes" id=""></textarea>
                  </div>
                  <div class="col-md-1" style="margin: -8px 0px 0px -20px;">
                    <label class="control-label centerid"></label> <br><br>
                    <a href="#addModal" data-toggle="modal" data-target="#addModal" class="btn btn-primary" title="Attendee Status" data-toggle="modal" data-target="#templates" style="margin-inline:5px"><i class="fa fa-bars" style="color:white!important"></i></a>
                  </div>
                </div>

                <input type="hidden" value="{{$parentID}}" name="parentID">
                <div class="form-group row">
                  <label class="col-sm-2 col-form-label">CC</label>
                  <div class="col-sm-4">
                    <select class="form-control mail_cc js-select2" id="mail_cc" multiple="multiple" disabled>
                      <option></option>
                      @foreach($users as $user)
                      @if(in_array($user['email'],$cc))
                      <option value="{{$user['email']}}" selected>{{$user['name']}} : {{$user['email']}}</option>
                      @endif
                      @endforeach
                    </select>
                  </div>
                  <!--  -->
                  <div class="col-sm-4" style="display: none;">
                    <select class="form-control mail_cc js-select2" id="mail_cc" multiple="multiple" name="mail_cc[]">
                      <option></option>
                      @foreach($users as $user)
                      @if(in_array($user['email'],$cc))
                      <option value="{{$user['email']}}" selected>{{$user['name']}} : {{$user['email']}}</option>
                      @endif
                      @endforeach
                    </select>
                  </div>
                  <!--  -->
                </div>


                <div class="form-group row">
                  <label class="col-sm-2 col-form-label">Subject</label>
                  <div class="col-sm-4">
                    <input class="form-control" type="text" id="meeting_subject" name="meeting_subject" readonly value="{{ $row['meeting_subject']}}" placeholder="OVM1 Meeting" required autocomplete="off">
                  </div>

                </div>

                <input type="hidden" id="type" name="type">
                <div class="form-group row datetime-row">
                  <label class="col-sm-2 col-form-label">Location</label>
                  <div class="col-sm-4">
                    <input class="form-control" type="text" id="meeting_location" name="meeting_location" readonly value="{{ $row['meeting_location']}}" placeholder="Enter Location" required autocomplete="off">
                  </div>
                </div>

                <div class="form-group row datetime-row">
                  <label class="col-sm-2 col-form-label">Start Date and Time</label>
                  <div class="col-sm-4">
                    <div class="inner-addon right-addon">
                      <i class="glyphicon fas fa-calendar-alt"></i>
                      <input type='text' class="form-control meeting_date" id='meeting_startdate' onchange="autodateupdate(this)" readonly name="meeting_startdate" value="{{ $row['meeting_startdate']}}" required>
                    </div>
                  </div>
                  <div class="col-sm-2">
                    <div class="content">
                      <input class="form-control" type="time" id="meeting_starttime" name="meeting_starttime" readonly value="{{ $row['meeting_starttime']}}" required onchange="autoupdatedescription1()">
                    </div>
                  </div>

                </div>



                <div class="form-group row datetime-row">
                  <label class="col-sm-2 col-form-label">End Date and Time</label>
                  <div class="col-sm-4">
                    <div class="inner-addon right-addon">
                      <i class="glyphicon fas fa-calendar-alt"></i>
                      <input type='text' class="form-control meeting_date" id="meeting_enddate" onchange="autodateupdate(this)" readonly name="meeting_enddate" value="{{ $row['meeting_enddate']}}" required placeholder="MM/DD/YYYY">
                    </div>
                  </div>
                  <div class="col-sm-2">

                    <div class="content">
                      <input class="form-control" type="time" id="meeting_endtime" name="meeting_endtime" readonly value="{{ $row['meeting_endtime']}}" required onchange="autoupdatedescription1()">
                    </div>


                  </div>



                </div>
                <!-- <div class="row  form-group " id="ovmdat" style="display:none">
                            <label class="col-sm-2 ">Attachement</label>
                            <div class="col-lg-4 form-group">
                            <input class="form-control" type="file" id="ovmattach" name="ovmattach"  required  autocomplete="off">

                            </div>
                          
                          </div> -->
                @if(!is_null($row['attachment']))
                <div class="form-group row">
                  <label class="col-sm-2 col-form-label">File Attachment</label>
                  <!-- <div class="col-sm-8">
                    <a class="btn btn-info" title="view Document" data-toggle="modal" data-target="#templates" onclick="getproposaldocument('{{ $row['attachment']}}')" style="margin: 5px 0px 0px 3px;height: 35px;cursor:pointer">{{ __('View Document') }}<span></span></a>
                  </div> -->
                  <input class="form-control" type="hidden" id="oldattachment" name="oldattachment" value="{{ config('setting.base_url') }}{{ $row['attachment']}}" required autocomplete="off">
                  <div class="col-sm-2">
                    <a href="#" id="viewLink" class="btn btn-info" title="View Attachment" style="display:none;" target="_blank"><i class="fa fa-eye" style="color:white!important"></i> View</a>
                  </div>
                </div>
                @endif
                <div class=" form-group ">
                  <label class="form-label">Meeting Description</label>
                  <textarea class="form-control" id="description" name="meeting_description" value="{{ $row['meeting_description']}}">{{ $row['meeting_description']}}</textarea>

                </div>
                <div class="row text-center">
                  <div class="col-md-12">
                    <a type="button" class="btn btn-warning text-white"
                      id="savebutton"
                      onclick="validateForm1('Completed')">Close</a> @if($authID == $row['created_by'])
                    @if($row['meeting_status'] == 'Accepted')
                    <!-- <a type="button" class="btn btn-warning text-white" id="savebutton" onclick="validateForm1('Completed')" name="type" value="Saved">Close</a> -->
                    @elseif($row['meeting_status'] == 'Declined')
                    <button type="submit" id="savebutton" class="btn btn-warning" name="type" value="Saved"> Declined </button>
                    @elseif($row['meeting_status'] == 'Reschedule Request')
                    <a type="button" id="savebutton" class="btn btn-warning text-white" onclick="validateForm2('Reschedule')" name="type" value="Reschedule">Reschedule</a>
                    @elseif($row['meeting_status'] == 'Completed')
                    @else
                    <button type="submit" id="savebutton" class="btn btn-warning" name="type" value="Saved">Save</button>
                    @endif
                    @else
                    @if($row['meeting_status'] == 'Accepted')
                    <!-- <a type="button" class="btn btn-warning text-white" id="savebutton" onclick="validateForm1('Completed')" name="type" value="Saved">Close</a> -->
                    @endif
                    <button type="submit" id="savebutton" class="btn btn-warning" name="type" value="Saved">Save</button>
                    @endif

                    @if($authID == $row['created_by'])
                    <!-- <button type="submit" id="resch" class="btn btn-success" name="type" value="Sent" style="display:none">Send</button> -->
                    <a type="button" id="resch" class="btn btn-success text-white" onclick="validateForm('Sent')" style="display:none" name="type" value="Sent">Send</a>
                    @else
                    <!-- <button type="submit" id="resch" class="btn btn-success" name="type" value="Reschedule" style="display:none">Send</button> -->
                    <a type="button" id="resch" class="btn btn-success text-white" onclick="validateForm('Reschedule')" style="display:none" name="type" value="Reschedule">Reschedule</a>
                    @endif
                    <a type="button" href="{{route('ovm2.index')}}" class="btn btn-danger text-white">Cancel</a>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

        </form>
        @endforeach


      </div>
    </div>




    <br>

</div>
</section>
<div class="modal fade" id="addModal">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <div class="main-contents">
        <section class="section">
          <div class="modal-header bg-primary" style=" background-color: rgb(0 103 172) !important;">
            <h4 class="modal-title">Attendee Status</h4>
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          </div>
          <div class="modal-body" style="background-color: #edfcff !important;">
            <div class="section-body mt-2">
              <div class="row">
                <div class="col-12">
                  <div class="mt-0 ">
                    <div class="card-body" id="card_header">
                      <div class="row">
                      </div>
                      <div class="table-wrapper">
                        <div class="table-responsive  p-3">
                          <table class="table table-bordered">
                            <thead>
                              <tr>
                                <th>Sl. No.</th>
                                <th>Attendee</th>
                                <th>Status</th>
                                <th>Notes</th>
                              </tr>
                            </thead>
                            <tbody>
                              @foreach($attendee as $key => $data)
                              <tr>
                                <td>{{$loop->iteration}}</td>
                                <td>{{$data['name']}}</td>
                                <td>{{$data['status']}}</td>
                                <td>{{$data['notes']}}</td>
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
            </div>
        </section>
      </div>
    </div>
  </div>
</div>
</div>
<script>
  const viewLink = document.getElementById('viewLink');
  const defaultFileUrl = document.getElementById('oldattachment').value;

  viewLink.setAttribute('href', defaultFileUrl);
  viewLink.style.display = 'inline-block';


  const fileInput = document.getElementById('file');
  fileInput.addEventListener('change', () => {
    const file = fileInput.files[0];
    if (file) {
      viewLink.setAttribute('href', URL.createObjectURL(file));
      viewLink.style.display = 'inline-block';
    } else {
      viewLink.setAttribute('href', defaultFileUrl);
      viewLink.style.display = 'inline-block';
    }
  });
</script>
<script>
  $(".js-select2").select2({
    closeOnSelect: false,
    placeholder: "No Data Available",
    allowHtml: true,
    tags: true
  });

  $(function() {
    $('.meeting_date').datepicker({
      dateFormat: 'dd/mm/yy',
      changeMonth: true,
      changeYear: true,
      yearRange: '-100:+0',
      minDate: 0,
      beforeShow: function(input, inst) {
        if ($(input).is('[readonly]')) {
          return false;
        }
      }
    });
  });
</script>
<script>
  function autodateupdate(datev) {
    $('#meeting_startdate').val(datev.value);
    $('#meeting_enddate').val(datev.value);
    autoupdatedescription1();
  }
  meeting_startdate.min = new Date().toISOString().split("T")[0];
  meeting_enddate.min = new Date().toISOString().split("T")[0];
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
      content_style: 'body { font-family:Helvetica,Arial,sans-serif; font-size:14px }'
    });
  });
</script>
<script>
  function getproposaldocument(id) {
    var id = (id);
    var id1 = id.substring(id.indexOf("/") + 1);
    $('#modalviewdiv').html('');
    $("#loading_gif").show();
    // console.log(id1);
    $.ajax({
      url: "{{url('view_attachment_documents')}}",
      type: 'post',
      data: {
        id: id1,
        _token: '{{csrf_token()}}'
      },
      error: function() {
        alert('File Format not supports');
      },
      success: function(data) {
        // console.log(data.length);
        if (data.length > 0) {
          $("#loading_gif").hide();
          var proposaldocuments = "<div class='removeclass' id='modalviewdiv' style=' height:100%'><iframe src='" + data + "' class='document_ifarme_view' style='width:100%; height:100%'></iframe></div>";
          $('.removeclass').remove();
          var document = $('#template').append(proposaldocuments);
        }

      }
    });
  };

  function validateForm(a) {

    // alert(a);
    var co_one = $('#is_coordinator1').val();
    var co_two = $('#is_coordinator2').val();
    var startdate = $('#meeting_startdate').val();

    if (co_one == "Select-IS-Coordinator-1") {
      swal.fire("Please Select IS Coordinator1 ", "", "error");
      return false;
    }
    // if (co_two == "Select-IS-Coordinator-2") {
    //   swal.fire("Please Select IS Coordinator2 ", "", "error");
    //   return false;
    // }
    // if (data1.length > 5) {
    //   swal.fire("IS Co-ordinator-1 has Already Assigned with Five Child", "", "error");
    //   return false;
    // }
    // if (data2.length > 5) {
    //   swal.fire("IS Co-ordinator-2 has Already Assigned with Five Child", "", "error");
    //   return false;
    // }

    // data1 = data1.filter(i => startdate.includes(i.idate));
    // const data1Len = data1.length;
    // if (data1Len >= 2) {
    //   swal.fire("IS Co-ordinator-2 has Two Appointment", "", "error");
    //   return false;
    // }

    // data2 = data2.filter(j => startdate.includes(j.idate));
    // const data2Len = data2.length;
    // if (data2Len >= 2) {
    //   swal.fire("IS Co-ordinator-2 has Two Appointment", "", "error");
    //   return false;
    // }

    if (document.getElementById('meeting_subject').value == "") {
      swal.fire("Please Enter Meeting Subject ", "", "error");
      return false;
    }
    if (document.getElementById('meeting_location').value == "") {
      swal.fire("Please Enter Meeting Location", "", "error");
      return false;
    }

    var meeting_startdate = document.getElementById('meeting_startdate').value;
    if (meeting_startdate == "") {
      swal.fire("Please Select Meeting  Start Date ", "", "error");
      return false;
    }

    var meeting_starttime = document.getElementById('meeting_starttime').value;
    if (meeting_starttime == "") {
      swal.fire("Please Select Meeting Start Time", "", "error");
      return false;
    }

    var meeting_enddate = document.getElementById('meeting_enddate').value;
    if (meeting_enddate == "") {
      swal.fire("Please Select Meeting End Date", "", "error");
      return false;
    }

    var meeting_endtime = document.getElementById('meeting_endtime').value;
    if (meeting_endtime == "") {
      swal.fire("Please Select Meeting End Time", "", "error");
      return false;
    }

    const date = new Date();
    let day = date.getDate();
    let month = date.getMonth() + 1;
    let year = date.getFullYear();
    let currentDate = `${year}-${month}-${day}`;

    var twentyMinutesLater = new Date();
    twentyMinutesLater.setMinutes(twentyMinutesLater.getMinutes() + 2);
    var currentTime = new Date(twentyMinutesLater).toLocaleTimeString("en-GB");

    if (currentDate == meeting_startdate) {
      if (meeting_starttime < currentTime) {
        swal.fire("Please Select Valid Time", "", "error");
        return false;
      }
    }
    if (meeting_starttime == meeting_endtime) {
      swal.fire("Start Time and End Time should not be same", "", "error");
      return false;
    }
    if (meeting_starttime > meeting_endtime) {
      swal.fire("Please Select Valid Time", "", "error");
      return false;
    }

    var sTime = meeting_starttime.replace(/:/g, "");
    var eTime = meeting_endtime.replace(/:/g, "");
    var length = 4;
    var tsTime = sTime.substring(0, length);
    var teTime = eTime.substring(0, length);
    var diff = teTime - tsTime;
    if (diff > 200) {
      swal.fire("Maximum Time Duration is Two Hours", "", "error");
      return false;
    }
    if (diff < 30) {
      swal.fire("Minimum Time Duration is 30 Minutes", "", "error");
      return false;
    }
    // if (tsTime < 900) {
    //   swal.fire("Meeting Can be Scheduled from 9AM to 6PM only", "", "error");
    //   return false;
    // }
    // if (teTime > 1800) {
    //   swal.fire("Meeting Can be Scheduled from 9AM to 6PM only", "", "error");
    //   return false;
    // }

    var length = 5;
    var meeting_starttime_u = meeting_starttime.substring(0, length);
    var meeting_endtime_U = meeting_endtime.substring(0, length);
    document.getElementById('meeting_starttime').value = meeting_starttime_u;
    document.getElementById('meeting_endtime').value = meeting_endtime_U;

    document.getElementById('type').value = a;
    tinyMCE.triggerSave();
    // if ($("#description").val().trim().length < 1) {
    //   swal.fire("Please Enter Description", "", "error");
    //   return false;
    // }

    if (a == 'Saved') {
      var swalText = 'save';
    } else if (a == 'Sent') {
      var swalText = 'submit';
    } else if (a == 'Completed') {
      var swalText = 'save and close';
    } else {
      var swalText = a.toLowerCase();
    }

    Swal.fire({
      title: "Confirmation",
      text: "Are you sure you want to " + swalText + "?",
      icon: "warning",
      customClass: 'swalalerttext',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      confirmButtonText: "Yes",
      cancelButtonText: "No",
      closeOnConfirm: false,
      closeOnCancel: true,
      showLoaderOnConfirm: true,
      width: '550px',
    }).then((result) => {
      if (result.value) {
        $('.btn').addClass('disabled').css('pointer-events', 'none');
        $('.btn').prop('disabled', true);
        document.getElementById('ovm').submit();
      }
    })
  }

  function validateForm1(a) {
    const today = new Date().setHours(0, 0, 0, 0);
    const givenDateStr = document.getElementById('meeting_startdate').value;
    const day = givenDateStr.substring(0, 2);
    const month = givenDateStr.substring(2, 4) - 1;
    const year = givenDateStr.substring(4, 8);
    const givenDate = new Date(year, month, day);
    givenDate.setHours(0, 0, 0, 0);

    if (givenDate.getTime() < today) {
      confirmComplete(a);
    } else if (givenDate.getTime() === today) {
      confirmComplete(a);
    } else {
      confirmComplete(a);
      // swal.fire("This Meeting is currently in progress.This Meeting Can't be Closed", "", "error");
      // return false;
    }
  }

  function confirmComplete(a) {
    document.getElementById("meeting_status1").value = a;
    document.getElementById('type').value = a;
    // console.log(document.getElementById('meeting_status').value);
    if (a == 'Saved') {
      var swalText = 'save';
    } else if (a == 'Sent') {
      var swalText = 'submit';
    } else if (a == 'Completed') {
      var swalText = 'save and close';
    } else {
      var swalText = a.toLowerCase();
    }

    Swal.fire({
      title: "Confirmation",
      text: "Are you sure you want to " + swalText + "?",
      icon: "warning",
      customClass: 'swalalerttext',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      confirmButtonText: "Yes",
      cancelButtonText: "No",
      closeOnConfirm: false,
      closeOnCancel: true,
      showLoaderOnConfirm: true,
      width: '550px',
    }).then((result) => {
      if (result.value) {
        $('.btn').addClass('disabled').css('pointer-events', 'none');
        $('.btn').prop('disabled', true);
        document.getElementById('ovm').submit();
      }
    })
  }

  function validateForm2(a) {

    // alert(a);
    var co_one = $('#is_coordinator1').val();
    var co_two = $('#is_coordinator2').val();
    var startdate = $('#meeting_startdate').val();

    if (co_one == "Select-IS-Coordinator-1") {
      swal.fire("Please Select IS Coordinator1 ", "", "error");
      return false;
    }

    if (document.getElementById('meeting_subject').value == "") {
      swal.fire("Please Enter Meeting Subject ", "", "error");
      return false;
    }
    if (document.getElementById('meeting_location').value == "") {
      swal.fire("Please Enter Meeting Location", "", "error");
      return false;
    }

    var meeting_startdate = document.getElementById('meeting_startdate').value;
    if (meeting_startdate == "") {
      swal.fire("Please Select Meeting  Start Date ", "", "error");
      return false;
    }

    var meeting_starttime = document.getElementById('meeting_starttime').value;
    if (meeting_starttime == "") {
      swal.fire("Please Select Meeting Start Time", "", "error");
      return false;
    }

    var meeting_enddate = document.getElementById('meeting_enddate').value;
    if (meeting_enddate == "") {
      swal.fire("Please Select Meeting End Date", "", "error");
      return false;
    }

    var meeting_endtime = document.getElementById('meeting_endtime').value;
    if (meeting_endtime == "") {
      swal.fire("Please Select Meeting End Time", "", "error");
      return false;
    }

    const date = new Date();
    let day = date.getDate();
    let month = date.getMonth() + 1;
    let year = date.getFullYear();
    let currentDate = `${year}-${month}-${day}`;

    var twentyMinutesLater = new Date();
    twentyMinutesLater.setMinutes(twentyMinutesLater.getMinutes() + 2);
    var currentTime = new Date(twentyMinutesLater).toLocaleTimeString("en-GB");

    if (currentDate == meeting_startdate) {
      if (meeting_starttime < currentTime) {
        swal.fire("Please Select Valid Time", "", "error");
        return false;
      }
    }
    if (meeting_starttime == meeting_endtime) {
      swal.fire("Start Time and End Time should not be same", "", "error");
      return false;
    }
    if (meeting_starttime > meeting_endtime) {
      swal.fire("Please Select Valid Time", "", "error");
      return false;
    }

    var sTime = meeting_starttime.replace(/:/g, "");
    var eTime = meeting_endtime.replace(/:/g, "");
    var length = 4;
    var tsTime = sTime.substring(0, length);
    var teTime = eTime.substring(0, length);
    var diff = teTime - tsTime;
    if (diff > 200) {
      swal.fire("Maximum Time Duration is Two Hours", "", "error");
      return false;
    }
    if (diff < 30) {
      swal.fire("Minimum Time Duration is 30 Minutes", "", "error");
      return false;
    }
    // if (tsTime < 900) {
    //   swal.fire("Meeting Can be Scheduled from 9AM to 6PM only", "", "error");
    //   return false;
    // }
    // if (teTime > 1800) {
    //   swal.fire("Meeting Can be Scheduled from 9AM to 6PM only", "", "error");
    //   return false;
    // }

    var length = 5;
    var meeting_starttime_u = meeting_starttime.substring(0, length);
    var meeting_endtime_U = meeting_endtime.substring(0, length);
    document.getElementById('meeting_starttime').value = meeting_starttime_u;
    document.getElementById('meeting_endtime').value = meeting_endtime_U;

    document.getElementById("meeting_status1").value = a;
    document.getElementById('type').value = 'Sent';
    // console.log(document.getElementById('meeting_status').value);
    tinyMCE.triggerSave();
    // if ($("#description").val().trim().length < 1) {
    //   swal.fire("Please Enter Description", "", "error");
    //   return false;
    // }

    if (a == 'Saved') {
      var swalText = 'save';
    } else if (a == 'Sent') {
      var swalText = 'submit';
    } else if (a == 'Completed') {
      var swalText = 'save and close';
    } else {
      var swalText = a.toLowerCase();
    }

    Swal.fire({
      title: "Confirmation",
      text: "Are you sure you want to " + swalText + "?",
      icon: "warning",
      customClass: 'swalalerttext',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      confirmButtonText: "Yes",
      cancelButtonText: "No",
      closeOnConfirm: false,
      closeOnCancel: true,
      showLoaderOnConfirm: true,
      width: '550px',
    }).then((result) => {
      if (result.value) {
        $('.btn').addClass('disabled').css('pointer-events', 'none');
        $('.btn').prop('disabled', true);
        document.getElementById('ovm').submit();
      }
    })
  }
</script>


<script type="text/javascript">
  const statusfn = (event) => {
    let status = event.target.value;
    let currenetstatus = document.getElementById("resch");
    let savebutton = document.getElementById("savebutton");
    savebutton.value = status;
    currenetstatus.style.display = (status === "Rescheduled") ? "inline-block" : "none";
    // ovmdat.style.display = (status === "Completed") ? "inline-block" : "none";
    var authID = <?php echo json_decode($authID) ?>;
    // console.log(authID);
    // console.log(status);
    var createdby = document.getElementById('created_by').value;
    // console.log(createdby);
    if (authID == createdby) {
      if (status == "Rescheduled") {
        $('#meeting_startdate').prop('readonly', false);
        $('#meeting_starttime').prop('readonly', false);
        $('#meeting_enddate').prop('readonly', false);
        $('#meeting_endtime').prop('readonly', false);
        $('#meeting_subject').prop('readonly', false);
        $('#meeting_location').prop('readonly', false);
      } else {
        $('#meeting_startdate').prop('readonly', true);
        $('#meeting_starttime').prop('readonly', true);
        $('#meeting_enddate').prop('readonly', true);
        $('#meeting_endtime').prop('readonly', true);
        $('#meeting_subject').prop('readonly', true);
        $('#meeting_location').prop('readonly', true);
      }
    }
    if (status == "Hold" || status == "Declined" || status == "Reschedule Request" || status == "Rescheduled") {
      $('#notesdiv').show();
      $('#notes').prop('required', true);
    } else {
      $('#notesdiv').hide();
      $('#notes').prop('required', false);
    }

    //...
  }
  $(document).ready(function() {
    var authID = <?php echo json_decode($authID) ?>;
    // console.log(authID);
    // console.log(status);
    var createdby = document.getElementById('created_by').value;
    // console.log(createdby);
    if (authID == createdby) {
      var state = document.getElementById('meeting_status').value;
      if (state == 'Reschedule Request') {
        $('#meeting_startdate').prop('readonly', false);
        $('#meeting_starttime').prop('readonly', false);
        $('#meeting_enddate').prop('readonly', false);
        $('#meeting_endtime').prop('readonly', false);
        $('#meeting_subject').prop('readonly', false);
        $('#meeting_location').prop('readonly', false);
      }
    }

  });
</script>
<script>
  var m1 = document.getElementById('meeting_startdate').value;
  var m2 = document.getElementById('meeting_starttime').value;
  m2 = convertTimeFormat(m2);
  var m3 = document.getElementById('meeting_endtime').value;
  m3 = convertTimeFormat(m3);
  repeate1 = m1 + ' from ' + m2 + ' to ' + m3;
  // console.log(repeate1);

  function autoupdatedescription1() {
    var mDate1 = document.getElementById('meeting_startdate').value;
    var mTime1_s = document.getElementById('meeting_starttime').value;
    mTime1_s = convertTimeFormat(mTime1_s);
    var mTime1_e = document.getElementById('meeting_endtime').value;
    mTime1_e = convertTimeFormat(mTime1_e);

    if (mDate1 != '' && mTime1_s != '' && mTime1_e != '') {
      var text1 = mDate1 + ' from ' + mTime1_s + ' to ' + mTime1_e;
      var content = tinymce.get('description').getContent();
      content = content.replace(repeate1, text1);
      tinymce.get('description').setContent(content);
      repeate1 = text1;
    }
  }

  function convertTimeFormat(input) {
    var inputValue = input;
    var timeParts = inputValue.split(':');
    let hours = parseInt(timeParts[0]);
    var minutes = timeParts[1];
    let meridian = '';

    if (hours >= 12) {
      meridian = ' PM';
      if (hours > 12) {
        hours -= 12;
      }
    } else {
      meridian = ' AM';
      if (hours === 0) {
        hours = 12;
      }
    }

    var formattedTime = `${hours}:${minutes}${meridian}`;
    return formattedTime;
  }
</script>
@include('newenrollement.formmodal')
@endsection