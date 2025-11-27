@extends('layouts.adminnav')

@section('content')

<style>
    .question {
        background-color: white;
        border-radius: 12px !important;
        margin-top: 2rem;
        padding: 5px !important;
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

    hr {
        width: 100%;
        border: 2px solid;
    }
</style>
<div class="main-content">
    <div class="section-body mt-0">
        <h4 style="text-align: center;color: darkblue;"> Performance Area Master Create </h4>

        <form class="form-horizontal" name="questionnaire_form" id="questionnaire_form" method="POST" action="{{ route('performancearea.store') }}" onsubmit="return validateForm()">
            @csrf

            <div class="card question">
                <div class="row">
                    <div class="col-md-6" style="margin: 15px 0px 0px 0px;">
                        <div class="form-group">
                            <label class="control-label required">Main Skill</label>
                            <select class="form-control" name="table_num" id="table_num" onchange="table_column(event)">
                                <option value="">Select Skill</option>
                                <option value="1">Gross Motor</option>
                                <option value="2">Fine Motor Skills</option>
                                <option value="3">Cognition Skills</option>
                                <option value="4">Emotional Skills</option>
                                <option value="5">Communication Skills</option>
                                <option value="6">Play</option>
                                <option value="7">ADL</option>
                            </select>
                        </div>
                    </div>
                    <div class="w-100"></div>
                    <div class="row question" id="mainDiv" style="display: none;">
                        <div class="col-md-12 form-group" id="sub_skill1" style="display: none;"><label class="control-label">Sub Skill Name</label><button class="btn btn-danger pull-right" id="remove-subskill" order="1" type='button'>X</button><input type="text" class="form-control default" name="sub_skill_name[row1]"></div>
                        <div class="col-md-6" id="table_column">
                            <div class="form-group">
                                <label class="control-label required">Activity</label>
                                <div class="multi-field-wrapper">
                                    <div class="multi-fields">
                                        <div class="multi-field" style="display: flex;margin-bottom: 5px;">
                                            <input type="text" class="form-control default" name="activity[row1][]" id="activity">
                                            <button class="remove-field btn btn-danger pull-right" id="remove-f" type='button'>X </button>
                                            &nbsp;
                                        </div>
                                    </div>
                                    <button type="button" class="add-field btn btn-success">Add Activity</button>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6" id="table_column1">
                            <div class="form-group">
                                <label class="control-label required">Observation</label>
                                <div class="multi-field-wrapper">
                                    <div class="multi-fields">
                                        <div class="multi-field" style="display: flex;margin-bottom: 5px;">
                                            <input type="text" class="form-control default" name="observation[row1][]" id="observation">
                                            <button class="remove-field btn btn-danger pull-right" id="remove-f" type='button'>X </button>
                                            &nbsp;
                                        </div>
                                    </div>
                                    <button type="button" class="add-field btn btn-success">Add Observation</button>
                                </div>
                            </div>
                        </div>
                        <div class="row" id="subDiv1"></div>
                        <div class="row text-center" style="margin:10px;">
                            <div class="col-md-12 ">
                                <a href="#" onclick="add_skill('1')" class="btn btn-info">Add Sub Skill</a>
                            </div>
                        </div>

                    </div>
                </div>
            </div>



            <div id="elements">

            </div>

            <div class="row text-center" style="margin:10px;">
                <div class="col-md-12">
                    <a href="#" id="add-todo-item" class="btn btn-primary" style="display: none;">Add Skill</a>
                    <button class="btn btn-success" type="submit"><i class="fa fa-check"></i> Submit</button>&nbsp;
                </div>
            </div>
        </form>
    </div>
</div>
</div>

<script type="text/javascript">
    $(document).ready(function() {

        tinymce.init({
            selector: 'textarea#questionnaire_description',
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

    $('.multi-field-wrapper').each(function() {

        var $wrapper = $('.multi-fields', this);
        console.log($wrapper);


        $(".add-field", $(this)).click(function(e) {
            $('.multi-field:first-child', $wrapper).clone(true).appendTo($wrapper).find('input').val('').focus();
            $('#file_field').append('<div class="multi-field" style="display: flex;margin-bottom: 5px;"><input class="form-control" type="text" id="file" name="file" autocomplete="off"></div>');
        });

        $('.multi-field .remove-field', $wrapper).click(function() {
            if ($('.multi-field', $wrapper).length > 1)
                $(this).parent('.multi-field').remove();

            else bootbox.alert({
                title: "Metadata creation",
                centerVertical: true,
                message: "Required one Dropdown Option",
            });


        });
    });

    var count = 0;

    function addElement() {
        count = $('#mainDiv').length + 1;
        var div = '<div class="card row question" id="mainDiv">';
        div += '<div class="col-md-12 form-group" id="sub_skill_main' + count + '"><label class="control-label">Skill Name</label><button class="btn btn-danger pull-right" id="remove-subskill_main" order="' + count + '" type="button">X</button><input type="text" class="form-control default" name="skill_name_main[row' + count + ']"></div>';
        div += '<div class="col-md-12 form-group" id="sub_skill' + count + '" style="display:none"><label class="control-label">Sub Skill Name</label><button class="btn btn-danger pull-right" id="remove-subskill" order="' + count + '" type="button">X</button><input type="text" class="form-control default" name="sub_skill_name[row' + count + '][]"></div>';
        div += '<div class="col-md-6" id="table_column"><div class="form-group"><label class="control-label required">Activity</label><div class="multi-field-wrapper"><div class="multi-fields"><div class="multi-field" style="display: flex;margin-bottom: 5px;">';
        div += '<input type="text" class="form-control default" name="activity[row' + count + '][]" id="activity"><button class="remove-field btn btn-danger pull-right" id="remove-f" type="button">X </button>&nbsp;</div></div><button type="button" class="add-field btn btn-success">Add Activity</button></div></div></div>';
        div += '<div class="col-md-6" id="table_column1"><div class="form-group"><label class="control-label required">Observation</label><div class="multi-field-wrapper"><div class="multi-fields"><div class="multi-field" style="display: flex;margin-bottom: 5px;">';
        div += '<input type="text" class="form-control default" name="observation[row' + count + '][]" id="observation"><button class="remove-field btn btn-danger pull-right" id="remove-f" type="button">X </button>&nbsp;</div></div><button type="button" class="add-field btn btn-success">Add Observation</button></div></div></div>';
        div += '<div class="row" id="subDiv' + count + '"></div>';
        div += '<div class="row text-center" style="margin:10px;"><div class="col-md-12 "><a href="#" onclick="add_skill(' + count + ')" class="btn btn-info">Add Sub Skill</a></div></div>';
        $("#elements").append(div);
    }

    function add_sub_skill(rowID) {
        count1 = $('.subDivc' + rowID).length + 1;
        var sub = '<div class="row subDivc' + rowID + '" id="subDivc' + rowID + '" style="border: 1px solid;border-radius: 5px;padding: 10px;"><div class="col-md-12 form-group"><label class="control-label">Skill Name</label><button class="btn btn-danger pull-right" id="remove-subskill" type="button">X</button><input type="text" class="form-control default" name="sub_skill_name[row' + rowID + '][]"></div>';
        sub += '<div class="col-md-6"><div class="form-group"><label class="control-label required">Activity</label><div class="multi-field-wrapper"><div class="multi-fields"><div class="multi-field" style="display: flex;margin-bottom: 5px;">';
        sub += '<input type="text" class="form-control default" name="sub_activity[row' + rowID + '][' + count1 + '][]" id="activity"><button class="remove-field btn btn-danger pull-right" id="remove-f" type="button">X </button>&nbsp;';
        sub += '</div></div><button type="button" class="add-field btn btn-success">Add Activity</button></div></div></div>';
        sub += '<div class="col-md-6"><div class="form-group"><label class="control-label required">Observation</label><div class="multi-field-wrapper"><div class="multi-fields"><div class="multi-field" style="display: flex;margin-bottom: 5px;">';
        sub += '<input type="text" class="form-control default" name="sub_observation[row' + rowID + '][' + count1 + '][]" id="observation"><button class="remove-field btn btn-danger pull-right" id="remove-f" type="button">X </button>&nbsp;';
        sub += '</div></div><button type="button" class="add-field btn btn-success">Add Observation</button></div></div></div></div>';
        $("#subDiv" + rowID).append(sub);
    }

    $(function() {

        $('#remove-subskill').click(function(e) {
            var order = e.target.getAttribute("order");
            $("#sub_skill" + order).hide();
        });

        $('#remove-subskill_main').click(function(e) {
            var order = e.target.getAttribute("order");
            $("#sub_skill_main" + order).hide();
        });

        // $('#add-sub-skill').click(function() {
        //     $("#hrtag1").show();
        //     $("#hrtag2").show();
        //     $("#sub_skill1").show();
        //     $("#w-100-1").show();
        //     $("#sub_col1_1").show();
        //     $("#sub_col1_2").show();
        // });

        $("#add-todo-item").on('click', function(e) {

            e.preventDefault();
            addElement()
            // var skillcount = $('.mainDiv').length;
            // if (skillcount == 0) {
            //     $("#sub_skill").show();
            //     $('#mainDiv').addClass("mainDiv");
            // } else {
            //     e.preventDefault();
            //     addElement()
            // }
        });
    });

    function add_skill(skillID) {
        var sub_skill = $('.sub_skill' + skillID).length;
        if (sub_skill == 0) {
            $("#sub_skill" + skillID).show();
            $('#sub_skill' + skillID).addClass("sub_skill" + skillID);
        } else {
            add_sub_skill(skillID)
        }
    }
</script>
<script>
    function table_column(e) {
        $('#mainDiv').show();
        $('#add-todo-item').show();
    }
</script>

@endsection