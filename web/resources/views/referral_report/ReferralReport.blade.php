<html>

<head>
  <style>
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

  <div id="reportDiv">

    <p style="text-align: center;font-size: 20px;"> <strong> Referral Report </strong></p>
    <div class="col-12 scrollable fixTableHead title-padding">
      <div class="table-responsive">
        <table class="table table-bordered card-body" style="width: 100%;border-spacing: 0px;border-collapse: collapse;">
          <tbody>
            <tr>
              <td style="font-weight:bold !important; font-size:16pt;font-family: 'Barlow Condensed';padding:5px; background: white;vertical-align: initial;text-align:left">{{$Mdata['child_name']}}</td>
              <td style="font-weight:bold !important; font-size:16pt;font-family: 'Barlow Condensed';padding:5px; background: white;vertical-align: initial;text-align:right">Date of Reporting : {{ date('d M Y', strtotime($Mdata['dor'])) }}</td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
    <div class="page">
      <div class="tinymce-body">{!! $report[0]['meeting_description'] !!}</div>
      <div id="table">
        <div class="table-responsive">
          <table class="table table-bordered card-body" id="main" style="width: 100%;border-spacing: 0px;border-collapse: collapse;">
            <thead>
              <tr>
                <th width="50%" style="border: 1px solid #040404 !important;color: #141414;background-color: white !important;">Recommendation</th>
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
              <tr class="recommendation_row" style="page-break-inside: avoid;" data-is_clone="true">
                @else
              <tr class="recommendation_row" style="page-break-inside: avoid;">
                @endif


                @if (!in_array($data['recomendation_id'], $ro1))
                <td rowspan="{{$rowS}}" id="recommendation{{$data['recomendation_id']}}" style="font-size:18px !important; font-family: 'Barlow Condensed', sans-serif !important;white-space: pre-line;background: white;border: 1px solid #0e0e0e !important;">{!! $data['recommendation'] !!}</td>
                @php
                array_push($ro1, $data['recomendation_id']);
                @endphp
                @else
                @php
                $ddc++;
                $rowS_1 = $data['recomendation_id'] .'_'.$ddc ;
                @endphp
                @endif

                {{-- <td id="recommendation{{$data['recomendation_id']}}" style="font-size:14px !important;font-family: 'Barlow Condensed', sans-serif !important;background: white;border: 1px solid #0e0e0e !important;">
                {{$data['recommendation']}}
                </td> --}}

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
                <td style="font-size:18px !important;font-family: 'Barlow Condensed', sans-serif !important;align-items: center;background: white;border: 1px solid #0e0e0e !important;white-space: pre-line;">{{$row['frequency']}}
                </td>
              </tr>
              @endif
              @endforeach
              @endforeach
            </tbody>
          </table>
        </div>
      </div>
      <!-- Sign -->
      <div class="col-12 scrollable fixTableHead title-padding" id="page14">
        <div class="table-responsive">
          <table class="table table-bordered card-body" style="width: 100%;border-spacing: 0px;border-collapse: collapse;">
            <tbody>
              <tr>
                <td>
                  <div style="line-height: 0.5 !important;">{!! $Mdata['signature'][1] !!}</div>
                </td>
                <td>
                  <div style="line-height: 0.5 !important;">{!! $Mdata['signature'][2] !!}</div>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
      <div>
        <p><span style="font-family: 'Barlow Condensed', sans-serif;">*Referrals given by Elina are background checked from our capacity and are matched to the profile of the child and Family. However, we strongly recommend that the parents remain highly vigilant in case of any one on one sessions to ensure safety of the child in any environment they are part of.</span></p>
      </div>
      <!-- Sign End -->
    </div>
  </div>
  <form method="post" action="{{ route('referral.report.render' , \Crypt::encrypt($Mdata['report_id'])) }}" id="submitForm">
    <input type="hidden" name="report" id="report">
    <input type="hidden" name="email" id="email" value="{{$Mdata['email']}}">
    <input type="hidden" name="data" id="data" value="<?= \Crypt::encrypt($Mdata) ?>">
  </form>
