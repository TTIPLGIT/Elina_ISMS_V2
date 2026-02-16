@extends('layouts.adminnav')
@section('content')

<div class="main-content">
    <section class="section">

        {{ Breadcrumbs::render('service_briefing.show', $data['id']) }}


        <div class="col-lg-12 text-center">
            <h4 style="color:darkblue;">Service Briefing - View</h4>
        </div>

        <div class="section-body">
            <div class="row">
                <div class="col-12">

                    <div class="card">
                        <div class="card-body">


                            <form>

                                <div class="row">

                                    {{-- Service Briefing --}}
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="control-label">Service Briefing</label>
                                            <input class="form-control"
                                                type="text"
                                                value="{{ $data['service_briefing'] ?? '' }}"
                                                disabled
                                                style="background-color:#f5f5f5;">
                                        </div>
                                    </div>

                                    {{-- Amount --}}
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="control-label">Amount</label>
                                            <input class="form-control"
                                                type="number"
                                                value="{{ $data['amount'] ?? '' }}"
                                                disabled
                                                style="background-color:#f5f5f5;">
                                        </div>
                                    </div>

                                </div>


                                <div class="row mt-3">

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Created At</label>
                                            <input class="form-control"
                                                type="text"
                                                value="{{ isset($data['created_at']) ? \Carbon\Carbon::parse($data['created_at'])->timezone('Asia/Kolkata')->format('d-m-Y') : '' }}"
                                                disabled
                                                style="background-color:#f5f5f5;">


                                        </div>
                                    </div>



                                </div>


                                <div class="d-flex justify-content-center mt-4">
                                    <a href="{{ route('service_briefing.index') }}"
                                        class="btn btn-labeled back-btn"
                                        style="color:white !important;">
                                        <span class="btn-label">
                                            <i class="fa fa-arrow-left"></i>
                                        </span>
                                        Back
                                    </a>
                                </div>

                            </form>

                        </div>
                    </div>

                </div>
            </div>
        </div>
    </section>
</div>

@endsection