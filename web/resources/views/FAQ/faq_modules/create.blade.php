@extends('layouts.adminnav')

@section('content')
<style>
    /* ========== MOBILE RESPONSIVE STYLES (only for screens ≤ 768px) ========== */
    @media (max-width: 768px) {
        .main-content {
            padding: 5px !important;
            margin-top: 60px !important;
        }

        .section-body {
            padding: 0 5px !important;
        }

        h5 {
            font-size: 16px !important;
            margin-top: 10px !important;
            font-weight: bold !important;
            text-align: center !important; /* center heading on mobile */
        }

        .card {
            margin: 5px 0 !important;
            border-radius: 6px !important;
        }

        .card-body {
            padding: 12px !important;
        }

        .form-group {
            margin-bottom: 12px !important;
        }

        .control-label,
        label {
            font-size: 12px !important;
            font-weight: 600 !important;
            margin-bottom: 4px !important;
        }

        .form-control {
            height: 36px !important;
            font-size: 13px !important;
            padding: 6px 10px !important;
        }

        .col-md-6 {
            width: 100% !important;
            max-width: 100% !important;
            flex: 0 0 100% !important;
            padding-left: 5px !important;
            padding-right: 5px !important;
        }

        .row {
            margin-left: 0 !important;
            margin-right: 0 !important;
        }

        .row .col-md-12 {
            padding-left: 5px !important;
            padding-right: 5px !important;
        }

        /* === BUTTONS: keep them in the SAME LINE (inline) === */
        .btn {
            display: inline-block !important;
            width: auto !important;
            min-width: 80px !important;
            padding: 6px 12px !important;
            font-size: 12px !important;
            margin: 4px 6px !important;
            border-radius: 4px !important;
            white-space: nowrap !important;
        }

        .btn-space {
            margin: 4px 6px !important;
        }

        /* Ensure buttons stay on same line by preventing wrapping */
        .text-center {
            padding: 0 5px !important;
            white-space: nowrap !important;
            overflow-x: auto !important;
            -webkit-overflow-scrolling: touch !important;
        }

        /* If the container still wraps, allow horizontal scroll */
        .text-center .btn {
            flex-shrink: 0 !important;
        }
    }

    /* === HEADING CENTERED ON ALL SCREENS === */
    h5 {
        text-align: center !important;
        color: darkblue !important;
    }
</style>

<div class="main-content">
  <!-- Main Content -->
  <section class="section">   
    <div class="section-body mt-1">
      <h5>FAQ Modules Creation</h5>
      <div class="row">
        <div class="col-12">
          <div class="card">
            <div class="card-body">
              <form name="uam_modules" id="uam_modules" onsubmit="return validateForm()" method="POST" action="{{ route('faqmodules.store') }}">
                @csrf
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label class="control-label"> FAQ Module Name <span style="color: red;font-size: 16px;">*</span></label>
                      <input class="form-control" type="text" id="module_name" name="module_name" style="background-color: #ffffff !important;" placeholder="Enter Module Name" autocomplete="off">
                    </div>
                  </div>
                </div>

                <div class="row text-center">
                  <div class="col-md-12">
                    <button type="button" class="btn btn-success btn-space" onclick="save()" id="savebutton">Save</button>
                    <button class="btn btn-primary" type="reset"><i class="fa fa-undo"></i> Undo </button>&nbsp;
                    <a class="btn btn-danger" href="{{ route('faqmodules.index') }}"><i class="fa fa-times" aria-hidden="true"></i> Cancel </a>
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
    return /^\d*\.?\d*$/.test(value); // Allow digits and '.' only, using a RegExp
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