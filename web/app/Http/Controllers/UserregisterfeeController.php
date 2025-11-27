<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use League\CommonMark\Extension\Attributes\Node\Attributes;
use Log;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Redirect;
use PHPJasper\PHPJasper;
use PDF;

class UserregisterfeeController extends BaseController
{
    public function index(Request $request)
    {
        $user_id = $request->session()->get("userID");
        $method = 'Method => LoginController => Register_screen';

        $request =  array();
        $request['user_id'] = $user_id;

        $gatewayURL = config('setting.api_gateway_url') . '/userregisterfee/index';
        $response = $this->serviceRequest($gatewayURL, 'GET',  json_encode($request), $method);

        $response = json_decode($response);
        $objData = json_decode($this->decryptData($response->Data));
        $rows = json_decode(json_encode($objData->Data), true);
        $payment_id = [];
        $payments = $rows['payments'];
        $rows = $rows['rows'];
        $menus = $this->FillMenu();
        $screens = $menus['screens'];
        $modules = $menus['modules'];
        foreach ($payments as $key => $value) {
            $refund_details[$value['payment_id']] = json_decode($payments[$key]['refund_details']);
            array_push($payment_id, $value['payment_id']);
        }

        return view('userregisterfee.index', compact('user_id', 'modules', 'screens', 'rows', 'payments', 'refund_details', 'payment_id'));
    }

