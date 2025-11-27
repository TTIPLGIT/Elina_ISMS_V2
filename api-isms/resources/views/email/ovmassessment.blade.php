<!DOCTYPE html>
<html>

<head>
</head>

<body>

	@if($data['email_draft'] == '')
	<p>Dear Parents,</p>
	<p><br>Greetings from Elina!</p>
	<p><br>Thank you so much for your cooperation in making the online assessment possible . Based on the videos&nbsp;sent, our interactions and the online interactions we have made his report. We have also put down our&nbsp;recommendations that can help in using his strengths to overcome the challenges that he faces currently, I&nbsp;hope the explanations given for the SWOT and recommendations are in alignment with your thought process. PFA's assessment and recommendation report. Please get back to us in case you have any questions or<br>clarifications.<br>We request you to discuss among the family and provide us with your consent to go ahead with the Referral plan.</p>
	<p><br>Thanks and Regards<br>Team Elina</p>
	@else
	{!! $data['email_draft'] !!}
	@endif

</body>

</html>