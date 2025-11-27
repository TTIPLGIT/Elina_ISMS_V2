@extends('layouts.adminnav')
@section('content')
<style>
    .form-control {
        background-color: #ffffff !important;
    }

    .form-control:disabled,
    .form-control[readonly] {
        background-color: #e9ecef !important;
    }

    textarea.form-control {
        resize: none;
        height: 200px !important;
    }
</style>
<style>
    table {
        border-collapse: collapse;
    }

    td,
    th {
        border: 1px solid black;
        padding: 10px;
        font-weight: bolder;
        color: black;
    }

    div.dataTables_wrapper div.dataTables_paginate ul.pagination {
        justify-content: center !important;
    }

    .tooltiptext1 {
        font-weight: 100;
    }

    .error {
        border: 2px solid red;
        border-color: red !important;
    }
</style>
<style>
    .nav {
        display: -webkit-inline-box;
        display: inline-flex;
        position: relative;
        overflow: hidden;
        max-width: 100%;
        background-color: #fff;
        padding: 0 20px;
        border-radius: 40px;
        box-shadow: 0 10px 40px rgba(159, 162, 177, 0.8);
        align-items: center;
        text-align: center;
        justify-content: center;
    }

    .nav-item {
        color: #83818c;
        padding: 20px;
        text-decoration: none;
        -webkit-transition: .3s;
        transition: .3s;
        margin: 0 6px;
        z-index: 1;
        font-family: 'DM Sans', sans-serif;
        font-weight: 500;
        position: relative;
    }

    .nav-item:before {
        content: "";
        position: absolute;
        bottom: -6px;
        left: 0;
        width: 100%;
        height: 5px;
        background-color: #dfe2ea;
        border-radius: 8px 8px 0 0;
        opacity: 0;
        -webkit-transition: .3s;
        transition: .3s;
    }

    .nav-item:not(.is-active):hover:before {
        opacity: 1;
        bottom: 0;
    }

    .nav-item:not(.is-active):hover {
        color: #333;
    }

    .nav-indicator {
        position: absolute;
        left: 0;
        bottom: 0;
        height: 4px;
        -webkit-transition: .4s;
        transition: .4s;
        height: 5px;
        z-index: 1;
        border-radius: 8px 8px 0 0;
    }

    li.disabled {
        display: none !important;
    }

    @media (max-width: 580px) {
        .nav {
            overflow: auto;
        }
    }
