@extends('layouts.adminnav')
@section('content')

<style>
  body {
    font-family: Arial, sans-serif;
  }

  .container {
    width: 80%;
    margin: 0 auto;
  }

  .form-section,
  .option-section {
    margin-bottom: 20px;
  }

  input[type="text"] {
    padding: 10px;
    width: 250px;
    margin-right: 10px;
  }

  button {
    padding: 10px 20px;
    background-color: #007BFF;
    color: white;
    border: none;
    cursor: pointer;
  }

  button:hover {
    background-color: #0056b3;
  }

  .option-section ul {
    list-style-type: none;
    padding: 0;
  }

  .option-section li {
    background-color: #f1f1f1;
    padding: 10px;
    margin: 5px 0;
    display: flex;
    justify-content: space-between;
  }

  .option-section li button {
    background-color: #28a745;
    margin-right: 10px;
  }

  .option-section li button.remove {
    background-color: #dc3545;
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
    background-color: rgba(0, 0, 0, 0.5);
    padding-top: 50px;
  }

  .modal-content {
    background-color: #fff;
    margin: 5% auto;
    /* padding: 20px; */
    border: 1px solid #888;
    width: 300px;
  }

  .modal-header {
    font-size: 18px;
    margin-bottom: 10px;
  }

  .modal-footer {
    text-align: center;
  }

  .modal-footer button {
    margin: 5px;
  }
</style>

