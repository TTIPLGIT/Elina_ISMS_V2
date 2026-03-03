@extends('layouts.adminnav')
@section('content')

<div class="main-content">
    <section class="section">
        {{ Breadcrumbs::render('service_briefing.edit', $data['id']) }}


        <div class="col-lg-12 text-center">
            <h4 style="color:darkblue;">Service Briefing - Edit</h4>
        </div>

        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">

                            <form action="{{ route('service_briefing.update', encrypt($data['id'])) }}"
                                method="POST"
                                id="service_briefing_edit">
                                @csrf

                                <div class="row">

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="control-label required">Service Briefing</label>
                                            <input class="form-control"
                                                type="text"
                                                id="service_briefing"
                                                name="service_briefing"
                                                value="{{ $data['service_briefing'] ?? '' }}"
                                                autocomplete="off"
                                                style="background-color:white !important;">
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="control-label required">Amount</label>
                                            <input class="form-control"
                                                type="number"
                                                id="amount"
                                                name="amount"
                                                value="{{ $data['amount'] ?? '' }}"
                                                autocomplete="off"
                                                style="background-color:white !important;">
                                        </div>
                                    </div>

                                </div>

                                <div class="d-flex justify-content-center align-items-center">

                                    <a type="button"
                                        onclick="Submit_form_edit()"
                                        class="btn btn-labeled btn-success"
                                        style="background:green !important;border-color:green !important;color:white !important;margin-right:25px;">
                                        <span class="btn-label">
                                            <i class="fa fa-check"></i>
                                        </span>
                                        Update
                                    </a>

                                    <a type="button"
                                        class="btn btn-labeled back-btn"
                                        href="{{ route('service_briefing.index') }}"
                                        style="color:white !important;">
                                        <span class="btn-label">
                                            <i class="fa fa-arrow-left"></i>
                                        </span>
                                        Back
                                    </a>

                                </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<script>
    function Submit_form_edit() {
        let service = document.getElementById('service_briefing').value;
        let amount = document.getElementById('amount').value;

        if (service === '') {
            Swal.fire({
                icon: 'warning',
                title: 'Required',
                text: 'Service Briefing is required',
                confirmButtonColor: '#3085d6'
            });
            return false;
        }

        if (amount === '') {
            Swal.fire({
                icon: 'warning',
                title: 'Required',
                text: 'Amount is required',
                confirmButtonColor: '#3085d6'
            });
            return false;
        }

        // ✅ Success – submit edit form
        document.getElementById('service_briefing_edit').submit();
    }
</script>

@endsection