@extends('layouts.parent')

@section('content')
<style>
    .stepper-horizontal {
        display: table;
        width: 100%;
        margin: 0 auto;
    }

    .stepper-horizontal .step {
        display: table-cell;
        position: relative;
        padding: 1.5rem;
        z-index: 2;
        width: 25%;
    }

    .stepper-horizontal .step:last-child .step-bar-left,
    .stepper-horizontal .step:last-child .step-bar-right {
        display: none;
    }

    .stepper-horizontal .step .step-circle {
        width: 2rem;
        height: 2rem;
        margin: 0 auto;
        border-radius: 50%;
        text-align: center;
        line-height: 1.75rem;
        font-size: 1rem;
        font-weight: 600;
        z-index: 2;
        border: 2px solid #d9e2ec;
    }

    .stepper-horizontal .step.done .step-circle {
        background-color: #199473;
        border: 2px solid #199473;
        color: #ffffff;
    }

    .stepper-horizontal .step.done .step-circle:before {
        font-family: "FontAwesome";
        font-weight: 100;
        content: "\2713";
        font-size: 1.5em;
        /* Adjust icon size as needed */
        color: white;
        /* Adjust color as needed */
    }

    .stepper-horizontal .step.done .step-circle * {
        display: none;
    }

    .stepper-horizontal .step.done .step-title {
        color: #102a43;
    }

    .stepper-horizontal .step.editing .step-circle {
        background: #ffffff;
        border-color: #199473;
        color: #199473;
    }

    .stepper-horizontal .step.editing .step-title {
        color: #199473;
        text-decoration: underline;
    }

    .stepper-horizontal .step .step-title {
        margin-top: 1rem;
        font-size: 1rem;
        font-weight: 600;
    }

    .stepper-horizontal .step .step-title,
    .stepper-horizontal .step .step-optional {
        text-align: center;
        color: #829ab1;
    }

    .stepper-horizontal .step .step-optional {
        font-size: 0.75rem;
        font-style: italic;
        color: #9fb3c8;
    }

    .stepper-horizontal .step .step-bar-left,
    .stepper-horizontal .step .step-bar-right {
        position: absolute;
        top: calc(2rem + 5px);
        height: 5px;
        background-color: #d9e2ec;
        border: solid #d9e2ec;
        border-width: 2px 0;
    }

    .stepper-horizontal .step .step-bar-left {
        width: calc(100% - 2rem);
        left: 50%;
        margin-left: 1rem;
        z-index: -1;
    }

    .stepper-horizontal .step .step-bar-right {
        width: 0;
        left: 50%;
        margin-left: 1rem;
        z-index: -1;
        transition: width 500ms ease-in-out;
    }

    .stepper-horizontal .step.done .step-bar-right {
        background-color: #199473;
        border-color: #199473;
        z-index: 3;
        width: calc(100% - 2rem);
    }
</style>
<style>
    .q_lable {
        padding-left: 3% !important;
    }

    /* .page_lable {
        display: flex;
        flex-wrap: wrap;
    } */
</style>
<style>
    .tab {
        overflow: hidden;
        border: 1px solid #f37020;
        background-color: #d4d0cf;
        border-radius: 36px;
        /* justify-content: center; */
        width: fit-content;
        margin: auto;
        text-align: center;

    }

    /* Style the buttons inside the tab */
    .tab button {
        background-color: #d4d0cf;
        /* float: left; */
        border: none;
        outline: none;
        cursor: pointer;
        padding: 14px 4.1rem;
        transition: 0.3s;
        font-size: 20px;
        border-radius: 36px;
    }

    /* Change background color of buttons on hover */
    .tab button:hover {
        background-color: #f37020;
    }

    /* Create an active/current tablink class */
    .tab button.active {
        background-color: #f37020;
    }

    /* Style the tab content */
    .tabcontent {
        display: none;
        padding: 6px 12px;
        margin-top: 20px;
        /* border: 1px solid #ccc; */
        /* border-top: none; */
    }
</style>
<style>
    .card_design {
        background-color: white;
        border-radius: 12px !important;
        margin-top: 2rem;
    }

    .card_design label {
        /* text-align: center; */
    }
</style>
<style>
    .current {
        color: green;
    }

    #pagin li {
        display: inline-block;
    }

    .prev {
        cursor: pointer;
    }

    .next {
        cursor: pointer;
    }

    .last {
        cursor: pointer;
        margin-left: 5px;
    }

    .first {
        cursor: pointer;
        margin-right: 5px;
    }

    .table_content {
        /* width: 100%; */
        border-collapse: collapse;
    }

    .table_content td {
        padding: 12px 15px;
        text-align: left !important;
        font-size: 16px;
    }

    .table_content th {
        padding: 12px 15px;
        text-align: center !important;
        font-size: 16px;
    }

    .inputError {
        box-shadow: inset 0px 0px 0px 2px #f31010;
        padding-top: 1px;
        padding-bottom: 1px;
        border-radius: 10px;
        margin-bottom: 10px;
        margin-top: 10px;
    }
</style>
@include('questionnaire_for_parents.style')
<style>
    #frname {
        color: red;
    }

    .form-control {
        background-color: #ffffff !important;
    }

    .is-coordinate {
        justify-content: center;
    }

    .form-control:disabled,
    .form-control[readonly] {
        background-color: #e9ecef !important;
        opacity: 1;
    }

    .centerid {
        width: 100%;
        text-align: center;
    }
    
    /* Media query for mobile devices */
@media only screen and (min-width: 768px) {
    .is-coordinate {
        display: flex;
        justify-content: space-around; /* Adjusted for smaller screens */
        flex-direction: row;
    }
}
@media only screen and (max-width: 768px) {
.multi-question {
        text-align: center;
        width: 100%;
        overflow-x: scroll;
        overflow-y: hidden;
    }
    .stickTd {
        position: sticky;
        left: 0;
        background: #f5f5f5;
    }
}
@media (max-width: 767px) {
        .otherOption {
            opacity: 1;
 
            margin: -2px 0px 0px 80px;
        }
    }
</style>
<div class="main-content">
   
    @if($role == 'Parent')
    {{ Breadcrumbs::render('questionnaire.submitted.form',$questionDetails[0]['questionnaire_name']) }}
    @else
    @if($questionDetails[0]['questionnaire_type'] == 'OVM')
    {{ Breadcrumbs::render('questionnaire.submitted.form1',$questionDetails[0]['questionnaire_name']) }}
    @elseif($questionDetails[0]['questionnaire_type'] == 'SAIL' || $questionDetails[0]['questionnaire_type'] == 'Sail')
    {{ Breadcrumbs::render('questionnaire.submitted.form2',$questionDetails[0]['questionnaire_name']) }}
    @endif
    @endif
   
    <div class="col-md-12 card" style="background-color: white;">
        <div class="is-coordinate">
            <div class="col-sm-3">
                <div class="form-group">
                    <label class="control-label">Enrollment ID</label>
                    <input class="form-control" name="enrollment_id" readonly value="{{ $enrollmentDetails[0]['enrollment_child_num']}}" placeholder="Enrollment ID" required style="color:black !important;">
                </div>
            </div>

            <div class="col-sm-3">
                <div class="form-group">
                    <label class="control-label">Child ID</label>
                    <input class="form-control" type="text" id="child_id" readonly name="child_id" value="{{ $enrollmentDetails[0]['child_id']}}" disabled="" placeholder="OVM1 Meeting" required autocomplete="off" style="color:black !important;">
                </div>
            </div>

            <div class="col-sm-3">
                <div class="form-group">
                    <label class="control-label">Child Name</label>
                    <input class="form-control" type="text" id="child_name" readonly name="child_name" value="{{ $enrollmentDetails[0]['child_name']}}" disabled="" placeholder="Enter Name" required autocomplete="off" style="color:black !important;">
                </div>
            </div>
        </div>
    </div>

    <div class="card" style="margin: 10px 0px 20px 0px;background-color: white;">
        <h5 style="text-align: center;margin:15px;">{{$questionDetails[0]['questionnaire_name']}}</h5>
        <div class="card-body" style="background-color: white !important;">
            {!! $questionDetails[0]['questionnaire_description'] !!}
        </div>
    </div>

    <div class="row justify-content-center">
        <div class="col-lg-12 col-md-12">
            <div class="" style="height:100%;">
                <div id="content">
                    <div class="scroll-break-div"></div>
                    <div class="stepper-horizontal" id="stepper1" style="display: none;">
                        <div class="step editing" id="Stepper1ID">
                            <div class="step-circle"><span>1</span></div>
                            <div class="step-bar-left" id="Stepper2ID2"></div>
                        </div>
                        <div class="step" id="Stepper2ID">
                            <div class="step-circle"><span>2</span></div>
                            <div class="step-bar-left" id="Stepper3ID2"></div>
                        </div>
                        <div class="step" id="Stepper3ID">
                            <div class="step-circle"><span>3</span></div>
                            <div class="step-bar-left" id="Stepper4ID2"></div>
                        </div>
                        <div class="step" id="Stepper4ID">
                            <div class="step-circle"><span>4</span></div>
                            <div class="step-bar-left"></div>
                        </div>
                    </div>

                    <div class="tab">
                        <button class="tablinks active" id="Tab1" onclick="openCity(event, 'Step1' , '1')">Stage 1</button>
                        <button class="tablinks" id="Tab2" onclick="openCity(event, 'Step2' , '2')">Stage 2</button>
                        <button class="tablinks" id="Tab3" onclick="openCity(event, 'Step3' , '3')">Stage 3</button>
                        <button class="tablinks" id="Tab4" onclick="openCity(event, 'Step4' , '4')">Stage 4</button>
                    </div>
                    <form class="formValidationDiv" action="{{ route('questionnaire.form.save') }}" method="post" id="divQuestionnaireForm">
                        {{ csrf_field() }}
                        <div class="card card_design">
                            <input type="hidden" value="{{$questionnaire_initiation_id}}" id="questionnaire_initiation_id" name="questionnaire_initiation_id">
                            <input type="hidden" id="btn_type" name="progress_status">
                            <div id="Step1" class="tabcontent pagination_one page_lable">
                                <!-- <ul id="pagin"></ul> -->
                            </div>
                            <div id="Step2" class="tabcontent pagination_two page_lable">
                                <!-- <ul id="pagin"></ul> -->
                            </div>
                            <div id="Step3" class="tabcontent pagination_three page_lable">
                                <!-- <ul id="pagin"></ul> -->
                            </div>
                            <div id="Step4" class="tabcontent pagination_four page_lable">
                                <!-- <ul id="pagin"></ul> -->
                            </div>
                            <!-- <div id="list_page1" class="list_page">
                            </div> -->
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="tile-footer title-footer-button-alignment" style="padding: 10px;display: flex;justify-content: center;">
            <a type="button" class="btn btn-labeled btn-info" onclick="PrevTab();" id="Previous" title="Previous" style="display:none;background: blue !important; border-color:blue !important; color:white !important">
                <span class="btn-label" style="font-size:13px !important;"><i class="fa fa-arrow-left"></i></span> Previous Stage</a>

            @if($role == 'Parent')
            <a type="button" class="btn btn-labeled back-btn" title="Back" href="{{ route('questionnaire_for_user.index') }}" style="color:white !important;background: red !important;">
                <span class="btn-label" style="font-size:13px !important;"><i class="fa fa-arrow-left" style="color:white !important"></i></span> Cancel</a>
            @else
            <a type="button" class="btn btn-labeled back-btn" title="Back" href="{{ URL::previous() }}" style="color:white !important;background: red !important;">
                <span class="btn-label" style="font-size:13px !important;"><i class="fa fa-arrow-left"></i></span> Cancel</a>
            @endif

            <a type="button" class="btn btn-labeled btn-info" onclick="NextTab();" id="Next" title="Next" style="background: blue !important; border-color:#4d94ff !important; color:white !important;">
                <span class="btn-label" style="font-size:13px !important;">Next Stage</span> <i class="fa fa-arrow-right"></i></a>
        </div>
        <!-- <div class="bs-stepper-content">
            <div id="test-l-1" class="content">
            </div>
        </div> -->
    </div>
