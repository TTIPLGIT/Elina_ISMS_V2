@extends('layouts.adminnav')

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
        content: "";
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

    /* .card_design label {
        text-align: center;
    } */
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


    /* .incomp {
        box-shadow: inset 0px 0px 0px 2px #f31010;
        border-radius: 10px;
    } */
    .incompCount {
        box-shadow: inset 0px 0px 0px 2px #f31010;
        border-radius: 10px;
    }
</style>
@include('questionnaire_for_parents.style')

<div class="main-content">
    @if (session('success'))
    <input type="hidden" name="session_data" id="session_data" class="session_data" value="{{ session('success') }}">
    <input type="hidden" name="session_data_page" id="session_data_page" class="session_data" value="{{ session('page') }}">
    <input type="hidden" name="session_data_restorePagination" id="session_data_restorePagination" class="session_data" value="{{ session('restorePagination') }}">
    <input type="hidden" name="session_data_restorepaginationPage" id="session_data_restorepaginationPage" class="session_data" value="{{ session('restorepaginationPage') }}">

    <script type="text/javascript">
        var openpage = $('#session_data_page').val();
        var restorePagination = $('#session_data_restorePagination').val();
        var restorepaginationPage = $('#session_data_restorepaginationPage').val();

        window.onload = function() {

            openCity('', 'Step' + openpage, openpage);
            var Opages = $('.pagination' + restorePagination + ' .page' + restorePagination + '[data-page' + restorePagination + '="1"]');
            Opages.removeClass("current");

            $('.pagination' + restorePagination + ' .page' + restorePagination + '[data-page' + restorePagination + '="' + (parseInt(restorepaginationPage) + 1) + '"]').addClass("current");
            document.getElementById('restorePagination').value = restorePagination;
            document.getElementById('restorepaginationPage').value = restorepaginationPage;
            var message = $('#session_data').val();
            swal.fire("Success", message, "success");

        }
    </script>
    @else
    <input type="hidden" name="session_data_restorePagination" id="session_data_restorePagination" class="session_data" value="{{ session('restorePagination') }}">
    <input type="hidden" name="session_data_restorepaginationPage" id="session_data_restorepaginationPage" class="session_data" value="{{ session('restorepaginationPage') }}">
    <script type="text/javascript">
        var restorePagination = $('#session_data_restorePagination').val();
        var restorepaginationPage = $('#session_data_restorepaginationPage').val();
    </script>
    @endif



    {{ Breadcrumbs::render('questionnaire_for_user.form.edit',$questionDetails[0]['questionnaire_name']) }}
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
                    <!-- <div id="loader_div" class="loader_div">
                        <img src="/images/loaderajax.gif">
                    </div> -->
                    <div class="scroll-break-div"></div>
                    <div class="stepper-horizontal" id="stepper1">
                        <div class="step" id="Stepper1ID">
                            <div class="step-circle"><span>1</span></div>
                            <div class="step-bar-left" id="Stepper2ID2"></div>
                            <!-- <div class="step-bar-right"></div> -->
                        </div>
                        <div class="step" id="Stepper2ID">
                            <div class="step-circle"><span>2</span></div>
                            <div class="step-bar-left" id="Stepper3ID2"></div>
                            <!-- <div class="step-bar-right"></div> -->
                        </div>
                        <div class="step" id="Stepper3ID">
                            <div class="step-circle"><span>3</span></div>
                            <div class="step-bar-left" id="Stepper4ID2"></div>
                            <!-- <div class="step-bar-right"></div> -->
                        </div>
                        <div class="step" id="Stepper4ID">
                            <div class="step-circle"><span>4</span></div>
                            <div class="step-bar-left"></div>
                            <!-- <div class="step-bar-right"></div> -->
                        </div>
                    </div>

                    <div class="tab">
                        <button class="tablinks" id="Tab1" onclick="openCity(event, 'Step1' , '1')">Stage 1</button>
                        <button class="tablinks" id="Tab2" onclick="openCity(event, 'Step2' , '2')">Stage 2</button>
                        <button class="tablinks" id="Tab3" onclick="openCity(event, 'Step3' , '3')">Stage 3</button>
                        <button class="tablinks" id="Tab4" onclick="openCity(event, 'Step4' , '4')">Stage 4</button>
                    </div>
                    <form class="formValidationDiv" action="{{ route('questionnaire.form.save') }}" method="post" id="divQuestionnaireForm">
                        {{ csrf_field() }}
                        <div class="card card_design">
                            <input type="hidden" value="{{$questionnaire_initiation_id}}" id="questionnaire_initiation_id" name="questionnaire_initiation_id">
                            <input type="hidden" id="btn_type" name="progress_status">
                            <input type="hidden" id="complete_question" name="complete_question">
                            <input type="hidden" id="restorePage" name="restorePage">
                            <input type="hidden" id="restorePagination" name="restorePagination">
                            <input type="hidden" id="restorepaginationPage" name="restorepaginationPage">
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
        <div class="tile-footer title-footer-button-alignment" style="padding: 10px;">
            <a type="button" class="btn btn-labeled btn-info" onclick="PrevTab();" id="Previous" title="Previous" style="display:none;height: 35px;background: blue !important; border-color:blue !important; color:white !important">
                <span class="btn-label" style="font-size:13px !important;"><i class="fa fa-arrow-left"></i></span> Previous Stage</a>

            <button class="btn btn-success saveButton_form" onclick="save()" type="button" id="saveButton">
                <i class="fa fa-fw fa-lg fa-check-circle"></i>Save</button>&nbsp;&nbsp;&nbsp;
            @if($role == 'Parent')
            <a type="button" class="btn btn-labeled back-btn" title="Back" href="{{ route('questionnaire_for_user.index') }}" style="color:white !important">
                <span class="btn-label" style="font-size:13px !important;"><i class="fa fa-arrow-left"></i></span> Cancel</a>
            @else
            <a type="button" class="btn btn-labeled back-btn" title="Back" href="{{ URL::previous() }}" style="color:white !important">
                <span class="btn-label" style="font-size:13px !important;"><i class="fa fa-arrow-left"></i></span> Cancel</a>
            @endif
            <!-- <button class="btn btn-success" onclick="nextStep()">Next</button> -->
            <button class="btn btn-success" onclick="sub()">Submit</button>

            <a type="button" class="btn btn-labeled btn-info" onclick="NextTab();" id="Next" title="Next" style="background: blue !important; border-color:#4d94ff !important; color:white !important;height: 35px;">
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
        completed_questions();
        var tabIDs = $('.tablinks.active').attr('id');
        var ret1 = tabIDs.replace('Tab', '');
        document.getElementById('restorePage').value = ret1;
        $(".loader").show();
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
                var Qrequired = $(el).attr('data-required');
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
                    if (Qrequired == 1) {
                        if (data == '' || data == null || data == undefined) {
                            document.getElementById(divErrorID).classList.add('inputError');
                        }
                    }
                } else if (type == 'radio') {
                    if (Qrequired == 1) {
                        var inputElement = document.getElementsByClassName("otherOption" + idd)[0];
                        if (inputElement != undefined) {
                            var inputValue = inputElement.value;
                            if (inputValue == '' || inputValue == null || inputValue == undefined) {
                                var element = document.getElementById(divErrorID);
                                element.classList.add("inputError");
                            }
                        } else {
                            if (getSelectedValue == null) {
                                var element = document.getElementById(divErrorID);
                                element.classList.add("inputError");
                            }
                        }
                    }
                } else if (type == 'checkbox') {
                    if (Qrequired == 1) {
                        if (checkbox == null || checkbox == '') {
                            var otherField = document.getElementsByClassName("otherField" + idd)[0];
                            var othersCheckbox = document.getElementsByClassName("otherOption" + idd)[0];
                            if (othersCheckbox != undefined) {
                                if (othersCheckbox.checked && otherField.value.trim() === "") {
                                    document.getElementById(divErrorID).classList.add('inputError');
                                }
                            } else {
                                document.getElementById(divErrorID).classList.add('inputError');
                            }
                        }
                    }
                } else if (type == undefined && tag == 'SELECT') {
                    if (Qrequired == 1) {
                        if (subcat.value == null || subcat.value == "") {
                            document.getElementById(divErrorID).classList.add('inputError');
                        }
                    }
                }
            });

        }

        var hasError = $(".inputError").length;
        completed_questions();
        if (hasError == 0) {
            $(".loader").show();
            document.getElementById('divQuestionnaireForm').submit();
        } else {
            var target = document.querySelector(".incompCount label");
            if (target != null || target != undefined) {
                var errorQuestion = target.innerHTML;
                swal.fire("Please Fill", errorQuestion, "error");
                return false;
            } else {
                Swal.fire({
                    title: "Do you want to Submit the form",
                    text: "Please click 'Yes' to Submit the form",
                    icon: "warning",
                    customClass: 'swalalerttext',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    confirmButtonText: "Yes",
                    cancelButtonText: "No",
                }).then((result) => {
                    if (result.isConfirmed) {
                        $(".loader").show();
                        document.getElementById('divQuestionnaireForm').submit();
                    } else {
                        return false;
                    }
                });

                // document.getElementById('divQuestionnaireForm').submit();
            }
        }
    }

    function completed_questions() {
        divClass = document.getElementsByClassName("divClass");
        for (i = 0; i < divClass.length; i++) {
            divClass[i].className = divClass[i].className.replace(" inputError", "");
            divClass[i].className = divClass[i].className.replace(" comp", "");
            divClass[i].className = divClass[i].className.replace(" incompCount", "");
        }
        var divClass = $(".divClass").length;
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
                var idd = $(el).attr('id');
                var divErrorID = 'div'.concat(idd);
                var Qrequired = $(el).attr('data-required');
                // console.log(divErrorID);
                var subcat, getSelectedValue, checkbox;
                if (type == 'radio') {
                    var getSelectedValue = document.querySelector("input[name=" + name + "]:checked");
                }
                if (type == 'checkbox') {
                    var checkbox = document.querySelector('input[type=checkbox][id=' + idd + ']:checked');
                }
                if (tag == 'SELECT') {
                    var subcat = document.getElementById(name);
                }
                if (type == 'text' || tag == 'TEXTAREA') {
                    if (data == '' || data == null || data == undefined) {
                        document.getElementById(divErrorID).classList.add('incomp');
                        if (Qrequired == 1) {
                            document.getElementById(divErrorID).classList.add('incompCount'); //1
                        }
                    } else {
                        document.getElementById(divErrorID).classList.add('comp');
                        document.getElementById(divErrorID).classList.remove('incomp');
                    }
                } else if (type == 'radio') {
                    if (getSelectedValue == null) {
                        var inputElement = document.getElementsByClassName("otherOption" + idd)[0];
                        if (inputElement != undefined) {
                            var inputValue = inputElement.value;
                            if (inputValue == '' || inputValue == null || inputValue == undefined) {
                                var element = document.getElementById(divErrorID);
                                element.classList.add("incomp");
                                document.getElementById(divErrorID).classList.remove('comp');
                                if (Qrequired == 1) {
                                    document.getElementById(divErrorID).classList.add('incompCount'); //1
                                }
                            }
                        } else {
                            var element = document.getElementById(divErrorID);
                            element.classList.add("incomp");
                            document.getElementById(divErrorID).classList.remove('comp');
                            if (Qrequired == 1) {
                                document.getElementById(divErrorID).classList.add('incompCount');
                            }
                        }
                    } else {
                        document.getElementById(divErrorID).classList.add('comp');
                        document.getElementById(divErrorID).classList.remove('incomp');
                    }
                } else if (type == 'checkbox') {
                    if (checkbox == null) {
                        document.getElementById(divErrorID).classList.add('incomp');
                        if (Qrequired == 1) {
                            document.getElementById(divErrorID).classList.add('incompCount'); //2
                        }
                    } else {
                        var otherField = document.getElementsByClassName("otherField" + idd)[0];
                        var othersCheckbox = document.getElementsByClassName("otherOption" + idd)[0];
                        if (othersCheckbox != undefined) {
                            if (othersCheckbox.checked && otherField.value.trim() === "") {
                                if (Qrequired == 1) {
                                    document.getElementById(divErrorID).classList.add('incompCount'); //3
                                }
                                document.getElementById(divErrorID).classList.add('incomp');
                            } else {
                                document.getElementById(divErrorID).classList.add('comp');
                                document.getElementById(divErrorID).classList.remove('incomp');
                            }
                        } else {
                            var mainQuestion = document.getElementById(divErrorID);
                            var mainQuestionName = mainQuestion.querySelector('label.required').innerText.trim();
                            var subquestions = mainQuestion.querySelectorAll('input[type="checkbox"]');

                            var isValid = true;

                            subquestions.forEach(function(subquestion) {
                                var subquestionName = subquestion.parentNode.parentNode.querySelector('td:first-child').innerText.trim();
                                var subquestionOptions = mainQuestion.querySelectorAll('input[name="' + subquestion.getAttribute('name') + '"]:checked');

                                if (subquestionOptions.length === 0) {
                                    isValid = false;
                                    subquestion.parentNode.classList.add('error');
                                    console.log('Please select an option for subquestion: ' + subquestionName);
                                } else {
                                    subquestion.parentNode.classList.remove('error');
                                }
                            });
                            if (isValid) {
                                document.getElementById(divErrorID).classList.add('comp');
                                document.getElementById(divErrorID).classList.remove('incomp');
                            } else {
                                if (Qrequired == 1) {
                                    document.getElementById(divErrorID).classList.add('incompCount'); //3
                                }
                            }
                        }
                    }
                } else if (type == undefined && tag == 'SELECT') {
                    if (subcat.value == null || subcat.value == "") {
                        if (Qrequired == 1) {
                            document.getElementById(divErrorID).classList.add('incompCount'); //3
                        }
                        document.getElementById(divErrorID).classList.add('incomp');
                    } else {
                        document.getElementById(divErrorID).classList.add('comp');
                        document.getElementById(divErrorID).classList.remove('incomp');
                    }
                }
            });
        }

        var incomp = $(".incomp").length;
        var comp = $(".comp").length;
        var QueSub = $(".QueSub").length;

        var ff = incomp + comp;
        if (ff == divClass) {
            document.getElementById('complete_question').value = comp;
        } else if (ff > divClass) {
            var co = comp - QueSub;
            document.getElementById('complete_question').value = co;
        } else {
            var co2 = comp + QueSub;
            document.getElementById('complete_question').value = co2;
        }

        return true;
    }
