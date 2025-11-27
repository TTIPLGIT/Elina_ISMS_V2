@extends('layouts.adminnav')

@section('content')
<style>
  #frname {
    color: red;
  }
  .form-control{
    background-color: #ffffff !important;
}
.is-coordinate{
  justify-content: center;
}


  .centerid {
    width: 100%;
    text-align: center;
  }
   #invite{
    display: none;
  }
</style>

<div class="main-content">

  <!-- Main Content -->
  <section class="section">


    <div class="section-body mt-1">
      <h5 class="text-center" style="color:darkblue">Demo Meeting Invite</h5>
      <div class="row">
        <div class="col-12">

          <div class="card">
            <div class="card-body">

              <!-- <form method="POST" action="{{ route('ovm1.store') }}"> -->
              <form action="{{route('elinademo.store')}}" method="POST" id="enrollement" enctype="multipart/form-data">

                @csrf
               
                <div class="row is-coordinate">
                  <div class="col-md-4">
                    <div class="form-group">
                      <label class="control-label">Enrollment ID</label><span class="error-star" style="color:red;">*</span>
                      <select class="form-control" id="enrollment_child_num"  name="enrollment_child_num" onchange="GetChilddetails()"   required>
                      <option value= "">Select-Enrollment</option> 

                      @foreach($rows['demo_parent_details'] as $key=>$row)
                        <option value= "{{$row['enrollment_child_num']}}">{{ $row['enrollment_child_num']}}</option>                        
                        @endforeach
                                               
                       

                      </select>                     
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group">
                      <label class="control-label">Child ID</label><span class="error-star" style="color:red;">*</span>
                      <input class="form-control" type="text" id="child_id" name="child_id" placeholder="Child ID" required autocomplete="off" readonly>
                    </div>
                  </div>
                  


                  <div class="col-md-4">
                    <div class="form-group">
                      <label class="control-label">Child Name</label><span class="error-star" style="color:red;">*</span>
                      <input class="form-control" type="text" id="child_name" name="child_name" oninput="Childname(event)" required maxlength="20" value="" placeholder="Enter Name"  autocomplete="off" readonly>
                    </div>
                  </div>

                  <div class="col-md-4">
                    <div class="form-group " >
                      <label class="control-label">IS Co-ordinator</label><span class="error-star" style="color:red;">*</span>
                      <select class="form-control" id="is_coordinator1"  name="is_coordinator1"  required onchange="iscoordinatorfn(event)" >

                      <option>Select-IS-Coordinator-1</option>
                      @foreach($rows['iscoordinators'] as $key=>$row)
                        <option value= "{{$row['id']}}">{{ $row['name']}}</option>                        
                        @endforeach
                       
                                             
                        
                      </select>
                      <input type="hidden" id="is_coordinator1old">
                      <input type="hidden" id="is_coordinator1current" >
                    </div>
                  </div>

                
                  


                </div>
                </div>
              </div>
            </div>
          </div>
                <br>


                <div class="row text-center">
                  <div class="col-md-12">
                    <button type="button" onclick="save()('submitted')" class="btn btn-success">Initiate</button>
                  </div>
                </div>
                




                <div class="row" id="invite">
                  <div class="col-12">

                    <div class="card">
                      <div class="card-body">

                        <div class="form-group row" style="margin-bottom: 5px;">
                          <label class="col-sm-2 col-form-label">To<span class="error-star" style="color:red;">*</span></label>
                          <div class="col-sm-4">
                          <input class="form-control" type="text" id="meeting_to" name="meeting_to" placeholder="Email Id"  autocomplete="off"> 
                          </div>
                          <div class="col-md-2">
                          </div>
                          <div class="col-md-2">
                            <label class="control-label centerid">Status</label> <br>

                            <input class="form-control" type="text" id="payment_status" name="meeting_status" placeholder="New"  autocomplete="off" readonly>

                          </div>



                        </div>




                        <div class="form-group row">
                          <label class="col-sm-2 col-form-label">Subject<span class="error-star" style="color:red;">*</span></label>
                          <div class="col-sm-4">

                            <input class="form-control" type="text" id="meeting_subject" name="meeting_subject" placeholder="Elina Demo Meeting"  autocomplete="off">

                          </div>

                        </div>


                        <div class="form-group row">
                          <label class="col-sm-2 col-form-label">Location<span class="error-star" style="color:red;">*</span></label>
                          <div class="col-sm-4">
                            <input class="form-control" type="text" id="meeting_location" name="meeting_location" oninput="location(event)" maxlength="20" value="" placeholder="Enter Location"  autocomplete="off">
                          </div>


                        </div>

                        <div class="form-group row">
                          <label class="col-sm-2 col-form-label">Start Date and Time<span class="error-star" style="color:red;">*</span></label>
                          <div class="col-sm-4">


                            <input type='date' class="form-control" id='meeting_startdate' name="meeting_startdate" placeholder="MM/DD/YYYY"  >


                          </div>
                          <div class="col-sm-2">
                            <div class="content">
                              <input class="form-control" type="time" id="meeting_starttime" name="meeting_starttime" >
                            </div>

                          </div>

                        </div>



                        <div class="form-group row">
                          <label class="col-sm-2 col-form-label">End Date and Time<span class="error-star" style="color:red;">*</span></label>
                          <div class="col-sm-4">

                            <input type='date' class="form-control" id="meeting_enddate" name="meeting_enddate" placeholder="MM/DD/YYYY"  >

                          </div>
                          <div class="col-sm-2">

                            <div class="content">
                              <input class="form-control" type="time" id="meeting_endtime" name="meeting_endtime" >
                            </div>

                          </div>

                          <div class="form-group row">
                          <label class="col-sm-2 col-form-label">File Attachement<span class="error-star" style="color:red;">*</span></label>
                          <div class="col-sm-4">
                            <input class="form-control" type="file" id="file" name="file" oninput="" maxlength="20" value="" placeholder="Enter Location"  autocomplete="off">
                          </div>


                        </div>

                        <div class="col-lg-12">
                            <div class="form-group">
                              <textarea class="form-control" id="description" name="meeting_description"></textarea>                              
                            </div>
                          </div>

                            <br>
                          
                        </div>

                        <div class="row text-center">
                          <div class="col-md-12">

                          
                            <button type="submit"  class="btn btn-warning" onclick="initatefunction()('submitted')"  name="type" value="save">Save</button>
                            <button type="submit" class="btn btn-success" name="type" value="sent">Send</button>
                            <button type="" class="btn btn-danger">Cancel</button>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>

              </form>

            </div>
          
        
          </div>
      </div>



      <br>

    </div>
  </section>
