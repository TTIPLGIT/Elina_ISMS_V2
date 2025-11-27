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
            <h1>G2 Form</h1>
            <div class="search-container">
                <input type="text" class="form-control default" id="searchInput" style="width: 30%;float: right;margin: 0 15px 0px 0px;font-family:Arial, FontAwesome" placeholder="&#xF002; Search">
            </div>
            <div class="container">
                <div class="faq-container">
                    @foreach($rows as $key => $data)
                    <div class="set">
                        <div class="question">{{$data['question']}}<i class="fa fa-cog" style="float: right;font-size: 20px;cursor: pointer;" aria-hidden="true" onclick="openSetting('{{$data['id']}}')"></i> </div>
                        <!-- <div class="question">{{$data['question']}}<i class="fa fa-cog" style="float: right;font-size: 20px;cursor: pointer;" aria-hidden="true" data-toggle="modal" data-target="#settingModal"></i> </div> -->
                        <div class="answer">{{$data['question_description']}}</div>
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
                            <input type="hidden" id="add_type_id" name="type_id" value="1">
                            <div class="form-group">
                                <label class="control-label required">Question</label>
                                <input class="form-control default" type="text" id="add_question" name="question">
                            </div>
                            <div class="form-group">
                                <label class="control-label">Description</label>
                                <input class="form-control default" type="text" id="add_description" name="description">
                            </div>
                            <div class="form-group">
                                <label class="control-label required">Required</label>
                                <label class='switch' data-bs-toggle='tooltip' data-bs-placement='top' title='Enable / Disable'><input type='checkbox' id="add_required" class='toggle_status' name='required' value="1"><span class='slider round'></span></label>
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
    <div class="modal fade" id="settingModal" tabindex="-1" role="dialog" aria-labelledby="settingModalTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-body" style="background-color: #8080800a;">
                    <form action="{{route('master.gform.update')}}" method="post" id="saveChanges">
                        <div class="col-12">
                            <input type="hidden" id="id" name="id">
                            <input type="hidden" id="type_id" name="type_id">
                            <div class="form-group">
                                <label class="control-label required">Question</label>
                                <input class="form-control default" type="text" id="question" name="question">
                            </div>
                            <div class="form-group">
                                <label class="control-label">Description</label>
                                <input class="form-control default" type="text" id="description" name="description">
                            </div>
                            <div class="form-group">
                                <label class="control-label required">Required</label>
                                <label class='switch' data-bs-toggle='tooltip' data-bs-placement='top' title='Enable / Disable'><input type='checkbox' id="required" class='toggle_status' name='required' value="1"><span class='slider round'></span></label>
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
    var rows = <?php echo json_encode($rows); ?>;

    function openSetting(id) {
        for (var i = 0; i < rows.length; i++) {
            var rowid = rows[i].id;
            if (rowid == id) {
                document.getElementById('question').value = rows[i].question;
                document.getElementById('description').value = rows[i].question_description;
                document.getElementById('id').value = rows[i].id;
                document.getElementById('type_id').value = rows[i].type_id;
                var required = rows[i].required;
                // console.log(required);
                if (required == 1) {
                    $("#required").prop("checked", true);
                } else {
                    $("#required").prop("checked", false);
                }
            }
        }
        $('#settingModal').modal('show');
    }

    function saveChanges() {
        document.getElementById('saveChanges').submit();
    }

    function addQuestion() {
        document.getElementById('addQuestion').submit();
    }
</script>
@endsection