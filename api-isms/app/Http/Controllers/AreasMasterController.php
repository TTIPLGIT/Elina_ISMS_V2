<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use Illuminate\Support\Facades\DB;


class AreasMasterController extends BaseController
{

    public function index(Request $request)
    {

        $method = 'Method => AreasMasterController => index';
        try {
            $rows = DB::select('SELECT * FROM recommendation_detail_areas WHERE status = 0');

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

    public function create()
    {
        try {
            $method = 'Method => AreasMasterController => create';
            $this->WriteFileLog($method);
            // $rows = DB::select("SELECT * FROM questionnaire_details WHERE active_flag=0");
            // $response = [
            //     'rows' => $rows,
            // ];
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

    public function storedata(Request $request)
    {
        try {
            $method = 'Method => AreasMasterController => storedata';
            $inputArray = $this->decryptData($request->requestData);

            $input = [
                'area_name' => $inputArray['Areas_Name'],
                'table_num' => $inputArray['table_num'],
                'recommended_environment' => $inputArray['recommended_environment'],
                'strategies_recommended' => $inputArray['strategies_recommended'],
            ];

            $table_num = $input['table_num'];
            $page_header =  DB::table('recommendation_detail_areas')
                ->insertGetId([
                    'area_name' => $input['area_name'],
                    'table_num' => $input['table_num'],
                    'status' => "New",
                ]);

            if ($table_num == 1) {
                if ($input['recommended_environment'] != '' || $input['recommended_environment'] != null) {
                    foreach ($input['recommended_environment'] as $key => $video_link) {
                        DB::table('recommendation_area_discription')
                            ->insertGetId([
                                'recommendation_detail_area_id' => $page_header,
                                'recommended_environment' => $video_link,
                                'strategies_recommended' => $input['strategies_recommended'][$key],
                                'created_by' => auth()->user()->id,
                                'created_at' => NOW()
                            ]);
                    }
                }
            }

            $response = [
                'page_header' => $page_header,
                // 'discription' => $discription
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

    public function data_edit($id)
    {
        try {
            $method = 'Method => AreasMasterController => data_edit';
            $id = $this->DecryptData($id);$this->WriteFileLog($id);
            $area_edit = DB::table('recommendation_detail_areas')
                ->select('*')
                ->where('recommendation_detail_area_id', $id)
                ->get();
            $table = $area_edit[0]->table_num;
            if ($table == 1) {
                $area_discription = DB::select("SELECT * FROM recommendation_area_discription WHERE recommendation_detail_area_id = '$id'");
            } else {
                $area_discription = '';
            }
            $response = [
                'area_edit' =>  $area_edit,
                'area_discription' => $area_discription
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

    public function updatedata(Request $request)
    {

        try {
            $method = 'Method => AreasMasterController => updatedata';
            $inputArray = $this->decryptData($request->requestData);
            $input = [
                'area_name' => $inputArray['Areas_Name'],
                'table_num' => $inputArray['table_num'],
                'recommendation_detail_area_id' => $inputArray['recommendation_detail_area_id'],
                'recommended_environment' => $inputArray['recommended_environment'],
                'strategies_recommended' => $inputArray['strategies_recommended'],
                'new_recommended_environment' => $inputArray['new_recommended_environment'],
                'new_strategies_recommended' => $inputArray['new_strategies_recommended'],
                'deleteInput' => $inputArray['deleteInput'],
            ];

            DB::transaction(function () use ($input) {
                DB::table('recommendation_detail_areas')
                    ->where('recommendation_detail_area_id', $input['recommendation_detail_area_id'])
                    ->update([
                        'area_name' => $input['area_name'],
                        'table_num' => $input['table_num'],
                        'updated_by' => auth()->user()->id,
                        'updated_at' => NOW()
                    ]);

                $table_num = $input['table_num'];

                if ($table_num == 1) {
                    if ($input['recommended_environment'] != '' || $input['recommended_environment'] != null) {
                        foreach ($input['recommended_environment'] as $key => $video_link) {
                            DB::table('recommendation_area_discription')
                                ->where('recommendation_area_description_id', $key)
                                ->update([
                                    // 'recommendation_detail_area_id' => $input['recommendation_detail_area_id'],
                                    'recommended_environment' => $video_link,
                                    'strategies_recommended' => $input['strategies_recommended'][$key],
                                    'updated_by' => auth()->user()->id,
                                    'updated_at' => NOW()
                                ]);
                        }
                    }

                    if ($input['new_recommended_environment'] != '' || $input['new_recommended_environment'] != null) {
                        foreach ($input['new_recommended_environment'] as $key => $video_link) {
                            DB::table('recommendation_area_discription')
                                ->insertGetId([
                                    'recommendation_detail_area_id' => $input['recommendation_detail_area_id'],
                                    'recommended_environment' => $video_link,
                                    'strategies_recommended' => $input['new_strategies_recommended'][$key],
                                    'created_by' => auth()->user()->id,
                                    'created_at' => NOW()
                                ]);
                        }
                    }

                    if ($input['deleteInput'] != '' || $input['deleteInput'] != null) {
                        foreach ($input['deleteInput'] as $key1 => $value) {
                            DB::table('recommendation_area_discription')->where('recommendation_area_description_id', $value)->delete();
                        }
                    }
                }
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

    public function delete($id)
    {
        try {
            $method = 'Method =>AreasMasterController => delete';
            $id = $this->decryptData($id);
            $check = DB::select("select * from recommendation_detail_areas where recommendation_detail_area_id ='$id' and status = '1' ");

            if ($check == []) {

                DB::table('recommendation_detail_areas')
                    ->where('recommendation_detail_area_id', $id)
                    ->update([
                        'status' => 1,
                    ]);

                $serviceResponse = array();
                $serviceResponse['Code'] = config('setting.status_code.success');
                $serviceResponse['Message'] = config('setting.status_message.success');
                $serviceResponse['Data'] = 1;
                $serviceResponse = json_encode($serviceResponse, JSON_FORCE_OBJECT);
                $sendServiceResponse = $this->SendServiceResponse($serviceResponse, config('setting.status_code.success'), true);
                return $sendServiceResponse;
            } else {

                $serviceResponse = array();
                $serviceResponse['Code'] = 400;
                $serviceResponse['Message'] = config('setting.status_message.success');
                $serviceResponse['Data'] = 1;
                $serviceResponse = json_encode($serviceResponse, JSON_FORCE_OBJECT);
                $sendServiceResponse = $this->SendServiceResponse($serviceResponse, config('setting.status_code.success'), true);
                return $sendServiceResponse;
            }
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
