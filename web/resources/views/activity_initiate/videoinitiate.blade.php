@extends('layouts.adminnav')

@section('content')
<style>
    #frname {
        color: red;
    }

    .centerid {
        width: 100%;
        text-align: center;
    }

    .paymentdetails {
        color: darkblue;
        padding-top: 1rem;
        margin: auto;
        justify-content: center;
    }

    .payinitiate {
        margin: auto;
    }

    .form-note {
        width: 30%;
        display: flex;
        justify-content: center;
        margin: auto;
    }

    .control-notes {
        display: flex;
        justify-content: center;
        font-weight: 800 !important;
        color: #34395e !important;
        font-size: 15px !important;
    }

    /* ===== FIX: SELECT2 SAME SIZE AS OTHER INPUTS ===== */
    .select2-container {
        width: 100% !important;
        display: block !important;
    }

    .select2-container--default .select2-selection--multiple {
        min-height: 38px !important;
        border: 1px solid #e4e6fc !important;
        border-radius: 4px !important;
        background-color: #fff !important;
    }

    .select2-container--default .select2-selection--multiple .select2-selection__choice {
        background-color: #e4e6fc !important;
        border: none !important;
        border-radius: 4px !important;
        padding: 4px 8px !important;
        margin: 2px 4px 2px 0 !important;
        font-size: 13px !important;
        color: #1e1a72 !important;
    }

    .select2-container--default .select2-search--inline .select2-search__field {
        font-size: 13px !important;
        margin-top: 6px !important;
    }

    /* Restore original select2 results styling (unchanged) */
    .select2-results__option {
        padding-right: 20px;
        vertical-align: middle;
    }

    .select2-results__option:before {
        content: "";
        display: inline-block;
        position: relative;
        height: 20px;
        width: 20px;
        border: 2px solid #e9e9e9;
        border-radius: 4px;
        background-color: #fff;
        margin-right: 20px;
        vertical-align: middle;
    }

    .select2-results__option[aria-selected=true]:before {
        font-family: fontAwesome;
        content: "\f00c";
        color: #fff;
        background-color: #f77750;
        border: 0;
        display: inline-block;
        padding-left: 3px;
    }

    .select2-container--default .select2-results__option--highlighted[aria-selected=true] {
        background-color: gray;
    }

    /* ===== BUTTONS: SAME SIZE, INLINE, PRESERVE ORIGINAL COLORS ===== */
    .action-buttons-wrapper {
        display: flex;
        justify-content: center;
        gap: 15px;
        flex-wrap: wrap;
        margin-top: 20px;
    }

    .btn-action {
        min-width: 160px !important;
        padding: 8px 20px !important;
        font-size: 14px !important;
        font-weight: 600 !important;
        border-radius: 6px !important;
        display: inline-flex !important;
        align-items: center !important;
        justify-content: center !important;
        gap: 8px !important;
        cursor: pointer !important;
        text-decoration: none !important;
        /* Original button colors (green) kept exactly */
        background: green !important;
        border-color: green !important;
        color: white !important;
        border: 1px solid transparent !important;
    }

    .btn-action:hover {
        opacity: 0.9;
        text-decoration: none !important;
        color: white !important;
    }

    .btn-action i {
        font-size: 14px !important;
    }

    /* ===== RESPONSIVE TABLES – NO EXTRA COLORS, ONLY HORIZONTAL SCROLL ===== */
    .table-wrapper {
        width: 100%;
        overflow-x: auto;
        margin-bottom: 10px;
    }

    /* Ensure original table borders remain black */
    .table-bordered,
    .table-bordered th,
    .table-bordered td {
        border: 1px solid black !important;
    }

    /* Preserve original inline editing area styles */
    .instructions_textarea {
        height: 100px;
        overflow-y: scroll;
    }

    /* Accordion styles (unchanged from original) */
    .accordion {
        border: solid 2px #f5f5f5;
        transition: all 0.3s ease-in-out;
        background-color: white;
    }

    .accordion+.accordion {
        margin-top: 0.25rem;
    }

    .accordion .accordion__title {
        list-style-type: none;
        cursor: pointer;
        font-size: 1rem;
        font-weight: 700;
        color: #555555;
        padding: 0.875rem 2.5rem 0.875rem 0.875rem;
        color: black;
        background-repeat: no-repeat;
        background-position: right 0.75rem top 0.625rem;
        background-size: 1.5rem;
    }

    .accordion .accordion__title::marker,
    .accordion .accordion__title::-webkit-details-marker {
        display: none;
    }

    .accordion[open] .accordion__title {
        color: white;
        background-color: #1e1a72;
    }

    /* ========== MOBILE RESPONSIVE STYLES (unchanged from original) ========== */
    @media (max-width: 768px) {
        .main-content {
            padding: 5px !important;
            margin-top: 60px !important;
            position: relative !important;
            z-index: 1 !important;
        }

        .breadcrumb {
            padding: 2px 5px !important;
            margin: 10px 0 10px 15px !important;
            width: 90% !important;
            height: auto !important;
            font-size: 9px !important;
            background-color: transparent !important;
            display: flex !important;
            flex-wrap: nowrap !important;
            overflow: hidden !important;
            border: none !important;
            box-shadow: none !important;
            justify-content: flex-start !important;
            align-items: center !important;
            white-space: nowrap !important;
        }

        .breadcrumb li span,
        .breadcrumb .number,
        .breadcrumb-item::before {
            width: 14px !important;
            height: 14px !important;
            line-height: 14px !important;
            font-size: 8px !important;
            margin-right: 3px !important;
        }

        .breadcrumb-item,
        .breadcrumb-item a {
            font-size: 9px !important;
            display: flex !important;
            align-items: center !important;
        }

        h5.text-center {
            font-size: 14px !important;
            margin-top: 10px !important;
            font-weight: bold !important;
            color: darkblue !important;
        }

        .card {
            margin: 5px 0 !important;
        }

        .card-body {
            padding: 10px !important;
        }

        .form-group {
            margin-bottom: 8px !important;
        }

        .control-label,
        .col-form-label,
        label {
            font-size: 10px !important;
            font-weight: bold !important;
            margin-bottom: 2px !important;
            color: #333 !important;
        }

        .form-control {
            height: 30px !important;
            font-size: 10px !important;
            padding: 5px !important;
        }

        .col-md-4,
        .col-sm-2,
        .col-sm-4,
        .col-md-2 {
            width: 100% !important;
            max-width: 100% !important;
            flex: 0 0 100% !important;
        }

        .centerid {
            text-align: left !important;
        }

        .btn-action {
            min-width: 120px !important;
            padding: 6px 12px !important;
            font-size: 11px !important;
        }

        .accordion .accordion__title {
            font-size: 12px !important;
            padding: 8px 30px 8px 8px !important;
        }

        .table-responsive {
            overflow-x: auto !important;
        }

        .table th,
        .table td {
            font-size: 10px !important;
            padding: 5px !important;
            word-break: break-word;
        }

        input[type="text"][id^="search_"] {
            width: 100% !important;
            margin: 5px 0 10px 0 !important;
            float: none !important;
        }

        .instructions_textarea {
            font-size: 11px !important;
        }
    }
