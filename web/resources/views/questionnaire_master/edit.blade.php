@extends('layouts.adminnav')

@section('content')

<style>
  input[type=checkbox] {
    display: inline-block;
  }

  .no-arrow {
    -moz-appearance: textfield;
  }

  .no-arrow::-webkit-inner-spin-button {
    display: none;
  }

  .no-arrow::-webkit-outer-spin-button,
  .no-arrow::-webkit-inner-spin-button {
    -webkit-appearance: none;
    margin: 0;
  }

  .nav-tabs {
    background-color: #0068a7 !important;
    border-radius: 29px !important;
    padding: 1px !important;
  }

  .nav-item.active {
    background-color: #0e2381 !important;
    border-radius: 31px !important;
    height: 100% !important;
  }

  .nav-link.active {
    background-color: #0e2381 !important;
    border-radius: 31px !important;
    height: 100% !important;
  }

  .nav-justified {
    display: flex !important;
    align-items: center !important;
  }

  hr {
    border-top: 1px solid #6c757d !important;
  }

  .dateformat {
    height: 41px;
    padding: 8px 10px !important;
    width: 100%;
    border-radius: 5px !important;
    border-color: #bec4d0 !important;
    box-shadow: 2px 2px 4px rgb(0 0 0 / 15%);
    border-style: outset;
  }

  h4 {
    text-align: center;
  }

  .question {
    background-color: white;
    border-radius: 12px !important;
    margin-top: 2rem;
  }

  .question label {
    text-align: center;
  }

  .questionnaire {
    text-align: center;
  }

  .btn-success {
    margin: auto;
  }

  /* ============================================================
     MOBILE RESPONSIVE STYLING – same as create page
     ============================================================ */
  @media (max-width: 768px) {

    /* Reset paddings */
    .main-content,
    .card,
    .card-body,
    .form-group {
      padding-left: 0 !important;
      padding-right: 0 !important;
      margin-left: 0 !important;
      margin-right: 0 !important;
    }

    .row,
    .col-12,
    .col-md-6,
    .col-lg-12 {
      padding-left: 5px !important;
      padding-right: 5px !important;
    }

    .main-content {
      padding-top: 0 !important;
    }

    .breadcrumb {
      font-size: 11px !important;
      margin: 60px 10px 10px 10px !important;
    }

    .card {
      margin-top: 0 !important;
    }

    h4 {
      font-size: 18px !important;
    }

    /* Stack columns */
    .col-md-6 {
      width: 100% !important;
      flex: 0 0 100% !important;
      max-width: 100% !important;
    }

    /* Form inputs full width */
    .form-control,
    .form-control[type="text"],
    textarea.form-control,
    select.form-control {
      font-size: 14px !important;
      height: auto !important;
      padding: 8px 10px !important;
    }

    /* Labels */
    .control-label {
      font-size: 13px !important;
    }

    /* ---- Dynamic fields – keep option+value and X inline ---- */
    .multi-field {
      display: flex !important;
      flex-wrap: nowrap !important;
      align-items: center !important;
      gap: 6px !important;
      margin-bottom: 8px !important;
    }

    /* Option and Value inputs – side by side, shrinkable */
    .multi-field input[name="option[]"],
    .multi-field input[name="value[]"] {
      flex: 1 1 0 !important;
      min-width: 0 !important;
      width: auto !important;
      margin: 0 !important;
    }

    /* Remove button – stays on the same line */
    .multi-field .remove-field {
      flex: 0 0 auto !important;
      padding: 4px 10px !important;
      font-size: 14px !important;
      margin: 0 !important;
      line-height: 1.4 !important;
    }

    /* Quadrant and Category fields – also inline */
    .multi-field input[name="quadrant[]"],
    .multi-field input[name="category[]"] {
      flex: 1 1 0 !important;
      min-width: 0 !important;
      width: auto !important;
      margin: 0 !important;
    }

    /* Buttons for adding fields – full width */
    .add-field {
      width: 100% !important;
      margin-top: 6px !important;
      font-size: 14px !important;
      padding: 8px !important;
    }

    /* ---- Action buttons: keep them in one line (wrap if needed) ---- */
    .row.text-center .col-md-12 {
      display: flex !important;
      flex-wrap: wrap !important;
      justify-content: center !important;
      align-items: center !important;
      gap: 6px !important;
      padding: 0 5px !important;
    }

    .row.text-center .col-md-12 .btn,
    .row.text-center .col-md-12 a.btn {
      flex: 0 0 auto !important;
      width: auto !important;
      min-width: 80px !important;
      margin: 0 !important;
      font-size: 13px !important;
      padding: 6px 12px !important;
    }

    /* Toggle */
    .switch {
      margin: 10px 0 !important;
    }

    /* Reduce spacing */
    .question {
      margin-top: 1rem !important;
      padding: 10px !important;
    }

    .form-group {
      margin-bottom: 12px !important;
    }

    .multi-field-wrapper {
      padding: 0 5px !important;
    }
  }
