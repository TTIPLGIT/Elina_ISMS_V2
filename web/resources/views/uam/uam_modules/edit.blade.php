@extends('layouts.adminnav')

@section('content')
<style>
  /* ==========================================
     MOBILE RESPONSIVE – FORM PAGES
     (same as create page)
     ========================================== */
  @media (max-width: 768px) {

    /* Containers */
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

    /* Form groups – stack labels and inputs */
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

    /* BUTTONS – INLINE ON MOBILE (same line, wrap if needed) */
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

    /* Heading */
    h5 {
      font-size: 20px !important;
    }
  }
</style>

<div class="row">
    <div class="main-content">

        <!-- Main Content -->
        <section class="section">

            {{ Breadcrumbs::render('uam_modules.edit',$one_row[0]['module_id']) }}

            <div class="section-body mt-1">
                <!-- HEADING CENTERED ON ALL SCREENS -->
                <h5 class="text-center" style="color:darkblue;">Modules Edit</h5>
                <div class="row">

                    <div class="col-12">

                        <div class="card">
                            <div class="card-body">

                                <form name="edit_form" action="{{ route('uam_modules.update',$one_row[0]['module_id']) }}" method="POST" id="edit_module_form{{$one_row[0]['module_id']}}">
                                    {{ csrf_field() }}
                                    @method('PUT')
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="control-label">Parent Module Name</label>
                                                <select class="form-control" name="parent_module_id" disabled="">
                                                    <option value="">--- Select Parent Module Name ---</option>
                                                    @foreach($rows as $key=>$row)
                                                    <option value="{{ $row['module_id'] }}" {{ $row['module_id'] ==  $one_row[0]['parent_module_id'] ? 'selected':'' }}>{{ $row['module_name'] }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="control-label">Module Name <span style="color: red;font-size: 16px;">*</span></label>
                                                <input class="form-control" type="text" id="module_name" name="module_name" placeholder="Enter Module Name" value="{{ $one_row[0]['module_name'] }}">
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="control-label">Icon Class Name <span style="color: red;font-size: 16px;">*</span></label>
                                                <input class="form-control" type="text" id="class_name" name="class_name" placeholder="Enter Class Name" value="{{ $one_row[0]['class_name'] }}" autocomplete="off">
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="control-label">Display Order </label>
                                                <input class="form-control" type="text" id="display_order" name="display_order" placeholder="Enter Display Order" value="{{ $one_row[0]['display_order'] }}">
                                            </div>
                                        </div>

                                        <input class="form-control" type="hidden" id="module_id" name="module_id" placeholder="Enter Module Name" value="{{ $one_row[0]['module_id'] }}">
                                    </div>

                                    <!-- BUTTON ROW – inline on mobile -->
                                    <div class="row text-center">
                                        <div class="col-md-12">
                                            <button type="button" class="btn btn-success btn-space" onclick="editbuttonclick('{{$one_row[0]['module_id']}}')">Update</button>
                                            <a class="btn btn-danger" href="{{ route('uam_modules.index') }}"><i class="fa fa-times" aria-hidden="true"></i> Cancel</a>&nbsp;
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
</div>

<!-- Your existing scripts (unchanged) -->
<script src="https://cdn.jsdelivr.net/jquery.validation/1.15.1/jquery.validate.min.js"></script>
<script type="text/javascript">
    $("#module_name").keypress(function(event) {
        var inputValue = event.charCode;
        if (!(inputValue >= 65 && inputValue <= 120) && (inputValue != 32 && inputValue != 0)) {
            event.preventDefault();
        }
    });
</script>
<script>
    function editbuttonclick(id) {
        
        var module_name = $('#module_name').val();
        if (module_name == '') {
            swal("Please Enter Module Name ", "", "error");
            return false;
        }

        var class_name = $('#class_name').val();
        if (class_name == '') {
            swal("Please Enter class Name ", "", "error");
            return false;
        }

        document.getElementById('edit_module_form' + id).submit();
    }
</script>
@endsection