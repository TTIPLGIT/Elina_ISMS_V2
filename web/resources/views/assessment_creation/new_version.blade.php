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

    /* body{
        background-color: white !important;
    } */
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

    .nav-justified {
        display: flex !important;
        align-items: center !important;
    }

    hr {
        border-top: 1px solid #6c757d !important;
    }

    .dateformat {
        height: 41px;
        padding: 8px 10px !important;
        width: 100%;
        border-radius: 5px !important;
        border-color: #bec4d0 !important;
        box-shadow: 2px 2px 4px rgb(0 0 0 / 15%);
        border-style: outset;
    }

    h4 {
        text-align: center;
    }

    .question {
        background-color: white;
        border-radius: 12px !important;
        margin-top: 2rem;
    }

    .question label {
        text-align: center;
    }

    .questionnaire {
        text-align: center;
    }

    .btn-success {
        margin: auto;
    }

    .colorbutton {
        background-color: darkblue;
        color: white;
        cursor: none;
        padding: 0.5rem 1rem;
        border: 0;
        border-color: darkblue;
        border-radius: 5px;
    }

    .colorbutton:hover {
        background-color: darkblue !important;
        color: white;
    }

    #list_section {
        /* display: none; */
    }

    .alignment {
        text-align: center;
    }
</style>
<div class="main-content">

    <div class="section-body mt-0">
        <h4 style="color:darkblue">Report Creation </h4>



        <div class="card question">
            <div class="card-body">
                <div class="row is-coordinate">
                    <div class="col-md-4 alignment">
                        <div class="form-group">
                            <label class="control-label">Type</label><span class="error-star" style="color:red;">*</span>

                            <input class="form-control" type="text" id="report_type" name="report_type" value="{{$report[0]['report_type']}}" autocomplete="off">



                        </div>
                    </div>
                    <div class="col-md-4 alignment">
                        <div class="form-group">
                            <label class="control-label">Report Name</label><span class="error-star" style="color:red;">*</span>
                            <input class="form-control" type="text" id="report_name" name="report_name" value="{{$report[0]['report_name']}}" autocomplete="off">

                        </div>
                    </div>


                    <div class="col-md-4 alignment">
                        <div class="form-group questionnaire">

                            <label class="control-label required">Total Page</label><br>
                            <input class="form-control" type="number" id="page" name="page" value="{{$report[0]['pages']}}" autocomplete="off">
                        </div>
                    </div>


                    <div class="col-md-4 alignment">
                        <div class="form-group">
                            <label class="control-label">Version</label><span class="error-star" style="color:red;">*</span>
                            <input class="form-control" type="text" id="report_version" name="report_version" value="2.0 [Draft]" autocomplete="off">

                        </div>
                    </div>


                    <!-- <div class="col-md-3 alignment">
                    <div class="form-group">
                        <label class="control-label">Status</label><span class="error-star" style="color:red;">*</span>
                        <input class="form-control" type="text" id="child_name" name="child_name" value="New" autocomplete="off">
                    </div>
                </div> -->
                </div>
            </div>
        </div>

        <div class="row text-center">
            <div class="col-md-12">
                <button onclick="newmeeting()" class="colorbutton mb-1" id="headerupdate" style="margin-top:1%">Update</button>
            </div>
        </div>



        <form action="{{route('asessmentreportmaster.store')}}" id="new_page" method="POST">
            {{ csrf_field() }}
            <input type="hidden" value="{{$report[0]['reports_id']}}" name="report_id" id="report_id">
            <div class="row justify-content-center" id="invite">

                <div class="card" style="width:100%">
                    <div class="card-body">
                        <!-- <div class="col-md-4 offset-md-4">
                            <div class="form-group questionnaire">
                                <label class="control-label">Page Number</label>
                                <select class="form-control" name="page_number" id="page_number">

                                </select>
                                
                            </div>
                        </div> -->

                        <div class="col-lg-12">
                            <div class="form-group">
                                <textarea class="form-control" id="meeting_description" name="meeting_description" required></textarea>
                            </div>
                            @php
                            $c_page = $report[0]['pages'];
                            $c_page++;
                            @endphp
                            <p>Page Number : {{$c_page}}</p>
                            <input type="hidden" value="{{$c_page}}" name="c_page" id="c_page">
                        </div>
                    </div>
                </div>
                <div class="col-md-12" style="text-align:center">
                    <button onclick="discription_content()" class="colorbutton mb-1" style="margin-top:1%">Save</button>
                    <button onclick="discription_content()" class="colorbutton mb-1" style="margin-top:1%">Submit</button>
                </div>


            </div>





        </form>

        @if($pages != [])

        <div class="card question" id="list_section">
            <div class="card-body">
                <div class="table-wrapper">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="length5">
                            <thead>
                                <tr>
                                    <th>Sl.No</th>
                                    <th>Page Number</th>
                                    <th width="20%">Action</th>
                                    <th>Active Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($pages as $page)
                                <tr>
                                    <td>{{$loop->iteration}}</td>
                                    <td>{{$page['page']}}</td>
                                    <td>
                                        <a class="btn btn-link" title="Edit" data-toggle="modal" data-target="#editmodulemodal{{$page['report_details_id']}}" style="color:darkblue"><i class="fas fa-pencil-alt"></i></a>

                                        <!-- <a class="btn btn-link" title="Edit" data-toggle="modal" style="color:darkblue"><i class="fas fa-pencil-alt"></i></a> -->
                                        @csrf
                                        <input type="hidden" name="delete_id" id="" value="">
                                        <a class="btn btn-link" title="Delete" class="btn btn-link"><i class="far fa-trash-alt"></i></a>
                                        <a class="btn btn-link" title="show" class="btn btn-link"><i class="far fa-eye"></i></a>
                                    </td>
                                    <td style="text-align: center;">
                                        <label class="switch " data-bs-toggle="tooltip" data-bs-placement="top" title="Enable / Disable">
                                            <input type="hidden" name="toggle_id" value="">
                                            <input type="checkbox" class="toggle_status" name="is_active" checked>
                                            <span class="slider round"></span>
                                        </label>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        @endif

    </div>
