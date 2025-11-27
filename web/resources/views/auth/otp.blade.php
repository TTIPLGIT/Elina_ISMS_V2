@extends('layouts.app')

@section('content')

<div  class="container_fluid ">
    <div class="justify-content-center">
        <div clas="col-10">
            

            <h1 class="text-center fwcolor">
            <a type="button"  href="{{route('/')}}" class="btn btn-primary bg-243c92 font-weight-bold rounded-halfpill ml-3"><i class="fa fa-arrow-circle-left" aria-hidden="true" style="    font-size: 1.4rem; display: flex;align-items: center;"></i> </a>
 <span class="mx-auto">ELINA SERVICES PORTAL</span>
               
            </h1>
        </div>
    </div>
</div>

<div class="container-fluid mt-lg-4">
    <div class="row justify-content-start">
        <div class="col-10 offset-1 col-sm-7 col-md-6 col-lg-4 col-xl-3 col-xxl-3 col-2560">
            <div class="card border border-4 border-243c92 rounded-3">
                <div class="row justify-content-center">
                    <img class="col-4 mi-3 mt-3 col-sm-5 col-md-4 col-lg-4 col-xl-4 col-xxl-4 " src="images\Elina Images\elina-logo (1).png" alt="logo">
                </div>

                <div class="card-body">
                    <form method="POST" action="{{ route('registerstore') }}">
                        @csrf
                        
                        <div class="row mb-3">

                            <div class="form-label-group col-12">
                                <input id="mobile_no" type="text" class="form-control border border-2 border-243c92 rounded-halfpill" name="Mobile_no" oninput="span(this,'spanmobileno','fnu')" placeholder="Mobile No" maxlength="15"  required  inputmode="numeric"  oninput="formatNumber(event)" >
                                <span class="error-star" id="spanmobileno" style="color:red;     position: absolute;top: 2px;left: 97px;">*</span>

                            </div>
                        </div>
                    <div class="row mb-3">
                        <div class="form-label-group col-12">
                                <input id="OTP" type="text" class="form-control border border-2 border-243c92 rounded-halfpill" name="OTP" oninput="span(this,'spanotp','fnu')" placeholder="OTP" maxlength="4"  required  inputmode="numeric"  oninput="formatNumber(event)" >
                                <span class="error-star" id="spanotp" style="color:red;     position: absolute;top: 2px;left: 97px;">*</span>
                        </div>
                    </div>       
                    
                                <a class="btn btn-success bg-#198754 padding:3px 0; font-weight-bold font-family: 'Barlow Condensed', sans-serif; rounded-halfpill" href="{{route('/')}}">
                                  CONFIRM
                                </a>
                                <a class="btn btn-success bg-#198754 font-weight-bold font-family: 'Barlow Condensed', sans-serif; rounded-halfpill" href="{{route('/')}}">
                                  CANCEL
                                </a>
                        
                            
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="https://code.jquery.com/jquery-1.7.2.min.js"></script>

<script type="text/javascript">
$(document).ready(function() {
    var cd;
    var today = new Date();
var dd = String(today.getDate()).padStart(2, '0');
var mm = String(today.getMonth() + 1).padStart(2, '0'); //January is 0!
var yyyy = today.getFullYear();
var dor = "Date of Registration ";
cd =  dd + '/' + mm + '/' + yyyy;

    document.getElementById('dor').value = cd;
});

function span(a,b,c){
    var a = a.value;
    if(a==""){
        document.getElementById(b).style.display = "block";
   
    }
    else{
        document.getElementById(b).style.display = "none";
    }
    if(c == "fnu"){
    let value =  event.target.value || '';
    value = value.replace(/[^0-9+ ]/,'',);
    event.target.value = value;
    }
    else if(c == "fna"){
        let value =  event.target.value || '';
    value = value.replace(/[^a-z A-Z ]/,'',);
    event.target.value = value;
  
    }
    else{

    }
}

function formatNumber(event){
    let value =  event.target.value || '';
    value = value.replace(/[^0-9+ ]/,'',);
    event.target.value = value;
  
 }
 function formatName(event){
    let value =  event.target.value || '';
    value = value.replace(/[^a-z A-Z ]/,'',);
    event.target.value = value;
  
 }
 
 
$(function(){
  $(".pr-password").passwordRequirements();
  $(".pr-password").passwordRequirements({
  numCharacters: 8,
  useLowercase: true,
  useUppercase: true,
  useNumbers: true,
  useSpecial: true
});
$(".pr-password").passwordRequirements({
  style: "dark"
});
$(".pr-password").passwordRequirements({
  fadeTime: 500
});
});



 </script>
@endsection
