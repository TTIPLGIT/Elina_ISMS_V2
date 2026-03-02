@extends('layouts.adminnav')

@section('content')
<div class="main-content">
    <section class="section">
        {{ Breadcrumbs::render('paymentmaster.customized.create') }}

        <div class="section-body mt-1">
            <h5 class="text-center" style="color:darkblue">Payment Master Creation</h5>
            <div class="row">
                <div class="col-12">
                    <form action="{{ route('paymentmaster.customized.store') }}" method="POST" id="payment_store">
                        <input type="hidden" id="payment_status" name="payment_status">
                        <input type="hidden" id="id" name="id" value="">
                        @csrf
                        <div class="card mb-1 mt-1">
                            <div class="card-body">
                                <div class="row is-coordinate">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="required">Child Name:</label>
                                            <select class="form-control" id="child_enrollment" name="child_enrollment" required>
                                                <option value="">Select Child</option>
                                                @foreach($childDetails as $key => $data)
                                                <option value="{{ $data['enrollment_id'] }}">{{ $data['child_name'] }} ( {{ $data['enrollment_child_num'] }} ) </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <!-- Hidden fields with default empty values -->
                                    <input type="hidden" id="Category" name="Category" value="1">
                                    <input type="hidden" id="fees_type" name="fees_type" value="1">
                                    <input type="hidden" id="school" name="school" value="">
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
                                                <th class="col-1">SI no</th>
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
                                        <input class="form-control" type="number" id="baseAmount" name="baseAmount" min="0" step="any" value="0">
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-sm-4 col-form-label" for="adjustedBaseAmount">Base Amount (in ₹):</label>
                                    <div class="col-sm-8">
                                        <input class="form-control"
                                            type="number"
                                            id="adjustedBaseAmount"
                                            name="adjustedBaseAmount"
                                            readonly
                                            value="0">
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-sm-4 col-form-label" for="gstRate">GST Rate (in %):</label>
                                    <div class="col-sm-8">
                                        <input class="form-control" style="background-color:white!important" type="number" id="gstRate" name="gstRate" required min="0" step="any" value="0">
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
                                    <input class="form-control" type="number" id="finalAmount" name="finalAmount" value="0" min="0" step="any" readonly>
                                </div>
                                
                                <div class="row">
                                    <div class="col-lg-12 text-center">
                                        <button type="button" class="btn btn-success text-white" onclick="validateForm('Submitted')">Submit</button>
                                        <a class="btn btn-labeled back-btn" title="Back" href="{{ route('paymentmaster.customized') }}" style="color:white !important">
                                            <span class="btn-label" style="font-size:13px !important;"><i class="fa fa-arrow-left"></i></span> Back
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
</div>

