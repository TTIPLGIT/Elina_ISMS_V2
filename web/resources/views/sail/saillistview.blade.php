@extends('layouts.adminnav')
@section('content')
<div class="main-content">
  {{ Breadcrumbs::render('sailquestionnairelistview') }}
  <section class="section">
    <div class="section-body mt-2">
      @if (session('success'))
      <input type="hidden" name="session_data" id="session_data" class="session_data" value="{{ session('success') }}">
      <script type="text/javascript">
        window.onload = function() {
          var message = $('#session_data').val();
          swal.fire("Success", message, "success");
        }
      </script>
      @elseif(session('fail'))
      <input type="hidden" name="session_data" id="session_data1" class="session_data" value="{{ session('fail') }}">
      <script type="text/javascript">
        window.onload = function() {
          var message = $('#session_data1').val();
          swal.fire("Info", message, "info");
        }
      </script>
      @endif
      <div class="row">

        <div class="col-12">
          <a type="button" href="{{route('sailquestionnaireinitiate')}}" value="" class="btn btn-labeled btn-info" title="create" style="background: #044a95 !important; border-color:#a9ca !important; color:white !important;margin-top: 0.5rem;">
            <span class="btn-label" style="font-size:15px !important; padding:8px !important"><i class="fa fa-plus"></i></span><span style="font-size:15px !important; padding:8px !important">Initiation</span></a>
          <div class="card">

            <div class="card-body">

              <div class="row">

                <div class="col-lg-12 text-center">
                  <h4 style="color:darkblue;"> Questionnaire Activation Tracker</h4>
                </div>

              </div>

              <div class="table-wrapper">
                <div class="table-responsive">
                  <table class="table table-bordered" id="align">
                    <thead>
                      <tr>
                        <th>Sl.No.</th>
                        <th>Enrollment Id</th>
                        <th>Child Name</th>
                        <th>Stage</th>
                        <th>Questionnaire Name</th>
                        <th>Status</th>
                        <th>Action</th>
                      </tr>
                    </thead>
                    <tbody>
                      @foreach($rows as $key=>$row)
                      <tr>
                        <td>{{ $loop->iteration}}</td>
                        <td>{{$row['enrollment_child_num']}}</td>
                        <td>{{$row['child_name']}} </td>
                        <td>SAIL</td>
                        <td>{{$row['questionnaire_name']}}</td>
                        @if(in_array($user_id , explode(',', $row['viewed_users']) ))
                        <td>Viewed</td>
                        @else
                        <td>{{$row['questatus']}}</td>
                        @endif
                        <td class="text-center">
                          @if($row['questatus'] == 'Submitted')
                          <a class="btn btn-link" title="Show" id="{{$row['questionnaire_initiation_id']}}" href="{{ route('questionnaire.submitted.form', \Crypt::encrypt($row['questionnaire_initiation_id'])) }}"><i class="fas fa-eye" style="color: blue !important"></i></a>
                          <!-- <div class="row text-center">
                            <div class="col-md-12 form-group">
                              <input type='checkbox' class='toggle_status' onclick="functiontoggle()" id="is_active" name='is_active' data-enrollment="{{ $row['enrollment_child_num'] }}" data-questionnaire="{{ $row['questionnaire_initiation_id'] }}">
                              <span class='slider round'></span>
                            </div>
                          </div> -->
                          @if($row['questatus'] == 'Submitted' ||$row['questatus'] == 'Viewed')
                          <div class="col-md-12">
                            <label class='switch' data-bs-toggle='tooltip' data-bs-placement='top' title='Enable / Disable'>
                              <input type='checkbox' class='toggle_status' id="is_active" name='is_active' value="1" data-enrollment="{{ $row['enrollment_child_num'] }}" data-questionnaire="{{ $row['questionnaire_initiation_id'] }}">
                              <span class='slider round'></span>
                            </label>
                          </div>
                          @endif

                          <!-- <a class="btn btn-link" title="Show" href="{{ route('sail.show', \Crypt::encrypt($row['questionnaire_initiation_id'])) }}"><i class="fas fa-eye" style="color: blue !important"></i></a> -->
                          @if($row['questionnaire_id'] == 4)
                          <a class="btn btn-link" title="Show" id="{{$row['questionnaire_initiation_id']}}" href="{{ route('questionnaire.sensoryreport', \Crypt::encrypt($row['questionnaire_initiation_id'])) }}"><i class="fa fa-arrows" style="color: blue !important"></i></a>
                          @endif
                          @endif
                          @if($row['questatus'] == 'Saved')
                          <a class="btn btn-link" title="Edit" href="{{ route('sail.edit', \Crypt::encrypt($row['questionnaire_initiation_id']))}}"><i class="fas fa-pencil-alt" style="color: blue !important"></i></a>
                          @endif
                          @if($row['questatus'] != 'Submitted')
                          <input type="hidden" name="delete_id" id="<?php echo $row['questionnaire_initiation_id']; ?>" value="{{ route('sail.delete', \Crypt::encrypt($row['questionnaire_initiation_id'])) }}">
                          <a class="btn btn-link" title="View" onclick="return myFunction(<?php echo $row['questionnaire_initiation_id']; ?>);" class="btn btn-link"><i class="far fa-eye"></i></a>
                          <!-- <a class="btn btn-link" title="Delete" onclick="return deleteFunction(<?php echo $row['questionnaire_initiation_id']; ?>);" class="btn btn-link"><i class="far fa-trash-alt"></i></a> -->
                          @endif

                        </td>
                      </tr>
                      @endforeach
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</div>