</div>
<script>
    $(document).ready(function() {
        for (i = 1; i <= 4; i++) {
            var zzz = $(".pagination-element" + i).length;
            if (zzz == 0) {
                var TabID = 'Tab'.concat(i);
                var StepperID = 'Stepper' + i + 'ID';
                var StepperID2 = 'Stepper' + i + 'ID2';

                document.getElementById(TabID).style.display = "none";
                document.getElementById(StepperID).style.display = "none";
                document.getElementById(StepperID2).style.display = "none";
            }
        }
    });
</script>
<script>
    function save() {

        document.getElementById('btn_type').value = 'save';

        document.getElementById('divQuestionnaireForm').submit();
    }

    function sub() {
        document.getElementById('btn_type').value = 'submit';

        divClass = document.getElementsByClassName("divClass");
        for (i = 0; i < divClass.length; i++) {
            divClass[i].className = divClass[i].className.replace(" inputError", "");
        }

        for (cindex = 1; cindex < divCount + 1; cindex++) {
            var stepNum = cindex + 1;
            var numSteps = divCount;
            currentStep = stepNum;
            currentStep++;
            var presentSten = cindex;
            $('.pagination' + presentSten + '').each(function(i, el) {
                var type = $(el).attr('type'); //alert(type);
                var name = $(el).attr('name'); //alert(name);
                var tag = $(el).prop("tagName"); //alert(tag);
                var data = $(el).val();
                var idd = $(el).attr('id'); //alert(idd);

                var divErrorID = 'div'.concat(idd); //alert(divErrorID);


                var subcat, getSelectedValue, checkbox;
                if (type == 'radio') {
                    var getSelectedValue = document.querySelector("input[name=" + name + "]:checked");
                }
                if (type == 'checkbox') {
                    var checkbox = document.querySelector('input[name="' + name + '"]:checked');
                }
                if (tag == 'SELECT') {
                    var subcat = document.getElementById(name);
                }

                if (type == 'text' || tag == 'TEXTAREA') {
                    if (data == '' || data == null || data == undefined) {
                        document.getElementById(divErrorID).classList.add('inputError');
                    }
                } else if (type == 'radio') {
                    if (getSelectedValue == null) {
                        var element = document.getElementById(divErrorID); //console.log(element);alert(element);
                        element.classList.add("inputError");
                    }
                } else if (type == 'checkbox') {
                    if (checkbox == null) {
                        document.getElementById(divErrorID).classList.add('inputError');
                    }
                } else if (type == undefined && tag == 'SELECT') {
                    if (subcat.value == null || subcat.value == "") {
                        document.getElementById(divErrorID).classList.add('inputError');
                    }
                }
            });

        }

        var hasError = $(".inputError").length;

        if (hasError == 0) {
            document.getElementById('divQuestionnaireForm').submit();
        } else {
            swal.fire("Please Fill All Answers: ", "", "error");
            return false;
        }

        // var dataForm = $('form#divQuestionnaireForm').serializeArray();
        // var formData = {};
        // console.log(dataForm);
        // for (var i = 0; i < dataForm.length; i++) {
        //     formData[dataForm[i].name] = dataForm[i].value;
        //     var cccccc = dataForm[i].value;
        //     if (cccccc == '' || cccccc == null) {
        //         swal.fire("Please Fill All Answers: ", "", "error");
        //         return false;
        //     }
        // }
        // alert('sub');
        // document.getElementById('divQuestionnaireForm').submit();
    }
</script>
<script>
    $('#saveButton').click(function() {
        $('#saveButton').attr("disabled", true);
        var dataForm = $('form#divQuestionnaireForm').serializeArray();
        var formData = {};
        for (var i = 0; i < dataForm.length; i++) {
            formData[dataForm[i].name] = dataForm[i].value;
        }
        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
        $.ajax({
            url: '/questionnaire/form/save',
            type: 'POST',
            data: {
                _token: CSRF_TOKEN,
                formData
            }
        }).done(function(data) {

            if (data != null) {

                swal.fire({
                        title: "Questionnaire Form",
                        text: "Form Saved Successfully",
                        type: "success",
                        confirmButtonColor: '#e73131',
                        confirmButtonText: 'OK',
                    },
                    function(isConfirm) {
                        if (isConfirm) {
                            window.location.href = "/questionnaire/form/editdata/" + data;
                        } else {

                        }
                    });

            }
        });
    });
</script>
<script>
    var stepper1Node = document.querySelector('#stepper1')
    var stepper1 = new Stepper(document.querySelector('#stepper1'))

    stepper1Node.addEventListener('show.bs-stepper', function(event) {
        console.warn('show.bs-stepper', event)
    })
    stepper1Node.addEventListener('shown.bs-stepper', function(event) {
        console.warn('shown.bs-stepper', event)
    })

    var stepper2 = new Stepper(document.querySelector('#stepper2'), {
        linear: false,
        animation: true
    })
    var stepper3 = new Stepper(document.querySelector('#stepper3'), {
        animation: true
    })
    var stepper4 = new Stepper(document.querySelector('#stepper4'))
</script>
<script>
    $(document).ready(function() {
        var cityName = 'Step1';
        document.getElementById(cityName).style.display = "block";
        // evt.currentTarget.className += " active";
        currentPagination('1');
        // nextStep('1');
    });

    function openCity(evt, cityName, stepNum) {

        var tabID = $('.tablinks.active').attr('id');
        var ret = tabID.replace('Tab', '');
        var i, tabcontent, tablinks;
        // tabcontent = document.getElementsByClassName("tabcontent");
        // for (i = 0; i < tabcontent.length; i++) {
        //     tabcontent[i].style.display = "none";
        // }
        // tablinks = document.getElementsByClassName("tablinks");
        // for (i = 0; i < tablinks.length; i++) {
        //     tablinks[i].className = tablinks[i].className.replace(" active", "");
        // }
        // document.getElementById(cityName).style.display = "block";
        // evt.currentTarget.className += " active";
        // currentPagination(stepNum);
        // nextStep(stepNum, ret);//alert('success');
        if (stepNum != ret) {
            if (stepNum < ret) {
                PrevTab1(stepNum);
            } else {
                NextTab1(stepNum);
            }
        }

    }
</script>
<script src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.11.1/jquery.validate.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.6.2/jquery.min.js"></script>


