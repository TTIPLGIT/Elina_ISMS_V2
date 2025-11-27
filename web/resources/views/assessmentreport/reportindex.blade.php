@extends('layouts.parent')
@section('content')
<div class="main-content">
  <!-- {{ Breadcrumbs::render('assessmentreport.index') }} -->
  <section class="section">
    <div class="section-body mt-2">
    <a id="closed_all" class="closed_all"></a>
      <div class="row">
        <div class="col-12">
          <div class="card">
            <div class="card-body">
              <div class="row">
                <div class="col-lg-12 text-center">
                  <h4 class="screen-title"> Sail Report List</h4>
                </div>
              </div>
              <div class="table-wrapper">
                <div class="table-responsive">
                  <table class="table table-bordered" id="tableList">
                    <thead>
                      <tr>
                        <!-- <th>Sl. No.</th> -->
                        <th>Report</th>
                        <th>Action</th>
                      </tr>
                    </thead>
                    <tbody>
                      @if($rows != [])
                      @php $email = $rows[0]['child_contact_email'] @endphp

                      @php
                      $folderPath = Config::get('setting.base_url').'/assessment_report/'.$email.'/Assessment_Executive_Report.pdf';
                      $folderExists = file_exists($folderPath);

                      $headers = @get_headers($folderPath);
                      $fileExists = ($headers && strpos($headers[0], '200') !== false);
                      @endphp

                      @if ($fileExists)
                      <tr>
                        <!-- <td>1</td> -->
                        <td>Assessment Executive Report</td>
                        <td class="text-center">
                          <a class="btn btn-primary" title="View Executive Report" data-toggle="modal" data-target="#templates" onclick="getproposaldocument('/assessment_report/{{$email}}/Assessment_Executive_Report.pdf')" class="report_all" style="margin-inline:5px"><i class="fa fa-eye" style="color:white!important"></i></a>
                          <!-- <a class="btn btn-info" title="View Summary Report" data-toggle="modal" data-target="#templates" onclick="getproposaldocument('/assessment_report/{{$email}}/Assessment_Detail_Summary_Report.pdf')" style="margin-inline:5px"><i class="fa fa-eye" style="color:white!important"></i></a> -->
                        </td>
                      </tr>
                      <tr>
                        <!-- <td>1</td> -->
                        <td>Assessment Detail Report</td>
                        <td class="text-center">
                          <!-- <a class="btn btn-primary" title="View Executive Report" data-toggle="modal" data-target="#templates" onclick="getproposaldocument('/assessment_report/{{$email}}/Assessment_Executive_Report.pdf')" style="margin-inline:5px"><i class="fa fa-eye" style="color:white!important"></i></a> -->
                          <a class="btn btn-info report_all" title="View Summary Report" data-toggle="modal" data-target="#templates" onclick="getproposaldocument('/assessment_report/{{$email}}/Assessment_Detail_Summary_Report.pdf')" style="margin-inline:5px"><i class="fa fa-eye" style="color:white!important"></i></a>
                        </td>
                      </tr>
                      @endif

                      @php
                      $folderPath1 = Config::get('setting.base_url').'/recommendation_report/'.$email.'/recommendation_report.pdf';
                      $folderExists1 = file_exists($folderPath1);
                      $headers1 = @get_headers($folderPath1);
                      $fileExists1 = ($headers1 && strpos($headers1[0], '200') !== false);
                      @endphp

                      @if ($fileExists1)
                      <tr>
                        <!-- <td>2</td> -->
                        <td>Recommendation Report</td>
                        <td class="text-center"><a class="btn btn-primary report_all" title="View Document" data-toggle="modal" data-target="#templates" onclick="getproposaldocument('/recommendation_report/{{$email}}/recommendation_report.pdf')" style="margin-inline:5px"><i class="fa fa-eye" style="color:white!important"></i></a></td>
                      </tr>
                      @endif

                      @php
                      $folderPath = Config::get('setting.base_url').'/referral_report/'.$email.'/referral_report.pdf';
                      $folderExists = file_exists($folderPath);
                      $headers = @get_headers($folderPath);
                      $fileExists = ($headers && strpos($headers[0], '200') !== false);
                      @endphp

                      @if ($fileExists)
                      <tr>
                        <!-- <td>3</td> -->
                        <td>Referral Report</td>
                        <td class="text-center"><a class="btn btn-primary report_all" title="View Document" data-toggle="modal" data-target="#templates" onclick="getproposaldocument('/referral_report/{{$email}}/referral_report.pdf')" style="margin-inline:5px"><i class="fa fa-eye" style="color:white!important"></i></a></td>
                      </tr>
                      @endif
                      @endif
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
  </section>
</div>
<script>
  function getproposaldocument(id) {
    var data = (id);
    $('#modalviewdiv').html('');
    $("#loading_gif").show();
    console.log(id);

    $("#loading_gif").hide();
    var proposaldocuments = "<div class='removeclass' id='modalviewdiv' style=' height:100%'><iframe src='" + data + "' class='document_ifarme_view' style='width:100%; height:100%'></iframe></div>";
    $('.removeclass').remove();
    var document = $('#template').append(proposaldocuments);
  };
</script>


@include('newenrollement.formmodal')
@endsection