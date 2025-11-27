                @extends('layouts.elearningmain')

@section('content')
<style>
    /* main header */
    .wishlist_main_header{
        width: fit-content;
        color: #0006cc;
        font-weight: 900;
        font-size: 1.5rem !important;
        margin-bottom: 1rem !important;
    }
    /* sort and filter options */
    .form-control{
        background-color: #fdfdff !important;
        box-shadow: none !important;
        border: 1px solid #000 !important;
        border-radius: 0px !important;
    }
    /* search section */
    .wishlist_search_container{
        font-weight: 800;
        padding: 0px 30px !important;
        margin-left: auto;
        margin-bottom: 1rem;
        border-radius: 0px !important;
    }
    .wishlist_search_container input{
        color: #000 !important;
        background-color: #fff !important;
        width: 100% !important;
        height: 41px;
        font-size: 1.2rem;
    }
    .wishlist_search_container button{
        color: #fff !important;
        background-color: #000 !important;
        border: 1px solid #000;
        border-left: 0px !important;
        width: 3rem;
        height: 41px;
        font-size: 1.2rem;
    }

    /* Course list section */
    .wishlist_courselist_container{
        margin-top: 1rem !important;
    }
    .wishlist_courselist{
        margin: 0px !important;
        margin-bottom: 2rem !important;
        border: 0px !important;
        box-shadow: none !important;
    }
    .wishlist_courselist .card-header{
        overflow: hidden !important;
        padding: 0px !important;
        height: 8rem !important;
    }
    .wishlist_courselist .card-body{
        padding: 0px !important;
    }
    .wishlist_courselist .card-title h5{
        color: #000;
        font-size: 1.3rem;
        line-height: 2rem;
        white-space: nowrap;
        width: 100%;
        overflow: hidden;
        text-overflow: ellipsis;
    }
    .course_image{
        width: 100%;
    }
    .course_total_progress{
        height: 0.25rem !important;
        box-shadow: none !important;
    }
    /* paginnation sectiion */
    .wishlist_paginate_container{
        margin-top: 2rem;
    }
    .wishlist_courses_paginate{
        margin-bottom: 0px !important;
    }
    .wishlist_pagination_page_number .page-link{
        color: #141ad8 !important;
        background-color: transparent !important;
        border: 0px solid #000 !important;
    }
    .wishlist_pagination_page_number .page-link.active{
        text-decoration: 2.2px underline #000;
    }
    .wishlist_pagination_nav .page-link{
        color: #000 !important;
        background-color: transparent !important;
        border: 1px solid #000 !important;
        border-radius: 50%;
    }

    /* courser price */
    .course_price{
        font-weight: 900;
        margin-right: 0.5rem;
    }
    .course_orginal_price{
        color: #6f6f6f;
        font-weight: 800;
        text-decoration: 1px line-through black;
    }
    @media (min-width:319.96px) {

    }
    @media (min-width:575.96px) {
    }

    @media (min-width:767.96px) {
    }
    @media (min-width:1024.96px) {
        .main-content{
            padding-left: 220px !important;
        }
        .sidebar-mini .main-content{
            padding-left: 85px !important;
        }
    }
