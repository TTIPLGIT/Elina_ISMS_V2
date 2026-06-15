@extends('layouts.adminnav')

@section('content')
<style>
/* =========================================================================
   MOBILE RESPONSIVE STYLING - SYNCHRONIZED COMPONENT CONFIGURATION
   ========================================================================= */

.table-responsive {
    overflow-x: auto;
    -webkit-overflow-scrolling: touch;
}

/* DataTables search elements spacing normalization rules */
.dataTables_wrapper .dataTables_length {
    float:left;
    margin-bottom: 15px;
    margin-left: 10px;
}
.dataTables_wrapper .dataTables_filter {
    float:left;
    margin-bottom: 15px;
}

@media (max-width: 768px) {

    /* Align DataTables length entries dropdown and search filter elements dynamically on mobile */

    .dataTables_wrapper .dataTables_filter {
        float: none !important;
        text-align:right !important;
        width: 100% !important;
        margin-bottom: 10px !important;
    }
    .dataTables_wrapper .dataTables_filter input {
        width:75% !important;
        margin-left: 0 !important;
        margin-top: 5px !important;
        margin-right:10px;
    }

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

    .btn-labeled {
        width: auto !important;
        margin-bottom: 15px !important;
        margin-left: 5px !important;
        text-align: left !important;
        padding: 3px 10px !important;
        display: inline-block !important;
        font-size: 11px !important;
    }

    .btn-labeled .btn-label {
        background: transparent !important;
        border: none !important;
        padding: 0 !important;
        margin-right: 5px !important;
        font-size: 11px !important;
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
        padding: 10px 15px 10px 15px !important; /* Adjusted left-padding since Sl No is hidden */
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

    /* 1. Sl No Badge Placement - Completely hidden on mobile accordion */
    #align td:nth-of-type(1) {
        display: none !important;
    }

    /* 3. Child Name Layout Details - ALWAYS VISIBLE */
    #align td:nth-of-type(3) {
        display: block !important;
        font-weight: 600 !important;
        font-size: 15px !important;
        color: #2c3e50 !important;
        margin-bottom: 4px !important;
        padding-right: 25px !important;
        order: 1 !important;
    }
    #align td:nth-of-type(3):before {
        content: "Child Name: ";
        font-weight: 600 !important;
        color: #000 !important;
    }

    /* 5. Questionnaire Name - ALWAYS VISIBLE */
    #align td:nth-of-type(5) {
        display: block !important;
        font-size: 13px !important;
        color: #34495e !important;
        margin-bottom: 4px !important;
        order: 2 !important;
    }
    #align td:nth-of-type(5):before {
        content: "Questionnaire Name: ";
        font-weight: 600 !important;
        color: #000 !important;
    }

    /* 6. Status Badge Container - ALWAYS VISIBLE */
    #align td:nth-of-type(6) {
        display: block !important;
        font-size: 12px !important;
        color: #34495e !important;
        margin-bottom: 0px !important;
        order: 3 !important;
    }
    #align td:nth-of-type(6):before {
        content: "Status: ";
        font-weight: 600 !important;
        color: #000 !important;
    }

    /* 2. Enrollment ID Header Placement - HIDDEN BY DEFAULT (Shows on open only) */
    #align td:nth-of-type(2) {
        display: none !important;
        order: 4 !important;
    }
    #align tr.expanded-row td:nth-of-type(2) {
        display: block !important;
        margin-top: 6px !important;
        font-size: 12px !important;
        color: #34495e !important;
    }
    #align tr.expanded-row td:nth-of-type(2):before {
        content: "Enrollment Id: ";
        font-weight: 600 !important;
        color: #000 !important;
    }

    /* 4. Stage - HIDDEN BY DEFAULT (Shows on open only) */
    #align td:nth-of-type(4) {
        display: none !important;
        order: 5 !important;
    }
    #align tr.expanded-row td:nth-of-type(4) {
        display: block !important;
        margin-top: 6px !important;
        font-size: 12px !important;
        color: #34495e !important;
    }
    #align tr.expanded-row td:nth-of-type(4):before {
        content: "Stage: ";
        font-weight: 600 !important;
        color: #000 !important;
    }

    /* 7. Action Toolbar Row - HIDDEN BY DEFAULT (Shows on open only) */
    #align td:nth-of-type(7) {
        display: none !important;
        order: 6 !important;
    }
    #align tr.expanded-row td:nth-of-type(7) {
        display: flex !important;
        align-items: center !important;
        flex-wrap: nowrap !important;
        gap: 6px !important;
        margin-top: 8px !important;
        white-space: nowrap !important;
    }
    #align tr.expanded-row td:nth-of-type(7):before {
        content: "Action:";
        font-weight: 600 !important;
        color: #000 !important;
        margin-right: 6px !important;
        flex-shrink: 0 !important;
    }

    /* Interactive Chevron UI Icon */
    #align tr::after {
        content: '\f054';
        font-family: 'FontAwesome';
        position: absolute;
        right: 15px;
        top: 30px; /* Aligned center relative to always-visible fields */
        color: #bdc3c7;
        transition: transform 0.3s;
        font-size: 12px;
    }

    #align tr.expanded-row::after {
        transform: rotate(90deg);
        top: 30px;
    }

    /* Inline Interactive Controls inside Opened Accordion */
    #align tr.expanded-row td:nth-of-type(7) a,
    #align tr.expanded-row td:nth-of-type(7) button {
        display: inline-flex !important;
        align-items: center !important;
        justify-content: center !important;
        margin-right: 0 !important;
        padding: 4px 10px !important;
        font-size: 14px !important;
        background: #f8f9fa !important;
        border: 1px solid #ddd !important;
        border-radius: 6px !important;
        box-shadow: 0 1px 2px rgba(0,0,0,0.05) !important;
    }

    /* Empty Fallback Structuring */
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

    .card-body h4 {
        font-size: 18px !important;
    }
}
</style>

