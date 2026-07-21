@extends('layouts.adminnav')

@section('content')
<style>
  /* ===== BASE STYLES (existing) ===== */
  .swal-popup-custom .swal2-html-container {
    overflow-x: auto;
  }
  .swal-popup-custom .swal2-popup {
    max-width: 90%;
  }
  .swal-popup-custom .swal2-table {
    width: 100%;
  }
  .swal-popup-custom table {
    width: 100%;
    border-collapse: collapse;
  }
  .swal-popup-custom th,
  .swal-popup-custom td {
    padding: 8px;
    text-align: left;
    border: 1px solid #ddd;
  }
  .swal-popup-custom th {
    background-color: #f4f4f4;
  }
  td {
    border-color: black !important;
  }

  /* ===== DESKTOP/TABLET COLUMN WIDTHS ===== */
  #align {
    table-layout: fixed;
    width: 100%;
    border-collapse: collapse;
  }
  #align th:nth-child(1),
  #align td:nth-child(1) { width: 6%; }   /* Sl. No. */
  #align th:nth-child(2),
  #align td:nth-child(2) { width: 20%; }  /* Enrollment Id */
  #align th:nth-child(3),
  #align td:nth-child(3) { width: 16%; }  /* Child Name */
  #align th:nth-child(4),
  #align td:nth-child(4) { width: 18%; }  /* Report */
  #align th:nth-child(5),
  #align td:nth-child(5) { width: 16%; }  /* Status */
  #align th:nth-child(6),
  #align td:nth-child(6) { width: 24%; }  /* Action */

  #align th,
  #align td {
    word-break: break-word;
    white-space: normal;
    overflow-wrap: break-word;
    padding: 8px 6px;
    text-align: center;
    vertical-align: middle;
  }

  /* ===== TABLET (769px – 1024px) ===== */
  @media (min-width: 769px) and (max-width: 1024px) {
    .table-responsive {
      overflow-x: auto !important;
      -webkit-overflow-scrolling: touch !important;
    }
    #align {
      table-layout: fixed !important;
      width: 100% !important;
      min-width: 700px !important;
    }
    /* Fine‑tune column widths */
    #align th:nth-child(1),
    #align td:nth-child(1) { width: 7% !important; }
    #align th:nth-child(2),
    #align td:nth-child(2) { width: 18% !important; }
    #align th:nth-child(3),
    #align td:nth-child(3) { width: 16% !important; }
    #align th:nth-child(4),
    #align td:nth-child(4) { width: 18% !important; }
    #align th:nth-child(5),
    #align td:nth-child(5) { width: 13% !important; }
    #align th:nth-child(6),
    #align td:nth-child(6) { width: 28% !important; }
    /* Allow wrapping for text columns */
    #align th:nth-child(2),
    #align td:nth-child(2),
    #align th:nth-child(3),
    #align td:nth-child(3),
    #align th:nth-child(4),
    #align td:nth-child(4) {
      white-space: normal !important;
      word-break: normal !important;
      overflow-wrap: break-word !important;
    }
    /* Keep Sl. No., Status, Action single-line */
    #align th:nth-child(1),
    #align td:nth-child(1),
    #align th:nth-child(5),
    #align td:nth-child(5),
    #align th:nth-child(6),
    #align td:nth-child(6) {
      white-space: nowrap !important;
    }
    /* Action buttons compact */
    #align td:nth-child(6) .btn {
      display: inline-block !important;
      font-size: 11px !important;
      padding: 2px 6px !important;
      margin: 0 2px !important;
      white-space: nowrap !important;
      border-radius: 4px !important;
      vertical-align: middle !important;
    }
    #align td:nth-child(6) .btn-link i {
      font-size: 13px !important;
      vertical-align: middle !important;
    }
  }

  /* ===== MOBILE (≤ 768px) – card‑style rows ===== */
  .table-responsive {
    overflow-x: auto;
    -webkit-overflow-scrolling: touch;
  }

  @media (max-width: 768px) {
    .main-content,
    .card,
    .card-body,
    .table-wrapper,
    .searchResultStudent,
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
    .searchResultStudent table,
    .searchResultStudent thead,
    .searchResultStudent tbody,
    .searchResultStudent th,
    .searchResultStudent td {
      display: block !important;
      width: 100% !important;
    }
    .searchResultStudent thead {
      display: none !important;
    }
    .searchResultStudent tbody {
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

    /* Sl. No. – absolute left */
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
    #align td:nth-of-type(3) {
      display: block !important;
      font-weight: 600 !important;
      font-size: 16px !important;
      color: #2c3e50 !important;
      margin-bottom: 4px !important;
      padding-right: 25px !important;
      order: 1 !important;
    }
    /* Enrollment ID */
    #align td:nth-of-type(2) {
      display: block !important;
      font-size: 13px !important;
      color: #34495e !important;
      margin-bottom: 10px !important;
      order: 2 !important;
    }
    #align td:nth-of-type(2):before {
      content: "ID: ";
      font-weight: 600 !important;
      color: #000 !important;
    }

    /* Hidden by default: Report, Status, Action */
    #align td:nth-of-type(4),
    #align td:nth-of-type(5),
    #align td:nth-of-type(6) {
      display: none !important;
    }

    /* Arrow indicator */
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

    /* Expanded: show Report, Status, Action with labels */
    #align tr.expanded-row td:nth-of-type(4) {
      display: block !important;
      margin-top: 8px !important;
      font-size: 12px !important;
      color: #34495e !important;
      order: 3 !important;
    }
    #align tr.expanded-row td:nth-of-type(4):before {
      content: "Report: ";
      font-weight: 600 !important;
      color: #000 !important;
    }

    #align tr.expanded-row td:nth-of-type(5) {
      display: block !important;
      margin-top: 6px !important;
      font-size: 12px !important;
      color: #34495e !important;
      order: 4 !important;
    }
    #align tr.expanded-row td:nth-of-type(5):before {
      content: "Status: ";
      font-weight: 600 !important;
      color: #000 !important;
    }

    /* Action row – flex, no wrap */
    #align tr.expanded-row td:nth-of-type(6) {
      display: flex !important;
      align-items: center !important;
      flex-wrap: nowrap !important;
      gap: 6px !important;
      margin-top: 6px !important;
      order: 5 !important;
      white-space: nowrap !important;
    }
    #align tr.expanded-row td:nth-of-type(6):before {
      content: "Action:";
      font-weight: 600 !important;
      color: #000 !important;
      margin-right: 6px !important;
      flex-shrink: 0 !important;
    }
    /* Action buttons/icons */
    #align tr.expanded-row td:nth-of-type(6) a {
      display: inline-flex !important;
      align-items: center !important;
      justify-content: center !important;
      margin-right: 0 !important;
      padding: 2px !important;
      font-size: 14px !important;
    }
    /* Republish button – keep compact */
    #align tr.expanded-row td:nth-of-type(6) .btn-labeled {
      font-size: 12px !important;
      padding: 2px 8px !important;
    }

    /* No records row – keep table‑row behaviour */
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

    /* DataTable controls */
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
</style>

