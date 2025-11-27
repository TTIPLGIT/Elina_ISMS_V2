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
                    <h5 class="text-center" style="color:darkblue">IS-Coordinator Allocation </h5>
                    <div class="col-md-12" style="display: flex;justify-content: center;">
                        <div class="form-group">
                            <div class="input-container">
                                <input type='text' class="form-control custom-month-input col-md-5" id='month' name="month" title="Monthly Allocation" onfocus="clearPlaceholder(event)" onblur="setPlaceholder()" value="Select a month"><br>
                                <!-- <div class="custom-month-placeholder" id="placeholder">Select a Month</div> -->

                                <select id="weekDropdown" class="form-control weekDropdown col-md-8" name="weekDropdown" disabled>
                                    <option value="" disabled selected>Select a week</option>
                                </select>

                                <!-- <div class="arrow-container">
                                    <div class="arrow up" id="prevMonth"><i class="fa fa-caret-up" aria-hidden="true"></i></div>
                                    <div class="arrow down" id="nextMonth"><i class="fa fa-caret-down" aria-hidden="true"></i></div>
                                </div> -->
                            </div>
                        </div>

                    </div>


                    <div id="weekDetails" class="week-details">
                        <!-- Week details will be displayed here -->
                    </div>
                    <div class="table-wrapper">
                        <div class="table-responsive">
                            <table class="table table-bordered" id="alignallocation">





                            </table>
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
            <form method="POST" action="{{ route('coordinator.allocate_store') }}" id="create_form" enctype="multipart/form-data" class="reset">

                <div class="main-contents">

                    <section class="section">
                        <div class="modal-header bg-primary" style=" background-color: rgb(0 103 172) !important;">
                            <h4 class="modal-title">IS-Coordinator Allocation</h4>
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
                                                            <select class="form-control" id="enrollment_child_num" name="enrollment_child_num" onchange="GetChilddetails()">
                                                                <option value="">Select-Enrollment</option>
                                                                @foreach($rows2['enrollment_details'] as $key=>$row)
                                                                <option value="{{$row['enrollment_child_num']}}">{{ $row['enrollment_child_num']}} ( {{$row['child_name']}} )</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <input type="hidden" id="user_id" name="user_id">
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label class="control-label">Child ID</label>
                                                            <input class="form-control readonly" type="text" id="child_id" name="child_id" placeholder="Child ID" autocomplete="off" readonly>
                                                            <input type="hidden" id="enrollment_id" name="enrollment_id" autocomplete="off" readonly>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label class="control-label">Child Name</label>
                                                            <input class="form-control readonly" type="text" id="child_name" name="child_name" oninput="Childname(event)" maxlength="20" value="" placeholder="Enter Name" autocomplete="off" readonly>
                                                        </div>
                                                    </div>

                                                </div>
                                                <div class="row" style="display: flex;justify-content: center;">
                                                    <div class="col-md-4">
                                                        <div class="form-group ">
                                                            <label class="control-label">IS Co-ordinator-1<span class="error-star" style="color:red;">*</span></label>
                                                            <div style="display: flex;">
                                                                <input type="hidden" id="coordinator1_id" name="coordinator1_id" autocomplete="off" readonly>


                                                                <input class="form-control readonly" type="text" id="is_coordinator1" name="is_coordinator1" class="is_coordinator1" value="" autocomplete="off">

                                                            </div>

                                                        </div>
                                                    </div>

                                                    <div class="col-md-4">
                                                        <div class="form-group ">
                                                            <label class="control-label">IS Co-ordinator-2<span class="error-star" style="color:red;">*</span></label>
                                                            <div style="display: flex;">
                                                                <input type="hidden" id="coordinator2_id" name="coordinator2_id" autocomplete="off" readonly>

                                                                <input class="form-control readonly" type="text" id="is_coordinator2" name="is_coordinator2" value="" autocomplete="off">


                                                            </div>

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
    function setPlaceholder() {
        var monthInput = document.getElementById('month');
        if (monthInput.value === '') {
            monthInput.type = 'text';
            monthInput.value = 'Select a month';
        }
    }

    function clearPlaceholder(e) {

        var monthInput = document.getElementById('month');
        if (monthInput.value === 'Select a month') {
            monthInput.value = '';
        }
        monthInput.type = 'month';
    }
