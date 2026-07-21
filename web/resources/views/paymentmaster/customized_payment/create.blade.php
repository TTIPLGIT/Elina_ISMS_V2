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
       SERVICE TABLE – BASE LAYOUT (Desktop)
       ========================================== */
    #serviceTable {
        table-layout: fixed;
        width: 100%;
        font-size: 14px;
    }
    #serviceTable th,
    #serviceTable td {
        padding: 8px 6px;
        vertical-align: middle;
        white-space: nowrap;
    }
    /* Column widths (desktop) */
    #serviceTable th:nth-child(1),
    #serviceTable td:nth-child(1) {
        width: 5%;   /* SI no */
    }
    #serviceTable th:nth-child(2),
    #serviceTable td:nth-child(2) {
        width: 40%;  /* Service Briefing – large enough to show full text */
        white-space: normal;        /* allow wrapping if needed */
        word-break: break-word;
    }
    #serviceTable th:nth-child(3),
    #serviceTable td:nth-child(3) {
        width: 10%;  /* QTY */
    }
    #serviceTable th:nth-child(4),
    #serviceTable td:nth-child(4) {
        width: 15%;  /* Rate */
    }
    #serviceTable th:nth-child(5),
    #serviceTable td:nth-child(5) {
        width: 15%;  /* Amount */
    }
    #serviceTable th:nth-child(6),
    #serviceTable td:nth-child(6) {
        width: 15%;  /* Action */
    }

    /* Make select fill the cell and show full text */
    #serviceTable td:nth-child(2) select {
        width: 100%;
        min-width: 140px; /* ensures enough room for average service names */
        box-sizing: border-box;
    }

    /* ==========================================
       TABLET (769px - 1024px)
       ========================================== */
    @media (min-width: 769px) and (max-width: 1024px) {
        .table-responsive-wrapper {
            overflow-x: auto !important;
            -webkit-overflow-scrolling: touch;
            margin: 0 -5px;
            padding: 0 5px;
        }
        #serviceTable {
            min-width: 100% !important;
        }
        /* Slightly adjust widths for better fit */
        #serviceTable th:nth-child(1),
        #serviceTable td:nth-child(1) {
            width: 4% !important;
        }
        #serviceTable th:nth-child(2),
        #serviceTable td:nth-child(2) {
            width: 42% !important;
        }
        #serviceTable th:nth-child(3),
        #serviceTable td:nth-child(3) {
            width: 10% !important;
        }
        #serviceTable th:nth-child(4),
        #serviceTable td:nth-child(4) {
            width: 15% !important;
        }
        #serviceTable th:nth-child(5),
        #serviceTable td:nth-child(5) {
            width: 15% !important;
        }
        #serviceTable th:nth-child(6),
        #serviceTable td:nth-child(6) {
            width: 14% !important;
        }
        /* Allow text wrapping only for Service Briefing */
        #serviceTable td:nth-child(2) {
            white-space: normal !important;
            word-break: break-word !important;
        }
        /* Other columns stay nowrap */
        #serviceTable td:not(:nth-child(2)) {
            white-space: nowrap !important;
        }
        /* Ensure select fills cell */
        #serviceTable td:nth-child(2) select {
            width: 100%;
            min-width: 120px;
        }
    }

    /* ==========================================
       MOBILE (max-width: 768px)
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

        /* BUTTONS – inline on mobile */
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

        /* SERVICE TABLE – mobile */
        .table-responsive-wrapper {
            overflow-x: auto !important;
            -webkit-overflow-scrolling: touch;
            margin: 0 -5px;
            padding: 0 5px;
        }

        #serviceTable {
            min-width: 700px !important;   /* ensures horizontal scroll */
            table-layout: fixed !important;
            width: 100% !important;
            font-size: 13px !important;
        }

        /* Redistribute widths: reduce SI no, increase Service Briefing */
        #serviceTable th:nth-child(1),
        #serviceTable td:nth-child(1) {
            width: 4% !important;   /* SI no reduced */
        }
        #serviceTable th:nth-child(2),
        #serviceTable td:nth-child(2) {
            width: 48% !important;  /* Service Briefing gets more space */
            white-space: normal !important;
            word-break: break-word !important;
        }
        #serviceTable th:nth-child(3),
        #serviceTable td:nth-child(3) {
            width: 10% !important;
        }
        #serviceTable th:nth-child(4),
        #serviceTable td:nth-child(4) {
            width: 14% !important;
        }
        #serviceTable th:nth-child(5),
        #serviceTable td:nth-child(5) {
            width: 14% !important;
        }
        #serviceTable th:nth-child(6),
        #serviceTable td:nth-child(6) {
            width: 10% !important;  /* Action reduced */
        }

        /* Cell padding and font */
        #serviceTable th,
        #serviceTable td {
            padding: 6px 4px !important;
            white-space: nowrap !important;
        }
        #serviceTable td:nth-child(2) {
            white-space: normal !important; /* allow wrapping for service briefing cell */
        }
        /* Other cells stay nowrap */
        #serviceTable td:not(:nth-child(2)) {
            white-space: nowrap !important;
        }

        /* Form controls inside table */
        #serviceTable .form-control {
            height: 34px !important;
            font-size: 13px !important;
            padding: 2px 4px !important;
            min-width: 50px !important;
        }
        #serviceTable select.form-control {
            min-width: 100px !important;
            width: 100% !important;
        }
        /* Ensure the select in service briefing is wide enough */
        #serviceTable td:nth-child(2) select {
            min-width: 140px !important;
            width: 100% !important;
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
                                    <input type="hidden" id="Category" name="Category" value="1">
                                    <input type="hidden" id="fees_type" name="fees_type" value="1">
                                    <input type="hidden" id="school" name="school" value="">
                                </div>
                            </div>
                        </div>

                        <!-- Service Details Table – now with a responsive wrapper -->
                        <div class="card mb-1 mt-1">
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="serviceTable">Service Details:</label>
                                    <div class="table-responsive-wrapper">
                                        <table class="table" id="serviceTable">
                                            <thead>
                                                <tr>
                                                    <th>SI no</th>
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
                                    </div>
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
    var serviceData = @json($serviceData);
    var usedServices = new Set();
    let totalServiceAmount = 0;

    function showAlert(message, type = 'error') {
        Swal.fire({
            icon: type,
            title: message,
            showConfirmButton: true,
        });
    }

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

        var taxGroups = document.querySelectorAll('.tax-group');
        for (var i = 0; i < taxGroups.length; i++) {
            var taxName = taxGroups[i].querySelector('[name="taxNames[]"]').value;
            var taxPercentage = taxGroups[i].querySelector('[name="additionalTaxes[]"]').value;
            if (taxName == "" || taxPercentage == "" || parseFloat(taxPercentage) < 0) {
                showAlert("Please enter valid Tax Name and Percentage for all additional taxes");
                return false;
            }
        }

        var serviceRows = document.querySelectorAll('#serviceTable tbody tr');
        if (serviceRows.length === 0) {
            showAlert("Please add at least one service");
            return false;
        }

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

    function calculateFinalAmount() {
        let baseAmount = parseFloat(document.getElementById('baseAmount').value) || 0;
        let amountAfterServices = baseAmount + totalServiceAmount;
        document.getElementById('adjustedBaseAmount').value = amountAfterServices.toFixed(2);

        let gstRate = parseFloat(document.getElementById('gstRate').value) || 0;
        let gstAmount = amountAfterServices * (gstRate / 100);

        let additionalTaxesTotal = 0;
        let taxGroups = document.querySelectorAll('.tax-group');
        taxGroups.forEach(function(taxGroup) {
            let taxPercentage = parseFloat(taxGroup.querySelector('[name="additionalTaxes[]"]').value) || 0;
            additionalTaxesTotal += amountAfterServices * (taxPercentage / 100);
        });

        let finalAmount = amountAfterServices + gstAmount + additionalTaxesTotal;
        document.getElementById('finalAmount').value = finalAmount.toFixed(2);
    }

    document.getElementById('gstRate').addEventListener('input', calculateFinalAmount);

    function populateServiceDropdown(selectElement, selectedValue = '') {
        while (selectElement.options.length > 1) {
            selectElement.remove(1);
        }

        if (serviceData && serviceData.length > 0) {
            let availableServices = serviceData.filter(function(service) {
                return !usedServices.has(service.service_briefing) || service.service_briefing === selectedValue;
            });

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

        if (selectElement.options.length === 1) {
            var option = document.createElement('option');
            option.value = '';
            option.textContent = 'No services available';
            option.disabled = true;
            selectElement.appendChild(option);
        }
    }

    function handleServiceChange(selectElement) {
        const row = selectElement.closest('tr');
        const rateInput = row.querySelector('.rate');
        const qtyInput = row.querySelector('.qty');
        const amountInput = row.querySelector('.amount');

        const selectedOption = selectElement.options[selectElement.selectedIndex];
        const rate = parseFloat(selectedOption.getAttribute('data-rate')) || 0;

        rateInput.value = rate;
        rateInput.readOnly = true;
        rateInput.classList.add('gray-bg', 'rate-disabled');

        if (qtyInput.value) {
            const qty = parseFloat(qtyInput.value) || 0;
            amountInput.value = (qty * rate).toFixed(2);
        } else {
            amountInput.value = '0.00';
        }

        calculateServiceAmountForRow(row);
        updateUsedServices();
        updateAllServiceDropdowns();
    }

    function updateUsedServices() {
        usedServices.clear();
        document.querySelectorAll('#serviceTable tbody tr').forEach(function(row) {
            const selectElement = row.querySelector('select[name="serviceBriefing[]"]');
            if (selectElement && selectElement.value && selectElement.value !== '') {
                usedServices.add(selectElement.value);
            }
        });
    }

    function updateAllServiceDropdowns() {
        document.querySelectorAll('#serviceTable tbody tr').forEach(function(row) {
            const selectElement = row.querySelector('select[name="serviceBriefing[]"]');
            const currentValue = selectElement.value;
            populateServiceDropdown(selectElement, currentValue);
        });
    }

    function addNewServiceRow() {
        const table = document.getElementById('serviceTable').getElementsByTagName('tbody')[0];
        const row = table.insertRow(table.rows.length);

        const cell1 = row.insertCell(0);
        const cell2 = row.insertCell(1);
        const cell3 = row.insertCell(2);
        const cell4 = row.insertCell(3);
        const cell5 = row.insertCell(4);
        const cell6 = row.insertCell(5);

        cell2.innerHTML = `<select class="form-control service-select" name="serviceBriefing[]" required>
            <option value="">Select Service</option>
        </select>`;
        cell3.innerHTML = `<input class="form-control qty" type="number" name="qty[]" min="0" step="any" value="" required>`;
        cell4.innerHTML = `<input class="form-control rate gray-bg" type="number" name="rate[]" min="0" step="any" readonly>`;
        cell5.innerHTML = `<input class="form-control amount gray-bg" type="number" name="amount[]" readonly value="0.00">`;
        cell6.innerHTML = `<button type="button" class="btn btn-danger removeServiceButton" onclick="removeRow(this)">Remove</button>`;

        const selectElement = row.querySelector('.service-select');
        populateServiceDropdown(selectElement);
        selectElement.addEventListener('change', function() {
            handleServiceChange(this);
        });
        row.querySelector('.qty').addEventListener('input', function() {
            calculateServiceAmountForRow(row);
        });

        updateServiceSerialNumbers();
    }

    function calculateServiceAmountForRow(row) {
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

    function removeRow(button) {
        const row = button.closest('tr');
        const selectElement = row.querySelector('select[name="serviceBriefing[]"]');
        const selectedService = selectElement ? selectElement.value : '';
        row.remove();

        if (selectedService) {
            usedServices.delete(selectedService);
            updateAllServiceDropdowns();
        }

        totalServiceAmount = 0;
        document.querySelectorAll('#serviceTable tbody tr').forEach(function(row) {
            const rowAmount = parseFloat(row.querySelector('.amount').value) || 0;
            totalServiceAmount += rowAmount;
        });

        updateServiceSerialNumbers();
        calculateFinalAmount();
    }

    document.addEventListener('DOMContentLoaded', function() {
        const table = document.getElementById('serviceTable').getElementsByTagName('tbody')[0];
        table.innerHTML = '';
        addNewServiceRow();
        updateAllServiceDropdowns();
        totalServiceAmount = 0;
        document.getElementById('baseAmount').value = '0';
        document.getElementById('gstRate').value = '0';
        document.getElementById('finalAmount').value = '0';
        document.getElementById('adjustedBaseAmount').value = '0';
        document.getElementById('child_enrollment').value = '';
        usedServices.clear();
    });

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

@endsection