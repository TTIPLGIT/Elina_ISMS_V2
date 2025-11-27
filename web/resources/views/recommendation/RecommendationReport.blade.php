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
  <div id="reportDiv" style="width: 1300px;margin: 0;">
    <div>
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
                    <th width="20%" style="font-family: Barlow !important;font-size: 20px;padding:4px;border: 1px solid #040404 !important;color: #141414;background-color: white !important;"> Components in the process of learning </th>
                    <th width="80%" style="font-family: Barlow !important;font-size: 20px;padding:4px;border: 1px solid #040404 !important;color: #141414;background-color: white !important;"> Recommendations based on child's strength </th>
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
                    <th width="20%" style="font-family: 'Barlow Condensed', sans-serif !important;padding:4px;font-size: 20px;border: 1px solid #040404 !important;color: #141414;background-color: white !important;">Areas </th>
                    <th width="40%" style="font-family: 'Barlow Condensed', sans-serif !important;padding:4px;font-size: 20px;border: 1px solid #040404 !important;color: #141414;background-color: white !important;">Strength</th>
                    <th width="40%" style="font-family: 'Barlow Condensed', sans-serif !important;padding:4px;font-size: 20px;border: 1px solid #040404 !important;color: #141414;background-color: white !important;">Recommendation strategies and Environment </th>
                    <!-- <th style="border: 1px solid #040404 !important;color: #141414;background-color: white !important;">Some strategies recommended</th> -->
                  </tr>
                </thead>
                <tbody id="memoryTable">
                  @foreach($page6 as $table6)
                  @php $rr = explode('_', $table6['recommended_enviroment']); @endphp
                  <tr id="row">
                    <td class="excTD" width="20%" style="font-family: 'Barlow Condensed', sans-serif !important;padding:4px;font-size: 18px;background: white;border: 1px solid #0e0e0e !important;text-align:center;font-weight:bold">{{$table6['area_name']}}</td>
                    <td class="excTD" width="20%" style="white-space: pre-line;font-family: Barlow !important;padding:4px;font-size: 18px;background: white;border: 1px solid #0e0e0e !important;">
                      <p>{!! $table6['strengths'] !!}</p>
                    </td>
                    <td class="excTD page6-td" width="60%" style="/*white-space: pre-line;*/font-family: 'Barlow Condensed', sans-serif !important;font-size: 18px;background: white;border: 1px solid #0e0e0e !important;">@if($table6['recommended_enviroment'] != '' || $table6['recommended_enviroment'] != null)
                      <!-- @foreach($rr as $r)
                      <p class="p-tag page6-td-p"> {!! $r !!}</p>
                      @endforeach -->
                      <p class="p-tag page6-td-p">{!! nl2br(e($table6['recommended_enviroment'])) !!}</p>

                      @endif
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
          <div class="col-12 scrollable fixTableHead title-padding" id="page4">
            <div class="table-responsive">
              <table class="table table-bordered card-body" id="main" style="width: 100%;border-spacing: 0px;border-collapse: collapse;">
                <thead>
                  <tr>
                    <th width="20%" style="font-family: Barlow !important;padding:4px;font-size: 20px;border: 1px solid #040404 !important;color: #141414;background-color: yellow !important;">Tier</th>
                    <th width="20%" style="font-family: Barlow !important;padding:4px;font-size: 20px;border: 1px solid #040404 !important;color: #141414;background-color: yellow !important;">Focus Area</th>
                    <th width="30%" style="font-family: Barlow !important;padding:4px;font-size: 20px;border: 1px solid #040404 !important;color: #141414;background-color: yellow !important;">Key Strategies</th>
                    <th width="30%" style="font-family: Barlow !important;padding:4px;font-size: 20px;border: 1px solid #040404 !important;color: #141414;background-color: yellow !important;">Intended Outcomes</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach ($tiers as $tierIndex => $tier)
                  @php $focusCount = count($tier['focus_areas'] ?? []); @endphp
                  @foreach ($tier['focus_areas'] ?? [] as $focusIndex => $focus)
                  <tr>
                    @if ($focusIndex == 0)
                    <td rowspan="{{ $focusCount }}" style="text-align:center;font-family: Barlow !important;padding:4px;font-size: 18px;background: white;border: 1px solid #0e0e0e !important;border-collapse: collapse !important;">{{ $tier['name'] }}</td>
                    @endif
                    <td style="text-align:center;font-family: Barlow !important;padding:4px;font-size: 18px;background: white;border: 1px solid #0e0e0e !important;border-collapse: collapse !important;">{{ $focus['name'] }}</td>
                    <td style="text-align:center;font-family: Barlow !important;padding:4px;font-size: 18px;background: white;border: 1px solid #0e0e0e !important;border-collapse: collapse !important;">{!! nl2br(e($focus['detail']['key_strategies'] ?? '')) !!}</td>
                    <td style="text-align:center;font-family: Barlow !important;padding:4px;font-size: 18px;background: white;border: 1px solid #0e0e0e !important;border-collapse: collapse !important;">{!! nl2br(e($focus['detail']['intended_outcomes'] ?? '')) !!}</td>
                  </tr>
                  @endforeach
                  @endforeach
                </tbody>
              </table>
            </div>
          </div>
          @endif
          @if($page['page'] == 5)
          <div class="col-12 scrollable fixTableHead title-padding" id="page7" /*style="page-break-inside: avoid;border: 1px solid #0e0e0e !important;*/">
            <div class="table-responsive" id="appendTable">
              @foreach($areas as $table7)
              <table class="table table-bordered card-body" id="main" style="width: 100%;border-spacing: 0px;border-collapse: collapse;">
                <thead>
                  <tr>
                    <th colspan="2" style="font-family: Barlow !important;padding:0 !important;font-size: 20px;border: 1px solid #040404 !important;color: #141414;background-color: #0000ff63 !important;">Area : {{ $table7['area_name']}}
                      <table width="100%" style="border-collapse: collapse;">
                        <tr>
                          <th width="25%" style="font-family: Barlow !important;padding:4px;font-size: 20px;border: 1px solid #040404 !important;color: #141414;background-color: yellow !important;">Factors</th>
                          <th width="75%" style="font-family: Barlow !important;padding:4px;font-size: 20px;border: 1px solid #040404 !important;color: #141414;background-color: yellow !important;">Observation</th>
                        </tr>
                      </table>
                    </th>
                  </tr>
                </thead>
                <tbody>
                  @foreach($page7 as $factors)
                  @if($factors['recommendation_detail_area_id']==$table7['recommendation_detail_area_id'])
                  <tr>
                    <td width="25%" style="font-weight:bold;text-align:center;font-family: Barlow !important;padding:4px;font-size: 18px;background-color:orange !important;background: white;border: 1px solid #0e0e0e !important;border-collapse: collapse !important;">{{ $factors['factor_name']}}</td>
                    <td width="75%" style="font-family: Barlow !important;padding:4px;font-size: 18px;background: white;border-right: 1px solid #0e0e0e !important;border: 1px solid #0e0e0e !important;border-collapse: collapse !important;">{!! $factors['detail'] !!}</td>
                  </tr>
                  @endif
                  @endforeach
                </tbody>
              </table>
              @endforeach
            </div>

          </div>
          @endif
          @if($page['page'] == 6)
          <!-- Sign -->
          <div class="col-12 scrollable fixTableHead title-padding" id="page14">
            <div class="table-responsive">
              <table class="table table-bordered card-body" style="width: 100%;border-spacing: 0px;border-collapse: collapse;">
                <tbody>
                  <tr>
                    @if(isset($data['signature'][1]))
                    <td style="font-size:16pt;font-family: 'Barlow Condensed';padding:5px; background: white;vertical-align: initial;text-align:left">{!! $data['signature'][1] !!}
                      @else
                    <td style="font-size:16pt;font-family: 'Barlow Condensed';padding:5px; background: white;vertical-align: initial;text-align:left">
                      @endif
                    </td>
                    @if(isset($data['signature'][2]))
                    <td style="font-size:16pt;font-family: 'Barlow Condensed';padding:5px; background: white;vertical-align: initial;text-align:left">{!! $data['signature'][2] !!}
                      @else
                    <td style="font-size:16pt;font-family: 'Barlow Condensed';padding:5px; background: white;vertical-align: initial;text-align:left">
                      @endif
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
          <!-- Sign End -->
          <div>
            <p><span style="font-size:18px; font-family: 'Barlow Condensed', sans-serif;"><strong>Date of Reporting : {{ date('d M Y', strtotime($data['dor'])) }}&nbsp;</strong></span></p>
          </div>
          @endif
        </div>
      </div>
      @endforeach
    </div>
    <div>
      <form method="post" action="{{ route('recommendation.report.render' , \Crypt::encrypt($data['report_id'])) }}" id="submitForm">
        <input type="hidden" name="report" id="report">
        <input type="hidden" name="email" id="email" value="{{$data['email']}}">
        <input type="hidden" name="data" id="data" value="<?= \Crypt::encrypt($data) ?>">
      </form>
