<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class CustomizedPaymentAPIController extends BaseController
{
    public function index(Request $request)
    {
        $method = 'Method => CustomizedPaymentAPIController => index';
        try {
            $rows = DB::select("SELECT ppc.id, ed.child_name, ed.enrollment_id, ed.enrollment_child_num, ppcs.name AS category_name, 
            ppft.name AS fee_type FROM payment_process_customized AS ppc 
            INNER JOIN enrollment_details AS ed ON ed.enrollment_id = ppc.enrollment_id
            INNER JOIN payment_process_categories AS ppcs ON ppcs.id = ppc.category_id
            INNER JOIN payment_process_fees_types AS ppft ON ppft.id = ppc.fees_type_id
            WHERE ed.enrollment_child_num NOT IN (SELECT enrollment_id FROM sail_details WHERE consent_aggrement = 'Agreed');");

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
    public function create(Request $request)
    {
        try {

            $method = 'Method => MasterPaymentController => show';

            $payment_id = 10;

            $childDetails = DB::select("SELECT enrollment_id , enrollment_child_num, child_name FROM enrollment_details WHERE STATUS = 'Submitted'  AND 
            enrollment_child_num NOT IN (SELECT enrollment_id FROM sail_details)");

            $rows = DB::table('payment_process_masters as ppm')
                ->join('payment_process_categories as ppc', 'ppm.category_id', '=', 'ppc.id')
                ->join('payment_process_fees_types as ppft', 'ppm.fees_type_id', '=', 'ppft.id')
                ->select('ppm.*')
                ->where('ppm.id', $payment_id)
                ->first();

            $schoolists = DB::select("select * from schools_registration");
            $serviceList = DB::select("SELECT * FROM payment_process_services WHERE payment_process_master_id = $payment_id");
            $taxList = DB::select("SELECT * FROM payment_process_taxes WHERE payment_process_master_id = $payment_id");

            $response = [
                'rows' => $rows,
                'schoolists' => $schoolists,
                'serviceList' => $serviceList,
                'taxList' => $taxList,
                'childDetails' => $childDetails
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
            $method = 'Method => MasterPaymentController => storedata';
            $validatedData = $this->decryptData($request->requestData);

            $paymentMasterId = DB::transaction(function () use ($validatedData) {

                $paymentMasterId = DB::table('payment_process_customized')->insertGetId([
                    'category_id' => $validatedData['category_id'],
                    'enrollment_id' => $validatedData['child_enrollment'],
                    'school_enrollment_id' => $validatedData['school_enrollment_id'],
                    'fees_type_id' => $validatedData['fees_type_id'],
                    'base_amount' => $validatedData['base_amount'],
                    'gst_rate' => $validatedData['gstRate'],
                    'final_amount' => $validatedData['finalAmount'],
                    'status' => $validatedData['status'],
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);

                for ($i = 0; $i < count($validatedData['serviceBriefing']); $i++) {
                    if ($validatedData['serviceBriefing'][$i] != null) {
                        DB::table('payment_process_services_customized')->insert([
                            'payment_process_master_id' => $paymentMasterId,
                            'service_briefing' => $validatedData['serviceBriefing'][$i],
                            'quantity' => $validatedData['qty'][$i],
                            'rate' => $validatedData['rate'][$i],
                            'amount' => $validatedData['amount'][$i],
                            'created_at' => now(),
                            'updated_at' => now(),
                        ]);
                    }
                }

                // if($validatedData['taxNames'] != null) {
                //     for ($j = 0; $j < count($validatedData['taxNames']); $j++) {
                //         DB::table('payment_process_taxes')->insert([
                //             'payment_process_master_id' => $paymentMasterId,
                //             'tax_name' => $validatedData['taxNames'][$j], 
                //             'tax_percentage' => $validatedData['additionalTaxes'][$j],
                //             'created_at' => now(),
                //             'updated_at' => now(),
                //         ]);
                //     }
                // }

                // $this->insertPaymentProcessLog($paymentMasterId , $validatedData['finalAmount'], 'Create');

                return $paymentMasterId;
            });

            $serviceResponse = array();
            $serviceResponse['Code'] = config('setting.status_code.success');
            $serviceResponse['Message'] = config('setting.status_message.success');
            $serviceResponse['Data'] = $paymentMasterId;
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

    public function getdata(Request $request)
    {
        try {

            $method = 'Method => MasterPaymentController => getdata';

            $inputArray = $this->decryptData($request->requestData);

            $payment_id = $inputArray['id'];

            $rows = DB::table('payment_process_customized as ppm')
                ->join('payment_process_categories as ppc', 'ppm.category_id', '=', 'ppc.id')
                ->join('payment_process_fees_types as ppft', 'ppm.fees_type_id', '=', 'ppft.id')
                ->select('ppm.*')
                // ->select('ppm.id', 'ppft.name as fee_type', 'ppc.name as category', 'ppm.final_amount')
                ->where('ppm.id', $payment_id)
                ->first();

            $enrollment_id = $rows->enrollment_id;

            $childDetails = DB::select("SELECT enrollment_id , enrollment_child_num, child_name, category_id FROM enrollment_details WHERE STATUS = 'Submitted' and enrollment_id = " . $enrollment_id);

            $schoolists = DB::select("select * from schools_registration");
            $serviceList = DB::select("SELECT * FROM payment_process_services_customized WHERE payment_process_master_id = $payment_id");
            $taxList = DB::select("SELECT * FROM payment_process_taxes WHERE payment_process_master_id = $payment_id");

            $response = [
                'rows' => $rows,
                'schoolists' => $schoolists,
                'serviceList' => $serviceList,
                'taxList' => $taxList,
                'childDetails' => $childDetails
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
            $method = 'Method => MasterPaymentController => updatedata';
            $validatedData = $this->decryptData($request->requestData);

            $paymentMasterId = DB::transaction(function () use ($validatedData) {

                $paymentMasterId = DB::table('payment_process_customized')
                    ->where('id', $validatedData['id'])
                    ->update([
                        'category_id' => $validatedData['category_id'],
                        'school_enrollment_id' => $validatedData['school_enrollment_id'],
                        'fees_type_id' => $validatedData['fees_type_id'],
                        'base_amount' => $validatedData['base_amount'],
                        'gst_rate' => $validatedData['gstRate'],
                        'final_amount' => $validatedData['finalAmount'],
                        'status' => $validatedData['status'],
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);

                DB::select("Delete FROM payment_process_services_customized WHERE payment_process_master_id = " . $validatedData['id']);
                for ($i = 0; $i < count($validatedData['serviceBriefing']); $i++) {
                    if ($validatedData['serviceBriefing'][$i] !== null) {
                        DB::table('payment_process_services_customized')->insert([
                            'payment_process_master_id' => $validatedData['id'],
                            'service_briefing' => $validatedData['serviceBriefing'][$i],
                            'quantity' => $validatedData['qty'][$i],
                            'rate' => $validatedData['rate'][$i],
                            'amount' => $validatedData['amount'][$i],
                            'created_at' => now(),
                            'updated_at' => now(),
                        ]);
                    }
                }

                DB::select("Delete FROM payment_process_taxes WHERE payment_process_master_id = " . $validatedData['id']);
                if ($validatedData['taxNames'] != null) {
                    for ($j = 0; $j < count($validatedData['taxNames']); $j++) {
                        if ($validatedData['taxNames'][$j] !== null) {
                            DB::table('payment_process_taxes')->insert([
                                'payment_process_master_id' => $validatedData['id'],
                                'tax_name' => $validatedData['taxNames'][$j],
                                'tax_percentage' => $validatedData['additionalTaxes'][$j],
                                'created_at' => now(),
                                'updated_at' => now(),
                            ]);
                        }
                    }
                }

                // $this->insertPaymentProcessLog($validatedData['id'], $validatedData['finalAmount'], 'Update');

                return $validatedData['id'];
            });

            $serviceResponse = array();
            $serviceResponse['Code'] = config('setting.status_code.success');
            $serviceResponse['Message'] = config('setting.status_message.success');
            $serviceResponse['Data'] = $paymentMasterId;
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
