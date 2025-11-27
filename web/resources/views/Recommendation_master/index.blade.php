@extends('layouts.adminnav')

@section('content')

<div class="main-content">
    @if (session('success'))
    <input type="hidden" name="session_data" id="session_data" class="session_data" value="{{ session('success') }}">
    <script type="text/javascript">
        window.onload = function() {
            var message = $('#session_data').val();
            swal.fire("Success", message, "success");
        }
    </script>
    @elseif(session('fail'))
    <input type="hidden" name="session_data" id="session_data1" class="session_data" value="{{ session('fail') }}">
    <script type="text/javascript">
        window.onload = function() {
            var message = $('#session_data1').val();
            swal.fire("Info", message, "info");
        }
    </script>
    @endif
    <form method="POST" id="registration_form" enctype="multipart/form-data" onsubmit="return false">
        @csrf
        <h2 style="text-align: center;color:blue">Recomendation Master</h2>
        <div class="row">
            <div class="col-12">
                <a type="button" href="{{ route('areas_master.create') }}" value="Create" class="btn btn-labeled btn-info" title="create" style="background: #044a95 !important; border-color:#a9ca !important; color:white !important;">
                    <span class="btn-label" style="font-size:15px !important; padding:8px !important"><i class="fa fa-plus"></i></span><span style="font-size:15px !important; padding:8px !important">Create</span></a>
                <div class="card">
                    <div class="card-body">
                        <div class="table-wrapper">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="align1">
                                    <thead>
                                        <tr>

                                            <th>Sl.No</th>
                                            <th>Areas Name</th>
                                            <th>Envitronment Type</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($rows as $data)
                                        <tr>
                                            <td>{{$loop->iteration}}</td>
                                            <td>{{$data['area_name']}}</td>
                                            @if($data['table_num']==1)
                                            <td>Connection Environment</td>
                                            @elseif($data['table_num']==2)
                                            <td>Learning Environment</td>
                                            @elseif($data['table_num']==3)
                                            <td>Components in Learning</td>
                                            @else
                                            <td></td>
                                            @endif
                                            <td>
                                                <!-- <a class="btn btn-link" title="show" href=""><i class="fas fa-eye" style="color:green"></i></a> -->
                                                <a class="btn btn-link" title="Edit" href="{{route('recommendationreport.edit', \Crypt::encrypt($data['recommendation_detail_area_id'])) }}"><i class="fas fa-pencil-alt" style="color: blue !important"></i></a>

                                                <input type="hidden" name="delete_id" id="<?php echo $data['recommendation_detail_area_id']; ?>" value="{{ route('recommendationreport.delete', \Crypt::encrypt($data['recommendation_detail_area_id'])) }}">
                                                <a class="btn btn-link" title="Delete" onclick="return myFunction(<?php echo $data['recommendation_detail_area_id']; ?>);" class="btn btn-link"><i class="far fa-trash-alt"></i></a>
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
    </form>
</div>

<script src="https://code.jquery.com/jquery-1.7.2.min.js"></script>
<script type="application/javascript">
    function myFunction(id) {
        swal.fire({
            title: "Confirmation For Delete ?",
            text: "Are You Sure to delete this data.",
            showCancelButton: true,
            confirmButtonColor: '#DD6B55',
            confirmButtonText: 'Yes, I am sure!',
            cancelButtonText: "No, cancel it!",
        }).then((result) => {
            if (result.value) {
                var url = $('#' + id).val();
                window.location.href = url;
                // swal.fire("Deleted!", "Data Deleted successfully!", "success");
            } else {
                swal.fire("Cancelled", "Your Data is safe :)", "info");
                e.preventDefault();
            }
        })
    }
</script>

@endsection