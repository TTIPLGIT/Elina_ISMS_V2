<?php

namespace App\Http\Controllers;

use Google\Service\Dataform\WriteFile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Redirect;
use PHPJasper\PHPJasper;
use PDF;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;


class cashfreecontroller extends BaseController
{
    public function store(Request $request)
    {
        try {
            $method = 'Method => cashfreecontroller => store';
            $url = 'https://sandbox.cashfree.com/pg/orders';
            $headers = array(
                "Content-Type: application/json",
                "x-api-version: 2021-05-21",
                "x-client-id: " . config('setting.cashfree_client_id'),
                "x-client-secret: " . config('setting.cashfree_client_secret')
            );
            $orderid =  'Elina_' . rand(1111111111, 9999999999);
            $enrollment_id = $request->enrollment_id;
            $payment_for = str_replace(' ', '_', $request->payment_for);
            $customer_phone = str_replace(' ', '', $request->phone_num);
            $data = json_encode([
                'order_id' =>  $orderid,
                'enrollment_id' => $enrollment_id,
                'order_amount' => $request->payment_amount,
                "order_currency" => "INR",
                "customer_details" => [
                    'child_id' => $request->child_id,
                    "customer_id" => 'Ref_' . rand(111111111, 999999999),
                    "customer_name" => $request->child_name,
                    "customer_email" => $request->initiated_to,
                    "customer_phone" => $customer_phone,
                ],
                "order_meta" => [
                    "return_url" => config('setting.base_url') . 'cashfree/payments/success?order_id={order_id}&enrollment=' . $enrollment_id . '&payment_for=' . $payment_for . '&order_token={order_token}'
                ]
            ]);


            $curl = curl_init($url);
            curl_setopt($curl, CURLOPT_URL, $url);
            curl_setopt($curl, CURLOPT_POST, true);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $data);

            $resp = curl_exec($curl);

            if (isset($resp['code'])) {
                echo 'failed';
                exit;
            }
            curl_close($curl);
            return redirect()->to(json_decode($resp)->payment_link);
        } catch (\Exception $exc) {
            return $this->sendLog($method, $exc->getCode(), $exc->getMessage(), $exc->getLine(), $exc->getTrace()[0]['args'][2]);
        }
    }

    public function success(Request $request)
    {
        try {

            $method = 'Method => cashfreecontroller => success';
            $order_id = $request->order_id;
            $client = new Client();

            $headers = [
                'accept' => 'application/json',
                'x-api-version' => '2022-09-01',
                'x-client-id' => config('setting.cashfree_client_id'),
                'x-client-secret' => config('setting.cashfree_client_secret')
            ];

            //   dd($headers);
            $url = 'https://sandbox.cashfree.com/pg/orders/' . $order_id . '/payments';

            $response = $client->request('GET', $url, [
                'headers' => $headers
            ]);
            $body = $response->getBody()->getContents();
            $parant_data = json_decode($body);


            $payment_status = $parant_data[0]->payment_status;
            $data = array();
            $data['enrollment_id'] = $request->enrollment;
            $data['payment_amount'] = $parant_data[0]->order_amount;
            $data['payment_status'] = $parant_data[0]->payment_status;
            $data['transaction_id'] = $parant_data[0]->cf_payment_id;
            $data['payment_for'] = str_replace('_', ' ', $request->payment_for);
            $data['receipt_num'] = $request->order_id;
            $data['register_receipt'] = '';
            $data['bank_referance'] = $parant_data[0]->bank_reference;
            $data['payment_completion_time'] = $parant_data[0]->payment_completion_time;
            $data['payment_currency'] = $parant_data[0]->payment_currency;
            $data['payment_method'] = json_encode($parant_data[0]->payment_method);

            $encryptArray = $this->encryptData($data);
            $request = array();
            $request['requestData'] = $encryptArray;

            $gatewayURL = config('setting.api_gateway_url') . '/payment/storedata';


            $response = $this->serviceRequest($gatewayURL, 'POST', json_encode($request), $method);
            $response1 = json_decode($response);
            if ($response1->Status == 200 && $response1->Success) {
                $objData = json_decode($this->decryptData($response1->Data));
                if ($objData->Code == 200) {
                    $parant_data = json_decode(json_encode($objData->Data), true);
                    if ($payment_status == 'SUCCESS') {
                        $this->report($parant_data);
                        return redirect(route('payuserfee.index'))->with('success', 'Payment process is complete. Thank you!');
                    } else {
                        return Redirect::back()->with('fail', 'Payment Failed');
                    }
                }

                if ($objData->Code == 400) {
                    return Redirect::back()->with('fail', 'Payment Failed');
                }
            } else {
                $objData = json_decode($this->decryptData($response1->Data));
                echo json_encode($objData->Code);
                exit;
            }
        } catch (\Exception $exc) {
            return $this->sendLog($method, $exc->getCode(), $exc->getMessage(), $exc->getLine(), $exc->getTrace()[0]['args'][2]);
        }
    }
    public function report($report_data)
    {
        $method = 'Method => Paymentcontroller => report';
        $amount = $report_data['amount'];
        
        if ($amount == 500 || $amount == 900 || $amount == 1000) {
            $paymentFor = 'User Register for';
            if($amount == 1000)
            {
                $amount_text = 'Nine Hundred';
            }
            else
            {
                $amount_text = 'Thousand';
            }
            $amount_text = 'Nine Hundred';
            $folderPath = $report_data['initiated_to'];
            //$folderPath = str_replace(' ', '-', $folderPath);
            $findString = array(' ', '&');
            $replaceString = array('-', '-');
            $folderPath = str_replace($findString, $replaceString, $folderPath);
            $storagePath = public_path() . '/receipt_document/' . $folderPath;


            if (!File::exists($storagePath)) {
                $storagePath = public_path() . '/receipt_document/';

                $arrFolder = explode('/', $folderPath);
                foreach ($arrFolder as $key => $value) {
                    $storagePath .= '/' . $value;

                    if (!File::exists($storagePath)) {
                        File::makeDirectory($storagePath,0777,true);
                    }
                }
            }


            $documentName = 'registration_receipt.pdf';
            $document_name = 'registration_receipt';
            $input = base_path() . '/reports/registration_receipt.jasper';


            //$input = 'C:\xampp\htdocs\jasperreport\storage\app\public\reports/userreport.jasper';
            $output = $storagePath . '/' . $documentName;
            $output_1 = $storagePath . '/' . $document_name;
            $storagePath = public_path() . '/receipt_document/';
            $report_path = public_path() . '/receipt_document/' . $folderPath;
        } else if ($amount == 8100 || $amount == 11000) {
            $paymentFor = 'Professional fee for SAIL program offered to';
            if($amount == 8100)
            {
                $amount_text = 'Eight Thousand and Hundred';
            }
            else
            {
                $amount_text = 'Eleven Thousand';
            }
            $folderPath = $report_data['initiated_to'];
            //$folderPath = str_replace(' ', '-', $folderPath);
            $findString = array(' ', '&');
            $replaceString = array('-', '-');
            $folderPath = str_replace($findString, $replaceString, $folderPath);
            $storagePath = public_path() . '/sail_receipt_document/' . $folderPath;

            if (!File::exists($storagePath)) {
                $storagePath = public_path() . '/sail_receipt_document/';

                $arrFolder = explode('/', $folderPath);
                foreach ($arrFolder as $key => $value) {
                    $storagePath .= '/' . $value;

                    if (!File::exists($storagePath)) {
                        File::makeDirectory($storagePath,0777,true);
                    }
                }
            }


            $documentName = 'registration_receipt.pdf';
            $document_name = 'registration_receipt';
            $input = base_path() . '/reports/registration_receipt.jasper';
            $output = $storagePath . '/' . $documentName;
            $output_1 = $storagePath . '/' . $document_name;
            $storagePath = public_path() . '/sail_receipt_document/';
            $report_path = public_path() . '/sail_receipt_document/' . $folderPath;
        }

        $receipt_number = $report_data['receipt_number']; //$this->WriteFileLog($receipt_number);
        // $options = [
        //     'format' => ['pdf'],
        //     'locale' => 'en',
        //     'params' => [
        //         'receipt_number' => $receipt_number,
        //         'amount' => $amount,
        //         'amount_text' => $amount_text,
        //     ],

        //     'db_connection' => [
        //         'driver' => 'mysql',
        //         'username' => config('setting.db_username'),
        //         'password' => config('setting.db_password'),
        //         'host' => '127.0.0.1',
        //         'database' => config('setting.db_database'),
        //         'port' => config('setting.db_port'),
        //     ]
        // ];

        $jasper = new PHPJasper;
        // echo json_encode($output_1); exit;
        // echo json_encode($options); exit;
        // $jasper->process(
        //     $input,
        //     $output_1,
        //     $options
        // )->execute();

        // $documentName = 'registration_receipt.pdf';
        // $headers = array(
        //     'Content-Type: application/pdf',
        // );

        $amount_text = $this->numberToWords($amount);

        $data = [
            'receipt_number' => $receipt_number,
            'amount' => $amount,
            'amount_text' => $amount_text,
            'child_name' => $report_data['child_name'],
            'paymentFor' => $paymentFor,
            'father' => $report_data['father'],
            'mother' => $report_data['mother'],
        ];
        $pdf = PDF::loadView('pdfTemplates.receipt', compact('data'));
        $pdf->save($output);
        // dd($output);
        $data = array();
        $data['register_receipt'] = $output;
        $data['receipt_number'] = $receipt_number;
        $encryptArray = $this->encryptData($data);
        $request = array();
        $request['requestData'] = $encryptArray;
        $gatewayURL = config('setting.api_gateway_url') . '/payment/storedata/email';
        $response = $this->serviceRequest($gatewayURL, 'POST', json_encode($request), $method);
        $response1 = json_decode($response);
        if ($response1->Status == 200 && $response1->Success) {
            return true;
        } else {
            $objData = json_decode($this->decryptData($response1->Data));
            echo json_encode($objData->Code);
            exit;
        }
    }
}
