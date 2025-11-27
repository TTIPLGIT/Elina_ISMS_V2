

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>ISMS</title>
  <!-- General CSS Files -->
  <link href="{{asset('asset/css/fullcal.css')}}" rel="stylesheet" type="text/css" />
  <link href="{{asset('asset/css/css2.css')}}" rel="stylesheet" type="text/css" />
  <link href="{{asset('asset/css/app.min.css')}}" rel="stylesheet" type="text/css" />
  <link href="{{asset('asset/bundles/datatables/datatables.min.css')}}" rel="stylesheet" type="text/css" />
  <link href="{{asset('asset/bundles/datatables/DataTables-1.10.16/css/dataTables.bootstrap4.min.css')}}" rel="stylesheet" />

  <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" type="text/css" rel="stylesheet" />

  <!-- <script src="bs-stepper.min.js"></script> -->
  <!-- <link href="{{asset('asset/css/bs-stepper.css')}}" type="text/css" rel="stylesheet" /> -->

  <!--dropzone css -->
  <!-- jQuery -->
<script src="{{ asset('asset/js/jquery.min.js') }}"></script>
  <!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script> -->
  
          <!-- <link href="{{asset('css/select2.css')}}" type="text/css" rel="stylesheet" /> -->

  <link href="{{asset('css/select2.css')}}" type="text/css" rel="stylesheet" />

  <!-- Template CSS -->
  <link href="{{asset('asset/css/style.css')}}" type="text/css" rel="stylesheet" />

  <link href="{{asset('asset/css/components.css')}}" type="text/css" rel="stylesheet" />
  <!-- Custom style CSS -->
  <link href="{{asset('asset/css/custom.css')}}" type="text/css" rel="stylesheet" />

  <link href="{{asset('asset/css/jquery-ui.css')}}" type="text/css" rel="stylesheet" />
  <link rel="stylesheet" type="text/css" href="{{ asset('css/hummingbird_v1.css') }}">
  <link rel="stylesheet" type="text/css" href="{{ asset('css/hummingbird_treeview.css') }}">
  <link rel="stylesheet" type="text/css" href="https://code.jquery.com/ui/1.10.2/themes/smoothness/jquery-ui.css">
  <script src="https://code.jquery.com/ui/1.10.4/jquery-ui.js"></script>
  <script src="{{ asset('asset/js/jquery-ui.js') }}"></script>
  <script src="{{ asset('asset/js/jquery-ui.min.js') }}"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.2/jquery-ui.min.js"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/css/intlTelInput.min.css" />
  <script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/intlTelInput.min.js"></script>
  <script type="text/javascript" src="{{ asset('js/select2.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.js"></script>
<link href="{{asset('asset/css/sweetalert.min.css')}}" type="text/css" rel="stylesheet" />
<script type="text/javascript" src="https://cdn.rawgit.com/t4t5/sweetalert/v0.2.0/lib/sweet-alert.min.js"></script>
  <link href="{{asset('asset/css/dropzone.css')}}" type="text/css" rel="stylesheet" />
  <script type="text/javascript" src="{{ asset('asset/js/dropzone4.js') }}"></script>
  <script type="text/javascript" src="{{ asset('asset/js/sweetalert2@11.js') }}"></script>
  <link href="{{asset('assets/css/adminnavbar.min.css')}}" rel="stylesheet" type="text/css" />
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="{{asset('asset/css/css2.css')}}" type="text/css" rel="stylesheet" />

<link rel="stylesheet" href="https://unpkg.com/swiper@6.8.1/swiper-bundle.min.css">
  <style>
    .li {
      padding-top: 10px;
    }

    .nav11 {
      background-color: #398eb1 !important;
      font-family: sans-serif;
      box-shadow: 0 .15rem 1.75rem 0 rgba(58, 59, 69, .15) !important;
    }

    .navheading {
      color: #f2f2f2;
    }
  </style>
  <style>
    .fs-7 {
      font-size: 0.8rem !important;
    }

    .fs-8 {
      font-size: 0.6rem !important;
    }

    .p-01 {
      padding: 0.1rem !important;
    }

    .border-0d6efd63 {
      border-color: #0d6efd63 !important;
    }

    /* .border-00ffff{
            border-color: #00ffff !important;
        } */
    .card-height {
      height: 20rem !important;
    }

    .card-body-height {
      height: 10rem !important;
    }

    .card-header-height {
      height: 13rem !important;
    }

    .bg-fff5cc {
      background-color: #a190f0 !important;
    }

    .bg-99ffbb {
      background-color: #8974ec !important;
    }

    .bg-ccffff {
      background-color: #eaf5f3 !important;
    }

    .text-d8c4c4 {
      color: #d8c4c4 !important;
    }

    .text-f2bf26 {
      color: black !important;
    }

    .text-b34700 {
      color: #da6969 !important;
    }

    .text-fae333 {
      color: #fae333 !important;
      font-weight: 600 !important;
    }

    .bg-fae333 {
      background-color: #fcee85 !important;
    }

    .bg-ffcccc {
      background-color: #ffcccc !important;
    }

    .bg-smokewhite {
      background-color: white !important;
    }

    .scroll {
      -ms-overflow-style: none;
      scrollbar-width: none;
      height: 200px;
      display: flex;
      flex-direction: column;
      overflow-y: scroll;
    }




    .flow-width {
      width: 4.5rem !important;
    }

    @media (min-width:374.96px) {
      .flow-width {
        width: 2.5rem !important;
      }
    }

    @media (min-width:424.96px) {
      .flow-width {
        width: 2.5rem !important;
      }
    }

    @media (min-width:575.96px) {
      .flow-width {
        width: 2.5rem !important;
      }
    }

    @media (min-width:767.96px) {
      .flow-width {
        width: 2.5rem !important;
      }
    }

    @media (min-width:991.96px) {
      .col-lg-2-5 {
        flex: 0 0 auto;
        width: 20.5%;
      }

      .flow-width {
        width: 3.5rem !important;
      }
    }

    @media (min-width:1199.96px) {
      .flow-width {
        width: 4.5rem !important;
      }
    }
  </style>
  <style>
    .fs-7 {
      font-size: 0.8rem !important;
    }

    .fs-8 {
      font-size: 0.6rem !important;
    }

    .p-01 {
      padding: 0.1rem !important;
    }

    .border-0d6efd63 {
      border-color: #0d6efd63 !important;
    }

    /* .border-00ffff{
            border-color: #00ffff !important;
        } */
    .card-height {
      height: 20rem !important;
    }

    .card-body-height {
      height: 10rem !important;
    }

    .card-header-height {
      height: 13rem !important;
    }

    .bg-fff5cc {
      background-color: #a190f0 !important;
    }

    .bg-99ffbb {
      background-color: #8974ec !important;
    }

    .bg-ccffff {
      background-color: #eaf5f3 !important;
    }

    .text-d8c4c4 {
      color: #d8c4c4 !important;
    }

    .text-f2bf26 {
      color: black !important;
    }

    .text-b34700 {
      color: #da6969 !important;
    }

    .text-fae333 {
      color: #fae333 !important;
      font-weight: 600 !important;
    }

    .bg-fae333 {
      background-color: #fcee85 !important;
    }

    .bg-ffcccc {
      background-color: #ffcccc !important;
    }

    .bg-smokewhite {
      background-color: white !important;
    }

    .scroll {
      -ms-overflow-style: none;
      scrollbar-width: none;
      height: 200px;
      display: flex;
      flex-direction: column;
      overflow-y: scroll;
    }

    .flow-width {
      width: 4.5rem !important;
    }

    @media (min-width:374.96px) {
      .flow-width {
        width: 2.5rem !important;
      }
    }

    @media (min-width:424.96px) {
      .flow-width {
        width: 2.5rem !important;
      }
    }

    @media (min-width:575.96px) {
      .flow-width {
        width: 2.5rem !important;
      }
    }

    @media (min-width:767.96px) {
      .flow-width {
        width: 2.5rem !important;
      }
    }

    @media (min-width:991.96px) {
      .col-lg-2-5 {
        flex: 0 0 auto;
        width: 20.5%;
      }

      .flow-width {
        width: 3.5rem !important;
      }
    }

    @media (min-width:1199.96px) {
      .flow-width {
        width: 4.5rem !important;
      }
    }

    .buttonedu {
      display: flex !important;
      justify-content: space-around !important;
      padding: 10px;
    }
    .back-btn{
      background: red !important;
      border-color: red !important;
    }
  </style>

  <style>

