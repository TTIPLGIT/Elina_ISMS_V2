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
                        <div class="form-group" style="display: flex;padding: 10px 0px 0px 0px;margin: 0 0 10px 5px;">
                            <label class="control-label" style="margin: 10px 10px 0px 10px;">Show</label>
                            <select class="col-md-3 form-control default" id="statusSelect">
                                <option value="all">All</option>
                                <!-- Options will be populated dynamically -->
                            </select>
                        </div>
                        
                        <!-- Search Box -->
                        <!-- <div class="form-group" style="display: flex;padding: 10px 0px 0px 0px;margin: 0 0 10px 5px;">
                            <label class="control-label" style="margin: 10px 10px 0px 10px;">Search</label>
                            <input type="text" class="col-md-3 form-control" id="searchInput" placeholder="Search Here">
                        </div> -->
                        
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
                                    <tbody id="tableBody">
                                        @foreach($rows['sail'] as $key=>$row)
                                        <tr class="data-row" data-status="{{ $row['audit_action'] }}">
                                            <td>{{ $key + 1 }}</td>
                                            <td class="enrollment-cell">{{ $row['enrollment_child_num']}}</td>
                                            <td class="child-name-cell">{{ $row['child_name']}}</td>
                                            <td>{{ json_decode($row['is_coordinator1'])->name }}</td>
                                            <td class="status-cell">{{ $row['audit_action']}}</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        
                        <!-- Pagination Info -->
                        <div class="row" style="padding: 10px;">
                            <div class="col-md-6">
                                <span id="recordCount">Loading...</span>
                            </div>
                            <div class="col-md-6 text-right" id="paginationLinks">
                                <!-- Pagination will be dynamically updated -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    let currentPage = 1;
    const rowsPerPage = 10; // Change this to whatever rows per page you want
    let allRows = [];
    let filteredRows = [];
    
    function fetchUniqueStatusValues() {
        const statusSet = new Set();
        allRows.forEach(row => {
            const status = row.getAttribute('data-status');
            if (status) {
                statusSet.add(status);
            }
        });
        return Array.from(statusSet).sort();
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

    function filterData() {
        const statusSelect = document.getElementById("statusSelect");
        const searchInput = document.getElementById("searchInput");
        
        const selectedStatus = statusSelect.value;
        const searchTerm = searchInput ? searchInput.value.toLowerCase() : '';
        
        // Filter rows based on status and search
        filteredRows = allRows.filter(row => {
            const status = row.getAttribute('data-status');
            const enrollment = row.querySelector('.enrollment-cell')?.textContent.toLowerCase() || '';
            const childName = row.querySelector('.child-name-cell')?.textContent.toLowerCase() || '';
            
            const statusMatch = selectedStatus === 'all' || status === selectedStatus;
            const searchMatch = searchTerm === '' || 
                               enrollment.includes(searchTerm) || 
                               childName.includes(searchTerm);
            
            return statusMatch && searchMatch;
        });
        
        // Reset to page 1
        currentPage = 1;
        displayCurrentPage();
        updatePagination();
        updateRecordCount();
    }

    function displayCurrentPage() {
        const start = (currentPage - 1) * rowsPerPage;
        const end = start + rowsPerPage;
        const pageRows = filteredRows.slice(start, end);
        
        // Hide all rows first
        allRows.forEach(row => row.style.display = 'none');
        
        // Show only current page rows
        pageRows.forEach(row => {
            row.style.display = '';
        });
    }

    function updatePagination() {
        const totalPages = Math.ceil(filteredRows.length / rowsPerPage);
        const paginationDiv = document.getElementById('paginationLinks');
        
        if (totalPages <= 1) {
            paginationDiv.innerHTML = '';
            return;
        }
        
        let paginationHtml = '<nav><ul class="pagination justify-content-end">';
        
        // Previous button
        paginationHtml += `<li class="page-item ${currentPage === 1 ? 'disabled' : ''}">
            <a class="page-link" href="#" data-page="${currentPage - 1}">Previous</a>
        </li>`;
        
        // Page numbers
        for (let i = 1; i <= totalPages; i++) {
            paginationHtml += `<li class="page-item ${currentPage === i ? 'active' : ''}">
                <a class="page-link" href="#" data-page="${i}">${i}</a>
            </li>`;
        }
        
        // Next button
        paginationHtml += `<li class="page-item ${currentPage === totalPages ? 'disabled' : ''}">
            <a class="page-link" href="#" data-page="${currentPage + 1}">Next</a>
        </li>`;
        
        paginationHtml += '</ul></nav>';
        
        paginationDiv.innerHTML = paginationHtml;
        
        // Add event listeners to pagination links
        document.querySelectorAll('.pagination a').forEach(link => {
            link.addEventListener('click', function(e) {
                e.preventDefault();
                const page = parseInt(this.getAttribute('data-page'));
                if (!isNaN(page) && page >= 1 && page <= totalPages) {
                    currentPage = page;
                    displayCurrentPage();
                    updatePagination();
                }
            });
        });
    }

    function updateRecordCount() {
        const recordSpan = document.getElementById('recordCount');
        const totalFiltered = filteredRows.length;
        const start = (currentPage - 1) * rowsPerPage + 1;
        const end = Math.min(currentPage * rowsPerPage, totalFiltered);
        
        if (totalFiltered === 0) {
            recordSpan.textContent = 'No records found';
        } else {
            recordSpan.textContent = `Showing ${start} to ${end} of ${totalFiltered} records`;
        }
        
        // Update modal title with filter info
        const modalTitle = document.querySelector('.modal-title');
        const statusSelect = document.getElementById("statusSelect");
        const selectedStatus = statusSelect.value;
        
        if (selectedStatus !== 'all') {
            modalTitle.textContent = `SAIL Details - Filtered: ${selectedStatus}`;
        } else {
            modalTitle.textContent = 'SAIL Details';
        }
    }

    // Initialize
    document.addEventListener("DOMContentLoaded", function() {
        // Store all rows
        allRows = Array.from(document.querySelectorAll('#tableBody .data-row'));
        filteredRows = [...allRows];
        
        populateStatusOptions();
        displayCurrentPage();
        updatePagination();
        updateRecordCount();
        
        const statusSelect = document.getElementById("statusSelect");
        const searchInput = document.getElementById("searchInput");
        
        statusSelect.addEventListener("change", filterData);
        searchInput.addEventListener("keyup", filterData);
    });
</script>