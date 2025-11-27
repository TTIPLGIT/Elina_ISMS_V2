<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use App\Http\Controllers\OfficeConverterController;
use Illuminate\Support\Facades\Redirect;
use PHPJasper\PHPJasper;
use Illuminate\Support\Facades\URL;
use PDF;
use DB;

class NewenrollementController extends BaseController
{
    public function index(Request $request)
    {
        $permission_data = $this->FillScreensByUser();
        $screen_permission = $permission_data[0];

        if (strpos($screen_permission['permissions'], 'View') !== false) {

            $method = 'Method => NewenrollementController => index';

            $menus = $this->FillMenu();
            $screens = $menus['screens'];
            $modules = $menus['modules'];
            $user_role = $modules['user_role'];
            $userRoleID = $modules['userRoleID'];

            $gatewayURL = config('setting.api_gateway_url') . '/newenrollment/index';
            $response = $this->serviceRequest($gatewayURL, 'GET', '', $method);
            $response = json_decode($response);
            $objData = json_decode($this->decryptData($response->Data));
            $responce_data = json_decode(json_encode($objData->Data), true);

            $rows = $responce_data['rows'];
            if ($user_role == 'Parent' && $userRoleID == '3') {
                if ($rows == []) {
                    return redirect(route('newenrollment.create'));
                }
                $enrollment_id = $rows[0]['enrollment_id'];
                $consent_aggrement = $rows[0]['consent_aggrement'];
                if ($consent_aggrement == null) {
                    return redirect(route('newenrollment.edit', $this->encryptData($enrollment_id)));
                } else if ($consent_aggrement == 'Declined') {
                    return redirect(route('newenrollment.edit', $this->encryptData($enrollment_id)));
                } else {
                    if ($responce_data['sailFlag'] == 1) {
                        return redirect(route('sail.consent', $this->encryptData($rows[0]['enrollment_child_num'])));
                    } else {
                        return redirect(route('newenrollment.show', $this->encryptData($enrollment_id)));
                    }
                }
            }
            return view('newenrollement.index', compact('screen_permission', 'rows', 'menus', 'screens', 'modules'));
        } else {
            return redirect()->route('not_allow');
        }
    }

