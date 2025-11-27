@extends('layouts.elearningmain')

@section('content')
<style>
    .card{
        box-shadow: none !important;
    }
    .main-content{
        padding-top: 80px !important;
        padding-left: 20px !important;
    }
    .overview_header{
        margin: 0px 0.5rem !important;
    }
    .overview_heading{
        color: #0006cc;
        font-weight: 900;
        font-size: 1.5rem !important;
    }
    .overview_filter{
        border: 0px !important;
        border-radius: 5px !important;
        padding: 5px !important;
        font-weight: 600 !important;
        font-size: 1rem !important;
        letter-spacing: 2px !important;
        width: fit-content !important;
        padding-right: 7% !important;
    }
    .overview_filter .dropdown-menu{
        width: fit-content !important;
    }
    .overview_body{
        flex-wrap: wrap !important;
    }
    .overview_body .card{
        width: 100% !important;
        border: 0px !important;
        margin-top: 0.5rem !important;
        margin-bottom: 0.5rem !important;
        margin-left: 0.5rem !important;
        margin-right: 0.5rem !important;
        border-radius: 5px !important;
    }
    .overview_body .card-header{
        color: #141ad8 !important;
        background-color: white !important;
        font-weight: 600 !important;
        padding-left: 1rem !important;
        border-bottom: 0px solid white !important;
        padding-bottom: 0px !important;
        min-height: 31px !important;
        border-top-left-radius: 5px !important;
        border-top-right-radius: 5px !important;
    }
    .overview_body .card-body{
        padding: 10px 10px !important;
        padding-top: 0px !important;
        border-top: 0px solid white !important;
        background-color: white !important;
        border-bottom-left-radius: 5px !important;
        border-bottom-right-radius: 5px !important;
    }
    .overview_count{
        padding-left: 5% !important;
        font-size: 1.5rem !important;
        color: #000 !important;
        font-weight: 900 !important;
        text-align: center !important;
    }
    .overview_img{
        width: 30% !important;
    }
    .overview_img#overview_img_exception{
        width: 35% !important;
    }
    .course{
        width: 50% !important;
        height: 300px !important;
        border: 0px !important;
        padding: 0px !important;
        margin: 0.5rem !important;
        border-radius: 5px !important;
        overflow: hidden !important;
    }
    .course_heading{
        color: #0006cc;
        font-weight: 900;
        font-size: 1rem !important;
        width: fit-content !important;
    }
    .course_filter{
        border: 0px !important;
        border-radius: 5px !important;
        padding: 5px !important;
        font-weight: 600 !important;
        font-size: 1rem !important;
        letter-spacing: 2px !important;
        width: fit-content !important;
        padding-right: 7% !important;
    }
    .course_filter .dropdown-menu{
        width: fit-content !important;
    }
    .course .card-header{
        width: 100% !important;
        height: 50px !important;
        padding: 0px 0px 7px 0px !important;
        background-color: #f8f9fc !important;
        border-top-left-radius: 5px !important;
        border-top-right-radius: 5px !important;
    }
    .course .card-body{
        width: 100% !important;
        border: 0px !important;
        padding: 0px !important;
        background-color: white !important;
    }
    
    .course_and_schedule_body{
        flex-wrap: wrap !important;
        width: 100% !important;
    }
    .schedule{
        width: 100% !important;
        height: 300px !important;
        border: 0px !important;
        margin-top: 0.5rem !important;
        margin-bottom: 0.5rem !important;
        margin-left: 0.5rem !important;
        margin-right: 0.5rem !important;
        border-radius: 5px !important;
        overflow: hidden !important;
    }
    .schedule_heading{
        color: #0006cc;
        font-weight: 900;
        font-size: 1rem !important;
        width: fit-content !important;
    }

    .schedule .card-header{
        width: 100% !important;
        height: 50px !important;
        padding: 0px 0px 7px 0px !important;
        background-color: #f8f9fc !important;
        border-top-left-radius: 5px !important;
        border-top-right-radius: 5px !important;
    }
    .schedule .card-body{
        width: 100% !important;
        height: 250px !important;
        padding: 0px 0px !important;
        background-color: white !important;
        border-radius: 5px !important;
        overflow: hidden !important;
    }
    
    .group_lessons, 
    .recommended_courses_list, 
    .notice_board_list {
        width: 100% !important;
        height: 325px !important;
        border: 0px !important;
        padding: 0px !important;
        margin: 0.5rem !important;
        border-radius: 5px !important;
        overflow: hidden !important;
    }
    .group_lessons .card-header, 
    .recommended_courses_list .card-header, 
    .notice_board_list .card-header{
        width: 100% !important;
        height: 75px !important;
        color: #0006cc;
        font-weight: 900;
        font-size: 1.5rem !important;
        padding: 10px 0px 7px 0px !important;
        background-color: #f8f9fc !important;
        border-top-left-radius: 5px !important;
        border-top-right-radius: 5px !important;
    }
    .group_lessons .card-body, 
    .recommended_courses_list .card-body, 
    .notice_board_list .card-body {
        width: 100% !important;
        height: 250px !important;
        border: 0px !important;
        padding: 0px !important;
        background-color: white !important;
        border-radius: 5px !important;
    }
    /* .calendar{
        width: 100% !important;
        height: 100% !important;
        padding: 10px 10px !important;
    }
    .calendar_header{
        width: 100% !important;
        height: 20% !important;
    }
    .calendar_body{
        width: 100% !important;
        height: 70% !important;+
    } */
    /* .week_days{
        background-color: #2196F3;
        padding: 5px;
    }
    .week_days > div{
        color: #000;
        text-align: center;
        font-size: 0.5rem;
    }
    .days{
        border: 1px solid #7ac0f8 !important;
        flex-wrap: wrap !important;
        width: fit-content !important;
        padding-top: 2px !important;
    }
    .days > div{
        border-bottom: 1px solid #7ac0f8 !important;
        padding: 5px !important;
        font-size: 0.5rem !important;
        color: #1a1a1a !important;
        width: calc(100%/7);
        text-align: center !important;
    }
    .days > div:nth-child(29),
    .days > div:nth-child(30),
    .days > div:nth-child(31){
        border-bottom: none !important;
    } */
    .event_indicator{
        width: 10px !important;
        height: 10px;
        color: #f69135;
        background-color: #f69135;
        border-radius: 50%;
    }
    /* calendar changes*/
    .schedule_frame{
        border: 0px !important;
    }
    .recommended_courses_list .card-body{
        overflow-y: auto;
        overflow-x: hidden;
    }
    .recommended_courses{
        width: 97%;
        height: 30%;
        overflow: hidden;
        margin: 0% 1.5% 5% 1.5%;
    }
    .recommended_courses:first-child{
        margin: 3% 1.5% 5% 1.5% !important;
    }
    .recommended_courses_poster{
        width: 30%;
        height: 100%;
    }
    .recommended_course_details{
        width: 65%;
        height: 100%;
    }
    .recommended_course_name{
        margin-bottom: 0px !important;
        color: #4d51db;
    }
    .recommended_course_instructor{
        padding-left: 1%;
        color: #999beb;
    }
    .recommended_course_footer{
        padding-left: 1%;
        color: #b1b1b1;
    }
    .notice_board_list .card-body{
        overflow-y: auto;
        overflow-x: hidden;
    }
    .notice_board{
        width: 97%;
        height: 25%;
        overflow: hidden;
        margin: 0% 1.5% 5% 1.5%;
    }
    .notice_board:first-child{
        margin: 1.5% 1.5% 5% 1.5% !important;
    }
    .notice_board_poster{
        width: 35%;
        height: 100%;
    }
    .notice_board_heading{
        width: 65%;
        height: 100%;
        padding: 0% 0% 0% 3%;
    }
    .notice_board_event_name{
        margin-bottom: 0px !important;
        color: #4d51db;
    }
    .notice_board_event_organiser{
        padding-left: 1%;
        color: #999beb;
    }
    .notice_board_footer{
        padding-left: 1%;
        color: #b1b1b1;
    }
    .group_lessons .card-body{
        overflow-y: auto !important;
        padding: 0% 5% 0% 5% !important;
    }
    .lesson{
        height: 250px;
        border-bottom: 1px solid #141ad8;
        margin: 20px 0px 5px 0px !important;
    }
    .group_lesson_author{
        color: #4d51db;
    }
    .group_lesson_course_name{
        color: #999beb;
    }
    .group_lesson_footer{
        margin-bottom: 10px !important;
    }
    .group_lesson_link{
        padding: 3px;
        border: 1px solid #f1f1f1;
        border-radius: 5px;
    }
    .group_lesson_link i{
        margin: 0px 5px 0px 10px !important;
    }
    .group_participants_container{
        width: 100%;
        height: 80px;
        margin: 20px 0px;
    }
    .group_participants_heading{
        width: 100%;
        font-weight: bold;
        height: 20px;
    }
    .group_participants_list{
        position: relative !important;
        width: 100% !important;
        height: 60px !important;
    }
    .group_participant1{
        position: absolute;
        top: 10%;
        left: 5px;
        width: 30px;
        height: 30px;
        clip-path: circle(30px);
        overflow: hidden;
    }
    .group_participant1 img{
        width: 30px;
        height: 30px;
        border-radius: 50%;
    }
    .group_participant2{
        position: absolute;
        top: 10%;
        left: 25px;
        width: 30px;
        height: 30px;
        clip-path: circle(30px);
        overflow: hidden;
    }
    .group_participant2 img{
        width: 30px;
        height: 30px;
        border-radius: 50%;
    }
    .group_participant3{
        position: absolute;
        top: 10%;
        left: 45px;
        width: 30px;
        height: 30px;
        clip-path: circle(30px);
        overflow: hidden;
    }
    .group_participant3 img{
        width: 30px;
        height: 30px;
        border-radius: 50%;
    }
    .group_participant4{
        position: absolute;
        top: 10%;
        left: 65px;
        width: 30px;
        height: 30px;
        clip-path: circle(30px);
        overflow: hidden;
    }
    .group_participant4 img{
        width: 30px;
        height: 30px;
        border-radius: 50%;
    }
    .group_participant5{
        position: absolute;
        top: 10%;
        left: 85px;
        width: 30px;
        height: 30px;
        clip-path: circle(30px);
        overflow: hidden;
    }
    .group_participant5 img{
        width: 30px;
        height: 30px;
        border-radius: 50%;
    }
    .group_participant_indicator{
        position: absolute;
        top: 10%;
        left: 105px;
        width: 30px;
        height: 30px;
        text-align: center;
        background-color: lightcyan;
        line-height: 30px;
        border-radius: 50%;
        clip-path: circle(30px);
    }
    .group_participant_indicator span{
        width: 100%;
        height: 100%;
        border-radius: 50%;
        color: #000;
        font-size: 0.75rem;
        font-weight: 900;
        text-align: center;
    }
    @media (min-width:319.96px) {
        .schedule{
            width: 100% !important;
            height: 500px !important;
        }
    }
    @media (min-width:424.96px) {
        .schedule{
            width: 70% !important;
            height: 500px !important;
        }
        .course{
            width: 70% !important;
        }
        .overview_body .card{
            width: 80% !important;
        }
    }
    @media (min-width:575.96px) {
        .schedule{
            width: 100% !important;
            height: 300px !important;
        }
        .schedule_heading{
            font-size: 1.5rem !important;
        }
        .course_heading{
            font-size: 1.5rem !important;
        }
        .course{
            width: 50% !important;
        }
        .overview_filter{
            padding-right: 4% !important;   
        }
        .overview_body .card{
            width: 46.5% !important;
        }
    }
    @media (min-width:767.96px) {
        .schedule{
            width: 70% !important;
        }
        .course{
            width: 70% !important;
        }
        .overview_body .card{
            width: 31% !important;
        }
    }
    @media (min-width:1024.96px) {
        .main-content{
            padding-left: 220px !important;
        }
        .sidebar-mini .main-content{
            padding-left: 85px !important;
        }
        .sidebar-mini .main-content .overview_body .card{
            width: 204px !important;
        }
        .course{
            width: 38% !important;
        }
        .schedule{
            width: 58% !important;
        }
        .overview_body .card{
            width: 31% !important;
        }
        .overview_filter{
            padding-right: 2% !important;   
        }
    }
    @media (min-width:1199.96px) {
        .overview_body{
            justify-content: space-between !important;
        }
        .overview_body .card{
            width: 17.85% !important;
        }
        .sidebar-mini .main-content .overview_body .card{
            width: 220px !important;
        }
    }