</style>

<div class="main-content">
  <div class="section-body mt-0">
    <h4> Questionnaire Creation </h4>
    <form class="form-horizontal" name="questionnaire_form" id="questionnaire_form" method="POST" action="{{ route('questionnaire_master.update_data') }}" onsubmit="return validateForm()">
      @csrf
      <div class="card question">
        <div class="row">
          <input class="form-control" type="hidden" id="questionnaire_id" name="questionnaire_id" placeholder="Enter Questionnaire Name" value="{{ $one_row[0]['questionnaire_id'] }}">
          <div class="col-md-6" style="margin: 15px 0px 0px 0px;">
            <div class="form-group">
              <label class="control-label">Questionnaire Name <span style="color: red;font-size: 16px;">*</span></label>
              <input class="form-control" type="text" id="questionnaire_name" name="questionnaire_name" placeholder="Enter Questionnaire Name" value="{{ $one_row[0]['questionnaire_name'] }}">
            </div>
          </div>

          <div class="col-md-6" style="margin: 15px 0px 0px 0px;">
            <div class="form-group questionnaire">
              <label class="control-label required">Questionnaire Type</label>
              <select class="form-control" name="questionnaire_type" id="questionnaire_type">
                <option value="">Select Questionnaire Type</option>
                <option value="OVM" @if ($one_row[0]['questionnaire_type']=='OVM' ) selected @endif>OVM</option>
                <option value="Sail" @if ($one_row[0]['questionnaire_type']=='Sail' ) selected @endif>Sail</option>
                <option value="CoMPASS" @if ($one_row[0]['questionnaire_type']=='CoMPASS' ) selected @endif>CoMPASS</option>
              </select>
            </div>
          </div>

          <div class="col-lg-12">
            <div class="form-group">
              <label class="control-label">Questionnaire Description<span style="color: red;font-size: 16px;">*</span></label>
              <textarea class="form-control" id="questionnaire_description" name="questionnaire_description">{{$one_row[0]['questionnaire_description']}}</textarea>
            </div>
          </div>

          <div class="row text-center" style="margin-top: 10px;">
            <div class="col-md-12">
              <label class='switch' data-bs-toggle='tooltip' data-bs-placement='top' title='Enable / Disable'><input type='checkbox' class='toggle_status' onclick="functiontoggle()" id="is_active" name='is_active' @if($one_row[0]['quadrant_flag']=='1' ) checked @endif><span class='slider round'></span></label>
            </div>
          </div>

        </div>
      </div>
      <div class="card question" style="display: none;" id="multiple_questions">
        <div class="row">
          <div class="col-md-12" style="margin: 15px 0px 0px 0px;">
            <div class="form-group questionnaire">
              <label class="control-label required" >Options & Values</label>
              <div class="multi-field-wrapper">
                <div class="multi-fields">
                  @if(count($options) > 0)
                  @foreach($options as $option)
                  <div class="multi-field" style="display: flex;margin-bottom: 5px;">
                    <input class="form-control" type="text" id="option[]" name="option[]" value="{{$option['option']}}" autocomplete="off" placeholder="Almost Always">
                    <input class="form-control" type="text" id="value[]" name="value[]" value="{{$option['value']}}" style="margin-left:20px;" autocomplete="off" placeholder="5">
                    <button class="remove-field btn btn-danger pull-right" id="remove-f" type='button'>X </button>
                    &nbsp;
                  </div>
                  @endforeach
                  @else
                  <div class="multi-field" style="display: flex;margin-bottom: 5px;">
                    <input class="form-control" type="text" id="option[]" name="option[]" autocomplete="off" placeholder="Almost Always">
                    <input class="form-control" type="text" id="value[]" name="value[]" style="margin-left:20px;" autocomplete="off" placeholder="5">
                    <button class="remove-field btn btn-danger pull-right" id="remove-f" type='button'>X </button>
                    &nbsp;
                  </div>
                  @endif
                </div>
                <button type="button" class="add-field btn btn-success">Add Options</button>
              </div>
            </div>
          </div>
          <div class="w-100"></div>
          <div class="col-6">
            <div class="form-group">
              <label class="required">Quadrant</label>
              <div class="multi-field-wrapper">
                <div class="multi-fields">
                  @if(count($fields) > 0)
                  @foreach($fields as $quadrant)
                  @if($quadrant['type_id'] == '1')
                  <div class="multi-field" style="display: flex;margin-bottom: 5px;">
                    <input type="text" class="form-control" name="quadrant[]" id="quadrant[]" value="{{$quadrant['field']}}" style="margin-right: 10px;">
                    <button class="remove-field btn btn-danger pull-right" id="remove-f" type='button'>X </button>
                    &nbsp;
                  </div>
                  @endif
                  @endforeach
                  @else
                  <div class="multi-field" style="display: flex;margin-bottom: 5px;">
                    <input type="text" class="form-control" name="quadrant[]" id="quadrant[]" style="margin-right: 10px;">
                    <button class="remove-field btn btn-danger pull-right" id="remove-f" type='button'>X </button>
                    &nbsp;
                  </div>
                  @endif
                </div>
                <button type="button" class="add-field btn btn-success">Add Quadrant</button>
              </div>
            </div>
          </div>

          <div class="col-6">
            <div class="form-group">
              <label class="required">Category</label>
              <div class="multi-field-wrapper">
                <div class="multi-fields">
                  @if(count($fields) > 0)
                  @foreach($fields as $category)
                  @if($category['type_id'] == '2')
                  <div class="multi-field" style="display: flex;margin-bottom: 5px;">
                    <input type="text" class="form-control" name="category[]" id="category[]" value="{{$category['field']}}" style="margin-right: 10px;">
                    <button class="remove-field btn btn-danger pull-right" id="remove-f" type='button'>X </button>
                    &nbsp;
                  </div>
                  @endif
                  @endforeach
                  @else
                  <div class="multi-field" style="display: flex;margin-bottom: 5px;">
                    <input type="text" class="form-control" name="category[]" id="category[]" style="margin-right: 10px;">
                    <button class="remove-field btn btn-danger pull-right" id="remove-f" type='button'>X </button>
                    &nbsp;
                  </div>
                  @endif
                </div>
                <button type="button" class="add-field btn btn-success">Add Category</button>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="row text-center" style="margin-top: 10px;">
        <div class="col-md-12">
          <button class="btn btn-success" type="submit"><i class="fa fa-check"></i> Submit</button>&nbsp;
          <button class="btn btn-primary" type="reset"><i class="fa fa-undo"></i> Undo </button>&nbsp;
          <a class="btn btn-danger" href="{{ route('questionnaire_master.index') }}"><i class="fa fa-times" aria-hidden="true"></i> Cancel </a>&nbsp;
        </div>
      </div>
    </form>
  </div>
