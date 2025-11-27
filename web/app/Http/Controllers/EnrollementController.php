<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PHPJasper\PHPJasper;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\URL;
use PDF;
use DB;
use Validator;

class EnrollementController extends BaseController
{
    public function create(Request $request)
    {
        try {
            $method = 'Method => EnrollementController => create';
            $schools = DB::select("SELECT id AS school_id,school_name FROM schools_registration;");
            return view('enrollement.enrollnow', compact('schools'));
        } catch (\Exception $exc) {

            return $this->sendLog($method, $exc->getCode(), $exc->getMessage(), $exc->getLine(), $exc->getTrace()[0]['args'][2]);
        }
    }

    public function store(Request $request)
    {
        try {
            $input = [
                'recaptcha' => $request->input('g-recaptcha-response')
            ];

            $rules = [
                'recaptcha' => 'required|captcha'
            ];

            $validator = Validator::make($input, $rules);

            if ($validator->fails()) {
                return back()->with('error', 'Recaptcha Failed');
            }
            
            $method = 'Method => EnrollementController => store';
            // Folder creation
            $folderPath = $request->child_contact_email;
            //$folderPath = str_replace(' ', '-', $folderPath);
            $findString = array(' ', '&');
            $replaceString = array('-', '-');
            $folderPath = str_replace($findString, $replaceString, $folderPath);
            $storagePath = public_path() . '/demo_document/' . $folderPath;

            if (!File::exists($storagePath)) {
                $storagePath = public_path() . '/demo_document/';
                $arrFolder = explode('/', $folderPath);
                foreach ($arrFolder as $key => $value) {
                    $storagePath .= '/' . $value;
                    if (!File::exists($storagePath)) {
                        File::makeDirectory($storagePath);
                    }
                }
            } else {
                File::cleanDirectory($storagePath);
            }

            /*
            |--------------------------------------------------------------------------
            | Enrollement Controller
            |--------------------------------------------------------------------------
            | Jasper Report
            |
            | This function has been Replaced with the Php Pdf generator function for optimization purposes
            |
            */

            // $documentName = 'Consent_form_child.pdf';
            // $document_name = 'Consent_form_child';
            // $input = base_path() . '/reports/Consent_form_child.jasper';
            // $output = $storagePath . '/' . $documentName;
            // $output_1 = $storagePath . '/' . $document_name;
            // $storagePath = public_path() . '/demo_document/';
            // $report_path = public_path() . '/demo_document/' . $folderPath;
            // $options = [
            //     'format' => ['pdf'],
            //     'locale' => 'en',
            //     'params' => [
            //         'child_name' => $request->child_name,
            //         'child_dob' =>  $request->child_dob,
            //         'parent_name' => $request->child_father_guardian_name,
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
            // $documentName = 'Consent_form_child.pdf';
            // $headers = array(
            //     'Content-Type: application/pdf',
            // );
            /*
            |--------------------------------------------------------------------------
            | Enrollement Controller
            |--------------------------------------------------------------------------
            | Jasper Report End
            |
            | This function has been Replaced with the Php Pdf generator function for optimization purposes
            |
            */

            /*
            |--------------------------------------------------------------------------
            | Enrollement Controller
            |--------------------------------------------------------------------------
            | Php Report
            |
            | This function has been Replaced with the Php Pdf generator function for optimization purposes
            |
            */

            // $consentdata = [
            //     'childName' => $request->child_name,
            // ];

            // $documentName = 'Consent_form_' . $request->child_name . '.pdf';
            // $output = $storagePath . '/' . $documentName;
            // $pdf = PDF::loadView('pdfTemplates.consentform', compact('consentdata'));
            // $pdf->save($output);


            $data = array();
            $data['child_name'] = $request->child_name;
            $data['child_dob'] = $request->child_dob;
            $data['child_school_name_address'] = $request->child_school_name_address;
            $data['child_gender'] = $request->child_gender;
            $data['child_father_guardian_name'] = $request->child_father_guardian_name;
            $data['child_mother_caretaker_name'] = $request->child_mother_caretaker_name;
            $data['child_contact_email'] = $request->child_contact_email;
            $data['child_contact_phone'] = $request->child_contact_phone;
            $data['child_contact_address'] = $request->child_contact_address;
            $data['status'] = $request->btn_status;
            $data['services_from_elina'] = $request->services_from_elina;
            $data['how_knowabt_elina'] = $request->how_knowabt_elina;
            $data['child_alter_phone'] = $request->child_alter_phone;
            // $data['consent_form'] = $output;

            $data['name'] = $request->name;
            $data['email'] = $request->email;
            $data['password'] = bcrypt($request->password);
            $data['password_confirmation'] = $request->password_confirmation;
             $data['Mobile_no'] = $request->Mobile_no;
            $data['dor'] = $request->dor;
            $data['child_school'] = $request->child_school;
            $react_web = isset($request->react_web)?$request->react_web:FALSE;
                
            $providerId = $request->providerId;
            $encryptArray = $this->encryptData($data);
            $request = array();
            $request['requestData'] = $encryptArray;
            if ($react_web){
            $gatewayURL = config('setting.api_gateway_url') . '/beforeenrollment/storedata';
            }else{
            $gatewayURL = config('setting.api_gateway_url') . '/v1/beforeenrollment/storedata';
            }
            $response = $this->serviceRequest($gatewayURL, 'POST', json_encode($request), $method);
            $response1 = json_decode($response);
            if ($response1->Status == 200 && $response1->Success) {
                // File::cleanDirectory($report_path);
                $objData = json_decode($this->decryptData($response1->Data)); //dd($objData);
                if ($objData->Code == 200) {
                    $this->RegisterFeeInitiate($objData->Data);
                    $row = json_decode(json_encode($objData->serviceResponse1), true); //dd($objData , $row , $objData->Data);
                    session(['accessToken' => $row['access_token']]);
                    session(['userType' => $row['user']['user_type']]);
                    session(['userID' => $row['user']['id']]);
                    session(['sessionTimer' => $row['formattedDateTime']]);
                    $enrollment = $objData->Data;
                    $enrollment_id = $enrollment->enrollment_id;
                    if($providerId == 1){
                    $url = URL::temporarySignedRoute(
                        'payuserfees.create1',
                        now()->addMinutes('3600'),
                        ['id' => encrypt($row['user']['id'])]
                    );
                    return $url;
                }

                if ($react_web) {
                    return response()->json([
                        'message' => 'Enrollment Submitted and Payment Initiated Successfully.',
                        'code' => 200
                    ], 200);
                } else {
                    return redirect(route('payuserfee.create'))->with('success', 'Enrollment Submitted and Payment Initiated Successfully');
                }

                    // return redirect(route('newenrollment.edit' , $this->encryptData($enrollment_id)))->with('success', 'Enrollment Updated Successfully');
                    // return redirect(route('home'))->with('success', 'You have been Enrolled and Consent form sent successfully');
                    // return view('enrollement.submit');
                }
                if ($objData->Code == 400) {
                    if ($react_web) {
                        return response()->json([
                            'message' => 'The provided email address has already been registered. Please log in using this email or register with a different email address.',
                            'code' => 400
                        ], 400);
                    } else {
                        return redirect()->back()->with('error', 'The provided email address has already been registered. Please log in using this email or register with a different email address.');
                    }
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

    public function RegisterFeeInitiate($request)
    {
        try {
            $method = 'Method => EnrollementController => RegisterFeeInitiate';

            $child_name = $request->child_name;
            $register_fee = $request->payment_amount;
            $parent_name = $request->child_father_guardian_name;
            $folderPath = $request->initiated_to;
            $findString = array(' ', '&');
            $replaceString = array('-', '-');
            $folderPath = str_replace($findString, $replaceString, $folderPath);
            $storagePath = public_path() . '/invoice_document/' . $folderPath;

            if (!File::exists($storagePath)) {
                $storagePath = public_path() . '/invoice_document/';
                $arrFolder = explode('/', $folderPath);
                foreach ($arrFolder as $key => $value) {
                    $storagePath .= '/' . $value;
                    if (!File::exists($storagePath)) {
                        File::makeDirectory($storagePath);
                    }
                }
            }


            $documentName = 'Registration_invoice_receipt.pdf';
            $document_name = 'Registration_invoice_receipt';
            $input = base_path() . '/reports/Registration_invoice_receipt.jasper';


            //$input = 'C:\xampp\htdocs\jasperreport\storage\app\public\reports/userreport.jasper';
            $output = $storagePath . '/' . $documentName;
            $output_1 = $storagePath . '/' . $document_name;
            $storagePath = public_path() . '/invoice_document/';
            $report_path = public_path() . '/invoice_document/' . $folderPath;


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

            $documentName = 'Registration_invoice_receipt.pdf';
            // $headers = array(
            //     'Content-Type: application/pdf',
            // );

            $users = DB::table('payment_status_details')->select('payment_status_id')->orderBy('payment_status_id', 'DESC')->first();

            // dd($users);
            if (empty($users)) {
                $invoice = 1;
            } else {
                $invoice = $users->payment_status_id + 1;
            }
            $amount_text = $this->numberToWords($register_fee);
            $data = [
                'father_name' => $parent_name,
                'child_name' => $child_name,
                'register_fee' => $register_fee,
                'in_words' => $amount_text,
                'id' => $invoice,
                'serviceList' => $request->masterData->serviceList,
                'baseAmount' => $request->baseAmount,
                'gstAmount' => $request->gstAmount
            ];
            // $this->WriteFileLog($data);
            $pdf = PDF::loadView('pdfTemplates.user_invoice', compact('data'));
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

            $paymenttokentime = (int)$request->paymenttokentime;
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
                    return redirect(route('userregisterfee.index'))->with('success', 'Payment Initated Successfully');
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
    public function ValidateEnrollment(Request $request)
    {
        try {
            $method = 'Method => UserregisterfeeController => GetAllDepartmentsByDirectorate';
            $InputName = $request->InputName;
            $InputDoB = $request->InputDoB;
            $request = array();
            $request['InputName'] = $InputName;
            $request['InputDoB'] = $InputDoB;
            $gatewayURL = config('setting.api_gateway_url') . '/validate/enrollment/user';
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
}
