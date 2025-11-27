@extends('layouts.adminnav')

@section('content')
<style>
  #frname {
    color: red;
  }

  .centerid {
    width: 100%;
    text-align: center;
  }

  .paymentdetails {
    color: darkblue;
    padding-top: 1rem;
    margin: auto;
    justify-content: center;
  }

  .payinitiate {
    margin: auto;
  }

  .form-note {
    width: 30%;
    display: flex;
    justify-content: center;
    margin: auto;
  }

  .control-notes {
    display: flex;
    justify-content: center;
    font-weight: 800 !important;
    color: #34395e !important;
    font-size: 15px !important;
  }

  .scroll_flow_class {
    padding: 1rem !important;
    box-shadow: 0 2px 3px 3px rgb(0 0 0 / 14%), 0 1px 5px 0 rgb(0 0 0 / 12%), 0 3px 1px -2px rgb(0 0 0 / 20%);
    -webkit-transition: .5s all ease;
    -moz-transition: .5s all ease;
    transition: .5s all ease;
    overflow-y: scroll;
    height: 150px !important;
  }

  /* #invite{
    display: none;
  } */
</style>

<div class="main-content" style="min-height:'60px'">
  <!-- Main Content -->
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

  <div class="section-body">
    <h5 class="text-center" style="color:darkblue">13+ F2F Observation Notes</h5>

    <form action="" id="userregistration" method="POST">
      @csrf
      <div class="col-12">
        <div class="card-body">
          <div class="row">
            <div class="col-md-4">
              <div class="form-group">
                <label class="control-label">Enrollment Number</label><span class="error-star" style="color:red;">*</span>
                <input class="form-control" type="text" id="enrollment_id" name="enrollment_id" value="EN/2023/12/070(Pavani)" disabled autocomplete="off">
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-group">
                <label class="control-label">Child ID</label><span class="error-star" style="color:red;">*</span>
                <input class="form-control" type="text" id="child_id" name="child_id" autocomplete="off" value="CH/2023/070" readonly>
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-group">
                <label class="control-label">Child Name</label><span class="error-star" style="color:red;">*</span>
                <input class="form-control" type="text" id="child_name" name="child_name" autocomplete="off" value="Pavani" readonly>
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-group">
                <label class="control-label">Category</label><span class="error-star" style="color:red;">*</span>
                <input class="form-control" type="text" id="Category" name="Category" autocomplete="off" value="Parent" readonly>
              </div>
            </div>


          </div>
          <div class="text-center" style="">

            <a href="#addModal2" data-toggle="modal" data-target="#addModal2" data-toggle="modal" title="Add to F2F" class="btn btn-labeled btn-success" data-target="#templates">Add Activity</a>
          </div>
        </div>
      </div>

      <div class="modal fade" id="addModal2">
        <div class="modal-dialog modal-xl" role="document">
          <div class="modal-content">


            <div class="modal-header" style="background-color:DarkSlateBlue;">
              <h5 class="modal-title" id="#addModal">Add Face-to-Face Observation</h5>
            </div>

            <div class="modal-body">
              <form action="" id="add_Question" method="">


                <div class="card question" id="next-section">
                  <div class="row" style="margin-bottom: 15px;margin-top: 20px;">
                    <div class="col-md-4" id="question_field">
                      <div class="form-group questionnaire">
                        <label class="control-label required">Activity Set</label>
                        <select class="form-control default activity-set" name="activity-set" id="activity-set">
                          <option value="">Select Activity Set</option>
                          <option value="1">Activity Set-1[Both]</option>
                          <option value="2">Activity Set-2[Both]</option>
                          <option value="3">Activity Set-3[Both]</option>
                          <option value="4">Activity Set-4[Both]</option>
                          <option value="5">Activity Set-5[Both]</option>
                          <option value="7">Activity Set-6[Both]</option>
                          <option value="8">Activity Set-1[13+]</option>
                          <option value="9">Activity Set-2[13+]</option>
                          <option value="10">Activity Set-3[13+]</option>
                          <option value="11">Activity Set-4[13+]</option>
                        </select>
                      </div>
                    </div>

                    <div class="col-md-7 des_ption" style="display:none;">
                      <div class="form-group questionnaire">
                        <label class="control-label required">Activity Description</label>
                        <select class="form-control default description" name="description" id="description">
                          <option value="">Select Description</option>

                          <option value="1">run, gallop, hop, leap, horizontal jump, slide.</option>
                          <option value="2">striking a stationary ball, stationary dribble, kick, catch, overhand throw,and underhand roll.</option>
                          <option value="3">Shoe lacing activity</option>
                          <option value="4">Colour/paint the given Mandala design (OR) Create own mandala using template.
                          </option>
                          <option value="5">Create a doodle</option>
                          <option value="7">Talking about current events for 1 min.</option>
                          <option value="8">Setting up a dining table.</option>
                          <option value="9">Making a sandwich.</option>
                          <option value="10">Planning for an event that is coming up.</option>
                          <option value="11">Organizing his work station.</option>
                          <option value="12">Decoding a bill of purchase.</option>
                          <option value="13">Folding clothes.</option>
                          <option value="14"></option>
                        </select>
                      </div>
                    </div>
                    <div class="col-md-3 materials_list" style="display:none;">
                      <div class="form-group">
                        <label class="control-label required">Materials Required</label>
                        <select data-placeholder="Select Materials" multiple class="chosen-select materials" name="materials" style="width: 100% !important;">
                          <option value="">Select Materials</option>
                          <option value="Bat">Bat</option>
                          <option value="Ball">Ball</option>
                          <option value="paper">Paper</option>
                          <option value="balloon">Ballon</option>
                          <option value="pen">Pen</option>
                          <option value="pencil">Pencil</option>
                        </select>
                      </div>
                    </div>

                    <div class="col-md-4">
                      <div class="form-group questionnaire">
                        <label class="control-label">To Observe</label>
                        <textarea class="form-control default" name="to_observe" id="to_observe" autocomplete="off"></textarea>
                      </div>
                    </div>
                    <div class="col-md-4">
                      <div class="form-group questionnaire">
                        <label class="control-label">To Ask Parents</label>
                        <textarea class="form-control default" name="ask_parent" id="ask_parent" autocomplete="off"></textarea>
                      </div>
                    </div>
                    <div class="col-md-4" id="">
                      <div class="form-group questionnaire">
                        <label class="control-label">Observation By IS-Head</label>
                        <textarea class="form-control default" name="observe_head" id="observe_head" autocomplete="off"></textarea>
                      </div>
                    </div>
                    <div class="col-md-4" id="">
                      <div class="form-group questionnaire">
                        <label class="control-label">Observation By IS-Coordinator1</label>
                        <textarea class="form-control default" name="observe_c1" id="observe_c1" autocomplete="off" disabled></textarea>
                      </div>
                    </div>
                    <div class="col-md-4" id="">
                      <div class="form-group questionnaire">
                        <label class="control-label">Observation By IS-Coordinator2</label>
                        <textarea class="form-control default" name="observe_c2" id="observe_c2" autocomplete="off" disabled></textarea>
                      </div>
                    </div>

                    <div class="col-md-12" style="display:flex;justify-content: center;">
                      <a type="button" onclick="saveQuestion('Submit')" id="submitbtn" class="btn btn-success" title="Submit Question" style="color:white !important">Submit</a>
                      <a type="button" class="btn btn-labeled back-btn" title="Close" onclick="saveQuestion('Close')" style="color:white !important">Close</a>
                    </div>
                  </div>
                </div>
              </form>

              </section>

            </div>




          </div>
        </div>
      </div>
      <div class="modal fade" id="editModal2">
        <div class="modal-dialog modal-xl" role="document">
          <div class="modal-content">
            <form name="edit_form" action="" method="" id="edit_question_form11">

              <div class="modal-header" style="background-color:DarkSlateBlue;">
                <h5 class="modal-title" id="#addModal">Update Face-to-Face Observation</h5>
              </div>

              <div class="modal-body">
                <form action="" id="edit_Question" method="">


                  <div class="card question" id="next-section">
                    <div class="row" style="margin-bottom: 15px;margin-top: 20px;">
                      <div class="col-md-4" id="question_field">
                        <div class="form-group questionnaire">
                          <label class="control-label required">Activity Set</label>
                          <input class="form-control" type="text" id="activity_set" name="activity_set" value="run, gallop, hop, leap, horizontal jump, slide." autocomplete="off" readonly>

                        </div>
                      </div>

                      <div class="col-md-7 des_ption">
                        <div class="form-group questionnaire">
                          <label class="control-label required">Activity Description</label>
                          <input class="form-control" type="text" id="description_id" name="description_id" value="run, gallop, hop, leap, horizontal jump, slide." autocomplete="off" readonly>

                        </div>
                      </div>
                      <div class="col-md-4 materials_list" style="">
                        <div class="form-group">
                          <label class="control-label required">Materials Required</label>
                          <select data-placeholder="Select Materials" multiple class="chosen-select materials" name="materials" style="width: 100% !important;">
                            <option value="">Select Materials</option>
                            <option value="Bat">Bat</option>
                            <option value="Ball" selected>Ball</option>
                            <option value="paper">Paper</option>
                            <option value="balloon">Ballon</option>
                            <option value="pen" selected>Pen</option>
                            <option value="pencil">Pencil</option>
                          </select>
                        </div>
                      </div>

                      <div class="col-md-4">
                        <div class="form-group questionnaire">
                          <label class="control-label">To Observe</label>
                          <textarea class="form-control default" name="to_observe" id="to_observe" autocomplete="off" value="please help me out"></textarea>
                        </div>
                      </div>
                      <div class="col-md-4">
                        <div class="form-group questionnaire">
                          <label class="control-label">To Ask Parents</label>
                          <textarea class="form-control default" name="ask_parent" id="ask_parent" autocomplete="off"></textarea>
                        </div>
                      </div>
                      <div class="col-md-4" id="">
                        <div class="form-group questionnaire">
                          <label class="control-label">Observation By IS-Head</label>
                          <textarea class="form-control default" name="observe_head" id="observe_head" autocomplete="off"></textarea>
                        </div>
                      </div>
                      <div class="col-md-4" id="">
                        <div class="form-group questionnaire">
                          <label class="control-label">Observation By IS-Coordinator1</label>
                          <textarea class="form-control default" name="observe_c1" id="observe_c1" autocomplete="off" disabled></textarea>
                        </div>
                      </div>
                      <div class="col-md-4" id="">
                        <div class="form-group questionnaire">
                          <label class="control-label">Observation By IS-Coordinator2</label>
                          <textarea class="form-control default" name="observe_c2" id="observe_c2" autocomplete="off" disabled></textarea>
                        </div>
                      </div>

                      <div class="col-md-12" style="display:flex;justify-content: center;">
                        <a type="button" onclick="saveQuestion('Update')" id="submitbtn" class="btn btn-success" title="Submit Question" style="color:white !important">Update</a>
                        <a type="button" class="btn btn-labeled back-btn" title="Close" onclick="saveQuestion('Close1')" style="color:white !important">Close</a>
                      </div>
                    </div>
                  </div>

                  </section>
                </form>
              </div>

            </form>


          </div>
        </div>
      </div>
      <input type="hidden" name="activity_id" value="56">
      <div class="col-12">
        <div class="card-body">
          <div class="table-wrapper">
            <div class="table-responsive">
              <table class="table table-bordered">
                <thead>
                  <tr>
                    <!-- <th>Sl.No</th> -->
                    <th>Activity</th>
                    <th>Description</th>

                    <th>Action</th> <!-- New column for Remove button -->

                  </tr>
                </thead>
                <tbody class="align1b" id="align1b">
                </tbody>

              </table>
            </div>
            <div id="noDataMessage" style="text-align: center;">
              <b>No Data Available</b>
            </div>
          </div>

        </div>
      </div>
      <br>

      <div class="col-md-12  text-center">
        <a type="button" class="btn btn-labeled back-btn" title="Back" href="{{route('activity_allocation13.index')}}" style="color:white !important">
          <span class="btn-label" style="font-size:13px !important;"><i class="fa fa-arrow-left"></i></span> Back</a>
      </div>

    </form>

  </div>
