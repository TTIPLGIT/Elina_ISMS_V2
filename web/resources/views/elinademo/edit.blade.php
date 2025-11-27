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
</style>

<div class="main-content">

  <!-- Main Content -->
  <section class="section">


    <div class="section-body mt-1">
      <h5 class="text-center" style="color:darkblue">Elina Demo Meeting Invite</h5>
      <div class="row">
        <div class="col-12">

          <div class="card">
            <div class="card-body">
            @foreach($rows as $key=>$row) 
              <form method="POST" action="{{ route('elinademo.update', $row['demo_parent_details_id']) }}">
              {{ csrf_field() }}
                    @method('PUT') 
              @endforeach
                @csrf
                <div class="row is-coordinate">
                  <div class="col-md-4">
                    <div class="form-group">
                      <label class="control-label">Enrollment ID</label>
                      <input class="form-control" name="enrollment_id" value="{{ $row['enrollment_id']}}" placeholder="Enrollment ID" required>
                    </div>
                  </div>


                  <div class="col-md-4">
                    <div class="form-group">
                      <label class="control-label">Child ID</label>
                      <input class="form-control" type="text" id="child_id" name="child_id"  value="{{ $row['child_id']}}"  placeholder="" required autocomplete="off">
                    </div>
                  </div>
                  


                  <div class="col-md-4">
                    <div class="form-group">
                      <label class="control-label">Child Name</label>
                      <input class="form-control" type="text" id="child_name" name="child_name"  value="{{ $row['child_name']}}"  placeholder="" required autocomplete="off">
                    </div>
                  </div>

                  <div class="col-md-4">
                    <div class="form-group " >
                      <label class="control-label">IS Co-ordinator1</label>
                      <input class="form-control" id="Is Co-ordinator"  name="Is Co-ordinator1" value="{{$row['is_coordinator1'][0]['id']}}" required>
                        
                      
                    </div>
                  </div>

                  
                
                  
                </div>
                </div>
                </div>
                </div>
                </div>
                <br>
            



                


         


                <div class="row">
                  <div class="col-12">

                    <div class="card">
                      <div class="card-body">

                        <div class="form-group row" style="margin-bottom: 5px;">
                          <label class="col-sm-2 col-form-label">To</label>
                          <div class="col-sm-4">

                          <input class="form-control" type="text" id="meeting_to" name="meeting_to" value="{{ $row['meeting_to']}}" placeholder="" required autocomplete="off">
                            
                          </div>
                          <div class="col-md-2">
                          </div>
                          <div class="col-md-2">
                            <label class="control-label centerid">Status</label> <br>
                            <!-- <input class="form-control" type="text" id="meeting_status" name="meeting_status" value="{{ $row['meeting_status']}}"  placeholder="" required autocomplete="off"> -->
                            <select class="form-control" type="text"  name="meeting_status" required> 
                            <option value="Sent"> {{ $row['meeting_status']}}</option>  
                            
                              <option value="Accept">Accept </option>
                              <option value="Reject">Reject </option>
                              <option value="Reshedule">Reshedule </option>
                              <option value="Completed">completed </option> 
                            </select>
                            
                          </div>



                        </div>




                        <div class="form-group row">
                          <label class="col-sm-2 col-form-label">Subject</label>
                          <div class="col-sm-4">
                            <input class="form-control" type="text" id="meeting_subject" name="meeting_subject"  value="{{ $row['meeting_subject']}}"  placeholder="OVM1 Meeting" required autocomplete="off">
                          </div>

                        </div>


                        <div class="form-group row">
                          <label class="col-sm-2 col-form-label">Location</label>
                          <div class="col-sm-4">
                            <input class="form-control" type="text" id="meeting_location" name="meeting_location"  value="{{ $row['meeting_location']}}"  placeholder="Enter Location" required autocomplete="off">
                          </div>


                        </div>

                        <div class="form-group row">
                          <label class="col-sm-2 col-form-label">Start Date and Time</label>
                          <div class="col-sm-4">

                            <input type='date' class="form-control" id='meeting_startdate' name="meeting_startdate" value="{{ $row['meeting_startdate']}}"  required >

                          </div>
                          <div class="col-sm-2">
                            <div class="content">
                              <input class="form-control" type="time" id="meeting_starttime" name="meeting_starttime" value="{{ $row['meeting_starttime']}}"  required >
                            </div>

                          </div>

                        </div>



                        <div class="form-group row">
                          <label class="col-sm-2 col-form-label">End Date and Time</label>
                          <div class="col-sm-4">
                            <input type='date' class="form-control" id="meeting_enddate" name="meeting_enddate" value="{{ $row['meeting_enddate']}}" required  placeholder="MM/DD/YYYY">
                          </div>
                          <div class="col-sm-2">

                            <div class="content">
                              <input class="form-control" type="time" id="meeting_endtime" name="meeting_endtime" value="{{ $row['meeting_endtime']}}" required>
                            </div>

                            
                            <br>

                          </div>

                          <div class="form-group row">
                          <label class="col-sm-2 col-form-label">File Attachement</label>
                          <div class="col-sm-4">
                            <input class="form-control" type="file" id="file" name="file" oninput="" maxlength="20" value="" placeholder="Enter Location" required autocomplete="off">
                          </div>
                          <div class="col-lg-12">
                            <div class="form-group">
                              <textarea class="form-control" id="description" name="meeting_description"  value="{{ $row['meeting_description']}}" > {{ $row['meeting_description']}}</textarea>                              
                            </div>
                          </div>

                        </div>
                        <div class="row text-center">
                          <div class="col-md-12">

                            <button type="submit" class="btn btn-warning">Submit</button>
                            <!-- <button type="" class="btn btn-success">Send</button>
                            <button type="" class="btn btn-danger">Cancel</button> -->
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>

              </form>

            
          
        </div>
      </div>




      <br>

    </div>
  </section>
</div>


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

























@endsection