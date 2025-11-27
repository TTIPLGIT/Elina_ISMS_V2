@extends('layouts.adminnav')

@section('content')
<style>
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
        background: inherit;
        /* background-image: linear-gradient(to bottom, #1c92d2, #f2fcfe); */
        box-shadow: 2px 2px 2px rgba(0, 0, 0, .4);
        transform: skew(10deg);
        border-radius: 0 5px 0 0;
    }

    #tabs #addition-tab::after {
        content: '';
        position: absolute;
        z-index: 1;
        top: 0;
        right: -.5em;
        bottom: 0;
        width: 1em;
        background: #78a6c9;
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

    body,
    .main-footer {
        background: white !important;
    }

    #content {
        background: #e9f8ff;
        padding: 2em;
        position: relative;
        z-index: 1;
        border-radius: 0 5px 5px 5px;
        /* box-shadow: 2px 2px 4px rgba(0, 0, 0, 0.15);
        border-style: outset; */
        box-shadow: -4px 4px 4px rgb(0 0 0 / 50%), inset 1px 0px 0px rgb(255 255 255 / 40%);

    }
    .navv {
    -ms-flex-preferred-size: 0;
    flex-basis: none !important;
    -ms-flex-positive: 1;
    -webkit-box-flex: 1;
    flex-grow: 0 !important;
    }
    .switch-field {
	display: flex;
	
	
}

.switch-field input {
	position: absolute !important;
	clip: rect(0, 0, 0, 0);
	height: 1px;
	width: 1px;
	border: 0;
	overflow: hidden;
}

.switch-field label {
	background-color: #e4e4e4;
	color: rgba(0, 0, 0, 0.6);
	font-size: 14px;
	line-height: 1;
	text-align: center;
	padding: 8px 16px;
	margin-right: -1px;
	border: 1px solid rgba(0, 0, 0, 0.2);
	box-shadow: inset 0 1px 3px rgba(0, 0, 0, 0.3), 0 1px rgba(255, 255, 255, 0.1);
	transition: all 0.1s ease-in-out;
}

.switch-field label:hover {
	cursor: pointer;
}

.switch-field input:checked + label {
	background-color: #a5dc86;
	box-shadow: none;
}

.switch-field label:first-of-type {
	border-radius: 4px 0 0 4px;
}

