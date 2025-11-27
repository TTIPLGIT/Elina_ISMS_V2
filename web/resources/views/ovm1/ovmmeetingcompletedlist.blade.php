@extends('layouts.adminnav')

@section('content')
<style>



</style>
<div class="main-content">
  <section class="section">
  {{ Breadcrumbs::render('ovmmeetingcompleted') }}

    <div class="section-body mt-2">

    @if (session('success'))
                    <input type="hidden" name="session_data" id="session_data" class="session_data" value="{{ session('success') }}">
                    <script type="text/javascript">
                        window.onload = function() {
                            var message = $('#session_data').val();
                            swal.fire("Success", message,"success");
                        }
                    </script>
                    @elseif(session('fail'))
                    <input type="hidden" name="session_data" id="session_data1" class="session_data" value="{{ session('fail') }}">
                    <script type="text/javascript">
                        window.onload = function() {
                            var message = $('#session_data1').val();
                            swal.fire( "Info",message,"info");
                        }
                    </script>
                    @endif
      <div class="row">

        <div class="col-12">

          <div class="card">

            <div class="card-body">
              <div class="row">
                <div class="col-lg-12 text-center">
                  <h4 style="color:darkblue;">Conversation Summary List</h4>
                </div>

              </div>






              <div class="table-wrapper">
                <div class="table-responsive">
                  <table class="table table-bordered" id="align">
                    <thead>
                      <tr>
                        <th width="50px">Sl. No.</th>
                        <th>OVM ID</th>
                        <th>Child Name</th>
                        <th>Enrollment Id</th>

                        <th>Status</th>
                        <th>Action</th>
                      </tr>
                    </thead>
                    <tbody>
                     
                      @foreach($rows as $key=>$row)
                      <tr>

                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $row['ovm_meeting_unique']}}</td>
                        <td>{{ $row['child_name']}}</td>
                        <td>{{ $row['enrollment_id']}}</td>
                     

                        <td>{{ $row['status']}}</td>




                        <td class="text-center">

                          <form action method="POST" action="">


                          @php  $id =  Crypt::encrypt($row['ovm_meeting_id']); @endphp
                          @php $role = 'iscoordinator' @endphp
                            <a class="btn btn-labeled btn-warning" style="background: warning !important; border-color:warning !important; color:warning !important" title="Report" href="{{ route('ovmcompleted', ['id' => $id , 'role' => $role]) }}"><span class="btn-label" style="font-size:13px !important;"><i class="fa fa-file-o"></i></span>Report </a>


                            @csrf



                          </form>

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
    swal.fire({
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
      function(isConfirm) {

        if (isConfirm) {
          swal.fire("Shortlisted!", "Candidates are successfully shortlisted!", "success");
          var url = $('#' + id).val();
          alert(url);
          window.location.href = url;

        } else {
          swal.fire("Cancelled", "Your imaginary file is safe :)", "error");
          e.preventDefault();
        }
      });


  }
</script>

@endsection