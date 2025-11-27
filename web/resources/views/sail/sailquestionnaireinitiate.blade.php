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
    display: none;
  }
  .select2-container{
    width: 100% !important;
  }
  .select2-container--default .select2-selection--multiple .select2-selection__choice{
    color: black !important;
  }
  .select2-container--default .select2-results__option--highlighted[aria-selected=true] {
    background-color: gray;
}
</style>

<div class="main-content">
  <!-- Main Content -->
  <section class="section">
  {{ Breadcrumbs::render('sailquestionnaireinitiate') }}
    <div class="section-body mt-1">
      <h5 class="text-center" style="color:darkblue">SAIL Questionnaire Initiation</h5>
      <div class="row">
        <div class="col-12">

          <div class="card">
            <div class="card-body">

              <!-- <form method="POST" action="{{ route('ovm1.store') }}"> -->
              <form action="{{ route('sailstore') }}" method="POST" id="enrollement" enctype="multipart/form-data">

                @csrf

                <input type="hidden" name="stage" value="sail">

                <div class="row is-coordinate">
                  <div class="col-md-4">
                    <div class="form-group">
                      <label class="control-label required">Enrollment Number</label>

                      <select class="form-control" id="enrollment_id" name="enrollment_id" onchange="GetChilddetails()">
                        <option value="">Select-Enrollment</option>

                        @foreach($rows['questionnaire_initiation'] as $key=>$row)
                        <option value="{{$row['enrollment_id']}}">{{ $row['enrollment_child_num']}} ({{ $row['child_name']}})</option>
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

                  <div class="form-group row" style="margin-bottom: 5px;display:none" id="chooseQuestionnaire">
                    <div class="col-md-6">
                      <label class="col-sm-8 control-label col-form-label">Questionnaire Name<span class="error-star" style="color:red;">*</span></label>
                      <select class="form-control js-select2" id="questionnaire_id" multiple="multiple" name="questionnaire_id[]">
                        <option value="">Questionnaire Name</option>
                      {{--  @foreach($rows['questionnaire'] as $key=>$row)

                        <option value="{{ $row['questionnaire_id']}}">{{ $row['questionnaire_name']}}</option>
                        @endforeach --}}
                      </select>
                    </div>
                    <input type="hidden" id="paymenttokentime" name="paymenttokentime" value="{{$paymenttokentime[0]['token_expire_time']}}">
                    <div class="col-md-3">
                      <label class="col-sm-3 control-label col-form-label">Status</label> <br>
                      <input class="form-control" type="text" id="payment_status" name="status" value="New" placeholder="New" autocomplete="off" readonly>
                    </div>
                    <input type="hidden" id="btn_status" name="btn_status" value="">
                    <input type="hidden" id="userID" name="userID" value="">


                    <!-- <div class="form-group row" style="margin-bottom: 5px;"> -->
                    <!-- <div class="col-md-4">
                      <label class="col-sm-6 control-label col-form-label">Activity Set<span class="error-star" style="color:red;">*</span></label>
                      <select class="form-control" name="activity_id" id="activity_id" onchange="Description()">
                        <option value="">Select Activity Set</option>
                        @foreach($activity as $key=>$active)
                        <option value="{{ $active['activity_id'] }}">{{ $active['activity_name'] }}</option>
                        @endforeach
                      </select>
                    </div> -->
                  </div>

                  <!-- <input type="hidden" id="paymenttokentime" name="paymenttokentime" value="{{$paymenttokentime[0]['token_expire_time']}}">
                  <div class="form-group row" style="margin-top:25px">
                    <div class="col-md-4">
                      <label class="col-sm-9 control-label col-form-label">Activity Description<span class="error-star" style="color:red;">*</span></label> <br>
                      <select class="form-control" name="activity_discription" id="actity_discription">
                        <option value="activity_discription">Activity Discription</option>
                      </select>

                    </div>

                    <input type="hidden" id="paymenttokentime" name="paymenttokentime" value="{{$paymenttokentime[0]['token_expire_time']}}">
                    <div class="col-md-3">
                      <label class="col-sm-3 control-label col-form-label">Status</label> <br>
                      <input class="form-control" type="text" id="payment_status" name="status" value="New" placeholder="New" autocomplete="off" readonly>
                    </div>
                    <input type="hidden" id="btn_status" name="btn_status" value="">
                    <input type="hidden" id="userID" name="userID" value="">
                  </div> -->


                </div>
            </div>
          </div>
        </div>
      </div>
      <br>

      <div class="col-md-12  text-center" style="padding-top: 1rem;">
        <!-- <a type="button" onclick="buttonAction('Saved')" class="btn btn-warning" name="type" value="save">Save</a>
                    <a type="button" onclick="buttonAction('Sent')" class="btn btn-success" name="type" value="sent">Submit</a>
                    <button type="" class="btn btn-danger">Cancel</button> -->

        <a type="button" onclick="buttonAction('Sent')" id="submitbutton" class="btn btn-labeled btn-succes" title="Initiate Questionnaire" style="background: green !important; border-color:green !important; color:white !important">
          <span class="btn-label" style="font-size:13px !important;"><i class="fa fa-check"></i></span> Initiate</a>

        <a type="button" class="btn btn-labeled back-btn" title="Back" href="{{ route('sailquestionnairelistview') }}" style="color:white !important">
          <span class="btn-label" style="font-size:13px !important;"><i class="fa fa-arrow-left"></i></span> Back</a>

      </div>
    </div>
</div>

</form>

</div>


</div>
</div>





</div>

