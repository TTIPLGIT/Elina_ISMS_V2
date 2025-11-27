@extends('layouts.adminnav')

@section('content')
<div class="main-content">
    <!-- {{ Breadcrumbs::render('video_creation.index') }} -->
    <div class="row justify-content-center">
        <div class="col-lg-12 col-md-12">
            <h4 style="color:darkblue;text-align: center !important;">Assessment - Activity Details</h4>
            <form method="POST" id="registration_form" enctype="multipart/form-data" onsubmit="return false">
                @csrf
                <!-- Activity Details -->
                <div class="row">
                    <div class="col-12">
                        <a type="button" href="{{ route('assessment_mapping.create') }}" value="Create" class="btn btn-labeled btn-info" title="Create" style="background: #044a95 !important; border-color:#a9ca !important; color:white !important;">
                            <span class="btn-label" style="font-size:15px !important; padding:8px !important"><i class="fa fa-plus"></i></span><span style="font-size:15px !important; padding:8px !important">New Activity</span></a>
                        <div class="card">
                            <div class="card-body">
                                <div class="table-wrapper">
                                    <div class="table-responsive">
                                        <table class="table table-bordered" id="align1">
                                            <thead>
                                                <tr>
                                                    <th>Sl.No</th>
                                                    <th>Activity Name</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                {{-- @foreach($rows as $key=>$row)
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                <td>{{ $row['activity_name']}}</td>
                                                <td>
                                                    <a class="btn btn-link" title="show" href="{{route('activitymaster.show_1',\Crypt::encrypt($row['activity_id']))}}"><i class="fas fa-eye" style="color:green"></i></a>
                                                    <a class="btn btn-link" title="Edit" href="{{route('activitymaster.edit_1',\Crypt::encrypt($row['activity_id']))}}"><i class="fas fa-pencil-alt" style="color: blue !important"></i></a>
                                                    @csrf
                                                    <input type="hidden" name="delete_id" id="<?php echo $row['activity_id']; ?>" value="{{ route('video_creation.delete', $row['activity_id']) }}">
                                                    <a class="btn btn-link" title="Delete" onclick="return myFunction('{{$row['activity_id']}}')" class="btn btn-link"><i class="far fa-trash-alt"></i></a>
                                                </td>
                                                </tr>
                                                @endforeach --}}
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
    </div>
</div>
@endsection