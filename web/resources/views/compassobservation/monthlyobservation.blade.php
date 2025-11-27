@extends('layouts.observation')
@section('content')
<style>
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
</style>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.16/dist/sweetalert2.all.min.js"></script>

<div class="" style="position:absolute !important; z-index: -2!important; ">

    <!-- Main Content -->
    <section class="section">


        <div class="section-body mt-1">


            <!-- <h5 class="text-center" style="color:darkblue">Home Tracker Initiate</h5> -->
            <div class="row" style="margin-top: 50px !important;">
                
                <div class="col-12">

                    <div class="card">
                        <div class="card-body" style="padding-bottom: 0px !important;">
                        <div class="row">
                    <div class="col-lg-12 text-center">
                        <h4 style="color:darkblue;">Consolidated Feedback View(Month)</h4>
                    </div>
                </div>

                            <form action="" method="GET" id="compassobservation" enctype="multipart/form-data">

                                @csrf
                                <div class="row is-coordinate">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label class="control-label">Enrollment ID<span class="error-star" style="color:red;">*</span></label>
                                            <input class="form-control default" type="text" id="enrollment_child_num" name="enrollment_child_num" onchange="GetChilddetails()" value="EN/2022/12/025 (Kaviya)" autocomplete="off" style="background-color: rgb(128 128 128 / 34%) !important;" readonly>

                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label class="control-label">Child ID</label>
                                            <input class="form-control default" type="text" id="child_id" name="child_id" placeholder="Child ID" autocomplete="off" value="CH/2022/025" style="background-color: rgb(128 128 128 / 34%) !important;" readonly>
                                            <!-- <input type="hidden" id="enrollment_id" name="enrollment_id" autocomplete="off" readonly> -->
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label class="control-label">Child Name</label>
                                            <input class="form-control default" type="text" id="child_name" name="child_name" oninput="Childname(event)" maxlength="20" value="Kaviya" style="background-color: rgb(128 128 128 / 34%) !important;" autocomplete="off" readonly>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="control-label">Month</label>
                                        <div style="display: flex;">
                                            <input class="form-control" type="text" id="month" name="month" value="Month1 12-2022" style="background-color: rgb(128 128 128 / 34%) !important;" readonly autocomplete="off">
                                        </div>
                                    </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="form-group ">
                                            <label class="control-label">label<span class="error-star" style="color:red;">*</span></label>
                                            <div style="display: flex;">
                                                <select class="form-control" id="Strength" name="Strength" required onclick="check()">
                                                    <option value="Strength">Strength</option>
                                                    <option value="Stretch">Stretch</option>
                                                    <option value="Opportunity">Opportunity</option>
                                                    <option value="Highlights">Highlights</option>
                                                    <option value="Vitals">Vitals</option>
                                                    <option value="Environmental">Environmental</option>
                                                    <option value="Emotional">Emotional</option>
                                                    <option value="Sociological">Sociological</option>
                                                    <option value="Physiological">Physiological</option>
                                                    <option value="Psychological">Psychological</option>

                                                </select>
                                            </div>
                                        </div>
                                    </div>


                                    <div class="col-md-3 Source">
                                        <div class="form-group ">
                                            <label class="control-label">Source Document<span class="error-star" style="color:red;">*</span></label>
                                            <div style="display: flex;">
                                                <select class="form-control" id="Source" name="Source" required>
                                                    <option>Hometracker(20-12)(20)</option>
                                                    <option>Weekly Feedback(10-12)(20)</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-3 Environment">
                                        <div class="form-group ">
                                            <label class="control-label">Environment<span class="error-star" style="color:red;">*</span></label>
                                            <div style="display: flex;">
                                                <select class="form-control" id="Environment" name="Environment" required>
                                                    <option>Home</option>
                                                    <option>Home-OT</option>
                                                    <option>School-Spl ed</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>


                                    <div class="col-md-3 Record">
                                        <div class="form-group ">


                                            <label class="control-label">Record<span class="error-star" style="color:red;">*</span></label>
                                            <div id="record">
                                                <div>
                                                    <input type="radio" id="contactChoice1" name="contact" value="email" checked>
                                                    <label for="contactChoice1">True</label>
                                                </div>
                                                <div>
                                                    <input type="radio" id="contactChoice2" name="contact" value="phone">
                                                    <label for="contactChoice2">False</label>
                                                </div>


                                            </div>

                                        </div>
                                    </div>


                                </div>

                                <div class="row text-center">
                                    <div class="col-md-12">
                                        <button type="save" class="btn btn-warning" name="type" value="tab1saved" onclick="validateForm(event)">Show</button>
                                        <a type="" href="{{route('monthlytab')}}" class="btn btn-danger text-white">Cancel</a>

                                    </div>
                                </div>
                                <br>
                        </div>


                    </div>



                </div>
            </div>


            <div class="row card col-12" id="search1" style="display:none !important;">
                <div class="card-body">

                    <div class=" col-12 scrollable fixTableHead title-padding">
                        <div class="table-responsive">

                            <table class="table table-bordered" id="align" style="width:100% !important;">
                                <thead>

                                    <tr>

                                        <th rowspan="2" style="width:304px !important;">Strength</th>

                                        <th colspan="1">week1</th>

                                        <th colspan="1">week2</th>
                                        <th colspan="1">week3</th>
                                        <th colspan="1">week4</th>


                                    </tr>


                                    <tr>
                                        <!-- <th style="width:241px !important;">Record</th> -->

                                        <th style="width:1000px !important;">Evidence</th>


                                        <!-- <th style="width:218px !important;">Record</th> -->


                                        <th style="width:1000px !important;">Evidence</th>


                                        <!-- <th style="width:241px !important;">Record</th> -->

                                        <th style="width:1000px !important;">Evidence</th>

                                        <!-- <th style="width:241px !important;">Record</th> -->


                                        <th style="width:1000px !important;">Evidence</th>

                                    </tr>
                                </thead>
                                <tbody>

                                    <tr id="135" class="custom">

                                        <td rowspan="1" class="dan" style="width:304px !important;font-weight: 900 !important;font-size: 17px !important;">Strength1</td>
                                        <!-- <td class="" style="width:241px !important;">true</td> -->
                                        <td class="" style="width:1000px !important;">He directly said no for work though he was aware, he bargained with the adult to do work. He tried to interact with other children. Theatre- He then turned at me and said - "Amma I helped
                                            that aunty" When mother wore saree for a function- "asked me why I was wearing paati's dress" He reasoned out verbally why he did not want to play with balloons</td>

                                        <!-- <td class="" style="width:241px !important;">true</td> -->
                                        <td class="" style="width:1000px !important;">He directly said no for work though he was aware, he bargained with the adult to do work. He tried to interact with other children. Theatre- He then turned at me and said - "Amma I helped
                                            that aunty" When mother wore saree for a function- "asked me why I was wearing paati's dress" He reasoned out verbally why he did not want to play with balloons</td>


                                        <!-- <td class="" style="width:241px !important;">true</td> -->
                                        <td class="" style="width:1000px !important;">He directly said no for work though he was aware, he bargained with the adult to do work. He tried to interact with other children. Theatre- He then turned at me and said - "Amma I helped
                                            that aunty" When mother wore saree for a function- "asked me why I was wearing paati's dress" He reasoned out verbally why he did not want to play with balloons</td>

                                        <!-- <td class="" style="width:241px !important;">true</td> -->
                                        <td class="" style="width:1000px !important;">He directly said no for work though he was aware, he bargained with the adult to do work. He tried to interact with other children. Theatre- He then turned at me and said - "Amma I helped
                                            that aunty" When mother wore saree for a function- "asked me why I was wearing paati's dress" He reasoned out verbally why he did not want to play with balloons</td>



                                    </tr>

                                    <tr id="135" class="custom">
                                        <td rowspan="1" class="dan" style="width:304px !important;font-weight: 900;font-size: 17px;">Strength2</td>
                                        <!-- <td class="" style="width:241px !important;">true</td> -->
                                        <td class="" style="width:1000px !important;">He directly said no for work though he was aware, he bargained with the adult to do work. He tried to interact with other children. Theatre- He then turned at me and said - "Amma I helped
                                            that aunty" When mother wore saree for a function- "asked me why I was wearing paati's dress" He reasoned out verbally why he did not want to play with balloons</td>

                                        <!-- <td class="" style="width:241px !important;">true</td> -->
                                        <td class="" style="width:1000px !important;">He directly said no for work though he was aware, he bargained with the adult to do work. He tried to interact with other children. Theatre- He then turned at me and said - "Amma I helped
                                            that aunty" When mother wore saree for a function- "asked me why I was wearing paati's dress" He reasoned out verbally why he did not want to play with balloons</td>


                                        <!-- <td class="" style="width:241px !important;">true</td> -->
                                        <td class="" style="width:1000px !important;">He directly said no for work though he was aware, he bargained with the adult to do work. He tried to interact with other children. Theatre- He then turned at me and said - "Amma I helped
                                            that aunty" When mother wore saree for a function- "asked me why I was wearing paati's dress" He reasoned out verbally why he did not want to play with balloons</td>

                                        <!-- <td class="" style="width:241px !important;">true</td> -->
                                        <td class="" style="width:1000px !important;">He directly said no for work though he was aware, he bargained with the adult to do work. He tried to interact with other children. Theatre- He then turned at me and said - "Amma I helped
                                            that aunty" When mother wore saree for a function- "asked me why I was wearing paati's dress" He reasoned out verbally why he did not want to play with balloons</td>




                                    </tr>



                                    <tr id="135" class="custom">
                                        <td rowspan="1" class="dan" style="width:304px !important;font-weight: 900;font-size: 17px;">Strength3</td>
                                        <!-- <td class="" style="width:241px !important;">true</td> -->
                                        <td class="" style="width:1000px !important;">He directly said no for work though he was aware, he bargained with the adult to do work. He tried to interact with other children. Theatre- He then turned at me and said - "Amma I helped
                                            that aunty" When mother wore saree for a function- "asked me why I was wearing paati's dress" He reasoned out verbally why he did not want to play with balloons</td>

                                        <!-- <td class="" style="width:241px !important;">true</td> -->
                                        <td class="" style="width:1000px !important;">He directly said no for work though he was aware, he bargained with the adult to do work. He tried to interact with other children. Theatre- He then turned at me and said - "Amma I helped
                                            that aunty" When mother wore saree for a function- "asked me why I was wearing paati's dress" He reasoned out verbally why he did not want to play with balloons</td>


                                        <!-- <td class="" style="width:241px !important;">true</td> -->
                                        <td class="" style="width:1000px !important;">He directly said no for work though he was aware, he bargained with the adult to do work. He tried to interact with other children. Theatre- He then turned at me and said - "Amma I helped
                                            that aunty" When mother wore saree for a function- "asked me why I was wearing paati's dress" He reasoned out verbally why he did not want to play with balloons</td>

                                        <!-- <td class="" style="width:241px !important;">true</td> -->
                                        <td class="" style="width:1000px !important;">He directly said no for work though he was aware, he bargained with the adult to do work. He tried to interact with other children. Theatre- He then turned at me and said - "Amma I helped
                                            that aunty" When mother wore saree for a function- "asked me why I was wearing paati's dress" He reasoned out verbally why he did not want to play with balloons</td>



                                    </tr>


                                    <tr id="135" class="custom">
                                        <td rowspan="1" class="dan" style="width:304px !important;font-weight: 900;font-size: 17px;">Strength4</td>
                                        <!-- <td class="" style="width:241px !important;">true</td> -->
                                        <td class="" style="width:1000px !important;">He directly said no for work though he was aware, he bargained with the adult to do work. He tried to interact with other children. Theatre- He then turned at me and said - "Amma I helped
                                            that aunty" When mother wore saree for a function- "asked me why I was wearing paati's dress" He reasoned out verbally why he did not want to play with balloons</td>

                                        <!-- <td class="" style="width:241px !important;">true</td> -->
                                        <td class="" style="width:1000px !important;">He directly said no for work though he was aware, he bargained with the adult to do work. He tried to interact with other children. Theatre- He then turned at me and said - "Amma I helped
                                            that aunty" When mother wore saree for a function- "asked me why I was wearing paati's dress" He reasoned out verbally why he did not want to play with balloons</td>


                                        <!-- <td class="" style="width:241px !important;">true</td> -->
                                        <td class="" style="width:1000px !important;">He directly said no for work though he was aware, he bargained with the adult to do work. He tried to interact with other children. Theatre- He then turned at me and said - "Amma I helped
                                            that aunty" When mother wore saree for a function- "asked me why I was wearing paati's dress" He reasoned out verbally why he did not want to play with balloons</td>

                                        <!-- <td class="" style="width:241px !important;">true</td> -->
                                        <td class="" style="width:1000px !important;">He directly said no for work though he was aware, he bargained with the adult to do work. He tried to interact with other children. Theatre- He then turned at me and said - "Amma I helped
                                            that aunty" When mother wore saree for a function- "asked me why I was wearing paati's dress" He reasoned out verbally why he did not want to play with balloons</td>



                                    </tr>




                                    <tr id="135" class="custom">
                                        <td rowspan="1" class="dan" style="width:304px !important;font-weight: 900;font-size: 17px;">Strength5</td>
                                        <!-- <td class="" style="width:241px !important;">true</td> -->
                                        <td class="" style="width:1000px !important;">He directly said no for work though he was aware, he bargained with the adult to do work. He tried to interact with other children. Theatre- He then turned at me and said - "Amma I helped
                                            that aunty" When mother wore saree for a function- "asked me why I was wearing paati's dress" He reasoned out verbally why he did not want to play with balloons</td>

                                        <!-- <td class="">true</td> -->
                                        <td class="" style="width:1000px !important;">He directly said no for work though he was aware, he bargained with the adult to do work. He tried to interact with other children. Theatre- He then turned at me and said - "Amma I helped
                                            that aunty" When mother wore saree for a function- "asked me why I was wearing paati's dress" He reasoned out verbally why he did not want to play with balloons</td>


                                        <!-- <td class="">true</td> -->
                                        <td class="" style="width:1000px !important;">He directly said no for work though he was aware, he bargained with the adult to do work. He tried to interact with other children. Theatre- He then turned at me and said - "Amma I helped
                                            that aunty" When mother wore saree for a function- "asked me why I was wearing paati's dress" He reasoned out verbally why he did not want to play with balloons</td>

                                        <!-- <td class="">true</td> -->
                                        <td class="" style="width:1000px !important;">He directly said no for work though he was aware, he bargained with the adult to do work. He tried to interact with other children. Theatre- He then turned at me and said - "Amma I helped
                                            that aunty" When mother wore saree for a function- "asked me why I was wearing paati's dress" He reasoned out verbally why he did not want to play with balloons</td>




                                    </tr>

                                    <tr id="135" class="custom">
                                        <td rowspan="1" class="dan" style="width:304px !important;font-weight: 900;font-size: 17px;">Strength6</td>
                                        <!-- <td class="" style="width:241px !important;">true</td> -->
                                        <td class="" style="width:1000px !important;">He directly said no for work though he was aware, he bargained with the adult to do work. He tried to interact with other children. Theatre- He then turned at me and said - "Amma I helped
                                            that aunty" When mother wore saree for a function- "asked me why I was wearing paati's dress" He reasoned out verbally why he did not want to play with balloons</td>

                                        <!-- <td class="">true</td> -->
                                        <td class="" style="width:1000px !important;">He directly said no for work though he was aware, he bargained with the adult to do work. He tried to interact with other children. Theatre- He then turned at me and said - "Amma I helped
                                            that aunty" When mother wore saree for a function- "asked me why I was wearing paati's dress" He reasoned out verbally why he did not want to play with balloons</td>


                                        <!-- <td class="">true</td> -->
                                        <td class="" style="width:1000px !important;">He directly said no for work though he was aware, he bargained with the adult to do work. He tried to interact with other children. Theatre- He then turned at me and said - "Amma I helped
                                            that aunty" When mother wore saree for a function- "asked me why I was wearing paati's dress" He reasoned out verbally why he did not want to play with balloons</td>

                                        <!-- <td class="">true</td> -->
                                        <td class="" style="width:1000px !important;">He directly said no for work though he was aware, he bargained with the adult to do work. He tried to interact with other children. Theatre- He then turned at me and said - "Amma I helped
                                            that aunty" When mother wore saree for a function- "asked me why I was wearing paati's dress" He reasoned out verbally why he did not want to play with balloons</td>




                                    </tr>

                                    <tr id="135" class="custom">
                                        <td rowspan="1" class="dan" style="width:304px !important;font-weight: 900;font-size: 17px;">Strength7</td>
                                        <!-- <td class="" style="width:241px !important;">true</td> -->
                                        <td class="" style="width:1000px !important;">He directly said no for work though he was aware, he bargained with the adult to do work. He tried to interact with other children. Theatre- He then turned at me and said - "Amma I helped
                                            that aunty" When mother wore saree for a function- "asked me why I was wearing paati's dress" He reasoned out verbally why he did not want to play with balloons</td>

                                        <!-- <td class="">true</td> -->
                                        <td class="" style="width:1000px !important;">He directly said no for work though he was aware, he bargained with the adult to do work. He tried to interact with other children. Theatre- He then turned at me and said - "Amma I helped
                                            that aunty" When mother wore saree for a function- "asked me why I was wearing paati's dress" He reasoned out verbally why he did not want to play with balloons</td>


                                        <!-- <td class="">true</td> -->
                                        <td class="" style="width:1000px !important;">He directly said no for work though he was aware, he bargained with the adult to do work. He tried to interact with other children. Theatre- He then turned at me and said - "Amma I helped
                                            that aunty" When mother wore saree for a function- "asked me why I was wearing paati's dress" He reasoned out verbally why he did not want to play with balloons</td>

                                        <!-- <td class="">true</td> -->
                                        <td class="" style="width:1000px !important;">He directly said no for work though he was aware, he bargained with the adult to do work. He tried to interact with other children. Theatre- He then turned at me and said - "Amma I helped
                                            that aunty" When mother wore saree for a function- "asked me why I was wearing paati's dress" He reasoned out verbally why he did not want to play with balloons</td>




                                    </tr>

                                    <tr id="135" class="custom">
                                        <td rowspan="1" class="dan" style="width:304px !important;font-weight: 900;font-size: 17px;">Strength8</td>
                                        <!-- <td class="" style="width:241px !important;">true</td> -->
                                        <td class="" style="width:1000px !important;">He directly said no for work though he was aware, he bargained with the adult to do work. He tried to interact with other children. Theatre- He then turned at me and said - "Amma I helped
                                            that aunty" When mother wore saree for a function- "asked me why I was wearing paati's dress" He reasoned out verbally why he did not want to play with balloons</td>

                                        <!-- <td class="">true</td> -->
                                        <td class="" style="width:1000px !important;">He directly said no for work though he was aware, he bargained with the adult to do work. He tried to interact with other children. Theatre- He then turned at me and said - "Amma I helped
                                            that aunty" When mother wore saree for a function- "asked me why I was wearing paati's dress" He reasoned out verbally why he did not want to play with balloons</td>


                                        <!-- <td class="">true</td> -->
                                        <td class="" style="width:1000px !important;">He directly said no for work though he was aware, he bargained with the adult to do work. He tried to interact with other children. Theatre- He then turned at me and said - "Amma I helped
                                            that aunty" When mother wore saree for a function- "asked me why I was wearing paati's dress" He reasoned out verbally why he did not want to play with balloons</td>

                                        <!-- <td class="">true</td> -->
                                        <td class="" style="width:1000px !important;">He directly said no for work though he was aware, he bargained with the adult to do work. He tried to interact with other children. Theatre- He then turned at me and said - "Amma I helped
                                            that aunty" When mother wore saree for a function- "asked me why I was wearing paati's dress" He reasoned out verbally why he did not want to play with balloons</td>




                                    </tr>













                                </tbody>
                            </table>

                        </div>
                    </div>
                </div>
            </div>


            <div class="row card col-12" id="search2" style="display:none !important;">
                <div class="card-body">
                    <!-- <div class="row">
                        <div class="col-lg-12 text-center">
                            <h4 style="color:darkblue;">Monthly Observation View</h4>
                        </div>
                    </div> -->
                    <div class=" col-12 scrollable fixTableHead title-padding">
                        <div class="table-responsive">

                            <table class="table table-bordered" id="align2" style="width:100% !important;">
                                <thead>

                                    <tr>

                                        <th rowspan="2" style="width:304px !important;">Stretch</th>

                                        <th colspan="1">week1</th>

                                        <th colspan="1">week2</th>
                                        <th colspan="1">week3</th>
                                        <th colspan="1">week4</th>


                                    </tr>


                                    <tr>
                                        <!-- <th style="width:241px !important;">Record</th> -->

                                        <th style="width:1000px !important;">Evidence</th>


                                        <!-- <th style="width:218px !important;">Record</th> -->


                                        <th style="width:1000px !important;">Evidence</th>


                                        <!-- <th style="width:241px !important;">Record</th> -->

                                        <th style="width:1000px !important;">Evidence</th>

                                        <!-- <th style="width:241px !important;">Record</th> -->


                                        <th style="width:1000px !important;">Evidence</th>

                                    </tr>
                                </thead>
                                <tbody>

                                    <tr id="135" class="custom">

                                        <td rowspan="1" class="dan" style="width:304px !important;font-weight: 900;font-size: 17px;">Stretch1</td>
                                        <!-- <td class="" style="width:241px !important;">true</td> -->
                                        <td class="" style="width:1000px !important;">He directly said no for work though he was aware, he bargained with the adult to do work. He tried to interact with other children. Theatre- He then turned at me and said - "Amma I helped
                                            that aunty" When mother wore saree for a function- "asked me why I was wearing paati's dress" He reasoned out verbally why he did not want to play with balloons</td>

                                        <!-- <td class="" style="width:241px !important;">true</td> -->
                                        <td class="" style="width:1000px !important;">He directly said no for work though he was aware, he bargained with the adult to do work. He tried to interact with other children. Theatre- He then turned at me and said - "Amma I helped
                                            that aunty" When mother wore saree for a function- "asked me why I was wearing paati's dress" He reasoned out verbally why he did not want to play with balloons</td>


                                        <!-- <td class="" style="width:241px !important;">true</td> -->
                                        <td class="" style="width:1000px !important;">He directly said no for work though he was aware, he bargained with the adult to do work. He tried to interact with other children. Theatre- He then turned at me and said - "Amma I helped
                                            that aunty" When mother wore saree for a function- "asked me why I was wearing paati's dress" He reasoned out verbally why he did not want to play with balloons</td>

                                        <!-- <td class="" style="width:241px !important;">true</td> -->
                                        <td class="" style="width:1000px !important;">He directly said no for work though he was aware, he bargained with the adult to do work. He tried to interact with other children. Theatre- He then turned at me and said - "Amma I helped
                                            that aunty" When mother wore saree for a function- "asked me why I was wearing paati's dress" He reasoned out verbally why he did not want to play with balloons</td>



                                    </tr>

                                    <tr id="135" class="custom">
                                        <td rowspan="1" class="dan" style="width:304px !important;font-weight: 900;font-size: 17px;">Stretch2</td>
                                        <!-- <td class="" style="width:241px !important;">true</td> -->
                                        <td class="" style="width:1000px !important;">He directly said no for work though he was aware, he bargained with the adult to do work. He tried to interact with other children. Theatre- He then turned at me and said - "Amma I helped
                                            that aunty" When mother wore saree for a function- "asked me why I was wearing paati's dress" He reasoned out verbally why he did not want to play with balloons</td>

                                        <!-- <td class="" style="width:241px !important;">true</td> -->
                                        <td class="" style="width:1000px !important;">He directly said no for work though he was aware, he bargained with the adult to do work. He tried to interact with other children. Theatre- He then turned at me and said - "Amma I helped
                                            that aunty" When mother wore saree for a function- "asked me why I was wearing paati's dress" He reasoned out verbally why he did not want to play with balloons</td>


                                        <!-- <td class="" style="width:241px !important;">true</td> -->
                                        <td class="" style="width:1000px !important;">He directly said no for work though he was aware, he bargained with the adult to do work. He tried to interact with other children. Theatre- He then turned at me and said - "Amma I helped
                                            that aunty" When mother wore saree for a function- "asked me why I was wearing paati's dress" He reasoned out verbally why he did not want to play with balloons</td>

                                        <!-- <td class="" style="width:241px !important;">true</td> -->
                                        <td class="" style="width:1000px !important;">He directly said no for work though he was aware, he bargained with the adult to do work. He tried to interact with other children. Theatre- He then turned at me and said - "Amma I helped
                                            that aunty" When mother wore saree for a function- "asked me why I was wearing paati's dress" He reasoned out verbally why he did not want to play with balloons</td>




                                    </tr>



                                    <tr id="135" class="custom">
                                        <td rowspan="1" class="dan" style="width:304px !important;font-weight: 900;font-size: 17px;">Stretch3</td>
                                        <!-- <td class="" style="width:241px !important;">true</td> -->
                                        <td class="" style="width:1000px !important;">He directly said no for work though he was aware, he bargained with the adult to do work. He tried to interact with other children. Theatre- He then turned at me and said - "Amma I helped
                                            that aunty" When mother wore saree for a function- "asked me why I was wearing paati's dress" He reasoned out verbally why he did not want to play with balloons</td>

                                        <!-- <td class="" style="width:241px !important;">true</td> -->
                                        <td class="" style="width:1000px !important;">He directly said no for work though he was aware, he bargained with the adult to do work. He tried to interact with other children. Theatre- He then turned at me and said - "Amma I helped
                                            that aunty" When mother wore saree for a function- "asked me why I was wearing paati's dress" He reasoned out verbally why he did not want to play with balloons</td>


                                        <!-- <td class="" style="width:241px !important;">true</td> -->
                                        <td class="" style="width:1000px !important;">He directly said no for work though he was aware, he bargained with the adult to do work. He tried to interact with other children. Theatre- He then turned at me and said - "Amma I helped
                                            that aunty" When mother wore saree for a function- "asked me why I was wearing paati's dress" He reasoned out verbally why he did not want to play with balloons</td>

                                        <!-- <td class="" style="width:241px !important;">true</td> -->
                                        <td class="" style="width:1000px !important;">He directly said no for work though he was aware, he bargained with the adult to do work. He tried to interact with other children. Theatre- He then turned at me and said - "Amma I helped
                                            that aunty" When mother wore saree for a function- "asked me why I was wearing paati's dress" He reasoned out verbally why he did not want to play with balloons</td>



                                    </tr>


                                    <tr id="135" class="custom">
                                        <td rowspan="1" class="dan" style="width:304px !important;font-weight: 900;font-size: 17px;">Stretch4</td>
                                        <!-- <td class="" style="width:241px !important;">true</td> -->
                                        <td class="" style="width:1000px !important;">He directly said no for work though he was aware, he bargained with the adult to do work. He tried to interact with other children. Theatre- He then turned at me and said - "Amma I helped
                                            that aunty" When mother wore saree for a function- "asked me why I was wearing paati's dress" He reasoned out verbally why he did not want to play with balloons</td>

                                        <!-- <td class="" style="width:241px !important;">true</td> -->
                                        <td class="" style="width:1000px !important;">He directly said no for work though he was aware, he bargained with the adult to do work. He tried to interact with other children. Theatre- He then turned at me and said - "Amma I helped
                                            that aunty" When mother wore saree for a function- "asked me why I was wearing paati's dress" He reasoned out verbally why he did not want to play with balloons</td>


                                        <!-- <td class="" style="width:241px !important;">true</td> -->
                                        <td class="" style="width:1000px !important;">He directly said no for work though he was aware, he bargained with the adult to do work. He tried to interact with other children. Theatre- He then turned at me and said - "Amma I helped
                                            that aunty" When mother wore saree for a function- "asked me why I was wearing paati's dress" He reasoned out verbally why he did not want to play with balloons</td>

                                        <!-- <td class="" style="width:241px !important;">true</td> -->
                                        <td class="" style="width:1000px !important;">He directly said no for work though he was aware, he bargained with the adult to do work. He tried to interact with other children. Theatre- He then turned at me and said - "Amma I helped
                                            that aunty" When mother wore saree for a function- "asked me why I was wearing paati's dress" He reasoned out verbally why he did not want to play with balloons</td>



                                    </tr>




                                    <tr id="135" class="custom">
                                        <td rowspan="1" class="dan" style="width:304px !important;font-weight: 900;font-size: 17px;">Stretch5</td>
                                        <!-- <td class="" style="width:241px !important;">true</td> -->
                                        <td class="" style="width:1000px !important;">He directly said no for work though he was aware, he bargained with the adult to do work. He tried to interact with other children. Theatre- He then turned at me and said - "Amma I helped
                                            that aunty" When mother wore saree for a function- "asked me why I was wearing paati's dress" He reasoned out verbally why he did not want to play with balloons</td>

                                        <!-- <td class="">true</td> -->
                                        <td class="" style="width:1000px !important;">He directly said no for work though he was aware, he bargained with the adult to do work. He tried to interact with other children. Theatre- He then turned at me and said - "Amma I helped
                                            that aunty" When mother wore saree for a function- "asked me why I was wearing paati's dress" He reasoned out verbally why he did not want to play with balloons</td>


                                        <!-- <td class="">true</td> -->
                                        <td class="" style="width:1000px !important;">He directly said no for work though he was aware, he bargained with the adult to do work. He tried to interact with other children. Theatre- He then turned at me and said - "Amma I helped
                                            that aunty" When mother wore saree for a function- "asked me why I was wearing paati's dress" He reasoned out verbally why he did not want to play with balloons</td>

                                        <!-- <td class="">true</td> -->
                                        <td class="" style="width:1000px !important;">He directly said no for work though he was aware, he bargained with the adult to do work. He tried to interact with other children. Theatre- He then turned at me and said - "Amma I helped
                                            that aunty" When mother wore saree for a function- "asked me why I was wearing paati's dress" He reasoned out verbally why he did not want to play with balloons</td>




                                    </tr>

                                    <tr id="135" class="custom">
                                        <td rowspan="1" class="dan" style="width:304px !important;font-weight: 900;font-size: 17px;">Stretch6</td>
                                        <!-- <td class="" style="width:241px !important;">true</td> -->
                                        <td class="" style="width:1000px !important;">He directly said no for work though he was aware, he bargained with the adult to do work. He tried to interact with other children. Theatre- He then turned at me and said - "Amma I helped
                                            that aunty" When mother wore saree for a function- "asked me why I was wearing paati's dress" He reasoned out verbally why he did not want to play with balloons</td>

                                        <!-- <td class="">true</td> -->
                                        <td class="" style="width:1000px !important;">He directly said no for work though he was aware, he bargained with the adult to do work. He tried to interact with other children. Theatre- He then turned at me and said - "Amma I helped
                                            that aunty" When mother wore saree for a function- "asked me why I was wearing paati's dress" He reasoned out verbally why he did not want to play with balloons</td>


                                        <!-- <td class="">true</td> -->
                                        <td class="" style="width:1000px !important;">He directly said no for work though he was aware, he bargained with the adult to do work. He tried to interact with other children. Theatre- He then turned at me and said - "Amma I helped
                                            that aunty" When mother wore saree for a function- "asked me why I was wearing paati's dress" He reasoned out verbally why he did not want to play with balloons</td>

                                        <!-- <td class="">true</td> -->
                                        <td class="" style="width:1000px !important;">He directly said no for work though he was aware, he bargained with the adult to do work. He tried to interact with other children. Theatre- He then turned at me and said - "Amma I helped
                                            that aunty" When mother wore saree for a function- "asked me why I was wearing paati's dress" He reasoned out verbally why he did not want to play with balloons</td>




                                    </tr>

                                    <tr id="135" class="custom">
                                        <td rowspan="1" class="dan" style="width:304px !important;font-weight: 900;font-size: 17px;">Stretch7</td>
                                        <!-- <td class="" style="width:241px !important;">true</td> -->
                                        <td class="" style="width:1000px !important;">He directly said no for work though he was aware, he bargained with the adult to do work. He tried to interact with other children. Theatre- He then turned at me and said - "Amma I helped
                                            that aunty" When mother wore saree for a function- "asked me why I was wearing paati's dress" He reasoned out verbally why he did not want to play with balloons</td>

                                        <!-- <td class="">true</td> -->
                                        <td class="" style="width:1000px !important;">He directly said no for work though he was aware, he bargained with the adult to do work. He tried to interact with other children. Theatre- He then turned at me and said - "Amma I helped
                                            that aunty" When mother wore saree for a function- "asked me why I was wearing paati's dress" He reasoned out verbally why he did not want to play with balloons</td>


                                        <!-- <td class="">true</td> -->
                                        <td class="" style="width:1000px !important;">He directly said no for work though he was aware, he bargained with the adult to do work. He tried to interact with other children. Theatre- He then turned at me and said - "Amma I helped
                                            that aunty" When mother wore saree for a function- "asked me why I was wearing paati's dress" He reasoned out verbally why he did not want to play with balloons</td>

                                        <!-- <td class="">true</td> -->
                                        <td class="" style="width:1000px !important;">He directly said no for work though he was aware, he bargained with the adult to do work. He tried to interact with other children. Theatre- He then turned at me and said - "Amma I helped
                                            that aunty" When mother wore saree for a function- "asked me why I was wearing paati's dress" He reasoned out verbally why he did not want to play with balloons</td>




                                    </tr>

                                    <tr id="135" class="custom">
                                        <td rowspan="1" class="dan" style="width:304px !important;font-weight: 900;font-size: 17px;">Stretch8</td>
                                        <!-- <td class="" style="width:241px !important;">true</td> -->
                                        <td class="" style="width:1000px !important;">He directly said no for work though he was aware, he bargained with the adult to do work. He tried to interact with other children. Theatre- He then turned at me and said - "Amma I helped
                                            that aunty" When mother wore saree for a function- "asked me why I was wearing paati's dress" He reasoned out verbally why he did not want to play with balloons</td>

                                        <!-- <td class="">true</td> -->
                                        <td class="" style="width:1000px !important;">He directly said no for work though he was aware, he bargained with the adult to do work. He tried to interact with other children. Theatre- He then turned at me and said - "Amma I helped
                                            that aunty" When mother wore saree for a function- "asked me why I was wearing paati's dress" He reasoned out verbally why he did not want to play with balloons</td>


                                        <!-- <td class="">true</td> -->
                                        <td class="" style="width:1000px !important;">He directly said no for work though he was aware, he bargained with the adult to do work. He tried to interact with other children. Theatre- He then turned at me and said - "Amma I helped
                                            that aunty" When mother wore saree for a function- "asked me why I was wearing paati's dress" He reasoned out verbally why he did not want to play with balloons</td>

                                        <!-- <td class="">true</td> -->
                                        <td class="" style="width:1000px !important;">He directly said no for work though he was aware, he bargained with the adult to do work. He tried to interact with other children. Theatre- He then turned at me and said - "Amma I helped
                                            that aunty" When mother wore saree for a function- "asked me why I was wearing paati's dress" He reasoned out verbally why he did not want to play with balloons</td>




                                    </tr>













                                </tbody>
                            </table>

                        </div>
                    </div>
                </div>
            </div>

            <div class="row card col-12" id="search3" style="display:none !important;">
                <div class="card-body">
                    <!-- <div class="row">
                        <div class="col-lg-12 text-center">
                            <h4 style="color:darkblue;">Monthly Observation View</h4>
                        </div>
                    </div> -->
                    <div class=" col-12 scrollable fixTableHead title-padding">
                        <div class="table-responsive">

                            <table class="table table-bordered" id="align3" style="width:100% !important;">
                                <thead>

                                    <tr>

                                        <th rowspan="2" style="width:310px !important;">Opportunites</th>

                                        <th colspan="1">week1</th>

                                        <th colspan="1">week2</th>
                                        <th colspan="1">week3</th>
                                        <th colspan="1">week4</th>


                                    </tr>


                                    <tr>
                                        <!-- <th style="width:241px !important;">Record</th> -->

                                        <th style="width:1000px !important;">Evidence</th>


                                        <!-- <th style="width:218px !important;">Record</th> -->


                                        <th style="width:1000px !important;">Evidence</th>


                                        <!-- <th style="width:241px !important;">Record</th> -->

                                        <th style="width:1000px !important;">Evidence</th>

                                        <!-- <th style="width:241px !important;">Record</th> -->


                                        <th style="width:1000px !important;">Evidence</th>

                                    </tr>
                                </thead>
                                <tbody>

                                    <tr id="135" class="custom">

                                        <td rowspan="1" class="dan" style="width:403px !important;font-weight: 900;font-size: 17px;">Opportunity1</td>
                                        <!-- <td class="" style="width:241px !important;">true</td> -->
                                        <td class="" style="width:1000px !important;">He directly said no for work though he was aware, he bargained with the adult to do work. He tried to interact with other children. Theatre- He then turned at me and said - "Amma I helped
                                            that aunty" When mother wore saree for a function- "asked me why I was wearing paati's dress" He reasoned out verbally why he did not want to play with balloons</td>

                                        <!-- <td class="" style="width:241px !important;">true</td> -->
                                        <td class="" style="width:1000px !important;">He directly said no for work though he was aware, he bargained with the adult to do work. He tried to interact with other children. Theatre- He then turned at me and said - "Amma I helped
                                            that aunty" When mother wore saree for a function- "asked me why I was wearing paati's dress" He reasoned out verbally why he did not want to play with balloons</td>


                                        <!-- <td class="" style="width:241px !important;">true</td> -->
                                        <td class="" style="width:1000px !important;">He directly said no for work though he was aware, he bargained with the adult to do work. He tried to interact with other children. Theatre- He then turned at me and said - "Amma I helped
                                            that aunty" When mother wore saree for a function- "asked me why I was wearing paati's dress" He reasoned out verbally why he did not want to play with balloons</td>

                                        <!-- <td class="" style="width:241px !important;">true</td> -->
                                        <td class="" style="width:1000px !important;">He directly said no for work though he was aware, he bargained with the adult to do work. He tried to interact with other children. Theatre- He then turned at me and said - "Amma I helped
                                            that aunty" When mother wore saree for a function- "asked me why I was wearing paati's dress" He reasoned out verbally why he did not want to play with balloons</td>



                                    </tr>

                                    <tr id="135" class="custom">
                                        <td rowspan="1" class="dan" style="width:403px !important;font-weight: 900;font-size: 17px;">Opportunity2</td>
                                        <!-- <td class="" style="width:241px !important;">true</td> -->
                                        <td class="" style="width:1000px !important;">He directly said no for work though he was aware, he bargained with the adult to do work. He tried to interact with other children. Theatre- He then turned at me and said - "Amma I helped
                                            that aunty" When mother wore saree for a function- "asked me why I was wearing paati's dress" He reasoned out verbally why he did not want to play with balloons</td>

                                        <!-- <td class="" style="width:241px !important;">true</td> -->
                                        <td class="" style="width:1000px !important;">He directly said no for work though he was aware, he bargained with the adult to do work. He tried to interact with other children. Theatre- He then turned at me and said - "Amma I helped
                                            that aunty" When mother wore saree for a function- "asked me why I was wearing paati's dress" He reasoned out verbally why he did not want to play with balloons</td>


                                        <!-- <td class="" style="width:241px !important;">true</td> -->
                                        <td class="" style="width:1000px !important;">He directly said no for work though he was aware, he bargained with the adult to do work. He tried to interact with other children. Theatre- He then turned at me and said - "Amma I helped
                                            that aunty" When mother wore saree for a function- "asked me why I was wearing paati's dress" He reasoned out verbally why he did not want to play with balloons</td>

                                        <!-- <td class="" style="width:241px !important;">true</td> -->
                                        <td class="" style="width:1000px !important;">He directly said no for work though he was aware, he bargained with the adult to do work. He tried to interact with other children. Theatre- He then turned at me and said - "Amma I helped
                                            that aunty" When mother wore saree for a function- "asked me why I was wearing paati's dress" He reasoned out verbally why he did not want to play with balloons</td>




                                    </tr>



                                    <tr id="135" class="custom">
                                        <td rowspan="1" class="dan" style="width:403px !important;font-weight: 900;font-size: 17px;">Opportunity3</td>
                                        <!-- <td class="" style="width:241px !important;">true</td> -->
                                        <td class="" style="width:1000px !important;">He directly said no for work though he was aware, he bargained with the adult to do work. He tried to interact with other children. Theatre- He then turned at me and said - "Amma I helped
                                            that aunty" When mother wore saree for a function- "asked me why I was wearing paati's dress" He reasoned out verbally why he did not want to play with balloons</td>

                                        <!-- <td class="" style="width:241px !important;">true</td> -->
                                        <td class="" style="width:1000px !important;">He directly said no for work though he was aware, he bargained with the adult to do work. He tried to interact with other children. Theatre- He then turned at me and said - "Amma I helped
                                            that aunty" When mother wore saree for a function- "asked me why I was wearing paati's dress" He reasoned out verbally why he did not want to play with balloons</td>


                                        <!-- <td class="" style="width:241px !important;">true</td> -->
                                        <td class="" style="width:1000px !important;">He directly said no for work though he was aware, he bargained with the adult to do work. He tried to interact with other children. Theatre- He then turned at me and said - "Amma I helped
                                            that aunty" When mother wore saree for a function- "asked me why I was wearing paati's dress" He reasoned out verbally why he did not want to play with balloons</td>

                                        <!-- <td class="" style="width:241px !important;">true</td> -->
                                        <td class="" style="width:1000px !important;">He directly said no for work though he was aware, he bargained with the adult to do work. He tried to interact with other children. Theatre- He then turned at me and said - "Amma I helped
                                            that aunty" When mother wore saree for a function- "asked me why I was wearing paati's dress" He reasoned out verbally why he did not want to play with balloons</td>



                                    </tr>


                                    <tr id="135" class="custom">
                                        <td rowspan="1" class="dan" style="width:403px !important;font-weight: 900;font-size: 17px;">Opportunity4</td>
                                        <!-- <td class="" style="width:241px !important;">true</td> -->
                                        <td class="" style="width:1000px !important;">He directly said no for work though he was aware, he bargained with the adult to do work. He tried to interact with other children. Theatre- He then turned at me and said - "Amma I helped
                                            that aunty" When mother wore saree for a function- "asked me why I was wearing paati's dress" He reasoned out verbally why he did not want to play with balloons</td>

                                        <!-- <td class="" style="width:241px !important;">true</td> -->
                                        <td class="" style="width:1000px !important;">He directly said no for work though he was aware, he bargained with the adult to do work. He tried to interact with other children. Theatre- He then turned at me and said - "Amma I helped
                                            that aunty" When mother wore saree for a function- "asked me why I was wearing paati's dress" He reasoned out verbally why he did not want to play with balloons</td>


                                        <!-- <td class="" style="width:241px !important;">true</td> -->
                                        <td class="" style="width:1000px !important;">He directly said no for work though he was aware, he bargained with the adult to do work. He tried to interact with other children. Theatre- He then turned at me and said - "Amma I helped
                                            that aunty" When mother wore saree for a function- "asked me why I was wearing paati's dress" He reasoned out verbally why he did not want to play with balloons</td>

                                        <!-- <td class="" style="width:241px !important;">true</td> -->
                                        <td class="" style="width:1000px !important;">He directly said no for work though he was aware, he bargained with the adult to do work. He tried to interact with other children. Theatre- He then turned at me and said - "Amma I helped
                                            that aunty" When mother wore saree for a function- "asked me why I was wearing paati's dress" He reasoned out verbally why he did not want to play with balloons</td>



                                    </tr>




                                    <tr id="135" class="custom">
                                        <td rowspan="1" class="dan" style="width:403px !important;font-weight: 900;font-size: 17px;">Opportunity5</td>
                                        <!-- <td class="" style="width:241px !important;">true</td> -->
                                        <td class="" style="width:1000px !important;">He directly said no for work though he was aware, he bargained with the adult to do work. He tried to interact with other children. Theatre- He then turned at me and said - "Amma I helped
                                            that aunty" When mother wore saree for a function- "asked me why I was wearing paati's dress" He reasoned out verbally why he did not want to play with balloons</td>

                                        <!-- <td class="">true</td> -->
                                        <td class="" style="width:1000px !important;">He directly said no for work though he was aware, he bargained with the adult to do work. He tried to interact with other children. Theatre- He then turned at me and said - "Amma I helped
                                            that aunty" When mother wore saree for a function- "asked me why I was wearing paati's dress" He reasoned out verbally why he did not want to play with balloons</td>


                                        <!-- <td class="">true</td> -->
                                        <td class="" style="width:1000px !important;">He directly said no for work though he was aware, he bargained with the adult to do work. He tried to interact with other children. Theatre- He then turned at me and said - "Amma I helped
                                            that aunty" When mother wore saree for a function- "asked me why I was wearing paati's dress" He reasoned out verbally why he did not want to play with balloons</td>

                                        <!-- <td class="">true</td> -->
                                        <td class="" style="width:1000px !important;">He directly said no for work though he was aware, he bargained with the adult to do work. He tried to interact with other children. Theatre- He then turned at me and said - "Amma I helped
                                            that aunty" When mother wore saree for a function- "asked me why I was wearing paati's dress" He reasoned out verbally why he did not want to play with balloons</td>




                                    </tr>

                                    <tr id="135" class="custom">
                                        <td rowspan="1" class="dan" style="width:403px !important;font-weight: 900;font-size: 17px;">Opportunity6</td>
                                        <!-- <td class="" style="width:241px !important;">true</td> -->
                                        <td class="" style="width:1000px !important;">He directly said no for work though he was aware, he bargained with the adult to do work. He tried to interact with other children. Theatre- He then turned at me and said - "Amma I helped
                                            that aunty" When mother wore saree for a function- "asked me why I was wearing paati's dress" He reasoned out verbally why he did not want to play with balloons</td>

                                        <!-- <td class="">true</td> -->
                                        <td class="" style="width:1000px !important;">He directly said no for work though he was aware, he bargained with the adult to do work. He tried to interact with other children. Theatre- He then turned at me and said - "Amma I helped
                                            that aunty" When mother wore saree for a function- "asked me why I was wearing paati's dress" He reasoned out verbally why he did not want to play with balloons</td>


                                        <!-- <td class="">true</td> -->
                                        <td class="" style="width:1000px !important;">He directly said no for work though he was aware, he bargained with the adult to do work. He tried to interact with other children. Theatre- He then turned at me and said - "Amma I helped
                                            that aunty" When mother wore saree for a function- "asked me why I was wearing paati's dress" He reasoned out verbally why he did not want to play with balloons</td>

                                        <!-- <td class="">true</td> -->
                                        <td class="" style="width:1000px !important;">He directly said no for work though he was aware, he bargained with the adult to do work. He tried to interact with other children. Theatre- He then turned at me and said - "Amma I helped
                                            that aunty" When mother wore saree for a function- "asked me why I was wearing paati's dress" He reasoned out verbally why he did not want to play with balloons</td>




                                    </tr>

                                    <tr id="135" class="custom">
                                        <td rowspan="1" class="dan" style="width:403px !important;font-weight: 900;font-size: 17px;">Opportunity7</td>
                                        <!-- <td class="" style="width:241px !important;">true</td> -->
                                        <td class="" style="width:1000px !important;">He directly said no for work though he was aware, he bargained with the adult to do work. He tried to interact with other children. Theatre- He then turned at me and said - "Amma I helped
                                            that aunty" When mother wore saree for a function- "asked me why I was wearing paati's dress" He reasoned out verbally why he did not want to play with balloons</td>

                                        <!-- <td class="">true</td> -->
                                        <td class="" style="width:1000px !important;">He directly said no for work though he was aware, he bargained with the adult to do work. He tried to interact with other children. Theatre- He then turned at me and said - "Amma I helped
                                            that aunty" When mother wore saree for a function- "asked me why I was wearing paati's dress" He reasoned out verbally why he did not want to play with balloons</td>


                                        <!-- <td class="">true</td> -->
                                        <td class="" style="width:1000px !important;">He directly said no for work though he was aware, he bargained with the adult to do work. He tried to interact with other children. Theatre- He then turned at me and said - "Amma I helped
                                            that aunty" When mother wore saree for a function- "asked me why I was wearing paati's dress" He reasoned out verbally why he did not want to play with balloons</td>

                                        <!-- <td class="">true</td> -->
                                        <td class="" style="width:1000px !important;">He directly said no for work though he was aware, he bargained with the adult to do work. He tried to interact with other children. Theatre- He then turned at me and said - "Amma I helped
                                            that aunty" When mother wore saree for a function- "asked me why I was wearing paati's dress" He reasoned out verbally why he did not want to play with balloons</td>




                                    </tr>

                                    <tr id="135" class="custom">
                                        <td rowspan="1" class="dan" style="width:403px !important;font-weight: 900;font-size: 17px;">Opportunity8</td>
                                        <!-- <td class="" style="width:241px !important;">true</td> -->
                                        <td class="" style="width:1000px !important;">He directly said no for work though he was aware, he bargained with the adult to do work. He tried to interact with other children. Theatre- He then turned at me and said - "Amma I helped
                                            that aunty" When mother wore saree for a function- "asked me why I was wearing paati's dress" He reasoned out verbally why he did not want to play with balloons</td>

                                        <!-- <td class="">true</td> -->
                                        <td class="" style="width:1000px !important;">He directly said no for work though he was aware, he bargained with the adult to do work. He tried to interact with other children. Theatre- He then turned at me and said - "Amma I helped
                                            that aunty" When mother wore saree for a function- "asked me why I was wearing paati's dress" He reasoned out verbally why he did not want to play with balloons</td>


                                        <!-- <td class="">true</td> -->
                                        <td class="" style="width:1000px !important;">He directly said no for work though he was aware, he bargained with the adult to do work. He tried to interact with other children. Theatre- He then turned at me and said - "Amma I helped
                                            that aunty" When mother wore saree for a function- "asked me why I was wearing paati's dress" He reasoned out verbally why he did not want to play with balloons</td>

                                        <!-- <td class="">true</td> -->
                                        <td class="" style="width:1000px !important;">He directly said no for work though he was aware, he bargained with the adult to do work. He tried to interact with other children. Theatre- He then turned at me and said - "Amma I helped
                                            that aunty" When mother wore saree for a function- "asked me why I was wearing paati's dress" He reasoned out verbally why he did not want to play with balloons</td>




                                    </tr>













                                </tbody>
                            </table>

                        </div>
                    </div>
                </div>
            </div>

            <div class="row card col-12" id="search4" style="display:none !important;">
                <div class="card-body">
                    <!-- <div class="row">
                        <div class="col-lg-12 text-center">
                            <h4 style="color:darkblue;">Monthly Observation View</h4>
                        </div>
                    </div> -->
                    <div class=" col-12 scrollable fixTableHead title-padding">
                        <div class="table-responsive">

                            <table class="table table-bordered" id="align4" style="width:100% !important;">
                                <thead>

                                    <tr>

                                        <th colspan="4">Highlights</th>



                                    </tr>


                                    <tr>
                                        <!-- <th style="width:241px !important;">Record</th> -->

                                        <th style="width:1000px !important;">week1</th>


                                        <!-- <th style="width:218px !important;">Record</th> -->


                                        <th style="width:1000px !important;">week2</th>


                                        <!-- <th style="width:241px !important;">Record</th> -->

                                        <th style="width:1000px !important;">week3</th>

                                        <!-- <th style="width:241px !important;">Record</th> -->


                                        <th style="width:1000px !important;">week4</th>

                                    </tr>
                                </thead>
                                <tbody>

                                    <tr id="135" class="custom">

                                        <!-- <td class="" style="width:241px !important;">true</td> -->
                                        <td class="" style="width:1000px !important;">Movements were on higher side, refused to take work; It was not a productive week- School</td>

                                        <!-- <td class="" style="width:241px !important;">true</td> -->
                                        <td class="" style="width:1000px !important;">Home- Mother out of town for few days in the last week</td>


                                        <!-- <td class="" style="width:241px !important;">true</td> -->
                                        <td class="" style="width:1000px !important;">School-He refused to work alone and bit difficult to sit with him all time. Too many other things were happening so following one child in this week was tough.</td>

                                        <!-- <td class="" style="width:241px !important;">true</td> -->
                                        <td class="" style="width:1000px !important;">Crying and shouting observed in OT- working on getting rid of fear</td>

                                    </tr>


                                    <tr id="135" class="custom">

                                        <!-- <td class="" style="width:241px !important;">true</td> -->
                                        <td class="" style="width:1000px !important;">Movements were on higher side, refused to take work; It was not a productive week- School</td>

                                        <!-- <td class="" style="width:241px !important;">true</td> -->
                                        <td class="" style="width:1000px !important;">Home- Mother out of town for few days in the last week</td>


                                        <!-- <td class="" style="width:241px !important;">true</td> -->
                                        <td class="" style="width:1000px !important;">School-He refused to work alone and bit difficult to sit with him all time. Too many other things were happening so following one child in this week was tough.</td>

                                        <!-- <td class="" style="width:241px !important;">true</td> -->
                                        <td class="" style="width:1000px !important;">Crying and shouting observed in OT- working on getting rid of fear</td>

                                    </tr>


                                    <tr id="135" class="custom">

                                        <!-- <td class="" style="width:241px !important;">true</td> -->
                                        <td class="" style="width:1000px !important;">Movements were on higher side, refused to take work; It was not a productive week- School</td>

                                        <!-- <td class="" style="width:241px !important;">true</td> -->
                                        <td class="" style="width:1000px !important;">Home- Mother out of town for few days in the last week</td>


                                        <!-- <td class="" style="width:241px !important;">true</td> -->
                                        <td class="" style="width:1000px !important;">School-He refused to work alone and bit difficult to sit with him all time. Too many other things were happening so following one child in this week was tough.</td>

                                        <!-- <td class="" style="width:241px !important;">true</td> -->
                                        <td class="" style="width:1000px !important;">Crying and shouting observed in OT- working on getting rid of fear</td>

                                    </tr>


                                    <tr id="135" class="custom">

                                        <!-- <td class="" style="width:241px !important;">true</td> -->
                                        <td class="" style="width:1000px !important;">Movements were on higher side, refused to take work; It was not a productive week- School</td>

                                        <!-- <td class="" style="width:241px !important;">true</td> -->
                                        <td class="" style="width:1000px !important;">Home- Mother out of town for few days in the last week</td>


                                        <!-- <td class="" style="width:241px !important;">true</td> -->
                                        <td class="" style="width:1000px !important;">School-He refused to work alone and bit difficult to sit with him all time. Too many other things were happening so following one child in this week was tough.</td>

                                        <!-- <td class="" style="width:241px !important;">true</td> -->
                                        <td class="" style="width:1000px !important;">Crying and shouting observed in OT- working on getting rid of fear</td>

                                    </tr>




















                                </tbody>
                            </table>

                        </div>
                    </div>
                </div>
            </div>

            <div class="row card col-12" id="search5" style="display:none !important;">
                <div class="card-body">
                    <!-- <div class="row">
                        <div class="col-lg-12 text-center">
                            <h4 style="color:darkblue;">Monthly Observation View</h4>
                        </div>
                    </div> -->
                    <div class=" col-12 scrollable fixTableHead title-padding">
                        <div class="table-responsive">

                            <table class="table table-bordered" id="align5" style="width:100% !important;">
                                <thead>

                                    <tr>

                                        <th rowspan="3" style="width:304px !important;">Vitals</th>
                                        <th colspan="4">Weekly Vitals </th>


                                    </tr>


                                    <tr>
                                        <!-- <th style="width:241px !important;">Record</th> -->
                                        <th colspan="1">week1</th>

                                        <th colspan="1">week2</th>
                                        <th colspan="1">week3</th>
                                        <th colspan="1">week4</th>
                                    </tr>
                                    <tr>
                                        <th style="width:1000px !important;">Notes</th>

                                        <th style="width:1000px !important;">Notes</th>

                                        <th style="width:1000px !important;">Notes</th>

                                        <th style="width:1000px !important;">Notes</th>

                                    </tr>
                                </thead>
                                <tbody>

                                    <tr id="135" class="custom">

                                        <td class="" style="width:444px !important;font-weight:500 !important;font-weight: 900;font-size: 17px;">Sleep routine</td>
                                        <td class="" style="width:1000px !important;">Sleep time- 9 to 10 pm; wake up time- 7 to 8 am; had difficulty falling sleep, disturbed sleep on a day</td>
                                        <!-- <td class="" style="width:241px !important;">true</td> -->
                                        <td class="" style="width:1000px !important;">Sleep time- 9:30 to 10:30 pm; wake up time- 7 to 8 am; disturbed sleep on a day</td>
                                        <!-- <td class="" style="width:241px !important;">true</td> -->
                                        <td class="" style="width:1000px !important;">Sleep time- 9:30 to 10:30 pm; wake up time- 7 to 7:30 am</td>
                                        <!-- <td class="" style="width:241px !important;">true</td> -->
                                        <td class="" style="width:1000px !important;">Sleep time- 9:30 to 10 pm; wake up time- 7 to 7:30 am; regular sleep routine most of the time</td>

                                    </tr>

                                    <tr id="135" class="custom">

                                        <td class="" style="width:444px !important;font-weight: 900;font-size: 17px;">Food Habits</td>
                                        <td class="" style="width:1000px !important;">Increased food intake, regular food</td>
                                        <!-- <td class="" style="width:241px !important;">true</td> -->
                                        <td class="" style="width:1000px !important;">Increased food intake, regular food, junk food</td>
                                        <!-- <td class="" style="width:241px !important;">true</td> -->
                                        <td class="" style="width:1000px !important;">Regular food, increased food intake, junk food, high sugar intake</td>
                                        <!-- <td class="" style="width:241px !important;">true</td> -->
                                        <td class="" style="width:1000px !important;">Regular food, increased food intake, high sugar intake; less intake on a day</td>

                                    </tr>

                                    <tr id="135" class="custom">

                                        <td class="" style="width:444px !important;font-weight: 900;font-size: 17px;">Screen time</td>
                                        <td class="" style="width:1000px !important;">1 hr</td>
                                        <!-- <td class="" style="width:241px !important;">true</td> -->
                                        <td class="" style="width:1000px !important;">1-2 hrs</td>
                                        <!-- <td class="" style="width:241px !important;">true</td> -->
                                        <td class="" style="width:1000px !important;">1-2 hrs</td>
                                        <!-- <td class="" style="width:241px !important;">true</td> -->
                                        <td class="" style="width:1000px !important;">1 hr</td>

                                    </tr>

                                    <tr id="135" class="custom">

                                        <td class="" style="width:444px !important;font-weight: 900;font-size: 17px;">Self engagement time</td>
                                        <td class="" style="width:1000px !important;">30 mins-2 hrs</td>
                                        <!-- <td class="" style="width:241px !important;">true</td> -->
                                        <td class="" style="width:1000px !important;">30 mins-2 hrs</td>
                                        <!-- <td class="" style="width:241px !important;">true</td> -->
                                        <td class="" style="width:1000px !important;">1-2 hrs</td>
                                        <!-- <td class="" style="width:241px !important;">true</td> -->
                                        <td class="" style="width:1000px !important;">1-2 hrs</td>

                                    </tr>

                                    <tr id="135" class="custom">

                                        <td class="" style="width:444px !important;font-weight: 900;font-size: 17px;">Attendance</td>
                                        <td class="" style="width:1000px !important;">School- 3/3; OT- 3/3</td>
                                        <!-- <td class="" style="width:241px !important;">true</td> -->
                                        <td class="" style="width:1000px !important;">School- 3/4; OT- 3/3</td>
                                        <!-- <td class="" style="width:241px !important;">true</td> -->
                                        <td class="" style="width:1000px !important;">School- 4/4; OT - 2/3</td>
                                        <!-- <td class="" style="width:241px !important;">true</td> -->
                                        <td class="" style="width:1000px !important;">School- 4/4; OT - 3</td>

                                    </tr>

                                    <tr id="135" class="custom">

                                        <td class="" style="width:444px !important;font-weight: 900;font-size: 17px;">Consistency goals</td>
                                        <td class="" style="width:1000px !important;">Potty training- No- he refuses to sit. WIP- training everyday</td>
                                        <!-- <td class="" style="width:241px !important;">true</td> -->
                                        <td class="" style="width:1000px !important;">Potty training- in progress- I have to make him sit which i feel I can achieve, but since I am not around during his potty time, it is taking time. He would not listen to others at home for potty traiing</td>
                                        <!-- <td class="" style="width:241px !important;">true</td> -->
                                        <td class="" style="width:1000px !important;">Potty training- In progress the mother is not finding the suitable time when he ant to do potty to make him sit and train him</td>
                                        <!-- <td class="" style="width:241px !important;">true</td> -->
                                        <td class="" style="width:1000px !important;">Potty training- No-Not willing to attempt- parent wants to know of Hamsa can help</td>

                                    </tr>

                                    <tr id="135" class="custom">

                                        <td class="" style="width:444px !important;font-weight: 900;font-size: 17px;">Therapist Satisfaction</td>
                                        <td class="" style="width:1000px !important;">School-No, OT-Neutral</td>
                                        <!-- <td class="" style="width:241px !important;">true</td> -->
                                        <td class="" style="width:1000px !important;">School, OT - Neutral</td>
                                        <!-- <td class="" style="width:241px !important;">true</td> -->
                                        <td class="" style="width:1000px !important;">School-Yes; OT-Neutral</td>
                                        <!-- <td class="" style="width:241px !important;">true</td> -->
                                        <td class="" style="width:1000px !important;">OT - Yes, School-Neutral</td>

                                    </tr>

                                    <tr id="135" class="custom">

                                        <td class="" style="width:444px !important;font-weight: 900;font-size: 17px;">Parent satisfaction</td>
                                        <td class="" style="width:1000px !important;">Yes in OT</td>
                                        <!-- <td class="" style="width:241px !important;">true</td> -->
                                        <td class="" style="width:1000px !important;">Yes in OT</td>
                                        <!-- <td class="" style="width:241px !important;">true</td> -->
                                        <td class="" style="width:1000px !important;">Yes in OT</td>
                                        <!-- <td class="" style="width:241px !important;">true</td> -->
                                        <td class="" style="width:1000px !important;">Yes in OT</td>

                                    </tr>















                                </tbody>
                            </table>

                        </div>
                    </div>
                </div>
            </div>

            <div class="row card col-12" id="search6" style="display:none !important;">
                <div class="card-body">
                    <!-- <div class="row">
                        <div class="col-lg-12 text-center">
                            <h4 style="color:darkblue;">Monthly Observation View</h4>
                        </div>
                    </div> -->
                    <div class=" col-12 scrollable fixTableHead title-padding">
                        <div class="table-responsive">

                            <table class="table table-bordered" id="align6" style="width:100% !important;">
                                <thead>
                                    <tr>
                                        <th>Environmental</th>
                                        <th>Sound</th>
                                        <th>Temperature</th>
                                        <th>Light</th>
                                        <th>Seating</th>
                                        <th style="width:340px;">Comments/Evidence</th>
                                    </tr>

                                </thead>
                                <tbody>

                                    <tr>
                                        <td style="font-weight: 900;font-size: 17px;">Week1</td>
                                        <td>true</td>
                                        <td>true</td>
                                        <td>true</td>
                                        <td>false</td>
                                        <td>School- Comfortable seating, Consistent work setting, Safe; OT- Quiet, Comfortable seating, Consistent work setting, Safe, Consistent device, Optimal lighting and ventilation.</td>

                                    </tr>


                                    <tr id="135" class="custom">

                                        <td style="font-weight: 900;font-size: 17px;">Week2</td>
                                        <td>true</td>
                                        <td>true</td>
                                        <td>true</td>
                                        <td>false</td>
                                        <td>School- Comfortable seating, Consistent work setting, Safe; OT- Quiet, Comfortable seating, Consistent work setting, Safe, Consistent device, Optimal lighting and ventilation.</td>

                                    </tr>



                                    <tr id="135" class="custom">

                                        <td style="font-weight: 900;font-size: 17px;">Week3</td>
                                        <td>true</td>
                                        <td>true</td>
                                        <td>true</td>
                                        <td>false</td>
                                        <td>School- Comfortable seating, Consistent work setting, Safe; OT- Quiet, Comfortable seating, Consistent work setting, Safe, Consistent device, Optimal lighting and ventilation.</td>



                                    </tr>

                                    <tr id="135" class="custom">

                                        <td style="font-weight: 900;font-size: 17px;">Week4</td>
                                        <td>true</td>
                                        <td>true</td>
                                        <td>true</td>
                                        <td>false</td>
                                        <td>School- Comfortable seating, Consistent work setting, Safe; OT- Quiet, Comfortable seating, Consistent work setting, Safe, Consistent device, Optimal lighting and ventilation.</td>




                                    </tr>




                                </tbody>
                            </table>

                        </div>
                    </div>
                </div>
            </div>

            <div class="row card col-12" id="search7" style="display:none !important;">
                <div class="card-body">
                    <!-- <div class="row">
                        <div class="col-lg-12 text-center">
                            <h4 style="color:darkblue;">Monthly Observation View</h4>
                        </div>
                    </div> -->
                    <div class=" col-12 scrollable fixTableHead title-padding">
                        <div class="table-responsive">

                            <table class="table table-bordered" id="align7" style="width:100% !important;">
                                <thead>
                                    <tr>
                                        <th>Emotional</th>
                                        <th>Level of motivation</th>
                                        <th>Task persistence</th>
                                        <th>conformity/Responsibility</th>
                                        <th>Need for a structured environment</th>
                                        <th style="width:200px;">Comments/Evidence</th>

                                    </tr>

                                </thead>
                                <tbody>

                                    <tr>
                                        <td style="font-weight: 900;font-size: 17px;">Week1</td>
                                        <td>true</td>
                                        <td>true</td>
                                        <td>true</td>
                                        <td>false</td>
                                        <td>School- Looked Distracted, Avoidance of tasks, Communicated dislike in the task; OT - Motivated, communicated dislike of the task Cranky at home too.</td>

                                    </tr>


                                    <tr id="135" class="custom">

                                        <td style="font-weight: 900;font-size: 17px;">Week2</td>
                                        <td>true</td>
                                        <td>true</td>
                                        <td>true</td>
                                        <td>false</td>
                                        <td>School- Avoidance of tasks, Took breaks in between the task, Looked Distracted OT- Motivated, Avoidance of tasks </td>

                                    </tr>



                                    <tr id="135" class="custom">

                                        <td style="font-weight: 900;font-size: 17px;">Week3</td>
                                        <td>true</td>
                                        <td>true</td>
                                        <td>true</td>
                                        <td>false</td>
                                        <td>School- Took breaks in between the task OT- Motivated, looked irritable</td>



                                    </tr>

                                    <tr id="135" class="custom">

                                        <td style="font-weight: 900;font-size: 17px;">Week4</td>
                                        <td>true</td>
                                        <td>true</td>
                                        <td>true</td>
                                        <td>false</td>
                                        <td>OT-Motivated, avoidance of tasks School- Understood the completion of task but did not complete, distracted</td>




                                    </tr>
















                                </tbody>
                            </table>

                        </div>
                    </div>
                </div>
            </div>

            <div class="row card col-12" id="search8" style="display:none !important;">
                <div class="card-body">
                    <!-- <div class="row">
                        <div class="col-lg-12 text-center">
                            <h4 style="color:darkblue;">Monthly Observation View</h4>
                        </div>
                    </div> -->
                    <div class=" col-12 scrollable fixTableHead title-padding">
                        <div class="table-responsive">

                            <table class="table table-bordered" id="align8" style="width:100% !important;">
                                <thead>
                                    <tr>
                                        <th>Sociological</th>
                                        <th>Alone</th>
                                        <th>With an Adult as a Teacher</th>
                                        <th style="width:2px !important;">With Peers</th>
                                        <th>In a Team</th>
                                        <th>Variety of Social Setting</th>
                                        <th style="width:200px;">Comments/Evidence</th>

                                    </tr>

                                </thead>
                                <tbody>

                                    <tr class="custom odd">
                                        <td style="font-weight: 900;font-size: 17px;">Week1</td>
                                        <td>true</td>
                                        <td>true</td>
                                        <td>true</td>
                                        <td>false</td>
                                        <td>true</td>
                                        <td>School- cooperation level-3; OT-3</td>

                                    </tr>


                                    <tr id="135" class="custom even">

                                        <td style="font-weight: 900;font-size: 17px;">Week2</td>
                                        <td>true</td>
                                        <td>true</td>
                                        <td>true</td>
                                        <td>false</td>
                                        <td>true</td>
                                        <td>School- cooperation level-3; OT-3 </td>

                                    </tr>



                                    <tr id="135" class="custom odd">

                                        <td style="font-weight: 900;font-size: 17px;">Week3</td>
                                        <td>true</td>
                                        <td>true</td>
                                        <td>true</td>
                                        <td>false</td>
                                        <td>true</td>
                                        <td>School- cooperation level-2; OT-3</td>



                                    </tr>

                                    <tr id="135" class="custom even">

                                        <td style="font-weight: 900;font-size: 17px;">Week4</td>
                                        <td>true</td>
                                        <td>true</td>
                                        <td>true</td>
                                        <td>false</td>
                                        <td>true</td>
                                        <td>OT- cooperation level-2; School-4</td>




                                    </tr>
















                                </tbody>
                            </table>

                        </div>
                    </div>
                </div>
            </div>

            <div class="row card col-12" id="search9" style="display:none !important;">
                <div class="card-body">
                    <!-- <div class="row">
                        <div class="col-lg-12 text-center">
                            <h4 style="color:darkblue;">Monthly Observation View</h4>
                        </div>
                    </div> -->
                    <div class=" col-12 scrollable fixTableHead title-padding">
                        <div class="table-responsive">

                            <table class="table table-bordered" id="align9" style="width:100% !important;">
                                <thead>
                                    <tr>
                                        <th>Physiological</th>
                                        <th>Auditory</th>
                                        <th>Visual </th>
                                        <th>Tactile</th>
                                        <th>Kinesthetic</th>
                                        <th style="width:200px;">Comments/Evidence</th>

                                    </tr>

                                </thead>
                                <tbody>

                                    <tr>
                                        <td style="font-weight: 900;font-size: 17px;">Week1</td>
                                        <td>true</td>
                                        <td>true</td>
                                        <td>true</td>
                                        <td>false</td>
                                        <td>Avoidance of loud noise</td>

                                    </tr>


                                    <tr id="135" class="custom">

                                        <td style="font-weight: 900;font-size: 17px;">Week2</td>
                                        <td>true</td>
                                        <td>true</td>
                                        <td>true</td>
                                        <td>false</td>
                                        <td>Cycling,Writing </td>

                                    </tr>



                                    <tr id="135" class="custom">

                                        <td style="font-weight: 900;font-size: 17px;">Week3</td>
                                        <td>true</td>
                                        <td>true</td>
                                        <td>true</td>
                                        <td>false</td>
                                        <td>Listening to sound patterns, cooking tasks, cycling, playing, writing</td>



                                    </tr>

                                    <tr id="135" class="custom">

                                        <td style="font-weight: 900;font-size: 17px;">Week4</td>
                                        <td>true</td>
                                        <td>true</td>
                                        <td>true</td>
                                        <td>false</td>
                                        <td>Reading, using phonic sounds</td>

                                    </tr>




                                </tbody>
                            </table>

                        </div>
                    </div>
                </div>
            </div>
            <div class="row card col-12" id="search10" style="display:none !important;">
                <div class="card-body">
                    <!-- <div class="row">
                        <div class="col-lg-12 text-center">
                            <h4 style="color:darkblue;">Monthly Observation View</h4>
                        </div>
                    </div> -->
                    <div class=" col-12 scrollable fixTableHead title-padding">
                        <div class="table-responsive">

                            <table class="table table-bordered" id="align10" style="width:100% !important;">
                                <thead>
                                    <tr>
                                        <th>Psychological</th>
                                        <th> Global/ Analytical</th>
                                        <th>Impulsive/ Reflective </th>
                                        <th style="width:70% !important;">Comments/Evidence</th>

                                    </tr>

                                </thead>
                                <tbody>

                                    <tr>
                                        <td style="font-weight: 900;font-size: 17px;">Week1</td>
                                        <td>true</td>
                                        <td>true</td>
                                        <td>Avoidance of loud noise</td>

                                    </tr>


                                    <tr id="135" class="custom">

                                        <td style="font-weight: 900;font-size: 17px;">Week2</td>
                                        <td>true</td>
                                        <td>true</td>
                                        <td>Cycling,Writing</td>

                                    </tr>



                                    <tr id="135" class="custom">

                                        <td style="font-weight: 900;font-size: 17px;">Week3</td>
                                        <td>true</td>
                                        <td>true</td>
                                        <td>Listening to sound patterns, cooking tasks, cycling, playing, writing</td>
                                    </tr>

                                    <tr id="135" class="custom">

                                        <td style="font-weight: 900;font-size: 17px;">Week4</td>
                                        <td>true</td>
                                        <td>true</td>
                                        <td>Reading, using phonic sounds</td>
                                    </tr>

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