<script>
    // Initialize variables
    var serviceData = @json($serviceData); // This contains all service names and amounts
    var usedServices = new Set();
    let totalServiceAmount = 0;

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
        var ChildName = $('#child_enrollment').val();
        
        if (ChildName == "") {
            showAlert("Please Select Child Name");
            return false;
        }

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

        // Check if at least one service is added
        var serviceRows = document.querySelectorAll('#serviceTable tbody tr');
        if (serviceRows.length === 0) {
            showAlert("Please add at least one service");
            return false;
        }

        // Validate each service row
        for (var i = 0; i < serviceRows.length; i++) {
            var serviceSelect = serviceRows[i].querySelector('select[name="serviceBriefing[]"]');
            var qty = serviceRows[i].querySelector('input[name="qty[]"]');
            var rate = serviceRows[i].querySelector('input[name="rate[]"]');

            if (!serviceSelect || serviceSelect.value === "") {
                showAlert("Please select a service for all rows");
                return false;
            }

            if (qty.value === "" || parseFloat(qty.value) <= 0) {
                showAlert("Please enter a valid quantity greater than 0 for all services");
                return false;
            }

            if (rate.value === "" || parseFloat(rate.value) < 0) {
                showAlert("Please enter a valid rate for all services");
                return false;
            }
        }

        document.getElementById('payment_status').value = action;

        Swal.fire({
            title: "Would you like to Submit the new Payment details?",
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
    function calculateFinalAmount() {
        // Get the base amount entered by the user
        let baseAmount = parseFloat(document.getElementById('baseAmount').value) || 0;

        // Calculate the total amount from the services (qty * rate for each service)
        let amountAfterServices = baseAmount + totalServiceAmount;

        // Show the adjusted base amount (base amount + service amount)
        document.getElementById('adjustedBaseAmount').value = amountAfterServices.toFixed(2);

        // Get the GST rate and calculate GST
        let gstRate = parseFloat(document.getElementById('gstRate').value) || 0;
        let gstAmount = amountAfterServices * (gstRate / 100);

        // Calculate the total additional taxes
        let additionalTaxesTotal = 0;
        let taxGroups = document.querySelectorAll('.tax-group');
        taxGroups.forEach(function(taxGroup) {
            let taxPercentage = parseFloat(taxGroup.querySelector('[name="additionalTaxes[]"]').value) || 0;
            additionalTaxesTotal += amountAfterServices * (taxPercentage / 100);
        });

        // Calculate the final amount (adjusted base amount + GST + additional taxes)
        let finalAmount = amountAfterServices + gstAmount + additionalTaxesTotal;

        // Update the final amount field
        document.getElementById('finalAmount').value = finalAmount.toFixed(2);
    }

    // Event listener for changes in GST Rate field
    document.getElementById('gstRate').addEventListener('input', calculateFinalAmount);

    // Function to populate dropdown with available services
    function populateServiceDropdown(selectElement, selectedValue = '') {
        // Clear existing options except the first one
        while (selectElement.options.length > 1) {
            selectElement.remove(1);
        }

        // Add available services
        if (serviceData && serviceData.length > 0) {
            // Filter out already used services
            let availableServices = serviceData.filter(function(service) {
                return !usedServices.has(service.service_briefing) || service.service_briefing === selectedValue;
            });

            // Add filtered services to dropdown
            availableServices.forEach(function(service) {
                var option = document.createElement('option');
                option.value = service.service_briefing;
                option.textContent = service.service_briefing;
                option.setAttribute('data-rate', service.amount || 0);

                if (selectedValue === service.service_briefing) {
                    option.selected = true;
                }

                selectElement.appendChild(option);
            });
        }

        // If no services available, add a disabled option
        if (selectElement.options.length === 1) {
            var option = document.createElement('option');
            option.value = '';
            option.textContent = 'No services available';
            option.disabled = true;
            selectElement.appendChild(option);
        }
    }

    // Function to handle service selection change
    function handleServiceChange(selectElement) {
        const row = selectElement.closest('tr');
        const rateInput = row.querySelector('.rate');
        const qtyInput = row.querySelector('.qty');
        const amountInput = row.querySelector('.amount');

        // Get the selected service
        const selectedOption = selectElement.options[selectElement.selectedIndex];
        const rate = parseFloat(selectedOption.getAttribute('data-rate')) || 0;

        // Auto-fill the rate
        rateInput.value = rate;
        rateInput.readOnly = true;
        rateInput.classList.add('gray-bg', 'rate-disabled');

        // If quantity is already entered, calculate amount
        if (qtyInput.value) {
            const qty = parseFloat(qtyInput.value) || 0;
            amountInput.value = (qty * rate).toFixed(2);
        } else {
            // If no quantity, set amount to 0
            amountInput.value = '0.00';
        }

        // Calculate service amount for this row
        calculateServiceAmountForRow(row);

        // Update used services
        updateUsedServices();

        // Update dropdowns in all rows
        updateAllServiceDropdowns();
    }

    // Update used services set
    function updateUsedServices() {
        usedServices.clear();

        document.querySelectorAll('#serviceTable tbody tr').forEach(function(row) {
            const selectElement = row.querySelector('select[name="serviceBriefing[]"]');
            if (selectElement && selectElement.value && selectElement.value !== '') {
                usedServices.add(selectElement.value);
            }
        });
    }

    // Update all service dropdowns
    function updateAllServiceDropdowns() {
        document.querySelectorAll('#serviceTable tbody tr').forEach(function(row) {
            const selectElement = row.querySelector('select[name="serviceBriefing[]"]');
            const currentValue = selectElement.value;
            populateServiceDropdown(selectElement, currentValue);
        });
    }

    // Function to add a new service row
    function addNewServiceRow() {
        const table = document.getElementById('serviceTable').getElementsByTagName('tbody')[0];
        const row = table.insertRow(table.rows.length);

        const cell1 = row.insertCell(0);
        const cell2 = row.insertCell(1);
        const cell3 = row.insertCell(2);
        const cell4 = row.insertCell(3);
        const cell5 = row.insertCell(4);
        const cell6 = row.insertCell(5);

        // Create dropdown for service briefing
        cell2.innerHTML = `<select class="form-control service-select" name="serviceBriefing[]" required>
            <option value="">Select Service</option>
        </select>`;

        cell3.innerHTML = `<input class="form-control qty" type="number" name="qty[]" min="0" step="any" value="" required>`;
        cell4.innerHTML = `<input class="form-control rate gray-bg" type="number" name="rate[]" min="0" step="any" readonly>`;
        cell5.innerHTML = `<input class="form-control amount gray-bg" type="number" name="amount[]" readonly value="0.00">`;
        cell6.innerHTML = `<button type="button" class="btn btn-danger removeServiceButton" onclick="removeRow(this)">Remove</button>`;

        // Populate the dropdown
        const selectElement = row.querySelector('.service-select');
        populateServiceDropdown(selectElement);

        // Add event listeners
        selectElement.addEventListener('change', function() {
            handleServiceChange(this);
        });

        row.querySelector('.qty').addEventListener('input', function() {
            calculateServiceAmountForRow(row);
        });

        updateServiceSerialNumbers();
    }

    // Function to calculate service amount for a specific row
    function calculateServiceAmountForRow(row) {
        const qty = parseFloat(row.querySelector('.qty').value) || 0;
        const rate = parseFloat(row.querySelector('.rate').value) || 0;
        const amount = qty * rate;

        row.querySelector('.amount').value = amount.toFixed(2);

        // Recalculate total service amount
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
        const selectElement = row.querySelector('select[name="serviceBriefing[]"]');
        const selectedService = selectElement ? selectElement.value : '';

        row.remove();

        // Remove from used services
        if (selectedService) {
            usedServices.delete(selectedService);
            updateAllServiceDropdowns();
        }

        // Recalculate total service amount
        totalServiceAmount = 0;
        document.querySelectorAll('#serviceTable tbody tr').forEach(function(row) {
            const rowAmount = parseFloat(row.querySelector('.amount').value) || 0;
            totalServiceAmount += rowAmount;
        });

        updateServiceSerialNumbers();
        calculateFinalAmount();
    }

    // Initialize the form
    document.addEventListener('DOMContentLoaded', function() {
        // Clear the service table
        const table = document.getElementById('serviceTable').getElementsByTagName('tbody')[0];
        table.innerHTML = ''; // Remove any existing rows
        
        // Add one empty service row
        addNewServiceRow();
        
        // Initialize all dropdowns
        updateAllServiceDropdowns();
        
        // Reset all values
        totalServiceAmount = 0;
        document.getElementById('baseAmount').value = '0';
        document.getElementById('gstRate').value = '0';
        document.getElementById('finalAmount').value = '0';
        document.getElementById('adjustedBaseAmount').value = '0';
        document.getElementById('child_enrollment').value = '';
        
        // Clear any used services
        usedServices.clear();
    });

    // Add service button click handler
    document.getElementById('addServiceButton').addEventListener('click', function() {
        addNewServiceRow();
    });

    function updateServiceSerialNumbers() {
        const rows = document.querySelectorAll('#serviceTable tbody tr');
        rows.forEach((row, index) => {
            row.cells[0].textContent = index + 1;
        });
    }
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

    #serviceTable input,
    #serviceTable select {
        margin-right: 10px;
    }

    #serviceTable input.form-control,
    #serviceTable select.form-control {
        background-color: #ffffff !important;
    }

    #serviceTable input.amount.gray-bg,
    #serviceTable input.rate.gray-bg {
        background-color: #e9ecef !important;
        color: #495057;
        cursor: not-allowed;
    }

    #child_enrollment {
        background-color: #ffffff !important;
    }

    .gray-bg {
        background-color: #f8f9fa !important;
        border-color: #ced4da;
    }

    .rate-disabled {
        background-color: #e9ecef !important;
        cursor: not-allowed;
    }
</style>
 
@endsection