<html>

<head>
<?php
    $barlowSemiReg = str_replace('\\', '/', storage_path('fonts/BarlowSemiCondensed-Regular.ttf'));
    $barlowSemiBold = str_replace('\\', '/', storage_path('fonts/BarlowSemiCondensed-Bold.ttf'));
    $barlowCondensedReg = str_replace('\\', '/', storage_path('fonts/BarlowCondensed-Regular.ttf'));
    $barlowCondensedBold = str_replace('\\', '/', storage_path('fonts/BarlowCondensed-Bold.ttf'));
    ?>
    <style>
        @font-face {
            font-family: 'Barlow Semi Condensed';
            font-style: normal;
            font-weight: 400;
            src: url('{{ $barlowSemiReg }}') format('truetype');
        }

        @font-face {
            font-family: 'Barlow Semi Condensed';
            font-style: normal;
            font-weight: 700;
            src: url('{{ $barlowSemiBold }}') format('truetype');
        }

        @font-face {
            font-family: 'Barlow Condensed';
            font-style: normal;
            font-weight: 400;
            src: url('{{ $barlowCondensedReg }}') format('truetype');
        }

        @font-face {
            font-family: 'Barlow Condensed';
            font-style: normal;
            font-weight: 700;
            src: url('{{ $barlowCondensedBold }}') format('truetype');
        }

    @page {
      margin: 0cm 0cm;
    }

    .flyleaf {
      page-break-after: always;
    }

    body {
      margin-top: 4cm;
      margin-left: 2cm;
      margin-right: 2cm;
      margin-bottom: 2cm;
      font-family: 'Barlow Semi Condensed', sans-serif;
    }

    header {
      position: fixed;
      top: 0cm;
      left: 0cm;
      right: 0cm;
      height: fit-content !important;
    }

    footer {
      position: fixed;
      bottom: 0cm;
      left: 0cm;
      right: 0cm;
      height: 2cm;
    }

    td>p {
      margin: 0;
    }
  </style>
</head>

