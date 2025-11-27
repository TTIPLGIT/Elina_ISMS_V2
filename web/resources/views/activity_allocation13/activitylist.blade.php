@extends('layouts.adminnav')

@section('content')

<div class="main-content">
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
    {{ Breadcrumbs::render('activity_allocation13.index') }}
    <div class="row">
    <div class="col-md-12" style="display: flex;justify-content: end;">
        <select id="leadTypeFilter" class="col-3 form-control default " onchange="selectedtype();">
            <option value="all" selected>All</option>
            <option value="1">Parent</option>
            <option value="2">Child</option>
        </select>
    </div>
        <div class="col-12">
            <a type="button" href="{{ route('activity_allocation13.create') }}" value="Cancel" class="btn btn-labeled btn-info" title="create" style="background: #044a95 !important; border-color:#a9ca !important; color:white !important;margin-top: 0.5rem;">
                <span class="btn-label" style="font-size:15px !important; padding:8px !important"><i class="fa fa-plus"></i></span><span style="font-size:15px !important; padding:8px !important">Activity Allocation</span></a>
            <a type="button" href="{{ route('privacy.update',\Crypt::encrypt('2')) }}" value="Cancel" class="btn btn-labeled btn-info" title="create" style="background: #044a95 !important;float: right; border-color:#a9ca !important; color:white !important;margin-top: 0.5rem;">
                <span class="btn-label" style="font-size:15px !important; padding:8px !important;left: 0;background: none;">Privacy Agreement</span></a>
            <!-- <a type="button" style="font-size:15px;" class="btn btn-success btn-lg" title="Create" id="gcb" href="{{ route('newenrollment.create') }}">NewEnrollment<i class="fa fa-plus" aria-hidden="true"></i></a> -->
            <div class="card">
                <div class="card-body">
                    <div class="col-lg-12 text-center">
                        <h4 class="text-center" style="color:darkblue">13+ Activity Allocation List</h4>
                    </div>
                    <div class="table-wrapper table1">
                        <div class="table-responsive">
                            <table class="table table-bordered" id="align1">
                                <thead>
                                    <tr>
                                        <th>Sl.No</th>
                                        <th>Enrollment ID</th>
                                        <th>Child Name</th>
                                        <th>Category</th>
                                        <th>Progression</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    <tr>
                                        <td>1</td>
                                        <td>EN/2024/01/025</td>
                                        <td>Pavani</td>
                                        <td>Parent</td>
                                        <td>
                                            <div class="progress" style="height: 25px;">
                                                <div class="progress-bar" role="progressbar" aria-valuemax="100" style="font-weight: bolder;color:white; width:35%;background-color:red;">5/15</div>
                                            </div>
                                        </td>
                                        <td>

                                            <a class="btn btn-link" title="Edit" href="{{route('activity_allocation13.edit','1')}}"><i class="fa fa-pencil-square-o" style="color:green"></i></a>

                                            <!-- <a class="btn btn-link" title="Show" href=""><i class="fas fa-eye" style="color:green"></i></a> -->

                                            <a class="btn btn-link" title="Face to Face Observation" href="{{route('activity_allocation13.observation','1')}}"><i class="fa fa-file-code-o" style="color:green"></i></a>

                                        </td>
                                    </tr>
                                    <tr>
                                        <td>2</td>
                                        <td>EN/2024/01/025</td>
                                        <td>Pavani</td>
                                        <td>Child</td>
                                        <td>
                                            <div class="progress" style="height: 25px;">
                                                <div class="progress-bar" role="progressbar" aria-valuemax="100" style="font-weight: bolder;color:white; width:35%;background-color:red;">10/15</div>
                                            </div>
                                        </td>
                                        <td>

                                            <a class="btn btn-link" title="Edit" href="{{route('activity_allocation13.edit','1')}}"><i class="fa fa-pencil-square-o" style="color:green"></i></a>

                                            <!-- <a class="btn btn-link" title="Show" href=""><i class="fas fa-eye" style="color:green"></i></a> -->

                                            <a class="btn btn-link" title="Face to Face Observation" href="{{route('activity_allocation13.observation','1')}}"><i class="fa fa-file-code-o" style="color:green"></i></a>

                                        </td>
                                    </tr>

                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="table-wrapper table2" style="display:none !important">
                        <div class="table-responsive">
                            <table class="table table-bordered" id="align2">
                                <thead>
                                    <tr>
                                        <th>Sl.No</th>
                                        <th>Enrollment ID</th>
                                        <th>Child Name</th>
                                        <th>Category</th>
                                        <th>Progression</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    <tr>
                                        <td>1</td>
                                        <td>EN/2024/01/025</td>
                                        <td>Pavani</td>
                                        <td>Parent</td>
                                        <td>
                                            <div class="progress" style="height: 25px;">
                                                <div class="progress-bar" role="progressbar" aria-valuemax="100" style="font-weight: bolder;color:white; width:35%;background-color:red;">5/15</div>
                                            </div>
                                        </td>
                                        <td>

                                            <a class="btn btn-link" title="Edit" href="{{route('activity_allocation13.edit','1')}}"><i class="fa fa-pencil-square-o" style="color:green"></i></a>

                                            <!-- <a class="btn btn-link" title="Show" href=""><i class="fas fa-eye" style="color:green"></i></a> -->

                                            <a class="btn btn-link" title="Face to Face Observation" href="{{route('activity_allocation13.observation','1')}}"><i class="fa fa-file-code-o" style="color:green"></i></a>

                                        </td>
                                    </tr>
                                   

                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="table-wrapper table3" style="display:none !important">
                        <div class="table-responsive">
                            <table class="table table-bordered" id="align3">
                                <thead>
                                    <tr>
                                        <th>Sl.No</th>
                                        <th>Enrollment ID</th>
                                        <th>Child Name</th>
                                        <th>Category</th>
                                        <th>Progression</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    
                                    <tr>
                                        <td>1</td>
                                        <td>EN/2024/01/025</td>
                                        <td>Pavani</td>
                                        <td>Child</td>
                                        <td>
                                            <div class="progress" style="height: 25px;">
                                                <div class="progress-bar" role="progressbar" aria-valuemax="100" style="font-weight: bolder;color:white; width:35%;background-color:red;">10/15</div>
                                            </div>
                                        </td>
                                        <td>

                                            <a class="btn btn-link" title="Edit" href="{{route('activity_allocation13.edit','1')}}"><i class="fa fa-pencil-square-o" style="color:green"></i></a>

                                            <!-- <a class="btn btn-link" title="Show" href=""><i class="fas fa-eye" style="color:green"></i></a> -->

                                            <a class="btn btn-link" title="Face to Face Observation" href="{{route('activity_allocation13.observation','1')}}"><i class="fa fa-file-code-o" style="color:green"></i></a>

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

