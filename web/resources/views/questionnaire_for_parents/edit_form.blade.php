@extends('layouts.parent')
@section('content')
<style>
    #questionnaire-intro-img {
        margin: auto;
        outline: 5px white;
        border-radius: 25px;
        height: 50%;
        /* padding-bottom: 10px; */
    }

    #questionnaire-intro-img img {
        max-width: 100%;
        height: auto;
        display: block;
        border-radius: 20px;
    }

    #questionnaire-intro {
        margin: 10px 0;
        background: white;
        border-radius: 25px;
        padding-bottom: 10px;
    }

    #questionnaire-title {
        text-align: center;
    }

    .questionnaire-description {
        padding: 0 10px;
    }
</style>
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
        /* background: #199473;
        color: white; */

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
    .tab {
        overflow: hidden;
        border: 1px solid #f37020;
        background-color: #d4d0cf;
        border-radius: 36px;
        width: fit-content;
        margin: auto;
        text-align: center;

    }

    .tab button {
        background-color: #d4d0cf;
        border: none;
        outline: none;
        cursor: pointer;
        padding: 14px 4.1rem;
        transition: 0.3s;
        font-size: 20px;
        border-radius: 36px;
    }

    .tab button:hover {
        background-color: #f37020;
    }

    .tab button.active {
        background-color: #f37020;
    }

    .tabcontent {
        display: none;
    }
</style>
<style>
    .divClass {
        background: white;
        padding: 0.5rem;
        border-radius: 1rem;
        margin: 1rem 0;
    }

    label.control-label {
        font-weight: bold;
    }
</style>
<style>
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

    .inputError {
        box-shadow: inset 0px 0px 0px 2px #f31010;
        border-radius: 10px;
    }

    @media (max-width: 767px) {
        .otherOption {
            opacity: 1;

            margin: -2px 0px 0px 80px;
        }
    }
</style>
<div class="main-content">
    {{ Breadcrumbs::render('questionnaire_for_user.form.edit',$questionDetails[0]['questionnaire_name']) }}
    <!--  -->
    <div id="questionnaire-intro-img">
        <img src="https://lh3.googleusercontent.com/uwipCOl4g1Ic_jD1PHxn0zYnr1kcj2P94I4R-G0yqlAn5nI8iOd-3AaAlgZjMkJUU0fvlVlxbtRBd-F37o-wH2XBm3GhFWKjGRCu55SIjc58FiDiyQy38XQ-MuQQ7elX=w1200" alt="Banner Img">
    </div>

    <div id="questionnaire-intro">
        <h1 id="questionnaire-title">{{$questionDetails[0]['questionnaire_name']}}</h1>

        <div class="questionnaire-description">
            <div id="questionnaire-description">
                {!! $questionDetails[0]['questionnaire_description'] !!}
            </div>
            <p><strong>Note:</strong> required fields are marked with an asterisk (*)</p>
        </div>
    </div>
    <!--  -->
    <div class="row justify-content-center">
        <div class="col-lg-12 col-md-12">
            <div class="" style="height:100%;">
                <div id="content">
                    <div class="scroll-break-div"></div>
                    <div class="stepper-horizontal" id="stepper1">
                        <div class="step editing" id="Stepper1ID" onclick="showStage('Step1', 1)">
                            <div class="step-circle"><span>1</span></div>
                            <div class="step-bar-left" id="Stepper2ID2"></div>
                        </div>
                        <div class="step" id="Stepper2ID" onclick="showStage('Step2', 2)">
                            <div class="step-circle"><span>2</span></div>
                            <div class="step-bar-left" id="Stepper3ID2"></div>
                        </div>
                        <div class="step" id="Stepper3ID" onclick="showStage('Step3', 3)">
                            <div class="step-circle"><span>3</span></div>
                            <div class="step-bar-left" id="Stepper4ID2"></div>
                        </div>
                        <div class="step" id="Stepper4ID" onclick="showStage('Step4', 4)">
                            <div class="step-circle"><span>4</span></div>
                            <div class="step-bar-left"></div>
                        </div>

                    </div>

                    <div class="tab d-none d-md-block">
                        <button class="tablinks active" id="Tab1" onclick="showStage('Step1', 1)">Stage 1</button>
                        <button class="tablinks" id="Tab2" onclick="showStage('Step2', 2)">Stage 2</button>
                        <button class="tablinks" id="Tab3" onclick="showStage('Step3', 3)">Stage 3</button>
                        <button class="tablinks" id="Tab4" onclick="showStage('Step4', 4)">Stage 4</button>
                    </div>
                    <form class="formValidationDiv" action="{{ route('questionnaire.form.save') }}" method="post" id="divQuestionnaireForm">
                        {{ csrf_field() }}
                        <div class="">
                            <input type="hidden" value="{{$questionnaire_initiation_id}}" id="questionnaire_initiation_id" name="questionnaire_initiation_id">
                            <input type="hidden" id="btn_type" name="progress_status">
                            <input type="hidden" id="complete_question" name="complete_question">
                            <input type="hidden" id="restorePage" name="restorePage">
                            <input type="hidden" id="restorePagination" name="restorePagination">
                            <input type="hidden" id="restorepaginationPage" name="restorepaginationPage">

                            <div id="Step1" class="tabcontent pagination_one page_lable"></div>
                            <div id="Step2" class="tabcontent pagination_two page_lable"></div>
                            <div id="Step3" class="tabcontent pagination_three page_lable"></div>
                            <div id="Step4" class="tabcontent pagination_four page_lable"></div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-lg-12 text-center">
            <button class="btn btn-success saveButton_form" onclick="save()" type="button" id="saveButton">
                <i class="fa fa-fw fa-lg fa fa-bookmark"></i>Save</button>

            <button class="btn btn-success saveButton_form" onclick="sub()" type="button" id="saveButton">
                <i class="fa fa-fw fa-lg fa-check-circle"></i>Submit</button>
        </div>
        <div class="col-lg-12 text-center">
            <a type="button" id="navPrev" onclick="navigate('prev')" class="btn btn-labeled responsive-button button-style back-button" title="Back">
                <i class="fas fa-arrow-left"></i><span> Back </span>
            </a>

            <a type="button" href="{{ $role == 'Parent' ? route('questionnaire_for_user.index') : URL::previous() }}" class="btn btn-labeled responsive-button button-style cancel-button" title="Cancel">
                <i class="fas fa-times"></i><span> Cancel </span>
            </a>

            <a type="button" id="navNext" onclick="navigate('next')" class="btn btn-labeled responsive-button next-button button-style" title="Next">
                <i class="fas fa-arrow-right"></i><span> Next </span>
            </a>
        </div>
    </div>
