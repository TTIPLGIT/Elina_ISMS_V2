@extends('layouts.adminnav')


@section('content')
<style>
    * {
        box-sizing: border-box;
        margin: 0;
        padding: 0;
    }

    /* body {
        font-family: helvetica, arial, sans-serif;
        padding: 20px 10px;
        position: relative;
        max-width: 700px;
        margin: 0 auto;
    } */

    fieldset {
        border-radius: 5px;
        padding: 0 20px;
        padding: 10px;
    }

    legend {
        background-color: #4c4c4c;
        color: #ffffff;
        padding: 5px;
        border-radius: 3px;
    }

    input:invalid:required {
        background-color: lightpink;
    }

    .container {
        display: flex;
        gap: 5px;
        justify-content: space-between;
    }

    .container>div {
        flex: 1 auto;
        background-color: lightgreen;
        padding: 5px;
        border-radius: 3px;
    }

    .input {
        border: none;
        border-radius: 4px;
        height: 25px;
        padding: 2px;
        font-size: 0.9em;
    }

    label {
        font-size: 0.9em;
    }

    #submit {
        padding: 0;
    }

    #submit>button {
        background-color: #ccc;
        box-shadow: 2px 2px 5px gray;
        /* width: 100%; */
        height: 100%;
        border: none;
        cursor: pointer;
    }

    #submit>button:active {
        box-shadow: 1px 1px 0px gray;
        background-color: #eee;
    }

    #submit>button:hover {
        background-color: aliceblue;
    }

    .calendar {
        margin: 20px 0;
    }

    .calendar>* {
        margin: 10px 0;
    }

    h1 {
        position: relative;
        background-color: #002180;
        padding: 8px 30px;
        text-align: center;
        color: #fff;
        border-radius: 8px;
    }

    h1 .btn {
        position: absolute;
        top: 20%;
        height: 60%;
        text-shadow: 2px 2px 5px rgb(35, 35, 46);
        border: 0;
        background: none;
        font-size: 1.2em;
        line-height: 0;
        color: lightgreen;
        cursor: pointer;
        opacity: 0.5;
    }

    h1 .btn:active {
        text-shadow: 0 0 2px rgb(35, 35, 46);
        color: #fff;
        opacity: 1;
    }

    h1 .prev {
        left: 10px;
    }

    h1 .next {
        right: 10px;
    }

    .calendar ul {
        list-style-type: none;
        display: grid;
        grid-template-columns: repeat(7, 1fr);
        gap: 1px;
        padding-left: 0;
    }

    .calendar li:nth-child(7n) {
        color: blue;
    }

    .calendar li:nth-child(7n-1) {
        color: red;
    }

    .weekdays {
        text-align: center;
        background-color: rgba(0, 0, 0, 0.1);
        border-top: 2px solid black;
        border-bottom: 2px solid black;
        color: navy;
        padding: 5px;
        font-size: 20px;
        font-weight: 800;
    }

    .days li {
        text-align: right;
        border: 1px solid green;
        background-color: rgba(0, 200, 0, 0.1);
        border-radius: 5px;
        padding: 5px 1% 5px 5px;
        text-align: center;
        font-weight: 600;
    }

    footer {
        font-size: 0.8em;
        text-decoration: underline;
        font-weight: 600;
        background-color: #7fffd4;
        text-align: center;
        padding: 4px;
    }

    footer:hover {
        cursor: pointer;
        text-decoration: none;
    }

    footer:active {
        color: red;
    }

    .yes-label {
        margin-right: 14px;
        font-weight: 700;

    }

    .yesRadio {
        margin-left: 14px;
    }

    .no-label {
        font-weight: 700;
    }
</style>



<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.16/dist/sweetalert2.all.min.js"></script>


