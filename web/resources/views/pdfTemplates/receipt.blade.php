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
            font-size: 16px;
            font-weight: 500;
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

        /* .invoice-box table tr td:nth-child(2) {
            text-align: right;
        } */

        .invoice-box table tr.top table td {
            padding-bottom: 20px;
        }

        .invoice-box table tr.top table td.title {
            font-size: 45px;
            line-height: 25px;
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

        .payment {
            background: #80ac54;
            text-align: center;
            font-weight: 900;
            color: white;
        }

        .text-center {
            text-align: left;
            opacity: 0.6;
        }

        .text-center1 {
            text-align: left;
            /* border-bottom: 1px solid; */
        }

        .height-tr {
            line-height: 25px;
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
        <table cellpadding="0" cellspacing="0" style="margin:50px 0 0 0;">
            <tr class="top">
                <td colspan="3">
                    <table>
                        <tr>
                            <td class="title">
                                <img src="C:\Apache24\htdocs\Elina ISMS\v1\web\public\images\elina-logo-new.png" style="width: 50%; max-width: 300px" />
                            </td>

                            <td style="text-align: left;">
                                <br />
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
            <tr>
                <td colspan="3" style="opacity: 0.5;">
                    <hr>
                </td>
            </tr>
            <tr>
                <td colspan="3"></td>
            </tr>
            <tr class="height-tr">
                <td colspan="3" style="text-align: center;">PAYMENT RECEIPT</td>
            </tr>
            <tr>
                <td colspan="3"></td>
            </tr>
            <tr>
                <td colspan="3"></td>
            </tr>
            <tr>
                <td colspan="3"></td>
            </tr>
            <tr>
                <td colspan="3"></td>
            </tr>
            <tr class="height-tr">
                <td width="20%" class="text-center">Payment Date</td>
                <td width="40%" class="text-center1"><strong>{{ date('d-m-Y') }}</strong>
                    <hr>
                </td>
                <td width="40%" rowspan="3" class="payment">Amount Received<br>Rs. {{$data['amount']}}</td>
            </tr>
            <tr class="height-tr">
                <td class="text-center">Receipt Number</td>
                <td class="text-center1"><strong>{{$data['receipt_number']}}</strong>
                    <hr>
                </td>
                <!-- <td ></td> -->
            </tr>
            <tr class="height-tr">
                <td class="text-center">Payment Mode</td>
                @if(isset($data['payment_mode'])) 
                <td class="text-center1"><strong>{{$data['payment_mode']}}</strong><hr></td>
                @else
                <td class="text-center1"><strong>Bank Transfer</strong><hr></td>
                @endif
                <!-- <td></td> -->
            </tr>
            <tr class="height-tr">
                <td class="text-center">Amount Received in words</td>
                <td class="text-center1"><strong>{{$data['amount_text']}}</strong>
                    <hr>
                </td>
                <td></td>
            </tr>

            <tr>
                <td colspan="3"></td>
            </tr>
            <tr>
                <td colspan="3"></td>
            </tr>
            <!-- <tr class="height-tr">
                <td colspan="3">Elina's ISMS User Registration Fees : {{$data['amount']}}</td>
            </tr> -->
            <tr class="height-tr">
                <td colspan="3"></td>
            </tr>
            <tr class="height-tr">
                <td colspan="3"></td>
            </tr>
            <tr class="height-tr">
                <td colspan="3"></td>
            </tr>
            <tr class="height-tr">
                <td colspan="3"></td>
            </tr>
        </table>
        <table cellpadding="0" cellspacing="0" style="margin: 50px 0 0 0;opacity:0.5%">
            <tr>
                <td width="70%">Received From </br> <strong>
                        @if ($data['mother'])
                        {{ $data['father'] }} / {{ $data['mother'] }}
                        @else
                        {{ $data['father'] }}
                        @endif
                    </strong>
                    </br> 
                    {{$data['paymentFor']}} : {{$data['child_name']}}</td>
                <td width="30%" style="text-align: right;" colspan="3"><img src="C:\Apache24\htdocs\Elina ISMS\v1\web\public\images\rama_mam_sign.JPG" style="width: 50%;margin: 0 85px 0 0px;" /><br>Ramalakshmi. K - For Elina</td>
            </tr>
        </table>
        <footer>
            <P style="border-top: 1px solid;opacity: 0.5;">ELiNA is a trademark of Vimarshi Solutions Private Limited.(CIN: U85500TN2023PTC160587)</P>
        </footer>
    </div>
</body>

</html>