@extends('layouts.adminnav')

@section('content')
<style>
    .nav-tabs {
        background-color: #0068a7 !important;
        border-radius: 29px !important;
        padding: 1px !important;

    }

    .nav-item.active {
        background-color: #0e2381 !important;
        border-radius: 31px !important;
        height: 100% !important;
    }

    .nav-link.active {
        background-color: #0e2381 !important;
        border-radius: 31px !important;
        height: 100% !important;
    }

    .nav-justified {
        display: flex !important;
        align-items: center !important;
    }

    hr {
        border-top: 1px solid #6c757d !important;
    }

    .dateformat {
        height: 41px;
        padding: 8px 10px !important;
        width: 100%;
        border-radius: 5px !important;
        border-color: #bec4d0 !important;
        box-shadow: 2px 2px 4px rgb(0 0 0 / 15%);
        border-style: outset;
    }

    #align1_length,
    #align1_filter,
    #align1_info,
    #align1_paginate {
        display: none !important;
    }

    .table-td-head {
        border: 1px solid black !important;
        background: rgb(9 48 110) !important;
        color: white;
    }
</style>

<div class="main-content">
    {{ Breadcrumbs::render('serviceproviderview',$rows[0]['id']) }}
    <div class="row">
        <div class="col-12">
            <div class="card" style="height:100%; padding: 15px; background-color:white">
                <div class="col-lg-12 text-center" style="padding: 10px;">
                    <h4 style="color:darkblue;">Service Partner Details</h4>
                </div>
                @foreach($rows as $key=>$row)
                <div class="tile" id="tile-1" style="margin-top:10px !important; margin-bottom:10px !important;">

                    <!-- Nav tabs -->
                    <ul class="nav nav-tabs nav-justified" style="width:75%; margin:auto;" id="tabs" role="tablist">

                        <li class="nav-item" class="">
                            <a class="nav-link" style="cursor: pointer; border:none;" id="home-tab" name="tab1" data-toggle="tab" role="tab" aria-controls="home" aria-selected="true"><i class="fa fa-home"></i><b style="padding: 2px;">General Details</b> <input type="checkbox" class="checkg" id="gencheckbox" name="nationality" value="0" onchange="submitval(this)" readonly style="background-color:solid green !important; color:green !important; visibility:hidden !important; ">
                                <div class="check" id="gct"></div>
                            </a>

                        </li>

                        <li class="nav-item" class="">
                            <a class="nav-link" style="cursor: pointer; border:none;" id="contact-tab" name="tab2" data-toggle="tab" role="tab" aria-controls="contact" aria-selected="false"><i class="fas fa-file-text"></i><b>Education Details</b> <input type="checkbox" class="checkg" id="expcheckbox" name="nationality" value="0" onchange="submitval(this)" style="background-color:solid green !important; color:green !important; visibility:hidden !important; ">
                                <div class="check" id="expct"></div>
                            </a>
                        </li>


                    </ul>
                </div>
                <!-- Tab panes -->
                <table class="table table-bordered" id="align1" style="display:none"></table>
                <div class="tab-content" id="tab-content">
                    <div class="tab-pane fade show active" id="tab1" role="tabpanel" aria-labelledby="home-tab">

                        <section class="section">
                            <div class="section-body mt-1">
                                <table class="table table-bordered" style="text-align:center;table-layout: fixed;">
                                    <tr>
                                        <td class="table-td-head">Name</td>
                                        <td style="border: 1px solid black !important;">{{$row['name']}}</td>
                                    </tr>
                                    <tr>
                                        <td class="table-td-head">Gender</td>
                                        <td style="border: 1px solid black !important;">{{$row['gender']}}</td>
                                    </tr>
                                    <tr>
                                        <td class="table-td-head">Contact Number</td>
                                        <td style="border: 1px solid black !important;">{{$row['phone_number']}}</td>
                                    </tr>
                                    <tr>
                                        <td class="table-td-head">Email Address</td>
                                        <td style="border: 1px solid black !important;">{{$row['email_address']}}</td>
                                    </tr>
                                    <tr>
                                        <td class="table-td-head">Area Of Spezialization</td>
                                        <td style="border: 1px solid black !important;">@foreach($area_of_specializtion as $key=>$rowsp)
                                            {{$rowsp}}, <br />
                                            @endforeach
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="table-td-head">Mode of operation</td>
                                        <td style="border: 1px solid black !important;">{{$row['type_of_service']}}</td>
                                    </tr>
                                    <tr>
                                        <td class="table-td-head">Mode of deliviery</td>
                                        <td style="border: 1px solid black !important;">{{$row['providing_home_service']}}</td>
                                    </tr>
                                    <tr>
                                        <td class="table-td-head">charges per session</td>
                                        <td style="border: 1px solid black !important;">{{$row['profession_charges_per_session']}}</td>
                                    </tr>
                                </table>
                                @if($row['type_of_service'] == 'Organisation')
                                <div class="col-lg-12 text-center">
                                    <h4 style="color:darkblue;">Organisation Details</h4>
                                </div>
                                <table class="table table-bordered" style="text-align:center;table-layout: fixed;">
                                    <tr>
                                        <td class="table-td-head">Name Of The Organisation</td>
                                        <td style="border: 1px solid black !important;">{{$row['organisation_name']}}</td>
                                    </tr>
                                    <tr>
                                        <td class="table-td-head">Head of Organisation</td>
                                        <td style="border: 1px solid black !important;">{{$row['organisation_head_name']}}</td>
                                    </tr>
                                    <tr>
                                        <td class="table-td-head">Email Address</td>
                                        <td style="border: 1px solid black !important;">{{$row['organisation_email_address']}}</td>
                                    </tr>
                                    <tr>
                                        <td class="table-td-head">Website/ Info of Organization</td>
                                        <td style="border: 1px solid black !important;">{{$row['organisation_website_info']}}</td>
                                    </tr>
                                    <tr>
                                        <td class="table-td-head">specifications, limitations or constraints</td>
                                        <td style="border: 1px solid black !important;">{{$row['specification_limitation_constraint']}}</td>
                                    </tr>
                                </table>
                                @endif



                            </div>
                            <div class="col-md-12 text-center">
                                <a type="button" class="btn btn-labeled btn-info" onclick="DoAction('tab2');" title="Next" style="background: blue !important; border-color:#4d94ff !important; color:white !important">
                                    <span class="btn-label" style="font-size:13px !important;"><i class="fa fa-arrow-right"></i></span>Next</a>
                                <a type="button" class="btn btn-labeled back-btn" title="Cancel" href="{{ route('servicelist') }}" style="color:white !important">
                                    <span class="btn-label" style="font-size:13px !important;"><i class="fa fa-times"></i></span> Cancel</a>
                            </div>
                        </section>

                    </div>

                    <div class="tab-pane fade show" id="tab2" role="tabpanel" aria-labelledby="contact-tab">
                        <section class="section">
                            <div class="section-body mt-1">


                                <table class="table table-bordered" id="align1" style="text-align:center;table-layout: fixed;">
                                    <thead>
                                        <tr>
                                            <!-- <th style="width: 7%">S.No</th> -->
                                            <th style="width: 15%">University Name</th>
                                            <th style="width: 20%">Professional Qualification</th>
                                            <th style="width: 15%">Year Of Completion</th>
                                            <th style="width: 15%">Specialist in</th>
                                            <th style="width: 20%">Work Experience</th>
                                            <th style="width: 20%">Acknowledgement</th>

                                        </tr>
                                    </thead>
                                    <tbody>


                                        <tr class="trc">
                                            <!-- <td>1</td> -->
                                            <td style="word-break: break-all;">{{$row['universtiy_name']}}</td>
                                            <td style="word-break: break-all;">{{$row['profession_qualification']}}</td>
                                            <td style="word-break: break-all;">{{$row['year_of_completion']}}</td>
                                            <td style="word-break: break-all;">{{$row['specialist_in']}}</td>
                                            <td style="word-break: break-all;">{{$row['work_experience']}}</td>
                                            <td style="word-break: break-all;">{{$row['agree_of_acknowledgement']}}</td>

                                        </tr>

                                    </tbody>
                                </table>

                            </div>
                            <div class="col-md-12 text-center">
                                <a type="button" class="btn btn-labeled btn-info" onclick="DoAction('tab1');" title="Previous" style="background: blue !important; border-color:#4d94ff !important; color:white !important">
                                    <span class="btn-label" style="font-size:13px !important;"><i class="fa fa-arrow-left"></i></span>Previous</a>
                                <a type="button" class="btn btn-labeled back-btn" title="Cancel" href="{{ route('servicelist') }}" style="color:white !important">
                                    <span class="btn-label" style="font-size:13px !important;"><i class="fa fa-times"></i></span> Cancel</a>
                            </div>
                        </section>

                    </div>

                    <div class="tab-pane fade show" id="tab3" role="tabpanel" aria-labelledby="contact-tab">



                        <section class="section">
                            <div class="section-body mt-1">


                                <table class="table table-bordered" id="align1" style="text-align:center;table-layout: fixed;">
                                    <thead>
                                        <tr>
                                            <th style="width: 10%">S.No</th>
                                            <th style="width: 45%">Document Name</th>
                                            <th style="width: 35%">Attachment</th>

                                            <th style="width: 10%">View</th>
                                        </tr>
                                    </thead>

                                </table>

                            </div>
                            <div class="col-md-12 text-center">

                                <a type="button" class="btn btn-labeled back-btn" title="Back" href="{{ route('servicelist') }}" style="color:white !important">
                                    <span class="btn-label" style="font-size:13px !important;"><i class="fa fa-arrow-left"></i></span> Back</a>



                            </div>
                        </section>

                    </div>


                </div>

                @endforeach
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-1.7.2.min.js"></script>

