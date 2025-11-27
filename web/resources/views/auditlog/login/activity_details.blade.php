@extends('layouts.adminnav')

@section('content')
<
<div class="main-content">
  <section class="section">

  {{ Breadcrumbs::render('activitylog.index') }}
    <div class="section-body mt-2">
    
@if ($message = Session::get('error'))
<div class="alert alert-warning">
  <p>{{ $message }}</p>
</div>
@endif
<div class="row">

<div class="col-12">
 
  <div class="card">

    <div class="card-body">
   
    
   

        <div class="row">   
    <div class="col-md-12">
        <div class="tile">
            <!-- <h3 class="tile-title">Forms Search</h3> -->
            <div class="tile-body">
                             
            <form class="form-horizontal" id="activity_details" name="activity_details" method="POST" action="{{ route('auditlog.activity') }}" onsubmit="return validateForm()">
                @csrf
                <div class="row">
                   <div class="col-md-4">
                    <div class="form-group">
                        <label class="control-label">Users</label>
                        <select name="user_id" id="user_id" class="form-control">
                           <option value="">{{ __('--- Select Users ---') }}</option>
                               
                           @foreach($data2['rows1'] as $key=>$row)
            
                           <option value="{{ $row['id'] }}" {{ $row['id']  ==$user_id ? 'selected':''}}>{{ $row['name'] }}</option>
                        
                           @endforeach
                       </select>
                   </div>
               </div>
               <div class="col-md-4">
                <div class="form-group">
                    <label class="control-label">From Date</label>
                    <input class="form-control" type="date" id="receipt_no" name="receipt_no"  placeholder="Enter receipt #" value="{{ $receipt_no }}">
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label class="control-label">To Date</label>
                    <input class="form-control" type="date" id="received_for" name="received_for"  placeholder="Enter received for" value="{{ $received_for }}">
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">

                    <label class="control-label">Process Type</label>
                    <select name="source_type" id="source_type" class="form-control" onchange="source_type_select()">

                     <option value="">{{ __('--- Select Process Type ---') }}</option>
                 }
                 <option value="UAM" {{ ( $source_type == 'UAM') ? 'selected' : '' }}>UAM</option>
                 <option value="Masters" {{ ( $source_type == 'Document Process') ? 'selected' : '' }}>Masters</option>
                    </select>
                </div>
            </div>
            <div class="col-md-4" id="uam_action_tab" style='display:none;'/>
                <div class="form-group">
                    <label class="control-label">UAM Actions</label>

                    <select name="uam_action" id="uam_action" class="form-control" >
                         <option value="">{{ __('--- Select Actions ---') }}</option>
                         <option value="Create" {{ ( $uam_action == 'Create') ? 'selected' : '' }}>Create</option>
                         <option value="Update" {{ ( $uam_action == 'Update') ? 'selected' : '' }}>Update</option>
                         <option value="Delete" {{ ( $uam_action == 'Delete') ? 'selected' : '' }}>Delete</option>

                    </select>
                </div>
            </div>
            <div class="col-md-4" id="master_action_tab" style='display:none;'/>
                <div class="form-group">
                    <label class="control-label">Masters Actions</label>

                    <select name="uam_action" id="uam_action" class="form-control" >
                        <option value="">{{ __('--- Select Actions ---') }}</option>
                        <option value="Create" {{ ( $uam_action == 'Create') ? 'selected' : '' }}>Create</option>
                        <option value="Update" {{ ( $uam_action == 'Update') ? 'selected' : '' }}>Update</option>
                        <option value="Delete" {{ ( $uam_action == 'Delete') ? 'selected' : '' }}>Delete</option>

                    </select>
                </div>
            </div>
            

<div class="row text-center">
    <div class="col-md-12">

        <button class="btn btn-success" type="submit"><i class="fa fa-fw fa-lg fa-search"></i>&nbsp;&nbsp; Search Details</button>&nbsp;
        <!-- <input class="btn btn-primary" type="reset" value="Reset"> -->

    </div>                
</div>
</form>
</div>
</div>
</div>
</div>


