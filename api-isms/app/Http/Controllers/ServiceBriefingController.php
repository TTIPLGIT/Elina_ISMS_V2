<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;


class ServiceBriefingController extends BaseController
{

    public function index(Request $request)
    {

        $method = 'Method => ServiceBriefingController => index';
        try {

            $serviceList = DB::select("SELECT * FROM payment_services_master WHERE active_flag = 0");

            $response = [
                'serviceList' => $serviceList
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
    public function create(Request $request)
    {

        $method = 'Method => ServiceBriefingController => create';
        try {

            $serviceList = DB::select("SELECT * FROM payment_services_master WHERE active_flag = 0");

            $response = [
                'serviceList' => $serviceList
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
            $method = 'Method => ServiceBriefingController => storedata';
            $validatedData = $this->decryptData($request->requestData);
            $userId = Auth::id();
            $input = [];
            $input['service_briefing'] = $validatedData['service_briefing'];
            $input['amount'] = $validatedData['amount'];
            $this->WriteFileLog($input);
            DB::table('payment_services_master')->insert([
                'service_briefing' => $validatedData['service_briefing'],
                'amount'          => $validatedData['amount'],
                'created_by'      => $userId,
                'created_at'      => now(),
                'active_flag'     => 0
            ]);
            $response = [
                'message' => 'Service Briefing created successfully'
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
    public function show(Request $request)
    {
        try {

            $method = 'Method => MasterPaymentController => show';

            $inputArray = $this->decryptData($request->requestData);

            $payment_id = $inputArray['id'];

            $rows = DB::table('payment_process_masters as ppm')
                ->join('payment_process_categories as ppc', 'ppm.category_id', '=', 'ppc.id')
                ->join('payment_process_fees_types as ppft', 'ppm.fees_type_id', '=', 'ppft.id')
                ->select('ppm.*')
                // ->select('ppm.id', 'ppft.name as fee_type', 'ppc.name as category', 'ppm.final_amount')
                ->where('ppm.id', $payment_id)
                ->first();

            $schoolists = DB::select("select * from schools_registration");
            $serviceList = DB::select("SELECT * FROM payment_process_services WHERE payment_process_master_id = $payment_id");
            $taxList = DB::select("SELECT * FROM payment_process_taxes WHERE payment_process_master_id = $payment_id");

            $serviceMaster = DB::select("select * from payment_services_master where active_flag = 0");

            $response = [
                'rows' => $rows,
                'schoolists' => $schoolists,
                'serviceList' => $serviceList,
                'taxList' => $taxList,
                'serviceMaster' => $serviceMaster
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
            $this->WriteFileLog($id);
            $method = 'Method => ServiceBriefingController => data_edit';

            $id = $this->decryptData($id);

            $data_show = DB::table('payment_services_master')
                ->where('id', $id)
                ->first();

            $serviceResponse = [];
            $serviceResponse['Code'] = config('setting.status_code.success');
            $serviceResponse['Message'] = config('setting.status_message.success');
            $serviceResponse['Data'] = $data_show;

            $serviceResponse = json_encode($serviceResponse, JSON_FORCE_OBJECT);

            return $this->SendServiceResponse(
                $serviceResponse,
                config('setting.status_code.success'),
                true
            );
        } catch (\Exception $exc) {

            $exceptionResponse = [];
            $exceptionResponse['ServiceMethod'] = $method;
            $exceptionResponse['Exception'] = $exc->getMessage();
            $this->WriteFileLog(json_encode($exceptionResponse));

            $serviceResponse = [];
            $serviceResponse['Code'] = config('setting.status_code.exception');
            $serviceResponse['Message'] = $exc->getMessage();

            return $this->SendServiceResponse(
                json_encode($serviceResponse),
                config('setting.status_code.exception'),
                false
            );
        }
    }

    public function data_delete($id)
    {
        try {

            $method = 'Method =>ServiceBriefingController => data_delete';
            $id = $this->decryptData($id);
            $userId = Auth::id();
            $this->WriteFileLog($id);

            DB::table('payment_services_master')
                ->where('id', $id)
                ->update(['active_flag' => 1, 'updated_by' => $userId, 'updated_at' => now()]);

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
    public function data_update($id)
    {
        try {

            $method = 'Method =>ServiceBriefingController => data_delete';
            $id = $this->decryptData($id);
            $userId = Auth::id();

            $data_show = DB::table('payment_services_master')
                ->where('id', $id)
                ->first();


            $serviceResponse = array();
            $serviceResponse['Code'] = config('setting.status_code.success');
            $serviceResponse['Message'] = config('setting.status_message.success');
            $serviceResponse['Data'] = $data_show;
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
            $method = 'Method => ServiceBriefingController => updatedata';

            $validatedData = $this->decryptData($request->requestData);
            $userId = Auth::id();

            DB::table('payment_services_master')
                ->where('id', $validatedData['id'])
                ->update([
                    'service_briefing' => $validatedData['service_briefing'],
                    'amount'          => $validatedData['amount'],
                    'updated_by'      => $userId,
                    'updated_at'      => now()
                ]);

            $response = [
                'message' => 'Service Briefing updated successfully'
            ];

            $serviceResponse = [];
            $serviceResponse['Code'] = config('setting.status_code.success');
            $serviceResponse['Message'] = config('setting.status_message.success');
            $serviceResponse['Data'] = $response;

            return $this->SendServiceResponse(
                json_encode($serviceResponse, JSON_FORCE_OBJECT),
                config('setting.status_code.success'),
                true
            );
        } catch (\Exception $exc) {

            $exceptionResponse = [];
            $exceptionResponse['ServiceMethod'] = $method;
            $exceptionResponse['Exception'] = $exc->getMessage();
            $this->WriteFileLog(json_encode($exceptionResponse));

            $serviceResponse = [];
            $serviceResponse['Code'] = config('setting.status_code.exception');
            $serviceResponse['Message'] = $exc->getMessage();

            return $this->SendServiceResponse(
                json_encode($serviceResponse, JSON_FORCE_OBJECT),
                config('setting.status_code.exception'),
                false
            );
        }
    }
}
