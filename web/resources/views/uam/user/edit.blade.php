@extends('layouts.adminnav')

@section('content')
<div class="main-content">
<style>
  #roles_id{
    pointer-events: none;
  }
</style>
  <!-- Main Content -->
  <section class="section">

    {{ Breadcrumbs::render('user.edit',$one_row[0]['id']) }}

    <div class="section-body mt-1">
      <h5 style="color:darkblue;text-align:center">User Edit</h5>



      <div class="row">

        <div class="col-12">

          <div class="card">
            <div class="card-body">
              <form class="form-horizontal" name="uam_modules" method="POST" action="{{ route('update_user_data') }}">

                @csrf
                <div class="row">


                  <input class="form-control" type="hidden" id="user_id" name="user_id" placeholder="Enter Module Name" value="{{ $one_row[0]['id']}}">


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
                        <div class="row">
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




                  {{-- <div class="col-md-12">

                    <div class="form-group">
                      <label class="control-label">Directorate and Department <span style="color: red;font-size: 16px;">*</span></label>


                      <div id="treeview_container" class="hummingbird-treeview well h-scroll-large">

                        <ul id="treeview" class="hummingbird-base">
                          @if($parent_folder !="")
                          @foreach ($parent_folder as $key => $parent_folder_value)
                          <li>
                            <i class="fa fa-plus"></i> <label> <input id="node-{{ $parent_folder_value['document_folder_structure_id'] }}" data-id="{{ $parent_folder_value['document_folder_structure_id'] }}" type="checkbox" module="{{ $parent_folder_value['document_folder_structure_id'] }}"> {{ $parent_folder_value['folder_name'] }} </label>
                  <ul>

                    @if($directorate !="")
                    @foreach ($directorate as $key => $directorate_value)
                    @if($parent_folder_value['document_folder_structure_id'] == $directorate_value['parent_document_folder_structure_id'])

                    <li><i class="fa fa-plus"></i> <label> <input id="node-{{$directorate_value['parent_document_folder_structure_id'] }}-{{$directorate_value['id'] }}" data-id="{{$directorate_value['parent_document_folder_structure_id'] }}-{{$directorate_value['id'] }}" module="{{$directorate_value['parent_document_folder_structure_id'] }}" type="checkbox"> {{$directorate_value['folder_name'] }}</label>
                      <ul>

                        @if($department !="")
                        @foreach ($department as $key => $department_value)
                        @if($directorate_value['id']== $department_value['parent_document_folder_structure_id'])

                        <li><i class="fa fa-plus"></i> <label><input id="node-{{$department_value['parent_document_folder_structure_id']}}-{{$department_value['id'] }}" data-id="{{$department_value['parent_document_folder_structure_id']}}:{{$department_value['id'] }}" type="checkbox"> {{$department_value['folder_name'] }} </label>
                          <ul>


                            @if($sub_department !="")
                            @foreach ($sub_department as $key => $sub_department_value_one)
                            @if($department_value['id'] == $sub_department_value_one['parent_document_folder_structure_id'])

                            <li> <i class="fa fa-plus"></i> <label><input id="node1-{{$sub_department_value_one['parent_document_folder_structure_id'] }}-{{$sub_department_value_one['id'] }}" data-id="{{$sub_department_value_one['parent_document_folder_structure_id'] }}:{{$sub_department_value_one['id']}}" type="checkbox"> {{$sub_department_value_one['folder_name'] }} </label>
                              <!-- sub -->
                              <ul>
                                @if($sub_department !="")
                                @foreach ($sub_department as $key => $sub_department_value_two)
                                @if($sub_department_value_one['documentfolderid'] == $sub_department_value_two['parent_document_folder_structure_id'])

                                <li><label><input class="hummingbird-end-node" id="node1-{{$sub_department_value_one['parent_document_folder_structure_id'] }}-{{$sub_department_value_one['id'] }}-{{$sub_department_value_two['id'] }}" data-id="{{$sub_department_value_two['parent_document_folder_structure_id'] }}:{{$sub_department_value_two['id'] }}" type="checkbox"> {{$sub_department_value_two['folder_name'] }} </label>
                                  @endif
                                  @endforeach
                                  @endif

                              </ul>
                              <!-- sub -->
                            </li>

                            @endif
                            @endforeach
                            @endif

                          </ul>
                        </li>

                        @endif
                        @endforeach
                        @endif

                      </ul>
                    </li>

                    @endif
                    @endforeach
                    @endif
                  </ul>
                  </li>
                  @endforeach
                  @endif
                  </ul>
                </div>
            </div>
            @error('directorate_department')
            <div class="error">{{ $message }}</div>
            @enderror

          </div>


          <input id="displayItems" name="displayItems" class="form-control" type="hidden">


          <input id="displayItems1" name="directorate_department" class="form-control" type="hidden">
          <input id="displayItems2" name="displayItems2" class="form-control" type="hidden">
          <div class="para"></div>
          <input class="form-control" type="hidden" id="parent_node_id" name="parent_node_id" placeholder="Enter Password" value="{{ $document_folder_structure_id }}">
          <input class="form-control" type="hidden" id="user_type" name="user_type" placeholder="Enter Password" value="AD">
        </div>--}}
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





    // var array_designation = { !!json_encode($one_row[0]->array_dashboard_list) !! };
    // var clean = array_designation.split();
    // var string = JSON.stringify(clean);
    // var newxcv = string.replace(/["]/g, '');
    // var ncd = JSON.parse(newxcv);
    // $('.js-select5').val(ncd);
    $(".js-select5").select2({
      closeOnSelect: false,
      placeholder: " Please Select Designation ",
      allowHtml: true,
      allowClear: true,
      tags: true // создает новые опции на лету
    });



    // var array_roles = <?php echo (json_encode($one_row)); ?>
    // var clean = array_roles.split();
    // var string = JSON.stringify(clean);
    // var newxcv = string.replace(/["]/g, '');
    // var ncd = JSON.parse(newxcv);
    // $('.roles_id').val(ncd);
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