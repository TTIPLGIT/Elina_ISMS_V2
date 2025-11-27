@extends('layouts.adminnav')
@section('content')
<style>
    .left_align {
        padding: 18px 5px !important;
        overflow: hidden !important;

    }

    .right_align {
        padding-left: 0px !important;
        padding-right: 0px !important;
    }

    .select2-container--default .select2-selection--single .select2-selection__rendered {
        color: #444;
        line-height: 42px !important;
    }

    .form-control {
        background-color: #ffffff !important;
    }

    /* .border-1 {
         border-bottom: 1px solid black; 
        border-left: 1px solid black;
        border-right: 1px solid black;
        border-top: 1px solid black;
        width: 100%;
        display: inline-block;
        padding: 5px;
        
    }
    

    .border-1:last-child{
        width: 100%;
        display: inline-block;
        padding: 8px;
        border-bottom: 0px solid black;
    } */
    table.table-bordered>tbody>tr>td {
        border: 1px solid black !important;
    }

    .received {
        background-color: lime !important;
        color: white !important;
    }

    .notreceived {
        background-color: red !important;
        color: white !important;
    }

    .dan {
        background-color: orangered !important;
        color: white !important;
    }

    .prisha {
        background-color: darkmagenta !important;
        color: white !important;
    }

    .table .table-bordered .dataTable .no-footer tr {
        width: 100px !important;
    }

    .hide {
        display: none;
    }
</style>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.16/dist/sweetalert2.all.min.js"></script>


