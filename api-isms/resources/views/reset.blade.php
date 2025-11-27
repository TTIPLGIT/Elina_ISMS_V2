<html>

<head>
	<title>Reset Password</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
</head>
<body>
	<p>Welcome To Our ELINA ISMS </p>
	<br>
	<a href="{{ config('setting.document_storage_path')}}/reset/{{ $data['token'] }}" class="btn btn-success"> Reset Password </a><br>
	<p>Above link will be expire within 24 hours or 1 day.</p></br>
	<p>Thanks & Regards,</p>
	<p>Team Elina</p>

</body>

</html>