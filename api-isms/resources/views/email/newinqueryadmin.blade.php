<!DOCTYPE html>
<html>

<head>
</head>

<body style="margin:0; padding:0; font-family: Arial, sans-serif; background-color:#f4f6f8;">

	<table width="100%" cellpadding="0" cellspacing="0" style="background-color:#f4f6f8; padding:20px;">
		<tr>
			<td align="center">

				<table width="600" cellpadding="0" cellspacing="0" style="background:#ffffff; border-radius:8px; overflow:hidden; box-shadow:0 2px 8px rgba(0,0,0,0.08);">

					<!-- Header -->
					<tr>
                        <td style="background:#2196F3; color:#ffffff; padding:15px; font-size:18px; font-weight:bold;">
							ELINA - New Inquiry Notification
						</td>
					</tr>

					<!-- Content -->
					<tr>
						<td style="padding:20px; color:#333333; font-size:14px; line-height:1.6;">

							<p>Dear Team,</p>

							<p>
								We have received a new inquiry through the <strong>Contact Us</strong> form.
								Please review the details below and take the necessary action as per the standard process.
							</p>

							<table width="100%" cellpadding="8" cellspacing="0" style="border-collapse:collapse; margin-top:15px;">
								<tr style="background:#f9fafb;">
									<td><strong>Name</strong></td>
									<td>{{ $data['name'] }}</td>
								</tr>

								<tr>
									<td><strong>Email ID</strong></td>
									<td>{{ $data['email'] }}</td>
								</tr>

								<tr style="background:#f9fafb;">
									<td><strong>Role</strong></td>
									<td>{{ ucfirst($data['user_type']) }}</td>
								</tr>

								<tr>
									<td><strong>Phone Number</strong></td>
									<td>{{ $data['phonenumber'] }}</td>
								</tr>

								<tr style="background:#f9fafb;">
									<td><strong>Comment</strong></td>
									<td>{{ $data['comments'] }}</td>
								</tr>
							</table>

							<p style="margin-top:20px;">
								This is an automated notification. Kindly proceed accordingly.
							</p>

							<p>
								Regards,<br>
								<strong>Web Administrator</strong><br>
								ELINA
							</p>

						</td>
					</tr>

				</table>

			</td>
		</tr>
	</table>

</body>

</html>