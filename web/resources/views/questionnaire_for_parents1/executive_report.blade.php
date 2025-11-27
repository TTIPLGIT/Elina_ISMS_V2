@extends('layouts.adminnav')

@section('content')

<style>
    .page {
        min-height: 297mm;
        padding: 10mm;
        margin: 10mm auto;
        border: 1px #D3D3D3 solid;
        border-radius: 5px;
        background: white;
        box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);
    }

    #img_logo {
        margin: 25px 150px 0 0;
    }
</style>
<style>
    .container {
        /* max-width: 800px; */
        margin: 0 auto;
        background-color: #FFFFFF;
        padding: 20px;
        /* border-radius: 10px; */
        box-shadow: 0px 0px 10px #BBBBBB;
    }

    table {
        border-collapse: collapse;
        border: 1px solid black;
        margin: 20px 0;
        width: 100%;
    }

    th,
    td {
        border: 1px solid black;
        background-color: #FFFFFF;
        color: #000000;
        padding: 10px;
        text-align: left;
    }

    td[contenteditable="true"] {
        /* background-color: #F9E79F; */
        width: 200px;
        /* Set a fixed width for the editable cells */
    }

    td:nth-child(1) {
        width: 20%;
    }

    td:nth-child(2) {
        width: 40%;
    }

    td:nth-child(3) {
        width: 40%;
    }

    table {
        width: 100%;
        table-layout: fixed;
    }

    td {
        width: 33.33%;
        height: auto;
        padding: 10px;
        border: 1px solid black;
        box-sizing: border-box;
        vertical-align: initial !important;
    }
    /* table { page-break-inside:auto } */
    tr {
        page-break-inside: avoid;
    }

    thead {
        display: table-header-group
    }

    tfoot {
        display: table-footer-group
    }
</style>