<div class="main-content" style="padding-top: 52px !important;">

    <div class="row">

        <div class="col-12 right_align">
            <div class="card">
                <div class="card-body left_align">
                    <div class="col-lg-12 ">

                        <h4 style="color:darkblue;display:flex !important;justify-content:center !important;">Therapist Progress View</h4>
                        </i>
                    </div>
                    <hr>
                    <div class="row is-coordinate" style="margin-top:2rem !important;">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="control-label">IS Head</label>
                                <select class="form-control" id="is_head" name="is_head">
                                    <option value="all">All</option>
                                    <option value="131">Sumi</option>
                                    <option value="132">Sowmya</option>
                                    <option value="133">Malini</option>
                                    <option value="134">Rama</option>
                                    <!-- <option value=""></option> -->
                                </select>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group ">
                                <label class="control-label">IS Co-ordinator</label>

                                <select class="form-control" id="is_coordinator1" name="is_coordinator1">
                                    <option value="all">All</option>
                                    <option value="131">Sumi</option>
                                    <option value="132">Sowmya</option>
                                    <option value="133">Malini</option>
                                    <option value="134">Rama</option>
                                </select>

                            </div>
                        </div>


                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="control-label">Child Name</label>
                                <select class="form-control" type="text" id="child_name" name="child_name">
                                    <option value="all">All</option>

                                    <option value="131">Tarun</option>
                                    <option value="132">Robert</option>
                                    <option value="133">yogesh</option>
                                    <option value="134">rudhresh</option>
                                    <option value="135">Dan</option>
                                    <option value="136">Prisha</option>
                                </select>
                            </div>
                        </div>


                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="control-label">Month</label>
                                <input type='month' class="form-control" id='month' name="month" title="Month" value="2022-12" required>
                            </div>
                        </div>


                        <div class="row text-center">
                            <div class="col-md-12">
                                <button style="background-color: #00a65a;border-color: #008d4c;" onclick="Search()" class="btn btn-success mb-1"><i class="fa fa-search" aria-hidden="true"></i>Search</button>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>



    <section class="section">


        <div class="section-body mt-1">

            <div class="card" id="search1" style="display:none !important;">
                <div class="card-body">

                    <div class="table-wrapper">
                        <div class="table-responsive">

                            <table class="table table-bordered" id="align" style="width:100% !important">
                                <thead>

                                    <tr>
                                        <th rowspan="2">Sl.No.</th>
                                        <th rowspan="2">Child Name</th>
                                        <th rowspan="2">IS-Coordinator</th>
                                        <th rowspan="2">Therapists</th>
                                        <th rowspan="2">Area</th>
                                        <th colspan="4">weekly</th>

                                        <th rowspan="2">Monthly</th>
                                        <th rowspan="2">Action</th>

                                    </tr>


                                    <tr>
                                        <th>week1</th>
                                        <th>week2</th>
                                        <th>week3</th>
                                        <th>week4</th>

                                    </tr>
                                </thead>
                                <tbody>

                                    <tr id="135" class="custom">
                                        <td rowspan="3">1</td>
                                        <td rowspan="3" class="dan">Dan</td>
                                        <td rowspan="3">Sumi</td>
                                        <td style="width: 20px !important;">Sumi</td>
                                        <td>Spled</td>
                                        <td class="received">received</td>
                                        <td class="received">received</td>
                                        <td class="received">received</td>
                                        <td class="received">received</td>
                                        <td class="received" style="width:45px !important;">received</td>
                                        <td rowspan="3"><a class="btn btn-link" title="Show" href="{{route('viewcalendar')}}"><i class="fas fa-eye" style="color: blue !important"></i></a></td>

                                    </tr>
                                    <tr id="135" class="custom">
                                        <td class="hide">1</td>
                                        <td class="hide">Dan</td>
                                        <td class="hide">Sumi</td>
                                        <td style="width: 20px !important;">Suganya</td>
                                        <td>OT</td>
                                        <td class="received">received</td>
                                        <td class="received">received</td>
                                        <td class="received">received</td>
                                        <td class="received">received</td>
                                        <td class="received" style="width:45px !important;">received</td>
                                        <td class="hide"><a class="btn btn-link" title="Show" href="{{route('viewcalendar')}}"><i class="fas fa-eye" style="color: blue !important"></i></a></td>

                                    </tr>
                                    <tr id="135" class="custom">
                                        <td class="hide">1</td>
                                        <td class="hide">Dan</td>
                                        <td class="hide">Sumi</td>
                                        <td style="width: 20px !important;">Stephen</td>
                                        <td>Phyed</td>
                                        <td class="received">received</td>
                                        <td class="received">received</td>
                                        <td class="received">received</td>
                                        <td class="received">received</td>
                                        <td class="notreceived" style="width:45px !important;">notreceived</td>
                                        <td class="hide"><a class="btn btn-link" title="Show" href="{{route('viewcalendar')}}"><i class="fas fa-eye" style="color: blue !important"></i></a></td>


                                    </tr>

                                    <tr id="136" class="custom2">
                                        <td rowspan="3">2</td>
                                        <td rowspan="3" class="prisha">Prisha</td>
                                        <td rowspan="3">Sumi</td>
                                        <td style="width: 20px !important;">Sumi</td>
                                        <td>Spled</td>
                                        <td class="received">received</td>
                                        <td class="received">received</td>
                                        <td class="received">received</td>
                                        <td class="received">received</td>
                                        <td class="received" style="width: 45px !important;">received</td>
                                        <td rowspan="3"><a class="btn btn-link" title="Show" href="{{route('viewcalendar')}}"><i class="fas fa-eye" style="color: blue !important"></i></a></td>

                                    </tr>
                                    <tr id="136" class="custom2">
                                        <td class="hide">2</td>
                                        <td class="hide">Prisha</td>
                                        <td class="hide">Sumi</td>
                                        <td style="width: 20px !important;">Suganya</td>
                                        <td>OT</td>
                                        <td class="received">received</td>
                                        <td class="received">received</td>
                                        <td class="received">received</td>
                                        <td class="received">received</td>
                                        <td class="received" style="width: 45px !important;">received</td>
                                        <td class="hide"><a class="btn btn-link" title="Show" href="{{route('viewcalendar')}}"><i class="fas fa-eye" style="color: blue !important"></i></a></td>

                                    </tr>
                                    <tr id="136" class="custom2">
                                        <td class="hide">2</td>
                                        <td class="hide">Prisha</td>
                                        <td class="hide">Sumi</td>
                                        <td style="width: 20px !important;">Stephen</td>
                                        <td>Phyed</td>
                                        <td class="received">received</td>
                                        <td class="received">received</td>
                                        <td class="received">received</td>
                                        <td class="received">received</td>
                                        <td class="notreceived" style="width:45px !important;">notreceived</td>
                                        <td class="hide"><a class="btn btn-link" title="Show" href="{{route('viewcalendar')}}"><i class="fas fa-eye" style="color: blue !important"></i></a></td>


                                    </tr>




                                </tbody>
                            </table>

                        </div>
                    </div>
                </div>
            </div>

        </div>

    </section>



    <section class="section">


        <div class="section-body mt-1">

            <div class="card" id="search2" style="display:none !important;">
                <div class="card-body">

                    <div class="table-wrapper">
                        <div class="table-responsive">

                            <table class="table table-bordered" id="align1" style="width:100% !important">
                                <thead>
                                    <tr>
                                        <th rowspan="2">Sl.No.</th>
                                        <th rowspan="2">Child Name</th>
                                        <th rowspan="2">IS-Coordinator</th>
                                        <th rowspan="2">Therapists</th>
                                        <th rowspan="2">Area</th>
                                        <th colspan="4">Weekly feedback </th>
                                        <th rowspan="2">Monthly objectives</th>
                                        <th rowspan="2">Action</th>

                                    </tr>

                                    <th>week1 </th>
                                    <th>week2</th>
                                    <th>week3</th>
                                    <th>week4</th>

                                </thead>
                                <tbody>
                                    @foreach($rows as $key=>$row)
                                    <td>{{"$row"}}</td>
                                    <td>{{"$row"}}</td>
                                    <td>{{"$row"}}</td>
                                    <td>{{"$row"}}</td>
                                    <td>{{"$row"}}</td>
                                    <td>{{"$row"}}</td>
                                    <td>{{"$row"}}</td>
                                    <td>{{"$row"}}</td>
                                    <td>{{"$row"}}</td>
                                    <td>{{"$row"}}</td>

                                    <td>{{"$row"}}</td>



                                </tbody>
                                @endforeach
                            </table>
                        </div>
                    </div>
                </div>
            </div>

        </div>

    </section>

</div>



