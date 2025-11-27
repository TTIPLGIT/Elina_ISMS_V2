@extends('layouts.adminnav')
@section('content')

<div class="main-content">
    <div class="row">
        <div class="col-12">
            {{ Breadcrumbs::render('servicelist') }}
            <div class="card">
                <div class="card-body">
                    <div class="col-lg-12 text-center">
                        <h4 style="color:darkblue;">Enrolled Service Providers List</h4>
                    </div>
                    <div class="table-wrapper">
                        <div class="table-responsive">
                            <table class="table table-bordered" id="align">
                                <thead>
                                    <tr>
                                        <th>S.No</th>
                                        <th>Service Provider Name</th>
                                        <th>Email Address</th>
                                        <th>Contact number</th>
                                        <th>Type of Service</th>
                                        <th>Charge Per Session</th>
                                        <!-- <th>Status</th> -->
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    @foreach($rows as $key=>$row)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $row['name']}}</td>
                                        <td>{{ $row['email_address']}}</td>
                                        <td>{{ $row['phone_number']}}</td>
                                        <td>{{ $row['type_of_service']}}</td>
                                        <td>{{ $row['profession_charges_per_session']}}</td>
                                        <!-- <td>{{ $row['status']}}</td> -->

                                        <td>
                                            @php $row['id'] = Crypt::encrypt($row['id']); @endphp
                                            <a class="btn btn-link" title="show" href="{{ route('serviceproviderview', $row['id']) }}"><i class="fas fa-eye" style="color:green"></i></a>
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