@extends('layouts.adminnav')

@section('content')

<style>
    input[type=checkbox] {
        display: inline-block;

    }

    .no-arrow {
        -moz-appearance: textfield;
    }

    .no-arrow::-webkit-inner-spin-button {
        display: none;
    }

    .no-arrow::-webkit-outer-spin-button,
    .no-arrow::-webkit-inner-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }

    /* body{
        background-color: white !important;
    } */
    .nav-tabs {
        background-color: #0068a7 !important;
        border-radius: 29px !important;
        padding: 1px !important;

    }

    .nav-item.active {
        background-color: #0e2381 !important;
        border-radius: 31px !important;
        height: 100% !important;
    }

    .nav-link.active {
        background-color: #0e2381 !important;
        border-radius: 31px !important;
        height: 100% !important;
    }

    .nav-justified {
        display: flex !important;
        align-items: center !important;
    }

    hr {
        border-top: 1px solid #6c757d !important;
    }

    .dateformat {
        height: 41px;
        padding: 8px 10px !important;
        width: 100%;
        border-radius: 5px !important;
        border-color: #bec4d0 !important;
        box-shadow: 2px 2px 4px rgb(0 0 0 / 15%);
        border-style: outset;
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
    {{ Breadcrumbs::render('video_creation.show',$rows[0]['activity_description_id']) }}
    <div class="section-body mt-0">

        <h4 style="color:darkblue">SAIL Activity Master </h4>


        <form action="{{route('video_creation.store')}}" method="POST" id="videouploadcreation" enctype="multipart/form-data">
            @csrf
            <div class="card question">

                <div class="row" style="margin-bottom: 15px;margin-top: 20px;">
                    <div class="col-md-3">
                        <div class="form-group questionnaire">
                            <label class="control-label">Group</label>
                            <input class="form-control" type="text" id="age" name="age" value="{{ $rows[0]['group']}}" autocomplete="off" disabled>



                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group questionnaire">
                            <label class="control-label">Category</label>
                            @if($rows[0]['category'] == '1')
                            <input class="form-control" type="text" id="Category" name="Category" value="Parent" autocomplete="off" disabled>
                            @elseif($rows[0]['category'] == '2')
                            <input class="form-control" type="text" id="Category" name="Category" value="Child" autocomplete="off" disabled>
                            @else
                            <input class="form-control" type="text" id="Category" name="Category" value="All" autocomplete="off" disabled>
                            @endif
                        </div>
                    </div>


                    <div class="col-md-5">
                        <div class="form-group questionnaire">
                            <label class="control-label">Activity Name</label>
                            <input class="form-control" type="text" id="activity_name" name="activity_name" value="{{ $rows[0]['activity_name']}}" autocomplete="off" disabled>


                            </select>
                        </div>
                    </div>

                    <!-- <div class="col-md-6">
                    <div class="form-group questionnaire">
                        <label class="control-label">File Attachment</label>
                        <input class="form-control" type="text" id="file" name="file" value="{{ $rows[0]['imagename']}}" autocomplete="off">
                            
                            
                        </select>
                    </div>
                </div> -->


                    <div class="row">
                        <div class="col-12">

                            <div class="card mt-3">
                                <div class="card-body">
                                    <div class="table-wrapper">
                                        <div class="table-responsive">
                                            <table class="table table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th>Sl.No</th>
                                                        <th>Activity Description</th>
                                                        <!-- <th>status</th> -->
                                                        <th> File Attachment </th>


                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach($rows as $key=>$row)
                                                    <tr>
                                                        <td>{{ $loop->iteration }}</td>
                                                        <td>{{ $row['description']}}</td>
                                                        <td> {{ $row['file_attachment']}}</td>




                                                    </tr>

                                                    <input type="hidden" class="cfn" id="fn" value="0">
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12 text-center">

                        <a class="btn btn-danger" href="{{route('video_creation.index')}}"><i class="fa fa-times" aria-hidden="true"></i> Cancel </a>&nbsp;
                    </div>
                </div>
            </div>






            </section>
        </form>

    </div>
</div>

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
        $(".add-field", $(this)).click(function(e) {
            $('.multi-field:first-child', $wrapper).clone(true).appendTo($wrapper).find('input').val('').focus();
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