<style>
    /* Standard Desktop Grid Normalization Rules */
    @media (min-width: 769px) {
        #align th, #align td {
            vertical-align: middle !important;
            font-size: 13px !important;
        }
    }
</style>

<div class="main-content">
  {{ Breadcrumbs::render('ovm.questionnaire') }}
  
  <section class="section">
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
          <a type="button" href="{{ route('ovm.questionnaire.initiate') }}" class="btn btn-labeled btn-info" title="create" style="background: #044a95 !important; border-color:#a9ca !important; color:white !important; margin-top: 0.5rem;">
            <span class="btn-label" style="font-size:15px !important; padding:8px !important"><i class="fa fa-plus"></i></span>
            <span style="font-size:15px !important; padding:8px !important">Initiation</span>
          </a>
          
          <div class="card">
            <div class="card-body">
              <div class="row">
                <div class="col-lg-12 text-center">
                  <h4 style="color:darkblue;">Parent Feedback List View</h4>
                </div>
              </div>

              <div class="table-wrapper">
                <div class="table-responsive">
                  <table class="table table-bordered" id="align">
                    <thead>
                      <tr>
                        <th width="50px">Sl.No.</th>
                        <th>Enrollment Id</th>
                        <th>Child Name</th>
                        <th>Stage</th>
                        <th>Questionnaire Name</th>
                        <th>Status</th>
                        <th style="width: 100px;">Action</th>
                      </tr>
                    </thead>
                    <tbody>
                      @foreach($rows as $key=>$row)
                      <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $row['enrollment_child_num'] }}</td>
                        <td>{{ $row['child_name'] }}</td>
                        <td>OVM</td>
                        <td>{{ $row['questionnaire_name'] }}</td>
                        @if($row['questatus'] == 'Save')
                        <td>In-Progress</td>
                        @else
                          @if(in_array($user_id, explode(',', $row['viewed_users'])))
                          <td>Viewed</td>
                          @else
                          <td>{{ $row['questatus'] }}</td>
                          @endif
                        @endif
                        <td class="text-center">
                          @if($row['questatus'] == 'Submitted')
                          <a class="btn btn-link" title="Show" id="{{ $row['questionnaire_initiation_id'] }}" href="{{ route('questionnaire.submitted.form', \Crypt::encrypt($row['questionnaire_initiation_id'])) }}">
                            <i class="fas fa-eye" style="color: blue !important"></i>
                          </a>
                          @endif
                          
                          @if($row['questatus'] != 'Submitted')
                          <input type="hidden" name="delete_id" id="{{ $row['questionnaire_initiation_id'] }}" value="{{ route('sail.delete', \Crypt::encrypt($row['questionnaire_initiation_id'])) }}">
                          <a class="btn btn-link" title="Delete" onclick="return myFunction({{ $row['questionnaire_initiation_id'] }});">
                            <i class="far fa-eye"></i>
                          </a>
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
  function myFunction(id) {
    Swal.fire("The parent has not yet submitted the questionnaire.", "", "info");
  }
</script>

<script>
$(document).ready(function() {
    // Symmetrical responsive parent row view logic toggle expansion
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