@extends('layouts.adminnav')

@section('content')
<style>
    #frname {
        color: red;
    }

    .form-control {
        background-color: #ffffff !important;
    }

    .is-coordinate {
        justify-content: center;
    }

    .centerid {
        width: 100%;
        text-align: center;
    }

    #item_no_label,
    #item_label {
        text-transform: capitalize !important;
    }

    #tabs {
        overflow: hidden;
        width: 100%;
        margin: 0;

        padding: 0;
        list-style: none;
        font-size: 16px !important;

    }

    #tabs li {
        float: left;
        margin: 0 .5em 0 0;

    }

    #tabs a {
        color: white !important;
        position: relative;
        background: #3e86bd;
        /* background-image: linear-gradient(to bottom, #1c92d2, #f2fcfe); */
        padding: .4em 1.5em;
        float: left;
        text-decoration: none;
        color: #444;
        text-shadow: 0 1px 0 rgba(255, 255, 255, .8);
        border-radius: 5px 0 0 0;
        box-shadow: 0 2px 2px rgba(0, 0, 0, .4);
    }

    #tabs a:hover,
    #tabs a:hover::after,
    #tabs a:focus,
    #tabs a:focus::after {
        background: #a9cadb;
    }

    #tabs a:focus {
        outline: 0;
    }

    #tabs a::after {
        content: '';
        position: absolute;
        z-index: 1;
        top: 0;
        right: -.5em;
        bottom: 0;
        width: 1em;
        background: #3e86bd;
        /* background-image: linear-gradient(to bottom, #1c92d2, #f2fcfe); */
        box-shadow: 2px 2px 2px rgba(0, 0, 0, .4);
        transform: skew(10deg);
        border-radius: 0 5px 0 0;
    }

    #tabs #current a,
    #tabs #current a::after {
        background: #265077;
        z-index: 3;
        color: white !important;

    }

    tr {
        display: block !important;
        /* float: left !important; */
        /* width: 50%; */
        height: 100%;

    }

    th,
    td {
        display: block !important;
    }

    th {
        width: 300.713px !important;
        display: flex !important;
        align-items: center;
        justify-content: center;
    }

    tbody {
        width: 100%;
    }

    .table {
        display: flex !important;
    }

    thead {
        font-size: 15px !important;
        background-color: rgb(9 48 110) !important;

    }

    #align td,
    #align th,
    #tableExport td,
    #tableExport th,
    #tableExport1 td,
    #tableExport1 th,
    #alignreport td,
    #alignreport th,
    #align2 td,
    #align2 th,
    #align3 td,
    #align3 th,
    #align4 td,
    #align4 th {
        /* border: 1px solid#343a405c !important; */
        padding: 8px !important;
        word-break: break-word !important;
        display: flex !important;
        justify-content: left;
        text-align: left !important;
        align-items: center;
    }

    #align tr:nth-child(odd),
    #alignreport tr:nth-child(odd),
    #align2 tr:nth-child(odd),
    #align3 tr:nth-child(odd),
    #align4 tr:nth-child(odd),
    #tableExport tr:nth-child(odd),
    #tableExport1 tr:nth-child(odd) {
        background-color: initial;
    }
</style>

