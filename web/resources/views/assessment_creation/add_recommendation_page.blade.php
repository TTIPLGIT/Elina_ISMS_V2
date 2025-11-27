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

    h5 {
        text-align: center;
    }

    .question {
        background-color: white;
        border-radius: 12px !important;
        /* margin-top: 2rem; */
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

    table {
        text-align: left;
        position: relative;
        border-collapse: collapse;
    }

    th,
    td {
        margin: 0;

    }

    th {
        background: #62acde;
        position: sticky;
        top: 0;
        margin: 0 !important;
        box-shadow: 0 2px 2px -1px rgba(0, 0, 0, 0.4);
    }

    .table thead th {
        vertical-align: inherit !important;
        text-align: center;
    }

    .table_input {
        width: 100%;
        height: 46px;
        outline: none;
        border: none;
    }

    .table_icon {
        position: absolute;
        top: 97px;
        left: 87%;
    }
</style>
<div class="main-content">
    {{ Breadcrumbs::render('assessmentreportmaster.edit',$report[0]['reports_id']) }}
    <div class="section-body mt-0">
        <h4 style="color:darkblue">Report Creation </h4>
        <div class="card question">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-3 alignment">
                        <div class="form-group">
                            <label class="control-label">Type</label><span class="error-star" style="color:red;">*</span>

                            <input class="form-control" type="text" id="report_type" name="report_type" value="{{$report[0]['report_type']}}" disabled autocomplete="off">



                        </div>
                    </div>
                    <div class="col-md-5 alignment">
                        <div class="form-group">
                            <label class="control-label">Report Name</label><span class="error-star" style="color:red;">*</span>
                            <input class="form-control" type="text" id="report_name" name="report_name" value="{{$report[0]['report_name']}}" disabled autocomplete="off">

                        </div>
                    </div>


                    <div class="col-md-2 alignment">
                        <div class="form-group questionnaire">

                            <label class="control-label required">Total Page</label><br>
                            <input class="form-control" type="number" id="page" name="page" value="{{$report[0]['pages']}}" disabled autocomplete="off">
                        </div>
                    </div>


                    <div class="col-md-2 alignment">
                        <div class="form-group">
                            <label class="control-label">Version</label><span class="error-star" style="color:red;">*</span>
                            <input class="form-control" type="text" id="report_version" name="report_version" disabled value="{{$report[0]['version']}}" autocomplete="off">
                        </div>
                    </div>
                </div>

                <!-- <div class="row text-center">
                    <div class="col-md-12">
                        <button onclick="submitForm()" class="colorbutton mb-1" id="headerupdate" style="margin-top:1%">Update</button>
                    </div>
                </div> -->
            </div>
        </div>

        <form action="{{route('asessmentreportmaster.report_store')}}" id="new_page" method="POST">
            {{ csrf_field() }}
            <input type="hidden" value="{{$report[0]['reports_id']}}" name="report_id" id="report_id">
            <input type="hidden" name="btn_statu" id="btn_statu">
            <div class="row justify-content-center" id="invite" style="margin: 10px 0px 0px 0px;">

                <div class="card" style="width:100%">

                    <div class="card-body">
                        <h5 style="color:darkblue; margin:15px">Add New Page</h5>

                        <div class="col-lg-12">
                            <div class="form-group">
                                <textarea class="form-control" id="meeting_description" maxlength="500" name="meeting_description" required></textarea>
                            </div>
                            @php
                            $c_page = $report[0]['pages'];
                            $c_page++;
                            @endphp
                            <p>Page Number : {{$c_page}}</p>
                            <input type="hidden" value="{{$c_page}}" name="c_page" id="c_page">
                        </div>
                        @if($c_page == '6')
                        <!--  -->
                        <div class="col-12 scrollable fixTableHead title-padding">
                            <div class="table-responsive">
                                <table class="table table-bordered card-body" id="main">
                                    <thead>
                                        <tr>

                                            <th>Areas</th>
                                            <th>Strength </th>
                                            <th>Recommended Environment</th>
                                            <th>Some strategies recommended</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($table_num as $key=>$rows)
                                        <tr id="row">

                                            <td><textarea name="rows[row{{$loop->iteration}}][{{$rows['recommendation_detail_area_id']}}]">{{ $rows['area_name']}}</textarea></td>
                                            <td><textarea name="rows[row{{$loop->iteration}}][1]"></textarea></td>
                                            <td><textarea name="rows[row{{$loop->iteration}}][2]"></textarea></td>
                                            <td><textarea name="rows[row{{$loop->iteration}}][3]"></textarea></td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <!-- <div class="text-center"><button onclick="addRow();" class="btn-success"><i class="fa fa-plus"></i> ADD NEW</button></div> -->
                        <!-- <input type="button" value="Add New Row" onclick="addRow();" id="rowButton" /> -->
                        <!--  -->
                        @endif
                        @if($c_page == '7')
                        <!--  -->
                        <div class="col-12 scrollable fixTableHead title-padding">
                            <div class="table-responsive">
                                <table class="table table-bordered card-body" id="main2">
                                    <thead>
                                        <tr>
                                            <th>Areas</th>
                                            <th colspan="12">Factors</th>

                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($table_num_1 as $key=>$rows)
                                        <tr id="row2" class="table_column{{$loop->iteration}}">
                                            <td><textarea name="rows2[table_column{{$loop->iteration}}][{{$rows['recommendation_detail_area_id']}}]">{{ $rows['area_name']}}</textarea></td>
                                            <td class="" id="table_column{{$loop->iteration}}">
                                                <div class="col arNew_table_column{{$loop->iteration}}" id="arNew" style="display:flex;flex-direction:column;width: 100%!important;">
                                                    <textarea name="rows2[table_column{{$loop->iteration}}][row1][1]"></textarea>
                                                    <textarea name="rows2[table_column{{$loop->iteration}}][row1][2]"></textarea>
                                                    <button id="factors" name="factors" title="Add Factor" class="btn viu" type="button" value="1">
                                                        <i style="color: blue;font-size: 20px;" id="plus1" class="fa fa-plus-circle" aria-hidden="true"></i></button>
                                                </div>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <!-- <div class="text-center"><button onclick="addRow2();" class="btn-success"><i class="fa fa-plus"></i> ADD NEW</button></div> -->
                        <!-- <input type="button" value="Add New Row" onclick="addRow();" id="rowButton" /> -->
                        <!--  -->
                        @endif
                        <div class="col-md-12" style="text-align:center">
                            <button onclick="discription_content('Saved')" class="colorbutton mb-1" name="type" value="Saved" style="margin-top:1%">Save Page</button>
                            <button onclick="report_submit('Completed')" class="colorbutton mb-1" name="type" value="Completed" style="margin-top:1%">Submit Report</button>
                        </div>
                    </div>
                </div>
            </div>

        </form>

        @if($pages != [])
        <div class="card question" style="margin: 10px 0 0 0;">
            <div class="card-body">
                <h5 style="color:darkblue; margin:15px">Created Pages</h5>
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
                                        @csrf
                                        <a class="btn btn-link" title="show" data-toggle="modal" data-target="#viewmodulemodal{{$page['report_details_id']}}"><i class="far fa-eye"></i></a>

                                    </td>
                                    <td style="text-align: center;">
                                        <label class="switch " data-bs-toggle="tooltip" data-bs-placement="top" title="Enable / Disable">
                                            <input type="hidden" name="toggle_id" value="{{$page['report_details_id']}}">
                                            <input type="checkbox" class="toggle_status" onclick="functiontoggle('{{$page['report_details_id']}}')" id="is_active{{$page['report_details_id']}}" name="is_active" @if($page['enable_flag']=='1' ) checked @endif>
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
<script>
    let table = document.getElementById('factors').addEventListener('click', table_num);
    const table_all = document.querySelectorAll('#factors');
    for (let i = 0; i < table_all.length; i++) {

        table_all[i].addEventListener('click', table_num);
    }

    function table_num(e) {
        // console.log(e);
        if (e.target.tagName == "BUTTON") {
            if (e.target.children[0].className == "fa fa-plus-circle") {
                e.target.style.visibility = 'hidden';
                console.log(e.target.parentElement.parentElement.parentElement.className);
                $(`.${e.target.parentElement.parentElement.parentElement.className}`).append('<td><td><div class="col valiadtion_func" style="display:flex;flex-direction:column;width: 100%!important;"><textarea name="rows2[row1][2]"></textarea><textarea name="rows2[row1][2]"></textarea><button id="factors" name="factors" title="Add Factor" class="btn" type="button" value="1"><i style="color: blue;font-size: 20px;" id="plus1" class="fa fa-minus-circle" aria-hidden="true"></i></button></div></td></td>')
                const table_all2 = document.querySelectorAll('#factors');
                for (let y = 0; y < table_all2.length; y++) {

                    table_all2[y].addEventListener('click', table_num);
                }
            } else {
                console.log(e.target.parentElement.parentElement.previousElementSibling.previousElementSibling.children[0].lastElementChild);
                e.target.parentElement.parentElement.previousElementSibling.previousElementSibling.children[0].lastElementChild.style.visibility = "visible";
                e.target.parentElement.parentElement.style.display = 'none';
            }

        } else {
            if (e.target.className == "fa fa-plus-circle") {
                e.target.parentElement.style.visibility = 'hidden';
                console.log(e.target.parentElement.parentElement.parentElement.parentElement.className);
                var cName = e.target.parentElement.parentElement.parentElement.parentElement.className;
                var area = $('.arNew_' + cName).length;
                area = area + 1;
                $(`.${e.target.parentElement.parentElement.parentElement.parentElement.className}`).append('<td><td><div class="col arNew_' + cName + '" id="arNew" style="display:flex;flex-direction:column;width: 100%!important;"><textarea name="rows2[' + cName + '][row' + area + '][1]"></textarea><textarea name="rows2[' + cName + '][row' + area + '][2]"></textarea><button id="factors" name="factors" title="Add Factor" class="btn" type="button" value="1"><i style="color: blue;font-size: 20px;" id="plus1" class="fa fa-minus-circle" aria-hidden="true"></i></button></div></td></td>')
                const table_all2 = document.querySelectorAll('#factors');
                for (let y = 0; y < table_all2.length; y++) {

                    table_all2[y].addEventListener('click', table_num);
                }

            } else {
                console.log(e.target.parentElement.parentElement.parentElement.previousElementSibling.previousElementSibling.children[0].lastElementChild);
                e.target.parentElement.parentElement.parentElement.previousElementSibling.previousElementSibling.children[0].lastElementChild.style.visibility = "visible";
                e.target.parentElement.parentElement.parentElement.remove();
                // e.target.parentElement.parentElement.parentElement.style.display = 'none';
            }






        }

        const table_all2_validation = document.querySelectorAll('[name="rows2[' + cName + '][row' + area + '][1]"]');
        for (let z = 0; z < table_all2_validation.length; z++) {

            table_all2_validation[z].addEventListener('keyup', table_num_validation);
        }
    }

    function table_num_validation(e) {
        console.log(e.target.value);
        if (e.target.value != '') {
            e.target.nextElementSibling.nextElementSibling.children[0].classList.remove("fa-minus-circle");
            e.target.nextElementSibling.nextElementSibling.children[0].classList.add("fa-plus-circle");



        } else {
            e.target.nextElementSibling.nextElementSibling.children[0].classList.add("fa-minus-circle");
            e.target.nextElementSibling.nextElementSibling.children[0].classList.remove("fa-plus-circle");

        }
    }

    function addRow() {
        var table = document.getElementById("main");
        var row = document.getElementById("row");
        var rws = table.rows;
        var rowlength = rws.length;
        var cols = table.rows[0].cells.length;
        var row = table.insertRow(rws.length);
        var cell;
        for (var i = 0; i < cols; i++) {
            cell = row.insertCell(i);
            j = i + 1;
            cell.innerHTML = '<textarea name="rows[row' + rowlength + '][' + j + ']"></textarea>';
        } //rows[row1][1]
    }

    function addRow2() {
        var table = document.getElementById("main2");
        var row = document.getElementById("row2");
        var rws = table.rows;
        var rowlength = rws.length;
        var cols = table.rows[0].cells.length;
        var row = table.insertRow(rws.length);
        var cell;
        for (var i = 0; i < cols; i++) {
            cell = row.insertCell(i);
            j = i + 1;
            cell.innerHTML = '<textarea name="rows2[row' + rowlength + '][' + j + ']"></textarea>';
        } //rows[row1][1]
    }

    function functiontoggle(id) {
        // alert(id);
        if ($('#is_active' + id).prop('checked')) {
            var is_active = '1';
        } else {
            var is_active = '0';
        }
        var f_id = id;

        $.ajax({
            url: "{{ route('reportmaster.update_toggle') }}",
            type: 'POST',
            data: {
                is_active: is_active,
                f_id: f_id,
                _token: '{{csrf_token()}}'
            },
            error: function() {
                alert('Something is wrong');
            },
            success: function(data) {

                var data_convert = $.parseJSON(data);

                // console.log(data_convert.Data);
                if (data_convert.Data == 0) {
                    swal.fire({
                        title: "Success",
                        text: "Page Deactivated",
                        type: "success"
                    }, );
                } else {
                    swal.fire({
                        title: "Success",
                        text: "Page Activated",
                        type: "success"
                    }, );
                }

            }


        });
    }
</script>
<!-- Edit -->
@foreach($pages as $data)
<div class="modal fade" id="editmodulemodal{{$data['report_details_id']}}">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <form name="edit_form" action="{{ route('reports_master.update', \Crypt::encrypt($data['report_details_id'])) }}" method="POST" id="edit_page_form{{$data['report_details_id']}}">
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
                                    <textarea class="form-control" id="meeting_description{{$loop->iteration}}" name="meeting_description" required>
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

                            <a type="button" onclick="editbuttonclick('{{$data['report_details_id']}}')" class="btn btn-labeled btn-succes" title="Update" style="background: green !important; border-color:green !important; color:white !important">
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
@endforeach
@foreach($pages as $data)
<div class="modal fade" id="viewmodulemodal{{$data['report_details_id']}}">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <form name="edit_form" action="{{ route('reports_master.update', \Crypt::encrypt($data['report_details_id'])) }}" method="POST" id="edit_page_form{{$data['report_details_id']}}">
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
                                <div class="page">
                                    {!! $data['page_description'] !!}
                                </div>
                                <input type="hidden" value="{{$report[0]['reports_id']}}" name="reports_id" id="reports_id">
                            </div>
                        </div>
                    </div>
                </div>
            </form>

        </div>
    </div>
</div>
</div>
@endforeach
<script>
    function editbuttonclick(id) {
        document.getElementById('edit_page_form' + id).submit();
    }
</script>
<!-- End -->

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
        // event.preventDefault()
    });

    $(document).ready(function() {

        var pages = <?php echo json_encode($pages); ?>;
        for (p = 0; p < pages.length; p++) {
            var k = p + 1;
            tinymce.init({
                selector: 'textarea#meeting_description' + k,
                plugins: 'preview importcss searchreplace autolink autosave save directionality code visualblocks visualchars fullscreen image link media codesample table charmap pagebreak nonbreaking anchor insertdatetime advlist lists wordcount help charmap quickbars emoticons',
                imagetools_cors_hosts: ['picsum.photos'],
                menubar: 'file edit view insert format tools table help',
                toolbar: 'undo redo | bold italic underline strikethrough | fontfamily fontsize blocks | alignleft aligncenter alignright alignjustify | outdent indent |  numlist bullist | forecolor backcolor removeformat | pagebreak | charmap emoticons | fullscreen  preview save print | insertfile image media link anchor codesample | ltr rtl',
                toolbar_sticky: true,
                autosave_ask_before_unload: true,
                autosave_interval: "30s",
                autosave_prefix: "{path}{query}-{id}-",
                autosave_restore_when_empty: false,
                autosave_retention: "2m",
                content_css: "{{url('assets/css/css2.css')}}",
                // content_css: '.a4-editor',
                font_formats: "Andale Mono=andale mono,times; Arial=arial,helvetica,sans-serif; Arial Black=arial black,avant garde; Barlow=Barlow, sans-serif; Barlow Condensed=Barlow Condensed, sans-serif; Barlow Semi Condensed=Barlow Semi Condensed, sans-serif; Plain Barlow Black=Barlow Black, sans-serif; Plain Barlow Bold=Barlow Bold, sans-serif; Plain Barlow Light=Barlow Light, sans-serif; Plain Barlow Medium=Barlow Medium, sans-serif; Plain Barlow Thin=Barlow Thin, sans-serif; Book Antiqua=book antiqua,palatino; Comic Sans MS=comic sans ms,sans-serif; Courier New=courier new,courier; Georgia=georgia,palatino; Helvetica=helvetica; Impact=impact,chicago; Oswald=oswald; Symbol=symbol; Tahoma=tahoma,arial,helvetica,sans-serif; Terminal=terminal,monaco; Times New Roman=times new roman,times; Trebuchet MS=trebuchet ms,geneva; Verdana=verdana,geneva; Webdings=webdings; Wingdings=wingdings,zapf dingbats",
                content_style: "@import url('https://fonts.googleapis.com/css2?family=Barlow&display=swap');",
                content_style: "@import url('https://fonts.googleapis.com/css2?family=Barlow+Condensed:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap');",
                content_style: "@import url('https://fonts.googleapis.com/css2?family=Barlow+Semi+Condensed:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap');",

                // content_css: '.a4-editor',
                importcss_append: true,

                file_picker_callback: function(cb, value, meta) {
                    var input = document.createElement('input');
                    input.setAttribute('type', 'file');
                    input.setAttribute('accept', 'image/*');

                    input.onchange = function() {
                        var file = this.files[0];

                        var reader = new FileReader();
                        reader.onload = function() {
                            var id = 'blobid' + (new Date()).getTime();
                            var blobCache = tinymce.activeEditor.editorUpload.blobCache;
                            var base64 = reader.result.split(',')[1];
                            var blobInfo = blobCache.create(id, file, base64);
                            blobCache.add(blobInfo);

                            /* call the callback and populate the Title field with the file name */
                            cb(blobInfo.blobUri(), {
                                title: file.name
                            });
                        };
                        reader.readAsDataURL(file);
                    };

                    input.click();
                },

                height: 520,
                image_caption: true,
                quickbars_selection_toolbar: 'bold italic | quicklink h2 h3 blockquote quickimage quicktable',
                noneditable_noneditable_class: "mceNonEditable",
                toolbar_mode: 'sliding',
                contextmenu: "link image imagetools table",
            });
        }
    });

    $("#meeting_description").keyup(function() {
        var maxlen = $(this).attr('maxlength');
        var length = $(this).val().length;
        if (length > (maxlen - 10)) {

        }
    });
