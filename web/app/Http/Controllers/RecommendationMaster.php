<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Log;
use Validator;
use Redirect;


class RecommendationMasterController extends BaseController
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
                    $rows =  $parant_data['rows'];
                    $menus = $this->FillMenu();
                    $screens = $menus['screens'];
                    $modules = $menus['modules'];
                    $permission = $this->FillScreensByUser();
                    $screen_permission = $permission[0];

                    return view('Recommendation_master.index', compact('rows', 'modules', 'screens', 'screen_permission'));
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
            $method = 'Method => AreasMasterController => Create';
            $gatewayURL = config('setting.api_gateway_url') . '/areas/master/index';
            
            $response = $this->serviceRequest($gatewayURL, 'GET', '', $method);
            $response = json_decode($response);
            if ($response->Status == 200 && $response->Success) {
                $objData = json_decode($this->decryptData($response->Data));
                if ($objData->Code == 200) {
                    $parant_data = json_decode(json_encode($objData->Data), true);
                    $menus = $this->FillMenu();
                    $screens = $menus['screens'];
                    $modules = $menus['modules'];
                    return view('Recommendation_master.create', compact('modules', 'screens'));
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
            $method = 'Method => AreasMasterController => store_data';
            $data = array();
            $data['Areas_Name'] = $request->Areas_Name;
            $data['table_num'] = $request->table_num;
            $encryptArray = $this->encryptData($data);
            $request = array();
            $request['requestData'] = $encryptArray;
            $gatewayURL = config('setting.api_gateway_url') . '/area/master/recommendation/store';
            $response = $this->serviceRequest($gatewayURL, 'POST', json_encode($request), $method);
            $response1 = json_decode($response);
            if ($response1->Status == 200 && $response1->Success) {
                $objData = json_decode($this->decryptData($response1->Data));
                $data = json_decode(json_encode($objData->Data), true);
                $encryptData = $this->encryptData($data);
                //echo $encryptData;
                 return redirect(route('areas_master.index'))->with('success', 'Question Created Successfully');
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
        try {
            $method = 'Method => AreasMasterController => edit';
            $id = $this->decryptData($id);
            $gatewayURL = config('setting.api_gateway_url') . '/areas/master/data_edit/' . $this->encryptData($id);
            $response = $this->serviceRequest($gatewayURL, 'GET', '', $method);
            $response = json_decode($response);

            if ($response->Status == 200 && $response->Success) {
                $objData = json_decode($this->decryptData($response->Data));
                if ($objData->Code == 200) {
                    $parant_data = json_decode(json_encode($objData->Data), true);
                    $area_edit =  $parant_data['area_edit'];
                    $menus = $this->FillMenu();
                    $screens = $menus['screens'];
                    $modules = $menus['modules'];
                    $permissions = config('permission.screen_permission');

                    return view('Recommendation_master.edit', compact('permissions', 'area_edit', 'modules', 'screens'));
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

    public function update(Request $request)
    {
        // dd($request->edit_field_types_id);
        try {
            $method = 'Method => AreasMasterController => update';
           
            $data = array();
            $data['recommendation_detail_area_id'] = $request->recommendation_detail_area_id;
            $data['Areas_Name'] = $request->Areas_Name;
            $data['table_num'] = $request->table_num;
            
             
            $encryptArray = $this->encryptData($data);
            $request = array();
            $request['requestData'] = $encryptArray;
            $gatewayURL = config('setting.api_gateway_url') . '/areas/master/update_data';
            $response = $this->serviceRequest($gatewayURL, 'POST', json_encode($request), $method);
            $response1 = json_decode($response);
            if ($response1->Status == 200 && $response1->Success) {
                $objData = json_decode($this->decryptData($response1->Data));
                $data = json_decode(json_encode($objData->Data), true);
                $encryptData = $this->encryptData($data);
                //echo $encryptData;
             return redirect(route('areas_master.index'))->with('success', 'Areas Name Created Successfully');
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
        try {
            $method = 'Method => AreasMasterController => delete';
            //  $id = $this->decryptData($id);
            $gatewayURL = config('setting.api_gateway_url') . '/area/master/delete' . $this->encryptData($id);
            $response = $this->serviceRequest($gatewayURL, 'GET', '', $method);
            $response1 = json_decode($response);

            if ($response1->Status == 200 && $response1->Success) {
                $objData = json_decode($this->decryptData($response1->Data));
                if ($objData->Code == 200) {
                    return redirect(route('question_creation.index'));
                }
                if ($objData->Code == 400) {
                    return redirect(route('question_creation.index'))->with('fail', $objData->Code);
                }
            }
        } catch (\Exception $exc) {
            
            return $this->sendLog($method, $exc->getCode(), $exc->getMessage(), $exc->getLine(), $exc->getTrace()[0]['args'][2]);
        }
    }

}
