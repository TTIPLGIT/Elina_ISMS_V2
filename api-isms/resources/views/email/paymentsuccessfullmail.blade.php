<!DOCTYPE html>
<html>

<head>
</head>

<body>
	<br />
	Dear Parent,
	<br /><br />
	@if($data['payment_for'] == 'SAIL Register Fee')
	Sail Payment for your child {{$data['child_name']}}, has been successfully completed. We have received your payment and it has been successfully processed.
	@else
	We are pleased to inform you that the payment for your Child {{$data['child_name']}}, has been successfully completed. We have received your payment and successfully processed it.
	@endif
	<br />
	This is a system-generated mail. Please do not reply.
	<br /><br />
	Thanks & Regards,
	<br />
	Team Elina
	<br /><br />
	
</body>

</html>