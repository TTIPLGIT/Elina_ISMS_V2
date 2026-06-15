@extends('layouts.adminnav')
@section('content')
<style>
/* =========================================================================
   MOBILE RESPONSIVE STYLING - SAME AS ENROLLMENT LIST PAGE
   ========================================================================= */

.table-responsive {
    overflow-x: auto;
    -webkit-overflow-scrolling: touch;
}

@media (max-width: 768px) {
    .main-content, .card, .card-body, .table-wrapper, .searchResultStudent, .table-responsive {
        padding-left: 0 !important; padding-right: 0 !important; margin-left: 0 !important; margin-right: 0 !important;
    }
    .row, .col-12, .col-lg-12 { padding-left: 5px !important; padding-right: 5px !important; }
    .main-content { padding-top: 0 !important; }
    .breadcrumb { font-size: 11px !important; margin-bottom: 10px !important; margin-top: 60px !important; margin-left: 10px !important; }
    .card { margin-top: 0 !important; }
    .table-responsive { overflow-x: hidden !important; overflow-y: visible !important; max-height: none !important; }
    .table-responsive table { font-size: 12px; min-width: 100% !important; width: 100% !important; }
    
    .searchResultStudent table, .searchResultStudent thead, .searchResultStudent tbody, .searchResultStudent th, .searchResultStudent td { display: block !important; width: 100% !important; }
    table[id^="align"] thead { display: none !important; }
    table[id^="align"] tbody { background: transparent !important; }
    table[id^="align"] { width: 100% !important; margin: 0 !important; }
    table[id^="align"] tr {
        display: flex !important; flex-direction: column !important; align-items: stretch !important;
        border: 1px solid #e0e0e0 !important; border-radius: 8px !important; margin: 8px 5px !important;
        position: relative !important; padding: 10px 15px 10px 45px !important; background: #fff !important;
        box-shadow: 0 1px 4px rgba(0,0,0,0.05) !important; cursor: pointer; width: calc(100% - 10px) !important;
    }
    table[id^="align"] td {
        display: block !important; border: none !important; padding: 0 !important; text-align: left !important;
        white-space: normal !important; width: 100% !important; background: transparent !important;
        height: auto !important; min-height: 0 !important; line-height: 1.2 !important;
    }

    /* Sl No */
    table[id^="align"] td:nth-of-type(1) {
        position: absolute !important; left: 15px !important; top: 50% !important; transform: translateY(-50%) !important;
        width: 25px !important; display: flex !important; font-weight: bold !important; font-size: 13px !important; color: #2c3e50 !important;
    }
    table[id^="align"] tr.expanded-row td:nth-of-type(1) { top: 20px !important; transform: translateY(0) !important; }

    /* Enrollment ID */
    table[id^="align"] td:nth-of-type(2) { display: block !important; font-size: 13px !important; color: #34495e !important; margin-bottom: 10px !important; order: 2 !important; }
    table[id^="align"] td:nth-of-type(2):before { content: "ID: "; font-weight: 600 !important; color: #000 !important; }

    /* Child Name */
    table[id^="align"] td:nth-of-type(3) { display: block !important; font-weight: 600 !important; font-size: 16px !important; color: #2c3e50 !important; margin-bottom: 4px !important; padding-right: 25px !important; order: 1 !important; }

    /* Hidden fields initially */
    table[id^="align"] td:nth-of-type(4),
    table[id^="align"] td:nth-of-type(5),
    table[id^="align"] td:nth-of-type(6),
    table[id^="align"] td:nth-of-type(7) { display: none !important; }

    /* Stage */
    table[id^="align"] tr.expanded-row td:nth-of-type(4) { display: block !important; margin-top: 8px !important; font-size: 12px !important; color: #34495e !important; order: 3 !important; }
    table[id^="align"] tr.expanded-row td:nth-of-type(4):before { content: "Stage: "; font-weight: 600 !important; color: #000 !important; }

    /* Questionnaire Name */
    table[id^="align"] tr.expanded-row td:nth-of-type(5) { display: block !important; margin-top: 6px !important; font-size: 12px !important; color: #34495e !important; order: 4 !important; }
    table[id^="align"] tr.expanded-row td:nth-of-type(5):before { content: "Questionnaire: "; font-weight: 600 !important; color: #000 !important; }

    /* Status */
    table[id^="align"] tr.expanded-row td:nth-of-type(6) { display: block !important; margin-top: 6px !important; font-size: 12px !important; color: #34495e !important; order: 5 !important; }
    table[id^="align"] tr.expanded-row td:nth-of-type(6):before { content: "Status: "; font-weight: 600 !important; color: #000 !important; }

    /* Action */
    table[id^="align"] tr.expanded-row td:nth-of-type(7) { display: flex !important; align-items: center !important; gap: 6px !important; margin-top: 6px !important; order: 6 !important; }
    table[id^="align"] tr.expanded-row td:nth-of-type(7):before { content: "Action:"; font-weight: 600 !important; color: #000 !important; margin-right: 6px !important; flex-shrink: 0 !important; }
    
    /* Arrow */
    table[id^="align"] tr::after { content: '\f054'; font-family: 'FontAwesome'; position: absolute; right: 15px; top: 50%; transform: translateY(-50%); color: #bdc3c7; transition: transform 0.3s; font-size: 12px; }
    table[id^="align"] tr.expanded-row::after { transform: translateY(-50%) rotate(90deg); top: 35px; }
    
    table[id^="align"] td.dataTables_empty { display: table-cell !important; width: 100% !important; text-align: center !important; padding: 15px !important; }
    table[id^="align"] tr:has(td.dataTables_empty) { display: table-row !important; border: none !important; box-shadow: none !important; padding: 0 !important; background: transparent !important; }
    table[id^="align"] tr:has(td.dataTables_empty)::after { display: none !important; }

    /* DataTable controls: Show left, Search right */
    .dataTables_wrapper .row:first-child { margin: 0 !important; }
    .dataTables_wrapper .dataTables_length { float: left !important; margin-left: 8px !important; }
    .dataTables_wrapper .dataTables_filter { float: right !important; padding-right: 8px !important; }
    .dataTables_wrapper .dataTables_length,
    .dataTables_wrapper .dataTables_filter,
    .dataTables_wrapper .dataTables_info,
    .dataTables_wrapper .dataTables_paginate { font-size: 10px !important; }
    .dataTables_wrapper .dataTables_length select { font-size: 11px !important; height: 32px !important; width: 60px !important; }
    .dataTables_wrapper .dataTables_filter input { width: 90px !important; height: 24px !important; font-size: 10px !important; }
}
</style>
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
<script>
$(document).ready(function() {
    $('table[id^="align"] tbody').on('click', 'tr', function(e) {
        if ($(e.target).closest('a, button, input, form, label').length) {
            return;
        }
        if ($(window).width() <= 768) {
            $(this).toggleClass('expanded-row');
        }
    });
});
</script>
@endsection