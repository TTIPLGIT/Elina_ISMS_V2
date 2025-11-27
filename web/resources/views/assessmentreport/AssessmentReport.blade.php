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

<body style="font-family: 'Barlow Semi Condensed', sans-serif !important;">
  <div class='loader'></div>
  <!-- Direct Template -->
  <div class="content view1" id="report1">
    <div class="page">
      @foreach($data['pages'] as $page)
      @if($page['enable_flag'] == 0)
      <div class="tinymce-body" style="font-family: 'Barlow Semi Condensed;">
        @if($page['page'] != 3 && $page['page'] != 4 && $page['page'] != 5 && $page['page'] != 6 && $page['page'] != 7 && $page['page'] != 8 && $page['page'] != 9 && $page['page'] != 10 && $page['page'] != 11 && $page['page'] != 14)
        {!! $page['page_description'] !!}
        @if($page['page'] == 1)
        <img style="display: block; margin-left: auto; margin-right: auto;" src="{{Config::get('setting.base_url')}}images/assessment_image.png" width="566">
        @endif
        @endif
        <!--  -->
        @if($page['page'] == 3)
        <!-- <p style="page-break-after: always;"></p> -->
        <p style="font-family: 'Barlow Semi Condensed;color: blue;font-weight:bold">1. CURRENT PERFORMANCE LEVEL IN 8 AREAS:</p>
        <div id="table">
          <div class="table-responsive" style="font-family: 'Barlow Semi Condensed', sans-serif;">
            <table class="table table-bordered card-body" style="width: 100%;border-spacing: 0px;border-collapse: collapse;">
              <tbody id="tablebody">
                @if($data['pages'][2]['enable_flag'] == 0)
                <tr>
                  <td width="30%" style="font-size:16pt;font-family: 'Barlow Semi Condensed;padding:5px; background: white;border: 1px solid #0e0e0e !important;vertical-align: initial;text-align:center">Physical</td>
                  <td width="80%" style="padding:5px; background: white;border: 1px solid #0e0e0e !important;">@foreach($data['pages'] as $page)
                    @if($page['page'] == 3)
                    {!! $page['page_description'] !!}
                    @endif
                    @endforeach</td>
                </tr>
                @endif
                @if($data['pages'][3]['enable_flag'] == 0)
                <tr>
                  <td width="30%" style="font-size:16pt;font-family: 'Barlow Semi Condensed;padding:5px; background: white;border: 1px solid #0e0e0e !important;vertical-align: initial;text-align:center">Gross Motor</td>
                  <td width="80%" style="padding:5px; background: white;border: 1px solid #0e0e0e !important;">@foreach($data['pages'] as $page)
                    @if($page['page'] == 4)
                    {!! $page['page_description'] !!}
                    @endif
                    @endforeach</td>
                </tr>
                @endif
                @if($data['pages'][4]['enable_flag'] == 0)
                <tr>
                  <td width="30%" style="font-size:16pt;font-family: 'Barlow Semi Condensed;padding:5px; background: white;border: 1px solid #0e0e0e !important;vertical-align: initial;text-align:center">Fine Motor</td>
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
                  <td width="30%" style="font-size:16pt;font-family: 'Barlow Semi Condensed;padding:5px; background: white;border: 1px solid #0e0e0e !important;vertical-align: initial;text-align:center">Sensory</td>
                  <td width="80%" style="padding:5px; background: white;border: 1px solid #0e0e0e !important;">@foreach($data['pages'] as $page)
                    @if($page['page'] == 6)
                    {!! $page['page_description'] !!}
                    @endif
                    @endforeach</td>
                </tr>
                @endif
                @if($data['pages'][6]['enable_flag'] == 0)
                <tr>
                  <td width="30%" style="font-size:16pt;font-family: 'Barlow Semi Condensed;padding:5px; background: white;border: 1px solid #0e0e0e !important;vertical-align: initial;text-align:center">cognition</td>
                  <td width="80%" style="padding:5px; background: white;border: 1px solid #0e0e0e !important;">@foreach($data['pages'] as $page)
                    @if($page['page'] == 7)
                    {!! $page['page_description'] !!}
                    @endif
                    @endforeach</td>
                </tr>
                @endif
                @if($data['pages'][7]['enable_flag'] == 0)
                <tr>
                  <td width="30%" style="font-size:16pt;font-family: 'Barlow Semi Condensed;padding:5px; background: white;border: 1px solid #0e0e0e !important;vertical-align: initial;text-align:center">Speech and Communication</td>
                  <td width="80%" style="padding:5px; background: white;border: 1px solid #0e0e0e !important;">@foreach($data['pages'] as $page)
                    @if($page['page'] == 8)
                    {!! $page['page_description'] !!}
                    @endif
                    @endforeach</td>
                </tr>
                @endif
                @if($data['pages'][8]['enable_flag'] == 0)
                <tr>
                  <td width="30%" style="font-size:16pt;font-family: 'Barlow Semi Condensed;padding:5px; background: white;border: 1px solid #0e0e0e !important;vertical-align: initial;text-align:center">Social and Emotional</td>
                  <td width="80%" style="padding:5px; background: white;border: 1px solid #0e0e0e !important;">@foreach($data['pages'] as $page)
                    @if($page['page'] == 9)
                    {!! $page['page_description'] !!}
                    @endif
                    @endforeach</td>
                </tr>
                @endif
                @if($data['pages'][9]['enable_flag'] == 0)
                <tr>
                  <td width="30%" style="font-size:16pt;font-family: 'Barlow Semi Condensed;padding:5px; background: white;border: 1px solid #0e0e0e !important;vertical-align: initial;text-align:center">Play</td>
                  <td width="80%" style="padding:5px; background: white;border: 1px solid #0e0e0e !important;">@foreach($data['pages'] as $page)
                    @if($page['page'] == 10)
                    {!! $page['page_description'] !!}
                    @endif
                    @endforeach</td>
                </tr>
                @endif
                @if($data['pages'][10]['enable_flag'] == 0)
                <tr>
                  <td width="30%" style="font-size:16pt;font-family: 'Barlow Semi Condensed;padding:5px; background: white;border: 1px solid #0e0e0e !important;vertical-align: initial;text-align:center">ADLs</td>
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
      @if($page['page'] == 13)
      <!-- Sign -->
      <div class="col-12 scrollable fixTableHead title-padding" id="page14">
        <div class="table-responsive">
          <table class="table table-bordered card-body" style="width: 100%;border-spacing: 0px;border-collapse: collapse;">
            <tbody>
              <tr>
                <td style="font-size:16pt;font-family: 'Barlow Semi Condensed;padding:5px; background: white;vertical-align: initial;text-align:left">{!! $data['signature'][1] !!}
                </td>
                <td style="font-size:16pt;font-family: 'Barlow Semi Condensed;padding:5px; background: white;vertical-align: initial;text-align:left">{!! $data['signature'][2] !!}
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
      <!-- Sign End -->
      @endif
      @endforeach
    </div>
  </div>
  <!--  -->
  <form method="post" action="{{ route('assessment.report.preview' , \Crypt::encrypt($data['report_id'])) }}" id="submitForm">
    <input type="hidden" name="executive_report" id="executive_report">
    <input type="hidden" name="email" id="email" value="{{$data['email']}}">
    <input type="hidden" name="data" id="data" value="<?= \Crypt::encrypt($data) ?>">
  </form>
