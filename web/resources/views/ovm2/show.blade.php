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
  .select2-container{
    width: 100% !important;
  }
  .select2-container--default .select2-selection--multiple .select2-selection__choice{
    color: black !important;
  }
</style>

<div class="main-content">
@if($modules['user_role'] != 'Parent')
  {{ Breadcrumbs::render('ovm2.show',$rows[0]['ovm_meeting_id']) }}
@endif
  <div class="section-body mt-1">
    <h5 class="text-center" style="color:darkblue">OVM-2 Meeting Invite Details</h5>
    <div class="row">
      <div class="col-12">

        <div class="card">
          <div class="card-body">
            @foreach($rows as $key=>$row)
            <form method="POST" action="{{ route('ovm2.store') }}">
              @endforeach
              @csrf
              <div class="row is-coordinate">
                <div class="col-md-4">
                  <div class="form-group">
                    <label class="control-label required">Enrollment ID</label>
                    <input class="form-control" name="enrollment_id" placeholder="Enrollment ID" value="{{ $row['enrollment_id']}}" disabled="" required>
                  </div>
                </div>


                <div class="col-md-4">
                  <div class="form-group">
                    <label class="control-label required">Child ID</label>
                    <input class="form-control" type="text" id="child_id" name="child_id" value="{{ $row['child_id']}}" disabled="" placeholder="OVM1 Meeting" required autocomplete="off">
                  </div>
                </div>

                <div class="col-md-4">
                  <div class="form-group">
                    <label class="control-label required">Child Name</label>
                    <input class="form-control" type="text" id="child_name" name="child_name" value="{{ $row['child_name']}}" disabled="" placeholder="Enter Name" required autocomplete="off">
                  </div>
                </div>

                <div class="col-md-4">
                  <div class="form-group ">
                    <label class="control-label required">IS Co-ordinator-1</label>
                    <select class="form-control" id="Is Co-ordinator" disabled name="is_coordinator1" required>
                      <option value="{{$row['is_coordinator1']['id']}}">{{$row['is_coordinator1']['name']}}</option>

                    </select>

                  </div>
                </div>

                @if($row['is_coordinator2'] != [])
                <div class="col-md-4">
                  <div class="form-group">

                    <label class="control-label required">IS Co-ordinator-2</label>
                    <select class="form-control" id="Is Co-ordinator" disabled name="is_coordinator2" required>
                      <option value="{{$row['is_coordinator2']['id']}}">{{$row['is_coordinator2']['name']}}</option>
                    </select>
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
                  <input class="form-control" type="text" id="meeting_to" name="meeting_to" value="{{ $row['meeting_to']}}" placeholder="Email Id" required disabled="" autocomplete="off">
                </div>
                <div class="col-md-2">
                </div>
                <div class="col-md-2">
                  <label class="control-label centerid required">Status</label> <br>
                  <input class="form-control" type="text" id="meeting_status" name="meeting_status" value="{{ $row['meeting_status']}}" disabled="" placeholder="" required autocomplete="off">
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
                  <option value="{{$user['email']}}" >{{$user['name']}} : {{$user['email']}}</option>
                  @endif
                  @endforeach
                </select>
                </div>
              </div>
              @endif

              <div class="form-group row">
                <label class="col-sm-2 col-form-label required">Subject</label>
                <div class="col-sm-4">
                  <input class="form-control" type="text" id="meeting_subject" name="meeting_subject" value="{{ $row['meeting_subject']}}" disabled="" placeholder="OVM1 Meeting" required autocomplete="off">
                </div>
              </div>


              <div class="form-group row">
                <label class="col-sm-2 col-form-label required">Location</label>
                <div class="col-sm-4">
                  <input class="form-control" type="text" id="meeting_location" name="meeting_location" value="{{ $row['meeting_location']}}" disabled="" placeholder="Enter Location" required autocomplete="off">
                </div>
              </div>

              <div class="form-group row">
                <label class="col-sm-2 col-form-label required">Start Date and Time</label>
                <div class="col-sm-4">
                  <input type='text' class="form-control meeting_date" id='meeting_startdate' name="meeting_startdate" value="{{ $row['meeting_startdate']}}" disabled="" required>
                </div>
                <div class="col-sm-2">
                  <div class="content">
                    <input class="form-control" type="time" id="meeting_starttime" name="meeting_starttime" value="{{ $row['meeting_starttime']}}" disabled="" required>
                  </div>

                </div>

              </div>



              <div class="form-group row">
                <label class="col-sm-2 col-form-label required">End Date and Time</label>
                <div class="col-sm-4">
                  <input type='text' class="form-control meeting_date" id="meeting_enddate" name="meeting_enddate" value="{{ $row['meeting_enddate']}}" required disabled="" placeholder="MM/DD/YYYY">
                </div>
                <div class="col-sm-2">
                  <div class="content">
                    <input class="form-control" type="time" id="meeting_endtime" name="meeting_endtime" disabled="" value="{{ $row['meeting_endtime']}}" required>
                  </div>
                </div>
                @if(!is_null($row['attachment']))
                <div class="form-group row">
                  <label class="col-sm-2 col-form-label">File Attachment</label>
                  <div class="col-sm-8">
                  <input class="form-control" type="hidden" id="oldattachment" name="oldattachment" value="{{ config('setting.base_url') }}{{ $row['attachment']}}" required autocomplete="off">
                    <!-- <a class="btn btn-info" title="view Document" data-toggle="modal" data-target="#templates" onclick="getproposaldocument('{{ $row['attachment']}}')" style="margin: 5px 0px 0px 3px;height: 35px;cursor:pointer">{{ __('View Document') }}<span></span></a> -->
                    <a href="#" id="viewLink" class="btn btn-info" title="View Attachment" style="display:none;" target="_blank"><i class="fa fa-eye" style="color:white!important"></i> View</a>
                  </div>
                </div>
                @endif
                <div class="col-lg-12" style="margin: 20px 0px 0px 0px;">
                  <div class="form-group">
                    <label class="form-label">Meeting Description</label>
                    <textarea class="form-control" id="description" name="meeting_description" value="{{ $row['meeting_description']}}" disabled="">{{ $row['meeting_description']}}</textarea>
                  </div>
                </div>

              </div>
            </div>
          </div>
        </div>
      </div>


      </form>



    </div>
    @if($modules['user_role'] != 'Parent')
    <div class="row text-center" style="margin: 5px 0px 0px 0px;"> 
      <div class="col-md-12">
        <a type="button" class="btn btn-labeled back-btn" title="Back" href="{{route('ovm2.index')}}" style="color:white !important">
          <span class="btn-label" style="font-size:13px !important;"><i class="fa fa-arrow-left"></i></span> Back</a>
      </div>
    </div>
    @endif
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
    closeOnSelect : false,
    placeholder : "Please Select User",
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
  $(document).ready(function() {

    tinymce.init({
      selector: 'textarea#description',
      height: 280,
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



<script>
  function getproposaldocument(id) {
    var id = (id);
    var id1 = id.substring(id.indexOf("/") + 1);
    $('#modalviewdiv').html('');
    $("#loading_gif").show();
    console.log(id1);
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
        console.log(data.length);
        if (data.length > 0) {
          $("#loading_gif").hide();
          var proposaldocuments = "<div class='removeclass' id='modalviewdiv' style=' height:100%'><iframe src='" + data + "' class='document_ifarme_view' style='width:100%; height:100%'></iframe></div>";
          $('.removeclass').remove();
          var document = $('#template').append(proposaldocuments);
        }

      }
    });
  };
</script>
@include('newenrollement.formmodal')





















@endsection