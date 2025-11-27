<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <title>ELINA ISMS</title>

  <!-- Fonts -->
  <link href="{{ asset('css/login.css') }}" rel="stylesheet">
  <link href="{{ asset('css/app.css') }}" rel="stylesheet">

  <link rel="icon" href="{{ asset('images/fia_logo.png') }}" type="image/gif" sizes="16x16">
  <style type="text/css">
    .btn-login:hover {
      color: #fff !important;
      background-color: #0d2b61 !important;
      border-color: #181053 !important;
    }

    .btn-login:not(:disabled):not(.disabled).active,
    .btn-login:not(:disabled):not(.disabled):active,
    .show>.btn-primary.dropdown-toggle {
      color: #fff !important;
      background-color: #2b1f8f !important;
      border-color: #2b1f8f !important;
    }

    .btn-login {
      color: #fff !important;
      background-color: #0d2b61 !important;
      border-color: #181053 !important;
    }

    .bgimg1 {
      background: #c7c4ff;
      width: 100% !important;
      max-width: 100% !important;
      background-position: center;
      background-repeat: no-repeat;
      background-size: cover;
      position: relative;
      height: 83vh;
    }

    .form-signin .btn {
      font-size: 80%;
      border-radius: 8px;
      letter-spacing: .1rem;
      font-weight: bold;
      padding: 8px;
      transition: all 0.2s;
      width: 100% !important;
    }

    .error {
      color: red;
    }

    .header {
      height: 80px;
      width: 100%;
      margin-left: 0px !important;
      background: #26268d !important;
    }

    .footer {
      background: #26268d !important;
    }

    .inputicon {
      position: absolute;
      margin-left: 21rem;
      margin-top: 5px;
    }

    body {
      height: 80px;
    }

    img {
      margin-right: 123px !important;
    }
    .unique{
      display: block !important;
    }
  </style>
</head>

<body>
  <div class="header row" >


    <div class="col-md-1"><a href="{{route('login')}}"><img class="" style="width: 200% !important;
    display: block;
    margin: 15px; 
    
    text-align: center;
    align-items: center;
    padding: 0;" src="{{asset('assets/images/elina-logo-2.png')}}"></a></div>
    <div class="col-md-11" style="justify-content: center;  
    display: flex;align-items: center;">
      <h2 style="color:#FFF;font-size: 40px!important">ELINA-Intervention Service Management System</h2>
    </div>


  </div>
  <div class="container bgimg1 pt-5 ">
    <div class="row unique">
      <div class="col-lg-4"></div>
      <div class="col-sm-10 col-md-9 col-lg-4 mx-auto">
        <div class="card card-signin">
          <div class="card-body text-center">

            <img src="{{ asset('assets/images/wrong.png') }}" style="width:100px;margin-left:129px;margin-bottom:10px ;" class="alert-image-size ">
            <p class="card-text alert-message-top">Your reset password link session is expired. Please </br>re-initiate your reset password request. .</p>
            <a href="{{ route('home') }}" class="btn btn-success">Ok</a>
          </div>
        </div>
      </div>
    </div>
    <div class="col-lg-4"></div>

  </div>
  </div>
  @include('partials.footer')
</body>

</html>