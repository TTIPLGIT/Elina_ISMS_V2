<style>
    table {
        border-collapse: collapse;
        width: 100%;
    }

    th,
    td {
        border: 1px solid #ddd;
        padding: 8px;
        text-align: center;
    }

    th {
        background-color: #f2f2f2;
    }

    .pagination {
        display: flex;
        justify-content: center;
        list-style: none;
        padding: 0;
    }

    .pagination li {
        display: inline-block;
        margin: 0 4px;
    }

    .pagination a {
        color: black;
        padding: 8px 16px;
        text-decoration: none;
        transition: background-color .3s;
    }

    .pagination a.active {
        background-color: #4CAF50;
        color: white;
    }

    .pagination a:hover:not(.active) {
        background-color: #ddd;
    }

    .pagination {
        display: flex;
        justify-content: center;
        margin-top: 20px;
        margin-bottom: 20px;
    }

    .pagination ul {
        list-style: none;
        padding: 0;
    }

    .pagination li {
        display: inline-block;
        margin: 0 5px;
    }

    .pagination a {
        color: #333;
        background-color: #f8f9fa;
        border: 1px solid #dee2e6;
        padding: 8px 16px;
        text-decoration: none;
        transition: background-color .3s;
    }

    .pagination a.active {
        background-color: #007bff;
        color: white;
        border: 1px solid #007bff;
    }

    .pagination a:hover:not(.active) {
        background-color: #e9ecef;
    }

    .pagination #prev,
    .pagination #next {
        font-weight: bold;
    }

    .pagination #prev.disabled,
    .pagination #next.disabled {
        pointer-events: none;
        cursor: not-allowed;
        color: #868e96;
        border: 1px solid #dee2e6;
    }

    .pagination li.disabled a {
        pointer-events: none;
        cursor: not-allowed;
        color: #868e96;
        display: none;
    }

    .lead_filter {
        font-size: 24px !important;
        display: flex;
        align-items: center;
        color: green;
        width: 100% !important;
        height: 100% !important;
    }

    .hidden-row, #lead_details tr.hidden-row {
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

        /* Filter header styling */
        #leadModal select#leadTypeFilter {
            width: 110px !important;
            height: 32px !important;
            font-size: 0.8rem !important;
            flex: none !important;
            max-width: none !important;
        }
        #leadModal .filtering {
            width: auto !important;
            flex: none !important;
            max-width: none !important;
            margin: 0 5px !important;
        }
        #leadModal #leadSearch {
            width: 140px !important;
            height: 32px !important;
            font-size: 0.8rem !important;
            flex: none !important;
            max-width: none !important;
        }

        .card-body {
            padding: 10px 0 !important;
        }

        #leadTable thead { display: none !important; }
        #leadTable tbody { background: transparent !important; }

        #lead_details tr { 
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

        #lead_details tr::after {
            content: "\f078" !important;
            font-family: "FontAwesome" !important;
            position: absolute !important;
            right: 15px !important;
            top: 15px !important;
            font-size: 0.85rem !important;
            color: #7f8c8d !important;
            transition: transform 0.2s !important;
        }

        #lead_details tr.expanded::after {
            transform: rotate(180deg) !important;
        }
        
        #lead_details td {
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
        
        #lead_details td:nth-of-type(1) {
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
        
        #lead_details td:nth-of-type(3) {
            font-weight: bold !important;
            font-size: 1rem !important;
            color: #2c3e50 !important;
            margin-bottom: 4px !important;
            width: 100% !important;
            order: 1 !important; /* Child Name first! */
        }
        
        #lead_details td:nth-of-type(2) {
            font-size: 0.85rem !important;
            color: #7f8c8d !important;
            margin-bottom: 2px !important;
            order: 2 !important;
            display: block !important;
        }
        #lead_details td:nth-of-type(2):before { content: "Enrollment ID: "; font-weight: bold !important; color: #333 !important; }

        /* Hidden details unless expanded */
        #lead_details td:nth-of-type(4),
        #lead_details td:nth-of-type(5),
        #lead_details td:nth-of-type(6),
        #lead_details td:nth-of-type(7) {
            display: none !important;
        }

        #lead_details tr.expanded td:nth-of-type(4) {
            display: block !important;
            margin-top: 4px !important;
            font-size: 0.85rem !important;
            color: #7f8c8d !important;
            order: 3 !important;
        }
        #lead_details tr.expanded td:nth-of-type(4):before { content: "Email: "; font-weight: bold !important; color: #333 !important; }

        #lead_details tr.expanded td:nth-of-type(5) {
            display: block !important;
            margin-top: 2px !important;
            font-size: 0.85rem !important;
            color: #7f8c8d !important;
            order: 4 !important;
        }
        #lead_details tr.expanded td:nth-of-type(5):before { content: "Mobile No: "; font-weight: bold !important; color: #333 !important; }

        #lead_details tr.expanded td:nth-of-type(6) {
            display: block !important;
            margin-top: 2px !important;
            font-size: 0.85rem !important;
            color: #7f8c8d !important;
            order: 5 !important;
        }
        #lead_details tr.expanded td:nth-of-type(6):before { content: "DoR: "; font-weight: bold !important; color: #333 !important; }

        #lead_details tr.expanded td:nth-of-type(7) {
            display: block !important;
            order: 6 !important;
            margin-top: 4px !important;
        }

        .pagination a {
            padding: 4px 6px !important;
            font-size: 9px !important;
        }
        
        .pagination li {
            margin: 0 2px !important;
        }
    }
