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

  #invite {
    /* display: none; */
  }
</style>

<div class="main-content">
{{ Breadcrumbs::render('ovm.questionnaire.initiate') }}
  <!-- Main Content -->
  <section class="section">

 
    <div class="section-body mt-1">
      <h5 class="text-center" style="color:darkblue">Parent Feedback Form Initiate</h5>
      <div class="row">
        <div class="col-12">

          <div class="card">
            <div class="card-body">

              <!-- <form method="POST" action="{{ route('ovm1.store') }}"> -->
              <form action="{{ route('sail.store') }}" method="POST" id="enrollement" enctype="multipart/form-data">

                @csrf
                <input type="hidden" name="stage" value="ovm">
                <div class="row is-coordinate">
                  <div class="col-md-4">
                    <div class="form-group">
                      <label class="control-label required">Enrollment Number</label>

                      <select class="form-control" id="enrollment_id" name="enrollment_id" onchange="GetChilddetails()">
                        <option value="">Select-Enrollment</option>

                        @foreach($rows['questionnaire_initiation'] as $key=>$row)
                        <option value="{{$row['enrollment_id']}}">{{ $row['enrollment_child_num']}} ( {{$row['child_name']}} )</option>
                        @endforeach


                      </select>



                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group">
                      <label class="control-label required">Child ID</label>
                      <input class="form-control" type="text" id="child_id" name="child_id" placeholder="Child ID" autocomplete="off">
                    </div>
                  </div>



                  <div class="col-md-4">
                    <div class="form-group">
                      <label class="control-label required">Child Name</label>
                      <input class="form-control" type="text" id="child_name" name="child_name" oninput="Childname(event)" maxlength="20" value="" placeholder="Enter Name" autocomplete="off">
                    </div>
                  </div>




                </div>
            </div>
          </div>
        </div>
      </div>
      <br>
      <!-- <div class="row text-center">
        <div class="col-md-12">
          <button type="button" onclick="save()" class="btn btn-success">Initiate</button>
        </div>
      </div> -->

      <div class="row" id="invite">
        <div class="col-12">

          <div class="card">
            <div class="card-body">

              <div class="form-group row" style="margin-bottom: 5px;">
                <div class="col-md-6">
                  <label class="col-sm-6 control-label col-form-label">Questionnaire Name<span class="error-star" style="color:red;">*</span></label>
                  <select class="form-control" id="questionnaire_id" name="questionnaire_id">
                    <option value="">Questionnaire Name</option>

                  </select>
                </div>
                <input type="hidden" id="paymenttokentime" name="paymenttokentime" value="{{$paymenttokentime[0]['token_expire_time']}}">
                <div class="col-md-6">
                  <label class="col-sm-3 control-label col-form-label">Status</label> <br>
                  <input class="form-control" type="text" id="payment_status" name="status" value="New" placeholder="New" autocomplete="off" readonly>
                </div>
                <input type="hidden" id="btn_status" name="btn_status" value="">
                <input type="hidden" id="userID" name="userID" value="">
              </div>
            </div>
          </div>
          <div class="col-md-12  text-center" style="padding-top: 1rem;">
            <!-- <a type="button" onclick="buttonAction('Saved')" class="btn btn-warning" name="type" value="save">Save</a>
                    <a type="button" onclick="buttonAction('Sent')" class="btn btn-success" name="type" value="sent">Submit</a>
                    <button type="" class="btn btn-danger">Cancel</button> -->

            <a type="button" onclick="buttonAction('Sent')" id="submitbutton" class="btn btn-labeled btn-succes" title="Initiate Questionnaire" style="background: green !important; border-color:green !important; color:white !important">
              <span class="btn-label" style="font-size:13px !important;"><i class="fa fa-check"></i></span>Initiate</a>

            <a type="button" class="btn btn-labeled back-btn" title="Back" href="{{ route('ovm.questionnaire') }}" style="color:white !important">
              <span class="btn-label" style="font-size:13px !important;"><i class="fa fa-arrow-left"></i></span> Back</a>

          </div>
        </div>
      </div>

      </form>

    </div>


</div>
</div>



<br>

</div>
</section>
</div>

<script>
  function newmeeting()

  {
    document.getElementById('invite').style.display = "block";

  }
</script>




<script>
  function Childname(event) {
    let value = event.target.value || '';
    value = value.replace(/[^a-z A-Z ]/, '', );
    event.target.value = value;

  }
</script>

<script type="text/javascript">
  $.ajaxSetup({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  });

  function GetChilddetails() {
    var enrollment_id = $("select[name='enrollment_id']").val();
    // alert(enrollment_id);
    if (enrollment_id != "") {
      $.ajax({
        url: '{{ url('/sail/getchild/enrollment') }}',
        type: 'POST',
        data: {
          'enrollment_id': enrollment_id,
          _token: '{{csrf_token()}}'
        }
      }).done(function(data) {
        console.log(data);
        if (data != '[]') {
          var optionsdata = "";
          document.getElementById('child_id').value = data[0].child_id;
          document.getElementById('child_name').value = data[0].child_name;
          document.getElementById('userID').value = data[0].user_id;
          // document.getElementById('meeting_to').value = data[0].child_contact_email;
          // document.getElementById('enrollment_id').value = data[0].enrollment_id;

          // if (enrollment_id != "") {
          // alert('asd');
          $.ajax({
            url: '{{ url('/sail/GetQuestionnaire') }}',
            type: "POST",
            dataType: "json",
            data: {
              enrollment_id: enrollment_id,
              type : '1',
              stage : 'OVM',
              _token: '{{csrf_token()}}'
            },
            success: function(data) {
              // alert(data);
              console.log(data);
              if (data != '[]') {
                var user_select = data.rows;
                var optionsdata = "";
                for (var i = 0; i < user_select.length; i++) {
                  var questionnaire_name = user_select[i]['questionnaire_name'];
                  var questionnaire_id = user_select[i]['questionnaire_id'];
                  var ddd = "<option value=" + questionnaire_id + ">" + questionnaire_name + "</option>";
                }
                var stageoption = ddd.concat(optionsdata);
                var demonew = $('#questionnaire_id').html(stageoption);
              } else {
                var stageoption = ddd.concat(optionsdata);
                var demonew = $('#questionnaire_id').html(stageoption);
              }
            }
          });
          // } else {
          //   var stageoption = ddd.concat(optionsdata);
          //   var demonew = $('#questionnaire_id').html(stageoption);
          // }

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
</script>
<script>
  function buttonAction(status) {
    var enrollment_id = $('#enrollment_id').val();
    if (enrollment_id == '') {
      swal.fire("Please Select Enrollment Number", "", "error");
      return false;
    }

    var questionnaire_id = $('#questionnaire_id').val();
    if (questionnaire_id == '') {
      swal.fire("Please Enter Questionnaire Name", "", "error");
      return false;
    }

    document.getElementById('btn_status').value = status;
    document.getElementById('enrollement').submit();
  }
</script>








@endsection