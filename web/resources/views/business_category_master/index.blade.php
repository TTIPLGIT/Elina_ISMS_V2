@extends('layouts.adminnav')

@section('content')
<style>
    a:hover,
    a:focus {
        text-decoration: none;
        outline: none;
    }

    .danger {
        background-color: #ffdddd;
        border-left: 6px solid #f44336;
    }

    #align {
        border-collapse: collapse !important;
    }

    table.dataTable.no-footer {
        border-bottom: .5px solid #002266 !important;
    }

    thead th {
        height: 5px;
        border-bottom: solid 1px #ddd;
        font-weight: bold;
    }

    .userrolecontainer {
        display: inline-block !important;
    }

    .section {
        margin-top: 20px;
    }
</style>
<style>
    /* Style the button */
    .custom-dropbtn {
        background-color: #4CAF50;
        color: white;
        padding: 16px;
        font-size: 16px;
        border: none;
        cursor: pointer;
    }

    /* Container for the dropdown */
    .custom-dropdown {
        position: relative;
        display: inline-block;
    }

    /* Style the dropdown content (hidden by default) */
    .custom-dropdown-content {
        display: none;
        position: absolute;
        background-color: #f9f9f9;
        min-width: 160px;
        box-shadow: 0px 8px 16px rgba(0, 0, 0, 0.2);
        z-index: 1;
    }

    /* Links inside the dropdown */
    .custom-dropdown-content a {
        color: black;
        padding: 12px 16px;
        text-decoration: none;
        display: block;
    }

    /* Change color of dropdown links on hover */
    .custom-dropdown-content a:hover {
        background-color: #f1f1f1;
    }

    /* Show the dropdown content when hovering over the button */
    .custom-dropdown:hover .custom-dropdown-content {
        display: block;
    }

    /* Change the button's background color when hovering */
    .custom-dropdown:hover .custom-dropbtn {
        background-color: #3e8e41;
    }
</style>
<div class="main-content">
    <section class="section">

        <div class="section-body mt-2">
            <div class="d-flex flex-row justify-content-between px-3">
                {{-- @if(strpos($screen_permission['permissions'], 'Create') !== false) --}}
                <div class="custom-dropdown">
                    <button class="custom-dropbtn btn btn-success">Create</button>
                    <div class="custom-dropdown-content">
                        <a href="{{ route('business.affiliate.create', ['program' => 'school']) }}">School</a>
                    </div>
                </div>
                {{-- @endif --}}
            </div>
            <div class="row">

                <div class="col-12">

                    <div class="card">

                        <div class="card-body">
                            <div class="row">

                            </div>
                            @if (session('success'))

                            <input type="hidden" name="session_data" id="session_data" class="session_data" value="{{ session('success') }}">
                            <script type="text/javascript">
                                window.onload = function() {
                                    var message = $('#session_data').val();
                                    swal({
                                        title: "Success",
                                        text: message,
                                        type: "success",
                                    });

                                }
                            </script>
                            @elseif(session('error'))

                            <input type="hidden" name="session_data" id="session_data1" class="session_data" value="{{ session('error') }}">
                            <script type="text/javascript">
                                window.onload = function() {
                                    var message = $('#session_data1').val();
                                    swal({
                                        title: "Info",
                                        text: message,
                                        type: "info",
                                    });

                                }
                            </script>
                            @endif



                            <div class="table-wrapper">
                                <div class="table-responsive">
                                    <table class="table table-bordered" id="align">
                                        <thead>
                                            <tr>
                                                <th width="50px">#</th>
                                                <th>School Name</th>
                                                <th>School Enrollment</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($rows as $key=>$row)
                                            <tr>
                                                <td>{{ ++$key }}</td>
                                                <td>{{$row['school_name'] }}</td>
                                                <td>{{$row['school_unique']}}</td>
                                                <td class="text-center">

                                                    {{-- @if(strpos($screen_permission['permissions'], 'Edit') !== false) --}}
                                                    <a class="btn btn-danger" href="{{ route('business.affiliate.edit', \Crypt::encrypt($row['id'])) }}" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit"><i class="fa fa-edit" aria-hidden="true"></i><span></span></a>
                                                    {{-- @endif --}}
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
    </section>
</div>
</div>
@endsection