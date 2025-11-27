<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PerformanceAreaController extends BaseController
{
    public function get_data()
    {
    }

    public function create()
    {
        try {
            $method = 'Method => PerformanceAreaController => createdata';

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

    public function store_date(Request $request)
    {
        try {
            $method = 'Method => UserregisterfeeController => sailstoredata';
            $inputArray = $this->decryptData($request->requestData);
            $input = [
                'performance_area' => $inputArray['performance_area'],
                'skill_name' => $inputArray['skill_name'],
                'activity' => $inputArray['activity'],
                'observation' => $inputArray['observation'],
                'sub_skill_name' => $inputArray['sub_skill_name'],
                'sub_activity' => $inputArray['sub_activity'],
                'sub_observation' => $inputArray['sub_observation'],
            ];


            DB::transaction(function () use ($input) {
                $skill_name = $input['skill_name'];
                $skill_count = count($skill_name);

                for ($i = 0; $i < $skill_count; $i++) {
                    $index = 'row'.($i+1);
                    $skill_id = DB::table('performance_skill')->insertGetId([
                        'performance_area_id' => $input['performance_area'],
                        'skill_name' => $input['skill_name'][$index],
                    ]);

                    $loopactivity = $input['activity'][$index];
                    $loopactivityCount = count($loopactivity);
                    for ($j = 0; $j < $loopactivityCount; $j++) {
                        $activity_id = DB::table('performance_skill_activity')->insertGetId([
                            'performance_area_id' => $input['performance_area'],
                            // 'skill_name' => $input['skill_name'][$index],
                            'activity_name' => $loopactivity[$j],
                            'skill_id' => $skill_id,
                        ]);
                    }

                    $loopobservation = $input['observation'][$index];
                    $loopobservationCount = count($loopobservation);
                    for($k=0;$k<$loopobservationCount;$k++){
                        $observation_id = DB::table('performance_skill_observation')->insertGetId([
                            'performance_area_id' => $input['performance_area'],
                            // 'skill_name' => $input['skill_name'][$index],
                            'observation_name' => $loopobservation[$k],
                            'skill_id' => $skill_id,
                        ]);
                    }
                   

                    // $skill_id = DB::table('performance_skill')->insertGetId([
                    //     'performance_area_id' => $input['performance_area'],
                    //     'skill_name' => $input['skill_name'],
                    // ]);

                    // $skill_id = DB::table('performance_skill')->insertGetId([
                    //     'performance_area_id' => $input['performance_area'],
                    //     'skill_name' => $input['skill_name'],
                    // ]);

                    // $skill_id = DB::table('performance_skill')->insertGetId([
                    //     'performance_area_id' => $input['performance_area'],
                    //     'skill_name' => $input['skill_name'],
                    // ]);

                    // $skill_id = DB::table('performance_skill')->insertGetId([
                    //     'performance_area_id' => $input['performance_area'],
                    //     'skill_name' => $input['skill_name'],
                    // ]);
                }


                // $this->auditLog('payment_status_details', $screen_permission_id, 'create', 'create a new Payment', $authID, NOW(), 'payment initiated');

            });

            $serviceResponse = array();
            $serviceResponse['Code'] = config('setting.status_code.success');
            $serviceResponse['Message'] = config('setting.status_message.success');
            $serviceResponse['Data'] = 1;
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
