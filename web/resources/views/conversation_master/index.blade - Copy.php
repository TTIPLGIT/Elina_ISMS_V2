@extends('layouts.adminnav')
@section('content')
<style>
    .container {
        margin: 0 auto;
        padding: 0 15px 20px;
        /* max-width: 800px; */
        transition: box-shadow 0.2s ease-in;
        border-radius: 10px;
        /* 	box-shadow: 0 0 40px 25px #111; */
        max-height: 350px;
        overflow-y: scroll;
    }

    h1 {
        /* margin: 20px 0; */
        color: blue;
        text-align: center;
    }

    /* ======== // end of optional styles ============= */

    .accordion {
        margin-bottom: 0;
        position: relative;
        padding: 18px 35px 18px 18px;
        width: 100%;
        text-align: left;
        font-size: 15px;
        color: #fff;
        background-color: #555555cc;
        border: 1px solid #000;
        transition: 0.4s;
        border-radius: 10px;
        outline: none;
        cursor: pointer;
    }

    .accordion::after {
        content: "";
        position: absolute;
        right: 18px;
        top: 50%;
        transform: translateY(-50%);
        width: 16px;
        height: 2px;
        background-color: #fff;
    }

    .accordion::before {
        content: "";
        position: absolute;
        right: 25px;
        top: 50%;
        transform: translateY(-50%);
        width: 2px;
        height: 16px;
        background-color: #fff;
        transition: height 0.2s ease-in;
    }

    .accordion.active::before {
        height: 0;
    }

    .accordion.active,
    .accordion:hover {
        background-color: #e86d16;
    }

    .accordion.active+.panel {
        margin-top: 2px;
    }

    .panel+.accordion {
        margin-top: 1px;
    }

    .panel {
        display: flex;
        padding: 0 18px;
        background-color: #ffffffee;
        max-height: 0;
        overflow: hidden;
        transition: max-height 0.2s ease-out;
        box-shadow: 0 0 1px 0 #444;
        border-radius: 10px;
    }

    .panel p:first-child {
        padding-top: 20px;
    }

    .panel p:last-child {
        padding-bottom: 20px;
    }

    .panel p+p {
        margin-bottom: 15px;
    }

    /* === for List === */
    .pr-list {
        padding: 20px 0;
    }

    .pr-list div {
        display: flex;
        justify-content: space-between;
        gap: 5px;
    }

    .pr-list div span:nth-child(2) {
        flex-grow: 1;
        line-height: 1.6;
        border-bottom: 1px dotted #333;
    }

    .pr-list div span:nth-child(3) {
        text-align: right;
    }
</style>
<style>
    .submit {
        display: flex;
        justify-content: center;
        margin: 10px 0 0 0;
    }

    .submit .btn-raised {
        width: 75%;
        margin: 0;
        font-size: 16px;
        padding: 15px;
        text-transform: none;
        transform: none !important;
    }

    .btn-raised.btn-default {
        background-color: #fff;
        color: #333;
    }

    .btn-raised {
        padding: 8px 15px;
        font-size: 13px;
        font-weight: 300;
        line-height: 20px;
        text-transform: uppercase;
        color: #fff;
        font-family: inherit;
        cursor: pointer;
        display: inline-block;
        text-decoration: none;
        text-align: center;
        background-color: #999;
        z-index: 2;
        position: relative;
        border: 0;
        border-radius: 3px;
        -webkit-font-smoothing: subpixel-antialiased;
        box-shadow: 0 2px 6px -2px rgba(0, 0, 0, 0.5);
        backface-visibility: hidden;
        transform: translate3d(0, 0, 0);
        transition: all 0.1s;
        outline: 0;
        -webkit-user-select: none;
        user-select: none;
    }
</style>
@if (session('success'))
<input type="hidden" name="session_data" id="session_data" class="session_data" value="{{ session('success') }}">
<script type="text/javascript">
    window.onload = function() {
        var message = $('#session_data').val();
        Swal.fire('Success!', message, 'success');
    }
</script>
@elseif(session('fail'))
<input type="hidden" name="session_data" id="session_data1" class="session_data" value="{{ session('fail') }}">
<script type="text/javascript">
    window.onload = function() {
        var message = $('#session_data1').val();
        Swal.fire('Info!', message, 'info');
    }
