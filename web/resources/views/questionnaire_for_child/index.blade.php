@extends('layouts.adminnav')

@section('content')
<style>
    .main-sidebar.sidebar-style-2{
        background-color: #2a0245 !important;
    }
    #sidebar-wrapper
    {
        background-color: #2a0245 !important;

    }
</style>
<style>
    progress {
        -webkit-appearance: none;
        appearance: none;
        height: 20px;
    }

    /* Mobile Responsive Table styling */
    @media (max-width: 767px) {
        #align1, 
        #align1 tbody, 
        #align1 tr, 
        #align1 td {
            display: block;
            width: 100%;
            box-sizing: border-box;
        }

        #align1 thead {
            display: none;
        }

        #align1 tbody tr {
            margin-bottom: 15px;
            border: 1px solid #ddd;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            background: #fff;
            padding: 10px;
        }

        #align1 tbody td {
            display: flex;
            justify-content: space-between;
            align-items: center;
            text-align: right !important;
            border-bottom: 1px solid #eee;
            padding: 10px 5px;
            word-break: break-word;
            white-space: normal;
        }

        #align1 tbody td:last-child {
            border-bottom: none;
            justify-content: space-between;
        }
        
        #align1 tbody td:last-child .btn, 
        #align1 tbody td:last-child a.btn {
            margin-left: 0;
            margin-right: 0;
        }

        #align1 tbody td::before {
            content: attr(data-label);
            font-weight: bold;
            display: block;
            flex-basis: 45%;
            text-align: left;
            margin-bottom: 0px;
            color: #333;
        }
        
        .dt-buttons .btn {
            padding: 4px 8px !important;
            font-size: 11px !important;
        }
        
        .btn {
            padding: 5px 10px !important;
            font-size: 11px !important;
        }

        div.dataTables_wrapper div.dataTables_length label,
        div.dataTables_wrapper div.dataTables_filter label,
        div.dataTables_wrapper div.dataTables_info,
        div.dataTables_wrapper div.dataTables_paginate {
            font-size: 12px !important;
        }

        div.dataTables_wrapper div.dataTables_length select,
        div.dataTables_wrapper div.dataTables_filter input {
            padding: 2px 5px !important;
            font-size: 12px !important;
            height: auto !important;
        }
        
        div.dataTables_wrapper div.dataTables_filter input {
            width: 120px !important;
        }
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

    <script>
        window.onload = function() {

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
    </script>
    @endif

    {{ Breadcrumbs::render('questionnaire_for_user.index') }}
    <div class="col-lg-12 text-center">
        <h4 style="color:darkblue;">Child Questionnaire List View</h4>
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
                                <tr>
                                        <!-- <td data-label="Sl.No">1</td> -->
                                        <td data-label="Questionaire Name">Executive Functioning-The way I process</td>
                                        <td data-label="Progress Status">
                                            <div class="progress" style="height: 25px;">
                                                <div class="progress-bar" role="progressbar" id="" aria-valuemax="100" style="font-weight: bolder;color: black;width:10%;background-color:red;color:white;">0/46</div>
                                            </div>
                                        </td>
                                        <td data-label="Status">New</td>
                                        <td data-label="Action">
                                            <a class="btn btn-danger" style="cursor: pointer;" id="" href="{{ route('childquestionnaire_for_user.form.edit', '1') }}">New</a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <!-- <td data-label="Sl.No">2</td> -->
                                        <td data-label="Questionaire Name">Executive Functioning-The way I process</td>
                                        <td data-label="Progress Status">
                                            <div class="progress" style="height: 25px;">
                                                <div class="progress-bar" role="progressbar" id="" aria-valuemax="100" style="font-weight: bolder;color: black;width:30%;background-color:orange;color:white;">20/46</div>
                                            </div>
                                        </td>
                                        <td data-label="Status">Saved</td>
                                        <td data-label="Action">
                                            <a class="btn btn-warning" style="cursor: pointer;" id="" href="{{ route('childquestionnaire_for_user.submitted.form', '1') }}">Edit</a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <!-- <td data-label="Sl.No">3</td> -->
                                        <td data-label="Questionaire Name">Executive Functioning-The way I process</td>
                                        <td data-label="Progress Status">
                                            <div class="progress" style="height: 25px;">
                                                <div class="progress-bar" role="progressbar" id="" aria-valuemax="100" style="font-weight: bolder;color: black;width:100%;background-color:green;color:white;">46/46</div>
                                            </div>
                                        </td>
                                        <td data-label="Status">Submitted</td>
                                        <td data-label="Action">
                                            <a class="btn btn-success" style="cursor: pointer;" id="" href="{{ route('childquestionnaire_for_user.submitted.form', '1') }}">View</a>
                                        </td>
                                    </tr>
                                  

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
    var progress_status = 10;
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
</script>
<script>
    setTimeout(func, 2000);

    function func() {
        let url = new URL(window.location.href)
        let message = url.searchParams.get("message");
        let message1 = url.searchParams.get("message1");

        if (message != null) {
            Swal.fire({
                title: "Success",
                text: "Questionnaire Saved Successfully",
                icon: "success",
            });
        }
        if (message1 != null) {
            Swal.fire({
                title: "Success",
                text: "Questionnaire Sumitted Successfully",
                icon: "success",
            });
        }
    };
    
    window.onload = function() {
        let url = new URL(window.location.href)
        let message = url.searchParams.get("message");
        let message1 = url.searchParams.get("message1");


        if (message != null) {
            func();
            window.history.pushState("object or string", "Questionnaire Saved Successfully", "/questionnaire_for_child");
        }
        if (message1 != null) {
            func();
            window.history.pushState("object or string", "Questionnaire Sumitted Successfully", "/questionnaire_for_child");

        }

    };
</script>
@endsection