<div class="main-content">

    <div class="section-body mt-0">
        <h4 style="color:darkblue;    text-align: center;">Executive Functioning</h4>
        <div class="container" id="entirePage" style="page-break-after: always;">
            <div class="tinymce-body" style="page-break-inside:avoid;">{{$head}}</div>
            <form class="formValidationDiv" action="{{ route('executive_report_update') }}" method="post" id="executive_report_update">
                <table style="page-break-inside:avoid;">
                    <tbody style="page-break-inside:avoid;">
                        <tr>
                            <td>Executive Skill (s)</td>
                            <td>Strengths</td>
                            <td>Stretches</td>
                        </tr>
                        <tr>
                            <td>Response Inhibition</td>
                            <td style="text-align: initial;" contenteditable="true">
                                <div name="response_inhibition['Strength']" id="response_inhibition['Strength']" contenteditable="true" style="text-align: left;" oninput="document.getElementById('response_inhibition_strength').value = this.innerHTML;">
                                    <p>Parent Form</p>
                                    @foreach($questions['parent']['Response Inhibition']['Strength'] as $question)
                                    {{$question['question']}}<br>
                                    @endforeach

                                    @if($questions['child'] != '')
                                    <p>Child Form</p>
                                    @foreach($questions['child']['Response Inhibition']['Strength'] as $question)
                                    {{$question['question']}}<br>
                                    @endforeach
                                    @endif
                                </div>
                            </td>
                            <input type="hidden" name="response_inhibition['Strength']" id="response_inhibition_strength">
                            <td style="text-align: initial;" contenteditable="true">
                                <div name="response_inhibition['Stretches']" id="response_inhibition['Stretches']" contenteditable="true" style="text-align: left;" oninput="document.getElementById('response_inhibition_stretches').value = this.innerHTML;">
                                    <p>Parent Form</p>
                                    @foreach($questions['parent']['Response Inhibition']['Stretches'] as $question)
                                    {{$question['question']}}<br>
                                    @endforeach
                                    @if($questions['child'] != '')
                                    <p>Child Form</p>
                                    @foreach($questions['child']['Response Inhibition']['Stretches'] as $question)
                                    {{$question['question']}}<br>
                                    @endforeach
                                    @endif
                                </div>
                            </td>
                            <input type="hidden" name="response_inhibition['Stretches']" id="response_inhibition_stretches">
                        </tr>
                        <tr>
                            <td>Working Memory</td>
                            <td style="text-align: initial;" contenteditable="true">
                                <div name="working_memory['Strength']" id="working_memory['Strength']" contenteditable="true" style="text-align: left;" oninput="document.getElementById('working_memory_strength').value = this.innerHTML;">
                                    <p>Parent Form</p>
                                    @foreach($questions['parent']['Working Memory']['Strength'] as $question)
                                    {{$question['question']}}<br>
                                    @endforeach
                                    @if($questions['child'] != '')
                                    <p>Child Form</p>
                                    @foreach($questions['child']['Working Memory']['Strength'] as $question)
                                    {{$question['question']}}<br>
                                    @endforeach
                                    @endif
                                </div>
                            </td>
                            <input type="hidden" id="working_memory_strength" name="working_memory['Strength']">
                            <td style="text-align: initial;" contenteditable="true">
                                <div name="working_memory['Stretches']" id="working_memory['Stretches']" contenteditable="true" style="text-align: left;" oninput="document.getElementById('working_memory_stretches').value = this.innerHTML;">
                                    <p>Parent Form</p>
                                    @foreach($questions['parent']['Working Memory']['Stretches'] as $question)
                                    {{$question['question']}}<br>
                                    @endforeach
                                    @if($questions['child'] != '')
                                    <p>Child Form</p>
                                    @foreach($questions['child']['Working Memory']['Stretches'] as $question)
                                    {{$question['question']}}<br>
                                    @endforeach
                                    @endif
                                </div>
                            </td>
                            <input type="hidden" name="working_memory['Stretches']" id="working_memory_stretches">
                        </tr>
                        <tr>
                            <td>Emotional Control </td>
                            <td style="text-align: initial;" contenteditable="true">
                                <div name="" id="" style="text-align: left;">
                                    <p>Parent Form</p>
                                    @foreach($questions['parent']['Emotional Control']['Strength'] as $question)
                                    {{$question['question']}}<br>
                                    @endforeach
                                    @if($questions['child'] != '')
                                    <p>Child Form</p>
                                    @foreach($questions['child']['Emotional Control']['Strength'] as $question)
                                    {{$question['question']}}<br>
                                    @endforeach
                                    @endif
                                </div>
                            </td>
                            <td style="text-align: initial;" contenteditable="true">
                                <div name="" id="" style="text-align: left;">
                                    <p>Parent Form</p>
                                    @foreach($questions['parent']['Emotional Control']['Stretches'] as $question)
                                    {{$question['question']}}<br>
                                    @endforeach
                                    @if($questions['child'] != '')
                                    <p>Child Form</p>
                                    @foreach($questions['child']['Emotional Control']['Stretches'] as $question)
                                    {{$question['question']}}<br>
                                    @endforeach
                                    @endif
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>Flexibility</td>
                            <td style="text-align: initial;" contenteditable="true">
                                <div name="" id="" style="text-align: left;">
                                    <p>Parent Form</p>
                                    @foreach($questions['parent']['Flexibility']['Strength'] as $question)
                                    {{$question['question']}}<br>
                                    @endforeach
                                    @if($questions['child'] != '')
                                    <p>Child Form</p>
                                    @foreach($questions['child']['Flexibility']['Strength'] as $question)
                                    {{$question['question']}}<br>
                                    @endforeach
                                    @endif
                                </div>
                            </td>
                            <td style="text-align: initial;" contenteditable="true">
                                <div name="" id="" style="text-align: left;">
                                    <p>Parent Form</p>
                                    @foreach($questions['parent']['Flexibility']['Stretches'] as $question)
                                    {{$question['question']}}<br>
                                    @endforeach
                                    @if($questions['child'] != '')
                                    <p>Child Form</p>
                                    @foreach($questions['child']['Flexibility']['Stretches'] as $question)
                                    {{$question['question']}}<br>
                                    @endforeach
                                    @endif
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>Sustained Attention</td>
                            <td style="text-align: initial;" contenteditable="true">
                                <div name="" id="" style="text-align: left;">
                                    <p>Parent Form</p>
                                    @foreach($questions['parent']['Sustained Attention']['Strength'] as $question)
                                    {{$question['question']}}<br>
                                    @endforeach
                                    @if($questions['child'] != '')
                                    <p>Child Form</p>
                                    @foreach($questions['child']['Sustained Attention']['Strength'] as $question)
                                    {{$question['question']}}<br>
                                    @endforeach
                                    @endif
                                </div>
                            </td>
                            <td style="text-align: initial;" contenteditable="true">
                                <div name="" id="" style="text-align: left;">
                                    <p>Parent Form</p>
                                    @foreach($questions['parent']['Sustained Attention']['Stretches'] as $question)
                                    {{$question['question']}}<br>
                                    @endforeach
                                    @if($questions['child'] != '')
                                    <p>Child Form</p>
                                    @foreach($questions['child']['Sustained Attention']['Stretches'] as $question)
                                    {{$question['question']}}<br>
                                    @endforeach
                                    @endif
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>Task Initiation</td>
                            <td style="text-align: initial;" contenteditable="true">
                                <div name="" id="" style="text-align: left;">
                                    <p>Parent Form</p>
                                    @foreach($questions['parent']['Task Initiation']['Strength'] as $question)
                                    {{$question['question']}}<br>
                                    @endforeach
                                    @if($questions['child'] != '')
                                    <p>Child Form</p>
                                    @foreach($questions['child']['Task Initiation']['Strength'] as $question)
                                    {{$question['question']}}<br>
                                    @endforeach
                                    @endif
                                </div>
                            </td>
                            <td style="text-align: initial;" contenteditable="true">
                                <div name="" id="" style="text-align: left;">
                                    <p>Parent Form</p>
                                    @foreach($questions['parent']['Task Initiation']['Stretches'] as $question)
                                    {{$question['question']}}<br>
                                    @endforeach
                                    @if($questions['child'] != '')
                                    <p>Child Form</p>
                                    @foreach($questions['child']['Task Initiation']['Stretches'] as $question)
                                    {{$question['question']}}<br>
                                    @endforeach
                                    @endif
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>Planning / Prioritizing</td>
                            <td style="text-align: initial;" contenteditable="true">
                                <div name="" id="" style="text-align: left;">
                                    <p>Parent Form</p>
                                    @foreach($questions['parent']['Planning/Prioritization']['Strength'] as $question)
                                    {{$question['question']}}<br>
                                    @endforeach
                                    @if($questions['child'] != '')
                                    <p>Child Form</p>
                                    @foreach($questions['child']['Planning/Prioritization']['Strength'] as $question)
                                    {{$question['question']}}<br>
                                    @endforeach
                                    @endif
                                </div>
                            </td>
                            <td style="text-align: initial;" contenteditable="true">
                                <div name="" id="" style="text-align: left;">
                                    <p>Parent Form</p>
                                    @foreach($questions['parent']['Planning/Prioritization']['Stretches'] as $question)
                                    {{$question['question']}}<br>
                                    @endforeach
                                    @if($questions['child'] != '')
                                    <p>Child Form</p>
                                    @foreach($questions['child']['Planning/Prioritization']['Stretches'] as $question)
                                    {{$question['question']}}<br>
                                    @endforeach
                                    @endif
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>Organization</td>
                            <td style="text-align: initial;" contenteditable="true">
                                <div name="" id="" style="text-align: left;">
                                    <p>Parent Form</p>
                                    @foreach($questions['parent']['Organization']['Strength'] as $question)
                                    {{$question['question']}}<br>
                                    @endforeach
                                    @if($questions['child'] != '')
                                    <p>Child Form</p>
                                    @foreach($questions['child']['Organization']['Strength'] as $question)
                                    {{$question['question']}}<br>
                                    @endforeach
                                    @endif
                                </div>
                            </td>
                            <td style="text-align: initial;" contenteditable="true">
                                <div name="" id="" style="text-align: left;">
                                    <p>Parent Form</p>
                                    @foreach($questions['parent']['Organization']['Stretches'] as $question)
                                    {{$question['question']}}<br>
                                    @endforeach
                                    @if($questions['child'] != '')
                                    <p>Child Form</p>
                                    @foreach($questions['child']['Organization']['Stretches'] as $question)
                                    {{$question['question']}}<br>
                                    @endforeach
                                    @endif
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>Time Management</td>
                            <td style="text-align: initial;" contenteditable="true">
                                <div name="" id="" style="text-align: left;">
                                    <p>Parent Form</p>
                                    @foreach($questions['parent']['Time Management']['Strength'] as $question)
                                    {{$question['question']}}<br>
                                    @endforeach
                                    @if($questions['child'] != '')
                                    <p>Child Form</p>
                                    @foreach($questions['child']['Time Management']['Strength'] as $question)
                                    {{$question['question']}}<br>
                                    @endforeach
                                    @endif
                                </div>
                            </td>
                            <td style="text-align: initial;" contenteditable="true">
                                <div name="" id="" style="text-align: left;">
                                    <p>Parent Form</p>
                                    @foreach($questions['parent']['Time Management']['Stretches'] as $question)
                                    {{$question['question']}}<br>
                                    @endforeach
                                    @if($questions['child'] != '')
                                    <p>Child Form</p>
                                    @foreach($questions['child']['Time Management']['Stretches'] as $question)
                                    {{$question['question']}}<br>
                                    @endforeach
                                    @endif
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>Metacognition</td>
                            <td style="text-align: initial;" contenteditable="true">
                                <div name="" id="" style="text-align: left;">
                                    <p>Parent Form</p>
                                    @foreach($questions['parent']['Metacognition']['Strength'] as $question)
                                    {{$question['question']}}<br>
                                    @endforeach
                                    @if($questions['child'] != '')
                                    <p>Child Form</p>
                                    @foreach($questions['child']['Metacognition']['Strength'] as $question)
                                    {{$question['question']}}<br>
                                    @endforeach
                                    @endif
                                </div>
                            </td>
                            <td style="text-align: initial;" contenteditable="true">
                                <div name="" id="" style="text-align: left;">
                                    <p>Parent Form</p>
                                    @foreach($questions['parent']['Metacognition']['Stretches'] as $question)
                                    {{$question['question']}}<br>
                                    @endforeach
                                    @if($questions['child'] != '')
                                    <p>Child Form</p>
                                    @foreach($questions['child']['Metacognition']['Stretches'] as $question)
                                    {{$question['question']}}<br>
                                    @endforeach
                                    @endif
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <div style="page-break-inside:avoid;"></div>
            </form>
        </div>

    </div>
    <div class="col-md-12 text-center" style="padding: 10px;">
        <a type="button" class="btn btn-labeled back-btn" title="Back" href="{{ URL::previous() }}" style="color:white !important">
            <span class="btn-label" style="font-size:13px !important;"><i class="fa fa-arrow-left"></i></span> Cancel</a>
        <!-- <a type="button" onclick="updateForm()" id="submitbutton" class="btn btn-labeled btn-succes" title="Submit" style="background: green !important; border-color:green !important; color:white !important">
            <span class="btn-label" style="font-size:13px !important;"><i class="fa fa-download"></i></span> Update </a> -->
        <a type="button" onclick="pdfgenrate()" id="submitbutton" class="btn btn-labeled btn-succes" title="Submit" style="background: green !important; border-color:green !important; color:white !important">
            <span class="btn-label" style="font-size:13px !important;"><i class="fa fa-download"></i></span> Download as PDF </a>
    </div>
