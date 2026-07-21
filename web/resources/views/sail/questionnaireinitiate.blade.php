@extends('layouts.adminnav')

@section('content')
<style>
  #frname {
    color: red;
  }

  .form-control {
    background-color: #ffffff !important;
  }

  .is-coordinate {
    justify-content: center;
  }

  .centerid {
    width: 100%;
    text-align: center;
  }

  /* Mobile Responsive Styles */
  @media (max-width: 767.98px) {
    .main-content {
      padding-left: 10px !important;
      padding-right: 10px !important;
    }

    .section-body {
      margin-top: 10px !important;
    }

    .breadcrumb {
      font-size: 11px !important;
      padding: 5px 10px !important;
    }

    .breadcrumb-item {
      font-size: 11px !important;
    }

    .is-coordinate .col-md-4 {
      margin-bottom: 10px;
    }

    .card-body {
      padding: 15px !important;
    }

    .form-group label {
      font-size: 13px !important;
    }

    .form-control {
      font-size: 13px !important;
      height: 38px !important;
    }

    h5.text-center {
      font-size: 16px !important;
      margin-bottom: 15px !important;
    }

    #invite .col-md-6 {
      margin-bottom: 15px;
    }

    .btn-labeled {
      width: auto !important;
      min-width: 110px;
      display: inline-block !important;
      margin-bottom: 10px;
      text-align: center;
      padding: 6px 12px !important;
      font-size: 13px !important;
    }

    .btn-labeled .btn-label {
      position: relative;
      left: 0;
      display: inline-block;
      margin-right: 5px;
      font-size: 12px !important;
      padding: 0 !important;
      background: transparent !important;
      border: none !important;
    }
    
    #invite .col-md-12.text-center {
        display: flex;
        justify-content: center;
        gap: 10px;
    }
    
    .tile-footer-button-alignment {
        flex-direction: column;
    }
  }

  /* ==========================================
     TABLET-ONLY (769px - 1024px)
     ========================================== */
  @media (min-width: 769px) and (max-width: 1024px) {
    /* Top section – two columns */
    .is-coordinate .col-md-4 {
      flex: 0 0 50% !important;
      max-width: 50% !important;
      width: 50% !important;
    }

    /* Widen the enrollment dropdown */
    .is-coordinate .col-md-4 select.form-control {
      width: 100% !important;
      overflow: hidden !important;
      text-overflow: ellipsis !important;
      white-space: nowrap !important;
    }

    /* ====== Questionnaire + Status row – clean alignment ====== */
    .card .form-group.row:has(#questionnaire_id) {
      display: flex !important;
      flex-wrap: nowrap !important;
      align-items: stretch !important;
    }
    .card .form-group.row:has(#questionnaire_id) .col-md-6:first-child {
      flex: 0 0 55% !important;
      max-width: 55% !important;
      width: 55% !important;
      display: flex !important;
      flex-direction: column !important;
      gap: 2px !important;
    }
    .card .form-group.row:has(#questionnaire_id) .col-md-6:first-child label {
      flex: 0 0 auto !important;
      white-space: nowrap !important;
      margin-bottom: 2px !important;
      font-weight: 600 !important;
    }
    .card .form-group.row:has(#questionnaire_id) .col-md-6:first-child select {
      width: 100% !important;
    }

    .card .form-group.row:has(#questionnaire_id) .col-md-6:last-child {
      flex: 0 0 40% !important;
      max-width: 40% !important;
      width: 40% !important;
      margin-left: 5% !important;
      display: flex !important;
      flex-direction: column !important;
    }
    .card .form-group.row:has(#questionnaire_id) .col-md-6:last-child label {
      flex: 0 0 auto !important;
      white-space: nowrap !important;
      margin-bottom: 2px !important;
      text-align: left !important;
      font-weight: 600 !important;
    }
    .card .form-group.row:has(#questionnaire_id) .col-md-6:last-child .form-control {
      width: 100% !important;
    }
    /* Remove the <br> after status label if present */
    .card .form-group.row:has(#questionnaire_id) .col-md-6:last-child br {
      display: none !important;
    }
  }
</style>

