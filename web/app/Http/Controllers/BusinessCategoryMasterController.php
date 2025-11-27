<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BusinessCategoryMasterController extends BaseController
{
    public function index(Request $request, $id)
    {
        try {
            $method = 'Method => BusinessCategoryMasterController => index';

            $menus = $this->FillMenu();
            $screens = $menus['screens'];
            $modules = $menus['modules'];


            $permission_data = $this->FillScreensByUser();
            $screen_permission = $permission_data[0];            

            $gatewayURL = config('setting.api_gateway_url') . '/business/affiliate/index';
            $response = $this->serviceRequest($gatewayURL, 'GET', '', $method);

            $response = json_decode($response);
            if ($response->Status == 200 && $response->Success) {
                $objData = json_decode($this->decryptData($response->Data));
                if ($objData->Code == 200) {
                    $parant_data = json_decode(json_encode($objData->Data), true);
                    $rows = $parant_data['rows'];
                    
                    if ($id == 'list') {
                        return view('business_category_master.index', compact('rows', 'modules', 'screens', 'screen_permission'));
                    } else {
                        return view('alert.under_construction');
                    }
                    //
                }
            } else {
                $objData = json_decode($this->decryptData($response->Data));
                if ($objData->Code == "401") {
                    return redirect(route('/'))->with('danger', 'User session Exipired');
                }
                echo json_encode($objData->Code);
                exit;
            }
        } catch (\Exception $exc) {
            return $this->sendLog($method, $exc->getCode(), $exc->getMessage(), $exc->getLine(), $exc->getTrace()[0]['args']);
        }
    }

    public function create(Request $request, $id)
    {
        try {
            $method = 'Method => BusinessCategoryMasterController => create';

            $menus = $this->FillMenu();
            $screens = $menus['screens'];
            $modules = $menus['modules'];

            $permission_data = $this->FillScreensByUser();
            $screen_permission = $permission_data[0];

            if ($id == 'school') {
                return view('business_category_master.create', compact('modules', 'screens', 'screen_permission'));
            } else {
                return view('alert.under_construction');
            }

        } catch (\Exception $exc) {
            return $this->sendLog($method, $exc->getCode(), $exc->getMessage(), $exc->getLine(), $exc->getTrace()[0]['args']);
        }
    }

    public function store_data(Request $request)
    {
        $method = 'Method => BusinessCategoryMasterController => store_data';
        // dd($request);
        $data = array();
        $data['schoolName']  = $request->schoolName;
        $data['schoolType'] =  $request->schoolType;
        $data['schoolAddress'] = $request->schoolAddress;
        $data['contactName'] = $request->contactName;
        $data['contactPosition'] = $request->contactPosition;
        $data['contactPhone'] = $request->contactPhone;
        $data['contactEmail'] = $request->contactEmail;
        $data['website'] = $request->website;
        $data['program'] = $request->program;

        $encryptArray = $this->encryptData($data);
        $request = array();
        $request['requestData'] = $encryptArray;
        
        $gatewayURL = config('setting.api_gateway_url') . '/business/affiliate/storedata';

        $response = $this->serviceRequest($gatewayURL, 'POST', json_encode($request), $method);
        $response1 = json_decode($response);
        if ($response1->Status == 200 && $response1->Success) {
            $objData = json_decode($this->decryptData($response1->Data));

            if ($objData->Code == 200) {
                return redirect(url('business/affiliate/list'))->with('success', 'Payment Master Added Successfully');
            }

            if ($objData->Code == 400) {
                return redirect(url('business/affiliate/list'))->with('fail', 'Payment Master Failed');
            }
        } else {
            $objData = json_decode($this->decryptData($response1->Data));
            echo json_encode($objData->Code);
            exit;
        }

        //
    }

    public function edit(Request $request, $id)
    {
        try {
            $method = 'Method => BusinessCategoryMasterController => index';

            $menus = $this->FillMenu();
            $screens = $menus['screens'];
            $modules = $menus['modules'];

            $permission_data = $this->FillScreensByUser();
            $screen_permission = $permission_data[0];            

            $gatewayURL = config('setting.api_gateway_url') . '/business/affiliate/getdata';
            $response = $this->serviceRequest($gatewayURL, 'GET', json_encode($id) , $method);

            $response = json_decode($response);
            if ($response->Status == 200 && $response->Success) {
                $objData = json_decode($this->decryptData($response->Data));
                if ($objData->Code == 200) {
                    $parant_data = json_decode(json_encode($objData->Data), true);
                    $rows = $parant_data['rows'];
                    // dd($rows);
                    
                    return view('business_category_master.edit', compact('rows', 'modules', 'screens', 'screen_permission'));
                }
            } else {
                $objData = json_decode($this->decryptData($response->Data));
                if ($objData->Code == "401") {
                    return redirect(route('/'))->with('danger', 'User session Exipired');
                }
                echo json_encode($objData->Code);
                exit;
            }
        } catch (\Exception $exc) {
            return $this->sendLog($method, $exc->getCode(), $exc->getMessage(), $exc->getLine(), $exc->getTrace()[0]['args']);
        }
    }

    public function update_data(Request $request)
    {
        $method = 'Method => BusinessCategoryMasterController => update_data';
        // dd($request);
        $data = array();
        $data['id']  = $request->id;
        $data['schoolName']  = $request->schoolName;
        $data['schoolType'] =  $request->schoolType;
        $data['schoolAddress'] = $request->schoolAddress;
        $data['contactName'] = $request->contactName;
        $data['contactPosition'] = $request->contactPosition;
        $data['contactPhone'] = $request->contactPhone;
        $data['contactEmail'] = $request->contactEmail;
        $data['website'] = $request->website;
        $data['program'] = $request->program;

        $encryptArray = $this->encryptData($data);
        $request = array();
        $request['requestData'] = $encryptArray;
        
        $gatewayURL = config('setting.api_gateway_url') . '/business/affiliate/updatedata';

        $response = $this->serviceRequest($gatewayURL, 'POST', json_encode($request), $method);
        $response1 = json_decode($response);
        if ($response1->Status == 200 && $response1->Success) {
            $objData = json_decode($this->decryptData($response1->Data));

            if ($objData->Code == 200) {
                return redirect(url('business/affiliate/list'))->with('success', 'Payment Master Added Successfully');
            }

            if ($objData->Code == 400) {
                return redirect(url('business/affiliate/list'))->with('fail', 'Payment Master Failed');
            }
        } else {
            $objData = json_decode($this->decryptData($response1->Data));
            echo json_encode($objData->Code);
            exit;
        }
    }
}