</style>
<div class="main-content">
    <section class="section">
        <div class="section-body mt-1">

            <div class="container-fluid d-flex flex-column flex-sm-row justify-content-between align-items-center wishlist_search_container">
                <h2 class="wishlist_main_header">
                    Wishlist
                </h2>
                <form class="d-flex flex-row justify-content-end align-items-center" action="#" method="get">
                    <input type="search" class="form-control" placeholder="Search">
                    <button type="submit">
                        <i class="fa fa-search" aria-hidden="true"></i>
                    </button>
                </form>
            </div>

            <div class="container-fluid wishlist_courselist_container">
                <div class="row">
                    <div class="col-12 col-sm-6 col-lg-4 col-xl-3">
                        <div class="card wishlist_courselist">
                            <div class="card-header">
                                <img src="{{asset('asset/image/recommended-course1.jpg')}}" alt="" class="course_image">
                            </div>
                            <div class="card-body">
                                <div class="card-title">
                                    <h5>
                                        Valuation and Financial Analysis
                                    </h5>
                                </div>
                                <div class="card-text">
                                    <h6>Colt Blue</h6>
                                </div>
                                <div class="d-flex flex-row justify-content-start">
                                    <span class="course_rating">
                                        4.5
                                    </span>
                                    <span class="course_rating_list">
                                        <i class="fa fa-star-o" aria-hidden="true"></i>
                                        <i class="fa fa-star-o" aria-hidden="true"></i>
                                        <i class="fa fa-star-o" aria-hidden="true"></i>
                                        <i class="fa fa-star-o" aria-hidden="true"></i>
                                        <i class="fa fa-star-o" aria-hidden="true"></i>
                                    </span>
                                    <span class="course_rating_count">
                                        (10245)
                                    </span>
                                </div>
                                <div class="d-flex flex-row justify-content-start">
                                    <span class="course_total_hours">
                                        17 total hours
                                    </span>
                                    <span class="course_contents">
                                        130 content
                                    </span>
                                </div>
                                <div class="d-flex flex-row justify-content-start">
                                    <span class="course_price">
                                        455 Ush
                                    </span>
                                    <span class="course_orginal_price">
                                        3499 Ush
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-sm-6 col-lg-4 col-xl-3">
                        <div class="card wishlist_courselist">
                            <div class="card-header">
                                <img src="{{asset('asset/image/recommended-course2.jpg')}}" alt="" class="course_image">
                            </div>
                            <div class="card-body">
                                <div class="card-title">
                                    <h5>
                                    Advanced valuation and strategy
                                    </h5>
                                </div>
                                <div class="card-text">
                                    <h6>Albus Dumbledore</h6>
                                </div>
                                <div class="progress course_total_progress">
                                    <div class="progress-bar" role="progressbar" style="width: 0%" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                                <span class="text-uppercase">Enroll Now</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-sm-6 col-lg-4 col-xl-3">
                        <div class="card wishlist_courselist">
                            <div class="card-header">
                                <img src="{{asset('asset/image/recommended-course3.jpg')}}" alt="" class="course_image">
                            </div>
                            <div class="card-body">
                                <div class="card-title">
                                    <h5>
                                        Bussiness Valuation Course
                                    </h5>
                                </div>
                                <div class="card-text">
                                    <h6>Minerva McGonagall</h6>
                                </div>
                                <div class="progress course_total_progress">
                                    <div class="progress-bar" role="progressbar" style="width: 0%" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                                <span class="text-uppercase">Enroll Now</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-sm-6 col-lg-4 col-xl-3">
                        <div class="card wishlist_courselist">
                            <div class="card-header">
                                <img src="{{asset('asset/image/recommended-course4.jpg')}}" alt="" class="course_image">
                            </div>
                            <div class="card-body">
                                <div class="card-title">
                                    <h5>
                                        Discounted Cash Flow Modelling
                                    </h5>
                                </div>
                                <div class="card-text">
                                    <h6>Severus Snape</h6>
                                </div>
                                <div class="progress course_total_progress">
                                    <div class="progress-bar" role="progressbar" style="width: 0%" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                                <span class="text-uppercase">Enroll Now</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-sm-6 col-lg-4 col-xl-3">
                        <div class="card wishlist_courselist">
                            <div class="card-header">
                                <img src="{{asset('asset/image/notice-board2.jpg')}}" alt="" class="course_image">
                            </div>
                            <div class="card-body">
                                <div class="card-title">
                                    <h5>
                                        Critiques Involved in Valuation 
                                    </h5>
                                </div>
                                <div class="card-text">
                                    <h6>Coltee</h6>
                                </div>
                                <div class="progress course_total_progress">
                                    <div class="progress-bar" role="progressbar" style="width: 0%" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                                <span class="text-uppercase">Enroll Now</span>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-12 col-sm-6 col-lg-4 col-xl-3">
                        <div class="card wishlist_courselist">
                            <div class="card-header">
                                <img src="{{asset('asset/image/notice-board3.jpg')}}" alt="" class="course_image">
                            </div>
                            <div class="card-body">
                                <div class="card-title">
                                    <h5>
                                        Analysis of Surveys and Mapping
                                    </h5>
                                </div>
                                <div class="card-text">
                                    <h6>Hermione Granger</h6>
                                </div>
                                <div class="progress course_total_progress">
                                    <div class="progress-bar" role="progressbar" style="width: 0%" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                                <span class="text-uppercase">Enroll Now</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="container-fluid d-flex flex-row justify-content-center wishlist_paginate_container">
                <ul class="pagination wishlist_courses_paginate">
                    <li class="wishlist_pagination_nav" id="wishlist_pagination_previous">
                        <a href="#" aria-controls="all_courses" data-dt-idx="0" tabindex="0" class="page-link">
                            <i class="fa fa-chevron-left" aria-hidden="true"></i>
                        </a>
                    </li>
                    <li class="wishlist_pagination_page_number">
                        <a href="#" aria-controls="all_courses" data-dt-idx="1" tabindex="0" class="page-link active">
                            1
                        </a>
                    </li>
                    <li class="wishlist_pagination_page_number">
                        <a href="#" aria-controls="all_courses" data-dt-idx="1" tabindex="0" class="page-link">
                            2
                        </a>
                    </li>
                    <li class="wishlist_pagination_nav" id="wishlist_pagination_next">
                        <a href="#" aria-controls="all_courses" data-dt-idx="2" tabindex="0" class="page-link">
                            <i class="fa fa-chevron-right" aria-hidden="true"></i>
                        </a>
                    </li>
                </ul>
            </div>
            
            <div class="container-fluid d-flex flex-row justify-content-center wishlist_info_container">
                <div class="wishlist_info">
                    1 to 6 of 6 Courses
                </div>
            </div>
                    
        </div>
    </section>
</div>

@endsection