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
      margin-bottom: 3cm;
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
      height: 3cm;
    }
    td>p {
      margin: 0;
    }
  </style>
</head>

<body style="font-family: 'Barlow Semi Condensed', sans-serif !important;">
<header>
    <img src="C:\Apache24\htdocs\Elina ISMS\v1\web\public\images/report_header-l.png" alt="" style="width: 100%;height:17%" id="img_logo">
  </header>

  <footer>
    <img src="C:\Apache24\htdocs\Elina ISMS\v1\web\public\images/report_footer.JPG" alt="" style="width: 100%;">
  </footer>

  {!! $htmlContent !!}
</body>

</html>