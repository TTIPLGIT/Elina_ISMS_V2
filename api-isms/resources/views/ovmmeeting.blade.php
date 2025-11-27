<!DOCTYPE html>
<html>
<head>
</head>
<body>
	<br/>
	Hello {{$data['child_name']}},{{$data['child_name']}}
	<br/><br/><br/>
	OVM Meeting Has Been Scheduled .<br/><br/>
    Meeting Subject : {{$data['meeting_subject']}}
    <br/><br/>
    Meeting Description : {{$data['meeting_description']}}
    <br/><br/> 
    Meeting Scheduled Date & Time : {{$data['meeting_startdate']}} {{$data['meeting_starttime']}} To{{$data['meeting_enddate']}} {{$data['meeting_endtime']}}
    <br/><br/>
	This is System Generated Mail Please Do not Reply.
	<br/><br/><br/>
	Thanks & Regards,
	<br/><br/>

	ISMS
</body>
</html>