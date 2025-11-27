@extends('layouts.adminnav')
@section('content')

<div class="main-content">
    <section class="section">
        <div class="section-body mt-2">
            <form action="{{route('business.affiliate.update')}}" method="POST" id="schoolRegistrationForm">
                @csrf 

                <div class="card mb-1 mt-1">
                    <div class="card-body">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="schoolName" class="form-label">School Name:</label>
                                <input type="text" id="schoolName" name="schoolName" class="form-control" placeholder="Enter school name" value="{{ $rows[0]['school_name'] ?? '' }}">
                                <div class="text-danger" id="schoolNameError"></div>
                            </div>
                        </div>
                        
                        <input type="hidden" name="program" value="school">
                        <input type="hidden" name="id" value="{{ $rows[0]['id'] }}">

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="schoolType" class="form-label">Type of School:</label>
                                <select id="schoolType" name="schoolType" class="form-control">
                                    <option value="">Select Type of School</option>
                                    <option value="public" {{ isset($rows[0]['school_type']) && $rows[0]['school_type'] == 'public' ? 'selected' : '' }}>Public</option>
                                    <option value="private" {{ isset($rows[0]['school_type']) && $rows[0]['school_type'] == 'private' ? 'selected' : '' }}>Private</option>
                                    <option value="charter" {{ isset($rows[0]['school_type']) && $rows[0]['school_type'] == 'charter' ? 'selected' : '' }}>Charter</option>
                                    <option value="international" {{ isset($rows[0]['school_type']) && $rows[0]['school_type'] == 'international' ? 'selected' : '' }}>International</option>
                                    <option value="other" {{ isset($rows[0]['school_type']) && $rows[0]['school_type'] == 'other' ? 'selected' : '' }}>Other</option>
                                </select>
                                <div class="text-danger" id="schoolTypeError"></div>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="schoolAddress" class="form-label">Address:</label>
                                <textarea id="schoolAddress" name="schoolAddress" class="form-control" placeholder="Enter school address">{{ $rows[0]['school_address'] ?? '' }}</textarea>
                                <div class="text-danger" id="schoolAddressError"></div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="contactName" class="form-label">Contact Person Name:</label>
                                <input type="text" id="contactName" name="contactName" class="form-control" placeholder="Enter contact person name" value="{{ $rows[0]['contact_name'] ?? '' }}">
                                <div class="text-danger" id="contactNameError"></div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="contactPosition" class="form-label">Position/Role:</label>
                                <input type="text" id="contactPosition" name="contactPosition" class="form-control" placeholder="Enter position or role" value="{{ $rows[0]['contact_position'] ?? '' }}">
                                <div class="text-danger" id="contactPositionError"></div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="contactPhone" class="form-label">Phone Number:</label>
                                <input type="tel" id="contactPhone" name="contactPhone" class="form-control" placeholder="Enter phone number" value="{{ $rows[0]['contact_phone'] ?? '' }}">
                                <div class="text-danger" id="contactPhoneError"></div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="contactEmail" class="form-label">Email Address:</label>
                                <input type="email" id="contactEmail" name="contactEmail" class="form-control" placeholder="Enter email address" value="{{ $rows[0]['contact_email'] ?? '' }}">
                                <div class="text-danger" id="contactEmailError"></div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="website" class="form-label">School Website URL:</label>
                                <input type="url" id="website" name="website" class="form-control" placeholder="https://www.example.com" value="{{ $rows[0]['website'] ?? '' }}">
                                <div class="text-danger" id="websiteError"></div>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-success">Register School</button>
                    </div>
                </div>
            </form>
        </div>
    </section>
</div>

<script>
    document.getElementById('schoolRegistrationForm').addEventListener('submit', function(e) {
        let valid = true;
        let firstInvalidField = null;

        // Clear previous error messages
        clearErrors();

        // Validate School Name
        const schoolName = document.getElementById('schoolName');
        if (!schoolName.value.trim()) {
            valid = false;
            document.getElementById('schoolNameError').innerText = "School Name is required.";
            if (!firstInvalidField) firstInvalidField = schoolName;
        }

        // Validate School Type
        const schoolType = document.getElementById('schoolType');
        if (!schoolType.value) {
            valid = false;
            document.getElementById('schoolTypeError').innerText = "Please select a school type.";
            if (!firstInvalidField) firstInvalidField = schoolType;
        }

        // Validate School Address
        const schoolAddress = document.getElementById('schoolAddress');
        if (!schoolAddress.value.trim()) {
            valid = false;
            document.getElementById('schoolAddressError').innerText = "Address is required.";
            if (!firstInvalidField) firstInvalidField = schoolAddress;
        }

        // Validate Contact Person Name
        const contactName = document.getElementById('contactName');
        if (!contactName.value.trim()) {
            valid = false;
            document.getElementById('contactNameError').innerText = "Contact Name is required.";
            if (!firstInvalidField) firstInvalidField = contactName;
        }

        // Validate Contact Position/Role
        const contactPosition = document.getElementById('contactPosition');
        if (!contactPosition.value.trim()) {
            valid = false;
            document.getElementById('contactPositionError').innerText = "Position/Role is required.";
            if (!firstInvalidField) firstInvalidField = contactPosition;
        }

        // Validate Phone Number (123-456-7890 format)
        const contactPhone = document.getElementById('contactPhone');
        const phonePattern = /^\d{3}\d{3}\d{4}$/;
        if (!phonePattern.test(contactPhone.value)) {
            valid = false;
            document.getElementById('contactPhoneError').innerText = "Phone number is required";
            if (!firstInvalidField) firstInvalidField = contactPhone;
        }

        // Validate Email Address
        const contactEmail = document.getElementById('contactEmail');
        const emailPattern = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/;
        if (!emailPattern.test(contactEmail.value)) {
            valid = false;
            document.getElementById('contactEmailError').innerText = "Please enter a valid email address.";
            if (!firstInvalidField) firstInvalidField = contactEmail;
        }

        // Validate Website (optional)
        const website = document.getElementById('website');
        if (website.value && !/^https?:\/\/[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}(\/\S*)?$/.test(website.value)) {
            valid = false;
            document.getElementById('websiteError').innerText = "Please enter a valid URL.";
            if (!firstInvalidField) firstInvalidField = website;
        }

        // If the form is invalid, prevent submission and focus on the first invalid field
        if (!valid) {
            e.preventDefault(); // Prevent form submission

            // Focus and scroll to the first invalid field
            if (firstInvalidField) {
                firstInvalidField.focus();
                firstInvalidField.scrollIntoView({
                    behavior: "smooth",
                    block: "center"
                });
            }
        }
    });

    // Function to clear error messages
    function clearErrors() {
        document.getElementById('schoolNameError').innerText = '';
        document.getElementById('schoolTypeError').innerText = '';
        document.getElementById('schoolAddressError').innerText = '';
        document.getElementById('contactNameError').innerText = '';
        document.getElementById('contactPositionError').innerText = '';
        document.getElementById('contactPhoneError').innerText = '';
        document.getElementById('contactEmailError').innerText = '';
        document.getElementById('websiteError').innerText = '';
    }
</script>

@endsection
