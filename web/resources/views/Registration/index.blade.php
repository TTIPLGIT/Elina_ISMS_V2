@extends('layouts.adminnav')

@section('content')
<style>
    input[type=checkbox] {
        display: inline-block;
    }
    .no-arrow {
        -moz-appearance: textfield;
    }

    .no-arrow::-webkit-inner-spin-button {
        display: none;
    }

    .no-arrow::-webkit-outer-spin-button,
    .no-arrow::-webkit-inner-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }
    
.nav-tabs{
    background-color: #0068a7 !important;
    border-radius: 29px !important;
    padding: 1px !important;

}

.nav-item.active{
    background-color: #0e2381 !important;
    border-radius: 31px !important;
    height:100% !important;
}
.nav-link.active{
    background-color: #0e2381 !important;
    border-radius: 31px !important;
    height:100% !important;
}
:root {
  --borderWidth: 5px;
  --height: 24px;
  --width: 12px;
  --borderColor: #78b13f;
}



.check  {
  display: inline-block;
  transform: rotate(50deg);
  height: var(--height);
  width: var(--width);
  border-bottom: var(--borderWidth) solid var(--borderColor);
  border-right: var(--borderWidth) solid var(--borderColor);
}
.nav-justified{
    display: flex !important;
    align-items: center !important;
}
.gender{
    display: flex;
    align-items: center;
    justify-content: space-evenly;
}
.egc{
    display: flex;
    border: 1px solid #350756;
    padding: 8px 25px 8px 8px;
    align-items: center;

    justify-content: space-between;
}
.dq {
    font-size: 16px;
    width: 80%;
    font-weight: 600;
}
.answer{
    width:15%;
    display:flex;
    color: #04092e !important;
    justify-content:space-around;
}
.questions{
    color: #000c62 !important
}
input[type='radio']:checked:after {
    background-color: #34395e !important;
}
input[type='radio']:after {
    background-color: #34395e !important;
}
/* radiocss */
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
/* endcss */
.vl {
  border-left: 1px solid #350756;
  height: 40px;
}

.close {
    color: white;
    opacity: 1;
}

