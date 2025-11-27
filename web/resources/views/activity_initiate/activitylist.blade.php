@extends('layouts.adminnav')

@section('content')

<div class="main-content">
@if (session('success'))
  <input type="hidden" name="session_data" id="session_data" class="session_data" value="{{ session('success') }}">
  <script type="text/javascript">
    window.onload = function() {
      var message = $('#session_data').val();
      Swal.fire('Success!', message, 'success');
    }
  </script>
  @elseif(session('fail'))
  <input type="hidden" name="session_data" id="session_data1" class="session_data" value="{{ session('fail') }}">
  <script type="text/javascript">
    window.onload = function() {
      var message = $('#session_data1').val();
      Swal.fire('Info!', message, 'info');
    }
  </script>
  @endif
    {{ Breadcrumbs::render('activity_initiate.index') }}
    <div class="row">
        <div class="col-12">
            <a type="button" href="{{ route('activity_initiate.create') }}" value="Cancel" class="btn btn-labeled btn-info" title="create" style="background: #044a95 !important; border-color:#a9ca !important; color:white !important;margin-top: 0.5rem;">
                <span class="btn-label" style="font-size:15px !important; padding:8px !important"><i class="fa fa-plus"></i></span><span style="font-size:15px !important; padding:8px !important">Activity Initiation</span></a>
            <a type="button" href="{{ route('privacy.update',\Crypt::encrypt('2')) }}" value="Cancel" class="btn btn-labeled btn-info" title="create" style="background: #044a95 !important;float: right; border-color:#a9ca !important; color:white !important;margin-top: 0.5rem;">
                <span class="btn-label" style="font-size:15px !important; padding:8px !important;left: 0;background: none;">Privacy Agreement</span></a>
            <!-- <a type="button" style="font-size:15px;" class="btn btn-success btn-lg" title="Create" id="gcb" href="{{ route('newenrollment.create') }}">NewEnrollment<i class="fa fa-plus" aria-hidden="true"></i></a> -->
            <div class="card">
                <div class="card-body">
                <div class="col-lg-12 text-center">
            <h4 class="text-center" style="color:darkblue">Activity Initiated List</h4>
</div>
                    <div class="table-wrapper">
                        <div class="table-responsive">
                            <table class="table table-bordered" id="align1">
                                <thead>
                                    <tr>
                                        <th>Sl.No</th>
                                        <th>Enrollment ID</th>
                                        <th>Child Name</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($rows as $key=>$row)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $row['enrollment_child_num']}}</td>
                                        <td>{{ $row['child_name']}}</td>
                                        <td>
                                            @if($row['status'] != 'Complete' || $row['status'] != 'Close' )
                                            <a class="btn btn-link" title="Edit" href="{{route('activity_initiate.edit',\Crypt::encrypt($row['activity_initiation_id']))}}"><i class="fa fa-pencil-square-o" style="color:green"></i></a>
                                            @else
                                            <a class="btn btn-link" title="Show" href="{{route('activity_initiate.edit',\Crypt::encrypt($row['activity_initiation_id']))}}"><i class="fas fa-eye" style="color:green"></i></a>
                                            @endif
                                            <a class="btn btn-link" title="Face to Face Observation" href="{{route('activityinitiate.observation',\Crypt::encrypt($row['activity_initiation_id']))}}"><i class="fa fa-file-code-o" style="color:green"></i></a>

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

<script>
    var com = <?php echo (json_encode($com)); ?>;
    var total = <?php echo (json_encode($total)); ?>;
    var rows = <?php echo (json_encode($rows)); ?>;

    for (i = 0; i < rows.length; i++) {

        var a = rows[i];
        var activity_initiation_id = a.activity_initiation_id;
        var activityID = a.activity_id;

        var ppp = 0;
        var ccc = 0;
        for (j = 0; j < total.length; j++) {
            var totalactivity_id = total[j].activity_id;
            if (totalactivity_id == activityID) {
                var ppp = total[j].total;
            }
        }

        for (k = 0; k < com.length; k++) {
            var comactivity_id = com[k].activity_initiation_id;
            if (comactivity_id == activity_initiation_id) {
                var ccc = com[k].complete;
            }
        }

        var id = a.activity_initiation_id;
        var no_questions = a.no_questions;
        var per = ((ccc / ppp) * 100).toFixed(3);
        var idi = '#'.concat(id);
        var title = 'Completed '.concat(ccc) + ' of '.concat(ppp);

        $(idi).attr('aria-valuenow', title).css('width', per + '%');
        var div = document.getElementById(id);
        div.innerHTML += ccc + ' / ' + ppp;

        if (per < 25) {
            document.getElementById(id).classList.add('bg-danger');
        } else if (per < 80) {
            document.getElementById(id).classList.add('bg-warning');
        } else if (per >= 80) {
            document.getElementById(id).classList.add('bg-success');
        }

    }
</script>

@endsection