</div>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        var divContent = document.getElementById('response_inhibition[\'Strength\']').innerHTML;
        document.getElementById('response_inhibition_strength').value = divContent;

        var divContent = document.getElementById('response_inhibition[\'Stretches\']').innerHTML;
        document.getElementById('response_inhibition_stretches').value = divContent;

        // var divContent = document.getElementById('response_inhibition[\'Strength\']').innerHTML;
        // document.getElementById('response_inhibition_strength').value = divContent;

        // var divContent = document.getElementById('response_inhibition[\'Strength\']').innerHTML;
        // document.getElementById('response_inhibition_strength').value = divContent;

        // var divContent = document.getElementById('response_inhibition[\'Strength\']').innerHTML;
        // document.getElementById('response_inhibition_strength').value = divContent;

        // var divContent = document.getElementById('response_inhibition[\'Strength\']').innerHTML;
        // document.getElementById('response_inhibition_strength').value = divContent;

        // var divContent = document.getElementById('response_inhibition[\'Strength\']').innerHTML;
        // document.getElementById('response_inhibition_strength').value = divContent;

        // var divContent = document.getElementById('response_inhibition[\'Strength\']').innerHTML;
        // document.getElementById('response_inhibition_strength').value = divContent;

        // var divContent = document.getElementById('response_inhibition[\'Strength\']').innerHTML;
        // document.getElementById('response_inhibition_strength').value = divContent;
    });
