<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;


class MasterPaymentController extends BaseController
{

    public function index(Request $request)
    {

        $method = 'Method => MasterPaymentController => index';
        try {
            $rows = DB::select("SELECT ppm.id, ppft.name AS fee_type, ppc.name AS category, final_amount, school_enrollment_id as school_id FROM payment_process_masters as ppm 
                    INNER JOIN payment_process_categories ppc ON ppm.category_id = ppc.id
                    INNER JOIN payment_process_fees_types ppft ON ppm.fees_type_id = ppft.id");

            $logs = DB::select("SELECT a.payment_process_id , a.created_at, b.name, a.description, a.amount FROM payment_process_master_log AS a INNER JOIN users AS b ON a.created_by = b.id ORDER BY a.log_id DESC");
            $school = DB::select("SELECT * FROM schools_registration");
            $response = [
                'rows' => $rows,
                'logs' => $logs,
                'school' => $school
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
            $method = 'Method => MasterPaymentController => createdata';


            $rows = DB::select("SELECT * FROM schools_registration WHERE id NOT IN (SELECT school_enrollment_id FROM payment_process_masters 
            GROUP BY school_enrollment_id HAVING COUNT(school_enrollment_id) > 1 );");
            
            $serviceMaster = DB::select("select * from payment_services_master where active_flag = 0");

            $response = [
                'rows' =>  $rows,
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


    public function storedata(Request $request)
    {
        try {
            $method = 'Method => MasterPaymentController => storedata';
            $validatedData = $this->decryptData($request->requestData);

            $paymentMasterId = DB::transaction(function () use ($validatedData) {

                $paymentMasterId = DB::table('payment_process_masters')->insertGetId([
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

                for ($i = 0; $i < count($validatedData['serviceBriefing']); $i++) {
                    if ($validatedData['serviceBriefing'][$i] != null) {
                        DB::table('payment_process_services')->insert([
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

                // if ($validatedData['taxNames'] != null) {
                //     for ($j = 0; $j < count($validatedData['taxNames']); $j++) {
                //         if ($validatedData['taxNames'][$j] != null) {
                //             DB::table('payment_process_taxes')->insert([
                //                 'payment_process_master_id' => $paymentMasterId,
                //                 'tax_name' => $validatedData['taxNames'][$j],
                //                 'tax_percentage' => $validatedData['additionalTaxes'][$j],
                //                 'created_at' => now(),
                //                 'updated_at' => now(),
                //             ]);
                //         }
                //     }
                // }

                $this->insertPaymentProcessLog($paymentMasterId, $validatedData['finalAmount'], 'Create');

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

    public function data_edit(Request $request)
    {

        try {

            $method = 'Method => MasterPaymentController => show';

            // $id = $this->decryptData($request['id']);
            $inputArray = $this->decryptData($request->requestData);
            $input = [
                'id' => $inputArray['id'],
                'school_id' => $inputArray['school_id']
            ];
            $payment_id = $input['id'];
            $sc_id = $input['school_id'];

            $rows = DB::table('payment_structure')
                ->select('*')
                ->where('id', $payment_id)
                ->get();
            if ($sc_id != '') {
                $school = DB::select("select * from school_enrollment_details where school_enrollment_id=$sc_id ");
            } else {
                $school = '';
            }


            $response = [
                'rows' => $rows,
                'school' => $school
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

                $paymentMasterId = DB::table('payment_process_masters')
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

                DB::select("Delete FROM payment_process_services WHERE payment_process_master_id = " . $validatedData['id']);
                for ($i = 0; $i < count($validatedData['serviceBriefing']); $i++) {
                    if ($validatedData['serviceBriefing'][$i] !== null) {
                        DB::table('payment_process_services')->insert([
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

                $this->insertPaymentProcessLog($validatedData['id'], $validatedData['finalAmount'], 'Update');

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
    public function toggle(Request $request)
    {
        // $this->WriteFileLog($request);
        try {
            $method = 'Method => MasterPaymentController => toggle';
            $inputArray = $this->decryptData($request->requestData);

            $input = [
                'id' => $inputArray['id'],
                'selectedDate' => $inputArray['selectedDate']
            ];
            // $this->WriteFileLog($input);

            // Start database transaction
            $document_sub_types_id = DB::transaction(function () use ($input) {
                // Fetch the current record
                $this->WriteFileLog("sdwed");
                $payment = DB::table('payment_structure')->where('id', $input['id'])->first();
                $feesType = $payment->fees_type; // Retrieve fees_type from the current record
                $this->WriteFileLog($feesType);
                if (!$payment) {
                    throw new \Exception('Payment record not found');
                }
                // Prepare the effective date (assuming selectedDate is the effective date)
                $selectedDate = $input['selectedDate']; // Assuming this is '31-07-2024'
                $effectiveDate = Carbon::now()->format('Y-m-d'); // Format effective date properly
                $formattedSelectedDate = Carbon::createFromFormat('d-m-Y', $selectedDate)->format('Y-m-d'); // Convert selected date to 'Y-m-d' format
                //$feesType = $input['feesType']; // Make sure you have feesType available
                $id = $input['id']; // ID of the record to update

                if ($formattedSelectedDate == $effectiveDate) {
                    // Update the status to 'Active'
                    DB::table('payment_structure')
                        ->where('id', $id)
                        ->update([
                            'status' => 'Active',
                            'effective_date' => $formattedSelectedDate // Set the effective date
                        ]);
                    $feesType = $payment->fees_type;
                    // Update the previous records with the same fees_type to 'Expired'
                    DB::table('payment_structure')
                        ->where('fees_type', $feesType)
                        ->where('id', '<>', $id) // Exclude the specific ID
                        ->whereNotIn('status', ['Saved', 'Submitted']) // Exclude records with status 'Saved' or 'Submitted'
                        ->update([
                            'status' => 'Expired',
                            'expired_date' => $formattedSelectedDate // Set the effective date
                        ]);
                } else {
                    // Update the status to 'Ready'
                    DB::table('payment_structure')
                        ->where('id', $input['id'])
                        ->update([
                            'status' => 'Ready',
                            'effective_date' => $formattedSelectedDate
                        ]);
                    DB::table('payment_structure')
                        ->where('fees_type', $feesType)
                        ->where('status', 'Active')
                        ->update([
                            'expired_date' => $formattedSelectedDate // Set the effective date
                        ]);
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
    public function hold(Request $request)
    {
        $this->WriteFileLog($request);
        try {
            $method = 'Method => MasterPaymentController => hold';
            $inputArray = $this->decryptData($request->requestData);

            $input = [
                'id' => $inputArray['id'],
                'selectedDate' => $inputArray['selectedDate']
            ];
            $this->WriteFileLog($input);

            // Start database transaction
            $document_sub_types_id = DB::transaction(function () use ($input) {
                // Fetch the current record
                $this->WriteFileLog("sdwed");
                $payment = DB::table('payment_structure')->where('id', $input['id'])->first();
                $feesType = $payment->fees_type; // Retrieve fees_type from the current record
                $this->WriteFileLog($feesType);

                // Prepare the effective date (assuming selectedDate is the effective date)
                $selectedDate = $input['selectedDate']; // Assuming this is '31-07-2024'
                $effectiveDate = Carbon::now()->format('Y-m-d'); // Format effective date properly
                $formattedSelectedDate = Carbon::createFromFormat('d-m-Y', $selectedDate)->format('Y-m-d'); // Convert selected date to 'Y-m-d' format
                //$feesType = $input['feesType']; // Make sure you have feesType available
                $id = $input['id']; // ID of the record to update

                if ($formattedSelectedDate == $effectiveDate) {
                    // Update the status to 'Active'
                    DB::table('payment_structure')
                        ->where('id', $id)
                        ->update([
                            'status' => 'Active',
                            'effective_date' => $formattedSelectedDate // Set the effective date
                        ]);
                    $feesType = $payment->fees_type;
                    // Update the previous records with the same fees_type to 'Expired'
                    DB::table('payment_structure')
                        ->where('fees_type', $feesType)
                        ->where('id', '<>', $id) // Exclude the specific ID
                        ->whereNotIn('status', ['Saved', 'Submitted']) // Exclude records with status 'Saved' or 'Submitted'
                        ->update([
                            'status' => 'Expired',
                            'expired_date' => $formattedSelectedDate // Set the effective date
                        ]);
                } else {
                    // Update the status to 'Ready'
                    DB::table('payment_structure')
                        ->where('id', $input['id'])
                        ->update([
                            'status' => 'Ready',
                            'effective_date' => $formattedSelectedDate
                        ]);
                    DB::table('payment_structure')
                        ->where('fees_type', $feesType)
                        ->where('status', 'Active')
                        ->update([
                            'expired_date' => $formattedSelectedDate // Set the effective date
                        ]);
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
    public function cancel(Request $request)
    {
        $this->WriteFileLog($request);
        try {
            $method = 'Method => MasterPaymentController => cancel';
            $inputArray = $this->decryptData($request->requestData);

            $input = [
                'id' => $inputArray['id'],
            ];
            $this->WriteFileLog($input);

            // Start database transaction
            $document_sub_types_id = DB::transaction(function () use ($input) {
                // Fetch the current record
                $this->WriteFileLog("sdwed");

                $id = $input['id']; // ID of the record to update

                // Update the status to 'Active'
                DB::table('payment_structure')
                    ->where('id', $id)
                    ->update([
                        'status' => 'Submitted',
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


    public function updateGoogleEvent()
    {
        $this->WriteFileLog("ASdae");
        // Get the current date for comparison
        $currentDate = Carbon::now()->format('Y-m-d');

        // Retrieve all records with status 'Ready'
        $details = DB::table('payment_structure')
            ->where('status', 'Ready')
            ->get();

        foreach ($details as $row) {
            $id = $row->id;
            $feesType = $row->fees_type;
            $effectiveDate = Carbon::parse($row->effective_date)->format('Y-m-d');

            // Prepare the effective date
            $formattedSelectedDate = Carbon::now()->format('Y-m-d'); // Assuming selectedDate should be current date

            if ($formattedSelectedDate === $currentDate) {
                // Update the current record to 'Active'
                DB::table('payment_structure')
                    ->where('id', $id)
                    ->update([
                        'status' => 'Active',
                        'effective_date' => $formattedSelectedDate,
                    ]);

                // Update previous records with the same fees_type to 'Expired'
                DB::table('payment_structure')
                    ->where('fees_type', $feesType)
                    ->where('id', '<>', $id) // Exclude the current record
                    ->where('status', 'Active') // Only affect currently 'Active' records
                    ->update([
                        'status' => 'Expired',
                        'expired_date' => $formattedSelectedDate,
                    ]);
            } else {
                // Update the status to 'Ready'
                DB::table('payment_structure')
                    ->where('id', $id)
                    ->update([
                        'status' => 'Ready',
                        'effective_date' => $formattedSelectedDate,
                    ]);

                // Update records with status 'Active' for the same fees_type
                DB::table('payment_structure')
                    ->where('fees_type', $feesType)
                    ->where('status', 'Active')
                    ->update([
                        'expired_date' => $formattedSelectedDate,
                    ]);
            }
        }
    }

    public function insertPaymentProcessLog($paymentProcessId, $finalAmount, $status, $effectiveFrom = null)
    {

        // The payment was updated by the admin

        $role_name = DB::select("SELECT role_name , us.name FROM uam_roles AS ur INNER JOIN users us ON (us.array_roles=ur.role_id) WHERE us.id=" . auth()->user()->id);
        $role_name_fetch = $role_name[0]->role_name;
        $role_name = $role_name[0]->name;
        $text = 'Payment has been ' . $status . ' by the ' . $role_name;

        return DB::table('payment_process_master_log')->insert([
            'payment_process_id' => $paymentProcessId,
            'created_by' => auth()->user()->id,
            'effective_from' => $effectiveFrom,
            'description' => $text,
            'amount' => $finalAmount
        ]);
    }
}
