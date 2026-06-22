@extends('layouts.adminnav')
@section('content')
<style>
    body {
        background-color: #f4f6f9 !important;
    }

    .screen-title {
        color: #1a237e;
        font-weight: 600;
        margin-bottom: 20px;
    }

    .table-wrapper {
        background: #fff;
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
    }

    /* =========================================================================
       MOBILE RESPONSIVE - EXACTLY AS OVM-1 INDEX
       ========================================================================= */
    .table-responsive {
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
    }

    @media (max-width: 768px) {

        /* Remove extra padding/margins */
        .main-content,
        .card,
        .card-body,
        .table-wrapper,
        .searchResultStudent,
        .table-responsive {
            padding-left: 0 !important;
            padding-right: 0 !important;
            margin-left: 0 !important;
            margin-right: 0 !important;
        }

        .row,
        .col-12,
        .col-lg-12 {
            padding-left: 5px !important;
            padding-right: 5px !important;
        }

        .main-content {
            padding-top: 0 !important;
        }

        .breadcrumb {
            font-size: 11px !important;
            margin-bottom: 10px !important;
            margin-top: 60px !important;
            margin-left: 10px !important;
        }

        .card {
            margin-top: 0 !important;
        }

        .table-responsive {
            overflow-x: hidden !important;
            overflow-y: visible !important;
            max-height: none !important;
        }

        .table-responsive table {
            font-size: 12px;
            min-width: 100% !important;
            width: 100% !important;
        }

        /* Convert table to cards */
        .searchResultStudent table,
        .searchResultStudent thead,
        .searchResultStudent tbody,
        .searchResultStudent th,
        .searchResultStudent td {
            display: block !important;
            width: 100% !important;
        }

        .searchResultStudent thead {
            display: none !important;
        }

        .searchResultStudent tbody {
            background: transparent !important;
        }

        #tableList {
            width: 100% !important;
            margin: 0 !important;
        }

        #tableList tr {
            display: flex !important;
            flex-direction: column !important;
            align-items: stretch !important;
            border: 1px solid #e0e0e0 !important;
            border-radius: 8px !important;
            margin: 8px 5px !important;
            position: relative !important;
            padding: 10px 15px 10px 45px !important;
            background: #fff !important;
            box-shadow: 0 1px 4px rgba(0,0,0,0.05) !important;
            cursor: pointer;
            width: calc(100% - 10px) !important;
        }

        #tableList td {
            display: block !important;
            border: none !important;
            padding: 0 !important;
            text-align: left !important;
            white-space: normal !important;
            width: 100% !important;
            background: transparent !important;
            height: auto !important;
            min-height: 0 !important;
            line-height: 1.2 !important;
        }

        /* Sl No – absolute positioned */
        #tableList td:nth-of-type(1) {
            position: absolute !important;
            left: 15px !important;
            top: 50% !important;
            transform: translateY(-50%) !important;
            width: 25px !important;
            display: flex !important;
            font-weight: bold !important;
            font-size: 13px !important;
            color: #2c3e50 !important;
        }

        #tableList tr.expanded-row td:nth-of-type(1) {
            top: 20px !important;
            transform: translateY(0) !important;
        }

        /* Question – main visible field (column 2) */
        #tableList td:nth-of-type(2) {
            display: block !important;
            font-weight: 600 !important;
            font-size: 16px !important;
            color: #2c3e50 !important;
            margin-bottom: 4px !important;
            padding-right: 25px !important;
            order: 1 !important;
        }

        /* Hide Description (col3), Type (col4), Action (col5) initially */
        #tableList td:nth-of-type(3),
        #tableList td:nth-of-type(4),
        #tableList td:nth-of-type(5) {
            display: none !important;
        }

        /* Arrow */
        #tableList tr::after {
            content: '\f054';
            font-family: 'FontAwesome';
            position: absolute;
            right: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: #bdc3c7;
            transition: transform 0.3s;
            font-size: 12px;
        }

        #tableList tr.expanded-row::after {
            transform: translateY(-50%) rotate(90deg);
            top: 35px;
        }

        /* Expanded: show Description, Type, Action */
        #tableList tr.expanded-row td:nth-of-type(3) {
            display: block !important;
            margin-top: 8px !important;
            font-size: 12px !important;
            color: #34495e !important;
            order: 2 !important;
        }
        #tableList tr.expanded-row td:nth-of-type(3):before {
            content: "Description: ";
            font-weight: 600 !important;
            color: #000 !important;
        }

        #tableList tr.expanded-row td:nth-of-type(4) {
            display: block !important;
            margin-top: 6px !important;
            font-size: 12px !important;
            color: #34495e !important;
            order: 3 !important;
        }
        #tableList tr.expanded-row td:nth-of-type(4):before {
            content: "Type: ";
            font-weight: 600 !important;
            color: #000 !important;
        }

        #tableList tr.expanded-row td:nth-of-type(5) {
            display: flex !important;
            align-items: center !important;
            flex-wrap: nowrap !important;
            gap: 6px !important;
            margin-top: 6px !important;
            order: 4 !important;
            white-space: nowrap !important;
        }
        #tableList tr.expanded-row td:nth-of-type(5):before {
            content: "Action: ";
            font-weight: 600 !important;
            color: #000 !important;
            margin-right: 6px !important;
            flex-shrink: 0 !important;
        }
        #tableList tr.expanded-row td:nth-of-type(5) button {
            display: inline-flex !important;
            align-items: center !important;
            justify-content: center !important;
            margin-right: 0 !important;
            padding: 2px !important;
            font-size: 14px !important;
        }

        /* No records row */
        #tableList td.dataTables_empty {
            display: table-cell !important;
            width: 100% !important;
            text-align: center !important;
            white-space: nowrap !important;
            padding: 15px !important;
            font-size: 13px !important;
            font-weight: 600 !important;
            color: #666 !important;
        }

        #tableList tr:has(td.dataTables_empty) {
            display: table-row !important;
            border: none !important;
            box-shadow: none !important;
            padding: 0 !important;
            background: transparent !important;
        }
        #tableList tr:has(td.dataTables_empty)::after {
            display: none !important;
        }

        /* ---- DataTable controls – search on right, length on left ---- */
        .dataTables_wrapper .row:first-child {
            margin: 0 !important;
            padding: 0 !important;
            display: flex !important;
            flex-wrap: wrap !important;
        }

        .dataTables_wrapper .dataTables_length {
            float: left !important;
            margin-left: 8px !important;
        }

        .dataTables_wrapper .dataTables_filter {
            float: right !important;
            padding-right: 8px !important;
        }

        .dataTables_wrapper .dataTables_length,
        .dataTables_wrapper .dataTables_filter,
        .dataTables_wrapper .dataTables_info,
        .dataTables_wrapper .dataTables_paginate {
            font-size: 10px !important;
        }

        .dataTables_wrapper .dataTables_length select {
            font-size: 11px !important;
            height: 32px !important;
            width: 60px !important;
        }

        .dataTables_wrapper .dataTables_filter input {
            width: 90px !important;
            height: 24px !important;
            font-size: 10px !important;
        }

        /* ---- Pagination & Info on same line - like screenshot 3 ---- */
        .dataTables_wrapper .row:last-child {
            display: flex !important;
            flex-wrap: wrap !important;
            align-items: center !important;
            justify-content: space-between !important;
            padding: 5px 10px !important;
            margin: 0 !important;
        }

        .dataTables_wrapper .dataTables_info {
            float: left !important;
            padding-top: 8px !important;
            font-size: 11px !important;
        }

        .dataTables_wrapper .dataTables_paginate {
            float: right !important;
            padding-top: 5px !important;
            text-align: right !important;
        }

        .dataTables_wrapper .dataTables_paginate .paginate_button {
            padding: 3px 8px !important;
            margin: 0 2px !important;
            font-size: 11px !important;
            border-radius: 3px !important;
        }

        .dataTables_wrapper .dataTables_paginate .paginate_button.current {
            background: #044a95 !important;
            color: white !important;
            border: 1px solid #044a95 !important;
        }

        .dataTables_wrapper .dataTables_paginate .paginate_button:hover {
            background: #e9ecef !important;
        }

        /* ---- Title – ensure visible with margin top ---- */
        .screen-title {
            font-size: 18px !important;
            margin-top: 20px !important;
            margin-bottom: 10px !important;
        }

        /* ---- Add Question button – left aligned, auto width ---- */
        .row.mb-3 .col-lg-12.text-left {
            text-align: left !important;
            padding-left: 10px !important;
        }

        .btn-labeled.btn-info {
            width: auto !important;
            display: inline-block !important;
            padding: 6px 12px !important;
            font-size: 13px !important;
            white-space: nowrap !important;
        }

        /* Hide icon on mobile */
        .btn-labeled.btn-info .btn-label,
        .btn-labeled.btn-info i {
            display: none !important;
        }

        /* ---- Modals full-screen on mobile ---- */
        .modal-dialog {
            max-width: 95% !important;
            margin: 10px auto !important;
        }
        .modal-dialog.modal-lg {
            max-width: 95% !important;
        }
        .modal-body {
            padding: 10px !important;
        }
        .modal-header h5 {
            font-size: 16px !important;
        }
        .modal-footer .btn {
            font-size: 12px !important;
            padding: 6px 12px !important;
        }
    }
