<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SWOTMasterController extends BaseController
{
    public function index()
    {
        try {
            $method = 'Method => SWOTMasterController => index';
            // 

            $menus = $this->FillMenu();
            $screens = $menus['screens'];
            $modules = $menus['modules'];
            return view('swot.index', compact('modules', 'screens'));
            // 
            $gatewayURL = config('setting.api_gateway_url') . '/auditlog/activity';
            $response = $this->serviceRequest($gatewayURL, 'GET', '', $method);
            $response = json_decode($response);
            if ($response->Status == 200 && $response->Success) {
                $objData = json_decode($this->decryptData($response->Data));
                if ($objData->Code == 200) {
                    $data2 = json_decode(json_encode($objData->Data), true);

                    $menus = $this->FillMenu();
                    $screens = $menus['screens'];
                    $modules = $menus['modules'];
                    return view('auditlog.login.activity_details', compact('modules', 'screens', 'receipt_no', 'user_id', 'received_for', 'source_type', 'uam_action', 'workflow_action', 'form_action', 'data2', 'department_action'));
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
            $method = 'Method => PerformanceAreaController => create';
            // 

            $menus = $this->FillMenu();
            $screens = $menus['screens'];
            $modules = $menus['modules'];
            return view('swot.create', compact('modules', 'screens'));
            // 
            $gatewayURL = config('setting.api_gateway_url') . '/performancearea/create';
            $response = $this->serviceRequest($gatewayURL, 'GET', '', $method);
            $response = json_decode($response);
            if ($response->Status == 200 && $response->Success) {
                $objData = json_decode($this->decryptData($response->Data));
                if ($objData->Code == 200) {
                    $data2 = json_decode(json_encode($objData->Data), true);

                    $menus = $this->FillMenu();
                    $screens = $menus['screens'];
                    $modules = $menus['modules'];
                    return view('auditlog.login.activity_details', compact('modules', 'screens', 'receipt_no', 'user_id', 'received_for', 'source_type', 'uam_action', 'workflow_action', 'form_action', 'data2', 'department_action'));
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
