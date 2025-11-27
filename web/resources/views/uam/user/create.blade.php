@extends('layouts.adminnav')
@section('content')

<style type="text/css">
    .dropdown-check-list {
        display: inline-block;
    }

    .dropdown-check-list .anchor {
        position: relative;
        cursor: pointer;
        display: inline-block;
        padding: 5px 50px 5px 10px;
        border: 2px solid #ccc;
        width: 300px;
    }

    .dropdown-check-list .anchor:after {
        position: absolute;
        content: "";
        border-left: 2px solid black;
        border-top: 2px solid black;
        padding: 5px;
        right: 10px;
        top: 20%;
        -moz-transform: rotate(-135deg);
        -ms-transform: rotate(-135deg);
        -o-transform: rotate(-135deg);
        -webkit-transform: rotate(-135deg);
        transform: rotate(-135deg);
    }

    .dropdown-check-list .anchor:active:after {
        right: 8px;
        top: 21%;
    }

    .dropdown-check-list ul.items {
        padding: 2px;
        display: none;
        margin: 0;
        border: 1px solid #ccc;
        border-top: none;
    }

    .dropdown-check-list ul.items li {
        list-style: none;
    }

    .dropdown-check-list.visible .anchor {
        color: #0094ff;
    }

    .dropdown-check-list.visible .items {
        display: block;
    }

    .select2-container--default .select2-selection--multiple .select2-selection__rendered li {
        color: black;
        font-weight: 600;
    }
</style>

