@extends('layouts.adminnav')

@section('content')
<style>
  #frname {
    color: red;
  }

  .form-control {
    background-color: #ffffff !important;
  }

  .is-coordinate {
    justify-content: center;
  }

  .centerid {
    width: 100%;
    text-align: center;
  }
</style>

<div class="main-content">
  <!-- Main Content -->
  <section class="section">
    <div class="section-body mt-1">
      <h5 class="text-center" style="color:darkblue">Questionnaire Initiation</h5>
      @foreach($rows as $key=>$row)
      <form method="POST" id="enrollement" action="{{ route('sail.update', \Crypt::encrypt($row['questionnaire_initiation_id'])) }}">
        {{ csrf_field() }}
        @method('PUT')
        @endforeach
        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-body">
                <div class="row is-coordinate">
                  <div class="col-md-4">
                    <div class="form-group">
                      <label class="control-label required">Enrollment Number</label>
                      <input class="form-control" name="enrollment_child_num" value="{{ $row['enrollment_child_num']}}" placeholder="Enrollment ID" required>
                    </div>
                  </div>
                  <input type="hidden" value="{{ $row['enrollment_id']}}" name="enrollment_id">
                  <input type="hidden" value="{{$row['user_id']}}" id="user_id" name="user_id">
                  <div class="col-md-4">
                    <div class="form-group">
                      <label class="control-label required">Child ID</label>
                      <input class="form-control" type="text" id="child_id" name="child_id" value="{{ $row['child_id']}}" placeholder="" required autocomplete="off">
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group">
                      <label class="control-label required">Child Name</label>
                      <input class="form-control" type="text" id="child_name" name="child_name" value="{{ $row['child_id']}}" placeholder="Enter Name" required autocomplete="off">
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <br>
        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-body">
                <div class="form-group row" style="margin-bottom: 5px;">
                  <div class="col-md-6">
                    <label class="col-sm-6 control-label col-form-label">Questionnaire Name<span class="error-star" style="color:red;">*</span></label>
                    <select class="form-control" id="questionnaire_id" name="questionnaire_id" style="pointer-events: none;cursor: not-allowed;">
                      <option value="{{ $row['questionnaire_id']}}">{{ $row['questionnaire_name']}}</option>
                    </select>
                  </div>
                  <input type="hidden" value="{{ $row['questionnaire_name']}}" name="questionnaire_name">
                  <div class="col-md-6">
                    <label class="col-sm-3 control-label col-form-label">Status</label> <br>
                    <input class="form-control" type="text" id="payment_status" name="status" value="{{ $row['status']}}" autocomplete="off" readonly>
                  </div>
                  <input type="hidden" id="btn_status" name="btn_status" value="">
                </div>
              </div>
            </div>
          </div>
          <div class="row text-center pt-3">
            <div class="col-md-12">
              <a type="button" onclick="save()" id="submitbutton" class="btn btn-labeled btn-succes" title="Submit" style="background: green !important; border-color:green !important; color:white !important">
                <span class="btn-label" style="font-size:13px !important;"><i class="fa fa-check"></i></span> Submit</a>
              <a type="button" class="btn btn-labeled back-btn" title="Back" href="{{ route('sail.index') }}" style="color:white !important">
                <span class="btn-label" style="font-size:13px !important;"><i class="fa fa-arrow-left"></i></span> Back</a>
            </div>
          </div>
        </div>
      </form>
    </div>
  </section>
</div>


<script type="text/javascript">
  tinymce.init({
    selector: 'textarea#description',
    height: 180,
    menubar: false,
    branding: false,
    plugins: [
      'advlist autolink lists link image charmap print preview anchor',
      'searchreplace visualblocks code fullscreen',
      'insertdatetime media table paste code help wordcount'
    ],
    toolbar: 'undo redo | formatselect | ' +
      'bold italic backcolor | alignleft aligncenter ' +
      'alignright alignjustify | bullist numlist outdent indent | ' +
      'removeformat | help',
    content_style: 'body { font-family:Helvetica,Arial,sans-serif; font-size:14px }'
  });
</script>
<script>
  function save() {
    var questionnaire_id = $('#questionnaire_id').val();
    if (questionnaire_id == '') {
      swal.fire("Please Enter Questionnaire Name:  ", "", "error");
      return false;
    }
    document.getElementById('btn_status').value = 'Sent';
    document.getElementById('enrollement').submit();
  }
</script>


@endsection