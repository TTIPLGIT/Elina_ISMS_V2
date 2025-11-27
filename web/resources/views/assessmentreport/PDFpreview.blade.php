@extends('layouts.adminnav')

@section('content')

<style>
    .content {
        /* display: none; */
    }

    .page {
        width: 210mm;
        /* min-height: 297mm; */
        padding: 20mm;
        margin: 10mm auto;
        border: 1px #D3D3D3 solid;
        border-radius: 5px;
        background: white;
        box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);
    }

    #img_logo {
        margin: 25px 150px 0 0;
    }

    select {
        appearance: none !important;
    }

    .container {
        margin: 0 auto;
        background-color: #FFFFFF;
        padding: 20px;
        box-shadow: 0px 0px 10px #BBBBBB;
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
    {{ Breadcrumbs::render('assessment_report.show',$data['report_id']) }}
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
    <input type="hidden" value="{{$data['email']}}" id="child_contact_email" name="child_contact_email">
    <input type="hidden" value="{{$data['child_name']}}" id="child_name" name="child_name">
    <input type="hidden" value="{{$data['child_dob']}}" id="child_dob" name="child_dob">
    <input type="hidden" value="{{$data['enrollment_id']}}" id="enrollment_id" name="enrollment_id">
    <div class="col-12 form-group" style="float:left;">
        <h4 style="color:darkblue;text-align: center;">Assessment Report Preview</h4>
        <select class="col-3 form-control default" style="margin: -45px 0 0 -15px;" id="Tableview" onchange="view_change()">
            <option value="1">Assessment Executive Report</option>
            <option value="2">Assessment Detail Report</option>
        </select>
    </div>

    <div id="executive_report">
        <iframe src="{{$reportURLs['executive_report']}}" width="100%" height="600" frameborder="0"></iframe>
    </div>

    <div id="summary_report" style="display: none;">
        <iframe src="{{$reportURLs['summary_report']}}" width="100%" height="600" frameborder="0"></iframe>
    </div>
    <div style="display: contents;">
        <div class="faq-drawer">
            <input class="faq-drawer__trigger" id="faq-drawer" type="checkbox" /><label class="faq-drawer__title" style="background: #96a3d5c7;" for="faq-drawer">Email Preview</label>
            <div class="faq-drawer__content-wrapper">
                <div class="faq-drawer__content">
                    <textarea class="form-control" id="email_content" name="email_content">{{$data['email_draft']}}</textarea>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-12 text-center" style="padding: 10px;">
        <!-- <a type="button" class="btn btn-labeled btn-info back" id="Previous" title="Previous" style="display:none;height: 35px;background: blue !important; border-color:blue !important; color:white !important">
            <span class="btn-label" style="font-size:13px !important;"><i class="fa fa-arrow-left"></i></span> Previous</a> -->
        <a type="button" class="btn btn-labeled back-btn" title="Back" href="{{ URL::previous() }}" style="color:white !important">
            <span class="btn-label" style="font-size:13px !important;"><i class="fa fa-arrow-left"></i></span> Back</a>
        <input type="hidden" value="{{ route('assessmentreport.edit', \Crypt::encrypt($data['report_id'])) }}" id="routeUrl">
        <a href="{{ route('assessmentreport.edit', \Crypt::encrypt($data['report_id'])) }}" type="button" id="editbutton" class="btn btn-labeled btn-succes" title="Edit" style="background: orange !important; color:white !important">
            <span class="btn-label" style="font-size:13px !important;"><i class="fas fa-pencil-alt"></i></span> Edit </a>
        <a type="button" onclick="pdfgenrate('{{$data['report_id']}}')" id="submitbutton" class="btn btn-labeled btn-succes" title="Publish" style="background: green !important; border-color:green !important; color:white !important">
            <span class="btn-label" style="font-size:13px !important;"><i class="fa fa-check"></i></span> Publish </a>
        <!-- <a type="button" class="btn btn-labeled btn-info next" id="Next" title="Next" style="background: blue !important; border-color:#4d94ff !important; color:white !important;height: 35px;">
                <span class="btn-label" style="font-size:13px !important;">Next</span> <i class="fa fa-arrow-right"></i></a> -->
    </div>
</div>

<script>
    function view_change() {
        $('#executive_report').toggle();
        $('#summary_report').toggle();
    }

    function pdfgenrate(reportID) {
        $(".loader").show();

        $('.view1').show();
        $('.view2').show();

        var view1 = $('.view1').html(); //console.log(view1);
        var view2 = $('.view2').html(); //console.log(view2);
        // var view = [view1 , view2];
        var child_dob = document.getElementById('child_dob').value;
        var child_name = document.getElementById('child_name').value;
        var child_contact_email = document.getElementById('child_contact_email').value;
        var enrollment_id = document.getElementById('enrollment_id').value;
        var email_content = tinyMCE.get('email_content').getContent();
        $("#submitbutton").addClass("disable-click");
        $.ajax({
            url: "{{ url('/report/assessment/generatePDFAssessment') }}",
            type: 'POST',
            data: {
                'reportID': reportID,
                'view1': view1,
                'view2': view2,
                'child_name': child_name,
                'child_dob': child_dob,
                'child_contact_email': child_contact_email,
                'enrollment_id': enrollment_id,
                'email_content': email_content,
                _token: '{{csrf_token()}}'
            }
        }).done(function(data) {
            $('.view2').hide();
            $(".loader").hide();

            // console.log(data);
            // var newWindow = window.open('Report', '_blank', 'newwindow', 'width=1000,height=720');
            // newWindow.document.title = 'Custom Window Title';
            // var newContent = '<iframe src="' + data.summary_report + '" width="100%" height="600" frameborder="0"></iframe>';
            // newWindow.document.write(newContent);

            // var newWindow = window.open('', '_blank', 'width=1000,height=720');
            // var newContent = '<iframe src="'+data.executive_report+'" width="100%" height="600" frameborder="0"></iframe>';
            // newWindow.document.write(newContent);

            swal.fire("Success", "The Assessment Report has been published successfully", "success").then(function() {
                window.location = "/report/assessmentreport";
            });
        })
    }
</script>
<script>
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
                var childName = <?php echo json_encode($data['child_name']); ?>;
                editor.on('init', function() {
                    content = editor.getContent();
                    content = content.replace(/childName/g, childName);
                    editor.setContent(content);
                });
            },

        });
    });
    document.addEventListener('DOMContentLoaded', function() {
        var tables = document.getElementsByClassName('table');

        for (var i = 0; i < tables.length; i++) {
            var table = tables[i];
            if (table.rows.length <= 1) {
                table.style.display = 'none';
            }
        }
    });
</script>
@endsection