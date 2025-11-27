<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Redirect;
use PHPJasper\PHPJasper;
use GuzzleHttp\Client;
use Pdf;
use Illuminate\Support\Facades\DB;

class Paymentcontroller extends BaseController
{

    //
    public function index(Request $request)
    {
        $user_id = $request->session()->get("userID");
        $method = 'Method => LoginController => Register_screen';
        $client = new Client();
        $request =  array();
        $request['user_id'] = $user_id;

        $gatewayURL = config('setting.api_gateway_url') . '/payment/index';
        $response = $this->serviceRequest($gatewayURL, 'GET',  json_encode($request), $method);

        $response = json_decode($response);

        $objData = json_decode($this->decryptData($response->Data));
        $rows = json_decode(json_encode($objData->Data), true);


        $refund_details = [];
        $payment_id = [];
        $payments = $rows['payments'];
        $roleID = $rows['roleID'];
        $rows = $rows['rows'];
        // dd(json_decode($payments['refund_details']));
        $menus = $this->FillMenu();
        $screens = $menus['screens'];
        $modules = $menus['modules'];
        foreach ($payments as $key => $value) {
            $refund_details[$key] = json_decode($payments[$key]['refund_details']);
            array_push($payment_id, $value['payment_id']);
        }
        if ($rows == [] && $roleID != 3) {
            return redirect(route('userregisterfee.index'));
        } else {
            return view('payuserfee.index', compact('user_id', 'modules', 'screens', 'rows', 'payments', 'refund_details', 'payment_id'));
        }
    }
    public function cash_refund($parant_data)
    {

        $method = 'Method => Paymentcontroller => cash_refund';
        $data = array();
        $data['cf_payment_id'] = $parant_data[0]->cf_payment_id;
        $data['cf_refund_id'] = $parant_data[0]->cf_refund_id;
        $data['entity'] = $parant_data[0]->entity;
        $data['order_id'] = $parant_data[0]->order_id;
        $data['processed_at'] = $parant_data[0]->processed_at;
        $data['refund_amount'] = $parant_data[0]->refund_amount;
        $data['refund_arn'] = $parant_data[0]->refund_arn;
        $data['refund_charge'] = $parant_data[0]->refund_charge;
        $data['refund_currency'] = $parant_data[0]->refund_currency;
        $data['refund_id'] = $parant_data[0]->refund_id;
        $data['refund_mode'] = $parant_data[0]->refund_mode;
        $data['refund_note'] = $parant_data[0]->refund_note;
        $data['refund_speed'] = $parant_data[0]->refund_speed;
        $data['refund_splits'] = $parant_data[0]->refund_splits;
        $data['refund_status'] = $parant_data[0]->refund_status;
        $data['refund_type'] = $parant_data[0]->refund_type;
        $data['status_description'] = $parant_data[0]->status_description;
        $encryptArray = $this->encryptData($data);
        $request = array();
        $request['requestData'] = $encryptArray;
        // dd($data);
        $gatewayURL = config('setting.api_gateway_url') . '/cashpayment/refund';

        $response = $this->serviceRequest($gatewayURL, 'GET', '', $method);
        // dd($response);

        $response = json_decode($response);
        if ($response->Status == 200 && $response->Success) {
            return true;
        } else {
            $objData = json_decode($this->decryptData($response->Data));
            echo json_encode($objData->Code);
            exit;
        }
    }


    public function create(Request $request)
    {

        try {
            $method = 'Method => Paymentcontroller => create';
            $gatewayURL = config('setting.api_gateway_url') . '/payment/createdata';
            $response = $this->serviceRequest($gatewayURL, 'GET', '', $method);

            $response = json_decode($response);

            if ($response->Status == 200 && $response->Success) {
                $objData = json_decode($this->decryptData($response->Data));

                if ($objData->Code == 200) {
                    $parant_data = json_decode(json_encode($objData->Data), true);
                    $rows =  $parant_data['rows'];
                    $email = $parant_data['email'];
                    $enrollment = $parant_data['enrollment'];
                    $amount = $parant_data['enrollment'][0]['payment_amount'];
                    $amount = (int)$amount;
                    $menus = $this->FillMenu();
                    $screens = $menus['screens'];
                    $modules = $menus['modules'];
                    return view('payuserfee.create', compact('rows', 'screens', 'modules', 'email', 'enrollment', 'amount'));
                }
            } else {
                $objData = json_decode($this->decryptData($response->Data));
                echo json_encode($objData->Code);
                exit;
            }
        } catch (\Exception $exc) {

            return $this->sendLog($method, $exc->getCode(), $exc->getMessage(), $exc->getLine(), $exc->getTrace()[0]['args'][2]);
        }
    }