<script>
    // $(document).ready(function() {
    //     var questionnaireID = $('#questionnaireID').val();
    //     $.ajax({
    //         url: '/questionnaire/fields/list',
    //         type: 'GET',
    //         data: {
    //             'questionnaireID': questionnaireID
    //         }
    //     }).done(function(data) {
    //         var response = JSON.parse(data);
    //         console.log(response);
    //         if (response.length > 0) {
    //             QuestionnaireForm(response);
    //             pagination();
    //         }
    //         $(".loader_div").hide();
    //     })
    // });


    $(document).ready(function() {

        var response = <?php echo (json_encode($question)); ?>;
        if (response.length > 0) {
            // $(".loader_div").show();
            QuestionnaireForm(response);
            // pagination();
            pagi_nation();
            currentPagination('1');
        }
        // $(".loader_div").hide();

    });

    // function autoIncrementCustomId(lastRecordId) {
    //     let increasedNum = Number(lastRecordId.replace('#Step', '')) + 1;
    //     let kmsStr = lastRecordId.substr(0, 5);
    //     kmsStr = kmsStr + increasedNum.toString();
    //     return kmsStr;
    // }

    function QuestionnaireForm(DataFields) {
        var count = DataFields.length;

        if (count > 40) {
            divCount = 4;
        } else {
            divCount = 3;
            document.getElementById("Tab4").style.display = "none";
            document.getElementById("Stepper4ID").style.display = "none";
            document.getElementById("Stepper4ID2").style.display = "none";
        }

        var tab_count = Math.ceil(count / divCount);
        const tab_content = [0];
        var ttt = [];
        var pushNumcount = 0;

        for (let jk = 0; jk < DataFields.length; jk++) {
            var fId = DataFields[jk]['questionnaire_field_types_id'];
            if (fId == 9) {
                ttt.push(jk);
            }
        }

        for (i = 1; i <= divCount; i++) {
            var pushNum = i * tab_count + 1;
            var pushNum1 = i * tab_count;

            if (ttt.includes(pushNum1)) {
                pushNumcount++;
                pushNum = pushNum + pushNumcount;
            }
            tab_content.push(pushNum);
        }
        var step = '#Step';
        let num = 0;

        var documentCategoryID = $('#documentCategory').val();
        var questionIndex = 0;
        var stageQuestionCount = 0;
        var addon = 0;
        for (let index = 0; index < DataFields.length; index++) {

            const isInArray = tab_content.includes(index);
            if (isInArray == true) {
                num++
                const stage1 = step.concat(num);
                var stage = step.concat(num);
                stageQuestionCount = 0;
            }
            // var questionNum = Number(index) + 1;
            // stage = '#Step1';
            // console.log(DataFields);
            stageQuestionCount++;
            var checkindex = index; //alert(checkindex);
            const fieldTypeID = DataFields[index]['questionnaire_field_types_id'];
            const fieldID = DataFields[index]['question_details_id'];
            const fieldLabel = DataFields[index]['question'];
            const fieldName = DataFields[index]['question_field_name'];
            const fieldValue = DataFields[index][fieldName]; //alert(fieldValue);
            var fieldOptionsDB = <?php echo (json_encode($fieldOptionsDB)); ?>;
            var fieldQuestionsDB = <?php echo (json_encode($fieldQuestionsDB)); ?>;
            const otherOption = DataFields[index]['other_option'];
            const requiredQuestion = DataFields[index]['required'];

            if (fieldTypeID != 9) {
                // var questionNum = Number(index)+1;
                questionIndex++
                var questionNum = questionIndex;
            } else {
                var questionNum = questionIndex;
            }
            if (fieldTypeID == 1) {
                var textboxHtml = '<div class="col-md-12 divClass" id="div' + fieldName + '"><div class="form-group pagination-element' + num + '">';
                textboxHtml += '<label class="control-label ' + (requiredQuestion == 1 ? ' required' : '') + '">' + questionNum + ' . ' + fieldLabel + '</label>';
                if (fieldValue == null) {
                    textboxHtml += '<input disabled class="form-control pagination' + num + '" type="text" id="' + fieldName + '" name="' + fieldName + '" placeholder="Your Answer" style="background-color:white !important;color:black !important;"><i class="bar"></i>';
                } else {
                    textboxHtml += '<input disabled class="form-control pagination' + num + '" readonly type="text" value="' + fieldValue + '" id="' + fieldName + '" name="' + fieldName + '" placeholder="Your Answer" style="background-color:white !important;color:black !important;"><i class="bar"></i>';
                }
                textboxHtml += '</div></div>';
                $(stage).append(textboxHtml);
            }

            if (fieldTypeID == 8) {
                var textboxHtml = '<div class="col-md-12 divClass" id="div' + fieldName + '"><div class="form-group pagination-element' + num + '">';
                textboxHtml += '<label class="control-label ' + (requiredQuestion == 1 ? ' required' : '') + '">' + questionNum + ' . ' + fieldLabel + '</label>';
                if (fieldValue == null) {
                    textboxHtml += '<input disabled class="form-control pagination' + num + '" type="url" id="' + fieldName + '" name="' + fieldName + '" placeholder="Your Answer" style="background-color:white !important;color:black !important;"><i class="bar"></i>';
                } else {
                    textboxHtml += '<input disabled class="form-control pagination' + num + '" readonly type="url" value="' + fieldValue + '" id="' + fieldName + '" name="' + fieldName + '" placeholder="Your Answer" style="background-color:white !important;color:black !important;"><i class="bar"></i>';
                }
                textboxHtml += '</div></div>';
                $(stage).append(textboxHtml);
            }

            if (fieldTypeID == 2) {
                var textboxHtml = '<div class="col-md-12 divClass" id="div' + fieldName + '"><div class="form-group pagination-element' + num + '">';
                textboxHtml += '<label class="control-label ' + (requiredQuestion == 1 ? ' required' : '') + '">' + questionNum + ' . ' + fieldLabel + '</label>';
                if (fieldValue == null) {
                    textboxHtml += '<textarea disabled class="form-control pagination' + num + '" id="' + fieldName + '" name="' + fieldName + '" rows="2" cols="25" placeholder="Your Answer" style="background-color:white !important;color:black !important;"></textarea>';
                } else {
                    textboxHtml += '<textarea disabled class="form-control pagination' + num + '" id="' + fieldName + '" name="' + fieldName + '" rows="2" cols="25" readonly placeholder="Your Answer" style="background-color:white !important;color:black !important;">' + fieldValue + '</textarea>';
                }
                textboxHtml += '<i class="bar"></i>';
                textboxHtml += '</div></div>';
                $(stage).append(textboxHtml);
            }

            if (fieldTypeID == 3) {

                var response = fieldOptionsDB;
                var dropdownHtml = '<div class="col-md-12 divClass" id="div' + fieldName + '"><div class="form-group pagination-element' + num + '">';
                dropdownHtml += '<label class="control-label ' + (requiredQuestion == 1 ? ' required' : '') + '">' + questionNum + ' . ' + fieldLabel + '</label>';
                dropdownHtml += '<select disabled class="documentCategory pagination' + num + '" name="' + fieldName + '" id="' + fieldName + '" style="width: 50%;">';
                dropdownHtml += '<option value=""> Choose </option>';
                for (let index = 0; index < response.length; index++) {
                    const question_details_id = response[index]['question_details_id'];
                    const option_field_name = response[index]['option_for_question'];
                    if (question_details_id == fieldID)
                        if (fieldValue == option_field_name) {
                            var option = "<option value='" + option_field_name + "' selected>" + option_field_name + "</option>";
                        } else {
                            var option = "<option value='" + option_field_name + "'>" + option_field_name + "</option>";
                        }
                    dropdownHtml += option;
                }
                dropdownHtml += '</select><i class="bar" style="width: 50%;"></i></div></div>';
                $(stage).append(dropdownHtml);

            }

            if (fieldTypeID == 4) {

                var response = fieldOptionsDB;
                var currentOption = [];
                var currentOption2 = [];
                var radioButtonHtml = '<div class="col-md-12 divClass" id="div' + fieldName + '"><div class="form-radio pagination-element' + num + '">';
                radioButtonHtml += '<label class="control-label ' + (requiredQuestion == 1 ? ' required' : '') + '" style="margin-left: -30px;padding-bottom: 10px;">' + questionNum + ' . ' + fieldLabel + '</label><div class="radio">';
                for (let index2 = 0; index2 < response.length; index2++) {
                    const question_details_id2 = response[index2]['question_details_id'];
                    const option_field_name2 = response[index2]['option_for_question'];
                    if (question_details_id2 == fieldID) {
                        currentOption2.push(option_field_name2);
                    }
                } //console.log(currentOption2);
                for (let index = 0; index < response.length; index++) {
                    const question_details_id = response[index]['question_details_id'];
                    const option_field_name = response[index]['option_for_question'];
                    var option_question_fields_id = response[index]['option_question_fields_id'];
                    var other_flag = response[index]['other_flag'];
                    if (question_details_id == fieldID) {
                        currentOption.push(option_field_name);
                        var checkOther2 = currentOption2.includes(fieldValue);
                        if (fieldValue == option_field_name) {
                            radioButtonHtml += '<div class="radio">';
                            if (other_flag == 1) {
                                radioButtonHtml += '<label><input data-required="' + requiredQuestion + '" style="margin-right: 10px;" class="pagination' + num + ' Qradio" other-flag=' + other_flag + ' othersub="otherOption_' + option_question_fields_id + '" name="' + fieldName + '" type="radio"  id="' + fieldName + '" value="' + option_field_name + '" onclick="showInputSub(' + fieldName + ',' + option_question_fields_id + ')" checked><i class="helper"></i>' + option_field_name;
                                radioButtonHtml += '<input type="text" class="otherOption_' + option_question_fields_id + ' otherOption' + fieldName + '" ' + (checkOther2 == false ? ' value="' + fieldValue + '" style="opacity: 1;width: 589px;margin: -2px 0px 0px 80px;pointer-events:none !important;"' : 'value="" style="opacity: 1;display:none;width: 589px;margin: -2px 0px 0px 80px;"') + ' name="' + fieldName + '">';
                            } else {
                                radioButtonHtml += '<label><input data-required="' + requiredQuestion + '" style="margin-right: 10px;" class="pagination' + num + ' Qradio" type="radio" name="' + fieldName + '" id="' + fieldName + '" value="' + option_field_name + '" onclick="showInput(' + fieldName + ')" checked><i class="helper"></i>' + option_field_name;
                            }
                            radioButtonHtml += '</label></div>';
                        } else {
                            radioButtonHtml += '<div class="radio">';
                            if (other_flag == 1) {
                                radioButtonHtml += '<label><input data-required="' + requiredQuestion + '" style="margin-right: 10px;" class="pagination' + num + ' Qradio" other-flag=' + other_flag + ' othersub="otherOption_' + option_question_fields_id + '" name="' + fieldName + '" type="radio"  id="' + fieldName + '" value="' + option_field_name + '" onclick="showInputSub(' + fieldName + ',' + option_question_fields_id + ')" checked disabled><i class="helper"></i>' + option_field_name;
                                radioButtonHtml += '<input type="text" class="otherOption_' + option_question_fields_id + ' otherOption' + fieldName + '" ' + (checkOther2 == false ? ' value="' + fieldValue + '" style="opacity: 1;width: 589px;margin: -2px 0px 0px 80px;pointer-events:none !important;"' : 'value="" style="opacity: 1;display:none;width: 589px;margin: -2px 0px 0px 80px;" ') + ' name="' + fieldName + '">';
                            } else {
                                radioButtonHtml += '<label><input data-required="' + requiredQuestion + '" style="margin-right: 10px;" class="pagination' + num + ' Qradio" type="radio" name="' + fieldName + '" id="' + fieldName + '" value="' + option_field_name + '" onclick="showInput(' + fieldName + ')" disabled><i class="helper" style="opacity:0.1"></i>' + option_field_name;
                            }
                            radioButtonHtml += '</label></div>';
                        }
                    }

                }
                // 

                if (otherOption == 1) {
                    var checkOther = currentOption.includes(fieldValue);
                    var setcheckOther = !checkOther && fieldValue != null;

                    if (setcheckOther == true) {
                        radioButtonHtml += '<div class="radio">';
                        radioButtonHtml += '<label><input style="margin-right: 10px;" class="pagination' + num + ' Qradio" type="radio" name="' + fieldName + '" id="' + fieldName + '" value="Others" onclick="showInput(' + fieldName + ')" checked><i class="helper"></i> ' + (fieldID == '106' ? 'If yes, please mention the reason <br/>' : 'Others');
                        radioButtonHtml += '<input data-required="' + requiredQuestion + '" type="text" class="otherOption' + fieldName + '" value="' + fieldValue + '" ' + (fieldID == '106' ? 'style="opacity: 1;width: 589px;margin: -2px 0px 0px 30px;pointer-events:none !important;"' : 'style="opacity: 1;width: 589px;margin: -2px 0px 0px 80px;"') + ' name="' + fieldName + '">';
                        radioButtonHtml += '</label></div>';
                    } else {
                        radioButtonHtml += '<div class="radio">';
                        radioButtonHtml += '<label><input style="margin-right: 10px;" class="pagination' + num + ' Qradio" type="radio" name="' + fieldName + '" id="' + fieldName + '" value="Others" onclick="showInput(' + fieldName + ')" disabled><i class="helper" style="opacity:0.1"></i> Others';
                        radioButtonHtml += '<input disabled data-required="' + requiredQuestion + '" type="text" class="otherOption' + fieldName + '" ' + (fieldID == '106' ? 'style="opacity: 1;display:none;margin: -2px 0px 0px 30px;width: 589px;pointer-events:none !important;"' : 'style="opacity: 1;display:none;margin: -2px 0px 0px 80px;width: 589px;"') + ' name="' + fieldName + '">';
                        radioButtonHtml += '</label></div>';
                    }
                }
                // console.log(currentOption);
                // 
                radioButtonHtml += '</div></div>';
                $(stage).append(radioButtonHtml);
            }
            // if (fieldTypeID == 5) {
            //     var response = fieldOptionsDB;
            //     var obj;
            //     if (fieldValue != null || fieldValue != undefined) {
            //         obj = JSON.parse(fieldValue);
            //     }
            //     if (obj != null) {
            //         var cou = obj.length;
            //     }
            //     var radioButtonHtml = '<div class="col-md-12 divClass" id="div' + fieldName + '"><div class="form-group pagination-element' + num + '">';
            //     radioButtonHtml += '<label class="control-label">' + questionNum + ' . ' + fieldLabel + '</label><div class="checkbox">';
            //     for (let index = 0; index < response.length; index++) {
            //         const question_details_id = response[index]['question_details_id'];
            //         const option_field_name = response[index]['option_for_question'];
            //         console.log(option_field_name);
            //         if (question_details_id == fieldID){
            //             if (obj != null) {
            //                 for (let j = 0; j < obj.length; j++) {
            //                     var che = obj[j];
            //                     console.log(che);
            //                     if (che == option_field_name) {
            //                         radioButtonHtml += '<label><input class="pagination' + num + '" type="checkbox" name="' + fieldName + '[]" id="' + fieldName + '" value="' + option_field_name + '" checked><i class="helper"></i>' + option_field_name + '</label>';
            //                         break;
            //                     } else {
            //                         radioButtonHtml += '<label><input class="pagination' + num + '" type="checkbox" name="' + fieldName + '[]" id="' + fieldName + '" value="' + option_field_name + '"><i class="helper"></i>' + option_field_name + '</label>';
            //                         break;
            //                     }
            //                 }
            //             } else {
            //                 radioButtonHtml += '<label><input class="pagination' + num + '" type="checkbox" name="' + fieldName + '[]" id="' + fieldName + '" value="' + option_field_name + '"><i class="helper"></i>' + option_field_name + '</label>';
            //             }
            //         }
            //     }
            //     radioButtonHtml += '</div></div>';
            //     $(stage).append(radioButtonHtml);
            // }
            if (fieldTypeID === 5) {
                var currentOption = [];
                var response = fieldOptionsDB;
                var obj = JSON.parse(fieldValue || null);
                var radioButtonHtml = `<div class="col-md-12 divClass" id="div${fieldName}"><div class="form-group pagination-element${num}">`;
                radioButtonHtml += `<label class="control-label ` + (requiredQuestion == 1 ? ' required' : '') + `">${questionNum}. ${fieldLabel}</label><div class="checkbox">`;

                for (let index = 0; index < response.length; index++) {
                    const question_details_id = response[index]['question_details_id'];
                    const option_field_name = response[index]['option_for_question'];

                    if (question_details_id == fieldID) {
                        currentOption.push(option_field_name);
                        if (obj != null) {
                            if (obj.includes(option_field_name)) {
                                radioButtonHtml += `<label><input onclick="return false" class="pagination${num}" type="checkbox" name="${fieldName}[]" id="${fieldName}" value="${option_field_name}" checked><i class="helper"></i>${option_field_name}</label>`;
                            } else {
                                radioButtonHtml += `<label><input class="pagination${num}" type="checkbox" name="${fieldName}[]" id="${fieldName}" value="${option_field_name}" onclick="return false"><i class="helper" style="opacity: 0.1;"></i>${option_field_name}</label>`;
                            }
                        } else {
                            radioButtonHtml += `<label><input onclick="return false" class="pagination${num}" type="checkbox" name="${fieldName}[]" id="${fieldName}" value="${option_field_name}"><i class="helper" style="opacity: 0.1;"></i>${option_field_name}</label>`;
                        }
                    }
                }
                if (otherOption == 1) {
                    let setcheckOther = false;
                    var missingValues = '';
                    for (var i = 0; i < obj.length; i++) {
                        if (!currentOption.includes(obj[i])) {
                            setcheckOther = true;
                            missingValues = obj[i];
                            break;
                        }
                    }
                    if (setcheckOther == true) {
                        radioButtonHtml += '<label><input onclick="return false" class="pagination' + num + ' otherOption' + fieldName + '" type="checkbox" id="' + fieldName + '" onclick="showInputOthers(' + fieldName + ')" checked><i class="helper"></i>Others';
                        radioButtonHtml += '<input type="text" disabled class="otherField' + fieldName + '" value="' + missingValues + '" style="display:inline;opacity: 1;border: 1px solid;pointer-events:none !important;" name="' + fieldName + '[]"></label>';
                    } else {
                        radioButtonHtml += '<label><input onclick="return false" class="pagination' + num + ' otherOption' + fieldName + '" type="checkbox" id="' + fieldName + '" onclick="showInputOthers(' + fieldName + ')"><i class="helper" style="opacity: 0.1;"></i>Others';
                        radioButtonHtml += '<input disabled type="text" class="otherField' + fieldName + '" style="opacity: 1;display:none;border: 1px solid;pointer-events:none !important;" name="' + fieldName + '[]"></label>';
                    }
                }
                radioButtonHtml += `</div></div>`;
                $(stage).append(radioButtonHtml);
            }
            if (fieldTypeID == 7) {
                var response = fieldQuestionsDB;
                var fieldOptions = response.fieldOptions;
                var fieldQuestions = response.fieldQuestions;
                var radioButtonHtml = '<div class="col-md-12 divClass multi-question" id="div' + fieldName + '"><div class="form-group pagination-element' + num + '">';
                radioButtonHtml += '<label class="control-label ' + (requiredQuestion == 1 ? ' required' : '') + '">' + questionNum + ' . ' + fieldLabel + '</label><br>'; //Sub Question Radio
                radioButtonHtml += '<table class="table_content" style="border: 1px solid black !important;overflow:scroll !important;">';
                radioButtonHtml += '<tr style="border: 1px solid black !important;">';
                radioButtonHtml += '<th class="stickTd" width="30%" style="border: 1px solid black !important;"></th>';
                for (let index = 0; index < fieldOptions.length; index++) {
                    const question_details_id = fieldOptions[index]['question_details_id'];
                    const option_field_name = fieldOptions[index]['option_for_question'];
                    if (question_details_id == fieldID)
                        // radioButtonHtml += '<label class="control-label q_lable">' + option_field_name + '</label>';
                        radioButtonHtml += '<th style="border: 1px solid black !important;">' + option_field_name + '</th>';
                }
                radioButtonHtml += '</tr>';

                for (let i = 0; i < fieldQuestions.length; i++) {
                    const sub_questions_id = fieldQuestions[i]['sub_questions_id'];
                    const sub_question = fieldQuestions[i]['sub_question'];
                    const question_details_id = fieldQuestions[i]['question_details_id'];
                    const optionValue = fieldName + sub_questions_id; //alert(optionValue);
                    const questionValue = DataFields[checkindex][optionValue]; //alert(questionValue);//alert(checkindex);
                    // radioButtonHtml += '<div>'
                    if (question_details_id == fieldID) {
                        radioButtonHtml += '<tr style="border: 1px solid black !important;">';
                        radioButtonHtml += '<td class="stickTd" style="border: 1px solid black !important;">' + sub_question + '</td>';
                        for (let index = 0; index < fieldOptions.length; index++) {
                            const question_details_id = fieldOptions[index]['question_details_id'];
                            const option_field_name = fieldOptions[index]['option_for_question'];
                            if (question_details_id == fieldID)
                                if (questionValue == option_field_name) {
                                    // alert('asd');
                                    radioButtonHtml += '<td style="border: 1px solid black !important;"><input style="height: 15px;" class="pagination' + num + ' QSub" type="radio" name="' + fieldName + sub_questions_id + '" id="' + fieldName + '" value="' + option_field_name + '" checked></td>';
                                } else {
                                    radioButtonHtml += '<td style="border: 1px solid black !important;"><input style="height: 15px;" class="pagination' + num + ' QSub" type="radio" name="' + fieldName + sub_questions_id + '" id="' + fieldName + '" value="' + option_field_name + '" disabled></td>';
                                }
                            // radioButtonHtml += '<td><input class="pagination' + num + '" type="radio" name="' + fieldName + sub_questions_id + '" id="' + fieldName + '" value="' + option_field_name + '"></td>';
                        }
                        radioButtonHtml += '</tr>'
                    }
                }
                radioButtonHtml += '</table>';
                $(stage).append(radioButtonHtml);
            }
            if (fieldTypeID == 9) {
                var stageCo = stageQuestionCount + addon;
                const isMultipleOf5 = stageCo => typeof stageCo === 'number' && stageCo % 5 === 0;
                if (isMultipleOf5(stageCo)) {
                    var c = index + 1;
                    const isEnd = tab_content.includes(c);
                    if (isEnd == true) {
                        var cNum = num + 1;
                        stage = step.concat(cNum);
                        addon++;
                    } else {
                        var cNum = num;
                    }
                    var radioButtonHtmlSkip = '<div class="col-md-12 pagination-element' + cNum + '" style="background-color: rgb(218, 178, 55);font-weight: 900;font-size: 20px;"></div>';
                    $(stage).append(radioButtonHtmlSkip);
                }

                var response = fieldOptionsDB;
                var radioButtonHtml = '<div class="col-md-12 pagination-element' + num + '" style="background-color: rgb(218, 178, 55);font-weight: 900;font-size: 20px;">';
                radioButtonHtml += '<label class="control-label">' + fieldLabel + '</label><br>';

                for (let index = 0; index < response.length; index++) {
                    var question_details_id = response[index]['question_details_id'];
                    var option_field_name = response[index]['option_for_question'];
                    if (question_details_id == fieldID) {
                        if (option_field_name != null)
                            radioButtonHtml += '<label>' + option_field_name + '</label>';
                    }
                }
                radioButtonHtml += '</div>';
                $(stage).append(radioButtonHtml);

            }

            if (fieldTypeID == 12) {
                var response = fieldQuestionsDB;
                var fieldOptions = response.fieldOptions;
                var fieldQuestions = response.fieldQuestions;
                var radioButtonHtml = '<div class="col-md-12 divClass multi-question" id="div' + fieldName + '"><div class="form-group pagination-element' + num + '">';
                radioButtonHtml += '<label class="control-label ' + (requiredQuestion == 1 ? ' required' : '') + '">' + questionNum + ' . ' + fieldLabel + '</label><br>'; //Sub Question Radio
                radioButtonHtml += '<table class="table_content" style="border: 1px solid black !important;">';
                radioButtonHtml += '<tr style="border: 1px solid black !important;">';
                radioButtonHtml += '<th class="stickTd" width="30%" style="border: 1px solid black !important;"></th>';
                for (let index = 0; index < fieldOptions.length; index++) {
                    const question_details_id = fieldOptions[index]['question_details_id'];
                    const option_field_name = fieldOptions[index]['option_for_question'];
                    if (question_details_id == fieldID)
                        // radioButtonHtml += '<label class="control-label q_lable">' + option_field_name + '</label>';
                        radioButtonHtml += '<th style="border: 1px solid black !important;">' + option_field_name + '</th>';
                }
                radioButtonHtml += '</tr>';

                for (let i = 0; i < fieldQuestions.length; i++) {
                    const sub_questions_id = fieldQuestions[i]['sub_questions_id'];
                    const sub_question = fieldQuestions[i]['sub_question'];
                    const question_details_id = fieldQuestions[i]['question_details_id'];
                    const optionValue = fieldName + sub_questions_id; //alert(optionValue);
                    const questionValue = DataFields[checkindex][optionValue];
                    var obj = JSON.parse(questionValue || null);
                    if (question_details_id == fieldID) {
                        radioButtonHtml += '<tr style="border: 1px solid black !important;">';
                        radioButtonHtml += '<td  class="stickTd" style="border: 1px solid black !important;">' + sub_question + '</td>';
                        for (let index = 0; index < fieldOptions.length; index++) {
                            const question_details_id = fieldOptions[index]['question_details_id'];
                            const option_field_name = fieldOptions[index]['option_for_question'];
                            if (question_details_id == fieldID) {
                                if (obj != null) {
                                    if (obj.includes(option_field_name)) {
                                        radioButtonHtml += '<td style="border: 1px solid black !important;"><input onclick="return false" data-required="' + requiredQuestion + '" style="height: 15px;" class="pagination' + num + ' QSub" type="checkbox" name="' + fieldName + sub_questions_id + '[]" id="' + fieldName + '" value="' + option_field_name + '" checked></td>';
                                    } else {
                                        radioButtonHtml += '<td style="border: 1px solid black !important;"><input onclick="return false" data-required="' + requiredQuestion + '" style="height: 15px;" class="pagination' + num + ' QSub" type="checkbox" name="' + fieldName + sub_questions_id + '[]" id="' + fieldName + '" value="' + option_field_name + '"></td>';
                                    }
                                } else {
                                    radioButtonHtml += '<td style="border: 1px solid black !important;"><input onclick="return false" data-required="' + requiredQuestion + '" style="height: 15px;" class="pagination' + num + ' QSub" type="checkbox" name="' + fieldName + sub_questions_id + '[]" id="' + fieldName + '" value="' + option_field_name + '"></td>';
                                }
                            }
                            // if (questionValue == option_field_name) {
                            //     radioButtonHtml += '<td><input style="height: 15px;" class="pagination' + num + ' QSub" type="checkbox" name="' + fieldName + sub_questions_id + '" id="' + fieldName + '" value="' + option_field_name + '" checked></td>';
                            // } else {
                            //     radioButtonHtml += '<td><input style="height: 15px;" class="pagination' + num + ' QSub" type="checkbox" name="' + fieldName + sub_questions_id + '" id="' + fieldName + '" value="' + option_field_name + '"></td>';
                            // }
                            // radioButtonHtml += '<td><input class="pagination' + num + '" type="radio" name="' + fieldName + sub_questions_id + '" id="' + fieldName + '" value="' + option_field_name + '"></td>';
                        }
                        radioButtonHtml += '</tr>'
                    }
                }
                radioButtonHtml += '</table>';
                $(stage).append(radioButtonHtml);
            }
        }
    }
