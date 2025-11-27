@extends('layouts.adminnav')
@section('content')
<div class="main-content">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.16/dist/sweetalert2.all.min.js"></script>
{{ Breadcrumbs::render('TherapistdetailsList') }}
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
       
        <!-- <a type="button" href="" value="" class="btn btn-labeled btn-info" title="create" style="background: #044a95 !important; border-color:#a9ca !important; color:white !important;margin: 0 0 2px 15px;">
          <span class="btn-label" style="font-size:15px !important; padding:8px !important"><i class="fa fa-plus"></i></span><span style="font-size:15px !important; padding:8px !important">Therapist Details</span></a>
          -->
        <div class="col-12">
          <div class="card">
            <div class="card-body">
              <div class="row">
                <div class="col-lg-12 text-center">
                  <h4 style="color:darkblue;">Therapist Directory </h4>
                </div>
              </div>
              <div class="table-wrapper">
                <div class="table-responsive">
                  <table class="table table-bordered" id="align">
                    <thead>
                     
                        <th width="4%">Sl.No.</th>
                        <th width="17%">Therapist Name</th>
                        <th width="15%">Therapy Area </th>
                        <th width="19%">Therapist Email</th>
                        <th  width="10%">Phone number</th>
                        <th width="10%">Location</th>
                        
                        <th width="13%">Action</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <td>1</td>
                        <td>Sumithra Shailesh</td>
                        <td>Speech Therapy</td>
                        <td>sumithra@elinaservices.in</td>
                        <td>9778361562</td>
                        <td>Hiranandani</td> 
                        


                        <td>
                          <a class="btn btn-link" title="Show" href="{{ route('TherapistdetailsListShow',1) }}" ><i class="fas fa-eye" style="color: blue !important"></i></a>
                           <a class="btn btn-link" title="Edit" href="{{ route('TherapistdetailsListedit','2') }}" ><i class="fas fa-pencil-alt" style="color:green"></i></a>
                          </td>   
                      </tr>

                      <tr>
                        <td>2</td>
                        <td>Lakshmi Narayanan</td>
                        <td>Speech Therapy</td>
                        <td>abilities.mrc@gmail.com laksh2706@gmail.com </td>
                        <td>9629971168</td>
                        <td>Adyar</td>
                        
                        <td>
                          <a class="btn btn-link" title="Show" href="{{ route('TherapistdetailsListShow',1) }}" ><i class="fas fa-eye" style="color: blue !important"></i></a>
                           <a class="btn btn-link" title="Edit" href="{{ route('TherapistdetailsListedit',1) }}"><i class="fas fa-pencil-alt" style="color:green"></i></a>
                          </td>   
                      </tr>
                      <tr>
                        <td>3</td>
                        <td>Srilakshmi</td>
                        <td>Special Education</td>
                        <td>laksh2706@gmail.com </td>
                        <td>9629971168</td>
                        <td>Online</td>
                                              
                        <td>
                          <a class="btn btn-link" title="Show" href="{{ route('TherapistdetailsListShow',1) }}" ><i class="fas fa-eye" style="color: blue !important"></i></a>
                           <a class="btn btn-link" title="Edit" href="{{ route('TherapistdetailsListedit',1) }}" ><i class="fas fa-pencil-alt" style="color:green"></i></a>
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
            <h4 class="modal-title">Therapist Activity</h4>
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