    public function create1($id)
    {
        try {
            $method = 'Method => Paymentcontroller => create';

            $ids = $this->DecryptData($id);


            $input = [
                'id' => $ids,
            ];

            $gatewayURL = config('setting.api_gateway_url') . '/signedLogin';
            $encryptArray = $this->encryptData($input);
            $request = array();
            $request['requestData'] = $encryptArray;
            $response1 = $this->serviceRequest($gatewayURL, 'POST', json_encode($request), $method);
            $response = json_decode($response1);



            if ($response->Status == 401) {
                // echo "fjhg";exit;
                return back()->withErrors(['recaptcha' => ['Invalid user name or password']]);
            }




            if ($response->Status == 200 && $response->Success) {
                $objData = json_decode($this->decryptData($response->Data));
                $objRows = $objData;
                $row = json_decode(json_encode($objRows), true); //dd($row);
                session(['accessToken' => $row['access_token']]);
                session(['userType' => $row['user']['user_type']]);
                session(['userID' => $row['user']['id']]);
                session(['sessionTimer' => $objData->formattedDateTime]);
                $menus = $this->FillMenu();
                $screens = $menus['screens'];
                $modules = $menus['modules'];
            }

            $gatewayURL = config('setting.api_gateway_url') . '/payment/createdata1/' . $id;
            $response = $this->serviceRequest($gatewayURL, 'GET', '', $method);
            $response = json_decode($response);
            if ($response->Status == 200 && $response->Success) {
                $objData = json_decode($this->decryptData($response->Data));

                if ($objData->Code == 200) {
                    $parant_data = json_decode(json_encode($objData->Data), true);
                    $rows =  $parant_data['rows'];
                    $email = $parant_data['email'];
                    $enrollment = $parant_data['enrollment'];

                    if ($enrollment == []) {
                        return redirect(route('payuserfee.index'))->with('fail', 'Payment Already Completed');
                    }


                    $menus = $this->FillMenu();
                    $screens = $menus['screens'];
                    $modules = $menus['modules'];
                    return view('payuserfee.create', compact('rows', 'screens', 'modules', 'email', 'enrollment'));
                }
            } else {
                $objData = json_decode($this->decryptData($response->Data));
                echo json_encode($objData->Code);
                exit;
            }
        } catch (\Exception $exc) {

            return $this->sendLog($method, $exc->getCode(), $exc->getMessage(), $exc->getLine(), $exc->getTrace()[0]['args'][2]);
        }
    }