</script>
<script>
    function NextTab() {
        var tabIDs = $('.tablinks.active').attr('id');
        var ret1 = tabIDs.replace('Tab', '');
        var i, tabcontent, tablinks;
        tabcontent = document.getElementsByClassName("tabcontent");
        for (i = 0; i < tabcontent.length; i++) {
            tabcontent[i].style.display = "none";
        }
        tablinks = document.getElementsByClassName("tablinks");
        for (i = 0; i < tablinks.length; i++) {
            tablinks[i].className = tablinks[i].className.replace(" active", "");
        }
        nexttabID = Number(ret1) + 1;
        var cityName1 = 'Step'.concat(nexttabID);
        var tabName1 = 'Tab'.concat(nexttabID);
        document.getElementById(cityName1).style.display = "block";
        document.getElementById(tabName1).classList.add('active');
        $('html,body').animate({
            scrollTop: $(".scroll-break-div").offset().top
        }, 'slow');
        if (nexttabID == divCount) {
            $('#Previous').show();
            $('#Next').hide();
        } else {
            $('#Previous').show();
            $('#Next').show();
        }
        nextStep(nexttabID, ret1);
        currentPagination(nexttabID);

    }

    function NextTab1(stepNum) {
        var tabIDs = $('.tablinks.active').attr('id');
        var ret1 = tabIDs.replace('Tab', '');
        var i, tabcontent, tablinks;
        tabcontent = document.getElementsByClassName("tabcontent");
        for (i = 0; i < tabcontent.length; i++) {
            tabcontent[i].style.display = "none";
        }
        tablinks = document.getElementsByClassName("tablinks");
        for (i = 0; i < tablinks.length; i++) {
            tablinks[i].className = tablinks[i].className.replace(" active", "");
        }
        nexttabID = stepNum;
        var cityName1 = 'Step'.concat(nexttabID);
        var tabName1 = 'Tab'.concat(nexttabID);
        document.getElementById(cityName1).style.display = "block";
        document.getElementById(tabName1).classList.add('active');
        $('html,body').animate({
            scrollTop: $(".scroll-break-div").offset().top
        }, 'slow');
        if (nexttabID == divCount) {
            $('#Previous').show();
            $('#Next').hide();
        } else {
            $('#Previous').show();
            $('#Next').show();
        }
        nextStep(nexttabID, ret1);
        currentPagination(nexttabID);

    }

    function PrevTab() {
        var tabIDs = $('.tablinks.active').attr('id');
        var ret1 = tabIDs.replace('Tab', '');
        var i, tabcontent, tablinks;
        tabcontent = document.getElementsByClassName("tabcontent");
        for (i = 0; i < tabcontent.length; i++) {
            tabcontent[i].style.display = "none";
        }
        tablinks = document.getElementsByClassName("tablinks");
        for (i = 0; i < tablinks.length; i++) {
            tablinks[i].className = tablinks[i].className.replace(" active", "");
        }
        nexttabID = Number(ret1) - 1;
        var cityName1 = 'Step'.concat(nexttabID);
        var tabName1 = 'Tab'.concat(nexttabID);
        document.getElementById(cityName1).style.display = "block";
        document.getElementById(tabName1).classList.add('active');
        $('html,body').animate({
            scrollTop: $(".scroll-break-div").offset().top
        }, 'slow');
        if (nexttabID == 1) {
            $('#Previous').hide();
            $('#Next').show();
        } else {
            $('#Previous').show();
            $('#Next').show();
        }
        nextStep(nexttabID, ret1);
        currentPagination(nexttabID);
    }

    function PrevTab1(stepNum) {
        var tabIDs = $('.tablinks.active').attr('id');
        var ret1 = tabIDs.replace('Tab', '');
        var i, tabcontent, tablinks;
        tabcontent = document.getElementsByClassName("tabcontent");
        for (i = 0; i < tabcontent.length; i++) {
            tabcontent[i].style.display = "none";
        }
        tablinks = document.getElementsByClassName("tablinks");
        for (i = 0; i < tablinks.length; i++) {
            tablinks[i].className = tablinks[i].className.replace(" active", "");
        }
        nexttabID = stepNum;
        var cityName1 = 'Step'.concat(nexttabID);
        var tabName1 = 'Tab'.concat(nexttabID);
        document.getElementById(cityName1).style.display = "block";
        document.getElementById(tabName1).classList.add('active');
        $('html,body').animate({
            scrollTop: $(".scroll-break-div").offset().top
        }, 'slow');
        if (nexttabID == 1) {
            $('#Previous').hide();
            $('#Next').show();
        } else {
            $('#Previous').show();
            $('#Next').show();
        }
        nextStep(nexttabID, ret1);
        currentPagination(nexttabID);
    }
