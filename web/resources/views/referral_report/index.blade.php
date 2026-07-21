@extends('layouts.adminnav')

@section('content')
<style>



</style>
<div class="main-content">
  {{ Breadcrumbs::render('referralreport.index') }}
  <section class="section">

    @if (session('success'))

    <input type="hidden" name="session_data" id="session_data" class="session_data" value="{{ session('success') }}">
    <script type="text/javascript">
      window.onload = function() {
        var message = $('#session_data').val();
        swal.fire("Success", message, "success");

      }
    </script>
    @elseif(session('fail'))

    <input type="hidden" name="session_data" id="session_data1" class="session_data" value="{{ session('error') }}">
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
          <a type="button" href="{{ route('referralreport.create') }}" value="Cancel" class="btn btn-labeled btn-info" title="create" style="background: #044a95 !important; border-color:#a9ca !important; color:white !important;margin-top: 0.5rem;">
            <span class="btn-label" style="font-size:15px !important; padding:8px !important"><i class="fa fa-plus"></i></span><span style="font-size:15px !important; padding:8px !important">New Referral Report</span></a>
          <div class="card">

            <div class="card-body">
              <div class="row">
                <div class="col-lg-12 text-center">
                  <h4 style="color:darkblue;">Referral Report List view</h4>
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
                      @foreach($rows as $data)
                      <tr>

                        <td>{{$loop->iteration}}</td>
                        <td>{{$data['enrollment_child_num']}}</td>
                        <td>{{$data['child_name']}}</td>
                        <td>Referral Report</td>
                        <td>{{$data['status']}}</td>
                        <td class="text-center">

                          @if($data['status'] != 'Published')
                          <a class="btn btn-link" title="Edit" href="{{ route('referralreport.edit', \Crypt::encrypt($data['id'])) }}"><i class="fas fa-pencil-alt" style="color: blue !important"></i></a>
                          @endif
                          @if($data['status'] == 'Published')
                          <a class="btn btn-link" title="Show" href="{{ route('referralreport.show', \Crypt::encrypt($data['id'])) }}"><i class="fas fa-eye" style="color: green !important"></i></a>
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
          swal.fire("Deleted!", "Data Deleted successfully!", "success");
          var url = $('#' + id).val();

          window.location.href = url;

        } else {
          swal.fire("Cancelled", "Your file is safe :)", "error");
          e.preventDefault();
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