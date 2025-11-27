@extends('layouts.adminnav')

@section('content')
<style>
    #hide {
        display: none;
    }

    .select2-selection__clear {
        display: none !important;
    }

    /* .recommendation_row:nth-child(odd) {
        background: #777;
    }

    .recommendation_row:nth-child(even) {
        background: blue;
    } */
</style>
<div class="main-content">
    {{ Breadcrumbs::render('referral_report.create') }}
    <div class="section-body mt-1">
        <h5 class="text-center align" style="color:darkblue">Referral Report</h5>
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row is-coordinate">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="control-label">Enrollment ID<span class="error-star" style="color:red;">*</span></label>
                                    <select class="form-control" id="enrollment_child_num" name="enrollment_child_num" onchange="GetChilddetails()">
                                        <option value="">Select-Enrollment</option>
                                        <option value="EN/2022/12/063">April (EN/2022/12/063)</option>
                                        <!-- @foreach($enrollment_details as $key=>$row)
                                        <option value="{{$row['enrollment_child_num']}}">{{ $row['enrollment_child_num']}} ( {{$row['child_name']}} )</option>
                                        @endforeach -->
                                    </select>
                                </div>
                            </div>
                            <input type="hidden" id="user_id" name="user_id">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="control-label">Child ID</label>
                                    <input class="form-control readonly" type="text" id="child_id" name="child_id" placeholder="Child ID" autocomplete="off" readonly>
                                    <input type="hidden" id="enrollment_id" name="enrollment_id" autocomplete="off" readonly>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="control-label">Child Name</label>
                                    <input class="form-control readonly" type="text" id="child_name" name="child_name" oninput="Childname(event)" maxlength="20" value="" placeholder="Enter Name" autocomplete="off" readonly>
                                </div>
                            </div>
                            <div class="col-md-4"></div>
                            @foreach($enrollment_details as $key=>$row1)
                            <div class="col-md-4" id="a{{$row1['user_id']}}" style="display: none;margin: 0 0 0 85px;">
                                <div class="form-group">
                                    <a class="btn btn-info btn-lg" title="View Record" target="_blank" href="{{ route('sail.status.edit', \Crypt::encrypt($row1['getID']))}}">Records</a>
                                </div>
                            </div>
                            @endforeach
                            <div class="col-md-4"></div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-12">
                <textarea class="meeting_description" id="meeting_description" name="meeting_description"></textarea>
                <div id="table">
                    <div class="table-responsive">
                        <table class="table table-bordered card-body" id="recommendation_table">
                            <thead>
                                <tr>
                                    <th width="30%">Recommendation</th>
                                    <th>Area of focus</th>
                                    <th>Referral</th>
                                    <th>Frequency</th>
                                </tr>
                            </thead>
                            <tbody id="tablebody">
                                <tr class="recommendation_row">
                                    <td rowspan="1" id="recommendation1">
                                        <!-- <textarea style="height: 50px !important;" class="form-control default" name=""></textarea> -->
                                        <div id="recommendation_option" style="display: flex;">
                                            <select class="form-control default recommendation_field" name="" id="options" onchange="recommendation_field()">
                                                <option value="">Select Recommendation</option>
                                                <option value="Creating a safe and warm environment, avoiding coercion and punishment, giving scope in expressing genuine concern and empathy, and being positive and optimistic">Creating a safe and warm environment, avoiding coercion and punishment, giving scope in expressing genuine concern and empathy, and being positive and optimistic</option>
                                                <option value="Periodic Review with the mental health professional to keep a check on his challenges and behaviours">Periodic Review with the mental health professional to keep a check on his challenges and behaviours</option>
                                                <option value="Cognitive Behavioral Therapy - to bring a focussed approach to facilitate positive attitude towards life situations">Cognitive Behavioral Therapy - to bring a focussed approach to facilitate positive attitude towards life situations</option>
                                                <option value="Counseling support to help him cope with his energy and encourage self-reflection, to improve pragmatics and to focus on developing his executive functioning skills.">Counseling support to help him cope with his energy and encourage self-reflection, to improve pragmatics and to focus on developing his executive functioning skills.</option>
                                                <option value="Academic skill building with a focus on remedial approach to improve his reading,writing and arithmetic skills. To incorporate a study skill approach to his learning routine.">Academic skill building with a focus on remedial approach to improve his reading,writing and arithmetic skills. To incorporate a study skill approach to his learning routine.</option>
                                                <option value="Art Therapy can help Yajur to express things that he is unable to put into words and for emotional regulation.">Art Therapy can help Yajur to express things that he is unable to put into words and for emotional regulation.</option>
                                            </select>
                                            <button class="fa fa-pencil editOption" style="visibility:hidden; background-color: transparent !important;border: none;" id="editbutton"></button>
                                            <!-- <button class="fa fa-pencil" style="visibility:hidden; background-color: transparent !important;border: none;" id="editbutton" onclick="editOption()"></button> -->
                                        </div>
                                        <div id="editForm" style="display: none;">
                                            <textarea class="form-control default" id="newOption" name="newOption"></textarea>
                                            <button class="fa fa-check" style="background-color: transparent !important;border: none;" onclick="updateOption()"></button>
                                        </div>
                                    </td>
                                    <td style="display: flex;align-items: center;">
                                        <select class="form-control default" name="focus_area" id="focus_area" onchange="focus_area()">
                                            <option value="">Select Area of focus</option>
                                            <option value="OT">Occupational Therapist</option>
                                            <option value="ST">Speech Therapist</option>
                                            <option value="SE">Special Education</option>
                                            <option value="PT">Physical Trainer</option>
                                            <option value="Phy">Physiotherapy</option>
                                            <option value="YT">Yoga Therapist</option>
                                        </select>
                                        <!-- <button>X</button> -->
                                    </td>
                                    <td>
                                        <select class="form-control default" name="referral_users" id="referral_users">
                                            <option value="">Select Referral</option>
                                        </select>
                                    </td>
                                    <td style="display: flex;align-items: center;">
                                        <input class="form-control default" type="text" id="frequency" name="frequency" autocomplete="off">
                                        <div class="row_div" order="1">
                                            <a class="btn" title="Add"><i class="fa fa-plus-circle"></i></a>
                                        </div>
                                        <a class="btn remove" title="Add"><i class="fa fa-times"></i></a>
                                    </td>
                                </tr>
                                <!-- <tr>
                                    <td colspan="4">
                                        <input id='add-row' class='btn btn-primary' onclick="addNewRow(event)" type='button' value='Add' />
                                    </td>
                                </tr> -->
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="text-center"> <input id='add-row' class='btn btn-large btn-success add' onclick="addNewRow(event)" type='button' value='Add New Recommendation' /> </div>
            </div>
        </div>


    </div>
