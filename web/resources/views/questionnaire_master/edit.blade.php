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

  /* body{
        background-color: white !important;
    } */
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
              <label class="control-label">Options & Values</label>
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
    let questionnaire_id = document.getElementById("questionnaire_name").value;
    if (questionnaire_id == '' || questionnaire_id == null) {
      swal.fire("Please Questionnaire Name", "", "error");
      return false;
    }

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
      else swal.fire("Required Two Option", "", "error");
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
      content_style: 'body { font-family:Helvetica,Arial,sans-serif; font-size:14px }'
    });

    functiontoggle();
  });
</script>

@endsection