</style>
<div class="main-content">
    @if (session('success'))
    <input type="hidden" name="session_data" id="session_data" class="session_data" value="{{ session('success') }}">
    <input type="hidden" name="session_data" id="session_data" class="session_data" value="{{ session('success') }}">
    <script type="text/javascript">
        window.onload = function() {
            var message = $('#session_data').val();
            Swal.fire('Success!', message, 'success');
        }
    </script>
    @elseif(session('fail'))

    <input type="hidden" name="session_data" id="session_data1" class="session_data" value="{{ session('fail') }}">
    <script type="text/javascript">
        window.onload = function() {
            var message = $('#session_data1').val();
            Swal.fire('Info!', message, 'info');
        }
    </script>
    @endif

    {{ Breadcrumbs::render('ovmcompleted') }}

    <div class="section-body mt-1">
        <h5 class="text-center" style="color:darkblue">Conversation Summary</h5>

        <form action="{{route('ovmiscfeedbackstore',$rows[0]['ovm_isc_report_id'])}}" method="POST" id="ovmisc" name="ovmisc" enctype="multipart/form-data">
            {{ csrf_field() }}
            @method('PUT')
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="row is-coordinate">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="control-label">Enrollment ID</label>
                                        <input class="form-control" name="enrollment_id" placeholder="Enrollment ID" value="{{ $rows[0]['enrollment_id']}}" readonly>
                                        <input type="hidden" class="form-control" name="editusername" placeholder="editusername" value="{{$editusername}}" readonly>

                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="control-label">OVM Meeting ID</label>
                                        <input class="form-control" type="text" id="ovm_meeting_unique" name="ovm_meeting_unique" value="{{ $rows[0]['ovm_meeting_unique']}}" placeholder="OVM1 Meeting" autocomplete="off" readonly>

                                    </div>
                                </div>
                                <input type="hidden" id="ovm_meeting_id" name="ovm_meeting_id" value="{{ $rows[0]['ovm_meeting_id']}}" readonly>

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="control-label">Child ID</label>
                                        <input class="form-control" type="text" id="child_id" name="child_id" value="{{ $rows[0]['child_id']}}" placeholder="OVM1 Meeting" autocomplete="off" readonly>

                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="control-label">Child Name</label>
                                        <input class="form-control" type="text" id="child_name" name="child_name" value="{{ $rows[0]['child_name']}}" placeholder="Enter Name" autocomplete="off" readonly>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="scrollSession"></div>
                <div class="col-12" style="margin: 5px 0 5px 0;cursor:pointer">
                    <nav class="nav" style="width:100%">
                        @foreach($group as $key => $value)
                        <a class="nav-item{{ $loop->first ? ' is-active' : '' }}" active-color="orange" data-id="{{$value['id']}}">{{$value['name']}}</a>
                        @endforeach
                        <span class="nav-indicator"></span>
                    </nav>
                </div>
                @foreach($group as $key => $value)
                <div class="row navcard navcard{{$value['id']}}" style="display:none">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <!-- {{$value['name']}} -->

                                <input type="text" class="col-4 form-control default" oninput="search(event , '{{$value['id']}}')" id="searchInput" style="float: right;font-family:Arial, FontAwesome" placeholder="&#xF002; Search">
                                <div class="table-wrapper">
                                    <div class="table-responsive">
                                        <table class="table myTable">
                                            @if($value['add_questions'] == 1)
                                            <thead>
                                                <tr>
                                                    <th width="30%">Areas</th>
                                                    <th width="35%"></th>
                                                    <th width="35%">Conversation summary</th>
                                                </tr>
                                            </thead>
                                            <tbody id="table_{{$value['id']}}">
                                                @foreach($questions as $question)
                                                @if($question['group_id'] == $value['id'])
                                                <tr>
                                                    <td width="30%" style="text-align:left !important;">{!! $question['question'] !!}<span class="tooltiptext1">{!! $question['question_description'] !!}</span></td>
                                                    <td width="35%"><textarea class="form-control default instructions_textarea" id="note_{{$question['question_column_name']}}" name="note[{{$question['question_column_name']}}]">{{ $question['additional_question_data']}}</textarea></td>
                                                    <td width="35%"><textarea class="form-control default instructions_textarea {{ $question['assigned_value']}}" id="{{$question['question_column_name']}}" name="que[{{$question['question_column_name']}}]">{{ $question['prefilled_data']}}</textarea></td>
                                                </tr>
                                                @endif
                                                @endforeach
                                            </tbody>
                                            @else
                                            <thead>
                                                <tr>
                                                    <th width="35%">Areas</th>
                                                    <th>Conversation summary</th>
                                                </tr>
                                            </thead>
                                            @if($value['id'] == 1)
                                            <tbody id="table_{{$value['id']}}">
                                                @foreach($questions as $question)
                                                @if($question['group_id'] == $value['id'])
                                                <tr>
                                                    <td width="35%" style="text-align:left !important;height: 200px;">{!! $question['question'] !!}<span class="tooltiptext1">{!! $question['question_description'] !!}</span></td>
                                                    <td style="text-align:left !important;">{!! $question['prefilled_data'] !!}<input type="hidden" value="{{ $question['prefilled_data'] }}" name="que[{{$question['question_column_name']}}]"></td>
                                                </tr>
                                                @endif
                                                @endforeach
                                            </tbody>
                                            @else
                                            <tbody id="table_{{$value['id']}}">
                                                @foreach($questions as $question)
                                                @if($question['group_id'] == $value['id'])
                                                <tr>
                                                    <td width="35%" style="text-align:left !important;height: 200px;">{!! $question['question'] !!}<span class="tooltiptext1">{!! $question['question_description'] !!}</span></td>
                                                    <td><textarea class="form-control default instructions_textarea {{ $question['assigned_value']}}" id="{{$question['question_column_name']}}" name="que[{{$question['question_column_name']}}]">{{ $question['prefilled_data']}}</textarea></td>
                                                </tr>
                                                @endif
                                                @endforeach
                                            </tbody>
                                            @endif
                                            @endif
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            <div class="row text-center">
                <div class="col-md-12">
                    <a class="btn btn-info" type="button" id="prevButton">Previous</a>
                    @if($role!='ishead')
                    @if( $rows[0]['status'] !="Submitted" && $rows[0]['status'] !="Completed")
                    <button type="submit" id="saved" class="btn btn-warning" name="type" value="Saved">Save</button>
                    <button type="submit" id="submit" class="btn btn-success" name="type" value="Submitted">Submit</button>
                    @endif
                    @elseif($role=='ishead')
                    <button type="submit" id="saved" class="btn btn-warning" name="type" value="Saved_Ishead">Save</button>
                    <button type="submit" id="submit" class="btn btn-success" name="type" value="Completed">Submit</button>
                    @endif
                    <a type="button" href="{{ route('ovmmeetingcompleted') }}" class="btn btn-danger">Cancel</a>
                    <a class="btn btn-info" type="button" id="nextButton">Next</a>
                </div>
            </div>
        </form>

        <input type="hidden" value="{{$rows[0]['status']}}" id="rowstatus">
        <input type="hidden" value="{{$rolename}}" id="rowrolename">
    </div>
