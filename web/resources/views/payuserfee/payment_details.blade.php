@extends('layouts.parent')
@section('content')
<style>
  b {
    color: black;
  }

  .qr-text {
    position: absolute;
    top: 39%;
    right: 9%;
  }

  .qr-code {
    width: 250px;
    height: 250px;
  }

  .modal {
    background-color: rgb(0, 0, 0);
    background-color: rgba(0, 0, 0, 0.8);
  }

  .modal-close {
    position: absolute;
    top: 27px;
    right: 5%;
    color: white;
    font-size: 40px;
    font-weight: bold;
    transition: 0.3s;
  }

  .modal-close:hover,
  .modal-close:focus {
    color: #bbb;
    text-decoration: none;
    cursor: pointer;
  }

  .modal-title {
    position: absolute;
    top: 20px;
    right: 40%;
    color: white;
    font-size: 40px;
    font-weight: bold;
    transition: 0.3s;
  }

  @media (max-width: 767px) {
    .modal-title {
      top: 150px;
      right: 25%;
      font-size: 35px;
    }

    .qr-text {
      position: inherit;
    }
  }
</style>
<div class="main-content">
  <!-- <section class="section"> -->
  <!-- <div class="section-body"> -->
  <h5 class="text-center" style="color:darkblue"><img style="width: 20px;" src="{{asset('upi.png')}}" /> Scan To Pay</h5>
  <div style="text-align: center;">
    <h5 class="qr-text"> Your Payable Amount: Rs.{{$amount}}/-</h5>
    @if(config('app.env') != 'local')
    <img src="{{asset('\images\payment_QR.jpg')}}" alt="QR Code" title="Click To Maximize" style="cursor: pointer;" class="qr-code modal-target" onclick="toggleFullscreen(this)">
    @else
    <img src="{{asset('\images\elinaQR.png')}}" alt="QR Code" title="Click To Maximize" style="cursor: pointer;" class="qr-code modal-target" onclick="toggleFullscreen(this)">
    @endif
  </div>
  @if(config('app.env') != 'local')
  <h5 style="text-align: center;">UPI ID: <b>9841050686@pz</b></h5>
  <div style="text-align: center;">
    <!-- <h6></h6> -->
    <p style="font-size: 16px;"><b>[OR]</b></p>
    <!-- <h2>Details</h2> -->
    <h5>Account Name: <b>Vimarshi Solutions Pvt Ltd</b></h5>
    <h5>Bank and branch: <b>HDFC Bank, Karapakkam Branch</b></h5>
    <h5>Account No: <b>50200082225802</b></h5>
    <h5>Account type: <b>Current Account</b></h5>
    <h5>IFSC: <b>HDFC0001852</b></h5>
  </div>
  @else
  <h5 style="text-align: center;">UPI ID: <b>9876543210@pz</b></h5>
  <div style="text-align: center;">
    <!-- <h6></h6> -->
    <p style="font-size: 16px;"><b>[OR]</b></p>
    <!-- <h2>Details</h2> -->
    <h5>Account Name: <b>Vimarshi Solutions Pvt Ltd</b></h5>
    <h5>Bank and branch: <b>HDFC Bank, Karapakkam Branch</b></h5>
    <h5>Account No: <b>123456789011</b></h5>
    <h5>Account type: <b>Current Account</b></h5>
    <h5>IFSC: <b>HDFC0000123</b></h5>
  </div>
  @endif
  <!-- </div> -->
  <!-- </section> -->
  <div class="col-md-12 text-center">
    <a type="button" onclick="clickedOk()" id="submitbutton" class="btn btn-labeled btn-succes" title="Confirm Payment" style="background: green !important; border-color:green !important; color:white !important">
      <span class="btn-label" style="font-size:13px !important;"><i class="fa fa-check"></i></span> Confirm Payment </a>
      <a type="button" href="{{ route('payuserfee.index') }}" class="btn btn-labeled responsive-button button-style back-button" title="Back">
    <i class="fas fa-arrow-left"></i><span> Back </span>
</a>
  </div>
