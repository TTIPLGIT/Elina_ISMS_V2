@extends('layouts.adminnav')
@section('content')
<div class="main-content">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.16/dist/sweetalert2.all.min.js"></script>
{{ Breadcrumbs::render('TherapistList') }}
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
        <a type="button" href="{{route('TherapistdetailsList')}}" value="" class="btn btn-labeled btn-info" title="create" style="background: #044a95 !important; border-color:#a9ca !important; color:white !important;margin: 0 0 2px 15px;">
          <span class="btn-label" style="font-size:15px !important; padding:8px !important"><i class="fa fa-plus"></i></span><span style="font-size:15px !important; padding:8px !important">Therapist Details</span></a>
         
        <div class="col-12">
          <div class="card">
            <div class="card-body">
              <div class="row">
                <div class="col-lg-12 text-center">
                  <h4 style="color:darkblue;">Therapist Allocated Session Details</h4>
                </div>
              </div>
              <div class="table-wrapper">
                <div class="table-responsive">
                  <table class="table table-bordered" id="align">
                    <thead>
                      <tr>
                        <th width="4%">Sl.No.</th>
                        <th width="22%">Enrollment Id</th>
                        <th width="17%">Parent Email Id</th>
                        <th width="10%">Special Education</th>
                        <th  width="10%">Operational Therapist</th>
                        <th width="10%">Speech Therapist</th>
                        <th width="10%">Physical Education</th>
                        <th width="13%">Action</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <td>1</td>
                        <td>EN/2022/Dec/001(Nandhan)</td>
                        <td>Jaykersm@gmail.com</td>
                        <td>Sumi 2(40)</td>
                        <td>Sukanya 2(40)</td>
                        <td>NA</td>
                        <td>Stephen 2(40)</td> 
                        


                        <td>
                          <a class="btn btn-link" title="Show"  href="{{ route('TherapistListShow',1) }}"><i class="fas fa-eye" style="color: blue !important"></i></a>
                          </td>   
                      </tr>

                      <tr>
                        <td>2</td>
                        <td>EN/2022/Dec/002(Aniv)</td>
                        <td>priya.infotech07@gmail.com</td>
                        <td>Renuka 2(40)</td>
                        <td>Sukanya 2(40)</td>
                        <td>NA</td>
                        <td>Stephen 2(40)</td> 
                        
                        <td>
                          <a class="btn btn-link" title="Show"  href="{{ route('TherapistListShow',1) }}" ><i class="fas fa-eye" style="color: blue !important"></i></a>
                          </td>   
                      </tr>
                      <tr>
                        <td>3</td>
                        <td>EN/2022/Dec/003(Ananda Boda)</td>
                        <td>sruthivboda@gmail.com</td>
                        <td>NA </td>
                        <td>Raji/Shibila 2(40)</td>
                        <td>LN 2(40)</td>
                        <td>Stephen 2(40)</td> 
                        
                        <td>
                          <a class="btn btn-link" title="Show"  href="{{ route('TherapistListShow',1) }}" ><i class="fas fa-eye" style="color: blue !important"></i></a>
                          </td>   
                      </tr>


                    </tbody>
                  </table>
                  <p><b>Therapist Name - Session Completed(Session Scheduled)</b></p>

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
            <h4 class="modal-title">CoMPASS Activity</h4>
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
                                <td>1</td>
                                <td>EN/2022/12/025</td>
                                <td>Nandhan R S</td>
                                <!-- <td></td> -->
                                <td>Payment Completed</td>
                                <td>2022-11-07 10:43:34</td>
                             </tr>
                             <tr>
                                <td>2</td>
                                <td>EN/2022/12/025</td>
                                <td>Nandhan R S</td>
                                <!-- <td></td> -->
                                <td>Payment Initiated</td>
                                <td>2022-11-07 10:42:30</td>
                              </tr>
                              <tr>
                                <td>3</td>
                                <td>EN/2022/12/025</td>
                                <td>Nandhan R S</td>
                                <!-- <td></td> -->
                                <td>Consent&Snapshot Sent</td>
                                <td>2022-11-07 10:38:59</td>
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
</script>
<script>
    setTimeout(func,2000);function func(){
  let url = new URL(window.location.href)
  
        let message = url.searchParams.get("message2");
    
      if(message!=null){
        Swal.fire({
                    title: "Success",
                    text: "Therapist Initiated Successfully",
                    icon: "success",
                  });
      }
    };
</script>


@endsection