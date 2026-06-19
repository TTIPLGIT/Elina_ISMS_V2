@extends('layouts.adminnav')

@section('content')
<style>
    .badge2.text-bg-danger {
        background-color: red;
        outline-color: black;
        padding: 5px;
    }

    tbody {
        font-size: 15px;
        font-weight: 600;
        border: 3px solid white;
    }

    .pagination {
        display: flex;
        justify-content: center;
    }

    .custom-month-input {
        background-color: transparent;
        font-size: 16px !important;
        font-weight: 700;
    }

    .arrow-container {
        position: absolute;
        right: 0;
        pointer-events: none;
    }

    .arrow {
        width: 100%;
        text-align: center;
        cursor: pointer;
        pointer-events: auto;
    }

    .input-container {
        position: relative;
        display: flex;
        gap: 19px;
        align-items: center;
        justify-content: center;
    }

    .month {
        font-size: 16px !important;
        font-weight: 700;
    }

    .weekDropdown {
        font-size: 16px !important;
        font-weight: 700;
    }

    .checkbox-label {
        display: flex;
        align-items: center;
    }

    .checkbox-label input[type="checkbox"] {
        margin-right: 5px;
    }

    input[type="month"] {
        position: relative;
        padding-left: 10px;
    }

    input[type="month"]::before {
        content: attr(placeholder);
        color: black;
        position: absolute;
        top: 50%;
        left: 10px;
        transform: translateY(-50%);
        pointer-events: none;
    }

    input[type="month"]:focus::before,
    input[type="month"]:active::before {
        content: "";
    }

    tr:nth-child(odd) {
        background-color: #dddddd;
    }

    tr:nth-child(even) {
        background-color: #aaaaaa;
    }

    .orange-text {
        color: orange;
    }

    .green-text {
        color: green;
    }

    .red-text {
        color: red;
    }

    textarea.form-control {
        height: 88px !important;
    }

    /* Breadcrumb – keep on one line */
    .breadcrumb {
        display: flex !important;
        flex-wrap: nowrap !important;
        overflow-x: auto !important;
        white-space: nowrap !important;
        -webkit-overflow-scrolling: touch;
        padding: 8px 15px;
        margin-bottom: 10px;
    }
    .breadcrumb-item + .breadcrumb-item {
        padding-left: 0.5rem;
    }
    .breadcrumb-item + .breadcrumb-item::before {
        content: "/";
        padding-right: 0.5rem;
    }

    /* Header row – remove gray line and keep button left */
    #weekDetails table tr:first-child td {
        border: none !important;
        background: #160b44 !important;
        color: #ffffff;
        padding: 8px 10px !important;
    }

    .week-header-row {
        display: flex !important;
        align-items: center !important;
        gap: 12px !important;
        flex-wrap: wrap !important;
    }
    .week-header-row .week-label {
        font-weight: 600;
        font-size: 15px;
        flex: 1 1 auto;
    }
    .week-header-row .btn {
        flex: 0 0 auto;
        padding: 4px 12px;
        font-size: 14px;
        white-space: nowrap;
    }

    /* ==========================================
       MOBILE RESPONSIVE
       ========================================== */
    @media (max-width: 768px) {
        .main-content,
        .card,
        .card-body,
        .section-body {
            padding-left: 10px !important;
            padding-right: 10px !important;
        }

        .row {
            margin-left: 0 !important;
            margin-right: 0 !important;
        }

        [class*="col-"] {
            padding-left: 5px !important;
            padding-right: 5px !important;
            flex: 0 0 100% !important;
            max-width: 100% !important;
        }

        .form-group {
            margin-bottom: 15px !important;
        }

        .form-group label {
            display: block !important;
            width: 100% !important;
            text-align: left !important;
            margin-bottom: 5px !important;
            font-weight: 600 !important;
        }

        .form-control,
        .form-control[readonly] {
            width: 100% !important;
            height: 40px !important;
            font-size: 14px !important;
        }

        select.form-control {
            height: 40px !important;
        }

        /* Month + Week pickers – stack vertically (month first, week second) */
        .input-container {
            flex-direction: column !important;
            gap: 10px !important;
            width: 100% !important;
            align-items: stretch !important;
        }

        .input-container .form-control {
            width: 100% !important;
        }

        /* Week details – make table horizontally scrollable */
        #weekDetails > div[style*="overflow-y: auto;"] {
            overflow-x: auto !important;
            max-height: none !important;
            padding-bottom: 10px;
        }

        #weekDetails table {
            min-width: 600px !important;
            width: 100% !important;
            font-size: 13px !important;
        }

        #weekDetails table td,
        #weekDetails table th {
            white-space: nowrap !important;
            padding: 6px 4px !important;
        }

        /* Tooltip icons and counts – adjust font */
        #weekDetails table td span {
            font-size: 13px !important;
        }

        /* Legend – inline (colour + text on same line, items side by side) */
        .legend-container {
            display: flex !important;
            flex-wrap: wrap !important;
            align-items: center !important;
            gap: 4px 15px !important;
            padding: 6px 0 !important;
        }
        .legend-container .legend-item {
            display: inline-flex !important;
            align-items: center !important;
            gap: 4px !important;
            white-space: nowrap !important;
        }
        .legend-container .legend-item i {
            display: inline-block !important;
            margin: 0 !important;
        }
        .legend-container .legend-item b {
            display: inline !important;
            font-weight: 600 !important;
            font-size: 13px !important;
        }

        /* Week header – keep button left and label next to it */
        .week-header-row {
            gap: 8px !important;
        }
        .week-header-row .week-label {
            font-size: 13px !important;
        }
        .week-header-row .btn {
            font-size: 12px !important;
            padding: 3px 10px !important;
        }

        /* Modal – full width on mobile */
        .modal-dialog.modal-xl {
            max-width: 95% !important;
            margin: 1.75rem auto !important;
        }

        .modal-body {
            padding: 10px !important;
        }

        /* Modal buttons – inline */
        .modal-body .row.text-center .col-md-12 {
            display: flex !important;
            flex-wrap: wrap !important;
            justify-content: center !important;
            gap: 6px !important;
        }

        .modal-body .row.text-center .col-md-12 .btn {
            width: auto !important;
            margin: 2px !important;
            padding: 6px 12px !important;
            font-size: 14px !important;
            white-space: nowrap !important;
        }

        /* Heading */
        h5 {
            font-size: 20px !important;
        }

        /* Textarea – adjust for mobile */
        textarea.form-control {
            height: auto !important;
            min-height: 80px !important;
        }
    }
