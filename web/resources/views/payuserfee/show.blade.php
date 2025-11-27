@extends('layouts.parent')
@section('content')

<div class="main-content">
  <section class="section">
    {{ Breadcrumbs::render('payuserfee.show',$rows[0]['payment_status_id']) }}
    <div class="section-body mt-1">
      <h4 class="text-center screen-title">Payment Details</h4>
      @foreach($rows as $key=>$row)
      <div class="row">
        <div class="col-12">
          <div class="card">
            <div class="card-body">
              <div class="row">
                <div class="col-md-4">
                  <div class="form-group">
                    <label class="control-label">Enrollment ID</label>
                    <input class="form-control" type="text" id="enrollment_child_num" name="enrollment_child_num" value="{{$row['enrollment_child_num'] }}" autocomplete="off" disabled>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <label class="control-label">Child ID</label>
                    <input class="form-control" type="text" id="child_id" name="child_id" value="{{$row['child_id'] }}" autocomplete="off" disabled>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <label class="control-label">Child Name</label>
                    <input class="form-control" type="text" id="child_name" value="{{$row['child_name'] }}" name="child_name" autocomplete="off" disabled>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <label class="control-label">Initiated To</label>
                    <input class="form-control" type="text" id="initiated_to" name="initiated_to" value=" {{$row['initiated_to'] }}" autocomplete="off" disabled>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <label class="control-label">Payment Fee</label>
                    <input class="form-control" id="payment_amount" name="payment_amount" value="{{ $row['payment_amount']}}" autocomplete="off" disabled>
                  </div>
                </div>
                <br>
                <div class="col-md-4">
                  <div class="form-group">
                    <label class="control-label">Status</label>
                    <input class="form-control" type="text" id="payment_status" name="payment_status" value="{{ $row['payment_status']}}" autocomplete="off" disabled>
                  </div>
                </div>
                <div class="form-notes d-none">
                  <label class="control-notes">Notes</label>
                  <textarea class="form-control form-note" type="textarea" id="payment_process_description" name="payment_process_description" value="{{ $row['payment_process_description']}}" disabled>{{ $row['payment_process_description']}}</textarea>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-md-12 text-center">
        <a type="button" class="btn btn-labeled responsive-button button-style back-button" href="{{ route('payuserfee.index') }}" title="Back">
          <i class="fas fa-arrow-left"></i><span> Back </span>
        </a>
      </div>
      @endforeach
  </section>
</div>
@endsection