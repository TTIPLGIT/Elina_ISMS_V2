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

    <div class="section-body mt-0">
        <h4> Email Template Creation </h4>


        <form action="{{ route('emailtemplate.store') }}" id="email_create" method="post">
            {{ csrf_field() }}
            <div class="card question">
                <div class="row" style="margin-bottom: 15px;margin-top: 20px;">



                    <div class="col-md-6">
                        <div class="form-group questionnaire">
                            <label class="control-label">Screen Name</label>
                            <select class="form-control default" name="email_screen" id="email_screen">
                                <option value="">- Screen Name -</option>
                                <option value="Registration">Registration</option>
                                <option value="Enrollment">Enrollment</option>
                                <!-- <option value="Payment Fee">Payment Fee</option> -->
                                <option value="OVM Initiate">OVM Initiate</option>
                                <option value="OVM Initiate 2">OVM Initiate 2</option>
                                <option value="OVM Initiate Admin">OVM Initiate Admin</option>
                                <option value="OVM Report">OVM Report</option>
                                <option value="Service Provider">Service Providers</option>
                                <option value="School Enrollment">School Enrollment</option>
                                <option value="Intern Enrollment">Intern Enrollment</option>
                                <option value="F2F">Face To Face Meeting</option>
                                <option value="OVM Allocation">OVM Allocation</option>
                                <option value="OVM Allocation Update">OVM Allocation Update</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group questionnaire">
                            <label class="control-label">Email Subject</label>
                            <input class="form-control default" type="text" id="email_subject" name="email_subject" autocomplete="off">
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="col-lg-12" style="margin: 20px 0px 0px 0px;">
                            <div class="form-group">
                                <label class="form-label">Email Body</label>
                                <textarea class="form-control" id="email_description" name="email_description"></textarea>
                            </div>
                        </div>
                    </div>


                    <button type="button" class="btn btn-success" id="saveButton">Save</button>

                </div>
            </div>
        </form>
    </div>

</div>
<script src="https://cdn.tiny.cloud/1/qagffr3pkuv17a8on1afax661irst1hbr4e6tbv888sz91jc/tinymce/6/tinymce.min.js"></script>

<script>
    $(document).ready(function() {
        var rows = <?php echo (json_encode($rows)); ?>;
        // var rows = rows.screen;console.log(rows);
        var email_screen = document.getElementById("email_screen");
        
        tinymce.init({
            selector: 'textarea#email_description',
            plugins: 'preview importcss searchreplace autolink autosave save directionality code visualblocks visualchars fullscreen image link media template codesample table charmap pagebreak nonbreaking anchor insertdatetime advlist lists wordcount help charmap quickbars emoticons',
            toolbar: 'undo redo | bold italic underline strikethrough | fontfamily fontsize blocks | alignleft aligncenter alignright alignjustify | outdent indent |  numlist bullist | forecolor backcolor removeformat | pagebreak | charmap emoticons | fullscreen  preview save print | insertfile image media template link anchor codesample | ltr rtl',
            height: 520,
            menubar: false,
            branding: false,
            toolbar: 'undo redo | formatselect | ' +
                'bold italic backcolor | alignleft aligncenter ' +
                'alignright alignjustify | bullist numlist outdent indent | ' +
                'removeformat | help',
            content_style: 'body { font-family:Helvetica,Arial,sans-serif; font-size:14px }'
        });

        for (var i = 0; i < email_screen.length; i++) {
            for (var j = 0; j < rows.length; j++) {
                if (email_screen.options[i].value != '')
                if (email_screen.options[i].value == rows[j].screen)
                    email_screen.remove(i);
            }
        }

    });
</script>
<script>
    $("#saveButton").click(function(event) {

        document.getElementById('email_create').submit();
        // event.preventDefault();
        // $.ajaxSetup({
        //     headers: {
        //         'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        //     }
        // });

        // var questionnaire_id = document.getElementById("questionnaire_id").value;
        // if (questionnaire_id == null || questionnaire_id == "") {
        //     swal.fire("Please Select Questionnaire Name ", "", "error");
        //     return false;
        // }

        // var discription1 = $('#Question_discription1').val();
        // if (discription1 == null || discription1 == "") {
        //     swal.fire("Please Fill Description", "", "error");
        //     return false;
        // }

        // var no_of_ques = document.getElementById("no_of_ques").value;
        // if (no_of_ques == '' || no_of_ques == null) {
        //     swal.fire("Please Enter No Of Questions", "", "error");
        //     return false;
        // }

        // $('#saveButton').prop('disabled', true);

        // $.ajax({
        //     url: '{{ url(' / question_creation / store_data ') }}',
        //     type: "POST",
        //     data: {
        //         _token: '{{csrf_token()}}',
        //         questionnaire_id: questionnaire_id,
        //         discription: discription1,
        //         no_of_ques: no_of_ques,
        //     },

        //     success: function(data) {
        //         window.location.href = "/question_creation/add_questions/" + data;

        //         // if (data != null) {
        //         //     swal.fire({
        //         //             title: "Initiated",
        //         //             text: "Question Created Successfully",
        //         //             type: "success",
        //         //             confirmButtonColor: '#e73131',
        //         //             confirmButtonText: 'OK',
        //         //         },
        //         //         function(isConfirm) {
        //         //             if (isConfirm) {
        //         // 			    window.location.href = "/question_creation/add_questions/"+data;
        //         //             } else {

        //         //             }
        //         //         });

        //         // }


        //     },
        //     error: function(data) {
        //         swal.fire({
        //                 title: "Error",
        //                 text: data,
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

@endsection