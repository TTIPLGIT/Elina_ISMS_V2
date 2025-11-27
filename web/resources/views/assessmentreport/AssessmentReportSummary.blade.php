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
      font-family: Barlow !important;
    }

    header {
      position: fixed;
      top: 0cm;
      left: 0cm;
      right: 0cm;
      /* height: fit-content !important; */
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

    /* Fix table pagination issues in Dompdf */
    table {
      page-break-inside: auto !important;
      border-collapse: collapse;
      width: 100%;
    }

    thead {
      display: table-header-group;
      /* Repeat header on each page when table breaks */
      page-break-inside: avoid;
      page-break-after: avoid;
    }

    tbody {
      display: table-row-group;
      page-break-inside: auto !important;
    }

    /* Allow rows to break across pages when necessary */
    /* Dompdf will try to keep rows together, but will break if needed */
    tr {
      page-break-inside: avoid;
      page-break-after: auto;
    }

    /* For very tall rows with explicit height, allow breaking */
    tr[style*="height"] {
      page-break-inside: auto;
    }

    td, th {
      overflow: visible !important;
      word-wrap: break-word;
      /* Allow cells to break if content is too long - this works with row breaking */
      page-break-inside: auto;
    }

    /* Special handling for cells with long content - ensure they can break */
    td[style*="white-space"] {
      page-break-inside: auto !important;
    }

    /* Ensure table can break across pages */
    .table-responsive {
      page-break-inside: auto !important;
      overflow: visible !important;
    }

    .table-responsive table {
      page-break-inside: auto !important;
    }

    /* Ensure wrapper divs don't prevent breaks */
    div[id^="table"] {
      page-break-inside: auto !important;
    }

    div[class*="table"] {
      page-break-inside: auto !important;
    }

    /* Allow long content in cells to wrap and break */
    td {
      white-space: normal !important;
      overflow: visible !important;
    }

    /* Ensure table cells with pre-line can still break */
    td[style*="white-space: pre-line"] {
      white-space: pre-line !important;
      overflow: visible !important;
      page-break-inside: auto !important;
    }

    /* General pagination rules for all elements (not just tables) */
    /* Allow divs to break across pages */
    div {
      page-break-inside: auto;
    }

    /* Prevent breaking inside paragraphs, but allow after */
    p {
      page-break-inside: avoid;
      page-break-after: auto;
      orphans: 3;
      widows: 3;
    }

    /* Allow content sections to break */
    .content {
      page-break-inside: auto !important;
    }

    .page {
      page-break-inside: auto !important;
    }

    /* Allow scrollable and other container divs to break */
    .scrollable,
    .fixTableHead,
    .title-padding,
    .col-12 {
      page-break-inside: auto !important;
    }

    /* Ensure main content wrapper can break */
    #report2 {
      page-break-inside: auto !important;
    }

    /* Prevent breaking inside headings, but allow after */
    h1, h2, h3, h4, h5, h6 {
      page-break-after: avoid;
      page-break-inside: avoid;
    }

    /* Debug styling for tables with position data (optional - for development) */
    table[data-page-start] {
      /* Can add visual indicators based on position if needed */
    }

    table[data-available-space] {
      /* Table has position information stored */
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
  </style>
</head>

<body style="font-family: Barlow !important;">
  <div class='loader'></div>

  <!-- <header>
    <img src="C:\Apache24\htdocs\Elina ISMS\v1\web\public\images/logo-2.png" alt="" style="width: 190px;float: right;margin: 50px 50px 0 0;" id="img_logo">
  </header>

  <footer>
    <img src="C:\Apache24\htdocs\Elina ISMS\v1\web\public\images/report_footer.JPG" alt="" style="width: 100%;">
  </footer> -->
  <div id="report2">
    <p style="text-align: justify;font-family: Barlow !important;font-size:14pt">Our functional assessment is based on the developmental domains and is designed to understand a child&rsquo;s profile and potential. While observing a child, many important facets of a child's development are revealed simultaneously and factors that may be impeding the child's overall performance are also identified. Developmental assessment observes how your child grows and changes over time and whether your child meets the typical developmental milestones in all the domains of development.</p>
    <table style="font-family: Barlow !important;border-collapse: collapse; width: 100%; border: 1px solid rgb(0, 0, 0); margin-left: auto; margin-right: auto;" border="1">
      <colgroup>
        <col style="width: 5.02125%;">
        <col style="width: 44.9787%;">
        <col style="width: 50%;">
      </colgroup>
      <tbody>
        <tr>
          <td style="font-size:14pt;padding:4px;font-family: Barlow !important;background-color: cornflowerblue;border-width: 1px; border-color: rgb(0, 0, 0);">&nbsp;</td>
          <td style="font-size:14pt;padding:4px;font-family: Barlow !important;background-color: cornflowerblue;text-align: center; border-width: 1px; border-color: rgb(0, 0, 0);">Domains</td>
          <td style="font-size:14pt;padding:4px;font-family: Barlow !important;background-color: cornflowerblue;text-align: center; border-width: 1px; border-color: rgb(0, 0, 0);">Description</td>
        </tr>
        <tr>
          <td style="font-size:14pt;padding:4px;font-family: Barlow !important;text-align: center;border-width: 1px; border-color: rgb(0, 0, 0);">I</td>
          <td style="font-size:14pt;padding:4px;font-family: Barlow !important;text-align: center; border-width: 1px; border-color: rgb(0, 0, 0);">Physical</td>
          <td style="font-size:14pt;padding:4px;font-family: Barlow !important;border-width: 1px; border-color: rgb(0, 0, 0);">The physical domain covers the development of physical changes, which includes growing in size and strength, also includes body image, health and nutrition.</td>
        </tr>
        <tr>
          <td style="font-size:14pt;padding:4px;font-family: Barlow !important;text-align: center;border-width: 1px; border-color: rgb(0, 0, 0);">II</td>
          <td style="font-size:14pt;padding:4px;font-family: Barlow !important;text-align: center; border-width: 1px; border-color: rgb(0, 0, 0);">Motor</td>
          <td style="font-size:14pt;padding:4px;font-family: Barlow !important;border-width: 1px; border-color: rgb(0, 0, 0);">Refers to elements related to gross motor, fine motor and bilateral coordination.</td>
        </tr>
        <tr>
          <td style="font-size:14pt;padding:4px;font-family: Barlow !important;text-align: center;border-width: 1px; border-color: rgb(0, 0, 0);">III</td>
          <td style="font-size:14pt;padding:4px;font-family: Barlow !important;text-align: center; border-width: 1px; border-color: rgb(0, 0, 0);">Sensory</td>
          <td style="font-size:14pt;padding:4px;font-family: Barlow !important;font-family: Barlow !important;border-width: 1px; border-color: rgb(0, 0, 0);">Assess children's sensory processing patterns with the Sensory Profile, adapted from the &nbsp;Pearsons Tools. This helps to understand a child's sensory processing patterns in everyday situations and profile the sensory system's effect on functional performance.&nbsp;</td>
        </tr>
        <tr>
          <td style="font-size:14pt;padding:4px;font-family: Barlow !important;text-align: center;border-width: 1px; border-color: rgb(0, 0, 0);">IV</td>
          <td style="font-size:14pt;padding:4px;font-family: Barlow !important;text-align: center; border-width: 1px; border-color: rgb(0, 0, 0);">Cognition</td>
          <td style="font-size:14pt;padding:4px;font-family: Barlow !important;font-family: Barlow !important;border-width: 1px; border-color: rgb(0, 0, 0);">The cognitive domain includes intellectual development and creativity.</td>
        </tr>
        <tr>
          <td style="font-size:14pt;padding:4px;font-family: Barlow !important;text-align: center;border-width: 1px; border-color: rgb(0, 0, 0);">V</td>
          <td style="font-size:14pt;padding:4px;font-family: Barlow !important;text-align: center; border-width: 1px; border-color: rgb(0, 0, 0);">Social &amp; Emotional</td>
          <td style="font-size:14pt;padding:4px;font-family: Barlow !important;font-family: Barlow !important;border-width: 1px; border-color: rgb(0, 0, 0);">The social-emotional domain includes a child's growing understanding and control of their emotions and participation in varied social domains.</td>
        </tr>
        <tr>
          <td style="font-size:14pt;padding:4px;font-family: Barlow !important;text-align: center;border-width: 1px; border-color: rgb(0, 0, 0);">VI</td>
          <td style="font-size:14pt;padding:4px;font-family: Barlow !important;text-align: center; border-width: 1px; border-color: rgb(0, 0, 0);">Speech and Communication</td>
          <td style="font-size:14pt;padding:4px;font-family: Barlow !important;border-width: 1px; border-color: rgb(0, 0, 0);">Addresses the skills of listening and speaking. Understanding receptive and expressive communication.&nbsp;</td>
        </tr>
        <tr>
          <td style="font-size:14pt;padding:4px;font-family: Barlow !important;text-align: center;border-width: 1px; border-color: rgb(0, 0, 0);">VII</td>
          <td style="font-size:14pt;padding:4px;font-family: Barlow !important;text-align: center; border-width: 1px; border-color: rgb(0, 0, 0);">Play</td>
          <td style="font-size:14pt;padding:4px;font-family: Barlow !important;border-width: 1px; border-color: rgb(0, 0, 0);">The observation and assessment of play, physical play and social skills through play.</td>
        </tr>
        <tr>
          <td style="font-size:14pt;padding:4px;font-family: Barlow !important;text-align: center;border-width: 1px; border-color: rgb(0, 0, 0);">VIII</td>
          <td style="font-size:14pt;padding:4px;font-family: Barlow !important;text-align: center; border-width: 1px; border-color: rgb(0, 0, 0);">ADLs</td>
          <td style="font-size:14pt;padding:4px;font-family: Barlow !important;border-width: 1px; border-color: rgb(0, 0, 0);">The activities of daily living are those skills required to manage one's basic physical needs, including personal hygiene or grooming, dressing, toileting, transferring and eating.</td>
        </tr>
      </tbody>
    </table>
    <p style="page-break-after: always"></p>
    <p style="font-size:14pt;padding:4px;font-family: Barlow !important;text-align: justify;">Within each of these domains, there are a variety of skill set areas that can further define specific areas of child development and learning.</p>
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
          <td style="font-size:14pt;padding:4px;font-family: Barlow !important;background-color: cornflowerblue;height: 19.5833px; text-align: center; border-width: 1px; border-color: rgb(0, 0, 0);">Needs major support</td>
          <td style="font-size:14pt;padding:4px;font-family: Barlow !important;background-color: cornflowerblue;height: 19.5833px; text-align: center; border-width: 1px; border-color: rgb(0, 0, 0);">Emerging</td>
          <td style="font-size:14pt;padding:4px;font-family: Barlow !important;background-color: cornflowerblue;height: 19.5833px; text-align: center; border-width: 1px; border-color: rgb(0, 0, 0);">Developing</td>
          <td style="font-size:14pt;padding:4px;font-family: Barlow !important;background-color: cornflowerblue;height: 19.5833px; text-align: center; border-width: 1px; border-color: rgb(0, 0, 0);">Meeting</td>
          <td style="font-size:14pt;padding:4px;font-family: Barlow !important;background-color: cornflowerblue;height: 19.5833px; text-align: center; border-width: 1px; border-color: rgb(0, 0, 0);">Exceeds expectation</td>
          <td style="font-size:14pt;padding:4px;font-family: Barlow !important;background-color: cornflowerblue;height: 19.5833px; text-align: center; border-width: 1px; border-color: rgb(0, 0, 0);">Unable to observe clearly</td>
        </tr>
        <tr style="height: 39.1667px;">
          <td style="font-size:14pt;padding:4px;font-family: Barlow !important;height: 39.1667px; border-width: 1px; border-color: rgb(0, 0, 0);">Child refuses to recognise/attempt the skill</td>
          <td style="font-size:14pt;padding:4px;font-family: Barlow !important;height: 39.1667px; border-width: 1px; border-color: rgb(0, 0, 0);">The child has been taught this skill</td>
          <td style="font-size:14pt;padding:4px;font-family: Barlow !important;height: 39.1667px; border-width: 1px; border-color: rgb(0, 0, 0);">Able to revisit previous knowledge or skill</td>
          <td style="font-size:14pt;padding:4px;font-family: Barlow !important;height: 39.1667px; border-width: 1px; border-color: rgb(0, 0, 0);">Showing a strong evidence of deep understanding</td>
          <td style="font-size:14pt;padding:4px;font-family: Barlow !important;height: 39.1667px; border-width: 1px; border-color: rgb(0, 0, 0);">Demonstrates an exceptional level of performance</td>
          <td style="font-size:14pt;padding:4px;font-family: Barlow !important;height: 39.1667px; border-width: 1px; border-color: rgb(0, 0, 0);">No / limited scope for observation</td>
        </tr>
        <tr style="height: 58.75px;">
          <td style="font-size:14pt;padding:4px;font-family: Barlow !important;height: 58.75px; border-width: 1px; border-color: rgb(0, 0, 0);">The child does not meet even the minimum expectations in results</td>
          <td style="font-size:14pt;padding:4px;font-family: Barlow !important;height: 58.75px; border-width: 1px; border-color: rgb(0, 0, 0);">Been given opportunities to develop</td>
          <td style="font-size:14pt;padding:4px;font-family: Barlow !important;height: 58.75px; border-width: 1px; border-color: rgb(0, 0, 0);">Been given opportunities to practise the skills</td>
          <td style="font-size:14pt;padding:4px;font-family: Barlow !important;height: 58.75px; border-width: 1px; border-color: rgb(0, 0, 0);">Able to apply the skill without prompting</td>
          <td style="font-size:14pt;padding:4px;font-family: Barlow !important;height: 58.75px; border-width: 1px; border-color: rgb(0, 0, 0);">Consistent&nbsp;</td>
          <td style="font-size:14pt;padding:4px;font-family: Barlow !important;height: 58.75px; border-width: 1px; border-color: rgb(0, 0, 0);">Activity video is too short to get an understanding</td>
        </tr>
        <tr style="height: 58.75px;">
          <td style="font-size:14pt;padding:4px;font-family: Barlow !important;height: 58.75px; border-width: 1px; border-color: rgb(0, 0, 0);">Significant improvement is needed in the skills area</td>
          <td style="font-size:14pt;padding:4px;font-family: Barlow !important;height: 58.75px; border-width: 1px; border-color: rgb(0, 0, 0);">Being supported by an adult&nbsp;</td>
          <td style="font-size:14pt;padding:4px;font-family: Barlow !important;height: 58.75px; border-width: 1px; border-color: rgb(0, 0, 0);">Shows an increasing understanding</td>
          <td style="font-size:14pt;padding:4px;font-family: Barlow !important;height: 58.75px; border-width: 1px; border-color: rgb(0, 0, 0);">Consistently be able to apply independently</td>
          <td style="font-size:14pt;padding:4px;font-family: Barlow !important;height: 58.75px; border-width: 1px; border-color: rgb(0, 0, 0);">Exceptional mastery</td>
          <td style="font-size:14pt;padding:4px;font-family: Barlow !important;height: 58.75px; border-width: 1px; border-color: rgb(0, 0, 0);">The video is edited or support being given outside the area of video</td>
        </tr>
        <tr style="height: 39.1667px;">
          <td style="font-size:14pt;padding:4px;font-family: Barlow !important;height: 39.1667px; border-width: 1px; border-color: rgb(0, 0, 0);">&nbsp;</td>
          <td style="font-size:14pt;padding:4px;font-family: Barlow !important;height: 39.1667px; border-width: 1px; border-color: rgb(0, 0, 0);">Is at the early stages of acquisition of this skill</td>
          <td style="font-size:14pt;padding:4px;font-family: Barlow !important;height: 39.1667px; border-width: 1px; border-color: rgb(0, 0, 0);">Frequently is able to apply independently</td>
          <td style="font-size:14pt;padding:4px;font-family: Barlow !important;height: 39.1667px; border-width: 1px; border-color: rgb(0, 0, 0);">&nbsp;</td>
          <td style="font-size:14pt;padding:4px;font-family: Barlow !important;height: 39.1667px; border-width: 1px; border-color: rgb(0, 0, 0);">Able to extend to higher level concepts using the skill being assessed for</td>
          <td style="font-size:14pt;padding:4px;font-family: Barlow !important;height: 39.1667px; border-width: 1px; border-color: rgb(0, 0, 0);">&nbsp;</td>
        </tr>
        <tr style="height: 39.1667px;">
          <td style="font-size:14pt;padding:4px;font-family: Barlow !important;height: 39.1667px; border-width: 1px; border-color: rgb(0, 0, 0);">&nbsp;</td>
          <td style="font-size:14pt;padding:4px;font-family: Barlow !important;height: 39.1667px; border-width: 1px; border-color: rgb(0, 0, 0);">Occasionally is able to apply the skill independently</td>
          <td style="font-size:14pt;padding:4px;font-family: Barlow !important;height: 39.1667px; border-width: 1px; border-color: rgb(0, 0, 0);">Comprehends the skill but is unable to fully complete the skill</td>
          <td style="font-size:14pt;padding:4px;font-family: Barlow !important;height: 39.1667px; border-width: 1px; border-color: rgb(0, 0, 0);">&nbsp;</td>
          <td style="font-size:14pt;padding:4px;font-family: Barlow !important;height: 39.1667px; border-width: 1px; border-color: rgb(0, 0, 0);">&nbsp;</td>
          <td style="font-size:14pt;padding:4px;font-family: Barlow !important;height: 39.1667px; border-width: 1px; border-color: rgb(0, 0, 0);">&nbsp;</td>
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
        <p style="font-size: 22px;color:blue;font-weight:bold;font-family: Barlow !important;">{{$page['tab_name']}}</p>
        @foreach($perskill as $perskills)
        @if($perskills['performance_area_id'] == $page['assessment_skill'] && $perskills['skill_type'] == 1)
        <div id="table{{$page['page']}}">
          <div class="table-responsive" style="font-family: Barlow !important;">
            <table class="table table-bordered card-body custom-split" style="width: 100%;border-spacing: 0px;border-collapse: collapse;">
              <thead>
                <tr>
                  @if($perskills['skill_name'] != null || $perskills['skill_name'] != '')
                  <th width="20%" style="padding:4px !important;background-color:#ffc70b !important;font-weight:bold !important;font-family: Barlow !important;text-align:center;border: 1px solid #040404 !important;color: #141414;border-collapse: collapse !important;">{{$perskills['skill_name']}}</th>
                  @else
                  <th width="20%" style="padding:4px !important;background-color:#ffc70b !important;font-weight:bold !important;font-family: Barlow !important;text-align:center;border: 1px solid #040404 !important;color: #141414;border-collapse: collapse !important;">{{$page['tab_name']}}</th>
                  @endif
                  <th width="15%" style="padding:4px !important;background-color:#ffc70b !important;font-weight:bold !important;font-family: Barlow !important;text-align:center;border: 1px solid #040404 !important;color: #141414;border-collapse: collapse !important;">
                    Observation</th>
                  <th width="35%" style="padding:4px !important;background-color:#ffc70b !important;font-family: Barlow !important;text-align:center;border: 1px solid #040404 !important;color: #141414;border-collapse: collapse !important;">
                    Evidence</th>
                  <th width="30%" style="padding:4px !important;background-color:#ffc70b !important;font-family: Barlow !important;text-align:center;border: 1px solid #040404 !important;color: #141414;border-collapse: collapse !important;">
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
                  <td width="20%" style="white-space: pre-line;background: white;border: 1px solid #0e0e0e !important;padding:4px !important;">@foreach($activitys as $activity) @if($page['assessment_skill'] == $activity['performance_area_id'] && $activity['skill_id'] == $perskills['skill_id'] ) @if($activity['skill_type'] == 1) @if( $detail['activity_name'] == $activity['activity_id'] ) <p style="font-weight: bold;">{{$activity['activity_name']}}</p> @endif @endif @endif @endforeach</td>
                  <td width="15%" style="background: white;border: 1px solid #0e0e0e !important;padding:4px !important;">@foreach($observations as $observation) @if( $detail['observation_name'] == $observation['observation_id'] ) <p style="font-weight: bold;">{{$observation['observation_name']}}</p> @endif @endforeach </td>
                  <td width="35%" style="white-space: pre-line;align-items: center;background: white;border: 1px solid #0e0e0e !important;font-family: Barlow !important;padding:4px !important;">{!! $detail['evidence'] !!}</td>
                  <td width="30%" style="white-space: pre-line;align-items: center;background: white;border: 1px solid #0e0e0e !important;font-family: Barlow !important;padding:4px !important;">
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
          <div class="table-responsive" style="font-family: Barlow !important;">
            @php
            $detailsCollection = collect($details2);
            $filteredDetails = $detailsCollection->filter(fn($detail) => $page['assessment_skill'] == $detail['performance_area_id'] && $detail['cheSkill'] == $perskills['skill_id']);
            $rowCount = $filteredDetails->count();
            $recommendationPrinted = false;
            @endphp
            <table class="table table-bordered card-body custom-split myTable{{$page['page']}}" style="width: 100%;border-spacing: 0px;border-collapse: collapse;">
              <thead>
                <tr>
                  <th colspan="4" style="background-color:#ffc70b !important;font-family: Barlow !important;text-align:center;color: #141414;text-align: left;border: 1px solid #040404 !important;border-collapse: collapse !important;">
                    {{$perskills['skill_name']}}
                  </th>
                </tr>
              </thead>
              <tbody id="tablebody_a{{$page['page']}}">
                @foreach($details2 as $detail)
                @if($page['assessment_skill'] == $detail['performance_area_id'] && $detail['cheSkill'] == $perskills['skill_id'])
                @if(!in_array($detail['activity_name'], $verifiedActivities))
                <tr>
                  <td width="20%" style="background: white;border: 1px solid #0e0e0e !important;padding:4px !important;"> @foreach($activitys as $activity) @if($activity['skill_type'] == 2) @if($page['assessment_skill'] == $activity['performance_area_id']) @if( $detail['activity_name'] == $activity['activity_id'] ) <p style="font-weight: bold;">{{$activity['activity_name']}}</p> @endif @endif @endif @endforeach </td>
                  <td width="15%" style="background: white;border: 1px solid #0e0e0e !important;padding:4px !important;"> @foreach($observations as $observation) @if( $detail['observation_name'] == $observation['observation_id'] ) <p style="font-weight: bold;">{{$observation['observation_name']}}</p> @endif @endforeach </td>
                  <td width="35%" style="white-space: pre-line;font-family: Barlow !important;padding:4px !important;align-items: center !important;background: white !important;border: 1px solid #0e0e0e !important;"> {{$detail['evidence']}} </td>

                  <td width="30%" style="white-space: pre-line;align-items: center;background: white;border: 1px solid #0e0e0e !important;font-family: Barlow !important;padding:4px !important;">
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

        @elseif($perskills['performance_area_id'] == $page['assessment_skill'] && $perskills['skill_type'] == 3 && !in_array($perskills['skill_id'] , explode(',',$report['switch'])))
        <!--  -->
        <div id="table{{$page['page']}}">
          <div class="table-responsive" style="font-family: Barlow !important;">
            <table class="table table-bordered custom-split card-body" style="width: 100%;border-spacing: 0px;border-collapse: collapse;">
              <thead>
                <tr>
                  @if($perskills['skill_name'] != null || $perskills['skill_name'] != '')
                  <th width="20%" style="padding:4px !important;background-color:#ffc70b !important;font-family: Barlow !important;text-align:center;border: 1px solid #040404 !important;color: #141414;border-collapse: collapse !important;">
                    {{$perskills['skill_name']}}
                  </th>
                  @else
                  <th width="20%" style="padding:4px !important;background-color:#ffc70b !important;border: 1px solid #040404 !important;color: #141414;border-collapse: collapse !important;font-family: Barlow !important;text-align:center;">
                    {{$page['tab_name']}}
                  </th>
                  @endif
                  <th width="15%" style="padding:4px !important;background-color:#ffc70b !important;font-family: Barlow !important;text-align:center;border: 1px solid #040404 !important;color: #141414;border-collapse: collapse !important;">
                    Observation</th>
                  <th width="35%" style="padding:4px !important;background-color:#ffc70b !important;font-family: Barlow !important;border: 1px solid #040404 !important;color: #141414;border-collapse: collapse !important;">
                    Evidence</th>
                  <th width="30%" style="padding:4px !important;background-color:#ffc70b !important;font-family: Barlow !important;border: 1px solid #040404 !important;color: #141414;border-collapse: collapse !important;">
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
        <div class="table-responsive" id="table_b{{$sskill['skill_id']}}" style="font-family: Barlow !important;">
          <table class="table table-bordered card-body custom-split" style="width: 100%;border-spacing: 0px;border-collapse: collapse;">
            <thead>
              <tr>
                <th colspan="4" style="background-color:#ffc70b !important;color: #141414;font-family: Barlow !important;text-align:center;border: 1px solid #040404 !important;border-collapse: collapse !important;">
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
                <td width="20%" style="background: white;border: 1px solid #0e0e0e !important;padding:4px !important;"> @foreach($activitys as $activity) @if( $detail['activity_name'] == $activity['activity_id'] ) @php $f = 1; @endphp <p style="font-weight: bold;">{{$activity['activity_name']}}</p> @endif @endforeach </td>
                <td width="15%" style="background: white;border: 1px solid #0e0e0e !important;padding:4px !important;"> @foreach($observations as $observation) @if( $detail['observation_name'] == $observation['observation_id'] ) <p style="font-weight: bold;">{{$observation['observation_name']}}</p> @endif @endforeach </td>
                <td width="35%" style="white-space: pre-line;font-family: Barlow !important;padding:4px !important;align-items: center;background: white;border: 1px solid #0e0e0e !important;">{{$detail['evidence'] }}</td>

                <td width="30%" style="white-space: pre-line;font-family: Barlow !important;padding:4px !important;align-items: center;background: white;border: 1px solid #0e0e0e !important;">
                  {!! $detail['recommendation'] !!}
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
        <p style="font-size: 22px;color:blue;font-weight:bold;font-family: Barlow !important;margin: 0;">Sensory</p>
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
            <table class="table table-bordered card-body custom-split-1" style="width: 100%; border-spacing: 0; border-collapse: collapse;">
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
                  <td class="quadrantSensory" style="border: 1px solid #0e0e0e !important; background-color: white;">
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
<!-- <script>
  // $(".loader").show();
  document.addEventListener("DOMContentLoaded", function() {
    const tables = document.querySelectorAll('table');
    tables.forEach(table => {
      // Skip only signature section
      if (table.closest('#page14')) {
        return;
      }

      // Determine target column indexes by header text (Evidence/Recommendation)
      const headerCells = Array.from(table.querySelectorAll('thead th'));
      const targetIndexes = headerCells
        .map((th, idx) => ({ idx, text: (th.textContent || '').toLowerCase().trim() }))
        .filter(h => h.text.includes('evidence') || h.text.includes('recommendation'))
        .map(h => h.idx);

      // Fallback for 4-col tables without thead mapping
      if (targetIndexes.length === 0) {
        targetIndexes.push(2, 3);
      }

      const rows = table.querySelectorAll('tbody tr');
      rows.forEach(tr => {
        const cells = Array.from(tr.querySelectorAll('td'));
        cells.forEach((td, columnIndex) => {
          if (!targetIndexes.includes(columnIndex)) {
            return;
          }

          const content = td.innerHTML.trim();
          if (content.length <= 200) {
            return;
          }

          const doc = new DOMParser().parseFromString(content, 'text/html');
          const paragraphs = doc.querySelectorAll('p');
          if (paragraphs.length <= 1) {
            return;
          }

          const halfIndex = Math.ceil(paragraphs.length / 2);
          const secondPart = Array.from(paragraphs).slice(halfIndex).map(p => p.outerHTML).join('');
          const firstPart = Array.from(paragraphs).slice(0, halfIndex).map(p => p.outerHTML).join('');

          const newRow = tr.cloneNode(true);
          const newTds = newRow.querySelectorAll('td');

          newTds.forEach((cell, i) => {
            if (i === columnIndex) {
              cell.innerHTML = secondPart;
            } else {
              cell.innerHTML = '';
            }
          });

          td.innerHTML = firstPart;
          tr.parentNode.insertBefore(newRow, tr.nextSibling);
        });
      });
    });
    var htmlContent = document.getElementById('report2').innerHTML;
    // console.log(htmlContent);
    document.getElementById('summary_report').value = htmlContent;
    // console.log(document.getElementById('summary_report').value);
    // document.getElementById('submitForm').submit();
  });
</script> -->

<!-- <script>
  document.addEventListener("DOMContentLoaded", function() {
    const A4_TOTAL_HEIGHT = 193.7; // A4 landscape height in px (96 DPI)
    const MARGIN_PX = 75.6; // 2cm margin in px
    const USABLE_HEIGHT = A4_TOTAL_HEIGHT - MARGIN_PX * 2; // ≈ 642.5px

    const tables = document.querySelectorAll("table");
    tables.forEach((table) => {
      if (table.closest("#page14")) return;

      const headerCells = Array.from(table.querySelectorAll("thead th"));
      const targetIndexes = headerCells
        .map((th, idx) => ({
          idx,
          text: (th.textContent || "").toLowerCase().trim(),
        }))
        .filter(
          (h) => h.text.includes("evidence") || h.text.includes("recommendation")
        )
        .map((h) => h.idx);

      if (targetIndexes.length === 0) {
        targetIndexes.push(2, 3);
      }

      const rows = table.querySelectorAll("tbody tr");
      rows.forEach((tr) => {
        const trHeight = tr.getBoundingClientRect().height;

        if (trHeight <= USABLE_HEIGHT) return;

        const cells = Array.from(tr.querySelectorAll("td"));
        cells.forEach((td, columnIndex) => {
          if (!targetIndexes.includes(columnIndex)) return;

          const content = td.innerHTML.trim();
          const doc = new DOMParser().parseFromString(content, "text/html");
          const paragraphs = doc.querySelectorAll("p");
          if (paragraphs.length <= 1) return;

          const halfIndex = Math.ceil(paragraphs.length / 2);
          const firstPart = Array.from(paragraphs)
            .slice(0, halfIndex)
            .map((p) => p.outerHTML)
            .join("");
          const secondPart = Array.from(paragraphs)
            .slice(halfIndex)
            .map((p) => p.outerHTML)
            .join("");

          const newRow = tr.cloneNode(true);
          const newTds = newRow.querySelectorAll("td");

          newTds.forEach((cell, i) => {
            if (i === columnIndex) {
              cell.innerHTML = secondPart;
            } else {
              cell.innerHTML = "";
            }
          });

          td.innerHTML = firstPart;
          tr.parentNode.insertBefore(newRow, tr.nextSibling);
        });
      });
    });

    const htmlContent = document.getElementById("report2").innerHTML;
    document.getElementById("summary_report").value = htmlContent;
    // document.getElementById('submitForm').submit();
  });
</script> -->

<!-- <script>
  document.addEventListener("DOMContentLoaded", function() {
    const A4_TOTAL_HEIGHT = 193.7;
    const MARGIN_PX = 75.6;
    const USABLE_HEIGHT = A4_TOTAL_HEIGHT - MARGIN_PX * 2;

    const tables = document.querySelectorAll("table.custom-split");
    tables.forEach((table) => {
      if (table.closest("#page14")) return;

      const headerCells = Array.from(table.querySelectorAll("thead th"));
      const targetIndexes = headerCells
        .map((th, idx) => ({
          idx,
          text: (th.textContent || "").toLowerCase().trim(),
        }))
        .filter(
          (h) => h.text.includes("evidence") || h.text.includes("recommendation")
        )
        .map((h) => h.idx);

      if (targetIndexes.length === 0) targetIndexes.push(2, 3);

      const rows = table.querySelectorAll("tbody tr");
      rows.forEach((tr) => {
        const trHeight = tr.getBoundingClientRect().height;
        if (trHeight <= USABLE_HEIGHT) return;

        const cells = Array.from(tr.querySelectorAll("td"));

        // ✅ Prevent error if row does not have enough cells
        if (cells.length <= Math.max(...targetIndexes)) return;

        const firstSplit = [];
        const secondSplit = [];

        // Collect and split BOTH columns together
        targetIndexes.forEach((columnIndex) => {
          let content = cells[columnIndex].innerHTML.trim();
          const doc = new DOMParser().parseFromString(content, "text/html");
          let paragraphs = Array.from(doc.querySelectorAll("p"));

          if (paragraphs.length === 0) {
            const rawText = content
              .replace(/<br\s*\/?>/gi, "\n")
              .replace(/<\/?[^>]+(>|$)/g, "")
              .trim();

            const lines = rawText.split(/\n+/).filter((line) => line.trim() !== "");
            paragraphs = lines.map((line) => {
              const p = document.createElement("p");
              p.textContent = line.trim();
              return p;
            });
          }

          const halfIndex = Math.ceil(paragraphs.length / 2);
          firstSplit[columnIndex] = paragraphs.slice(0, halfIndex).map(p => p.outerHTML).join("");
          secondSplit[columnIndex] = paragraphs.slice(halfIndex).map(p => p.outerHTML).join("");
        });

        const newRow = tr.cloneNode(true);
        const newTds = newRow.querySelectorAll("td");
        const oldTds = tr.querySelectorAll("td");

        // ✅ Apply both splits to original row & new row — SAFETY CHECK added
        targetIndexes.forEach((col) => {
          if (oldTds[col] && newTds[col]) {
            oldTds[col].innerHTML = firstSplit[col];
            newTds[col].innerHTML = secondSplit[col];
          }
        });

        // ✅ Keep other columns SAME (no blank cells) — SAFE ACCESS
        newTds.forEach((cell, i) => {
          if (!targetIndexes.includes(i) && oldTds[i]) {
            cell.innerHTML = oldTds[i].innerHTML;
          }
        });

        tr.parentNode.insertBefore(newRow, tr.nextSibling);
      });
    });

    const htmlContent = document.getElementById("report2").innerHTML;
    document.getElementById("summary_report").value = htmlContent;
    // document.getElementById('submitForm').submit();
  });
</script> -->


<script>
  (function() {
    const A4_TOTAL_HEIGHT = 193.7; // A4 page height in mm (converted to px at 96 DPI)
    const MARGIN_PX = 75.6; // 2cm margin in px
    const USABLE_HEIGHT = A4_TOTAL_HEIGHT - MARGIN_PX * 2;
    const HEADER_HEIGHT = 113.4; // 4cm header in px (margin-top from body)
    const FOOTER_HEIGHT = 56.7; // 2cm footer in px

    //----------------------------------------------------------------
    // FUNCTION: Calculate table starting position on page
    //----------------------------------------------------------------
    function calculateTablePosition(table) {
      // Get table's position relative to document
      const rect = table.getBoundingClientRect();
      const scrollTop = window.pageYOffset || document.documentElement.scrollTop;
      const tableTop = rect.top + scrollTop;
      
      // Account for body margin-top (header space)
      const contentStart = HEADER_HEIGHT;
      const relativeTop = tableTop - contentStart;
      
      // Calculate which "page" this table starts on (in PDF terms)
      // Each page is USABLE_HEIGHT pixels tall
      const pageNumber = Math.floor(relativeTop / USABLE_HEIGHT);
      const positionOnPage = relativeTop % USABLE_HEIGHT;
      
      // Calculate available space from table start to end of current page
      const availableSpaceOnPage = USABLE_HEIGHT - positionOnPage;
      
      // Store as data attributes for later use
      table.setAttribute('data-page-start', pageNumber);
      table.setAttribute('data-position-y', positionOnPage.toFixed(2));
      table.setAttribute('data-available-space', availableSpaceOnPage.toFixed(2));
      table.setAttribute('data-absolute-top', tableTop.toFixed(2));
      
      return {
        pageNumber: pageNumber,
        positionY: positionOnPage,
        availableSpace: availableSpaceOnPage,
        absoluteTop: tableTop,
        tableHeight: rect.height
      };
    }

    //----------------------------------------------------------------
    // FUNCTION: Get all tables and calculate their positions
    //----------------------------------------------------------------
    function calculateAllTablePositions() {
      const allTables = document.querySelectorAll('table');
      const tablePositions = [];
      
      allTables.forEach((table, index) => {
        if (table.closest("#page14")) return; // Skip signature table
        
        const position = calculateTablePosition(table);
        tablePositions.push({
          index: index,
          table: table,
          ...position
        });
        
        // Log for debugging (can be removed in production)
        console.log(`Table ${index}:`, {
          page: position.pageNumber,
          yPosition: position.positionY.toFixed(2) + 'px',
          availableSpace: position.availableSpace.toFixed(2) + 'px',
          tableHeight: position.tableHeight.toFixed(2) + 'px'
        });
      });
      
      return tablePositions;
    }

    // Calculate positions for all tables
    const tablePositions = calculateAllTablePositions();

    //----------------------------------------------------------------
    // UTILITY FUNCTIONS: Access table position information
    // 
    // USAGE EXAMPLES:
    // 
    // 1. Get position of first table:
    //    const pos = getTablePosition(0);
    //    console.log('Page:', pos.pageNumber, 'Y Position:', pos.positionY);
    // 
    // 2. Get position of specific table element:
    //    const table = document.querySelector('table.custom-split');
    //    const pos = getTablePosition(table);
    //    console.log('Available space:', pos.availableSpace);
    // 
    // 3. Get just the available space:
    //    const space = getTableAvailableSpace(0); // Returns available space in px
    // 
    // RETURNED OBJECT STRUCTURE:
    // {
    //   pageNumber: number,      // Which page the table starts on (0-indexed)
    //   positionY: number,       // Y position from top of page content area
    //   availableSpace: number,  // Remaining space on current page
    //   absoluteTop: number,     // Absolute position from document top
    //   tableHeight: number      // Height of the table
    // }
    // 
    // DATA ATTRIBUTES SET ON EACH TABLE:
    // - data-page-start: Page number where table begins
    // - data-position-y: Y position on page
    // - data-available-space: Available space remaining
    // - data-absolute-top: Absolute top position
    //----------------------------------------------------------------
    window.getTablePosition = function(tableOrIndex) {
      let table;
      if (typeof tableOrIndex === 'number') {
        table = document.querySelectorAll('table')[tableOrIndex];
      } else {
        table = tableOrIndex;
      }
      
      if (!table) return null;
      
      // Return stored position or calculate new one
      const storedPos = tablePositions.find(tp => tp.table === table);
      if (storedPos) {
        return storedPos;
      }
      
      // Calculate if not found
      return calculateTablePosition(table);
    };

    //----------------------------------------------------------------
    // UTILITY FUNCTION: Get available space for a table
    //----------------------------------------------------------------
    window.getTableAvailableSpace = function(tableOrIndex) {
      const pos = window.getTablePosition(tableOrIndex);
      return pos ? pos.availableSpace : null;
    };

    //----------------------------------------------------------------
    // PROCESS 1: Tables with class "custom-split-1" (recursive splitting until rows fit)
    //----------------------------------------------------------------
    const tables1 = document.querySelectorAll("table.custom-split-1");

    tables1.forEach((table) => {
      if (table.closest("#page14")) return;

      // Get target columns (Evidence and Recommendations)
      const headerCells = Array.from(table.querySelectorAll("thead th"));
      const targetIndexes = headerCells
        .map((th, idx) => ({
          idx,
          text: (th.textContent || "").toLowerCase().trim()
        }))
        .filter((h) => h.text.includes("evidence") || h.text.includes("recommendation"))
        .map((h) => h.idx);
      
      if (targetIndexes.length === 0) targetIndexes.push(1, 2); // Default to columns 1 and 2 for custom-split-1
      
      // Recursive function to split rows based on paragraph count
      function splitRowsRecursively() {
        let maxIterations = 50; // Safety limit to prevent infinite loops
        let iteration = 0;
        let hasChanges = true;
        
        while (hasChanges && iteration < maxIterations) {
          hasChanges = false;
          iteration++;
          
          const rows = Array.from(table.querySelectorAll("tbody tr"));
          
          rows.forEach((tr) => {
            if (tr.hasAttribute('data-split-processed-1')) return;
            
            const cells = Array.from(tr.querySelectorAll("td"));
            
            if (cells.length <= Math.max(...targetIndexes)) {
              tr.setAttribute('data-split-processed-1', 'true');
              return;
            }
            
            // Check if we need to split - look at Evidence column (targetIndexes[0])
            const evidenceColumnIndex = targetIndexes[0];
            if (evidenceColumnIndex >= cells.length) {
              tr.setAttribute('data-split-processed-1', 'true');
              return;
            }
            
            let evidenceContent = cells[evidenceColumnIndex].innerHTML.trim();
            const doc = new DOMParser().parseFromString(evidenceContent, "text/html");
            let paragraphs = Array.from(doc.querySelectorAll("p"));
            
            if (paragraphs.length === 0) {
              const rawText = evidenceContent
                .replace(/<br\s*\/?>/gi, "\n")
                .replace(/<\/?[^>]+(>|$)/g, "")
                .trim();
              
              const lines = rawText.split(/\n+/).filter((line) => line.trim() !== "");
              paragraphs = lines.map((line) => {
                const p = document.createElement("p");
                p.textContent = line.trim();
                return p;
              });
            }
            
            // Only split if there are more than 3 paragraphs
            // Split into chunks of 2-3 paragraphs per row
            if (paragraphs.length <= 3) {
              tr.setAttribute('data-split-processed-1', 'true');
              return;
            }
            
            // Determine split point: take first 3 paragraphs, rest goes to new row
            const splitPoint = 3;
            const firstPart = paragraphs.slice(0, splitPoint).map(p => p.outerHTML).join("");
            const secondPart = paragraphs.slice(splitPoint).map(p => p.outerHTML).join("");
            
            // Split the row
            const firstSplit = [];
            const secondSplit = [];
            
            targetIndexes.forEach((columnIndex) => {
              if (columnIndex >= cells.length) return;
              
              let content = cells[columnIndex].innerHTML.trim();
              
              if (columnIndex === evidenceColumnIndex) {
                // Split evidence column
                firstSplit[columnIndex] = firstPart;
                secondSplit[columnIndex] = secondPart;
              } else {
                // For recommendations column, split proportionally if it has content
                const recDoc = new DOMParser().parseFromString(content, "text/html");
                const recParagraphs = Array.from(recDoc.querySelectorAll("p"));
                if (recParagraphs.length >= 2) {
                  // Split recommendations proportionally based on evidence split ratio
                  const recSplitPoint = Math.ceil((recParagraphs.length * splitPoint) / paragraphs.length);
                  firstSplit[columnIndex] = recParagraphs.slice(0, recSplitPoint).map(p => p.outerHTML).join("");
                  secondSplit[columnIndex] = recParagraphs.slice(recSplitPoint).map(p => p.outerHTML).join("");
                } else {
                  firstSplit[columnIndex] = content;
                  secondSplit[columnIndex] = "";
                }
              }
            });
            
            // Create new row with split content
            const newRow = tr.cloneNode(true);
            const newTds = newRow.querySelectorAll("td");
            const oldTds = tr.querySelectorAll("td");
            
            targetIndexes.forEach((col) => {
              if (oldTds[col] && newTds[col]) {
                oldTds[col].innerHTML = firstSplit[col] || "";
                newTds[col].innerHTML = secondSplit[col] || "";
              }
            });
            
            // Keep other columns the same (Quadrants column - column 0)
            newTds.forEach((cell, i) => {
              if (!targetIndexes.includes(i) && oldTds[i]) {
                cell.innerHTML = oldTds[i].innerHTML;
              }
            });
            
            tr.setAttribute('data-split-processed-1', 'true');
            newRow.removeAttribute('data-split-processed-1'); // New row needs to be checked
            tr.parentNode.insertBefore(newRow, tr.nextSibling);
            
            hasChanges = true;
          });
        }
      }
      
      // Execute recursive splitting
      splitRowsRecursively();
    });

    //----------------------------------------------------------------
    // PROCESS 2: Tables with class "custom-split" (split rows only, keep all p tags together)
    //----------------------------------------------------------------
    const tables2 = document.querySelectorAll("table.custom-split");

    tables2.forEach((table) => {

      if (table.closest("#page14")) return;

      const headerCells = Array.from(table.querySelectorAll("thead th"));

      const targetIndexes = headerCells

        .map((th, idx) => ({

          idx,

          text: (th.textContent || "").toLowerCase().trim()

        }))

        .filter((h) => h.text.includes("evidence") || h.text.includes("recommendation"))

        .map((h) => h.idx);

      if (targetIndexes.length === 0) targetIndexes.push(2, 3);

      // Convert NodeList to array to avoid issues with live NodeList
      const rows = Array.from(table.querySelectorAll("tbody tr"));

      rows.forEach((tr) => {
        // Skip rows that have already been processed
        if (tr.hasAttribute('data-split-processed')) {
          return;
        }

        const trHeight = tr.getBoundingClientRect().height;

        // Mark row as processed even if it doesn't need splitting
        if (trHeight <= USABLE_HEIGHT) {
          tr.setAttribute('data-split-processed', 'true');
          return;
        }

        const cells = Array.from(tr.querySelectorAll("td"));

        if (cells.length <= Math.max(...targetIndexes)) {
          tr.setAttribute('data-split-processed', 'true');
          return;
        }

        const firstSplit = [];

        const secondSplit = [];

        let hasContentToSplit = false;

        targetIndexes.forEach((columnIndex) => {

          let content = cells[columnIndex].innerHTML.trim();

          const doc = new DOMParser().parseFromString(content, "text/html");

          let paragraphs = Array.from(doc.querySelectorAll("p"));

          if (paragraphs.length === 0) {

            const rawText = content

              .replace(/<br\s*\/?>/gi, "\n")

              .replace(/<\/?[^>]+(>|$)/g, "")

              .trim();

            // const lines = rawText.split(/\n+/).filter((line) => line.trim() !== "");
            // paragraphs = lines.map((line) => {
            //   const p = document.createElement("p");
            //   p.textContent = line.trim();
            //   return p;
            // });

const blocks = rawText.split(/\n\s*\n/).map(block => block.trim()).filter(block => block !== "");

paragraphs = blocks.map(block => {
  const p = document.createElement("p");
  p.textContent = block;
  return p;
});


          }

          // Only split if there are at least 2 paragraphs
          if (paragraphs.length >= 2) {
            hasContentToSplit = true;
            const halfIndex = Math.ceil(paragraphs.length / 2);

            firstSplit[columnIndex] = paragraphs.slice(0, halfIndex).map(p => p.outerHTML).join("");

            secondSplit[columnIndex] = paragraphs.slice(halfIndex).map(p => p.outerHTML).join("");
          } else {
            // Keep original content if not enough paragraphs to split
            firstSplit[columnIndex] = content;
            secondSplit[columnIndex] = "";
          }

        });

        // Only create new row if there's actually content to split
        if (!hasContentToSplit) {
          tr.setAttribute('data-split-processed', 'true');
          return;
        }

        const newRow = tr.cloneNode(true);

        const newTds = newRow.querySelectorAll("td");

        const oldTds = tr.querySelectorAll("td");

        targetIndexes.forEach((col) => {

          if (oldTds[col] && newTds[col]) {

            oldTds[col].innerHTML = firstSplit[col];

            newTds[col].innerHTML = secondSplit[col];

          }

        });

        newTds.forEach((cell, i) => {

          if (!targetIndexes.includes(i) && oldTds[i]) {

            cell.innerHTML = oldTds[i].innerHTML;

          }

        });

        // Mark both rows as processed
        tr.setAttribute('data-split-processed', 'true');
        newRow.setAttribute('data-split-processed', 'true');

        tr.parentNode.insertBefore(newRow, tr.nextSibling);

      });

    });

    //----------------------------------------------------------------
    // Update hidden summary field (exists in both scripts)
    //----------------------------------------------------------------
    if (document.getElementById("report2") && document.getElementById("summary_report")) {
      document.getElementById("summary_report").value =
        document.getElementById("report2").innerHTML;
    }
    document.getElementById('submitForm').submit();
  })();
</script>





</html>