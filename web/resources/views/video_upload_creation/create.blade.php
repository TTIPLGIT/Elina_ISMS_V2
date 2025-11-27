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
                                <option value="Below 12">Age of 6-12 yrs</option>
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
                            <label class="control-label" style="">Activity Description & Instruction</label>
                            <div class="multi-field-wrapper">
                                <div class="multi-fields">
                                    <div class="multi-field" style="display: flex;margin-bottom: 5px;">
                                        <input type="text" class="form-control default col-4" name="description[]" id="description">
                                    <!-- <input class="form-control default col-3" type="file" id="file" name="file[]" value="file_value" autocomplete="off"> -->
                                        <div class="form-control default tinymce-body" id="instruction[]" name="instruction[]"></div>
                                        <button class="remove-field btn btn-danger pull-right" id="remove-f" type='button'>X </button>
                                        &nbsp;
                                    </div>
                                </div>
                                <button type="button" class="add-field btn btn-success">Add Description</button>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12 text-center">
                        <a type="button" onclick="submit('submitted')" id="submitbutton" class="btn btn-labeled btn-succes" title="submit" style="background: green !important; border-color:green !important; color:white !important">
                            <span class="btn-label" style="font-size:13px !important;"><i class="fa fa-check"></i></span> Submit</a>
                        <a class="btn btn-danger" href="{{route('video_creation.index')}}"><i class="fa fa-times" aria-hidden="true"></i> Cancel </a>&nbsp;
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
    $(document).ready(function() {
        tinymce.init({
            selector: '.tinymce-body',
            height: 180,
            menubar: false,
            branding: false,
            inline: true,
            plugins: 'link',
            toolbar: 'undo redo | formatselect | ' +
                'bold italic backcolor link | alignleft aligncenter ' +
                'alignright alignjustify | bullist numlist outdent indent | ' +
                'removeformat | help',
            content_style: 'body { font-family:Helvetica,Arial,sans-serif; font-size:14px }'
        });
    });

    function categorizedquestion() {
        var groupselection = document.querySelector('.age').value;
        var categoryDropdown = document.getElementById('Category');

        if (groupselection == "Below 12") {
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
</script>
<script>
    function submit() {

        var age = $('.age').val();

        if (age == '') {
            swal.fire("Please Select the Group", "", "error");
            return false;
        }

        var Category = $('.Category').val();

        if (Category == '') {
            swal.fire("Please Select the Category", "", "error");
            return false;
        }

        var activity_name = $('#activity_name').val();

        if (activity_name == '') {
            swal.fire("Please Enter Activity Name: ", "", "error");
            return false;
        }


        var description = $('#description').val();

        if (description == '') {
            swal.fire("Please Enter Description:", "", "error");
            return false;
        }

        document.getElementById('videouploadcreation').submit('saved');
    }

    // <script type="text/javascript">
    $('.multi-field-wrapper').each(function() {

        var $wrapper = $('.multi-fields', this);
        console.log($wrapper);


        $(".add-field", $(this)).click(function(e) {
            $('.multi-field:first-child', $wrapper).clone(true).appendTo($wrapper).find('input').val('').focus();
            $('#file_field').append('<div class="multi-field" style="display: flex;margin-bottom: 5px;"><input class="form-control" type="file" id="file" name="file" autocomplete="off"></div>');
        });

        $('.multi-field .remove-field', $wrapper).click(function() {
            if ($('.multi-field', $wrapper).length > 1)
                $(this).parent('.multi-field').remove();

            else bootbox.alert({
                title: "Metadata creation",
                centerVertical: true,
                message: "Required one Dropdown Option",
            });


        });
    });
</script>

<script type="text/javascript">
    //     function typeChange() {
    //         var fieldtype = $('#option-tab').val();
    //         alert("hi");
    //         if (fieldtype == dropdown) {
    //             $('#option').hide();
    //         } else {
    //             $('#option').show();
    //         }
    //     }
    // 
</script>

@endsection