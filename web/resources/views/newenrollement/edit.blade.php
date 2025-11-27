
@extends('layouts.parent')

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

    .page {
        margin: 50px;
        background: white;
    }

    .container {
        display: flex;
        flex-direction: column;
        box-sizing: border-box;
        max-height: 500px !important;
    }

    .container__heading {
        padding: 1rem 0;
        border-bottom: 1px solid #ccc;
        text-align: center;
    }

    .container__heading>h2 {
        font-size: 1.75rem;
        line-height: 1.75rem;
        margin: 0;
    }

    .container__content {
        flex-grow: 1;
        overflow-y: scroll;
        margin: 25px;
    }

    .container__nav {
        border-top: 1px solid #ccc;
        text-align: center;
        font-size: 16px;
        font-weight: bold;
        padding: 2rem 0 1rem;
    }

    .container__nav1 {
        border-top: 1px solid #ccc;
    }

    .container__nav>.button {
        background-color: #444499;
        box-shadow: 0rem 0.5rem 1rem -0.125rem rgba(0, 0, 0, 0.25);
        padding: 0.8rem 2rem;
        border-radius: 0.5rem;
        color: #fff;
        text-decoration: none;
        font-size: 0.9rem;
        transition: transform 0.25s, box-shadow 0.25s;
    }

    .container__nav>.button:hover {
        box-shadow: 0rem 0rem 1rem -0.125rem rgba(0, 0, 0, 0.25);
        transform: translateY(-0.5rem);
    }

    .container__nav>small {
        color: #777;
        margin-right: 1rem;
    }

    .hidden {
        display: none;
    }

    .phoneStyle {
        padding-left: 83px;
        border-radius: 5px !important;
        border-color: #bec4d0 !important;
        box-shadow: 2px 2px 4px rgba(0, 0, 0, 0.15);
        border-style: outset;
        height: 40px;
        display: block;
        font-size: 1rem;
        font-weight: 400;
        line-height: 1.5;
        color: #495057;
        background-color: #fff;
        background-clip: padding-box;
        border: 1px solid #ced4da;
        border-radius: 0.25rem;
        -webkit-transition: border-color .15s ease-in-out, -webkit-box-shadow .15s ease-in-out;
        transition: border-color .15s ease-in-out, -webkit-box-shadow .15s ease-in-out;
        transition: border-color .15s ease-in-out, box-shadow .15s ease-in-out;
        transition: border-color .15s ease-in-out, box-shadow .15s ease-in-out, -webkit-box-shadow .15s ease-in-out;
    }
</style>

