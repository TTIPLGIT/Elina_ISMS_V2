@extends('layouts.adminnav')

@section('content')
<style>
    input[type=checkbox] {
        display: inline-block;
    }

    .no-arrow {
        -moz-appearance: textfield;
    }

    .no-arrow::-webkit-inner-spin-button {
        display: none;
    }

    .no-arrow::-webkit-outer-spin-button,
    .no-arrow::-webkit-inner-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }

    .nav-tabs {
        background-color: #0068a7 !important;
        border-radius: 29px !important;
        padding: 1px !important;

    }

    .nav-item.active {
        background-color: #0e2381 !important;
        border-radius: 31px !important;
        height: 100% !important;
    }

    .nav-link.active {
        background-color: #0e2381 !important;
        border-radius: 31px !important;
        height: 100% !important;
    }

    :root {
        --borderWidth: 5px;
        --height: 24px;
        --width: 12px;
        --borderColor: #78b13f;
    }



    .check {
        display: inline-block;
        transform: rotate(50deg);
        height: var(--height);
        width: var(--width);
        border-bottom: var(--borderWidth) solid var(--borderColor);
        border-right: var(--borderWidth) solid var(--borderColor);
    }

    .nav-justified {
        display: flex !important;
        align-items: center !important;
    }

    .gender {
        display: flex;
        align-items: center;
        justify-content: space-evenly;
    }

    .egc {
        display: flex;
        border: 1px solid #350756;
        padding: 8px 25px 8px 8px;
        align-items: center;

        justify-content: space-between;
    }

    .dq {
        font-size: 16px;
        width: 80%;
        font-weight: 600;
    }

    .answer {
        width: 15%;
        display: flex;
        color: #04092e !important;
        justify-content: space-around;
    }

    .questions {
        color: #000c62 !important
    }

    input[type='radio']:checked:after {
        background-color: #34395e !important;
    }

    input[type='radio']:after {
        background-color: #34395e !important;
    }

    /* radiocss */
    .switch-field {
        display: flex;


    }

    .switch-field input {
        position: absolute !important;
        clip: rect(0, 0, 0, 0);
        height: 1px;
        width: 1px;
        border: 0;
        overflow: hidden;
    }

    .switch-field label {
        background-color: #e4e4e4;
        color: rgba(0, 0, 0, 0.6);
        font-size: 14px;
        line-height: 1;
        text-align: center;
        padding: 8px 16px;
        margin-right: -1px;
        border: 1px solid rgba(0, 0, 0, 0.2);
        box-shadow: inset 0 1px 3px rgba(0, 0, 0, 0.3), 0 1px rgba(255, 255, 255, 0.1);
        transition: all 0.1s ease-in-out;
    }

    .switch-field label:hover {
        cursor: pointer;
    }

    .switch-field input:checked+label {
        background-color: #a5dc86;
        box-shadow: none;
    }

    .switch-field label:first-of-type {
        border-radius: 4px 0 0 4px;
    }

    .switch-field label:last-of-type {
        border-radius: 0 4px 4px 0;
    }

    /* endcss */
    .vl {
        border-left: 1px solid #350756;
        height: 40px;
    }

    .close {
        color: white;
        opacity: 1;
    }
</style>

@if (session('success'))
<input type="hidden" name="session_data" id="session_data" class="session_data" value="{{ session('success') }}">
<script type="text/javascript">
    window.onload = function() {
        var message = $('#session_data').val();
        Swal.fire('Success!', message, 'success');
    }
</script>
@elseif(session('fail'))
<input type="hidden" name="session_data" id="session_data1" class="session_data" value="{{ session('fail') }}">
<script type="text/javascript">
    window.onload = function() {
        var message = $('#session_data1').val();
        Swal.fire('Info!', message, 'info');
    }
</script>
@endif