</style>
<div class="main-content">
    <div class="row justify-content-center">
        <div class="col-lg-12 col-md-12">
            <div class="" style="height:100%; padding: 15px">

                <form  method="POST" id="registration_form" enctype="multipart/form-data" onsubmit="return false">
                    @csrf
                    
                    <div class="tile" id="tile-1" style="margin-top:10px !important; margin-bottom:10px !important;">

                        <!-- Nav tabs -->
                        <ul class="nav nav-tabs nav-justified" id="tabs" role="tablist">
                          
                            <li class="nav-item" class="active">
                                <a class="nav-link  " id="home-tab" name="tab1" data-toggle="tab" role="tab" aria-controls="home" aria-selected="true"><i class="fa fa-home"></i><b> General Details</b> <input type="checkbox" class="checkg" id="gencheckbox" name="nationality" value="0" onchange="submitval(this)" readonly style="background-color:solid green !important; color:green !important; visibility:hidden !important; "> <div class="check" id="gct"></div> </a>

                            </li>
                            <li class="nav-item" class="">
                                <a class="nav-link" id="addition-tab" name="tab2" data-toggle="tab" role="tab" aria-controls="addition" aria-selected="false"><i class="fas fa-map-signs"></i> <b>Education Qualification</b> <input type="checkbox" class="checkg" id="educheckbox" name="nationality" value="0" onchange="submitval(this)" style="background-color:solid green !important; color:green !important; visibility:hidden !important; "> <div class="check" id="educt"></div> </a>

                            </li>
                            <li class="nav-item" class="">
                                <a class="nav-link" id="contact-tab" name="tab3" data-toggle="tab" role="tab" aria-controls="contact" aria-selected="false"><i class="fas fa-map-signs"></i><b> Work Experience</b> <input type="checkbox" class="checkg" id="expcheckbox" name="nationality" value="0" onchange="submitval(this)" style="background-color:solid green !important; color:green !important; visibility:hidden !important; "><div class="check" id="expct"></div></a>
                            </li>
                            <li class="nav-item" class="">
                                <a class="nav-link" id="profile-tab" name="tab4" data-toggle="tab" role="tab" aria-controls="profile" aria-selected="false"><i class="fas fa-id-card"></i><b>Eligibility Criteria</b> <input type="checkbox" class="checkg" id="eligcheckbox" name="nationality" value="0" onchange="submitval(this)" style="background-color:solid green !important; color:green !important; visibility:hidden !important; "><div class="check" id="eligct"></div> </a>

                            </li>


                        </ul>
                    </div>
                    <!-- Tab panes -->

                    <div id="content">
                        <div id="tab1">

                            <section class="section">


                                <div class="section-body mt-0">
                                    <div class="row">
                                        <div class="col-12">
                                                <a type="button" style="font-size:15px;" class="btn btn-success btn-lg" title="Create" id="gcb" href="{{ route('Registration.create') }}" data-toggle="modal" data-target="#addModal">Add General Details <i class="fa fa-plus" aria-hidden="true"></i></a>
                                                <div class="card mt-0">
                                                    <div class="card-body">
                                                            <div class="table-wrapper">
                                                                <div class="table-responsive">
                                                                    <table class="table table-bordered" id="align1">
                                                                        <thead>
                                                                        <tr>
                                                                            <th>Sl.No</th>
                                                                            <th>Name</th>
                                                                            <th>Role</th>
                                                                            <th>Land Classification</th>
                                                                            <th>Constitiuency</th>
                                                                            <th>Status</th>
                                                                            <th>Action</th>
                                                                        </tr>
                                                                        </thead>
                                                                        <tbody>

                                                                            
                                                                        <tr>
                                                                            
                                                                            <td></td>
                                                                            <td> </td>

                                                                            <td></td>
                                                                            <td></td>
                                                                            <td></td>
                                                                            <td></td>

                                                                            <input type="hidden" class="cfn" id="fn" value="">

                                                                            <td>
                                                                            <form action="{{ route('destroygen',1) }}" id="destroygen" method="POST">
                                                                            
                                                                                <a class="btn btn-link" title="Edit" href="{{ route('Registration.edit',1) }}"><i class="fas fa-pencil-alt" style="color: blue !important"></i></a>
                                                                                <a class="btn btn-link" title="show" href="{{ route('Registration.show',1) }}"><i class="fas fa-eye" style="color:green"></i></a>
                                                                                @csrf
                                                                                
                                                                                <button type="submit" title="Delete" onclick="delete1()" class="btn btn-link"><i class="far fa-trash-alt" style="color:red"></i></button>
                                                                            </form>
                                                                            </td>

                                                                        </tr>

                                                                       
                                                                        <input type="hidden" class="cfn" id="fn" value="0">

                                                                        </tbody>
                                                                    </table>
                                                                </div>
                                                            </div>
                                                    </div>
                                                </div>
                                        </div>



                                        <div class="col-lg-12 text-center ">
                                        <a type="button" id="registerbutton" class="btn btn-labeled btn-info" title="Submit" style="background: green !important; border-color:green !important; color:white !important; margin-top:15px">
                                        <span class="btn-label" style="font-size:13px !important;"><i class="fa fa-check"></i></span>Submit</a>
                                            <a type="button" class="btn btn-labeled btn-info" onclick="DoAction('tab2');" title="next" style="background: #4d94ff !important; border-color:#4d94ff !important; color:white !important;margin-top:15px">
                                            <span class="btn-label" style="font-size:13px !important;"><i class="fa fa-arrow-right"></i></span>Next</a>

                                        </div>
                                        
                                    </div>
                                </div>
                            </section>
                    
                        </div>


                        <div id="tab2">

                            <section class="section">


                                <div class="section-body mt-1">


                                    <div class="row">
                                            <div class="col-12">
                                                <a type="button" style="font-size:15px;" class="btn btn-success btn-lg" title="Create" id="educb" href="{{ route('educreate') }}" >Add Education Profile <i class="fa fa-plus" aria-hidden="true"></i></a>
                                                <div class="card mt-0">


                                                        <div class="card-body">
                       
                                                                    <!-- @if ($message = Session::get('success'))
                                                                    <div class="alert alert-success alert-block">
                                                                        <button type="button" class="close" data-dismiss="alert">�</button>
                                                                        <strong>{{ $message }}</strong>
                                                                    </div>
                                                                    @endif

                                                                    @if ($message = Session::get('error'))
                                                                    <div class="alert alert-success alert-block">
                                                                        <button type="button" class="close" data-dismiss="alert">�</button>
                                                                        <strong>{{ $message }}</strong>
                                                                    </div>
                                                                    @endif -->
                                                                    <div class="table-wrapper">
                                                                <div class="table-responsive">
                                                                    <table class="table table-bordered" id="align3">
                                                                    <thead>
                                                                        <tr>
                                                                        <th>Sl.No</th>
                                                                        <th>No of ug courses</th>
                                                                        <th>No of pg courses</th>
                                                                        <th>No of diploma courses</th>
                                                                        <th>Action</th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>

                                                                   
                                                                    
                                                                        <tr>
                                                                        <td></td>

                                                                        <td></td>

                                                                        <td></td>

                                                                        <td></td>
                                                                        <input type="hidden" class="ceduid" id="eduid" value="">

                                                                      
                                                                        <td>
                                                                            <form action="{{ route('destroyedu',1) }}" method="POST">
                                                                            <a class="btn btn-link" title="Edit" href="{{route('eduedit',1) }}"><i class="fas fa-pencil-alt" style="color:darkblue"></i></a>
                                                                            <a class="btn btn-link" title="show" href="{{route('edushow',1) }}"><i class="fas fa-eye" style="color:blue"></i></a>
                                                                            <input type="hidden" class="form-control" required id="user_detail" name="user_detail" value="educate">
                                                                           
                                                                            @csrf
                                                                            <button type="submit" title="Delete" onclick="return confirm('Are you sure you want to delete this general Profile ? You may Delelting the Critical  data');" class="btn btn-link"><i class="far fa-trash-alt" style="color:red"></i></button>

                                                                         
                                                                        </form>
                                                                        </td>

                                                                        </tr>
                                                                   
                                                                    <input type="hidden" class="ceduid" id="eduid" value="0">

                                                                    </tbody>
                                                                    </table>
                                                                </div>
                                                                    </div>
                                                        </div>
                                                </div>
                                            </div>
                                    </div>


                                    <div class="col-lg-12 text-center ">

                                        <a type="button" class="btn btn-labeled btn-info" onclick="DoAction('tab1');" title="back" style="background: red !important; border-color:red !important; color:white !important; margin-top:15px">
                                        <span class="btn-label" style="font-size:13px !important;"><i class="fa fa-arrow-left"></i></span>Back</a>
                                        <a type="button" id="registerbutton" class="btn btn-labeled btn-info" title="Submit" style="background: green !important; border-color:green !important; color:white !important; margin-top:15px ">
                                        <span class="btn-label" style="font-size:13px !important;"><i class="fa fa-check"></i></span>Submit</a>
                                        <a type="button" class="btn btn-labeled btn-info" onclick="DoAction('tab3');" title="next" style="background: #4d94ff !important; border-color:#4d94ff !important; color:white !important; margin-top:15px">
                                        <span class="btn-label" style="font-size:13px !important;"><i class="fa fa-arrow-right"></i></span>Next</a>

                                    </div>
                                </div>

                            </section>

                        </div>

                        <div id="tab3">
                            <section class="section">


                                <div class="section-body mt-0">


                                    <div class="row">
                                            <div class="col-12">

                                                <a type="button" style="font-size:15px;" class="btn btn-success btn-lg" title="Create" id="expcb"  href="{{ route('Registration.create',['urd' => 'exp']) }}" >Add Experience Profile <i class="fa fa-plus" aria-hidden="true"></i></a>

                                                <div class="card mt-0">


                                                    <div class="card-body">
                          


                                                        <div class="table-wrapper">
                                                            <div class="table-responsive">
                                                                <table class="table table-bordered" id="align4">
                                                                <thead>
                                                                    <tr>
                                                                    <th>Sl.No</th>
                                                                    <th>Work Experience in years</th>
                                                                    <th>Relevent work experience</th>
                                                                    <th>No of Certification</th>
                                                                    <th>Status</th>
                                                                    <th>Action</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                
                                                                    <tr>
                                                                    <td></td>
                                                                    <td></td>
                                                                    <td></td>
                                                                    <td></td>
                                                                    <td></td>
                                                                    <input type="hidden" class="cexpexperience" id="expexperience" value="">

                                                                  
                                                                    <td>
                                                                        <form action="{{ route('destroyexp',1) }}" method="POST">
                                                                        <a class="btn btn-link" title="Edit" href="{{route('expedit',1) }}"><i class="fas fa-pencil-alt" style="color:darkblue"></i></a>
                                                                        <a class="btn btn-link" title="show" href="{{route('expshow',1) }}"><i class="fas fa-eye" style="color:blue"></i></a>
                                                                        @csrf
                                                                        <button type="submit" title="Delete" onclick="return confirm('Are you sure you want to delete this Experience details ? You may Delelting the Critical  data');" class="btn btn-link"><i class="far fa-trash-alt" style="color:red"></i></button>
                                                                    </form>
                                                                    </td>
                                                                    </tr>
                                                                    
                                                                    <input type="hidden" class="cexpexperience" id="expexperience" value="0">
                                                                </tbody>
                                                                </table>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                   


                                        <div class="col-lg-12 text-center ">

                                            <a type="button" class="btn btn-labeled btn-info" onclick="DoAction('tab2');" title="back" style="background: red !important; border-color:red !important; color:white !important; margin-top:15px">
                                            <span class="btn-label" style="font-size:13px !important;"><i class="fa fa-arrow-left"></i></span>Back</a>
                                            <a type="button" id="registerbutton" class="btn btn-labeled btn-info" title="Submit" style="background: green !important; border-color:green !important; color:white !important; margin-top:15px">
                                        <span class="btn-label" style="font-size:13px !important;"><i class="fa fa-check"></i></span>Submit</a>
                                            <a type="button" class="btn btn-labeled btn-info" onclick="DoAction('tab4');" title="next" style="background: #4d94ff !important; border-color:#4d94ff !important; color:white !important; margin-top:15px">
                                            <span class="btn-label" style="font-size:13px !important;"><i class="fa fa-arrow-right"></i></span>Next</a>

                                        </div>
                                    </div>
                                </div>
                            </section>
                        </div>

                        <div id="tab4">
                            <section class="section">


                                <div class="section-body mt-0">


                                    <div class="row">
                                        <div class="col-12">
                                        <a type="button" style="font-size:15px;" class="btn btn-success btn-lg" title="Create" id="eligcb" href="{{ route('Registration.create') }}" data-toggle="modal" data-target="#addeligModal">Add Eligible Criteria <i class="fa fa-plus" aria-hidden="true"></i></a>

                                        <div class="card mt-0">


                                            <div class="card-body">

                                        
                             
                                            <div class="table-wrapper">
                                            <div class="table-responsive">
                                                <table class="table table-bordered" id="align">
                                                <thead>
                                                    <tr>
                                                    <th>Sl.No</th>
                                                    <th>Question1 </th>
                                                    <th>Answer </th>
                                                    
                                                    <th>Status</th>
                                                    <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                
                                                    <tr>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <input type="hidden" class="celigqa" id="eligqa" value="">

                                                    <td>New</td>
                                                    <td>
                                                  
                                                        <form action="{{ route('Registration.destroy',1) }}" method="POST">
                                                        <a class="btn btn-link" title="Edit" href="{{route('Registration.edit',1) }}" data-toggle="modal" data-target="#editeligeModal"><i class="fas fa-pencil-alt" style="color:darkblue"></i></a>
                                                        <a class="btn btn-link" title="show" href="{{route('Registration.show',1) }}"  data-toggle="modal" data-target="#showeligeModal"><i class="fas fa-eye" style="color:blue"></i></a>
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" title="Delete" onclick="return confirm('Are you sure you want to delete this Technical Profile ? You may Delelting the Critical  data');" class="btn btn-link"><i class="far fa-trash-alt" style="color:red"></i></button>
                                                        </form>
                                                    </td>

                                                    </tr>
                                               
                                                <input type="hidden" class="celigqa" id="eligqa" value="0">

                                                </tbody>
                                                </table>
                                            </div>
                                            </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>


                                <!-- final submit button -->




                                <!-- final submit button -->
                        

                                <div class="col-lg-12" id="register">

                                    <form action="" method="POST">
                                        @csrf

                                      <div class="col-md-12 text-center">

                                        <input type="hidden" class="form-control" required id="reg_status" name="reg_status" value="">
                                        <input type="hidden" class="form-control" required id="user_id" name="user_id" value="">
                                        <input type="hidden" class="form-control" name="registration_status" value="Registered">




                                        <a type="button" class="btn btn-labeled btn-info" onclick="DoAction('tab3');" title="next" style="background: red !important; border-color:red !important; color:white !important; margin-top:15px">
                                        <span class="btn-label" style="font-size:13px !important;"><i class="fa fa-arrow-left"></i></span>Back</a>

                                        <a type="button" id="registerbutton" class="btn btn-labeled btn-info" title="Submit" style="background: green !important; border-color:green !important; color:white !important; margin-top:15px">
                                        <span class="btn-label" style="font-size:13px !important;"><i class="fa fa-check"></i></span>Submit</a>

                                    </div>
                                    </form>
                                </div>


                                <div class="col-lg-12" id="registr">

                                    <form action="" method="POST">
                                    @csrf

                                    <div class="col-md-12 text-center">

                                        <input type="hidden" class="form-control" required id="reg_status" name="reg_status" value="">
                                        <input type="hidden" class="form-control" required id="user_id" name="user_id" value="">
                                        <input type="hidden" class="form-control" name="registration_status" value="Registered">
                                        <!-- <label style="color:black"><i><b>Please Click Submit to Complete Supplier Registration </b></i></label><br>
                                  
                                        <a type="button" id="registerbutton" class="btn btn-labeled btn-info" title="Submit" style="background: #4d94ff !important; border-color:#4d94ff !important; color:white !important">
                                        <span class="btn-label" style="font-size:13px !important;"><i class="fa fa-thumbs-up"></i></span>Submit</a> -->

                                    </div>
                                    </form>
                                </div>
                                

                                <div class="col-md-12 text-center">

                                    <input type="hidden" class="form-control" required id="reg_status" name="reg_status" value="">
                                    <input type="hidden" class="form-control" required id="user_id" name="user_id" value="">
                                    <input type="hidden" class="form-control" name="registration_status" value="Registered">




                               


                                </div>
                                </div>

                                            
                            </section>


                        </div>
                        <div class="col-md-12 text-center">
                        
                        </div>
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
       var gc = document.getElementById('fn').value;
       var eduid = document.getElementById('eduid').value;
       var eexp = document.getElementById('expexperience').value;
       var eligqa = document.getElementById('eligqa').value;
      
       if(gc == "0"){
        $('#addModal').modal('show');
        document.getElementById('gct').style.display = "none";
        document.getElementById('gcb').style.display = "inline-block";
        document.getElementById('gencheckbox').checked = false;
        }
        else{
                document.getElementById('gcb').style.display = "none";
                document.getElementById('gct').style.display = "inline-block";
                document.getElementById('gencheckbox').checked = true;
            }
            if(eduid == "0"){
        document.getElementById('educt').style.display = "none";
        document.getElementById('educb').style.display = "inline-block";
        document.getElementById('educheckbox').checked = false;
        }
        else{
                document.getElementById('educb').style.display = "none";
                document.getElementById('educt').style.display = "inline-block";
                document.getElementById('educheckbox').checked = true;
            }
            if(eexp == "0"){
        document.getElementById('expct').style.display = "none";
        document.getElementById('expcb').style.display = "inline-block";
        document.getElementById('expcheckbox').checked = false;
        }
        else{
                document.getElementById('expcb').style.display = "none";
                document.getElementById('expct').style.display = "inline-block";
                document.getElementById('expcheckbox').checked = true;
            }
            if(eligqa == "0"){
                
        document.getElementById('eligct').style.display = "none";
        document.getElementById('eligcb').style.display = "inline-block";
        document.getElementById('eligcheckbox').checked = false;
        }
        else{
                document.getElementById('eligcb').style.display = "none";
                document.getElementById('eligct').style.display = "inline-block";
                document.getElementById('eligcheckbox').checked = true;
            }
    $('#tabs a').click(function(e) {
      e.preventDefault();
      if ($(this).closest("li").attr("id") == "current") { //detection for current tab
        return;
      } else {
        $("#content").find("[id^='tab']").hide(); // Hide all content
        $("#tabs li").removeClass("active"); //Reset id's
        $(this).parent().addClass("active"); // Activate this
        $('#' + $(this).attr('name')).fadeIn(); // Show content for the current tab
        if(this.name =="tab1"){
            if(gc == "0"){
            $('#addModal').modal('show');
            }
            else{
                document.getElementById('gcb').style.display = "none";
            }
        }
        if(this.name =="tab2"){
            // window.location.href =" {{ route('educreate') }}";

        }
        if(this.name =="tab3"){
            // window.location.href =" {{ route('Registration.create',['urd' => 'exp']) }}";
        }
        if(this.name =="tab4"){
            if(eligqa == "0"){
            $('#addeligModal').modal('show');
        }
            else{
                document.getElementById('eligcb').style.display = "none";
            }
        }
      }
    });
       
       
});

    function DoAction(id) {

        $("#content").find("[id^='tab']").hide(); // Hide all content
    $("#tabs li").removeClass("active"); //Reset id's
    $("#tabs a").removeClass("active"); //Reset id's
    $("a[name='" + id + "']").parent().addClass("active");
    $('#' + (id)).fadeIn(); // Show content for the current tab

    }
