@extends('layouts.parent')

@section('content')

{{-- Alerts --}}
@if (session('success'))
<script>
  window.onload = function() {
    Swal.fire('Success!', @json(session('success')), 'success').then(() => {
      window.location.href = "{{ route('g2form.list') }}";
    });
  }
</script>
@elseif(session('fail'))
<script>
  window.onload = function() {
    Swal.fire('Info!', @json(session('fail')), 'info');
  }
</script>
@endif

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
    /* ✅ vertical center alignment */
    gap: 8px;
    /* ✅ proper spacing between elements */
    margin: 2px 0;
  }

  .other-input {
    margin-top: 0 !important;
    /* ❌ remove top gap */
    height: 32px;
    /* ✅ match checkbox line height */
    padding: 4px 8px;
  }

  .option-item input[type="checkbox"],
  .option-item input[type="radio"] {
    width: 18px;
    height: 18px;
    margin-right: 8px;
    flex-shrink: 0;
    accent-color: #007bff;
    cursor: pointer;
  }

  /* ✅ Keep color even if disabled (if used later) */
  .option-item input:disabled {
    opacity: 1 !important;
  }

  .other-input {
    margin-top: 12px;
    width: 100%;
    max-width: 300px;
  }

  select.form-control {
    color: #000 !important;
  }

  .form-group p {
    margin-bottom: 5px;
    /* reduce description gap */
  }

  .option-item {
    margin: 2px 0;
    /* tighter spacing */
  }

  .option-item.pt-3 {
    padding-top: 2px !important;
    /* remove large gap */
  }

  .options-grid {
    gap: 5px 10px;
    /* reduce vertical gap */
  }

  /* Mobile Responsive Overrides */
  @media (max-width: 768px) {
    .main-content {
      padding: 5px !important;
    }

    #mobile-breadcrumb-wrapper .breadcrumb, 
    #mobile-breadcrumb-wrapper .breadcrumb-custom {
      margin-top: 60px !important;
      background: transparent !important;
      border: none !important;
      box-shadow: none !important;
      padding: 0 !important;
      display: flex !important;
      flex-wrap: wrap !important;
      align-items: center !important;
    }

    #mobile-breadcrumb-wrapper .breadcrumb * {
      background: transparent !important;
      border: none !important;
      box-shadow: none !important;
      margin: 0 !important;
      padding: 0 !important;
    }

    #mobile-breadcrumb-wrapper .breadcrumb li, 
    #mobile-breadcrumb-wrapper .breadcrumb-item {
      font-size: 13px !important;
      color: #495057 !important; /* Dark Gray for active text */
    }

    #mobile-breadcrumb-wrapper .breadcrumb a {
      font-size: 13px !important;
      color: #007bff !important; /* Blue color for links */
      text-decoration: none !important;
      border: none !important;
      border-top: none !important;
      border-bottom: none !important;
      outline: none !important;
    }

    #mobile-breadcrumb-wrapper .breadcrumb .active {
      font-size: 13px !important;
      color: #495057 !important; /* Dark Gray for active text */
      text-decoration: none !important;
      border: none !important;
    }

    /* Force hide all custom Elina ISMS chevrons and circular numbers using ID specificity */
    #mobile-breadcrumb-wrapper .breadcrumb *:before,
    #mobile-breadcrumb-wrapper .breadcrumb *:after,
    #mobile-breadcrumb-wrapper .breadcrumb *::before,
    #mobile-breadcrumb-wrapper .breadcrumb *::after {
      display: none !important;
      content: none !important;
      background: transparent !important;
      border: none !important;
      width: 0 !important;
      height: 0 !important;
    }

    #mobile-breadcrumb-wrapper .breadcrumb span {
      display: none !important;
    }

    /* Add the simple ">" arrow separator */
    #mobile-breadcrumb-wrapper .breadcrumb li + li::before {
      display: inline-block !important;
      content: " \003E " !important;
      color: #adb5bd !important;
      padding: 0 8px !important;
      font-weight: normal !important;
      position: static !important;
    }
    h4 {
      font-size: 14px !important;
      margin-top: 10px !important;
      margin-bottom: 10px !important;
      font-weight: bold !important;
    }

    .card-body {
      padding: 10px !important;
      max-height: 500px !important; /* Slightly more room on mobile */
    }

    .form-group {
      margin-bottom: 12px !important;
    }

    .form-group label {
      font-size: 13px !important;
      font-weight: bold !important;
    }

    .form-group p {
      font-size: 11px !important;
      margin-bottom: 8px !important;
    }

    .option-item label {
      font-size: 12px !important;
    }

    .btn {
      padding: 6px 12px !important;
      font-size: 12px !important;
      margin-bottom: 5px !important;
    }
  }
</style>

