<html>

<head>

	<style>
		@page {
			margin: 0cm 0cm;
		}

		/* vietnamese */
		@font-face {
			font-family: 'Barlow';
			font-style: normal;
			font-weight: 400;
			src: url(https://fonts.gstatic.com/s/barlow/v12/7cHpv4kjgoGqM7E_A8s52Hs.woff2) format('woff2');
			unicode-range: U+0102-0103, U+0110-0111, U+0128-0129, U+0168-0169, U+01A0-01A1, U+01AF-01B0, U+0300-0301, U+0303-0304, U+0308-0309, U+0323, U+0329, U+1EA0-1EF9, U+20AB;
		}

		/* latin-ext */
		@font-face {
			font-family: 'Barlow';
			font-style: normal;
			font-weight: 400;
			src: url(https://fonts.gstatic.com/s/barlow/v12/7cHpv4kjgoGqM7E_Ass52Hs.woff2) format('woff2');
			unicode-range: U+0100-02AF, U+0304, U+0308, U+0329, U+1E00-1E9F, U+1EF2-1EFF, U+2020, U+20A0-20AB, U+20AD-20CF, U+2113, U+2C60-2C7F, U+A720-A7FF;
		}

		/* latin */
		@font-face {
			font-family: 'Barlow';
			font-style: normal;
			font-weight: 400;
			src: url(https://fonts.gstatic.com/s/barlow/v12/7cHpv4kjgoGqM7E_DMs5.woff2) format('woff2');
			unicode-range: U+0000-00FF, U+0131, U+0152-0153, U+02BB-02BC, U+02C6, U+02DA, U+02DC, U+0304, U+0308, U+0329, U+2000-206F, U+2074, U+20AC, U+2122, U+2191, U+2193, U+2212, U+2215, U+FEFF, U+FFFD;
		}

		.flyleaf {
			page-break-after: always;
		}

		body {
			margin-top: 2cm;
			margin-left: 2cm;
			margin-right: 2cm;
			margin-bottom: 2cm;
			/* font-family: 'Barlow !important'; */
			font-family: 'Barlow Semi Condensed !important';
		}

		header {
			position: fixed;
			top: 0cm;
			left: 0cm;
			right: 0cm;
			height: fit-content !important;
		}

		footer {
			position: fixed;
			bottom: 0cm;
			left: 0cm;
			right: 0cm;
			height: 2cm;
		}

		select {
			appearance: none !important;
			border: none;
			-moz-appearance: none;
			-webkit-appearance: none;
		}

		img {
			display: block;
			margin: 0 auto;
			width: 35%;
		}
	</style>
</head>

<body>
	<div style="text-align:center;">
		<img src="C:\Apache24\htdocs\Elina ISMS\v1\web\public\images/elina-logo-2.png">
	</div>
	<h2 style="text-align: center;">&nbsp;</h2>
	<h2 style="text-align: center;"><strong>Listening to the parents - Conversation</strong></h2>
	@foreach($group as $key => $value)
	<div class="row navcard navcard{{$value['id']}}">
		<div class="col-12">
			<div class="card">
				<div class="card-body">
					<div class="table-wrapper">
						<div class="table-responsive">
							<table class="table myTable" style="width: 100%;border-spacing: 0px;border-collapse: collapse;">
								@if($value['add_questions'] == 1)
								<thead>
									<tr>
										<th width="30%" style="padding:0px;border: 1px solid #040404 !important;color: #141414;background-color: white !important;">Areas</th>
										<th width="35%" style="padding:0px;border: 1px solid #040404 !important;color: #141414;background-color: white !important;"></th>
										<th width="35%" style="padding:0px;border: 1px solid #040404 !important;color: #141414;background-color: white !important;">Conversation summary</th>
									</tr>
								</thead>
								<tbody id="table_{{$value['id']}}">
									@foreach($questions as $question)
									@if($question['group_id'] == $value['id'])
									<tr>
										<td width="30%" style="padding:0px;text-align:left !important;border: 1px solid #040404 !important;color: #141414;background-color: white !important;">{!! $question['question'] !!}<span class="tooltiptext1">{!! $question['question_description']!!}</span></td>
										<td width="35%" style="padding:0px;background: white;border: 1px solid #0e0e0e !important;">{!! $fetchdata1[0][$question['question_column_name']] !!}</td>
										<td width="35%" style="padding:0px;background: white;border: 1px solid #0e0e0e !important;">{!! $fetchdata[0][$question['question_column_name']] !!}</td>
									</tr>
									@endif
									@endforeach
								</tbody>
								@else
								@if($value['id'] == 3)
								<thead>
									<tr>
										<td style="padding:0px;border: 1px solid #040404 !important;color: #141414;background-color: white !important;"><strong>Areas</strong>&nbsp;</td>
										<td style="padding:0px;border: 1px solid #040404 !important;color: #141414;background-color: white !important;"><strong>Conversation summary</strong></td>
										@if(isset($rows[1]))
										<td style="padding:0px;border: 1px solid #040404 !important;color: #141414;background-color: white !important;"><strong>Conversation summary</strong></td>
										
										@else
										<td style="padding:0px;border: 1px solid #040404 !important;color: #141414;background-color: white !important;"><strong>Conversation summary</strong></td>

										@endif
									</tr>
									<tr>
										<td style="padding:0px;border: 1px solid #040404 !important;color: #141414;background-color: white !important;">&nbsp;</td>
										<td style="padding:0px;border: 1px solid #040404 !important;color: #141414;background-color: white !important;"><strong>{{$rows[0]['name']}}</strong></td>
										@if(isset($rows[1]))
										<td style="padding:0px;border: 1px solid #040404 !important;color: #141414;background-color: white !important;"><strong>{{$rows[1]['name']}}</strong></td>
										@else
										<td style="padding:0px;border: 1px solid #040404 !important;color: #141414;background-color: white !important;"><strong></strong></td>
										@endif
									</tr>
								</thead>
								<tbody id="table_{{$value['id']}}">
									@foreach($questions as $question)
									@if($question['group_id'] == $value['id'])
									<tr>
										<td width="35%" style="padding:0px;text-align:left !important;border: 1px solid #040404 !important;color: #141414;background-color: white !important;">{!! $question['question'] !!}<span class="tooltiptext1">{!! $question['question_description'] !!}</span></td>
										<td style="padding:0px;background: white;border: 1px solid #0e0e0e !important;">{!! $fetchdata[0][$question['question_column_name']] !!}</td>
										@if(isset($fetchdata[1]))
										<td style="padding:0px;background: white;border: 1px solid #0e0e0e !important;">{!! $fetchdata[1][$question['question_column_name']] !!}</td>
										@else
										<td style="padding:0px;background: white;border: 1px solid #0e0e0e !important;"></td>
										@endif
									</tr>
									@endif
									@endforeach
								</tbody>
								@else
								<thead>
									<tr>
										<th width="35%" style="padding:0px;border: 1px solid #040404 !important;color: #141414;background-color: white !important;">Areas</th>
										<th style="padding:0px;border: 1px solid #040404 !important;color: #141414;background-color: white !important;">Conversation summary</th>
									</tr>
								</thead>
								<tbody id="table_{{$value['id']}}">
									@foreach($questions as $question)
									@if($question['group_id'] == $value['id'])
									<tr>
										<td width="35%" style="padding:0px;text-align:left !important;border: 1px solid #040404 !important;color: #141414;background-color: white !important;">{!! $question['question'] !!}<span class="tooltiptext1">{!! $question['question_description'] !!}</span></td>
										<td style="padding:0px;background: white;border: 1px solid #0e0e0e !important;">{!! $fetchdata[0][$question['question_column_name']] !!}</td>
									</tr>
									@endif
									@endforeach
								</tbody>
								@endif
								@endif
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	@if($loop->last)
	
	@else
	<p style="page-break-after: always"></p>
	@endif
	@endforeach
</body>

</html>