<div class="main-content">

    <!-- Main Content -->
    <section class="section">
        {{ Breadcrumbs::render('ovmreportview',$rows[0]['ovm_isc_report_id']) }}
        <h5 class="text-center" style="color:darkblue">Conversation Recap</h5>

        <div class="section-body mt-1">
            <!-- <h5 class="text-center" style="color:darkblue">OVM Meeting Report</h5> -->
            <!-- <a style="float:right; position:relative;background-color: #2196f3ab;margin: 0 15px 2px 0px;" class="btn" onclick="return downloadrepo()"><i class="fa fa-arrow-down" aria-hidden="true"></i>&nbsp; Final Report </a>  -->
            @if($rows[0]['report_flag'] != 1)
            <a class="btn btn-labeled btn-warning" style="float:right;background: warning !important;margin: 0 15px 2px 0px; border-color:warning !important; color:warning !important" title="Report Preview" href="{{ route('ovm.preview', Crypt::Encrypt($rows[0]['ovm_isc_report_id'])) }}"><span class="btn-label" style="font-size:13px !important;"><i class="fa fa-file-o"></i></span> Report Preview</a>
            <!-- <a style="float:right; position:relative;background-color: #2196f3ab;margin: 0 15px 2px 0px;cursor: pointer;" class="btn" title="view Document" data-toggle="modal" data-target="#templates" onclick="getproposaldocument()"><i class="fa fa-arrow-down"></i>&nbsp; Final Report </a> -->
            @endif
            <div class="row">
                <div class="col-12">
                    <div class="card">

                        <div class="card-body">

                            <form action="{{route('send_report')}}" method="POST" id="submit_report">
                                @csrf
                                <input type="hidden" value="{{$rows[0]['is_coordinator_id']}}" name="is_coordinator_id" id="is_coordinator_id">
                                <input type="hidden" value="{{$rows[0]['child_id']}}" name="child_id" id="child_id">
                                <input type="hidden" value="{{$rows[0]['child_name']}}" name="child_name" id="child_name">
                                <input type="hidden" id="email_draft" name="email_draft">
                            </form>

                            <div class="table-wrapper">
                                <div class="table-responsive">
                                    <!-- <a type="button" onclick="newfn()"> Resize</a> -->
                                    <table class="table table-bordered" id="alignreport">
                                        <thead>
                                            <tr>
                                                <th>IS Coordinator Name</th>
                                                <th>OVM ID</th>
                                                <th>Child Name</th>
                                                <th>Enrollment Id</th>
                                                <th>Child Id</th>
                                                <th>Parent’s info</th>
                                                <th>Family info</th>
                                                <th>Birth History</th>
                                                <th>Developmental Milestones – Motor / Lang / Speech</th>
                                                <th>Schools attended / School s/he currently in / Grade</th>
                                                <th>Previous interventions given / Current intervention</th>
                                                <th>Any assessment done?</th>
                                                <th>Food / Sleep pattern / Any medication?</th>
                                                <th>Socialization / Emotional /communication/ Sensory</th>
                                                <th>ADLs - General Routine</th>
                                                <th>Strength / Interests</th>
                                                <th>Current challenges / concerns</th>
                                                <th>Other information</th>
                                                <th>Academics</th>
                                                <th>Introspection</th>
                                                <th>Expectation from School</th>
                                                <th>Expectation from Elina</th>
                                                <th>Notes</th>
                                                <th>Status</th>
                                                <!-- <th>Action</th> -->
                                            </tr>
                                        </thead>
                                        <tbody>

                                            @foreach($rows as $key=>$row)
                                            <tr>

                                                <td>{{ $row['name'] }}</td>
                                                <td>{{ $row['ovm_meeting_unique']}}</td>
                                                <td>{{ $row['child_name']}}</td>
                                                <td>{{ $row['enrollment_id']}}</td>
                                                <td>{{ $row['child_id']}}</td>
                                                <td>{{ $row['profession_of_the_parents']}}</td>
                                                <td>{{ $row['siblings']}}</td>
                                                <td>{{ $row['birth_history']}}</td>
                                                <td>{{ $row['developmental_milestones_motor_lang_speech']}}</td>
                                                <td>{{ $row['schools_attended_school_currently_grade']}}</td>
                                                <td>{{ $row['previous_interventions_given_current_intervention']}}</td>
                                                <td>{{ $row['any_assessment_done']}}</td>
                                                <td>{{ $row['food_sleep_pattern_any_medication']}}</td>
                                                <td>{{ $row['socialization_emotional_communication_sensory']}}</td>
                                                <td>{{ $row['adls_general_routine']}}</td>
                                                <td>{{ $row['strength_interests']}}</td>
                                                <td>{{ $row['current_challenges_concerns']}}</td>
                                                <td>{{ $row['other_information']}}</td>
                                                <td>{{ $row['academics']}}</td>
                                                <td>{{ $row['introspection']}}</td>
                                                <td>{{ $row['expectation_from_school']}}</td>
                                                <td>{{ $row['expectation_from_elina']}}</td>
                                                <td>{{ $row['notes']}}</td>
                                                <td>{{ $row['status']}}</td>



                                                <!-- <td class="text-center">

                                                    <form action method="POST" action="">
                                                        @php  $ovmreport= array();
                                                        $id = Crypt::Encrypt($row['ovm_isc_report_id']); @endphp
                                                          @php $role = 'ishead' @endphp

                                                        <a class="btn btn-labeled btn-warning" style="background: warning !important; border-color:warning !important; color:warning !important" title="Report" href="{{ route('ovmcompletedisedit',['id' => $id , 'role' => $role]) }}">
                                                        <span class="btn-label" style="font-size:13px !important;"><i class="fa fa-file-o"></i></span>Edit </a>


                                                        @csrf



                                                    </form>

                                                </td> -->
                                            </tr>
                                            @endforeach
                                        </tbody>

                                    </table>
                                </div>
                            </div>


                        </div>
                    </div>


                    <div class="col-md-12  text-center" style="padding-top: 1rem;">

                        <a type="button" class="btn btn-labeled back-btn" title="Back" href="{{ route('ovmreport') }}" style="color:white !important">
                            <span class="btn-label" style="font-size:13px !important;"><i class="fa fa-arrow-left"></i></span> Back</a>

                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