</script>
<script>
    var currentStep = 1;
    // var numSteps = divCount;

    function nextStep(stepNum, ret) {

        // alert(stepNum);
        // alert(ret);
        var numSteps = divCount;
        currentStep = stepNum;
        currentStep++;
        // var presentSten = ret - 1;
        // if (presentSten == 0) {
        //     presentSten = 1;
        // }

        var presentSten = ret;

        divClass = document.getElementsByClassName("divClass");
        for (i = 0; i < divClass.length; i++) {
            divClass[i].className = divClass[i].className.replace(" incomp", "");
        }

        $('.pagination' + presentSten + '').each(function(i, el) {
            var type = $(el).attr('type'); //alert(type);
            var name = $(el).attr('name'); //alert(name);
            var tag = $(el).prop("tagName"); //alert(tag);
            var data = $(el).val();
            var idd = $(el).attr('id'); //alert(idd);

            var divErrorID = 'div'.concat(idd); //alert(divErrorID);


            var subcat, getSelectedValue, checkbox;
            if (type == 'radio') {
                var getSelectedValue = document.querySelector("input[name=" + name + "]:checked");
            }
            if (type == 'checkbox') {
                var checkbox = document.querySelector('input[name="' + name + '"]:checked');
            }
            if (tag == 'SELECT') {
                var subcat = document.getElementById(name);
            }

            if (type == 'text' || tag == 'TEXTAREA') {
                if (data == '' || data == null || data == undefined) {
                    document.getElementById(divErrorID).classList.add('incomp');
                }
            } else if (type == 'radio') {
                if (getSelectedValue == null) {
                    var element = document.getElementById(divErrorID);
                    element.classList.add("incomp");
                }
            } else if (type == 'checkbox') {
                if (checkbox == null) {
                    document.getElementById(divErrorID).classList.add('incomp');
                }
            } else if (type == undefined && tag == 'SELECT') {
                if (subcat.value == null || subcat.value == "") {
                    document.getElementById(divErrorID).classList.add('incomp');
                }
            }
        });

        var incomp = $(".incomp").length;
        if (incomp == 0) {
            var StepperID = 'Stepper' + presentSten + 'ID';
            document.getElementById(StepperID).classList.add('done');

            editingStep1 = document.getElementsByClassName("step");
            for (i = 0; i < editingStep1.length; i++) {
                editingStep1[i].className = editingStep1[i].className.replace(" editing", "");
            }

            var StepperEditID = 'Stepper' + stepNum + 'ID';
            document.getElementById(StepperEditID).classList.add('editing');
        } else {
            var i, tabcontent, tablinks;
            var cityName = 'Step'.concat(stepNum);
            var tabName = 'Tab'.concat(stepNum);
            tabcontent = document.getElementsByClassName("tabcontent");
            for (i = 0; i < tabcontent.length; i++) {
                tabcontent[i].style.display = "none";
            }
            tablinks = document.getElementsByClassName("tablinks");
            for (i = 0; i < tablinks.length; i++) {
                tablinks[i].className = tablinks[i].className.replace(" active", "");
            }
            document.getElementById(cityName).style.display = "block";
            document.getElementById(tabName).classList.add('active');

            editingStep = document.getElementsByClassName("step");
            for (i = 0; i < editingStep.length; i++) {
                editingStep[i].className = editingStep[i].className.replace(" editing", "");
            }

            var StepperEditID = 'Stepper' + stepNum + 'ID'; //alert(StepperEditID);
            document.getElementById(StepperEditID).classList.add('editing');

            var stepperIDEdit = 'Stepper' + presentSten + 'ID';
            // alert(stepperIDEdit);
            document.getElementById(stepperIDEdit).classList.remove('done');
        }

    }


    /* get, set class, see https://ultimatecourses.com/blog/javascript-hasclass-addclass-removeclass-toggleclass */

    function hasClass(elem, className) {
        return new RegExp(' ' + className + ' ').test(' ' + elem.className + ' ');
    }

    function addClass(elem, className) {
        if (!hasClass(elem, className)) {
            elem.className += ' ' + className;
        }
    }

    function removeClass(elem, className) {
        var newClass = ' ' + elem.className.replace(/[\t\r\n]/g, ' ') + ' ';
        if (hasClass(elem, className)) {
            while (newClass.indexOf(' ' + className + ' ') >= 0) {
                newClass = newClass.replace(' ' + className + ' ', ' ');
            }
            elem.className = newClass.replace(/^\s+|\s+$/g, '');
        }
    }

    function nextStepCheck(stepNum) {
        var i, tabcontent, tablinks;
        var cityName = 'Step'.concat(stepNum);
        var tabName = 'Tab'.concat(stepNum);
        tabcontent = document.getElementsByClassName("tabcontent");
        for (i = 0; i < tabcontent.length; i++) {
            tabcontent[i].style.display = "none";
        }
        tablinks = document.getElementsByClassName("tablinks");
        for (i = 0; i < tablinks.length; i++) {
            tablinks[i].className = tablinks[i].className.replace(" active", "");
        }
        document.getElementById(cityName).style.display = "block";
        document.getElementById(tabName).classList.add('active');

        editingStep = document.getElementsByClassName("step");
        for (i = 0; i < editingStep.length; i++) {
            editingStep[i].className = editingStep[i].className.replace(" editing", "");
        }

        var StepperEditID = 'Stepper' + stepNum + 'ID'; //alert(StepperEditID);
        document.getElementById(StepperEditID).classList.add('editing');

        return false;
    }
