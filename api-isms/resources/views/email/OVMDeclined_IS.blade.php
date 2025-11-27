<!DOCTYPE html>
<html>

<head>
</head>

<body>

	Dear Coordinator,<br /><br />
	We are pleased to inform you that you have been declined the OVM meetings for child-{{$data['child_name']}} on the following date:<br /><br />
	Date & Time:-<br />
	{{$data['meeting_startdate']}} from {{$data['meeting_starttime']}} to {{$data['meeting_endtime']}} (OVM1 date and time)<br />
	{{$data['meeting_startdate2']}} from {{$data['meeting_starttime2']}} to {{$data['meeting_endtime2']}} (OVM2 date and time)<br />
	<br />
	@if(!empty($data['c_notes']))
	<p style="color:red !important">***Note:{{$data['c_notes']}}***</p>
	@endif
	<!-- Your presence and active participation in this meeting are highly appreciated as we value your input and expertise in the matters at hand. Please make sure to mark your calendar and ensure your availability for the mentioned date and time.<br /><br /> -->
	
	<p><br />Thanks and Regards,<br>
	Team Elina</p>

</body>

</html>