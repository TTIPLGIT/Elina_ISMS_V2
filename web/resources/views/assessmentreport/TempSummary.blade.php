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
            <table class="table table-bordered card-body" style="width: 100%;border-spacing: 0px;border-collapse: collapse;">
              <thead>
                <tr>
                  @if($perskills['skill_name'] != null || $perskills['skill_name'] != '')
                  <th width="20%" style="padding:4px !important;background-color:#ffc70b !important;font-weight:bold !important;font-family: Barlow !important;text-align:center;border: 1px solid #040404 !important;color: #141414;border-collapse: collapse !important;">{{$perskills['skill_name']}}</th>
                  @else
                  <th width="20%" style="padding:4px !important;background-color:#ffc70b !important;font-weight:bold !important;font-family: Barlow !important;text-align:center;border: 1px solid #040404 !important;color: #141414;border-collapse: collapse !important;">{{$page['tab_name']}}</th>
                  @endif
                  <th width="15%" style="padding:4px !important;background-color:#ffc70b !important;font-weight:bold !important;font-family: Barlow !important;text-align:center;border: 1px solid #040404 !important;color: #141414;border-collapse: collapse !important;">
                    Observation</th>
                  <th width="65%" style="padding:4px !important;background-color:#ffc70b !important;font-family: Barlow !important;text-align:center;border: 1px solid #040404 !important;color: #141414;border-collapse: collapse !important;">
                    Evidence</th>
                </tr>
              </thead>
              <tbody id="tablebody{{$page['page']}}">
                @foreach($details as $detail)
                @if($page['assessment_skill'] == $detail['performance_area_id'])
                <tr>
                <td width="20%" style="white-space: pre-line;background: white;border: 1px solid #0e0e0e !important;padding:4px !important;">@foreach($activitys as $activity) @if($page['assessment_skill'] == $activity['performance_area_id'] && $activity['skill_id'] == $perskills['skill_id'] ) @if($activity['skill_type'] == 1) @if( $detail['activity_name'] == $activity['activity_id'] ) <p style="font-weight: bold;">{{$activity['activity_name']}}</p> @endif @endif @endif @endforeach</td>
                  <td width="15%" style="background: white;border: 1px solid #0e0e0e !important;padding:4px !important;">@foreach($observations as $observation) @if( $detail['observation_name'] == $observation['observation_id'] ) <p style="font-weight: bold;">{{$observation['observation_name']}}</p> @endif @endforeach </td>
                  <td width="65%" style="white-space: pre-line;align-items: center;background: white;border: 1px solid #0e0e0e !important;font-family: Barlow !important;padding:4px !important;">{!! $detail['evidence'] !!}</td>
                </tr>
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
            <table class="table table-bordered card-body myTable{{$page['page']}}" style="width: 100%;border-spacing: 0px;border-collapse: collapse;">
              <thead>
                <tr>
                  <th colspan="3" style="background-color:#ffc70b !important;font-family: Barlow !important;text-align:center;color: #141414;text-align: left;border: 1px solid #040404 !important;border-collapse: collapse !important;">
                    {{$perskills['skill_name']}}
                  </th>
                </tr>
              </thead>
              <tbody id="tablebody_a{{$page['page']}}">
                @foreach($details2 as $detail)
                @if($page['assessment_skill'] == $detail['performance_area_id'] && $detail['cheSkill'] == $perskills['skill_id'])
                <tr>
                <td width="20%" style="background: white;border: 1px solid #0e0e0e !important;padding:4px !important;"> @foreach($activitys as $activity) @if($activity['skill_type'] == 2) @if($page['assessment_skill'] == $activity['performance_area_id']) @if( $detail['activity_name'] == $activity['activity_id'] ) <p style="font-weight: bold;">{{$activity['activity_name']}}</p> @endif @endif @endif @endforeach </td>
                  <td width="15%" style="background: white;border: 1px solid #0e0e0e !important;padding:4px !important;"> @foreach($observations as $observation) @if( $detail['observation_name'] == $observation['observation_id'] ) <p style="font-weight: bold;">{{$observation['observation_name']}}</p> @endif @endforeach </td>
                  <td width="65%" style="white-space: pre-line;font-family: Barlow !important;padding:4px !important;align-items: center !important;background: white !important;border: 1px solid #0e0e0e !important;"> {{$detail['evidence']}} </td>
                </tr>
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
            <table class="table table-bordered card-body" style="width: 100%;border-spacing: 0px;border-collapse: collapse;">
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
                  <th width="65%" style="padding:4px !important;background-color:#ffc70b !important;font-family: Barlow !important;border: 1px solid #040404 !important;color: #141414;border-collapse: collapse !important;">
                    Evidence</th>
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
        @php $f = 0; array_push($j , $detail['activity_name']); @endphp
        <div class="table-responsive" id="table_b{{$sskill['skill_id']}}" style="font-family: Barlow !important;">
          <table class="table table-bordered card-body" style="width: 100%;border-spacing: 0px;border-collapse: collapse;">
            <thead>
              <tr>
                <th colspan="3" style="background-color:#ffc70b !important;color: #141414;font-family: Barlow !important;text-align:center;border: 1px solid #040404 !important;border-collapse: collapse !important;">
                  {{$sskill['skill_name']}}
                </th>
              </tr>
            </thead>
            <tbody id="tablebody_b{{$sskill['skill_id']}}">
              @foreach($details3 as $detail)
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
                <td width="65%" style="white-space: pre-line;font-family: Barlow !important;padding:4px !important;align-items: center;background: white;border: 1px solid #0e0e0e !important;">{{$detail['evidence'] }}</td>
             </tr>
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
        <img style="display: block;margin-right: auto;margin-left: 25%;width: 50%;height:70%" src="{{asset('images/Self regulation continuum.png')}}" width="550" height="900px">
        <div style="/*border: 1px solid;*/padding: 0 4px;">
          <div style="text-align: center;font-size:20px;font-weight:bold">
            <u>
              Seeking/Seeker <br>
              Seeks out and is attracted to a stimulating sensory environment
              <br>
            </u>
          </div>
          {!! $page8['sensory_profiling1'] !!}
        </div>
        <!-- <p style="page-break-after: always"></p> -->
        <div style="/*border: 1px solid;*/padding: 0 4px;">
          <div style="text-align: center;font-size:20px;font-weight:bold">
            <u>
              Avoiding/Avoider<br>
              Distressed by a stimulating sensory environment and attempts to leave the environment
              <br>
            </u>
          </div>
          {!! $page8['sensory_profiling2'] !!}
        </div>
        <!-- <p style="page-break-after: always"></p> -->
        <div style="/*border: 1px solid;*/padding: 0 4px;">
          <div style="text-align: center;font-size:20px;font-weight:bold">
            <u>
              Sensitivity/Sensor<br>
              Distractibility, discomfort with sensory stimuli</u>
            </u>
          </div>
          <br>
          {!! $page8['sensory_profiling3'] !!}
        </div>
        <!-- <p style="page-break-after: always"></p> -->
        <div style="/*border: 1px solid;*/padding: 0 4px;">
          <div style="text-align: center;font-size:20px;font-weight:bold">
            <u>
              Registration/Bystander<br>
              Missing stimuli, responding slowly
              <br>
            </u>
          </div>
          {!! $page8['sensory_profiling4'] !!}
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
  <form method="post" action="{{ route('assessment.report.render' , \Crypt::encrypt($data['report_id'])) }}" id="submitForm">
    <input type="hidden" name="summary_report" id="summary_report">
    <input type="hidden" name="email" id="email" value="{{$data['email']}}">
    <input type="hidden" name="data" id="data" value="<?= \Crypt::encrypt($data) ?>">
  </form>
