<style type="text/css">
  .scroll_class {
    padding: 1rem !important;
    border: none;
    -webkit-transition: .5s all ease;
    -moz-transition: .5s all ease;
    transition: .5s all ease;
    box-shadow: -1px 1px 4px 2px #f3f0f0;
    overflow-y: scroll;
    height: 328px !important;
  }

  /* ==========================================
     SCREEN ITEMS – TWO‑LINE LAYOUT
     ========================================== */
  .screen-item {
    margin-bottom: 10px;
    border-bottom: 1px solid #f0f0f0;
    padding-bottom: 6px;
  }
  .screen-check {
    display: flex;
    align-items: center;
    gap: 8px;
  }
  .screen-check input[type="checkbox"] {
    margin: 0;
    width: 16px;
    height: 16px;
    flex-shrink: 0;
  }
  .screen-check label {
    margin: 0;
    font-weight: 500;
    font-size: 14px;
  }
  .screen-permissions {
    margin-left: 26px;  /* indent to align with label */
    font-size: 13px;
    color: #6c757d;
    word-break: break-word;
  }

  /* ==========================================
     MOBILE RESPONSIVE – FORM PAGES
     ========================================== */
  @media (max-width: 768px) {
    .main-content,
    .card,
    .card-body,
    .section-body {
      padding-left: 10px !important;
      padding-right: 10px !important;
    }

    .row {
      margin-left: 0 !important;
      margin-right: 0 !important;
    }

    [class*="col-"] {
      padding-left: 5px !important;
      padding-right: 5px !important;
      flex: 0 0 100% !important;
      max-width: 100% !important;
    }

    .form-group {
      margin-bottom: 15px !important;
    }

    .form-group label {
      display: block !important;
      width: 100% !important;
      text-align: left !important;
      margin-bottom: 5px !important;
      font-weight: 600 !important;
    }

    .form-control,
    .form-control[readonly] {
      width: 100% !important;
      height: 40px !important;
      font-size: 14px !important;
    }

    select.form-control {
      height: 40px !important;
    }

    .row.text-center .col-md-12 {
      display: flex !important;
      flex-wrap: wrap !important;
      justify-content: center !important;
      gap: 6px !important;
    }

    .row.text-center .col-md-12 .btn {
      width: auto !important;
      margin: 2px !important;
      padding: 6px 12px !important;
      font-size: 14px !important;
      white-space: nowrap !important;
    }

    h5 {
      font-size: 20px !important;
    }

    .scroll_class {
      height: auto !important;
      max-height: 300px !important;
      overflow-y: auto !important;
      padding: 0.75rem !important;
    }

    .screen-check label {
      font-size: 13px !important;
    }
    .screen-permissions {
      font-size: 12px !important;
      margin-left: 24px !important;
    }
  }
</style>

@extends('layouts.adminnav')

@section('content')
<div class="row">   
   <div class="main-content">
  
<!-- Main Content -->
 <section class="section">

 {{ Breadcrumbs::render('uam_modules_screens.show',$rows[0]['module_id']) }}

        <div class="section-body mt-1">
        <!-- HEADING CENTERED -->
        <h5 class="text-center" style="color:darkblue;">Screens Show</h5>
          <div class="row">
        
            <div class="col-12">
        
              <div class="card" >
                <div class="card-body" >      
                 
                <form class="form-horizontal" method="post" name ="uam_modules_screens"  action="{{ route('uam_modules_screens.update_data') }}">
          <div class="row">
            <div class="col-md-4">
           
              <div class="form-group">

                <label class="control-label">Module Name <span style="color: red;font-size: 16px;">*</span></label>
                <input class="form-control" type="text"  id="module_name" name="module_name" disabled="" placeholder="Enter Module Name" value="{{ $rows[0]['module_name'] }}" disabled="">


                <input class="form-control" type="hidden"  id="module_id" name="module_id"  placeholder="Enter Module Name" value="{{ $rows[0]['module_id'] }}" >
              </div>

            </div>


            <div class="col-md-8 ">
              <label class="control-label">Screens Name <span style="color: red;font-size: 16px;">*</span> </label>
              <div class="row scroll_class">
                <div class="col-md-12 ">
                  
               @foreach($screensdata as $key=>$screen)

                <!-- TWO‑LINE SCREEN ITEM -->
                <div class="screen-item">
                  <div class="screen-check">
                    <input type="checkbox" id="scr_{{ $screen['screen_id'] }}" name="screen_id[]" value="{{ $screen['screen_id'] }}" disabled="">
                    <label for="scr_{{ $screen['screen_id'] }}">{{ $screen['screen_name'] }}</label>
                  </div>
                  <div class="screen-permissions">( {{ $screen['permissions'] }} )</div>
                </div>
              
             @endforeach
             </div>    
           </div>  
         </div>

   
      </div>
                    
                    <div class="row text-center">
                        <div class="col-md-12">
                            
                            <a class="btn btn-danger" href="{{ route('uam_modules_screens.index') }}"><i class="fa fa-times" aria-hidden="true"></i> Cancel </a>&nbsp;
                            
                        </div>                
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
</div>
</section>
</div>
</div>


<script src="https://cdn.jsdelivr.net/jquery.validation/1.15.1/jquery.validate.min.js"></script>
<script type="text/javascript">


$("#module_name").keypress(function(event){
        var inputValue = event.charCode;
        if(!(inputValue >= 65 && inputValue <= 120) && (inputValue != 32 && inputValue != 0)){
            event.preventDefault();
        }
    });



</script>
<script>
    function editbuttonclick(id) {

      var module_name = $('#module_name'+id).val();

      if (module_name == '') {
        swal("Please Enter Module Name ", "", "error");
        return false;
      }

      

      document.getElementById('edit_module_form'+id).submit();
    }
  </script>
  <script type="text/javascript">
    
  $(document).ready(function(){
    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });

    $module_id = $("#module_id").val();


$.ajax({
  url: '{{ url('/uam_modules_screens/get_modules_screen') }}', 
  type:"POST",
  dataType:"json",
  data: {module_id : $module_id, _token: '{{csrf_token()}}' },
  success:function(data){
    
    if (data.length == 0) {


    }else{
      for(i = 0 ; i < data.length; i++){
        
         // Use the new ID format: scr_ + screen_id
         document.getElementById('scr_' + data[i].screen_id).checked = true;
      }
    }
  },
  error:function(data){
    console.log(data);
  }
});


});
</script>

@endsection