</script>

<!-- <script>
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
</script> -->
<script>
    // $(document).ready(function() {
    //     var cityName = 'Step1';
    //     document.getElementById(cityName).style.display = "block";
    //     currentPagination('1');
    // });

    function openCity(evt, cityName, stepNum) {
        // console.log(evt, cityName, stepNum);
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
        // // alert(stepNum); alert(ret);
        // currentPagination(stepNum);
        // nextStep(stepNum, ret);
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
    function showInput(nameField) {
        var otherInput = document.getElementsByClassName("otherOption" + nameField[0].id);
        for (var i = 0; i < nameField.length; i++) {
            if (nameField[i].checked) {
                if (nameField[i].value == 'Others') {
                    otherInput[0].style.display = "inline";
                    otherInput[0].disabled = false;
                } else {
                    otherInput[0].style.display = "none";
                    otherInput[0].disabled = true;
                }
            }
        }
    }

    function showInputOthers(nameField) {
        // alert(nameField[0].id);
        var checkbox = document.getElementsByClassName("otherField" + nameField[0].id);
        if ($('.otherOption' + nameField[0].id).prop('checked')) {
            checkbox[0].style.display = "inline";
            checkbox[0].disabled = false;
        } else {
            checkbox[0].style.display = "none";
            checkbox[0].disabled = true;
        }
    }
</script>
<script>
    $(document).ready(function() {

        var response = <?php echo (json_encode($question)); ?>;
        if (response.length > 0) {
            QuestionnaireForm(response);
            pagi_nation();
            currentPagination('1');
        }
        console.log('Edit');

    });

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

        // const fieldTypeID = DataFields[index]['questionnaire_field_types_id'];
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
            // stage = '#Step1';
            // console.log(DataFields);
            stageQuestionCount++;
            var checkindex = index; //alert(checkindex);
            const fieldTypeID = DataFields[index]['questionnaire_field_types_id'];
            const fieldID = DataFields[index]['question_details_id'];
            const fieldLabel = DataFields[index]['question'];
            const fieldName = DataFields[index]['question_field_name'];
            const fieldValue = DataFields[index][fieldName];
            const otherOption = DataFields[index]['other_option'];
            const requiredQuestion = DataFields[index]['required'];
            var fieldOptionsDB = <?php echo (json_encode($fieldOptionsDB)); ?>;
            var fieldQuestionsDB = <?php echo (json_encode($fieldQuestionsDB)); ?>;
            var options = <?php echo json_encode($options); ?>;
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
                    textboxHtml += '<input data-required="' + requiredQuestion + '" class="form-control pagination' + num + '" type="text" id="' + fieldName + '" name="' + fieldName + '" placeholder="Your Answer"><i class="bar"></i>';
                } else {
                    textboxHtml += '<input data-required="' + requiredQuestion + '" class="form-control pagination' + num + '" type="text" value="' + fieldValue + '" id="' + fieldName + '" name="' + fieldName + '" placeholder="Your Answer"><i class="bar"></i>';
                }
                textboxHtml += '</div></div>';
                $(stage).append(textboxHtml);
            }

            // if (fieldTypeID == 8) {
            //     var textboxHtml = '<div class="col-md-12 divClass" id="div' + fieldName + '"><div class="form-group pagination-element' + num + '">';
            //     textboxHtml += '<label class="control-label">'  + questionNum + ' . ' + fieldLabel + '</label>';
            //     if (fieldValue == null) {
            //         textboxHtml += '<input class="form-control pagination' + num + '" type="url" id="' + fieldName + '" name="' + fieldName + '" placeholder="Your Answer"><i class="bar"></i>';
            //     } else {
            //         textboxHtml += '<input class="form-control pagination' + num + '" type="url" value="' + fieldValue + '" id="' + fieldName + '" name="' + fieldName + '" placeholder="Your Answer"><i class="bar"></i>';
            //     }
            //     textboxHtml += '</div></div>';
            //     $(stage).append(textboxHtml);
            // }

            if (fieldTypeID == 2) {
                var textboxHtml = '<div class="col-md-12 divClass" id="div' + fieldName + '"><div class="form-group pagination-element' + num + '">';
                textboxHtml += '<label class="control-label ' + (requiredQuestion == 1 ? ' required' : '') + '">' + questionNum + ' . ' + fieldLabel + '</label>';
                if (fieldValue == null) {
                    textboxHtml += '<textarea data-required="' + requiredQuestion + '" class="form-control pagination' + num + '" id="' + fieldName + '" name="' + fieldName + '" rows="2" cols="25" placeholder="Your Answer"></textarea>';
                } else {
                    textboxHtml += '<textarea data-required="' + requiredQuestion + '" class="form-control pagination' + num + '" id="' + fieldName + '" name="' + fieldName + '" rows="2" cols="25" placeholder="Your Answer">' + fieldValue + '</textarea>';
                }
                textboxHtml += '<i class="bar"></i>';
                textboxHtml += '</div></div>';
                $(stage).append(textboxHtml);
            }

            if (fieldTypeID == 3) {

                var response = fieldOptionsDB;
                var dropdownHtml = '<div class="col-md-12 divClass" id="div' + fieldName + '"><div class="form-group pagination-element' + num + '">';
                dropdownHtml += '<label class="control-label ' + (requiredQuestion == 1 ? ' required' : '') + '">' + questionNum + ' . ' + fieldLabel + '</label>';
                dropdownHtml += '<select data-required="' + requiredQuestion + '" class="documentCategory pagination' + num + '" name="' + fieldName + '" id="' + fieldName + '" style="width: 50%;">';
                dropdownHtml += '<option value=""> Choose </option>';
                for (let index = 0; index < response.length; index++) {
                    const question_details_id = response[index]['question_details_id'];
                    const option_field_name = response[index]['option_for_question'];
                    if (question_details_id == fieldID)
                        if (fieldValue == option_field_name) {
                            dropdownHtml += "<option value='" + option_field_name + "' selected>" + option_field_name + "</option>";
                        } else {
                            dropdownHtml += "<option value='" + option_field_name + "'>" + option_field_name + "</option>";
                        }
                    // dropdownHtml += option;
                }
                dropdownHtml += '</select><i class="bar" style="width: 50%;"></i></div></div>';
                $(stage).append(dropdownHtml);

            }

            if (fieldTypeID == 4) {

                var response = fieldOptionsDB;
                var currentOption = [];
                var radioButtonHtml = '<div class="col-md-12 divClass" id="div' + fieldName + '"><div class="form-radio pagination-element' + num + '">';
                radioButtonHtml += '<label class="control-label ' + (requiredQuestion == 1 ? ' required' : '') + '" style="margin-left: -30px;padding-bottom: 10px;">' + questionNum + ' . ' + fieldLabel + '</label><div class="radio">';
                for (let index = 0; index < response.length; index++) {
                    const question_details_id = response[index]['question_details_id'];
                    const option_field_name = response[index]['option_for_question'];
                    if (question_details_id == fieldID) {
                        currentOption.push(option_field_name);
                        if (fieldValue == option_field_name) {
                            radioButtonHtml += '<div class="radio">';
                            radioButtonHtml += '<label><input data-required="' + requiredQuestion + '" style="margin-right: 10px;" class="pagination' + num + ' Qradio" type="radio" name="' + fieldName + '" id="' + fieldName + '" value="' + option_field_name + '" onclick="showInput(' + fieldName + ')" checked><i class="helper"></i>' + option_field_name;
                            radioButtonHtml += '</label></div>';
                        } else {
                            radioButtonHtml += '<div class="radio">';
                            radioButtonHtml += '<label><input data-required="' + requiredQuestion + '" style="margin-right: 10px;" class="pagination' + num + ' Qradio" type="radio" name="' + fieldName + '" id="' + fieldName + '" value="' + option_field_name + '" onclick="showInput(' + fieldName + ')"><i class="helper"></i>' + option_field_name;
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
                        radioButtonHtml += '<label><input style="margin-right: 10px;" class="pagination' + num + ' Qradio" type="radio" name="' + fieldName + '" id="' + fieldName + '" value="Others" onclick="showInput(' + fieldName + ')" checked><i class="helper"></i> '+ (fieldID == '106' ? 'If yes, please mention the reason <br/>' : 'Others');
                        radioButtonHtml += '<input data-required="' + requiredQuestion + '" type="text" class="otherOption' + fieldName + '" value="' + fieldValue + '" '+(fieldID == '106' ? 'style="opacity: 1;width: 589px;margin: -2px 0px 0px 30px;' : 'style="opacity: 1;width: 589px;margin: -2px 0px 0px 80px;')+ '" name="' + fieldName + '">';
                        radioButtonHtml += '</label></div>';
                    } else {
                        radioButtonHtml += '<div class="radio">';
                        radioButtonHtml += '<label><input style="margin-right: 10px;" class="pagination' + num + ' Qradio" type="radio" name="' + fieldName + '" id="' + fieldName + '" value="Others" onclick="showInput(' + fieldName + ')"><i class="helper"></i> '+(fieldID == '106' ? 'If yes, please mention the reason' : 'Others');
                        radioButtonHtml += '<input disabled data-required="' + requiredQuestion + '" type="text" class="otherOption' + fieldName + '" '+(fieldID == '106' ? 'style="opacity: 1;width: 589px;margin: -2px 0px 0px 30px;' : 'style="opacity: 1;width: 589px;margin: -2px 0px 0px 80px;')+' name="' + fieldName + '">';
                        radioButtonHtml += '</label></div>';
                    }
                }
                // console.log(currentOption);
                // 
                radioButtonHtml += '</div></div>';
                $(stage).append(radioButtonHtml);
            }
            if (fieldTypeID === 5) {
                var currentOption = [];
                var response = fieldOptionsDB;
                // console.log(fieldValue);
                var obj = JSON.parse(fieldValue || null); //console.log(obj);
                var radioButtonHtml = `<div class="col-md-12 divClass" id="div${fieldName}"><div class="form-group pagination-element${num}">`;
                radioButtonHtml += `<label class="control-label ` + (requiredQuestion == 1 ? ' required' : '') + `">${questionNum}. ${fieldLabel}</label><div class="checkbox">`;

                for (let index = 0; index < response.length; index++) {
                    const question_details_id = response[index]['question_details_id'];
                    const option_field_name = response[index]['option_for_question'];

                    if (question_details_id == fieldID) {
                        currentOption.push(option_field_name);
                        if (obj != null) {
                            if (obj.includes(option_field_name)) {
                                radioButtonHtml += `<label><input data-required="` + requiredQuestion + `" class="pagination${num}" type="checkbox" name="${fieldName}[]" id="${fieldName}" value="${option_field_name}" checked><i class="helper"></i>${option_field_name}</label>`;
                            } else {
                                radioButtonHtml += `<label><input data-required="` + requiredQuestion + `" class="pagination${num}" type="checkbox" name="${fieldName}[]" id="${fieldName}" value="${option_field_name}"><i class="helper"></i>${option_field_name}</label>`;
                            }
                        } else {
                            radioButtonHtml += `<label><input data-required="` + requiredQuestion + `" class="pagination${num}" type="checkbox" name="${fieldName}[]" id="${fieldName}" value="${option_field_name}"><i class="helper"></i>${option_field_name}</label>`;
                        }
                    }
                }
                if (otherOption == 1) {
                    let setcheckOther = false;
                    var missingValues = '';
                    for (var i = 0; i < obj.length; i++) {
                        if (!currentOption.includes(obj[i])) {
                            if (obj[i] != null && obj[i] != '') {
                                setcheckOther = true;
                                missingValues = obj[i];
                                break;
                            }
                        }
                    }
                    if (setcheckOther == true) {
                        radioButtonHtml += '<label><input class="pagination' + num + ' otherOption' + fieldName + '" type="checkbox" id="' + fieldName + '" onclick="showInputOthers(' + fieldName + ')" checked><i class="helper"></i>Others';
                        radioButtonHtml += '<input type="text" data-required="' + requiredQuestion + '" class="otherField' + fieldName + '" value="' + missingValues + '" style="width: 589px;display:inline;opacity: 1;margin:-2px 0 0 90px;border: 1px solid;" name="' + fieldName + '[]"></label>';
                    } else {
                        radioButtonHtml += '<label><input class="pagination' + num + ' otherOption' + fieldName + '" type="checkbox" id="' + fieldName + '" onclick="showInputOthers(' + fieldName + ')"><i class="helper"></i>Others';
                        radioButtonHtml += '<input disabled type="text" data-required="' + requiredQuestion + '" class="otherField' + fieldName + '" style="width: 700px;opacity: 1;display:none;margin:-2px 0 0 90px;border: 1px solid;" name="' + fieldName + '[]"></label>';
                    }
                }
                radioButtonHtml += `</div></div>`;
                $(stage).append(radioButtonHtml);
            }


            if (fieldTypeID == 7) {
                var response = fieldQuestionsDB;
                var fieldOptions = response.fieldOptions;
                var fieldQuestions = response.fieldQuestions;
                var radioButtonHtml = '<div class="col-md-12 divClass" id="div' + fieldName + '"><div class="form-group pagination-element' + num + '">';
                radioButtonHtml += '<label class="control-label ' + (requiredQuestion == 1 ? ' required' : '') + '">' + questionNum + ' . ' + fieldLabel + '</label><br>'; //Sub Question Radio
                radioButtonHtml += '<table class="table_content">';
                radioButtonHtml += '<tr>';
                radioButtonHtml += '<th width="30%"></th>';
                for (let index = 0; index < fieldOptions.length; index++) {
                    const question_details_id = fieldOptions[index]['question_details_id'];
                    const option_field_name = fieldOptions[index]['option_for_question'];
                    if (question_details_id == fieldID)
                        // radioButtonHtml += '<label class="control-label q_lable">' + option_field_name + '</label>';
                        radioButtonHtml += '<th>' + option_field_name + '</th>';
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
                        radioButtonHtml += '<tr>';
                        radioButtonHtml += '<td>' + sub_question + '</td>';
                        for (let index = 0; index < fieldOptions.length; index++) {
                            const question_details_id = fieldOptions[index]['question_details_id'];
                            const option_field_name = fieldOptions[index]['option_for_question'];
                            if (question_details_id == fieldID)
                                if (questionValue == option_field_name) {
                                    // alert('asd');
                                    radioButtonHtml += '<td><input data-required="' + requiredQuestion + '" style="height: 15px;" class="pagination' + num + ' QSub" type="radio" name="' + fieldName + sub_questions_id + '" id="' + fieldName + '" value="' + option_field_name + '" checked></td>';
                                } else {
                                    radioButtonHtml += '<td><input data-required="' + requiredQuestion + '" style="height: 15px;" class="pagination' + num + ' QSub" type="radio" name="' + fieldName + sub_questions_id + '" id="' + fieldName + '" value="' + option_field_name + '"></td>';
                                }
                            // radioButtonHtml += '<td><input class="pagination' + num + '" type="radio" name="' + fieldName + sub_questions_id + '" id="' + fieldName + '" value="' + option_field_name + '"></td>';
                        }
                        radioButtonHtml += '</tr>'
                    }
                }
                radioButtonHtml += '</table>';
                $(stage).append(radioButtonHtml);
            }

            if (fieldTypeID == 8) {

                var response = options;
                var dropdownHtml = '<div class="col-md-12 divClass" id="div' + fieldName + '"><div class="form-group pagination-element' + num + '">';
                dropdownHtml += '<label class="control-label ' + (requiredQuestion == 1 ? ' required' : '') + '">' + questionNum + ' . ' + fieldLabel + '</label>';
                dropdownHtml += '<select data-required="' + requiredQuestion + '" class="documentCategory pagination' + num + '" name="' + fieldName + '" id="' + fieldName + '" style="width: 50%;">';
                dropdownHtml += '<option value=""> Choose </option>';
                for (let index = 0; index < response.length; index++) {
                    const question_details_id = fieldID;
                    const option = response[index]['option'];
                    // console.log('fieldValue', fieldValue);console.log('option', option);
                    if (question_details_id === fieldID) {
                        if (fieldValue == option) {
                            dropdownHtml += "<option value='" + option + "' selected>" + option + "</option>";
                        } else {
                            dropdownHtml += "<option value='" + option + "'>" + option + "</option>";
                        }
                    }
                    // dropdownHtml += option;
                }
                dropdownHtml += '</select><i class="bar" style="width: 50%;"></i></div></div>';
                $(stage).append(dropdownHtml);

            }

            if (fieldTypeID == 9) {
                var stageCo = stageQuestionCount + addon;
                const isMultipleOf5 = stageCo => typeof stageCo === 'number' && stageCo % 5 === 0;
                // console.log(isMultipleOf5(stageCo));
                // console.log(index);
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
                var radioButtonHtml = '<div class="col-md-12 divClass" id="div' + fieldName + '"><div class="form-group pagination-element' + num + '">';
                radioButtonHtml += '<label class="control-label ' + (requiredQuestion == 1 ? ' required' : '') + '">' + questionNum + ' . ' + fieldLabel + '</label><br>'; //Sub Question Radio
                radioButtonHtml += '<table class="table_content">';
                radioButtonHtml += '<tr>';
                radioButtonHtml += '<th width="30%"></th>';
                for (let index = 0; index < fieldOptions.length; index++) {
                    const question_details_id = fieldOptions[index]['question_details_id'];
                    const option_field_name = fieldOptions[index]['option_for_question'];
                    if (question_details_id == fieldID)
                        // radioButtonHtml += '<label class="control-label q_lable">' + option_field_name + '</label>';
                        radioButtonHtml += '<th>' + option_field_name + '</th>';
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
                        radioButtonHtml += '<tr>';
                        radioButtonHtml += '<td>' + sub_question + '</td>';
                        for (let index = 0; index < fieldOptions.length; index++) {
                            const question_details_id = fieldOptions[index]['question_details_id'];
                            const option_field_name = fieldOptions[index]['option_for_question'];
                            if (question_details_id == fieldID) {
                                if (obj != null) {
                                    if (obj.includes(option_field_name)) {
                                        radioButtonHtml += '<td><input data-required="' + requiredQuestion + '" style="height: 15px;" class="pagination' + num + ' QSub" type="checkbox" name="' + fieldName + sub_questions_id + '[]" id="' + fieldName + '" value="' + option_field_name + '" checked></td>';
                                    } else {
                                        radioButtonHtml += '<td><input data-required="' + requiredQuestion + '" style="height: 15px;" class="pagination' + num + ' QSub" type="checkbox" name="' + fieldName + sub_questions_id + '[]" id="' + fieldName + '" value="' + option_field_name + '"></td>';
                                    }
                                } else {
                                    radioButtonHtml += '<td><input data-required="' + requiredQuestion + '" style="height: 15px;" class="pagination' + num + ' QSub" type="checkbox" name="' + fieldName + sub_questions_id + '[]" id="' + fieldName + '" value="' + option_field_name + '"></td>';
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
        // alert(nexttabID); alert(ret1);
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

    function nextStep(stepNum, ret) {

        var numSteps = divCount;
        currentStep = stepNum;
        currentStep++;
        var presentSten = ret;

        divClass = document.getElementsByClassName("divClass");
        for (i = 0; i < divClass.length; i++) {
            divClass[i].className = divClass[i].className.replace(" incomp", "");
        }

        $('.pagination' + presentSten + '').each(function(i, el) {
            var type = $(el).attr('type');
            var name = $(el).attr('name');
            var tag = $(el).prop("tagName");
            var data = $(el).val();
            var idd = $(el).attr('id');
            var divErrorID = 'div'.concat(idd);
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
                    var pagination1 = $('<div class="pagination1" style="font-size: 18px;font-weight: bolder;" id="pageDiv1"></div>');
                    // var pagination1 = $('<div class="pagination1" style="font-size: 18px;font-weight: bolder;" id="pageDiv1"></div>').append('<a class="nav prev disabled" data-next="false"><</a>');

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
                    this.pageNavigator = $("body").on("click", ".page1", function() {
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
                    document.getElementById('restorePagination').value = '1';
                    document.getElementById('restorepaginationPage').value = this.currentPage;
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
                init: function(container, items, perPage, cPage) {
                    this.container = container;
                    this.currentPage = cPage;
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

                pagify.init(el, items, perPage, cPage);
            };


            $('#pageDiv2').hide();
            $('#pageDiv3').hide();
            $('#pageDiv4').hide();
            // console.log("restorePagination" , restorePagination , "restorepaginationPage" , restorepaginationPage);
            $(".pagination_one").pagify(5, ".pagination-element1", restorePagination == 1 ? restorepaginationPage : 0);
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
                    var pagination2 = $('<div class="pagination2" style="font-size: 18px;font-weight: bolder;" id="pageDiv2"></div>');
                    // var pagination2 = $('<div class="pagination2" style="font-size: 18px;font-weight: bolder;" id="pageDiv2"></div>').append('<a class="nav prev disabled" data-next="false"><</a>');

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
                    this.pageNavigator = $("body").on("click", ".page2", function() {
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
                    document.getElementById('restorePagination').value = '2';
                    document.getElementById('restorepaginationPage').value = this.currentPage;
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
                init: function(container, items, perPage, cPage) {
                    this.container = container;
                    this.currentPage = cPage;
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

                pagify.init(el, items, perPage, cPage);
            };
            $('#pageDiv1').hide();
            $('#pageDiv4').hide();
            $('#pageDiv3').hide();

            $(".pagination_two").pagify(5, ".pagination-element2", restorePagination == 2 ? restorepaginationPage : 0);
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
                    var pagination3 = $('<div class="pagination3" style="font-size: 18px;font-weight: bolder;" id="pageDiv3"></div>');
                    // var pagination3 = $('<div class="pagination3" style="font-size: 18px;font-weight: bolder;" id="pageDiv3"></div>').append('<a class="nav prev disabled" data-next="false"><</a>');

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
                    this.pageNavigator = $("body").on("click", ".page3", function() {
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
                    document.getElementById('restorePagination').value = '3';
                    document.getElementById('restorepaginationPage').value = this.currentPage;
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
                init: function(container, items, perPage, cPage) {
                    this.container = container;
                    this.currentPage = cPage;
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

                pagify.init(el, items, perPage, cPage);
            };


            $('#pageDiv1').hide();
            $('#pageDiv2').hide();
            $('#pageDiv4').hide();

            $(".pagination_three").pagify(5, ".pagination-element3", restorePagination == 3 ? restorepaginationPage : 0);
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
                    var pagination4 = $('<div class="pagination4" style="font-size: 18px;font-weight: bolder;" id="pageDiv4" style="display:none;"></div>');
                    // var pagination4 = $('<div class="pagination4" style="font-size: 18px;font-weight: bolder;" id="pageDiv4" style="display:none;"></div>').append('<a class="nav prev disabled" data-next="false"><</a>');

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
                    this.pageNavigator = $("body").on("click", ".page4", function() {
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
                    document.getElementById('restorePagination').value = '4';
                    document.getElementById('restorepaginationPage').value = this.currentPage;
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
                init: function(container, items, perPage, cPage) {
                    this.container = container;
                    this.currentPage = cPage;
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

                pagify.init(el, items, perPage, cPage);
            };

            $('#pageDiv1').hide();
            $('#pageDiv2').hide();
            $('#pageDiv3').hide();

            $(".pagination_four").pagify(5, ".pagination-element4", restorePagination == 4 ? restorepaginationPage : 0);
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
    // $(document).ready(function() {
    //     for (cindex = 1; cindex < divCount + 1; cindex++) {
    //         var stepNum = cindex + 1;
    //         var numSteps = divCount;
    //         currentStep = stepNum;
    //         currentStep++;
    //         var presentSten = cindex;

    //         divClass = document.getElementsByClassName("divClass");
    //         for (i = 0; i < divClass.length; i++) {
    //             divClass[i].className = divClass[i].className.replace(" incomp", "");
    //         }

    //         $('.pagination' + presentSten + '').each(function(i, el) {
    //             var type = $(el).attr('type');
    //             var name = $(el).attr('name');
    //             var tag = $(el).prop("tagName");
    //             var data = $(el).val();
    //             var idd = $(el).attr('id');
    //             var divErrorID = 'div'.concat(idd);
    //             var subcat, getSelectedValue, checkbox;
    //             if (type == 'radio') {
    //                 var getSelectedValue = document.querySelector("input[name=" + name + "]:checked");
    //             }
    //             if (type == 'checkbox') {
    //                 var checkbox = document.querySelector('input[name="' + name + '"]:checked');
    //             }
    //             if (tag == 'SELECT') {
    //                 var subcat = document.getElementById(name);
    //             }

    //             if (type == 'text' || tag == 'TEXTAREA') {
    //                 if (data == '' || data == null || data == undefined) {
    //                     document.getElementById(divErrorID).classList.add('incomp');
    //                 }
    //             } else if (type == 'radio') {
    //                 if (getSelectedValue == null) {
    //                     var element = document.getElementById(divErrorID);
    //                     element.classList.add("incomp");
    //                 }
    //             } else if (type == 'checkbox') {
    //                 if (checkbox == null) {
    //                     document.getElementById(divErrorID).classList.add('incomp');
    //                 }
    //             } else if (type == undefined && tag == 'SELECT') {
    //                 if (subcat.value == null || subcat.value == "") {
    //                     document.getElementById(divErrorID).classList.add('incomp');
    //                 }
    //             }
    //         });
    //         var incomp = $(".incomp").length;
    //         if (incomp == 0) {
    //             var StepperID = 'Stepper' + presentSten + 'ID';
    //             document.getElementById(StepperID).classList.add('done');

    //             var editactive = $(".editing").length;

    //             if (editactive == 0) {
    //                 var StepperEditID = 'Stepper' + stepNum + 'ID';
    //                 document.getElementById(StepperEditID).classList.add('editing');
    //                 var cityName = 'Step'.concat(stepNum);
    //                 var Tab = 'Tab'.concat(stepNum);
    //                 document.getElementById(cityName).style.display = "block";
    //                 document.getElementById(Tab).classList.add('active');
    //                 currentPagination(stepNum);
    //             }
    //         }

    //     }
    // });

    $(document).ready(function() {

        var tabIDs = $('.tablinks.active').attr('id');
        if (tabIDs == undefined) {
            var StepperEditID = 'Stepper1ID';
            document.getElementById(StepperEditID).classList.add('editing');

            document.getElementById('Step1').style.display = "block";
            document.getElementById('Tab1').classList.add('active');
            currentPagination(1);
        }

    });
</script>

@endsection