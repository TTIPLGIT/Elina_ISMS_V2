@extends('layouts.adminnav')
@section('content')

<style>
  .error {
    color: red;
    size: 80%;
  }
  .hidden {
    display: none;
  }

  .toggle-password {
    float: right;
    cursor: pointer;
    margin-right: 10px;
    margin-top: -25px;
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

    /* BUTTONS – INLINE ON MOBILE */
    .row.text-center .col-md-12 {
      display: flex !important;
      flex-wrap: wrap !important;
      justify-content: center !important;
      gap: 6px !important;
    }

    .row.text-center .col-md-12 .btn {
      width: auto !important;
      margin: 2px !important;
      padding: 6px 12px !important;
      font-size: 14px !important;
      white-space: nowrap !important;
    }

    h5 {
      font-size: 20px !important;
    }

    /* Password toggle icon – adjust position for mobile inputs */
    .toggle-password {
      margin-top: -32px;  /* align with the 40px input height */
      margin-right: 12px;
      font-size: 18px;
    }

    /* Notes paragraph – smaller font */
    .form-group p {
      font-size: 12px !important;
      margin-top: 4px !important;
    }
  }
</style>

<div class="main-content">
    <!-- Main Content -->
    <section class="section">
      {{ Breadcrumbs::render('user.change_password_admin',$id) }}

      <div class="section-body mt-1">
        <h5 class="text-center" style="color:darkblue;">Change Password</h5>
        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-body">

                <form class="form-horizontal" name="myForm" method="POST" action="{{ url('change_password_admin') }}" enctype="multipart/form-data">
                  @csrf
                  <div class="row">

                    <input class="form-control" type="hidden" id="user_id" name="user_id" value="{{ $id }}">

                    <div class="col-md-6">
                      <div class="form-group">
                        <label class="control-label">New Password <span style="color: red;font-size: 16px;">*</span></label>
                        <input type="password" id="new_password" name="new_password" placeholder="Enter New Password" class="form-control">
                        <i class="toggle-password fa fa-fw fa-eye-slash"></i>
                      </div>

                      <label style="color:#f30202!important">Notes</label>
                      <p> Validation Format  - at least 1 uppercase character (A-Z),
                        at least 1 lowercase character (a-z),
                        at least 1 digit (0-9),
                        at least 1 special character (punctuation)</p>
                      @error('new_password')
                      <div class="error">{{ $message }}</div>
                      @enderror
                    </div>

                    <div class="col-md-6">
                      <div class="form-group">
                        <label class="control-label">Confirm Password <span style="color: red;font-size: 16px;">*</span></label>
                        <input type="password" id="confirm_password" name="confirm_password" placeholder="Enter Confirm Password" class="form-control">
                        <i class="toggle-password fa fa-fw fa-eye-slash"></i>
                        @error('confirm_password')
                        <div class="error">{{ $message }}</div>
                        @enderror
                      </div>
                    </div>

                  </div>

                  <div class="row text-center">
                    <div class="col-md-12">
                      <button class="btn btn-success" type="submit"><i class="fa fa-check"></i> Update </button>&nbsp;
                      <button class="btn btn-primary" type="reset"><i class="fa fa-undo"></i> Reset </button>&nbsp;
                      <a class="btn btn-danger" href="{{ route('user.index') }}"><i class="fa fa-times" aria-hidden="true"></i> Cancel </a>&nbsp;
                    </div>
                  </div>

                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
</div>

<script type="text/javascript">
  $(".toggle-password").click(function() {
    $(this).toggleClass("fa-eye fa-eye-slash");
    input = $(this).parent().find("input");
    if (input.attr("type") == "password") {
      input.attr("type", "text");
    } else {
      input.attr("type", "password");
    }
  });
</script>

<script src="https://cdn.jsdelivr.net/jquery.validation/1.15.1/jquery.validate.min.js"></script>

@if (session('fail'))
<input type="hidden" name="session_data" id="session_data" class="session_data" value="{{ session('fail') }}">
<script type="text/javascript">
  window.onload = function() {
    var message = $('#session_data').val();
    bootbox.alert({
      title: "Alert",
      centerVertical: true,
      message: message
    });
  }
</script>
@endif

@endsection