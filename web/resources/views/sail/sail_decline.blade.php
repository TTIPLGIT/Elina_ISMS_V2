@extends('layouts.adminnav')

@section('content')
<style>
    /* h1,
    h2,
    h3,
    h4,
    h5,
    h6 {
        font-weight: 400;
        padding: 0;
        margin: 0;
    } */

    p {
        padding: 0;
        margin: 0;
    }

    a {
        text-decoration: none;
        padding: 0;
        margin: 0;
        outline: medium none !important;
    }

    a:hover {
        text-decoration: none;
        outline: medium none !important;
    }

    a:focus {
        text-decoration: none;
        outline: medium none !important;
    }

    img {
        display: inline-block;
        vertical-align: middle;
        max-width: 100%;
    }

    .clear {
        clear: both;
        width: 0;
        height: 0;
        visibility: hidden;
        overflow: hidden;
    }

    .test .open {

        display: none !important;
    }

    .smiley .open {
        display: block;
    }

    .smiley .close {
        display: none;
    }

    .test .close {
        display: block !important;
    }

    /********************************************************************/

    .feedback_container {
        /* text-align: center; */
        padding: 50px;
    }

    .title_feedback {
        font-size: 31px;
        font-weight: 800;
        padding-bottom: 30px;
    }

    .rating_div,
    .question {
        margin-bottom: 80px;
    }

    .smiley {
        width: 72%;
        margin: auto;
    }

    .smiley span {
        display: block;
        float: left;
        margin: 0 20px;
        width: 70px;
        height: 70px;
        cursor: pointer;
    }

    .close {
        opacity: 1 !important;
    }

    .question a {
        text-align: center;
        display: block;
        border: 2px solid #f18700;
        margin-bottom: 30px;
        font-size: 18px;
        color: #000;
        font-weight: 800;
        padding: 10px 0;
    }

    .question a:hover,
    .question a.active_qa {
        background: #f18700;
        color: #fff;
    }

    .comment_div textarea {
        width: 100%;
        border: 2px solid #f18700;
        resize: none;
        outline: 0;
        font-weight: 800;
        padding: 20px;
        font-size: 18px;
    }

    .submit_btn {
        margin-top: 40px;
    }

    .submit_btn a {
        display: inline-block;
        background: #f18700;
        color: #fff;
        font-size: 20px;
        font-weight: 700;
        padding: 10px 40px;
        text-transform: uppercase;
    }

    @media only screen and (max-width: 800px) {

        .smiley {
            width: 97%;
        }

        .smiley span {
            width: 50px;
            height: 50px;
        }

    }

    @media only screen and (max-width: 640px) {

        .feedback_container {
            text-align: center;
            padding: 30px;
        }

        .title_feedback {
            font-size: 24px;
        }

        .smiley {
            width: 100%;
        }

        .smiley span {
            width: 40px;
            height: 40px;
            margin: 0 10px;
        }

    }
</style>

<style>
    h1 {
        color: #333;
    }

    form {
        margin-top: 20px;
    }

    /* Radio button and text container */
    .radio-wrapper {
        display: flex;
        align-items: center;
        margin-bottom: 12px;
        position: relative;
    }

    /* Increased radio button size */
    input[type="radio"] {
        display: inline-block;
        margin-right: 12px;
        vertical-align: middle;
        width: 20px;
        height: 20px;
        cursor: pointer;
        flex-shrink: 0;
    }

    /* Label styling */
    label {
        display: inline-block;
        margin-bottom: 0;
        font-weight: 500;
        font-size: 18px;
        cursor: pointer;
        line-height: 1.4;
        color: #333;
    }

    /* Tooltip styling */
    .radio-wrapper[data-tooltip] {
        position: relative;
    }

    .radio-wrapper[data-tooltip]:hover::after {
        content: attr(data-tooltip);
        position: absolute;
        left: 35px;
        top: -30px;
        background: #333;
        color: white;
        padding: 5px 10px;
        border-radius: 4px;
        font-size: 13px;
        white-space: nowrap;
        z-index: 1000;
        box-shadow: 0 2px 5px rgba(0,0,0,0.2);
        pointer-events: none;
    }

    .radio-wrapper[data-tooltip]:hover::before {
        content: '';
        position: absolute;
        left: 45px;
        top: -8px;
        border-width: 5px;
        border-style: solid;
        border-color: #333 transparent transparent transparent;
        z-index: 1000;
        pointer-events: none;
    }

    select {
        margin-left: 10px;
    }

    /* Week selection styling - Proper alignment */
    #weekSelection {
        margin-left: 32px; /* Aligns with the radio button text */
        margin-top: 8px;
        margin-bottom: 16px;
        display: none; /* Hidden by default */
        align-items: center;
        gap: 10px;
    }

    #weekSelection label {
        font-size: 16px;
        font-weight: 500;
        margin-bottom: 0;
        white-space: nowrap;
        color: #555;
    }

    #weekSelect {
        margin-left: 0;
        width: auto;
        min-width: 130px;
        padding: 8px 12px;
        border: 1px solid #ccc;
        border-radius: 4px;
        font-size: 15px;
        cursor: pointer;
        background-color: white;
    }

    #weekSelect:focus {
        outline: none;
        border-color: #f18700;
    }

    .modal-backdrop {
        display: none;
    }
