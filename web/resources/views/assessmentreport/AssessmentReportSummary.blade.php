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
      font-family: 'Barlow Semi Condensed', sans-serif !important;
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
      height: 2cm;
    }

    td>p {
      margin: 0;
    }

    .loader {
      position: fixed;
      left: 0px;
      top: 0px;
      width: 100%;
      height: 100%;
      z-index: 9999;
      background: url('/images/elinaloader.gif') 50% 50% no-repeat rgb(249, 249, 249);
    }

    p {
      line-height: 18px;
    }

    tr {
      page-break-inside: avoid;
      break-inside: avoid;
    }

    .page-break {
      page-break-before: always;
      break-before: page;
    }

    table {
      border-collapse: collapse;
      page-break-inside: auto;
      break-inside: auto;
    }

    thead {
      display: table-header-group;
    }

    tbody tr:first-child {
      page-break-inside: avoid;
      break-inside: avoid;
    }

    table {
      page-break-inside: auto;
      width: 100%;
    }

    thead {
      display: table-header-group;
    }

    tr {
      page-break-inside: avoid;
    }

    .page-break {
      page-break-before: always;
    }

    /* Table header styling for straight alignment */
    table {
      table-layout: fixed !important;
      width: 100% !important;
      border-collapse: collapse !important;
      border-bottom: 1px solid #0e0e0e !important;
    }

    th {
      text-align: center !important;
      vertical-align: middle !important;
      font-weight: 600 !important;
      padding: 8px 4px !important;
    }

    td {
      vertical-align: top !important;
      padding: 4px !important;
    }

    /* Ensure table headers stay with first row */
    table {
      page-break-inside: auto;
    }

    thead {
      display: table-header-group;
    }

    tbody tr {
      page-break-inside: avoid;
      page-break-after: auto;
    }

    /* For continuation rows */
    .continuation-row {
      page-break-before: avoid;
    }

    .continuation-row.page-break {
      page-break-before: always;
    }

    /* Ensure first row stays with header */
    tbody tr:first-child {
      page-break-before: avoid;
    }

    /* Ensure table headers behave correctly in PDF */
    thead {
      display: table-header-group;
    }

    /* Header must not be alone */
    thead tr {
      page-break-after: avoid;
      break-after: avoid;
    }

    /* First body row must stay with header */
    tbody tr:first-child {
      page-break-before: avoid;
      break-before: avoid;
      page-break-inside: avoid;
      break-inside: avoid;
    }

    /* JS-created continuation rows should never repeat headers */
    tbody tr {
      page-break-inside: auto;
    }

    /* Print styles and table continuation styling */
    * {
      -webkit-print-color-adjust: exact !important;
      color-adjust: exact !important;
      print-color-adjust: exact !important;
    }

    table {
      border-collapse: collapse;
      width: 100% !important;
      table-layout: fixed !important;
      page-break-inside: auto !important;
    }

    thead {
      display: table-header-group !important;
    }

    td,
    th {
      font-family: 'Barlow Semi Condensed', sans-serif !important;
      font-size: 14px !important;
      font-weight: 400 !important;
      line-height: 18px !important;
      letter-spacing: 0.3px !important;
      word-wrap: break-word !important;
      overflow-wrap: break-word !important;
      white-space: pre-line !important;
      padding: 4px !important;
      border: 1px solid #0e0e0e !important;
      vertical-align: top !important;
    }

    th {
      font-weight: 600 !important;
      background-color: #f2f2f2 !important;
    }

    /* Default continuation row styling */
    .continuation-row td:first-child,
    .continuation-row td:nth-child(2) {
      background-color: #f9f9f9 !important;
    }

    /* New page header rows should have white background */
    .continuation-row.new-page-header td:first-child,
    .continuation-row.new-page-header td:nth-child(2) {
      background-color: white !important;
      font-weight: 400 !important;
    }

    @media print {

      /* Force table headers on every page */
      thead {
        display: table-header-group !important;
      }

      /* Page breaks for new page headers */
      .continuation-row.new-page-header {
        page-break-before: always !important;
        break-before: page !important;
      }

      /* Regular continuation rows stay on same page */
      .continuation-row:not(.new-page-header) {
        page-break-inside: avoid !important;
        break-inside: avoid !important;
      }

      /* Keep rows together */
      tr {
        page-break-inside: avoid !important;
        break-inside: avoid !important;
      }

      /* Ensure table headers appear on all pages */
      table {
        page-break-inside: auto !important;
      }

      /* Background colors for print */
      th {
        background-color: #f2f2f2 !important;
        -webkit-print-color-adjust: exact !important;
      }

      .continuation-row td:first-child,
      .continuation-row td:nth-child(2) {
        background-color: #f9f9f9 !important;
        -webkit-print-color-adjust: exact !important;
      }

      .continuation-row.new-page-header td:first-child,
      .continuation-row.new-page-header td:nth-child(2) {
        background-color: white !important;
        -webkit-print-color-adjust: exact !important;
      }
    }

    /* Screen styles */
    table {
      border-collapse: collapse;
      width: 100%;
    }

    td,
    th {
      border: 1px solid #0e0e0e;
      padding: 4px;
      vertical-align: top;
    }

    th {
      background-color: #f2f2f2;
      font-weight: 600;
    }

    .continuation-row td:first-child,
    .continuation-row td:nth-child(2) {
      background-color: #f9f9f9;
    }

    .continuation-row.new-page-header td:first-child,
    .continuation-row.new-page-header td:nth-child(2) {
      background-color: white;
    }

    /* Fix for specific row styling - remove bold from "sit and stand" type rows */
    .table-bordered tbody tr td:first-child p {
      font-weight: 400 !important;
    }

    /* Make sure activity names are not bold unless specifically needed */
    td p {
      font-weight: 400 !important;
    }

    /* Exception for specific bold elements that should remain bold */
    .table-bordered thead th,
    .table-bordered tbody tr:first-child td:first-child p,
    .table-bordered tbody tr:first-child td p[style*="font-weight: bold"] {
      font-weight: 600 !important;
    }
  </style>
  <style>
    @media print {
      table {
        page-break-inside: auto !important;
      }

      thead {
        display: table-header-group !important;
      }

      tbody tr {
        page-break-inside: avoid !important;
        page-break-after: auto !important;
      }

      .continuation-row {
        page-break-inside: avoid !important;
      }
    }

    /* Ensure headers are properly aligned */
    table.assessment-table th {
      text-align: center !important;
      vertical-align: middle !important;
      font-weight: 600 !important;
      padding: 8px 4px !important;
      background-color: #ffc70b !important;
      border: 1px solid #040404 !important;
      font-family: 'Barlow Semi Condensed', sans-serif !important;
      color: #141414 !important;
    }

    /* Column alignment */
    table.assessment-table td:nth-child(1),
    table.assessment-table td:nth-child(2),
    table.assessment-table .continuation-row td:nth-child(1),
    table.assessment-table .continuation-row td:nth-child(2) {
      text-align: center !important;
      vertical-align: middle !important;
    }

    table.assessment-table td:nth-child(1),
    table.assessment-table th:nth-child(1) {
      width: 20% !important;
    }

    table.assessment-table td:nth-child(2),
    table.assessment-table th:nth-child(2) {
      width: 15% !important;
    }

    table.assessment-table td:nth-child(3),
    table.assessment-table th:nth-child(3) {
      width: 35% !important;
      vertical-align: top !important;
    }

    table.assessment-table td:nth-child(4),
    table.assessment-table th:nth-child(4) {
      width: 30% !important;
      vertical-align: top !important;
    }
  </style>
