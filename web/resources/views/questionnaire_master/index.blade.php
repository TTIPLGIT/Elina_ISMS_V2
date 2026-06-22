@extends('layouts.adminnav')

@section('content')
<style>
/* ============================================================
   MOBILE ACCORDION – tweaked for better fit
   ============================================================ */
@media (max-width: 768px) {

    /* Reset paddings */
    .main-content,
    .card,
    .card-body,
    .table-wrapper,
    .table-responsive {
        padding-left: 0 !important;
        padding-right: 0 !important;
        margin-left: 0 !important;
        margin-right: 0 !important;
    }
    .row, .col-12, .col-lg-12 {
        padding-left: 5px !important;
        padding-right: 5px !important;
    }
    .main-content { padding-top: 0 !important; }
    .breadcrumb {
        font-size: 11px !important;
        margin: 60px 10px 10px 10px !important;
    }
    .card { margin-top: 0 !important; }

    .table-responsive {
        overflow-x: hidden !important;
        max-height: none !important;
    }

    /* --- Hide table header on mobile --- */
    #align1 thead {
        display: none !important;
    }

    /* --- Each row becomes a card --- */
    #align1 tbody tr {
        display: flex !important;
        flex-direction: column !important;
        align-items: stretch !important;
        border: 1px solid #e0e0e0 !important;
        border-radius: 8px !important;
        margin: 6px 5px !important;
        padding: 10px 30px 10px 35px !important;  /* reduced padding */
        background: #fff !important;
        box-shadow: 0 1px 4px rgba(0,0,0,0.05) !important;
        cursor: pointer !important;
        position: relative !important;
        width: calc(100% - 10px) !important;
        transition: background 0.2s;
        word-break: break-word;  /* prevent overflow */
    }
    #align1 tbody tr:active { background: #f5f9ff; }

    /* --- Each cell becomes a block --- */
    #align1 tbody td {
        display: block !important;
        border: none !important;
        padding: 2px 0 !important;
        text-align: left !important;
        white-space: normal !important;
        width: 100% !important;
        background: transparent !important;
        line-height: 1.3 !important;
        font-size: 12.5px !important;  /* slightly smaller */
        color: #34495e !important;
    }

    /* ---- Sl.No – left side badge (smaller) ---- */
    #align1 tbody td:first-child {
        position: absolute !important;
        left: 10px !important;
        top: 50% !important;
        transform: translateY(-50%) !important;
        width: auto !important;
        font-weight: 700 !important;
        font-size: 13px !important;  /* reduced */
        color: #2c3e50 !important;
        padding: 0 !important;
        background: transparent !important;
    }
    /* When expanded, move badge to top-left */
    #align1 tbody tr.expanded-row td:first-child {
        top: 12px !important;
        transform: none !important;
    }

    /* ---- Questionnaire Name – always visible, bold, smaller ---- */
    #align1 tbody td:nth-child(2) {
        font-weight: 600 !important;
        font-size: 14px !important;  /* was 16px */
        color: #2c3e50 !important;
        margin-bottom: 2px !important;
        order: 1 !important;
        padding-right: 5px !important;
        word-break: break-word;
    }

    /* ---- Type & Action – hidden by default ---- */
    #align1 tbody td:nth-child(3),
    #align1 tbody td:nth-child(4) {
        display: none !important;
    }

    /* ---- Expanded row shows Type ---- */
    #align1 tbody tr.expanded-row td:nth-child(3) {
        display: block !important;
        margin-top: 4px !important;
        order: 2 !important;
        font-size: 12px !important;
    }
    #align1 tbody tr.expanded-row td:nth-child(3)::before {
        content: "Type: ";
        font-weight: 600 !important;
        color: #000 !important;
    }

    /* ---- Expanded row shows Action (icons smaller) ---- */
    #align1 tbody tr.expanded-row td:nth-child(4) {
        display: flex !important;
        align-items: center !important;
        flex-wrap: nowrap !important;
        gap: 2px !important;
        margin-top: 4px !important;
        order: 3 !important;
        white-space: nowrap !important;
        overflow-x: auto;
        font-size: 12px !important;
    }
    #align1 tbody tr.expanded-row td:nth-child(4)::before {
        content: "Action:";
        font-weight: 600 !important;
        color: #000 !important;
        margin-right: 4px !important;
        flex-shrink: 0 !important;
        font-size: 12px !important;
    }
    #align1 tbody tr.expanded-row td:nth-child(4) a {
        display: inline-flex !important;
        align-items: center !important;
        justify-content: center !important;
        padding: 0 3px !important;
        font-size: 12px !important;  /* smaller icons */
        margin: 0 !important;
    }
    #align1 tbody tr.expanded-row td:nth-child(4) a i {
        font-size: 13px !important;  /* adjust icon size */
    }

    /* ---- Right‑side arrow (adjusted position) ---- */
    #align1 tbody tr::after {
        content: '\f054';
        font-family: 'FontAwesome';
        position: absolute;
        right: 10px;
        top: 50%;
        transform: translateY(-50%);
        color: #bdc3c7;
        font-size: 13px;
        transition: transform 0.25s ease;
    }
    #align1 tbody tr.expanded-row::after {
        transform: translateY(-50%) rotate(90deg);
    }

    /* ---- Empty row (no data) ---- */
    #align1 tbody tr:has(td.dataTables_empty) {
        display: table-row !important;
        border: none !important;
        box-shadow: none !important;
        padding: 0 !important;
        background: transparent !important;
        cursor: default !important;
    }
    #align1 tbody tr:has(td.dataTables_empty) td {
        display: table-cell !important;
        text-align: center !important;
        padding: 20px !important;
        font-size: 13px !important;
        color: #666 !important;
    }
    #align1 tbody tr:has(td.dataTables_empty)::after { display: none !important; }

    /* ---- DataTable controls (if used) ---- */
    .dataTables_wrapper .row:first-child { margin: 0 !important; }
    .dataTables_wrapper .dataTables_length { float: left !important; margin-left: 8px !important; }
    .dataTables_wrapper .dataTables_filter { float: right !important; padding-right: 8px !important; }
    .dataTables_wrapper .dataTables_length,
    .dataTables_wrapper .dataTables_filter,
    .dataTables_wrapper .dataTables_info,
    .dataTables_wrapper .dataTables_paginate {
        font-size: 10px !important;
    }
    .dataTables_wrapper .dataTables_length select {
        font-size: 11px !important;
        height: 32px !important;
        width: 60px !important;
    }
    .dataTables_wrapper .dataTables_filter input {
        width: 90px !important;
        height: 24px !important;
        font-size: 10px !important;
    }
    .card-body h4 { font-size: 18px !important; }
}
</style>

