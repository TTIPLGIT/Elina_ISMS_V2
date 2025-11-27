@extends('layouts.adminnav')

@section('content')
<style>



</style>
<div class="main-content">

  {{ Breadcrumbs::render('inperson_meeting.index') }}
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
              <h4 style="color:darkblue;">Face to Face Meeting Archive</h4>
            </div>

          </div>






          <div class="table-wrapper">
            <div class="table-responsive">
              <table class="table table-bordered" id="align">
                <thead>
                  <tr>
                    <th width="50px">Sl. No.</th>
                    <th>F2F ID</th>
                    <th>Child Name</th>
                    <!-- <th>Enrollment Id</th> -->
                    <th>IS Coordinator's</th>
                    <th>Meeting Date & Time</th>
                    <th>Status</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
              

                  @foreach($rows as $key=>$row)
                 
                  <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $row['meeting_unique']}}</td>
                    <td>{{ $row['child_name']}}</td>
                    <!-- <td>{{ $row['enrollment_id']}}</td> -->
                    <td>{{ $row['is_coordinator1']['name'] }}(1)
                      @if(json_decode($row['is_coordinator2']) != null)
                      ,{{ json_decode($row['is_coordinator2'], true)['name'] }}(2)
                                         
                      @endif
                    </td>
                    <td>{{ $row['meeting_startdate']}} @ {{ date('h:i A', strtotime($row['meeting_starttime'])) }}</td>
                    @if($modules['user_role'] == 'IS Coordinator')

                      @if(in_array($row['meeting_id'] , $arr))
                                 
                        @foreach($attendeeStatus as $as)
                          @if($as['ovm_id'] == $row['meeting_id'])
                            <td>{{$as['overall_status']}}</td>
                          @endif
                        @endforeach
                        
                      @else
                        <td>{{ $row['meeting_status']}}</td>
                      @endif

                    @else
                    <td>{{ $row['meeting_status']}}</td>
                    @endif
                    <td class="text-center">

                      <form action method="POST" action="">



                        @php $moId = $row['meeting_id'];
                        $row['meeting_id'] = Crypt::encrypt($row['meeting_id']); @endphp
                        <a class="btn btn-link" title="Show" href="{{ route('inperson_meeting.show', $row['meeting_id']) }}"><i class="fas fa-eye" style="color: blue !important"></i></a>
                        @if( $row['meeting_status']== 'Sent' || $row['meeting_status']== 'Accepted' ||$row['meeting_status']== 'Declined' ||$row['meeting_status']== 'Rescheduled' || $row['meeting_status']== 'Reschedule Request' || $row['meeting_status']== 'Hold')
                        <a class="btn btn-link" title="Edit" href="{{ route('SentMeeting', $row['meeting_id']) }}"><i class="fas fa-pencil-alt" style="color:green"></i></a>
                        @elseif( $row['meeting_status']== 'Completed')
                        <!-- <a class="btn btn-link" title="Edit" href="{{ route('ovmcompleted', $row['meeting_id']) }}"><i class="fas fa-pencil-alt" style="color:green"></i></a> -->

                        @else
                        <a class="btn btn-link" title="Edit" href="{{ route('SentMeeting', $row['meeting_id']) }}"><i class="fas fa-pencil-alt" style="color:green"></i></a>
                        @endif
                        @csrf
                        <!-- <a href="#addModal" data-toggle="modal" data-target="#addModal{{$moId}}" class="btn btn-primary" title="View" data-toggle="modal" data-target="#templates" style="margin-inline:5px"><i class="fa fa-bars" style="color:white!important"></i></a> -->
                        <input type="hidden" name="delete_id" id="<?php echo $row['meeting_id']; ?>" value="{{ route('ovm1.delete', $row['meeting_id']) }}">
                        <!-- @if( $row['meeting_status']== 'Saved' )                                               
                                <a class="btn btn-light"  title="Delete" onclick="return myFunction(<?php echo $row['meeting_id']; ?>);" class="btn btn-link"><i class="far fa-trash-alt"></i></a>
                            @endif -->

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

  @foreach($rows as $key=>$row)
  <div class="modal fade" id="addModal{{$row['meeting_id']}}">
    <div class="modal-dialog modal-xl">
      <div class="modal-content">
        <div class="main-contents">
          <section class="section">
            <div class="modal-header bg-primary" style=" background-color: rgb(0 103 172) !important;">
              <h4 class="modal-title">OVM Activity</h4>
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
                                  <th>Sl. No.</th>
                                  <th>Enrollment Number</th>
                                  <th>Child Name</th>
                                  <th>Status</th>
                                  <th>Date</th>
                                  <th>Last Actioned</th>
                                </tr>
                              </thead>
                              <tbody>
                                
                                @foreach($log as $key => $data)
                                @if($row['meeting_id'] == $data['audit_table_id'])
                                <tr>
                                  <td>{{$loop->iteration}}</td>
                                  <td>{{$data['enrollment_id']}}</td>
                                  <td>{{$data['child_name']}}</td>
                                  <td>{{$data['audit_action']}}</td>
                                  <td>{{$data['action_date_time']}}</td>
                                  <td>{{$data['role_name']}}</td>
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





</div>



<script type="text/javascript">
  $(document).ready(function() {
    var saveAlert = <?php echo json_encode($saveAlert); ?>;
    for (i = 0; i < saveAlert.length; i++) {
      var alert = saveAlert[i];
      var message = 'Meeting for ' + alert.child_name + ' (' + alert.enrollment_id + ') ' + 'is in saved state and waiting for your action';
      Swal.fire('Info!', message, 'info');
    }
  });
</script>

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
          swal.fire("Shortlisted!", "Candidates are successfully shortlisted!", "success");
          var url = $('#' + id).val();
          window.location.href = url;

        } else {
          swal.fire("Cancelled", "Your imaginary file is safe :)", "error");
          e.preventDefault();
        }
      });


  }
</script>

@endsection