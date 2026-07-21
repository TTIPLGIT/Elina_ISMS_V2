@extends('layouts.adminnav')

@section('content')

<style>
  /* ----- General styles (unchanged) ----- */
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
    width: 18px;
    height: 18px;
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

  .option-item input:disabled {
    opacity: 1 !important;
  }

  /* ----- NEW LAYOUT: Full-height card with sticky buttons ----- */
  .full-height-card {
    display: flex;
    flex-direction: column;
    height: 75vh;               /* Adjust as needed; use calc(100vh - header) if required */
    min-height: 400px;
  }

  .full-height-card .card-body {
    flex: 1;
    overflow-y: auto;
    padding: 15px;
  }

  .full-height-card .card-footer {
    border-top: 1px solid rgba(0,0,0,.125);
    padding: 12px 15px;
    background: #fff;
    flex-shrink: 0;
    text-align: center;
  }

  /* ----- Mobile responsive overrides (kept, with minor adjustments) ----- */
  @media (max-width: 768px) {
    .form-control, .form-group textarea, .form-group select {
      background-color: transparent !important;
      border: none !important;
      border-bottom: 1px solid #ced4da !important;
      border-radius: 0 !important;
      padding: 8px 0 !important;
      font-size: 13px !important;
      font-weight: 600 !important;
      color: #1a1a1a !important;
      font-family: 'Barlow Semi Condensed', sans-serif !important;
      box-shadow: none !important;
      min-height: auto !important;
    }

    .form-control:focus {
      border-bottom: 2px solid #007bff !important;
      background-color: transparent !important;
    }

    .form-control[readonly], .form-control:disabled {
      background-color: transparent !important;
      border-bottom: 1px dashed #ccc !important;
    }

    .main-content {
      padding: 5px !important;
    }

    /* Breadcrumb adjustments (unchanged) */
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
    #mobile-breadcrumb-wrapper .breadcrumb a, 
    #mobile-breadcrumb-wrapper .breadcrumb .active,
    #mobile-breadcrumb-wrapper .breadcrumb-item {
      font-size: 13px !important;
      color: #e83e8c !important;
    }

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

    .full-height-card .card-body {
      padding: 10px !important;
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

    /* Mobile Breadcrumb Fix */
    .breadcrumb-wrapper {
      width: 100% !important;
      overflow: hidden !important;
    }

    .breadcrumb-wrapper .breadcrumb {
      margin-top: 60px !important;
      padding: 0 !important;
      background: transparent !important;
      white-space: nowrap !important;
      overflow-x: auto !important;
      overflow-y: hidden !important;
      flex-wrap: nowrap !important;
      display: flex !important;
      align-items: center !important;
      scrollbar-width: none !important;
    }

    .breadcrumb-wrapper .breadcrumb::-webkit-scrollbar {
      display: none !important;
    }

    .breadcrumb-wrapper .breadcrumb li,
    .breadcrumb-wrapper .breadcrumb a,
    .breadcrumb-wrapper .breadcrumb .active,
    .breadcrumb-wrapper .breadcrumb-item {
      font-size: 11px !important;
      white-space: nowrap !important;
      flex-shrink: 0 !important;
    }

    h4 {
      font-size: 13px !important;
      margin-top: 8px !important;
      margin-bottom: 8px !important;
    }

    .full-height-card {
      height: 70vh;        /* Slightly shorter on mobile for better fit */
      min-height: 350px;
    }

    .full-height-card .card-footer {
      padding: 8px 10px !important;
    }

    .btn {
      padding: 5px 10px !important;
      font-size: 11px !important;
    }
  }
</style>

<div class="main-content">

  <div class="breadcrumb-wrapper">
    {{ Breadcrumbs::render('g2form.new' , $child_name) }}
  </div>

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

  <div class="row">
    <div class="col-lg-12 text-center">
      <h4 style="color:darkblue;">Parent Reflection Form ({{$child_name}})</h4>
    </div>

    <div class="col-12">
      {{-- Card now uses the flex layout --}}
      <div class="card full-height-card">

        <form action="{{route('g2form.store')}}" method="POST" id="gfrom">
          {{ csrf_field() }}

          {{-- Scrollable body --}}
          <div class="card-body">
            @foreach($questions as $question)

            @php
            $options = [];
            if(isset($question['other_option']) && !empty($question['other_option'])){
              if ($question['field_types_id'] == 5) {
                preg_match_all('/\[(.*?)\]/', $question['other_option'], $matches);
                if(!empty($matches[1])){
                  $options = array_map('trim', $matches[1]);
                }
              } else {
                $options = array_filter(array_map('trim', explode(',', $question['other_option'])));
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

              @if(!empty($question['question_description']))
              <p>{!! $question['question_description'] !!}</p>
              @endif

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
                    style="{{ $isDisabled ? 'pointer-events: none;' : '' }}"
                  {{ $isDisabled ? 'tabindex="-1"' : '' }}>
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
                    style="{{ $isDisabled ? 'pointer-events: none;' : '' }}"
                  {{ $isDisabled ? 'tabindex="-1"' : '' }}>
                  <label class="option-item pt-2">{{ $opt }}</label>
                </div>
                @endforeach
              </div>

              {{-- OTHERS --}}
              <div class="option-item mt-2">
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
                  placeholder="Enter other value"
                  style="{{ $otherValue ? 'display:inline-block; width: auto;' : 'display:none; width: auto;' }}"
                  {{ $isDisabled ? 'readonly' : '' }}>
              </div>

              @endif

            </div>

            @endforeach
          </div>

          {{-- Fixed footer with buttons --}}
          <div class="card-footer">
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

{{-- JS (unchanged) --}}
<script>
  $(document).on('change', '.other-check', function() {
    let input = $(this).closest('.form-group').find('.other-input');

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