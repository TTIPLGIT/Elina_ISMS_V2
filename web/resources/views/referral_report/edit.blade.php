@extends('layouts.adminnav')

@section('content')
<style>
    #hide {
        display: none;
    }

    /* tr:nth-child(odd) {
        background: #DDE;
    }

    tr:nth-child(odd) td[rowspan] {
        background: #FFF;
    } */

    .oddrow td {
        background: red;
    }

    .hide_div {
        display: none;
    }
</style>
<div class="main-content">
    {{ Breadcrumbs::render('referralreport.edit',$report[0]['report_id']) }}
    @if (session('success'))

    <input type="hidden" name="session_data" id="session_data" class="session_data" value="{{ session('success') }}">
    <script type="text/javascript">
        window.onload = function() {
            var message = $('#session_data').val();
            swal.fire("Success", message, "success");

        }
    </script>
    @elseif(session('fail'))

    <input type="hidden" name="session_data" id="session_data1" class="session_data" value="{{ session('error') }}">
    <script type="text/javascript">
        window.onload = function() {
            var message = $('#session_data1').val();
            swal.fire("Info", message, "info");

        }
    </script>
    @endif
    <div class="section-body mt-1">
        <h5 class="text-center align" style="color:darkblue">Compilation of Referral Report</h5>
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row is-coordinate">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="control-label">Enrollment ID<span class="error-star" style="color:red;">*</span></label>
                                    <input class="form-control readonly" type="text" id="child_id" name="child_id" placeholder="Child ID" value="{{$report[0]['enrollment_child_num']}}" autocomplete="off" readonly>
                                    <input type="hidden" id="enrollment_id" name="enrollment_id" autocomplete="off" readonly>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="control-label">Child ID</label>
                                    <input class="form-control readonly" type="text" id="child_id" name="child_id" placeholder="Child ID" value="{{$report[0]['child_id']}}" autocomplete="off" readonly>
                                    <input type="hidden" id="enrollment_id" name="enrollment_id" autocomplete="off" readonly>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="control-label">Child Name</label>
                                    <input class="form-control readonly" type="text" id="child_name" name="child_name" value="{{$report[0]['child_name']}}" oninput="Childname(event)" maxlength="20" value="" placeholder="Enter Name" autocomplete="off" readonly>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="control-label">Date of Reporting</label>
                                    @if($report[0]['dor'] == '')
                                    <input class="form-control default" type="date" onchange="document.getElementById('dor').value = this.value" value="<?php echo date('Y-m-d'); ?>">
                                    @else
                                    <input class="form-control default" type="date" onchange="document.getElementById('dor').value = this.value" value="{{$report[0]['dor']}}">
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            <div class="col-12">
                <form name="edit_form" action="{{ route('referralreport.update' , \Crypt::encrypt($report[0]['report_id']))}}" method="POST" id="form_report">
                    {{ csrf_field() }}
                    @method('PUT')
                    <input type="hidden" id="state" name="state">
                    @if($report[0]['dor'] == '')
                    <input type="hidden" id="dor" name="dor" value="<?php echo date('Y-m-d'); ?>">
                    @else
                    <input type="hidden" id="dor" name="dor" value="{{$report[0]['dor']}}">
                    @endif
                    <input type="hidden" id="enrollmentId" name="enrollmentId" value="{{$report[0]['enrollment_id']}}">
                    <textarea class="meeting_description" id="meeting_description" name="meeting_description">{{$report[0]['meeting_description']}}</textarea>
                    <div id="table">
                        <div class="table-responsive">
                            <table class="table table-bordered card-body" id="recommendation_table">
                                <thead>
                                    <tr>
                                        <th width="40%">Recommendation</th>
                                        <th>Area of focus</th>
                                        <th>Referral</th>
                                        <th>Frequency</th>
                                    </tr>
                                </thead>
                                <tbody id="tablebody">
                                    @php
                                    $ro = array();
                                    $ro1 = array();
                                    $ddc = 1;
                                    @endphp

                                    @foreach($recommendations as $data)
                                    @foreach($report as $row)
                                    @if($row['recommendation_area'] == $data['recomendation_id'])

                                    @php
                                    array_push($ro, $data['recomendation_id']);
                                    @endphp

                                    @endif
                                    @endforeach
                                    @endforeach


                                    @foreach($recommendations as $data)
                                    @foreach($report as $row)
                                    @if($row['recommendation_area'] == $data['recomendation_id'])

                                    @php
                                    $ro_counts = array_count_values($ro);
                                    $rowS = $ro_counts[$data['recomendation_id']];

                                    $rowS_1 = $data['recomendation_id'];

                                    @endphp

                                    @if (in_array($data['recomendation_id'], $ro1))
                                    <tr class="recommendation_row" data-is_clone="true">
                                        @else
                                    <tr class="recommendation_row">
                                        @endif


                                        @if (!in_array($data['recomendation_id'], $ro1))
                                        <td rowspan="{{$rowS}}" id="recommendation{{$data['recomendation_id']}}">
                                            <textarea style="height: 50px !important;width: 100%;" name="recommendation_area[{{$data['recomendation_id']}}]" oninput="checkCharCount(this)">{{$data['recommendation']}}</textarea>
                                        </td>
                                        @php
                                        array_push($ro1, $data['recomendation_id']);
                                        @endphp
                                        @else
                                        @php
                                        $ddc++;
                                        $rowS_1 = $data['recomendation_id'] .'_'.$ddc ;
                                        @endphp
                                        @endif
                                        <td style="align-items: center;">
                                            <select class="form-control default" name="focus_area[{{$data['recomendation_id']}}][]" id="focus_area{{$rowS_1}}" onchange="focus_area('{{$rowS_1}}')">
                                                <option value="">Select Area of focus</option>
                                                @foreach($specialization as $specialist)
                                                @if($row['focus_area'] == $specialist['id'])
                                                <option value="{{$specialist['id']}}" selected>{{$specialist['specialization']}}</option>
                                                @else
                                                <option value="{{$specialist['id']}}">{{$specialist['specialization']}}</option>
                                                @endif
                                                @endforeach
                                                <option value="0" {{ $row['focus_area'] == "0" ? 'selected' : '' }}>Others</option>
                                            </select>
                                            @if($row['focus_area'] == '0')
                                            <input class="form-control default" type="text" name="focus_area_other[{{$data['recomendation_id']}}][]" id="otherInputfocus_area{{$loop->iteration}}" value="{{$row['focus_area_other']}}">
                                            @else
                                            <input class="form-control default" type="text" name="focus_area_other[{{$data['recomendation_id']}}][]" id="otherInputfocus_area{{$loop->iteration}}" style="display: none;">
                                            @endif
                                        </td>
                                        <td>
                                            <select class="form-control default" name="referral_users[{{$data['recomendation_id']}}][]" id="referral_users{{$rowS_1}}" onchange="checkOption(this)">
                                                <option value="">Select Referral</option>
                                                @foreach($serviceProviders as $provider)
                                                @if($provider['id'] == $row['referral_users'])
                                                <option value="{{$provider['id']}}" selected>{{$provider['name']}} - {{$provider['phone_number']}}</option>
                                                @else
                                                <option value="{{$provider['id']}}">{{$provider['name']}} - {{$provider['phone_number']}}</option>
                                                @endif
                                                @endforeach
                                                <option value="0" {{ $row['referral_users'] == "0" ? 'selected' : '' }}>Others</option>
                                            </select>
                                            @if($row['referral_users'] == '0')
                                            <input class="form-control default" type="text" value="{{$row['referral_users_other']}}" name="referral_users_other[{{$data['recomendation_id']}}][]" id="otherInputreferral_users{{$rowS_1}}">
                                            @else
                                            <input class="form-control default" type="text" name="referral_users_other[{{$data['recomendation_id']}}][]" id="otherInputreferral_users{{$rowS_1}}" style="display: none;">
                                            @endif
                                        </td>
                                        <td style="display: flex;align-items: center;">
                                            <input class="form-control default" type="text" id="frequency" name="frequency[{{$data['recomendation_id']}}][]" value="{{$row['frequency']}}" autocomplete="off">
                                            <div class="row_div addHide{{$data['recomendation_id']}}" order="{{$data['recomendation_id']}}">
                                                <a class="btn" title="Add"><i class="fa fa-plus-circle"></i></a>
                                            </div>
                                            <a class="btn remove" title="Add"><i class="fa fa-times"></i></a>
                                        </td>
                                    </tr>
                                    @endif
                                    @endforeach
                                    @endforeach
                                    <!-- <tr>
                                    <td colspan="4">
                                        <input id='add-row' class='btn btn-primary' onclick="addNewRow(event)" type='button' value='Add' />
                                    </td>
                                </tr> -->
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="text-center" style="margin-bottom: 5px;"> <input id='add-row' class='btn btn-success' onclick="addNewRow(event)" type='button' value='Add New Recommendation' /> </div>
                    <!-- Sign -->
                    <div class="col-12 scrollable fixTableHead title-padding">
                        <div class="table-responsive">
                            <table class="table table-bordered card-body">
                                <tbody>
                                    <tr>
                                        <td style="background: white;border: 1px solid #0e0e0e !important;vertical-align: initial !important;">
                                            <textarea class="tinymce-textarea" style="width: 100%;height:150px;" id="signature_1" name="signature[1]">{{$signature[1]}}</textarea>
                                        </td>
                                        <td style="background: white;border: 1px solid #0e0e0e !important;vertical-align: initial !important;">
                                            <textarea class="tinymce-textarea" style="width: 100%;height:150px;" id="signature_2" name="signature[2]">{{$signature[2]}}</textarea>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <!-- End Sign -->
                </form>
            </div>
            <div class="col-md-12 text-center" style="margin: 15px 0px 0px 0px;">
                <!-- <a type="button" class="btn btn-labeled btn-info" onclick="PrevTab();" id="Previous" title="Previous" style="display:none;height: 35px;background: blue !important; border-color:blue !important; color:white !important">
                    <span class="btn-label" style="font-size:13px !important;"><i class="fa fa-arrow-left"></i></span> Previous</a> -->
                <a type="button" onclick="save('Submitted')" id="submitbutton" class="btn btn-labeled btn-succes" title="Publish" style="background: orange !important; color:white !important">
                    <span class="btn-label" style="font-size:13px !important;"><i class="fa fa-check"></i></span> Submit</a>
                <a type="button" onclick="save('Saved')" id="submitbutton" class="btn btn-labeled btn-succes" title="Save" style="background: green !important; border-color:green !important; color:white !important">
                    <span class="btn-label" style="font-size:13px !important;"><i class="fa fa-check"></i></span> Save</a>
                <a type="button" class="btn btn-labeled back-btn" title="Back" href="{{ route('referralreport.index') }}" style="color:white !important">
                    <span class="btn-label" style="font-size:13px !important;"><i class="fa fa-arrow-left"></i></span> Back</a>
                <!-- <a type="button" class="btn btn-labeled btn-info" onclick="NextTab();" id="Next" title="Next" style="background: blue !important; border-color:#4d94ff !important; color:white !important;height: 35px;">
                    <span class="btn-label" style="font-size:13px !important;">Next</span> <i class="fa fa-arrow-right"></i></a> -->
            </div>
        </div>


    </div>
