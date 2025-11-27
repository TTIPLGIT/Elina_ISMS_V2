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
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
  document.addEventListener("DOMContentLoaded", function() {
    console.log('1');

    const tdElements = document.querySelectorAll('td');
    tdElements.forEach(td => {
      var content = td.innerHTML.trim();
      content = content.replace(/></g, '> <');
      const tdLength = td.offsetHeight;
      if (tdLength > 400 && content.length > 50) {
        // console.log(content);
        const contentArray = content.split(' ');
        const halfIndex = Math.ceil(contentArray.length / 2);

        var secondArray = contentArray.slice(halfIndex).join(' ');
        // console.log( secondArray);
        // 
        // var htmlArray = secondArray.split('><').join('> <');
        var htmlArray = secondArray;
        // console.log( htmlArray);
        htmlArray = htmlArray.split(/\s+|\n/);
        // console.log(htmlArray);
        var closingTags = ['</p>', '</li>', '</ul>'];
        var minIndex = Infinity;
        var firstClosingTag = '';
        // console.log(htmlArray.length);
        for (var i = 0; i < htmlArray.length; i++) {
          // for (var j = 0; j < closingTags.length; j++) {
          // var index = htmlArray[i].indexOf(closingTags[j]);
          // if (index !== -1 && index < minIndex) {
          //   minIndex = index;
          //   firstClosingTag = closingTags[j];
          // }
          // }

          const isInArray = closingTags.includes(htmlArray[i]);
          if (isInArray == true && i < minIndex) {
            minIndex = i;
            // break;
          }
        }
        // console.log("First closing tag :", firstClosingTag, "at index", minIndex);
        var secondArrayIndex = halfIndex + minIndex;
        // console.log(secondArray);
        // var match = secondArray.match(/<\/(li|ul|p)>/i);
        // if (match) {
        //   // console.log(match);
        //   // console.log(secondArray.indexOf(match[0]));
        //   var secondArrayIndex = halfIndex + secondArray.indexOf(match[0]);
        //   console.log(halfIndex, secondArrayIndex, secondArrayIndex + 1);
        // }

        const newRow = td.parentNode.cloneNode(true);
        const newTds = newRow.querySelectorAll('td');
        newTds[1].innerHTML = contentArray.slice(secondArrayIndex).join(' ');
        td.innerHTML = contentArray.slice(0, secondArrayIndex).join(' ');
        const tbody = td.closest('tbody');
        tbody.insertBefore(newRow, td.parentNode.nextSibling);
      }
    });

    var tables = $('.page7');

    tables.each(function(index, table) {
      var rows = $('table tbody tr', table);
      var thead = $('table thead', table);
      thead = thead[0];
      console.log('thead' , thead);

      var currentHeight = 0;
      var tbody = null;
      var firstTDtext;
      var thisTableSpan = 0;
      var rowspan;

      rows.each(function(index, row) {
        var rowHeight = row.offsetHeight;

        var firstTD = $('td:first', row);
        var rowspanCheck = firstTD.attr('rowspan');

        thisTableSpan = thisTableSpan + 1;
        if (rowspanCheck != undefined) {
          firstTDtext = firstTD.text();
          rowspan = firstTD.attr('rowspan');
        }

        if (currentHeight + rowHeight <= 300) {
          currentHeight += rowHeight;
          if (!tbody) {
            tbody = $('<table class="table table-bordered card-body" style="width: 100%;border-spacing: 0px;border-collapse: collapse;"> <tbody style=" page-break-before: always !important;">');
            $(table).append(tbody);
            $(table).append('<div style=" page-break-before: always;"></div>');
          }
          tbody.addClass('page7-tbody');
          tbody.append(row);
        } else {
          currentHeight = rowHeight;
          tbody = $('<table class="table table-bordered card-body" style="width: 100%;border-spacing: 0px;border-collapse: collapse;"> <tbody style=" page-break-before: always !important;">');
          $(table).append(tbody);
          $(table).append('<div style=" page-break-before: always;"></div>');

          var prevSpan = thisTableSpan - 1;
          var remainingRows = rows.length - index;
          if (remainingRows > 3) {
            var newTdRowspan = rowspan - prevSpan;
          } else {
            var newTdRowspan = remainingRows;
          }

          var newTd = $('<td rowspan="' + newTdRowspan + '" style="font-weight:bold;color:blue; font-family: Barlow !important;text-align: center;background: white;border-collapse: collapse;border: 1px solid #0e0e0e !important;font-size: 18px;">' + firstTDtext + '</td>');
          $(row).prepend(newTd);
          tbody.addClass('page7-tbody');
          tbody.append(row);
          thisTableSpan = 0;
        }
      });
    });
    var page7tables = $('.page7-tbody');
    var jj = 0;
    var jk = 0;
    page7tables.each(function(index) {
      var trCount = $(this).find('tr').length;
      var rowspanTD = $(this).find('td[rowspan]');
      if (rowspanTD.length === 1) {
        var rowspanValue = parseInt(rowspanTD.attr('rowspan'));
        // console.log(rowspanValue, trCount);
        if (rowspanValue > trCount) {
          rowspanTD.attr('rowspan', trCount);
          // console.log('  - Updated rowspan value to match <tr> elements count: ' + trCount);
        } else if (rowspanValue < trCount) {
          rowspanTD.attr('rowspan', trCount);
        }
      }
      if (rowspanTD.length > 1) {
        var firstRowspanIndex = rowspanTD.eq(0).closest('tr').index();
        var secondRowspanIndex = rowspanTD.eq(1).closest('tr').index();
        var trElementsBetween = secondRowspanIndex - firstRowspanIndex - 1; // Subtracting 1 to exclude the first <tr>
        var trElementsBetween1 = secondRowspanIndex - firstRowspanIndex;
        if (trElementsBetween > 1) {
          rowspanTD.attr('rowspan', trElementsBetween1);
        }
        // console.log('Number of <tr> elements between first and second rowspan:', trElementsBetween);
      }

      rowspanTD.each(function(tdIndex) {
        var rowspanValue = parseInt($(this).attr('rowspan'));
        var rowspanIndex = $(this).index();
        // console.log('    - Rowspan TD at index ' + rowspanIndex + ' with rowspan value ' + rowspanValue);
      });
      jj = jj + 1;
      jk = 0;
    });
  });

  $(document).ready(function() {
    console.log('2');
    var htmlContent = document.getElementById('reportDiv1').innerHTML;
    console.log(htmlContent);

    document.getElementById('report').value = htmlContent;
    // document.getElementById('submitForm').submit();
  });