<div class="main-content">
    <!-- Main Content -->
    <section class="section">
        {{ Breadcrumbs::render('user.create') }}

        <div class="section-body mt-1">
            <h5 class="usercreate" style="color:darkblue; text-align: center;">Users Create</h5>
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <form class="form-horizontal" id="formSubmit" name="uam_modules" method="POST" action="{{ route('user.store') }}">
                                @csrf
                                <div class="row">

                                    <div class="col-md-6">

                                        <div class="form-group">
                                            <label class="control-label">User Name <span style="color: red;font-size: 16px;">*</span></label>
                                            <input class="form-control" type="text" id="name" name="name" placeholder="Enter User Name">
                                            @error('name')
                                            <div class="error">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="control-label">Email <span style="color: red;font-size: 16px;">*</span></label>
                                            <input class="form-control" type="email" id="email" name="email" placeholder="Enter Email">
                                            @error('email')
                                            <div class="error">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="control-label">Password <span style="color: red;font-size: 16px;">*</span></label>
                                            <input class="form-control" type="text" id="password" name="password" placeholder="Enter Password">
                                            <label style="color:#f30202!important">Notes</label>
                                            <p> Password Format - at least 1 uppercase character (A-Z),
                                                at least 1 lowercase character (a-z),
                                                at least 1 digit (0-9),
                                                at least 1 special character (punctuation),
                                                Minimum 8 character
                                            </p>
                                            @error('password')
                                            <div class="error">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="control-label">Confirm Password <span style="color: red;font-size: 16px;">*</span></label>
                                            <input class="form-control" type="password" id="confirm_password" name="confirm_password" placeholder="Enter Password">
                                            @error('confirm_password')
                                            <div class="error">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="control-label">Screen Roles <span style="color: red;font-size: 16px;">*</span></label>
                                            <select class="form-control" id="roles_id" name="roles_id">

                                                <option value="">Please Select Role</option>
                                                @foreach($rows as $key=>$row)
                                                <option value="{{ $row['role_id']}}">{{ $row['role_name'] }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        @error('roles_id')
                                        <div class="error">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="control-label">Additional Roles & Responsibilities</label>
                                            <select class="form-control js-select2" id="additional_roles_id" name="additional_roles_id[]" multiple>
                                                <option value="">Please Select Roles</option>
                                                @foreach($rows as $key=>$row)
                                                <option value="{{ $row['role_id']}}">{{ $row['role_name'] }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        @error('roles_id')
                                        <div class="error">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="control-label">Designation <span style="color: red;font-size: 16px;">*</span></label>
                                            <select class="form-control" id="designation" name="designation">
                                                <option value="">Please Select Designation</option>
                                                @foreach($designation as $key=>$row)
                                                <option value="{{ $row['designation_id'] }}">{{ $row['designation_name'] }}</option>
                                                @endforeach
                                            </select>
                                            @error('designation')
                                            <div class="error">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-12" style="display: none;">
                                        <div class="form-group">
                                            <label class="control-label">Dashboard List <span style="color: red;font-size: 16px;">*</span></label>
                                            <select class="js-select5 form-control dashboard_list_id" id="dashboard_list_id" multiple="multiple" name="dashboard_list_id[]" style="color: black;">

                                                @foreach($dashboard as $key=>$row)
                                                <option value="{{ $row['dashboard_list_id'] }}" selected>{{ $row['dashboard_list_name'] }}</option>
                                                @endforeach
                                            </select>

                                            @error('dashboard_list_id')
                                            <div class="error">{{ $message }}</div>
                                            @enderror


                                        </div>
                                    </div>
                                </div>
                                <input class="form-control" type="hidden" id="user_type" name="user_type" placeholder="Enter Password" value="AD">
                                <div class="row text-center">
                                    <div class="col-md-12">
                                        <a type="button" onclick="submit()" class="btn btn-success"><i class="fa fa-check"></i> Submit</a>&nbsp;
                                        <button class="btn btn-primary" type="reset"><i class="fa fa-undo"></i> Undo </button>&nbsp;
                                        <a class="btn btn-danger" href="{{ route('user.index') }}"><i class="fa fa-times" aria-hidden="true"></i> Cancel </a>&nbsp;
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
<script src="https://cdn.jsdelivr.net/jquery.validation/1.15.1/jquery.validate.min.js"></script>
<script type="text/javascript">
    $(document).ready(function() {

    });

    $(".js-select2").select2({
        closeOnSelect: false,
        placeholder: " Please Select Roles ",
        allowHtml: true,
        allowClear: true,
        tags: true
    });

    $(".js-select5").select2({
        closeOnSelect: false,
        placeholder: " Please Select Dashboard List ",
        allowHtml: true,
        allowClear: true,
        tags: true
    });
</script>
<script>
    function submit() {
        var name = $('#name').val();
        if (name == '') {
            swal.fire("Please Enter User Name", "", "error");
            return false;
        }

        var email = $('#email').val();
        if (email == '') {
            swal.fire("Please Enter Email", "", "error");
            return false;
        }
        let testemail = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
        if (!testemail.test(email)) {
            swal.fire("Please Enter Valid Email Adress", "", "error");
            return false;
        }

        var password = $('#password').val();
        if (password == '') {
            swal.fire("Please Enter Password", "", "error");
            return false;
        }
        
        var pwd_validation = /^(?=.*[0-9])(?=.*[!@#$%^&*])[a-zA-Z0-9!@#$%^&*]{8,16}$/;
        var pwd_check = pwd_validation.test(password);
        if (pwd_check == false) {
            swal.fire("Please choose a strong password! ", "", "error");
            return false;
        }

        var confirm_password = $('#confirm_password').val();
        if (confirm_password == '') {
            swal.fire("Please Enter Confirm Password", "", "error");
            return false;
        }

        if(password != confirm_password) {
            swal.fire("Password doesn't Match", "", "error");
            return false;
        }

        var roles_id = $('#roles_id').val();
        if (roles_id == '') {
            swal.fire("Please Enter Role", "", "error");
            return false;
        }

        var designation = $('#designation').val();
        if (designation == '') {
            swal.fire("Please Enter Designation", "", "error");
            return false;
        }

        var dashboard_list_id = $('#dashboard_list_id').val();
        if (dashboard_list_id == '') {
            swal.fire("Please Enter Dashboard List", "", "error");
            return false;
        }

        document.getElementById('formSubmit').submit();

    }
</script>
<script>
document.addEventListener("DOMContentLoaded", function() {
    var rolesSelect = document.getElementById("roles_id");
    var additionalRolesSelect = document.getElementById("additional_roles_id");

    rolesSelect.addEventListener("change", function() {
        var selectedRoleId = this.value;
        if (selectedRoleId) {
            var options = additionalRolesSelect.options;
            for (var i = 0; i < options.length; i++) {
                options[i].disabled = false;
            }
            var optionToDisable = additionalRolesSelect.querySelector("option[value='" + selectedRoleId + "']");
            if (optionToDisable) {
                optionToDisable.disabled = true;
            }
        }
    });
});
</script>
@endsection