.navigation {
      /*position: fixed;*/
      top: 0;
      /*  width: 100%;
  height: 60px;
  background: #3f9cb5;*/
    }

    .navigation .inner-navigation {
      padding: 0;
      margin: 0;
    }

    .navigation .inner-navigation li {
      list-style-type: none;
    }

    .navigation .inner-navigation li .menu-link {
      color: #085a7e;
      line-height: 3.7em;
      padding: 20px 18px;
      text-decoration: none;
      transition: background 0.5s, color 0.5s;
    }

    .navigation .inner-navigation li .menu-link.menu-anchor {
      padding: 20px;
      margin: 0;
      background: #bea20f;
      color: #FFF;
    }

    .navigation .inner-navigation li .menu-link.has-notifications {
      background: #085a7e;
      color: #FFF;
    }

    .navigation .inner-navigation li .menu-link.circle {
      line-height: 3.8rem ;
    padding: 14px 18px !important;
    border-radius: 50%;
  }

    .navigation .inner-navigation li .menu-link.circle:hover {
      background: #085a7e;
      color: #FFF;
    }

    .navigation .inner-navigation li .menu-link.square:hover {
      background: #085a7e;
      color: #FFF;
      transition: background 0.5s, color 0.5s;
    }

    .dropdown-container {
      overflow-y: hidden;
    }

    .dropdown-container.expanded .dropdown {
      -webkit-animation: fadein 0.5s;
      -moz-animation: fadein 0.5s;
      -ms-animation: fadein 0.5s;
      -o-animation: fadein 0.5s;
      animation: fadein 0.5s;
      display: block;
    }

    .dropdown-container .dropdown {
      -webkit-animation: fadeout 0.5s;
      -moz-animation: fadeout 0.5s;
      -ms-animation: fadeout 0.5s;
      -o-animation: fadeout 0.5s;
      animation: fadeout 0.5s;
      display: none;
      position: absolute;
      width: 300px;
      height: auto;
      max-height: 600px;
      overflow-y: hidden;
      padding: 0;
      margin: 0;
      background: #eee;
      margin-top: 3px;
      margin-right: -15px;
      border-top: 4px solid #085a7e;
      border-bottom-left-radius: 15px;
      border-bottom-right-radius: 15px;
      -webkit-box-shadow: 2px 2px 15px -5px rgba(0, 0, 0, 0.75);
      -moz-box-shadow: 2px 2px 15px -5px rgba(0, 0, 0, 0.75);
      box-shadow: 2px 2px 15px -5px rgba(0, 0, 0, 0.75);
      /*
  &:before{
    position: absolute;
    content: ' ';
    width: 0; 
    height: 0; 
    top: -13px;
    right: 7px;
    border-left: 8px solid transparent;
    border-right: 8px solid transparent;
    border-bottom: 10px solid $secondary-color; 
  }
  */
    }

    .dropdown-container .dropdown .notification-group {
      border-bottom: 1px solid #e3e3e3;
      overflow: hidden;
      min-height: 65px;
    }

    .dropdown-container .dropdown .notification-group:last-child {
      border-bottom: 0;
      border-bottom-left-radius: 15px;
      border-bottom-right-radius: 15px;
    }

    .dropdown-container .dropdown .notification-group .notification-tab {
      padding: 0px 25px;
      min-height: 65px;
    }

    .dropdown-container .dropdown .notification-group .notification-tab:hover {
      cursor: pointer;
      background: #3f9cb5;
    }

    .dropdown-container .dropdown .notification-group .notification-tab:hover .fa,
    .dropdown-container .dropdown .notification-group .notification-tab:hover h4,
    .dropdown-container .dropdown .notification-group .notification-tab:hover .label {
      color: #FFF;
      display: inline-block;
    }

    .dropdown-container .dropdown .notification-group .notification-tab:hover .label {
      background: #085a7e;
      border-color: #085a7e;
    }

    .dropdown-container .dropdown .notification-group .notification-list {
      padding: 0;
      overflow-y: auto;
      height: 0px;
      max-height: 250px;
      transition: height 0.5s;
    }

    .dropdown-container .dropdown .notification-group .notification-list .notification-list-item {
      padding: 5px 25px;
      border-bottom: 1px solid #e3e3e3;
    }

    .dropdown-container .dropdown .notification-group .notification-list .notification-list-item .message {
      margin: 5px 5px 10px;
    }

    .dropdown-container .dropdown .notification-group .notification-list .notification-list-item .item-footer a {
      color: #3f9cb5;
      text-decoration: none;
    }

    .dropdown-container .dropdown .notification-group .notification-list .notification-list-item .item-footer .date {
      float: right;
    }

    .dropdown-container .dropdown .notification-group .notification-list .notification-list-item:nth-of-type(odd) {
      background: #e3e3e3;
    }

    .dropdown-container .dropdown .notification-group .notification-list .notification-list-item:hover {
      cursor: pointer;
    }

    .dropdown-container .dropdown .notification-group .notification-list .notification-list-item:last-child {
      border-bottom: 0;
      border-bottom-left-radius: 15px;
      border-bottom-right-radius: 15px;
    }

    .dropdown-container .dropdown .notification-group.expanded .notification-tab {
      background: #3f9cb5;
    }

    .dropdown-container .dropdown .notification-group.expanded .notification-tab .fa,
    .dropdown-container .dropdown .notification-group.expanded .notification-tab h4,
    .dropdown-container .dropdown .notification-group.expanded .notification-tab .label {
      color: #FFF;
      display: inline-block;
    }

    .dropdown-container .dropdown .notification-group.expanded .notification-tab .label {
      background: #085a7e;
      border-color: #085a7e;
    }

    .dropdown-container .dropdown .notification-group.expanded .notification-list {
      height: 150px;
      max-height: 250px;
      transition: height 0.5s;
    }

    .dropdown-container .dropdown .notification-group .fa,
    .dropdown-container .dropdown .notification-group h4,
    .dropdown-container .dropdown .notification-group .label {
      color: #333;
      display: inline-block;
    }

    .dropdown-container .dropdown .notification-group .fa {
      margin-right: 5px;
      margin-top: 25px;
    }

    .dropdown-container .dropdown .notification-group .label {
      float: right;
      margin-top: 20px;
      color: #3f9cb5;
      border: 1px solid #3f9cb5;
      padding: 0px 7px;
      border-radius: 15px;
    }

    .tile-body-height {
      height: 60vh;
      overflow-y: overlay;
      padding-right: 25px;
    }

    .right {
      float: right;
    }

    .left {
      float: left;
      list-style: none;
    }
    .badge{
      line-height: 20px!important;
    /* margin: auto; */
    /* align-items: flex-end; */
    /* margin: auto; */
    position: absolute!important;
    /* margin-top: 2rem; */
    top: 6px!important;
    right: 60px !important;
    /* padding: 1rem; */
    border-radius: 50px !important;
    width: 20px !important;
    height: 20px !important;
    background-color: red !important;
    color: white !important;
    font-size: 8px !important;
    padding: 1px 4px !important;
}
.table:not(.table-sm) thead th {
  background-color: rgb(9 48 110) !important;
}

