@extends('layouts.adminnav')

@section('content')
<style>
   /* ==========================================
   MOBILE ACCORDION VIEW
   SAME AS PROFESSIONAL LIST SCREEN
========================================== */
@media (max-width:768px){

    .main-content,
    .card,
    .card-body,
    .table-wrapper,
    .table-responsive{
        padding-left:0 !important;
        padding-right:0 !important;
        margin-left:0 !important;
        margin-right:0 !important;
    }

    .row,
    .col-12,
    .col-lg-12{
        padding-left:5px !important;
        padding-right:5px !important;
    }

    .table-responsive{
        overflow-x:hidden !important;
        overflow-y:auto !important;
        max-height:80vh;
    }

    .table-responsive table{
        font-size:12px;
        min-width:100% !important;
        width:100% !important;
    }

    .table-responsive table,
    .table-responsive thead,
    .table-responsive tbody,
    .table-responsive th,
    .table-responsive td{
        display:block !important;
        width:100% !important;
    }

    .table-responsive thead{
        display:none !important;
    }

    .table-responsive tbody{
        background:transparent !important;
    }

    #align{
        width:100% !important;
        margin:0 !important;
    }

    /* CARD STYLE */
    #align tr{
        display:flex !important;
        flex-direction:column !important;
        align-items:stretch !important;
        border:1px solid #e0e0e0 !important;
        border-radius:8px !important;
        margin:8px 5px !important;
        position:relative !important;
        padding:10px 15px 10px 45px !important;
        background:#fff !important;
        box-shadow:0 1px 4px rgba(0,0,0,0.05) !important;
        cursor:pointer;
        width:calc(100% - 10px) !important;
    }

    #align td{
        display:block !important;
        border:none !important;
        padding:0 !important;
        text-align:left !important;
        white-space:normal !important;
        width:100% !important;
        background:transparent !important;
        height:auto !important;
        min-height:0 !important;
        line-height:1.3 !important;
    }

    /* S.NO */
    #align td:nth-of-type(1){
        position:absolute !important;
        left:15px !important;
        top:50% !important;
        transform:translateY(-50%) !important;
        width:25px !important;
        display:flex !important;
        font-weight:bold !important;
        font-size:13px !important;
        color:#2c3e50 !important;
    }

    #align tr.expanded-row td:nth-of-type(1){
        top:20px !important;
        transform:translateY(0) !important;
    }

    /* SCHOOL NAME */
    #align td:nth-of-type(2){
        display:block !important;
        font-weight:600 !important;
        font-size:16px !important;
        color:#2c3e50 !important;
        margin-bottom:4px !important;
        padding-right:25px !important;
        order:1 !important;
    }

    /* ENROLLMENT NUMBER */
    #align td:nth-of-type(3){
        display:block !important;
        font-size:12px !important;
        color:#7f8c8d !important;
        order:2 !important;
    }

    /* HIDE REMAINING FIELDS */
    #align td:nth-of-type(4),
    #align td:nth-of-type(5),
    #align td:nth-of-type(6),
    #align td:nth-of-type(7){
        display:none !important;
    }

    /* ARROW */
    #align tr::after{
        content:'\f054';
        font-family:'FontAwesome';
        position:absolute;
        right:15px;
        top:50%;
        transform:translateY(-50%);
        color:#bdc3c7;
        transition:transform .3s;
        font-size:12px;
    }

    #align tr.expanded-row::after{
        transform:translateY(-50%) rotate(90deg);
        top:35px;
    }

    /* DISTRICT */
    #align tr.expanded-row td:nth-of-type(4){
        display:block !important;
        margin-top:8px !important;
        font-size:12px !important;
        color:#34495e !important;
        order:3 !important;
    }

    #align tr.expanded-row td:nth-of-type(4):before{
        content:"District: ";
        font-weight:600 !important;
        color:#000 !important;
    }

    /* ADMIN NUMBER */
    #align tr.expanded-row td:nth-of-type(5){
        display:block !important;
        margin-top:6px !important;
        font-size:12px !important;
        color:#34495e !important;
        order:4 !important;
    }

    #align tr.expanded-row td:nth-of-type(5):before{
        content:"Administration Number: ";
        font-weight:600 !important;
        color:#000 !important;
    }

    /* STATUS */
    #align tr.expanded-row td:nth-of-type(6){
        display:block !important;
        margin-top:6px !important;
        font-size:12px !important;
        color:#34495e !important;
        order:5 !important;
    }

    #align tr.expanded-row td:nth-of-type(6):before{
        content:"Status: ";
        font-weight:600 !important;
        color:#000 !important;
    }

    /* ACTION */
    #align tr.expanded-row td:nth-of-type(7){
        display:flex !important;
        align-items:center !important;
        gap:10px !important;
        margin-top:8px !important;
        order:6 !important;
    }

    #align tr.expanded-row td:nth-of-type(7):before{
        content:"Action: ";
        font-weight:600 !important;
        color:#000 !important;
    }

    #align tr.expanded-row td:nth-of-type(7) a{
        display:inline-flex !important;
        align-items:center !important;
        font-size:15px !important;
        margin-right:8px !important;
    }

    /* DATATABLE FIXES */
    .dataTables_wrapper .row:first-child{
        margin:0 !important;
        display:flex !important;
        justify-content:space-between !important;
        align-items:center !important;
        width:100% !important;
    }

    .dataTables_wrapper .row:first-child > div{
        flex:0 0 auto !important;
        width:auto !important;
        max-width:50% !important;
    }

    .dataTables_wrapper .dataTables_length{
        float:left !important;
        margin-left:8px !important;
    }

    .dataTables_wrapper .dataTables_filter{
        float:right !important;
        margin-right:8px !important;
    }

    .dataTables_wrapper .dataTables_length,
    .dataTables_wrapper .dataTables_filter,
    .dataTables_wrapper .dataTables_info,
    .dataTables_wrapper .dataTables_paginate{
        font-size:10px !important;
    }

    .dataTables_wrapper .dataTables_length select{
        font-size:11px !important;
        height:32px !important;
        width:60px !important;
    }

    .dataTables_wrapper .dataTables_filter input{
        width:90px !important;
        height:24px !important;
        font-size:10px !important;
    }
}
</style>
    <div class="main-content">
        <div class="row">
            <div class="col-12">
                {{ Breadcrumbs::render('enrollement.schoollist') }}
                <div class="card">
                    <div class="card-body">
                        <div class="col-lg-12 text-center" style="padding: 10px;">
                            <h4 style="color:darkblue;">School Enrollment Detail</h4>
                        </div>
                        <div class="table-wrapper">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="align">
                                    <thead>
                                        <tr>
                                            <th>S.No</th>
                                            <th>School Name</th>
                                            <th>Enrollment number</th>
                                            <th class='col-2'>District</th>
                                            <th class='col-2'>Administration Number</th>
                                            <th>status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($rows as $key => $row)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $row['school_name']}}</td>
                                                <td>{{ $row['school_enrollment_num']}}</td>
                                                <td>{{ $row['school_district']}}</td>
                                                <td>{{ $row['admin_contract']}}</td>
                                                <td>{{ $row['status']}}</td>
                                                <td>
                                                    <a class="btn btn-link" title="Show"
                                                        href="{{ route('enrollement.schoolshow', \Crypt::encrypt($row['school_enrollment_id'])) }}"><i
                                                            class="fas fa-eye" style="color:green"></i></a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<style>
    /* Improved Action Buttons in Mobile View */
    @media (max-width: 768px) {
        #align tr.expanded-row td a.btn, #align tr.expanded-row td a.btn-link, #align tr.expanded-row td a[title], .table-responsive tr.expanded-row td a.btn, .table-responsive tr.expanded-row td a.btn-link, .table-responsive tr.expanded-row td button, #align1 tr.expanded-row td a.btn-link, #align1 tr.expanded-row td a.btn {
            padding: 6px 14px !important;
            background: #f8f9fa !important;
            border: 1px solid #ddd !important;
            border-radius: 6px !important;
            display: inline-block !important;
            margin-right: 6px !important;
            box-shadow: 0 1px 2px rgba(0,0,0,0.05) !important;
            font-size: 14px !important;
        }
    }
