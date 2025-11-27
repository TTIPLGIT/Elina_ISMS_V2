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

    /* body{
        background-color: white !important;
    } */
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

    .nav-justified {
        display: flex !important;
        align-items: center !important;
    }

    hr {
        border-top: 1px solid #6c757d !important;
    }

    .dateformat {
        height: 41px;
        padding: 8px 10px !important;
        width: 100%;
        border-radius: 5px !important;
        border-color: #bec4d0 !important;
        box-shadow: 2px 2px 4px rgb(0 0 0 / 15%);
        border-style: outset;
    }
</style>

<div class="main-content">

    <div class="row">
        <div class="col-lg-12 text-center" style="padding: 10px;">
            <h4 style="color:darkblue;">Lead Details</h4>
        </div>
        <div class="col-12">

            <div class="card" style="height:100%; padding: 15px; background-color:white">
                <section class="section">
                    <div class="section-body mt-1">
                        <!-- <hr> -->
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label" style="font-size: medium;">Unique ID </label>
                                    <input class="form-control" type="text" value="{{ $rows[0]['unique_id']}}" readonly>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label" style="font-size: medium;">Child's Name: </label>
                                    <input class="form-control" type="text" value="{{ $rows[0]['name']}}" readonly>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label" style="font-size: medium;">Child's Date of Birth:</label>
                                    <input class="form-control" type="text" value="{{ $rows[0]['child_dob']}} " readonly>
                                </div>
                            </div>
                            <!-- <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label" style="font-size: medium;">Child's Age</label>
                                        <input class="form-control" type="text" value="{{ $rows[0]['age']}} " readonly>
                                </div>
                            </div> -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label" style="font-size: medium;">Child's Gender:</label>
                                    <br>
                                    <input type="radio" value="Male" {{ ($rows[0]['gender']=="Male")? "checked" : "disabled" }}><label for="featured-1" style="padding: 5px;">Male</label>
                                    <input type="radio" value="Female" {{ ($rows[0]['gender']=="Female")? "checked" : "disabled" }}><label for="featured-2" style="padding: 5px;">Female</label>
                                </div>
                            </div>
                        </div>

                        <!-- <hr> -->
                        <!-- <h5 style="font-weight: bold; display:flex;   width: fit-content; padding: -13px;margin-top: -18px;margin-left: auto;margin-right: auto;padding: 5px;background-color: white;">Contact Details</h5> -->
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label" style="font-size: medium;">Child's Parent/Guardian</label>
                                    <input class="form-control " type="text" value="{{ $rows[0]['parentname']}}" disabled="">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label" style="font-size: medium;">Child Relationship with child</label>
                                    <input class="form-control " type="text" value="{{ $rows[0]['childrelationship']}}" disabled="">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label" style="font-size: medium;">Email Address</label>
                                    <input id="child_contact_email" type="email" class="form-control" value="{{ $rows[0]['email_id']}}" disabled="">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label" style="font-size: medium;">Phone Number</label>
                                    <input class="form-control " type="text" value="{{ $rows[0]['phone_no']}}" disabled="">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label" style="font-size: medium;">Child's Current School</label>
                                    <textarea class="form-control child_school_name_address" type="textarea" value="{{ $rows[0]['child_school']}}" disabled="">{{ $rows[0]['child_school']}}</textarea>
                                </div>
                            </div>

                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label" style="font-size: medium;">Know about us</label>
                                    <input id="child_contact_email" type="email" class="form-control" name="child_contact_email" value="{{ $rows[0]['knowaboutUs']}}" disabled="">
                                </div>
                            </div>

                            @if($rows[0]['knowaboutUs'] == 'Others')
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label" style="font-size: medium;">Specify Others (if any)</label>
                                    <input id="child_contact_email" type="email" class="form-control" name="child_contact_email" value="{{ $rows[0]['challenges']}}" disabled="">
                                </div>
                            </div>
                            @endif

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label" style="font-size: medium;">Reason For Contacting</label>
                                    <input class="form-control" type="text" value="{{ $rows[0]['contact_reason']}}" disabled="">
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12 text-center">
                            <a type="button" href="{{ route('home') }}" class="btn btn-labeled btn-danger back-btn" title="Cancel" style="color:white !important"><span class="btn-label" style="font-size:13px !important;"><i class="fa fa-times"></i></span> Cancel</a>
                        </div>
                    </div>
                </section>
            </div>

        </div>
    </div>
</div>

@endsection