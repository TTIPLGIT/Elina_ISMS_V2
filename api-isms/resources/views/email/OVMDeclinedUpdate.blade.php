<!DOCTYPE html>
<html>

<head>
</head>

<body>

	<!-- meeting_description -->
	{!! $data['meeting_description'] !!}


	<p><br />Based on our request the meeting has been declined.</p></br>
	@if(!empty($data['c_notes']))
	<p style="color:red !important">***Note:{{$data['c_notes']}}***</p>
	@endif

	<p>Thanks for showing interest in Elina Services.</p></br>
	<p>For any support kindly reach us through https://isms.elinaservices.com/</p></br>

</body>

</html>