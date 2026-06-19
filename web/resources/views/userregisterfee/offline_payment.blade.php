@extends('layouts.adminnav')

@section('content')
<style>
  .paymentdetails {
    color: darkblue;
    padding-top: 1rem;
    margin: auto;
    justify-content: center;
  }

  /* ==========================================
     BREADCRUMB – KEEP ON ONE LINE
     ========================================== */
  .breadcrumb {
    display: flex !important;
    flex-wrap: nowrap !important;
    overflow-x: auto !important;
    white-space: nowrap !important;
    -webkit-overflow-scrolling: touch;
    padding: 8px 15px;
    margin-bottom: 10px;
  }
  .breadcrumb-item + .breadcrumb-item {
    padding-left: 0.5rem;
  }
  .breadcrumb-item + .breadcrumb-item::before {
    content: "/";
    padding-right: 0.5rem;
  }

  /* ==========================================
     MOBILE RESPONSIVE – FORM PAGES
     ========================================== */
  @media (max-width: 768px) {
    .main-content,
    .card,
    .card-body,
    .section-body {
      padding-left: 10px !important;
      padding-right: 10px !important;
    }

    .row {
      margin-left: 0 !important;
      margin-right: 0 !important;
    }

    [class*="col-"] {
      padding-left: 5px !important;
      padding-right: 5px !important;
      flex: 0 0 100% !important;
      max-width: 100% !important;
    }

    .form-group {
      margin-bottom: 15px !important;
    }

    .form-group label {
      display: block !important;
      width: 100% !important;
      text-align: left !important;
      margin-bottom: 5px !important;
      font-weight: 600 !important;
    }

    .form-control,
    .form-control[readonly] {
      width: 100% !important;
      height: 40px !important;
      font-size: 14px !important;
    }

    select.form-control {
      height: 40px !important;
    }

    /* BUTTONS – INLINE ON MOBILE */
    .row.text-center .col-md-12,
    .col-md-12.text-center {
      display: flex !important;
      flex-wrap: wrap !important;
      justify-content: center !important;
      gap: 6px !important;
    }

    .row.text-center .col-md-12 .btn,
    .col-md-12.text-center .btn {
      width: auto !important;
      margin: 2px !important;
      padding: 6px 12px !important;
      font-size: 14px !important;
      white-space: nowrap !important;
    }

    h5 {
      font-size: 20px !important;
    }

    /* File input – adjust for mobile */
    input[type="file"] {
      height: 40px !important;
      font-size: 13px !important;
      padding: 4px !important;
    }
  }
</style>

