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
     MOBILE RESPONSIVE – CARD STYLE
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

    /* Role Name – primary field (2nd column) */
    #align td:nth-of-type(2) {
      display: block !important;
      font-weight: 600 !important;
      font-size: 16px !important;
      color: #2c3e50 !important;
      margin-bottom: 4px !important;
      padding-right: 25px !important;
      order: 1 !important;
    }

    /* Action – hidden initially (3rd column) */
    #align td:nth-of-type(3) {
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

    /* Expanded action */
    #align tr.expanded-row td:nth-of-type(3) {
      display: flex !important;
      align-items: center !important;
      flex-wrap: wrap !important;
      gap: 4px !important;
      margin-top: 6px !important;
      order: 2 !important;
    }
    #align tr.expanded-row td:nth-of-type(3):before {
      content: "Action:";
      font-weight: 600 !important;
      color: #000 !important;
      margin-right: 6px !important;
      flex-shrink: 0 !important;
    }

    /* Action buttons – inline, small, touch-friendly */
    #align tr.expanded-row td:nth-of-type(3) form {
      display: inline-flex !important;
      align-items: center !important;
      gap: 4px !important;
      margin: 0 !important;
      flex-wrap: wrap !important;
    }

    #align tr.expanded-row td:nth-of-type(3) .btn {
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
    {{ Breadcrumbs::render('uam_roles.index') }}

    <div class="section-body mt-2">
      @if(strpos($screen_permission['permissions'], 'Create') !== false)
        <a type="button" style="font-size:15px; margin: 0 0px 5px 15px;" class="btn btn-success btn-lg" href="{{ route('uam_roles.create') }}">Create</a>
      @endif
      <style>
        .section {
          margin-top: 20px;
        }
      </style>
      <div class="row">
        <div class="col-12">
          <div class="card">
            <div class="card-body">
              <div class="row">
                <div class="col-lg-12 text-center">
                  <h4 style="color:darkblue;">UAM Role List</h4>
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
                        <th>Role Name</th>
                        <th>Action</th>
                      </tr>
                    </thead>
                    <tbody>
                      @foreach($rows as $key=>$row)
                        <tr>
                          <td data-label="Sl. No.">{{ ++$key }}</td>
                          <td data-label="Role Name">{{ $row['role_name'] }}</td>
                          <td data-label="Action" class="text-center">
                            <form id="DeleteForm{{ $key }}" action="{{ route('uam_roles.destroy', \Crypt::encrypt($row['role_id'])) }}" method="POST">
                              @if(strpos($screen_permission['permissions'], 'Show') !== false)
                                <a class="btn btn-info btn-sm" href="{{ route('uam_roles.show', \Crypt::encrypt($row['role_id'])) }}">Show</a>
                              @endif
                              @if(strpos($screen_permission['permissions'], 'Edit') !== false)
                                <a class="btn btn-warning btn-sm" href="{{ route('uam_roles.edit', \Crypt::encrypt($row['role_id'])) }}">Edit</a>
                              @endif
                              @csrf
                              @method('DELETE')
                              @if(strpos($screen_permission['permissions'], 'Delete') !== false)
                                <button class="btn btn-danger btn-sm" type="button" onclick="deleteForm({{ $key }})">Delete</button>
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
  function deleteForm(index) {
    swal({
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
          document.getElementById('DeleteForm' + index).submit();
        } else {
          return false;
        }
      });
  }

  // Toggle expand/collapse on mobile (same as other indices)
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