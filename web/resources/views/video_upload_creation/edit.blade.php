@extends('layouts.adminnav')

@section('content')

<style>
    input[type=checkbox] {
        display: inline-block;
    }

    h4 {
        text-align: center;
    }

    .question {
        background-color: white;
        border-radius: 12px !important;
        margin-top: 2rem;
    }

    .question label {
        text-align: center;
    }

    .questionnaire {
        text-align: center;
    }

    .btn-success {
        margin: auto;
    }

    /* Fix for TinyMCE */
    .tox .tox-edit-area {
        text-align: left !important;
    }
    .tox .tox-edit-area__iframe {
        text-align: left !important;
    }
    .tox-tinymce {
        border: 1px solid #ced4da !important;
        border-radius: 4px !important;
        width: 100% !important;
    }

    /* ---- Desktop default: description & instruction side by side ---- */
    .multi-field {
        display: flex;
        align-items: flex-start;
        gap: 10px;
        margin-bottom: 15px;
        width: 100%;
        background-color: #f8f9fa;
        padding: 10px;
        border-radius: 5px;
    }

    .multi-field .col-4 {
        width: 33.33%;
        flex: 0 0 33.33%;
    }

    .multi-field .col-7 {
        width: 58.33%;
        flex: 0 0 58.33%;
    }

    /* Hide the inner "Instruction" label on desktop */
    .inner-instruction-label {
        display: none;
    }

    /* ============================================================
       MOBILE RESPONSIVE – screens ≤ 768px
       ============================================================ */
    @media (max-width: 768px) {

        /* Reset paddings and prevent horizontal scroll */
        .main-content,
        .card,
        .card-body,
        .form-group,
        .table-wrapper,
        .table-responsive {
            padding-left: 0 !important;
            padding-right: 0 !important;
            margin-left: 0 !important;
            margin-right: 0 !important;
            overflow-x: hidden !important;
            max-width: 100% !important;
        }

        .row,
        .col-12,
        .col-md-3,
        .col-md-6,
        .col-lg-12 {
            padding-left: 5px !important;
            padding-right: 5px !important;
            margin-left: 0 !important;
            margin-right: 0 !important;
        }

        .main-content {
            padding-top: 0 !important;
        }

        .breadcrumb {
            font-size: 10px !important;
            margin: 60px 10px 10px 10px !important;
            white-space: nowrap !important;
            overflow: hidden !important;
            text-overflow: ellipsis !important;
            display: flex !important;
            flex-wrap: nowrap !important;
            padding: 6px 10px !important;
        }

        .breadcrumb li {
            display: inline !important;
            white-space: nowrap !important;
        }

        .card {
            margin-top: 0 !important;
        }

        h4 {
            font-size: 18px !important;
        }

        /* Stack columns */
        .col-md-3,
        .col-md-6 {
            width: 100% !important;
            flex: 0 0 100% !important;
            max-width: 100% !important;
        }

        .col-md-12 {
            width: 100% !important;
            flex: 0 0 100% !important;
            max-width: 100% !important;
            padding-left: 0 !important;
            padding-right: 0 !important;
        }

        /* Form inputs full width */
        .form-control,
        .form-control[type="text"],
        .form-control[type="number"],
        textarea.form-control,
        select.form-control {
            font-size: 14px !important;
            height: auto !important;
            padding: 8px 10px !important;
            width: 100% !important;
        }

        /* Labels */
        .control-label {
            font-size: 13px !important;
        }

        /* ---- Center the "Activity Description" label ---- */
        .desc-label {
            text-align: center !important;
            display: block !important;
            width: 100% !important;
        }

        /* ---- Show the inner "Instruction" label on mobile ---- */
        .inner-instruction-label {
            display: block !important;
            font-size: 13px;
            font-weight: 600;
            margin-bottom: 4px;
        }

        /* ---- Multi-field: stack vertically ---- */
        .multi-field {
            flex-direction: column !important;
            align-items: stretch !important;
            padding: 10px !important;
            gap: 10px !important;
        }

        .multi-field .col-4,
        .multi-field .col-7 {
            flex: 0 0 100% !important;
            width: 100% !important;
            max-width: 100% !important;
        }

        /* Force description input and textarea to take full width */
        .multi-field input[type="text"],
        .multi-field textarea {
            width: 100% !important;
            max-width: 100% !important;
        }

        .multi-field .remove-field {
            align-self: flex-end !important;
            margin-top: 4px !important;
            flex: 0 0 auto !important;
        }

        /* Add Description button – full width */
        .add-field {
            width: 100% !important;
            margin-top: 6px !important;
            font-size: 14px !important;
            padding: 8px !important;
        }

        /* ---- Submit and Cancel buttons – inline (side by side) ---- */
        .col-md-12.text-center {
            display: flex !important;
            flex-direction: row !important;
            flex-wrap: wrap !important;
            justify-content: center !important;
            align-items: center !important;
            gap: 10px !important;
        }

        .col-md-12.text-center .btn,
        .col-md-12.text-center a.btn {
            width: auto !important;
            min-width: 100px !important;
            margin: 0 !important;
            font-size: 14px !important;
            padding: 8px 20px !important;
            flex: 0 0 auto !important;
        }

        /* ---- Hide icons inside buttons on mobile ---- */
        .col-md-12.text-center .btn .fa,
        .col-md-12.text-center a.btn .fa {
            display: none !important;
        }

        /* Fix TinyMCE editor container */
        .tox-tinymce {
            max-width: 100% !important;
        }
    }
