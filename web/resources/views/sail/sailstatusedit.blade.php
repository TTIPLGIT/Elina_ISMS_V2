@extends('layouts.adminnav')

@section('content')
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

    .centerid {
        width: 100%;
        text-align: center;
    }

    #item_no_label,
    #item_label {
        text-transform: capitalize !important;
    }

    #tabs {
        overflow: hidden;
        width: 100%;
        margin: 0;
        flex-wrap: nowrap;
        padding: 0;
        list-style: none;
        font-size: 16px !important;

    }

    #tabs li {
        float: left;
        margin: 0 .5em 0 0;

    }

    #tabs a {
        color: white !important;
        position: relative;
        background: #3e86bd;
        /* background-image: linear-gradient(to bottom, #1c92d2, #f2fcfe); */
        float: left;
        text-decoration: none;
        color: #444;
        text-shadow: 0 1px 0 rgba(255, 255, 255, .8);
        border-radius: 5px 0 0 0;
        box-shadow: 0 2px 2px rgba(0, 0, 0, .4);
    }

    #tabs a:hover,
    #tabs a:hover::after,
    #tabs a:focus,
    #tabs a:focus::after {
        background: #a9cadb;
    }

    #tabs a:focus {
        outline: 0;
    }

    #tabs a::after {
        content: '';
        position: absolute;
        z-index: 1;
        top: 0;
        right: -.5em;
        bottom: 0;
        width: 1em;
        background: #3e86bd;
        /* background-image: linear-gradient(to bottom, #1c92d2, #f2fcfe); */
        box-shadow: 2px 2px 2px rgba(0, 0, 0, .4);
        transform: skew(10deg);
        border-radius: 0 5px 0 0;
    }

    #tabs #current a,
    #tabs #current a::after {
        background: #265077;
        z-index: 3;
        color: white !important;

    }

    .form-control:disabled,
    .form-control[readonly] {
        background-color: #e9ecef !important;
    }

    textarea {
        resize: none;
    }
</style>

