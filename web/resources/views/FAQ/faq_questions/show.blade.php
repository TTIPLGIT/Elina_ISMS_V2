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
            text-align: center !important;
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

        textarea.form-control {
            height: 80px !important;
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

        /* === BUTTON: keep it centered and inline === */
        .btn {
            display: inline-block !important;
            width: auto !important;
            min-width: 80px !important;
            padding: 6px 16px !important;
            font-size: 12px !important;
            margin: 4px 6px !important;
            border-radius: 4px !important;
            white-space: nowrap !important;
        }

        .text-center {
            padding: 0 5px !important;
            text-align: center !important;
        }
    }

    /* === HEADING CENTERED ON ALL SCREENS === */
    h5 {
        text-align: center !important;
        color: darkblue !important;
    }
</style>

<div class="row">
  <div class="main-content">

    <!-- Main Content -->
    <section class="section">

    {{ Breadcrumbs::render('FAQ_questions.show',$rows[0]['id']) }}

      <div class="section-body mt-1">
        <h5> FAQ Module Show</h5>
        <div class="row">

          <div class="col-12">

            <div class="card">
              <div class="card-body">
                <form class="form-horizontal" method="post" name="uam_modules" action="{{ route('FAQ_questions.update_data') }}">

                  @csrf
                  <div class="row">
                    <div class="col-md-6">
                      <div class="form-group">
                        <label class="control-label">FAQ Module Name</label>
                        <select class="form-control" name="module_id" disabled="">
                          <option value="">--- Select FAQ Module Name ---</option>
                          @foreach($rows as $key=>$row)
                          <option value="{{ $row['id'] }}" {{ $row['id'] ==  $one_row[0]['module_id'] ? 'selected':'' }}>{{ $row['module_name'] }}</option>
                          @endforeach
                        </select>
                        @error('module_id')
                        <div class="error">{{ $message }}</div>
                        @enderror
                      </div>
                    </div>


                    <div class="col-md-6">
                      <div class="form-group">
                        <label class="control-label">Question <span style="color: red;font-size: 16px;">*</span></label>
                        <input class="form-control" type="text" id="question" name="question" placeholder="Enter Question" value="{{ $one_row[0]['question'] }}" disabled="">
                      </div>
                      @error('question')
                      <div class="error">{{ $message }}</div>
                      @enderror
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                        <label class="control-label">Answer</label>

                        <textarea class="form-control" type="text" id="answer" name="answer" disabled="">{{ $one_row[0]['answer'] }}</textarea>
                      </div>
                      @error('answer')
                      <div class="error">{{ $message }}</div>
                      @enderror
                    </div>

                    <input class="form-control" type="hidden" id="que_id" name="que_id" placeholder="Enter Module Name" value="{{ $one_row[0]['id'] }}">
                  </div>

                  <div class="row text-center">
                    <div class="col-md-12">
                      <a class="btn btn-danger" href="{{ route('FAQ_questions.index') }}"><i class="fa fa-times" aria-hidden="true"></i> Cancel </a>
                    </div>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
    </section>
  </div>
</div>


<script src="https://cdn.jsdelivr.net/jquery.validation/1.15.1/jquery.validate.min.js"></script>
<script type="text/javascript">
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

  // Wait for the DOM to be ready
  $(function() {
    // Initialize form validation on the registration form.
    // It has the name attribute "registration"
    $("form[name='uam_modules']").validate({
      // Specify validation rules
      rules: {

        module_name: {
          required: true,
        },

      },
      // Specify validation error messages
      messages: {

        module_name: {
          required: "Please provide a module name",
        },

      },
      // Make sure the form is submitted to the destination defined
      // in the "action" attribute of the form when valid
      submitHandler: function(form) {
        form.submit();
      }
    });
  });
</script>

@endsection