<!DOCTYPE html>
<html>

<head>
</head>

<body>

	<!-- meeting_description -->
	{!! $data['meeting_description'] !!}
	@if(!empty($data['c_notes']))
	<p style="color:red !important">***Note:{{$data['c_notes']}}***</p>
	@endif

	<p><a href="{{$data['url']}}">Click Here</a> to Confirm your Availability</p>
	
	<!-- <p><br/>Based on your request the meeting has been re-scheduled. The corresponding links will be shared with you soon.</p>
	<p><br/>Thanks and Regards<br>Team Elina</p>  -->
</body>

</html>