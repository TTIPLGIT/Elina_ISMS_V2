@extends('layouts.adminnav')
@section('content')


<style>
    /* General reset and layout */
    body {
        font-family: 'Arial', sans-serif;
        background-color: #f4f7fc;
        color: #333;
        margin: 0;
        padding: 0;
    }

    /* Tab container styling */
    .tabs {
        display: flex;
        margin-bottom: 5px;
        border-bottom: 2px solid #ddd;
        background-color: #ffffff;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        padding: 10px;
    }

    /* Individual tab item styles */
    .tab-item {
        padding: 15px 30px;
        cursor: pointer;
        font-size: 16px;
        font-weight: 500;
        color: #6c6c6c;
        transition: all 0.3s ease;
        border-radius: 5px 5px 0 0;
        text-align: center;
    }

    .tab-item:hover {
        background-color: #f1f1f1;
        color: #007bff;
    }

    /* Active tab styles */
    .tab-item.active {
        background-color: #007bff;
        color: white;
        box-shadow: 0 2px 10px rgba(0, 123, 255, 0.4);
    }

    /* Content container styling */
    .tab-content {
        display: none;
        /* padding: 30px; */
        background-color: #fff;
        border-radius: 0 0 5px 5px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        margin-top: -1px;
    }

    /* Active content visibility */
    .tab-content.active {
        display: block;
    }

    /* Sub-tabs under "Schools" */
    .sub-tabs {
        display: flex;
        justify-content: space-between;
        /* margin-top: 20px; */
    }

    .sub-tabs .tab-item {
        flex-grow: 1;
        text-align: center;
    }

    /* Modern typography */
    h1,
    h2,
    h3 {
        color: #333;
        margin-bottom: 20px;
        font-weight: 600;
    }

    ul {
        padding-left: 20px;
    }

    li {
        margin: 10px 0;
        font-size: 14px;
        color: #555;
    }

    /* Responsive design */
    @media (max-width: 768px) {
        .tabs {
            flex-direction: column;
        }

        .sub-tabs {
            flex-direction: column;
        }
    }
</style>
<style>
    a:hover,
    a:focus {
        text-decoration: none;
        outline: none;
    }

    .danger {
        background-color: #ffdddd;
        border-left: 6px solid #f44336;
    }

    #align {
        border-collapse: collapse !important;
    }

    table.dataTable.no-footer {
        border-bottom: .5px solid #002266 !important;
    }

    thead th {
        height: 5px;
        border-bottom: solid 1px #ddd;
        font-weight: bold;
    }
</style>
<style>
    .section {
        margin-top: 20px;
    }
</style>
<style>
    .input-group-text {
        cursor: pointer;
        /* Change cursor to pointer when hovering over the icon */
    }

    table.table-bordered>tbody>tr>td {
        border: 1px solid black !important;
    }
</style>
<style>
    #openModalBtn {
        padding: 10px 20px;
        font-size: 16px;
        cursor: pointer;
    }

    .modal {
        display: none;
        /* Hidden by default */
        position: fixed;
        z-index: 1;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        /* overflow: auto; */
        background-color: rgb(0, 0, 0);
        background-color: rgba(0, 0, 0, 0.4);
        /* Black with opacity */
    }

    .modal-content {
        background-color: #fff;
        margin: 5% auto;
        height: 500px;
        padding: 20px;
        border-radius: 10px;
        width: 60%;
        max-width: 600px;
        box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.2);
    }

    .close-btn {
        color: #aaa;
        font-size: 28px;
        font-weight: bold;
        position: absolute;
        top: 10px;
        right: 20px;
        cursor: pointer;
    }

    .close-btn:hover,
    .close-btn:focus {
        color: black;
        text-decoration: none;
        cursor: pointer;
    }

    /* Timeline styles */
    .timeline {
        margin-top: 20px;
        height: 500px;
        overflow: scroll;
    }

    .timeline-item {
        background-color: #f9f9f9;
        padding: 10px;
        margin-bottom: 15px;
        border-left: 5px solid #3498db;
    }

    .timeline-item h3 {
        margin: 0;
        font-size: 18px;
        font-weight: bold;
    }

    .timeline-item p {
        margin: 5px 0 0;
    }
</style>
<div class="main-content">

    <section class="section">
        {{ Breadcrumbs::render('service_briefing.create') }}

        @if (session('success'))
        <input type="hidden" name="session_data" id="session_data" class="session_data" value="{{ session('success') }}">
        <script type="text/javascript">
            window.onload = function() {
                var message = $('#session_data').val();
                Swal.fire('Success!', message, 'success');
            }
        </script>
        @elseif(session('error'))
        <input type="hidden" name="session_data" id="session_data1" class="session_data" value="{{ session('error') }}">
        <script type="text/javascript">
            window.onload = function() {
                var message = $('#session_data1').val();
                Swal.fire('Info!', message, 'info');
            }
        </script>
        @endif

        <div class="col-lg-12 text-center">
            <h4 style="color:darkblue;">Service Briefing Create</h4>
        </div>
        <div class="section-body">
            <div class="row">
                <div class="col-12">

                    <div class="card">
                        <div class="card-body">


                            <form action="{{ route('service_briefing.store') }}" method="POST" id="service_briefing" enctype="multipart/form-data">

                                @csrf
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="control-label required">Service Briefing</label>
                                            <input class="form-control"
                                                type="text"
                                                id="service_briefings"
                                                name="service_briefing"
                                                placeholder="Service Briefing"
                                                autocomplete="off"
                                                style="background-color: #ffffff !important;">

                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="control-label required">Amount</label>
                                            <input class="form-control"
                                                type="number"
                                                id="amount"
                                                name="amount"
                                                placeholder="Amount"
                                                style="background-color: #ffffff !important;" autocomplete="off">
                                        </div>
                                    </div>

                                </div>
                                <div class="d-flex justify-content-center align-items-center">

                                    <a type="button"
                                        onclick="Submit_form()"
                                        id="submitbutton"
                                        class="btn btn-labeled btn-success"
                                        style="background: green !important;border-color:green !important;color:white !important;margin-right:25px;">
                                        <span class="btn-label">
                                            <i class="fa fa-check"></i>
                                        </span>
                                        Initiate
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
    function Submit_form() {
        let service = document.getElementById('service_briefings').value;
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




        // success – submit form
        document.getElementById('service_briefing').submit();
    }
</script>


@endsection