</script>
<script type="text/javascript">
    function updateForm() {
        document.getElementById('executive_report_update').submit();
    }

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
    });
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.9.2/html2pdf.bundle.min.js"></script>
<script>
    var childName = <?php echo json_encode($childName); ?>;

    function pdfgenrate(reportID) {
        var entirePage = document.getElementById('entirePage').innerHTML;
        entirePage = entirePage.replace(/<\/?span[^>]*>/g, "");

        const element = document.getElementById('entirePage');
        const options = {
            filename: 'executive_functioning_'+childName+'.pdf',
            html2canvas: {
                scale: 4,
                useCORS: true,
                dpi: 192,
                letterRendering: true
            },
            jsPDF: {
                unit: 'in',
                format: 'letter',
                orientation: 'portrait',
            },
        };

        // Adjust margins using CSS styles
        element.style.margin = '10px';

        html2pdf().set(options).from(element).save();

        // $.ajax({
        //     url: "{{ url('/pdfdownload') }}",
        //     type: 'POST',
        //     data: {
        //         'entirePage': entirePage,
        //         _token: '{{csrf_token()}}'
        //     }
        // }).done(function(data) {
        //     console.log(data);
        //     // swal.fire("Success", "PDF Genrated", "success");
        // })
    }
</script>
<!-- <script type="text/javascript">
    $(document).ready(function() {
        $('#content-1').show();

        tinymce.init({
            selector: 'textarea#meeting_description',
            height: 180,
            menubar: false,
            branding: false,
            content_style: 'body { font-family:Helvetica,Arial,sans-serif; font-size:14px }'
        });

    });
</script>

<script>
    function discription_content() {
        document.getElementById('new_page').submit();
    }

    var counter = 1;

    $('body').on('click', '.next', function() {
        $('.content').hide();

        counter++;
        $('#content-' + counter + '').show();

        if (counter > 1) {
            $('.back').show();
        };
        if (counter >= totalPage) {
            $('.next').hide();
        };
        $('html,body').scrollTop(0);
    });

    $('body').on('click', '.back', function() {
        counter--;
        $('.content').hide();
        var id = counter;
        $('#content-' + id).show();
        if (counter == 1) {
            $('.back').hide();
            $('.next').show();
        };
        $('html,body').scrollTop(0);

    });
</script>
<script>
    $(document).ready(function() {
        var entirePage = document.getElementById('entirePage').innerHTML;

    });
</script> -->

@endsection