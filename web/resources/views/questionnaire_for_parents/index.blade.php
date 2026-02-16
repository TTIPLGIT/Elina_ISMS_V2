@extends('layouts.parent')

@section('content')

<style>
    progress {
        -webkit-appearance: none;
        appearance: none;
        height: 20px;
    }

    .container {
        width: 100vw;
        height: 100vh;
        background: #d4d4d4;
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .switch {
        display: flex;
    }

    .switch input[type='checkbox'] {
        height: 0;
        width: 0;
        visibility: hidden;
    }

    .switch label {
        cursor: pointer;
        width: 45px;
        height: 20px;
        background-color: rgb(0, 0, 0, 0.2);
        display: block;
        border-radius: 50em;
        position: relative;
        transition: 0.3s;
        padding: 4px;
        box-sizing: content-box;
    }

    .switch label>.slider.round {
        content: '';
        position: absolute;
        width: 20px;
        height: 20px;
        background-color: #fff;
        border-radius: 50em;
        transition: 0.3s;
    }

    .switch input:checked+label {
        background-color: #5549f1;
    }

    .switch input:checked+label>.slider.round {
        transform: translateX(calc(100% + 5px));
        color: black;
    }

    .slider.round {
        width: auto;
        height: auto;
        font-family: sans-serif;
        text-align: center;
        color: gray;
        margin: 0;
        padding: 0;
    }
</style>
<div class="main-content">
    @if (session('success'))
    <input type="hidden" name="session_data" id="session_data" class="session_data" value="{{ session('success') }}">
    <script type="text/javascript">
        window.onload = function() {
            var message = $('#session_data').val();
            // swal.fire("Success", message, "success");
            Swal.fire("Success", message, "success").then((result) => {
                var encUser = <?php echo json_encode($encUser); ?>;
                var sail = <?php echo json_encode($sail); ?>;
                if (sail == 0) {
                    Swal.fire({
                        title: "SAIL Consent",
                        text: "Please click Agree to proceed to the SAIL Program",
                        icon: "info",
                        customClass: 'swalalerttext',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        confirmButtonText: "Agree",
                        cancelButtonText: "Decline",
                        allowOutsideClick: false,
                        closeOnConfirm: false,
                        closeOnCancel: true,
                        showLoaderOnConfirm: true,
                    }).then((result) => {
                        if (result['isConfirmed']) {
                            $('.loader').show();
                            window.location.href = "{{Config::get('setting.base_url')}}sail/signed/initiate?user_id=" + encUser;
                        } else {
                            $('.loader').show();
                            window.location.href = "{{Config::get('setting.base_url')}}submitDenial/" + encUser;
                        }
                    });
                }
            });
        }
    </script>
    @elseif(session('fail'))
    <input type="hidden" name="session_data" id="session_data1" class="session_data" value="{{ session('fail') }}">
    <script type="text/javascript">
        window.onload = function() {
            var message = $('#session_data1').val();
            swal.fire("Info", message, "info");
        }
    </script>
    @elseif($sail == 0)
    <script>
        window.onload = function() {
            var encUser = <?php echo json_encode($encUser); ?>;
            var sail = <?php echo json_encode($sail); ?>;
            if (sail == 0) {
                Swal.fire({
                    title: "SAIL Consent",
                    text: "Please click Agree to proceed to the SAIL Program",
                    icon: "info",
                    customClass: 'swalalerttext',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    confirmButtonText: "Agree",
                    cancelButtonText: "Decline",
                    allowOutsideClick: false,
                    closeOnConfirm: false,
                    closeOnCancel: true,
                    showLoaderOnConfirm: true,
                }).then((result) => {
                    if (result['isConfirmed']) {
                        $('.loader').show();
                        window.location.href = "{{Config::get('setting.base_url')}}sail/signed/initiate?user_id=" + encUser;
                    } else {
                        $('.loader').show();
                        window.location.href = "{{Config::get('setting.base_url')}}submitDenial/" + encUser;
                    }
                });
            }
        }
    </script>
    @endif

    {{ Breadcrumbs::render('questionnaire_for_user.index') }}
    <div class="col-lg-12 text-center">
        <h4 class="screen-title"> Questionnaire List View</h4>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card mt-3">
                <div class="card-body">
                    <div class="table-wrapper">
                        <div class="table-responsive">
                            <table class="table table-bordered" id="tableList">
                                <thead>
                                    <tr>
                                        <!-- <th>Sl.No</th> -->
                                        <th>Questionaire Name</th>
                                        <th style="width: 20%">Progress Status</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($initiated_form as $data)
                                    <tr>
                                        <!-- <td>{{$loop->iteration}}</td> -->
                                        <td>{{$data['questionnaire_name']}}</td>
                                        <td>
                                            <div class="progress" style="height: 25px;">
                                                <div class="progress-bar" role="progressbar" id="{{$data['questionnaire_initiation_id']}}" aria-valuemax="100" style="font-weight: bolder;color: black;"></div>
                                            </div>
                                        </td>
                                        @if($data['currentState'] == 'Sent')
                                        <td>New</td>
                                        @else
                                        <td>{{$data['currentState']}}</td>
                                        @endif
                                        <td style="display:flex;justify-content:space-evenly;">
                                            <a class="btn" style="cursor: pointer;" id="a{{$data['questionnaire_initiation_id']}}" href="{{ route('questionnaire_for_user.form.edit', \Crypt::encrypt($data['questionnaire_initiation_id'])) }}"></a>
                                            @if($data['questionnaire_id'] !='1')
                                            @if($data['currentState'] == 'Submitted' && $data['p_flag'] == '1')
                                            <!-- <div class="">
                                                <button type="button" class="btn btn-primary btn-xs dt-edit toggle_status" data-enrollment="{{ $data['enrollment_child_num'] }}" data-question="{{$data['questionnaire_id'] }}" data-questionnaire="{{ $data['questionnaire_initiation_id'] }}" disabled>Request Sent
                                                </button>
                                            </div> -->
                                            @elseif($data['currentState'] == 'Submitted' && $data['p_flag'] != '1')
                                            <div class="">
                                                <button type="button" class="btn btn-primary btn-xs dt-edit toggle_status" data-enrollment="{{ $data['enrollment_child_num'] }}" data-question="{{$data['questionnaire_id'] }}" data-questionnaire="{{ $data['questionnaire_initiation_id'] }}">Edit Request</button>
                                            </div>
                                            @endif
                                            @endif
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    var progress_status = <?php echo (json_encode($initiated_form)); ?>;
    for (i = 0; i < progress_status.length; i++) {

        var a = progress_status[i];
        var percent = a.question_progress;
        var id = a.questionnaire_initiation_id;
        var total_questions = a.total_questions;
        var status = a.currentState;
        var per = ((percent / total_questions) * 100).toFixed(3);
        var title = 'Completed '.concat(percent) + ' of '.concat(total_questions);
        var idi = '#'.concat(id);
        var aidi = 'a'.concat(id);
        if (per < 15) {

            $(idi).attr('aria-valuenow', title).css('width', "25" + '%');
        } else {
            $(idi).attr('aria-valuenow', title).css('width', per + '%');

        }
        var div = document.getElementById(id);
        div.innerHTML += percent + ' / ' + total_questions;

        if (per == 0) {
            document.getElementById(aidi).innerHTML = "New";
            document.getElementById(aidi).classList.add('btn-danger');
        } else if (status == "Submitted") {
            document.getElementById(aidi).innerHTML = "View";
            document.getElementById(aidi).classList.add('btn-success');
        } else {
            document.getElementById(aidi).classList.add('btn-primary');
            document.getElementById(aidi).innerHTML = "Edit";
        }

        if (per < 25) {
            document.getElementById(id).classList.add('bg-danger');
        } else if (per < 80) {
            document.getElementById(id).classList.add('bg-warning');
        } else if (per >= 80) {
            document.getElementById(id).classList.add('bg-success');
        }

    }
    document.addEventListener("DOMContentLoaded", function() {
        var toggles = document.querySelectorAll('.toggle_status');
        toggles.forEach(function(toggle) {
            toggle.addEventListener("click", function() {
                // Get the status of the button
                var button = this;

                // Show SweetAlert dialog
                Swal.fire({
                    title: 'Are you sure?',
                    text: 'Do you want to request the edit option for this questionnaire?',
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonText: 'Yes',
                    cancelButtonText: 'No',
                }).then((result) => {
                    if (result.isConfirmed) {
                        var enrollmentId = button.getAttribute("data-enrollment");
                        var questionnaireId = button.getAttribute("data-questionnaire");
                        var que_id = button.getAttribute("data-question");

                        button.textContent = 'Request Sent';
                        button.disabled = true;
                        // Make an AJAX call to update the option
                        $.ajax({
                            type: 'POST',
                            url: '/questionnaire/updateoption/parent', // Replace with your AJAX endpoint
                            data: {
                                enrollment_id: enrollmentId,
                                questionnaire_initiation_id: questionnaireId,
                                q_id: que_id
                            },
                            success: function(response) {
                                // Handle the response here
                                // console.log(response);
                                Swal.fire({
                                    title: 'Success!',
                                    text: 'Your request for editing the questionnaire is sent',
                                    icon: 'success'
                                }).then((result) => {
                                    // Reload the page after showing the success message
                                    //button.textContent = 'Request Sent';
                                    location.reload();
                                });
                                button.disabled = true;
                            },
                            error: function(xhr, status, error) {
                                // Handle errors here
                                console.error(xhr.responseText);
                                Swal.fire({
                                    title: 'Error!',
                                    text: 'Failed to request questionnaire. Please try again.',
                                    icon: 'error'
                                });
                                button.disabled = false;
                            }
                        });
                    } else {
                        // If the user clicks "No", do nothing
                    }
                });
            });
        });
    });
</script>
@endsection