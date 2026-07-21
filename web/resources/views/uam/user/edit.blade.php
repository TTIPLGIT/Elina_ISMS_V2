@extends('layouts.adminnav')

@section('content')
<div class="main-content">
<style>
  #roles_id{
    pointer-events: none;
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
    .row.text-center .col-md-12 {
      display: flex !important;
      flex-wrap: wrap !important;
      justify-content: center !important;
      gap: 6px !important;
    }

    .row.text-center .col-md-12 .btn {
      width: auto !important;
      margin: 2px !important;
      padding: 6px 12px !important;
      font-size: 14px !important;
      white-space: nowrap !important;
    }

    h5 {
      font-size: 20px !important;
    }

    /* Additional roles – two columns, each with checkbox+label on same line */
    .additional-roles-container .col-md-6 {
      flex: 0 0 50% !important;
      max-width: 50% !important;
      display: flex !important;
      align-items: center !important;
      gap: 4px;
      margin-bottom: 6px;
    }
    .additional-roles-container .col-md-6 input[type="checkbox"] {
      margin: 0;
      flex-shrink: 0;
    }
    .additional-roles-container .col-md-6 label {
      display: inline-block !important;
      margin: 0 !important;
      font-weight: normal !important;
      font-size: 13px !important;
      white-space: nowrap;
    }
  }

  /* Desktop: also ensure checkbox+label stay on same line */
  .additional-roles-container .col-md-6 {
    display: flex !important;
    align-items: center !important;
    gap: 4px;
    margin-bottom: 6px;
  }
  .additional-roles-container .col-md-6 input[type="checkbox"] {
    margin: 0;
    flex-shrink: 0;
  }
  .additional-roles-container .col-md-6 label {
    display: inline-block !important;
    margin: 0 !important;
    font-weight: normal !important;
  }
</style>

  <!-- Main Content -->
  <section class="section">

    {{ Breadcrumbs::render('user.edit',$one_row[0]['id']) }}

    <div class="section-body mt-1">
      <h5 class="text-center" style="color:darkblue;">User Edit</h5>

      <div class="row">
        <div class="col-12">
          <div class="card">
            <div class="card-body">
              <form class="form-horizontal" name="uam_modules" method="POST" action="{{ route('update_user_data') }}">

                @csrf
                <div class="row">

                  <input class="form-control" type="hidden" id="user_id" name="user_id" value="{{ $one_row[0]['id']}}">

                  <div class="col-md-12 row">
                    <div class="col-md-6 form-group">
                      <label class="control-label">User Name <span style="color: red;font-size: 16px;">*</span></label>
                      <input class="form-control default" type="text" id="name" name="name" placeholder="Enter User Name" value="{{ $one_row[0]['name']}}">
                      @error('name')
                      <div class="error">{{ $message }}</div>
                      @enderror
                    </div>
                    <div class="col-md-6 form-group">
                      <label class="control-label">Email <span style="color: red;font-size: 16px;">*</span></label>
                      <input class="form-control default" type="email" id="email" name="email" placeholder="Enter Email" value="{{ $one_row[0]['email'] }}">
                      @error('email')
                      <div class="error">{{ $message }}</div>
                      @enderror
                    </div>

                    <div class="col-md-6 form-group">
                      <label class="control-label">Roles <span style="color: red;font-size: 16px;">*</span></label>
                      <select class="form-control" name="roles_id" id="roles_id">
                        <option value="">Please Select Role</option>
                        @foreach($rows_data as $key=>$row_data)
                        <option value="{{ $row_data['role_id'] }}" {{ $row_data['role_id'] ==  $one_row[0]['array_roles'] ? 'selected':'' }}>{{ $row_data['role_name'] }}</option>
                        @endforeach
                      </select>
                      @error('roles_id')
                      <div class="error">{{ $message }}</div>
                      @enderror
                    </div>

                    <div class="col-md-6 form-group">
                      <label class="control-label">Designation <span style="color: red;font-size: 16px;">*</span></label>
                      <select class="form-control default" name="designation">
                        <option value="">Please Select Designation</option>
                        @foreach($designation as $key=>$row)
                        <option value="{{ $row['designation_id'] }}" {{ $row['designation_id'] ==  $one_row[0]['designation_id'] ? 'selected':'' }}>{{ $row['designation_name'] }}</option>
                        @endforeach
                      </select>
                      @error('designation')
                      <div class="error">{{ $message }}</div>
                      @enderror
                    </div>

                    <div class="col-md-6">
                      <div class="form-group">
                        <label class="control-label">Additional Roles & Responsibilities</label><br>
                        <div class="row additional-roles-container">
                            @foreach($rows_data as $key => $row_data1)
                            @if($one_row[0]['array_roles'] != $row_data1['role_id'])
                            <div class="col-md-6">
                                @if($one_row[0]['roles'] !== null && strpos(','.$one_row[0]['roles'].',', ','.$row_data1['role_id'].',') !== false)
                                <input type="checkbox" id="additional_roles_id{{$row_data1['role_id']}}" name="additional_roles_id[]" value="{{$row_data1['role_id']}}" checked>
                                @else
                                <input type="checkbox" id="additional_roles_id{{$row_data1['role_id']}}" name="additional_roles_id[]" value="{{$row_data1['role_id']}}">
                                @endif
                                <label for="additional_roles_id{{$row_data1['role_id']}}">{{ $row_data1['role_name'] }}</label>
                            </div>
                            @endif
                            @endforeach
                        </div>
                      </div>
                    </div>

                    <div class="col-md-6 form-group" style="display: none;">
                      <label class="control-label">Dashboard List <span style="color: red;font-size: 16px;">*</span></label>
                      <select class="js-select5 form-control dashboard_list_id" multiple="multiple" name="dashboard_list_id[]">
                        @foreach($dashboard as $key=>$row)
                        <option value="{{ $row_data['role_id'] }}">{{ $row['dashboard_list_name'] }}</option>
                        @endforeach
                      </select>
                      @error('dashboard_list_id')
                      <div class="error">{{ $message }}</div>
                      @enderror
                    </div>
                  </div>

                  <!-- The commented-out treeview section remains as is -->
                  {{-- ... --}}

                </div>

                <div class="row text-center">
                  <div class="col-md-12">
                    <button class="btn btn-success" type="submit"><i class="fa fa-check"></i>&nbsp;&nbsp; Submit</button>&nbsp;
                    <button class="btn btn-primary" type="reset"><i class="fa fa-undo"></i> Undo </button>&nbsp;
                    <a class="btn btn-danger" href="{{ route('user.index') }}"><i class="fa fa-times" aria-hidden="true"></i> Cancel </a>&nbsp;
                  </div>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</div>