</div>

<script type="text/javascript">
  function validateForm() {
    // Save TinyMCE content
    if (tinymce) {
      tinymce.triggerSave();
    }

    // Validate Questionnaire Name
    let questionnaire_name = document.getElementById("questionnaire_name").value;
    if (questionnaire_name == '' || questionnaire_name == null) {
      swal.fire("Please Enter Questionnaire Name", "", "error");
      return false;
    }

    // Validate Questionnaire Type
    let questionnaire_type = document.getElementById("questionnaire_type").value;
    if (questionnaire_type == '' || questionnaire_type == null) {
      swal.fire("Please Select Questionnaire Type", "", "error");
      return false;
    }

    // Validate Questionnaire Description
    let questionnaire_description = document.getElementById("questionnaire_description").value;
    if (questionnaire_description == '' || questionnaire_description == null) {
      swal.fire("Please Enter Questionnaire Description", "", "error");
      return false;
    }

    // If toggle is checked, validate all fields
    if ($('#is_active').prop('checked')) {

      // Validate Options & Values
      var optionsValid = true;
      var valuesValid = true;
      var emptyOptionRows = [];
      var emptyValueRows = [];

      $('.multi-fields').first().find('.multi-field').each(function(index) {
        var optionField = $(this).find('input[name="option[]"]');
        var valueField = $(this).find('input[name="value[]"]');

        if (optionField.val().trim() == '') {
          optionsValid = false;
          emptyOptionRows.push(index + 1);
        }

        if (valueField.val().trim() == '') {
          valuesValid = false;
          emptyValueRows.push(index + 1);
        }
      });

      if (!optionsValid) {
        let rowNumbers = emptyOptionRows.join(', ');
        swal.fire({
          title: "Validation Error",
          text: `Please fill in Option for row(s): ${rowNumbers}`,
          icon: "error",
          confirmButtonColor: '#3085d6'
        });
        return false;
      }

      if (!valuesValid) {
        let rowNumbers = emptyValueRows.join(', ');
        swal.fire({
          title: "Validation Error",
          text: `Please fill in Value for row(s): ${rowNumbers}`,
          icon: "error",
          confirmButtonColor: '#3085d6'
        });
        return false;
      }

      // Validate Quadrants
      var quadrantsValid = true;
      var emptyQuadrantRows = [];

      $('.col-6:first .multi-fields .multi-field').each(function(index) {
        var quadrantField = $(this).find('input[name="quadrant[]"]');

        if (quadrantField.val().trim() == '') {
          quadrantsValid = false;
          emptyQuadrantRows.push(index + 1);
        }
      });

      if (!quadrantsValid) {
        let rowNumbers = emptyQuadrantRows.join(', ');
        swal.fire({
          title: "Validation Error",
          text: `Please fill in Quadrant for row(s): ${rowNumbers}`,
          icon: "error",
          confirmButtonColor: '#3085d6'
        });
        return false;
      }

      // Validate Categories
      var categoriesValid = true;
      var emptyCategoryRows = [];

      $('.col-6:last .multi-fields .multi-field').each(function(index) {
        var categoryField = $(this).find('input[name="category[]"]');

        if (categoryField.val().trim() == '') {
          categoriesValid = false;
          emptyCategoryRows.push(index + 1);
        }
      });

      if (!categoriesValid) {
        let rowNumbers = emptyCategoryRows.join(', ');
        swal.fire({
          title: "Validation Error",
          text: `Please fill in Category for row(s): ${rowNumbers}`,
          icon: "error",
          confirmButtonColor: '#3085d6'
        });
        return false;
      }

      // Check minimum requirements
      if ($('.multi-fields').first().find('.multi-field').length < 2) {
        swal.fire({
          title: "Validation Error",
          text: "At least 2 Options & Values are required",
          icon: "error",
          confirmButtonColor: '#3085d6'
        });
        return false;
      }

      if ($('.col-6:first .multi-fields .multi-field').length < 1) {
        swal.fire({
          title: "Validation Error",
          text: "At least 1 Quadrant is required",
          icon: "error",
          confirmButtonColor: '#3085d6'
        });
        return false;
      }

      if ($('.col-6:last .multi-fields .multi-field').length < 1) {
        swal.fire({
          title: "Validation Error",
          text: "At least 1 Category is required",
          icon: "error",
          confirmButtonColor: '#3085d6'
        });
        return false;
      }
    }

    return true;
  }

  function functiontoggle() {
    if ($('#is_active').prop('checked')) {
      $('#multiple_questions').show();
    } else {
      $('#multiple_questions').hide();
    }
  }

  $('.multi-field-wrapper').each(function() {
    var $wrapper = $('.multi-fields', this);
    $(".add-field", $(this)).click(function(e) {
      $('.multi-field:first-child', $wrapper).clone(true).appendTo($wrapper).find('input').val('').focus();
    });
    $('.multi-field .remove-field', $wrapper).click(function() {
      if ($('.multi-field', $wrapper).length > 2)
        $(this).parent('.multi-field').remove();
      else swal.fire("Required at least 2 Options", "", "error");
    });
  });

  $(document).ready(function() {
    tinymce.init({
      selector: 'textarea#questionnaire_description',
      height: 180,
      menubar: false,
      branding: false,
      toolbar: 'undo redo | formatselect | ' +
        'bold italic backcolor | alignleft aligncenter ' +
        'alignright alignjustify | bullist numlist outdent indent | ' +
        'removeformat | help',
      content_style: 'body { font-family:Helvetica,Arial,sans-serif; background-color:#E2E4E6 !important; color: #000000; font-size:14px }'
    });

    functiontoggle();
  });
</script>

@endsection