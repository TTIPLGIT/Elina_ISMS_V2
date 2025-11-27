@extends('layouts.adminnav')

@section('content')
<style>



</style>
<div class="main-content">

  <section class="section">


    <div class="section-body mt-2">


      <div class="row">

        <div class="col-12">
          <a type="button" href="{{ route('performancearea.create') }}" value="Cancel" class="btn btn-labeled btn-info" title="create" style="background: #044a95 !important; border-color:#a9ca !important; color:white !important;margin-top: 0.5rem;">
            <span class="btn-label" style="font-size:15px !important; padding:8px !important"><i class="fa fa-plus"></i></span><span style="font-size:15px !important; padding:8px !important">Create</span></a>
          <div class="card">

            <div class="card-body">
              <div class="row">
                <div class="col-lg-12 text-center">
                  <h4 style="color:darkblue;">Performance Area Master</h4>
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
                        <th>Report</th>
                        <th>Status</th>
                        <th>Action</th>
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


  </section>






</div>


@endsection