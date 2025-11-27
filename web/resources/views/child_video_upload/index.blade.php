@extends('layouts.adminnav')
@section('content')

<div class="main-content">
    {{ Breadcrumbs::render('child_video_upload.childindex') }}

    
    <!-- <input type="hidden" name="session_data" id="session_data" class="session_data" value="{{ session('success') }}">
    <script type="text/javascript">
        window.onload = function() {
            var message = $('#session_data').val();
            Swal.fire('Success!', message, 'success');
        }
    </script>
    
    <input type="hidden" name="session_data" id="session_data1" class="session_data" value="{{ session('fail') }}">
    <script type="text/javascript">
        window.onload = function() {
            var message = $('#session_data1').val();
            Swal.fire('Info!', message, 'info');
        }
    </script>
    -->

    <div class="tile" id="tile-1" style="margin-top:10px !important; margin-bottom:10px !important;">
        <h4 class="text-center" style="color:darkblue">13+Activity Set List</h4>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card mt-3">
                <div class="card-body">
                <h6 style="color:red !important;">NOTE:-</h6>
                    <div class="col-md-12" style="display: flex;flex-direction: row; align-items: center;">
                    <p class="mr-1"style="font-weight: 900 !important;">1)</p>
                        <span class="text-inherit mr-1 fa fa-circle" style="color:red !important;font-weight: 900;" title=""></span>
                        <p style="font-weight: 900 !important;">This symbol implies number of Rejected Activities(when mouse hovered).</p>
                    </div>
                    <div class="col-md-12" style="display: flex;flex-direction: row;align-items: center;">
                       <p class="mr-1" style="font-weight: 900 !important;">2)</p><p style="font-weight: 900 !important;">By clicking the<a class="btn btn-success" id="btn_complete_edit58" title="Upload Video" type="button"><i class="fa fa-plus" style="font-size: 10px;"></i><span style="font-size: 10px;">Upload</span></a>you will be able to the see the list of Activities under the Activity Sets.</p>

                    </div>
                    <div class="table-wrapper">
                        <div class="table-responsive">
                            <table class="table table-bordered" id="align1">
                                <thead>
                                    <tr>
                                        <th>Sl.No</th>
                                        <th>Activity Name</th>
                                        <th>Current Status</th>
                                        <th>Progress Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>

                                   
                                    <tr>
                                        <td>1</td>
                                        <td>Activity Set-1</td>
                                       
                                        <td id="currentStatus1">New</td>
                                                                               
                                        <td>
                                            <div class="progress" style="height: 25px;">
                                                <div class="progress-bar" role="progressbar" id="1" aria-valuemax="100" style="font-weight: bolder;color: black;">0/4</div>
                                            </div>
                                        </td>
                                        <td>
                                            
                                            <a href="#addModal" data-toggle="modal" data-target="#addModal" class="btn btn-success" title="View" data-toggle="modal" data-target="#templates" style="margin-inline:5px"><i class="fa fa-plus"></i></span><span style="font-size:15px !important; padding:8px !important">Upload</a>

                                           

                                        </td>
                                    </tr>
                                    <tr>
                                        <td>2</td>
                                        <td>Activity Set-2</td>
                                       
                                        <td id="currentStatus1">Completed</td>
                                                                               
                                        <td>
                                            <div class="progress" style="height: 25px;">
                                                <div class="progress-bar bg-success" role="progressbar" id="39" aria-valuemax="100" style="font-weight: bolder;color: black;width: 100%;">4/4</div>
                                            </div>
                                        </td>
                                        <td>
                                            
                                            <!-- <a href="#addModal" data-toggle="modal" data-target="#addModal" class="btn btn-success" title="View" data-toggle="modal" data-target="#templates" style="margin-inline:5px"><i class="fa fa-plus"></i></span><span style="font-size:15px !important; padding:8px !important">Upload</a> -->

                                            <a class="btn btn-success" id="btn_complete_show1" title="show" type="button" href="{{ route('child_video_upload.child_create', '1') }}"><i class="fas fa-eye" style="color:green"></i> View</a>
                                            <!-- <a class="btn btn-success" id="btn_complete_edit1" title="Upload Video" type="button" href="{{ route('child_video_upload.child_create','1') }}"><i class="fa fa-plus"></i></span><span style="font-size:15px !important; padding:8px !important">Upload</a> -->
                                            <!-- Show the circle button only if there are rejected videos -->
                                            
                                            
                                            <!-- Display the circle button only for the first row -->
                                            <!-- <span class="text-inherit mr-3 fa fa-circle" style="color:red !important;" title=""></span> -->
                                            


                                        </td>
                                    </tr>
                                    <tr>
                                        <td>3</td>
                                        <td>Activity Set-3</td>
                                       
                                        <td id="currentStatus1">In-Progress</td>
                                                                               
                                        <td>
                                            <div class="progress" style="height: 25px;">
                                                <div class="progress-bar bg-warning" role="progressbar" id="1" aria-valuemax="100" style="font-weight: bolder;color: black;width: 57.143%;">3/5</div>
                                            </div>
                                        </td>
                                        <td>
                                            
                                            <a href="#addModal" data-toggle="modal" data-target="#addModal" class="btn btn-success" title="View" data-toggle="modal" data-target="#templates" style="margin-inline:5px"><i class="fa fa-plus"></i></span><span style="font-size:15px !important; padding:8px !important">Upload</a>

                                            <!-- <a class="btn btn-success" id="btn_complete_show1" title="show" type="button" href="{{ route('child_video_upload.child_create', '1') }}"><i class="fas fa-eye" style="color:green"></i> View</a> -->
                                            <!-- <a class="btn btn-success" id="btn_complete_edit1" title="Upload Video" type="button" href="{{ route('child_video_upload.child_create','1') }}"><i class="fa fa-plus"></i></span><span style="font-size:15px !important; padding:8px !important">Upload</a> -->
                                            <!-- Show the circle button only if there are rejected videos -->
                                            
                                            
                                            <!-- Display the circle button only for the first row -->
                                            <span class="text-inherit mr-3 fa fa-circle" style="color:red !important;" title=""></span>
                                            


                                        </td>
                                    </tr>
                                    <tr>
                                        <td>4</td>
                                        <td>Activity Set-4</td>
                                       
                                        <td id="currentStatus1">In-Progress</td>
                                                                               
                                        <td>
                                            <div class="progress" style="height: 25px;">
                                                <div class="progress-bar bg-warning" role="progressbar" id="1" aria-valuemax="100" style="font-weight: bolder;color: black;">1/4</div>
                                            </div>
                                        </td>
                                        <td>
                                            
                                            <a href="#addModal" data-toggle="modal" data-target="#addModal" class="btn btn-success" title="View" data-toggle="modal" data-target="#templates" style="margin-inline:5px"><i class="fa fa-plus"></i></span><span style="font-size:15px !important; padding:8px !important">Upload</a>

                                            <!-- <a class="btn btn-success" id="btn_complete_show1" title="show" type="button" href="{{ route('child_video_upload.child_create', '1') }}"><i class="fas fa-eye" style="color:green"></i> View</a> -->
                                            <!-- <a class="btn btn-success" id="btn_complete_edit1" title="Upload Video" type="button" href="{{ route('child_video_upload.child_create','1') }}"><i class="fa fa-plus"></i></span><span style="font-size:15px !important; padding:8px !important">Upload</a> -->
                                            <!-- Show the circle button only if there are rejected videos -->
                                            
                                            
                                            <!-- Display the circle button only for the first row -->
                                            <span class="text-inherit mr-3 fa fa-circle" style="color:red !important;" title=""></span>
                                            


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
                                    <p><br><strong>Dear Child,</strong></p>
                                    <p><br>As discussed during the meeting, we would require you to video record your child's activities that enables us to observe and understand your child's behaviours in his/her natural environment.&nbsp;</p>
                                    <p><br>We will be maintaining confidentiality and the videos will be shared only among Elina team. If in case there is a need to share with anyone else, it will be done with your permission. Requesting you to agree and give your consent for sharing the videos.</p>
                                    <p>&nbsp;</p>
                                    <p>Thanks and Regards,</p>
                                    <p>Elina Team</p>
                                    </div>
                                </div>
                                <input type="hidden" value="" name="enrollment_id">
                                <input type="hidden" value="" name="activity_initiation_id">

                            </form>
                            <div class="col-md-12  text-center" style="padding-top: 1rem;">
                                <a type="button" onclick="accept()" id="submitbutton" class="btn btn-labeled btn-succes" title="Accept" style="background: green !important; border-color:green !important; color:white !important">
                                    <span class="btn-label" style="font-size:13px !important;"><i class="fa fa-check"></i></span>Accept</a>
                                <a type="button" class="btn btn-labeled back-btn" data-dismiss="modal" aria-hidden="true" title="Back" style="color:white !important">
                                    <span class="btn-label" style="font-size:13px !important;"><i class="fa fa-arrow-left"></i></span>Cancel</a>
                            </div>
                        </div>
                </section>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        $('[data-toggle="tooltip"]').tooltip();
    });
</script>
<script>
    var com = 10;
    var total = 10;
    var rows = 10;
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
        // document.getElementById('useraccept').submit();
        window.location.href="/child_video_upload/parent_create/1";
    }
</script>
@endsection