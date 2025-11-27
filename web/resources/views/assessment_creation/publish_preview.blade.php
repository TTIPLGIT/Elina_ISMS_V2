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
</style>
<div class="main-content">
    {{ Breadcrumbs::render('reports_master.show',$report[0]['reports_id']) }}
    <div class="section-body mt-0">
        <h4 style="color:darkblue">Report Preview </h4>



        <div class="card question">
            <div class="card-body">
                <div class="row is-coordinate">
                    <div class="col-md-3 alignment">
                        <div class="form-group">
                            <label class="control-label">Type</label><span class="error-star" style="color:red;">*</span>

                            <input class="form-control" type="text" id="report_type" name="report_type" value="{{$report[0]['report_type']}}" autocomplete="off">



                        </div>
                    </div>
                    <div class="col-md-5 alignment">
                        <div class="form-group">
                            <label class="control-label">Report Name</label><span class="error-star" style="color:red;">*</span>
                            <input class="form-control" type="text" id="report_name" name="report_name" value="{{$report[0]['report_name']}}" autocomplete="off">

                        </div>
                    </div>

                    <input type="hidden" value="{{$report[0]['reports_id']}}" name="report_id" id="report_id">

                    <div class="col-md-2 alignment">
                        <div class="form-group questionnaire">

                            <label class="control-label required">Total Page</label><br>
                            <input class="form-control" type="number" id="page" name="page" value="{{$report[0]['pages']}}" autocomplete="off">
                        </div>
                    </div>


                    <div class="col-md-2 alignment">
                        <div class="form-group">
                            <label class="control-label">Version</label><span class="error-star" style="color:red;">*</span>
                            <input class="form-control" type="text" id="report_version" name="report_version" value="{{$report[0]['version']}}" autocomplete="off">

                        </div>
                    </div>


                    <!-- <div class="col-md-3 alignment">
                    <div class="form-group">
                        <label class="control-label">Status</label><span class="error-star" style="color:red;">*</span>
                        <input class="form-control" type="text" id="child_name" name="child_name" value="New" autocomplete="off">
                    </div>
                </div> -->
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
        <a type="button" class="btn btn-labeled btn-info back" id="Previous" title="Previous" style="display:none;height: 35px;background: blue !important; border-color:blue !important; color:white !important">
            <span class="btn-label" style="font-size:13px !important;"><i class="fa fa-arrow-left"></i></span> Previous</a>
      
        <!-- <button type="button" class="back">Back</button>
            <button type="button" class="next">Next</button> -->
        <!-- <a type="button" class="btn btn-labeled btn-info" id="Next" title="Publish" style="background: blue !important; border-color:#4d94ff !important; color:white !important;height: 35px;">
                <span class="btn-label" style="font-size:13px !important;">Publish</span></a> -->
        @if($role_name == 'IS Head')
        <button class="btn btn-success" onclick="publish()">Approve</button>

        <a type="button" class="btn btn-labeled" title="Edit" href="{{ route('reports_master.edit', \Crypt::encrypt($report[0]['reports_id'])) }}" style="background-color: #ffff00ad;color:white !important">
            <span class="btn-label" style="font-size:13px !important;"><i class="fas fa-pencil-alt"></i></span> Edit</a>
        @else
        <button class="btn btn-success" onclick="publish()">Publish</button>

        @endif
        <a type="button" class="btn btn-labeled back-btn" title="Back" href="{{ route('asessmentreportmaster.index') }}" style="color:white !important">
            <span class="btn-label" style="font-size:13px !important;"><i class="fa fa-arrow-left"></i></span> Back</a>
        <a type="button" class="btn btn-labeled btn-info next" id="Next" title="Next" style="background: blue !important; border-color:#4d94ff !important; color:white !important;height: 35px;">
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
    function publish() {
        Swal.fire({

            title: "Do you want to Publish the Report ?",
            text: "Please click 'Yes' to Publish the Report.",
            icon: "warning",
            customClass: 'swalalerttext',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            confirmButtonText: "Yes",
            cancelButtonText: "No",
            closeOnConfirm: false,
            closeOnCancel: true,
            showLoaderOnConfirm: true,
            width: '550px',
        }).then((result) => {
            if (result.value) {
                var report_id = document.getElementById("report_id").value;
                var report_name = document.getElementById("report_name").value;


                $.ajax({
                    url: '{{ url('/master/final/submit') }}',
                    type: "POST",
                    data: {
                        _token: '{{csrf_token()}}',
                        action: 'Published',
                        report_id: report_id,
                        report_name: report_name
                    },

                    success: function(data) {
                        window.location.href = "/master/assessment";

                    },
                    error: function(data) {
                        swal.fire({
                            title: "Error",
                            text: data,
                            type: "error",
                            confirmButtonColor: '#e73131',
                            confirmButtonText: 'OK',
                        });

                    }
                });
            }
        })
    }

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