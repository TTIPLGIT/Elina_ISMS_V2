@extends('layouts.parent')

@section('content')
<style>
    table {
        border-collapse: collapse;
    }

    td,
    th {
        border: 1px solid black;
        padding: 10px;
        font-weight: bolder;
        color: black !important;
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

    .flatpickr-disabled {
        color: grey !important;
    }
    tr,th
    {
        border: 1px solid white;
        padding: 10px;
        font-weight: bolder;
        color: white !important;
    }
    .readonly{
        background-color: #e9ecef !important;
        pointer-events: none !important;
    }
    select.form-control {
        color: black !important;
    }
</style>

<div class="main-content">
    <!-- active_flag -->
    @if ($rows[0]['active_flag'] == 1)
    <script type="text/javascript">
        window.onload = function() {
            Swal.fire('info!', "You have already confirmed your availability", 'info');
        }
    </script>
    @elseif($rows[0]['active_flag'] == 2)
    <script type="text/javascript">
        window.onload = function() {
            Swal.fire('info!', "Your OVM Meeting Schedule has been updated", 'info');
        }
    </script>
    @endif
    {{ Breadcrumbs::render('user_edit' , $rows[0]['id'] ) }}

    <h5 class="text-center" style="color:darkblue">OVM Meeting Scheduling Edit</h5>
    <div class="row">
        <div class="col-12">
            <form action="{{route('ovm.allocation.user_update')}}" method="POST" id="ovmmeet" enctype="multipart/form-data">
                @csrf
                <input type="hidden" value="{{$rows[0]['id']}}" id="allocation_id" name="allocation_id">
                <input type="hidden" value="{{$rows[0]['enrollment_id']}}" name="enrollment_id">

                <div class="card">
                    <div class="card-body">
                        <div class="table-wrapper">
                            <div class="table-responsive">
                                <table class="table" id="myTable">
                                    <thead>
                                        <tr>
                                            <th width="35%">Details</th>
                                            <th>OVM 1</th>
                                            <th>OVM 2</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>Meeting Date</td>
                                            <td>{{$rows[0]['meeting_startdate']}}</td>
                                            <td>{{$rows[0]['meeting_startdate2']}}</td>
                                        </tr>
                                        <tr>
                                            <td>Meeting Time</td>
                                            <td>{{ \Carbon\Carbon::createFromFormat('H:i:s', $rows[0]['meeting_starttime'])->format('g:i A') }} - {{ \Carbon\Carbon::createFromFormat('H:i:s', $rows[0]['meeting_endtime'])->format('g:i A') }}</td>
                                            <td>{{ \Carbon\Carbon::createFromFormat('H:i:s', $rows[0]['meeting_starttime2'])->format('g:i A') }} - {{ \Carbon\Carbon::createFromFormat('H:i:s', $rows[0]['meeting_endtime2'])->format('g:i A') }}</td>
                                        </tr>
                                        <tr>
                                            <td>Meeting Location</td>
                                            <td>{{$rows[0]['meeting_location']}}</td>
                                            <td>{{$rows[0]['meeting_location2']}}</td>
                                        </tr>
                                        @if($rows[0]['reschedule_count'] <= 2) <tr>
                                            <td>
                                                <p class="required"><strong>Confirm Availability</strong></p>
                                            </td>
                                            <td>
                                                <select class="form-control default" id="rsvp_1" name="rsvp_1" @if($rows[0]['rsvp1'] =='Accept') style="pointer-events:none !important;" readonly @elseif($rows[0]['rsvp1'] !='') readonly @endif>
                                                    <option value="" @if($rows[0]['rsvp1']=='' ) selected @endif>Select</option>
                                                    <option value="Accept" @if($rows[0]['rsvp1']=='Accept' ) selected @endif>Accept</option>
                                                    <option value="Reschedule" @if($rows[0]['rsvp1']=='Reschedule' ) selected @endif>Reschedule</option>
                                                </select>
                                                </br>
                                                <input type="datetime-local" id="rsvp_1_time"  class="form-control default col-md-12 rsvp_1_time" name="rsvp_1_time" placeholder="Select reschedule date and time"style="display:none !important;">
                                                <input type="hidden" value="" id="rsvp_1_time_hide" name="rsvp_1_time_hide">

                                               
                                            </br>
                                            </td>
                                            <td>
                                                <select class="form-control default" id="rsvp_2" name="rsvp_2" @if($rows[0]['rsvp2'] =='Accept') style="pointer-events:none !important;" readonly @elseif($rows[0]['rsvp2'] !='' ) readonly @endif>
                                                    <option value="" @if($rows[0]['rsvp2']=='' ) selected @endif>Select</option>
                                                    <option value="Accept" @if($rows[0]['rsvp2']=='Accept' ) selected @endif>Accept</option>
                                                    <option value="Reschedule" @if($rows[0]['rsvp2']=='Reschedule' ) selected @endif>Reschedule</option>
                                                </select>
    </br>
                                                <input type="datetime-local" id="rsvp_2_time" name="rsvp_2_time" class="form-control default col-md-12 rsvp_2_time" placeholder="Select reschedule date and time" style="display:none !important;">
                                                <input type="hidden" value="" id="rsvp_2_time_hide" name="rsvp_2_time_hide">

                                                </br>
                                            </td>
                                            </tr>

                                            @else
                                            <tr>
                                                <td>
                                                    <p class="required"><strong>Confirm Availability</strong></p>
                                                </td>


                                                <td>
                                                    <select class="form-control default" id="rsvp_1" name="rsvp_1" readonly @if($rows[0]['rsvp1']=='' ) readonly @endif>

                                                        <option value="Accept" selected>Accept</option>

                                                    </select>
                                                </td>
                                                <td>
                                                    <select class="form-control default" id="rsvp_2" name="rsvp_2" @if($rows[0]['rsvp2']=='' ) readonly @endif>

                                                        <option value="Accept" selected>Accept</option>

                                                    </select>
                                                </td>
                                            </tr>
                                            @endif
                                            <tr>
                                                <td>Note</td>

                                                <td style="padding: 10px;"><textarea class="form-control default" name="notes_1" id="notes_1" @if($rows[0]['rsvp1'] !='' ) disabled readonly @endif></textarea></td>
                                                <td style="padding: 10px;"><textarea class="form-control default" name="notes_2" id="notes_2" @if($rows[0]['rsvp2'] !='' ) disabled  readonly @endif></textarea></td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <p class="required"><strong>Coordinator Notes</strong></p>
                                                <td colspan="2" style="padding: 10px;">
                                                    <textarea class="form-control default" name="co_notes" disabled>{{$rows[0]['cnotes']}}</textarea>
                                                </td>

                                                </td>
                                            </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <p style="color:red !important;text-align: center;">***Please note that the meeting times always be in Indian Standard Time (IST).***</p>

                    </div>
                </div>
            </form>
            <br>
            <div class="row text-center">
                <div class="col-md-12">
                    @if ($rows[0]['active_flag'] != 1 && $rows[0]['active_flag'] != 2 && $rows[0]['reschedule_count'] != 3)
                    <a type="button" class="btn btn-success text-white" onclick="validateForm()" name="type">Submit</a>
                    @endif
                    <a type="button" href="{{ route('home') }}" class="btn btn-labeled responsive-button button-style back-button" title="Back">
                        <i class="fas fa-arrow-left"></i><span> Back </span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script>
    flatpickr("#rsvp_1_time", {
        enableTime: true,
        dateFormat: "d/m/Y h:i K",
        time_24hr: false,
        placeholder:"Select date and time",
        minDate: "today",  // Disable past dates
    });
    flatpickr("#rsvp_2_time", {
        enableTime: true,
        dateFormat: "d/m/Y h:i K",
        time_24hr: false,
        placeholder:"Select date and time",
        minDate: "today",  // Disable past dates
    });
</script>
<script>
    <!-- JavaScript to update notes based on selected date and time 
    -->
    //When the RSVP date and time  changes RSVP date
    
    $('.rsvp_1_time').change(function()
    {
    //Get the selected date and time
    var selectedDateTime =$('.rsvp_1_time').val();
    //Format   the date  date
    var formattedDateTime1  = selectedDateTime;
    // Update  the notes  with the formatted  date

    $('#notes_1').val(formattedDateTime1);
    $('#rsvp_1_time_hide').val($('.rsvp_1_time').val());
    });
    $('.rsvp_2_time').change(function()
    {
    // Get the selected date and time
    var selectedDateTime = $('.rsvp_2_time').val();
    //Format the  date
    var formattedDateTime2 =selectedDateTime;    
    $('#rsvp_2_time_hide').val($('.rsvp_2_time').val());
    // Update the notes with the formatted date
    $('#notes_2').val(formattedDateTime2);
    });
    function validateDateTime()
    {
    //
    const pattern =/\d{2}\/\d{2}\/\d{4}\d{2}:\d{2}$/;
    const  value = $('#notes_1').val();
    const  value2 =$('#notes_2').val();
    var rsvp_1_time_hide  = document.getElementById('rsvp_1_time_hide').value;
    var rsvp_2_time_hide  = document.getElementById('rsvp_2_time_hide').value;
    //
    const matches =value.match(pattern);
    if(value === " " && document.getElementById('rsvp_1').value !='Accept'&& rsvp_1_time_hide =="")
    {
    swal.fire("Please Fill all required OVM-1 details", "", "error");
    return false;
    }
    else if(value2 ==="" && document.getElementById('rsvp_2').value  !='Accept'  &&  rsvp_2_time_hide  == "") 
    {
    swal.fire("Please Fill all required OVM-2 details","","error");
    return false;
    }
    else
    {
    }
    return true;
    }

</script>
<script>
    function validateForm() {

        if (document.getElementById('rsvp_1').value == '') {
            swal.fire("Please Confirm your Availability for OVM-1", "", "error");
            return false;
        }
        if (document.getElementById('rsvp_2').value == '') {
            swal.fire("Please Confirm your Availability for OVM-2", "", "error");
            return false;
        }
        if (document.getElementById('notes_1').value == '' && document.getElementById('rsvp_1').value != 'Accept') {
            swal.fire("Please Enter your notes for OVM-1", "", "error");
            return false;
        }
        if (document.getElementById('notes_2').value == '' && document.getElementById('rsvp_2').value != 'Accept') {
            swal.fire("Please Enter your notes for OVM-2", "", "error");
            return false;
        }

        if (validateDateTime()) {
            $(".loader").show();
            document.getElementById('ovmmeet').submit();
        } else {
            return false;
        }

    }
</script>

<!-- Include JavaScript to handle form element changes and date format updates -->
<script>
    // Function to enable/disable form elements and update notes field
    function enableDisableFormElements() {
     
        var rsvp1 = document.getElementById('rsvp_1');
        var rsvp2 = document.getElementById('rsvp_2');
        var notes1 = document.getElementById('notes_1');
        var notes2 = document.getElementById('notes_2');
        var meetingDate1 = document.getElementById('meeting_startdate');
        var meetingDate2 = document.getElementById('meeting_startdate2');
        var rsvp_1_time =document.getElementById('rsvp_1_time');
        var rsvp_2_time =document.getElementById('rsvp_2_time');
        var rsvp_1_time_hide=document.getElementById('rsvp_1_time_hide');
        var rsvp_2_time_hide=document.getElementById('rsvp_2_time_hide');


        if (rsvp1.value === 'Reschedule' && rsvp2.value === 'Reschedule') {
           
            rsvp2.disabled = false;
            notes1.disabled = false;
            notes2.disabled = false;
            rsvp1.disabled = false;

            // Initialize the date and time picker for notes1

            
            notes1.placeholder = "The Reschedule date is dd/mm/yyyy hr:min:-";
            notes2.placeholder = "The Reschedule date is dd/mm/yyyy hr:min:-";
            rsvp_1_time.style.display="block";
            rsvp_2_time.style.display="block";
            
            var parsedDate1 = new Date(rsvp_1_time.value);
            
            var parsedDate2 = new Date(rsvp_2_time.value);
            notes1.value =rsvp_1_time_hide.value; //(!isNaN(parsedDate1.getTime()) && rsvp_1_time_hide.value !="" )? (rsvp_1_time.value) : "";
            notes2.value =rsvp_2_time_hide.value;// (!isNaN(parsedDate2.getTime()) && rsvp_2_time_hide.value !="" ) ? (rsvp_2_time.value) : "";


        } else if (rsvp1.value === 'Reschedule' && rsvp2.value != 'Reschedule') {
            
            rsvp2.disabled = false;
            notes1.disabled = false;
            notes2.disabled = false;
            rsvp1.disabled = false;

            // Update the notes field to "dd/mm/yyyy hr:min" for OVM 1
            notes1.placeholder = "The Reschedule date is dd/mm/yyyy hr:min:-";
            notes2.placeholder = "";
            
            rsvp_1_time.style.display="block";
            rsvp_2_time.style.display="none";
         
        
        var parsedDate1 = new Date(rsvp_1_time.value);
           
        notes1.value = rsvp_1_time_hide.value;//(!isNaN(parsedDate1.getTime()) && rsvp_1_time_hide.value !="" )? (rsvp_1_time.value) : "";

            

        } else if (rsvp1.value != 'Reschedule' && rsvp2.value == 'Reschedule') {
           
            rsvp2.disabled = false;
            notes1.disabled = false;
            notes2.disabled = false;
            rsvp1.disabled = false;

            // Update the notes field to "dd/mm/yyyy hr:min" for OVM 1
            notes2.placeholder = "The Reschedule date is dd/mm/yyyy hr:min:-";
            notes1.placeholder = "";
            rsvp_1_time.style.display="none";
            rsvp_2_time.style.display="block";
            var parsedDate2 = new Date(rsvp_2_time.value);
            notes2.value = rsvp_2_time_hide.value;//(!isNaN(parsedDate2.getTime()) && rsvp_2_time_hide.value !="" ) ? (rsvp_2_time.value) : "";


        } else if (rsvp1.value != 'Reschedule' && rsvp2.value != 'Reschedule') {
            
            rsvp2.disabled = false;
            notes1.disabled = false;
            notes2.disabled = false;
            rsvp1.disabled = false;

            // Update the notes field to "dd/mm/yyyy hr:min" for OVM 1
            notes2.placeholder = "";
            notes1.placeholder = "";
            rsvp_1_time.style.display="none";
            rsvp_2_time.style.display="none";

        } else {
            rsvp2.disabled = false;
            notes1.disabled = false;
            notes2.disabled = false;
            
        }
    }
    
    // Attach the event listener to the "Reschedule" dropdowns
    document.getElementById('rsvp_1').addEventListener('change', enableDisableFormElements);
    document.getElementById('rsvp_2').addEventListener('change', enableDisableFormElements);

    // Call the function initially to check the initial values
    enableDisableFormElements();
</script>



@endsection