.loader {
   position: fixed;
   left: 0px;
   top: 0px;
   width: 100%;
   height: 100%;
   z-index: 9999;
   background: url('/images/elinaloader.gif') 50% 50% no-repeat rgb(249,249,249);
 }
    
 .required:after {
  content:" *";
  color: red;
}
.dropdown{
   position:relative;
}
.dropdown-content{
   position:absolute;
   top:0;
   right:10px;
}
.alert-head-background {background-color: rgb(39 86 104);color: #fff;}
 .alert-row-top {margin-top: 75px}
 .alert-message-top {margin-top: 20px;}
 .alert-image-size {width: 75px;}
 .btn-alert{
background-color: rgb(39 86 104) !important;
color: #fff !important;
}
.sweet-alert button{
  background-color: #000dff !important;
}
li.dropdown {
    cursor: pointer;
}
.readonly {
    background-color: #8080803d !important;
  }
  .form-control:disabled, .form-control[readonly] {
    background-color: #e9ecef !important;
    opacity: 1;
}
.disable-click{
    pointer-events:none;
    opacity: 0.5;
}
.dark-sidebar .main-sidebar .sidebar-menu li ul.dropdown-menu a:hover {
    background-color: #4068cf !important;
}
.tox-statusbar{
  display: none !important;
}

/* Calander Icon Position */
  /* enable absolute positioning */
  .inner-addon {
    position: relative;
  }

  /* style glyph */
  .inner-addon .glyphicon {
    position: absolute;
    padding: 15px;
    pointer-events: none;
  }

  /* align glyph */
  .left-addon .glyphicon {
    left: 0px;
  }

  .right-addon .glyphicon {
    right: 0px;
  }

  /* add padding  */
  .left-addon input {
    padding-left: 30px;
  }

  .right-addon input {
    padding-right: 30px;
  }
  /*  Calander Icon Position - End */
  /* Datepicker CSS */
  .ui-state-default .ui-state-active {
  background-color: green !important;
}
#timer {
            /* display: none;  */
        }
        #timerText {
            display: none; 
        }
  /* Datepicker CSS - End */
  </style>

</head>

<body>
<div id="app"><div class='loader'></div>

  <div id="app">
    <div class="main-wrapper main-wrapper-1">
      <div class="navbar-bg"></div>
      <nav class="navbar nav11 navbar-expand-lg main-navbar">
        <div class="form-inline mr-auto">
          <ul class="navbar-nav mr-3">
            <li>
              <a href="#" data-toggle="sidebar" class="nav-link nav-link-lg collapse-btn "><i class="fas fa-bars navheading"></i></a>
            </li>
            <li>
              <a href="#" class="nav-link nav-link-lg fullscreen-btn">
                <i class="fas fa-expand navheading"></i>
              </a>
            </li>
          </ul>

        </div>
        <div class="form-inline mr-auto d-md-inline-block d-none" style="color: #2a0245!important; font-weight: 900; font-size: 28px">

          <span style="  color:white; padding: 10px;" class="nav_heading"><b class="navheading">ELINA ISMS PORTAL</b>
            <span style="color: #9958ae; right: -90px;position: relative;" class="user_name_nav"></span></span>


        </div>
        <div>
          <P style="/*margin: 0 15px 0 0;*/color: white;" id="timerText">Your Session will be expired</P>
          <span style="/*margin: 0 15px 0 0;*/color: white;text-align: center;" id="timer"></span>
        </div>

        <ul class="navbar-nav navbar-right" style="width: 160px;">
        <nav class="navigation" style="width: 20%;margin-right: 10px !important;">

<span class="badge badge-light badgeworkflow" style="right: 130px !important;"></span>

<ul class="inner-navigation">

  <li class="left">
    <!--span class="notification-label"></span-->

    <div class="dropdown-container">
      <a href="#" data-dropdown="notificationMenu" class="menu-link has-notifications circle">
        <i class="fa fa-bell"></i><span class="badge badge-light"></span>
      </a>
      <ul class="dropdown" name="notificationMenu">
        <!-- <li class="notification-group">
          <div class="notification-tab">
            <i class="fa fa-flag lg"></i>
            <h4 style="font-size:15px" class="">Payment list</h4>
            <span class="user_name_alert"></span>
          </div>
          
          <ul class="notification-list work_flow_alert_list">


            



          </ul> -->
        </li>
        @if($modules['user_role'] != 'Parent')
        <li class="notification-group">
          <div class="notification-tab">
          <i class="fa fa-user" aria-hidden="true"></i>
            <h4 style="font-size:15px" class="">Users</h4>
            <span class="user_name_alert1"></span>
          </div>
          <!-- tab -->
          <ul class="notification-list user_alert_list">


           





          </ul>
        </li>
        @endif
        <li class="notification-group">
          <div class="notification-tab">
          <i class="fa fa-users" aria-hidden="true"></i>
            <h4 style="font-size:15px" class="">Enrollment</h4>
            <span class="user_name_alert2"></span>
          </div>
          <!-- tab -->
          <ul class="notification-list form_alert_list">


           



          </ul>
        </li>

         <li class="notification-group">
          <div class="notification-tab">
          <i class="fa fa-money" aria-hidden="true"></i>
            <h4 style="font-size:15px" class="">Payment</h4>
            <span class="user_name_alert3"></span>
          </div>
         
          <ul class="notification-list payment_alert_list">


           


          </ul>
        </li>
        <!-- <li class="notification-group">
          <div class="notification-tab">
            <i class="fa fa-flag goldenrod"></i>
            <h4 style="font-size:15px" class="">Payment Completed </h4>
            <span class="user_name_alert4"></span>
          </div>
          
          <ul class="notification-list paymentsuccessful_alert_list">

            




          </ul>
        </li>  -->
        <li class="notification-group">
          <div class="notification-tab">
            <i class="fa fa-flag goldenrod"></i>
            <h4 style="font-size:15px" class="">OVM Meeting</h4>
            <span class="user_name_alert6"></span>
          </div>
          
          <ul class="notification-list ovm_meeting">

            




          </ul>
        </li> 

        <!-- <li class="notification-group">
          <div class="notification-tab">
            <i class="fa fa-flag goldenrod"></i>
            <h4 style="font-size:15px" class="">ORM Meeting</h4>
            <span class="user_name_alert6"></span>
          </div>
          
          <ul class="notification-list ovm_meeting">

            




          </ul>
        </li>  -->

        <!-- <li class="notification-group">
          <div class="notification-tab">
            <i class="fa fa-flag goldenrod"></i>
            <h4 style="font-size:15px" class="">Elina Demo Link</h4>
            <span class="user_name_alert5"></span>
          </div>
          
          <ul class="notification-list elinademo_alert_list">

            




          </ul>
        </li>  -->

        <!-- <li class="notification-group">
          <div class="notification-tab">
            <i class="fa fa-flag goldenrod"></i>
            <h4 style="font-size:15px" class="">UAM</h4>
            <span class="uam_alert_list1"></span>
          </div>         
          <ul class="notification-list uam_alert_list">
          </ul>
        </li>  -->

         <li class="notification-group">
          <div class="notification-tab">
            <i class="fa fa-flag goldenrod"></i>
            <h4 style="font-size:15px" class="">Questionnaire</h4>
            <span class="questionnaire_alert_list"></span>
          </div>         
          <ul class="notification-list questionnaire_alert_list1">
          </ul>
        </li> 

        <li class="notification-group">
          <div class="notification-tab">
            <i class="fa fa-flag goldenrod"></i>
            <h4 style="font-size:15px" class="">SAIL</h4>
            <span class="activity_alert_list1"></span>
          </div>         
          <ul class="notification-list activity_alert_list">
          </ul>
        </li> 

        <!-- <li class="notification-group">
          <div class="notification-tab">
            <i class="fa fa-flag goldenrod"></i>
            <h4 style="font-size:15px" class="">Home Tracker</h4>
            <span class="questionnaire_alert_list"></span>
          </div>         
          <ul class="notification-list questionnaire_alert_list1">
          </ul>
        </li>  -->

      </ul>
    </div>
  </li>
