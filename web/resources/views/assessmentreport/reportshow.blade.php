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
<div class="main-content">
    {{ Breadcrumbs::render('assessment_report.show',$report['report_id']) }}
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

    <div class="col-md-12 text-center" style="padding: 10px;">
        <a type="button" class="btn btn-labeled back-btn" title="Back" href="{{ URL::previous() }}" style="color:white !important">
            <span class="btn-label" style="font-size:13px !important;"><i class="fa fa-arrow-left"></i></span> Back</a>
    </div>
</div>

<script>
    function view_change() {
        $('#executive_report').toggle();
        $('#summary_report').toggle();
    }

</script>
@endsection