</div>

<script type="text/javascript">
    var page6che = '1';

    function GetChilddetails() {
        var enrollment_child_num = $("select[name='enrollment_child_num']").val();

        if (enrollment_child_num != "") {
            $.ajax({
                url: "{{ url('/userregisterfee/enrollmentlist') }}",
                type: 'POST',
                data: {
                    'enrollment_child_num': enrollment_child_num,
                    _token: '{{csrf_token()}}'
                }
            }).done(function(data) {
                // var category_id = json.parse(data);
                console.log(data);

                if (data != '[]') {
                    $('#r1').show();
                    $('#r2').show();
                    // var user_select = data;
                    var optionsdata = "";

                    document.getElementById('child_id').value = data[0].child_id;
                    document.getElementById('child_name').value = data[0].child_name;
                    document.getElementById('enrollmentId').value = data[0].enrollment_id;
                    // document.getElementById('meeting_to').value = data[0].child_contact_email;
                    document.getElementById('enrollment_id').value = data[0].enrollment_id;
                    document.getElementById('user_id').value = data[0].user_id;

                    // console.log(data)
                    var user_id = data[0].user_id;
                    $('#a' + user_id).show();
                    // 
                    $.ajax({
                        url: "{{ url('/sensory/enrollmentlist') }}",
                        type: 'POST',
                        data: {
                            'enrollment_child_num': enrollment_child_num,
                            _token: '{{csrf_token()}}'
                        }
                    }).done(function(data) {
                        // var category_id = json.parse(data);
                        // console.log(data);

                        if (data != '[]') {
                            var qu1 = "";
                            var qu2 = "";
                            var qu3 = "";
                            var qu4 = "";
                            var quc1 = 0;
                            var quc2 = 0;
                            var quc3 = 0;
                            var quc4 = 0;
                            for (var i = 0; i < data.length; i++) {
                                var quadrant_type = data[i]['quadrant']; //console.log(quadrant_type);
                                var question = data[i]['question'];
                                if (quadrant_type == 'SEEKING') {
                                    quc1++;
                                    if (quc1 < 10)
                                        qu1 += '<li style="float: left;">' + question + '</li><br>';
                                }
                                if (quadrant_type == 'AVOIDING') {
                                    quc2++;
                                    if (quc2 < 10)
                                        qu2 += '<li style="float: left;">' + question + '</li><br>';
                                }
                                if (quadrant_type == 'SENSITIVITY') {
                                    quc3++;
                                    if (quc3 < 10)
                                        qu3 += '<li style="float: left;">' + question + '</li><br>';
                                }
                                if (quadrant_type == 'REGISTRATION') {
                                    quc4++;
                                    if (quc4 < 10)
                                        qu4 += '<li style="float: left;">' + question + '</li><br>';
                                }
                            }
                            var demonew1 = $('#qu1').append(qu1);
                            var demonew2 = $('#qu2').append(qu2);
                            var demonew3 = $('#qu3').append(qu3);
                            var demonew4 = $('#qu4').append(qu4);
                            var page6che = '2';

                        }


                    })
                    // 
                } else {
                    document.getElementById('child_name');
                    var ddd = '<option value="child_name">Select Enrollment_child_num</option>';
                    var demonew = $('#child_name').html(ddd);
                }


            })
        } else {
            document.getElementById('initiated_by');
            var ddd = '<option value="initiated_by">Select Enrollment_child_num</option>';
            var demonew = $('#initiated_by').html(ddd);
        }
    };
