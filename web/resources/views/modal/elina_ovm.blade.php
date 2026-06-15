<div class="modal fade" id="elina_ovm">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header" style=" background-color: rgb(0 103 172) !important; align-items: center !important;">
                <h4 class="modal-title" style="color: white !important; font-weight: bold !important; font-size: 1.25rem !important;">Overall OVM Meetings</h4>
                <button type="button" class="close" data-dismiss="modal" style="color: white !important; font-size: 2.2rem !important; opacity: 1 !important; font-weight: 300 !important; line-height: 1 !important; outline: none !important; padding: 0 !important; margin: 0 !important; margin-top: -20px !important;">&times;</button>
            </div>
            <div class="modal-body" style="padding:0">
                <div class="col-12" style="padding:0">
                    <div class="card-body" id="card_header">
                        <!-- Add search input field above table -->
                        <div class="row mb-3">
                            <div class="col-md-4 offset-md-8">
                                <div class="d-flex align-items-center justify-content-end mt-2">
                                    <label class="mb-0 mr-2"
                                        style="font-size: 14px; color: #333333; font-weight: bold; white-space: nowrap;">Search:</label>
                                    <input type="text" id="tableSearch" class="form-control" placeholder="&#xF002; Search"
                                        style="width: 180px; height: 38px; font-family:Arial, FontAwesome; font-size: 14px; border: 1px solid #ced4da; border-radius: 4px; padding: 6px 12px;">
                                </div>
                            </div>
                        </div>
                        <div class="table-wrapper" style="padding: 10px;">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="getOVMdetailsTable">
                                    <thead>
                                        <tr>
                                            <th width="1px">S.No.</th>
                                            <th>Child Name</th>
                                            <th>Enrollement Number</th>
                                            <th>IS Coordinator</th>
                                            <th>Meeting Date & Time</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody id="getOVMdetails">
                                        {{-- @foreach($rows['ovm_meeting_details'] as $key=>$row)
                                        <tr>
                                            <td>{{ ++$key }}</td>
                                            <td>{{ $row['child_name']}}</td>
                                            <td>{{ $row['enrollment_child_num']}}</td>
                                            <td>{{ json_decode($row['is_coordinator1'])->name }}{{
                                                isset($row['is_coordinator2']) && $row['is_coordinator2'] != '{}' ? ' ,
                                                ' . json_decode($row['is_coordinator2'])->name : '' }}</td>
                                            <td>{{ $row['meeting_startdate']}} & {{ date('h:i A',
                                                strtotime($row['meeting_starttime'])) }}</td>
                                            <td>{{ $row['audit_action']}}</td>
                                        </tr>
                                        @endforeach --}}
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
<script>
    function getOVMDetails() {
        $.ajax({
            url: '/user/status/view',
            type: 'GET',
            data: {
                'get_type': 'ovm',
            }
        }).done(function (data) {
            // console.log(data);
            if (data != '[]') {
                var user_select = data;
                var ddd = ''; // Initialize ddd as empty string
                for (var i = 0; i < user_select.length; i++) {

                    var audit_action = user_select[i].audit_action;
                    var child_name = user_select[i].child_name;
                    var is_coordinator1 = JSON.parse(user_select[i].is_coordinator1);
                    var is_coordinator2 = JSON.parse(user_select[i].is_coordinator2);
                    var enrollment_child_num = user_select[i].enrollment_child_num;
                    var audit_table_name = user_select[i].audit_table_name;
                    if (audit_table_name == 'ovm_meeting_2_details') {
                        audit_action = audit_action.replace('OVM', 'OVM 2');
                    } else if (audit_table_name == 'ovm_meeting_details') {
                        audit_action = audit_action.replace('OVM', 'OVM 1');
                    }

                    var meeting_startdate = user_select[i].meeting_startdate;
                    var meeting_starttime = user_select[i].meeting_starttime;

                    var day = meeting_startdate.substring(0, 2);
                    var month = meeting_startdate.substring(3, 5);
                    var year = meeting_startdate.substring(6, 10);
                    var formattedDate = month + '-' + day + '-' + year;

                    var startTime = meeting_starttime.split(':');
                    var hours = parseInt(startTime[0]);
                    var minutes = parseInt(startTime[1]);
                    var period = hours >= 12 ? 'PM' : 'AM';
                    hours = hours % 12;
                    hours = hours ? hours : 12; // Handle 0 as 12
                    var formattedTime = hours + ':' + minutes.toString().padStart(2, '0') + ' ' + period;

                    var formattedDateTime = formattedDate + ' & ' + formattedTime;

                    ddd += "<tr><td>" + (i + 1) + "</td><td>" + child_name + "</td><td>" + enrollment_child_num + "</td><td>" + is_coordinator1.name + (is_coordinator2.name == undefined ? '' : ', ' + is_coordinator2.name) + "</td><td>" + formattedDateTime + "</td><td>" + audit_action + "</td></tr>";
                }
                $('#getOVMdetails').html(ddd);
            } else {
                $('#getOVMdetails').html('<tr><td colspan="6" class="text-center">No data available in table</td></tr>');
            }

            $("#elina_ovm").modal();

            // Clear search field when modal is opened with new data
            $('#tableSearch').val('');
        })
    }

    // Add search functionality
    $(document).ready(function () {
        // Live search as you type
        $('#tableSearch').on('keyup', function () {
            var searchText = $(this).val().toLowerCase().trim();

            $('#getOVMdetails tr').each(function () {
                var rowText = $(this).text().toLowerCase();
                var isMatch = rowText.indexOf(searchText) > -1;
                $(this).toggleClass('hidden-row', !isMatch);
            });

            // Show "No results" message if all rows are hidden
            var visibleRows = $('#getOVMdetails tr:not(.hidden-row)').length;
            if (visibleRows === 0) {
                if ($('#noResultsRow').length === 0) {
                    $('#getOVMdetails').append('<tr id="noResultsRow" class="text-center"><td colspan="6" style="padding: 20px !important;">No matching records found</td></tr>');
                }
            } else {
                $('#noResultsRow').remove();
            }
        });

        // Clear search when modal is closed
        $('#elina_ovm').on('hidden.bs.modal', function () {
            $('#tableSearch').val('');
            $('#getOVMdetails tr').removeClass('hidden-row').removeClass('expanded');
            $('#noResultsRow').remove();
        });

        // Accordion toggle on mobile
        $(document).on('click', '#getOVMdetails tr', function() {
            if ($(window).width() <= 767) {
                $(this).toggleClass('expanded');
            }
        });
    });
</script>

<style>
    .hidden-row, #getOVMdetails tr.hidden-row {
        display: none !important;
    }

    /* Style the search field to match your design */
    #tableSearch {
        border: 1px solid #ddd;
        border-radius: 4px;
        padding: 8px 12px;
        font-size: 14px;
    }

    #tableSearch:focus {
        border-color: rgb(0 103 172);
        outline: none;
        box-shadow: 0 0 5px rgba(0, 103, 172, 0.3);
    }

    /* Remove any DataTables filter if present (just in case) */
    .dataTables_filter {
        display: none !important;
    }

    @media (max-width: 767px) {
        .modal-dialog.modal-xl {
            margin: 10px !important;
            max-width: calc(100% - 20px) !important;
        }

        .modal-body {
            padding: 10px !important;
        }

        .modal-header h4 {
            font-size: 1.1rem !important;
        }

        /* Search bar styling */
        #elina_ovm .row.mb-3 {
            margin-bottom: 10px !important;
        }
        #elina_ovm .row.mb-3 .col-md-4 {
            width: 100% !important;
            max-width: 100% !important;
            flex: 0 0 100% !important;
            padding: 0 10px !important;
            margin-top: 5px !important;
        }
        #elina_ovm .d-flex.align-items-center.justify-content-end {
            width: 100% !important;
            justify-content: flex-end !important;
        }
        #elina_ovm #tableSearch {
            width: 130px !important;
            height: 32px !important;
            font-size: 0.85rem !important;
            padding: 4px 8px !important;
        }

        .table-wrapper {
            height: auto !important;
            max-height: 400px !important;
            overflow-y: auto !important;
            padding: 0 !important;
        }

        #getOVMdetailsTable thead { display: none !important; }
        #getOVMdetailsTable tbody { background: transparent !important; }

        #getOVMdetails tr { 
            display: flex !important;
            flex-direction: column !important;
            align-items: stretch !important;
            border: 1px solid #e0e0e0 !important; 
            border-radius: 8px !important;
            margin-bottom: 8px !important;
            position: relative !important;
            padding: 10px 35px 10px 45px !important; /* right padding for chevron */
            background: #fff !important;
            box-shadow: 0 1px 4px rgba(0,0,0,0.05) !important;
            width: 100% !important;
            cursor: pointer !important;
        }

        #getOVMdetails tr::after {
            content: "\f078" !important;
            font-family: "FontAwesome" !important;
            position: absolute !important;
            right: 15px !important;
            top: 15px !important;
            font-size: 0.85rem !important;
            color: #7f8c8d !important;
            transition: transform 0.2s !important;
        }

        #getOVMdetails tr.expanded::after {
            transform: rotate(180deg) !important;
        }
        
        #getOVMdetails td {
            display: block !important;
            border: none !important;
            padding: 0 !important;
            text-align: left !important;
            white-space: normal !important;
            width: 100% !important;
            background: transparent !important;
            height: auto !important;
            min-height: 0 !important;
            line-height: 1.4 !important;
            font-size: 0.9rem !important; 
            color: #34495e !important;
            word-break: normal !important;
        }
        
        #getOVMdetails td:nth-of-type(1) {
            position: absolute !important;
            left: 15px !important;
            top: 15px !important;
            width: 25px !important;
            font-weight: bold !important;
            font-size: 1rem !important;
            color: #2c3e50 !important;
            background: transparent !important;
            display: flex !important;
            align-items: center !important;
            margin: 0 !important;
        }
        
        #getOVMdetails td:nth-of-type(2) {
            font-weight: bold !important;
            font-size: 1rem !important;
            color: #2c3e50 !important;
            margin-bottom: 4px !important;
            width: 100% !important;
        }
        
        #getOVMdetails td:nth-of-type(3) {
            font-size: 0.85rem !important;
            color: #7f8c8d !important;
            margin-bottom: 2px !important;
            display: block !important;
        }
        #getOVMdetails td:nth-of-type(3):before { content: "Enrollment: "; font-weight: bold !important; color: #333 !important; }

        /* Hidden details unless expanded */
        #getOVMdetails td:nth-of-type(4),
        #getOVMdetails td:nth-of-type(5),
        #getOVMdetails td:nth-of-type(6) {
            display: none !important;
        }

        #getOVMdetails tr.expanded td:nth-of-type(4) {
            display: block !important;
            margin-top: 4px !important;
            font-size: 0.85rem !important;
            color: #7f8c8d !important;
        }
        #getOVMdetails tr.expanded td:nth-of-type(4):before { content: "IS Coordinator: "; font-weight: bold !important; color: #333 !important; }

        #getOVMdetails tr.expanded td:nth-of-type(5) {
            display: block !important;
            margin-top: 2px !important;
            font-size: 0.85rem !important;
            color: #7f8c8d !important;
        }
        #getOVMdetails tr.expanded td:nth-of-type(5):before { content: "Meeting Time: "; font-weight: bold !important; color: #333 !important; }

        #getOVMdetails tr.expanded td:nth-of-type(6) {
            display: block !important;
            margin-top: 2px !important;
            font-size: 0.85rem !important;
            color: #7f8c8d !important;
        }
        #getOVMdetails tr.expanded td:nth-of-type(6):before { content: "Status: "; font-weight: bold !important; color: #333 !important; }
    }
</style>