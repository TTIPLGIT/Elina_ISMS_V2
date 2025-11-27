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

    .tox.tox-tinymce.email-editor-class {
        margin: 0 !important;
    }

    /* .a4-editor {
        width: calc(210mm / 25.4 * 96px);
        height: calc(297mm / 25.4 * 96px);
    } */

    .select2-container {
        width: 100% !important;
    }

    .select2-container--default .select2-selection--multiple .select2-selection__choice {
        color: black !important;
    }
</style>
<style>
    @import url('https://fonts.googleapis.com/css2?family=Oswald&display=swap');
</style>
<div class="main-content">
    @if (session('success'))
    @if (session('success') == 'Submitted Successfully')
    <input type="hidden" name="session_data" id="session_data" class="session_data" value="{{ session('success') }}">
    <script type="text/javascript">
        window.onload = function() {
            var message = $('#session_data').val();
            Swal.fire({
                title: 'Success!',
                text: message,
                icon: 'success',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Preview'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Call the preview function here
                    Preview()
                }
            });
        }
    </script>
    @else
    <input type="hidden" name="session_data" id="session_data" class="session_data" value="{{ session('success') }}">
    <script type="text/javascript">
        window.onload = function() {
            var message = $('#session_data').val();
            Swal.fire('Success!', message, 'success');
        }
    </script>
    @endif
    @elseif(session('fail'))
    <input type="hidden" name="session_data" id="session_data1" class="session_data" value="{{ session('fail') }}">
    <script type="text/javascript">
        window.onload = function() {
            var message = $('#session_data1').val();
            Swal.fire('Info!', message, 'info');
        }
    </script>
    @endif

    <div class="section-body mt-0">
        <h4 style="color:darkblue;    text-align: center;">Report Editor</h4>
        <div class="container" id="entirePage">
            <div class="tinymce-body" id="page-body" style="margin: 0 0 0 85px !important;">
                @foreach($report as $data1)
                <div style="page-break-after: always" class="section" data-section="{{ $data1['page'] }}">
                    {!! $data1['page_description'] !!}
                </div>
                @endforeach
            </div>
        </div>
        <form action="{{ route('sailguide.save') }}" method="post" id="formSubmit">
            @csrf
            <input type="hidden" name="child_contact_email" id="child_contact_email">
            <input type="hidden" name="child_name" id="child_name">
            <input type="hidden" name="child_id" id="child_id">
            <input type="hidden" name="enrollment_id" id="enrollment_id">
        </form>
        @if($rows[0]['finalstatus'] != 1)
        <div style="display: contents;">
            <div class="faq-drawer">
                <input class="faq-drawer__trigger" id="faq-drawer" type="checkbox" /><label class="faq-drawer__title" style="background: #96a3d5c7;" for="faq-drawer">Email Preview</label>
                <div class="faq-drawer__content-wrapper">
                    <div class="faq-drawer__content">
                        <div class="form-group">
                            <label for="mail_cc">CC:</label>
                            <select class="form-control mail_cc js-select2" id="mail_cc" multiple="multiple" name="mail_cc[]">
                                <option></option>

                                {{-- Existing users --}}
                                @foreach($users as $user)
                                <option value="{{ $user['email'] }}"
                                    {{ in_array($user['email'], $ccEmails) ? 'selected' : '' }}>
                                    {{ $user['name'] }} : {{ $user['email'] }}
                                </option>
                                @endforeach

                                {{-- Extra emails that are in $ccEmails but not in $users --}}
                                @foreach($ccEmails as $ccEmail)
                                @if(!collect($users)->pluck('email')->contains($ccEmail))
                                <option value="{{ $ccEmail }}" selected>
                                    {{ $ccEmail }}
                                </option>
                                @endif
                                @endforeach
                            </select>
                        </div>
                        <textarea class="form-control" id="email_content" name="email_content">
                        {{$email}}
                        </textarea>
                    </div>
                </div>
            </div>
        </div>
        @endif

        <div class="col-md-12 text-center" style="padding: 10px;">
            <a type="button" class="btn btn-labeled back-btn" title="Back" href="{{ URL::previous() }}" style="color:white !important">
                <span class="btn-label" style="font-size:13px !important;"><i class="fa fa-arrow-left"></i></span> Back</a>
            @if($rows[0]['finalstatus'] != 1)
            <a type="button" onclick="Preview()" id="submitbutton" class="btn btn-labeled btn-info" title="Preview" style="background: orange !important; border-color:green !important; color:white !important">
                <span class="btn-label" style="font-size:13px !important;"><i class="fa fa-eye"></i></span> Preview </a>
            <a type="button" onclick="SaveData()" id="submitbutton" class="btn btn-labeled btn-info" title="Save" style="background: blue !important; border-color:green !important; color:white !important">
                <span class="btn-label" style="font-size:13px !important;"><i class="fa fa-bookmark"></i></span> Save </a>
            <a type="button" onclick="SubmitData()" id="submitbutton" class="btn btn-labeled btn-info" title="Submit" style="background: darkblue !important; border-color:darkblue !important; color:white !important">
                <span class="btn-label" style="font-size:13px !important;"><i class="far fa-check-circle"></i></span>Submit</a>

            <a type="button" onclick="pdfgenrate()" id="submitbutton" class="btn btn-labeled btn-succes" title="Publish" style="background: green !important; border-color:green !important; color:white !important">
                <span class="btn-label" style="font-size:13px !important;"><i class="fa fa-check"></i></span> Publish </a>
            @endif
        </div>

    </div>

