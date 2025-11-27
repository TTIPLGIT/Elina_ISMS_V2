@extends('layouts.adminnav')
<script type="text/javascript" src="https://cdn.rawgit.com/t4t5/sweetalert/v0.2.0/lib/sweet-alert.min.js"></script>

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

  {{ Breadcrumbs::render('TherapistdetailsListedit',1) }}
    <div class="section-body mt-1">
    <h5 class="text-center" style="color:darkblue">Therapist Directory</h5>
      <div class="row">
        <div class="col-12">

          <div class="card">
            <div class="card-body">
            
            <form action="{{route('TherapistdetailsListupdate')}}" method="POST" id="orm" enctype="multipart/form-data">
          
                @csrf
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group" >
                      <label class="control-label">Name</label>
                      <input class="form-control" name="Therapist Name" value="Sumithra Shailesh"   required>
                    </div>
                  </div>


                  <div class="col-md-6">
                    <div class="form-group">
                      <label class="control-label">Area</label>
                      <input class="form-control" type="text" id="therapy_area" name="therapy_area"  value="Speech Therapy"   required autocomplete="off">
                    </div>
                  </div>
                </div>
                  

                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label class="control-label">Email</label>
                      <input class="form-control" type="email" id="therapist_mail" name="therapist_mail"  value="sumithra@elinaservices.in"  required autocomplete="off">
                    </div>
                  </div>

                  <div class="col-md-6">
                    <div class="form-group">
                      <label class="control-label">Phone Number</label>
                      <input class="form-control" type="text" id="phone_number" name="phone_number"  value="9778361562"  required autocomplete="off">
                    </div>
                  </div>
                </div>
                  
                
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label class="control-label">Location</label>
                      <input class="form-control" type="text" id="location" name="location"  value="Hiranandani"  required autocomplete="off">
                    </div>
                  </div>


                  <div class="row">
                    <div class="col-md-6">
                      <div class="form-group">
                        <label class="control-label">Address</label>
                        <textarea  id="address" name="address" value="Address" rows="3" cols="80">No.21/2,4th Durga Nagar,Hiranandani.</textarea>

                      </div>
                    </div>

                  <div class="row text-center">
                          <div class="col-md-12">
                          <button type="submit" href="{{route('TherapistdetailsListupdate')}}"class="btn btn-warning" name="type" value="saved">Saved</button>
                          <button type="" class="btn btn-danger text-white">Cancel</button> 
                            <!-- <button type="submit" class="btn btn-success" name="type" value="sent">Send</button>
                            
                          </div>


                </div>
                </div>
            </form>
                </div>
                </div>
            
    </div>
  </section>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/tinymce/4.5.6/tinymce.min.js"></script>
<script src="http://cdnjs.cloudflare.com/ajax/libs/tinymce/4.5.6/jquery.tinymce.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.26.0/moment.min.js"></script>
<script type="text/javascript">
  tinymce.init({
    selector: 'textarea#description',    
    height: 180,
    menubar: false,
    branding: false,
    toolbar: 'undo redo | formatselect | ' +
      'bold italic backcolor | alignleft aligncenter ' +
      'alignright alignjustify | bullist numlist outdent indent | ' +
      'removeformat | help',
    content_style: 'body { font-family:Helvetica,Arial,sans-serif; font-size:14px }'
  }
    );  
  
</script>

@endsection