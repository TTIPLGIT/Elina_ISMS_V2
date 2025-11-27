@extends('layouts.adminnav')

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

    #invite {
        display: none;
    }

    #co_one,
    #co_two {
        padding: 0 0 0 5px;
        background: transparent;
    }
    .form-control
    {
        background-color: rgb(128 128 128 / 34%) !important;
    }
</style>
<div class="main-content" style="position:absolute !important; z-index: -2!important; ">

    <!-- Main Content -->
    <section class="section">


        <div class="section-body mt-1">
            <h5 class="text-center" style="color:darkblue">Home Tracker Initiate View</h5>
            <div class="row">
                <div class="col-12">

                    <div class="card">
                        <div class="card-body">

                            <!-- <form method="POST" action="{{ route('ovm1.store') }}" onsubmit="return validateForm()"> -->
                            <form action="{{route('hometracker')}}" method="GET" id="home_tracker" enctype="multipart/form-data">

                                @csrf
                                <div class="row is-coordinate">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="control-label">Enrollment ID</label>
                                            <input class="form-control" name="enrollment_id" value="EN/2022/12/025" placeholder="Enrollment ID" disabled=""required>
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
                                        <div class="form-group">
                                            <label class="control-label"> Date<span class="error-star" style="color:red;">*</span></label>
                                            <input type='date' class="form-control" id='meeting_startdate' name="meeting_startdate" title="Start Date"  value="2023-01-22" disabled=""required>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group ">
                                            <label class="control-label">Status<span class="error-star" style="color:red;">*</span></label>
                                            <input class="form-control" type="text" id="Status" name="Status" value="Saved" disabled="" required autocomplete="off">

                                        </div>
                                    </div>

                                </div>
                        </div>
                    </div>
                </div>
            </div>
            <br>

            <!-- <div id="calendar"></div> -->


            <div class="row text-center">
                <div class="col-md-12">
                    <a type="button" class="btn btn-labeled back-btn" title="Back" href="{{route('hometrackerInit')}}" style="color:white !important">
                        <span class="btn-label" style="font-size:13px !important;"><i class="fa fa-arrow-left"></i></span> Back</a>
                </div>
            </div>
        </div>
        <br>

    </section>
</div>






<!-- Calander -->
<div class="modal fade row" id="calModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered col-12" role="document">
        <div class="modal-content">
            <!-- <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Modal title</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div> -->
            <div class="modal-body">
                <div id="calendar1"></div>
            </div>
            <!-- <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div> -->
        </div>
    </div>
</div>
<div class="modal fade" id="calModal2" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <!-- <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Modal title</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div> -->
            <div class="modal-body">
                <div id="calendar2"></div>
            </div>
            <!-- <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div> -->
        </div>
    </div>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/tinymce/4.5.6/tinymce.min.js"></script>
<script src="http://cdnjs.cloudflare.com/ajax/libs/tinymce/4.5.6/jquery.tinymce.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.26.0/moment.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.16/dist/sweetalert2.all.min.js"></script>


@include('ovm1.cal')
<!-- End -->
<script type="text/javascript">
    const iscoordinatorfn = (event) => {
        let coordinatorname = event.target.value;
        let currentcoordinator = event.target.name;
        if (currentcoordinator === "is_coordinator1") {
            let iscoordinater2new = JSON.parse($('#is_coordinator2old').attr('data-attr'));
            intcoordinatorname = parseInt(coordinatorname);
            iscoordinater2new = iscoordinater2new.filter(name => name.id !== intcoordinatorname)
            alternatecoordinator = document.getElementById('is_coordinator2')
            var ddd = '<option value="">Select-IS-Coordinator-2</option>';
            for (i = 0; i < iscoordinater2new.length; i++) {
                ddd += '<option value="' + iscoordinater2new[i].id + '">' + iscoordinater2new[i].name + '</option>';
            }
            let currentcoordinatorname = alternatecoordinator.value;
            alternatecoordinator.innerHTML = "";
            alternatecoordinator.innerHTML = ddd;
            alternatecoordinator.value = currentcoordinatorname;
        } else {
            let iscoordinater1new = JSON.parse($('#is_coordinator1old').attr('data-attr'));
            intcoordinatorname = parseInt(coordinatorname);
            iscoordinater1new = iscoordinater1new.filter(name => name.id !== intcoordinatorname)
            alternatecoordinator = document.getElementById('is_coordinator1');
            var ddd = '<option value="">Select-IS-Coordinator-1</option>';
            for (i = 0; i < iscoordinater1new.length; i++) {
                ddd += '<option value="' + iscoordinater1new[i].id + '">' + iscoordinater1new[i].name + '</option>';
            }
            let currentcoordinatorname = alternatecoordinator.value;
            alternatecoordinator.innerHTML = "";
            alternatecoordinator.innerHTML = ddd;
            alternatecoordinator.value = currentcoordinatorname;
        }
        //...
    }