</script>
@endif

<div class="main-content">
    <div class="row">
        <div class="col-12">
            <h1>Accordion</h1>
            <div class="container">
                @foreach($rows as $key => $data)
                <button class="accordion">{{$data['question']}}</button>
                <div class="panel"> 
                    <h6>Question is required</h6>
                    <label class='switch' data-bs-toggle='tooltip' data-bs-placement='top' title='Enable / Disable'><input type='checkbox' class='toggle_status' onclick="functiontoggle('{{$data['required']}}')" id="is_active{{$data['id']}}" name='is_active' @if($data['required']=='0' ) checked @endif><span class='slider round'></span></label>
                </div>
                @endforeach
                <button class="accordion">Accordion Tab 1</button>
                <div class="panel">
                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
                </div>
                <button class="accordion">Accordion Tab 2</button>
                <div class="panel">
                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
                </div>

                <button class="accordion">Accordion Tab 3</button>
                <div class="panel">
                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
                </div>
                <!--  -->
                <button class="accordion">Accordion Tab 1</button>
                <div class="panel">
                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
                </div> <button class="accordion">Accordion Tab 1</button>
                <div class="panel">
                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
                </div> <button class="accordion">Accordion Tab 1</button>
                <div class="panel">
                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
                </div>
                <button class="accordion">Accordion Tab 1</button>
                <div class="panel">
                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
                </div> <button class="accordion">Accordion Tab 1</button>
                <div class="panel">
                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
                </div> <button class="accordion">Accordion Tab 1</button>
                <div class="panel">
                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
                </div>
                <!--  -->
                <button class="accordion">Accordion Tab 4</button>
                <div class="panel">
                    <div class="pr-list">
                        <div>
                            <span>Item I</span>
                            <span></span>
                            <span>1200 ₽</span>
                        </div>

                        <div>
                            <span>Item II</span>
                            <span></span>
                            <span>1000 ₽</span>
                        </div>

                        <div>
                            <span>Item III</span>
                            <span></span>
                            <span>800 ₽</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="submit"><button class="btn-raised btn-default">Add Question</button></div>
        </div>
    </div>
</div>
<script>
    if (document.querySelector(".accordion") !== null) {
        const acc = document.getElementsByClassName("accordion");

        openFirstAccTab();

        // Here the accordion can close all tabs
        for (let i = 0; i < acc.length; i++) {
            acc[i].addEventListener("click", function() {
                if (!this.classList.contains("active")) {
                    closeAccTabs();
                    toggleAcc(this);
                    console.log("Non Active");
                } else {
                    closeAccTabs();
                    console.log("Active");
                }
            });
        }

        // If you want one block in accordion to be always open
        // for (let i = 0; i < acc.length; i++) {
        // 	acc[i].addEventListener("click", function () {
        // 		closeAccTabs();
        // 		toggleAcc(this);
        // 	});
        // }

        // Open/close tab
        function toggleAcc(e) {
            e.classList.toggle("active");
            var panel = e.nextElementSibling;
            if (panel.style.maxHeight) {
                panel.style.maxHeight = null;
            } else {
                panel.style.maxHeight = panel.scrollHeight + "px";
            }
        }

        // Closing an open accordion tab when clicking on another one (if needed)
        function closeAccTabs() {
            for (let i = 0; i < acc.length; i++) {
                if (acc[i].classList.contains("active")) {
                    acc[i].classList.remove("active");
                    acc[i].nextElementSibling.removeAttribute("style");
                }
            }
        }

        // Open first accordion tab by default
        function openFirstAccTab() {
            if (!acc[0].classList.contains("active")) {
                acc[0].classList.add("active");
                acc[0].nextElementSibling.style.maxHeight =
                    acc[0].nextElementSibling.scrollHeight + "px";
            }
        }

        // When resizing - auto-height adjustment
        window.addEventListener(
            "resize",
            function() {
                for (let i = 0; i < acc.length; i++) {
                    if (acc[i].classList.contains("active")) {
                        acc[i].nextElementSibling.style.maxHeight =
                            acc[i].nextElementSibling.scrollHeight + "px";
                    }
                }
            },
            true
        );
    }
</script>
@endsection