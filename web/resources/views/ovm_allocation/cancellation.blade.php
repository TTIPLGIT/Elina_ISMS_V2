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
        /* Ensure the background is transparent */
        background-color: transparent;
        /* padding-right: 30px; */
        /* Add padding for arrow buttons */
        /* Adjust the width to your design */
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
        /* Light grey color for odd rows */
    }

    tr:nth-child(even) {
        background-color: #aaaaaa;
        /* Dark grey color for even rows */
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
                    <h5 class="text-center" style="color:darkblue">IS-Coordinator Cancellation</h5>
                    <div class="col-md-12" style="display: flex;justify-content: center;">
                        <div class="form-group">
                            <div class="input-container">
                                <input type='month' class="form-control custom-month-input col-md-4" id='month' name="month" title="Monthly Allocation" placeholder="Select a month" value="{{$rows[0]['month']}}" readonly><br>
                                <!-- <div class="custom-month-placeholder" id="placeholder">Select a Month</div> -->

                                <select id="weekDropdown" class="form-control weekDropdown col-md-8" name="weekDropdown">
                                    <option value=""  selected>Select a week</option>
                                </select>
                                <input type="hidden" name="week_hidden" id="week_hidden" value="{{$rows[0]['week']}}">

                                <!-- <div class="arrow-container">
                                    <div class="arrow up" id="prevMonth"><i class="fa fa-caret-up" aria-hidden="true"></i></div>
                                    <div class="arrow down" id="nextMonth"><i class="fa fa-caret-down" aria-hidden="true"></i></div>
                                </div> -->
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
                            <div> <i class="fa fa-circle orange-text" aria-hidden="true"></i><b>-less than and equal to 2,</b>
                                <i class="fa fa-circle green-text" aria-hidden="true"></i><b>-greater than 2 and less than equal to 4,</b>
                                <i class="fa fa-circle red-text" aria-hidden="true"></i><b>-greater than 4.</b>
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
            <form method="POST" action="{{ route('coordinator.cancellation_store') }}" id="update_form" enctype="multipart/form-data">

                <div class="main-contents">

                    <section class="section">
                        <div class="modal-header bg-primary" style=" background-color: rgb(0 103 172) !important;">
                            <h4 class="modal-title">IS-Coordinator Cancellation</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        </div>
                        <div class="modal-body" style="background-color: #edfcff !important;">
                            <div class="section-body mt-2">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="mt-0 ">
                                            <div class="card-body" id="card_header">
                                                <div class="row">
                                                    <input type="hidden" id="selected_month" name="selected_month" value="{{$rows[0]['month']}}">
                                                    <input type="hidden" id="selected_week" name="selected_week" value="{{$rows[0]['week']}}">
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
                                                            <label class="form-label">Special Instruction(if Any)<span class="error-star" style="color:red;">*</span></label>
                                                            <textarea class="form-control" id="description" name="description"></textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row text-center">
                                                    <div class="col-md-12">
                                                        <button class="btn btn-success" type="button" onclick="validateAndAllocate('saved')" id="savebutton"><i class="fa fa-check"></i>Submit</button>&nbsp;
                                                        <!-- <button class="btn btn-primary" type="reset" onclick="mycheckfunction()"><i class="fa fa-undo"></i> Undo</button>&nbsp; -->
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
            getWeekTable(weekLabel); // Call the getWeekTable function with the weekLabel
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

            weekDropdown.disabled = true;

        }

        function getWeekTable(weekLabel) {
            // Initialize an empty table
            let tableHTML = `
        <div style="max-height: 220px; overflow-y: auto;">
            <table style="width: 100%;">
                <tr>
                    <td colspan="3" style="background: #160b44; color: #ffffff;">
                        <div class="col-md-12" style="display: flex;align-items: center;">
                            <span class="col-md-10">${weekLabel}</span>
                            <span class="col-md-2">
                                <a type="button" id="allocationButton" class="btn btn-success text-white" onclick="validateAndAllocate1('Saved')" name="type" value="Saved">Allocation<i class="fa fa-plus" aria-hidden="true" style="padding-left: 5px;"></i></a>
                            </span>
                        </div>
                    </td>
                </tr>                  
                <tr style="background: #160b44; color: #ffffff;border: 1px solid #ffffff;">
                    <td>IS-Coordinator's Name</td>
                    <td>OVM(Completed)</td>
                    <td>SAIL(InProgress)</td>
                </tr>
    `;

            // Make an AJAX request to fetch IS Coordinator names
            $.ajax({
                url: '/coordinator_allocation', // Replace with the actual endpoint URL
                type: 'GET',
                data: {
                    _token: '{{ csrf_token() }}',
                    is_ajax: "yes"
                },
                success: function(data) {
                    // Iterate through the retrieved data and add rows to the table

                    data.forEach(function(row, index) {
                        console.log(row.sail_inprogress_count);
                        // Initialize an empty string for the tooltip title
                        let tooltipContent = "";

                        // Loop through the array to construct the tooltip title
                        row.sail_inprogress_count.forEach(function(item, index) {
                            // Add each enrollment record as a separate row without HTML tags
                            tooltipContent += `${index + 1})${item.enrollment_id} (${item.child_name}) - ${item.current_status}\n`;
                        });
                        const dataName = row.name;
                        // const cor1Value = document.getElementById('cor1_hidden').value;
                        // const cor2Value = document.getElementById('cor2_hidden').value;

                        // Get all checkboxes with the class "checkbox_btn"
                        const checkboxes = document.querySelectorAll('.cordinator');

                        // Iterate through checkboxes
                        exist = 0;
                        checkboxes.forEach(function(checkbox) {
                            console.log(checkbox.classList);
                            const id = checkbox.value;

                            if (id == row.id) {
                                exist = 1;
                            }


                        });

                        var is_checked = exist == 1 ? "checked" : "";
                        const dataCount = is_checked ? (index + 1) : ''; // Set data-count to 1 and 2 for checked rows

                        tableHTML += `
                    <tr>
                        <td style="font-weight:700;">
                            <div class="form-check checkbox-label">
                                <input ${is_checked}  data-count="${dataCount}" class="form-check-input checkbox_btn" type="checkbox" value="${row.id}" id="checkbox${row.id}" data-name="${dataName}" disabled>${row.name}
                            </div>
                        </td>
                        <td style="font-weight:700;">${row.ovm2_completion_count}
                        </td>
                        <td style="font-weight:700;">
    <span data-toggle="tooltip" data-placement="top" id="sail_inprogress${row.id}"  title="${tooltipContent}"  class="">
        ${row.sail_inprogress_count.length}
        <a href="#" class="text-inherit mr-3 fa fa-circle ${getRowColorClass(row.sail_inprogress_count.length)}"></a>
    </span>
</td>
                    </tr>
                    
                `;
                    });

                    // Close the table HTML
                    tableHTML += '</table></div>';

                    // Update the weekDetails element with the generated table
                    weekDetails.innerHTML = tableHTML;

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
    let counter = 1;
    // Event listener for checkbox changes
    document.addEventListener('click', function(e) {

        if (e.target.classList.contains('checkbox_btn')) {
            // alert('efefef');
            // alert(e.target.checked);
            const coordinatorId = e.target.value;
            const coordinatorName = e.target.getAttribute('data-name');
            const selectedMonth = document.getElementById('month').value;
            const selectedWeek = document.getElementById('weekDropdown').value;
            if (e.target.checked) {
                // alert('feef');

                if (document.getElementById('is_coordinator1').value == "") {
                    document.querySelector('#is_coordinator1').value = coordinatorName;
                    document.getElementById('coordinator1_id').value = coordinatorId; // Set the coordinator2_id
                    document.getElementById('selected_month').value = selectedMonth;
                    document.getElementById('selected_week').value = selectedWeek;
                    e.target.setAttribute('data-count', counter++);
                } else if (document.getElementById('is_coordinator2').value == "") {
                    document.querySelector('#is_coordinator2').value = coordinatorName;
                    document.getElementById('coordinator2_id').value = coordinatorId;
                    document.getElementById('selected_month').value = selectedMonth;
                    document.getElementById('selected_week').value = selectedWeek;
                    // Add the count as an attribute to the checkbox
                    e.target.setAttribute('data-count', counter++);
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
                // Remove the data-count attribute when unchecked
                e.target.removeAttribute('data-count');
            }
        }
    });





    // Allocation button click event
    const allocationButton = document.getElementById('allocationButton');

    allocationButton.addEventListener('click', function() {
        // Check if at least two coordinators are selected
        const isCoordinator1 = document.getElementById('is_coordinator1').value;
        const isCoordinator2 = document.getElementById('is_coordinator2').value;

        if (isCoordinator1 !== "" && isCoordinator2 !== "") {
            // Show the modal
            $('#addModal').modal('show');
        } else {
           // alert('Please select at least two coordinators for allocation.');
        }
    });


    function getRowColorClass(count) {
        if (count <= 2) {
            return 'orange-text';
        } else if (count > 2 && count <= 4) {
            return 'green-text';
        } else {
            return 'red-text';
        }
    }

    // Find the element with the data-toggle="tooltip" attribute that you want to update
    const elementToUpdate = document.querySelector('#sail_inprogress'); // Replace with the actual ID or selector of your element

    // Check if the element exists
    if (elementToUpdate) {
        // Update the title attribute to change the tooltip content
        elementToUpdate.setAttribute('title', 'New Tooltip Content');

        // Destroy the old Bootstrap Tooltip instance and create a new one with the updated title
        const oldTooltipInstance = bootstrap.Tooltip.getInstance(elementToUpdate);
        if (oldTooltipInstance) {
            oldTooltipInstance.dispose(); // Destroy the old tooltip
        }

        // Create a new Bootstrap Tooltip instance with the updated title
        const newTooltipInstance = new bootstrap.Tooltip(elementToUpdate);

        // Show the updated tooltip
        newTooltipInstance.show();
    }


    function validateAndAllocate1(allocationType) {
        const checkboxes = document.querySelectorAll('.form-check-input:checked');
        console.log(checkboxes);
        // Check if any checkboxes are selected
        if (checkboxes.length === 0) {
            swal.fire("You can Only Select 2 IS-Coordinator's for a OVM allocation", "", "error");
            return false;
        }
        const selectedCoordinators = [];
        // Collect the selected IS-Coordinators' names
        checkboxes.forEach(checkbox => {
            const span = checkbox;

            if (span) {

                const coordinatorName = span.textContent.trim();
                selectedCoordinators.push(coordinatorName);
            }

        });

        const checkedCount = selectedCoordinators.length;

        if (checkedCount == 2) {
            const isCoordinatorInput1 = document.getElementById('is_coordinator1');
            const isCoordinatorInput2 = document.getElementById('is_coordinator2');

            $('#addModal').modal('show');
        } else {
            swal.fire("You can Only Select 2 IS-Coordinator's for a OVM allocation", "", "error");
            return false;
        }
    }

    // Rest of your code
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

        // Trigger initial change event to handle any pre-selected value
        $("input[type='month']").trigger("change");
    });

    function Childname(event) {
        let value = event.target.value || '';
        value = value.replace(/[^a-z A-Z ]/, '', );
        event.target.value = value;

    }
</script>



<!-- <script>
    const myModal = document.querySelectorAll('.modalreset');

    for (const myModals of myModal) {

        myModals.addEventListener('hidden.bs.modal', function() {

            const form = this.querySelector('.reset');

            form.reset();
        });

    }
    $(document).ready(function() {
        $(document).on('hidden.bs.modal', function() {
            // const form = this.querySelector('.reset');

            // form.reset();
            const form_count = document.querySelectorAll('form.reset');
            for (let index = 0; index < form_count.length; index++) {
                $('.reset')[index].reset();

            }

        })

    })
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

        // Trigger initial change event to handle any pre-selected value
        $("input[type='month']").trigger("change");
    });
</script> -->
<script>

</script>



<script>
    const monthInput = document.getElementById('month');

    // Disable keyboard input by capturing the keydown event and preventing default
    monthInput.addEventListener('keydown', function(event) {
        event.preventDefault();
    });

    // Disable mouse wheel events to prevent changing the month with the wheel
    monthInput.addEventListener('wheel', function(event) {
        event.preventDefault();
    });
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
            var description =$("#description").val();
            if (enrollment_child_num == '') {
                swal.fire("Please Select Enrollment ID", "", "error");
                return false;
            } 
            if (description == '') {
                swal.fire("Please Enter the Special Instruction", "", "error");
                return false;
            } 
            else {
                $('#savebutton').prop('disabled', true);
                Swal.fire({
                    title: `Do you want to Cancel the IS-Coordinator for child of ${$('#child_name').val()}?`,
                    text: "Please click 'Yes' to proceed for the Cancellation",
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
                        // Simulating a success response with a delay
                        document.getElementById('update_form').submit();

                    }
                });


            }
        }
        // if (allocationType == "saved") {
        //     Swal.fire({
        //         title: "Do you want to Allocate the IS-Coordinator for the child of Naz Naz?",
        //         text: "Please click 'Yes' to proceed for the Allocation",
        //         icon: "warning",
        //         customClass: 'swalalerttext',
        //         showCancelButton: true,
        //         confirmButtonColor: '#3085d6',
        //         confirmButtonText: "Yes",
        //         cancelButtonText: "No",
        //         closeOnConfirm: false,
        //         closeOnCancel: true,
        //         showLoaderOnConfirm: true,
        //         width: '550px',
        //     }).then((result) => {
        //         if (result.value) {
        //             // Simulating a success response with a delay
        //             setTimeout(() => {
        //                 // showSuccessAlert();
        //                 // Redirect with a message parameter
        //                 const message6 = "Valuer List Approved Successfully";
        //                 location.replace(`/coordinator/list/view/?message6="${message6}"`);
        //             }, 1000);
        //         }
        //     });
        // }
    }

    window.onload = function() {
        let url = new URL(window.location.href);
        let message6 = url.searchParams.get("message6");

        if (message6 != null) {
            // Remove the parameter from the URL after showing the success message
            window.history.pushState({}, document.title, "/coordinator/list/view");
            showSuccessAlert();
        }
    };
</script>


@endsection