    public function store(Request $request)
    {
        try {
            $method = 'Method => Paymentcontroller => store';
            $data = array();
            $data['enrollment_child_num'] = $request->enrollment_child_num;
            $data['child_id'] = $request->child_id;
            $data['child_name'] = $request->child_name;
            $data['initiated_by'] = $request->initiated_by;
            $data['initiated_to'] = $request->initiated_to;
            $data['payment_amount'] = $request->payment_amount;
            $data['payment_status'] = 'Paid';
            $data['payment_process_description'] = $request->payment_process_description;
            $data['transaction_id'] = $request->transaction_id;
            $data['receipt_num'] = $request->receipt_num;
            $data['register_receipt'] = '';
            $data['payment_for'] = $request->payment_for;
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
                    $this->report($parant_data);
                    return redirect(route('payuserfee.index'))->with('success', 'Payment process is complete. Thank you!');
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

    public function show($id)
    {

        try {

            $method = 'Method => Paymentcontroller => show';

            // echo json_encode($id);exit;
            $gatewayURL = config('setting.api_gateway_url') . '/payment/data_edit/' . $id;

            $response = $this->serviceRequest($gatewayURL, 'GET', '', $method);

            $response = json_decode($response);

            if ($response->Status == 200 && $response->Success) {
                $objData = json_decode($this->decryptData($response->Data));
                if ($objData->Code == 200) {
                    $parant_data = json_decode(json_encode($objData->Data), true);


                    $rows = $parant_data['rows'];

                    $menus = $this->FillMenu();
                    $screens = $menus['screens'];
                    $modules = $menus['modules'];
                    return view('payuserfee.show', compact('rows', 'screens', 'modules'));
                }
            } else {
                $objData = json_decode($this->decryptData($response->Data));
                echo json_encode($objData->Code);
                exit;
            }
        } catch (\Exception $exc) {
            return $this->sendLog($method, $exc->getCode(), $exc->getMessage(), $exc->getLine(), $exc->getTrace()[0]['args'][2]);
        }
        //

    }

    public function report($report_data)
    {
        $method = 'Method => Paymentcontroller => report';
        $amount = $report_data['amount'];
        if ($amount == 500 || $amount == 900 || $amount == 11000) {
            $paymentFor = 'User Register for';
            if ($amount == 900) {
                $amount_text = 'Nine Hundred';
            } else {
                $amount_text = 'Thousand';
            }

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
                        File::makeDirectory($storagePath);
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
            if ($amount == 8100) {
                $amount_text = 'Eight Thousand and Hundred';
            } else {
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
                        File::makeDirectory($storagePath);
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

    public function compasspay_create(Request $request)
    {
        $menus = $this->FillMenu();
        $screens = $menus['screens'];
        $modules = $menus['modules'];
        return view('payuserfee.compasscreate', compact('screens', 'modules'));
    }


    public function compasspay_show($id)
    {


        $menus = $this->FillMenu();
        $screens = $menus['screens'];
        $modules = $menus['modules'];
        return view('payuserfee.compassshow', compact('screens', 'modules'));
    }

    public function offline_request(Request $request)
    {
        try {
            $method = 'Method => Paymentcontroller => offline_request';

            $data = array();
            $data['payment_status_id'] = $request['payment_status_id'];
            $data['initiated_to'] = $request['initiated_to'];
            $data['payment_type'] = $request['payment_type'];

            $encryptArray = $this->encryptData($data);
            $request = array();
            $request['requestData'] = $encryptArray;
            $gatewayURL = config('setting.api_gateway_url') . '/payment/offline/request';

            $response = $this->serviceRequest($gatewayURL, 'POST', json_encode($request), $method);

            $response1 = json_decode($response);

            if ($response1->Status == 200 && $response1->Success) {
                $objData = json_decode($this->decryptData($response1->Data));
                return redirect(route('ovmreport'))->with('success', 'Payment Details have been sent to your Registered Email');
            } else {
                $objData = json_decode($this->decryptData($response1->Data));
                echo json_encode($objData->Code);
                exit;
            }
        } catch (\Exception $exc) {

            return $this->sendLog($method, $exc->getCode(), $exc->getMessage(), $exc->getLine(), $exc->getTrace()[0]['args'][2]);
        }
    }

    public function payment_details($id)
    {
        // dd($id);
        try {
            $method = 'Method => Paymentcontroller => show';
            $gatewayURL = config('setting.api_gateway_url') . '/payment/data_edit/' . $id;
            $response = $this->serviceRequest($gatewayURL, 'GET', '', $method);
            $response = json_decode($response);
            if ($response->Status == 200 && $response->Success) {
                $objData = json_decode($this->decryptData($response->Data));
                if ($objData->Code == 200) {
                    $parant_data = json_decode(json_encode($objData->Data), true); //dd($parant_data);
                    $rows = $parant_data['rows'];
                    $amount = $rows[0]['payment_amount'];
                    $menus = $this->FillMenu();
                    $screens = $menus['screens'];
                    $modules = $menus['modules'];
                    return view('payuserfee.payment_details', compact('rows', 'amount', 'screens', 'modules'));
                }
            } else {
                $objData = json_decode($this->decryptData($response->Data));
                echo json_encode($objData->Code);
                exit;
            }
        } catch (\Exception $exc) {
            return $this->sendLog($method, $exc->getCode(), $exc->getMessage(), $exc->getLine(), $exc->getTrace()[0]['args'][2]);
        }
    }
}