<div class="main-content" style="padding-top: 52px !important;">

    <div class="row">

        <div class="col-12 right_align">
            <div class="card">
                <div class="card-body left_align">
                    <div class="col-lg-12 ">

                        <h4 style="color:darkblue;display:flex !important;justify-content:center !important;">Availability Calendar View</h4>
                        </i>
                    </div>
                    <hr>
                    <div class="row is-coordinate" style="margin-top:2rem !important;">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="control-label">Month<span class="error-star" style="color:red;">*</span></label>
                                <select type="month" class="input form-control" id="month" name="month" title="Month" required></select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="control-label">Year<span class="error-star" style="color:red;">*</span></label>
                                <input type="number" class="input form-control" id="year" name="year" title="year" max="2100" min="1582" required>
                            </div>
                        </div>


                        <div class="row text-center">
                            <div class="col-md-12" id="submit">
                                <button style="background-color: #00a65a;border-color: #008d4c;" class="btn btn-success mb-1 submit">Show</button>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <br>
    <div class="card cal">
        <form action="{{route('calendar.store')}}" method="POST" id="submitform" enctype="multipart/form-data">
            <div class="calendar">
                <h1>
                    <!-- <button class="prev btn">&lt;</button> -->
                    <span class="month-year"></span>
                    <!-- <button class="next btn">&gt;</button> -->
                </h1>
                <ul class="weekdays"></ul>
                <ul class="days"></ul>
            </div>
        </form>
        <div class="row text-center">
            <div class="col-md-12">


                <!-- <a type="button" class="btn btn-warning text-white" name="type" value="Saved">Save</a> -->
                <input type="hidden" id="status" value="">
                <a type="button" class="btn btn-success text-white" onclick="submitform()" name="type" value="sent">Submit</a>
                <a type="button" class="btn btn-labeled back-btn" title="Back" style="color:white !important">
                    <span class="btn-label" style="font-size:13px !important;"><i class="fa fa-arrow-left"></i></span>Cancel</a>
            </div>
        </div>
        <br>
    </div>
</div>

<script>
    function submitform() {
        document.getElementById('submitform').submit();
    }
</script>

<script type="text/javascript">
    $("#enrollment_child_num").select2({
        tags: false
    });
</script>

<script>
    $(document).ready(function() {
        var table = $('#example').DataTable({

            'columnDefs': [{
                'targets': [1, 2, 3, 4, 5],
                'orderable': false,
                'searchable': false
            }],
            'rowsGroup': [0],
            'createdRow': function(row, data, dataIndex) {
                // Use empty value in the "Office" column
                // as an indication that grouping with COLSPAN is needed
                if (data[2] === '') {
                    // Add COLSPAN attribute
                    $('td:eq(1)', row).attr('colspan', 5);

                    // Hide required number of columns
                    // next to the cell with COLSPAN attribute
                    $('td:eq(2)', row).css('display', 'none');
                    $('td:eq(3)', row).css('display', 'none');
                    $('td:eq(4)', row).css('display', 'none');
                    $('td:eq(5)', row).css('display', 'none');
                }
            }
        });
    });
</script>


