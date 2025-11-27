<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use GuzzleHttp\Client;
use App\Jobs\refundjob;
use Validator;
use Illuminate\Support\Facades\DB;
use File;
use Illuminate\Support\Facades\Mail;
use App\Mail\sendpaymentmail;
use App\Mail\adminpaymentinitiation;
use App\Jobs\paymentinitiatejob;
use Illuminate\Support\Str;
use App\Models\User;
use Illuminate\Support\Facades\URL;
use App\Mail\sendsailpaymentmail;
use Illuminate\Support\Facades\Auth;
use App\Mail\sendpaymentsuccessfullmail;
use App\Mail\sailconsentmail;

class UserregisterfeeController extends BaseController
{

    public function index(Request $request)
    {
        try {

            $method = 'Method => UserregisterfeeController => index';

            $rows = DB::select("SELECT * FROM payment_status_details 
            ORDER BY payment_status_id DESC");
            // $refund_deails = dispatch(new refundjob('1'))->delay(now()->addSeconds(60));

            $payments = DB::select("SELECT * FROM refund_details");

            $response = [
                'rows' => $rows,
                'payments' => $payments
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

    public function createdata()
    {
        //echo "naa";exit;
        try {
            $method = 'Method => UserregisterfeeController => createdata';


            // $rows = DB::select("SELECT a.* from enrollment_details AS a 
            // INNER JOIN users AS b ON b.email = a.child_contact_email
            // WHERE b.email IS NOT NULL AND a.status = 'Submitted'");
            $rows = DB::Select("SELECT a.* from enrollment_details AS a INNER JOIN users AS b ON b.email = a.child_contact_email
            WHERE b.email IS NOT NULL AND a.status = 'Submitted' ORDER BY a.enrollment_id DESC ");

            $id = auth()->user()->id;

            $email = DB::select("select * from users where id = $id");

            $paymenttokentime = DB::Select("select token_expire_time from token_paremeterisation where token_process='Payment'");

            // $this->WriteFileLog($paymenttokentime[0]->token_expire_time);

            $paymenttokentime = $paymenttokentime[0]->token_expire_time;

            $response = [
                'rows' => $rows,
                'email' => $email,
                'paymenttokentime' => $paymenttokentime,
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

        //return $request;
        try {
            $method = 'Method => UserregisterfeeController => storedata';



            $inputArray = $this->decryptData($request->requestData);
            // $userid = (auth()->check())?auth()->user()->id:"a";
            // $this->WriteFileLog($userid);


            $input = [
                'enrollment_child_num' => $inputArray['enrollment_child_num'],
                'child_id' => $inputArray['child_id'],
                'child_name' => $inputArray['child_name'],
                'initiated_by' => $inputArray['initiated_by'],
                'initiated_to' => $inputArray['initiated_to'],
                'payment_amount' => $inputArray['payment_amount'],
                'payment_status' => $inputArray['payment_status'],
                'payment_process_description' => $inputArray['payment_process_description'],
                'url' => $inputArray['url'],
                'userid' => $inputArray['user_id'],
                // 'transaction_id' => $inputArray['transaction_id'],
                // 'receipt_num' => $inputArray['receipt_num'],
                'notificationURL' => $inputArray['notificationURL'],
                'register_invoice' => $inputArray['register_invoice']
            ];
            $initiated_to = $input['initiated_to'];


            $user_check = DB::select("select * from payment_status_details where initiated_to = '$initiated_to'");

            if ($user_check == []) {


                DB::transaction(function () use ($input) {

                    $inputArraycount = count($input);

                    $screen_permission_id = DB::table('payment_status_details')->insertGetId([
                        'enrollment_child_num' => $input['enrollment_child_num'],
                        'child_id' => $input['child_id'],
                        'child_name' => $input['child_name'],
                        'initiated_by' => $input['initiated_by'],
                        'initiated_to' => $input['initiated_to'],
                        'payment_amount' => $input['payment_amount'],
                        'payment_status' => $input['payment_status'],
                        'payment_process_description' => $input['payment_process_description'],
                        // 'transaction_id' => $input['transaction_id'],
                        // 'receipt_num' => $claimnoticenoNew,
                        'active_flag' => 0,
                        'payment_for' => 'User Register Fee',
                        'created_date' => NOW()
                    ]);






                    $this->auditLog('payment_status_details', $screen_permission_id, 'create', 'create a new Payment', '', NOW(), 'payment initiated');

                    $admin_details = DB::SELECT("SELECT * from users where array_roles = '4'");
                    $adminn_count = count($admin_details);
                    if ($admin_details != []) {
                        for ($j = 0; $j < $adminn_count; $j++) {

                            $notifications = DB::table('notifications')->insertGetId([
                                'user_id' =>  $admin_details[$j]->id,
                                'notification_type' => 'Payment',
                                'notification_status' => 'Payment Initiated',
                                'notification_url' => 'userregisterfee/' . encrypt($screen_permission_id),
                                'megcontent' => "User " . $input['child_name'] . " (" . $input['enrollment_child_num'] . ")" . " Payment Initiated Successfully and mail sent.",
                                'alert_meg' => "User " . $input['child_name'] . " (" . $input['enrollment_child_num'] . ")" . " Payment Initiated Successfully and mail sent.",
                                'created_by' => '',
                                'created_at' => NOW()
                            ]);
                        }
                    }
                });



                DB::transaction(function () use ($input) {

                    $inputArraycount = count($input);

                    $screen_permission = DB::table('payment_process_details')->insertGetId([
                        'enrollment_child_num' => $input['enrollment_child_num'],
                        'child_name' => $input['child_name'],
                        'child_id' => $input['child_id'],
                        'payment_status' => $input['payment_status'],
                        'payment_process_description' => $input['payment_process_description'],
                        'initiated_by' => $input['initiated_by'],
                        'initiated_to' => $input['initiated_to'],
                        'created_by' => '',
                        'created_date' => NOW()
                    ]);

                    $this->auditLog('payment_process_details', $screen_permission, 'create', 'create a new Payment', '', NOW(), 'Payment Initiated');
                });

                $email = $inputArray['initiated_to'];

                $data = array(
                    'child_name' => $inputArray['child_name'],
                    'initiated_to' => $input['initiated_to'],
                    'url' => $input['url'],
                    'register_invoice' => $inputArray['register_invoice'],
                    'amount' => $input['payment_amount']
                );

                $in = DB::select("SELECT id FROM users WHERE email='$email'");
                $inID = $in[0]->id;
                DB::table('notifications')->insertGetId([
                    'user_id' => $inID,
                    'notification_type' => 'Payment',
                    'notification_status' => 'Payment Initiated',
                    'notification_url' => 'payuserfee/create',
                    'megcontent' => "Dear Parent User Register Fee Payment is Initiated Successfully",
                    'alert_meg' => "Dear Parent User Register Fee Payment is Initiated Successfully",
                    'created_by' => '',
                    'created_at' => NOW()
                ]);
                // $this->WriteFileLog('1');
                Mail::to($data['initiated_to'])->send(new sendpaymentmail($data));
                // $this->WriteFileLog('2');
                $users = DB::select("SELECT email, name from users where array_roles='4'");
                $admin_email = count($users);
                if ($email != []) {
                    for ($j = 0; $j < $admin_email; $j++) {
                        $name = $users[$j]->name;
                        $email = $users[0]->email;
                        $data = array(
                            'admin' => $name,
                            'child_name' => $inputArray['child_name'],
                            'initiated_to' => $email
                        );
                        dispatch(new paymentinitiatejob($data))->delay(now()->addSeconds(1));
                        // Mail::to($users[$j]->email)->send(new adminpaymentinitiation($data));
                    }
                }


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

    public function data_edit($id)
    {
        try {
            $method = 'Method => UserregisterfeeController => data_edit';
            $id = $this->DecryptData($id);
            // $rows = DB::table('payment_status_details as a')
            //     ->select('a.*')
            //     ->where('a.payment_status_id', $id)
            //     ->get();

            $rows = DB::select("SELECT a.* ,b.child_contact_phone as phno ,b.child_father_guardian_name as father , b.child_mother_caretaker_name as mother FROM payment_status_details AS a 
            INNER JOIN enrollment_details AS b ON b.enrollment_child_num = a.enrollment_child_num
            WHERE payment_status_id = $id");

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


    public function updatedata(Request $request)
    {

        try {

            $method = 'Method =>  UserregisterfeeController => updatedata';

            $inputArray = $this->decryptData($request->requestData);
            $input = [
                'id' => $inputArray['id'],
                'enrollment_id' => $inputArray['enrollment_id'],
                'child_id' => $inputArray['child_id'],
                'child_name' => $inputArray['child_name'],
                'initiated_by' => $inputArray['initiated_by'],
                'initiated_to' => $inputArray['initiated_to'],
                'payment_amount' => $inputArray['payment_amount'],
                'payment_status' => $inputArray['payment_status'],
                'payment_process_description' => $inputArray['payment_process_description'],
            ];









            DB::transaction(function () use ($input) {







                DB::table('payment_status_details')
                    ->where('payment_status_id', $input['id'])
                    ->update([

                        'enrollment_id' => $input['enrollment_id'],
                        'child_id' => $input['child_id'],
                        'child_name' => $input['child_name'],
                        'initiated_by' => $input['initiated_by'],
                        'initiated_to' => $input['initiated_to'],
                        'payment_amount' => $input['payment_amount'],
                        'payment_status' => $input['payment_status'],
                        'payment_process_description' => $input['payment_process_description'],
                        'active_flag' => 0,

                        // 'user_id' => auth()->user()->id,                                              

                        'created_by' => auth()->user()->id,
                        'created_date' => NOW()

                    ]);
                //   $role_name=DB::select("SELECT role_name FROM uam_roles AS ur
                //       INNER JOIN users us ON (us.array_roles=ur.role_id) WHERE us.id=".auth()->user()->id);

                //   $role_name_fetch=$role_name[0]->role_name;
                $this->auditLog('payment_process_details', $input, 'Update', 'update a new Payment', auth()->user()->id, NOW(), ' $role_name_fetch');
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


            $method = 'Method =>UserregisterfeeController => data_delete';

            $id = $this->decryptData($id);




            $check = DB::select("select * from payment_status_details where payment_status_id = '$id' and active_flag = '0' ");

            if ($check !== []) {


                DB::table('payment_status_details')
                    ->where('payment_status_id', $id)
                    ->update([
                        'active_flag' => 1,

                    ]);



                // $role_name=DB::select("SELECT role_name FROM uam_roles AS ur
                //     INNER JOIN users us ON (us.array_roles=ur.role_id) WHERE us.id=".auth()->user()->id);

                // $role_name_fetch=$role_name[0]->role_name;

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

        //
    }


    public function GetAllDepartmentsByDirectorate(Request $request)
    {
        try {
            $logMethod = 'Method => UserregisterfeeController => GetAllDirectorates';
            $inputArray = $request->requestData;
            // $this->WriteFileLog($inputArray);
            $enrollmentID = DB::select("select * from enrollment_details where enrollment_child_num = '$inputArray'");
            $usermail = $enrollmentID[0]->child_contact_email;
            $enrollment_id = $enrollmentID[0]->enrollment_id;
            $allocation = DB::select("SELECT * FROM ovm_allocation WHERE enrollment_id = $enrollment_id ");
            $user_id = DB::select("select id from users where email = '$usermail'");
            $enrollment_details = DB::select("SELECT o.*, e.enrollment_child_num, u1.name AS is_coordinator1_name, u2.name AS is_coordinator2_name
            FROM ovm_allocation AS o INNER JOIN enrollment_details AS e ON o.enrollment_id = e.enrollment_id INNER JOIN users AS u1 ON u1.id = o.is_coordinator1 INNER JOIN users AS u2 ON u2.id = o.is_coordinator2 WHERE o.STATUS IS NOT NULL and e.enrollment_child_num= '$inputArray' ORDER BY o.id DESC");

            $enrollmentID = (object) array_merge(
                (array) $enrollmentID,
                (array) $user_id,
                (array) $allocation,
                (array) $enrollment_details
            );
            // $this->WriteFileLog($enrollmentID);

            $serviceResponse = array();
            $serviceResponse['Code'] = config('setting.status_code.success');
            $serviceResponse['Message'] = config('setting.status_message.success');
            $serviceResponse['Data'] =  $enrollmentID;
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

    public function sailcreatedata()
    {
        //echo "naa";exit;
        try {
            $method = 'Method => UserregisterfeeController => sailcreatedata';
            // $this->WriteFileLog($method);


            $rows = DB::select("select * from enrollment_details 
            WHERE enrollment_child_num IN (SELECT enrollment_id FROM sail_details WHERE active_flag=0)
            AND enrollment_child_num NOT IN (SELECT enrollment_child_num FROM payment_status_details 
            WHERE payment_for = 'SAIL Register Fee')");
            $id = auth()->user()->id;
            $email = DB::select("select * from users where id = $id");
            $paymenttokentime = DB::Select("select token_expire_time from token_paremeterisation where token_process='Payment'");






            $response = [
                'rows' => $rows,
                'email' => $email,
                'paymenttokentime' => $paymenttokentime
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


    public function sailstoredata(Request $request)
    {
        try {
            $method = 'Method => UserregisterfeeController => sailstoredata';
            $inputArray = $this->decryptData($request->requestData);
            $input = [
                'enrollment_child_num' => $inputArray['enrollment_child_num'],
                'child_id' => $inputArray['child_id'],
                'child_name' => $inputArray['child_name'],
                'initiated_by' => $inputArray['initiated_by'],
                'initiated_to' => $inputArray['initiated_to'],
                'payment_amount' => $inputArray['payment_amount'],
                'payment_status' => $inputArray['payment_status'],
                'payment_process_description' => $inputArray['payment_process_description'],
                'payment_for' => $inputArray['payment_for'],
                'sail_invoice' => $inputArray['sail_invoice'],
                'url' => $inputArray['url'],
                'user_id' => $inputArray['user_id'],
                'consent_aggrement' => $inputArray['consent_aggrement'],
            ];


            $enrollmentID = DB::transaction(function () use ($input) {
                $authID = Auth::id();
                $payment_declaration = "SAIL Register Fee";
                $screen_permission_id = DB::table('payment_status_details')->insertGetId([
                    'enrollment_child_num' => $input['enrollment_child_num'],
                    'child_id' => $input['child_id'],
                    'child_name' => $input['child_name'],
                    'initiated_by' => $input['initiated_by'],
                    'initiated_to' => $input['initiated_to'],
                    'payment_amount' => $input['payment_amount'],
                    'payment_status' => $input['payment_status'],
                    'payment_process_description' => $input['payment_process_description'],
                    'active_flag' => 0,
                    'payment_for' => $payment_declaration,
                    'created_by' => $authID,
                    'created_date' => NOW()
                ]);

                DB::table('sail_details')
                    ->where('enrollment_id', $input['enrollment_child_num'])
                    ->update([
                        'consent_aggrement' => $input['consent_aggrement'],
                    ]);

                $this->auditLog('payment_status_details', $screen_permission_id, 'create', 'create a new Payment', $authID, NOW(), 'payment initiated');

                $enrollmentChildNum = $input['enrollment_child_num'];
                $enrollmentDetails = DB::select("SELECT user_id , enrollment_id FROM enrollment_details WHERE enrollment_child_num='$enrollmentChildNum'");
                $parentUserID = $enrollmentDetails[0]->user_id;
                $enrollmentID = $enrollmentDetails[0]->enrollment_id;

                DB::table('notifications')->insertGetId([
                    'user_id' => $parentUserID,
                    'notification_type' => 'Payment',
                    'notification_status' => 'Payment Initiated',
                    'notification_url' => 'payuserfee/create',
                    'megcontent' => "Dear " . $input['child_name'] . " (" . $input['enrollment_child_num'] . ")" . " Your " . $input['payment_for'] . " Payment Initiated was Successfully. Please click here to pay.",
                    'alert_meg' => "Dear " . $input['child_name'] . " (" . $input['enrollment_child_num'] . ")" . " Your " . $input['payment_for'] . " Payment Initiated was Successfully. Please click here to pay",
                    'created_by' => $authID,
                    'created_at' => NOW()
                ]);

                $admin_details = DB::SELECT("SELECT * from users where array_roles = '4'");
                $adminn_count = count($admin_details);
                if ($admin_details != []) {
                    for ($j = 0; $j < $adminn_count; $j++) {

                        $notifications = DB::table('notifications')->insertGetId([
                            'user_id' =>  $admin_details[$j]->id,
                            'notification_type' => 'Payment',
                            'notification_status' => 'Payment Initiated',
                            'notification_url' => 'payuserfee/' . encrypt($screen_permission_id),
                            'megcontent' => "User " . $input['child_name'] . " (" . $input['enrollment_child_num'] . ") " . $input['payment_for'] . " Payment Initiated Successfully and mail sent.",
                            'alert_meg' => "User " . $input['child_name'] . " (" . $input['enrollment_child_num'] . ") " . $input['payment_for'] . " Payment Initiated Successfully and mail sent.",
                            'created_by' => auth()->user()->id,
                            'created_at' => NOW()
                        ]);
                    }
                }
            
                $authID = Auth::id();
                $screen_permission = DB::table('payment_process_details')->insertGetId([
                    'enrollment_child_num' => $input['enrollment_child_num'],
                    'child_name' => $input['child_name'],
                    'child_id' => $input['child_id'],
                    'payment_status' => $input['payment_status'],
                    'payment_process_description' => $input['payment_process_description'],
                    'initiated_by' => $input['initiated_by'],
                    'initiated_to' => $input['initiated_to'],
                    'created_by' => $authID,
                    'created_date' => NOW()
                ]);

                $role_name = DB::select("SELECT role_name FROM uam_roles AS ur INNER JOIN users us ON (us.array_roles=ur.role_id) WHERE us.id=$authID");
                $role_name_fetch = $role_name[0]->role_name;

                $this->auditLog('payment_process_details', $screen_permission, 'create', 'create a new Payment', $authID, NOW(), $role_name_fetch);
                $enrollmentChildNum = $input['enrollment_child_num'];
                $this->sail_status_log('payment_process_details', $screen_permission, 'Payment Initiated', 'Sail Status', $authID, NOW(), $enrollmentChildNum);

                return $enrollmentID;
            });
            
            $feeType = 2;
			$payableAmount = $this->getPayableAmount($enrollmentID, $feeType);

            $email = $inputArray['initiated_to'];
            $data = array(
                'child_name' => $inputArray['child_name'],
                'url' => $input['url'],
                'sail_invoice' => $inputArray['sail_invoice'],
                'amount' => $payableAmount
            );
            $data1 = array(
                'child_name' => $inputArray['child_name']
            );

            Mail::to($email)->send(new sailconsentmail($data1));
            // Mail::to($is_coordinator1email)->send(new sailconsentAdmin($data1));
            // Mail::to($is_coordinator2email)->send(new sailconsentAdmin($data1));

            Mail::to($email)->send(new sendsailpaymentmail($data));            

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

    public function category_data_get(Request $request)
    {
        try {
            $method = 'Method => UserregisterfeeController => category_data_get';


            $inputArray = $this->decryptData($request->requestData);
            $input = [
                'enrollment_child_num' => $inputArray['enrollment_child_num'],
                'type' => $inputArray['type'],
                'stage' => $inputArray['stage']
            ];

            $enID = $input['enrollment_child_num'];


            $type = $input['type'];
            $stage = $input['stage'];

            if ($type == 1) {

                $rows =  DB::select("SELECT a.questionnaire_id, a.questionnaire_name FROM questionnaire AS a 
                INNER JOIN questionnaire_details AS b ON b.questionnaire_id=a.questionnaire_id
                WHERE b.no_questions=b.question_count
                AND a.questionnaire_id NOT IN (
                SELECT ques.questionnaire_id  FROM questionnaire AS ques 
                inner JOIN questionnaire_details AS qud ON ques.questionnaire_id= qud.questionnaire_id
                INNER JOIN questionnaire_initiation AS qi ON qud.questionnaire_id = qi.questionnaire_id 
                WHERE qi.enrollment_id = $enID AND a.questionnaire_type = '$stage' and qi.activeflag = 0) AND a.questionnaire_type = '$stage' order by a.order_id ");
                $desc = DB::select("SELECT * FROM parent_video_upload AS a
                INNER JOIN activity AS b ON a.activity_id=b.activity_id
                INNER JOIN activity_description AS c ON a.activity_description_id=c.activity_description_id
                WHERE enrollment_id = $enID AND STATUS = 'Complete'");
                $activity = DB::select("SELECT * FROM parent_video_upload AS a
                INNER JOIN activity AS b ON a.activity_id=b.activity_id
                INNER JOIN activity_description AS c ON a.activity_description_id=c.activity_description_id
                WHERE enrollment_id = $enID AND STATUS = 'Complete' GROUP BY a.activity_id");
            } elseif ($type == 2) {
                $rows =  DB::select("SELECT a.questionnaire_id, a.questionnaire_name, qb.status FROM questionnaire AS a 
                INNER JOIN questionnaire_details AS b ON b.questionnaire_id=a.questionnaire_id 
                INNER JOIN questionnaire_initiation AS qb ON qb.questionnaire_id = b.questionnaire_id
                WHERE b.no_questions=b.question_count
                AND a.questionnaire_id IN (
                SELECT ques.questionnaire_id  FROM questionnaire AS ques 
                inner JOIN questionnaire_details AS qud ON ques.questionnaire_id= qud.questionnaire_id
                INNER JOIN questionnaire_initiation AS qi ON qud.questionnaire_id = qi.questionnaire_id 
                WHERE qi.enrollment_id = '$enID' AND a.questionnaire_type = '$stage')  AND a.questionnaire_type = '$stage'");
                $desc = DB::select("SELECT * FROM parent_video_upload AS a
                 INNER JOIN activity AS b ON a.activity_id=b.activity_id
                 INNER JOIN activity_description AS c ON a.activity_description_id=c.activity_description_id
                 WHERE enrollment_id = $enID AND STATUS = 'Complete'");
                $activity = DB::select("SELECT * FROM parent_video_upload AS a
                 INNER JOIN activity AS b ON a.activity_id=b.activity_id
                 INNER JOIN activity_description AS c ON a.activity_description_id=c.activity_description_id
                 WHERE enrollment_id = $enID AND STATUS = 'Complete' GROUP BY a.activity_id");
            }

            $response = [
                'rows' => $rows,
                'activity' => $activity,
                'desc' => $desc
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
    public function GetIsCo(Request $request)
    {
        try {
            $method = 'Method => UserregisterfeeController => GetIsCo';


            $inputArray = $this->decryptData($request->requestData);
            $input = [
                'enrollment_child_num' => $inputArray['enrollment_child_num'],
            ];

            $enID = $input['enrollment_child_num'];

            $rows =  DB::select("SELECT JSON_EXTRACT(is_coordinator1, '$.id') AS co1 , JSON_EXTRACT(is_coordinator2, '$.id') AS co2 FROM ovm_meeting_details 
            WHERE enrollment_id='$enID' AND active_flag=0");

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

    public function compass_create_data(Request $request)
    {
        try {
            $method = 'Method => UserregisterfreeController => compass_create_data';


            $rows = DB::select('select * from enrollment_details');

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
    public function SensoryGetData(Request $request)
    {
        $logMethod = 'Method => UserregisterfeeController => SensoryGetData';

        try {
            $inputArray = $request->requestData;
            $enrollmentID = DB::select("select * from enrollment_details where enrollment_child_num = '$inputArray'");
            $enrollment_id = $enrollmentID[0]->enrollment_id;

            $evidence = DB::select("SELECT a.activity_description_id , comments , b.activity_id , b.activity_name , c.description FROM parent_video_upload AS a
            INNER JOIN activity AS b ON b.activity_id = a.activity_id
            INNER JOIN activity_description AS c ON c.activity_description_id = a.activity_description_id WHERE enrollment_id = $enrollment_id AND a.enableflag = 0");
            $matrix = DB::select("SELECT * FROM sail_assessment_matrix");
            $sign = DB::select("SELECT * FROM users WHERE (id = (SELECT JSON_EXTRACT(is_coordinator1, '$.id') FROM sail_details WHERE enrollment_id = '$inputArray')
            OR id = (SELECT JSON_EXTRACT(is_coordinator2, '$.id') FROM sail_details WHERE enrollment_id = '$inputArray'))");

            $response = [
                'evidence' => $evidence,
                'matrix' => $matrix,
                'sign' => $sign
            ];

            $serviceResponse = array();
            $serviceResponse['Code'] = config('setting.status_code.success');
            $serviceResponse['Message'] = config('setting.status_message.success');
            $serviceResponse['Data'] =  $response;
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
    public function completepayment(Request $request)
    {
        try {
            $method = 'Method => UserregisterfeeController => completepayment';
            $inputArray = $this->decryptData($request->requestData);

            $input = [
                'enrollment_child_num' => $inputArray['enrollment_child_num'],
                'payment_status_id' => $inputArray['payment_status_id'],
                'payment_date' => $inputArray['payment_date'],
                'payment_mode' => $inputArray['payment_mode'],
                'reference_id' => $inputArray['reference_id'],
                'register_receipt' => $inputArray['register_receipt'],
                'receipt_number' => $inputArray['receipt_number'],
                'initiated_to' => $inputArray['initiated_to'],
                'payment_for' => $inputArray['paymentFor'],
                'payment_amount' => $inputArray['amount'],
                'transaction_id' => $inputArray['transaction_id'],
                'file_name' => $inputArray['file_name'],
            ];

            DB::transaction(function () use ($input) {

                DB::table('payment_status_details')
                    ->where('payment_status_id', $input['payment_status_id'])
                    ->update([
                        'payment_status' => 'SUCCESS',
                        'payment_type' => 1,
                        'reference_id' => $input['reference_id'],
                        'transaction_id' => $input['transaction_id'],
                        'receipt_num' => $input['receipt_number'],
                        'file_name' => $input['file_name'],
                        'payment_date' => $input['payment_date'],
                        'created_by' => auth()->user()->id,
                        'created_date' => NOW()
                    ]);

                DB::table('payment_process_details')->insertGetId([
                    'enrollment_child_num' => $input['enrollment_child_num'],
                    // 'child_name' => $input['child_name'],
                    // 'child_id' => $input['child_id'],
                    'payment_status' => 'SUCCESS',
                    // 'payment_process_description' => $input['payment_process_description'],
                    // 'initiated_by' => $input['initiated_by'],
                    'reference_id' => $input['reference_id'],
                    'initiated_to' => $input['initiated_to'],
                    'payment_status_id' => $input['payment_status_id'],
                    'created_by' => auth()->user()->id,
                    'created_date' => NOW()
                ]);

                $this->auditLog('payment_status_details', $input['payment_status_id'], 'SUCCESS', 'Payment SUCCESS', '', NOW(), 'payment completed');

                $email = $input['initiated_to'];
                $enrollment_child_num = $input['enrollment_child_num'];
                $enrollment_details = DB::select("SELECT * FROM users AS a INNER JOIN enrollment_details AS b ON a.id = b.user_id WHERE b.enrollment_child_num= '$enrollment_child_num'");

                $data = array(
                    'child_name' => $enrollment_details[0]->child_name,
                    'register_receipt' => $input['register_receipt'],
                    'receipt' => $input['receipt_number'],
                    'payment_for' => $input['payment_for'],
                    'payment_amount' => $input['payment_amount'],
                );

                Mail::to($email)->send(new sendpaymentsuccessfullmail($data));

                DB::table('notifications')->insertGetId([
                    'user_id' => $enrollment_details[0]->id,
                    'notification_type' => 'Payment',
                    'notification_status' => 'Payment Successfully completed',
                    'notification_url' => 'payuserfee/' . encrypt($input['payment_status_id']),
                    'megcontent' => "Dear parent " . $enrollment_details[0]->child_name . " " . $input['payment_for'] . " Payment has been Completed Successfully.",
                    'alert_meg' => "Dear parent " . $enrollment_details[0]->child_name . " " . $input['payment_for'] . " Payment has been Completed Successfully.",
                    'created_by' => auth()->user()->id,
                    'created_at' => NOW()
                ]);
                $userID = $enrollment_details[0]->id;
                $ch = DB::select("SELECT * FROM notifications WHERE notification_status = 'Payment Initiated' AND user_id = $userID");
                if ($ch !== []) {
                    DB::table('notifications')
                        ->where('user_id', $userID)
                        ->where('notification_status', 'Payment Initiated')
                        ->update([
                            'active_flag' => 1
                        ]);
                }

                if ($input['payment_for'] == 'SAIL Register Fee') {
                    $this->sail_status_log('payment_status_details', $input['payment_status_id'], 'Payment Completed', 'Sail Status', auth()->user()->id, NOW(), $enrollment_child_num);
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
}
