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
        padding: 20mm;
        margin: 10mm auto;
        border: 1px #D3D3D3 solid;
        border-radius: 5px;
        background: white;
        box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);
    }

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
        .breadcrumb::-webkit-scrollbar {
            display: none;
        }
        .breadcrumb-item,
        .breadcrumb-item a {
            white-space: nowrap !important;
            font-size: 11px !important;
        }

        body, .main-content {
            overflow-x: hidden !important;
            padding: 0 5px !important;
        }

        table, .table-responsive {
            display: block !important;
            width: 100% !important;
            overflow-x: auto !important;
            -webkit-overflow-scrolling: touch;
        }

        .form-group, .form-control, .select2-container, .tox-tinymce {
            width: 100% !important;
        }

        .card-body, .section-body {
            padding: 10px !important;
        }

        .row {
            display: flex;
            flex-direction: column;
        }

        .col-md-1, .col-md-2, .col-md-3, .col-md-4, .col-md-5, .col-md-6, .col-md-7, .col-md-8, .col-md-9, .col-md-10, .col-md-11, .col-md-12 {
            width: 100% !important;
            max-width: 100% !important;
        }

        .page {
            width: 100% !important;
            padding: 10px !important;
            margin: 0 auto !important;
        }

        /* PDF iframe height on mobile */
        iframe {
            height: 450px !important;
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

        /* Back button full width on mobile (optional) */
        .action-buttons .btn {
            width: auto !important;
            min-width: 120px !important;
        }
    }

    /* Desktop: hide mobile download button */
    .mobile-download-btn {
        display: none;
    }
</style>

<div class="main-content">
    {{ Breadcrumbs::render('recommendation.preview',$report[0]['report_id']) }}

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

        <!-- Mobile Download Button (only visible on mobile) -->
        <div class="mobile-download-btn">
            <a href="{{ $viewPDF }}" download="Recommendation_Report.pdf" class="btn report-download-btn">
                <i class="fa fa-download"></i> Download Report (PDF)
            </a>
        </div>

        <!-- PDF Viewer -->
        <div>
            <iframe src="{{ $viewPDF }}" width="100%" height="600" frameborder="0"></iframe>
        </div>
    </div>

    <!-- Action Buttons -->
    <div class="col-md-12 text-center action-buttons">
        <!-- Back button - red color -->
        <a type="button" class="btn btn-labeled back-btn" title="Back" href="{{ route('recommendation.index') }}" style="color:white !important; background: #dc3545 !important; border-color: #dc3545 !important;">
            <span class="btn-label" style="font-size:13px !important;"><i class="fa fa-arrow-left"></i></span> Back
        </a>
    </div>
</div>

<style>
/* Additional fix for button alignment on desktop */
.action-buttons {
    text-align: center;
}
</style>

@endsection