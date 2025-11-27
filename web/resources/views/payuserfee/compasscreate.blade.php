@extends('layouts.adminnav')

@section('content')
<style>
  #frname {
    color: red;
  }

  .centerid {
    width: 100%;
    text-align: center;
  }

  .paymentdetails {
    color: darkblue;
    padding-top: 1rem;
    margin: auto;
    justify-content: center;
  }

  .payinitiate {
    margin: auto;
  }

  .form-note {
    width: 30%;
    display: flex;
    justify-content: center;
    margin: auto;
  }

  .control-notes {
    display: flex;
    justify-content: center;
    font-weight: 800 !important;
    color: #34395e !important;
    font-size: 15px !important;
  }

  .razorpay-payment-button {
    background-color: green;
    border-color: green;
    color: white;
    font-weight: 200;
    padding: 6px;
    border-radius: 10px;
  }

  .paymentscreen {
    display: none !important;
  }
  
</style>
<meta name="csrf-token" content="{{ csrf_token() }}">
<div class="main-content " style="height: 100% !important">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.16/dist/sweetalert2.all.min.js"></script>

  <!-- Main Content -->
  <section class="section">
  {{ Breadcrumbs::render('payuserfee.create') }}



    <div class="section-body mt-1">
      <h5 class="text-center" style="color:darkblue">Header Details</h5>

      <div class="row">
        <div class="col-12">

          <div class="card">
            <div class="card-body">

              @csrf
              
              <div class="row">
                <div class="col-md-4">
                  <div class="form-group">
                    <label class="control-label">Enrollment Number</label><span class="error-star" style="color:red;">*</span>
                    <input class="form-control" type="text" id="enrollment_child_num" name="enrollment_child_num" value="EN/2022/12/025 (Kaviya)" autocomplete="off" disabled>
                  </div>
                </div>


                <div class="col-md-4">
                  <div class="form-group">
                    <label class="control-label">Child ID</label><span class="error-star" style="color:red;">*</span>
                    <input class="form-control" type="text" id="child_id" name="child_id" value="CH/2022/025" autocomplete="off" disabled>
                  </div>
                </div>
                <br>


                <div class="col-md-4">
                  <div class="form-group">
                    <label class="control-label">Child Name</label><span class="error-star" style="color:red;">*</span>
                    <input class="form-control" type="text" id="child_name" value="Kaviya" name="child_name" autocomplete="off" disabled>
                  </div>
                </div>


              </div>




            </div>
          </div>
        </div>
      </div>
      


      <h5 class="text-center paymentdetails" style="color:darkblue">Payment Details</h5>
      <br>
      <div class="row">
        <div class="col-12" style="padding-top: 12px;">

          <div class="card">
            <div class="card-body">


              @csrf
              <div class="row">
                <div class="col-md-3">
                  <div class="form-group">
                    <label class="control-label">Initiated By</label><span class="error-star" style="color:red;">*</span>
                    <input class="form-control" type="text" id="initiated_by" name="initiated_by" value=" elinaishead1@gmail.com" autocomplete="off" disabled>


                  </div>
                </div>

                <div class="col-md-3">
                  <div class="form-group">
                    <label class="control-label">Initiated To</label><span class="error-star" style="color:red;">*</span>
                    <input class="form-control" type="text" id="initiated_to" name="initiated_to" value=" Kaviya@talentakeaways.com" autocomplete="off" disabled>

                  </div>
                </div>


                <div class="col-md-3">
                  <div class="form-group">
                    <label class="control-label">Payment Fee(INR)</label><span class="error-star" style="color:red;">*</span>
                    <input class="form-control" id="payment_amount" name="payment_amount" value="20000" disabled autocomplete="off">
                  </div>
                </div>
                <br>


                <div class="col-md-3">
                  <div class="form-group">
                    <label class="control-label">Status</label>
                    <input class="form-control" type="text" id="payment_status" name="payment_status" value="New" disabled autocomplete="off">
                  </div>
                </div>




              </div>
              <div class="form-notes">
                <label class="control-notes">Info</label>
                <textarea class="form-control form-note" type="textarea" id="payment_process_description" name="payment_process_description" value="kindly Pay Rs.20000 for your CoMPASS Registration" readonly>kindly Pay Rs.20000 for your CoMPASS Registration</textarea>
              </div>




            </div>
          </div>
        </div>
      </div>

        <div class="col-md-12 text-center" style="padding-top: 1rem;">


          <!-- <a type="button" id="savebutton" href="{{url('razorpay-payment')}}" class="" title="save1">
            <span class="btn-label" style="font-size:13px !important;"><i class="fa fa-check"></i></span>Proceed to Pay</a>  -->
            <form action="{{route('razorpay.payment.store')}}" method="POST">
            {{ csrf_field() }}
             
<!-- <input type="button" onclick="func()"> -->
              <input type="hidden" name="_token" value="hqnZxRzkEAEjXCNXNPC7mbBJ1QXub32jfnCnHP6K">
         

              <!-- <input type="submit" value="Pay 500 INR" class="razorpay-payment-button"> -->
            </form>
        
        </div>













      </div>
  </section>
</div>


<script type="text/javascript">
function func(){

}
</script>
<script src="https://checkout.razorpay.com/v1/checkout.js"></script>
<script>
var SITEURL = '{{URL::to('')}}';
$.ajaxSetup({
headers: {
'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
}
}); 
$('#button').on('click', '.buy_now', function(e){
var totalAmount = $(this).attr("payment_amount");
var product_id =  $(this).attr("data-id");
console.log(totalAmount);

totalAmount = parseInt(totalAmount);
console.log(totalAmount);

var options = {
"key": "rzp_test_SYm5UF3bsPxKKR",
"amount": (totalAmount*100), // 2000 paise = INR 20
"name": "Tutsmake",
"description": "Payment",
"image": "//www.tutsmake.com/wp-content/uploads/2018/12/cropped-favicon-1024-1-180x180.png",
"handler": function (response){
window.location.href = SITEURL +'/'+ 'paysuccess?payment_id='+response.razorpay_payment_id+'&product_id='+product_id+'&amount='+totalAmount;
},
"prefill": {
"contact": '9988665544',
"email":   'tutsmake@gmail.com',
},
"theme": {
"color": "#528FF0"
}
};
var rzp1 = new Razorpay(options);
rzp1.open();
e.preventDefault();
});
/*document.getElementsClass('buy_plan1').onclick = function(e){
rzp1.open();
e.preventDefault();
}*/



</script>

@include('payuserfee.razorpayView')
<script>
  $('.razorpay-payment-button').click(function() {
    $(".loader").show();
  });
</script>




















@endsection