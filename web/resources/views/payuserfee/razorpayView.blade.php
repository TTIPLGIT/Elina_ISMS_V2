
<div style="height: 100% !important;">

<!-- Main Content -->
<section class="section">


  <div class="section-body mt-1">
        <main class="py-0">
            <div class="container">
                <div class="row" style="justify-content:center !important">
                    <div class="col-md-6 offset-3 col-md-offset-6"style=" display: flex; justify-content: center;">
  
                        @if($message = Session::get('error'))
                            <div class="alert alert-danger alert-dismissible fade in" role="alert">
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">×</span>
                                </button>
                                <strong>Error!</strong> {{ $message }}
                            </div>
                        @endif
  
                        @if($message = Session::get('success'))
                            <div class="alert alert-success alert-dismissible fade {{ Session::has('success') ? 'show' : 'in' }}" role="alert">
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">×</span>
                                </button>
                                <strong>Success!</strong> {{ $message }}
                            </div>
                        @endif
  
                    
                                <form action="{{ route('payuserfee.store') }}" method="POST" >
                                    @csrf
                                    <input class="form-control paymentscreen" type="text" id="enrollment_child_num" name="enrollment_child_num" value="EN/2022/12/025 (Kaviya)" autocomplete="off">
                                    <input class="form-control paymentscreen" type="text" id="child_id" name="child_id" value="CH/2022/025" autocomplete="off">
                                    <input class="form-control paymentscreen" type="text" id="child_name" value="child_name" name="child_name" autocomplete="off">
                                    <input class="form-control paymentscreen" type="text" id="initiated_by" name="initiated_by" value=" elinaishead1@gmail.com" autocomplete="off">
                                    <input class="form-control paymentscreen" type="text" id="initiated_to" name="initiated_to" value=" Kaviya@talentakeaways.com" autocomplete="off">
                                    <input class="form-control paymentscreen" id="payment_amount" name="payment_amount" value="20000" autocomplete="off">
                                    <input class="form-control paymentscreen" type="text" id="payment_status" name="payment_status" value="New" autocomplete="off">
                                    <textarea class="form-control paymentscreen" type="textarea" id="payment_process_description" name="payment_process_description" value="kindly Pay Rs.20000 for your CoMPASS Registration">kindly Pay Rs.20000 for your CoMPASS Registration</textarea>
                                    <textarea class="form-control paymentscreen" type="textarea" id="notes" name="notes" value=""></textarea>
                                    <script src="https://checkout.razorpay.com/v1/checkout.js"
                                            data-key= "rzp_test_KUJc3PyWmtOLvw" 
                                            data-amount="2000000"
                                            data-buttontext="Proceed to Pay"
                                            data-name="Elinaservices.com"
                                            data-description="Rozerpay"
                                            data-image= "http://localhost:10/Elina ISMS\v1/web/public/asset/image/Elina-icon.JPG"
                                            data-prefill.name="name"
                                            data-prefill.email="Kaviya@talentakeaways.com"
                                            data-theme.color="green">
                                    </script>
              <a type="button" class="btn btn-labeled back-btn" title="Back" href="{{ route('payuserfee.index') }}" style="color:white !important">
        <span class="btn-label" style="font-size:13px !important;"><i class="fa fa-arrow-left"></i></span> Back</a>

                                </form>
                           
  
                    </div>
                </div>
            </div>
        </main>
  </div></section></div>