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

<div class="main-content">

  <!-- Main Content -->
  <section class="section">


    <div class="section-body mt-1">
      <h5 class="text-center" style="color:darkblue">Header Details</h5>
      @foreach($rows as $key=>$row)
      <form action="{{route('userregisterfee.update', $row['payment_status_id'])}}" method="POST">
        {{ csrf_field() }}
        @method('PUT') 
        <div class="row">
          <div class="col-12">

            <div class="card">
              <div class="card-body">



                <div class="row">
                  <div class="col-md-4">
                    <div class="form-group">
                      <label class="control-label">Enrollment ID</label>
                      <input class="form-control" type="text" id="enrollment_child_num" name="enrollment_child_num" value="{{ $row['enrollment_child_num'] }}"  autocomplete="off">
                      </select>
                    </div>
                  </div>


                  <div class="col-md-4">
                    <div class="form-group">
                      <label class="control-label">Child ID</label>
                      <input class="form-control" type="text" id="child_id" name="child_id" value="{{ $row['child_id']}}" autocomplete="off">
                    </div>
                  </div>
                  <br>


                  <div class="col-md-4">
                    <div class="form-group">
                      <label class="control-label">Child Name</label>
                      <input class="form-control" type="text" id="child_name" name="child_name" value="{{ $row['child_name']}}" autocomplete="off">
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
                        <input class="form-control" type="text" id="initiated_by" name="initiated_by" value="{{ $row['initiated_by']}}" autocomplete="off">


                      </div>
                    </div>

                    <div class="col-md-3">
                      <div class="form-group">
                        <label class="control-label">Initiated To</label>
                        <input class="form-control" type="text" id="initiated_to" name="initiated_to"value="{{ $row['initiated_to']}}"  autocomplete="off">

                      </div>
                    </div>


                    <div class="col-md-3">
                      <div class="form-group">
                        <label class="control-label">Payment Fee</label>
                        <input class="form-control" type="text" id="payment_amount" name="payment_amount" value="Rs.500"  autocomplete="off">
                      </div>
                    </div>
                    <br>


                    <div class="col-md-3">
                      <div class="form-group">
                        <label class="control-label">Status</label>
                        <input class="form-control" type="text" id="payment_status" name="payment_status" value="{{ $row['payment_status']}}"  autocomplete="off">
                      </div>
                    </div>





                  </div>

                  <div class="form-notes">
                    <label class="control-notes">Notes</label>
                    <textarea class="form-control form-note" type="textarea" id="payment_process_description" name="payment_process_description" value="" >kindly Pay Rs.500 for your Enrollment</textarea>
                  </div>




                </div>

              </div>
            </div>

            <div class="col-md-12 text-center" style="padding-top: 1rem;">


            <button type="submit" class="btn btn-success btn-space"  id="savebutton">Payment Initiation</button>
            </div>













          </div>
      </form>
      @endforeach
    </div>
  </section>
</div>


<script type="text/javascript">

</script>

























@endsection
