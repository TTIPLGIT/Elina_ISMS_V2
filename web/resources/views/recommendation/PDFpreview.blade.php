@extends('layouts.adminnav')

@section('content')

<style>
    /* ========== BASE STYLES (unchanged) ========== */
    input[type=checkbox] { display: inline-block; }
    .no-arrow { -moz-appearance: textfield; }
    .no-arrow::-webkit-inner-spin-button { display: none; }
    .no-arrow::-webkit-outer-spin-button,
    .no-arrow::-webkit-inner-spin-button { -webkit-appearance: none; margin: 0; }

    .nav-tabs {
        background-color: #0068a7 !important;
        border-radius: 29px !important;
        padding: 1px !important;
    }
    .nav-item.active { background-color: #0e2381 !important; border-radius: 31px !important; height: 100% !important; }
    .nav-link.active { background-color: #0e2381 !important; border-radius: 31px !important; height: 100% !important; }
    .nav-justified { display: flex !important; align-items: center !important; }
    hr { border-top: 1px solid #6c757d !important; }

    .dateformat {
        height: 41px;
        padding: 8px 10px !important;
        width: 100%;
        border-radius: 5px !important;
        border-color: #bec4d0 !important;
        box-shadow: 2px 2px 4px rgb(0 0 0 / 15%);
        border-style: outset;
    }
    h4 { text-align: center; }
    .question {
        background-color: white;
        border-radius: 12px !important;
        margin-top: 2rem;
    }
    .question label { text-align: center; }
    .questionnaire { text-align: center; }
    .btn-success { margin: auto; }
    .colorbutton {
        background-color: darkblue;
        color: white;
        cursor: none;
        padding: 0.5rem 1rem;
        border: 0;
        border-color: darkblue;
        border-radius: 5px;
    }
    .colorbutton:hover { background-color: darkblue !important; color: white; }
    .alignment { text-align: center; }
    .content { display: none; }
    .page {
        width: 210mm;
        padding: 20mm;
        margin: 10mm auto;
        border: 1px #D3D3D3 solid;
        border-radius: 5px;
        background: white;
        box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);
    }
    .select2-container { width: 1% !important; display: table-cell !important; }
    .select2-container--default .select2-selection--multiple .select2-selection__choice { color: black !important; }
    .select2-container .select2-selection--multiple .select2-selection__rendered {
        white-space: normal !important;
        max-height: 100px;
        overflow-y: scroll;
    }

    /* FAQ drawer (email preview) */
    input[type="checkbox"] { display: none; }
    .faq-drawer {
        flex: 1;
        box-shadow: 0px 2px 15px rgba(0, 0, 0, 0.1);
    }
    .faq-drawer__title {
        display: block;
        position: relative;
        padding: 5px 5px 5px 25px;
        margin-bottom: 0;
        background: white;
        color: #373737;
        font-weight: 600;
        font-size: 15px;
        border-radius: 8px;
        transition: all 0.25s ease-out;
        cursor: pointer;
    }
    .faq-drawer__title:hover { color: #747474; }
    .faq-drawer__title::after {
        content: " ";
        position: absolute;
        width: 0;
        height: 0;
        top: 15px;
        right: 20px;
        float: right;
        border-left: 5px solid transparent;
        border-right: 5px solid transparent;
        border-top: 5px solid currentColor;
        transition: transform 0.2s ease-out;
    }
    .faq-drawer__trigger:checked + .faq-drawer__title::after { transform: rotate(-180deg); }
    .faq-drawer__content-wrapper {
        overflow: hidden;
        max-height: 0px;
        font-size: 15px;
        line-height: 23px;
        transition: max-height 0.25s ease-in-out;
    }
    .faq-drawer__trigger:checked + .faq-drawer__title + .faq-drawer__content-wrapper { max-height: max-content; }
    .faq-drawer__trigger:checked + .faq-drawer__title {
        border-bottom-right-radius: 0;
        border-bottom-left-radius: 0;
    }
    .faq-drawer__content-wrapper .faq-drawer__content {
        background: white;
        padding: 2px 18px 14px;
        border-bottom-left-radius: 8px;
        border-bottom-right-radius: 8px;
    }

    /* Global fix for TinyMCE scrolling on mobile */
    .tox-tinymce, .tox-edit-area, .tox-edit-area__iframe {
        overflow-y: auto !important;
    }
    .tox-edit-area__iframe {
        height: 300px !important;
    }

    /* ========== MOBILE RESPONSIVE STYLES ========== */
    @media (max-width: 768px) {
        /* Breadcrumb single line - ensure visibility */
        .breadcrumb {
            flex-wrap: nowrap !important;
            white-space: nowrap !important;
            overflow-x: auto !important;
            overflow-y: hidden !important;
            display: flex !important;
            width: 100% !important;
            margin-top: 60px !important;
            margin-bottom: 10px !important;
            padding: 5px 10px !important;
            font-size: 11px !important;
        }
        .breadcrumb::-webkit-scrollbar { display: none; }
        .breadcrumb-item,
        .breadcrumb-item a {
            white-space: nowrap !important;
            font-size: 11px !important;
        }

        .main-content {
            padding: 0 5px !important;
            overflow-x: hidden !important;
        }
        h4 {
            font-size: 18px !important;
            margin-top: 5px !important;
        }
        .section-body {
            padding: 0 !important;
        }

        iframe {
            height: 450px !important;
            width: 100% !important;
        }

        /* Email drawer - make TinyMCE scrollable on mobile */
        .faq-drawer__content {
            padding: 10px !important;
            max-height: 70vh !important;
            overflow-y: auto !important;
        }
        .faq-drawer__content .tox-tinymce {
            max-height: 50vh !important;
            overflow-y: auto !important;
        }
        .faq-drawer__content .tox-edit-area {
            overflow-y: auto !important;
        }
        .faq-drawer__content .tox-edit-area__iframe {
            height: auto !important;
            min-height: 200px !important;
            max-height: 50vh !important;
            overflow-y: auto !important;
        }
        .mce-tinymce {
            overflow-y: auto !important;
        }
        textarea#email_content {
            max-height: 300px !important;
            overflow-y: auto !important;
        }

        /* Buttons row: same line horizontally */
        .action-buttons {
            display: flex !important;
            flex-direction: row !important;
            align-items: center !important;
            justify-content: center !important;
            gap: 10px !important;
            flex-wrap: wrap !important;
            margin-top: 15px !important;
        }
        .action-buttons .btn {
            width: auto !important;
            min-width: 100px !important;
            margin: 0 !important;
        }

        /* Mobile download button */
        .mobile-download-btn {
            display: block !important;
            text-align: center;
            margin: 15px 0;
        }
        .mobile-download-btn .btn {
            background: #036B86 !important;
            border-color: #036B86 !important;
            color: #fff !important;
            font-weight: 600;
            min-width: 250px;
        }
    }

    /* Desktop: hide mobile download button */
    .mobile-download-btn {
        display: none;
    }

    /* Action buttons row on desktop */
    .action-buttons {
        display: flex;
        flex-direction: row;
        justify-content: center;
        gap: 15px;
        margin-top: 20px;
    }
</style>

<div class="main-content">
    {{ Breadcrumbs::render('recommendation.preview',$data['report_id']) }}

    @if (session('success'))
        <input type="hidden" name="session_data" id="session_data" class="session_data" value="{{ session('success') }}">
        <script>
            window.onload = function() {
                var message = $('#session_data').val();
                swal.fire("Success", message, "success");
            }
        </script>
    @elseif(session('fail'))
        <input type="hidden" name="session_data" id="session_data1" class="session_data" value="{{ session('error') }}">
        <script>
            window.onload = function() {
                var message = $('#session_data1').val();
                swal.fire("Info", message, "info");
            }
        </script>
    @endif

    <div class="section-body mt-0">
        <h4 style="color:darkblue">Recommendation Report Preview</h4>

        <input type="hidden" name="child_contact_email" id="child_contact_email" value="{{$data['email']}}">
        <input type="hidden" name="enrollment_id" id="enrollment_id" value="{{$data['enrollment_id']}}">

        <!-- Mobile Download Button (only visible on mobile) -->
        <div class="mobile-download-btn">
            <a href="{{ $viewPDF }}" download="Recommendation_Report.pdf" class="btn report-download-btn">
                <i class="fa fa-download"></i> Download Report (PDF)
            </a>
        </div>

        <!-- PDF Viewer -->
        <div class="pdf-viewer-container">
        <!-- Desktop/Android: native iframe PDF viewer -->
        <div id="recommendation_iframe_wrap">
            <iframe src="{{ $viewPDF }}" width="100%" height="600" frameborder="0"></iframe>
        </div>
        <!-- iOS Safari fallback: show download link (hidden by default, shown by JS) -->
        <div id="recommendation_ios_fallback" style="display:none; text-align:center; padding:30px 10px;">
            <p style="color:#555; margin-bottom:15px;">PDF preview is not supported on this device.<br>Tap the button below to open the report.</p>
            <a href="{{ $viewPDF }}" target="_blank" class="btn btn-labeled" style="background:#036B86;color:#fff;border-color:#036B86;font-weight:600;padding:10px 24px;">
                <span class="btn-label"><i class="fa fa-file-pdf-o"></i></span> Open Recommendation Report (PDF)
            </a>
        </div>
        </div>

        <!-- Email Preview Drawer -->
        <div style="display: contents;">
            <div class="faq-drawer">
                <input class="faq-drawer__trigger" id="faq-drawer" type="checkbox" />
                <label class="faq-drawer__title" style="background: #96a3d5c7;" for="faq-drawer">Email Preview</label>
                <div class="faq-drawer__content-wrapper">
                    <div class="faq-drawer__content">
                        <textarea class="form-control" id="email_content" name="email_content">{{ $data['email_draft'] }}</textarea>
                        <div style="color: rgb(246, 15, 15); display: block; margin-top: 8px;">
                            Do not include <strong>Thanks & Regards</strong> at the end of the Email Draft
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Action Buttons (same line on all devices) -->
    <div class="action-buttons">
        <!-- Back button - red color -->
        <a type="button" class="btn btn-labeled back-btn" title="Back" href="{{ route('recommendation.index') }}" style="color:white !important; background: #dc3545 !important; border-color: #dc3545 !important;">
            <span class="btn-label" style="font-size:13px !important;"><i class="fa fa-arrow-left"></i></span> Back
        </a>
        <input type="hidden" value="{{ route('recommendation.edit', \Crypt::encrypt($data['report_id'])) }}" id="routeUrl">
        <a href="{{ route('recommendation.edit', \Crypt::encrypt($data['report_id'])) }}" type="button" id="editbutton" class="btn btn-labeled btn-succes" title="Edit" style="background: orange !important; color:white !important">
            <span class="btn-label" style="font-size:13px !important;"><i class="fas fa-pencil-alt"></i></span> Edit
        </a>
        <a type="button" onclick="pdfgenrate('{{ $data['report_id'] }}')" id="submitbutton" class="btn btn-labeled btn-succes" title="Publish" style="background: green !important; border-color:green !important; color:white !important">
            <span class="btn-label" style="font-size:13px !important;"><i class="fa fa-check"></i></span> Publish
        </a>
    </div>
</div>

<!-- Scripts (unchanged) -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/tinymce/4.5.6/tinymce.min.js"></script>
<script src="http://cdnjs.cloudflare.com/ajax/libs/tinymce/4.5.6/jquery.tinymce.min.js"></script>
<script>
    $(".js-select5").select2({
        closeOnSelect: false,
        placeholder: " Please Select the value ",
        allowHtml: true,
        allowClear: true,
        tags: true
    });
</script>
<script type="text/javascript">
    $(document).ready(function() {
        $('#content-1').show();
        tinymce.init({
            selector: '.tinymce-body',
            inline: true,
            menubar: false,
            branding: false,
            plugins: 'searchreplace',
            toolbar: 'undo redo | formatselect | bold italic backcolor | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | removeformat | searchreplace',
            font_formats: "Andale Mono=andale mono,times;Barlow=Barlow, normal; Arial=arial,helvetica,sans-serif; Arial Black=arial black,avant garde; Book Antiqua=book antiqua,palatino; Comic Sans MS=comic sans ms,sans-serif; Courier New=courier new,courier; Georgia=georgia,palatino; Helvetica=helvetica; Impact=impact,chicago; Oswald=oswald; Symbol=symbol; Tahoma=tahoma,arial,helvetica,sans-serif; Terminal=terminal,monaco; Times New Roman=times new roman,times; Trebuchet MS=trebuchet ms,geneva; Verdana=verdana,geneva; Webdings=webdings; Wingdings=wingdings,zapf dingbats",
            content_style: "@import url('https://fonts.googleapis.com/css2?family=Barlow&display=swap'); body { font-family: Barlow; }",
        });
    });
</script>
<script>
    function pdfgenrate(reportID) {
        Swal.fire({
            title: "Publish Recommendation Report",
            text: "Are you sure you want to publish this recommendation report?",
            icon: "warning",
            showCancelButton: true,
            confirmButtonText: "Yes, Publish",
            cancelButtonText: "No",
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                $(".loader").show();
                var child_contact_email = document.getElementById('child_contact_email').value;
                var enrollment_id = document.getElementById('enrollment_id').value;
                var email_content = tinyMCE.get('email_content').getContent();
                $("#submitbutton").addClass("disable-click");
                $.ajax({
                    url: "{{ url('/report/assessment/generatePDF') }}",
                    type: 'POST',
                    data: {
                        'reportID': reportID,
                        'child_contact_email': child_contact_email,
                        'enrollment_id': enrollment_id,
                        'email_content': email_content,
                        _token: '{{csrf_token()}}'
                    }
                }).done(function(data) {
                    $(".loader").hide();
                    Swal.fire("Success", "The Recommendation Report has been published successfully.", "success").then(function() {
                        window.location = "/report/recommendationreport";
                    });
                });
            } else {
                return false;
            }
        });
    }
</script>
<script>
    $(document).ready(function() {
        tinymce.init({
            selector: 'textarea#email_content',
            menubar: false,
            branding: false,
            toolbar: 'undo redo | formatselect | bold italic backcolor | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | removeformat',
            content_style: 'body { font-family:Helvetica,Arial,sans-serif; font-size:14px }',
            setup: function(editor) {
                var childName = <?php echo json_encode($data['child_name']); ?>;
                var childGender = <?php echo json_encode($data['child_gender']); ?>;
                var gender = (childGender == "Male") ? 'He' : 'She';
                var genderAdjectives = (childGender == "Male") ? 'his' : 'her';
                editor.on('init', function() {
                    content = editor.getContent();
                    content = content.replace(/childName/g, childName);
                    if (content.includes("leveraging their strengths")) {
                        content = content.replace(/leveraging their strengths/g, 'leveraging ' + genderAdjectives + ' strengths');
                    } else {
                        content = content.replace(/childGenderAdjectives/g, genderAdjectives);
                    }
                    editor.setContent(content);
                });
            },
        });
    });
</script>
<script>
        // iOS Safari PDF preview fix (same as assessment report)
        var isIOS = /iPad|iPhone|iPod/.test(navigator.userAgent) && !window.MSStream;
        if (isIOS) {
            var recWrap = document.getElementById('recommendation_iframe_wrap');
            var recFallback = document.getElementById('recommendation_ios_fallback');
            if (recWrap) recWrap.style.display = 'none';
            if (recFallback) recFallback.style.display = 'block';
        }
        // Existing code continues
        if (window.history && window.history.pushState) {
            var currentUrl = window.location.href.split('#')[0];
            window.history.pushState({ url: currentUrl }, null, currentUrl);
            window.onpopstate = function(event) {
                if (event.state && event.state.url === currentUrl) {
                    location.reload();
                }
            };
        }
</script>
@endsection