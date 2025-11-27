@extends('layouts.adminnav')

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.16/dist/sweetalert2.all.min.js"></script>


@section('content')
<div class="main-content">
  <section class="section">
    <div class="section-body mt-2">
      <div class="row">
        @if (session('success'))
        <input type="hidden" name="session_data" id="session_data" class="session_data" value="{{ session('success') }}">
        <script type="text/javascript">
          window.onload = function() {
            var message = $('#session_data').val();
            Swal.fire({
              title: "Success",
              text: message,
              icon: "success",
            });
          }
        </script>
        @elseif(session('fail'))
        <input type="hidden" name="session_data" id="session_data1" class="session_data" value="{{ session('fail') }}">
        <script type="text/javascript">
          window.onload = function() {
            var message = $('#session_data1').val();
            Swal.fire({
              title: "Info",
              text: message,
              icon: "info",
            });
          }
        </script>
        @endif
        @if($modules['user_role'] != 'Parent')
        <a type="button" href="{{route('compassstatus.initiate')}}" value="" class="btn btn-labeled btn-info" title="Compass Initiate" style="background: #044a95 !important; border-color:#a9ca !important; color:white !important;margin: 0 0 2px 15px;">
          <span class="btn-label" style="font-size:15px !important; padding:8px !important"><i class="fa fa-plus"></i></span><span style="font-size:15px !important; padding:8px !important">CoMPASS Initiation</span></a>
          @endif
          <div class="col-12">
          <div class="card">
            <div class="card-body">
              <div class="row">
                <div class="col-lg-12 text-center">
                  <h4 style="color:darkblue;">CoMPASS List View</h4>
                </div>
              </div>
              <div class="table-wrapper">
                <div class="table-responsive">
                  <table class="table table-bordered" id="align">
                    <thead>
                      <tr>
                        <th>Sl. No.</th>
                        <th>Enrollment Id</th>
                        <th>Child Name</th>
                        <!-- <th>Is-coordinator</th> -->
                        <th>Status</th>
                        <th>Action</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <td>1</td>
                        <td>EN/2022/12/025</td>
                        <td>Kaviya</td>
                        <!-- <td></td> -->
                        <td>Month1-Observation Completed</td>




                        <td class="text-center">
                          <a href="#addModal" data-toggle="modal" data-target="#addModal" class="btn btn-primary" title="View" data-toggle="modal" data-target="#templates" style="margin-inline:5px"><i class="fa fa-bars" style="color:white!important"></i></a>
                          <a class="btn btn-primary" title="view Document" data-toggle="modal" data-target="#templates" style="margin-inline:5px"><i class="fa fa-download" style="color:white!important"></i></a>
                          <!-- <a href="#addModal" data-toggle="modal" data-target="#addModal" style="font-weight: bold;"><span class="text-secondary">Click Here To View All Leads <i class="fa fa-arrow-right" aria-hidden="true"></i></span></a>  -->
                          <!-- <a class="btn" title="Delete" onclick="" class="btn btn-link"><i class="fa fa-bars"></i></a> -->
                        </td>
                      </tr>

                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
  </section>
</div>
<!-- Modal -->

