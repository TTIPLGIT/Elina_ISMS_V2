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
  .select2-container--default .select2-selection--single .select2-selection__rendered {
    color: #444;
   line-height:42px!important; 
}

  .centerid {
    width: 100%;
    text-align: center;
  }

  #invite {
    display: none;
  }

  #co_one,
  #co_two {
    padding: 0 0 0 5px;
    background: transparent;
  }
</style>
<div class="main-content" style="position:absolute !important; z-index: -2!important; ">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.16/dist/sweetalert2.all.min.js"></script>

  <!-- Main Content -->
  <section class="section">


    <div class="section-body mt-1">
      <h5 class="text-center" style="color:darkblue">CoMPASS Initiative</h5>
      <div class="row">
        <div class="col-12">

          <div class="card">
            <div class="card-body">

              <!-- <form method="POST" action="{{ route('ovm1.store') }}"> onsubmit="return validateForm()" -->
              <form action="{{route('compass_store')}}" method="POST" id="compassinitiate" enctype="multipart/form-data">

                @csrf

                
                <div class="row is-coordinate">
                <div class="col-md-4">
                    <div class="form-group">
                      <label class="control-label required">Enrollment Number</label>
                      <select class="form-control" name="enrollment_child_num" id="enrollment_child_num" onchange=" GetChilddetails()">
                        <option value="">Select Enrollment ID</option>
                        @foreach($rows as $key=>$row)

                        <option value="{{ $row['enrollment_child_num'] }}">{{ $row['enrollment_child_num'] }} ( {{$row['child_name']}} )</option>
                        @endforeach
                      </select>
                    </div>
                  </div>
                  <input type="hidden" name="user_id" id="user_id" value="">
                  <div class="col-md-4">
                    <div class="form-group">
                      <label class="control-label">Child ID</label>
                      <input class="form-control" type="text" id="child_id" name="child_id" placeholder="Child ID" autocomplete="off" readonly>
                      <input type="hidden" id="enrollment_id" name="enrollment_id">
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group">
                      <label class="control-label">Child Name</label>
                      <input class="form-control" type="text" id="child_name" name="child_name" oninput="Childname(event)" maxlength="20" value="" placeholder="Enter Name" autocomplete="off" readonly>
                    </div>
                  </div>
                  <!-- <div class="col-md-4">
                    <div class="form-group ">
                      <label class="control-label">IS Co-ordinator-1</label>
                      <div style="display: flex;">
                        <select class="form-control" id="is_coordinator1" name="is_coordinator1" onchange="iscoordinatorfn(event)" required>
                          <option value="">Select-IS-Coordinator-1</option>
                         
                        </select>
                      </div>
                      <input type="hidden" id="is_coordinator1old" >
                      <input type="hidden" id="is_coordinator1current">
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group">
                      <label class="control-label">IS Co-ordinator-2</label>
                      <div style="display: flex;">
                        <select class="form-control" id="is_coordinator2" name="is_coordinator2" onchange="iscoordinatorfn(event)" required>
                          <option value="">Select-IS-Coordinator-2</option>
                         
                        </select>
                      </div>
                      <input type="hidden" id="is_coordinator2old" >
                      <input type="hidden" id="is_coordinator2current">
                    </div>
                  </div> -->
                </div>
            </div>
          </div>
        </div>
      </div>
      <br>   

      <!-- <div class="row" id="invite">
        <div class="col-12">
          <div class="card">
            <div class="card-body">
              <div class="form-group row" style="margin-bottom: 5px;">
                <label class="col-sm-2 col-form-label">To</label>
                <div class="col-sm-4">
                  <input class="form-control" type="text" id="meeting_to" name="meeting_to" placeholder="Email Id" required autocomplete="off">
                </div>
                <div class="col-md-2">
                </div>
                <div class="col-md-2">
                  <label class="control-label centerid">Status</label> <br>
                  <input class="form-control" type="text" id="meeting_status" name="meeting_status" placeholder="New" autocomplete="off" readonly>
                </div>
              </div>
              <div class="form-group row">
                <label class="col-sm-2 col-form-label">Subject</label>
                <div class="col-sm-4">
                  <input class="form-control" type="text" id="meeting_subject" name="meeting_subject" placeholder="OVM1 Meeting" title="Meeting Subject" required autocomplete="off">
                </div>
              </div>
              <div class="form-group row">
                <label class="col-sm-2 col-form-label">Location</label>
                <div class="col-sm-4">
                  <input class="form-control" type="text" id="meeting_location" name="meeting_location" oninput="location(event)" title="Meeting Location" maxlength="20" value="" placeholder="Enter Location" required autocomplete="off">
                </div>
              </div>
              <div class="form-group row">
                <label class="col-sm-2 col-form-label">Start Date and Time</label>
                <div class="col-sm-4">

                  <input type='date' class="form-control" id='meeting_startdate' name="meeting_startdate" title="Meeting Start Date" required>

                </div>
                <div class="col-sm-2">
                  <div class="content">
                    <input class="form-control" type="time" id="meeting_starttime" name="meeting_starttime" title="Meeting Start Time" required>
                  </div>

                </div>

              </div>
              <div class="form-group row">
                <label class="col-sm-2 col-form-label">End Date and Time</label>
                <div class="col-sm-4">
                  <input type='date' class="form-control" id="meeting_enddate" name="meeting_enddate" title="Meeting End Date" required placeholder="MM/DD/YYYY">
                </div>
                <div class="col-sm-2">

                  <div class="content">
                    <input class="form-control" type="time" id="meeting_endtime" name="meeting_endtime" title="Meeting End Time" required>
                  </div>

                </div>
                <div class="col-lg-12">
                  <div class="form-group">
                    <textarea class="form-control" id="meeting_description" name="meeting_description" required></textarea>
                  </div>
                </div>

                <br>

              </div>
              <div class="row text-center">
                <div class="col-md-12">


                  <a type="button" class="btn btn-warning text-white" onclick="validateForm('Saved')" name="type" value="Saved">Save</a>
                  <a type="button" class="btn btn-success text-white" onclick="validateForm('sent')" name="type" value="sent">Send</a>
                  <a type="reset" class="btn btn-danger text-white">Cancel</a>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div> -->

      </form>
      <div class="col-md-12  text-center" style="padding-top: 1rem;">


