<div class="modal fade" id="elina_sail">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header" style=" background-color: rgb(0 103 172) !important; align-items: center !important;">
                <h4 class="modal-title" style="color: white !important; font-weight: bold !important; font-size: 1.25rem !important;">SAIL Details</h4>
                <button type="button" class="close" data-dismiss="modal" style="color: white !important; font-size: 2.2rem !important; opacity: 1 !important; font-weight: 300 !important; line-height: 1 !important; outline: none !important; padding: 0 !important; margin: 0 !important; margin-top: -20px !important;">&times;</button>
            </div>
            <div class="modal-body p-0">
                <div class="p-3">
                    <!-- Show dropdown & Search -->
                    <div class="d-flex align-items-center justify-content-between mb-3" style="gap: 10px; flex-wrap: nowrap;">
                        <div class="d-flex align-items-center" style="gap: 8px;">
                            <label class="mb-0" style="white-space: nowrap; font-size: 14px; font-weight: bold; color: #333;">Show:</label>
                            <select id="statusSelect" class="form-control" style="width: 180px; height: 38px; font-size: 14px; border: 1px solid #ced4da; border-radius: 4px; padding: 6px 12px;">
                                <option value="all">All</option>
                            </select>
                        </div>
                        <div>
                            <input type="text" id="sailSearch" class="form-control" placeholder="&#xF002; Search" style="width: 180px; height: 38px; font-family:Arial, FontAwesome; font-size: 14px; border: 1px solid #ced4da; border-radius: 4px; padding: 6px 12px;">
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
    $(document).ready(function () {
        // Get all rows
        var allRows = $('#sailTableBody tr');
        var totalRows = allRows.length;

        // Get unique statuses
        var statuses = [];
        allRows.each(function () {
            var status = $(this).attr('data-status');
            if (statuses.indexOf(status) === -1) {
                statuses.push(status);
            }
        });
        statuses.sort();

        // Populate dropdown
        var select = $('#statusSelect');
        $.each(statuses, function (i, status) {
            select.append('<option value="' + status + '">' + status + '</option>');
        });

        // Show all rows initially
        allRows.removeClass('hidden-row');
        $('#recordCount').text('Showing all ' + totalRows + ' records');

        function applyFilter() {
            var selected = select.val();
            var searchText = $('#sailSearch').val().toLowerCase().trim();
            var visibleCount = 0;

            allRows.each(function () {
                var rowText = $(this).text().toLowerCase();
                var status = $(this).attr('data-status');

                var matchesSearch = rowText.indexOf(searchText) > -1;
                var matchesStatus = (selected === 'all' || status === selected);

                if (matchesSearch && matchesStatus) {
                    $(this).removeClass('hidden-row');
                    visibleCount++;
                } else {
                    $(this).addClass('hidden-row');
                }
            });

            // Update S.No for visible rows
            $('#sailTableBody tr:not(.hidden-row)').each(function (index) {
                $(this).find('td:first').text(index + 1);
            });

            if (selected === 'all' && searchText === '') {
                $('#recordCount').text('Showing all ' + totalRows + ' records');
            } else {
                $('#recordCount').text('Showing ' + visibleCount + ' of ' + totalRows + ' records');
            }
        }

        // Filter on change
        select.on('change', applyFilter);

        // Search on keyup
        $('#sailSearch').on('keyup', applyFilter);

        // Reset on modal close
        $('#elina_sail').on('hidden.bs.modal', function () {
            select.val('all');
            $('#sailSearch').val('');
            allRows.removeClass('hidden-row').removeClass('expanded');
            allRows.each(function (index) {
                $(this).find('td:first').text(index + 1);
            });
            $('#recordCount').text('Showing all ' + totalRows + ' records');
        });

        // Accordion toggle on mobile
        $(document).on('click', '#sailTableBody tr', function() {
            if ($(window).width() <= 767) {
                $(this).toggleClass('expanded');
            }
        });
    });
</script>

<style>
    .hidden-row, #sailTableBody tr.hidden-row {
        display: none !important;
    }

    .modal-header.bg-primary {
        background-color: rgb(0, 103, 172) !important;
    }

    .modal-title {
        color: white;
    }

    #statusSelect, #sailSearch {
        width: 180px;
        height: 38px;
        border: 1px solid #ced4da;
        border-radius: 4px;
        padding: 6px 12px;
        font-size: 14px;
    }

    .table th {
        background-color: #f8f9fa;
    }

    #recordCount {
        font-size: 14px;
    }

    @media (max-width: 767px) {
        .modal-dialog.modal-xl {
            margin: 10px !important;
            max-width: calc(100% - 20px) !important;
        }

        .p-3 {
            padding: 10px !important;
        }

        .modal-header h4 {
            font-size: 1.1rem !important;
        }

        #statusSelect, #sailSearch {
            width: 130px !important;
            height: 32px !important;
            font-size: 0.85rem !important;
            padding: 4px 8px !important;
        }

        #sailTable thead { display: none !important; }
        #sailTable tbody { background: transparent !important; }

        #sailTableBody tr { 
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

        #sailTableBody tr::after {
            content: "\f078" !important;
            font-family: "FontAwesome" !important;
            position: absolute !important;
            right: 15px !important;
            top: 15px !important;
            font-size: 0.85rem !important;
            color: #7f8c8d !important;
            transition: transform 0.2s !important;
        }

        #sailTableBody tr.expanded::after {
            transform: rotate(180deg) !important;
        }
        
        #sailTableBody td {
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
        
        #sailTableBody td:nth-of-type(1) {
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
        
        #sailTableBody td:nth-of-type(3) {
            font-weight: bold !important;
            font-size: 1rem !important;
            color: #2c3e50 !important;
            margin-bottom: 4px !important;
            width: 100% !important;
            order: 1 !important; /* Child Name first! */
        }
        
        #sailTableBody td:nth-of-type(2) {
            font-size: 0.85rem !important;
            color: #7f8c8d !important;
            margin-bottom: 2px !important;
            order: 2 !important;
            display: block !important;
        }
        #sailTableBody td:nth-of-type(2):before { content: "Enrollment: "; font-weight: bold !important; color: #333 !important; }

        /* Hidden details unless expanded */
        #sailTableBody td:nth-of-type(4),
        #sailTableBody td:nth-of-type(5) {
            display: none !important;
        }

        #sailTableBody tr.expanded td:nth-of-type(4) {
            display: block !important;
            margin-top: 4px !important;
            font-size: 0.85rem !important;
            color: #7f8c8d !important;
            order: 3 !important;
        }
        #sailTableBody tr.expanded td:nth-of-type(4):before { content: "Coordinator: "; font-weight: bold !important; color: #333 !important; }

        #sailTableBody tr.expanded td:nth-of-type(5) {
            display: block !important;
            margin-top: 2px !important;
            font-size: 0.85rem !important;
            color: #7f8c8d !important;
            order: 4 !important;
        }
        #sailTableBody tr.expanded td:nth-of-type(5):before { content: "Status: "; font-weight: bold !important; color: #333 !important; }

        #recordCount {
            font-size: 10px !important;
        }
    }
</style>