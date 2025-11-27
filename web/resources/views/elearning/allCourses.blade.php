@extends('layouts.elearningmain')

@section('content')
<style>
    /* main-container */
    .all_courses_main_header{
        width: fit-content;
        color: #0006cc;
        font-weight: 900;
        font-size: 1.5rem !important;
        margin-bottom: 1rem !important;
    }
    /* filters mobile */
    .filters_header{
        background: #eee !important;
        color: #000 !important;
    }
    /* sort and filter header*/
    .all_courses_sort_header, 
    .all_courses_filter_header{
        display: none !important;
    }
    /* sort and filter options */
    .form-control{
        background-color: #fdfdff !important;
        box-shadow: none !important;
        border: 1px solid #000 !important;
        border-radius: 0px !important;
    }
    .all_courses_sort_select{
        font-weight: 800;
        width: 20%;
        border: 1px solid #000 !important;
        border-radius: 0px !important;
        margin-bottom: 1rem;
    }
    .all_courses_filter_container{
        font-weight: 800;
        width: 45%;
        margin-left: 2%;
        margin-bottom: 1rem;
        border-radius: 0px !important;
    }
    .all_courses_filter_select{
        font-weight: 800;
        width: 40%;
        margin-right: 2%;
        border: 1px solid #000 !important;
        border-radius: 0px !important;    
    }
    .all_courses_reset_btn{
        width: fit-content;
        text-align: left;
        color: #1c1d1f !important;
        border: 0px !important;
        padding: 0px 0px !important;
        background-color: transparent !important;
    }
    /* search section */
    .all_courses_search_container{
        font-weight: 800;
        width: 25%;
        margin-left: auto;
        margin-bottom: 1rem;
        border-radius: 0px !important;
    }
    .all_courses_search_container button{
        color: #fff !important;
        background-color: #000 !important;
        border: 1px solid #000;
        border-left: 0px !important;
        width: 3rem;
        height: 41px;
        font-size: 1.2rem;
    }

    /* Course list section */
    .all_courses_courselist_container{
        margin-top: 1rem !important;
    }
    .all_courses_courselist{
        margin: 0px !important;
        margin-bottom: 2rem !important;
        border: 0px !important;
        box-shadow: none !important;
    }
    .all_courses_courselist .card-header{
        overflow: hidden !important;
        padding: 0px !important;
        height: 8rem !important;
    }
    .all_courses_courselist .card-body{
        padding: 0px !important;
    }
    .all_courses_courselist .card-title h5{
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
    .all_courses_paginate_container{
        margin-top: 2rem;
    }
    .all_courses_paginate{
        margin-bottom: 0px !important;
    }
    .all_courses_pagination_page_number .page-link{
        color: #141ad8 !important;
        background-color: transparent !important;
        border: 0px solid #000 !important;
    }
    .all_courses_pagination_page_number .page-link.active{
        text-decoration: 2.2px underline #000;
    }
    .all_courses_pagination_nav .page-link{
        color: #000 !important;
        background-color: transparent !important;
        border: 1px solid #000 !important;
        border-radius: 50%;
    }
    @media (min-width:319.96px) {
        /* .all_courses_sort_select{
            width: 100%;
        } */
        .all_courses_filters_popper{
            margin-bottom: 1rem !important;
            font-size: 1rem;
            font-weight: 700;
            background-color: #fff;
            padding: 0.5% 3%;
            color: #000;
            border: 0px !important;
            border-radius: 10px;
            box-shadow: 0.1rem 0.1rem 0.2rem #6c757d;
        }
        .all_courses_filters_popper i{
            font-size: 0.75rem;
            vertical-align: middle;
            color: #41464b;
            font-weight: 700;
        }
        .all_courses_filter_block2{
            display: none !important;
        }
    }

    @media (min-width:767.96px) {
        .all_courses_sort_header{
            display: inline-block !important;
            width: 20%;
            color: #1c1d1f !important;
            margin-bottom: 0.75rem;
            text-align: left;
        }
        .all_courses_filter_header{
            display: inline-block !important;
            width: 20%;
            color: #1c1d1f !important;
            margin-left: 2%;
            margin-bottom: 0.75rem;
            text-align: left;
        }
        .all_courses_filters_popper{
            display: none !important;
        }
        .all_courses_filter_block2{
            display: flex !important;
        }
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

            <div class="container-fluid all_courses_container">
                
                <div class="d-flex flex-row justify-content-between align-items-end">
                    <h2 class="all_courses_main_header">
                        All Courses
                    </h2>
                    <a class="text-uppercase all_courses_filters_popper" href="#" data-toggle="modal" data-target="#filters">
                        filters
                        <i class="fa fa-plus" aria-hidden="true"></i>
                    </a>
                </div>

                <div class="d-flex flex-row justify-content-start">
                    <span class="all_courses_sort_header">
                        Sort by
                    </span>
                    <span class="all_courses_filter_header">
                        Filter by
                    </span>
                </div>

                <div class="d-flex flex-row flex-wrap justify-content-start all_courses_filter_block2">
                    <select class="form-control all_courses_sort_select" name="all_courses_sort_select">
                        <option value="Recently Accessed" selected>Recently Accessed</option>
                        <option value="Recently Enrolled">Recently Enrolled</option>
                        <option value="A to Z">A to Z</option>
                        <option value="Z to A">Z to A</option>
                    </select>
                    <div class="d-flex flex-row flex-wrap justify-content-evenly all_courses_filter_container">
                        <select class="form-control all_courses_filter_select" name="all_courses_filter_select">
                            <option selected>Category</option>
                            <option value="Survey and Mapping">Survey and Mapping</option>
                            <option value="Land Registration">Land Registration</option>
                            <option value="Land Administration">Land Administration</option>
                            <option value="Valuation">Valuation</option>
                        </select>
                        <select class="form-control all_courses_filter_select" name="all_courses_filter_select">
                            <option selected>Progress</option>
                            <option value="In Progress">In Progress</option>
                            <option value="Completed">Completed</option>
                            <option value="Not Enrolled">Not Enrolled</option>
                        </select>
                        <button class="all_courses_reset_btn" type="button" disabled>
                            <span>Reset</span>
                        </button>
                    </div>
                    <div class="all_courses_search_container">
                        <form class="d-flex flex-row justify-content-center align-items-center" action="#" method="get">
                            <input type="search" class="form-control" placeholder="Search">
                            <button type="submit">
                                <i class="fa fa-search" aria-hidden="true"></i>
                            </button>
                        </form>
                    </div>
                </div>

            </div>

            <div class="container-fluid all_courses_courselist_container">
                <div class="row">
                    <div class="col-12 col-sm-6 col-lg-4 col-xl-3">
                        <div class="card all_courses_courselist">
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
                                <div class="progress course_total_progress">
                                    <div class="progress-bar" role="progressbar" style="width: 25%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                                <span class="text-uppercase">25% completed</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-sm-6 col-lg-4 col-xl-3">
                        <div class="card all_courses_courselist">
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
                                <span class="text-uppercase">start course</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-sm-6 col-lg-4 col-xl-3">
                        <div class="card all_courses_courselist">
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
                                    <div class="progress-bar" role="progressbar" style="width: 20%" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                                <span class="text-uppercase">20% completed</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-sm-6 col-lg-4 col-xl-3">
                        <div class="card all_courses_courselist">
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
                                    <div class="progress-bar" role="progressbar" style="width: 45%" aria-valuenow="45" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                                <span class="text-uppercase">45% completed</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-sm-6 col-lg-4 col-xl-3">
                        <div class="card all_courses_courselist">
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
                                <span class="text-uppercase">start completed</span>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-12 col-sm-6 col-lg-4 col-xl-3">
                        <div class="card all_courses_courselist">
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
                                    <div class="progress-bar" role="progressbar" style="width: 80%" aria-valuenow="80" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                                <span class="text-uppercase">80% completed</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="container-fluid d-flex flex-row justify-content-center all_courses_paginate_container">
                <ul class="pagination all_courses_paginate">
                    <li class="all_courses_pagination_nav" id="all_courses_pagination_previous">
                        <a href="#" aria-controls="all_courses" data-dt-idx="0" tabindex="0" class="page-link">
                            <i class="fa fa-chevron-left" aria-hidden="true"></i>
                        </a>
                    </li>
                    <li class="all_courses_pagination_page_number">
                        <a href="#" aria-controls="all_courses" data-dt-idx="1" tabindex="0" class="page-link active">
                            1
                        </a>
                    </li>
                    <li class="all_courses_pagination_page_number">
                        <a href="#" aria-controls="all_courses" data-dt-idx="1" tabindex="0" class="page-link">
                            2
                        </a>
                    </li>
                    <li class="all_courses_pagination_nav" id="all_courses_pagination__next">
                        <a href="#" aria-controls="all_courses" data-dt-idx="2" tabindex="0" class="page-link">
                            <i class="fa fa-chevron-right" aria-hidden="true"></i>
                        </a>
                    </li>
                </ul>
            </div>
            
            <div class="container-fluid d-flex flex-row justify-content-center all_courses_info_container">
                <div class="all_courses_info">
                    1 to 6 of 6 Courses
                </div>
            </div>
                    
        </div>
    </section>
</div>

<!-- Filters Modal -->
<div class="modal fade" id="filters" tabindex="-1" aria-labelledby="filtersLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content modal_filters">
            <div class="modal-header filters_header">
                <h5 class="modal-title" id="filtersLabel">Filters</h5>
                <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-3 filters_body">
                <div class="d-flex flex-row flex-wrap justify-content-between all_courses_filter_container w-100 m-0">
                    <select class="form-control all_courses_sort_select w-50 mb-3" name="all_courses_sort_select">
                        <option value="Recently Accessed" selected>Recently Accessed</option>
                        <option value="Recently Enrolled">Recently Enrolled</option>
                        <option value="A to Z">A to Z</option>
                        <option value="Z to A">Z to A</option>
                    </select>
                    <select class="form-control all_courses_filter_select m-0 mb-3" name="all_courses_filter_select">
                        <option selected>Category</option>
                        <option value="Survey and Mapping">Survey and Mapping</option>
                        <option value="Land Registration">Land Registration</option>
                        <option value="Land Administration">Land Administration</option>
                        <option value="Valuation">Valuation</option>
                    </select>
                    <select class="form-control all_courses_filter_select w-50 m-0 mb-3" name="all_courses_filter_select">
                        <option selected>Progress</option>
                        <option value="In Progress">In Progress</option>
                        <option value="Completed">Completed</option>
                        <option value="Not Enrolled">Not Enrolled</option>
                    </select>
                    <button class="all_courses_reset_btn mx-auto mb-3" type="button" disabled>
                        <span>Reset</span>
                    </button>
                    <div class="all_courses_search_container w-100">
                        <form class="d-flex flex-row justify-content-center align-items-center" action="#" method="get">
                            <input type="search" class="form-control" placeholder="Search">
                            <button type="submit">
                                <i class="fa fa-search" aria-hidden="true"></i>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection