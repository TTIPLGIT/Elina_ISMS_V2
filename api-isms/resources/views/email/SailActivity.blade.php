<!DOCTYPE html>
<html>

<head>
</head>

<body>
	<br />
	Dear Parent,
	<br /><br />

	<!-- Activity set has been {{$data['status']}} for your child.<br /> -->
	Kindly note that activities towards your child's SAIL assessment process has been {{$data['status']}}.<br /><br />
	
	@isset($data['isms_base'])
	@if(!empty($data['isms_base']))
		Please login into our <a href="{{ $data['isms_base'] }}/parent_video_upload/parentindex" target="_blank">ISMS</a> portal and click on "Parent Video Upload" to upload relevant videos.<br />
	@else
		Please login into our ISMS portal and click on "Parent Video Upload" to upload relevant videos.<br />
	@endif
	@else
		Please login into our ISMS portal and click on "Parent Video Upload" to upload relevant videos.<br />
	@endisset


	Should you face any challenges or need clarifications regarding this activity, you may reach out to Ms. Aparna for further guidance.
	<br /><br />
	Thanks and Regards,
	<br /><br />
	Team Elina
</body>

</html>