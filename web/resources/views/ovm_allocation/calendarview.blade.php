@extends('layouts.fullscreen')
@section('content')



<script src="https://cdn.jsdelivr.net/npm/@fullcalendar/core@4.2.0/main.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@fullcalendar/daygrid@4.2.0/main.js"></script>
<script src="https://fullcalendar.io/releases/timegrid/4.2.0/main.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@fullcalendar/interaction@4.2.0/main.js"></script>
<script src="https://yourwebsite.com/script.js"></script>
<script src="{{ asset('asset/js/jquery.min.js') }}"></script>
<link href="https://cdn.jsdelivr.net/npm/@fullcalendar/core@4.2.0/main.min.css" rel="stylesheet" />
<link href="https://yourwebsite.com/style.css" rel="stylesheet" />
<style>
    .fc-view>table td {
        border-color: grey;

        color: grey;
        text-align: right;
    }

    .fc-dayGridMonth-button.fc-button.fc-button-primary {
        border-radius: 20px;
        background-color: darkorchid;
        font-size: 15px;
    }

    .fc-timeGridWeek-button.fc-button.fc-button-primary {
        border-radius: 20px;
        background-color: darkorchid;
        font-size: 15px;
    }

    .fc-button-group>.fc-button:not(:first-child) {

        border-top-left-radius: none !important;
        border-bottom-left-radius: none !important;
    }

    .fc-view>table th {
        border-color: grey;

        color: white !important;
        font-weight: 700;
        padding: 10px;
        font-family: sans-serif;
    }

    .fc-day-number {
        color: white;
    }

    .fc-today-button.fc-button.fc-button-primary {
        opacity: .65;
        display: none;
    }

    /* .fc-today-button:disabled {
    opacity: .65;
    display: none;
} */
    .fc-prev-button.fc-button.fc-button-primary {
        border-radius: 20px;
        background-color: darkorchid;
        font-size: 15px;

    }

    .fc-next-button.fc-button.fc-button-primary {
        border-radius: 20px;
        background-color: darkorchid;
        font-size: 15px;
        margin-right: 10px;
    }

    .icon-wrapper {
        position: relative;
    }

    .tooltip {
        display: none;
        position: absolute;
        top: 100%;
        left: 50%;
        transform: translateX(-50%);
        background-color: #fff;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.3);
        padding: 10px;
        border-radius: 5px;
    }

    thead {
        background: #1f90bf !important;
        color: white !important;
        font-size: 16px;
    }

    .icon-wrapper:hover .tooltip {
        display: block;
    }

    .scrollable,
    #scroll {
        -ms-overflow-style: none;
        scrollbar-width: none;
        /* height: 300px;  */
        display: flex;
        flex-direction: column;
        overflow-y: scroll;
    }

    .scrollable::-webkit-scrollbar {
        display: none;

    }

    .event {
        position: absolute;
        width: calc(100% - 40px);
        height: 50px;
        margin: 10px 20px;
        padding: 10px;
        border-radius: 5px;
        background-color: #ccc;
        font-size: 14px;
        line-height: 1.5;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }

    .event-group {
        position: relative;
        height: 50px;
    }

    .fc-left {
        visibility: hidden;
    }

    .fc-right {
        font-weight: 700;
        display: flex;
        align-items: baseline;
        flex-direction: column;
    }

    .fc-right>.fc-button-group {
        gap: 6px;
    }

    .label_switch2 {
        /* background: aquamarine; */
        /* padding: 3px; */
        /* border-radius: 22px !important; */
        /* background-color: #0000ff6e; */
        color: black;
        font-weight: 700;
    }

    .label_switch1 {
        /* background: aquamarine; */
        /* padding: 3px; */
        /* border-radius: 22px !important; */
        width: 61px;
        /* background-color: #0000ff6e; */
        color: black;
        font-weight: 700;
    }


    .switch {
        position: relative;
        display: inline-block;
        width: 60px;
        height: 34px;
    }

    .switch input {
        opacity: 0;
        width: 0;
        height: 0;
    }

    .slider {
        position: absolute;
        cursor: pointer;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-color: white;
        -webkit-transition: .4s;
        transition: .4s;
    }

    .slider:before {
        position: absolute;
        content: "";
        height: 26px;
        width: 26px;
        left: 4px;
        bottom: 4px;
        background-color: limegreen;
        -webkit-transition: .4s;
        transition: .4s;
    }

    input:checked+.slider {
        background-color: #2196F3;
    }

    input:focus+.slider {
        box-shadow: 0 0 1px #2196F3;
    }

    input:checked+.slider:before {
        -webkit-transform: translateX(26px);
        -ms-transform: translateX(26px);
        transform: translateX(26px);
    }

    /* input:checked+.slider {
    background-color: #0c1318;
} */

    .slider.round {
        border-radius: 34px;
        border: 1px solid black;
    }

    .slider.round:before {
        border-radius: 50%;
    }

    /* .next {
        margin-left: 5px !important;
        background-color: #1f90bf;
    } */

    .main_div {
        /* gap: 10px; */
        display: flex;
        justify-content: space-around;
        /* justify-content: center; */
        width: 90%;

    }

    .btn-primary {
        background-color: blue;

    }
