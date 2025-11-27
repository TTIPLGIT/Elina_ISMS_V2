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

    label {
        display: inline-block;
        margin-bottom: 10px;
        font-weight: bold;
        font-size: 25px;
    }

    select {
        margin-left: 10px;
    }

    input[type="radio"] {
        display: inline-block;
        margin-right: 10px;
        vertical-align: middle;
    }

    #weekSelection {
        margin-left: 30px;
    }

    #weekSelect {
        margin-left: 10px;
    }

    button {
        display: block;
        margin-top: 20px;
        padding: 10px;
        background-color: #4CAF50;
        color: white;
        border: none;
        border-radius: 4px;
        cursor: pointer;
    }

    button:hover {
        background-color: #3e8e41;
    }

    button:active {
        background-color: #2c6220;
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
                            <h4 class="title_feedback">How probable is it that you would want to go on?</h4>
                            <div class="question">
                                <div class="">
                                    <input type="radio" id="option1" name="confirmation" value="Will not continue with SAIL process">
                                    <label for="option1">1. Will not continue with SAIL process</label><br>
                                    <input type="radio" id="option2" name="confirmation" value="Will confirm after">
                                    <label for="option2">2. Will confirm later</label><br>
                                    <div id="weekSelection" style="display:none;">
                                        <label for="weekSelect">After:</label>
                                        <select class="col-4 form-control default" id="weekSelect" name="weekSelect">
                                            <option value="">Select Week</option>
                                            <option value="Week 1">Week 1</option>
                                            <option value="Week 2">Week 2</option>
                                            <option value="Week 3">Week 3</option>
                                        </select>
                                    </div>
                                    <input type="radio" id="option3" name="confirmation" value="Will confirm after one month">
                                    <label for="option3">3. Will confirm after one month</label><br>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12 text-center">
                            <a type="button" class="btn btn-labeled btn-info" href="{{ route('newenrollment.index') }}" title="Cancel" style="background: blue !important; border-color:blue !important; color:white !important">
                                <span class="btn-label" style="font-size:13px !important;"><i class="fa fa-arrow-left"></i></span> Cancel</a>
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