<div class="main-content">
  <section class="section">
    {{ Breadcrumbs::render('userregisterfee.offline_payment',$rows[0]['payment_status_id']) }}
    <div class="section-body mt-1">
      <h5 class="text-center" style="color:darkblue">{{$rows[0]['payment_for']}} Details</h5>
      @foreach($rows as $key=>$row)
      <form action="{{route('userregisterfee.completepayment')}}" method="POST" id="userregisterfee" enctype="multipart/form-data">
        @csrf
        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-body">
                <div class="row">
                  <div class="col-md-4">
                    <div class="form-group">
                      <label class="control-label">Enrollment ID</label>
                      <input class="form-control" type="text" id="enrollment_child_num" name="enrollment_child_num" value="{{ $row['enrollment_child_num'] }}" readonly autocomplete="off">
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
                      <input class="form-control" type="text" id="child_name" name="child_name" value="{{ $row['child_name']}}" readonly autocomplete="off">
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group">
                      <label class="control-label">Initiated To</label>
                      <input class="form-control" type="text" id="initiated_to" name="initiated_to" value="{{ $row['initiated_to']}}" readonly autocomplete="off">
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group">
                      <label class="control-label">Payment Fee</label>
                      <input class="form-control" type="text" id="payment_amount" name="payment_amount" value="{{ $row['payment_amount']}}" readonly autocomplete="off">
                    </div>
                  </div>
                  <br>
                  <div class="col-md-4">
                    <div class="form-group">
                      <label class="control-label">Status</label>
                      <input class="form-control" type="text" id="payment_status" name="payment_status" value="{{ $row['payment_status']}}" disabled autocomplete="off">
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
                    <input type="hidden" name="payment_status_id" id="payment_status_id" value="{{$row['payment_status_id']}}">
                    <input type="hidden" name="father" id="father" value="{{$row['father']}}">
                    <input type="hidden" name="mother" id="mother" value="{{$row['mother']}}">
                    <input type="hidden" name="payment_for" id="payment_for" value="{{$row['payment_for']}}">

                    <!-- <div class="col-md-4">
                      <div class="form-group">
                        <label class="control-label">Invoice number</label>
                        <input class="form-control default" type="text" id="invoice_number" name="invoice_number" disabled autocomplete="off">
                      </div>
                    </div> -->
                    <div class="col-md-4">
                      <div class="form-group">
                        <label class="control-label required">Payment Date</label>
                        <div class="inner-addon right-addon">
                          <i class="glyphicon fas fa-calendar-alt"></i>
                          <input type='text' class="form-control payment_date default" id='payment_date' name="payment_date" title="Payment Date" placeholder="DD/MM/YYYY" autocomplete="off">
                        </div>
                      </div>
                    </div>
                    <div class="col-md-4">
                      <div class="form-group">
                        <label class="control-label required">Payment Mode</label>
                        <select class="form-control default" id="payment_mode" name="payment_mode">
                          <option value="Cash">Cash</option>
                          <option value="Bank Transfer">Bank Transfer</option>
                          <option value="Cheque">Cheque</option>
                          <!-- <option value="">Cash</option> -->
                        </select>
                      </div>
                    </div>
                    <div class="col-md-4">
                      <div class="form-group">
                        <label class="control-label">Reference ID</label>
                        <input class="form-control default" type="text" id="reference_id" name="reference_id" autocomplete="off">
                      </div>
                    </div>
                    <div class="col-md-4">
                      <div class="form-group">
                        <label class="control-label">Attach File</label>
                        <input class="form-control default" type="file" id="file" name="file">
                      </div>
                      <!-- <a href="#" id="viewLink" class="btn btn-info" title="View Attachment" style="display:none;" target="_blank"><i class="fa fa-eye" style="color:white!important"></i> View</a> -->
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-md-12 text-center" style="padding-top: 1rem;">
            <a type="button" onclick="completePayment()" id="submitbutton" class="btn btn-labeled btn-succes" title="Complete Payment" style="background: green !important; border-color:green !important; color:white !important">
              <span class="btn-label" style="font-size:13px !important;"><i class="fa fa-check"></i></span> Complete Payment </a>
            <a type="button" class="btn btn-labeled back-btn" title="Back" href="{{ route('userregisterfee.index') }}" style="color:white !important">
              <span class="btn-label" style="font-size:13px !important;"><i class="fa fa-arrow-left"></i></span> Back</a>
          </div>
        </div>
      </form>
    </div>
    @endforeach
  </section>
</div>
<script>
  $(function() {
    $('.payment_date').datepicker({
      dateFormat: 'dd/mm/yy',
      // minDate: 0,
      maxDate: 0,
      changeMonth: true,
      changeYear: true,
    });
  });
</script>
<script>
  const fileInput = document.getElementById('file');
  const viewLink = document.getElementById('viewLink');

  fileInput.addEventListener('change', () => {
    const file = fileInput.files[0];
    if (file) {
      viewLink.setAttribute('href', URL.createObjectURL(file));
      viewLink.style.display = 'inline-block';
    } else {
      viewLink.style.display = 'none';
    }
  });

  function completePayment() {
    var payment_date = document.getElementById('payment_date').value;

    const [day, month, year] = payment_date.split('/').map(Number);
    const date = new Date(year, month - 1, day);
    const today = new Date();
    today.setHours(0, 0, 0, 0);
    if (date > today) {
      Swal.fire("Please Select an valid Payment Date. Payment date cannot be in the future.", "", "error");
      return false;
    }
    
    if (payment_date == '') {
      Swal.fire("Please Select Payment Date", "", "error");
      return false;
    }

    var payment_mode = document.getElementById('payment_mode').value;
    if (payment_mode == '') {
      Swal.fire("Please Select Payment Mode", "", "error");
      return false;
    }
    $('.loader').show();
    document.getElementById('userregisterfee').submit();
  }
</script>
@endsection