</style>

<div class="" style="position:absolute !important; z-index: -2!important; ">

    <!-- Main Content -->
    <section class="section">


        <div class="section-body mt-1">


            <div class="row" style="margin-top: 50px !important;">

                <div class="row">
                <a href="{{ url()->previous() }}"type="button" class="btn btn-warning text-white" id="actionButton"style="color:black !important;height: 33px !important;">Back</a>

                    
                    <div class="col-lg-10 text-center mb-4">
                        <h4 style="color:darkblue;">OVM Meeting Schedule Calendar</h4>
                    </div>

                </div>
                <div class="d-flex flex-row align-items-center" style="position:absolute;top:70px;gap:5px;font-weight: 700;">
                    <label>Month</label>
                    <label class="switch">
                        <input type="checkbox" id="calender_view">
                        <span class="slider round"></span>
                    </label>
                    <!-- <label>Week</label> -->
                </div>

                <div>
                    <div id="calendar">

                    </div>
                </div>


            </div>
    </section>
</div>
<div class="modal fade" id="addmodal">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="main-contents">
                <section class="section">
                    <div class="modal-header bg-primary" style=" background-color: rgb(0 103 172) !important;">
                        <h4 class="modal-title">OVM Schedule details</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    </div>
                    <div class="modal-body" style="background-color: #edfcff !important;padding:10px !important;">
                        <div class="section-body mt-2">
                            <div class="row">
                                <div class="col-12">
                                    <div class="mt-0 ">
                                        <div class="card-body" id="card_header" style="padding:0px !important;">
                                            <div class="row">
                                            </div>
                                            <div class="table-wrapper">
                                                <div class="table-responsive  p-2">
                                                    <table class="table table-bordered">
                                                        <thead>
                                                            <tr>
                                                                <th>Sl. No.</th>
                                                                <th>Child Name</th>
                                                                <th>ISCoordinator-1</th>
                                                                <th>ISCoordinator-2</th>
                                                                <th>Type</th>

                                                                <th>Start Date</th>
                                                                <th>Start Time</th>
                                                                <th>End Date</th>
                                                                <th>End Time</th>
                                                                <th>Status</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>


                                                            <tr>
                                                                <td>1</td>
                                                                <td>Kaviya(EN/2022/12/025)</td>
                                                                <td>Robert</td>
                                                                <td>Robert</td>
                                                                <td>05-02-2023</td>
                                                                <td>10:00 AM</td>
                                                                <td>05-02-2023</td>
                                                                <td>11:00 AM</td>
                                                                <td>Completed</td>

                                                            </tr>

                                                            <tr>
                                                                <td>2</td>
                                                                <td>Kaviya(EN/2022/12/025)</td>
                                                                <td>Robert</td>
                                                                <td>Robert</td>
                                                                <td>05-02-2023</td>
                                                                <td>01:00 PM</td>
                                                                <td>05-02-2023</td>
                                                                <td>02:00 PM</td>
                                                                <td>Completed</td>

                                                            </tr>





                                                        </tbody>
                                                    </table>
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


