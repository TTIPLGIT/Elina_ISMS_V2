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
    {{ Breadcrumbs::render('userregisterfee.show',$rows[0]['payment_status_id']) }}

    <div class="section-body mt-1">


      <h5 class="text-center" style="color:darkblue">{{$rows[0]['payment_for']}} Details</h5>
      @foreach($rows as $key=>$row)

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
                      <!-- <select class="form-control" name="enrollment_child_num"> -->
                      <!-- <option value="">Select Enrollment ID</option> -->


                      <input class="form-control" type="text" id="enrollment_child_num" name="enrollment_child_num" value="{{ $row['enrollment_child_num'] }}" disabled autocomplete="off">


                      <!-- </select> -->
                    </div>
                  </div>


                  <div class="col-md-4">
                    <div class="form-group">
                      <label class="control-label">Child ID</label>
                      <input class="form-control" type="text" id="child_id" name="child_id" value="{{ $row['child_id']}}" disabled autocomplete="off">
                    </div>
                  </div>
                  <br>


                  <div class="col-md-4">
                    <div class="form-group">
                      <label class="control-label">Child Name</label>
                      <input class="form-control" type="text" id="child_name" name="child_name" value="{{ $row['child_name']}}" disabled autocomplete="off">
                    </div>
                  </div>

                  <div class="col-md-4">
                    <div class="form-group">
                      <label class="control-label">Father/Guardian Name</label>
                      <input class="form-control" type="text" id="father_name" name="father_name" value="{{ $row['father']}}" disabled autocomplete="off">
                    </div>
                  </div>

                  <div class="col-md-4">
                    <div class="form-group">
                      <label class="control-label">Mother/Primary Caretaker's Name</label>
                      <input class="form-control" type="text" id="mother_name" name="mother_name" value="{{ $row['mother']}}" disabled autocomplete="off">
                    </div>
                  </div>

                  <div class="col-md-4">
                    <div class="form-group">
                      <label class="control-label">Contact Phone Number</label>
                      <input class="form-control" type="text" id="phone_number" name="phone_number" value="{{ $row['phno']}}" disabled autocomplete="off">
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
                        <input class="form-control" type="text" id="initiated_by" name="initiated_by" value="{{ $row['initiated_by']}}" disabled autocomplete="off">


                      </div>
                    </div>

                    <div class="col-md-3">
                      <div class="form-group">
                        <label class="control-label">Initiated To</label>
                        <input class="form-control" type="text" id="initiated_to" name="initiated_to" value="{{ $row['initiated_to']}}" disabled autocomplete="off">

                      </div>
                    </div>
                    @if(!empty($row['payment_date']))
                    <div class="col-md-4">
                      <div class="form-group">
                        <label class="control-label required">Payment Date</label>
                        <div class="inner-addon right-addon">
                          <i class="glyphicon fas fa-calendar-alt"></i>
                          <input type='text' class="form-control payment_date default" id='payment_date' name="payment_date" value="{{ $row['payment_date']}}" title="Payment Date" disabled autocomplete="off">
                        </div>
                      </div>
                    </div>
                    @else
                    <div class="col-md-4">
                      <div class="form-group">
                        <label class="control-label required">Payment Date</label>
                        <div class="inner-addon right-addon">
                          <i class="glyphicon fas fa-calendar-alt"></i>
                          @php
                          // Convert created_date to the desired format
                          $formattedDate = date('d/m/Y', strtotime($row['created_date']));
                          @endphp
                          @if($row['payment_status'] == 'SUCCESS')
                          <input type='text' class="form-control payment_date default" id='payment_date' name="payment_date" value="{{ $formattedDate }}" title="Payment Date" disabled autocomplete="off">
                          @else
                          <input type='text' class="form-control payment_date default" id='payment_date' name="payment_date" value="" title="Payment Date" disabled autocomplete="off">
                          @endif

                        </div>
                      </div>
                    </div>
                    @endif

                    <div class="col-md-3">
                      <div class="form-group">
                        <label class="control-label">Payment Fee</label>
                        <input class="form-control" type="text" id="payment_amount" name="payment_amount" value="{{ $row['payment_amount']}}" disabled autocomplete="off">
                      </div>
                    </div>
                    <br>


                    <div class="col-md-3">
                      <div class="form-group">
                        <label class="control-label">Status</label>
                        <input class="form-control" type="text" id="payment_status" name="payment_status" value="{{ $row['payment_status']}}" disabled autocomplete="off">
                      </div>
                    </div>

                    <div class="col-md-3">
                      <div class="form-group">
                        <label class="control-label">Reference ID</label>
                        <input class="form-control" type="text" id="reference_id" name="reference_id" value="{{ $row['reference_id']}}" disabled autocomplete="off">
                      </div>
                    </div>
                    <div class="col-md-4">
                      <div class="form-group">
                        <label class="control-label">Attach File</label>
                        <?php if (!empty($row['file_name'])) : ?>
                          <input class="form-control default" type="text" id="file" name="file" value="{{ $row['file_name']}}" readonly>
                          <br />
                          <a href="{{ asset('offline_payment/' . $row['payment_status_id'] . '/' . $row['file_name']) }}" id="viewLink" class="btn btn-info" title="View Attachment" style="" target="_blank"><i class="fa fa-eye" style="color:white!important"></i> View</a>
                        <?php else : ?>
                          <p>No file uploaded</p>
                        <?php endif; ?>
                      </div>

                    </div>

                  </div>

                  <!-- <div class="form-notes">
                    <label class="control-notes">Notes</label>
                    <textarea class="form-control  form-note" type="textarea" id="payment_process_description" name="payment_process_description" value="{{ $row['payment_process_description']}}" disabled autocomplete="off">{{ $row['payment_process_description']}} </textarea>
                  </div> -->

                </div>
              </div>
            </div>
          </div>
          <div class="col-md-12 text-center" style="padding-top: 1rem;">
            <a type="button" class="btn btn-labeled back-btn" title="Cancel" href="{{ route('userregisterfee.index') }}" style="color:white !important">
              <span class="btn-label" style="font-size:13px !important;"><i class="fa fa-times"></i></span> Cancel</a>
          </div>
        </div>
      </form>
    </div>
    @endforeach
  </section>
</div>
@endsection