@extends('layouts.adminnav')

@section('content')
<style>
  .error {
    color: red;
    size: 80%
  }

  .hidden {
    display: none;
  }
</style>
<div class="main-content">
  <!-- Main Content -->
  <section class="section">
    {{ Breadcrumbs::render('profilepage') }}
    <div class="section-body mt-1">
      <h5 style="color:darkblue;text-align: center;">Profile Settings</h5>
      <div class="row">
        <div class="col-12">
          <div class="card">
            <div class="card-body">
              <form class="form-horizontal" method="post" name="profile" id="upload-image-form" enctype="multipart/form-data" autocomplete="off">

                @csrf
                <div class="row">


                  <input class="form-control" type="hidden" id="user_id" name="user_id" placeholder="Enter Module Name" value="{{ $one_row[0]['id'] }}">


                  <div class="col-md-6">
                    <div class="form-group">
                      <label class="control-label">User Name <span style="color: red;font-size: 16px;"></span></label>
                      <input class="form-control" type="text" id="name" name="name" placeholder="Enter User Name" value="{{ $one_row[0]['name'] }}" >
                      @error('name')
                      <div class="error">{{ $message }}</div>
                      @enderror
                    </div>
                  </div>


                  <div class="col-md-6">
                    <div class="form-group">
                      <label class="control-label">Email <span style="color: red;font-size: 16px;"></span></label>
                      <input class="form-control" type="email" id="email" name="email" placeholder="Enter Email" value="{{ $one_row[0]['email'] }}" >
                      @error('email')
                      <div class="error">{{ $message }}</div>
                      @enderror
                    </div>
                  </div>

                  @if($one_row[0]['mobile_no'] != "")
                  <div class="col-md-6">
                    <div class="form-group">
                      <label class="control-label">Phone Number <span style="color: red;font-size: 16px;"></span></label>
                      <input class="form-control" type="text" id="phone_number" name="phone_number" placeholder="Enter Phone Number" value="{{ $one_row[0]['mobile_no'] }}" autocomplete="off">
                      @error('phone_number')
                      <div class="error">{{ $message }}</div>
                      @enderror

                    </div>
                    @else
                    <div class="col-md-6">
                      <div class="form-group">
                        <label class="control-label">Phone Number <span style="color: red;font-size: 16px;"></span></label>
                        <input class="form-control" type="text" id="phone_number" name="phone_number" placeholder="Enter phone number 10 digits only" value="{{ $one_row[0]['mobile_no'] }}" autocomplete="off">
                        @error('phone_number')
                        <div class="error">{{ $message }}</div>
                        @enderror

                      </div>
                      @endif


<!-- 
                      <label style="color:#f30202!important">Notes</label>
                      <p> Validation Format -7872348272</p> -->


                      <div id="phone_error" class="error hidden">Please enter a valid phone number</div>

                    </div>


                    <div class="col-md-6">
                      <div class="form-group">
                        <label class="control-label">Profile Picture<span style="color: red;font-size: 16px;"></span></label>

                        <input class="form-control" type="file" id="signature_attachment" name="signature_attachment" placeholder="Enter Signature Attachment" value="{{ $one_row[0]['profile_image'] }}" multiple accept="image/*" style="padding: 3px 6px;margin: 0px;">

                        <input type="hidden" name="signature" id="signature" value="{{ $one_row[0]['profile_image'] }}">
                        <br>
                        @if($one_row[0]['profile_image'] != "")
                        <img src="{{ $one_row[0]['profile_image'] }}" style="border-radius:50% ;" id="profile_pic" alt="" width="100" height="100"><br>
                        <label for="vehicle1" id="width1">Width:90cm to 200cm<i id="color5"></i> </label><br>

                        <label for="height" id="height1">Height:70cm to 200cm<i id="color6"></i></label><br>
                        <label for="filesize" id="filesize1">Maximum File Size:2MB <i id="color7"></i> </label><br>
                        <label for="type" id="type1">Image Type:PNG,JPEG or JPG <i id="color8"></i></label><br>


                        @endif

                        @error('profile_image')
                        <div class="error">{{ $message }}</div>
                        @enderror
                      </div>
                    </div>
                    <input class="form-control" type="hidden" id="user_type" name="user_type" placeholder="Enter Password" value="AD">


                  </div>

                  <div class="row text-center">
                    <div class="col-md-12">

                      <button class="btn btn-success" id="update_button" type="submit"><i class="fa fa-check"></i> Update </button>&nbsp;
                      <button class="btn btn-primary" type="reset"><i class="fa fa-undo"></i> Undo </button>&nbsp;
                      <a class="btn btn-danger" href="{{ route('home') }}"><i class="fa fa-times" aria-hidden="true"></i> Cancel </a>&nbsp;
                    </div>
                  </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</div>