</script>

<script>
   $(document).ready(function(){
    var user_id = "<?php echo $user_id; ?>"
    document.getElementById('user_id').value = user_id;
    var i = 0;
    var j = 0;
    var k = 0;
    var l = 0;
    $("#addug").click(function(){
     
      // $('#dynamic_field').append('<div id="rowphd"><div class=""><input type="text" name="name[]" placeholder="Enter your Name" class="form-control name_list"/></td><td><input type="text" name="email[]" placeholder="Enter your Email" class="form-control name_email"/></td><td></div>');  
        $('#dynamic_fieldug').append('<section class="input-box ug" name="a" id="rowug"><div class="educationug"> <div class="row"> <div class="col-md-4"><div class="form-group"><label>Graduation:<span class="error-star" style="color:red;">*</span></label><input type="text" class="form-control gradug" required id="graduationug" name="ug['+i+'][graduation]" value="Under Graduate" readonly> </div></div><div class="col-md-4"><div class="form-group"><label>(i)College Name:<span class="error-star" style="color:red;">*</span></label> <input type="text" class="form-control clgug" required id="college_nameug" name="ug['+i+'][college_name]"></div> </div> <div class="col-md-4"> <div class="form-group"> <label>(i)University Name:<span class="error-star" style="color:red;">*</span></label> <input type="text" class="form-control uniug" required id="university_nameug" name="ug['+i+'][university_name]"> </div> </div> </div> <div class="row"> <div class="col-md-4"> <div class="form-group"> <label>(i) Course Name:<span class="error-star" style="color:red;">*</span></label> <select class="form-control crsug" required id="course_nameug" name="ug['+i+'][course_name]"> <option value="0">Select-Course</option> <option value="civil">civil</option> <option value="architect">architect</option> <option value="townplanning">townplanning</option> </select> </div> </div> <!-- </div> <div class="row"> --> <div class="col-md-4"> <div class="form-group"> <label>(ii) Year of Passing <span class="error-star" style="color:red;">*</span></label> <input type="month" class="form-control ypug" maxlength="18" required id="yopug" name="ug['+i+'][yop]"> </div> </div> <div class="col-md-4"> <div class="form-group"> <label>(iii) Marks %:<span class="error-star" style="color:red;">*</span></label> <input type="text" class="form-control mkug" required id="m_percentageug" name="ug['+i+'][m_percentage]"> </div> </div> </div> <div class="row"> <h style="color:black"><b>Supporting Documents:</b></h> <div class="col-md-4"> <div class="form-group"> <label>(i) Consolidate Marksheet: <span class="error-star" style="color:red;">*</span></label> <input type="file" class="form-control ccug" required id="consolidate_markug" name="ug['+i+'][consolidate_mark]"> </div> </div> <!-- </div> <div class="row"> --> <div class="col-md-4"> <div class="form-group"> <label>(ii) Graduation Certificate:<span class="error-star" style="color:red;">*</span></label> <input type="file" class="form-control gcug" required id="garduation_certificateug" name="ug['+i+'][garduation_certificate]"> </div> </div> <div><button style="margin-top:30px" type="button" name="remove" id="ug" value='+i+' class="btn btn-danger btn_removeug">X</button></div> </div></div></section>'); 
        i++;
        $("#attachment_countug").val(i);
      
    });
    $("#addpg").click(function(){
     
      // $('#dynamic_field').append('<div id="rowpg"><div class=""><input type="text" name="name[]" placeholder="Enter your Name" class="form-control name_list"/></td><td><input type="text" name="email[]" placeholder="Enter your Email" class="form-control name_email"/></td><td></div>');  
        $('#dynamic_fieldpg').append('<section class="input-box pg" id="rowpg"><div class="educationpg"> <div class="row"> <div class="col-md-4"><div class="form-group"><label>Graduation:<span class="error-star" style="color:red;">*</span></label><input type="text" class="form-control gradpg" required id="graduationpg" name="pg['+j+'][graduation]" value="Post Graduation" readonly> </div></div><div class="col-md-4"><div class="form-group"><label>(i)College Name:<span class="error-star" style="color:red;">*</span></label> <input type="text" class="form-control clgpg" required id="college_namepg" name="pg['+j+'][college_name]"></div> </div> <div class="col-md-4"> <div class="form-group"> <label>(i)University Name:<span class="error-star" style="color:red;">*</span></label> <input type="text" class="form-control unipg" required id="university_namepg" name="pg['+j+'][university_name]"> </div> </div> </div> <div class="row"> <div class="col-md-4"> <div class="form-group"> <label>(i) Course Name:<span class="error-star" style="color:red;">*</span></label> <select class="form-control crspg" required id="course_namepg" name="pg['+j+'][course_name]"> <option value="0">Select-Course</option> <option value="civil">civil</option> <option value="architect">architect</option> <option value="townplanning">townplanning</option> </select> </div> </div> <!-- </div> <div class="row"> --> <div class="col-md-4"> <div class="form-group"> <label>(ii) Year of Passing <span class="error-star" style="color:red;">*</span></label> <input type="month" class="form-control yppg" maxlength="18" required id="yoppg" name="pg['+j+'][yop]"> </div> </div> <div class="col-md-4"> <div class="form-group"> <label>(iii) Marks %:<span class="error-star" style="color:red;">*</span></label> <input type="text" class="form-control mkpg" required id="m_percentagepg" name="pg['+j+'][m_percentage]"> </div> </div> </div> <div class="row"> <h style="color:black"><b>Supporting Documents:</b></h> <div class="col-md-4"> <div class="form-group"> <label>(i) Consolidate Marksheet: <span class="error-star" style="color:red;">*</span></label> <input type="file" class="form-control ccpg" required id="consolidate_markpg" name="pg['+j+'][consolidate_mark]"> </div> </div> <!-- </div> <div class="row"> --> <div class="col-md-4"> <div class="form-group"> <label>(ii) Graduation Certificate:<span class="error-star" style="color:red;">*</span></label> <input type="file" class="form-control gcpg" required id="garduation_certificatepg" name="pg['+j+'][garduation_certificate]"> </div> </div> <div><button style="margin-top:30px" type="button" name="remove" id="pg" value='+j+' class="btn btn-danger btn_removepg">X</button></div> </div></div></section>'); 
        j++;
        $("#attachment_countpg").val(j);
    });
    $("#adddip").click(function(){
      
      // $('#dynamic_field').append('<div id="rowdip"><div class=""><input type="text" name="name[]" placeholder="Enter your Name" class="form-control name_list"/></td><td><input type="text" name="email[]" placeholder="Enter your Email" class="form-control name_email"/></td><td></div>');  
        $('#dynamic_fielddip').append('<section class="input-box dip" id="rowdip"><div class="educationdip"> <div class="row"> <div class="col-md-4"><div class="form-group"><label>Graduation:<span class="error-star" style="color:red;">*</span></label><input type="text" class="form-control graddip" required id="graduationdip" name="dip['+k+'][graduation]" value="Diploma" readonly> </div></div><div class="col-md-4"><div class="form-group"><label>(i)College Name:<span class="error-star" style="color:red;">*</span></label> <input type="text" class="form-control clgdip" required id="college_namedip" name="dip['+k+'][college_name]"></div> </div> <div class="col-md-4"> <div class="form-group"> <label>(i)University Name:<span class="error-star" style="color:red;">*</span></label> <input type="text" class="form-control unidip" required id="university_namedip" name="dip['+k+'][university_name]"> </div> </div> </div> <div class="row"> <div class="col-md-4"> <div class="form-group"> <label>(i) Course Name:<span class="error-star" style="color:red;">*</span></label> <select class="form-control crsdip" required id="course_namedip" name="dip['+k+'][course_name]"> <option value="0">Select-Course</option> <option value="civil">civil</option> <option value="architect">architect</option> <option value="townplanning">townplanning</option> </select> </div> </div> <!-- </div> <div class="row"> --> <div class="col-md-4"> <div class="form-group"> <label>(ii) Year of Passing <span class="error-star" style="color:red;">*</span></label> <input type="month" class="form-control ypdip" maxlength="18" required id="yopdip" name="dip['+k+'][yop]"> </div> </div> <div class="col-md-4"> <div class="form-group"> <label>(iii) Marks %:<span class="error-star" style="color:red;">*</span></label> <input type="text" class="form-control mkdip" required id="m_percentagedip" name="dip['+k+'][m_percentage]"> </div> </div> </div> <div class="row"> <h style="color:black"><b>Supporting Documents:</b></h> <div class="col-md-4"> <div class="form-group"> <label>(i) Consolidate Marksheet: <span class="error-star" style="color:red;">*</span></label> <input type="file" class="form-control ccdip" required id="consolidate_markdip" name="dip['+k+'][consolidate_mark]"> </div> </div> <!-- </div> <div class="row"> --> <div class="col-md-4"> <div class="form-group"> <label>(ii) Graduation Certificate:<span class="error-star" style="color:red;">*</span></label> <input type="file" class="form-control gcdip" required id="garduation_certificatedip" name="dip['+k+'][garduation_certificate]"> </div> </div> <div><button style="margin-top:30px" type="button" name="remove" id="dip" value='+k+' class="btn btn-danger btn_removedip">X</button></div> </div></div></section>'); 
        k++;
        $("#attachment_countdip").val(k);
    });
    $("#addphd").click(function(){
      
      // $('#dynamic_field').append('<div id="rowphd"><div class=""><input type="text" name="name[]" placeholder="Enter your Name" class="form-control name_list"/></td><td><input type="text" name="email[]" placeholder="Enter your Email" class="form-control name_email"/></td><td></div>');  
        $('#dynamic_fieldphd').append('<section class="input-box phd" id="rowphd"><div class="educationphd"> <div class="row"> <div class="col-md-4"><div class="form-group"><label>Graduation:<span class="error-star" style="color:red;">*</span></label><input type="text" class="form-control gradphd" required id="graduationphd" name="phd['+l+'][graduation]" value="Ph.D" readonly> </div></div><div class="col-md-4"><div class="form-group"><label>(i)College Name:<span class="error-star" style="color:red;">*</span></label> <input type="text" class="form-control clgphd" required id="college_namephd" name="phd['+l+'][college_name]"></div> </div> <div class="col-md-4"> <div class="form-group"> <label>(i)University Name:<span class="error-star" style="color:red;">*</span></label> <input type="text" class="form-control uniphd" required id="university_namephd" name="phd['+l+']university_name"> </div> </div> </div> <div class="row"> <div class="col-md-4"> <div class="form-group"> <label>(i) Course Name:<span class="error-star" style="color:red;">*</span></label> <select class="form-control crsphd" required id="course_namephd" name="phd['+l+'][course_name]"> <option value="0">Select-Course</option> <option value="civil">civil</option> <option value="architect">architect</option> <option value="townplanning">townplanning</option> </select> </div> </div> <!-- </div> <div class="row"> --> <div class="col-md-4"> <div class="form-group"> <label>(ii) Year of Passing <span class="error-star" style="color:red;">*</span></label> <input type="month" class="form-control ypphd" maxlength="18" required id="yopphd" name="phd['+l+'][yop]"> </div> </div> <div class="col-md-4"> <div class="form-group"> <label>(iii) Marks %:<span class="error-star" style="color:red;">*</span></label> <input type="text" class="form-control mkphd" required id="m_percentagephd" name="phd['+l+'][m_percentage]"> </div> </div> </div> <div class="row"> <h style="color:black"><b>Supporting Documents:</b></h> <div class="col-md-4"> <div class="form-group"> <label>(i) Consolidate Marksheet: <span class="error-star" style="color:red;">*</span></label> <input type="file" class="form-control ccphd" required id="consolidate_markphd" name="phd['+l+'][consolidate_mark]"> </div> </div> <!-- </div> <div class="row"> --> <div class="col-md-4"> <div class="form-group"> <label>(ii) Graduation Certificate:<span class="error-star" style="color:red;">*</span></label> <input type="file" class="form-control gcphd" required id="garduation_certificatephd" name="phd['+l+'][garduation_certificate]"> </div> </div> <div><button style="margin-top:30px" type="button" name="remove" id="phd" value='+l+' class="btn btn-danger btn_removephd">X</button></div> </div></div></section>'); 
        l++;
        $("#attachment_countphd").val(l);
    });

    $(document).on('click', '.btn_removeug', function(){  
      var button_id = $(this).attr("id");   
       i =  $('#attachment_count'+button_id+'').val(); 
      $('#row'+button_id+'').remove();  
      --i;
       $('#attachment_count'+button_id+'').val(i);
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
 });

 function testit(a) {
 
  var val =  a.value;
  if(val==="1"){
  $("#l1").css("background-color","green").css("color","white").css("font-weight","700");
    $("#l2").css("background-color","white").css("color","black").css("font-weight","700");
  }
  else{
    $("#l1").css("background-color","white").css("color","black").css("font-weight","700");
  $("#l2").css("background-color","red").css("color","white").css("font-weight","700");
  }
 
}

//test on radio change
$("body").on("change","input",function(e){
  testIt();
});

//test on load
testIt();

function delete1() {
    $.ajax({
            url: "{{ route('destroygen') }}",
            type: 'POST',
            data: {

                _token: '{{csrf_token()}}'
            },
            error: function() {
                alert('Something is wrong');
            },
            success: function(data) {

                swal({
                        title: "Success",
                        text: "Requisition Submitted Successfully",
                        type: "success"
                    },
                    function() {

                        window.location.href = "{{ url('Registration') }}";

                    }
                );
            }
        });

}

</script>

    
@include('Registration.generalcreate')

<!--  -->
@include('Registration.edit')
@include('Registration.show')

@endsection
