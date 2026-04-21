@foreach($question_details as $data)
<div class="modal fade" id="editmodulemodal{{$data['question_details_id']}}">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <form name="edit_form" action="{{ route('question_creation.update', \Crypt::encrypt($data['question_details_id'])) }}" method="POST" id="edit_question_form{{$data['question_details_id']}}">
        {{ csrf_field() }}
        @method('PUT')
        <div class="modal-header" style="background-color:DarkSlateBlue;">
          <h5 class="modal-title" id="#editModal">Edit Question</h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="row register-form">
            <div class="col-md-12">
              <div class="form-group questionnaire">
                <label class="control-label required">Question</label>
                <input class="form-control" type="text" id="edit_field_question{{$data['question_details_id']}}" name="field_question" value="{{ ($data['questionnaire_field_types_id'] == 9) ? ($data['header_title'] ?? $data['question'] ?? '') : ($data['question'] ?? '') }}" autocomplete="off">
              </div>

              @php 
                $desc = $data['question_description'] ?? $data['header_description'] ?? $data['description'] ?? ''; 
              @endphp
              <div class="form-group questionnaire" id="edit_descriptionDiv{{$data['question_details_id']}}" style="{{ ($desc != '' && $desc != null) ? '' : 'display: none;' }}">
                <label class="control-label">Description</label>
                <textarea class="form-control" id="edit_question_description{{$data['question_details_id']}}" name="question_description" autocomplete="off">{{$desc}}</textarea>
                <input type="hidden" name="header_description" id="hidden_header_description{{$data['question_details_id']}}" value="{{$desc}}">
                <input type="hidden" name="description" id="hidden_description{{$data['question_details_id']}}" value="{{$desc}}">
              </div>


              <input type="hidden" name="client_data" value="{{$questionnaire_list[0]['questionnaire_details_id']}}">
              <input type="hidden" value="{{$data['question_field_name']}}" name="question_field_name" id="question_field_name{{$data['question_details_id']}}">
              <input type="hidden" value="{{$data['questionnaire_field_types_id']}}" name="edit_field_types_id" id="edit_field_types_id{{$data['question_details_id']}}">

              {{-- Options for Radio, Checkbox, Dropdown --}}
              <div class="col-12" style="display: none;" id="edit_option{{$data['question_details_id']}}">
                <div class="form-group">
                  <label class="required">Options</label>
                  <div class="multi-field-wrapper">
                    <div class="multi-fields" id="edit_options_container_{{$data['question_details_id']}}">
                      @foreach($option_question_fields as $option)
                      @if($option['question_details_id'] == $data['question_details_id'])
                      <div class="multi-field" style="display: flex; margin-bottom: 5px;">
                        <input type="text" class="form-control" name="options_questions[]" value="{{$option['option_for_question']}}" style="margin-right: 10px;">
                        <button class="remove-field btn btn-danger pull-right" type="button">X</button>
                      </div>
                      @endif
                      @endforeach

                      @if(isset($data['other_option']) && $data['other_option'] == 1)
                      <div class="multi-field other-option-row" style="display: flex; margin-bottom: 5px;" id="edit_other_row_{{$data['question_details_id']}}">
                        <input type="hidden" name="other_option_enabled" value="1">
                        <input type="text" class="form-control" value="Other" readonly style="margin-right: 10px; background-color: #f8f9fa !important;">
                        <button class="btn btn-danger pull-right" type="button" onclick="removeEditOther('{{$data['question_details_id']}}')">X</button>
                      </div>
                      @endif
                    </div>
                    <button type="button" class="add-field btn btn-success">Add Option</button>
                    @if($data['questionnaire_field_types_id'] == 4 || $data['questionnaire_field_types_id'] == 5)
                    <span id="add_other_btn_container_{{$data['question_details_id']}}" style="{{ (isset($data['other_option']) && $data['other_option'] == 1) ? 'display:none;' : '' }}">
                      <b> or </b>
                      <a href="javascript:void(0)" onclick="addEditOther('{{$data['question_details_id']}}')" style="color: blue;"><b>Add other</b></a>
                    </span>
                    @endif
                  </div>
                </div>
              </div>

              {{-- Quadrant Specific Fields --}}
              <div class="row" style="display: none;" id="edit_multiple_questions{{$data['question_details_id']}}">
                <div class="col-6">
                  <div class="form-group">
                    <label class="required">Quadrant</label>
                    <select class="form-control" name="quadrant" id="edit_quadrant{{$data['question_details_id']}}">
                      <option value="">Select Quadrant</option>
                      @foreach($fields as $quadrant)
                        @if($quadrant['type_id'] == '1')
                        <option value="{{$quadrant['field']}}" @if(isset($data['quadrant']) && $data['quadrant'] == $quadrant['field']) selected @endif>{{$quadrant['field']}}</option>
                        @endif
                      @endforeach
                    </select>
                  </div>
                </div>
                <div class="col-6">
                  <div class="form-group">
                    <label class="required">Category</label>
                    <select class="form-control" name="quadrant_type_id" id="edit_quadrant_type_id{{$data['question_details_id']}}">
                      <option value="">Select Category</option>
                      @foreach($fields as $category)
                        @if($category['type_id'] == '2')
                        <option value="{{$category['field']}}" @if((isset($data['quadrant_type_id']) && $data['quadrant_type_id'] == $category['field']) || (isset($data['quadrant_type']) && $data['quadrant_type'] == $category['field']) || (isset($data['category']) && $data['category'] == $category['field'])) selected @endif>{{$category['field']}}</option>
                        @endif
                      @endforeach
                    </select>
                  </div>
                </div>
                <div class="col-12">
                  <div class="form-group">
                    <label>Quadrant Values</label>
                    <div class="multi-field-wrapper">
                      @foreach($options as $option)
                      <div class="multi-field" style="display: flex; margin-bottom: 5px;">
                        <input type="text" class="form-control" value="{{$option['option']}} = {{$option['value']}}" readonly>
                      </div>
                      @endforeach
                    </div>
                  </div>
                </div>
              </div>

              {{-- Sub-Questions Specific Fields --}}
              <div class="row" style="display: none;" id="edit_sub_questions{{$data['question_details_id']}}">
                <div class="col-6">
                  <div class="form-group">
                    <label class="required">Sub Questions</label>
                    <div class="multi-field-wrapper">
                      <div class="multi-fields">
                        @php
                        $matchedSubQuestions = array_filter($sub_questions, function($sq) use ($data) {
                          return $sq['question_details_id'] == $data['question_details_id'];
                        });
                        @endphp
                        @if(!empty($matchedSubQuestions))
                          @foreach($matchedSubQuestions as $data2)
                          <div class="multi-field" style="display: flex; margin-bottom: 5px;">
                            <input type="text" value="{{ $data2['sub_question'] }}" class="form-control" name="sub_questions[]">
                            <button class="remove-field btn btn-danger pull-right" type="button">X</button>
                          </div>
                          @endforeach
                        @else
                          <div class="multi-field" style="display: flex; margin-bottom: 5px;">
                            <input type="text" class="form-control" name="sub_questions[]">
                            <button class="remove-field btn btn-danger pull-right" type="button">X</button>
                          </div>
                        @endif
                      </div>
                      <button type="button" class="add-field btn btn-success">Add Sub Question</button>
                    </div>
                  </div>
                </div>
                <div class="col-6">
                  <div class="form-group">
                    <label class="required">Sub Options</label>
                    <div class="multi-field-wrapper">
                      <div class="multi-fields">
                        @php
                        $matchedOptionFields = array_filter($option_question_fields, function($oq) use ($data) {
                          return $oq['question_details_id'] == $data['question_details_id'];
                        });
                        @endphp
                        @if(!empty($matchedOptionFields))
                          @foreach($matchedOptionFields as $data1)
                          <div class="multi-field" style="display: flex; margin-bottom: 5px;">
                            <input type="text" value="{{ $data1['option_for_question'] }}" class="form-control" name="edit_sub_options[]">
                            <button class="remove-field btn btn-danger pull-right" type="button">X</button>
                          </div>
                          @endforeach
                        @else
                          <div class="multi-field" style="display: flex; margin-bottom: 5px;">
                            <input type="text" class="form-control" name="edit_sub_options[]">
                            <button class="remove-field btn btn-danger pull-right" type="button">X</button>
                          </div>
                        @endif
                      </div>
                      <button type="button" class="add-field btn btn-success">Add Option</button>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <div class="mx-auto">
            <a type="button" onclick="editbuttonclick('{{$data['question_details_id']}}')" class="btn btn-success" title="Update">
              <i class="fa fa-check"></i> Update
            </a>
            <a type="button" data-dismiss="modal" class="btn btn-labeled btn-space" title="Cancel" style="background: red !important; border-color: red !important; color: white !important;">
              <span class="btn-label" style="font-size: 13px !important;"><i class="fa fa-remove"></i></span> Cancel
            </a>
          </div>
        </div>
      </form>
    </div>
  </div>
