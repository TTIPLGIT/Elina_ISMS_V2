<div class="modal fade" id="elina_ovm">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header bg-primary" style=" background-color: rgb(0 103 172) !important;">
                 <h4> Overall OVM Meetings</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            </div>
            <div class="modal-body" style="padding:0">
                <div class="col-12" style="padding:0">
                    <div class="card-body" id="card_header">
                        <!-- Add search input field above table -->
                        <div class="row mb-3">
                            <div class="col-md-4 mt-3 offset-md-8">
                                <div class="d-flex align-items-center justify-content-end">
                                    <label class="mb-0 mr-2" style="font-size: 14px; color: #333333; font-weight: 400; white-space: nowrap;">Search:</label>
                                    <input type="text" id="tableSearch" class="form-control" placeholder="" style="width: 200px; font-size: 14px; color: #495057; border: 1px solid #ced4da; border-radius: 4px; height: 35px;">
                                </div>
                            </div>
                        </div>
                        <div class="table-wrapper" style="padding: 10px;">
                            <div class="table-responsive">
                                <table class="table table-bordered dashboardTable" id="getOVMdetailsTable">
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
                                        <td>{{ json_decode($row['is_coordinator1'])->name }}{{ isset($row['is_coordinator2']) && $row['is_coordinator2'] != '{}' ? ' , ' . json_decode($row['is_coordinator2'])->name : '' }}</td>
                                        <td>{{ $row['meeting_startdate']}} & {{ date('h:i A', strtotime($row['meeting_starttime'])) }}</td>
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
        }).done(function(data) {
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
    $(document).ready(function() {
        // Live search as you type
        $('#tableSearch').on('keyup', function() {
            var searchText = $(this).val().toLowerCase().trim();

            $('#getOVMdetails tr').each(function() {
                var rowText = $(this).text().toLowerCase();

                if (rowText.indexOf(searchText) === -1) {
                    $(this).hide();
                } else {
                    $(this).show();
                }
            });

            // Show "No results" message if all rows are hidden
            var visibleRows = $('#getOVMdetails tr:visible').length;
            if (visibleRows === 0) {
                if ($('#noResultsRow').length === 0) {
                    $('#getOVMdetails').append('<tr id="noResultsRow"><td colspan="6" class="text-center ">No matching records found</td></tr>');
                }
            } else {
                $('#noResultsRow').remove();
            }
        });

        // Clear search when modal is closed
        $('#elina_ovm').on('hidden.bs.modal', function() {
            $('#tableSearch').val('');
            $('#getOVMdetails tr').show();
            $('#noResultsRow').remove();
        });
    });
</script>

<style>
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

    /* Optional: Style for "No results" message */
    #noResultsRow td {
        padding: 20px !important;
      
    }

    /* Remove any DataTables filter if present (just in case) */
    .dataTables_filter {
        display: none !important;
    }
</style>