</div>
<!-- <script>$('tr:not(:has(td[rowspan])):even').addClass('oddrow');</script> -->
<script>
    function save(a) {
        // if (document.getElementById('enrollment_child_num').value == "") {
        //     swal.fire("Please Select Enrolment Number", "", "error");
        //     return false;
        // }
        document.getElementById('state').value = a;
        document.getElementById('form_report').submit();

    }

    function checkOption(selectElem) {
        // console.log(selectElem.id);
        var otherOption = document.getElementById("otherInput" + selectElem.id);
        if (selectElem.value == "0") {
            otherOption.style.display = "block";
        } else {
            otherOption.style.display = "none";
        }
    }
</script>
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
                // console.log(data);

                if (data != '[]') {

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
    var aof = '<select class="form-control default" name="focus_area" id="focus_area" onchange="focus_area()"><option value="">Select Area of focus</option><option value="">Occupational Therapist</option><option value="">Speech Therapist</option><option value="">Special Education</option><option value="">Physical Trainer</option><option value="">Physiotherapy</option><option value="">Yoga Therapist</option></select>';
    var referral = '<select class="form-control default" name=""><option value="">Select Referral</option></select>';
    var frequency = '<input class="form-control default" type="text" id="frequency" name="frequency" autocomplete="off">';
    var referraloptions = '<option value="">Ms. Sukanya - 9876522210</option><option value="">Ms. Sumithra Shailesh - 9876543217</option><option value="">Ms. Ramalakshmi - 9876543233</option><option value="">Ms. Vijayalakshmi - 9876543216 </option><option value="">Mr. Stephen - 9876543211</option><option value="">Ms. Malini - 9876543210 </option>';

    function focus_area(id) {
        // alert(id);
        var focus_area = $('#focus_area' + id).val();
        if (focus_area == "0") {
            document.getElementById('otherInputfocus_area' + id).style.display = "block";
            var selectElement = document.getElementById('referral_users' + id);
            selectElement.innerHTML = '';
            $('#referral_users' + id).append('<option value="0">Other</option>');
            var selectElement = document.getElementById('referral_users' + id);
            selectElement.selectedIndex = '0';
            selectElement.onchange();
        } else {
            document.getElementById('otherInputfocus_area' + id).style.display = "none";
            var selectElement = document.querySelector('#referral_users' + id);
            selectElement.innerHTML = '';
            selectElement.innerHTML = '<option value="">Select Referral</option>';
            selectElement.onchange();
            $('#otherInputreferral_users' + id).hide();
            $('#otherInputreferral_users' + id).val('');
            $.ajax({
                url: "{{ url('/therapist/specialization/getuser') }}",
                type: 'POST',
                data: {
                    'focus_area': focus_area,
                    _token: '{{csrf_token()}}'
                }
            }).done(function(data) {
                if (data.length != 0) {
                    var ddd = '';
                    for (var i = 0; i < data.length; i++) {
                        var name = data[i].name;
                        var phone_number = data[i].phone_number;
                        var user_id = data[i].id;
                        ddd += '<option value="' + user_id + '">' + name + '-' + phone_number + '</option>';
                    }
                    ddd += '<option value="0">Other</option>';
                    $('#referral_users' + id).append(ddd);
                } else {
                    selectElement.innerHTML = '';
                    var ddd = '<option value="">No Records Found</option>';
                    ddd += '<option value="0">Other</option>';
                    $('#referral_users' + id).append(ddd);
                }
            })
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
        var cloneRow = thisRow.clone(true).insertAfter(thisRow).data('is_clone', true);
        // console.log(cloneRow);
        $(this).attr("id", "hide");
        $(this).parent().find('.remove').attr('id', 'hide');
        var nextRow = thisRow.next();
        nextRow.find('input:not(.row_div)').val("");
        nextRow.find('.row_div').attr("id", "hide");
        if (thisRow.data('is_clone')) {
            while (thisRow.data('is_clone')) {
                thisRow = thisRow.prev();
            }
        } else {
            nextRow.children(":first").remove();
        }
        var order = $(this).attr("order");
        var rowSpanCount = $('#recommendation' + order).attr('rowspan');
        $('#recommendation' + order).attr('rowspan', Number(rowSpanCount) + 1);

        var rowCount = $('#recommendation' + order).attr('rowspan');
        var select = cloneRow.find('select[name^="focus_area"]');
        var id = select.attr('id');
        var suffix = id.replace('focus_area', '');
        select.attr('id', id + '_' + rowCount).attr('onchange', 'focus_area("' + suffix + '_' + rowCount + '")');

        // <input class="form-control default" type="text" name="focus_area_other[' + trl + '][]" id="otherInputfocus_area' + trl + '" style="display: none;">
        var inputText = cloneRow.find('input[name^="focus_area_other"]');
        inputText.each(function(index) {
            var newID = $(this).attr('id') + '_' + rowCount;
            $(this).attr('id', newID);
        });

        var select2 = cloneRow.find('select[name^="referral_users"]');
        var id2 = select2.attr('id');
        select2.attr('id', id2 + '_' + rowCount);

        var input = cloneRow.find('input[name^="referral_users_other"]');
        var id2 = input.attr('id');
        if (input.css('display') === 'block') {
            input.css('display', 'none');
        }
        input.attr('id', id2 + '_' + rowCount);

        const selectElement = document.querySelector('#' + id2 + '_' + rowCount);
        selectElement.innerHTML = '';
        selectElement.innerHTML = '<option value="">Select Referral</option>';

    });

    // $(document).on('click', ".remove", function() {
    //     var thisRow = $(this).parent().parent(),
    //         prevRow = thisRow.prev();

    //     if (thisRow.data('is_clone')) {
    //         while (prevRow.data('is_clone')) {
    //             prevRow = prevRow.prev();
    //         }
    //     } else {
    //         prevRow = prevRow.prev();
    //         // prevRow = thisRow.next()
    //         //     .removeData('is_clone')
    //         //     .children(":first")
    //         //     .before(thisRow.children(":first"))
    //         //     .end();
    //     }
    //     prevRow.find('.remove').last().removeAttr('id');
    //     prevRow.find('.row_div').last().removeAttr('id');
    //     currRowSpan = prevRow.children(":first").attr("rowspan");
    //     if (currRowSpan > 1) {
    //         prevRow.children(":first").attr("rowspan", currRowSpan - 1);
    //     }
    //     thisRow.remove();
    // });
    $(document).on('click', ".remove", function() {
        var thisRow = $(this).parent().parent(),
            prevRow = thisRow.prev();

        var currentFrequency = thisRow.find('#frequency').val().trim();

        // If the input is empty, remove the row directly
        if (currentFrequency === '') {
            removeRow();
        } else {
            // If the input is not empty, show a validation prompt
            Swal.fire({
                title: 'Do you want to remove this frequency from the report?',
                text: 'Click Yes to remove the frequency point. Please note that this action cannot be reversed',
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'Yes',
                cancelButtonText: 'No',
            }).then((result) => {
                if (result.isConfirmed) {
                    // If the user confirms, remove the row
                    removeRow();
                }
            });
        }

        function removeRow() {
            // The row removal logic
            if (thisRow.data('is_clone')) {
                while (prevRow.data('is_clone')) {
                    prevRow = prevRow.prev();
                }
            } else {
                prevRow = prevRow.prev();
            }
            prevRow.find('.remove').last().removeAttr('id');
            prevRow.find('.row_div').last().removeAttr('id');
            currRowSpan = prevRow.children(":first").attr("rowspan");
            if (currRowSpan > 1) {
                prevRow.children(":first").attr("rowspan", currRowSpan - 1);
            }
            thisRow.remove();
        }
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
        var tempfrequency = '<input class="form-control default" type="text" id="frequency" name="frequency[' + trl + '][]" value="" autocomplete="off">';
        tempfrequency += '<div class="row_div" order="' + trl + '"><a class="btn" title="Add"><i class="fa fa-plus-circle"></i></a></div>';
        tempfrequency += '<a class="btn remove" title="Add"><i class="fa fa-times"></i></a>';
        for (var i = 0; i < cols; i++) {
            cell = row.insertCell(i);
            j = i + 1;
            if (j == 1) {
                cell.id = 'recommendation' + trl;
                cell.rowSpan = 1;
                cell.innerHTML = '<textarea style="height: 50px !important;" class="form-control default" name="recommendation_area[' + trl + ']"></textarea>';
            }
            if (j == 2) {
                var aofD = <?php echo json_encode($specialization); ?>;
                var aof = '<select class="form-control default" name="focus_area[' + trl + '][]" id="focus_area' + trl + '" onchange="focus_area(' + trl + ')"><option value="">Select Area of focus</option>';
                for (var ik = 0; ik < aofD.length; ik++) {
                    var id = aofD[ik].id;
                    var specialization = aofD[ik].specialization;
                    aof += "<option value=" + id + ">" + specialization + "</option>";
                }
                aof += '<option value="0">Others</option>';
                aof += "</select>";
                aof += '<input class="form-control default" type="text" name="focus_area_other[' + trl + '][]" id="otherInputfocus_area' + trl + '" style="display: none;">';
                cell.innerHTML = aof;
            }
            if (j == 3) {
                var ref = '<select class="form-control default" name="referral_users[' + trl + '][]" id="referral_users' + trl + '" onchange="checkOption(this)">';
                ref += '<option value="">Select Referral</option>';
                ref += '</select>';
                ref += '<input class="form-control default" type="text" name="referral_users_other[' + trl + '][]" id="otherInputreferral_users' + trl + '" style="display: none;">';
                cell.innerHTML = ref;
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
            selector: '.meeting_description',
            height: 250,
            plugins: 'preview importcss searchreplace autolink autosave save directionality code visualblocks visualchars fullscreen image link media codesample table charmap pagebreak nonbreaking anchor insertdatetime advlist lists wordcount help charmap quickbars emoticons',
            imagetools_cors_hosts: ['picsum.photos'],
            menubar: 'file edit view insert format table help',
            toolbar: 'undo redo | bold italic underline strikethrough | fontfamily fontsize blocks | alignleft aligncenter alignright alignjustify | outdent indent |  numlist bullist | forecolor backcolor removeformat | media link | ltr rtl',
            toolbar_sticky: true,
            autosave_ask_before_unload: true,
            autosave_interval: "30s",
            autosave_prefix: "{path}{query}-{id}-",
            autosave_restore_when_empty: false,
            autosave_retention: "2m",
            image_advtab: true,
            content_css: "{{url('assets/css/css2.css')}}",
            font_formats: "Andale Mono=andale mono,times; Arial=arial,helvetica,sans-serif; Arial Black=arial black,avant garde; Barlow=Barlow, sans-serif; Barlow Condensed=Barlow Condensed, sans-serif; Barlow Semi Condensed=Barlow Semi Condensed, sans-serif; Plain Barlow Black=Barlow Black, sans-serif; Plain Barlow Bold=Barlow Bold, sans-serif; Plain Barlow Light=Barlow Light, sans-serif; Plain Barlow Medium=Barlow Medium, sans-serif; Plain Barlow Thin=Barlow Thin, sans-serif; Book Antiqua=book antiqua,palatino; Comic Sans MS=comic sans ms,sans-serif; Courier New=courier new,courier; Georgia=georgia,palatino; Helvetica=helvetica; Impact=impact,chicago; Oswald=oswald; Symbol=symbol; Tahoma=tahoma,arial,helvetica,sans-serif; Terminal=terminal,monaco; Times New Roman=times new roman,times; Trebuchet MS=trebuchet ms,geneva; Verdana=verdana,geneva; Webdings=webdings; Wingdings=wingdings,zapf dingbats",
            content_style: "@import url('https://fonts.googleapis.com/css2?family=Barlow&display=swap');",
            content_style: "@import url(https://fonts.googleapis.com/css2?family=Barlow+Condensed:wght@400;display=swap);",
            content_style: "@import url(https://fonts.googleapis.com/css2?family=Barlow+Condensed:wght@700&display=swap);",
            content_style: "@import url('https://fonts.googleapis.com/css2?family=Barlow+Semi+Condensed:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap');",
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

            image_caption: true,
            quickbars_selection_toolbar: 'bold italic | quicklink h2 h3 blockquote quickimage quicktable',
            noneditable_noneditable_class: "mceNonEditable",
            toolbar_mode: 'sliding',
            contextmenu: "link image imagetools table",
        });
        tinymce.init({
            selector: '.tinymce-textarea',
            height: 200,
            branding: false,
            plugins: 'importcss',
            autosave_ask_before_unload: false, //Set True to for confirmation on unload
            toolbar: '',
            font_formats: "Andale Mono=andale mono,times; Arial=arial,helvetica,sans-serif; Arial Black=arial black,avant garde; Barlow=Barlow, sans-serif; Barlow Condensed=Barlow Condensed, sans-serif; Barlow Semi Condensed=Barlow Semi Condensed, sans-serif; Plain Barlow Black=Barlow Black, sans-serif; Plain Barlow Bold=Barlow Bold, sans-serif; Plain Barlow Light=Barlow Light, sans-serif; Plain Barlow Medium=Barlow Medium, sans-serif; Plain Barlow Thin=Barlow Thin, sans-serif; Book Antiqua=book antiqua,palatino; Comic Sans MS=comic sans ms,sans-serif; Courier New=courier new,courier; Georgia=georgia,palatino; Helvetica=helvetica; Impact=impact,chicago; Oswald=oswald; Symbol=symbol; Tahoma=tahoma,arial,helvetica,sans-serif; Terminal=terminal,monaco; Times New Roman=times new roman,times; Trebuchet MS=trebuchet ms,geneva; Verdana=verdana,geneva; Webdings=webdings; Wingdings=wingdings,zapf dingbats",
            content_style: "@import url('https://fonts.googleapis.com/css2?family=Barlow&display=swap');",
            content_style: "@import url('https://fonts.googleapis.com/css2?family=Barlow+Condensed:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap');",
            content_style: "@import url(https://fonts.googleapis.com/css2?family=Barlow+Condensed:wght@400;display=swap);",
            content_style: "@import url(https://fonts.googleapis.com/css2?family=Barlow+Condensed:wght@700&display=swap);",
            content_style: "@import url('https://fonts.googleapis.com/css2?family=Barlow+Semi+Condensed:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap');",
            content_style: 'body {font-family :Barlow Condensed, sans-serif; font-size:14px }',
        });
        var recommendations = <?php echo json_encode($recommendations); ?>;
        // console.log(recommendations);
        for (var k = 0; k < recommendations.length; k++) {
            var rID = recommendations[k].id;
            $(".addHide" + rID).not(":last").addClass("hide_div");

        }
    });
</script>
<script>
    function checkCharCount(textarea) {
        var maxChar = 1000;

        if (textarea.value.length >= maxChar) {
            textarea.value = textarea.value.substring(0, maxChar);
            textarea.removeEventListener("input", checkCharCount);
        }

        var remainingChars = maxChar - textarea.value.length;
        console.log("Remaining characters: " + remainingChars);
    }
</script>
@endsection