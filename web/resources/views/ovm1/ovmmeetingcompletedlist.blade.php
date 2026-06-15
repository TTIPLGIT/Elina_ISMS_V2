@extends('layouts.adminnav')

@section('content')
<style>
    @media (max-width: 768px) {
        /* Global Mobile scaling */
        .main-content {
            padding: 2px !important;
            margin-top: 55px !important;
            overflow-x: hidden !important;
        }

        /* Breadcrumbs - Cleaned & Left Aligned */
        .breadcrumb {
            padding: 2px 5px !important;
            margin: 5px 0 5px 15px !important;
            width: 85% !important;
            height: auto !important;
            min-height: 25px !important;
            font-size: 8px !important;
            background-color: transparent !important;
            display: flex !important;
            flex-wrap: nowrap !important;
            overflow: hidden !important;
            border: none !important;
            box-shadow: none !important;
            justify-content: flex-start !important;
            align-items: center !important;
            white-space: nowrap !important;
        }
        
        .breadcrumb li span, 
        .breadcrumb .number,
        .breadcrumb-item::before {
            width: 14px !important;
            height: 14px !important;
            line-height: 14px !important;
            font-size: 8px !important;
            margin-right: 4px !important;
        }

        .breadcrumb-item, .breadcrumb-item a {
            font-size: 8px !important;
            display: flex !important;
            align-items: center !important;
        }

        /* Heading */
        h4 {
            font-size: 14px !important;
            margin: 10px 0 !important;
            font-weight: bold !important;
            color: darkblue !important;
            text-align: center !important;
        }

        /* Create Button Optimization - Root Cause Fix */
        table#align tbody td .btn-labeled {
            padding: 0 !important;
            font-size: 10px !important;
            margin: 2px 2px 2px 0 !important; /* Merge margins to be consistent with other buttons */
            height: 24px !important;
            display: inline-flex !important;
            align-items: stretch !important; /* Stretch children to fill height */
            width: auto !important;
            min-width: 60px !important;
            overflow: hidden !important;
            border-radius: 4px !important;
            border: none !important;
            box-shadow: none !important; /* Remove any shadow */
            position: relative !important;
        }
        
        /* Hide the theme-specific gray box artifact */
        table#align tbody td .btn-labeled .btn-label::before,
        table#align tbody td .btn-labeled .btn-label::after {
            display: none !important;
            content: none !important;
        }

        table#align tbody td .btn-labeled .btn-label {
            height: auto !important; /* Let stretch handle it */
            padding: 0 8px !important; /* Force tighter padding */
            background: transparent !important; 
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
            margin: 0 !important;
            font-size: 10px !important;
            position: relative !important;
            left: 0 !important;
            top: 0 !important;
        }

        table#align tbody td .btn-labeled span:not(.btn-label) {
            font-size: 10px !important;
            padding: 0 10px !important;
            font-weight: bold !important;
            margin: 0 !important;
            display: flex !important;
            align-items: center !important;
        }

        /* DataTables Controls - Bold 9px */
        div.dataTables_wrapper div.dataTables_length {
            float: left !important;
            width: 48% !important;
            font-size: 9px !important;
            font-weight: bold !important;
            margin-bottom: 5px !important;
            text-align: left !important;
            display: flex !important;
            align-items: center !important;
        }
        
        div.dataTables_wrapper div.dataTables_filter {
            float: right !important;
            width: 50% !important;
            font-size: 9px !important;
            font-weight: bold !important;
            margin-bottom: 5px !important;
            text-align: right !important;
            display: flex !important;
            align-items: center !important;
            justify-content: flex-end !important;
        }

        /* Export Buttons (PDF, Excel, etc.) - Standardized to Screenshot 1 */
        div.dataTables_wrapper div.dt-buttons {
            float: none !important;
            display: flex !important;
            flex-wrap: nowrap !important;
            justify-content: center !important;
            margin-bottom: 10px !important;
            gap: 4px !important;
            width: 100% !important;
        }
        div.dataTables_wrapper div.dt-buttons .btn {
            padding: 4px 6px !important;
            font-size: 10px !important;
            min-width: 40px !important;
            width: auto !important;
            height: auto !important;
            border-radius: 4px !important;
            font-weight: bold !important;
            display: inline-block !important;
        }

        div.dataTables_wrapper div.dataTables_length select {
            height: 32px !important;
            width: 75px !important;
            font-size: 11px !important;
            margin: 0 5px !important;
            padding: 2px 5px !important;
        }
        
        div.dataTables_wrapper div.dataTables_filter input {
            height: 30px !important;
            width: 100px !important;
            font-size: 11px !important;
            margin-left: 5px !important;
            border-radius: 4px !important;
            border: 1px solid #ccc !important;
        }

        /* Table - Mobile Accordion UI */
        .table-responsive {
            overflow-x: hidden !important;
            overflow-y: auto !important;
            max-height: 80vh;
            width: 100% !important;
            padding-bottom: 10px !important;
            display: block !important;
            clear: both !important;
        }

        .table-responsive table {
            font-size: 12px;
            min-width: 100% !important;
            width: 100% !important;
        }

        .table-responsive thead { display: none !important; }
        .table-responsive tbody { background: transparent !important; }

        #align tr {
            display: flex !important;
            flex-direction: column !important;
            align-items: stretch !important;
            border: 1px solid #e0e0e0 !important; 
            border-radius: 8px !important;
            margin-bottom: 8px !important;
            position: relative !important;
            padding: 10px 15px 10px 45px !important;
            background: #fff !important;
            box-shadow: 0 1px 4px rgba(0,0,0,0.05) !important;
            cursor: pointer;
            width: 100% !important;
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

        /* 1. S.No -> Plain text on the left */
        #align td:nth-of-type(1) {
            position: absolute !important;
            left: 15px !important;
            top: 50% !important;
            transform: translateY(-50%) !important;
            width: 25px !important;
            background: transparent !important;
            display: flex !important;
            align-items: center !important;
            justify-content: flex-start !important;
            font-weight: bold !important;
            font-size: 1rem !important;
            color: #2c3e50 !important;
            transition: top 0.3s, transform 0.3s;
            margin: 0 !important;
        }

        #align tr.expanded-row td:nth-of-type(1) {
            top: 20px !important;
            transform: translateY(0) !important;
        }

        /* 2. OVM ID - hidden on mobile */
        #align td:nth-of-type(2) { display: none !important; }

        /* 3. Child Name */
        #align td:nth-of-type(3) {
            font-weight: bold !important;
            font-size: 1rem !important;
            color: #2c3e50 !important;
            margin-bottom: 2px !important;
            margin-top: 0 !important;
            padding-right: 25px !important;
            order: 1 !important;
            line-height: 1.2 !important;
        }

        /* 4. Enrollment Id */
        #align td:nth-of-type(4) {
            font-size: 0.85rem !important;
            color: #34495e !important;
            margin-bottom: 0 !important;
            margin-top: 0 !important;
            order: 2 !important;
            line-height: 1.2 !important;
        }
        #align td:nth-of-type(4):before { content: "Child ID: "; font-weight: bold !important; color: #000 !important; }

        /* Hidden columns by default */
        #align td:nth-of-type(5) { order: 3 !important; display: none !important; }
        #align td:nth-of-type(6) { order: 4 !important; display: none !important; }

        /* Chevron icon */
        #align tr::after {
            content: '\f054';
            font-family: 'FontAwesome';
            position: absolute;
            right: 20px;
            top: 50%;
            transform: translateY(-50%);
            color: #bdc3c7;
            transition: transform 0.3s;
            font-size: 1rem;
        }
        
        #align tr.expanded-row::after {
            transform: translateY(-50%) rotate(90deg);
            top: 35px;
        }

        /* Expanded state styles */
        #align tr.expanded-row td:nth-of-type(5) {
            display: flex !important;
            align-items: center !important;
            margin-top: 8px !important;
            padding-top: 0 !important;
            border-top: none !important;
            font-size: 0.95rem !important;
            color: #34495e !important;
        }
        
        #align tr.expanded-row td:nth-of-type(5):before { content: "Status: "; font-weight: bold !important; color: #000 !important; display: inline !important; margin-right: 4px !important;}
        
        /* Action button alignment */
        #align tr.expanded-row td:nth-of-type(6) {
            display: flex !important;
            align-items: center !important;
            margin-top: 8px !important;
            padding-top: 0 !important;
            border-top: none !important;
            font-size: 0.95rem !important;
            color: #34495e !important;
            flex-wrap: wrap !important;
        }
        #align tr.expanded-row td:nth-of-type(6):before { content: "Action: "; font-weight: bold !important; color: #000 !important; display: inline !important; margin-right: 4px !important;}
        
        #align tr.expanded-row td:nth-of-type(6) a.btn, 
        #align tr.expanded-row td:nth-of-type(6) button.btn {
            padding: 4px 8px !important;
            background: #FFA426 !important;
            border-radius: 4px !important;
            display: inline-block !important;
            margin: 2px !important;
        }

        /* Pagination sizing */
        div.dataTables_wrapper div.dataTables_paginate ul.pagination li.paginate_button a {
            padding: 3px 6px !important;
            font-size: 8px !important;
        }
        div.dataTables_wrapper div.dataTables_info {
            font-size: 10px !important;
            margin-bottom: 5px !important;
        }

        /* Action Icons */
        .btn-link i {
            font-size: 14px !important;
        }
    }
    @media (min-width: 769px) {
        #align th, #align td {
            vertical-align: middle !important;
            font-size: 13px !important;
        }
        .is-co-col {
            width: 15% !important;
        }
        .status-col {
            width: 10% !important;
            white-space: nowrap !important;
        }
        .meeting-time-col {
            width: 15% !important;
            white-space: nowrap !important;
        }
    }
