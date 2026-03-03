@extends('layouts.parent')
@section('content')
<style>
    .modal-header {
        position: relative;
        padding: 20px 20px;
        /* ⬅ adds space top & bottom */
        min-height: 60px;
        /* ⬅ increases header height */
    }

    .modal-header .close {
        position: absolute;
        right: 20px;
        top: 50%;
        transform: translateY(-50%);
        float: none;

        padding: 8px 12px;
        background: transparent;
        border: 1px solid transparent;
        border-radius: 4px;

        color: white;
        font-size: 24px;
        opacity: 1;
        cursor: pointer;
    }

    /* Hover */
    .modal-header .close:hover {
        border: 1px solid #000;
    }

    /* Space between DataTable buttons */
    .dt-buttons .btn {
        margin-right: 8px;
        /* space between buttons */
        margin-bottom: 5px;
        /* small vertical space (mobile safe) */
    }

    /* Space between "Show entries" and buttons */
    .dataTables_length {
        margin-bottom: 12px;
    }

    /* Align buttons nicely */
    .dt-buttons {
        margin-left: 10px;
    }
</style>
<style>
    #tableList th,
    #tableList td {
        text-align: center;
        vertical-align: middle;
    }
</style>
<div class="main-content">
    {{ Breadcrumbs::render('parent_video_upload.parentindex') }}
    <style>
        @media only screen and (max-width: 767px) {
            .text-inherit {
                margin: 0 0 0 15px;
            }
        }
    </style>
    @if (session('success'))
    <input type="hidden" name="session_data" id="session_data" class="session_data" value="{{ session('success') }}">
    <script type="text/javascript">
        window.onload = function() {
            var message = $('#session_data').val();
            Swal.fire('Success!', message, 'success');
        }
    </script>
    @elseif(session('fail'))
    <input type="hidden" name="session_data" id="session_data1" class="session_data" value="{{ session('fail') }}">
    <script type="text/javascript">
        window.onload = function() {
            var message = $('#session_data1').val();
            Swal.fire('Info!', message, 'info');
        }
    </script>
    @endif
    <div class="col-lg-12 text-center">
        <h4 class="screen-title">Activity Set List</h4>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card mt-3">
                <div class="card-body">
                    <h6 style="color:red !important;">NOTE:-</h6>
                    <div class="col-md-12" style="display: flex;flex-direction: row; align-items: flex-start;">
                        <p class="mr-1" style="font-weight: 900 !important; margin: 0; line-height: 1.4;">1)</p>
                        <span class="text-inherit mr-1 fa fa-circle" style=" padding-left:10px ; padding-right:10px; padding-top:3px; color:red !important;font-weight: 900; margin-top: 2px;" title=""></span>
                        <p style="font-weight: 900 !important; margin: 0; line-height: 1.4;">This symbol implies number of Rejected Activities(when mouse hovered).</p>
                    </div>
                    <div class="col-md-12" style="padding-top:10px;display: flex;flex-direction: row; align-items: flex-start;">
                        <p class="mr-1" style="font-weight: 900 !important; margin: 0; line-height: 1.4;">2)</p>
                        <p style="padding-left:10px ;font-weight: 900 !important; margin: 0; line-height: 1.4;">By clicking the
                            <a class="btn btn-success btn-sm" id="btn_complete_edit58" title="Upload Video" type="button" style="display: inline-flex; align-items: center; padding: 0.15rem 0.4rem; margin: 0 4px; vertical-align: middle; height: 22px;">
                                <i class="fa fa-plus" style="font-size: 9px; margin-right: 2px;"></i>
                                <span style="font-size: 11px;">Upload</span>
                            </a>
                            you will be able to see the list of Activities under the Activity Sets.
                        </p>
                    </div>
                    <div class="table-wrapper" style="padding-top: 10px">
                        <div class="table-responsive" style="padding-top: 10px">
                            <table class="table table-bordered" style="padding-top: 10px" id="tableList">
                                <thead>
                                    <tr>
                                        <!-- <th>Sl.No</th> -->
                                        <th>Activity Name</th>
                                        <th>Current Status</th>
                                        <th>Progress Status</th>
                                        <th width="25%">Action</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    @foreach($rows as $key=>$row)
                                    <tr>
                                        <!-- <td>{{ $loop->iteration }}</td> -->
                                        <td>{{ $row['activity_name']}}</td>
                                        @if($row['currentStatus'] == 'initiated')
                                        <td id="currentStatus{{$row['activity_initiation_id']}}">In-Progress</td>
                                        @else
                                        <td id="currentStatus{{$row['activity_initiation_id']}}">{{ $row['currentStatus']}}</td>
                                        @endif
                                        <td>
                                            <div class="progress" style="height: 25px;">
                                                <div class="progress-bar" role="progressbar" id="{{$row['activity_initiation_id']}}" aria-valuemax="100" style="font-weight: bolder;color: black;"></div>
                                            </div>
                                        </td>
                                        <td>
                                            <!-- <a href="#addModal" data-toggle="modal" data-target="#addModal" class="btn btn-success" title="View" data-toggle="modal" data-target="#templates" style="margin-inline:5px"><i class="fa fa-plus"></i></span><span style="font-size:15px !important; padding:8px !important">Upload</a> -->
                                            <a class="btn btn-success" id="btn_complete_show{{$row['activity_initiation_id']}}" title="show" type="button" href="{{ route('parent_video_upload.parent_create', \Crypt::encrypt($row['activity_initiation_id'])) }}"><i class="fas fa-eye" style="color:green"></i> View</a>
                                            <a class="btn btn-success" id="btn_complete_edit{{$row['activity_initiation_id']}}" title="Upload Video" type="button" href="{{ route('parent_video_upload.parent_create', \Crypt::encrypt($row['activity_initiation_id'])) }}" onclick="return validateBeforeUpload(event);"><i class="fa fa-plus"></i><span style="font-size:15px !important; padding:8px !important">Upload</span></a>
                                            <!-- <a class="btn btn-success" id="btn_complete_edit{{$row['activity_initiation_id']}}" title="Upload Video" type="button" href="{{ route('parent_video_upload.parent_create', \Crypt::encrypt($row['activity_initiation_id'])) }}"><i class="fa fa-plus"></i></span><span style="font-size:15px !important; padding:8px !important">Upload</a> -->
                                            <!-- Show the circle button only if there are rejected videos -->
                                            @if($row['isReject'] > 0)
                                            @php
                                            $rejectionDescriptions = DB::table('parent_video_upload')
                                            ->select('activity_description.description')
                                            ->join('activity_description', function ($join) {
                                            $join->on('parent_video_upload.activity_id', '=', 'activity_description.activity_id')
                                            ->on('parent_video_upload.activity_description_id', '=', 'activity_description.activity_description_id');
                                            }) ->where('parent_video_upload.activity_id', $row['activity_id'])
                                            ->where('Enrollment_id', $row['enrollment_id'])
                                            ->where('status', 'Rejected')
                                            ->get()
                                            ->pluck('description');
                                            @endphp
                                            <span class="text-inherit mr-3 fa fa-circle  ml-sm-4" style="color:red !important;" title="{!! implode('&#10;', array_map(function($index, $desc) { return ($index + 1) . ') ' . $desc; }, array_keys($rejectionDescriptions->toArray()), $rejectionDescriptions->toArray())) !!}"></span>
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
@if($rows != [])
<div class="modal fade" id="addModal">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content">

            <div class="main-contents">
                <section class="section">

                    <!-- Header -->
                    <div class="modal-header bg-primary" style="background-color: rgb(0 103 172) !important;">
                        <button type="button"
                            class="close text-white"
                            data-dismiss="modal"
                            aria-hidden="true">&times;</button>
                    </div>

                    <!-- Body -->
                    <div class="modal-body" style="background-color: #edfcff !important;">
                        <div class="section-body mt-2">

                            <form action="{{ route('videocreation.policyaggrement') }}"
                                id="useraccept"
                                method="POST">
                                @csrf

                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="card-body" id="card_header">
                                            {!! $policy[0]['policy_content'] !!}
                                        </div>
                                    </div>
                                </div>

                                <input type="hidden"
                                    name="enrollment_id"
                                    value="{{ $rows[0]['enrollment_id'] }}">

                                <input type="hidden"
                                    name="activity_initiation_id"
                                    value="{{ $rows[0]['activity_initiation_id'] }}">
                            </form>

                            <!-- Accept Button -->
                            <div class="row">
                                <div class="col-md-12 text-center pt-3">
                                    <a type="button"
                                        onclick="accept()"
                                        id="submitbutton"
                                        class="btn btn-labeled btn-success"
                                        title="Accept"
                                        style="background: green !important; border-color: green !important; color: white !important;">

                                        <span class="btn-label" style="font-size:13px !important;">
                                            <i class="fa fa-check"></i>
                                        </span>
                                        Accept
                                    </a>
                                </div>
                            </div>

                        </div>
                    </div>

                </section>
            </div>

        </div>
    </div>
