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

  /* #invite{
    display: none;
  } */

  .select2-container {
    min-width: 100% !important;
  }

  .select2-results__option {
    padding-right: 20px;
    vertical-align: middle;
  }

  .select2-results__option:before {
    content: "";
    display: inline-block;
    position: relative;
    height: 20px;
    width: 20px;
    border: 2px solid #e9e9e9;
    border-radius: 4px;
    background-color: #fff;
    margin-right: 20px;
    vertical-align: middle;
  }

  .select2-results__option[aria-selected=true]:before {
    font-family: fontAwesome;
    content: "\f00c";
    color: #fff;
    background-color: #f77750;
    border: 0;
    display: inline-block;
    padding-left: 3px;
  }

  .select2-container {
    width: 1% !important;
    display: table-cell !important;
  }

  .select2-container--default .select2-selection--multiple .select2-selection__choice {
    color: black !important;
  }

  .select2-container .select2-selection--multiple .select2-selection__rendered {
    white-space: normal !important;
    max-height: 100px;
    overflow-y: scroll;
  }

  .select2-container--default .select2-results__option--highlighted[aria-selected=true] {
    background-color: gray;
  }

  .select2-container--default.select2-container--open.select2-container--below .select2-selection--multiple {
    border-radius: 4px;
  }

  .select2-container--open .select2-dropdown--below {

    border-radius: 6px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);

  }

  .select2-selection .select2-selection--multiple:after {
    content: 'hhghgh';
  }

  /* select with icons badges single*/
  .select-icon .select2-selection__placeholder .badge {
    display: none;
  }

  .select-icon .placeholder {
    display: none;
  }

  .select-icon .select2-results__option:before,
  .select-icon .select2-results__option[aria-selected=true]:before {
    display: none !important;
    /* content: "" !important; */
  }

  .select-icon .select2-search--dropdown {
    display: none;
  }

  .accordion {
    border: solid 2px #f5f5f5;
    transition: all 0.3s ease-in-out;
    background-color: white;
  }

  .accordion+.accordion {
    margin-top: 0.25rem;
  }

  .accordion .accordion__title {
    list-style-type: none;
    cursor: pointer;
    font-size: 1rem;
    font-weight: 700;
    color: #555555;
    padding: 0.875rem 2.5rem 0.875rem 0.875rem;
    color: black;
    background-repeat: no-repeat;
    background-position: right 0.75rem top 0.625rem;
    background-size: 1.5rem;
  }

  .accordion .accordion__title::marker,
  .accordion .accordion__title::-webkit-details-marker {
    display: none;
  }

  .accordion[open] .accordion__title {
    color: white;
    background-color: #1e1a72;
  }
</style>

