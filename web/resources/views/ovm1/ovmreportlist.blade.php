@extends('layouts.adminnav')

@section('content')
<style>



</style>
<div class="main-content">
  <section class="section">

    {{ Breadcrumbs::render('ovmreport') }}
    <div class="section-body mt-2">

      @if (session('success'))
      <input type="hidden" name="session_data" id="session_data" class="session_data" value="{{ session('success') }}">
      <script type="text/javascript">
        window.onload = function() {
          var message = $('#session_data').val();
          Swal.fire('Success!', message, 'success');
        }
      </script>
      @elseif(session('fail'))
      <input type="hidden" name="session_data" id="session_data1" class="session_data" value="{{ session('fail') }}">
      <script type="text/javascript">
        window.onload = function() {
          var message = $('#session_data1').val();
          Swal.fire('Info!', message, 'info');
        }
      </script>
      @endif

      <div class="row">
        <div class="col-12">
          <div class="card">
            <div class="card-body">
              <div class="row">
                <div class="col-lg-12 text-center">
                  <h4 style="color:darkblue;">OVM Report List </h4>
                </div>
              </div>

              <input type="hidden" id="sendReport" name="sendReport">
              <div class="table-wrapper">
                <div class="table-responsive">
                  <table class="table table-bordered" id="align">
                    <thead>
                      <tr>
                        <th width="50px">Sl. No.</th>
                        <th>OVM ID</th>
                        <th>Child Name</th>
                        <th>Enrollment Id</th>
                        <th>Child Id</th>
                        <th>Status</th>
                        <th>Action</th>
                      </tr>
                    </thead>
                    <tbody>

                      @foreach($rows as $key=>$row)
                      <tr>

                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $row['ovm_meeting_unique']}}</td>
                        <td>{{ $row['child_name']}}</td>
                        <td>{{ $row['enrollment_id']}}</td>
                        <td>{{ $row['child_id']}}</td>
                        @if(in_array($row['ovm_meeting_id'] , $completed) || $row['status'] == 'Completed')
                        <td>Completed</td>
                        @else
                          @if($row['report_flag'] == 0)
                          <td>New</td>
                          @elseif($row['report_flag'] == 2)
                          <td>Saved</td>
                          @elseif($row['report_flag'] == 3)
                          <td>Submitted</td>
                          @else
                          <td>{{ $row['status']}}</td>
                          @endif
                        @endif

                        <form action="{{route('send_report')}}" method="POST" id="submit_report{{$row['child_id']}}">
                          @csrf
                          <input type="hidden" value="{{$row['is_coordinator_id']}}" name="is_coordinator_id" id="is_coordinator_id">
                          <input type="hidden" value="{{$row['child_id']}}" name="child_id" id="child_id">
                          <input type="hidden" value="{{$row['child_name']}}" name="child_name" id="child_name">
                        </form>

                        <td class="text-center">

                          <form action method="POST" action="">



                            @php
                            $folderPath = $row['child_contact_email'];
                            $folderPath1 = $row['child_id'];
                            $reportflag = $row['report_flag'];
                            if($reportflag == 0 || $reportflag == 2){
                            $consent = '/ovm_report/'.$folderPath.'/ovm_report.pdf';
                            }else{
                            $consent = '/ovm_assessment/'.$folderPath.'/sail_guide.pdf';
                            }
                            @endphp


                            @php $omd = Crypt::encrypt($row['ovm_meeting_id']); @endphp
                            <a class="btn btn-labeled btn-warning" style="background: warning !important; border-color:warning !important; color:warning !important" title="Report" href="{{ route('ovmreportview', $omd) }}"><span class="btn-label" style="font-size:13px !important;"><i class="fa fa-file-o"></i></span>Report </a>
                            @if(strpos($screen_permission['permissions'], 'Compare') !== false)
                              @if($reportflag == 0 || $reportflag == 2)
                                <a class="btn btn-primary" title="Conversation Report" data-toggle="modal" data-target="#templates" onclick="getproposaldocument('{{$consent}}')" style="margin-inline:5px"><i class="fa fa-files-o" style="color:white!important"></i></a>
                              @else
                                <a class="btn btn-info" title="SAIL Guide" data-toggle="modal" data-target="#templates" onclick="getproposaldocument('{{$consent}}')" style="margin-inline:5px"><i class="fa fa-file-pdf-o" style="color:white!important"></i></a>
                              @endif
                            @endif
                            @csrf



                          </form>

                        </td>
                      </tr>
                      @endforeach
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





<script src="https://code.jquery.com/jquery-1.7.2.min.js"></script>

<script>
  function getproposaldocument(id) {
    var data = (id);
    console.log(data);
    $("#loading_gif").show();
    var proposaldocuments = "<div class='removeclass' id='modalviewdiv' style=' height:100%'><iframe src='" + data + "' class='document_ifarme_view' style='width:100%; height:100%'></iframe></div>";
    $('.removeclass').remove();
    $('#template').html('');
    $('#template1').html('');
    $("#loading_gif").hide();
    var document = $('#template').append(proposaldocuments);

  };

  function getproposaldocument1(cid) {
    var child_id = cid;
    var child_name = '';
    document.getElementById('sendReport').value = child_id;
    // alert(child_id);
    $('#modalviewdiv').html('');
    $("#loading_gif").show();

    $.ajax({
      url: "{{ route('report_download') }}",
      type: 'post',
      data: {
        child_id: child_id,
        child_name: child_name,
        _token: '{{csrf_token()}}'
      },
      error: function() {
        alert('Something is wrong');
      },
      success: function(data) {
        console.log(data.length);
        if (data.length > 0) {
          $("#loading_gif").hide();
          var proposaldocuments = "<div class='removeclass' id='modalviewdiv' style=' height:100%'><iframe src='" + data + "' class='document_ifarme_view' style='width:100%; height:100%'></iframe></div>";
          $('.removeclass').remove();
          $('#template').html('');
          $('#template1').html('');
          var document = $('#template1').append(proposaldocuments);
        }

      }
    });
  };

  function send_form() {
    var f = document.getElementById('sendReport').value;
    document.getElementById('submit_report' + f).submit();
  }
</script>
@include('newenrollement.formmodal')
@include('ovm1.formmodal2')


@endsection