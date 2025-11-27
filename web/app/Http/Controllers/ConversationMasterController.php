<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class ConversationMasterController extends BaseController
{
    // G2 Form 
    public function G2_Index()
    {
        $permission_data = $this->FillScreensByUser();
        $screen_permission = $permission_data[0];
        $id = 1;
        if (strpos($screen_permission['permissions'], 'View') !== false) {
            try {
                $method = 'Method => ConversationMasterController => G2_Index';

                $menus = $this->FillMenu();
                $screens = $menus['screens'];
                $modules = $menus['modules'];

                $gatewayURL = config('setting.api_gateway_url') . '/conversation/summery/getdata/' . $id;
                $response = $this->serviceRequest($gatewayURL, 'GET', '', $method);
                $response = json_decode($response);
                $objData = json_decode($this->decryptData($response->Data));
                $responce_data = json_decode(json_encode($objData->Data), true);
                $rows = $responce_data['rows'];
                return view('conversation_master.index', compact('screen_permission', 'rows', 'menus', 'screens', 'modules'));
            } catch (\Exception $exc) {
                return $this->sendLog($method, $exc->getCode(), $exc->getMessage(), $exc->getLine(), $exc->getTrace()[0]['args'][2]);
            }
        } else {
            return redirect()->route('not_allow');
        }
    }

    public function G2_Store(Request $request)
    {
        // dd($request);
        try {
            $method = 'Method => ConversationMasterController => G2_Store';
            $data = array();
            $data['id'] = $request->id;
            $data['question'] = $request->question;
            $data['description'] = $request->description;
            $data['required'] = $request->required;
            $data['type_id'] = $request->type_id;
            $data['group'] = $request->group;
            $data['prefilled_data'] = $request->prefilled_data;
            $data['additional_question_check'] = $request->additional_question_check;
            $data['additional_question_data'] = $request->additional_question_data;
            // dd($data);
            $encryptArray = $this->encryptData($data);
            $request = array();
            $request['requestData'] = $encryptArray;
            $gatewayURL = config('setting.api_gateway_url') . '/conversation/summery/storedata';
            $response = $this->serviceRequest($gatewayURL, 'POST', json_encode($request), $method);
            $response1 = json_decode($response);

            if ($response1->Status == 200 && $response1->Success) {
                $objData = json_decode($this->decryptData($response1->Data));
                if ($objData->Code == 200) {
                    $parant_data = json_decode(json_encode($objData->Data), true);
                    return Redirect::back()->with('success', 'Question Added Successfully');
                }
                if ($objData->Code == 400) {
                    return Redirect::back();
                    return redirect(route('master.gform.index'))->with('fail', 'Something went wrong');
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

    public function G2_Update(Request $request)
    {
        // dd($request);
        try {
            $method = 'Method => ConversationMasterController => G2_Update';
            $data = array();
            $data['id'] = $request->id;
            $data['question'] = $request->question;
            $data['description'] = $request->description;
            $data['required'] = $request->required;
            $data['type_id'] = $request->type_id;
            $data['group'] = $request->group;
            $data['prefilled_data'] = $request->prefilled_data;
            $data['additional_question_check'] = $request->additional_question_check;
            $data['additional_question_data'] = $request->additional_question_data;
            // dd($data);
            $encryptArray = $this->encryptData($data);
            $request = array();
            $request['requestData'] = $encryptArray;
            $gatewayURL = config('setting.api_gateway_url') . '/conversation/summery/updatedata';
            $response = $this->serviceRequest($gatewayURL, 'POST', json_encode($request), $method);
            $response1 = json_decode($response);

            if ($response1->Status == 200 && $response1->Success) {
                $objData = json_decode($this->decryptData($response1->Data));
                if ($objData->Code == 200) {
                    $parant_data = json_decode(json_encode($objData->Data), true);
                    return Redirect::back()->with('success', 'Updated Successfully');
                }
                if ($objData->Code == 400) {
                    return Redirect::back();
                    return redirect(route('master.gform.index'))->with('fail', 'Something went wrong');
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

    // Conversation Summery
    public function Summery_Index()
    {
        $permission_data = $this->FillScreensByUser();
        $screen_permission = $permission_data[0];
        $id = 2;
        if (strpos($screen_permission['permissions'], 'View') !== false) {
            try {
                $method = 'Method => ConversationMasterController => Summery_Index';

                $menus = $this->FillMenu();
                $screens = $menus['screens'];
                $modules = $menus['modules'];

                $gatewayURL = config('setting.api_gateway_url') . '/conversation/summery/getdata/' . $id;
                $response = $this->serviceRequest($gatewayURL, 'GET', '', $method);
                $response = json_decode($response);
                $objData = json_decode($this->decryptData($response->Data));
                $responce_data = json_decode(json_encode($objData->Data), true);

                $rows = $responce_data['rows'];
                $groupdata = $responce_data['group'];
                $uniqueGroups = array_unique(array_column($rows, 'group_id'));
                // dd(in_array("1", $uniqueGroups));

                // dd($uniqueGroups);
                return view('conversation_master.summery_index', compact('groupdata','uniqueGroups','screen_permission', 'rows', 'menus', 'screens', 'modules'));
            } catch (\Exception $exc) {
                return $this->sendLog($method, $exc->getCode(), $exc->getMessage(), $exc->getLine(), $exc->getTrace()[0]['args'][2]);
            }
        } else {
            return redirect()->route('not_allow');
        }
    }

}
