@extends('layouts.adminnav')

@section('content')

<style>
    .content {
        display: none;
    }

    .page {
        width: 210mm;
        /* min-height: 297mm; */
        padding: 20mm;
        margin: 10mm auto;
        border: 1px #D3D3D3 solid;
        border-radius: 5px;
        background: white;
        box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);
    }

    #img_logo {
        margin: 25px 150px 0 0;
    }

    select {
        appearance: none !important;
    }
</style>
<div class="main-content">
    {{ Breadcrumbs::render('assessment_report.show',$report[0]['report_id']) }}
    @if (session('success'))
    <input type="hidden" name="session_data" id="session_data" class="session_data" value="{{ session('success') }}">
    <script type="text/javascript">
    window.onload = function() {
        var message = $('#session_data').val();
        swal.fire("Success", message, "success");

    }
    </script>
    @elseif(session('fail'))

    <input type="hidden" name="session_data" id="session_data1" class="session_data" value="{{ session('error') }}">
    <script type="text/javascript">
    window.onload = function() {
        var message = $('#session_data1').val();
        swal.fire("Info", message, "info");

    }
    </script>
    @endif
    <div class="section-body mt-0">
        <h4 style="color:darkblue;    text-align: center;">Report Preview </h4>

        <input type="hidden" value="{{$report[0]['child_contact_email']}}" id="child_contact_email" name="child_contact_email">
        <input type="hidden" value="{{$report[0]['child_name']}}" id="child_name" name="child_name">
        <input type="hidden" value="{{$report[0]['child_dob']}}" id="child_dob" name="child_dob">
        <input type="hidden" value="{{$report[0]['enrollment_id']}}" id="enrollment_id" name="enrollment_id">
        <!-- <div class="card question">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4 alignment">
                        <div class="form-group">
                            <label class="control-label">Type</label><span class="error-star" style="color:red;">*</span>
                            <input class="form-control" type="text" id="report_type" name="report_type" value="{{$report[0]['report_type']}}" autocomplete="off">
                        </div>
                    </div>

                    <div class="col-md-4 alignment">
                        <div class="form-group">
                            <label class="control-label">Report Name</label><span class="error-star" style="color:red;">*</span>
                            <input class="form-control" type="text" id="report_name" name="report_name" value="{{$report[0]['report_name']}}" autocomplete="off">
                        </div>
                    </div>

                    <div class="col-md-2 alignment">
                        <div class="form-group questionnaire">
                            <label class="control-label required">Total Page</label><br>
                            <input class="form-control" type="number" id="page" name="page" value="{{$report[0]['pages']}}" autocomplete="off">
                        </div>
                    </div>

                    <div class="col-md-2 alignment">
                        <div class="form-group">
                            <label class="control-label">Version</label><span class="error-star" style="color:red;">*</span>
                            <input class="form-control" type="text" id="report_version" name="report_version" value="{{$report[0]['version']}}" autocomplete="off">
                        </div>
                    </div>

                </div>
            </div>
        </div> -->

        <div id="entirePage">
            @foreach($pages as $page)
            <div class="col-12">
                <div class="content" id="content-{{$page['page']}}">

                    <div class="page">
                        <div class="tinymce-body" style="font-family: 'Barlow Semi Condensed', sans-serif;">{!! $page['page_description'] !!}</div>
                        @if($page['page'] == 1)
                        <img style="display: block; margin-left: auto; margin-right: auto;" src="{{Config::get('setting.base_url')}}images/assessment_image.png" width="566">
                        @endif
                        @if($page['assessment_skill'] != null)
                        @foreach($perskill as $perskills)
                        @if($perskills['performance_area_id'] == $page['assessment_skill'] && $perskills['skill_type'] == 1)
                        <div id="table{{$page['page']}}">
                            <div class="table-responsive" style="font-family: 'Barlow Semi Condensed', sans-serif;">
                                <table class="table table-bordered card-body" style="width: 100%;border-spacing: 0px;border-collapse: collapse;">
                                    <thead>
                                        <tr>
                                            <th width="33%" style="border: 1px solid #040404 !important;color: #141414;background-color: white !important;border-collapse: collapse !important;">
                                                {{$page['tab_name']}}
                                            </th>
                                            <th width="33%" style="border: 1px solid #040404 !important;color: #141414;background-color: white !important;border-collapse: collapse !important;">
                                                Observation</th>
                                            <th width="33%" style="border: 1px solid #040404 !important;color: #141414;background-color: white !important;border-collapse: collapse !important;">
                                                Evidence</th>
                                        </tr>
                                    </thead>
                                    <tbody id="tablebody{{$page['page']}}">
                                        @foreach($details as $detail)
                                        @if($page['assessment_skill'] == $detail['performance_area_id'])
                                        <tr>
                                            <td width="33%" style="background: white;border: 1px solid #0e0e0e !important;">

                                                @foreach($activitys as $activity)
                                                @if($page['assessment_skill'] == $activity['performance_area_id'] && $activity['skill_id'] ==  $perskills['skill_id'] )
                                                @if($activity['skill_type'] == 1)
                                                @if( $detail['activity_name'] == $activity['activity_id'] )
                                                <input type="text" style="border: none;width: 100%;" value="{{$activity['activity_name']}}">
                                                @endif
                                                @endif
                                                @endif
                                                @endforeach

                                            </td>
                                            <td width="33%" style="background: white;border: 1px solid #0e0e0e !important;">

                                                @foreach($observations as $observation)
                                                @if( $detail['observation_name'] == $observation['observation_id'] )
                                                <input type="text" style="border: none;width: 100%;" value="{{$observation['observation_name']}}">
                                                @endif
                                                @endforeach

                                            </td>
                                            <td width="33%" style="align-items: center;background: white;border: 1px solid #0e0e0e !important;">
                                                {{$detail['evidence']}}
                                            </td>
                                        </tr>
                                        @endif
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        @elseif($perskills['performance_area_id'] == $page['assessment_skill'] && $perskills['skill_type'] == 2)
                        <div id="table_a{{$page['page']}}">
                            <div class="table-responsive" style="font-family: 'Barlow Semi Condensed', sans-serif;">
                                <table class="table table-bordered card-body" style="width: 100%;border-spacing: 0px;border-collapse: collapse;">
                                    <thead>
                                        <tr>
                                            <th colspan="3" style="background-color: white !important;color: #141414;text-align: left;border: 1px solid #040404 !important;border-collapse: collapse !important;">
                                                {{$perskills['skill_name']}}
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody id="tablebody_a{{$page['page']}}">
                                        @foreach($details2 as $detail)
                                        @if($page['assessment_skill'] == $detail['performance_area_id'])
                                        <tr>
                                            <td width="33%" style="background: white;border: 1px solid #0e0e0e !important;">

                                                @foreach($activitys as $activity)
                                                @if($activity['skill_type'] == 2)
                                                @if($page['assessment_skill'] == $activity['performance_area_id'])
                                                @if( $detail['activity_name'] == $activity['activity_id'] )
                                                <input type="text" style="border: none;width: 100%;" value="{{$activity['activity_name']}}">
                                                @endif
                                                @endif
                                                @endif
                                                @endforeach

                                            </td>
                                            <td width="33%" style="background: white;border: 1px solid #0e0e0e !important;">

                                                @foreach($observations as $observation)
                                                @if( $detail['observation_name'] == $observation['observation_id'] )
                                                <input type="text" style="border: none;width: 100%;" value="{{$observation['observation_name']}}">
                                                @endif
                                                @endforeach

                                            </td>
                                            <td width="33%" style="align-items: center !important;background: white !important;border: 1px solid #0e0e0e !important;">
                                                {{$detail['evidence']}}
                                            </td>
                                        </tr>
                                        @endif
                                        @endforeach


                                    </tbody>
                                </table>
                            </div>
                        </div>
                        @elseif($perskills['performance_area_id'] == $page['assessment_skill'] && $perskills['skill_type'] == 3)
                        <!--  -->
                        <div id="table{{$page['page']}}">
                            <div class="table-responsive" style="font-family: 'Barlow Semi Condensed', sans-serif;">
                                <table class="table table-bordered card-body" style="width: 100%;border-spacing: 0px;border-collapse: collapse;">
                                    <thead>
                                        <tr>
                                            <th width="33%" style="border: 1px solid #040404 !important;color: #141414;background-color: white !important;border-collapse: collapse !important;">
                                            {{$page['tab_name']}}</th>
                                            <th width="33%" style="border: 1px solid #040404 !important;color: #141414;background-color: white !important;border-collapse: collapse !important;">
                                                Observation</th>
                                            <th width="33%" style="border: 1px solid #040404 !important;color: #141414;background-color: white !important;border-collapse: collapse !important;">
                                                Evidence</th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                        @php $j= array() ; @endphp
                        @foreach($subskill as $sskill)
                        @if($page['assessment_skill'] == $sskill['performance_area_id'] && $sskill['primary_skill_id'] == $perskills['skill_id'])
                        @foreach($details3 as $detail)
                        @if($detail['performance_area_id'] == $sskill['performance_area_id'])
                        @php $fid = $detail['activity_name'] @endphp
                        @if(!in_array( $fid , $j ))
                        @php $f = 0; array_push($j , $detail['activity_name']); @endphp
                        <div class="table-responsive" id="table_b{{$sskill['skill_id']}}" style="font-family: 'Barlow Semi Condensed', sans-serif;">
                            <table class="table table-bordered card-body" style="width: 100%;border-spacing: 0px;border-collapse: collapse;">
                                <thead>
                                    <tr>
                                        <th colspan="3" style="background-color: white !important;color: #141414;text-align: left;border: 1px solid #040404 !important;border-collapse: collapse !important;">
                                            {{$sskill['skill_name']}}
                                        </th>
                                    </tr>
                                </thead>
                                <tbody id="tablebody_b{{$sskill['skill_id']}}">
                                    @foreach($details3 as $detail)
                                    @php $looppasstab3 = 0 @endphp
                                    @foreach($activitys as $activity)
                                    @if($sskill['skill_id'] == $activity['sub_skill'])
                                    @if( $detail['activity_name'] == $activity['activity_id'] )
                                    @php $looppasstab3 = 1 @endphp
                                    @endif
                                    @endif
                                    @endforeach
                                    @if($looppasstab3 == 1)
                                    <tr class="firstrow">
                                        <td width="33%" style="background: white;border: 1px solid #0e0e0e !important;">

                                            @foreach($activitys as $activity)
                                            @if( $detail['activity_name'] == $activity['activity_id'] )
                                            @php $f = 1; @endphp
                                            <input type="text" style="border: none;width: 100%;" value="{{$activity['activity_name']}}">
                                            @endif
                                            @endforeach

                                        </td>
                                        <td width="33%" style="background: white;border: 1px solid #0e0e0e !important;">

                                            @foreach($observations as $observation)
                                            @if( $detail['observation_name'] == $observation['observation_id'] )
                                            <input type="text" style="border: none;width: 100%;" value="{{$observation['observation_name']}}">
                                            @endif
                                            @endforeach

                                        </td>
                                        <td width="33%" style="align-items: center;background: white;border: 1px solid #0e0e0e !important;">{{$detail['evidence'] }}
                                        </td>
                                    </tr>
                                    @endif
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        @if($f = 1) @break @endif
                        @endif
                        @endif
                        @endforeach
                        @endif
                        @endforeach
                        <!--  -->
                        @endif
                        @endforeach
                        @endif

                        @if($page['page'] == 6)
                        <!-- Page 8 -->
                        <!-- <div class="col-12 scrollable fixTableHead title-padding" id="page8table">
                            <div class="table-responsive">
                                <table class="table table-bordered card-body" id="main2" style="width: 100%;border-spacing: 0px;border-collapse: collapse;">
                                    <thead>
                                        <tr>
                                            <th style="border: 1px solid #040404 !important;color: #141414;background-color: white !important;">Seeks out and is attracted to a stimulating sensory environment</th>
                                            <th style="border: 1px solid #040404 !important;color: #141414;background-color: white !important;">Distressed by a stimulating sensory environment and attemptsto leave the environment</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($page8 as $table8)
                                        <tr id="row2">
                                            <td style="background: white;border: 1px solid #0e0e0e !important;"> {{$table8['sensory_profiling1']}}</td>
                                            <td style="background: white;border: 1px solid #0e0e0e !important;"> {{$table8['sensory_profiling2']}}</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div> -->
                        <div class="col-12 scrollable fixTableHead title-padding" id="page8table">
                            <div class="table-responsive" style="font-family: 'Barlow Semi Condensed', sans-serif;">
                                <table class="table table-bordered card-body" id="main">
                                    <thead>
                                        <tr>
                                            <th style="border: 1px solid #040404 !important;color: #141414;background-color: white !important;">Seeking/Seeker
                                                <br>
                                                <p style="line-height: initial;font-weight: lighter;">Seeks out and is attracted to a stimulating sensory environment</p>
                                            </th>
                                            <th style="border: 1px solid #040404 !important;color: #141414;background-color: white !important;">Avoiding/Avoider
                                                <p style="line-height: initial;font-weight: lighter;">Distressed by a stimulating sensory environment and attempts to leave the environment</p>
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr id="row">
                                            <td style="background: white;border: 1px solid #0e0e0e !important;vertical-align: initial !important;">{{$page8[0]['sensory_profiling1']}}
                                            </td>
                                            <td style="background: white;border: 1px solid #0e0e0e !important;vertical-align: initial !important;">{{$page8[0]['sensory_profiling2']}}
                                            </td>
                                        </tr>
                                    </tbody>
                                    <thead>
                                        <tr>
                                            <th style="border: 1px solid #040404 !important;color: #141414;background-color: white !important;">Sensitivity/Sensor
                                                <br>
                                                <p style="line-height: initial;font-weight: lighter;">Distractibility, discomfort with sensory stimuli</p>
                                            </th>
                                            <th style="border: 1px solid #040404 !important;color: #141414;background-color: white !important;">Registration/Bystander
                                                <p style="line-height: initial;font-weight: lighter;">Missing stimuli, responding slowly</p>
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr id="row">
                                            <td style="background: white;border: 1px solid #0e0e0e !important;vertical-align: initial !important;">{{$page8[0]['sensory_profiling3']}}
                                            </td>
                                            <td style="background: white;border: 1px solid #0e0e0e !important;vertical-align: initial !important;">{{$page8[0]['sensory_profiling4']}}
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <!-- End 8 -->
                        @endif
                    </div>
                </div>
            </div>
            @endforeach
        </div>

    </div>
    <div class="col-md-12 text-center" style="padding: 10px;">
        <a type="button" class="btn btn-labeled btn-info back" id="Previous" title="Previous" style="display:none;height: 35px;background: blue !important; border-color:blue !important; color:white !important">
            <span class="btn-label" style="font-size:13px !important;"><i class="fa fa-arrow-left"></i></span> Previous</a>
        <a type="button" class="btn btn-labeled back-btn" title="Back" href="{{ URL::previous() }}" style="color:white !important">
            <span class="btn-label" style="font-size:13px !important;"><i class="fa fa-arrow-left"></i></span> Back</a>
        <input type="hidden" value="{{ route('assessmentreport.edit', \Crypt::encrypt($report[0]['report_id'])) }}" id="routeUrl">
        <a href="{{ route('assessmentreport.edit', \Crypt::encrypt($report[0]['report_id'])) }}" type="button" id="editbutton" class="btn btn-labeled btn-succes" title="Edit" style="background: orange !important; color:white !important">
            <span class="btn-label" style="font-size:13px !important;"><i class="fas fa-pencil-alt"></i></span> Edit </a>
        <a type="button" onclick="pdfgenrate('{{$report[0]['report_id']}}')" id="submitbutton" class="btn btn-labeled btn-succes" title="Publish" style="background: green !important; border-color:green !important; color:white !important">
            <span class="btn-label" style="font-size:13px !important;"><i class="fa fa-check"></i></span> Publish </a>
        <a type="button" class="btn btn-labeled btn-info next" id="Next" title="Next" style="background: blue !important; border-color:#4d94ff !important; color:white !important;height: 35px;">
            <span class="btn-label" style="font-size:13px !important;">Next</span> <i class="fa fa-arrow-right"></i></a>
    </div>
