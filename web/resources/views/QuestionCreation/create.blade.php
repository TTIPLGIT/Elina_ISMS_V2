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

    /* ============================================================
       MOBILE RESPONSIVE – same patterns as other pages
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
        .col-md-4,
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

        /* ---- Breadcrumbs: keep on one line ---- */
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
        .col-md-4 {
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
        }

        /* Labels */
        .control-label {
            font-size: 13px !important;
        }

        /* TinyMCE editor – adapt to container */
        .tox-tinymce {
            max-width: 100% !important;
        }

        /* Button – full width with spacing */
        .btn-success {
            width: 100% !important;
            margin: 10px 0 5px 0 !important;
            font-size: 14px !important;
            padding: 10px !important;
        }

        /* Adjust top row margins */
        .question .row {
            margin-left: 0 !important;
            margin-right: 0 !important;
        }

        .form-group {
            margin-bottom: 12px !important;
        }

        /* Reduce card padding */
        .question {
            padding: 10px !important;
            margin-top: 1rem !important;
        }
    }
</style>

<div class="main-content">
    {{ Breadcrumbs::render('question_creation.create') }}
    <div class="section-body mt-0">
        <h4> Questionnaire Creation </h4>
        <div class="card question">
            <div class="row" style="margin-bottom: 15px;margin-top: 20px;">
                <div class="col-md-4">
                    <div class="form-group questionnaire">
                        <label class="control-label required">Questionnaire Name</label>
                        <select class="form-control" name="questionnaire_id" style="background-color: #ffffff !important; color: #000000;" id="questionnaire_id" onchange="questionnaireChange()">
                            <option value="">Select Questionnaire</option>
                            @foreach($questionnaire_list as $data)
                            <option value="{{$data['questionnaire_id']}}">{{$data['questionnaire_name']}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group questionnaire">
                        <label class="control-label required">No.Of.Questions</label>
                        <input class="form-control" type="number" style="background-color: #ffffff !important; color: #000000;" id="no_of_ques" name="no_of_ques" autocomplete="off">
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group questionnaire">
                        <label class="control-label required">Description</label>
                        <textarea class="form-control" type="text" id="Question_discription1" name="discription" placeholder="" autocomplete="off"> </textarea>
                    </div>
                </div>
                <button type="button" class="btn btn-success" id="saveButton">Add Questions</button>
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

        var no_of_ques = document.getElementById("no_of_ques").value;
        if (no_of_ques == '' || no_of_ques == null) {
            swal.fire("Please Enter No Of Questions", "", "error");
            return false;
        }

        $('#saveButton').prop('disabled', true);
        var editor = tinymce.get('Question_discription1');
        var content = editor.getContent();
        if (content == null || content == "") {
            swal.fire("Please Fill Description", "", "error");
            return false;
        }

        $.ajax({
            url: "{{ url('/question_creation/store_data') }}",
            type: "POST",
            data: {
                _token: '{{csrf_token()}}',
                questionnaire_id: questionnaire_id,
                discription: content,
                no_of_ques: no_of_ques,
            },

            success: function(data) {
                window.location.href = "/question_creation/add_questions/" + data;
            },
            error: function(data) {
                swal.fire({
                        title: "Error",
                        text: 'Something went wrong',
                        type: "error",
                        confirmButtonColor: '#e73131',
                        confirmButtonText: 'OK',
                    },
                    function(isConfirm) {
                        if (isConfirm) {
                            location.reload();
                        } else {

                        }
                    });

                console.log(data);
            }
        });

    });
</script>
<script type="text/javascript">
    var questionnaire = <?php echo json_encode($questionnaire_list); ?>;

    function questionnaireChange() {
        var questionnaire_id = document.getElementById('questionnaire_id').value;
        for (const question of questionnaire) {
            if (question['questionnaire_id'] == questionnaire_id && question['questionnaire_description'] != null) {
                const textarea = tinymce.get('Question_discription1');
                textarea.setContent(question['questionnaire_description']);
            }
        }
    }
</script>

@endsection