<!doctype html>
<html lang="en-US">

<body marginheight="0" topmargin="0" marginwidth="0"
	style="margin: 0px; background-color: #f2f3f8; font-family:'Rubik',sans-serif;"
	leftmargin="0">

	<table cellspacing="0" border="0" cellpadding="0" width="100%" bgcolor="#f2f3f8">
		<tr>
			<td>
				<table style="max-width:670px; margin:0 auto;" width="100%" border="0"
					align="center" cellpadding="0" cellspacing="0">

					<tr>
						<td style="height:80px;">&nbsp;</td>
					</tr>

					<tr>
						<td>
							<table width="95%" border="0" align="center" cellpadding="0"
								cellspacing="0"
								style="max-width:670px; background:#fff; border-radius:8px;
								text-align:center; box-shadow:0 6px 18px 0 rgba(0,0,0,.06);">

								<tr>
									<td style="height:40px;">&nbsp;</td>
								</tr>

								<tr>
									<td style="padding:0 35px;">

										<h1 style="color:#1e1e2d; font-weight:500; margin:0;
											font-size:30px;">
											Dear Parent
										</h1>

										<p style="font-size:15px; color:#455056;
											margin:15px 0 0; line-height:24px;">
											It was a pleasure meeting you on OVM-2 Meeting Date {{$data['meeting_date']}}.
											We hope you got a better idea of our services. As discussed in the meeting,
											we request you to confirm if you would like to avail our SAIL assessment services.
											Upon your confirmation, we will be sending you the details.
											<br><br>
											If you have found other alternatives or are taking time to make the decision,
											please let us know.
										</p>

										<br><br>
										<a href="{{$data['url']}}"
											style="background:#22c55e;
											text-decoration:none;
											display:inline-block;
											font-weight:600;
											color:#ffffff;
											font-size:14px;
											padding:12px 32px;
											border-radius:25px;">
											ACCEPT
										</a>

										&nbsp;&nbsp;&nbsp;

										<a href="{{Config::get('setting.document_storage_path')}}/submitDenial/{{$data['userID']}}"
											style="background:#ef4444;
											text-decoration:none;
											display:inline-block;
											font-weight:600;
											color:#ffffff;
											font-size:14px;
											padding:12px 32px;
											border-radius:25px;"
											target="_blank">
											DECLINE
										</a>

										<!-- Information about Accept and Decline -->
										<div style="text-align: left; background-color: #f8f9fa; padding: 20px; border-radius: 8px; margin: 20px 0; border-left: 4px solid #22c55e;">
											<p style="font-size:15px; color:#455056; line-height:24px; margin:0 0 15px 0;">
												<strong style="color:#22c55e;">✓ If you select ACCEPT:</strong><br>
												We will initiate the SAIL process and share the next steps, including schedules, documentation requirements, and any additional information needed to begin the assessment.
											</p>

											<p style="font-size:15px; color:#455056; line-height:24px; margin:0;">
												<strong style="color:#ef4444;">✗ If you select DECLINE:</strong><br>
												Please choose one of the options below:
											</p>

											<ul style="font-size:15px; color:#455056; line-height:24px; margin:10px 0 0 20px; padding-left:20px;">
												<li><strong></strong> Will confirm after one month</li>
												<li><strong></strong> Will confirm later</li>
												<li><strong></strong> Will not continue with SAIL process</li>
											</ul>

											<p style="font-size:15px; color:#666; line-height:24px; margin:15px 0 0 0;">
												Your selected option will help us update our records and assist you accordingly.
											</p>
										</div>

										<!-- Buttons (unchanged) -->


										<br><br><br>

										<!-- Removed the duplicate options section since it's now in the info box above -->

									</td>
								</tr>

								<tr>
									<td style="height:40px;">&nbsp;</td>
								</tr>

							</table>
						</td>
					</tr>

					<tr>
						<td style="height:80px;">&nbsp;</td>
					</tr>

				</table>
			</td>
		</tr>
	</table>

</body>

</html>