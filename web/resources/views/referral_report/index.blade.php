@extends('layouts.adminnav')

@section('content')
<style>



</style>
<div class="main-content">
  {{ Breadcrumbs::render('referralreport.index') }}
  <section class="section">

    @if (session('success'))

    <input type="hidden" name="session_data" id="session_data" class="session_data" value="{{ session('success') }}">
    <script type="text/javascript">
      window.onload = function() {
        var message = $('#session_data').val();
        swal.fire("Success", message, "success");

      }
    </script>
    @elseif(session('fail'))

    <input type="hidden" name="session_data" id="session_data1" class="session_data" value="{{ session('error') }}">
    <script type="text/javascript">
      window.onload = function() {
        var message = $('#session_data1').val();
        swal.fire("Info", message, "info");

      }
    </script>
    @endif
    <div class="section-body mt-2">


      <div class="row">

        <div class="col-12">
          <a type="button" href="{{ route('referralreport.create') }}" value="Cancel" class="btn btn-labeled btn-info" title="create" style="background: #044a95 !important; border-color:#a9ca !important; color:white !important;margin-top: 0.5rem;">
            <span class="btn-label" style="font-size:15px !important; padding:8px !important"><i class="fa fa-plus"></i></span><span style="font-size:15px !important; padding:8px !important">New Referral Report</span></a>
          <div class="card">

            <div class="card-body">
              <div class="row">
                <div class="col-lg-12 text-center">
                  <h4 style="color:darkblue;">Referral Report List view</h4>
                </div>

              </div>






              <div class="table-wrapper">
                <div class="table-responsive">
                  <table class="table table-bordered" id="align">
                    <thead>
                      <tr>
                        <th>Sl. No.</th>
                        <th>Enrollment Id</th>
                        <th>Child Name</th>
                        <th>Report</th>
                        <th>Status</th>
                        <th>Action</th>
                      </tr>
                    </thead>
                    <tbody>
                      @foreach($rows as $data)
                      <tr>

                        <td>{{$loop->iteration}}</td>
                        <td>{{$data['enrollment_child_num']}}</td>
                        <td>{{$data['child_name']}}</td>
                        <td>Referral Report</td>
                        <td>{{$data['status']}}</td>
                        <td class="text-center">

                          @if($data['status'] != 'Published')
                          <a class="btn btn-link" title="Edit" href="{{ route('referralreport.edit', \Crypt::encrypt($data['id'])) }}"><i class="fas fa-pencil-alt" style="color: blue !important"></i></a>
                          @endif
                          @if($data['status'] == 'Published')
                          <a class="btn btn-link" title="Show" href="{{ route('referralreport.show', \Crypt::encrypt($data['id'])) }}"><i class="fas fa-eye" style="color: green !important"></i></a>
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
          swal.fire("Deleted!", "Data Deleted successfully!", "success");
          var url = $('#' + id).val();

          window.location.href = url;

        } else {
          swal.fire("Cancelled", "Your file is safe :)", "error");
          e.preventDefault();
        }
      });


  }
</script>

@endsection