</body>
<script>
  // $(".loader").show();
  document.addEventListener("DOMContentLoaded", function() {
    const tdElements = document.querySelectorAll('td');
    tdElements.forEach(td => {
      if (td.id === 'signatureData') {
        return;
      }
      const content = td.innerHTML.trim();
      if (content.length > 200) {
        const doc = new DOMParser().parseFromString(content, 'text/html');
        const paragraphs = doc.querySelectorAll('p');
        if (paragraphs.length > 1) {
          const halfIndex = Math.ceil(paragraphs.length / 2);
          const secondPart = Array.from(paragraphs).slice(halfIndex).map(p => p.outerHTML).join('');
          const firstPart = Array.from(paragraphs).slice(0, halfIndex).map(p => p.outerHTML).join('');

          const newRow = td.parentNode.cloneNode(true);
          const newTds = newRow.querySelectorAll('td');
          newTds[1].innerHTML = secondPart;
          td.innerHTML = firstPart;

          const tbody = td.closest('tbody');
          tbody.insertBefore(newRow, td.parentNode.nextSibling);
        }
      }
    });
    var htmlContent = document.getElementById('report2').innerHTML;
    // console.log(htmlContent);
    document.getElementById('summary_report').value = htmlContent;
    // console.log(document.getElementById('summary_report').value);
    document.getElementById('submitForm').submit();
  });
</script>

</html>