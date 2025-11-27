@extends('layouts.adminnav')
<style>
  .fc .fc-toolbar>*> :first-child {
    margin-left: -16px;
    margin-top: -18px;
  }

  .fc-prev-button.fc-button.fc-state-default.fc-corner-left.fc-corner-right {
    color: white;
  }

  .fc-next-button.fc-button.fc-state-default.fc-corner-left.fc-corner-right {
    color: white;
  }

  .modal.show .modal-dialog {
    -webkit-transform: none;
    transform: none;
    height: 438px;
  }

  .fc-view>table tr,
  .fc-view>table td {
    border-color: black !important;
    /* border-color: #f2f2f2; */
  }

  .fc-head {
    /* background:#2a0245!important;  */
    font-size: 16px;
  }

  .fc-head-container.fc-widget-header {
    background-color: azure !important;


  }

  .fc-day-header.fc-future {
    color: black !important;
  }

  thead {
    background-color: azure !important;
  }

  td.fc-day.fc-widget-content {
    background-color: white !important;
  }

  tr.disabled {
    background-color: grey;
  }
</style>
<style>
  .fc-view>table tr,
  .fc-view>table td {
    border-color: #f2f2f2;
    background: white;
    border: 1px solid;
  }



  .fc-view>table th {
    border-color: #1c1b1b;
  }


  .fc-toolbar h2 {
    font-size: 25px;
  }

  .fc-day-number {
    color: white !important;
  }

  a.fc-day-number {
    /* color: red; */
    /* background-color: black; */
    color: white;
  }

  td.fc-day-top.fc-mon.fc-past {

    background-color: limegreen;
  }

  td.fc-day-top.fc-tue.fc-past {

    background-color: limegreen;
  }

  .fc-day-top.fc-wed.fc-past {
    background-color: #fd2236;

  }

  td.fc-day-top.fc-thu.fc-past {
    background-color: limegreen;
  }

  .fc-day-top.fc-fri.fc-past {
    background-color: #fd2236;
  }

  .fc-day-top.fc-sat.fc-past {
    background-color: limegreen;
  }

  .fc-day-top.fc-sun.fc-past {
    background-color: limegreen;
  }

  .fc-day.fc-widget-content {
    background-color: #fd2236;
  }

  .fc-prev-button.fc-button.fc-state-default.fc-corner-left.fc-corner-right {
    color: blue;
    background-color: white !important;
  }

  .fc-next-button.fc-button.fc-state-default.fc-corner-left.fc-corner-right {
    color: blue;
    background-color: white !important;
  }

  .fc .fc-toolbar>*> :first-child {
    margin-top: -25px !important;
  }


  .fc-future {

    opacity: 0.5;
  }

  .fc button .fc-icon {
    top: -0.09em;
    color: navy;
    font-size: 28px;
  }

  .fc-left {
    background-color: white;
    color: navy;
  }

  .fc-right {
    background-color: white;
    color: navy;
  }
