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

        {{ Breadcrumbs::render('TherapistdetailsListShow',1) }}
        <div class="section-body mt-1">
            <h5 class="text-center" style="color:darkblue">Therapist Allocated Session Details View</h5>
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
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <div class="col-12">

            <div class="card">
                <div class="card-body">

                    <div class="row">
                        <div class="col-lg-12 text-center">
                            <h4 style="color:darkblue;"></h4>
                        </div>
                    </div>
                    <div class="table-wrapper">
                        <div class="table-responsive">
                            <table class="table table-bordered" id="align">
                                <thead>

                                    <tr>
                                        <th width="7%">Sl.No.</th>
                                        <th width="10%">Therapist</th>
                                        <th width="12%">Specialization</th>
                                        <th width="12%">Date&Time</th>
                                        <th width="12%">Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>1</td>
                                        <td>Sumi X(2) Y(40)</td>
                                        <td>Special Education</td>
                                        <td>23-01-2023 10:00:00</td>
                                        <td>X-Completed Session<br> Y-Scheduled Session</td>
                                        
                                    </tr>

                                    <tr>
                                        <td>2</td>
                                        <td>Sukanya X(2) Y(40)</td>
                                        <td>Operational</td>
                                        <td>24-01-2023 10:00:00</td>
                                        <td>X-Completed Session<br> Y-Scheduled Session</td>
                                        
                                    </tr>

                                    <tr>
                                        <td>3</td>
                                        <td>NA</td>
                                        <td>Speech</td>
                                        <td>-</td>
                                        <td>-</td>
                                        
                                    </tr>

                                    <tr>
                                        <td>4</td>
                                        <td>Stephen X(2) Y(40)</td>
                                        <td>Physical Education</td>
                                        <td>27-01-2023 10:00:00</td>
                                        <td>X-Completed Session<br> Y-Scheduled Session</td>
                                        
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



</div>

</section>







@endsection