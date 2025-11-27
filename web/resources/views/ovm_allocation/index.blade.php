@extends('layouts.adminnav')

@section('content')

<div class="main-content">
    {{ Breadcrumbs::render('ovm_allocation.index') }}
    @if (session('success'))
    <input type="hidden" name="session_data" id="session_data" class="session_data" value="{{ session('success') }}">
    <script type="text/javascript">
        window.onload = function() {
            var message = $('#session_data').val();
            Swal.fire('Success!', message, 'success');
        }
    </script>
    @elseif(session('Saved'))
    <input type="hidden" name="session_data" id="session_data" class="session_data" value="{{ session('Saved') }}">
    <script type="text/javascript">
        window.onload = function() {
            var message = $('#session_data').val();
            Swal.fire('Saved!', message, 'success');
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

    <!-- <h5 class="text-center" style="color:darkblue"></h5> -->
    <div class="row">
        <div class="col-12">
            @php

            $authID = session()->get('userID');

            $role_name = DB::select("SELECT ur.role_name,ur.role_id FROM uam_roles AS ur INNER JOIN users as us ON (us.array_roles=ur.role_id) WHERE us.id=$authID");
            $role_id=$role_name[0]->role_id;

            @endphp
           
            @if(strpos($screen_permission['permissions'], 'Create') !== false)
            <a type="button" href="{{ route('ovm_allocation.create') }}" value="Cancel" class="btn btn-labeled btn-info" title="create" style="background: #044a95 !important; border-color:#a9ca !important; color:white !important;margin-top: 0.5rem;">
                <span class="btn-label" style="font-size:15px !important; padding:8px !important"><i class="fa fa-plus"></i></span><span style="font-size:15px !important; padding:8px !important">Create</span></a>
            @endif
            <div class="card">
                <div class="card-body">
                    <div class="col-lg-12 text-center">
                        <h4 style="color:darkblue;">OVM Meeting Scheduling</h4>
                    </div>
                    <div class="table-wrapper">
                        <div class="table-responsive">
                            <table class="table table-bordered" id="align1">
                                <thead>
                                    <tr>
                                        <th>S.No</th>
                                        <th>Child Name</th>
                                        <th>Child ID</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    @foreach($rows as $row)

                                    <tr>
                                        <td>{{$loop->iteration }}</td>
                                        <td>{{$row['child_name']}}</td>
                                        <td>{{$row['child_id']}}</td>
                                        <td>
                                            @if($row['rsvp1'] =="")
                                            <p>{{$row['meeting_status']}}</p>
                                            @else
                                            <p>OVM-1 {{$row['rsvp1']}},OVM-2 {{$row['rsvp2']}}</p>
                                            @endif
                                        </td>
                                        <td>
                                            @if($row['meeting_status'] == 'Saved')
                                            <a class="btn btn-link" title="Edit" href="{{ route('ovm_allocation.saved', Crypt::encrypt($row['id'])) }}"><i class="fas fa-pencil-alt" style="color:green"></i></a>
                                            @else
                                            <a class="btn btn-link" title="Edit" href="{{ route('ovm_allocation.edit', Crypt::encrypt($row['id'])) }}"><i class="fas fa-pencil-alt" style="color:green"></i></a>
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
                    swal.fire("Cancelled", "Your Data is safe :)", "error");
                    e.preventDefault();
                }
            });
    }
</script>

@endsection