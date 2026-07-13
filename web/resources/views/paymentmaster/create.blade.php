@extends('layouts.adminnav')

@section('content')
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
    .rate-disabled {
        background-color: #e9ecef !important;
        cursor: not-allowed;
    }
    #child_enrollment {
        background-color: #ffffff !important;
    }
    .gray-bg {
        background-color: #f8f9fa !important;
        border-color: #ced4da;
    }
    #child_enrollment:disabled {
        background-color: #e9ecef !important;
        color: black !important;
        opacity: 1 !important;
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

    /* ==========================================
       MOBILE RESPONSIVE – FORM PAGES
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

        /* BUTTONS – INLINE ON MOBILE */
        .row.text-center .col-md-12,
        .row .col-lg-12.text-center {
            display: flex !important;
            flex-wrap: wrap !important;
            justify-content: center !important;
            gap: 6px !important;
        }

        .row.text-center .col-md-12 .btn,
        .row .col-lg-12.text-center .btn {
            width: auto !important;
            margin: 2px !important;
            padding: 6px 12px !important;
            font-size: 14px !important;
            white-space: nowrap !important;
        }

        h5 {
            font-size: 20px !important;
        }

        /* ==========================================
           SERVICE TABLE – IMPROVED FOR MOBILE
           ========================================== */
        .table-responsive-wrapper {
            overflow-x: auto !important;
            -webkit-overflow-scrolling: touch;
            margin: 0 -5px;
            padding: 0 5px;
        }

        #serviceTable {
            min-width: 600px !important;
            width: 100% !important;
            font-size: 13px !important;
        }

        #serviceTable th,
        #serviceTable td {
            padding: 6px 4px !important;
            white-space: nowrap !important;
        }

        #serviceTable .form-control {
            height: 34px !important;
            font-size: 13px !important;
            padding: 2px 4px !important;
            min-width: 50px !important;
        }

        #serviceTable select.form-control {
            min-width: 80px !important;
        }

        #serviceTable .btn {
            font-size: 12px !important;
            padding: 2px 6px !important;
        }

        /* Add Service button – full width on mobile */
        #addServiceButton {
            width: 100% !important;
            margin-top: 8px !important;
        }
    }

    /* ==========================================
       TABLET-ONLY (769px - 1024px) – optimise column widths
       ========================================== */
    @media (min-width: 769px) and (max-width: 1024px) {
        .table-responsive-wrapper {
            overflow-x: auto !important;
            -webkit-overflow-scrolling: touch;
            margin: 0 -5px;
            padding: 0 5px;
        }

        #serviceTable {
            table-layout: fixed !important;   /* enforce column widths */
            width: 100% !important;
            font-size: 13px !important;
            min-width: 100% !important;       /* remove horizontal scroll unless needed */
        }

        /* Assign widths to each column */
        #serviceTable th:nth-child(1),
        #serviceTable td:nth-child(1) {
            width: 5% !important;   /* SI no */
        }
        #serviceTable th:nth-child(2),
        #serviceTable td:nth-child(2) {
            width: 40% !important;  /* Service Briefing – wide enough to wrap */
        }
        #serviceTable th:nth-child(3),
        #serviceTable td:nth-child(3) {
            width: 10% !important;  /* QTY */
        }
        #serviceTable th:nth-child(4),
        #serviceTable td:nth-child(4) {
            width: 15% !important;  /* Rate (reduced) */
        }
        #serviceTable th:nth-child(5),
        #serviceTable td:nth-child(5) {
            width: 15% !important;  /* Amount (reduced) */
        }
        #serviceTable th:nth-child(6),
        #serviceTable td:nth-child(6) {
            width: 15% !important;  /* Action */
        }

        /* Allow Service Briefing to wrap */
        #serviceTable td:nth-child(2),
        #serviceTable th:nth-child(2) {
            white-space: normal !important;
            word-break: break-word !important;
        }

        /* Keep other columns single-line */
        #serviceTable td:not(:nth-child(2)),
        #serviceTable th:not(:nth-child(2)) {
            white-space: nowrap !important;
        }

        /* Ensure inputs and selects fit within their columns */
        #serviceTable .form-control {
            height: 34px !important;
            font-size: 13px !important;
            padding: 2px 4px !important;
            width: 100% !important;
            min-width: unset !important;       /* override mobile min-width */
        }

        #serviceTable select.form-control {
            width: 100% !important;
            min-width: unset !important;
        }

        #serviceTable .btn {
            font-size: 12px !important;
            padding: 2px 6px !important;
        }

        /* Add Service button – normal width on tablet */
        #addServiceButton {
            width: auto !important;
        }
    }
</style>

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
                                                <th class="col-1">SI No</th>
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
            showAlert('All General payment categories already exist. Kindly edit the fees in the Payment Master index!', 'info');
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
        updateSerialNumbers();

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
        updateSerialNumbers();
        // Recalculate final amount after removing the row
        calculateServiceAmount();
    }

    // Initialize first service row on page load
    document.addEventListener('DOMContentLoaded', function() {
        document.getElementById('addServiceButton').click(); // Automatically add the first row
    });

    function updateSerialNumbers() {
        const rows = document.querySelectorAll('#serviceTable tbody tr');
        rows.forEach((row, index) => {
            row.cells[0].textContent = index + 1;
        });
    }
</script>
@endsection