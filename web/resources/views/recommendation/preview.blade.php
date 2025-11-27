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
        /* min-height: 297mm; */
        padding: 20mm;
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
<div class="main-content">
    {{ Breadcrumbs::render('recommendation.preview',$report[0]['report_id']) }}
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
        <h4 style="color:darkblue">Report Preview </h4>

        <input type="hidden" name="child_contact_email" id="child_contact_email" value="{{$report[0]['child_contact_email']}}">
        <input type="hidden" name="enrollment_id" id="enrollment_id" value="{{$report[0]['enrollment_id']}}">

        <div id="entirePage" style="font-family: 'Barlow'">
            @foreach($pages as $page)
            <div class="col-12">
                <div class="content" id="content-{{$page['page']}}">
                    <div class="page">

                        @if($page['page'] == 2)
                        <img style="display: block; margin-left: auto; margin-right: auto;" src="{{Config::get('setting.base_url')}}images/chain_image.JPG" width="566" height="72">
                        <div class="tinymce-body" style="font-family: 'Barlow'">{!! $page['page_description'] !!}</div>
                        <!-- components -->
                        <div /*class="col-12 scrollable fixTableHead title-padding"*/ id="page2" /*style="break-inside: avoid;page-break-inside: avoid;"*/>
                            <div class="table-responsive">
                                <table class="table table-bordered card-body" style="width: 100%;border-spacing: 0px;border-collapse: collapse;">
                                    <thead>
                                        <tr>
                                            <th width="35%" style="border: 1px solid #040404 !important;color: #141414;background-color: white !important;"> Components in the process of learning </th>
                                            <th width="65%" style="border: 1px solid #040404 !important;color: #141414;background-color: white !important;"> Recommendations based on child's strength </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($components as $component)
                                        <tr>
                                            <td style="border: 1px solid black !important;background: white;text-align: center !important;">{{$component['area_name']}}</td>
                                            @isset($component['description'])
                                            <td style="border: 1px solid black !important;background: white;">{!! $component['description'] !!}</td>
                                            @else
                                            <td style="border: 1px solid black !important;background: white;"></td>
                                            @endisset
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <!-- End components -->
                        @else
                        @if($page['page'] == 3)
                        <!-- <p style="page-break-after: always;"></p> -->
                        @endif
                        <div class="tinymce-body">{!! $page['page_description'] !!}</div>
                        @endif

                        @if($page['page'] == 3)
                        <img style="display: block; margin-left: auto; margin-right: auto;" src="{{Config::get('setting.base_url')}}images/Circle.JPG" width="515" height="322">
                        <!-- page 6 -->
                        <div class="col-12 scrollable fixTableHead title-padding" id="page6">
                        <div class="table-responsive">
                            <table class="table table-bordered card-body" id="main" style="width: 100%;border-spacing: 0px;border-collapse: collapse;">
                                <thead>
                                    <tr>
                                        <th width="20%" style="border: 1px solid #040404 !important;color: #141414;background-color: white !important;">Areas </th>
                                        <th width="40%" style="border: 1px solid #040404 !important;color: #141414;background-color: white !important;">Strength</th>
                                        <th width="40%" style="border: 1px solid #040404 !important;color: #141414;background-color: white !important;">Recommendation strategies and Environment </th>
                                        <!-- <th style="border: 1px solid #040404 !important;color: #141414;background-color: white !important;">Some strategies recommended</th> -->
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($page6 as $table6)
                                    <tr id="row">
                                        <td width="20%" style="background: white;border: 1px solid #0e0e0e !important;">{{$table6['area_name']}}</td>
                                        <td width="40%" style="background: white;border: 1px solid #0e0e0e !important;">{{$table6['strengths']}}</td>
                                        <td width="40%" style="background: white;border: 1px solid #0e0e0e !important;">
                                            <p id="disableselect{{$loop->iteration}}">{{$table6['recommended_enviroment']}}</p>
                                        </td>
                                        <!-- <td style="background: white;border: 1px solid #0e0e0e !important;">{{$table6['strategies_command']}}</td> -->
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <!-- End 6 -->
                    @endif
                    @if($page['page'] == 4)
                    <!-- Page 8 -->
                    <div class="col-12 scrollable fixTableHead title-padding" id="page7" /*style="page-break-inside: avoid;border: 1px solid #0e0e0e !important;*/">
                        <div class="table-responsive">
                            <table class="table table-bordered" id="main2" style="width: 100%;border-spacing: 0px;border-collapse: collapse;">
                                <thead>
                                    <tr>
                                        <th style="border: 1px solid #040404 !important;color: #141414;background-color: white !important;">Areas</th>
                                        <th style="border: 1px solid #040404 !important;color: #141414;background-color: white !important;" colspan="6">Factors</th>
                                    </tr>
                                </thead>
                                
                                    @php $iteration = 0; @endphp

                                    @foreach($areas as $table7)
                                    <tbody style="page-break-inside: avoid;">
                                    @php $iteration = $iteration+1; @endphp
                                    <tr id="row2" class="table_column{{$iteration}}" style="border: 1px solid #0e0e0e !important;border-collapse: collapse;">
                                        <td style="background-color:orange !important; background: white;border-collapse: collapse;border: 1px solid #0e0e0e !important;">{{ $table7['area_name']}}</td>

                                        @php $sub_iteration = 0; @endphp
                                        @foreach($page7 as $factors)
                                        @if($factors['recommendation_detail_area_id']==$table7['recommendation_detail_area_id'])
                                        @php $sub_iteration = $sub_iteration+1; @endphp
                                        <td style="background-color:orange !important;background: white;border: 1px solid #0e0e0e !important;border-collapse: collapse !important;" id="table_column{{$iteration}}">{{ $factors['factor_name']}}</td>
                                        @endif
                                        @if($loop->last)
                                        @for($i = $sub_iteration; $i < $page7Max ; $i++) <td style="border-right: 1px solid #0e0e0e !important;background: white;border: 1px solid #0e0e0e !important;border-collapse: collapse !important;" id="table_column{{$iteration}}">
                                            </td>
                                            @endfor
                                            @endif
                                            @endforeach
                                    </tr>
                                    <!--  -->
                                    <tr id="row2" class="table_column{{$iteration}}" style="border-right: 1px solid #0e0e0e !important;border: 1px solid #0e0e0e !important;border-collapse: collapse;">
                                        <td style="background: white;border-right: 1px solid #0e0e0e !important;border: 1px solid #0e0e0e !important;border-collapse: collapse;"></td>
                                        @foreach($page7 as $factors)
                                        @if($factors['recommendation_detail_area_id']==$table7['recommendation_detail_area_id'])

                                        <td style="background: white;border-right: 1px solid #0e0e0e !important;border: 1px solid #0e0e0e !important;border-collapse: collapse !important;" id="table_column{{$iteration}}">{{ $factors['detail']}}</td>
                                        @endif
                                        @if($loop->last)
                                        @for($i = $sub_iteration; $i < $page7Max ; $i++) 
                                        <td style="background: white;border-right: 1px solid #0e0e0e !important;border: 1px solid #0e0e0e !important;border-collapse: collapse !important;" id="table_column{{$iteration}}">
                                            </td>
                                            @endfor
                                            @endif
                                            @endforeach
                                    </tr>
                                    <!--  -->
                                    </tbody>
                                    @endforeach
                                
                            </table>
                        </div>
                    </div>
                    <!-- End 8 -->
                    @endif
                </div>
            </div>
            @endforeach
        </div>
        
    </div>


