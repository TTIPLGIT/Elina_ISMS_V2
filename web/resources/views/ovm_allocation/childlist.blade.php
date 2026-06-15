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
            margin-right: 3px !important;
        }

        .breadcrumb-item, .breadcrumb-item a {
            font-size: 8px !important;
            display: flex !important;
            align-items: center !important;
        }

        /* Heading - exactly like enrollment list view */
        .col-lg-12.text-center h4 {
            font-size: 18px !important;
            margin: 10px 0 !important;
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

        div.dataTables_wrapper div.dataTables_filter label {
            display: flex !important;
            align-items: center !important;
        }
        
        div.dataTables_wrapper div.dataTables_length select {
            height: 32px !important;
            width: 70px !important;
            font-size: 11px !important;
            padding: 0 5px !important;
            margin: 0 5px !important;
            appearance: auto !important;
        }
        
        div.dataTables_wrapper div.dataTables_filter input {
            height: 30px !important;
            width: 80px !important;
            font-size: 11px !important;
            margin-left: 5px !important;
        }

        div.dataTables_wrapper div.dt-buttons {
            float: left !important;
            clear: both !important;
            display: flex !important;
            margin-bottom: 8px !important;
            gap: 2px !important;
        }
        div.dataTables_wrapper div.dt-buttons .btn {
            padding: 1px 4px !important;
            font-size: 7px !important;
            min-width: 30px !important;
            height: 18px !important;
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
        }

        div.dataTables_wrapper div.dataTables_paginate ul.pagination li.paginate_button a {
            padding: 3px 6px !important;
            font-size: 8px !important;
        }
        div.dataTables_wrapper div.dataTables_info {
            font-size: 10px !important;
            margin-bottom: 5px !important;
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
        
        .table-responsive table {
            font-size: 12px;
            min-width: 100% !important;
            width: 100% !important;
        }

        .table-responsive thead { display: none !important; }
        .table-responsive tbody { background: transparent !important; }
        
        #align1 tr {
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

        #align1 td {
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

        #align1 td:nth-of-type(1) {
            position: absolute !important;
            left: 15px !important;
            top: 50% !important;
            transform: translateY(-50%) !important;
            font-size: 14px !important;
            font-weight: bold !important;
            color: #666 !important;
            width: auto !important;
        }

        #align1 td:nth-of-type(2) {
            font-size: 13px !important;
            font-weight: bold !important;
            color: #1a73e8 !important;
            margin-bottom: 6px !important;
        }

        #align1 td:nth-of-type(3),
        #align1 td:nth-of-type(4),
        #align1 td:nth-of-type(5),
        #align1 td:nth-of-type(6) {
            display: none !important;
            font-size: 12px !important;
            color: #444 !important;
            margin-bottom: 5px !important;
        }

        #align1 td:nth-of-type(3):before { content: "IS-Coordinator: "; font-weight: bold; color: #888; }
        #align1 td:nth-of-type(4):before { content: "Allocation Date: "; font-weight: bold; color: #888; }
        #align1 td:nth-of-type(5):before { content: "Status: "; font-weight: bold; color: #888; }

        #align1 tr.expanded-row td:nth-of-type(3),
        #align1 tr.expanded-row td:nth-of-type(4),
        #align1 tr.expanded-row td:nth-of-type(5),
        #align1 tr.expanded-row td:nth-of-type(6) {
            display: block !important;
        }

        #align1 tr::after {
            content: '\f054'; 
            font-family: 'FontAwesome';
            position: absolute;
            right: 15px;
            top: 50%;
            transform: translateY(-50%);
            font-size: 12px;
            color: #999;
            transition: transform 0.2s ease;
        }

        #align1 tr.expanded-row::after {
            transform: translateY(-50%) rotate(90deg);
        }

        #align1 tr.expanded-row td a.btn, 
        #align1 tr.expanded-row td a.btn-link, 
        #align1 tr.expanded-row td a[title] {
            padding: 6px 14px !important;
            background: #f8f9fa !important;
            border: 1px solid #ddd !important;
            border-radius: 6px !important;
            display: inline-block !important;
            margin-right: 6px !important;
            box-shadow: 0 1px 2px rgba(0,0,0,0.05) !important;
            font-size: 14px !important;
        }

        div.dataTables_wrapper div.dataTables_info, 
        div.dataTables_wrapper div.dataTables_paginate {
            font-size: 10px !important;
            margin-top: 10px !important;
            clear: both !important;
        }
        .responsive-note {
            font-size: 11px !important;
            margin-top: 10px !important;
            font-weight: bold !important;
            display: block !important;
            clear: both !important;
        }
    }
</style>

