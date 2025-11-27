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
  </style>
</head>

<body style="font-family: 'Barlow Semi Condensed', sans-serif !important;">
<header>
    <img src="C:\Apache24\htdocs\Elina ISMS\v1\web\public\images/report_header.JPG" alt="" style="width: 100%;height:17%" id="img_logo">
  </header>

  <footer>
    <img src="C:\Apache24\htdocs\Elina ISMS\v1\web\public\images/report_footer.JPG" alt="" style="width: 100%;">
  </footer>

  <p style="text-align: center;font-size: 20px;font-family: Barlow !important"> <strong> Recommendation Report </strong></p>
  @foreach($pages as $page)
  <div class="col-12">
    <div class="content" id="content-{{$page['page']}}">
      <div class="page">

        @if($page['page'] == 2)
        <img style="display: block; margin-left: auto; margin-right: auto;" src="{{Config::get('setting.base_url')}}images/chain_image.JPG" width="566" height="72">
        <div class="tinymce-body" style="font-family: 'Barlow'">{!! $page['page_description'] !!}</div>
        <!-- components -->
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
      <!-- <p style="page-break-after: always;"></p> -->
      @endif
      <div class="tinymce-body">{!! $page['page_description'] !!}</div>
      @endif

      @if($page['page'] == 3)
      <img style="display: block;margin-right: auto;margin-left: 25%;width: 50%;height:50%" src="{{Config::get('setting.base_url')}}images/Circle.JPG" width="550" height="350">
      <p style="page-break-after: always;"></p>
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
                <td width="40%" style="font-family: Barlow !important;font-size: 18px;background: white;border: 1px solid #0e0e0e !important;">
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
      <!-- Page 8 -->
      <div class="col-12 scrollable fixTableHead title-padding" id="page7" /*style="page-break-inside: avoid;border: 1px solid #0e0e0e !important;*/">
        <div class="table-responsive">
          <table class="table table-bordered" id="main2" style="width: 100%;border-spacing: 0px;border-collapse: collapse;">
            <thead>
              <tr>
                <th style="font-family: Barlow !important;padding:4px;font-size: 20px;border: 1px solid #040404 !important;color: #141414;background-color: white !important;">Areas</th>
                <th style="font-family: Barlow !important;padding:4px;font-size: 20px;border: 1px solid #040404 !important;color: #141414;background-color: white !important;" colspan="6">Factors</th>
              </tr>
            </thead>

            @php $iteration = 0; @endphp

            @foreach($areas as $table7)
            <tbody style="page-break-inside: avoid;">
              @php $iteration = $iteration+1; @endphp
              <tr id="row2" class="table_column{{$iteration}}" style="border: 1px solid #0e0e0e !important;border-collapse: collapse;">
                <td style="font-weight:bold;color:blue; font-family: Barlow !important;background-color:orange !important; background: white;border-collapse: collapse;border: 1px solid #0e0e0e !important;font-size: 18px;">{{ $table7['area_name']}}</td>

                @php $sub_iteration = 0; @endphp
                @foreach($page7 as $factors)
                @if($factors['recommendation_detail_area_id']==$table7['recommendation_detail_area_id'])
                @php $sub_iteration = $sub_iteration+1; @endphp
                <td style="font-family: Barlow !important;padding:4px;font-size: 18px;background-color:orange !important;background: white;border: 1px solid #0e0e0e !important;border-collapse: collapse !important;" id="table_column{{$iteration}}">{{ $factors['factor_name']}}</td>
                @endif
                @if($loop->last)
                @for($i = $sub_iteration; $i < $page7Max ; $i++) <td style="padding:4px;font-size: 18px;border-right: 1px solid #0e0e0e !important;background: white;border: 1px solid #0e0e0e !important;border-collapse: collapse !important;" id="table_column{{$iteration}}">
                  </td>
                  @endfor
                  @endif
                  @endforeach
              </tr>
              <!--  -->
              <tr id="row2" class="table_column{{$iteration}}" style="padding:4px;font-size: 18px;border-right: 1px solid #0e0e0e !important;border: 1px solid #0e0e0e !important;border-collapse: collapse;">
                <td style="font-family: Barlow !important;padding:4px;font-size: 18px;background: white;border-right: 1px solid #0e0e0e !important;border: 1px solid #0e0e0e !important;border-collapse: collapse;"></td>
                @foreach($page7 as $factors)
                @if($factors['recommendation_detail_area_id']==$table7['recommendation_detail_area_id'])

                <td style="font-family: Barlow !important;padding:4px;font-size: 18px;background: white;border-right: 1px solid #0e0e0e !important;border: 1px solid #0e0e0e !important;border-collapse: collapse !important;" id="table_column{{$iteration}}">{{ $factors['detail']}}</td>
                @endif
                @if($loop->last)
                @for($i = $sub_iteration; $i < $page7Max ; $i++) <td style="font-size: 18px;background: white;border-right: 1px solid #0e0e0e !important;border: 1px solid #0e0e0e !important;border-collapse: collapse !important;" id="table_column{{$iteration}}">
                  </td>
                  @endfor
                  @endif
                  @endforeach
              </tr>
              <!--  -->
            </tbody>
            @endforeach

          </table>
        </div>
      </div>
      <!-- End 8 -->
      @endif
    </div>
  </div>
  @endforeach
  <style>
    body {
      font-family: 'Barlow Semi Condensed', sans-serif;
    }
  </style>
</body>

</html>