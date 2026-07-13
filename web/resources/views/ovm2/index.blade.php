@extends('layouts.adminnav')

@section('content')
<style>
/* =========================================================================
   MOBILE RESPONSIVE STYLING - SYNCHRONIZED FROM OVM-1 BLUEPRINT
   ========================================================================= */

.table-responsive {
    overflow-x: auto;
    -webkit-overflow-scrolling: touch;
}

@media (max-width: 768px) {

    .main-content,
    .card,
    .card-body,
    .table-wrapper,
    .table-responsive {
        padding-left: 0 !important;
        padding-right: 0 !important;
        margin-left: 0 !important;
        margin-right: 0 !important;
    }

    .row,
    .col-12,
    .col-lg-12 {
        padding-left: 5px !important;
        padding-right: 5px !important;
    }

    .main-content {
        padding-top: 0 !important;
    }

    .breadcrumb {
        font-size: 11px !important;
        margin-bottom: 10px !important;
        margin-top: 60px !important;
        margin-left: 10px !important;
    }

    .card {
        margin-top: 0 !important;
    }

    .table-responsive {
        overflow-x: hidden !important;
        overflow-y: visible !important;
        max-height: none !important;
    }

    .table-responsive table {
        font-size: 12px;
        min-width: 100% !important;
        width: 100% !important;
    }

    .table-responsive table,
    .table-responsive thead,
    .table-responsive tbody,
    .table-responsive th,
    .table-responsive td {
        display: block !important;
        width: 100% !important;
    }

    .table-responsive thead {
        display: none !important;
    }

    .table-responsive tbody {
        background: transparent !important;
    }

    #align {
        width: 100% !important;
        margin: 0 !important;
    }

    #align tr {
        display: flex !important;
        flex-direction: column !important;
        align-items: stretch !important;
        border: 1px solid #e0e0e0 !important;
        border-radius: 8px !important;
        margin: 8px 5px !important;
        position: relative !important;
        padding: 10px 15px 10px 45px !important;
        background: #fff !important;
        box-shadow: 0 1px 4px rgba(0,0,0,0.05) !important;
        cursor: pointer;
        width: calc(100% - 10px) !important;
    }

    #align td {
        display: block !important;
        border: none !important;
        padding: 0 !important;
        text-align: left !important;
        white-space: normal !important;
        width: 100% !important;
        background: transparent !important;
        height: auto !important;
        min-height: 0 !important;
        line-height: 1.2 !important;
    }

    /* Sl No */
    #align td:nth-of-type(1) {
        position: absolute !important;
        left: 15px !important;
        top: 50% !important;
        transform: translateY(-50%) !important;
        width: 25px !important;
        display: flex !important;
        font-weight: bold !important;
        font-size: 13px !important;
        color: #2c3e50 !important;
    }

    #align tr.expanded-row td:nth-of-type(1) {
        top: 20px !important;
        transform: translateY(0) !important;
    }

    /* Child Name */
    #align td:nth-of-type(2) {
        display: block !important;
        font-weight: 600 !important;
        font-size: 16px !important;
        color: #2c3e50 !important;
        margin-bottom: 4px !important;
        padding-right: 25px !important;
        order: 1 !important;
    }

    /* Enrollment ID */
    #align td:nth-of-type(3) {
        display: block !important;
        font-size: 13px !important;
        color: #34495e !important;
        margin-bottom: 10px !important;
        order: 2 !important;
    }

    #align td:nth-of-type(3):before {
        content: "ID: ";
        font-weight: 600 !important;
        color: #000 !important;
    }

    /* Hidden fields initially */
    #align td:nth-of-type(4),
    #align td:nth-of-type(5),
    #align td:nth-of-type(6),
    #align td:nth-of-type(7) {
        display: none !important;
    }

    /* Arrow */
    #align tr::after {
        content: '\f054';
        font-family: 'FontAwesome';
        position: absolute;
        right: 15px;
        top: 50%;
        transform: translateY(-50%);
        color: #bdc3c7;
        transition: transform 0.3s;
        font-size: 12px;
    }

    #align tr.expanded-row::after {
        transform: translateY(-50%) rotate(90deg);
        top: 35px;
    }

    /* Coordinator */
    #align tr.expanded-row td:nth-of-type(4) {
        display: block !important;
        margin-top: 8px !important;
        font-size: 12px !important;
        color: #34495e !important;
        order: 3 !important;
    }

    #align tr.expanded-row td:nth-of-type(4):before {
        content: "Coordinator: ";
        font-weight: 600 !important;
        color: #000 !important;
    }

    /* Meeting */
    #align tr.expanded-row td:nth-of-type(5) {
        display: block !important;
        margin-top: 6px !important;
        font-size: 12px !important;
        color: #34495e !important;
        order: 4 !important;
    }

    #align tr.expanded-row td:nth-of-type(5):before {
        content: "Meeting: ";
        font-weight: 600 !important;
        color: #000 !important;
    }

    /* Status */
    #align tr.expanded-row td:nth-of-type(6) {
        display: block !important;
        margin-top: 6px !important;
        font-size: 12px !important;
        color: #34495e !important;
        order: 5 !important;
    }

    #align tr.expanded-row td:nth-of-type(6):before {
        content: "Status: ";
        font-weight: 600 !important;
        color: #000 !important;
    }

    /* Action Row */
    #align tr.expanded-row td:nth-of-type(7) {
        display: flex !important;
        align-items: center !important;
        flex-wrap: nowrap !important;
        gap: 6px !important;
        margin-top: 6px !important;
        order: 6 !important;
        white-space: nowrap !important;
    }

    /* Action label */
    #align tr.expanded-row td:nth-of-type(7):before {
        content: "Action:";
        font-weight: 600 !important;
        color: #000 !important;
        margin-right: 6px !important;
        flex-shrink: 0 !important;
    }

    /* Icons */
    #align tr.expanded-row td:nth-of-type(7) a,
    #align tr.expanded-row td:nth-of-type(7) button {
        display: inline-flex !important;
        align-items: center !important;
        justify-content: center !important;
        margin-right: 0 !important;
        padding: 2px !important;
        font-size: 14px !important;
    }

    /* No records handling fallback matching OVM-1 style */
    #align td.dataTables_empty {
        display: table-cell !important;
        width: 100% !important;
        text-align: center !important;
        white-space: nowrap !important;
        padding: 15px !important;
        font-size: 13px !important;
        font-weight: 600 !important;
        color: #666 !important;
    }

    #align tr:has(td.dataTables_empty) {
        display: table-row !important;
        border: none !important;
        box-shadow: none !important;
        padding: 0 !important;
        background: transparent !important;
    }

    #align tr:has(td.dataTables_empty)::after {
        display: none !important;
    }

    /* DataTable controls layout synchronization */
    .dataTables_wrapper .row:first-child {
        margin: 0 !important;
    }

    .dataTables_wrapper .dataTables_length {
        float: left !important;
        margin-left: 8px !important;
    }

    .dataTables_wrapper .dataTables_filter {
        float: right !important;
        padding-right: 8px !important;
    }

    .dataTables_wrapper .dataTables_length,
    .dataTables_wrapper .dataTables_filter,
    .dataTables_wrapper .dataTables_info,
    .dataTables_wrapper .dataTables_paginate {
        font-size: 10px !important;
    }

    .dataTables_wrapper .dataTables_length select {
        font-size: 11px !important;
        height: 32px !important;
        width: 60px !important;
    }

    .dataTables_wrapper .dataTables_filter input {
        width: 90px !important;
        height: 24px !important;
        font-size: 10px !important;
    }

    .card-body h4 {
        font-size: 18px !important;
    }
}

