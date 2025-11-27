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