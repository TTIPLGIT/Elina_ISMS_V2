<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Elina Services</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Barlow+Semi+Condensed:wght@400;500;600&display=swap">

    <link rel="stylesheet" href="{{asset('assets/parent_library/vendors/mdi/css/materialdesignicons.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/parent_library/vendors/css/vendor.bundle.base.css')}}">
    <link rel="stylesheet" href="{{asset('assets/parent_library/css/style.css')}}">
    <link rel="stylesheet" href="{{asset('assets/parent_library/css/navbar.min.css')}}">
    <link rel="shortcut icon" href="{{asset('assets/parent_library/images/favicon.ico')}}" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.bootstrap5.min.css">

    <script src="https://code.jquery.com/jquery-3.7.0.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.5.0/js/responsive.bootstrap5.min.js"></script>
    <link href="{{asset('asset/css/sweetalert.min.css')}}" type="text/css" rel="stylesheet" />
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/css/intlTelInput.min.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/intlTelInput.min.js"></script>

    <!--  -->


    <style>
        .fa {
            color: white !important;
        }

        .readonly {
            background-color: #8080803d !important;
        }

        .form-control:disabled,
        .form-control[readonly] {
            background-color: #e9ecef !important;
            opacity: 1;
        }

        .loader {
            position: fixed;
            left: 0px;
            top: 0px;
            width: 100%;
            height: 100%;
            z-index: 9999;
            background: url('/images/elinaloader.gif') 50% 50% no-repeat rgb(249, 249, 249);
        }

        .required:after {
            content: " *";
            color: red;
        }

        .dropdown-divider {
            border: 1px solid;
            opacity: 0.9;
        }

        .capitalize {
            text-transform: capitalize;
        }

        .step-back-button,
        .step-prev-button,
        .step-next-button {
            background: #15B99E !important;
            border-color: #15B99E !important;
            color: white !important;
        }

        @media only screen and (max-width: 768px) {
            .mdi-bell-outline:before {
                color: black;
            }
        }

        @media (max-width: 768px) {
            .dataTables_wrapper .row {
                display: flex;
                flex-wrap: wrap;
                gap: 10px;
                /* Adjust the gap as needed */
            }

            .dataTables_wrapper .col-sm-12 {
                flex: 0 0 100%;
                max-width: 100%;
            }

            .dataTables_wrapper .col-md-6 {
                flex: 0 0 100%;
                max-width: 100%;
            }
        }

        @media (min-width: 322px) and (max-width: 370px) {
            .isms_header {

                /* Adjust the gap as needed */
                margin-right: 42px !important;
            }
        }

        @media (min-width: 374px) and (max-width: 423px) {
            .isms_header {

                /* Adjust the gap as needed */
                margin-right: 41px !important;
            }
        }

        @media (min-width: 424px) and (max-width: 767px) {
            .isms_header {

                /* Adjust the gap as needed */
                margin-right: 62px !important;
            }
        }
    </style>
</head>