<div class="main-content" style="min-height:'60px'">
  {{ Breadcrumbs::render('activity_allocation13.create') }}
  @if(session('restore'))
  <script type="text/javascript">
    window.onload = function() {
      Swal.fire('Success!', 'Activity Saved Successfully', 'success');
      myFunction();
    }
  </script>
  @endif
  <!-- Main Content -->
  <section class="section">

    <div class="section-body mt-1">
      <h5 class="text-center" style="color:darkblue">Activity Allocation</h5>
      <form action="{{route('activity_allocation13.store')}}" id="userregistration" method="POST">
        @csrf
        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-body">
                <input type="hidden" id="prevData" name="prevData" value="">
                <div class="row">
                  <div class="col-md-4">
                    <div class="form-group">
                      <label class="control-label">Enrollment ID</label><span class="error-star" style="color:red;">*</span>
                      <select class="form-control default" name="enrollment_id" id="enrollment_id" onchange="myFunction()">
                        <option value="">Select Enrollment ID</option>

                        <option value="76">EN/2023/12/070(Pavani)</option>

                      </select>
                    </div>
                  </div>


                  <div class="col-md-4">
                    <div class="form-group">
                      <label class="control-label">Child ID</label><span class="error-star" style="color:red;">*</span>
                      <input class="form-control" type="text" id="child_id" name="child_id" autocomplete="off" readonly>
                    </div>
                  </div>



                  <div class="col-md-4">
                    <div class="form-group">
                      <label class="control-label">Child Name</label><span class="error-star" style="color:red;">*</span>
                      <input class="form-control" type="text" id="child_name" name="child_name" autocomplete="off" readonly>
                    </div>
                  </div>
                  <input type="hidden" id="user_id" name="user_id" value="">
                  <input type="hidden" id="descriptionID" name="descriptionID" value="">
                  <div class="col-md-4">
                    <div class="form-group">
                      <label class="control-label">Initiated By</label><span class="error-star" style="color:red;">*</span>
                      <input class="form-control" type="text" id="initiated_by" name="initiated_by" value="" autocomplete="off" readonly>


                    </div>
                  </div>

                  <div class="col-md-4">
                    <div class="form-group">
                      <label class="control-label">Allocated To</label><span class="error-star" style="color:red;">*</span>
                      <select class="form-control default" name="Category" id="Category" onchange="categorization()">
                        <option value="">Select Category</option>
                        <option value="1">Parent</option>
                        <option value="2">Child</option>

                      </select>
                    </div>
                  </div>

                  <input type="hidden" id="actionBtn" name="actionBtn">
                  <div class="col-md-4" id="divActivityName" style="display: none;">
                    <div class="form-group">
                      <label class="control-label">Activity Name</label><span class="error-star" style="color:red;">*</span>
                      <select class="js-select5 form-control" name="activity_id[]" id="activity_id" onchange="Description()" multiple="multiple">
                        <option value="">Select Activity Set</option>
                        <option value="47">Activity Set 1 [All]</option>
                        <option value="48">Activity Set 2 [All]</option>
                        <option value="50">Activity Set 3 [All]</option>
                        <option value="51">Activity Set 4 [All]</option>
                        <option value="52">Activity Set 5 [All]</option>
                        <option value="53">Activity Set 6 [All]</option>
                        <option value="56">Activity Set 1[Physical Skills] [13+]</option>
                        <option value="57">Activity Set 2 [13+]</option>
                        <option value="58">Activity Set 3 [13+]</option>
                        <option value="59">Activity Set 4 [13+]</option>

                      </select>
                    </div>
                  </div>
                  <div class="col-md-4" id="divActivityName1" style="display: none;">
                    <div class="form-group">
                      <label class="control-label">Activity Name</label><span class="error-star" style="color:red;">*</span>
                      <select class="js-select5 form-control" name="activity_id[]" id="activity_id" onchange="Description()" multiple="multiple">
                        <option value="">Select Activity Set</option>
                        <option value="47">Activity Set 1 [All]</option>
                        <option value="48">Activity Set 2 [All]</option>
                        <option value="50">Activity Set 3 [All]</option>
                        <option value="51">Activity Set 4 [All]</option>
                        <option value="52">Activity Set 5 [All]</option>
                        <option value="53">Activity Set 6 [All]</option>
                        <option value="60">Activity Set 1[Language Component] [13+]</option>
                        <option value="61">Activity Set 2 [13+]</option>
                        <option value="62">Activity Set 3 [13+]</option>


                      </select>
                    </div>
                  </div>

                </div>
                <div class="row">
                  <div class="col-md-12 d-flex justify-content-center">
                <a type="button" class="btn btn-labeled back-btn" title="Back" href="{{ route('activity_allocation13.index') }}" style="color:white !important">
                <span class="btn-label" style="font-size:13px !important;"><i class="fa fa-arrow-left"></i></span> Back</a>
                </div>
                </div>
              </div>
            </div>
          </div>
          <div class="row col-md-12" style="display: none;" id="description_table">

          </div>

          <div class="col-md-12  text-center" style="padding-top: 1rem;display:none" id="description_table_submit">
            <a type="button" onclick="save('Submit')" id="submitbutton" class="btn btn-labeled btn-succes" title="Initiation" style="background: green !important; border-color:green !important; color:white !important">
              <span class="btn-label" style="font-size:13px !important;"><i class="fa fa-check"></i></span>Activity Initiation</a>
            <a type="button" onclick="save('Save')" id="submitbutton" class="btn btn-labeled btn-succes" title="Save" style="background: green !important; border-color:green !important; color:white !important">
              <span class="btn-label" style="font-size:13px !important;"><i class="fa fa-check"></i></span>Save</a>
          </div>
        </div>

    </div>
    </form>
</div>
</section>
</div>


