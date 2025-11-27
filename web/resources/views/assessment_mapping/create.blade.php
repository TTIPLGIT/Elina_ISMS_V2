@extends('layouts.adminnav')

@section('content')
<link rel="stylesheet" href="https://static.jstree.com/3.2.1/assets/dist/themes/default/style.min.css">
<style>
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

    .select2-container {
        width: 100% !important;
    }

    .select2-container--default .select2-selection--single .select2-selection__rendered {
        color: #444;
        line-height: 42px !important;
    }
</style>

<div class="main-content">
    <!-- {{ Breadcrumbs::render('video_creation.create') }} -->
    <div class="section-body mt-0">
        <h4 style="color:darkblue">SAIL Activity Master Creation </h4>

        <form action="{{route('video_creation.store')}}" method="POST" id="videouploadcreation" enctype="multipart/form-data">
            @csrf
            <div class="card question">
                <div class="row" style="margin-bottom: 15px;margin-top: 20px;">
                    <div class="col-md-6">
                        <div class="form-group questionnaire">
                            <label class="control-label">Physical</label>
                            <select class="form-control" id="assessment_skill" name="assessment_skill" onchange="getAssessmentSkill()">
                                <option value="">Select Area</option>
                                @foreach($rows as $key=> $row)
                                <option value="{{$row['assessment_skill_id']}}">{{ $row['area_name']}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row" style="display: none;" id="divSkill">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="table-wrapper">
                                    <div class="table-responsive">
                                        <table class="table table-bordered" id="">
                                            <thead>
                                                <tr>
                                                    <th>Sl.No</th>
                                                    <th>Skill</th>
                                                    <th>Activity Set</th>
                                                    <!-- <th>Activity Description</th> -->
                                                </tr>
                                            </thead>
                                            <tbody id="tbody">
                                                <!-- <tr>
                                                    <td></td>
                                                    <td>

                                                    </td>
                                                    <td>
                                                        <select class="form-control activity_id" id="activity_id" name="activity_id" onchange="Description()"><option value="">Select Activity</option></select>
                                                    </td>
                                                    <td></td>
                                                </tr> -->
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12 text-center">
                        <a type="button" onclick="submit('submitted')" id="submitbutton" class="btn btn-labeled btn-succes" title="submit" style="background: green !important; border-color:green !important; color:white !important">
                            <span class="btn-label" style="font-size:13px !important;"><i class="fa fa-check"></i></span> Submit</a>
                        <a class="btn btn-danger" href=""><i class="fa fa-times" aria-hidden="true"></i> Cancel </a>&nbsp;
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
    $(document).ready(function() {
        tinymce.init({
            selector: '.tinymce-body',
            height: 180,
            menubar: false,
            branding: false,
            inline: true,
            plugins: 'link',
            toolbar: 'undo redo | formatselect | ' +
                'bold italic backcolor link | alignleft aligncenter ' +
                'alignright alignjustify | bullist numlist outdent indent | ' +
                'removeformat | help',
            content_style: 'body { font-family:Helvetica,Arial,sans-serif; font-size:14px }'
        });
    });
</script>
<script>
    function submit() {


        var activity_name = $('#activity_name').val();

        if (activity_name == '') {
            swal.fire("Please Enter Activity Name: ", "", "error");
            return false;
        }


        var description = $('#description').val();

        if (description == '') {
            swal.fire("Please Enter Description:", "", "error");
            return false;
        }

        // var file = $('#file').val();

        // if (file == '') {
        //      swal.fire("Please Attach File:", "", "error");
        //      return false;
        // }




        document.getElementById('videouploadcreation').submit('saved');
    }

    // <script type="text/javascript">
    $('.multi-field-wrapper').each(function() {

        var $wrapper = $('.multi-fields', this);

        $(".add-field", $(this)).click(function(e) {
            $('.multi-field:first-child', $wrapper).clone(true).appendTo($wrapper).find('input').val('').focus();
            $('#file_field').append('<div class="multi-field" style="display: flex;margin-bottom: 5px;"><input class="form-control" type="file" id="file" name="file" autocomplete="off"></div>');
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
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
<script src="https://static.jstree.com/3.2.1/assets/dist/jstree.js"></script>
<script type="text/javascript">
    $(document).ready(function() {
        function getAssessmentSkill() {
            var assessment_skill = $('#assessment_skill').val();

            $.ajax({
                url: "{{ url('/assessment/skill/getdetails') }}",
                type: 'POST',
                data: {
                    'assessment_skill': assessment_skill,
                    _token: '{{csrf_token()}}'
                }
            }).done(function(data) {
                var skill = data.skill;
                var skillOptions = '';
                for (var i = 0; i < skill.length; i++) {
                    var index = i + 1;
                    var activity_id = skill[i]['activity_id'];
                    var activity_name = skill[i]['activity_name'];
                    skillOptions += '<tr><td>' + index + '</td>';
                    skillOptions += '<td>' + activity_name + '</td>';
                    skillOptions += '<td><div id="jstree"' + activity_id + '></div><td>';
                    // skillOptions += '<td> <select class="form-control activity_id" id="activity_id_' + activity_id + '" name="activity_id[]" onchange="Description()" multiple="multiple"><option value="">Select Activity</option></select> </td>';
                    // skillOptions += '<td> <select class="form-control activity_description" id="activity_description" name="activity_description"><option value="">Select Activity Description</option></select> </td> </tr>';
                }

                $('#tbody').append(skillOptions);

                var activity = data.activity;
                var activityOptions = "<option value=''>Select Activity</option>";
                for (var i = 0; i < activity.length; i++) {
                    var activity_id = activity[i]['activity_id'];
                    var activity_name = activity[i]['activity_name'];
                    // activityOptions += '<option value="' + activity_id + '">' + activity_name + '</option>';
                    $('#jstree' + activity_id).jstree({
                        'plugins': ['search', 'checkbox', 'wholerow'],
                        'core': {
                            'data': [{
                                'id': '1',
                                'parent': '#',
                                'text': 'Greater London'
                            }, ],
                            'animation': false,
                            //'expand_selected_onload': true,
                            'themes': {
                                'icons': false,
                            }
                        },
                        'search': {
                            'show_only_matches': true,
                            'show_only_matches_children': true
                        }
                    })
                }

                // $('.activity_id').append(activityOptions);
                $('#divSkill').show();
            });
        }

        window.getAssessmentSkill = getAssessmentSkill;
    });
</script>
<script>
    function Description() {

        var activity_id = $("select[name='activity_id[]']").val();

        if (activity_id != "") {
            $.ajax({
                url: "{{ route('parentvideo.description') }}",
                type: 'POST',
                data: {
                    'activity_id': activity_id,
                    'enrollment_id': enrollment_id,
                    _token: '{{csrf_token()}}'
                }
            }).done(function(data) {
                var active = data.active;
                var initiated = data.initiated[0].initiated;
                var prevData = data.prevData;

                document.getElementById('prevData').value = prevData[0].co;
                var data = data.id;
                // console.log(initiated);
                if (data != '[]') {
                    var optionsdata = "";
                    for (var ij = 0; ij < data.length; ij++) {
                        var data_set = data[ij];
                        var activity_title = data_set[ij].activity_name;
                        optionsdata += '<tbody id="align1b">';
                        for (var i = 0; i < data_set.length; i++) {
                            var id = data_set[i].activity_description_id;
                            var name = data_set[i].description;
                            optionsdata += "<tr><td >" + (parseInt(i) + 1) + "</td><td id=" + id + " >" + name + "</td><td>New</td><td style='text-align:center;'><label class='switch' data-bs-toggle='tooltip' data-bs-placement='top' title='Enable / Disable'><input type='checkbox' class='toggle_status' onclick='active_function(" + id + ")'  id='active_id' name='is_active'  checked><span class='slider round'></span></label></td></tr>";
                        }

                        optionsdata += '</tbody></table></div></div>';
                        optionsdata += '</div></details>';
                    }
                    var demonew = $('#description_table').html(optionsdata);
                    $('#description_table').show();
                    $('#description_table_submit').show();
                }
            })
        }
    };

    function initSelect2() {
        var jq = $.noConflict();
        jq('.activity_id').select2({
            closeOnSelect: false,
            placeholder: "Select Activity",
            allowHtml: true,
            allowClear: true,
            tags: true
        });
    }
</script>
@endsection