</style>
<div class="main-content">
    <section class="section">
        <div class="section-body mt-1">
            <div class="overview_container container-fluid">
                <div class="overview_header d-flex flex-row justify-content-between align-items-center">
                    <h2 class="overview_heading">
                        Overview
                    </h2>
                    
                    <select class="custom-select overview_filter">
                        <option value="Yearly" selected>Overall</option>
                        <option value="Yearly">Yearly</option>
                        <option value="Monthly">Monthly</option>
                        <option value="Weekly">Weekly</option>
                        <option value="Daily">Daily</option>
                    </select>
                </div>
                <div class="d-flex flex-row justify-content-center justify-content-sm-start overview_body">
                    <div class="card">
                        <div class="card-header">
                            <span>Course in Progress</span>
                        </div>
                        <div class="card-body d-flex flex-row justify-content-between align-items-center">
                            <span class="overview_count">02</span>
                            <img class="overview_img" id="overview_img_exception" src="{{asset('asset/image/courseInProgress.png')}}" alt="Course in Progress" width="40%">
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-header">
                            <span>Course Completed</span>
                        </div>
                        <div class="card-body d-flex flex-row justify-content-between align-items-center">
                            <span class="overview_count">07</span>
                            <img class="overview_img" src="{{asset('asset/image/courseCompleted.png')}}" alt="Course Completed" width="40%">
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-header">
                            <span>Watching Time</span>
                        </div>
                        <div class="card-body d-flex flex-row justify-content-between align-items-center">
                            <span class="overview_count">10h <sub>20m</sub></span>
                            <img class="overview_img" id="overview_img_exception" src="{{asset('asset/image/watchingTime.png')}}" alt="Watching Time" width="40%">
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-header">
                            <span>Certificates Achieved</span>
                        </div>
                        <div class="card-body d-flex flex-row justify-content-between align-items-center">
                            <span class="overview_count">05</span>
                            <img class="overview_img" src="{{asset('asset/image/certificateAchieved.png')}}" alt="Certificates Achieved" width="40%">
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-header">
                            <span>Credits Earned</span>
                        </div>
                        <div class="card-body d-flex flex-row justify-content-between align-items-center">
                            <span class="overview_count">670</span>
                            <img class="overview_img" src="{{asset('asset/image/creditsEarned.png')}}" alt="Credits Earned" width="40%">
                        </div>
                    </div>
                </div>
            </div>
            <div class="container-fluid course_and_schedule_container">
                <div class="d-flex flex-row justify-content-center justify-content-md-between align-items-center course_and_schedule_body">
                    <div class="card schedule">
                        <div class="card-header d-flex flex-row justify-content-center align-items-center">
                            <h2 class="schedule_heading">
                                Upcoming Events
                            </h2>
                        </div>
                        <div class="card-body">
                            <iframe class="schedule_frame" src="{{asset('asset/animated-calendar/index.html')}}" width="100%" height="100%"></iframe>
                        </div>
                    </div>
                    <div class="card course">
                        <div class="card-header d-flex flex-row justify-content-between align-items-center">
                            <h2 class="course_heading">
                                Study Statistics
                            </h2>
                                    
                            <select class="custom-select course_filter">
                                <option value="Weekly" selected>Weekly</option>
                                <option value="Monthly">Monthly</option>
                                <option value="Yearly">Yearly</option>
                                <option value="Yearly">Overall</option>
                            </select>
                        </div>
                        <div class="card-body">
                            <div id="line_top_x"></div>
                            </div>
                        </div>
                    </div>
                </div>  
            </div>
            <div class="container-fluid">
                <div class="row justify-content-between">
                    <div class="col-12 col-sm-6 col-lg-3">
                        <div class="card group_lessons">
                            <div class="card-header">
                                Group Lessons
                            </div>
                            <div class="d-flex flex-column justify-content-between card-body">
                                <div class="d-flex flex-column justify-content-between lesson">
                                    <div class="group_lesson_heading">
                                        <h5 class="group_lesson_author">
                                            Sirius Black
                                        </h5>
                                        <span class="group_lesson_course_name">
                                            Standards Used In An Survey
                                        </span>
                                    </div>
                                    <div class="group_participants_container">
                                        <h6 class="group_participants_heading">
                                            Participants
                                        </h6>
                                        <div class="group_participants_list">
                                            <div class="group_participant1">
                                                <img src="{{asset('asset/image/profile1.jpg')}}" alt="">
                                            </div>
                                            <div class="group_participant2">
                                                <img src="{{asset('asset/image/profile2.jpg')}}" alt="">
                                            </div>
                                            <div class="group_participant3">
                                                <img src="{{asset('asset/image/profile3.jpg')}}" alt="">
                                            </div>
                                            <div class="group_participant4">
                                                <img src="{{asset('asset/image/profile4.jpg')}}" alt="">    
                                            </div>
                                            <div class="group_participant5">
                                                <img src="{{asset('asset/image/profile5.jpg')}}" alt="">
                                            </div>
                                            <div class="group_participant_indicator">
                                                <span>30+</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="d-flex flex-row justify-content-between align-items-center group_lesson_footer">
                                        <span class="group_lesson_date">
                                            <i class="fa fa-calendar-o" aria-hidden="true"></i>
                                            07 Jun 2022
                                        </span>
                                        <span class="group_lesson_link">
                                            <a href="#" class="">
                                                Browse
                                                <i class="fa fa-chevron-right" aria-hidden="true"></i>
                                            </a>
                                        </span>
                                    </div>
                                </div>
                                <div class="d-flex flex-column justify-content-between lesson">
                                    <div class="group_lesson_heading">
                                        <h5 class="group_lesson_author">
                                            Rubeus Hagrid
                                        </h5>
                                        <span class="group_lesson_course_name">
                                            Standards Used In An Valuation
                                        </span>
                                    </div>
                                    <div class="group_participants_container">
                                        <h6 class="group_participants_heading">
                                            Participants
                                        </h6>
                                        <div class="group_participants_list">
                                            <div class="group_participant1">
                                                <img src="{{asset('asset/image/profile1.jpg')}}" alt="">
                                            </div>
                                            <div class="group_participant2">
                                                <img src="{{asset('asset/image/profile2.jpg')}}" alt="">
                                            </div>
                                            <div class="group_participant3">
                                                <img src="{{asset('asset/image/profile3.jpg')}}" alt="">
                                            </div>
                                            <div class="group_participant4">
                                                <img src="{{asset('asset/image/profile4.jpg')}}" alt="">    
                                            </div>
                                            <div class="group_participant5">
                                                <img src="{{asset('asset/image/profile5.jpg')}}" alt="">
                                            </div>
                                            <div class="group_participant_indicator">
                                                <span>12+</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="d-flex flex-row justify-content-between align-items-center group_lesson_footer">
                                        <span class="group_lesson_date">
                                            <i class="fa fa-calendar-o" aria-hidden="true"></i>
                                            10 Jun 2022
                                        </span>
                                        <span class="group_lesson_link">
                                            <a href="#" class="">
                                                Browse
                                                <i class="fa fa-chevron-right" aria-hidden="true"></i>
                                            </a>
                                        </span>
                                    </div>
                                </div>
                                <div class="d-flex flex-column justify-content-between lesson">
                                    <div class="group_lesson_heading">
                                        <h5 class="group_lesson_author">
                                            Rolanda Hooch
                                        </h5>
                                        <span class="group_lesson_course_name">
                                            Difference Between Valuers and Surveyors
                                        </span>
                                    </div>
                                    <div class="group_participants_container">
                                        <h6 class="group_participants_heading">
                                            Participants
                                        </h6>
                                        <div class="group_participants_list">
                                            <div class="group_participant1">
                                                <img src="{{asset('asset/image/profile1.jpg')}}" alt="">
                                            </div>
                                            <div class="group_participant2">
                                                <img src="{{asset('asset/image/profile2.jpg')}}" alt="">
                                            </div>
                                            <div class="group_participant3">
                                                <img src="{{asset('asset/image/profile3.jpg')}}" alt="">
                                            </div>
                                            <div class="group_participant4">
                                                <img src="{{asset('asset/image/profile4.jpg')}}" alt="">    
                                            </div>
                                            <div class="group_participant5">
                                                <img src="{{asset('asset/image/profile5.jpg')}}" alt="">
                                            </div>
                                            <div class="group_participant_indicator">
                                                <span>20+</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="d-flex flex-row justify-content-between align-items-center group_lesson_footer">
                                        <span class="group_lesson_date">
                                            <i class="fa fa-calendar-o" aria-hidden="true"></i>
                                            12 Jun 2022
                                        </span>
                                        <span class="group_lesson_link">
                                            <a href="#" class="">
                                                Browse
                                                <i class="fa fa-chevron-right" aria-hidden="true"></i>
                                            </a>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-sm-6 col-lg-5">
                        <div class="card recommended_courses_list">
                            <div class="card-header">
                                Recommended Courses
                            </div>
                            <div class="card-body">
                                <div class="d-flex flex-row justify-content-around recommended_courses">
                                    <img class="recommended_courses_poster" src="{{asset('asset/image/recommended-course1.jpg')}}" alt="Recommended Course">
                                    <div class="d-flex flex-column justify-content-between recommended_course_details">
                                        <div class="recommended_course_header">
                                            <h6 class="recommended_course_name">
                                                Valuation and Financial Analysis
                                            </h6>
                                            <span class="recommended_course_instructor">
                                                Colt Blue
                                            </span>
                                        </div>
                                        <div class="recommended_course_footer">
                                            <span class="recommended_course_time">
                                                4h 41m
                                            </span>
                                            <span class="recommended_course_divider">
                                                -
                                            </span>
                                            <span class="recommended_course_learners">
                                                1845 Students
                                            </span>                                        
                                        </div>
                                    </div>
                                </div>
                                <div class="d-flex flex-row justify-content-around recommended_courses">
                                    <img class="recommended_courses_poster" src="{{asset('asset/image/recommended-course2.jpg')}}" alt="Recommended Course">
                                    <div class="d-flex flex-column justify-content-between recommended_course_details">
                                        <div class="recommended_course_header">
                                            <h6 class="recommended_course_name">
                                                Advanced valuation and strategy
                                            </h6>
                                            <span class="recommended_course_instructor">
                                                Albus Dumbledore
                                            </span>
                                        </div>
                                        <div class="recommended_course_footer">
                                            <span class="recommended_course_time">
                                                2h 21m
                                            </span>
                                            <span class="recommended_course_divider">
                                                -
                                            </span>
                                            <span class="recommended_course_learners">
                                                2425 Students
                                            </span>                                        
                                        </div>
                                    </div>
                                </div>
                                <div class="d-flex flex-row justify-content-around recommended_courses">
                                    <img class="recommended_courses_poster" src="{{asset('asset/image/recommended-course3.jpg')}}" alt="Recommended Course">
                                    <div class="d-flex flex-column justify-content-between recommended_course_details">
                                        <div class="recommended_course_header">
                                            <h6 class="recommended_course_name">
                                                Bussiness Valuation Course
                                            </h6>
                                            <span class="recommended_course_instructor">
                                                Minerva McGonagall
                                            </span>
                                        </div>
                                        <div class="recommended_course_footer">
                                            <span class="recommended_course_time">
                                                3h 10m
                                            </span>
                                            <span class="recommended_course_divider">
                                                -
                                            </span>
                                            <span class="recommended_course_learners">
                                                3761 Students
                                            </span>                                        
                                        </div>
                                    </div>
                                </div>
                                <div class="d-flex flex-row justify-content-around recommended_courses">
                                    <img class="recommended_courses_poster" src="{{asset('asset/image/recommended-course4.jpg')}}" alt="Recommended Course">
                                    <div class="d-flex flex-column justify-content-between recommended_course_details">
                                        <div class="recommended_course_header">
                                            <h6 class="recommended_course_name">
                                                Discounted Cash Flow Modelling
                                            </h6>
                                            <span class="recommended_course_instructor">
                                                Severus Snape
                                            </span>
                                        </div>
                                        <div class="recommended_course_footer">
                                            <span class="recommended_course_time">
                                                2h 09m
                                            </span>
                                            <span class="recommended_course_divider">
                                                -
                                            </span>
                                            <span class="recommended_course_learners">
                                                4625 Students
                                            </span>                                        
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-sm-6 col-lg-4">
                        <div class="card notice_board_list">
                            <div class="card-header">
                                Notice Board
                            </div>
                            <div class="card-body">
                                <div class="d-flex flex-row justify-content-around notice_board">
                                    <img class="notice_board_poster" src="{{asset('asset/image/notice-board1.jpg')}}" alt="Recommended Course">
                                    <div class="d-flex flex-column justify-content-around notice_board_heading">
                                        <h6 class="notice_board_event_name">
                                            Weekly Critique Challenge
                                        </h6>
                                        <span class="notice_board_event_organiser">
                                            mlhud staff 1
                                        </span>
                                    </div>
                                </div>
                                <div class="d-flex flex-row justify-content-around notice_board">
                                    <img class="notice_board_poster" src="{{asset('asset/image/notice-board2.jpg')}}" alt="Recommended Course">
                                    <div class="d-flex flex-column justify-content-around notice_board_heading">
                                        <h6 class="notice_board_event_name">
                                            New Announcement
                                        </h6>
                                        <span class="notice_board_event_organiser">
                                            mlhud staff 2
                                        </span>
                                    </div>
                                </div>
                                <div class="d-flex flex-row justify-content-around notice_board">
                                    <img class="notice_board_poster" src="{{asset('asset/image/notice-board3.jpg')}}" alt="Recommended Course">
                                    <div class="d-flex flex-column justify-content-around notice_board_heading">
                                        <h6 class="notice_board_event_name">
                                            New Course Launched
                                        </h6>
                                        <span class="notice_board_event_organiser">
                                            mlhud staff 3
                                        </span>
                                    </div>
                                </div>
                                <div class="d-flex flex-row justify-content-around notice_board">
                                    <img class="notice_board_poster" src="{{asset('asset/image/notice-board4.jpg')}}" alt="Recommended Course">
                                    <div class="d-flex flex-column justify-content-around notice_board_heading">
                                        <h6 class="notice_board_event_name">
                                            Assessments Added
                                        </h6>
                                        <span class="notice_board_event_organiser">
                                            mlhud staff 4
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
<!-- Vertically centered modal -->
    <div class="modal fade" id="event_poster_modal" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="staticBackdropLabel">Modal title</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            ...
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="button" class="btn btn-primary">Understood</button>
        </div>
        </div>
    </div>
    </div>