</div>
<script>
    function save() {

        document.getElementById('btn_type').value = 'save';
        validateForm();
        var tabIDs = $('.tablinks.active').attr('id');
        var ret1 = tabIDs.replace('Tab', '');
        document.getElementById('restorePage').value = ret1;
        $(".loader").show();
        document.getElementById('divQuestionnaireForm').submit();
    }

    // function sub() {
    //     document.getElementById('btn_type').value = 'submit';
    //     validateForm();
    //     $(".loader").show();
    //     document.getElementById('divQuestionnaireForm').submit();

    // }
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
                var type = $(el).attr('type');
                var name = $(el).attr('name');
                var tag = $(el).prop("tagName");
                var data = $(el).val();
                var idd = $(el).attr('id');
                var Qrequired = $(el).attr('data-required');
                var divErrorID = 'div'.concat(idd);
                var questionType = $(el).closest('.divClass').data('question-type');

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

                // Validate text and textarea
                if (type == 'text' || tag == 'TEXTAREA') {
                    if (Qrequired == 1) {
                        if (data == '' || data == null || data == undefined || (typeof data === 'string' && data.trim() === '')) {
                            document.getElementById(divErrorID).classList.add('inputError');
                        }
                    }
                } 
                // Validate radio buttons
                else if (type == 'radio') {
                    if (Qrequired == 1) {
                        if (getSelectedValue == null) {
                            document.getElementById(divErrorID).classList.add("inputError");
                        } else {
                            // Check if "Others" option is selected and validate text field
                            var inputElement = document.getElementsByClassName("otherOption" + idd)[0];
                            if (inputElement != undefined) {
                                var computedStyle = window.getComputedStyle(inputElement);
                                if (computedStyle.display != "none" && computedStyle.visibility != "hidden") {
                                    var inputValue = inputElement.value;
                                    if (inputValue == '' || inputValue == null || inputValue == undefined || inputValue.trim() === "") {
                                        document.getElementById(divErrorID).classList.add("inputError");
                                    }
                                }
                            }
                        }
                    }
                } 
                // Validate checkboxes
                else if (type == 'checkbox') {
                    if (Qrequired == 1) {
                        // Check for checkbox arrays (name ends with [])
                        var checkboxName = name.replace('[]', '');
                        var checkboxes = document.querySelectorAll('input[name="' + name + '"]:checked');
                        var isChecked = checkboxes.length > 0;
                        
                        if (!isChecked) {
                            document.getElementById(divErrorID).classList.add('inputError');
                        } else {
                            // Check if "Others" checkbox is selected and validate text field
                            var othersCheckbox = document.getElementsByClassName("otherOption" + idd)[0];
                            if (othersCheckbox != undefined && othersCheckbox.checked) {
                                var otherField = document.getElementsByClassName("otherField" + idd)[0];
                                if (otherField != undefined) {
                                    if (otherField.value.trim() === "") {
                                        document.getElementById(divErrorID).classList.add('inputError');
                                    }
                                }
                            }
                        }
                    }
                } 
                // Validate select dropdowns
                else if (type == undefined && tag == 'SELECT') {
                    if (Qrequired == 1) {
                        if (subcat.value == null || subcat.value == "" || subcat.value === "") {
                            document.getElementById(divErrorID).classList.add('inputError');
                        }
                    }
                }
                
                // Validate radio-sub questions (fieldTypeID == 7)
                if (questionType == 'radio-sub') {
                    if (Qrequired == 1) {
                        var subQuestionDiv = document.getElementById(divErrorID);
                        if (subQuestionDiv) {
                            var subRadioButtons = subQuestionDiv.querySelectorAll('.QSub:checked');
                            if (subRadioButtons.length == 0) {
                                subQuestionDiv.classList.add('inputError');
                            }
                        }
                    }
                }
                
                // Validate checkbox-sub questions (fieldTypeID == 12)
                if (questionType == 'checkbox-sub') {
                    if (Qrequired == 1) {
                        var subQuestionDiv = document.getElementById(divErrorID);
                        if (subQuestionDiv) {
                            var subCheckboxes = subQuestionDiv.querySelectorAll('.QSub:checked');
                            if (subCheckboxes.length == 0) {
                                subQuestionDiv.classList.add('inputError');
                            }
                        }
                    }
                }
            });



        }

        var hasError = $(".inputError").length;


        if (hasError == 0) {
            validateForm();
            updateStepStatus();
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
        } else {
            var inputErrorElement = document.querySelector('.inputError');
            var target = null;
            if (inputErrorElement) {
                target = inputErrorElement.querySelector('label.control-label');
            }
            if (target != null && target != undefined) {
                var errorQuestion = target.innerHTML;

                swal.fire("Please Fill", errorQuestion, "error").then(() => {
                    // Get the inputError element (already found above)
                    // location.href="#questionnaire-intro";
                    if (inputErrorElement) {
                        var parentId = inputErrorElement.parentElement.id;
                        var stepNumber = parentId.replace('Step', '');
                        console.log(stepNumber);
                        var stepperId = 'Stepper' + stepNumber + 'ID';
                        if (stepperId) {
                            // Get the stepper element
                            var stepperElement = document.getElementById(stepperId);

                            if (stepperElement) {
                                // Click the stepper element
                                stepperElement.click();

                                // Set a timeout to scroll to the question ID
                                setTimeout(() => {
                                    // Get the ID of the inputError element
                                    var questionId = inputErrorElement.id;
                                    console.log(questionId);
                                    inputErrorElement.scrollIntoView({
                                        behavior: 'smooth',
                                        block: 'center'
                                    });
                                    // Set location.href to include the question ID as fragment identifier
                                    // location.href = "#" + questionId;
                                }, 500); // Adjust the delay time as needed
                            }
                        }
                    }
                });

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

    // var dataForm = $('form#divQuestionnaireForm').serializeArray();
    // var formData = {};
    // console.log(dataForm);
    // for (var i = 0; i < dataForm.length; i++) {
    //     formData[dataForm[i].name] = dataForm[i].value;
    //     var cccccc = dataForm[i].value;
    //     if (cccccc == '' || cccccc == null) {
    //         swal("Please Fill All Answers: ", "", "error");
    //         return false;
    //     }
    // }
    // alert('sub');
    // document.getElementById('divQuestionnaireForm').submit();
</script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        showStage('Step1', 1);
    });

    function showStage(stageId, step) {
        var tabContents = document.getElementsByClassName('tabcontent');
        for (var i = 0; i < tabContents.length; i++) {
            tabContents[i].style.display = 'none';
        }
        var tabLinks = document.getElementsByClassName('tablinks');
        for (var i = 0; i < tabLinks.length; i++) {
            tabLinks[i].classList.remove('active');
        }
        document.getElementById(stageId).style.display = 'block';
        document.getElementById('Tab' + stageId.charAt(stageId.length - 1)).classList.add('active');

        var stepperSteps = document.querySelectorAll('.stepper-horizontal .step');
        for (var i = 0; i < stepperSteps.length; i++) {
            stepperSteps[i].classList.remove('editing');
        }
        document.getElementById('Stepper' + step + 'ID').classList.add('editing');

        var prevButton = document.querySelector('#navPrev');
        var nextButton = document.querySelector('#navNext');
        //alert(step);
        // alert(divCount);
        prevButton.style.display = 'inline-block';
        nextButton.style.display = 'inline-block';
        if (step === 1) {
            prevButton.style.display = 'none'; // Hide previous button in the first stage
        } else if (step === divCount) {
            nextButton.style.display = 'none'; // Hide next button in the last stage
        } else {
            prevButton.style.display = 'inline-block';
            nextButton.style.display = 'inline-block';
        }
        validateForm()
    }

    function validateForm() {
        var steps = [];

        for (var i = 1; i <= divCount; i++) {
            steps.push('Step' + i);
        }
        var answeredQuestionsCount = 0;
        steps.forEach(element => {
            // console.log(element);
            var allQuestionsAnswered = true;

            $('#' + element + ' .divClass').each(function() {
                var questionType = $(this).data('question-type');
                var questionAnswered = false;
                if (questionType == 'text' || questionType == 'textarea') {
                    questionAnswered = $(this).find('textarea, input').val().trim() !== '';
                } else if (questionType == 'radio' || questionType == 'checkbox') {
                    questionAnswered = $(this).find('input:checked').length > 0;
                } else if (questionType == 'radio-sub') {
                    questionAnswered = $(this).find('.QSub:checked').length > 0;
                } else if (questionType == 'select') {
                    // questionAnswered = $(this).find('select').val() !== null;
                    questionAnswered = ($(this).find('select').val() !== null && $(this).find('select').val() !== '')
                    // console.log('select-val',$(this).find('select').val());
                } else if (questionType == 'checkbox-sub') {
                    questionAnswered = $(this).find('.QSub:checked').length > 0;
                }
                if (questionAnswered) {
                    answeredQuestionsCount++;
                    console.log('answeredQuestionsCount', answeredQuestionsCount);
                } else {
                    allQuestionsAnswered = false;
                }
            });

            var stepperID = element.replace('Step', '');
            console.log('valid', stepperID, allQuestionsAnswered);
            if (allQuestionsAnswered) {

                document.getElementById('Stepper' + stepperID + 'ID').classList.add('done');

            } else {
                document.getElementById('Stepper' + stepperID + 'ID').classList.remove('done');
            }
        });
        document.getElementById('complete_question').value = answeredQuestionsCount;
    }

    function navigate(direction) {
        var currentStep = document.querySelector('.stepper-horizontal .step.editing');
        var nextStep;
        if (direction === 'next') {
            nextStep = currentStep.nextElementSibling;
        } else if (direction === 'prev') {
            nextStep = currentStep.previousElementSibling;
        }

        if (nextStep) {
            var stepNumber = nextStep.querySelector('.step-circle span').textContent.trim(); // Retrieve the step number
            var stageId = 'Step' + stepNumber;
            showStage(stageId, parseInt(stepNumber));
            $('html,body').scrollTop(0);
        }
    }