</style>
<div class="modal fade" id="leadModal">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header" style=" background-color: rgb(0 103 172) !important; align-items: center !important;">
                <h4 class="modal-title" style="color: white !important; font-weight: bold !important; font-size: 1.25rem !important;">Elina Lead</h4>
                <button type="button" class="close" data-dismiss="modal" style="color: white !important; font-size: 2.2rem !important; opacity: 1 !important; font-weight: 300 !important; line-height: 1 !important; outline: none !important; padding: 0 !important; margin: 0 !important; margin-top: -20px !important;">&times;</button>
            </div>
            <div class="modal-body" style="padding:0">
                <div class="col-12" style="padding:10px">
                    <div style="display: flex;justify-content: space-between;">
                        <select id="leadTypeFilter" class="col-4 form-control default">
                            <option value="all">All</option>
                            <option value="1">Enrollment</option>
                            <option value="2">Start Your Journey</option>
                        </select>
                        <div class="col-md-5 filtering"><i class="fa fa-filter lead_filter" aria-hidden="true"></i>
                        </div>
                        <input oninput="searchlead(event)" id="leadSearch"
                            style="width: 30%;float: right;margin: 0 15px 0px 0px;font-family:Arial, FontAwesome"
                            type="text" class="form-control default" placeholder="&#xF002; Search">
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered" id="leadTable">
                            <thead>
                                <tr>
                                    <th width="5%">S.No</th>
                                    <th width="10%">Enrollement Id</th>
                                    <th>Child Name</th>
                                    <th>Email</th>
                                    <th>Mobile No</th>
                                    <th width="10%">DoR</th>
                                    <th width="5%">Action</th>
                                </tr>
                            </thead>
                            <tbody id="lead_details">

                            </tbody>
                        </table>
                    </div>
                    <div class="pagination" id="pagination">
                        <ul>
                            <li><a href="#" id="prev">Previous</a></li>
                            <!-- Pagination links will be added dynamically -->
                            <li><a href="#" id="next">Next</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<form action="{{route('lead_view')}}" method="post" id="lead_view">
    <input type="hidden" name="type_id" id="type_id">
    <input type="hidden" name="viewid" id="viewid">
</form>

<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
<script>
    function getleadDetails() {
        $.ajax({
            url: '/user/status/view',
            type: 'GET',
            data: {
                'get_type': 'leads',
            }
        }).done(function (data) {
            // console.log(data);
            var monthNames = ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"];

            if (data != '[]') {
                var user_select = data;
                var ddd = '';
                for (var i = 0; i < user_select.length; i++) {
                    var type_id = user_select[i].type_id;
                    var enrollment_id = user_select[i].enrollment_id;
                    var enrollment_child_num = user_select[i].enrollment_child_num;
                    var created_date = user_select[i].created_date;
                    var child_name = user_select[i].child_name;
                    var child_contact_phone = user_select[i].child_contact_phone;
                    var child_contact_email = user_select[i].child_contact_email;

                    created_date = new Date(created_date);
                    var day = created_date.getDate();
                    var month = created_date.getMonth();
                    var year = created_date.getFullYear();
                    var formattedDate = day + " " + monthNames[month] + " " + year;

                    ddd += "<tr class='listshow' lead-type=" + type_id + "><td>" + (parseInt(i) + 1) + "</td><td>" + enrollment_child_num + "</td><td> " + child_name + " </td><td> " + child_contact_email + " </td><td> " + child_contact_phone + " </td><td>" + formattedDate + "</td><td><a class='btn btn-link' title='Show' onclick='gotoview(" + type_id + "," + enrollment_id + ")'><i class='fas fa-eye' style='color:green'></i></a></td></tr>";
                }
                var demonew = $('#lead_details').html(ddd);
                // dashboardTable.ajax.reload();
            } else {
                var stageoption = ddd.concat(optionsdata);
            }
            // $(".loader").hide();
            currentPage = 1; // Reset pagination to first page
            displayRows();
            updatePagination();
            $("#leadModal").modal();
        })
    }

    function gotoview(type_id, viewid) {
        console.log(type_id, viewid);
        document.getElementById('type_id').value = type_id;
        document.getElementById('viewid').value = viewid;
        document.getElementById('lead_view').submit();

        // $.ajax({
        //     url: '/lead/view/userdetails',
        //     type: 'GET',
        //     data: {
        //         'get_type': 'leads',
        //         'type_id': type_id,
        //         'viewid': viewid
        //     }
        // });
    }
