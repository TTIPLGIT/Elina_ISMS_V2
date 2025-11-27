<div class="modal fade" id="addModal">
    <div class="modal-dialog modal-lg" >


		<div class="modal-content">

  		  <form  action="{{ route('Registration.store') }}" method="POST" id="create_form" enctype="multipart/form-data">
				{{ csrf_field() }}
					<div class="modal-header"style="background-color:DarkSlateBlue;">						
						<h4 class="modal-title">Add Personal Information</h4>
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					</div>
				<div class="modal-body" style="    background-color: #edfcff !important;">
					<input type="hidden" class="form-control" required id="user_id" name="user_id" value="">		
					<input type="hidden" class="form-control" required id="user_details" name="user_details" value="general">		
		
					<div class="row">
					
						<div class="col-md-4">
							<div class="form-group">
								<label>First Name:<span class="error-star" style="color:red;">*</span></label>
								<input type="text" class="form-control default"  required id="fname" name="fname">
							</div>
						</div>
						<div class="col-md-4">
							<div class="form-group">
								<label>Last Name:<span class="error-star" style="color:red;">*</span></label>
								<input type="text" class="form-control default"  required id="lname" name="lname">
							</div>
						</div>
						<div class="col-md-4">
							<div class="form-group">
								<label>Gender:<span class="error-star" style="color:red;">*</span></label>
									<div class="gender">
										<div>
											<input type="radio" class=""  required id="Male" name="gender" value="Male"><span> Male</span>
										</div>
										<div>
											<input type="radio" class=""  required id="Female" name="gender" value="Female"><span> Female</span>
										</div>
										<div>
											<input type="radio" class=""  required id="Transgender" name="gender" value="Transgender"><span> Transgender</span>
										</div>
									</div>
							</div>
						</div>
					</div>
              	  <h style="color:black"><b>Address:</b></h>
						<div class="row">
					
							<div class="col-md-3">
								<div class="form-group">
							
									<label>Address Line 1:<span class="error-star" style="color:red;">*</span></label>
									<input type="text" class="form-control default"  required id="Address_line1" name="Address_line1">
								</div>
							</div>
							<!-- </div>
						
							<div class="row"> -->
							<div class="col-md-3">
								<div class="form-group">
									<label>District:<span class="error-star" style="color:red;">*</span></label>
											   <select class="form-control default" required id="district" name="district">
												    <option value="0">Select-District</option> 
													<option value="Amolator">Amolator</option> 
													<option value="Kamweng">Kamweng</option> 
													<option value="Kira">Kira</option> 
													<option value="Kitgum">Kitgum</option> 
												</select>
											
								</div>
							</div>
							<div class="col-md-3">
								<div class="form-group">
									<label>constituency: <span class="error-star" style="color:red;">*</span></label>
												<select class="form-control default" required id="constituency" name="constituency">
												    <option value="0">Select-Constituency</option> 
													<option value="Bukanga County">Bukanga County</option> 
													<option value="Labwor County">Labwor County</option> 
													<option value="Mazuri County">Mazuri County</option> 
												</select>
								</div>
							</div>
							<div class="col-md-3">
								<div class="form-group">
					
									<label>Village: <span class="error-star" style="color:red;">*</span></label>
												<select class="form-control default" required id="village" name="village">
												    <option value="0">Select-Village</option> 
													<option value="Amolator">kampala</option> 
												
												</select>
								</div>
							</div>
                        </div>
					
                     
						<div class="row">
                        
						<div class="col-md-8">
								<div class="form-group">
									<label>Land Classification:<span class="error-star" style="color:red;">*</span></label>
									<div class="gender">
											<div>
												<input type="radio" class=""  required id="al" name="lvc" value="AgricultureLand"><span> Agriculture Land</span>
											</div>
											<div>
												<input type="radio" class=""  required id="rel" name="lvc" value="RealEstateLand"><span> Real Estate Land</span>
											</div>
								
											<div>
												<input type="radio" class=""  required id="pl" name="lvc" value="PlantationLand"><span> Plantation Land</span>
											</div>
									</div>
								</div>
						</div>     
						<div class="col-md-4">
								<div class="form-group">
									<label>Role Classification:<span class="error-star" style="color:red;">*</span></label>
									<div class="gender">
											<div>
												<input type="radio" class=""  required id="val" name="role_c" value="Valuer"><span> Valuer</span>
											</div>
											<div>
												<input type="radio" class=""  required id="sur" name="role_c" value="Surveyour"><span> Surveyour</span>
											</div>
								
											<div>
												<input type="radio" class=""  required id="asr" name="role_c" value="Assessor"><span> Assessor</span>
											</div>
									</div>
								</div>
						</div>             
					</div>
                        <div class="row">
					
							<div class="col-md-6">
							<div class="form-group">
							<label>NIN (National Identification Number):<span class="error-star" style="color:red;">*</span></label>
							<div class="row">
							<div class="col-md-6">
							<input type="text" class="form-control default" maxlength="12" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" required id="nin" name="nin">
							</div>
							<div class="col-md-6">
							<input class="form-control " type="file" id="ninf" name="ninf" value="" required autocomplete="off">
							</div>
							</div>
							</div>
							</div>
							<!-- </div>

							<div class="row"> -->
						
							<div class="col-md-6">
							<div class="form-group">
							<label>Passport:<span class="error-star" style="color:red;">*</span></label>
							<div class="row">
							<div class="col-md-6">
							<input type="text" class="form-control default" maxlength="10" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" required id="passport" name="passport">
							</div>
							<div class="col-md-6">
							<input class="form-control " type="file" id="ppf" name="ppf" required value="" autocomplete="off">
							</div>
							</div>
							</div>
							</div>
                        </div>


                        

					
                  
					
					<div class="row">	
						<div class="col-lg-12 text-center">				
					
							<button type="submit" class="btn btn-success btn-space"  id="savebutton">Save</button>
							<input type="button" class="btn btn-danger" data-dismiss="modal" value="Cancel">

					
						</div>
					</div>
				</div>
			
			</form>

			
    </div>
  </div>
</div>
  