@extends('layouts.parent')

@section('content')
<style>
    input[type=checkbox] {
        display: inline-block;

    }

    .page {
        /* padding: 50px 80px; */
        margin: 50px;
        background: white;
        /* box-shadow: 2px 2px 2px rgba(0, 0, 0, 0.6); */
        /* max-width: 800px; */
        /* min-width: 500px; */
    }

    .container {
        display: flex;
        flex-direction: column;
        box-sizing: border-box;
        max-height: 500px !important;
    }

    .container__heading {
        padding: 1rem 0;
        border-bottom: 1px solid #ccc;
        text-align: center;
    }

    .container__heading>h2 {
        font-size: 1.75rem;
        line-height: 1.75rem;
        margin: 0;
    }

    .container__content {
        flex-grow: 1;
        overflow-y: scroll;
        margin: 25px;
    }

    .container__nav {
        border-top: 1px solid #ccc;
        text-align: center;
        font-size: 16px;
        font-weight: bold;
        padding: 2rem 0 1rem;
    }

    .container__nav1 {
        border-top: 1px solid #ccc;
    }

    .container__nav>.button {
        background-color: #444499;
        box-shadow: 0rem 0.5rem 1rem -0.125rem rgba(0, 0, 0, 0.25);
        padding: 0.8rem 2rem;
        border-radius: 0.5rem;
        color: #fff;
        text-decoration: none;
        font-size: 0.9rem;
        transition: transform 0.25s, box-shadow 0.25s;
    }

    .container__nav>.button:hover {
        box-shadow: 0rem 0rem 1rem -0.125rem rgba(0, 0, 0, 0.25);
        transform: translateY(-0.5rem);
    }

    .container__nav>small {
        color: #777;
        margin-right: 1rem;
    }

    .hidden {
        display: none;
    }
</style>
<div class="main-content">
    {{ Breadcrumbs::render('newenrollment.create') }}
    <h5 class="text-center" style="color:darkblue">Sail Consent Form</h5>

    <div class="row justify-content-center">
        <div class="col-lg-12 col-md-12">

            <div class="card" style="height:100%; padding: 15px; background-color:white">
                <form action="{{route('sail.consent.accept')}}" method="POST" id="consentAccept" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" id="btn_status" name="btn_status" value="">
                    <div class="tab-content" id="tab-content">
                        <!-- Consent Form Tab -->
                        <input type="hidden" value="{{$data['enrollment_child_num']}}" id="enrollment_child_num" name="enrollment_child_num">
                        <input type="hidden" value="{{$data['enrollmentID']}}" id="enrollmentID" name="enrollmentID">
                        <input type="hidden" value="{{$data['payment_amount']}}" id="payment_amount" name="payment_amount">
                        <input type="hidden" value="{{$data['initiated_to']}}" id="initiated_to" name="initiated_to">
                        <input type="hidden" value="{{$data['child_id']}}" id="child_id" name="child_id">
                        <input type="hidden" value="{{$data['child_name']}}" id="child_name" name="child_name">
                        <input type="hidden" value="{{$data['initiated_by']}}" id="initiated_by" name="initiated_by">
                        <input type="hidden" value="{{$data['payment_status']}}" id="payment_status" name="payment_status">
                        <input type="hidden" value="{{$data['payment_process_description']}}" id="payment_process_description" name="payment_process_description">
                        <input type="hidden" value="{{$data['payment_for']}}" id="payment_for" name="payment_for">
                        <input type="hidden" value="{{$data['user_id']}}" id="user_id" name="user_id">
                        <input type="hidden" value="{{$data['paymenttokentime']}}" id="paymenttokentime" name="paymenttokentime">
                        <input type="hidden" value="{{$data['parentname']}}" id="parentname" name="parentname">
                        <input type="hidden" value="{{$data['baseAmount']}}" id="baseAmount" name="baseAmount">
                        <input type="hidden" value="{{$data['gstAmount']}}" id="gstAmount" name="gstAmount">
                        <input type="hidden" value="{{$data['masterData']}}" id="masterData" name="masterData">

                        <div>
                            <div class="container">
                                <div class="container__nav1"></div>
                                <div class="container__content" id="terms-and-conditions">
                                    {!! $consentData !!}
                                </div>

                            </div>
                            <div class="container__nav">
                                <label id="accept-label" /*class="hidden" * />
                                <input type="checkbox" name="consent_aggrement" value="Agreed" id="accept-checkbox" style="margin-right: 0.3rem!important;">I have read and accept the terms and conditions.
                                </label>
                            </div>
                            <div class="col-md-12 text-center">
                                <a type="button" onclick="consentAccept('Agreed')" id="accept-button" class="btn btn-labeled btn-succes disable-click" title="submit" style="background: gray !important;color:white !important">
                                    <span class="btn-label" style="font-size:13px !important;"><i class="fa fa-check"></i></span> Submit</a>
                                <a type="button" onclick="consentAccept('Declined')" id="decline-button" class="btn btn-labeled btn-succes" title="Decline" style="background: red !important; color:white !important">
                                    <span class="btn-label" style="font-size:13px !important;"><i class="fa fa-check"></i></span> Decline </a>
                            </div>

                        </div>
                        <!-- End Tab -->
                    </div>



                </form>
            </div>

        </div>
    </div>
</div>



<script>
    const termsContainer = document.querySelector('.container__content');
    const acceptLabel = document.querySelector('#accept-label');
    const checkbox = document.getElementById("accept-checkbox");
    const acceptButton = document.getElementById("accept-button");
    const declineButton = document.getElementById("decline-button");
    checkbox.addEventListener("change", () => {
        if (checkbox.checked) {
            // alert("You have accepted the terms and conditions.");
            swal.fire("You have accepted the terms and conditions. Please click on the submit button to proceed further.", "", "info");
            acceptButton.style.backgroundColor = "green";
            acceptButton.classList.remove('disable-click');

            declineButton.style.backgroundColor = "gray";
            declineButton.classList.add('disable-click');
        } else {
            swal.fire("For further processing, you must agree and click the submit button to proceed further", "", "info");
            acceptButton.style.backgroundColor = "gray";
            acceptButton.classList.add('disable-click');

            declineButton.style.backgroundColor = "red";
            declineButton.classList.remove('disable-click');
        }
    });

    function checkScroll() {
        const scrollHeight = termsContainer.scrollHeight;
        const offsetHeight = termsContainer.offsetHeight;
        const scrollTop = termsContainer.scrollTop;
        if (scrollHeight === offsetHeight + scrollTop) {
            acceptLabel.classList.remove('hidden');
        } else {
            acceptLabel.classList.add('hidden');
        }
    }
</script>
<script>
    function consentAccept(a) {
        document.getElementById('btn_status').value = a;
        if(a == 'Declined'){
            swaltext = 'Decline';
        }else if(a == 'Agreed'){
            swaltext = 'Agree';
        }else{
            swaltext = a;
        }
        Swal.fire({
            title: "Do you want to "+swaltext+" ?",
            text: "Please Click 'Yes' to "+swaltext+" the Consent",
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Yes',
            cancelButtonText: 'No'
        }).then((result) => {
            if (result.isConfirmed) {
                $('.loader').show();
                document.getElementById('consentAccept').submit();
            } else {
                return false;
            }
        });
    }
</script>
<script type="text/javascript">
    window.onload = function() {
        Swal.fire('Info!', 'Please Accept the Consent Form to proceed further', 'info');
    }
</script>
@endsection