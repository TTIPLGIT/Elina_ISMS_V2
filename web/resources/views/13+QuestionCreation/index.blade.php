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

    .trash {
        color: red !important;
    }

    .publish {
        background: green !important;
        border-color: #a9ca !important;
        color: white !important;
    }

    .slider {
        position: absolute;
        cursor: pointer;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-color: red;
        -webkit-transition: .4s;
        transition: .4s;
    }

    input:checked+.slider {
        background-color: green;
    }
    .card-body
    {
        width: 100% !important;
    }
</style>
<div class="main-content">
    {{ Breadcrumbs::render('thirteenyrsquestion_creation.index') }}
    <a type="button" href="{{ route('thirteenyrsquestion_creation.create') }}" value="Cancel" class="btn btn-labeled btn-info" title="create" style="background: #044a95 !important; border-color:#a9ca !important; color:white !important;margin-top: 0.5rem;">
        <span class="btn-label" style="font-size:15px !important; padding:8px !important"><i class="fa fa-plus"></i></span><span style="font-size:15px !important; padding:8px !important">13+ Questionnaire</span></a>
    <div class="row">
        <div class="card-body">
            <h3 class="text-center" style="color:darkblue;">13+ Question Creation List</h3>

            <div class="table-wrapper">
                <div class="table-responsive">
                    <table class="table table-bordered" id="align1">
                        <thead>
                            <tr>
                                <th>Sl.No</th>
                                <th>Questionnaire Name</th>
                                <th>Versions</th>
                                <th>Type</th>
                                <th>Status</th>
                                <th>Action</th>

                            </tr>
                        </thead>
                        <tbody>

                            <!-- <tr>
                                <td>1</td>
                                <td>Executive functioning - The way I process</td>


                                <td>SAIL</td>
                                <td>Inprogress</td>
                                <td>
                                    
                                    <a class="btn btn-link" title="Edit" href="{{ route('thirteenquestion_creation.add_questions', 10) }}"><i class="fas fa-pencil-alt" style="color: blue !important"></i></a>

                                    <input type="hidden" name="delete_id" id="" value="">
                                    <a class="btn btn-link trash" title="Delete" onclick="return myFunction('1');" class="btn btn-link"><i class="far fa-trash-alt"></i></a>
                                </td>
                            </tr> -->
                            <tr>
                                <td>1</td>
                                <td>Executive functioning - The way I process</td>
                                <td>-</td>

                                <td>SAIL</td>
                                <td>Completed</td>
                                <td>
                                    <a class="btn publish" title="Publish" href="{{ route('thirteenquestion_creation.add_questions', 10) }}">Publish</a>

                                    <a class="btn btn-link" title="Edit" href="{{ route('thirteenquestion_creation.add_questions', 10) }}"><i class="fas fa-pencil-alt" style="color: blue !important"></i></a>

                                    <input type="hidden" name="delete_id" id="" value="">
                                    <a class="btn btn-link trash" title="Delete" onclick="return myFunction('1');" class="btn btn-link"><i class="far fa-trash-alt"></i></a>
                                </td>
                            </tr>
                            <tr>
                                <td>2</td>
                                <td id="versions">Executive functioning - The way I process</td>
                                <td>1.0</td>

                                <td>SAIL</td>
                                <td>Published</td>
                                <td>
                                    <a class="btn btn-link" title="New Version" onclick="return newversion();"><i class="fas fa-plus" style="color:green"></i></a>

                                    <!-- <a class="btn btn-link" title="Edit" href="{{ route('thirteenquestion_creation.add_questions', 10) }}"><i class="fas fa-pencil-alt" style="color: blue !important"></i></a> -->
                                    <!-- <a class="btn new_version" title="New Version" onclick="return newversion();" style="background: darkblue;color: white;">New Version</a> -->

                                    <input type="hidden" name="delete_id" id="" value="">
                                    <!-- <a class="btn btn-link trash" title="Delete" onclick="return myFunction('1');" class="btn btn-link"><i class="far fa-trash-alt"></i></a> -->
                                </td>
                            </tr>

                            <tr id="draftruler" style="display:none">
                                <td>3</td>
                                <td id="versions">Executive functioning - The way I process</td>

                                <td>2.0</td>
                                <td>SAIL</td>
                                <td>Draft</td>
                                <td>
                                    <!-- <a class="btn btn-link" title="View" href=""><i class="fas fa-eye" style="color:green"></i></a> -->
                                    <!-- <a class="btn new_version" title="New Version"  style="background: darkblue;color: white;">New Version</a> -->

                                    <a class="btn" title="New Version" href="{{ route('thirteenquestion_creation.add_questions', 10) }}" style="background: darkblue;color: white;">New Version</a>
                                    <a class="btn btn-link trash" title="Delete" onclick="return myFunction('1');" class="btn btn-link"><i class="far fa-trash-alt"></i></a>

                                    <a href="#addModal2" data-toggle="modal" data-target="#addModal2" class="btn btn-primary modalbtn" title="View" data-toggle="modal" data-target="#templates" style="margin-inline:5px;"><i class="fa fa-bars" style="color:white!important"></i></a>

                                    <!-- <a class="btn btn-link" title="Edit" href="{{ route('thirteenquestion_creation.add_questions', 10) }}"><i class="fas fa-pencil-alt" style="color: blue !important"></i></a> -->
                                    <!-- <a href="#addModal2" data-toggle="modal" data-target="#addModal2" class="btn btn-primary modalbtn" title="View" data-toggle="modal" data-target="#templates" style="margin-inline:5px;display:none"><i class="fa fa-bars" style="color:white!important"></i></a> -->

                                    <input type="hidden" name="delete_id" id="" value="">
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

