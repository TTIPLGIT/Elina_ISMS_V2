@extends('layouts.adminnav')
<style>
    .trash {
        color: red !important;
    }
</style>
@section('content')

<div class="main-content">
    {{ Breadcrumbs::render('thirteenyrsquestionnaire_master.index') }}

    <div class="row">
        @if (session('success'))
        <input type="hidden" name="session_data" id="session_data" class="session_data" value="{{ session('success') }}">
        <script type="text/javascript">
            window.onload = function() {
                var message = $('#session_data').val();
                Swal.fire({
                    title: "Success",
                    text: message,
                    type: "success",
                });
            }
        </script>
        @elseif(session('fail'))
        <input type="hidden" name="session_data" id="session_data1" class="session_data" value="{{ session('fail') }}">
        <script type="text/javascript">
            window.onload = function() {
                var message = $('#session_data1').val();
                Swal.fire({
                    title: "Info",
                    text: message,
                    type: "info",
                });
            }
        </script>
        @endif
        <div class="col-12">
            <a type="button" href="{{ route('thirteenyrsquestionnaire_master.create') }}" value="Cancel" class="btn btn-labeled btn-info" title="create" style="background: #044a95 !important; border-color:#a9ca !important; color:white !important;margin-top: 0.5rem;">
                <span class="btn-label" style="font-size:15px !important; padding:8px !important"><i class="fas fa-plus"></i></span><span style="font-size:15px !important; padding:8px !important">13+Questionnaire</span></a>
            <!-- <a type="button" style="font-size:15px;" class="btn btn-success btn-lg" title="Create" id="gcb" href="{{ route('newenrollment.create') }}">NewEnrollment<i class="fa fa-plus" aria-hidden="true"></i></a> -->
            <div class="card mt-3">
                <div class="card-body">
                    <h3 class="text-center" style="color:darkblue;">13+ Questionnaire Creation List</h3>
                    <div class="table-wrapper">
                        <div class="table-responsive">
                            <table class="table table-bordered" id="align1">
                                <thead>
                                    <tr>
                                        <th>Sl.No</th>
                                        <th>13+Questionnaire Name</th>
                                        <th>Category</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    <tr>
                                        <td>1</td>
                                        <td>Executive Functioning Questionnaire</td>
                                        <td>Parent</td>
                                        <td>
                                            <!-- <a class="btn btn-link" title="show" href=""><i class="fas fa-eye" style="color:green"></i></a> -->
                                            <a class="btn btn-link" title="Edit" href="{{ route('thirteenyrsquestionnaire_master.edit', 1) }}"><i class="fas fa-pencil-alt" style="color: blue !important"></i></a>

                                            <input type="hidden" name="delete_id" id="1" value="{{ route('thirteenquestionnaire_master.delete', 1) }}">
                                            <a class="btn btn-link trash" title="Delete" onclick="return myFunction('1');" class="btn btn-link"><i class="far fa-trash-alt"></i></a>
                                        </td>
                                    </tr>

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
            text: "Are you sure,you want to delete this Questionnaire.",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: '#F1320E',
            confirmButtonText: 'Yes, I am sure!',
            cancelButtonText: "No, cancel it!",
            closeOnConfirm: false,
            closeOnCancel: false
        }).then((result) => {
            /* Read more about isConfirmed, isDenied below */
            if (result.isConfirmed) {
                swal.fire("Deleted!", "Question Deleted successfully!", "success").then(()=>location.reload());
            }
        });


    }
</script>

<script>
    setTimeout(func, 2000);

    function func() {
        let url = new URL(window.location.href)
        let message = url.searchParams.get("message");
        let message1 = url.searchParams.get("message1");

        if (message != null) {
            Swal.fire({
                title: "Success",
                text: "Questionnaire Created Successfully",
                icon: "success",
            });
        }
        if (message1 != null) {
            Swal.fire({
                title: "Success",
                text: "Questionnaire Updated Successfully",
                icon: "success",
            });
        }
    };
    
    window.onload = function() {
        let url = new URL(window.location.href)
        let message = url.searchParams.get("message");
        let message1 = url.searchParams.get("message1");


        if (message != null) {
            func();
            window.history.pushState("object or string", "Questionnaire Created Successfully", "/thirteenyrsquestionnaire_master");
        }
        if (message1 != null) {
            func();
            window.history.pushState("object or string", "Questionnaire Updated Successfully", "/thirteenyrsquestionnaire_master");

        }

    };
</script>

@endsection