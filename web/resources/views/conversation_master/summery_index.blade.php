@extends('layouts.adminnav')
@section('content')
<style>
    body {
        background-color: white !important;
    }

    .faq-container {
        /* max-width: 800px; */
        margin: 0 auto;
        padding: 20px;
    }

    .question {
        font-weight: bold;
        color: white;
        /* Dodger Blue */
        /* margin-bottom: 5px; */
        background-color: gray;
        padding: 10px;
        border-radius: 5px;
    }

    .answer {
        color: #333;
        /* Dark Gray */
        background-color: #d9d9d952;
        padding: 10px;
        margin-bottom: 15px;
        border-radius: 0 0 10px 10px;
    }
</style>
<style>
    .container {
        margin: 0 auto;
        padding: 0 15px 20px;
        /* max-width: 800px; */
        transition: box-shadow 0.2s ease-in;
        border-radius: 10px;
        /* 	box-shadow: 0 0 40px 25px #111; */
        max-height: 350px;
        overflow-y: scroll;
    }

    .submit {
        display: flex;
        justify-content: center;
        margin: 10px 0 0 0;
    }

    .submit .btn-raised {
        width: 75%;
        margin: 0;
        font-size: 16px;
        padding: 15px;
        text-transform: none;
        transform: none !important;
    }

    .btn-raised.btn-default {
        background-color: #3578eb96;
        color: #333;
    }

    .btn-raised {
        padding: 8px 15px;
        font-size: 13px;
        font-weight: 300;
        line-height: 20px;
        text-transform: uppercase;
        color: #fff;
        font-family: inherit;
        cursor: pointer;
        display: inline-block;
        text-decoration: none;
        text-align: center;
        background-color: #999;
        z-index: 2;
        position: relative;
        border: 0;
        border-radius: 3px;
        -webkit-font-smoothing: subpixel-antialiased;
        box-shadow: 0 2px 6px -2px rgba(0, 0, 0, 0.5);
        backface-visibility: hidden;
        transform: translate3d(0, 0, 0);
        transition: all 0.1s;
        outline: 0;
        -webkit-user-select: none;
        user-select: none;
    }

    h1 {
        /* margin: 20px 0; */
        color: blue;
        text-align: center;
    }

    .search-container {
        display: flex;
        justify-content: space-between;
        margin: 0 0 10px 35px;
    }
</style>
@if (session('success'))
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

