@extends('layouts.parent')
@section('content')
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
        overflow-x: hidden !important;
        overflow-y: auto !important;
        max-height: 80vh;
        width: 100% !important;
        padding-bottom: 10px !important;
        display: block !important;
        clear: both !important;
    }

    #tableList {
        font-size: 12px;
        min-width: 100% !important;
        width: 100% !important;
    }

    #tableList thead { display: none !important; }
    #tableList tbody { background: transparent !important; }

    #tableList tr {
        display: flex !important;
        flex-direction: column !important;
        align-items: stretch !important;
        border: 1px solid #e0e0e0 !important; 
        border-radius: 8px !important;
        margin-bottom: 8px !important;
        position: relative !important;
        padding: 10px 15px 10px 15px !important;
        background: #fff !important;
        box-shadow: 0 1px 4px rgba(0,0,0,0.05) !important;
        cursor: pointer;
        width: 100% !important;
    }

    #tableList td {
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

    /* 1. Enrollment Id */
    #tableList td:nth-of-type(1) {
        font-weight: bold !important;
        font-size: 1rem !important;
        color: #2c3e50 !important;
        margin-bottom: 2px !important;
        padding-right: 25px !important;
        order: 1 !important;
    }

    /* 2. Child Name */
    #tableList td:nth-of-type(2) {
        font-size: 0.85rem !important;
        color: #34495e !important;
        margin-bottom: 0 !important;
        order: 2 !important;
    }
    #tableList td:nth-of-type(2):before { content: "Child Name: "; font-weight: bold !important; color: #000 !important; }

    /* Hidden columns by default */
    #tableList td:nth-of-type(3) { order: 3 !important; display: none !important; }
    #tableList td:nth-of-type(4) { order: 4 !important; display: none !important; }

    /* Chevron icon */
    #tableList tr::after {
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
    
    #tableList tr.expanded-row::after {
        transform: translateY(-50%) rotate(90deg);
        top: 35px;
    }

    /* Expanded state styles */
    #tableList tr.expanded-row td:nth-of-type(3) {
        display: flex !important;
        align-items: center !important;
        margin-top: 8px !important;
        font-size: 0.95rem !important;
        color: #34495e !important;
    }
    #tableList tr.expanded-row td:nth-of-type(3):before { content: "Status: "; font-weight: bold !important; color: #000 !important; display: inline !important; margin-right: 4px !important;}
    
    #tableList tr.expanded-row td:nth-of-type(4) {
        display: flex !important;
        align-items: center !important;
        margin-top: 8px !important;
        font-size: 0.95rem !important;
        color: #34495e !important;
        flex-wrap: wrap !important;
    }
    #tableList tr.expanded-row td:nth-of-type(4):before { content: "Action: "; font-weight: bold !important; color: #000 !important; display: inline !important; margin-right: 4px !important;}
    
    #tableList tr.expanded-row td:nth-of-type(4) a.btn {
        padding: 4px 8px !important;
        background: #fff0f0 !important;
        border-radius: 4px !important;
        display: inline-block !important;
        margin: 2px !important;
    }

    .dt-buttons .btn {
        padding: 2px 5px !important;
        font-size: 9px !important;
    }
}
</style>
<style>
    #tableList th,
    #tableList td {
        text-align: center;
        vertical-align: middle;
    }
</style>

<div class="main-content">
  {{ Breadcrumbs::render('g2form.list') }}
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

<style>
    /* Improved Action Buttons in Mobile View */
    @media (max-width: 768px) {
        #align tr.expanded-row td a.btn, #align tr.expanded-row td a.btn-link, #align tr.expanded-row td a[title], .table-responsive tr.expanded-row td a.btn, .table-responsive tr.expanded-row td a.btn-link, .table-responsive tr.expanded-row td button, #align1 tr.expanded-row td a.btn-link, #align1 tr.expanded-row td a.btn {
            padding: 6px 14px !important;
            background: #f8f9fa !important;
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

        // Prevent action button click from collapsing row
        $(document).on('click', '.table-responsive td a.btn, .table-responsive td a.btn-link, .table-responsive td a[title], .table-responsive td button, #align tbody tr td:last-child a, #align1 tbody tr td:last-child a', function(e) {
            if($(window).width() <= 768) {
                e.stopPropagation();
            }
        });

        // Mobile back button logic
        if($(window).width() <= 768) {
            var breadcrumbItems = $('.breadcrumb li');
            if (breadcrumbItems.length === 1 || (breadcrumbItems.length === 2 && breadcrumbItems.last().text().trim() === '')) {
                // Single breadcrumb
                var title = breadcrumbItems.first().text().trim();
                $('.breadcrumb').replaceWith('<a href="javascript:history.back()" class="btn btn-secondary back-btn" style="margin: 10px 15px; font-size: 11px; padding: 4px 8px; border-radius: 4px;"><i class="fa fa-arrow-left" style="margin-right: 5px;"></i> Back</a>');
            } else if (breadcrumbItems.length > 1) {
                // Parent-Child breadcrumb
                $('<div style="padding: 10px 15px 0 15px;"><a href="/home" class="btn btn-secondary back-btn" style="font-size: 11px; padding: 4px 8px; border-radius: 4px;"><i class="fa fa-arrow-left" style="margin-right: 5px;"></i> Dashboard</a></div>').insertBefore('.breadcrumb');
            }
        }
        
        // Status Badge styling
        $('.table-responsive tbody tr, #align tbody tr, #align1 tbody tr').each(function() {
            $(this).find('td').each(function() {
                var text = $(this).text().trim();
                if (text.match(/^(Saved|Completed|Approved|Submitted|Pending|In Progress|Active|Inactive)$/i)) {
                    var color = '#e2e3e5'; // Default Saved
                    var textCol = '#383d41';
                    var tLower = text.toLowerCase();
                    if(tLower === 'submitted') { color = '#cce5ff'; textCol = '#004085'; }
                    else if(tLower === 'completed' || tLower === 'approved' || tLower === 'active') { color = '#d4edda'; textCol = '#155724'; }
                    else if(tLower === 'pending' || tLower === 'in progress') { color = '#fff3cd'; textCol = '#856404'; }
                    
                    $(this).html('<span style="background-color: ' + color + '; color: ' + textCol + '; padding: 3px 8px; border-radius: 12px; font-size: 11px; font-weight: 600; display: inline-block;">' + text + '</span>');
                }
            });
        });
    });
</script>


@endsection
