@extends('layouts.adminnav')

@section('content')

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
              <input class="form-control" type="text" id="questionnaire_name" name="questionnaire_name" placeholder="Enter Questionnaire Name">
            </div>
          </div>
          <div class="col-md-6" style="margin: 15px 0px 0px 0px;">
            <div class="form-group questionnaire">
              <label class="control-label required">Questionnaire Type</label>
              <select class="form-control" name="questionnaire_type" id="questionnaire_type">
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
                <label class="control-label">Options & Values</label>
                <div class="multi-field-wrapper">
                  <div class="multi-fields">
                    <div class="multi-field" style="display: flex;margin-bottom: 5px;">

                      <input class="form-control" type="text" id="option" name="option[]" autocomplete="off" placeholder="Almost Always">
                      <input class="form-control" type="text" id="value" name="value[]" style="margin-left:20px;" autocomplete="off" placeholder="5">
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
                      <input type="text" class="form-control" name="quadrant[]" id="quadrant[]" style="margin-right: 10px;">
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
                      <input type="text" class="form-control" name="category[]" id="category[]" style="margin-right: 10px;">
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

    let questionnaire_id = document.getElementById("questionnaire_name").value;
    if (questionnaire_id == '' || questionnaire_id == null) {
      swal.fire("Please Enter Questionnaire Name", "", "error");
      return false;
    }

    var fieldtype = $('#questionnaire_type').val();
    if (fieldtype == null || fieldtype == "") {
      swal.fire("Please Select Questionnaire Type", "", "error");
      return false;
    }

    var questionnaire_description = tinymce.get('questionnaire_description').getContent();
    if (questionnaire_description == '' || questionnaire_description == null) {
      swal.fire("Please Enter Questionnaire Description", "", "error");
      return false;
    }

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