</div>
<script>
    const indicator = document.querySelector('.nav-indicator');
    const items = document.querySelectorAll('.nav-item');

    function handleIndicator(el) {
        items.forEach(item => {
            item.classList.remove('is-active');
            item.removeAttribute('style');
        });

        indicator.style.width = `${el.offsetWidth}px`;
        indicator.style.left = `${el.offsetLeft}px`;
        indicator.style.backgroundColor = el.getAttribute('active-color');

        el.classList.add('is-active');
        el.style.color = el.getAttribute('active-color');

        var dataid = el.getAttribute('data-id');
        // console.log(dataid);
        if (dataid == 7) {
            $('#nextButton').hide();
        } else {
            $('#nextButton').show();
        }

        if (dataid == 1) {
            $('#prevButton').hide();
        } else {
            $('#prevButton').show();
        }

        $('#currentPage').val(dataid);

        // window.scroll({
        //     top: 0,
        //     left: 0,
        //     behavior: 'smooth'
        // });
        document.getElementById('scrollSession').scrollIntoView({
            behavior: 'smooth'
        });

        $('.navcard').hide();
        $('.navcard' + dataid).show();
    }


    items.forEach((item, index) => {
        item.addEventListener('click', e => {
            handleIndicator(e.target);
        });
        item.classList.contains('is-active') && handleIndicator(item);
    });

    // Next and Prev

    const prevButton = document.getElementById('prevButton');
    const nextButton = document.getElementById('nextButton');

    function handleNext() {
        const activeItem = document.querySelector('.nav-item.is-active');
        const nextItem = activeItem.nextElementSibling;
        if (nextItem && nextItem.classList.contains('nav-item')) {
            handleIndicator(nextItem);
        }
    }

    function handlePrevious() {
        const activeItem = document.querySelector('.nav-item.is-active');
        const prevItem = activeItem.previousElementSibling;
        if (prevItem && prevItem.classList.contains('nav-item')) {
            handleIndicator(prevItem);
        }
    }

    prevButton.addEventListener('click', handlePrevious);
    nextButton.addEventListener('click', handleNext);

    // ...
</script>
<script>
    // $(document).ready(function() {
    //     var table = $('.myTable').DataTable({
    //         "pageLength": 5,
    //         "dom": '<"top"rt<"bottom"ip>',
    //         "language": {
    //             "info": ""
    //         },
    //         "ordering": false,
    //     });
    // });
    $(document).on('click', '.paginate_button:not(.disabled)', function() {
        window.scroll({
            top: 0,
            left: 0,
            behavior: 'smooth'
        });
    });
</script>
<script type="text/javascript">
    function tabledestroy() {
        var table = $('#myTable').DataTable();
        table.destroy();
        $('#myTable').DataTable({
            "pageLength": -1,
            "ordering": false,
        });
    }

    function tablerestore() {
        var table = $('#myTable').DataTable();
        table.destroy();
        $('#myTable').DataTable({
            "pagingType": "simple",
            "pageLength": 5,
            "dom": '<"top"f>rt<"bottom"ip>',
            "language": {
                "info": ""
            },
            "ordering": false,
        });
    }
    $('#saved').click(function() {
        $("#saved").addClass("disable-click");
        $('.loader').show();
        tabledestroy();
        document.getElementById('ovmisc').submit();
    });

    $("#submit").click(function() {
        tabledestroy();
        const getAllFormElements = element => Array.from(element.elements).filter(tag => ["textarea"].includes(tag.tagName.toLowerCase()));
        const pageFormElements = getAllFormElements(document.getElementById("ovmisc"));
        $('.loader').show();
        // for (i = 0; i < pageFormElements.length; i++) {
        //     if (pageFormElements[i].value == "") {
        //         $('.loader').hide();
        //         let text = "Please Enter Field ";
        //         text += pageFormElements[i].title;
        //         swal.fire("Warning", text, "warning").then(function(result) {
        //             if (result.isConfirmed) {
        //                 pageFormElements[i].classList.add('error');
        //                 var errorElement = $(".error");
        //                 var tdElement = errorElement.parentsUntil("tbody", "tr").last();

        //                 tablerestore();
        //                 var table = $('#myTable').DataTable();
        //                 var pageNo = pageFormElements[i].getAttribute('order');
        //                 pageNo = Number(pageNo);
        //                 table.page(pageNo).draw('page');

        //                 $('html, body').animate({
        //                     scrollTop: tdElement.offset().top
        //                 }, 'slow');
        //                 pageFormElements[i].focus();
        //             }
        //         });


        //         return false;
        //     } 

        // }
    });
</script>
<script>
    $(document).ready(function() {

        var fetchdatas = <?php echo json_encode($fetchdata); ?>;
        fetchdatas = fetchdatas[0];
        console.log(fetchdatas);
        $.each(fetchdatas, function(key, value) {
            // if(value != null) {
            $('#' + key).val(value);
            // }
        });

        var fetchdatas1 = <?php echo json_encode($fetchdata1); ?>;
        fetchdatas1 = fetchdatas1[0];
        $.each(fetchdatas1, function(key, value) {
            // if(value != null) {
            $('#note_' + key).val(value);
            // }
        });

        var rolename = document.getElementById('rowrolename').value;
        var status = document.getElementById('rowstatus').value;

        if (status == "Submitted" || status == "Completed") {
            if (rolename !== 'IS Head') {
                var readonly = 1;
            } else {
                var readonly = 0;
            }
        } else {
            var readonly = 0;
        }

        tinymce.init({
            selector: '.instructions_textarea',
            height: '100%',
            menubar: false,
            branding: false,
            // readonly: readonly,
            // inline: true,
            plugins: 'preview importcss searchreplace autolink autosave save directionality code visualblocks visualchars fullscreen image link media codesample table charmap pagebreak nonbreaking anchor insertdatetime advlist lists wordcount help charmap emoticons',
            toolbar: 'undo redo | bold italic underline strikethrough | fontfamily fontsize blocks | alignleft aligncenter alignright alignjustify | outdent indent |  numlist bullist | forecolor backcolor link ',
        });



        var pageNo = $('#session_page').val();
        // console.log(pageNo);
        if (pageNo != '' && pageNo != null && pageNo != undefined) {
            const itemToSetActive = document.querySelector('.nav-item[data-id="' + pageNo + '"]');
            itemToSetActive.click();
        }
    });
</script>
<script>
    function search(event, id) {
        var value = event.target.value;
        // console.log(value, id);
        value = value.toLowerCase();
        $("#table_" + id + " tr").filter(function() {
            $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
        });
    }
</script>
@endsection