</div>

<script>
    function pdfgenrate(reportID) {
        $(".loader").show();
        var totalPage1 = <?php echo (json_encode($pages)); ?>;
        for (var gj = 0; gj < totalPage1.length; gj++) {
            var id = totalPage1[gj].page;
            console.log(id);
            $('#content-' + id).show();
        }
        var entirePage = $('#entirePage').html();
        var child_dob = document.getElementById('child_dob').value;
        var child_name = document.getElementById('child_name').value;
        var child_contact_email = document.getElementById('child_contact_email').value;
        var enrollment_id = document.getElementById('enrollment_id').value;
        // entirePage = entirePage.replace(/<\/?span[^>]*>/g, "");
        $("#submitbutton").addClass("disable-click");
        $.ajax({
            url: "{{ url('/report/assessment/generatePDFAssessment') }}",
            type: 'POST',
            data: {
                'reportID': reportID,
                'entirePage': entirePage,
                'child_name': child_name,
                'child_dob': child_dob,
                'child_contact_email': child_contact_email,
                'enrollment_id': enrollment_id,
                _token: '{{csrf_token()}}'
            }
        }).done(function(data) {
            console.log(data);
            // swal.fire("Success", "Assessment Report Sent Successfully", "success");
            // // 
            for (var gj = 1; gj < totalPage1.length; gj++) {
                var id = totalPage1[gj].page;
                console.log(id);
                $('#content-' + id).hide();
            }
            $(".loader").hide();
            swal.fire("Success", "Assessment Report Sent Successfully", "success").then(function() {
                window.location = "/report/assessmentreport";
            });


            // 

        })
    }