</div>

<script>
  $(document).ready(function() {
    // Handle change event on the Activity Set dropdown
    var descriptionDropdown = $('.description');
    var materialist = document.querySelector('.materials_list');

    $(".activity-set").change(function() {
      var selectedActivitySet = $(this).val();
      var descriptionDropdown = $('.description'); // Change this line
      var materialsDropdown = $('.materials'); // Change this line
      var desption = document.querySelector('.des_ption');
      var materialist = document.querySelector('.materials_list');


      // Show/hide Description and Materials dropdowns based on the selected Activity Set
      if (selectedActivitySet != "") {
        desption.style.display = "block";
        // descriptionDropdown.style.display = "block";

      } else {
        desption.style.display = "none";
        materialist.style.display = "none";
      }
    });
    $(".description").change(function() {
      var descriptionDropdown = $(this).val();
      if (descriptionDropdown != "") {

        materialist.style.display = "block";
        // materialsDropdown.style.display = "block";
      } else {
        materialist.style.display = "none";
        //  materialsDropdown.style.display = "none";
      }


    });




  });

  function des() {
    $('.des_ption').css('display', 'none');
    $('.materials_list').css('display', 'none');

    // // Destroy and reinitialize Select2
    // // $('.description').select2('destroy').select2();
    // $('.materials').select2('destroy').select2();
  }


  // After dynamically adding rows to the table
  function updateTableVisibility() {
    if ($('#align1b tr').length === 0) {
      $('#noDataMessage').show();
    } else {
      $('#noDataMessage').hide();
    }
  }


  // Function to save question and close modal
  function saveQuestion(action) {
    // Your existing code to save question
    if (action == "Close") {
      // Clear the form fields
      $('#activity-set').val("");
      $('#description').val("");
      $('.chosen-select').val("");
      $('#to_observe').val("");
      $('#ask_parent').val("");
      $('#observe_head').val("");

      // Close the modal after clearing the form
      $('#addModal2').modal('hide');
      des();
    } else if (action == "Submit") {
      // Get the form data
      // var activitySet = $('#activity-set').val();
      var activitySetName = $('#activity-set option:selected').text(); // Get the selected option's text
      var description = $('#description option:selected').text(); // Get the selected option's text

      // var description = $('#description').val();

      // Add the data to the table
      var newRow = "<tr>" +
        "<td>" + activitySetName + "</td>" +
        "<td>" + description + "</td>" +
        "<td><button onclick='editRow(this)' class='btn btn-warning'>Edit</button> <button onclick='removeRow(this)' class='btn btn-danger'>Remove</button></td>" +
        "</tr>";

      // Show confirmation dialog
      Swal.fire({
        title: 'Are you sure?',
        text: 'Do you want to add this to the Face to Face?',
        icon: 'question',
        showCancelButton: true,
        confirmButtonText: 'Yes',
        cancelButtonText: 'No',
      }).then((result) => {
        if (result.isConfirmed) {
          // Append the new row to the table body
          $('#align1b').append(newRow);

          // Clear the form fields
          $('#activity-set').val("");
          $('.description').val("");
          $('.chosen-select').val("");
          $('#to_observe').val("");
          $('#ask_parent').val("");
          $('#observe_head').val("");

          // Close the modal
          $('#addModal2').modal('hide');

          // Update table visibility after dynamically adding rows
          updateTableVisibility();
          des();
        }
      });


    } else if (action == "Update") {
      // Show confirmation dialog
      Swal.fire({
        title: 'Are you sure?',
        text: 'Do you want to add this to the Face to Face?',
        icon: 'question',
        showCancelButton: true,
        confirmButtonText: 'Yes',
        cancelButtonText: 'No',
      }).then((result) => {
        if (result.isConfirmed) {
          Swal.fire('Success!', 'F2F Observation Updated Successfully', 'success');
          $('#editModal2').modal('hide');

        }
      })

    }
    if (action == "Close1") {
      // Close the modal after clearing the form
      $('#editModal2').modal('hide');


    }
  }
  // Function to edit a row in the table
  function editRow(button) {
    $('.des_ption').css('display', 'block');
    $('.materials_list').css('display', 'block');
    // Get the current row
    var row = $(button).closest('tr');

    // Extract data from the row
    var activitySet = row.find('td:eq(0)').text();
    var description = row.find('td:eq(1)').text();

    // Populate the form fields in the modal with the extracted data
    $('#activity-set').val(activitySet);
    $('#description').val(description);

    // Remove the edited row from the table
    //row.remove();

    // Update table visibility
    updateTableVisibility();

    // Show the modal for editing
    $('#editModal2').modal('show');
  }
  // Function to remove a row from the table
  function removeRow(button) {
    // Show confirmation dialog
    Swal.fire({
      title: 'Are you sure?',
      text: 'Do you want to remove this f2f observation?',
      icon: 'question',
      showCancelButton: true,
      confirmButtonText: 'Yes',
      cancelButtonText: 'No',
    }).then((result) => {
      if (result.isConfirmed) {
        // Get the current row
        var row = $(button).closest('tr');

        // Remove the row from the table
        row.remove();

        // Update table visibility
        updateTableVisibility();
        // Show success message
        Swal.fire('Success!', 'F2F Observation Removed Successfully', 'success');

      }
    });
  }
</script>
<script>
  $(".chosen-select").select2({
    closeOnSelect: false,
    placeholder: "Please Select Users",
    allowHtml: true,
    tags: true
  });
//   // $(".chzn-select").chosen();
//   $('#add_Questiont').on('reset', function () {
//     // Destroy and reinitialize Select2
//     $('.chosen-select').val(null).trigger('change'); // Clear the selection first
//     $('.chosen-select').select2('destroy').select2();
// });
</script>






















@endsection