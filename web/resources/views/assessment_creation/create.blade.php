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

    #invite {
        display: none;
    }

    .colorbutton {
        background-color: darkblue;
        color: white;
        cursor: none;
        padding: 0.5rem 1rem;
        border: 0;
        border-color: darkblue;
        border-radius: 5px;
    }

    .colorbutton:hover {
        background-color: darkblue !important;
        color: white;
    }

    #list_section {
        display: none;
    }

    .alignment {
        text-align: center;
    }

    /* ============================================================
       MOBILE RESPONSIVE – screens ≤ 768px
       ============================================================ */
    @media (max-width: 768px) {

        /* Reset paddings & margins */
        .main-content,
        .card,
        .card-body,
        .form-group,
        .row {
            padding-left: 0 !important;
            padding-right: 0 !important;
            margin-left: 0 !important;
            margin-right: 0 !important;
        }

        .main-content {
            padding-top: 0 !important;
        }

        .breadcrumb {
            font-size: 11px !important;
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

        h4 {
            font-size: 18px !important;
        }

        .question {
            margin-top: 1rem !important;
            margin-left: 5px !important;
            margin-right: 5px !important;
        }

        /* Stack columns vertically */
        .is-coordinate {
            display: flex !important;
            flex-direction: column !important;
            align-items: stretch !important;
        }

        .is-coordinate .col-md-4 {
            flex: 0 0 100% !important;
            max-width: 100% !important;
            width: 100% !important;
            padding-left: 10px !important;
            padding-right: 10px !important;
            margin-bottom: 10px !important;
        }

        /* Left-align labels */
        .form-group label {
            text-align: left !important;
            display: block !important;
            width: 100% !important;
        }

        /* Inputs full width */
        .form-control,
        .form-control[type="text"],
        select.form-control {
            font-size: 14px !important;
            height: auto !important;
            padding: 8px 10px !important;
            width: 100% !important;
        }

        /* ---- Create button – keep original size, just centered ---- */
        .col-md-12.text-center {
            text-align: center !important;
            padding-left: 10px !important;
            padding-right: 10px !important;
        }

        .colorbutton {
            /* Remove full width */
            width: auto !important;
            display: inline-block !important;
            padding: 0.5rem 1rem !important;  /* keep desktop padding */
            font-size: inherit !important;
            margin: 0 auto !important;
            box-shadow: none !important;
        }

        /* Fix for TinyMCE if used elsewhere */
        .tox-tinymce {
            max-width: 100% !important;
        }
    }
</style>

<div class="main-content">
    {{ Breadcrumbs::render('asessmentreportmaster.create') }}
    <div class="section-body mt-0">
        <h4 style="color:darkblue">Report Creation </h4>

        <div class="card question">
            <div class="card-body">
                <div class="row is-coordinate">

                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="control-label required">Type</label>
                            <select class="form-control default" name="report_type" id="report_type">
                                <option value="">-- Select Type --</option>
                                <option value="SAIL" selected>SAIL</option>
                                <option value="CoMPASS">CoMPASS</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="control-label required">Report Name</label>
                            <select class="form-control default" name="report_name" id="report_name">
                                <option value="">-- Select Report --</option>
                                <option value="Assessment Report">Assessment Report</option>
                                <option value="Recommendation Report">Recommendation Report</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="control-label required">Version</label>
                            <input class="form-control" type="text" id="report_version" name="report_version" value="1.0 [Draft]" readonly autocomplete="off">
                        </div>
                    </div>

                </div>
            </div>
        </div>

        <div class="row text-center">
            <div class="col-md-12">
                <button onclick="submitForm()" class="colorbutton mb-1" id="headerupdate" style="margin-top:1%">Create</button>
            </div>
        </div>
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/tinymce/4.5.6/tinymce.min.js"></script>
<script src="http://cdnjs.cloudflare.com/ajax/libs/tinymce/4.5.6/jquery.tinymce.min.js"></script>

<script type="text/javascript">
    $(document).ready(function() {
        tinymce.init({
            selector: 'textarea#meeting_description',
            height: 180,
            menubar: false,
            branding: false,
            height: "480",
            toolbar: 'undo redo | formatselect | ' +
                'bold italic backcolor | alignleft aligncenter ' +
                'alignright alignjustify | bullist numlist outdent indent | ' +
                'removeformat | help',
            content_style: 'body { font-family:Helvetica,Arial,sans-serif; font-size:14px }'
        });
    });
</script>

<script>
    function discription_content() {
        document.getElementById('report').submit();
    }
</script>
<script>
    function submitForm() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        var report_type = document.getElementById("report_type").value;
        if (report_type == null || report_type == "") {
            swal.fire("Please Select Type", "", "error");
            return false;
        }

        var report_name = document.getElementById("report_name").value;
        if (report_name == null || report_name == '') {
            swal.fire("Please Enter Report Name", "", "error");
            return false;
        }

        var version = document.getElementById("report_version").value;
        $(".loader").show();

        $.ajax({
            url: '{{ url('/master/assessment/header') }}',
            type: "POST",
            data: {
                _token: '{{csrf_token()}}',
                report_type: report_type,
                report_name: report_name,
                version: version
            },
            success: function(data) {
                window.location.href = "/master/assessment/edit/" + data;
            },
            error: function(data) {
                swal.fire({
                    title: "Error",
                    text: data,
                    type: "error",
                    confirmButtonColor: '#e73131',
                    confirmButtonText: 'OK',
                });
            }
        });
    }
</script>

@endsection