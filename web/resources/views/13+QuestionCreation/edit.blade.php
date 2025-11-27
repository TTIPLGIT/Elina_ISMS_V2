<div class="modal fade" id="editmodulemodal1">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <form name="edit_form" action="" method="" id="edit_question_form10">

        <div class="modal-header" style="background-color:DarkSlateBlue;">
          <h5 class="modal-title" id="#editModal">Edit Question</h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="row register-form">


            <div class="row" style="margin-bottom: 15px;margin-top: 20px;">

              <div class="col-md-12">
                <div class="form-group questionnaire">
                  <label class="control-label">Questions</label>
                  <input class="form-control" type="text" id="edit_field_question" name="edit_field_question" value="Your Name" autocomplete="off">
                </div>
              </div>
              <div class="col-md-10">
                <div class="form-group questionnaire">
                  <label class="control-label required">Question Type</label>
                  <select class="form-control default" name="field_type_id" id="field_type_id" onChange="typeChange()">
                    <!-- <option value="">Select Question Type</option> -->

                    <option value="1">Short Answer</option>
                    <option value="2">Paragraph</option>
                    <option value="3">Dropdown</option>
                    <option value="4">Multiple Choice Radio</option>
                    <option value="5">Check Box</option>
                    <option value="7" checked>Grid-Multiple Choice Radio</option>
                    <option value="8">Qudrant Dropdown</option>
                    <option value="9">Title and Description</option>
                    <option value="10">Time</option>
                    <option value="11">Date</option>
                    <option value="12">Grid-Multiple Choice Checkbox</option>
                    <option value="13">Qudrant Radio</option>
                    <option value="14">Qudrant Grid</option>
                  </select>
                </div>
              </div>
              <div class="typequestions">
                <input type="hidden" name="client_data" value="1">
                <input type="hidden" value="1" name="edit_field_types_id" id="edit_field_types_id">

                <div class="col-12" id="edit_option1">
                  <div class="form-group">
                    <label>Option</label>
                    <div class="multi-field-wrapper">
                      <div class="multi-fields">


                        <div class="multi-field" style="display: flex;margin-bottom: 5px;">
                          <input type="text" value="" class="form-control" name="options_question[]" id="options_question[]">
                          <button class="remove-field btn btn-danger pull-right" id="remove-f" type='button'>X </button>
                          <!-- <button class="add-field btn btn-danger pull-right" id="" type='button'>+ </button> -->
                          &nbsp;
                        </div>

                      </div>
                      <!-- <button class="add-field btn btn-danger" id="" type='button'>+ </button> -->
                      <button type="button" class="add-field btn btn-success">Add Option</button>
                    </div>
                  </div>
                </div>

                <div class="w-100"></div>

                <div class="row" id="edit_sub_questions{{'1'}}">
                  <div class="col-md-12">
                    <div class="form-group">
                      <label>Sub Question</label>
                      <div class="multi-field-wrapper">
                        <div class="multi-fields">

                          <div class="multi-field" style="display: flex;margin-bottom: 5px;">
                            <input type="text" value="" class="form-control" name="sub_questions[]" id="sub_questions[]">
                            <button class="remove-field btn btn-danger pull-right" id="remove-f" type='button'>X </button>
                            <!-- <button class="add-field btn btn-danger pull-right" id="" type='button'>+ </button> -->
                            &nbsp;
                          </div>

                        </div>
                        <button type="button" class="add-field btn btn-success">Add Question</button>
                      </div>
                    </div>
                  </div>

                  <div class="col-12">
                    <div class="form-group">
                      <label>Option</label>
                      <div class="multi-field-wrapper">
                        <div class="multi-fields">

                          <div class="multi-field" style="display: flex;margin-bottom: 5px;">
                            <input type="text" value="1" class="form-control" name="edit_sub_options[]" id="edit_sub_options[]">
                            <button class="remove-field btn btn-danger pull-right" id="remove-f" type='button'>X </button>
                            <!-- <button class="add-field btn btn-danger pull-right" id="" type='button'>+ </button> -->
                            &nbsp;
                          </div>

                        </div>
                        <!-- <button class="add-field btn btn-danger" id="" type='button'>+ </button> -->
                        <button type="button" class="add-field btn btn-success">Add Option</button>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="w-100"></div>
            </div>
            <div class="col-6" style="display: none;" id="option">
              <div class="form-group">
                <label class="required">Option</label>
                <div class="multi-field-wrapper">
                  <div class="multi-fields" id="add_other">
                    <div class="multi-field" style="display: flex;margin-bottom: 5px;">
                      <input type="text" class="form-control" name="options_questions[]" id="options_question[]" style="margin-right: 10px;">
                      <button class="remove-field btn btn-danger pull-right" id="remove-f" type='button'>X </button>
                      &nbsp;
                    </div>
                  </div>
                  <button type="button" class="add-field btn btn-success">Add Option</button>
                  <b class="otherBtn"> or </b>
                  <a type="button" onclick="add_other()" class="otherBtn" title="Add other" style="color: blue;"><b>Add other</b></a>
                </div>
              </div>
            </div>
            <div class="w-100"></div>
            <div class="col-12" style="display: none;" id="header_field">
              <div class="form-group questionnaire">
                <label class="control-label">Title</label>
                <input class="form-control" type="text" id="header_title" name="header_title" placeholder="optional" autocomplete="off">
              </div>
              <div class="form-group questionnaire">
                <label class="control-label">Description</label>
                <input class="form-control" type="text" id="header_description" name="header_description" placeholder="optional" autocomplete="off">
              </div>
            </div>
            <div class="w-100"></div>
            <div class="row" style="display: none;" id="sub_questions">
              <div class="col-6">
                <div class="form-group">
                  <label class="required">Sub Question</label>
                  <div class="multi-field-wrapper">
                    <div class="multi-fields">
                      <div class="multi-field" style="display: flex;margin-bottom: 5px;">

                        <input type="text" class="form-control" name="sub_question[]" id="sub_question[]" style="margin-right: 10px;">
                        <button class="remove-field btn btn-danger pull-right" id="remove-f" type='button'>X </button>
                        <!-- <button class="add-field btn btn-danger pull-right" id="" type='button'>+ </button> -->
                        &nbsp;
                      </div>
                    </div>
                    <button type="button" class="add-field btn btn-success">Add Question</button>
                  </div>
                </div>
              </div>

              <div class="col-6">
                <div class="form-group">
                  <label class="required">Option</label>
                  <div class="multi-field-wrapper">
                    <div class="multi-fields">
                      <div class="multi-field" style="display: flex;margin-bottom: 5px;">

                        <input type="text" class="form-control" name="sub_options[]" id="sub_options[]" style="margin-right: 10px;">
                        <button class="remove-field btn btn-danger pull-right" id="remove-f" type='button'>X </button>
                        <!-- <button class="add-field btn btn-danger pull-right" id="" type='button'>+ </button> -->
                        &nbsp;
                      </div>
                    </div>
                    <button type="button" class="add-field btn btn-success">Add Option</button>
                  </div>
                </div>
              </div>
            </div>
            <!--  -->
            <div class="row" style="display: none;" id="multiple_questions">
              <div class="col-6">
                <div class="form-group">
                  <label class="required">Quadrant</label>
                  <select class="form-control" name="quadrant" id="quadrant">
                    <option value="">Select Quadrant</option>
                    <option value="1">Study Method</option>
                    <option value="2">In Classroom</option>
                    <option value="3">Home work</option>
                    <option value="4">Regarding Examination</option>

                  </select>
                </div>
              </div>

              <div class="col-6">
                <div class="form-group">
                  <label class="required">Category</label>
                  <select class="form-control" name="quadrant_type_id" id="quadrant_type_id">
                    <option value="">Select Quadrant Category</option>

                  </select>
                </div>
              </div>
              <div class="w-100"></div>
              <div class="col-6">
                <div class="form-group">
                  <label class="required">Options</label>
                  <div class="multi-field-wrapper">
                    <div class="multi-fields">

                      <div class="multi-field" style="display: flex;margin-bottom: 5px;">
                        <input type="text" class="form-control" value="" name="options_questions1[]" id="options_question[]" style="margin-right: 10px;" readonly>
                        <!-- <button class="remove-field btn btn-danger pull-right" id="remove-f" type='button'>X </button> -->
                        &nbsp;
                      </div>

                    </div>
                    <!-- <button type="button" class="add-field btn btn-success">Add Options</button> -->
                  </div>
                </div>
              </div>
              <div class="w-100"></div>

            </div>

            <div class="col-md-12">
              <label>Required:</label>
              <label class='switch' data-bs-toggle='tooltip' data-bs-placement='top' title='Enable / Disable'>
                <input type='checkbox' class='toggle_status' id="required" name='required' checked value="1">
                <span class='slider round'></span>
              </label>
            </div>

          </div>

          <div class="col-md-12">
            <div class="mx-auto">

              <a type="button" onclick="editbuttonclick('10')" class="btn btn-labeled btn-succes" title="Update" style="background: green !important; border-color:green !important; color:white !important">
                <span class="btn-label" style="font-size:13px !important;"><i class="fa fa-check"></i></span>Update</a>
              <a type="button" data-dismiss="modal" aria-label="Close" value="Cancel" class="btn btn-labeled btn-space" title="Cancel" style="background: red !important; border-color:red !important; color:white !important">
                <span class="btn-label" style="font-size:13px !important;"><i class="fa fa-remove"></i></span>Cancel</a>


            </div>
          </div>

      </form>

    </div>
  </div>