<script>
    var com;
    var total;
    var rows;

    for (i = 0; i < rows.length; i++) {

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
            var comactivity_id = com[k].activity_initiation_id;
            if (comactivity_id == activity_initiation_id) {
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

    }
</script>
<script>
    setTimeout(func, 2000);

    function func() {
        let url = new URL(window.location.href)
        let message = url.searchParams.get("message");
        let message1 = url.searchParams.get("message1");

        if (message != null) {
            Swal.fire({
                title: "Success",
                text: "Activity Initiated Successfully",
                icon: "success",
            });
        }
        if (message1 != null) {
            Swal.fire({
                title: "Success",
                text: "Activity Updated Successfully",
                icon: "success",
            });
        }
    };

    window.onload = function() {
        let url = new URL(window.location.href)
        let message = url.searchParams.get("message");
        let message1 = url.searchParams.get("message1");


        if (message != null) {
            func();
            window.history.pushState("object or string", "Activity Initiated Successfully", "/activity_allocation13");
        }
        if (message1 != null) {
            func();
            window.history.pushState("object or string", "Activity Updated Successfully", "/activity_allocation13");

        }

    };
    function selectedtype()
    {
        var selector=document.getElementById('leadTypeFilter').value;
        if(selector =="all")
        {
            document.querySelector('.table1').style.display="block";
            document.querySelector('.table2').style.display="none";
            document.querySelector('.table3').style.display="none";

        }
        else if(selector =="1")
        {
            document.querySelector('.table1').style.display="none";
            document.querySelector('.table2').style.display="block";
            document.querySelector('.table3').style.display="none";

        }
        else if(selector =="2")
        {
            document.querySelector('.table1').style.display="none";
            document.querySelector('.table2').style.display="none";
            document.querySelector('.table3').style.display="block";

        }
        else
        {
            
            document.querySelector('.table1').style.display="block";
            document.querySelector('.table2').style.display="none";
            document.querySelector('.table3').style.display="none";
        }

    }
</script>


@endsection