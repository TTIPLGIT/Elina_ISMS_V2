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
                                        @if($rows[0]['reschedule_count'] <= 2) 
                                        <tr>
                                            <td>
                                                <p class="required"><strong>Confirm Availability</strong></p>
                                            </td>
                                            <td>
                                                <select class="form-control default" id="rsvp_1" name="rsvp_1" @if($rows[0]['rsvp1'] =='Accept') style="pointer-events:none !important;" readonly @endif>
                                                    <option value="" @if($rows[0]['rsvp1']=='' ) selected @endif>Select</option>
                                                    <option value="Accept" @if($rows[0]['rsvp1']=='Accept' ) selected @endif>Accept</option>
                                                    <option value="Reschedule" @if($rows[0]['rsvp1']=='Reschedule' ) selected @endif>Reschedule</option>
                                                </select>
                                                </br>
                                                <input type="datetime-local" id="rsvp_1_time"  class="form-control default col-md-12 rsvp_1_time" name="rsvp_1_time" placeholder="Select reschedule date and time" style="display:none !important;">
                                                <input type="hidden" value="{{ $rows[0]['notes1'] ?? '' }}" id="rsvp_1_time_hide" name="rsvp_1_time_hide">
                                                </br>
                                            </td>
                                            <td>
                                                <select class="form-control default" id="rsvp_2" name="rsvp_2" @if($rows[0]['rsvp2'] =='Accept') style="pointer-events:none !important;" readonly @endif>
                                                    <option value="" @if($rows[0]['rsvp2']=='' ) selected @endif>Select</option>
                                                    <option value="Accept" @if($rows[0]['rsvp2']=='Accept' ) selected @endif>Accept</option>
                                                    <option value="Reschedule" @if($rows[0]['rsvp2']=='Reschedule' ) selected @endif>Reschedule</option>
                                                </select>
                                                </br>
                                                <input type="datetime-local" id="rsvp_2_time" name="rsvp_2_time" class="form-control default col-md-12 rsvp_2_time" placeholder="Select reschedule date and time" style="display:none !important;">
                                                <input type="hidden" value="{{ $rows[0]['notes2'] ?? '' }}" id="rsvp_2_time_hide" name="rsvp_2_time_hide">
                                                </br>
                                            </td>
                                        </tr>
                                        @else
                                        <tr>
                                            <td>
                                                <p class="required"><strong>Confirm Availability</strong></p>
                                            </td>
                                            <td>
                                                <select class="form-control default" id="rsvp_1" name="rsvp_1" readonly>
                                                    <option value="Accept" selected>Accept</option>
                                                </select>
                                            </td>
                                            <td>
                                                <select class="form-control default" id="rsvp_2" name="rsvp_2" readonly>
                                                    <option value="Accept" selected>Accept</option>
                                                </select>
                                            </td>
                                        </tr>
                                        @endif
                                        <tr>
                                            <td>Note</td>
                                            <td style="padding: 10px;">
                                                <textarea class="form-control default" 
                                                    name="notes_1" 
                                                    id="notes_1" 
                                                    @if($rows[0]['rsvp1'] == 'Accept') readonly @endif>{{ $rows[0]['notes1'] ?? '' }}</textarea>
                                            </td>
                                            <td style="padding: 10px;">
                                                <textarea class="form-control default" 
                                                    name="notes_2" 
                                                    id="notes_2" 
                                                    @if($rows[0]['rsvp2'] == 'Accept') readonly @endif>{{ $rows[0]['notes2'] ?? '' }}</textarea>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <p class="required"><strong>Coordinator Notes</strong></p>
                                            </td>
                                            <td colspan="2" style="padding: 10px;">
                                                <textarea class="form-control default" name="co_notes" disabled>{{$rows[0]['cnotes']}}</textarea>
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
        placeholder: "Select date and time",
        minDate: "today",
    });
    
    flatpickr("#rsvp_2_time", {
        enableTime: true,
        dateFormat: "d/m/Y h:i K",
        time_24hr: false,
        placeholder: "Select date and time",
        minDate: "today",
    });
</script>

<script>
    // JavaScript to update notes based on selected date and time
    $(document).ready(function() {
        $('.rsvp_1_time').change(function() {
            var selectedDateTime = $('.rsvp_1_time').val();
            $('#notes_1').val(selectedDateTime);
            $('#rsvp_1_time_hide').val(selectedDateTime);
        });
        
        $('.rsvp_2_time').change(function() {
            var selectedDateTime = $('.rsvp_2_time').val();
            $('#notes_2').val(selectedDateTime);
            $('#rsvp_2_time_hide').val(selectedDateTime);
        });
    });
</script>

