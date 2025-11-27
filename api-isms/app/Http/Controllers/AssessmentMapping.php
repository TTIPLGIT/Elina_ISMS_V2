<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AssessmentMapping extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        try {
            $method = 'Method => activityInitiationController => createdata';
            $rows = DB::select("select * from assessment_skill");

            $response = [
                'rows' => $rows,
            ];


            $serviceResponse = array();
            $serviceResponse['Code'] = config('setting.status_code.success');
            $serviceResponse['Message'] = config('setting.status_message.success');
            $serviceResponse['Data'] = $response;
            $serviceResponse = json_encode($serviceResponse, JSON_FORCE_OBJECT);
            $sendServiceResponse = $this->SendServiceResponse($serviceResponse, config('setting.status_code.success'), true);
            return $sendServiceResponse;
        } catch (\Exception $exc) {
            $exceptionResponse = array();
            $exceptionResponse['ServiceMethod'] = $method;
            $exceptionResponse['Exception'] = $exc->getMessage();
            $exceptionResponse = json_encode($exceptionResponse, JSON_FORCE_OBJECT);
            $this->WriteFileLog($exceptionResponse);
            $serviceResponse = array();
            $serviceResponse['Code'] = config('setting.status_code.exception');
            $serviceResponse['Message'] = $exc->getMessage();
            $serviceResponse = json_encode($serviceResponse, JSON_FORCE_OBJECT);
            $sendServiceResponse = $this->SendServiceResponse($serviceResponse, config('setting.status_code.exception'), false);
            return $sendServiceResponse;
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
            $logMethod = 'Method => UserregisterfeeController => GetDetails';
            $inputArray = $request->requestData;

            $skill = DB::select("SELECT * FROM performance_skill_activity WHERE performance_area_id = '$inputArray'");
            $activity = DB::select("SELECT * FROM activity WHERE active_flag = 0");

            $response = [
                'skill' => $skill,
                'activity' => $activity
            ];
            $serviceResponse = array();
            $serviceResponse['Code'] = config('setting.status_code.success');
            $serviceResponse['Message'] = config('setting.status_message.success');
            $serviceResponse['Data'] =  $response;
            $serviceResponse = json_encode($serviceResponse, JSON_FORCE_OBJECT);
            $sendServiceResponse = $this->SendServiceResponse($serviceResponse, config('setting.status_code.success'), true);
            return $sendServiceResponse;
        } catch (\Exception $exc) {
            $exceptionResponse = array();
            $exceptionResponse['ServiceMethod'] = $logMethod;
            $exceptionResponse['Exception'] = $exc->getMessage();
            $exceptionResponse = json_encode($exceptionResponse, JSON_FORCE_OBJECT);
            $this->WriteFileLog($exceptionResponse);
            $serviceResponse = array();
            $serviceResponse['Code'] = config('setting.status_code.exception');
            $serviceResponse['Message'] = $exc->getMessage();
            $serviceResponse = json_encode($serviceResponse, JSON_FORCE_OBJECT);
            $sendServiceResponse = $this->SendServiceResponse($serviceResponse, config('setting.status_code.exception'), false);
            return $sendServiceResponse;
        }
    }

    public function NewAssesmentSkill(Request $request)
    {
        try {
            $method = 'Method => AssessmentMapping => API => NewAssesmentSkill';

            $inputArray = $this->DecryptData($request->requestData);
            $input = [
                'performanceAreaId' => $inputArray['performanceAreaId'],
                'activityName' => $inputArray['typedName'],
                'skillId' => $inputArray['skillId'],
                'subSkillId' => $inputArray['subSkillId'] ?? null
            ];

            $activityID = DB::transaction(function () use ($input) {
                // 
                $subSkill = $input['subSkillId'] ?? null;
                if ($subSkill !== null) {
                    $primarySkillIds = DB::table('performance_sub_skill')
                                        ->where('skill_id', $subSkill)
                                        ->pluck('primary_skill_id');
                    
                    $primarySkillIds = $primarySkillIds->first() ?? $input['skillId'];

                } else {
                    $primarySkillIds = null;
                }
                
                $primarySkillId = $primarySkillIds ?? $input['skillId']; 
                // DB::table('performance_skill_activity')->updateOrInsert(
                //     ['performance_area_id' => $input['performanceAreaId'], 'skill_id' => $input['skillId']], 
                //     [
                //         'sub_skill' => $subSkill,
                //         'performance_area_id' => $input['performanceAreaId'], 
                //         'skill_id' => $input['skillId'],
                //         'activity_name' => $input['activityName'],
                //     ]
                // );

                // $arrayRoles = is_array(auth()->user()->array_roles) ? auth()->user()->array_roles : [];
                // $roles = is_array(auth()->user()->roles) ? auth()->user()->roles : [];
                // $rolesArray = array_merge($arrayRoles, $roles);
                // $isVerified = in_array(4, $rolesArray) ? "1" : "0";

                $isVerified = (auth()->user()->array_roles === '4') ? "0" : "1";

                $activityID = DB::table('performance_skill_activity')->insertGetId([
                    'sub_skill' => $subSkill,
                    'performance_area_id' => $input['performanceAreaId'],
                    'skill_id' => $primarySkillId, //$input['skillId'],
                    'activity_name' => $input['activityName'],
                    'isVerified' => $isVerified,
                ]);

                return $activityID;

            });

            $serviceResponse = array();
            $serviceResponse['Code'] = config('setting.status_code.success');
            $serviceResponse['Message'] = config('setting.status_message.success');
            $serviceResponse['Data'] = $activityID;
            $serviceResponse = json_encode($serviceResponse, JSON_FORCE_OBJECT);
            $sendServiceResponse = $this->SendServiceResponse($serviceResponse, config('setting.status_code.success'), true);
            return $sendServiceResponse;
        } catch (\Exception $exc) {
            $exceptionResponse = array();
            $exceptionResponse['ServiceMethod'] = $method;
            $exceptionResponse['Exception'] = $exc->getMessage();
            $exceptionResponse = json_encode($exceptionResponse, JSON_FORCE_OBJECT);
            $this->WriteFileLog($exceptionResponse);
            $serviceResponse = array();
            $serviceResponse['Code'] = config('setting.status_code.exception');
            $serviceResponse['Message'] = $exc->getMessage();
            $serviceResponse = json_encode($serviceResponse, JSON_FORCE_OBJECT);
            $sendServiceResponse = $this->SendServiceResponse($serviceResponse, config('setting.status_code.exception'), false);
            return $sendServiceResponse;
        }
    }
}
