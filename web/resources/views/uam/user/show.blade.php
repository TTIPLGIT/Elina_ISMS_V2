@extends('layouts.adminnav')

@section('content')
<style>
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
  }
</style>

<div class="main-content">
  <!-- Main Content -->
  <section class="section">
    {{ Breadcrumbs::render('user.show',$one_row[0]['id']) }}

    <div class="section-body mt-1">
      <h5 class="text-center" style="color:darkblue;">User Show</h5>

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
                      <input class="form-control" type="text" id="name" name="name" placeholder="Enter User Name" value="{{ $one_row[0]['name']}}" disabled="">
                      @error('name')
                      <div class="error">{{ $message }}</div>
                      @enderror
                    </div>
                    <div class="form-group col-md-6">
                      <label class="control-label">Email <span style="color: red;font-size: 16px;">*</span></label>
                      <input class="form-control" type="email" id="email" name="email" placeholder="Enter Email" value="{{ $one_row[0]['email'] }}" disabled="">
                      @error('email')
                      <div class="error">{{ $message }}</div>
                      @enderror
                    </div>

                    <div class="form-group col-md-6">
                      <label class="control-label">Roles <span style="color: red;font-size: 16px;">*</span></label>
                      <select class="form-control" name="roles_id" disabled>
                        <option value="">Please Select Role</option>
                        @foreach($rows_data as $key=>$row_data)
                        <option value="{{ $row_data['role_id'] }}" {{ $row_data['role_id'] ==  $one_row[0]['array_roles'] ? 'selected':'' }}>{{ $row_data['role_name'] }}</option>
                        @endforeach
                      </select>
                      @error('roles_id')
                      <div class="error">{{ $message }}</div>
                      @enderror
                    </div>

                    <div class="form-group col-md-6">
                      <label class="control-label">Designation <span style="color: red;font-size: 16px;">*</span></label>
                      <select class="form-control" name="designation" disabled>
                        <option value="">Please Select Designation</option>
                        @foreach($designation as $key=>$row)
                        <option value="{{ $row['designation_id'] }}" {{ $row['designation_id'] ==  $one_row[0]['designation_id'] ? 'selected':'' }}>{{ $row['designation_name'] }}</option>
                        @endforeach
                      </select>
                      @error('designation')
                      <div class="error">{{ $message }}</div>
                      @enderror
                    </div>

                    <div class="form-group col-md-6" style="display: none;">
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

                  {{-- The commented-out treeview section remains as is --}}
                  {{-- ... --}}
                </div>

                <div class="row text-center">
                  <div class="col-md-12">
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
  document.getElementById("checkbox").checked = true;
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
    var array_roles = <?php echo (json_encode($one_row)); ?>
    var clean = array_roles.split();
    var string = JSON.stringify(clean);
    var newxcv = string.replace(/["]/g, '');
    var ncd = JSON.parse(newxcv);
    $('.roles_id').val(ncd);
    $(".js-select2").select2({
      closeOnSelect: false,
      placeholder: " Please Select Roles ",
      allowHtml: true,
      allowClear: true,
      tags: true
    });

    var array_designation = {
      !!json_encode($one_row[0] - > array_dashboard_list) !!
    };
    var clean = array_designation.split();
    var string = JSON.stringify(clean);
    var newxcv = string.replace(/["]/g, '');
    var ncd = JSON.parse(newxcv);
    $('.js-select5').val(ncd);
    $(".js-select5").select2({
      closeOnSelect: false,
      placeholder: " Please Select Designation ",
      allowHtml: true,
      allowClear: true,
      tags: true
    });
  });
</script>

<script type="text/javascript">
  $(document).ready(function() {
    $("#treeview_example_code_button").on("click", function() {
      var that_code = $("#treeview_example_code");
      that_code.toggle();
      var that_code_display = that_code.css("display");
      if (that_code_display == "none") {
        $(this).text("Show HTML");
      } else {
        $(this).text("Hide HTML");
      }
    });

    $("#treeview_example_search_html").on("click", function() {
      var that_code = $("#treeview_example_search_html_display");
      that_code.toggle();
      var treeview_example_search_html_mode = that_code.css("display");
      if (treeview_example_search_html_mode == "none") {
        $(this).text("Show HTML");
      } else {
        $(this).text("Hide HTML");
      }
    });

    $("#treeview_example_search_css").on("click", function() {
      var that_code = $("#treeview_example_search_css_display");
      that_code.toggle();
      var treeview_example_search_css_mode = that_code.css("display");
      if (treeview_example_search_css_mode == "none") {
        $(this).text("Show CSS");
      } else {
        $(this).text("Hide CSS");
      }
    });

    var responseTime = [];
    var actualTime = [];
    var responseTimeSend = false;
    var responseTimeCounter = 0;

    var startTime, endTime;

    function measure_start() {
      startTime = new Date();
    };

    function measure_end() {
      endTime = new Date();
      var timeDiff = endTime - startTime;
      timeDiff /= 1000;
      var seconds = timeDiff;
      $("#time_measure").val(seconds + " sec");
    }

    $.fn.hummingbird.defaults.collapseAll = true;
    $.fn.hummingbird.defaults.checkboxes = "enabled";
    $.fn.hummingbird.defaults.checkDoubles = false;

    if ($("#checkbox_doubles").prop("checked") == true) {
      $.fn.hummingbird.defaults.checkDoubles = true;
    } else {
      $.fn.hummingbird.defaults.checkDoubles = false;
    }

    $("#treeview").hummingbird();
    $("#treeview2").hummingbird();
    $("#treeview2").hummingbird("expandNode", {
      attr: "id",
      name: "xnode-0-1",
      expandParents: true
    });
    $('#treeview2').css({
      "pointer-events": "none"
    });

    $("#treeview").hummingbird("expandNode", {
      attr: "id",
      name: "node-0",
      expandParents: true
    });

    $("#CheckAll").on("click", function() {
      measure_start();
      $("#treeview").hummingbird("checkAll");
      measure_end();
    });

    $("#UnCheckAll").on("click", function() {
      measure_start();
      $("#treeview").hummingbird("uncheckAll");
      measure_end();
    });

    $("#CollapseAll").on("click", function() {
      measure_start();
      $("#treeview").hummingbird("collapseAll");
      measure_end();
    });

    $("#ExpandAll").on("click", function() {
      measure_start();
      $("#treeview").hummingbird("expandAll");
      measure_end();
    });

    $("#checkNode").on("click", function() {
      measure_start();
      $("#treeview").hummingbird("checkNode", {
        attr: "id",
        name: $("#checkNodeOnID").val(),
        expandParents: false
      });
      measure_end();
    });

    $("#uncheckNode").on("click", function() {
      measure_start();
      $("#treeview").hummingbird("uncheckNode", {
        attr: "id",
        name: $("#uncheckNodeOnID").val(),
        collapseChildren: false
      });
      measure_end();
    });

    $("#expandNode").on("click", function() {
      measure_start();
      $("#treeview").hummingbird("expandNode", {
        attr: "id",
        name: $("#expandNodeOnID").val(),
        expandParents: true
      });
      measure_end();
    });

    $("#collapseNode").on("click", function() {
      measure_start();
      $("#treeview").hummingbird("collapseNode", {
        attr: "id",
        name: $("#collapseNodeOnID").val(),
        collapseChildren: true
      });
      measure_end();
    });

    $("#enableNode").on("click", function() {
      measure_start();
      var state = $("#enable_state_true").prop("checked");
      var enableChildren = $("#enable_state_true_children").prop("checked");
      $("#treeview").hummingbird("enableNode", {
        attr: "id",
        name: $("#enableNodeOnID").val(),
        state: state,
        enableChildren: enableChildren
      });
      measure_end();
    });

    $("#getItems").on("click", function() {
      measure_start();
      var List = {
        "id": [],
        "dataid": [],
        "text": [],
        "module": []
      };
      $("#treeview").hummingbird("getChecked", {
        list: List,
        onlyParents: true
      });
      $("#displayItems").val(List.dataid.join(","));
      var L = List.id.length;
      if (L == 1) {
        $("#num").val(L + " item checked");
      } else {
        $("#num").val(L + " items checked");
      }
    });

    $("#getItems").on("click", function() {
      measure_start();
      var List1 = {
        "id": [],
        "dataid": [],
        "text": [],
        "module": []
      };
      $("#treeview").hummingbird("getChecked", {
        list: List1,
        onlyEndNodes: true
      });
      $("#displayItems1").val(List1.dataid.join(":"));
      $("#displayItems2").val(List1.id.join("-"));
      var L = List1.id.length;
      if (L == 1) {
        $("#num").val(L + " item checked");
      } else {
        $("#num").val(L + " items checked");
      }
    });

    if ($("#checkbox_get_items").prop("checked") == true) {
      var List = {
        "id": [],
        "dataid": [],
        "text": [],
        "module": []
      };
      $("#treeview").hummingbird("getChecked", {
        list: List,
        onlyParents: true
      });
      $("#displayItems").val(List.dataid.join(","));
      var L = List.id.length;
      if (L == 1) {
        $("#num").val(L + " item checked");
      } else {
        $("#num").val(L + " items checked");
      }

      $("#treeview").on("CheckUncheckDone", function() {
        var List = {
          "id": [],
          "dataid": [],
          "text": [],
          "module": []
        };
        $("#treeview").hummingbird("getChecked", {
          list: List,
          onlyParents: true
        });
        $("#displayItems").val(List.dataid.join(","));
        var L = List.id.length;
        if (L == 1) {
          $("#num").val(L + " item checked");
        } else {
          $("#num").val(L + " items checked");
        }
      });

      $("#treeview").on("CheckUncheckDone", function() {
        var List1 = {
          "id": [],
          "dataid": [],
          "text": [],
          "dataid1": []
        };
        $("#treeview").hummingbird("getChecked", {
          list: List1,
          onlyEndNodes: true
        });
        $("#displayItems1").val(List1.id.join(":"));
        $("#displayItems2").val(List1.dataid.join("-"));
        var L = List1.id.length;
        if (L == 1) {
          $("#num").val(L + " item checked");
        } else {
          $("#num").val(L + " items checked");
        }
      });
    }

    $("#treeview").hummingbird("search", {
      treeview_container: "treeview_container",
      search_input: "search_input",
      search_output: "search_output",
      search_button: "search_button",
      scrollOffset: -515,
      onlyEndNodes: false
    });

    @if($one_row != "")
      @foreach($one_row as $row)
        $("#treeview").hummingbird("checkNode", {
          attr: "id",
          name: ["{{$row['id']}}"],
          expandParents: false
        });
      @endforeach
    @endif

    $("#treeview").hummingbird("collapseNode", {
      attr: "id",
      name: $("#collapseNodeOnID").val(),
      collapseChildren: true
    });
  });
</script>
@endsection