</div>
<div id="modal" class="modal"><span style="color: white;text-align:center">Tap on QR Code to Download</span>
  <span onclick="closemodalimg()" id="modal-close" class="modal-close">&times;</span>
  <!-- <span class="modal-title"><img style="width: 20px;" src="{{asset('upi.png')}}" /> Scan To Pay</span> -->
  <div class="modal-dialog modal-dialog-centered" role="document">
  <a href="{{asset('\images\elinaQR.png')}}" download>
    <img id="modal-content" class="modal-content"></a>
    <!-- <div id="modal-caption" class="modal-caption"></div> -->
  </div>
</div>

<input type="hidden" value="{{$rows[0]['payment_status_id']}}" id="payment_status_id" name="payment_status_id">
<input type="hidden" id="initiated_to" name="initiated_to" value=" {{$rows[0]['initiated_to'] }}" autocomplete="off">
<input type="hidden" id="payment_type" name="payment_type" value="{{$rows[0]['payment_type']}}">
<script>
  function toggleFullscreen(img) {
    img.classList.toggle('fullscreen');
  }

  var modal = document.getElementById('modal');

  var modalClose = document.getElementById('modal-close');
  modalClose.addEventListener('click', function() {
    modal.style.display = "none";
  });

  document.addEventListener('click', function(e) {
    if (e.target.className.indexOf('modal-target') !== -1) {
      var img = e.target;
      var modalImg = document.getElementById("modal-content");
      var captionText = document.getElementById("modal-caption");
      modal.style.display = "block";
      modalImg.src = img.src;
      captionText.innerHTML = img.alt;
    }
  });

  function clickedOk() {
    var payment_status_id = document.getElementById('payment_status_id').value;
    var initiated_to = document.getElementById('initiated_to').value;
    var payment_type = document.getElementById('payment_type').value;
    Swal.fire({
      icon: 'info',
      html: 'Thank you for the Payment Confirmation. Once the payment got reflected in the above-sent account, the payment receipt will be sent to your registered Email ID',
      showConfirmButton: true
    }).then(function() {
      window.location = "/payuserfee";
    });

    // if (payment_type == 1) {
    //   Swal.fire({
    //     icon: 'info',
    //     // title: 'Payment Details Sent',
    //     // html: '<span style="font-weight: 900;color:red"> If you are not paid </span> - Payment Details has been sent <span style="font-weight: 900;color:red"> AGAIN </span> to your Registered Email <br> [or] <br> Use below details/ Scan the UPI detail.',
    //     html: 'Payment Details Already Sent To Your Registered Email.',
    //     showConfirmButton: true
    //   }).then(function() {
    //     window.location = "/payuserfee";
    //   });
    // } else {
    //   $('.loader').show();
    //   $.ajax({
    //     url: "{{ route('payment.offline.request') }}",
    //     type: 'post',
    //     data: {
    //       payment_status_id: payment_status_id,
    //       initiated_to: initiated_to,
    //       payment_type: payment_type,
    //       _token: '{{csrf_token()}}'
    //     },
    //     error: function() {
    //       window.location = "/payuserfee";
    //       // alert('Something is wrong');
    //     },
    //     success: function(data) {
    //       $('.loader').hide();

    //       // swal.fire("Success", "Payment Details have been sent to your Registered Email [or] Use the below details/ Scan the UPI detail.", "success");
    //       swal.fire("Payment Details Sent", "Payment Details have been sent to your Registered Email for Future referance.", "success").then(function() {
    //         window.location = "/payuserfee";
    //       });


    //       // swal.fire("Success", "Payment Details have been sent to your Registered Email [or] Use the below details/ Scan the UPI detail.", "success").then(function() {
    //       //   window.location = "/payuserfee";
    //       // });

    //       // var IMAGE_URL = "{{asset('upi.png')}}";
    //       // // console.log(IMAGE_URL);
    //       // Swal.fire({
    //       //   icon: 'info',
    //       //   title: 'Info',
    //       //   html: 'Payment Details has been sent to your Email <br> [or] <br> Use <img style="width: 20px;" src="' + IMAGE_URL + '"/> UPI Payment <span style="font-weight: 900;">9841050686@pz</span>',
    //       //   showConfirmButton: true
    //       // }).then(function() {
    //       //   window.location = "/payuserfee";
    //       // });
    //     }
    //   });
    // }

  }
</script>
<script type="text/javascript">
  var payment_type = document.getElementById('payment_type').value;
  if (payment_type != 1) {
    window.onload = function() {
      swal.fire("Info", 'To pay and continue, either scan the UPI ID or use the payment information below.', "info");
    }
  }
</script>
@endsection