<div class="main-content">
    {{ Breadcrumbs::render('questionnaire_master.index') }}
    <div class="row">
        <div class="col-12">
            <a type="button" href="{{ route('questionnaire_master.create') }}" value="Cancel" class="btn btn-labeled btn-info" title="create" style="background: #044a95 !important; border-color:#a9ca !important; color:white !important;margin-top: 0.5rem;">
                <span class="btn-label" style="font-size:15px !important; padding:8px !important"><i class="fa fa-plus"></i></span><span style="font-size:15px !important; padding:8px !important">Create Questionnaire</span></a>
            <div class="card mt-3">
                <div class="card-body">
                    <div class="table-wrapper">
                        <div class="table-responsive">
                            <table class="table table-bordered" id="align1">
                                <thead>
                                    <tr>
                                        <th>Sl.No</th>
                                        <th>Questionnaire Name</th>
                                        <th>Questionnaire Type</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($rows as $data)
                                    <tr>
                                        <td>{{$loop->iteration}}</td>
                                        <td>{{$data['questionnaire_name']}}</td>
                                        <td>{{$data['questionnaire_type']}}</td>
                                        <td>
                                            <a class="btn btn-link" title="Edit" href="{{ route('questionnaire_master.edit', \Crypt::encrypt($data['questionnaire_id'])) }}"><i class="fas fa-pencil-alt" style="color: blue !important"></i></a>
                                            @csrf
                                            <a href="javascript:void(0)"
                                                class="btn btn-link"
                                                title="Delete"
                                                onclick="confirmDelete('{{ route('questionnaire_master.delete', Crypt::encrypt($data['questionnaire_id'])) }}')">
                                                <i class="fas fa-trash-alt" style="color:red !important"></i>
                                            </a>
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

<script src="https://code.jquery.com/jquery-1.7.2.min.js"></script>

<script>
    // ============================================================
    // MOBILE ACCORDION – click row to expand (like OVM-1)
    // ============================================================
    $(document).ready(function() {
        $('#align1 tbody').on('click', 'tr', function(e) {
            // Ignore clicks on action links/buttons
            if ($(e.target).closest('a, button, input, form').length) {
                return;
            }
            // Only on mobile (≤ 768px)
            if ($(window).width() <= 768) {
                // Close any other open row (single-expand)
                $(this).siblings().removeClass('expanded-row');
                $(this).toggleClass('expanded-row');
            }
        });
    });

    // ============================================================
    // DELETE CONFIRMATION
    // ============================================================
    function confirmDelete(url) {
        Swal.fire({
            title: 'Are you sure?',
            text: "Do you really want to delete this questionnaire?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Yes, Delete',
            cancelButtonText: 'No, Cancel'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = url;
            }
        });
    }
</script>

@if(session('success'))
<script>
    Swal.fire({
        icon: 'success',
        title: 'Success',
        text: "{{ session('success') }}",
        timer: 2000,
        confirmButtonText: 'OK',
        allowOutsideClick: false
    });
</script>
@endif

@if(session('fail'))
<script>
    Swal.fire({
        icon: 'error',
        title: 'Error',
        text: "{{ session('fail') }}",
        confirmButtonText: 'OK',
        allowOutsideClick: false
    });
</script>
@endif

@endsection