</body>
<!-- <script>
  // $(".loader").show();
  document.addEventListener("DOMContentLoaded", function() {
    const tdElements = document.querySelectorAll('td');
    tdElements.forEach(td => {
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
    var htmlContent = document.getElementById('reportDiv').innerHTML;
    console.log(htmlContent);
    document.getElementById('report').value = htmlContent;
    console.log(document.getElementById('report').value);
    document.getElementById('submitForm').submit();
  });
</script> -->
<!-- <script>
  document.addEventListener("DOMContentLoaded", function() {
    const tdElements = document.querySelectorAll('td');
    tdElements.forEach(td => {
      const content = td.innerHTML.trim();
      if (content.length > 200) {
        const contentArray = content.split(' ');
        const halfIndex = Math.ceil(contentArray.length / 2);
        const newRow = td.parentNode.cloneNode(true);
        const newTds = newRow.querySelectorAll('td');
        newTds[1].innerHTML = contentArray.slice(halfIndex).join(' ');
        td.innerHTML = contentArray.slice(0, halfIndex).join(' ');
        const tbody = td.closest('tbody');
        tbody.insertBefore(newRow, td.parentNode.nextSibling);
      }
    });
  });
</script> -->
<script>
  function findNearestClosingTagIndex(htmlString, index) {
    let stack = [];
    for (let i = index; i < htmlString.length; i++) {
      if (htmlString[i] === '<') {
        if (htmlString[i + 1] === '/') {
          let tagName = '';
          for (let j = i + 2; j < htmlString.length; j++) {
            if (htmlString[j] === '>') {
              break;
            }
            tagName += htmlString[j];
          }
          if (stack.length > 0 && stack[stack.length - 1] === tagName) {
            stack.pop();
          } else {
            return i; // Return the index of the closing tag
          }
        } else {
          let tagName = '';
          for (let j = i + 1; j < htmlString.length; j++) {
            if (htmlString[j] === '>' || htmlString[j] === ' ') {
              break;
            }
            tagName += htmlString[j];
          }
          stack.push(tagName);
        }
      }
    }
    return -1; // No matching closing tag found
  }


  // document.addEventListener("DOMContentLoaded", function() {
  //   const tdElements = document.querySelectorAll('td');
  //   tdElements.forEach(td => {
  //     var content = td.innerHTML.trim();
  //     content = content.replace(/></g, '> <');
  //     const tdLength = td.offsetHeight;
  //     // if (tdLength > 250 && content.length > 50) {
  //     //   console.log(content);
  //     //   const contentArray = content.split(' ');
  //     //   const halfIndex = Math.ceil(contentArray.length / 2);

  //     //   var secondArray = contentArray.slice(halfIndex).join(' ');
  //     //   // console.log( secondArray);
  //     //   // 
  //     //   // var htmlArray = secondArray.split('><').join('> <');
  //     //   var htmlArray = secondArray;
  //     //   // console.log( htmlArray);
  //     //   htmlArray = htmlArray.split(/\s+|\n/);
  //     //   // console.log(htmlArray);
  //     //   var closingTags = ['</p>', '</li>', '</ul>'];
  //     //   var minIndex = Infinity;
  //     //   var firstClosingTag = '';
  //     //   // console.log(htmlArray.length);
  //     //   for (var i = 0; i < htmlArray.length; i++) {
  //     //     // for (var j = 0; j < closingTags.length; j++) {
  //     //     // var index = htmlArray[i].indexOf(closingTags[j]);
  //     //     // if (index !== -1 && index < minIndex) {
  //     //     //   minIndex = index;
  //     //     //   firstClosingTag = closingTags[j];
  //     //     // }
  //     //     // }

  //     //     const isInArray = closingTags.includes(htmlArray[i]);
  //     //     if (isInArray == true && i < minIndex) {
  //     //       minIndex = i;
  //     //       // break;
  //     //     }
  //     //   }
  //     //   // console.log("First closing tag :", firstClosingTag, "at index", minIndex);
  //     //   var secondArrayIndex = halfIndex + minIndex;
  //     //   // console.log(secondArray);
  //     //   // var match = secondArray.match(/<\/(li|ul|p)>/i);
  //     //   // if (match) {
  //     //   //   // console.log(match);
  //     //   //   // console.log(secondArray.indexOf(match[0]));
  //     //   //   var secondArrayIndex = halfIndex + secondArray.indexOf(match[0]);
  //     //   //   console.log(halfIndex, secondArrayIndex, secondArrayIndex + 1);
  //     //   // }

  //     //   const newRow = td.parentNode.cloneNode(true);
  //     //   const newTds = newRow.querySelectorAll('td');
  //     //   newTds[1].innerHTML = contentArray.slice(secondArrayIndex).join(' ');
  //     //   td.innerHTML = contentArray.slice(0, secondArrayIndex).join(' ');
  //     //   const tbody = td.closest('tbody');
  //     //   tbody.insertBefore(newRow, td.parentNode.nextSibling);
  //     // }
  //   });
  //   var htmlContent = document.getElementById('reportDiv').innerHTML;
  //   // console.log(htmlContent);
  //   document.getElementById('report').value = htmlContent;
  //   // console.log(document.getElementById('report').value);
  //   document.getElementById('submitForm').submit();
  // });
</script>
<script>
  document.addEventListener("DOMContentLoaded", function() {
    const tdElements = document.querySelectorAll('td[rowspan]');
    tdElements.forEach(tdElement => {
      const rowspan = parseInt(tdElement.getAttribute('rowspan'));

      if (!isNaN(rowspan) && rowspan > 1) {
        const content = tdElement.textContent.trim();
        const contentLines = content.split('\n');
        const partSize = Math.ceil(contentLines.length / rowspan);
        const parts = [];
        for (let i = 0; i < rowspan; i++) {
          const startIdx = i * partSize;
          const endIdx = startIdx + partSize;
          const partContent = contentLines.slice(startIdx, endIdx).join('\n');
          const divElement = document.createElement('div');
          divElement.classList.add('recommendation_content');
          divElement.textContent = partContent;
          parts.push(divElement);
        }
        tdElement.innerHTML = '';
        parts.forEach(part => {
          tdElement.appendChild(part);
        });
      }
    });

    var htmlContent = document.getElementById('reportDiv').innerHTML;
    // console.log(htmlContent);
    document.getElementById('report').value = htmlContent;
    // console.log(document.getElementById('report').value);
    document.getElementById('submitForm').submit();
  });
</script>

</html>