</head>

<body style="font-family: 'Barlow Semi Condensed', sans-serif !important;">
  <div class='loader'></div>
  <div id="report2">
    <p style="text-align: justify;font-family: 'Barlow Semi Condensed', sans-serif !important;font-size:14pt">Our functional assessment is based on the developmental domains and is designed to understand a child&rsquo;s profile and potential. While observing a child, many important facets of a child's development are revealed simultaneously and factors that may be impeding the child's overall performance are also identified. Developmental assessment observes how your child grows and changes over time and whether your child meets the typical developmental milestones in all the domains of development.</p>
    <table style="font-family: 'Barlow Semi Condensed', sans-serif !important;border-collapse: collapse; width: 100%; border: 1px solid rgb(0, 0, 0); margin-left: auto; margin-right: auto;" border="1">
      <colgroup>
        <col style="width: 5.02125%;">
        <col style="width: 44.9787%;">
        <col style="width: 50%;">
      </colgroup>
      <tbody>
        <tr>
          <td style="font-size:14pt;padding:4px;font-family: 'Barlow Semi Condensed', sans-serif !important;background-color: cornflowerblue;border-width: 1px; border-color: rgb(0, 0, 0);">&nbsp;</td>
          <td style="font-size:14pt;padding:4px;font-family: 'Barlow Semi Condensed', sans-serif !important;background-color: cornflowerblue;text-align: center; border-width: 1px; border-color: rgb(0, 0, 0);">Domains</td>
          <td style="font-size:14pt;padding:4px;font-family: 'Barlow Semi Condensed', sans-serif !important;background-color: cornflowerblue;text-align: center; border-width: 1px; border-color: rgb(0, 0, 0);">Description</td>
        </tr>
        <tr>
          <td style="font-size:14pt;padding:4px;font-family: 'Barlow Semi Condensed', sans-serif !important;text-align: center;border-width: 1px; border-color: rgb(0, 0, 0);">I</td>
          <td style="font-size:14pt;padding:4px;font-family: 'Barlow Semi Condensed', sans-serif !important;text-align: center; border-width: 1px; border-color: rgb(0, 0, 0);">Physical</td>
          <td style="font-size:14pt;padding:4px;font-family: 'Barlow Semi Condensed', sans-serif !important;border-width: 1px; border-color: rgb(0, 0, 0);">The physical domain covers the development of physical changes, which includes growing in size and strength, also includes body image, health and nutrition.</td>
        </tr>
        <tr>
          <td style="font-size:14pt;padding:4px;font-family: 'Barlow Semi Condensed', sans-serif !important;text-align: center;border-width: 1px; border-color: rgb(0, 0, 0);">II</td>
          <td style="font-size:14pt;padding:4px;font-family: 'Barlow Semi Condensed', sans-serif !important;text-align: center; border-width: 1px; border-color: rgb(0, 0, 0);">Motor</td>
          <td style="font-size:14pt;padding:4px;font-family: 'Barlow Semi Condensed', sans-serif !important;border-width: 1px; border-color: rgb(0, 0, 0);">Refers to elements related to gross motor, fine motor and bilateral coordination.</td>
        </tr>
        <tr>
          <td style="font-size:14pt;padding:4px;font-family: 'Barlow Semi Condensed', sans-serif !important;text-align: center;border-width: 1px; border-color: rgb(0, 0, 0);">III</td>
          <td style="font-size:14pt;padding:4px;font-family: 'Barlow Semi Condensed', sans-serif !important;text-align: center; border-width: 1px; border-color: rgb(0, 0, 0);">Sensory</td>
          <td style="font-size:14pt;padding:4px;font-family: 'Barlow Semi Condensed', sans-serif !important;border-width: 1px; border-color: rgb(0, 0, 0);">Assess children's sensory processing patterns with the Sensory Profile, adapted from the &nbsp;Pearsons Tools. This helps to understand a child's sensory processing patterns in everyday situations and profile the sensory system's effect on functional performance.&nbsp;</td>
        </tr>
        <tr>
          <td style="font-size:14pt;padding:4px;font-family: 'Barlow Semi Condensed', sans-serif !important;text-align: center;border-width: 1px; border-color: rgb(0, 0, 0);">IV</td>
          <td style="font-size:14pt;padding:4px;font-family: 'Barlow Semi Condensed', sans-serif !important;text-align: center; border-width: 1px; border-color: rgb(0, 0, 0);">Cognition</td>
          <td style="font-size:14pt;padding:4px;font-family: 'Barlow Semi Condensed', sans-serif !important;border-width: 1px; border-color: rgb(0, 0, 0);">The cognitive domain includes intellectual development and creativity.</td>
        </tr>
        <tr>
          <td style="font-size:14pt;padding:4px;font-family: 'Barlow Semi Condensed', sans-serif !important;text-align: center;border-width: 1px; border-color: rgb(0, 0, 0);">V</td>
          <td style="font-size:14pt;padding:4px;font-family: 'Barlow Semi Condensed', sans-serif !important;text-align: center; border-width: 1px; border-color: rgb(0, 0, 0);">Social &amp; Emotional</td>
          <td style="font-size:14pt;padding:4px;font-family: 'Barlow Semi Condensed', sans-serif !important;border-width: 1px; border-color: rgb(0, 0, 0);">The social-emotional domain includes a child's growing understanding and control of their emotions and participation in varied social domains.</td>
        </tr>
        <tr>
          <td style="font-size:14pt;padding:4px;font-family: 'Barlow Semi Condensed', sans-serif !important;text-align: center;border-width: 1px; border-color: rgb(0, 0, 0);">VI</td>
          <td style="font-size:14pt;padding:4px;font-family: 'Barlow Semi Condensed', sans-serif !important;text-align: center; border-width: 1px; border-color: rgb(0, 0, 0);">Speech and Communication</td>
          <td style="font-size:14pt;padding:4px;font-family: 'Barlow Semi Condensed', sans-serif !important;border-width: 1px; border-color: rgb(0, 0, 0);">Addresses the skills of listening and speaking. Understanding receptive and expressive communication.&nbsp;</td>
        </tr>
        <tr>
          <td style="font-size:14pt;padding:4px;font-family: 'Barlow Semi Condensed', sans-serif !important;text-align: center;border-width: 1px; border-color: rgb(0, 0, 0);">VII</td>
          <td style="font-size:14pt;padding:4px;font-family: 'Barlow Semi Condensed', sans-serif !important;text-align: center; border-width: 1px; border-color: rgb(0, 0, 0);">Play</td>
          <td style="font-size:14pt;padding:4px;font-family: 'Barlow Semi Condensed', sans-serif !important;border-width: 1px; border-color: rgb(0, 0, 0);">The observation and assessment of play, physical play and social skills through play.</td>
        </tr>
        <tr>
          <td style="font-size:14pt;padding:4px;font-family: 'Barlow Semi Condensed', sans-serif !important;text-align: center;border-width: 1px; border-color: rgb(0, 0, 0);">VIII</td>
          <td style="font-size:14pt;padding:4px;font-family: 'Barlow Semi Condensed', sans-serif !important;text-align: center; border-width: 1px; border-color: rgb(0, 0, 0);">ADLs</td>
          <td style="font-size:14pt;padding:4px;font-family: 'Barlow Semi Condensed', sans-serif !important;border-width: 1px; border-color: rgb(0, 0, 0);">The activities of daily living are those skills required to manage one's basic physical needs, including personal hygiene or grooming, dressing, toileting, transferring and eating.</td>
        </tr>
      </tbody>
    </table>
    <p style="page-break-after: always"></p>
    <p style="font-size:14pt;padding:4px;font-family: 'Barlow Semi Condensed', sans-serif !important;text-align: justify;">Within each of these domains, there are a variety of skill set areas that can further define specific areas of child development and learning.</p>
    <table style="border-collapse: collapse; width: 99.9757%; height: 254.583px; border: 1px solid rgb(0, 0, 0); margin-left: auto; margin-right: auto;" border="1">
      <colgroup>
        <col style="width: 15.7933%;">
        <col style="width: 13.8923%;">
        <col style="width: 17.475%;">
        <col style="width: 20.2495%;">
        <col style="width: 18.8682%;">
        <col style="width: 13.746%;">
      </colgroup>
      <tbody>
        <tr style="height: 19.5833px;">
          <td style="font-size:14pt;padding:4px;font-family: 'Barlow Semi Condensed', sans-serif !important;background-color: cornflowerblue;height: 19.5833px; text-align: center; border-width: 1px; border-color: rgb(0, 0, 0);">Needs major support</td>
          <td style="font-size:14pt;padding:4px;font-family: 'Barlow Semi Condensed', sans-serif !important;background-color: cornflowerblue;height: 19.5833px; text-align: center; border-width: 1px; border-color: rgb(0, 0, 0);">Emerging</td>
          <td style="font-size:14pt;padding:4px;font-family: 'Barlow Semi Condensed', sans-serif !important;background-color: cornflowerblue;height: 19.5833px; text-align: center; border-width: 1px; border-color: rgb(0, 0, 0);">Developing</td>
          <td style="font-size:14pt;padding:4px;font-family: 'Barlow Semi Condensed', sans-serif !important;background-color: cornflowerblue;height: 19.5833px; text-align: center; border-width: 1px; border-color: rgb(0, 0, 0);">Meeting</td>
          <td style="font-size:14pt;padding:4px;font-family: 'Barlow Semi Condensed', sans-serif !important;background-color: cornflowerblue;height: 19.5833px; text-align: center; border-width: 1px; border-color: rgb(0, 0, 0);">Exceeds expectation</td>
          <td style="font-size:14pt;padding:4px;font-family: 'Barlow Semi Condensed', sans-serif !important;background-color: cornflowerblue;height: 19.5833px; text-align: center; border-width: 1px; border-color: rgb(0, 0, 0);">Unable to observe clearly</td>
        </tr>
        <tr style="height: 39.1667px;">
          <td style="font-size:14pt;padding:4px;font-family: 'Barlow Semi Condensed', sans-serif !important;height: 39.1667px; border-width: 1px; border-color: rgb(0, 0, 0);">Child refuses to recognise/attempt the skill</td>
          <td style="font-size:14pt;padding:4px;font-family: 'Barlow Semi Condensed', sans-serif !important;height: 39.1667px; border-width: 1px; border-color: rgb(0, 0, 0);">The child has been taught this skill</td>
          <td style="font-size:14pt;padding:4px;font-family: 'Barlow Semi Condensed', sans-serif !important;height: 39.1667px; border-width: 1px; border-color: rgb(0, 0, 0);">Able to revisit previous knowledge or skill</td>
          <td style="font-size:14pt;padding:4px;font-family: 'Barlow Semi Condensed', sans-serif !important;height: 39.1667px; border-width: 1px; border-color: rgb(0, 0, 0);">Showing a strong evidence of deep understanding</td>
          <td style="font-size:14pt;padding:4px;font-family: 'Barlow Semi Condensed', sans-serif !important;height: 39.1667px; border-width: 1px; border-color: rgb(0, 0, 0);">Demonstrates an exceptional level of performance</td>
          <td style="font-size:14pt;padding:4px;font-family: 'Barlow Semi Condensed', sans-serif !important;height: 39.1667px; border-width: 1px; border-color: rgb(0, 0, 0);">No / limited scope for observation</td>
        </tr>
        <tr style="height: 58.75px;">
          <td style="font-size:14pt;padding:4px;font-family: 'Barlow Semi Condensed', sans-serif !important;height: 58.75px; border-width: 1px; border-color: rgb(0, 0, 0);">The child does not meet even the minimum expectations in results</td>
          <td style="font-size:14pt;padding:4px;font-family: 'Barlow Semi Condensed', sans-serif !important;height: 58.75px; border-width: 1px; border-color: rgb(0, 0, 0);">Been given opportunities to develop</td>
          <td style="font-size:14pt;padding:4px;font-family: 'Barlow Semi Condensed', sans-serif !important;height: 58.75px; border-width: 1px; border-color: rgb(0, 0, 0);">Been given opportunities to practise the skills</td>
          <td style="font-size:14pt;padding:4px;font-family: 'Barlow Semi Condensed', sans-serif !important;height: 58.75px; border-width: 1px; border-color: rgb(0, 0, 0);">Able to apply the skill without prompting</td>
          <td style="font-size:14pt;padding:4px;font-family: 'Barlow Semi Condensed', sans-serif !important;height: 58.75px; border-width: 1px; border-color: rgb(0, 0, 0);">Consistent&nbsp;</td>
          <td style="font-size:14pt;padding:4px;font-family: 'Barlow Semi Condensed', sans-serif !important;height: 58.75px; border-width: 1px; border-color: rgb(0, 0, 0);">Activity video is too short to get an understanding</td>
        </tr>
        <tr style="height: 58.75px;">
          <td style="font-size:14pt;padding:4px;font-family: 'Barlow Semi Condensed', sans-serif !important;height: 58.75px; border-width: 1px; border-color: rgb(0, 0, 0);">Significant improvement is needed in the skills area</td>
          <td style="font-size:14pt;padding:4px;font-family: 'Barlow Semi Condensed', sans-serif !important;height: 58.75px; border-width: 1px; border-color: rgb(0, 0, 0);">Being supported by an adult&nbsp;</td>
          <td style="font-size:14pt;padding:4px;font-family: 'Barlow Semi Condensed', sans-serif !important;height: 58.75px; border-width: 1px; border-color: rgb(0, 0, 0);">Shows an increasing understanding</td>
          <td style="font-size:14pt;padding:4px;font-family: 'Barlow Semi Condensed', sans-serif !important;height: 58.75px; border-width: 1px; border-color: rgb(0, 0, 0);">Consistently be able to apply independently</td>
          <td style="font-size:14pt;padding:4px;font-family: 'Barlow Semi Condensed', sans-serif !important;height: 58.75px; border-width: 1px; border-color: rgb(0, 0, 0);">Exceptional mastery</td>
          <td style="font-size:14pt;padding:4px;font-family: 'Barlow Semi Condensed', sans-serif !important;height: 58.75px; border-width: 1px; border-color: rgb(0, 0, 0);">The video is edited or support being given outside the area of video</td>
        </tr>
        <tr style="height: 39.1667px;">
          <td style="font-size:14pt;padding:4px;font-family: 'Barlow Semi Condensed', sans-serif !important;height: 39.1667px; border-width: 1px; border-color: rgb(0, 0, 0);">&nbsp;</td>
          <td style="font-size:14pt;padding:4px;font-family: 'Barlow Semi Condensed', sans-serif !important;height: 39.1667px; border-width: 1px; border-color: rgb(0, 0, 0);">Is at the early stages of acquisition of this skill</td>
          <td style="font-size:14pt;padding:4px;font-family: 'Barlow Semi Condensed', sans-serif !important;height: 39.1667px; border-width: 1px; border-color: rgb(0, 0, 0);">Frequently is able to apply independently</td>
          <td style="font-size:14pt;padding:4px;font-family: 'Barlow Semi Condensed', sans-serif !important;height: 39.1667px; border-width: 1px; border-color: rgb(0, 0, 0);">&nbsp;</td>
          <td style="font-size:14pt;padding:4px;font-family: 'Barlow Semi Condensed', sans-serif !important;height: 39.1667px; border-width: 1px; border-color: rgb(0, 0, 0);">Able to extend to higher level concepts using the skill being assessed for</td>
          <td style="font-size:14pt;padding:4px;font-family: 'Barlow Semi Condensed', sans-serif !important;height: 39.1667px; border-width: 1px; border-color: rgb(0, 0, 0);">&nbsp;</td>
        </tr>
        <tr style="height: 39.1667px;">
          <td style="font-size:14pt;padding:4px;font-family: 'Barlow Semi Condensed', sans-serif !important;height: 39.1667px; border-width: 1px; border-color: rgb(0, 0, 0);">&nbsp;</td>
          <td style="font-size:14pt;padding:4px;font-family: 'Barlow Semi Condensed', sans-serif !important;height: 39.1667px; border-width: 1px; border-color: rgb(0, 0, 0);">Occasionally is able to apply the skill independently</td>
          <td style="font-size:14pt;padding:4px;font-family: 'Barlow Semi Condensed', sans-serif !important;height: 39.1667px; border-width: 1px; border-color: rgb(0, 0, 0);">Comprehends the skill but is unable to fully complete the skill</td>
          <td style="font-size:14pt;padding:4px;font-family: 'Barlow Semi Condensed', sans-serif !important;height: 39.1667px; border-width: 1px; border-color: rgb(0, 0, 0);">&nbsp;</td>
          <td style="font-size:14pt;padding:4px;font-family: 'Barlow Semi Condensed', sans-serif !important;height: 39.1667px; border-width: 1px; border-color: rgb(0, 0, 0);">&nbsp;</td>
          <td style="font-size:14pt;padding:4px;font-family: 'Barlow Semi Condensed', sans-serif !important;height: 39.1667px; border-width: 1px; border-color: rgb(0, 0, 0);">&nbsp;</td>
        </tr>
      </tbody>
    </table>
    <p style="page-break-after: always"></p>
    <div class="content view2">
      <div class="page">
        @foreach($pages as $page)
        @if($page['page'] != 15)
        @if($page['enable_flag'] == 0)
        @if($page['assessment_skill'] != null && $page['enable_flag'] != 1)
        <p style="font-size: 22px;color:blue;font-weight:bold;font-family: 'Barlow Semi Condensed', sans-serif !important;">{{$page['tab_name']}}</p>
        @foreach($perskill as $perskills)
        @if($perskills['performance_area_id'] == $page['assessment_skill'] && $perskills['skill_type'] == 1)
        <div id="table{{$page['page']}}">
          <div class="table-responsive" style="font-family: 'Barlow Semi Condensed', sans-serif !important;">
            <table class="table table-bordered card-body" style="width: 100%;border-spacing: 0px;border-collapse: collapse;">
              <thead>
                <tr>
                  @if($perskills['skill_name'] != null || $perskills['skill_name'] != '')
                  <th width="20%" style="padding:4px !important;background-color:#ffc70b !important;font-weight:bold !important;font-family: 'Barlow Semi Condensed', sans-serif !important;text-align:center;border: 1px solid #040404 !important;color: #141414;border-collapse: collapse !important;">{{$perskills['skill_name']}}</th>
                  @else
                  <th width="20%" style="padding:4px !important;background-color:#ffc70b !important;font-weight:bold !important;font-family: 'Barlow Semi Condensed', sans-serif !important;text-align:center;border: 1px solid #040404 !important;color: #141414;border-collapse: collapse !important;">{{$page['tab_name']}}</th>
                  @endif
                  <th width="15%" style="padding:4px !important;background-color:#ffc70b !important;font-weight:bold !important;font-family: 'Barlow Semi Condensed', sans-serif !important;text-align:center;border: 1px solid #040404 !important;color: #141414;border-collapse: collapse !important;">
                    Observation</th>
                  <th width="35%" style="padding:4px !important;background-color:#ffc70b !important;font-family: 'Barlow Semi Condensed', sans-serif !important;text-align:center;border: 1px solid #040404 !important;color: #141414;border-collapse: collapse !important;">
                    Evidence</th>
                  <th width="30%" style="padding:4px !important;background-color:#ffc70b !important;font-family: 'Barlow Semi Condensed', sans-serif !important;text-align:center;border: 1px solid #040404 !important;color: #141414;border-collapse: collapse !important;">
                    Recommendation</th>
                </tr>
              </thead>
              @php
              $detailsCollection = collect($details);
              $rowCount = $detailsCollection->filter(fn($detail) => $page['assessment_skill'] == $detail['performance_area_id'])->count();
              $recommendationPrinted = false;
              @endphp
              <tbody id="tablebody{{$page['page']}}">
                @foreach($details as $detail)
                @if($page['assessment_skill'] == $detail['performance_area_id'])
                @if(!in_array($detail['activity_name'], $verifiedActivities))
                <tr>
                  <td width="20%" style="white-space: pre-line;background: white;border: 1px solid #0e0e0e !important;padding:4px !important;">@foreach($activitys as $activity) @if($page['assessment_skill'] == $activity['performance_area_id'] && $activity['skill_id'] == $perskills['skill_id'] ) @if($activity['skill_type'] == 1) @if( $detail['activity_name'] == $activity['activity_id'] ) <p>{{$activity['activity_name']}}</p> @endif @endif @endif @endforeach</td>
                  <td width="15%" style="background: white;border: 1px solid #0e0e0e !important;padding:4px !important;">@foreach($observations as $observation) @if( $detail['observation_name'] == $observation['observation_id'] ) <p>{{$observation['observation_name']}}</p> @endif @endforeach </td>
                  <td width="35%" style="white-space: pre-line;align-items: center;background: white;border: 1px solid #0e0e0e !important;font-family: 'Barlow Semi Condensed', sans-serif !important;padding:4px !important;">{!! $detail['evidence'] !!}</td>
                  <td width="30%" style="white-space: pre-line;align-items: center;background: white;border: 1px solid #0e0e0e !important;font-family: 'Barlow Semi Condensed', sans-serif !important;padding:4px !important;">
                    {!! $detail['recommendation'] !!}
                  </td>
                </tr>
                @endif
                @endif
                @endforeach
              </tbody>
            </table>
          </div>
        </div>
        <p style="page-break-after: always"></p>

        @elseif($perskills['performance_area_id'] == $page['assessment_skill'] && $perskills['skill_type'] == 2 && !in_array($perskills['skill_id'] , explode(',',$report['switch'])))
        <div class="myTableheader{{$page['page']}}" id="table_a{{$page['page']}}">
          <div class="table-responsive" style="font-family: 'Barlow Semi Condensed', sans-serif !important;">
            @php
            $detailsCollection = collect($details2);
            $filteredDetails = $detailsCollection->filter(fn($detail) => $page['assessment_skill'] == $detail['performance_area_id'] && $detail['cheSkill'] == $perskills['skill_id']);
            $rowCount = $filteredDetails->count();
            $recommendationPrinted = false;
            @endphp
            <table class="table table-bordered card-body myTable{{$page['page']}}" style="width: 100%;border-spacing: 0px;border-collapse: collapse;">
              <thead>
                <tr>
                  <th colspan="4" style="background-color:#ffc70b !important;font-family: 'Barlow Semi Condensed', sans-serif !important;text-align:center;color: #141414;text-align: left;border: 1px solid #040404 !important;border-collapse: collapse !important;">
                    {{$perskills['skill_name']}}
                  </th>
                </tr>
              </thead>
              <tbody id="tablebody_a{{$page['page']}}">
                @foreach($details2 as $detail)
                @if($page['assessment_skill'] == $detail['performance_area_id'] && $detail['cheSkill'] == $perskills['skill_id'])
                @if(!in_array($detail['activity_name'], $verifiedActivities))
                <tr>
                  <td width="20%" style="background: white;border: 1px solid #0e0e0e !important;padding:4px !important;"> @foreach($activitys as $activity) @if($activity['skill_type'] == 2) @if($page['assessment_skill'] == $activity['performance_area_id']) @if( $detail['activity_name'] == $activity['activity_id'] ) <p>{{$activity['activity_name']}}</p> @endif @endif @endif @endforeach </td>
                  <td width="15%" style="background: white;border: 1px solid #0e0e0e !important;padding:4px !important;"> @foreach($observations as $observation) @if( $detail['observation_name'] == $observation['observation_id'] ) <p>{{$observation['observation_name']}}</p> @endif @endforeach </td>
                  <td width="35%" style="white-space: pre-line;font-family: 'Barlow Semi Condensed', sans-serif !important;padding:4px !important;align-items: center !important;background: white !important;border: 1px solid #0e0e0e !important;"> {{$detail['evidence']}} </td>

                  <td width="30%" style="white-space: pre-line;align-items: center;background: white;border: 1px solid #0e0e0e !important;font-family: 'Barlow Semi Condensed', sans-serif !important;padding:4px !important;">
                    {{$detail['recommendation']}}
                  </td>

                </tr>
                @endif
                @endif
                @endforeach


              </tbody>
            </table>
          </div>
        </div>
        <p style="page-break-after: always"></p>

        @elseif($perskills['performance_area_id'] == $page['assessment_skill'] && $perskills['skill_type'] == 3 && !in_array($perskills['skill_id'] , explode(',',$report['switch'])))
        <!--  -->
        <div id="table{{$page['page']}}">
          <div class="table-responsive" style="font-family: 'Barlow Semi Condensed', sans-serif !important;">
            <table class="table table-bordered card-body" style="width: 100%;border-spacing: 0px;border-collapse: collapse;">
              <thead>
                <tr>
                  @if($perskills['skill_name'] != null || $perskills['skill_name'] != '')
                  <th width="20%" style="padding:4px !important;background-color:#ffc70b !important;font-family: 'Barlow Semi Condensed', sans-serif !important;text-align:center;border: 1px solid #040404 !important;color: #141414;border-collapse: collapse !important;">
                    {{$perskills['skill_name']}}
                  </th>
                  @else
                  <th width="20%" style="padding:4px !important;background-color:#ffc70b !important;border: 1px solid #040404 !important;color: #141414;border-collapse: collapse !important;font-family: 'Barlow Semi Condensed', sans-serif !important;text-align:center;">
                    {{$page['tab_name']}}
                  </th>
                  @endif
                  <th width="15%" style="padding:4px !important;background-color:#ffc70b !important;font-family: 'Barlow Semi Condensed', sans-serif !important;text-align:center;border: 1px solid #040404 !important;color: #141414;border-collapse: collapse !important;">
                    Observation</th>
                  <th width="35%" style="padding:4px !important;background-color:#ffc70b !important;font-family: 'Barlow Semi Condensed', sans-serif !important;border: 1px solid #040404 !important;color: #141414;border-collapse: collapse !important;">
                    Evidence</th>
                  <th width="30%" style="padding:4px !important;background-color:#ffc70b !important;font-family: 'Barlow Semi Condensed', sans-serif !important;border: 1px solid #040404 !important;color: #141414;border-collapse: collapse !important;">
                    Recommendation
                  </th>
                </tr>
              </thead>
            </table>
          </div>
        </div>

        @php $j= array() ; @endphp
        @foreach($subskill as $sskill)
        @if($page['assessment_skill'] == $sskill['performance_area_id'] && $sskill['primary_skill_id'] == $perskills['skill_id'] && !in_array($sskill['skill_id'] , explode(',',$report['switch2'])))
        @foreach($details3 as $detail)
        @if($detail['performance_area_id'] == $sskill['performance_area_id'])
        @php $fid = $detail['activity_name'] @endphp
        @if(!in_array( $fid , $j ))
        @php
        $f = 0;
        array_push($j, $detail['activity_name']);
        $recommendationPrinted = false;
        $recommendationCount = collect($details3)->filter(function($d) use ($sskill, $activitys) {
        return $d['performance_area_id'] == $sskill['performance_area_id'] &&
        in_array($d['activity_name'], collect($activitys)->where('sub_skill', $sskill['skill_id'])->pluck('activity_id')->toArray());
        })->count();
        @endphp
        <div class="table-responsive" id="table_b{{$sskill['skill_id']}}" style="font-family: 'Barlow Semi Condensed', sans-serif !important;">
          <table class="table table-bordered card-body" style="width: 100%;border-spacing: 0px;border-collapse: collapse;">
            <thead>
              <tr>
                <th colspan="4" style="background-color:#ffc70b !important;color: #141414;font-family: 'Barlow Semi Condensed', sans-serif !important;text-align:center;border: 1px solid #040404 !important;border-collapse: collapse !important;">
                  {{$sskill['skill_name']}}
                </th>
              </tr>
            </thead>
            <tbody id="tablebody_b{{$sskill['skill_id']}}">
              @foreach($details3 as $detail)
              @if(!in_array($detail['activity_name'], $verifiedActivities))
              @php $looppasstab3 = 0 @endphp
              @foreach($activitys as $activity)
              @if($sskill['skill_id'] == $activity['sub_skill'])
              @if( $detail['activity_name'] == $activity['activity_id'] )
              @php $looppasstab3 = 1 @endphp
              @endif
              @endif
              @endforeach
              @if($looppasstab3 == 1)
              <tr class="firstrow">
                <td width="20%" style="background: white;border: 1px solid #0e0e0e !important;padding:4px !important;"> @foreach($activitys as $activity) @if( $detail['activity_name'] == $activity['activity_id'] ) @php $f = 1; @endphp <p>{{$activity['activity_name']}}</p> @endif @endforeach </td>
                <td width="15%" style="background: white;border: 1px solid #0e0e0e !important;padding:4px !important;"> @foreach($observations as $observation) @if( $detail['observation_name'] == $observation['observation_id'] ) <p>{{$observation['observation_name']}}</p> @endif @endforeach </td>
                <td width="35%" style="white-space: pre-line;font-family: 'Barlow Semi Condensed', sans-serif !important;padding:4px !important;align-items: center;background: white;border: 1px solid #0e0e0e !important;">{{$detail['evidence'] }}</td>

                <td width="30%" style="white-space: pre-line;font-family: 'Barlow Semi Condensed', sans-serif !important;padding:4px !important;align-items: center;background: white;border: 1px solid #0e0e0e !important;">
                  {{$detail['recommendation']}}
                </td>

              </tr>
              @endif
              @endif
              @endforeach
            </tbody>
          </table>
        </div>
        <p style="page-break-after: always"></p>
        @if($f = 1) @break @endif
        @endif
        @endif
        @endforeach
        @endif
        @endforeach
        <!--  -->
        @endif
        @endforeach
        @endif
        @endif
        @endif
        @endforeach
        <!-- Sensory -->
        <!-- <p style="page-break-after: always"></p> -->
        <p style="font-size: 22px;color:blue;font-weight:bold;font-family: 'Barlow Semi Condensed', sans-serif !important;margin: 0;">Sensory</p>
        <div>
          <p style="text-align: center;font-size:20px;font-weight:bold;margin: 0;">Sensory Profiling Quadrant:</p>
          Sensory processing refers to the brain's ability to organize, interpret and respond to information received from
          each of the senses. When interruption or disruption occurs in the processing of information from one or more of
          these areas, the ability to self-regulate and organize oneself may become compromised. {{$data['child_name']}} demonstrates a few
          signs and symptoms of sensory processing difficulty at this time.
          The sensory information is separated into 4 quadrants to determine how a child is reacting to various sensory
          inputs.
        </div>
        <!-- <img style="display: block;margin-right: auto;margin-left: 25%;width: 50%;height:70%" src="{{asset('images/Self regulation continuum.png')}}" width="550" height="900px"> -->
        <div class="col-12 scrollable fixTableHead title-padding" id="page8" style="margin-top: 5px;">
          <div class="table-responsive">
            <table class="table table-bordered card-body" style="width: 100%; border-spacing: 0; border-collapse: collapse;">
              <thead>
                <tr>
                  <th width="30%" style="border: 1px solid #040404 !important; background-color: #ffc70b; color: #141414; text-align: center;">
                    Quadrants
                  </th>
                  <th width="30%" style="border: 1px solid #040404 !important; background-color: #ffc70b; color: #141414; text-align: center;">
                    Evidence
                  </th>
                  <th width="30%" style="border: 1px solid #040404 !important; background-color: #ffc70b; color: #141414; text-align: center;">
                    Recommendations
                  </th>
                </tr>
              </thead>
              <tbody>
                @php
                $sensoryQuadrants = [
                1 => 'Seeks out and is attracted to a stimulating sensory environment',
                2 => 'Distressed by a stimulating sensory environment and attempts to leave the environment',
                3 => 'Sensitivity to stimuli, distractibility, discomfort with sensory stimuli',
                4 => 'Missing stimuli, responding slowly'
                ];
                @endphp

                @foreach($sensoryQuadrants as $index => $label)
                <tr>
                  <td style="border: 1px solid #040404 !important; background-color: white;">
                    {{ $label }}
                  </td>
                  <td style="border: 1px solid #0e0e0e !important; background-color: white;">
                    {!! $page8['sensory_profiling' . $index] !!}
                  </td>
                  <td id="quadrantSensory" style="border: 1px solid #0e0e0e !important; background-color: white;">
                    {!! $data['sensory_recommendation'][$index] !!}
                  </td>
                </tr>
                @endforeach
              </tbody>
            </table>
          </div>
        </div>
        <!-- <p style="page-break-after: always"></p> -->
        <!-- End Sensory -->
        <!-- Sign -->
        <div class="col-12 scrollable fixTableHead title-padding" id="page14" style="margin-top: 5px;">
          <div class="table-responsive">
            <table class="table table-bordered card-body" style="width: 100%;border-spacing: 0px;border-collapse: collapse;">
              <tbody>
                <tr>
                  <td id="signatureData" style="font-size:16pt;font-family: 'Barlow Condensed';padding:5px; background: white;vertical-align: initial;text-align:left">{!! $data['signature'][1] !!}
                  </td>
                  <td id="signatureData" style="font-size:16pt;font-family: 'Barlow Condensed';padding:5px; background: white;vertical-align: initial;text-align:left">{!! $data['signature'][2] !!}
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
        <!-- Sign End -->
      </div>
    </div>
  </div>
  <form method="post" action="{{ filter_var($data['isTemp'] ?? false, FILTER_VALIDATE_BOOLEAN) 
    ? route('assessment.report.SummaryReportSave', \Crypt::encrypt($data['report_id'])) 
    : route('assessment.report.render', \Crypt::encrypt($data['report_id'])) }}" id="submitForm">

    <input type="hidden" name="summary_report" id="summary_report">
    <input type="hidden" name="email" id="email" value="{{$data['email']}}">
    <input type="hidden" name="data" id="data" value="<?= \Crypt::encrypt($data) ?>">
  </form>
