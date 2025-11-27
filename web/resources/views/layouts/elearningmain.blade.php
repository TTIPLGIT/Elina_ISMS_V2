<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
    <title>MLHUD</title>

    <!-- Bootstrap v4.3.1 CSS File -->
    <link href="{{asset('asset/css/app.min.css')}}" rel="stylesheet" type="text/css" />

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.2/font/bootstrap-icons.css">
    <!-- Font-Awesome v4.2.0 -->
    <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" type="text/css" rel="stylesheet" />

    <!--dropzone css -->
    <!-- jQuery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>


    <link href="{{asset('css/select2.css')}}" type="text/css" rel="stylesheet" />

    <!-- Template CSS -->
    <link href="{{asset('asset/css/style.css')}}" type="text/css" rel="stylesheet" />
    <link href="{{asset('asset/css/components.css')}}" type="text/css" rel="stylesheet" />
    <!-- Custom style CSS -->
    <link href="{{asset('asset/css/custom.css')}}" type="text/css" rel="stylesheet" />

    <link href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.2/themes/smoothness/jquery-ui.css" type="text/css" rel="stylesheet" />

    <link rel="stylesheet" type="text/css" href="{{ asset('css/hummingbird_v1.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/hummingbird_treeview.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/select2.css') }}" />

    <link rel="stylesheet" type="text/css" href="https://code.jquery.com/ui/1.10.2/themes/smoothness/jquery-ui.css">

    <link rel="stylesheet" href="https://cdn.rawgit.com/t4t5/sweetalert/v0.2.0/lib/sweet-alert.css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css">

    <link href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/4.3.0/dropzone.css" rel="stylesheet">

    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/4.3.0/dropzone.js"></script>

    <script type="text/javascript" src="{{ asset('js/hummingbird_treeview.js') }}"></script>

    <script type="text/javascript" src="{{ asset('js/select2.js') }}"></script>

    <link href="{{asset('assets/css/adminnavbar.min.css')}}" rel="stylesheet" type="text/css" />



    <!-- loading gif -->
    <!-- Ck editor -->
    <script src="https://cdn.tiny.cloud/1/1pvpoo3olz0n1t42br79z0fne5gce6ayj2lt9hmmcg04gqkg/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>

    <style>
        .li {
            padding-top: 10px;
        }

        .nav11 {
            background-color: #D1812E !important;

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
    </style>

    <style>
        @media (min-width:319.96px) {
            .search-box{
                width: 110px !important;
                position: relative !important;
            }
            #bell {
                position: absolute;
                top: 18px !important;
                right: 60px !important;
            }
            .nav11{
                padding: 0px !important;
            }
        }
        @media (min-width:374.96px) {
            .search-box{
                width: 160px !important;
            }
        }
        @media (min-width:424.96px) {
            .search-box{
                width: 190px !important;
            }
        }
        @media (min-width:575.96px) {
            .search-box{
                width: 330px !important;
            }
            #bell {
                position: absolute;
                top: 4px !important;
                right: 12px !important;
            }
        }
        @media (min-width:767.96px) {
            .nav11{
                padding: 0.5rem 1rem !important;
            }
            .search-box{
                width: 500px !important;
            }
            .search-input:focus {
                -webkit-box-shadow: 1px 1px #141ad8;
                box-shadow: 1px 1px #141ad8;
            }
        }
        @media (min-width:1024.96px) {
            .nav11{
                left: 200px !important;
            }
        }
        .main-sidebar{
            width: 200px !important;
        }
        .sidebar-mini .navbar{
            left: 65px !important;
        }
        .sidebar-mini .main-sidebar{
            width: 65px !important;
        }
        .sidebar-mini .main-sidebar .sidebar-menu>li{
            padding-top: 0px !important;
            padding-bottom: 0px !important;
        }
        .sidebar-menu{
            margin-top: 1rem !important;
        }
        .sidebar-secondary-menu{
            position: absolute;
            left: 0px !important;
            bottom: 0px !important;
        }
        .sidebar-icons{
            font-size: 1.5rem !important;
        }
        .collapse_btn{
            margin-top: auto !important;
            margin-bottom: auto !important;
        }
        .collapse_btn_icon{
            color: #141ad8 !important;
        }
        .fullscreen_btn{
            margin-top: auto !important;
            margin-bottom: auto !important;
        }
        .fullscreen_btn_icon{
            color: #141ad8 !important;
        }
        .search-input{
            color: #141ad8 !important;
            width: 100% !important;
            box-sizing: border-box !important;
            border: 0px !important;
            border-radius: 25px !important;
            font-size: 16px !important; 
            background-color: white !important;
            padding-top: 8px !important;
            padding-bottom: 8px !important;
            padding-left: 40px !important;
            z-index: 0 !important;
            transition: 0.4s ease-in-out !important;
            outline: none !important;
        }
        .search-input::placeholder{
            color: #141ad8 !important;
            padding-top: 0px !important;
            padding-bottom: 0px !important;
        }
        .search-icon{
            color: #141ad8 !important;
            position: absolute;
            left: 0px !important;
            z-index: 1 !important;
            font-size: 1.2rem !important;
            padding: 12px !important;
        }
        .nav11{
            background-color: white !important;
        }
        .main-sidebar .sidebar-menu li a span{
            width: auto !important;
        }
        .profile_pic_icon{
            color: #141ad8 !important;
            font-size: 1.5rem !important;
        }
        .vertical_center{
            align-items: center !important;
        }
        
    </style>
    <!-- newly added -->
    <style>
        body{
            background-color: #f8f9fc !important;
        }
        .sidebar_links.active{
            background-color: #001b52 !important;
        }
    </style>