.switch-field label:last-of-type {
	border-radius: 0 4px 4px 0;
}
.ad{
   background-color: #2725a4 !important ;
}
</style>
<div class="main-content">
    <div class="row justify-content-center">
        <div class="col-lg-12 col-md-12">
            <div class="" style="height:100%; padding: 15px">

           
                    <form  action="{{ route('Registration.store') }}" method="POST" id="educreate_form" enctype="multipart/form-data" >
                            @csrf

                            <input type="hidden" class="form-control" required id="user_details" name="user_details" value="educate">
                            <div class="tile" id="tile-1" style="margin-top:10px !important;">

                                <!-- Nav tabs -->
                            
                                <ul class="nav nav-tabs nav-justified " id="tabs" role="tablist">
                                
                                    <li class="nav-items navv" class="active" style="flex-basis: 1 !important;">
                                        <a class="nav-link  " id="home-tab"  name="tab1" data-toggle="tab" role="tab" aria-controls="home" aria-selected="true" ><i class="fa fa-home"></i><b> Diploma</b> <input type="checkbox" class="checkg" id="profile" name="nationality" value="0" onchange="submitval(this)" readonly style="background-color:solid green !important; color:green !important; visibility:hidden !important; "> <div class="check"></div> </a>

                                    </li>
                                    <li class="nav-items navv" class="" style="flex-basis: 1 !important;" >
                                        <a class="nav-link" id="addition-tab" name="tab2" data-toggle="tab" role="tab" aria-controls="addition" aria-selected="false"   style=" background: #78a6c9 !important;"  ><i class="fas fa-map-signs"></i> <b>Under Graduation</b> <input type="checkbox" class="checkg" id="adddetails" name="nationality" value="0" onchange="submitval(this)" style="background-color:solid green !important; color:green !important; visibility:hidden !important; "></a>

                                    </li>
                                    <li class="nav-items navv" class="" style="flex-basis: 1 !important;" >
                                        <a class="nav-link" id="pg-tab" name="tab3" data-toggle="tab" role="tab" aria-controls="pg" aria-selected="false"   style=" background: #78a6c9 !important;"  ><i class="fas fa-map-signs"></i> <b>Post Graduatio</b> <input type="checkbox" class="checkg" id="adddetails" name="nationality" value="0" onchange="submitval(this)" style="background-color:solid green !important; color:green !important; visibility:hidden !important; "></a>

                                    </li>
                                

                                </ul>
                            </div>
                            <!-- Tab panes -->

                            <div id="content">
                                    <div id="tab1">

                                                <section class="section">
                                                    <div class="section-body mt-1">
                                                    
                                                    <div id="dynamic_fielddip"></div>
                                                    <button type="button" name="adddip" id="adddip" class="btn btn-primary ad" ><i class="fas fa-plus" style="color:white"></i></button>

                                                    
                                                        <input type="hidden" name="attachment_countdip" id="attachment_countdip" value="0">
                                                    </div>
                                                    <div style="display:flex; justify-content:center; width:100%">

                                                        <a type="button" class="btn btn-labeled btn-info" onclick="DoActions('tab2');" title="next" style="background: #4d94ff !important; border-color:#4d94ff !important; color:white !important">
                                                                <span class="btn-label" style="font-size:13px !important;"><i class="fa fa-arrow-right"></i></span>Next</a>
                                                            
                                                    </div>

                                                </section>
                                            
                                    </div>
                                <div id="tab2">

                                        <section class="section">
                                            <div class="section-body mt-1">
                                            <div id="dynamic_fieldug"></div> 
                                            <button type="button" name="addug" id="addug" class="btn btn-primary ad" ><i class="fas fa-plus" style="color:white"></i></button>

                                                </div>
                                                <input type="hidden" name="attachment_countug" id="attachment_countug" value="0">

                                        </section>
                                            <div style="display:flex; justify-content:center; width:100%">
                                            <a type="button" class="btn btn-labeled btn-info" onclick="DoActions('tab1');" title="next" style="background: red !important; border-color:red !important; color:white !important; margin-top:10px !important;">
                                                <span class="btn-label" style="font-size:13px !important;"><i class="fa fa-arrow-left"></i></span>Previous</a>
                                        <a type="button" class="btn btn-labeled btn-info" onclick="DoActions('tab3');" title="next" style="background: #4d94ff !important; border-color:#4d94ff !important; color:white !important;  margin-top:10px !important;  margin-left:10px !important;">
                                                <span class="btn-label" style="font-size:13px !important;"><i class="fa fa-arrow-right"></i></span>Next</a>
                                            </div>
                                </div>
                                <div id="tab3">
                                    <section class="section">


                                        <div class="section-body mt-0">

                                        <div id="dynamic_fieldpg"></div>
                                        <button type="button" name="addpg" id="addpg" class="btn btn-primary ad" ><i class="fas fa-plus" style="color:white"></i></button>
                                        <input type="hidden" name="attachment_countpg" id="attachment_countpg" value="0">
                                        <!-- final submit button -->




                                        <!-- final submit button -->
                                

                                        <div class="col-lg-12" id="register">

                                            

                                            <div class="col-md-12 text-center">

                                                <input type="hidden" class="form-control" required id="reg_status" name="reg_status" value="">
                                                <input type="hidden" class="form-control" required id="user_id" name="user_id" value="">
                                                <input type="hidden" class="form-control" name="registration_status" value="Registered">



                                                    
                                                <a type="button" class="btn btn-labeled btn-info" onclick="DoActions('tab2');" title="next" style="background: red !important; border-color:red !important; color:white !important">
                                                <span class="btn-label" style="font-size:13px !important;"><i class="fa fa-arrow-left"></i></span>Previous</a>



                                            </div>
                                        </div>


                                        <div class="col-lg-12" id="registr">

                                        

                                            <div class="col-md-12 text-center">

                                                <input type="hidden" class="form-control" required id="reg_status" name="reg_status" value="">
                                                <input type="hidden" class="form-control" required id="user_id" name="user_id" value="">
                                                <input type="hidden" class="form-control" name="registration_status" value="Registered">
                                            
                                       

                                            </div>
                                            
                                        </div>
                                        

                                        <div class="col-md-12 text-center">

                                            <input type="hidden" class="form-control" required id="reg_status" name="reg_status" value="">
                                            <input type="hidden" class="form-control" required id="user_id" name="user_id" value="">
                                            <input type="hidden" class="form-control" name="registration_status" value="Registered">




                                        



                                        </div>
                                        </div>

                                                    
                                    </section>


                                </div>
                            
                            </div>
                                <div style="display:flex; justify-content:center; width:100%">

                                                    <a type="button" class="btn btn-labeled btn-info" href="{{url('Registration')}}" title="next" style="background: red !important; border-color:red !important; color:white !important; margin-top:15px !important;">
                                                                    <span class="btn-label" style="font-size:13px !important;"><i class="fa fa-arrow-left"></i></span>Back</a>
                                                                    <button type="submit" id="registerbutton"  class="btn btn-labeled btn-info" title="Submit" style="background: green !important; border-color:green !important; color:white !important; margin-top:15px !important; margin-left: 15px;">
                                                <span class="btn-label" style="font-size:13px !important;"><i class="fa fa-check"></i></span>Save</button>

                                </div>
                                <div style="display:flex; justify-content: center; margin-top:4px">
                                <label style="color:black"><i><b>Please Click Submit to Complete Valuer/Surveyor/Assessor Registration </b></i></label><br>
                                </div>
                    </form>
            </div>
        </div>
    </div>