</ul>

</nav>


          <li class="dropdown" style="width: 80%;">
            <a data-toggle="dropdown" class="nav-link dropdown-toggle nav-link-lg nav-link-user d-flex align-items-center">
              <i class="fas fa-user navheading"></i>
              @if($modules['user_role'] == 'relative')
              <span class="d-sm-none d-lg-inline-block" style="margin: 0 0 0 10px;"></span>- {{$modules['user_role']}}</a>
              @else
              <span class="d-sm-none d-lg-inline-block" style="margin: 0 0 0 10px;"></span>{{$modules['user_role']}}</a>
              @endif
            <div class="dropdown-menu dropdown-menu-right">

              <!-- <a href="{{ url('admin_profile') }}" class="dropdown-item has-icon">
                <i class="far fa-user" style="color:red !important;"></i><b style="color:blue !important;">Profile</b></a> -->
                <a class="dropdown-item has-icon" href="{{ route('profilepage') }}"><i class="fa fa-user" style="color:red !important;"></i><b style="color:blue !important;">Profile</b></a>
                <a class="dropdown-item has-icon" href="{{ route('main_index') }}"><i class="fa fa-question-circle" style="color:red !important;"></i><b style="color:blue !important;">FAQ</b></a>

              <a href="{{ route('logout') }}" class="dropdown-item has-icon" onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                <i class="fa fa-sign-out" style="color:red !important;"></i><b style="color:blue !important;">Logout</b></a>

              <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf

              </form>
            </div>
          </li>


        </ul>
      </nav>

      <div class="main-sidebar sidebar-style-2" style=" background-color: rgb(0, 34, 102) !important;">
        <aside id="sidebar-wrapper" style=" background-color: rgb(0, 34, 102) !important;">
          <div class="sidebar-brand" style=" background-color:white!important;">

            <img src="{{asset('assets/images/elina-logo-2.png')}}" class="logo" style="  width: 70% !important;">
            </a>
          </div>

          <ul class="sidebar-menu" id="sidechecks">

          @if($modules['user_role'] != 'Parent' && $modules['user_role'] != '')
            <li class="dropdown "><a href="{{route('home')}}" class="nav-link"><i class="fas fa-home"></i><span>Dashboard</span></a></li>
            <li class="dropdown "><a href="{{route('questionnaire.dashboard')}}" class="nav-link"><i class="fa fa-pie-chart"></i><span>Feedback Dashboard</span></a></li>
          @endif
          
            <!-- qqq -->
            @if($modules['data'] !="")
            @foreach ($modules['data'] as $key => $module)

            @if($screens['unique'] != "")
            @php
            $s = $screens['unique1'][0]['un'];
            $array=explode(",",$s);
            $s2 = $screens['unique2'][0]['un'];
            $array2=explode(",",$s2);
            $a=array();
            @endphp
            @foreach ($screens['unique'] as $key => $mscreen)

            @php
            if ($mscreen['parent_module_id'] == 1 && in_array($mscreen['module_id'], $array)) {
            $msID = 0;
            } elseif ($mscreen['parent_module_id'] == 1) {
            $msID = $mscreen['module_id'];
            } else {
              $msID = $mscreen['parent_module_id'];
                        if(in_array($msID, $a)){
                            $msID = 0;
                            
                        }
                        array_push($a, $msID);
            }
            @endphp

            @if($module['module_id'] == $msID)

            <li class="dropdown">

              <a class="nav-link has-dropdown">
                <i class="{{$module['class_name']}}"></i>
                <span>
                  {{$module['module_name']}}
                </span>
              </a>

              <ul class="dropdown-menu active" style="display: none;">
              @if($module['module_id']!=9) <!-- Need to be changed -->
                @if($screens !="")
                @foreach ($screens['screens'] as $key => $screen)
                @if($module['module_id'] == $screen['module_id'])
                <li><a class="nav-link smn" id="navLink" onclick="navclick()" href="{{ config('setting.base_url')}}{{ $screen['route_url'] }}">{{$screen['screen_name']}}</a></li>
                @endif
                @endforeach
                @endif
@endif<!-- Need to be changed -->
                <!--  -->

                @if($modules['sub_module'] !="")
                @foreach ($modules['sub_module'] as $key => $sub_module)
                @if($sub_module['parent_module_id'] == $module['module_id'])

                <!--  -->
                @if(in_array($sub_module['module_id'],$array2))
                <li class="dropdown">

                  <a class="nav-link has-dropdown">
                    <span>
                      {{$sub_module['module_name']}}
                    </span>
                  </a>

                  <ul class="dropdown-menu active" style="display: none;">
                    @if($screens['screens'] !="")
                    @foreach ($screens['screens'] as $key => $subscreen)
                    @if($sub_module['module_id'] == $subscreen['check_id'])
                    @if($subscreen !="")
                    <li><a class="nav-link smn" id="navLink" onclick="navclick()" href="{{ config('setting.base_url')}}{{ $subscreen['route_url'] }}">{{$subscreen['screen_name']}}</a></li>
                    @endif
                    @endif
                    @endforeach
                    @endif
                  </ul>
                </li>
                <!--  -->
                @endif
                @endif
                @endforeach
                @endif

                <!--  -->
                @if($module['module_id']==9)<!-- Need to be changed -->
                @if($screens !="")<!-- Need to be changed -->
                @foreach ($screens['screens'] as $key => $screen)<!-- Need to be changed -->
                @if($module['module_id'] == $screen['module_id'])<!-- Need to be changed -->
                <li><a class="nav-link smn" href="{{ config('setting.base_url')}}{{ $screen['route_url'] }}">{{$screen['screen_name']}}</a></li><!-- Need to be changed -->
                @endif<!-- Need to be changed -->
                @endforeach<!-- Need to be changed -->
                @endif<!-- Need to be changed -->
                @endif<!-- Need to be changed -->
              </ul>

            </li>

            @endif
            @endforeach
            @endif
            @endforeach
            @endif





            <!-- end module -->

            <!-- <li class="dropdown">
              <a href="" class="nav-link  has-dropdown"><i class="fas fa-user-cog"></i></i><span>UAM</span></a>
              <ul class="dropdown-menu active">
                <li> <a class="nav-link" href="{{url('uam_modules')}}">Modules</a></li>
                <li> <a class="nav-link" href="{{url('uam_screens')}}">Screens</a></li>
                <li> <a class="nav-link" href="{{url('uam_modules_screens')}}">Module Screen Mapping</a></li>
                <li> <a class="nav-link" href="{{url('uam_roles')}}">Roles</a></li>
                <li> <a class="nav-link" href="{{url('user')}}">User Creation</a></li>
              </ul>
            </li> -->






