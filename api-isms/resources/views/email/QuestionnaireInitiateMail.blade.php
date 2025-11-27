<!DOCTYPE html>
<html>
<head>
</head>
<body>
	<br/>
	Dear Parent,
	<br/>
	<br/>
	Questionnaire has been Initiated for you.<br/><br/>
	
	@foreach($data as $key => $value)
	
	Click this link to Fill the {{$key}} : <a href="{{$value}}">Click Here</a><br/>
	
	@endforeach	
	<br/><br/>
	Note: This link will expire in 24 hours and after that you can continue the process by login to the ISMS website.

	<br/><br/>
	This is System Generated Mail Please Do not Reply.
	<br/><br/><br/>
	Thanks & Regards,
	<br/><br/>
	Team Elina
</body>
</html>