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
        /* margin-top: 2rem; */
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
    {{ Breadcrumbs::render('thirteenyrsquestion_creation.create') }}
    <div class="section-body mt-0">
        <div class="card question">
            <div class="col-md-12 mt-2">
                <h3 class="text-center" style="color:darkblue;">13+Question Creation </h3>
            </div>
            <div class="col-md-12" style="padding-top: 20px;">
                <div class="row">

                    <div class="col-md-4">
                        <div class="form-group questionnaire">
                            <label class="control-label required">Questionnaire Name</label>
                            <select class="form-control" name="questionnaire_id" id="questionnaire_id" onchange="questionnaireChange()">
                                <option value="">Select Questionnaire</option>

                                <option value="10">Executive functioning - The way I process</option>

                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group questionnaire">
                            <label class="control-label required">No.Of.Questions</label>
                            <input class="form-control" type="number" id="no_of_ques" name="no_of_ques" autocomplete="off">
                        </div>
                    </div>
                    <div class="col-md-4 questionnaire_type1" style="display:none;">
                        <div class="form-group questionnaire">
                            <label class="control-label required">Type</label>
                            <select class="form-control" name="questionnaire_type" id="questionnaire_type">
                                <option value="">Select Type</option>

                                <option value="1" selected>Parent</option>
                                <option value="2">Child</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group questionnaire">
                            <label class="control-label required">Description</label>
                            <textarea class="form-control" type="text" id="Question_discription1" name="discription" placeholder="" autocomplete="off"> </textarea>
                        </div>
                    </div>
                    <div class="row text-center" style="margin-top: 10px;">
                        <div class="col-md-12">
                            <button type="button" class="btn btn-success" id="saveButton"><i class="fa fa-plus" aria-hidden="true"></i>&nbsp;Add Questions</button>
                            <a style="background-color: red;color:white;" class="btn" href="{{ route('thirteenyrsquestion_creation.index') }}"><i class="fa fa-arrow-left" aria-hidden="true"></i>&nbsp; Back </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/tinymce/4.5.6/tinymce.min.js"></script>
<script src="http://cdnjs.cloudflare.com/ajax/libs/tinymce/4.5.6/jquery.tinymce.min.js"></script>

<script>
    $(document).ready(function() {

        tinymce.init({
            selector: 'textarea#Question_discription1',
            height: 180,
            menubar: false,
            branding: false,
            toolbar: 'undo redo | formatselect | ' +
                'bold italic backcolor | alignleft aligncenter ' +
                'alignright alignjustify | bullist numlist outdent indent | ' +
                'removeformat | help',
            content_style: 'body { font-family:Helvetica,Arial,sans-serif; font-size:14px }'
        });
    });
</script>
<script>
    $("#saveButton").click(function(event) {
        event.preventDefault();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        var questionnaire_id = document.getElementById("questionnaire_id").value;
        if (questionnaire_id == null || questionnaire_id == "") {
            swal.fire("Please Select Questionnaire Name ", "", "error");
            return false;
        }

        // var discription1 = $('#Question_discription1').val();
        // if (discription1 == null || discription1 == "") {
        //     swal.fire("Please Fill Description", "", "error");
        //     return false;
        // }

        var no_of_ques = document.getElementById("no_of_ques").value;
        if (no_of_ques == '' || no_of_ques == null) {
            swal.fire("Please Enter No Of Questions", "", "error");
            return false;
        }
        var questionnaire_type = document.getElementById("questionnaire_type").value;
        if (questionnaire_type == null || questionnaire_type == "") {
            swal.fire("Please Select Questionnaire Type ", "", "error");
            return false;
        }
        window.location.href = "/thirteenquestion_creation/add_questions/" + 10;

        $('#saveButton').prop('disabled', true);
        var editor = tinymce.get('Question_discription1');
        var content = editor.getContent();
        if (content == null || content == "") {
            swal.fire("Please Fill Description", "", "error");
            return false;
        }
        window.location.href = "/thirteenquestion_creation/add_questions/" + 10;
        // $.ajax({
        //     url: "{{ url('/question_creation/store_data') }}",
        //     type: "POST",
        //     data: {
        //         _token: '{{csrf_token()}}',
        //         questionnaire_id: questionnaire_id,
        //         discription: content,
        //         no_of_ques: no_of_ques,
        //     },

        //     success: function(data) {
        //         window.location.href = "/thirteenquestion_creation/add_questions/" + 10;
        //     },
        //     error: function(data) {
        //         swal.fire({
        //                 title: "Error",
        //                 text: 'Something went wrong',
        //                 type: "error",
        //                 confirmButtonColor: '#e73131',
        //                 confirmButtonText: 'OK',
        //             },
        //             function(isConfirm) {
        //                 if (isConfirm) {
        //                     location.reload();
        //                 } else {

        //                 }
        //             });

        //         console.log(data);
        //     }
        // });

    });
</script>
<script type="text/javascript">
    var questionnaire = 10;

    function questionnaireChange() {
        var questionnaire_id = document.getElementById('questionnaire_id').value;
        // for (const question of questionnaire) {
        //     if (question['questionnaire_id'] == questionnaire_id && question['questionnaire_description'] != null) {
        //         // document.getElementById('Question_discription1').value = question['questionnaire_description'];
        //         const textarea = tinymce.get('Question_discription1');
        //         textarea.setContent(question['questionnaire_description']);
        //     }
        // }
        if (document.getElementById('questionnaire_id').value != " ") {
            document.querySelector('.questionnaire_type1').style.display = "block";

        } else {
            document.querySelector('.questionnaire_type1').style.display = "none";

        }
    }
</script>

@endsection