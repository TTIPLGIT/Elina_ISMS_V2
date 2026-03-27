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
                            <label class="control-label">Activity Description</label>
                            <div class="multi-field-wrapper">
                                <div class="multi-fields">
                                    @foreach($rows as $key => $row)
                                    <div class="multi-field" style="display: flex; margin-bottom: 5px;">
                                        <input type="text" class="form-control col-4"
                                            name="description[{{ $row['activity_description_id'] }}]"
                                            value="{{ $row['description'] }}" autocomplete="off" style="background-color:white !important" placeholder="Enter description">

                                        <textarea class="form-control tinymce-body col-7"
                                            name="instruction[{{ $row['activity_description_id'] }}]"
                                            rows="4" placeholder="Enter instruction">{{ $row['instruction'] }}</textarea>

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
    <div class="multi-field" style="display: flex; margin-bottom: 5px;">
        <input type="text" class="form-control col-4" name="description[new][]" value="" style="background-color:white !important" autocomplete="off" placeholder="Enter description">
        <textarea class="form-control tinymce-body col-7" name="instruction[new][]" rows="4" placeholder="Enter instruction"></textarea>
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
            swal.fire("Please Enter Activity Name", "", "error");
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

            swal.fire({
                title: "Validation Error",
                text: "Please enter description for newly added row",
                icon: "error",
                confirmButtonColor: '#3085d6'
            });

            return false;
        }

        document.getElementById('videouploadcreation').submit();
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