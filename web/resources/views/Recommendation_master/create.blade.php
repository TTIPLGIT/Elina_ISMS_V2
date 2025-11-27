@extends('layouts.adminnav')

@section('content')

<style>
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
    <h4 style="text-align: center;"> Recommendation Report Master </h4>
    <div class="card question">
      <form class="form-horizontal" name="questionnaire_form" id="questionnaire_form" method="POST" action="{{ route('recommendationreport.store_data') }}" onsubmit="return validateForm()">
        @csrf
        <div class="row">
          <div class="col-md-6" style="margin: 15px 0px 0px 0px;">
            <div class="form-group questionnaire">
              <label class="control-label">Areas Name<span style="color: red;font-size: 16px;">*</span></label>
              <input class="form-control" type="text" id="Areas_Name" name="Areas_Name" placeholder="Enter Areas Name">
            </div>
          </div>
          <div class="col-md-6" style="margin: 15px 0px 0px 0px;">
            <div class="form-group questionnaire">
              <label class="control-label required">Environment Type</label>
              <select class="form-control" name="table_num" id="table_num" onchange="table_column(event)">
                <option value="">Select Environment Type</option>
                <option value="1">Connection Environment</option>
                <option value="2">Learning Environment</option>
                <option value="3">Components in Learning</option>
              </select>
            </div>
          </div>
          <div class="col-md-12 d-none" id="table_column">
            <div class="form-group questionnaire">
              <div>
                <label class="control-label" name="recommended_environment" id="recommended_environment">Recommended Environment </label>
                <label class="control-label" name="strategies_recommended" id="strategies_recommended" style="margin-left:20%">Some strategies recommended </label>
              </div>

              <div class="multi-field-wrapper">
                <div class="multi-fields">
                  <div class="multi-field" style="display: flex;margin-bottom: 5px;">

                    <input type="text" class="form-control" name="description[]" id="description">
                    <input class="form-control" type="text" id="file" name="file[]" value="" style="margin-left:20px;" autocomplete="off">
                    <button class="remove-field btn btn-danger pull-right" id="remove-f" type='button'>X </button>

                    &nbsp;
                  </div>
                </div>
                <button type="button" class="add-field btn btn-success">Add Description</button>
              </div>
            </div>
          </div>
        </div>
        <div class="row text-center" style="margin: 10px;">
          <div class="col-md-12">
            <button class="btn btn-success" type="submit"><i class="fa fa-check"></i> Submit</button>&nbsp;
          </div>
        </div>
    </div>
    </form>
  </div>
  </section>

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
    event.preventDefault()
  });

  // function validateForm() {

  //   let questionnaire_id = document.getElementById("questionnaire_name").value;
  //   if (questionnaire_id == '' || questionnaire_id == null) {
  //     swal.fire("Please Enter Questionnaire Name", "", "error");
  //     return false;
  //   }

  //   var fieldtype = $('#questionnaire_type').val();
  //   if (fieldtype == null || fieldtype == "") {
  //     swal.fire("Please Select Questionnaire Type", "", "error");
  //     return false;
  //   }

  //   var questionnaire_description = tinymce.get('questionnaire_description').getContent();
  //   if (questionnaire_description == '' || questionnaire_description == null) {
  //     swal.fire("Please Enter Questionnaire Description", "", "error");
  //     return false;
  //   }

  // }

  $('.multi-field-wrapper').each(function() {

    var $wrapper = $('.multi-fields', this);
    console.log($wrapper);


    $(".add-field", $(this)).click(function(e) {
      $('.multi-field:first-child', $wrapper).clone(true).appendTo($wrapper).find('input').val('').focus();
      $('#file_field').append('<div class="multi-field" style="display: flex;margin-bottom: 5px;"><input class="form-control" type="text" id="file" name="file" autocomplete="off"></div>');
    });

    $('.multi-field .remove-field', $wrapper).click(function() {
      if ($('.multi-field', $wrapper).length > 1)
        $(this).parent('.multi-field').remove();

      else bootbox.alert({
        title: "Metadata creation",
        centerVertical: true,
        message: "Required one Dropdown Option",
      });


    });
  });
</script>
<script>
  function table_column(e)

  {
    if (e.target.value == '1') {
      document.getElementById('table_column').classList.remove('d-none');
    } else {
      document.getElementById('table_column').classList.add('d-none');
    }

  }
</script>

@endsection