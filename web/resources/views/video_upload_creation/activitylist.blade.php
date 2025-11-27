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

    .egc {
        display: flex;
        border: 1px solid #350756;
        padding: 8px 25px 8px 8px;
        align-items: center;

        justify-content: space-between;
    }

    .dq {
        font-size: 16px;
        width: 80%;
        font-weight: 600;
    }

    .answer {
        width: 15%;
        display: flex;
        color: #04092e !important;
        justify-content: space-around;
    }

    .questions {
        color: #000c62 !important
    }

    input[type='radio']:checked:after {
        background-color: #34395e !important;
    }

    input[type='radio']:after {
        background-color: #34395e !important;
    }

    /* radiocss */
    .switch-field {
        display: flex;


    }

    .switch-field input {
        position: absolute !important;
        clip: rect(0, 0, 0, 0);
        height: 1px;
        width: 1px;
        border: 0;
        overflow: hidden;
    }

    .switch-field label {
        background-color: #e4e4e4;
        color: rgba(0, 0, 0, 0.6);
        font-size: 14px;
        line-height: 1;
        text-align: center;
        padding: 8px 16px;
        margin-right: -1px;
        border: 1px solid rgba(0, 0, 0, 0.2);
        box-shadow: inset 0 1px 3px rgba(0, 0, 0, 0.3), 0 1px rgba(255, 255, 255, 0.1);
        transition: all 0.1s ease-in-out;
    }

    .switch-field label:hover {
        cursor: pointer;
    }

    .switch-field input:checked+label {
        background-color: #a5dc86;
        box-shadow: none;
    }

    .switch-field label:first-of-type {
        border-radius: 4px 0 0 4px;
    }

    .switch-field label:last-of-type {
        border-radius: 0 4px 4px 0;
    }

    /* endcss */
    .vl {
        border-left: 1px solid #350756;
        height: 40px;
    }

    .close {
        color: white;
        opacity: 1;
    }
</style>

<div class="main-content">

    <div class="row justify-content-center">
        <div class="col-lg-12 col-md-12">
            <div class="" style="height:100%; padding: 15px">
                <form method="POST" id="registration_form" enctype="multipart/form-data" onsubmit="return false">
                    @csrf
                    <div class="tile" id="tile-1" style="margin-top:10px !important; margin-bottom:10px !important;">
                    </div>
                    <!-- Tab panes -->
                    <div id="content">
                        <div id="tab1">
                            <section class="section">
                                <div class="section-body mt-0">
                                    <div class="row">
                                        <div class="col-12">
                                            <a type="button" href="{{ route('video_creation.create') }}" value="Cancel" class="btn btn-labeled btn-info" title="create" style="background: #044a95 !important; border-color:#a9ca !important; color:white !important;margin-top: 0.5rem;">
                                                <span class="btn-label" style="font-size:15px !important; padding:8px !important"><i class="fa fa-plus"></i></span><span style="font-size:15px !important; padding:8px !important">Add Activity </span></a>
                                            <!-- <a type="button" style="font-size:15px;" class="btn btn-success btn-lg" title="Create" id="gcb" href="{{ route('newenrollment.create') }}">NewEnrollment<i class="fa fa-plus" aria-hidden="true"></i></a> -->
                                            <div class="card mt-3">
                                                <div class="card-body">
                                                    <div class="table-wrapper">
                                                        <div class="table-responsive">
                                                            <table class="table table-bordered" id="align1">
                                                                <thead>
                                                                    <tr>
                                                                        <th>Sl.No</th>
                                                                        <th>Activity Name</th>
                                                                        <!-- <th>status</th> -->
                                                                        <th>Action</th>

                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                
                                                                    <tr>
                                                                        <td></td>
                                                                        <td></td>
                                                                        
                                                                        
                                                                        
                                                                        <td>
                                                                            <a class="btn btn-link" title="show" href=""><i class="fas fa-eye" style="color:green"></i></a>
                                                                            <a class="btn btn-link" title="Edit" href=""><i class="fas fa-pencil-alt"  style="color: blue !important"></i></a>
                                                                            @csrf
                                                                            <input type="hidden" name="delete_id" id="" value="">
                                                                            <a class="btn btn-link" title="Delete" onclick="return myFunction" class="btn btn-link"><i class="far fa-trash-alt"></i></a>
                                                                        </td>
                                                                    </tr>
                                                                    
                                                                    <input type="hidden" class="cfn" id="fn" value="0">
                                                                  
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
                </form>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-1.7.2.min.js"></script>
<script type="application/javascript">
    function myFunction(id) {
        swal.fire({
                title: "Confirmation For Delete ?",
                text: "Are You Sure to delete this data.",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: '#DD6B55',
                confirmButtonText: 'Yes, I am sure!',
                cancelButtonText: "No, cancel it!",
                closeOnConfirm: false,
                closeOnCancel: false
            },
            function(isConfirm) {

                if (isConfirm) {
                    swal.fire("Deleted!", "Data Deleted successfully!", "success");
                    var url = $('#' + id).val();

                    window.location.href = url;

                } else {
                    swal.fire("Cancelled", "Your file is safe :)", "error");
                    e.preventDefault();
                }
            });


    }
</script>


@endsection