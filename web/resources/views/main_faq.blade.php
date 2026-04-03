<!DOCTYPE html>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <title>ELINA ISMS</title>
  <link rel="icon" href="{{ asset('images/fia_logo.png') }}" type="image/gif" sizes="16x16">
  <!-- Fonts -->
  <link href="{{ asset('css/login.css') }}" rel="stylesheet">
  <link href="{{ asset('css/app.css') }}" rel="stylesheet">
  <style type="text/css">
    .bgimg1 {
      background: #c7c4ff;
      width: 100% !important;
      max-width: 100% !important;
      background-position: center;
      background-repeat: no-repeat;
      background-size: cover;
      position: relative;
      height: 83vh;
    }

    .form-signin .btn {
      font-size: 80%;
      border-radius: 8px;
      letter-spacing: .1rem;
      font-weight: bold;
      padding: 8px;
      transition: all 0.2s;
      width: 100% !important;
    }

    .error {
      color: red;
    }

    .header {
      height: 110px;
      width: 100%;
      margin-left: 0px !important;
      background: #26268d !important;
    }

    .footer {
      background: #26268d !important;
    }

    .text-line {
      background-color: white;
      color: #eeeeee;
      outline: none;
      outline-style: none;
      outline-offset: 0;
      border-top: none;
      border-left: none;
      border-right: none;
      border-bottom: solid #d9d9d9 1px;
      padding: 3px 10px;
    }

    h1 {
      float: left !important;
      font-weight: 300 !important;
      text-decoration: underline !important;
      font: 20px Arial, sans-serif !important;
      padding: 15px 15px !important;
    }

    u {
      text-decoration: underline 4px solid !important;
      text-decoration-color: orange !important;
      text-underline-position: under !important;
    }

    p {
      font-size: 15px !important;
      color: black !important;
      font-weight: 500 !important;
    }

    #question {
      font-size: 15px !important;
      color: black !important;
      font-weight: 500 !important;
    }

    #answer {
      font-size: 15px !important;
      color: #737373 !important;
      padding: 0px 65px !important;
    }

    html,
    body {
      background-color: #f2f2f2 !important;
    }

    .collapsible {
      background-color: white;
      color: black;
      cursor: pointer;
      padding: 18px;
      width: 100%;
      border: none !important;
      text-align: left;
      outline: none !important;
      font-size: 15px;
      border-bottom: 1px solid #ddd;
      position: relative;
      transition: background-color 0.3s ease;
    }

    .active,
    .collapsible:hover {
      background-color: #f8f9fa;
    }

    .active {
      background-color: #f8f9fa !important;
    }

    .content {
      padding: 20px;
      display: none;
      overflow: hidden;
      color: black;
      background-color: white;
      border-left: 1px solid #ddd;
      border-right: 1px solid #ddd;
      border-bottom: 1px solid #ddd;
      animation: fadeIn 0.3s ease;
    }

    @keyframes fadeIn {
      from { opacity: 0; }
      to { opacity: 1; }
    }

    th {
      color: #602e9e !important;
      background-color: white !important;
      border-color: white !important;
    }

    table,
    td {
      border-color: white !important;
    }

    .faqsearch {
      color: black !important;
    }

    #name {
      font-size: 18px !important;
      margin: 0;
      display: flex;
      align-items: center;
    }

    /* Removed the #name:before rule to eliminate the plus/minus symbol */

    #q_faq {
      padding: 0px 30px !important;
    }

    #a_faq {
      padding: 0px 40px !important;
      color: #666666 !important;
    }

    #m_faq {
      font-size: 18px !important;
      font-weight: 800 !important;
    }

    .fixed-header {
      width: 100%;
      background: #602e9e !important;
      padding: 10px 0;
      color: #fff;
    }

    .fixed-header {
      top: 0;
    }

    #footer {
      color: white !important;
      position: fixed;
      padding: 10px 10px 0px 10px;
      bottom: 0;
      width: 100%;
      height: 40px;
      background: #602e9e !important;
    }

    .container {
      width: 80%;
      margin: 0 auto;
    }

    nav a {
      color: #fff;
      text-decoration: none;
      padding: 7px 25px;
      display: inline-block;
    }

    h2,
    h5 {
      font-size: 22px !important;
      text-align: center !important;
    }

    #box {
      border-color: #602e9e !important;
    }

    .col-lg-3 {
      margin-bottom: 0px !important;
    }

    /* Removed .collapsible:after rule to eliminate the trailing plus/minus symbol */
  </style>
  <script disable-devtool-auto="">
    // ... (the disable devtool script remains exactly as it was) ...
  </script>
</head>

