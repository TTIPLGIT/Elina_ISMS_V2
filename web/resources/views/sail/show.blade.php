@extends('layouts.adminnav')

@section('content')
<style>
  #frname {
    color: red;
  }
  .form-control{
    background-color: #ffffff !important;
}
  .is-coordinate{
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
      <div class="row">
        <div class="col-12">

          <div class="card">
            <div class="card-body">
            @foreach($rows as $key=>$row) 
              <form method="POST" action="">
            @endforeach
                @csrf
                <div class="row is-coordinate">
                  <div class="col-md-4">
                    <div class="form-group">
                      <label class="control-label">Enrollment ID</label><span class="error-star" style="color:red;">*</span>
                      <input class="form-control" name="enrollment_id" value="{{ $row['enrollment_child_num']}}" placeholder="Enrollment ID" required>
                    </div>
                  </div>


                  <div class="col-md-4">
                    <div class="form-group">
                      <label class="control-label">Child ID</label><span class="error-star" style="color:red;">*</span>
                      <input class="form-control" type="text" id="child_id" name="child_id"  value="{{ $row['child_id']}}" disabled="" placeholder="" required autocomplete="off">
                    </div>
                  </div>
                  


                  <div class="col-md-4">
                    <div class="form-group">
                      <label class="control-label">Child Name</label><span class="error-star" style="color:red;">*</span>
                      <input class="form-control" type="text" id="child_name" name="child_name"  value="{{ $row['child_name']}}" disabled="" placeholder="Enter Name" required autocomplete="off">
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
                  <input class="form-control" type="text" id="questionnaire_id" name="questionnaire_id" value="{{ $row['questionnaire_name']}}" disabled="" placeholder="" required autocomplete="off">
                </div>
                         
                         

                          <div class="col-md-6">
                  <label class="col-sm-3 control-label col-form-label">Status</label> <br>

                  <input class="form-control" type="text" id="status" name="status" value="{{ $row['status']}}" disabled="" placeholder="" required autocomplete="off">


                </div>


                        </div>




                        

                      </div>
                      
                    </div>
                  </div>
                </div>
                <div class="row text-center">
                            <div class="col-md-12">

                                        <a type="button" class="btn btn-labeled back-btn" title="Back" href="{{ route('sail.index') }}" style="margin: 5px 0px 0px 0px;color:white !important">
                            <span class="btn-label" style="font-size:13px !important;"><i class="fa fa-arrow-left"></i></span> Back</a>
                            </div>
                        </div> 
              </form>

            
          
        </div>
      </div>




      <br>

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
  }
    );  
  
</script>


@endsection