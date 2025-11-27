<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
  <meta name="csrf-token" content="nggJlyl8oRqH22vvHNdrFR3B8pqgteEf7IoMBoC7">
  <title>ISMS</title>
  <link href="http://localhost:60161/asset/css/app.min.css" rel="stylesheet" type="text/css" />
  <script src="http://localhost:60161/asset/js/jquery.min.js"></script>
  <link href="http://localhost:60161/asset/css/style.css" type="text/css" rel="stylesheet" />
  <link href="http://localhost:60161/assets/css/adminnavbar.min.css" rel="stylesheet" type="text/css" />

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
    .navigation {
      top: 0;
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
      line-height: 3.8rem;
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

    .right {
      float: right;
    }

    .left {
      float: left;
      list-style: none;
    }

    .badge {
      line-height: 20px !important;
      position: absolute !important;
      top: 6px !important;
      right: 60px !important;
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
      background: url('/images/loader.gif') 50% 50% no-repeat rgb(249, 249, 249);
    }

    .alert-head-background {
      background-color: rgb(39 86 104);
      color: #fff;
    }

    .alert-row-top {
      margin-top: 75px
    }

    .alert-message-top {
      margin-top: 20px;
    }

    .alert-image-size {
      width: 75px;
    }

    .btn-alert {
      background-color: rgb(39 86 104) !important;
      color: #fff !important;
    }
    .card .card-body p {
    font-weight: 900 !important;
}
  </style>

</head>

<body>
  <div id="app">
    <div class='loader'></div>

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


          <ul class="navbar-nav navbar-right" style="width: 160px;">
            <nav class="navigation" style="width: 20%;margin-right: 10px !important;">

              <span class="badge badge-light badgeworkflow" style="right: 130px !important;"></span>

              <ul class="inner-navigation">
                <li class="left">
                  <div class="dropdown-container">
                    <a href="#" data-dropdown="notificationMenu" class="menu-link has-notifications circle">
                      <i class="fa fa-bell"></i><span class="badge badge-light"></span>
                    </a>
                    <ul class="dropdown" name="notificationMenu">
                </li>
              </ul>
            </nav>


            <li class="dropdown" style="width: 80%;">
              <a data-toggle="dropdown" class="nav-link dropdown-toggle nav-link-lg nav-link-user d-flex align-items-center">
                <i class="fas fa-user navheading"></i>
                <span class="d-sm-none d-lg-inline-block" style="margin: 0 0 0 10px;"></span></a>
              <div class="dropdown-menu dropdown-menu-right">
                <a class="dropdown-item has-icon" href="http://localhost:60161/profilepage"><i class="fa fa-user" style="color:red !important;"></i><b style="color:blue !important;">Profile</b></a>
                <a class="dropdown-item has-icon" href="http://localhost:60161/FAQ_main"><i class="fa fa-question-circle" style="color:red !important;"></i><b style="color:blue !important;">FAQ</b></a>
                <a href="http://localhost:60161/logout" class="dropdown-item has-icon" onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                  <i class="fa fa-sign-out" style="color:red !important;"></i><b style="color:blue !important;">Logout</b></a>
                <form id="logout-form" action="http://localhost:60161/logout" method="POST" style="display: none;">
                  <input type="hidden" name="_token" value="nggJlyl8oRqH22vvHNdrFR3B8pqgteEf7IoMBoC7">
                </form>
              </div>
            </li>


          </ul>
        </nav>

        <div class="main-sidebar sidebar-style-2" style=" background-color: rgb(0, 34, 102) !important;">
          <aside id="sidebar-wrapper" style=" background-color: rgb(0, 34, 102) !important;">
            <div class="sidebar-brand" style=" background-color:white!important;">

              <img src="http://localhost:60161/assets/images/elina-logo-2.png" class="logo" style="  width: 70% !important;">
              </a>
            </div>

            <ul class="sidebar-menu" id="sidechecks">
            </ul>
          </aside>
          <input type="hidden" name="testing_id" id="testing_id" value="http://localhost:60161">
        </div>
      </div>
    </div>

    <main class="py-4">
      <div class="main-content">
        <section class="section">
          <div class="section-body mt-1">
            <div class="row alert-row-top">
              <div class="col-md-2"></div>
              <div class="col-md-6">
                <div class="card text-center">
                  <div class="card-header alert-head-background" style="justify-content: center;">{{ __('ISMS - Session Expired') }}</div>
                  <div class="card-body">
                    <img src="{{ asset('images/wrong.png') }}" class="alert-image-size">
                    <p class="card-text alert-message-top">Your session has expired / is invalid.</p>
                    <a href="{{ route('/') }} " class="btn btn-alert">Go Home</a>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </section>
      </div>
    </main>
  </div>
</body>
<script type="text/javascript">
  $(window).on('load', function() {
    $(".loader").fadeOut("slow");
  })
</script>

</html>