</script>
<script>
    function showInput(nameField) {
        // Check if nameField exists and has elements
        if (!nameField || nameField.length === 0 || !nameField[0] || !nameField[0].id) {
            return;
        }
        
        var otherInput = document.getElementsByClassName("otherOption" + nameField[0].id);
        
        // Check if otherInput exists before accessing its properties
        if (!otherInput || otherInput.length === 0 || !otherInput[0]) {
            return;
        }
        
        for (var i = 0; i < nameField.length; i++) {
            if (nameField[i].checked) {
                if (nameField[i].value == 'Others') {
                    otherInput[0].style.display = "inline";
                    otherInput[0].style.border = "1px solid black";
                    otherInput[0].disabled = false;
                } else {
                    otherInput[0].style.display = "none";
                    otherInput[0].disabled = true;
                }
            }
        }
    }

    function showInputSub(nameField, option_question_fields_id) {
        // Check if nameField exists and has elements
        if (!nameField || nameField.length === 0) {
            return;
        }

        for (var i = 0; i < nameField.length; i++) {
            var othersub = $(nameField[i]).attr('othersub');
            var othersub_flag = $(nameField[i]).attr('other_flag');
            
            // Check if othersub attribute exists
            if (!othersub) {
                continue;
            }
            
            var otherInput = document.getElementsByClassName(othersub);
            var othersubinputElement = document.getElementsByClassName(othersub)[0];

            // Check if the input element exists before accessing its properties
            if (otherInput && otherInput.length > 0 && otherInput[0]) {
                if (nameField[i].checked) {
                    otherInput[0].style.display = "inline";
                    otherInput[0].style.border = "1px solid black";
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
            checkbox[0].style.border = "1px solid black";
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
        // console.log('response.length', response.length);
        if (response.length > 0) {
            QuestionnaireForm(response);
            // pagi_nation();
            // currentPagination('1');
        }
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

        var ttt = [];
        var pushNumcount = 0;
        for (let jk = 0; jk < DataFields.length; jk++) {
            var fId = DataFields[jk]['questionnaire_field_types_id'];
            if (fId == 9) {
                // console.log(DataFields[jk]);
                ttt.push(jk);
            }
        }

        var tab_count = Math.ceil(count / divCount);
        const tab_content = [0];
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
            // stage = '#Step1';
            // console.log(DataFields);
            // var questionNum = Number(index) + 1;
            stageQuestionCount++;
            var checkindex = index; //alert(checkindex);
            const fieldTypeID = DataFields[index]['questionnaire_field_types_id'];
            const fieldID = DataFields[index]['question_details_id'];
            const fieldLabel = DataFields[index]['question'];
            const fieldDescription = DataFields[index]['question_description'];
            const fieldName = DataFields[index]['question_field_name'];
            const fieldValue = DataFields[index][fieldName];
            const otherOption = DataFields[index]['other_option'];
            const requiredQuestion = DataFields[index]['required'];
            var fieldOptionsDB = <?php echo (json_encode($fieldOptionsDB)); ?>;
            var fieldQuestionsDB = <?php echo (json_encode($fieldQuestionsDB)); ?>;
            var options = <?php echo json_encode($options); ?>;
            if (fieldTypeID != 9) {
                questionIndex++
                var questionNum = questionIndex;
            } else {
                var questionNum = questionIndex;
            }
            if (fieldTypeID == 1) {
                var textboxHtml = '<div class="col-md-12 divClass newQuestion" data-question-type="text" id="div' + fieldName + '"><div class="form-group pagination-element' + num + '">';
                textboxHtml += '<label class="control-label ' + (requiredQuestion == 1 ? ' required' : '') + '">' + questionNum + ' . ' + fieldLabel + '</label>';
                if(fieldDescription != null && fieldDescription != undefined){
                    textboxHtml += '<p>' + fieldDescription + '</p>';
                }                
                if (fieldValue == null) {
                    textboxHtml += '<input class="form-control pagination' + num + '" type="text" id="' + fieldName + '" name="' + fieldName + '" placeholder="Your Answer" data-required="' + requiredQuestion + '"><i class="bar"></i>';
                } else {
                    textboxHtml += '<input class="form-control pagination' + num + '" type="text" value="' + fieldValue + '" id="' + fieldName + '" name="' + fieldName + '" placeholder="Your Answer" data-required="' + requiredQuestion + '"><i class="bar"></i>';
                }
                textboxHtml += '</div></div>';
                $(stage).append(textboxHtml);
            }

            if (fieldTypeID == 2) {
                var textboxHtml = '<div class="col-md-12 divClass newQuestion" data-question-type="textarea" id="div' + fieldName + '"><div class="form-group pagination-element' + num + '">';
                textboxHtml += '<label class="control-label ' + (requiredQuestion == 1 ? ' required' : '') + '">' + questionNum + ' . ' + fieldLabel + '</label>';
                if(fieldDescription != null && fieldDescription != undefined){
                    textboxHtml += '<p>' + fieldDescription + '</p>';
                }
                if (fieldValue == null) {
                    if (fieldID == 109) {
                        textboxHtml += '<input type="text" oninput="validateNumber(' + fieldName + ')" data-required="' + requiredQuestion + '" class="form-control pagination' + num + '" id="' + fieldName + '" name="' + fieldName + '" min="1" max="5">';
                    } else {
                        textboxHtml += '<textarea class="form-control pagination' + num + '" id="' + fieldName + '" name="' + fieldName + '" rows="2" cols="25" placeholder="Your Answer" data-required="' + requiredQuestion + '"></textarea>';
                    }
                } else {
                    if (fieldID == 109) {
                        textboxHtml += '<input type="text" oninput="validateNumber(' + fieldName + ')" data-required="' + requiredQuestion + '" class="form-control pagination' + num + '" id="' + fieldName + '" name="' + fieldName + '" min="1" max="5" value="' + fieldValue + '">';
                    } else {
                        textboxHtml += '<textarea class="form-control pagination' + num + '" id="' + fieldName + '" name="' + fieldName + '" rows="2" cols="25" placeholder="Your Answer" data-required="' + requiredQuestion + '">' + fieldValue + '</textarea>';
                    }
                }
                textboxHtml += '<i class="bar"></i>';
                textboxHtml += '</div></div>';
                $(stage).append(textboxHtml);
            }

            if (fieldTypeID == 3) {

                var response = fieldOptionsDB;
                var dropdownHtml = '<div class="col-md-12 divClass newQuestion" data-question-type="select" id="div' + fieldName + '"><div class="form-group pagination-element' + num + '">';
                dropdownHtml += '<label class="control-label ' + (requiredQuestion == 1 ? ' required' : '') + '">' + questionNum + ' . ' + fieldLabel + '</label>';
                if(fieldDescription != null && fieldDescription != undefined){
                    dropdownHtml += '<p>' + fieldDescription + '</p>';
                }
                dropdownHtml += '<select class="documentCategory pagination' + num + '" name="' + fieldName + '" id="' + fieldName + '" style="width: 50%;" data-required="' + requiredQuestion + '">';
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
                var currentOption2 = [];
                var radioButtonHtml = '<div class="col-md-12 divClass newQuestion" data-question-type="radio" id="div' + fieldName + '"><div class="form-radio pagination-element' + num + '">';
                radioButtonHtml += '<label class="control-label ' + (requiredQuestion == 1 ? ' required' : '') + '" >' + questionNum + ' . ' + fieldLabel + '</label><div class="radio">';
                if(fieldDescription != null && fieldDescription != undefined){
                    radioButtonHtml += '<p>' + fieldDescription + '</p>';
                }
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
                                // When option is selected and has other_flag, text box should be visible
                                // Check if fieldValue contains custom text (not in options list)
                                var textValue = (!checkOther2 && fieldValue != option_field_name) ? fieldValue : '';
                                radioButtonHtml += '<label><input style="margin-right: 10px;" class="pagination' + num + ' Qradio" other-flag=' + other_flag + ' othersub="otherOption_' + option_question_fields_id + '" type="radio" name="' + fieldName + '" id="' + fieldName + '" value="' + option_field_name + '" onclick="showInputSub(' + fieldName + ',' + option_question_fields_id + ')" checked data-required="' + requiredQuestion + '"><i class="helper"></i> ' + option_field_name;
                                radioButtonHtml += '<input type="text" class="otherOption_' + option_question_fields_id + ' otherOption' + fieldName + '" style="opacity: 1;display:inline;width: 589px;margin: -2px 0px 0px 80px;" name="' + fieldName + '" value="' + textValue + '" placeholder="If Yes please mention reason">';
                            } else {
                                radioButtonHtml += '<label><input style="margin-right: 10px;" class="pagination' + num + ' Qradio" other-flag=' + other_flag + ' othersub="otherOption_' + option_question_fields_id + '" type="radio" name="' + fieldName + '" id="' + fieldName + '" value="' + option_field_name + '" onclick="showInput(' + fieldName + ')" checked data-required="' + requiredQuestion + '"><i class="helper"></i> ' + option_field_name;
                            }
                            radioButtonHtml += '</label></div>';
                        } else {
                            radioButtonHtml += '<div class="radio">';
                            if (other_flag == 1) {
                                // When option is not selected but has other_flag, text box should be hidden
                                radioButtonHtml += '<label><input style="margin-right: 10px;" class="pagination' + num + ' Qradio" other-flag=' + other_flag + ' othersub="otherOption_' + option_question_fields_id + '" type="radio" name="' + fieldName + '" id="' + fieldName + '" value="' + option_field_name + '" onclick="showInputSub(' + fieldName + ',' + option_question_fields_id + ')" data-required="' + requiredQuestion + '" ><i class="helper"></i> ' + option_field_name;
                                radioButtonHtml += '<input type="text" class="otherOption_' + option_question_fields_id + ' otherOption' + fieldName + '" style="opacity: 1;display:none;width: 589px;margin: -2px 0px 0px 80px;" name="' + fieldName + '" placeholder="If Yes please mention reason">';
                            } else {
                                radioButtonHtml += '<label><input style="margin-right: 10px;" class="pagination' + num + ' Qradio" other-flag=' + other_flag + ' othersub="otherOption_' + option_question_fields_id + '" type="radio" name="' + fieldName + '" id="' + fieldName + '" value="' + option_field_name + '" onclick="showInput(' + fieldName + ')" data-required="' + requiredQuestion + '" ><i class="helper"></i> ' + option_field_name;
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
                        radioButtonHtml += '<label><input style="margin-right: 10px;" class="pagination' + num + ' Qradio" type="radio" name="' + fieldName + '" id="' + fieldName + '" value="Others" onclick="showInput(' + fieldName + ')" checked><i class="helper"></i> ' + (fieldID == '106' ? 'If yes, please mention the reason <br/>' : ' Others');
                        radioButtonHtml += '<input data-required="' + requiredQuestion + '" type="text" class="otherOption' + fieldName + '" value="' + fieldValue + '" ' + (fieldID == '106' ? 'style="opacity: 1;"' : 'style="opacity: 1;"') + ' name="' + fieldName + '">';
                        radioButtonHtml += '</label></div>';
                    } else {
                        radioButtonHtml += '<div class="radio">';
                        radioButtonHtml += '<label><input style="margin-right: 10px;" class="pagination' + num + ' Qradio" type="radio" name="' + fieldName + '" id="' + fieldName + '" value="Others" onclick="showInput(' + fieldName + ')"><i class="helper"></i> Others';
                        radioButtonHtml += '<input disabled data-required="' + requiredQuestion + '" type="text" class="otherOption' + fieldName + '" ' + (fieldID == '106' ? 'style="opacity: 1;display:none;"' : 'style="opacity: 1;display:none;"') + ' name="' + fieldName + '">';
                        radioButtonHtml += '</label></div>';
                    }
                }
                // console.log(currentOption);
                // 
                radioButtonHtml += '</div></div>';
                $(stage).append(radioButtonHtml);
            }
            if (fieldTypeID == 5) {
                var currentOption = [];
                var response = fieldOptionsDB;
                var obj;
                if (fieldValue != null || fieldValue != undefined) {
                    obj = JSON.parse(fieldValue);
                }
                if (obj != null) {
                    var cou = obj.length;
                }
                var radioButtonHtml = '<div class="col-md-12 divClass newQuestion" data-question-type="checkbox" id="div' + fieldName + '"><div class="form-group pagination-element' + num + '">';
                radioButtonHtml += '<label class="control-label ' + (requiredQuestion == 1 ? ' required' : '') + '">' + questionNum + ' . ' + fieldLabel + '</label><div class="checkbox">';
                if(fieldDescription != null && fieldDescription != undefined){
                    radioButtonHtml += '<p>' + fieldDescription + '</p>';
                }
                for (let index = 0; index < response.length; index++) {
                    const question_details_id = response[index]['question_details_id'];
                    const option_field_name = response[index]['option_for_question'];
                    // console.log('option_field_name - ' + questionNum, option_field_name)
                    if (question_details_id == fieldID) {
                        currentOption.push(option_field_name);
                        // console.log('obj', obj);
                        if (obj != undefined) {
                            // console.log('if');
                            var isChecked = (obj !== null && obj.includes(option_field_name));
                        } else {
                            // console.log('else');
                            var isChecked = false;
                            // console.log('isChecked' , isChecked);
                        }

                        radioButtonHtml += '<label><input data-required="' + requiredQuestion + '" class="pagination' + num + '" type="checkbox" name="' + fieldName + '[]" id="' + fieldName + '" value="' + option_field_name + '"';

                        if (isChecked) {
                            radioButtonHtml += ' checked';
                        }

                        radioButtonHtml += '><i class="helper"></i> ' + option_field_name + '</label><br>';
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
                    if (setcheckOther == true && missingValues != null) {
                        radioButtonHtml += '<label><input  class="pagination' + num + ' otherOption' + fieldName + '" type="checkbox" id="' + fieldName + '" onclick="showInputOthers(' + fieldName + ')" checked><i class="helper"></i>Others';
                        radioButtonHtml += '<input type="text"  class="otherField' + fieldName + '" value="' + missingValues + '" style="display:inline;opacity: 1;" name="' + fieldName + '[]"></label>';
                    } else {
                        radioButtonHtml += '<label><input  class="pagination' + num + ' otherOption' + fieldName + '" type="checkbox" id="' + fieldName + '" onclick="showInputOthers(' + fieldName + ')"><i class="helper" style="opacity: 0.1;"></i>Others';
                        radioButtonHtml += '<input type="text" disabled class="otherField' + fieldName + '" style="opacity: 1;display:none;" name="' + fieldName + '[]"></label>';
                    }
                }
                radioButtonHtml += '</div></div>';
                $(stage).append(radioButtonHtml);
            }

            if (fieldTypeID == 7) {
                var response = fieldQuestionsDB;
                var fieldOptions = response.fieldOptions;
                var fieldQuestions = response.fieldQuestions;
                var radioButtonHtml = '<div class="col-md-12 divClass newQuestion multi-question" data-question-type="radio-sub" id="div' + fieldName + '"><div class="form-group pagination-element' + num + '">';
                radioButtonHtml += '<label class="control-label ' + (requiredQuestion == 1 ? ' required' : '') + '">' + questionNum + ' . ' + fieldLabel + '</label><br>'; //Sub Question Radio
                if(fieldDescription != null && fieldDescription != undefined){
                    radioButtonHtml += '<p>' + fieldDescription + '</p>';
                }
                radioButtonHtml += '<table class="table_content" style="border: 1px solid black !important;">';
                radioButtonHtml += '<tr  style="border: 1px solid black !important;">';
                radioButtonHtml += '<th class="stickTd" width="30%"  style="border: 1px solid black !important;"></th>';
                for (let index = 0; index < fieldOptions.length; index++) {
                    const question_details_id = fieldOptions[index]['question_details_id'];
                    const option_field_name = fieldOptions[index]['option_for_question'];
                    if (question_details_id == fieldID)
                        // radioButtonHtml += '<label class="control-label q_lable">' + option_field_name + '</label>';
                        radioButtonHtml += '<th  style="border: 1px solid black !important;">' + option_field_name + '</th>';
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
                        radioButtonHtml += '<tr  style="border: 1px solid black !important;">';
                        radioButtonHtml += '<td class="stickTd"  style="border: 1px solid black !important;">' + sub_question + '</td>';
                        for (let index = 0; index < fieldOptions.length; index++) {
                            const question_details_id = fieldOptions[index]['question_details_id'];
                            const option_field_name = fieldOptions[index]['option_for_question'];
                            if (question_details_id == fieldID) {
                                if (questionValue == option_field_name) {
                                    // alert('asd');
                                    radioButtonHtml += '<td  style="border: 1px solid black !important;"><input style="height: 15px;" class="pagination' + num + ' QSub" type="radio" name="' + fieldName + sub_questions_id + '" id="' + fieldName + '" value="' + option_field_name + '" checked data-required="' + requiredQuestion + '"></td>';
                                } else {
                                    radioButtonHtml += '<td  style="border: 1px solid black !important;"><input style="height: 15px;" class="pagination' + num + ' QSub" type="radio" name="' + fieldName + sub_questions_id + '" id="' + fieldName + '" value="' + option_field_name + '" data-required="' + requiredQuestion + '"></td>';
                                }
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
                var dropdownHtml = '<div class="col-md-12 divClass newQuestion" data-question-type="select" id="div' + fieldName + '"><div class="form-group pagination-element' + num + '">';
                dropdownHtml += '<label class="control-label ' + (requiredQuestion == 1 ? ' required' : '') + '">' + questionNum + ' . ' + fieldLabel + '</label>';
                if(fieldDescription != null && fieldDescription != undefined){
                    dropdownHtml += '<p>' + fieldDescription + '</p>';
                }
                dropdownHtml += '<select class="documentCategory pagination' + num + '" data-required="' + requiredQuestion + '" name="' + fieldName + '" id="' + fieldName + '" style="width: 50%;">';
                dropdownHtml += '<option value=""> Choose </option>';
                for (let index = 0; index < response.length; index++) {
                    const question_details_id = fieldID;
                    const option = response[index]['option'];

                    if (question_details_id == fieldID)
                        if (fieldValue == option) {
                            dropdownHtml += "<option value='" + option + "' selected>" + option + "</option>";
                        } else {
                            dropdownHtml += "<option value='" + option + "'>" + option + "</option>";
                        }
                    // dropdownHtml += option;
                }
                dropdownHtml += '</select><i class="bar" style="width: 50%;"></i></div></div>';
                $(stage).append(dropdownHtml);

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
                if(fieldDescription != null && fieldDescription != undefined){
                    radioButtonHtml += '<p>' + fieldDescription + '</p>';
                }  
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
                var radioButtonHtml = '<div class="col-md-12 divClass newQuestion multi-question" data-question-type="checkbox-sub" id="div' + fieldName + '"><div class="form-group pagination-element' + num + '">';
                radioButtonHtml += '<label class="control-label ' + (requiredQuestion == 1 ? ' required' : '') + '">' + questionNum + ' . ' + fieldLabel + '</label><br>'; //Sub Question Radio
                if(fieldDescription != null && fieldDescription != undefined){
                    radioButtonHtml += '<p>' + fieldDescription + '</p>';
                }
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
                                        radioButtonHtml += '<td style="border: 1px solid black !important;"><input data-required="' + requiredQuestion + '" style="height: 15px;" class="pagination' + num + ' QSub" type="checkbox" name="' + fieldName + sub_questions_id + '[]" id="' + fieldName + '" value="' + option_field_name + '" checked></td>';
                                    } else {
                                        radioButtonHtml += '<td style="border: 1px solid black !important;"><input data-required="' + requiredQuestion + '" style="height: 15px;" class="pagination' + num + ' QSub" type="checkbox" name="' + fieldName + sub_questions_id + '[]" id="' + fieldName + '" value="' + option_field_name + '"></td>';
                                    }
                                } else {
                                    radioButtonHtml += '<td style="border: 1px solid black !important;"><input data-required="' + requiredQuestion + '" style="height: 15px;" class="pagination' + num + ' QSub" type="checkbox" name="' + fieldName + sub_questions_id + '[]" id="' + fieldName + '" value="' + option_field_name + '"></td>';
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

    function updateStepStatus() {
        var steps = document.querySelectorAll('.step');
        var allQuestionsFilled = true;

        // Loop through each step
        steps.forEach(function(step, index) {
            var questions = document.querySelectorAll('.newQuestion[data-step="' + (index + 1) + '"] input[data-required="1"]');
            var stepIsDone = true;

            // Loop through each question in the step
            questions.forEach(function(question) {
                if (!question.value.trim()) {
                    stepIsDone = false;
                }
            });

            // Update step status
            if (stepIsDone) {
                step.classList.add('done');
            } else {
                step.classList.remove('done');
                allQuestionsFilled = false;
            }
        });

        // Apply CSS if all questions are filled in all steps
        if (allQuestionsFilled) {
            document.querySelectorAll('.step').forEach(function(step) {
                step.querySelector('.step-circle').classList.add('done');
            });
        } else {
            document.querySelectorAll('.step').forEach(function(step) {
                step.querySelector('.step-circle').classList.remove('done');
            });
        }
    }
</script>
<script>
    function validateNumber(ijk) {
        var inputValue = ijk.value;
        inputValue = inputValue.replace(/\D/g, '');
        var numericValue = parseInt(inputValue);

        if (isNaN(numericValue) || numericValue < 1 || numericValue > 10) {
            swal.fire("Info", "Value must be between 1 and 10", "info");
            ijk.value = "";
        } else {
            // swal.fire("Info", "Value must be between 1 and 10", "info");
            ijk.value = numericValue;
        }
    }
</script>
@endsection