<script type="text/javascript">
    function ndate(d) {

        date = d.value;


        var date_from = document.getElementById("date_of_stay_from").value;

        var date_to = document.getElementById("date_of_stay_to").value;
        if (date_from != "" && date_to != "") {
            const date1 = new Date(date_from);
            const date2 = new Date(date_to);
            console.log(getDifferenceInDays(date1, date2));

            function getDifferenceInDays(date1, date2) {
                const diffInMs = Math.abs(date2 - date1);
                document.getElementById("date_of_stay").value = diffInMs / (1000 * 60 * 60 * 24);
            }

            window.addval(date);
        }

    };
</script>
<script type="text/javascript">
    $(document).ready(function() {
        $("#content").find("[id^='tab']").hide(); // Hide all content
        $("#home-tab").addClass("active"); // Activate the first tab
        $("#tab1").fadeIn();

    });
</script>
<script type="application/javascript">
    $("#tile-1 .nav-tabs a").click(function() {
        var position = $(this).parent().position();
        var width = $(this).parent().width();
        $("#tile-1 .slider").css({
            "left": +position.left,
            "width": width
        });

        $("#tab-content").find("[id^='tab']").hide(); // Hide all content
        $('#' + $(this).attr('name')).fadeIn(); // Show content for the current tab

    });
    var actWidth = $("#tile-1 .nav-tabs").find(".active").parent("li").width();
    var actPosition = $("#tile-1 .nav-tabs .active").position();
    // $("#tile-1 .slider").css({
    //     "left": +actPosition.left,
    //     "width": actWidth
    // });


    function DoAction(id) {

        $("#tab-content").find("[id^='tab']").hide(); // Hide all content
        $("#tabs a").removeClass("active"); //Reset id's
        $("a[name='" + id + "']").addClass("active");
        var position = $("a[name='" + id + "']").position();
        var width = $("a[name='" + id + "']").width();
        $("#tile-1 .slider").css({
            "left": +position.left,
            "width": width
        });
        $('#' + (id)).fadeIn(); // Show content for the current tab


    }
</script>



@endsection