</script>
<style>
    .pagination1 {
        padding: 20px;
        display: flex;
        justify-content: center;
    }

    .pagination1,
    .pagination1 * {
        -webkit-user-select: none;
        -moz-user-select: none;
        -ms-user-select: none;
        user-select: none;
    }

    .pagination1 a {
        display: inline-block;
        padding: 0 10px;
        cursor: pointer;
    }

    .pagination1 a.disabled {
        opacity: 0.3;
        pointer-events: none;
        cursor: not-allowed;
    }

    .pagination1 a.current {
        background: #f3f3f3;
    }

    .pagination2 {
        padding: 20px;
        display: flex;
        justify-content: center;
    }

    .pagination2,
    .pagination2 * {
        -webkit-user-select: none;
        -moz-user-select: none;
        -ms-user-select: none;
        user-select: none;
    }

    .pagination2 a {
        display: inline-block;
        padding: 0 10px;
        cursor: pointer;
    }

    .pagination2 a.disabled {
        opacity: 0.3;
        pointer-events: none;
        cursor: not-allowed;
    }

    .pagination2 a.current {
        background: #f3f3f3;
    }

    .pagination3 {
        padding: 20px;
        display: flex;
        justify-content: center;
    }

    .pagination3,
    .pagination3 * {
        -webkit-user-select: none;
        -moz-user-select: none;
        -ms-user-select: none;
        user-select: none;
    }

    .pagination3 a {
        display: inline-block;
        padding: 0 10px;
        cursor: pointer;
    }

    .pagination3 a.disabled {
        opacity: 0.3;
        pointer-events: none;
        cursor: not-allowed;
    }

    .pagination3 a.current {
        background: #f3f3f3;
    }

    .pagination4 {
        padding: 20px;
        display: flex;
        justify-content: center;
    }

    .pagination4,
    .pagination4 * {
        -webkit-user-select: none;
        -moz-user-select: none;
        -ms-user-select: none;
        user-select: none;
    }

    .pagination4 a {
        display: inline-block;
        padding: 0 10px;
        cursor: pointer;
    }

    .pagination4 a.disabled {
        opacity: 0.3;
        pointer-events: none;
        cursor: not-allowed;
    }

    .pagination4 a.current {
        background: #f3f3f3;
    }

    .pagination1 a.current {
        border-radius: 4px;
        background-color: #16425b;
    }

    .pagination1 a.current:hover {
        background-color: #16425b;
    }

    .pagination1 a.current {
        color: #f3f4f2;
    }

    .pagination2 a.current {
        border-radius: 4px;
        background-color: #16425b;
    }

    .pagination2 a.current:hover {
        background-color: #16425b;
    }

    .pagination2 a.current {
        color: #f3f4f2;
    }

    .pagination3 a.current {
        border-radius: 4px;
        background-color: #16425b;
    }

    .pagination3 a.current:hover {
        background-color: #16425b;
    }

    .pagination3 a.current {
        color: #f3f4f2;
    }

    .pagination4 a.current {
        border-radius: 4px;
        background-color: #16425b;
    }

    .pagination4 a.current:hover {
        background-color: #16425b;
    }

    .pagination4 a.current {
        color: #f3f4f2;
    }
