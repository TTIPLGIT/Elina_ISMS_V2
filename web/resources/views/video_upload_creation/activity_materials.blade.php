@extends('layouts.adminnav')

@section('content')

<style>
    input[type=checkbox] {
        display: inline-block;
    }

    h4 {
        text-align: center;
    }

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

    /* ---- Fix select2 width on desktop ---- */
    .chosen-select {
        width: 100% !important;
    }

    /* ---- Desktop default: description & select side by side ---- */
    .multi-field {
        display: flex;
        align-items: center;
        gap: 10px;
        margin-bottom: 15px;
        width: 100%;
        background-color: #f8f9fa;
        padding: 10px;
        border-radius: 5px;
        flex-wrap: nowrap;
    }

    .multi-field .col-4 {
        width: 33.33%;
        flex: 0 0 33.33%;
    }

    .multi-field .select2-container {
        flex: 1;
        min-width: 200px;
    }

    /* ============================================================
       MOBILE RESPONSIVE – screens ≤ 768px
       ============================================================ */
    @media (max-width: 768px) {

        /* Reset paddings and prevent horizontal scroll */
        .main-content,
        .card,
        .card-body,
        .form-group,
        .table-wrapper,
        .table-responsive {
            padding-left: 0 !important;
            padding-right: 0 !important;
            margin-left: 0 !important;
            margin-right: 0 !important;
            overflow-x: hidden !important;
            max-width: 100% !important;
        }

        .row,
        .col-12,
        .col-md-3,
        .col-md-6,
        .col-lg-12 {
            padding-left: 5px !important;
            padding-right: 5px !important;
            margin-left: 0 !important;
            margin-right: 0 !important;
        }

        .main-content {
            padding-top: 0 !important;
        }

        .breadcrumb {
            font-size: 10px !important;
            margin: 60px 10px 10px 10px !important;
            white-space: nowrap !important;
            overflow: hidden !important;
            text-overflow: ellipsis !important;
            display: flex !important;
            flex-wrap: nowrap !important;
            padding: 6px 10px !important;
        }

        .breadcrumb li {
            display: inline !important;
            white-space: nowrap !important;
        }

        .card {
            margin-top: 0 !important;
        }

        h4 {
            font-size: 18px !important;
        }

        /* Stack columns */
        .col-md-3,
        .col-md-6 {
            width: 100% !important;
            flex: 0 0 100% !important;
            max-width: 100% !important;
        }

        .col-md-12 {
            width: 100% !important;
            flex: 0 0 100% !important;
            max-width: 100% !important;
            padding-left: 0 !important;
            padding-right: 0 !important;
        }

        /* Form inputs full width */
        .form-control,
        .form-control[type="text"],
        .form-control[type="number"],
        textarea.form-control,
        select.form-control {
            font-size: 14px !important;
            height: auto !important;
            padding: 8px 10px !important;
            width: 100% !important;
        }

        /* Labels */
        .control-label {
            font-size: 13px !important;
        }

        /* ---- Multi-field: stack vertically ---- */
        .multi-field {
            flex-direction: column !important;
            align-items: stretch !important;
            padding: 10px !important;
            gap: 10px !important;
        }

        .multi-field .col-4 {
            flex: 0 0 100% !important;
            width: 100% !important;
            max-width: 100% !important;
        }

        /* Description input full width */
        .multi-field input[type="text"] {
            width: 100% !important;
            max-width: 100% !important;
        }

        /* Select2 container full width */
        .multi-field .select2-container {
            width: 100% !important;
            min-width: 0 !important;
        }

        .select2-container--default .select2-selection--multiple {
            width: 100% !important;
        }

        /* ---- Submit and Cancel buttons – side by side, same size as desktop ---- */
        .col-md-12.text-center {
            display: flex !important;
            flex-direction: row !important;
            flex-wrap: wrap !important;
            justify-content: center !important;
            align-items: center !important;
            gap: 10px !important;
        }

        .col-md-12.text-center .btn,
        .col-md-12.text-center a.btn {
            width: auto !important;
            min-width: 100px !important;  /* optional, for consistent width */
            margin: 0 !important;
            flex: 0 0 auto !important;
            box-shadow: none !important;  /* remove left shadow */
            /* No font-size or padding overrides – uses Bootstrap default */
        }
    }
</style>

<div class="main-content">
    {{ Breadcrumbs::render('video_creation.edit',$rows[0]['activity_description_id']) }}
    <div class="section-body mt-0">
        <h4 style="color:darkblue">SAIL Activity Mapping </h4>
        <form action="{{route('activity.mapping.store')}}" method="POST" id="videouploadcreation" enctype="multipart/form-data">
            @csrf
            <input type="hidden" value="{{$rows[0]['activity_description_id']}}" id="activity_id" name="activity_id">
            <div class="card question">
                <div class="row" style="margin-bottom: 15px;margin-top: 20px;">
                    <div class="col-md-6">
                        <div class="form-group questionnaire">
                            <label class="control-label">Activity Name</label>
                            <input class="form-control" type="text" id="activity_name" name="activity_name" value="{{ $rows[0]['activity_name']}}" autocomplete="off">
                        </div>
                    </div>
                    <div class="col-md-6">
                    </div>
                    <div class="col-md-12">
                        <div class="form-group questionnaire">
                            <!-- <label class="control-label">Description</label> -->
                            <div class="multi-field-wrapper">
                                <div class="multi-fields">
                                    @foreach($rows as $key=>$row)
                                    
                                    @php $activity_materials_id = 0; @endphp
                                    @foreach($activity_materials_mapping as $mapping)
                                    @if($row['activity_description_id'] == $mapping['activity_description_id'])
                                    @php $activity_materials_id = $mapping['activity_materials_id']; @endphp
                                    @break
                                    @endif
                                    @endforeach

                                    <div class="multi-field" style="display: flex;margin-bottom: 5px;">
                                        <input type="text" class="form-control default col-4" name="description[{{$row['activity_description_id']}}]" id="description" value="{{ $row['description']}}">&nbsp;
                                        <select data-placeholder="Select Materials" multiple class="chosen-select" name="material[{{$row['activity_description_id']}}][]" style="width: 100% !important;">
                                            @foreach($activity_materials as $material)
                                            @if(in_array($material['id'] , explode(',', $activity_materials_id) ))
                                            <option value="{{$material['id']}}" selected>{{$material['materials']}}</option>
                                            @else
                                            <option value="{{$material['id']}}">{{$material['materials']}}</option>
                                            @endif
                                            @endforeach
                                        </select>&nbsp;
                                        &nbsp;
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12 text-center">
                        <a type="button" onclick="submit('submitted')" id="submitbutton" class="btn btn-labeled btn-succes" title="submit" style="background: green !important; border-color:green !important; color:white !important">
                            <span class="btn-label" style="font-size:13px !important;"><i class="fa fa-check"></i></span>Update</a>
                        <a class="btn btn-danger" href="{{route('video_creation.index')}}"><i class="fa fa-times" aria-hidden="true"></i> Cancel </a>&nbsp;
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
    $(".chosen-select").select2({
        closeOnSelect: false,
        placeholder: " Please Select Users",
        allowHtml: true,
        tags: true
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
        document.getElementById('videouploadcreation').submit('saved');
    }
</script>
@endsection