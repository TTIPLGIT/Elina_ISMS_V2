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

    .content {
        display: none;
    }

    .page {
        width: 210mm;
        min-height: 297mm;
        padding: 20mm;
        margin: 10mm auto;
        border: 1px #D3D3D3 solid;
        border-radius: 5px;
        background: white;
        box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);
    }

    /* ============================================================
       MOBILE RESPONSIVE – screens ≤ 768px
       ============================================================ */
    @media (max-width: 768px) {

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

        /* Stack fields vertically, but keep label + asterisk inline */
        .row .col-md-4,
        .row .col-md-2 {
            flex: 0 0 100% !important;
            max-width: 100% !important;
            width: 100% !important;
            padding-left: 10px !important;
            padding-right: 10px !important;
            margin-bottom: 10px !important;
        }

        .form-group {
            text-align: left !important;
        }

        .form-group label {
            display: inline-block !important;
            white-space: nowrap !important;
            text-align: left !important;
            width: auto !important;
        }

        /* Asterisk must stay inline */
        .error-star {
            display: inline !important;
            margin-left: 2px !important;
        }

        .form-control,
        .form-control[type="text"],
        .form-control[type="number"],
        select.form-control {
            font-size: 14px !important;
            height: auto !important;
            padding: 8px 10px !important;
            width: 100% !important;
        }

        /* Page preview – adapt to screen, allow horizontal scroll */
        .page {
            width: 100% !important;
            min-height: auto !important;
            padding: 10px !important;
            margin: 5px auto !important;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-shadow: none;
            overflow-x: auto !important;
            -webkit-overflow-scrolling: touch;
        }

        .page table {
            width: 100% !important;
            min-width: 600px !important;
        }
        .page .table-responsive {
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
        }

        /* ---- Buttons: keep in one line exactly like desktop ---- */
        .col-md-12.text-center {
            display: flex !important;
            flex-wrap: nowrap !important;   /* no wrapping */
            justify-content: center !important;
            align-items: center !important;
            gap: 6px !important;
            padding: 10px !important;
            overflow-x: auto !important;   /* if screen is too narrow, allow scroll */
            -webkit-overflow-scrolling: touch;
        }

        .col-md-12.text-center .btn {
            flex: 0 0 auto !important;
            white-space: nowrap !important;
            padding: 6px 12px !important;
            font-size: 12px !important;
            height: auto !important;       /* override inline height */
            margin: 0 !important;
        }

        .btn .btn-label i,
        .btn i {
            font-size: 12px !important;
        }

        .btn .btn-label {
            font-size: 12px !important;
            padding: 0 !important;
        }

        /* Override any inline height from the buttons */
        #Previous, #Next, .back-btn {
            height: auto !important;
            line-height: 1.4 !important;
        }
    }
</style>
<div class="main-content">
    {{ Breadcrumbs::render('reports_master.show',$report[0]['reports_id']) }}

    <div class="section-body mt-0">
        <h4 style="color:darkblue">Report Preview </h4>



        <div class="card question">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4 alignment">
                        <div class="form-group">
                            <label class="control-label">Type<span class="error-star" style="color:red;">*</span></label>
                            <input class="form-control" type="text" id="report_type" name="report_type" value="{{$report[0]['report_type']}}" autocomplete="off">
                        </div>
                    </div>

                    <div class="col-md-4 alignment">
                        <div class="form-group">
                            <label class="control-label">Report Name<span class="error-star" style="color:red;">*</span></label>
                            <input class="form-control" type="text" id="report_name" name="report_name" value="{{$report[0]['report_name']}}" autocomplete="off">
                        </div>
                    </div>

                    <div class="col-md-2 alignment">
                        <div class="form-group questionnaire">
                            <label class="control-label required">Total Page</label><br>
                            <input class="form-control" type="number" id="page" name="page" value="{{$report[0]['pages']}}" autocomplete="off">
                        </div>
                    </div>

                    <div class="col-md-2 alignment">
                        <div class="form-group">
                            <label class="control-label">Version<span class="error-star" style="color:red;">*</span></label>
                            <input class="form-control" type="text" id="report_version" name="report_version" value="{{$report[0]['version']}}" autocomplete="off">
                        </div>
                    </div>

                </div>
            </div>
        </div>

        @foreach($pages as $page)
        <div class="col-12">
            <div class="content" id="content-{{$page['page']}}">
                <div class="page">
                    {!! $page['page_description'] !!}
                </div>
            </div>
        </div>
        @endforeach


    </div>
    <div class="col-md-12 text-center" style="padding: 10px;">
        <a type="button" class="btn btn-labeled btn-info back" id="Previous" title="Previous" style="display:none;background: blue !important; border-color:blue !important; color:white !important">
            <span class="btn-label" style="font-size:13px !important;"><i class="fa fa-arrow-left"></i></span> Previous</a>
        <a type="button" class="btn btn-labeled back-btn" title="Back" href="{{ route('asessmentreportmaster.index') }}" style="color:white !important">
            <span class="btn-label" style="font-size:13px !important;"><i class="fa fa-arrow-left"></i></span> Back</a>
        <a type="button" class="btn btn-labeled btn-info next" id="Next" title="Next" style="background: blue !important; border-color:#4d94ff !important; color:white !important;">
            <span class="btn-label" style="font-size:13px !important;">Next</span> <i class="fa fa-arrow-right"></i></a>
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/tinymce/4.5.6/tinymce.min.js"></script>
<script src="http://cdnjs.cloudflare.com/ajax/libs/tinymce/4.5.6/jquery.tinymce.min.js"></script>

<script type="text/javascript">
    $(document).ready(function() {
        $('#content-1').show();

        tinymce.init({
            selector: 'textarea#meeting_description',
            height: 180,
            menubar: false,
            branding: false,
            content_style: 'body { font-family:Helvetica,Arial,sans-serif; font-size:14px }'
        });
        // event.preventDefault()
    });
</script>

<script>
    function discription_content() {
        document.getElementById('new_page').submit();
    }

    var counter = 1;
    var totalPage = <?php echo (json_encode($totalPage)); ?>;

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


@endsection