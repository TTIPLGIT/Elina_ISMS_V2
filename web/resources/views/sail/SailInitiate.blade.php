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

  #co_one,
  #co_two {
    padding: 0 0 0 5px;
    background: transparent;
  }
</style>
<div class="main-content" style="position:absolute !important; z-index: -2!important; ">
  <section class="section">

    {{ Breadcrumbs::render('sailstatus.initiate') }}

    <div class="section-body mt-1">
      <h5 class="text-center" style="color:darkblue">Sail Initiate</h5>
      <div class="row">
        <div class="col-12">
          <div class="card">
            <div class="card-body">

              <!-- <form action="{{route('sail.initiate.sotre')}}" method="POST" id="sailinitiate" enctype="multipart/form-data"> -->
              <!-- Previously used for SAIL Initiation 
              Initially : New Sail Initiate
              Then : SAIL Initiation Automated 
              Now : When : SAIL Program Declined by Parent
              -->
              <form action="{{route('sail.reinitiate.store')}}" method="POST" id="sailinitiate" enctype="multipart/form-data">
                @csrf

                <div class="row is-coordinate">
                  <div class="col-md-4">
                    <div class="form-group">
                      <label class="control-label required">Enrollment Number</label>
                      <select class="form-control" id="enrollment_child_num" name="enrollment_child_num" onchange="GetChilddetails()" required>
                        <option value="">Select-Enrollment</option>
                        @foreach($rows as $key=> $row)
                        <option value="{{$row['enrollment_child_num']}}">{{ $row['enrollment_child_num']}} ({{ $row['child_name']}})</option>
                        @endforeach
                      </select>
                    </div>
                  </div>
                  <input type="hidden" name="user_id" id="user_id" value="">
                  <div class="col-md-4">
                    <div class="form-group">
                      <label class="control-label required">Child ID</label>
                      <input class="form-control" type="text" id="child_id" name="child_id" placeholder="Child ID" autocomplete="off" readonly>
                      <input type="hidden" id="enrollment_id" name="enrollment_id">
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group">
                      <label class="control-label required">Child Name</label>
                      <input class="form-control" type="text" id="child_name" name="child_name" oninput="Childname(event)" maxlength="20" value="" placeholder="Enter Name" autocomplete="off" readonly>
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group ">
                      <label class="control-label required">IS Co-ordinator</label>
                      <div style="display: flex;">
                        <select class="form-control" id="is_coordinator1" name="is_coordinator1" onchange="iscoordinatorfn(event)" readonly style="pointer-events: none !important;">
                          <option value="">Select-IS-Coordinator-1</option>
                          @foreach($iscoordinators as $key=>$row)
                          <option value="{{$row['id']}}" id="a{{$row['id']}}">{{ $row['name']}}</option>
                          @endforeach
                        </select>
                      </div>
                      <input type="hidden" id="is_coordinator1old" data-attr='<?php echo json_encode($iscoordinators); ?>'>
                      <input type="hidden" id="is_coordinator1current">
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group">
                      <label class="control-label required">IS Co-ordinator-2</label>
                      <div style="display: flex;">
                        <select class="form-control" id="is_coordinator2" name="is_coordinator2" onchange="iscoordinatorfn(event)" readonly style="pointer-events: none !important;">
                          <option value="">Select-IS-Coordinator-2</option>
                          @foreach($iscoordinators as $key=>$row)
                          <option value="{{$row['id']}}" id="b{{$row['id']}}">{{ $row['name']}}</option>
                          @endforeach
                        </select>
                      </div>
                      <input type="hidden" id="is_coordinator2old" data-attr='<?php echo json_encode($iscoordinators); ?>'>
                      <input type="hidden" id="is_coordinator2current">
                    </div>
                  </div>
                </div>
            </div>
          </div>
        </div>
      </div>
      <br>
      </form>
      <div class="col-md-12  text-center" style="padding-top: 1rem;">


        <a type="button" onclick="save()" id="submitbutton" class="btn btn-labeled btn-succes" title="Submit" style="background: green !important; border-color:green !important; color:white !important">
          <span class="btn-label" style="font-size:13px !important;"><i class="fa fa-check"></i></span> Submit</a>

        <a type="button" class="btn btn-labeled back-btn" title="Back" href="{{ route('sailstatus') }}" style="color:white !important">
          <span class="btn-label" style="font-size:13px !important;"><i class="fa fa-arrow-left"></i></span> Back</a>

      </div>

    </div>
</div>
</div>
<br>
</div>
</section>
</div>
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
        // console.log(data);

        if (data != '[]') {

          // var user_select = data;
          var optionsdata = "";

          document.getElementById('child_id').value = data[0].child_id;
          document.getElementById('child_name').value = data[0].child_name;
          document.getElementById('enrollment_id').value = data[0].enrollment_id;
          document.getElementById('user_id').value = data[0].user_id;


          // console.log(data[0].user_id);
          $.ajax({
            url: "{{ url('/sail/GetIsCo') }}",
            type: "POST",
            dataType: "json",
            data: {
              enrollment_id: enrollment_child_num,
              _token: '{{csrf_token()}}'
            },
            success: function(data) {
              // console.log(data[0].co1); console.log(data[0].co2);
              var co1 = data[0].co1;
              co1 = 'a'.concat(co1);
              var co2 = data[0].co2;
              co2 = 'b'.concat(co2);
              var is_coordinator1 = document.getElementById("is_coordinator1");
              $('select option[id=' + co1 + ']').attr("selected", true);

              var is_coordinator2 = document.getElementById("is_coordinator2");
              $('select option[id=' + co2 + ']').attr("selected", true);

            }
          });

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
  function save() {

    var enrollment_child_num = $('#enrollment_child_num').val();
    if (enrollment_child_num == "") {
      swal.fire("Please Select Enrolment Number", "", "error");
      return false;
    }
    var child_id = $('#child_id').val();
    if (child_id == "") {
      swal.fire("Please Enter Child ID", "", "error");
      return false;
    }
    var child_name = $('#child_name').val();
    if (child_name == "") {
      swal.fire("Please Enter Child Name", "", "error");
      return false;
    }
    var co_one = $('#is_coordinator1').val();
    if (co_one == "") {
      swal.fire("Please Select IS Coordinator", "", "error");
      return false;
    }
    // var co_two = $('#is_coordinator2').val();
    // if (co_two == "") {
    //   swal.fire("Please Select IS Coordinator 2", "", "error");
    //   return false;
    // }
    $(".loader").show();
    document.getElementById('sailinitiate').submit();

  }
</script>
@endsection