<script src="https://cdn.jsdelivr.net/jquery.validation/1.15.1/jquery.validate.min.js"></script>
<script>
  $('#phone_number').change(function(e) {
    document.getElementById('update_button').disabled = false;
  });
  var _URL = window.URL || window.webkitURL;
  $("#signature_attachment").change(function(e) {




    if ((file = this.files[0])) {

      if (file) {

        var img_url = URL.createObjectURL(file);
        // $('#blah').attr('src',img_url);
        // document.getElementById("blah").style.backgroundImage = "url('"+img_url+"')";
      }
      var file, img;
      img = new Image();


      img.onload = function() {

        if ((this.width >= '425') && (this.width <= '625')) {

          $('#color5').addClass("preview_eye fa fa-check-circle");
          document.getElementById('color5').style.color = "green"
        } else {
          $('#color5').removeClass("preview_eye fa fa-check-circle");
          $('#color5').addClass("fa fa-times-circle");
          document.getElementById('color5').style.color = "red"
        }
        if ((this.height >= '425') && (this.height <= '625')) {

          $('#color6').addClass("preview_eye fa fa-check-circle");
          document.getElementById('color6').style.color = "green"
        } else {
          $('#color6').removeClass("preview_eye fa fa-check-circle");
          $('#color6').addClass("fa fa-times-circle");
          document.getElementById('color6').style.color = "red"
        }
        const fileType = file['type'];
        const validImageTypes = ['image/gif', 'image/jpeg', 'image/png'];
        if (!validImageTypes.includes(fileType)) {
          $('#color8').removeClass(" preview_eye fa fa-check-circle");
          $('#color8').addClass("fa fa-times-circle");
          document.getElementById('color8').style.color = "red"
        } else {

          $('#color8').addClass(" preview_eye fa fa-check-circle");
          document.getElementById('color8').style.color = "green"
        }
        fileupload_size = file.size / 1024;
        var fileupload1 = fileupload_size;


        if (fileupload1 <= '20480') {
          $('#color7').addClass("preview_eye fa fa-check-circle");
          document.getElementById('color7').style.color = "green"
        } else {
          $('#color7').removeClass("preview_eye fa fa-check-circle");
          $('#color7').addClass("fa fa-times-circle");
          document.getElementById('color7').style.color = "red"
        }
        var pr_len = $(".preview_eye").length;
        if (pr_len == '4') {
          $('#profile_pic').attr('src', this.src);
          document.getElementById('update_button').disabled = false;
        } else {
          document.getElementById('update_button').disabled = true;
          swal.fire({
            title: 'Warning',
            text: "Please Upload a Valid Profile Image!",
            icon: 'warning',

          });
        }


      };
    }
    img.src = _URL.createObjectURL(file);

  });


  $.ajaxSetup({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  });

  $('#upload-image-form').submit(function(e) {

    e.preventDefault();
    let formData = new FormData(this);
    console.log(formData);



    var confilter = /^\d{10}$/i;
    var con = confilter.test(document.profile.phone_number.value);
    var ph_no = document.getElementById('phone_number').value;
    if (ph_no != []) {
      if (con == false) {
        swal.fire({
          title: 'Warning',
          text: "Please Enter a Valid Phone Number!",
          icon: 'warning',

        });
        document.profile.phone_number.focus();
        return false;
      }
    }
    var signature = $('#signature').val();
    var signature_attachment = $('#signature_attachment').val();
    $.ajax({
      type: 'POST',
      url: '/profile_update',
      data: formData,
      contentType: false,
      processData: false,
      success: (response) => {
        if (response) {

          Swal.fire(
            'Success!',
            'Profile Settings Uploaded Succesfully!',
            'success'
          )
        }
      },
      error: function(response) {

        $('#image-input-error').text(response.responseJSON.errors.file);
      }
    });
  });
</script>
<!-- <script type="text/javascript">
    $("#phone_number").keydown(function(event) {
  k = event.which;
  if ((k >= 96 && k <= 105) || k == 8) {
    if ($(this).val().length == 10) {
      if (k == 8) {
        return true;
      } else {
        event.preventDefault();
        return false;

      }
    }
  } else {
    event.preventDefault();
    return false;
  }

});
</script> -->
@endsection