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
        /* padding: 10px; */
        text-align: left;
    }

    /* td[contenteditable="true"] {
        width: 200px;
    } */

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
        /* padding: 10px; */
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

    @media print {

        /* Avoid page break after the last element */
        .last-element {
            page-break-after: avoid;
        }
    }
</style>

<div class="main-content">

    <div class="section-body mt-0">
        <h4 style="color:darkblue;    text-align: center;">{{$questions[0]['questionnaire_name']}} Quadrant</h4>
        <div class="container" id="entirePage" style="page-break-after: always;padding:40px">
            <div class="tinymce-body">
                <div style="font-size:16px">{{$head}}</div>
                <table pagebreak="after">
                    <tbody>
                        <tr>
                            <td>Sensory Threshold</td>
                            <td>Passive Behavioural Response</td>
                            <td>Active Behavioural Response</td>
                        </tr>
                        <tr>
                            <td>Under-Reactive System (HIGH)</td>
                            <td>Missing stimuli, responding slowly</td>
                            <td>Seeks out and is attracted to a stimulating sensory environment</td>
                        </tr>
                        <tr>
                            <td></td>
                            <td contenteditable="true">
                                <ul style="text-align: initial;">
                                    @foreach($questions as $question)
                                    @if($question['quadrant'] == 'REGISTRATION')
                                    <li style="float: left;">{{$question['question']}}</li><br>
                                    @endif
                                    @endforeach
                                </ul>
                            </td>
                            <td contenteditable="true">
                                <ul style="text-align: initial;">
                                    @foreach($questions as $question)
                                    @if($question['quadrant'] == 'SEEKING')
                                    <li style="float: left;">{{$question['question']}}</li><br>
                                    @endif
                                    @endforeach
                                </ul>
                            </td>
                        </tr>
                        <tr>
                            <td>Over-Reactive System (LOW)</td>
                            <td>Sensitivity to stimuli, distractibility, discomfort with sensory stimuli</td>
                            <td>Distressed by a stimulating sensory environment and attempts to leave the environment</td>
                        </tr>
                        <tr>
                            <td></td>
                            <td contenteditable="true">
                                <ul style="text-align: initial;">
                                    @foreach($questions as $question)
                                    @if($question['quadrant'] == 'SENSITIVITY')
                                    <li style="float: left;">{{$question['question']}}</li><br>
                                    @endif
                                    @endforeach
                                </ul>
                            </td>
                            <td contenteditable="true">
                                <ul style="text-align: initial;">
                                    @foreach($questions as $question)
                                    @if($question['quadrant'] == 'AVOIDING')
                                    <li style="float: left;">{{$question['question']}}</li><br>
                                    @endif
                                    @endforeach
                                </ul>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <div style="page-break-inside:avoid;font-size:16px">{{$footer}}</div>
            </div>
        </div>

    </div>
    <div class="col-md-12 text-center" style="padding: 10px;">
        <a type="button" class="btn btn-labeled back-btn" title="Back" href="{{ URL::previous() }}" style="color:white !important">
            <span class="btn-label" style="font-size:13px !important;"><i class="fa fa-arrow-left"></i></span> Cancel</a>
        <a type="button" onclick="pdfgenrate()" id="submitbutton" class="btn btn-labeled btn-succes" title="Submit" style="background: green !important; border-color:green !important; color:white !important">
            <span class="btn-label" style="font-size:13px !important;"><i class="fa fa-download"></i></span> Download as PDF </a>
    </div>
</div>
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
            filename: 'sensory_profiling_'+childName+'.pdf',
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