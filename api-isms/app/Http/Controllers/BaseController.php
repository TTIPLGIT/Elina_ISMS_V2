<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redis;
use App\Googl;
use Illuminate\Support\Facades\View;

class BaseController extends Controller
{
    /**
     * Author: Anbukani
     * Date: 05/06/2021
     * Description: Return encrypted data for success.
     **/
    public function __construct(Request $request)
    {
        if (auth()->user() !== null) {
            $token = $request->header('Authorization');
            $devicecookie = $request->header('x-custome-cookie');

            $token = str_replace('Bearer ', '', $token);
            $token = str_replace(' ', '', $token);

            $userID = auth()->user()->id;
            $get_data = DB::select("SELECT login_time , audit_id , login_token FROM login_audit WHERE user_id=" . $userID . " ORDER BY login_time DESC LIMIT 1");
            if ($get_data != []) {
                $last_token = $get_data[0]->login_token;

                $tk = $this->DecryptData($last_token);

                $last_accessKey = isset($tk['token']) ? $tk['token'] : '';
                $devicecookie1 = isset($tk['hostname']) ? $tk['hostname'] : '';

                $last_accessKey = str_replace(' ', '', $last_accessKey);
                if ($devicecookie != $devicecookie1 && $last_accessKey != '' && trim($token) != trim($last_accessKey)) {
                    abort(403, '403');
                    return view('errors.401');
                }
            }
        } else {
            $serviceResponse = array();
            $serviceResponse['Code'] = config('setting.status_code.unauthenticated');
            $serviceResponse['Message'] = config('setting.status_message.unauthenticated');
            $serviceResponse = json_encode($serviceResponse, JSON_FORCE_OBJECT);
            $sendServiceResponse = $this->SendServiceResponse($serviceResponse, config('setting.status_code.unauthenticated'), false);
            return $sendServiceResponse;
        }
    }
    public function SendServiceResponse($rows, $statusCode, $status)
    {
        try {

            $encryptedData = Crypt::encrypt($rows);
            $serviceResponse = [
                'Success' => $status,
                'Data' => $encryptedData,
                'Status' => $statusCode
            ];
            return response()->json($serviceResponse, 200);
        } catch (\Exception $exc) {
            Log::error('Method => BaseController => SendServiceResponse: [' . $exc->getCode() . '] ' . $exc->getMessage());
            $exceptionResponse = array();
            $exceptionResponse['Code'] = 500;
            $exceptionResponse['Message'] = $exc->getMessage();
            $exceptionResponse = json_encode($exceptionResponse, JSON_FORCE_OBJECT);
            $serviceResponse = [
                'Success' => false,
                'Data' => Crypt::encrypt($exceptionResponse),
                'Status' => 509
            ];
            return response()->json($serviceResponse, 200);
        }
    }


    public function sendnewResponse($id, $stage, $user, $settings, $datacheked, $initiatestage)
    {
        try {
            $response = [
                'Success' => true,
                'id'    => $id,
                'stage' => $stage,
                'user' => $user,
                'settings' => $settings,
                'datacheked' => $datacheked,
                'initiatestage' => $initiatestage,
                'Status' => 200
            ];

            return response()->json($response, 200);
        } catch (\Exception $exc) {
            Log::error('Method => sendResponse: [' . $exc->getCode() . '] "' . $exc->getMessage() . '" on line ' . $exc->getTrace()[0]['line'] . ' of file ' . $exc->getTrace()[0]['file']);
            return $this->sendErrorResponse('Method => BaseController => sendResponse: ' . $exc->getMessage(), 400);
        }
    }



    /**
     * Schema: -
     * Table Name: -
     * Author: Anbukani
     * Date: 24/09/2019
     * Description: Decrypt data.
     */
    public function DecryptData($data)
    {
        try {
            return Crypt::decrypt($data);
        } catch (\Exception $exc) {
            Log::error('Method => BaseController => DecryptData => Decrypt data error =>: [' . $exc->getCode() . '] ' . $exc->getMessage());
            return 'Failure';
        }
    }

