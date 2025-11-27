@extends('layouts.adminnav')

@section('content')
<style>



</style>
<div class="main-content" style="position:absolute; z-index:-1">
<section class="section">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.16/dist/sweetalert2.all.min.js"></script>

{{ Breadcrumbs::render('compassmeeting.index') }}
@if (session('success'))
                    <input type="hidden" name="session_data" id="session_data" class="session_data" value="{{ session('success') }}">
                    <script type="text/javascript">
                        window.onload = function() {
                            var message = $('#session_data').val();
                            Swal.fire({
                                title: "Success",
                                text: message,
                                icon: "success",
                            });
                        }
                    </script>
                    @elseif(session('fail'))
                    <input type="hidden" name="session_data" id="session_data1" class="session_data" value="{{ session('fail') }}">
                    <script type="text/javascript">
                        window.onload = function() {
                            var message = $('#session_data1').val();
                            Swal.fire({
                                title: "Info",
                                text: message,
                                type: "info",
                            });
                        }
                    </script>
                    @endif
    <div class="section-body mt-2">
      

        <div class="row">

          <div class="col-12">
           
            <div class="card">

              <div class="card-body">
                <div class="row">
                  <div class="col-lg-12 text-center">
                    <h4 style="color:darkblue;">Orientation Meeting List View</h4>
                  </div>

                </div>
         

                



                <div class="table-wrapper">
                  <div class="table-responsive">
                    <table class="table table-bordered" id="align">
                      <thead>
                        <tr>
                          <th width="7%">Sl. No.</th>
                          <th width="17%">ORM ID</th>
                          <th width="7%">Child Name</th>
                          <th width="15%">Enrollement Id</th>
                          <th width="10%">IS Coordinators</th>
                          <th width="14%">Therapist</th>
                          <th width="10%">Meeting Date & Time</th>                                          
                          <th width="7%">Status</th>
                          <th width="13%">Action</th>                      
                        </tr>
                      </thead>
                      <tbody>
                      <td>1</td>
                          <td>ORM/2022/12/001</td>
                          <td>Kaviya</td>
                          <td>EN/2022/12/025</td>
                          <td>Robert</td>
                          <td>Malini(ST)</td>
                          <td>2023-01-23&12:00:00</td>                                          
                          <td>Sent</td>
                          <td>
                          <a class="btn btn-link" title="Show" href="{{ route('compassmeeting.show', 1) }}" ><i class="fas fa-eye" style="color: blue !important"></i></a>
                           <a class="btn btn-link" title="Edit" href="{{ route('compassmeeting.edit', 1) }}" ><i class="fas fa-pencil-alt" style="color:green"></i></a>
                          </td>      
                        
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
      Swal.fire({
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
     swal("Shortlisted!", "Candidates are successfully shortlisted!", "success");
     var url = $('#' + id).val();
                  window.location.href = url;

    } else {
      swal("Cancelled", "Your imaginary file is safe :)", "error");
         e.preventDefault();
    }
 });


    }

    
</script>


<script>
window.onload = function() { 

  Swal.fire({
        
        text: "Orientation Meeting for EN/2022/12/025(Kaviya) Saved Successfully",
        type: "info",
        icon: "warning",
      });

}

</script>

@endsection