</div>

@endif
<script>
    $(document).ready(function() {
        $('[data-toggle="tooltip"]').tooltip();
    });
</script>
<script>
    var com = <?php echo (json_encode($com)); ?>;
    var total = <?php echo (json_encode($total)); ?>;
    var rows = <?php echo (json_encode($rows)); ?>;
    var leg = rows.length;

    for (i = 0; i < leg; i++) {

        var a = rows[i];
        var activity_initiation_id = a.activity_initiation_id;
        var activityID = a.activity_id;

        var ppp = 0;
        var ccc = 0;
        for (j = 0; j < total.length; j++) {
            var totalactivity_id = total[j].activity_id;
            if (totalactivity_id == activityID) {
                var ppp = total[j].total;
            }
        }


        for (k = 0; k < com.length; k++) {
            var comactivity_id = com[k].activity_id;
            if (comactivity_id == activityID) {
                var ccc = com[k].complete;
            }
        }


        var id = a.activity_initiation_id;
        var no_questions = a.no_questions;
        var per = ((ccc / ppp) * 100).toFixed(3);
        var idi = '#'.concat(id);
        var title = 'Completed '.concat(ccc) + ' of '.concat(ppp);

        $(idi).attr('aria-valuenow', title).css('width', per + '%');
        var div = document.getElementById(id);
        div.innerHTML += ccc + ' / ' + ppp;

        if (per < 25) {
            document.getElementById(id).classList.add('bg-danger');
        } else if (per < 80) {
            document.getElementById(id).classList.add('bg-warning');
        } else if (per >= 80) {
            document.getElementById(id).classList.add('bg-success');
        }

        if (ccc == ppp) {
            document.getElementById('currentStatus' + id).innerHTML = 'Completed';
            $('#btn_complete_edit' + id).hide();
            $('#btn_complete_show' + id).show();
        } else {
            $('#btn_complete_edit' + id).show();
            $('#btn_complete_show' + id).hide();
        }

    }