    public function create(Request $request)
    {
        try {
            $user_id = $request->session()->get("userID");

            $method = 'Method => NewenrollementController => create';
            $gatewayURL = config('setting.api_gateway_url') . '/newenrollment/createdata';
            $response = $this->serviceRequest($gatewayURL, 'GET', '', $method);

            $response = json_decode($response);

            if ($response->Status == 200 && $response->Success) {
                $objData = json_decode($this->decryptData($response->Data));

                if ($objData->Code == 200) {
                    $parant_data = json_decode(json_encode($objData->Data), true);
                    $rows = $parant_data['rows']; //dd($rows);
                    $email = $parant_data['email'];
                    $consent = $parant_data['consent'];

                    $menus = $this->FillMenu();
                    $screens = $menus['screens'];
                    $modules = $menus['modules'];
                    if ($rows == []) {
                        return view('newenrollement.create', compact('screens', 'modules', 'email', 'consent'));
                    } else {
                        return redirect(route('newenrollment.index'));
                    }
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

    public function internlist(Request $request)
    {
        $permission_data = $this->FillScreensByUser();
        $screen_permission = $permission_data[0];

        if (strpos($screen_permission['permissions'], 'View') !== false) {
            try {
                $method = 'Method => NewenrollementController => Register_screen';

                $gatewayURL = config('setting.api_gateway_url') . '/newenrollment/internlist';
                $response = $this->serviceRequest($gatewayURL, 'GET', '', $method);
                $response = json_decode($response);
                $objData = json_decode($this->decryptData($response->Data));
                $responce_data = json_decode(json_encode($objData->Data), true);
                $rows = $responce_data['rows'];
                $menus = $this->FillMenu();
                $screens = $menus['screens'];
                $modules = $menus['modules'];

                return view('newenrollement.internlist', compact('rows', 'menus', 'screens', 'modules'));
            } catch (\Exception $exc) {
                return $this->sendLog($method, $exc->getCode(), $exc->getMessage(), $exc->getLine(), $exc->getTrace()[0]['args'][2]);
            }
        } else {
            return redirect()->route('not_allow');
        }
    }

    public function servicelist(Request $request)
    {
        $permission_data = $this->FillScreensByUser();
        $screen_permission = $permission_data[0];

        if (strpos($screen_permission['permissions'], 'View') !== false) {
            try {
                $method = 'Method => NewenrollementController => servicelist';

                $gatewayURL = config('setting.api_gateway_url') . '/newenrollment/servicelist';
                $response = $this->serviceRequest($gatewayURL, 'GET', '', $method);
                $response = json_decode($response);
                $objData = json_decode($this->decryptData($response->Data));
                $responce_data = json_decode(json_encode($objData->Data), true);
                $rows = $responce_data['rows'];

                $menus = $this->FillMenu();
                $screens = $menus['screens'];
                $modules = $menus['modules'];

                return view('newenrollement.serviceproviderlist', compact('rows', 'menus', 'screens', 'modules'));
            } catch (\Exception $exc) {
                return $this->sendLog($method, $exc->getCode(), $exc->getMessage(), $exc->getLine(), $exc->getTrace()[0]['args'][2]);
            }
        } else {
            return redirect()->route('not_allow');
        }
    }

    public function store(Request $request)
    {
        try {
            $btn = $request->btn_status;
            $method = 'Method => NewenrollementController => store';
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
            }

            // else
            // {
            // 	File::cleanDirectory($storagePath);
            // }

            // $documentName = 'Consent_form_child.pdf';
            // $document_name = 'Consent_form_child';
            // $input = base_path() . '/reports/Consent_form_child.jasper';
            // // dd($input);
            // //$input = 'C:\xampp\htdocs\jasperreport\storage\app\public\reports/userreport.jasper';
            // $output = $storagePath . '/' . $documentName;
            // // dd($output);

            // $output_1 = $storagePath . '/' . $document_name;
            // $storagePath = public_path() . '/demo_document/';
            // $report_path = public_path() . '/demo_document/' . $folderPath;


            // $options = [
            //     'format' => ['pdf'],
            //     'locale' => 'en',
            //     'params' => [
            //         'child_name' => $request->child_name,
            //         'child_dob' =>  $request->child_dob,
            //         'parent_name' => $request->child_father_guardian_name
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
            // //echo json_encode($options); exit;
            // $jasper->process(
            //     $input,
            //     $output_1,
            //     $options
            // )->execute();
            // $documentName = 'Consent_form_child.pdf';
            // $headers = array(
            //     'Content-Type: application/pdf',
            // );

            $consentdata = [
                'childName' => $request->child_name,
            ];

            $documentName = 'Consent_form_' . $request->child_name . '.pdf';
            $output = $storagePath . '/' . $documentName;
            $pdf = PDF::loadView('pdfTemplates.consentform', compact('consentdata'));
            $pdf->save($output);

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
            $data['consent_aggrement'] = $request->consent_aggrement;
            $data['consent_form'] = $output;

            // dd($data);
            $encryptArray = $this->encryptData($data);
            $request = array();
            $request['requestData'] = $encryptArray;
            $gatewayURL = config('setting.api_gateway_url') . '/newenrollment/storedata';
            $response = $this->serviceRequest($gatewayURL, 'POST', json_encode($request), $method);
            $response1 = json_decode($response);

            if ($response1->Status == 200 && $response1->Success) {
                $objData = json_decode($this->decryptData($response1->Data));
                if ($objData->Code == 200) {
                    if ($btn == 'saved') {
                        // $this->WriteFileLog($btn);
                        // return redirect(route('newenrollment.edit' , $this->encryptData($id)))->with('success', 'In order to proceed further, Please Agree and Submit');
                        return redirect(route('newenrollment.index'))->with('success', 'In order to proceed further, Please Agree and Submit');
                    } else {
                        $this->RegisterFeeInitiate($objData->Data);
                        return redirect(route('payuserfee.create'))->with('success', 'Enrollment Submitted and Payment Initiated Successfully');
                    }
                }
                // dd(back()
                // ->with('fail', 'Enrollment Name Already Exists'));
                if ($objData->Code == 400) {
                    return Redirect::back()
                        ->with('fail', 'Enrollment Name Already Exists');
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

    public function show(Request $request , $id)
    {
       
        try {
            $method = 'Method => NewenrollementController => show';
            $gatewayURL = config('setting.api_gateway_url') . '/newenrollment/data_edit/' . $id;

            $response = $this->serviceRequest($gatewayURL, 'GET', '', $method);

            $response = json_decode($response);

            if ($response->Status == 200 && $response->Success) {
                $objData = json_decode($this->decryptData($response->Data));
                if ($objData->Code == 200) {
                    $parant_data = json_decode(json_encode($objData->Data), true);

                    $rows = $parant_data['rows'];
                    $services_from_elina = $rows[0]['services_from_elina'];
                    $subparant_data = json_decode($services_from_elina, true);
                    $knmabtelina_data = json_decode($rows[0]['how_knowabt_elina'], true);

                    $sail = $parant_data['sail'];
                    $user_idEnc = $request->session()->get("userID");
                    $encUser = $this->encryptData($user_idEnc);
                   
                    $menus = $this->FillMenu();
                    $screens = $menus['screens'];
                    $modules = $menus['modules'];
                    return view('newenrollement.show', compact('encUser','sail','rows', 'screens', 'modules', 'knmabtelina_data', 'subparant_data'));
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

    public function internview($id)
    {
        try {
            $method = 'Method => NewenrollementController => show';
            $gatewayURL = config('setting.api_gateway_url') . '/internview/data_edit/' . $id;

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
                    return view('newenrollement.internview', compact('rows', 'screens', 'modules'));
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
    public function serviceproviderview($id)
    {
        try {
            $method = 'Method => NewenrollementController => show';
            $gatewayURL = config('setting.api_gateway_url') . '/serviceproviderview/data_edit/' . $id;
            $response = $this->serviceRequest($gatewayURL, 'GET', '', $method);
            $response = json_decode($response);
            if ($response->Status == 200 && $response->Success) {
                $objData = json_decode($this->decryptData($response->Data));
                if ($objData->Code == 200) {
                    $parant_data = json_decode(json_encode($objData->Data), true);
                    $rows = $parant_data['rows'];
                    $mode_of_service = $rows[0]['mode_of_service'];
                    $mode_of_service = json_decode($mode_of_service, true);
                    $area_of_specializtion = json_decode($rows[0]['area_of_specializtion'], true);
                    $menus = $this->FillMenu();
                    $screens = $menus['screens'];
                    $modules = $menus['modules'];
                    return view('newenrollement.serviceproviderview', compact('rows', 'screens', 'modules', 'mode_of_service', 'area_of_specializtion'));
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
            $method = 'Method => NewenrollementController => edit';
            $gatewayURL = config('setting.api_gateway_url') . '/newenrollment/data_edit/' . $id;
            $response = $this->serviceRequest($gatewayURL, 'GET', '', $method);
            $response = json_decode($response);

            if ($response->Status == 200 && $response->Success) {
                $objData = json_decode($this->decryptData($response->Data));
                if ($objData->Code == 200) {
                    $parant_data = json_decode(json_encode($objData->Data), true);
                    $rows = $parant_data['rows'];
                    $consent_aggrement = $rows[0]['consent_aggrement'];
                    if ($consent_aggrement == null || $consent_aggrement == '' || $consent_aggrement == 'Declined') {
                        $consent_flag = 1;
                    } else {
                        $consent_flag = 0;
                    }
                    $subparant_data = json_decode($rows[0]['services_from_elina'], true);
                    $knmabtelina_data = json_decode($rows[0]['how_knowabt_elina'], true);
                    $consent = $parant_data['consent'];
                    $menus = $this->FillMenu();
                    $screens = $menus['screens'];
                    $modules = $menus['modules'];

                    return view('newenrollement.edit', compact('rows', 'screens', 'modules', 'knmabtelina_data', 'subparant_data', 'consent', 'consent_flag'));
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
            // dd($request);
            $btn = $request->btn_status;
            $method = 'Method =>  NewenrollementController => update_data';
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
            }

            $consentdata = [
                'childName' => $request->child_name,
            ];

            $documentName = 'Consent_form_' . $request->child_name . '.pdf';
            $output = $storagePath . '/' . $documentName;

            if ($request->consent_aggrement == 'Agreed') {
                $pdf = PDF::loadView('pdfTemplates.consentform', compact('consentdata'));
                $pdf->save($output);
            }

            $data = array();
            $data['id'] = $id;
            $data['child_name'] = $request->child_name;
            $data['child_dob'] = $request->child_dob;
            $data['child_school_name_address'] = $request->child_school_name_address;
            $data['child_gender'] = $request->child_gender;
            $data['enrollment_child_num'] = $request->enrollment_child_num;
            $data['child_father_guardian_name'] = $request->child_father_guardian_name;
            $data['child_mother_caretaker_name'] = $request->child_mother_caretaker_name;
            $data['child_contact_email'] = $request->child_contact_email;
            $data['child_contact_phone'] = $request->child_contact_phone;
            $data['child_contact_address'] = $request->child_contact_address;
            $data['status'] = $request->btn_status;
            $data['services_from_elina'] = $request->services_from_elina;
            $data['how_knowabt_elina'] = $request->how_knowabt_elina;
            $data['consent_form'] = $output;
            $data['consent_aggrement'] = $request->consent_aggrement;
            $data['child_alter_phone'] = $request->child_alter_phone;
           
            $encryptArray = $this->encryptData($data);

            $con = $request->consent_aggrement;
            $request = array();

            $request['requestData'] = $encryptArray;
            $gatewayURL = config('setting.api_gateway_url') . '/v2/newenrollment/updatedata';
            // $gatewayURL = config('setting.api_gateway_url') . '/newenrollment/updatedata'; // Old Version
            $response = $this->serviceRequest($gatewayURL, 'POST', json_encode($request), $method);
            $response1 = json_decode($response);

            if ($response1->Status == 200 && $response1->Success) {

                $objData = json_decode($this->decryptData($response1->Data));

                if ($objData->Code == 200) {
                    if ($btn == 'update') {
                        return redirect(route('newenrollment.show', $this->encryptData($id)))->with('success', 'Enrollment Updated Successfully');
                    }
                    if ($btn == 'Declined') {
                        // dd('asd');
                        return redirect(route('/'))->with('success', 'You will not be processed further. Thank you for visiting our site. For more information, you can connect with our support staff through the contact details provided on the website');
                    }
                    if ($con != 'Agreed') {
                        if ($btn == 'saved') {
                            return redirect(route('newenrollment.edit', $this->encryptData($id)))->with('success', 'In order to proceed further, Please Agree and Submit');
                        } else {
                            return redirect(route('newenrollment.show', $this->encryptData($id)))->with('success', 'Enrollment Updated Successfully');
                        }
                    } else {
                        $this->RegisterFeeInitiate($objData->Data);
                        return redirect(route('payuserfee.create'))->with('success', 'Consent Form Submitted and Payment Initiated Successfully');
                        // return redirect(route('payuserfee.index'))->with('success', 'Consent Form Submitted and Payment Initiated Successfully');
                    }
                }

                if ($objData->Code == 400) {
                    return Redirect::back()->with('fail', 'enrollment Name Already Exists');
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
            $method = 'Method => NewenrollementController => delete';
            //  $id = $this->decryptData($id);
            $gatewayURL = config('setting.api_gateway_url') . '/newenrollment/data_delete/' . $this->encryptData($id);
            $response = $this->serviceRequest($gatewayURL, 'GET', '', $method);
            $response1 = json_decode($response);

            if ($response1->Status == 200 && $response1->Success) {
                $objData = json_decode($this->decryptData($response1->Data));
                if ($objData->Code == 200) {
                    return redirect(route('newenrollment.index'))
                        ->with('success', 'Enrollment Screen Deleted Successfully');
                }
                if ($objData->Code == 400) {
                    return redirect(route('newenrollment.index'))
                        ->with('fail', 'Enrollment Screen Allocated One Role');
                }
            }
        } catch (\Exception $exc) {

            return $this->sendLog($method, $exc->getCode(), $exc->getMessage(), $exc->getLine(), $exc->getTrace()[0]['args'][2]);
        }
    }
    public function view_proposal_documents(Request $request)
    {

        $path = $request->id;
        $storagepath = public_path() . $path;
        $converter = new OfficeConverterController($storagepath);
        $converter->convertTo('document-view.pdf');

        $documentViewPath = '/documents/pdfview' . '/document-view.pdf';
        return $documentViewPath;
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
            $jasper = new PHPJasper;
            //echo json_encode($output_1); exit;
            //  echo json_encode($options); exit;
            // $jasper->process(
            //     $input,
            //     $output_1,
            //     $options
            // )->execute();

            // $documentName = 'Registration_invoice_receipt.pdf';
            // $headers = array(
            //     'Content-Type: application/pdf',
            // );
            // $users = DB::table('payment_status_details')->select('payment_status_id')->orderBy('payment_status_id', 'DESC')->first();
            // $users = DB::select("Select * from payment_status_details");
            // dd($users);
            // if(empty($users)){
            $invoice = 1;
            // }else{
            //     $invoice = $users->payment_status_id + 1;
            // }

            $amount_text = $this->numberToWords($register_fee);
            $data = [
                'father_name' => $parent_name,
                'child_name' => $child_name,
                'register_fee' => $register_fee,
                'in_words' => $amount_text,
                'id' => $invoice,
            ];
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
                    return redirect(route('payuserfee.index'));
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
