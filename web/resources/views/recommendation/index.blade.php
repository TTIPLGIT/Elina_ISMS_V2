@extends('layouts.adminnav')

@section('content')
<style>
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
</style>
<div class="main-content">
  {{ Breadcrumbs::render('recommendation.index') }}
  <section class="section">


    <div class="section-body mt-2">


      <div class="row">

        <div class="col-12">
          <a type="button" href="{{ route('recommendation.create') }}" value="Cancel" class="btn btn-labeled btn-info" title="create" style="background: #044a95 !important; border-color:#a9ca !important; color:white !important;margin-top: 0.5rem;">
            <span class="btn-label" style="font-size:15px !important; padding:8px !important"><i class="fa fa-plus"></i></span><span style="font-size:15px !important; padding:8px !important">Recommendation Report</span></a>
          <div class="card">

            <div class="card-body">
              <div class="row">
                <div class="col-lg-12 text-center">
                  <h4 style="color:darkblue;"> SAIL Recommendation Report</h4>
                </div>

              </div>






              <div class="table-wrapper">
                <div class="table-responsive">
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
                      @foreach($row as $data)
                      <tr>

                        <td>{{$loop->iteration}}</td>
                        <td>{{$data['enrollment_child_num']}}</td>
                        <td>{{$data['child_name']}}</td>
                        <td>Recommendation Report</td>
                        <td>{{$data['current_state']}}</td>
                        <td class="text-center">
                          @if($data['current_state'] != 'Published')
                          <a class="btn btn-link" title="Edit" href="{{ route('recommendation.edit', \Crypt::encrypt($data['report_id'])) }}"><i class="fas fa-pencil-alt" style="color: blue !important"></i></a>
                          @endif
                          @if($data['current_state'] != 'Saved' && $data['current_state'] != 'Published')
                          <a class="btn btn-link" title="show" href="{{ route('recommendation.report.render', \Crypt::encrypt($data['report_id'])) }}"><i class="fas fa-eye" style="color: green !important"></i></a>
                          @endif
                          @if($data['current_state'] == 'Published')
                          <a class="btn btn-link" title="show" href="{{ route('recommendation.report.render1', \Crypt::encrypt($data['report_id'])) }}"><i class="fas fa-eye" style="color: green !important"></i></a>
                          @if($data['republishCount'] < 2)
                            <a class="btn btn-labeled btn-info" title="Republish" onclick="republish('{{$data['report_id']}}' , '{{$data['republishCount']}}')"><i class="fa fa-repeat" style="color: green !important"></i> Republish</a>
                            @endif                           
                            @endif
                            @if($data['republishCount'] != 0)
                            <a class="btn btn-labeled btn-primary" title="Version Details" onclick="viewDetails('{{ $data['report_id'] }}' , '{{ $data['enrollment_child_num'] }}' , '{{ $data['child_name'] }}')"><i class="fa fa-info-circle"></i></a>
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


  </section>






</div>



<script src="https://code.jquery.com/jquery-1.7.2.min.js"></script>
<script type="application/javascript">
  function republish(id , count) {
    if(count == 0){
      var text = "The republish feature is limited two times only.<br> Are you sure you want to republish this report?";
    }else{
      var text = "You have already republished the document once; this is your final opportunity to republish it again. <br> Are you sure you want to republish this report?";
    }
    Swal.fire({
      title: "Confirmation For Republish?",
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
            // console.log(`Report ID: ${id}, Comment: ${comment}`);
            $.ajax({
              url: "{{ url('/assessment/report/republish') }}",
              type: 'POST',
              data: {
                'reportID': id,
                'comment': comment,
                'type': 'assessment',
                _token: '{{csrf_token()}}'
              }
            }).done(function(data) {
              console.log('Success', data);
              var reportID = data.reportID;
              window.location.href = "{{ route('recommendation.edit', '__REPORT_ID__') }}".replace('__REPORT_ID__', reportID);
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

  function viewDetails(id, enrollmentNo, name) {
    $.ajax({
      url: "{{ url('/assessment/report/get/comments') }}",
      type: 'GET',
      data: {
        'reportID': id,
        'type': 'assessment',
        _token: '{{csrf_token()}}'
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
          // title: 'Report Details',
          html: html,
          // icon: 'info',
          confirmButtonText: 'Close',
          customClass: {
            popup: 'swal-popup-custom'
          },
          confirmButtonText: 'Close',
          width: '90%'
        });
      },
      error: function() {
        Swal.fire("Error", "Failed to fetch details", "error");
      }
    });
  }
</script>

<style>
/* =========================================================================
   MOBILE RESPONSIVE STYLING - CARD VIEW (LIKE OVM-2)
   ========================================================================= */
@media (max-width: 768px) {
    .main-content, .card, .card-body, .table-wrapper, .table-responsive {
        padding-left: 0 !important;
        padding-right: 0 !important;
        margin-left: 0 !important;
        margin-right: 0 !important;
    }
    .row, .col-12, .col-lg-12 {
        padding-left: 5px !important;
        padding-right: 5px !important;
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
    .table-responsive table, .table-responsive thead, .table-responsive tbody, .table-responsive th, .table-responsive td {
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
    /* Sl No (Col 1) */
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
    /* Child Name (Col 3) */
    #align td:nth-of-type(3) {
        display: block !important;
        font-weight: 600 !important;
        font-size: 16px !important;
        color: #2c3e50 !important;
        margin-bottom: 4px !important;
        padding-right: 25px !important;
        order: 1 !important;
    }
    /* Enrollment ID (Col 2) */
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
    /* Hidden fields initially */
    #align td:nth-of-type(4),
    #align td:nth-of-type(5),
    #align td:nth-of-type(6) {
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
    /* Report (Col 4) */
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
    /* Status (Col 5) */
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
    /* Action (Col 6) */
    #align tr.expanded-row td:nth-of-type(6) {
        display: flex !important;
        align-items: center !important;
        flex-wrap: wrap !important;
        gap: 6px !important;
        margin-top: 6px !important;
        order: 5 !important;
        white-space: normal !important;
    }
    #align tr.expanded-row td:nth-of-type(6):before {
        content: "Action:";
        font-weight: 600 !important;
        color: #000 !important;
        margin-right: 6px !important;
        flex-shrink: 0 !important;
        width: 100% !important;
        margin-bottom: 5px !important;
    }
    /* Action buttons fix */
    #align tr.expanded-row td:nth-of-type(6) a,
    #align tr.expanded-row td:nth-of-type(6) button {
        display: inline-block !important;
        margin-bottom: 5px !important;
    }
    
    /* DataTable controls */
    .dataTables_wrapper .row:first-child { margin: 0 !important; }
    .dataTables_wrapper .dataTables_length { float: left !important; margin-left: 8px !important; }
    .dataTables_wrapper .dataTables_filter { float: right !important; padding-right: 8px !important; }
    .dataTables_wrapper .dataTables_length, .dataTables_wrapper .dataTables_filter, .dataTables_wrapper .dataTables_info, .dataTables_wrapper .dataTables_paginate { font-size: 10px !important; }
    .dataTables_wrapper .dataTables_length select { font-size: 11px !important; height: 32px !important; width: 60px !important; }
    .dataTables_wrapper .dataTables_filter input { width: 90px !important; height: 24px !important; font-size: 10px !important; }
}
</style>

<script>
$(document).ready(function() {
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