<div class="main-content">
  {{ Breadcrumbs::render('ovm.questionnaire.initiate') }}
  <!-- Main Content -->
  <section class="section">
    <div class="section-body mt-1">
      <h5 class="text-center" style="color:darkblue">Parent Feedback Form Initiate</h5>
      <div class="row">
        <div class="col-12">
          <div class="card">
            <div class="card-body">
              <form action="{{ route('sail.store') }}" method="POST" id="enrollement" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="stage" value="ovm">
                <!-- Top row: Enrollment, Child ID, Child Name -->
                <div class="row is-coordinate">
                  <div class="col-md-4">
                    <div class="form-group">
                      <label class="control-label required">Enrollment Number</label>
                      <select class="form-control" id="enrollment_id" name="enrollment_id" onchange="GetChilddetails()">
                        <option value="">Select-Enrollment</option>
                        @foreach($rows['questionnaire_initiation'] as $key=>$row)
                          <option value="{{$row['enrollment_id']}}">{{ $row['enrollment_child_num']}} ( {{$row['child_name']}} )</option>
                        @endforeach
                      </select>
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group">
                      <label class="control-label required">Child ID</label>
                      <input class="form-control" type="text" style="background-color:#E9ECEF !important" id="child_id" name="child_id" placeholder="Child ID" autocomplete="off">
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group">
                      <label class="control-label required">Child Name</label>
                      <input class="form-control" type="text" id="child_name" style="background-color:#E9ECEF !important" name="child_name" oninput="Childname(event)" maxlength="20" value="" placeholder="Enter Name" autocomplete="off">
                    </div>
                  </div>
                </div>
            </div>
          </div>
        </div>
      </div>
      <br>

      <!-- Questionnaire & Status row (two columns) -->
      <div class="row" id="invite">
        <div class="col-12">
          <div class="card">
            <div class="card-body">
              <div class="form-group row">
                <!-- Questionnaire Name (left column) -->
                <div class="col-md-6">
                  <label class="control-label col-form-label">
                    Questionnaire Name<span class="error-star" style="color:red;">*</span>
                  </label>
                  <select class="form-control" id="questionnaire_id" name="questionnaire_id">
                    <option value="">Questionnaire Name</option>
                  </select>
                </div>
                <!-- Status (right column) -->
                <div class="col-md-6">
                  <label class="control-label col-form-label">Status</label>
                  <input class="form-control" type="text" id="payment_status" name="status" value="New" placeholder="New" readonly>
                </div>
              </div>

              <!-- Hidden fields -->
              <input type="hidden" id="paymenttokentime" name="paymenttokentime" value="{{$paymenttokentime[0]['token_expire_time']}}">
              <input type="hidden" id="btn_status" name="btn_status" value="">
              <input type="hidden" id="userID" name="userID" value="">
            </div>
          </div>

          <!-- Buttons -->
          <div class="col-md-12 text-center" style="padding-top: 1rem;">
            <a type="button"
               onclick="buttonAction('Sent', this)"
               id="submitbutton"
               class="btn btn-labeled btn-succes"
               title="Initiate Questionnaire"
               style="background: green !important; border-color:green !important; color:white !important">
                <span class="btn-label" style="font-size:13px !important;">
                    <i class="fa fa-check"></i>
                </span>
                Initiate
            </a>
            <a type="button" class="btn btn-labeled back-btn" title="Back" href="{{ route('ovm.questionnaire') }}" style="color:white !important">
              <span class="btn-label" style="font-size:13px !important;"><i class="fa fa-arrow-left"></i></span> Back
            </a>
          </div>
        </div>
      </div>

      </form>
    </div>
  </section>
</div>

<!-- ======================== JAVASCRIPT ======================== -->
<script>
  function newmeeting() {
    document.getElementById('invite').style.display = "block";
  }
</script>

<script>
  function Childname(event) {
    let value = event.target.value || '';
    value = value.replace(/[^a-z A-Z ]/, '', );
    event.target.value = value;
  }
</script>

<script type="text/javascript">
  $.ajaxSetup({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  });

  function GetChilddetails() {
    var enrollment_id = $("select[name='enrollment_id']").val();
    if (enrollment_id != "") {
      $.ajax({
        url: '{{ url('/sail/getchild/enrollment') }}',
        type: 'POST',
        data: {
          'enrollment_id': enrollment_id,
          _token: '{{csrf_token()}}'
        }
      }).done(function(data) {
        console.log(data);
        if (data != '[]') {
          var optionsdata = "";
          document.getElementById('child_id').value = data[0].child_id;
          document.getElementById('child_name').value = data[0].child_name;
          document.getElementById('userID').value = data[0].user_id;
          $.ajax({
            url: '{{ url('/sail/GetQuestionnaire') }}',
            type: "POST",
            dataType: "json",
            data: {
              enrollment_id: enrollment_id,
              type : '1',
              stage : 'OVM',
              _token: '{{csrf_token()}}'
            },
            success: function(data) {
              console.log(data);
              if (data != '[]') {
                var user_select = data.rows;
                var optionsdata = "<option value=''>Select Questionnaire</option>";
                var ddd = "";
                for (var i = 0; i < user_select.length; i++) {
                  var questionnaire_name = user_select[i]['questionnaire_name'];
                  var questionnaire_id = user_select[i]['questionnaire_id'];
                  ddd += "<option value=" + questionnaire_id + ">" + questionnaire_name + "</option>";
                }
                var stageoption = optionsdata.concat(ddd);
                $('#questionnaire_id').html(stageoption);
              } else {
                var stageoption = "<option value=''>No Questionnaire Found</option>";
                $('#questionnaire_id').html(stageoption);
              }
            }
          });
        } else {
          document.getElementById('child_name');
          var ddd = '<option value="child_name">Select Enrollment_child_num</option>';
          $('#child_name').html(ddd);
        }
      })
    } else {
      document.getElementById('initiated_by');
      var ddd = '<option value="initiated_by">Select Enrollment_child_num</option>';
      $('#initiated_by').html(ddd);
    }
  };
</script>

<script>
  function buttonAction(status, btn) {
    var enrollment_id = $('#enrollment_id').val();
    if (enrollment_id == '') {
        Swal.fire("Please Select Enrollment Number", "", "error");
        return false;
    }

    var questionnaire_id = $('#questionnaire_id').val();
    if (questionnaire_id == '') {
        Swal.fire("Please Select Questionnaire Name", "", "error");
        return false;
    }

    // Prevent double click
    btn.style.pointerEvents = "none";
    btn.style.opacity = "0.6";

    btn.innerHTML =
        '<span class="btn-label"><i class="fa fa-spinner fa-spin"></i></span> Processing...';

    document.getElementById('btn_status').value = status;

    // Submit form
    document.getElementById('enrollement').submit();
  }
</script>

@endsection