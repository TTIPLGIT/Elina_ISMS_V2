<!DOCTYPE html>
<html>
<head>
</head>
<body>
	<br/>
  Hi {{$data['name']}},
	<br/><br/>
	A new OVM Meeting Has Been Scheduled To {{$data['child_name']}}.<br/><br/>
    OVM Meeting Details:
    <br/><br/>
    Meeting Start Date & Time: {{$data['meeting_startdate']}} & {{$data['startTime']}}<br/>
    Meeting End Date & Time: {{$data['meeting_enddate']}} & {{$data['endTime']}} 
    <br/><br/>
    For your Reference Enrollment Id: {{$data['enrollment_child_num']}} 
	<br/><br/><br/>
	Thanks & Regards,
	<br/>

	ISMS
</body>
</html>