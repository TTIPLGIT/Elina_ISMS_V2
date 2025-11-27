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
        flex-wrap: nowrap;
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

    .form-control:disabled,
    .form-control[readonly] {
        background-color: #e9ecef !important;
    }

    textarea {
        resize: none;
    }
    .tooltip1 {
  position: relative;
  display: inline-block;
  margin: 0 0 0 5px;
}

.tooltip1 .tooltiptext1 {
  visibility: hidden;
  width: 300px;
  background-color: #555;
  color: #fff;
  text-align: center;
  border-radius: 6px;
  padding: 5px 0;
  position: absolute;
  z-index: 1;
  bottom: 125%;
  left: 50%;
  margin-left: -150px;
  opacity: 0;
  transition: opacity 0.3s;
}

.tooltip1 .tooltiptext1::after {
  content: "";
  position: absolute;
  top: 100%;
  left: 50%;
  margin-left: -5px;
  border-width: 5px;
  border-style: solid;
  border-color: #555 transparent transparent transparent;
}

.tooltip1:hover .tooltiptext1 {
  visibility: visible;
  opacity: 1;
}
</style>

<div class="main-content">

    <!-- Main Content -->
    <section class="section">

        {{ Breadcrumbs::render('ovmcompleted') }}
        <div class="section-body mt-1">
            <h5 class="text-center" style="color:darkblue">OVM Meeting Summary</h5>
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            @foreach($rows as $key=>$row)
                            <form action="{{route('ovmiscfeedbackstore',$row['ovm_isc_report_id'])}}" method="POST" id="ovmisc" name="ovmisc" enctype="multipart/form-data">
                                {{ csrf_field() }}
                                @method('PUT')


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
                                                <input class="form-control"  readonly type="url" id="video_link" name="video_link" autocomplete="off" value="{{$row['video_link1']}}">
                                                <a class="btn btn-link"  title="show" target="_blank" href="{{$row['video_link1']}}"><i class="fas fa-eye" style="color:green"></i></a>
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





                                <div class="tile" id="tile-1" style="margin-top:10px !important; margin-bottom:15px !important;">

                                    <!-- Nav tabs -->

                                    <ul class="nav nav-tabs nav-justified " id="tabs" role="tablist">

                                        <li class="nav-items navv" class="active" style="flex-basis: 1 !important;">
                                            <a class="nav-link  " id="home-tab" name="tab1" data-toggle="tab" role="tab" aria-controls="home" aria-selected="true"><b>Family Info</b> <input type="checkbox" class="checkg" id="profile" name="nationality" value="0" onchange="submitval(this)" readonly style="background-color:solid green !important; color:green !important; visibility:hidden !important; ">
                                                <div class="check"></div>
                                            </a>

                                        </li>
                                        <li class="nav-items navv" class="active" style="flex-basis: 1 !important;">
                                            <a class="nav-link  " id="home-tab" name="tab2" data-toggle="tab" role="tab" aria-controls="home" aria-selected="true"><b>Academics</b> <input type="checkbox" class="checkg" id="profile" name="nationality" value="0" onchange="submitval(this)" readonly style="background-color:solid green !important; color:green !important; visibility:hidden !important; ">
                                                <div class="check"></div>
                                            </a>

                                        </li>
                                        <li class="nav-items navv" class="active" style="flex-basis: 1 !important;">
                                            <a class="nav-link  " id="home-tab" name="tab3" data-toggle="tab" role="tab" aria-controls="home" aria-selected="true"></i><b>Assessment</b> <input type="checkbox" class="checkg" id="profile" name="nationality" value="0" onchange="submitval(this)" readonly style="background-color:solid green !important; color:green !important; visibility:hidden !important; ">
                                                <div class="check"></div>
                                            </a>

                                        </li>
                                        <li class="nav-items navv" class="active" style="flex-basis: 1 !important;">
                                            <a class="nav-link  " id="home-tab" name="tab4" data-toggle="tab" role="tab" aria-controls="home" aria-selected="true"></i><b>Strength & Challenges</b> <input type="checkbox" class="checkg" id="profile" name="nationality" value="0" onchange="submitval(this)" readonly style="background-color:solid green !important; color:green !important; visibility:hidden !important; ">
                                                <div class="check"></div>
                                            </a>

                                        </li>
                                        <li class="nav-items navv" class="active" style="flex-basis: 1 !important;">
                                            <a class="nav-link  " id="home-tab" name="tab5" data-toggle="tab" role="tab" aria-controls="home" aria-selected="true"><b>Introspection & Expectations</b> <input type="checkbox" class="checkg" id="profile" name="nationality" value="0" onchange="submitval(this)" readonly style="background-color:solid green !important; color:green !important; visibility:hidden !important; ">
                                                <div class="check"></div>
                                            </a>

                                        </li>

                                    </ul>
                                </div>
                                <!-- Tab panes -->


                                <div id="content">
                                    <div id="tab1" title="Family Info">
                                        <section class="section">
                                            <div class="section-body mt-1">

                                                <input type="hidden" class="form-control" id="user_id" name="user_id" value="">
                                                <input type="hidden" class="form-control" id="user_details" name="user_details" value="general">

                                                <div class="row">

                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label>Primary caretaker:<span class="error-star" style="color:red;">*</span></label><div class="tooltip1"><i class="fa fa-info-circle" aria-hidden="true"></i><span class="tooltiptext1">Name of parents<br>Are both parents present?<br>Profession (we don’t ask it explicitly but if it comes in the discussion)</span></div>
                                                            @if($row['primary_caretaker'] != '')
                                                            <textarea class="form-control default" id="primary_caretaker" title="Primary Caretaker" name="primary_caretaker" {{ ($row['status']=="Submitted") || ($row['status']=="Completed") && $rolename !='IS Head'? "disabled" : "" }}>{{ $row['primary_caretaker']}}</textarea>
                                                            @else
                                                            <textarea class="form-control default" id="primary_caretaker" title="Primary Caretaker" name="primary_caretaker" {{ ($row['status']=="Submitted") || ($row['status']=="Completed") && $rolename !='IS Head'? "disabled" : "" }}>{{ $primary_caretaker }}</textarea>
                                                            @endif
                                                            <!-- placeholder="Name of parents&#10;Are both parents present?&#10;Profession (we don’t ask it explicitly but if it comes in the discussion)" -->
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label>Nuclear/joint family:<span class="error-star" style="color:red;">*</span></label><div class="tooltip1"><i class="fa fa-info-circle" aria-hidden="true"></i><span class="tooltiptext1">-Siblings?<br>-Nuclear/joint family?<br>- Primary caretaker?<br>-Any other important info (single parent, history of illness in family etc)</span></div>
                                                            <textarea class="form-control default" id="family_type" title="Family Type" name="family_type" {{ ($row['status']=="Submitted") || ($row['status']=="Completed") && $rolename !='IS Head'? "disabled" : "" }}>{{ $row['family_type']}}</textarea>
                                                        </div>
                                                    </div>


                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label>Siblings:<span class="error-star" style="color:red;">*</span></label>
                                                            <textarea class="form-control default" id="siblings" title="Siblings" name="siblings" {{ ($row['status']=="Submitted") || ($row['status']=="Completed") && $rolename !='IS Head'? "disabled" : "" }}>{{ $row['siblings']}}</textarea>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label>Parent's Profession<span class="error-star" style="color:red;">*</span></label>
                                                            <textarea class="form-control default" id="profession_of_the_parents" title="Profession of the parents" name="profession_of_the_parents" {{ ($row['status']=="Submitted") || ($row['status']=="Completed") && $rolename !='IS Head'? "disabled" : "" }}>{{ $row['profession_of_the_parents']}}</textarea>
                                                        </div>
                                                    </div>
                                                </div>







                                            </div>

                                        </section>

                                    </div>
                                    <div id="tab2" title="Academics">
                                        <section class="section">
                                            <div class="section-body mt-1">

                                                <input type="hidden" class="form-control" id="user_id" name="user_id" value="">
                                                <input type="hidden" class="form-control" id="user_details" name="user_details" value="general">

                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label>Academics:<span class="error-star" style="color:red;">*</span></label><div class="tooltip1"><i class="fa fa-info-circle" aria-hidden="true"></i><span class="tooltiptext1">- His/her favourite<br>subjects<br>-His/Her least favourite subject / Why?<br>-Is s/he independent in doing homework?<br>-Time management skills<br>-General inputs received from teachers</span></div>
                                                            <textarea class="form-control default" id="academics" title="Academics" name="academics" {{ ($row['status']=="Submitted") || ($row['status']=="Completed") && $rolename !='IS Head'? "disabled" : "" }}>{{ $row['academics']}}</textarea>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label>Developmental Milestones – Motor / Lang / Speech:<span class="error-star" style="color:red;">*</span></label>
                                                            <textarea class="form-control default" id="developmental_milestones_motor_lang_speech" title="Developmental Milestones Motor Lang Speech" name="developmental_milestones_motor_lang_speech" {{ ($row['status']=="Submitted") || ($row['status']=="Completed") && $rolename !='IS Head'? "disabled" : "" }}>{{ $row['developmental_milestones_motor_lang_speech']}}</textarea>
                                                        </div>
                                                    </div>


                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label> Schools attended / School she/he currently in / Grade:<span class="error-star" style="color:red;">*</span></label>
                                                            <textarea class="form-control default" id="schools_attended_school_currently_grade" title="Schools Attended School Currently Grade" name="schools_attended_school_currently_grade" {{ ($row['status']=="Submitted") || ($row['status']=="Completed") && $rolename !='IS Head'? "disabled" : "" }}>{{ $row['schools_attended_school_currently_grade']}}</textarea>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label>Previous interventions given / Current intervention:<span class="error-star" style="color:red;">*</span></label>
                                                            <textarea class="form-control default" id="previous_interventions_given_current_intervention" title="Previous Interventions Given Current Intervention" name="previous_interventions_given_current_intervention" {{ ($row['status']=="Submitted") || ($row['status']=="Completed") && $rolename !='IS Head'? "disabled" : "" }}>{{ $row['previous_interventions_given_current_intervention']}}</textarea>
                                                        </div>
                                                    </div>
                                                </div>







                                            </div>

                                        </section>

                                    </div>
                                    <div id="tab3" title="Assements">
                                        <section class="section">
                                            <div class="section-body mt-1">

                                                <input type="hidden" class="form-control" id="user_id" name="user_id" value="">
                                                <input type="hidden" class="form-control" id="user_details" name="user_details" value="general">

                                                <div class="row">

                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label> Any assessment done:<span class="error-star" style="color:red;">*</span></label>
                                                            <textarea class="form-control default" id="any_assessment_done" title="Any Assessment Done" name="any_assessment_done" {{ ($row['status']=="Submitted") || ($row['status']=="Completed") && $rolename !='IS Head'? "disabled" : "" }}>{{ $row['any_assessment_done']}}</textarea>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label>Food / Sleep pattern / Any medication?:<span class="error-star" style="color:red;">*</span></label>
                                                            <textarea class="form-control default" id="food_sleep_pattern_any_medication" title="Food Sleep Pattern Any Medication" name="food_sleep_pattern_any_medication" {{ ($row['status']=="Submitted") || ($row['status']=="Completed") && $rolename !='IS Head'? "disabled" : "" }}>{{ $row['food_sleep_pattern_any_medication']}}</textarea>
                                                        </div>
                                                    </div>


                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label>Socialization / Emotional /communication/ Sensory:<span class="error-star" style="color:red;">*</span></label>
                                                            <textarea class="form-control default" id="socialization_emotional_communication_sensory" title="Socialization Emotional Communication Sensory" name="socialization_emotional_communication_sensory" {{ ($row['status']=="Submitted") || ($row['status']=="Completed") && $rolename !='IS Head'? "disabled" : "" }}>{{ $row['socialization_emotional_communication_sensory']}}</textarea>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label>ADLs - General Routine:<span class="error-star" style="color:red;">*</span></label>
                                                            <textarea class="form-control default" id="adls_general_routine" title="ADLs - General Routine" name="adls_general_routine" {{ ($row['status']=="Submitted") || ($row['status']=="Completed") && $rolename !='IS Head'? "disabled" : "" }}>{{ $row['adls_general_routine']}}</textarea>
                                                        </div>
                                                    </div>
                                                </div>



                                            </div>

                                        </section>

                                    </div>

                                    <div id="tab4" title="Strength & Challenges">
                                        <section class="section">
                                            <div class="section-body mt-1">

                                                <input type="hidden" class="form-control" id="user_id" name="user_id" value="">
                                                <input type="hidden" class="form-control" id="user_details" name="user_details" value="general">






                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label> Birth History:<span class="error-star" style="color:red;">*</span></label>
                                                            <textarea class="form-control default" id="birth_history" title="Birth History" name="birth_history" {{ ($row['status']=="Submitted") || ($row['status']=="Completed") && $rolename !='IS Head'? "disabled" : "" }}>{{ $row['birth_history']}}</textarea>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label>Strength / Interests:<span class="error-star" style="color:red;">*</span></label>
                                                            <textarea class="form-control default" id="strength_interests" title="Strength Interests" name="strength_interests" {{ ($row['status']=="Submitted") || ($row['status']=="Completed") && $rolename !='IS Head'? "disabled" : "" }}>{{ $row['strength_interests']}}</textarea>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label>Current challenges / concerns:<span class="error-star" style="color:red;">*</span></label>
                                                            <textarea class="form-control default" id="current_challenges_concerns" title="Current challenges concerns" name="current_challenges_concerns" {{ ($row['status']=="Submitted") || ($row['status']=="Completed") && $rolename !='IS Head'? "disabled" : "" }}>{{ $row['current_challenges_concerns']}}</textarea>
                                                        </div>
                                                    </div>


                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label>Other information:<span class="error-star" style="color:red;">*</span></label>
                                                            <textarea class="form-control default" id="other_information" title="Other information" name="other_information" {{ ($row['status']=="Submitted") || ($row['status']=="Completed") && $rolename !='IS Head'? "disabled" : "" }}>{{ $row['other_information']}}</textarea>
                                                        </div>
                                                    </div>

                                                </div>

                                        </section>

                                    </div>
                                    <div id="tab5" title="Introspection & Expectations">
                                        <section class="section">
                                            <div class="section-body mt-1">

                                                <input type="hidden" class="form-control" id="user_id" name="user_id" value="">
                                                <input type="hidden" class="form-control" id="user_details" name="user_details" value="general">

                                                <div class="row">

                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label>Introspection:<span class="error-star" style="color:red;">*</span></label><div class="tooltip1"><i class="fa fa-info-circle" aria-hidden="true"></i><span class="tooltiptext1">-Why are you seeking change? - in School / Intervention<br>-What is the top concern in your mind regarding your child? How quickly would you want to resolve it?<br>-What do you consider as a loss if your child does not receive the required/necessary support?</span></div>
                                                            <textarea class="form-control default" id="introspection" title="Introspection" name="introspection" {{ ($row['status']=="Submitted") || ($row['status']=="Completed") && $rolename !='IS Head'? "disabled" : "" }}>{{ $row['introspection']}}</textarea>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label>Expectation from School:<span class="error-star" style="color:red;">*</span></label><div class="tooltip1"><i class="fa fa-info-circle" aria-hidden="true"></i><span class="tooltiptext1">(Goal is to promote independence in the long run...until then do you expect?)<br>-Shadow support (1:1)<br>-Full / part time sp.ed support<br>-Pull-outs<br>-After School Remedial suppor</span></div>
                                                            <textarea class="form-control default" id="expectation_from_school" title="Expectation from School" name="expectation_from_school" {{ ($row['status']=="Submitted") || ($row['status']=="Completed") && $rolename !='IS Head'? "disabled" : "" }}>{{ $row['expectation_from_school']}}</textarea>
                                                        </div>
                                                    </div>


                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label> Expectation from Elina:<span class="error-star" style="color:red;">*</span></label><div class="tooltip1"><i class="fa fa-info-circle" aria-hidden="true"></i><span class="tooltiptext1">What kind of support do you expert from Elina?<br>How do you see Elina's Role as of Today</span></div>
                                                            <textarea class="form-control default" id="expectation_from_elina" title="Expectation from Elina" name="expectation_from_elina" {{ ($row['status']=="Submitted") || ($row['status']=="Completed") && $rolename !='IS Head'? "disabled" : "" }}>{{ $row['expectation_from_elina']}}</textarea>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label>Notes:<span class="error-star" style="color:red;">*</span></label>
                                                            <textarea class="form-control default" id="notes" title="Notes" name="notes" {{ ($row['status']=="Submitted") || ($row['status']=="Completed") && $rolename !='IS Head'? "disabled" : "" }}>{{ $row['notes']}}</textarea>
                                                        </div>
                                                    </div>
                                                </div>




                                            </div>

                                        </section>

                                    </div>
                                </div>
                                <div class="row text-center">
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
                            </div>
                        </div>
                    </div>
                </div>

                </form>
                @endforeach


            </div>
        </div>




        <br>