<!-- The hidden override options container (unchanged) -->
<div class="container-fluid" style="display: none">
  <div class="row">
    <div class="col-sm-1">
    </div>
    <div class="col-sm-5 text-center">
      <div class="text-left">Override some defaults:</div>
      <form id="override_options_form" method="POST" action="" style="display: none">
        <div class="form-group">
          <div class="checkbox text-left">
            <label><input id="checkbox_doubles" name="checkbox_doubles" value="1" type="checkbox" checked>Enable checking for n-tupel (doubles, triplets, ...) nodes</label>
          </div>
          <div class="checkbox text-left">
            <label><input id="checkbox_get_items" name="checkbox_get_items" type="checkbox" value="1" checked>Getting number of checked nodes on the fly</label>
          </div>
          <input type="hidden" name="select_tree" value="<br />
      <b>Notice</b>:  Undefined index: select_tree in <b>/storage/ssd4/607/2172607/public_html/hummingbird_v1.php</b> on line <b>317</b><br />
      ">
          <input type="hidden" name="override_options_form" value="1">
          <button class="btn btn-responsive btn-block btn-primary" type="submit" id="submit_options">Submit</button>
        </div>
      </form>
      <hr>
    </div>
  </div>
</div>

<script type="text/javascript">
  // document.getElementById("checkbox").checked = true;
</script>

<script src="https://cdn.jsdelivr.net/jquery.validation/1.15.1/jquery.validate.min.js"></script>
<script type="text/javascript">
  $("input#name").on({
    keydown: function(e) {
      if (e.which === 32)
        return false;
    },
    change: function() {
      this.value = this.value.replace(/\s/g, "");
    }
  });

  $(document).ready(function() {
    $(".js-select5").select2({
      closeOnSelect: false,
      placeholder: " Please Select Designation ",
      allowHtml: true,
      allowClear: true,
      tags: true
    });

    $(".js-select2").select2({
      closeOnSelect: false,
      placeholder: " Please Select Roles ",
      allowHtml: true,
      allowClear: true,
      tags: true
    });
  });
</script>

@endsection