</body>

<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>
<script>
  function setZoomTo100() {
    // Method 1: Using CSS transform property
    document.body.style.transform = 'scale(1)';
    document.body.style.transformOrigin = '0 0';

    // Method 2: Using window.devicePixelRatio
    document.body.style.zoom = 1 / window.devicePixelRatio;

    // Method 3: Using Meta Tag for responsive design
    var metaTag = document.createElement('meta');
    metaTag.name = 'viewport';
    metaTag.content = 'width=device-width, initial-scale=1.0';
    document.getElementsByTagName('head')[0].appendChild(metaTag);
  }

  setZoomTo100();
</script>
<script>
  $(document).ready(function() {
    var ul = $('ul');
    ul.find('li').each(function() {
      $(this).wrap('<p class="newp" style="margin: 0px;"></p>').after('<ul class="newUL" style="margin: 0px;">').next().append($(this));
    });
  });
</script>
<!-- 
<script>
  function setFontSize() {
    var currentFontSize = 1366 / 100 * 1.6;
    // console.log('window.innerWidth',window.innerWidth);
    // console.log('currentFontSize',currentFontSize);
    var page6Paragraphs = document.querySelectorAll('.page6-td-p');
    page6Paragraphs.forEach(function(paragraph) {
      paragraph.style.fontSize = currentFontSize + 'px';
    });
  }

  
    setFontSize();
  
  
  window.addEventListener('resize', setFontSize);