<body style="font-family: 'Barlow Semi Condensed', sans-serif !important;">
  <div class="flyleaf">
    <header>
      <img src="C:\Apache24\htdocs\Elina ISMS\v1\web\public\images/report_header.JPG" alt="" style="width: 100%;" id="img_logo">
    </header>
    <img src="C:\Apache24\htdocs\Elina ISMS\v1\web\public\images/SAIL.png" alt="" style="display: block;margin-top:15%;margin-left: 8%;margin-right: auto;width: 85%;height:45%">
    <!-- <h6 style="text-align: center;font-size: 20px;">Child Name</h6> -->
    <h6 style="text-align: center;font-size: 20px;font-family: 'Barlow Condensed';">{{$data['child_name']}}</h6>
    <h6 style="float:left;font-size: 20px;font-family: 'Barlow Condensed';">Date of Birth<br>{{$data['child_dob']}}</h6>
    <h6 style="float:right;font-size: 20px;font-family: 'Barlow Condensed';">Date of Reporting<br>{{$data['dor']}}</h6>
    <footer>
      <img src="C:\Apache24\htdocs\Elina ISMS\v1\web\public\images/report_footer.JPG" alt="" style="width: 100%;">
    </footer>
  </div>

  <header>
    <img src="C:\Apache24\htdocs\Elina ISMS\v1\web\public\images/logo-2.png" alt="" style="width: 190px;float: right;margin: 50px 50px 0 0;" id="img_logo">
  </header>

  <footer>
    <img src="C:\Apache24\htdocs\Elina ISMS\v1\web\public\images/report_footer.JPG" alt="" style="width: 100%;">
  </footer>
  <!-- Direct Template -->
  <div class="content view1" id="report1">
    <div class="page">
      @foreach($data['pages'] as $page)
      @if($page['enable_flag'] == 0)
      <div class="tinymce-body" style="font-family: 'Barlow Condensed';">
        @if($page['page'] != 3 && $page['page'] != 4 && $page['page'] != 5 && $page['page'] != 6 && $page['page'] != 7 && $page['page'] != 8 && $page['page'] != 9 && $page['page'] != 10 && $page['page'] != 11)
        {!! $page['page_description'] !!}
        @if($page['page'] == 1)
        <img style="display: block; margin-left: auto; margin-right: auto;" src="{{Config::get('setting.base_url')}}images/assessment_image.png" width="566">
        @endif
        @endif
        <!--  -->
        @if($page['page'] == 3)
        <p style="font-family: 'Barlow Condensed';color: blue;font-weight:bold">1. CURRENT PERFORMANCE LEVEL IN 8 AREAS:</p>
        <div id="table">
          <div class="table-responsive" style="font-family: 'Barlow Semi Condensed', sans-serif;">
            <table class="table table-bordered card-body" style="width: 100%;border-spacing: 0px;border-collapse: collapse;">
              <tbody id="tablebody">
                @if($data['pages'][2]['enable_flag'] == 0)
                <tr>
                  <td width="30%" style="font-size:16pt;font-family: 'Barlow Condensed';padding:5px; background: white;border: 1px solid #0e0e0e !important;vertical-align: initial;text-align:center">Physical</td>
                  <td width="80%" style="padding:5px; background: white;border: 1px solid #0e0e0e !important;">@foreach($data['pages'] as $page)
                    @if($page['page'] == 3)
                    {!! $page['page_description'] !!}
                    @endif
                    @endforeach</td>
                </tr>
                @endif
                @if($data['pages'][3]['enable_flag'] == 0)
                <tr>
                  <td width="30%" style="font-size:16pt;font-family: 'Barlow Condensed';padding:5px; background: white;border: 1px solid #0e0e0e !important;vertical-align: initial;text-align:center">Gross Motor</td>
                  <td width="80%" style="padding:5px; background: white;border: 1px solid #0e0e0e !important;">@foreach($data['pages'] as $page)
                    @if($page['page'] == 4)
                    {!! $page['page_description'] !!}
                    @endif
                    @endforeach</td>
                </tr>
                @endif
                @if($data['pages'][4]['enable_flag'] == 0)
                <tr>
                  <td width="30%" style="font-size:16pt;font-family: 'Barlow Condensed';padding:5px; background: white;border: 1px solid #0e0e0e !important;vertical-align: initial;text-align:center">Fine Motor</td>
                  <td width="80%" style="padding:5px; background: white;border: 1px solid #0e0e0e !important;">@foreach($data['pages'] as $page)
                    @if($page['page'] == 5)
                    {!! $page['page_description'] !!}
                    @endif
                    @endforeach
                  </td>
                </tr>
                @endif
                @if($data['pages'][5]['enable_flag'] == 0)
                <tr>
                  <td width="30%" style="font-size:16pt;font-family: 'Barlow Condensed';padding:5px; background: white;border: 1px solid #0e0e0e !important;vertical-align: initial;text-align:center">Sensory</td>
                  <td width="80%" style="padding:5px; background: white;border: 1px solid #0e0e0e !important;">@foreach($data['pages'] as $page)
                    @if($page['page'] == 6)
                    {!! $page['page_description'] !!}
                    @endif
                    @endforeach</td>
                </tr>
                @endif
                @if($data['pages'][6]['enable_flag'] == 0)
                <tr>
                  <td width="30%" style="font-size:16pt;font-family: 'Barlow Condensed';padding:5px; background: white;border: 1px solid #0e0e0e !important;vertical-align: initial;text-align:center">Cognitive</td>
                  <td width="80%" style="padding:5px; background: white;border: 1px solid #0e0e0e !important;">@foreach($data['pages'] as $page)
                    @if($page['page'] == 7)
                    {!! $page['page_description'] !!}
                    @endif
                    @endforeach</td>
                </tr>
                @endif
                @if($data['pages'][7]['enable_flag'] == 0)
                <tr>
                  <td width="30%" style="font-size:16pt;font-family: 'Barlow Condensed';padding:5px; background: white;border: 1px solid #0e0e0e !important;vertical-align: initial;text-align:center">Speech and Communication</td>
                  <td width="80%" style="padding:5px; background: white;border: 1px solid #0e0e0e !important;">@foreach($data['pages'] as $page)
                    @if($page['page'] == 8)
                    {!! $page['page_description'] !!}
                    @endif
                    @endforeach</td>
                </tr>
                @endif
                @if($data['pages'][8]['enable_flag'] == 0)
                <tr>
                  <td width="30%" style="font-size:16pt;font-family: 'Barlow Condensed';padding:5px; background: white;border: 1px solid #0e0e0e !important;vertical-align: initial;text-align:center">Social and Emotional</td>
                  <td width="80%" style="padding:5px; background: white;border: 1px solid #0e0e0e !important;">@foreach($data['pages'] as $page)
                    @if($page['page'] == 9)
                    {!! $page['page_description'] !!}
                    @endif
                    @endforeach</td>
                </tr>
                @endif
                @if($data['pages'][9]['enable_flag'] == 0)
                <tr>
                  <td width="30%" style="font-size:16pt;font-family: 'Barlow Condensed';padding:5px; background: white;border: 1px solid #0e0e0e !important;vertical-align: initial;text-align:center">Play</td>
                  <td width="80%" style="padding:5px; background: white;border: 1px solid #0e0e0e !important;">@foreach($data['pages'] as $page)
                    @if($page['page'] == 10)
                    {!! $page['page_description'] !!}
                    @endif
                    @endforeach</td>
                </tr>
                @endif
                @if($data['pages'][10]['enable_flag'] == 0)
                <tr>
                  <td width="30%" style="font-size:16pt;font-family: 'Barlow Condensed';padding:5px; background: white;border: 1px solid #0e0e0e !important;vertical-align: initial;text-align:center">ADLs</td>
                  <td width="80%" style="padding:5px; background: white;border: 1px solid #0e0e0e !important;">@foreach($data['pages'] as $page)
                    @if($page['page'] == 11)
                    {!! $page['page_description'] !!}
                    @endif
                    @endforeach</td>
                </tr>
                @endif
              </tbody>
            </table>
          </div>
        </div>
        @endif
        <!--  -->
      </div>
      @endif
      @endforeach

    </div>
  </div>
  <!--  -->
  <style>
    body {
      font-family: 'Barlow Semi Condensed', sans-serif;
    }
  </style>
</body>

</html>