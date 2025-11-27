<div class="modal fade" id="addeligModal">
    <div class="modal-dialog modal-xl" >


		<div class="modal-content">

         <form  action="{{ route('Registration.store') }}" method="POST" id="create_form" enctype="multipart/form-data">
			{{ csrf_field() }}
				<div class="modal-header"style="background-color:DarkSlateBlue;">						
					<h4 class="modal-title">Add Eligible Criteria</h4>
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				</div>
				<div class="modal-body">
				<input type="hidden" class="form-control" required id="user_id" name="user_id" value="">		
				<input type="hidden" class="form-control" required id="user_details" name="user_details" value="eligibleq">
				<label style="font-size: 16px !important;">A person shall be eligible to be an empanelled as Valuer/Assessor/Surveyor if he/she:<span class="error-star" style="color:red;">*</span></label>
					
					<div class="row">
					
					
							<div class="col-md-12">
								<div class="form-group">
									<div class="egc">
										<div class="dq"><span class="questions"></span></div>
										<div class="vl"></div>
										<div class="switch-field">
											<input type="hidden" id="qid" name="q" value="">
											<input type="radio" id="radio-one" name="q" value="yes" checked/>
											<label for="radio-one">Yes</label>
											<input type="radio" id="radio-two" name="q" value="no" />
											<label for="radio-two">No</label>
										</div>
									</div>
								</div>
							</div>
					</div>
					@endforeach
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