</script>

<script>
    meeting_startdate.min = new Date().toISOString().split("T")[0];
</script>


<!-- //validation -->
<script>
    function Childname(event) {
        let value = event.target.value || '';
        value = value.replace(/[^a-z A-Z ]/, '', );
        event.target.value = value;

    }

    function location(event) {
        let value = event.target.value || '';
        value = value.replace(/[^a-z A-Z ]/, '', );
        event.target.value = value;

    }
</script>

<script type="text/javascript">
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    function GetChilddetails() {
        var enrollment_child_num = $("select[name='enrollment_child_num']").val();

        if (enrollment_child_num != "") {
            $.ajax({
                url: "{{ url('/userregisterfee/enrollmentlist') }}",
                type: 'POST',
                data: {
                    'enrollment_child_num': enrollment_child_num,
                    _token: '{{csrf_token()}}'
                }
            }).done(function(data) {
                // var category_id = json.parse(data);
                console.log(data);

                if (data != '[]') {

                    // var user_select = data;
                    var optionsdata = "";

                    document.getElementById('child_id').value = data[0].child_id;
                    document.getElementById('child_name').value = data[0].child_name;
                    document.getElementById('enrollment_id').value = data[0].enrollment_id;
                    document.getElementById('user_id').value = data[0].user_id;


                    console.log(data[0].user_id);


                } else {
                    document.getElementById('child_name');
                    var ddd = '<option value="child_name">Select Enrollment_child_num</option>';
                    var demonew = $('#child_name').html(ddd);
                }
            })
        } else {
            document.getElementById('initiated_by');
            var ddd = '<option value="initiated_by">Select Enrollment_child_num</option>';
            var demonew = $('#initiated_by').html(ddd);
        }
    };
</script>
<script>
    function validateForm1(a) {

        var enrollment_child_num = $('#enrollment_child_num').val();
        if (enrollment_child_num == "") {
            Swal.fire("Please Select Enrolment Number", "", "error");
            return false;
        }
        var child_id = $('#child_id').val();
        if (child_id == "") {
            Swal.fire("Please Enter Child ID", "", "error");
            return false;
        }
        var child_name = $('#child_name').val();
        if (child_name == "") {
            Swal.fire("Please Enter Child Name", "", "error");
            return false;
        }
        var meeting_startdate = $('#meeting_startdate').val();

        if (document.getElementById('meeting_startdate').value == "") {
            Swal.fire("Please Select Start Date ", "", "error");
            return false;
        }
        Swal.fire({

            title: "Are you want to Initiate the HomeTracker ?",
            text: "Please click 'Yes' to Initiate the HomeTracker.",
            icon: "warning",
            customClass: 'swalalerttext',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            confirmButtonText: "Yes",
            cancelButtonText: "No",
            closeOnConfirm: false,
            closeOnCancel: true,
            showLoaderOnConfirm: true,
            width: '550px',
        }).then((result) => {
            if (result.value) {
                const message = "Valuer List Approved Successfully";
                location.replace(`/hometracker?message2="${message}"`);
            }
        })



    }


    function validateForm(a) {
        var enrollment_child_num = $('#enrollment_child_num').val();
        if (enrollment_child_num == "") {
            Swal.fire("Please Select Enrolment Number", "", "error");
            return false;
        }
        var child_id = $('#child_id').val();
        if (child_id == "") {
            Swal.fire("Please Enter Child ID", "", "error");
            return false;
        }
        var child_name = $('#child_name').val();
        if (child_name == "") {
            Swal.fire("Please Enter Child Name", "", "error");
            return false;
        }
        var meeting_startdate = $('#meeting_startdate').val();

        if (document.getElementById('meeting_startdate').value == "") {
            Swal.fire("Please Select Start Date ", "", "error");
            return false;
        }

        const message = "Valuer List Approved Successfully";
        location.replace(`/hometracker?message="${message}"`);

    }

    function autodateupdate(datev) {
        $('#meeting_startdate').val(datev.value);
        $('#meeting_enddate').val(datev.value);
    }

    //  function() {

    //   var calendar = new Calendar('#calendar', data);

    // }();
</script>





@endsection