</style>

<div class="main-content">
    {{ Breadcrumbs::render('coordinator_allocation.index') }}
    @if (session('success'))
    <input type="hidden" name="session_data" id="session_data" class="session_data" value="{{ session('success') }}">
    <script type="text/javascript">
        window.onload = function() {
            var message = $('#session_data').val();
            Swal.fire('Success!', message, 'success');
        }
    </script>
    @elseif(session('fail'))
    <input type="hidden" name="session_data" id="session_data1" class="session_data" value="{{ session('fail') }}">
    <script type="text/javascript">
        window.onload = function() {
            var message = $('#session_data1').val();
            Swal.fire('Info!', message, 'info');
        }
    </script>
    @endif
    <div class="row">
        <div class="col-12">

            <div class="card">
                <div class="card-body">
                    <h5 class="text-center" style="color:darkblue">IS-Coordinator Reallocation </h5>
                    <div class="col-md-12" style="display: flex;justify-content: center;">
                        <div class="form-group">
                            <div class="input-container">
                                <input type='month' class="form-control custom-month-input col-md-4" id='month' name="month" title="Monthly Allocation" value="{{$rows[0]['month']}}"><br>
                                <select id="weekDropdown" class="form-control weekDropdown col-md-8" name="weekDropdown">
                                    <option value="" disabled selected>Select a week</option>
                                </select>
                                <input type="hidden" name="" id="week_hidden" value="{{$rows[0]['week']}}">
                            </div>
                        </div>
                    </div>
                    <input type="hidden" name="" id="cor1_hidden" class="cordinator cor1" value="{{$rows[0]['is_coordinator1']}}">
                    <input type="hidden" name="" id="cor2_hidden" class="cordinator cor2" value="{{$rows[0]['is_coordinator2']}}">

                    <div id="weekDetails" class="week-details">
                        <!-- Week details will be displayed here -->
                    </div>

                    <div class="row">
                        <div class="col-lg-12">
                            <div class="legend-container">
                                <span class="legend-item">
                                    <i class="fa fa-circle orange-text" aria-hidden="true"></i>
                                    <b>- less than and equal to 2,</b>
                                </span>
                                <span class="legend-item">
                                    <i class="fa fa-circle green-text" aria-hidden="true"></i>
                                    <b>- greater than 2 and less than equal to 4,</b>
                                </span>
                                <span class="legend-item">
                                    <i class="fa fa-circle red-text" aria-hidden="true"></i>
                                    <b>- greater than 4.</b>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade modalreset" id="addModal">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <form method="POST" action="{{ route('coordinator.reallocation') }}" id="update_form" enctype="multipart/form-data">
                <div class="main-contents">
                    <section class="section">
                        <div class="modal-header bg-primary" style=" background-color: rgb(0 103 172) !important;">
                            <h4 class="modal-title">IS-Coordinator Reallocation</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        </div>
                        <div class="modal-body" style="background-color: #edfcff !important;">
                            <div class="section-body mt-2">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="mt-0 ">
                                            <div class="card-body" id="card_header">
                                                <div class="row">
                                                    <input type="hidden" id="selected_month" name="selected_month">
                                                    <input type="hidden" id="selected_week" name="selected_week">
                                                </div>
                                                <div class="row is-coordinate">
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label class="control-label">Enrollment ID<span class="error-star" style="color:red;">*</span></label>
                                                            <input class="form-control" type="text" id="enrollment_child_num" name="enrollment_child_num" value="{{$rows[0]['enrollment_child_num']}}" required autocomplete="off" readonly>
                                                            <input type="hidden" id="enrollment_id" name="enrollment_id" autocomplete="off" value="{{$rows[0]['enrollment_id']}}" readonly>
                                                        </div>
                                                    </div>
                                                    <input type="hidden" id="user_id" name="user_id">
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label class="control-label">Child ID</label>
                                                            <input class="form-control readonly" type="text" id="child_id" name="child_id" placeholder="Child ID" autocomplete="off" value="{{$rows[0]['child_id']}}" readonly>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label class="control-label">Child Name</label>
                                                            <input class="form-control readonly" type="text" id="child_name" name="child_name" value="{{$rows[0]['child_name']}}" maxlength="20" value="" placeholder="Enter Name" autocomplete="off" readonly>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row" style="display: flex;justify-content: center;">
                                                    <div class="col-md-4">
                                                        <div class="form-group ">
                                                            <label class="control-label">IS Co-ordinator-1<span class="error-star" style="color:red;">*</span></label>
                                                            <div style="display: flex;">
                                                                <input type="hidden" id="coordinator1_id" name="coordinator1_id" autocomplete="off" value="{{$rows[0]['is_coordinator1']}}" readonly>
                                                                <input class="form-control readonly" type="text" id="is_coordinator1" name="is_coordinator1" class="is_coordinator1" value="{{$rows[0]['is_coordinator1_name']}}" autocomplete="off">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="form-group ">
                                                            <label class="control-label">IS Co-ordinator-2<span class="error-star" style="color:red;">*</span></label>
                                                            <div style="display: flex;">
                                                                <input type="hidden" id="coordinator2_id" name="coordinator2_id" autocomplete="off" value="{{$rows[0]['is_coordinator2']}}" readonly>
                                                                <input class="form-control readonly" type="text" id="is_coordinator2" name="is_coordinator2" value="{{$rows[0]['is_coordinator2_name']}}" autocomplete="off">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-lg-12" style="margin: 20px 0px 0px 0px;">
                                                        <div class="form-group">
                                                            <label class="form-label">Special Instruction (if Any)<span class="error-star" style="color:red;">*</span></label>
                                                            <textarea class="form-control" id="description" name="description"></textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row text-center">
                                                    <div class="col-md-12">
                                                        <button class="btn btn-success" type="button" onclick="validateAndAllocate('saved')" id="savebutton"><i class="fa fa-check"></i>Submit</button>&nbsp;
                                                        <a class="btn btn-danger" href=""><i class="fa fa-times" aria-hidden="true"></i> Cancel </a>&nbsp;
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.11.4/js/jquery.dataTables.min.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const monthInput = document.getElementById('month');
        const weekDropdown = document.getElementById('weekDropdown');
        const weekDetails = document.getElementById('weekDetails');
        let selectedMonth = new Date();
        let daysInMonth = 0;

        monthInput.addEventListener('change', function() {
            selectedMonth = new Date(monthInput.value);
            daysInMonth = new Date(selectedMonth.getFullYear(), selectedMonth.getMonth() + 1, 0).getDate();
            generateWeekDropdown();
        });
        // Set the minimum month to the current month and year
        const currentMonth = new Date().toISOString().slice(0, 7);
        monthInput.min = currentMonth;
        weekDropdown.addEventListener('change', function() {
            const selectedWeek = weekDropdown.value;
            const startDate = new Date(selectedMonth.getFullYear(), selectedMonth.getMonth(), (selectedWeek - 1) * 7 + 1);
            const endDate = new Date(selectedMonth.getFullYear(), selectedMonth.getMonth(), Math.min(selectedWeek * 7, daysInMonth));
            const weekLabel = `Week ${selectedWeek}: ${startDate.toLocaleDateString('en-US', { day: 'numeric', month: 'short', year: 'numeric' })} - ${endDate.toLocaleDateString('en-US', { day: 'numeric', month: 'short', year: 'numeric' })}`;
            getWeekTable(weekLabel);
        });

        function generateWeekDropdown() {
            weekDropdown.innerHTML = '<option value="" disabled selected>Select a week</option>';

            const firstDay = new Date(selectedMonth.getFullYear(), selectedMonth.getMonth(), 1);
            const weeksInMonth = Math.min(5, Math.ceil((firstDay.getDay() + daysInMonth) / 7));

            for (let i = 1; i <= weeksInMonth; i++) {
                const startDate = new Date(selectedMonth.getFullYear(), selectedMonth.getMonth(), (i - 1) * 7 + 1);
                const endDate = new Date(selectedMonth.getFullYear(), selectedMonth.getMonth(), Math.min(i * 7, daysInMonth));

                const weekLabel = `Week ${i}: ${startDate.toLocaleDateString('en-US', { month: 'short', day: 'numeric', year: 'numeric' })} - ${endDate.toLocaleDateString('en-US', { month: 'short', day: 'numeric', year: 'numeric' })}`;
                const option = document.createElement('option');
                option.value = i;
                option.textContent = weekLabel;
                weekDropdown.appendChild(option);
            }

            weekDropdown.disabled = false;
        }

        function getWeekTable(weekLabel) {
            // Build the table header with button on the left
            let tableHTML = `
        <div style="max-height: 220px; overflow-y: auto;">
            <table style="width: 100%;">
                <tr>
                    <td colspan="4" style="background: #160b44; color: #ffffff; border: none !important; padding: 8px 10px !important;">
                        <div class="week-header-row">
                            <a type="button" id="allocationButton" class="btn btn-success text-white" onclick="validateAndAllocate1('Saved')" name="type" value="Saved">Allocation<i class="fa fa-plus" aria-hidden="true" style="padding-left: 5px;"></i></a>
                            <span class="week-label">${weekLabel}</span>
                        </div>
                    </td>
                </tr>                  
                <tr style="background: #160b44; color: #ffffff;border: 1px solid #ffffff;">
                    <td>IS-Coordinator's Name</td>
                    <td>OVM(InProgress)</td>
                    <td>OVM(Completed)</td>
                    <td>SAIL(InProgress)</td>
                </tr>
    `;

            // Make an AJAX request to fetch IS Coordinator names
            $.ajax({
                url: '/coordinator_allocation',
                type: 'GET',
                data: {
                    _token: '{{ csrf_token() }}',
                    is_ajax: "yes"
                },
                success: function(data) {
                    data.forEach(function(row, index) {
                        let tooltipContent = "";
                        let tooltipContent1 = "";
                        row.sail_inprogress_count.forEach(function(item, index) {
                            tooltipContent += `${index + 1})${item.enrollment_id} (${item.child_name}) - ${item.current_status}\n`;
                        });
                        row.inprogress_count.forEach(function(item, index) {
                            tooltipContent1 += `${index + 1})${item.enrollment_id} (${item.child_name}) - ${item.meeting_status} (${item.Type})\n`;
                        });
                        const dataName = row.name;

                        const checkboxes = document.querySelectorAll('.cordinator');
                        let exist = 0;
                        checkboxes.forEach(function(checkbox) {
                            if (checkbox.value == row.id) {
                                exist = 1;
                            }
                        });

                        var is_checked = exist == 1 ? "checked" : "";
                        const dataCount = is_checked ? (index + 1) : '';

                        tableHTML += `
                    <tr>
                        <td style="font-weight:700;">
                            <div class="form-check checkbox-label">
                                <input ${is_checked}  data-count="${dataCount}" class="form-check-input checkbox_btn" type="checkbox" value="${row.id}" id="checkbox${row.id}" data-name="${dataName}">${row.name}
                            </div>
                        </td>
                        <td style="font-weight:700;">
                            <span data-toggle="tooltip" data-placement="top" id="sail_inprogress${row.id}"  title="${tooltipContent1}"  class="">
                                ${row.inprogress_count.length}
                                <a href="#" class="text-inherit mr-3 fa fa-circle ${getRowColorClass(row.inprogress_count.length)}"></a>
                            </span>
                        </td>
                        <td style="font-weight:700;">${row.ovm2_completion_count}</td>
                        <td style="font-weight:700;">
                            <span data-toggle="tooltip" data-placement="top" id="sail_inprogress${row.id}"  title="${tooltipContent}"  class="">
                                ${row.sail_inprogress_count.length}
                                <a href="#" class="text-inherit mr-3 fa fa-circle ${getRowColorClass(row.sail_inprogress_count.length)}"></a>
                            </span>
                        </td>
                    </tr>
                `;
                    });

                    tableHTML += '</table></div>';
                    weekDetails.innerHTML = tableHTML;

                    // Legend – already present outside; no need to append again
                },
                error: function(error) {
                    console.error('Error fetching IS Coordinator names: ' + error);
                }
            });
        }

        function triggerChange() {
            const event = new Event('change', {
                bubbles: true,
                cancelable: true
            });
            monthInput.dispatchEvent(event);
        }

        function triggerChange2() {
            const event2 = new Event('change', {
                bubbles: true,
                cancelable: true
            });
            weekDropdown.dispatchEvent(event2);
        }
        triggerChange();
        $('#weekDropdown').val($('#week_hidden').val());
        triggerChange2();
    });

    let counter = 3;
    // Event listener for checkbox changes
    document.addEventListener('click', function(e) {
        if (e.target.classList.contains('checkbox_btn')) {
            const coordinatorId = e.target.value;
            const coordinatorName = e.target.getAttribute('data-name');
            const selectedMonth = document.getElementById('month').value;
            const selectedWeek = document.getElementById('weekDropdown').value;
            if (e.target.checked) {
                const checkboxes = document.querySelectorAll('.form-check-input:checked');
                if (checkboxes.length > 2) {
                    swal.fire("You need to remove one IS-Coordinator for a allocation", "", "error");
                    e.target.checked = false;
                    return false;
                }
                e.target.setAttribute('data-count', counter++);
                if (document.getElementById('is_coordinator1').value == "") {
                    document.querySelector('#is_coordinator1').value = coordinatorName;
                    document.getElementById('coordinator1_id').value = coordinatorId;
                    document.getElementById('selected_month').value = selectedMonth;
                    document.getElementById('selected_week').value = selectedWeek;
                } else if (document.getElementById('is_coordinator2').value == "") {
                    document.querySelector('#is_coordinator2').value = coordinatorName;
                    document.getElementById('coordinator2_id').value = coordinatorId;
                    document.getElementById('selected_month').value = selectedMonth;
                    document.getElementById('selected_week').value = selectedWeek;
                }
            } else {
                if (document.getElementById('is_coordinator1').value == e.target.getAttribute('data-name')) {
                    document.getElementById('is_coordinator1').value = '';
                    document.getElementById('selected_month').value = '';
                    document.getElementById('selected_week').value = '';
                    counter = 1;
                } else if (document.getElementById('is_coordinator2').value == e.target.getAttribute('data-name')) {
                    document.getElementById('is_coordinator2').value = '';
                    document.getElementById('selected_month').value = '';
                    document.getElementById('selected_week').value = '';
                    counter = 1;
                }
                e.target.removeAttribute('data-count');
            }
        }
    });

    // Allocation button click event (to open modal)
    document.addEventListener('click', function(e) {
        if (e.target.closest('#allocationButton')) {
            const isCoordinator1 = document.getElementById('is_coordinator1').value;
            const isCoordinator2 = document.getElementById('is_coordinator2').value;
            if (isCoordinator1 !== "" && isCoordinator2 !== "") {
                $('#addModal').modal('show');
            } else {
                swal.fire("Please select at least two IS-Coordinators", "", "info");
            }
        }
    });

    function getRowColorClass(count) {
        if (count <= 2) return 'orange-text';
        else if (count > 2 && count <= 4) return 'green-text';
        else return 'red-text';
    }

    function validateAndAllocate1(allocationType) {
        const checkboxes = document.querySelectorAll('.form-check-input:checked');
        if (checkboxes.length === 0) {
            swal.fire("You can Only Select 2 IS-Coordinator's for a OVM allocation", "", "error");
            return false;
        }
        const selectedCoordinators = [];
        checkboxes.forEach(checkbox => {
            const coordinatorName = checkbox.textContent.trim();
            selectedCoordinators.push(coordinatorName);
        });
        if (selectedCoordinators.length == 2) {
            $('#addModal').modal('show');
        } else {
            swal.fire("You can Only Select 2 IS-Coordinator's for a OVM allocation", "", "error");
            return false;
        }
    }

    $(document).ready(function() {
        $("input[type='month']").on("change", function() {
            const selectedDate = $(this).val();
            if (selectedDate === "") {
                $(this).css("color", "#aaa");
            } else {
                $(this).css("color", "black");
                $(this).removeAttr("placeholder");
            }
        });
        $("input[type='month']").trigger("change");
    });

    function Childname(event) {
        let value = event.target.value || '';
        value = value.replace(/[^a-z A-Z ]/, '', );
        event.target.value = value;
    }
