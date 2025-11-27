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
        /* display: none; */
    }

    .alignment {
        text-align: center;
    }



    .page {
        width: 210mm;
        /* min-height: 297mm; */
        padding: 10mm;
        margin: 10mm auto;
        border: 1px #D3D3D3 solid;
        border-radius: 5px;
        background: white;
        box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);
    }

    /* .circle-container {
  display: flex;
  align-items: center;
  justify-content: center;
} */

    /* .circle {
  width: 100px;
  height: 100px;
  border-radius: 50%;
  background-color: #ddd;
  display: flex;
  align-items: center;
  justify-content: center;
} */

    /* .circle-content {
  text-align: center;
} */
    .select2-container {
        width: 1% !important;
        display: table-cell !important;
    }

    .select2-container--default .select2-selection--multiple .select2-selection__choice {
        color: black !important;
    }

    .select2-container .select2-selection--multiple .select2-selection__rendered {
        white-space: normal !important;
        max-height: 100px;
        overflow-y: scroll;
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

    /* .tox.tox-tinymce {
        margin: 0 0 0 85px;
    } */

    /* .a4-editor {
        width: calc(210mm / 25.4 * 96px);
        height: calc(297mm / 25.4 * 96px);
    } */
</style>
<div class="main-content">
    {{ Breadcrumbs::render('referralreport.show',$data['report_id']) }}
    @if (session('success'))

    <input type="hidden" name="session_data" id="session_data" class="session_data" value="{{ session('success') }}">
    <script type="text/javascript">
        window.onload = function() {
            var message = $('#session_data').val();
            swal.fire("Success", message, "success");

        }
    </script>
    @elseif(session('fail'))

    <input type="hidden" name="session_data" id="session_data1" class="session_data" value="{{ session('error') }}">
    <script type="text/javascript">
        window.onload = function() {
            var message = $('#session_data1').val();
            swal.fire("Info", message, "info");

        }
    </script>
    @endif
    <div class="section-body mt-0">
        <h4 style="color:darkblue">Referral Report Preview</h4>
        
        <input type="hidden" name="child_contact_email" id="child_contact_email" value="{{$data['email']}}">
        <input type="hidden" name="child_name" id="child_name" value="{{$data['child_name']}}">
        <input type="hidden" name="enrollment_id" id="enrollment_id" value="{{$data['enrollment_id']}}">

        <div>
            <iframe src="{{$viewPDF}}" width="100%" height="600" frameborder="0"></iframe>
        </div>
        @if($data['status'] != 'Published')
        <div style="display: contents;">
        <div class="faq-drawer">
            <input class="faq-drawer__trigger" id="faq-drawer" type="checkbox" /><label class="faq-drawer__title" style="background: #96a3d5c7;" for="faq-drawer">Email Preview</label>
            <div class="faq-drawer__content-wrapper">
                <div class="faq-drawer__content">
                    <textarea class="form-control" id="email_content" name="email_content">{{$data['email_draft']}}</textarea>
                </div>
            </div>
        </div>
    </div>@endif
    </div>
    <div class="col-md-12 text-center" style="padding: 10px;">
        <a type="button" class="btn btn-labeled back-btn" title="Cancel" href="{{ route('referralreport.index') }}" style="color:white !important">
            <span class="btn-label" style="font-size:13px !important;"><i class="fa fa-arrow-left"></i></span> Cancel</a>
            @if($data['status'] != 'Published')
        <a href="{{ route('referralreport.edit', \Crypt::encrypt($data['report_id'])) }}" type="button" id="editbutton" class="btn btn-labeled btn-succes" title="Edit" style="background: orange !important; color:white !important">
            <span class="btn-label" style="font-size:13px !important;"><i class="fas fa-pencil-alt"></i></span> Edit </a>
        <a type="button" onclick="pdfgenrate('{{$data['report_id']}}')" id="submitbutton" class="btn btn-labeled btn-succes" title="Submit" style="background: green !important; border-color:green !important; color:white !important">
            <span class="btn-label" style="font-size:13px !important;"><i class="fa fa-check"></i></span> Publish </a>
            @endif
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/tinymce/4.5.6/tinymce.min.js"></script>
<script src="http://cdnjs.cloudflare.com/ajax/libs/tinymce/4.5.6/jquery.tinymce.min.js"></script>

<script type="text/javascript">
    $(document).ready(function() {

        tinymce.init({
            selector: '.tinymce-body',
            inline: true,
            menubar: false,
            branding: false,
            plugins: 'searchreplace',
            toolbar: 'undo redo | formatselect | ' +
                'bold italic backcolor | alignleft aligncenter ' +
                'alignright alignjustify | bullist numlist outdent indent | ' +
                'removeformat | searchreplace',
        });
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
                var childName = <?php echo json_encode($data['child_name']); ?>;
                editor.on('init', function() {
                    content = editor.getContent();
                    content = content.replace(/childName/g, childName);
                    editor.setContent(content);
                });
            },

        });
    });
</script>
<script>
    function pdfgenrate(reportID) {
        $(".loader").show();
        // var entirePage = document.getElementById('entirePage').innerHTML;
        // entirePage = entirePage.replace(/<\/?span[^>]*>/g, "");
        var child_contact_email = document.getElementById('child_contact_email').value;
        var childName = document.getElementById('child_name').value;
        var enrollment_id = document.getElementById('enrollment_id').value;
        var email_content = tinyMCE.get('email_content').getContent();
        $("#submitbutton").addClass("disable-click");
        $.ajax({
            url: "{{ url('/report/referral/generatePDF') }}",
            type: 'POST',
            data: {
                'reportID': reportID,
                // 'entirePage': entirePage,
                'child_contact_email': child_contact_email,
                'enrollment_id': enrollment_id,
                'childName': childName,
                'email_content': email_content,
                _token: '{{csrf_token()}}'
            }
        }).done(function(data) {

            $(".loader").hide();
            // swal.fire("Success", "Report Sent Successfully", "success");
            swal.fire("Success", "The Referral Report has been published successfully.", "success").then(function() {
                window.location.href = "{{route('referralreport.index')}}";
            });
        })
    }
</script>

@endsection