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
</style>
<div class="main-content">
    <div class="row justify-content-center">
        <div class="col-lg-12 col-md-12">
            <div class="" style="height:100%; padding: 15px">
           
          
            <form  action="{{ route('Registration.update',$user_id) }}" method="POST" id="educreate_form" enctype="multipart/form-data" >
                    @csrf
                    @method('put')
                    <input type="hidden" class="form-control" required id="user_details" name="user_details" value="exp">

                    <div class="tile" id="tile-1" style="margin-top:10px !important;">

                        <!-- Nav tabs -->
                      
                        <ul class="nav nav-tabs nav-justified " id="tabs" role="tablist">
                          
                            <li class="nav-items navv" class="active" style="flex-basis: 1 !important;">
                                <a class="nav-link  " id="home-tab"  name="tab1" data-toggle="tab" role="tab" aria-controls="home" aria-selected="true" ><i class="fa fa-home"></i><b> Work Experience</b> <input type="checkbox" class="checkg" id="profile" name="nationality" value="0" onchange="submitval(this)" readonly style="background-color:solid green !important; color:green !important; visibility:hidden !important; "> <div class="check"></div> </a>

                            </li>
                            <li class="nav-items navv" class="" style="flex-basis: 1 !important;" >
                                <a class="nav-link" id="addition-tab" name="tab2" data-toggle="tab" role="tab" aria-controls="addition" aria-selected="false"   style=" background: #78a6c9 !important;"  ><i class="fas fa-map-signs"></i> <b>Certification</b> <input type="checkbox" class="checkg" id="adddetails" name="nationality" value="0" onchange="submitval(this)" style="background-color:solid green !important; color:green !important; visibility:hidden !important; "></a>

                            </li>
                         
                         

                        </ul>
                    </div>
                    <!-- Tab panes -->

                    <div id="content">
                        <div id="tab1">

                                    <section class="section">
                                        <div class="section-body mt-1">
                                            <div class="row">

                                                <div class="col-md-4">
                                                <div class="form-group">
                                                <label class="control-label">Work Experience:<span class="error-star" style="color:red;">*</span></label>
                                                        <input class="form-control default" type="text" id="we" name="we" required value="" autocomplete="off">
                                                        <input class="form-control" type="hidden" id="" name="ref_no" value="" autocomplete="off">
                                                    </div>
                                                </div>

                                                <div class="col-md-6">
                                                <div class="form-group mb-0 mt-4">
                                                <div class="egc" style="display: flex;  align-items: center;">
                                                                <div class="dq"><span class="questions">Work Experience Related To Valuation: YES/NO:</span></div>
                                                                            
                                                                            <div class="switch-field" style="padding-left:12px">
                                                        <input type="radio" id="radio-one12" name="wrqch" value="yes" required onchange="radchange(this)" />
                                                        <label for="radio-one12">Yes</label>
                                                        <input type="radio" id="radio-two12" name="wrqch" value="no" required onchange="radchange(this)" />
                                                        <label for="radio-two12">No</label>
                                                    </div>
                                                            </div>
                                                    </div>
                                                    
                                                </div>
                                                <div class="col-md-2">
                                                                    <div class="form-group">
                                                                        <label class="control-label">ISU Membership Number:<span class="error-star"  style="color:red;">*</span></label>
                                                                        <input class="form-control default indent wrq" type="text" oninput="input(this)" id="cpvw"  name="wrq[cpvw]" autocomplete="off" >

                                                                    </div>
                                                                </div>
                                            </div>
                                            
                                                    <div class="" id="qv1">
                                                        <div class="row">
                                                                <div class="col-md-2">
                                                                    <div class="form-group">
                                                                        <label class="control-label">Cost, price, value and worth,:<span class="error-star"  style="color:red;">*</span></label>
                                                                        <input class="form-control default indent wre" type="text" oninput="input(this)" id="cpvw"  name="wrq[cpvw]" autocomplete="off" >

                                                                    </div>
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <div class="form-group">
                                                                        <label class="control-label">Value – types, elements, ingredients, characteristics:<span class="error-star" style="color:red;">*</span></label>
                                                                        <input class="form-control default indent wrq" type="text" oninput="input(this)" id="teic"  name="wrq[teic]" autocomplete="off" >

                                                                    </div>
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <div class="form-group">
                                                                        <label class="control-label">Annuities – capitalisation – rate of capitalisation – redemption of capital:</label>
                                                                        <input class="form-control default indent wrq" type="text" oninput="input(this)" id="acrr"  name="wrq[acrr]" autocomplete="off" >

                                                                    </div>
                                                                </div>

                                                                <div class="col-md-6">
                                                                    <div class="form-group">
                                                                        <label class="control-label"><span id="item_label"></span>Three approaches to value viz., Income, Market and Cost:<span class="error-star" style="color:red;">*</span></label>
                                                                        <input class="form-control default indent wrq" type="text" oninput="input(this)" id="imc" name="wrq[imc]"  autocomplete="off" >

                                                                    </div>
                                                                </div>

                                                                <div class="col-md-4">
                                                                    <div class="form-group">
                                                                        <label class="control-label"><span id="item_no_label"></span>Laws applicable to agricultural land:<span class="error-star" style="color:red;">*</span></label>
                                                                        <input class="form-control default wrq" type="text" id="laal" name="wrq[laal]"  autocomplete="off">
                                                                    </div>
                                                                </div>
                                                        </div>
                                                    </div>

                                                    <div class="" id="qv2">
                                                        <!-- <div class="row">
                                                              
                                                                <div class="col-md-2">
                                                                    <div class="form-group">
                                                                        <label class="control-label">From Date:<span class="error-star" style="color:red;">*</span></label>
                                                                        <input class="form-control default indent wre" type="date" oninput="input(this)" id="fde1" name="wre[0][fde]" required  placeholder="DD-MM-YYYY" autocomplete="off" >

                                                                    </div>
                                                                </div>
                                                                <div class="col-md-2">
                                                                    <div class="form-group">
                                                                        <label class="control-label">To Date:</label>
                                                                        <input class="form-control default indent wre" type="date" oninput="input(this)" id="tde1" name="wre[0][tde]" required autocomplete="off" >

                                                                    </div>
                                                                </div>
                                                                <div class="col-md-2">
                                                                    <div class="form-group">
                                                                        <label class="control-label"><span id="item_no_label"></span>Area of work:<span class="error-star" style="color:red;">*</span></label>
                                                                        <input class="form-control default wre" type="text" id="aow1" name="wre[0][aow]" required  autocomplete="off">
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-3">
                                                                    <div class="form-group">
                                                                        <label class="control-label"><span id="item_label"></span>Employment/Practice:<span class="error-star" style="color:red;">*</span></label>
                                                                    <div class="switch-field" style="padding-left:12px">
                                                                        <input type="radio" id="radio-one0" class="wre" name="wre[0][ep]" value="employee" required onchange="workchanges(this,'1')" />
                                                                        <label for="radio-one0">Employment</label>
                                                                        <input type="radio" id="radio-two0" class="wre" name="wre[0][ep]" value="practice" required onchange="workchanges(this,'1')" />
                                                                        <label for="radio-two0">Practice</label>
                                                                    </div>

                                                                    </div>
                                                                </div>
                                                            
                                                                <div class=" col-md-2 " id="s11">
                                                                    <div class="form-group">
                                                                        <label class="control-label"><span id="item_no_label1"></span>Designation:<span class="error-star" style="color:red;">*</span></label>
                                                                        <input class="form-control default wre " type="text" id="des1" name="wre[0][des]" required autocomplete="off">
                                                                    </div>
                                                                </div>
                                                                <div class=" col-md-2" id="s21">
                                                                    <div class="form-group">
                                                                        <label class="control-label"><span id="item_no_label2"></span>Exp in the relevant valuation:<span class="error-star" style="color:red;">*</span></label>
                                                                        <input class="form-control default wre " type="text" id="rel1" name="wre[0][rel]" required  autocomplete="off">
                                                                    </div>
                                                                </div>
                                                          
                                                        </div>   -->
                                                                    <input type="hidden" name="attachment_counte" id="attachment_counte" value="1">
                                                                    <div id="dynamic_fielde"></div>
                                                                     <button type="button" name="adde" id="adde" class="btn btn-primary" style="background-color: #67c8e2 !important" >Add Experience</button>
                                                                   

                                                    </div>
                                    
                                        </div>
                                    </section>
                                        <div style="display:flex; justify-content:center; width:100%">

                                    <a type="button" class="btn btn-labeled btn-info" onclick="DoAction('tab2');" title="next" style="background: #4d94ff !important; border-color:#4d94ff !important; color:white !important">
                                            <span class="btn-label" style="font-size:13px !important;"><i class="fa fa-arrow-right"></i></span>Next</a>
                                        </div>
                        </div>

                        <div id="tab2">
                            <section class="section">


                                <div class="section-body mt-0">


                                    
                                        <div class="row">
                                            <div class="col-md-12">
                                                <input type="hidden" name="attachment_countc" id="attachment_countc" value="1">

                                                <div id="dynamic_fieldc"></div>
                                            </div>
                                        </div>

                                                <button type="button" name="addc" id="addc" class="btn btn-primary" style="background-color: #67c8e2 !important" >Add Certification</button>
                                <!-- final submit button -->




                                <!-- final submit button -->
                        

                                <!-- <div class="col-lg-12" id="register">

                                    <form action="" method="POST">
                                        @csrf

                                      <div class="col-md-12 text-center">

                                        <input type="hidden" class="form-control" required id="reg_status" name="reg_status" value="">
                                        <input type="hidden" class="form-control" required id="user_id" name="user_id" value="">
                                        <input type="hidden" class="form-control" name="registration_status" value="Registered">



                                            
                                        <a type="button" class="btn btn-labeled btn-info" onclick="DoAction('tab1');" title="next" style="background: red !important; border-color:red !important; color:white !important">
                                        <span class="btn-label" style="font-size:13px !important;"><i class="fa fa-arrow-left"></i></span>Previous</a>



                                    </div>
                                    </form>
                                </div> -->


                                <!-- <div class="col-lg-12" id="registr">

                                    <form action="" method="POST">
                                    @csrf

                                    <div class="col-md-12 text-center">

                                        <input type="hidden" class="form-control" required id="reg_status" name="reg_status" value="">
                                        <input type="hidden" class="form-control" required id="user_id" name="user_id" value="">
                                        <input type="hidden" class="form-control" name="registration_status" value="Registered">
                                        <label style="color:red"><b>Please Click Submit to Complete Supplier Registration </b></label><br>
                                       
                                    
                                    </div>
                                    </form>
                                </div> -->
                                

                                <!-- <div class="col-md-12 text-center">

                                    <input type="hidden" class="form-control" required id="reg_status" name="reg_status" value="">
                                    <input type="hidden" class="form-control" required id="user_id" name="user_id" value="">
                                    <input type="hidden" class="form-control" name="registration_status" value="Registered">




                                   



                                </div> -->

                                </div>
                                            
                            </section>


                        </div>
                      
                    </div>
                        <div style="display:flex; justify-content:center; width:100%">
                                            <a type="button" class="btn btn-labeled btn-info" href="{{url('Registration')}}" title="next" style="background: red !important; border-color:red !important; color:white !important; margin-top:15px !important;">
                                                            <span class="btn-label" style="font-size:13px !important;"><i class="fa fa-arrow-left"></i></span>Back</a>
                                                            <button type="submit"  id="registerbutton" class="btn btn-labeled btn-info" title="Submit" style="background: green !important; border-color:green !important; color:white !important;  margin-top:15px !important; margin-left:15px !important;">
                                        <span class="btn-label" style="font-size:13px !important;"><i class="fa fa-check"></i></span>Save</a>

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


        var  Experience = {!! json_encode($Experience) !!};
        console.log(Experience); 
            var eul = Experience['index']
            document.getElementById('we').value = Experience['index'][0]['experience'];
            var exp =  Experience['index'][0]['wrqch'];
            var wrel = Experience['wre'].length;
            var certl = Experience['cert'].length;

            document.getElementById("radio-one12").checked = (exp == "yes") ? true : false;
            document.getElementById("radio-two12").checked = (exp == "no") ? true : false;
            document.getElementById('qv2').style.display = "none" ;
                document.getElementById('qv1').style.display = "none" ;
            if(exp==="yes"){
                document.getElementById('qv1').style.display = "inline-block" ;
                var b = document.getElementsByClassName('wrq');
        for(var x=0; x < b.length; x++){
            document.getElementsByClassName('wrq')[z].setAttribute('required','required');
           
        }
            }
            else{
                document.getElementById('qv2').style.display = "inline-block" ;
               
                for(j=0;j<wrel;j++){
                    var q = j+1;
                    $('#dynamic_fielde').append('<section class="input-box expc" id="rowe'+j+'"><div class="row clear remove_other'+j+' "> <div class="col-md-2"> <div class="form-group"> <label class="control-label">From Date:<span class="error-star" style="color:red;">*</span></label> <input class="form-control default indent wre expf" type="date" oninput="input(this)" id="fde'+q+'" name="wre['+j+'][fde]" required autocomplete="off" > </div> </div> <div class="col-md-2"> <div class="form-group"> <label class="control-label">To Date:</label> <input class="form-control default indent wre expt" type="date" oninput="input(this)" id="tde'+q+'" name="wre['+j+'][tde]" required autocomplete="off" > </div> </div> <div class="col-md-2"> <div class="form-group"> <label class="control-label"><span id="item_no_label"></span>Area of work:<span class="error-star" style="color:red;">*</span></label> <input class="form-control default wre expa" type="text" id="aow'+q+'" name="wre['+j+'][aow]" required autocomplete="off"> </div> </div> <div class="col-md-3"> <div class="form-group"> <label class="control-label"><span id="item_label"></span>Employment/Practice:<span class="error-star" style="color:red;">*</span></label> <div class="switch-field" style="padding-left:12px"> <input type="radio" class="wre expep" id="radio-one'+j+'" name="wre['+j+'][ep]" value="employee" required onchange="workchanges(this,'+q+')" /> <label for="radio-one'+j+'">Employment</label> <input type="radio" class="wre expep" id="radio-two'+j+'" name="wre['+j+'][ep]" value="practice" required onchange="workchanges(this,'+q+')" /> <label for="radio-two'+j+'">Practice</label> </div> </div> </div> <div class="col-md-2" id="s1'+q+'" style="display:none"> <div class="form-group "> <label class="control-label"><span id="item_no_label1"></span>Designation:<span class="error-star" style="color:red;">*</span></label> <input class="form-control default  wre expd" type="text" id="des'+q+'" name="wre['+j+'][des]" required autocomplete="off"> </div> </div> <div class=" col-md-2" id="s2'+q+'" style="display:none"> <div class="form-group"> <label class="control-label"><span id="item_no_label2"></span>Exp in the relvt valuation:<span class="error-star" style="color:red;">*</span></label> <input class="form-control default wre expr" type="text" id="rel'+q+'" name="wre['+j+'][rel]" required autocomplete="off"> </div> </div><div><button style="margin-top:30px" type="button" name="remove" id="e'+j+'" class="btn btn-danger btn_remove">X</button></div></div></section>'); 
                    $("#attachment_counte").val(q);
                
                    document.getElementById('s1'+q).style.display = "none" ;
                    document.getElementById('s2'+q).style.display = "none" ;


                    document.getElementById('fde'+q).value =  Experience['wre'][j]['fde'];
                    document.getElementById('tde'+q).value =  Experience['wre'][j]['tde'];
                    document.getElementById('aow'+q).value =  Experience['wre'][j]['aow'];
                    exps = Experience['wre'][j]['ep'];
                    document.getElementById("radio-one"+j).checked = (exps == "employee") ? true : false;
                    document.getElementById("radio-two"+j).checked = (exps == "practice") ? true : false;
                    if(exps==="employee"){
                    document.getElementById('s1'+q).style.display = "inline-block" ;
                    document.getElementById('des'+q).value = Experience['wre'][j]['des'];
                    document.getElementById('rel'+q).removeAttribute('required');
                    }
                    else{
                    document.getElementById('s2'+q).style.display = "inline-block" ;
                    document.getElementById('rel'+q).value = Experience['wre'][j]['rel'];
                    document.getElementById('des'+q).removeAttribute('required');
                    }
                }
                for(i=0;i<certl;i++){
                    var q = i+1;
                    var doc = "'"+Experience['cert'][i]['certfp']+'/'+Experience['cert'][i]['certfn']+"'";
                    $('#dynamic_fieldc').append('<section class="input-box certc" id="rowc'+i+'"><div class="row clear remove_other'+i+' "><div class="col-md-4"> <div class="form-group"> <label class="control-label">Name of the Professional Body:<span class="error-star" style="color:red;">*</span></label> <input class="form-control default certnopb" type="text" id="nopb" name="cert['+i+'][nopb]" value="'+Experience['cert'][i]['nopb']+'" autocomplete="off" required value="" > </div> </div> <div class="col-md-3"> <div class="form-group"> <label class="control-label">Certificate issued by:<span class="error-star" style="color:red;">*</span></label> <input class="form-control default certib" type="text" id="certib" name="cert['+i+'][ib]" required value="'+Experience['cert'][i]['certib']+'" autocomplete="off">  </div> </div> <div class="col-md-3"> <div class="form-group"> <label class="control-label">Certification Documents:<span class="error-star" style="color:red;">*</span></label> <label>'+Experience['cert'][i]['certfn']+'</label></div></div><div class="col-md-2"> <div class="form-group "> <label> <a type="button" class="btn btn-success " title="Download Documents" href="'+Experience['cert'][i]['certfp']+'/'+Experience['cert'][i]['certfn']+'" download=""><i class="fa fa-download" style="color:white!important"></i></a> <a class="btn btn-primary" title="view Document" data-toggle="modal" data-target="#templates" onclick="getproposaldocument('+doc+')"><input type="hidden" class="cert" id="ocfn'+q+'" name="cert['+i+'][ocfn]" value="'+Experience['cert'][i]['certfn']+'"><input type="hidden" class="cert id="ougcfp'+q+'" name="cert['+i+'][ocfp]" value="'+Experience['cert'][i]['certfp']+'"><i class="fa fa-eye" style="color:white!important"></i></a></label></div></div></div><div class="row"> <div class="col-md-2"><div class="form-group"> <button type="button" class="btn btn-info " id="f'+q+'" title="change Documents" value="1" onclick="changefile1(this,'+q+')"><input class="certf" type="hidden" id="i'+q+'" name="f'+q+'" value="1"><input type="hidden" id="yn'+q+'" name="yn" value="1"><i class="fa fa-exchange" id="fi'+q+'" style="color:white!important"> Change File</i></button></div></div><div class="col-md-3 dcertd certd" id="dcertd'+q+'" ><div class="form-group"><input class="form-control" type="file" id="certd'+q+'" name="cert['+i+'][certd]"  value="" autocomplete="off"> </div></div><div><button  type="button" name="remove" id="c'+i+'" class="btn btn-danger btn_remove">X</button></div></div> </div> </div></section>'); 

                    $("#attachment_countc").val(q);
                    
                }
         
                var a = document.getElementsByClassName('dcertd');
        for(var z=0; z < a.length; z++){
            document.getElementsByClassName('dcertd')[z].style.display = "none";
        } 
             
            }
            

    });

        function DoAction(id) {

            $("#content").find("[id^='tab']").hide(); // Hide all content
        $("#tabs li").removeClass("active"); //Reset id's
        $("#tabs a").removeClass("active"); //Reset id's
        $("a[name='" + id + "']").parent().addClass("active");
        $('#' + (id)).fadeIn(); // Show content for the current tab

        }
        
        function radchange(a){
            var a = a.value;
            if(a=="yes"){
                document.getElementById('qv2').style.display = "none" ;
                document.getElementById('qv1').style.display = "block" ;
                var a = document.getElementsByClassName('wrq');
        for(var z=0; z < a.length; z++){
                document.getElementsByClassName('wrq')[z].setAttribute('required','required');
       
        }
        var b = document.getElementsByClassName('wre');
        for(var y=0; y < b.length; y++){
        document.getElementsByClassName('wre')[y].removeAttribute('required');
             }
            }
            else{
                document.getElementById('qv1').style.display = "none" ;
                document.getElementById('qv2').style.display = "block" ;
                var a = document.getElementsByClassName('wrq');
        for(var z=0; z < a.length; z++){
                document.getElementsByClassName('wrq')[z].removeAttribute('required');
       
        }
        var b = document.getElementsByClassName('wre');
        for(var y=0; y < b.length; y++){
                document.getElementsByClassName('wre')[y].setAttribute('required','required');
             }
            }
        }
        function workchanges(a,b){
            var a = a.value;

            if(a == "employee"){
                document.getElementById('s2'+b).style.display = "none" ;
                document.getElementById('rel'+b).removeAttribute('required','required');
                document.getElementById('s1'+b).style.display = "inline-block" ;
                document.getElementById('des'+b).setAttribute('required','required');
             }
            else{
                document.getElementById('s1'+b).style.display = "none" ;
                document.getElementById('des'+b).removeAttribute('required','required');
                document.getElementById('s2'+b).style.display = "inline-block" ;
                document.getElementById('rel'+b).setAttribute('required','required');
                
            }
        }
        function changefile1(b,a) {
        var b = b.value;
        if(b == "1"){
        document.getElementById('certd'+a).setAttribute('required','required');
        document.getElementById('dcertd'+a).style.display = "inline-block";
        document.getElementById('i'+a).value = "0";
        document.getElementById('f'+a).value = "0";
        document.getElementById('fi'+a).innerText = " Stay The Same";
        }
        else{
            document.getElementById('certd'+a).removeAttribute('required');
        document.getElementById('dcertd'+a).style.display = "none";
        document.getElementById('i'+a).value = "1";
        document.getElementById('f'+a).value = "1";
        document.getElementById('fi'+a).innerText = " Change File";
        }
        };
        var j =  $("#attachment_counte").val();

 $("#adde").click(function(){
        var q = j + 1;
      // $('#dynamic_field').append('<div id="row'+i+'"><div class=""><input type="text" name="name[]" placeholder="Enter your Name" class="form-control name_list"/></td><td><input type="text" name="email[]" placeholder="Enter your Email" class="form-control name_email"/></td><td></div>');  
      $('#dynamic_fielde').append('<section class="input-box expc" id="rowe'+j+'"><div class="row clear remove_other'+j+' "> <div class="col-md-2"> <div class="form-group"> <label class="control-label">From Date:<span class="error-star" style="color:red;">*</span></label> <input class="form-control default indent wre expf" type="date" oninput="input(this)" id="fde" name="wre['+j+'][fde]" required autocomplete="off" > </div> </div> <div class="col-md-2"> <div class="form-group"> <label class="control-label">To Date:</label> <input class="form-control default indent wre expt" type="date" oninput="input(this)" id="tde" name="wre['+j+'][tde]" required autocomplete="off" > </div> </div> <div class="col-md-2"> <div class="form-group"> <label class="control-label"><span id="item_no_label"></span>Area of work:<span class="error-star" style="color:red;">*</span></label> <input class="form-control default wre expa" type="text" id="aow" name="wre['+j+'][aow]" required autocomplete="off"> </div> </div> <div class="col-md-3"> <div class="form-group"> <label class="control-label"><span id="item_label"></span>Employment/Practice:<span class="error-star" style="color:red;">*</span></label> <div class="switch-field" style="padding-left:12px"> <input type="radio" class="wre expep" id="radio-one'+j+'" name="wre['+j+'][ep]" value="employee" required onchange="workchanges(this,'+q+')" /> <label for="radio-one'+j+'">Employment</label> <input type="radio" class="wre expep" id="radio-two'+j+'" name="wre['+j+'][ep]" value="practice" required onchange="workchanges(this,'+q+')" /> <label for="radio-two'+j+'">Practice</label> </div> </div> </div> <div class="col-md-2" id="s1'+q+'" style="display:none"> <div class="form-group "> <label class="control-label"><span id="item_no_label1"></span>Designation:<span class="error-star" style="color:red;">*</span></label> <input class="form-control default  wre expd" type="text" id="des'+q+'" name="wre['+j+'][des]" required autocomplete="off"> </div> </div> <div class=" col-md-2" id="s2'+q+'" style="display:none"> <div class="form-group"> <label class="control-label"><span id="item_no_label2"></span>Exp in the relvt valuation:<span class="error-star" style="color:red;">*</span></label> <input class="form-control default wre expr" type="text" id="rel'+q+'" name="wre['+j+'][rel]" required autocomplete="off"> </div> </div><div><button style="margin-top:30px" type="button" name="remove" id="e'+j+'" class="btn btn-danger btn_remove">X</button></div></div></section>'); 
      j++;
    
 $("#attachment_counte").val(j);

    });

    $(document).on('click', '.btn_remove', function(){  
      var button_id = $(this).attr("id"); 
      button_ide = '#row'+button_id+'';
      $(button_ide).remove();  
      --j;
       $("#attachment_counte").val(j);
       var a = document.getElementsByClassName('expc');
        for(var z=0; z < a.length; z++){

            document.getElementsByClassName('expf')[z].setAttribute('name', "[wre]["+z+"][fde]" );
            document.getElementsByClassName('expt')[z].setAttribute('name', "[wre]["+z+"][tde]" );
            document.getElementsByClassName('expa')[z].setAttribute('name', "[wre]["+z+"][aow]" );
            document.getElementsByClassName('expep')[z].setAttribute('name', "[wre]["+z+"][ep]" );
            document.getElementsByClassName('expd')[z].setAttribute('name', "[wre]["+z+"][des]" );
            document.getElementsByClassName('expr')[z].setAttribute('name', "[wre]["+z+"][rel]" );

         
        }
    });



    $("#addc").click(function(){
 var i =  $("#attachment_countc").val();
 i = parseInt(i);
        var q = i+1;
      // $('#dynamic_field').append('<div id="row'+i+'"><div class=""><input type="text" name="name[]" placeholder="Enter your Name" class="form-control name_list"/></td><td><input type="text" name="email[]" placeholder="Enter your Email" class="form-control name_email"/></td><td></div>');  
      $('#dynamic_fieldc').append('<section class="input-box certc" id="rowc'+i+'"><div class="row clear remove_other'+i+' "><div class="col-md-4"> <div class="form-group"> <label class="control-label">Name of the Professional Body:<span class="error-star" style="color:red;">*</span></label> <input class="form-control default certnopb" type="text" id="nopb" name="cert['+i+'][nopb]" autocomplete="off" required value="" > </div> </div> <div class="col-md-3"> <div class="form-group"> <label class="control-label">Certificate issued by:<span class="error-star" style="color:red;">*</span></label> <input class="form-control default certib" type="text" id="certib" name="cert['+i+'][ib]" required value="" autocomplete="off">  </div> </div> <div class="col-md-3"> <div class="form-group"> <label class="control-label">Certification Documents:<span class="error-star" style="color:red;">*</span></label> <input class="form-control certd" type="file" id="certd" name="cert['+i+'][certd]" required value="" autocomplete="off"><input class="certf" type="hidden" id="i'+q+'" name="f'+q+'" value="0"> </div> </div> <div><button style="margin-top:30px" type="button" name="remove" id="c'+i+'" class="btn btn-danger btn_remove">X</button></div></div></section>'); 
      i++;
    
 $("#attachment_countc").val(q);

    });

    $(document).on('click', '.btn_remove', function(){  
      var button_id = $(this).attr("id");   
      button_idc = '#row'+button_id+''
      $(button_idc).remove();  
      var i =  $("#attachment_countc").val();
      --i;
       $("#attachment_countc").val(i);
       var a = document.getElementsByClassName('certc');
        for(var z=0; z < a.length; z++){

            document.getElementsByClassName('certnopb')[z].setAttribute('name', "[cert]["+z+"][nopb]" );
            document.getElementsByClassName('certib')[z].setAttribute('name', "[cert]["+z+"][ib]" );
            document.getElementsByClassName('certd')[z].setAttribute('name', "[cert]["+z+"][certd]" );
            document.getElementsByClassName('certf')[z].setAttribute('name', "[f"+z+"]" );
         
        }
    });

    function getproposaldocument(id) {
        var id = (id);

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
                    var proposaldocuments = "<div class='removeclass' style=' height:100%'><iframe src='" + data + "' class='document_ifarme_view' style='width:100%; height:100%'></iframe></div>";
                    $('.removeclass').remove();
                    var document = $('#template').append(proposaldocuments);

                }
            }
        });
    };
</script>
@include('Registration.formmodal')

  @endsection