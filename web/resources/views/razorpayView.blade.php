<div style="height: 100% !important;">

    <!-- Main Content -->
    <section class="section">


        <div class="section-body mt-1">
            <main class="py-0">
                <div class="container">
                    <div class="row" style="justify-content:center !important">
                        <div class="col-md-6 offset-3 col-md-offset-6" style=" display: flex; justify-content: center;">

                            <!-- @if($message = Session::get('error'))
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
                            @endif -->
                            @php $payment_amount = (int)$enrollment[0]['payment_amount'] ;
                            $payment_amount= $payment_amount * 100 ;@endphp

                            <form action="{{route('cash_store')}}" method="POST" id="paynow">
                                @csrf
                                <input type="hidden" value="{{$enrollment[0]['payment_status_id']}}" id="payment_status_id" name="payment_status_id">
                                <input class="form-control paymentscreen" type="text" id="payment_for" name="payment_for" value="{{$enrollment[0]['payment_for'] }}" autocomplete="off">
                                <input class="form-control paymentscreen" type="text" id="enrollment_child_num" name="enrollment_child_num" value="{{$enrollment[0]['enrollment_child_num'] }}" autocomplete="off">
                                <input class="form-control paymentscreen" type="text" id="child_id" name="child_id" value="{{$enrollment[0]['child_id'] }}" autocomplete="off">
                                <input class="form-control paymentscreen" type="text" id="child_name" value="{{$enrollment[0]['child_name'] }}" name="child_name" autocomplete="off">
                                <input class="form-control paymentscreen" type="text" id="initiated_by" name="initiated_by" value=" {{$enrollment[0]['initiated_by'] }}" autocomplete="off">
                                <input class="form-control paymentscreen" type="text" id="initiated_to" name="initiated_to" value=" {{$enrollment[0]['initiated_to'] }}" autocomplete="off">
                                <input class="form-control paymentscreen" type="text" id="enrollment_id" name="enrollment_id" value=" {{$rows[0]['enrollment_id'] }}" autocomplete="off">
                                <input class="form-control paymentscreen" type="text" id="phone_num" name="phone_num" value=" {{$rows[0]['child_contact_phone'] }}" autocomplete="off">
                                <input class="form-control paymentscreen" id="payment_amount" name="payment_amount" value="{{$enrollment[0]['payment_amount'] }}" autocomplete="off">
                                <input class="form-control paymentscreen" type="text" id="payment_status" name="payment_status" value="paid" autocomplete="off">
                                <textarea class="form-control paymentscreen" type="textarea" id="payment_process_description" name="payment_process_description" value="{{$enrollment[0]['payment_process_description'] }}">{{$enrollment[0]['payment_process_description']}}</textarea>
                                <textarea class="form-control paymentscreen" type="textarea" id="notes" name="notes" value=""></textarea>
                                <!-- <script src="https://checkout.razorpay.com/v1/checkout.js"
                                            data-key= "rzp_test_1PAtCSSLE3ibfW" 
                                            data-amount="{{$payment_amount}} "
                                            data-buttontext="Proceed to Pay"
                                            data-name="Elinaservices.com"
                                            data-description="Rozerpay"
                                            data-image= "http://localhost:10/Elina ISMS\v1/web/public/asset/image/Elina-icon.JPG"
                                            data-prefill.name="name"
                                            data-prefill.email="{{$enrollment[0]['initiated_to'] }}"
                                            data-theme.color="green">
                                    </script> -->
                                    
                            </form>
                            
                            <!-- <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#paymentModal">Launch</button> -->
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </section>
    <div class="col-md-12 text-center" style="padding: 0;margin:0;">
                                <a type="button" onclick="paynow()" id="submitbutton" class="btn btn-labeled btn-succes" title="Pay Now" style="background: green !important; border-color:green !important; color:white !important">
                                    <span class="btn-label" style="font-size:13px !important;"><i class="fa fa-check"></i></span> Pay Now </a>
                                   
                                    <a type="button" class="btn btn-labeled responsive-button button-style back-button" href="{{ route('payuserfee.index') }}" title="Back">
                                        <i class="fas fa-arrow-left"></i><span> Back </span>
                                    </a>
                                    </div>
    <input type="hidden" value="{{\Crypt::encrypt($enrollment[0]['payment_status_id'])}}" id="cryptpayment_status_id">
    <div class="modal fade" id="paymentModal" tabindex="-1" role="dialog" aria-labelledby="paymentModalTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Payment Method</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Please Select Type of Payment</p>
                    <input type="radio" id="Offline" name="payment_method" value="Offline" checked>
                    <label for="Offline">Offline</label><br>
                    <!-- <input type="radio" id="Online" name="payment_method" value="Online">
                    <label for="Online">Online</label><br> -->
                </div>
                <div class="modal-footer">
                    <button type="button" onclick="proceedtopay()" class="btn btn-success">Proceed To Pay</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    function paynow() {
        // console.log(localStorage.getItem('alertShown'));
        // if(localStorage.getItem('alertShown')){
        // swal.fire("", "Your current session is about to expire. To continue your payment, kindly log in again.", "info");
        // }else{
        $('#paymentModal').modal('show');
        // }
    }

    function proceedtopay() {
        var selected = document.querySelector('input[name="payment_method"]:checked').value;
        var payment_status_id = document.getElementById('payment_status_id').value;
        var cryptpayment_status_id = document.getElementById('cryptpayment_status_id').value;
        var initiated_to = document.getElementById('initiated_to').value;
        if (selected == 'Offline') {
            $('.loader').show();
            $.ajax({
                url: "{{ route('payment.offline.request') }}",
                type: 'post',
                data: {
                    payment_status_id: payment_status_id,
                    initiated_to: initiated_to,
                    // payment_type: payment_type,
                    _token: '{{csrf_token()}}'
                },
                error: function() {
                    window.location = "/payuserfee";
                },
                success: function(data) {
                    // $('.loader').hide();
                    window.location = "/show/payment/details/" + cryptpayment_status_id;
                }
            });
        } else if (selected == 'Online') {
            $(".loader").show();
            document.getElementById('paynow').submit();
        }
        // if (selected == 'Offline') {
        //     $.ajax({
        //         url: "{{ route('payment.offline.request') }}",
        //         type: 'post',
        //         data: {
        //             payment_status_id: payment_status_id,
        //             initiated_to: initiated_to,
        //             _token: '{{csrf_token()}}'
        //         },
        //         error: function() {
        //             alert('Something is wrong');
        //         },
        //         success: function(data) {
        //             $('#paymentModal').modal('hide');
        //             // swal.fire("Success", "Payment Details has been sent to your Email", "success").then(function() {
        //             //     window.location = "/payuserfee";
        //             // });
        //             var IMAGE_URL = "{{asset('upi.png')}}";
        //             // console.log(IMAGE_URL);
        //             Swal.fire({
        //                 icon: 'info',
        //                 title: 'Info',
        //                 html: 'Payment Details has been sent to your Email <br> [or] <br> Use <img style="width: 20px;" src="'+IMAGE_URL+'"/> UPI Payment <span style="font-weight: 900;">9841050686@pz</span>',
        //                 showConfirmButton: true
        //             }).then(function() {
        //                 window.location = "/payuserfee";
        //             });
        //         }
        //     });
        // } else if (selected == 'Online') {
        //     $(".loader").show();
        //     document.getElementById('paynow').submit();
        // }
    }
</script>