</body>
<script>
  // $(".loader").show();
  function countWords(text) {
    return text.split(/\s+/).length;
  }

  // document.addEventListener('DOMContentLoaded', function() {
  //   const table = document.querySelector('table');
  //   const rows = table.querySelectorAll('tr');

  //   rows.forEach(row => {
  //     const cells = row.querySelectorAll('td');
  //     cells.forEach(cell => {
  //       const words = countWords(cell.textContent);
  //       if (words > 400) {
  //         let contentArray = cell.textContent.split(' ');
  //         let firstPart = contentArray.slice(0, 400).join(' ');
  //         let remainingPart = contentArray.slice(400).join(' ');

  //         cell.textContent = firstPart;

  //         while (remainingPart) {
  //           const newRow = document.createElement('tr');
  //           const newCell1 = document.createElement('td');
  //           const newCell2 = document.createElement('td');

  //           newCell2.textContent = remainingPart.slice(0, 400);

  //           newRow.appendChild(newCell1);
  //           newRow.appendChild(newCell2);
  //           row.parentNode.insertBefore(newRow, row.nextSibling);

  //           remainingPart = remainingPart.slice(400);
  //         }
  //       }
  //     });
  //   });

  //   // var htmlContent = document.getElementById('report1').innerHTML;
  //   // console.log(htmlContent);
  //   // document.getElementById('executive_report').value = htmlContent;
  //   // console.log(document.getElementById('executive_report').value);
  //   // document.getElementById('submitForm').submit();
  // });
  document.addEventListener("DOMContentLoaded", function() {
    const tdElements = document.querySelectorAll('td');
    tdElements.forEach(td => {
      const content = td.innerHTML.trim();
      const tdLength = td.offsetHeight;
      console.log(content, tdLength);
      if (tdLength > 410) {
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
    var htmlContent = document.getElementById('report1').innerHTML;
    // console.log(htmlContent);
    document.getElementById('executive_report').value = htmlContent;
    // console.log(document.getElementById('executive_report').value);
    document.getElementById('submitForm').submit();

  });
</script>

</html>