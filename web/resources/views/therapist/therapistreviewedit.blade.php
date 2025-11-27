@extends('layouts.adminnav')

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.16/dist/sweetalert2.all.min.js"></script>


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

        {{ Breadcrumbs::render('therapistreviewedit',1) }}
        <div class="section-body mt-1">
            <h5 class="text-center" style="color:darkblue">Monthly Therapist Review Meeting Invite</h5>
            <div class="row">
                <div class="col-12">

                    <div class="card">
                        <div class="card-body">

                            <form action="{{ route('therapist.store') }}" method="POST" id="orm" enctype="multipart/form-data">
                                {{ csrf_field() }}

                                <div class="row is-coordinate">

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="control-label">Enrollment ID</label>

                                            <input class="form-control" name="enrollment_id" placeholder="Enrollment ID" value="EN/2022/12/025" required>
                                        </div>
                                    </div>


                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="control-label">Child ID</label>
                                            <input class="form-control" type="text" id="child_id" name="child_id" value="CH/2022/025" placeholder="OVM1 Meeting" required autocomplete="off">
                                        </div>
                                    </div>



                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="control-label">Child Name</label>
                                            <input class="form-control" type="text" id="child_name" name="child_name" value="Kaviya" placeholder="Enter Name" required autocomplete="off">
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group ">
                                            <label class="control-label">IS Co-ordinator</label>
                                            <select class="form-control" id="Is Co-ordinator" name="is_coordinator1" required>
                                                <option value="Robert">Robert</option>

                                            </select>

                                        </div>
                                    </div>



                                    <div class="col-md-4 sp1">
                                        <div class="form-group">
                                            <label class="control-label required">Specialization</label>
                                            <input class="form-control" type="text" id="Specialization" name="Specialization" value="Speech Therapist" disabled="" required autocomplete="off">
                                        </div>
                                    </div>



                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="control-label">Therapist</label>
                                            <input class="form-control" type="text" id="Therapist" name="Therapist" value="Malini" disabled="" required autocomplete="off">
                                        </div>
                                    </div>

                                    <div class="col-md-4 sp1">
                                        <div class="form-group">
                                            <label class="control-label required">Specialization</label>
                                            <input class="form-control" type="text" id="Specialization" name="Specialization" value="Occupational Therapist" disabled="" required autocomplete="off">
                                        </div>
                                    </div>



                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="control-label">Therapist</label>
                                            <input class="form-control" type="text" id="Therapist" name="Therapist" value="robert" disabled="" required autocomplete="off">
                                        </div>
                                    </div>




                                </div>
                        </div>
                    </div>
                </div>




                <div class="row">
                    <div class="col-12">

                        <div class="card">
                            <div class="card-body">

                                <div class="form-group row" style="margin-bottom: 5px;">
                                    <label class="col-sm-2 col-form-label">To</label>
                                    <div class="col-sm-4">
                                        <input class="form-control" type="text" name="meeting_to" placeholder="Email Id" value="malini12@gmail.com" autocomplete="off">
                                    </div>
                                    <div class="col-md-2">
                                    </div>

                                    <div class="col-md-2">
                                        <label class="control-label centerid">Status</label> <br>
                                        <input class="form-control" type="text" id="meeting_status" name="meeting_status" value="Saved" required autocomplete="off">
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
                                        <input class="form-control" type="text" id="meeting_subject" name="meeting_subject" value="Review Meeting" placeholder="ORM Meeting" required autocomplete="off">
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
                                        <button type="" onclick="send(event)" class="btn btn-success" name="type" value="sent">Send</button>
                                        <a type="" href="{{route('Therapistreviewinvite')}}" class="btn btn-danger text-white">Cancel</a>
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
<script>
    meeting_startdate.min = new Date().toISOString().split("T")[0];
    meeting_enddate.min = new Date().toISOString().split("T")[0];
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/tinymce/4.5.6/tinymce.min.js"></script>
<script src="http://cdnjs.cloudflare.com/ajax/libs/tinymce/4.5.6/jquery.tinymce.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.26.0/moment.min.js"></script>
<script type="text/javascript">
    const iscoordinatorfn = (event) => {
        let coordinatorname = event.target.value;
        let currentcoordinator = event.target.name;
        if (currentcoordinator === "is_coordinator1") {
            let iscoordinater2new = JSON.parse($('#is_coordinator2old').attr('data-attr'));
            iscoordinater2new = iscoordinater2new.filter(name => name.name !== coordinatorname)
            alternatecoordinator = document.getElementById('is_coordinator2')
            var ddd = '<option >Select-IS-Coordinator-2</option>';
            for (i = 0; i < iscoordinater2new.length; i++) {
                ddd += '<option value="' + iscoordinater2new[i].name + '">' + iscoordinater2new[i].name + '</option>';
            }
            let currentcoordinatorname = alternatecoordinator.value;
            alternatecoordinator.innerHTML = "";
            alternatecoordinator.innerHTML = ddd;
            alternatecoordinator.value = currentcoordinatorname;
        } else {
            let iscoordinater1new = JSON.parse($('#is_coordinator1old').attr('data-attr'));
            iscoordinater1new = iscoordinater1new.filter(name => name.name !== coordinatorname)
            alternatecoordinator = document.getElementById('is_coordinator1');
            var ddd = '<option >Select-IS-Coordinator-1</option>';
            for (i = 0; i < iscoordinater1new.length; i++) {
                ddd += '<option value="' + iscoordinater1new[i].name + '">' + iscoordinater1new[i].name + '</option>';
            }
            let currentcoordinatorname = alternatecoordinator.value;
            alternatecoordinator.innerHTML = "";
            alternatecoordinator.innerHTML = ddd;
            alternatecoordinator.value = currentcoordinatorname;
        }

        //...
    }

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
        window.location.href = "http://localhost:60161/therapist/review/invite?message3=" + message3 + "";
        //    location.replace(`/therapist/initation?message5="${message5}"`);

    }

    function send(event)

    {

        event.preventDefault()

        const message4 = "Valuer List Approved Successfully";
        window.location.href = "http://localhost:60161/therapist/review/invite?message4=" + message4 + "";
        //    location.replace(`/therapist/initation?message5="${message5}"`);

    }
</script>























@endsection