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
	<p>Thanks for showing interest in Elina Services.</p></br>
	<p>For any support kindly reach us through</p> <a href="https://isms.elinaservices.com/"></a></br>
	
</body>

</html>