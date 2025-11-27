@extends('layouts.adminnav')

@section('content')
<style>
    .form-control {
        background-color: #ffffff !important;
    }

    .form-control:disabled,
    .form-control[readonly] {
        background-color: #e9ecef !important;
    }

    textarea.form-control {
        resize: none;
        height: 200px !important;
    }
</style>
<style>
    table {
        border-collapse: collapse;
    }

    td,
    th {
        border: 1px solid black;
        padding: 10px;
        font-weight: bolder;
        color: black;
    }

    div.dataTables_wrapper div.dataTables_paginate ul.pagination {
        justify-content: center !important;
    }

    .tooltiptext1 {
        font-weight: 100;
    }

    .error {
        border: 2px solid red;
        border-color: red !important;
    }
</style>
<div class="main-content">
    {{ Breadcrumbs::render('ovmcompleted') }}
    @if (session('success'))
    <input type="hidden" name="session_data" id="session_data" class="session_data" value="{{ session('success') }}">
    <input type="hidden" name="session_page" id="session_page" value="{{ session('page') }}">
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
    <div class="section-body mt-1">
        <h5 class="text-center" style="color:darkblue">Conversation Summary</h5>
        @foreach($rows as $key=>$row)
        <form action="{{route('ovmiscfeedbackstore',$row['ovm_isc_report_id'])}}" method="POST" id="ovmisc" name="ovmisc" enctype="multipart/form-data">
            {{ csrf_field() }}
            @method('PUT')
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <input type="hidden" id="currentPage" name="currentPage">
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="control-label">Enrollment ID</label>
                                        <input class="form-control" name="enrollment_id" placeholder="Enrollment ID" value="{{ $row['enrollment_id']}}" readonly>
                                        <input type="hidden" class="form-control" name="editusername" placeholder="editusername" value="{{$editusername}}" readonly>

                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="control-label">OVM Meeting ID</label>
                                        <input class="form-control" type="text" id="ovm_meeting_unique" name="ovm_meeting_unique" value="{{ $row['ovm_meeting_unique']}}" placeholder="OVM1 Meeting" autocomplete="off" readonly>

                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="control-label">Child ID</label>
                                        <input class="form-control" type="text" id="child_id" name="child_id" value="{{ $row['child_id']}}" placeholder="OVM1 Meeting" autocomplete="off" readonly>

                                    </div>
                                </div>



                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="control-label">Child Name</label>
                                        <input class="form-control" type="text" id="child_name" name="child_name" value="{{ $row['child_name']}}" placeholder="Enter Name" autocomplete="off" readonly>
                                    </div>
                                </div>


                                @if( $row['video_link1']!= '')
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="control-label">Video Link</label>
                                        <div style="display: flex;">
                                            <input class="form-control" readonly type="url" id="video_link" name="video_link" autocomplete="off" value="{{$row['video_link1']}}">
                                            <a class="btn btn-link" title="show" target="_blank" href="{{$row['video_link1']}}"><i class="fas fa-eye" style="color:green"></i></a>
                                        </div>
                                        {{-- <input class="form-control"  readonly type="url" id="video_link" name="video_link" autocomplete="off" value="Video Not Available"> --}}

                                    </div>
                                </div>
                                @endif








                            </div>
                        </div>
                    </div>
                </div>




                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="table-wrapper">
                                    <div class="table-responsive">
                                        <table class="table" id="myTable">
                                            <thead>
                                                <tr>
                                                    <th width="35%">Areas</th>
                                                    <th>Conversation summary</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>Parent’s info<span class="tooltiptext1"><br>Name of parents<br>Are both parents present?<br>Profession (we don’t ask it explicitly but if it comes in the discussion)</span></td>
                                                    <td><textarea class="form-control default" order="0" id="profession_of_the_parents" title="Profession of the parents" name="profession_of_the_parents" {{ ($row['status']=="Submitted") || ($row['status']=="Completed") && $rolename !='IS Head'? "disabled" : "" }}>{{ $row['profession_of_the_parents']}}</textarea></td>
                                                </tr>
                                                <tr>
                                                    <td>Family info<span class="tooltiptext1"><br>-Siblings?<br>-Nuclear/joint family?<br>- Primary caretaker?<br>-Any other important info (single parent, history of illness in family etc)</span></td>
                                                    <td><textarea class="form-control default" order="0" id="siblings" title="Siblings" name="siblings" {{ ($row['status']=="Submitted") || ($row['status']=="Completed") && $rolename !='IS Head'? "disabled" : "" }}>{{ $row['siblings']}}</textarea></td>
                                                </tr>
                                                <tr>
                                                    <td>Birth History</td>
                                                    <td><textarea class="form-control default" order="0" id="birth_history" title="Birth History" name="birth_history" {{ ($row['status']=="Submitted") || ($row['status']=="Completed") && $rolename !='IS Head'? "disabled" : "" }}>{{ $row['birth_history']}}</textarea></td>
                                                </tr>
                                                <tr>
                                                    <td>Developmental Milestones – Motor / Lang / Speech</td>
                                                    <td><textarea class="form-control default" order="0" id="developmental_milestones_motor_lang_speech" title="Developmental Milestones Motor Lang Speech" name="developmental_milestones_motor_lang_speech" {{ ($row['status']=="Submitted") || ($row['status']=="Completed") && $rolename !='IS Head'? "disabled" : "" }}>{{ $row['developmental_milestones_motor_lang_speech']}}</textarea></td>
                                                </tr>
                                                <tr>
                                                    <td>Schools attended / School s/he currently in / Grade</td>
                                                    <td>
                                                        <textarea class="form-control default" order="0" id="schools_attended_school_currently_grade" title="Schools Attended School Currently Grade" name="schools_attended_school_currently_grade" {{ ($row['status']=="Submitted") || ($row['status']=="Completed") && $rolename !='IS Head'? "disabled" : "" }}>{{ $row['schools_attended_school_currently_grade']}}</textarea>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Previous interventions given / Current intervention </td>
                                                    <td>
                                                        <textarea class="form-control default" order="1" id="previous_interventions_given_current_intervention" title="Previous Interventions Given Current Intervention" name="previous_interventions_given_current_intervention" {{ ($row['status']=="Submitted") || ($row['status']=="Completed") && $rolename !='IS Head'? "disabled" : "" }}>{{ $row['previous_interventions_given_current_intervention']}}</textarea>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Any assessment done?</td>
                                                    <td>
                                                        <textarea class="form-control default" order="1" id="any_assessment_done" title="Any Assessment Done" name="any_assessment_done" {{ ($row['status']=="Submitted") || ($row['status']=="Completed") && $rolename !='IS Head'? "disabled" : "" }}>{{ $row['any_assessment_done']}}</textarea>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Food / Sleep pattern / Any medication?</td>
                                                    <td>
                                                        <textarea class="form-control default" order="1" id="food_sleep_pattern_any_medication" title="Food Sleep Pattern Any Medication" name="food_sleep_pattern_any_medication" {{ ($row['status']=="Submitted") || ($row['status']=="Completed") && $rolename !='IS Head'? "disabled" : "" }}>{{ $row['food_sleep_pattern_any_medication']}}</textarea>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Socialization / Emotional /communication/ Sensory </td>
                                                    <td>
                                                        <textarea class="form-control default" order="1" id="socialization_emotional_communication_sensory" title="Socialization Emotional Communication Sensory" name="socialization_emotional_communication_sensory" {{ ($row['status']=="Submitted") || ($row['status']=="Completed") && $rolename !='IS Head'? "disabled" : "" }}>{{ $row['socialization_emotional_communication_sensory']}}</textarea>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>ADLs - General Routine</td>
                                                    <td>
                                                        <textarea class="form-control default" order="1" id="adls_general_routine" title="ADLs - General Routine" name="adls_general_routine" {{ ($row['status']=="Submitted") || ($row['status']=="Completed") && $rolename !='IS Head'? "disabled" : "" }}>{{ $row['adls_general_routine']}}</textarea>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Strength / Interests</td>
                                                    <td>
                                                        <textarea class="form-control default" order="2" id="strength_interests" title="Strength Interests" name="strength_interests" {{ ($row['status']=="Submitted") || ($row['status']=="Completed") && $rolename !='IS Head'? "disabled" : "" }}>{{ $row['strength_interests']}}</textarea>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Current challenges / concerns</td>
                                                    <td>
                                                        <textarea class="form-control default" order="2" id="current_challenges_concerns" title="Current challenges concerns" name="current_challenges_concerns" {{ ($row['status']=="Submitted") || ($row['status']=="Completed") && $rolename !='IS Head'? "disabled" : "" }}>{{ $row['current_challenges_concerns']}}</textarea>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Other information</td>
                                                    <td>
                                                        <textarea class="form-control default" order="2" id="other_information" title="Other information" name="other_information" {{ ($row['status']=="Submitted") || ($row['status']=="Completed") && $rolename !='IS Head'? "disabled" : "" }}>{{ $row['other_information']}}</textarea>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Academics
                                                        <span class="tooltiptext1"><br>- His/her favorite<br>subjects<br>-His/Her least favorite subject / Why?<br>-Is s/he independent in doing homework?<br>-Time management skills<br>-General inputs received from teachers</span>
                                                    </td>
                                                    <td>
                                                        <textarea class="form-control default" order="2" id="academics" title="Academics" name="academics" {{ ($row['status']=="Submitted") || ($row['status']=="Completed") && $rolename !='IS Head'? "disabled" : "" }}>{{ $row['academics']}}</textarea>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Introspection<span class="tooltiptext1"><br>-Why are you seeking change? - in School / Intervention<br>-What is the top concern in your mind regarding your child? How quickly would you want to resolve it?<br>-What do you consider as a loss if your child does not receive the required/necessary support?</span></td>
                                                    <td><textarea class="form-control default" order="2" id="introspection" title="Introspection" name="introspection" {{ ($row['status']=="Submitted") || ($row['status']=="Completed") && $rolename !='IS Head'? "disabled" : "" }}>{{ $row['introspection']}}</textarea></td>
                                                </tr>
                                                <tr>
                                                    <td>Expectation from School<span class="tooltiptext1"><br>(Goal is to promote independence in the long run...until then do you expect?)<br>-Shadow support (1:1)<br>-Full / part time speed support<br>-Pull-outs<br>-After School Remedial support</span></td>
                                                    <td><textarea class="form-control default" order="3" id="expectation_from_school" title="Expectation from School" name="expectation_from_school" {{ ($row['status']=="Submitted") || ($row['status']=="Completed") && $rolename !='IS Head'? "disabled" : "" }}>{{ $row['expectation_from_school']}}</textarea></td>
                                                </tr>
                                                <tr>
                                                    <td>Expectation from Elina
                                                        <span class="tooltiptext1"><br>What kind of support do you expert from Elina?<br>How do you see Elina's Role as of today</span>
                                                    </td>
                                                    <td>
                                                        <textarea class="form-control default" order="3" id="expectation_from_elina" title="Expectation from Elina" name="expectation_from_elina" {{ ($row['status']=="Submitted") || ($row['status']=="Completed") && $rolename !='IS Head'? "disabled" : "" }}>{{ $row['expectation_from_elina']}}</textarea>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Notes</td>
                                                    <td><textarea class="form-control default" order="3" id="notes" title="Notes" name="notes" {{ ($row['status']=="Submitted") || ($row['status']=="Completed") && $rolename !='IS Head'? "disabled" : "" }}>{{ $row['notes']}}</textarea></td>
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
            <div class="row text-center" style="margin: 5px 0px 0px 0px;">
                <div class="col-md-12">

                    @if($role!='ishead')
                    @if( $row['status'] !="Submitted" && $row['status'] !="Completed")
                    <button type="submit" id="saved" class="btn btn-warning" name="type" value="Saved">Save</button>
                    <button type="submit" id="submit" class="btn btn-success" name="type" value="Submitted">Submit</button>
                    @endif
                    @elseif($role=='ishead')
                    <button type="submit" id="submit" class="btn btn-success" name="type" value="Completed">Submit</button>
                    @endif
                    <a type="button" href="{{ route('ovmmeetingcompleted') }}" class="btn btn-danger">Cancel</a>

                </div>
            </div>
        </form>
        @endforeach


    </div>
