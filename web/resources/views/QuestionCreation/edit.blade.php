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


            <div class="row" style="margin-bottom: 15px;margin-top: 20px;">

              <div class="col-md-12">
                <div class="form-group questionnaire">
                  <label class="control-label">Questions</label>
                  <input class="form-control" type="text" id="edit_field_question" name="edit_field_question" value="{{$data['question']}}" autocomplete="off">
                </div>
              </div>
              <input type="hidden" name="client_data" value="{{$questionnaire_list[0]['questionnaire_details_id']}}">
              <input type="hidden" value="{{$data['questionnaire_field_types_id']}}" name="edit_field_types_id" id="edit_field_types_id">

              <div class="col-12" style="display: none;" id="edit_option{{$data['question_details_id']}}">
                <div class="form-group">
                  <label>Option</label>
                  <div class="multi-field-wrapper">
                    <div class="multi-fields">
                      @foreach($option_question_fields as $data1)
                      @if($data['question_details_id'] == $data1['question_details_id'])
                      <div class="multi-field" style="display: flex;margin-bottom: 5px;">
                        <input type="text" value="{{$data1['option_for_question']}}" class="form-control" name="options_question[]" id="options_question[]">
                        <button class="remove-field btn btn-danger pull-right" id="remove-f" type='button'>X </button>
                        <!-- <button class="add-field btn btn-danger pull-right" id="" type='button'>+ </button> -->
                        &nbsp;
                      </div>
                      @endif
                      @endforeach
                    </div>
                    <!-- <button class="add-field btn btn-danger" id="" type='button'>+ </button> -->
                    <button type="button" class="add-field btn btn-success">Add Option</button>
                  </div>
                </div>
              </div>

              <div class="w-100"></div>

              <div class="row" style="display: none;" id="edit_sub_questions{{$data['question_details_id']}}">
                <div class="col-6">
                  <div class="form-group">
                    <label>Sub Question</label>
                    <div class="multi-field-wrapper">
                      <div class="multi-fields">
                        {{-- @foreach($sub_questions as $data2)
                        @if($data['question_details_id'] == $data2['question_details_id'])
                        <div class="multi-field" style="display: flex;margin-bottom: 5px;">
                          <input type="text" value="{{$data2['sub_question']}}" class="form-control" name="sub_questions[]" id="sub_questions[]">
                        <button class="remove-field btn btn-danger pull-right" id="remove-f" type='button'>X </button>
                        <!-- <button class="add-field btn btn-danger pull-right" id="" type='button'>+ </button> -->
                        &nbsp;
                      </div>
                      @endif
                      @endforeach --}}

                      @php
                      $matchedSubQuestions = array_filter($sub_questions, function($sq) use ($data) {
                      return $sq['question_details_id'] == $data['question_details_id'];
                      });
                      @endphp

                      @if(!empty($matchedSubQuestions))
                      @foreach($matchedSubQuestions as $data2)
                      <div class="multi-field" style="display: flex; margin-bottom: 5px;">
                        <input type="text"
                          value="{{ $data2['sub_question'] }}"
                          class="form-control"
                          name="sub_questions[]"
                          id="sub_questions[]">
                        <button class="remove-field btn btn-danger pull-right" type="button">X</button>
                        &nbsp;
                      </div>
                      @endforeach
                      @else
                      {{-- If no sub questions exist, show one empty field --}}
                      <div class="multi-field" style="display: flex; margin-bottom: 5px;">
                        <input type="text"
                          value=""
                          class="form-control"
                          name="sub_questions[]"
                          id="sub_questions[]">
                        <button class="remove-field btn btn-danger pull-right" type="button">X</button>
                        &nbsp;
                      </div>
                      @endif

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
                      {{-- @foreach($option_question_fields as $data1)
                      @if($data['question_details_id'] == $data1['question_details_id'])
                      <div class="multi-field" style="display: flex;margin-bottom: 5px;">
                        <input type="text" value="{{$data1['option_for_question']}}" class="form-control" name="edit_sub_options[]" id="edit_sub_options[]">
                      <button class="remove-field btn btn-danger pull-right" id="remove-f" type='button'>X </button>
                      <!-- <button class="add-field btn btn-danger pull-right" id="" type='button'>+ </button> -->
                      &nbsp;
                    </div>
                    @endif
                    @endforeach --}}

                    @php
                    $matchedOptionFields = array_filter($option_question_fields, function($oq) use ($data) {
                    return $oq['question_details_id'] == $data['question_details_id'];
                    });
                    @endphp

                    @if(!empty($matchedOptionFields))
                    @foreach($matchedOptionFields as $data1)
                    <div class="multi-field" style="display: flex; margin-bottom: 5px;">
                      <input type="text"
                        value="{{ $data1['option_for_question'] }}"
                        class="form-control"
                        name="edit_sub_options[]"
                        id="edit_sub_options[]">
                      <button class="remove-field btn btn-danger pull-right" type="button">X</button>
                      &nbsp;
                    </div>
                    @endforeach
                    @else
                    {{-- If no options exist, show one empty input --}}
                    <div class="multi-field" style="display: flex; margin-bottom: 5px;">
                      <input type="text"
                        value=""
                        class="form-control"
                        name="edit_sub_options[]"
                        id="edit_sub_options[]">
                      <button class="remove-field btn btn-danger pull-right" type="button">X</button>
                      &nbsp;
                    </div>
                    @endif

                  </div>
                  <!-- <button class="add-field btn btn-danger" id="" type='button'>+ </button> -->
                  <button type="button" class="add-field btn btn-success">Add Option</button>
                </div>
              </div>
            </div>
          </div>

          <div class="w-100"></div>
        </div>


    </div>

    <div class="modal-footer">
      <div class="mx-auto">

        <a type="button" onclick="editbuttonclick('{{$data['question_details_id']}}')" class="btn btn-labeled btn-succes" title="Update" style="background: green !important; border-color:green !important; color:white !important">
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
@endforeach