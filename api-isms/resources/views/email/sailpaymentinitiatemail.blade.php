<!DOCTYPE html>
<html>
<head>
</head>
<body>
	<br/>
	Dear Parent,
	<br /><br />
	Greetings from Elina!
	<br /><br />
	Sail Payment Link for {{$data['child_name']}} has been created. You need to pay a fee of {{$data['amount']}} as the SAIL Registration Fees which is non-refundable.<br /><br />
	Click this link to Pay : <a href="{{$data['url']}}">Click Here</a>
	<br /><br />
	Note: The Payment link will expire in 24 hours and after that, you can continue the process through the ISMS website.
	<br /><br />
	Thanks & Regards,<br />
	<x-email-signature />
	Team Elina
</body>
</html>