{{--
            <li class="dropdown">
              <a href="" class="nav-link  has-dropdown"><i class="fas fa-cog"></i><span>Masters</span></a>
            <ul class="dropdown-menu active">
              
                <!-- <li> <a class="nav-link" href="">FAQ</a></li>
              <li> <a class="nav-link" href="">FAQ Module</a></li> -->
                <li><a class="nav-link" href="{{url('tokenmaster')}}">Token Expiring Master</a></li>

              
              
            </ul>
          </li>








            <li> <a class="nav-link has-dropdown" href="{{url('newenrollment')}}"><i class="fa fa-users" aria-hidden="true"></i><span>Enrollment</span></a>
            <ul class="dropdown-menu active">
                <!-- <li> <a class="nav-link" href="{{url('Registration')}}">New Enrollment</a></li> -->

                <li> <a class="nav-link" href="{{ route('newenrollment.create') }}">New Enrollment</a></li>
                <li> <a class="nav-link" href="{{url('newenrollment')}}">Enrollment List </a></li>

                <li> <a class="nav-link" href="{{url('internlist')}}">Intern Application List </a></li>
                <li> <a class="nav-link" href="{{url('servicelist')}}">Service Provider List </a></li>

                <li style="line-height: normal;"> <a class="nav-link" href="{{ route('enrollement.schoollist') }}"> School Enrollment List view</a></li>


                <!-- <li> <a class="nav-link" href="{{url('submitted_complaint')}}">Submitted Complaint</a></li> -->
              </ul>

            </li>


            <li> <a class="nav-link has-dropdown" href=""><i class="fa fa-money" aria-hidden="true"></i><span>Payment Initiation</span></a>
         

            

              <ul class="dropdown-menu active">



              <li style="line-height: normal;"> <a class="nav-link" href="{{ route('userregisterfee.create') }}">User Registration Fee</a></li>
              <li style="line-height: normal;"> <a class="nav-link" href="{{ route('sail_register_fee') }}">SAIL Registration Fee</a></li>
              <li style="line-height: normal;"> <a class="nav-link" href="">Compass Registration Fee</a></li>
              <li style="line-height: normal;"> <a class="nav-link" href="{{route('userregisterfee.index')}}">Payment Status List</a></li>
              </ul>
          </li>
            <li> <a class="nav-link has-dropdown" href="{{url('newenrollment')}}"><i class="fa fa-usd" aria-hidden="true"></i><span>Payment Pending</span></a>
              <ul class="dropdown-menu active">



                <!-- <li style="line-height: normal;"> <a class="nav-link" href="{{ route('payuserfee.create') }}">User Registration Fee</a></li>
                <li style="line-height: normal;"> <a class="nav-link" href="">SAIL Registration Fee</a></li>
                <li style="line-height: normal;"> <a class="nav-link" href="">Compass Registration Fee</a></li> --> 
                <li style="line-height: normal;"> <a class="nav-link" href="{{route('payuserfee.index')}}">Payment Status List</a></li>

            </ul>


          </li>


          </li> 


          <li> <a class="nav-link has-dropdown" href=""><i class="fa fa-envelope-o"></i><span>Overview Meetings</span></a>
            <ul class="dropdown-menu active">
          </li>


          <li class="dropdown">
            <a href="" class="nav-link  has-dropdown"><i class="fas fa-user-cog"></i></i><span>OVM 1</span></a>
            <ul class="dropdown-menu active">
              <li> <a class="nav-link" href="{{url('Newmeetinginvite')}}">New Meeting Invite</a></li>
              <li> <a class="nav-link" href="{{url('ovm1')}}">OVM-1 List View</a></li>
              <li> <a class="nav-link" href="{{url('ovmmeetingcompleted')}}">OVM-1 Completed</a></li>
              <li> <a class="nav-link" href="{{route('sail.index')}}">OVM-1 Questionnaire</span></a></li>
              <li> <a class="nav-link" href="{{url('ovmreport')}}">OVM-1 Report </a></li>
            </ul>
          </li>
          <li class="dropdown">
            <a href="" class="nav-link  has-dropdown"><i class="fas fa-user-cog"></i></i><span>OVM 2</span></a>
            <ul class="dropdown-menu active">
              <li> <a class="nav-link" href="{{url('Newmeetinginvite2')}}">New Meeting Invite</a></li>
              <li> <a class="nav-link" href="{{url('ovm2')}}">OVM-2 List View</a></li>
            
            </ul>
          </li>
          </ul>

          <li> <a class="nav-link has-dropdown" href=""><i class="fa fa-file-text-o"></i><span>SAIL Activity Guide sending</span></a>
            <ul class="dropdown-menu active">



              <li style="line-height: normal;"> <a class="nav-link" href="{{ route('elinademo.create') }}">SAIL Activity Guide</a></li>

              <li style="line-height: normal;"> <a class="nav-link" href="{{ route('elinademo.index') }}">SAIL Activity Guide List view</a></li>

            </ul>

          </li>

          <li> <a class="nav-link has-dropdown" href=""><i class="fa fa-file-text-o" aria-hidden="true"></i><span> SAIL</span></a>
              <ul class="dropdown-menu active">



              <!-- <li style="line-height: normal;"> <a class="nav-link" href=""> </a></li> -->
              <li style="line-height: normal;"> <a class="nav-link" href="{{route('sailstatus')}}"> SAIL Status</a></li>
              <li style="line-height: normal;"> <a class="nav-link" href=" {{route('sail.index')}}">Questionnaire List View</a></li>
              <li style="line-height: normal;"> <a class="nav-link" href="{{route('questionnaireinitiate')}}">Questionnaire Initiation</a></li>
              <li style="line-height: normal;"> <a class="nav-link" href="">Mail Communication</a></li>
              <li style="line-height: normal;"> <a class="nav-link" href="{{route('parent_video_upload.parentindex')}}">Parent Video Upload</a></li>
              <li class="dropdown">
            <a href="" class="nav-link  has-dropdown"><span>Assessment Report</span></a>
            <ul class="dropdown-menu active">
              <li> <a class="nav-link" href="{{url('Newmeetinginvite')}}">Activity Analyse Entry</a></li>
              <li> <a class="nav-link" href="">Recommendation Report</a></li>
              <li> <a class="nav-link" href="{{url('ovm2')}}">Report List View</a></li>
            
            </ul>
          </li> 
              
            </ul>


          </li>

          
          <li class="dropdown">
            <a href="" class="nav-link  has-dropdown"><i class="fas fa-pen"></i></i><span>Manage Questionnaire</span></a>
            <ul class="dropdown-menu active">
              <li> <a class="nav-link" href="{{ route('question_creation.index') }}">Question Creation</a></li>
              <li> <a class="nav-link" href="{{ route('questionnaire_master.index') }}">Question Master</a></li>

            </ul>
          </li>

          <li class="dropdown">
            <a href="" class="nav-link  has-dropdown"><i class="fas fa-pen"></i></i><span>Parents Questionnaire</span></a>
            <ul class="dropdown-menu active">
              <!-- <li> <a class="nav-link" href="{{ route('questionnaire_for_user.fill_form') }}">Questionnaire</a></li> -->
              <li> <a class="nav-link" href="{{ route('questionnaire_for_user.index') }}">Index</a></li>
              <li> <a class="nav-link" href="{{ route('questionnaire.submitted.list') }}">Submitted Form</a></li>

            </ul>
          </li>


          <li> <a class="nav-link has-dropdown" href=""><i class="fa fa-flag" aria-hidden="true"></i><span>Reports</span></a>
              <ul class="dropdown-menu active">



              <li style="line-height: normal;"> <a class="nav-link" href="{{route('auditlog.login_report')}}">SAIL Assessment Report</a></li>
              <li style="line-height: normal;"> <a class="nav-link" href="{{route('auditlog.login_report')}}">SAIL Recommendation Report</a></li>
              
              

            </ul>


          </li>


          <li> <a class="nav-link has-dropdown" href=""><i class="fa fa-file-video-o" aria-hidden="true"></i><span>Activity Creation</span></a>
              <ul class="dropdown-menu active">



              <li style="line-height: normal;"> <a class="nav-link" href="{{url('video_creation')}}">Activity Creation List</a></li>
              
              <!-- <li style="line-height: normal;"> <a class="nav-link" href="{{route('activity_initiate.create')}}">Activity Initiation</a></li> -->

              <li style="line-height: normal;"> <a class="nav-link" href="{{url('activity_initiate')}}">Activity Initiation List View</a></li>

            </ul>


          </li>



            <li> <a class="nav-link has-dropdown" href=""><i class="fa fa-file-video-o" aria-hidden="true"></i><span>CoMPASS</span></a>
              <ul class="dropdown-menu active">
            <li style="line-height: normal;"> <a class="nav-link" href="{{url('childwebsite')}}">Child Website</a></li>



              <li style="line-height: normal;"> <a class="nav-link" href="{{url('CompassNewmeetinginvite')}}">Orientation Meeting Invite</a></li>

              <li style="line-height: normal;"> <a class="nav-link" href="{{url('compassmeeting')}}">ORM List View</a></li>
              @if($modules['user_role'] != 'Parent' && $modules['user_role'] != '')
              <li> <a class="nav-link has-dropdown" href=""><span>Therapist Allocation</span></a>
                <ul class="dropdown-menu active">
                  <li style="line-height: normal;"> <a class="nav-link" href="{{url('therapist')}}">Therapist Session Allocation</a></li>
                  <li style="line-height: normal;"> <a class="nav-link" href="{{url('therapist/list')}}">Therapist Details</a></li>
                  <li style="line-height: normal;"> <a class="nav-link" href="{{url('therapistallocationview')}}">Therapist Allocation View</a></li>

                </ul>
             
              </li>
              @endif
              <li style="line-height: normal;"> <a class="nav-link" href="{{url('hometracker')}}">Home Tracker</a></li>
              @if($modules['user_role'] != 'Parent' && $modules['user_role'] != '')

              <li style="line-height: normal;"> <a class="nav-link" href="{{url('weeklyfeedback')}}">Weekly Feedback</a></li>
              <li style="line-height: normal;"> <a class="nav-link" href="{{url('monthlyobjective')}}">Monthly Feedback</a></li>
              <li style="line-height: normal;"> <a class="nav-link" href="{{url('progress/status')}}">Progress Search</a></li>
             
              <li style="line-height: normal;"> <a class="nav-link" href="{{url('compassobservation')}}">Observation</a></li>
              @endif
            </ul>
            <li> <a class="nav-link has-dropdown" href=""><i class="fa fa-flag" aria-hidden="true"></i><span>Reports</span></a>
                <ul class="dropdown-menu active">
                  <li style="line-height: normal;"> <a class="nav-link" href="{{url('compassreport')}}">Monthly Report</a></li>
                </ul>
            </li>

            --}}





        </aside>

        <input type="hidden" name="testing_id" id="testing_id" value="{{URL::to('/')}}">
      </div>






    </div>
  </div>

  <main class="py-4">



    @yield('content')
  </main>

  <!-- <script type="text/javascript">$('#listDataTable').DataTable();</script> -->