<script>
    const selectMonth = document.querySelector("#month");
    const yearInput = document.querySelector("#year");
    const enterBtn = document.querySelector(".submit");

    //const timeNow = document.querySelector("footer");
    const month_year = document.querySelector(".month-year");

    const months = [
        "January",
        "February",
        "March",
        "April",
        "May",
        "June",
        "July",
        "August",
        "September",
        "October",
        "November",
        "December"
    ];

    // Populate month select button with options
    for (let month of months) {
        const option = document.createElement("option");
        option.textContent = option.value = month;
        selectMonth.appendChild(option);
    }

    // Display current calendar date on page load.
    let now = new Date();
    createCalendar(months[now.getMonth()], now.getFullYear());

    // At the click of the enter button.
    enterBtn.addEventListener("click", (e) => {
        createCalendar(selectMonth.value, yearInput.value);
        e.preventDefault();
    });

    // Add event listener to date footer: return to today when clicked
    timeNow.addEventListener("click", () => {
        now = new Date();
        createCalendar(months[now.getMonth()], now.getFullYear());
    });

    // Add event listener to prev and next month button

    document.querySelector(".prev").addEventListener("click", () => {
        const MonthYear = month_year.textContent.split(" ");
        let month = MonthYear[0],
            year = MonthYear[1];
        let m = months.indexOf(month) - 1;

        if (m < 0) {
            year--;
            createCalendar(months[11], year);
        } else {
            createCalendar(months[m], year);
        }
    });

    document.querySelector(".next").addEventListener("click", () => {
        const MonthYear = month_year.textContent.split(" ");
        let month = MonthYear[0],
            year = MonthYear[1];
        let m = months.indexOf(month) + 1;

        if (m > 11) {
            year++;
            createCalendar(months[0], year);
        } else {
            createCalendar(months[m], year);
        }
    });

    // User input validation: disable enter btn if input invalid
    yearInput.addEventListener("input", () => {
        if (yearInput.validity.rangeUnderflow || yearInput.validity.rangeOverflow) {
            yearInput.setCustomValidity("Input must be within 1582 and 2100");
            yearInput.reportValidity();
            enterBtn.disabled = true;
        } else {
            yearInput.setCustomValidity("");
            enterBtn.disabled = false;
        }
    });

    // Changes the time display on the red footer every second
    setInterval(() => {
        now = new Date();
        timeNow.textContent = `${now.toDateString()}, ${now.toLocaleTimeString()}`;
    }, 1000);

    //
    function createCalendar(month, year) {
        /* List out the number of days in month of year. */

        // Validates inputs entered from the browser console. Just for debugging sakes.
        if (!months.includes(month) || year < 1582 || year > 2100) {
            console.log("Error in createCalendar: Invalid input.");
            return;
        }

        // Update the values on the form
        selectMonth.value = month;
        yearInput.value = year;

        month_year.textContent = `${month} ${year}`;

        const weekdays = document.querySelector(".weekdays");
        weekdays.innerHTML = "";
        for (let i of ["Mon", "Tue", "Wed", "Thur", "Fri", "Sat", "Sun"]) {
            const weekday = document.createElement("li");
            weekday.textContent = i;
            weekdays.appendChild(weekday);
        }

        let countdays = 0,
            daysOfMonth,
            flag = false;
        // This loop counts the days from 1900 up to the month in the given year
        for (let yyyy = 1; yyyy <= year; yyyy++) {
            for (let mm = 0; mm < 12; mm++) {
                if (mm === 1) {
                    // February
                    if ((yyyy % 4 === 0 && yyyy % 100 !== 0) || yyyy % 400 === 0) {
                        // Leap year
                        daysOfMonth = 29;
                    } else {
                        // other year
                        daysOfMonth = 28;
                    }
                } else if ([8, 3, 5, 10].includes(mm)) {
                    daysOfMonth = 30;
                } else {
                    daysOfMonth = 31;
                }
                for (let dd = 1; dd <= daysOfMonth; dd++) {
                    countdays++;
                }
                if (yyyy === Number(year) && mm === months.indexOf(month)) {
                    flag = true;
                    break;
                }
            }
            if (flag) break;
        }

        const days = document.querySelector(".days");
        days.innerHTML = "";
        // Fill blank days of month
        for (let i = 1; i <= (countdays - daysOfMonth) % 7; i++) {
            const day = document.createElement("li");
            day.textContent = "";
            day.style.backgroundColor = "white";
            day.style.borderColor = "lightgreen";
            days.appendChild(day);
        }

        function getMonthIndex(monthName) {
            const months = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
            const monthIndex = months.findIndex(month => month.toLowerCase() === monthName.toLowerCase());
            if (monthIndex === -1) {
                throw new Error('Invalid month name');
            }
            return String(monthIndex + 4).padStart(2, '0');
        }

        for (let i = 1; i <= daysOfMonth; i++) {
            var monthIndex = getMonthIndex(month);
            console.log(monthIndex);

            const day = document.createElement("li");
            day.textContent = i.toString();
            const yesRadio = document.createElement("input");
            document.createElement("input");
            yesRadio.type = "radio";
            yesRadio.name = "date["+`${year}-${monthIndex}-${i}`+"]";
            // yesRadio.name = `day-${i}-answer`;
            yesRadio.classList.add("yesRadio");
            yesRadio.value = "yes";
            yesRadio.checked = true;
            day.appendChild(yesRadio);

            const yesLabel = document.createElement("label");

            yesLabel.setAttribute("for", `day-${i}-yes`);
            yesLabel.classList.add("yes-label");
            yesLabel.textContent = "Yes";
            day.appendChild(yesLabel);
            const noRadio = document.createElement("input");
            noRadio.type = "radio";
            noRadio.name = "date["+`${year}-${monthIndex}-${i}`+"]";
            // noRadio.name = `day-${i}-answer`;
            noRadio.value = "no";
            day.appendChild(noRadio);

            const noLabel = document.createElement("label");
            noLabel.setAttribute("for", `day-${i}-no`);
            noLabel.textContent = "No";
            noLabel.classList.add("no-label");
            day.appendChild(noLabel);

            days.appendChild(day);

            if (
                Number(year) === now.getFullYear() &&
                month === months[now.getMonth()] &&
                i === now.getDate()
            ) {
                day.style.backgroundColor = "lightskyblue";
                day.style.boxShadow = "2px 2px 5px gray";
                day.style.border = "1px solid gray";
            }
        }
    }
</script>
@endsection