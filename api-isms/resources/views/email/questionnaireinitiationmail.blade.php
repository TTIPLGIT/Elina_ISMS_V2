<!DOCTYPE html>
<html>
<head>
</head>
<body>
	<br/>
	Hi {{$data['child_name']}},


	<br/><br/><br/>
	Dear Parent, Your questionnaire Link has been Successfully sent .<br/><br/>
	Click this link to edit the questions : <a href="{{$data['url']}}/{{$data['userid']}} "  >Click Here</a>

	<br/><br/>
	This is System Generated Mail Please Do not Reply.
	<br/><br/><br/>
	Thanks & Regards,
	<br/><br/>

	ISMS
</body>
</html>