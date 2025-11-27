@extends('layouts.adminnav')

@section('content')
<div class="main-content">
    <div class="row">
        <div class="col-12">
            {{ Breadcrumbs::render('enrollement.schoollist') }}
            <div class="card">
                <div class="card-body">
                    <div class="col-lg-12 text-center" style="padding: 10px;">
                        <h4 style="color:darkblue;">School Enrollment Detail</h4>
                    </div>
                    <div class="table-wrapper">
                        <div class="table-responsive">
                            <table class="table table-bordered" id="align">
                                <thead>
                                    <tr>
                                        <th>S.No</th>
                                        <th>School Name</th>
                                        <th>Enrollment number</th>
                                        <th>District</th>
                                        <th>Administration Number</th>
                                        <th>status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($rows as $key=>$row)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $row['school_name']}}</td>
                                        <td>{{ $row['school_enrollment_num']}}</td>
                                        <td>{{ $row['school_district']}}</td>
                                        <td>{{ $row['admin_contract']}}</td>
                                        <td>{{ $row['status']}}</td>
                                        <td>
                                            <a class="btn btn-link" title="Show" href="{{ route('enrollement.schoolshow',\Crypt::encrypt($row['school_enrollment_id'])) }}"><i class="fas fa-eye" style="color:green"></i></a>
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
@endsection