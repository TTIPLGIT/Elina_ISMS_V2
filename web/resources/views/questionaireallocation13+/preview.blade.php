@extends('layouts.adminnav')

@section('content')


<div class="main-content">
    <section class="section">


        <div class="section-body mt-1">
        <h3 class="text-center" style="color:darkblue;">Questionnaire Preview</h3>
            <div id="reportDiv">
                <iframe src="http://localhost:60161/referral_report/preview.pdf" frameborder="0" style="width:100%; height:600px;"></iframe>

            </div>
            <div class="col-md-12" style="display: flex;justify-content: center;">
                <a type="button" class="btn btn-labeled back-btn" title="Back" href="{{ route('questionnaire_allocation13.edit','1') }}" style="color:white !important">
                    <span class="btn-label" style="font-size:13px !important;"><i class="fa fa-arrow-left"></i></span> Back</a>

            </div>
        </div>
    </section>
</div>
<script>
    function findNearestClosingTagIndex(htmlString, index) {
        let stack = [];
        for (let i = index; i < htmlString.length; i++) {
            if (htmlString[i] === '<') {
                if (htmlString[i + 1] === '/') {
                    let tagName = '';
                    for (let j = i + 2; j < htmlString.length; j++) {
                        if (htmlString[j] === '>') {
                            break;
                        }
                        tagName += htmlString[j];
                    }
                    if (stack.length > 0 && stack[stack.length - 1] === tagName) {
                        stack.pop();
                    } else {
                        return i; // Return the index of the closing tag
                    }
                } else {
                    let tagName = '';
                    for (let j = i + 1; j < htmlString.length; j++) {
                        if (htmlString[j] === '>' || htmlString[j] === ' ') {
                            break;
                        }
                        tagName += htmlString[j];
                    }
                    stack.push(tagName);
                }
            }
        }
        return -1; // No matching closing tag found
    }