</script>
<script type="text/javascript">
    $(document).ready(function() {
        $('#content-1').show();
        var pages = <?php echo json_encode($pages); ?>;
        for (p = 0; p < pages.length; p++) {
            var k = p + 1;
            tinymce.init({
                selector: '.tinymce-body',
                inline: true,
                menubar: false,
                branding: false,
                plugins: 'searchreplace',
                toolbar: 'undo redo | formatselect | ' +
                    'bold italic backcolor | alignleft aligncenter ' +
                    'alignright alignjustify | bullist numlist outdent indent | ' +
                    'removeformat | searchreplace',
            });
        }
    });
</script>

<script>
    function discription_content() {
        document.getElementById('new_page').submit();
    }

    var counter = 1;
    var totalPage = <?php echo (json_encode($totalPage)); ?>;

    $('body').on('click', '.next', function() {
        $('.content').hide();

        counter++;
        $('#content-' + counter + '').show();

        if (counter > 1) {
            $('.back').show();
        };
        if (counter >= totalPage) {
            $('.next').hide();
        };
        $('html,body').scrollTop(0);
        $('#editbutton').removeAttr('href');
        var url = document.getElementById('routeUrl').value;
        url += '?' + $.param({
            currentPage: counter
        });
        $('#editbutton').attr('href', url);
    });

    $('body').on('click', '.back', function() {
        counter--;
        $('.content').hide();
        var id = counter;
        $('#content-' + id).show();
        if (counter == 1) {
            $('.back').hide();
            $('.next').show();
        };
        if (counter != 1) {
            $('.next').show();
        }
        $('html,body').scrollTop(0);
        $('#editbutton').removeAttr('href');
        var url = document.getElementById('routeUrl').value;
        url += '?' + $.param({
            currentPage: counter
        });
        $('#editbutton').attr('href', url);

    });
</script>
<script>
    $(document).ready(function() {
        var entirePage = document.getElementById('entirePage').innerHTML;

    });
</script>

@endsection