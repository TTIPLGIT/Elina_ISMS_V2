@extends('layouts.adminnav')

@section('content')
<style>
    input[type=checkbox] {
        display: inline-block;

    }

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
</style>

<div class="main-content">
    {{ Breadcrumbs::render('internview',$rows[0]['internship_id']) }}
    <div class="row">
        <div class="col-12">
            <div class="card" style="height:100%; padding: 15px; background-color:white">
                <div class="col-lg-12 text-center" style="padding: 10px;">
                    <h4 style="color:darkblue;">Intern Enrollment Overview</h4>
                </div>
                @foreach($rows as $key=>$row)
                <div class="tile" id="tile-1" style="margin-top:10px !important; margin-bottom:10px !important;">
                    <ul class="nav nav-tabs nav-justified" style="width:75%; margin:auto;" id="tabs" role="tablist">
                        <li class="nav-item" class="">
                            <a class="nav-link" style="border: none; cursor: pointer;" id="home-tab" name="tab1" data-toggle="tab" role="tab" aria-controls="home" aria-selected="true"><i class="fa fa-home"></i><b style="padding: 2px;">Personal Details</b> <input type="checkbox" class="checkg" id="gencheckbox" name="nationality" value="0" onchange="submitval(this)" readonly style="background-color:solid green !important; color:green !important; visibility:hidden !important; ">
                                <div class="check" id="gct"></div>
                            </a>
                        </li>
                        <li class="nav-item" class="">
                            <a class="nav-link" style="border: none; cursor: pointer;" id="contact-tab" name="tab2" data-toggle="tab" role="tab" aria-controls="contact" aria-selected="false"><i class="fas fa-file-text"></i><b>Attachments</b> <input type="checkbox" class="checkg" id="expcheckbox" name="nationality" value="0" onchange="submitval(this)" style="background-color:solid green !important; color:green !important; visibility:hidden !important; ">
                                <div class="check" id="expct"></div>
                            </a>
                        </li>
                    </ul>
                </div>
                <div class="tab-content" id="tab-content">
                    <table class="table table-bordered" id="align1" style="display: none;"></table>
                    <div class="tab-pane fade show active" id="tab1" role="tabpanel" aria-labelledby="home-tab">
                        <section class="section">
                            <div class="section-body mt-1">
                                <table class="table table-bordered" id="align1" style="text-align:center;table-layout: fixed;">
                                    <thead>
                                        <tr>
                                            <!-- <th style="width: 7%">S.No</th> -->
                                            <th style="width: 10%"> Name</th>
                                            <th style="width: 15%">Date of Birth</th>
                                            <th style="width: 20%">Contact Number</th>
                                            <th style="width: 20%"> Email Address</th>
                                            <th style="width: 20%">Parent / Guardian Contact number</th>
                                            <th style="width: 20%"> Start Date With Elina</th>
                                            <th style="width: 20%"> Hours Intern per Week</th>

                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr class="trc">
                                            <!-- <td>1</td> -->
                                            <td style="word-break: break-all;">{{$row['name']}}</td>
                                            <td style="word-break: break-all;">{{$row['date_of_birth']}}</td>
                                            <td style="word-break: break-all;">{{$row['contact_number']}}</td>
                                            <td style="word-break: break-all;">{{$row['email_address']}}</td>
                                            <td style="word-break: break-all;">{{$row['parent_guardian_contact_number']}}</td>
                                            <td style="word-break: break-all;">{{$row['start_date_with_elina']}}</td>
                                            <td style="word-break: break-all;">{{$row['hours_intern_elina_per_week']}}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="col-md-12 text-center">
                                <a type="button" class="btn btn-labeled btn-info" onclick="DoAction('tab2');" title="Next" style="background: blue !important; border-color:#4d94ff !important; color:white !important">
                                    <span class="btn-label" style="font-size:13px !important;"><i class="fa fa-arrow-right"></i></span>Next</a>
                                <a type="button" class="btn btn-labeled back-btn" title="Cancel" href="{{ route('internlist') }}" style="color:white !important">
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
                                            <th style="width: 10%">S.No</th>
                                            <th style="width: 35%">Document Name</th>
                                            <th style="width: 35%">Attachment</th>
                                            <th style="width: 20%">View</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr class="trc">
                                            <td>1</td>
                                            <td style="word-break: break-all;">Short Introduction</td>
                                            <td> <img style="width: 26px;" src="https://fia-uganda-edrms.com/images/pdf.png">
                                                <a href="{{$row['short_introduction_fp']}}/{{$row['short_introduction_fn']}}" download="">{{$row['short_introduction_fn']}}</a>
                                            </td>
                                            <td style="word-break: break-all;">
                                            <a class="btn btn-primary" title="View Document" href="{{$row['short_introduction_fp']}}/{{$row['short_introduction_fn']}}" target="_blank" style="margin-inline:5px;cursor:pointer;"><i class="fa fa-eye" style="color:white!important"></i></a> 
                                            <a class="btn btn-info" title="Download Document" href="{{$row['short_introduction_fp']}}/{{$row['short_introduction_fn']}}" download="" style="margin-inline:5px;cursor:pointer;"><i class="fa fa-download" style="color:white!important"></i></a> 
                                        </td>
                                        </tr>
                                        <tr class="trc">
                                            <td>2</td>
                                            <td style="word-break: break-all;">About Elina</td>
                                            <td> <img style="width: 26px;" src="https://fia-uganda-edrms.com/images/pdf.png">
                                                <a href="{{$row['about_elina_fp']}}/{{$row['about_elina_fn']}}" download="">{{$row['about_elina_fn']}}</a>
                                            </td>
                                            <td style="word-break: break-all;"><a class="btn btn-primary" title="View Document" target="_blank" href="{{$row['about_elina_fp']}}/{{$row['about_elina_fn']}}" style="margin-inline:5px;cursor:pointer;"><i class="fa fa-eye" style="color:white!important"></i></a>
                                            <a class="btn btn-info" title="Download Document" href="{{$row['about_elina_fp']}}/{{$row['about_elina_fn']}}" download="" style="margin-inline:5px;cursor:pointer;"><i class="fa fa-download" style="color:white!important"></i></a>  </td>
                                        </tr>
                                        <tr class="trc">
                                            <td>3</td>
                                            <td style="word-break: break-all;">Intern With Elina</td>
                                            <td> <img style="width: 26px;" src="https://fia-uganda-edrms.com/images/pdf.png">
                                                <a href="{{$row['intern_with_elina_fp']}}/{{$row['intern_with_elina_fn']}}" download="">{{$row['intern_with_elina_fn']}}</a>
                                            </td>
                                            <td style="word-break: break-all;"><a class="btn btn-primary" title="View Document" target="_blank" href="{{$row['intern_with_elina_fp']}}/{{$row['intern_with_elina_fn']}}" style="margin-inline:5px;cursor:pointer;"><i class="fa fa-eye" style="color:white!important"></i></a> 
                                            <a class="btn btn-info" title="Download Document" href="{{$row['intern_with_elina_fp']}}/{{$row['intern_with_elina_fn']}}" download="" style="margin-inline:5px;cursor:pointer;"><i class="fa fa-download" style="color:white!important"></i></a> 
                                        </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>

                            <div class="col-md-12 text-center">
                                <a type="button" class="btn btn-labeled btn-info" onclick="DoAction('tab1');" title="Previous" style="background: blue !important; border-color:#4d94ff !important; color:white !important">
                                    <span class="btn-label" style="font-size:13px !important;"><i class="fa fa-arrow-left"></i></span>Previous</a>
                                <a type="button" class="btn btn-labeled back-btn" title="Cancel" href="{{ route('internlist') }}" style="color:white !important">
                                    <span class="btn-label" style="font-size:13px !important;"><i class="fa fa-times"></i></span> Cancel</a>
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

    function getproposaldocument(id) {
        var id = (id);
        $('#modalviewdiv').html('');
        $("#loading_gif").show();
        console.log(id);
        $.ajax({
            url: "{{url('view_proposal_documents')}}",
            type: 'post',
            data: {
                id: id,
                _token: '{{csrf_token()}}'
            },
            error: function() {
                alert('Something is wrong');
            },
            success: function(data) {
                console.log(data.length);
                if (data.length > 0) {
                    $("#loading_gif").hide();
                    var proposaldocuments = "<div class='removeclass' id='modalviewdiv' style=' height:100%'><iframe src='" + data + "' class='document_ifarme_view' style='width:100%; height:100%'></iframe></div>";
                    $('.removeclass').remove();
                    var document = $('#template').append(proposaldocuments);
                }

            }
        });
    };
</script>

@include('newenrollement.formmodal')


@endsection