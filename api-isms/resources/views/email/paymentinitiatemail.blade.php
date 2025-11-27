<!DOCTYPE html>
<html>

<head>
</head>

<body>
	<br/>
	Dear Parent,
	<br/>
	<br/>
	We sincerely appreciate your registration with us. As part of the registration process, we kindly request payment of Rs. {{$data['amount']}} for the registration fee. This payment will facilitate the scheduling of an appointment with one of our coordinators. Once your payment is received, we will promptly provide you with further details.
	<br/><br/>
	To make the payment, please click on the following link: <a href="{{$data['url']}}">Click Here</a>
	<br/><br/>
	Please note that the Rs. {{$data['amount']}} fee covers the User Registration Fees for the ISMS Web portal and is non-refundable.
	<br/><br/>
	Important Note: The payment link will expire in 24 hours. If the link expires, you can continue the process by logging in to the ISMS website.
	<br /><br />
	Thank you for your prompt attention to this matter. If you have any questions or need further assistance, please do not hesitate to contact us.
	<br /><br />
	Best Regards,
	<br/>
	<x-email-signature />
	<br/>
	Team Elina
</body>

</html>