<body>
    <div class='loader'></div>
    <div class="container-scroller">
        <nav class="navbar default-layout-navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
            <div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-center">
                <a class="navbar-brand brand-logo"><img src="{{asset('assets/parent_library/images/elina-logo-mini.png')}}" alt="logo" /></a>
                <a class="navbar-brand brand-logo-mini"><img src="{{asset('assets/parent_library/images/elina-logo.png')}}" alt="logo" /></a>
            </div>

            <div class="navbar-menu-wrapper d-flex align-items-stretch">
                <button class="navbar-toggler navbar-toggler align-self-center" type="button" data-toggle="minimize">
                    <span class="mdi mdi-menu"></span>
                </button>
                <div class="d-flex align-items-center justify-content-center isms_header" style="flex-grow: 1;">
                    <h2 class="text-center d-none d-sm-block">ELINA ISMS PORTAL</h2>
                    <h2 class="text-center text-black d-sm-none m-0 headeings">ELINA ISMS</h2>
                </div>

                <ul class="navbar-nav navbar-nav-right">
                    <li class="nav-item nav-logout d-none d-lg-block">
                        <a class="nav-link">
                            <div class="nav-profile-text">
                                <!-- <p class="mb-1">00:00:00 </p> -->
                                <span id="timer" style="text-align: center;"></span>
                            </div>
                        </a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link count-indicator dropdown-toggle" id="notificationDropdown" href="#" data-bs-toggle="dropdown">
                            <i class="mdi mdi-bell-outline"></i>
                            <span class="count-symbol bg-danger"></span>
                        </a>
                        <div class="col-md-12 dropdown-menu dropdown-menu-right navbar-dropdown preview-list" aria-labelledby="notificationDropdown" id="divNotification" style="max-height: 300px;width: 270px;overflow: scroll;">

                        </div>
                    </li>

                    <li class="nav-item nav-profile dropdown">
                        <a class="nav-link dropdown-toggle" id="profileDropdown" href="{{ route('profilepage') }}" data-bs-toggle="dropdown" aria-expanded="false">
                            <div class="nav-profile-img d-none">
                                <img src="{{$modules['user_profile'][0]['profile_image']}}" alt="image">
                                <span class="availability-status online"></span>
                            </div>
                            <div class="nav-profile-text">
                            @if($modules['user_role'] != 'Parent' && $modules['user_role'] != 'Child' && $modules['user_role'] != '')
                                <p class="mb-1 text-black">{{$modules['user_profile'][0]['role_name']}}</p>
                            @else
                                <p class="mb-1 text-black">{{$modules['user_profile'][0]['name']}}</p>
                            @endif
                            </div>
                        </a>
                        <div class="dropdown-menu navbar-dropdown responsiveDropdown" style="margin-left: 0;" aria-labelledby="profileDropdown">
                            <a class="dropdown-item" href="{{ route('profilepage') }}">
                                <i class="mdi mdi-account me-2 text-success"></i> Profile </a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                                <i class="mdi mdi-logout me-2 text-primary"></i> Logout </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">@csrf</form>
                        </div>
                    </li>
                </ul>
                <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button" data-toggle="offcanvas">
                    <span class="mdi mdi-menu"></span>
                </button>
            </div>
        </nav>
        <!-- partial -->
        <div class="container-fluid page-body-wrapper" style="padding-right: 0;padding-left: 0;">
            <!-- partial:partials/_sidebar.html -->
            <nav class="sidebar sidebar-offcanvas" id="sidebar">
                <ul class="nav">
                    <li class="nav-item nav-profile">
                        <a href="#" class="nav-link">
                            <div class="nav-profile-image">
                                <img src="{{asset('assets/parent_library/images/face1.jpg')}}" alt="profile">
                                <span class="login-status online"></span>
                                <!--change to offline or busy as needed-->
                            </div>
                            <div class="nav-profile-text d-flex flex-column">
                                <span class="font-weight-bold mb-2">{{$modules['user_profile'][0]['name']}}</span>
                                <span class="text-secondary text-white">{{$modules['user_profile'][0]['role_name']}}</span>
                            </div>
                            <!-- <i class="mdi mdi-bookmark-check text-success nav-profile-badge"></i> -->
                        </a>
                    </li>
                    @if($modules['user_role'] != 'Parent' && $modules['user_role'] != 'Child' && $modules['user_role'] != '')
                    <li class="dropdown "><a href="{{route('home')}}" class="nav-link"><span>Dashboard</span></a></li>
                    <li class="dropdown "><a href="{{route('questionnaire.dashboard')}}" class="nav-link"><span>Feedback Dashboard</span></a></li>
                    @endif
                    <!-- <li class="nav-item">
                        <a class="nav-link" href="index.html">
                            <span class="menu-title">Dashboard</span>
                            <i class="mdi mdi-home menu-icon"></i>
                        </a>
                    </li> -->
                    @if($modules['parentModule'] !="")
                    @foreach ($modules['parentModule'] as $key => $module)
                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="collapse" href="#{{ str_replace(' ', '', $module['module_name']) }}" aria-expanded="false" aria-controls="{{ str_replace(' ', '', $module['module_name']) }}">
                            <span class="menu-title">{{$module['module_name']}}</span>
                            <i class="menu-arrow"></i>
                            <i class="{{$module['class_name']}}"></i>
                        </a>
                        <div class="collapse" id="{{ str_replace(' ', '', $module['module_name']) }}">
                            @if($screens['parentScreen'] !="")
                            @foreach ($screens['parentScreen'] as $key => $screen)
                            @if($module['module_id'] == $screen['module_id'])
                            <ul class="nav flex-column sub-menu">
                                <li class="nav-item"> <a class="nav-link" href="{{ config('setting.base_url')}}{{ $screen['route_url'] }}">{{$screen['screen_name']}}</a></li>
                            </ul>
                            @endif
                            @endforeach
                            @endif
                        </div>
                    </li>
                    @endforeach
                    @endif



                </ul>
            </nav>
            <!-- partial -->
            <div class="main-panel">
                <div class="content-wrapper">
                    @yield('content')
                </div>
                <footer class="footer" style="display: none;">
                </footer>
            </div>
        </div>
    </div>
    <script src="{{asset('assets/parent_library/vendors/js/vendor.bundle.base.js')}}"></script>
    <script src="{{asset('assets/parent_library/js/hoverable-collapse.js')}}"></script>
    <script src="{{asset('assets/parent_library/js/off-canvas.js')}}"></script>
    <script src="{{asset('assets/parent_library/js/misc.js')}}"></script>
    <script src="{{asset('assets/parent_library/js/jquery.cookie.js')}}" type="text/javascript"></script>
    <script src="{{asset('assets/parent_library/js/jquery-3.6.4.min.js')}}"></script>

    <link rel="stylesheet" href="{{asset('assets/parent_library/vendors/mdi/css/materialdesignicons.min.css')}}">
    <script type="text/javascript">
        $(window).on('load', function() {
            $(".loader").fadeOut("slow");
        })
    </script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.7.1/js/dataTables.buttons.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.2.2/jszip.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.7.1/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.7.1/js/buttons.print.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.7.1/js/buttons.colVis.min.js"></script>

    <script>
        $(document).ready(function() {
            if ($(window).width() < 1024) {
                var resize = true;
            } else {
                var resize = false;

            }
            // Initialize the DataTable
            var table = new DataTable('#tableList', {
                responsive: resize,
                order: [],
                openable: true, // Allow rows to be opened
                dom: 'lBfrtip', // 'l' for length changing input, 'B' for buttons, 'f' for filtering input, 'r' for processing display element, 't' for table, 'i' for table information summary, 'p' for pagination controls

                buttons: [{
                        extend: 'pdfHtml5',
                        text: 'PDF',
                        className: 'btn btn-success'
                    },
                    {
                        extend: 'csvHtml5',
                        text: 'CSV',
                        className: 'btn btn-primary'
                    },
                    {
                        extend: 'excelHtml5',
                        text: 'Excel',
                        className: 'btn btn-warning'
                    },
                    {
                        extend: 'print',
                        text: 'Print',
                        className: 'btn btn-primary'
                    }
                ],
                drawCallback: function(settings) {
                    var api = this.api();
                    var currentPage = api.page.info().page;
                    var totalPages = api.page.info().pages;

                    if (totalPages <= 1) {
                        $('.dataTables_paginate').addClass('d-none');
                    } else {
                        $('.dataTables_paginate').removeClass('d-none');
                    }

                    if (currentPage === totalPages - 1) {
                        $('.paginate_button.next', this.api().table().container()).addClass('d-none');
                    } else {
                        $('.paginate_button.next', this.api().table().container()).removeClass('d-none');
                    }

                    if (currentPage === 0) {
                        $('.paginate_button.previous', this.api().table().container()).addClass('d-none');
                    } else {
                        $('.paginate_button.previous', this.api().table().container()).removeClass('d-none');
                    }

                    // Open all rows by default
                    api.rows().every(function() {
                        this.child.show();
                        $(this.node()).addClass('dt-hasChild parent');
                    });
                }
            });


        });
    </script>
    <!-- #td_05 -->
    <script>
        var id = "parent";
        $(document).ready(function() {
            $.ajax({
                url: "{{ url('/user/notifications') }}",
                type: "POST",
                dataType: "json",
                async: false,
                data: {
                    id: id,
                    _token: '{{csrf_token()}}'
                },
                success: function(data) {
                    // console.log('Noti', data.notifications);
                    var notifications = data.notifications;
                    for (var index = 0; index < notifications.length; index++) {
                        var notification_id = notifications[index].notification_id;
                        var alert_meg = notifications[index].alert_meg;
                        var notification_type = notifications[index].notification_type;
                        // 
                        var html = '<div class="dropdown-divider"></div>';
                        // html += '<div class="preview-thumbnail"><div class="preview-icon bg-success"><i class="mdi mdi-calendar"></i></div></div>';
                        html += '<a class="dropdown-item preview-item" onclick="notification(' + notification_id + ')" style="white-space: pre-line;">';
                        html += '<div class="preview-item-content d-flex align-items-start flex-column justify-content-center">';
                        html += '<h6 class="preview-subject font-weight-normal mb-1 capitalize">' + notification_type + '</h6>';
                        html += '<p class="text-gray mb-0"> ' + alert_meg + ' </p>';
                        html += '</div></a>';
                        // 
                        $('#divNotification').append(html);
                    }
                },
                error: function(data) {
                    console.log('Noti', data);
                }
            });
        });

        function notification(notification_id) {

            var APP_URL = <?php echo json_encode(url('/')); ?>;
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            var notification_id = notification_id;
            $(".loader").show();
            $.ajax({
                url: "{{ url('/user/notification_alert') }}",
                type: "POST",
                dataType: "json",
                async: false,
                data: {
                    notification_id: notification_id,
                    _token: '{{csrf_token()}}'
                },
                success: function(data) {
                    var url = data[0].notification_url;
                    window.location.href = APP_URL + '/' + url;
                },
                error: function(data) {
                    //  console.log(data);
                }
            });
        }
    </script>
    <script>
        $(document).ready(function() {
            var multipleDevice = <?php echo json_encode(session()->get("multipleDevice")); ?>;
            if (multipleDevice == 1) {
                swal.fire('Another Session Detected', 'You are currently logged in from another device/location. For security reasons, simultaneous logins from multiple devices/locations are not allowed. Your previous session will be auto logging out.', 'info');
                <?php echo json_encode(session()->put('multipleDevice', 0)); ?>;
            }

            localStorage.setItem('alertShown', 'false');
            // var sessionTimer = new Date('2023-10-26 18:40:00'); //2023-07-14 18:03:35;
            var sessionTimer = <?php echo json_encode(session()->get("sessionTimer")); ?>;
            var userID = <?php echo json_encode(session()->get("userID")); ?>;

            var targetDateTime = new Date(sessionTimer);
            var displayTime = new Date(targetDateTime.getTime() - (5 * 60 * 1000));
            var currentTime = new Date();
            if (currentTime >= displayTime) {
                showTimer();
                showAlert();
            } else {
                showTimer();
                var delay = displayTime - currentTime;
                setTimeout(showAlert, delay);
            }

            function showTimer() {
                // document.getElementById("timerText").style.display = "block";
                document.getElementById("timer").style.display = "block";
                var timerInterval = setInterval(updateTimer, 1000);
                updateTimer();
            }

            function showAlert() {
                if (localStorage.getItem('unauthenticated') == 'false') {
                    var formattedTime = targetDateTime.toLocaleTimeString([], {
                        hour: 'numeric',
                        minute: '2-digit'
                    });
                    swal.fire('info', 'Your Session will Expire Soon.Please save your work before the page expires.', 'info');
                    localStorage.setItem('alertShown', 'true');
                }
            }

            function updateTimer() {
                var currentTime = new Date().getTime();
                var timeDifference = targetDateTime - currentTime;
                var days = Math.floor(timeDifference / (1000 * 60 * 60 * 24));
                var hours = Math.floor((timeDifference % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                var minutes = Math.floor((timeDifference % (1000 * 60 * 60)) / (1000 * 60));
                var seconds = Math.floor((timeDifference % (1000 * 60)) / 1000);
                document.getElementById("timer").innerHTML = 'Session Ends in <br>' + (hours != 0 ? hours + "h " : '') + minutes + "m " + seconds + "s ";
                // console.log(timeDifference);
                if (timeDifference <= 0) {
                    // console.log('if');
                    // document.getElementById("timerText").style.display = "none";
                    document.getElementById("timer").innerHTML = "Session Expired!";
                    if (localStorage.getItem('unauthenticated') == 'false') {
                        $.ajax({
                            url: '/user/session/expire',
                            type: 'GET',
                            async: false,
                            data: {
                                userID: userID,
                                _token: '{{csrf_token()}}'
                            }
                        }).done(function(data) {
                            window.location = "{{ route('unauthenticated') }}";
                        });
                    }
                } else {
                    // console.log('else');
                    localStorage.setItem('unauthenticated', 'false');
                }
            }
        });
    </script>
    <script>
        function showAlert(title, text, icon) {
            swal.fire(title, text, icon);
        }
    </script>
    @include('layouts.script')
</body>

</html>