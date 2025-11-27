<script src="{{ asset('asset/js/app.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/hummingbird_treeview.js') }}"></script>
<!-- <script src="{{ asset('asset/bundles/datatables/DataTables-1.10.16/js/dataTables.bootstrap4.min.js') }}"></script> -->
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

<script src="{{ asset('asset/bundles/datatables/export-tables/buttons.print.min.js') }}"></script>

<script src="{{ asset('asset/bundles/datatables/export-tables/pdfmake.min.js') }}"></script>

<script src="https://code.jquery.com/ui/1.10.4/jquery-ui.js"></script>

<script src="{{ asset('asset/js/jquery-ui.js') }}"></script>
<script src="{{ asset('asset/js/fullcalendar.min.js') }}"></script>

<!-- Template JS File -->
<script src="{{ asset('asset/js/scripts.js') }}"></script>

<script src="{{ asset('asset/js/jquery-ui.min.js') }}"></script>
<script src="https://cdn.tiny.cloud/1/{{ $modules['editorKey'] }}/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>

<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.2/jquery-ui.min.js"></script>
<script type="text/javascript">
  $(document).ready(function() {
    var commonDrawCallback = function(settings) {
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
    };
    window.commonDrawCallback = commonDrawCallback;
  });
  $(document).ready(function() {
    var nav = document.getElementsByClassName("smn");
    for (let i = 0; i < nav.length; i++) {
      let currentnav = window.location.href;
      nav[i].parentElement.parentElement.style.display = (currentnav == nav[i].getAttribute("href")) ? "block" : "none";
      nav[i].parentElement.parentElement.parentElement.parentElement.style.display = (currentnav == nav[i].getAttribute("href")) ? "block" : (nav[i].parentElement.parentElement.parentElement.parentElement.id == "sidechecks") ? "block" : "none";
      nav[i].style.backgroundColor = (currentnav == nav[i].getAttribute("href")) ? "blueviolet" : "none";
      if (currentnav == nav[i].getAttribute("href")) {
        break;
      }
    }

    // let breadcrumbs = document.getElementsByClassName('breadcrumb');
    // console.log(window.location.href);

    //   var li = document.createElement("li");
    // li.appendChild(document.createTextNode("Four"));


    //   let a = document.createElement('li') ;
    //   a.setAttribute('class', 'breadcrumb-item');
    //   let b = document.createElement('a');
    //   b.innerText='UAM';
    // a.appendChild(b);
    //   console.log(a);
    //         breadcrumbs[0].prepend(a);
    //         console.log(breadcrumbs);
    $('#tableExport').DataTable({
      "lengthMenu": [
        [10, 50, 100, 250, -1],
        [10, 50, 100, 250, "All"]
      ], // page length options

      dom: 'lBfrtip',
      buttons: [
        'pdf', 'copy', 'csv', 'excel', 'print'
      ],
      drawCallback: commonDrawCallback
    });

    $('#data1').DataTable({
      "lengthMenu": [
        [10, 50, 100, 250, -1],
        [10, 50, 100, 250, "All"]
      ], // page length options

      dom: 'lBfrtip',
      buttons: [
        'pdf', 'copy', 'csv', 'excel', 'print'
      ],
      drawCallback: commonDrawCallback
    });


  //   var li = document.createElement("li");
  // li.appendChild(document.createTextNode("Four"));
  
 
//   let a = document.createElement('li') ;
//   a.setAttribute('class', 'breadcrumb-item');
//   let b = document.createElement('a');
//   b.innerText='UAM';
// a.appendChild(b);
//   console.log(a);
//         breadcrumbs[0].prepend(a);
//         console.log(breadcrumbs);
    // $('#tableExport').DataTable({
    //   "lengthMenu": [
    //     [10, 50, 100, 250, -1],
    //     [10, 50, 100, 250, "All"]
    //   ], // page length options

    //   dom: 'lBfrtip',
    //   buttons: [
    //     'pdf','copy', 'csv', 'excel', 'print'
    //   ]
    // });

    $('.tableExport').DataTable({
      "lengthMenu": [
        [10, 50, 100, 250, -1],
        [10, 50, 100, 250, "All"]
      ], // page length options

      dom: 'lBfrtip',
      buttons: [
        'pdf', 'copy', 'csv', 'excel', 'print'
      ],
      drawCallback: commonDrawCallback
    });
    
    $('.dashboardTable').DataTable({
      "lengthMenu": [
        [5, 10, 50, 100, 250, -1],
        [5, 10, 50, 100, 250, "All"]
      ], // page length options
      dom: 'frtp',
      drawCallback: commonDrawCallback
    });

    $('#align').DataTable({
      "lengthMenu": [
        [5,10, 50, 100, 250, -1],
        [5,10, 50, 100, 250, "All"]
      ], // page length options

      dom: 'lBfrtip',
      buttons: [
        'pdf', 'copy', 'csv', 'excel', 'print'
      ],
      drawCallback: commonDrawCallback
    });
    $('#alignstretch').DataTable({
      "lengthMenu": [
        [5,10, 50, 100, 250, -1],
        [5,10, 50, 100, 250, "All"]
      ], // page length options

      dom: 'lBfrtip',
      buttons: [
        'pdf', 'copy', 'csv', 'excel', 'print'
      ],
      drawCallback: commonDrawCallback
    });

    $('#alignopportunity').DataTable({
      "lengthMenu": [
        [5,10, 50, 100, 250, -1],
        [5,10, 50, 100, 250, "All"]
      ], // page length options

      dom: 'lBfrtip',
      buttons: [
        'pdf', 'copy', 'csv', 'excel', 'print'
      ],
      drawCallback: commonDrawCallback
    });

    $('#alignhighlights').DataTable({
      "lengthMenu": [
        [5,10, 50, 100, 250, -1],
        [5,10, 50, 100, 250, "All"]
      ], // page length options

      dom: 'lBfrtip',
      buttons: [
        'pdf', 'copy', 'csv', 'excel', 'print'
      ],
      drawCallback: commonDrawCallback
    });

    $('#alignvitals').DataTable({
      "lengthMenu": [
        [5,10, 50, 100, 250, -1],
        [5,10, 50, 100, 250, "All"]
      ], // page length options

      dom: 'lBfrtip',
      buttons: [
        'pdf', 'copy', 'csv', 'excel', 'print'
      ],
      drawCallback: commonDrawCallback
    });

    $('#alignenvironmental').DataTable({
      "lengthMenu": [
        [5,10, 50, 100, 250, -1],
        [5,10, 50, 100, 250, "All"]
      ], // page length options

      dom: 'lBfrtip',
      buttons: [
        'pdf', 'copy', 'csv', 'excel', 'print'
      ],
      drawCallback: commonDrawCallback
    });

    $('#alignemotional').DataTable({
      "lengthMenu": [
        [5,10, 50, 100, 250, -1],
        [5,10, 50, 100, 250, "All"]
      ], // page length options

      dom: 'lBfrtip',
      buttons: [
        'pdf', 'copy', 'csv', 'excel', 'print'
      ],
      drawCallback: commonDrawCallback
    });

    $('#alignsociological').DataTable({
      "lengthMenu": [
        [5,10, 50, 100, 250, -1],
        [5,10, 50, 100, 250, "All"]
      ], // page length options

      dom: 'lBfrtip',
      buttons: [
        'pdf', 'copy', 'csv', 'excel', 'print'
      ],
      drawCallback: commonDrawCallback
    });
    $('#alignphysiological ').DataTable({
      "lengthMenu": [
        [5,10, 50, 100, 250, -1],
        [5,10, 50, 100, 250, "All"]
      ], // page length options

      dom: 'lBfrtip',
      buttons: [
        'pdf', 'copy', 'csv', 'excel', 'print'
      ],
      drawCallback: commonDrawCallback
    });
    $('#alignpsychological ').DataTable({
      "lengthMenu": [
        [5,10, 50, 100, 250, -1],
        [5,10, 50, 100, 250, "All"]
      ], // page length options

      dom: 'lBfrtip',
      buttons: [
        'pdf', 'copy', 'csv', 'excel', 'print'
      ],
      drawCallback: commonDrawCallback
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
      buttons: [
        'pdf', 'copy', 'csv', 'excel', 'print'
      ],
      drawCallback: commonDrawCallback


    });
    $('#alignreport').DataTable({dom: '',});
  });
  $(document).ready(function() {
    $('#align2').DataTable({


      "lengthMenu": [
        [5,10, 50, 100, 250, -1],
        [5,10, 50, 100, 250, "All"]
      ], // page length options

      dom: 'lBfrtip',
      buttons: [
        'pdf', 'copy', 'csv', 'excel', 'print'
      ],
      drawCallback: commonDrawCallback


    });

  });
  $(document).ready(function() {
    $('#align3').DataTable({


      "lengthMenu": [
        [5,10, 50, 100, 250, -1],
        [5,10, 50, 100, 250, "All"]
      ], // page length options

      dom: 'lBfrtip',
      buttons: [
        'pdf', 'copy', 'csv', 'excel', 'print'
      ],
      drawCallback: commonDrawCallback


    });

  });
  $(document).ready(function() {
    $('#align4').DataTable({


      "lengthMenu": [
        [5,10, 50, 100, 250, -1],
        [5,10, 50, 100, 250, "All"]
      ], // page length options

      dom: 'lBfrtip',
      buttons: [
        'pdf', 'copy', 'csv', 'excel', 'print'
      ],
      drawCallback: commonDrawCallback


    });

  });
  $(document).ready(function() {
    $('#align5').DataTable({


      "lengthMenu": [
        [5,10, 50, 100, 250, -1],
        [5,10, 50, 100, 250, "All"]
      ], // page length options

      dom: 'lBfrtip',
      buttons: [
        'pdf', 'copy', 'csv', 'excel', 'print'
      ],
      drawCallback: commonDrawCallback


    });

  });
  $(document).ready(function() {
    $('#align6').DataTable({


      "lengthMenu": [
        [5,10, 50, 100, 250, -1],
        [5,10, 50, 100, 250, "All"]
      ], // page length options

      dom: 'lBfrtip',
      buttons: [
        'pdf', 'copy', 'csv', 'excel', 'print'
      ],
      drawCallback: commonDrawCallback


    });

  });
  $(document).ready(function() {
    $('#align7').DataTable({


      "lengthMenu": [
        [5,10, 50, 100, 250, -1],
        [5,10, 50, 100, 250, "All"]
      ], // page length options

      dom: 'lBfrtip',
      buttons: [
        'pdf', 'copy', 'csv', 'excel', 'print'
      ],
      drawCallback: commonDrawCallback


    });

  });
  $(document).ready(function() {
    $('#align8').DataTable({


      "lengthMenu": [
        [5,10, 50, 100, 250, -1],
        [5,10, 50, 100, 250, "All"]
      ], // page length options

      dom: 'lBfrtip',
      buttons: [
        'pdf', 'copy', 'csv', 'excel', 'print'
      ],
      drawCallback: commonDrawCallback


    });

  });

  $(document).ready(function() {
    $('#align9').DataTable({


      "lengthMenu": [
        [5,10, 50, 100, 250, -1],
        [5,10, 50, 100, 250, "All"]
      ], // page length options

      dom: 'lBfrtip',
      buttons: [
        'pdf', 'copy', 'csv', 'excel', 'print'
      ],
      drawCallback: commonDrawCallback


    });

  });

  $(document).ready(function() {
    $('#align10').DataTable({


      "lengthMenu": [
        [20, 50, 100, 250, -1],
        [20, 50, 100, 250, "All"]
      ], // page length options

      dom: 'lBfrtip',
      buttons: [
        'pdf', 'copy', 'csv', 'excel', 'print'
      ],
      drawCallback: commonDrawCallback


    });

  });

  $(document).ready(function() {
    $('#align11').DataTable({


      "lengthMenu": [
        [20, 50, 100, 250, -1],
        [20, 50, 100, 250, "All"]
      ], // page length options

      dom: 'lBfrtip',
      buttons: [
        'pdf', 'copy', 'csv', 'excel', 'print'
      ],
      drawCallback: commonDrawCallback


    });

  });

  $(document).ready(function() {
    $('#length5').DataTable({


      "lengthMenu": [
        [5, 10, 50, 100, 250, -1],
        [5, 10, 50, 100, 250, "All"]
      ], // page length options

      dom: 'lBfrtip',
      buttons: [
        'pdf', 'copy', 'csv', 'excel', 'print'
      ],
      drawCallback: commonDrawCallback


    });

  });
  $(document).ready(function() {
    $('#alignq1').DataTable({


      "lengthMenu": [
        [10, 50, 100, 250, -1],
        [10, 50, 100, 250, "All"]
      ], // page length options

      dom: 'lBfrtip',
      buttons: [
        'pdf', 'copy', 'csv', 'excel', 'print'
      ],
      drawCallback: commonDrawCallback


    });

  });
  $(document).ready(function() {
    $('#alignq2').DataTable({


      "lengthMenu": [
        [10, 50, 100, 250, -1],
        [10, 50, 100, 250, "All"]
      ], // page length options

      dom: 'lBfrtip',
      buttons: [
        'pdf', 'copy', 'csv', 'excel', 'print'
      ],
      drawCallback: commonDrawCallback


    });

  });
  $(document).ready(function() {
    $('#alignq3').DataTable({


      "lengthMenu": [
        [10, 50, 100, 250, -1],
        [10, 50, 100, 250, "All"]
      ], // page length options

      dom: 'lBfrtip',
      buttons: [
        'pdf', 'copy', 'csv', 'excel', 'print'
      ],
      drawCallback: commonDrawCallback


    });

  });

</script>