</div>
<div class="col-md-12 text-center" style="padding: 10px;">
    <a type="button" class="btn btn-labeled btn-info back" id="Previous" title="Previous" style="display:none;height: 35px;background: blue !important; border-color:blue !important; color:white !important">
        <span class="btn-label" style="font-size:13px !important;"><i class="fa fa-arrow-left"></i></span> Previous</a>
    <a type="button" class="btn btn-labeled back-btn" title="Back" href="{{ route('recommendation.index') }}" style="color:white !important">
        <span class="btn-label" style="font-size:13px !important;"><i class="fa fa-arrow-left"></i></span> Back</a>
    <input type="hidden" value="{{ route('recommendation.edit', \Crypt::encrypt($report[0]['report_id'])) }}" id="routeUrl">
    <a href="{{ route('recommendation.edit', \Crypt::encrypt($report[0]['report_id'])) }}" type="button" id="editbutton" class="btn btn-labeled btn-succes" title="Edit" style="background: orange !important; color:white !important">
        <span class="btn-label" style="font-size:13px !important;"><i class="fas fa-pencil-alt"></i></span> Edit </a>
    <a type="button" class="btn btn-labeled btn-info next" id="Next" title="Next" style="background: blue !important; border-color:#4d94ff !important; color:white !important;height: 35px;">
        <span class="btn-label" style="font-size:13px !important;">Next</span> <i class="fa fa-arrow-right"></i></a>

    <a type="button" onclick="pdfgenrate('{{$report[0]['report_id']}}')" id="submitbutton" class="btn btn-labeled btn-succes" title="Publish" style="background: green !important; border-color:green !important; color:white !important">
        <span class="btn-label" style="font-size:13px !important;"><i class="fa fa-check"></i></span> Publish </a>