<div class="main-content">
    @if (session('success'))
    <input type="hidden" name="session_data" id="session_data" class="session_data" value="{{ session('success') }}">
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

    @if($consent_flag == 1 && $rows[0]['status'] != 'saved')
    <script type="text/javascript">
        window.onload = function() {
            DoAction('tab3');
            Swal.fire('Info!', 'You have been enrolled, Please Accept the Consent Form to proceed further', 'info');
        }
    </script>
    @endif
    {{ Breadcrumbs::render('newenrollment.edit',$rows[0]['enrollment_id']) }}

    <div class="row justify-content-center">
        <div class="col-12">
            <div class="card" style="height:100%; padding: 15px; background-color:white">
                <div class="col-lg-12 text-center" style="padding: 10px;">
                    <h4 style="color:darkblue;">Child Profile Edit Screen</h4>
                </div>
                @foreach($rows as $key=>$row)
                <form action="{{route('newenrollment.update', $row['enrollment_id'])}}" method="POST" id="newenrollement" enctype="multipart/form-data">
                    {{ csrf_field() }}
                    @method('PUT')
                    <input type="hidden" id="btn_status" name="btn_status" value="">
                    <div class="tile" id="tile-1" style="margin-top:10px !important; margin-bottom:10px !important;">

                        <ul class="nav nav-tabs" style="margin:auto;display: flex !important;justify-content: center !important;width: fit-content;" id="tabs" role="tablist">

                            <li class="nav-item" class="active">
                                <a class="nav-link" style="border: none;cursor: pointer;" id="home-tab" name="tab1" data-toggle="tab" role="tab" aria-controls="home" aria-selected="true"><i class="fa fa-home"></i><b style="padding: 2px;">Personal Details</b> <input type="checkbox" class="checkg" id="gencheckbox" name="nationality" value="0" onchange="submitval(this)" readonly style="background-color:solid green !important; color:green !important; visibility:hidden !important; ">
                                    <div class="check" id="gct"></div>
                                </a>
                            </li>

                            <li class="nav-item" class="">
                                <a class="nav-link" style="border: none;cursor: pointer;" id="contact-tab" name="tab2" data-toggle="tab" role="tab" aria-controls="contact" aria-selected="false"><i class="fas fa-map-signs"></i><b>General Questions</b> <input type="checkbox" class="checkg" id="expcheckbox" name="nationality" value="0" onchange="submitval(this)" style="background-color:solid green !important; color:green !important; visibility:hidden !important; ">
                                    <div class="check" id="expct"></div>
                                </a>
                            </li>

                            @if($consent_flag == 1)
                            <li class="nav-item" class="">
                                <a class="nav-link" style="border: none;cursor: pointer;" id="contact-tab" name="tab3" data-toggle="tab" role="tab" aria-controls="contact" aria-selected="false"><i class="fas fa-map-signs"></i><b>Consent Form</b> <input type="checkbox" class="checkg" id="expcheckbox" name="nationality" value="0" onchange="submitval(this)" style="background-color:solid green !important; color:green !important; visibility:hidden !important; ">
                                    <div class="check"></div>
                                </a>
                            </li>
                            @endif

                        </ul>
                    </div>
                    <br>



                    <!-- Tab panes -->

                    <div class="tab-content" id="tab-content">
                        <div class="tab-pane fade show active" id="tab1" role="tabpanel" aria-labelledby="home-tab">


                            <section class="section">
                                <div class="section-body mt-1">
                                    <hr>
                                    <h5 style="font-weight: bold; display:flex;   width: fit-content; padding: -13px;margin-top: -18px;margin-left: auto;margin-right: auto;padding: 5px;background-color: white;">Child Enrollment Details</h5>

                                    <div class="row">
                                        <input type="hidden" id="selected_id" name="selected_id" value="">

                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label class="control-label" style="font-size: medium;">Child's Name: </label><span class="error-star" style="color:red;">*</span>
                                                <input class="form-control default" type="text" id="child_name" name="child_name" oninput="childName(event)" maxlength="50" value="{{ $row['child_name']}}" autocomplete="off">
                                                <input class="form-control default" type="hidden" id="enrollment_child_num" name="enrollment_child_num" value="{{ $row['enrollment_child_num']}}" autocomplete="off">
                                            </div>

                                        </div>


                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label class="control-label" style="font-size: medium;">Child's Date of Birth:</label><span class="error-star" style="color:red;">*</span>
                                                @php
                                                $dob = !empty($row['child_dob']) ? \Carbon\Carbon::createFromFormat('d/m/Y', $row['child_dob'])->format('Y-m-d') : '';
                                                $today = \Carbon\Carbon::today()->format('Y-m-d');
                                                @endphp
                                                <input type="date" class="form-control dob_field" style="background-color: white !important;" placeholder="DD/MM/YYYY" autocomplete="off" id="child_dob" name="child_dob" value="{{ $dob }}" max="{{ $today }}" oninput="validateDublication()" onchange="validateDublication()">
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
                                                <label class="control-label" style="font-size: medium;">Child's Father/Guardian Name: </label>
                                                <input class="form-control default" type="text" id="child_father_guardian_name" name="child_father_guardian_name" oninput="childfatherName(event)" maxlength="50" value="{{ $row['child_father_guardian_name']}}" autocomplete="off">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="control-label" style="font-size: medium;">Child's Mother/Primary Caretaker's Name</label>
                                                <input class="form-control default" type="text" id="child_mother_caretaker_name" name="child_mother_caretaker_name" oninput="childmotherName(event)" maxlength="50" value="{{ $row['child_mother_caretaker_name']}}" autocomplete="off">
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
                                                <input class="/*phoneStyle*/ form-control" type="text" id="child_contact_phone" name="child_contact_phone" autocomplete="off" inputmode="numeric" oninput="contactphonenumber(event , 'one')" value="{{ $row['child_contact_phone']}}">
                                                <br><span id='phone_message_one'></span>
                                            </div>

                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label class="control-label" style="font-size: medium;">Alternative Phone Number: </label>
                                                <input class="/*phoneStyle*/ form-control default" type="text" id="child_alter_phone" name="child_alter_phone" autocomplete="off" inputmode="numeric" oninput="contactphonenumber(event , 'two')" value="{{ $row['child_alter_phone']}}">
                                                <br><span id='phone_message_two'></span>
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
                                    <button type="button" onclick="save('saved')" name="status" value="Saved" id="savebutton" class="btn btn-labeled btn-succes" title="Save" style="background: green !important; border-color:green !important; color:white !important">
                                        <span class="btn-label" style="font-size:13px !important;"><i class="fa fa-check"></i></span> Save</button>
                                    @endif
                                    <a type="button" href="{{ route('newenrollment.index') }}" class="btn btn-labeled responsive-button button-style cancel-button" title="Cancel">
                                        <i class="fas fa-times"></i><span> Cancel </span>
                                    </a>
                                    <a type="button" onclick="DoAction('tab2');" class="btn btn-labeled responsive-button next-button button-style" title="Next">
                                        <i class="fas fa-arrow-right"></i>
                                        <span> Next </span>
                                    </a>
                                </div>
                            </section>

                        </div>

                        <div class="tab-pane fade show" id="tab2" role="tabpanel" aria-labelledby="contact-tab">



                            <section class="section">
                                <div class="section-body mt-1">
                                    <div class="row">
                                        @if($rows[0]['flag'] == 0)
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="control-label" style="font-weight: bold;">Q1.Services that you would want to avail from Elina? </label><span class="error-star" style="color:red;">*</span>
                                                <br>
                                                @if($subparant_data !='')
                                                @if(in_array('Consultancy and Referal',$subparant_data))
                                                <input type="checkbox" id="featured-3" name="services_from_elina[]" value="Consultancy and Referal" checked onchange="addval(this)"><label for="featured-3" style="padding: 5px;">Consultancy and Referral</label>
                                                @else
                                                <input type="checkbox" id="featured-3" name="services_from_elina[]" value="Consultancy and Referal" onchange="addval(this)"><label for="featured-3" style="padding: 5px;">Consultancy and Referral</label>
                                                @endif
                                                <br>
                                                @if(in_array('Assesment and Recommendation',$subparant_data))
                                                <input type="checkbox" id="featured-4" name="services_from_elina[]" value="Assesment and Recommendation" checked Fonchange="addval(this)"><label for="featured-4" style="padding: 5px;">Assessment and Recommendation</label>
                                                @else
                                                <input type="checkbox" id="featured-4" name="services_from_elina[]" value="Assesment and Recommendation" Fonchange="addval(this)"><label for="featured-4" style="padding: 5px;">Assessment and Recommendation</label>
                                                @endif
                                                <br>
                                                @if(in_array('Integrated 8 month Program',$subparant_data))
                                                <input type="checkbox" id="featured-11" name="services_from_elina[]" value="Integrated 8 month Program" checked onchange="addval(this)"><label for="featured-11" style="padding: 5px;">Integrated 8 month Program</label>
                                                @else
                                                <input type="checkbox" id="featured-11" name="services_from_elina[]" value="Integrated 8 month Program" onchange="addval(this)"><label for="featured-11" style="padding: 5px;">Integrated 8 month Program</label>
                                                @endif
                                                <br>
                                                @if(in_array('Dream Mapping',$subparant_data))
                                                <input type="checkbox" id="featured-12" name="services_from_elina[]" value="Dream Mapping" checked onchange="addval(this)"><label for="featured-12" style="padding: 5px;">Dream Mapping</label>
                                                @else
                                                <input type="checkbox" id="featured-12" name="services_from_elina[]" value="Dream Mapping" onchange="addval(this)"><label for="featured-12" style="padding: 5px;">Dream Mapping</label>
                                                @endif
                                                <br>
                                                <!-- @if(in_array('Through HLC Admission',$subparant_data))
                                                <input type="checkbox" id="featured-13" name="services_from_elina[]" value="Through HLC Admission" checked onchange="addval(this)"><label for="featured-13" style="padding: 5px;">Through HLC Admission</label>
                                                @else
                                                <input type="checkbox" id="featured-13" name="services_from_elina[]" value="Through HLC Admission"onchange="addval(this)" disabled=""><label for="featured-13" style="padding: 5px;">Through HLC Admission</label>
                                                @endif -->
                                                @else
                                                <label for="featured-3" style="padding: 5px;display:flex"> <input type="checkbox" id="featured-3" name="services_from_elina[]" value="Consultancy and Referal" onchange="addval(this)" style="margin-right: 0.3rem!important;">Consultancy and Referral</label>
                                                <label for="featured-4" style="padding: 5px;display:flex"> <input type="checkbox" id="featured-4" name="services_from_elina[]" value="Assesment and Recommendation" Fonchange="addval(this)" style="margin-right: 0.3rem!important;">Assessment and Recommendation</label>
                                                <label for="featured-11" style="padding: 5px;display:flex"><input type="checkbox" id="featured-11" name="services_from_elina[]" value="Integrated 8 month Program" onchange="addval(this)" style="margin-right: 0.3rem!important;">Integrated 8 month Program</label>
                                                <label for="featured-12" style="padding: 5px;display:flex"><input type="checkbox" id="featured-12" name="services_from_elina[]" value="Dream Mapping" onchange="addval(this)" style="margin-right: 0.3rem!important;">Dream Mapping</label>
                                                <!-- <label for="featured-13" style="padding: 5px;display:flex"><input type="checkbox" id="featured-13" name="services_from_elina[]" value="Through HLC Admission" onchange="addval(this)" style="margin-right: 0.3rem!important;">Through HLC Admission</label> -->
                                                @endif
                                                <br>
                                            </div>
                                        </div>
                                        @else
                                        <div class="col-md-6">
                                            <div class="form-group questions">
                                                <label class="control-label">Q1.What is your expectation from Elina?</label><span class="error-star" style="color:red;">*</span>
                                                <textarea class="form-control default expectation" type="text" id="expectation" name="services_from_elina[]" value="{{ json_decode($rows[0]['services_from_elina'])->{0} }}" autocomplete="off">{{ json_decode($rows[0]['services_from_elina'])->{0} }}</textarea>

                                            </div>
                                        </div>
                                        @endif
                                       {{-- <div class="col-md-6">
                                            <div class="form-group">

                                                <label class="control-label" style="font-weight: bold;">Q2.How did you come to know about Elina? </label><span class="error-star" style="color:red;">*</span>

                                                @if($knmabtelina_data !='')
                                                    @if(in_array("Through Elina's Website",$knmabtelina_data ))
                                                    <input type="checkbox" id="featured-7" name="how_knowabt_elina[]" value="Through Elina's Website" checked onchange="addval(this)"><label for="featured-7" style="padding: 5px;">Elina Website</label>
                                                    @else
                                                    <input type="checkbox" id="featured-7" name="how_knowabt_elina[]" value="Through Elina's Website" onchange="addval(this)"><label for="featured-7" style="padding: 5px;">Elina Website</label>
                                                    @endif

                                                    <br>
                                                    @if(in_array('Through Facebook and Social Media',$knmabtelina_data ))
                                                    <input type="checkbox" id="featured-9" name="how_knowabt_elina[]" value="Through Facebook and Social Media" checked onchange="addval(this)"><label for="featured-9" style="padding: 5px;">Social Media</label>
                                                    @else
                                                    <input type="checkbox" id="featured-9" name="how_knowabt_elina[]" value="Through Facebook and Social Media" onchange="addval(this)"><label for="featured-9" style="padding: 5px;">Social Media</label>
                                                    @endif
                                                    <br>

                                                    @if(in_array('Through HLC Admission',$knmabtelina_data ))
                                                    <input type="checkbox" id="featured-8" name="how_knowabt_elina[]" value="Through HLC Admission" checked onchange="addval(this)"><label for="featured-8" style="padding: 5px;">Through HLC</label>
                                                    @else
                                                    <input type="checkbox" id="featured-8" name="how_knowabt_elina[]" value="Through HLC Admission" onchange="addval(this)"><label for="featured-8" style="padding: 5px;">Through HLC</label>
                                                    @endif
                                                    <br>

                                                    @if(in_array('Through Other School', $knmabtelina_data))
                                                    <input type="checkbox" id="featured-11" name="how_knowabt_elina[]" value="Through Other School" checked onchange="addval(this)">
                                                    <label for="featured-11" style="padding: 5px;">Through other schools</label>
                                                    @else
                                                    <input type="checkbox" id="featured-11" name="how_knowabt_elina[]" value="Through Other School" onchange="addval(this)">
                                                    <label for="featured-11" style="padding: 5px;">Through other schools</label>
                                                    @endif
                                                    <br>

                                                    @if(in_array('Through Other Parent', $knmabtelina_data))
                                                    <input type="checkbox" id="featured-12" name="how_knowabt_elina[]" value="Through Other Parent" checked onchange="addval(this)">
                                                    <label for="featured-12" style="padding: 5px;">Through other parents</label>
                                                    @else
                                                    <input type="checkbox" id="featured-12" name="how_knowabt_elina[]" value="Through Other Parent" onchange="addval(this)">
                                                    <label for="featured-12" style="padding: 5px;">Through other parents</label>
                                                    @endif
                                                    <br>

                                                    @if(in_array('From a Friend',$knmabtelina_data))
                                                    <input type="checkbox" id="featured-5" name="how_knowabt_elina[]" value="From a Friend" checked onchange="addval(this)"><label for="featured-5" style="padding: 5px;">Through friends</label>
                                                    @else
                                                    <input type="checkbox" id="featured-5" name="how_knowabt_elina[]" value="From a Friend" onchange="addval(this)"><label for="featured-5" style="padding: 5px;">Through friends</label>
                                                    @endif
                                                    <br>

                                                    @if(in_array("Recommended by Child's therapist",$knmabtelina_data ))
                                                    <input type="checkbox" id="featured-6" name="how_knowabt_elina[]" value="Recommended by Child's therapist" checked Fonchange="addval(this)"><label for="featured-6" style="padding: 5px;">Through my therapists</label>
                                                    @else
                                                    <input type="checkbox" id="featured-6" name="how_knowabt_elina[]" value="Recommended by Child's therapist" Fonchange="addval(this)"><label for="featured-6" style="padding: 5px;">Through my therapists</label>
                                                    @endif
                                                    <br>

                                                    @if(in_array('others', $knmabtelina_data))
                                                    <input type="checkbox" id="featured-13" name="how_knowabt_elina[]" value="Others" checked onchange="addval(this)">
                                                    <label for="featured-13" style="padding: 5px;">Others</label>
                                                    @else
                                                    <input type="checkbox" id="featured-13" name="how_knowabt_elina[]" value="Others" onchange="addval(this)">
                                                    <label for="featured-13" style="padding: 5px;">Others</label>
                                                    @endif
                                                    <br>
                                                    <!--  -->                                                
                                                    @if(in_array('Through Beyond 8',$knmabtelina_data ))
                                                    <input type="checkbox" id="featured-10" name="how_knowabt_elina[]" value="Through Beyond 8" checked onchange="addval(this)"><label for="featured-10" style="padding: 5px;">Through Beyond 8</label>
                                                    @endif

                                                @else
                                                    <label for="featured-7" style="padding: 5px;display:flex"><input type="checkbox" id="featured-7" name="how_knowabt_elina[]" value="Through Elina's Website" onchange="addval(this)" style="margin-right: 0.3rem!important;">Elina Website</label>
                                                    <label for="featured-9" style="padding: 5px;display:flex"><input type="checkbox" id="featured-9" name="how_knowabt_elina[]" value="Through Facebook and Social Media" onchange="addval(this)" style="margin-right: 0.3rem!important;">Social Media</label>
                                                    <label for="featured-8" style="padding: 5px;display:flex"><input type="checkbox" id="featured-8" name="how_knowabt_elina[]" value="Through HLC Admission" onchange="addval(this)" style="margin-right: 0.3rem!important;">Through HLC</label>
                                                    <label for="featured-11" style="padding: 5px; display:flex"><input type="checkbox" id="featured-11" name="how_knowabt_elina[]" value="Through Other School" onchange="addval(this)" style="margin-right: .3rem!important;">Through other schools</label>
                                                    <label for="featured-12" style="padding: 5px; display:flex"><input type="checkbox" id="featured-12" name="how_knowabt_elina[]" value="Through Other Parent" onchange="addval(this)" style="margin-right: .3rem!important;">Through other parents</label>
                                                    <label for="featured-5" style="padding: 5px;display:flex"><input type="checkbox" id="featured-5" name="how_knowabt_elina[]" value="From a Friend" onchange="addval(this)" class="questionpadding" style="margin-right: 0.3rem!important;">Through friends</label>
                                                    <label for="featured-6" style="padding: 5px;display:flex"><input type="checkbox" id="featured-6" name="how_knowabt_elina[]" value="Recommended by Child's therapist" Fonchange="addval(this)" style="margin-right: 0.3rem!important;">Through my therapists</label>
                                                    <label for="featured-13" style="padding: 5px; display:flex"><input type="checkbox" id="featured-13" name="how_knowabt_elina[]" value="Others" onchange="addval(this)" style="margin-right: .3rem!important;">Others</label>
                                                    <!--  -->
                                                    <!-- <label for="featured-10" style="padding: 5px;display:flex"><input type="checkbox" id="featured-10" name="how_knowabt_elina[]" value="Through Beyond 8" onchange="addval(this)" style="margin-right: 0.3rem!important;">Through Beyond 8</label>                                                 -->
                                                @endif
                                            </div>
                                        </div> --}}
                                       
                                        @php
    // Handle both array (JSON decoded) and single string formats
    if(!empty($knmabtelina_data)) {
        $knmabtelina_data_array = is_array($knmabtelina_data) 
            ? $knmabtelina_data 
            : (is_string($knmabtelina_data) && strpos($knmabtelina_data, '{') === 0 
                ? json_decode($knmabtelina_data, true) 
                : [$knmabtelina_data]);
    } else {
        $knmabtelina_data_array = [];
    }