</script>
<script>
    const tdElements = document.querySelectorAll('td[rowspan]');
    var formElements = document.querySelectorAll('.form-group input, .form-group textarea');

    // Loop through each form element and apply styles
    formElements.forEach(function(element) {
        element.style.display = 'block';
        element.style.background = 'none';
        element.style.padding = '0.125rem 0.125rem 0.0625rem';
        element.style.fontSize = '1rem';
        element.style.borderWidth = '0';
        element.style.borderColor = 'transparent';
        element.style.lineHeight = '1.9';
        element.style.width = '100%';
        element.style.color = 'transparent';
        element.style.transition = 'all 0.28s ease';
        element.style.boxShadow = 'none';
    });

    // Wait for the DOM to be fully loaded

    // Select all select elements within the class '.form-group'
    var selectElements = document.querySelectorAll('.form-group select');

    // Apply styles to each selected select element
    selectElements.forEach(function(selectElement) {
        selectElement.style.width = '50%';
        selectElement.style.fontSize = '1rem';
        selectElement.style.height = '1.6rem';
        selectElement.style.padding = '0.125rem 0.125rem 0.0625rem';
        selectElement.style.background = 'none';
        selectElement.style.border = 'none';
        selectElement.style.lineHeight = '1.6';
        selectElement.style.boxShadow = 'none';
    });


    // Wait for the DOM to be fully loaded

    // Select all elements with the class '.form-control'
    var formControlElements = document.querySelectorAll('.form-control');

    // Apply styles to each selected form control element
    formControlElements.forEach(function(formControlElement) {
        formControlElement.style.padding = '8px 10px !important';
        formControlElement.style.fontSize = '14px';
        formControlElement.style.height = '41px';
        formControlElement.style.background = '#e2e4e6 !important';
        formControlElement.style.color = '#0a0000 !important';
        formControlElement.style.borderColor = '#bec4d0 !important';
        formControlElement.style.boxShadow = '2px 2px 4px rgba(0, 0, 0, 0.15)';
        formControlElement.style.borderStyle = 'outset';
        formControlElement.style.display = 'block';
        formControlElement.style.width = '100%';
        formControlElement.style.height = 'calc(1.5em + 0.75rem + 2px)';
        formControlElement.style.padding = '0.375rem 0.75rem';
        formControlElement.style.fontSize = '1rem';
        formControlElement.style.fontWeight = '400';
        formControlElement.style.lineHeight = '1.5';
        formControlElement.style.backgroundColor = '#fff';
        formControlElement.style.backgroundClip = 'padding-box';
        formControlElement.style.border = '1px solid #ced4da';
        formControlElement.style.borderRadius = '0.25rem';
        formControlElement.style.webkitTransition = 'border-color .15s ease-in-out,-webkit-box-shadow .15s ease-in-out';
        formControlElement.style.transition = 'border-color .15s ease-in-out,-webkit-box-shadow .15s ease-in-out';
        formControlElement.style.transition = 'border-color .15s ease-in-out,box-shadow .15s ease-in-out';
        formControlElement.style.transition = 'border-color .15s ease-in-out,box-shadow .15s ease-in-out,-webkit-box-shadow .15s ease-in-out';
    });



    // Get the elements with the specified classes
    var formRadio = document.querySelector('.form-radio');
    var formGroup = document.querySelector('.form-group');

    // Apply styles to the elements
    if (formRadio) {
        formRadio.style.position = 'relative';
        formRadio.style.marginTop = '2.25rem';
        formRadio.style.marginBottom = '2.25rem';
    }

    // if (formGroup) {
    //   formGroup.style.position = 'relative';
    //   formGroup.style.marginTop = '2.25rem';
    //   formGroup.style.marginBottom = '2.25rem';
    // }
    // Get the elements with the specified classes
    var formGroupElements = document.querySelectorAll('.form-inline > .form-group');
    var btnElements = document.querySelectorAll('.form-inline > .btn');

    // Apply styles to form group elements
    formGroupElements.forEach(function(element) {
        element.style.display = 'inline-block';
        element.style.marginBottom = '0';
    });

    // Apply styles to button elements
    btnElements.forEach(function(element) {
        element.style.display = 'inline-block';
        element.style.marginBottom = '0';
    });
    var formHelpElement = document.querySelector('.form-help');

    // Apply styles to the element
    if (formHelpElement) {
        formHelpElement.style.marginTop = '0.125rem';
        formHelpElement.style.marginLeft = '0.125rem';
        formHelpElement.style.color = '#b3b3b3';
        formHelpElement.style.fontSize = '0.8rem';
    }
    // Get the elements with the specified classes
    var checkboxFormHelp = document.querySelector('.checkbox .form-help');
    var radioFormHelp = document.querySelector('.form-radio .form-help');
    var formGroupFormHelp = document.querySelector('.form-group .form-help');

    // Apply styles to checkbox form help
    if (checkboxFormHelp) {
        checkboxFormHelp.style.position = 'absolute';
        checkboxFormHelp.style.width = '100%';
    }

    // Apply styles to radio form help
    if (radioFormHelp) {
        radioFormHelp.style.position = 'absolute';
        radioFormHelp.style.width = '100%';
    }

    // Apply styles to form group form help
    if (formGroupFormHelp) {
        formGroupFormHelp.style.position = 'absolute';
        formGroupFormHelp.style.width = '100%';
    }
    var checkboxFormHelp = document.querySelector('.checkbox .form-help');

    // Apply styles to checkbox form help
    if (checkboxFormHelp) {
        checkboxFormHelp.style.position = 'relative';
        checkboxFormHelp.style.marginBottom = '1rem';
    }
    // Get the element with the specified class
    var radioFormHelp = document.querySelector('.form-radio .form-help');

    // Apply styles to radio form help
    if (radioFormHelp) {
        radioFormHelp.style.paddingTop = '0.25rem';
        radioFormHelp.style.marginTop = '-1rem';
    }

    // Wait for the DOM to be fully loaded

    // Select all input elements within the class '.form-group'
    var inputElements = document.querySelectorAll('.form-group input');

    // Select all textarea elements within the class '.form-group'
    var textareaElements = document.querySelectorAll('.form-group textarea');

    // Select all bar elements within the class '.form-group'
    // var barElements = document.querySelectorAll('.form-group.bar');

    // Apply styles to input elements
    inputElements.forEach(function(inputElement) {

        inputElement.style.height = '1.9rem';

    });

    // Apply styles to textarea elements
    textareaElements.forEach(function(textareaElement) {

        textareaElement.style.resize = 'none';

    });
    var barElements = document.querySelectorAll('.form-group .bar');

    // Apply styles to bar elements
    barElements.forEach(function(barElement) {
        barElement.style.position = 'relative';
        barElement.style.borderBottom = '0.0625rem solid #999';
        barElement.style.display = 'block';

    });

    // Apply styles to bar::before elements
    var barBeforeElements = document.querySelectorAll('.form-group .bar::before');
    barBeforeElements.forEach(function(barBeforeElement) {
        if (barBeforeElement) {
            barBeforeElement.style.content = '""';
            barBeforeElement.style.height = '0.125rem';
            barBeforeElement.style.width = '0';
            barBeforeElement.style.left = '50%';
            barBeforeElement.style.bottom = '-0.0625rem';
            barBeforeElement.style.position = 'absolute';
            barBeforeElement.style.background = '#337ab7';
            barBeforeElement.style.transition = 'left 0.28s ease, width 0.28s ease';
            barBeforeElement.style.zIndex = '2';
        }
    });


    // Get the elements with the specified class and type
    var fileInput = document.querySelector('.form-group input[type="file"]');
    // var selectInput = document.querySelector('.form-group select');
    var textInputs = document.querySelectorAll('.form-group input, .form-group textarea');
    var controlLabels = document.querySelectorAll('.form-group .control-label');
    var bars = document.querySelectorAll('.form-group .bar');

    // Apply styles to file input
    if (fileInput) {
        fileInput.style.lineHeight = '1';
    }


    // Apply styles to text inputs
    textInputs.forEach(function(input) {
        input.style.color = '#333';
    });

    // Apply styles to control labels
    controlLabels.forEach(function(label) {
        label.style.fontSize = '0.8rem';
        label.style.color = 'gray';
        label.style.top = '-1rem';
        label.style.left = '0';
    });

    // // Apply styles to bars
    // bars.forEach(function (bar) {
    //   bar.style.display = 'none';
    // });
    // Get the elements with the specified classes
    var checkboxLabel = document.querySelector('.checkbox label');
    var radioLabel = document.querySelector('.form-radio label');
    var checkboxInput = document.querySelector('.checkbox input');
    var radioInput = document.querySelector('.form-radio input');

    // Apply styles to checkbox label
    if (checkboxLabel) {
        checkboxLabel.style.position = 'relative';
        checkboxLabel.style.cursor = 'pointer';
        checkboxLabel.style.paddingLeft = '2rem';
        checkboxLabel.style.textAlign = 'left';
        checkboxLabel.style.color = '#333';
        checkboxLabel.style.display = 'block';
    }

    // Apply styles to radio label
    if (radioLabel) {
        radioLabel.style.position = 'relative';
        radioLabel.style.cursor = 'pointer';
        radioLabel.style.paddingLeft = '2rem';
        radioLabel.style.textAlign = 'left';
        radioLabel.style.color = '#333';
        radioLabel.style.display = 'block';
    }

    // Apply styles to checkbox input
    if (checkboxInput) {
        checkboxInput.style.width = 'auto';
        checkboxInput.style.opacity = '0.00000001';
        checkboxInput.style.position = 'absolute';
        checkboxInput.style.left = '0';
    }

    // Apply styles to radio input
    if (radioInput) {
        radioInput.style.width = 'auto';
        radioInput.style.opacity = '0.00000001';
        radioInput.style.position = 'absolute';
        radioInput.style.left = '0';
    }
    // Get the elements with the specified class
    var radioContainer = document.querySelector('.radio');
    var radioInput = document.querySelector('.radio input');
    var radioHelper = document.querySelector('.radio .helper');

    // Apply styles to radio container
    if (radioContainer) {
        radioContainer.style.marginBottom = '1rem';
    }

    // Apply styles to radio helper
    if (radioHelper) {
        radioHelper.style.position = 'absolute';
        radioHelper.style.top = '-0.25rem';
        radioHelper.style.left = '-0.25rem';
        radioHelper.style.cursor = 'pointer';
        radioHelper.style.display = 'block';
        radioHelper.style.fontSize = '1rem';
        radioHelper.style.userSelect = 'none';
        radioHelper.style.color = '#999';
    }

    // Add event listener to radio input for hover effect
    if (radioInput) {
        radioInput.addEventListener('mouseover', function() {
            if (radioHelper) {
                radioHelper.style.color = '#337ab7';
            }
        });

        radioInput.addEventListener('mouseout', function() {
            if (radioHelper) {
                radioHelper.style.color = '#999';
            }
        });

        // Add event listener to radio input for checked effect
        radioInput.addEventListener('change', function() {
            if (radioInput.checked) {
                if (radioHelper) {
                    radioHelper.style.color = '#337ab7';
                }
            }
        });
    }
    // Get the elements with the specified class and type
    var checkboxContainer = document.querySelector('.checkbox');
    var checkboxInput = document.querySelector('.checkbox input');
    var checkboxLabel = document.querySelector('.checkbox label');
    var checkboxHelper = document.querySelector('.checkbox .helper');

    // Apply styles to checkbox container
    if (checkboxContainer) {
        checkboxContainer.style.fontSize = '1rem';
        checkboxContainer.style.lineHeight = '1.1';
    }

    // Apply styles to checkbox helper
    if (checkboxHelper) {
        checkboxHelper.style.color = '#999';
        checkboxHelper.style.position = 'absolute';
        checkboxHelper.style.top = '0';
        checkboxHelper.style.left = '0';
        checkboxHelper.style.width = '1rem';
        checkboxHelper.style.height = '1rem';
        checkboxHelper.style.zIndex = '0';
        checkboxHelper.style.border = '0.125rem solid currentColor';
        checkboxHelper.style.borderRadius = '0.0625rem';
        checkboxHelper.style.transition = 'border-color 0.28s ease';
    }

    // Add event listener to checkbox label for hover effect
    if (checkboxLabel) {
        checkboxLabel.addEventListener('mouseover', function() {
            if (checkboxHelper) {
                checkboxHelper.style.color = '#337ab7';
            }
        });

        checkboxLabel.addEventListener('mouseout', function() {
            if (checkboxHelper) {
                checkboxHelper.style.color = '#999';
            }
        });
    }

    // Add event listener to checkbox input for checked effect
    if (checkboxInput) {
        checkboxInput.addEventListener('change', function() {
            if (checkboxInput.checked) {
                if (checkboxHelper) {
                    checkboxHelper.style.color = '#337ab7';
                }
            }
        });
    }
    // Example: Apply styles to .radio + .radio
    var radioSiblings = document.querySelectorAll('.radio + .radio');
    if (radioSiblings.length > 0) {
        radioSiblings.forEach(function(radio) {
            radio.style.marginTop = '1rem';
        });
    }

    // Example: Apply styles to .checkbox + .checkbox
    var checkboxSiblings = document.querySelectorAll('.checkbox + .checkbox');
    if (checkboxSiblings.length > 0) {
        checkboxSiblings.forEach(function(checkbox) {
            checkbox.style.marginTop = '1rem';
        });
    }
    // Apply the specified styles using JavaScript

    // Example: Apply styles to .has-error .legend.legend and .has-error.form-group .control-label.control-label
    var errorLegends = document.querySelectorAll('.has-error .legend.legend, .has-error.form-group .control-label.control-label');
    if (errorLegends.length > 0) {
        errorLegends.forEach(function(element) {
            element.style.color = '#d9534f';
        });
    }

    // Example: Apply styles to .has-error.form-group .form-help, .has-error.form-group .helper, and other similar elements
    var errorHelpers = document.querySelectorAll('.has-error.form-group .form-help, .has-error.form-group .helper, .has-error.checkbox .form-help, .has-error.checkbox .helper, .has-error.radio .form-help, .has-error.radio .helper, .has-error.form-radio .form-help, .has-error.form-radio .helper');
    if (errorHelpers.length > 0) {
        errorHelpers.forEach(function(element) {
            element.style.color = '#d9534f';
        });
    }
    // Example: Apply styles to .has-error .bar::before
    var errorBarBefore = document.querySelector('.has-error .bar::before');
    if (errorBarBefore) {
        errorBarBefore.style.background = '#d9534f';
        errorBarBefore.style.left = '0';
        errorBarBefore.style.width = '100%';
    }
    // Apply the specified styles using JavaScript

    // Example: Apply styles to .form-group .control-label, .form-group > label, and #attach
    var controlLabels = document.querySelectorAll('.form-group .control-label');
    var directLabels = document.querySelectorAll('.form-group > label');
    var attachElement = document.getElementById('attach');

    if (controlLabels.length > 0) {
        controlLabels.forEach(function(element) {
            element.style.paddingBottom = '10px';
        });
    }

    if (directLabels.length > 0) {
        directLabels.forEach(function(element) {
            element.style.paddingBottom = '10px';
        });
    }

    if (attachElement) {
        attachElement.style.paddingBottom = '10px';
    }
    // Apply the specified styles using JavaScript

    // Example: Apply styles to .form-radio .control-label, .form-group > label, and #attach
    var radioControlLabels = document.querySelectorAll('.form-radio .control-label');
    var directLabels = document.querySelectorAll('.form-group > label');
    var attachElement = document.getElementById('attach');

    if (radioControlLabels.length > 0) {
        radioControlLabels.forEach(function(element) {
            element.style.fontWeight = '800';
            element.style.color = '#34395e';
            element.style.fontSize = '15px';
        });
    }

    if (directLabels.length > 0) {
        directLabels.forEach(function(element) {
            element.style.fontWeight = '800';
            element.style.color = '#34395e';
            element.style.fontSize = '15px';
        });
    }

    if (attachElement) {
        attachElement.style.fontWeight = '800';
        attachElement.style.color = '#34395e';
        attachElement.style.fontSize = '15px';
    }
    var loaderDiv = document.querySelector('.loader_div');
    if (loaderDiv) {
        loaderDiv.style.position = 'absolute';
        loaderDiv.style.top = '0';
        loaderDiv.style.bottom = '0%';
        loaderDiv.style.left = '0';
        loaderDiv.style.right = '0%';
        loaderDiv.style.zIndex = '99';
        loaderDiv.style.opacity = '0.7';
        loaderDiv.style.display = 'none';
        loaderDiv.style.background = 'url("../images/loaderajax.gif") center center no-repeat rgb(249, 249, 249)';
    }
    // Example: Apply styles to .radio[disabled]
    var disabledRadio = document.querySelector('.radio[disabled]');
    if (disabledRadio) {
        disabledRadio.style.backgroundColor = '#FFFFFF';
    }
    document.addEventListener("DOMContentLoaded", function() {
        // Wait for the DOM to be fully loaded

        // Select all elements with class names .pagination1, .pagination2, .pagination3, .pagination4
        var paginationElements = document.querySelectorAll('.pagination1, .pagination2, .pagination3, .pagination4');

        // Apply styles to each selected element
        paginationElements.forEach(function(element) {
            // element.style.padding = '20px';
            element.style.display = 'flex';
            element.style.justifyContent = 'center';
        });
    });

    // Wait for the DOM to be fully loaded

    // Select all elements with the specified class names and their descendants
    var elementsWithUserSelectNone = document.querySelectorAll('.pagination1, .pagination2, .pagination3, .pagination4, .pagination1 *, .pagination2 *, .pagination3 *, .pagination4 *');

    // Apply styles to each selected element
    elementsWithUserSelectNone.forEach(function(element) {
        element.style.webkitUserSelect = 'none';
        element.style.mozUserSelect = 'none';
        element.style.msUserSelect = 'none';
        element.style.userSelect = 'none';
    });


    // Wait for the DOM to be fully loaded

    // Select all anchor elements within the specified class names
    var anchorElements = document.querySelectorAll('.pagination1 a, .pagination2 a, .pagination3 a, .pagination4 a');

    // Apply styles to each selected anchor element
    anchorElements.forEach(function(anchor) {
        anchor.style.display = 'inline-block';
        anchor.style.padding = '0 10px';
        anchor.style.cursor = 'pointer';
    });


    document.addEventListener("DOMContentLoaded", function() {
        // Wait for the DOM to be fully loaded

        // Select all anchor elements with the class 'disabled' within the specified class names
        var disabledAnchorElements = document.querySelectorAll('.pagination1 a.disabled, .pagination2 a.disabled, .pagination3 a.disabled, .pagination4 a.disabled');

        // Apply styles to each selected disabled anchor element
        disabledAnchorElements.forEach(function(disabledAnchor) {
            disabledAnchor.style.opacity = '0.3';
            disabledAnchor.style.pointerEvents = 'none';
            disabledAnchor.style.cursor = 'not-allowed';
        });
    });

    // Wait for the DOM to be fully loaded

    // Select all anchor elements with the class 'current' within the specified class names
    var currentAnchorElements = document.querySelectorAll('.pagination1 a.current, .pagination2 a.current, .pagination3 a.current, .pagination4 a.current');

    // Apply styles to each selected current anchor element
    currentAnchorElements.forEach(function(currentAnchor) {
        currentAnchor.style.background = '#f3f3f3';
        currentAnchor.style.borderRadius = '4px';
        currentAnchor.style.backgroundColor = '#16425b';
        currentAnchor.style.color = '#f3f4f2';
    });


    // Wait for the DOM to be fully loaded

    // Select all anchor elements with the class 'current' on hover within the specified class names
    var currentAnchorHoverElements = document.querySelectorAll('.pagination1 a.current:hover, .pagination2 a.current:hover, .pagination3 a.current:hover, .pagination4 a.current:hover');

    // Apply styles to each selected current anchor on hover element
    currentAnchorHoverElements.forEach(function(currentAnchorHover) {
        currentAnchorHover.style.backgroundColor = '#16425b';
    });





    var htmlContent = document.getElementById('reportDiv').innerHTML;
    // console.log(htmlContent);
    document.getElementById('report').value = htmlContent;
    // console.log(document.getElementById('report').value);
    //    document.getElementById('submitForm').submit();
</script>

@endsection