</style>
<div class="main-content">
  <section class="section">
  {{ Breadcrumbs::render('ovmmeetingcompleted') }}

    <div class="section-body mt-2">

    @if (session('success'))
                    <input type="hidden" name="session_data" id="session_data" class="session_data" value="{{ session('success') }}">
                    <script type="text/javascript">
                        window.onload = function() {
                            var message = $('#session_data').val();
                            swal.fire("Success", message,"success");
                        }
                    </script>
                    @elseif(session('fail'))
                    <input type="hidden" name="session_data" id="session_data1" class="session_data" value="{{ session('fail') }}">
                    <script type="text/javascript">
                        window.onload = function() {
                            var message = $('#session_data1').val();
                            swal.fire( "Info",message,"info");
                        }
                    </script>
                    @endif
      <div class="row">

        <div class="col-12">

          <div class="card">

            <div class="card-body">
              <div class="row">
                <div class="col-lg-12 text-center">
                  <h4 style="color:darkblue;">Conversation Summary List</h4>
                </div>

              </div>






              <div class="table-wrapper">
                <div class="table-responsive">
                  <table class="table table-bordered" id="align">
                    <thead>
                      <tr>
                        <th width="50px">Sl. No.</th>
                        <th>OVM ID</th>
                        <th>Child Name</th>
                        <th>Enrollment Id</th>

                        <th>Status</th>
                        <th>Action</th>
                      </tr>
                    </thead>
                    <tbody>
                     
                      @foreach($rows as $key=>$row)
                      <tr>

                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $row['ovm_meeting_unique']}}</td>
                        <td>{{ $row['child_name']}}</td>
                        <td>{{ $row['enrollment_id']}}</td>
                     

                        <td>{{ $row['status']}}</td>




                        <td class="text-center">

                          <form action method="POST" action="">


                          @php  $id =  Crypt::encrypt($row['ovm_meeting_id']); @endphp
                          @php $role = 'iscoordinator' @endphp
                            <a class="btn btn-labeled btn-warning" style="background: warning !important; border-color:warning !important; color:warning !important" title="Report" href="{{ route('ovmcompleted', ['id' => $id , 'role' => $role]) }}"><span class="btn-label" style="font-size:13px !important;"><i class="fa fa-file-o"></i></span>Report </a>


                            @csrf



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
          swal.fire("Shortlisted!", "Candidates are successfully shortlisted!", "success");
          var url = $('#' + id).val();
          alert(url);
          window.location.href = url;

        } else {
          swal.fire("Cancelled", "Your imaginary file is safe :)", "error");
          e.preventDefault();
        }
      });


  }