    public function create(Request $request)
    {

        try {
            $user_id = $request->session()->get("userID");
            if ($user_id == null) {
                return view('auth.login');
            }
            $method = 'Method => UserregisterfeeController => create';
            $gatewayURL = config('setting.api_gateway_url') . '/userregisterfee/createdata';
            $response = $this->serviceRequest($gatewayURL, 'GET', '', $method);

            $response = json_decode($response);
            if ($response->Status == 200 && $response->Success) {
                $objData = json_decode($this->decryptData($response->Data));

                if ($objData->Code == 200) {
                    $parant_data = json_decode(json_encode($objData->Data), true);
                    $rows =  $parant_data['rows'];
                    $email = $parant_data['email'];
                    $paymenttokentime = $parant_data['paymenttokentime'];
                    $menus = $this->FillMenu();
                    $screens = $menus['screens'];
                    $modules = $menus['modules'];
                    return view('userregisterfee.create', compact('rows', 'screens', 'modules', 'email', 'paymenttokentime'));
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
            $user_id = $request->session()->get("userID");
            if ($user_id == null) {
                return view('auth.login');
            }
            $method = 'Method => UserregisterfeeController => store';

            $child_name = $request->child_name;
            $register_fee = $request->payment_amount;
            $parent_name = $request->child_father_guardian_name;

            $folderPath = $request->initiated_to;
            //$folderPath = str_replace(' ', '-', $folderPath);
            $findString = array(' ', '&');
            $replaceString = array('-', '-');
            $folderPath = str_replace($findString, $replaceString, $folderPath);
            $storagePath = public_path() . '/invoice_document/' . $folderPath;

            // if (!File::exists($storagePath)) {
            //     $storagePath = public_path() . '/invoice_document/';

            //     $arrFolder = explode('/', $folderPath);
            //     foreach ($arrFolder as $key => $value) {
            //         $storagePath .= '/' . $value;

            //         if (!File::exists($storagePath)) {
            //             File::makeDirectory($storagePath,0777,true);
            //         }
            //     }
            // }


            $documentName = 'Registration_invoice_receipt.pdf';
            // $document_name = 'Registration_invoice_receipt';
            // $input = base_path() . '/reports/Registration_invoice_receipt.jasper';


            // //$input = 'C:\xampp\htdocs\jasperreport\storage\app\public\reports/userreport.jasper';
            $output = $storagePath . '/' . $documentName;
            // $output_1 = $storagePath . '/' . $document_name;
            // $storagePath = public_path() . '/invoice_document/';
            // $report_path = public_path() . '/invoice_document/' . $folderPath;


            // $options = [
            //     'format' => ['pdf'],
            //     'locale' => 'en',
            //     'params' => [
            //         'father_name' => $parent_name,
            //         'child_name' => $child_name,
            //         'register_fee' => $register_fee,

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
            // $jasper = new PHPJasper;
            // //echo json_encode($output_1); exit;
            // //  echo json_encode($options); exit;
            // $jasper->process(
            //     $input,
            //     $output_1,
            //     $options
            // )->execute();

            // $documentName = 'Registration_invoice_receipt.pdf';
            // $headers = array(
            //     'Content-Type: application/pdf',
            // );

            $data = [
                'father_name' => $parent_name,
                'child_name' => $child_name,
                'register_fee' => $register_fee,
                'in_words' => 'Five Hundred',
            ];
            $pdf = PDF::loadView('pdfTemplates.invoice', $data);
            $pdf->save($output);

            $data = array();
            $data['enrollment_child_num'] = $request->enrollment_child_num;
            $data['child_id'] = $request->child_id;
            $data['child_name'] = $request->child_name;

            $data['initiated_by'] = $request->initiated_by;
            $data['initiated_to'] = $request->initiated_to;
            $data['payment_amount'] = $request->payment_amount;
            $data['payment_status'] = $request->payment_status;
            $data['payment_process_description'] = $request->payment_process_description;
            $data['payment_for'] = $request->payment_for;




            // $data['transaction_id'] = $request->transaction_id;
            // $data['receipt_num'] = $request->receipt_num;
            $paymenttokentime = $request->paymenttokentime;
            $paymenttokentime = (int)$paymenttokentime;
            $url = URL::temporarySignedRoute(
                'payuserfees.create1',
                now()->addMinutes($paymenttokentime),
                ['id' => encrypt($request->user_id)]
            );
            $data['url'] = $url;
            $notificationURL = substr($url, strrpos($url, "payuserfees"));
            $data['notificationURL'] = $notificationURL;
            $data['user_id'] = $request->user_id;
            $data['register_invoice'] = $output;
            $encryptArray = $this->encryptData($data);



            $request = array();
            $request['requestData'] = $encryptArray;
            $gatewayURL = config('setting.api_gateway_url') . '/userregisterfee/storedata';

            $response = $this->serviceRequest($gatewayURL, 'POST', json_encode($request), $method);

            $response1 = json_decode($response);
            if ($response1->Status == 200 && $response1->Success) {
                $objData = json_decode($this->decryptData($response1->Data));
                if ($objData->Code == 200) {
                    return redirect(route('userregisterfee.index'))
                        ->with('success', 'Payment Initated Successfully');
                }

                if ($objData->Code == 400) {
                    return redirect()->back()
                        ->with('fail', 'Payment Already Initiated');
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

            $method = 'Method => UserregisterfeeController => show';

            // echo json_encode($id);exit;
            $gatewayURL = config('setting.api_gateway_url') . '/userregisterfee/data_edit/' . $id;

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
                    return view('userregisterfee.show', compact('rows', 'screens', 'modules'));
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


    public function edit($id)
    {
        try {
            $method = 'Method => UserregisterfeeController => edit';

            $gatewayURL = config('setting.api_gateway_url') . '/userregisterfee/data_edit/' . $id;

            $response = $this->serviceRequest($gatewayURL, 'GET', '', $method);
            $response = json_decode($response);

            if ($response->Status == 200 && $response->Success) {
                $objData = json_decode($this->decryptData($response->Data));
                if ($objData->Code == 200) {
                    $parant_data = json_decode(json_encode($objData->Data), true);
                    $rows = $parant_data['rows'];


                    // $work_flow_row =  $parant_data['work_flow_row'];
                    $menus = $this->FillMenu();
                    $screens = $menus['screens'];
                    $modules = $menus['modules'];

                    return view('userregisterfee.edit', compact('rows', 'screens', 'modules'));
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


    public function update(Request $request, $id)
    {

        try {
            $method = 'Method =>  UserregisterfeeController => update_data';
            $data = array();
            $data['id'] = $id;
            $data['enrollment_id'] = $request->enrollment_id;
            $data['child_id'] = $request->child_id;
            $data['child_name'] = $request->child_name;
            $data['initiated_by'] = $request->initiated_by;
            $data['initiated_to'] = $request->initiated_to;
            $data['payment_amount'] = $request->payment_amount;


            $data['payment_status'] = $request->payment_status;
            $data['payment_process_description'] = $request->payment_process_description;


            $encryptArray = $this->encryptData($data);
            $request = array();

            $request['requestData'] = $encryptArray;
            $gatewayURL = config('setting.api_gateway_url') . '/userregisterfee/updatedata';
            $response = $this->serviceRequest($gatewayURL, 'POST', json_encode($request), $method);
            $response1 = json_decode($response);

            if ($response1->Status == 200 && $response1->Success) {

                $objData = json_decode($this->decryptData($response1->Data));

                if ($objData->Code == 200) {
                    return redirect(route('userregisterfee.index'))
                        ->with('success', 'enrollment Updated Successfully');
                }
                if ($objData->Code == 400) {
                    return Redirect::back()
                        ->with('fail', 'userregisterfee Name Already Exists');
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


    public function delete($id)
    {


        try {
            $method = 'Method => UserregisterfeeController => delete';
            //  $id = $this->decryptData($id);
            $gatewayURL = config('setting.api_gateway_url') . '/userregisterfee/data_delete/' . $this->encryptData($id);
            $response = $this->serviceRequest($gatewayURL, 'GET', '', $method);
            $response1 = json_decode($response);

            if ($response1->Status == 200 && $response1->Success) {
                $objData = json_decode($this->decryptData($response1->Data));
                if ($objData->Code == 200) {
                    return redirect(route('userregisterfee.index'))
                        ->with('success', 'Payment Screen Deleted Successfully');
                }
                if ($objData->Code == 400) {
                    return redirect(route('userregisterfee.index'))
                        ->with('fail', 'Payment Screen Allocated One Role');
                }
            }
        } catch (\Exception $exc) {

            return $this->sendLog($method, $exc->getCode(), $exc->getMessage(), $exc->getLine(), $exc->getTrace()[0]['args'][2]);
        }
    }


    public function GetAllDepartmentsByDirectorate(Request $request)

    {
        try {
            $method = 'Method => UserregisterfeeController => GetAllDepartmentsByDirectorate';

            $enrollment_child_num = $request->enrollment_child_num;

            $request = array();
            $request['requestData'] = $enrollment_child_num;

            $gatewayURL = config('setting.api_gateway_url') . '/userregisterfee/enrollmentlist';
            $serviceResponse = $this->serviceRequest($gatewayURL, 'POST', json_encode($request), $method);

            $serviceResponse = json_decode($serviceResponse);
            if ($serviceResponse->Status == 200 && $serviceResponse->Success) {
                $objData = json_decode($this->decryptData($serviceResponse->Data));
                if ($objData->Code == 200) {
                    $rows = json_decode(json_encode($objData->Data), true);
                    return $rows;
                    echo json_encode($rows);
                }
            }
        } catch (\Exception $exc) {
            $exceptionResponse = array();
            $exceptionResponse['ServiceMethod'] = $method;
            $exceptionResponse['Exception'] = $exc->getMessage();
            $exceptionResponse = json_encode($exceptionResponse, JSON_FORCE_OBJECT);
            $this->WriteFileLog($exceptionResponse);
        }
    }

    public function sail_create_data()
    {
        // dd('asdads');
        try {
            $method = 'Method => UserregisterfeeController => sailcreatedata';
            $gatewayURL = config('setting.api_gateway_url') . '/userregisterfee/sailcreate';
            // dd($gatewayURL);
            $response = $this->serviceRequest($gatewayURL, 'GET', '', $method);

            $response = json_decode($response);

            if ($response->Status == 200 && $response->Success) {
                $objData = json_decode($this->decryptData($response->Data));

                if ($objData->Code == 200) {
                    $parant_data = json_decode(json_encode($objData->Data), true);
                    $rows =  $parant_data['rows'];
                    $email = $parant_data['email'];
                    $paymenttokentime = $parant_data['paymenttokentime'];

                    $menus = $this->FillMenu();
                    $screens = $menus['screens'];
                    $modules = $menus['modules'];
                    return view('userregisterfee.sailcreate', compact('paymenttokentime', 'rows', 'screens', 'modules', 'email'));
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

    public function store_data(Request $request)
    {
        try {
            $method = 'Method => UserregisterfeeController => store_data';
            //sail invoice

            $child_name = $request->child_name;
            $payment_amount = $request->payment_amount;



            $folderPath = $request->initiated_to;
            //$folderPath = str_replace(' ', '-', $folderPath);
            $findString = array(' ', '&');
            $replaceString = array('-', '-');
            $folderPath = str_replace($findString, $replaceString, $folderPath);
            $storagePath = public_path() . '/sail_invoice_document/' . $folderPath;

            if (!File::exists($storagePath)) {
                $storagePath = public_path() . '/sail_invoice_document/';

                $arrFolder = explode('/', $folderPath);
                foreach ($arrFolder as $key => $value) {
                    $storagePath .= '/' . $value;

                    if (!File::exists($storagePath)) {
                        File::makeDirectory($storagePath, 0777, true);
                    }
                }
            }


            $documentName = 'PAYMENT_INVOICE_RECEIPT.pdf';
            $document_name = 'PAYMENT_INVOICE_RECEIPT';
            $input = base_path() . '/reports/PAYMENT_INVOICE_RECEIPT.jasper';


            //$input = 'C:\xampp\htdocs\jasperreport\storage\app\public\reports/userreport.jasper';
            $output = $storagePath . '/' . $documentName;
            $output_1 = $storagePath . '/' . $document_name;
            $storagePath = public_path() . '/sail_invoice_document/';
            $report_path = public_path() . '/sail_invoice_document/' . $folderPath;


            $options = [
                'format' => ['pdf'],
                'locale' => 'en',
                'params' => [
                    'child_name' =>  $child_name,
                    'payment_amount' => $payment_amount,
                    'child_id' => $request->child_id,

                ],


                'db_connection' => [
                    'driver' => 'mysql',
                    'username' => config('setting.db_username'),
                    'password' => config('setting.db_password'),
                    'host' => '127.0.0.1',
                    'database' => config('setting.db_database'),
                    'port' => config('setting.db_port'),
                ]
            ];
            $jasper = new PHPJasper;
            //echo json_encode($output); exit;
            //  echo json_encode($options); exit;
            $jasper->process(
                $input,
                $output_1,
                $options
            )->execute();

            $documentName = 'PAYMENT_INVOICE_RECEIPT.pdf';
            $headers = array(
                'Content-Type: application/pdf',
            );
            //End sail invoice


            //assessment_report



            $data = array();
            $data['enrollment_child_num'] = $request->enrollment_child_num;
            $data['child_id'] = $request->child_id;
            $data['child_name'] = $request->child_name;

            $data['initiated_by'] = $request->initiated_by;
            $data['initiated_to'] = $request->initiated_to;
            $data['payment_amount'] = $request->payment_amount;
            $data['payment_status'] = $request->payment_status;
            $data['payment_process_description'] = $request->payment_process_description;
            $data['payment_for'] = $request->payment_for;
            $data['user_id'] = $request->user_id;
            $data['sail_invoice'] = $output;
            $paymenttokentime = $request->paymenttokentime;
            $paymenttokentime = (int)$paymenttokentime;
            $url = URL::temporarySignedRoute(
                'payuserfees.create1',
                now()->addMinutes($paymenttokentime),
                ['id' => encrypt($request->user_id)]
            );
            $data['url'] = $url;
            // $data['transaction_id'] = $request->transaction_id;
            // $data['receipt_num'] = $request->receipt_num;
            $encryptArray = $this->encryptData($data);

            $request = array();
            $request['requestData'] = $encryptArray;

            $gatewayURL = config('setting.api_gateway_url') . '/sail/consent/declined';

            $response = $this->serviceRequest($gatewayURL, 'POST', json_encode($request), $method);

            $response1 = json_decode($response);
            if ($response1->Status == 200 && $response1->Success) {
                $objData = json_decode($this->decryptData($response1->Data));
                if ($objData->Code == 200) {
                    return redirect(route('userregisterfee.index'))
                        ->with('success', 'Payment Initiated Successfully');
                }

                if ($objData->Code == 400) {
                    return Redirect::back()
                        ->with('fail', 'Payment Already Initiated');
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

    public function GetQuestionnaire(Request $request)
    {
        try {
            $method = 'Method => UserregisterfeeController => GetQuestionnaire';
            $data = array();
            $data['enrollment_child_num'] = $request->enrollment_id;
            $data['type'] = $request->type;
            $data['stage'] = $request->stage;
            $encryptArray = $this->encryptData($data);
            $request = array();
            $request['requestData'] = $encryptArray;
            $gatewayURL = config('setting.api_gateway_url') . '/sail/category_data_get';
            $response = $this->serviceRequest($gatewayURL, 'POST', json_encode($request), $method);
            $response = json_decode($response);
            if ($response->Status == 200 && $response->Success) {
                $objData = json_decode($this->decryptData($response->Data));
                if ($objData->Code == 200) {
                    $parant_data = json_decode(json_encode($objData->Data), true);
                    $rows =  $parant_data['rows'];
                    return $parant_data;
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

    public function compass_create_data(Request $request)
    {


        $user_id = $request->session()->get("userID");

        if ($user_id == null) {
            return view('auth.login');
        }
        $method = 'Method => UserregisterfeeController =>compass_create_data';

        $request =  array();
        $request['user_id'] = $user_id;

        $gatewayURL = config('setting.api_gateway_url') . '/register/compass/compasscreate';
        $response = $this->serviceRequest($gatewayURL, 'GET',  json_encode($request), $method);
        $response = json_decode($response);

        if ($response->Status == "401") {
            return redirect(route('/'))->with('danger', 'User session Exipired');
        }
        $objData = json_decode($this->decryptData($response->Data));

        $rows = json_decode(json_encode($objData->Data), true);
        $rows = $rows['rows'];
        //dd( $rows);

        $menus = $this->FillMenu();

        if ($menus == "401") {
            return redirect(route('/'))->with('danger', 'User session Exipired');
        }
        $screens = $menus['screens'];
        $modules = $menus['modules'];
        return view('userregisterfee.compasscreate', compact('rows', 'screens', 'modules'));
    }

    public function compass_store_data(Request $request)
    {


        return redirect(route('userregisterfee.index'))->with('success', 'CoMPASS Payment Initiated Successfully');
    }

    public function compass_show($id)
    {
        $menus = $this->FillMenu();
        $screens = $menus['screens'];
        $modules = $menus['modules'];
        return view('userregisterfee.compassshow', compact('screens', 'modules'));
    }






    public function GetIsCoordinator(Request $request)
    {
        try {
            $method = 'Method => UserregisterfeeController => GetIsCoordinator';
            $data = array();
            $data['enrollment_child_num'] = $request->enrollment_id;
            $encryptArray = $this->encryptData($data);
            $request = array();
            $request['requestData'] = $encryptArray;
            $gatewayURL = config('setting.api_gateway_url') . '/sail/GetIsCo';
            $response = $this->serviceRequest($gatewayURL, 'POST', json_encode($request), $method);
            $response = json_decode($response);
            if ($response->Status == 200 && $response->Success) {
                $objData = json_decode($this->decryptData($response->Data));
                if ($objData->Code == 200) {
                    $parant_data = json_decode(json_encode($objData->Data), true);
                    $rows =  $parant_data['rows'];
                    return $rows;
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
    public function SensoryGetData(Request $request)
    {
        $method = 'Method => UserregisterfeeController => SensoryGetData';
        try {
            $enrollment_child_num = $request->enrollment_child_num;
            $request = array();
            $request['requestData'] = $enrollment_child_num;
            $gatewayURL = config('setting.api_gateway_url') . '/sensory/enrollmentlist';
            $serviceResponse = $this->serviceRequest($gatewayURL, 'POST', json_encode($request), $method);

            $serviceResponse = json_decode($serviceResponse);
            if ($serviceResponse->Status == 200 && $serviceResponse->Success) {
                $objData = json_decode($this->decryptData($serviceResponse->Data));
                if ($objData->Code == 200) {
                    $rows = json_decode(json_encode($objData->Data), true);
                    return $rows;
                    echo json_encode($rows);
                }
            }
        } catch (\Exception $exc) {
            $exceptionResponse = array();
            $exceptionResponse['ServiceMethod'] = $method;
            $exceptionResponse['Exception'] = $exc->getMessage();
            $exceptionResponse = json_encode($exceptionResponse, JSON_FORCE_OBJECT);
            $this->WriteFileLog($exceptionResponse);
        }
    }
    public function offline_payment($id)
    {
        try {
            $method = 'Method => UserregisterfeeController => offline_payment';
            $gatewayURL = config('setting.api_gateway_url') . '/userregisterfee/data_edit/' . $id;
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
                    return view('userregisterfee.offline_payment', compact('rows', 'screens', 'modules'));
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
    public function completepayment(Request $request)
    {
        try {
            // dd($request->hasFile('file'));
            // dd($request);
            $method = 'Method => UserregisterfeeController => completepayment';

            $foldername = $request->payment_status_id;
            $storagePath = public_path() . '/offline_payment/' . $foldername;
            if ($request->hasFile('file')) {
                if (!File::exists($storagePath)) {
                    File::makeDirectory($storagePath, 0777, true);
                }
                $imageFile = $request->file('file');
                $findString = array(' ', '&', '(', ')', "'");
                $replaceString = array('_', '_', '_', '', '');
                $imageName = str_replace($findString, $replaceString, $imageFile->getClientOriginalName());
                $imageFile->move($storagePath, $imageName);
            } else {
                $imageName = '';
            }

            // Recipt
            $amount = $request->payment_amount;
            $paymentFor = $request->payment_for;
            $amount_text = $this->numberToWords($amount);
            $folderPath = $request->initiated_to;
            $child_name = $request->child_name;
            $father = $request->father;
            $mother = $request->mother;

            if ($paymentFor == 'User Register Fee') {
                $paymentFor = $request->payment_for;
                $storagePath = public_path() . '/receipt_document/' . $folderPath;
            } else {
                $paymentFor = 'Professional fee for SAIL program offered to';
                $storagePath = public_path() . '/sail_receipt_document/' . $folderPath;
            }

            if (!File::exists($storagePath)) {
                File::makeDirectory($storagePath, 0777, true);
            }

            $documentName = 'registration_receipt.pdf';
            $output = $storagePath . '/' . $documentName;

            $receipt_number = 'Elina_' . rand(1111111111, 9999999999);

            $data = [
                'receipt_number' => $receipt_number,
                'amount' => $amount,
                'amount_text' => $amount_text,
                'child_name' => $child_name,
                'paymentFor' => $paymentFor,
                'father' => $father,
                'mother' => $mother,
                'payment_mode' => $request->payment_mode
            ];

            $pdf = PDF::loadView('pdfTemplates.receipt', compact('data'));
            $pdf->save($output);

            $data = array();
            $data['enrollment_child_num'] = $request->enrollment_child_num;
            $data['payment_status_id'] = $request->payment_status_id;
            $data['payment_date'] = $request->payment_date;
            $data['payment_mode'] = $request->payment_mode;
            $data['reference_id'] = $request->reference_id;
            $data['register_receipt'] = $output;
            $data['receipt_number'] = $receipt_number;
            $data['initiated_to'] = $request->initiated_to;
            $data['paymentFor'] = $request->payment_for;
            $data['amount'] = $request->amount;
            $data['file_name'] = $imageName;
            $data['transaction_id'] = rand(1111111111, 9999999999);

            // dd($data);

            $encryptArray = $this->encryptData($data);
            $request = array();
            $request['requestData'] = $encryptArray;
            $gatewayURL = config('setting.api_gateway_url') . '/offline/payment/complete';

            $response = $this->serviceRequest($gatewayURL, 'POST', json_encode($request), $method);

            $response1 = json_decode($response);
            if ($response1->Status == 200 && $response1->Success) {
                $objData = json_decode($this->decryptData($response1->Data));
                if ($objData->Code == 200) {
                    return redirect(route('userregisterfee.index'))->with('success', 'Payment Completed Successfully');
                }
                if ($objData->Code == 400) {
                    return redirect()->back()->with('fail', 'Payment Already Initiated');
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
}