</style>
<script>
    function pagi_nation(ffff) {

        // $('#pageDiv').html('');

        if (ffff = 1) {
            var pagify = {
                items: {},
                container: null,
                totalPages: 1,
                perPage: 3,
                currentPage: 0,
                createNavigation: function() {
                    this.totalPages = Math.ceil(this.items.length / this.perPage);

                    $('.pagination', this.container.parent()).remove();
                    var pagination1 = $('<div class="pagination1" id="pageDiv1"></div>');
                    // var pagination1 = $('<div class="pagination1" id="pageDiv1"></div>').append('<a class="nav prev disabled" data-next="false"><</a>');

                    for (var i = 0; i < this.totalPages; i++) {
                        var pageElClass = "page1";
                        if (!i)
                            pageElClass = "page1 current";
                        var pageEl = '<a class="' + pageElClass + '" data-page1="' + (
                            i + 1) + '">' + (
                            i + 1) + "</a>";
                        pagination1.append(pageEl);
                    }
                    // pagination1.append('<a class="nav next" data-next="true">></a>');

                    this.container.after(pagination1);

                    var that = this;
                    $("body").off("click", ".nav");
                    this.navigator = $("body").on("click", ".nav", function() {
                        var el = $(this);
                        that.navigate(el.data("next"));
                    });

                    $("body").off("click", ".page1");
                    this.pageNavigator = $("body").on("click touchstart", ".page1", function() {
                        var el = $(this);
                        that.goToPage(el.data("page1"));
                    });
                },
                navigate: function(next) {
                    // default perPage to 5
                    if (isNaN(next) || next === undefined) {
                        next = true;
                    }
                    $(".pagination1 .nav").removeClass("disabled");
                    if (next) {
                        this.currentPage++;
                        if (this.currentPage > (this.totalPages - 1))
                            this.currentPage = (this.totalPages - 1);
                        if (this.currentPage == (this.totalPages - 1))
                            $(".pagination1 .nav.next").addClass("disabled");
                    } else {
                        this.currentPage--;
                        if (this.currentPage < 0)
                            this.currentPage = 0;
                        if (this.currentPage == 0)
                            $(".pagination1 .nav.prev").addClass("disabled");
                    }

                    this.showItems();
                },
                updateNavigation: function() {

                    var pages = $(".pagination1 .page1");
                    pages.removeClass("current");
                    $('.pagination1 .page1[data-page1="' + (
                        this.currentPage + 1) + '"]').addClass("current");
                    $('html,body').animate({
                        scrollTop: $(".scroll-break-div").offset().top
                    }, 'slow');
                },
                goToPage: function(page1) {

                    this.currentPage = page1 - 1;

                    $(".pagination1 .nav").removeClass("disabled");
                    if (this.currentPage == (this.totalPages - 1))
                        $(".pagination1 .nav.next").addClass("disabled");

                    if (this.currentPage == 0)
                        $(".pagination1 .nav.prev").addClass("disabled");
                    this.showItems();
                },
                showItems: function() {
                    this.items.hide();
                    var base = this.perPage * this.currentPage;
                    this.items.slice(base, base + this.perPage).show();

                    this.updateNavigation();
                },
                init: function(container, items, perPage) {
                    this.container = container;
                    this.currentPage = 0;
                    this.totalPages = 1;
                    this.perPage = perPage;
                    this.items = items;
                    this.createNavigation();
                    this.showItems();
                }
            };

            // stuff it all into a jQuery method!
            $.fn.pagify = function(perPage, itemSelector, cPage) {
                var el = $(this);
                var items = $(itemSelector, el);

                // default perPage to 5
                if (isNaN(perPage) || perPage === undefined) {
                    perPage = 3;
                }

                // don't fire if fewer items than perPage
                if (items.length <= perPage) {
                    return true;
                }

                pagify.init(el, items, perPage);
            };


            $('#pageDiv2').hide();
            $('#pageDiv3').hide();
            $('#pageDiv4').hide();


            $(".pagination_one").pagify(5, ".pagination-element1", 1);
        }
        if (ffff = 2) {
            var pagify = {
                items: {},
                container: null,
                totalPages: 1,
                perPage: 3,
                currentPage: 0,
                createNavigation: function() {
                    this.totalPages = Math.ceil(this.items.length / this.perPage);

                    $('.pagination', this.container.parent()).remove();
                    var pagination2 = $('<div class="pagination2" id="pageDiv2"></div>');

                    for (var i = 0; i < this.totalPages; i++) {
                        var pageElClass = "page2";
                        if (!i)
                            pageElClass = "page2 current";
                        var pageEl = '<a class="' + pageElClass + '" data-page2="' + (
                            i + 1) + '">' + (
                            i + 1) + "</a>";
                        pagination2.append(pageEl);
                    }
                    // pagination2.append('<a class="nav next" data-next="true">></a>');

                    this.container.after(pagination2);

                    var that = this;
                    $("body").off("click", ".nav");
                    this.navigator = $("body").on("click", ".nav", function() {
                        var el = $(this);
                        that.navigate(el.data("next"));
                    });

                    $("body").off("click", ".page2");
                    this.pageNavigator = $("body").on("click touchstart", ".page2", function() {
                        var el = $(this);
                        that.goToPage(el.data("page2"));
                    });
                },
                navigate: function(next) {
                    // default perPage to 5
                    if (isNaN(next) || next === undefined) {
                        next = true;
                    }
                    $(".pagination2 .nav").removeClass("disabled");
                    if (next) {
                        this.currentPage++;
                        if (this.currentPage > (this.totalPages - 1))
                            this.currentPage = (this.totalPages - 1);
                        if (this.currentPage == (this.totalPages - 1))
                            $(".pagination2 .nav.next").addClass("disabled");
                    } else {
                        this.currentPage--;
                        if (this.currentPage < 0)
                            this.currentPage = 0;
                        if (this.currentPage == 0)
                            $(".pagination2 .nav.prev").addClass("disabled");
                    }

                    this.showItems();
                },
                updateNavigation: function() {

                    var pages = $(".pagination2 .page2");
                    pages.removeClass("current");
                    $('.pagination2 .page2[data-page2="' + (
                        this.currentPage + 1) + '"]').addClass("current");
                    $('html,body').animate({
                        scrollTop: $(".scroll-break-div").offset().top
                    }, 'slow');
                },
                goToPage: function(page2) {

                    this.currentPage = page2 - 1;

                    $(".pagination2 .nav").removeClass("disabled");
                    if (this.currentPage == (this.totalPages - 1))
                        $(".pagination2 .nav.next").addClass("disabled");

                    if (this.currentPage == 0)
                        $(".pagination2 .nav.prev").addClass("disabled");
                    this.showItems();
                },
                showItems: function() {
                    this.items.hide();
                    var base = this.perPage * this.currentPage;
                    this.items.slice(base, base + this.perPage).show();

                    this.updateNavigation();
                },
                init: function(container, items, perPage) {
                    this.container = container;
                    this.currentPage = 0;
                    this.totalPages = 1;
                    this.perPage = perPage;
                    this.items = items;
                    this.createNavigation();
                    this.showItems();
                }
            };

            // stuff it all into a jQuery method!
            $.fn.pagify = function(perPage, itemSelector, cPage) {
                var el = $(this);
                var items = $(itemSelector, el);

                // default perPage to 5
                if (isNaN(perPage) || perPage === undefined) {
                    perPage = 3;
                }

                // don't fire if fewer items than perPage
                if (items.length <= perPage) {
                    return true;
                }

                pagify.init(el, items, perPage);
            };
            $('#pageDiv1').hide();
            $('#pageDiv4').hide();
            $('#pageDiv3').hide();

            $(".pagination_two").pagify(5, ".pagination-element2", 2);
        }
        if (ffff = 3) {
            var pagify = {
                items: {},
                container: null,
                totalPages: 1,
                perPage: 3,
                currentPage: 0,
                createNavigation: function() {
                    this.totalPages = Math.ceil(this.items.length / this.perPage);

                    $('.pagination', this.container.parent()).remove();
                    var pagination3 = $('<div class="pagination3" id="pageDiv3"></div>');
                    // var pagination3 = $('<div class="pagination3" id="pageDiv3"></div>').append('<a class="nav prev disabled" data-next="false"><</a>');

                    for (var i = 0; i < this.totalPages; i++) {
                        var pageElClass = "page3";
                        if (!i)
                            pageElClass = "page3 current";
                        var pageEl = '<a class="' + pageElClass + '" data-page3="' + (
                            i + 1) + '">' + (
                            i + 1) + "</a>";
                        pagination3.append(pageEl);
                    }
                    // pagination3.append('<a class="nav next" data-next="true">></a>');

                    this.container.after(pagination3);

                    var that = this;
                    $("body").off("click", ".nav");
                    this.navigator = $("body").on("click", ".nav", function() {
                        var el = $(this);
                        that.navigate(el.data("next"));
                    });

                    $("body").off("click", ".page3");
                    this.pageNavigator = $("body").on("click touchstart", ".page3", function() {
                        var el = $(this);
                        that.goToPage(el.data("page3"));
                    });
                },
                navigate: function(next) {
                    // default perPage to 5
                    if (isNaN(next) || next === undefined) {
                        next = true;
                    }
                    $(".pagination3 .nav").removeClass("disabled");
                    if (next) {
                        this.currentPage++;
                        if (this.currentPage > (this.totalPages - 1))
                            this.currentPage = (this.totalPages - 1);
                        if (this.currentPage == (this.totalPages - 1))
                            $(".pagination3 .nav.next").addClass("disabled");
                    } else {
                        this.currentPage--;
                        if (this.currentPage < 0)
                            this.currentPage = 0;
                        if (this.currentPage == 0)
                            $(".pagination3 .nav.prev").addClass("disabled");
                    }

                    this.showItems();
                },
                updateNavigation: function() {

                    var pages = $(".pagination3 .page3");
                    pages.removeClass("current");
                    $('.pagination3 .page3[data-page3="' + (
                        this.currentPage + 1) + '"]').addClass("current");
                    $('html,body').animate({
                        scrollTop: $(".scroll-break-div").offset().top
                    }, 'slow');
                },
                goToPage: function(page3) {

                    this.currentPage = page3 - 1;

                    $(".pagination3 .nav").removeClass("disabled");
                    if (this.currentPage == (this.totalPages - 1))
                        $(".pagination3 .nav.next").addClass("disabled");

                    if (this.currentPage == 0)
                        $(".pagination3 .nav.prev").addClass("disabled");
                    this.showItems();
                },
                showItems: function() {
                    this.items.hide();
                    var base = this.perPage * this.currentPage;
                    this.items.slice(base, base + this.perPage).show();

                    this.updateNavigation();
                },
                init: function(container, items, perPage) {
                    this.container = container;
                    this.currentPage = 0;
                    this.totalPages = 1;
                    this.perPage = perPage;
                    this.items = items;
                    this.createNavigation();
                    this.showItems();
                }
            };

            // stuff it all into a jQuery method!
            $.fn.pagify = function(perPage, itemSelector, cPage) {
                var el = $(this);
                var items = $(itemSelector, el);

                // default perPage to 5
                if (isNaN(perPage) || perPage === undefined) {
                    perPage = 3;
                }

                // don't fire if fewer items than perPage
                if (items.length <= perPage) {
                    return true;
                }

                pagify.init(el, items, perPage);
            };


            $('#pageDiv1').hide();
            $('#pageDiv2').hide();
            $('#pageDiv4').hide();

            $(".pagination_three").pagify(5, ".pagination-element3", 3);
        }

        if (ffff = 4) {
            var pagify = {
                items: {},
                container: null,
                totalPages: 1,
                perPage: 3,
                currentPage: 0,
                createNavigation: function() {
                    this.totalPages = Math.ceil(this.items.length / this.perPage);

                    $('.pagination', this.container.parent()).remove();
                    var pagination4 = $('<div class="pagination4" id="pageDiv4" style="display:none;"></div>');
                    // var pagination4 = $('<div class="pagination4" id="pageDiv4" style="display:none;"></div>').append('<a class="nav prev disabled" data-next="false"><</a>');

                    for (var i = 0; i < this.totalPages; i++) {
                        var pageElClass = "page4";
                        if (!i)
                            pageElClass = "page4 current";
                        var pageEl = '<a class="' + pageElClass + '" data-page4="' + (
                            i + 1) + '">' + (
                            i + 1) + "</a>";
                        pagination4.append(pageEl);
                    }
                    // pagination4.append('<a class="nav next" data-next="true">></a>');

                    this.container.after(pagination4);

                    var that = this;
                    $("body").off("click", ".nav");
                    this.navigator = $("body").on("click", ".nav", function() {
                        var el = $(this);
                        that.navigate(el.data("next"));
                    });

                    $("body").off("click", ".page4");
                    this.pageNavigator = $("body").on("click touchstart", ".page4", function() {
                        var el = $(this);
                        that.goToPage(el.data("page4"));
                    });
                },
                navigate: function(next) {
                    // default perPage to 5
                    if (isNaN(next) || next === undefined) {
                        next = true;
                    }
                    $(".pagination4 .nav").removeClass("disabled");
                    if (next) {
                        this.currentPage++;
                        if (this.currentPage > (this.totalPages - 1))
                            this.currentPage = (this.totalPages - 1);
                        if (this.currentPage == (this.totalPages - 1))
                            $(".pagination4 .nav.next").addClass("disabled");
                    } else {
                        this.currentPage--;
                        if (this.currentPage < 0)
                            this.currentPage = 0;
                        if (this.currentPage == 0)
                            $(".pagination4 .nav.prev").addClass("disabled");
                    }

                    this.showItems();
                },
                updateNavigation: function() {

                    var pages = $(".pagination4 .page4");
                    pages.removeClass("current");
                    $('.pagination4 .page4[data-page4="' + (
                        this.currentPage + 1) + '"]').addClass("current");
                    $('html,body').animate({
                        scrollTop: $(".scroll-break-div").offset().top
                    }, 'slow');
                },
                goToPage: function(page4) {

                    this.currentPage = page4 - 1;

                    $(".pagination4 .nav").removeClass("disabled");
                    if (this.currentPage == (this.totalPages - 1))
                        $(".pagination4 .nav.next").addClass("disabled");

                    if (this.currentPage == 0)
                        $(".pagination4 .nav.prev").addClass("disabled");
                    this.showItems();
                },
                showItems: function() {
                    this.items.hide();
                    var base = this.perPage * this.currentPage;
                    this.items.slice(base, base + this.perPage).show();

                    this.updateNavigation();
                },
                init: function(container, items, perPage) {
                    this.container = container;
                    this.currentPage = 0;
                    this.totalPages = 1;
                    this.perPage = perPage;
                    this.items = items;
                    this.createNavigation();
                    this.showItems();
                }
            };

            // stuff it all into a jQuery method!
            $.fn.pagify = function(perPage, itemSelector, cPage) {
                var el = $(this);
                var items = $(itemSelector, el);

                // default perPage to 5
                if (isNaN(perPage) || perPage === undefined) {
                    perPage = 3;
                }

                // don't fire if fewer items than perPage
                if (items.length <= perPage) {
                    return true;
                }

                pagify.init(el, items, perPage);
            };

            $('#pageDiv1').hide();
            $('#pageDiv2').hide();
            $('#pageDiv3').hide();

            $(".pagination_four").pagify(5, ".pagination-element4", 4);
        }


    }