</style>

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

<div class="main-content">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <!-- Title -->
                    <div class="row mb-2">
                        <div class="col-lg-12 text-center">
                            <h4 class="screen-title"><b>Parent Reflection Form</b></h4>
                        </div>
                    </div>

                    <!-- Add Button -->
                    <div class="row mb-3">
                        <div class="col-lg-12 text-left">
                            <button type="button" class="btn btn-labeled btn-info" data-toggle="modal" data-target="#addModal" title="Add Question" style="background: #044a95 !important; border-color:#a9ca !important; color:white !important; margin-top: 0.5rem;">
                                <span class="btn-label" style="font-size:15px; padding:8px;"><i class="fa fa-plus"></i></span>
                                <span style="font-size:15px; padding:8px;">Add Question</span>
                            </button>
                        </div>
                    </div>

                    <!-- Table -->
                    <div class="table-wrapper">
                        <div class="table-responsive searchResultStudent">
                            <table class="table table-bordered table-striped" id="tableList" width="100%">
                                <thead>
                                    <tr>
                                        <th style="width:5%;">Sl. No.</th>
                                        <th style="width:25%;">Question</th>
                                        <th style="width:25%;">Description</th>
                                        <th style="width:15%;">Type</th>
                                        <th style="width:10%; text-align:center;">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                    $typeMapping = [
                                    1 => 'Short Answer',
                                    2 => 'Paragraph',
                                    3 => 'Dropdown',
                                    4 => 'Radio Button',
                                    5 => 'Check Box'
                                    ];
                                    @endphp
                                    @foreach($rows as $key => $data)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $data['question'] }}</td>
                                        <td>{{ $data['question_description'] }}</td>
                                        <td>{{ isset($data['field_types_id']) && isset($typeMapping[$data['field_types_id']]) ? $typeMapping[$data['field_types_id']] : 'Short Answer' }}</td>
                                        <td class="text-center">
                                            <!-- Edit -->
                                            <button class="btn btn-link p-0 mr-2" title="Edit" onclick="openSetting('{{$data['id']}}')">
                                                <i class="fas fa-pencil-alt" style="color: green !important; font-size: 15px;"></i>
                                            </button>

                                            <!-- Delete -->
                                            <button class="btn btn-link p-0" title="Delete" onclick="deleteQuestion('{{$data['id']}}')">
                                                <i class="fas fa-trash-alt" style="color: red !important; font-size: 15px;"></i>
                                            </button>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Add Modal -->
    <div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="addModalTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add Question</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body" style="background-color:#f8f9fa;">
                    <form action="{{ route('master.gform.store') }}" method="post" id="addQuestionForm">
                        @csrf
                        <input type="hidden" id="add_type_id" name="type_id" value="1">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="control-label required">Question</label>
                                    <input class="form-control default" type="text" id="add_question" name="question" required>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="control-label">Description</label>
                                    <input class="form-control default" type="text" id="add_description" name="description">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label required">Question Type</label>
                                    <select class="form-control default" name="field_types_id" id="add_field_types_id" onchange="handleAddTypeChange()" required>
                                        <option value="1">Short Answer</option>
                                        <option value="2">Paragraph</option>
                                        <option value="3">Dropdown</option>
                                        <option value="5">Check Box</option>
                                        <option value="4">Radio Button</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label">Required</label><br>
                                    <label class='switch'>
                                        <input type='checkbox' id="add_required" name='required' value="1">
                                        <span class='slider round'></span>
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-12" id="add_options_container" style="display:none;">
                                <div class="form-group">
                                    <label class="control-label required">Options</label>
                                    <div id="add_dynamic_options"></div>
                                    <button type="button" class="btn btn-sm btn-outline-primary mt-2" onclick="addOptionRow('add_dynamic_options')">
                                        <i class="fas fa-plus"></i> Add Option
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" onclick="submitAddQuestion()" class="btn btn-success">Add Question</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Modal -->
    <div class="modal fade" id="settingModal" tabindex="-1" role="dialog" aria-labelledby="settingModalTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Question</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body" style="background-color:#f8f9fa;">
                    <form action="{{ route('master.gform.update') }}" method="post" id="saveChangesForm">
                        @csrf
                        <input type="hidden" id="edit_id" name="id">
                        <input type="hidden" id="edit_type_id" name="type_id">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="control-label required">Question</label>
                                    <input class="form-control default" type="text" id="edit_question" name="question" required>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="control-label">Description</label>
                                    <input class="form-control default" type="text" id="edit_description" name="description">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label required">Question Type</label>
                                    <select class="form-control default" name="field_types_id" id="edit_field_types_id" onchange="handleEditTypeChange()" required>
                                        <option value="1">Short Answer</option>
                                        <option value="2">Paragraph</option>
                                        <option value="3">Dropdown</option>
                                        <option value="5">Check Box</option>
                                        <option value="4">Radio Button</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label required">Required</label><br>
                                    <label class='switch'>
                                        <input type='checkbox' id="edit_required" name='required' value="1">
                                        <span class='slider round'></span>
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-12" id="edit_options_container" style="display:none;">
                                <div class="form-group">
                                    <label class="control-label required">Options</label>
                                    <div id="edit_dynamic_options"></div>
                                    <button type="button" class="btn btn-sm btn-outline-primary mt-2" onclick="addOptionRow('edit_dynamic_options')">
                                        <i class="fas fa-plus"></i> Add Option
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" onclick="submitSaveChanges()" class="btn btn-success">Save changes</button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    var rows = <?php echo json_encode($rows); ?>;

    $(document).ready(function() {
        // Safe DataTable init
        if ($.fn.DataTable.isDataTable('#tableList')) {
            $('#tableList').DataTable().destroy();
        }
        $('#tableList').DataTable({
            "pageLength": 10,
            "language": {
                "search": "_INPUT_",
                "searchPlaceholder": "Search..."
            }
        });

        // ---- Row expansion on mobile ----
        $('#tableList tbody').on('click', 'tr', function(e) {
            // Ignore clicks inside action buttons
            if ($(e.target).closest('button').length) {
                return;
            }
            if ($(window).width() <= 768) {
                $(this).toggleClass('expanded-row');
            }
        });
    });

    function addOptionRow(containerId, value = '') {
        let html = `
        <div class="d-flex mb-2 align-items-center">
            <input class="form-control default other_option_input flex-grow-1" type="text" name="other_option[]" value="${value}" placeholder="Enter option" required>
            <button type="button" class="btn btn-danger ml-2" onclick="removeOptionRow(this)"><i class="fas fa-trash"></i></button>
        </div>
    `;
        $('#' + containerId).append(html);
    }

    function removeOptionRow(btn) {
        if ($(btn).closest('.form-group').find('.d-flex').length > 1) {
            $(btn).closest('.d-flex').remove();
        } else {
            Swal.fire('Warning', 'At least one option is required.', 'warning');
        }
    }

    function handleAddTypeChange() {
        var type = $('#add_field_types_id').val();
        if (['3', '4', '5'].includes(type)) {
            $('#add_options_container').show();
            $('#add_dynamic_options input').attr('required', true);
            if ($('#add_dynamic_options').children().length === 0) addOptionRow('add_dynamic_options');
        } else {
            $('#add_options_container').hide();
            $('#add_dynamic_options input').removeAttr('required');
        }
    }

    function handleEditTypeChange() {
        var type = $('#edit_field_types_id').val();
        if (['3', '4', '5'].includes(type)) {
            $('#edit_options_container').show();
            $('#edit_dynamic_options input').attr('required', true);
            if ($('#edit_dynamic_options').children().length === 0) addOptionRow('edit_dynamic_options');
        } else {
            $('#edit_options_container').hide();
            $('#edit_dynamic_options input').removeAttr('required');
        }
    }

    function openSetting(id) {
        for (var i = 0; i < rows.length; i++) {
            if (rows[i].id == id) {
                $('#edit_question').val(rows[i].question);
                $('#edit_description').val(rows[i].question_description);
                $('#edit_id').val(rows[i].id);
                $('#edit_type_id').val(rows[i].type_id);
                $("#edit_required").prop("checked", rows[i].required == 1);

                var fieldType = rows[i].field_types_id ? rows[i].field_types_id : 1;
                $('#edit_field_types_id').val(fieldType);

                $('#edit_dynamic_options').empty();
                if (['3', '4', '5'].includes(fieldType.toString())) {
                    $('#edit_options_container').show();
                    if (rows[i].other_option) {
                        if (fieldType.toString() === '5') {
                            // Checkbox: Match everything inside brackets as ONE option
                            let matches = rows[i].other_option.match(/\[(.*?)\]/g);
                            if (matches) {
                                matches.forEach(opt => {
                                    let cleanOpt = opt.replace(/[\[\]]/g, '').trim();
                                    if (cleanOpt !== '') addOptionRow('edit_dynamic_options', cleanOpt);
                                });
                            }
                        } else {
                            // Dropdown & Radio Button: Comma-separated options without brackets
                            let options = rows[i].other_option.split(',');
                            options.forEach(opt => {
                                let cleanOpt = opt.trim();
                                if (cleanOpt !== '') addOptionRow('edit_dynamic_options', cleanOpt);
                            });
                        }
                    }
                    if ($('#edit_dynamic_options').children().length === 0) addOptionRow('edit_dynamic_options');
                } else {
                    $('#edit_options_container').hide();
                }
                break;
            }
        }
        $('#settingModal').modal('show');
    }

    function submitSaveChanges() {
        if (!$('#edit_question').val()) {
            Swal.fire('Warning!', 'Question is required.', 'warning');
            return;
        }
        var type = $('#edit_field_types_id').val();
        if (['3', '4', '5'].includes(type) && $('#edit_dynamic_options input').filter(function() {
                return this.value.trim() == "";
            }).length > 0) {
            Swal.fire('Warning!', 'All options must be filled. Please remove empty options.', 'warning');
            return;
        }
        document.getElementById('saveChangesForm').submit();
    }

    function submitAddQuestion() {
        if (!$('#add_question').val()) {
            Swal.fire('Warning!', 'Question is required.', 'warning');
            return;
        }
        var type = $('#add_field_types_id').val();
        if (['3', '4', '5'].includes(type) && $('#add_dynamic_options input').filter(function() {
                return this.value.trim() == "";
            }).length > 0) {
            Swal.fire('Warning!', 'All options must be filled. Please remove empty options.', 'warning');
            return;
        }
        document.getElementById('addQuestionForm').submit();
    }

    function deleteQuestion(id) {
        Swal.fire({
            title: 'Are you sure?',
            text: "This will delete the question!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "{{ route('master.gform.update') }}",
                    type: "POST",
                    data: {
                        _token: "{{ csrf_token() }}",
                        id: id,
                        delete_flag: 1
                    },
                    success: function(res) {
                        Swal.fire('Question Deleted Successfully', '', 'success').then(() => {
                            location.reload();
                        });
                    },
                    error: function(err) {
                        Swal.fire('Error!', 'Something went wrong', 'error');
                    }
                });
            }
        });
    }
</script>
@endsection