</style>
@section('content')
<div class="main-content">
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.16/dist/sweetalert2.all.min.js"></script>

  <section class="section">
    <div class="section-body mt-2">
    {{ Breadcrumbs::render('Weekly') }}

      <div class="row">
        @if (session('success'))
        <input type="hidden" name="session_data" id="session_data" class="session_data" value="{{ session('success') }}">
        <script type="text/javascript">
          window.onload = function() {
            var message = $('#session_data').val();
            Swal.fire({
              title: "Success",
              text: message,
              type: "success",
            });
          }
        </script>
        @elseif(session('fail'))
        <input type="hidden" name="session_data" id="session_data1" class="session_data" value="{{ session('fail') }}">
        <script type="text/javascript">
          window.onload = function() {
            var message = $('#session_data1').val();
            Swal.fire({
              title: "Info",
              text: message,
              type: "info",
            });
          }
        </script>
        @endif
        <!-- <a type="button" href="{{route('TherapistInit')}}" value="" class="btn btn-labeled btn-info" title="create" style="background: #044a95 !important; border-color:#a9ca !important; color:white !important;margin: 0 0 2px 15px;">
          <span class="btn-label" style="font-size:15px !important; padding:8px !important"><i class="fa fa-plus"></i></span><span style="font-size:15px !important; padding:8px !important">Therapist Initiation</span></a>
          -->

        <div class="col-lg-12 text-center">
          <h4 style="color:darkblue;">Therapist Mapping</h4>
        </div>
        <div class="col-12">

          <div class="card">
            <div class="card-body">

              <!-- <form method="POST" action="{{ route('ovm1.store') }}"> onsubmit="return validateForm()" -->
              <form action="{{route('compass_store')}}" method="POST" id="compassinitiate" enctype="multipart/form-data">

                @csrf


                <div class="row is-coordinate">
                  <div class="col-md-4">
                    <div class="form-group">
                      <label class="control-label required">Enrollment Number</label>
                      <select class="form-control" name="enrollment_child_num" id="enrollment_child_num" onchange=" GetChilddetails()">
                        <option value="">Select Enrollment ID</option>
                        @foreach($rows as $key=>$row)

                        <option value="{{ $row['enrollment_child_num'] }}">{{ $row['enrollment_child_num'] }} ( {{$row['child_name']}} )</option>
                        @endforeach
                      </select>
                    </div>
                  </div>
                  <input type="hidden" name="user_id" id="user_id" value="">
                  <div class="col-md-4">
                    <div class="form-group">
                      <label class="control-label">Child ID</label>
                      <input class="form-control" type="text" id="child_id" name="child_id" placeholder="Child ID" autocomplete="off" readonly>
                      <input type="hidden" id="enrollment_id" name="enrollment_id">
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group">
                      <label class="control-label">Child Name</label>
                      <input class="form-control" type="text" id="child_name" name="child_name" oninput="Childname(event)" maxlength="20" value="" placeholder="Enter Name" autocomplete="off" readonly>
                    </div>
                  </div>

                </div>

              </form>
            </div>
          </div>
        </div>
        <br>

        <div class="col-md-12  text-center" style="padding-top: 1rem;">


          <a type="button" onclick="save()" id="submitbutton" class="btn btn-labeled btn-succes" title="Submit" style="background: green !important; border-color:green !important; color:white !important">
            <span class="btn-label" style="font-size:13px !important;"><i class="fa fa-check"></i></span> Submit</a>

          <a type="button" class="btn btn-labeled back-btn" title="Back" href="{{ route('therapist.index') }}" style="color:white !important">
            <span class="btn-label" style="font-size:13px !important;"><i class="fa fa-arrow-left"></i></span> Back</a>

        </div>

      </div>
    </div>
    <br>


    <div class="col-12" id="weekly" style="display:none;">
      <div class="card">
        <div class="card-body" style="background-color:#008eff99 !important;">
          <div class="row">
            <div class="col-lg-12 text-center">
              <h4 style="color:darkblue;">Therapist Weekly Mapping</h4>
            </div>
          </div>
          <button id="calender_show" href="#addModal" style="display: none;" data-toggle="modal" data-target="#addModal" class="btn btn-primary" title="View" data-toggle="modal" data-target="#templates" style="margin-inline:5px"><i class="fa fa-bars" style="color:white!important"></i></button>

          <div class="offset-5 col-md-4 mt-4">
            <div class="form-group" style="margin-left: -26px !important;margin-right: 107px !important;">
              <input type='month' class="form-control" id='month' name="month" title="Month" value="2022-12" required>
            </div>
          </div>
          <div class="table-wrapper">
            <div class="table-responsive  p-3">
              <table class="table table-bordered ">
                <thead>
                  <tr>
                    <th class="week" style="background-color:red !important;" >Week1</th>

                    <th class="week" style="background-color:red !important;">Week2</th>
                    <th class="week" style="background-color:green !important;">Week3</th>
                    <th class="week">Week4 
                    <button><i class="fa fa-user-md" aria-hidden="true" style="font-size: 22px !important;color:orange !important;"></i></button>

                    <button ><i class="fa fa-clock-o" aria-hidden="true" style="font-size: 22px !important;"></i></button></th>


                  </tr>
                  <tr class="statuscheck">
                    <th style="background-color:grey !important;">Week5</th>
                    <th style="background-color:grey !important;">Week6</th>
                    <th style="background-color:grey !important;">Week7</th>
                    <th style="background-color:grey !important;">Week8
                    <button><i class="fa fa-user-md" aria-hidden="true" style="font-size: 22px !important;color:orange !important;"></i></button>
                    <button><i class="fa fa-clock-o" aria-hidden="true" style="font-size: 22px !important;"></i></button></th>
                  </tr>
                  <tr class="statuscheck">
                    <th style="background-color:grey !important;">Week9</th>
                    <th style="background-color:grey !important;">Week10</th>
                    <th style="background-color:grey !important;">Week11</th>
                    <th style="background-color:grey !important;">Week12
                    <button><i class="fa fa-user-md" aria-hidden="true" style="font-size: 22px !important;color:orange !important;"></i></button>
                    <button><i class="fa fa-clock-o" aria-hidden="true" style="font-size: 22px !important;"></i></button></th>
                  </tr>
                  <tr class="statuscheck">
                    <th style="background-color:grey !important;">Week13</th>
                    <th style="background-color:grey !important;">Week14</th>
                    <th style="background-color:grey!important;">Week15</th>
                    <th style="background-color:grey !important;">Week16
                    <button><i class="fa fa-user-md" aria-hidden="true" style="font-size: 22px !important;color:orange !important;"></i></button>
                    <button><i class="fa fa-clock-o" aria-hidden="true" style="font-size: 22px !important;"></i></button></th>
                  </tr>
                  <tr class="statuscheck">
                    <th style="background-color:grey !important;">Week17</th>
                    <th style="background-color:grey !important;">Week18</th>
                    <th style="background-color:grey !important;">Week19</th>
                    <th style="background-color:grey !important;">Week20
                    <button><i class="fa fa-user-md" aria-hidden="true" style="font-size: 22px !important;color:orange !important;"></i></button>

                    <button><i class="fa fa-clock-o" aria-hidden="true" style="font-size: 22px !important;"></i></button></th>
                  </tr>
                  <tr class="statuscheck">
                    <th style="background-color:grey !important;">Week21</th>
                    <th style="background-color:grey !important;">Week22</th>
                    <th style="background-color:grey !important;">Week23</th>
                    <th style="background-color:grey !important;">Week24
                    <button><i class="fa fa-user-md" aria-hidden="true" style="font-size: 22px !important;color:orange !important;"></i></button>
                    <button><i class="fa fa-clock-o" aria-hidden="true" style="font-size: 22px !important;"></i></button></th>
                  </tr>
                  <tr class="statuscheck">
                    <th style="background-color:grey !important;">Week25</th>
                    <th style="background-color:grey !important;">Week26</th>
                    <th style="background-color:grey !important;">Week27</th>
                    <th style="background-color:grey !important;">Week28
                    <button><i class="fa fa-user-md" aria-hidden="true" style="font-size: 22px !important;color:orange !important;"></i></button>
                    <button><i class="fa fa-clock-o" aria-hidden="true" style="font-size: 22px !important;"></i></button></th>
                  </tr>
                  <tr class="statuscheck">
                    <th style="background-color:grey !important;">Week29</th>
                    <th style="background-color:grey !important;">Week30</th>
                    <th style="background-color:grey !important;">Week31</th>
                    <th style="background-color:grey !important;">Week32
                    <button><i class="fa fa-user-md" aria-hidden="true" style="font-size: 22px !important;color:orange !important;"></i></button>
                    <button><i class="fa fa-clock-o" aria-hidden="true" style="font-size: 22px !important;"></i></button></th>
                  </tr>

                </thead>
                <tbody>


                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</div>

