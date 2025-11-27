<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AssessmentMapping extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $method = 'Method => AssessmentMapping => index';
        $gatewayURL = config('setting.api_gateway_url') . '/assessment/mapping/index';
        $response = $this->serviceRequest($gatewayURL, 'GET', '', $method);
        $response = json_decode($response);
        $objData = json_decode($this->decryptData($response->Data));
        $rows = json_decode(json_encode($objData->Data), true);
        $rows = $rows['rows'];

        $menus = $this->FillMenu();
        $screens = $menus['screens'];
        $modules = $menus['modules'];
        return view('assessment_mapping.index', compact('modules', 'screens', 'rows'));
        //
        //  dd('index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        try {
            $method = 'Method => AssessmentMapping => create';
            $gatewayURL = config('setting.api_gateway_url') . '/assessment/mapping/create';
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
                    return view('assessment_mapping.create', compact('rows', 'screens', 'modules'));
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
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function GetDetails(Request $request)
    {
        try {
            $method = 'Method => UserregisterfeeController => GetDetails';
            $assessment_skill = $request->assessment_skill;

            $request = array();
            $request['requestData'] = $assessment_skill;

            $gatewayURL = config('setting.api_gateway_url') . '/assessment/skill/getdetails';
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

    public function NewAssesmentSkill(Request $request)
    {
        $method = 'Method => AssessmentMapping => NewAssesmentSkill';
        // $this->WriteFileLog($method);
        try {
            $data = array();
            $data['performanceAreaId'] = $request->performanceAreaId;
            $data['skillId'] = $request->skillId;
            $data['typedName'] = $request->typedName;
            // Forward subSkillId when adding sub-skill activities
            if ($request->has('subSkillId')) {
                $data['subSkillId'] = $request->subSkillId;
            }
            $encryptArray = $this->encryptData($data);

            $request = array();
            $request['requestData'] = $encryptArray;
            $gatewayURL = config('setting.api_gateway_url') . '/store/new/assessment/skill';
            // $this->WriteFileLog($gatewayURL);
            $response = $this->serviceRequest($gatewayURL, 'Post', json_encode($request), $method);
            $response = json_decode($response);

            if ($response->Status == 200 && $response->Success) {
                $objData = json_decode($this->decryptData($response->Data));

                if ($objData->Code == 200) {
                    $parant_data = json_decode(json_encode($objData->Data), true);
                    // $this->WriteFileLog($parant_data);
                    return $parant_data;
                    echo json_encode($parant_data);
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
