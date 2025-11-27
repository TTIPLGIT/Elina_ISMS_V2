@extends('layouts.adminnav')
@section('content')
<style>
    .fc-view>table td {
        height: 50px !important;
    }

    .fc-row.fc-week.fc-widget-content {
        height: 80px !important;
    }

    #calendar {
        background: white;
        padding: 5px;
        margin: 40px auto;
        padding: 15px;
    }

    .fc-view>table tr,
    .fc-view>table td {
        border-color: #f2f2f2;
        background: white;
        border: 1px solid;
    }

    .fc-scroller.fc-day-grid-container {
        height: 500px !important;
    }

    .fc-view>table th {
        border-color: #1c1b1b;
    }

    .fc-toolbar.fc-header-toolbar {
        margin: 10px 0 10px 0px;
    }

    .fc-toolbar h2 {
        font-size: 25px;
    }
</style>


<div class="main-content">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.16/dist/sweetalert2.all.min.js"></script>

    <section class="section">
        <div class="section-body mt-2">
            {{ Breadcrumbs::render('weeklyfeedback.index') }}
            <div class="row">

                @if (session('success'))
                <input type="hidden" name="session_data" id="session_data" class="session_data" value="{{ session('success') }}">
                <script type="text/javascript">
                    window.onload = function() {
                        var message = $('#session_data').val();
                        Swal.fire({
                            title: "Success",
                            text: message,
                            type: "success",
                        });
                    }
                </script>
                @elseif(session('fail'))
                <input type="hidden" name="session_data" id="session_data1" class="session_data" value="{{ session('fail') }}">
                <script type="text/javascript">
                    window.onload = function() {
                        var message = $('#session_data1').val();
                        Swal.fire({
                            title: "Info",
                            text: message,
                            type: "info",
                        });
                    }
                </script>
                @endif




                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-12 text-center">
                                    <h4 style="color:darkblue;">Weekly Feedback List View</h4>
                                </div>
                            </div>
                            <div class="table-wrapper">
                                <div class="table-responsive">
                                    <table class="table table-bordered" id="align">
                                        <thead>
                                            <tr>
                                                <th>Sl. No.</th>
                                                <th>Enrollment Id</th>
                                                <th>Child Name</th>
                                                <!-- <th>Is-coordinator</th> -->
                                                <th>Therapist</th>
                                                <th>Progress Status</th>
                                                <th>Status</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>1</td>
                                                <td>EN/2022/12/025</td>
                                                <td>Kaviya</td>
                                                <td>Malini(ST)  <br> Sumi(OT) <br> Sowmya(PH ED) </td>
                                                <td>
                                                    <div class="progress" style="height: 25px;">
                                                        <div class="progress-bar" role="progressbar" aria-valuemax="100" style="font-weight: bolder;color:white; width:35%;background-color:red;">15/32</div>
                                                    </div>

                                                    <div class="progress" style="height: 25px;margin-top:2px !important;">
                                                        <div class="progress-bar" role="progressbar" aria-valuemax="100" style="font-weight: bolder;color:white; width:35%;background-color:red;">15/32</div>
                                                    </div>

                                                    <div class="progress" style="height: 25px;margin-top:4px !important;">
                                                        <div class="progress-bar" role="progressbar" aria-valuemax="100" style="font-weight: bolder;color:white; width:35%;background-color:red;">15/32</div>
                                                    </div>

                                                </td>

                                                <td>InProgress<br>InProgress<br>InProgress </td>
                                                <td class="text-center">
                                                    <!-- <a class="btn" href="{{route('viewcale')}}" style="margin-inline:5px;background-color:indigo;"><i class="fa fa-home" style="color:white!important;font-size: large;"></i></a> -->
                                                    <a class="btn" href="{{route('viewcalendar')}}" style="margin-inline:5px;background-color:blue;"><i class="fa fa-calendar" style="color:white!important"></i></a>
                                                    <a href="#addModal2" data-toggle="modal" data-target="#addModal2" class="btn btn-primary" title="View" data-toggle="modal" data-target="#templates" style="margin-inline:5px" ><i class="fa fa-bars" style="color:white!important"></i></a>
                                                    <a class="btn btn-primary" title="view Document" data-toggle="modal" data-target="#templates" style="margin-inline:5px"><i class="fa fa-download" style="color:white!important"></i></a>
                                                    <!-- <a href="#addModal" data-toggle="modal" data-target="#addModal" style="font-weight: bold;"><span class="text-secondary">Click Here To View All Leads <i class="fa fa-arrow-right" aria-hidden="true"></i></span></a>  -->
                                                    <!-- <a class="btn" title="Delete" onclick="" class="btn btn-link"><i class="fa fa-bars"></i></a> -->
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
    </section>
</div>



<script src="https://code.jquery.com/jquery-1.7.2.min.js"></script>
<script type="application/javascript">
    window.onload = function () {
    let url = new URL(window.location.href)
    let message = url.searchParams.get("Message2");
    if(message !=null)
    {
        $("#addModal2").modal('show');
        window.history.pushState("object or string", "Title", "/weeklyfeedback/");
    }

    };
    
    
    function myFunction(id) {
        Swal.fire({
                title: "Confirmation For Delete ?",
                text: "Are You Sure to delete this data.",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: '#DD6B55',
                confirmButtonText: 'Yes, I am sure!',
                cancelButtonText: "No, cancel it!",
                closeOnConfirm: false,
                closeOnCancel: false
            },
            function(isConfirm) {

                if (isConfirm) {
                    Swal.fire("Deleted!", "Data Deleted successfully!", "success");
                    var url = $('#' + id).val();

                    window.location.href = url;

                } else {
                    Swal.fire("Cancelled", "Your file is safe :)", "error");
                    e.preventDefault();
                }
            });


    }
</script>
<script>
    function getproposaldocument(id) {
        var data = (id);
        $('#modalviewdiv').html('');
        $("#loading_gif").show();
        console.log(id);

        $("#loading_gif").hide();
        var proposaldocuments = "<div class='removeclass' id='modalviewdiv' style=' height:100%'><iframe src='" + data + "' class='document_ifarme_view' style='width:100%; height:100%'></iframe></div>";
        $('.removeclass').remove();
        var document = $('#template').append(proposaldocuments);

    };
</script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js" integrity="sha512-qTXRIMyZIFb8iQcfjXWCO8+M5Tbc38Qi5WzdPOYZHIlZpzBHG3L3by84BBBOiRGiEb7KKtAOAs5qYdUiZiQNNQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.2/fullcalendar.min.js" integrity="sha512-o0rWIsZigOfRAgBxl4puyd0t6YKzeAw9em/29Ag7lhCQfaaua/mDwnpE2PVzwqJ08N7/wqrgdjc2E0mwdSY2Tg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>



<!-- <style>
    #calendar {
    max-width: 600px;
    margin: 40px auto;
    padding: 0 10px;
  }

</style> -->

<script>
    setTimeout(func, 2000);

    function func() {
        let url = new URL(window.location.href)

        let message = url.searchParams.get("message");

        if (message != null) {
            Swal.fire({
                title: "Success",
                text: "Weekly Feedback Saved Successfully",
                icon: "success",
            });


        }
    };
</script>
<script>
    setTimeout(func, 2000);

    function func() {
        let url = new URL(window.location.href)

        let message = url.searchParams.get("message2");

        if (message != null) {
            Swal.fire({
                title: "Success",
                text: "Weekly Feedback Initiated Successfully",
                icon: "success",
            });
        }
    };
</script>

@include('modal.modal')

@endsection