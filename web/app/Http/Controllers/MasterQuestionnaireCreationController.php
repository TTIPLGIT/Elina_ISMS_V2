<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Log;
use Validator;
use Redirect;


class MasterQuestionnaireCreationController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response 
     */
    public function index(Request $request)
    {
        try {
            $method = 'Method => MasterQuestionnaireCreationController => index';
            // $gatewayURL = config('setting.api_gateway_url') . '/questionnaire_master/get_data';
            // $serviceResponse = array();
            // $serviceResponse['dynamiclist'] = $request['dynamictype'];
            // $serviceResponse = json_encode($serviceResponse, JSON_FORCE_OBJECT);
            // $response = $this->serviceRequest($gatewayURL, 'GET', $serviceResponse, $method);
            // $response = json_decode($response);
            // if ($response->Status == 200 && $response->Success) {
            //     $objData = json_decode($this->decryptData($response->Data));
            //     if ($objData->Code == 200) {
            //         $parant_data = json_decode(json_encode($objData->Data), true);
            //         $rows =  $parant_data['rows'];
                    $menus = $this->FillMenu();
                    $screens = $menus['screens'];
                    $modules = $menus['modules'];
                    $permission = $this->FillScreensByUser();
                    $screen_permission = $permission[0];

                    return view('questionnaire_master13+.index', compact('modules', 'screens', 'screen_permission'));
            //     }
            // } else {
            //     $objData = json_decode($this->decryptData($response->Data));
            //     echo json_encode($objData->Code);
            //     exit;
            // }
        } catch (\Exception $exc) {
            
            return $this->sendLog($method, $exc->getCode(), $exc->getMessage(), $exc->getLine(), $exc->getTrace()[0]['args'][2]);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // dd('create');
        try {
            $method = 'Method => MasterQuestionnaireCreationController => create';

            $menus = $this->FillMenu();
            $screens = $menus['screens'];
            $modules = $menus['modules'];

            return view('questionnaire_master13+.create', compact('modules', 'screens'));
        } catch (\Exception $exc) {
            
            return $this->sendLog($method, $exc->getCode(), $exc->getMessage(), $exc->getLine(), $exc->getTrace()[0]['args'][2]);
        }
    }



    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            $method = 'Method => QuestionnaireMasterCreation => store';
// dd($request);
            $rules = [
                'questionnaire_name' => 'required',
            ];

            $messages = [
                'questionnaire_name.required' => 'Questionnaire Name is required',
            ];

            $validator = Validator::make($request->all(), $rules, $messages);

            if ($validator->fails()) {
                return Redirect::back()->withErrors($validator);
            } else {
                $data = array();
                $table_name = $request->questionnaire_name;
                $findString = array(' ', '&');
                $replaceString = array('_', '_');
                $tableName = str_replace($findString, $replaceString, $table_name);
// dd($tableName);
                $data['questionnaire_name'] = $request->questionnaire_name;
                $data['questionnaire_description'] = $request->questionnaire_description;
                $data['tableName'] = $tableName;
                $data['questionnaire_type'] = $request->questionnaire_type;
                $data['is_active'] = ($request->is_active == 'on') ? '1' : '0';
                $data['option'] = $request->option;
                $data['value'] = $request->value;
                $data['quadrant'] = $request->quadrant;
                $data['category'] = $request->category;

                $encryptArray = $this->encryptData($data);
                $request = array();
                $request['requestData'] = $encryptArray;
                $gatewayURL = config('setting.api_gateway_url') . '/questionnaire_master/storedata';
                $response = $this->serviceRequest($gatewayURL, 'POST', json_encode($request), $method);
                $response1 = json_decode($response);

                if ($response1->Status == 200 && $response1->Success) {
                    $objData = json_decode($this->decryptData($response1->Data));
                    if ($objData->Code == 200) {
                        return redirect(route('questionnaire_master.index'))->with('success', 'Questionnaire Created Successfully');
                    }
                } else {
                    $objData = json_decode($this->decryptData($response1->Data));
                    echo json_encode($objData->Code);
                    exit;
                }
            }
        } catch (\Exception $exc) {
            
            return $this->sendLog($method, $exc->getCode(), $exc->getMessage(), $exc->getLine(), $exc->getTrace()[0]['args'][2]);
        }
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function show($id)
    {
        try {
            $method = 'Method => QuestionnaireMasterCreation => show';
            $id = $this->decryptData($id);
            $gatewayURL = config('setting.api_gateway_url') . '/questionnaire_master/data_edit/' . $this->encryptData($id);
            $response = $this->serviceRequest($gatewayURL, 'GET', '', $method);
            $response = json_decode($response);

            if ($response->Status == 200 && $response->Success) {
                $objData = json_decode($this->decryptData($response->Data));
                if ($objData->Code == 200) {
                    $parant_data = json_decode(json_encode($objData->Data), true);

                    $one_row =  $parant_data['one_rows'];

                    $menus = $this->FillMenu();
                    $screens = $menus['screens'];
                    $modules = $menus['modules'];
                    $permissions = config('permission.screen_permission');

                    return view('questionnaire_master.show', compact('permissions', 'one_row', 'modules', 'screens'));
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
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        try {
            $method = 'Method => MasterQuestionnaireCreationController => edit';
            // $id = $this->decryptData($id);
            // $gatewayURL = config('setting.api_gateway_url') . '/questionnaire_master/data_edit/' . $this->encryptData($id);
            // $response = $this->serviceRequest($gatewayURL, 'GET', '', $method);
            // $response = json_decode($response);

            // if ($response->Status == 200 && $response->Success) {
            //     $objData = json_decode($this->decryptData($response->Data));
            //     if ($objData->Code == 200) {
            //         $parant_data = json_decode(json_encode($objData->Data), true);
            //         $one_row =  $parant_data['one_rows'];//dd($one_row);
            //         $fields = $parant_data['fields'];
            //         $options = $parant_data['options'];
                    $menus = $this->FillMenu();
                    $screens = $menus['screens'];
                    $modules = $menus['modules'];
                    $permissions = config('permission.screen_permission');

                    return view('questionnaire_master13+.edit', compact('permissions', 'modules', 'screens'));
                // }
            // } else {
            //     $objData = json_decode($this->decryptData($response->Data));
            //     echo json_encode($objData->Code);
            //     exit;
            // }
        } catch (\Exception $exc) {
            
            return $this->sendLog($method, $exc->getCode(), $exc->getMessage(), $exc->getLine(), $exc->getTrace()[0]['args'][2]);
        }
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update_data(Request $request)
    {
        try {
            $method = 'Method => QuestionnaireMasterCreation => update_data';
// dd(($request));
            $rules = [
                'questionnaire_name' => 'required',
            ];

            $messages = [
                'questionnaire_name.required' => 'Questionnaire Name is Required',
            ];

            $validator = Validator::make($request->all(), $rules, $messages);

            if ($validator->fails()) {
                return Redirect::back()->withErrors($validator);
            } else {

                $data = array();
                $data['questionnaire_name'] = $request->questionnaire_name;
                $data['questionnaire_id'] = $request->questionnaire_id;
                $data['questionnaire_description'] = $request->questionnaire_description;
                $data['questionnaire_type'] = $request->questionnaire_type;
                $data['is_active'] = ($request->is_active == 'on') ? '1' : '0';
                $data['option'] = $request->option;
                $data['value'] = $request->value;
                $data['quadrant'] = $request->quadrant;
                $data['category'] = $request->category;
                // dd($data);
                $encryptArray = $this->encryptData($data);
                $request = array();
                $request['requestData'] = $encryptArray;
                $gatewayURL = config('setting.api_gateway_url') . '/questionnaire_master/updatedata';
                $response = $this->serviceRequest($gatewayURL, 'POST', json_encode($request), $method);
                $response1 = json_decode($response);

                if ($response1->Status == 200 && $response1->Success) {
                    $objData = json_decode($this->decryptData($response1->Data));
                    if ($objData->Code == 200) {
                        return redirect(route('questionnaire_master.index'))->with('success', 'Questionnaire Name Updated Successfully');
                    }
                } else {
                    $objData = json_decode($this->decryptData($response1->Data));
                    echo json_encode($objData->Code);
                    exit;
                }
            }
        } catch (\Exception $exc) {
            
            return $this->sendLog($method, $exc->getCode(), $exc->getMessage(), $exc->getLine(), $exc->getTrace()[0]['args'][2]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
   
    public function delete($id)
    {
        // dd($id);
        try {
            $method = 'Method => QuestionnaireMasterCreation => delete';
            $id = $this->decryptData($id);
            $gatewayURL = config('setting.api_gateway_url') . '/questionnaire_master/data_delete/' . $this->encryptData($id);
            $response = $this->serviceRequest($gatewayURL, 'GET', '', $method);

            $response1 = json_decode($response);
            if ($response1->Status == 200 && $response1->Success) {
                $objData = json_decode($this->decryptData($response1->Data));
                if ($objData->Code == 200) {
                    return redirect(route('questionnaire_master.index'))->with('success', 'Questionnaire Deleted Successfully');
                }
                if ($objData->Code == 400) {
                    return redirect(route('questionnaire_master.index'))->with('fail', 'Something Went Wrong');
                }
            }
        } catch (\Exception $exc) {
            
            return $this->sendLog($method, $exc->getCode(), $exc->getMessage(), $exc->getLine(), $exc->getTrace()[0]['args'][2]);
        }
    }

}
