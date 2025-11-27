@extends('layouts.parent')

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

  .razorpay-payment-button {
    background-color: green;
    border-color: green;
    color: white;
    font-weight: 200;
    padding: 6px;
    border-radius: 10px;
  }

  .paymentscreen {
    display: none !important;
  }
</style>
<meta name="csrf-token" content="{{ csrf_token() }}">
<div class="main-content">

  <!-- Main Content -->
  <section class="section">
    {{ Breadcrumbs::render('payuserfee.create') }}
    @if (session('success'))
    <input type="hidden" name="session_data" id="session_data" class="session_data" value="{{ session('success') }}">
    <script type="text/javascript">
      window.onload = function() {
        var message = $('#session_data').val();
        swal.fire("Success", message, "success");
      }
    </script>
    @elseif(session('fail'))
    <input type="hidden" name="session_data" id="session_data1" class="session_data" value="{{ session('fail') }}">
    <script type="text/javascript">
      window.onload = function() {
        var message = $('#session_data1').val();
        swal.fire("Info", message, "info");
      }
    </script>
    @endif
    <div class="section-body">
      <div class="col-lg-12 text-center">
        <h4 class="screen-title"> {{$enrollment[0]['payment_for']}} Details</h4>
      </div>

      <div class="row">
        <div class="col-12">
          <div class="card">
            <div class="card-body">
              <div class="row">

                <div class="col-md-4">
                  <div class="form-group">
                    <label class="control-label">Enrollment Number</label><span class="error-star" style="color:red;">*</span>
                    <input class="form-control" type="text" id="enrollment_child_num" name="enrollment_child_num" value="{{$enrollment[0]['enrollment_child_num'] }}" autocomplete="off" disabled>
                  </div>
                </div>

                <div class="col-md-4">
                  <div class="form-group">
                    <label class="control-label">Child ID</label><span class="error-star" style="color:red;">*</span>
                    <input class="form-control" type="text" id="child_id" name="child_id" value="{{$enrollment[0]['child_id'] }}" autocomplete="off" disabled>
                  </div>
                </div>
                <br>

                <div class="col-md-4">
                  <div class="form-group">
                    <label class="control-label">Child Name</label><span class="error-star" style="color:red;">*</span>
                    <input class="form-control" type="text" id="child_name" value="{{$enrollment[0]['child_name'] }}" name="child_name" autocomplete="off" disabled>
                  </div>
                </div>

              </div>
            </div>
          </div>
        </div>
      </div>

      <h5 class="text-center paymentdetails" style="color:darkblue">Payment Details</h5>

      <div class="row">
        <div class="col-12" style="padding-top: 12px;">
          <div class="card">
            <div class="card-body">
              <div class="row">
                <div class="col-md-3">
                  <div class="form-group">
                    <label class="control-label">Initiated By</label><span class="error-star" style="color:red;">*</span>
                    <input class="form-control" type="text" id="initiated_by" name="initiated_by" value=" {{$enrollment[0]['initiated_by'] }}" autocomplete="off" disabled>
                  </div>
                </div>

                <div class="col-md-3">
                  <div class="form-group">
                    <label class="control-label">Initiated To</label><span class="error-star" style="color:red;">*</span>
                    <input class="form-control" type="text" id="initiated_to" name="initiated_to" value=" {{$enrollment[0]['initiated_to'] }}" autocomplete="off" disabled>
                  </div>
                </div>

                <div class="col-md-3">
                  <div class="form-group">
                    <label class="control-label">Payment Fee(INR)</label><span class="error-star" style="color:red;">*</span>
                    <input class="form-control" id="payment_amount" name="payment_amount" value="{{$enrollment[0]['payment_amount'] }}" disabled autocomplete="off">
                  </div>
                </div>

                <div class="col-md-3">
                  <div class="form-group">
                    <label class="control-label">Status</label>
                    <input class="form-control" type="text" id="payment_status" name="payment_status" value="{{$enrollment[0]['payment_status'] }}" disabled autocomplete="off">
                  </div>
                </div>

              </div>

              <div class="form-notes" style="display: none;">
                <label class="control-notes">Info</label>
                <textarea class="form-control form-note" type="textarea" id="payment_process_description" name="payment_process_description" value="{{$enrollment[0]['payment_process_description'] }}" readonly>{{$enrollment[0]['payment_process_description'] }}</textarea>
              </div>

            </div>
          </div>
        </div>
      </div>

      @include('razorpayView')
    </div>
  </section>
</div>
<script>
  $('.razorpay-payment-button').click(function() {
    $(".loader").show();
  });
</script>
@endsection