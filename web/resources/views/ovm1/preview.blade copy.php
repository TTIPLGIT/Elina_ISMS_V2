@extends('layouts.adminnav')

@section('content')
<!-- <link href="{{asset('assets/css/ovm_assessment.css')}}" rel="stylesheet" type="text/css" /> -->
<style>
    /* vietnamese */
    @font-face {
        font-family: 'Barlow';
        font-style: normal;
        font-weight: 400;
        font-display: swap;
        src: url(https://fonts.gstatic.com/s/barlow/v12/7cHpv4kjgoGqM7E_A8s52Hs.woff2) format('woff2');
        unicode-range: U+0102-0103, U+0110-0111, U+0128-0129, U+0168-0169, U+01A0-01A1, U+01AF-01B0, U+0300-0301, U+0303-0304, U+0308-0309, U+0323, U+0329, U+1EA0-1EF9, U+20AB;
    }

    /* latin-ext */
    @font-face {
        font-family: 'Barlow';
        font-style: normal;
        font-weight: 400;
        font-display: swap;
        src: url(https://fonts.gstatic.com/s/barlow/v12/7cHpv4kjgoGqM7E_Ass52Hs.woff2) format('woff2');
        unicode-range: U+0100-02AF, U+0304, U+0308, U+0329, U+1E00-1E9F, U+1EF2-1EFF, U+2020, U+20A0-20AB, U+20AD-20CF, U+2113, U+2C60-2C7F, U+A720-A7FF;
    }

    /* latin */
    @font-face {
        font-family: 'Barlow';
        font-style: normal;
        font-weight: 400;
        font-display: swap;
        src: url(https://fonts.gstatic.com/s/barlow/v12/7cHpv4kjgoGqM7E_DMs5.woff2) format('woff2');
        unicode-range: U+0000-00FF, U+0131, U+0152-0153, U+02BB-02BC, U+02C6, U+02DA, U+02DC, U+0304, U+0308, U+0329, U+2000-206F, U+2074, U+20AC, U+2122, U+2191, U+2193, U+2212, U+2215, U+FEFF, U+FFFD;
    }

    .container {
        margin: 0 auto;
        background-color: #FFFFFF;
        padding: 20px;
        box-shadow: 0px 0px 10px #BBBBBB;
    }

    .page {
        min-height: 297mm;
        padding: 10mm;
        margin: 10mm auto;
        border: 1px #D3D3D3 solid;
        border-radius: 5px;
        background: white;
        box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);
    }
</style>
<style>
    input[type="checkbox"] {
        display: none;
    }

    .faq-drawer {
        /* width: 75%;
    margin-bottom: 1.8rem; */
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

    .faq-drawer__title:hover {
        color: #747474;
    }

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

    .faq-drawer__trigger:checked+.faq-drawer__title::after {
        transform: rotate(-180deg);
    }

    .faq-drawer__content-wrapper {
        overflow: hidden;
        max-height: 0px;
        font-size: 15px;
        line-height: 23px;
        transition: max-height 0.25s ease-in-out;
    }

    .faq-drawer__trigger:checked+.faq-drawer__title+.faq-drawer__content-wrapper {
        max-height: max-content;
    }

    .faq-drawer__trigger:checked+.faq-drawer__title {
        border-bottom-right-radius: 0;
        border-bottom-left-radius: 0;
    }

    .faq-drawer__content-wrapper .faq-drawer__content {
        background: white;
        padding: 2px 18px 14px;
        border-bottom-left-radius: 8px;
        border-bottom-right-radius: 8px;
    }

    .tox.tox-tinymce {
        margin: 0 0 0 85px;
    }

    /* .a4-editor {
        width: calc(210mm / 25.4 * 96px);
        height: calc(297mm / 25.4 * 96px);
    } */
</style>
<style>
    @import url('https://fonts.googleapis.com/css2?family=Oswald&display=swap');
</style>
<div class="main-content">

    <div class="section-body mt-0">
        <h4 style="color:darkblue;    text-align: center;">Preview</h4>
        <div class="container" id="entirePage">
            <div class="tinymce-body" id="page-body" style="    margin: 0 0 0 85px !important;">
                @foreach($report as $data1)
                <div style="page-break-after: always">
                    {!! $data1['page_description'] !!}
                </div>
                @endforeach
            </div>
        </div>
        <input type="hidden" name="child_contact_email" id="child_contact_email">
        <input type="hidden" name="child_name" id="child_name">
        <input type="hidden" name="child_id" id="child_id">

        <div style="display: contents;">
            <div class="faq-drawer">
                <input class="faq-drawer__trigger" id="faq-drawer" type="checkbox" /><label class="faq-drawer__title" style="background: #96a3d5c7;" for="faq-drawer">Email Preview</label>
                <div class="faq-drawer__content-wrapper">
                    <div class="faq-drawer__content">
                        <textarea class="form-control" id="email_content" name="email_content">
                        {{$email[0]['email_body']}}
                        </textarea>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-12 text-center" style="padding: 10px;">
            <a type="button" class="btn btn-labeled back-btn" title="Back" href="{{ URL::previous() }}" style="color:white !important">
                <span class="btn-label" style="font-size:13px !important;"><i class="fa fa-arrow-left"></i></span> Back</a>
            <a type="button" onclick="pdfgenrate()" id="submitbutton" class="btn btn-labeled btn-succes" title="Submit" style="background: green !important; border-color:green !important; color:white !important">
                <span class="btn-label" style="font-size:13px !important;"><i class="fa fa-check"></i></span> Submit </a>
        </div>

    </div>

</div>
<script type="text/javascript">
    window.addEventListener("beforeunload", function(event) {
        // Only remove the editor if myFunction() has not been called
        if (typeof myFunction === "undefined") {
            tinymce.remove();
        }
    });

    var Q_Data = <?php echo json_encode($rows); ?>;
    // console.log(Q_Data);
    var dob = Q_Data[0].child_dob;
    var dobParts = dob.split('/');
    var birthdate = new Date(dobParts[2], dobParts[1] - 1, dobParts[0]);
    var now = new Date();
    var years = now.getFullYear() - birthdate.getFullYear();
    var months = now.getMonth() - birthdate.getMonth();
    if (months < 0 || (months === 0 && now.getDate() < birthdate.getDate())) {
        years--;
        months += 12;
    }

    var childAge = years + " years " + months + " months";

    var childDoB = birthdate.toLocaleDateString('en-US', {
        month: 'short',
        day: 'numeric',
        year: 'numeric'
    });

    document.getElementById('child_contact_email').value = Q_Data[0].child_contact_email;
    document.getElementById('child_name').value = Q_Data[0].child_name;
    document.getElementById('child_id').value = Q_Data[0].child_id;

    $(document).ready(function() {

        tinymce.init({
            selector: 'textarea#email_content',
            menubar: false,
            branding: false,
            toolbar: 'undo redo | formatselect | ' +
                'bold italic backcolor | alignleft aligncenter ' +
                'alignright alignjustify | bullist numlist outdent indent | ' +
                'removeformat ',
            content_style: 'body { font-family:Helvetica,Arial,sans-serif; font-size:14px }',

            setup: function(editor) {
                editor.on('init', function() {
                    content = editor.getContent();
                    content = content.replace(/___/g, Q_Data[0].meeting_startdate);
                    editor.setContent(content);
                });
            },

        });

        tinymce.init({
            selector: '.tinymce-body',
            plugins: 'preview importcss searchreplace autolink autosave save directionality code visualblocks visualchars fullscreen image link media codesample table charmap pagebreak nonbreaking anchor insertdatetime advlist lists wordcount help charmap quickbars emoticons',
            imagetools_cors_hosts: ['picsum.photos'],
            menubar: 'file edit view insert format tools table help',
            toolbar: 'undo redo | bold italic underline strikethrough | fontfamily fontsize blocks | alignleft aligncenter alignright alignjustify | outdent indent |  numlist bullist | forecolor backcolor removeformat | pagebreak | charmap emoticons | fullscreen  preview save print | insertfile image media link anchor codesample | ltr rtl',
            toolbar_sticky: true,
            autosave_ask_before_unload: true,
            autosave_interval: "30s",
            autosave_prefix: "{path}{query}-{id}-",
            autosave_restore_when_empty: false,
            autosave_retention: "2m",
            image_advtab: true,
            font_formats: "Andale Mono=andale mono,times; Arial=arial,helvetica,sans-serif; Arial Black=arial black,avant garde; Barlow=Barlow, sans-serif; Barlow Condensed=Barlow Condensed, sans-serif; Barlow Condensed Bold=Barlow Condensed Bold, sans-serif; Barlow Condensed Thin=Barlow Condensed Thin, sans-serif; Barlow Semi-Condensed=Barlow Semi-Condensed, sans-serif; Barlow Semi-Condensed Bold=Barlow Semi-Condensed Bold, sans-serif; Barlow Semi-Condensed Thin=Barlow Semi-Condensed Thin, sans-serif; Plain Barlow Black=Barlow Black, sans-serif; Plain Barlow Bold=Barlow Bold, sans-serif; Plain Barlow Light=Barlow Light, sans-serif; Plain Barlow Medium=Barlow Medium, sans-serif; Plain Barlow Thin=Barlow Thin, sans-serif; Book Antiqua=book antiqua,palatino; Comic Sans MS=comic sans ms,sans-serif; Courier New=courier new,courier; Georgia=georgia,palatino; Helvetica=helvetica; Impact=impact,chicago; Oswald=oswald; Symbol=symbol; Tahoma=tahoma,arial,helvetica,sans-serif; Terminal=terminal,monaco; Times New Roman=times new roman,times; Trebuchet MS=trebuchet ms,geneva; Verdana=verdana,geneva; Webdings=webdings; Wingdings=wingdings,zapf dingbats",
            content_style: "@import url('https://fonts.googleapis.com/css2?family=Oswald&display=swap');",
            content_style: "@import url('https://fonts.googleapis.com/css2?family=Barlow&display=swap');",
            importcss_append: true,

            file_picker_callback: function(cb, value, meta) {
                var input = document.createElement('input');
                input.setAttribute('type', 'file');
                input.setAttribute('accept', 'image/*');

                input.onchange = function() {
                    var file = this.files[0];

                    var reader = new FileReader();
                    reader.onload = function() {
                        var id = 'blobid' + (new Date()).getTime();
                        var blobCache = tinymce.activeEditor.editorUpload.blobCache;
                        var base64 = reader.result.split(',')[1];
                        var blobInfo = blobCache.create(id, file, base64);
                        blobCache.add(blobInfo);

                        /* call the callback and populate the Title field with the file name */
                        cb(blobInfo.blobUri(), {
                            title: file.name
                        });
                    };
                    reader.readAsDataURL(file);
                };

                input.click();
            },
            width: '210mm',
            margin: 85,
            height: 520,
            image_caption: true,
            quickbars_selection_toolbar: 'bold italic | quicklink h2 h3 blockquote quickimage quicktable',
            noneditable_noneditable_class: "mceNonEditable",
            toolbar_mode: 'sliding',
            contextmenu: "link image imagetools table",

            setup: function(editor) {
                editor.on('init', function() {
                    content = editor.getContent();
                    // console.log(Q_Data[0].schools_attended_school_currently_grade);
                    content = content.replace(/childName/g, Q_Data[0].child_name);
                    content = content.replace(/childInterventions_data/g, Q_Data[0].previous_interventions_given_current_intervention);
                    content = content.replace(/childAcademic_data/g, Q_Data[0].academics);
                    content = content.replace(/childAssessment_data/g, Q_Data[0].any_assessment_done);
                    content = content.replace(/childStrength_data/g, Q_Data[0].strength_interests);
                    content = content.replace(/childInterest_data/g, Q_Data[0].strength_interests);
                    // content = content.replace(/childSupport_data/g, Q_Data[0].developmental_milestones_motor_lang_speech);
                    content = content.replace(/childSupport_data/g, Q_Data[0].current_challenges_concerns);
                    content = content.replace(/childIntrospection_data/g, Q_Data[0].introspection);
                    content = content.replace(/childExpectations_data/g, Q_Data[0].expectation_from_elina);
                    content = content.replace(/childAoR_data/g, Q_Data[0].child_contact_address);
                    content = content.replace(/meetingDate/g, Q_Data[0].meeting_startdate);
                    content = content.replace(/childExpectationsSchool_data/g, Q_Data[0].expectation_from_school);
                    content = content.replace(/childAge/g, childAge);
                    content = content.replace(/childDoB/g, childDoB);

                    editor.setContent(content);
                    content = content.replace(/null/g, '');
                    editor.setContent(content);
                });
            },

        });
        tinymce.init({
  selector: 'textarea',
  toolbar: "undo redo | styleselect | fontselect | bold italic | alignleft aligncenter alignright alignjustify | outdent indent",
  font_formats: "Andale Mono=andale mono,times; Arial=arial,helvetica,sans-serif; Arial Black=arial black,avant garde; Book Antiqua=book antiqua,palatino; Comic Sans MS=comic sans ms,sans-serif; Courier New=courier new,courier; Georgia=georgia,palatino; Helvetica=helvetica; Impact=impact,chicago; Oswald=oswald; Symbol=symbol; Tahoma=tahoma,arial,helvetica,sans-serif; Terminal=terminal,monaco; Times New Roman=times new roman,times; Trebuchet MS=trebuchet ms,geneva; Verdana=verdana,geneva; Webdings=webdings; Wingdings=wingdings,zapf dingbats",
  content_style: "@import url('https://fonts.googleapis.com/css2?family=Oswald&display=swap'); body { font-family: Oswald; }",
  height: 500
});
    });
</script>
<script>
    function pdfgenrate() {
        Swal.fire({

            title: "Do you want to publish the Sail Guide?",
            text: "Please click 'Yes' to publish the Sail Guide",
            icon: "warning",
            customClass: 'swalalerttext',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            confirmButtonText: "Yes",
            cancelButtonText: "No",
            width: '550px',
        }).then((result) => {
            if (result.value) {
                $(".loader").show();
                // document.getElementsByClassName('tinymce-body').style.display = 'block';

                var entirePage = $('#entirePage').html();
                entirePage = entirePage.replace('display: none;', "");

                var editor1 = tinyMCE.get('page-body').getContent({
                    format: 'html'
                });

                // console.log(editor1);

                var child_email = document.getElementById('child_contact_email').value;
                var child_id = document.getElementById('child_id').value;
                var child_name = document.getElementById('child_name').value;
                // $("#submitbutton").addClass("disable-click");
                var email_content = tinyMCE.get('email_content').getContent();
                // document.getElementById('email_draft').value = email_content;

                $.ajax({
                    url: "{{ url('/report/SailGuide/generatePDF') }}",
                    type: 'POST',
                    data: {
                        'entirePage': editor1,
                        'con': entirePage,
                        'child_email': child_email,
                        'child_id': child_id,
                        'child_name': child_name,
                        'email_content': email_content,
                        _token: '{{csrf_token()}}'
                    }
                }).done(function(data) {
                    $(".loader").hide();
                    swal.fire("Success", "Sail Guide Sent Successfully", "success").then(function() {
                        window.location = "/ovmreport";
                    });
                })
                // tinymce.remove();
            } else {
                return false;
            }
        })
    }
</script>
@endsection