<!-- <script src="https://code.jquery.com/jquery-1.7.2.min.js"></script> -->
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
    meeting_startdate.min = new Date().toISOString().split("T")[0];
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
    function check() {
        const strength = document.getElementById('Strength').value;

        //alert("isjc");
        if ((strength == 'Highlights') || (strength == 'Vitals')) {
            document.querySelector('.Source').style.visibility = 'hidden';
            document.querySelector('.Environment').style.visibility = 'hidden';
            document.querySelector('.Record').style.visibility = 'hidden';


        } else if ((strength == 'Environmental') || (strength == 'Emotional') || (strength == 'Sociological') || (strength == 'Physiological') || (strength == 'Psychological')) {
            document.querySelector('.Environment').style.visibility = 'hidden';
            document.querySelector('.Record').style.visibility = 'hidden';
        } else {
            document.querySelector('.Source').style.visibility = 'visible';
            document.querySelector('.Environment').style.visibility = 'visible';
            document.querySelector('.Record').style.visibility = 'visible';

        }


    }

    function validateForm(e) {
        //alert("nkscn");
        const source = document.getElementById('Source').value;
        //alert(source);
        const environment = document.getElementById('Environment').value;
        //alert(environment);
        const strength = document.getElementById('Strength').value;
        //alert(strength);

        //alert(e.target.value);
        if ((source == 'Hometracker(20-12)(20)') && (environment == 'Home') && (strength == 'Strength')) {
            //alert("hii");
            document.getElementById('search1').style.display = "block";
            document.getElementById('search10').style.display = "none";
            document.getElementById('search2').style.display = "none";
            document.getElementById('search3').style.display = "none";
            document.getElementById('search4').style.display = "none";
            document.getElementById('search5').style.display = "none";
            document.getElementById('search6').style.display = "none";
            document.getElementById('search7').style.display = "none";
            document.getElementById('search8').style.display = "none";
            document.getElementById('search9').style.display = "none";

        } else if ((source == 'Hometracker(20-12)(20)') && (environment == 'Home') && (strength == 'Stretch')) {
            //alert("bjns");
            document.getElementById('search1').style.display = "none";
            document.getElementById('search10').style.display = "none";
            document.getElementById('search3').style.display = "none";
            document.getElementById('search4').style.display = "none";
            document.getElementById('search5').style.display = "none";
            document.getElementById('search6').style.display = "none";
            document.getElementById('search7').style.display = "none";
            document.getElementById('search8').style.display = "none";
            document.getElementById('search9').style.display = "none";

            document.getElementById('search2').style.display = "block";

        } else if ((source == 'Hometracker(20-12)(20)') && (environment == 'Home') && (strength == 'Opportunity')) {
            // alert("bjns");
            document.getElementById('search1').style.display = "none";
            document.getElementById('search2').style.display = "none";
            document.getElementById('search10').style.display = "none";
            document.getElementById('search4').style.display = "none";
            document.getElementById('search5').style.display = "none";
            document.getElementById('search6').style.display = "none";
            document.getElementById('search7').style.display = "none";
            document.getElementById('search8').style.display = "none";
            document.getElementById('search9').style.display = "none";

            document.getElementById('search3').style.display = "block";

        } else if ((source == 'Hometracker(20-12)(20)') && (environment == 'Home') && (strength == 'Highlights')) {
            // alert("bjns");
            document.getElementById('search1').style.display = "none";
            document.getElementById('search2').style.display = "none";


            document.getElementById('search3').style.display = "none";
            document.getElementById('search4').style.display = "block";


            document.getElementById('search10').style.display = "none";
            document.getElementById('search5').style.display = "none";
            document.getElementById('search6').style.display = "none";
            document.getElementById('search7').style.display = "none";
            document.getElementById('search8').style.display = "none";
            document.getElementById('search9').style.display = "none";


        } else if ((source == 'Hometracker(20-12)(20)') && (environment == 'Home') && (strength == 'Vitals')) {
            // alert("bjns");
            document.getElementById('search1').style.display = "none";
            document.getElementById('search2').style.display = "none";

            document.getElementById('search3').style.display = "none";
            document.getElementById('search4').style.display = "none";

            document.getElementById('search10').style.display = "none";

            document.getElementById('search5').style.display = "block";

            document.getElementById('search6').style.display = "none";
            document.getElementById('search7').style.display = "none";
            document.getElementById('search8').style.display = "none";
            document.getElementById('search9').style.display = "none";


        } else if ((source == 'Hometracker(20-12)(20)') && (environment == 'Home') && (strength == 'Environmental')) {
            // alert("bjns");
            document.getElementById('search1').style.display = "none";
            document.getElementById('search2').style.display = "none";

            document.getElementById('search3').style.display = "none";
            document.getElementById('search4').style.display = "none";
            document.getElementById('search5').style.display = "none";
            document.getElementById('search7').style.display = "none";
            document.getElementById('search8').style.display = "none";
            document.getElementById('search9').style.display = "none";
            document.getElementById('search10').style.display = "none";

            document.getElementById('search6').style.display = "block";


        } else if ((source == 'Hometracker(20-12)(20)') && (environment == 'Home') && (strength == 'Emotional')) {
            // alert("bjns");
            document.getElementById('search1').style.display = "none";
            document.getElementById('search2').style.display = "none";

            document.getElementById('search3').style.display = "none";
            document.getElementById('search4').style.display = "none";
            document.getElementById('search5').style.display = "none";
            document.getElementById('search6').style.display = "none";
            document.getElementById('search8').style.display = "none";
            document.getElementById('search9').style.display = "none";
            document.getElementById('search10').style.display = "none";


            document.getElementById('search7').style.display = "block";


        } else if ((source == 'Hometracker(20-12)(20)') && (environment == 'Home') && (strength == 'Sociological')) {
            // alert("bjns");
            document.getElementById('search1').style.display = "none";
            document.getElementById('search2').style.display = "none";

            document.getElementById('search3').style.display = "none";
            document.getElementById('search4').style.display = "none";
            document.getElementById('search5').style.display = "none";
            document.getElementById('search6').style.display = "none";
            document.getElementById('search7').style.display = "none";
            document.getElementById('search9').style.display = "none";
            document.getElementById('search10').style.display = "none";
            document.getElementById('search8').style.display = "block";


        } else if ((source == 'Hometracker(20-12)(20)') && (environment == 'Home') && (strength == 'Physiological')) {
            // alert("bjns");
            document.getElementById('search1').style.display = "none";
            document.getElementById('search2').style.display = "none";

            document.getElementById('search3').style.display = "none";
            document.getElementById('search4').style.display = "none";
            document.getElementById('search5').style.display = "none";
            document.getElementById('search6').style.display = "none";
            document.getElementById('search7').style.display = "none";
            document.getElementById('search8').style.display = "none";
            document.getElementById('search10').style.display = "none";


            document.getElementById('search9').style.display = "block";

        } else if ((source == 'Hometracker(20-12)(20)') && (environment == 'Home') && (strength == 'Psychological')) {
            //alert("bjns");
            document.getElementById('search1').style.display = "none";
            document.getElementById('search2').style.display = "none";
            document.getElementById('search3').style.display = "none";
            document.getElementById('search4').style.display = "none";
            document.getElementById('search5').style.display = "none";
            document.getElementById('search6').style.display = "none";
            document.getElementById('search7').style.display = "none";
            document.getElementById('search8').style.display = "none";
            document.getElementById('search9').style.display = "none";

            document.getElementById('search10').style.display = "block";

        } else {
            document.getElementById('source').style.display = "none";
            document.getElementById('Environment').style.display = "none";
            document.getElementById('record').style.display = "none";


        }
        e.preventDefault();
        // e.preventDefault();




    }
</script>

@endsection