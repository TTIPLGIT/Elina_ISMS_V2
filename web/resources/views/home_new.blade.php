@extends('layouts.adminnav')
@section('content')
    @include('dashboard_css')
    <style>
        /* ----- Reduce column gutters in the top row ----- */
        .row.gutter-sm {
            margin-right: -5px;
            margin-left: -5px;
        }
        .row.gutter-sm > [class*="col-"] {
            padding-right: 5px;
            padding-left: 5px;
        }

        .borderBoard {
            border: 1px solid rgba(0, 0, 0, .125);
        }

        .table:not(.table-sm):not(.table-md):not(.dataTable) td,
        .table:not(.table-sm):not(.table-md):not(.dataTable) th {
            border: 1px solid black !important;
        }

        .badgeact {
            position: relative;
        }

        .badgeact::after {
            content: attr(data-badge);
            position: absolute;
            top: -3px;
            right: -8px;
            width: 10px;
            height: 10px;
            border-radius: 50%;
            background-color: #FF5151;
            color: white;
            font-size: 10px;
            text-align: center;
            line-height: 16px;
        }

        .table-responsive {
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
        }

        .table-responsive table {
            min-width: 750px;
            /* force scroll */
        }

        .table-responsive th,
        .table-responsive td {
            white-space: nowrap;
            vertical-align: middle;
        }

        /* Fix your sticky header issue */
        .fixTableHead {
            overflow: unset !important;
        }

        /* ================================================================
           TABLET & MOBILE (max-width: 1024px)
           ================================================================ */
        @media (max-width: 1024px) {
            .table-responsive {
                overflow-x: hidden !important;
                overflow-y: auto !important;
                max-height: 80vh; /* Ensure vertical scrolling if many rows */
            }
            .table-responsive table {
                font-size: 12px;
                min-width: 100% !important;
                width: 100% !important;
            }
            
            /* ---------- SEARCH TABLE (already existing) ---------- */
            .searchResultStudent table, 
            .searchResultStudent thead, 
            .searchResultStudent tbody, 
            .searchResultStudent th, 
            .searchResultStudent td { 
                display: block !important; 
                width: 100% !important;
            }
            
            .searchResultStudent thead { display: none !important; }
            .searchResultStudent tbody { background: transparent !important; }
            
            /* Use #align1b ID to guarantee max specificity */
            #align1b tr { 
                display: flex !important;
                flex-direction: column !important;
                align-items: stretch !important;
                border: 1px solid #e0e0e0 !important; 
                border-radius: 8px !important;
                margin-bottom: 8px !important;
                position: relative !important;
                padding: 10px 15px 10px 45px !important;
                background: #fff !important;
                box-shadow: 0 1px 4px rgba(0,0,0,0.05) !important;
                cursor: pointer;
                width: 100% !important;
            }
            
            #align1b td {
                display: block !important;
                border: none !important;
                padding: 0 !important;
                text-align: left !important;
                white-space: normal !important;
                width: 100% !important;
                background: transparent !important;
                height: auto !important;
                min-height: 0 !important;
                line-height: 1.2 !important;
            }
            
            #align1b td:nth-of-type(1) {
                position: absolute !important;
                left: 15px !important;
                top: 50% !important;
                transform: translateY(-50%) !important;
                width: 25px !important;
                background: transparent !important;
                display: flex !important;
                align-items: center !important;
                justify-content: flex-start !important;
                font-weight: bold !important;
                font-size: 1rem !important;
                color: #2c3e50 !important;
                transition: top 0.3s, transform 0.3s;
                margin: 0 !important;
            }
            
            #align1b tr.expanded-row td:nth-of-type(1) {
                top: 20px !important;
                transform: translateY(0) !important;
            }
            
            #align1b td:nth-of-type(3) {
                font-weight: bold !important;
                font-size: 1rem !important;
                color: #2c3e50 !important;
                margin-bottom: 2px !important;
                margin-top: 0 !important;
                padding-right: 25px !important;
                order: 1 !important;
                line-height: 1.2 !important;
            }
            
            #align1b td:nth-of-type(2) {
                font-size: 0.85rem !important;
                color: #34495e !important;
                margin-bottom: 0 !important;
                margin-top: 0 !important;
                order: 2 !important;
                line-height: 1.2 !important;
            }
            #align1b td:nth-of-type(2):before { content: "ID: "; font-weight: bold !important; color: #000 !important; }
            
            /* Hidden columns */
            #align1b td:nth-of-type(4) { order: 3 !important; display: none !important; }
            #align1b td:nth-of-type(5) { order: 4 !important; display: none !important; }
            #align1b td:nth-of-type(6) { order: 5 !important; display: none !important; }
            
            #align1b tr::after {
                content: '\f054';
                font-family: 'FontAwesome';
                position: absolute;
                right: 20px;
                top: 50%;
                transform: translateY(-50%);
                color: #bdc3c7;
                transition: transform 0.3s;
                font-size: 1rem;
            }
            
            #align1b tr.expanded-row::after {
                transform: translateY(-50%) rotate(90deg);
                top: 35px;
            }
            
            #align1b tr.expanded-row td:nth-of-type(4) {
                display: flex !important;
                align-items: center !important;
                margin-top: 8px !important;
                padding-top: 0 !important;
                border-top: none !important;
                font-size: 0.95rem !important;
                color: #34495e !important;
            }
            
            #align1b tr.expanded-row td:nth-of-type(5) {
                display: flex !important;
                align-items: center !important;
                margin-top: 4px !important;
                padding-top: 0 !important;
                border-top: none !important;
                font-size: 0.95rem !important;
                color: #34495e !important;
            }
            
            #align1b tr.expanded-row td:nth-of-type(4):before { content: "Email: "; font-weight: bold !important; color: #000 !important; display: inline !important; margin-right: 4px !important;}
            #align1b tr.expanded-row td:nth-of-type(5):before { content: "Mobile: "; font-weight: bold !important; color: #000 !important; display: inline !important; margin-right: 4px !important;}
            #align1b tr.expanded-row td:nth-of-type(6):before { content: "Action: "; font-weight: bold !important; color: #000 !important; display: inline !important; margin-right: 4px !important;}
            
            #align1b tr.expanded-row td:nth-of-type(6) {
                display: flex !important;
                align-items: center !important;
                margin-top: 8px !important;
                padding-top: 0 !important;
                border-top: none !important;
                font-size: 0.95rem !important;
                color: #34495e !important;
            }
            #align1b tr.expanded-row td:nth-of-type(6) a {
                padding: 4px 12px !important;
                background: #fff0f0 !important;
                border-radius: 4px !important;
                display: inline-block !important;
            }

            /* ---------- ACCESS HISTORY (already existing) ---------- */
            #row3 .table-access thead { display: none !important; }
            #row3 .table-access tbody { background: transparent !important; }

            #row3 .table-access #align-access tr { 
                display: flex !important;
                flex-direction: column !important;
                align-items: stretch !important;
                border: 1px solid #e0e0e0 !important; 
                border-radius: 8px !important;
                margin-bottom: 8px !important;
                position: relative !important;
                padding: 10px 40px 10px 15px !important;
                background: #fff !important;
                box-shadow: 0 1px 4px rgba(0,0,0,0.05) !important;
                width: 100% !important;
            }
            
            #row3 .table-access #align-access td {
                display: block !important;
                border: none !important;
                padding: 0 !important;
                text-align: left !important;
                white-space: normal !important;
                width: 100% !important;
                background: transparent !important;
                height: auto !important;
                min-height: 0 !important;
                line-height: 1.4 !important;
                font-size: 0.95rem !important;
                color: #34495e !important;
                word-break: normal !important;
            }
            
            #row3 .table-access #align-access td:nth-of-type(1) {
                font-weight: bold !important;
                font-size: 1rem !important;
                color: #2c3e50 !important;
                margin-bottom: 2px !important;
                width: 100% !important;
            }
            
            #row3 .table-access #align-access td:nth-of-type(2) {
                font-size: 0.85rem !important;
                color: #7f8c8d !important;
                margin-bottom: 0 !important;
                width: 100% !important;
            }
            #row3 .table-access #align-access tr.expanded-row td:nth-of-type(2) {
                margin-bottom: 8px !important;
            }
            
            #row3 .table-access #align-access td:nth-of-type(3) {
                display: none !important;
                margin-top: 4px !important;
                width: 100% !important;
            }
            #row3 .table-access #align-access td:nth-of-type(3):before { content: "Login: "; font-weight: bold !important; color: #000 !important; display: inline !important; margin-right: 4px !important;}
            #row3 .table-access #align-access tr.expanded-row td:nth-of-type(3) {
                display: flex !important;
            }
            
            #row3 .table-access #align-access td:nth-of-type(4) {
                display: none !important;
                margin-top: 4px !important;
                width: 100% !important;
            }
            #row3 .table-access #align-access td:nth-of-type(4):before { content: "Logout: "; font-weight: bold !important; color: #000 !important; display: inline !important; margin-right: 4px !important;}
            #row3 .table-access #align-access tr.expanded-row td:nth-of-type(4) {
                display: flex !important;
            }

            #row3 .table-access #align-access tr::after {
                content: '\f054';
                font-family: 'FontAwesome';
                position: absolute;
                right: 20px;
                top: 50%;
                transform: translateY(-50%);
                color: #bdc3c7;
                transition: transform 0.3s;
                font-size: 1rem;
            }
            #row3 .table-access #align-access tr.expanded-row::after {
                transform: translateY(-50%) rotate(90deg);
                top: 35px;
            }

            /* ---------- SAIL TABLE (already existing) ---------- */
            #row3 .table-sail thead { display: none !important; }
            #row3 .table-sail tbody { background: transparent !important; }

            #row3 .table-sail #align-sail tr { 
                display: flex !important;
                flex-direction: column !important;
                align-items: stretch !important;
                border: 1px solid #e0e0e0 !important; 
                border-radius: 8px !important;
                margin-bottom: 8px !important;
                position: relative !important;
                padding: 10px 40px 10px 45px !important;
                background: #fff !important;
                box-shadow: 0 1px 4px rgba(0,0,0,0.05) !important;
                width: 100% !important;
            }
            
            #row3 .table-sail #align-sail td {
                display: block !important;
                border: none !important;
                padding: 0 !important;
                text-align: left !important;
                white-space: normal !important;
                width: 100% !important;
                background: transparent !important;
                height: auto !important;
                min-height: 0 !important;
                line-height: 1.4 !important;
                font-size: 0.95rem !important;
                color: #34495e !important;
                word-break: normal !important;
            }
            
            #row3 .table-sail #align-sail td:nth-of-type(1) {
                position: absolute !important;
                left: 15px !important;
                top: 50% !important;
                transform: translateY(-50%) !important;
                width: 25px !important;
                font-weight: bold !important;
                font-size: 1rem !important;
                color: #2c3e50 !important;
                background: transparent !important;
                display: flex !important;
                align-items: center !important;
                margin: 0 !important;
            }
            #row3 .table-sail #align-sail tr.expanded-row td:nth-of-type(1) {
                top: 20px !important;
                transform: translateY(0) !important;
            }
            
            #row3 .table-sail #align-sail td:nth-of-type(2) {
                font-weight: bold !important;
                font-size: 1rem !important;
                color: #2c3e50 !important;
                margin-bottom: 2px !important;
                width: 100% !important;
            }
            
            #row3 .table-sail #align-sail td:nth-of-type(3) {
                font-size: 0.85rem !important;
                color: #34495e !important;
                margin-bottom: 0 !important;
                width: 100% !important;
            }
            #row3 .table-sail #align-sail td:nth-of-type(3):before { content: "ID: "; font-weight: bold !important; color: #000 !important; }
            #row3 .table-sail #align-sail tr.expanded-row td:nth-of-type(3) {
                margin-bottom: 8px !important;
            }
            
            #row3 .table-sail #align-sail td:nth-of-type(4) {
                display: none !important;
                margin-top: 4px !important;
                width: 100% !important;
            }
            #row3 .table-sail #align-sail td:nth-of-type(4):before { content: "Status: "; font-weight: bold !important; color: #000 !important; display: inline !important; margin-right: 4px !important;}
            #row3 .table-sail #align-sail tr.expanded-row td:nth-of-type(4) {
                display: flex !important;
            }

            #row3 .table-sail #align-sail tr::after {
                content: '\f054';
                font-family: 'FontAwesome';
                position: absolute;
                right: 20px;
                top: 50%;
                transform: translateY(-50%);
                color: #bdc3c7;
                transition: transform 0.3s;
                font-size: 1rem;
            }
            #row3 .table-sail #align-sail tr.expanded-row::after {
                transform: translateY(-50%) rotate(90deg);
                top: 35px;
            }

            /* ================================================================
               MODAL TABLES (Elina Lead, OVM, SAIL) – now also for tablet
               ================================================================ */
            #elina_leads table,
            #elina_ovm table,
            #elina_sail table {
                table-layout: fixed;
                width: 100% !important;
                border-collapse: collapse;
            }

            #elina_leads table thead,
            #elina_ovm table thead,
            #elina_sail table thead {
                display: none !important;
            }

            #elina_leads table tbody,
            #elina_ovm table tbody,
            #elina_sail table tbody {
                background: transparent !important;
            }

            #elina_leads table tbody tr,
            #elina_ovm table tbody tr,
            #elina_sail table tbody tr {
                display: flex !important;
                flex-direction: column !important;
                align-items: stretch !important;
                border: 1px solid #e0e0e0 !important;
                border-radius: 8px !important;
                margin-bottom: 8px !important;
                position: relative !important;
                padding: 10px 40px 10px 45px !important; /* left padding for S.No, right for chevron */
                background: #fff !important;
                box-shadow: 0 1px 4px rgba(0,0,0,0.05) !important;
                cursor: pointer;
                width: 100% !important;
            }

            #elina_leads table tbody td,
            #elina_ovm table tbody td,
            #elina_sail table tbody td {
                display: block !important;
                border: none !important;
                padding: 0 !important;
                text-align: left !important;
                white-space: normal !important;
                width: 100% !important;
                background: transparent !important;
                height: auto !important;
                min-height: 0 !important;
                line-height: 1.4 !important;
                font-size: 0.95rem !important;
                color: #34495e !important;
                word-break: normal !important;
            }

            /* First column (Sl.No) – absolute position */
            #elina_leads table tbody td:nth-of-type(1),
            #elina_ovm table tbody td:nth-of-type(1),
            #elina_sail table tbody td:nth-of-type(1) {
                position: absolute !important;
                left: 15px !important;
                top: 50% !important;
                transform: translateY(-50%) !important;
                width: 25px !important;
                font-weight: bold !important;
                font-size: 1rem !important;
                color: #2c3e50 !important;
                background: transparent !important;
                display: flex !important;
                align-items: center !important;
                margin: 0 !important;
            }

            #elina_leads table tbody tr.expanded-row td:nth-of-type(1),
            #elina_ovm table tbody tr.expanded-row td:nth-of-type(1),
            #elina_sail table tbody tr.expanded-row td:nth-of-type(1) {
                top: 20px !important;
                transform: translateY(0) !important;
            }

            /* Second column – main title */
            #elina_leads table tbody td:nth-of-type(2),
            #elina_ovm table tbody td:nth-of-type(2),
            #elina_sail table tbody td:nth-of-type(2) {
                font-weight: bold !important;
                font-size: 1rem !important;
                color: #2c3e50 !important;
                margin-bottom: 2px !important;
                width: 100% !important;
            }

            /* Third column – extra info (shown with label) */
            #elina_leads table tbody td:nth-of-type(3),
            #elina_ovm table tbody td:nth-of-type(3),
            #elina_sail table tbody td:nth-of-type(3) {
                font-size: 0.85rem !important;
                color: #34495e !important;
                margin-bottom: 0 !important;
                width: 100% !important;
            }
            #elina_leads table tbody td:nth-of-type(3):before,
            #elina_ovm table tbody td:nth-of-type(3):before,
            #elina_sail table tbody td:nth-of-type(3):before {
                content: "ID: ";
                font-weight: bold !important;
                color: #000 !important;
            }
            #elina_leads table tbody tr.expanded-row td:nth-of-type(3),
            #elina_ovm table tbody tr.expanded-row td:nth-of-type(3),
            #elina_sail table tbody tr.expanded-row td:nth-of-type(3) {
                margin-bottom: 8px !important;
            }

            /* Columns 4, 5, 6 – hidden initially, shown on expansion */
            #elina_leads table tbody td:nth-of-type(4),
            #elina_ovm table tbody td:nth-of-type(4),
            #elina_sail table tbody td:nth-of-type(4),
            #elina_leads table tbody td:nth-of-type(5),
            #elina_ovm table tbody td:nth-of-type(5),
            #elina_sail table tbody td:nth-of-type(5),
            #elina_leads table tbody td:nth-of-type(6),
            #elina_ovm table tbody td:nth-of-type(6),
            #elina_sail table tbody td:nth-of-type(6) {
                display: none !important;
                margin-top: 4px !important;
                width: 100% !important;
            }

            #elina_leads table tbody td:nth-of-type(4):before,
            #elina_ovm table tbody td:nth-of-type(4):before,
            #elina_sail table tbody td:nth-of-type(4):before {
                content: "Email: ";
                font-weight: bold !important;
                color: #000 !important;
                display: inline !important;
                margin-right: 4px !important;
            }
            #elina_leads table tbody td:nth-of-type(5):before,
            #elina_ovm table tbody td:nth-of-type(5):before,
            #elina_sail table tbody td:nth-of-type(5):before {
                content: "Mobile: ";
                font-weight: bold !important;
                color: #000 !important;
                display: inline !important;
                margin-right: 4px !important;
            }
            #elina_leads table tbody td:nth-of-type(6):before,
            #elina_ovm table tbody td:nth-of-type(6):before,
            #elina_sail table tbody td:nth-of-type(6):before {
                content: "Action: ";
                font-weight: bold !important;
                color: #000 !important;
                display: inline !important;
                margin-right: 4px !important;
            }

            #elina_leads table tbody tr.expanded-row td:nth-of-type(4),
            #elina_ovm table tbody tr.expanded-row td:nth-of-type(4),
            #elina_sail table tbody tr.expanded-row td:nth-of-type(4),
            #elina_leads table tbody tr.expanded-row td:nth-of-type(5),
            #elina_ovm table tbody tr.expanded-row td:nth-of-type(5),
            #elina_sail table tbody tr.expanded-row td:nth-of-type(5),
            #elina_leads table tbody tr.expanded-row td:nth-of-type(6),
            #elina_ovm table tbody tr.expanded-row td:nth-of-type(6),
            #elina_sail table tbody tr.expanded-row td:nth-of-type(6) {
                display: flex !important;
                align-items: center !important;
            }

            /* Chevron icon for modal rows */
            #elina_leads table tbody tr::after,
            #elina_ovm table tbody tr::after,
            #elina_sail table tbody tr::after {
                content: '\f054';
                font-family: 'FontAwesome';
                position: absolute;
                right: 20px;
                top: 50%;
                transform: translateY(-50%);
                color: #bdc3c7;
                transition: transform 0.3s;
                font-size: 1rem;
            }

            #elina_leads table tbody tr.expanded-row::after,
            #elina_ovm table tbody tr.expanded-row::after,
            #elina_sail table tbody tr.expanded-row::after {
                transform: translateY(-50%) rotate(90deg);
                top: 35px;
            }

            /* ---------- PAGINATION inside modals ---------- */
            .modal .pagination {
                flex-wrap: wrap !important;
                justify-content: center !important;
                gap: 4px !important;
                margin: 10px 0 !important;
            }
            .modal .pagination .page-item .page-link {
                padding: 4px 8px !important;
                font-size: 0.85rem !important;
                border-radius: 4px !important;
            }
            .modal .pagination .page-item.active .page-link {
                background-color: #007bff !important;
                border-color: #007bff !important;
                color: #fff !important;
            }
            .modal .pagination .page-item.disabled .page-link {
                opacity: 0.5 !important;
            }

            /* Modal body scroll */
            .modal-body {
                max-height: 75vh !important;
                overflow-y: auto !important;
            }
            .modal-body .table-wrapper {
                overflow-x: auto !important;
            }

            /* ---------- Log Modal Table (already existing) ---------- */
            #logModal .modal-dialog {
                margin: 10px !important;
            }
            
            #logModal .modal-body {
                padding: 10px !important;
            }

            #logModal .table-wrapper {
                height: auto !important;
                max-height: 400px !important;
                overflow-y: auto !important;
            }

            .table-modal-log thead { display: none !important; }
            .table-modal-log tbody { background: transparent !important; }

            #logTable tr { 
                display: flex !important;
                flex-direction: column !important;
                align-items: stretch !important;
                border: 1px solid #e0e0e0 !important; 
                border-radius: 8px !important;
                margin-bottom: 8px !important;
                position: relative !important;
                padding: 10px 15px 10px 45px !important;
                background: #fff !important;
                box-shadow: 0 1px 4px rgba(0,0,0,0.05) !important;
                width: 100% !important;
            }
            
            #logTable td {
                display: block !important;
                border: none !important;
                padding: 0 !important;
                text-align: left !important;
                white-space: normal !important;
                width: 100% !important;
                background: transparent !important;
                height: auto !important;
                min-height: 0 !important;
                line-height: 1.4 !important;
                font-size: 0.95rem !important; 
                color: #34495e !important;
                word-break: normal !important;
            }
            
            #logTable td:nth-of-type(1) {
                position: absolute !important;
                left: 15px !important;
                top: 50% !important;
                transform: translateY(-50%) !important;
                width: 25px !important;
                font-weight: bold !important;
                font-size: 1rem !important;
                color: #2c3e50 !important;
                background: transparent !important;
                display: flex !important;
                align-items: center !important;
                margin: 0 !important;
            }
            
            #logTable td:nth-of-type(2) {
                font-weight: bold !important;
                font-size: 1rem !important;
                color: #2c3e50 !important;
                margin-bottom: 4px !important;
                width: 100% !important;
            }
            
            #logTable td:nth-of-type(3) {
                font-size: 0.85rem !important;
                color: #7f8c8d !important;
                width: 100% !important;
            }
            #logTable td:nth-of-type(3):before { content: "Action Time: "; font-weight: bold !important; color: #000 !important; }

            /* No Data Found row styling */
            #align1b tr.no-data-row {
                display: block !important;
                padding: 20px 15px !important;
                text-align: center !important;
                background: #fdfefe !important;
                border: 1px dashed #ccd1d1 !important;
                border-radius: 8px !important;
                margin-bottom: 12px !important;
                height: auto !important;
                min-height: 60px !important;
            }
            #align1b tr.no-data-row::after {
                display: none !important;
                content: none !important;
            }
            #align1b tr.no-data-row td {
                display: block !important;
                position: static !important;
                transform: none !important;
                width: 100% !important;
                text-align: center !important;
                font-weight: bold !important;
                font-size: 1.1rem !important;
                color: #7f8c8d !important;
                margin: 0 !important;
                padding: 0 !important;
                background: transparent !important;
            }

            #searchReset {
                width: calc(100% - 30px) !important;
                float: none !important;
                margin: 15px 15px !important;
                display: block !important;
                text-align: center !important;
                font-weight: bold !important;
                font-size: 0.9rem !important;
                padding: 8px 16px !important;
                border-radius: 6px !important;
            }

            #logModal #search {
                width: 50% !important;
                float: right !important;
                margin: 10px 15px 10px 0px !important;
            }

            .hidden-row {
                display: none !important;
            }

            /* Profile card centering */
            .profile-card .list-group-item {
                justify-content: center !important;
                flex-wrap: wrap !important;
                text-align: center !important;
            }
            .profile-card .list-group-item h6,
            .profile-card .list-group-item span,
            .profile-card .list-group-item a {
                text-align: center !important;
                width: 100% !important;
                justify-content: center !important;
            }
            .profile-card .list-group-item a {
                display: inline-block !important;
                margin: 2px 0 !important;
            }
            .profile-card .list-group-item:last-child {
                flex-direction: column !important;
                align-items: center !important;
                gap: 4px;
            }
        }

        /* Ensure equal height for Access History and Sail cards */
        #row3 .card {
            height: 100%;
        }

        .last-login-value {
            white-space: nowrap !important;
        }

        .analysis-card {
            height: 100% !important;
            overflow: hidden !important;
        }
        .analysis-card .card-body {
            overflow: hidden !important;
            padding-bottom: 0 !important;
        }
        .analysis-card #chart_div {
            width: 100%;
            height: 100%;
            min-height: 280px;
        }
    </style>
    <div class="main-content contentpadding" style="position:absolute; z-index:-1">
        <div class="section-body">
            <!-- ---------- TOP ROW with reduced gutters ---------- -->
            <div class="row gutter-sm">
                @if($modules['user_role'] != 'IS Coordinator')
                    <div class="col-md-3">
                @else
                    <div class="col-md-4">
                @endif
                        <div class="card profile-card">
                            <div class="card-body">
                                <div class="d-flex flex-column align-items-center text-center">
                                    @if($rows['users']['profile_image'] != "")
                                        <img src="{{$rows['users']['profile_image'] }}" alt="" width="100" height="100"
                                            style="border-radius:50%;height: 130px;width: 130px;margin: 10px 0px 10px 0px;"
                                            onerror="this.onerror=null;this.src='{{ asset('images/profile-picture.webp') }}';">
                                    @else
                                        <img style="margin-top: 10px;" src="{{ asset('images/profile-picture.webp') }}" alt="profile"
                                            class="rounded-circle p-1 bg-primary" width="110">
                                        <div class="mt-3">
                                            <h4 class="headercolor">{{$rows['users']['name']}}</h4>
                                            <p class="text-secondary mb-1 headercolor">{{$rows['users']['role_name']}}</p>
                                        </div>
                                    @endif
                                </div>
                                <ul class="list-group list-group-flush">
                                    <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                                        <h6 class="mb-0" style="color:#6b747b;">
                                            <i class="fa fa-briefcase mr-2" aria-hidden="true" style="width: 20px; text-align: center;"></i> Designation
                                        </h6>
                                        <span class="text-secondary"
                                            style="font-weight:bold;">{{$rows['users']['role_name']}}</span>
                                    </li>
                                    <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                                        <h6 class="mb-0" style="color:#6b747b; white-space: nowrap;">
                                            <i class="fa fa-clock mr-2" style="width: 20px; text-align: center;"></i> Last Login
                                        </h6>
                                        <span class="text-secondary last-login-value" style="padding: 0 0 0 14px; font-weight: 700;">
                                            {{ date('d M - h:i A', strtotime($rows['users']['login_time'])) }}
                                        </span>
                                    </li>
                                    <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                                        <a href="{{ route('profilepage') }}" class="mb-0"
                                            style="text-align: right; font-weight: bold; color:#6b747b;">
                                            <i class="fa fa-user mr-2" style="width: 20px; text-align: center;"></i> View Profile
                                        </a>
                                        <a style="text-align: left; font-weight: bold; color:#6b747b;" href="#"
                                            onclick="event.preventDefault();document.getElementById('logout-form').submit();">Logout
                                            <i class="fa fa-sign-out ml-2"></i>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    @if($modules['user_role'] != 'IS Coordinator')
                        <div class="col-md-5">
                    @else
                        <div class="col-md-8">
                    @endif
                            <div class="card cardheight headercolor">
                                <div class="card-header"><i class="fa fa-folder-open" id="fa-icon" aria-hidden="true"></i>
                                    Elina Student Activity List</div>
                                <div class="card-body" id="scroll">
                                    <div class="card mb-3 widget-content bg">
                                        <div class="widget-content-wrapper text-white">
                                            <div class="widget-content-left">
                                                <div class="widget-heading fontsweight fontsizes">Elina Lead</div>
                                                <div style="text-align: left;">
                                                    <a class="dbox__title fontsweight" onclick="getleadDetails()">View</a>
                                                    <!-- <a class="dbox__title fontsweight" href="#addModal" data-toggle="modal" data-target="#addModal">View</a> -->
                                                </div>
                                            </div>
                                            <div class="widget-content-right">
                                                <div class="widget-numbers text-white numberfontsize">
                                                    <span>{{ count($rows['leads'] ?? '') }}
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="card mb-3 widget-content bg">
                                        <div class="widget-content-wrapper text-white">
                                            <div class="widget-content-left">
                                                <div class="widget-heading fontsweight fontsizes">Overall OVM Meetings</div>
                                                <div style="text-align: left;">
                                                    <a class="dbox__title fontsweight" onclick="getOVMDetails()">View</a>
                                                    <!-- <a class="dbox__title fontsweight" href="#elina_ovm" data-toggle="modal" data-target="#elina_ovm">View</a> -->
                                                </div>
                                            </div>
                                            <div class="widget-content-right">
                                                <div class="widget-numbers text-white numberfontsize">
                                                    <span>{{ count($rows['rows'] ?? []) }}</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card mb-3 widget-content bg">
                                        <div class="widget-content-wrapper text-white">
                                            <div class="widget-content-left">
                                                <div class="widget-heading fontsweight fontsizes">SAIL</div>
                                                <div style="text-align: left;">
                                                    <a class="dbox__title fontsweight" href="#elina_sail"
                                                        data-toggle="modal" data-target="#elina_sail"
                                                        style="color: white;">View</a>
                                                </div>
                                            </div>
                                            <div class="widget-content-right">
                                                <div class="widget-numbers text-white numberfontsize">
                                                    <span>{{ count($rows['sail'] ?? []) }}</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="card mb-3 widget-content bg">
                                        <div class="widget-content-wrapper text-white">
                                            <div class="widget-content-left">
                                                <div class="widget-heading fontsweight fontsizes">CoMPASS</div>
                                                <div style="text-align: left;">
                                                    <!-- <a class="dbox__title fontsweight" onclick="alert('No Data Found')">View</a> -->
                                                    <!-- <a class="dbox__title fontsweight" href="#addModal" data-toggle="modal" data-target="#addModal">View</a> -->
                                                </div>
                                            </div>
                                            <div class="widget-content-right">
                                                <div class="widget-numbers text-white numberfontsize"><span> 0</span></div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                        @if($modules['user_role'] != 'IS Coordinator')
                            <div class="col-md-4">
                                <div class="card cardheight" style="background-color: white; ">
                                    <div class="card-header headercolor">
                                        <i class="fa fa-pie-chart" id="fa-icon" aria-hidden="true">
                                        </i>Enrollment Analysis
                                    </div>

                                    <div id="piechart" style="width: 100%; height: 300px;">


                                    </div>
                                </div>
                            </div>
                        @endif
                        <!-- End Row 1 -->

                        <!-- Row 2 -->
                        <div class="row">
                            @if($modules['user_role'] != 'IS Coordinator')
                                <div class="col-md-12">
                                    <div class="col-xs-12">
                                        <div class="card">
                                            <div class="card-header headercolor"><i class="fa fa-bar-chart" id="fa-icon"
                                                    aria-hidden="true"></i> Black Board</div>
                                            <div class="card-body">

                                                <ul class="list-group list-group-flush">
                                                    <a class="borderBoard" href="{{route('user.index')}}">
                                                        <li
                                                            class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                                                            <div class="float-left" style="font-weight:bold;color:#6b747b;">User
                                                                Registered</div>
                                                            <div class="counter-va" class="float-right newcolor">
                                                                {{$rows['blackboard'][0]['register_count']}}
                                                            </div>
                                                        </li>
                                                    </a>
                                                    <a class="borderBoard" href="{{route('newenrollment.index')}}">
                                                        <li
                                                            class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                                                            <div class="float-left" style="font-weight:bold;color:#6b747b;">
                                                                Enrolled</div>
                                                            <div class="float-right newcolor">{{$rows['totalenrolled']}}</div>
                                                        </li>
                                                    </a>

                                                    <a class="borderBoard" href="{{route('ovm1.index')}}">
                                                        <li
                                                            class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                                                            <div class="float-left" style="font-weight:bold;color:#6b747b;">OVM
                                                                1 Meeting</div>
                                                            <div class="float-right newcolor">
                                                                {{$rows['blackboard'][0]['ovm_count']}}
                                                            </div>
                                                        </li>
                                                    </a>
                                                    <a class="borderBoard" href="{{route('ovm2.index')}}">
                                                        <li
                                                            class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                                                            <div class="float-left" style="font-weight:bold;color:#6b747b;">OVM
                                                                2 Meeting</div>
                                                            <div class="float-right newcolor">
                                                                {{$rows['blackboard'][0]['ovm2_count']}}
                                                            </div>
                                                        </li>
                                                    </a>
                                                    <!-- <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                                                                                        <div class="float-left" style="font-weight:bold;color:#6b747b;">Completed Assessment</div>
                                                                                        <div class="float-right newcolor">0</div>
                                                                                    </li> -->
                                                    <a class="borderBoard" href="{{route('sailstatus')}}">
                                                        <li
                                                            class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                                                            <div class="float-left" style="font-weight:bold;color:#6b747b;">Sail
                                                            </div>
                                                            <div class="float-right newcolor">{{ count($rows['sail'] ?? []) }}
                                                            </div>
                                                        </li>
                                                    </a>
                                                    <li
                                                        class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                                                        <div class="float-left" style="font-weight:bold;color:#6b747b;">CoMPASS
                                                            Process</div>
                                                        <div class="float-right newcolor">0</div>
                                                    </li>

                                                    <li
                                                        class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                                                        <div class="float-left" style="font-weight:bold;color:#6b747b;">Renewal
                                                            Process</div>
                                                        <div class="float-right newcolor">0</div>
                                                    </li>
                                                    <li
                                                        class="list-group-item d-flex justify-content-between align-items-center flex-wrap bglred">
                                                        <div class="float-left cclr" style="font-weight:bold;">SLA Crossed</div>
                                                        <div class="float-right newcolor cclr">
                                                            {{$rows['blackboard'][0]['sla_crossed']}}
                                                        </div>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif

                            <!-- ========== SEARCH HERE – now a card wrapper matching Black Board ========== -->
                            <div class="col-md-12">
                                <div class="card">
                                    <div class="card-header">
                                        <i class="fa fa-search" id="fa-icon" aria-hidden="true"></i><a
                                            style="color: #5263dd;font-weight: bold;" href=""> Search Here</a>
                                        <div class="float-right colorgrey"> </div>
                                    </div>
                                    <div class="card-body">
                                        <ul class="list-group list-group-flush">

                                            <li class="list-group-item d-flex justify-content-between align-items-center ">
                                                <p style=" font-weight: bold;color:#6b747b;" href="#"
                                                    title="{{ __('View') }}">Search By </p>
                                                <select class="form-control wp px-auto" name="elinalead" id="searchuserdata"
                                                    style="background-color: #ffffff !important;"
                                                    onchange="selectfn(event)">
                                                    <option value="">Select-Category</option>
                                                    <option Value="child_name">Child Name</option>
                                                    <option Value="enrollment_child_num">Child Enrollment Id</option>
                                                    <option Value="child_contact_phone">Child Contact Number</option>
                                                    <option Value="child_contact_email">Child Contact Email</option>
                                                    <!-- <option Value="coordinators">IS Coordinators</option> -->
                                                </select>
                                            </li>
                                            <li class="list-group-item d-flex justify-content-between align-items-center"
                                                id="SearchByChild" style="display: none !important;">
                                                <a style=" font-weight: bold;color:#6b747b; " id="selectedcategory"
                                                    class="text-capitalize" href="#" title="{{ __('View') }}">Category
                                                </a><input style="background-color: #ffffff !important;" type="text"
                                                    id="searchinput" class="form-control wp">
                                            </li>
                                            <li class="list-group-item d-flex justify-content-between align-items-center"
                                                id="SearchByCoordinators" style="display: none !important;">
                                                <p style=" font-weight: bold;color:#6b747b;" class="text-capitalize">
                                                    Coordinator</p>
                                                <select class="form-control wp" name="searchCoordinators"
                                                    id="searchCoordinators" onchange="searchCoordinators()">
                                                    <option value="">Select Coordinators</option>
                                                    @foreach($rows['coordinators'] as $coordinators)
                                                        <option value="{{$coordinators['id']}}">{{$coordinators['name']}}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </li>
                                            <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap"
                                                style="height: 52px;">
                                                <h6></h6>
                                                <a class="btn btn-labeled btn-info text-white " type="button"
                                                    onclick="elinaleadsearch()" title="{{ __('View') }}"><span
                                                        class="text-white"><i class="fa fa-search" aria-hidden="true"></i>
                                                        Search</span></a>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="searchResultCoordinator" id="columnchart_material"
                                        style="display: none;width: 100% !important; height: 400px;"></div>
                                    <div class="scrollable fixTableHead title-padding searchResultStudent" id="scrolls">
                                        <div class="table-responsive" style="cursor: grab;">
                                            <table
                                                class="table table-hover table-bordered table-custom-list card-body custom"
                                                style="width:100% !important">
                                                <thead>
                                                    <tr>
                                                        <!-- <th scope="col">Audit ID</th> -->
                                                        <th>Sl.No</th>
                                                        <th>Enrollment ID</th>
                                                        <th>Child Name</th>
                                                        <th>Email</th>
                                                        <th>Mobile Number</th>
                                                        <th>Track & Trace</th>
                                                    </tr>
                                                </thead>
                                                <tbody style="background-color: white; " id="align1b">
                                                    @foreach($rows['enrollment_details'] as $data)
                                                        <tr>
                                                            <td>{{$loop->iteration}}</td>
                                                            <td>{{$data['enrollment_child_num']}}</td>
                                                            <td>{{$data['child_name']}}</td>
                                                            <td>{{$data['child_contact_email']}}</td>
                                                            <td>{{$data['child_contact_phone']}}</td>

                                                            <td> <a onclick="overallStatus('{{$data['enrollment_id']}}' , '{{$data['child_name']}}')"
                                                                    title="Overall Status"><i class="fa fa-bars"
                                                                        style="color: red;"></i></a></td>
                                                        </tr>
                                                    @endforeach

                                                </tbody>
                                            </table>
                                        </div>
                                        <a class="btn text-white" type="button"
                                            style="background-color: red;float: right;display:none" id="searchReset"
                                            onclick="resetsearch()" title="{{ __('Reset') }}"><span class="text-white"><i
                                                    class="fa fa-refresh" aria-hidden="true"></i> Reset</span></a>
                                    </div>
                                </div>
                            </div>
                            <!-- ========== End Search Here ========== -->

                        </div>
                        <div>



                        </div>
                    </div>





                    <div class="row" id="row3">
                        <div class="col-12 col-md-6">
                            <div class="card justify-content-md-center h-100">
                                <div class="card-header headercolor justify-content-between"><i class="fa fa-history"
                                        id="fa-icon" aria-hidden="true"> Access History</i>
                                    <a href="{{url('auditlog/login_report')}}">
                                        <div class="float-right">View All <i class="fa fa-arrow-right"
                                                aria-hidden="true"></i></div>
                                    </a>
                                </div>
                                <div class="scrollable fixTableHead title-padding" id="scrolls">
                                    <div class="table-responsive">
                                        <table class="table table-hover table-bordered table-custom-list card-body table-access"
                                            style="width:100% !important">
                                            <thead>
                                                <tr>
                                                    <!-- <th scope="col">Audit ID</th> -->
                                                    <th style="width:16%">User Name</th>
                                                    <th style="width:16% !important">Designation</th>
                                                    <!-- <th style="width:15% !important">Role</th> -->
                                                    <th style="width:15% !important">Login</th>
                                                    <th style="width:15%">Logout</th>
                                                </tr>
                                            </thead>

                                            <tbody style="background-color: white; " id="align-access">

                                                @foreach($rows['userlogin'] as $data)
                                                    @if($loop->iteration < 10)
                                                        <tr>
                                                            <!-- <td>Login{{$loop->iteration}}</td> -->
                                                            <td>{{$data['name']}}</td>
                                                            <td>{{$data['role_name']}}</td>
                                                            <!-- <td>{{$data['role_name']}}</td> -->
                                                            <td>{{ date('d-m-Y h:i A', strtotime($data['login_time'])) }}</td>
                                                            @if($data['logout_time'] == '' || $data['logout_time'] == null)
                                                                <td> - </td>
                                                            @else <td>{{ date('d-m-Y h:i A', strtotime($data['logout_time'])) }}
                                                                </td>
                                                            @endif
                                                        </tr>
                                                    @endif
                                                @endforeach

                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>

                        @if($modules['user_role'] != 'IS Coordinator')
                            <div class="col-12 col-md-6">
                                <div class="card analysis-card h-100">
                                    <div class="card-header headercolor"><i class="fa fa-area-chart" id="fa-icon"
                                            aria-hidden="true"></i>Enrollment ISMS Analysis </div>
                                    <div class="card-body chartspace">
                                        <div id="chart_div" style="width: 100%; height: 100%; min-height: 280px;"></div>
                                    </div>
                                </div>
                            </div>
                        @else
                            <div class="col-12 col-md-6">
                                <div class="card justify-content-md-center h-100">
                                    <div class="card-header headercolor justify-content-between"><i class="fa fa-history"
                                            id="fa-icon" aria-hidden="true"> Sail</i>

                                    </div>
                                    <div class="scrollable fixTableHead title-padding" id="scrolls">
                                        <div class="table-responsive">
                                            <table class="table table-hover table-bordered table-custom-list card-body table-sail"
                                                style="width:100% !important">
                                                <thead>
                                                    <tr>
                                                        <th style="width:5px !important">S.No</th>
                                                        <th>Enrollment Number</th>
                                                        <th>Child Name</th>
                                                        <!-- <th>Is-coordinator</th> -->
                                                        <th>Status</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="align-sail">
                                                    @foreach($rows['sail'] as $key => $row)
                                                        <tr>
                                                            <td>{{ ++$key }}</td>
                                                            <td>{{ $row['child_name']}}</td>
                                                            <td>{{ $row['enrollment_child_num']}}</td>
                                                            <!-- <td>{{ json_decode($row['is_coordinator1'])->name }}</td> -->
                                                            <td>{{ $row['audit_action']}}</td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>




            <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
            <script type="text/javascript">
                $(document).ready(function () {
                    var space_dash = $('.space_dash');
                    $(".space_dash").each(function (index) {
                        if (index == 4) {
                            $(this).css("width", "50px");
                        }
                        if (index == 9) {
                            $(this).css("width", "50px");
                        }
                    });
                });
            </script>

            <input type="hidden" name="session_data" id="session_data" class="session_data"
                value="{{ session('success') }}">
            <script type="text/javascript">

            </script>
            <!-- Pie Chart -->

            <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
            <script type="text/javascript">
                var chart1 = <?php echo json_encode($rows['chart1']); ?>;
                // console.log(chart1);
                google.charts.load('current', {
                    'packages': ['corechart']
                });
                google.charts.setOnLoadCallback(drawChart);

                function drawChart() {

                    var data = google.visualization.arrayToDataTable([
                        ['Task', 'Hours per Day'],
                        ['Parent', chart1[0].child_enrollement_count],
                        ['Intern', chart1[0].internship_count],
                        ['Service Provider', chart1[0].service_provider_count],
                        ['School', chart1[0].school_enrollment_count],
                    ]);

                    var options = {
                        backgroundColor: 'transparent',
                        pieSliceText: 'percentage',
                        pieStartAngle: 100,
                        is3D: true,
                        // chartArea: {
                        //     left: 25,
                        //     top: 30,
                        //     width: '100%',
                        //     height: '100%'
                        // },
                        legend: {
                            display: 'inline-block',
                            position: 'bottom',
                            alignment: 'start',
                            maxLines: 1,
                            textStyle: {
                                color: 'blue',
                                fontSize: 12
                            }
                        }
                    };

                    var chart = new google.visualization.PieChart(document.getElementById('piechart'));

                    chart.draw(data, options);
                }
            </script>








            <!-- Graph -->

            <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
            <script type="text/javascript">
                google.charts.load('current', {
                    packages: ['corechart']
                });
                google.charts.setOnLoadCallback(drawChart);

                function drawChart() {

                    var chart2 = <?php echo json_encode($rows['chart2']); ?>;
                    console.log('chart2', chart2);

                    // Force previous year if only one year exists (so line/area is visible)
                    if (chart2.length === 1) {
                        var y = parseInt(chart2[0].c_year);
                        chart2.unshift({
                            c_year: y - 1,
                            ovm_count: 0,
                            sail_count: 0,
                            dropped: 0
                        });
                    }

                    var chartData = [
                        ['Year', 'Dropped', 'OVM Participated', 'Sail Participated']
                    ];

                    chart2.forEach(function (row) {
                        chartData.push([
                            row.c_year.toString(),
                            Number(row.dropped),
                            Number(row.ovm_count),
                            Number(row.sail_count)
                        ]);
                    });

                    var data = google.visualization.arrayToDataTable(chartData);

                    var options = {
                        backgroundColor: 'transparent',
                        width: '100%',
                        height: '100%',
                        isStacked: false,
                        pointSize: 6,
                        lineWidth: 3,
                        hAxis: {
                            title: 'Year'
                        },
                        vAxis: {
                            minValue: 0,
                            title: 'No of Enrollment'
                        },
                        legend: {
                            position: 'bottom',
                            alignment: 'start',
                            textStyle: {
                                color: '#333',
                                fontSize: 12
                            }
                        },
                        curveType: 'function',
                        series: {
                            0: {
                                areaOpacity: 0.15
                            },
                            1: {
                                areaOpacity: 0.25
                            },
                            2: {
                                areaOpacity: 0.25
                            }
                        },
                        chartArea: {
                            left: 60,
                            top: 20,
                            right: 20,
                            bottom: 60
                        }
                    };

                    var chart = new google.visualization.AreaChart(
                        document.getElementById('chart_div')
                    );

                    chart.draw(data, options);
                }
            </script>








            <script>
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                var initialTableHTML = document.getElementById('align1b').innerHTML;

                function elinaleadsearch() {
                    let sb = $("#searchuserdata").val();

                    const selectElement = document.getElementById('searchuserdata');
                    const selectedOption = selectElement.options[selectElement.selectedIndex].innerHTML;

                    if (sb == '') {
                        swal.fire("Please Select Search By Category", "", "error");
                    }
                    let elinalead = $("#searchinput").val();
                    if (sb == "child_name") {

                        var searchkey = `and a.${sb} LIKE '%${elinalead}%'`;

                    } else if (sb == "child_contact_phone") {
                        var searchkey = `and a.${sb} LIKE '%${elinalead}%'`;
                    } else {
                        var searchkey = `and a.${sb}='${elinalead}'`;
                    }

                    console.log(sb, searchkey);
                    if (elinalead == '') {
                        swal.fire("Please Enter " + selectedOption, "", "error");
                    } else {
                        $.ajax({
                            url: "{{ route('elinaleadsearch') }}",
                            type: 'POST',
                            data: {
                                'searchkey': searchkey,
                                _token: '{{csrf_token()}}'
                            }
                        }).done(function (data) {
                            if (data != '[]') {
                                var optionsdata = "";
                                // console.log(data);
                                if (data.length > 0) {
                                    for (var i = 0; i < data.length; i++) {
                                        var enrollment_child_num = data[i].enrollment_child_num;
                                        var child_name = data[i].child_name;
                                        var child_contact_email = data[i].child_contact_email;
                                        var child_contact_phone = data[i].child_contact_phone;
                                        var enrollment_id = data[i].enrollment_id;
                                        var status = data[i].status;
                                        optionsdata += `<tr><td>${parseInt(i) + 1}</td><td>${enrollment_child_num}</td><td>${child_name}</td><td>${child_contact_email}</td><td>${child_contact_phone}</td><td><a onclick="overallStatus(${enrollment_id}, '${child_name}')" title="Overall Status"><i class="fa fa-bars" style="color: red;"></i></a></td></tr>`;
                                    }
                                } else {
                                    optionsdata += "<tr class='no-data-row'><td colspan='6'>No Data Found</td></tr>";
                                }
                                var demonew = $('#align1b').html(optionsdata);
                                $('#searchReset').show();
                            } else {
                                var ddd = "<tr class='no-data-row'><td colspan='6'>No Data Found</td></tr>";
                                var demonew = $('#align1b').html(ddd);
                                $('#searchReset').show();
                            }
                            $('.searchResultStudent').show();
                            $('.searchResultCoordinator').hide();
                        })
                    }
                };

                function resetsearch() {
                    $("#searchinput").val('');
                    resetTableToInitial();
                    $('.searchResultStudent').show();
                    $('.searchResultCoordinator').hide();
                }

                function resetTableToInitial() {
                    document.getElementById('align1b').innerHTML = initialTableHTML;
                    $('#searchReset').hide();
                }

                function selectfn(event) {
                    var selectby = event.target.value;
                    if (selectby == 'coordinators') {
                        var SearchByChild = document.querySelector("#SearchByChild");
                        SearchByChild.style.setProperty("display", "none", "important");
                        var SearchByCoordinators = document.querySelector("#SearchByCoordinators");
                        SearchByCoordinators.style.setProperty("display", "", "important");

                    } else {
                        var SearchByChild = document.querySelector("#SearchByChild");
                        SearchByChild.style.setProperty("display", "", "important");
                        var SearchByCoordinators = document.querySelector("#SearchByCoordinators");
                        SearchByCoordinators.style.setProperty("display", "none", "important");

                        const selectElement = document.getElementById('searchuserdata');
                        const selectedOption = selectElement.options[selectElement.selectedIndex].innerHTML;
                        selectedcategory.innerText = (!selectby) ? "category" : '' + selectedOption;
                    }
                }
                window.onunload = function () {
                    event.preventDefault();
                    document.getElementById('logout-form').submit();
                }

                // ================================================================
                //  EXPAND / COLLAPSE FOR ALL ACCORDION TABLES (including modals)
                // ================================================================
                $(document).ready(function() {
                    // Click handler for SEARCH table rows
                    $(document).on('click', '.searchResultStudent tr, .table-access tr, .table-sail tr', function() {
                        if($(window).width() <= 1024) {
                            if ($(this).hasClass('expanded-row')) {
                                $(this).removeClass('expanded-row');
                            } else {
                                $(this).siblings('tr').removeClass('expanded-row');
                                $(this).addClass('expanded-row');
                            }
                        }
                    });
                    
                    // Prevent action button click from collapsing row
                    $(document).on('click', '.searchResultStudent td:nth-of-type(6) a', function(e) {
                        if($(window).width() <= 1024) {
                            e.stopPropagation();
                        }
                    });

                    // ===== NEW: Click handlers for MODAL tables =====
                    // Target rows inside the modal tables (using modal IDs)
                    $(document).on('click', '#elina_leads table tbody tr, #elina_ovm table tbody tr, #elina_sail table tbody tr', function(e) {
                        if($(window).width() <= 1024) {
                            // Prevent collapse when clicking on an action link inside the row
                            if ($(e.target).closest('a').length) return;

                            if ($(this).hasClass('expanded-row')) {
                                $(this).removeClass('expanded-row');
                            } else {
                                $(this).siblings('tr').removeClass('expanded-row');
                                $(this).addClass('expanded-row');
                            }
                        }
                    });
                });

                function getDocumentView(documentProcessID) {
                    $(".loader_div").show();
                    $('#viewDocument').html('');
                    $.ajax({
                        url: '/document/processing/document/view',
                        type: 'GET',
                        data: {
                            'documentProcessID': documentProcessID
                        }
                    }).done(function (data) {
                        if (data.status == 401) {
                            window.location.href = "/unauthenticated";
                        }
                        if (data.status == 200) {
                            $('#viewDocument').html(data.html);
                        }
                        $(".loader_div").hide();
                    })
                }
            </script>
            <script>
                function formatDate(inputDateTime) {
                    const ustDate = new Date(inputDateTime + ' UTC');
                    ustDate.setHours(ustDate.getHours() + 5);
                    ustDate.setMinutes(ustDate.getMinutes() + 30);

                    const options = {
                        day: '2-digit',
                        month: 'short',
                        year: 'numeric',
                        hour: '2-digit',
                        minute: '2-digit',
                        hour12: true,
                    };

                    return ustDate.toLocaleDateString(undefined, options);
                }

                function overallStatus(id, Sname) {
                    var enrollment_id = id;

                    $.ajax({
                        url: '/user/status/view',
                        type: 'GET',
                        data: {
                            'get_type': 'child',
                            'enrollment_id': enrollment_id
                        }
                    }).done(function (data) {
                        console.log(data);

                        if (data != '[]') {
                            var user_select = data;
                            var ddd = "";
                            var modalHeader = document.getElementById('modalHeader');
                            modalHeader.textContent = 'Overall Activity of ' + Sname;

                            // 1️⃣ Find Consent Sent time
                            var consentSentTime = null;

                            for (var i = 0; i < user_select.length; i++) {
                                var desc = user_select[i].description;
                                if (desc.includes("Consent Sent")) {
                                    consentSentTime = new Date(
                                        user_select[i].action_date_time.replace(/-/g, '/')
                                    ).getTime();
                                    break;
                                }
                            }

                            var rowIndex = 1;

                            // 2️⃣ Build table rows
                            for (var i = 0; i < user_select.length; i++) {
                                var description = user_select[i].description;
                                var inputDateString = user_select[i].action_date_time;

                                var currentTime = new Date(
                                    inputDateString.replace(/-/g, '/')
                                ).getTime();

                                // 🔴 AFTER Consent → remove SAIL payment rows
                                if (
                                    consentSentTime !== null &&
                                    currentTime >= consentSentTime &&
                                    (
                                        description.includes("SAIL Register Fee Payment Initiated") ||
                                        description.includes("SAIL Register Fee Payment Completed")
                                    )
                                ) {
                                    continue; // remove these rows
                                }

                                // 🔁 BEFORE Consent → rename SAIL → USER
                                if (
                                    consentSentTime !== null &&
                                    currentTime < consentSentTime
                                ) {
                                    if (description.includes("SAIL Register Fee Payment Initiated")) {
                                        description = "User Register Fee Payment Initiated";
                                    }

                                    if (description.includes("SAIL Register Fee Payment Completed")) {
                                        description = "User Register Fee Payment Completed";
                                    }
                                }

                                // 🔁 AFTER Consent → rename generic Payment → SAIL
                                if (
                                    consentSentTime !== null &&
                                    currentTime >= consentSentTime
                                ) {
                                    if (description === "Payment Initiated") {
                                        description = "SAIL Register Fee Payment Initiated";
                                    }

                                    if (description === "Payment Completed") {
                                        description = "SAIL Register Fee Payment Completed";
                                    }
                                }

                                // Convert UTC to IST
                                var utcTime = new Date(inputDateString.replace(/-/g, '/'));
                                utcTime.setHours(utcTime.getHours() + 5);
                                utcTime.setMinutes(utcTime.getMinutes() + 30);

                                var istTime = utcTime.toLocaleString('en-US', {
                                    timeZone: 'Asia/Kolkata'
                                });

                                var dateObj = new Date(istTime);

                                var formattedDate = dateObj.toLocaleString('en-US', {
                                    year: 'numeric',
                                    month: 'short',
                                    day: 'numeric',
                                    hour: 'numeric',
                                    minute: 'numeric',
                                    second: 'numeric',
                                    hour12: true
                                });

                                ddd += "<tr><td>" + rowIndex +
                                    "</td><td>" + description +
                                    "</td><td>" + formattedDate +
                                    "</td></tr>";

                                rowIndex++;
                            }

                            $('#logTable').html(ddd);
                        }

                        $("#logModal").modal();
                    });
                }
            </script>



            <script type="text/javascript">
                // window.onload = function() {
                //     // Full screen
                //     $('body').toggleClass(" sidebar-mini");
                //     var element = document.querySelector(".main-sidebar");
                //     element.style.setProperty("overflow", "hidden", "important");
                // }

                function searchCoordinators() {
                    // $(".loader").show();
                    var searchCoordinators = document.getElementById('searchCoordinators').value;
                    // console.log(searchCoordinators);
                    $.ajax({
                        url: '/search/Coordinators/view',
                        type: 'GET',
                        data: {
                            'searchCoordinators': searchCoordinators
                        }
                    }).done(function (data) {
                        $('.searchResultStudent').hide();
                        var searchResultCoordinator = document.querySelector(".searchResultCoordinator");
                        searchResultCoordinator.style.setProperty("display", "block", "important");
                        // $('.searchResultCoordinator').show();
                        // $(".loader").hide();
                    })
                }
            </script>
            <script type="text/javascript">
                google.charts.load('current', {
                    'packages': ['bar']
                });
                google.charts.setOnLoadCallback(drawChart);

                function drawChart() {
                    var data = google.visualization.arrayToDataTable([
                        ['Month', 'OVM', 'SAIL', 'CoMPASS'],
                        ['May', 11, 11, 0],
                        ['June', 16, 12, 0],
                        ['July', 5, 3, 0]
                    ]);

                    var options = {
                        // 'width': 891,
                        // 'height': 400,
                        // chart: {
                        //     title: 'Company Performance',
                        //     subtitle: 'Sales, Expenses, and Profit: 2014-2017',
                        // }
                    };

                    var chart = new google.charts.Bar(document.getElementById('columnchart_material'));

                    chart.draw(data, google.charts.Bar.convertOptions(options));
                }
            </script>
            @include('modal.students_log')
            @include('modal.elina_dropped')
            @include('modal.elina_ovm')
            @include('modal.elina_sail')
            @include('modal.elina_leads')

            <script>
                // Desktop Row Expansion Logic
                $(document).on('click', '.clickable-name', function() {
                    $(this).closest('tr').next('.details-row').toggle();
                });
            </script>
@endsection