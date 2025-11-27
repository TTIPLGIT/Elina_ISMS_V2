<html>

<head>
  <style>
    @page {
      margin: 0cm 0cm;
    }

    .flyleaf {
      page-break-after: always;
    }
    /* vietnamese */
    @font-face {
      font-family: 'Barlow Semi Condensed';
      font-style: normal;
      font-weight: 400;
      font-display: swap;
      src: url(https://fonts.gstatic.com/s/barlowsemicondensed/v15/wlpvgxjLBV1hqnzfr-F8sEYMB0Yybp0mudRXd4qqOEo.woff2) format('woff2');
      unicode-range: U+0102-0103, U+0110-0111, U+0128-0129, U+0168-0169, U+01A0-01A1, U+01AF-01B0, U+0300-0301, U+0303-0304, U+0308-0309, U+0323, U+0329, U+1EA0-1EF9, U+20AB;
    }

    /* latin-ext */
    @font-face {
      font-family: 'Barlow Semi Condensed';
      font-style: normal;
      font-weight: 400;
      font-display: swap;
      src: url(https://fonts.gstatic.com/s/barlowsemicondensed/v15/wlpvgxjLBV1hqnzfr-F8sEYMB0Yybp0mudRXdoqqOEo.woff2) format('woff2');
      unicode-range: U+0100-02AF, U+0304, U+0308, U+0329, U+1E00-1E9F, U+1EF2-1EFF, U+2020, U+20A0-20AB, U+20AD-20CF, U+2113, U+2C60-2C7F, U+A720-A7FF;
    }

    /* latin */
    @font-face {
      font-family: 'Barlow Semi Condensed';
      font-style: normal;
      font-weight: 400;
      font-display: swap;
      src: url(https://fonts.gstatic.com/s/barlowsemicondensed/v15/wlpvgxjLBV1hqnzfr-F8sEYMB0Yybp0mudRXeIqq.woff2) format('woff2');
      unicode-range: U+0000-00FF, U+0131, U+0152-0153, U+02BB-02BC, U+02C6, U+02DA, U+02DC, U+0304, U+0308, U+0329, U+2000-206F, U+2074, U+20AC, U+2122, U+2191, U+2193, U+2212, U+2215, U+FEFF, U+FFFD;
    }

    /* vietnamese */
    @font-face {
      font-family: 'Barlow Semi Condensed';
      font-style: normal;
      font-weight: 700;
      font-display: swap;
      src: url(https://fonts.gstatic.com/s/barlowsemicondensed/v15/wlpigxjLBV1hqnzfr-F8sEYMB0Yybp0mudRfw6-_CGslu50.woff2) format('woff2');
      unicode-range: U+0102-0103, U+0110-0111, U+0128-0129, U+0168-0169, U+01A0-01A1, U+01AF-01B0, U+0300-0301, U+0303-0304, U+0308-0309, U+0323, U+0329, U+1EA0-1EF9, U+20AB;
    }

    /* latin-ext */
    @font-face {
      font-family: 'Barlow Semi Condensed';
      font-style: normal;
      font-weight: 700;
      font-display: swap;
      src: url(https://fonts.gstatic.com/s/barlowsemicondensed/v15/wlpigxjLBV1hqnzfr-F8sEYMB0Yybp0mudRfw6-_CWslu50.woff2) format('woff2');
      unicode-range: U+0100-02AF, U+0304, U+0308, U+0329, U+1E00-1E9F, U+1EF2-1EFF, U+2020, U+20A0-20AB, U+20AD-20CF, U+2113, U+2C60-2C7F, U+A720-A7FF;
    }

    /* latin */
    @font-face {
      font-family: 'Barlow Semi Condensed';
      font-style: normal;
      font-weight: 700;
      font-display: swap;
      src: url(https://fonts.gstatic.com/s/barlowsemicondensed/v15/wlpigxjLBV1hqnzfr-F8sEYMB0Yybp0mudRfw6-_B2sl.woff2) format('woff2');
      unicode-range: U+0000-00FF, U+0131, U+0152-0153, U+02BB-02BC, U+02C6, U+02DA, U+02DC, U+0304, U+0308, U+0329, U+2000-206F, U+2074, U+20AC, U+2122, U+2191, U+2193, U+2212, U+2215, U+FEFF, U+FFFD;
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
  </style>
</head>

<body style="font-family: 'Barlow Semi Condensed', sans-serif !important;">
  <div class="flyleaf">
    <header>
      <img src="C:\Apache24\htdocs\Elina ISMS\v1\web\public\images/report_header.JPG" alt="" style="width: 100%;" id="img_logo">
    </header>
    <img src="C:\Apache24\htdocs\Elina ISMS\v1\web\public\images/SAIL.png" alt="" style="display: block;margin-left: 25%;margin-right: auto;width: 50%;height:50%">
    <h6 style="text-align: center;font-size: 20px;">Child Name</h6>
    <h6 style="text-align: center;font-size: 20px;">{{$data['child_name']}}</h6>
    <h6 style="float:left;font-size: 20px;">Date of Birth<br>{{$data['child_dob']}}</h6>
    <h6 style="float:right;font-size: 20px;">Date of Reporting<br>{{$data['dor']}}</h6>
    <footer>
      <img src="C:\Apache24\htdocs\Elina ISMS\v1\web\public\images/report_footer.JPG" alt="" style="width: 100%;">
    </footer>
  </div>

  <header>
    <img src="C:\Apache24\htdocs\Elina ISMS\v1\web\public\images/elina-logo-2.png" alt="" style="width: 190px;float: right;margin: 50px 50px 0 0;" id="img_logo">
  </header>

  <footer>
    <img src="C:\Apache24\htdocs\Elina ISMS\v1\web\public\images/report_footer.JPG" alt="" style="width: 100%;">
  </footer>
  <p style="text-align: justify;font-family: 'Barlow Semi Condensed', sans-serif !important;">Our functional assessment is based on the developmental domains and is designed to understand a child&rsquo;s profile and potential. While observing a child, many important facets of a child's development are revealed simultaneously and factors that may be impeding the child's overall performance are also identified. Developmental assessment observes how your child grows and changes over time and whether your child meets the typical developmental milestones in all the domains of development.</p>
  <table style="font-family: 'Barlow Semi Condensed', sans-serif !important;border-collapse: collapse; width: 100%; border: 1px solid rgb(0, 0, 0); margin-left: auto; margin-right: auto;" border="1">
    <colgroup>
      <col style="width: 5.02125%;">
      <col style="width: 44.9787%;">
      <col style="width: 50%;">
    </colgroup>
    <tbody>
      <tr>
        <td style="font-family: 'Barlow Semi Condensed', sans-serif;background-color: cornflowerblue;border-width: 1px; border-color: rgb(0, 0, 0);">&nbsp;</td>
        <td style="font-family: 'Barlow Semi Condensed', sans-serif;background-color: cornflowerblue;text-align: center; border-width: 1px; border-color: rgb(0, 0, 0);">Domains</td>
        <td style="font-family: 'Barlow Semi Condensed', sans-serif;background-color: cornflowerblue;text-align: center; border-width: 1px; border-color: rgb(0, 0, 0);">Description</td>
      </tr>
      <tr>
        <td style="font-family: 'Barlow Semi Condensed', sans-serif;text-align: center;border-width: 1px; border-color: rgb(0, 0, 0);">I</td>
        <td style="font-family: 'Barlow Semi Condensed', sans-serif;text-align: center; border-width: 1px; border-color: rgb(0, 0, 0);">Physical</td>
        <td style="font-family: 'Barlow Semi Condensed', sans-serif !important;border-width: 1px; border-color: rgb(0, 0, 0);">The physical domain covers the development of physical changes, which includes growing in size and strength, also includes body image, health and nutrition.</td>
      </tr>
      <tr>
        <td style="font-family: 'Barlow Semi Condensed', sans-serif;text-align: center;border-width: 1px; border-color: rgb(0, 0, 0);">II</td>
        <td style="font-family: 'Barlow Semi Condensed', sans-serif;text-align: center; border-width: 1px; border-color: rgb(0, 0, 0);">Motor</td>
        <td style="font-family: 'Barlow Semi Condensed', sans-serif !important;border-width: 1px; border-color: rgb(0, 0, 0);">Refers to elements related to gross motor, fine motor and bilateral coordination.</td>
      </tr>
      <tr>
        <td style="font-family: 'Barlow Semi Condensed', sans-serif;text-align: center;border-width: 1px; border-color: rgb(0, 0, 0);">III</td>
        <td style="font-family: 'Barlow Semi Condensed', sans-serif;text-align: center; border-width: 1px; border-color: rgb(0, 0, 0);">Sensory</td>
        <td style="font-family: 'Barlow Semi Condensed', sans-serif;font-family: 'Barlow Semi Condensed', sans-serif !important;border-width: 1px; border-color: rgb(0, 0, 0);">Assess children's sensory processing patterns with the Sensory Profile, adapted from the &nbsp;Pearsons Tools. This helps to understand a child's sensory processing patterns in everyday situations and profile the sensory system's effect on functional performance.&nbsp;</td>
      </tr>
      <tr>
        <td style="font-family: 'Barlow Semi Condensed', sans-serif;text-align: center;border-width: 1px; border-color: rgb(0, 0, 0);">IV</td>
        <td style="font-family: 'Barlow Semi Condensed', sans-serif;text-align: center; border-width: 1px; border-color: rgb(0, 0, 0);">Cognition</td>
        <td style="font-family: 'Barlow Semi Condensed', sans-serif;font-family: 'Barlow Semi Condensed', sans-serif !important;border-width: 1px; border-color: rgb(0, 0, 0);">The cognitive domain includes intellectual development and creativity.</td>
      </tr>
      <tr>
        <td style="font-family: 'Barlow Semi Condensed', sans-serif;text-align: center;border-width: 1px; border-color: rgb(0, 0, 0);">V</td>
        <td style="font-family: 'Barlow Semi Condensed', sans-serif;text-align: center; border-width: 1px; border-color: rgb(0, 0, 0);">Social &amp; Emotional</td>
        <td style="font-family: 'Barlow Semi Condensed', sans-serif;font-family: 'Barlow Semi Condensed', sans-serif !important;border-width: 1px; border-color: rgb(0, 0, 0);">The social-emotional domain includes a child's growing understanding and control of their emotions and participation in varied social domains.</td>
      </tr>
      <tr>
        <td style="font-family: 'Barlow Semi Condensed', sans-serif;text-align: center;border-width: 1px; border-color: rgb(0, 0, 0);">VI</td>
        <td style="font-family: 'Barlow Semi Condensed', sans-serif;text-align: center; border-width: 1px; border-color: rgb(0, 0, 0);">Speech and Communication</td>
        <td style="font-family: 'Barlow Semi Condensed', sans-serif !important;border-width: 1px; border-color: rgb(0, 0, 0);">Addresses the skills of listening and speaking. Understanding receptive and expressive communication.&nbsp;</td>
      </tr>
      <tr>
        <td style="font-family: 'Barlow Semi Condensed', sans-serif;text-align: center;border-width: 1px; border-color: rgb(0, 0, 0);">VII</td>
        <td style="font-family: 'Barlow Semi Condensed', sans-serif;text-align: center; border-width: 1px; border-color: rgb(0, 0, 0);">Play</td>
        <td style="font-family: 'Barlow Semi Condensed', sans-serif !important;border-width: 1px; border-color: rgb(0, 0, 0);">The observation and assessment of play, physical play and social skills through play.</td>
      </tr>
      <tr>
        <td style="font-family: 'Barlow Semi Condensed', sans-serif;text-align: center;border-width: 1px; border-color: rgb(0, 0, 0);">VIII</td>
        <td style="font-family: 'Barlow Semi Condensed', sans-serif;text-align: center; border-width: 1px; border-color: rgb(0, 0, 0);">ADLs</td>
        <td style="font-family: 'Barlow Semi Condensed', sans-serif !important;border-width: 1px; border-color: rgb(0, 0, 0);">The activities of daily living are those skills required to manage one's basic physical needs, including personal hygiene or grooming, dressing, toileting, transferring and eating.</td>
      </tr>
    </tbody>
  </table>
  <p style="page-break-after: always"></p>
  <p style="font-family: 'Barlow Semi Condensed', sans-serif !important;text-align: justify;">Within each of these domains, there are a variety of skill set areas that can further define specific areas of child development and learning.</p>
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
        <td style="font-family: 'Barlow Semi Condensed', sans-serif;background-color: cornflowerblue;height: 19.5833px; text-align: center; border-width: 1px; border-color: rgb(0, 0, 0);">Needs major support</td>
        <td style="font-family: 'Barlow Semi Condensed', sans-serif;background-color: cornflowerblue;height: 19.5833px; text-align: center; border-width: 1px; border-color: rgb(0, 0, 0);">Emerging</td>
        <td style="font-family: 'Barlow Semi Condensed', sans-serif;background-color: cornflowerblue;height: 19.5833px; text-align: center; border-width: 1px; border-color: rgb(0, 0, 0);">Developing</td>
        <td style="font-family: 'Barlow Semi Condensed', sans-serif;background-color: cornflowerblue;height: 19.5833px; text-align: center; border-width: 1px; border-color: rgb(0, 0, 0);">Meeting</td>
        <td style="font-family: 'Barlow Semi Condensed', sans-serif;background-color: cornflowerblue;height: 19.5833px; text-align: center; border-width: 1px; border-color: rgb(0, 0, 0);">Exceeds expectation</td>
        <td style="font-family: 'Barlow Semi Condensed', sans-serif;background-color: cornflowerblue;height: 19.5833px; text-align: center; border-width: 1px; border-color: rgb(0, 0, 0);">Unable to observe clearly</td>
      </tr>
      <tr style="height: 39.1667px;">
        <td style="font-family: 'Barlow Semi Condensed', sans-serif;height: 39.1667px; border-width: 1px; border-color: rgb(0, 0, 0);">Child refuses to recognise/attempt the skill</td>
        <td style="font-family: 'Barlow Semi Condensed', sans-serif;height: 39.1667px; border-width: 1px; border-color: rgb(0, 0, 0);">The child has been taught this skill</td>
        <td style="font-family: 'Barlow Semi Condensed', sans-serif;height: 39.1667px; border-width: 1px; border-color: rgb(0, 0, 0);">Able to revisit previous knowledge or skill</td>
        <td style="font-family: 'Barlow Semi Condensed', sans-serif;height: 39.1667px; border-width: 1px; border-color: rgb(0, 0, 0);">Showing a strong evidence of deep understanding</td>
        <td style="font-family: 'Barlow Semi Condensed', sans-serif;height: 39.1667px; border-width: 1px; border-color: rgb(0, 0, 0);">Demonstrates an exceptional level of performance</td>
        <td style="font-family: 'Barlow Semi Condensed', sans-serif;height: 39.1667px; border-width: 1px; border-color: rgb(0, 0, 0);">No / limited scope for observation</td>
      </tr>
      <tr style="height: 58.75px;">
        <td style="font-family: 'Barlow Semi Condensed', sans-serif;height: 58.75px; border-width: 1px; border-color: rgb(0, 0, 0);">The child does not meet even the minimum expectations in results</td>
        <td style="font-family: 'Barlow Semi Condensed', sans-serif;height: 58.75px; border-width: 1px; border-color: rgb(0, 0, 0);">Been given opportunities to develop</td>
        <td style="font-family: 'Barlow Semi Condensed', sans-serif;height: 58.75px; border-width: 1px; border-color: rgb(0, 0, 0);">Been given opportunities to practise the skills</td>
        <td style="font-family: 'Barlow Semi Condensed', sans-serif;height: 58.75px; border-width: 1px; border-color: rgb(0, 0, 0);">Able to apply the skill without prompting</td>
        <td style="font-family: 'Barlow Semi Condensed', sans-serif;height: 58.75px; border-width: 1px; border-color: rgb(0, 0, 0);">Consistent&nbsp;</td>
        <td style="font-family: 'Barlow Semi Condensed', sans-serif;height: 58.75px; border-width: 1px; border-color: rgb(0, 0, 0);">Activity video is too short to get an understanding</td>
      </tr>
      <tr style="height: 58.75px;">
        <td style="font-family: 'Barlow Semi Condensed', sans-serif;height: 58.75px; border-width: 1px; border-color: rgb(0, 0, 0);">Significant improvement is needed in the skills area</td>
        <td style="font-family: 'Barlow Semi Condensed', sans-serif;height: 58.75px; border-width: 1px; border-color: rgb(0, 0, 0);">Being supported by an adult&nbsp;</td>
        <td style="font-family: 'Barlow Semi Condensed', sans-serif;height: 58.75px; border-width: 1px; border-color: rgb(0, 0, 0);">Shows an increasing understanding</td>
        <td style="font-family: 'Barlow Semi Condensed', sans-serif;height: 58.75px; border-width: 1px; border-color: rgb(0, 0, 0);">Consistently be able to apply independently</td>
        <td style="font-family: 'Barlow Semi Condensed', sans-serif;height: 58.75px; border-width: 1px; border-color: rgb(0, 0, 0);">Exceptional mastery</td>
        <td style="font-family: 'Barlow Semi Condensed', sans-serif;height: 58.75px; border-width: 1px; border-color: rgb(0, 0, 0);">The video is edited or support being given outside the area of video</td>
      </tr>
      <tr style="height: 39.1667px;">
        <td style="font-family: 'Barlow Semi Condensed', sans-serif;height: 39.1667px; border-width: 1px; border-color: rgb(0, 0, 0);">&nbsp;</td>
        <td style="font-family: 'Barlow Semi Condensed', sans-serif;height: 39.1667px; border-width: 1px; border-color: rgb(0, 0, 0);">Is at the early stages of acquisition of this skill</td>
        <td style="font-family: 'Barlow Semi Condensed', sans-serif;height: 39.1667px; border-width: 1px; border-color: rgb(0, 0, 0);">Frequently is able to apply independently</td>
        <td style="font-family: 'Barlow Semi Condensed', sans-serif;height: 39.1667px; border-width: 1px; border-color: rgb(0, 0, 0);">&nbsp;</td>
        <td style="font-family: 'Barlow Semi Condensed', sans-serif;height: 39.1667px; border-width: 1px; border-color: rgb(0, 0, 0);">Able to extend to higher level concepts using the skill being assessed for</td>
        <td style="font-family: 'Barlow Semi Condensed', sans-serif;height: 39.1667px; border-width: 1px; border-color: rgb(0, 0, 0);">&nbsp;</td>
      </tr>
      <tr style="height: 39.1667px;">
        <td style="font-family: 'Barlow Semi Condensed', sans-serif;height: 39.1667px; border-width: 1px; border-color: rgb(0, 0, 0);">&nbsp;</td>
        <td style="font-family: 'Barlow Semi Condensed', sans-serif;height: 39.1667px; border-width: 1px; border-color: rgb(0, 0, 0);">Occasionally is able to apply the skill independently</td>
        <td style="font-family: 'Barlow Semi Condensed', sans-serif;height: 39.1667px; border-width: 1px; border-color: rgb(0, 0, 0);">Comprehends the skill but is unable to fully complete the skill</td>
        <td style="font-family: 'Barlow Semi Condensed', sans-serif;height: 39.1667px; border-width: 1px; border-color: rgb(0, 0, 0);">&nbsp;</td>
        <td style="font-family: 'Barlow Semi Condensed', sans-serif;height: 39.1667px; border-width: 1px; border-color: rgb(0, 0, 0);">&nbsp;</td>
        <td style="font-family: 'Barlow Semi Condensed', sans-serif;height: 39.1667px; border-width: 1px; border-color: rgb(0, 0, 0);">&nbsp;</td>
      </tr>
    </tbody>
  </table>
  <p style="page-break-after: always"></p>
  {!! $data['data'] !!}

  <style>
    body {
      font-family: 'Barlow Semi Condensed', sans-serif;
    }
  </style>
</body>

</html>