@extends('layouts.adminnav')

@section('content')

<style>
    .content {}

    .page {
        width: 210mm;
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

    .container {
        margin: 0 auto;
        background-color: #FFFFFF;
        padding: 20px;
        box-shadow: 0px 0px 10px #BBBBBB;
    }

    /* Breadcrumb */
    .breadcrumb {
        flex-wrap: nowrap !important;
        white-space: nowrap !important;
        overflow-x: auto;
        overflow-y: hidden;
    }

    /* Radio Buttons */
    .report-radio-group {
        display: flex;
        justify-content: center;
        align-items: center;
        gap: 30px;
        margin-top: 15px;
        flex-wrap: wrap;
    }

    .radio-option {
        font-weight: 600;
        cursor: pointer;
        margin: 0;
    }

    .radio-option input[type="radio"] {
        margin-right: 8px;
    }

    /* Mobile Download Buttons */
    .mobile-download-btn {
        display: none;
    }

    .report-download-btn {
        background: #036B86 !important;
        border-color: #036B86 !important;
        color: #fff !important;
        font-weight: 600;
    }

    .report-download-btn:hover {
        background: #036B86 !important;
        border-color: #036B86 !important;
        color: #fff !important;
    }

    /* PDF Viewer */
    #executive_report iframe,
    #summary_report iframe {
        width: 100%;
        height: 600px;
        border: none;
    }

    @media (max-width: 768px) {

        body,
        .main-content {
            overflow-x: hidden !important;
        }

        .breadcrumb {
            font-size: 12px !important;
            flex-wrap: nowrap !important;
            white-space: nowrap !important;
            overflow-x: auto !important;
        }

        .report-radio-group {
            flex-direction: column;
            gap: 10px;
            align-items: center;
        }

        .radio-option {
            text-align: center;
            font-size: 14px;
        }

        /* Show Download Button Only on Mobile */
        .mobile-download-btn {
            display: block;
            margin-bottom: 15px;
            text-align: center;
        }

        .report-download-btn {
            min-width: 250px;
        }

        /* Mobile PDF */
        #executive_report iframe,
        #summary_report iframe {
            height: 450px !important;
        }

        .page {
            width: 100% !important;
            padding: 10px !important;
            margin: 0 auto !important;
        }

        .col-md-1,
        .col-md-2,
        .col-md-3,
        .col-md-4,
        .col-md-5,
        .col-md-6,
        .col-md-7,
        .col-md-8,
        .col-md-9,
        .col-md-10,
        .col-md-11,
        .col-md-12 {
            width: 100% !important;
            max-width: 100% !important;
        }
    }
    .mobile-download-btn {
    display: none;
}
@media (max-width: 768px) {

    /* Breadcrumb in one line */
    .breadcrumb,
    .breadcrumb-container,
    ol.breadcrumb,
    ul.breadcrumb {
        display: flex !important;
        flex-wrap: nowrap !important;
        align-items: center !important;
        overflow-x: auto !important;
        overflow-y: hidden !important;
        white-space: nowrap !important;
        width: 100% !important;
        margin-bottom: 10px !important;
        padding: 5px !important;
    }

    .breadcrumb li,
    .breadcrumb-item {
        white-space: nowrap !important;
        font-size: 11px !important;
        display: inline-flex !important;
        align-items: center !important;
    }

    .breadcrumb::-webkit-scrollbar {
        display: none;
    }

    /* Title spacing */
    .form-group.text-center {
        margin-top: 5px !important;
    }
}

.report-download-btn {
    background: #036B86 !important;
    border-color: #036B86 !important;
    color: #fff !important;
    font-weight: 600;
}

@media (max-width:768px) {

    .mobile-download-btn {
        display: block;
        text-align: center;
        margin-bottom: 15px;
    }

    .report-download-btn {
        min-width: 250px;
    }
}
</style>

<div class="main-content">

    {{ Breadcrumbs::render('assessment_report.show',$report['report_id']) }}

    <div class="col-12 form-group text-center">

        <h4 style="color:darkblue;text-align:center;">
            Assessment Report Preview
        </h4>

        <div class="report-radio-group">

            <label class="radio-option">
                <input type="radio"
                       name="report_type"
                       value="1"
                       checked
                       onchange="view_change()">
                Assessment Executive Report
            </label>

            <label class="radio-option">
                <input type="radio"
                       name="report_type"
                       value="2"
                       onchange="view_change()">
                Assessment Detail Report
            </label>

        </div>

    </div>

<!-- Mobile Download Buttons -->
<div class="mobile-download-btn">

    <a id="downloadExecutive"
       href="{{$reportURLs['executive_report']}}"
       download="Executive_Report.pdf"
       class="btn report-download-btn">
        Download Executive Report
    </a>

    <a id="downloadSummary"
       href="{{$reportURLs['summary_report']}}"
       download="Detail_Report.pdf"
       class="btn report-download-btn"
       style="display:none;">
        Download Detail Report
    </a>

</div>

  

    <!-- Executive Report -->

    <div id="executive_report">
        <iframe src="{{$reportURLs['executive_report']}}"></iframe>
    </div>

    <!-- Detail Report -->

    <div id="summary_report" style="display:none;">
        <iframe src="{{$reportURLs['summary_report']}}"></iframe>
    </div>

    <!-- Back Button -->

    <div class="col-md-12 text-center" style="padding:10px;">
        <a type="button"
           class="btn btn-labeled back-btn"
           title="Back"
           href="{{ URL::previous() }}"
           style="color:white !important">

            <span class="btn-label" style="font-size:13px !important;">
                <i class="fa fa-arrow-left"></i>
            </span>

            Back

        </a>
    </div>

</div>

<script>
   function view_change() {

    let selected = document.querySelector(
        'input[name="report_type"]:checked'
    ).value;

    if (selected == '1') {

        $('#executive_report').show();
        $('#summary_report').hide();

        $('#downloadExecutive').show();
        $('#downloadSummary').hide();

    } else {

        $('#executive_report').hide();
        $('#summary_report').show();

        $('#downloadExecutive').hide();
        $('#downloadSummary').show();
    }
}
</script>

@endsection