</div>
 
  <script src="https://code.jquery.com/jquery-1.7.2.min.js"></script>
<script type="application/javascript">
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
    });

        function DoActions(id) {

            $("#content").find("[id^='tab']").hide(); // Hide all content
        $("#tabs li").removeClass("active"); //Reset id's
        $("#tabs a").removeClass("active"); //Reset id's
        $("a[name='" + id + "']").parent().addClass("active");
        $('#' + (id)).fadeIn(); // Show content for the current tab

        }

        function submit() {

            document.getElementById('educreate_form').submit();
        }
        var user_id = "<?php echo $user_id; ?>"
    document.getElementById('user_id').value = user_id;
    var i = 0;
    var j = 0;
    var k = 0;
    var l = 0;
    $("#addug").click(function(){
     
      // $('#dynamic_field').append('<div id="rowphd"><div class=""><input type="text" name="name[]" placeholder="Enter your Name" class="form-control name_list"/></td><td><input type="text" name="email[]" placeholder="Enter your Email" class="form-control name_email"/></td><td></div>');  
        $('#dynamic_fieldug').append('<section class="input-box ug" name="a" id="rowug"><div class="educationug"> <div class="row"> <div class="col-md-4"><div class="form-group"><label>Graduation:<span class="error-star" style="color:red;">*</span></label><input type="text" class="form-control gradug" required id="graduationug" name="ug['+i+'][graduation]" value="Under Graduate" readonly> </div></div><div class="col-md-4"><div class="form-group"><label>College Name:<span class="error-star" style="color:red;">*</span></label> <input type="text" class="form-control clgug" required id="college_nameug" name="ug['+i+'][college_name]"></div> </div> <div class="col-md-4"> <div class="form-group"> <label>University Name:<span class="error-star" style="color:red;">*</span></label> <input type="text" class="form-control uniug" required id="university_nameug" name="ug['+i+'][university_name]"> </div> </div> </div> <div class="row"> <div class="col-md-4"> <div class="form-group"> <label> Course Name:<span class="error-star" style="color:red;">*</span></label> <select class="form-control crsug" required id="course_nameug" name="ug['+i+'][course_name]"> <option value="0">Select-Course</option> <option value="civil">civil</option> <option value="architect">architect</option> <option value="townplanning">townplanning</option> </select> </div> </div> <!-- </div> <div class="row"> --> <div class="col-md-4"> <div class="form-group"> <label> Year of Passing <span class="error-star" style="color:red;">*</span></label> <input type="month" class="form-control ypug" maxlength="18" required id="yopug" name="ug['+i+'][yop]"> </div> </div> <div class="col-md-4"> <div class="form-group"> <label> Marks %:<span class="error-star" style="color:red;">*</span></label> <input type="text" class="form-control mkug" required id="m_percentageug" name="ug['+i+'][m_percentage]"> </div> </div> </div> <div class="row"> <h style="color:black"><b>Supporting Documents:</b></h></div><div class="row"> <div class="col-md-4"> <div class="form-group"> <label> Consolidate Marksheet: <span class="error-star" style="color:red;">*</span></label> <input type="file" class="form-control ccug" required id="consolidate_markug" name="ug['+i+'][consolidate_mark]"> </div> </div> <!-- </div> <div class="row"> --> <div class="col-md-4"> <div class="form-group"> <label> Graduation Certificate:<span class="error-star" style="color:red;">*</span></label> <input type="file" class="form-control gcug" required id="garduation_certificateug" name="ug['+i+'][garduation_certificate]"> </div> </div> <div><button style="margin-top:30px" type="button" name="remove" id="ug" value='+i+' class="btn btn-danger btn_removeug">X</button></div> </div></div></section>'); 
        i++;
        $("#attachment_countug").val(i);
      
    });
    $("#addpg").click(function(){
     
      // $('#dynamic_field').append('<div id="rowpg"><div class=""><input type="text" name="name[]" placeholder="Enter your Name" class="form-control name_list"/></td><td><input type="text" name="email[]" placeholder="Enter your Email" class="form-control name_email"/></td><td></div>');  
        $('#dynamic_fieldpg').append('<section class="input-box pg" id="rowpg"><div class="educationpg"> <div class="row"> <div class="col-md-4"><div class="form-group"><label>Graduation:<span class="error-star" style="color:red;">*</span></label><input type="text" class="form-control gradpg" required id="graduationpg" name="pg['+j+'][graduation]" value="Post Graduation" readonly> </div></div><div class="col-md-4"><div class="form-group"><label>College Name:<span class="error-star" style="color:red;">*</span></label> <input type="text" class="form-control clgpg" required id="college_namepg" name="pg['+j+'][college_name]"></div> </div> <div class="col-md-4"> <div class="form-group"> <label>University Name:<span class="error-star" style="color:red;">*</span></label> <input type="text" class="form-control unipg" required id="university_namepg" name="pg['+j+'][university_name]"> </div> </div> </div> <div class="row"> <div class="col-md-4"> <div class="form-group"> <label> Course Name:<span class="error-star" style="color:red;">*</span></label> <select class="form-control crspg" required id="course_namepg" name="pg['+j+'][course_name]"> <option value="0">Select-Course</option> <option value="civil">civil</option> <option value="architect">architect</option> <option value="townplanning">townplanning</option> </select> </div> </div> <!-- </div> <div class="row"> --> <div class="col-md-4"> <div class="form-group"> <label> Year of Passing <span class="error-star" style="color:red;">*</span></label> <input type="month" class="form-control yppg" maxlength="18" required id="yoppg" name="pg['+j+'][yop]"> </div> </div> <div class="col-md-4"> <div class="form-group"> <label> Marks %:<span class="error-star" style="color:red;">*</span></label> <input type="text" class="form-control mkpg" required id="m_percentagepg" name="pg['+j+'][m_percentage]"> </div> </div> </div> <div class="row"> <h style="color:black"><b>Supporting Documents:</b></h></div><div class="row"> <div class="col-md-4"> <div class="form-group"> <label> Consolidate Marksheet: <span class="error-star" style="color:red;">*</span></label> <input type="file" class="form-control ccpg" required id="consolidate_markpg" name="pg['+j+'][consolidate_mark]"> </div> </div> <!-- </div> <div class="row"> --> <div class="col-md-4"> <div class="form-group"> <label> Graduation Certificate:<span class="error-star" style="color:red;">*</span></label> <input type="file" class="form-control gcpg" required id="garduation_certificatepg" name="pg['+j+'][garduation_certificate]"> </div> </div> <div><button style="margin-top:30px" type="button" name="remove" id="pg" value='+j+' class="btn btn-danger btn_removepg">X</button></div> </div></div></section>'); 
        j++;
        $("#attachment_countpg").val(j);
    });
    $("#adddip").click(function(){
      
      // $('#dynamic_field').append('<div id="rowdip"><div class=""><input type="text" name="name[]" placeholder="Enter your Name" class="form-control name_list"/></td><td><input type="text" name="email[]" placeholder="Enter your Email" class="form-control name_email"/></td><td></div>');  
        $('#dynamic_fielddip').append('<section class="input-box dip" id="rowdip"><div class="educationdip"> <div class="row"> <div class="col-md-4"><div class="form-group"><label>Diploma:<span class="error-star" style="color:red;">*</span></label><input type="text" class="form-control graddip" required id="graduationdip" name="dip['+k+'][graduation]" value="Diploma" readonly> </div></div><div class="col-md-4"><div class="form-group"><label>College Name:<span class="error-star" style="color:red;">*</span></label> <input type="text" class="form-control clgdip" required id="college_namedip" name="dip['+k+'][college_name]"></div> </div> <div class="col-md-4"> <div class="form-group"> <label>University Name:<span class="error-star" style="color:red;">*</span></label> <input type="text" class="form-control unidip" required id="university_namedip" name="dip['+k+'][university_name]"> </div> </div> </div> <div class="row"> <div class="col-md-4"> <div class="form-group"> <label> Diploma Name:<span class="error-star" style="color:red;">*</span></label> <select class="form-control crsdip" required id="course_namedip" name="dip['+k+'][course_name]"> <option value="0">Select-Diploma</option> <option value="civil">civil</option> <option value="architect">architect</option> <option value="townplanning">townplanning</option> </select> </div> </div> <!-- </div> <div class="row"> --> <div class="col-md-4"> <div class="form-group"> <label> Year of Passing <span class="error-star" style="color:red;">*</span></label> <input type="month" class="form-control ypdip" maxlength="18" required id="yopdip" name="dip['+k+'][yop]"> </div> </div> <div class="col-md-4"> <div class="form-group"> <label> Marks %:<span class="error-star" style="color:red;">*</span></label> <input type="text" class="form-control mkdip" required id="m_percentagedip" name="dip['+k+'][m_percentage]"> </div> </div> </div> <div class="row"> <h style="color:black"><b>Supporting Documents:</b></h></div><div class="row"><div class="col-md-4"> <div class="form-group"> <label> Consolidate Marksheet: <span class="error-star" style="color:red;">*</span></label> <input type="file" class="form-control ccdip" required id="consolidate_markdip" name="dip['+k+'][consolidate_mark]"> </div> </div> <!-- </div> <div class="row"> --> <div class="col-md-4"> <div class="form-group"> <label> Graduation Certificate:<span class="error-star" style="color:red;">*</span></label> <input type="file" class="form-control gcdip" required id="garduation_certificatedip" name="dip['+k+'][garduation_certificate]"> </div> </div> <div><button style="margin-top:30px" type="button" name="remove" id="dip" value='+k+' class="btn btn-danger btn_removedip">X</button></div> </div></div></section>'); 
        k++;
        $("#attachment_countdip").val(k);
    });
    $("#addphd").click(function(){
      
      // $('#dynamic_field').append('<div id="rowphd"><div class=""><input type="text" name="name[]" placeholder="Enter your Name" class="form-control name_list"/></td><td><input type="text" name="email[]" placeholder="Enter your Email" class="form-control name_email"/></td><td></div>');  
        $('#dynamic_fieldphd').append('<section class="input-box phd" id="rowphd"><div class="educationphd"> <div class="row"> <div class="col-md-4"><div class="form-group"><label>Graduation:<span class="error-star" style="color:red;">*</span></label><input type="text" class="form-control gradphd" required id="graduationphd" name="phd['+l+'][graduation]" value="Ph.D" readonly> </div></div><div class="col-md-4"><div class="form-group"><label>College Name:<span class="error-star" style="color:red;">*</span></label> <input type="text" class="form-control clgphd" required id="college_namephd" name="phd['+l+'][college_name]"></div> </div> <div class="col-md-4"> <div class="form-group"> <label>University Name:<span class="error-star" style="color:red;">*</span></label> <input type="text" class="form-control uniphd" required id="university_namephd" name="phd['+l+']university_name"> </div> </div> </div> <div class="row"> <div class="col-md-4"> <div class="form-group"> <label> Course Name:<span class="error-star" style="color:red;">*</span></label> <select class="form-control crsphd" required id="course_namephd" name="phd['+l+'][course_name]"> <option value="0">Select-Course</option> <option value="civil">civil</option> <option value="architect">architect</option> <option value="townplanning">townplanning</option> </select> </div> </div> <!-- </div> <div class="row"> --> <div class="col-md-4"> <div class="form-group"> <label> Year of Passing <span class="error-star" style="color:red;">*</span></label> <input type="month" class="form-control ypphd" maxlength="18" required id="yopphd" name="phd['+l+'][yop]"> </div> </div> <div class="col-md-4"> <div class="form-group"> <label> Marks %:<span class="error-star" style="color:red;">*</span></label> <input type="text" class="form-control mkphd" required id="m_percentagephd" name="phd['+l+'][m_percentage]"> </div> </div> </div> <div class="row"> <h style="color:black"><b>Supporting Documents:</b></h> <div class="col-md-4"> <div class="form-group"> <label> Consolidate Marksheet: <span class="error-star" style="color:red;">*</span></label> <input type="file" class="form-control ccphd" required id="consolidate_markphd" name="phd['+l+'][consolidate_mark]"> </div> </div> <!-- </div> <div class="row"> --> <div class="col-md-4"> <div class="form-group"> <label> Graduation Certificate:<span class="error-star" style="color:red;">*</span></label> <input type="file" class="form-control gcphd" required id="garduation_certificatephd" name="phd['+l+'][garduation_certificate]"> </div> </div> <div><button style="margin-top:30px" type="button" name="remove" id="phd" value='+l+' class="btn btn-danger btn_removephd">X</button></div> </div></div></section>'); 
        l++;
        $("#attachment_countphd").val(l);
    });

    $(document).on('click', '.btn_removeug', function(){  
      var button_id = $(this).attr("id");   
       i =  $('#attachment_count'+button_id+'').val(); 
      $('#row'+button_id+'').remove();  
      --i;
       $('#attachment_count'+button_id+'').val;
       var a = document.getElementsByClassName('ug');
        for(var z=0; z < a.length; z++){
            document.getElementsByClassName('gradug')[z].setAttribute('name', "ug["+z+"][graduation]" );
            document.getElementsByClassName('clgug')[z].setAttribute('name', "ug["+z+"][college_name]" );
            document.getElementsByClassName('uniug')[z].setAttribute('name', "ug["+z+"][university_name]" );
            document.getElementsByClassName('crsug')[z].setAttribute('name', "ug["+z+"][course_name]" );
            document.getElementsByClassName('ypug')[z].setAttribute('name', "ug["+z+"][yop]" );
            document.getElementsByClassName('mkug')[z].setAttribute('name', "ug["+z+"][m_percentage]" );
            document.getElementsByClassName('gcug')[z].setAttribute('name', "ug["+z+"][consolidate_mark]" );
            document.getElementsByClassName('ccug')[z].setAttribute('name', "ug["+z+"][garduation_certificate]" );
        }
    });
    $(document).on('click', '.btn_removepg', function(){  
      var button_id = $(this).attr("id");   
       j = $('#attachment_count'+button_id+'').val();  
      $('#row'+button_id+'').remove();  
      --j;
       $('#attachment_count'+button_id+'').val(j);
       var a = document.getElementsByClassName('pg');
        for(var z=0; z < a.length; z++){
            document.getElementsByClassName('gradpg')[z].setAttribute('name', "pg["+z+"][graduation]" );
            document.getElementsByClassName('clgpg')[z].setAttribute('name', "pg["+z+"][college_name]" );
            document.getElementsByClassName('unipg')[z].setAttribute('name', "pg["+z+"][university_name]" );
            document.getElementsByClassName('crspg')[z].setAttribute('name', "pg["+z+"][course_name]" );
            document.getElementsByClassName('yppg')[z].setAttribute('name', "pg["+z+"][yop]" );
            document.getElementsByClassName('mkpg')[z].setAttribute('name', "pg["+z+"][m_percentage]" );
            document.getElementsByClassName('gcpg')[z].setAttribute('name', "pg["+z+"][consolidate_mark]" );
            document.getElementsByClassName('ccpg')[z].setAttribute('name', "pg["+z+"][garduation_certificate]" );
        }
    });
    $(document).on('click', '.btn_removedip', function(){  
      var button_id = $(this).attr("id");   
       k = $('#attachment_count'+button_id+'').val(); 
      $('#row'+button_id+'').remove();  
      --k;
       $('#attachment_count'+button_id+'').val(k);
       var a = document.getElementsByClassName('dip');
        for(var z=0; z < a.length; z++){
            document.getElementsByClassName('graddip')[z].setAttribute('name', "dip["+z+"][graduation]" );
            document.getElementsByClassName('clgdip')[z].setAttribute('name', "dip["+z+"][college_name]" );
            document.getElementsByClassName('unidip')[z].setAttribute('name', "dip["+z+"][university_name]" );
            document.getElementsByClassName('crsdip')[z].setAttribute('name', "dip["+z+"][course_name]" );
            document.getElementsByClassName('ypdip')[z].setAttribute('name', "dip["+z+"][yop]" );
            document.getElementsByClassName('mkdip')[z].setAttribute('name', "dip["+z+"][m_percentage]" );
            document.getElementsByClassName('gcdip')[z].setAttribute('name', "dip["+z+"][consolidate_mark]" );
            document.getElementsByClassName('ccdip')[z].setAttribute('name', "dip["+z+"][garduation_certificate]" );
        }
    });
    $(document).on('click', '.btn_removephd', function(){  
      var button_id = $(this).attr("id");   
       l = $('#attachment_count'+button_id+'').val(); 
      $('#row'+button_id+'').remove();  
      --l;
       $('#attachment_count'+button_id+'').val(l);
       var a = document.getElementsByClassName('ug');
        for(var z=0; z < a.length; z++){
            document.getElementsByClassName('gradphd')[z].setAttribute('name', "phd["+z+"][graduation]" );
            document.getElementsByClassName('clgphd')[z].setAttribute('name', "phd["+z+"][college_name]" );
            document.getElementsByClassName('uniphd')[z].setAttribute('name', "phd["+z+"][university_name]" );
            document.getElementsByClassName('crsphd')[z].setAttribute('name', "phd["+z+"][course_name]" );
            document.getElementsByClassName('ypphd')[z].setAttribute('name', "phd["+z+"][yop]" );
            document.getElementsByClassName('mkphd')[z].setAttribute('name', "phd["+z+"][m_percentage]" );
            document.getElementsByClassName('gcphd')[z].setAttribute('name', "phd["+z+"][consolidate_mark]" );
            document.getElementsByClassName('ccphd')[z].setAttribute('name', "phd["+z+"][garduation_certificate]" );
        }
    });
</script>

  @endsection