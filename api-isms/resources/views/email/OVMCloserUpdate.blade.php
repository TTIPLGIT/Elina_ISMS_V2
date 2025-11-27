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
	<!-- <p><br />Based on our request the meeting has been Forced Closure.</p></br>


	<p>Thanks for showing interest in Elina Services.</p></br>
	
	<p><br />Thanks and Regards<br>Team Elina</p> -->
</body>

</html>