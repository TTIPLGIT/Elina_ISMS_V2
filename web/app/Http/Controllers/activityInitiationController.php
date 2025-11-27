<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class activityInitiationController extends BaseController
{
    public function index()
    {
        try {
            $method = 'Method => activityInitiationController => index';
            $gatewayURL = config('setting.api_gateway_url') . '/activityinitiate/index';

            $response = $this->serviceRequest($gatewayURL, 'GET', '', $method);
            $response = json_decode($response);
            if ($response->Status == 200 && $response->Success) {
                $objData = json_decode($this->decryptData($response->Data));
                if ($objData->Code == 200) {
                    $parant_data = json_decode(json_encode($objData->Data), true);
                    $rows =  $parant_data['rows'];
                    $com = $parant_data['com'];
                    $observation = $parant_data['observation'][0]['id']; //dd($observation);
                    $total = $parant_data['total'];
                    $menus = $this->FillMenu();
                    $screens = $menus['screens'];
                    $modules = $menus['modules'];
                    $permission = $this->FillScreensByUser();
                    $screen_permission = $permission[0];
                    return view('activity_initiate.activitylist', compact('observation', 'com', 'total', 'rows', 'screens', 'modules', 'screen_permission'));
                }
            } else {
                $objData = json_decode($this->decryptData($response->Data));
                return Redirect::back()->with('fail', $objData->Message);
            }
        } catch (\Exception $exc) {
            return $this->sendLog($method, $exc->getCode(), $exc->getMessage(), $exc->getLine(), $exc->getTrace()[0]['args'][2]);
        }
    }



    public function create(Request $request)
    {

        try {
            $method = 'Method => activityInitiationController => create';
            $gatewayURL = config('setting.api_gateway_url') . '/activityinitiate/create';
            $response = $this->serviceRequest($gatewayURL, 'GET', '', $method);
            $response = json_decode($response);
            if ($response->Status == 200 && $response->Success) {
                $objData = json_decode($this->decryptData($response->Data));
                if ($objData->Code == 200) {
                    $parant_data = json_decode(json_encode($objData->Data), true);
                    $rows =  $parant_data['rows'];
                    $email = $parant_data['email'];
                    $activity = $parant_data['activity'];
                    $menus = $this->FillMenu();
                    $screens = $menus['screens'];
                    $modules = $menus['modules'];
                    return view('activity_initiate.videoinitiate', compact('rows', 'screens', 'modules', 'email', 'activity'));
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
        try { //dd($request);
            $method = 'Method => activityInitiationController => store';
            $data = array();
            $data['enrollment_id'] = $request->enrollment_id;
            $data['activity_id'] = $request->activity_id;
            $data['descriptionID'] = $request->descriptionID;
            $data['instructions'] = $request->get_instructions;
            $data['actionBtn'] = $request->actionBtn;
            $encryptArray = $this->encryptData($data);
            $actionBtn = $request->actionBtn;
            $value = $request->enrollment_id;
            $request = array();
            $request['requestData'] = $encryptArray;            

            $gatewayURL = config('setting.api_gateway_url') . '/activityinitiate/storedata';

            $response = $this->serviceRequest($gatewayURL, 'POST', json_encode($request), $method);
            //dd($response);
            $response1 = json_decode($response);
            if ($response1->Status == 200 && $response1->Success) {
                $objData = json_decode($this->decryptData($response1->Data));
                if ($objData->Code == 200) {
                    if($actionBtn == 'Save'){
                        return Redirect::back()->with('restore', ['message' => 'Activity Saved Successfully', 'value' => $value]);
                    }
                    return redirect(route('activity_initiate.index'))->with('success', 'Activity Initiated Successfully');
                }
                if ($objData->Code == 400) {
                    return Redirect::back()->with('fail', 'Activity Name Already Exists');
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

    public function activityajax(Request $request)

    {
        $method = 'Method => activityInitiationController => activityajax';
        try {

            $enrollment_id = $request->enrollment_id;



            $request = array();

            $request['requestData'] = $enrollment_id;



            $gatewayURL = config('setting.api_gateway_url') . '/activityinitiate/ajax';
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

    public function show($id)
    {

        try {

            $method = 'Method => activityInitiationController => show';

            // echo json_encode($id);exit;
            $gatewayURL = config('setting.api_gateway_url') . '/activityinitiate/data_edit/' . $id;

            $response = $this->serviceRequest($gatewayURL, 'GET', '', $method);

            $response = json_decode($response);

            if ($response->Status == 200 && $response->Success) {
                $objData = json_decode($this->decryptData($response->Data));
                if ($objData->Code == 200) {
                    $parant_data = json_decode(json_encode($objData->Data), true);


                    $rows = $parant_data['rows'];
                    $activityshow = $parant_data['activityshow'];

                    $menus = $this->FillMenu();
                    $screens = $menus['screens'];
                    $modules = $menus['modules'];
                    return view('activity_initiate.activityshow', compact('rows', 'screens', 'modules', 'activityshow'));
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
            $method = 'Method => activityInitiationController => edit';
            $gatewayURL = config('setting.api_gateway_url') . '/activityinitiate/data_edit/' . $id;

            $response = $this->serviceRequest($gatewayURL, 'GET', '', $method);
            $response = json_decode($response);

            if ($response->Status == 200 && $response->Success) {
                $objData = json_decode($this->decryptData($response->Data));
                if ($objData->Code == 200) {
                    $parant_data = json_decode(json_encode($objData->Data), true); //dd($parant_data);
                    $rows = $parant_data['rows'];
                    $activity = $parant_data['activity'];
                    $lastactivity = $parant_data['lastactivity'];
                    $comments = $parant_data['comments'];
                    $video_link = $parant_data['video_link'];//dd($video_link);
                    $currentactivity = $parant_data['currentactivity'];
                    $activity_materials = $parant_data['activity_materials'];
                    $activity_materials_mapping = $parant_data['activity_materials_mapping'];
                    $f2f_observation = $parant_data['f2f_observation'];
                    $lastactivity1 = $parant_data['lastactivity1'];
                    $datalist= json_decode($parant_data['datalist']);
                    $menus = $this->FillMenu();
                    $screens = $menus['screens'];
                    $modules = $menus['modules'];

                    return view('activity_initiate.activityedit', compact('activity_materials_mapping' , 'activity_materials' ,'currentactivity', 'comments', 'lastactivity', 'rows', 'video_link', 'screens', 'modules', 'activity','lastactivity1','datalist'));
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

        try { // dd($request , $id);
            $method = 'Method =>  activityInitiationController => update_data';
            $data = array();
            $data['activity_initiation_id'] = $id;
            $data['approval_status'] = $request->approval_status;
            $data['comments'] = $request->comments;
            $data['activity_description_id'] = $request->activity_description_id;
            $data['check_video'] = $request->check_video;
            $data['observation'] = $request->observation;
            $encryptArray = $this->encryptData($data);
            $request = array();
            //dd($data);
            $request['requestData'] = $encryptArray;
            $gatewayURL = config('setting.api_gateway_url') . '/activityinitiate/updatedata';
            $response = $this->serviceRequest($gatewayURL, 'POST', json_encode($request), $method);
            $response1 = json_decode($response);

            if ($response1->Status == 200 && $response1->Success) {

                $objData = json_decode($this->decryptData($response1->Data));

                if ($objData->Code == 200) {
                    // return redirect(route('activity_initiate.index'))
                    //     ->with('success', 'Activity status Updated Successfully');
                    $returnTab = $objData->Data;
                    return Redirect::back()
                        ->with('success', 'Activity status Updated Successfully')->with('key' , $returnTab);
                }
                if ($objData->Code == 400) {
                    return Redirect::back()
                        ->with('fail', 'Activitylist Name Already Exists');
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

    public function observation($id)
    {
        try {
            $method = 'Method => activityInitiationController => edit';

            $gatewayURL = config('setting.api_gateway_url') . '/activityinitiate/data_edit/' . $id;

            $response = $this->serviceRequest($gatewayURL, 'GET', '', $method);
            $response = json_decode($response);

            if ($response->Status == 200 && $response->Success) {
                $objData = json_decode($this->decryptData($response->Data));
                if ($objData->Code == 200) {
                    $parant_data = json_decode(json_encode($objData->Data), true);
                    $rows = $parant_data['rows'][0];
                    $activity = $parant_data['activity'];
                    $lastactivity = $parant_data['lastactivity'];
                    $comments = $parant_data['comments'];
                    $activity_set = $parant_data['activity_set'];
                    // $work_flow_row =  $parant_data['work_flow_row'];
                    $menus = $this->FillMenu();
                    $screens = $menus['screens'];
                    $modules = $menus['modules'];

                    return view('activity_initiate.activity_observation', compact('comments', 'lastactivity', 'rows', 'screens', 'modules', 'activity','activity_set'));
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

    public function observationrecord(Request $request, $id)
    {
        try {
            // dd($request);
            $method = 'Method =>  activityInitiationController => update_data';
            $data = array();
            $data['activity_initiation_id'] = $id;
            $data['observation_result'] = $request->observation_result;
            // $data['coordinator_observation'] = $request->coordinator_observation;
            // $data['head_observation'] = $request->head_observation;
            // $data['physical_observation_name'] = $request->physical_observation_name;
            // $data['physical_observation_result'] = $request->physical_observation_result;
            // dd($data);
            $encryptArray = $this->encryptData($data);
            $request = array();

            $request['requestData'] = $encryptArray;
            $gatewayURL = config('setting.api_gateway_url') . '/activityinitiate/observationrecord';
            $response = $this->serviceRequest($gatewayURL, 'POST', json_encode($request), $method);
            $response1 = json_decode($response);

            if ($response1->Status == 200 && $response1->Success) {

                $objData = json_decode($this->decryptData($response1->Data));

                if ($objData->Code == 200) {
                    return Redirect::back()->with('success', 'Activity Observation Saved Successfully');
                }
                if ($objData->Code == 400) {
                    return Redirect::back()->with('fail', 'Activitylist Name Already Exists');
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
    // public function data_delete($id)
    // {
    //     try {dd($id);

    //         $method = 'Method => QuestinnaireMasterCreation => data_delete';
    //         $id = $this->decryptData($id);

    //         DB::transaction(function () use ($id) {
    //             $uam_modules_id =  DB::table('questionnaire')
    //                 ->where('questionnaire_id', $id)
    //                 ->update([
    //                     'active_flag' => 1,
    //                     'last_modified_by' => auth()->user()->id,
    //                     'last_modified_date' => NOW()
    //                 ]);
    //         });

    //         $serviceResponse = array();
    //         $serviceResponse['Code'] = config('setting.status_code.success');
    //         $serviceResponse['Message'] = config('setting.status_message.success');
    //         $serviceResponse['Data'] = 1;
    //         $serviceResponse = json_encode($serviceResponse, JSON_FORCE_OBJECT);
    //         $sendServiceResponse = $this->SendServiceResponse($serviceResponse, config('setting.status_code.success'), true);
    //         return $sendServiceResponse;
    //     } catch (\Exception $exc) {
    //         $exceptionResponse = array();
    //         $exceptionResponse['ServiceMethod'] = $method;
    //         $exceptionResponse['Exception'] = $exc->getMessage();
    //         $exceptionResponse = json_encode($exceptionResponse, JSON_FORCE_OBJECT);
    //         $this->WriteFileLog($exceptionResponse);
    //         $serviceResponse = array();
    //         $serviceResponse['Code'] = config('setting.status_code.exception');
    //         $serviceResponse['Message'] = $exc->getMessage();
    //         $serviceResponse = json_encode($serviceResponse, JSON_FORCE_OBJECT);
    //         $sendServiceResponse = $this->SendServiceResponse($serviceResponse, config('setting.status_code.exception'), false);
    //         return $sendServiceResponse;
    //     }
    // }

    public function activeStatus(Request $request, $id)
    {

        try {
            $method = 'Method =>  activityInitiationController => update_data';
            $data = array();
            $data['activity_initiation_id'] = $id;
            $data['approval_status'] = $request->approval_status;
            // dd($data);
            $encryptArray = $this->encryptData($data);
            $request = array();

            $request['requestData'] = $encryptArray;
            $gatewayURL = config('setting.api_gateway_url') . '/activityinitiate/activeStatus';
            $response = $this->serviceRequest($gatewayURL, 'POST', json_encode($request), $method);
            $response1 = json_decode($response);

            if ($response1->Status == 200 && $response1->Success) {

                $objData = json_decode($this->decryptData($response1->Data));

                if ($objData->Code == 200) {
                    return redirect(route('activity_initiate.index'))
                        ->with('success', 'Activity status Updated Successfully');
                }
                if ($objData->Code == 400) {
                    return Redirect::back()
                        ->with('fail', 'Activitylist Name Already Exists');
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
    public function bulk_update(Request $request)
    {

        try { //dd($request);
            $method = 'Method =>  activityInitiationController => bulk_update';
            $data = array();
            $data['approval'] = $request->approval;
            $data['pvID'] = $request->pvID;
            $data['aID'] = $request->aID;
            $data['comment'] = $request->comment;
            $encryptArray = $this->encryptData($data);
            $request = array();
            //dd($data);
            $request['requestData'] = $encryptArray;
            $gatewayURL = config('setting.api_gateway_url') . '/activity/edit/bulk';
            $response = $this->serviceRequest($gatewayURL, 'POST', json_encode($request), $method);
            $response1 = json_decode($response);

            if ($response1->Status == 200 && $response1->Success) {
                $objData = json_decode($this->decryptData($response1->Data));

                return $objData;
                echo json_encode($objData);

                // if ($objData->Code == 200) {
                //     $rows = json_decode(json_encode($objData->Data), true);
                //     return $rows;
                //     echo json_encode($rows);
                // }
            }
        } catch (\Exception $exc) {
            return $this->sendLog($method, $exc->getCode(), $exc->getMessage(), $exc->getLine(), $exc->getTrace()[0]['args'][2]);
        }
    }

    public function update_toggle(Request $request)
    {
        try {

            $method = 'Method => activityInitiationController => update_toggle';
            $data = array();
            $data['is_active'] = $request->is_active;
            $data['f_id'] = $request->f_id;
            $encryptArray = $this->encryptData($data);
            $request = array();
            $request['requestData'] = $encryptArray;
            $gatewayURL = config('setting.api_gateway_url') . '/activity_initiate/update_toggle';
            $response = $this->serviceRequest($gatewayURL, 'POST', json_encode($request), $method);
            $response1 = json_decode($response);


            if ($response1->Status == 200 && $response1->Success) {
                $objData = json_decode($this->decryptData($response1->Data));
                echo $this->decryptData($response1->Data);
            } else {
                $objData = json_decode($this->decryptData($response1->Data));
                echo json_encode($objData->Code);
                exit;
            }
        } catch (\Exception $exc) {
            
            return $this->sendLog($method, $exc->getCode(), $exc->getMessage(), $exc->getLine(), $exc->getTrace()[0]['args'][2]);
        }
    }

    public function activity_update(Request $request)
    {

        try {
            // dd($request->is_active_tab);
            $method = 'Method =>  activityInitiationController => update_data';
            $returnTab = $request->is_active_tab;
            $data = array();
            $data['approval_status'] = $request->approval_status;
            $data['comments'] = $request->comments;
            $data['activity_initiation'] = $request->activity_initiation_id;
            $data['check_video'] = $request->check_video;
            $data['observation'] = $request->observation;
            $data['parent_video_upload'] = $request->parent_video_upload_id;
            $data['enrollment_id'] = $request->enrollment_id;
            $data['description'] = $request->description_id;
            $data['materials_required'] = $request->material;
            $data['to_observe'] = $request->to_observe;
            $data['to_ask_parents'] = $request->to_ask_parents;
            $data['enablef2f'] = $request->enablef2f;
            $encryptArray = $this->encryptData($data);
            $request = array();
            // dd($data);

            $request['requestData'] = $encryptArray;
            $gatewayURL = config('setting.api_gateway_url') . '/activityinitiate/update/video';
            $response = $this->serviceRequest($gatewayURL, 'POST', json_encode($request), $method);
            $response1 = json_decode($response);

            if ($response1->Status == 200 && $response1->Success) {

                $objData = json_decode($this->decryptData($response1->Data));

                if ($objData->Code == 200) {
                    // return redirect(route('activity_initiate.index'))
                    //     ->with('success', 'Activity status Updated Successfully');
                    return Redirect::back()->with('success', 'Activity status Updated Successfully')->with('key' , $returnTab);
                }
                if ($objData->Code == 400) {
                    return Redirect::back()->with('fail', 'Activitylist Name Already Exists');
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

    public function activity_save(Request $request)
    {
        try {
            // $data1 = $request->except('_token');
            // dd($request);
            $method = 'Method =>  activityInitiationController => activity_save';
            $data = array();
            $data['approval_status'] = $request->approval_status;
            $data['comments'] = $request->comments;
            $data['activity_initiation'] = $request->activity_initiation_id;
            $data['check_video'] = $request->check_video;
            $data['observation'] = $request->observation;
            $data['parent_video_upload'] = $request->parent_video_upload_id;
            $data['enrollment_id'] = $request->enrollment_id;
            $data['description'] = $request->description_id;
            $data['materials_required'] = $request->material;
            $data['to_observe'] = $request->to_observe;
            $data['to_ask_parents'] = $request->to_ask_parents;
            $data['enablef2f'] = $request->enablef2f;
            $data['pvID'] = $request->pvID;
            $encryptArray = $this->encryptData($data);
            
            // dd($data);
            
            $request = array();
            $request['requestData'] = $encryptArray;
            $gatewayURL = config('setting.api_gateway_url') . '/activityinitiate/save/video';
            $response = $this->serviceRequest($gatewayURL, 'POST', json_encode($request), $method);
            $response1 = json_decode($response);

            if ($response1->Status == 200 && $response1->Success) {
                $objData = json_decode($this->decryptData($response1->Data));
                return true;
            } else {
                $objData = json_decode($this->decryptData($response1->Data));
                echo json_encode($objData->Code);
                exit;
            }
        } catch (\Exception $exc) {
            return $this->sendLog($method, $exc->getCode(), $exc->getMessage(), $exc->getLine(), $exc->getTrace()[0]['args'][2]);
        }
    }

    public function send_required(Request $request)
    {
        try { //dd($request);
            $method = 'Method =>  activityInitiationController => send_required';
            $data = array();
            $data['activityids'] = $request->activityids;
            $data['emaildraft'] = $request->emaildraft;
            $data['enrollment_id'] = $request->enrollment_id;
            $encryptArray = $this->encryptData($data);
            $request = array();
            //dd($data);
            $request['requestData'] = $encryptArray;
            $gatewayURL = config('setting.api_gateway_url') . '/activity/send/required';
            $response = $this->serviceRequest($gatewayURL, 'POST', json_encode($request), $method);
            $response1 = json_decode($response);

            if ($response1->Status == 200 && $response1->Success) {
                $objData = json_decode($this->decryptData($response1->Data));
                return $objData;
                echo json_encode($objData);
            }
        } catch (\Exception $exc) {
            return $this->sendLog($method, $exc->getCode(), $exc->getMessage(), $exc->getLine(), $exc->getTrace()[0]['args'][2]);
        }
    }

    public function reload($id){
        //dd($id);
    }
    public function activity_f2fstore(Request $request)
    {  
        try { //dd($request);
            $method = 'Method => activityInitiationController => activity_f2fstore';
            $data = array();
            $selectedMaterials = $request->input('materials', []);
            $data['enrollment_id'] = $request->enrollment_id;
            $data['activity_id'] = $request->activity_set;
            $data['descriptionID'] = $request->description;
            //$data['description_name'] = $request->description_name;
            // $data['materials'] = $request->materials;
            $data['to_observe'] = $request->to_observe;
            $data['ask_parent'] = $request->ask_parent;
            $data['Observation'] = $request->Observation;
            $data['materials'] = $selectedMaterials; // Assigning selected materials to your data array
            $data['actionf2f'] = $request->actionf2f;
           
            $encryptArray = $this->encryptData($data);
            $actionBtn = $request->actionf2f;
            $value = $request->enrollment_id;
            $activityID = $request->activity_set;
            $descriptionID = $request->description;
            $request = array();
            $request['requestData'] = $encryptArray;            

            $gatewayURL = config('setting.api_gateway_url') . '/activity/f2f/store';

            $response = $this->serviceRequest($gatewayURL, 'POST', json_encode($request), $method);
            //dd($response);
            $response1 = json_decode($response);
            if ($response1->Status == 200 && $response1->Success) {
                $objData = json_decode($this->decryptData($response1->Data));
                if ($objData->Code == 200) {
                    if($actionBtn == 'Submit'){
                        return Redirect::back()->with('success', 'F2F Submitted Successfully');
                    }
                    if($actionBtn == 'Save'){
                        return Redirect::back()
                        ->with('save', 'F2F Saved Successfully')
                        ->with('activityID', $activityID)
						->with('descriptionID', $descriptionID);
                    }
                }
                if ($objData->Code == 400) {
                    return Redirect::back()->with('fail', 'F2F Already Exists');
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
    public function activity_f2fedit($id)
    {
        
        try {
            $method = 'Method => activityInitiationController => activity_f2fedit';
            $id = $this->decryptData($id);
            $gatewayURL = config('setting.api_gateway_url') . '/activity/f2f/edit/' . $this->encryptData($id);
            $response = $this->serviceRequest($gatewayURL, 'GET', '', $method);
            $response = json_decode($response);

            if ($response->Status == 200 && $response->Success) {
                
                $objData = json_decode($this->decryptData($response->Data));
                if ($objData->Code == 200) {
                    $rows = json_decode(json_encode($objData->Data), true);
                    return $rows;
                    echo json_encode($rows);                }
            } else {
                $objData = json_decode($this->decryptData($response->Data));
                echo json_encode($objData->Code);
                exit;
            }
        } catch (\Exception $exc) {
            
            return $this->sendLog($method, $exc->getCode(), $exc->getMessage(), $exc->getLine(), $exc->getTrace()[0]['args'][2]);
        }
    }
   
    public function activity_f2fdelete($id)
    {      
        // $this->WriteFileLog($id);

        try {
            $method = 'Method => activityInitiationController => activity_f2fdelete';
            //  $id = $this->decryptData($id);
            $data['id'] = $id;
            // $this->WriteFileLog($data);
            $encryptArray = $this->encryptData($data);
            $request = array();
            $request['requestData'] = $encryptArray;
            $gatewayURL = config('setting.api_gateway_url') . '/activity/f2f/delete';
            $response = $this->serviceRequest($gatewayURL, 'GET', json_encode($request), $method);
            // $this->WriteFileLog($response);
            $response1 = json_decode($response);
            $objData = json_decode($this->decryptData($response1->Data));
            $rows = json_decode(json_encode($objData->Data), true);
            return $rows;
        } catch (\Exception $exc) {
            
            return $this->sendLog($method, $exc->getCode(), $exc->getMessage(), $exc->getLine(), $exc->getTrace()[0]['args'][2]);
        }
    }
    public function fetch(Request $request)
    {

        try {
            // $this->WriteFileLog("feef");
            $method = 'Method => activityInitiationController => fetch';
            // $user_id = $request->session()->get("userID");
            // if ($user_id == null) {
            //     return view('auth.login');
            // }
            $data['id'] = $request->id;
            $encryptArray = $this->encryptData($data);
            $request = array();
            $request['requestData'] = $encryptArray;


            $gatewayURL = config('setting.api_gateway_url') . '/activity/f2f/fetch';
            $response = $this->serviceRequest($gatewayURL, 'GET', json_encode($request), $method);
            // $this->WriteFileLog($response);
            $response1 = json_decode($response);
            $objData = json_decode($this->decryptData($response1->Data));
            $rows = json_decode(json_encode($objData->Data), true);
            return $rows;
        } catch (\Exception $exc) {
            echo $exc;
            return $this->sendLog($method, $exc->getCode(), $exc->getMessage(), $exc->getTrace()[0]['line'], $exc->getTrace()[0]['file']);
        }
    }
    public function activity_f2fupdate(Request $request)
    {  
        try { 
            $method = 'Method => activityInitiationController => activity_f2fupdate';
            $data = array();
            $data['enrollment_id'] = $request->enrollment_id;
            $data['activity_id'] = $request->activity_id;
            $data['descriptionID'] = $request->description_id;
            //$data['description_name'] = $request->description_name;
            // $data['materials'] = $request->materials;
            $data['to_observe'] = $request->to_observe_edit;
            $data['ask_parent'] = $request->ask_parent_edit;
            $data['Observation'] = $request->Observation_edit;
            $data['materials'] = $request->materials_edit; // Assigning selected materials to your data array
            $data['parent_video_id'] = $request->parent_video_id; // Assigning selected materials to your data array
           
            $encryptArray = $this->encryptData($data);
            $actionBtn = $request->actionBtn;
            $value = $request->enrollment_id;
            $activity_initiation_id = $this->encryptData($request->activity_initiation_id);
            $request = array();
            $request['requestData'] = $encryptArray;            

            $gatewayURL = config('setting.api_gateway_url') . '/activity/f2f/update';

            $response = $this->serviceRequest($gatewayURL, 'POST', json_encode($request), $method);
            // dd($response);
            $response1 = json_decode($response);
            if ($response1->Status == 200 && $response1->Success) {
                $objData = json_decode($this->decryptData($response1->Data));
                if ($objData->Code == 200) {
                    // if($actionBtn == 'Submit'){
                        return redirect(route('activityinitiate.observation',$activity_initiation_id))->with('success', 'F2F Updated Successfully');
                    // }
                }
                if ($objData->Code == 400) {
                    return Redirect::back()->with('fail', 'F2F Already Exists');
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
