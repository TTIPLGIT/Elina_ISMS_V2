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
      <form action="{{route('userregisterfee.store')}}" method="POST">
        @csrf
        <div class="row">
          <div class="col-12">

            <div class="card">
              <div class="card-body">



                <div class="row">
                  <div class="col-md-4">
                    <div class="form-group">
                      <label class="control-label">Enrollment ID</label>
                      <select class="form-control" name="enrollment_child_num" id="enrollment_child_num" onchange="myFunction()">
                        <option value="">Select Enrollment ID</option>
                        @foreach($rows as $key=>$row)

                        <option value="{{ $row['enrollment_child_num'] }}">{{ $row['enrollment_child_num'] }}</option>
                        @endforeach
                      </select>
                    </div>
                  </div>


                  <div class="col-md-4">
                    <div class="form-group">
                      <label class="control-label">Child ID</label>
                      <input class="form-control" type="text" id="child_id" name="child_id" autocomplete="off">
                    </div>
                  </div>
                  <br>


                  <div class="col-md-4">
                    <div class="form-group">
                      <label class="control-label">Child Name</label>
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
                        <label class="control-label">Initiated By</label>
                        <input class="form-control" type="text" id="initiated_by" name="initiated_by" value=" {{$email[0]['email'] }}" autocomplete="off">


                      </div>
                    </div>

                    <div class="col-md-3">
                      <div class="form-group">
                        <label class="control-label">Initiated To</label>
                        <input class="form-control" type="text" id="initiated_to" name="initiated_to" autocomplete="off">

                      </div>
                    </div>


                    <div class="col-md-3">
                      <div class="form-group">
                        <label class="control-label">Payment Fee</label>
                        <input class="form-control" type="text" id="payment_amount" name="payment_amount" value="Rs.2000" autocomplete="off">
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
                    <textarea class="form-control  form-note" type="textarea" id="payment_process_description" name="payment_process_description" value="">kindly Pay your SAIL Assessment Payment</textarea>
                  </div>




                </div>

              </div>
            </div>

            <div class="col-md-12 text-center" style="padding-top: 1rem;">


            <button type="submit" class="btn btn-success btn-space" style="background-color: green;"  id="savebutton">Payment Initation</button>
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