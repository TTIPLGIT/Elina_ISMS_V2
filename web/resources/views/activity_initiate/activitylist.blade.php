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

    /* Enrollment ID */
    table[id^="align"] td:nth-of-type(2) { display: block !important; font-size: 13px !important; color: #34495e !important; margin-bottom: 10px !important; order: 2 !important; }
    table[id^="align"] td:nth-of-type(2):before { content: "ID: "; font-weight: 600 !important; color: #000 !important; }

    /* Child Name */
    table[id^="align"] td:nth-of-type(3) { display: block !important; font-weight: 600 !important; font-size: 16px !important; color: #2c3e50 !important; margin-bottom: 4px !important; padding-right: 25px !important; order: 1 !important; }

    /* Action Row - hidden initially */
    table[id^="align"] td:nth-of-type(4) { display: none !important; }
    table[id^="align"] tr.expanded-row td:nth-of-type(4) { display: flex !important; align-items: center !important; gap: 6px !important; margin-top: 6px !important; order: 3 !important; }
    table[id^="align"] tr.expanded-row td:nth-of-type(4):before { content: "Action:"; font-weight: 600 !important; color: #000 !important; margin-right: 6px !important; flex-shrink: 0 !important; }
    
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

    .mobile-btn-row {
        display: flex !important;
        flex-direction: column !important;
        width: 100% !important;
        gap: 8px !important;
    }

    .mobile-btn-row .btn-activity {
        align-self: flex-start !important;
        margin-left: 0 !important;
    }

    .mobile-btn-row .btn-privacy {
        align-self: flex-end !important;
        margin-right: 0 !important;
        float: none !important;
    }
}
</style>
<div class="main-content">
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
    {{ Breadcrumbs::render('activity_initiate.index') }}
    <div class="row">
        <div class="col-12">
            <div class="mobile-btn-row">
            <a type="button" href="{{ route('activity_initiate.create') }}" value="Cancel" class="btn btn-labeled btn-info btn-activity" title="create" style="background: #044a95 !important; border-color:#a9ca !important; color:white !important;margin-top: 0.5rem;">
                <span class="btn-label" style="font-size:15px !important; padding:8px !important"><i class="fa fa-plus"></i></span><span style="font-size:15px !important; padding:8px !important">Activity Initiation</span></a>
            <a type="button" href="{{ route('privacy.update',\Crypt::encrypt('2')) }}" value="Cancel" class="btn mb-3 btn-labeled btn-info btn-privacy" title="create" style="background: #044a95 !important;float: right; border-color:#a9ca !important; color:white !important;margin-top: 0.5rem;">
                <span class="btn-label" style="font-size:15px !important; padding:8px !important;left: 0;background: none;">Privacy Agreement</span></a>
            </div>
            <!-- <a type="button" style="font-size:15px;" class="btn btn-success btn-lg" title="Create" id="gcb" href="{{ route('newenrollment.create') }}">NewEnrollment<i class="fa fa-plus" aria-hidden="true"></i></a> -->
            <div class="card">
                <div class="card-body">
                <div class="col-lg-12 text-center">
            <h4 class="text-center" style="color:darkblue">Activity Initiated List</h4>
</div>
                    <div class="table-wrapper">
                        <div class="table-responsive">
                            <table class="table table-bordered" id="align1">
                                <thead>
                                    <tr>
                                        <th>Sl.No</th>
                                        <th>Enrollment ID</th>
                                        <th>Child Name</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($rows as $key=>$row)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $row['enrollment_child_num']}}</td>
                                        <td>{{ $row['child_name']}}</td>
                                        <td>
                                            @if($row['status'] != 'Complete' || $row['status'] != 'Close' )
                                            <a class="btn btn-link" title="Edit" href="{{route('activity_initiate.edit',\Crypt::encrypt($row['activity_initiation_id']))}}"><i class="fa fa-pencil-square-o" style="color:green"></i></a>
                                            @else
                                            <a class="btn btn-link" title="Show" href="{{route('activity_initiate.edit',\Crypt::encrypt($row['activity_initiation_id']))}}"><i class="fas fa-eye" style="color:green"></i></a>
                                            @endif
                                            <a class="btn btn-link" title="Face to Face Observation" href="{{route('activityinitiate.observation',\Crypt::encrypt($row['activity_initiation_id']))}}"><i class="fa fa-file-code-o" style="color:green"></i></a>

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

<script>
    var com = <?php echo (json_encode($com)); ?>;
    var total = <?php echo (json_encode($total)); ?>;
    var rows = <?php echo (json_encode($rows)); ?>;

    for (i = 0; i < rows.length; i++) {

        var a = rows[i];
        var activity_initiation_id = a.activity_initiation_id;
        var activityID = a.activity_id;

        var ppp = 0;
        var ccc = 0;
        for (j = 0; j < total.length; j++) {
            var totalactivity_id = total[j].activity_id;
            if (totalactivity_id == activityID) {
                var ppp = total[j].total;
            }
        }

        for (k = 0; k < com.length; k++) {
            var comactivity_id = com[k].activity_initiation_id;
            if (comactivity_id == activity_initiation_id) {
                var ccc = com[k].complete;
            }
        }

        var id = a.activity_initiation_id;
        var no_questions = a.no_questions;
        var per = ((ccc / ppp) * 100).toFixed(3);
        var idi = '#'.concat(id);
        var title = 'Completed '.concat(ccc) + ' of '.concat(ppp);

        $(idi).attr('aria-valuenow', title).css('width', per + '%');
        var div = document.getElementById(id);
        div.innerHTML += ccc + ' / ' + ppp;

        if (per < 25) {
            document.getElementById(id).classList.add('bg-danger');
        } else if (per < 80) {
            document.getElementById(id).classList.add('bg-warning');
        } else if (per >= 80) {
            document.getElementById(id).classList.add('bg-success');
        }

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