</div>
</section>
</div>


<script type="text/javascript">
      
 $('#saved').click(function(){
        $("#saved").addClass("disable-click");
 });

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
        let role = "<?php echo $role ?>";
        document.getElementById('saved').value = (role === "ishead") ? 'Submitted' : 'Saved';

    });

    $("#submit").click(function() {


        const getAllFormElements = element => Array.from(element.elements).filter(tag => ["textarea"].includes(tag.tagName.toLowerCase()));
        const pageFormElements = getAllFormElements(document.getElementById("ovmisc"));
        for (i = 0; i < pageFormElements.length; i++) {
            if (pageFormElements[i].value == "") {
                let text = "Please Enter Field ";
                text += pageFormElements[i].title;
                let tab = " in ";
                tab += pageFormElements[i].parentElement.parentElement.parentElement.parentElement.parentElement.parentElement.title;
                tab += " Section"
                text += tab;
                swal.fire("Warning", text, "warning");
                return false;
            }else{
                $("#submit").addClass("disable-click");
            }
        }
    });
    tinymce.init({
        selector: 'textarea#description',
        height: 180,
        menubar: false,
        branding: false,
        plugins: [
            'advlist autolink lists link image charmap print preview anchor',
            'searchreplace visualblocks code fullscreen',
            'insertdatetime media table paste code help wordcount'
        ],
        toolbar: 'undo redo | formatselect | ' +
            'bold italic backcolor | alignleft aligncenter ' +
            'alignright alignjustify | bullist numlist outdent indent | ' +
            'removeformat | help',
        content_style: 'body { font-family:Helvetica,Arial,sans-serif; font-size:14px }'
    });
</script>



<script type="text/javascript">
    const statusfn = (event) => {
        let status = event.target.value;
        let currenetstatus = document.getElementById("resch");
        currenetstatus.style.display = (status === "Rescheduled") ? "inline-block" : "none";
        //...
    }
</script>





















@endsection