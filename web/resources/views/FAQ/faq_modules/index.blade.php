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

  /* =========================================================================
     MOBILE RESPONSIVE STYLING - CARD VIEW (like Assessment Report)
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
    /* Sl. No. (Col 1) */
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
    /* Module Name (Col 2) */
    #align td:nth-of-type(2) {
        display: block !important;
        font-weight: 600 !important;
        font-size: 16px !important;
        color: #2c3e50 !important;
        margin-bottom: 4px !important;
        padding-right: 25px !important;
        order: 1 !important;
    }
    /* Action (Col 3) - hidden initially */
    #align td:nth-of-type(3) {
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
    /* Action (Col 3) - shown when expanded */
    #align tr.expanded-row td:nth-of-type(3) {
        display: flex !important;
        align-items: center !important;
        flex-wrap: wrap !important;
        gap: 6px !important;
        margin-top: 10px !important;
        order: 2 !important;
        white-space: normal !important;
    }
    #align tr.expanded-row td:nth-of-type(3)::before {
        content: "Action:";
        font-weight: 600 !important;
        color: #000 !important;
        margin-right: 6px !important;
        flex-shrink: 0 !important;
        width: 100% !important;
        margin-bottom: 5px !important;
    }
    /* Action buttons - adjust for mobile */
    #align tr.expanded-row td:nth-of-type(3) a,
    #align tr.expanded-row td:nth-of-type(3) button {
        display: inline-block !important;
        margin-bottom: 5px !important;
        padding: 5px 10px !important;
        font-size: 12px !important;
    }

    /* DataTable controls (if any) */
    .dataTables_wrapper .row:first-child { margin: 0 !important; }
    .dataTables_wrapper .dataTables_length { float: left !important; margin-left: 8px !important; }
    .dataTables_wrapper .dataTables_filter { float: right !important; padding-right: 8px !important; }
    .dataTables_wrapper .dataTables_length, .dataTables_wrapper .dataTables_filter, .dataTables_wrapper .dataTables_info, .dataTables_wrapper .dataTables_paginate { font-size: 10px !important; }
    .dataTables_wrapper .dataTables_length select { font-size: 11px !important; height: 32px !important; width: 60px !important; }
    .dataTables_wrapper .dataTables_filter input { width: 90px !important; height: 24px !important; font-size: 10px !important; }
  }
</style>

<div class="main-content">
  <section class="section">
    {{ Breadcrumbs::render('faqmodules.index')}}

    <div class="section-body mt-2">

      @if(strpos($screen_permission['permissions'], 'Create') !== false)
      <a type="button" style="font-size:15px; margin: 0 0px 5px 15px;" class="btn btn-success btn-lg" href="{{ route('faqmodules.create') }}">Create</a>
      @endif
      <div class="row">
        <div class="col-12">
          <div class="card">
            <div class="card-body">
              <div class="row">
                <div class="col-lg-12 text-center">
                  <h4 style="color:darkblue;">FAQ Modules List</h4>
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
                        <th>Module Name</th>
                        <th>Action</th>
                      </tr>
                    </thead>
                    <tbody>
                      @foreach($rows as $key=>$row)
                      <tr>
                        <td>{{ ++$key }}</td>
                        <td>{{ $row['module_name'] }}</td>
                        <td class="text-center">
                          @if(strpos($screen_permission['permissions'], 'Show') !== false)
                          <a class="btn btn-info" href="{{ route('faqmodules.show', \Crypt::encrypt($row['id'])) }}">{{ __('Show') }}</a>
                          @endif
                          @if(strpos($screen_permission['permissions'], 'Edit') !== false)
                          <a class="btn btn-warning" href="{{ route('faqmodules.edit', \Crypt::encrypt($row['id'])) }}">{{ __('Edit') }}</a>
                          @endif
                          @if(strpos($screen_permission['permissions'], 'Delete') !== false)
                          <input type="hidden" name="delete_id" id="{{ $row['id'] }}" value="{{ route('faqmodules.delete', \Crypt::encrypt($row['id'])) }}">
                          <a class="btn btn-danger" href="{{ route('faqmodules.delete', \Crypt::encrypt($row['id'])) }}" style="cursor: pointer; color:aliceblue !important;" onclick="return myFunction({{ $row['id'] }});">{{ __('Delete') }}</a>
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

<script>
  function myFunction(id) {
    swal({
        html: true,
        title: "Do you want to delete This Module ?",
        type: "warning",
        customClass: 'swalalerttext',
        showCancelButton: true,
        confirmButtonColor: '#00a2ed',
        confirmButtonText: "Yes",
        cancelButtonText: "No",
        reverseButtons: true,
        closeOnConfirm: false,
        closeOnCancel: false,
        showLoaderOnConfirm: true,
        width: '20px'
      },
      function(isConfirm) {
        if (isConfirm) {
          var url = $('#' + id).val();
          window.location.href = url;
        } else {
          swal.close();
        }
      });
  }

  // Mobile row toggle (expand/collapse) – only on small screens
  $(document).ready(function() {
    $('#align tbody').on('click', 'tr', function(e) {
      // Do not toggle if click is on a link, button, or form element
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