@endphp

<div class="col-md-6">
    <div class="form-group">
        <label class="control-label" style="font-weight: bold;">
            Q2. How did you come to know about Elina? 
        </label>
        <span class="error-star" style="color:red;">*</span>

        <select id="how_knowabt_elina" name="how_knowabt_elina" class="form-control" required style="color: black;">
            <option value="">-- Select --</option>
            <option value="From a Friend" {{ in_array('From a Friend', $knmabtelina_data_array) ? 'selected' : '' }}>From a Friend</option>
            <option value="Recommended by Child's therapist" {{ in_array("Recommended by Child's therapist", $knmabtelina_data_array) ? 'selected' : '' }}>Recommended by Child's therapist</option>
            <option value="Through Elina's Website" {{ in_array("Through Elina's Website", $knmabtelina_data_array) ? 'selected' : '' }}>Through Elina's Website</option>
            <option value="Through HLC Admission" {{ in_array('Through HLC Admission', $knmabtelina_data_array) ? 'selected' : '' }}>Through HLC Admission</option>
            <option value="Through Facebook and Social Media" {{ in_array('Through Facebook and Social Media', $knmabtelina_data_array) ? 'selected' : '' }}>Through Facebook and Social Media</option>
            <option value="Through Beyond 8" {{ in_array('Through Beyond 8', $knmabtelina_data_array) ? 'selected' : '' }}>Through Beyond 8</option>
            <option value="others" {{ in_array('others', $knmabtelina_data_array) ? 'selected' : '' }}>Others</option>
        </select>
    </div>
