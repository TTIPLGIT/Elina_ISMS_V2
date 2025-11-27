@foreach($rows['token_paremeterisation'] as $key=>$row)
<div class="modal fade" id="editModal{{$row['token_parameterisation_id']}}">
	<div class="modal-dialog modal-lg">


		<div class="modal-content">

			<form action="{{route('tokenmaster.update', $row['token_parameterisation_id'])}}" method="POST" id="create_form" enctype="multipart/form-data">
				{{ csrf_field() }}
				@method('PUT')
				<div class="modal-header" style="background-color:DarkSlateBlue;">
					<h4 class="modal-title">Add Personal Information</h4>
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				</div>
				<div class="modal-body" style="background-color: #edfcff !important;">



					<div class="row">

						<div class="col-md-4">
							<div class="form-group">
								<label>Time Type:<span class="error-star" style="color:red;">*</span></label>
								<select class="form-control" id="expire_type" name="expire_type" required>
									<option value="{{$row['token_expire_type']}}">{{$row['token_expire_type']}}</option>
									<option>Select-Type</option>
									<option value="Days">Days</option>
									<option value="Hours">Hours</option>

								</select>
							</div>
						</div>
						<div class="col-md-4">
							<div class="form-group">
								<label>Token Process:<span class="error-star" style="color:red;">*</span></label>
								<input type="text" class="form-control "  id="token_process" name="token_process" min="1" value="{{$row['token_process']}}" required>
							</div>
						</div>
						<div class="col-md-4">
							<div class="form-group">
								<label>Expiring Time:<span class="error-star" style="color:red;">*</span></label>
								<input type="text" class="form-control " required id="token_expire_time" name="token_expire_time" value="{{$row['token_expire_time']}}">
							</div>
						</div>
					</div>








					<div class="row">
						<div class="col-lg-12 text-center">

							<button type="submit" class="btn btn-success btn-space" id="savebutton">Save</button>
							<input type="button" class="btn btn-danger" data-dismiss="modal" value="Cancel">


						</div>
					</div>
				</div>
			</form>

		</div>
	</div>
</div>
@endforeach