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
      size: legal landscape;
    }

    .flyleaf {
      page-break-after: always;
    }

    body {
      margin-top: 4cm;
      margin-left: 2cm;
      margin-right: 2cm;
      margin-bottom: 3cm;
      font-family: 'Barlow Semi Condensed', 'Barlow', Arial, sans-serif !important;
      font-size: 12pt;
      line-height: 1.4;
    }

    header {
      position: fixed;
      top: 0cm;
      left: 0cm;
      right: 0cm;
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
      padding: 2px 0;
    }

    /* Table splitting and rendering improvements for Dompdf */
    table {
      border-collapse: collapse !important;
      width: 100%;
      table-layout: auto;
      page-break-inside: auto;
      page-break-after: auto;
    }

    /* Ensure tables can break across pages */
    table.table-bordered {
      page-break-inside: auto;
    }

    thead {
      display: table-header-group;
    }

    tbody {
      display: table-row-group;
    }

    tr {
      page-break-inside: avoid;
      page-break-after: auto;
    }

    /* Allow table rows to split across pages when needed */
    tbody tr {
      page-break-inside: auto;
    }

    /* Allow cells to break when content is long - Dompdf limitation: cannot split rows, but can break cell content */
    td {
      word-wrap: break-word;
      overflow-wrap: break-word;
      hyphens: auto;
      page-break-inside: auto;
      overflow: visible;
    }

    /* For cells with long content (Evidence/Recommendation columns), explicitly allow breaking */
    td[style*="white-space: pre-line"],
    td[style*="white-space:pre-line"],
    td[width="30%"],
    td[width="35%"] {
      page-break-inside: auto;
      overflow: visible;
    }

    /* Allow paragraphs inside cells to break across pages */
    td p {
      page-break-inside: auto;
      orphans: 2;
      widows: 2;
    }

    /* Custom split tables - allow row and cell splitting */
    table.custom-split tbody tr {
      page-break-inside: auto;
    }

    table.custom-split tbody td {
      page-break-inside: auto;
      overflow: visible;
    }

    /* Custom split-1 tables - allow breaking for long content */
    table.custom-split-1 tbody tr {
      page-break-inside: auto;
    }

    table.custom-split-1 tbody td {
      page-break-inside: auto;
      overflow: visible;
    }

    /* Special handling for sensory table cells with long content */
    #page8 table.custom-split-1 tbody td {
      page-break-inside: auto;
      overflow: visible;
      height: auto;
      max-height: none;
    }

    #page8 table.custom-split-1 tbody td p {
      page-break-inside: auto;
      margin: 2px 0;
      padding: 2px 0;
      orphans: 1;
      widows: 1;
    }

    /* Force table rows to allow breaking when content is very long */
    #page8 table.custom-split-1 tbody tr {
      page-break-inside: auto;
      height: auto;
    }

    /* Ensure empty cells don't prevent breaking */
    #page8 table.custom-split-1 tbody td:empty {
      min-height: 0;
      height: auto;
    }

    /* Page break controls */
    .page-break {
      page-break-after: always;
    }

    .no-break {
      page-break-inside: avoid;
    }

    /* Improve text rendering */
    * {
      -webkit-font-smoothing: antialiased;
      text-rendering: optimizeLegibility;
    }

    /* Ensure proper spacing */
    p {
      margin: 4px 0;
      padding: 0;
    }
  </style>
</head>

<body style="font-family: 'Barlow Semi Condensed', 'Barlow', Arial, sans-serif !important;">
  <div class="flyleaf">
    <header>
      <img src="C:\Apache24\htdocs\Elina ISMS\v1\web\public\images/report_header-l.png" alt="" style="width: 100%;height:19%" id="img_logo">
    </header>
    <img src="C:\Apache24\htdocs\Elina ISMS\v1\web\public\images/SAIL.png" alt="" style="display: block;margin-left: 15%;margin-right: auto;width: 70%;height:80%">
    <br><br>
    <table style="width: 100%;">
      <tbody>
        <tr>
          <td style="font-weight:bold !important; width: 33%;font-size: 20px;text-align: center;">Date of Birth<br>{{$data['child_dob']}}</td>
          <td style="font-weight:bold !important; width: 34%;font-size: 20px;text-align: center;">{{$data['child_name']}}</td>
          <td style="font-weight:bold !important; width: 33%;font-size: 20px;text-align: center;">Date of Reporting<br>{{ date('d M Y', strtotime($data['dor'])) }}</td>
        </tr>
      </tbody>
    </table>
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
</body>

</html>