</head>

<body>
    <div class="loader"></div>
    <div id="app">
        <div class="main-wrapper main-wrapper-1">
            <div class="navbar-bg"></div>
            <nav class="navbar nav11 navbar-expand-lg main-navbar">
                <div class="form-inline mr-auto">
                    <ul class="navbar-nav mr-3">
                        <li class="collapse_btn">
                            <a href="#" data-toggle="sidebar" class="nav-link nav-link-lg collapse-btn">
                            <i class="fa fa-bars collapse_btn_icon" aria-hidden="true"></i>
                            </a>
                        </li>
                        <li class="fullscreen_btn">
                            <a href="#" class="nav-link nav-link-lg fullscreen-btn">
                                <i class="fas fa-expand fullscreen_btn_icon"></i>
                            </a>
                        </li>
                        <li>
                            <div class="search-box">
                                <input type="text" class="search-input" placeholder="Search any keyword" aria-label="Username" aria-describedby="addon-wrapping">
                                <i class="fa fa-search search-icon" aria-hidden="true"></i>
                            </div>
                        </li>
                    </ul>
                </div>
                <ul class="navbar-nav navbar-right vertical_center">
                    <li class="dropdown dropdown-list-toggle">
                        <a href="#" data-toggle="dropdown" class="nav-link notification-toggle nav-link-lg badges">
                            <i id="bell" class="far fa-bell"></i>
                            <span id="notifier"></span>
                            <span class="badge badge-danger badge-counter"></span>
                        </a>
                        <div class="dropdown-menu dropdown-list dropdown-menu-right" style="border-radius: 5px; border: 2px solid rgb(0, 34, 102); background-color:#f5f6fa;">
                            <div class="dropdown-header">
                                <h4>Notifications</h4>
                                <div class="float-right">
                                    <!-- <a href="#">Mark All As Read</a> -->
                                </div>
                            </div>
                            <div class="dropdown-list-content dropdown-list-icons" style="cursor: pointer !important; ">
                                <a>
                                    <span style="color:rgb(0, 34, 102) !important;  font-size:13px !important;"><span style="padding:10px !important; color:green !important;"><i class="fa fa-info-circle" aria-hidden="true"></i></span></span>
                                    <hr style="border-top: 1px dashed rgb(0, 34, 102);">
                                </a>
                            </div>
                        </div>
                    </li>
                    <li class="dropdown">
                        <a data-toggle="dropdown" class="nav-link dropdown-toggle nav-link-lg nav-link-user">
                            <i class="fas fa-user profile_pic_icon"></i>
                            <span class="d-sm-none d-lg-inline-block"></span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right">
                            <a href="#" class="dropdown-item has-icon">
                                <i class="far fa-user" style="color:red !important;"></i>
                                <b style="color:blue !important;">Profile</b>
                            </a>
                        </div>
                    </li>
                </ul>
            </nav>

            <div class="main-sidebar sidebar-style-2" style=" background-color: rgb(0, 34, 102) !important;">
                <aside id="sidebar-wrapper" style=" background-color: rgb(0, 34, 102) !important;">
                    <div class="sidebar-brand" style=" background-color:white!important;">
                        <img src="{{asset('asset/image/logo-mlhud.png')}}" alt="logo" class="logo" width="180px">
                    </div>
                    <ul class="sidebar-menu">
                        <li>
                            <a href="{{ route('elearningDashboard') }}" class="nav-link sidebar_links">
                                <i class="sidebar-icons fa fa-home" aria-hidden="true"></i>
                                <span>Dashboard</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('elearningAllCourses') }}" class="nav-link sidebar_links">
                                <i class="sidebar-icons fa fa-graduation-cap" aria-hidden="true"></i>
                                <span>All Courses</span>
                            </a>
                        </li>
                        <!-- <li>
                            <a href="" class="nav-link">
                                <i class="sidebar-icons fa fa-spinner" aria-hidden="true"></i>
                                <span>Progress</span>
                            </a>
                        </li> -->
                        <li>
                            <a href="{{ route('elearningWishlist') }}" class="nav-link sidebar_links">
                                <i class="sidebar-icons bi bi-heart-fill" aria-hidden="true"></i>
                                <span>Wish List</span>
                            </a>
                        </li>
                        <li>
                            <a href="" class="nav-link sidebar_links">
                                <i class="sidebar-icons bi bi-cart4" aria-hidden="true"></i>
                                <span>Cart</span>
                            </a>
                        </li>
                        <li>
                            <a href="" class="nav-link sidebar_links">
                                <i class="sidebar-icons bi bi-patch-question-fill" aria-hidden="true"></i>
                                <span>Quiz</span>
                            </a>
                        </li>
                        <li>
                            <a href="" class="nav-link sidebar_links">
                                <i class="sidebar-icons fa fa-trophy" aria-hidden="true"></i>
                                <span>Assessment</span>
                            </a>
                        </li>
                        <li>
                            <a href="" class="nav-link sidebar_links">
                                <i class="sidebar-icons fa fa-sign-out" aria-hidden="true"></i>
                                <span>Logout</span>
                            </a>
                            <form id="logout-form" action="" method="POST" class="d-none">
                            </form>
                        </li>
                    </ul>
                </aside>
                <ul class="sidebar-menu sidebar-secondary-menu">
                    <li>
                        <a href="" class="nav-link">
                            <i class="sidebar-icons fa fa-arrow-left" aria-hidden="true"></i>
                            <span>Home</span>
                        </a>
                    </li>
                    <li>
                        <a href="" class="nav-link">
                            <i class="sidebar-icons fa fa-info" aria-hidden="true"></i>
                            <span>About Us</span>
                        </a>
                    </li>
                                <li>
                        <a href="" class="nav-link">
                            <i class="sidebar-icons fa fa-map-marker" aria-hidden="true"></i>
                            <span>Contact Us</span>
                        </a>
                    </li>
                </ul>
                <input type="hidden" name="testing_id" id="testing_id" value="{{URL::to('/')}}">
            </div>
        </div>
    </div>
    <main class="py-4">
        @yield('content')
    </main>
    <script>
        // let link = document.querySelectorAll(".sidebar_links");
        // link[0].classList.toogle("active");
    </script>
</body>
@include('layouts.script')

</html>