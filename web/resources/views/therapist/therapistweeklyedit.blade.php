@extends('layouts.adminnav')
<script type="text/javascript" src="https://cdn.rawgit.com/t4t5/sweetalert/v0.2.0/lib/sweet-alert.min.js"></script>

@section('content')
<style>
    #frname {
        color: red;
    }

    .form-control {
        background-color: #ffffff !important;
    }

    .is-coordinate {
        justify-content: center;
    }

    .centerid {
        width: 100%;
        text-align: center;
    }
</style>

<div class="main-content">

    <!-- Main Content -->
    <section class="section">

        {{ Breadcrumbs::render('TherapistWeeklyEdit',1) }}
        <div class="section-body mt-1">
            <h5 class="text-center" style="color:darkblue">Therapist Initiative</h5>
            <div class="row">
                <div class="col-12">

                    <div class="card">
                        <div class="card-body">

                            <form method="POST" action="{{ route('therapist.store') }}">

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


                                    <div class="col-md-4 sp1">
                                        <div class="form-group">
                                            <label class="control-label required">Specialization</label>
                                            <input class="form-control" type="text" id="Specialization" name="Specialization" value="Speech" disabled="" required autocomplete="off">
                                        </div>
                                    </div>



                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="control-label">Therapist</label>
                                            <input class="form-control" type="text" id="Therapist" name="Therapist" value="Malini" disabled="" required autocomplete="off">
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


                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">Start Date and Time</label>
                                    <div class="col-sm-4">

                                        <input type='date' class="form-control" id='meeting_startdate' name="meeting_startdate" value="2023-01-23" required>

                                    </div>
                                    <div class="col-sm-2">
                                        <div class="content">
                                            <input class="form-control" type="time" id="meeting_starttime" name="meeting_starttime" value="10:00:00" required>
                                        </div>

                                    </div>

                                    <div class="col-md-2" style="margin: auto !important;">
                                        <label class="control-label centerid">Status</label> <br>
                                        <input class="form-control" type="text" id="meeting_status" name="meeting_status" value="Saved" disabled="" placeholder="" required autocomplete="off">
                                    </div>

                                </div>




                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">End Date and Time</label>
                                    <div class="col-sm-4">
                                        <input type='date' class="form-control" id="meeting_enddate" name="meeting_enddate" value="2023-01-23" required placeholder="MM/DD/YYYY">
                                    </div>
                                    <div class="col-sm-2">

                                        <div class="content">
                                            <input class="form-control" type="time" id="meeting_endtime" name="meeting_endtime" value="11:00:00" required>
                                        </div>

                                    </div>

                                    <div class="col-md-10" style="display: flex;flex-direction: column;align-items: flex-end;margin-top: -110px;margin-left: -16px;height: 3%;">
                                        <div class="col-md-3">
                                            <input type="radio" id="contactChoice1" name="contact" value="email" checked>
                                            <label for="contactChoice1">Apply for 8 months</label>
                                        </div>
                                        <div class="col-md-3">
                                            <input type="radio" id="contactChoice2" name="contact" value="phone">
                                            <label for="contactChoice2">Apply for this week</label>
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <label class="control-label">Notes</label><span class="error-star" style="color:red;">*</span>

                                        <div class="form-group">
                                            <textarea class="form-control" id="description" name="meeting_description" value="ORM Meeting" readonly>Kindly Attend the Session meeting</textarea>
                                        </div>
                                    </div>

                                </div>
                                <div class="row text-center">
                                    <div class="col-md-12">
                                        <a type="" onclick="send(event)" class="btn btn-labeled btn-succes" title="Submit" style="background:orange !important; border-color:green !important; color:white !important;height: 34px !important;">
                                            <span class="btn-label" style="font-size:16px !important;"><i class="fa fa-check"></i></span>Save</a>

                                        <button type="submit" class="btn btn-success" name="type" value="sent" onclick="send(event)">Send</button>
                                        <a type="" href="{{route('therapist.weeeklycal')}}" class="btn btn-danger text-white">Cancel</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                </form>



            </div>
        </div>




        <br>

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

<script>
    function save(event)

    {

        //event.preventDefault()

        //const message = "Valuer List Approved Successfully";
        window.location.href = "http://localhost:60161/therapist/initation";
        //    location.replace(`/therapist/initation?message5="${message5}"`);

    }
</script>
<script>
    function send(event)

    {

        event.preventDefault()

        const message5 = "Valuer List Approved Successfully";
        window.location.href = "http://localhost:60161/therapist/initation?message5=" + message5 + "";
        //    location.replace(`/therapist/initation?message5="${message5}"`);

    }
</script>

<script>
    function cancel()

    {
        window.location.href = "http://localhost:60161/therapist/initation/";

    }
</script>























@endsection