<div class="modal fade" id="addModal">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <div class="main-contents">
        <section class="section">
          <div class="modal-header bg-primary" style=" background-color: rgb(0 103 172) !important;">
            <h4 class="modal-title">
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
                      <div class="table-wrapper">
                        <div class="table-responsive  p-3">
                          <table class="table table-bordered">
                            <thead>
                              <tr>
                                <th>Sl. No.</th>
                                <th>Enrollement Number</th>
                                <th>Child Name</th>
                                <th>Status</th>
                                <th>Date</th>
                              </tr>
                            </thead>
                            <tbody>
                              <tr>
                              <tr>
                                <td>1</td>
                                <td>EN/2022/12/025</td>
                                <td>Kaviya </td>
                                <!-- <td></td> -->
                                <td>Consent&Snapshot Sent</td>
                                <td>2022-11-07 10:38:59</td>
                              </tr>
                              <tr>
                                <td>2</td>
                                <td>EN/2022/12/025</td>
                                <td>Kaviya </td>
                                <!-- <td></td> -->
                                <td>Payment Initiated</td>
                                <td>2022-11-08 10:42:30</td>
                              </tr>
                              <tr>
                                <td>3</td>
                                <td>EN/2022/12/025</td>
                                <td>Kaviya </td>
                                <!-- <td></td> -->
                                <td>Payment Completed</td>
                                <td>2022-11-09 10:43:34</td>
                             </tr>
                             <tr>
                                <td>4</td>
                                <td>EN/2022/12/025</td>
                                <td>Kaviya </td>
                                <!-- <td></td> -->
                                <td>ORM invite sent</td>
                                <td>2022-11-09 10:43:34</td>
                             </tr>
                             <tr>
                                <td>5</td>
                                <td>EN/2022/12/025</td>
                                <td>Kaviya </td>
                                <!-- <td></td> -->
                                <td>ORM completed</td>
                                <td>2022-11-09 10:43:34</td>
                             </tr>
                             <tr>
                                <td>6</td>
                                <td>EN/2022/12/025</td>
                                <td>Kaviya </td>
                                <!-- <td></td> -->
                                <td>Week4 Therapist Allocated
                                <a onclick="modal(event)"data-target="#addModal5" class="btn " title="Therapist Session Status View" style="margin-inline:5px" id="therapistsession"><i class="fa fa-arrow-circle-o-right" style="color:white!important;background-color:blue!important;font-size: 23px;"></i></a>

                                  </td>
                                <td>2022-12-15 12:43:34</td>
                             </tr>
                             <td>7</td>
                                <td>EN/2022/12/025</td>
                                <td>Kaviya </td>
                                <!-- <td></td> -->
                                <td>HomeTracker saved</td>
                                <td>2022-11-10 1:43:34</td>
                             </tr>
                             <tr>
                                <td>8</td>
                                <td>EN/2022/12/025</td>
                                <td>Kaviya</td>
                                <!-- <td></td> -->
                                <td>HomeTracker sent</td>
                                <td>2022-11-11 12:43:34</td>
                             </tr>
                             <tr>
                                <td>9</td>
                                <td>EN/2022/12/025</td>
                                <td>Kaviya </td>
                                <!-- <td></td> -->
                                <td>HomeTracker Progress
                                <a onclick="modal(event)"data-target="#addModal4" class="btn " title="Home Tracker Status View" style="margin-inline:5px" id="home"><i class="fa fa-arrow-circle-o-right" style="color:white!important;background-color:blue!important;font-size: 23px;"></i></a>
                                  <div class="progress" style="height: 25px;">
                                  <div class="progress-bar" role="progressbar" aria-valuemax="100"style="font-weight: bolder;color:white; width:35%;background-color:orange;">30/240</div>
                                 </div></td>
                                <td>2022-11-12 12:43:34</td>
                             </tr>
                                                     

                            
                           
                             <tr>
                                <td>10</td>
                                <td>EN/2022/12/025</td>
                                <td>Kaviya</td>
                                <!-- <td></td> -->
                                <td>Week4-Weekly Feedback Progress
                                <a onclick="modal(event)"  data-target="#addModal2" class="btn " title="Weekly Feedback Status View" style="margin-inline:5px" id="weekly"><i class="fa fa-arrow-circle-o-right" style="color:white!important;background-color:blue!important;font-size: 23px;"></i></a>

                                <div class="progress" style="height: 25px;">
                                
                                  <div class="progress-bar" role="progressbar" aria-valuemax="100"style="font-weight: bolder;color:white; width:100%;background-color:orange;width:25%;">4/32</div>
                                 </div>
                                </td>
                                <td>2022-12-17 12:43:34</td>
                             </tr>
                             <tr>
                                <td>11</td>
                                <td>EN/2022/12/025</td>
                                <td>Kaviya</td>
                                <!-- <td></td> -->
                                <td>Monthly Review Meeting Invite Sent
                                  </td>
                                <td>2022-12-16 12:43:34</td>
                             </tr>
                             <tr>
                                <td>12</td>
                                <td>EN/2022/12/025</td>
                                <td>Kaviya</td>
                                <!-- <td></td> -->
                                <td>Monthly Review Meeting Completed
                                  </td>
                                <td>2022-12-16 12:43:34</td>
                             </tr>
                             
                             <tr>
                                <td>13</td>
                                <td>EN/2022/12/025</td>
                                <td>Kaviya</td>
                                <!-- <td></td> -->
                                <td>Month2-Monthly Objective Progress
                                <a onclick="modal(event)"  data-target="#addModal3" class="btn " title="Monthly Objective Status View" style="margin-inline:5px" id="monthly"><i class="fa fa-arrow-circle-o-right" style="color:white!important;background-color:blue!important;font-size: 23px;"></i></a>

                                  <div class="progress" style="height: 25px;">
                                  <div class="progress-bar" role="progressbar" aria-valuemax="100"style="font-weight: bolder;color:white; width:100%;background-color:orange;width:25%;">1/8</div>
                                 </div></td>
                                <td>2022-12-30 12:43:34</td>
                             </tr>

                             <tr>
                                <td>14</td>
                                <td>EN/2022/12/025</td>
                                <td>Kaviya</td>
                                <!-- <td></td> -->
                                <td>Month1-Observation
                                  
                                <a onclick="modal(event)"  data-target="#addModal3" class="btn " title="Monthly Objective Status View" style="margin-inline:5px" id="observation"><i class="fa fa-arrow-circle-o-right" style="color:white!important;background-color:blue!important;font-size: 23px;"></i></a>

                                  <div class="progress" style="height: 25px;">
                                  <div class="progress-bar" role="progressbar" aria-valuemax="100"style="font-weight: bolder;color:white; width:100%;background-color:orange;width:25%;">1/8</div>
                                 </div></td>
                                <td>2023-01-03 12:43:34</td>
                             </tr>

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


<script src="https://code.jquery.com/jquery-1.7.2.min.js"></script>
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


  function modal(event) {
    //alert("bjsd");
    //alert(event.target.parentElement.id);
    if((event.target.id=="weekly")||(event.target.parentElement.id=="weekly"))
    {
      //alert("bjn");
      window.location.href = "http://localhost:60161/weeklyfeedback?Message2='ojj'#addModal2";

    }
   else if((event.target.id=="monthly")||(event.target.parentElement.id=="monthly"))
    {
      //alert("bjn");
      window.location.href = "http://localhost:60161/monthlyobjective?Message2='ojj'#addModal3";

    }
    else if((event.target.id=="home")||(event.target.parentElement.id=="home"))
    {
      //alert("bjn");
      window.location.href = "http://localhost:60161/hometracker?Message2='ojj'#addModal4";


    }
    else if((event.target.id=="therapistsession")||(event.target.parentElement.id=="therapistsession"))
    {
      //alert("bjn");
      window.location.href = "http://localhost:60161/therapist?Message2='ojj'#addModal4";

      
    }

    else if((event.target.id=="observation")||(event.target.parentElement.id=="observation"))
    {
      //alert("bjn");
      window.location.href = "http://localhost:60161/compassobservation?Message2='ojj'#addModal6";

      
    }
    

    
  }

  


</script>


@endsection