<script>
    function validateDateTime() {
        var rsvp_1_time_hide = document.getElementById('rsvp_1_time_hide').value;
        var rsvp_2_time_hide = document.getElementById('rsvp_2_time_hide').value;
        var rsvp1 = document.getElementById('rsvp_1').value;
        var rsvp2 = document.getElementById('rsvp_2').value;
        var notes1 = document.getElementById('notes_1').value;
        var notes2 = document.getElementById('notes_2').value;

        if (rsvp1 === 'Reschedule' && notes1 === '' && rsvp_1_time_hide === '') {
            swal.fire("Please select a reschedule date and time for OVM-1", "", "error");
            return false;
        }
        
        if (rsvp2 === 'Reschedule' && notes2 === '' && rsvp_2_time_hide === '') {
            swal.fire("Please select a reschedule date and time for OVM-2", "", "error");
            return false;
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
        
        // Only validate if Reschedule is selected and no value exists in either field
        if (document.getElementById('rsvp_1').value == 'Reschedule' && 
            document.getElementById('notes_1').value == '' && 
            document.getElementById('rsvp_1_time_hide').value == '') {
            swal.fire("Please enter a reschedule date for OVM-1", "", "error");
            return false;
        }
        
        if (document.getElementById('rsvp_2').value == 'Reschedule' && 
            document.getElementById('notes_2').value == '' && 
            document.getElementById('rsvp_2_time_hide').value == '') {
            swal.fire("Please enter a reschedule date for OVM-2", "", "error");
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

<script>
    // Function to enable/disable form elements and update notes field
    function enableDisableFormElements() {
        var rsvp1 = document.getElementById('rsvp_1');
        var rsvp2 = document.getElementById('rsvp_2');
        var notes1 = document.getElementById('notes_1');
        var notes2 = document.getElementById('notes_2');
        var rsvp_1_time = document.getElementById('rsvp_1_time');
        var rsvp_2_time = document.getElementById('rsvp_2_time');
        var rsvp_1_time_hide = document.getElementById('rsvp_1_time_hide');
        var rsvp_2_time_hide = document.getElementById('rsvp_2_time_hide');

        // Check if there are existing reschedule values from database
        var hasExistingDate1 = rsvp_1_time_hide.value !== "";
        var hasExistingDate2 = rsvp_2_time_hide.value !== "";

        if (rsvp1.value === 'Reschedule' && rsvp2.value === 'Reschedule') {
            rsvp2.disabled = false;
            notes1.disabled = false;
            notes2.disabled = false;
            rsvp1.disabled = false;

            notes1.placeholder = "The Reschedule date is dd/mm/yyyy hr:min:-";
            notes2.placeholder = "The Reschedule date is dd/mm/yyyy hr:min:-";
            
            // Show datetime picker and make notes editable for Reschedule
            rsvp_1_time.style.display = "block";
            rsvp_2_time.style.display = "block";
            notes1.readOnly = false;
            notes2.readOnly = false;
            notes1.style.backgroundColor = "";
            notes2.style.backgroundColor = "";
            
            // Show existing dates if they exist
            if (hasExistingDate1) {
                notes1.value = rsvp_1_time_hide.value;
            }
            if (hasExistingDate2) {
                notes2.value = rsvp_2_time_hide.value;
            }

        } else if (rsvp1.value === 'Reschedule' && rsvp2.value != 'Reschedule') {
            rsvp2.disabled = false;
            notes1.disabled = false;
            notes2.disabled = false;
            rsvp1.disabled = false;

            notes1.placeholder = "The Reschedule date is dd/mm/yyyy hr:min:-";
            notes2.placeholder = "";

            // Show datetime picker for OVM 1 and make notes editable
            rsvp_1_time.style.display = "block";
            rsvp_2_time.style.display = "none";
            notes1.readOnly = false;
            notes1.style.backgroundColor = "";
            
            // Show existing date if it exists
            if (hasExistingDate1) {
                notes1.value = rsvp_1_time_hide.value;
            } else {
                notes1.value = "";
            }
            notes2.value = "";

        } else if (rsvp1.value != 'Reschedule' && rsvp2.value == 'Reschedule') {
            rsvp2.disabled = false;
            notes1.disabled = false;
            notes2.disabled = false;
            rsvp1.disabled = false;

            notes2.placeholder = "The Reschedule date is dd/mm/yyyy hr:min:-";
            notes1.placeholder = "";
            
            rsvp_1_time.style.display = "none";
            
            // Show datetime picker for OVM 2 and make notes editable
            rsvp_2_time.style.display = "block";
            notes2.readOnly = false;
            notes2.style.backgroundColor = "";
            
            // Show existing date if it exists
            notes1.value = "";
            if (hasExistingDate2) {
                notes2.value = rsvp_2_time_hide.value;
            } else {
                notes2.value = "";
            }

        } else if (rsvp1.value != 'Reschedule' && rsvp2.value != 'Reschedule') {
            rsvp2.disabled = false;
            notes1.disabled = false;
            notes2.disabled = false;
            rsvp1.disabled = false;

            notes2.placeholder = "";
            notes1.placeholder = "";
            rsvp_1_time.style.display = "none";
            rsvp_2_time.style.display = "none";

            // Clear notes if not reschedule
            notes1.value = "";
            notes2.value = "";
        }
    }

    // Attach the event listener to the "Reschedule" dropdowns
    document.getElementById('rsvp_1').addEventListener('change', enableDisableFormElements);
    document.getElementById('rsvp_2').addEventListener('change', enableDisableFormElements);

    // Call the function initially to check the initial values
    document.addEventListener('DOMContentLoaded', function() {
        enableDisableFormElements();
    });
</script>

@endsection