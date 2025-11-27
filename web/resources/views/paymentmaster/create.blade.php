@extends('layouts.adminnav')

@section('content')
<div class="main-content">
    <section class="section">
        {{ Breadcrumbs::render('payment_master.create') }}
        <div class="section-body mt-1">
            <h5 class="text-center" style="color:darkblue">Payment Master Creation</h5>
            <div class="row">
                <div class="col-12">
                    <form action="{{ route('paymentmaster.store_data') }}" method="POST" id="payment_store">
                        <input type="hidden" id="payment_status" name="payment_status">
                        @csrf
                        <div class="card mb-1 mt-1">
                            <div class="card-body">
                                <div class="row is-coordinate">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="required">Category:</label>
                                            <select class="form-control" id="Category" name="Category" onchange="toggleSchoolDropdown(this)" required>
                                                <option value="">Select-Category</option>
                                                <option value="1">General</option>
                                                <option value="2">School</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="required">Fees Type</label>
                                            <select class="form-control" id="fees_type" name="fees_type" required>
                                                <option value="">Select- Fees Type</option>
                                                <option value="1">Registration</option>
                                                <option value="2">SAIL</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-6" id="school_dropdown" style="display:none;">
                                        <div class="form-group">
                                            <label class="required">School</label>
                                            <select class="form-control" id="school" name="school" required>
                                                <option value="">Select-School</option>
                                                @foreach($rows as $key => $row)
                                                <option value="{{ $row['id'] }}">{{ $row['school_name'] }}</option>
                                                @endforeach
                                            </select>
                                            @if(count($rows) == 0)
                                            <p style="color: red;">All School payment categories already exist. </br> Kindly edit the fees in the Payment Master index.</p>
                                            @endif
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
                                        <input class="form-control" type="number" id="adjustedBaseAmount" name="adjustedBaseAmount" readonly>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-sm-4 col-form-label" for="gstRate">GST Rate (in %):</label>
                                    <div class="col-sm-8">
                                        <input class="form-control" type="number" id="gstRate" name="gstRate" value="0" required min="0" step="any">
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
                                    <input class="form-control" type="number" id="finalAmount" name="finalAmount" min="0" step="any" readonly>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-12 text-center">
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
    // Function to toggle the school dropdown based on selected category
    function toggleSchoolDropdown(selectElement) {
        var category = selectElement.value;
        var schoolDropdown = document.getElementById('school_dropdown');
        
        if (category === '1') {
            showAlert('All General payment categories already exist. Kindly edit the fees in the Payment Master index!' , 'info');
            selectElement.value = "";
            return false;
        }

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

    const options = <?php echo json_encode($serviceMaster); ?>;

    let selectedServices = []; // Track the selected services

    // Function to handle service addition dynamically
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

        // Add event listeners for new inputs
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

    // Function to calculate service amounts (qty * rate)
    function calculateServiceAmount(event) {
        const row = event ? event.target.closest('tr') : null;
        const qty = parseFloat(row.querySelector('.qty').value) || 0;
        const rate = parseFloat(row.querySelector('.rate').value) || 0;
        const amount = qty * rate;

        row.querySelector('.amount').value = amount.toFixed(2);

        let totalServiceAmount = 0;
        document.querySelectorAll('#serviceTable tbody tr').forEach(function(row) {
            const rowAmount = parseFloat(row.querySelector('.amount').value) || 0;
            totalServiceAmount += rowAmount;
        });

        calculateFinalAmount(totalServiceAmount);
    }

    // Function to calculate the final amount
    function calculateFinalAmount(totalServiceAmount) {
        let baseAmount = parseFloat(document.getElementById('baseAmount').value) || 0;
        let amountAfterServices = baseAmount + totalServiceAmount;

        document.getElementById('adjustedBaseAmount').value = amountAfterServices.toFixed(2);

        let gstRate = parseFloat(document.getElementById('gstRate').value) || 0;
        let gstAmount = amountAfterServices * (gstRate / 100);

        let finalAmount = amountAfterServices + gstAmount;

        document.getElementById('finalAmount').value = finalAmount.toFixed(2);
    }

    // Remove service row
    function removeRow(button) {
        const row = button.closest('tr');
        const serviceToRemove = row.querySelector('select[name="serviceBriefing[]"]').value;

        // Remove the row
        row.remove();

        // Update the selected services array by removing the removed service
        selectedServices = selectedServices.filter(service => service !== serviceToRemove);

        // Rebuild dropdowns with the updated selected services
        rebuildDropdowns();

        // Recalculate final amount after removing the row
        calculateServiceAmount();
    }

    // Initialize first service row on page load
    document.addEventListener('DOMContentLoaded', function() {
        document.getElementById('addServiceButton').click(); // Automatically add the first row
    });
</script>
@endsection