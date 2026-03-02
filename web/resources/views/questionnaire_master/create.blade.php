@extends('layouts.adminnav')

@section('content')

@if(session('error'))
<script>
  document.addEventListener('DOMContentLoaded', function() {
    Swal.fire({
      icon: 'error',
      title: 'Error',
      text: "{{ session('error') }}",
      confirmButtonColor: '#d33'
    });
  });
</script>
@endif


@if(session('success'))
<script>
  document.addEventListener('DOMContentLoaded', function() {
    Swal.fire({
      icon: 'success',
      title: 'Success',
      text: "{{ session('success') }}",
      confirmButtonColor: '#3085d6'
    });
  });
</script>
@endif
<style>
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
</style>
<div class="main-content">
  {{ Breadcrumbs::render('questionnaire_master.create') }}
  <div class="section-body mt-0">
    <h4> Questionnaire Creation </h4>
    <form class="form-horizontal" name="questionnaire_form" id="questionnaire_form" method="POST" action="{{ route('questionnaire_master.store') }}" onsubmit="return validateForm()">
      @csrf
      <div class="card question">
        <div class="row">
          <div class="col-md-6" style="margin: 15px 0px 0px 0px;">
            <div class="form-group">
              <label class="control-label">Questionnaire Name<span style="color: red;font-size: 16px;">*</span></label>
              <input class="form-control" type="text" id="questionnaire_name" style="background-color: #ffffff !important; color: #000000;" name="questionnaire_name" placeholder="Enter Questionnaire Name">
            </div>
          </div>
          <div class="col-md-6" style="margin: 15px 0px 0px 0px;">
            <div class="form-group questionnaire">
              <label class="control-label required">Questionnaire Type</label>
              <select style="background-color: #ffffff !important; color: #000000;" class="form-control" name="questionnaire_type" id="questionnaire_type">
                <option value="">Select Questionnaire Type</option>
                <option value="OVM">OVM</option>
                <option value="Sail">Sail</option>
                <option value="OVM">CoMPASS</option>
              </select>
            </div>
          </div>

          <div class="col-lg-12">
            <div class="form-group">
              <label class="control-label">Questionnaire Description<span style="color: red;font-size: 16px;">*</span></label>
              <textarea class="form-control" id="questionnaire_description" name="questionnaire_description"></textarea>
            </div>
          </div>

          <div class="row text-center" style="margin-top: 10px;">
            <div class="col-md-12">
              <label class='switch' data-bs-toggle='tooltip' data-bs-placement='top' title='Enable / Disable'><input type='checkbox' class='toggle_status' onclick="functiontoggle()" id="is_active" name='is_active'><span class='slider round'></span></label>
            </div>
          </div>
        </div>
      </div>
      <div class="card question" style="display: none;" id="multiple_questions">
        <div class="row">
          <div class="row">
            <div class="col-md-12">
              <div class="form-group questionnaire">
                <label class="control-label required">Options & Values</label>
                <div class="multi-field-wrapper">
                  <div class="multi-fields">
                    <div class="multi-field" style="display: flex;margin-bottom: 5px;">

                      <input class="form-control" style="background-color:white!important" type="text" id="option" name="option[]" autocomplete="off" placeholder="Almost Always">
                      <input class="form-control" style="background-color:white!important" type="text" id="value" name="value[]" style="margin-left:20px;" autocomplete="off" placeholder="5">
                      <button class="remove-field btn btn-danger pull-right" id="remove-f" type='button'>X </button>
                      &nbsp;
                    </div>
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
                    <div class="multi-field" style="display: flex;margin-bottom: 5px;">
                      <input type="text" style="background-color:white!important" class="form-control" name="quadrant[]" id="quadrant[]" style="margin-right: 10px;">
                      <button class="remove-field btn btn-danger pull-right" id="remove-f" type='button'>X </button>
                      &nbsp;
                    </div>
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
                    <div class="multi-field" style="display: flex;margin-bottom: 5px;">
                      <input style="background-color:white!important" type="text" class="form-control" name="category[]" id="category[]" style="margin-right: 10px;">
                      <button class="remove-field btn btn-danger pull-right" id="remove-f" type='button'>X </button>
                      &nbsp;
                    </div>
                  </div>
                  <button type="button" class="add-field btn btn-success">Add Category</button>
                </div>
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/tinymce/4.5.6/tinymce.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="http://cdnjs.cloudflare.com/ajax/libs/tinymce/4.5.6/jquery.tinymce.min.js"></script>
<script type="text/javascript">
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
      content_style: 'body { font-family:Helvetica,Arial,sans-serif; font-size:14px }'
    });
  });

  function validateForm() {

    let questionnaire_name = $("#questionnaire_name").val().trim();
    if (questionnaire_name == '') {
      Swal.fire("Questionnaire Name is required", "", "error");
      return false;
    }

    let questionnaire_type = $('#questionnaire_type').val();
    if (!questionnaire_type) {
      Swal.fire("Questionnaire Type is required", "", "error");
      return false;
    }

    let questionnaire_description = tinymce.get('questionnaire_description').getContent({
      format: 'text'
    }).trim();
    if (questionnaire_description == '') {
      Swal.fire("Questionnaire Description is required", "", "error");
      return false;
    }

    // ✅ If Enable Toggle Checked
    if ($('#is_active').prop('checked')) {

      // ===== OPTIONS =====
      let optionIndex = 1;
      let optionValid = true;
      $('input[name="option[]"]').each(function() {
        if ($(this).val().trim() == '') {
          Swal.fire("Option " + optionIndex + " is required", "", "error");
          optionValid = false;
          return false;
        }
        optionIndex++;
      });
      if (!optionValid) return false;

      // ===== VALUES =====
      let valueIndex = 1;
      let valueValid = true;
      $('input[name="value[]"]').each(function() {
        if ($(this).val().trim() == '') {
          Swal.fire("Value " + valueIndex + " is required", "", "error");
          valueValid = false;
          return false;
        }
        valueIndex++;
      });
      if (!valueValid) return false;

      // ===== QUADRANT =====
      let quadrantIndex = 1;
      let quadrantValid = true;
      $('input[name="quadrant[]"]').each(function() {
        if ($(this).val().trim() == '') {
          Swal.fire("Quadrant " + quadrantIndex + " is required", "", "error");
          quadrantValid = false;
          return false;
        }
        quadrantIndex++;
      });
      if (!quadrantValid) return false;

      // ===== CATEGORY =====
      let categoryIndex = 1;
      let categoryValid = true;
      $('input[name="category[]"]').each(function() {
        if ($(this).val().trim() == '') {
          Swal.fire("Category " + categoryIndex + " is required", "", "error");
          categoryValid = false;
          return false;
        }
        categoryIndex++;
      });
      if (!categoryValid) return false;
    }

    return true;
  }
</script>
<script type="text/javascript">
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
      else swal.fire("Required Two Option", "", "error");
    });
  });
</script>
@endsection