</script>

<script>
    const monthInput = document.getElementById('month');
    monthInput.addEventListener('keydown', function(event) { event.preventDefault(); });
    monthInput.addEventListener('wheel', function(event) { event.preventDefault(); });
</script>

<script>
    window.onload = function() {
        let url = new URL(window.location.href)
        let message = url.searchParams.get("message6");
        if (message != null) {
            window.history.pushState("object or string", "Title", "/coordinator/list/view");
        }
    };
</script>

<script>
    function showSuccessAlert() {
        Swal.fire({
            title: "Success",
            text: "IS-Coordinator Allocated Successfully",
            icon: "success",
        });
    }

    function validateAndAllocate(allocationType) {
        if (allocationType == "saved") {
            var enrollment_child_num = $("#enrollment_child_num").val();
            var description = $("#description").val();
            if (enrollment_child_num == '') {
                swal.fire("Please Select Enrollment ID", "", "error");
                return false;
            }
            if (description == '') {
                swal.fire("Please Enter the Special Instruction", "", "error");
                return false;
            } else {
                $('#savebutton').prop('disabled', true);
                Swal.fire({
                    title: `Do you want to Reallocate the IS-Coordinator for child of ${$('#child_name').val()}?`,
                    text: "Please click 'Yes' to proceed for the Reallocation",
                    icon: "warning",
                    customClass: 'swalalerttext',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    confirmButtonText: "Yes",
                    cancelButtonText: "No",
                    closeOnConfirm: false,
                    closeOnCancel: true,
                    showLoaderOnConfirm: true,
                    width: '550px',
                }).then((result) => {
                    if (result.value) {
                        document.getElementById('update_form').submit();
                    }
                });
            }
        }
    }

    window.onload = function() {
        let url = new URL(window.location.href);
        let message6 = url.searchParams.get("message6");
        if (message6 != null) {
            window.history.pushState({}, document.title, "/coordinator/list/view");
            showSuccessAlert();
        }
    };
</script>

@endsection