<!-- <a style="margin-left: 15px;" type="button" class="btn btn-primary"  href="{{config('setting.base_url')}}get_activityandoperationreport/{{ $receipt_no? $receipt_no:'1'}}/{{ $received_for? $received_for:'1'}}/{{ $user_id? $user_id: '1' }}/{{ $source_type? $source_type: '1' }}/{{ $uam_action? $uam_action: '1' }}/{{ $workflow_action? $workflow_action: '1' }}/{{ $form_action? $form_action: '1' }}">PDF Download</a> -->
<div class="row">
    <div class="col-md-12 content-bottom-position">
        <div class="tile title-padding">
            <div class="table-responsive">
                <table class="display custom-responsive-table table table-hover table-bordered table-custom-list" id="align">
                    <thead>
                        <tr>
                            <th width="50px">Sl. No.</th>
                            <th width="110px">Audit Id</th>
                            <th>Module Name</th> 
                            <th>Action Date and Time</th>
                            <th>Audit Action</th>
                            <th>User Name</th>
                            <th>Role Name</th>
                            
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($data2['rows'] as $key=>$row)
                        <tr>
                            <td>{{ ++$key }}</td>   
                            <td>Audit#00{{ $key }}</td>
                            <td>{{ $row['module_name'] }}</td>
                            <td>{{ $row['action_date_time'] }}</td>
                            <td>{{ $row['description']}}</td>
                            <td>{{ $row['name'] }}</td>
                            <td>{{ $row['role_name'] }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>







@if (session('success'))


<input type="hidden" name="session_data" id="session_data" class="session_data" value="{{ session('success') }}">
<script type="text/javascript">
    window.onload = function(){
       var message = $('#session_data').val();

       bootbox.alert({
        title: "Success",
        centerVertical: true,
        message: message
    });
   }
</script>
@endif


@if (session('failed'))
<input type="hidden" name="session_data" id="session_data" class="session_data" value="{{ session('failed') }}">
<script type="text/javascript">
    window.onload = function(){
       var message = $('#session_data').val();

       bootbox.alert({
        title: "Success",
        centerVertical: true,
        message: message
    });
   }
</script>
@endif


<script src="{{ asset('js/table2excel.js') }}" type="text/javascript"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>

<script type="text/javascript">
    function source_type_select()
    {

      var inputvalue = document.getElementById("source_type").value;
 // alert(inputvalue)
 if( inputvalue==="UAM"){

    $("#uam_action_tab").show();
    $("#master_action_tab").hide();
    $("#form_action_tab").hide();
    $("#department_action_tab").hide();

}
if( inputvalue==="Masters"){

    $("#uam_action_tab").hide();
    $("#master_action_tab").show();
    $("#form_action_tab").hide();
    $("#department_action_tab").hide();

}
if( inputvalue==="Work Flow"){

    $("#uam_action_tab").hide();
    $("#workflow_action_tab").show();
    $("#form_action_tab").hide();
    $("#department_action_tab").hide();

}
if( inputvalue==="Department"){

    $("#uam_action_tab").hide();
    $("#workflow_action_tab").hide();
    $("#form_action_tab").hide();
    $("#department_action_tab").show();

}
if( inputvalue===""){

    $("#uam_action_tab").hide();
    $("#workflow_action_tab").hide();
    $("#form_action_tab").hide();
    $("#department_action_tab").hide();

}


}
window.onload = function(){
    var inputvalue=$('#source_type :selected').text();

    if( inputvalue==="UAM"){

        $("#uam_action_tab").show();
        $("#workflow_action_tab").hide();
        $("#form_action_tab").hide();
        $("#department_action_tab").hide();

    }
    if( inputvalue==="Document Process"){

        $("#uam_action_tab").hide();
        $("#workflow_action_tab").hide();
        $("#form_action_tab").show();
        $("#department_action_tab").hide();

    }
    if( inputvalue==="Work Flow"){

        $("#uam_action_tab").hide();
        $("#workflow_action_tab").show();
        $("#form_action_tab").hide();
        $("#department_action_tab").hide();

    }
    if( inputvalue==="Department"){

        $("#uam_action_tab").hide();
        $("#workflow_action_tab").hide();
        $("#form_action_tab").hide();
        $("#department_action_tab").show();

    }
    if( inputvalue===""){

        $("#uam_action_tab").hide();
        $("#workflow_action_tab").hide();
        $("#form_action_tab").hide();
        $("#department_action_tab").hide();

    }

}
</script>
<script type="text/javascript">
  $(document).ready(function() {
   var currentDate = new Date();
   var day = currentDate.getDate();

   var month = String(currentDate.getMonth() + 1).padStart(2, '0');
   var year = currentDate.getFullYear();
   var d = day + "" + month + "" + year;
   $('#listDataTable1').DataTable( {
    dom: 'Bfrtip',
    buttons: [{ extend: 'excel',
    text: '<i class="fa fa-file-excel-o" aria-hidden="true"></i>Excel Export',
    title: 'Active /Operation Details'+d}
            // 'copy', 'csv', 'excel', 'pdf', 'print'
            
            ]
        } );
} );
</script>
<script>
    if ( window.history.replaceState ) {
      window.history.replaceState( null, null, window.location.href );
  }
</script>

<script>

  $(document).on('change', '#receipt_no', function(){

    var startDate = document.getElementById("receipt_no").value;
    var endDate = document.getElementById("received_for").value;

    if (endDate =='') 
    {

    }
    else
    {

        document.getElementById("received_for").value = "";


    }

});
  $(document).on('change', '#received_for', function(){

    var startDate = document.getElementById("receipt_no").value;
    var endDate = document.getElementById("received_for").value;

    if (endDate =='') 
    {

    }
    else
    {
       var start_date = new Date(startDate); 
       var end_date = new Date(endDate); 


       if (start_date > end_date)  
       {
         swal("Invalid End Date", "", "error");
         document.getElementById("received_for").value = "";
         return false;
     }
 }

});




  function validateForm() {

   let user_id = document.forms["activity_details"]["user_id"].value;

   let receipt_no = document.forms["activity_details"]["receipt_no"].value;

   let received_for = document.forms["activity_details"]["received_for"].value;

   let source_type = document.forms["activity_details"]["source_type"].value;


   if (user_id == "" && receipt_no == "" && received_for == "" && source_type == "") {
      bootbox.alert({
         title: "Active/Operation Details",
         centerVertical: true,
         message: "No Input for Search",
     });
      return false;
  }

}



</script>



@endsection