<div class="main-content">
  {{ Breadcrumbs::render('assessmentreport.index') }}
  <section class="section">

    @if (session('success'))
      <input type="hidden" name="session_data" id="session_data" class="session_data" value="{{ session('success') }}">
      <script type="text/javascript">
        window.onload = function() {
          var message = $('#session_data').val();
          swal("Success", message, "success");
        }
      </script>
    @elseif(session('fail'))
      <input type="hidden" name="session_data" id="session_data1" class="session_data" value="{{ session('error') }}">
      <script type="text/javascript">
        window.onload = function() {
          var message = $('#session_data1').val();
          swal("Info", message, "info");
        }
      </script>
    @endif

    <div class="section-body mt-2">
      <div class="row">
        <div class="col-12">
          <a type="button" href="{{ route('assessmentreport.create') }}" value="Creat" class="btn btn-labeled btn-info" title="create" style="background: #044a95 !important; border-color:#a9ca !important; color:white !important;margin-top: 0.5rem;">
            <span class="btn-label" style="font-size:15px !important; padding:8px !important"><i class="fa fa-plus"></i></span><span style="font-size:15px !important; padding:8px !important">Assessment Report</span>
          </a>
          <div class="card">
            <div class="card-body">
              <div class="row">
                <div class="col-lg-12 text-center">
                  <h4 style="color:darkblue;">Assessment Report List view</h4>
                </div>
              </div>

              <div class="table-wrapper">
                <div class="table-responsive searchResultStudent">
                  <table class="table table-bordered" id="align">
                    <thead>
                      <tr>
                        <th>Sl. No.</th>
                        <th>Enrollment Id</th>
                        <th>Child Name</th>
                        <th>Report</th>
                        <th>Status</th>
                        <th>Action</th>
                      </tr>
                    </thead>
                    <tbody>
                      @foreach($rows as $data)
                      <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $data['enrollment_child_num'] }}</td>
                        <td>{{ $data['child_name'] }}</td>
                        <td>Assessment Report</td>
                        <td>{{ $data['current_state'] }}</td>
                        <td class="text-center">
                          @if($data['current_state'] != 'Published')
                            <a class="btn btn-link" title="Edit" href="{{ route('assessmentreport.edit', \Crypt::encrypt($data['report_id'])) }}"><i class="fas fa-pencil-alt" style="color: blue !important"></i></a>
                          @endif
                          @if($data['current_state'] != 'Saved' && $data['current_state'] != 'Published')
                            <a class="btn btn-link" title="Show" href="{{ route('assessment.report.preview', \Crypt::encrypt($data['report_id'])) }}"><i class="fas fa-eye" style="color: green !important"></i></a>
                          @endif
                          @if($data['current_state'] == 'Published')
                            <a class="btn btn-link" title="Show" href="{{ route('assessment.report.preview1', \Crypt::encrypt($data['report_id'])) }}"><i class="fas fa-eye" style="color: green !important"></i></a>
                            @if($data['republishCount'] < 2)
                              <a class="btn btn-labeled btn-info" title="Republish" onclick="republish('{{ $data['report_id'] }}', '{{ $data['republishCount'] }}')"><i class="fa fa-repeat" style="color: green !important"></i> Republish</a>
                            @endif
                          @endif
                          @if($data['republishCount'] != 0)
                            <a class="btn btn-labeled btn-primary" title="Version Details" onclick="viewDetails('{{ $data['report_id'] }}', '{{ $data['enrollment_child_num'] }}', '{{ $data['child_name'] }}')"><i class="fa fa-info-circle"></i></a>
                          @endif
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
  </section>