<script type="text/javascript">
 $(window).on('load', function() {
  $(".loader").fadeOut("slow");
})
</script>

<script type="text/javascript">
  function navclick(){
    $(".loader").show();
  }

      //Open dropdown when clicking on element
      $(document).on('click', "a[data-dropdown='notificationMenu']",  function(e){
        e.preventDefault();
        
        var el = $(e.currentTarget);
        
        $('body').prepend('<div id="dropdownOverlay" style="background: transparent; height:100%;width:100%;position:fixed;"></div>')
        
        var container = $(e.currentTarget).parent();
        var dropdown = container.find('.dropdown');
        var containerWidth = container.width();
        var containerHeight = container.height();
        
        var anchorOffset = $(e.currentTarget).offset();

        dropdown.css({
          'right': containerWidth / 2 + 'px',
          'position' : 'absolute',
          'z-index' : 100
        })
        
        container.toggleClass('expanded')
        
      });

//Close dropdowns on document click

$(document).on('click', '#dropdownOverlay', function(e){
  var el = $(e.currentTarget)[0].activeElement;
  
  if(typeof $(el).attr('data-dropdown') === 'undefined'){
    $('#dropdownOverlay').remove();
    $('.dropdown-container.expanded').removeClass('expanded');
  }
})

//Dropdown collapsile tabs
$('.notification-tab').click(function(e){
  if($(e.currentTarget).parent().hasClass('expanded')){
    $('.notification-group').removeClass('expanded');
  }
  else{
    $('.notification-group').removeClass('expanded');
    $(e.currentTarget).parent().toggleClass('expanded');
  }
})
</script>

