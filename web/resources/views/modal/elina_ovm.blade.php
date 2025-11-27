<div class="modal fade" id="elina_ovm">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header bg-primary" style=" background-color: rgb(0 103 172) !important;">
                <h4 class="modal-title">Overall OVM Meetings</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            </div>
            <div class="modal-body" style="padding:0">
                <div class="col-12" style="padding:0">
                    <div class="card-body" id="card_header">
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
                var ddd;
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
                    var formattedDate = `${month}-${day}-${year}`;

                    var startTime = meeting_starttime.split(':');
                    var hours = parseInt(startTime[0]);
                    var minutes = parseInt(startTime[1]);
                    var period = hours >= 12 ? 'PM' : 'AM';
                    var formattedTime = `${((hours + 11) % 12) + 1}:${minutes.toString().padStart(2, '0')} ${period}`;

                    var formattedDateTime = `${formattedDate} & ${formattedTime}`;

                    ddd += "<tr><td >" + (parseInt(i) + 1) + "</td><td>" + child_name + "</td><td> " + enrollment_child_num + " </td><td> " + is_coordinator1.name + (is_coordinator2.name == undefined ? '' : ',' + is_coordinator2.name) + " </td><td> " + formattedDateTime + " </td><td> " + audit_action + " </td></tr>";
                }
                var demonew = $('#getOVMdetails').html(ddd);
                // dashboardTable.ajax.reload();
            } else {
                var stageoption = ddd.concat(optionsdata);
            }
            // $(".loader").hide();
            $("#elina_ovm").modal();
        })
    }
</script>