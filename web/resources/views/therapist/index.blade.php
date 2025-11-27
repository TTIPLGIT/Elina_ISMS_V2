@extends('layouts.adminnav')
@section('content')
<style>

</style>
<div class="main-content">
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.16/dist/sweetalert2.all.min.js"></script>
  {{ Breadcrumbs::render('Therapist') }}
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
              type: "success",
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
              type: "info",
            });
          }
        </script>
        @endif

        <!-- <a  href="#addcal" data-toggle="modal" data-target="#addcal" class="btn btn-labeled btn-info" title="create" data-target="#templates" style="background:#044a95 !important; border-color:#a9ca !important; color:white !important;margin: 0 0 2px 15px;">
          <span class="btn-label" style="font-size:15px !important; padding:8px !important"><i class="fa fa-plus"></i></span><span style="font-size:15px !important; padding:8px !important">Therapist Initiation</span></a>
          -->
        <a type="button" href="{{route('therapist.weeeklycal')}}" value="" class="btn btn-labeled btn-info" title="initiate" style="background: #044a95 !important; border-color:#a9ca !important; color:white !important;margin: 0 0 2px 15px;">
          <span class="btn-label" style="font-size:15px !important; padding:8px !important"><i class="fa fa-plus"></i></span><span style="font-size:15px !important; padding:8px !important">Therapist Initiation</span></a>


        <!-- <a type="button"  href="{{route('TherapistInit')}}"value="" class="btn btn-labeled btn-info" title="initiate" style="background: #044a95 !important; border-color:#a9ca !important; color:white !important;margin: 0 0 2px 15px;">
             <span class="btn-label" style="font-size:15px !important; padding:8px !important"><i class="fa fa-plus"></i></span><span style="font-size:15px !important; padding:8px !important">Therapist Initiation</span></a> -->

        <div class="col-12">
          <div class="card">
            <div class="card-body">
              <div class="row">
                <div class="col-lg-12 text-center">
                  <h4 style="color:darkblue;">Therapist Mapping View</h4>
                </div>
              </div>
              <div class="table-wrapper">
                <div class="table-responsive">
                  <table class="table table-bordered" id="align">
                    <thead>

                      <tr>
                        <th width="7%">Sl. No.</th>
                        <th width="15%">Enrollment Id</th>
                        <th width="10%">Child Name</th>
                        <th width="14%">IS Coordinators</th>
                        <th width="10%">Therapist</th>
                        <th width="12%">Specialization</th>
                        <th width="12%">Status</th>
                        <th width="13%">Action</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <td>1</td>
                        <td>EN/2022/12/025</td>
                        <td>Kaviya</td>
                        <td>Robert</td>
                        <td> Malini </td>
                        <td>Speech</td>
                        <td>Monthly Review Meeting Invite Sent</td>


                        <td class="text-center">
                          <a href="#addModal5" data-toggle="modal" data-target="#addModal5" class="btn btn-primary" title="View" data-toggle="modal" data-target="#templates" style="margin-inline:5px"><i class="fa fa-bars" style="color:white!important"></i></a>
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


<div class="modal fade" id="addcal">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <div class="main-contents">
        <section class="section">
          <div class="modal-header bg-primary" style=" background-color: blue !important;">
            <h4 class="modal-title">Therapist Weekly Mapping</h4>
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          </div>
          <div class="modal-body" style="background-color: #edfcff !important;">
            <div class="section-body mt-2">
              <div class="row">
                <div class="col-12">
                  <div class="mt-0 ">
                    <div class="card-body" id="card_header" style="background-color:#008eff99 !important;">
                      <div class="row">

                        <div class="col-md-4">
                          <div class="form-group" style="display:flex;justify-content:space-evenly;">
                            <label class="control-label">Month</label>
                            <input type='month' class="form-control" id='month' name="month" title="Month" value="2022-12" required>
                          </div>
                        </div>



                      </div>
                      <div class="table-wrapper">
                        <div class="table-responsive  p-3">
                          <table class="table table-bordered ">
                            <thead>
                              <tr>
                                <th>Week1</th>
                                <th>Week2</th>
                                <th>Week3</th>
                                <th>Week4</th>

                              </tr>
                              <tr>
                                <th>Week5</th>
                                <th>Week6</th>
                                <th>Week7</th>
                                <th>Week8</th>
                              </tr>
                              <tr>
                                <th>Week9</th>
                                <th>Week10</th>
                                <th>Week11</th>
                                <th>Week12</th>
                              </tr>
                              <tr>
                                <th>Week13</th>
                                <th>Week14</th>
                                <th>Week15</th>
                                <th>Week16</th>
                              </tr>
                              <tr>
                                <th>Week17</th>
                                <th>Week18</th>
                                <th>Week19</th>
                                <th>Week20</th>
                              </tr>
                              <tr>
                                <th>Week21</th>
                                <th>Week22</th>
                                <th>Week23</th>
                                <th>Week24</th>
                              </tr>
                              <tr>
                                <th>Week25</th>
                                <th>Week26</th>
                                <th>Week27</th>
                                <th>Week28</th>
                              </tr>
                              <tr>
                                <th>Week29</th>
                                <th>Week30</th>
                                <th>Week31</th>
                                <th>Week32</th>
                              </tr>

                            </thead>
                            <tbody>


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
</div>

@include('modal.modal')

<script src="https://code.jquery.com/jquery-1.7.2.min.js"></script>
<script type="application/javascript">
  window.onload = function () {
    let url = new URL(window.location.href)
    let message = url.searchParams.get("Message2");
    if(message !=null)
    {
        $("#addModal5").modal('show');
        window.history.pushState("object or string", "Title", "/therapist/");
    }

    };
  function myFunction(id) {



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
</script>
<script>
  setTimeout(func, 2000);

  function func() {
    let url = new URL(window.location.href)

    let message = url.searchParams.get("message2");

    if (message != null) {
      Swal.fire({
        title: "Success",
        text: "Session Sent Successfully",
        icon: "success",
      });
    }
  };
</script>

<script>
  setTimeout(func, 2000);

  function func() {
    let url = new URL(window.location.href)

    let message = url.searchParams.get("message3");

    if (message != null) {
      Swal.fire({
        title: "Success",
        text: "Monthly Therapist Review Meeting Sent Successfully",
        icon: "success",
      });
    }
  };
</script>

  

<script>
  setTimeout(func, 2000);

  function func() {
    let url = new URL(window.location.href)

    let message = url.searchParams.get("message4");

    if (message != null) {
      Swal.fire({
        title: "Success",
        text: "Monthly Therapist Review Meeting  Sent Successfully",
        icon: "success",
      });
    }
  };
</script>

<script>
  setTimeout(func, 2000);

  function func() {
    let url = new URL(window.location.href)

    let message = url.searchParams.get("message5");

    if (message != null) {
      Swal.fire({
        title: "Success",
        text: "Monthly Parents Review Meeting  Sent Successfully",
        icon: "success",
      });
    }
  };
</script>



@endsection