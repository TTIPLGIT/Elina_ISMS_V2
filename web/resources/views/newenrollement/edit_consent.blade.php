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

    /* body{
        background-color: white !important;
    } */
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
</style>

<div class="main-content">
{{ Breadcrumbs::render('newenrollment.edit',$rows[0]['enrollment_id']) }}

    <div class="row justify-content-center">

        <div class="col-lg-12 col-md-12">
            <div class="card" style="height:100%; padding: 15px; background-color:white">

                @foreach($rows as $key=>$row)
                <form action="{{route('newenrollment.update', $row['enrollment_id'])}}" method="POST" id="newenrollement" enctype="multipart/form-data">
                    {{ csrf_field() }}
                    @method('PUT')


                    <input type="hidden" id="btn_status" name="btn_status" value="">

                    <div class="tile" id="tile-1" style="margin-top:10px !important; margin-bottom:10px !important;">

                        <!-- Nav tabs -->
                        <ul class="nav nav-tabs nav-justified" style="width:75%; margin:auto;" id="tabs" role="tablist">

                            <li class="nav-item" class="active">
                                <a class="nav-link" style="border: none;cursor: pointer;" id="home-tab" name="tab1" data-toggle="tab" role="tab" aria-controls="home" aria-selected="true"><i class="fa fa-home"></i><b style="padding: 2px;">Personal Details</b> <input type="checkbox" class="checkg" id="gencheckbox" name="nationality" value="0" onchange="submitval(this)" readonly style="background-color:solid green !important; color:green !important; visibility:hidden !important; ">
                                    <div class="check" id="gct"></div>
                                </a>

                            </li>

                            <li class="nav-item" class="">
                                <a class="nav-link" style="border: none;cursor: pointer;" id="contact-tab" name="tab3" data-toggle="tab" role="tab" aria-controls="contact" aria-selected="false"><i class="fas fa-map-signs"></i><b>General Questions</b> <input type="checkbox" class="checkg" id="expcheckbox" name="nationality" value="0" onchange="submitval(this)" style="background-color:solid green !important; color:green !important; visibility:hidden !important; ">
                                    <div class="check" id="expct"></div>
                                </a>
                            </li>


                        </ul>
                    </div>
                    <br>



                    <!-- Tab panes -->

                    <div class="tab-content" id="tab-content">
                        <div class="tab-pane fade show active" id="tab1" role="tabpanel" aria-labelledby="home-tab">


                            <section class="section">
                                <div class="section-body mt-1">
                                    <hr>
                                    <h5 style="font-weight: bold; display:flex;   width: fit-content; padding: -13px;margin-top: -18px;margin-left: auto;margin-right: auto;padding: 5px;background-color: white;">Personal Details</h5>

                                    <div class="row">
                                        <input type="hidden" id="selected_id" name="selected_id" value="">

                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label class="control-label" style="font-size: medium;">Child's Name: </label><span class="error-star" style="color:red;">*</span>
                                                <input class="form-control default" type="text" id="child_name" name="child_name" oninput="childName(event)" maxlength="20" value="{{ $row['child_name']}}" autocomplete="off">
                                                <input class="form-control default" type="hidden" id="enrollment_child_num" name="enrollment_child_num" value="{{ $row['enrollment_child_num']}}" autocomplete="off">
                                            </div>

                                        </div>


                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label class="control-label" style="font-size: medium;">Child's Date of Birth:</label><span class="error-star" style="color:red;">*</span>
                                                <input placeholder="dd-mm-yyyy" class="form dateformat child_dob" type="text" onfocus="(this.type='date')" id="child_dob" name="child_dob" value="{{ $row['child_dob']}}">
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <div class="form-group">

                                                <label class="control-label" style="font-size: medium;">Child's Gender:</label><span class="error-star" style="color:red;">*</span>
                                                <br>
                                                <input type="radio" id="child_gender" name="child_gender" value="Male" {{ ($row['child_gender']=="Male")? "checked" : "" }}><label for="featured-1" style="padding: 5px;">Male</label>


                                                <input type="radio" id="child_gender" name="child_gender" value="Female" {{ ($row['child_gender']=="Female")? "checked" : "" }}><label for="featured-2" style="padding: 5px;">Female</label>






                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="control-label" style="font-size: medium;">Child's Current School Name and Address: </label><span class="error-star" style="color:red;">*</span>
                                                <textarea class="form-control default child_school_name_address" type="textarea" id="child_school_name_address" name="child_school_name_address" value="{{ $row['child_school_name_address']}}" autocomplete="off">{{ $row['child_school_name_address']}}</textarea>
                                            </div>
                                        </div>

                                    </div>

                                    <hr>
                                    <h5 style="font-weight: bold; display:flex;   width: fit-content; padding: -13px;margin-top: -18px;margin-left: auto;margin-right: auto;padding: 5px;background-color: white;">Contact Details</h5>


                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="control-label" style="font-size: medium;">Child's Father/Guardian Name: </label><span class="error-star" style="color:red;">*</span>
                                                <input class="form-control default" type="text" id="child_father_guardian_name" name="child_father_guardian_name" oninput="childfatherName(event)" maxlength="20" value="{{ $row['child_father_guardian_name']}}" autocomplete="off">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="control-label" style="font-size: medium;">Child's Mother/Primary Caretaker's Name</label><span class="error-star" style="color:red;">*</span>
                                                <input class="form-control default" type="text" id="child_mother_caretaker_name" name="child_mother_caretaker_name" oninput="childmotherName(event)" maxlength="20" value="{{ $row['child_mother_caretaker_name']}}" autocomplete="off">
                                            </div>
                                        </div>






                                    </div>



                                    <div class="row">


                                        <div class="col-md-4">

                                            <div class="form-group">
                                                <label class="control-label" style="font-size: medium;">Email Address: </label><span class="error-star" style="color:red;">*</span>
                                                <input id="child_contact_email" type="email" class="form-control default readonly" name="child_contact_email" value="{{ $row['child_contact_email']}}" readonly>
                                                @error('email')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label class="control-label" style="font-size: medium;">Contact Phone Number: </label><span class="error-star" style="color:red;">*</span>
                                                <input class="form-control default readonly" type="text" id="child_contact_phone" minlength="10" maxlength="10" name="child_contact_phone" autocomplete="off" inputmode="numeric" oninput="contactphonenumber(event)" value="{{ $row['child_contact_phone']}}" readonly>
                                            </div>

                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label class="control-label" style="font-size: medium;">Alternative Phone Number: </label>
                                                <input class="form-control default" type="text" id="child_alter_phone" minlength="10" maxlength="10" name="child_alter_phone" autocomplete="off" inputmode="numeric" oninput="contactphonenumber(event)" value="{{ $row['child_alter_phone']}}" >
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="control-label" style="font-size: medium;">Address: </label><span class="error-star" style="color:red;">*</span>
                                                <textarea class="form-control default" type="textarea" id="child_contact_address" name="child_contact_address" value="{{ $row['child_contact_address']}}" autocomplete="off">{{ $row['child_contact_address']}}</textarea>

                                            </div>

                                        </div>



                                    </div>



                                </div>

                                <div class="col-md-12 text-center">
                                    @if($row['status'] != 'Submitted')
                                    <button type="button" onclick="save('saved')" name="status" value="Saved" id="savebutton" class="btn btn-labeled btn-succes" title="save" style="background: green !important; border-color:green !important; color:white !important">
                                        <span class="btn-label" style="font-size:13px !important;"><i class="fa fa-check"></i></span> Save</button>
                                    @endif

                                    <button class="btn btn-primary" type="reset"><i class="fa fa-undo"></i> Clear</button>&nbsp;

                                    <a type="button" class="btn btn-labeled btn-info" onclick="DoAction('tab3');" title="next" style="background: #4d94ff !important; border-color:#4d94ff !important; color:white !important">
                                        <span class="btn-label" style="font-size:13px !important;"><i class="fa fa-arrow-right"></i></span>Next</a>


                                </div>
                            </section>

                        </div>

                        <div class="tab-pane fade show" id="tab3" role="tabpanel" aria-labelledby="contact-tab">



                            <section class="section">
                                <div class="section-body mt-1">
                                    <div class="row">
                                        

                                    <div class="col-md-6">
                                        
                                        <div class="form-group">
                                           
                                            <label class="control-label" style="font-weight: bold;">Q1.Service that you would want to avail from Elina? </label><span class="error-star" style="color:red;">*</span>

                                            <br>
                                            @if($subparant_data !='')
                                            @if(in_array('Consultancy and Referal',$subparant_data))
                                            <input type="checkbox" id="featured-3" name="services_from_elina[]" value="Consultancy and Referal"checked onchange="addval(this)"><label for="featured-3" style="padding: 5px;">Consultancy and Referal</label>
                                            @else
                                            <input type="checkbox" id="featured-3" name="services_from_elina[]" value="Consultancy and Referal" onchange="addval(this)"><label for="featured-3" style="padding: 5px;">Consultancy and Referal</label>
                                            
                                            @endif
                                            <br>
                                            @if(in_array('Assesment and Recommendation',$subparant_data))
                                            <input type="checkbox" id="featured-4" name="services_from_elina[]" value="Assesment and Recommendation"checked Fonchange="addval(this)"><label for="featured-4" style="padding: 5px;">Assesment and Recommendation</label>
                                            @else
                                            <input type="checkbox" id="featured-4" name="services_from_elina[]" value="Assesment and Recommendation" Fonchange="addval(this)"><label for="featured-4" style="padding: 5px;">Assesment and Recommendation</label>

                                            
                                            @endif
                                            <br>
                                            @if(in_array('Integrated 8 month Program',$subparant_data))
                                            <input type="checkbox" id="featured-11" name="services_from_elina[]" value="Integrated 8 month Program"checked onchange="addval(this)"><label for="featured-11" style="padding: 5px;">Integrated 8 month Program</label>
                                            @else
                                            <input type="checkbox" id="featured-11" name="services_from_elina[]" value="Integrated 8 month Program" onchange="addval(this)"><label for="featured-11" style="padding: 5px;">Integrated 8 month Program</label>
                                            
                                            @endif
                                            <br>
                                            <!-- @if(in_array('Dream Maping',$subparant_data))
                                            <input type="checkbox" id="featured-12" name="services_from_elina[]" value="Dream Maping" checked onchange="addval(this)"><label for="featured-12" style="padding: 5px;">Dream Maping</label>
                                            @else
                                            <input type="checkbox" id="featured-12" name="services_from_elina[]" value="Dream Maping"onchange="addval(this)"><label for="featured-12" style="padding: 5px;">Dream Maping</label>
                                            
                                            @endif
                                            <br>
                                            @if(in_array('Through HLC Admission',$subparant_data))
                                            <input type="checkbox" id="featured-13" name="services_from_elina[]" value="Through HLC Admission" checked onchange="addval(this)"><label for="featured-13" style="padding: 5px;">Through HLC Admission</label>
                                            @else
                                            <input type="checkbox" id="featured-13" name="services_from_elina[]" value="Through HLC Admission"onchange="addval(this)" disabled=""><label for="featured-13" style="padding: 5px;">Through HLC Admission</label>
                                                
                                            @endif -->
                                            @else
                                            
                                            <label for="featured-3" style="padding: 5px;display:flex">  <input type="checkbox" id="featured-3" name="services_from_elina[]"  value="Consultancy and Referal" onchange="addval(this)"style="margin-right: 0.3rem!important;">Consultancy and Referal</label>
                                            <label for="featured-4" style="padding: 5px;display:flex"> <input type="checkbox" id="featured-4" name="services_from_elina[]"  value="Assesment and Recommendation" Fonchange="addval(this)"style="margin-right: 0.3rem!important;">Assesment and Recommendation</label>
                                            <label for="featured-11" style="padding: 5px;display:flex"><input type="checkbox" id="featured-11" name="services_from_elina[]" value="Integrated 8 month Program" onchange="addval(this)"style="margin-right: 0.3rem!important;">Integrated 8 month Program</label>
                                            <!-- <label for="featured-12" style="padding: 5px;display:flex"><input type="checkbox" id="featured-12" name="services_from_elina[]"  value="Dream Maping" onchange="addval(this)"style="margin-right: 0.3rem!important;">Dream Maping</label> -->
                                            <!-- <label for="featured-13" style="padding: 5px;display:flex"><input type="checkbox" id="featured-13" name="services_from_elina[]" value="Through HLC Admission" onchange="addval(this)" style="margin-right: 0.3rem!important;">Through HLC Admission</label> -->
                                            @endif
                                            
                                            <br>

                                        </div>
                                    </div>
                                    

                                   
                                
                                    <div class="col-md-6">
                                        <div class="form-group">
                                   
                                            <label class="control-label" style="font-weight: bold;">Q2.How did you come to know about Elina? </label><span class="error-star" style="color:red;">*</span>

                                            <br>
                                            @if($knmabtelina_data !='')
                                            @if(in_array('From a Friend',$knmabtelina_data))
                                            <input type="checkbox" id="featured-5" name="how_knowabt_elina[]" value="From a Friend" checked onchange="addval(this)" ><label for="featured-5" style="padding: 5px;">From a Friend</label>
                                            @else
                                            <input type="checkbox" id="featured-5" name="how_knowabt_elina[]" value="From a Friend" onchange="addval(this)" ><label for="featured-5" style="padding: 5px;">From a Friend</label>
                                            @endif
                                            <br>
                                            @if(in_array("Recommended by Child's therapist",$knmabtelina_data ))
                                            <input type="checkbox" id="featured-6" name="how_knowabt_elina[]" value="Recommended by Child's therapist" checked Fonchange="addval(this)"><label for="featured-6" style="padding: 5px;">Recommended by Child's therapist</label>
                                            @else
                                            <input type="checkbox" id="featured-6" name="how_knowabt_elina[]" value="Recommended by Child's therapist"Fonchange="addval(this)"><label for="featured-6" style="padding: 5px;">Recommended by Child's therapist</label>
                                            @endif
                                            <br>
                                            @if(in_array("Through Elina's Website",$knmabtelina_data ))
                                            <input type="checkbox" id="featured-7" name="how_knowabt_elina[]" value="Through Elina's Website"checked onchange="addval(this)"><label for="featured-7" style="padding: 5px;">Through Elina Website</label>
                                            @else
                                            <input type="checkbox" id="featured-7" name="how_knowabt_elina[]" value="Through Elina's Website" onchange="addval(this)"><label for="featured-7" style="padding: 5px;">Through Elina Website</label>
                                            @endif
                                            <br>
                                            @if(in_array('Through HLC Admission',$knmabtelina_data ))
                                            <input type="checkbox" id="featured-8" name="how_knowabt_elina[]" value="Through HLC Admission"checked onchange="addval(this)"><label for="featured-8" style="padding: 5px;">Through HLC Admission</label>
                                            @else
                                            <input type="checkbox" id="featured-8" name="how_knowabt_elina[]" value="Through HLC Admission" onchange="addval(this)"><label for="featured-8" style="padding: 5px;">Through HLC Admission</label>
                                            @endif
                                            <br>
                                            
                                            @if(in_array('Through Facebook and Social Media',$knmabtelina_data ))
                                            <input type="checkbox" id="featured-9" name="how_knowabt_elina[]" value="Through Facebook and Social Media"checked onchange="addval(this)"><label for="featured-9" style="padding: 5px;">Through Facebook and Social Media</label>
                                            @else
                                            <input type="checkbox" id="featured-9" name="how_knowabt_elina[]" value="Through Facebook and Social Media" onchange="addval(this)"><label for="featured-9" style="padding: 5px;">Through Facebook and Social Media</label>
                                            @endif
                                            <br>
                                            @if(in_array('Through Beyond 8',$knmabtelina_data ))
                                            <input type="checkbox" id="featured-10" name="how_knowabt_elina[]" value="Through Beyond 8"checked onchange="addval(this)"><label for="featured-10" style="padding: 5px;">Through Beyond 8</label>
                                            @else
                                            <input type="checkbox" id="featured-10" name="how_knowabt_elina[]" value="Through Beyond 8" onchange="addval(this)"><label for="featured-10" style="padding: 5px;">Through Beyond 8</label>
                                            @endif

                                            @else

                                            


                                            <label for="featured-5" style="padding: 5px;display:flex"><input type="checkbox" id="featured-5" name="how_knowabt_elina[]" value="From a Friend" onchange="addval(this)" class="questionpadding"style="margin-right: 0.3rem!important;">From a Friend</label>

                                            <label for="featured-6" style="padding: 5px;display:flex"><input type="checkbox" id="featured-6" name="how_knowabt_elina[]" value="Recommended by Child's therapist" Fonchange="addval(this)"style="margin-right: 0.3rem!important;">Recommended by Child's therapist</label>

                                            <label for="featured-7" style="padding: 5px;display:flex"><input type="checkbox" id="featured-7" name="how_knowabt_elina[]" value="Through Elina's Website" onchange="addval(this)"style="margin-right: 0.3rem!important;">Through Elina's Website</label>

                                            <label for="featured-8" style="padding: 5px;display:flex"><input type="checkbox" id="featured-8" name="how_knowabt_elina[]" value="Through HLC Admission" onchange="addval(this)"style="margin-right: 0.3rem!important;">Through HLC Admission</label>

                                            <label for="featured-9" style="padding: 5px;display:flex"><input type="checkbox" id="featured-9" name="how_knowabt_elina[]" value="Through Facebook and Social Media" onchange="addval(this)"style="margin-right: 0.3rem!important;">Through Facebook and Social Media</label>

                                            <label for="featured-10" style="padding: 5px;display:flex"><input type="checkbox" id="featured-10" name="how_knowabt_elina[]" value="Through Beyond 8" onchange="addval(this)"style="margin-right: 0.3rem!important;">Through Beyond 8</label>

                                            @endif

                                        </div>
                                    </div>




                                    </div>
                                </div>
                                <div class="col-md-12 text-center">

                                    <a type="button" class="btn btn-labeled btn-info" onclick="DoAction('tab1');" title="back" style="background: blue !important; border-color:blue !important; color:white !important">
                                        <span class="btn-label" style="font-size:13px !important;"><i class="fa fa-arrow-left"></i></span> Back</a>


                                        <a type="button" onclick="submit('submitted')" id="submitbutton" class="btn btn-labeled btn-succes" title="submit" style="background: green !important; border-color:green !important; color:white !important">
                                        <span class="btn-label" style="font-size:13px !important;"><i class="fa fa-check"></i></span> Submit</a>
                                    <button class="btn btn-primary" type="reset"><i class="fa fa-undo"></i> Clear</button>&nbsp;


                                </div>
                            </section>

                        </div>




                    </div>



                </form>
                @endforeach
            </div>

        </div>


    </div>
