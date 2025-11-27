<?php

namespace App\Http\Controllers;

use App\Jobs\refundjob;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Mail\sendpaymentsuccessfullmail;
use App\Mail\paymentsuccessfullmail;
use Illuminate\Support\Facades\Auth;
use App\Mail\OfflinePaymentMail;
use Illuminate\Support\Carbon;

class Paymentcontroller extends BaseController
{

    //
    public function index(Request $request)
    {
        try {

            $method = 'Method => Paymentcontroller => index';

            $userID = auth()->user()->id;
            $email = auth()->user()->email;

            $rows = DB::select("SELECT * FROM payment_status_details WHERE payment_status_details.initiated_to='$email' ORDER BY payment_status_id DESC ");
            $role = DB::select("SELECT array_roles FROM users WHERE id=$userID");
            $roleID = $role[0]->array_roles;

            // $this->WriteFileLog($rows);
            $enrollment_id = $rows[0]->enrollment_child_num;
            // $this->WriteFileLog('1');

            // $refund_deails = dispatch(new refundjob('1'))->delay(now()->addSeconds(60));
            // $this->WriteFileLog('1');
            $payments = DB::select("SELECT * FROM refund_details where enrollment_id= '$enrollment_id'");

            $response = [
                'rows' => $rows,
                'roleID' => $roleID,
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

    public function refund_index(Request $request)
    {
        try {
            $method = 'Method => Paymentcontroller => refund_index';
            $inputArray = $this->decryptData($request->requestData);
            $this->WriteFileLog($inputArray);

            $input = [
                'cf_payment_id' => $inputArray['cf_payment_id'],
                'cf_refund_id' => $inputArray['cf_refund_id'],
                'entity' => $inputArray['entity'],
                'order_id' => $inputArray['order_id'],
                'processed_at' => $inputArray['processed_at'],
                'refund_amount' => $inputArray['refund_amount'],
                'refund_arn' => $inputArray['refund_arn'],
                'refund_charge' => $inputArray['refund_charge'],
                'refund_currency' => $inputArray['refund_currency'],
                'refund_id' => $inputArray['refund_id'],
                'refund_mode' => $inputArray['refund_mode'],
                'refund_note' => $inputArray['refund_note'],
                'refund_speed' => $inputArray['refund_speed'],
                'refund_splits' => $inputArray['refund_splits'],
                'refund_status' => $inputArray['refund_status'],
                'refund_type' => $inputArray['refund_type'],
                'status_description' => $inputArray['status_description'],
            ];
            DB::transaction(function () use ($input) {
                $authID = Auth::id();


                $screen = DB::table('refund_details')->insertGetId([
                    'cf_payment_id' => $input['cf_payment_id'],
                    'cf_refund_id' => $input['cf_refund_id'],
                    'entity' => $input['entity'],
                    'order_id' => $input['order_id'],
                    'processed_at' => $input['processed_at'],
                    'refund_amount' => $input['refund_amount'],
                    'refund_arn' => $input['refund_arn'],
                    'refund_charge' => $input['refund_charge'],
                    'refund_currency' => $input['refund_currency'],
                    'refund_id' => $input['refund_id'],
                    'refund_mode' => $input['refund_mode'],
                    'refund_note' => $input['refund_note'],
                    'refund_speed' => $input['refund_speed'],
                    'refund_splits' => $input['refund_splits'],
                    'refund_status' => $input['refund_status'],
                    'refund_type' => $input['refund_type'],
                    'status_description' => $input['status_description'],
                    'created_by' => auth()->user()->id,
                    'created_date' => NOW()
                ]);
            });
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
        // $this->WriteFileLog($id);
        try {
            $method = 'Method => Paymentcontroller => createdata';


            $rows = DB::select('select child_contact_email,enrollment_id, child_contact_phone from 
            enrollment_details where user_id = ' . auth()->user()->id);
            $email = auth()->user()->email;

            // $email = DB::select("select email from users where email='$email'");
            // $this->WriteFileLog($email);
            // $en = $email->child_contact_email;

            // $id = $this->DecryptData($id);   

            $enrollment = DB::select("select * from payment_status_details INNER JOIN 
                  users ON payment_status_details.initiated_to = users.email
                  where users.email ='$email' and payment_status_details.payment_status='New'");







            $response = [
                'rows' => $rows,
                'email' => $email,
                'enrollment' =>  $enrollment,

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
    public function createdata1($id)
    {
        //echo "naa";exit;
        try {
            $method = 'Method => Paymentcontroller => createdata1';
            $id = $this->DecryptData($id);
            // $this->WriteFileLog($id);

            $rows = DB::select('select child_contact_email,enrollment_id, child_contact_phone from 
            enrollment_details where user_id = ' . auth()->user()->id);

            $emails = DB::select('select email from users where id=' . $id);

            $email = $emails[0]->email;

            // $email = DB::select("select email from users where email='$email'");
            // $this->WriteFileLog($id);
            // $en = $email->child_contact_email;

            $enrollment = DB::select("select * from payment_status_details INNER JOIN 
                  users ON payment_status_details.initiated_to = users.email
                  where users.id ='$id' and payment_status_details.payment_status='New'");
            // $this->WriteFileLog($enrollment);





            //   select * from payment_status_details INNER JOIN 
            //   users ON payment_status_details.initiated_to=users.email where users.email ='$email'


            $response = [
                'rows' => $rows,
                'email' => $email,
                'enrollment' =>  $enrollment,

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
            $method = 'Method => Paymentcontroller => storedata';
            $inputArray = $this->decryptData($request->requestData);
            $rows = DB::select('select * from enrollment_details where enrollment_id = ' . $inputArray['enrollment_id']);

            $input = [
                'enrollment_child_num' => $rows[0]->enrollment_child_num,
                'child_id' => $rows[0]->child_id,
                'child_name' => $rows[0]->child_name,
                // 'initiated_by' => $rows[0]->initiated_by,
                'initiated_to' => $rows[0]->child_contact_email,
                // 'payment_process_description' => $inputArray['payment_process_description'],
                'payment_amount' => $inputArray['payment_amount'],
                'payment_status' => $inputArray['payment_status'],
                'payment_for' => $inputArray['payment_for'],
                'enrollment_id' => $inputArray['enrollment_id'],
                'transaction_id' => $inputArray['transaction_id'],
                'receipt_num' => $inputArray['receipt_num'],
                'bank_referance' => $inputArray['bank_referance'],
                'payment_completion_time' => $inputArray['payment_completion_time'],
                'payment_currency' => $inputArray['payment_currency'],
                'payment_method' => $inputArray['payment_method'],
            ];

            $claimdetails = DB::table('payment_status_details')->orderBy('payment_status_id', 'desc')->where('transaction_id', '!=', null)->first();

            // if ($claimdetails == null) {
            //     $claimnoticenoNew =  'REC/' . date("Y") . '/' . date("M") . '/001';
            //     $transactionnum   =  'TRAN/' . date("Y") . '/' . date("M") . '/001';
            // } else {
            //     $claimnoticeno = $claimdetails->receipt_num;
            //     $claimnoticenoNew =  ++$claimnoticeno;
            //     $transactionid = $claimdetails->transaction_id;
            //     $transactionnum = ++$transactionid;
            // }
            // $this->writefilelog($input['initiated_to']);
            $authID = Auth::id();
            DB::transaction(function () use ($input) {
                $authID = Auth::id();
                if ($input['payment_status'] == 'SUCCESS') {

                    DB::table('payment_status_details')
                        ->where('initiated_to', $input['initiated_to'])
                        ->where('transaction_id', null)
                        ->update([
                            'payment_status' => $input['payment_status'],
                            'transaction_id' => $input['transaction_id'],
                            'receipt_num' => $input['receipt_num'],
                        ]);
                }

                $screen = DB::table('payment_process_details')->insertGetId([
                    'enrollment_child_num' => $input['enrollment_child_num'],
                    'child_id' => $input['child_id'],
                    'child_name' => $input['child_name'],
                    // 'initiated_by' => $input['initiated_by'],
                    'initiated_to' => $input['initiated_to'],
                    'payment_status' => $input['payment_status'],
                    // 'payment_process_description' => $input['payment_process_description'],
                    'transaction_id' => $input['transaction_id'],
                    'receipt_num' => $input['receipt_num'],
                    'bank_reference' => $input['bank_referance'],
                    'payment_completion_time' => $input['payment_completion_time'],
                    'payment_currency' => $input['payment_currency'],
                    'payment_method' => $input['payment_method'],
                    'created_by' => auth()->user()->id,
                    'created_date' => NOW()
                ]);



                $in = $input['initiated_to'];

                $emailid = DB::SELECT(" SELECT * from payment_status_details as a where initiated_to = '$in'");
                $initiate = $emailid[0]->payment_status_id;
                // $this->writefilelog('3');

                $role_name = DB::select("SELECT role_name FROM uam_roles AS ur INNER JOIN users us ON (us.array_roles=ur.role_id) WHERE us.id=$authID");
                $role_name_fetch = $role_name[0]->role_name;

                $this->auditLog('payment_status_details',  $initiate, 'create', 'Payment Completed', $authID, NOW(), $role_name_fetch);

                $enCh = $input['enrollment_child_num'];
                $amount = $input['payment_amount'];
                $this->updateGoogleEvent();
                $payment = DB::select("select * from payment_structure where fees_type='sail' and status='Active'");
                $effectiveDate = Carbon::parse($payment[0]->effective_date)->format('Y-m-d');
    
                // Prepare the effective date
                $formattedSelectedDate = Carbon::now()->format('Y-m-d'); // Assuming selectedDate should be current date
                $currentDate = Carbon::now()->format('Y-m-d');
                
                if ( $payment[0]->status == 'Active' && ($formattedSelectedDate === $currentDate) ) {
                    $enrol = DB::select("SELECT JSON_EXTRACT(is_coordinator1, '$.email') AS co_email from ovm_meeting_details where enrollment_id = '$enCh'");
                    $data = array(
                        'child_name' => $input['child_name'],
                        'child_contact_email' => $input['enrollment_child_num'],
                        'co_email' => $enrol[0]->co_email,
                    );
                    // Mail::to($input['initiated_to'])->send(new OVMCompleteMail($data));
                    $this->sail_status_log('payment_process_details', $screen, 'Payment Completed', 'Sail Status', $authID, NOW(), $enCh);
                }

                if ($input['payment_status'] == 'SUCCESS') {

                    DB::table('notifications')->insertGetId([
                        'user_id' => $authID,
                        'notification_type' => 'Payment',
                        'notification_status' => 'Payment Successfully completed',
                        'notification_url' => 'payuserfee/' . encrypt($initiate),
                        'megcontent' => "Dear parent " . $input['child_name'] . " " . $input['payment_for'] . " Payment has been Completed Successfully.",
                        'alert_meg' => "Dear parent " . $input['child_name'] . " " . $input['payment_for'] . " Payment has been Completed Successfully.",
                        'created_by' => $authID,
                        'created_at' => NOW()
                    ]);
                } else {
                    DB::table('notifications')->insertGetId([
                        'user_id' => $authID,
                        'notification_type' => 'Payment',
                        'notification_status' => 'Payment UnSuccessfully',
                        'notification_url' => 'payuserfee/' . encrypt($initiate),
                        'megcontent' => "Dear parent " . $input['child_name'] . " " . $input['payment_for'] . " Payment has been declined.",
                        'alert_meg' => "Dear parent " . $input['child_name'] . " " . $input['payment_for'] . " Payment has been declined.",
                        'created_by' => $authID,
                        'created_at' => NOW()
                    ]);
                }


                $admin_details = DB::SELECT("SELECT *from users where array_roles = '4' ");
                $adminn_count = count($admin_details);
                if ($admin_details != []) {
                    for ($j = 0; $j < $adminn_count; $j++) {
                        if ($input['payment_status'] == 'SUCCESS') {


                            DB::table('notifications')->insertGetId([
                                'user_id' =>  $admin_details[$j]->id,
                                'notification_type' => 'Payment',
                                'notification_status' => 'Payment Successfully completed',
                                'notification_url' => 'userregisterfee/' . encrypt($initiate),
                                'megcontent' => "User " . $input['child_name'] . " (" . $input['enrollment_child_num'] . ") " . $input['payment_for'] . " Payment Successfully Completed and Mail Sent.",
                                'alert_meg' => "User " . $input['child_name'] . " (" . $input['enrollment_child_num'] . ") " . $input['payment_for'] . " Payment Successfully Completed and Mail Sent.",
                                'created_by' => $authID,
                                'created_at' => NOW()
                            ]);
                        } else {


                            DB::table('notifications')->insertGetId([
                                'user_id' =>  $admin_details[$j]->id,
                                'notification_type' => 'Payment',
                                'notification_status' => 'Payment UnSuccessfully',
                                'notification_url' => 'payuserfee/create',
                                'megcontent' => "User " . $input['child_name'] . " (" . $input['enrollment_child_num'] . ") " . $input['payment_for'] . " Payment has been declined",
                                'alert_meg' => "User " . $input['child_name'] . " (" . $input['enrollment_child_num'] . ") " . $input['payment_for'] . " Payment has been declined.",
                                'created_by' => $authID,
                                'created_at' => NOW()
                            ]);
                        }
                    }
                }
                $userID = $authID;
                $ch = DB::select("SELECT * FROM notifications WHERE notification_status = 'Payment Initiated' AND user_id = $userID");
                if ($ch !== []) {
                    DB::table('notifications')
                        ->where('user_id', $userID)
                        ->where('notification_status', 'Payment Initiated')
                        ->update([
                            'active_flag' => 1
                        ]);
                }
            });

            $email = $input['initiated_to'];

            $users = DB::select("SELECT email, name from users where array_roles='4' ");
            $email = $users[0]->email;
            $admin_email = count($users);
            if ($email != []) {
                for ($j = 0; $j < $admin_email; $j++) {

                    $name = $users[$j]->name;
                    $data = array(
                        'admin' => $name,
                        'name' => $request['name'],
                        'child_name' => $input['child_name'],
                    );
                    Mail::to($users[$j]->email)->send(new paymentsuccessfullmail($data));
                }
            }

            $enrollment_details = DB::select("SELECT child_father_guardian_name , child_mother_caretaker_name FROM enrollment_details WHERE user_id = $authID");

            $response = [
                'amount' => $input['payment_amount'],
                'receipt_number' => $input['receipt_num'],
                'child_name' => $input['child_name'],
                'initiated_to' => $input['initiated_to'],
                'father' => $enrollment_details[0]->child_father_guardian_name,
                'mother' => $enrollment_details[0]->child_mother_caretaker_name,
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

            $method = 'Method => Paymentcontroller => data_edit';

            $id = $this->DecryptData($id);


            $rows = DB::table('payment_status_details as a')


                ->select('a.*')
                ->where('a.payment_status_id', $id)
                ->get();

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

    public function sailcreatedata()
    {
        //echo "naa";exit;
        try {
            $method = 'Method => Paymentcontroller => createdata';


            $rows = DB::select('select child_contact_email from enrollment_details');
            $email = auth()->user()->email;

            // $email = DB::select("select email from users where email='$email'");
            // $this->WriteFileLog($email);
            // $en = $email->child_contact_email;

            $enrollment = DB::select("
            select * from payment_status_details INNER JOIN 
              users ON payment_status_details.initiated_to=users.email where users.email ='$email'");

            $response = [
                'rows' => $rows,
                'email' => $email,
                'enrollment' =>  $enrollment,

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
    public function storedataemail(Request $request)
    {
        try {
            $method = 'Method => Paymentcontroller => storedataemail';
            $inputArray = $this->decryptData($request->requestData);
            $email = $inputArray['register_receipt'];
            $receipt = $inputArray['receipt_number'];
            $us = Auth::id();
            $cc = DB::select("SELECT * FROM users AS a INNER JOIN enrollment_details AS b ON a.id = b.user_id WHERE a.id= $us");
            // $this->WriteFileLog($receipt);
            $paymentDetails = DB::select("SELECT * FROM payment_status_details WHERE receipt_num='$receipt'");
            // $this->WriteFileLog($paymentDetails);

            $data = array(
                'child_name' => $cc[0]->child_name,
                'register_receipt' => $inputArray['register_receipt'],
                'receipt' => $receipt,
                'payment_for' => $paymentDetails[0]->payment_for,
                'payment_amount' => $paymentDetails[0]->payment_amount,
            );

            Mail::to($cc[0]->child_contact_email)->send(new sendpaymentsuccessfullmail($data));
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


    public function compasspay_create(Request $request)
    {
    }


    public function compasspay_show($id)
    {
    }

    public function offline_request(Request $request)
    {

        $inputArray = $this->decryptData($request->requestData);

        $payment_status_id = $inputArray['payment_status_id'];
        $initiated_to = $inputArray['initiated_to'];
        $payment_type = $inputArray['payment_type'];

        $payment_status =   DB::select("SELECT * FROM payment_status_details WHERE payment_status_id = '$payment_status_id'");

        $data = array(
            'child_name' => $payment_status[0]->child_name,
            'payment_for' => $payment_status[0]->payment_for,
        );

        Mail::to($initiated_to)->send(new OfflinePaymentMail($data));

        DB::table('payment_status_details')
            ->where('payment_status_id', $payment_status_id)
            ->update([
                'payment_type' => 1,
                // 'status' => 'Verification Pending',
            ]);

        $admin_details = DB::SELECT("SELECT * from users where array_roles = '4'");
        $adminn_count = count($admin_details);
        if ($admin_details != []) {
            for ($j = 0; $j < $adminn_count; $j++) {
                DB::table('notifications')->insertGetId([
                    'user_id' =>  $admin_details[$j]->id,
                    'notification_type' => 'Payment',
                    'notification_status' => 'Payment Successfully completed',
                    'notification_url' => 'userregisterfee',
                    'megcontent' => "User " . $payment_status[0]->child_name . " (" . $payment_status[0]->enrollment_child_num . ") " . $payment_status[0]->payment_for . " Payment has requested for offline payment and Mail Sent.",
                    'alert_meg' => "User " . $payment_status[0]->child_name . " (" . $payment_status[0]->enrollment_child_num . ") " . $payment_status[0]->payment_for . " Payment has requested for offline payment and Mail Sent.",
                    'created_by' => auth()->user()->id,
                    'created_at' => NOW()
                ]);
            }
        }

        $serviceResponse = array();
        $serviceResponse['Code'] = config('setting.status_code.success');
        $serviceResponse['Message'] = config('setting.status_message.success');
        $serviceResponse['Data'] = 1;
        $serviceResponse = json_encode($serviceResponse, JSON_FORCE_OBJECT);
        $sendServiceResponse = $this->SendServiceResponse($serviceResponse, config('setting.status_code.success'), true);
        return $sendServiceResponse;
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
}
