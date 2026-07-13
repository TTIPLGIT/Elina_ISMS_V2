@extends('layouts.adminnav')

@section('content')
<style>
/* ============================================================
   DESKTOP LAYOUT – OVM‑1 STYLE
   ============================================================ */
.card-body .table-responsive {
    overflow-x: auto;
}

/* Header row: title left, search+button right (if you add back search later) */
.header-row {
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
    margin-bottom: 1rem;
}
.header-row h4 {
    color: darkblue;
    margin: 0;
    font-weight: 600;
}
.header-row .controls {
    display: flex;
    align-items: center;
    gap: 10px;
}
.header-row .controls input {
    width: 220px;
    padding: 0.375rem 0.75rem;
    font-size: 0.9rem;
    border: 1px solid #ced4da;
    border-radius: 0.25rem;
}
.header-row .controls .btn-init {
    background: #044a95 !important;
    border-color: #a9ca !important;
    color: white !important;
    font-size: 0.9rem;
    padding: 0.375rem 1rem;
    border-radius: 0.25rem;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 5px;
}
.header-row .controls .btn-init:hover {
    opacity: 0.9;
}

/* Table styling – fixed layout with percentage widths (desktop) */
#align {
    width: 100%;
    table-layout: fixed;
    border-collapse: collapse;
    font-size: 0.9rem;
}
#align thead th {
    background: #f8f9fa;
    font-weight: 600;
    border-bottom: 2px solid #dee2e6;
    padding: 0.75rem;
    text-align: center;
}
#align tbody td {
    padding: 0.75rem;
    vertical-align: middle;
    border-bottom: 1px solid #dee2e6;
    word-wrap: break-word;
}
#align tbody tr:hover {
    background-color: #f5f7fa;
}

/* -------- PERCENTAGE COLUMN WIDTHS (Desktop) -------- */
#align th:nth-child(1), /* Sl.No. */
#align td:nth-child(1) {
    width: 5%;
    text-align: center;
}
#align th:nth-child(2), /* Child Name */
#align td:nth-child(2) {
    width: 35%;
    text-align: left;
}
#align th:nth-child(3), /* Enrollment Id */
#align td:nth-child(3) {
    width: 18%;
    text-align: left;
}
#align th:nth-child(4), /* Stage */
#align td:nth-child(4) {
    width: 6%;
    text-align: center;
}
#align th:nth-child(5), /* Questionnaire Name */
#align td:nth-child(5) {
    width: 20%;
    text-align: left;
}
#align th:nth-child(6), /* Status */
#align td:nth-child(6) {
    width: 10%;
    text-align: center;
}
#align th:nth-child(7), /* Action */
#align td:nth-child(7) {
    width: 6%;
    text-align: center;
    white-space: nowrap;
}

/* Action icons inside the cell */
#align .action-icons a {
    margin: 0 4px;
    color: #495057;
}
#align .action-icons a:hover {
    color: #044a95;
}

/* No data row */
#align td.dataTables_empty {
    text-align: center;
    padding: 2rem;
    color: #6c757d;
    font-weight: 500;
}

/* ============================================================
   TABLET ADJUSTMENTS (769px – 1024px)
   ============================================================ */
@media (min-width: 769px) and (max-width: 1024px) {
    #align {
        table-layout: auto !important;    /* columns size to content */
        width: 100% !important;
    }

    /* Reset all widths to auto, allow wrapping where needed */
    #align th,
    #align td {
        width: auto !important;
        max-width: none !important;
        white-space: nowrap !important;   /* default: no wrap */
        word-wrap: normal !important;
        overflow-wrap: normal !important;
    }

    /* Allow wrapping only on Child Name and Questionnaire Name */
    #align th:nth-child(2),
    #align td:nth-child(2),    /* Child Name */
    #align th:nth-child(5),
    #align td:nth-child(5) {   /* Questionnaire Name */
        white-space: normal !important;
        word-wrap: break-word !important;
        overflow-wrap: break-word !important;
        word-break: break-word !important;
        min-width: 100px !important;      /* prevent them from becoming too narrow */
    }

    /* Keep Enrollment Id, Stage, Status, Action on one line */
    #align th:nth-child(3),
    #align td:nth-child(3),    /* Enrollment Id */
    #align th:nth-child(4),
    #align td:nth-child(4),    /* Stage */
    #align th:nth-child(6),
    #align td:nth-child(6),    /* Status */
    #align th:nth-child(7),
    #align td:nth-child(7) {   /* Action */
        white-space: nowrap !important;
    }

    /* Give Sl.No. a small fixed width */
    #align th:nth-child(1),
    #align td:nth-child(1) {
        width: 50px !important;
        text-align: center;
    }

    #align thead th {
        text-align: center !important;
    }
}