</script> -->


<script>
  document.addEventListener("DOMContentLoaded", function() {
    const tdElements = document.querySelectorAll('td:not(.excTD)');

    tdElements.forEach(td => {
      var content = td.innerHTML.trim();
      content = content.replace(/></g, '> <');
      content = content.replace(/<p>/g, '<p class="NewPara">');
      const tdLength = td.offsetHeight;

      if (tdLength > 360 && content.length > 50) {
        // New
        const paragraphs = content.split('<p ');
        var tempElement = td.parentNode.cloneNode(true);
        var tempElementsecondChild = tempElement.querySelectorAll('td')[1];
        tempElementsecondChild.innerHTML = '';
        // 
        var tempElement1 = td.parentNode.cloneNode(true);
        var tempElementsecondChild1 = tempElement1.querySelectorAll('td')[1];
        tempElementsecondChild1.innerHTML = '';
        // 
        var tempMemory;
        var orderTr = [];
        var tempElement1remaining;

        paragraphs.forEach((paragraph, index) => {
          const paragraphHTML = `<p ${paragraph}`;

          tempMemory = tempElementsecondChild.innerHTML;
          tempElementsecondChild.innerHTML += paragraphHTML;

          const tempbody = td.closest('tbody');
          tempbody.appendChild(tempElement);
          if (tempElement.offsetHeight > 360 || index === paragraphs.length - 1) {
            const newRow = td.parentNode.cloneNode(true);
            const newTds = newRow.querySelectorAll('td');
            newTds[1].innerHTML = tempElementsecondChild.innerHTML;
            orderTr.push(newRow);
            tempElementsecondChild.innerHTML = '';
            if (index === paragraphs.length - 1) {
              tempbody.removeChild(tempElement);
            }
          }
        });

        // console.log('orderTr', orderTr);
        for (var order = orderTr.length; order > 0; order--) {
          orderRow = orderTr[order - 1];
          const tbody = td.closest('tbody');
          tbody.insertBefore(orderRow, td.parentNode.nextSibling);
        }

        const parentTr = td.parentNode;
        parentTr.style.display = 'none';
        parentTr.classList.add('hide');
        // 
      }
    });

    // 
    var maxHeight = 360;
    processRows(maxHeight);

    //
    const pageDiv = document.getElementById("page4");
    const table = pageDiv.querySelector("table");
    const tbody = table.querySelector("tbody");
    const thead = table.querySelector("thead");

    const rows = Array.from(tbody.querySelectorAll("tr"));
    pageDiv.innerHTML = ""; // clear original

    const PAGE_HEIGHT = 1122; // Approx A4 landscape px
    let currentHeight = 0;
    let activeRowspans = {}; // track remaining rowspan per column

    function createNewTable() {
      const newTable = table.cloneNode(false);
      newTable.appendChild(thead.cloneNode(true));
      const newTbody = document.createElement("tbody");
      newTable.appendChild(newTbody);
      pageDiv.appendChild(newTable);
      return newTbody;
    }

    let currentTbody = createNewTable();

    rows.forEach(row => {
      const clonedRow = row.cloneNode(true);
      const cells = Array.from(clonedRow.children);

      // Insert active rowspans for this row
      Object.keys(activeRowspans).forEach(i => {
        if (activeRowspans[i].remaining > 0) {
          const cell = document.createElement("td");
          cell.innerHTML = activeRowspans[i].content;
          cell.style.cssText = activeRowspans[i].style;
          clonedRow.insertBefore(cell, clonedRow.children[i] || null);
          activeRowspans[i].remaining--;
        }
      });

      // Update active rowspans for this row
      cells.forEach((cell, i) => {
        if (cell.rowSpan > 1) {
          activeRowspans[i] = {
            remaining: cell.rowSpan - 1,
            content: cell.innerHTML,
            style: cell.style.cssText
          };
          cell.rowSpan = 1;
        }
      });

      currentTbody.appendChild(clonedRow);
      currentHeight += clonedRow.offsetHeight;

      // Page break
      if (currentHeight > PAGE_HEIGHT) {
        currentTbody.removeChild(clonedRow);
        currentTbody = createNewTable();
        currentTbody.appendChild(clonedRow);
        currentHeight = clonedRow.offsetHeight;
      }
    });
    //  
    var htmlContent = document.getElementById('reportDiv').innerHTML;
    // console.log(htmlContent);
    document.getElementById('report').value = htmlContent;
    document.getElementById('submitForm').submit();

  });