</script>
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
            const selectedOption = weekDropdown.options[weekDropdown.selectedIndex];

            if (selectedOption.disabled) {
                Swal.fire({
                    icon: 'error',
                    title: 'Week already passed!',
                    text: 'You cannot select a week that has already passed.',
                });

                weekDropdown.value = '';
                return;
            }

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

            const today = new Date(); // Current date to compare

            for (let i = 1; i <= weeksInMonth; i++) {
                const startDate = new Date(selectedMonth.getFullYear(), selectedMonth.getMonth(), (i - 1) * 7 + 1);
                const endDate = new Date(selectedMonth.getFullYear(), selectedMonth.getMonth(), Math.min(i * 7, daysInMonth));

                const weekLabel = `Week ${i}: ${startDate.toLocaleDateString('en-US', { month: 'short', day: 'numeric', year: 'numeric' })} - ${endDate.toLocaleDateString('en-US', { month: 'short', day: 'numeric', year: 'numeric' })}`;

                const option = document.createElement('option');
                option.value = i;
                option.textContent = weekLabel;

                // Disable if week has already passed
                if (endDate < new Date().setHours(0, 0, 0, 0)) {
                    option.disabled = true;
                    option.style.color = "red";
                    option.title = "This week has already passed";
                }

                weekDropdown.appendChild(option);
            }

            weekDropdown.disabled = false;
        }


        function getWeekTable(weekLabel) {
            // Initialize an empty table
            let tableHTML = `
        <div style="max-height: 220px; overflow-y: auto;">
            <table style="width: 100%;">
                <tr>
                    <td colspan="4" style="background: #160b44; color: #ffffff;">
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
                    <td>OVM(InProgress)</td>
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

                    data.forEach(function(row) {
                        console.log(row);
                        console.log(row.sail_inprogress_count);
                        // Initialize an empty string for the tooltip title
                        let tooltipContent = "";
                        let tooltipContent1 = "";

                        // Loop through the array to construct the tooltip title
                        row.sail_inprogress_count.forEach(function(item, index) {
                            // Add each enrollment record as a separate row without HTML tags
                            tooltipContent += `${index + 1})${item.enrollment_id} (${item.child_name}) - ${item.current_status}\n`;
                        });
                        row.inprogress_count.forEach(function(item, index) {
                            // Add each enrollment record as a separate row without HTML tags
                            tooltipContent1 += `${index + 1})${item.enrollment_id} (${item.child_name}) - ${item.meeting_status} (${item.Type})\n`;
                        });

                        const dataName = row.name;

                        tableHTML += `
                    <tr>
                    
                        <td style="font-weight:700;">
                            <div class="form-check checkbox-label">
                                <input class="form-check-input checkbox_btn" type="checkbox" value="${row.id}" id="checkbox${row.id}" data-name="${dataName}">${row.name}
                            </div>
                        </td>
                        <td style="font-weight:700;">
    <span data-toggle="tooltip" data-placement="top" id="sail_inprogress${row.id}"  title="${tooltipContent1}"  class="">
        ${row.inprogress_count.length}
        <a href="#" class="text-inherit mr-3 fa fa-circle ${getRowColorClass(row.inprogress_count.length)}"></a>
    </span>
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
                    weekDetails.insertAdjacentHTML('beforeend', `
                <div class="row">
                    <div class="col-lg-12">
                        <div>
                            <i class="fa fa-circle orange-text" aria-hidden="true"></i><b>-less than and equal to 2,</b>
                            <i class="fa fa-circle green-text" aria-hidden="true"></i><b>-greater than 2 and less than equal to 4,</b>
                            <i class="fa fa-circle red-text" aria-hidden="true"></i><b>-greater than 4.</b>
                        </div>
                    </div>
                </div>
            `);



                },
                error: function(error) {
                    console.error('Error fetching IS Coordinator names: ' + error);
                }
            });
        }
    });
    let firstSelectedCoordinator = null;
    let secondSelectedCoordinator = null;
    // Function to update the modal with selected coordinators
    // function updateModal() {
    //     const isCoordinatorInput1 = document.getElementById('is_coordinator1');

    //     const isCoordinatorInput2 = document.getElementById('is_coordinator2');


    //     // Update is_coordinator1 and is_coordinator2 inputs based on the selected coordinators
    //     if (firstSelectedCoordinator && secondSelectedCoordinator) {
    //         isCoordinatorInput1.value = firstSelectedCoordinator.getAttribute('data-name');
    //         isCoordinatorInput2.value = secondSelectedCoordinator.getAttribute('data-name');

    //     } else {
    //         isCoordinatorInput1.value = '';
    //         isCoordinatorInput2.value = '';
    //     }
    // }

    // Event listener for checkbox changes
    document.addEventListener('click', function(e) {
        if (e.target.classList.contains('checkbox_btn')) {

            const coordinatorId = e.target.value;
            const coordinatorName = e.target.getAttribute('data-name');
            const selectedMonth = document.getElementById('month').value;
            const selectedWeek = document.getElementById('weekDropdown').value;
            //alert(e.target.getAttribute('value'));
            if (e.target.checked) {
                //alert('checked');
                const checkboxes = document.querySelectorAll('.form-check-input:checked');
                if (checkboxes.length > 2) {
                    // alert('eegeg');
                    swal.fire("You need to remove one IS-Coordinator for a allocation", "", "error");

                    e.target.checked = false;
                    return false;
                }
                if (document.getElementById('is_coordinator1').value == "") {
                    document.querySelector('#is_coordinator1').value = coordinatorName;
                    document.getElementById('coordinator1_id').value = coordinatorId; // Set the coordinator2_id
                    document.getElementById('selected_month').value = selectedMonth;
                    document.getElementById('selected_week').value = selectedWeek;

                } else if (document.getElementById('is_coordinator2').value == "") {
                    document.querySelector('#is_coordinator2').value = coordinatorName;
                    document.getElementById('coordinator2_id').value = coordinatorId;
                    document.getElementById('selected_month').value = selectedMonth;
                    document.getElementById('selected_week').value = selectedWeek;
                }
            } else {
                //alert('not checked');

                if (document.getElementById('is_coordinator1').value == e.target.getAttribute('data-name')) {
                    // alert('in');
                    document.getElementById('is_coordinator1').value = '';
                    document.getElementById('selected_month').value = '';
                    document.getElementById('selected_week').value = '';
                } else if (document.getElementById('is_coordinator2').value == e.target.getAttribute('data-name')) {
                    document.getElementById('is_coordinator2').value = '';
                    document.getElementById('selected_month').value = '';
                    document.getElementById('selected_week').value = '';
                }
            }
        }
    });


    // const label = this.parentElement.querySelector('span'); // Get the span inside the label
    // const coordinatorName = label.textContent.trim(); // Get the coordinator's name
    // const coordinatorId = this.value;


    // if (this.checked) {
    //     // Set the coordinator's name and ID in the is_coordinator1 input and user_id hidden field
    //     document.getElementById('is_coordinator1').value = coordinatorName;
    //     document.getElementById('user_id').value = coordinatorId;
    // } else {
    //     // Clear the is_coordinator1 input and user_id hidden field
    //     document.getElementById('is_coordinator1').value = '';
    //     document.getElementById('user_id').value = '';
    // }

    // // Update the modal when a checkbox is changed
    // updateModal();


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
            swal.fire("Please select at least two IS-Coordinator", "", "error");
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

            // if (isCoordinatorInput1 && isCoordinatorInput2) { // Check if the inputs exist
            //     // Assign names to IS Coordinators in the input fields
            //     isCoordinatorInput1.value = selectedCoordinators[0];
            //     isCoordinatorInput2.value = selectedCoordinators[1];
            // }

            // Disable the checkboxes after selection
            // checkboxes.forEach(checkbox => {
            //     checkbox.disabled = true;
            // });
            // updateModal();
            $('#addModal').modal('show');
        } else {
            swal.fire("Please select at least two IS-Coordinator", "", "error");
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
    function GetChilddetails() {
        var enrollment_child_num = $("select[name='enrollment_child_num']").val();

        if (enrollment_child_num != "") {
            $.ajax({
                url: "{{ url('/userregisterfee/enrollmentlist') }}",
                type: 'POST',
                data: {
                    'enrollment_child_num': enrollment_child_num,
                    _token: '{{csrf_token()}}'
                }
            }).done(function(data) {
                console.log(data);
                if (data != '[]') {
                    var optionsdata = "";
                    document.getElementById('child_id').value = data[0].child_id;
                    document.getElementById('child_name').value = data[0].child_name;
                    document.getElementById('enrollment_id').value = data[0].enrollment_id;
                    document.getElementById('user_id').value = data[0].user_id;
                } else {
                    document.getElementById('child_name');
                    var ddd = '<option value="child_name">Select Enrollment_child_num</option>';
                    var demonew = $('#child_name').html(ddd);
                }
            })
        } else {
            document.getElementById('initiated_by');
            var ddd = '<option value="initiated_by">Select Enrollment_child_num</option>';
            var demonew = $('#initiated_by').html(ddd);
        }
    };
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

            if (enrollment_child_num == '') {
                swal.fire("Please Select Enrollment ID", "", "error");
                return false;
            } else {
                $('#savebutton').prop('disabled', true);
                Swal.fire({
                    title: `Do you want to Allocate the IS-Coordinator for child of ${$('#child_name').val()}?`,
                    text: "Please click 'Yes' to proceed for the Allocation",
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
                        document.getElementById('create_form').submit();
                        // setTimeout(() => {
                        //     // showSuccessAlert();
                        //     // Redirect with a message parameter
                        //     const message6 = "Valuer List Approved Successfully";
                        //     
                        //     location.replace(`/coordinator/list/view/?message6="${message6}"`);
                        // }, 1000);
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