    /**
     * Author: Anbukani
     * Date: 16/09/2019
     * Description: Encrypt data.
     */
    public function EncryptData($data)
    {
        try {
            return Crypt::encrypt($data);
        } catch (\Exception $exc) {
            Log::error('Method => BaseController => EncryptData => Encrypt data error =>: [' . $exc->getCode() . '] ' . $exc->getMessage());
            return 'Failure';
        }
    }

    /**
     * Author: Anbukani
     * Date: 04/06/2021
     * Description: Write error in text file.
     **/
    public function WriteFileLog($request)
    {
        try {
            Log::error($request);
        } catch (\Exception $exc) {
            Log::error('Method => BaseController => WriteFileLog => Write log file error =>: [' . $exc->getCode() . '] ' . $exc->getMessage());
        }
    }

    /**
     * Schema: -
     * Table Name: audit_logs
     * Author: Anbukani
     * Date: 24/09/2019
     * Description: Audit log for database table record changes.
     */
    public function AuditLog($tableName, $key, $action, $description, $user, $time, $role_name)
    {
        try {
            DB::table('audit_logs')->insert([
                'audit_table_name' => $tableName,
                'audit_table_id' => $key,
                'audit_action' => $action,
                'description' => $description,
                'user_id' => $user,
                'action_date_time' => $time,
                'role_name' => $role_name
            ]);
        } catch (\Exception $exc) {
            $exceptionResponse = array();
            $exceptionResponse['ServiceMethod'] = 'Method => BaseController => AuditLog';
            $exceptionResponse['Exception'] = $exc->getMessage();
            $exceptionResponse = json_encode($exceptionResponse, JSON_FORCE_OBJECT);
            $this->WriteFileLog($exceptionResponse);
            //return 'Failure';
        }
    }
    public function elina_assessment($enrollment_id, $elina_assessment_status, $elina_assessment_status_code, $description, $user, $time)
    {
        try {
            $id = DB::table('elina_assessment')->insertGetId([
                'enrollment_id' => $enrollment_id,
                'elina_assessment_status' => $elina_assessment_status,
                'elina_assessment_status_code' => $elina_assessment_status_code,
                'description' => $description,
                'created_by' => $user,
                'created_date' => $time,

            ]);
            // $this->WriteFileLog('asmnt0');
            // $this->WriteFileLog($enrollment_id);
            return $id;
        } catch (\Exception $exc) {
            $exceptionResponse = array();
            $exceptionResponse['ServiceMethod'] = 'Method => BaseController => AuditLog';
            $exceptionResponse['Exception'] = $exc->getMessage();
            $exceptionResponse = json_encode($exceptionResponse, JSON_FORCE_OBJECT);
            $this->WriteFileLog($exceptionResponse);
            //return 'Failure';
        }
    }
    public function elina_assessment_process($enrollment_id, $elina_assessment_status,  $elina_assessment_status_code, $description, $user, $time)
    {
        try {
            // $elina_assessment_process = DB::table('elina_assessment_process')
            // ->where('enrollment_id', $enrollment_id)
            // ->updateOrInsert([
            //     'enrollment_id' => $enrollment_id,
            //     'elina_assessment_status' => $elina_assessment_status,
            //     'elina_assessment_id' => $elina_assessment_id,
            //     'elina_assessment_status_code' => $elina_assessment_status_code,
            //     'elina_assessment_status_code' => $description,
            //     'created_by' => $time,
            //     'created_date' => $time,
            // ]);
            // Redis::connection();
            // $this->WriteFileLog('asmnt1');
            // $this->WriteFileLog($description);
            $elina_assessment_process =  DB::table('elina_assessment_process')
                ->updateOrInsert(
                    [
                        'enrollment_id' => $enrollment_id,
                        'elina_assessment_status' =>  $elina_assessment_status,
                        'elina_assessment_status_code' => $elina_assessment_status_code,
                        'description' => $description,
                        'created_by' => $user,
                        'created_date' => $time
                    ],
                    ['enrollment_id' => $enrollment_id]
                );
            // $this->WriteFileLog($elina_assessment_process);


            // $elina_assessment_id = $elina_assessment_process->elina_assessment_id;
            return  $elina_assessment_process;
        } catch (\Exception $exc) {
            $exceptionResponse = array();
            $exceptionResponse['ServiceMethod'] = 'Method => BaseController => AuditLog';
            $exceptionResponse['Exception'] = $exc->getMessage();
            $exceptionResponse = json_encode($exceptionResponse, JSON_FORCE_OBJECT);
            $this->WriteFileLog($exceptionResponse);
            //return 'Failure';
        }
    }
    public function notificationstable($user_id, $notification_status, $notification_type, $notification_description)
    {
        try {
            $notifications = DB::table('notifications')->insert([
                'user_id' => $user_id,
                'notification_status' => $notification_status,
                'notification_type' => $notification_type,
                'notification_description' => $notification_description,
                'created_by' => auth()->user()->id,
                'created_at' => NOW()
            ]);
            return true;
        } catch (\Exception $exc) {
            $exceptionResponse = array();
            $exceptionResponse['ServiceMethod'] = 'Method => BaseController => notifications';
            $exceptionResponse['Exception'] = $exc->getMessage();
            $exceptionResponse = json_encode($exceptionResponse, JSON_FORCE_OBJECT);
            $this->WriteFileLog($exceptionResponse);
            //return 'Failure';
        }
    }
    // public $client;

