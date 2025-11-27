@extends('layouts.adminnav')
<script type="text/javascript" src="https://cdn.rawgit.com/t4t5/sweetalert/v0.2.0/lib/sweet-alert.min.js"></script>

@section('content')
<style>
    #frname {
        color: red;
    }

    .is-coordinate {
        justify-content: center;
    }

    .centerid {
        width: 100%;
        text-align: center;
    }

    .form-control {
        background-color: rgb(128 128 128 / 34%) !important;
    }
</style>

<div class="main-content">


    <!-- Main Content -->
    <section class="section">


        <div class="section-body mt-1">
            <div class="row">
                <div class="col-12">

                    <div class="card">
                        <div class="card-body">
                            <h5 class="text-center" style="color:darkblue">IS-Coordinator Allocation View</h5>


                            <form method="" action="">

                                @csrf

                                <div class="row is-coordinate pt-4">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="control-label">Enrollment ID</label>
                                            <input class="form-control" name="enrollment_id" value="{{ $rows[0]['enrollment_child_num']}}" placeholder="Enrollment ID" required>
                                        </div>
                                    </div>


                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="control-label">Child ID</label>
                                            <input class="form-control" type="text" id="child_id" name="child_id" value="{{$rows[0]['child_id']}}" disabled="" placeholder="OVM1 Meeting" required autocomplete="off">
                                        </div>
                                    </div>



                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="control-label">Child Name</label>
                                            <input class="form-control" type="text" id="child_name" name="child_name" value="{{$rows[0]['child_name']}}" disabled="" placeholder="Enter Name" required autocomplete="off">
                                        </div>
                                    </div>

                                    <div class="col-md-5">
                                        <div class="form-group ">
                                            <label class="control-label">IS Co-ordinator-1</label>
                                            <input class="form-control" type="text" id="is_coordinator" name="is_coordinator" value="{{$rows[0]['is_coordinator1_name']}}" disabled="" required autocomplete="off">


                                        </div>
                                    </div>

                                    <div class="col-md-5">
                                        <div class="form-group ">
                                            <label class="control-label">IS Co-ordinator-2</label>
                                            <input class="form-control" type="text" id="is_coordinator" name="is_coordinator" value="{{$rows[0]['is_coordinator2_name']}}" disabled="" required autocomplete="off">


                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="form-group ">
                                            <label class="control-label centerid">Status</label> <br>


                                            <input class="form-control" type="text" id="coordinator_status" name="coordinator_status" value="{{$rows[0]['meeting_status']}}" disabled="" placeholder="" required autocomplete="off">


                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label class="control-label centerid">Allocated Date</label> <br>
                                            <?php
                                            $createdDate = $rows[0]['created_date'];
                                            $formattedDate = date('d-m-Y', strtotime($createdDate));
                                            ?>
                                            <input class="form-control" type="text" id="allocated_date" name="allocated_date" value="{{$formattedDate}}" disabled="" placeholder="" required autocomplete="off">

                                        </div>
                                    </div>
                                    @if($rows[0]['status']!= 1)
                                    <div class="col-lg-12" style="margin: 20px 0px 0px 0px;">
                                        <div class="form-group">
                                            <label class="form-label">Special Instruction(if Any)</label>
                                            <textarea class="form-control" id="description" name="description" readonly value="{{ $rows[0]['comments']}}">{{ $rows[0]['comments']}}</textarea>
                                        </div>
                                    </div>
                                    @endif
                                </div>
                                <div class="row text-center">
                                    <div class="col-md-12">
                                        <a type="button" class="btn btn-labeled back-btn" title="Back" href="{{route('coordinator.list')}}" style="color:white !important">
                                            <span class="btn-label" style="font-size:13px !important;"><i class="fa fa-arrow-left"></i></span> Back</a>
                                    </div>
                                </div>

                        </div>
                    </div>
                </div>

                <br>

                </form>



            </div>
        </div>


</div>
</section>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/tinymce/4.5.6/tinymce.min.js"></script>
<script src="http://cdnjs.cloudflare.com/ajax/libs/tinymce/4.5.6/jquery.tinymce.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.26.0/moment.min.js"></script>


























@endsection