</script>

<script>
    var table = document.getElementById("leadTable");
    var rowsPerPage = 5; // Number of rows per page
    var maxPaginationLinks = 5; // Maximum number of pagination links to display
    var currentPage = 1;

    function displayRows() {
        var startIndex = (currentPage - 1) * rowsPerPage;
        var endIndex = startIndex + rowsPerPage;

        var rows = table.querySelectorAll("tbody tr");
        rows.forEach(function (row) {
            row.classList.add("hidden-row");
        });

        var activeRows = table.querySelectorAll("tbody tr.listshow");
        activeRows.forEach(function (row, index) {
            if (index >= startIndex && index < endIndex) {
                row.classList.remove("hidden-row");
            }
        });

        // Update sequential S.No for the active/filtered rows
        activeRows.forEach(function (row, index) {
            var sNoCell = row.querySelector("td:first-child");
            if (sNoCell) {
                sNoCell.textContent = index + 1;
            }
        });
    }

    function updatePagination() {
        var numPages = Math.ceil(table.querySelectorAll("tbody tr.listshow").length / rowsPerPage);
        var paginationElement = document.getElementById("pagination").querySelector("ul");
        paginationElement.innerHTML = "";

        if (numPages <= 1) {
            return;
        }

        var prevBtn = document.createElement("li");
        var prevLink = document.createElement("a");
        prevLink.href = "#";
        prevLink.textContent = "Previous";
        prevLink.id = "prev";
        prevBtn.appendChild(prevLink);

        prevBtn.addEventListener("click", function (event) {
            event.preventDefault();
            if (currentPage > 1) {
                currentPage--;
                displayRows();
                updatePagination();
            }
        });

        var nextBtn = document.createElement("li");
        var nextLink = document.createElement("a");
        nextLink.href = "#";
        nextLink.textContent = "Next";
        nextLink.id = "next";
        nextBtn.appendChild(nextLink);

        nextBtn.addEventListener("click", function (event) {
            event.preventDefault();
            if (currentPage < numPages) {
                currentPage++;
                displayRows();
                updatePagination();
            }
        });

        if (currentPage === 1) {
            prevBtn.classList.add("disabled");
        } else if (currentPage === numPages) {
            nextBtn.classList.add("disabled");
        }

        paginationElement.appendChild(prevBtn);

        var startPage = Math.max(1, Math.min(currentPage - Math.floor(maxPaginationLinks / 2), numPages - maxPaginationLinks + 1));
        var endPage = Math.min(startPage + maxPaginationLinks - 1, numPages);

        for (var i = startPage; i <= endPage; i++) {
            var link = document.createElement("a");
            link.href = "#";
            link.textContent = i;

            if (i === currentPage) {
                link.classList.add("active");
            }

            link.addEventListener("click", function (event) {
                event.preventDefault();
                currentPage = parseInt(this.textContent);
                displayRows();
                updatePagination();
            });

            paginationElement.appendChild(link);
        }

        paginationElement.appendChild(nextBtn);
    }
    displayRows();
    updatePagination();
</script>
<script>
    function applyLeadsFilter() {
        var selectedValue = document.getElementById("leadTypeFilter").value;
        var searchText = document.getElementById("leadSearch").value.toLowerCase().trim();
        var rows = document.querySelectorAll('#lead_details tr');

        rows.forEach(function (row) {
            var rowText = row.textContent.toLowerCase();
            var type = row.getAttribute('lead-type');

            var matchesSearch = rowText.indexOf(searchText) > -1;
            var matchesType = (selectedValue === "all" || type === selectedValue);

            if (matchesSearch && matchesType) {
                row.classList.add('listshow');
            } else {
                row.classList.remove('listshow');
            }
        });
        currentPage = 1;
        displayRows();
        updatePagination();
    }

    document.getElementById("leadTypeFilter").addEventListener("change", applyLeadsFilter);
</script>
<script>
    function searchlead(event) {
        applyLeadsFilter();
    }

    $(document).ready(function () {
        // Clear search when modal is closed
        $('#leadModal').on('hidden.bs.modal', function () {
            $('#leadSearch').val('');
            $('#leadTypeFilter').val('all');
            $('#lead_details tr').removeClass('hidden-row').removeClass('expanded');
            applyLeadsFilter();
        });

        // Accordion toggle on mobile
        $(document).on('click', '#lead_details tr', function() {
            if ($(window).width() <= 767) {
                $(this).toggleClass('expanded');
            }
        });
    });
</script>