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
</style>
<div class="main-content">





  <section class="section">

    {{ Breadcrumbs::render('user.index') }}

    <div class="section-body mt-2">



      <div class="d-flex flex-row justify-content-between px-3">
        <a type="button" style="margin: 0 0px 5px 0px;" class="btn btn-success" href="{{ route('paymentmaster.customized.create') }}">Create</a>
      </div>

      <style>
        .section {
          margin-top: 20px;
        }
      </style>



      <div class="row">

        <div class="col-12">

          <div class="card">

            <div class="card-body">
              <div class="row">
                <!-- <div class="col-lg-12 text-center">
                  <h4 style="color:darkblue;">Folder List</h4>
                </div> -->

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
                        <th>Name</th>
                        <th>Enrollment ID</th>
                        <th>Fee Type</th>
                        <th>Action</th>
                      </tr>
                    </thead>
                    <tbody>
                      @foreach($rows as $key=>$row)
                      <tr>
                        <td>{{ ++$key }}</td>
                        <td>{{$row['child_name'] }}</td>
                        <td>{{$row['enrollment_child_num']}}</td>
                        <td>{{ $row['fee_type'] }}</td>
                        <td class="text-center">
                          <a class="btn btn-danger" href="{{ route('paymentmaster.customized.getdata', \Crypt::encrypt($row['id'])) }}" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit"><i class="fa fa-edit" aria-hidden="true"></i><span></span></a>
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