<!-- Modal -->

<div class="modal fade" id="addModal" style="height:100% !important; ">
  <div class="modal-dialog modal-l">
    <div class="modal-content">
      <div class="main-contents" style="width:600px !important;height:30% !important;">
        <section class="section-bordered ">
          <div class="modal-header bg-primary" style=" background-color: rgb(0 103 172) !important;">
            <h4 class="modal-title">Therapist Mapping </h4>
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          </div>
          <div class="modal-body" style="background-color: #edfcff !important;">
            <div class="section-body mt-2">
              <div class="row">
                <div class="col-12">
                  <div class="mt-0 ">
                    <div class="card-body" id="card_header" style="background-color: navy !important;color: white !important;">
                      <div class="row">
                      </div>
                      <div class="calendar">
                        <div id="calendar">
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
    </div>
  </div>
</div>

<script src="https://code.jquery.com/jquery-1.7.2.min.js"></script>
<script type="application/javascript">
  function myFunction(id) {
    swal({
        title: "Confirmation For Delete ?",
        text: "Are You Sure to delete this data.",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: '#DD6B55',
        confirmButtonText: 'Yes, I am sure!',
        cancelButtonText: "No, cancel it!",
        closeOnConfirm: false,
        closeOnCancel: false
      },
      function(isConfirm) {

        if (isConfirm) {
          swal("Deleted!", "Data Deleted successfully!", "success");
          var url = $('#' + id).val();

          window.location.href = url;

        } else {
          swal("Cancelled", "Your file is safe :)", "error");
          e.preventDefault();
        }
      });


  }
