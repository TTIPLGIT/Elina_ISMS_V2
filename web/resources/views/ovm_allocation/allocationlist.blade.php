@extends('layouts.adminnav')

@section('content')

<style>
    .decision-tabs {
        display: flex;
        justify-content: center;
        gap: 15px;
        margin-bottom: 25px;
        flex-wrap: wrap;
    }

    .decision-tab-btn {
        border: 1px solid #d5d5d5;
        background: #fff;
        color: #555;
        padding: 10px 28px;
        border-radius: 30px;
        font-weight: 600;
        transition: 0.3s;
        cursor: pointer;
    }

    .decision-tab-btn.active {
        background: #1f2b8f;
        color: #fff;
        border-color: #1f2b8f;
    }
</style>

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

                    <div class="decision-tabs mt-3">
                        <button type="button" class="decision-tab-btn active" data-table="activeCoordinatorsSection">
                            Active Coordinators
                        </button>
                        <button type="button" class="decision-tab-btn" data-table="deletedCoordinatorsSection">
                            Deleted Coordinators
                        </button>
                    </div>

                    <div class="table-wrapper table-section" id="activeCoordinatorsSection">
                        <div class="table-responsive">
                            <table class="table table-bordered" id="align1">
                                <thead>
                                    <tr>
                                        <th class="col-1">Sl.No</th>
                                        <th class="col-2">Enrollment ID(Child Name) </th>
                                        <th class="col-3">IS-Coordinator's</th>
                                        <th>Allocation Date</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>


                                    @foreach($rows['rows'] as $data)



                                    <tr>
                                        <td>{{$loop->iteration}}</td>

                                        <td>{{$data['enrollment_child_num']}} ({{$data['child_name']}})</td>

                                        <td>
                                            {{$data['is_coordinator1_name']}}(1),<br>
                                            {{$data['is_coordinator2_name']}}(2)
                                        </td>

                                        <td>{{ date('d-m-Y', strtotime($data['created_date'])) }}</td>

                                        <td>
                                            @if($data['status'] == 1)
                                            <p>Allocated</p>
                                            @elseif($data['status'] == 2)
                                            <p>Reallocated</p>
                                            @elseif($data['status'] == 3)
                                            <p>Cancelled</p>
                                            @endif
                                        </td>

                                        <td>
                                            @if($data['status'] == 1)
                                            <a class="btn btn-link"
                                                title="Reallocation"
                                                href="{{ route('coordinator.edit', Crypt::encrypt($data['id'])) }}"
                                                style="background-color: orange;color:white;text-decoration: none;">
                                                Reallocation
                                            </a>
                                            @endif

                                            @if($data['status'] != 3)
                                            @php
                                            $encryptedId = Crypt::encrypt($data['id']);
                                            @endphp
                                            <a class="btn btn-link"
                                                title="Cancel"
                                                onclick="validateAndAllocate('Cancel', '{{$encryptedId}}', '{{$data['child_name']}}')"
                                                style="background-color:red;color:white;text-decoration: none;">
                                                Cancellation
                                            </a>
                                            @endif


                                            <a class="btn btn-link"
                                                title="View"
                                                href="{{ route('coordinator.show', Crypt::encrypt($data['id'])) }}">
                                                <i class="fas fa-eye" style="color:blue"></i>
                                            </a>

                                        </td>

                                    </tr>
                                    @endforeach

                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="table-wrapper table-section d-none" id="deletedCoordinatorsSection">

                        <div class="table-responsive">

                            <table class="table table-bordered" id="align2" style="width: 100%">

                                <thead>

                                    <tr>

                                        <th class="col-1">Sl.No</th>

                                        <th class="col-2">Enrollment ID(Child Name) </th>

                                        <th class="col-3"> Deleted IS-Coordinator's</th>

                                        <th>Allocation Date</th>

                                        <th>Status</th>

                                        <th>Action</th>

                                    </tr>

                                </thead>

                                <tbody>



                                    @if(isset($deleted_coordinators) && is_array($deleted_coordinators))

                                    @foreach($deleted_coordinators as $data)



                                    <tr>

                                        <td>{{$loop->iteration}}</td>



                                        <td>{{$data['enrollment_child_num']}} ({{$data['child_name']}})</td>



                                        <td>

                                            @php

                                                $show1 = (isset($data['u1_delete_status']) && $data['u1_delete_status'] == 1 && isset($data['u1_active_flag']) && $data['u1_active_flag'] == 1);

                                                $show2 = (isset($data['u2_delete_status']) && $data['u2_delete_status'] == 1 && isset($data['u2_active_flag']) && $data['u2_active_flag'] == 1);

                                            @endphp



                                            @if($show1)

                                                {{$data['is_coordinator1_name']}}(1)

                                            @endif



                                            @if($show1 && $show2)

                                                <br>

                                            @endif



                                            @if($show2)

                                                {{$data['is_coordinator2_name']}}(2)

                                            @endif



                                            @if(!$show1 && !$show2)

                                                {{$data['is_coordinator1_name']}}(1),<br>

                                                {{$data['is_coordinator2_name']}}(2)

                                            @endif

                                        </td>



                                        <td>{{ date('d-m-Y', strtotime($data['created_date'])) }}</td>



                                        <td>

                                            @if($data['status'] == 1)

                                            <p>Allocated</p>

                                            @elseif($data['status'] == 2)

                                            <p>Reallocated</p>

                                            @elseif($data['status'] == 3)

                                            <p>Cancelled</p>

                                            @endif

                                        </td>



                                        <td>

                                            @if($data['status'] == 1)

                                            <a class="btn btn-link"

                                                title="Reallocation"

                                                href="{{ route('coordinator.edit', Crypt::encrypt($data['id'])) }}"

                                                style="background-color: orange;color:white;text-decoration: none;">

                                                Reallocation

                                            </a>

                                            @endif



                                            @if($data['status'] != 3)

                                            @php

                                            $encryptedId = Crypt::encrypt($data['id']);

                                            @endphp

                                            <a class="btn btn-link"

                                                title="Cancel"

                                                onclick="validateAndAllocate('Cancel', '{{$encryptedId}}', '{{$data['child_name']}}')"

                                                style="background-color:red;color:white;text-decoration: none;">

                                                Cancellation

                                            </a>

                                            @endif





                                            <a class="btn btn-link"

                                                title="View"

                                                href="{{ route('coordinator.show', Crypt::encrypt($data['id'])) }}">

                                                <i class="fas fa-eye" style="color:blue"></i>

                                            </a>



                                        </td>



                                    </tr>

                                    @endforeach

                                    @endif



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

                    const cancelUrl = `\/coordinator/cancellation/${id}`;

                    setTimeout(() => {

                        window.location.href = cancelUrl;

                    }, 1000);

                }

            });

        }

    }



    $(document).ready(function() {

        $('.decision-tab-btn').on('click', function() {

            $('.decision-tab-btn').removeClass('active');

            $(this).addClass('active');



            let tableId = $(this).data('table');

            $('.table-section').addClass('d-none');

            $('#' + tableId).removeClass('d-none');



            // Adjust DataTable columns on tab switch

            if ($.fn.dataTable) {

                $.fn.dataTable.tables({ visible: true, api: true }).columns.adjust();

            }

        });

    });

</script>

@endsection