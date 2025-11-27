@extends('layouts.adminnav')
@section('content')
@include('dashboard_css')
<style>
    .borderBoard {
        border: 1px solid rgba(0, 0, 0, .125);
    }

    .table:not(.table-sm):not(.table-md):not(.dataTable) td,
    .table:not(.table-sm):not(.table-md):not(.dataTable) th {
        border: 1px solid black !important;
    }

    .badgeact {
        position: relative;
    }

    .badgeact::after {
        content: attr(data-badge);
        position: absolute;
        top: -3px;
        right: -8px;
        width: 10px;
        height: 10px;
        border-radius: 50%;
        background-color: #FF5151;
        color: white;
        font-size: 10px;
        text-align: center;
        line-height: 16px;
    }
</style>
<div class="main-content contentpadding" style="position:absolute; z-index:-1">
    <div class="section-body">
        <div class="row">
            @if($modules['user_role'] != 'IS Coordinator')
            <div class="col-md-3">
                @else
                <div class="col-md-4">
                    @endif
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex flex-column align-items-center text-center">
                                @if($rows['users']['profile_image'] != "")
                                <img src="{{$rows['users']['profile_image'] }}" alt="" width="100" height="100" style="border-radius:50%;height: 130px;width: 130px;margin: 10px 0px 10px 0px;">
                                @else
                                <img style="margin-top: 10px;" src="images\profile-picture.webp" alt="profile" class="rounded-circle p-1 bg-primary" width="110">
                                <div class="mt-3">
                                    <h4 class="headercolor">{{$rows['users']['name']}}</h4>
                                    <p class="text-secondary mb-1 headercolor">{{$rows['users']['role_name']}}</p>
                                </div>
                                @endif
                            </div>
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                                    <h6 class="mb-0" style="color:#6b747b;">
                                        <i class="fa fa-briefcase" aria-hidden="true"></i> Designation
                                    </h6>
                                    <span class="text-secondary" style="font-weight:bold;">{{$rows['users']['role_name']}}</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center flex-nowrap">
                                    <h6 style="color:#6b747b; white-space: nowrap;"><i class="fa fa-clock-o" style="font-size:15px; "></i> <span style="white-space: nowrap;">Last Login</span> </h6>
                                    <span class="text-secondary" style="padding: 0 0 0 14px;font-weight: 700;">{{ date('d M - h:i A', strtotime($rows['users']['login_time'])) }}</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                                    <a href="{{ route('profilepage') }}" style="text-align: right; font-weight: bold; color:#6b747b;"><i class="fa fa-user" style="font-size:16px; "></i> View Profile</a>
                                    <a style="text-align: left; font-weight: bold; color:#6b747b;" href="#" onclick="event.preventDefault();document.getElementById('logout-form').submit();">Logout <i class="fa fa-sign-out" style="font-size:15px"></i></a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                @if($modules['user_role'] != 'IS Coordinator')
                <div class="col-md-5">
                    @else
                    <div class="col-md-8">
                        @endif
                        <div class="card cardheight headercolor">
                            <div class="card-header"><i class="fa fa-folder-open" id="fa-icon" aria-hidden="true"></i> Elina Student Activity List</div>
                            <div class="card-body" id="scroll">
                                <div class="card mb-3 widget-content bg">
                                    <div class="widget-content-wrapper text-white">
                                        <div class="widget-content-left">
                                            <div class="widget-heading fontsweight fontsizes">Elina Lead</div>
                                            <div style="text-align: left;">
                                                <a class="dbox__title fontsweight" onclick="getleadDetails()">View</a>
                                                <!-- <a class="dbox__title fontsweight" href="#addModal" data-toggle="modal" data-target="#addModal">View</a> -->
                                            </div>
                                        </div>
                                        <div class="widget-content-right">
                                            <div class="widget-numbers text-white numberfontsize"><span>{{ $rows['elinalead'] ?? '' }}
                                            </span></div>
                                        </div>
                                    </div>
                                </div>

                                <div class="card mb-3 widget-content bg">
                                    <div class="widget-content-wrapper text-white">
                                        <div class="widget-content-left">
                                            <div class="widget-heading fontsweight fontsizes">Overall OVM Meetings</div>
                                            <div style="text-align: left;">
                                                <a class="dbox__title fontsweight" onclick="getOVMDetails()">View</a>
                                                <!-- <a class="dbox__title fontsweight" href="#elina_ovm" data-toggle="modal" data-target="#elina_ovm">View</a> -->
                                            </div>
                                        </div>
                                        <div class="widget-content-right">
                                            <div class="widget-numbers text-white numberfontsize"><span> {{ $rows['chart2'][0]['ovm_count'] ?? '' }}
                                            </span></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card mb-3 widget-content bg">
                                    <div class="widget-content-wrapper text-white">
                                        <div class="widget-content-left">
                                            <div class="widget-heading fontsweight fontsizes">SAIL</div>
                                            <div style="text-align: left;">
                                                <a class="dbox__title fontsweight" href="#elina_sail" data-toggle="modal" data-target="#elina_sail">View</a>
                                                <!-- <a class="dbox__title fontsweight" href="{{url('sailstatus')}}">View</a> -->
                                            </div>
                                        </div>
                                        <div class="widget-content-right">
                                            <div class="widget-numbers text-white numberfontsize"><span> {{ $rows['chart2'][0]['sail_count'] ?? '' }}
                                            </span></div>
                                        </div>
                                    </div>
                                </div>

                                <div class="card mb-3 widget-content bg">
                                    <div class="widget-content-wrapper text-white">
                                        <div class="widget-content-left">
                                            <div class="widget-heading fontsweight fontsizes">CoMPASS</div>
                                            <div style="text-align: left;">
                                                <a class="dbox__title fontsweight" onclick="alert('No Data Found')">View</a>
                                                <!-- <a class="dbox__title fontsweight" href="#addModal" data-toggle="modal" data-target="#addModal">View</a> -->
                                            </div>
                                        </div>
                                        <div class="widget-content-right">
                                            <div class="widget-numbers text-white numberfontsize"><span> 0</span></div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                    @if($modules['user_role'] != 'IS Coordinator')
                    <div class="col-md-4">
                        <div class="card cardheight" style="background-color: white; ">
                            <div class="card-header headercolor">
                                <i class="fa fa-pie-chart" id="fa-icon" aria-hidden="true">
                                </i>Enrollment Analysis
                            </div>

                            <div id="piechart" style="width: 100%; height: 300px;">


                            </div>
                        </div>
                    </div>
                    @endif
                    <!-- End Row 1 -->

                    <!-- Row 2 -->
                    <div class="row">
                        @if($modules['user_role'] != 'IS Coordinator')
                        <div class="col-md-3">
                            <div class="col-xs-12">
                                <div class="card">
                                    <div class="card-header headercolor"><i class="fa fa-bar-chart" id="fa-icon" aria-hidden="true"></i> Black Board</div>
                                    <div class="card-body">

                                        <ul class="list-group list-group-flush">
                                            <a class="borderBoard" href="{{route('user.index')}}">
                                                <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                                                    <div class="float-left" style="font-weight:bold;color:#6b747b;">User Registered</div>
                                                    <div class="counter-va" class="float-right newcolor">{{$rows['blackboard'][0]['register_count']}}</div>
                                                </li>
                                            </a>
                                            <a class="borderBoard" href="{{route('newenrollment.index')}}">
                                                <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                                                    <div class="float-left" style="font-weight:bold;color:#6b747b;">Enrolled</div>
                                                    <div class="float-right newcolor">{{$rows['blackboard'][0]['child_enrollement_count']}}</div>
                                                </li>
                                            </a>

                                            <a class="borderBoard" href="{{route('ovm1.index')}}">
                                                <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                                                    <div class="float-left" style="font-weight:bold;color:#6b747b;">OVM 1 Meeting</div>
                                                    <div class="float-right newcolor">{{$rows['blackboard'][0]['ovm_count']}}</div>
                                                </li>
                                            </a>
                                            <a class="borderBoard" href="{{route('ovm2.index')}}">
                                                <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                                                    <div class="float-left" style="font-weight:bold;color:#6b747b;">OVM 2 Meeting</div>
                                                    <div class="float-right newcolor">{{$rows['blackboard'][0]['ovm2_count']}}</div>
                                                </li>
                                            </a>
                                            <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                                                <div class="float-left" style="font-weight:bold;color:#6b747b;">Completed Assessment</div>
                                                <div class="float-right newcolor">0</div>
                                            </li>

                                            <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                                                <div class="float-left" style="font-weight:bold;color:#6b747b;">CoMPASS Process</div>
                                                <div class="float-right newcolor">0</div>
                                            </li>

                                            <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                                                <div class="float-left" style="font-weight:bold;color:#6b747b;">Renewal Process</div>
                                                <div class="float-right newcolor">0</div>
                                            </li>
                                            <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap bglred">
                                                <div class="float-left cclr" style="font-weight:bold;">SLA Crossed</div>
                                                <div class="float-right newcolor cclr">{{$rows['blackboard'][0]['sla_crossed']}}</div>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endif

                        <div class="col-md-9">
                            <div class="col-xs-12">
                                <div class="card-header">
                                    <i class="fa fa-search" id="fa-icon" aria-hidden="true"></i><a style="color: #5263dd;font-weight: bold;" href=""> Search Here</a>
                                    <div class="float-right colorgrey"> </div>
                                </div>
                                <div class="card-body">
                                    <ul class="list-group list-group-flush">

                                        <li class="list-group-item d-flex justify-content-between align-items-center ">
                                            <p style=" font-weight: bold;color:#6b747b;" href="#" title="{{ __('View') }}">Search By </p>
                                            <select class="form-control wp px-auto" name="elinalead" id="searchuserdata" onchange="selectfn(event)">
                                                <option value="">Select-Category</option>
                                                <option Value="child_name">Child Name</option>
                                                <option Value="enrollment_child_num">Child Enrollment Id</option>
                                                <option Value="child_contact_phone">Child Contact Number</option>
                                                <option Value="child_contact_email">Child Contact Email</option>
                                                <!-- <option Value="coordinators">IS Coordinators</option> -->
                                            </select>
                                        </li>
                                        <li class="list-group-item d-flex justify-content-between align-items-center" id="SearchByChild" style="display: none !important;">
                                            <a style=" font-weight: bold;color:#6b747b; " id="selectedcategory" class="text-capitalize" href="#" title="{{ __('View') }}">Category </a><input type="text" id="searchinput" class="form-control wp">
                                        </li>
                                        <li class="list-group-item d-flex justify-content-between align-items-center" id="SearchByCoordinators" style="display: none !important;">
                                            <p style=" font-weight: bold;color:#6b747b;" class="text-capitalize">Coordinator</p>
                                            <select class="form-control wp" name="searchCoordinators" id="searchCoordinators" onchange="searchCoordinators()">
                                                <option value="">Select Coordinators</option>
                                                @foreach($rows['coordinators'] as $coordinators)
                                                <option value="{{$coordinators['id']}}">{{$coordinators['name']}}</option>
                                                @endforeach
                                            </select>
                                        </li>
                                        <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap" style="height: 52px;">
                                            <h6></h6>
                                            <a class="btn btn-labeled btn-info text-white " type="button" onclick="elinaleadsearch()" title="{{ __('View') }}"><span class="text-white"><i class="fa fa-search" aria-hidden="true"></i> Search</span></a>
                                        </li>
                                    </ul>
                                </div>
                                <div class="searchResultCoordinator" id="columnchart_material" style="display: none;width: 100% !important; height: 400px;"></div>
                                <div class="scrollable fixTableHead title-padding searchResultStudent" id="scrolls">
                                    <div class="table-responsive">
                                        <table class="table table-hover table-bordered table-custom-list card-body custom" style="width:100% !important">
                                            <thead>
                                                <tr>
                                                    <!-- <th scope="col">Audit ID</th> -->
                                                    <th style="width:10%">Sl.No</th>
                                                    <th style="width:20% ">Enrollment ID</th>
                                                    <th style="width:15% ">Child Name</th>
                                                    <th style="width:20% ">Email</th>
                                                    <th style="width:20% ">Mobile Number</th>

                                                    <th style="width:20%">Track & Trace</th>
                                                </tr>
                                            </thead>
                                            <tbody style="background-color: white; " id="align1b">
                                                @foreach($rows['enrollment_details'] as $data)
                                                <tr>
                                                    <td>{{$loop->iteration}}</td>
                                                    <td>{{$data['enrollment_child_num']}}</td>
                                                    <td>{{$data['child_name']}}</td>
                                                    <td>{{$data['child_contact_email']}}</td>
                                                    <td>{{$data['child_contact_phone']}}</td>

                                                    <td> <a onclick="overallStatus('{{$data['enrollment_id']}}' , '{{$data['child_name']}}')" title="Overall Status"><i class="fa fa-bars" style="color: red;"></i></a></td>
                                                </tr>
                                                @endforeach

                                            </tbody>
                                        </table>
                                    </div>
                                    <a class="btn text-white" type="button" style="background-color: red;float: right;display:none" id="searchReset" onclick="resetsearch()" title="{{ __('Reset') }}"><span class="text-white"><i class="fa fa-refresh" aria-hidden="true"></i> Reset</span></a>
                                </div>

                            </div>

                        </div>
                        <div class="col-md-3">

                        </div>

                    </div>
                    <div>



                    </div>
                </div>





                <div class="row" id="row3">
                    <div class="col-12 col-md-6">
                        <div class="card justify-content-md-center">
                            <div class="card-header headercolor justify-content-between"><i class="fa fa-history" id="fa-icon" aria-hidden="true"> Access History</i>
                                <a href="{{url('auditlog/login_report')}}">
                                    <div class="float-right">View All <i class="fa fa-arrow-right" aria-hidden="true"></i></div>
                                </a>
                            </div>
                            <div class="scrollable fixTableHead title-padding" id="scrolls">
                                <div class="table-responsive">
                                    <table class="table table-hover table-bordered table-custom-list card-body" style="width:100% !important">
                                        <thead>
                                            <tr>
                                                <!-- <th scope="col">Audit ID</th> -->
                                                <th style="width:16%">User Name</th>
                                                <th style="width:16% !important">Designation</th>
                                                <!-- <th style="width:15% !important">Role</th> -->
                                                <th style="width:15% !important">Login</th>
                                                <th style="width:15%">Logout</th>
                                            </tr>
                                        </thead>

                                        <tbody style="background-color: white; ">

                                            @foreach($rows['userlogin'] as $data)
                                            @if($loop->iteration < 10) <tr>
                                                <!-- <td>Login{{$loop->iteration}}</td> -->
                                                <td>{{$data['name']}}</td>
                                                <td>{{$data['role_name']}}</td>
                                                <!-- <td>{{$data['role_name']}}</td> -->
                                                <td>{{ date('d-m-Y h:i A', strtotime($data['login_time'])) }}</td>
                                                @if($data['logout_time'] == '' || $data['logout_time'] == null) <td> - </td>
                                                @else <td>{{ date('d-m-Y h:i A', strtotime($data['logout_time'])) }}</td>
                                                @endif
                                                </tr>
                                                @endif
                                                @endforeach

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                    @if($modules['user_role'] != 'IS Coordinator')
                    <div class="col-12 col-md-6">
                        <div class="card">
                            <div class="card-header headercolor"><i class="fa fa-area-chart" id="fa-icon" aria-hidden="true"></i>Enrollment ISMS Analysis </div>
                            <div class="card-body chartspace">
                                <div id="chart_div" style="width: 100%; height: 300px;"></div>
                            </div>
                        </div>
                    </div>
                    @else
                    <div class="col-12 col-md-6">
                        <div class="card justify-content-md-center">
                            <div class="card-header headercolor justify-content-between"><i class="fa fa-history" id="fa-icon" aria-hidden="true"> Sail</i>

                            </div>
                            <div class="scrollable fixTableHead title-padding" id="scrolls">
                                <div class="table-responsive">
                                    <table class="table table-hover table-bordered table-custom-list card-body" style="width:100% !important">
                                        <thead>
                                            <tr>
                                                <th style="width:5px !important">S.No</th>
                                                <th>Enrollment Number</th>
                                                <th>Child Name</th>
                                                <!-- <th>Is-coordinator</th> -->
                                                <th>Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($rows['sail'] as $key=>$row)
                                            <tr>
                                                <td>{{ ++$key }}</td>
                                                <td>{{ $row['child_name']}}</td>
                                                <td>{{ $row['enrollment_child_num']}}</td>
                                                <!-- <td>{{ json_decode($row['is_coordinator1'])->name }}</td> -->
                                                <td>{{ $row['audit_action']}}</td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>




        <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
        <script type="text/javascript">
            $(document).ready(function() {
                var space_dash = $('.space_dash');
                $(".space_dash").each(function(index) {
                    if (index == 4) {
                        $(this).css("width", "50px");
                    }
                    if (index == 9) {
                        $(this).css("width", "50px");
                    }
                });
            });
        </script>

        <input type="hidden" name="session_data" id="session_data" class="session_data" value="{{ session('success') }}">
        <script type="text/javascript">

        </script>
        <!-- Pie Chart -->

        <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
        <script type="text/javascript">
            var chart1 = <?php echo json_encode($rows['chart1']); ?>;
            // console.log(chart1);
            google.charts.load('current', {
                'packages': ['corechart']
            });
            google.charts.setOnLoadCallback(drawChart);

            function drawChart() {

                var data = google.visualization.arrayToDataTable([
                    ['Task', 'Hours per Day'],
                    ['Parent', chart1[0].child_enrollement_count],
                    ['Intern', chart1[0].internship_count],
                    ['Service Provider', chart1[0].service_provider_count],
                    ['School', chart1[0].school_enrollment_count],
                ]);

                var options = {
                    backgroundColor: 'transparent',
                    pieSliceText: 'percentage',
                    pieStartAngle: 100,
                    is3D: true,
                    // chartArea: {
                    //     left: 25,
                    //     top: 30,
                    //     width: '100%',
                    //     height: '100%'
                    // },
                    legend: {
                        display: 'inline-block',
                        position: 'bottom',
                        alignment: 'start',
                        maxLines: 1,
                        textStyle: {
                            color: 'blue',
                            fontSize: 12
                        }
                    }
                };

                var chart = new google.visualization.PieChart(document.getElementById('piechart'));

                chart.draw(data, options);
            }
        </script>








        <!-- Graph -->

        <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
        <script type="text/javascript">
            google.charts.load('current', {
                'packages': ['corechart']
            });
            google.charts.setOnLoadCallback(drawChart);

            function drawChart() {
                var chart2 = <?php echo json_encode($rows['chart2']); ?>;
                console.log('chart2', chart2);
                // console.log(chart2[0]['dropped']);
                var data = google.visualization.arrayToDataTable([
                    ['Year', 'Dropped', 'OVM Participated', 'Sail Participated'],
                    //['2019', 0, 0, 0, 0],
                    //['2020', 0, 0, 0, 0],
                    ['2023', 0, 70, 54],
                    ['2024', 0, 75, 50],
                    // [chart2[0]['c_year'], chart2[0]['dropped'], chart2[0]['ovm_count'], chart2[0]['sail_count'], 0],

                ]);

                var options = {
                    backgroundColor: 'transparent',
                    is3D: true,
                    'width': 550,
                    'height': 250,
                    pointSize: 7,
                    hAxis: {
                        title: 'Year',
                        formate: 'MMM yy',
                        curveType: 'function',
                        pointSize: 100,
                        viewWindow: {
                            min: new Date(2022, 1),
                        }
                    },
                    legend: {
                        maxLines: 10,
                        position: 'bottom',
                        alignment: 'start',
                        textStyle: {
                            color: 'blue',
                            fontSize: 12
                        }
                    },
                    vAxis: {
                        minValue: 0,
                        //maxValue: 100, //Remove maxValue if dont have end point
                        title: 'No of Enrollment'
                    }
                };

                var chart = new google.visualization.AreaChart(document.getElementById('chart_div'));
                chart.draw(data, options);
            }
        </script>







        <script>
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            var initialTableHTML = document.getElementById('align1b').innerHTML;

            function elinaleadsearch() {
                let sb = $("#searchuserdata").val();

                const selectElement = document.getElementById('searchuserdata');
                const selectedOption = selectElement.options[selectElement.selectedIndex].innerHTML;

                if (sb == '') {
                    swal.fire("Please Select Search By Category", "", "error");
                }
                let elinalead = $("#searchinput").val();
                if (sb == "child_name") {

                    var searchkey = `and a.${sb} LIKE '%${elinalead}%'`;

                } else if (sb == "child_contact_phone") {
                    var searchkey = `and a.${sb} LIKE '%${elinalead}%'`;
                } else {
                    var searchkey = `and a.${sb}='${elinalead}'`;
                }

                console.log(sb, searchkey);
                if (elinalead == '') {
                    swal.fire("Please Enter " + selectedOption, "", "error");
                } else {
                    $.ajax({
                        url: "{{ route('elinaleadsearch') }}",
                        type: 'POST',
                        data: {
                            'searchkey': searchkey,
                            _token: '{{csrf_token()}}'
                        }
                    }).done(function(data) {
                        if (data != '[]') {
                            var optionsdata = "";
                            // console.log(data);
                            if (data.length > 0) {
                                for (var i = 0; i < data.length; i++) {
                                    var enrollment_child_num = data[i].enrollment_child_num;
                                    var child_name = data[i].child_name;
                                    var child_contact_email = data[i].child_contact_email;
                                    var child_contact_phone = data[i].child_contact_phone;
                                    var enrollment_id = data[i].enrollment_id;
                                    var status = data[i].status;
                                    optionsdata += `<tr><td>${parseInt(i) + 1}</td><td>${enrollment_child_num}</td><td>${child_name}</td><td>${child_contact_email}</td><td>${child_contact_phone}</td><td><a onclick="overallStatus(${enrollment_id}, '${child_name}')" title="Overall Status"><i class="fa fa-bars" style="color: red;"></i></a></td></tr>`;
                                }
                            } else {
                                optionsdata += "<tr><td colspan='6'>No Data Found</td></tr>";
                            }
                            var demonew = $('#align1b').html(optionsdata);
                            $('#searchReset').show();
                        } else {
                            var ddd = "<tr><td colspan='6'>No Data Found</td></tr>";
                            var demonew = $('#align1b').html(ddd);
                            $('#searchReset').show();
                        }
                        $('.searchResultStudent').show();
                        $('.searchResultCoordinator').hide();
                    })
                }
            };

            function resetsearch() {
                $("#searchinput").val('');
                resetTableToInitial();
                $('.searchResultStudent').show();
                $('.searchResultCoordinator').hide();
            }

            function resetTableToInitial() {
                document.getElementById('align1b').innerHTML = initialTableHTML;
                $('#searchReset').hide();
            }

            function selectfn(event) {
                var selectby = event.target.value;
                if (selectby == 'coordinators') {
                    var SearchByChild = document.querySelector("#SearchByChild");
                    SearchByChild.style.setProperty("display", "none", "important");
                    var SearchByCoordinators = document.querySelector("#SearchByCoordinators");
                    SearchByCoordinators.style.setProperty("display", "", "important");

                } else {
                    var SearchByChild = document.querySelector("#SearchByChild");
                    SearchByChild.style.setProperty("display", "", "important");
                    var SearchByCoordinators = document.querySelector("#SearchByCoordinators");
                    SearchByCoordinators.style.setProperty("display", "none", "important");

                    const selectElement = document.getElementById('searchuserdata');
                    const selectedOption = selectElement.options[selectElement.selectedIndex].innerHTML;
                    selectedcategory.innerText = (!selectby) ? "category" : '' + selectedOption;
                }
            }
            window.onunload = function() {
                event.preventDefault();
                document.getElementById('logout-form').submit();
            }

            function getDocumentView(documentProcessID) {
                $(".loader_div").show();
                $('#viewDocument').html('');
                $.ajax({
                    url: '/document/processing/document/view',
                    type: 'GET',
                    data: {
                        'documentProcessID': documentProcessID
                    }
                }).done(function(data) {
                    if (data.status == 401) {
                        window.location.href = "/unauthenticated";
                    }
                    if (data.status == 200) {
                        $('#viewDocument').html(data.html);
                    }
                    $(".loader_div").hide();
                })
            }
        </script>
        <script>
            function formatDate(inputDateTime) {
                const ustDate = new Date(inputDateTime + ' UTC');
                ustDate.setHours(ustDate.getHours() + 5);
                ustDate.setMinutes(ustDate.getMinutes() + 30);
                const options = {
                    day: '2-digit',
                    month: 'short',
                    year: 'numeric',
                    hour: '2-digit',
                    minute: '2-digit',
                    hour12: true,
                };

                return ustDate.toLocaleDateString(undefined, options);
            }

            function overallStatus(id, Sname) {
                // $(".loader").show();
                var enrollment_id = id;
                $.ajax({
                    url: '/user/status/view',
                    type: 'GET',
                    data: {
                        'get_type': 'child',
                        'enrollment_id': enrollment_id
                    }
                }).done(function(data) {
                    console.log(data);
                    if (data != '[]') {
                        var user_select = data;
                        var ddd;
                        var modalHeader = document.getElementById('modalHeader');
                        modalHeader.textContent = 'Overall Activity of ' + Sname;
                        for (var i = 0; i < user_select.length; i++) {
                            var description = user_select[i].description;
                            var action_date_time = formatDate(user_select[i].action_date_time);
                            // Input date and time string
                            var inputDateString = user_select[i].action_date_time;

                            // Parse the input string into a Date object


                            var utcTime = new Date(inputDateString.replace(/-/g, '/'));
                            utcTime.setHours(utcTime.getHours() + 5);
                            utcTime.setMinutes(utcTime.getMinutes() + 30);
                            var istTime = utcTime.toLocaleString('en-US', {
                                timeZone: 'Asia/Kolkata'
                            });
                            var dateObj = new Date(istTime);

                            // Format the date object into the desired format
                            var formattedDate = dateObj.toLocaleString('en-US', {
                                year: 'numeric',
                                month: 'short',
                                day: 'numeric',
                                hour: 'numeric',
                                minute: 'numeric',
                                second: 'numeric',
                                hour12: true
                            });

                            console.log('formattedDate', formattedDate);

                            ddd += "<tr><td >" + (parseInt(i) + 1) + "</td><td>" + description + "</td><td> " + formattedDate + " </td></tr>";
                        }
                        var demonew = $('#logTable').html(ddd);
                    } else {
                        var stageoption = ddd.concat(optionsdata);
                    }
                    // $(".loader").hide();
                    $("#logModal").modal();
                })
            }
        </script>
        <script type="text/javascript">
            // window.onload = function() {
            //     // Full screen
            //     $('body').toggleClass(" sidebar-mini");
            //     var element = document.querySelector(".main-sidebar");
            //     element.style.setProperty("overflow", "hidden", "important");
            // }

            function searchCoordinators() {
                // $(".loader").show();
                var searchCoordinators = document.getElementById('searchCoordinators').value;
                // console.log(searchCoordinators);
                $.ajax({
                    url: '/search/Coordinators/view',
                    type: 'GET',
                    data: {
                        'searchCoordinators': searchCoordinators
                    }
                }).done(function(data) {
                    $('.searchResultStudent').hide();
                    var searchResultCoordinator = document.querySelector(".searchResultCoordinator");
                    searchResultCoordinator.style.setProperty("display", "block", "important");
                    // $('.searchResultCoordinator').show();
                    // $(".loader").hide();
                })
            }
        </script>
        <script type="text/javascript">
            google.charts.load('current', {
                'packages': ['bar']
            });
            google.charts.setOnLoadCallback(drawChart);

            function drawChart() {
                var data = google.visualization.arrayToDataTable([
                    ['Month', 'OVM', 'SAIL', 'CoMPASS'],
                    ['May', 11, 11, 0],
                    ['June', 16, 12, 0],
                    ['July', 5, 3, 0]
                ]);

                var options = {
                    // 'width': 891,
                    // 'height': 400,
                    // chart: {
                    //     title: 'Company Performance',
                    //     subtitle: 'Sales, Expenses, and Profit: 2014-2017',
                    // }
                };

                var chart = new google.charts.Bar(document.getElementById('columnchart_material'));

                chart.draw(data, google.charts.Bar.convertOptions(options));
            }
        </script>
        @include('modal.students_log')
        @include('modal.elina_dropped')
        @include('modal.elina_ovm')
        @include('modal.elina_sail')
        @include('modal.elina_leads')

        @endsection