<!-- <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script>
    google.charts.load("current", {packages:["corechart"]});
      google.charts.setOnLoadCallback(drawChart);
      function drawChart() {
        var data = google.visualization.arrayToDataTable([
          ['Course', 'Percentege'],
          ['Completed', 80],
          ['Pending', 20],
          
        ]);

        var options = {
          title: 'Course1',
          pieHole: 0.5,
          pieStartAngle: -45,
          chartArea:{
                    left:15,
                    right:15,
                    top:40,
                    bottom:20,
                    width:'50%',
                    height:'75%'
                }
        };

        var chart = new google.visualization.PieChart(document.getElementById('donutchart'));
        chart.draw(data, options);
      }
</script> -->
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
      google.charts.load('current', {'packages':['line']});
      google.charts.setOnLoadCallback(drawChart);

    function drawChart() {

      var data = new google.visualization.DataTable();
      data.addColumn('number', 'Day');
      data.addColumn('number', 'Equity Research Course');
      data.addColumn('number', 'Finance of mergers and Acquistions');
      data.addColumn('number', 'Stock Valuation Analysis');

      data.addRows([
        [1,  37.8, 80.8, 41.8],
        [2,  30.9, 69.5, 32.4],
        [3,  25.4,   57, 25.7],
        [4,  11.7, 18.8, 10.5],
        [5,  11.9, 17.6, 10.4],
        [6,   8.8, 13.6,  7.7],
        [7,   7.6, 12.3,  9.6],
        [8,  12.3, 29.2, 10.6],
        [9,  16.9, 42.9, 14.8],
        [10, 12.8, 30.9, 11.6],
        [11,  5.3,  7.9,  4.7],
        [12,  6.6,  8.4,  5.2],
        [13,  4.8,  6.3,  3.6],
        [14,  4.2,  6.2,  3.4]
      ]);

      var options = {
        chart: {
        //   title: 'Box Office Earnings in First Two Weeks of Opening',
        //   subtitle: 'in millions of dollars (USD)'
            
        },
        width:'100%',
        height:250,
        chartArea:{
                    left:15,
                    right:15,
                    top:0,
                    bottom:0,
                    width:'100%',
                    height:250,
                },
        axes: {
          x: {
            0: {side: 'top'}
          }
        }
      };

      var chart = new google.charts.Line(document.getElementById('line_top_x'));

      chart.draw(data, google.charts.Line.convertOptions(options));
    }
  </script>
@endsection