</div>

<script type="text/javascript">
 $(document).ready(function() {

       });

       const iscoordinatorfn = (event) => {
        let coordinatorname = event.target.value;
        let currentcoordinator = event.target.name;
        if(currentcoordinator === "is_coordinator1"){
          let iscoordinater2new = JSON.parse($('#is_coordinator2old').attr('data-attr'));
          intcoordinatorname = parseInt(coordinatorname);
          iscoordinater2new = iscoordinater2new.filter(name => name.id !== intcoordinatorname)
          alternatecoordinator = document.getElementById('is_coordinator2')
          var ddd = '<option >Select-IS-Coordinator-2</option>';
          for(i=0;i<iscoordinater2new.length;i++){
             ddd += '<option value="'+iscoordinater2new[i].id+'">'+iscoordinater2new[i].name+'</option>';
          }
          let currentcoordinatorname = alternatecoordinator.value;
          alternatecoordinator.innerHTML = "";
          alternatecoordinator.innerHTML = ddd;
          alternatecoordinator.value = currentcoordinatorname;
        }
       else{
        let iscoordinater1new = JSON.parse($('#is_coordinator1old').attr('data-attr'));
        intcoordinatorname = parseInt(coordinatorname);
          iscoordinater1new = iscoordinater1new.filter(name => name.id !== intcoordinatorname)
          alternatecoordinator = document.getElementById('is_coordinator1');   
          var ddd = '<option >Select-IS-Coordinator-1</option>';
          for(i=0;i<iscoordinater1new.length;i++){
             ddd += '<option value="'+iscoordinater1new[i].id+'">'+iscoordinater1new[i].name+'</option>';
          }
          let currentcoordinatorname = alternatecoordinator.value;
          alternatecoordinator.innerHTML = "";
          alternatecoordinator.innerHTML = ddd;
          alternatecoordinator.value = currentcoordinatorname;
       }
        
        //...
    }
    </script>