</script>
<script>
  function meeting(e) {

    // alert("url");
    window.location.href = "/parents/review/invite";

  }
</script>
<script>
  function getproposaldocument(id) {
    var data = (id);
    $('#modalviewdiv').html('');
    $("#loading_gif").show();
    console.log(id);

    $("#loading_gif").hide();
    var proposaldocuments = "<div class='removeclass' id='modalviewdiv' style=' height:100%'><iframe src='" + data + "' class='document_ifarme_view' style='width:100%; height:100%'></iframe></div>";
    $('.removeclass').remove();
    var document = $('#template').append(proposaldocuments);

  };
</script>
<script>
  setTimeout(func, 2000);

  function func() {
    let url = new URL(window.location.href)

    let message = url.searchParams.get("message2");

    if (message != null) {
      Swal.fire({
        title: "Success",
        text: "Therapist Initiated Successfully",
        icon: "success",
      });
    }
  };
</script>
<style>
  .popoverInfoCalendar i {
    font-size: 14px;
    margin-right: 10px;
    line-height: inherit;
    color: #d3d4da;
  }

  .popoverInfoCalendar p {
    margin-bottom: 1px;
  }

  .popoverDescCalendar {
    margin-top: 12px;
    padding-top: 12px;
    border-top: 1px solid #E3E3E3;
    overflow: hidden;
    display: -webkit-box;
    -webkit-line-clamp: 3;
    -webkit-box-orient: vertical;
  }

  .popover-title {
    background: transparent;
    font-weight: 600;
    padding: 0 !important;
    border: none;
  }

  .popover-content {
    padding: 15px 15px;
    font-family: Roboto;
    font-size: 13px;
  }

  .popover {
    background: #fff !important;
    color: #2E2F34;
    border: none;
    margin-bottom: 10px;
  }

  .popover-header {
    background-color: Violet !important;
    color: white !important;
    text-align: center !important;

  }

  .popoverDescCalendar {
    background-color: #07b7ff !important;
    color: black !important;
  }

  .popoverInfoCalendar {
    background-color: #07b7ff !important;
    color: black !important;
  }

  .popover-body {
    background-color: #07b7ff !important;
    color: black !important;
  }

  .popover-title {
    background: #F7F7FC;
    font-weight: 600;
    padding: 15px 15px 11px;
    border: none;

  }

  /*popover arrows*/
  .popover.top .arrow:after {
    border-top-color: #fff;
  }

  .popover.right .arrow:after {
    border-right-color: #fff;
  }

  .popover.bottom .arrow:after {
    border-bottom-color: #fff;
  }

  .popover.left .arrow:after {
    border-left-color: #fff;
  }

  .popover.bottom .arrow:after {
    border-bottom-color: #fff;
  }

  .popoverTitleCalendar {

    margin-top: 8px;
    padding-bottom: 15px;
  }
</style>

