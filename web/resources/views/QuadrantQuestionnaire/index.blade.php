@extends('layouts.adminnav')
@section('content')

<div class="main-content">
    {{ Breadcrumbs::render('quadrant_questionnaire.index') }}
    <!-- <a type="button" href="{{ route('quadrant_questionnaire.create') }}" value="Create" class="btn btn-labeled btn-info" title="create" style="background: #044a95 !important; border-color:#a9ca !important; color:white !important;margin-top: 0.5rem;">
        <span class="btn-label" style="font-size:15px !important; padding:8px !important"><i class="fa fa-plus"></i></span><span style="font-size:15px !important; padding:8px !important">New Questionnaire</span></a> -->
    <div class="row">
        <div class="card-body">
        <div class="col-lg-12 text-center">
            <h4 class="text-center" style="color:darkblue">Quadrant Reports List</h4>
</div>
            <div class="table-wrapper">
                <div class="table-responsive">
                    <table class="table table-bordered" id="align">
                        <thead>
                            <tr>
                                <th>Sl.No.</th>
                                <th>Enrollment Id</th>
                                <th>Child Name</th>
                                <!-- <th>Stage</th> -->
                                <th>Questionnaire Name</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($rows as $key=>$row)
                            <tr>
                                <td>{{ $loop->iteration}}</td>
                                <td>{{$row['enrollment_child_num']}}</td>
                                <td>{{$row['child_name']}} </td>
                                <!-- <td>SAIL</td> -->
                                <td>{{$row['questionnaire_name']}}</td>
                                <td class="text-center">
                                    @if($row['questionnaire_id'] == 17)
                                    <a class="btn btn-link" title="Show" id="{{$row['questionnaire_initiation_id']}}" href="{{ route('quadrant_questionnaire.show', \Crypt::encrypt($row['questionnaire_initiation_id'])) }}"><i class="fas fa-eye" style="color: blue !important"></i></a>
                                    @else
                                    <a class="btn btn-link" title="Show" id="{{$row['questionnaire_initiation_id']}}" href="{{ route('quadrant_questionnaire.executive', \Crypt::encrypt($row['questionnaire_initiation_id'])) }}"><i class="fas fa-eye" style="color: blue !important"></i></a>
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

@endsection