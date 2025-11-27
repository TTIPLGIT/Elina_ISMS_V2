@extends('layouts.parent')

@section('content')
<style>



</style>
<div class="main-content">

  {{ Breadcrumbs::render('g2form.new' , $child_name) }}
  @if (session('success'))
  <input type="hidden" name="session_data" id="session_data" class="session_data" value="{{ session('success') }}">
  <script type="text/javascript">
    window.onload = function() {
      var message = $('#session_data').val();
      Swal.fire('Success!', message, 'success');
    }
  </script>
  @elseif(session('fail'))
  <input type="hidden" name="session_data" id="session_data1" class="session_data" value="{{ session('fail') }}">
  <script type="text/javascript">
    window.onload = function() {
      var message = $('#session_data1').val();
      Swal.fire('Info!', message, 'info');
    }
  </script>
  @endif


  <div class="row">
    <div class="col-lg-12 text-center">
      <h4 style="color:darkblue;">Parent Reflection Form ({{$child_name}})</h4>
    </div>
    <p>Thank you so much for taking the time to share your story with us. Your thoughts and experience are truly important, and they help us support your child and family in the most caring way possible. We are here to listen, learn and support you in the best way possible. Please feel free to answer as openly and comfortably as you like- there are no right or wrong answers here.</p>
    <div class="col-12" style="padding: 0;">
      <div class="card">
        <form action="{{route('g2form.store')}}" method="POST" id="gfrom" name="gfrom" enctype="multipart/form-data">
          {{ csrf_field() }}
          <div class="card-body" style="max-height: 400px;overflow: scroll;">
            <!--  -->
            <div class="table-wrapper">
              <div class="table-responsive">
                <table class="table table-bordered">
                  <tbody>
                    @foreach($questions as $question)
                    <div class="form-group">
                      <label class="control-label{{ $question['required'] == '1' ? ' required' : '' }}">{{ $loop->iteration }}. {!! $question['question'] !!}</label>
                      <p>{!! $question['question_description'] !!}</p>
                      @if(isset($answers[0]))
                      <textarea class="form-control default" data-required="{{$question['required']}}" id="{{$question['question_column_name']}}" name="answer[{{$question['question_column_name']}}]" placeholder="Your Answer" {{ $answers[0]['status'] != 'Submitted' ? '' : 'disabled' }}>{{$answers[0][$question['question_column_name']]}}</textarea>
                      @else
                      <textarea class="form-control default" data-required="{{$question['required']}}" id="{{$question['question_column_name']}}" name="answer[{{$question['question_column_name']}}]" placeholder="Your Answer"></textarea>
                      @endif
                    </div>
                    @endforeach
                  </tbody>
                </table>
              </div>
            </div>
            <!--  -->
          </div>
          <div class="row text-center">
            <div class="col-md-12">
              <input type="hidden" id="type" name="type">
              <input type="hidden" id="enrollment_id" name="enrollment_id" value="{{$enrollId}}">
              @if(isset($answers[0]))
              @if($answers[0]['status'] != 'Submitted')
              <button type="submit" id="saved" class="btn btn-warning" name="type" value="Saved">Save</button>
              <a type="button" id="submit" class="btn btn-success" name="type" value="Submitted" onclick="validateanswer()">Submit</a>
              @endif
              @else
              <button type="submit" id="saved" class="btn btn-warning" name="type" value="Saved">Save</button>
              <a type="button" id="submit" class="btn btn-success" name="type" value="Submitted" onclick="validateanswer()">Submit</a>
              @endif
              <a type="button" href="{{ route('g2form.list') }}" class="btn btn-danger">Cancel</a>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<script>
  function validateanswer() {
    document.getElementById("type").value = "Submitted";

    var requiredTextareas = $('textarea[data-required="1"]');

    var isValid = true;

    requiredTextareas.each(function() {
      if ($.trim($(this).val()) === '') {
        isValid = false;
        return false;
      }
    });

    if (!isValid) {
      swal.fire('error', 'Please fill in all required question', 'error');
      return false;
    }

    document.getElementById('gfrom').submit();
  }
</script>
@endsection