</div>
<script>
    $(document).ready(function() {
        var table = $('#myTable').DataTable({
            // "pagingType": "simple",
            "pageLength": 5,
            "dom": '<"top"f>rt<"bottom"ip>',
            "language": {
                "info": ""
            },
            "ordering": false,
        });
        var pageInfo = table.page.info();
        var totalPages = pageInfo.pages;

        if (pageInfo.page === totalPages - 1) {
            $('.next').hide();
        } else {
            $('.next').show();
        }

        if (pageInfo.page === 0) {
            $('.previous').hide();
        } else {
            $('.previous').show();
        }
    });
    $(document).on('click', '.paginate_button:not(.disabled)', function() {
        window.scroll({
            top: 0,
            left: 0,
            behavior: 'smooth'
        });
        var table = $('#myTable').DataTable();
        var pageInfo = table.page.info();
        var totalPages = pageInfo.pages;
        document.getElementById('currentPage').value = pageInfo.page;
        if (pageInfo.page === totalPages - 1) {
            $('.next').hide();
        } else {
            $('.next').show();
        }

        if (pageInfo.page === 0) {
            $('.previous').hide();
        } else {
            $('.previous').show();
        }
    });
</script>
<script type="text/javascript">
    function tabledestroy() {
        var table = $('#myTable').DataTable();
        table.destroy();
        $('#myTable').DataTable({
            "pageLength": -1,
            "ordering": false,
        });
    }

    function tablerestore() {
        var table = $('#myTable').DataTable();
        table.destroy();
        $('#myTable').DataTable({
            "pagingType": "simple",
            "pageLength": 5,
            "dom": '<"top"f>rt<"bottom"ip>',
            "language": {
                "info": ""
            },
            "ordering": false,
        });
    }
    $('#saved').click(function() {
        $("#saved").addClass("disable-click");
        $('.loader').show();
        tabledestroy();
        document.getElementById('ovmisc').submit();
    });

    $("#submit").click(function() {
        tabledestroy();
        const getAllFormElements = element => Array.from(element.elements).filter(tag => ["textarea"].includes(tag.tagName.toLowerCase()));
        const pageFormElements = getAllFormElements(document.getElementById("ovmisc"));
        $('.loader').show();
        // for (i = 0; i < pageFormElements.length; i++) {
        //     if (pageFormElements[i].value == "") {
        //         $('.loader').hide();
        //         let text = "Please Enter Field ";
        //         text += pageFormElements[i].title;
        //         swal.fire("Warning", text, "warning").then(function(result) {
        //             if (result.isConfirmed) {
        //                 pageFormElements[i].classList.add('error');
        //                 var errorElement = $(".error");
        //                 var tdElement = errorElement.parentsUntil("tbody", "tr").last();

        //                 tablerestore();
        //                 var table = $('#myTable').DataTable();
        //                 var pageNo = pageFormElements[i].getAttribute('order');
        //                 pageNo = Number(pageNo);
        //                 table.page(pageNo).draw('page');

        //                 $('html, body').animate({
        //                     scrollTop: tdElement.offset().top
        //                 }, 'slow');
        //                 pageFormElements[i].focus();
        //             }
        //         });


        //         return false;
        //     } 

        // }
    });
</script>
<script>
    $(document).ready(function() {
        var pageNo = $('#session_page').val();
        if (pageNo != undefined && pageNo != null) {
            var table = $('#myTable').DataTable();
            pageNo = Number(pageNo);
            table.page(pageNo).draw('page');
        }
    });
</script>
@endsection