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
<div class="main-content">
    {{ Breadcrumbs::render('referralreport.show',$report[0]['report_id']) }}
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
        <input type="hidden" name="child_name" id="child_name" value="{{$report[0]['child_name']}}">
        <input type="hidden" name="enrollment_id" id="enrollment_id" value="{{$report[0]['enrollment_id']}}">
        <div id="entirePage">

            <div class="col-12">
                <div class="content">
                    <div class="page">
                        <div class="tinymce-body">{!! $report[0]['meeting_description'] !!}</div>
                        <div id="table">
                            <div class="table-responsive">
                                <table class="table table-bordered card-body" id="main" style="width: 100%;border-spacing: 0px;border-collapse: collapse;">
                                    <thead>
                                        <tr>
                                            <th width="20%" style="border: 1px solid #040404 !important;color: #141414;background-color: white !important;">Recommendation</th>
                                            <th style="border: 1px solid #040404 !important;color: #141414;background-color: white !important;">Area of focus</th>
                                            <th style="border: 1px solid #040404 !important;color: #141414;background-color: white !important;">Referral</th>
                                            <th style="border: 1px solid #040404 !important;color: #141414;background-color: white !important;">Frequency</th>
                                        </tr>
                                    </thead>
                                    <tbody id="tablebody">
                                        @php
                                        $ro = array();
                                        $ro1 = array();
                                        $ddc = 1;
                                        @endphp

                                        @foreach($recommendations as $data)
                                        @foreach($report as $row)
                                        @if($row['recommendation_area'] == $data['recomendation_id'])

                                        @php
                                        array_push($ro, $data['recomendation_id']);
                                        @endphp

                                        @endif
                                        @endforeach
                                        @endforeach


                                        @foreach($recommendations as $data)
                                        @foreach($report as $row)
                                        @if($row['recommendation_area'] == $data['recomendation_id'])

                                        @php
                                        $ro_counts = array_count_values($ro);
                                        $rowS = $ro_counts[$data['recomendation_id']];

                                        $rowS_1 = $data['recomendation_id'];

                                        @endphp

                                        @if (in_array($data['recomendation_id'], $ro1))
                                        <tr class="recommendation_row" data-is_clone="true">
                                            @else
                                        <tr class="recommendation_row">
                                            @endif


                                            @if (!in_array($data['recomendation_id'], $ro1))
                                            <td rowspan="{{$rowS}}" id="recommendation{{$data['recomendation_id']}}" style="background: white;border: 1px solid #0e0e0e !important;">
                                                {{$data['recommendation']}}
                                            </td>
                                            @php
                                            array_push($ro1, $data['recomendation_id']);
                                            @endphp
                                            @else
                                            @php
                                            $ddc++;
                                            $rowS_1 = $data['recomendation_id'] .'_'.$ddc ;
                                            @endphp
                                            @endif
                                            <td style="align-items: center;background: white;border: 1px solid #0e0e0e !important;">
                                                @foreach($specialization as $specialist)
                                                @if($row['focus_area'] == $specialist['id'])
                                                {{$specialist['specialization']}}
                                                @endif
                                                @endforeach
                                                @if($row['focus_area'] == '0')
                                                {{$row['focus_area_other']}}
                                                @endif
                                            </td>
                                            <td style="background: white;border: 1px solid #0e0e0e !important;">
                                                
                                                @foreach($serviceProviders as $provider)
                                                @if($provider['id'] == $row['referral_users'])
                                                    {{$provider['name']}} - {{$provider['phone_number']}}
                                                @endif
                                                @endforeach

                                                @if($row['referral_users'] == '0')
                                                    {{$row['referral_users_other']}}
                                                @endif
                                            </td>
                                            <td style="align-items: center;background: white;border: 1px solid #0e0e0e !important;white-space: pre-line;">{{$row['frequency']}}
                                            </td>
                                        </tr>
                                        @endif
                                        @endforeach
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>


    </div>
    <div class="col-md-12 text-center" style="padding: 10px;">
        <a type="button" class="btn btn-labeled back-btn" title="Cancel" href="{{ route('referralreport.index') }}" style="color:white !important">
            <span class="btn-label" style="font-size:13px !important;"><i class="fa fa-arrow-left"></i></span> Cancel</a>
        <a href="{{ route('referralreport.edit', \Crypt::encrypt($report[0]['report_id'])) }}" type="button" id="editbutton" class="btn btn-labeled btn-succes" title="Edit" style="background: orange !important; color:white !important">
            <span class="btn-label" style="font-size:13px !important;"><i class="fas fa-pencil-alt"></i></span> Edit </a>
        <a type="button" onclick="pdfgenrate('{{$report[0]['report_id']}}')" id="submitbutton" class="btn btn-labeled btn-succes" title="Submit" style="background: green !important; border-color:green !important; color:white !important">
            <span class="btn-label" style="font-size:13px !important;"><i class="fa fa-check"></i></span> Publish </a>
    </div>
</div>
@include('questionaireallocation13+.preview');


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
    });
</script>
<script>
    function pdfgenrate(reportID) {
        $(".loader").show();
        var entirePage = document.getElementById('entirePage').innerHTML;
        entirePage = entirePage.replace(/<\/?span[^>]*>/g, "");
        var child_contact_email = document.getElementById('child_contact_email').value;
        var childName = document.getElementById('child_name').value;
        var enrollment_id = document.getElementById('enrollment_id').value;
        $("#submitbutton").addClass("disable-click");
        $.ajax({
            url: "{{ url('/report/referral/generatePDF') }}",
            type: 'POST',
            data: {
                'reportID': reportID,
                'entirePage': entirePage,
                'child_contact_email': child_contact_email,
                'enrollment_id': enrollment_id,
                'childName': childName,
                _token: '{{csrf_token()}}'
            }
        }).done(function(data) {

            $(".loader").hide();
            // swal.fire("Success", "Report Sent Successfully", "success");
            swal.fire("Success", "Referral Report Sent Successfully", "success").then(function() {
                window.location.href = "{{route('referralreport.index')}}";
            });
        })
    }
</script>

@endsection