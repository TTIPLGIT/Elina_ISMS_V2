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
        <h4 style="color:darkblue">SAIL Activity Master </h4>

        <form action="{{route('video_creation.update',$rows[0]['activity_description_id'])}}" method="POST" id="videouploadcreation" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="card question">

                <div class="row" style="margin-bottom: 15px;margin-top: 20px;">

                    <div class="col-md-6">
                        <div class="form-group questionnaire">
                            <label class="control-label">Activity Name</label>
                            <input class="form-control" type="text" id="activity_name" name="activity_name" value="{{ $rows[0]['activity_name']}}" autocomplete="off">


                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                    </div>


                    <div class="col-md-12">
                        <div class="form-group questionnaire">

                            <label class="control-label">Activity Description</label>
                            <div class="multi-field-wrapper">
                                <div class="multi-fields">
                                    @foreach($rows as $key=>$row)
                                    <div class="multi-field" style="display: flex;margin-bottom: 5px;">
                                        <input type="text" class="form-control default col-4" name="description[{{$row['activity_description_id']}}]" id="description" value="{{ $row['description']}}">
                                        <!-- <input class="form-control default col-3" type="file" id="file" name="file[{{$row['activity_description_id']}}]" value="{{ $row['file_attachment']}}" autocomplete="off"> -->
                                        <div style="height: auto;" class="form-control default tinymce-body" id="instruction[{{$row['activity_description_id']}}]" name="instruction[{{$row['activity_description_id']}}]">{!! $row['instruction'] !!}</div>
                                        <button class="remove-field btn btn-danger pull-right" id="remove-f" type='button'>X </button>
                                        &nbsp;
                                    </div>
                                    @endforeach
                                </div>
                                <button type="button" class="add-field btn btn-success">Add Description</button>
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






            </section>
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




        document.getElementById('videouploadcreation').submit('saved');
    }

    // <script type="text/javascript">
    $('.multi-field-wrapper').each(function() {
        var $wrapper = $('.multi-fields', this);
        var idCounter = 1;
        $(".add-field", $(this)).click(function(e) {
            // $('.multi-field:first-child', $wrapper).clone(true).appendTo($wrapper).find('input').val('').focus();
            var $clone = $('.multi-field:first-child', $wrapper).clone(true);
            $('input', $clone).each(function() {
                var newName = $(this).attr('name').replace(/\[\d+\]/, '[new][]');
                $(this).attr('name', newName);
            });
            $clone.appendTo($wrapper).find('input').val('').focus();
            idCounter++;

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
    // 
</script>

<script type="text/javascript">
    //     function typeChange() {
    //         var fieldtype = $('#option-tab').val();
    //         alert("hi");
    //         if (fieldtype == dropdown) {
    //             $('#option').hide();
    //         } else {
    //             $('#option').show();
    //         }
    //     }
    // 
</script>

@endsection