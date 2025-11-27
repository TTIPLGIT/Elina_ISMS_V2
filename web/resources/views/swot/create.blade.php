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
    <h4> SWOT Master </h4>
    <div class="card question">
      <form class="form-horizontal" name="questionnaire_form" id="questionnaire_form" method="POST" action="{{ route('recommendationreport.store_data') }}" onsubmit="return validateForm()">
        @csrf
        <div class="row">
          <div class="col-md-6" style="margin: 15px 0px 0px 0px;">
            <div class="form-group questionnaire">
              <label class="control-label required">Area</label>
              <select class="form-control" name="table_num" id="table_num" onchange="table_column(event)">
                <option value="">Select Area</option>
                <option value="1">Strengths</option>
                <option value="2">Work on</option>
                <option value="3">Opportunities</option>
                <option value="4">Threat</option>
                
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
    <div class="row text-center" style="margin-top: 10px;">
      <div class="col-md-12">
        <button class="btn btn-success" type="submit"><i class="fa fa-check"></i> Submit</button>&nbsp;
        <!-- <button class="btn btn-primary" type="reset"><i class="fa fa-undo"></i> Undo </button>&nbsp; -->
        <!-- <a class="btn btn-danger" href="{{ route('questionnaire_master.index') }}"><i class="fa fa-times" aria-hidden="true"></i> Cancel </a>&nbsp; -->
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
    if(e.target.value=='1')
    {
      document.getElementById('table_column').classList.remove('d-none');
    }
    else{
      document.getElementById('table_column').classList.add('d-none');
    }
    
  }
  </script>

@endsection