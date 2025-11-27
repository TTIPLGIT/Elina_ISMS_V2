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
  {{ Breadcrumbs::render('compass_show',1) }}

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
                      <label class="control-label">Enrollment ID</label>
                      <!-- <select class="form-control" name="enrollment_child_num"> -->
                        <!-- <option value="">Select Enrollment ID</option> -->
                        
                        
                        <input class="form-control" type="text" id="enrollment_child_num" name="enrollment_child_num" value="EN/2022/12/025 (Kaviya)" disabled autocomplete="off">
                        
                        
                      <!-- </select> -->
                    </div>
                  </div>

                  <div class="col-md-4">
                    <div class="form-group">
                      <label class="control-label">Child ID</label>
                      <input class="form-control" type="text" id="child_id" name="child_id" value="CH/2022/025" disabled autocomplete="off">
                    </div>
                  </div>
                  <br>
                
                 


                  <div class="col-md-4">
                    <div class="form-group">
                      <label class="control-label">Child Name</label>
                      <input class="form-control" type="text" id="child_name" name="child_name" value="Kaviya" disabled autocomplete="off">
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
                        <input class="form-control" type="text" id="initiated_by" name="initiated_by" value="elinaishead1@gmail.com"disabled autocomplete="off">


                      </div>
                    </div>
                  
              

                    <div class="col-md-3">
                      <div class="form-group">
                        <label class="control-label">Initiated To</label>
                        <input class="form-control" type="text" id="initiated_to" name="initiated_to"value="Kaviya@talentakeaways.com" disabled autocomplete="off">

                      </div>
                    </div>

                    <div class="col-md-3">
                      <div class="form-group">
                        <label class="control-label">Payment Fee</label>
                        <input class="form-control" type="text" id="payment_amount" name="payment_amount" value="20000" disabled autocomplete="off">
                      </div>
                    </div>
                    <br>

                    <div class="col-md-3">
                      <div class="form-group">
                        <label class="control-label">Status</label>
                        <input class="form-control" type="text" id="payment_status" name="payment_status" value="New" disabled autocomplete="off">
                      </div>
                    </div>

                   





                  </div>

                  <div class="form-notes ">
                    <label class="control-notes">Notes</label>
                    <textarea class="form-control  form-note" type="textarea" id="payment_process_description" name="payment_process_description" value="Kindly Pay your CoMPASS Assessment Payment" disabled autocomplete="off">Kindly Pay your CoMPASS Assessment Payment</textarea>
                  </div>




                </div>

              </div>
            </div>

            <div class="col-md-12 text-center" style="padding-top: 1rem;">


<a type="button" class="btn btn-labeled back-btn" title="Back" href="{{ route('userregisterfee.index') }}" style="color:white !important">
<span class="btn-label" style="font-size:13px !important;"><i class="fa fa-arrow-left"></i></span> Back</a>
</div>


</div>
          
          </form>
          
          
        </div>
        
      </section>
    </div>
    
    
    <script type="text/javascript">
    
    </script>
    




@endsection