</body>
<script>
  const BARLOW_FONT_URL = 'https://fonts.googleapis.com/css2?family=Barlow+Semi+Condensed:wght@400;500;600&display=swap';
  document.addEventListener("DOMContentLoaded", function() {
    const LINE_HEIGHT = 18;
    const MAX_LINES = 18;
    const MAX_HEIGHT = LINE_HEIGHT * MAX_LINES;
    const FALLBACK_WIDTH = 500;
    const FONT_FAMILY = "'Barlow Semi Condensed', sans-serif";
    const FONT_SIZE = "14px";

    function isFontLoaded() {
      const span = document.createElement("span");
      span.style.fontFamily = "serif";
      span.style.fontSize = "72px";
      span.style.position = "absolute";
      span.style.visibility = "hidden";
      span.innerHTML = "MWMWMWMW";
      document.body.appendChild(span);
      const originalWidth = span.offsetWidth;

      span.style.fontFamily = FONT_FAMILY + ", serif";
      const newWidth = span.offsetWidth;
      document.body.removeChild(span);

      return originalWidth !== newWidth;
    }
 
    function getActualWidth(element) {
      if (element.offsetWidth > 0) return element.offsetWidth;

      const temp = document.createElement('div');
      temp.innerHTML = element.innerHTML;
      temp.style.cssText = window.getComputedStyle(element).cssText;
      temp.style.visibility = 'hidden';
      temp.style.position = 'absolute';
      temp.style.display = 'block';
      document.body.appendChild(temp);
      const width = temp.offsetWidth;
      document.body.removeChild(temp);
      return width || FALLBACK_WIDTH;
    }

    function measureHeight(html, width) {
      const div = document.createElement("div");
      div.innerHTML = html;
      div.style.cssText = `
        visibility: hidden;
        position: absolute;
        width: ${width}px;
        line-height: ${LINE_HEIGHT}px;
        font-family: ${FONT_FAMILY};
        font-size: ${FONT_SIZE};
        font-weight: 400;
        letter-spacing: 0.3px;
        padding: 4px;
        box-sizing: border-box;
        white-space: pre-line;
        word-wrap: break-word;
        overflow-wrap: break-word;
      `;
      document.body.appendChild(div);
      const height = div.offsetHeight;
      document.body.removeChild(div);
      return height;
    }

    function splitContentByHeight(html, width, maxHeight) {
      if (!html || html.trim() === '') {
        return ['', ''];
      }

      const temp = document.createElement("div");
      temp.innerHTML = html;
      const originalText = temp.textContent || temp.innerText;
      const cleanedText = originalText.replace(/\s+/g, ' ').trim();
      if (!cleanedText) return ['', ''];

      const words = cleanedText.split(' ');
      let visibleText = '';
      let overflowText = '';

      const tester = document.createElement("div");
      tester.style.cssText = `
        visibility: hidden;
        position: absolute;
        width: ${width}px;
        line-height: ${LINE_HEIGHT}px;
        font-family: ${FONT_FAMILY};
        font-size: ${FONT_SIZE};
        font-weight: 400;
        padding: 4px;
        box-sizing: border-box;
        letter-spacing: 0.3px;
        white-space: pre-line;
        word-wrap: break-word;
        overflow-wrap: break-word;
      `;
      document.body.appendChild(tester);

      for (let i = 0; i < words.length; i++) {
        const testText = visibleText ? visibleText + ' ' + words[i] : words[i];
        tester.textContent = testText;

        if (tester.offsetHeight <= maxHeight) {
          visibleText = testText;
        } else {
          overflowText = words.slice(i).join(' ');
          break;
        }
      }

      document.body.removeChild(tester);

      if (!overflowText) {
        return [cleanedText, ''];
      }
      if (!visibleText && words.length > 0) {
        visibleText = words[0];
        overflowText = words.slice(1).join(' ');
      }

      return [visibleText, overflowText];
    }
    if (!isFontLoaded()) {
      const fontLink = document.createElement('link');
      fontLink.href = BARLOW_FONT_URL;
      fontLink.rel = 'stylesheet';
      document.head.appendChild(fontLink);

      setTimeout(processTables, 300);
    } else {
      processTables();
    }

    function processTables() {
      document.querySelectorAll("table").forEach((table, tableIndex) => {
        table.style.tableLayout = "fixed";
        table.style.width = "100%";
        table.style.borderCollapse = "collapse";

        const thead = table.querySelector("thead");
        if (thead) {
          const headerRow = thead.querySelector("tr");
          if (headerRow) {
            const headerCells = headerRow.querySelectorAll("th");
            headerCells.forEach((th, index) => {
              th.style.fontFamily = FONT_FAMILY;
              th.style.fontSize = FONT_SIZE;
              th.style.fontWeight = "600";
              th.style.letterSpacing = "0.3px";
              th.style.lineHeight = LINE_HEIGHT + "px";
              th.style.whiteSpace = "normal";
              th.style.textAlign = "center";
              th.style.verticalAlign = "middle";
              th.style.padding = "8px 4px";
              th.style.boxSizing = "border-box";

              if (table.classList.contains("assessment-table")) {
                if (index === 0) th.style.width = "20%";
                else if (index === 1) th.style.width = "15%";
                else if (index === 2) th.style.width = "35%";
                else if (index === 3) th.style.width = "30%";
              }
            });
          }
        }

        const tbody = table.querySelector("tbody");
        if (tbody) {
          const bodyRows = tbody.querySelectorAll("tr");
          bodyRows.forEach(row => {
            const cells = row.querySelectorAll("td");
            cells.forEach((td, index) => {
              td.style.fontFamily = FONT_FAMILY;
              td.style.fontSize = FONT_SIZE;
              td.style.fontWeight = "400";
              td.style.letterSpacing = "0.3px";
              td.style.lineHeight = LINE_HEIGHT + "px";
              td.style.whiteSpace = "pre-line";
              td.style.wordWrap = "break-word";
              td.style.overflowWrap = "break-word";
              td.style.padding = "4px";
              td.style.boxSizing = "border-box";


              if (index === 0 || index === 1) {
                td.style.textAlign = "center";
                td.style.verticalAlign = "middle";
              } else {
                td.style.verticalAlign = "top";
              }

              if (table.classList.contains("assessment-table")) {
                if (index === 0) td.style.width = "20%";
                else if (index === 1) td.style.width = "15%";
                else if (index === 2) td.style.width = "35%";
                else if (index === 3) td.style.width = "30%";
              }
            });
          });
        }
      });
      const MAX_HEIGHT = 14 * LINE_HEIGHT;

      document.querySelectorAll("table").forEach((table, tableIndex) => {
        const tbody = table.querySelector("tbody");
        if (!tbody) return;

        const thead = table.querySelector("thead");
        if (thead) {
          thead.querySelectorAll("th, td").forEach(cell => {
            cell.style.border = "1px solid #0e0e0e";
          });
        }

        const rows = Array.from(tbody.querySelectorAll("tr"));
        let preMergedRows = [];
        let lastMainRow = null;

        rows.forEach(row => {
          if (row.closest('thead') || row.children.length < 4) {
            preMergedRows.push(row);
            lastMainRow = null;
            return;
          }

          if (lastMainRow && 
              row.cells[0].innerText.trim() === lastMainRow.cells[0].innerText.trim() && 
              row.cells[1].innerText.trim() === lastMainRow.cells[1].innerText.trim() &&
              row.cells[0].innerText.trim() !== "") {
            
            lastMainRow.cells[2].innerHTML += "<br>" + row.cells[2].innerHTML;
            lastMainRow.cells[3].innerHTML += "<br>" + row.cells[3].innerHTML;
          } else {
            preMergedRows.push(row);
            lastMainRow = row;
          }
        });

        let processedRows = [];

        preMergedRows.forEach((row, rowIndex) => {
          if (row.closest('thead') || row.children.length < 4) {
            processedRows.push(row);
            return;
          }

          const cells = Array.from(row.children);
          const originalContent = {
            activity: cells[0].innerHTML,
            observation: cells[1].innerHTML,
            evidence: cells[2].innerHTML,
            recommendation: cells[3].innerHTML
          };

          const getCellWidth = (cell) => {
            const computedStyle = window.getComputedStyle(cell);
            return parseInt(computedStyle.width) || cell.offsetWidth || FALLBACK_WIDTH;
          };

          const evidenceWidth = getCellWidth(cells[2]);
          const recommendationWidth = getCellWidth(cells[3]);
          const effectiveEvidenceWidth = Math.max(evidenceWidth - 12, 50);
          const effectiveRecommendationWidth = Math.max(recommendationWidth - 12, 50);

          const evidenceHeight = measureHeight(originalContent.evidence, effectiveEvidenceWidth);
          const recommendationHeight = measureHeight(originalContent.recommendation, effectiveRecommendationWidth);

          const needsEvidenceSplit = evidenceHeight > MAX_HEIGHT;
          const needsRecommendationSplit = recommendationHeight > MAX_HEIGHT;

          if (!needsEvidenceSplit && !needsRecommendationSplit) {
            processedRows.push(row);
            return;
          }

          const evidenceSplits = needsEvidenceSplit ?
            splitContentByHeight(originalContent.evidence, effectiveEvidenceWidth, MAX_HEIGHT) : [originalContent.evidence, ''];
          const recommendationSplits = needsRecommendationSplit ?
            splitContentByHeight(originalContent.recommendation, effectiveRecommendationWidth, MAX_HEIGHT) : [originalContent.recommendation, ''];

          cells[2].innerHTML = evidenceSplits[0] || '';
          cells[3].innerHTML = recommendationSplits[0] || '';
          processedRows.push(row);

          let evidenceRemaining = evidenceSplits[1];
          let recommendationRemaining = recommendationSplits[1];
          let continuationCount = 0;

          while (evidenceRemaining || recommendationRemaining) {
            const newRow = document.createElement("tr");
            newRow.className = "continuation-row";

            for (let i = 0; i < 4; i++) {
              const newCell = document.createElement("td");
              newCell.style.border = "1px solid #0e0e0e";
              newCell.style.padding = "4px";
              newCell.style.boxSizing = "border-box";
              newCell.style.fontFamily = FONT_FAMILY;
              newCell.style.fontSize = FONT_SIZE;
              newCell.style.lineHeight = LINE_HEIGHT + "px";
              newCell.style.whiteSpace = "pre-line";
              newCell.style.wordWrap = "break-word";
              newCell.style.overflowWrap = "break-word";

              if (i === 0 || i === 1) {
                newCell.style.textAlign = "center";
                newCell.style.verticalAlign = "middle";
                newCell.innerHTML = ""; 
              } else {
                newCell.style.verticalAlign = "top";
                if (i === 2) {
                  const [nextPart, remaining] = splitContentByHeight(evidenceRemaining, effectiveEvidenceWidth, MAX_HEIGHT);
                  newCell.innerHTML = nextPart || '';
                  evidenceRemaining = remaining;
                } else {
                  const [nextPart, remaining] = splitContentByHeight(recommendationRemaining, effectiveRecommendationWidth, MAX_HEIGHT);
                  newCell.innerHTML = nextPart || '';
                  recommendationRemaining = remaining;
                }
              }

              newCell.style.borderTop = "none";
              if (processedRows.length > 0) {
                const prevRow = processedRows[processedRows.length - 1];
                if (prevRow.cells[i]) {
                  prevRow.cells[i].style.borderBottom = "none";
                }
              }

              newRow.appendChild(newCell);
            }

            newRow.dataset.originalRow = rowIndex;
            newRow.dataset.continuation = continuationCount;

            processedRows.push(newRow);
            continuationCount++;
          }
        });

        tbody.innerHTML = '';
        processedRows.forEach(row => {
          tbody.appendChild(row);
        });
      });

      const style = document.createElement('style');

      setTimeout(() => {
        const reportContent = document.getElementById("report2")?.innerHTML;
        if (reportContent && document.getElementById("summary_report")) {
          document.getElementById("summary_report").value = reportContent;

          const submitForm = document.getElementById("submitForm");
          if (submitForm) {
            submitForm.submit();
          }
        }
      }, 500);
    }
  });
</script>

</html>