</script>
<script>
    function accept() {
        Swal.fire({
            title: 'Please ensure the video is relevant to the activity before uploading.',
            text: 'Save and review it thoroughly before submitting. Once submitted, you will not be able to change the video link.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'OK',
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('useraccept').submit();
            }
        });
    }
</script>
<script>
    $(document).ready(function() {
        // console.log("Document ready");
        $(document).on('click', '.text-inherit', function() {
            // console.log("Click event triggered");
            var title = $(this).attr('title');
            showAlert('Required to resend', title, 'info');
        });

        var privacyStatus = @json($privacy_status);
        if (privacyStatus.length == 0) {
            $('#addModal').modal('show');
        }
    });
</script>
<script>
    // Function to close the modal
    function closeModal() {
        var modal = document.getElementById('addModal');
        modal.classList.remove('show');
        modal.setAttribute('aria-hidden', 'true');
        modal.setAttribute('style', 'display: none');
        var modalBackdrop = document.getElementsByClassName('modal-backdrop')[0];
        modalBackdrop.parentNode.removeChild(modalBackdrop);
        //document.body.classList.remove('modal-open');
    }

    // Event listener for cancel button click
    document.querySelector('.cancel-button').addEventListener('click', function() {
        closeModal();
    });

    // Event listener for close button click
    document.querySelector('.close').addEventListener('click', function() {
        closeModal();
    });
</script>
<script>
    function validateBeforeUpload(event) {
        var privacyStatus = @json($privacy_status);

        if (privacyStatus.length === 0) {
            event.preventDefault();
            Swal.fire({
                title: 'Info!',
                text: 'Please accept the Privacy Policy to proceed to upload the Activities.',
                icon: 'info',
                confirmButtonText: 'OK'
            }).then((result) => {
                if (result.isConfirmed) {
                    $('#addModal').modal('show');
                }
            });
            return false;
        }

        return true;
    }
</script>

@endsection