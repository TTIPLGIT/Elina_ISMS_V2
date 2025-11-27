<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CalendarController extends BaseController
{
    public function storedata(Request $request)
    {
        try {
            $method = 'Method => CalendarController => storedata';
            $inputArray = $this->DecryptData($request->requestData);
            $input = [
                'date' => $inputArray['date'],
            ];

            $question = DB::table('questionnaire_details')->insertGetId([
                'questionnaire_id' => $input['questionnaire_id'],
                'questionnaire_description' => $input['discription'],
                'no_questions' => $input['no_of_ques'],
                'active_flag' => 1,
                'created_by' => auth()->user()->id,
                'created_date' => NOW()
            ]);

            $serviceResponse = array();
            $serviceResponse['Code'] = config('setting.status_code.success');
            $serviceResponse['Message'] = config('setting.status_message.success');
            $serviceResponse['Data'] = $question;
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
