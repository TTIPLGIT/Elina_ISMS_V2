@extends('layouts.adminnav')

@section('content')

<style>
    progress {
        -webkit-appearance: none;
        appearance: none;
        height: 20px;
    }
</style>
<div class="main-content">
    @if (session('success'))
    <input type="hidden" name="session_data" id="session_data" class="session_data" value="{{ session('success') }}">
    <script type="text/javascript">
        window.onload = function() {
            var message = $('#session_data').val();
            swal.fire("Success", message, "success");
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
    @endif

    {{ Breadcrumbs::render('questionnaire_for_user.index') }}
    <div class="col-lg-12 text-center">
        <h4 style="color:darkblue;"> Questionnaire List View</h4>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card mt-3">
                <div class="card-body">
                    <div class="table-wrapper">
                        <div class="table-responsive">
                            <table class="table table-bordered" id="align1">
                                <thead>
                                    <tr>
                                        <th>Sl.No</th>
                                        <th>Questionaire Name</th>
                                        <th style="width: 20%">Progress Status</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($initiated_form as $data)
                                    <tr>
                                        <td>{{$loop->iteration}}</td>
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
                                        <td>
                                            <a class="btn" style="cursor: pointer;" id="a{{$data['questionnaire_initiation_id']}}" href="{{ route('questionnaire_for_user.form.edit', \Crypt::encrypt($data['questionnaire_initiation_id'])) }}"></a>
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

        $(idi).attr('aria-valuenow', title).css('width', per + '%');
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
    $(document).ready(function() {
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
                closeOnConfirm: false,
                closeOnCancel: true,
                showLoaderOnConfirm: true,
            }).then((result) => {
                if (result['isConfirmed']) {
                    window.location.href = "{{Config::get('setting.base_url')}}sail/signed/initiate?user_id=" + encUser;
                } else {
                    window.location.href = "{{Config::get('setting.base_url')}}submitDenial/" + encUser;
                }
            });
        }
    });
</script>
@endsection