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
    {{ Breadcrumbs::render('coordinator.list') }}

    <div class="row">
        <div class="col-12">
            <!-- <a type="button" style="font-size:15px;" class="btn btn-success btn-lg" title="Create" id="gcb" href="{{ route('newenrollment.create') }}">NewEnrollment<i class="fa fa-plus" aria-hidden="true"></i></a> -->
            <div class="card">
                <div class="card-body">
                    <h5 class="text-center" style="color:darkblue">My OVM Allocation List View</h5>

                    <div class="table-wrapper">
                        <div class="table-responsive">
                            <table class="table table-bordered" id="align1">
                                <thead>
                                    <tr>
                                        <th>Sl.No</th>
                                        <th>Enrollment ID(Child Name) </th>
                                        <th>IS-Coordinator</th>
                                        <th>Allocation Date</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    @foreach($rows['rows'] as $data)
                                    @php
                                    $enrollmentId = $data['enrollment_id'];
                                    $count = DB::table('ovm_allocation')
                                    ->where('enrollment_id', $enrollmentId)
                                    ->count();
                                    @endphp
                                    <tr>
                                        <td>{{$loop->iteration}}</td>
                                        <td>{{$data['enrollment_child_num']}}({{$data['child_name']}})</td>
                                        <td>
                                            @if ($user_id == $data['is_coordinator1'])
                                            {{$data['is_coordinator2_name']}}(S)
                                            @elseif ($user_id == $data['is_coordinator2'])
                                            {{$data['is_coordinator1_name']}}(P)
                                            @endif
                                        </td>
                                        <td>{{date('d-m-Y', strtotime($data['created_date']))}}</td>
                                        <td>{{$data['meeting_status']}}</td>
                                        <td>
                                            @if(($data['status']!= 3 && $count > 1) || ($data['status']!= 3 && $count = 1))
                                            <a class="btn btn-link" title="" href="{{ route('coordinator_allocation.ovm_create', Crypt::encrypt($data['id'])) }}" style="background-color:blue;color:white;text-decoration: none;">OVM Meeting</a>
                                            @elseif($data['status']==3 || $count = 1)
                                            -
                                            @endif
                                        </td>

                                    </tr>
                                    @endforeach

                                </tbody>
                            </table>
                            <p><b>P-Primary,S-Secondary</b></p>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>



<script>
    function showSuccessAlert() {
        Swal.fire({
            title: "Success",
            text: "Reallocation Done Successfully",
            icon: "success",
        });
    }

    function validateAndAllocate(id) {
        //alert("sd");

        $.ajax({
            url: "{{ url('/coordinator/ovm_fetch') }}",
            type: 'GET',
            data: {
                'id': id,
                _token: '{{csrf_token()}}'
            },
            success: function(data) {
                console.log(data);
                if (data != 0) {
                    location.replace(`/coordinator/ovm_create`);

                }



            }
        });


    }
    window.onload = function() {
        let url = new URL(window.location.href);
        let message4 = url.searchParams.get("message4");

        if (message4 != null) {
            // Remove the parameter from the URL after showing the success message
            window.history.pushState({}, document.title, "/allocation/list");
            showSuccessAlert();
        }
    };
</script>
@endsection