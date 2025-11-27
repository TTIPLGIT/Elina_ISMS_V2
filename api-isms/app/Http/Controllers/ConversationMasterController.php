<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ConversationMasterController extends BaseController
{
    public function getdata(Request $request, $id)
    {
        try {

            $method = 'Method => ConversationMasterController => getdata';
            $rows = DB::select("SELECT * FROM conversation_questions WHERE type_id = $id");
            $group = DB::select("SELECT * FROM conversation_summery_groups WHERE active_flag = 1");
            $response = [
                'rows' => $rows,
                'group' => $group,
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

    public function store_data(Request $request)
    {
        try {
            $method = 'Method => ConversationMasterController => store_data';
            // $this->WriteFileLog($method);
            $inputArray = $this->DecryptData($request->requestData);
            $column_type = DB::transaction(function () use ($inputArray) {

                $question_details = DB::select("SELECT * FROM conversation_questions ORDER BY id DESC ");
                $metadata_client_field_name = ($question_details == null) ? 'conversation_001' : ++$question_details[0]->question_column_name;
                $table_name = ($inputArray['type_id'] == 2) ? 'ovm_conversation_feedback' : 'ovm_g2form_feedback';
                $column_type = "ALTER TABLE $table_name ADD $metadata_client_field_name text";
                

                DB::table('conversation_questions')
                    ->insertGetId([
                        'type_id' => $inputArray['type_id'],
                        'group_id' => $inputArray['group'],
                        'question' => $inputArray['question'],
                        'question_description' => $inputArray['description'],
                        'prefilled_data' => $inputArray['prefilled_data'],
                        'required' => $inputArray['required'],
                        'additional_question_check' => $inputArray['additional_question_check'],
                        'additional_question_data' => $inputArray['additional_question_data'],
                        'question_column_name' => $metadata_client_field_name,
                        'created_date' => NOW(),
                        'created_by' => auth()->user()->id,
                        'version' => 2,
                    ]);

                    return $column_type;
            });

            DB::unprepared($column_type);

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

    public function update_data(Request $request)
    {
        try {
            $method = 'Method => ConversationMasterController => update_data';
            // $this->WriteFileLog($method);
            $inputArray = $this->DecryptData($request->requestData);
            DB::transaction(function () use ($inputArray) {
                DB::table('conversation_questions')
                    ->where('id', $inputArray['id'])
                    ->update([
                        'group_id' => $inputArray['group'],
                        'question' => $inputArray['question'],
                        'question_description' => $inputArray['description'],
                        'prefilled_data' => $inputArray['prefilled_data'],
                        'required' => $inputArray['required'],
                        'additional_question_check' => $inputArray['additional_question_check'],
                        'additional_question_data' => $inputArray['additional_question_data'],
                        'created_date' => NOW(),
                        'created_by' => auth()->user()->id,
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
