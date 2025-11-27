@extends('layouts.adminnav')

@section('content')

<div class="main-content">
    {{ Breadcrumbs::render('questionnaire_master.index') }}
    <div class="row">
        <div class="col-12">
            <a type="button" href="{{ route('questionnaire_master.create') }}" value="Cancel" class="btn btn-labeled btn-info" title="create" style="background: #044a95 !important; border-color:#a9ca !important; color:white !important;margin-top: 0.5rem;">
                <span class="btn-label" style="font-size:15px !important; padding:8px !important"><i class="fa fa-plus"></i></span><span style="font-size:15px !important; padding:8px !important">Create Questionnaire</span></a>
            <!-- <a type="button" style="font-size:15px;" class="btn btn-success btn-lg" title="Create" id="gcb" href="{{ route('newenrollment.create') }}">NewEnrollment<i class="fa fa-plus" aria-hidden="true"></i></a> -->
            <div class="card mt-3">
                <div class="card-body">
                    <div class="table-wrapper">
                        <div class="table-responsive">
                            <table class="table table-bordered" id="align1">
                                <thead>
                                    <tr>
                                        <th>Sl.No</th>
                                        <th>Questionnaire Name</th>
                                        <!-- <th>Description</th> -->
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($rows as $data)
                                    <tr>
                                        <td>{{$loop->iteration}}</td>
                                        <td>{{$data['questionnaire_name']}}</td>
                                        {{--<td>{{$data['questionnaire_description']}}</td>--}}
                                        <td>
                                            <!-- <a class="btn btn-link" title="show" href=""><i class="fas fa-eye" style="color:green"></i></a> -->
                                            <a class="btn btn-link" title="Edit" href="{{ route('questionnaire_master.edit', \Crypt::encrypt($data['questionnaire_id'])) }}"><i class="fas fa-pencil-alt" style="color: blue !important"></i></a>
                                            @csrf
                                            <input type="hidden" name="delete_id" id="<?php echo $data['questionnaire_id']; ?>" value="{{ route('questionnaire_master.delete', \Crypt::encrypt($data['questionnaire_id'])) }}">
                                            <a class="btn btn-link" title="Delete" onclick="return myFunction(<?php echo $data['questionnaire_id']; ?>);" class="btn btn-link"><i class="far fa-trash-alt"></i></a>
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