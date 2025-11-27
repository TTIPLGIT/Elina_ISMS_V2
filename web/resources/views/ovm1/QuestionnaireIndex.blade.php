@extends('layouts.adminnav')
@section('content')

<div class="main-content">
{{ Breadcrumbs::render('ovm.questionnaire') }}
  <section class="section">
    <div class="section-body mt-2">
      @if (session('success'))
      <input type="hidden" name="session_data" id="session_data" class="session_data" value="{{ session('success') }}">
      <script type="text/javascript">
        window.onload = function() {
          var message = $('#session_data').val();
          Swal.fire('Success!',message,'success');
        }
      </script>
      @elseif(session('fail'))
      <input type="hidden" name="session_data" id="session_data1" class="session_data" value="{{ session('fail') }}">
      <script type="text/javascript">
        window.onload = function() {
          var message = $('#session_data1').val();
          Swal.fire('Info!',message,'info');
        }
      </script>
      @endif
      <div class="row">

        <div class="col-12">
          <a type="button" href="{{route('ovm.questionnaire.initiate')}}" value="" class="btn btn-labeled btn-info" title="create" style="background: #044a95 !important; border-color:#a9ca !important; color:white !important;margin-top: 0.5rem;">
            <span class="btn-label" style="font-size:15px !important; padding:8px !important"><i class="fa fa-plus"></i></span><span style="font-size:15px !important; padding:8px !important">Initiation</span></a>
          <div class="card">

            <div class="card-body">

              <div class="row">

                <div class="col-lg-12 text-center">
                  <h4 style="color:darkblue;"> Parent Feedback List View</h4>
                </div>

              </div>

              <div class="table-wrapper">
                <div class="table-responsive">
                  <table class="table table-bordered" id="align">
                    <thead>
                      <tr>
                        <th>Sl.No.</th>
                        <th>Enrollment Id</th>
                        <th>Child Name</th>
                        <th>Stage</th>
                        <th>Questionnaire Name</th>
                        <th>Status</th>
                        <th>Action</th>
                      </tr>
                    </thead>
                    <tbody>
                      @foreach($rows as $key=>$row)
                      <tr>
                        <td>{{ $loop->iteration}}</td>
                        <td>{{$row['enrollment_child_num']}}</td>
                        <td>{{$row['child_name']}} </td>
                        <td>OVM</td>
                        <td>{{$row['questionnaire_name']}}</td>
                        @if($row['questatus'] == 'Save')
                        <td>In-Progress</td>
                        @else
                        @if(in_array($user_id , explode(',', $row['viewed_users']) ))
                          <td>Viewed</td>
                          @else
                          <td>{{$row['questatus']}}</td>
                          @endif
                        @endif
                        <td class="text-center">
                          @if($row['questatus'] == 'Submitted')
                          <a class="btn btn-link" title="Show" id="{{$row['questionnaire_initiation_id']}}" href="{{ route('questionnaire.submitted.form', \Crypt::encrypt($row['questionnaire_initiation_id'])) }}"><i class="fas fa-eye" style="color: blue !important"></i></a>
                          <!-- <a class="btn btn-link" title="Show" href="{{ route('sail.show', \Crypt::encrypt($row['questionnaire_initiation_id'])) }}"><i class="fas fa-eye" style="color: blue !important"></i></a> -->
                          @endif
                          <!-- @if($row['questatus'] == 'Saved')
                          <a class="btn btn-link" title="Edit" href="{{ route('sail.edit', \Crypt::encrypt($row['questionnaire_initiation_id']))}}"><i class="fas fa-pencil-alt" style="color: blue !important"></i></a>
                          @endif -->
                          @if($row['questatus'] != 'Submitted')
                          <input type="hidden" name="delete_id" id="<?php echo $row['questionnaire_initiation_id']; ?>" value="{{ route('sail.delete', \Crypt::encrypt($row['questionnaire_initiation_id'])) }}">
                          <a class="btn btn-link" title="Delete" onclick="return myFunction(<?php echo $row['questionnaire_initiation_id']; ?>);" class="btn btn-link"><i class="far fa-eye"></i></a>
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
    </div>
  </section>
</div>

<script src="https://code.jquery.com/jquery-1.7.2.min.js"></script>
<script type="application/javascript">
  function myFunction(id) {
    swal.fire("The parent has not yet submitted the questionnaire.", "", "info");

    // swal.fire({
    //   title: "Confirmation For Delete ?",
    //   text: "Are You Sure to delete this data.",
    //   type: "warning",
    //   showCancelButton: true,
    //   confirmButtonColor: '#DD6B55',
    //   confirmButtonText: 'Yes, I am sure!',
    //   cancelButtonText: "No, cancel it!",
    //   closeOnConfirm: false,
    //   closeOnCancel: false
    // }).then((result) => {
    //   if (result.value) {
    //     swal.fire("Deleted!", "Data Deleted successfully!", "success");
    //     var url = $('#' + id).val();
    //     window.location.href = url;
    //   }
    // })

  }
</script>
@endsection