</div>

<script src="https://code.jquery.com/jquery-1.7.2.min.js"></script>
<script type="application/javascript">
  // ===== REPUBLISH FUNCTION (unchanged) =====
  function republish(id, count) {
    if (count == 0) {
      var text = "The republish feature is limited to two times only.<br> Are you sure you want to republish this report?";
    } else {
      var text = "You have already republished the document once; this is your final opportunity to republish it again. <br> Are you sure you want to republish this report?";
    }
    Swal.fire({
      title: "Confirmation for Republish?",
      html: text,
      icon: "warning",
      showCancelButton: true,
      confirmButtonColor: '#DD6B55',
      confirmButtonText: 'Yes, I am sure!',
      cancelButtonText: "No, cancel it!",
      reverseButtons: true
    }).then((result) => {
      if (result.isConfirmed) {
        Swal.fire({
          title: 'Enter Comment/Reason',
          input: 'textarea',
          inputPlaceholder: 'Type your comment here...',
          inputAttributes: {
            'aria-label': 'Type your comment here'
          },
          showCancelButton: true,
          confirmButtonText: 'Submit',
          cancelButtonText: 'Cancel',
          inputValidator: (value) => {
            if (!value) {
              return 'You need to write a comment!';
            }
          }
        }).then((commentResult) => {
          if (commentResult.isConfirmed) {
            var comment = commentResult.value;
            $.ajax({
              url: "{{ url('/assessment/report/republish') }}",
              type: 'POST',
              data: {
                'reportID': id,
                'comment': comment,
                'type': 'assessment',
                _token: '{{ csrf_token() }}'
              }
            }).done(function(data) {
              console.log('Success', data);
              var reportID = data.reportID;
              window.location.href = "{{ route('assessmentreport.edit', '__REPORT_ID__') }}".replace('__REPORT_ID__', reportID);
            })
          } else {
            Swal.fire("Cancelled", "Report republish is cancelled", "error");
          }
        });
      } else {
        Swal.fire("Cancelled", "Report republish is cancelled", "error");
      }
    });
  }

  // ===== VIEW DETAILS FUNCTION (unchanged) =====
  function viewDetails(id, enrollmentNo, name) {
    $.ajax({
      url: "{{ url('/assessment/report/get/comments') }}",
      type: 'GET',
      data: {
        'reportID': id,
        'type': 'assessment',
        _token: '{{ csrf_token() }}'
      },
      success: function(data) {
        var html = '<h5>Version History of ' + name + ' (' + enrollmentNo + ')</h5>';
        html += '<table class="table table-bordered"><thead><tr><th style="text-align: center;">S No</th><th style="text-align: center;">Description</th><th style="text-align: center;">Changed By</th><th style="text-align: center;">Date</th></tr></thead><tbody>';

        data.forEach(function(change) {
          const date = new Date(change.change_date.replace(' ', 'T') + 'Z');
          const options = {
            day: '2-digit',
            month: 'short',
            year: 'numeric'
          };
          const formattedDate = date.toLocaleDateString('en-GB', options);
          html += `<tr>
                     <td style="border-color: black !important;">${change.version_number}</td>
                     <td style="border-color: black !important;">${change.change_description}</td>
                     <td style="border-color: black !important;">${change.changed_by}</td>
                     <td style="border-color: black !important;">${formattedDate}</td>
                   </tr>`;
        });

        html += '</tbody></table>';

        Swal.fire({
          html: html,
          confirmButtonText: 'Close',
          customClass: {
            popup: 'swal-popup-custom'
          },
          width: '90%'
        });
      },
      error: function() {
        Swal.fire("Error", "Failed to fetch details", "error");
      }
    });
  }

  // ===== MOBILE EXPAND/CONTRACT ON ROW CLICK (from OVM‑1) =====
  $(document).ready(function() {
    $('#align tbody').on('click', 'tr', function(e) {
      // Ignore clicks inside links, buttons, inputs, forms
      if ($(e.target).closest('a, button, input, form').length) {
        return;
      }
      // Only toggle on small screens (max-width: 768px)
      if ($(window).width() <= 768) {
        $(this).toggleClass('expanded-row');
      }
    });
  });
</script>
@endsection