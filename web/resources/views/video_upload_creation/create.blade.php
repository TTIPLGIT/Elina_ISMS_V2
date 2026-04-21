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

    /* Fix for TinyMCE text alignment and wrapping */
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
    }

    /* Style for the instruction container */
    .instruction-container {
        flex: 1;
        min-width: 300px;
    }

    .swal2-confirm {
        background-color: #3085d6 !important;
        border: none !important;
    }

    .swal2-cancel {
        background-color: #d33 !important;
        border: none !important;
    }
</style>

<div class="main-content">
    {{ Breadcrumbs::render('video_creation.create') }}
    <div class="section-body mt-0">
        <h4 style="color:darkblue">SAIL Activity Master Creation</h4>

        <form action="{{route('video_creation.store')}}" method="POST" id="videouploadcreation" enctype="multipart/form-data">
            @csrf
            <div class="card question">
                <div class="row" style="margin-bottom: 15px;margin-top: 20px;">
                    <div class="col-md-3">
                        <div class="form-group questionnaire">
                            <label class="control-label required">Group(Age)</label>
                            <select class="form-control default age" id="age" name="age" onchange="categorizedquestion()">
                                <option value="">Select-Group</option>
                                <option value="Age of 6-12 yrs">Age of 6-12 yrs</option>
                                <option value="13+">Age of 13+ yrs</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3 Categorytype" style="display:none;">
                        <div class="form-group questionnaire">
                            <label class="control-label required">Category</label>
                            <select class="form-control default Category" id="Category" name="Category">
                                <option value="">Select-Type</option>
                                <option value="1">Parent</option>
                                <option value="2">Child</option>
                                <option value="3">All</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group questionnaire">
                            <label class="control-label required">Activity Name</label>
                            <input class="form-control default" type="text" id="activity_name" name="activity_name" autocomplete="off">
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="form-group questionnaire">
                            <label class="control-label required" style="margin-left:-300px">Activity Description </label>
                            <label class="control-label" style="margin-left:300px">Activity Instruction</label>
                            <div class="multi-field-wrapper">
                                <div class="multi-fields">
                                    <!-- First row -->
                                    <div class="multi-field" style="display: flex;margin-bottom: 5px;">
                                        <input type="text" class="form-control default col-4" name="description[]" id="description_0" value="">
                                        <div class="instruction-container">
                                            <textarea class="form-control tinymce-body" name="instruction[]" id="instruction_0" style="height: 180px; width: 100%;"></textarea>
                                        </div>
                                        <button class="remove-field btn btn-danger pull-right" type='button'>X</button>
                                        &nbsp;
                                    </div>
                                </div>
                                <button type="button" class="add-field btn btn-success">Add Description</button>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12 text-center">
                        <button type="button" onclick="submitForm()" id="submitbutton" class="btn btn-labeled btn-success" title="submit" style="background: green !important; border-color:green !important; color:white !important">
                            <span class="btn-label" style="font-size:13px !important;"><i class="fa fa-check"></i></span> Submit
                        </button>
                        <a class="btn btn-danger" href="{{route('video_creation.index')}}"><i class="fa fa-times" aria-hidden="true"></i> Cancel </a>&nbsp;
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Include TinyMCE and SweetAlert -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/tinymce/6.8.3/tinymce.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    $(document).ready(function() {
        // Initialize TinyMCE for all existing fields
        setTimeout(function() {
            initAllTinyMCE();
        }, 500);

        // Setup remove button functionality
        setupRemoveButtons();
    });

    function initAllTinyMCE() {
        // First, remove all existing TinyMCE instances
        if (tinymce) {
            tinymce.remove();
        }

        // Initialize TinyMCE for each textarea with class tinymce-body
        $('.tinymce-body').each(function(index) {
            var textareaId = $(this).attr('id');
            if (textareaId) {
                // Small delay between initializations
                setTimeout(function() {
                    initTinyMCE(textareaId);
                }, index * 200);
            }
        });
    }

    function initTinyMCE(selector) {
        // Check if instance already exists and remove it
        if (tinymce.get(selector)) {
            tinymce.get(selector).remove();
        }

        tinymce.init({
            selector: '#' + selector,
            height: 180,
            menubar: false,
            branding: false,
            plugins: 'link',
            toolbar: 'undo redo | formatselect | bold italic backcolor link | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | removeformat',
            content_style: 'body { font-family:Helvetica,Arial,sans-serif; font-size:14px; text-align: left; }',
            setup: function(editor) {
                editor.on('init', function() {
                    // Force left alignment
                    editor.getBody().style.textAlign = 'left';
                    console.log('TinyMCE initialized for: ' + selector);
                });
            }
        });
    }

    function categorizedquestion() {
        var groupselection = document.querySelector('.age').value;
        var categoryDropdown = document.getElementById('Category');

        if (groupselection == "Age of 6-12 yrs") {
            document.querySelector('.Categorytype').style.display = "block";
            categoryDropdown.value = "3";
            categoryDropdown.style.pointerEvents = "none";

        } else if (groupselection == "13+") {
            document.querySelector('.Categorytype').style.display = "block";
            categoryDropdown.value = "";
            categoryDropdown.style.pointerEvents = "";
        } else {
            document.querySelector('.Categorytype').style.display = "none";
        }
    }

    // Setup remove button functionality using event delegation
    function setupRemoveButtons() {
        $(document).off('click', '.remove-field').on('click', '.remove-field', function() {
            var $wrapper = $('.multi-fields');
            var $currentField = $(this).closest('.multi-field');

            if ($('.multi-field', $wrapper).length > 1) {
                // Get the textarea ID before removing
                var textareaId = $currentField.find('.tinymce-body').attr('id');

                // Remove TinyMCE instance
                if (textareaId && tinymce.get(textareaId)) {
                    tinymce.get(textareaId).remove();
                }

                // Remove the field
                $currentField.remove();

                // Reinitialize all TinyMCE instances with a delay
                setTimeout(function() {
                    if (tinymce) {
                        tinymce.remove();
                    }
                    initAllTinyMCE();
                }, 300);

            } else {
                Swal.fire({
                    title: "Cannot Remove",
                    text: "At least one description and instruction is required",
                    icon: "warning",
                    confirmButtonColor: '#3085d6'
                });
            }
        });
    }

    // Add field functionality
    $('.add-field').click(function(e) {
        e.preventDefault();
        var $wrapper = $('.multi-fields');
        var fieldCount = $('.multi-field', $wrapper).length;

        // Create new field HTML
        var newField = `
            <div class="multi-field" style="display: flex;margin-bottom: 5px;">
                <input type="text" class="form-control default col-4" name="description[]" id="description_${fieldCount}" value="">
                <div class="instruction-container">
                    <textarea class="form-control tinymce-body" name="instruction[]" id="instruction_${fieldCount}" style="height: 180px; width: 100%;"></textarea>
                </div>
                <button class="remove-field btn btn-danger pull-right" type='button'>X</button>
                &nbsp;
            </div>
        `;

        // Append the new field
        $wrapper.append(newField);

        // Initialize TinyMCE for the new field with delay
        setTimeout(function() {
            initTinyMCE('instruction_' + fieldCount);
        }, 200);
    });

    function submitForm() {
        // Save TinyMCE content
        if (tinymce) {
            tinymce.triggerSave();
        }

        var age = $('.age').val();
        if (age == '') {
            Swal.fire("Please Select the Group", "", "error");
            return false;
        }

        var Category = $('.Category').val();
        if (Category == '') {
            Swal.fire("Please Select the Category", "", "error");
            return false;
        }

        var activity_name = $('#activity_name').val();
        if (activity_name == '') {
            Swal.fire("Please Enter Activity Name", "", "error");
            return false;
        }

        var allDescriptionsValid = true;
        var allInstructionsValid = true;
        var emptyDescriptionRows = [];
        var emptyInstructionRows = [];

        $('.multi-field').each(function(index) {
            var descriptionField = $(this).find('input[name="description[]"]');
            var instructionField = $(this).find('textarea[name="instruction[]"]');

            if (descriptionField.val().trim() == '') {
                allDescriptionsValid = false;
                emptyDescriptionRows.push(index + 1);
            }

            if (instructionField.val().trim() == '') {
                allInstructionsValid = false;
                emptyInstructionRows.push(index + 1);
            }
        });

        if (!allDescriptionsValid) {
            Swal.fire({
                title: "Validation Error",
                text: `Please fill in the Description for row(s): ${emptyDescriptionRows.join(', ')}`,
                icon: "error"
            });
            return false;
        }

 

        // ✅ FINAL CONFIRMATION
        Swal.fire({
            title: "Are you sure?",
            text: "Do you want to Create this activity?",
            icon: "question",
            showCancelButton: true,
            confirmButtonText: "Yes, Create",
            cancelButtonText: "No",

        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('videouploadcreation').submit();
            }
        });
    }
</script>

@endsection