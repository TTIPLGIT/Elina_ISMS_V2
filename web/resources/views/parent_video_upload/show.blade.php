@extends('layouts.parent')

@section('content')
<style>
  #frname {
    color: red;
  }

  .centerid {
    width: 100%;
    text-align: center;
  }

  .paymentdetails {
    color: darkblue;
    padding-top: 1rem;
    margin: auto;
    justify-content: center;
  }

  .payinitiate {
    margin: auto;
  }

  .form-note {
    width: 30%;
    display: flex;
    justify-content: center;
    margin: auto;
  }

  .control-notes {
    display: flex;
    justify-content: center;
    font-weight: 800 !important;
    color: #34395e !important;
    font-size: 15px !important;
  }

  /* #invite{
    display: none;
  } */
</style>

<div class="main-content" style="min-height:'60px'">

  <!-- Main Content -->
  <section class="section">
    <div class="section-body mt-1">
      <h5 class="text-center" style="color:darkblue">Parent Video Upload</h5>
      <form action="{{route('videocreation.parentstore')}}" id="userregistration" method="POST">
        @csrf
        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-body">
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label class="control-label">Activity Name</label><span class="error-star" style="color:red;">*</span>
                      <input class="form-control" type="text" id="activity_id" name="activity_id" value="{{ $rows[0]['activity_name']}}" autocomplete="off" readonly>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label class="control-label">Activity Description</label><span class="error-star" style="color:red;">*</span>
                      <input class="form-control" type="text" id="description_id" name="description_id" value="{{ $rows[0]['description']}}" autocomplete="off" readonly>
                    </div>
                  </div>
                  <div class="w-100"></div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label class="control-label">Video Link</label><span class="error-star" style="color:red;">*</span>
                      <div style="display: flex;">
                      <input class="form-control" type="url" id="video_link" name="video_link" autocomplete="off" value="{{$rows[0]['video_link']}}">
                      <a class="btn btn-link" title="show"  target="_blank" href="{{$rows[0]['video_link']}}"><i class="fas fa-eye" style="color:green"></i></a>
                      <!-- <div style="color: rgb(246, 15, 15); display: block;margin: 5px 0px 0px 0px;">Google Drive Link Only</div> -->
                      </div>
                    </div>
                  </div>
                  <input type="hidden" id="activity_description_id" name="activity_description_id" value="{{$rows[0]['activity_description_id']}}">
                  <input type="hidden" id="parent_video_upload_id" name="parent_video_upload_id" value="{{$rows[0]['parent_video_upload_id']}}">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label class="control-label">Comments</label>
                      <textarea class="form-control" name="comments" id="comments"></textarea>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
      </form>
    </div>
  </section>
</div>


























@endsection