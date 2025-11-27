@extends('layouts.adminnav')

@section('content')

<style>
    .content {
        /* display: none; */
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

    .container {
        margin: 0 auto;
        background-color: #FFFFFF;
        padding: 20px;
        box-shadow: 0px 0px 10px #BBBBBB;
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
    <div class="col-12 form-group" style="float:left;">
        <h4 style="color:darkblue;text-align: center;">Report Preview</h4>
        <select class="col-2 form-control default" style="margin: -45px 0 0 -15px;" id="Tableview" onchange="view_change()">
            <option value="1">Assessment Executive Report</option>
            <option value="2">Assessment Detail Report</option>
        </select>
    </div>
    <div class="section-body mt-0">
        <input type="hidden" value="{{$report[0]['child_contact_email']}}" id="child_contact_email" name="child_contact_email">
        <input type="hidden" value="{{$report[0]['child_name']}}" id="child_name" name="child_name">
        <input type="hidden" value="{{$report[0]['child_dob']}}" id="child_dob" name="child_dob">
        <input type="hidden" value="{{$report[0]['enrollment_id']}}" id="enrollment_id" name="enrollment_id">
        <div id="entirePage">
            <div class="col-12">
                <div class="content view1" id="report1">
                    <div class="page">
                        @foreach($pages as $page)
                        <div class="tinymce-body" style="font-family: 'Barlow Semi Condensed', sans-serif;">
                            @if($page['page'] != 3 && $page['page'] != 4 && $page['page'] != 5 && $page['page'] != 6 && $page['page'] != 7 && $page['page'] != 8 && $page['page'] != 9 && $page['page'] != 10 && $page['page'] != 11)
                            {!! $page['page_description'] !!}
                            @if($page['page'] == 1)
                            <img style="display: block; margin-left: auto; margin-right: auto;" src="{{Config::get('setting.base_url')}}images/assessment_image.png" width="566">
                            @endif
                            @endif
                            <!--  -->
                            @if($page['page'] == 3)
                            <p>1. CURRENT PERFORMANCE LEVEL IN 8 AREAS:</p>
                            <div id="table">
                                <div class="table-responsive" style="font-family: 'Barlow Semi Condensed', sans-serif;">
                                    <table class="table table-bordered card-body" style="width: 100%;border-spacing: 0px;border-collapse: collapse;">
                                        <tbody id="tablebody">
                                            <tr>
                                                <td width="30%" style="background: white;border: 1px solid #0e0e0e !important;">Physical</td>
                                                <td width="80%" style="background: white;border: 1px solid #0e0e0e !important;">@foreach($pages as $page)
                                                    @if($page['page'] == 3)
                                                    {!! $page['page_description'] !!}
                                                    @endif
                                                    @endforeach</td>
                                            </tr>
                                            <tr>
                                                <td width="30%" style="background: white;border: 1px solid #0e0e0e !important;">Gross Motor</td>
                                                <td width="80%" style="background: white;border: 1px solid #0e0e0e !important;">@foreach($pages as $page)
                                                    @if($page['page'] == 4)
                                                    {!! $page['page_description'] !!}
                                                    @endif
                                                    @endforeach</td>
                                            </tr>
                                            <tr>
                                                <td width="30%" style="background: white;border: 1px solid #0e0e0e !important;">Fine Motor</td>
                                                <td width="80%" style="background: white;border: 1px solid #0e0e0e !important;">@foreach($pages as $page)
                                                    @if($page['page'] == 5)
                                                    {!! $page['page_description'] !!}
                                                    @endif
                                                    @endforeach</td>
                                            </tr>
                                            <tr>
                                                <td width="30%" style="background: white;border: 1px solid #0e0e0e !important;">Sensory</td>
                                                <td width="80%" style="background: white;border: 1px solid #0e0e0e !important;">@foreach($pages as $page)
                                                    @if($page['page'] == 6)
                                                    {!! $page['page_description'] !!}
                                                    @endif
                                                    @endforeach</td>
                                            </tr>
                                            <tr>
                                                <td width="30%" style="background: white;border: 1px solid #0e0e0e !important;">Cognitive</td>
                                                <td width="80%" style="background: white;border: 1px solid #0e0e0e !important;">@foreach($pages as $page)
                                                    @if($page['page'] == 7)
                                                    {!! $page['page_description'] !!}
                                                    @endif
                                                    @endforeach</td>
                                            </tr>
                                            <tr>
                                                <td width="30%" style="background: white;border: 1px solid #0e0e0e !important;">Speech and Communication</td>
                                                <td width="80%" style="background: white;border: 1px solid #0e0e0e !important;">@foreach($pages as $page)
                                                    @if($page['page'] == 8)
                                                    {!! $page['page_description'] !!}
                                                    @endif
                                                    @endforeach</td>
                                            </tr>
                                            <tr>
                                                <td width="30%" style="background: white;border: 1px solid #0e0e0e !important;">Social and Emotional</td>
                                                <td width="80%" style="background: white;border: 1px solid #0e0e0e !important;">@foreach($pages as $page)
                                                    @if($page['page'] == 9)
                                                    {!! $page['page_description'] !!}
                                                    @endif
                                                    @endforeach</td>
                                            </tr>
                                            <tr>
                                                <td width="30%" style="background: white;border: 1px solid #0e0e0e !important;">Play</td>
                                                <td width="80%" style="background: white;border: 1px solid #0e0e0e !important;">@foreach($pages as $page)
                                                    @if($page['page'] == 10)
                                                    {!! $page['page_description'] !!}
                                                    @endif
                                                    @endforeach</td>
                                            </tr>
                                            <tr>
                                                <td width="30%" style="background: white;border: 1px solid #0e0e0e !important;">ADLs</td>
                                                <td width="80%" style="background: white;border: 1px solid #0e0e0e !important;">@foreach($pages as $page)
                                                    @if($page['page'] == 11)
                                                    {!! $page['page_description'] !!}
                                                    @endif
                                                    @endforeach</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            @endif
                            <!--  -->
                        </div>
                        @endforeach

                    </div>
                </div>
                <div class="content tinymce-body view2" style="display: none;" id="report2">
                    <div class="page">
                        @foreach($pages as $page)
                        @if($page['assessment_skill'] != null)
                        {{$page['tab_name']}}
                        @foreach($perskill as $perskills)
                        @if($perskills['performance_area_id'] == $page['assessment_skill'] && $perskills['skill_type'] == 1)
                        <div id="table{{$page['page']}}">
                            <div class="table-responsive" style="font-family: 'Barlow Semi Condensed', sans-serif;">
                                <table class="table table-bordered card-body" style="width: 100%;border-spacing: 0px;border-collapse: collapse;">
                                    <thead>
                                        <tr>
                                            @if($perskills['skill_name'] != null || $perskills['skill_name'] != '')
                                            <th width="33%" style="border: 1px solid #040404 !important;color: #141414;background-color: white !important;border-collapse: collapse !important;">{{$perskills['skill_name']}}</th>
                                            @else
                                            <th width="33%" style="border: 1px solid #040404 !important;color: #141414;background-color: white !important;border-collapse: collapse !important;">{{$page['tab_name']}}</th>
                                            @endif
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
                                                @if($page['assessment_skill'] == $activity['performance_area_id'] && $activity['skill_id'] == $perskills['skill_id'] )
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
                        <div class="myTableheader{{$page['page']}}" id="table_a{{$page['page']}}">
                            <div class="table-responsive" style="font-family: 'Barlow Semi Condensed', sans-serif;">
                                <table class="table table-bordered card-body myTable{{$page['page']}}" style="width: 100%;border-spacing: 0px;border-collapse: collapse;">
                                    <thead>
                                        <tr>
                                            <th colspan="3" style="background-color: white !important;color: #141414;text-align: left;border: 1px solid #040404 !important;border-collapse: collapse !important;">
                                                {{$perskills['skill_name']}}
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody id="tablebody_a{{$page['page']}}">
                                        @foreach($details2 as $detail)
                                        @if($page['assessment_skill'] == $detail['performance_area_id'] && $detail['cheSkill'] == $perskills['skill_id'])
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
                                            @if($perskills['skill_name'] != null || $perskills['skill_name'] != '')
                                            <th width="33%" style="border: 1px solid #040404 !important;color: #141414;background-color: white !important;border-collapse: collapse !important;">
                                                {{$perskills['skill_name']}}
                                            </th>
                                            @else
                                            <th width="33%" style="border: 1px solid #040404 !important;color: #141414;background-color: white !important;border-collapse: collapse !important;">
                                                {{$page['tab_name']}}
                                            </th>
                                            @endif
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
                        {{$page['tab_name']}}
                        <div class="scrollable fixTableHead title-padding" id="page8table">
                            <div class="table-responsive" style="font-family: 'Barlow Semi Condensed', sans-serif;">
                                <table class="table table-bordered card-body" id="main" style="border-collapse: collapse;">
                                    <thead>
                                        <tr>
                                            <th style="border: 1px solid #040404 !important;color: #141414;background-color: white !important;border-collapse: collapse;">Seeking/Seeker
                                                <br>
                                                <p style="line-height: initial;font-weight: lighter;">Seeks out and is attracted to a stimulating sensory environment</p>
                                            </th>
                                            <th style="border: 1px solid #040404 !important;color: #141414;background-color: white !important;border-collapse: collapse;">Avoiding/Avoider
                                                <p style="line-height: initial;font-weight: lighter;">Distressed by a stimulating sensory environment and attempts to leave the environment</p>
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr id="row">
                                            <td style="background: white;border: 1px solid #0e0e0e !important;vertical-align: initial !important;border-collapse: collapse;">{{$page8[0]['sensory_profiling1']}}
                                            </td>
                                            <td style="background: white;border: 1px solid #0e0e0e !important;vertical-align: initial !important;border-collapse: collapse;">{{$page8[0]['sensory_profiling2']}}
                                            </td>
                                        </tr>
                                    </tbody>
                                    <thead>
                                        <tr>
                                            <th style="border: 1px solid #040404 !important;color: #141414;background-color: white !important;border-collapse: collapse;">Sensitivity/Sensor
                                                <br>
                                                <p style="line-height: initial;font-weight: lighter;">Distractibility, discomfort with sensory stimuli</p>
                                            </th>
                                            <th style="border: 1px solid #040404 !important;color: #141414;background-color: white !important;border-collapse: collapse;">Registration/Bystander
                                                <p style="line-height: initial;font-weight: lighter;">Missing stimuli, responding slowly</p>
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr id="row">
                                            <td style="background: white;border: 1px solid #0e0e0e !important;vertical-align: initial !important;border-collapse: collapse;">{{$page8[0]['sensory_profiling3']}}
                                            </td>
                                            <td style="background: white;border: 1px solid #0e0e0e !important;vertical-align: initial !important;border-collapse: collapse;">{{$page8[0]['sensory_profiling4']}}
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <!-- End 8 -->
                        @endif
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

    </div>
    <div class="col-md-12 text-center" style="padding: 10px;">
        <!-- <a type="button" class="btn btn-labeled btn-info back" id="Previous" title="Previous" style="display:none;height: 35px;background: blue !important; border-color:blue !important; color:white !important">
            <span class="btn-label" style="font-size:13px !important;"><i class="fa fa-arrow-left"></i></span> Previous</a> -->
        <a type="button" class="btn btn-labeled back-btn" title="Back" href="{{ URL::previous() }}" style="color:white !important">
            <span class="btn-label" style="font-size:13px !important;"><i class="fa fa-arrow-left"></i></span> Back</a>
        <input type="hidden" value="{{ route('assessmentreport.edit', \Crypt::encrypt($report[0]['report_id'])) }}" id="routeUrl">
        <a href="{{ route('assessmentreport.edit', \Crypt::encrypt($report[0]['report_id'])) }}" type="button" id="editbutton" class="btn btn-labeled btn-succes" title="Edit" style="background: orange !important; color:white !important">
            <span class="btn-label" style="font-size:13px !important;"><i class="fas fa-pencil-alt"></i></span> Edit </a>
        <a type="button" onclick="pdfgenrate('{{$report[0]['report_id']}}')" id="submitbutton" class="btn btn-labeled btn-succes" title="Publish" style="background: green !important; border-color:green !important; color:white !important">
            <span class="btn-label" style="font-size:13px !important;"><i class="fa fa-check"></i></span> Publish </a>
        <!-- <a type="button" class="btn btn-labeled btn-info next" id="Next" title="Next" style="background: blue !important; border-color:#4d94ff !important; color:white !important;height: 35px;">
                <span class="btn-label" style="font-size:13px !important;">Next</span> <i class="fa fa-arrow-right"></i></a> -->
    </div>
</div>

<script>
    function pdfgenrate(reportID) {
        $(".loader").show();

        $('.view1').show();
        $('.view2').show();

        var view1 = $('.view1').html(); //console.log(view1);
        var view2 = $('.view2').html(); //console.log(view2);
        // var view = [view1 , view2];
        var child_dob = document.getElementById('child_dob').value;
        var child_name = document.getElementById('child_name').value;
        var child_contact_email = document.getElementById('child_contact_email').value;
        var enrollment_id = document.getElementById('enrollment_id').value;
        $("#submitbutton").addClass("disable-click");
        $.ajax({
            url: "{{ url('/report/assessment/generatePDFAssessment') }}",
            type: 'POST',
            data: {
                'reportID': reportID,
                'view1': view1,
                'view2': view2,
                'child_name': child_name,
                'child_dob': child_dob,
                'child_contact_email': child_contact_email,
                'enrollment_id': enrollment_id,
                _token: '{{csrf_token()}}'
            }
        }).done(function(data) {
            $('.view2').hide();
            $(".loader").hide();

            console.log(data);
            var newWindow = window.open('Report', '_blank', 'newwindow' ,'width=1000,height=720');
            newWindow.document.title = 'Custom Window Title';
            var newContent = '<iframe src="'+data.summary_report+'" width="100%" height="600" frameborder="0"></iframe>';
            newWindow.document.write(newContent);

            // var newWindow = window.open('', '_blank', 'width=1000,height=720');
            // var newContent = '<iframe src="'+data.executive_report+'" width="100%" height="600" frameborder="0"></iframe>';
            // newWindow.document.write(newContent);

            // swal.fire("Success", "Assessment Report Sent Successfully", "success").then(function() {
            //     window.location = "/report/assessmentreport";
            // });
        })
    }
</script>
<script type="text/javascript">
    $(document).ready(function() {
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

        $('#content-1').show();

        var pages = <?php echo json_encode($pages); ?>;
        for (p = 0; p < pages.length; p++) {
            var pgNo = pages[p].page;
            if ($(".myTable" + pgNo + " tr").length <= 1) {
                $(".myTableheader" + pgNo).hide();
            }
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

    function view_change() {
        var i = $('#Tableview').val();
        $('.view1').toggle();
        $('.view2').toggle();
    }
</script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var tables = document.getElementsByClassName('table');

        for (var i = 0; i < tables.length; i++) {
            var table = tables[i];
            if (table.rows.length <= 1) {
                table.style.display = 'none';
            }
        }
    });
</script>
@endsection