<script type="text/javascript">
    function downloadrepo() {
        document.getElementById('submit_report').submit();
    }
</script>

<script type="text/javascript">
    $(document).ready(function() {

        $("#content").find("[id^='tab']").hide(); // Hide all content
        $("#tabs li:first").addClass("active"); // Activate the first tab
        $("#tab1").fadeIn(); // Show first tab's content



        $('#tabs a').click(function(e) {
            e.preventDefault();
            if ($(this).closest("li").attr("id") == "current") { //detection for current tab
                return;
            } else {
                $("#content").find("[id^='tab']").hide(); // Hide all content
                $("#tabs li").removeClass("active"); //Reset id's
                $(this).parent().addClass("active"); // Activate this
                $('#' + $(this).attr('name')).fadeIn(); // Show content for the current tab


            }
        });
        setTimeout(function() {
            var td = document.getElementsByTagName('td')
            var th = document.getElementsByTagName('th')
            let tdl = th.length
            let tdrl = td.length
            // console.log(tdl);
            for (let i = 0; i < tdl; i++) {
                th[i].height = (tdl === tdrl) ? td[i].clientHeight - (td[i].clientHeight % 22.501) : ((td[i].clientHeight) >= (td[i + tdl].clientHeight)) ? td[i].clientHeight - (td[i + tdl].clientHeight % 22.501) : td[i + tdl].clientHeight - (td[i].clientHeight % 22.501);
                td[i].height = (tdl === tdrl) ? td[i].clientHeight - (td[i].clientHeight % 22.501) : ((td[i].clientHeight) >= (td[i + tdl].clientHeight)) ? td[i].clientHeight - (td[i + tdl].clientHeight % 22.501) : td[i + tdl].clientHeight - (td[i].clientHeight % 22.501);
                //   console.log(tdl===tdrl);
                if (tdl !== tdrl) {
                    td[i + tdl].height = ((td[i].clientHeight) >= (td[i + tdl].clientHeight)) ? td[i].clientHeight - (td[i + tdl].clientHeight % 22.501) : td[i + tdl].clientHeight - (td[i].clientHeight % 22.501);
                    // console.log(th[i].innerText,i,(td[i].clientHeight ) , (td[i+tdl].clientHeight),td[i+tdl].innerText,td[i].innerText)
                }

                // console.log(td[i].clientHeight,td[i].height)
            }
        }, 100);



        // var a = $("#test").height();
        // $('#test1').css('height', a);

    });

    $(window).resize(function() {

        var td = document.getElementsByTagName('td');
        var th = document.getElementsByTagName('th');
        for (let i = 0; i < td.length / 2; i++) {
            th[i].height = td[i].clientHeight - ((td[i].clientHeight % 22.501));
        }


    }).trigger('resize');
</script>
<script>
    function newfn() {
        var td = document.getElementsByTagName('td')
        var th = document.getElementsByTagName('th')
        for (let i = 0; i < td.length; i++) {
            th[i].height = td[i].clientHeight - (td[i].clientHeight % 22.501);
        }
    }
</script>
<script>
    function send_form() {
        var email_content = tinyMCE.get('email_content').getContent();
        document.getElementById('email_draft').value = email_content;
        $("#loading_gif").show();
        document.getElementById('submit_report').submit();
    }

    function getproposaldocument() {
        var is_coordinator_id = document.getElementById('is_coordinator_id').value;
        var child_id = document.getElementById('child_id').value;
        var child_name = document.getElementById('child_name').value;

        $('#modalviewdiv').html('');
        $("#loading_gif").show();

        $.ajax({
            url: "{{ route('report_download') }}",
            type: 'post',
            data: {
                is_coordinator_id: is_coordinator_id,
                child_id: child_id,
                child_name: child_name,
                _token: '{{csrf_token()}}'
            },
            error: function() {
                alert('Something is wrong');
            },
            success: function(data) {
                // console.log(data.length);
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
@include('ovm1.formmodal')
@endsection