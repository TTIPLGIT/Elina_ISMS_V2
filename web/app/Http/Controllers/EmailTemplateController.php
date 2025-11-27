<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Log;
use Redirect;
use Illuminate\Support\Facades\Validator;

class EmailTemplateController extends BaseController
{


    public function index(Request $request)
    {
        try {
            $method = 'Method => EmailTemplateController => index';
            $gatewayURL = config('setting.api_gateway_url') . '/emailpreview/getdata';
            $response = $this->serviceRequest($gatewayURL, 'GET', '', $method);
            $response = json_decode($response);
            if ($response->Status == 200 && $response->Success) {
                $objData = json_decode($this->decryptData($response->Data));
                if ($objData->Code == 200) {
                    $parant_data = json_decode(json_encode($objData->Data), true);
                    $email_preview =  $parant_data['email_preview'];
                    $menus = $this->FillMenu();
                    $screens = $menus['screens'];
                    $modules = $menus['modules'];
                    $permission_data = $this->FillScreensByUser();
                    $screen_permission = $permission_data[0];
                    return view('email_template.index', compact('email_preview', 'modules', 'screens', 'screen_permission'));
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


    public function create()
    {
        try {
            $method = 'Method => EmailTemplateController => create';
            $gatewayURL = config('setting.api_gateway_url') . '/emailpreview/create';
            $response = $this->serviceRequest($gatewayURL, 'GET', '', $method);
            $response = json_decode($response);
            if ($response->Status == 200 && $response->Success) {
                $objData = json_decode($this->decryptData($response->Data));
                if ($objData->Code == 200) {
                    $parant_data = json_decode(json_encode($objData->Data), true);
                    $rows =  $parant_data['rows'];
                    $menus = $this->FillMenu();
                    $screens = $menus['screens'];
                    $modules = $menus['modules'];
                    return view('email_template.create', compact('rows', 'modules', 'screens'));
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
            // $this->WriteFileLog($request->email_description);
            // dd($request);
            $method = 'Method => EmailTemplateController => store';
            $data = array();
            $data['email_screen'] = $request->email_screen;
            $data['email_subject'] = $request->email_subject;
            $data['email_description'] = $request->email_description;


            $encryptArray = $this->encryptData($data);
            $request = array();
            $request['requestData'] = $encryptArray;
            $gatewayURL = config('setting.api_gateway_url') . '/emailpreview/storedata';
            $response = $this->serviceRequest($gatewayURL, 'POST', json_encode($request), $method);

            $response1 = json_decode($response);


            if ($response1->Status == 200 && $response1->Success) {
                $objData = json_decode($this->decryptData($response1->Data));
                if ($objData->Code == 200) {
                    return redirect(route('emailtemplate.index'))->with('success', 'FAQ Modules Created Successfully');
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

    public function edit($id)
    {
        $permission_data = $this->FillScreensByUser();
        $screen_permission = $permission_data[0];
        if (strpos($screen_permission['permissions'], 'Edit') !== false) {

            try {
                $method = 'Method => EmailTemplateController => edit';
                $id = $this->decryptData($id);
                $gatewayURL = config('setting.api_gateway_url') . '/emailpreview/data_edit/' . $this->encryptData($id);
                $response = $this->serviceRequest($gatewayURL, 'GET', '', $method);

                $response = json_decode($response);
                if ($response->Status == 200 && $response->Success) {
                    $objData = json_decode($this->decryptData($response->Data));
                    if ($objData->Code == 200) {
                        $parant_data = json_decode(json_encode($objData->Data), true);
                        $email =  $parant_data['email'];
                        $menus = $this->FillMenu();
                        $screens = $menus['screens'];
                        $modules = $menus['modules'];
                        return view('email_template.edit', compact('email', 'modules', 'screens'));
                    }
                } else {
                    $objData = json_decode($this->decryptData($response->Data));
                    echo json_encode($objData->Code);
                    exit;
                }
            } catch (\Exception $exc) {
                return $this->sendLog($method, $exc->getCode(), $exc->getMessage(), $exc->getLine(), $exc->getTrace()[0]['args'][2]);
            }
        } else {
            return redirect()->route('not_allow');
        }
    }


    public function show($id)
    {
        $permission_data = $this->FillScreensByUser();
        $screen_permission = $permission_data[0];
        if (strpos($screen_permission['permissions'], 'Show') !== false) {

            try {
                $method = 'Method => EmailTemplateController => show';
                $id = $this->decryptData($id);
                $gatewayURL = config('setting.api_gateway_url') . '/emailpreview/data_edit/' . $this->encryptData($id);
                $response = $this->serviceRequest($gatewayURL, 'GET', '', $method);


                $response = json_decode($response);
                if ($response->Status == 200 && $response->Success) {
                    $objData = json_decode($this->decryptData($response->Data));
                    if ($objData->Code == 200) {
                        $parant_data = json_decode(json_encode($objData->Data), true);
                        $email =  $parant_data['email'];

                        $menus = $this->FillMenu();
                        $screens = $menus['screens'];
                        $modules = $menus['modules'];
                        return view('email_template.show', compact('email', 'modules', 'screens'));
                    }
                } else {
                    $objData = json_decode($this->decryptData($response->Data));
                    echo json_encode($objData->Code);
                    exit;
                }
            } catch (\Exception $exc) {
                return $this->sendLog($method, $exc->getCode(), $exc->getMessage(), $exc->getLine(), $exc->getTrace()[0]['args'][2]);
            }
        } else {
            return redirect()->route('not_allow');
        }
    }



    public function update(Request $request , $id)
    {
        try {
            $method = 'Method => EmailTemplateController => update_data';
            $data = array();
            $data['id'] = $id;
            $data['email_screen'] = $request->email_screen;
            $data['email_subject'] = $request->email_subject;
            $data['email_description'] = $request->email_description;

            $encryptArray = $this->encryptData($data);
            $request = array();
            $request['requestData'] = $encryptArray;
            $gatewayURL = config('setting.api_gateway_url') . '/emailpreview/update_data';
            $response = $this->serviceRequest($gatewayURL, 'POST', json_encode($request), $method);
            $response1 = json_decode($response);

            if ($response1->Status == 200 && $response1->Success) {
                $objData = json_decode($this->decryptData($response1->Data));
            }
            if ($objData->Code == 200) {
                return redirect(route('emailtemplate.index'))->with('success', 'Email Updated Successfully');
            } else {
                $objData = json_decode($this->decryptData($response->Data));
                echo json_encode($objData->Code);
                exit;
            }
        } catch (\Exception $exc) {
            return $this->sendLog($method, $exc->getCode(), $exc->getMessage(), $exc->getLine(), $exc->getTrace()[0]['args'][2]);
        }
    }

    public function delete($id)
    {
        $permission_data = $this->FillScreensByUser();
        $screen_permission = $permission_data[0];
        if (strpos($screen_permission['permissions'], 'Delete') !== false) {
            try {

                $method = 'Method => EmailTemplateController => delete';
                $id = $this->decryptData($id);

                $gatewayURL = config('setting.api_gateway_url') . '/FAQ_modules/data_delete/' . $this->encryptData($id);
                $response = $this->serviceRequest($gatewayURL, 'GET', '', $method);



                $response1 = json_decode($response);
                if ($response1->Status == 200 && $response1->Success) {
                    $objData = json_decode($this->decryptData($response1->Data));
                    if ($objData->Code == 200) {
                        return redirect(route('faqmodules.index'))->with('success', 'FAQ Modules Deleted Successfully.');
                    }
                    if ($objData->Code == 400) {
                        return redirect(route('faqmodules.index'))->with('fail', 'This Module Allocated One FAQ Question');
                    }
                } else {
                    $objData = json_decode($this->decryptData($response->Data));
                    echo json_encode($objData->Code);
                    exit;
                }
            } catch (\Exception $exc) {
                
                return $this->sendLog($method, $exc->getCode(), $exc->getMessage(), $exc->getLine(), $exc->getTrace()[0]['args'][2]);
            }
        } else {
            return redirect()->route('not_allow');
        }
    }
}