</script>
</head>

<body style="font-family: 'Barlow Semi Condensed', sans-serif !important;">
  <!-- <div class='loader'></div> -->

  <div id="reportDiv1">
    <p style="text-align: center;font-size: 24px;font-family: 'Barlow Semi Condensed', sans-serif !important;"> <strong> Recommendation Report </strong></p>
    <p style="text-align: center;font-size: 24px;font-family: 'Barlow Semi Condensed', sans-serif !important;"> {{$data['child_name']}}</p>
    @foreach($pages as $page)
    <div class="col-12">
      <div class="content" id="content-{{$page['page']}}">
        <div class="page">

          @if($page['page'] == 2)
          <img style="display: block; margin-left: auto; margin-right: auto;" src="{{Config::get('setting.base_url')}}images/chain_image.JPG" width="566" height="120">
          <div class="tinymce-body">{!! $page['page_description'] !!}</div>
          <!-- components -->
          <p style="page-break-after: always;"></p>
          <div /*class="col-12 scrollable fixTableHead title-padding" */ id="page2" /*style="break-inside: avoid;page-break-inside: avoid;" * />
          <div class="table-responsive">
            <table class="table table-bordered card-body" style="width: 100%;border-spacing: 0px;border-collapse: collapse;">
              <thead>
                <tr>
                  <th width="35%" style="font-family: Barlow !important;font-size: 20px;padding:4px;border: 1px solid #040404 !important;color: #141414;background-color: white !important;"> Components in the process of learning </th>
                  <th width="65%" style="font-family: Barlow !important;font-size: 20px;padding:4px;border: 1px solid #040404 !important;color: #141414;background-color: white !important;"> Recommendations based on child's strength </th>
                </tr>
              </thead>
              <tbody>
                @foreach($components as $component)
                <tr>
                  <td style="font-family: Barlow !important;padding:4px;font-size: 18px;border: 1px solid black !important;background: white;text-align: center !important;font-weight:bold">{{$component['area_name']}}</td>
                  @isset($component['description'])
                  <td style="padding:4px;font-size: 18px;border: 1px solid black !important;background: white;">{!! $component['description'] !!}</td>
                  @else
                  <td style="padding:4px;font-size: 18px;border: 1px solid black !important;background: white;"></td>
                  @endisset
                </tr>
                @endforeach
              </tbody>
            </table>
          </div>
        </div>
        <!-- End components -->
        @else
        @if($page['page'] == 3)
        <p style="page-break-after: always;"></p>
        @endif
        <div class="tinymce-body">{!! $page['page_description'] !!}</div>
        @endif

        @if($page['page'] == 3)
        <!-- <p style="page-break-after: always;"></p> -->
        <img style="display: block;margin-right: auto;margin-left: 25%;width: 50%;height:75%" src="{{Config::get('setting.base_url')}}images/Circle.png" width="550" height="900px">
        <!-- <p style="page-break-after: always;"></p> -->
        <!-- page 6 -->
        <div class="col-12 scrollable fixTableHead title-padding" id="page6">
          <div class="table-responsive">
            <table class="table table-bordered card-body" id="main" style="width: 100%;border-spacing: 0px;border-collapse: collapse;">
              <thead>
                <tr>
                  <th width="20%" style="font-family: Barlow !important;padding:4px;font-size: 20px;border: 1px solid #040404 !important;color: #141414;background-color: white !important;">Areas </th>
                  <th width="40%" style="font-family: Barlow !important;padding:4px;font-size: 20px;border: 1px solid #040404 !important;color: #141414;background-color: white !important;">Strength</th>
                  <th width="40%" style="font-family: Barlow !important;padding:4px;font-size: 20px;border: 1px solid #040404 !important;color: #141414;background-color: white !important;">Recommendation strategies and Environment </th>
                  <!-- <th style="border: 1px solid #040404 !important;color: #141414;background-color: white !important;">Some strategies recommended</th> -->
                </tr>
              </thead>
              <tbody>
                @foreach($page6 as $table6)
                <tr id="row">
                  <td width="20%" style="font-family: Barlow !important;padding:4px;font-size: 18px;background: white;border: 1px solid #0e0e0e !important;text-align:center;font-weight:bold">{{$table6['area_name']}}</td>
                  <td width="40%" style="font-family: Barlow !important;padding:4px;font-size: 18px;background: white;border: 1px solid #0e0e0e !important;">{{$table6['strengths']}}</td>
                  <td width="40%" style="white-space: pre-line;font-family: Barlow !important;font-size: 18px;background: white;border: 1px solid #0e0e0e !important;">
                    <p id="disableselect{{$loop->iteration}}" style="font-size: 18px;padding:4px;">{{$table6['recommended_enviroment']}}</p>
                  </td>
                  <!-- <td style="background: white;border: 1px solid #0e0e0e !important;">{{$table6['strategies_command']}}</td> -->
                </tr>
                @endforeach
              </tbody>
            </table>
          </div>
        </div>
        <!-- End 6 -->
        @endif
        @if($page['page'] == 4)
        <div class="col-12 scrollable fixTableHead title-padding" id="page7" /*style="page-break-inside: avoid;border: 1px solid #0e0e0e !important;*/">
          <div class="table-responsive page7" id="appendTable">
            <table class="table table-bordered card-body" id="main" style="width: 100%;border-spacing: 0px;border-collapse: collapse;">
              <!-- <thead>
                <tr>
                  <th width="15%" style="font-family: Barlow !important;padding:4px;font-size: 20px;border: 1px solid #040404 !important;color: #141414;background-color: yellow !important;">Areas </th>
                  <th width="20%" style="font-family: Barlow !important;padding:4px;font-size: 20px;border: 1px solid #040404 !important;color: #141414;background-color: yellow !important;">Factors</th>
                  <th width="65%" style="font-family: Barlow !important;padding:4px;font-size: 20px;border: 1px solid #040404 !important;color: #141414;background-color: yellow !important;">Observation</th>
                </tr>
              </thead> -->
              @foreach($areas as $table7)
              <tbody class="areasfactor">
                @php $loopcount = 0; @endphp
                @foreach($page7 as $factors)
                @if($factors['recommendation_detail_area_id']==$table7['recommendation_detail_area_id'])

                @if($loopcount == 0)
                @php
                $recommendation_detail_area_id = $table7['recommendation_detail_area_id'];
                $filteredFactors = array_filter($page7, function($factors) use ($table7) {
                return $factors['recommendation_detail_area_id'] == $table7['recommendation_detail_area_id'];
                });
                $rowspancount = count($filteredFactors);
                @endphp
                <tr>
                  <td rowspan="{{$rowspancount}}" style="font-weight:bold;color:blue; font-family: Barlow !important;text-align: center;background: white;border-collapse: collapse;border: 1px solid #0e0e0e !important;font-size: 18px;">{{ $table7['area_name']}}</td>
                  <td style="font-family: Barlow !important;padding:4px;font-size: 18px;background-color:orange !important;background: white;border: 1px solid #0e0e0e !important;border-collapse: collapse !important;">{{ $factors['factor_name']}}</td>
                  <td style="white-space: pre-line;font-family: Barlow !important;padding:4px;font-size: 18px;background: white;border-right: 1px solid #0e0e0e !important;border: 1px solid #0e0e0e !important;border-collapse: collapse !important;">{{ $factors['detail']}}</td>
                </tr>
                @else
                <tr>
                  <td style="font-family: Barlow !important;padding:4px;font-size: 18px;background-color:orange !important;background: white;border: 1px solid #0e0e0e !important;border-collapse: collapse !important;">{{ $factors['factor_name']}}</td>
                  <td style="white-space: pre-line;font-family: Barlow !important;padding:4px;font-size: 18px;background: white;border-right: 1px solid #0e0e0e !important;border: 1px solid #0e0e0e !important;border-collapse: collapse !important;">{{ $factors['detail']}}</td>
                </tr>
                @endif

                @php $loopcount++; @endphp

                @endif
                @endforeach
              </tbody>
              @endforeach
              <!-- <tfoot>
                <tr>
                  <td colspan="3" style="text-align: center;color: red;border: 1px solid black;font-weight: bold;">End Of Report</td>
                </tr>
              </tfoot> -->
            </table>
          </div>
        </div>
        @endif
      </div>
    </div>
    @endforeach
    </div>
    </div>
    </div>
    </div>
  </div>

  <form method="post" action="{{ route('recommendation.report.render' , \Crypt::encrypt($data['report_id'])) }}" id="submitForm">
    <input type="hidden" name="report" id="report">
    <input type="hidden" name="email" id="email" value="{{$data['email']}}">
    <input type="hidden" name="data" id="data" value="<?= \Crypt::encrypt($data) ?>">
  </form>
</body>


 
</html>