<script>
    const eventsData = <?php echo json_encode($rows['rows'][0]['inprogress_count']); ?>;
    const eventsArray = [];
    const eventalArray = {};
    const colorArray = ['#0665d0', '#F91084', '#67F80E', '#04B9FC', '#FCD604'];
    var colorIndex = 0;
    eventsData.forEach(data => {
        const parts = data.meeting_startdate.split('/');
        const startday = parts[0];
        const startmonth = parts[1];
        const startyear = parts[2];
        const parts1 = data.meeting_enddate.split('/');
        const endday = parts1[0];
        const endmonth = parts1[1];
        const endyear = parts1[2];
        const formattedStartDate = `${startyear}-${startmonth}-${startday}`;
        const formattedEndDate = `${endyear}-${endmonth}-${endday}`;
        if (colorIndex > colorArray.length - 1) {
            colorIndex = 0;
        }

        var colorCode = colorArray[colorIndex];
        const eventObject = {
            title: data.child_name,
            start: formattedStartDate + 'T' + data.meeting_starttime,
            end: formattedEndDate + 'T' + data.meeting_endtime,
            overlap: true,
            color: colorCode,
            description: data.meeting_description,
            type: data.type,
            status: data.meeting_status,
            name: data.name1,
            name2: data.name2,

        };

        eventsArray.push(eventObject);

        const key = formattedStartDate;
        if (!eventalArray[key]) {
            eventalArray[key] = [];
        }

        eventalArray[key].push(eventObject);
        colorIndex++;
    });

    document.addEventListener('DOMContentLoaded', function() {
        var calendarEl = document.getElementById('calendar');
        var calendar = new FullCalendar.Calendar(calendarEl, {
            height: 800,
            plugins: ['dayGrid', 'timeGrid'],
            allDaySlot: false,
            header: {
                left: 'dayGridMonth',
                center: 'title',
                end: '<button type="button" class="fc-button fc-button-primary toggle-month" aria-label="Toggle Month"><i class="fas fa-calendar"></i></button> <button type="button" class="fc-button fc-button-primary toggle-week" aria-label="Toggle Week"><i class="fas fa-bars"></i></button>'
            },
            initialDate: '2012-02-12',
            eventColor: 'green',
            eventClick: function(info) {
                var key = info.event.start.toISOString().split('T')[0];
                const eventsOnSelectedDate = eventalArray[key];
                if (eventsOnSelectedDate && eventsOnSelectedDate.length > 0) {
                    // Display all events for the clicked date
                    console.log(eventsOnSelectedDate, 'event Array');
                    const table = document.querySelector('#addmodal table tbody');
                    // Clear existing rows in the table
                    table.innerHTML = '';
                    eventsOnSelectedDate.forEach((row1, index) => {
                        var formattedStartDate = new Date(row1.start).toLocaleDateString();
                        var formattedStartTime = new Date(row1.start).toLocaleTimeString();

                        var formattedEndDate = new Date(row1.end).toLocaleDateString();
                        var formattedEndTime = new Date(row1.end).toLocaleTimeString();
                        const row2 = table.insertRow();
                        row2.innerHTML = `
                            <td>${index + 1}</td>
                <td>${row1.title}</td>
                <td>${row1.name}</td>
                <td>${row1.name2}</td>
                <td>${row1.type}</td>
                <td>${formattedStartDate}</td>
                <td>${formattedStartTime}</td>
                <td>${formattedEndDate}</td>
                <td>${formattedEndTime}</td>
                <td>${row1.status}</td>
            `;
                    });
                    $('.modal').modal('show');
                    // eventsOnSelectedDate.forEach((row, index) => {
                    //     console.log(row.start, 'start');
                    //     console.log(new Date(row.start), 'start with Date');
                    //     console.log(new Date(row.start).toLocaleTimeString(), 'start with Date and time string');

                    //     var formattedStartDate = new Date(row.start).toLocaleDateString();
                    //     var formattedStartTime = new Date(row.start).toLocaleTimeString();

                    //     var formattedEndDate = new Date(row.end).toLocaleDateString();
                    //     var formattedEndTime = new Date(row.end).toLocaleTimeString();


                    // });
                    //$('.modal').modal('show'); // You can customize this to show events in a modal
                }
            },
            events: eventsArray
        });

        calendar.render();
    });
</script>
<script>
    function calender_view() {
        var calender_view = $('#calender_view').prop('checked');
        //week
        if (calender_view == true) {
            document.querySelector('.fc-timeGridWeek-button').click();

        }
        //month
        else {
            document.querySelector('.fc-dayGridMonth-button').click();

        }

    }
</script>
<script>
    window.onload = function() {
        const container = document.querySelector('.fc-right');
        const previous = document.createElement('label');
        const next = document.createElement('label');
        const time = document.querySelectorAll('.fc-time');
        //alert(time);
        time.textContent = '';
        next.classList.add('next');
        // next.classList.add('btn');
        // next.classList.add('btn-next');
        next.classList.add('label_switch1');


        previous.classList.add('previous');
        // previous.classList.add('btn');
        // previous.classList.add('btn-previous');
        previous.classList.add('label_switch2');

        previous.textContent = 'Prev';
        next.textContent = 'Next';
        const main_div = document.createElement('div');
        main_div.classList.add('main_div');
        // main_div.classList.add('mt-1');

        container.append(main_div);
        const container2 = document.querySelector('.main_div');
        container2.append(previous);
        container2.append(next);
    }
</script>
<style>
    .next {
        margin-left: 5px !important;
        font-weight: 700;
        /* background-color: #1f90bf; */
    }



    .next btn.btn-next .label_switch1 {
        margin-right: -10%;
    }

    .fc button {
        height: auto;
        padding: 6px 16px;
        text-shadow: none;
        border-radius: 0;
    }

    .fc-center {
        color: darkorchid;
        padding-bottom: 36px;
    }
</style>
@endsection