<div class="modal fade" id="addModal2">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="main-contents">
                <section class="section">
                    <div class="modal-header bg-primary" style=" background-color: rgb(0 103 172) !important;">
                        <h4 class="modal-title">Executive functioning - The way I process Version History</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    </div>
                    <div class="modal-body" style="">
                        <div class="section-body mt-2">
                            <div class="row">
                                <div class="col-12">
                                    <div class="mt-0 ">
                                        <div class="card-body" id="" style="background-color: #a0c4e3 !important;">
                                            <div class="row">
                                            </div>
                                            <div class="table-wrapper">
                                                <div class="table-responsive  p-3">
                                                    <table class="table table-bordered">
                                                        <thead>
                                                            <tr>
                                                                <th>Sl. No.</th>
                                                                <th>Versions</th>
                                                                <th>Author</th>
                                                                <th>Status</th>
                                                                <th>Action</th>

                                                            </tr>
                                                        </thead>
                                                        <tbody>



                                                            <tr>
                                                                <td>1</td>
                                                                <td>Version 1</td>
                                                                <td>IS-head</td>
                                                                <td>Published</td>
                                                                <td>
                                                                    <!-- <a class="btn" title="New Version" onclick="return newversion();" style="background: darkblue;color: white;">New Version</a> -->
                                                                    <a class="btn btn-link" style="display: none;" title="Edit" href="{{ route('thirteenquestion_creation.add_questions', 10) }}"><i class="fas fa-pencil-alt" style="color: blue !important"></i></a>

                                                                    <input type="hidden" name="delete_id" id="" value="">
                                                                    <a class="btn btn-link trash" style="display: none;" title="Delete" onclick="return myFunction('1');" class="btn btn-link"><i class="far fa-trash-alt"></i></a>

                                                                    <label class='switch' data-bs-toggle='tooltip' data-bs-placement='top' title='Enable / Disable'>
                                                                        <input type='checkbox' class='toggle_status' id="required" name='required' checked value="1">
                                                                        <span class='slider round'></span>
                                                                    </label>

                                                                </td>


                                                            </tr>
                                                            <tr>
                                                                <td>2</td>

                                                                <td>Version 2</td>
                                                                <td>IS-head</td>
                                                                <td>Draft</td>
                                                                <td>-
                                                                </td>


                                                            </tr>
                                                            <tr>
                                                                <td>3</td>

                                                                <td>Version 2</td>
                                                                <td>IS-head</td>
                                                                <td>Completed</td>
                                                                <td>
                                                                    <!-- <a class="btn" title="New Version" onclick="return newversion();" style="background: darkblue;color: white;">New Version</a> -->
                                                                    <!-- <a class="btn btn-link" title="Edit" href="{{ route('thirteenquestion_creation.add_questions', 10) }}"><i class="fas fa-pencil-alt" style="color: blue !important"></i></a>

                                                                    <input type="hidden" name="delete_id" id="" value="">
                                                                    <a class="btn btn-link trash" title="Delete" onclick="return myFunction('1');" class="btn btn-link"><i class="far fa-trash-alt"></i></a> -->

                                                                    <label class='switch' data-bs-toggle='tooltip' data-bs-placement='top' title='Enable / Disable'>
                                                                        <input type='checkbox' class='toggle_status' id="required" name='required' value="1">
                                                                        <span class='slider round'></span>
                                                                    </label>

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
                </section>
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
                swal.fire("Deleted!", "Question Deleted successfully!", "success").then(() => location.reload());
            }
        });


    }

    document.addEventListener("DOMContentLoaded", function() {
        // Check local storage for confirmation status
        // var isConfirmed = localStorage.getItem('newVersionConfirmed') === 'true';

        // Display or hide the button based on confirmation status
        var newVersionBtn = document.querySelector('.modalbtn');
        var newVersionBtn1 = document.querySelector('.new_version');
        newVersionBtn.style.display = localStorage.getItem('newVersionConfirmed') ? '' : '';
        newVersionBtn1.style.display = localStorage.getItem('newVersionConfirmed') ? 'none' : '';
    });

    function newversion1() {
        swal.fire({
            title: "Confirmation for a new version ?",
            text: "Are you sure,you want to create a New version of this Questionnaire.",
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
                localStorage.setItem('newVersionConfirmed', 'true');
                swal.fire("Success!", "New Version of Questionanaire created successfully!", "success").then(() => window.location.href = "/thirteenquestion_creation/add_questions/" + 10);
            }
        });


    }

    function newversion() {
        swal.fire({
            title: "Confirmation for a new version ?",
            text: "Are you sure,you want to create a New version of this Questionnaire.",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: '#28a745',
            confirmButtonText: 'Yes, I am sure!',
            cancelButtonColor: '#dc3545',
            cancelButtonText: "No, cancel it!",
            closeOnConfirm: false,
            closeOnCancel: false
        }).then((result) => {
            /* Read more about isConfirmed, isDenied below */
            if (result.isConfirmed) {
                localStorage.setItem('newVersionConfirmed', 'true');
                swal.fire("Success!", "New Version of Questionanaire created successfully!", "success").then(() => document.getElementById('draftruler').style.display = "");

            }

        });


    }