<div class="main-content">
    @if (session('success'))
        <input type="hidden" name="session_data" id="session_data" class="session_data" value="{{ session('success') }}">
        <script type="text/javascript">
            window.onload = function () {
                var message = $('#session_data').val();
                Swal.fire('Success!', message, 'success');
            }
        </script>
    @elseif(session('fail'))
        <input type="hidden" name="session_data" id="session_data1" class="session_data" value="{{ session('fail') }}">
        <script type="text/javascript">
            window.onload = function () {
                var message = $('#session_data1').val();
                Swal.fire('Info!', message, 'info');
            }
        </script>
    @endif
    
    {{ Breadcrumbs::render('coordinator.list') }}

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="col-lg-12 text-center mb-3">
                        <h4 style="color:darkblue;">My OVM Allocation List View</h4>
                    </div>

                    <div class="table-wrapper">
                        <div class="table-responsive">
                            <table class="table table-bordered" id="align1">
                                <thead>
                                    <tr>
                                        <th>Sl.No</th>
                                        <th>Enrollment ID(Child Name) </th>
                                        <th>IS-Coordinator</th>
                                        <th>Allocation Date</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($rows['rows'] as $data)
                                        @php
                                            $enrollmentId = $data['enrollment_id'];
                                            $count = DB::table('ovm_allocation')
                                                ->where('enrollment_id', $enrollmentId)
                                                ->count();
                                        @endphp
                                        <tr>
                                            <td>{{$loop->iteration}}</td>
                                            <td>{{$data['enrollment_child_num']}}({{$data['child_name']}})</td>
                                            <td>
                                                @if ($user_id == $data['is_coordinator1'])
                                                    {{$data['is_coordinator2_name']}}(S)
                                                @elseif ($user_id == $data['is_coordinator2'])
                                                    {{$data['is_coordinator1_name']}}(P)
                                                @else
                                                    {{$data['is_coordinator1_name']}}(P)
                                                    @if(!empty($data['is_coordinator2_name']))
                                                        <br>{{$data['is_coordinator2_name']}}(S)
                                                    @endif
                                                @endif
                                            </td>
                                            <td>{{date('d-m-Y', strtotime($data['created_date']))}}</td>
                                            <td>{{$data['meeting_status']}}</td>
                                            <td>
                                                @if(($data['status'] != 3 && $count > 1) || ($data['status'] != 3 && $count = 1))
                                                    <a class="btn btn-link" title=""
                                                        href="{{ route('coordinator_allocation.ovm_create', Crypt::encrypt($data['id'])) }}"
                                                        style="background-color:blue;color:white;text-decoration: none;">OVM
                                                        Meeting</a>
                                                @elseif($data['status'] == 3 || $count = 1)
                                                    -
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <p class="responsive-note"><b>P-Primary,S-Secondary</b></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function showSuccessAlert() {
        Swal.fire({
            title: "Success",
            text: "Reallocation Done Successfully",
            icon: "success",
        });
    }

    function validateAndAllocate(id) {
        $.ajax({
            url: "{{ url('/coordinator/ovm_fetch') }}",
            type: 'GET',
            data: {
                'id': id,
                _token: '{{csrf_token()}}'
            },
            success: function (data) {
                console.log(data);
                if (data != 0) {
                    location.replace(`/coordinator/ovm_create`);
                }
            }
        });
    }

    window.onload = function () {
        let url = new URL(window.location.href);
        let message4 = url.searchParams.get("message4");
        if (message4 != null) {
            window.history.pushState({}, document.title, "/allocation/list");
            showSuccessAlert();
        }
    };
</script>

<script>
    $(document).ready(function() {
        // Mobile row expansion logic
        $(document).on('click', '#align1 tbody tr', function() {
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
        $(document).on('click', '#align1 tbody tr td:last-child a', function(e) {
            if($(window).width() <= 768) {
                e.stopPropagation();
            }
        });

        // Status Badge styling
        $('#align1 tbody tr').each(function() {
            $(this).find('td').each(function() {
                var text = $(this).text().trim();
                if (text.match(/^(Saved|Completed|Approved|Submitted|Pending|In Progress|Active|Inactive|Sent|Rescheduled|Accepted|Declined)$/i)) {
                    var color = '#e2e3e5';
                    var textCol = '#383d41';
                    var tLower = text.toLowerCase();
                    if(tLower === 'submitted' || tLower === 'sent') { color = '#cce5ff'; textCol = '#004085'; }
                    else if(tLower === 'completed' || tLower === 'approved' || tLower === 'active' || tLower === 'accepted') { color = '#d4edda'; textCol = '#155724'; }
                    else if(tLower === 'pending' || tLower === 'in progress' || tLower === 'rescheduled') { color = '#fff3cd'; textCol = '#856404'; }
                    else if(tLower === 'declined') { color = '#f8d7da'; textCol = '#721c24'; }

                    $(this).html('<span style="background-color: ' + color + '; color: ' + textCol + '; padding: 3px 8px; border-radius: 12px; font-size: 11px; font-weight: 600; display: inline-block;">' + text + '</span>');
                }
            });
        });
    });
</script>

@endsection