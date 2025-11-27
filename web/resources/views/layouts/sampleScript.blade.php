<script src="{{ asset('asset/js/app.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/hummingbird_treeview.js') }}"></script>
<script src="{{ asset('asset/bundles/datatables/DataTables-1.10.16/js/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('asset/bundles/datatables/datatables.min.js') }}"></script>
<!-- JS Libraies -->
<script src="{{ asset('asset/bundles/chartjs/chart.min.js') }}"></script>
<script src="{{ asset('asset/bundles/apexcharts/apexcharts.min.js') }}"></script>
<!-- Page Specific JS File -->
<script src="{{ asset('asset/js/page/index.js') }}"></script>
<script src="{{ asset('asset/js/page/datatables.js') }}"></script>

<script src="{{ asset('asset/bundles/datatables/export-tables/dataTables.buttons.min.js') }}"></script>
<script src="{{ asset('asset/bundles/datatables/export-tables/buttons.flash.min.js') }}"></script>
<script src="{{ asset('asset/bundles/datatables/export-tables/jszip.min.js') }}"></script>
<script src="{{ asset('asset/bundles/datatables/export-tables/vfs_fonts.js') }}"></script>
<script src="{{ asset('asset/bundles/datatables/export-tables/buttons.print.min.js') }}"></script>
<script src="{{ asset('asset/bundles/datatables/export-tables/pdfmake.min.js') }}"></script>

<script src = "https://code.jquery.com/ui/1.10.4/jquery-ui.js"></script>

<!-- Template JS File -->
<script src="{{ asset('asset/js/scripts.js') }}"></script>
<!-- Custom JS File -->
<script src="{{ asset('asset/js/custom.js') }}"></script>

<script type="text/javascript" src="https://cdn.rawgit.com/t4t5/sweetalert/v0.2.0/lib/sweet-alert.min.js"></script>

<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.2/jquery-ui.min.js"></script>
<script type="text/javascript">
  $(document).ready(function() {
    $('#tableExport').DataTable({
      "lengthMenu": [
        [10, 50, 100, 250, -1],
        [10, 50, 100, 250, "All"]
      ], // page length options

      dom: 'lBfrtip',
      buttons: [
        'copy', 'csv', 'excel', 'print'
      ]
    });
    $('#align').DataTable({
      "lengthMenu": [
        [10, 50, 100, 250, -1],
        [10, 50, 100, 250, "All"]
      ], // page length options

      dom: 'lBfrtip',
      buttons: [
        'copy', 'csv', 'excel', 'print'
      ]
    });
  });
</script>
<script type="text/javascript">
  $(document).ready(function() {
    $('#align1').DataTable({


      "lengthMenu": [
        [10, 50, 100, 250, -1],
        [10, 50, 100, 250, "All"]
      ], // page length options

      dom: 'lBfrtip',


    });

  });

  $(document).ready(function() {
    $('#length5').DataTable({


      "lengthMenu": [
        [5, 10, 50, 100, 250, -1],
        [5, 10, 50, 100, 250, "All"]
      ], // page length options

      dom: 'lBfrtip',


    });

  });
</script>