<div class="main-content">
    <div class="row">
        <div class="col-12">
            <h1>Conversation Summery</h1>
            <div class="search-container">
                <select class="col-4 form-control default" onchange="showGroup(this.value)" id="group-nav">
                    @foreach($groupdata as $group)
                    @if(in_array($group['id'], $uniqueGroups))
                    <option value="{{$group['id']}}">{{$group['name']}}</option>
                    @endif
                    @endforeach
                </select>
                <input type="text" class="col-4 form-control default" id="searchInput" style="font-family:Arial, FontAwesome" placeholder="&#xF002; Search">
            </div>
            <div class="container">
                <div class="faq-container">
                    @foreach($rows as $key => $data)
                    <div>
                        <!-- <p style="background-color: orange;width: 20%;border-radius: 0px 15px 0px 0;">{{$data['group_id']}}</p> -->
                        <div class="set promote" data-id="{{$data['group_id']}}" data-group="{{$data['group_id']}}">
                            <div class="question" style="display: flex;align-items: center;justify-content: space-between;">{!! $data['question'] !!}<i class="fa fa-cog" style="float: right;font-size: 20px;cursor: pointer;" aria-hidden="true" onclick="openSetting('{{$data['id']}}')"></i> </div>
                            <!-- <div class="question">{{$data['question']}}<i class="fa fa-cog" style="float: right;font-size: 20px;cursor: pointer;" aria-hidden="true" data-toggle="modal" data-target="#settingModal"></i> </div> -->
                            <div class="answer">{!! $data['question_description'] !!}</div>
                        </div>
                    </div>
                    @endforeach
                </div>
                <div id="noDataFound" style="font-size: 20px;text-align: center;display: none;">No Records Found</div>
            </div>
            <div class="submit"><button class="btn-raised btn-default" data-toggle="modal" data-target="#addModal">Add Question</button></div>
        </div>
    </div>

    <!-- Add Modal -->
    <div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="addModalTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-body" style="background-color: #8080800a;">
                    <form action="{{route('master.gform.store')}}" method="post" id="addQuestion">
                        <div class="col-12">
                            <input type="hidden" id="add_type_id" name="type_id" value="2">
                            <div class="form-group">
                                <label class="control-label required">Question</label>
                                <input class="form-control default add_text" type="text" id="add_question" name="question">
                            </div>
                            <div class="form-group">
                                <label class="control-label">Description</label>
                                <input class="form-control default add_text" type="text" id="add_description" name="description">
                            </div>
                            <div class="form-group">
                                <label class="control-label">Prefilled Value</label>
                                <input class="form-control default add_text" type="text" id="add_prefilled_data" name="prefilled_data">
                            </div>
                            <div class="form-group">
                                <label class="control-label">Additional Question</label>
                                <input class="" type="checkbox" id="add_additional_question_check" value="1" name="add_additional_question_check" onclick="$('#additional_question_div1').toggle();">
                                <div style="display: none;" id="additional_question_div1">
                                    <input class="form-control default add_text" type="text" id="add_additional_question_data" name="add_additional_question_data">
                                </div>
                            </div>
                            <!-- <div class="form-group">
                                <label class="control-label">Required</label>
                                <label class='switch' data-bs-toggle='tooltip' data-bs-placement='top' title='Enable / Disable'><input type='checkbox' id="add_required" class='toggle_status' name='required' value="1"><span class='slider round'></span></label>
                            </div> -->
                            <div class="form-group">
                                <label class="control-label required">Group</label>
                                <select class="form-control default" name="group" id="add_group">
                                    @foreach($groupdata as $key => $value)
                                    <option value="{{$value['id']}}">{{$value['name']}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" onclick="addQuestion()" class="btn btn-success">Add Question</button>
                </div>
            </div>
        </div>
    </div>
    <!-- End Add -->
    <!-- Update Modal -->
    <div class="modal fade" id="settingModal" tabindex="-1" role="dialog" aria-labelledby="settingModalTitle" aria-hidden="true" data-backdrop="static">
        <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-body" style="background-color: #8080800a;">
                    <form action="{{route('master.gform.update')}}" method="post" id="saveChanges">
                        <div class="col-12">
                            <input type="hidden" id="id" name="id">
                            <input type="hidden" id="type_id" name="type_id">
                            <div class="form-group">
                                <label class="control-label required">Question</label>
                                <input class="form-control default update_text" type="text" id="question" name="question">
                            </div>
                            <div class="form-group">
                                <label class="control-label">Description</label>
                                <input class="form-control default update_text" type="text" id="description" name="description">
                            </div>
                            <div class="form-group">
                                <label class="control-label">Prefilled Value</label>
                                <input class="form-control default update_text" type="text" id="prefilled_data" name="prefilled_data">
                            </div>
                            <div class="form-group">
                                <label class="control-label">Additional Question</label>
                                <input class="" type="checkbox" id="additional_question_check" value="1" name="additional_question_check" onclick="$('#additional_question_div').toggle();">
                                <div style="display: none;" id="additional_question_div">
                                    <input class="form-control default update_text" type="text" id="additional_question_data" name="additional_question_data">
                                </div>
                            </div>
                            <!-- <div class="form-group">
                                <label class="control-label required">Required</label>
                                <label class='switch' data-bs-toggle='tooltip' data-bs-placement='top' title='Enable / Disable'><input type='checkbox' id="required" class='toggle_status' name='required' value="1"><span class='slider round'></span></label>
                            </div> -->
                            <div class="form-group">
                                <label class="control-label required">Group</label>
                                <select class="form-control default" name="group" id="group">
                                    @foreach($groupdata as $key => $value)
                                    <option value="{{$value['id']}}">{{$value['name']}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" onclick="saveChanges()" class="btn btn-success">Save changes</button>
                </div>
            </div>
        </div>
    </div>
    <!-- End Update -->
</div>

<script>
    document.getElementById('searchInput').addEventListener('input', function() {
        var input, filter, faqContainer, sets, i, txtQuestion, txtAnswer, noDataFound;
        input = document.getElementById('searchInput');
        filter = input.value.toUpperCase();
        faqContainer = document.querySelector('.faq-container');
        sets = faqContainer.getElementsByClassName('set');
        noDataFound = document.getElementById('noDataFound');
        var found = false;

        for (i = 0; i < sets.length; i++) {
            txtQuestion = sets[i].getElementsByClassName('question')[0];
            txtAnswer = sets[i].getElementsByClassName('answer')[0];
            if (txtQuestion.textContent.toUpperCase().indexOf(filter) > -1 || txtAnswer.textContent.toUpperCase().indexOf(filter) > -1) {
                sets[i].style.display = '';
                found = true;
            } else {
                sets[i].style.display = 'none';
            }
        }

        if (found) {
            noDataFound.style.display = 'none';
        } else {
            noDataFound.style.display = 'block';
        }
    });
</script>
<script>
    function showGroup(group) {
        var selectedGroupElement = document.querySelector('[data-group="' + group + '"]');
        if (selectedGroupElement) {
            selectedGroupElement.scrollIntoView({
                behavior: 'smooth'
            });
            var firstQuestion = selectedGroupElement.querySelector('.question');
            if (firstQuestion) {
                firstQuestion.focus();
            }
        }
    }
</script>
<script>
    function elementInView(elem) {
        var shown = $(elem).data("shown");
        if (shown) {
            return false;
        }
        var elTop = $(elem).offset().top;
        var elBottom = $(elem).offset().top + $(elem).outerHeight();
        var screenBottom = $(window).scrollTop() + $(window).innerHeight();
        var screenTop = $(window).scrollTop();

        if ((screenBottom > elTop) && (screenTop < elBottom)) {
            return true;
        } else {
            return false;
        }
    }
    $(window).scroll(function() {
        $('.promote').each(function() {
            if (elementInView(this)) {
                var dataid = $(this).data("id");
                $(this).attr('data-shown', '1');
                // alert(dataid);
                $('#group-nav option[value="' + dataid + '"]').attr("selected", "selected");
            }
        });
    });
</script>
<script>
    var rows = <?php echo json_encode($rows); ?>;

    function openSetting(id) {
        tinymce.remove('.update_text');
        for (var i = 0; i < rows.length; i++) {
            var rowid = rows[i].id;
            if (rowid == id) {
                // console.log(rows[i]);
                document.getElementById('question').value = rows[i].question;
                document.getElementById('description').value = rows[i].question_description;
                document.getElementById('id').value = rows[i].id;
                document.getElementById('type_id').value = rows[i].type_id;
                document.getElementById('additional_question_data').value = rows[i].additional_question_data;

                document.getElementById('prefilled_data').value = rows[i].prefilled_data;

                var group_id = rows[i].group_id;
                $('#group option[value="' + group_id + '"]').attr("selected", "selected");

                var additional_question_check = rows[i].additional_question_check;
                if (additional_question_check == 1) {
                    $("#additional_question_check").prop("checked", true);
                    document.getElementById('additional_question_div').style.display = "";
                } else {
                    $("#additional_question_check").prop("checked", false);
                    document.getElementById('additional_question_div').style.display = "none";
                }

                var required = rows[i].required;
                if (required == 1) {
                    $("#required").prop("checked", true);
                } else {
                    $("#required").prop("checked", false);
                }
            }
        }
        tinymce.init({
            selector: '.update_text',
            height: 150,
            menubar: false,
            branding: false,
            // inline: true,
            plugins: 'preview importcss searchreplace autolink autosave save directionality code visualblocks visualchars fullscreen image link media codesample table charmap pagebreak nonbreaking anchor insertdatetime advlist lists wordcount help charmap emoticons',
            toolbar: 'undo redo | bold italic underline strikethrough | fontfamily fontsize blocks | alignleft aligncenter alignright alignjustify | outdent indent |  numlist bullist | forecolor backcolor link ',
        });
        $('#settingModal').modal('show');
    }

    function saveChanges() {
        document.getElementById('saveChanges').submit();
    }

    function addQuestion() {
        document.getElementById('addQuestion').submit();
    }

    $(document).ready(function() {
        tinymce.init({
            selector: '.add_text',
            height: 150,
            menubar: false,
            branding: false,
            // inline: true,
            plugins: 'preview importcss searchreplace autolink autosave save directionality code visualblocks visualchars fullscreen image link media codesample table charmap pagebreak nonbreaking anchor insertdatetime advlist lists wordcount help charmap emoticons',
            toolbar: 'undo redo | bold italic underline strikethrough | fontfamily fontsize blocks | alignleft aligncenter alignright alignjustify | outdent indent |  numlist bullist | forecolor backcolor link ',
        });
    });
</script>
@endsection