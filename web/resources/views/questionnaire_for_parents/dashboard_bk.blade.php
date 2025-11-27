@extends('layouts.fullscreen')
@section('content')
<style>
    #align1_length,
    #align1_filter {
        display: none !important;
    }

    .dataTables_paginate {
        padding: 0 !important;
        margin: 0 !important;
        float: left !important;
    }

    .dataTables_paginate {
        display: inline !important;
    }

    .pagination {
        display: inline !important;
        float: right !important;
    }

    .bglred {
        background-color: #ff251b !important;
    }

    .cclr {
        color: #ebebec;
    }



    table.custom,
    tbody,
    tr,
    td {
        word-break: break-all !important
    }

    .main-contents {

        width: 100%;
        /* position: relative; */
    }

    #align td,
    #align th,
    #tableExport td,
    .tableExport td,
    #tableExport th,
    .tableExport th,
    #tableExport1 td,
    #tableExport1 th,
    #align1 td,
    #align1 th,
    #align2 td,
    #align2 th,
    #align3 td,
    #align3 th,
    #align4 td,
    #align4 th {
        padding: 8px !important;
        word-break: break-word !important;

    }
</style>
<style>
    .is-coordinate {
        justify-content: center;
    }

    .fsm {
        margin: 10vh 5vw;
        background-color: blue;
        height: 100px;
        flex: 1;
        display: flex;
        justify-content: center;
        align-items: center;
        flex-direction: column;
        color: #f5f5f5;
        font-size: 1.5rem;
        border-radius: 10px;
        transition: 1s;
        cursor: pointer;
    }

    .fsm.full-screen {
        height: 100vh;
        z-index: 100;
        margin: 0;
        border-radius: 0;
    }

    .fsm.full-screen .fa {
        font-size: 10vw;
    }

    .fsm.full-screen .modal-content {
        height: auto;
        width: auto;
        margin: inital;
    }

    .fsm.full-screen h1.modal-content {
        transition-delay: 0.5s;
        opacity: 1;
    }
</style>
<style>
    .slider {
        height: 100vh;
        width: 100%;
        position: relative;
        margin: auto;
    }

    .slider .cardheight {
        display: none;
        height: 100%;
        width: 100%;
    }

    .slider .cardheight img {
        height: 100%;
        width: 100%;
        filter: contrast(90%);
        object-fit: cover;
    }

    .slider .cardheight .caption {
        position: absolute;
        bottom: 30px;
        left: 50%;
        transform: translateX(-50%);
        font-size: 22px;
        color: #fff;
        padding: 8px 16px;
        background-color: rgba(0, 0, 0, 0.4);
        border-radius: 4px;
    }

    .slider a.prev,
    .slider a.next {
        position: absolute;
        top: 50%;
        font-size: 30px;
        cursor: pointer;
        user-select: none;
        color: #ffffff;
        padding: 12px;
        transition: 0.2s;
    }

    .slider a.prev:hover,
    .slider a.next:hover {
        background-color: rgba(0, 0, 0, 0.4);
        border-radius: 3px;
    }

    .slider .next {
        right: 20px;
    }

    .slider .prev {
        left: 20px;
    }

    .show {
        animation: fade 0.5s ease-out;
    }
</style>
<div class="main-content contentpadding" style="position:absolute; z-index:-1;    padding: 80px 0 0 0;">

    <!-- Main Content -->

    <div class="section-body">
        <h5 class="text-center" style="color:darkblue">Parent Feedback Dashboard</h5>
        <div class="row" style="padding-bottom: 10px;">
            <div class="col-12">
                <div class="card" style="background-color: white; ">
                    <div class="card-body">
                        <form action="" method="post">
                            <div class="row is-coordinate">


                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="control-label required">From</label>
                                        <input class="form-control default" type="text" id="from" name="from" autocomplete="off">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="control-label required">To</label>
                                        <input class="form-control default" type="text" id="to" name="to" autocomplete="off">
                                    </div>
                                </div>
                                <div class="w-100"></div>
                                <div class="tile-footer title-footer-button-alignment" style="padding: 10px;">
                                    <button class="btn btn-success saveButton_form" onclick="save()" type="button" id="saveButton">
                                        <i class="fa fa-fw fa-lg fa-check-circle"></i>Show</button>&nbsp;&nbsp;&nbsp;
                                    <a class="btn btn-primary" href="{{route('home')}}"><i class="fa fa-fw fa-lg fa-times-circle"></i>Cancel</a>&nbsp;&nbsp;&nbsp;
                                    <button class="btn btn-info saveButton_form" type="reset" id="saveButton">
                                        <i class="fa fa-repeat"></i> Reset</button>
                                </div>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
        <div class="col-12">
            <!-- <div class="col-md-3" style="margin: 10px 0 10px 0px;">
        <div class="card cardheight" style="background-color: white; "><i class="fa fa-chevron-left" onclick="hidefunction()" aria-hidden="true" style="float: right;margin: 7px 10px 0px 0px;"></i><br>
        <div id="piechart">            
        </div></div></div> -->
            <!-- <div class="slider">
                <div class="cardheight">
                    <img src="https://picsum.photos/800?t=1" />
                </div>
                <div class="cardheight">
                    <img src="https://picsum.photos/800?t=2" />
                </div>
                <div class="cardheight">
                    <img src="https://picsum.photos/800?t=3" />
                </div>
                <div class="cardheight">
                    <img src="https://picsum.photos/800?t=4" />
                </div>
                <div class="cardheight">
                    <img src="https://picsum.photos/800?t=5" />
                </div>
                <a class="prev">&#10094;</a>
                <a class="next">&#10095;</a>
            </div> -->
            
            <div class="row" style="display: none;" id="graph">
                <a class="prev">&#10094;</a>
                <a class="next">&#10095;</a>
            </div>
        </div>

    </div>


</div>
<script>
    function hidefunction(hideID) {
        // alert(hideID);
        hide = 'divchart'.concat(hideID);
        document.getElementById(hide).style.display = 'none';
    }
</script>
<script>
    const images = document.querySelectorAll(".cardheight"),
        next = document.querySelector(".next"),
        prev = document.querySelector(".prev");

    let current = 0;

    function changeImage() {
        images.forEach(img => {
            img.classList.remove("show");
            img.style.display = "none";
        });

        images[current].classList.add("show");
        images[current].style.display = "block";
    }

    // Calling first time
    changeImage();

    next.addEventListener("click", function() {
        current++;

        if (current > images.length - 1) {
            current = 0;
        } else if (current < 0) {
            current = images.length - 1;
        }

        changeImage();
    });
    prev.addEventListener("click", function() {
        current--;

        if (current > images.length - 1) {
            current = 0;
        } else if (current < 0) {
            current = images.length - 1;
        }

        changeImage();
    });
</script>
<!--  -->

<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

<script>
    $("#from").datepicker({
        dateFormat: 'dd-mm-yy',
    });
    $("#to").datepicker({
        dateFormat: 'dd-mm-yy',
    });
</script>

<!--  -->
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script>
    function save() {
        var from = document.getElementById("from").value;
        // console.log(from);
        if (from == null || from == "") {
            swal.fire("Please Select From Date", "", "error");
            return false;
        }
        var to = document.getElementById("to").value;
        // console.log(to);
        if (to == null || to == "") {
            swal.fire("Please Select To Date", "", "error");
            return false;
        }
        $('#graph').html('');
        $.ajax({
            url: "{{ url('/questionnaire/graph/getdata') }}",
            type: 'POST',
            data: {
                'from': from,
                'to': to,
                _token: '{{csrf_token()}}'
            }
        }).done(function(data) {
            // var category_id = json.parse(data);
            // console.log(data);
            var fieldTypes = data.fieldTypes;
            var checkdata = data.data;
            if (checkdata != '') {

                var data = data.data;
                var dataLenth = data.length;
                //    console.log(dataLenth);
                for (var idk = 0; idk < 1; idk++) {
                    var dataItem1 = data[idk]; //console.log(dataItem1);
                    var dataItemLength1 = Object.keys(dataItem1).length;
                    for (var k = 0; k < dataItemLength1; k++) {
                        var dataItemKey1 = Object.keys(dataItem1)[k]; //console.log(dataItemKey1);
                        var dataItemValue1 = dataItem1[dataItemKey1];
                        window[dataItemKey1] = [];
                        window[dataItemKey1 + "total"] = [];
                        window[dataItemKey1 + "final"] = [];
                        var index = k + 1;
                        var dropdownHtml = '<div class="col-md-3" style="margin: 10px 0 10px 0px;" id="divchart' + index + '"><div class="card cardheight fsm" style="background-color: white; "><i class="fa fa-chevron-left" onclick="hidefunction(' + index + ')" aria-hidden="true" style="float: right;margin: 7px 10px 0px 0px;"></i><br><div id="piechart' + index + '"></div></div></div>';
                        $('#graph').append(dropdownHtml);
                        // 

                        var fsmActual = document.createElement('div');
                        fsmActual.setAttribute('id', 'fsm_actual');
                        document.body.appendChild(fsmActual);
                        var $fsm = document.querySelectorAll('.fsm');
                        // console.log($fsm)
                        var $fsmActual = document.querySelector('#fsm_actual');
                        $fsmActual.style.position = "absolute";

                        var position = {};
                        var size = {};


                        //modal action stuffs
                        var openFSM = function(event) {
                            var $this = event.currentTarget;
                            position = $this.getBoundingClientRect();
                            // console.log(position)
                            size = {
                                width: window.getComputedStyle($this).width,
                                height: window.getComputedStyle($this).height
                            }

                            $fsmActual.style.position = "absolute";
                            $fsmActual.style.top = position.top + 'px';
                            $fsmActual.style.left = position.left + 'px';
                            $fsmActual.style.height = size.height;
                            $fsmActual.style.width = size.width;
                            $fsmActual.style.margin = $this.style.margin;

                            setTimeout(function() {
                                $fsmActual.innerHTML = $this.innerHTML;
                                var classes = $this.classList.value.split(' ');
                                for (var i = 0; i < classes.length; i++) {
                                    $fsmActual.classList.add(classes[i]);
                                }
                                $fsmActual.classList.add('growing');
                                $fsmActual.style.height = '100vh';
                                $fsmActual.style.width = '100vw';
                                $fsmActual.style.top = '0';
                                $fsmActual.style.left = '0';
                                $fsmActual.style.margin = '0';
                            }, 1);

                            setTimeout(function() {
                                $fsmActual.classList.remove('growing');
                                $fsmActual.classList.add('full-screen')
                            }, 1000);
                        };

                        var closeFSM = function(event) {
                            var $this = event.currentTarget;

                            $this.style.height = size.height;
                            $this.style.width = size.width;
                            $this.style.top = position.top + 'px';
                            $this.style.left = position.left + 'px';
                            $this.style.margin = '0';
                            $this.classList.remove('full-screen');
                            $this.classList.add('shrinking');

                            setTimeout(function() {
                                while ($this.firstChild) $this.removeChild($this.firstChild);
                                var classList = $this.classList;
                                while (classList.length > 0) {
                                    classList.remove(classList.item(0));
                                }
                                $this.style = '';;
                            }, 1000);
                        };

                        for (var i = 0; i < $fsm.length; i++) {
                            $fsm[i].addEventListener("click", openFSM);
                        }
                        $fsmActual.addEventListener("click", closeFSM);

                        // 
                    }
                }
                for (var i = 0; i < dataLenth; i++) {
                    var dataItem = data[i];
                    var dataItemLength = Object.keys(dataItem).length;
                    for (var j = 0; j < dataItemLength; j++) {
                        var dataItemKey = Object.keys(dataItem)[j];
                        var dataItemValue = dataItem[dataItemKey];
                        window[dataItemKey].push(dataItemValue);
                    }

                    for (var m = 0; m < dataItemLength; m++) {
                        var dataItemKey2 = Object.keys(dataItem)[m];
                        var dataItemValue2 = dataItem[dataItemKey2];
                        window[dataItemKey2 + "count"] = {};
                        window[dataItemKey2].forEach(function(x) {
                            window[dataItemKey2 + "count"][x] = (window[dataItemKey2 + "count"][x] || 0) + 1;
                        });
                        var entries = Object.entries(window[dataItemKey2 + "count"]);
                        window[dataItemKey2 + "total"].push(entries);
                    }
                }
                // 
                for (var m = 0; m < dataItemLength; m++) {
                    var dataItemKey3 = Object.keys(dataItem)[m];
                    var dataItemValue3 = dataItem[dataItemKey3];
                    // console.log(window[dataItemKey3 + "total"]);
                    // for (var ft = 0; ft < fieldTypes.length; ft++) {
                    //     var question_field_name = fieldTypes[ft].question_field_name;
                    //     var questionnaire_field_types_id = fieldTypes[ft].questionnaire_field_types_id;
                    //     if (question_field_name == dataItemKey3) {
                    //         if (questionnaire_field_types_id != 5) {
                    //             chartType = 'corechart';
                    //         } else {
                    //             chartType = 'piechart';
                    //         }
                    //     }
                    // }
                    var winLength = window[dataItemKey3 + "total"].length;
                    var heder = ['Questions', 'TotalAnswers'];
                    window[dataItemKey3 + "total"][winLength - 1].unshift(heder);

                    window[dataItemKey3 + "final"].push(window[dataItemKey3 + "total"][winLength - 1]);
                }

                google.charts.load('current', {
                    'packages': ['corechart']
                });
                google.charts.setOnLoadCallback(drawChart);

                function drawChart() {
                    for (var m1 = 0; m1 < dataItemLength; m1++) {
                        // alert(m1);
                        var dataItemKey4 = Object.keys(dataItem)[m1];
                        var dataItemValue4 = dataItem[dataItemKey4];
                        // console.log(m1);
                        // console.log(window[dataItemKey4 + "final"]);
                        // console.log(window[dataItemKey4 + "final"][m1]);
                        var winLength1 = window[dataItemKey4 + "final"].length;

                        var data2 = google.visualization.arrayToDataTable(
                            window[dataItemKey4 + "final"][0]
                        );

                        for (var ft = 0; ft < fieldTypes.length; ft++) {
                            var question_field_name = fieldTypes[ft].question_field_name;
                            var questionnaire_field_types_id = fieldTypes[ft].questionnaire_field_types_id;
                            var question = fieldTypes[ft].question;
                            if (question_field_name == dataItemKey4) {
                                break;
                                // if (questionnaire_field_types_id != 5) {
                                //     chartType = 'corechart';
                                //     break;
                                // } else {
                                //     chartType = 'piechart';
                                //     break;
                                // }
                            }
                        }

                        if (questionnaire_field_types_id == 5 || questionnaire_field_types_id == 2) {
                            var view = new google.visualization.DataView(data2);
                            view.setColumns([0, 1,
                                {
                                    calc: "stringify",
                                    sourceColumn: 1,
                                    type: "string",
                                    role: "annotation"
                                }
                            ]);
                            var options = {
                                title: question,
                                bars: 'horizontal',
                            };
                        } else {
                            var options = {
                                title: question
                            };
                        }

                        var txt = 'piechart' + (m1 + 1);
                        if (questionnaire_field_types_id == 5) {
                            var chart = new google.visualization.BarChart(document.getElementById(txt));
                            chart.draw(view, options);
                        } else if (questionnaire_field_types_id == 2) {
                            var chart = new google.visualization.ColumnChart(document.getElementById(txt));
                            chart.draw(view, options);
                        } else {
                            var chart = new google.visualization.PieChart(document.getElementById(txt));
                            chart.draw(data2, options);
                        }
                    }

                }
                // 

            } else {
                swal.fire("No Data Found", "", "error");
                return false;
            }
        })

        $('#graph').show();
    }