</style>


<div class="main-content">
    <!-- {{ Breadcrumbs::render('newenrollment.create') }} -->
    <!-- <h5 class="text-center" style="color:darkblue">Sail Consent Form</h5> -->

    <div class="row justify-content-center">
        <div class="col-lg-12 col-md-12">

            <div class="card" style="height:100%; padding: 15px; background-color:white">
                <form action="{{route('sail.consent.denial')}}" method="POST" id="consentdenial" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" value="{{$data[0]['user_id']}}" name="user_id" id="user_id">
                    <div class="feedback_container">
                        <div class="qa_div">
                            <h4 class="title_feedback" style="font-family: sans-serif;">How probable is it that you would want to go on?</h4>
                            <div class="question">
                                <div class="">
                                    <!-- Option: Will confirm after one month (Default selected) -->
                                    <div class="radio-wrapper" data-tooltip="Confirm your participation after one month">
                                        <input type="radio" id="option3" name="confirmation" value="Will confirm after one month" checked>
                                        <label for="option3" style="font-family: sans-serif;" >Will confirm after one month</label>
                                    </div>

                                    <!-- Option: Will confirm later -->
                                    <div class="radio-wrapper" data-tooltip="Decide on participation at a later date">
                                        <input type="radio" id="option2" name="confirmation" value="Will confirm after">
                                        <label for="option2" style="font-family: sans-serif;">Will confirm later</label>
                                    </div>
                                    
                                    <!-- Week selection - Properly aligned with the option text -->
                                    <div id="weekSelection" style="display: none;">
                                        <label  style="font-family: sans-serif;" for="weekSelect">After:</label>
                                        <select class="col-4 form-control default" id="weekSelect" name="weekSelect">
                                            <option value="" style="font-family: sans-serif;">Select Week</option>
                                            <option value="Week 1" style="font-family: sans-serif;">Week 1</option>
                                            <option value="Week 2" style="font-family: sans-serif;">Week 2</option>
                                            <option value="Week 3" style="font-family: sans-serif;">Week 3</option>
                                        </select>
                                    </div>
                                    
                                    <!-- Option: Will not continue with SAIL process -->
                                    <div class="radio-wrapper" data-tooltip="Opt out of the SAIL process completely">
                                        <input type="radio" id="option1" name="confirmation" value="Will not continue with SAIL process">
                                        <label for="option1">Will not continue with SAIL process</label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12 text-center">
                            <a type="button" class="btn btn-labeled btn-info" href="{{ route('newenrollment.index') }}" title="Back" style="background: red !important; border-color:red !important; color:white !important">
                                <span class="btn-label" style="font-size:13px !important;"><i class="fa fa-arrow-left"></i></span> Back</a>
                            <a type="button" onclick="formSubmit()" id="accept-button" class="btn btn-labeled btn-succes" title="submit" style="background: green !important; border-color:green !important; color:white !important">
                                <span class="btn-label" style="font-size:13px !important;"><i class="fa fa-check"></i></span> Submit</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    const weekSelection = document.getElementById('weekSelection');
    const weekSelect = document.getElementById('weekSelect');
    const confirmWeekOption = document.getElementById('option2');
    const options = document.getElementsByName('confirmation');

    // Show/hide week selection based on selected option
    for (const option of options) {
        option.addEventListener('change', function() {
            if (confirmWeekOption.checked) {
                weekSelection.style.display = 'flex';
            } else {
                weekSelection.style.display = 'none';
            }
        });
    }

    // Ensure option 3 (one month) is selected by default
    document.addEventListener('DOMContentLoaded', function() {
        document.getElementById('option3').checked = true;
    });
</script>

<script type="text/javascript">
    // window.onload = function() {
    //     $('#myModal').modal('show');
    //     $('#myModal').modal({
    //         backdrop: 'static',
    //         keyboard: false
    //     });
    // }
</script>
<script>
    function formSubmit() {
        var selectedOption = $('input[name=confirmation]:checked').val();
        if (selectedOption == '' || selectedOption == null) {
            swal.fire("Please Select Your Confirmation", "", "error");
            return false;
        }

        if (selectedOption == 'Will confirm after') {
            var selectedWeek = $('#weekSelect').val();
            if (selectedWeek == '' || selectedWeek == null) {
                swal.fire("Please Select After Weeks", "", "error");
                return false;
            }
        }
        document.getElementById('consentdenial').submit();
    }
</script>
@endsection