/* =========================================================================
   OVM ACTIVITY MODAL - MOBILE RESPONSIVE
   ========================================================================= */
@media (max-width: 768px) {
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

    /* Hide internal modal table header */
    .modal-body table thead {
        display: none !important;
    }

    .modal-body table,
    .modal-body tbody,
    .modal-body tr,
    .modal-body td {
        display: block !important;
        width: 100% !important;
    }

    /* Linearized Log Cards */
    .modal-body tbody tr {
        border: 1px solid #dcdcdc !important;
        border-radius: 10px !important;
        background: #fff !important;
        padding: 12px !important;
        margin-bottom: 12px !important;
        box-shadow: 0 2px 5px rgba(0,0,0,0.08) !important;
        position: relative;
    }

    .modal-body tbody td {
        border: none !important;
        padding: 3px 0 !important;
        text-align: left !important;
        font-size: 13px !important;
        line-height: 1.4 !important;
    }

    /* Field Labels Injection */
    .modal-body tbody td:nth-child(1):before { content: "Sl No : "; font-weight: 600; color: #000; }
    .modal-body tbody td:nth-child(2):before { content: "Enrollment : "; font-weight: 600; color: #000; }
    .modal-body tbody td:nth-child(3):before { content: "Child Name : "; font-weight: 600; color: #000; }
    .modal-body tbody td:nth-child(4):before { content: "Status : "; font-weight: 600; color: #000; }
    .modal-body tbody td:nth-child(5):before { content: "Date : "; font-weight: 600; color: #000; }
    .modal-body tbody td:nth-child(6):before { content: "Last Actioned : "; font-weight: 600; color: #000; }

    .modal-header h4 { font-size: 18px !important; }
    .modal-header .close { font-size: 22px !important; }
    #card_header { padding: 0 !important; }
}
</style>

<style>
    /* Standard Desktop Sizing Constraints */
    @media (min-width: 769px) {
        #align th, #align td {
            vertical-align: middle !important;
            font-size: 13px !important;
        }
        .is-co-col { width: 15% !important; }
        .status-col { width: 10% !important; white-space: nowrap !important; }
        .meeting-time-col { width: 15% !important; white-space: nowrap !important; }
    }

    /* ==========================================
       TABLET-ONLY (769px - 1024px) – optimise column widths & text wrapping
       ========================================== */
    @media (min-width: 769px) and (max-width: 1024px) {
        .table-responsive {
            overflow-x: auto !important;
            -webkit-overflow-scrolling: touch !important;
        }

        #align {
            table-layout: fixed !important;
            width: 100% !important;
            min-width: 780px !important;
        }

        /* Column widths – balanced for tablet readability */
        #align th:nth-child(1),
        #align td:nth-child(1) {
            width: 6% !important;
        }
        #align th:nth-child(2),
        #align td:nth-child(2) {
            width: 15% !important;   /* Child Name – wrap */
        }
        #align th:nth-child(3),
        #align td:nth-child(3) {
            width: 13% !important;   /* Enrollment ID */
        }
        #align th:nth-child(4),
        #align td:nth-child(4) {
            width: 18% !important;   /* IS Coordinators – wrap */
        }
        #align th:nth-child(5),
        #align td:nth-child(5) {
            width: 16% !important;   /* Meeting Date & Time – wrap */
        }
        #align th:nth-child(6),
        #align td:nth-child(6) {
            width: 10% !important;   /* Status – no wrap */
        }
        #align th:nth-child(7),
        #align td:nth-child(7) {
            width: 22% !important;   /* Action – keep buttons inline */
        }

        /* Allow wrapping for columns that may have long content */
        #align th:nth-child(2),
        #align td:nth-child(2),
        #align th:nth-child(4),
        #align td:nth-child(4),
        #align th:nth-child(5),
        #align td:nth-child(5) {
            white-space: normal !important;
            word-break: normal !important;
            overflow-wrap: break-word !important;
        }

        /* Keep Sl. No., Status, Action single-line */
        #align th:nth-child(1),
        #align td:nth-child(1),
        #align th:nth-child(6),
        #align td:nth-child(6),
        #align th:nth-child(7),
        #align td:nth-child(7) {
            white-space: nowrap !important;
        }

        /* Action buttons – compact and inline */
        #align td:nth-child(7) {
            white-space: nowrap !important;
        }
        #align td:nth-child(7) .btn {
            display: inline-block !important;
            font-size: 11px !important;
            padding: 2px 6px !important;
            margin: 0 2px !important;
            white-space: nowrap !important;
            border-radius: 4px !important;
            vertical-align: middle !important;
        }
        #align td:nth-child(7) .btn-link i {
            font-size: 13px !important;
            vertical-align: middle !important;
        }

        /* "Resend" button – keep compact */
        #align td:nth-child(7) .resend-btn {
            font-size: 11px !important;
            padding: 2px 6px !important;
        }
    }
