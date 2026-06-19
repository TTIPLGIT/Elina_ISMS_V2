@extends('layouts.adminnav')

@section('content')
<style>
  /* ==========================================
     MOBILE RESPONSIVE – FORM PAGES
     ========================================== */
  @media (max-width: 768px) {

    /* Containers */
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

    /* Form groups – stack labels and inputs */
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

    /* BUTTONS – INLINE ON MOBILE (same line, wrap if needed) */
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

    /* Heading */
    h5 {
      font-size: 20px !important;
    }
  }
</style>

<div class="main-content">
  <!-- Main Content -->
  <section class="section">
    {{ Breadcrumbs::render('uam_modules.create') }}

    <div class="section-body mt-1">
      <!-- HEADING CENTERED ON ALL SCREENS -->
      <h5 class="text-center" style="color:darkblue;">Modules Create</h5>

      <div class="row">
        <div class="col-12">
          <div class="card">
            <div class="card-body">
              <form name="uam_modules" id="uam_modules" onsubmit="return validateForm()" method="POST" action="{{ route('uam_modules.store') }}">
                @csrf
                <div class="row">

                  <div class="col-md-6">
                    <div class="form-group">
                      <label class="control-label">Module Category <span style="color: red;font-size: 16px;">*</span></label>
                      <select class="form-control" name="module_type" id="module_type" style="background-color: #ffffff !important;" onChange="typeChange()">
                        <option value="01">Module</option>
                        <option value="02">Sub Module</option>
                      </select>
                    </div>
                  </div>

                  <div class="col-md-6" id="module">
                    <div class="form-group">
                      <label class="control-label">Parent Module Name</label>
                      <select class="form-control" name="parent_module_id" style="background-color: #ffffff !important;">
                        <option value="1">Home</option>
                      </select>
                    </div>
                  </div>

                  <div class="col-md-6" id="sub_module" style="display: none;">
                    <div class="form-group">
                      <label class="control-label">Parent Module Name</label>
                      <select class="form-control" name="sub_module_id" style="background-color: #ffffff !important;">
                        <option value="">Select Parent Module</option>
                        @foreach($rows as $key=>$row)
                        <option value="{{ $row['module_id'] }}">{{ $row['module_name'] }}</option>
                        @endforeach
                      </select>
                    </div>
                  </div>

                  <div class="col-md-6">
                    <div class="form-group">
                      <label class="control-label">Module Name <span style="color: red;font-size: 16px;">*</span></label>
                      <input class="form-control" type="text" id="module_name" name="module_name" style="background-color: #ffffff !important;" placeholder="Enter Module Name" autocomplete="off">
                    </div>
                  </div>

                  <div class="col-md-6">
                    <div class="form-group">
                      <label class="control-label">Icon Class Name <span style="color: red;font-size: 16px;">*</span></label>
                      <input class="form-control" type="text" id="class_name" style="background-color: #ffffff !important;" name="class_name" placeholder="Enter Class Name" autocomplete="off">
                    </div>
                  </div>

                  <div class="col-md-6">
                    <div class="form-group">
                      <label class="control-label">Display Order </label>
                      <input class="form-control" type="text" id="display_order" style="background-color: #ffffff !important;" name="display_order" placeholder="Enter Display Order" autocomplete="off">
                    </div>
                  </div>

                </div>

                <!-- BUTTON ROW – inline on mobile -->
                <div class="row text-center">
                  <div class="col-md-12">
                    <button type="button" class="btn btn-success btn-space" onclick="save()" id="savebutton">Save</button>
                    <button class="btn btn-primary" type="reset"><i class="fa fa-undo"></i> Undo</button>
                    <a class="btn btn-danger" href="{{ route('uam_modules.index') }}"><i class="fa fa-times" aria-hidden="true"></i> Cancel</a>
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

<!-- Your existing scripts (unchanged) -->
<script src="https://cdn.jsdelivr.net/jquery.validation/1.15.1/jquery.validate.min.js"></script>
<script type="text/javascript">
  function typeChange() {
    var module_type = $('#module_type').val();

    if (module_type == 02) {
      $('#sub_module').show();
      $('#module').hide();
    } else {
      $('#sub_module').hide();
      $('#module').show();
    }
  }

  function setInputFilter(textbox, inputFilter) {
    ["input", "keydown", "keyup", "mousedown", "mouseup", "select", "contextmenu", "drop"].forEach(function(event) {
      textbox.addEventListener(event, function() {
        if (inputFilter(this.value)) {
          this.oldValue = this.value;
          this.oldSelectionStart = this.selectionStart;
          this.oldSelectionEnd = this.selectionEnd;
        } else if (this.hasOwnProperty("oldValue")) {
          this.value = this.oldValue;
          this.setSelectionRange(this.oldSelectionStart, this.oldSelectionEnd);
        } else {
          this.value = "";
        }
      });
    });
  }

  setInputFilter(document.getElementById("display_order"), function(value) {
    return /^\d*\.?\d*$/.test(value);
  });

  $("#module_name").keypress(function(event) {
    var inputValue = event.charCode;
    if (!(inputValue >= 65 && inputValue <= 120) && (inputValue != 32 && inputValue != 0)) {
      event.preventDefault();
    }
  });
</script>

@if (session('fail'))
<input type="hidden" name="session_data" id="session_data" class="session_data" value="{{ session('fail') }}">
<script type="text/javascript">
  window.onload = function() {
    var message = $('#session_data').val();
    bootbox.alert({
      title: "Error",
      centerVertical: true,
      message: message
    });
  }
</script>
@endif

<script>
  function save() {

    var module_type = $('#module_type').val();

    if (module_type == 02) {
      var parent_module = $("select[name='sub_module_id']").val();
      if (parent_module == '') {
        swal("Please Select Parent Module ", "", "error");
        return false;
      }
    } else {
      var parent_module = $("select[name='parent_module_id']").val();
      if (parent_module == '') {
        swal("Please Select Parent Module ", "", "error");
        return false;
      }
    }

    var parent_module = $("select[name='module_type']").val();
    if (parent_module == '') {
      swal("Please Select Module Category", "", "error");
      return false;
    }

    var module_name = $('#module_name').val();
    if (module_name == '') {
      swal("Please Enter Module Name ", "", "error");
      return false;
    }

    var class_name = $('#class_name').val();
    if (class_name == '') {
      swal("Please Enter class Name ", "", "error");
      return false;
    }

    document.getElementById('uam_modules').submit();
  }
</script>
@endsection