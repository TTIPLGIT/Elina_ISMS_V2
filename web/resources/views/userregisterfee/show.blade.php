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

    .form-note {
      width: 100% !important;
      padding: 0 10px !important;
    }
    .control-notes {
      font-size: 14px !important;
    }
  }

  /* ==========================================
     TABLET-ONLY (769px - 1024px) – adjust column widths
     ========================================== */
  @media (min-width: 769px) and (max-width: 1024px) {
    /* For the top section (child details) – make them 2 columns */
    .col-md-4 {
      flex: 0 0 50% !important;
      max-width: 50% !important;
    }

    /* For the payment details – give more room to Initiated By & Initiated To */
    .col-md-3 {
      flex: 0 0 33.333% !important;
      max-width: 33.333% !important;
    }

    /* Make Initiated By and Initiated To wider – 35% each */
    .card .row .col-md-3:nth-child(1),
    .card .row .col-md-3:nth-child(2) {
      flex: 0 0 35% !important;
      max-width: 35% !important;
    }

    /* Payment Date – narrower (30%) */
    .card .row .col-md-3:nth-child(3) {
      flex: 0 0 30% !important;
      max-width: 30% !important;
    }

    /* All other columns (Payment Fee, Status, Reference ID, Attach File) – 33.333% */
    .card .row .col-md-3:not(:nth-child(1)):not(:nth-child(2)):not(:nth-child(3)) {
      flex: 0 0 33.333% !important;
      max-width: 33.333% !important;
    }

    .form-group label {
      font-size: 13px !important;
    }
    .form-control {
      font-size: 13px !important;
      height: 36px !important;
    }
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
                      <input class="form-control" type="text" id="enrollment_child_num" name="enrollment_child_num" value="{{ $row['enrollment_child_num'] }}" disabled autocomplete="off">
                    </div>
                  </div>

                  <div class="col-md-4">
                    <div class="form-group">
                      <label class="control-label">Child ID</label>
                      <input class="form-control" type="text" id="child_id" name="child_id" value="{{ $row['child_id']}}" disabled autocomplete="off">
                    </div>
                  </div>

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
        </div>

        <h5 class="text-center paymentdetails" style="color:darkblue">Payment Details</h5>

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
                  <div class="col-md-3">
                    <div class="form-group">
                      <label class="control-label required">Payment Date</label>
                      <div class="inner-addon right-addon">
                        <i class="glyphicon fas fa-calendar-alt"></i>
                        <input type='text' class="form-control payment_date default" id='payment_date' name="payment_date" value="{{ $row['payment_date']}}" title="Payment Date" disabled autocomplete="off">
                      </div>
                    </div>
                  </div>
                  @else
                  <div class="col-md-3">
                    <div class="form-group">
                      <label class="control-label required">Payment Date</label>
                      <div class="inner-addon right-addon">
                        <i class="glyphicon fas fa-calendar-alt"></i>
                        @php
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

                  <div class="col-md-3">
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

              </div>
            </div>
          </div>
        </div>

        <div class="col-md-12 text-center" style="padding-top: 1rem;">
          <a type="button" class="btn btn-labeled back-btn" title="Cancel" href="{{ route('userregisterfee.index') }}" style="color:white !important">
            <span class="btn-label" style="font-size:13px !important;"><i class="fa fa-times"></i></span> Cancel</a>
        </div>

      </form>
      @endforeach
    </div>
  </section>
</div>
@endsection