<script type="text/javascript">
window.addEventListener('beforeunload', function() {
  document.body.style.pointerEvents = 'none';
  document.body.style.cursor = 'wait';
});

  $( document ).ready(function() {
//var user_id = Session::getId();
callnotification();
// setInterval(callnotification, 30000);

// Session Timer
        // localStorage.removeItem('alertShown');
        var sessionTimer = {!! json_encode(session()->get("sessionTimer")) !!};
        // console.log(sessionTimer);
        var targetDateTime = new Date(sessionTimer);//2023-07-14 18:03:35
        // var displayTime = new Date(targetDateTime.getFullYear(), targetDateTime.getMonth(), targetDateTime.getDate(), 15, 10, 0);
        var displayTime = new Date(targetDateTime.getTime() - (5 * 60 * 1000));
        var currentTime = new Date();
        if (currentTime >= displayTime) {
            showTimer();
        } else {
            // showTimer();
            var delay = displayTime - currentTime;
            setTimeout(showTimer, delay);
        }

        function showTimer() {
            // alert('Timer Startes');
            if (!localStorage.getItem('unauthenticated')){
              if (!localStorage.getItem('alertShown')) {
                var formattedTime = targetDateTime.toLocaleTimeString([], { hour: 'numeric', minute: '2-digit' });
                swal.fire('info','Your Session will Expire Soon.Please save your work before the page expires.' , 'info');
                localStorage.setItem('alertShown', 'true');
              }else{
                Swal.fire({
                  icon:'info',
                  title:'Session Timeout',
                  html:'Your Session will Expire Soon.<br/>Please save your work before the page expires.',
                  timer:5000, // 5 seconds
                  showConfirmButton: false
                }).then(function() {
                });
              }
            }
            document.getElementById("timerText").style.display = "block"; 
            document.getElementById("timer").style.display = "block"; 
            var timerInterval = setInterval(updateTimer, 1000);
            updateTimer();
        }

        function updateTimer() {
            var currentTime = new Date().getTime();
            var timeDifference = targetDateTime - currentTime;
            var days = Math.floor(timeDifference / (1000 * 60 * 60 * 24));
            var hours = Math.floor((timeDifference % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            var minutes = Math.floor((timeDifference % (1000 * 60 * 60)) / (1000 * 60));
            var seconds = Math.floor((timeDifference % (1000 * 60)) / 1000);
            document.getElementById("timer").innerHTML = (hours != 0 ? hours + "h " : '')  + minutes + "m " + seconds + "s ";
            if (timeDifference <= 0) {
                // clearInterval(timerInterval);
                document.getElementById("timerText").style.display = "none"; 
                document.getElementById("timer").innerHTML = "Session Expired!";
                localStorage.removeItem('alertShown');
                if (!localStorage.getItem('unauthenticated')){
                  localStorage.setItem('unauthenticated', 'true');
                  window.location = "{{ route('unauthenticated') }}";
                }
            }
        }
// 
var id = "user_id";

    $.ajaxSetup({
     headers: {
       'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
   });
function callnotification() {
   $.ajax({
     url: '{{ url('/user/notifications') }}',    
     type:"POST",
     dataType:"json",
     async: false,
     data: {id: id, _token: '{{csrf_token()}}'},
     success:function(data){


      // console.log(data);

     // return false;   
      
       var data2 = data;
      
       
       // <div class = ""><a onclick="notification('+work_flow_id+')" style="width: 100%;border-bottom: 1px solid #adb5bd;"><div class = "notification-text">'+ data['rowsdetails'][count].work_flow_name +' '+ data['rowsdetails'][count].work_flow_level_name +' allocated to you. </div></a></div>

     $('.user_login_name').text(''+ data2['user'][0].name +'');
       //console.log(''+ data2['user'][0].name +'');

       

       var count = data2['count_data'][0].countflow;

       var count1 = data2['work_flow_data_count'][0].countflow;

        var count2 = data2['user_data_count'][0].countflow;

        var count3 = data2['form_data_count'][0].countflow;

        var count4 = data2['payment_data_count'][0].countflow;

        // var count5 = data2['paymentsuccessfull_data_count'][0].countflow;


        var count7 = data2['ovmmeeting_data_count'][0].countflow;


        var count6 = data2['elinademolink_count'][0].countflow;

        var count66 = data2['uamdata_count'][0].countflow;

        var count99 = data2['activity_count'][0].countflow;

        var count77 = data2['questionnaire_count'][0].countflow;
       if (count == 0) {

         
       }else{

        $('.user_name_login').append('<span class="label badgeworkflow">'+ data2['count_data'][0].countflow +'</span>')

       // $('.badgeworkflow').text(''+ data2['count_data'][0].countflow +'');

       $('.user_name_alert').append('<span class="label user_name_alert">'+ count1 +'</span>');

         $('.user_name_alert1').append('<span class="label user_name_alert1">'+ count2 +'</span>');

          $('.user_name_alert2').append('<span class="label user_name_alert2">'+ count3 +'</span>');

          $('.user_name_alert3').append('<span class="label user_name_alert3">'+ count4 +'</span>');

          // $('.user_name_alert4').append('<span class="label user_name_alert4">'+ count5 +'</span>');

          $('.user_name_alert5').append('<span class="label user_name_alert5">'+ count6 +'</span>');


          $('.user_name_alert6').append('<span class="label user_name_alert6">'+ count7 +'</span>');

          $('.uam_alert_list1').append('<span class="label uam_alert_list1">'+ count66 +'</span>');

          $('.questionnaire_alert_list').append('<span class="label questionnaire_alert_list">'+ count77 +'</span>');
          $('.activity_alert_list1').append('<span class="label activity_alert_list1">'+ count99 +'</span>');

         $('.badgeworkflow').text(count);

       }

 //$('.user_name_login').append('<span class="label badgeworkflow">'+ data2['count_data'][0].countflow +'</span>');
       for(var count = 0; count < data2['work_flow_data'].length; count++)
       {

        // var work_flow_id = data2['work_flow_data'][count].work_flow_id;
        // var notification_type = data2['work_flow_data'][count].notification_type;
        // var work_flow_name = data2['work_flow_data'][count].work_flow_name;
        // var notification_status = data2['work_flow_data'][count].notification_status;
        var notification_id = data2['work_flow_data'][count].notification_id;
        var alert_meg = data2['work_flow_data'][count].alert_meg;


    $('.work_flow_alert_list').append('<li onclick="notification('+notification_id+')" class="notification-list-item"><p class="message">'+alert_meg+'</p></li>');

      }
       for(var count = 0; count < data2['user_data'].length; count++)
       {

        // var work_flow_id = data2['work_flow_data'][count].work_flow_id;
        // var notification_type = data2['work_flow_data'][count].notification_type;
        // var work_flow_name = data2['work_flow_data'][count].work_flow_name;
        // var notification_status = data2['work_flow_data'][count].notification_status;
        var notification_id = data2['user_data'][count].notification_id;
        var alert_meg = data2['user_data'][count].alert_meg;


    $('.user_alert_list').append('<li onclick="notification1('+notification_id+')" class="notification-list-item"><p class="message">'+alert_meg+'</p></li>');

      }

      for(var count = 0; count < data2['form_data'].length; count++)
       {

        // var work_flow_id = data2['work_flow_data'][count].work_flow_id;
        // var notification_type = data2['work_flow_data'][count].notification_type;
        // var work_flow_name = data2['work_flow_data'][count].work_flow_name;
        // var notification_status = data2['work_flow_data'][count].notification_status;
        var notification_id = data2['form_data'][count].notification_id;
        var alert_meg = data2['form_data'][count].alert_meg;


    $('.form_alert_list').append('<li onclick="notification2('+notification_id+')" class="notification-list-item"><p class="message">'+alert_meg+'</p></li>');

      }

//      
for(var count = 0; count < data2['payment_data'].length; count++)
       {

        // var work_flow_id = data2['work_flow_data'][count].work_flow_id;
        // var notification_type = data2['work_flow_data'][count].notification_type;
        // var work_flow_name = data2['work_flow_data'][count].work_flow_name;
        // var notification_status = data2['work_flow_data'][count].notification_status;
        var notification_id = data2['payment_data'][count].notification_id;
        var alert_meg = data2['payment_data'][count].alert_meg;


    $('.payment_alert_list').append('<li onclick="notification3('+notification_id+')" class="notification-list-item"><p class="message">'+alert_meg+'</p></li>');

      }

    //   for(var count = 0; count < data2['paymentsuccessfull_data'].length; count++)
    //    {

    //     // var work_flow_id = data2['work_flow_data'][count].work_flow_id;
    //     // var notification_type = data2['work_flow_data'][count].notification_type;
    //     // var work_flow_name = data2['work_flow_data'][count].work_flow_name;
    //     // var notification_status = data2['work_flow_data'][count].notification_status;
    //     var notification_id = data2['paymentsuccessfull_data'][count].notification_id;
    //     var alert_meg = data2['paymentsuccessfull_data'][count].alert_meg;


    // $('.paymentsuccessful_alert_list').append('<li onclick="notification4('+notification_id+')" class="notification-list-item"><p class="message">'+alert_meg+'</p></li>');

    //   }
      for(var count = 0; count < data2['ovmmeeting_data'].length; count++)
       {


        var notification_id = data2['ovmmeeting_data'][count].notification_id;
        var alert_meg = data2['ovmmeeting_data'][count].alert_meg;


    $('.ovm_meeting').append('<li onclick="notification6('+notification_id+')" class="notification-list-item"><p class="message">'+alert_meg+'</p></li>');

      }
      for(var count = 0; count < data2['elinademolink_data'].length; count++)
       {


        // var work_flow_id = data2['work_flow_data'][count].work_flow_id;
        // var notification_type = data2['work_flow_data'][count].notification_type;
        // var work_flow_name = data2['work_flow_data'][count].work_flow_name;
        // var notification_status = data2['work_flow_data'][count].notification_status;


        var notification_id = data2['elinademolink_data'][count].notification_id;
        var alert_meg = data2['elinademolink_data'][count].alert_meg;


    $('.elinademo_alert_list').append('<li onclick="notification5('+notification_id+')" class="notification-list-item"><p class="message">'+alert_meg+'</p></li>');

      }

      for(var count = 0; count < data2['uamdata_data'].length; count++)
       {

        var notification_id = data2['uamdata_data'][count].notification_id;
        var alert_meg = data2['uamdata_data'][count].alert_meg;
          $('.uam_alert_list').append('<li onclick="notification66('+notification_id+')" class="notification-list-item"><p class="message">'+alert_meg+'</p></li>');
      }

      for(var count = 0; count < data2['activity_data'].length; count++)
       {

        var notification_id = data2['activity_data'][count].notification_id;
        var alert_meg = data2['activity_data'][count].alert_meg;
          $('.activity_alert_list').append('<li onclick="notification99('+notification_id+')" class="notification-list-item"><p class="message">'+alert_meg+'</p></li>');
      }

      for(var count = 0; count < data2['questionnaire_data'].length; count++)
       {
        var notification_id = data2['questionnaire_data'][count].notification_id;
        var alert_meg = data2['questionnaire_data'][count].alert_meg;
          $('.questionnaire_alert_list1').append('<li onclick="notification77('+notification_id+')" class="notification-list-item"><p class="message">'+alert_meg+'</p></li>');
      }

    },


    error:function(data){
    //  console.log(data);
   }
 });
}
});

   function notification(notification_id)
{
   var login_user_id = $('#login_user_id').val();

   var APP_URL = {!! json_encode(url('/')) !!};

       $.ajaxSetup({
     headers: {
       'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
     }
   });

       var notification_id = notification_id;

       // alert(APP_URL);

       //return false;

       $(".loader").show();
   $.ajax({
     url: '{{ url('/user/notification_alert') }}',    
     type:"POST",
     dataType:"json",
     async: false,
     data: {notification_id: notification_id, _token: '{{csrf_token()}}'},
     success:function(data){

    var url = data['work_flow_data'][0].notification_url;

//       var notification_type =  data[0].screen_url;

// var edit = "edit";



     window.location.href = APP_URL+'/'+url;
      


    },

    error:function(data){
    //  console.log(data);
   }
 });
}

   function notification1(notification_id)
{
   var login_user_id = $('#login_user_id').val();

   var APP_URL = {!! json_encode(url('/')) !!};

       $.ajaxSetup({
     headers: {
       'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
     }
   });

       var notification_id = notification_id;

        // alert(APP_URL);

       //return false;

       $(".loader").show();
   $.ajax({
     url: '{{ url('/user/notification_alert') }}',    
     type:"POST",
     dataType:"json",
     async: false,
     data: {notification_id: notification_id, _token: '{{csrf_token()}}'},
     success:function(data){

    var url = data['user_data'][0].notification_url;
// console.log(url);
//       var notification_type =  data[0].screen_url;

// var edit = "edit";



     window.location.href = APP_URL+'/'+url;
      


    },

    error:function(data){
      
    //  console.log(data);
   }
 });
}
function notification2(notification_id)
{
   var login_user_id = $('#login_user_id').val();

   var APP_URL = {!! json_encode(url('/')) !!};

       $.ajaxSetup({
     headers: {
       'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
     }
   });

       var notification_id = notification_id;

        // alert(APP_URL);

       //return false;

       $(".loader").show();
   $.ajax({
     url: '{{ url('/user/notification_alert') }}',    
     type:"POST",
     dataType:"json",
     async: false,
     data: {notification_id: notification_id, _token: '{{csrf_token()}}'},
     success:function(data){
      // console.log(data);

    var url = data['form_data'][0].notification_url;
// console.log(url);

//       var notification_type =  data[0].screen_url;

// var edit = "edit";



     window.location.href = APP_URL+'/'+url;
      


    },

    error:function(data){
      
    //  console.log(data);
   }
 });
}

function notification3(notification_id)
{
   var login_user_id = $('#login_user_id').val();

   var APP_URL = {!! json_encode(url('/')) !!};

       $.ajaxSetup({
     headers: {
       'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
     }
   });

       var notification_id = notification_id;

        // alert(APP_URL);

       //return false;

       $(".loader").show();
   $.ajax({
     url: '{{ url('/user/notification_alert') }}',    
     type:"POST",
     dataType:"json",
     async: false,
     data: {notification_id: notification_id, _token: '{{csrf_token()}}'},
     success:function(data){

    var url = data['payment_data'][0].notification_url;
// console.log(url);

//       var notification_type =  data[0].screen_url;

// var edit = "edit";



     window.location.href = APP_URL+'/'+url;
      


    },

    error:function(data){
      
    //  console.log(data);
   }
 });
}

// function notification4(notification_id)
// {
//    var login_user_id = $('#login_user_id').val();

//    var APP_URL = {!! json_encode(url('/')) !!};

//        $.ajaxSetup({
//      headers: {
//        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
//      }
//    });

//        var notification_id = notification_id;

//         // alert(APP_URL);

//        //return false;


//    $.ajax({
//      url: '{{ url('/user/notification_alert') }}',    
//      type:"POST",
//      dataType:"json",
//      async: false,
//      data: {notification_id: notification_id, _token: '{{csrf_token()}}'},
//      success:function(data){

//     var url = data['paymentsuccessfull_data'][0].notification_url;
//   // console.log(url);

//   //       var notification_type =  data[0].screen_url;

//   // var edit = "edit";



//      window.location.href = APP_URL+'/'+url;
      


//     },

//     error:function(data){
      
//     //  console.log(data);
//    }
//  });
// }

function notification6(notification_id)
{
   var login_user_id = $('#login_user_id').val();

   var APP_URL = {!! json_encode(url('/')) !!};

       $.ajaxSetup({
     headers: {
       'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
     }
   });

       var notification_id = notification_id;

        // alert(APP_URL);

       //return false;
       $(".loader").show();
   $.ajax({
     url: '{{ url('/user/notification_alert') }}',    
     type:"POST",
     dataType:"json",
     async: false,
     data: {notification_id: notification_id, _token: '{{csrf_token()}}'},
     success:function(data){
      
// console.log(data);
    
  // console.log( data['ovmmeeting_data'][0]);
  var url = data['ovmmeeting_data'][0].notification_url;

  //       var notification_type =  data[0].screen_url;

  // var edit = "edit";



     window.location.href = APP_URL+'/'+url;
      


    },

    error:function(data){
      
    //  console.log(data);
   }
 });
}
function notification66(notification_id)
{
   var login_user_id = $('#login_user_id').val();

   var APP_URL = {!! json_encode(url('/')) !!};

       $.ajaxSetup({
     headers: {
       'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
     }
   });
   var notification_id = notification_id;
   $(".loader").show();
   $.ajax({
     url: '{{ url('/user/notification_alert') }}',    
     type:"POST",
     dataType:"json",
     async: false,
     data: {notification_id: notification_id, _token: '{{csrf_token()}}'},
     success:function(data){
    var url = data['uamdata_data'][0].notification_url;
    // console.log(url);
     window.location.href = APP_URL+'/'+url;     
    },
    error:function(data){
    //  console.log(data);
   }
 });
}

function notification99(notification_id)
{
   var login_user_id = $('#login_user_id').val();

   var APP_URL = {!! json_encode(url('/')) !!};

       $.ajaxSetup({
     headers: {
       'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
     }
   });
   var notification_id = notification_id;
   $(".loader").show();
   $.ajax({
     url: '{{ url('/user/notification_alert') }}',    
     type:"POST",
     dataType:"json",
     async: false,
     data: {notification_id: notification_id, _token: '{{csrf_token()}}'},
     success:function(data){
    var url = data['activity_data'][0].notification_url;
    // console.log(url);
     window.location.href = APP_URL+'/'+url;     
    },
    error:function(data){
    //  console.log(data);
   }
 });
}

function notification77(notification_id)
{
   var login_user_id = $('#login_user_id').val();

   var APP_URL = {!! json_encode(url('/')) !!};

       $.ajaxSetup({
     headers: {
       'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
     }
   });
   var notification_id = notification_id;
   $(".loader").show();
   $.ajax({
     url: '{{ url('/user/notification_alert') }}',    
     type:"POST",
     dataType:"json",
     async: false,
     data: {notification_id: notification_id, _token: '{{csrf_token()}}'},
     success:function(data){
    var url = data['questionnaire_data'][0].notification_url;
    // console.log(url);
     window.location.href = APP_URL+'/'+url;     
    },
    error:function(data){
    //  console.log(data);
   }
 });
}

</script>
@include('layouts.script')

</body>


</html>




