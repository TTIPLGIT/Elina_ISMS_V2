<div class="modal fade" id="elina_dropped">
    <div class="modal-dialog modal-xl">


        <div class="modal-content">
            <div class="main-contents">





                <section class="section">
                    <div class="modal-header bg-primary" style=" background-color: rgb(0 103 172) !important;">
                        <h4 class="modal-title">Elina Lead Activity</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    </div>
                    <div class="modal-body" style="background-color: #edfcff !important;">

                        <div class="section-body mt-2">




                            <div class="row">

                                <div class="col-12">

                                    <div class="mt-0 ">

                                        <div class="card-body" id="card_header">
                                            <div class="row">


                                            </div>
                                            @if (session('success'))

                                            <input type="hidden" name="session_data" id="session_data" class="session_data" value="{{ session('success') }}">
                                            <script type="text/javascript">
                                                window.onload = function() {
                                                    var message = $('#session_data').val();
                                                    swal({
                                                        title: "Success",
                                                        text: message,
                                                        type: "success",
                                                    });

                                                }
                                            </script>
                                            @elseif(session('error'))

                                            <input type="hidden" name="session_data" id="session_data1" class="session_data" value="{{ session('error') }}">
                                            <script type="text/javascript">
                                                window.onload = function() {
                                                    var message = $('#session_data1').val();
                                                    swal({
                                                        title: "Info",
                                                        text: message,
                                                        type: "info",
                                                    });

                                                }
                                            </script>
                                            @endif



                                            <div class="table-wrapper">
                                                <div class="table-responsive  p-3">
                                                    <table class="table table-bordered tableExport" >
                                                        <thead>
                                                            <tr>
                                                                <th style="width:5px !important">Sl. No.</th>
                                                                <th>Enrollement Id</th>
                                                                <th>Child Name</th>
                                                                <th>Email</th>
                                                                <th>Mobile No</th>
                                                                <th>Date of Registration</th>
                                                                <th>Present Status</th>
                                                                <th>Notes</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <!-- <tr>
                                                            <td></td>
                                                            <td></td>
                                                            <td></td>
                                                        </tr> -->
                                                            @foreach($rows['dropped'] as $key=>$row)
                                                            <tr>
                                                                <td>{{ ++$key }}</td>
                                                                <td>{{ $row['enrollment_id']}} </td>
                                                                <td>{{ $row['child_name']}} </td>
                                                                <td>{{ $row['child_contact_email']}} </td>
                                                                <td>{{ $row['child_contact_phone']}} </td>
                                                                <td>{{ $row['status']}} </td>
                                                                <td>{{ $row['elina_assessment_description']}} </td>
                                                               

                                                            </tr>
                                                            @endforeach
                                                          




                                                         
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                </section>
            </div>
        </div>

    </div>
</div>