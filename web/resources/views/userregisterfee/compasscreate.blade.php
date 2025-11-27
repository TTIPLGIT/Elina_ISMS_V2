@extends('layouts.adminnav')
<script type="text/javascript" src="https://cdn.rawgit.com/t4t5/sweetalert/v0.2.0/lib/sweet-alert.min.js"></script>

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
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.16/dist/sweetalert2.all.min.js"></script>

  <!-- Main Content -->
  <section class="section">
  {{ Breadcrumbs::render('compass_register_fee') }}
  @if (session('success'))

<input type="hidden" name="session_data" id="session_data" class="session_data" value="{{ session('success') }}">
<script type="text/javascript">
    window.onload = function() {
        var message = $('#session_data').val();
        Swal.fire({
            title: "Success",
            text: message,
            icon: "success",
        });

    }
</script>
@elseif(session('fail'))

<input type="hidden" name="session_data" id="session_data1" class="session_data" value="{{ session('fail') }}">
<script type="text/javascript">
    window.onload = function() {
        var message = $('#session_data1').val();
        Swal.fire({
            title: "Info",
            text: message,
            icon: "info",
        });

    }
</script>
@endif


    <div class="section-body mt-1">
      <h5 class="text-center" style="color:darkblue">Header Details</h5>
      <form action="{{route('compass_store_data')}}" method="POST" id="sub_mit">
        @csrf
        <div class="row">
          <div class="col-12">

            <div class="card">
              <div class="card-body">



                <div class="row">
                  <div class="col-md-4">
                  <div class="form-group">
                      <label class="control-label">Enrollment ID</label><span class="error-star" style="color:red;">*</span>
                      <select class="form-control" name="enrollment_child_num" id="enrollment_child_num" onchange="myFunction()" readonly>
                        <option value="">Select Enrollment ID</option>
                        @foreach($rows as $key=>$row)

                        <option value="{{ $row['enrollment_child_num'] }}">{{ $row['enrollment_child_num'] }} ( {{$row['child_name']}} )</option>
                        @endforeach
                      </select>
                    </div>
                  </div>
                  <input type="hidden" id="paymenttokentime" name="paymenttokentime" >

                  <div class="col-md-4">
                    <div class="form-group">
                      <label class="control-label required">Child ID</label>
                      <input class="form-control" type="text" id="child_id" name="child_id" autocomplete="off">
                    </div>
                  </div>
                  <br>


                  <div class="col-md-4">
                    <div class="form-group">
                      <label class="control-label required">Child Name</label>
                      <input class="form-control" type="text" id="child_name" name="child_name" autocomplete="off">
                    </div>
                  </div>


                </div>




              </div>
            </div>
          </div>
          <br>


          <h5 class="text-center paymentdetails" style="color:darkblue">Payment Details</h5>
          <br>
          <div class="row">
            <div class="col-12" style="padding-top: 12px;">

              <div class="card">
                <div class="card-body">


                  
                  <div class="row">
                    <div class="col-md-3">
                      <div class="form-group">
                        <label class="control-label required">Initiated By</label>
                        <input class="form-control" type="text" id="initiated_by" name="initiated_by"  value="elinaishead1@gmail.com"autocomplete="off">


                      </div>
                    </div>

                    <div class="col-md-3">
                      <div class="form-group">
                        <label class="control-label required">Initiated To</label>
                        <input class="form-control" type="text" id="initiated_to" name="initiated_to" autocomplete="off">

                      </div>
                    </div>


                    <div class="col-md-3">
                      <div class="form-group">
                        <label class="control-label required">Payment Fee(IN Rs)</label>
                        <input class="form-control" type="text" id="payment_amount" name="payment_amount" value="20000" autocomplete="off">
                      </div>
                    </div>
                    <br>


                    <div class="col-md-3">
                      <div class="form-group">
                        <label class="control-label">Status</label>
                        <input class="form-control" type="text" id="payment_status" name="payment_status" value="New" autocomplete="off">
                      </div>
                    </div>





                  </div>

                  <div class="form-notes ">
                    <label class="control-notes">Notes</label>
                    <textarea class="form-control  form-note" type="textarea" id="payment_process_description" name="payment_process_description" value="">Kindly Pay your CoMPASS Assessment Payment</textarea>
                  </div>




                </div>

              </div>
            </div>

            <div class="col-md-12  text-center" style="padding-top: 1rem;">


<a type="button" onclick="save()" id="submitbutton" class="btn btn-labeled btn-succes" title="Initiate Payment" style="background: green !important; border-color:green !important; color:white !important">
<span class="btn-label" style="font-size:13px !important;"><i class="fa fa-check"></i></span>Payment Initiation</a>

<a type="button" class="btn btn-labeled back-btn" title="Back" href="{{ route('userregisterfee.index') }}" style="color:white !important">
<span class="btn-label" style="font-size:13px !important;"><i class="fa fa-arrow-left"></i></span> Back</a>

</div>













          </div>
      </form>
    </div>
  </section>
</div>
<script>
  function save(){
    
    
var enrollment_child_num = $('#enrollment_child_num').val();

if (enrollment_child_num == '') {
  Swal.fire("Please Select Enrollment Number", "", "error");
    return false;
}

var child_id = $('.child_id').val();

if (child_id == '') {
  Swal.fire("Please Enter Child ID", "", "error");
    return false;
}



var child_name = $('.child_name').val();

if (child_name == '') {
  Swal.fire("Please Enter Child Name", "", "error");
    return false;
}

var initiated_by = $('#initiated_by').val();

if (initiated_by == '') {
  Swal.fire("Please Enter Initiated_by", "", "error");
    return false;
}

var initiated_to = $('#initiated_to').val();

if (initiated_to == '') {
  Swal.fire("Please Enter Initiated To", "", "error");
    return false;
}

var payment_amount = $('#payment_amount').val();

if (payment_amount == '') {
  Swal.fire("Please Enter Payment Fee", "", "error");
    return false;
}

var payment_status = $('#payment_status').val();

if (payment_status == '') {
  Swal.fire("Please Enter Payment Status", "", "error");
    return false;
}

  Swal.fire({
     
     title: "Do you want to Initiate the CoMPASS Payment?",
       text: "Please click 'Yes' to Initiate the CoMPASS Payment.",
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
      document.getElementById('sub_mit').submit();
     

  }
  })
}
  

  
  
</script>

<script type="text/javascript">


$.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    function myFunction() {
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
                    document.getElementById('initiated_to').value= data[0].child_contact_email;
                        
                        // console.log(name)
                      
                   
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

























@endsection