</div>

<script type="text/javascript">
    function SaveData() {
        console.log('save');
        var sections = document.querySelectorAll('.section');
        var editor = tinymce.get('page-body');
        // tinyMCE.get('email_content').getContent();

        sections.forEach(function(section, index) {
            var sectionIndex = section.getAttribute('data-section');
            // var sectionContent = section.innerHTML;
            var sectionContent = editor.getBody().querySelector('.section[data-section="' + sectionIndex + '"]').innerHTML;
            // console.log(sectionContent);
            var inputElement = document.createElement('input');
            inputElement.type = 'hidden';
            inputElement.name = 'section[' + sectionIndex + ']';
            inputElement.value = sectionContent;

            document.getElementById('formSubmit').appendChild(inputElement);
            // console.log(inputElement);
        });

        var inputSave = document.createElement('input');
        inputSave.type = 'hidden';
        inputSave.name = 'status';
        inputSave.value = 'Save';
        // var email_draft = tinyMCE.get('email_content').getContent();
        document.getElementById('formSubmit').appendChild(inputSave);
        // Create a hidden input field for email_content
        var emailContentInput = document.createElement('input');
        emailContentInput.type = 'hidden';
        emailContentInput.name = 'email_content';
        emailContentInput.value = tinymce.get('email_content').getContent();
        document.getElementById('formSubmit').appendChild(emailContentInput);

        // Mail CC
        const selectElement = document.getElementById('mail_cc');
        const selectedValues = Array.from(selectElement.selectedOptions).map(option => option.value);
        const hiddenValue = selectedValues.join(',');
        const mailCcInput = document.createElement('input');
        mailCcInput.type = 'hidden';
        mailCcInput.name = 'mail_cc';
        mailCcInput.value = hiddenValue;
        document.getElementById('formSubmit').appendChild(mailCcInput);
        // console.log('Selected values:', selectedValues);

        document.getElementById('formSubmit').submit();
    }

    function SubmitData() {
        Swal.fire({
            title: "Do you want to submit the data?",
            text: "Please click 'Yes' to submit.",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: "Yes",
            cancelButtonText: "No"
        }).then((result) => {
            if (result.isConfirmed) {
                // User clicked "Yes", proceed with form submission

                var sections = document.querySelectorAll('.section');
                var editor = tinymce.get('page-body');

                sections.forEach(function(section, index) {
                    var sectionIndex = section.getAttribute('data-section');
                    var sectionContent = editor.getBody().querySelector('.section[data-section="' + sectionIndex + '"]').innerHTML;

                    var inputElement = document.createElement('input');
                    inputElement.type = 'hidden';
                    inputElement.name = 'section[' + sectionIndex + ']';
                    inputElement.value = sectionContent;

                    document.getElementById('formSubmit').appendChild(inputElement);
                });

                var inputSave = document.createElement('input');
                inputSave.type = 'hidden';
                inputSave.name = 'status';
                inputSave.value = 'Submitted';
                document.getElementById('formSubmit').appendChild(inputSave);

                // Create a hidden input field for email_content
                var emailContentInput = document.createElement('input');
                emailContentInput.type = 'hidden';
                emailContentInput.name = 'email_content';
                emailContentInput.value = tinymce.get('email_content').getContent();
                document.getElementById('formSubmit').appendChild(emailContentInput);

                // Mail CC
                const selectElement = document.getElementById('mail_cc');
                const selectedValues = Array.from(selectElement.selectedOptions).map(option => option.value);
                const hiddenValue = selectedValues.join(',');
                const mailCcInput = document.createElement('input');
                mailCcInput.type = 'hidden';
                mailCcInput.name = 'mail_cc';
                mailCcInput.value = hiddenValue;
                document.getElementById('formSubmit').appendChild(mailCcInput);

                // Submit the form
                document.getElementById('formSubmit').submit();

                // Optionally, call preview function here
                preview();
            } else {
                // User clicked "No", handle cancellation
                console.log('Form submission cancelled.');
            }
        });
    }


    function handleConfirmation() {
        var confirmation = confirm("Submitted Successfully. Do you want to preview?");
        if (confirmation) {
            preview();
        } else {
            // Handle the cancel action if needed
        }
    }

    window.addEventListener("beforeunload", function(event) {
        // Only remove the editor if myFunction() has not been called
        if (typeof myFunction === "undefined") {
            tinymce.remove();
        }
    });

    var Q_Data = <?php echo json_encode($rows); ?>;
    // console.log(Q_Data[0]);
    // console.log('Adhi');
    const valuesArray = JSON.parse(Q_Data[0].services_from_elina);
    var concatenatedString = Object.values(valuesArray).join(', ');
    var Introspection_fetch_data = Q_Data[0].conversation_027 + ',' + Q_Data[0].conversation_028 + ' ,' + Q_Data[0].conversation_029 + ' ,' + Q_Data[0].conversation_030 + ' ,' + Q_Data[0].conversation_031 + ' ,' + Q_Data[0].conversation_032 + ' ,' + Q_Data[0].conversation_033 + ' ,' + Q_Data[0].conversation_034 + ' ,' + Q_Data[0].conversation_035 + ' ,' + Q_Data[0].conversation_036 + ' ,' + Q_Data[0].conversation_037 + ' ,' + Q_Data[0].conversation_038 + ' ,' + Q_Data[0].conversation_039 + ' ,' + Q_Data[0].conversation_040 + ' ,' + Q_Data[0].conversation_041 + ' ,' + Q_Data[0].conversation_044 + ' ,' + Q_Data[0].conversation_045;
    var tempElement = $('<div>').html(Introspection_fetch_data);
    Introspection_fetch_data = tempElement.text();
    // console.log('Introspection_fetch_data', Introspection_fetch_data);

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
    var gender = (Q_Data[0].child_gender == "Male") ? 'He' : 'She';
    var genderAdjectives = (Q_Data[0].child_gender == "Male") ? 'his' : 'her';

    var childDoB = birthdate.toLocaleDateString('en-US', {
        month: 'short',
        day: 'numeric',
        year: 'numeric'
    });

    document.getElementById('child_contact_email').value = Q_Data[0].child_contact_email;
    document.getElementById('child_name').value = Q_Data[0].child_name;
    document.getElementById('child_id').value = Q_Data[0].child_id;
    document.getElementById('enrollment_id').value = Q_Data[0].enID;

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
            init_instance_callback: function(editor) {
                editor.getContainer().classList.add('email-editor-class');
            }

        });
        var readonlyval = 0;
        var readonly = <?php echo json_encode($rows[0]['finalstatus']); ?>;
        if (readonly == 1) {
            readonlyval = 1;
        }
        tinymce.init({
            selector: '.tinymce-body',
            plugins: 'ruler preview importcss searchreplace autolink autosave save directionality code visualblocks visualchars fullscreen image link media codesample table charmap pagebreak nonbreaking anchor insertdatetime advlist lists wordcount help charmap quickbars emoticons',
            imagetools_cors_hosts: ['picsum.photos'],
            images_dataimg_filter: function(img) {
                return img.hasAttribute('internal-blob');
            },
            menubar: 'file edit view insert format tools table help',
            toolbar: 'undo redo | bold italic underline strikethrough | fontfamily fontsize blocks | alignleft aligncenter alignright alignjustify | outdent indent |  numlist bullist | forecolor backcolor removeformat | pagebreak | charmap emoticons | fullscreen  preview save print | insertfile image media link anchor codesample | ltr rtl ruler',
            fontsize_formats: '8pt 9pt 10pt 11pt 12pt 13pt 14pt 15pt 16pt 17pt 18pt 19pt 20pt 21pt 22pt 23pt 24pt 25pt 26pt 27pt 28pt 29pt 30pt 31pt 32pt 33pt 34pt 35pt 36pt 37pt 38pt 39pt 40pt 41pt 42pt 43pt 44pt 45pt 46pt 47pt 48pt 49pt 50pt',
            toolbar_sticky: true,
            readonly: readonlyval,
            autosave_ask_before_unload: true,
            autosave_interval: "30s",
            autosave_prefix: "{path}{query}-{id}-",
            autosave_restore_when_empty: false,
            autosave_retention: "2m",
            image_advtab: true,
            content_css: "{{url('assets/css/css2.css')}}",
            // content_css: '.a4-editor',
            font_formats: "Andale Mono=andale mono,times; Arial=arial,helvetica,sans-serif; Arial Black=arial black,avant garde; Barlow=Barlow, sans-serif; Barlow Condensed=Barlow Condensed, sans-serif; Barlow Semi Condensed=Barlow Semi Condensed, sans-serif; Plain Barlow Black=Barlow Black, sans-serif; Plain Barlow Bold=Barlow Bold, sans-serif; Plain Barlow Light=Barlow Light, sans-serif; Plain Barlow Medium=Barlow Medium, sans-serif; Plain Barlow Thin=Barlow Thin, sans-serif; Book Antiqua=book antiqua,palatino; Comic Sans MS=comic sans ms,sans-serif; Courier New=courier new,courier; Georgia=georgia,palatino; Helvetica=helvetica; Impact=impact,chicago; Oswald=oswald; Symbol=symbol; Tahoma=tahoma,arial,helvetica,sans-serif; Terminal=terminal,monaco; Times New Roman=times new roman,times; Trebuchet MS=trebuchet ms,geneva; Verdana=verdana,geneva; Webdings=webdings; Wingdings=wingdings,zapf dingbats",
            content_style: "@import url('https://fonts.googleapis.com/css2?family=Barlow&display=swap');",
            content_style: "@import url(https://fonts.googleapis.com/css2?family=Barlow+Condensed:wght@400;display=swap);",
            content_style: "@import url(https://fonts.googleapis.com/css2?family=Barlow+Condensed:wght@700&display=swap);",
            content_style: "@import url('https://fonts.googleapis.com/css2?family=Barlow+Semi+Condensed:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap');",
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
                    content = content.replace(/childInterventions_data/g, $('<div>').html(Q_Data[0].conversation_021).text()); //$('<div>').html(Q_Data[0].conversation_021).text()
                    content = content.replace(/childAcademic_data/g, $('<div>').html(Q_Data[0].conversation_024).text()); //$('<div>').html(Q_Data[0].conversation_024).text()
                    content = content.replace(/childAssessment_data/g, $('<div>').html(Q_Data[0].conversation_062).text()); //$('<div>').html(Q_Data[0].conversation_062).text()
                    content = content.replace(/childStrength_data/g, $('<div>').html(Q_Data[0].conversation_063).text());
                    content = content.replace(/childInterest_data/g, $('<div>').html(Q_Data[0].conversation_063).text());
                    // content = content.replace(/childSupport_data/g, Q_Data[0].developmental_milestones_motor_lang_speech);
                    content = content.replace(/childSupport_data/g, $('<div>').html(Q_Data[0].conversation_033).text()); //$('<div>').html(Q_Data[0].conversation_033).text()
                    content = content.replace(/childIntrospection_data/g, Introspection_fetch_data); // 
                    content = content.replace(/childExpectations_data/g, concatenatedString);
                    content = content.replace(/childAoR_data/g, Q_Data[0].child_contact_address);
                    content = content.replace(/meetingDate/g, Q_Data[0].meeting_startdate);
                    content = content.replace(/childExpectationsSchool_data/g, Q_Data[0].expectation_from_school);
                    content = content.replace(/childAge/g, childAge);
                    content = content.replace(/childDoB/g, childDoB);

                    content = content.replace(/\bher\b/gi, genderAdjectives);
                    content = content.replace(/\bhim\b/gi, genderAdjectives);
                    content = content.replace(/\bhis\b/gi, genderAdjectives);
                    content = content.replace(/\bhe\b/gi, gender);
                    content = content.replace(/\bshe\b/gi, gender);

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
    function Preview() {
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
            url: "{{ url('/report/SailGuide/generatePDFPreview') }}",
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
            // console.log(data);
            var newWindow = window.open('Report', '_blank');
            var newContent = '<iframe src="' + data + '" width="100%" height="600" frameborder="0"></iframe>';
            newWindow.document.write(newContent);
        })
    }

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

                // Mail CC
                const selectElement = document.getElementById('mail_cc');
                const mailCC = Array.from(selectElement.selectedOptions).map(option => option.value);

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
                        'mail_cc': mailCC,
                        _token: '{{csrf_token()}}'
                    }
                }).done(function(data) {
                    $(".loader").hide();
                    swal.fire("Success", "Sail Guide Sent Successfully", "success").then(function() {
                        window.location = "/ovmreport";
                    });
                })

            } else {
                return false;
            }
        })
    }

    $(".js-select2").select2({
        closeOnSelect: false,
        placeholder: " Please Select Users",
        allowHtml: true,
        tags: true
    });
</script>
@endsection