<script src="https://code.jquery.com/jquery-1.7.2.min.js"></script>
<script type="application/javascript">
  function myFunction(id) {
    swal.fire("The parent has not yet submitted the questionnaire.", "", "info");
    // swal.fire({
    //     title: "Confirmation For Delete ?",
    //     text: "Are You Sure to delete this data.",
    //     type: "warning",
    //     showCancelButton: true,
    //     confirmButtonColor: '#DD6B55',
    //     confirmButtonText: 'Yes, I am sure!',
    //     cancelButtonText: "No, cancel it!",
    //     closeOnConfirm: false,
    //     closeOnCancel: false
    //   },
    //   function(isConfirm) {
    //     if (isConfirm) {
    //       swal.fire("Deleted!", "Data Deleted successfully!", "success");
    //       var url = $('#' + id).val();
    //       window.location.href = url;
    //     } else {
    //       swal.fire("Cancelled", "Your file is safe :)", "error");
    //       e.preventDefault();
    //     }
    //   });
  }

  function deleteFunction(id) {
    swal.fire({
      title: "Confirmation For Delete ?",
      text: "Are You Sure to delete this Questionnaire.",
      type: "warning",
      showCancelButton: true,
      confirmButtonColor: '#DD6B55',
      confirmButtonText: 'Yes, I am sure!',
      cancelButtonText: "No, cancel it!",
      closeOnConfirm: false,
      closeOnCancel: false
    }).then((result) => {
      if (result.value) {
        swal.fire("Deleted!", "Questionnaire Deleted successfully!", "success");
        var url = $('#' + id).val();
        console.log(url);
        window.location.href = url;
      }
    })
  }
</script>
<script>
  document.addEventListener("DOMContentLoaded", function() {
    var toggles = document.querySelectorAll('.toggle_status');
    toggles.forEach(function(toggle) {
      toggle.addEventListener("change", functiontoggle);
    });
  });

  function functiontoggle() {
    // Get the status of the checkbox
    var checkbox = this;
    var isChecked = checkbox.checked;
    console.log("Checkbox checked:", isChecked);

    var enrollmentId = checkbox.getAttribute("data-enrollment");
    var questionnaireId = checkbox.getAttribute("data-questionnaire");
    // Show SweetAlert dialog only if the checkbox is checked
    if (isChecked) {
      Swal.fire({
        title: 'Are you sure?',
        text: 'Do you want to allow the edit option for this questionnaire?',
        icon: 'question',
        showCancelButton: true,
        confirmButtonText: 'Yes',
        cancelButtonText: 'No',
      }).then((result) => {
        if (result.isConfirmed) {
        
          // Make an AJAX call to get the data
          $.ajax({
            type: 'POST',
            url: '/questionnaire/updateoption', // Replace with your AJAX endpoint
            data: {
              enrollment_id: enrollmentId,
              questionnaire_initiation_id: questionnaireId
            },
            success: function(response) {
              // Handle the response here
              console.log(response);
              Swal.fire({
                title: 'Success!',
                text: 'Edit access to the questionnaire has been successfully enabled for the parents',
                icon: 'success'
              }).then((result) => {
                // Reload the page after showing the success message
                location.reload();
              });
              checkbox.disabled = true;
            },
            error: function(xhr, status, error) {
              // Handle errors here
              console.error(xhr.responseText);
              checkbox.disabled = false;
            }
          });
        } else {
          // If the user clicks "No", revert the status of the switch
          checkbox.checked = false;
          // Enable the toggle after reverting the status
          checkbox.disabled = false;
        }
      });
    } else {
      // If the switch is unchecked, no action is needed
      checkbox.disabled = false;
    }
  }
</script>
@endsection