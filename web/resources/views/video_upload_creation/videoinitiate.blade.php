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
</style>

<div class="main-content" style="min-height:'60px'"> 

  <!-- Main Content -->
  <section class="section">


    <div class="section-body mt-1">
      <h5 class="text-center" style="color:darkblue">Header Details</h5>
      <form action="{{route('activity_initiate.store')}}" id="userregistration" method="POST">
        @csrf
        <div class="row">
          <div class="col-12">

            <div class="card">
              <div class="card-body">



                <div class="row">
                  <div class="col-md-4">
                    <div class="form-group">
                      <label class="control-label">Enrollment ID</label><span class="error-star" style="color:red;">*</span>
                      <select class="form-control" name="enrollment_id" id="enrollment_id" onchange="myFunction()" readonly>
                        <option value="">Select Enrollment ID</option>
                        @foreach($rows as $key=>$row)

                        <option value="{{ $row['enrollment_child_num'] }}">{{ $row['enrollment_child_num'] }}</option>
                        @endforeach
                      </select>
                    </div>
                  </div>


                  <div class="col-md-4">
                    <div class="form-group">
                      <label class="control-label">Child ID</label><span class="error-star" style="color:red;">*</span>
                      <input class="form-control" type="text" id="child_id" name="child_id" autocomplete="off" readonly>
                    </div>
                  </div>
                


                  <div class="col-md-4">
                    <div class="form-group">
                      <label class="control-label">Child Name</label><span class="error-star" style="color:red;">*</span>
                      <input class="form-control" type="text" id="child_name" name="child_name" autocomplete="off" readonly>
                    </div>
                  </div>


                </div>




              </div>
            </div>
          </div>
          


          
          
          <div class="row">
            <div class="col-12" style="padding-top: 45px;">

              <div class="card">
                <div class="card-body">


                  
                <div class="row">

                <div class="col-md-4">
                      <div class="form-group">
                        <label class="control-label">Initiated By</label><span class="error-star" style="color:red;">*</span>
                        <input class="form-control" type="text" id="initiated_by" name="initiated_by" value=" {{$email[0]['email'] }}" autocomplete="off" readonly>


                      </div>
                    </div>

                    <div class="col-md-4">
                      <div class="form-group">
                        <label class="control-label">Initiated To</label><span class="error-star" style="color:red;">*</span>
                        <input class="form-control" type="text" id="initiated_to" name="initiated_to" autocomplete="off" readonly>

                      </div>
                    </div>

                  <div class="col-md-4">
                    <div class="form-group">
                      <label class="control-label">Activity Name</label><span class="error-star" style="color:red;">*</span>
                      <select class="form-control" name="activity_id" id="activity_id" onchange="myFunction()" readonly>
                        <option value="">Select Activity Set</option>
                        @foreach($activity as $key=>$active)
                        <option value="{{ $active['activity_id'] }}">{{ $active['activity_name'] }}</option>
                        @endforeach
                      </select>
                    </div>
                  </div>


                 
                


                 

                </div>

                  

                  




                </div>

              </div>
            </div>

            <div class="col-md-12  text-center" style="padding-top: 1rem;">


            <a type="button" onclick="save()('submitted')" id="submitbutton" class="btn btn-labeled btn-succes" title="save" style="background: green !important; border-color:green !important; color:white !important">
            <span class="btn-label" style="font-size:13px !important;"><i class="fa fa-check"></i></span>Activity Initiation</a>

            </div>













          </div>
      </form>
    </div>
  </section>
</div>


<script type="text/javascript">


$.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    function myFunction() {
        var enrollment_id = $("select[name='enrollment_id']").val();

        if (enrollment_id != "") {
            $.ajax({
                url: "{{ url('/activityinitiate/ajax') }}",
                type: 'POST',
                data: {
                    'enrollment_id': enrollment_id,
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
                    document.getElementById('initiated_to').value= data[0].child_contact_email;
                    document.getElementById('user_id').value= data[0].user_id;
                        console.log(name)
                      
                   
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

        function save() {


var enrollment_id = $('#enrollment_id').val();

if (enrollment_id == '') {
    swal.fire("Please Enter Enrollment Child Number: ", "", "error");
    return false;
}

var child_id = $('.child_id').val();

if (child_id == '') {
    swal.fire("Please Enter Child ID:", "", "error");
    return false;
}



var child_name = $('.child_name').val();

if (child_name == '') {
    swal.fire("Please Enter Child Name:", "", "error");
    return false;
}
var initiated_by = $('#initiated_by').val();

if (initiated_by == '') {
    swal.fire("Please Enter Initiated_by:  ", "", "error");
    return false;
}

var initiated_to = $('#initiated_to').val();

if (initiated_to == '') {
    swal.fire("Please Enter Initiated To:  ", "", "error");
    return false;
}

var activity_id = $('#activity_id').val();

if (activity_id == '') {
    swal.fire("Please Select Activity Set  ", "", "error");
    return false;
}







document.getElementById('userregistration').submit('saved');
}


</script>


























@endsection