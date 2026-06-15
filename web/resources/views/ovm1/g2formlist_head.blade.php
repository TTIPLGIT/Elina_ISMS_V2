@extends('layouts.adminnav')
@section('content')
<div class="main-content">
  {{ Breadcrumbs::render('g2form.list') }}
  <style>
    /* Space between DataTable buttons */
  .dt-buttons .btn {
      margin-right: 8px;   /* space between buttons */
      margin-bottom: 5px;  /* small vertical space (mobile safe) */
  }
  
  /* Space between "Show entries" and buttons */
  .dataTables_length {
      margin-bottom: 12px;
  }
  
  /* Align buttons nicely */
  .dt-buttons {
      margin-left: 10px;
  }
  
  /* Mobile Responsive Table styling - Compact Table (Scrollable) */
  @media (max-width: 767px) {
      .main-content {
          padding: 5px !important;
      }

      .breadcrumb {
          margin-top: 60px !important;
          font-size: 10px !important;
          padding: 0 !important;
          background: transparent !important;
          border: none !important;
          box-shadow: none !important;
          width: max-content !important;
      }

      .card-body {
          padding: 8px !important;
      }

      .table-responsive {
          display: block !important;
          width: 100% !important;
          overflow-x: auto !important;
          -webkit-overflow-scrolling: touch !important;
          border: 1px solid #ddd !important;
      }

      #tableList {
          font-size: 10px !important;
          width: auto !important;
          min-width: 100% !important;
          margin-bottom: 0 !important;
      }

      #tableList thead th {
          background-color: #003366 !important;
          color: #fff !important;
          padding: 8px 6px !important;
          font-size: 10px !important;
          white-space: nowrap !important;
          text-align: center !important;
      }

      #tableList tbody td {
          padding: 8px 6px !important;
          font-size: 10px !important;
          white-space: nowrap !important;
          text-align: center !important;
          vertical-align: middle !important;
      }

      .dt-buttons .btn {
          padding: 2px 5px !important;
          font-size: 9px !important;
      }

         #tableList td:nth-child(2),
    #tableList th:nth-child(2) {
        max-width: 100px !important; 
        width: 100px !important;
        overflow: hidden !important;
        text-overflow: ellipsis !important;
        white-space: nowrap !important;
    }
  }
  </style>
  <section class="section">
    <div class="section-body mt-2">
      @if (session('success'))
      <input type="hidden" name="session_data" id="session_data" class="session_data" value="{{ session('success') }}">
      <script type="text/javascript">
        window.onload = function() {
          var message = $('#session_data').val();
          swal.fire("Success", message, "success");
        }
      </script>
      @elseif(session('fail'))
      <input type="hidden" name="session_data" id="session_data1" class="session_data" value="{{ session('fail') }}">
      <script type="text/javascript">
        window.onload = function() {
          var message = $('#session_data1').val();
          swal.fire("Info", message, "info");
        }
      </script>
      @endif
      <div class="row">

        <div class="col-12">
          <div class="card">

            <div class="card-body">

              <div class="row">
                <div class="col-lg-12 text-center">
                  <h4 class="screen-title"> Parent Reflection Form</h4>
                </div>
              </div>

              <div class="table-wrapper">
                <div class="table-responsive">
                  <table class="table table-bordered" id="tableList">
                    <thead>
                      <tr>
                        <!-- <th>Sl.No.</th> -->
                        <th>Enrollment Id</th>
                        <th>Child Name</th>
                        <th>Status</th>
                        <th>Action</th>
                      </tr>
                    </thead>
                    <tbody>
                      @foreach($rows as $key=>$row)
                      <tr>
                        <!-- <td data-label="Sl.No.">{{ $loop->iteration}}</td> -->
                        <td data-label="Enrollment Id">{{$row['enrollment_child_num']}}</td>
                        <td data-label="Child Name">{{$row['child_name']}} </td>
                        @if(in_array($user_id , explode(',', $row['viewed_users']) ))
                        <td data-label="Status">Viewed</td>
                        @else
                        <td data-label="Status">{{$row['status']}}</td>
                        @endif
                       
                        <td data-label="Action" class="text-center">

                          @if($row['status'] == 'Submitted')
                          <a class="btn btn-link" title="Show" id="{{$row['user_id']}}" href="{{ route('g2form.new', \Crypt::encrypt($row['user_id'])) }}"><i class="fas fa-eye" style="color: blue !important"></i></a>
                          @endif
                          @if($row['status'] != 'Submitted')
                          @if($modules['user_role'] == 'Parent')
                          <a class="btn btn-link" title="Edit" id="{{$row['user_id']}}" href="{{ route('g2form.new', \Crypt::encrypt($row['user_id'])) }}"><i class="fas fa-pen" style="color: blue !important"></i></a>
                          @else
                          <a class="btn btn-link" title="Show" onclick="return myFunction(<?php echo $row['user_id']; ?>);" class="btn btn-link"><i class="far fa-eye"></i></a>
                          @endif
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
    swal.fire("The parent has not yet submitted the form.", "", "info");
  }
</script>
@endsection