</script>
<script>
    var rec = '<div id="recommendation_option" style="display: flex;"><select class="form-control default recommendation_field" name="" id="options" onchange="recommendation_field()">';
    rec += '<option value="">Select Recommendation</option><option value="Creating a safe and warm environment, avoiding coercion and punishment, giving scope in expressing genuine concern and empathy, and being positive and optimistic">Creating a safe and warm environment, avoiding coercion and punishment, giving scope in expressing genuine concern and empathy, and being positive and optimistic</option><option value="Periodic Review with the mental health professional to keep a check on his challenges and behaviours">Periodic Review with the mental health professional to keep a check on his challenges and behaviours</option><option value="Cognitive Behavioral Therapy - to bring a focussed approach to facilitate positive attitude towards life situations">Cognitive Behavioral Therapy - to bring a focussed approach to facilitate positive attitude towards life situations</option><option value="Counseling support to help him cope with his energy and encourage self-reflection, to improve pragmatics and to focus on developing his executive functioning skills.">Counseling support to help him cope with his energy and encourage self-reflection, to improve pragmatics and to focus on developing his executive functioning skills.</option><option value="Academic skill building with a focus on remedial approach to improve his reading,writing and arithmetic skills. To incorporate a study skill approach to his learning routine.">Academic skill building with a focus on remedial approach to improve his reading,writing and arithmetic skills. To incorporate a study skill approach to his learning routine.</option><option value="Art Therapy can help Yajur to express things that he is unable to put into words and for emotional regulation.">Art Therapy can help Yajur to express things that he is unable to put into words and for emotional regulation.</option>';
    rec += '</select><button class="fa fa-pencil" style="visibility:hidden; background-color: transparent !important;border: none;" id="editbutton" onclick="editOption()"></button></div>';
    rec += '<div id="editForm" style="display: none;"><textarea class="form-control default" id="newOption" name="newOption"></textarea><button class="fa fa-check" style="background-color: transparent !important;border: none;" onclick="updateOption()"></button></div>';

    var aof = '<select class="form-control default" name="focus_area" id="focus_area" onchange="focus_area()"><option value="">Select Area of focus</option><option value="">Occupational Therapist</option><option value="">Speech Therapist</option><option value="">Special Education</option><option value="">Physical Trainer</option><option value="">Physiotherapy</option><option value="">Yoga Therapist</option></select>';
    var referral = '<select class="form-control default" name=""><option value="">Select Referral</option></select>';
    var frequency = '<input class="form-control default" type="text" id="frequency" name="frequency" autocomplete="off">';
    var referraloptions = '<option value="">Ms. Sukanya - 9876522210</option><option value="">Ms. Sumithra Shailesh - 9876543217</option><option value="">Ms. Ramalakshmi - 9876543233</option><option value="">Ms. Vijayalakshmi - 9876543216 </option><option value="">Mr. Stephen - 9876543211</option><option value="">Ms. Malini - 9876543210 </option>';

    function focus_area() {
        var focus_area = $('#focus_area').val();
        console.log(focus_area);
        if (focus_area != '' || focus_area != null) {
            $('#referral_users').append(referraloptions);
        }
    }
    // function addRow(e) {
    //     console.log(e);
    //     var table = document.getElementById("recommendation_table");

    //     var tableCount = $('#tablebody').find('tr').length;
    //     var rowSpanCount = $('#recommendation' + e).attr('rowspan');
    //     $('#recommendation' + e).attr('rowspan', Number(rowSpanCount) + 1);
    //     if(Number(e) + 1 == 2){
    //         var row = table.insertRow(Number(e) + 1);
    //     }else{
    //         var row = table.insertRow(Number(e) - 1);
    //     }
    //     // var row = table.insertRow(-1);

    //     $(row.insertCell(0)).append(aof);
    //     $(row.insertCell(1)).append(referral);

    //     var tempfrequency = frequency;
    //     tempfrequency += '<div onclick="addRow('+e+')"><a class="btn addProduct" title="Add" order=""><i class="fa fa-plus-circle" order=""></i></a></div><a class="btn remove" order="" title="Add"><i class="fa fa-times" order=""></i></a>';
    //     cell3 = row.insertCell(2);
    //     cell3.style.cssText = "display: flex;align-items: center;";
    //     $(cell3).append(tempfrequency);
    // }

    $(document).on('click', ".row_div", function() {
        var thisRow = $(this).parent().parent();
        thisRow.clone(true).insertAfter(thisRow).data('is_clone', true);
        $(this).attr("id", "hide");

        var nextRow = thisRow.next();
        nextRow.find('input:not(.row_div)').val("");

        if (thisRow.data('is_clone')) {
            while (thisRow.data('is_clone')) {
                thisRow = thisRow.prev();
            }
        } else {
            nextRow.children(":first").remove();
        }

        // currRowSpan = thisRow.children(":first").attr("rowspan");
        // thisRow.children(":first").attr("rowspan", currRowSpan + 1);
        var order = $(this).attr("order");
        var rowSpanCount = $('#recommendation' + order).attr('rowspan');
        $('#recommendation' + order).attr('rowspan', Number(rowSpanCount) + 1);

    });

    $(document).on('click', ".remove", function() {
        var thisRow = $(this).parent().parent(),
            prevRow = thisRow.prev();

        if (thisRow.data('is_clone')) {
            while (prevRow.data('is_clone')) {
                prevRow = prevRow.prev();
            }
        } else {
            prevRow = thisRow.next()
                .removeData('is_clone')
                .children(":first")
                .before(thisRow.children(":first"))
                .end();
        }

        currRowSpan = prevRow.children(":first").attr("rowspan");
        prevRow.children(":first").attr("rowspan", currRowSpan - 1);
        thisRow.remove();
    });

    function addNewRow() {
        var table = document.getElementById("recommendation_table");
        var trl = document.querySelectorAll('.recommendation_row').length + 1;

        var rws = table.rows;
        var rowlength = rws.length;
        var cols = table.rows[0].cells.length;
        var row = table.insertRow(rws.length);
        row.className = 'recommendation_row';
        var cell;
        var tempfrequency = frequency;
        tempfrequency += '<div class="row_div" order="' + trl + '"><a class="btn" title="Add"><i class="fa fa-plus-circle"></i></a></div>';
        tempfrequency += '<a class="btn remove" title="Add"><i class="fa fa-times"></i></a>';
        for (var i = 0; i < cols; i++) {
            cell = row.insertCell(i);
            j = i + 1;
            if (j == 1) {
                cell.id = 'recommendation' + trl;
                cell.rowSpan = 1;
                cell.innerHTML = rec;
            }
            if (j == 2) {
                cell.innerHTML = aof;
            }
            if (j == 3) {
                cell.innerHTML = referral;
            }
            if (j == 4) {
                cell.style.cssText = "display: flex;align-items: center;";
                cell.innerHTML = tempfrequency;
            }
        }
    }