<div class="card" style="margin-left:22%;margin-right:2%;" id="invite">

  <div class="card-body">
    <div class="table-wrapper">
      <div class="table-responsive">
        <table class="table table-bordered">
          <thead>
            <tr>
              <th>Sl.No.</th>
              <th>Questionnaire Name</th>
              <th>Status</th>

            </tr>
          </thead>
          <tbody id="sailview">

          </tbody>
        </table>
      </div>

    </div>
  </div>
</div>
</section>
</div>
<script>
   $(".js-select2").select2({
    closeOnSelect : false,
    placeholder : " Please Select",
    allowHtml: true,
        tags: true 
     });
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
    console.log(enrollment_id);
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
          // alert(enrollment_id);

          $.ajax({
            url: '{{ url('/sail/GetQuestionnaire') }}',
            type: "POST",
            dataType: "json",
            data: {
              enrollment_id: enrollment_id,
              type: '1',
              stage: 'SAIL',
              _token: '{{csrf_token()}}'
            },
            success: function(data) {
              //alert(data);
              
              if (data != '[]') {
                var user_select = data.rows;
                var optionsdata = "";
                var ddd ;
                for (var i = 0; i < user_select.length; i++) {
                  var questionnaire_name = user_select[i]['questionnaire_name'];
                  var questionnaire_id = user_select[i]['questionnaire_id'];
                  ddd += "<option value=" + questionnaire_id + ">" + questionnaire_name + "</option>";
                }
                var stageoption = ddd.concat(optionsdata);
                var demonew = $('#questionnaire_id').html(stageoption);

                // 
                var activity = data.activity;
                // var optionsdata1 = "";
                // var ddd1 = "<option value=''>Select Activity</option>";
                // for (var i = 0; i < activity.length; i++) {
                  // var activity_name = activity[i]['activity_name'];
                //   var activity_id = activity[i]['activity_id'];
                //   ddd1 = "<option value=" + activity_id + ">" + activity_name + "</option>";
                // }
                // var stageoption1 = ddd1.concat(optionsdata1);
                // var demonew1 = $('#activity_id').html(stageoption1);
                // var selectobject1 = document.getElementById("activity_id");
                // for (var i = 0; i < activity.length; i++) {
                //   var activity_name = activity[i]['activity_name'];
                //   for (var j = 0; j < selectobject1.length; j++) {
                //     if (selectobject1.options[j].value == activity_name)
                //       selectobject1.remove(j);
                //   }
                // }


              } else {
                var stageoption = ddd.concat(optionsdata);
                // var demonew = $('#questionnaire_id').html(stageoption);
              }


$('#chooseQuestionnaire').show();


            }
          });

          $.ajax({
            url: '{{ url('/sail/GetQuestionnaire') }}',
            type: "POST",
            dataType: "json",
            data: {

              enrollment_id: enrollment_id,
              type: '2',
              stage: 'SAIL',
              _token: '{{csrf_token()}}'
            },
            success: function(data) {
              //alert(data);
              // console.log('ddd');
              // console.log(data.rows);
              if (data.rows != '[]') {
                var user_select = data.rows;
                // var optionsdata = "";
                for (var i = 0; i < user_select.length; i++) {
                  var questionnaire_name = user_select[i].questionnaire_name;
                  var questatus = user_select[i].status;
                  ddd += "<tr><td >" + (parseInt(i) + 1) + "</td><td>" + questionnaire_name + "</td><td> " + questatus + " </td></tr>";
                }
                // var stageoption = ddd.concat(optionsdata);
                var demonew = $('#sailview').html(ddd);
                // document.getElementById('invite').style.display = "block";
              } else {
                var stageoption = ddd.concat(optionsdata);
                // var demonew = $('#questionnaire_id').html(stageoption);
              }
            }
          })

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

    // var activity_id = $('#activity_id').val();
    // if (activity_id == '') {
    //   swal.fire("Please Select Activity Set", "", "error");
    //   return false;
    // }

    // var actity_discription = $('#actity_discription').val();
    // if (actity_discription == '') {
    //   swal.fire("Please Select Activity Discription", "", "error");
    //   return false;
    // }

    document.getElementById('btn_status').value = status;
    document.getElementById('enrollement').submit();
  }

  function Description() {
    var activity_id = $("select[name='activity_id']").val();
    var enrollment_id = $("select[name='enrollment_id']").val();
    if (enrollment_id == '') {
      swal.fire("Please Select Enrollment Child Number: ", "", "error");
      return false;
    }
    if (activity_id != "") {
      $.ajax({
        url: "{{ route('parentvideo.description') }}",
        type: 'POST',
        data: {
          'activity_id': activity_id,
          'enrollment_id': enrollment_id,
          _token: '{{csrf_token()}}'
        }
      }).done(function(data) {
        // var category_id = json.parse(data);
        // console.log(data);

        if (data != '[]') {

          var data = data.desc;
          // var user_select = data;
          if (data != '[]'){
          var optionsdata = '<option value="">Select description</option>';
          for (var i = 0; i < data.length; i++) {
            var id = data[i].activity_description_id;
            var name = data[i].description;
            // console.log(name)
            // var ddd = '<option value="">Select description</option>';
            optionsdata += '<option value="' + id + '"> ' + name + ' </option>';

          }
        }else{
          var optionsdata = '<option value="">No Data Found</option>';
        }
          var demonew = $('#actity_discription').html(optionsdata);

        } else {

          // var ddd = '<option value="">Select description</option>';
          // var demonew = $('#align1').html(ddd);
        }
      })
    } else {
      // var ddd = '<option value="">Select description</option>';
      // var demonew = $('#align1').html(ddd);
    }
  };
</script>








@endsection