</script>
<script>
    var fsmActual = document.createElement('div');
    fsmActual.setAttribute('id', 'fsm_actual');
    document.body.appendChild(fsmActual);
    var $fsm = document.querySelectorAll('.fsm');
    // console.log($fsm)
    var $fsmActual = document.querySelector('#fsm_actual');
    $fsmActual.style.position = "absolute";

    var position = {};
    var size = {};
    //modal action stuffs
    var openFSM = function(event) {
        var $this = event.currentTarget;
        position = $this.getBoundingClientRect();
        // console.log(position)
        size = {
            width: window.getComputedStyle($this).width,
            height: window.getComputedStyle($this).height
        }

        $fsmActual.style.position = "absolute";
        $fsmActual.style.top = position.top + 'px';
        $fsmActual.style.left = position.left + 'px';
        $fsmActual.style.height = size.height;
        $fsmActual.style.width = size.width;
        $fsmActual.style.margin = $this.style.margin;

        setTimeout(function() {
            $fsmActual.innerHTML = $this.innerHTML;
            var classes = $this.classList.value.split(' ');
            for (var i = 0; i < classes.length; i++) {
                $fsmActual.classList.add(classes[i]);
            }
            $fsmActual.classList.add('growing');
            $fsmActual.style.height = '100vh';
            $fsmActual.style.width = '100vw';
            $fsmActual.style.top = '0';
            $fsmActual.style.left = '0';
            $fsmActual.style.margin = '0';
        }, 1);

        setTimeout(function() {
            $fsmActual.classList.remove('growing');
            $fsmActual.classList.add('full-screen')
        }, 1000);
    };

    var closeFSM = function(event) {
        var $this = event.currentTarget;

        $this.style.height = size.height;
        $this.style.width = size.width;
        $this.style.top = position.top + 'px';
        $this.style.left = position.left + 'px';
        $this.style.margin = '0';
        $this.classList.remove('full-screen');
        $this.classList.add('shrinking');

        setTimeout(function() {
            while ($this.firstChild) $this.removeChild($this.firstChild);
            var classList = $this.classList;
            while (classList.length > 0) {
                classList.remove(classList.item(0));
            }
            $this.style = '';;
        }, 1000);
    };

    for (var i = 0; i < $fsm.length; i++) {
        $fsm[i].addEventListener("click", openFSM);
    }
    $fsmActual.addEventListener("click", closeFSM);
</script>
<!-- Pie Chart -->
<!-- <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script type="text/javascript">
    google.charts.load('current', {
        'packages': ['corechart']
    });
    google.charts.setOnLoadCallback(drawChart);

    function drawChart() {

        var data = google.visualization.arrayToDataTable([
            ['Task', 'Hours per Day'],
            ['Work', 11],
            ['Eat', 2],
            ['Commute', 2],
            ['Watch TV', 2],
            ['Sleep', 7]
        ]);

        var options = {
            title: 'Question'
        };

            var txt = 'piechart';
            var chart = new google.visualization.PieChart(document.getElementById(txt));
            chart.draw(data, options);
        
    }
</script> -->
@endsection