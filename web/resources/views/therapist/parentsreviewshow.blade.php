@extends('layouts.adminnav')
<script type="text/javascript" src="https://cdn.rawgit.com/t4t5/sweetalert/v0.2.0/lib/sweet-alert.min.js"></script>

@section('content')
<style>
    #frname {
        color: red;
    }

  
    .is-coordinate {
        justify-content: center;
    }

    .centerid {
        width: 100%;
        text-align: center;
    }
    .form-control
    {
        background-color: rgb(128 128 128 / 34%) !important;
    }
</style>

<div class="main-content">

    <!-- Main Content -->
    <section class="section">

        {{ Breadcrumbs::render('TherapistWeeklyShow',1) }}
        <div class="section-body mt-1">
            <h5 class="text-center" style="color:darkblue">Monthly Parents Review Meeting Invite View</h5>
            <div class="row">
                <div class="col-12">

                    <div class="card">
                        <div class="card-body">

                            <form method="POST" action="{{ route('ovm1.store') }}">

                                @csrf
                                <div class="row is-coordinate">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="control-label">Enrollment ID</label>
                                            <input class="form-control" name="enrollment_id" value="EN/2022/12/025" placeholder="Enrollment ID" required>
                                        </div>
                                    </div>


                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="control-label">Child ID</label>
                                            <input class="form-control" type="text" id="child_id" name="child_id" value="CH/2022/025" disabled="" placeholder="OVM1 Meeting" required autocomplete="off">
                                        </div>
                                    </div>



                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="control-label">Child Name</label>
                                            <input class="form-control" type="text" id="child_name" name="child_name" value="Kaviya" disabled="" placeholder="Enter Name" required autocomplete="off">
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group ">
                                            <label class="control-label">IS Co-ordinator<span class="error-star" style="color:red;">*</span></label>
                                            <div style="display: flex;">
                                            <input class="form-control" type="text" id="is_coordinator" name="is_coordinator"  value="Robert" disabled=""required autocomplete="off">

                                                <button style="display: none;" id="co_one" title="Availability Calendar" class="btn" data-toggle="modal" data-target="#calModal" type="button">
                                                    <i style="color: blue;font-size: 20px;" class="fa fa-calendar" aria-hidden="true"></i></button>
                                            </div>
                                            <input type="hidden" id="is_coordinator1old">
                                            <input type="hidden" id="is_coordinator1current">
                                        </div>
                                    </div>





                                </div>
                        </div>
                    </div>
                </div>
                <br>










                <div class="row">
                    <div class="col-12">

                        <div class="card">
                            <div class="card-body">



                                <div class="form-group row" style="margin-bottom: 5px;">
                                    <label class="col-sm-2 col-form-label">To<span class="error-star" style="color:red;">*</span></label>
                                    <div class="col-sm-4">
                                        <input class="form-control" type="text" id="meeting_to" name="meeting_to" placeholder="Email Id" value="Kaviya@talentakeaways.com" disabled="" required>
                                    </div>
                                    <div class="col-md-2">
                                    </div>
                                    <div class="col-md-2">
                                        <label class="control-label centerid">Status</label> <br>
                                        <input class="form-control" type="text" id="meeting_status" name="meeting_status" placeholder="New" value="Saved" disabled="" readonly>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">Subject<span class="error-star" style="color:red;">*</span></label>
                                    <div class="col-sm-4">
                                        <input class="form-control" type="text" id="meeting_subject" name="meeting_subject" placeholder="Review Meeting" title="Meeting Subject" value="Monthly Review Meeting For Parents" disabled="" required>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">Location<span class="error-star" style="color:red;">*</span></label>
                                    <div class="col-sm-4">
                                        <input class="form-control" type="text" id="meeting_location" name="meeting_location" oninput="location(event)" title="Meeting Location" maxlength="20" placeholder="Enter Location" value="Chennai" disabled="" required>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">Start Date and Time<span class="error-star" style="color:red;">*</span></label>
                                    <div class="col-sm-4">

                                        <input type='date' class="form-control" id='meeting_startdate' name="meeting_startdate" title="Meeting Start Date" onchange="autodateupdate(this)" value="2023-01-23" disabled="" required>

                                    </div>
                                    <div class="col-sm-2">
                                        <div class="content">
                                            <input class="form-control" type="time" id="meeting_starttime" name="meeting_starttime" title="Meeting Start Time" value="10:00:00" disabled="" required>
                                        </div>

                                    </div>

                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">End Date and Time<span class="error-star" style="color:red;">*</span></label>
                                    <div class="col-sm-4">
                                        <input type='date' class="form-control" id="meeting_enddate" name="meeting_enddate" title="Meeting End Date" onchange="autodateupdate(this)" required placeholder="MM/DD/YYYY" value="2023-01-23" disabled="">
                                    </div>
                                    <div class="col-sm-2">

                                        <div class="content">
                                            <input class="form-control" type="time" id="meeting_endtime" name="meeting_endtime" title="Meeting End Time" value="11:00:00" disabled="" required>
                                        </div>

                                    </div>
                                    <div class="col-lg-12">
                                        <div class="form-group">
                                        <label class="col-form-label">Description</label>

                                            <textarea class="form-control" id="meeting_description" name="meeting_description"  disabled="" required>Kindly Attend the Review Meeting</textarea>
                                        </div>
                                    </div>
                                    <!-- <div class="row text-center">
                          <div class="col-md-12">

                            <button type="submit" class="btn btn-warning">Save</button>
                            <button type="" class="btn btn-success">Send</button>
                            <button type="" class="btn btn-danger">Cancel</button>
                          </div>
                        </div> -->

                                </div>
                            </div>
                        </div>
                    </div>

                    </form>



                </div>
            </div>




            <br>
            <div class="row text-center">
                <div class="col-md-12">
                    <a type="button" class="btn btn-labeled back-btn" title="Back" href="{{route('Parentsreviewinvite')}}" style="color:white !important">
                        <span class="btn-label" style="font-size:13px !important;"><i class="fa fa-arrow-left"></i></span> Back</a>
                </div>
            </div>

        </div>
    </section>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/tinymce/4.5.6/tinymce.min.js"></script>
<script src="http://cdnjs.cloudflare.com/ajax/libs/tinymce/4.5.6/jquery.tinymce.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.26.0/moment.min.js"></script>
<script type="text/javascript">
    tinymce.init({
        selector: 'textarea#description',
        height: 180,
        menubar: false,
        branding: false,
        toolbar: 'undo redo | formatselect | ' +
            'bold italic backcolor | alignleft aligncenter ' +
            'alignright alignjustify | bullist numlist outdent indent | ' +
            'removeformat | help',
        content_style: 'body { font-family:Helvetica,Arial,sans-serif; font-size:14px }'
    });
</script>

























@endsection