<script type="text/javascript">
  $(".js-select5").select2({
      closeOnSelect: false,
      placeholder: "Select Activity",
      allowHtml: true,
      allowClear: true,
      tags: true
    }).on('select2:selecting', e => $(e.currentTarget).data('scrolltop', $('.select2-results__options').scrollTop()))
    .on('select2:select', e => $('.select2-results__options').scrollTop($(e.currentTarget).data('scrolltop')))
    .on('select2:unselect', function(e) {
      var deselectedOption = e.params.data.id;
      var selectedOptionText = e.params.data.text;
      deselectactivity(deselectedOption, selectedOptionText);
    });

  $.ajaxSetup({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  });

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
        if (data != '[]') {
          var savedActivity = data.savedActivity[0].savedActivity;
          // console.log(savedActivity);
          if (savedActivity != null) {
            savedActivity = savedActivity.split(',').map(Number);
          } else {
            savedActivity = '';
          }
          var activityList = data.activity;
          data = data.enrollmentID;
          var optionsdata = "";
          document.getElementById('child_id').value = data[0].child_id;
          document.getElementById('child_name').value = data[0].child_name;
          document.getElementById('initiated_by').value = "elinaishead@gmail.com";
          // document.getElementById('initiated_to').value = data[0].child_contact_email;
          document.getElementById('user_id').value = data[0].user_id;
          // 
          // var optionsdata1 = "";
          // var ddd = "<option value=''>Select Activity Set</option>";
          // // console.log(savedActivity);
          // for (var i = 0; i < activityList.length; i++) {
          //   var activity_id = activityList[i]['activity_id'];
          //   var activity_name = activityList[i]['activity_name'];
          //   // console.log(savedActivity.includes(activity_id));
          //   ddd += "<option value=" + activity_id + (savedActivity.includes(activity_id) ? " selected" : "") + ">" + activity_name + "</option>";
          // }
          // var stageoption = ddd.concat(optionsdata1);
          // // console.log(stageoption);
          // var demonew = $('#activity_id').html(stageoption);
          // 
          Description();
          //$('#divActivityName').show();
        } else {
          document.getElementById('child_name');
          var ddd = '<option value="child_name">Select Enrollment_child_num</option>';
          var demonew = $('#child_name').html(ddd);
        }
      })
    } else {
      $('#divActivityName').hide();
      document.getElementById('child_id').value = '';
      document.getElementById('child_name').value = '';
      document.getElementById('initiated_to').value = '';
      document.getElementById('user_id').value = '';

      document.getElementById('initiated_by');
      var ddd = '<option value="initiated_by">Select Enrollment_child_num</option>';
      var demonew = $('#initiated_by').html(ddd);
    }
  };

  var ini_activity_id = [0];
  var extractedValues = [];

  function Description() {
    var activity_id = $("select[name='activity_id[]']").val();
    for (var i = 0; i < activity_id.length; i++) {
      var value = activity_id[i];

      if (!extractedValues.includes(value)) {
        extractedValues.push(value);
      } else {
        activity_id.splice(i, 1);
        i--;
      }
    }
    // console.log(extractedValues);
    var enrollment_id = $("select[name='enrollment_id']").val();
    if (enrollment_id == '') {
      swal.fire("Please Select Enrollment Child Number: ", "", "error");
      return false;
    }
    if (activity_id != "") {
      $.ajax({
        url: "{{ route('parentvideo13.description') }}",
        type: 'POST',
        data: {
          'activity_id': activity_id,
          'enrollment_id': enrollment_id,
          _token: '{{csrf_token()}}'
        }
      }).done(function(data) {

        // var category_id = json.parse(data);
        console.log(data);
        var active = data.active;
        var initiated = data.initiated[0].initiated;
        var prevData = data.prevData;
        var savedDescription = data.savedDescription[0].savedDescription;
        if (savedDescription == null) {
          savedDescription = [];
        }
        document.getElementById('prevData').value = prevData[0].co;
        var data = data.id;
        // console.log(initiated);
        if (data != '[]') {
          // data2 = [];
          // data3 = [];
          var optionsdata = "";
          for (var ij = 0; ij < data.length; ij++) {
            var data_set = data[ij];
            var activity_title = data_set[ij].activity_name;
            var activity_id = data_set[ij].activity_id;
            var group = data_set[ij].group;
            console.log(group);
            optionsdata += '<details class="accordion" id="accordion_id' + activity_id + '">';
            optionsdata += '<summary class="accordion__title">' + activity_title + '[' + group + ']' + '</summary>';
            optionsdata += '<div class="accordion__content">';
            optionsdata += '<div class="table-wrapper"><div class="table-responsive" id="alignq2">';
            optionsdata += '<input oninput="search(event , ' + activity_id + ')" id="search_' + activity_id + '" style="width: 30%;float: right;margin: 0 15px 0px 0px;" type="text" class="form-control default" placeholder="Search">';
            optionsdata += '<table class="table table-bordered"><thead><tr><th width="10%">Sl.No</th><th width="30%">Activity Name</th><th width="50%">Description</th><th width="10%">Active/InActive</th></tr></thead>';
            optionsdata += '<tbody id="table_' + activity_id + '">';
            for (var i = 0; i < data_set.length; i++) {
              var id = data_set[i].activity_description_id;
              var name = data_set[i].description;
              var instruction = data_set[i].instruction;
              data1.push(id);
              if (savedDescription.includes(id)) {
                optionsdata += "<tr><td style='border: 1px solid black !important;'>" + (parseInt(i) + 1) + "</td><td style='border: 1px solid black !important;' id=" + id + " >" + name + "</td><td style='border: 1px solid black !important;'> <div contenteditable='true' style='height:100px;overflow-y: scroll;' class='instructions_textarea' id='instructions[" + id + "]' name='instructions'>" + instruction + "</div></td><td style='text-align:center;border: 1px solid black !important;'><label class='switch' data-bs-toggle='tooltip' data-bs-placement='top' title='Enable / Disable'><input type='checkbox' checked class='toggle_status is_active id_active" + activity_id + "' onclick='active_function(" + activity_id + ")'  id='active_id' name='is_active'><span class='slider round'></span></label></td></tr>";
                active_function(id);
              } else {
                optionsdata += "<tr><td style='border: 1px solid black !important;'>" + (parseInt(i) + 1) + "</td><td style='border: 1px solid black !important;' id=" + id + " >" + name + "</td><td style='border: 1px solid black !important;'> <div contenteditable='true' style='height:100px;overflow-y: scroll;' class='instructions_textarea' id='instructions[" + id + "]' name='instructions'>" + instruction + "</div></td><td style='text-align:center;border: 1px solid black !important;'><label class='switch' data-bs-toggle='tooltip' data-bs-placement='top' title='Enable / Disable'><input type='checkbox' class='toggle_status is_active id_active" + activity_id + "' onclick='active_function(" + activity_id + ")'  id='active_id' name='is_active'><span class='slider round'></span></label></td></tr>";
              }
              // optionsdata += "<tr><td style='border: 1px solid black !important;'>" + (parseInt(i) + 1) + "</td><td style='border: 1px solid black !important;' id=" + id + " >" + name + "</td><td style='border: 1px solid black !important;'> <div contenteditable='true' style='height:100px;overflow-y: scroll;' class='instructions_textarea' id='instructions[" + id + "]' name='instructions'>" + instruction + "</div></td><td style='text-align:center;border: 1px solid black !important;'><label class='switch' data-bs-toggle='tooltip' data-bs-placement='top' title='Enable / Disable'><input type='checkbox' class='toggle_status is_active id_active" + activity_id + "' onclick='active_function(" + id + ")'  id='active_id' name='is_active'><span class='slider round'></span></label></td></tr>";

            }
            data2.push(activity_id);
            data3.push(activity_title);
            optionsdata += '</tbody></table></div></div>';
            optionsdata += '</div></details>';
          }
          var demonew = $('#description_table').append(optionsdata);
          $('#description_table').show();
          $('#description_table_submit').show();
          ini_activity_id.push(activity_id);
        }

        tinymce.init({
          selector: '.instructions_textarea',
          height: 150,
          menubar: false,
          branding: false,
          inline: true,
          plugins: 'link',
          toolbar: 'undo redo | formatselect | ' +
            'bold italic backcolor link ' +
            'removeformat',
        });
        updateSlNo(activity_id);
        $("#table_" + activity_id).sortable({
          items: "tr",
          cursor: "move",
          axis: "y",
          update: function(event, ui) {
            // Update the order of rows in the backend or perform any necessary actions
            var newOrder = $(this).sortable('toArray');
            console.log(newOrder);

            // Update the Sl.No in the displayed table
            updateSlNo();
          }
        }).disableSelection();

        // Function to update Sl.No values in the table
        function updateSlNo() {
          $("#table_" + activity_id + " tr").each(function(index) {
            // Update the Sl.No in the first column (assuming it's the first <td> in each row)
            $(this).find("td:first").text(index + 1);
          });
        }
      })
    }
  };
  var data1 = [0]; //48,49,50
  function active_function(id) { //console.log('acFu' , id);
    var check = 0;
    for (var i = 0; i < data1.length; i++) {
      if (data1[i] === id) {
        data1.splice(i, 1);
        check = 1;
        // console.log(data1);
      }
    }
    if (check == 0) {
      data1.push(id);
      // console.log(data1);
    }
  }
  var data2 = [];
  var data3 = [];

  function save(id) {
    // alert(id);

    var prevData = document.getElementById('prevData').value;

    // if (prevData > 0) {
    //   swal.fire("Activity Description is in pending status", "", "error");
    //   return false;
    // }

    // var descriptionID = (id);
    document.getElementById('actionBtn').value = id;
    document.getElementById('descriptionID').value = data1;
    var enrollment_id = $('#enrollment_id').val();

    if (enrollment_id == '') {
      swal.fire("Please Select Enrollment Child Number: ", "", "error");
      return false;
    }

    var child_id = $('.child_id').val();

    if (child_id == '') {
      swal.fire("Please Enter Child ID:", "", "error");
      return false;
    }

    var child_name = $('.child_name').val();

    if (child_name == '') {
      swal.fire("Please Enter Child Name:", "", "error");
      return false;
    }
    var initiated_by = $('#initiated_by').val();

    if (initiated_by == '') {
      swal.fire("Please Enter Initiated_by:  ", "", "error");
      return false;
    }

    var initiated_to = $('#Category').val();

    if (initiated_to == '') {
      swal.fire("Please Select the Category ", "", "error");
      return false;
    }

    var activity_id = $('#activity_id').val();

    if (activity_id == '') {
      swal.fire("Please Select Activity Set ", "", "error");
      return false;
    }
    var is_active = $('.is_active:checkbox:checked').length;
    if (is_active == 0) {
      swal.fire("Please Enable the Activity", "", "error");
      return false;
    }
    for (var i = 0; i < data2.length; i++) {
      var id_active = $('.id_active' + data2[i] + ':checkbox:checked').length;
      var id_name = data3[i];
      if (id_active == 0) {
        swal.fire("Please Enable the Activity in " + id_name, "", "error");
        return false;
      }
    }
    // $(".loader").show();
    // document.getElementById('userregistration').submit('saved');
    if (id == "Submit") {
      Swal.fire({

        title: "Are you Sure you want to Initiate the Activity?",
        text: "Please click 'Yes' to Initiate.",
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
          const message = "Activity Initiated Successfully";
          location.replace(`/activity_allocation13?message=${encodeURIComponent(message)}`);
        }
      })
    } else {
      swal.fire("Success!", "Activity Saved Successfully.", "success").then(function() {
        location.reload();
      });

    }

  }