</div>

<script>
  function editbuttonclick(id) {
    if (typeof tinymce !== 'undefined') {
        tinymce.triggerSave();
    }
    var descVal = $('#edit_question_description' + id).val();
    $('#hidden_header_description' + id).val(descVal);
    $('#hidden_description' + id).val(descVal);
    
    var fieldtype = $('#edit_field_types_id' + id).val();
    if (fieldtype == null || fieldtype == "") {
      swal.fire("Something Went Wrong", "", "error");
      return false;
    }

    var field_question = $('#edit_field_question' + id).val();
    if (field_question == null || field_question == "") {
      swal.fire("Please Enter Question", "", "error");
      return false;
    }

    if (fieldtype == 3 || fieldtype == 4 || fieldtype == 5) {
      var form = document.getElementById('edit_question_form' + id);
      var que = form.querySelectorAll('input[name="options_questions[]"]');
      if (que.length < 2) {
        swal.fire("Required at least two options!", "", "error");
        return false;
      }
      for (var i = 0; i < que.length; i++) {
        if (que[i].value == "") {
          swal.fire("Please fill all option fields!", "", "error");
          return false;
        }
      }
    } else if (fieldtype == 6 || fieldtype == 7) {
      var subque = document.getElementsByName('sub_questions[]');
      if (subque.length < 1) {
        swal.fire("Required at least one sub-question!", "", "error");
        return false;
      }
      var subopt = document.getElementsByName('edit_sub_options[]');
      if (subopt.length < 2) {
        swal.fire("Required at least two options for sub-questions!", "", "error");
        return false;
      }
    }

    if (fieldtype == 8) {
      var quadrant = $('#edit_quadrant' + id).val();
      if (quadrant == null || quadrant == "") {
        swal.fire("Please Select Quadrant", "", "error");
        return false;
      }
      var category = $('#edit_quadrant_type_id' + id).val();
      if (category == null || category == "") {
        swal.fire("Please Select Category", "", "error");
        return false;
      }
    }

    document.getElementById('edit_question_form' + id).submit();
  }

  function addEditOther(id) {
    var html = '<div class="multi-field other-option-row" style="display: flex; margin-bottom: 5px;" id="edit_other_row_' + id + '">';
    html += '<input type="hidden" name="other_option_enabled" value="1">';
    html += '<input type="text" class="form-control" value="Other" readonly style="margin-right: 10px; background-color: #f8f9fa !important;">';
    html += '<button class="btn btn-danger pull-right" type="button" onclick="removeEditOther(\'' + id + '\')">X</button></div>';
    
    $('#edit_options_container_' + id).append(html);
    $('#add_other_btn_container_' + id).hide();
  }

  function removeEditOther(id) {
    $('#edit_other_row_' + id).remove();
    $('#add_other_btn_container_' + id).show();
  }
</script>
@endforeach