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
  {{ Breadcrumbs::render('activityinitiate.observation', $rows['child_id'] ) }}
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
  @elseif(session('save'))
  <input type="hidden" name="session_save" id="session_save" value="{{ session('save') }}">
  <input type="hidden" name="session_activityID" id="session_activityID" value="{{ session('activityID') }}">
  <input type="hidden" name="session_descriptionID" id="session_descriptionID" value="{{ session('descriptionID') }}">
  <script type="text/javascript">
    window.onload = function() {
      var SetdescriptionID = $('#session_descriptionID').val();
      var SetactivityID = $('#session_activityID').val();
      var message = $('#session_save').val();

      Swal.fire("Success!", message, "success").then((result) => {
        if (result.isConfirmed) {
          $('#addModal2').modal('show');
          // 
          var selectElement = $(".selectActivitySet");
          var optionValueToSelect = SetactivityID;
          selectElement.val(optionValueToSelect);
          selectElement.change();
          // 
          // 
        }
      });

      // Swal.fire('Info!', message, 'info');
    }
  </script>
  @endif

  <div class="section-body">
    <h5 class="text-center" style="color:darkblue">F2F Observation Notes</h5>


    <div class="col-12">
      <div class="card-body">
        <div class="row">
          <div class="col-md-4">
            <div class="form-group">
              <label class="control-label">Enrollment Number</label><span class="error-star" style="color:red;">*</span>
              <input class="form-control" type="text" id="enrollment_id" name="enrollment_id" value="{{ $rows['enrollment_child_num'] }}" disabled autocomplete="off">
            </div>
          </div>
          <div class="col-md-4">
            <div class="form-group">
              <label class="control-label">Child ID</label><span class="error-star" style="color:red;">*</span>
              <input class="form-control" type="text" id="child_id" name="child_id" autocomplete="off" value="{{ $rows['child_id'] }}" readonly>
            </div>
          </div>
          <div class="col-md-4">
            <div class="form-group">
              <label class="control-label">Child Name</label><span class="error-star" style="color:red;">*</span>
              <input class="form-control" type="text" id="child_name" name="child_name" autocomplete="off" value="{{ $rows['child_name'] }}" readonly>
            </div>
          </div>
        </div>
        <div class="text-center">
          <a href="#addModal2" data-toggle="modal" data-target="#addModal2" data-toggle="modal" title="Add to F2F" class="btn btn-labeled btn-success" data-target="#templates">
            <span class="btn-label" style="font-size:13px !important;"><i class="fa fa-plus"></i></span> Add Activity</a>
          <a type="button" class="btn btn-labeled back-btn" title="Back" href="{{route('activity_initiate.index')}}" style="color:white !important">
            <span class="btn-label" style="font-size:13px !important;"><i class="fa fa-arrow-left"></i></span> Back</a>
        </div>
      </div>
    </div>
    <div class="m-3"></div>
    <div class="col-12">
      <div class="card-body">

        <div class="row mb-3">
          <div class="col-md-4">
            <label for="activityFilter">Filter by Activity:</label>
            <select id="activityFilter" class="form-control" onchange="filterTable()">
              <option value="">All</option>
              @foreach(collect($lastactivity)->unique('activity_name') as $activity)
              <option value="{{ $activity['activity_name'] }}">{{ $activity['activity_name'] }}</option>
              @endforeach
            </select>
          </div>
          <div class="col-md-4">
            <label for="statusFilter">Filter by Status:</label>
            <select id="statusFilter" class="form-control" onchange="filterTable()">
              <option value="">All</option>
              <option value="Initiated">Initiated</option>
              <option value="Saved">Saved</option>
            </select>
          </div>
        </div>

        <div class="table-wrapper">
          <div class="table-responsive">
            <table class="table table-bordered">
              <thead>
                <tr>
                  <!-- <th>Sl.No</th> -->
                  <th>Activity</th>
                  <th>Activity Description</th>
                  <!-- <th>Observation</th> -->
                  <th>Status</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody id="align1b">
                @foreach($lastactivity as $key=> $row)
                @if($row['f2f_flag'] != '0')
                <tr>
                  <!-- <td>{{ $loop->iteration }}</td> -->
                  <td>{{$row['activity_name']}}</td>
                  <td>{{$row['description']}}</td>
                  <!-- <td>
                      <input class="form-control" type="text" id="observation_result{{$row['parent_video_upload_id']}}" name="observation_result[{{$row['parent_video_upload_id']}}]" value="{{$row['comments']}}" autocomplete="off">
                    </td> -->
                  <td>{{ $row['f2f_flag'] == 2 ? 'Saved' : ($row['f2f_flag'] == 1 ? 'Initiated' : '') }}</td>
                  <td>
                    @if($row['f2f_flag'] == 2)
                    <a class="" title="Edit" id="edit" data-activity-id="{{$row['activity_id']}}" data-description-id="{{$row['activity_description_id']}}" onclick="openInitateModal(this.dataset.activityId, this.dataset.descriptionId)" style="padding-top: 6px;"><i class="fas fa-pencil-alt" style="color: blue !important"></i></a>
                    @else
                    <a class="" title="Edit" id="edit" data-parent-video-id="{{$row['parent_video_upload_id']}}" onclick="fetch_update(this.dataset.parentVideoId,'edit')" data-toggle="modal" data-target="#editModal2" style="padding-top: 6px;"><i class="fas fa-pencil-alt" style="color: blue !important"></i></a>
                    @endif
                    <!-- openInitateModal -->
                    <a class="btn btn-link" id="show" data-parent-video-id="{{$row['parent_video_upload_id']}}" onclick="fetch_update(this.dataset.parentVideoId,'show')" data-toggle="modal" data-target="#showModal2" style="padding-top: 6px;" title="show"><i class="fas fa-eye" style="color:green"></i></a>
                    <button type="submit" title="Delete" data-parent-video-id="{{$row['parent_video_upload_id']}}" onclick="delete1(this.dataset.parentVideoId)" class="btn btn-link"><i class="far fa-trash-alt" style="color:red"></i></button>
                    <!-- <button onclick='removeRow(this)' class='btn btn-danger'>Remove</button> -->
                  </td>
                </tr>
                @endif
                @endforeach
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>


  </div>

  <!-- Modal -->
  <div class="modal fade modalreset" id="addModal2">
    <div class="modal-dialog modal-xl" role="document">
      <div class="modal-content">
        <form action="{{route('activity_f2f.store')}}" method="POST" id="formmeeting" enctype="multipart/form-data" class="reset">
          @csrf
          <input type="hidden" id="enrollment_id" name="enrollment_id" value="{{ $rows['enrollment_child_num'] }}">
          <input type="hidden" name="actionf2f" id="actionf2f">

          <div class="modal-header" style="background-color:DarkSlateBlue;">
            <h5 class="modal-title" id="#addModal">Initiate Face-to-Face Observation</h5>
          </div>

          <div class="modal-body">

            <div class="card question" id="next-section">
              <div class="row" style="margin-bottom: 15px;margin-top: 20px;">
                <div class="col-md-4" id="question_field">
                  <div class="form-group questionnaire">
                    <label class="control-label required">Activity Set</label>
                    <select class="form-control default activity_set selectActivitySet" name="activity_set" id="activity_set">
                      <option value="">Select Activity Set</option>
                      @foreach ($activity_set as $key => $act)
                      <option value="{{ $act['activity_id'] }}">{{ $act['activity_name'] }}</option>
                      @endforeach
                    </select>
                  </div>
                </div>
                <input type="hidden" id="description_name" name="description_name">

                <div class="col-md-7 des_ption" style="display:none;">
                  <div class="form-group questionnaire">
                    <label class="control-label required">Activity Description</label>
                    <select class="form-control default description selectDescription" name="description" id="description">

                    </select>
                  </div>
                </div>
                <div class="col-md-3 materials_list" style="display:none;">
                  <div class="form-group">
                    <label class="control-label required">Materials Required</label>
                    <select data-placeholder="Select Materials" multiple class="chosen-select materials materialsRequiredSaved" name="materials[]" style="width: 100% !important;">
                      <option value="">Select Materials</option>
                    </select>
                  </div>
                </div>

                <div class="col-md-4">
                  <div class="form-group questionnaire">
                    <label class="control-label required">To Observe</label>
                    <textarea class="form-control default tx_to_observe" name="to_observe" id="to_observe" autocomplete="off"></textarea>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group questionnaire">
                    <label class="control-label">To Ask Parents</label>
                    <textarea class="form-control default tx_ask_parent" name="ask_parent" id="ask_parent" autocomplete="off"></textarea>
                  </div>
                </div>
                <div class="col-md-4" id="">
                  <div class="form-group questionnaire">
                    <label class="control-label">Observation</label>
                    <textarea class="form-control default tx_Observation" name="Observation" id="Observation" autocomplete="off"></textarea>
                  </div>
                </div>

                <input type="hidden" id="actionBtn" name="actionBtn" value="Submit">

                <div class="col-md-12" style="display:flex;justify-content: center;gap:5px">
                  <a type="button" onclick="saveQuestion1('Submit')" id="submitbtn" class="btn btn-success" title="Add Activity" style="color:white !important">Submit</a>
                  <a type="button" onclick="saveQuestion1('Save')" id="savebtn" class="btn btn-success" title="Save Activity" style="color:white !important">Save</a>
                  <a type="button" class="btn back-btn" title="Close" onclick="saveQuestion('Close')" style="color:white !important">Close</a>
                </div>
              </div>
            </div>
          </div>
        </form>

        </section>

      </div>




    </div>
  </div>

  <div class="modal fade" id="editModal2">
    <div class="modal-dialog modal-xl" role="document">
      <div class="modal-content">
        <form action="{{route('activity_f2f.update')}}" id="edit_Question" method="POST" enctype="multipart/form-data" class="reset">
          @csrf
          <input type="hidden" name="eid" class="eid" id="eid">
          <input type="hidden" name="description_id" class="description_id" id="description_id">
          <input type="hidden" name="activity_id" class="activity_id" id="activity_id">
          <input type="hidden" name="parent_video_id" class="parent_video_id" id="parent_video_id">
          <input type="hidden" id="enrollment_id" name="enrollment_id" value="{{ $rows['enrollment_child_num'] }}">
          <input type="hidden" name="activity_initiation_id" value="{{$rows['activity_initiation_id']}}">

          <div class="modal-header" style="background-color:DarkSlateBlue;">
            <h5 class="modal-title" id="#addModal">Update Face-to-Face Observation</h5>
          </div>

          <div class="modal-body">


            <div class="card question" id="next-section">
              <div class="row" style="margin-bottom: 15px;margin-top: 20px;">
                <div class="col-md-4" id="question_field">
                  <div class="form-group questionnaire">
                    <label class="control-label required">Activity Set</label>
                    <input class="form-control" type="text" id="activity_set_edit" name="activity_set" value="" autocomplete="off" readonly>

                  </div>
                </div>

                <div class="col-md-7 des_ption">
                  <div class="form-group questionnaire">
                    <label class="control-label required">Activity Description</label>
                    <input class="form-control" type="text" id="description_id_edit" name="description_id" value="" autocomplete="off" readonly>

                  </div>
                </div>
                <div class="col-md-7">
                  <div class="form-group questionnaire">
                    <label class="control-label required">Materials Required</label>
                    <input class="form-control" type="text" id="materials_edit" name="materials_edit" value="" autocomplete="off" readonly>

                  </div>
                </div>

                <div class="col-md-4">
                  <div class="form-group questionnaire">
                    <label class="control-label required">To Observe</label>
                    <textarea class="form-control default" name="to_observe_edit" id="to_observe_edit" autocomplete="off" value="" readonly></textarea>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group questionnaire">
                    <label class="control-label">To Ask Parents</label>
                    <textarea class="form-control default" name="ask_parent_edit" id="ask_parent_edit" autocomplete="off" readonly></textarea>
                  </div>
                </div>
                <div class="col-md-4" id="">
                  <div class="form-group questionnaire">
                    <label class="control-label">Observation</label>
                    <textarea class="form-control default" name="Observation_edit" id="Observation_edit" autocomplete="off"></textarea>
                  </div>
                </div>

                <div class="col-md-12" style="display:flex;justify-content: center;gap:5px;">
                  <a type="button" onclick="saveQuestion('Update')" id="submitbtn" class="btn btn-success" title="Update F2F Observation" style="color:white !important">Update</a>
                  <a type="button" class="btn back-btn" title="Close" onclick="saveQuestion('Close1')" style="color:white !important">Close</a>
                </div>
              </div>
            </div>

            </section>

          </div>

        </form>


      </div>
    </div>
  </div>

  <div class="modal fade" id="showModal2">
    <div class="modal-dialog modal-xl" role="document">
      <div class="modal-content">
        <form action="" id="edit_Question" method="POST" id="ethnicupdate" enctype="multipart/form-data" class="reset">
          @method('put')
          @csrf
          <input type="hidden" name="eid" class="eid" id="eid">
          <div class="modal-header" style="background-color:DarkSlateBlue;">
            <h5 class="modal-title" id="#addModal">Face-to-Face Observation</h5>
          </div>

          <div class="modal-body">


            <div class="card question" id="next-section">
              <div class="row" style="margin-bottom: 15px;margin-top: 20px;">
                <div class="col-md-4" id="question_field">
                  <div class="form-group questionnaire">
                    <label class="control-label required">Activity Set</label>
                    <input class="form-control" type="text" id="activity_set_show" name="activity_set" value="" autocomplete="off" readonly>

                  </div>
                </div>

                <div class="col-md-7 des_ption">
                  <div class="form-group questionnaire">
                    <label class="control-label required">Activity Description</label>
                    <input class="form-control" type="text" id="description_id_show" name="description_id" value="" autocomplete="off" readonly>

                  </div>
                </div>
                <div class="col-md-7 materials_list">
                  <div class="form-group questionnaire">
                    <label class="control-label required">Materials Required</label>
                    <input class="form-control" type="text" id="materials_show" name="materials_show" value="" autocomplete="off" readonly>

                  </div>
                </div>

                <div class="col-md-4">
                  <div class="form-group questionnaire">
                    <label class="control-label required">To Observe</label>
                    <textarea class="form-control default" name="to_observe_show" id="to_observe_show" autocomplete="off" value="" readonly></textarea>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group questionnaire">
                    <label class="control-label">To Ask Parents</label>
                    <textarea class="form-control default" name="ask_parent_show" id="ask_parent_show" autocomplete="off" readonly></textarea>
                  </div>
                </div>
                <div class="col-md-4" id="">
                  <div class="form-group questionnaire">
                    <label class="control-label">Observation</label>
                    <textarea class="form-control default" name="Observation_show" id="Observation_show" autocomplete="off" readonly></textarea>
                  </div>
                </div>

                <div class="col-md-12" style="display:flex;justify-content: center;">
                  <a type="button" class="btn btn-labeled back-btn" title="Close" data-dismiss="modal" style="color:white !important">Close</a>
                </div>
              </div>
            </div>

            </section>

          </div>

        </form>


      </div>
    </div>
  </div>
  <!-- End Modal -->

  <script type="text/javascript">
    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });

    function isBlank(value) {
      return value === undefined || value === null || (typeof value === 'string' && value.trim() === '');
    }

    function myFunction() {
      var enrollment_id = $("select[name='enrollment_id']").val();

      if (enrollment_id != "") {
        $.ajax({
          url: "{{ url('/activityinitiate/ajax') }}",
          type: 'POST',
          data: {
            'enrollment_id': enrollment_id,
            _token: '{{csrf_token()}}'
          }
        }).done(function(data) {
          // var category_id = json.parse(data);
          console.log(data);

          if (data != '[]') {

            // var user_select = data;
            var optionsdata = "";

            document.getElementById('child_id').value = data[0].child_id;
            document.getElementById('child_name').value = data[0].child_name;
            document.getElementById('initiated_to').value = data[0].child_contact_email;
            document.getElementById('user_id').value = data[0].user_id;
            console.log(name)


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

    function Description() {
      var activity_id = $("select[name='activity_id']").val();

      if (activity_id != "") {
        $.ajax({
          url: "{{ route('parentvideo.description') }}",
          type: 'POST',
          data: {
            'activity_id': activity_id,
            _token: '{{csrf_token()}}'
          }
        }).done(function(data) {
          // var category_id = json.parse(data);
          // console.log(data);

          if (data != '[]') {

            // var user_select = data;
            var optionsdata = "";
            for (var i = 0; i < data.length; i++) {
              var id = data[i].activity_description_id;
              var name = data[i].description;
              // console.log(name)
              // var ddd = '<td="">Select description</td>';
              optionsdata += "<tr><td >" + (parseInt(i) + 1) + "</td><td id=" + id + " >" + name + "</td><td>New</td></tr>";
            }
            // var stageoption = ddd.concat(optionsdata);
            var demonew = $('#align1b').html(optionsdata);
          } else {

            // var ddd = '<option value="">Select description</option>';
            // var demonew = $('#align1').html(ddd);
          }
        })
      } else {
        // var ddd = '<option value="">Select description</option>';
        // var demonew = $('#align1').html(ddd);
      }
    };

    function saveQuestion1(action) {
      $('#actionf2f').val(action);
      if (action == "Submit") {
        var activity_set = $('#activity_set').val();
        var description = $('#description').val();
        if (activity_set == "") {
          Swal.fire("Please Select Activity Set", "", "error");
          return false;
        }
        if (description == "") {
          Swal.fire("Please Select Activity description", "", "error");
          return false;
        }
        var selectedMaterials = $('select.materials').val();
        if (!selectedMaterials || selectedMaterials.length === 0) {
          Swal.fire("Please select at least one material", "", "error");
          return false;
        }
        // var observationText = $('#Observation').val();
        // if (isBlank(observationText)) {
        //   Swal.fire("Please enter Observation", "", "error");
        //   return false;
        // }

        var toObserveText = $('#to_observe').val();
        if (isBlank(toObserveText)) {
          Swal.fire("Please enter To Observe", "", "error");
          return false;
        }

        // Check if the form element exists
        var form = document.getElementById('formmeeting');
        if (form) {
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
              // Submit the form
              form.submit();
            }
          });
        } else {
          console.error("Form element with ID 'formmeeting' not found.");
        }
      }
      if (action == "Save") {
        var activity_set = $('#activity_set').val();
        var description = $('#description').val();
        if (activity_set == "") {
          Swal.fire("Please Select Activity Set ", "", "error");
          return false;
        }
        if (description == "") {
          Swal.fire("Please Select Activity description ", "", "error");
          return false;
        }
        var selectedMaterials = $('select.materials').val();
        if (!selectedMaterials || selectedMaterials.length === 0) {
          Swal.fire("Please select at least one material", "", "error");
          return false;
        }
        // var observationText = $('#Observation').val();
        // if (isBlank(observationText)) {
        //   Swal.fire("Please enter Observation", "", "error");
        //   return false;
        // }
        var toObserveText = $('#to_observe').val();
        if (isBlank(toObserveText)) {
          Swal.fire("Please enter To Observe", "", "error");
          return false;
        }
        document.getElementById('formmeeting').submit();
      }
    }


    function saveQuestion(action) {
      // Your existing code to save question
      if (action == "Close") {
        // Clear the form fields
        $('#activity_set').val("");
        $('#description').val("");
        $('.chosen-select').val("");
        $('#to_observe').val("");
        $('#ask_parent').val("");
        $('#observe_head').val("");

        // Close the modal after clearing the form
        $('#addModal2').modal('hide');
        des();
      } else if (action == "Submit") {
        var activity_set = $('#activity_set').val();
        var description = $('#description').val();
        if (activity_set == "") {
          Swal.fire("Please Select Activity Set ", "", "error");
          return false;
        }
        if (description == "") {
          Swal.fire("Please Select Activity description ", "", "error");
          return false;
        }
        //Show confirmation dialog
        Swal.fire({
          title: 'Are you sure?',
          text: 'Do you want to add this to the Face to Face?',
          icon: 'question',
          showCancelButton: true,
          confirmButtonText: 'Yes',
          cancelButtonText: 'No',
        }).then((result) => {
          if (result.isConfirmed) {
            // $('#addModal2').modal('hide');
            $(".loader").show();
            $('#addModal2').modal('hide');
            // Display success message
          }
        });

      } else if (action == "Update") {
        var observationEditText = $('#Observation_edit').val();
        if (isBlank(observationEditText)) {
          Swal.fire("Please enter Observation", "", "error");
          return;
        }
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
            // Set form action
            document.getElementById('edit_Question').submit(); // Display success message
            Swal.fire('Success!', 'F2F Observation Updated Successfully', 'success');
            $('#editModal2').modal('hide');
          }
        });
      } else if (action == "Close1") {
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
      $('#activity_set').val(activitySet);
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
    $(".chosen-select").select2({
      closeOnSelect: false,
      placeholder: "Please Select Users",
      allowHtml: true,
      tags: true
    });
    // After dynamically adding rows to the table
    function updateTableVisibility() {
      if ($('#align1b tr').length === 0) {
        $('#noDataMessage').show();
      } else {
        $('#noDataMessage').hide();
      }
    }
    $(".chosen-select").select2({
      closeOnSelect: false,
      placeholder: "Please Select Users",
      allowHtml: true,
      tags: true
    });

    $(document).ready(function() {

      var descriptionDropdown = $('.description');
      var materialist = document.querySelector('.materials_list');

      $(".activity_set").change(function() {
        var selectedActivitySet = $(this).val();
        var enrollment_id = $('#enrollment_id').val();
        var descriptionDropdown = $('#description');
        var description_name = $('#description_name');
        var materialsDropdown = $('.materials');
        var desption = $('.des_ption');
        var materialist = $('.materials_list');
        var id;
        if (selectedActivitySet != "") {
          desption.show();
          materialsDropdown.show();
          $('.materials_list').css('display', 'block');
          $.ajax({
            url: "{{ route('parentvideo.f2f_description') }}",
            type: 'POST',
            data: {
              'activity_id': selectedActivitySet,
              'enrollment_id': enrollment_id,
              '_token': '{{csrf_token()}}'
            },
            success: function(data) {

              if (data.length > 0) {

                var optionsdata = '<option value="">Select Description</option>';
                for (var i = 0; i < data.length; i++) {
                  var id = data[i].activity_description_id;
                  var name = data[i].description;
                  optionsdata += "<option value='" + id + "'>" + name + "</option>";
                }
                descriptionDropdown.html(optionsdata);

                var SetdescriptionID = $('#session_descriptionID').val();
                if (SetdescriptionID != undefined) {
                  var selectElement1 = $(".selectDescription");
                  var optionValueToSelect1 = SetdescriptionID;
                  selectElement1.val(optionValueToSelect1);
                  selectElement1.change();
                }

              } else {
                descriptionDropdown.html("<option value=''>No descriptions found</option>");
              }
            },
            error: function(xhr, status, error) {
              console.error(xhr.responseText);
            }
          });
        } else {
          desption.hide();
          materialist.hide();
          descriptionDropdown.html("<option value=''>Please select an activity</option>");
          materialsDropdown.html("<option value=''>Please select an activity</option>");
        }
      });


      $(".description").change(function() {
        var descriptionDropdown = $(this).val();
        // console.log(descriptionDropdown);
        var materialsDropdown = $('.materials');
        var selectedActivitySet = $('.activity_set').val();
        var enrollment_id = $('#enrollment_id').val();

        if (descriptionDropdown != "") {
          $.ajax({
            url: "{{ route('parentvideo.materials') }}",
            type: 'POST',
            data: {
              'activity_id': selectedActivitySet,
              'enrollment_id': enrollment_id,
              'description_id': descriptionDropdown,
              'materials': materialsDropdown.val(),
              '_token': '{{csrf_token()}}'
            },

            success: function(data) {
              var f2fObs = data.f2f_Observation[0];
              if (data.desc1.length > 0) {
                var options = [];
                for (var i = 0; i < data.desc1.length; i++) {
                  options.push("<option value='" + data.desc1[i].materials + "'>" + data.desc1[i].materials + "</option>");
                }
                materialsDropdown.html(options.join(''));

                if ($.fn.select2) {
                  if (materialsDropdown.hasClass('select2-hidden-accessible')) {
                    materialsDropdown.select2('destroy');
                  }

                  materialsDropdown.select2({
                    multiple: true,
                    placeholder: "Select materials"
                  });
                } else {
                  console.error("Select2 not available");
                }

                if (f2fObs != null) {
                  $('.tx_to_observe').val(f2fObs.to_observe);
                  $('.tx_ask_parent').val(f2fObs.to_ask_parents);

                  var materialsRequired = f2fObs.materials_required;
                  var materialsArray = materialsRequired.split(',');

                  $('.materialsRequiredSaved').each(function() {
                    $(this).val(materialsArray).trigger('change'); 
                  });

                }

                $('.tx_Observation').val(data.comments);
              } else {
                materialsDropdown.html("<option value=''>No materials found</option>");
              }
            },
            error: function(xhr, status, error) {
              console.error(xhr.responseText);
            }
          });
        } else {
          materialist.style.display = "none";
          materialsDropdown.removeAttr("multiple");
          materialsDropdown.html("");
        }
      });

    });

    function des() {
      $('.des_ption').css('display', 'none');
      $('.materials_list').css('display', 'none');

    }

    $('.edit-link').click(function(event) {
      event.preventDefault(); // Prevent default link behavior
      $('#editModal2').modal('show');
      var parentVideoId = $(this).data('parent-video-id'); // Get parent video ID
      // console.log(parentVideoId);
      // Fetch modal content via AJAX
      $.ajax({
        url: "{{ route('activity_f2f.edit', ':parentVideoId') }}".replace(':parentVideoId', parentVideoId),
        type: 'GET',
        success: function(response) {
          // Insert response into modal content
          $('#editModal2 .modal-content').html(response);
          // Show modal

        },
        error: function(xhr, status, error) {
          console.error('Error loading modal content:', error);
        }
      });
    });

    function fetch_update(id, type) {
      $.ajax({
        url: "{{ url('/activity/f2f/fetch') }}",
        type: 'GET',
        data: {
          'id': id,
          _token: '{{csrf_token()}}'

        },

        success: function(data) {
          // console.log(data);
          if (type == "edit") {
            $('#activity_set_edit').val(data.rows1[0]['activity_name']);
            $('#description_id_edit').val(data.rows1[0]['description']);
            $('#materials_edit').val(data.rows[0]['materials_required']);
            $('#to_observe_edit').val(data.rows[0]['to_observe']);
            $('#ask_parent_edit').val(data.rows[0]['to_ask_parents']);
            $('#Observation_edit').val(data.rows1[0]['comments']);
            $('#activity_id').val(data.rows1[0]['activity_id']);
            $('#description_id').val(data.rows1[0]['activity_description_id']);
            $('#parent_video_id').val(data.rows1[0]['parent_video_upload_id']);

            $('#eid').val(data.rows[0]['id']);

          } else {
            $('#activity_set_show').val(data.rows1[0]['activity_name']);
            $('#description_id_show').val(data.rows1[0]['description']);
            $('#materials_show').val(data.rows[0]['materials_required']);
            $('#to_observe_show').val(data.rows[0]['to_observe']);
            $('#ask_parent_show').val(data.rows[0]['to_ask_parents']);
            $('#Observation_show').val(data.rows1[0]['comments']);

            $('#eidshow').val(data.rows[0]['id']);

            $('#activity_set_show').prop('disabled', true);
            $('#description_id_show').prop('disabled', true);
            $('#materials_show').prop('disabled', true);
            $('#to_observe_show').prop('disabled', true);
            $('#ask_parent_show').prop('disabled', true);
            $('#Observation_show').prop('disabled', true);
            $('#eidshow').attr('Action', '');


          }


        }
      });

    }
    const myModal = document.querySelectorAll('.modalreset');

    for (const myModals of myModal) {

      myModals.addEventListener('hidden.bs.modal', function() {

        const form = this.querySelector('.reset');

        form.reset();
      });

    }

    function delete1(id) {
      Swal.fire({
        title: 'Are you sure?',
        text: 'Do you want to remove this f2f observation?',
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Delete",
      }).then((result) => {
        if (result.isConfirmed) {
          $.ajax({
            url: "{{ route('activity_f2f.delete', ['id' => ':id']) }}".replace(':id', id),
            type: 'GET',
            data: {
              _token: '{{csrf_token()}}'

            },


            success: function(data) {
              console.log(data);
              if (result.value) {

                Swal.fire("Success!", "F2F Deleted Successfully!", "success").then((result) => {
                  if (result.isConfirmed) {
                    location.reload();
                  }
                });
              }

            }
          });
        }
      })
    }
  </script>

  <script>
    function filterTable() {
      const activityFilter = document.getElementById("activityFilter").value.toLowerCase();
      const statusFilter = document.getElementById("statusFilter").value.toLowerCase();

      const table = document.getElementById("align1b");
      const rows = table.getElementsByTagName("tr");

      for (let row of rows) {
        const activityCell = row.cells[0]?.textContent.toLowerCase() || '';
        const statusCell = row.cells[2]?.textContent.toLowerCase() || '';

        const activityMatch = !activityFilter || activityCell.includes(activityFilter);
        const statusMatch = !statusFilter || statusCell.includes(statusFilter);

        row.style.display = (activityMatch && statusMatch) ? "" : "none";
      }
    }
  </script>
  <script>
    function openInitateModal(activityID, descriptionID) {

      let hiddenInput = document.getElementById("session_descriptionID");

      if (!hiddenInput) {
        hiddenInput = document.createElement("input");
        hiddenInput.type = "hidden";
        hiddenInput.name = "session_descriptionID";
        hiddenInput.id = "session_descriptionID";
        document.body.appendChild(hiddenInput);
      }

      hiddenInput.value = descriptionID;
      $('#addModal2').modal('show');
      const selectElement1 = $(".selectActivitySet");
      selectElement1.val(activityID).change();

    }
  </script>

  @endsection