</div>
</div>
<script>
    function selectenable(ed) {
        $('#enableselect' + ed).show();
        $('#disableselect' + ed).hide();
    }
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/tinymce/4.5.6/tinymce.min.js"></script>
<script src="http://cdnjs.cloudflare.com/ajax/libs/tinymce/4.5.6/jquery.tinymce.min.js"></script>
<script>
    $(".js-select5").select2({
        closeOnSelect: false,
        placeholder: " Please Select the value ",
        allowHtml: true,
        allowClear: true,
        tags: true // создает новые опции на лету
    });
</script>
<script type="text/javascript">
    $(document).ready(function() {
        $('#content-1').show();

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
                font_formats: "Andale Mono=andale mono,times;Barlow=Barlow, normal; Arial=arial,helvetica,sans-serif; Arial Black=arial black,avant garde; Book Antiqua=book antiqua,palatino; Comic Sans MS=comic sans ms,sans-serif; Courier New=courier new,courier; Georgia=georgia,palatino; Helvetica=helvetica; Impact=impact,chicago; Oswald=oswald; Symbol=symbol; Tahoma=tahoma,arial,helvetica,sans-serif; Terminal=terminal,monaco; Times New Roman=times new roman,times; Trebuchet MS=trebuchet ms,geneva; Verdana=verdana,geneva; Webdings=webdings; Wingdings=wingdings,zapf dingbats",
            content_style: "@import url('https://fonts.googleapis.com/css2?family=Barlow&display=swap'); body { font-family: Barlow; }",
        });
    });
</script>
<script>
    function pdfgenrate(reportID) {
        $(".loader").show();
        var totalPage1 = <?php echo (json_encode($pages)); ?>;
        for (var gj = 0; gj < totalPage1.length; gj++) {
            var id = totalPage1[gj].page;
            // console.log(id);
            $('#content-' + id).show();
        }
        var entirePage = document.getElementById('entirePage').innerHTML;
        // entirePage = entirePage.replace(/<\/?span[^>]*>/g, "");
        var child_contact_email = document.getElementById('child_contact_email').value;
        var enrollment_id = document.getElementById('enrollment_id').value;
        $("#submitbutton").addClass("disable-click");
        $.ajax({
            url: "{{ url('/report/assessment/generatePDF') }}",
            type: 'POST',
            data: {
                'reportID': reportID,
                'entirePage': entirePage,
                'child_contact_email': child_contact_email,
                'enrollment_id': enrollment_id,
                _token: '{{csrf_token()}}'
            }
        }).done(function(data) {
            // console.log(data);
            for (var gj = 1; gj < totalPage1.length; gj++) {
                var id = totalPage1[gj].page;
                // console.log(id);
                $('#content-' + id).hide();
            }
            $(".loader").hide();
            // swal.fire("Success", "Report Sent Successfully", "success");
            swal.fire("Success", "Recommendation Report Sent Successfully", "success").then(function() {
                window.location = "/report/recommendationreport";
            });
        })
    }
</script>
<script>
    function discription_content() {
        document.getElementById('new_page').submit();
    }

    var counter = 1;
    var pages = <?php echo json_encode($pages); ?>;
    var totalPage = pages.length;

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
        $('#editbutton').removeAttr('href');
        var url = document.getElementById('routeUrl').value;
        url += '?' + $.param({
            currentPage: counter
        });
        $('#editbutton').attr('href', url);
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
        $('#editbutton').removeAttr('href');
        var url = document.getElementById('routeUrl').value;
        url += '?' + $.param({
            currentPage: counter
        });
        $('#editbutton').attr('href', url);

    });
</script>


@endsection