</style>

<div class="main-content">

  {{ Breadcrumbs::render('ovm2.index') }}
  
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

  <div class="section-body mt-2">
    <div class="row">
      <div class="col-12">
        <div class="card">
          <div class="card-body">
            <div class="row">
              <div class="col-lg-12 text-center">
                <h4 style="color:darkblue;">OVM-2 List View</h4>
              </div>
            </div>

            <div class="table-wrapper">
              <div class="table-responsive">
                <table class="table table-bordered" id="align">
                  <thead>
                    <tr>
                      <th width="50px">Sl. No.</th>
                      <th>Child Name</th>
                      <th>Enrollment Id</th>
                      <th class="is-co-col">IS Coordinater Name</th>
                      <th class="meeting-time-col">Meeting Date & Time</th>
                      <th class="status-col">Status</th>
                      <th style="width: 100px;">Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach($rows as $key=>$row)
                    <tr>
                      <td>{{ $loop->iteration }}</td>
                      <td>{{ $row['child_name']}}</td>
                      <td>{{ $row['enrollment_id']}}</td>
                      @if($row['is_coordinator2'] == [])
                      <td class="is-co-col">{{ $row['is_coordinator1']['name']}}</td>
                      @else
                      <td class="is-co-col">{{ $row['is_coordinator1']['name']}},{{ $row['is_coordinator2']['name']}}</td>
                      @endif
                      <td class="meeting-time-col">{{ $row['meeting_startdate']}} & {{ date('h:i A', strtotime($row['meeting_starttime'])) }}</td>
                      <td class="status-col">{{ $row['meeting_status']}}</td>
                      <td class="text-center">
                        <form method="POST" action="">
                          @php
                          $moId = $row['ovm_meeting_id'];
                          $row['ovm_meeting_id'] = Crypt::encrypt($row['ovm_meeting_id']);
                          @endphp

                          <a class="btn btn-link" title="Show" href="{{ route('ovm2.show', $row['ovm_meeting_id']) }}">
                            <i class="fas fa-eye" style="color: blue !important"></i>
                          </a>

                          @if($row['meeting_status'] == 'Accepted' || $row['meeting_status'] == 'Declined' || $row['meeting_status'] == 'Hold' || $row['meeting_status'] == 'Reschedule Request')
                          <a class="btn btn-link" title="Edit" href="{{ route('ovmsent2', $row['ovm_meeting_id']) }}">
                            <i class="fas fa-pencil-alt" style="color:green"></i>
                          </a>
                          @elseif($row['meeting_status'] == 'Sent' || $row['meeting_status'] == 'Rescheduled')
                          <a class="btn btn-link resend-btn" title="Resend" href="{{ route('ovm1resend', ['ovm2', Crypt::encrypt($row['event_id'])]) }}" onclick="disableResend(this)">
                            Resend
                          </a>
                          <a class="btn btn-link" title="Edit" href="{{ route('ovmsent2', $row['ovm_meeting_id']) }}">
                            <i class="fas fa-pencil-alt" style="color:green"></i>
                          </a>
                          @elseif($row['meeting_status'] != 'Completed')
                          <a class="btn btn-link" title="Edit" href="{{ route('ovm2.edit', $row['ovm_meeting_id']) }}">
                            <i class="fas fa-pencil-alt" style="color:green"></i>
                          </a>
                          @endif

                          @csrf
                          <a href="#addModal" data-toggle="modal" data-target="#addModal{{$moId}}" class="btn btn-primary" title="View" style="margin-inline:5px">
                            <i class="fa fa-bars" style="color:white!important"></i>
                          </a>
                          <input type="hidden" name="delete_id" id="{{ $row['ovm_meeting_id'] }}" value="{{ route('ovm2.delete', $row['ovm_meeting_id']) }}">
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
  </div>

  @foreach($rows as $key=>$row)
  <div class="modal fade" id="addModal{{$row['ovm_meeting_id']}}">
    <div class="modal-dialog modal-xl">
      <div class="modal-content">
        <div class="main-contents">
          <section class="section">
            <div class="modal-header bg-primary" style=" background-color: rgb(0 103 172) !important;">
              <h4 class="modal-title">Sail Activity</h4>
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            </div>
            <div class="modal-body" style="background-color: #edfcff !important;">
              <div class="section-body mt-2">
                <div class="row">
                  <div class="col-12">
                    <div class="mt-0 ">
                      <div class="card-body" id="card_header">
                        <div class="row"></div>
                        <div class="table-wrapper">
                          <div class="table-responsive p-3">
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
                                @if($row['ovm_meeting_id'] == $data['audit_table_id'])
                                <tr>
                                  <td>{{$loop->iteration}}</td>
                                  <td>{{$data['enrollment_id']}}</td>
                                  <td>{{$data['child_name']}}</td>
                                  <td>{{$data['audit_action']}}</td>
                                  <td>
                                    <script>
                                      var dateString = "{{ $data['action_date_time'] }}";
                                      var formattedDateString = dateString.replace(/-/g, '/') + ' UTC';
                                      var utcDate = new Date(formattedDateString);
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
            </div>
          </section>
        </div>
      </div>
    </div>
  </div>
  @endforeach

</div>

<script>
  function disableResend(el) {
    el.style.pointerEvents = "none";
    el.style.opacity = "0.5";
    el.innerText = "Resent";
    setTimeout(() => {
      el.style.pointerEvents = "none";
    }, 100);
  }
</script>

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
          swal.fire("Deleted!", "Scheduled OVM meeting bave Been deleted!", "success");
          var url = $('#' + id).val();
          window.location.href = url;
        } else {
          swal.fire("Cancelled", "Your Data is safe :)", "error");
          e.preventDefault();
        }
      });
  }
</script>

<script>
$(document).ready(function() {
    // Symmetrical row toggle interaction handling click events accurately
    $('#align tbody').on('click', 'tr', function(e) {
        if ($(e.target).closest('a, button, input, form').length) {
            return;
        }
        if ($(window).width() <= 768) {
            $(this).toggleClass('expanded-row');
        }
    });
});
</script>
@endsection