<div class="main-content">

  <div id="mobile-breadcrumb-wrapper">
    {{ Breadcrumbs::render('g2form.new' , $child_name) }}
  </div>

  <div class="row">
    <div class="col-lg-12 text-center">
      <h4 style="color:darkblue;">Parent Reflection Form ({{$child_name}})</h4>
    </div>

    <div class="col-12">
      <div class="card">

        <form action="{{route('g2form.store')}}" method="POST" id="gfrom">
          {{ csrf_field() }}

          <div class="card-body">

            @foreach($questions as $question)

            @php
            // ✅ Extract options
            $options = [];
            if(isset($question['other_option']) && !empty($question['other_option'])) {
            if ($question['field_types_id'] == 5) {
            // Checkbox: extracted using brackets
            preg_match_all('/\[(.*?)\]/', $question['other_option'], $matches);
            if(!empty($matches[1])) {
            $options = array_map('trim', $matches[1]);
            }
            } else {
            // Dropdown and Radio: extracted by splitting commas
            $options = array_filter(array_map('trim', explode(',', $question['other_option'])));
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
              @foreach($options as $opt)
              <div class="option-item mt-1">
                <input type="radio"
                  name="answer[{{$question['question_column_name']}}]"
                  value="{{ $opt }}"
                  data-required="{{$question['required']}}"
                  {{ $value == $opt ? 'checked' : '' }}
                  style="{{ $isDisabled ? 'pointer-events: none;' : '' }}"
                  {{ $isDisabled ? 'tabindex="-1"' : '' }}>
                <label>{{ $opt }}</label>
              </div>
              @endforeach

              {{-- CHECKBOX --}}
              @elseif($question['field_types_id'] == 5)

              @foreach($options as $opt)
              <div class="option-item mt-1">
                <input type="checkbox"
                  name="answer[{{$question['question_column_name']}}][]"
                  value="{{ $opt }}"
                  data-required="{{$question['required']}}"
                  {{ in_array($opt, $selectedValues) ? 'checked' : '' }}
                  style="{{ $isDisabled ? 'pointer-events: none;' : '' }}"
                  {{ $isDisabled ? 'tabindex="-1"' : '' }}>
                <label class="option-item pt-1">{{ $opt }}</label>
              </div>
              @endforeach

              {{-- OTHERS --}}
              <div class="option-item mt-1">
                <input type="checkbox"
                  class="other-check"
                  {{ $otherValue ? 'checked' : '' }}
                  style="{{ $isDisabled ? 'pointer-events: none;' : '' }}"
                  {{ $isDisabled ? 'tabindex="-1"' : '' }}>

                <label class="mb-0">Others</label>

                <input type="text"
                  class="form-control other-input ml-2"
                  name="other[{{$question['question_column_name']}}]"
                  value="{{ $otherValue }}"
                  placeholder="Please enter your input"
                  style="{{ $otherValue ? 'display:inline-block; width: auto;' : 'display:none; width: auto;' }}"
                  {{ $isDisabled ? 'readonly' : '' }}>
              </div>

              @endif

            </div>

            @endforeach

          </div>

          <div class="text-center mb-3">
            <input type="hidden" id="type" name="type">
            <input type="hidden" name="enrollment_id" value="{{$enrollId}}">

            @if(!$isDisabled)
            <button type="button" class="btn btn-warning" onclick="saveForm()">Save</button>
            <button type="button" class="btn btn-success" onclick="validateanswer()">Submit</button>
            <a href="{{ route('g2form.list') }}" class="btn btn-danger">Cancel</a>
            @else
            <a href="{{ route('g2form.list') }}" class="btn btn-danger">Close</a>
            @endif
          </div>

        </form>

      </div>
    </div>
  </div>
</div>

<script>
  $(document).on('change', '.other-check', function() {
    let input = $(this).closest('.option-item').find('.other-input');

    if ($(this).is(':checked')) {
      input.css('display', 'inline-block');
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
    let isValid = true;

    // TEXTAREA & SELECT
    $('textarea[data-required="1"], select[data-required="1"]').each(function() {
      if ($.trim($(this).val()) === '') {
        isValid = false;
        return false;
      }
    });

    // RADIO (group validation)
    let radioNames = new Set();
    $('input[type="radio"][data-required="1"]').each(function() {
      radioNames.add($(this).attr('name'));
    });

    for (let name of radioNames) {
      if (!$('input[name="' + name + '"]:checked').length) {
        isValid = false;
        break;
      }
    }

    // CHECKBOX (group validation)
    let checkboxNames = new Set();
    $('input[type="checkbox"][data-required="1"]').each(function() {
      checkboxNames.add($(this).attr('name'));
    });

    for (let name of checkboxNames) {
      let isStandardChecked = $('input[name="' + name + '"]:checked').length > 0;
      let isOtherChecked = $('input[name="' + name + '"]').closest('.form-group').find('.other-check:checked').length > 0;

      if (!isStandardChecked && !isOtherChecked) {
        isValid = false;
        break;
      }
    }

    if (!isValid) {
      Swal.fire('Warning!', 'Please fill all mandatory fields.', 'warning');
      return;
    }

    Swal.fire({
      title: 'Are you sure?',
      text: "Do you want to submit this form?",
      icon: 'question',
      showCancelButton: true,
      confirmButtonText: 'Yes, submit it!'
    }).then((result) => {
      if (result.isConfirmed) {
        document.getElementById("type").value = "Submitted";
        document.getElementById('gfrom').submit();
      }
    });
  }

  function saveForm() {
    Swal.fire({
      title: 'Are you sure?',
      text: "Do you want to save this form?",
      icon: 'info',
      showCancelButton: true,
      confirmButtonText: 'Yes, save it!'
    }).then((result) => {
      if (result.isConfirmed) {
        document.getElementById("type").value = "Saved";
        document.getElementById('gfrom').submit();
      }
    });
  }
</script>

@endsection