</style>

<div class="main-content" style="min-height:'60px'">
    {{ Breadcrumbs::render('activity_initiate.creat') }}
    @if(session('restore'))
    <script type="text/javascript">
        window.onload = function() {
            Swal.fire('Success!', 'Activity Saved Successfully', 'success');
            myFunction();
        }
    </script>
    @endif
    <!-- Main Content -->
    <section class="section">
        <div class="section-body mt-1">
            <h5 class="text-center" style="color:darkblue">Activity Initiation</h5>
            <form action="{{route('activity_initiate.store')}}" id="userregistration" method="POST">
                @csrf
                <div id="divInstruction"></div>
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <input type="hidden" id="prevData" name="prevData" value="">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="control-label">Enrollment ID</label><span class="error-star" style="color:red;">*</span>
                                            <select class="form-control default" name="enrollment_id" id="enrollment_id" onchange="myFunction()">
                                                <option value="">Select Enrollment ID</option>
                                                @foreach($rows as $row)
                                                    <option value="{{ $row['enrollment_id'] }}" @if(session('restore') != null && $row['enrollment_id'] == session('restore')['value']) selected @endif>
                                                        {{ $row['enrollment_child_num'] }} ({{$row['child_name']}})
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="control-label">Child ID</label><span class="error-star" style="color:red;">*</span>
                                            <input class="form-control" type="text" id="child_id" name="child_id" autocomplete="off" readonly>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="control-label">Child Name</label><span class="error-star" style="color:red;">*</span>
                                            <input class="form-control" type="text" id="child_name" name="child_name" autocomplete="off" readonly>
                                        </div>
                                    </div>
                                    <input type="hidden" id="user_id" name="user_id" value="">
                                    <input type="hidden" id="descriptionID" name="descriptionID" value="">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="control-label">Initiated By</label><span class="error-star" style="color:red;">*</span>
                                            <input class="form-control" type="text" id="initiated_by" name="initiated_by" value=" {{$email[0]['email'] }}" autocomplete="off" readonly>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="control-label">Initiated To</label><span class="error-star" style="color:red;">*</span>
                                            <input class="form-control" type="text" id="initiated_to" name="initiated_to" autocomplete="off" readonly>
                                        </div>
                                    </div>

                                    <input type="hidden" id="actionBtn" name="actionBtn">
                                    <div class="col-md-4" id="divActivityName" style="display: none;">
                                        <div class="form-group">
                                            <label class="control-label">Activity Name</label><span class="error-star" style="color:red;">*</span>
                                            <select class="js-select5 form-control" name="activity_id[]" id="activity_id" onchange="Description()" multiple="multiple">
                                                <option value="">Select Activity Set</option>
                                                @foreach($activity as $key=>$active)
                                                    <option value="{{ $active['activity_id'] }}">{{ $active['activity_name'] }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row col-md-12" style="display: none;" id="description_table"></div>

                    <div class="col-md-12 text-center" style="padding-top: 1rem; display:none" id="description_table_submit">
                        <div class="action-buttons-wrapper">
                            <a type="button" onclick="save('Submit')" class="btn-action" title="Initiation">
                                <i class="fa fa-check"></i> Activity Initiation
                            </a>
                            <a type="button" onclick="save('Save')" class="btn-action" title="Save">
                                <i class="fa fa-check"></i> Save
                            </a>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </section>
</div>

<script type="text/javascript">
    $(".js-select5").select2({
        closeOnSelect: false,
        placeholder: "Select Activity",
        allowHtml: true,
        allowClear: true,
        tags: true
    }).on('select2:selecting', e => $(e.currentTarget).data('scrolltop', $('.select2-results__options').scrollTop()))
      .on('select2:select', e => $('.select2-results__options').scrollTop($(e.currentTarget).data('scrolltop')))
      .on('select2:unselect', function(e) {
          var deselectedOption = e.params.data.id;
          var selectedOptionText = e.params.data.text;
          deselectactivity(deselectedOption, selectedOptionText);
      });

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    function myFunction() {
        var enrollment_id = $("select[name='enrollment_id']").val();
        if (enrollment_id != "") {
            $.ajax({
                url: "{{ url('/activityinitiate/ajax') }}",
                type: 'POST',
                data: {
                    'enrollment_id': enrollment_id,
                    _token: '{{csrf_token()}}'
                }
            }).done(function(data) {
                if (data != '[]') {
                    var savedActivity = data.savedActivity[0].savedActivity;
                    if (savedActivity != null) {
                        savedActivity = savedActivity.split(',').map(Number);
                    } else {
                        savedActivity = '';
                    }
                    var activityList = data.activity;
                    data = data.enrollmentID;
                    document.getElementById('child_id').value = data[0].child_id;
                    document.getElementById('child_name').value = data[0].child_name;
                    document.getElementById('initiated_to').value = data[0].child_contact_email;
                    document.getElementById('user_id').value = data[0].user_id;

                    var ddd = "<option value=''>Select Activity Set</option>";
                    for (var i = 0; i < activityList.length; i++) {
                        var activity_id = activityList[i]['activity_id'];
                        var activity_name = activityList[i]['activity_name'];
                        ddd += "<option value=" + activity_id + (savedActivity.includes(activity_id) ? " selected" : "") + ">" + activity_name + "</option>";
                    }
                    $('#activity_id').html(ddd);
                    Description();
                    $('#divActivityName').show();
                } else {
                    $('#child_name').html('<option value="child_name">Select Enrollment_child_num</option>');
                }
            })
        } else {
            $('#divActivityName').hide();
            document.getElementById('child_id').value = '';
            document.getElementById('child_name').value = '';
            document.getElementById('initiated_to').value = '';
            document.getElementById('user_id').value = '';
        }
    };

    var ini_activity_id = [0];
    var extractedValues = [];
    var data1 = [0];
    var data2 = [];
    var data3 = [];

    function Description() {
        var activity_id = $("select[name='activity_id[]']").val();
        for (var i = 0; i < activity_id.length; i++) {
            var value = activity_id[i];
            if (!extractedValues.includes(value)) {
                extractedValues.push(value);
            } else {
                activity_id.splice(i, 1);
                i--;
            }
        }
        var enrollment_id = $("select[name='enrollment_id']").val();
        if (enrollment_id == '') {
            swal.fire("Please Select Enrollment Child Number: ", "", "error");
            return false;
        }
        if (activity_id != "") {
            $.ajax({
                url: "{{ route('parentvideo.description') }}",
                type: 'POST',
                data: {
                    'activity_id': activity_id,
                    'enrollment_id': enrollment_id,
                    _token: '{{csrf_token()}}'
                }
            }).done(function(data) {
                var active = data.active;
                var initiated = data.initiated[0].initiated;
                var prevData = data.prevData;
                var savedDescription = data.savedDescription[0].savedDescription;
                if (savedDescription == null) {
                    savedDescription = [];
                    var idArray = [];
                } else {
                    var idArray = savedDescription.split(',').map(Number);
                }
                document.getElementById('prevData').value = prevData[0].co;
                var dataSet = data.id;
                if (dataSet != '[]') {
                    var optionsdata = "";
                    for (var ij = 0; ij < dataSet.length; ij++) {
                        var data_set = dataSet[ij];
                        var activity_title = data_set[ij].activity_name;
                        var activity_id = data_set[ij].activity_id;
                        optionsdata += '<details class="accordion" id="accordion_id' + activity_id + '">';
                        optionsdata += '<summary class="accordion__title">' + activity_title + '</summary>';
                        optionsdata += '<div class="accordion__content">';
                        optionsdata += '<div class="table-wrapper"><div class="table-responsive">';
                        optionsdata += '<input oninput="search(event , ' + activity_id + ')" id="search_' + activity_id + '" style="width: 30%;float: right;margin: 0 15px 0px 0px;" type="text" class="form-control default" placeholder="Search">';
                        optionsdata += '<table class="table table-bordered"><thead><th width="10%">Sl.No</th><th width="30%">Activity Name</th><th width="45%">Activity Description</th><th width="15%">Active/InActive</th></thead>';
                        optionsdata += '<tbody id="table_' + activity_id + '">';
                        var filteredActive = active.filter(item => item.activity_id === activity_id);
                        for (var i = 0; i < data_set.length; i++) {
                            var id = data_set[i].activity_description_id;
                            var name = data_set[i].description;
                            var activeItem = filteredActive.find(item => item.activity_description_id === id);
                            if (activeItem) {
                                var instruction = activeItem.instruction || '';
                            } else {
                                var instruction = data_set[i].instruction;
                            }
                            data1.push(id);
                            if (idArray.includes(id)) {
                                optionsdata += "<tr><td style='border: 1px solid black !important;'>" + (parseInt(i) + 1) + "</td><td style='border: 1px solid black !important;' id=" + id + " >" + name + "</td><td style='border: 1px solid black !important;'> <div contenteditable='true' style='height:100px;overflow-y: scroll;' class='instructions_textarea' id='instructions[" + id + "]' name='instructions' data-instructions=" + id + ">" + instruction + "</div></td><td style='text-align:center;border: 1px solid black !important;'><label class='switch' data-bs-toggle='tooltip' data-bs-placement='top' title='Enable / Disable'><input type='checkbox' checked class='toggle_status is_active id_active" + activity_id + "' onclick='active_function(" + id + ")' id='active_id' name='is_active'><span class='slider round'></span></label></td></tr>";
                                active_function(id);
                            } else {
                                optionsdata += "<tr><td style='border: 1px solid black !important;'>" + (parseInt(i) + 1) + "</td><td style='border: 1px solid black !important;' id=" + id + " >" + name + "</td><td style='border: 1px solid black !important;'> <div contenteditable='true' style='height:100px;overflow-y: scroll;' class='instructions_textarea' id='instructions[" + id + "]' name='instructions' data-instructions=" + id + ">" + instruction + "</div></td><td style='text-align:center;border: 1px solid black !important;'><label class='switch' data-bs-toggle='tooltip' data-bs-placement='top' title='Enable / Disable'><input type='checkbox' class='toggle_status is_active id_active" + activity_id + "' onclick='active_function(" + id + ")' id='active_id' name='is_active'><span class='slider round'></span></label></td></tr>";
                            }
                        }
                        data2.push(activity_id);
                        data3.push(activity_title);
                        optionsdata += '</tbody></table></div></div>';
                        optionsdata += '</div></details>';
                    }
                    $('#description_table').append(optionsdata);
                    $('#description_table').show();
                    $('#description_table_submit').show();
                    ini_activity_id.push(activity_id);
                }
                tinymce.init({
                    selector: '.instructions_textarea',
                    height: 150,
                    menubar: false,
                    branding: false,
                    inline: true,
                    plugins: 'link',
                    toolbar: 'undo redo | formatselect | bold italic backcolor link removeformat',
                });
            })
        }
    };

    function active_function(id) {
        var check = 0;
        for (var i = 0; i < data1.length; i++) {
            if (data1[i] === id) {
                data1.splice(i, 1);
                check = 1;
            }
        }
        if (check == 0) {
            data1.push(id);
        }
    }

    function save(id) {
        var prevData = document.getElementById('prevData').value;
        var instruction_textareas = document.querySelectorAll('.instructions_textarea');
        instruction_textareas.forEach(function(textarea) {
            var content = tinymce.get(textarea.id).getContent();
            content = content.replace(/'/g, "%27");
            var encodedContent = encodeURIComponent(content);
            var i_id = textarea.getAttribute('data-instructions');
            var htmlDum = "<input type='hidden' name='get_instructions[" + i_id + "]' id='get_instructions' value='" + encodedContent + "'>";
            $('#divInstruction').append(htmlDum);
        });
        document.getElementById('actionBtn').value = id;
        document.getElementById('descriptionID').value = data1;
        var enrollment_id = $('#enrollment_id').val();
        if (enrollment_id == '') {
            swal.fire("Please Select Enrollment Child Number: ", "", "error");
            return false;
        }
        var child_id = $('#child_id').val();
        if (child_id == '') {
            swal.fire("Please Enter Child ID:", "", "error");
            return false;
        }
        var child_name = $('#child_name').val();
        if (child_name == '') {
            swal.fire("Please Enter Child Name:", "", "error");
            return false;
        }
        var initiated_by = $('#initiated_by').val();
        if (initiated_by == '') {
            swal.fire("Please Enter Initiated_by:  ", "", "error");
            return false;
        }
        var initiated_to = $('#initiated_to').val();
        if (initiated_to == '') {
            swal.fire("Please Enter Initiated To:  ", "", "error");
            return false;
        }
        var activity_id = $('#activity_id').val();
        if (activity_id == '') {
            swal.fire("Please Select Activity Set  ", "", "error");
            return false;
        }
        var is_active = $('.is_active:checkbox:checked').length;
        if (is_active == 0) {
            swal.fire("Please Enable the Activity", "", "error");
            return false;
        }
        for (var i = 0; i < data2.length; i++) {
            var id_active = $('.id_active' + data2[i] + ':checkbox:checked').length;
            var id_name = data3[i];
            if (id_active == 0) {
                swal.fire("Please Enable the Activity in " + id_name, "", "error");
                return false;
            }
        }
        $(".loader").show();
        document.getElementById('userregistration').submit();
    }

    function search(event, id) {
        var value = event.target.value.toLowerCase();
        $("#table_" + id + " tr").filter(function() {
            $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1);
        });
    }

    function deselectactivity(deselectedOption, selectedOptionText) {
        $('#accordion_id' + deselectedOption).remove();
        extractedValues = extractedValues.filter(value => value !== deselectedOption);
        for (var di = 0; di < data2.length; di++) {
            if (data2[di] == deselectedOption) {
                data2.splice(di, 1);
                di--;
            }
        }
        data3 = data3.filter(value2 => value2 !== selectedOptionText);
    }
</script>

@include('newenrollement.formmodal')
@endsection