<script type="text/javascript">
 $(document).ready(function() {

       });

       const iscoordinatorfn = (event) => {
        let coordinatorname = event.target.value;
        let currentcoordinator = event.target.name;
        if(currentcoordinator === "is_coordinator1"){
          let iscoordinater2new = JSON.parse($('#is_coordinator2old').attr('data-attr'));
          intcoordinatorname = parseInt(coordinatorname);
          iscoordinater2new = iscoordinater2new.filter(name => name.id !== intcoordinatorname)
          alternatecoordinator = document.getElementById('is_coordinator2')
          var ddd = '<option >Select-IS-Coordinator-2</option>';
          for(i=0;i<iscoordinater2new.length;i++){
             ddd += '<option value="'+iscoordinater2new[i].id+'">'+iscoordinater2new[i].name+'</option>';
          }
          let currentcoordinatorname = alternatecoordinator.value;
          alternatecoordinator.innerHTML = "";
          alternatecoordinator.innerHTML = ddd;
          alternatecoordinator.value = currentcoordinatorname;
        }
       else{
        let iscoordinater1new = JSON.parse($('#is_coordinator1old').attr('data-attr'));
        intcoordinatorname = parseInt(coordinatorname);
          iscoordinater1new = iscoordinater1new.filter(name => name.id !== intcoordinatorname)
          alternatecoordinator = document.getElementById('is_coordinator1');   
          var ddd = '<option >Select-IS-Coordinator-1</option>';
          for(i=0;i<iscoordinater1new.length;i++){
             ddd += '<option value="'+iscoordinater1new[i].id+'">'+iscoordinater1new[i].name+'</option>';
          }
          let currentcoordinatorname = alternatecoordinator.value;
          alternatecoordinator.innerHTML = "";
          alternatecoordinator.innerHTML = ddd;
          alternatecoordinator.value = currentcoordinatorname;
       }
        
        //...
    }

</script>
<script type="text/javascript">
  tinymce.init({
    selector: 'textarea#description',    
    height: 180,
    menubar: false,
    branding: false,
    plugins: [
      'advlist autolink lists link image charmap print preview anchor',
      'searchreplace visualblocks code fullscreen',
      'insertdatetime media table paste code help wordcount'
    ],
    toolbar: 'undo redo | formatselect | ' +
      'bold italic backcolor | alignleft aligncenter ' +
      'alignright alignjustify | bullist numlist outdent indent | ' +
      'removeformat | help',
    content_style: 'body { font-family:Helvetica,Arial,sans-serif; font-size:14px }'
  }
    );  
  
</script>






 
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
                    document.getElementById('meeting_to').value= data[0].child_contact_email;
                    document.getElementById('enrollment_child_num').value = enrollment_child_num;
                      

                        // console.log(name)
                      
                   
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

if (enrollment_child_num == '') {
    swal("Please Enter Enrollment Id ", "", "error");
    return false;
}

var is_coordinator1 = $('#is_coordinator1').val();

if (is_coordinator1 == '') {
    swal("Please Enter Isco-ordinator", "", "error");
    return false;
}
document.getElementById('invite').style.display = "block";
}
</script>

<script>
  function initatefunction() {



var meeting_subject = $('#meeting_subject').val();

if (meeting_subject == '') {
    swal("Please Enter Subject:  ", "", "error");
    return false;
}

var meeting_location = $('#meeting_location').val();

if (meeting_location == '') {
    swal("Please Enter Location:  ", "", "error");
    return false;
}

var meeting_startdate = $('#meeting_startdate').val();

if (meeting_startdate == '') {
    swal("Please Enter Meeting Start Date:  ", "", "error");
    return false;
}

var meeting_starttime = $('#meeting_starttime').val();

if (meeting_starttime == '') {
    swal("Please Enter Meeting start Time:  ", "", "error");
    return false;
}

var meeting_enddate = $('#meeting_enddate').val();

if (meeting_enddate == '') {
    swal("Please Enter Meeting End Date:  ", "", "error");
    return false;
}


var meeting_endtime = $('#meeting_endtime').val();

if (meeting_endtime == '') {
    swal("Please Enter Meeting End Time:  ", "", "error");
    return false;
}

var file = $('#file').val();

if (file == '') {
    swal("Please Attached the File:  ", "", "error");
    return false;
}

var meeting_description = $('#meeting_description').val();

if (meeting_description == '') {
    swal("Please Enter Address:  ", "", "error");
    return false;
}



document.getElementById('newenrollement').submit('saved');

    
     
}
</script>
















@endsection