<div class="main-content">
  <section class="section">

    {{ Breadcrumbs::render('user.index') }}

    <div class="section-body mt-2">

      <div class="row">
        <div class="row">
          <div class="col-lg-12 text-center">
            <h4 style="color:darkblue;">Service Briefing</h4>
          </div>
        </div>
        <div class="col-12">

          <div class="card">

            <div class="card-body">
              <div class="row">
              </div>
              @if (session('success'))

              <input type="hidden" name="session_data" id="session_data" class="session_data" value="{{ session('success') }}">
              <script type="text/javascript">
                window.onload = function() {
                  var message = $('#session_data').val();
                  swal({
                    title: "Success",
                    text: message,
                    type: "success",
                  });

                }
              </script>
              @elseif(session('error'))

              <input type="hidden" name="session_data" id="session_data1" class="session_data" value="{{ session('error') }}">
              <script type="text/javascript">
                window.onload = function() {
                  var message = $('#session_data1').val();
                  swal({
                    title: "Info",
                    text: message,
                    type: "info",
                  });

                }
              </script>
              @endif

              <div class="">
                <!-- <h1>Service Briefing</h1> -->

                <!-- Form to add new option -->
                <div class="form-section">
                  <label for="newOption">Add a new Service Briefing:</label>
                  <input type="text" id="newOption" placeholder="Enter an option">
                  <button onclick="addOption()">Add</button>
                </div>

                <!-- Display section where the options will reflect -->
                <div class="option-section">
                  <h2>Added Service Briefing:</h2>
                  <ul id="optionList"></ul>
                </div>
              </div>

              <!-- Modal for editing options -->
              <div id="editModal" class="modal">
                <div class="modal-content">
                  <div class="modal-header">
                    <h2>Edit Option</h2>
                  </div>
                  <div class="modal-body">
                    <input type="text" id="editInput" placeholder="Edit the option">
                  </div>
                  <div class="modal-footer">
                    <button onclick="saveEdit()">Save</button>
                    <button onclick="closeModal()">Cancel</button>
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
</div>
<script>
  let editIndex = null; // Store index for editing
  let currentItem = null; // Store the current item to edit

  // Predefined options
  var servicesList = <?php echo json_encode($rows); ?>;
  // const predefinedOptions = servicesList.map(service => service.service_briefing);

  const predefinedOptions = servicesList.map(service => ({
    id: service.id, // Assuming service.id contains the unique ID
    service_briefing: service.service_briefing
  }));

  // console.log(predefinedOptions);

  // Function to load predefined options on page load
  function loadPredefinedOptions() {
    predefinedOptions.forEach(option => {
      // Use the predefined options (service_briefing and id) to add them to the list
      addToOptionListPreDefined(option.service_briefing, option.id);
    });
  }

  // Call the function when the page loads
  window.onload = loadPredefinedOptions;

  // Function to add a new option and reflect it in the list
  function addOption() {
    const option = document.getElementById('newOption').value.trim();
    if (option) {
      if (editIndex === null) {
        // Add new option
        addToOptionList(option);
      } else {
        // Edit existing option
        editOption(option);
        // Reset editIndex after saving to avoid overwriting after next add
        editIndex = null;
      }

      // Clear the input field for new entries
      document.getElementById('newOption').value = '';
    } else {
      alert('Please enter a valid option.');
    }
  }

  // Helper function to add an option to the list
  function addToOptionList(option) {
    // Perform the AJAX request to save the new option to the database
    $.ajax({
      url: "{{ url('/service/briefing/master/store') }}",
      type: 'POST',
      data: {
        'option': option,
        _token: '{{ csrf_token() }}' // Ensure CSRF token is included for security
      },
      success: function(data) {
        // Assuming data.id is the newly created option's ID returned by the server
        const list = document.getElementById('optionList');
        const listItem = document.createElement('li');
        listItem.textContent = option;
        listItem.dataset.id = data; // Store the returned ID on the list item

        // Create the Edit button
        const editButton = document.createElement('button');
        editButton.textContent = 'Edit';
        editButton.onclick = () => openEditModal(option, listItem);

        // Create the Remove button
        const removeButton = document.createElement('button');
        removeButton.classList.add('remove');
        removeButton.textContent = 'Remove';
        removeButton.onclick = () => confirmRemoveOption(listItem);

        // Append buttons to list item
        listItem.appendChild(editButton);
        listItem.appendChild(removeButton);

        // Add the list item to the list
        list.appendChild(listItem);

        // Optional: Show success message with SweetAlert2 (or standard alert)
        Swal.fire(
          'Success!',
          'Option added successfully.',
          'success'
        );
      },
      error: function(xhr, status, error) {
        // Handle the error case, show an alert or log the error
        Swal.fire(
          'Error!',
          'Failed to add the option. Please try again later.',
          'error'
        );
        console.error('Error adding option:', error);
      }
    });
  }

  function addToOptionListPreDefined(option, id) {
    const list = document.getElementById('optionList');
    const listItem = document.createElement('li');
    listItem.textContent = option;
    listItem.dataset.id = id; // Use the id from the predefined options

    // Create edit and remove buttons
    const editButton = document.createElement('button');
    editButton.textContent = 'Edit';
    editButton.onclick = () => openEditModal(option, listItem);

    const removeButton = document.createElement('button');
    removeButton.classList.add('remove');
    removeButton.textContent = 'Remove';
    removeButton.onclick = () => confirmRemoveOption(listItem);

    // Append buttons to list item
    listItem.appendChild(editButton);
    listItem.appendChild(removeButton);

    // Add the item to the list
    list.appendChild(listItem);
  }

  // Function to edit an existing option
  function editOption(newOption) {
    const listItems = document.getElementById('optionList').children;
    listItems[editIndex].firstChild.textContent = newOption;
  }

  // Function to open the edit modal
  function openEditModal(option, listItem) {
    document.getElementById('editInput').value = option;
    editIndex = Array.from(listItem.parentNode.children).indexOf(listItem);
    currentItem = listItem;
    document.getElementById('editModal').style.display = 'block';
  }

  // Function to save the edited option
  function saveEdit() {
    const newOption = document.getElementById('editInput').value.trim();

    if (newOption) {
      // Update the option text in the list item
      currentItem.firstChild.textContent = newOption;
      closeModal();

      // After saving the edit, reset editIndex to null to allow future adds
      editIndex = null;

      // Perform the AJAX request to update the option in the backend
      $.ajax({
        url: "{{ url('/service/briefing/master/update') }}",
        type: 'POST',
        data: {
          'option': newOption, // The new option text
          'id': currentItem.dataset.id, // The ID of the option to update
          'action': 'update', // Action indicating an update operation
          _token: '{{ csrf_token() }}' // CSRF token for security
        },
        success: function(data) {
          // On successful update, show success message using SweetAlert2
          Swal.fire(
            'Updated!',
            'Your option has been successfully updated.',
            'success'
          );
        },
        error: function(xhr, status, error) {
          // On error, restore the original option text and show an error message
          currentItem.firstChild.textContent = document.getElementById('editInput').dataset.originalValue;

          Swal.fire(
            'Error!',
            'Failed to update the option. Please try again later.',
            'error'
          );
        }
      });
    } else {
      // If the new option is empty, show a validation alert
      alert('Please enter a valid option.');
    }
  }

  // Function to close the modal
  function closeModal() {
    document.getElementById('editModal').style.display = 'none';
    document.getElementById('editInput').value = '';
  }

  // Function to confirm removal of an option
  function confirmRemoveOption(listItem) {
    const optionId = listItem.getAttribute('data-id'); // Get the ID from the list item
    const optionValue = listItem.firstChild.textContent.trim(); // Get the option's value

    // Use SweetAlert2 for confirmation
    Swal.fire({
      title: 'Are you sure?',
      text: "You won't be able to revert this!",
      icon: 'warning',
      showCancelButton: true,
      confirmButtonText: 'Yes, delete it!',
      cancelButtonText: 'No, cancel!',
      reverseButtons: true
    }).then((result) => {
      if (result.isConfirmed) {
        // Perform the AJAX request to delete the option
        $.ajax({
          url: "{{ url('/service/briefing/master/update') }}", // URL for the request
          type: 'POST', // Use POST request to send data
          data: {
            'option': optionValue, // The value of the option being deleted
            'id': optionId, // The ID of the option being deleted
            'action': 'remove', // Action indicating removal
            _token: '{{ csrf_token() }}' // CSRF token for security
          },
          success: function(data) {
            // If the request is successful, remove the option from the list
            Swal.fire(
              'Deleted!',
              'Your option has been deleted.',
              'success'
            );
            listItem.remove();
          },
          error: function(xhr, status, error) {
            // If there's an error, show a SweetAlert error message
            Swal.fire(
              'Error!',
              'Failed to remove the option. Please try again later.',
              'error'
            );
          }
        });
      } else if (result.dismiss === Swal.DismissReason.cancel) {
        Swal.fire(
          'Cancelled',
          'Your option is safe :)',
          'info'
        );
      }
    });
  }
</script>
@endsection