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

    .select2-container {
    width: 100% !important;
  }

  .select2-container--default .select2-selection--multiple .select2-selection__choice {
    color: black !important;
  }
</style>

<div class="main-content">

    <!-- Main Content -->
    <section class="section">

        {{ Breadcrumbs::render('TherapistWeeklyShow',1) }}
        <div class="section-body mt-1">
            <h5 class="text-center" style="color:darkblue">Monthly Parents Review Meeting Invite</h5>
            <div class="row">
                <div class="col-12">

                    <div class="card">
                        <div class="card-body">

                            <form method="POST" action="{{ route('therapist.store') }}" enctype="multipart/form-data">

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
                                            <label class="control-label">IS Co-ordinator</label>
                                            <select class="form-control" id="Is Co-ordinator" name="is_coordinator" required>
                                                <option value="Robert">Robert</option>

                                            </select>

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
                                    <label class="col-sm-2 col-form-label">To</label>
                                    <div class="col-sm-4">
                                        <input class="form-control" type="text" id="meeting_to" name="meeting_to" value="Kaviya@talentakeaways.com" placeholder="Email Id" required autocomplete="off">
                                    </div>
                                    <div class="col-md-2">
                                    </div>

                                    <div class="col-md-2" style="margin: auto !important;">
                                        <label class="control-label centerid">Status</label> <br>
                                        <input class="form-control" type="text" id="meeting_status" name="meeting_status" value="Saved" disabled="" placeholder="" required autocomplete="off">
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">CC<span class="error-star" style="color:red;">*</span></label>
                                    <div class="col-sm-4">
                                        <select class="form-control mail_cc js-select2" id="mail_cc" multiple="multiple" name="mail_cc[]">
                                            <option> </option>

                                            <option value="robert@talentakeaways.com" selected>Robert</option>
                                            <option value="deena@talentakeaways.com">deena</option>


                                        </select>
                                    </div>
                                </div>


                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">Subject</label>
                                    <div class="col-sm-4">
                                        <input class="form-control" type="text" id="meeting_subject" name="meeting_subject" value="Review Meeting for Parents" placeholder="ORM Meeting" required autocomplete="off">
                                    </div>

                                </div>


                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">Location</label>
                                    <div class="col-sm-4">
                                        <input class="form-control" type="text" id="meeting_location" name="meeting_location" value="Chennai" placeholder="Enter Location" required autocomplete="off">
                                    </div>
                                </div>

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
                                        <br>

                                    </div>
                                    <div class="col-lg-12">
                                        <div class="form-group">
                                        <label class="col-form-label">Description</label>

                                            <textarea class="form-control" id="description" name="meeting_description" value="ORM Meeting">kindly attend the meeting</textarea>
                                        </div>
                                    </div>

                                </div>
                                <div class="row text-center">
                                    <div class="col-md-12">
                                    <button type="" onclick="save(event)" class="btn btn-labeled btn-succes" title="Submit" style="background:orange !important; border-color:green !important; color:white !important;height: 34px !important;">
                                            <span class="btn-label" style="font-size:16px !important;"><i class="fa fa-check"></i></span>Save</button>
                                        <button type="submit" class="btn btn-success" name="type" value="sent" onclick="send(event)">Send</button>
                                        <a type=""href="{{route('Parentsreviewinvite')}}" class="btn btn-danger text-white">Cancel</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                </form>


            </div>
        </div>
</div>
</section>
</div>

<script>
  $(".js-select2").select2({
    closeOnSelect: false,
    placeholder: " Please Select Users",
    allowHtml: true,
    tags: true
  });
</script>

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
    
    event.preventDefault()
    
    const message3 = "Valuer List Approved Successfully";
    window.location.href = "http://localhost:60161/parents/review/invite?message3="+message3+"";
//    location.replace(`/therapist/initation?message5="${message5}"`);

}
    function send(event)

    {
        
        event.preventDefault()
        
        const message4 = "Valuer List Approved Successfully";
        window.location.href = "http://localhost:60161/parents/review/invite?message4="+message4+"";
    //    location.replace(`/therapist/initation?message5="${message5}"`);

    }
</script>


























@endsection