/* ============================================================
   MOBILE RESPONSIVE (accordion cards) – FULLY PRESERVED
   ============================================================ */
@media (max-width: 768px) {
    .header-row {
        flex-direction: column;
        align-items: stretch;
        gap: 10px;
    }
    .header-row .controls {
        flex-wrap: wrap;
        justify-content: stretch;
    }
    .header-row .controls input {
        width: 100%;
        flex: 1;
    }
    .header-row .controls .btn-init {
        width: 100%;
        text-align: center;
        justify-content: center;
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
    .row, .col-12, .col-lg-12 {
        padding-left: 5px !important;
        padding-right: 5px !important;
    }
    .breadcrumb {
        font-size: 11px !important;
        margin-bottom: 10px !important;
        margin-top: 60px !important;
        margin-left: 10px !important;
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
        table-layout: auto !important;
    }
    #align tr {
        display: flex !important;
        flex-direction: column !important;
        align-items: stretch !important;
        border: 1px solid #e0e0e0 !important;
        border-radius: 8px !important;
        margin: 8px 5px !important;
        position: relative !important;
        padding: 10px 15px 10px 15px !important;
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
        max-width: 100% !important;
    }
    /* Hide Sl No */
    #align td:nth-of-type(1) {
        display: none !important;
    }
    /* Always visible: Child Name */
    #align td:nth-of-type(2) {
        display: block !important;
        font-weight: 600 !important;
        font-size: 15px !important;
        color: #2c3e50 !important;
        margin-bottom: 4px !important;
        padding-right: 25px !important;
        order: 1 !important;
    }
    #align td:nth-of-type(2):before {
        content: "Child Name: ";
        font-weight: 600 !important;
        color: #000 !important;
    }
    /* Always visible: Questionnaire Name */
    #align td:nth-of-type(5) {
        display: block !important;
        font-size: 13px !important;
        color: #34495e !important;
        margin-bottom: 4px !important;
        order: 2 !important;
    }
    #align td:nth-of-type(5):before {
        content: "Questionnaire: ";
        font-weight: 600 !important;
        color: #000 !important;
    }
    /* Always visible: Status */
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
    /* Hidden by default: Enrollment Id */
    #align td:nth-of-type(3) {
        display: none !important;
        order: 4 !important;
    }
    /* Hidden by default: Stage */
    #align td:nth-of-type(4) {
        display: none !important;
        order: 5 !important;
    }
    /* Hidden by default: Action */
    #align td:nth-of-type(7) {
        display: none !important;
        order: 6 !important;
    }
    /* Show hidden fields on expanded row */
    #align tr.expanded-row td:nth-of-type(3),
    #align tr.expanded-row td:nth-of-type(4),
    #align tr.expanded-row td:nth-of-type(7) {
        display: block !important;
    }
    #align tr.expanded-row td:nth-of-type(3):before {
        content: "Enrollment Id: ";
        font-weight: 600 !important;
        color: #000 !important;
    }
    #align tr.expanded-row td:nth-of-type(4):before {
        content: "Stage: ";
        font-weight: 600 !important;
        color: #000 !important;
    }
    #align tr.expanded-row td:nth-of-type(7):before {
        content: "Action:";
        font-weight: 600 !important;
        color: #000 !important;
        margin-right: 6px !important;
        flex-shrink: 0 !important;
    }
    #align tr.expanded-row td:nth-of-type(7) {
        display: flex !important;
        align-items: center !important;
        flex-wrap: nowrap !important;
        gap: 6px !important;
        margin-top: 8px !important;
        white-space: nowrap !important;
    }
    /* Chevron icon */
    #align tr::after {
        content: '\f054';
        font-family: 'FontAwesome';
        position: absolute;
        right: 15px;
        top: 30px;
        color: #bdc3c7;
        transition: transform 0.3s;
        font-size: 12px;
    }
    #align tr.expanded-row::after {
        transform: rotate(90deg);
        top: 30px;
    }
    /* Inline action buttons inside expanded row */
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
    /* Empty state */
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
          <div class="card">
           <div class="card-body">

    <!-- Heading Row -->
    <div class="row mb-3">
        <div class="col-12 text-center">
            <h4 class="mb-0" style="color: darkblue;">Parent Feedback List View</h4>
        </div>
    </div>

    <!-- Button Row -->
    <div class="row mb-3">
        <div class="col-12 text-start">
            <a href="{{ route('ovm.questionnaire.initiate') }}"
               class="btn btn-labeled btn-info"
               title="Create"
               style="background:#044a95; border-color:#044a95; color:#fff;">

                <span class="btn-label" style="font-size:15px; padding:8px;">
                    <i class="fa fa-plus"></i>
                </span>

                <span style="font-size:15px; padding:8px;">
                    Initiation
                </span>
            </a>
        </div>
    </div>

              <div class="table-wrapper">
                <div class="table-responsive">
                  <table class="table table-bordered" id="align">
                    <thead>
                    <tr>
    <th class="text-center">Sl.No.</th>
    <th class="text-center">Child Name</th>
    <th class="text-center">Enrollment Id</th>
    <th class="text-center">Stage</th>
    <th class="text-center">Questionnaire Name</th>
    <th class="text-center">Status</th>
    <th class="text-center">Action</th>
