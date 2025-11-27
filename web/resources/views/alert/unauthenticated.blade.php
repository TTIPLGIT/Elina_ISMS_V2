@extends('layouts.unauth')
@section('content')
<div class="main-content">
  <!-- Main Content -->
  <section class="section">
    <div class="section-body mt-1">
      <div class="row alert-row-top">
        <div class="col-md-2"></div>
        <div class="col-md-6">
          <div class="card text-center">
            <div class="card-header alert-head-background" style="justify-content: center;">{{ __('ISMS - Session Expired') }}</div>
            <div class="card-body">
              <img src="{{ asset('images/wrong.png') }}" class="alert-image-size">
              <p class="card-text alert-message-top">Your session has expired / is invalid.</p>
              <a href="{{ route('/') }} " class="btn btn-alert">Ok</a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</div>
@endsection