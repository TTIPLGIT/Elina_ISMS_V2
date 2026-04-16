@extends('layouts.parent')

@section('content')

<style>
  .options-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
    gap: 10px 15px;
    margin-top: 8px;
  }

  .option-item {
    display: flex;
    align-items: center;
  }

  .option-item input[type="checkbox"],
  .option-item input[type="radio"] {
    width: 16px;
    height: 16px;
    margin-right: 8px;
    flex-shrink: 0;
    accent-color: #007bff; /* ✅ Blue tick */
    cursor: pointer;
  }

  /* ✅ Keep color even if disabled (if used later) */
  .option-item input:disabled {
    opacity: 1;
  }

  .other-input {
    margin-top: 12px;
    width: 100%;
    max-width: 300px;
  }

  select.form-control {
    color: #000 !important;
  }
</style>

<div class="main-content">

  {{ Breadcrumbs::render('g2form.new' , $child_name) }}

  <div class="row">
    <div class="col-lg-12 text-center">
      <h4 style="color:darkblue;">Parent Reflection Form ({{$child_name}})</h4>
    </div>

    <div class="col-12">
      <div class="card">

        <form action="{{route('g2form.store')}}" method="POST" id="gfrom">
          {{ csrf_field() }}

          <div class="card-body" style="max-height:400px;overflow:auto;">

            @foreach($questions as $question)

            @php
            // ✅ Extract options
            $options = [];
            if(isset($question['other_option'])) {
              preg_match_all('/\[(.*?)\]/', $question['other_option'], $matches);
              if(!empty($matches[1])) {
                $options = array_map('trim', $matches[1]);
              }
            }

            // ✅ Stored value
            $value = isset($answers[0]) ? ($answers[0][$question['question_column_name']] ?? '') : '';

            // ✅ Decode value (JSON or CSV)
            $selectedValues = [];
            if (!empty($value)) {
              $decoded = json_decode($value, true);
              if (is_array($decoded)) {
                $selectedValues = array_map('trim', $decoded);
              } else {
                $selectedValues = array_map('trim', explode(',', $value));
              }
            }

            // ✅ Extract OTHER values
            $otherValues = [];
            foreach ($selectedValues as $val) {
              if (!in_array($val, $options)) {
                $otherValues[] = $val;
              }
            }

            $otherValue = !empty($otherValues) ? implode(', ', $otherValues) : '';

            // ✅ IMPORTANT: Allow editing
            $disabled = '';
            @endphp

            <div class="form-group">

              <label class="{{ $question['required'] == '1' ? 'required' : '' }}">
                {{ $loop->iteration }}. {!! $question['question'] !!}
              </label>

              <p>{!! $question['question_description'] !!}</p>

              {{-- TEXTAREA --}}
              @if(in_array($question['field_types_id'], [1,2]))
              <textarea class="form-control"
                name="answer[{{$question['question_column_name']}}]">{{$value}}</textarea>

              {{-- DROPDOWN --}}
              @elseif($question['field_types_id'] == 3)
              <select class="form-control"
                name="answer[{{$question['question_column_name']}}]">
                <option value="">Select</option>
                @foreach($options as $opt)
                <option value="{{ $opt }}" {{ $value == $opt ? 'selected' : '' }}>
                  {{ $opt }}
                </option>
                @endforeach
              </select>

              {{-- RADIO --}}
              @elseif($question['field_types_id'] == 4)
              @foreach($options as $opt)
              <div class="option-item pt-3">
                <input type="radio"
                  name="answer[{{$question['question_column_name']}}]"
                  value="{{ $opt }}"
                  {{ $value == $opt ? 'checked' : '' }}>
                <label>{{ $opt }}</label>
              </div>
              @endforeach

              {{-- CHECKBOX --}}
              @elseif($question['field_types_id'] == 5)

              @foreach($options as $opt)
              <div class="option-item pt-3">
                <input type="checkbox"
                  name="answer[{{$question['question_column_name']}}][]"
                  value="{{ $opt }}"
                  {{ in_array($opt, $selectedValues) ? 'checked' : '' }}>
                <label class="option-item pt-1">{{ $opt }}</label>
              </div>
              @endforeach

              {{-- OTHERS --}}
              <div class="option-item pt-3">
                <input type="checkbox"
                  class="other-check"
                  {{ $otherValue ? 'checked' : '' }}>
                <label>Others</label>
              </div>

              <input type="text"
                class="form-control other-input mt-2"
                name="other[{{$question['question_column_name']}}]"
                value="{{ $otherValue }}"
                placeholder="Enter other value"
                style="{{ $otherValue ? 'display:block;' : 'display:none;' }}">

              @endif

            </div>

            @endforeach

          </div>

          <div class="text-center mb-3">
            <input type="hidden" id="type" name="type">
            <input type="hidden" name="enrollment_id" value="{{$enrollId}}">

            <button type="button" class="btn btn-warning" onclick="saveForm()">Save</button>
            <button type="button" class="btn btn-success" onclick="validateanswer()">Submit</button>
            <a href="{{ route('g2form.list') }}" class="btn btn-danger">Cancel</a>
          </div>

        </form>

      </div>
    </div>
  </div>
</div>

<script>
  $(document).on('change', '.other-check', function() {
    let input = $(this).closest('.form-group').find('.other-input');

    if ($(this).is(':checked')) {
      input.show();
    } else {
      input.hide().val('');
    }
  });

  $(document).ready(function() {
    $('.other-check').each(function() {
      let input = $(this).closest('.form-group').find('.other-input');
      if ($(this).is(':checked')) {
        input.show();
      }
    });
  });

  function validateanswer() {
    document.getElementById("type").value = "Submitted";
    document.getElementById('gfrom').submit();
  }

  function saveForm() {
    document.getElementById("type").value = "Saved";
    document.getElementById('gfrom').submit();
  }
</script>

@endsection