</script>

<script>
  function splitRowContent(row, maxHeight) {
    var remainingContent = [];

    while (row.offsetHeight > maxHeight) {
      var paragraphs = row.getElementsByTagName('p');
      if (paragraphs.length > 0) {
        remainingContent.unshift(paragraphs[paragraphs.length - 1].outerHTML);
        paragraphs[paragraphs.length - 1].remove();
      } else {
        break;
      }
    }
    return remainingContent;
  }

  function processRows(maxHeight) {
    var rows = document.querySelectorAll('#memoryTable tr');
    var needsMoreSplitting = true;

    while (needsMoreSplitting) {
      needsMoreSplitting = false;

      rows.forEach(row => {
        if (row.offsetHeight > maxHeight) {
          needsMoreSplitting = true;
          var remainingContent = splitRowContent(row, maxHeight);

          if (remainingContent.length > 0) {
            var newRow = document.createElement('tr');
            var cells = row.getElementsByClassName('excTD');

            for (var i = 0; i < cells.length; i++) {
              var newCell = cells[i].cloneNode(true);
              if (i === 2) {
                newCell.innerHTML = remainingContent.join('');
              }
              newRow.appendChild(newCell);
            }
            row.parentNode.insertBefore(newRow, row.nextSibling);
          }
        }
      });
      rows = document.querySelectorAll('#memoryTable tr');
    }
  }
</script>

</html>