<script>
  $(document).ready(function() {

    const selectrefershbox = document.querySelectorAll('.week1');

    for (let i = 0; i < selectrefershbox.length; i++) {
      //alert(i);
      selectrefershbox[i].addEventListener("click", calendershow);
    }


    const selectrefershbox1 = document.querySelectorAll('.week');

for (let i = 0; i < selectrefershbox1.length; i++) {
  //alert(i);
  selectrefershbox1[i].addEventListener("click", therapist);
}



    //     mobiscroll.eventcalendar('#calendar', {
    //     view: {
    //         calendar:
    //             {
    //                 labels: true,
    //                 type: 'week',
    //                 size: 2
    //             }
    //         }
    // }),

    $('#calendar').fullCalendar({
      header: {
        left: 'prev',
        center: 'title',
        right: 'next',

      },
      eventRender: function(event, element) {
        element.popover({
          title: '<div class="popoverTitleCalendar"style="background-color:black !important;color:white !important;">' + event.title + '</div>',
          content: '<div class="popoverInfoCalendar">' +
            '<p><strong>Child Name:</strong>' + event.childName + '</p>' +
            '<p><strong>Specialization:</strong>' + event.Specialization + '</p>' +
            '<p><strong>Event Date:</strong>' + event.Date + '</p>' +
            '<p><strong>Event Time:</strong>' + event.Time + '</p>' +
            '<div class="popoverDescCalendar"><strong>Status:</strong>' + event.Status + ' </div>' +
            '</div>',
          delay: {
            show: "800",
            hide: "50"
          },
          trigger: 'hover',
          placement: 'top',
          html: true,
          container: 'body'
        });
      },

      eventAfterAllRender: function(view) {

        if ($('.labelweek').length == 0) {
          $('.fc-center').after('<br><div class="labelweek" style="color:white !important;">Week4</div>');
        }
      },
      defaultView: 'basicWeek',


      viewRender: function(view, element) {
        // removeAttribute('data-goto');
        var now = new Date("2022-11-27");
        var end = new Date();
        end.setMonth(now.getMonth() + 8); //Adjust as needed

        if (end < view.end) {
          $("#calendar .fc-next-button").hide();
          return false;
        } else {
          $("#calendar .fc-next-button").show();

        }

        if (view.start < now) {
          $("#calendar .fc-prev-button").hide();
          return false;
        } else {
          $("#calendar .fc-prev-button").show();

        }
      },


      navLinks: true,
      editable: true,
      eventLimit: true,


      events: [{
          id: 998,
          title: 'Sameer Speech',
          url: false,
          start: '2022-12-08',
          display: "background",
          color: "red",

        },
        {
          id: 998,
          title: 'Sameer Speech',
          url: false,
          start: '2022-12-08',
          display: "background",
          color: "red",

        },
        {
          id: 998,
          title: 'Dev Sped',
          url: false,
          start: '2022-12-07',
          display: "background",
          color: "green",
        },
        {
          id: 998,
          title: 'Dev Sped',
          childName: 'Dev',
          Specialization: 'Special Education',
          Date: '11/12/2022',
          Time: '4:30 PM',
          Status: 'Completed',
          url: false,
          start: '2022-12-11',
          display: "background",
          color: "green",

        },
        {
          id: 998,
          title: 'Sameer Sped',
          childName: 'Sameer',
          Specialization: 'Special Education',
          Date: '13/12/2022',
          Time: '2:30 PM',
          Status: 'Hold',
          url: false,
          start: '2022-12-13',
          display: "background",
          color: "red",
        },
        {
          id: 998,
          title: 'Dev Sped',
          childName: 'Dev',
          Specialization: 'Special Education',
          Date: '18/12/2022',
          Time: '4:30 PM',
          Status: 'Completed',
          url: false,
          start: '2022-12-18',
          display: "background",
          color: "green",

        },
        {
          id: 998,
          title: 'Sameer Sped',
          childName: 'Sameer',
          Specialization: 'Special Education',
          Date: '21/12/2022',
          Time: '2:30 PM',
          Status: 'Hold',
          url: false,
          start: '2022-12-21',
          display: "background",
          color: "red",
        },

        {
          id: 998,
          title: 'Dev Sped',
          childName: 'Dev',
          Specialization: 'Special Education',
          Date: '27/12/2022',
          Time: '9:30 PM',
          Status: 'Completed',
          url: false,
          start: '2022-12-27',
          display: "background",
          color: "green",

        },
        {
          id: 998,
          title: 'Sameer Sped',
          childName: 'Sameer',
          Specialization: 'Special Education',
          Date: '25/12/2022',
          Time: '2:30 PM',
          Status: 'Hold',
          url: false,
          start: '2022-12-25',
          display: "background",
          color: "red",
        },

        {
          id: 998,
          title: 'Dev Sped',
          childName: 'Dev',
          Specialization: 'Special Education',
          Date: '08/01/2023',
          Time: '9:30 PM',
          Status: 'Completed',
          url: false,
          start: '2023-01-08',
          display: "background",
          color: "green",

        },
        {
          id: 998,
          title: 'Sameer Sped',
          childName: 'Sameer',
          Specialization: 'Special Education',
          Date: '08/01/2023',
          Time: '2:30 PM',
          Status: 'Hold',
          url: false,
          start: '2023-01-09',
          display: "background",
          color: "red",
        },

        {
          id: 998,
          title: 'Dev Sped',
          childName: 'Dev',
          Specialization: 'Special Education',
          Date: '10/01/2023',
          Time: '9:30 PM',
          Status: 'Completed',
          url: false,
          start: '2023-01-10',
          display: "background",
          color: "green",

        },
       





      ],

      eventClick: function(event) {

        if (event.url) {
          window.location.href = "/therapist/initation";
          return false;
        }
      },

      // $(".fc-day,  .fc-day-top").hover(function(e) {
      //  console.log($(e.currentTarget).data("2022-12-13")); 
      //   }),



    });

    // $('#calendar').find('.fc-day[data-date='+2022-11-05+']').addClass('specificdate');
  });

  var week1 = document.getElementsByClassName('week1');
  week1.addEventListener("click", calendershow)

  function calendershow(e) {


    if ((e.target.tagName != "I") && (e.target.tagName != "BUTTON")) {


      document.getElementById("calender_show").click()
      const myTimeout = setTimeout(myGreeting, 150);

      function myGreeting() {
        document.querySelector(".fc-next-button").click();
      }
      const myTimeoutnew = setTimeout(addlink, 200);
    } 
    else {
      if(e.target.classList[1]=='fa-clock-o')
      {
        meeting();
      }
      else
      {
        window.location.href = "/therapist/review/invite";
      }
      
    }


  }
  var week = document.getElementsByClassName('week');
  week.addEventListener("click", therapist)
  function therapist(e)
  {
    //alert("jcbns");
    //alert(e.target.classList[0]);
    if(e.target.classList[0]=="week")
    {
      window.location.href = "/therapist/initation";
    }
    else {
      if(e.target.classList[1]=='fa-clock-o')
      {
        meeting();
      }
      else
      {
        window.location.href = "/therapist/review/invite";
      }
    }
    //alert(week);
    //console.log(week);
    // if()
   
  }

  function addlink() {
    //alert("hii");
    const link = document.querySelectorAll("[data-goto]");
    console.log(link);
    //document.getElementById(`${refresh_id}`).classList.add("fa-minus-circle");
    //alert(link.length);
    for (let i = 0; i < link.length; i++) {

      link[i].href = "/therapist/initation";
      //link[i].removeAttribute([data-goto]);
      link[i].removeAttribute('data-goto');
    }
  }

  window.onload = function() {
    //alert("hii");

    // selecting the elements for which we want to add a tooltip
    const target = document.querySelector("fc-title");
    const tooltip = document.querySelector("fc-title");

    // change display to 'block' on mouseover
    target.addEventListener('mouseover', () => {
      tooltip.style.display = 'block';
    }, false);

    // change display to 'none' on mouseleave
    target.addEventListener('mouseleave', () => {
      tooltip.style.display = 'none';
    }, false);

  }
