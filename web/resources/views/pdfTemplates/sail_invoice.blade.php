<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8" />
	<style>
		.invoice-box {
			/* max-width: 800px; */
			/* margin: auto; */
			/* padding: 30px; */
			/* border: 1px solid #eee; */
			/* box-shadow: 0 0 10px rgba(0, 0, 0, 0.15); */
			font-size: 12px;
			/* line-height: 24px; */
			font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;
			color: black;
		}

		.invoice-box table {
			width: 100%;
			line-height: inherit;
			text-align: left;
		}

		.invoice-box table td {
			padding: 5px;
			vertical-align: middle;
		}

		.invoice-box table tr td:nth-child(2) {
			text-align: right;
		}

		.invoice-box table tr.top table td {
			padding-bottom: 20px;
		}

		.invoice-box table tr.top table td.title {
			font-size: 45px;
			line-height: 45px;
			color: #333;
		}

		.invoice-box table tr.information table td {
			padding-bottom: 40px;
		}

		.invoice-box table tr.heading td {
			background: #eee;
			border-bottom: 1px solid #ddd;
			font-weight: bold;
			text-align: center;
		}

		.invoice-box table tr.details td {
			padding-bottom: 20px;
			text-align: center;
		}

		.invoice-box table tr.item td {
			border-bottom: 1px solid #eee;
			text-align: center;
		}

		.invoice-box table tr.item.last td {
			border-bottom: none;
		}

		.invoice-box table tr.total td:nth-child(2) {
			border-top: 2px solid #eee;
			font-weight: bold;
		}

		@media only screen and (max-width: 600px) {
			.invoice-box table tr.top table td {
				width: 100%;
				display: block;
				text-align: center;
			}

			.invoice-box table tr.information table td {
				width: 100%;
				display: block;
				text-align: center;
			}
		}

		/** RTL **/
		.invoice-box.rtl {
			direction: rtl;
			font-family: Tahoma, 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;
		}

		.invoice-box.rtl table {
			text-align: right;
		}

		.invoice-box.rtl table tr td:nth-child(2) {
			text-align: left;
		}

		footer {
			position: fixed;
			bottom: 0cm;
			left: 0cm;
			right: 0cm;
			height: 2cm;
		}

		.low_opacity {
			opacity: 0.6;
		}
	</style>
</head>

<body>
	<div class="invoice-box">
		<table cellpadding="0" cellspacing="0">
			<tr class="top">
				<td colspan="5">
					<table>
						<tr>
							<td class="title">
								<img src="C:\Apache24\htdocs\Elina ISMS\v1\web\public\images\elina-logo-new.png" style="width: 50%; max-width: 300px" />
							</td>

							<td>
								<br />
								<h2>INVOICE<br /># ESIS-I-{{ date('Y') }}/{{$data['id']}}</h2>
							</td>
						</tr>
					</table>
				</td>
			</tr>

			<tr class="information">
				<td colspan="5">
					<table>
						<tr>
							<td>
								<strong>Vimarshi Solutions Private Limited</strong><br /><br />
								<div class="low_opacity">
									C1 - 301, Pelican Nest<br />
									Creek Street, OMR<br />
									Chennai Tamil Nadu 600097<br />
									India
								</div>
							</td>
						</tr>
					</table>
				</td>
			</tr>

			<tr class="information">
				<td colspan="5">
					<table>
						<tr>
							<td>
								To<br />
								@if(isset($data['father_name']))
								<strong>{{$data['father_name']}}</strong><br />
								@endif
								Elina Services For: {{$data['child_name']}}
							</td>

							<td>
								<b>Invoice Date: {{ date('d-m-Y') }}</b><br />
								<b>Terms: Due On Receipt</b><br />
							</td>
						</tr>
					</table>
				</td>
			</tr>

			<tr class="heading">
				<td width="5%">#</td>
				<td width="60%">Items & Description</td>
				<td width="10%">QTY</td>
				<td width="15%">Rate</td>
				<td width="10%">Amount</td>
			</tr>

			@foreach($data['serviceList'] as $brifing)
			<tr class="details">
				<td>{{ $loop->iteration }}</td>
				<td style="text-align: left !important;">{{ $brifing->service_briefing }}</td>
				<td>{{ $brifing->quantity }}</td>
				<td>{{ $brifing->rate }}</td>
				<td>{{ $brifing->amount }}</td>
			</tr>
			@endforeach

			<tr>
				<td colspan="5"></td>
			</tr>

			<tr class="item">
				<td colspan="3"></td>
				<td>Sub Total</td>
				<td>{{$data['baseAmount']}}</td>
			</tr>

			<tr class="item">
				<td colspan="3"></td>
				<td>GST</td>
				<td>{{$data['gstAmount']}}.00</td>
			</tr>

			<tr class="item">
				<td colspan="3"></td>
				<td>Total</td>
				<td>{{$data['register_fee']}}</td>
			</tr>

			<tr class="item">
				<td colspan="3"></td>
				<td>Payment Made </td>
				<td style="color: red;">(-) {{$data['register_fee']}}</td>
			</tr>

			<tr class="heading">
				<td colspan="3"></td>
				<td>Balance Due</td>
				<td>{{$data['register_fee']}}</td>
			</tr>

			<tr class="total">
				<td></td>
				<td colspan="4">Total In Words Indian Rupee {{$data['in_words']}} Only</td>
			</tr>
			<tr>
				<td colspan="5">Notes</td>
			</tr>
			<tr>
				<td colspan="5">Thanks for choosing Elina Services</td>
			</tr>
			<tr>
				<td colspan="5"></td>
			</tr>
			<tr>
				<td colspan="5"></td>
			</tr>

			<!-- <tr>
				<td colspan="5">Terms & Condition</td>
			</tr> -->
			<tr>
				<td colspan="5"></td>
			</tr>
			<!-- <tr>
				<td colspan="5">tc1</td>
			</tr>
			<tr>
				<td colspan="5">tc2</td>
			</tr>
			<tr>
				<td colspan="5">tc3</td>
			</tr> -->
			<tr>
				<td colspan="5"><img src="C:\Apache24\htdocs\Elina ISMS\v1\web\public\images\rama_mam_sign.JPG" style="width: 15%;" /></br><strong style="width: 15%;">Ramalakshmi. K - For Elina</strong></td>
			</tr>
		</table>
		<footer>
			<P style="border-top: 1px solid;opacity: 0.5;">ELiNA is a trademark of Vimarshi Solutions Private Limited.(CIN: U85500TN2023PTC160587)</P>
		</footer>
	</div>
</body>

</html>