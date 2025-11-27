<div class="modal fade" id="elina_sail">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header bg-primary" style=" background-color: rgb(0 103 172) !important;">
                <h4 class="modal-title">SAIL Details</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            </div>
            <div class="modal-body" style="padding:0">
                <div class="col-12" style="padding:0">
                    <div class="card-body" id="card_header">
                        <div class="form-group" style="display: flex;padding: 10px 0px 0px 0px;margin: 0 0 -35px 5px;">
                            <label class="control-label" style="margin: 10px 10px 0px 10px;">Show</label>
                            <select class="col-md-3 form-control default" id="statusSelect">
                                <option value="all">All</option>
                                <option value="Assessment Report Sent">Assessment Report Sent</option>
                                <option value="Activity Initiated">Activity Initiated</option>
                                <option value="Recommendation Report Sent">Recommendation Report Sent</option>
                            </select>
                        </div>
                        <div class="table-wrapper" style="padding: 10px;">
                            <div class="table-responsive">
                                <table class="table table-bordered dashboardTable" id="statusTable">
                                    <thead>
                                        <tr>
                                            <th style="width:5px !important">S.No</th>
                                            <th>Enrollment Number</th>
                                            <th>Child Name</th>
                                            <th>Is-coordinator</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($rows['sail'] as $key=>$row)
                                        <tr>
                                            <td>{{ ++$key }}</td>
                                            <td>{{ $row['child_name']}}</td>
                                            <td>{{ $row['enrollment_child_num']}}</td>
                                            <td>{{ json_decode($row['is_coordinator1'])->name }}</td>
                                            <td>{{ $row['audit_action']}}</td>
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
</div>

<script>
    function fetchUniqueStatusValues() {
        const statusSet = new Set();
        const table = document.querySelector("#statusTable");
        const rows = table.getElementsByTagName("tr");
        for (let i = 1; i < rows.length; i++) {
            const row = rows[i];
            const statusCell = row.cells[4];
            const statusText = statusCell.textContent.trim();
            statusSet.add(statusText);
        }
        return Array.from(statusSet);
    }

    function populateStatusOptions() {
        const statusSelect = document.getElementById("statusSelect");
        const statusValues = fetchUniqueStatusValues();
        statusSelect.innerHTML = "";

        const allOption = document.createElement("option");
        allOption.value = "all";
        allOption.textContent = "All";
        statusSelect.appendChild(allOption);
        statusValues.forEach((status) => {
            const option = document.createElement("option");
            option.value = status;
            option.textContent = status;
            statusSelect.appendChild(option);
        });
    }

    function filterTableByStatus() {
        const statusSelect = document.getElementById("statusSelect");
        const statusValue = statusSelect.value;
        const table = document.querySelector("#statusTable");
        const rows = table.getElementsByTagName("tr");

        for (let i = 1; i < rows.length; i++) {
            const row = rows[i];
            const statusCell = row.cells[4];
            const statusText = statusCell.textContent.trim();

            // Show or hide rows based on the selected status
            if (statusValue === "all" || statusText === statusValue) {
                row.style.display = "table-row";
            } else {
                row.style.display = "none";
            }
        }
    }
    document.getElementById("statusSelect").addEventListener("change", filterTableByStatus);
    populateStatusOptions();
</script>