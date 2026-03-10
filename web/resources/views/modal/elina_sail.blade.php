<div class="modal fade" id="elina_sail">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header bg-primary" style="background-color: rgb(0 103 172) !important;">
                <h4 class="modal-title">SAIL Details</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body p-0">
                <div class="p-3">
                    <!-- Show dropdown -->
                    <div class="row mb-3">
                        <div class="col-md-12 text-right">
                            <label class="mr-2">Show:</label>
                            <select id="statusSelect" class="form-control d-inline-block" style="width: 200px;">
                                <option value="all">All</option>
                            </select>
                        </div>
                    </div>
                    
                    <!-- Table -->
                    <div class="table-responsive">
                        <table class="table table-bordered" id="sailTable">
                            <thead class="bg-light">
                                <tr>
                                    <th>S.No</th>
                                    <th>Enrollment Number</th>
                                    <th>Child Name</th>
                                    <th>Is-coordinator</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody id="sailTableBody">
                                @foreach($rows['sail'] as $key => $row)
                                <tr data-status="{{ $row['audit_action'] }}">
                                    <td>{{ $key + 1 }}</td>
                                    <td>{{ $row['enrollment_child_num'] }}</td>
                                    <td>{{ $row['child_name'] }}</td>
                                    <td>{{ json_decode($row['is_coordinator1'])->name }}</td>
                                    <td>{{ $row['audit_action'] }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    
                    <!-- Record count -->
                    <div class="mt-2">
                        <span id="recordCount" class="text-muted"></span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    // Get all rows
    var allRows = $('#sailTableBody tr');
    var totalRows = allRows.length;
    
    // Get unique statuses
    var statuses = [];
    allRows.each(function() {
        var status = $(this).attr('data-status');
        if (statuses.indexOf(status) === -1) {
            statuses.push(status);
        }
    });
    statuses.sort();
    
    // Populate dropdown
    var select = $('#statusSelect');
    $.each(statuses, function(i, status) {
        select.append('<option value="' + status + '">' + status + '</option>');
    });
    
    // Show all rows initially
    allRows.show();
    $('#recordCount').text('Showing all ' + totalRows + ' records');
    $('.modal-title').text('SAIL Details ');
    
    // Filter on change
    select.on('change', function() {
        var selected = $(this).val();
        
        if (selected === 'all') {
            allRows.show();
            $('#recordCount').text('Showing all ' + totalRows + ' records');
            $('.modal-title').text('SAIL Details');
            
            // Reset S.No
            allRows.each(function(index) {
                $(this).find('td:first').text(index + 1);
            });
        } else {
            var visibleCount = 0;
            allRows.hide();
            
            allRows.each(function() {
                if ($(this).attr('data-status') === selected) {
                    $(this).show();
                    visibleCount++;
                }
            });
            
            // Update S.No for visible rows
            $('#sailTableBody tr:visible').each(function(index) {
                $(this).find('td:first').text(index + 1);
            });
            
            $('#recordCount').text('Showing ' + visibleCount + ' of ' + totalRows + ' records');
            $('.modal-title').text('SAIL Details');
        }
    });
    
    // Reset on modal close
    $('#elina_sail').on('hidden.bs.modal', function() {
        select.val('all');
        allRows.show();
        allRows.each(function(index) {
            $(this).find('td:first').text(index + 1);
        });
        $('#recordCount').text('Showing all ' + totalRows + ' records');
        $('.modal-title').text('SAIL Details');
    });
});
</script>

<style>
.modal-header.bg-primary {
    background-color: rgb(0, 103, 172) !important;
}
.modal-title {
    color: white;
}
#statusSelect {
    width: 200px;
    height: 35px;
    border: 1px solid #ced4da;
    border-radius: 4px;
    padding: 5px;
}
.table th {
    background-color: #f8f9fa;
}
#recordCount {
    font-size: 14px;
}
</style>