</style>

<div class="main-content">
    {{ Breadcrumbs::render('video_creation.edit', $rows[0]['activity_description_id']) }}
    <div class="section-body mt-0">
        <h4 style="color:darkblue">SAIL Activity Master</h4>

        <form action="{{ route('video_creation.update', $rows[0]['activity_description_id']) }}" method="POST" id="videouploadcreation" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="card question">
                <div class="row" style="margin-bottom: 15px; margin-top: 20px;">
                    <div class="col-md-6">
                        <div class="form-group questionnaire">
                            <label class="control-label">Activity Name</label>
                            <input class="form-control" style="background-color: white !important;" type="text" id="activity_name" name="activity_name" value="{{ $rows[0]['activity_name'] }}" autocomplete="off">
                        </div>
                    </div>
                    <div class="col-md-6"></div>

                    <div class="col-md-12">
                        <div class="form-group questionnaire">
                            <label class="control-label desc-label">Activity Description</label>
                            <div class="multi-field-wrapper">
                                <div class="multi-fields">
                                    @foreach($rows as $key => $row)
                                    <div class="multi-field">
                                        <input type="text" class="form-control col-4"
                                            name="description[{{ $row['activity_description_id'] }}]"
                                            value="{{ $row['description'] }}" autocomplete="off" style="background-color:white !important" placeholder="Enter description">

                                        <div class="col-7" style="padding:0; display:flex; flex-direction:column; width:100%;">
                                            <label class="inner-instruction-label">Instruction</label>
                                            <textarea class="form-control tinymce-body"
                                                name="instruction[{{ $row['activity_description_id'] }}]"
                                                rows="4" placeholder="Enter instruction">{{ $row['instruction'] }}</textarea>
                                        </div>

                                        <button class="remove-field btn btn-danger pull-right" type="button">X</button>
                                    </div>
                                    @endforeach
                                </div>
                                <button type="button" class="add-field btn btn-success">Add Description</button>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12 text-center">
                        <a type="button" onclick="submitForm()" id="submitbutton" class="btn btn-labeled btn-success" title="submit" style="background: green !important; border-color:green !important; color:white !important">
                            <span class="btn-label" style="font-size:13px !important;"><i class="fa fa-check"></i></span>Update
                        </a>
                        <a class="btn btn-danger" href="{{ route('video_creation.index') }}"><i class="fa fa-times" aria-hidden="true"></i> Cancel</a>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Template for new row (hidden) -->
<div id="new-row-template" style="display: none;">
    <div class="multi-field">
        <input type="text" class="form-control col-4" name="description[new][]" value="" style="background-color:white !important" autocomplete="off" placeholder="Enter description">
        <div class="col-7" style="padding:0; display:flex; flex-direction:column; width:100%;">
            <label class="inner-instruction-label">Instruction</label>
            <textarea class="form-control tinymce-body" name="instruction[new][]" rows="4" placeholder="Enter instruction"></textarea>
        </div>
        <button class="remove-field btn btn-danger pull-right" type="button">X</button>
    </div>
</div>

<script>
    function initTinyMCE(selector) {
        tinymce.init({
            selector: selector,
            height: 180,
            menubar: false,
            branding: false,
            plugins: 'link lists',
            toolbar: 'undo redo | formatselect | bold italic backcolor link | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | removeformat',
            content_style: 'body { font-family:Helvetica,Arial,sans-serif; font-size:14px; }'
        });
    }

    $(document).ready(function() {
        initTinyMCE('.tinymce-body');
    });

    function submitForm() {

        if (tinymce) {
            tinymce.triggerSave();
        }

        var activity_name = $('#activity_name').val();

        if ($.trim(activity_name) === "") {
            Swal.fire("Please Enter Activity Name", "", "error");
            return false;
        }

        var emptyDescriptionRows = [];
        var rowNumber = 1;

        // Check only newly added rows
        $('.multi-fields .multi-field').each(function() {

            var descriptionField = $(this).find('input[name="description[new][]"]');

            if (descriptionField.length > 0) {

                if ($.trim(descriptionField.val()) === "") {
                    emptyDescriptionRows.push(rowNumber);
                }

                rowNumber++;
            }

        });

        if (emptyDescriptionRows.length > 0) {
            Swal.fire({
                title: "Validation Error",
                text: "Please enter description for newly added row",
                icon: "error",
                confirmButtonColor: '#3085d6'
            });
            return false;
        }

        // ✅ Confirmation popup
        Swal.fire({
            title: "Are you sure?",
            text: "Do you want to Update this activity?",
            icon: "question",
            showCancelButton: true,
            confirmButtonText: "Yes, Update",
            cancelButtonText: "No",
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('videouploadcreation').submit();
            }
        });
    }

    $('.multi-field-wrapper').each(function() {
        var $wrapper = $('.multi-fields', this);
        var template = $('#new-row-template').html();

        $(".add-field", $(this)).click(function(e) {
            var $newRow = $(template);
            $wrapper.append($newRow);
            initTinyMCE('.tinymce-body');
        });

        $wrapper.on('click', '.remove-field', function() {
            if ($('.multi-field', $wrapper).length > 1) {
                var $field = $(this).closest('.multi-field');
                var textarea = $field.find('textarea');
                if (textarea.length) {
                    tinymce.remove(textarea[0]);
                }
                $field.remove();
            } else {
                bootbox.alert({
                    title: "Metadata creation",
                    centerVertical: true,
                    message: "At least one description is required.",
                });
            }
        });
    });
</script>

@endsection