<!-- Modal -->




<!-- <script src="https://code.jquery.com/jquery-1.7.2.min.js"></script> -->
<script type="application/javascript">
    function myFunction(id) {
        swal({
                title: "Confirmation For Delete ?",
                text: "Are You Sure to delete this data.",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: '#DD6B55',
                confirmButtonText: 'Yes, I am sure!',
                cancelButtonText: "No, cancel it!",
                closeOnConfirm: false,
                closeOnCancel: false
            },
            function(isConfirm) {

                if (isConfirm) {
                    swal("Deleted!", "Data Deleted successfully!", "success");
                    var url = $('#' + id).val();

                    window.location.href = url;

                } else {
                    swal("Cancelled", "Your file is safe :)", "error");
                    e.preventDefault();
                }
            });


    }
</script>

<script>
    meeting_startdate.min = new Date().toISOString().split("T")[0];
</script>
<script>
    function getproposaldocument(id) {
        var data = (id);
        $('#modalviewdiv').html('');
        $("#loading_gif").show();
        console.log(id);

        $("#loading_gif").hide();
        var proposaldocuments = "<div class='removeclass' id='modalviewdiv' style=' height:100%'><iframe src='" + data + "' class='document_ifarme_view' style='width:100%; height:100%'></iframe></div>";
        $('.removeclass').remove();
        var document = $('#template').append(proposaldocuments);

    };
</script>
<script>
    setTimeout(func, 2000);

    function func() {
        let url = new URL(window.location.href)

        let message = url.searchParams.get("message2");

        if (message != null) {
            Swal.fire({
                title: "Success",
                text: "Therapist Initiated Successfully",
                icon: "success",
            });
        }
    };
</script>

<script>
    function Search() {
        // document.getElementById('search1').style.display = "block";

        var head = $('#is_head').val();
        //alert(head);
        var is_coordinator1 = $('#is_coordinator1').val();
        //alert(is_coordinator1);
        var child_name = $('#child_name').val();
        //alert(child_name);
        var month = $('#month').val();
        var dan = $('#dan').val();
        //alert(month);

        if ((head == '131') && (child_name == '135') && (month == '2022-11')) {

            document.getElementById('search1').style.display = "block";
            document.getElementById('search2').style.display = "none";

        } else if ((head != '') && (is_coordinator1 != '') && (child_name == '135') && (month != '')) {

            var custom = document.querySelectorAll('.custom');

            for (let i = 0; i < custom.length; i++) {
                //alert(i);
                custom[i].removeAttribute('style');
            }
            var custom2 = document.querySelectorAll('.custom2');

            for (let i = 0; i < custom2.length; i++) {
                //alert(i);
                custom2[i].style.display = "none";
            }

            //document.getElementById('136').style.display = "none";
            document.getElementById('search1').style.display = "block";
            document.getElementById('search2').style.display = "none";
        } else if ((head != '') && (is_coordinator1 != '') && (child_name == '136') && (month != '')) {
            var custom2 = document.querySelectorAll('.custom2');

            for (let i = 0; i < custom2.length; i++) {
                // alert(i);
                custom2[i].removeAttribute('style');
            }

            var custom = document.querySelectorAll('.custom');

            for (let i = 0; i < custom.length; i++) {
                //alert(i);
                custom[i].style.display = "none";
            }
            // document.getElementById('135').style.display = "none";
            document.getElementById('search1').style.display = "block";
            document.getElementById('search2').style.display = "none";
        } else if ((head == 'all') && (is_coordinator1 == 'all') && (child_name == 'all') && (month != '')) {
            var custom2 = document.querySelectorAll('.custom2');

            for (let i = 0; i < custom2.length; i++) {
                // alert(i);
                custom2[i].removeAttribute('style');
            }

            var custom = document.querySelectorAll('.custom');

            for (let i = 0; i < custom.length; i++) {
                //alert(i);
                custom[i].removeAttribute('style');
            }
            document.getElementById('search1').style.display = "block";
            document.getElementById('search2').style.display = "none";
        } else {
            document.getElementById('search1').style.display = "none";
            document.getElementById('search2').style.display = "block";
        }





    }
</script>

<script type="text/javascript">
    $("#enrollment_child_num").select2({
        tags: false
    });
</script>

<script>
    $(document).ready(function() {
        var table = $('#example').DataTable({

            'columnDefs': [{
                'targets': [1, 2, 3, 4, 5],
                'orderable': false,
                'searchable': false
            }],
            'rowsGroup': [0],
            'createdRow': function(row, data, dataIndex) {
                // Use empty value in the "Office" column
                // as an indication that grouping with COLSPAN is needed
                if (data[2] === '') {
                    // Add COLSPAN attribute
                    $('td:eq(1)', row).attr('colspan', 5);

                    // Hide required number of columns
                    // next to the cell with COLSPAN attribute
                    $('td:eq(2)', row).css('display', 'none');
                    $('td:eq(3)', row).css('display', 'none');
                    $('td:eq(4)', row).css('display', 'none');
                    $('td:eq(5)', row).css('display', 'none');
                }
            }
        });
    });
</script>
@endsection