    // public function __construct(Googl $googl)
    // {
    //     $this->client = $googl->client();
    //     $this->client->setAuthConfig(storage_path('calendar.json'));
    // }

    public function admin_notification($notification_type, $notification_status, $urlID1, $urlID, $name, $megcontent)
    {

        $adminID = DB::select("SELECT * FROM users WHERE array_roles=4");
        $countAdmin = count($adminID);
        for ($i = 0; $i < $countAdmin; $i++) {
            $notifications = DB::table('notifications')->insertGetId([
                'user_id' => $adminID[$i]->id,
                'notification_type' => $notification_type,
                'notification_status' => $notification_status,
                'notification_url' => $urlID1 . '/' . encrypt($urlID),
                'megcontent' => $name . $megcontent,
                'alert_meg' => $name . $megcontent,
                'created_by' => auth()->user()->id,
                'created_at' => NOW(),
            ]);
        }
    }

    public function sail_status_log($tableName, $key, $action, $description, $user, $time, $role_name)
    {
        try {
            DB::table('sail_status_logs')->insert([
                'audit_table_name' => $tableName,
                'audit_table_id' => $key,
                'audit_action' => $action,
                'description' => $description,
                'user_id' => $user,
                'action_date_time' => $time,
                'enrollment_id' => $role_name
            ]);

            DB::table('sail_details')
                ->where('enrollment_id', $role_name)
                ->update([
                    'current_status' => $action,
                    'last_modified_by' => auth()->user()->id,
                    'last_modified_date' => now()
                ]);
        } catch (\Exception $exc) {
            $exceptionResponse = array();
            $exceptionResponse['ServiceMethod'] = 'Method => BaseController => AuditLog';
            $exceptionResponse['Exception'] = $exc->getMessage();
            $exceptionResponse = json_encode($exceptionResponse, JSON_FORCE_OBJECT);
            $this->WriteFileLog($exceptionResponse);
            //return 'Failure';
        }
    }

