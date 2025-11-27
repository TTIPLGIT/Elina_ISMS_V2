@extends('layouts.public')

@section('content')
<div class="main-content">
    <div class="row justify-content-center">
        <div class="col-lg-12 col-md-12">
            <div class="card" style="height:100%; padding: 15px">
                
                <P>We Have submitted your Response<br>
                    thank you!
                </P>
            </div>

        </div>
        <div class="col-md-12 text-center " style="    margin-top: 5px;">
        
          
            <a type="button" href="{{url('enrollnow')}}" id="submitbutton" class="btn btn-labeled btn-succes" title="Create New" style="background: green !important; border-color:green !important; color:white !important">
                <span class="btn-label" style="font-size:13px !important;"><i class="fa fa-plus"></i></span> Create New </a>
                <a type="button" href="{{route('/')}}" id="submitbutton" class="btn btn-labeled btn-succes" title="Home" style="background: #00b6bf !important; border-color:#00b6bf !important; color:white !important">
                <span class="btn-label" style="font-size:13px !important;"><i class="fa fa-home"></i></span> Home </a>
        </div>
    </div>
</div>
@endsection