@extends('layouts.parent')
@section('content')

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
                    <div class="col-md-12" style="display: flex;flex-direction: row; align-items: center;">
                        <p class="mr-1" style="font-weight: 900 !important;">1)</p>
                        <span class="text-inherit mr-1 fa fa-circle" style="color:red !important;font-weight: 900;" title=""></span>
                        <p style="font-weight: 900 !important;">This symbol implies number of Rejected Activities(when mouse hovered).</p>
                    </div>
                    <div class="col-md-12" style="display: flex;flex-direction: row;align-items: center;">
                        <p class="mr-1" style="font-weight: 900 !important;">2)</p>
                        <p style="font-weight: 900 !important;">By clicking the<a class="btn btn-success" id="btn_complete_edit58" title="Upload Video" type="button"><i class="fa fa-plus" style="font-size: 10px;"></i><span style="font-size: 10px;">Upload</span></a>you will be able to the see the list of Activities under the Activity Sets.</p>

                    </div>
                    <div class="table-wrapper">
                        <div class="table-responsive">
                            <table class="table table-bordered" id="tableList">
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
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="main-contents">
                <section class="section">
                    <div class="modal-header bg-primary" style=" background-color: rgb(0 103 172) !important;">
                        <!-- <h4 class="modal-title">Sail Activity</h4> -->
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    </div>
                    <div class="modal-body" style="background-color: #edfcff !important;">
                        <div class="section-body mt-2">
                            <form action="{{route('videocreation.policyaggrement')}}" id="useraccept" method="POST">
                                @csrf
                                <div class="row">
                                    <div class="card-body" id="card_header">
                                        {!!$policy[0]['policy_content']!!}
                                    </div>
                                </div>
                                <input type="hidden" value="{{$rows[0]['enrollment_id']}}" name="enrollment_id">
                                <input type="hidden" value="{{$rows[0]['activity_initiation_id']}}" name="activity_initiation_id">

                            </form>
                            <div class="col-md-12  text-center" style="padding-top: 1rem;">
                                <a type="button" onclick="accept()" id="submitbutton" class="btn btn-labeled btn-succes" title="Accept" style="background: green !important; border-color:green !important; color:white !important">
                                    <span class="btn-label" style="font-size:13px !important;"><i class="fa fa-check"></i></span>Accept</a>

                                <!-- <a type="button" data-dismiss="modal" class="btn btn-labeled responsive-button button-style cancel-button" title="Cancel">
                                    <i class="fas fa-times"></i><span> Cancel </span> -->
                                </a>
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