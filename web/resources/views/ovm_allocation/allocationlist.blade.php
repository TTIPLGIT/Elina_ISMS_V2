@extends('layouts.adminnav')

@section('content')

<div class="main-content">
    @if (session('success'))

    <input type="hidden" name="session_data" id="session_data" class="session_data" value="{{ session('success') }}">

    <script type="text/javascript">
        window.onload = function() {
            var message = '<?php echo session('success'); ?>';
            // alert(message);exit;
            Swal.fire({
                title: "Success",
                text: message,
                icon: 'success',
                type: "success",
            });
        }
    </script>
    @elseif(session('fail'))
    <input type="hidden" name="session_data" id="session_data1" class="session_data" value="{{ session('fail') }}">
    <script type="text/javascript">
        window.onload = function() {
            var message = $('#session_data1').val();
            Swal.fire({
                title: "Success",
                text: "message",
                type: "success",
            });
        }
    </script>
    @endif


    {{ Breadcrumbs::render('coordinator.list') }}

    <div class="row">
        <div class="col-12">
            <!-- <a type="button" style="font-size:15px;" class="btn btn-success btn-lg" title="Create" id="gcb" href="{{ route('newenrollment.create') }}">NewEnrollment<i class="fa fa-plus" aria-hidden="true"></i></a> -->
            <div class="card">
                <div class="card-body">
                    <h5 class="text-center" style="color:darkblue">IS-Coordinator's Allocation List </h5>

                    <div class="table-wrapper">
                        <div class="table-responsive">
                            <table class="table table-bordered" id="align1">
                                <thead>
                                    <tr>
                                        <th>Sl.No</th>
                                        <th>Enrollment ID(Child Name) </th>
                                        <th>IS-Coordinator's</th>
                                        <th>Allocation Date</th>
                                        <th style="width: 76.641px;">Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>


                                    @foreach($rows['rows'] as $data)
                                    <tr>
                                        <td>{{$loop->iteration}}</td>
                                        <td>{{$data['enrollment_child_num']}}({{$data['child_name']}})</td>
                                        <td>{{$data['is_coordinator1_name']}}(1),<br>{{$data['is_coordinator2_name']}}(2)</td>
                                        <td>{{date('d-m-Y', strtotime($data['created_date']))}}</td>
                                        <td>
                                            @if($data['status']== 1)
                                            <p>Allocated</p>
                                            @elseif($data['status']== 2)
                                            <p>Reallocated</p>
                                            @elseif($data['status']== 3)
                                            <p>Cancelled</p>
                                            @endif
                                        </td>
                                        <td>
                                            @if($data['status']== 1)
                                            <a class="btn btn-link" title="Reallocation" href="{{ route('coordinator.edit', Crypt::encrypt($data['id'])) }}" style="background-color: orange;color:white;text-decoration: none;">Reallocation</a>
                                            @endif
                                            @if($data['status'] != 3)
                                            @php
                                            $encryptedId = Crypt::encrypt($data['id']);
                                            @endphp
                                            <a class="btn btn-link" title="Cancel" onclick="validateAndAllocate('Cancel', '{{$encryptedId}}', '{{$data['child_name']}}')" style="background-color:red;color:white;text-decoration: none;">Cancellation</a>
                                            @endif
                                            <a class="btn btn-link" title="View" href="{{ route('coordinator.show', Crypt::encrypt($data['id'])) }}"><i class="fas fa-eye" style="color:blue"></i></a>


                                        </td>
                                    </tr>
                                    @endforeach
                                    <!-- <tr>
                                        <td>2</td>
                                        <td>EN/2023/05/003(Kaviya)</td>
                                        <td>Chitra</td>
                                        <td>08-07-2023</td>
                                        <td>Cancelled</td>
                                        <td>
                                            <a class="btn btn-link" title="Reallocation" href="{{route('coordinator_allocation.index')}}" style="background-color: orange;color:white;text-decoration: none;">Reallocation</a>

                                            <a class="btn btn-link" title="View" href=""><i class="fas fa-eye" style="color:blue"></i></a>


                                        </td>
                                    </tr>
                                    <tr>
                                        <td>3</td>
                                        <td>EN/2023/05/003(Kaviya)</td>
                                        <td>Chitra</td>
                                        <td>08-07-2023</td>
                                        <td>Reallocated</td>
                                        <td>

                                            <a class="btn btn-link" title="View" href=""><i class="fas fa-eye" style="color:blue"></i></a>


                                        </td>
                                    </tr> -->
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- <script>
    window.onload = function() {
        let url = new URL(window.location.href)
        let message = url.searchParams.get("message4");
        if (message != null) {

            window.history.pushState("object or string", "Title", "/coordinator/list/view");
        }
        let message1 = url.searchParams.get("message6");
        if (message1 != null) {

            window.history.pushState("object or string", "Title", "/coordinator/list/view");
        }

    };
</script> -->


<script>
    function showSuccessAlert() {
        Swal.fire({
            title: "Success",
            text: "IS-Coordinator Allocation Cancelled Successfully",
            icon: "success",
        });
    }

    function validateAndAllocate(allocationType, id, childName) {



        if (allocationType == "Cancel") {
            Swal.fire({
                title: `Do you want to Cancel the IS-Coordinator Allocation for the child of ${childName}?`,
                text: "Please click 'Yes' to Cancel the Allocation",
                icon: "warning",
                customClass: 'swalalerttext',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                confirmButtonText: "Yes",
                cancelButtonText: "No",
                closeOnConfirm: false,
                closeOnCancel: true,
                showLoaderOnConfirm: true,
                width: '550px',
            }).then((result) => {
                if (result.value) {
                    // Simulating a success response with a delay

                    const cancelUrl = `\/coordinator/cancellation/${id}`;
                    setTimeout(() => {
                        // showSuccessAlert();
                        // Redirect with a message parameter
                        window.location.href = cancelUrl; // Replace with your desired route
                    }, 1000);
                }
            });
        }
    }

    // window.onload = function() {
    //     let url = new URL(window.location.href);
    //     let message4 = url.searchParams.get("message4");

    //     if (message4 != null) {
    //         // Remove the parameter from the URL after showing the success message
    //         window.history.pushState({}, document.title, "/coordinator/list/view");
    //         showSuccessAlert();
    //     }
    // };
</script>
@endsection