</div>
<!-- Edit -->
@foreach($pages as $data)
<div class="modal fade" id="editmodulemodal{{$data['report_details_id']}}">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <form name="edit_form" action="{{ route('reports_master.update', \Crypt::encrypt($page['report_details_id'])) }}" method="POST" id="edit_page_form{{$page['report_details_id']}}">
                {{ csrf_field() }}
                @method('PUT')
                <div class="modal-header" style="background-color:DarkSlateBlue;">
                    <h5 class="modal-title" id="#editModal">Edit Page</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row register-form">
                        <div class="row" style="margin-bottom: 15px;margin-top: 20px;">
                        <div class="col-lg-12">
                            <div class="form-group">
                                <textarea class="form-control" id="meeting_description" name="meeting_description" required>
                                {{$data['page_description']}}
                                </textarea>
                            </div>
                            <!-- <p>Page Number : {{$c_page}}</p> -->
                            <input type="hidden" value="{{$report[0]['reports_id']}}" name="reports_id" id="reports_id">
                        </div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <div class="mx-auto">

                            <a type="button" onclick="editbuttonclick('{{$page['report_details_id']}}')" class="btn btn-labeled btn-succes" title="Update" style="background: green !important; border-color:green !important; color:white !important">
                                <span class="btn-label" style="font-size:13px !important;"><i class="fa fa-check"></i></span>Update</a>
                            <a type="button" data-dismiss="modal" aria-label="Close" value="Cancel" class="btn btn-labeled btn-space" title="Cancel" style="background: red !important; border-color:red !important; color:white !important">
                                <span class="btn-label" style="font-size:13px !important;"><i class="fa fa-remove"></i></span>Cancel</a>


                        </div>
                    </div>

            </form>

        </div>
    </div>
</div>
</div>

<script>
    function editbuttonclick(id) {

        document.getElementById('edit_page_form' + id).submit();
    }
</script>
@endforeach
<!-- End -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/tinymce/4.5.6/tinymce.min.js"></script>
<script src="http://cdnjs.cloudflare.com/ajax/libs/tinymce/4.5.6/jquery.tinymce.min.js"></script>

<script type="text/javascript">
    $(document).ready(function() {


        tinymce.init({
            selector: 'textarea#meeting_description',
            height: 180,
            menubar: false,
            branding: false,
            toolbar: 'undo redo | formatselect | ' +
                'bold italic backcolor | alignleft aligncenter ' +
                'alignright alignjustify | bullist numlist outdent indent | ' +
                'removeformat | help',
            content_style: 'body { font-family:Helvetica,Arial,sans-serif; font-size:14px }'
        });
        event.preventDefault()
    });
</script>

<script>
    //   function newmeeting()

    //   {

    //     document.getElementById('invite').style.display = "block";
    //   }
    //   function newmeeting_id()

    // {

    //   document.getElementById('list_section').style.display = "block";
    // }
    // function pagenumber()
    // {
    //    var pageheader = document.getElementById('page').value;

    //     var optionsdata = "";
    //         for (var i = 1; i <=pageheader; i++) {

    //             var option = '<option value="">Select the Page </option>';
    //             optionsdata += "<option value=" + i + " >Page - " + i + "</option>";
    //         }
    //         var stageoption = option.concat(optionsdata);
    //         console.log(stageoption);
    //         var demonew = $('#page_number').html(stageoption);

    //         // console.log(company_name)
    //         // document.getElementById('company_name').value = data[0].company_name;
    // }
    // var dropdown = document.getElementById('page_number');
    // dropdown.addEventListener("change", listview);

    // function listview(e)
    // {
    //     alert(e.target.value);
    // }
    function discription_content() {
        document.getElementById('new_page').submit();
    }
</script>
<script>
    $("#headerupdate").click(function(event) {

                event.preventDefault();
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                var report_type = document.getElementById("report_type").value;
                if (report_type == null || report_type == "") {
                    swal.fire("Please Select Type", "", "error");
                    return false;
                }

                var report_name = document.getElementById("report_name").value;
                if (report_name == null || report_name == '') {
                    swal.fire("Please Enter Report Name", "", "error");
                    return false;
                }





                var version = document.getElementById("report_version").value;
                $('#headerupdate').prop('disabled', true);

                $.ajax({
                            url: '{{ url(' / master / assessment / header ') }}',
                            type: " POST",
                            data: {
                                _token: '{{csrf_token()}}',
                                report_type: report_type,
                                report_name: report_name,
                                version: version
                            },
                            success: function(data) {
                                    console.log(data);
                                    document.getElementById('report_id').value = data; // document.getElementById('headerupdate').style.display="none" ; }, error: function(data) { swal.fire({ title: "Error" , text: data, type: "error" , confirmButtonColor: '#e73131' , confirmButtonText: 'OK' , }); } }); }); 
</script>

@endsection