<div class="main-content">

    <!-- Main Content -->
    <section class="section">
        {{ Breadcrumbs::render('sail.status.edit',$rows[0]['enrollment_id']) }}

        <div class="section-body mt-1">
            <h5 class="text-center" style="color:darkblue">Sail Reallocation (Coordinator) Screen</h5>
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">

                            <form action="{{route('sail.complete',$rows[0]['enrollment_id'])}}" method="POST" id="submitform" name="submitform" enctype="multipart/form-data">
                                {{ csrf_field() }}
                                @method('PUT')
                                <div class="row is-coordinate">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="control-label required">Enrollment Number</label>
                                            <input class="form-control" name="enrollment_child_num" value="{{ $rows[0]['enrollment_child_num']}}" placeholder="Enrollment ID" readonly>
                                        </div>
                                    </div>
                                    <input type="hidden" value="{{ $rows[0]['enrollment_id']}}" name="enrollment_id">
                                    <input type="hidden" value="{{$rows[0]['user_id']}}" id="user_id" name="user_id">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="control-label required">Child ID</label>
                                            <input class="form-control" type="text" id="child_id" name="child_id" value="{{ $rows[0]['child_id']}}" placeholder="" readonly autocomplete="off">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="control-label required">Child Name</label>
                                            <input class="form-control" type="text" id="child_name" name="child_name" value="{{ $rows[0]['child_name']}}" placeholder="Enter Name" readonly autocomplete="off">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="control-label required">IS Coordinator 1</label>
                                            <Select class="form-control" type="text" id="is_1" name="is_1" required autocomplete="off" onchange="removeSelectedOption('is_1', 'is_2')">
                                                @foreach($iscoordinators as $row)
                                                @if($rows[0]['is_coordinator1']['id'] == $row['id'])
                                                <option value="{{$row['id']}}" selected>{{$row['name']}}</option>
                                                @else
                                                <option value="{{$row['id']}}">{{$row['name']}}</option>
                                                @endif
                                                @endforeach
                                            </Select>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="control-label required">IS Coordinator 2</label>
                                            <Select class="form-control" type="text" id="is_2" name="is_2" required autocomplete="off" onchange="removeSelectedOption('is_2', 'is_1')">
                                                @if($rows[0]['is_coordinator2'] != null)
                                                @foreach($iscoordinators as $row)
                                                @if($rows[0]['is_coordinator2']['id'] == $row['id'])
                                                <option value="{{$row['id']}}" selected>{{$row['name']}}</option>
                                                @else
                                                <option value="{{$row['id']}}">{{$row['name']}}</option>
                                                @endif
                                                @endforeach
                                                @else
                                                <option value="">Select</option>
                                                @foreach($iscoordinators as $row)
                                                <option value="{{$row['id']}}">{{$row['name']}}</option>
                                                @endforeach
                                                @endif
                                            </Select>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="control-label required">Payment Status</label>
                                            @if($payment[0]['payment_status'] == 'New')
                                            <input class="form-control" type="text" id="payment_status" name="payment_status" value="Pending" placeholder="Enter Name" readonly autocomplete="off">
                                            @else
                                            <input class="form-control" type="text" id="payment_status" name="payment_status" value="{{$payment[0]['payment_status']}}" placeholder="Enter Name" readonly autocomplete="off">
                                            @endif 
                                        </div>
                                    </div>
                                    <input type="hidden" id="action_btn" name="action_btn">
                                    {{-- <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="control-label required">Status Action</label>
                                            <Select class="form-control" type="text" id="current_status" name="current_status" value="" required autocomplete="off">
                                                <option value="">Action</option>
                                                @if($rows[0]['current_status'] == 'Completed')
                                                <option value="Completed" selected>Completed</option>
                                                @else
                                                <option value="Completed">Completed</option>
                                                @endif
                                            </Select>
                                        </div>
                                    </div> --}}
                                </div>

                            </form>
                        </div>
                    </div>
                </div>

                <div class="row text-center" style="    margin: 15px 0 15px 0px;">
                    <div class="col-md-12">
                        <button type="submit" id="submit" class="btn btn-info" name="type" onclick="submitformaction('Completed')" value="Close">Close</button>
                        <button type="submit" id="submit" class="btn btn-success" name="type" onclick="submitformaction('Submitted')" value="Submitted">Update</button>
                        <a type="button" href="{{ url()->previous() }}" class="btn btn-danger">Cancel</a>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="tile" id="tile-1" style="margin-top:10px !important; margin-bottom:15px !important;">
                                    <ul class="nav nav-tabs nav-justified " id="tabs" role="tablist">
                                        <li class="nav-items navv" class="active" style="flex-basis: 1 !important;">
                                            <a class="nav-link  " id="home-tab" name="tab1" data-toggle="tab" role="tab" aria-controls="home" aria-selected="true"><b>Activity</b> <input type="checkbox" class="checkg" id="profile" name="nationality" value="0" onchange="submitval(this)" readonly style="background-color:solid green !important; color:green !important; visibility:hidden !important; ">
                                                <div class="check"></div>
                                            </a>
                                        </li>
                                        <li class="nav-items navv" class="active" style="flex-basis: 1 !important;">
                                            <a class="nav-link  " id="home-tab" name="tab2" data-toggle="tab" role="tab" aria-controls="home" aria-selected="true"><b>Questionnaire Forms</b> <input type="checkbox" class="checkg" id="profile" name="nationality" value="0" onchange="submitval(this)" readonly style="background-color:solid green !important; color:green !important; visibility:hidden !important; ">
                                                <div class="check"></div>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                                <div id="content">
                                    <div id="tab1" title="Activity">
                                        <div class="table-wrapper">
                                            <div class="table-responsive">
                                                <table class="table table-bordered" id="align1">
                                                    <thead>
                                                        <tr>
                                                            <th>Sl.No</th>
                                                            <th>Activity Name</th>
                                                            <th>Description</th>
                                                            <!-- <th>Status</th> -->
                                                            <th>Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach($video as $key=>$data2)
                                                        <tr>
                                                            <td>{{ $loop->iteration }}</td>
                                                            <td>{{ $data2['activity_name']}}</td>
                                                            <td>{{ $data2['description']}}</td>
                                                            <!-- <td>{{$data2['status']}}</td> -->
                                                            <td>
                                                                <a class="btn btn-link" title="show" target="_blank" href="{{$data2['video_link']}}"><i class="fas fa-eye" style="color:green"></i></a>
                                                            </td>
                                                        </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                    <div id="tab2" title="Questionnaire">
                                        <div class="table-wrapper">
                                            <div class="table-responsive">
                                                <table class="table table-bordered" id="align">
                                                    <thead>
                                                        <tr>
                                                            <th>Sl.No</th>
                                                            <th>Questionaire Name</th>
                                                            <th style="width: 10% !important">Status</th>
                                                            <th>Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach($questionnaire as $data)
                                                        <tr>
                                                            <td>{{$loop->iteration}}</td>
                                                            <td>{{$data['questionnaire_name']}}</td>
                                                            <td>
                                                                <div class="progress" style="height: 25px;">
                                                                    <div class="progress-bar" role="progressbar" id="{{$data['questionnaire_initiation_id']}}" aria-valuemax="100" style="font-weight: bolder;color: black;"></div>
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <a class="btn" style="cursor: pointer;" id="a{{$data['questionnaire_initiation_id']}}" href="{{ route('questionnaire_for_user.form.edit', \Crypt::encrypt($data['questionnaire_initiation_id'])) }}"></a>
                                                                @csrf
                                                            </td>
                                                        </tr>
                                                        @endforeach
                                                        <input type="hidden" class="cfn" id="fn" value="0">
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <br>
</div>
</section>
</div>
<script>
    function submitformaction(a) {
        // var current_status = document.getElementById('current_status').value;
        // if (current_status == '') {
        //     swal.fire("Please Select Status Action", "", "error");
        //     return false;
        // }
        document.getElementById('action_btn').value = a;
        document.getElementById('submitform').submit();
    }
