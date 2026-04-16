@extends('layouts.adminnav')

@section('content')

<style>
  .options-grid {
    display: block;
    margin-top: 8px;
  }

  .option-item {
    display: flex;
    align-items: center;
    gap: 8px;
    margin-bottom: 8px;
  }

  .option-item input[type="checkbox"],
  .option-item input[type="radio"] {
    width: 16px;
    height: 16px;
    margin-right: 8px;
    flex-shrink: 0;
    accent-color: #007bff;
    cursor: pointer;
  }

  .other-input {
    margin-top: 10px;
    width: 100%;
    max-width: 300px;
  }

  select.form-control {
    color: #000 !important;
  }
</style>

<div class="main-content">

  {{ Breadcrumbs::render('g2form.new' , $child_name) }}

  {{-- Alerts --}}
  @if (session('success'))
  <script>
    window.onload = function() {
      Swal.fire('Success!', @json(session('success')), 'success');
    }
  </script>
  @elseif(session('fail'))
  <script>
    window.onload = function() {
      Swal.fire('Info!', @json(session('fail')), 'info');
    }
  </script>
  @endif

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
            $options = [];
            if(isset($question['other_option']) && !empty($question['other_option'])){
              preg_match_all('/\[(.*?)\]/', $question['other_option'], $matches);
              if(!empty($matches[1])){
                $options = array_map('trim', $matches[1]);
              }
            }

            $value = isset($answers[0]) ? ($answers[0][$question['question_column_name']] ?? '') : '';

            $selectedValues = [];
            if (!empty($value)) {
              $decoded = json_decode($value, true);
              if (is_array($decoded)) {
                $selectedValues = array_map('trim', $decoded);
              } else {
                $selectedValues = array_map('trim', explode(',', $value));
              }
            }

            $otherValues = [];
            foreach ($selectedValues as $val) {
              if (!in_array($val, $options)) {
                $otherValues[] = $val;
              }
            }

            $otherValue = !empty($otherValues) ? implode(', ', $otherValues) : '';

            $isDisabled = (isset($answers[0]) && $answers[0]['status'] == 'Submitted');
            @endphp

            <div class="form-group">

              <label class="{{ $question['required'] == '1' ? 'required' : '' }}">
                {{ $loop->iteration }}. {!! $question['question'] !!}
              </label>

              <p>{!! $question['question_description'] !!}</p>

              {{-- TEXTAREA --}}
              @if(in_array($question['field_types_id'], [1,2]))
              <textarea class="form-control"
                name="answer[{{$question['question_column_name']}}]"
                data-required="{{$question['required']}}"
                {{ $isDisabled ? 'readonly' : '' }}>{{$value}}</textarea>

              {{-- DROPDOWN --}}
              @elseif($question['field_types_id'] == 3)
              <select class="form-control"
                name="answer[{{$question['question_column_name']}}]"
                data-required="{{$question['required']}}"
                {{ $isDisabled ? 'disabled' : '' }}>
                <option value="">Select</option>
                @foreach($options as $opt)
                <option value="{{ $opt }}" {{ $value == $opt ? 'selected' : '' }}>
                  {{ $opt }}
                </option>
                @endforeach
              </select>

              {{-- RADIO --}}
              @elseif($question['field_types_id'] == 4)
              <div class="options-grid">
                @foreach($options as $opt)
                <div class="option-item">
                  <input type="radio"
                    name="answer[{{$question['question_column_name']}}]"
                    value="{{ $opt }}"
                    data-required="{{$question['required']}}"
                    {{ $value == $opt ? 'checked' : '' }}
                    {{ $isDisabled ? 'onclick=return false;' : '' }}>
                  <label>{{ $opt }}</label>
                </div>
                @endforeach
              </div>

              {{-- CHECKBOX --}}
              @elseif($question['field_types_id'] == 5)

              <div class="options-grid">
                @foreach($options as $opt)
                <div class="option-item pt-1">
                  <input type="checkbox"
                    name="answer[{{$question['question_column_name']}}][]"
                    value="{{ $opt }}"
                    data-required="{{$question['required']}}"
                    {{ in_array($opt, $selectedValues) ? 'checked' : '' }}
                    {{ $isDisabled ? 'onclick=return false;' : '' }}>
                  <label class="option-item pt-2">{{ $opt }}</label>
                </div>
                @endforeach
              </div>

              {{-- OTHERS --}}
              <div class="option-item mt-2">
                <input type="checkbox"
                  class="other-check"
                  {{ $otherValue ? 'checked' : '' }}
                  {{ $isDisabled ? 'onclick=return false;' : '' }}>
                <label>Others</label>
              </div>

              <input type="text"
                class="form-control other-input"
                name="other[{{$question['question_column_name']}}]"
                value="{{ $otherValue }}"
                placeholder="Enter other value"
                style="{{ $otherValue ? 'display:block;' : 'display:none;' }}"
                {{ $isDisabled ? 'readonly' : '' }}>

              @endif

            </div>

            @endforeach

          </div>

          {{-- BUTTONS --}}
          <div class="text-center mb-3">
            <input type="hidden" id="type" name="type">
            <input type="hidden" name="enrollment_id" value="{{$enrollId}}">

            @if(isset($answers[0]) && $answers[0]['status'] == 'Submitted')
            <a href="{{ route('g2form.list') }}" class="btn btn-danger">Back</a>
            @else
            <button type="button" class="btn btn-warning" onclick="saveForm()">Save</button>
            <button type="button" class="btn btn-success" onclick="validateanswer()">Submit</button>
            <a href="{{ route('g2form.list') }}" class="btn btn-danger">Cancel</a>
            @endif
          </div>

        </form>

      </div>
    </div>
  </div>
</div>

{{-- JS --}}
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

    let isValid = true;

    $('[data-required="1"]').each(function() {

      if ($(this).is('textarea') || $(this).is('select')) {
        if ($.trim($(this).val()) === '') {
          isValid = false;
          return false;
        }
      }

      if ($(this).is(':radio')) {
        let name = $(this).attr('name');
        if (!$('input[name="' + name + '"]:checked').length) {
          isValid = false;
          return false;
        }
      }

      if ($(this).is(':checkbox') && $(this).attr('name')) {
        let name = $(this).attr('name');
        if (!$('input[name="' + name + '"]:checked').length) {
          isValid = false;
          return false;
        }
      }

    });

    if (!isValid) {
      Swal.fire('Error', 'Please fill all required fields', 'error');
      return false;
    }

    document.getElementById('gfrom').submit();
  }

  function saveForm() {
    document.getElementById("type").value = "Saved";
    document.getElementById('gfrom').submit();
  }
</script>

@endsection