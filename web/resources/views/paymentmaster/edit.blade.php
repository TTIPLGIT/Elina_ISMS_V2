@extends('layouts.adminnav')

@section('content')
<div class="main-content">
    <section class="section">
        {{ Breadcrumbs::render('payment_master.create') }}
        <div class="section-body mt-1">
            <h5 class="text-center" style="color:darkblue">Payment Master Creation</h5>
            <div class="row">
                <div class="col-12">
                    <form action="{{ route('paymentmaster.update') }}" method="POST" id="payment_store">
                        <input type="hidden" id="payment_status" name="payment_status">
                        <input type="hidden" id="id" name="id" value="{{$rows['id']}}">
                        @csrf
                        <div class="card mb-1 mt-1">
                            <div class="card-body">
                                <div class="row is-coordinate">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="required">Category:</label>
                                            <select class="form-control" id="Category" name="Category" onchange="toggleSchoolDropdown()" required>
                                                <option value="">Select-Category</option>
                                                <option value="1" {{ isset($rows['category_id']) && $rows['category_id'] == '1' ? 'selected' : '' }}>General</option>
                                                <option value="2" {{ isset($rows['category_id']) && $rows['category_id'] == '2' ? 'selected' : '' }}>School</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="required">Fees Type</label>
                                            <select class="form-control" id="fees_type" name="fees_type" required>
                                                <option value="">Select- Fees Type</option>
                                                <option value="1" {{ isset($rows['fees_type_id']) && $rows['fees_type_id'] == '1' ? 'selected' : '' }}>Registration</option>
                                                <option value="2" {{ isset($rows['fees_type_id']) && $rows['fees_type_id'] == '2' ? 'selected' : '' }}>SAIL</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-6" id="school_dropdown" style="display:none;">
                                        <div class="form-group">
                                            <label class="required">School</label>
                                            <select class="form-control" id="school" name="school" required>
                                                <option value="">Select-School</option>
                                                @foreach($schoolists as $key => $schoolist)
                                                <option value="{{$schoolist['id']}}" {{ isset($rows['school_enrollment_id']) && $rows['school_enrollment_id'] == $schoolist['id'] ? 'selected' : '' }}>{{ $schoolist['school_name'] }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Service Details Table -->
                        <div class="card mb-1 mt-1">
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="serviceTable">Service Details:</label>
                                    <table class="table" id="serviceTable">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Service Briefing</th>
                                                <th>QTY</th>
                                                <th>Rate (in ₹)</th>
                                                <th>Amount (in ₹)</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <!-- Dynamic rows will be added here -->
                                        </tbody>
                                    </table>
                                    <button type="button" id="addServiceButton" class="btn btn-info">Add Service</button>
                                </div>
                            </div>
                        </div>
                        <div class="card mb-1 mt-1">
                            <div class="card-body">
                                <div class="form-group row" style="display: none;">
                                    <label class="col-sm-4 col-form-label" for="baseAmount">Base Amount (in ₹):</label>
                                    <div class="col-sm-8">
                                        <input class="form-control" type="number" id="baseAmount" name="baseAmount" min="0" step="any" required>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-sm-4 col-form-label" for="adjustedBaseAmount">Base Amount (in ₹):</label>
                                    <div class="col-sm-8">
                                        <input class="form-control" type="number" id="adjustedBaseAmount" name="adjustedBaseAmount" readonly value="{{$rows['base_amount']}}">
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-sm-4 col-form-label" for="gstRate">GST Rate (in %):</label>
                                    <div class="col-sm-8">
                                        <input class="form-control" type="number" id="gstRate" name="gstRate" required min="0" step="any" value="{{$rows['gst_rate']}}">
                                    </div>
                                </div>

                                <div class="form-group" style="display: none;">
                                    <label for="additionalTaxes">Additional Taxes (if any):</label>
                                    <div id="additionalTaxes">
                                        <!-- Tax Groups will be appended here -->
                                    </div>
                                    <button type="button" id="addTaxButton" class="btn btn-info">Add Other Tax</button>
                                </div>

                                <div class="form-group">
                                    <label class="col-form-label required" for="finalAmount">Final Amount (in ₹):</label>
                                    <input class="form-control" type="number" id="finalAmount" name="finalAmount" min="0" step="any" readonly value="{{$rows['final_amount']}}">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-12 text-center">
                                <!-- <button type="button" class="btn btn-warning text-white" onclick="validateForm('Saved')">Save</button> -->
                                <button type="button" class="btn btn-success text-white" onclick="validateForm('Submitted')">Submit</button>
                                <a class="btn btn-labeled back-btn" title="Back" href="{{ route('payment_master.index') }}" style="color:white !important">
                                    <span class="btn-label" style="font-size:13px !important;"><i class="fa fa-arrow-left"></i></span> Back
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
</div>

<script>
    let totalServiceAmount = 0;

    // Function to toggle the school dropdown based on selected category
    function toggleSchoolDropdown() {
        var category = document.getElementById('Category').value;
        var schoolDropdown = document.getElementById('school_dropdown');
        schoolDropdown.style.display = (category == '2') ? 'block' : 'none';
    }

    // Helper function to show alerts
    function showAlert(message, type = 'error') {
        Swal.fire({
            icon: type,
            title: message,
            showConfirmButton: true,
        });
    }

    // Validate the form before submitting
    function validateForm(action) {
        var Category = $('#Category').val();
        if (Category == "") {
            showAlert("Please Select Category");
            return false;
        }

        var school = $('#school').val();
        if (Category == "2" && school == '') {
            showAlert("Please Select School");
            return false;
        }

        var fees_type = $('#fees_type').val();
        if (fees_type == "") {
            showAlert("Please Select Fees Type");
            return false;
        }

        // var baseAmount = $('#baseAmount').val();
        // if (baseAmount == "" || parseFloat(baseAmount) <= 0) {
        //     showAlert("Please Enter a valid Base Amount greater than 0");
        //     return false;
        // }

        var gstRate = $('#gstRate').val();
        if (gstRate == "" || parseFloat(gstRate) < 0) {
            showAlert("Please Enter a valid GST Rate (0 or greater)");
            return false;
        }

        // Check for additional taxes and validate them
        var taxGroups = document.querySelectorAll('.tax-group');
        for (var i = 0; i < taxGroups.length; i++) {
            var taxName = taxGroups[i].querySelector('[name="taxNames[]"]').value;
            var taxPercentage = taxGroups[i].querySelector('[name="additionalTaxes[]"]').value;

            if (taxName == "" || taxPercentage == "" || parseFloat(taxPercentage) < 0) {
                showAlert("Please enter valid Tax Name and Percentage for all additional taxes");
                return false;
            }
        }

        document.getElementById('payment_status').value = action;

        var swalText = (action == 'Saved') ? 'Save' : 'Submit';

        Swal.fire({
            title: "Would you like to " + swalText + " the new Payment details?",
            text: "Please click 'Yes' to confirm the submission",
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
                $(".loader").show();
                document.getElementById('payment_store').submit();
            }
        });
    }

    // Function to calculate the final amount
    // function calculateFinalAmount() {
    //     // Get the base amount entered by the user
    //     let baseAmount = parseFloat(document.getElementById('baseAmount').value) || 0;

    //     // Calculate the total amount from the services (qty * rate for each service)
    //     let amountAfterServices = baseAmount + totalServiceAmount;

    //     // Show the adjusted base amount (base amount + service amount)
    //     document.getElementById('adjustedBaseAmount').value = amountAfterServices.toFixed(2);

    //     // Get the GST rate and calculate GST
    //     let gstRate = parseFloat(document.getElementById('gstRate').value) || 0;
    //     let gstAmount = amountAfterServices * (gstRate / 100);

    //     // Calculate the total additional taxes
    //     let additionalTaxesTotal = 0;
    //     let taxGroups = document.querySelectorAll('.tax-group');
    //     taxGroups.forEach(function(taxGroup) {
    //         let taxPercentage = parseFloat(taxGroup.querySelector('[name="additionalTaxes[]"]').value) || 0;
    //         additionalTaxesTotal += amountAfterServices * (taxPercentage / 100);
    //     });

    //     // Calculate the final amount (adjusted base amount + GST + additional taxes)
    //     let finalAmount = amountAfterServices + gstAmount + additionalTaxesTotal;

    //     // Update the final amount field
    //     document.getElementById('finalAmount').value = finalAmount.toFixed(2);
    // }

    function calculateFinalAmount() {
        // Get the base amount (even if it's hidden)
        let baseAmount = parseFloat(document.getElementById('baseAmount').value) || 0;

        // Recalculate total service amount by summing up each row
        totalServiceAmount = 0;
        document.querySelectorAll('#serviceTable tbody tr').forEach(function(row) {
            const rowAmount = parseFloat(row.querySelector('.amount').value) || 0;
            totalServiceAmount += rowAmount;
        });

        // Calculate the adjusted base amount
        let amountAfterServices = baseAmount + totalServiceAmount;
        document.getElementById('adjustedBaseAmount').value = amountAfterServices.toFixed(2);

        // GST Calculation
        let gstRate = parseFloat(document.getElementById('gstRate').value) || 0;
        let gstAmount = amountAfterServices * (gstRate / 100);

        // Additional taxes
        let additionalTaxesTotal = 0;
        let taxGroups = document.querySelectorAll('.tax-group');
        taxGroups.forEach(function(taxGroup) {
            let taxPercentage = parseFloat(taxGroup.querySelector('[name="additionalTaxes[]"]').value) || 0;
            additionalTaxesTotal += amountAfterServices * (taxPercentage / 100);
        });

        // Final amount
        let finalAmount = amountAfterServices + gstAmount + additionalTaxesTotal;
        document.getElementById('finalAmount').value = finalAmount.toFixed(2);
    }


    // Event listener for changes in Base Amount field
    document.getElementById('baseAmount').addEventListener('input', function() {
        calculateFinalAmount(); // Recalculate final amount when base amount is changed
    });

    // Event listener for changes in GST Rate field
    document.getElementById('gstRate').addEventListener('input', calculateFinalAmount);

    // Dynamically add additional tax input fields
    var taxList = <?php echo json_encode($taxList); ?>;
    document.getElementById('addTaxButton').addEventListener('click', function() {
        const taxGroup = document.createElement('div');
        const taxId = `taxGroup_${Date.now()}`;
        taxGroup.classList.add('tax-group');
        taxGroup.setAttribute('data-id', taxId);

        taxGroup.innerHTML = `
            <div class="form-group row tax-row">
                <div class="col-5">
                    <input class="form-control" type="text" id="taxName_${taxId}" name="taxNames[]" placeholder="Tax Name" required>
                </div>
                <div class="col-5">
                    <input class="form-control" type="number" id="taxPercentage_${taxId}" name="additionalTaxes[]" placeholder="Percentage" required min="0" step="any">
                </div>
                <div class="col-2">
                    <button type="button" class="removeTaxButton btn btn-danger" data-id="${taxId}">Remove</button>
                </div>
            </div>
        `;

        document.getElementById('additionalTaxes').appendChild(taxGroup);

        taxGroup.querySelector('[name="additionalTaxes[]"]').addEventListener('input', calculateFinalAmount);

        taxGroup.querySelector('.removeTaxButton').addEventListener('click', function() {
            taxGroup.remove();
            calculateFinalAmount();
        });

        calculateFinalAmount();
    });

    var serviceList = <?php echo json_encode($serviceList); ?>;

    const options = <?php echo json_encode($serviceMaster); ?>;

    let selectedServices = []; // Track the selected services

    // Handle adding service rows dynamically
    document.getElementById('addServiceButton').addEventListener('click', function() {
        const table = document.getElementById('serviceTable').getElementsByTagName('tbody')[0];
        const rowCount = table.rows.length + 1;

        const row = table.insertRow(rowCount - 1);

        const cell1 = row.insertCell(0);
        const cell2 = row.insertCell(1);
        const cell3 = row.insertCell(2);
        const cell4 = row.insertCell(3);
        const cell5 = row.insertCell(4);
        const cell6 = row.insertCell(5);

        cell1.textContent = rowCount;

        // cell2.innerHTML = `<input class="form-control" type="text" name="serviceBriefing[]" placeholder="Service Briefing" required>`;

        // Create a new dropdown with filtered options
        let optionHtml = '<select class="form-control serviceDropdown" name="serviceBriefing[]" required>';
        optionHtml += '<option value="">Select Service</option>';

        // Filter options to exclude already selected services
        options.forEach(function(option) {
            if (!selectedServices.includes(option.id)) {
                optionHtml += `<option value="${option.id}">${option.service_briefing}</option>`;
            }
        });
        optionHtml += '</select>';

        cell2.innerHTML = optionHtml;
        cell3.innerHTML = `<input class="form-control qty" type="number" name="qty[]" min="0" step="any" required>`;
        cell4.innerHTML = `<input class="form-control rate" type="number" name="rate[]" min="0" step="any" required>`;
        cell5.innerHTML = `<input class="form-control amount" type="number" name="amount[]" readonly>`;
        cell6.innerHTML = `<button type="button" class="btn btn-danger removeServiceButton" onclick="removeRow(this)">Remove</button>`;

        row.querySelector('.qty').addEventListener('input', calculateServiceAmount);
        row.querySelector('.rate').addEventListener('input', calculateServiceAmount);

        // Add event listener for dropdown selection
        const selectElement = row.querySelector('select[name="serviceBriefing[]"]');

        selectElement.addEventListener('change', function() {
            const selectedService = selectElement.value;
            const previousValue = selectElement.dataset.previousValue || '';

            // if (selectedService && !selectedServices.includes(selectedService)) {
            //     selectedServices.push(selectedService); // Add the selected service to the array
            // }

            if (previousValue && selectedServices.includes(previousValue)) {
                selectedServices = selectedServices.filter(service => service !== previousValue);
            }
            if (selectedService && !selectedServices.includes(selectedService)) {
                selectedServices.push(selectedService);
            }

            // Update the previous value for the current row
            selectElement.dataset.previousValue = selectedService;


            rebuildDropdowns(); // Rebuild the dropdowns with updated options
            calculateServiceAmount(); // Recalculate the amount after the selection
        });

        // Call rebuildDropdowns to exclude the selected services from other rows
        rebuildDropdowns();
    });

    // Rebuild all dropdowns to exclude selected services
    function rebuildDropdowns() {
        const serviceDropdowns = document.querySelectorAll('.serviceDropdown');
        serviceDropdowns.forEach(dropdown => {
            const options = dropdown.querySelectorAll('option');
            options.forEach(option => {
                if (selectedServices.includes(option.id)) {
                    option.disabled = true; // Disable already selected services
                } else {
                    option.disabled = false; // Enable unselected services
                }
            });
        });
    }
    // Loop through the serviceList if it's not null and populate the rows
    if (serviceList && serviceList.length > 0) {
        const table = document.getElementById('serviceTable').getElementsByTagName('tbody')[0];

        serviceList.forEach((service, index) => {
            const row = table.insertRow(table.rows.length);

            const cell1 = row.insertCell(0);
            const cell2 = row.insertCell(1);
            const cell3 = row.insertCell(2);
            const cell4 = row.insertCell(3);
            const cell5 = row.insertCell(4);
            const cell6 = row.insertCell(5);

            cell1.textContent = table.rows.length + 1; // Auto-increment row number

            // cell2.innerHTML = `<input class="form-control" type="text" name="serviceBriefing[]" value="${service.service_briefing}" required>`;

            // Create a new dropdown with filtered options
            let optionHtml = '<select class="form-control serviceDropdown" name="serviceBriefing[]" required>';
            optionHtml += '<option value="">Select Service</option>';

            // Filter options to exclude already selected services
            options.forEach(function(option) {
                if (!selectedServices.includes(option.id)) {
                    optionHtml += `<option value="${option.id}" ${option.id === parseInt(service.service_briefing, 10) ? 'selected' : ''}>${option.service_briefing}</option>`;
                }
            });
            optionHtml += '</select>';

            cell2.innerHTML = optionHtml;

            cell3.innerHTML = `<input class="form-control qty" type="number" name="qty[]" value="${service.quantity}" min="0" step="any" required>`;
            cell4.innerHTML = `<input class="form-control rate" type="number" name="rate[]" value="${service.rate}" min="0" step="any" required>`;
            cell5.innerHTML = `<input class="form-control amount" type="number" name="amount[]" value="${service.amount}" readonly>`;
            cell6.innerHTML = `<button type="button" class="btn btn-danger removeServiceButton" onclick="removeRow(this)">Remove</button>`;

            row.querySelector('.qty').addEventListener('input', calculateServiceAmount);
            row.querySelector('.rate').addEventListener('input', calculateServiceAmount);


            // Add event listener for dropdown selection
            const selectElement = row.querySelector('select[name="serviceBriefing[]"]');

            selectElement.addEventListener('change', function() {
                const selectedService = selectElement.value;
                const previousValue = selectElement.dataset.previousValue || '';

                // if (selectedService && !selectedServices.includes(selectedService)) {
                //     selectedServices.push(selectedService); // Add the selected service to the array
                // }

                if (previousValue && selectedServices.includes(previousValue)) {
                    selectedServices = selectedServices.filter(service => service !== previousValue);
                }
                if (selectedService && !selectedServices.includes(selectedService)) {
                    selectedServices.push(selectedService);
                }

                // Update the previous value for the current row
                selectElement.dataset.previousValue = selectedService;


                rebuildDropdowns(); // Rebuild the dropdowns with updated options
                calculateServiceAmount(); // Recalculate the amount after the selection
            });

            // Call rebuildDropdowns to exclude the selected services from other rows
            rebuildDropdowns();
        });
    }


    // Function to calculate the service amounts (qty * rate)
    function calculateServiceAmount(event) {
        const row = event.target.closest('tr');
        const qty = parseFloat(row.querySelector('.qty').value) || 0;
        const rate = parseFloat(row.querySelector('.rate').value) || 0;
        const amount = qty * rate;

        row.querySelector('.amount').value = amount.toFixed(2);

        totalServiceAmount = 0;
        document.querySelectorAll('#serviceTable tbody tr').forEach(function(row) {
            const rowAmount = parseFloat(row.querySelector('.amount').value) || 0;
            totalServiceAmount += rowAmount;
        });

        calculateFinalAmount();
    }

    // Remove service row
    function removeRow(button) {
        const row = button.closest('tr');
        const serviceToRemove = row.querySelector('select[name="serviceBriefing[]"]').value;

        row.remove();

        selectedServices = selectedServices.filter(service => service !== serviceToRemove);

        rebuildDropdowns();
        calculateServiceAmount();
    }

    // Add the first service row when the page loads
    document.addEventListener('DOMContentLoaded', function() {
        // Programmatically trigger the click event to add the first service row
        document.getElementById('addServiceButton').click();
    });
</script>

<style>
    .tax-row {
        display: flex;
        align-items: center;
        margin-bottom: 10px;
    }

    .tax-row input {
        margin-right: 10px;
    }

    .removeTaxButton {
        margin-left: 10px;
    }

    #serviceTable .removeServiceButton {
        margin-left: 10px;
    }

    #serviceTable input {
        margin-right: 10px;
    }
</style>
@endsection