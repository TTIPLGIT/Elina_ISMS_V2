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
<style>
    .nav {
        display: -webkit-inline-box;
        display: inline-flex;
        position: relative;
        overflow: hidden;
        max-width: 100%;
        background-color: #fff;
        padding: 0 20px;
        border-radius: 40px;
        box-shadow: 0 10px 40px rgba(159, 162, 177, 0.8);
        align-items: center;
        text-align: center;
        justify-content: center;
    }

    .nav-item {
        color: #83818c;
        padding: 20px;
        text-decoration: none;
        -webkit-transition: .3s;
        transition: .3s;
        margin: 0 6px;
        z-index: 1;
        font-family: 'DM Sans', sans-serif;
        font-weight: 500;
        position: relative;
    }

    .nav-item:before {
        content: "";
        position: absolute;
        bottom: -6px;
        left: 0;
        width: 100%;
        height: 5px;
        background-color: #dfe2ea;
        border-radius: 8px 8px 0 0;
        opacity: 0;
        -webkit-transition: .3s;
        transition: .3s;
    }

    .nav-item:not(.is-active):hover:before {
        opacity: 1;
        bottom: 0;
    }

    .nav-item:not(.is-active):hover {
        color: #333;
    }

    .nav-indicator {
        position: absolute;
        left: 0;
        bottom: 0;
        height: 4px;
        -webkit-transition: .4s;
        transition: .4s;
        height: 5px;
        z-index: 1;
        border-radius: 8px 8px 0 0;
    }

    li.disabled {
        display: none !important;
    }

    @media (max-width: 580px) {
        .nav {
            overflow: auto;
        }
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
        <form action="{{route('ovmiscfeedbackstore',$rows[0]['ovm_isc_report_id'])}}" method="POST" id="ovmisc" name="ovmisc" enctype="multipart/form-data">
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
                                        <input class="form-control enrollment_id" name="enrollment_id" placeholder="Enrollment ID" value="{{ $rows[0]['enrollment_id']}}" readonly>
                                        <input type="hidden" class="form-control" name="editusername" placeholder="editusername" value="{{$editusername}}" readonly>
                                        <input type="hidden" class="form-control" name="report_id" placeholder="editusername" id="report_id" value="{{$rows[0]['ovm_isc_report_id']}}" readonly>


                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="control-label">OVM Meeting ID</label>
                                        <input class="form-control" type="text" id="ovm_meeting_unique" name="ovm_meeting_unique" value="{{ $rows[0]['ovm_meeting_unique']}}" placeholder="OVM1 Meeting" autocomplete="off" readonly>

                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="control-label">Child ID</label>
                                        <input class="form-control" type="text" id="child_id" name="child_id" value="{{ $rows[0]['child_id']}}" placeholder="OVM1 Meeting" autocomplete="off" readonly>

                                    </div>
                                </div>



                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="control-label">Child Name</label>
                                        <input class="form-control" type="text" id="child_name" name="child_name" value="{{ $rows[0]['child_name']}}" placeholder="Enter Name" autocomplete="off" readonly>
                                    </div>
                                </div>


                                @if( $rows[0]['video_link1']!= '')
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="control-label">Video Link</label>
                                        <div style="display: flex;">
                                            <input class="form-control" readonly type="url" id="video_link" name="video_link" autocomplete="off" value="{{$rows[0]['video_link1']}}">
                                            <a class="btn btn-link" title="show" target="_blank" href="{{$rows[0]['video_link1']}}"><i class="fas fa-eye" style="color:green"></i></a>
                                        </div>
                                        {{-- <input class="form-control"  readonly type="url" id="video_link" name="video_link" autocomplete="off" value="Video Not Available"> --}}

                                    </div>
                                </div>
                                @endif





                                <input type="hidden" id="g2form_filled" name="g2form_filled">


                            </div>
                        </div>
                    </div>
                </div>

                <div id="scrollSession"></div>
                <div class="col-12" style="margin: 5px 0 5px 0;cursor:pointer">
                    <nav class="nav" style="width:100%">
                        @foreach($group as $key => $value)
                        <a class="nav-item{{ $loop->first ? ' is-active' : '' }}" active-color="orange" data-id="{{$value['id']}}">{{$value['name']}}</a>
                        @endforeach
                        <span class="nav-indicator"></span>
                    </nav>
                </div>
                @foreach($group as $key => $value)

                <div class="row navcard navcard{{$value['id']}}" style="display:none">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <!-- {{$value['name']}} -->
                                <input type="text" class="col-4 form-control default" oninput="search(event , '{{$value['id']}}')" id="searchInput" style="float: right;font-family:Arial, FontAwesome" placeholder="&#xF002; Search">
                                <div class="table-wrapper">
                                    <div class="table-responsive">
                                        <table class="table myTable">
                                            @if($value['add_questions'] == 1)
                                            <thead>
                                                <tr>
                                                    <th width="30%">Areas</th>
                                                    <th width="35%"></th>
                                                    <th width="35%">Conversation summary</th>
                                                </tr>
                                            </thead>
                                            <tbody id="table_{{$value['id']}}">
                                                @foreach($questions as $question)
                                                @if($question['group_id'] == $value['id'])
                                                <tr>
                                                    <td width="30%" style="text-align:left !important;">{!! $question['question'] !!}<span class="tooltiptext1">{!! $question['question_description'] !!}</span></td>
                                                    <td width="35%"><textarea class="form-control default instructions_textarea" id="note_{{$question['question_column_name']}}" name="note[{{$question['question_column_name']}}]" {{ ($rows[0]['status']=="Submitted") || ($rows[0]['status']=="Completed") && $rolename !='IS Head'? "disabled" : "" }}>{{ $question['additional_question_data']}}</textarea></td>
                                                    <td width="35%"><textarea class="form-control default instructions_textarea {{ $question['assigned_value']}}" id="{{$question['question_column_name']}}" name="que[{{$question['question_column_name']}}]" {{ ($rows[0]['status']=="Submitted") || ($rows[0]['status']=="Completed") && $rolename !='IS Head'? "disabled" : "" }}>{{ $question['prefilled_data']}}</textarea></td>
                                                </tr>
                                                @endif
                                                @endforeach
                                            </tbody>
                                            @else
                                            <thead>
                                                <tr>
                                                    <th width="35%">Areas</th>
                                                    <th>Conversation summary</th>
                                                </tr>
                                            </thead>
                                            @if($value['id'] == 1)
                                            <tbody id="table_{{$value['id']}}">
                                                @foreach($questions as $question)
                                                @if($question['group_id'] == $value['id'])
                                                <tr>
                                                    <td width="35%" style="text-align:left !important;height: 200px;">{!! $question['question'] !!}<span class="tooltiptext1">{!! $question['question_description'] !!}</span></td>
                                                    <td style="text-align:left !important;">{!! $question['prefilled_data'] !!}<input type="hidden" value="{{ $question['prefilled_data'] }}" name="que[{{$question['question_column_name']}}]"></td>
                                                </tr>
                                                @endif
                                                @endforeach
                                            </tbody>
                                            @else
                                            <tbody id="table_{{$value['id']}}">
                                                @foreach($questions as $question)
                                                @if($question['group_id'] == $value['id'])
                                                <tr>
                                                    <td width="35%" style="text-align:left !important;height: 200px;">{!! $question['question'] !!}<span class="tooltiptext1">{!! $question['question_description'] !!}</span></td>
                                                    @if(isset($question['readonly']) && $question['readonly'] == 1)
                                                    {{-- <td style="text-align:left !important;" class="td_{{ $question['assigned_value']}}">{!! $question['prefilled_data'] !!} <input type="hidden" class="{{ $question['assigned_value']}}" name="que[{{$question['question_column_name']}}]"></td> --}}
                                                    <td><textarea class="form-control default instructions_textarea_readonly {{ $question['assigned_value']}}" id="{{$question['question_column_name']}}" name="que[{{$question['question_column_name']}}]" disabled> {!! $question['prefilled_data'] !!}</textarea></td>
                                                    @else
                                                    <td><textarea class="form-control default instructions_textarea {{ $question['assigned_value']}}" id="{{$question['question_column_name']}}" name="que[{{$question['question_column_name']}}]" {{ ($rows[0]['status']=="Submitted") || ($rows[0]['status']=="Completed") && $rolename !='IS Head'? "disabled" : "" }}>{{ $question['prefilled_data']}}</textarea></td>
                                                    @endif
                                                </tr>
                                                @endif
                                                @endforeach
                                            </tbody>
                                            @endif
                                            @endif
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach

            </div>
            <div class="row text-center" style="margin: 5px 0px 0px 0px;">
                <div class="col-md-12">
                    <a class="btn btn-info" type="button" title="Previous" id="prevButton">Previous</a>
                    @if($role!='ishead')
                    @if( $rows[0]['status'] !="Submitted" && $rows[0]['status'] !="Completed")
                    <button type="submit" id="saved" class="btn btn-warning" title="Save" name="type" value="Saved">Save</button>
                    <button type="submit" id="click-saved" name="type" value="Saved" title="Save" style="display: none;">Save</button>
                    <button type="submit" id="submit" class="btn btn-success" name="type" title="Submit" value="Submitted">Submit</button>
                    <button type="submit" id="click-submit" name="type" value="Submitted" title="Submit" style="display: none;">Submit</button>
                    @endif
                    @elseif($role=='ishead')
                    <button type="submit" id="submit" class="btn btn-success" name="type" title="Submit" value="Completed">Submit</button>
                    <button type="submit" id="click-submit" name="type" value="Submitted" title="Submit" style="display: none;">Submit</button>
                    @endif
                    <a type="button" href="{{ route('ovmmeetingcompleted') }}" title="Cancel" class="btn btn-danger">Cancel</a>
                    <a class="btn btn-info" type="button" title="Next" id="nextButton">Next</a>
                </div>
            </div>
        </form>
        <input type="hidden" value="{{$rows[0]['status']}}" id="rowstatus">
        <input type="hidden" value="{{$rolename}}" id="rowrolename">

    </div>
</div>
<script>
    const indicator = document.querySelector('.nav-indicator');
    const items = document.querySelectorAll('.nav-item');

    function handleIndicator(el) {
        items.forEach(item => {
            item.classList.remove('is-active');
            item.removeAttribute('style');
        });

        indicator.style.width = `${el.offsetWidth}px`;
        indicator.style.left = `${el.offsetLeft}px`;
        indicator.style.backgroundColor = el.getAttribute('active-color');

        el.classList.add('is-active');
        el.style.color = el.getAttribute('active-color');

        var dataid = el.getAttribute('data-id');
        // console.log(dataid);
        if (dataid == 7) {
            $('#nextButton').hide();
        } else {
            $('#nextButton').show();
        }

        if (dataid == 1) {
            $('#prevButton').hide();
        } else {
            $('#prevButton').show();
        }

        $('#currentPage').val(dataid);

        window.scroll({
            top: 0,
            left: 0,
            behavior: 'smooth'
        });
        // document.getElementById('scrollSession').scrollIntoView({
        //     behavior: 'smooth'
        // });

        $('.navcard').hide();
        $('.navcard' + dataid).show();
    }


    items.forEach((item, index) => {
        item.addEventListener('click', e => {
            handleIndicator(e.target);
        });
        item.classList.contains('is-active') && handleIndicator(item);
    });

    // Next and Prev

    const prevButton = document.getElementById('prevButton');
    const nextButton = document.getElementById('nextButton');

    function handleNext() {
        const activeItem = document.querySelector('.nav-item.is-active');
        const nextItem = activeItem.nextElementSibling;
        if (nextItem && nextItem.classList.contains('nav-item')) {
            handleIndicator(nextItem);
        }
    }

    function handlePrevious() {
        const activeItem = document.querySelector('.nav-item.is-active');
        const prevItem = activeItem.previousElementSibling;
        if (prevItem && prevItem.classList.contains('nav-item')) {
            handleIndicator(prevItem);
        }
    }

    prevButton.addEventListener('click', handlePrevious);
    nextButton.addEventListener('click', handleNext);

    // ...
</script>
<script>
    // $(document).ready(function() {
    //     var table = $('.myTable').DataTable({
    //         "pageLength": 5,
    //         "dom": '<"top"rt<"bottom"ip>',
    //         "language": {
    //             "info": ""
    //         },
    //         "ordering": false,
    //     });
    // });
    $(document).on('click', '.paginate_button:not(.disabled)', function() {
        window.scroll({
            top: 0,
            left: 0,
            behavior: 'smooth'
        });
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
    $('#saved').click(function(event) {
        event.preventDefault(); // Prevent default button click behavior

        Swal.fire({
            title: "Do you want to Save the Observation?",
            text: "Please click 'Yes' to Save the Observation",
            icon: "warning",
            customClass: 'swalalerttext',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            confirmButtonText: "Yes",
            cancelButtonText: "No",
        }).then((result) => {
            if (result.isConfirmed) {
                // Disable the button to prevent multiple clicks
                // Submit the form
                let form = document.getElementById('ovmisc');
                if (form) {
                    $("#saved").addClass("disable-click");
                    // Show loader
                    $('.loader').show();

                    // Call function to destroy the table if needed
                    tabledestroy();
                    // Method - 1: Submitting the form directly
                    // form.submit();
                    // $('.loader').show();
                    document.getElementById("click-saved").click();

                } else {
                    console.log('Form not found.');
                }
            } else {
                console.log('Form not saved.');
            }
        });
    });

    // $('#saved').click(function() {
    //     $("#saved").addClass("disable-click");
    //     $('.loader').show();
    //     tabledestroy();
    //     document.getElementById('ovmisc').submit();
    // });
</script>
<script>
    $(document).ready(function() {

        // ================== ENROLLMENT ==================
        var $enrollment_details = <?php echo json_encode($enrollment_details); ?>;
        $enrollment_details = $enrollment_details[0];

        var dob = $enrollment_details.child_dob;
        var dobParts = dob.split('/');
        var birthdate = new Date(dobParts[2], dobParts[1] - 1, dobParts[0]);
        var now = new Date();

        var years = now.getFullYear() - birthdate.getFullYear();
        var months = now.getMonth() - birthdate.getMonth();

        if (months < 0 || (months === 0 && now.getDate() < birthdate.getDate())) {
            years--;
            months += 12;
        }

        var childAge = years + " years " + months + " months";
        var childGender = $enrollment_details.child_gender;

        $('.f_name').val($enrollment_details.child_name);
        $('.f_age').val(childAge);
        $('.f_dob').val($enrollment_details.child_dob);
        $('.f_aor').val($enrollment_details.child_contact_address);
        $('.f_school').val($enrollment_details.child_school_name_address);

        // ================== HELPERS ==================
        function isNullValue(value) {
            if (value === null || value === undefined) return true;
            if (typeof value === 'string') {
                var trimmed = value.trim();
                return trimmed === '' ||
                    trimmed === 'null' ||
                    trimmed.includes('>null<');
            }
            return false;
        }

        function cleanValue(value) {
            return isNullValue(value) ? '' : value;
        }

        function correctPronounCase(text, gender) {
            return text;
        }

        function appendField(selector, value) {
            if (isNullValue(value)) return;

            value = correctPronounCase(value, childGender);

            var current = $(selector).val();
            $(selector).val(current ? current + '<br>' + value : value);
        }

        // ================== FETCHDATA ==================
        var fetchdatas = <?php echo json_encode($fetchdata); ?>;
        if (fetchdatas && fetchdatas.length > 0) {
            $.each(fetchdatas[0], function(key, value) {
                var cleaned = correctPronounCase(cleanValue(value), childGender);
                $('#' + key).val(cleaned);
            });
        }

        // ================== FETCHDATA1 ==================
        var fetchdatas1 = <?php echo json_encode($fetchdata1); ?>;
        if (fetchdatas1 && fetchdatas1.length > 0) {
            $.each(fetchdatas1[0], function(key, value) {
                var cleaned = correctPronounCase(cleanValue(value), childGender);
                $('#note_' + key).val(cleaned);
            });
        }

        // ================== MAIN FIX (MULTIPLE COORDINATORS) ==================
        var fetchdata2 = <?php echo json_encode($fetchdata2); ?>;

        if (fetchdata2 && fetchdata2.length > 0) {

            // Clear fields once
            $('.f_deve, .f_assessment, .f_prev, .f_other, .f_adl, .f_support, .f_social, .f_strength, .f_parentinput')
                .val('');

            $.each(fetchdata2, function(index, data) {

                // ❌ REMOVE OLD CONDITION
                // if (data.g2form_filled != 1 && data.flag != 1) {

                // ✅ NEW CONDITION
                if (data) {

                    appendField('.f_deve', data.conversation_064);
                    appendField('.f_assessment', data.conversation_065);
                    appendField('.f_prev', data.conversation_066);

                    appendField('.f_other', data.conversation_067);
                    appendField('.f_other', data.conversation_068);
                    appendField('.f_other', data.conversation_074);

                    appendField('.f_adl', data.conversation_080);

                    appendField('.f_support', data.conversation_075);
                    appendField('.f_support', data.conversation_076);
                    appendField('.f_support', data.conversation_077);

                    appendField('.f_social', data.conversation_079);

                    appendField('.f_strength', data.conversation_071);
                    appendField('.f_strength', data.conversation_078);

                    appendField('.f_parentinput', data.conversation_069);
                    appendField('.f_parentinput', data.conversation_070);
                    appendField('.f_parentinput', data.conversation_072);
                    appendField('.f_parentinput', data.conversation_073);
                }
            });

            $('#g2form_filled').val(1);

        } else {
            $('#g2form_filled').val(0);
        }

        // ================== CLEAN FINAL ==================
        $('.instructions_textarea').each(function() {
            if (isNullValue($(this).val())) {
                $(this).val('');
            }
        });

        // ================== READONLY ==================
        var rolename = $('#rowrolename').val();
        var status = $('#rowstatus').val();

        var readonly = 0;
        if ((status === "Submitted" || status === "Completed") && rolename !== 'IS Head') {
            readonly = 1;
        }

        // ================== TINYMCE ==================
        tinymce.init({
            selector: '.instructions_textarea',
            height: '100%',
            menubar: false,
            branding: false,
            readonly: readonly,
            plugins: 'lists link table code',
            toolbar: 'undo redo | bold italic | alignleft aligncenter alignright | bullist numlist'
        });

        // ================== PAGE NAV ==================
        var pageNo = $('#session_page').val();
        if (pageNo) {
            document.querySelector('.nav-item[data-id="' + pageNo + '"]')?.click();
        }

    });
</script>
<script>
    function search(event, id) {
        var value = event.target.value;
        // console.log(value, id);
        value = value.toLowerCase();
        $("#table_" + id + " tr").filter(function() {
            $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
        });
    }
</script>
<script>
    $(document).ready(function() {
        // Function to autosave form data
        var status = document.getElementById('rowstatus').value;

        function autosave() {

            var formData = $('#ovmisc').serialize(); // Serialize form data
            var additionalData = {
                ovm_isc_report_id: $('#report_id').val(),
                ovm_meeting_unique: $('#ovm_meeting_unique').val(),
                enrollment_id: $('.enrollment_id').val(),
                child_id: $('#child_id').val(),
                child_name: $('#child_name').val(),
                type: $('[name="type"]').val(), // Assuming you have an element with id 'type'

            };
            var additionalnote = {};
            // Retrieve the value of the note_ field and add it to additionalData
            $('textarea[name^="note["]').each(function() {
                var noteId = $(this).attr('name');

                // var key = noteId.replace('note_', '');
                var noteValue;

                if ($(this).hasClass('instructions_textarea')) {
                    noteValue = tinyMCE.get(this.id).getContent();
                    // console.log(noteValue);
                } else {
                    noteValue = $(this).val();
                    // console.log(noteValue);
                }
                additionalData[noteId] = noteValue;

            });

            $('textarea[name^="que["],input[name^="que["]').each(function(index, element) {
                // console.log(element);
                var queName = $(this).attr('name'); // Get the name attribute of the input
                // console.log(queName);

                if ($(this).hasClass('instructions_textarea')) {

                    queValue = tinyMCE.get(this.id).getContent(); // Get the content of the TinyMCE editor

                } else {
                    queValue = $(this).val(); // Get the value of the input field
                }
                // console.log(queValue);
                // var queValue = $(this).val(); // Get the value of the input
                additionalData[queName] = queValue; // Assign the value to the corresponding property in additionalData
            });



            $.ajax({
                type: 'POST',
                url: '/autosave/' + $('#report_id').val(),
                data: additionalData,
                dataType: "json",
                success: function(response) {
                    console.log(response);

                    if (response == 200) {
                        console.log(response);

                    }
                },
                // error: function(xhr, status, error) {
                //     console.error('Error autosaving form:', error);
                // }
            });
        }

        if (status != "Submitted" && status != "Completed") {
            var autosaveInterval = setInterval(autosave, 1000); // 1000 milliseconds = 1 second
        }

        $("#submit").click(function(event) {
            event.preventDefault(); // Prevent default button click behavior

            // Clear the autosave interval (assuming these are defined elsewhere)
            clearInterval(autosaveInterval);
            autosave = function() {};
            tabledestroy();

            // Show confirmation dialog
            Swal.fire({
                title: "Do you want to Submit the Observation?",
                text: "Please click 'Yes' to Submit the Observation",
                icon: "warning",
                customClass: 'swalalerttext',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                confirmButtonText: "Yes",
                cancelButtonText: "No",
            }).then((result) => {
                if (result.isConfirmed) {
                    let form = document.getElementById('ovmisc');
                    if (form) {
                        // // Method - 1
                        // var rls = <?php echo json_encode($role) ?>;
                        // let typeInput = document.createElement('input');
                        // typeInput.type = 'hidden';
                        // typeInput.name = 'type';
                        // typeInput.value = (rls == 'ishead' ? 'Completed' : 'Submitted');
                        // form.appendChild(typeInput);                        
                        // HTMLFormElement.prototype.submit.call(form);

                        // // Method - 2
                        $('.loader').show();
                        document.getElementById("click-submit").click();
                    } else {
                        console.log('Form not found.');
                    }
                } else {
                    console.log('Form submission cancelled.');
                }
            });
        });

    });
</script>


@endsection