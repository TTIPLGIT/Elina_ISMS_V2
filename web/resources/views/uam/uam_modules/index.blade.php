@extends('layouts.adminnav')

@section('content')
<style>
  a:hover,
  a:focus {
    text-decoration: none;
    outline: none;
  }

  .danger {
    background-color: #ffdddd;
    border-left: 6px solid #f44336;
  }

  #align {
    border-collapse: collapse !important;
  }

  table.dataTable.no-footer {
    border-bottom: .5px solid #002266 !important;
  }

  thead th {
    height: 5px;
    border-bottom: solid 1px #ddd;
    font-weight: bold;
  }

  /* ==========================================
     MOBILE RESPONSIVE – CARD STYLE (same as OVM‑1)
     ========================================== */
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

    #align thead {
      display: none !important;
    }

    #align,
    #align tbody,
    #align tr,
    #align td {
      display: block !important;
      width: 100% !important;
    }

    #align tbody {
      background: transparent !important;
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

    /* Sl. No. – floating badge */
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

    /* Module Name – primary field */
    #align td:nth-of-type(3) {  /* Module Name is the 3rd column (after Sl.No and Parent) */
      display: block !important;
      font-weight: 600 !important;
      font-size: 16px !important;
      color: #2c3e50 !important;
      margin-bottom: 4px !important;
      padding-right: 25px !important;
      order: 1 !important;
    }

    /* Parent Module Name – hidden initially */
    #align td:nth-of-type(2) {
      display: none !important;
    }

    /* Display Order – hidden initially */
    #align td:nth-of-type(4) {
      display: none !important;
    }

    /* Action – hidden initially */
    #align td:nth-of-type(5) {
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

    /* Expanded fields */
    #align tr.expanded-row td:nth-of-type(2) { /* Parent Module Name */
      display: block !important;
      margin-top: 8px !important;
      font-size: 12px !important;
      color: #34495e !important;
      order: 2 !important;
    }
    #align tr.expanded-row td:nth-of-type(2):before {
      content: "Parent Module: ";
      font-weight: 600 !important;
      color: #000 !important;
    }

    #align tr.expanded-row td:nth-of-type(4) { /* Display Order */
      display: block !important;
      margin-top: 6px !important;
      font-size: 12px !important;
      color: #34495e !important;
      order: 3 !important;
    }
    #align tr.expanded-row td:nth-of-type(4):before {
      content: "Display Order: ";
      font-weight: 600 !important;
      color: #000 !important;
    }

    #align tr.expanded-row td:nth-of-type(5) { /* Action */
      display: flex !important;
      align-items: center !important;
      flex-wrap: nowrap !important;
      gap: 6px !important;
      margin-top: 6px !important;
      order: 4 !important;
      white-space: nowrap !important;
    }
    #align tr.expanded-row td:nth-of-type(5):before {
      content: "Action:";
      font-weight: 600 !important;
      color: #000 !important;
      margin-right: 6px !important;
      flex-shrink: 0 !important;
    }

    /* Action buttons – inline, no extra margins */
    #align tr.expanded-row td:nth-of-type(5) form {
      display: inline-flex !important;
      align-items: center !important;
      gap: 4px !important;
      margin: 0 !important;
    }

    #align tr.expanded-row td:nth-of-type(5) .btn {
      font-size: 11px !important;
      padding: 4px 8px !important;
      margin: 0 !important;
    }

    /* No records message */
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

    /* DataTable controls (if any) */
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
  <section class="section">
    <div class="section-body mt-2">
      {{ Breadcrumbs::render('uam_modules.index') }}

      @if(strpos($screen_permission['permissions'], 'Create') !== false)
        <a type="button" style="font-size:15px; margin: 0 0px 5px 15px;" class="btn btn-success btn-lg" href="{{ route('uam_modules.create') }}">Add Modules</a>
      @endif

      <div class="row">
        <div class="col-12">
          <div class="card">
            <div class="card-body">
              <div class="row">
                <div class="col-lg-12 text-center">
                  <h4 style="color:darkblue;">List of Modules</h4>
                </div>
              </div>

              @if (session('success'))
                <input type="hidden" name="session_data" id="session_data" class="session_data" value="{{ session('success') }}">
                <script type="text/javascript">
                  window.onload = function() {
                    var message = $('#session_data').val();
                    swal({
                      title: "Success",
                      text: message,
                      type: "success",
                    });
                  }
                </script>
              @elseif(session('error'))
                <input type="hidden" name="session_data" id="session_data1" class="session_data" value="{{ session('error') }}">
                <script type="text/javascript">
                  window.onload = function() {
                    var message = $('#session_data1').val();
                    swal({
                      title: "Info",
                      text: message,
                      type: "info",
                    });
                  }
                </script>
              @endif

              <div class="table-wrapper">
                <div class="table-responsive">
                  <table class="table table-bordered" id="align">
                    <thead>
                      <tr>
                        <th width="50px">Sl. No.</th>
                        <th>Parent Module Name</th>
                        <th>Module Name</th>
                        <th>Display Order</th>
                        <th>Action</th>
                      </tr>
                    </thead>
                    <tbody>
                      @foreach($rows as $key=>$row)
                        <tr>
                          <td data-label="Sl. No.">{{ ++$key }}</td>
                          <td data-label="Parent Module Name">
                            @if($row['parent_module_name'] == null)
                              NA
                            @else
                              {{ $row['parent_module_name'] }}
                            @endif
                          </td>
                          <td data-label="Module Name">{{ $row['module_name'] }}</td>
                          <td data-label="Display Order">{{ $row['display_order'] }}</td>
                          <td data-label="Action" class="text-center">
                            <form action="{{ route('uam_modules.destroy', \Crypt::encrypt($row['module_id'])) }}" method="POST">
                              @csrf
                              @method('DELETE')

                              @if(strpos($screen_permission['permissions'], 'Edit') !== false)
                                <a class="btn btn-warning btn-sm" href="{{ route('uam_modules.edit', \Crypt::encrypt($row['module_id'])) }}">Edit</a>
                              @endif

                              @if(strpos($screen_permission['permissions'], 'Delete') !== false)
                                <button class="btn btn-danger btn-sm" type="submit" onclick="return confirm('Are you sure you want to delete this data?');">Delete</button>
                              @endif
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
  </section>
</div>

<script>
  function myFunction(id) {
    swal({
      message: "Are You Sure to delete this data.",
      title: "Confirmation For Delete ?",
      centerVertical: true,
      buttons: {
        confirm: {
          label: 'Yes',
          className: 'btn-success'
        },
        cancel: {
          label: 'No',
          className: 'btn-danger'
        }
      },
      callback: function(result) {
        if (result == true) {
          var url = $('#' + id).val();
          window.location.href = url;
        }
      }
    });
  }

  // Toggle expand/collapse on mobile (same as OVM)
  $(document).ready(function() {
    $('#align tbody').on('click', 'tr', function(e) {
      // Ignore clicks inside action buttons/links
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