</div>
</div>

<script>
   function typeChange() {
    var fieldtype = $('#field_type_id').val();
    document.querySelector('.typequestions').style.display = "none";
    if (fieldtype == 4 || fieldtype == 5) {

      $('#option').show();
      $('#sub_questions').hide();
      $('#multiple_questions').hide();
      $('#question_field').show();
      $('#header_field').hide();
      $('#footerDiv').show();
      $('.otherBtn').show();
      $('#multiple_gridqudrant').hide();
      $('#multiple_radioquestions').hide();
    } else if (fieldtype == 3) {
      $('#option').show();
      $('#sub_questions').hide();
      $('#multiple_questions').hide();
      $('#question_field').show();
      $('#header_field').hide();
      $('#footerDiv').show();
      $('.otherBtn').hide();
      $('#multiple_gridqudrant').hide();
      $('#multiple_radioquestions').hide();
    } else if (fieldtype == 6 || fieldtype == 7) {
      $('#option').hide();
      $('#header_field').hide();
      $('#sub_questions').show();
      $('#question_field').show();
      $('#multiple_questions').hide();
      $('#footerDiv').show();
      $('.otherBtn').hide();
      $('#multiple_gridqudrant').hide();
      $('#multiple_radioquestions').hide();
    } else if (fieldtype == 8) {
      $('#header_field').hide();
      $('#multiple_questions').show();
      $('#sub_questions').hide();
      $('#option').hide();
      $('#question_field').show();
      $('#footerDiv').show();
      $('.otherBtn').hide();
      $('#multiple_gridqudrant').hide();
      $('#multiple_radioquestions').hide();
    } else if (fieldtype == 9) {
      $('#header_field').show();
      $('#footerDiv').hide();
      $('#option').hide();
      $('#sub_questions').hide();
      $('#multiple_questions').hide();
      $('#question_field').hide();
      $('.otherBtn').hide();
      $('#multiple_gridqudrant').hide();
      $('#multiple_radioquestions').hide();
    } else if (fieldtype == 13) {
      $('#header_field').hide();
      $('#multiple_questions').hide();
      $('#multiple_radioquestions').show();
      $('#sub_questions').hide();
      $('#option').hide();
      $('#question_field').show();
      $('#footerDiv').show();
      $('.otherBtn').hide();
      $('#multiple_gridqudrant').hide();
    } else if (fieldtype == 14) {
      $('#option').hide();
      $('#multiple_questions').hide();
      $('#multiple_radioquestions').hide();
      $('#header_field').hide();
      $('#multiple_gridqudrant').show();
      $('#question_field').show();

      $('#footerDiv').show();
      $('.otherBtn').hide();
    } else {
      $('#footerDiv').show();
      $('#header_field').hide();
      $('#question_field').show();
      $('#option').hide();
      $('#sub_questions').hide();
      $('#multiple_questions').hide();
      $('#multiple_gridqudrant').hide();
      $('.otherBtn').hide();
      $('#multiple_radioquestions').hide();
    }
  }
  function editbuttonclick(id) {


    var fieldtype = $('#edit_field_types_id').val();
    // alert(fieldtype);
    if (fieldtype == null || fieldtype == "") {
      swal.fire("Something Went Wrong", "", "error");
      return false;
    }

    var field_question = $('#edit_field_question').val();
    if (field_question == null || field_question == "") {
      swal.fire("Please Enter Question", "", "error");
      return false;
    }

    if (fieldtype == 3 || fieldtype == 4 || fieldtype == 5) {

      var que = document.getElementsByName('options_question[]');
      var QueLength = que.length;
      // alert(QueLength);

      if (QueLength < 2) {
        swal.fire("Required Two Option!", "", "error");
        return false;
      }
      for (i = 0; i < QueLength; i++) {
        if (que[i].value == "") {
          swal.fire("Please Fill Option Field!", "", "error");
          return false;
        }
      }

    } else if (fieldtype == 6 || fieldtype == 7) {


      var Subque = document.getElementsByName('sub_questions[]');
      // console.log(Subque);
      var SubLength = Subque.length;
      // alert(SubLength);

      if (SubLength < 1) {
        swal.fire("Required Two Question!", "", "error");
        return false;
      }
      for (i = 0; i < SubLength; i++) {
        if (Subque[i].value == "") {
          swal.fire("Please Fill Sub Question Field!", "", "error");
          return false;
        }
      }

      var queOpt = document.getElementsByName('edit_sub_options[]');
      // console.log(queOpt);
      var QueOpLength = queOpt.length;
      // alert(QueOpLength);

      if (QueOpLength < 2) {
        swal.fire("Required Two Option!", "", "error");
        return false;
      }
      for (i = 0; i < QueOpLength; i++) {
        if (queOpt[i].value == "") {
          swal.fire("Please Fill Option Field!", "", "error");
          return false;
        }
      }

    }


    document.getElementById('edit_question_form' + id).submit();
  }

 
</script>