</script>
<script>
    // $('.toggle_status').on('change', function() {
    //     alert('effef');
    // })
    $(document).ready(function() {
        document.querySelectorAll('.toggle_status').forEach(function(toggle) {
            console.log(toggle);
            toggle.addEventListener('change', function() {

                // Find the parent row
                var row = this.closest('tr');

                // Check if the toggle is checked or unchecked
                var isChecked = this.checked;

                // If checked, find the checked row and swap its state with the current row
                if (isChecked) {
                    document.querySelectorAll('input.toggle_status:checked').forEach(function(checkedToggle) {
                        // Uncheck the toggle in the previous checked row
                        if (checkedToggle !== toggle) {
                            var checkedRow = checkedToggle.closest('tr');
                            checkedToggle.checked = false;

                            // Swap rows
                            swapRows(row, checkedRow);
                            swapVersions();
                        }
                    });
                }
            });
        });
    });


    // Function to swap two rows
    function swapRows(row1, row2) {
        var siNo1 = row1.querySelector('td:first-child').innerText;
        var siNo2 = row2.querySelector('td:first-child').innerText;
        row1.querySelector('td:first-child').innerText = siNo2;
        row2.querySelector('td:first-child').innerText = siNo1;

        // Swap Status
        var status1 = row1.querySelector('td:nth-child(4)').innerText;
        var status2 = row2.querySelector('td:nth-child(4)').innerText;
        row1.querySelector('td:nth-child(4)').innerText = status2;
        row2.querySelector('td:nth-child(4)').innerText = status1;
        // Swap buttons based on Status
        // swapButtons(row1, status1);
        // swapButtons(row2, status2);

        // Clone the rows to preserve event listeners and other properties
        var clonedRow1 = row1.cloneNode(true);
        var clonedRow2 = row2.cloneNode(true);
        // swapVersions(row1, row2);
        // Replace row1 with clonedRow2
        row1.parentNode.replaceChild(clonedRow2, row1);

        // Replace row2 with clonedRow1
        row2.parentNode.replaceChild(clonedRow1, row2);
        // Swap Versions

        // var row1Html = row1.innerHTML;
        // row1.innerHTML = row2.innerHTML;
        // row2.innerHTML = row1Html;
    }
    // Function to swap buttons based on Status
    // function swapButtons(row, status) {

    //     var editButton = row.querySelector('a.btn-link[title="Edit"]');
    //     var newVersionButton = row.querySelector('a.btn[title="New Version"]');
    //     var deleteButton = row.querySelector('a.btn-link[title="Delete"]');

    //     if (editButton) {
    //         editButton.style.display = status === 'Published' ? '' : 'none';
    //         deleteButton.style.display = status === 'Published' ? '' : 'none';
    //         newVersionButton.style.display = status === 'Completed' ? '' : '';
    //         // editButton.style.display = status === 'Completed' ? 'inline' : 'none';
    //         // deleteButton.style.display = status === 'Completed' ? 'inline' : 'none';


    //     }



    //     // if (deleteButton) {
    //     //     deleteButton.style.display = 'inline';
    //     // }
    //     // Add additional conditions based on other statuses if needed
    // }
    // Function to swap version information
    function swapVersions() {
        // alert(row1);
        // alert(row2);

        var version1 = document.querySelector('#versions');

        version1.innerText = "Executive functioning - The way I process V1";

    }
</script>


@endsection