</div>


<script>
</script>
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
<script type="application/javascript">
    var inputs = document.querySelectorAll('.file-input')

    for (var i = 0, len = inputs.length; i < len; i++) {
        customInput(inputs[i])
    }

    function customInput(el) {
        const fileInput = el.querySelector('[type="file"]')
        const label = el.querySelector('[data-js-label]')

        fileInput.onchange =
            fileInput.onmouseout = function() {
                if (!fileInput.value) return

                var value = fileInput.value.replace(/^.*[\\\/]/, '')
                el.className += ' -chosen'
                label.innerText = value
            }
    }
    //validation

    function childName(event) {
        let value = event.target.value || '';
        value = value.replace(/[^a-z A-Z ]/, '', );
        event.target.value = value;

    }

    function childfatherName(event) {
        let value = event.target.value || '';
        value = value.replace(/[^a-z A-Z ]/, '', );
        event.target.value = value;

    }

    function childmotherName(event) {
        let value = event.target.value || '';
        value = value.replace(/[^a-z A-Z ]/, '', );
        event.target.value = value;

    }

    function contactphonenumber(event) {
        let value = event.target.value || '';
        value = value.replace(/[^0-9+ ]/, '', );
        event.target.value = value;

    }

    function save(a) {

        var status = a;
        var child_name = $('#child_name').val();

        if (child_name == '') {
            swal.fire("Please Enter Child's Name: ", "", "error");
            return false;
        }

        var child_dob = $('.child_dob').val();

        if (child_dob == '') {
            swal.fire("Please Enter Child's Date of Birth:", "", "error");
            return false;
        }

        var child_gender = $('input[name="child_gender"]:checked').val();



        if (child_gender !== "Male" && child_gender !== "Female") {

            swal.fire({
                title: "Error",
                text: "select Child's Gender",
                type: 'error',
                confirmButtontext: "OK"
            });

            return false;

        }

        var child_school_name_address = $('.child_school_name_address').val();

        if (child_school_name_address == '') {
            swal.fire("Please Enter Child's current school name and address:", "", "error");
            return false;
        }

        var child_father_guardian_name = $('#child_father_guardian_name').val();

        if (child_father_guardian_name == '') {
            swal.fire("Please Enter Child's Father/ Guardian Name:  ", "", "error");
            return false;
        }

        var child_mother_caretaker_name = $('#child_mother_caretaker_name').val();

        if (child_mother_caretaker_name == '') {
            swal.fire("Please Enter Child's Mother/Primary caretaker's Name:  ", "", "error");
            return false;
        }

        var child_contact_email = $('#child_contact_email').val();

        if (child_contact_email == '') {
            swal.fire("Please Enter Email Address:  ", "", "error");
            return false;
        }

        var child_contact_phone = $('#child_contact_phone').val();

        if (child_contact_phone == '') {
            swal.fire("Please Enter Contact Phone number:  ", "", "error");
            return false;
        }
        let testmobile = /^[+0-9]{10,15}/;

        if (!testmobile.test(child_contact_phone)) {
            swal.fire("Please Enter Valid Contact Number:", "", "error");
            return false;
        }
        var child_contact_address = $('#child_contact_address').val();

        if (child_contact_address == '') {
            swal.fire("Please Enter Address:  ", "", "error");
            return false;
        }


        document.getElementById('btn_status').value = 'saved';

        document.getElementById('newenrollement').submit('saved');
    }

    function submit() {

        var child_name = $('#child_name').val();

        if (child_name == '') {
            swal.fire("Please Enter Child's Name: ", "", "error");
            return false;
        }

        var child_dob = $('.child_dob').val();

        if (child_dob == '') {
            swal.fire("Please Enter Child's Date of Birth:", "", "error");
            return false;
        }

        var child_gender = $('input[name="child_gender"]:checked').val();



        if (child_gender !== "Male" && child_gender !== "Female") {

            swal.fire({
                title: "Error",
                text: "select Child's Gender",
                type: 'error',
                confirmButtontext: "OK"
            });

            return false;

        }

        var child_school_name_address = $('.child_school_name_address').val();

        if (child_school_name_address == '') {
            swal.fire("Please Enter Child's current school name and address:", "", "error");
            return false;
        }

        var child_father_guardian_name = $('#child_father_guardian_name').val();

        if (child_father_guardian_name == '') {
            swal.fire("Please Enter Child's Father/ Guardian Name:  ", "", "error");
            return false;
        }

        var child_mother_caretaker_name = $('#child_mother_caretaker_name').val();

        if (child_mother_caretaker_name == '') {
            swal.fire("Please Enter Child's Mother/Primary caretaker's Name:  ", "", "error");
            return false;
        }

        var child_contact_email = $('#child_contact_email').val();

        if (child_contact_email == '') {
            swal.fire("Please Enter Email Address:  ", "", "error");
            return false;
        }
        let testemail = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;

        if (!testemail.test(child_contact_email)) {
            swal.fire("Please Enter Valid Email Adress:", "", "error");
            return false;
        }
        var child_contact_phone = $('#child_contact_phone').val();

        if (child_contact_phone == '') {
            swal.fire("Please Enter Contact Phone number:  ", "", "error");
            return false;
        }
        let testmobile = /^[+0-9]{10,15}/;

        if (!testmobile.test(child_contact_phone)) {
            swal.fire("Please Enter Valid Contact Number:", "", "error");
            return false;
        }
        var child_contact_address = $('#child_contact_address').val();

        if (child_contact_address == '') {
            swal.fire("Please Enter Address:  ", "", "error");
            return false;
        }

        var featured3 = document.getElementById("featured-3");
        var featured4 = document.getElementById("featured-4");
        var featured11 = document.getElementById("featured-11");
        var featured12 = document.getElementById("featured-12");
        var featured13 = document.getElementById("featured-13");


        if ((featured3.checked == false) && (featured4.checked == false) && (featured11.checked == false) && (featured12.checked == false) && (featured13.checked == false)) {

            swal.fire({
                title: "Error",
                text: "Please Select atleast one Question from Services from Elina",
                type: 'error',
                confirmButtontext: "OK"
            });

            return false;

        }


        var featured5 = document.getElementById("featured-5");
        var featured6 = document.getElementById("featured-6");
        var featured7 = document.getElementById("featured-7");
        var featured8 = document.getElementById("featured-8");
        var featured9 = document.getElementById("featured-9");
        var featured10 = document.getElementById("featured-10");

        if ((featured5.checked == false) && (featured6.checked == false) && (featured7.checked == false) && (featured8.checked == false) && (featured9.checked == false) && (featured10.checked == false)) {

            swal.fire({
                title: "Error",
                text: "Please Select atleast one Qusetion from About Elina",
                type: 'error',
                confirmButtontext: "OK"
            });

            return false;

        }
        document.getElementById('btn_status').value = 'Submitted';

        document.getElementById('newenrollement').submit();
    }
</script>


@endsection