</style>
<script>
    $(document).ready(function() {
        // Mobile row expansion logic
        $(document).on('click', '.table-responsive tr, #align tbody tr, #align1 tbody tr', function() {
            if($(window).width() <= 768) {
                if ($(this).hasClass('expanded-row')) {
                    $(this).removeClass('expanded-row');
                } else {
                    $(this).siblings('tr').removeClass('expanded-row');
                    $(this).addClass('expanded-row');
                }
            }
        });

        // Prevent action button click from collapsing row
        $(document).on('click', '.table-responsive td a.btn, .table-responsive td a.btn-link, .table-responsive td a[title], .table-responsive td button, #align tbody tr td:last-child a, #align1 tbody tr td:last-child a', function(e) {
            if($(window).width() <= 768) {
                e.stopPropagation();
            }
        });

        // Mobile back button logic
        if($(window).width() <= 768) {
            var breadcrumbItems = $('.breadcrumb li');
            if (breadcrumbItems.length === 1 || (breadcrumbItems.length === 2 && breadcrumbItems.last().text().trim() === '')) {
                // Single breadcrumb
                var title = breadcrumbItems.first().text().trim();
                $('.breadcrumb').replaceWith('<a href="javascript:history.back()" class="btn btn-secondary back-btn" style="margin: 10px 15px; font-size: 11px; padding: 4px 8px; border-radius: 4px;"><i class="fa fa-arrow-left" style="margin-right: 5px;"></i> Back</a>');
            } else if (breadcrumbItems.length > 1) {
                // Parent-Child breadcrumb
                $('<div style="padding: 10px 15px 0 15px;"><a href="/home" class="btn btn-secondary back-btn" style="font-size: 11px; padding: 4px 8px; border-radius: 4px;"><i class="fa fa-arrow-left" style="margin-right: 5px;"></i> Dashboard</a></div>').insertBefore('.breadcrumb');
            }
        }
        
     
    });
</script>


@endsection