</script>
<script>
    $(document).ready(function() {

        tinymce.init({
            selector: 'textarea#meeting_description',
            height: 200,
            max_chars: 10,
            menubar: false,
            branding: false,
            statusbar: false,
            plugins: 'searchreplace',
            toolbar: 'undo redo | formatselect | ' +
                'bold italic backcolor | alignleft aligncenter ' +
                'alignright alignjustify | bullist numlist outdent indent | ' +
                'removeformat | searchreplace',
            content_style: 'body { font-family:Helvetica,Arial,sans-serif; font-size:14px }',
        });

    });
</script>

<script>
    function recommendation_field() {
        var selectBox = document.getElementById("options");
        if (selectBox != '') {
            document.getElementById("editbutton").style.visibility = "visible";
        } else {
            document.getElementById("editbutton").style.visibility = "hidden";
        }
    }

    $(document).on('click', "#editOption", function() {
        console.log('editOption');
        $(this).parent().find('recommendation_option').hide();
    });

    $(document).ready(function() {
        $("#editButton").on("click", function() {
            console.log('editOption');
            // Code to execute when the button is clicked
        });
    });

    function editOption() {
        document.getElementById("recommendation_option").style.display = "none";
        document.getElementById("editForm").style.display = "flex";
        var selectBox = document.getElementById("options");
        var selectedOption = selectBox.options[selectBox.selectedIndex].value;
        console.log(selectedOption);
        document.getElementById("newOption").value = selectedOption;
    }

    function updateOption() {
        var selectBox = document.getElementById("options");
        var selectedOption = selectBox.options[selectBox.selectedIndex].value;
        var newOption = document.getElementById("newOption").value;
        var optionIndex = Array.from(selectBox.options).findIndex(option => option.value === selectedOption);
        selectBox.options[optionIndex].value = newOption;
        selectBox.options[optionIndex].text = newOption;
        document.getElementById("editForm").style.display = "none";
        document.getElementById("recommendation_option").style.display = "flex";
    }
</script>

@endsection