</script>
<script>
    $(document).ready(function() {

        $("#content").find("[id^='tab']").hide(); // Hide all content
        $("#tabs li:first").addClass("active"); // Activate the first tab
        $("#tab1").fadeIn(); // Show first tab's content



        $('#tabs a').click(function(e) {
            e.preventDefault();
            if ($(this).closest("li").attr("id") == "current") { //detection for current tab
                return;
            } else {
                $("#content").find("[id^='tab']").hide(); // Hide all content
                $("#tabs li").removeClass("active"); //Reset id's
                $(this).parent().addClass("active"); // Activate this
                $('#' + $(this).attr('name')).fadeIn(); // Show content for the current tab


            }
        });
    });
</script>
<script>
    var progress_status = <?php echo (json_encode($questionnaire)); ?>

    for (i = 0; i < progress_status.length; i++) {

        var a = progress_status[i];
        var percent = a.question_progress;
        var id = a.questionnaire_initiation_id;
        var no_questions = a.no_questions;
        var per = ((percent / no_questions) * 100).toFixed(3);
        var title = 'Completed '.concat(percent) + ' of '.concat(no_questions);
        var idi = '#'.concat(id);
        var aidi = 'a'.concat(id);

        $(idi).attr('aria-valuenow', title).css('width', per + '%');
        var div = document.getElementById(id);
        div.innerHTML += percent + ' / ' + no_questions;

        if (per == 0) {
            document.getElementById(aidi).innerHTML = "New";
            document.getElementById(aidi).classList.add('btn-danger');
        } else if (per == 100) {
            document.getElementById(aidi).innerHTML = "View";
            document.getElementById(aidi).classList.add('btn-success');
        } else {
            document.getElementById(aidi).classList.add('btn-primary');
            document.getElementById(aidi).innerHTML = "Edit";
        }

        if (per < 25) {
            document.getElementById(id).classList.add('bg-danger');
        } else if (per < 80) {
            document.getElementById(id).classList.add('bg-warning');
        } else if (per >= 80) {
            document.getElementById(id).classList.add('bg-success');
        }

    }
</script>
<script>
    function removeSelectedOption(selectedId, otherId) {
        var selectedOption = document.getElementById(selectedId).value;
        var otherSelect = document.getElementById(otherId);

        if (selectedOption) {
            // Remove the selected option from the other select element
            for (let i = 0; i < otherSelect.options.length; i++) {
                if (otherSelect.options[i].value === selectedOption) {
                    otherSelect.remove(i);
                    break;
                }
            }
        }
    }
    $(document).ready(function() {
        removeSelectedOption('is_1', 'is_2');
        removeSelectedOption('is_2', 'is_1');
    });
</script>
@endsection