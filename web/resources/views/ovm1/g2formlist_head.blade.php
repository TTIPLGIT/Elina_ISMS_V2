@extends('layouts.adminnav')
@section('content')
<div class="main-content">
  {{ Breadcrumbs::render('g2form.list') }}
  <section class="section">
    <div class="section-body mt-2">
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
      <div class="row">

        <div class="col-12">
          <div class="card">

            <div class="card-body">

              <div class="row">
                <div class="col-lg-12 text-center">
                  <h4 class="screen-title"> Parent Reflection Form</h4>
                </div>
              </div>

              <div class="table-wrapper">
                <div class="table-responsive">
                  <table class="table table-bordered" id="tableList">
                    <thead>
                      <tr>
                        <!-- <th>Sl.No.</th> -->
                        <th>Enrollment Id</th>
                        <th>Child Name</th>
                        <th>Status</th>
                        <th>Action</th>
                      </tr>
                    </thead>
                    <tbody>
                      @foreach($rows as $key=>$row)
                      <tr>
                        <!-- <td>{{ $loop->iteration}}</td> -->
                        <td>{{$row['enrollment_child_num']}}</td>
                        <td>{{$row['child_name']}} </td>
                        @if(in_array($user_id , explode(',', $row['viewed_users']) ))
                        <td>Viewed</td>
                        @else
                        <td>{{$row['status']}}</td>
                        @endif
                       
                        <td class="text-center">

                          @if($row['status'] == 'Submitted')
                          <a class="btn btn-link" title="Show" id="{{$row['user_id']}}" href="{{ route('g2form.new', \Crypt::encrypt($row['user_id'])) }}"><i class="fas fa-eye" style="color: blue !important"></i></a>
                          @endif
                          @if($row['status'] != 'Submitted')
                          @if($modules['user_role'] == 'Parent')
                          <a class="btn btn-link" title="Edit" id="{{$row['user_id']}}" href="{{ route('g2form.new', \Crypt::encrypt($row['user_id'])) }}"><i class="fas fa-pen" style="color: blue !important"></i></a>
                          @else
                          <a class="btn btn-link" title="Show" onclick="return myFunction(<?php echo $row['user_id']; ?>);" class="btn btn-link"><i class="far fa-eye"></i></a>
                          @endif
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
      </div>
    </div>
  </section>
</div>

<script src="https://code.jquery.com/jquery-1.7.2.min.js"></script>
<script type="application/javascript">
  function myFunction(id) {
    swal.fire("The parent has not yet submitted the form.", "", "info");
  }
</script>
@endsection