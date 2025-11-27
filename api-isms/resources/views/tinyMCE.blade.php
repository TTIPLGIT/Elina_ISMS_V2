<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Enable/Disable List (Organized Layout)</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            background-color: #f4f7fa;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th,
        td {
            padding: 12px;
            text-align: center;
            border: 1px solid #ccc;
        }

        th {
            background-color: #f1f1f1;
        }

        tr.enabled {
            background-color: #d0f5d0;
        }

        tr.disabled {
            background-color: #f5d0d0;
        }

        .switch {
            position: relative;
            display: inline-block;
            width: 40px;
            height: 20px;
        }

        .switch input {
            opacity: 0;
            width: 0;
            height: 0;
        }

        .slider {
            position: absolute;
            cursor: pointer;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: #ccc;
            transition: 0.4s;
            border-radius: 34px;
        }

        .slider:before {
            position: absolute;
            content: "";
            height: 14px;
            width: 14px;
            left: 3px;
            bottom: 3px;
            background-color: white;
            transition: 0.4s;
            border-radius: 50%;
        }

        input:checked+.slider {
            background-color: #4CAF50;
        }

        input:checked+.slider:before {
            transform: translateX(20px);
        }

        h1 {
            margin-bottom: 20px;
            color: #333;
        }

        /* Updated button styles */
        button#addRecordBtn {
            padding: 12px 24px;
            font-size: 16px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease, transform 0.2s ease;
            box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
        }

        button#addRecordBtn:hover {
            background-color: #45a049;
            transform: translateY(-2px);
        }

        button#addRecordBtn:focus {
            outline: none;
            box-shadow: 0 0 0 4px rgba(72, 202, 123, 0.5);
        }

        /* Modal styles */
        .modal {
            display: none;
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0, 0, 0, 0.4);
            animation: fadeIn 0.4s ease-in-out;
        }

        /* Modal content */
        .modal-content {
            background-color: #fff;
            margin: 5% auto;
            padding: 40px;
            border-radius: 10px;
            width: 50%;
            max-width: 500px;
            box-shadow: 0px 10px 20px rgba(0, 0, 0, 0.1);
            animation: slideIn 0.5s ease-in-out;
        }

        /* Close button */
        .close {
            color: #aaa;
            font-size: 30px;
            font-weight: bold;
            position: absolute;
            top: 10px;
            right: 20px;
            cursor: pointer;
        }

        .close:hover,
        .close:focus {
            color: black;
            text-decoration: none;
        }

        /* Modal form inputs */
        input[type="email"],
        input[type="text"],
        input[type="checkbox"] {
            padding: 10px;
            width: 100%;
            margin: 8px 0;
            border-radius: 5px;
            border: 1px solid #ccc;
            box-sizing: border-box;
        }

        input[type="checkbox"] {
            width: auto;
            margin: 0;
        }

        /* Submit button in the modal */
        button[type="submit"] {
            background-color: #4CAF50;
            color: white;
            border: none;
            padding: 12px 24px;
            font-size: 16px;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        button[type="submit"]:hover {
            background-color: #45a049;
        }

        /* Animations for modal */
        @keyframes fadeIn {
            from {
                opacity: 0;
            }

            to {
                opacity: 1;
            }
        }

        @keyframes slideIn {
            from {
                transform: translateY(-20px);
            }

            to {
                transform: translateY(0);
            }
        }
    </style>

    <!-- Include jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>

<body>
    <h1>Setting : TinyMCE</h1>

    <button id="addRecordBtn">Add New Record</button>

    <table id="myTable">
        <thead>
            <tr>
                <th>Email</th>
                <!-- <th>Last Active (From)</th>
                <th>Last Active (To)</th> -->
                <th>Enable/Disable</th>
            </tr>
        </thead>
        <tbody>
            @foreach($records as $key => $data)
            <tr class="{{ $data->status == 1 ? 'enabled' : 'disabled' }}" data-index="{{ $data->id }}" data-key="{{ $data->editor_key }}">
                <td>{{$data->registered_email}}</td>
                <!-- <td id="timestamp-from-{{$data->status}}" title="{{ 
                $data->last_active_from && !$data->last_active_to ? 'Currently active' : 
                ($data->last_active_from ? '' : 'Not active now') }}">
                    {{ $data->last_active_from ? \Carbon\Carbon::parse($data->last_active_from)->format('d M Y h:i A') : '-' }}
                </td>
                <td id="timestamp-to-{{$data->status}}" title="{{ 
                $data->last_active_to ? '' : 
                ($data->last_active_from && !$data->last_active_to ? 'Currently active' : 'Not active now') }}">
                    {{ $data->last_active_to ? \Carbon\Carbon::parse($data->last_active_to)->format('d M Y h:i A') : '-' }}
                </td> -->
                <td>
                    <label class="switch">
                        <input type="checkbox" {{ $data->status == 1 ? 'checked' : '' }}>
                        <span class="slider"></span>
                    </label>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Modal for adding new record -->
    <div id="myModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <h2>Add New Record</h2>
            <form id="addRecordForm">
                <div>
                    <label for="email">Email:</label>
                    <input type="email" id="email" name="email" required />
                </div>
                <div>
                    <label for="key">Key:</label>
                    <input type="text" id="key" name="key" required />
                </div>
                <div>
                    <label for="Enable">Enable:</label>
                    <input type="checkbox" id="enable" name="enable" />
                </div>
                <button type="submit">Add Record</button>
            </form>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        $(document).ready(function() {
            // Show the modal when 'Add New Record' button is clicked
            $("#addRecordBtn").click(function() {
                $("#myModal").fadeIn();
            });

            // Close the modal when 'x' is clicked
            $(".close").click(function() {
                $("#myModal").fadeOut();
            });

            // Close the modal when clicking outside of it
            $(window).click(function(event) {
                if ($(event.target).is("#myModal")) {
                    $("#myModal").fadeOut();
                }
            });

            // Handle form submission
            $("#addRecordForm").on("submit", function(e) {
                e.preventDefault();

                const email = $("#email").val();
                const key = $("#key").val();
                const enable = $("#enable").is(":checked") ? 1 : 0;

                // Send AJAX request to add the new record
                $.ajax({
                    url: '/api/add-tinymce-record',
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        email: email,
                        key: key,
                        enable: enable
                    },
                    success: function(response) {
                        if (response.status === 'success') {
                            console.log('Record added successfully');

                            // Construct the new row HTML
                            const newRow = `
                        <tr class="${enable === 1 ? 'enabled' : 'disabled'}" data-index="${response.data.id}">
                            <td>${email}</td>
                            <td>
                                <label class="switch">
                                    <input type="checkbox" ${enable === 1 ? 'checked' : ''}>
                                    <span class="slider"></span>
                                </label>
                            </td>
                        </tr>
                    `;

                            // Append the new row to the table
                            $("#myTable tbody").append(newRow);

                            // Close the modal after form submission
                            $("#myModal").fadeOut();
                            Swal.fire({
                                title: 'Success!',
                                text: 'Record added successfully.',
                                icon: 'success',
                                confirmButtonText: 'OK'
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    location.reload(); // reload after user clicks OK
                                }
                            });
                        } else {
                            console.error('Error adding record');
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('AJAX request failed: ' + status + ', ' + error);
                    }
                });
            });

            // Enable/Disable toggle switch functionality
            $('.switch input').on('change', function() {
                const row = $(this).closest('tr');
                const rowId = row.data('index');
                const status = this.checked ? 'enabled' : 'disabled';

                if (this.checked) {
                    $('tr').each(function() {
                        if ($(this).data('index') !== rowId && $(this).hasClass('enabled')) {
                            $(this).find('input').prop('checked', false);
                            $(this).removeClass('enabled').addClass('disabled');
                        }
                    });

                    row.removeClass('disabled').addClass('enabled');
                } else {
                    row.removeClass('enabled').addClass('disabled');
                }

                // Send AJAX request to update the status
                $.ajax({
                    url: '/api/update-tinymce-status',
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        id: rowId,
                        status: status
                    },
                    success: function(response) {
                        if (response.status === 'success') {
                            Swal.fire('Success!', 'Key updated successfully', 'success');
                        } else {
                            Swal.fire('Something went wrong', 'Please contact Admin', 'info');
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('AJAX request failed: ' + status + ', ' + error);
                    }
                });
            });
        });
    </script>

    <script>
        const enabledRows = document.querySelectorAll('tr.enabled[data-key]');

        enabledRows.forEach(row => {
            var editorKey = row.getAttribute('data-key');
        });
    </script>
    <script src="https://cdn.tiny.cloud/1/`${editorKey}`/tinymce/7/tinymce.min.js" referrerpolicy="origin"></script>

    <!-- Place the following <script> and <textarea> tags your HTML's <body> -->
    <script>
        tinymce.init({
            selector: 'textarea',
            plugins: 'anchor autolink charmap codesample emoticons image link lists media searchreplace table visualblocks wordcount',
            toolbar: 'undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | link image media table | align lineheight | numlist bullist indent outdent | emoticons charmap | removeformat',
        });
    </script>

    <textarea> </textarea>

</body>

</html>