</script>

<script>
  $(document).ready(function() {
    tinymce.init({
      selector: '.instructions_textarea',
      height: 200,
      menubar: false,
      branding: false,
      plugins: 'searchreplace autolink link quickbars',
      toolbar: 'undo redo | formatselect | ' +
        'bold italic backcolor | alignleft aligncenter ' +
        'alignright alignjustify | bullist numlist outdent indent | ' +
        'removeformat | searchreplace',
      content_style: 'body { font-family:Helvetica,Arial,sans-serif; font-size:14px }',
    });
  });

  function search(event, id) {
    var value = event.target.value;
    // console.log(value, id);
    value = value.toLowerCase();
    $("#table_" + id + " tr").filter(function() {
      $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
    });
    // Function to update Sl.No values in the table

  }

  function deselectactivity(deselectedOption, selectedOptionText) {
    document.getElementById('accordion_id' + deselectedOption).remove();
    extractedValues = extractedValues.filter(value => value !== deselectedOption);

    for (var di = 0; di < data2.length; di++) {
      if (data2[di] == deselectedOption) {
        data2.splice(di, 1);
        di--;
      }
    }

    data3 = data3.filter(value2 => value2 !== selectedOptionText);
    // console.log(extractedValues);
    console.log(data2, data3);
  }

  function categorization() {
    var category = document.getElementById('Category').value;

    if (category == '1') {
      document.getElementById('divActivityName').style.display = "block";
      document.getElementById('divActivityName1').style.display = "none";

    } else if (category == '2') {
      document.getElementById('divActivityName').style.display = "none";
      document.getElementById('divActivityName1').style.display = "block";

    } else {
      document.getElementById('divActivityName').style.display = "none";
      document.getElementById('divActivityName1').style.display = "none";

    }


  }
  $(document).ready(function() {
    // Enable sortable feature on the table

  });
</script>
@endsection