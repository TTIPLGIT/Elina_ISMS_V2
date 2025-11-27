@extends('layouts.adminnav')
@section('content')

<div class="main-content">
    {{ Breadcrumbs::render('assessmentreport.index') }}
    <section class="section">
        @if (session('success'))
        <input type="hidden" name="session_data" id="session_data" class="session_data" value="{{ session('success') }}">
        <script type="text/javascript">
            window.onload = function() {
                var message = $('#session_data').val();
                swal("Success", message, "success");

            }
        </script>
        @elseif(session('fail'))
        <input type="hidden" name="session_data" id="session_data1" class="session_data" value="{{ session('error') }}">
        <script type="text/javascript">
            window.onload = function() {
                var message = $('#session_data1').val();
                swal("Info", message, "info");
            }
        </script>
        @endif
        <div class="section-body mt-2">
            <div class="row">
                <div class="col-12">                    
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-12 text-center">
                                    <h4 style="color:darkblue;">SAIL Report List</h4>
                                </div>
                            </div>
                            <div class="table-wrapper">
                                <div class="table-responsive">
                                    <table class="table table-bordered" id="align">
                                        <thead>
                                            <tr>
                                                <th>S No</th>
                                                <th>Enrollment ID</th>
                                                <th>Child Name</th>
                                                <th>Report</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($rows as $data)
                                            <tr>
                                                <td>{{$loop->iteration}}</td>
                                                <td>{{$data['enrollment_child_num']}}</td>
                                                <td>{{$data['child_name']}}</td>
                                                <td></td>
                                                <td class="text-center"></td>
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
    </section>
</div>
@endsection