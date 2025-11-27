@extends('layouts.adminnav')
@section('content')
<div class="main-content">
  {{ Breadcrumbs::render('sailstatus') }}
  <section class="section">
    <div class="section-body mt-2">
      <div class="row">
        @if (session('success'))
        <input type="hidden" name="session_data" id="session_data" class="session_data" value="{{ session('success') }}">
        <script type="text/javascript">
          window.onload = function() {
            var message = $('#session_data').val();
            swal.fire("Success", message, "success");
          }
        </script>
        @elseif(session('fail'))
        <input type="hidden" name="session_data" id="session_data1" class="session_data" value="{{ session('fail') }}">
        <script type="text/javascript">
          window.onload = function() {
            var message = $('#session_data1').val();
            swal.fire("Info", message, "info");
          }
        </script>
        @endif
        <a type="button" href="{{route('sailstatus.initiate')}}" value="" class="btn btn-labeled btn-info" title="create" style="background: #044a95 !important; border-color:#a9ca !important; color:white !important;margin: 0 0 2px 15px;">
          <span class="btn-label" style="font-size:15px !important; padding:8px !important"><i class="fa fa-plus"></i></span><span style="font-size:15px !important; padding:8px !important">Initiation</span></a>
        <div class="col-12">
          <div class="card">
            <div class="card-body">
              <div class="row">
                <div class="col-lg-12 text-center">
                  <h4 style="color:darkblue;">SAIL Status List View</h4>
                </div>
              </div>
              <div class="table-wrapper">
                <div class="table-responsive">
                  <table class="table table-bordered" id="align">
                    <thead>
                      <tr>
                        <th>Sl. No.</th>
                        <th>Enrollment Number</th>
                        <th>Child Name</th>
                        <th>Is-coordinator</th>
                        <th>Status</th>
                        <th>Action</th>
                      </tr>
                    </thead>
                    <tbody>
                      @foreach($rows as $key=>$row)
                      <tr>
                        <td>{{$loop->iteration}}</td>
                        <td>{{$row['enrollment_child_num']}}</td>
                        <td>{{ $row['child_name']}}</td>
                        @if($row['is_coordinator2'] == [])
                        <td>{{ $row['is_coordinator1']['name']}}</td>
                        @else
                        <td>{{ $row['is_coordinator1']['name']}},<br>{{ $row['is_coordinator2']['name']}}</td>
                        @endif
                        @if($row['current_status'] == 'Initiated')
                        <td>Consent Form Sent</td>
                        @else
                        <td>{{ $row['current_status']}}</td>
                        @endif
                        @php
                        $folderPath = $row['child_id'];
                        $consent = '/sail_consent/'.$folderPath.'/consent_form_sail.pdf';

                        @endphp
                        <td class="text-center">
                          <a href="#addModal" data-toggle="modal" data-target="#addModal{{$row['user_id']}}" class="btn btn-primary" title="View" data-toggle="modal" data-target="#templates" style="margin-inline:5px"><i class="fa fa-bars" style="color:white!important"></i></a>
                          <a class="btn btn-primary" title="view Document" data-toggle="modal" data-target="#templates" onclick="getproposaldocument('{{$consent}}')" style="margin-inline:5px"><i class="fa fa-download" style="color:white!important"></i></a>
                          @if(strpos($screen_permission['permissions'], 'Edit') !== false)
                          <a class="btn btn-link" title="Edit" href="{{ route('sail.status.edit', \Crypt::encrypt($row['enrollment_id']))}}"><i class="fas fa-pencil-alt" style="color: blue !important"></i></a>
                          @endif
                          <!-- <a href="#addModal" data-toggle="modal" data-target="#addModal" style="font-weight: bold;"><span class="text-secondary">Click Here To View All Leads <i class="fa fa-arrow-right" aria-hidden="true"></i></span></a>  -->
                          <!-- <a class="btn" title="Delete" onclick="" class="btn btn-link"><i class="fa fa-bars"></i></a> -->
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
<!-- Modal -->
@foreach($rows as $key=>$row)
<div class="modal fade" id="addModal{{$row['user_id']}}">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <div class="main-contents">
        <section class="section">
          <div class="modal-header bg-primary" style=" background-color: rgb(0 103 172) !important;">
            <h4 class="modal-title">Sail Overview of {{$row['child_name']}}</h4>
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          </div>
          <div class="modal-body" style="background-color: #edfcff !important;">
            <div class="section-body mt-2">
              <div class="row">
                <div class="col-12">
                  <div class="mt-0 ">
                    <div class="card-body" id="card_header">
                      <div class="row">
                      </div>
                      <div class="table-wrapper">
                        <div class="table-responsive  p-3">
                          <table class="table table-bordered">
                            <thead>
                              <tr>
                                <th>S.No.</th>
                                <!-- <th>Enrollment Number</th> -->
                                <!-- <th>Child Name</th> -->
                                <th>Status</th>
                                <th>Date</th>
                              </tr>
                            </thead>
                            <tbody>
                              @foreach($actions as $key => $data)
                              @if($row['child_id'] == $data['child_id'])
                              <tr>
                                <td>{{$loop->iteration}}</td>
                                <!-- <td>{{$data['enrollment_id']}}</td> -->
                                <!-- <td>{{$data['child_name']}}</td> -->
                                <td>{{$data['audit_action']}}</td>
                                <td>
                                  <script>
                                    // Assuming $data['action_date_time'] is in the format "2023-11-09 12:49:12"
                                    var dateString = "{{ $data['action_date_time'] }}";

                                    // Convert to a format recognized by JavaScript Date
                                    var formattedDateString = dateString.replace(/-/g, '/') + ' UTC';
                                    var utcDate = new Date(formattedDateString);

                                    // Format the date for IST
                                    var options = {
                                      timeZone: 'Asia/Kolkata',
                                      year: 'numeric',
                                      month: 'numeric',
                                      day: 'numeric',
                                      hour: 'numeric',
                                      minute: 'numeric',
                                      second: 'numeric'
                                    };
                                    var istDate = new Intl.DateTimeFormat('en-IN', options).format(utcDate);
                                    istDate = istDate.replace(/\b(?:am|pm)\b/gi, match => match.toUpperCase());

                                    document.write(istDate);
                                  </script>

                                </td>
                              </tr>
                              @endif
                              @endforeach
                            </tbody>
                          </table>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
        </section>
      </div>
    </div>
  </div>
</div>
@endforeach
<!-- End Modal -->
<script src="https://code.jquery.com/jquery-1.7.2.min.js"></script>
<script type="application/javascript">
  function myFunction(id) {
    swal.fire({
        title: "Confirmation For Delete ?",
        text: "Are You Sure to delete this data.",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: '#DD6B55',
        confirmButtonText: 'Yes, I am sure!',
        cancelButtonText: "No, cancel it!",
        closeOnConfirm: false,
        closeOnCancel: false
      },
      function(isConfirm) {

        if (isConfirm) {
          swal.fire("Deleted!", "Data Deleted successfully!", "success");
          var url = $('#' + id).val();

          window.location.href = url;

        } else {
          swal.fire("Cancelled", "Your file is safe :)", "error");
          e.preventDefault();
        }
      });


  }
</script>
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