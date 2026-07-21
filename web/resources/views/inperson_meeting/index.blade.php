@extends('layouts.adminnav')

@section('content')
<style>
/* =========================================================================
   MOBILE RESPONSIVE STYLING - SAME AS ENROLLMENT LIST PAGE
   ========================================================================= */

.table-responsive {
    overflow-x: auto;
    -webkit-overflow-scrolling: touch;
}

@media (max-width: 768px) {
    .main-content, .card, .card-body, .table-wrapper, .searchResultStudent, .table-responsive {
        padding-left: 0 !important; padding-right: 0 !important; margin-left: 0 !important; margin-right: 0 !important;
    }
    .row, .col-12, .col-lg-12 { padding-left: 5px !important; padding-right: 5px !important; }
    .main-content { padding-top: 0 !important; }
    .breadcrumb { font-size: 11px !important; margin-bottom: 10px !important; margin-top: 60px !important; margin-left: 10px !important; }
    .card { margin-top: 0 !important; }
    .table-responsive { overflow-x: hidden !important; overflow-y: visible !important; max-height: none !important; }
    .table-responsive table { font-size: 12px; min-width: 100% !important; width: 100% !important; }
    
    .searchResultStudent table, .searchResultStudent thead, .searchResultStudent tbody, .searchResultStudent th, .searchResultStudent td { display: block !important; width: 100% !important; }
    table[id^="align"] thead { display: none !important; }
    table[id^="align"] tbody { background: transparent !important; }
    table[id^="align"] { width: 100% !important; margin: 0 !important; }
    table[id^="align"] tr {
        display: flex !important; flex-direction: column !important; align-items: stretch !important;
        border: 1px solid #e0e0e0 !important; border-radius: 8px !important; margin: 8px 5px !important;
        position: relative !important; padding: 10px 15px 10px 45px !important; background: #fff !important;
        box-shadow: 0 1px 4px rgba(0,0,0,0.05) !important; cursor: pointer; width: calc(100% - 10px) !important;
    }
    table[id^="align"] td {
        display: block !important; border: none !important; padding: 0 !important; text-align: left !important;
        white-space: normal !important; width: 100% !important; background: transparent !important;
        height: auto !important; min-height: 0 !important; line-height: 1.2 !important;
    }

    /* Sl No */
    table[id^="align"] td:nth-of-type(1) {
        position: absolute !important; left: 15px !important; top: 50% !important; transform: translateY(-50%) !important;
        width: 25px !important; display: flex !important; font-weight: bold !important; font-size: 13px !important; color: #2c3e50 !important;
    }
    table[id^="align"] tr.expanded-row td:nth-of-type(1) { top: 20px !important; transform: translateY(0) !important; }

    /* F2F ID */
    table[id^="align"] td:nth-of-type(2) { display: block !important; font-size: 13px !important; color: #34495e !important; margin-bottom: 10px !important; order: 2 !important; }
    table[id^="align"] td:nth-of-type(2):before { content: "ID: "; font-weight: 600 !important; color: #000 !important; }

    /* Child Name */
    table[id^="align"] td:nth-of-type(3) { display: block !important; font-weight: 600 !important; font-size: 16px !important; color: #2c3e50 !important; margin-bottom: 4px !important; padding-right: 25px !important; order: 1 !important; }

    /* Hidden fields initially */
    table[id^="align"] td:nth-of-type(4),
    table[id^="align"] td:nth-of-type(5),
    table[id^="align"] td:nth-of-type(6),
    table[id^="align"] td:nth-of-type(7) { display: none !important; }

    /* IS Coordinator's */
    table[id^="align"] tr.expanded-row td:nth-of-type(4) { display: block !important; margin-top: 8px !important; font-size: 12px !important; color: #34495e !important; order: 3 !important; }
    table[id^="align"] tr.expanded-row td:nth-of-type(4):before { content: "Coordinator: "; font-weight: 600 !important; color: #000 !important; }

    /* Meeting Date & Time */
    table[id^="align"] tr.expanded-row td:nth-of-type(5) { display: block !important; margin-top: 6px !important; font-size: 12px !important; color: #34495e !important; order: 4 !important; }
    table[id^="align"] tr.expanded-row td:nth-of-type(5):before { content: "Meeting: "; font-weight: 600 !important; color: #000 !important; }

    /* Status */
    table[id^="align"] tr.expanded-row td:nth-of-type(6) { display: block !important; margin-top: 6px !important; font-size: 12px !important; color: #34495e !important; order: 5 !important; }
    table[id^="align"] tr.expanded-row td:nth-of-type(6):before { content: "Status: "; font-weight: 600 !important; color: #000 !important; }

    /* Action */
    table[id^="align"] tr.expanded-row td:nth-of-type(7) { display: flex !important; align-items: center !important; gap: 6px !important; margin-top: 6px !important; order: 6 !important; }
    table[id^="align"] tr.expanded-row td:nth-of-type(7):before { content: "Action:"; font-weight: 600 !important; color: #000 !important; margin-right: 6px !important; flex-shrink: 0 !important; }
    
    /* Arrow */
    table[id^="align"] tr::after { content: '\f054'; font-family: 'FontAwesome'; position: absolute; right: 15px; top: 50%; transform: translateY(-50%); color: #bdc3c7; transition: transform 0.3s; font-size: 12px; }
    table[id^="align"] tr.expanded-row::after { transform: translateY(-50%) rotate(90deg); top: 35px; }
    
    table[id^="align"] td.dataTables_empty { display: table-cell !important; width: 100% !important; text-align: center !important; padding: 15px !important; }
    table[id^="align"] tr:has(td.dataTables_empty) { display: table-row !important; border: none !important; box-shadow: none !important; padding: 0 !important; background: transparent !important; }
    table[id^="align"] tr:has(td.dataTables_empty)::after { display: none !important; }

    /* DataTable controls: Show left, Search right */
    .dataTables_wrapper .row:first-child { margin: 0 !important; }
    .dataTables_wrapper .dataTables_length { float: left !important; margin-left: 8px !important; }
    .dataTables_wrapper .dataTables_filter { float: right !important; padding-right: 8px !important; }
    .dataTables_wrapper .dataTables_length,
    .dataTables_wrapper .dataTables_filter,
    .dataTables_wrapper .dataTables_info,
    .dataTables_wrapper .dataTables_paginate { font-size: 10px !important; }
    .dataTables_wrapper .dataTables_length select { font-size: 11px !important; height: 32px !important; width: 60px !important; }
    .dataTables_wrapper .dataTables_filter input { width: 90px !important; height: 24px !important; font-size: 10px !important; }

/* ==========================================
   OVM Activity Modal - Mobile Responsive
   ========================================== */
    .modal-dialog.modal-xl {
        max-width: 95% !important;
        margin: 10px auto !important;
    }
    .modal-body {
        padding: 10px !important;
    }
    .modal-body .table-responsive {
        overflow-x: hidden !important;
    }
    /* Hide table header */
    .modal-body table thead {
        display: none !important;
    }
    .modal-body table, .modal-body tbody, .modal-body tr, .modal-body td {
        display: block !important; width: 100% !important;
    }
    /* Card Design */
    .modal-body tbody tr {
        border: 1px solid #dcdcdc !important; border-radius: 10px !important;
        background: #fff !important; padding: 12px !important; margin-bottom: 12px !important;
        box-shadow: 0 2px 5px rgba(0,0,0,0.08) !important; position: relative;
    }
    .modal-body tbody td {
        border: none !important; padding: 3px 0 !important; text-align: left !important;
        font-size: 13px !important; line-height: 1.4 !important;
    }
    /* Labels */
    .modal-body tbody td:nth-child(1):before { content: "Sl No : "; font-weight: 600; color: #000; }
    .modal-body tbody td:nth-child(2):before { content: "Enrollment : "; font-weight: 600; color: #000; }
    .modal-body tbody td:nth-child(3):before { content: "Child Name : "; font-weight: 600; color: #000; }
    .modal-body tbody td:nth-child(4):before { content: "Status : "; font-weight: 600; color: #000; }
    .modal-body tbody td:nth-child(5):before { content: "Date : "; font-weight: 600; color: #000; }
    .modal-body tbody td:nth-child(6):before { content: "Last Actioned : "; font-weight: 600; color: #000; }
    /* Modal Header */
    .modal-header h4 { font-size: 18px !important; }
    .modal-header .close { font-size: 22px !important; }
    /* Card body spacing */
    #card_header { padding: 0 !important; }
}
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

<script>
$(document).ready(function() {
    $('table[id^="align"] tbody').on('click', 'tr', function(e) {
        if ($(e.target).closest('a, button, input, form, label').length) {
            return;
        }
        if ($(window).width() <= 768) {
            $(this).toggleClass('expanded-row');
        }
    });
});
</script>
@endsection