</script>

<script type="text/javascript" src="https://cdn.rawgit.com/t4t5/sweetalert/v0.2.0/lib/sweet-alert.min.js"></script>


<script type="text/javascript">
  const iscoordinatorfn = (event) => {
    let coordinatorname = event.target.value;
    let currentcoordinator = event.target.name;
    if (currentcoordinator === "is_coordinator1") {
      let iscoordinater2new = JSON.parse($('#is_coordinator2old').attr('data-attr'));
      intcoordinatorname = parseInt(coordinatorname);
      iscoordinater2new = iscoordinater2new.filter(name => name.id !== intcoordinatorname)
      alternatecoordinator = document.getElementById('is_coordinator2')
      var ddd = '<option value="">Select-IS-Coordinator-2</option>';
      for (i = 0; i < iscoordinater2new.length; i++) {
        ddd += '<option value="' + iscoordinater2new[i].id + '">' + iscoordinater2new[i].name + '</option>';
      }
      let currentcoordinatorname = alternatecoordinator.value;
      alternatecoordinator.innerHTML = "";
      alternatecoordinator.innerHTML = ddd;
      alternatecoordinator.value = currentcoordinatorname;
    } else {
      let iscoordinater1new = JSON.parse($('#is_coordinator1old').attr('data-attr'));
      intcoordinatorname = parseInt(coordinatorname);
      iscoordinater1new = iscoordinater1new.filter(name => name.id !== intcoordinatorname)
      alternatecoordinator = document.getElementById('is_coordinator1');
      var ddd = '<option value="">Select-IS-Coordinator-1</option>';
      for (i = 0; i < iscoordinater1new.length; i++) {
        ddd += '<option value="' + iscoordinater1new[i].id + '">' + iscoordinater1new[i].name + '</option>';
      }
      let currentcoordinatorname = alternatecoordinator.value;
      alternatecoordinator.innerHTML = "";
      alternatecoordinator.innerHTML = ddd;
      alternatecoordinator.value = currentcoordinatorname;
    }
    //...
  }
