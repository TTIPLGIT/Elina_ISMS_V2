    
   @extends('layouts.adminnav')
    @section('content')
    @include('dashboard_css')
    <style>
        #align1_length,
        #align1_filter {
            display: none !important;
        }

    .dataTables_paginate {
        padding: 0 !important;
        margin: 0 !important;
        float: left !important;
    }

    .dataTables_paginate {
        display: inline !important;
    }

    .pagination {
        display: inline !important;
        float: right !important;
    }

    .bglred {
        background-color: #ff251b !important;
    }

    .cclr {
        color: #ebebec;
    }



    table.custom,
    tbody,
    tr,
    td {
        word-break: break-all !important
    }

    .main-contents {

        width: 100%;
        /* position: relative; */
    }

    #align td,
    #align th,
    #tableExport td,
    .tableExport td,
    #tableExport th,
    .tableExport th,
    #tableExport1 td,
    #tableExport1 th,
    #align1 td,
    #align1 th,
    #align2 td,
    #align2 th,
    #align3 td,
    #align3 th,
    #align4 td,
    #align4 th {
        padding: 8px !important;
        word-break: break-word !important;

    }
</style>
<div class="main-content contentpadding" style="position:absolute; z-index:-1">

    <!-- Main Content -->

    <div class="section-body">
        <div class="row">
            <!-- Row 1 -->



                <div class="col-md-3">
                    <div class="card">
                        <div class="card-body">
                        <div class="d-flex flex-column align-items-center text-center">
                            @if($rows['users']['profile_image'] != "")
                            <img src="{{$rows['users']['profile_image'] }}" alt="" width="100" height="100" style="border-radius:50%;height: 130px;width: 130px;margin: 10px 0px 10px 0px;">
                            @else

                                <img style="margin-top: 10px;" src="images\profile-picture.webp" alt="profile" class="rounded-circle p-1 bg-primary" width="110">
                                <div class="mt-3">
                                    <h4 class="headercolor">Kaviya</h4>
                                    <p class="text-secondary mb-1 headercolor"></p>
                                </div>
                            @endif
                            </div>
                            <ul class="list-group list-group-flush">
                                <!-- <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                                    <h6 class="mb-0" style="color:#6b747b;"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-globe me-2 icon-inline">
                                            <circle cx="12" cy="12" r="10"></circle>
                                            <line x1="2" y1="12" x2="22" y2="12"></line>
                                            <path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"></path>
                                        </svg></h6>
                                    <span class="text-secondary" style="font-weight:bold;"></span>
                                </li> -->

                            <li class="list-group-item d-flex justify-content-between align-items-center flex-nowrap">
                                <h6 style="color:#6b747b; white-space: nowrap;"><i class="fa fa-clock-o" style="font-size:15px; "></i> <span style="white-space: nowrap;">Last Login</span> </h6>
                                <span class="text-secondary">{{$rows['users']['login_time']}}</span>
                            </li>

                            <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                                <a href="#" style="text-align: right; font-weight: bold; color:#6b747b;"><i class="fa fa-user" style="font-size:16px; "></i> View Profile</a>
                                <!-- <a href="#" style="text-align: left;">Logout <i class="fa fa-sign-out" style="font-size:16px"></i></a> -->

                                <a style="text-align: left; font-weight: bold; color:#6b747b;" href="#" onclick="event.preventDefault();document.getElementById('logout-form').submit();">Logout <i class="fa fa-sign-out" style="font-size:15px"></i></a>
                            </li>

                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-md-5">
                <div class="card cardheight headercolor">
                    <div class="card-header"><i class="fa fa-folder-open" id="fa-icon" aria-hidden="true"></i> Elina Student Activity List</div>
                    <div class="card-body" id="scroll">
                        <div class="card mb-3 widget-content bg">
                            <div class="widget-content-wrapper text-white">
                                <div class="widget-content-left">
                                    <div class="widget-heading fontsweight fontsizes">Dropped</div>
                                    <div style="text-align: left;">

                                        <a class="dbox__title fontsweight" href="#elina_dropped" data-toggle="modal" data-target="#elina_dropped">View</a>
                                    </div>
                                </div>
                                <div class="widget-content-right">
                                    <div class="widget-numbers text-white numberfontsize"><span>{{count($rows['dropped'])}} </span></div>
                                </div>
                            </div>
                        </div>
                        <div class="card mb-3 widget-content bg">
                            <div class="widget-content-wrapper text-white">
                                <div class="widget-content-left">
                                    <div class="widget-heading fontsweight fontsizes">OVM</div>
                                    <div style="text-align: left;">

                                        <a class="dbox__title fontsweight" href="#elina_ovm" data-toggle="modal" data-target="#elina_ovm">View</a>
                                    </div>
                                </div>
                                <div class="widget-content-right">
                                    <div class="widget-numbers text-white numberfontsize"><span> {{$rows['chart2'][0]['ovm_count']}} </span></div>
                                </div>
                            </div>
                        </div>
                        <div class="card mb-3 widget-content bg">
                            <div class="widget-content-wrapper text-white">
                                <div class="widget-content-left">
                                    <div class="widget-heading fontsweight fontsizes">SAIL</div>
                                    <div style="text-align: left;">

                                        <a class="dbox__title fontsweight" href="#elina_sail" data-toggle="modal" data-target="#elina_sail">View</a>
                                    </div>
                                </div>
                                <div class="widget-content-right">
                                    <div class="widget-numbers text-white numberfontsize"><span> {{$rows['chart2'][0]['sail_count']}}</span></div>
                                </div>
                            </div>
                        </div>

                        <div class="card mb-3 widget-content bg">
                            <div class="widget-content-wrapper text-white">
                                <div class="widget-content-left">
                                    <div class="widget-heading fontsweight fontsizes">Assessment</div>
                                    <div style="text-align: left;">

                                        <a class="dbox__title fontsweight" href="#addModal" data-toggle="modal" data-target="#addModal">View</a>
                                    </div>
                                </div>
                                <div class="widget-content-right">
                                    <div class="widget-numbers text-white numberfontsize"><span>0</span></div>
                                </div>
                            </div>
                        </div>
                        <div class="card mb-3 widget-content bg">
                            <div class="widget-content-wrapper text-white">
                                <div class="widget-content-left">
                                    <div class="widget-heading fontsweight fontsizes">CoMPASS</div>
                                    <div style="text-align: left;">

                                        <a class="dbox__title fontsweight" href="#addModal" data-toggle="modal" data-target="#addModal">View</a>
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

            <div class="col-md-4">
                <div class="card cardheight" style="background-color: white; ">
                    <div class="card-header headercolor">
                        <i class="fa fa-pie-chart" id="fa-icon" aria-hidden="true">
                        </i>Enrollement Analysis
                    </div>

                    <div id="piechart" style="width: 100%; height: 300px;">


                    </div>
                </div>
            </div>

            <!-- End Row 1 -->

            <!-- Row 2 -->
            <div class="row">
                <div class="col-md-3">
                    <div class="col-xs-12">

                        <div class="card">
                            <div class="card-header headercolor"><i class="fa fa-tasks" id="fa-icon" aria-hidden="true"></i> Elina Lead</div>
                            <div class="card-body">
                                <ul class="list-group list-group-flush">
                                    <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                                        <div class="float-left"><i class="fa fa-user" aria-hidden="true"></i><a style="color:#6b747b;;font-weight: bold;" title="{{ __('View') }}" href="#"> No of Elina leads</a> </div>
                                        <div class="float-right">{{count($rows['elinalead'])}}</div>
                                    </li>

                                    <!-- <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                                    <div class="float-left"><i class="fa fa-user" aria-hidden="true"></i><a style="color: #636b6f;" title="{{ __('View') }}" href="#"> Actioned Workflow Cases</a></div>
                                    <div class="float-right">actioned workflow</div>
                                    </li> -->

                                </ul>
                            </div>
                            <div class="card-footer">
                                <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                                    <h6></h6>
                                    <a href="#addModal" data-toggle="modal" data-target="#addModal" style="font-weight: bold;"><span class="text-secondary" style="white-space: nowrap;">Click Here To View All Leads <i class="fa fa-arrow-right" aria-hidden="true"></i></span></a>
                                </li>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-header headercolor"><i class="fa fa-bar-chart" id="fa-icon" aria-hidden="true"></i> Black Board</div>
                            <div class="card-body">

                                <ul class="list-group list-group-flush">
                                    <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                                        <div class="float-left" style="font-weight:bold;color:#6b747b;">Registered</div>
                                        <div class="float-right newcolor">{{$rows['blackboard'][0]['register_count']}}</div>
                                    </li>

                                    <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                                        <div class="float-left" style="font-weight:bold;color:#6b747b;">Enrolled</div>
                                        <div class="float-right newcolor">{{$rows['blackboard'][0]['child_enrollement_count']}}</div>
                                    </li>

                                    <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                                        <div class="float-left" style="font-weight:bold;color:#6b747b;">OVM Meeting</div>
                                        <div class="float-right newcolor">{{$rows['blackboard'][0]['ovm_count']}}</div>
                                    </li>

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
                                    <!-- <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                            <div class="float-left">Check-In Workflow</div>
                            <div class="float-right">55</div>
                        </li> -->

                                    <!-- <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                                <h6></h6>
                                <a href="{{ config('setting.base_url')}}reports/processflow"><span class="text-secondary">Report <i class="fa fa-arrow-right" aria-hidden="true"></i></span></a>
                            </li> -->

                                </ul>

                            </div>

                        </div>

                    </div>






                </div>

                <div class="col-md-9">
                    <div class="col-xs-12">
                        <div class="card-header">
                            <i class="fa fa-search" id="fa-icon" aria-hidden="true"></i><a style="color: #5263dd;font-weight: bold;" href=""> Search Here</a>
                            <div class="float-right colorgrey"> </div>
                        </div>
                        <div class="card-body">
                            <ul class="list-group list-group-flush">

                                <li class="list-group-item d-flex justify-content-between align-items-center ">
                                    <a style=" font-weight: bold;color:#6b747b;;" href="#" title="{{ __('View') }}">Search By </a>
                                    <input type="hidden" id="sb">
                                    <select class="form-control wp px-auto" name="elinalead" onchange="selectfn(event)">
                                        <option value="">Select-Category</option>
                                        <option Value="name">Name</option>
                                        <option Value="enrollment_id">Enrollement Id</option>
                                        <option Value="mobile_no">Contact Number</option>
                                        <option Value="email">Contact Email</option>
                                    </select>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center ">
                                    <a style=" font-weight: bold;color:#6b747b; " id="selectedcategory" class="text-capitalize" href="#" title="{{ __('View') }}">Category </a><input type="text" id="searchinput" class="form-control wp">
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap" style="height: 52px;">
                                    <h6></h6>
                                    <a class="btn btn-labeled btn-info text-white " type="button" onclick="elinaleadsearch()" title="{{ __('View') }}"><span class="text-white">Search <i class="fa fa-arrow-right" aria-hidden="true"></i></span></a>
                                </li>
                            </ul>
                        </div>
                        <div class="scrollable fixTableHead title-padding" id="scrolls">
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
                                            <th style="width:20%">Status</th>

                                        </tr>
                                    </thead>
                                    <tbody style="background-color: white; " id="align1b">
                                        {{-- @foreach($audit as $data)
                                @if($loop->iteration < 10) <tr>
                                    <!-- <td>Login{{$loop->iteration}}</td> -->
                                        <td>{{$data->name}}</td>
                                        <td style="width:20% !important">{{$data->email}}</td>
                                        <td>{{$data->login_time}}</td>
                                        @if($data->logout_time == '' || $data->logout_time == null) <td> - </td>
                                        @else <td>{{$data->logout_time}}</td>
                                        @endif
                                        </tr>
                                        @endif
                                        @endforeach--}}

                                        <tr>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                        </tr>
                                        <tr>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                        </tr>

                                    </tbody>
                                </table>
                            </div>
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
                                        <th style="width:16% !important">User Email</th>
                                        <th style="width:15% !important">Role</th>
                                        <th style="width:15% !important">Login</th>
                                        <th style="width:15%">Logout</th>
                                    </tr>
                                </thead>
                                <tbody style="background-color: white; ">

                                    @foreach($rows['userlogin'] as $data)
                                    @if($loop->iteration < 10) <tr>
                                        <!-- <td>Login{{$loop->iteration}}</td> -->
                                        <td>{{$data['name']}}</td>
                                        <td>{{$data['email']}}</td>
                                        <td>{{$data['role_name']}}</td>
                                        <td>{{$data['login_time']}}</td>
                                        @if($data['logout_time'] == '' || $data['logout_time'] == null) <td> - </td>
                                        @else <td>{{$data['logout_time']}}</td>
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


            <div class="col-12 col-md-6">
                <div class="card">
                    <div class="card-header headercolor"><i class="fa fa-area-chart" id="fa-icon" aria-hidden="true"></i>Enrollment ISMS Analysis </div>
                    <div class="card-body chartspace">
                        <div id="chart_div" style="width: 100%; height: 300px;"></div>
                    </div>
                </div>
            </div>
        </div>

    </div>


    <!-- Row 2 End -->

    <!-- Row 3 -->

    <!-- Row 3 End -->


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
    var chart1 = {!!json_encode($rows['chart1']) !!};
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
        var chart2 = {!!json_encode($rows['chart2']) !!};
        // console.log(chart2);
        // console.log(chart2[0]['dropped']);
        var data = google.visualization.arrayToDataTable([
            ['Year', 'Dropped', 'OVM Participated', 'Sail Participated', 'Report Generated'],
            ['2019', 0, 0, 0, 0],
            ['2020', 0, 0, 0, 0],
            ['2021', 0, 0, 0, 0],
            [chart2[0]['c_year'], chart2[0]['dropped'], chart2[0]['ovm_count'], chart2[0]['sail_count'], 0],

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
                title: 'No of Enrollement'
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

    function elinaleadsearch() {
        let sb = $("#sb").val();
        let elinalead = $("#searchinput").val();

        let searchkey = `and a.${sb}='${elinalead}'`;
        // console.log(sb, elinalead, searchkey)
        if (searchkey != "") {
            $.ajax({
                url: "{{ route('elinaleadsearch') }}",
                type: 'POST',
                data: {
                    'searchkey': searchkey,
                    _token: '{{csrf_token()}}'
                }
            }).done(function(data) {
                // var category_id = json.parse(data);
                // console.log(data);

                if (data != '[]') {

                    // var user_select = data;
                    var optionsdata = "";
                    for (var i = 0; i < data.length; i++) {
                        var enrollment_child_num = data[i].enrollment_child_num;
                        var child_name = data[i].child_name;
                        var child_contact_email = data[i].child_contact_email;
                        var child_contact_phone = data[i].child_contact_phone;
                        var status = data[i].status;
                        // console.log(name)
                        // var ddd = '<td="">Select description</td>';
                        optionsdata += "<tr><td >" + (parseInt(i) + 1) + "</td><td >" + enrollment_child_num + "</td><td >" + child_name + "</td><td >" + child_contact_email + "</td><td >" + child_contact_phone + "</td><td >" + status + "</td></tr>";
                    }
                    // var stageoption = ddd.concat(optionsdata);
                    var demonew = $('#align1b').html(optionsdata);
                } else {

                    // var ddd = '<option value="">Select description</option>';
                    // var demonew = $('#align1').html(ddd);
                }
            })
        } else {
            // var ddd = '<option value="">Select description</option>';
            // var demonew = $('#align1').html(ddd);
        }
    };

    function selectfn(event) {
        var selectby = event.target.value || '';
        selectby = selectby.replace('_', ' ');
        selectby = selectby.replace(/^./, function(str) {
            return str.toUpperCase();
        })
        var selectedcategory = document.getElementById("selectedcategory");
        var sb = document.getElementById("sb");
        // console.log(selectby == "Mobile no");
        sb.value = (!selectby) ? "" : (selectby == "Name") ? "child_name" : (selectby == "Enrollment id") ? "enrollment_child_num" : (selectby == "Mobile no") ? "child_contact_phone" : (selectby == "Email") ? "child_contact_email" : "";
        selectedcategory.innerText = (!selectby) ? "category" : selectby;
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
@include('modal.elina_leads')
@include('modal.elina_dropped')
@include('modal.elina_ovm')
@include('modal.elina_leads')

@endsection