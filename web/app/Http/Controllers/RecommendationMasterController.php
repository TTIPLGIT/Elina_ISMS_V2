<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Log;
use Validator;
use Redirect;


class RecommendationMaster extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response 
     */
    public function index(Request $request)
    {
        try {
            $method = 'Method => AreasMasterController => index';
            $gatewayURL = config('setting.api_gateway_url') . '/areas/master/index';
            
            $serviceResponse = array();
            $serviceResponse['dynamiclist'] = $request['dynamictype'];
            $serviceResponse = json_encode($serviceResponse, JSON_FORCE_OBJECT);
            $response = $this->serviceRequest($gatewayURL, 'GET', $serviceResponse, $method);
            
            $response = json_decode($response);
            if ($response->Status == 200 && $response->Success) {
                $objData = json_decode($this->decryptData($response->Data));
                if ($objData->Code == 200) {
                    $parant_data = json_decode(json_encode($objData->Data), true);
                   // $rows =  $parant_data['rows'];
                    $menus = $this->FillMenu();
                    $screens = $menus['screens'];
                    $modules = $menus['modules'];
                    $permission = $this->FillScreensByUser();
                    $screen_permission = $permission[0];

                    return view('master_recommendtion.index', compact('modules', 'screens', 'screen_permission'));
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