</script>


<script>
  function newmeeting()

  {
    if (document.getElementById('enrollment_child_num').value == "") {
      Swal.fire("Please Select Enrolment Number: ", "", "error");
      return false;
    }
    document.getElementById('invite').style.display = "block";
  }
</script>

<!-- //validation -->
<script>
  function Childname(event) {
    let value = event.target.value || '';
    value = value.replace(/[^a-z A-Z ]/, '', );
    event.target.value = value;

  }

  function location(event) {
    let value = event.target.value || '';
    value = value.replace(/[^a-z A-Z ]/, '', );
    event.target.value = value;

  }
</script>

<script type="text/javascript">
  $.ajaxSetup({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  });

  function GetChilddetails() {
    var enrollment_child_num = $("select[name='enrollment_child_num']").val();

    if (enrollment_child_num != "") {
      $.ajax({
        url: "{{ url('/userregisterfee/enrollmentlist') }}",
        type: 'POST',
        data: {
          'enrollment_child_num': enrollment_child_num,
          _token: '{{csrf_token()}}'
        }
      }).done(function(data) {
        // var category_id = json.parse(data);
        console.log(data);

        if (data != '[]') {

          // var user_select = data;
          var optionsdata = "";

          document.getElementById('child_id').value = data[0].child_id;
          document.getElementById('child_name').value = data[0].child_name;
          document.getElementById('enrollment_id').value = data[0].enrollment_id;
          document.getElementById('user_id').value = data[0].user_id;


          console.log(data[0].user_id);


        } else {
          document.getElementById('child_name');
          var ddd = '<option value="child_name">Select Enrollment_child_num</option>';
          var demonew = $('#child_name').html(ddd);
        }
      })
    } else {
      document.getElementById('initiated_by');
      var ddd = '<option value="initiated_by">Select Enrollment_child_num</option>';
      var demonew = $('#initiated_by').html(ddd);
    }
  };
</script>
<script>
  function save() {


    var enrollment_child_num = $('#enrollment_child_num').val();

    if (enrollment_child_num == "") {

      Swal.fire("Please Select Enrolment Number", "", "error");
      return false;
    }
    var child_id = $('#child_id').val();
    if (child_id == "") {
      Swal.fire("Please Enter Child ID", "", "error");
      return false;
    }
    var child_name = $('#child_name').val();
    if (child_name == "") {
      Swal.fire("Please Enter Child Name", "", "error");
      return false;
    }

    document.getElementById('weekly').style.display = "block";


  }
</script>
<script type="text/javascript">
  $("#enrollment_child_num").select2({
    tags: false
  });
</script>
<script type="text/javascript">
  $(document).ready(function() {
    $(".statuscheck").attr('disabled', "disabled");
    document.getElementsByClassName("statuscheck").disabled = true;
  });
</script>







@endsection