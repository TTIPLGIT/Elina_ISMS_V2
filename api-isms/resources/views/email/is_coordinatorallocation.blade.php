<!DOCTYPE html>
<html>

<head>
</head>

<body>

	Dear Coordinator,<br /><br />
    We are pleased to inform you that you have been allocated as IS-Coordinator1: {{$data['is_coordinator1']}} and IS-Coordinator2: {{$data['is_coordinator2']}} for {{$data['child_name']}}<br /><br />
	<h3><b>Child Details:-</b></h3><br>
	<b>Name of the Child:</b> {{$data['child_name']}}<br>
	<b>Child DOB :</b> {{$data['child_dob']}}<br>
	<b>Name of Parent/ Guardian :</b> {{$data['parentname']}}<br>
	<b>Email id :</b> {{$data['email']}}<br>
	<b>Phone no :</b> {{$data['contact_no']}}<br>
	<br><br>

	Your presence and active participation are highly appreciated as we value your input and expertise in the matters at hand. Please make sure to schedule the OVM Meeting for this child {{$data['child_name']}}.<br /><br />
	
	<p><br />Thanks and Regards,<br>
	Team Elina</p>

</body>

</html>