    public function ovm_status_logs($tableName, $key, $action, $description, $user, $time, $role_name, $name)
    {
        try {

            DB::table('ovm_status_logs')->insert([
                'audit_table_name' => $tableName,
                'audit_table_id' => $key,
                'audit_action' => $action,
                'description' => $description,
                'user_id' => $user,
                'action_date_time' => $time,
                'enrollment_id' => $role_name,
                'role_name' => $name
            ]);
        } catch (\Exception $exc) {
            $exceptionResponse = array();
            $exceptionResponse['ServiceMethod'] = 'Method => BaseController => AuditLog';
            $exceptionResponse['Exception'] = $exc->getMessage();
            $exceptionResponse = json_encode($exceptionResponse, JSON_FORCE_OBJECT);
            $this->WriteFileLog($exceptionResponse);
            //return 'Failure';
        }
    }
    public function StudentsLogs($tableName, $key, $description, $user, $time)
    {
        try {
            DB::table('students_logs')->insert([
                'audit_table_name' => $tableName,
                'audit_table_id' => $key,
                'description' => $description,
                'user_id' => $user,
                'action_date_time' => $time,
            ]);
        } catch (\Exception $exc) {
            $exceptionResponse = array();
            $exceptionResponse['ServiceMethod'] = 'Method => BaseController => AuditLog';
            $exceptionResponse['Exception'] = $exc->getMessage();
            $exceptionResponse = json_encode($exceptionResponse, JSON_FORCE_OBJECT);
            $this->WriteFileLog($exceptionResponse);
            //return 'Failure';
        }
    }

    public function getPayableAmount($enrollmentID, $feeType)
    {

        $data = DB::table('enrollment_details')
            ->select('category_id', 'school_id')
            ->where('enrollment_id', $enrollmentID)
            ->get();

        $paymentCategory = $data[0]->category_id;
        $schoolID = $data[0]->school_id;

        $paymentDetails = DB::table('payment_process_customized')
            ->where('enrollment_id', $enrollmentID)
            ->get();

        // $this->WriteFileLog('$feeType ' . $feeType);
        // $this->WriteFileLog('$paymentCategory ' . $paymentCategory);
        // $this->WriteFileLog('$enrollmentID ' . $enrollmentID);

        if (!empty($paymentDetails && $paymentDetails != '[]')) {

            // if ($schoolID == 0) {
            //     $this->WriteFileLog('If - School - 0');
            //     $activePayment = DB::table('payment_process_customized')
            //         ->where('fees_type_id', $feeType)
            //         ->where('category_id', $paymentCategory)
            //         ->where('enrollment_id', $enrollmentID)
            //         ->select('final_amount', 'id', 'base_amount', 'gst_rate')
            //         ->first();
            // } else
            if ($paymentCategory == 2) {
                // $this->WriteFileLog('Else if -paymentCategory == 2 ');
                $activePayment = DB::table('payment_process_customized')
                    ->where('fees_type_id', $feeType)
                    ->where('category_id', $paymentCategory)
                    // ->where('school_enrollment_id', $schoolID)
                    ->where('enrollment_id', $enrollmentID)
                    ->select('final_amount', 'id', 'base_amount', 'gst_rate')
                    ->first();
            } else {
                // $this->WriteFileLog('Else');
                $activePayment = DB::table('payment_process_customized')
                    ->where('fees_type_id', $feeType)
                    ->where('category_id', $paymentCategory)
                    ->where('enrollment_id', $enrollmentID)
                    ->select('final_amount', 'id', 'base_amount', 'gst_rate')
                    ->first();
            }
        } else {

            if ($schoolID == 0) {
                // $this->WriteFileLog('else if - School - 0');
                $activePayment = DB::table('payment_process_masters')
                    ->where('fees_type_id', $feeType)
                    ->where('category_id', $paymentCategory)
                    ->select('final_amount', 'id', 'base_amount', 'gst_rate')
                    ->first();
            } elseif ($paymentCategory == 2) {
                // $this->WriteFileLog('Else else if -paymentCategory == 2 ');
                $activePayment = DB::table('payment_process_masters')
                    ->where('fees_type_id', $feeType)
                    ->where('category_id', $paymentCategory)
                    ->where('school_enrollment_id', $schoolID)
                    ->select('final_amount', 'id', 'base_amount', 'gst_rate')
                    ->first();
            } else {
                // $this->WriteFileLog('Else else');
                $activePayment = DB::table('payment_process_masters')
                    ->where('fees_type_id', $feeType)
                    ->where('category_id', $paymentCategory)
                    ->select('final_amount', 'id', 'base_amount', 'gst_rate')
                    ->first();
            }
        }
        // $this->WriteFileLog($activePayment->final_amount);       
        $payableAmount = $activePayment->final_amount;
        return $payableAmount;
    }
}
