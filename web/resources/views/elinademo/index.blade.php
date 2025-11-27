@extends('layouts.adminnav')

@section('content')
<style>
.btn{
  padding:0.1rem 0.1rem !important;
}


</style>
<div class="main-content">
<section class="section">


    <div class="section-body mt-2">
      

        <div class="row">

          <div class="col-12">
           
            <div class="card">

              <div class="card-body">
                <div class="row">
                  <div class="col-lg-12 text-center">
                    <h4 style="color:darkblue;"> Elina Demo List View</h4>
                  </div>

                </div>
                

                



                <div class="table-wrapper">
                  <div class="table-responsive">
                    <table class="table table-bordered" id="align">
                      <thead>
                        <tr>
                          <th width="50px">Sl. No.</th>
                          <th width="120px">Enrollment Id</th>
                          <th width="80px">Child Name</th>
                          <th>IS Coordinater Name</th>
                          <th>Subject and Meeting Date & Time</th>                                          
                          <th>Status</th>
                          <th>Action</th>                      
                        </tr>
                      </thead>
                      <tbody>
                      @foreach($rows as $key=>$row) 
                        <tr>
                          
                            <td>{{ $loop->iteration}}</td>  
                            <td>{{ $row['enrollment_id']}}</td>
                            <td>{{ $row['child_name']}}</td>
                            <td>{{$row['is_coordinator1']}}</td>
                            <td>{{ $row['meeting_subject']}}{{ $row['meeting_startdate']}} & {{ $row['meeting_starttime']}}</td>
                            <td>{{ $row['meeting_status']}}</td>
                            
                            

                          <td class="text-center">

                            
                                
                               
                                
                            <a class="btn btn-link" title="Show" href="{{ route('elinademo.show', $row['demo_parent_details_id'])}}"><i class="fas fa-eye" style="color: blue !important"></i></a>
                            <a class="btn btn-link" title="Edit" href="{{ route('elinademo.edit', $row['demo_parent_details_id']) }}"><i class="fas fa-pencil-alt" style="color: blue !important"></i></a>
                                                 
                            <input type="hidden" name="delete_id" id="<?php echo $row['demo_parent_details_id']; ?>" value="{{ route('elinademo.delete', $row['demo_parent_details_id']) }}">
                                                                            
                                <a class="btn btn-light"  title="Delete" onclick="return myFunction(<?php echo $row ['demo_parent_details_id']; ?>);" class="btn btn-link"><i class="far fa-trash-alt"></i></a>
                                                                           
                                
                            
                              

                               
                              

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


</section>






</div>                                                    



<script src="https://code.jquery.com/jquery-1.7.2.min.js"></script>
<script type="application/javascript">
    
    function myFunction(id) {
     swal({
    title: "Confirmation For Delete ?",
    text: "Are You Sure to delete this data.",
    type: "warning",
    showCancelButton: true,
    confirmButtonColor: '#DD6B55',
    confirmButtonText: 'Yes, I am sure!',
    cancelButtonText: "No, cancel it!",
    closeOnConfirm: false,
    closeOnCancel: false
 },
 function(isConfirm){

   if (isConfirm){
     swal("Deleted!", "Data Deleted successfully!", "success");
     var url = $('#' + id).val();
    
                  window.location.href = url;

    } else {
      swal("Cancelled", "Your file is safe :)", "error");
         e.preventDefault();
    }
 });


    }
</script>













@endsection
