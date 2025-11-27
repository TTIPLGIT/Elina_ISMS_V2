<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use Illuminate\Support\Facades\DB;


class QuestinnaireMasterCreation extends BaseController
{

    public function get_data(Request $request)
    {

        $method = 'Method => QuestinnaireMasterCreation => get_data';
        try {
            $rows = DB::select('SELECT * FROM questionnaire WHERE active_flag = 0');

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

    public function storedata(Request $request)
    {
        try {
            $method = 'Method => QuestinnaireMasterCreation => storedata';
            $inputArray = $this->decryptData($request->requestData);

            $input = [
                'questionnaire_name' => $inputArray['questionnaire_name'],
                'questionnaire_description' => $inputArray['questionnaire_description'],
                'tableName' => $inputArray['tableName'],
                'questionnaire_type' => $inputArray['questionnaire_type'],

                'is_active' => $inputArray['is_active'],
                'option' => $inputArray['option'],
                'value' => $inputArray['value'],
                'quadrant' => $inputArray['quadrant'],
                'category' => $inputArray['category'],
            ];

            $newTable = $input['tableName'];
            $newTable = preg_replace('/[^A-Za-z0-9\-]/', '', $newTable);
            $newTable = $input['questionnaire_type'] . '_' . $newTable;

            $document_sub_types_id = DB::transaction(function () use ($input, $newTable) {

                $questionnaire_id = DB::table('questionnaire')
                    ->insertGetId([
                        'questionnaire_name' => $input['questionnaire_name'],
                        'questionnaire_description' => $input['questionnaire_description'],
                        'table_name' => $newTable,
                        'questionnaire_type' => $input['questionnaire_type'],
                        'created_by' => auth()->user()->id,
                        'created_date' => now(),
                        'active_flag' => 0,
                        'quadrant_flag' => $input['is_active'],
                    ]);

                if ($input['is_active'] == 1) {
                    $options = $input['option'];
                    $values = $input['value'];
                    for ($i = 0; $i < count($options); $i++) {
                        $option = $options[$i];
                        $value = $values[$i];
                        DB::table('quadrant_questionnaire')
                            ->insertGetId([
                                'questionnaire_id' => $questionnaire_id,
                                'option' => $option,
                                'value' => $value,
                                'created_by' => auth()->user()->id,
                                'created_at' => now(),
                                'active_flag' => 0
                            ]);
                    }

                    $quadrant = $input['quadrant'];
                    if (count($quadrant) != 0) {
                        for ($j = 0; $j < count($quadrant); $j++) {
                            if ($quadrant[$j] != null) {
                                DB::table('questionnaire_quadrant_category')
                                    ->insertGetId([
                                        'questionnaire_id' => $questionnaire_id,
                                        'field' => $quadrant[$j],
                                        'type' => 'quadrant',
                                        'type_id' => '1',
                                        'created_by' => auth()->user()->id,
                                        'created_at' => now(),
                                        'active_flag' => 0
                                    ]);
                            }
                        }
                    }

                    $category = $input['category'];
                    if (count($category) != 0) {
                        for ($j = 0; $j < count($category); $j++) {
                            if ($category[$j] != null) {
                                DB::table('questionnaire_quadrant_category')
                                    ->insertGetId([
                                        'questionnaire_id' => $questionnaire_id,
                                        'field' => $category[$j],
                                        'type' => 'category',
                                        'type_id' => '2',
                                        'created_by' => auth()->user()->id,
                                        'created_at' => now(),
                                        'active_flag' => 0
                                    ]);
                            }
                        }
                    }
                }

                return $questionnaire_id;
            });

            $sql = "CREATE TABLE $newTable (
                    question_process_id BIGINT(20) NOT NULL AUTO_INCREMENT, 
                    active_flag INT(11) NULL DEFAULT '1',
                    created_at TIMESTAMP NULL DEFAULT NULL,
                    created_by INT(11) NULL DEFAULT NULL,
                    last_modified_by INT(11) NULL DEFAULT NULL,
                    last_modified_at TIMESTAMP NULL DEFAULT NULL,
                    questionnaire_initiation_id INT(11) NULL DEFAULT NULL,
                    progress_status TEXT NULL DEFAULT NULL COLLATE 'utf8_general_ci',
                    PRIMARY KEY (`question_process_id`) USING BTREE )";

            DB::unprepared($sql);

            $serviceResponse = array();
            $serviceResponse['Code'] = config('setting.status_code.success');
            $serviceResponse['Message'] = config('setting.status_message.success');
            $serviceResponse['Data'] = $document_sub_types_id;
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

            $method = 'Method => QuestinnaireMasterCreation => data_edit';

            $id = $this->decryptData($id);

            $one_rows = DB::table('questionnaire')
                ->select('*')
                ->where('questionnaire_id', $id)
                ->get();

            $fields = DB::table('questionnaire_quadrant_category')
                ->select('*')
                ->where('questionnaire_id', $id)
                ->get();

            $options = DB::table('quadrant_questionnaire')
                ->select('*')
                ->where('questionnaire_id', $id)
                ->get();

            $response = [
                'one_rows' => $one_rows,
                'fields' => $fields,
                'options' => $options,
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
            $method = 'Method => QuestinnaireMasterCreation => updatedata';
            $inputArray = $this->decryptData($request->requestData);
            $input = [
                'questionnaire_name' => $inputArray['questionnaire_name'],
                'questionnaire_id' => $inputArray['questionnaire_id'],
                'questionnaire_description' => $inputArray['questionnaire_description'],
                'questionnaire_type' => $inputArray['questionnaire_type'],

                'is_active' => $inputArray['is_active'],
                'option' => $inputArray['option'],
                'value' => $inputArray['value'],
                'quadrant' => $inputArray['quadrant'],
                'category' => $inputArray['category'],
            ];

            DB::transaction(function () use ($input) {
                $questionnaire_id = $input['questionnaire_id'];

                DB::table('questionnaire')
                    ->where('questionnaire_id', $input['questionnaire_id'])
                    ->update([
                        'questionnaire_name' => $input['questionnaire_name'],
                        'questionnaire_description' => $input['questionnaire_description'],
                        'questionnaire_type' => $input['questionnaire_type'],
                        'last_modified_by' => auth()->user()->id,
                        'last_modified_date' => NOW(),
                        'quadrant_flag' => $input['is_active'],
                    ]);

                if ($input['is_active'] == 1) {
                    $options = $input['option'];
                    $values = $input['value'];

                    DB::table('quadrant_questionnaire')->where('questionnaire_id', $questionnaire_id)->delete();

                    for ($i = 0; $i < count($options); $i++) {
                        $option = $options[$i];
                        $value = $values[$i];
                        DB::table('quadrant_questionnaire')
                            ->insertGetId([
                                'questionnaire_id' => $questionnaire_id,
                                'option' => $option,
                                'value' => $value,
                                'created_by' => auth()->user()->id,
                                'created_at' => now(),
                                'active_flag' => 0
                            ]);
                    }

                    DB::table('questionnaire_quadrant_category')->where('questionnaire_id', $questionnaire_id)->delete();

                    $quadrant = $input['quadrant'];

                    for ($j = 0; $j < count($quadrant); $j++) {
                        if ($quadrant[$j] != null) {
                            DB::table('questionnaire_quadrant_category')
                                ->insertGetId([
                                    'questionnaire_id' => $questionnaire_id,
                                    'field' => $quadrant[$j],
                                    'type' => 'quadrant',
                                    'type_id' => '1',
                                    'created_by' => auth()->user()->id,
                                    'created_at' => now(),
                                    'active_flag' => 0
                                ]);
                        }
                    }

                    $category = $input['category'];
                    for ($j = 0; $j < count($category); $j++) {
                        if ($category[$j] != null) {
                            DB::table('questionnaire_quadrant_category')
                                ->insertGetId([
                                    'questionnaire_id' => $questionnaire_id,
                                    'field' => $category[$j],
                                    'type' => 'category',
                                    'type_id' => '2',
                                    'created_by' => auth()->user()->id,
                                    'created_at' => now(),
                                    'active_flag' => 0
                                ]);
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

    public function data_delete($id)
    {
        try {

            $method = 'Method => QuestinnaireMasterCreation => data_delete';
            $id = $this->decryptData($id);

            DB::transaction(function () use ($id) {
                $uam_modules_id =  DB::table('questionnaire')
                    ->where('questionnaire_id', $id)
                    ->update([
                        'active_flag' => 1,
                        'last_modified_by' => auth()->user()->id,
                        'last_modified_date' => NOW()
                    ]);
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