</script>

<style>
    /* Improved Action Buttons in Mobile View */
    @media (max-width: 768px) {
        #align tr.expanded-row td a.btn, #align tr.expanded-row td a.btn-link, #align tr.expanded-row td a[title], .table-responsive tr.expanded-row td a.btn, .table-responsive tr.expanded-row td a.btn-link, .table-responsive tr.expanded-row td button, #align1 tr.expanded-row td a.btn-link, #align1 tr.expanded-row td a.btn {
            padding: 6px 14px !important;
            background: #d10a50 !important;
            border: 1px solid #ddd !important;
            border-radius: 6px !important;
            display: inline-block !important;
            margin-right: 6px !important;
            box-shadow: 0 1px 2px rgba(0,0,0,0.05) !important;
            font-size: 14px !important;
        }
    }
</style>
<script>
    $(document).ready(function() {
        // Mobile row expansion logic
        $(document).on('click', '.table-responsive tr, #align tbody tr, #align1 tbody tr', function() {
            if($(window).width() <= 768) {
                if ($(this).hasClass('expanded-row')) {
                    $(this).removeClass('expanded-row');
                } else {
                    $(this).siblings('tr').removeClass('expanded-row');
                    $(this).addClass('expanded-row');
                }
            }
        });

     

    
        
     
    });
</script>


@endsection
