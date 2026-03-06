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
											margin:15px 0 0; line-height:24px; text-align:left;">
											It was a pleasure meeting you on {{$data['meeting_date']}}. 
											Thank you for the trust and openness with which you shared your child’s journey — their strengths, areas of difficulty, and your concerns, as we explored possible next steps together.
											<br><br>

											As discussed, the <strong>SAIL assessment</strong> is one pathway to help us build a clearer, structured understanding of your child’s learning and regulation needs.
											<br><br>

											Whenever you feel ready, please let us know if you would like to proceed with the SAIL process. Upon your confirmation, we will share:
										</p>

										<ul style="font-size:15px; color:#455056; line-height:24px; margin:10px 0 20px 40px; text-align:left;">
											<li>The detailed assessment roadmap</li>
											<li>Scheduling options</li>
											<li>Documentation requirements</li>
											<li>Timelines and next steps</li>
										</ul>

										<p style="font-size:15px; color:#455056; line-height:24px; text-align:left;">
											If you are exploring other options or would like more time to reflect, that is completely understandable. 
											Please feel free to inform us — we are here to support you in whatever decision feels right for your family.
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
												<strong style="color:#22c55e;">✓ If you choose to proceed (Accept):</strong><br>
												We will initiate the SAIL process and guide you step-by-step through the next phase.
											</p>

											<p style="font-size:15px; color:#455056; line-height:24px; margin:0;">
												<strong style="color:#ef4444;">✗ If you choose not to proceed (Decline) at this time:</strong><br>
												You may indicate one of the following so we can update our records accordingly:
											</p>

											<ul style="font-size:15px; color:#455056; line-height:24px; margin:10px 0 0 20px; padding-left:20px;">
												<li>I would like to revisit this after one month</li>
												<li>I would like to revisit this at a later time</li>
												<li>I have decided not to proceed with the SAIL process</li>
											</ul>

											<p style="font-size:15px; color:#666; line-height:24px; margin:15px 0 0 0;">
												Your response helps us ensure continuity and clarity in communication.
											</p>

											<p style="font-size:15px; color:#455056; line-height:24px; margin-top:20px;">
												Warm regards,<br>
												<strong>Team Elina</strong>
											</p>

										</div>

										<br><br><br>

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