<div class="main-content">
    {{ Breadcrumbs::render('newenrollment.index') }}
    <div class="row">
        <div class="col-12">
            @if ($rows==[])
            @if(strpos($screen_permission['permissions'], 'Create') !== false)
            <a type="button" href="{{ route('newenrollment.create') }}" value="Cancel" class="btn btn-labeled btn-info" title="create" style="background: #044a95 !important; border-color:#a9ca !important; color:white !important;margin-top: 0.5rem;">
                <span class="btn-label" style="font-size:15px !important; padding:8px !important"><i class="fa fa-plus"></i></span><span style="font-size:15px !important; padding:8px !important">NewEnrollment</span></a>
            @endif
            @endif
           {{-- @if(strpos($screen_permission['permissions'], 'Agreement') !== false)
            <a type="button" href="{{ route('privacy.update',\Crypt::encrypt('3')) }}" value="Edit Text" class="btn btn-labeled btn-info" title="create" style="background: #044a95 !important; border-color:#a9ca !important; color:white !important;margin-top: 0.5rem;">
                <span class="btn-label" style="font-size:15px !important; padding:8px !important"><i class="fa fa-font"></i></span><span style="font-size:15px !important; padding:8px !important">Consent Form</span></a>
            @endif --}}
            <div class="card">
                <div class="card-body">
                    <div class="col-lg-12 text-center mb-3">
                        <h4 style="color:darkblue;">Child Enrollment Details</h4>
                    </div>
                    <div class="table-wrapper">
                        <div class="table-responsive">
                            <table class="table table-bordered" id="align">
                                <thead>
                                    <tr>
                                        <th>S.No</th>
                                        <th>Child Name</th>
                                        <th>Email Address</th>
                                        <th>Enrollment number</th>
                                        <!-- <th>Child number</th> -->
                                        <th>Status</th>
                                        <!-- <th>Consent Acknowledge</th> -->
                                        <th style="width: 100px;">Action</th>

                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($rows as $key=>$row)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $row['child_name']}}</td>
                                        <td>{{ $row['child_contact_email']}}</td>
                                        <td>{{ $row['enrollment_child_num']}}</td>
                                        <!-- <td>{{ $row['child_id']}}</td> -->
                                        @if($row['consent_aggrement'] == null)
                                        <td>Saved</td>
                                        @else
                                        <td>{{ $row['status']}}</td>
                                        @endif
                                        <!-- @if($row['consent_aggrement'] == null)
                                        <td> Pending </td>
                                        @else
                                        <td>{{$row['consent_aggrement']}}</td>
                                        @endif -->
                                        <td>
                                            @php
                                            $folderPath = $row['child_contact_email'];
                                            $consent = '/demo_document/'.$folderPath.'/Consent_form_'.$row['child_name'].'.pdf';
                                            @endphp
                                            {{-- @if($row['status'] != 'saved')
                                            <a class="btn btn-primary" title="View Document" data-toggle="modal" data-target="#templates" onclick="getproposaldocument('{{$consent}}')" style="margin-inline:5px"><i class="fa fa-download" style="color:white!important"></i></a>
                                            @endif --}}
                                            @if(strpos($screen_permission['permissions'], 'Show') !== false)
                                            <a class="btn btn-link" title="Show" href="{{ route('newenrollment.show',\Crypt::encrypt($row['enrollment_id'])) }}"><i class="fas fa-eye" style="color:green"></i></a>
                                            @endif
                                            @if(strpos($screen_permission['permissions'], 'Edit') !== false)
                                            @if($row['consent_aggrement'] != [])
                                            <a class="btn btn-link" title="Edit" href="{{ route('newenrollment.edit',\Crypt::encrypt($row['enrollment_id'])) }}"><i class="fas fa-pencil-alt" style="color: blue !important"></i></a>
                                            @endif
                                            @endif
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="https://code.jquery.com/jquery-1.7.2.min.js"></script>
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

@include('newenrollement.formmodal')

@endsection