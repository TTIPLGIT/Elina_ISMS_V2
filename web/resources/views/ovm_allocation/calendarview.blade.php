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

    /* Mobile Responsive Overrides */
    @media (max-width: 768px) {
        .main-container-fixed {
            position: relative !important;
            z-index: 1 !important;
            padding: 5px !important;
        }
        
        .section-body {
            padding: 0 !important;
        }

        /* Top Row Fix (Back & Title) */
        .row:has(#actionButton) {
            display: flex !important;
            align-items: center !important;
            margin: 0 !important;
            padding-top: 10px !important;
        }

        #actionButton {
            height: 22px !important;
            font-size: 9px !important;
            padding: 0 8px !important;
            width: auto !important;
            min-width: 45px !important;
            background-color: #ffb822 !important;
            color: black !important;
            margin: 0 10px 0 10px !important; /* Added left margin */
            display: inline-flex !important;
            align-items: center !important;
            justify-content: center !important;
        }

        h4 {
            font-size: 11px !important;
            font-weight: bold !important;
            margin: 0 !important;
            flex-grow: 1 !important;
            text-align: center !important;
        }

        /* Standardizing Prev/Next font to match Heading (11px) */
        .label_switch1, .label_switch2, .next, .previous {
            font-size: 11px !important;
            font-weight: bold !important;
            color: black !important;
            margin: 0 !important;
        }

        /* Reverting Navigation to previous responsive state */
        .fc-header-toolbar {
            display: flex !important;
            flex-direction: column !important;
            align-items: center !important;
            margin-bottom: 5px !important;
            gap: 5px !important;
        }

        .fc-center h2 {
            font-size: 14px !important;
            color: darkorchid !important;
            margin: 0 !important;
        }

        .fc-right {
            display: flex !important;
            flex-direction: column !important;
            align-items: center !important;
            gap: 5px !important;
        }

        .fc-button {
            width: 22px !important; /* Reduced size */
            height: 22px !important;
            padding: 0 !important;
            font-size: 10px !important;
            border-radius: 50% !important;
            background-color: darkorchid !important;
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
            margin-bottom: 2px !important;
        }
        .fc-right, .fc-left {
            display: flex !important;
            justify-content: center !important;
            align-items: center !important;
            width: auto !important;
            visibility: visible !important;
            flex-shrink: 0 !important; /* Prevent shrinking icons */
        }
        .fc-center {
            display: flex !important;
            justify-content: center !important;
            align-items: center !important;
            flex-grow: 1 !important;
            min-width: 0 !important;
        }
        .fc-header-toolbar {
            display: flex !important;
            flex-direction: row !important;
            justify-content: space-between !important;
            align-items: center !important;
            padding: 0 10px !important; /* Balanced 10px padding on both sides */
            margin-bottom: 10px !important;
            flex-wrap: nowrap !important;
        }
        .main_div {
            display: none !important;
        }
        .nav-group {
            display: flex !important;
            flex-direction: column !important; /* Back to icon above text */
            align-items: center !important;
        }
        .fc-button {
            width: 28px !important;
            height: 28px !important;
            padding: 0 !important;
            font-size: 12px !important;
            border-radius: 50% !important;
            background-color: darkorchid !important;
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
            margin-bottom: 2px !important;
        }
        .label_switch1, .label_switch2 {
            font-size: 10px !important;
            font-weight: bold !important;
            color: black !important;
            margin: 0 !important;
        }
        .fc-center h2 {
            font-size: 14px !important;
            color: darkorchid !important;
            margin: 0 !important;
        }
        .fc-today-button {
            display: none !important;
        }

        /* Date & Day Headers - White */
        .fc-view > table thead th {
            background-color: #1f90bf !important;
            color: white !important;
            padding: 4px !important;
            font-size: 10px !important;
        }
        
        .fc-day-number {
            font-size: 10px !important;
            color: white !important;
            font-weight: bold !important;
        }

        /* Event Text - No Word Splitting */
        .fc-event, .fc-title, .fc-time {
            color: black !important;
            font-size: 8px !important;
        }

        .fc-content {
            padding: 2px !important;
            white-space: nowrap !important; /* Stay on one line */
            overflow: hidden !important;
            text-overflow: ellipsis !important; /* Add ... if too long */
            word-break: normal !important;
            line-height: 1.1 !important;
        }

        /* Modal Header - Absolute Alignment */
        .modal-header {
            background-color: #004085 !important;
            color: white !important;
            padding: 10px 15px !important;
            display: flex !important;
            flex-direction: row !important;
            justify-content: space-between !important;
            align-items: center !important;
            width: 100% !important;
        }
        .modal-title {
            font-size: 14px !important;
            color: white !important;
            margin: 0 !important;
            padding: 0 !important;
            text-align: left !important;
            flex-grow: 1 !important;
            white-space: nowrap !important;
        }
        .modal-header .close {
            color: white !important;
            opacity: 1 !important;
            margin: 0 !important;
            padding: 0 0 0 10px !important;
            font-size: 24px !important;
            line-height: 1 !important;
            flex-shrink: 0 !important;
            float: none !important;
        }
        .table#align1 thead th, .table thead th {
            background-color: #004085 !important;
            color: white !important;
            font-size: 8px !important;
            padding: 4px !important;
        }
        .table#align1 tbody td, .table tbody td {
            background-color: #e3f2fd !important;
            color: black !important;
            font-size: 8px !important;
            padding: 4px !important;
            border: 1px solid #dee2e6 !important;
            white-space: nowrap !important; /* Don't split names or data */
            word-break: normal !important;
        }

        /* Restore previous spacing */
        .d-flex.flex-row.align-items-center {
            position: relative !important;
            top: 0 !important;
            margin: 5px 0 5px 10px !important;
            font-size: 10px !important;
            gap: 5px !important;
        }
        .fc-center h2 {
            font-size: 16px !important;
            color: darkorchid !important;
            margin: 5px 0 !important;
            text-align: center !important;
        }
        .switch {
            width: 40px !important;
            height: 20px !important;
        }
        .slider:before {
            height: 14px !important;
            width: 14px !important;
            left: 3px !important;
            bottom: 3px !important;
        }

        /* Force table to fit */
        .fc-scroller {
            height: auto !important;
            overflow: visible !important;
        }
        
        div[style*="z-index: -2"] {
            position: relative !important;
            z-index: 1 !important;
            margin-top: 0 !important;
        }
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
        const leftContainer = document.querySelector('.fc-left');
        const rightContainer = document.querySelector('.fc-right');
        const prevBtn = document.querySelector('.fc-prev-button');
        const nextBtn = document.querySelector('.fc-next-button');
        
        const prevGroup = document.createElement('div');
        prevGroup.classList.add('nav-group');
        const prevLabel = document.createElement('label');
        prevLabel.classList.add('label_switch2');
        prevLabel.textContent = 'Prev';
        
        const nextGroup = document.createElement('div');
        nextGroup.classList.add('nav-group');
        const nextLabel = document.createElement('label');
        nextLabel.classList.add('label_switch1');
        nextLabel.textContent = 'Next';

        if(prevBtn && nextBtn) {
            // Move Prev to Left
            prevGroup.appendChild(prevBtn);
            prevGroup.appendChild(prevLabel);
            leftContainer.innerHTML = '';
            leftContainer.appendChild(prevGroup);
            
            // Move Next to Right
            nextGroup.appendChild(nextBtn);
            nextGroup.appendChild(nextLabel);
            rightContainer.innerHTML = '';
            rightContainer.appendChild(nextGroup);
        }
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