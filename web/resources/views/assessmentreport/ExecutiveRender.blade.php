<html>

<head>
  <?php
  $barlowSemiReg = str_replace('\\','/', storage_path('fonts/BarlowSemiCondensed-Regular.ttf'));
  $barlowSemiBold = str_replace('\\','/', storage_path('fonts/BarlowSemiCondensed-Bold.ttf'));
  $barlowCondensedReg = str_replace('\\','/', storage_path('fonts/BarlowCondensed-Regular.ttf'));
  $barlowCondensedBold = str_replace('\\','/', storage_path('fonts/BarlowCondensed-Bold.ttf'));
  ?>
  <style>
    /* Embed Barlow fonts for Dompdf (use local TTFs) */
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
      <img src="C:\Apache24\htdocs\Elina ISMS\v1\web\public\images/report_header.png" alt="" style="width: 100%;" id="img_logo">
    </header>
    <img src="C:\Apache24\htdocs\Elina ISMS\v1\web\public\images/SAIL.png" alt="" style="display: block;margin-top:15%;margin-left: 0%;margin-right: 0%;height:45%;width:115%;">
    <!-- <h6 style="text-align: center;font-size: 20px;">Child Name</h6> -->
    <h6 style="text-align: center;font-size: 20px;font-family: 'Barlow Condensed';">{{$data['child_name']}}</h6>
    <h6 style="float:left;font-size: 20px;font-family: 'Barlow Condensed';">Date of Birth<br>{{$data['child_dob']}}</h6>
    <h6 style="float:right;font-size: 20px;font-family: 'Barlow Condensed';">Date of Reporting<br>{{ date('d M Y', strtotime($data['dor'])) }}</h6>
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
  {!! $htmlContent !!}
  <!--  -->
  <style>
    body {
      font-family: 'Barlow Semi Condensed', sans-serif;
    }
  </style>
</body>

</html>