</script>

<script>
    function discription_content(a) {
        document.getElementById('btn_statu').value = a;
        tinyMCE.triggerSave();
        var tds = $("#meeting_description");
        if ($("#meeting_description").val().trim().length < 1) {
            swal.fire("Please Enter Page", "", "error");
            return false;
        }
        document.getElementById('new_page').submit();
    }

    function report_submit(a) {
        document.getElementById('btn_statu').value = a;
        // tinyMCE.triggerSave();
        // var tds = $("#meeting_description");
        // if ($("#meeting_description").val().trim().length < 1) {
        //     swal.fire("Please Enter Description", "", "error");
        //     return false;
        // }
        Swal.fire({

            title: "Are you want to Submit the Report ?",
            text: "Please click 'Yes' to Submit the Report.",
            icon: "warning",
            customClass: 'swalalerttext',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            confirmButtonText: "Yes",
            cancelButtonText: "No",
            closeOnConfirm: false,
            closeOnCancel: true,
            showLoaderOnConfirm: true,
            width: '550px',
        }).then((result) => {
            if (result.value) {
                document.getElementById('new_page').submit();
            }
        })
    }
</script>
<script>
    function submitForm() {
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
        var report_id = document.getElementById("report_id").value;

        $.ajax({
            url: '{{ url(' / master / assessment / header / update ') }}',
            type: "POST",
            data: {
                _token: '{{csrf_token()}}',
                report_type: report_type,
                report_name: report_name,
                version: version,
                report_id: report_id
            },

            success: function(data) {
                swal.fire({
                    title: "Success",
                    text: data,
                    type: "sucess",
                    confirmButtonColor: '#e73131',
                    confirmButtonText: 'OK',
                });
            },
            error: function(data) {
                swal.fire({
                    title: "Error",
                    text: data,
                    type: "error",
                    confirmButtonColor: '#e73131',
                    confirmButtonText: 'OK',
                });

            }
        });
    }
</script>

@endsection