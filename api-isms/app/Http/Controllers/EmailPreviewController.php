<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EmailPreviewController extends BaseController
{
    public function getdata()
    {
        try {
            $method = 'Method => EmailPreviewController => getdata';
            // $this->WriteFileLog($method);
            $email_preview = DB::select("SELECT * FROM email_preview WHERE active_flag=0");

            $response = [
                'email_preview' => $email_preview,
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
            $method = 'Method => EmailPreviewController => create';
            $rows = DB::select("SELECT * FROM email_preview WHERE active_flag=0");
            $response = [
                'rows' => $rows
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

            $method = 'Method => EmailPreviewController => storedata';
            $inputArray = $this->decryptData($request->requestData);

            $input = [
                'email_screen' => $inputArray['email_screen'],
                'email_subject' => $inputArray['email_subject'],
                'email_description' => $inputArray['email_description'],
            ];

            DB::transaction(function () use ($input) {

                $email_id = DB::table('email_preview')
                    ->insertGetId([
                        'screen' => $input['email_screen'],
                        'email_subject' => $input['email_subject'],
                        'email_body' => $input['email_description'],
                        'created_by' => auth()->user()->id,
                        'created_date' => now()
                    ]);

                $role_name = DB::select("SELECT role_name FROM uam_roles AS ur
                    INNER JOIN users us ON (us.array_roles=ur.role_id) WHERE us.id=" . auth()->user()->id);
                // $this->WriteFileLog($role_name);
                $role_name_fetch = $role_name[0]->role_name;
                $this->auditLog('Email Template', $email_id, 'Create', 'Created New Email Template', auth()->user()->id, NOW(), $role_name_fetch);
            });

            // return $this->sendResponse('Success', 'Uam module update successfully.');

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
    public function data_edit($id)
    {

        $logMethod = 'Method => QuestionCreationController => data_edit';

        try {
            $id = $this->decryptData($id);
            // $this->WriteFileLog($id);
            $email = DB::select("SELECT * FROM email_preview WHERE id = $id");

            $response = [
                'email' => $email,
            ];
            // $this->WriteFileLog($data);
            $serviceResponse = array();
            $serviceResponse['Code'] = config('setting.status_code.success');
            $serviceResponse['Message'] = config('setting.status_message.success');
            $serviceResponse['Data'] = $response;
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
    public function update_data(Request $request)
    {
        $logMethod = 'Method => DocumentProcessReportController => update_data';
        try {
            $inputArray = $this->DecryptData($request->requestData);

            $userID = auth()->user()->id;
            $input = [
                'id' => $inputArray['id'],
                'email_screen' => $inputArray['email_screen'],
                'email_subject' => $inputArray['email_subject'],
                'email_description' => $inputArray['email_description'],
            ];
            DB::transaction(function () use ($input) {

                DB::table('email_preview')
                    ->where('id', $input['id'])
                    ->update([
                        'screen' => $input['email_screen'],
                        'email_subject' => $input['email_subject'],
                        'email_body' => $input['email_description'],
                        'created_by' => auth()->user()->id,
                        'created_date' => now()
                    ]);

                $role_name = DB::select("SELECT role_name FROM uam_roles AS ur
                    INNER JOIN users us ON (us.array_roles=ur.role_id) WHERE us.id=" . auth()->user()->id);
                // $this->WriteFileLog($role_name);
                $role_name_fetch = $role_name[0]->role_name;
                $this->auditLog('Email Template',$input['id'], 'Update', 'Update Email Template', auth()->user()->id, NOW(), $role_name_fetch);
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
    public function data_delete($id)
    {
        try {
            $method = 'Method =>QuestionCreationController => data_delete';
            $id = $this->decryptData($id);
            $check = DB::select("select * from question_details where question_details_id = '$id' and active_flag = '1' ");
            $questionnaire_details_id = $check[0]->questionnaire_details_id;
            if ($check != []) {

                DB::table('question_details')
                    ->where('question_details_id', $id)
                    ->update([
                        'active_flag' => 0,
                    ]);


                $question_detail = DB::select("SELECT * FROM question_details WHERE active_flag=1 and questionnaire_details_id=$questionnaire_details_id");
                $count_question = count($question_detail);
                DB::table('questionnaire_details')
                    ->where('questionnaire_details_id', $questionnaire_details_id)
                    ->update([
                        'question_count' => $count_question
                    ]);

                $serviceResponse = array();
                $serviceResponse['Code'] = config('setting.status_code.success');
                $serviceResponse['Message'] = config('setting.status_message.success');
                $serviceResponse['Data'] = $questionnaire_details_id;
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