<body>
  <!-- header, nav, and content same as before, no changes needed -->
  <div class="header row" style="display:flex; align-items:center">
    <div class="col-md-1"><a href="{{route('login')}}"><img class="" style="width: 200% !important; display: block; margin: 15px; text-align: center; align-items: center; padding: 0;" src="{{asset('assets/images/elina-logo-2.png')}}"></a></div>
    <div class="col-md-11" style="justify-content: center; display: flex; align-items: center;">
      <h2 style="color:#FFF;font-size: 40px!important"> ELINA-Intervention Service Management System</h2>
    </div>
  </div>
  <nav class="navbar navbar-expand-lg navbar-light bg-light" style="border: 2px solid #602e9e !important;">
    <div class="col-md-4"><img class="" style="width: 100%; margin-top: -10px; margin-bottom: -10px; margin-left: -35px;" src="{{ asset('images/faq.png') }}"></div>
    <div class="col-lg-4">
      <h2><b style="font-size: 29px;">What do you need help with ?</b></h2>
      <div class="input-group">
        <input type="search" class="form-control rounded" id="module_name" name="module_name" placeholder="Search" aria-label="Search" aria-describedby="search-addon" />
        <button type="button" onclick="searchIt()" style="background: #ffc002 !important; color:black !important;font-weight: bold;" class="btn btn-primary"><i class="fa fa-fw  fa-search"></i></button>
        <button type="button" id="refresh" onclick="location.reload();" style="color:black !important;font-weight: bold;display:none" class="btn btn-primary"><i class="fa fa-refresh"></i></button>
      </div>
    </div>
    <div class="col-lg-4">
      <a type="button" href="{{route('login')}}" style="float:right !important; font: 18px Arial, sans-serif!important; padding:10px !important; background-color:#ffc002 !important; color: black !important; border-radius:25px;" class="btn-primary" title="Register / Login"><b>LOGIN</b></a>
    </div>
  </nav>

  <div class="main-content">
    <div class="container con">
      <div class="row">
        <div class="col-lg-12 margin-tb"></div>
      </div>
      <div class="card" style="margin-top:50px; margin-bottom:90px !important;">
        <div class="card-body">
          <fieldset>
            <div class="row">
              <h1><b><u>Frequently Asked Questions on ISMS</u></b></h1>
              <div class="col-lg-12">
                <div id="faq_id">
                  @foreach($one_row as $data)
                    <button type="button" class="collapsible">
                      <p id="name"><b> {{$loop->iteration}})    {{ $data['module_name'] }}</b></p>
                    </button>
                    <div class="content">
                      @if($rows != '')
                        @php $qnum = 1; @endphp
                        @foreach ($rows as $faqdata)
                          @if($data['id'] == $faqdata['module_id'])
                            <p id="question"><span style="padding:50px !important;"><b> Q{{$qnum}}.{{$faqdata['question']}}</b></span></p>
                            <p id="answer"><span style=" color: #666666 !important;"> {{$faqdata['answer']}}</span></p>
                            @php $qnum++; @endphp
                          @endif
                        @endforeach
                      @endif
                    </div>
                    <div class="text-line"></div>
                  @endforeach
                </div>
                <div class="faqsearch" id="search_id"></div>
                <div class="alert text-center" id="alert_message" style="display:none ;">
                  <p> NO DATA FOUND </p>
                </div>
              </div>
            </div>
          </fieldset>
        </div>
      </div>
    </div>
  </div>
</body>
@include('partials.footer')
</html>

<script>
  var reset = document.querySelector('#reset');
  if (reset) {
    reset.addEventListener('click', () => {
      grecaptcha.reset()
    });
  }
</script>

<script>
  var coll = document.getElementsByClassName("collapsible");
  var i;

  for (i = 0; i < coll.length; i++) {
    coll[i].addEventListener("click", function() {
      this.classList.toggle("active");
      var content = this.nextElementSibling;
      if (content.style.display === "block") {
        content.style.display = "none";
      } else {
        content.style.display = "block";
      }
    });
  }
</script>

<script type="text/javascript">
  var optionsdata = '';

  $.ajaxSetup({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  });

  function searchIt() {
    var module_name = $('#module_name').val();
    $.ajax({
      url: "{{route('que_search')}}",
      type: 'POST',
      data: {
        module_name: module_name,
        _token: '{{csrf_token()}}'
      },
      dataType: "json",
      async: false,
      error: function() {
        alert('Something is wrong');
      },
      success: function(data) {
        console.log(data);

        $('#faq_id').hide();

        var search_faq = data.Data.rows;
        if (search_faq == null || search_faq == "") {
          $('#alert_message').show();
          return;
        } else {
          $('#alert_message').hide();
        }

        var modules = [];
        var completed = 0;
        var total = Object.getOwnPropertyNames(data.Data.rows).length;

        for (var i = 0; i < total; i++) {
          var module = data.Data.rows[i];
          var mod_id = module.id;
          var module_name = module.module_name;
          var module_index = i + 1;

          $.ajax({
            url: "{{route('ans_search')}}",
            type: 'POST',
            data: {
              mod_id: mod_id,
              _token: '{{csrf_token()}}'
            },
            dataType: "json",
            async: false,
            error: function() {
              alert('Something is wrong');
            },
            success: function(quesData) {
              var questions = quesData.Data.rows;
              modules.push({
                module_index: module_index,
                module_name: module_name,
                questions: questions
              });
              completed++;
              if (completed === total) {
                buildSearchHTML(modules);
              }
            }
          });
        }
      }
    });
    $('#refresh').show();
  }

  function buildSearchHTML(modules) {
    var optionsdata = '';
    for (var m = 0; m < modules.length; m++) {
      var mod = modules[m];
      optionsdata += "<button type='button' class='collapsible'><b><p id='name'>" + mod.module_index + "." + mod.module_name + "</p></b></button><div class='content'>";
      for (var q = 0; q < mod.questions.length; q++) {
        var question = mod.questions[q].question;
        var answer = mod.questions[q].answer;
        var qnum = q + 1;
        optionsdata += "<p id='q_faq'>Q" + qnum + "." + question + "</p><p id='a_faq'>" + answer + "</p>";
      }
      optionsdata += "</div>";
    }

    $('.faqsearch').html(optionsdata);

    var coll = document.getElementsByClassName("collapsible");
    for (var i = 0; i < coll.length; i++) {
      coll[i].addEventListener("click", function() {
        this.classList.toggle("active");
        var content = this.nextElementSibling;
        if (content.style.display === "block") {
          content.style.display = "none";
        } else {
          content.style.display = "block";
        }
      });
    }
  }
</script>