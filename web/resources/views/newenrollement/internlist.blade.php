@extends('layouts.adminnav')

@section('content')
<style>
    input[type=checkbox] {
        display: inline-block;
    }

    .no-arrow {
        -moz-appearance: textfield;
    }

    .no-arrow::-webkit-inner-spin-button {
        display: none;
    }

    .no-arrow::-webkit-outer-spin-button,
    .no-arrow::-webkit-inner-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }

    .nav-tabs {
        background-color: #0068a7 !important;
        border-radius: 29px !important;
        padding: 1px !important;

    }

    .nav-item.active {
        background-color: #0e2381 !important;
        border-radius: 31px !important;
        height: 100% !important;
    }

    .nav-link.active {
        background-color: #0e2381 !important;
        border-radius: 31px !important;
        height: 100% !important;
    }

    :root {
        --borderWidth: 5px;
        --height: 24px;
        --width: 12px;
        --borderColor: #78b13f;
    }



    .check {
        display: inline-block;
        transform: rotate(50deg);
        height: var(--height);
        width: var(--width);
        border-bottom: var(--borderWidth) solid var(--borderColor);
        border-right: var(--borderWidth) solid var(--borderColor);
    }

    .nav-justified {
        display: flex !important;
        align-items: center !important;
    }

    .gender {
        display: flex;
        align-items: center;
        justify-content: space-evenly;
    }
</style>
<div class="main-content">
    <div class="row">
        <div class="col-12">
            {{ Breadcrumbs::render('internlist') }}
            <div class="card">
                <div class="card-body">
                    <div class="col-lg-12 text-center mb-3">
                        <h4 style="color:darkblue;">Internship Participant Info List</h4>
                    </div>
                    <div class="table-wrapper">
                        <div class="table-responsive">
                            <table class="table table-bordered" id="align">
                                <thead>
                                    <tr>
                                        <th>S.No</th>
                                        <th>Intern Name</th>
                                        <th>Email Address</th>
                                        <th>Contact number</th>
                                        <th>Start Date</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($rows as $key=>$row)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $row['name']}}</td>
                                        <td>{{ $row['email_address']}}</td>
                                        <td>{{ $row['contact_number']}}</td>
                                        <td>{{ $row['start_date_with_elina']}}</td>
                                        <td>{{ $row['status']}}</td>
                                        <td>
                                            @php $row['internship_id'] = Crypt::encrypt($row['internship_id']); @endphp
                                            <a class="btn btn-link" title="show" href="{{ route('internview', $row['internship_id']) }}"><i class="fas fa-eye" style="color:green"></i></a>
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