<a type="button" onclick="save()" id="submitbutton" class="btn btn-labeled btn-succes" title="Submit" style="background: green !important; border-color:green !important; color:white !important">
<span class="btn-label" style="font-size:13px !important;"><i class="fa fa-check"></i></span> Submit</a>

<a type="button" class="btn btn-labeled back-btn" title="Back" href="{{ route('compassstatus') }}" style="color:white !important">
<span class="btn-label" style="font-size:13px !important;"><i class="fa fa-arrow-left"></i></span> Back</a>

</div>

    </div>
</div>
</div>
<br>
</div>
</section>
</div>
<script type="text/javascript" src="https://cdn.rawgit.com/t4t5/sweetalert/v0.2.0/lib/sweet-alert.min.js"></script>


<script type="text/javascript">


  const iscoordinatorfn = (event) => {
    let coordinatorname = event.target.value;
    let currentcoordinator = event.target.name;
    if (currentcoordinator === "is_coordinator1") {
      let iscoordinater2new = JSON.parse($('#is_coordinator2old').attr('data-attr'));
      intcoordinatorname = parseInt(coordinatorname);
      iscoordinater2new = iscoordinater2new.filter(name => name.id !== intcoordinatorname)
      alternatecoordinator = document.getElementById('is_coordinator2')
      var ddd = '<option value="">Select-IS-Coordinator-2</option>';
      for (i = 0; i < iscoordinater2new.length; i++) {
        ddd += '<option value="' + iscoordinater2new[i].id + '">' + iscoordinater2new[i].name + '</option>';
      }
      let currentcoordinatorname = alternatecoordinator.value;
      alternatecoordinator.innerHTML = "";
      alternatecoordinator.innerHTML = ddd;
      alternatecoordinator.value = currentcoordinatorname;
    } else {
      let iscoordinater1new = JSON.parse($('#is_coordinator1old').attr('data-attr'));
      intcoordinatorname = parseInt(coordinatorname);
      iscoordinater1new = iscoordinater1new.filter(name => name.id !== intcoordinatorname)
      alternatecoordinator = document.getElementById('is_coordinator1');
      var ddd = '<option value="">Select-IS-Coordinator-1</option>';
      for (i = 0; i < iscoordinater1new.length; i++) {
        ddd += '<option value="' + iscoordinater1new[i].id + '">' + iscoordinater1new[i].name + '</option>';
      }
      let currentcoordinatorname = alternatecoordinator.value;
      alternatecoordinator.innerHTML = "";
      alternatecoordinator.innerHTML = ddd;
      alternatecoordinator.value = currentcoordinatorname;
    }
    //...
  }
</script>


<script>
  function newmeeting()

  {
    if (document.getElementById('enrollment_child_num').value == "") {
      Swal.fire("Please Select Enrolment Number: ", "", "error");
      return false;
    }
    document.getElementById('invite').style.display = "block";
  }
</script>

<!-- //validation -->
<script>
  function Childname(event) {
    let value = event.target.value || '';
    value = value.replace(/[^a-z A-Z ]/, '', );
    event.target.value = value;

  }

  function location(event) {
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
    var enrollment_child_num = $("select[name='enrollment_child_num']").val();

    if (enrollment_child_num != "") {
      $.ajax({
        url: "{{ url('/userregisterfee/enrollmentlist') }}",
        type: 'POST',
        data: {
          'enrollment_child_num': enrollment_child_num,
          _token: '{{csrf_token()}}'
        }
      }).done(function(data) {
        // var category_id = json.parse(data);
        console.log(data);

        if (data != '[]') {

          // var user_select = data;
          var optionsdata = "";

          document.getElementById('child_id').value = data[0].child_id;
          document.getElementById('child_name').value = data[0].child_name;
          document.getElementById('enrollment_id').value = data[0].enrollment_id;
          document.getElementById('user_id').value = data[0].user_id;


          console.log(data[0].user_id);


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
  function save(){
    

    var enrollment_child_num = $('#enrollment_child_num').val();
    
    if (enrollment_child_num == "") {
      
      Swal.fire("Please Select Enrolment Number", "", "error");
      return false;
    }
    var child_id = $('#child_id').val();
    if (child_id == "") {
      Swal.fire("Please Enter Child ID", "", "error");
      return false;
    }
    var child_name = $('#child_name').val();
    if (child_name == "") {
      Swal.fire("Please Enter Child Name", "", "error");
      return false;
    }
    // var co_one = $('#is_coordinator1').val();
    // if (co_one == "") {
    //   swal("Please Select IS Coordinator 1", "", "error");
    //   return false;
    // }
    // var co_two = $('#is_coordinator2').val();
    // if (co_two == "") {
    //   swal("Please Select IS Coordinator 2", "", "error");
    //   return false;
    // }
    Swal.fire({
     
                title: "Do you want to submit?",
                text:"Please click 'Yes', you will be successfully initiated,Consent form & Snapshot will be sent to the child "+child_name,
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
          document.getElementById('compassinitiate').submit();
           
        }
    })
  }
</script>
<script type="text/javascript">
		$("#enrollment_child_num").select2({
			tags: false
		});		
</script>
@endsection