</script>
<script>
    function currentPagination(num) {

        if (num == 1) {
            $('#pageDiv1').show();
            $('#pageDiv2').hide();
            $('#pageDiv3').hide();
            $('#pageDiv4').hide();
        } else if (num == 2) {
            $('#pageDiv1').hide();
            $('#pageDiv2').show();
            $('#pageDiv3').hide();
            $('#pageDiv4').hide();
        } else if (num == 3) {
            $('#pageDiv1').hide();
            $('#pageDiv2').hide();
            $('#pageDiv3').show();
            $('#pageDiv4').hide();
        } else if (num == 4) {
            $('#pageDiv1').hide();
            $('#pageDiv2').hide();
            $('#pageDiv3').hide();
            $('#pageDiv4').show();
        }
    }
</script>
<script>
    $(document).ready(function() {
        for (cindex = 1; cindex < divCount + 1; cindex++) {
            var stepNum = cindex + 1;
            var numSteps = divCount;
            currentStep = stepNum;
            currentStep++;
            var presentSten = cindex;
            $('.pagination' + presentSten + '').each(function(i, el) {
                var type = $(el).attr('type');
                var name = $(el).attr('name');
                var tag = $(el).prop("tagName");
                var data = $(el).val();

                var subcat, getSelectedValue, checkbox;
                if (type == 'radio') {
                    var getSelectedValue = document.querySelector("input[name=" + name + "]:checked");
                }
                if (type == 'checkbox') {
                    var checkbox = document.querySelector('input[name="' + name + '"]:checked');
                }
                if (tag == 'SELECT') {
                    var subcat = document.getElementById(name);
                }

                if (type == 'text' || tag == 'TEXTAREA') {
                    if (data == '' || data == null || data == undefined) {
                        return false;
                    }
                } else if (type == 'radio') {
                    if (getSelectedValue == null) {
                        return false;
                    }
                } else if (type == 'checkbox') {
                    if (checkbox == null) {
                        return false;
                    }
                } else if (type == undefined && tag == 'SELECT') {
                    if (subcat.value == null || subcat.value == "") {
                        return false;
                    }
                } else {

                    var StepperID = 'Stepper' + presentSten + 'ID';
                    document.getElementById(StepperID).classList.add('done');

                    editingStep1 = document.getElementsByClassName("step");
                    for (i = 0; i < editingStep1.length; i++) {
                        editingStep1[i].className = editingStep1[i].className.replace(" editing", "");
                    }
                    if (presentSten != divCount) {
                        var StepperEditID = 'Stepper' + stepNum + 'ID';
                        document.getElementById(StepperEditID).classList.add('editing');
                    } else {
                        var StepperEditID = 'Stepper' + stepNum + 'ID';
                        document.getElementById(StepperEditID).classList.remove(" editing");
                    }
                }
            });

        }
    });
    
    function showInput(nameField) {
        var otherInput = document.getElementsByClassName("otherOption" + nameField[0].id);
        for (var i = 0; i < nameField.length; i++) {
            if (nameField[i].checked) {
                if (nameField[i].value == 'Others') {
                    otherInput[0].style.display = "inline";
                    otherInput[0].style.border = "1px solid black";
                    otherInput[0].disabled = false;
                    otherInput[0].style.pointerEvents = "none";
                    

                } else {
                    otherInput[0].style.display = "none";
                    otherInput[0].disabled = true;
                }
            }
        }
    }

    function showInputSub(nameField, option_question_fields_id) {

        for (var i = 0; i < nameField.length; i++) {
            var othersub = $(nameField[i]).attr('othersub');
            var othersub_flag = $(nameField[i]).attr('other_flag');
            var otherInput = document.getElementsByClassName(othersub);
            var othersubinputElement = document.getElementsByClassName(othersub)[0];

            if (nameField[i].checked) {
                otherInput[0].style.display = "inline";
                otherInput[0].style.border = "1px solid black";
                otherInput[0].disabled = false;
                otherInput[0].style.pointerEvents = "none";
            } else {
                otherInput[0].style.display = "none";
                otherInput[0].disabled = true;
            }
        }
    }

    function showInputOthers(nameField) {
        // alert(nameField[0].id);
        var checkbox = document.getElementsByClassName("otherField" + nameField[0].id);
        if ($('.otherOption' + nameField[0].id).prop('checked')) {
            checkbox[0].style.display = "inline";
            checkbox[0].style.border = "1px solid black";
            checkbox[0].disabled = false;
            checkbox[0].style.pointerEvents = "none";
        } else {
            checkbox[0].style.display = "none";
            checkbox[0].disabled = true;
            checkbox[0].style.pointerEvents = "none";
        }
    }
</script>
@endsection