</tr>
                    </thead>
                    <tbody>
                      @forelse($rows as $key=>$row)
                      <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $row['child_name'] }}</td>
                        <td>{{ $row['enrollment_child_num'] }}</td>
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
                        <td class="action-icons text-center">
                          @if($row['questatus'] == 'Submitted')
                          <a class="btn btn-link" title="Show" href="{{ route('questionnaire.submitted.form', \Crypt::encrypt($row['questionnaire_initiation_id'])) }}">
                            <i class="fas fa-eye" style="color: blue !important"></i>
                          </a>
                          @endif
                          
                          @if($row['questatus'] != 'Submitted')
                          <input type="hidden" name="delete_id" value="{{ route('sail.delete', \Crypt::encrypt($row['questionnaire_initiation_id'])) }}">
                          <a class="btn btn-link" title="Delete" onclick="return myFunction({{ $row['questionnaire_initiation_id'] }});">
                            <i class="far fa-eye"></i>
                          </a>
                          @endif
                        </td>
                      </tr>
                      @empty
                      <tr>
                        <td colspan="7" class="text-center">No records found.</td>
                      </tr>
                      @endforelse
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
    // ---- REMOVE ANY DATATABLES WRAPPER / EXTRAS ----
    if ($.fn.DataTable) {
        var table = $('#align').DataTable();
        if (table) {
            table.destroy();
        }
    }
    $('.dataTables_wrapper').remove();
    $('#align').unwrap();

    // ---- MOBILE ACCORDION TOGGLE ----
    $('#align tbody').on('click', 'tr', function(e) {
        if ($(e.target).closest('a, button, input, form').length) {
            return;
        }
        if ($(window).width() <= 768) {
            $(this).toggleClass('expanded-row');
        }
    });

    // ---- CUSTOM SEARCH FILTER (if search input exists) ----
    // If you add a search input with id "searchInput", uncomment the following:
    /*
    $('#searchInput').on('keyup', function() {
        var value = $(this).val().toLowerCase();
        $('#align tbody tr').filter(function() {
            var childName = $(this).find('td:nth-child(2)').text().toLowerCase();
            var enrollment = $(this).find('td:nth-child(3)').text().toLowerCase();
            $(this).toggle(childName.indexOf(value) > -1 || enrollment.indexOf(value) > -1);
        });
    });
    */
});
</script>
@endsection