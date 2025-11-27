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
    {{ Breadcrumbs::render('compassobservation.index') }}

        <div class="section-body mt-2">
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
                                    <h4 style="color:darkblue;">Observation List View</h4>
                                </div>
                            </div>
                            <div class="table-wrapper">
                                <div class="table-responsive">
                                    <table class="table table-bordered" id="align">
                                        <thead>
                                            <tr>
                                                <th>Sl.No.</th>
                                                <th>Enrollment Id</th>
                                                <th>Child Name</th>
                                                <!-- <th>Therapist</th>  -->
                                                <th>Status</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>1</td>
                                                <td>EN/2022/12/025</td>
                                                 <td>Kaviya</td>
                                                 <!-- <td>Malini <br> Sumi <br> Sowmya </td> -->
                                                
                                                <td>InProgress
                                                    <!-- <div class="progress" style="height: 25px;">
                                                        <div class="progress-bar" role="progressbar" aria-valuemax="100"style="font-weight: bolder;color:white; width:35%;background-color:red;">1/8</div>
                                                    </div> -->
                                                    
                                                </td>
                                                <td class="text-center">
                                                <!-- <a class="btn" href="{{route('viewcale')}}" style="margin-inline:5px;background-color:indigo;"><i class="fa fa-home" style="color:white!important;font-size: large;"></i></a> -->
                                                <a class="btn" href="{{route('monthlyindex')}}" style="margin-inline:5px;background-color:blue;"><i class="fa fa-calendar" style="color:white!important"></i></a>
                                                    <a href="#addModal6" data-toggle="modal" data-target="#addModal6" class="btn btn-primary" title="View" data-toggle="modal" data-target="#templates" style="margin-inline:5px"><i class="fa fa-bars" style="color:white!important"></i></a>
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


@include('modal.modal')

<script src="https://code.jquery.com/jquery-1.7.2.min.js"></script>
<script type="application/javascript">


window.onload = function () {
    let url = new URL(window.location.href)
    let message = url.searchParams.get("Message2");
    if(message !=null)
    {
        $("#addModal6").modal('show');
        window.history.pushState("object or string", "Title", "/compassobservation/");
    }

    };



</script>
@endsection