@extends('layouts.adminnav')
@section('content')

<style>
  #frname {
    color: red;
  }

  .form-control {
    background-color: #ffffff !important;
  }

  .is-coordinate {
    justify-content: center;
  }
  .main-content{
    padding-top:55px !important;
  }

  .centerid {
    width: 100%;
    text-align: center;
  }

  #invite {
    display: none;
  }

  #co_one,
  #co_two {
    padding: 0 0 0 5px;
    background: transparent;
  }
</style>

<style>
    .fc-view>table td {
        height: 50px !important;
    }
    .fc-row.fc-week.fc-widget-content {
        height: 80px !important;
    }
    .section>*:first-child
    {
        margin-top: 270px;
    }

    #calendar {
        background: white;
        padding: 5px;
        margin: 27px auto;
        padding: 15px;
        width:100%;
        height:60%;
    
    }

    .fc-view>table tr,
    .fc-view>table td {
        border-color: #f2f2f2;
        background: white;
        border: 1px solid;
    }

    .fc-scroller.fc-day-grid-container {
        height: 500px !important;
    }

    .fc-view>table th {
        border-color: #1c1b1b;
    }

    .fc-toolbar.fc-header-toolbar {
        margin: 10px 0 10px 0px;
    }
    .fc-toolbar h2 {
        font-size: 25px;
    }
    .fc-day-number
    {
        color:white !important;
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
    .fc-day-top.fc-wed.fc-past
    {
        background-color: #fd2236;
        
    }
    td.fc-day-top.fc-thu.fc-past
     {
    background-color: limegreen;
    }
    .fc-day-top.fc-fri.fc-past
{
    background-color: #fd2236;
}
.fc-day-top.fc-sat.fc-past
{
    background-color: limegreen;
}
.fc-day-top.fc-sun.fc-past
{
    background-color: limegreen;
}

.fc-day.fc-widget-content {
    background-color: #fd2236;
}

.fc-unthemed td.fc-today
{
    background-color: skyblue; 
}
.fc-day[data-date="2022-11-05"]
{
     background-color: pink !important;
     background:yellow !important;
     color:red !important;

}
.fc-row .fc-content-skeleton td.fc-day-top.fc-future
{
  background-color: #1a1a1a;
}
.fc-future
{
 
  opacity:0.3;
}
.fc-day-header {
    font-size: 25px !important;
    font-weight: 600 !important;
}
.fc button .fc-icon {
    top: -0.09em;
    color: navy;
    font-size: 28px;
}
.fc-left
{
  background-color: #c9dcf5;
}
.fc-right
{
  background-color: #c9dcf5;
}

#998
{
    background-color: green;
}
</style>
<div class="main-content" style="position:absolute !important; z-index: -1!important; ">

  <!-- Main Content -->
  <section class="section">
  

  <div class="section-body mt-1">

  {{ Breadcrumbs::render('viewcalendar') }}
  <h5 class="text-center" style="color:darkblue">HOME TRACKER SCHEDULER</h5>   
    
  <div class="row">
        <div class="col-12">

          <div class="card">
            <div class="card-body" style="padding-bottom: 0px !important;"> 
            <div class="box-header with-border">
                @csrf

                <div class="row is-coordinate">
                  <div class="col-md-4">
                    <div class="form-group">
                      <label class="control-label">Enrollment ID<span class="error-star" style="color:red;">*</span></label>
                      <input class="form-control default"  type="text" id="enrollment_child_num" name="enrollment_child_num" onchange="GetChilddetails()" value="EN/2022/12/025 (Kaviya)" autocomplete="off" style="background-color:white!important;"readonly> 
                      <!-- <select class="form-control" id="enrollment_child_num" name="enrollment_child_num" onchange="GetChilddetails()" required>
                        <option value="">Select-Enrollment</option>
                        <option>EN/2022/12/025</option>

                      </select> -->
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group">
                      <label class="control-label">Child ID</label>
                      <input class="form-control default" type="text" id="child_id" name="child_id" placeholder="Child ID" autocomplete="off" value="CH/2022/025"style="background-color:white!important;" readonly>
                      <!-- <input type="hidden" id="enrollment_id" name="enrollment_id" autocomplete="off" readonly> -->
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group">
                      <label class="control-label">Child Name</label>
                      <input class="form-control default" type="text" id="child_name" name="child_name" oninput="Childname(event)" maxlength="20"  value="Kaviya" style="background-color:white!important;"autocomplete="off" readonly>
                    </div>
                  </div>


                  <div class="col-md-4">
                    <div class="form-group ">
                      <label class="control-label">IS Co-ordinator<span class="error-star" style="color:red;">*</span></label>
                      <div style="display: flex;">
                      <input class="form-control default" type="text" id="is_coordinator1" name="is_coordinator1" placeholder="Child ID" autocomplete="off" value="Robert"style="background-color:white!important;" readonly>
                        <!-- <select class="form-control" id="is_coordinator1" name="is_coordinator1" onchange="iscoordinatorfn(event)" required>
                          <option>Select-IS-Coordinator</option>
                          <option value="131">Robert</option>


                        </select> -->
                        <button  style="display: none;"id="co_one" title="Availability Calendar" class="btn" data-toggle="modal" data-target="#calModal" type="button">
                          <i style="color: blue;font-size: 20px;" class="fa fa-calendar" aria-hidden="true"></i></button>
                      </div>
                      <input type="hidden" id="is_coordinator1old">
                      <input type="hidden" id="is_coordinator1current">
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group">
                      <label class="control-label">Therapist<span class="error-star" style="color:red;">*</span></label>
                      <div style="display: flex;">
                      <input class="form-control default" type="text" id="is_therapist" name="is_therapist"  autocomplete="off" value="Malini"style="background-color:white!important;" readonly>
                        <!-- <select class="form-control" id="is_coordinator2" name="is_coordinator2" onchange="iscoordinatorfn(event)" required>
                          <option>Select-Therapist</option>
                          <option value="134">Malini</option>
                        </select> -->
                        <button style="display: none;"id="co_two" title="Availability Calendar" class="btn" data-toggle="modal" data-target="#calModal2" type="button">
                          <i style="color: blue;font-size: 20px;" class="fa fa-calendar" aria-hidden="true"></i></button>
                      </div>
                      <input type="hidden" id="is_coordinator2old">
                      <input type="hidden" id="is_coordinator2current">
                    </div>
                  </div>                
                </div>  
          </div>
        </div>
        <div class="calendar">    
        <div id="calendar">
        </div>
   </div>
</section>
</div>



  <!-- <div class="calendar">    
          <div id="calendar">
          </div>
    </div> -->





<script>
    $(document).ready(function() {
        

        $('#calendar').fullCalendar({     
            header: {
                left: 'prev',
                center: 'title',
                right: 'next',
                
            },
            //defaultView: 'basicWeek',
          //   visibleRange: {
          //      start: '2022-11-22',
          //      end: '2022-8-25'
          //  },
    //       dayRender: function (date, cell) {
        
    //     var today = new Date();
    //     var end = new Date();
    //     end.setDate(today.getDate()+7);
        
    //     if (date.getDate() === today.getDate()) {
    //         cell.css("background-color", "red");
    //     }
        
    //     if(date > today && date <= end) {
    //         cell.css("background-color", "yellow");
    //     }
      
    // }, 

       viewRender: function(view,element) {
            var now = new Date("2022-11-27");
            var end = new Date();
            end.setMonth(now.getMonth() + 8); //Adjust as needed

            if ( end < view.end) {
                $("#calendar .fc-next-button").hide();
                return false;
            }
            else {
                $("#calendar .fc-next-button").show();
               
            }

            if ( view.start < now) {
                $("#calendar .fc-prev-button").hide();
                return false;
            }
            else {
                $("#calendar .fc-prev-button").show();
               
            }
     },    
    //  dayRender: function (date, cell) {
    //     cell.css("background-color", "red");
    //    },
    
            // defaultDate: "2022-11-01",
            // minDate:0 ,
          
            // dayRender: function(date, cell) {
            //            var today = $. fullCalendar. moment();
            //            var end = $. fullCalendar. moment(). add(7, 'days');
            //            if (date. get('date') == today. get('date')) {
            //            cell. css("background", "#e8e8e8");
            //    }
            //   },   
            navLinks: true,
            editable: true,
            eventLimit: true,
           
           
            events: [ 
              // {
              //       id: 998,
              //       title: '40/40',
              //       url: true,
              //       start: '2022-10-01',
              //       display:"background",
              //       color:"blue",
                    
              //   }, {
              //       id: 998,
              //       title: '40/40',
              //       url: true,
              //       start: '2022-10-02',
              //       display:"background",
              //       color:"blue",
                    
              //   }, {
              //       id: 998,
              //       title: '40/40',
              //       url: true,
              //       start: '2022-10-03',
              //       display:"background",
              //       color:"blue",
                    
              //   },
              //   {
              //       id: 999,
              //       title: '40/40',
              //       url: true,
              //       start: '2022-10-04',
              //       display:"background",
              //       color:"blue",
                    
                    
              //   }, {
              //       id: 998,
              //       title: '0/40',
              //       url: true,
              //       start: '2022-10-05',
              //       display:"background",
              //       color:"red",
                    
              //   },
              //   {
              //       id: 998,
              //       title: '40/40',
              //       url: true,
              //       start: '2022-10-06',
              //       display:"background",
              //       color:"blue",
                    
              //   },{
              //       id: 998,
              //       title: '20/40',
              //       url: true,
              //       start: '2022-10-07',
              //       display:"background",
              //       color:"orange",
                    
              //   },{
              //       id: 998,
              //       title: '40/40',
              //       url: true,
              //       start: '2022-10-08',
              //       display:"background",
              //       color:"blue",
                    
              //   },{
              //       id: 998,
              //       title: '40/40',
              //       url: true,
              //       start: '2022-10-09',
              //       display:"background",
              //       color:"blue",
                    
              //   },{
              //       id: 998,
              //       title: '40/40',
              //       url: true,
              //       start: '2022-10-10',
              //       display:"background",
              //       color:"blue",
                    
              //   },
              //   {
              //       id: 998,
              //       title: '40/40',
              //       url: true,
              //       start: '2022-10-11',
              //       display:"background",
              //       color:"blue",
                    
              //   },
              //   {
              //       id: 998,
              //       title: '20/40',
              //       url: true,
              //       start: '2022-10-12',
              //       display:"background",
              //       color:"orange",
                    
              //   },
              //   {
              //       id: 998,
              //       title: '40/40',
              //       url: true,
              //       start: '2022-10-13',
              //       display:"background",
              //       color:"blue",
                    
              //   },
              //   {
              //       id: 998,
              //       title: '30/40',
              //       url: true,
              //       start: '2022-10-14',
              //       display:"background",
              //       color:"orange",
                    
              //   },
              //   {
              //       id: 998,
              //       title: '40/40',
              //       url: true,
              //       start: '2022-10-15',
              //       display:"background",
              //       color:"blue",
                    
              //   },
              //   {
              //       id: 998,
              //       title: '40/40',
              //       url: true,
              //       start: '2022-10-16',
              //       display:"background",
              //       color:"blue",
                    
              //   },
              //   {
              //       id: 998,
              //       title: '40/40',
              //       url: true,
              //       start: '2022-10-17',
              //       display:"background",
              //       color:"blue",
                    
              //   },
              //   {
              //       id: 998,
              //       title: '40/40',
              //       url: true,
              //       start: '2022-10-18',
              //       display:"background",
              //       color:"blue",
                    
              //   },
              //   {
              //       id: 998,
              //       title: '10/40',
              //       url: true,
              //       start: '2022-10-19',
              //       display:"background",
              //       color:"orange",
                    
              //   },
              //   {
              //       id: 998,
              //       title: '40/40',
              //       url: true,
              //       start: '2022-10-20',
              //       display:"background",
              //       color:"blue",
                    
              //   },
              //   {
              //       id: 998,
              //       title: '0/40',
              //       url: true,
              //       start: '2022-10-21',
              //       display:"background",
              //       color:"red",
                    
              //   },
              //   {
              //       id: 998,
              //       title: '40/40',
              //       url: true,
              //       start: '2022-10-22',
              //       display:"background",
              //       color:"blue",
                    
              //   },
              //   {
              //       id: 998,
              //       title: '40/40',
              //       url: true,
              //       start: '2022-10-23',
              //       display:"background",
              //       color:"blue",
                   
                    
              //   },
              //   {
              //       id: 998,
              //       title: '40/40',
              //       url: true,
              //       start: '2022-10-24',
              //       display:"background",
              //       color:"blue",
                    
              //   },
              //   {
              //       id: 998,
              //       title: '40/40',
              //       url: true,
              //       start: '2022-10-25',
              //       display:"background",
              //       color:"blue",
                    
              //   },
              //   {
              //       id: 998,
              //       title: '0/40',
              //       url: true,
              //       start: '2022-10-26',
              //       display:"background",
              //       color:"red",
                    
              //   },
              //   {
              //       id: 998,
              //       title: '40/40',
              //       url: true,
              //       start: '2022-10-27',
              //       display:"background",
              //       color:"blue",
                    
              //   },
              //   {
              //       id: 998,
              //       title: '30/40',
              //       url: true,
              //       start: '2022-10-28',
              //       display:"background",
              //       color:"orange",
                    
              //   },
              //   {
              //       id: 998,
              //       title: '40/40',
              //       url: true,
              //       start: '2022-10-29',
              //       display:"background",
              //       color:"blue",
                    
              //   }, {
              //       id: 998,
              //       title: '40/40',
              //       url: true,
              //       start: '2022-10-30',
              //       display:"background",
              //       color:"blue",
                    
              //   }, {
              //       id: 998,
              //       title: '40/40',
              //       url: true,
              //       start: '2022-10-31',
              //       display:"background",
              //       color:"blue",
                    
              //   },
              //   {
              //       id: 998,
              //       title: '40/40',
              //       url: true,
              //       start: '2022-11-01',
              //       display:"background",
              //       color:"blue",
                    
              //   }, {
              //       id: 998,
              //       title: '10/40',
              //       url: true,
              //       start: '2022-11-02',
              //       display:"background",
              //       color:"orange",
                    
              //   }, {
              //       id: 998,
              //       title: '40/40',
              //       url: true,
              //       start: '2022-11-03',
              //       display:"background",
              //       color:"blue",
                    
              //   },
              //   {
              //       id: 999,
              //       title: '10/40',
              //       url: true,
              //       start: '2022-11-04',
              //       display:"background",
              //       color:"orange",
              //       overlap:"false",
                    
              //   }, {
              //       id: 998,
              //       title: '40/40',
              //       url: true,
              //       start: '2022-11-05',
              //       display:"background",
              //       color:"blue",
                    
              //   },
              //   {
              //       id: 998,
              //       title: '40/40',
              //       url: true,
              //       start: '2022-11-06',
              //       display:"background",
              //       color:"blue",
                    
              //   },{
              //       id: 998,
              //       title: '40/40',
              //       url: true,
              //       start: '2022-11-07',
              //       display:"background",
              //       color:"blue",
                    
              //   },{
              //       id: 998,
              //       title: '40/40',
              //       url: true,
              //       start: '2022-11-08',
              //       display:"background",
              //       color:"blue",
                    
              //   },{
              //       id: 998,
              //       title: '0/40',
              //       url: true,
              //       start: '2022-11-09',
              //       display:"background",
              //       color:"red",
                    
              //   },{
              //       id: 998,
              //       title: '40/40',
              //       url: true,
              //       start: '2022-11-10',
              //       display:"background",
              //       color:"blue",
                    
              //   },
              //   {
              //       id: 998,
              //       title: '30/40',
              //       url: true,
              //       start: '2022-11-11',
              //       display:"background",
              //       color:"orange",
                    
              //   },
              //   {
              //       id: 998,
              //       title: '40/40',
              //       url: true,
              //       start: '2022-11-12',
              //       display:"background",
              //       color:"blue",
                    
              //   },
              //   {
              //       id: 998,
              //       title: '40/40',
              //       url: true,
              //       start: '2022-11-13',
              //       display:"background",
              //       color:"blue",
                    
              //   },
              //   {
              //       id: 998,
              //       title: '40/40',
              //       url: true,
              //       start: '2022-11-14',
              //       display:"background",
              //       color:"blue",
                    
              //   },
              //   {
              //       id: 998,
              //       title: '40/40',
              //       url: true,
              //       start: '2022-11-15',
              //       display:"background",
              //       color:"blue",
                    
              //   },
              //   {
              //       id: 998,
              //       title: '20/40',
              //       url: true,
              //       start: '2022-11-16',
              //       display:"background",
              //       color:"orange",
                    
              //   },
              //   {
              //       id: 998,
              //       title: '40/40',
              //       url: true,
              //       start: '2022-11-17',
              //       display:"background",
              //       color:"blue",
                    
              //   },
              //   {
              //       id: 998,
              //       title: '30/40',
              //       url: true,
              //       start: '2022-11-18',
              //       display:"background",
              //       color:"orange",
                    
              //   },
              //   {
              //       id: 998,
              //       title: '40/40',
              //       url: true,
              //       start: '2022-11-19',
              //       display:"background",
              //       color:"blue",
                    
              //   },
              //   {
              //       id: 998,
              //       title: '40/40',
              //       url: true,
              //       start: '2022-11-20',
              //       display:"background",
              //       color:"blue",
                    
              //   },
              //   {
              //       id: 998,
              //       title: '40/40',
              //       url: true,
              //       start: '2022-11-21',
              //       display:"background",
              //       color:"blue",
                    
              //   },
              //   {
              //       id: 998,
              //       title: '40/40',
              //       url: true,
              //       start: '2022-11-22',
              //       display:"background",
              //       color:"blue",
                    
              //   },
              //   {
              //       id: 998,
              //       title: '30/40',
              //       url: true,
              //       start: '2022-11-23',
              //       display:"background",
              //       color:"orange",
                   
                    
              //   },
              //   {
              //       id: 998,
              //       title: '40/40',
              //       url: true,
              //       start: '2022-11-24',
              //       display:"background",
              //       color:"blue",
                    
              //   },
              //   {
              //       id: 998,
              //       title: '0/40',
              //       url: true,
              //       start: '2022-11-25',
              //       display:"background",
              //       color:"red",
                    
              //   },
              //   {
              //       id: 998,
              //       title: '40/40',
              //       url: true,
              //       start: '2022-11-26',
              //       display:"background",
              //       color:"blue",
                    
              //   },
              //   {
              //       id: 998,
              //       title: '40/40',
              //       url: true,
              //       start: '2022-11-27',
              //       display:"background",
              //       color:"blue",
                    
              //   },
                {
                    id: 998,
                    title: '40/40',
                    url: true,
                    start: '2022-11-28',
                    display:"background",
                    color:"blue",
                    
                },
                {
                    id: 998,
                    title: '40/40',
                    url: true,
                    start: '2022-11-29',
                    display:"background",
                    color:"blue",
                    
                },
                {
                    id: 998,
                    title: '0/40',
                    url: true,
                    start: '2022-11-30',
                    display:"background",
                    color:"red",
                    
                },
                {
                    id: 998,
                    title: '40/40',
                    url: true,
                    start: '2022-12-01',
                    display:"background",
                    color:"blue",
                    
                },
                {
                    id: 998,
                    title: '20/40',
                    url: true,
                    start: '2022-12-02',
                    display:"background",
                    color:"orange",
                    
                },
                {
                    id: 998,
                    title: '40/40',
                    url: true,
                    start: '2022-12-03',
                    display:"background",
                    color:"blue",
                    
                },
                {
                    id: 998,
                    title: '40/40',
                    url: true,
                    start: '2022-12-04',
                    display:"background",
                    color:"blue",
                    
                },
                {
                id: 998,
                    title: '40/40',
                    url: true,
                    start: '2022-12-05',
                    display:"background",
                    color:"blue",
                    
                },
                {
                id: 998,
                    title: '40/40',
                    url: true,
                    start: '2022-12-06',
                    display:"background",
                    color:"blue",
                    
                },
                {
                id: 998,
                    title: '20/40',
                    url: true,
                    start: '2022-12-07',
                    display:"background",
                    color:"orange",
                    
                },
                {
                id: 998,
                    title: '40/40',
                    url: true,
                    start: '2022-12-08',
                    display:"background",
                    color:"blue",
                    
                },
                {
                id: 998,
                    title: '0/40',
                    url: true,
                    start: '2022-12-09',
                    display:"background",
                    color:"red",
                    
                },
                {
                id: 998,
                    title: '40/40',
                    url: true,
                    start: '2022-12-10',
                    display:"background",
                    color:"blue",
                    
                },
                {
                id: 998,
                    title: '40/40',
                    url: true,
                    start: '2022-12-11',
                    display:"background",
                    color:"blue",
                    
                },
                {
                id: 998,
                    title: '40/40',
                    url: true,
                    start: '2022-12-12',
                    display:"background",
                    color:"blue",
                    
                },
                {
                id: 998,
                    title: '40/40',
                    url: true,
                    start: '2022-12-13',
                    display:"background",
                    color:"blue",
                    
                },
                {
                id: 998,
                    title: '30/40',
                    url: true,
                    start: '2022-12-14',
                    display:"background",
                    color:"orange",
                    
                },
                {
                id: 998,
                    title: '40/40',
                    url: true,
                    start: '2022-12-15',
                    display:"background",
                    color:"blue",
                    
                },
                {
                id: 998,
                    title: '40/40',
                    url: true,
                    start: '2022-12-16',
                    display:"background",
                    color:"blue",
                    
                },
                {
                id: 998,
                    title: '40/40',
                    url: true,
                    start: '2022-12-17',
                    display:"background",
                    color:"blue",
                    
                },
                {
                id: 998,
                    title: '40/40',
                    url: true,
                    start: '2022-12-18',
                    display:"background",
                    color:"blue",
                    
                },
                {
                id: 998,
                    title: '40/40',
                    url: true,
                    start: '2022-12-19',
                    display:"background",
                    color:"blue",
                    
                },
                {
                id: 998,
                    title: '40/40',
                    url: true,
                    start: '2022-12-20',
                    display:"background",
                    color:"blue",
                    
                },
                {
                    id: 998,
                    title: '0/40',
                    url: true,
                    start: '2022-12-21',
                    display:"background",
                    color:"red",
                    
                },
                {
                    id: 998,
                    title: '40/40',
                    url: true,
                    start: '2022-12-22',
                    display:"background",
                    color:"blue",
                    
                },

                {
                    id: 998,
                    title: '30/40',
                    url: true,
                    start: '2022-12-23',
                    display:"background",
                    color:"orange",
                    
                },

                {
                    id: 998,
                    title: '40/40',
                    url: true,
                    start: '2022-12-24',
                    display:"background",
                    color:"blue",
                    
                },

                {
                    id: 998,
                    title: '40/40',
                    url: true,
                    start: '2022-12-25',
                    display:"background",
                    color:"blue",
                    
                },

                {
                    id: 998,
                    title: '40/40',
                    url: true,
                    start: '2022-12-27',
                    display:"background",
                    color:"blue",
                    
                },
                {
                    id: 998,
                    title: '30/40',
                    url: true,
                    start: '2022-12-28',
                    display:"background",
                    color:"orange",
                    
                },
                {
                    id: 998,
                    title: '40/40',
                    url: true,
                    start: '2022-12-29',
                    display:"background",
                    color:"blue",
                    
                },
                {
                    id: 998,
                    title: '30/40',
                    url: true,
                    start: '2022-12-30',
                    display:"background",
                    color:"orange",
                    
                },
                {
                    id: 998,
                    title: '30/40',
                    url: true,
                    start: '2022-12-31',
                    display:"background",
                    color:"orange",
                    
                },
                {
                    id: 998,
                    title: '40/40',
                    url: true,
                    start: '2023-01-01',
                    display:"background",
                    color:"blue",
                    
                },
                {
                    id: 998,
                    title: '40/40',
                    url: true,
                    start: '2023-01-02',
                    display:"background",
                    color:"blue",
                    
                },

                {
                    id: 998,
                    title: '40/40',
                    url: true,
                    start: '2023-01-03',
                    display:"background",
                    color:"blue",
                    
                },

                {
                    id: 998,
                    title: '30/40',
                    url: true,
                    start: '2023-01-04',
                    display:"background",
                    color:"orange",
                    
                },
                {
                    id: 998,
                    title: '40/40',
                    url: true,
                    start: '2023-01-05',
                    display:"background",
                    color:"blue",
                    
                },

                {
                    id: 998,
                    title: '30/40',
                    url: true,
                    start: '2023-01-06',
                    display:"background",
                    color:"orange",
                    
                },

                {
                    id: 998,
                    title: '40/40',
                    url: true,
                    start: '2023-01-07',
                    display:"background",
                    color:"blue",
                    
                },
                {
                    id: 998,
                    title: '40/40',
                    url: true,
                    start: '2023-01-08',
                    display:"background",
                    color:"blue",
                    
                },
                {
                    id: 998,
                    title: '40/40',
                    url: true,
                    start: '2023-01-09',
                    display:"background",
                    color:"blue",
                    
                },

                {
                    id: 998,
                    title: '40/40',
                    url: true,
                    start: '2023-01-10',
                    display:"background",
                    color:"blue",
                    
                },
                {
                    id: 998,
                    title: '30/40',
                    url: true,
                    start: '2023-01-11',
                    display:"background",
                    color:"orange",
                    
                },
                {
                    id: 998,
                    title: '40/40',
                    url: true,
                    start: '2023-01-12',
                    display:"background",
                    color:"blue",
                    
                },
                {
                    id: 998,
                    title: '30/40',
                    url: true,
                    start: '2023-01-13',
                    display:"background",
                    color:"orange",
                    
                },
                {
                    id: 998,
                    title: '40/40',
                    url: true,
                    start: '2023-01-14',
                    display:"background",
                    color:"blue",
                    
                },

                {
                    id: 998,
                    title: '40/40',
                    url: true,
                    start: '2023-01-15',
                    display:"background",
                    color:"blue",
                    
                },
                {
                    id: 998,
                    title: '40/40',
                    url: true,
                    start: '2023-01-16',
                    display:"background",
                    color:"blue",
                    
                },
                {
                    id: 998,
                    title: '40/40',
                    url: true,
                    start: '2023-01-17',
                    display:"background",
                    color:"blue",
                    
                },
                {
                    id: 998,
                    title: '30/40',
                    url: true,
                    start: '2023-01-18',
                    display:"background",
                    color:"orange",
                    
                },
                {
                    id: 998,
                    title: '40/40',
                    url: true,
                    start: '2023-01-19',
                    display:"background",
                    color:"blue",
                    
                },
                {
                    id: 998,
                    title: '30/40',
                    url: true,
                    start: '2023-01-20',
                    display:"background",
                    color:"orange",
                    
                },
                {
                    id: 998,
                    title: '40/40',
                    url: true,
                    start: '2023-01-21',
                    display:"background",
                    color:"blue",
                    
                },
                {
                    id: 998,
                    title: '40/40',
                    url: true,
                    start: '2023-01-22',
                    display:"background",
                    color:"blue",
                    
                },
                {
                    id: 998,
                    title: '40/40',
                    url: true,
                    start: '2023-01-23',
                    display:"background",
                    color:"blue",
                    
                },
                {
                    id: 998,
                    title: '0/40',
                    url: true,
                    start: '2023-01-24',
                    display:"background",
                    color:"darkmagenta",
                    
                },
                
            ],

            eventClick: function(event) {
                if (event.url) {
                    window.location.href = "/hometracker/parentinitiate/new/12";
                    return false;
                }
            },


        eventRender: function (event, element, view) { 
        // event.start is already a moment.js object
        // we can apply .format()
        
        var dateString = event.start.format("YYYY-MM-DD");
       
        
        $(view.el[0]).find('.fc-day[data-date=' + dateString + ']').css('background-color', '#FAA732');
     }


        });
       
      // $('#calendar').find('.fc-day[data-date='+2022-11-05+']').addClass('specificdate');
    });
</script>
<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/tinymce/4.5.6/tinymce.min.js"></script>
<script src="http://cdnjs.cloudflare.com/ajax/libs/tinymce/4.5.6/jquery.tinymce.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.26.0/moment.min.js"></script> -->
@include('ovm1.cal')
<!-- End -->
<script type="text/javascript" src="https://cdn.rawgit.com/t4t5/sweetalert/v0.2.0/lib/sweet-alert.min.js"></script>

<script type="text/javascript">
  $(document).ready(function() {

    tinymce.init({
      selector: 'textarea#meeting_description',
      height: 180,
      menubar: false,
      branding: false,
      toolbar: 'undo redo | formatselect | ' +
        'bold italic backcolor | alignleft aligncenter ' +
        'alignright alignjustify | bullist numlist outdent indent | ' +
        'removeformat | help',
      content_style: 'body { font-family:Helvetica,Arial,sans-serif; font-size:14px }'
    });
    event.preventDefault()
  });

  const iscoordinatorfn = (event) => {
  
    let coordinatorname = event.target.value;
    let currentcoordinator = event.target.name;
   

    getEventsDB(currentcoordinator);

    //...
  }
</script>

<!-- //validation -->
<script>
  function Childame(event) {
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
          document.getElementById('meeting_to').value = data[0].child_contact_email;
          document.getElementById('enrollment_id').value = data[0].enrollment_id;

          // console.log(data)


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
  function getEventsDB(current_co) {
    
    if (current_co == 'is_coordinator1') {
      var co_one = $('#is_coordinator1').val();
      if (co_one != null) {
        $('#co_one').hide();
        getEventData(co_one, 'col1');
        $('#co_one').show();
      } else {
        $('#co_one').hide();
      }
    } else {
      var co_two = $('#is_coordinator2').val();
      if (co_two != null) {
        $('#co_two').hide();
        getEventData(co_two, 'col2');
        $('#co_two').show();
      } else {
        $('#co_two').hide();
      }
    }
  }

  var data1 = [];
  var data2 = [];

  function getEventData(is_ID, col) {
    

    $.ajax({
      url: '/calendar/event/getdata',
      type: 'GET',
      async: false,
      data: {
        fieldID: is_ID,
        _token: '{{csrf_token()}}'
      }
    }).done(function(data) {
      var response = JSON.parse(data);

      if (col == 'col1') {
        data1 = [];
        for (let index = 0; index < response.length; index++) {
          const eventvalue = response[index];
          data1.push(eventvalue);
        }
        $('#calendar1').html('');
        var calendar = new Calendar('#calendar1', data1);
      } else if (col == 'col2') {
        data2 = [];
        for (let index = 0; index < response.length; index++) {
          const eventvalue = response[index];
          data2.push(eventvalue);
        }
        $('#calendar2').html('');
        var calendar = new Calendar('#calendar2', data2);

      }

    });

  }

  function validateForm(a) {
    var co_one = $('#is_coordinator1').val();
    var co_two = $('#is_coordinator2').val();
    var startdate = $('#meeting_startdate').val();
    data1 = data1.filter(i => startdate.includes(i.idate));
    const data1Len = data1.length;
    if (data1Len >= 2) {
      try {
        swal("IS Co-ordinator-2 has Two Appointment", "", "error");
        return false;
      } catch (err) {
        console.log(err);
        return false;
      }

    }

    
  }

</script>
<style>
    .specificdate
    {
        background-color: orangered;
    }
</style>

@endsection