</div>



                                    </div>
                                </div>
                                <div class="col-md-12 text-center">
                                    <a type="button" class="btn btn-labeled responsive-button button-style back-button" onclick="DoAction('tab1');" title="Back">
                                        <i class="fas fa-arrow-left"></i><span> Back </span>
                                    </a>
                                    {{-- @if($row['status'] != 'Submitted')
                                    <a type="button" onclick="submit('submitted')" id="submitbutton" class="btn btn-labeled btn-succes" title="Submit" style="background: green !important; border-color:green !important; color:white !important">
                                        <span class="btn-label" style="font-size:13px !important;"><i class="fa fa-check"></i></span> Submit</a>
                                    @endif --}}
                                    @if($row['status'] != 'Submitted')
                                    <button type="button" onclick="save('saved')" name="status" value="Saved" id="savebutton" class="btn btn-labeled btn-succes" title="Save" style="background: green !important; border-color:green !important; color:white !important">
                                        <span class="btn-label" style="font-size:13px !important;"><i class="fa fa-check"></i></span> Save</button>
                                    @endif
                                    @if($consent_flag == 0)
                                    <a type="button" onclick="submit('update')" id="submitbutton" class="btn btn-labeled btn-succes" title="Update" style="background: green !important; border-color:green !important; color:white !important">
                                        <span class="btn-label" style="font-size:13px !important;"><i class="fa fa-check"></i></span> Update</a>
                                    @endif
                                    <a type="button" href="{{ route('newenrollment.index') }}" class="btn btn-labeled responsive-button button-style cancel-button" title="Cancel">
                                        <i class="fas fa-times"></i><span> Cancel </span>
                                    </a>
                                    @if($consent_flag == 1)
                                    <!-- <button class="btn btn-primary" type="reset"><i class="fa fa-undo"></i> Clear</button>&nbsp; -->
                                    <a type="button" class="btn btn-labeled btn-info" onclick="DoAction('tab3');" title="Next" style="background: #4d94ff !important; border-color:#4d94ff !important; color:white !important">
                                        <span class="btn-label" style="font-size:13px !important;"><i class="fa fa-arrow-right"></i></span>Next</a>
                                    @endif
                                </div>
                            </section>

                        </div>

                        @if($consent_flag == 1)
                        <!-- Consent Form Tab -->
                        <div class="tab-pane fade show" id="tab3" role="tabpanel" aria-labelledby="contact-tab">
                            <div class="container">
                                <div class="container__nav1"></div>
                                <div class="container__content" id="terms-and-conditions">
                                    {!! $consent[0]['policy_content'] !!}
                                </div>

                            </div>
                            <div class="container__nav">
                                <label id="accept-label" /*class="hidden" * />
                                <input type="checkbox" name="consent_aggrement" value="Agreed" id="accept-checkbox" style="margin-right: 0.3rem!important;">I have read and accept the terms and conditions.
                                </label>
                            </div>
                            <div class="col-md-12 text-center">
                                <a type="button" class="btn btn-labeled responsive-button button-style back-button" onclick="DoAction('tab2');" title="Back">
                                    <i class="fas fa-arrow-left"></i><span> Back </span>
                                </a>
                                <a type="button" onclick="submit('Submitted')" id="accept-button" class="btn btn-labeled btn-succes disable-click" title="Submit" style="background: gray !important; color:white !important">
                                    <span class="btn-label" style="font-size:13px !important;"><i class="fa fa-check"></i></span> Submit</a>
                                <a type="button" onclick="submit('Declined')" id="decline-button" class="btn btn-labeled btn-succes" title="Decline" style="background: red !important; color:white !important">
                                    <span class="btn-label" style="font-size:13px !important;"><i class="fa fa-check"></i></span> Decline </a>
                                <!-- <button class="btn btn-primary" type="reset" style="height: 32px;"><i class="fa fa-undo"></i> Clear</button>&nbsp; -->
                            </div>

                        </div>
                        <!-- End Tab -->
                        @endif
                    </div>



                </form>
                @endforeach
            </div>

        </div>


    </div>
</div>

<script>
    var phone_number = document.querySelector("#child_contact_phone");
    var phone_number2 = document.querySelector("#child_alter_phone");

    var iti = window.intlTelInput(phone_number, {
        initialCountry: "in",
        separateDialCode: true,
        utilsScript: "//cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.3/js/utils.js"
    });

    var iti = window.intlTelInput(phone_number2, {
        initialCountry: "in",
        separateDialCode: true,
        utilsScript: "//cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.3/js/utils.js"
    });
</script>
<script>
    const termsContainer = document.querySelector('.container__content');
    const acceptLabel = document.querySelector('#accept-label');
    const checkbox = document.getElementById("accept-checkbox");
    const acceptButton = document.getElementById("accept-button");
    const declineButton = document.getElementById("decline-button");
    @if($consent_flag == 1)
    checkbox.addEventListener("change", () => {
        if (checkbox.checked) {
            // alert("You have accepted the terms and conditions.");
            swal.fire("You have accepted the terms and conditions. Please click on the submit button to proceed further.", "", "info");
            acceptButton.style.backgroundColor = "green";
            acceptButton.classList.remove('disable-click');

            declineButton.style.backgroundColor = "gray";
            declineButton.classList.add('disable-click');
        } else {
            swal.fire("For further processing, you must agree and click the submit button to proceed further", "", "info");
            acceptButton.style.backgroundColor = "gray";
            acceptButton.classList.add('disable-click');

            declineButton.style.backgroundColor = "red";
            declineButton.classList.remove('disable-click');
        }
    });
    @endif

    function checkScroll() {
        const scrollHeight = termsContainer.scrollHeight;
        const offsetHeight = termsContainer.offsetHeight;
        const scrollTop = termsContainer.scrollTop;
        if (scrollHeight === offsetHeight + scrollTop) {
            acceptLabel.classList.remove('hidden');
        } else {
            acceptLabel.classList.add('hidden');
        }
    }
</script>

<script type="text/javascript">
    $('.dob_field').datepicker({
        dateFormat: 'dd/mm/yy',
        maxDate: 0,
        changeMonth: true,
        changeYear: true,
    });
</script>
<script type="text/javascript">
    $(document).ready(function() {
        $("#content").find("[id^='tab']").hide();
        $("#home-tab").addClass("active");
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

        $("#tab-content").find("[id^='tab']").hide();
        $('#' + $(this).attr('name')).fadeIn();

    });
    var actWidth = $("#tile-1 .nav-tabs").find(".active").parent("li").width();
    var actPosition = $("#tile-1 .nav-tabs .active").position();

    function DoAction(id) {
        $("#tab-content").find("[id^='tab']").hide();
        $("#tabs a").removeClass("active");
        $("a[name='" + id + "']").addClass("active");
        var position = $("a[name='" + id + "']").position();
        var width = $("a[name='" + id + "']").width();
        $("#tile-1 .slider").css({
            "left": +position.left,
            "width": width
        });
        $('#' + (id)).fadeIn();
    }
</script>
<script type="application/javascript">
    //validation
    function childName(event) {
        let value = event.target.value || '';
        value = value.replace(/[^a-z A-Z ]/, '', );
        event.target.value = value;
        validateDublication();
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

    function contactphonenumber(event, field) {
        let value = event.target.value || '';
        value = value.replace(/[^0-9+ ]/, '', );
        event.target.value = value;

        if (field == 'one') {
            var p1 = window.intlTelInputGlobals.getInstance(phone_number).isValidNumber();
        } else if (field == 'two') {
            var p1 = window.intlTelInputGlobals.getInstance(phone_number2).isValidNumber();
        }

        if (p1 == true) {
            document.getElementById('phone_message_' + field).style.color = 'green';
            document.getElementById('phone_message_' + field).innerHTML = 'Valid Number';
        } else {
            document.getElementById('phone_message_' + field).style.color = 'red';
            document.getElementById('phone_message_' + field).innerHTML = 'Invalid Number';
        }
    }

    var validate = 0;

    function validateDublication() {
        var InputName = $('#child_name').val();
        var InputEmail = $('#child_contact_email').val();
        var InputDoB = $('#child_dob').val();
        // console.log(InputName, InputEmail , InputDoB);
        if (InputName != "" && InputDoB != "") {
            $.ajax({
                url: "{{ url('/validate/enrollment/user') }}",
                type: 'POST',
                data: {
                    'InputName': InputName,
                    'InputDoB': InputDoB,
                    _token: '{{csrf_token()}}'
                }
            }).done(function(data) {
                // console.log(data);
                validate = data;
            })
        }
    }

    function save() {
        var child_name = $('#child_name').val();
        if (child_name == '') {
            swal.fire("Please Enter Child's Name: ", "", "error");
            return false;
        }
        if (validate == 1) {
            swal.fire("You have Already Enrolled With Elina", "", "error");
            return false;
        }
        document.getElementById('btn_status').value = 'saved';
        $('.loader').show();
        document.getElementById('newenrollement').submit('saved');
    }

    function submit(a) {
        if (validate == 1) {
            swal.fire("You have Already Enrolled With Elina", "", "error");
            return false;
        }
        var child_name = $('#child_name').val();
        if (child_name == '') {
            swal.fire("Please Enter Child's Name: ", "", "error");
            return false;
        }

        var child_dob = $('#child_dob').val();
        if (child_dob == '') {
            swal.fire("Please Enter Child's Date of Birth:", "", "error");
            return false;
        }

        var child_gender = $('input[name="child_gender"]:checked').val();
        if (child_gender !== "Male" && child_gender !== "Female") {
            swal.fire("Please Select Child's Gender", "", "error");
            return false;

        }

        var child_school_name_address = $('.child_school_name_address').val();
        if (child_school_name_address == '') {
            swal.fire("Please Enter Child's current school name and address:", "", "error");
            return false;
        }

        var child_father_guardian_name = $('#child_father_guardian_name').val();
        var child_mother_caretaker_name = $('#child_mother_caretaker_name').val();

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

        var p1 = window.intlTelInputGlobals.getInstance(phone_number).isValidNumber();
        if (p1 == false) {
            swal("Please Enter Valid Contact Number", "", "error");
            return false;
        }

        var child_alter_phone = $('#child_alter_phone').val();
        if (child_alter_phone != '') {
            var p2 = window.intlTelInputGlobals.getInstance(phone_number2).isValidNumber();
            if (p2 == false) {
                swal("Please Enter Valid Alternative Contact Number", "", "error");
                return false;
            }
        }

        var child_contact_address = $('#child_contact_address').val();
        if (child_contact_address == '') {
            swal.fire("Please Enter Address:  ", "", "error");
            return false;
        }
        var expectation = $('#expectation').val();
        if (expectation == '') {
            swal("Please Enter your expectation from Elina", "", "error");
            return false;
        }
        // var featured3 = document.getElementById("featured-3");
        // var featured4 = document.getElementById("featured-4");
        // var featured11 = document.getElementById("featured-11");
        // var featured12 = document.getElementById("featured-12");
        // var featured13 = document.getElementById("featured-13");


        // if ((featured3.checked == false) && (featured4.checked == false) && (featured11.checked == false) && (featured12.checked == false)) {

        //     swal.fire("Please Select atleast one Question from Services from Elina", "", "error");

        //     return false;

        // }


        var featured5 = document.getElementById("featured-5");
        var featured6 = document.getElementById("featured-6");
        var featured7 = document.getElementById("featured-7");
        var featured8 = document.getElementById("featured-8");
        var featured9 = document.getElementById("featured-9");
        var featured10 = document.getElementById("featured-10");

        // if ((featured5.checked == false) && (featured6.checked == false) && (featured7.checked == false) && (featured8.checked == false) && (featured9.checked == false) && (featured10.checked == false)) {
        //     swal.fire("Please Select atleast one Qusetion from About Elina", "", "error");
        //     return false;
        // }
        var select = document.getElementById("how_knowabt_elina").value; // get the dropdown value
    if (select === "") {
        swal.fire("Please Select atleast one Qusetion from About Elina", "", "error");
        return false; // Prevent form submission
    }
        document.getElementById('btn_status').value = a;
        if (a == 'Declined') {
            swaltext = 'Decline';
        } else if (a == 'Submitted') {
            swaltext = 'Submit';
        } else {
            swaltext = a;
        }
        Swal.fire({
            title: "Do you want to " + swaltext + " ?",
            text: "Please click 'Yes' to " + swaltext + " the Enrollment",
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Yes',
            cancelButtonText: 'No'
        }).then((result) => {
            if (result.isConfirmed) {
                $('.loader').show();
                document.getElementById('newenrollement').submit();
            } else {
                return false;
            }
        });
    }
</script>
@endsection