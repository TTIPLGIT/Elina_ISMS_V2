<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendReferralReport;
use App\Mail\ReferralRespondMail;
use App\Mail\ReferralRespondMail2;

class ReferralReportController extends BaseController
{

    public function index(Request $request)
    {
        try {
            $method = 'Method => ReferralReportController => index';         
            
            $authID = auth()->user()->id;
            $role_name = DB::select("SELECT role_name FROM uam_roles AS ur INNER JOIN users us ON (us.array_roles=ur.role_id) WHERE us.id=$authID");
            $role_name_fetch = $role_name[0]->role_name;

            if ($role_name_fetch == 'IS Coordinator') {
                $rows = DB::select("SELECT a.status , enrollment_child_num , child_name , id FROM referral_report AS a 
                INNER JOIN enrollment_details AS b ON a.enrollment_id = b.enrollment_id WHERE b.enrollment_child_num IN (SELECT enrollment_id FROM sail_details WHERE (JSON_EXTRACT(is_coordinator1, '$.id') = $authID or JSON_EXTRACT(is_coordinator2, '$.id') = $authID)) ORDER BY a.id DESC ");
            } else {
                $rows = DB::select("SELECT a.status , enrollment_child_num , child_name , id FROM referral_report AS a 
                INNER JOIN enrollment_details AS b ON a.enrollment_id = b.enrollment_id ORDER BY a.id DESC ");
            }

            $serviceResponse = array();
            $serviceResponse['Code'] = config('setting.status_code.success');
            $serviceResponse['Message'] = config('setting.status_message.success');
            $serviceResponse['Data'] = $rows;
            $serviceResponse = json_encode($serviceResponse, JSON_FORCE_OBJECT);
            $sendServiceResponse = $this->SendServiceResponse($serviceResponse, config('setting.status_code.success'), true);
            return $sendServiceResponse;
        } catch (\Exception $exc) {
            $exceptionResponse = array();
            $exceptionResponse['ServiceMethod'] = $method;
            $exceptionResponse['Exception'] = $exc->getMessage();
            $exceptionResponse = json_encode($exceptionResponse, JSON_FORCE_OBJECT);
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
        try {
            $method = 'Method => ReferralReportController => createdata';

            $re = DB::select("SELECT reports_id FROM reports WHERE report_type = 'SAIL' AND active_flag = 0");
            $reportsID = $re[0]->reports_id;

            $authID = auth()->user()->id;
            $role_name = DB::select("SELECT role_name FROM uam_roles AS ur INNER JOIN users us ON (us.array_roles=ur.role_id) WHERE us.id=$authID");
            $role_name_fetch = $role_name[0]->role_name;

            if ($role_name_fetch == 'IS Coordinator') {
                $enrollment_details = DB::select("Select a.enrollment_id AS getID, a.child_name ,a.user_id, a.enrollment_child_num , a.enrollment_id from enrollment_details AS a
                WHERE enrollment_id NOT IN (SELECT enrollment_id FROM referral_report)
                AND a.enrollment_child_num IN (SELECT enrollment_child_num FROM payment_status_details WHERE payment_for = 'SAIL Register Fee' AND payment_status = 'SUCCESS')
                AND a.enrollment_child_num IN (SELECT enrollment_id FROM sail_details WHERE (JSON_EXTRACT(is_coordinator1, '$.id') = $authID or JSON_EXTRACT(is_coordinator2, '$.id') = $authID))
                ORDER BY a.enrollment_id DESC");
            } else {
                $enrollment_details = DB::select("Select a.enrollment_id AS getID, a.child_name ,a.user_id, a.enrollment_child_num , a.enrollment_id from enrollment_details AS a
                WHERE enrollment_id NOT IN (SELECT enrollment_id FROM referral_report)
                AND a.enrollment_child_num IN (SELECT enrollment_child_num FROM payment_status_details WHERE payment_for = 'SAIL Register Fee' AND payment_status = 'SUCCESS')
                ORDER BY a.enrollment_id DESC");
            }

            $recommendations = DB::select("SELECT * FROM referral_recommendations where active_flag = 0");
            $specialization = DB::select("SELECT * FROM therapist_specialization where active_flag = 0");
            $response = [
                'recommendations' => $recommendations,
                'enrollment_details' => $enrollment_details,
                'specialization' => $specialization
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

    public function GetUser(Request $request)
    {
        try {
            $logMethod = 'Method => ReferralReportController => GetUser';
            $id = $request->requestData;

            $specialist = DB::select("SELECT * FROM therapist_specialization WHERE id = $id AND active_flag = 0");
            $specialization = $specialist[0]->specialization;
            // $this->WriteFileLog($specialization);

            $user = DB::select("SELECT * FROM service_provider 
            WHERE JSON_EXTRACT(area_of_specializtion, JSON_UNQUOTE(JSON_SEARCH(area_of_specializtion, 'one', '$specialization'))) IS NOT NULL;");
            // $user = DB::select('SELECT *
            // FROM service_provider
            // WHERE JSON_CONTAINS(JSON_EXTRACT(area_of_specializtion, "$.*"), '"Music Therapist"')');
            // $this->WriteFileLog($user);

            $serviceResponse = array();
            $serviceResponse['Code'] = config('setting.status_code.success');
            $serviceResponse['Message'] = config('setting.status_message.success');
            $serviceResponse['Data'] =  $user;
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

    public function storedata(Request $request)
    {
        try {
            $method = 'Method => MasterAssessmentreportController => storedata';
            $inputArray = $this->DecryptData($request->requestData);
            $input = [
                'state' => $inputArray['state'],
                'enrollmentId' => $inputArray['enrollmentId'],
                'meeting_description' => $inputArray['meeting_description'],
                'focus_area' => $inputArray['focus_area'],
                'referral_users' => $inputArray['referral_users'],
                'frequency' => $inputArray['frequency'],
                'recommendation_area' => $inputArray['recommendation_area'],
                'referral_users_other' => $inputArray['referral_users_other'],
                'focus_area_other' => $inputArray['focus_area_other'],
                'signature' => $inputArray['signature'],
                'dor' => $inputArray['dor'],
            ];


            $report_id = DB::transaction(function () use ($input) {
                $page_header =  DB::table('referral_report')
                    ->insertGetId([
                            'enrollment_id' => $input['enrollmentId'],
                            'status' => $input['state'],
                            'meeting_description' => $input['meeting_description'],
                            'signature' => json_encode($input['signature'], JSON_FORCE_OBJECT),
                            'created_by' => auth()->user()->id,
                            'created_date' => now(),
                            'dor' => $input['dor']
                        ]);

                $recommendation_area = $input['recommendation_area'];
                $focus_area = $input['focus_area'];
                $referral_users = $input['referral_users'];
                $frequency = $input['frequency'];
                $referral_users_other = $input['referral_users_other'];
                $focus_area_other = $input['focus_area_other'];

                foreach ($recommendation_area as $key => $value){
                    DB::table('referral_recommendations_final')->insertGetId([
                        'report_id' => $page_header,
                        'recomendation_id' => $key,
                        'recommendation' => $value,
                    ]);
                }

                foreach ($recommendation_area as $key => $value) {

                    $key_focus_area = $focus_area[$key];
                    $key_referral_users = $referral_users[$key];
                    $key_frequency = $frequency[$key];
                    $key_referral_users_other = $referral_users_other[$key];
                    $key_focus_area_other = $focus_area_other[$key];

                    $key_count = count($key_focus_area);
                    for ($i = 0; $i < $key_count; $i++) {
                        if($key_referral_users[$i] == 'other'){
                            $value_referral_users = $key_referral_users_other[$i];
                        }else{
                            $value_referral_users = $key_referral_users[$i];   
                        }
                        // $this->WriteFileLog($value_referral_users);exit;
                        DB::table('referral_report_details')->insertGetId([
                            'report_id' => $page_header,
                            'recommendation_area' => $key,
                            'focus_area' => $key_focus_area[$i],
                            'referral_users' => $value_referral_users,
                            'frequency' => $key_frequency[$i],
                            'focus_area_other' => $key_focus_area_other[$i],
                            'referral_users_other' => $key_referral_users_other[$i],
                            // 'created_by' => auth()->user()->id,
                            // 'created_date' => NOW()
                        ]);
                    }
                }

                // if ($input['state'] == 'Submitted') {
                //     $eId = $input['enrollmentId'];
                //     $en = DB::select("SELECT * FROM enrollment_details where enrollment_id = $eId");

                //     $admin_details = DB::SELECT("SELECT * from users where array_roles = '4'");
                //     $adminn_count = count($admin_details);
                //     if ($admin_details != []) {
                //         for ($j = 0; $j < $adminn_count; $j++) {

                //             DB::table('notifications')->insertGetId([
                //                 'user_id' =>  $admin_details[$j]->id,
                //                 'notification_type' => 'activity',
                //                 'notification_status' => 'Report Create',
                //                 'notification_url' => 'report/assessmentreport/edit/' . encrypt($page_header),
                //                 'megcontent' => "Assessment Report for " . $en[0]->child_name . " (" . $en[0]->enrollment_child_num . " ) has been Submitted",
                //                 'alert_meg' => "Assessment Report for " . $en[0]->child_name . " (" . $en[0]->enrollment_child_num . " ) has been Submitted",
                //                 'created_by' => auth()->user()->id,
                //                 'created_at' => NOW()
                //             ]);
                //         }
                //     }
                // }

                return $page_header;
            });

            $serviceResponse = array();
            $serviceResponse['Code'] = config('setting.status_code.success');
            $serviceResponse['Message'] = config('setting.status_message.success');
            $serviceResponse['Data'] = '1';
            if ($input['state'] == 'Submitted') {
                $serviceResponse['check'] = '0';
            } else {
                $serviceResponse['check'] = '1';
            }
            $serviceResponse['enrollmentId'] = $input['enrollmentId'];
            $serviceResponse['reports_id'] = $report_id;
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
        //echo "naa";exit;
        try {
            $method = 'Method => assessmentreportController => createdata';
            $id = $this->DecryptData($id);

            $report = DB::select("SELECT a.*,b.*,c.*,a.status as status FROM referral_report AS a INNER JOIN referral_report_details AS b ON a.id = b.report_id INNER JOIN enrollment_details AS c ON c.enrollment_id = a.enrollment_id WHERE a.id=$id");
            $recommendations = DB::select("SELECT * FROM referral_recommendations_final where active_flag = 0 and report_id = $id");
            $specialization = DB::select("SELECT * FROM therapist_specialization where active_flag = 0");
            $serviceProviders = DB::select("SELECT * FROM service_provider ");
            $rowSpan = DB::select("SELECT GROUP_CONCAT(recommendation_area) FROM referral_report_details WHERE report_id = $id");
            $email = DB::select("select * from email_preview where id = '16'");
            $response = [
                'report' => $report,
                'recommendations' => $recommendations,
                'specialization' => $specialization,
                'serviceProviders' => $serviceProviders,
                'rowSpan' => $rowSpan,
                'email' => $email[0]->email_body
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
            $method = 'Method => MasterAssessmentreportController => storedata';
            $inputArray = $this->DecryptData($request->requestData);
            $input = [
                'state' => $inputArray['state'],
                'enrollmentId' => $inputArray['enrollmentId'],
                'meeting_description' => $inputArray['meeting_description'],
                'focus_area' => $inputArray['focus_area'],
                'referral_users' => $inputArray['referral_users'],
                'frequency' => $inputArray['frequency'],
                'recommendation_area' => $inputArray['recommendation_area'],
                'report_id' => $inputArray['report_id'],
                'referral_users_other' => $inputArray['referral_users_other'],
                'focus_area_other' => $inputArray['focus_area_other'],
                'signature' => $inputArray['signature'],
                'dor' => $inputArray['dor'],
            ];


            $report_id = DB::transaction(function () use ($input) {

                $report_id = $input['report_id'];

                DB::table('referral_report')
                    ->where('id', $report_id)
                    ->update([
                        'status' => $input['state'],
                        'meeting_description' => $input['meeting_description'],
                        'dor' => $input['dor'],
                        'signature' => json_encode($input['signature'], JSON_FORCE_OBJECT),
                        // 'last_modified_by' => auth()->user()->id,
                        // 'last_modified_date' => NOW(),
                    ]);

                $recommendation_area = $input['recommendation_area'];
                $focus_area = $input['focus_area'];
                $referral_users = $input['referral_users'];
                $frequency = $input['frequency'];
                $referral_users_other = $input['referral_users_other'];
                $focus_area_other = $input['focus_area_other'];

                DB::table('referral_report_details')->where('report_id', $report_id)->delete();
                DB::table('referral_recommendations_final')->where('report_id', $report_id)->delete();
                
                foreach ($recommendation_area as $key => $value){
                    DB::table('referral_recommendations_final')->insertGetId([
                        'report_id' => $report_id,
                        'recomendation_id' => $key,
                        'recommendation' => $value,
                    ]);
                }
                
                foreach ($recommendation_area as $key => $value) {
                    
                    $key_focus_area = $focus_area[$key];$this->WriteFileLog('1');
                    $key_referral_users = $referral_users[$key];$this->WriteFileLog('2');
                    $key_frequency = $frequency[$key];$this->WriteFileLog('3');
                    $key_referral_users_other = $referral_users_other[$key];$this->WriteFileLog('4');
                    $key_focus_area_other = $focus_area_other[$key];$this->WriteFileLog('5');
                
                    $key_count = count($key_focus_area);
                    for ($i = 0; $i < $key_count; $i++) {
                        if($key_referral_users[$i] == 'other'){
                            $value_referral_users = $key_referral_users_other[$i];
                        }else{
                            $value_referral_users = $key_referral_users[$i];   
                        }
                        DB::table('referral_report_details')->insertGetId([
                            'report_id' => $report_id,
                            'recommendation_area' => $key,
                            'focus_area' => $key_focus_area[$i],
                            'referral_users' => $value_referral_users,
                            'frequency' => $key_frequency[$i],
                            'focus_area_other' => $key_focus_area_other[$i],
                            'referral_users_other' => $key_referral_users_other[$i],
                            // 'created_by' => auth()->user()->id,
                            // 'created_date' => NOW()
                        ]);
                    }
                }

                // if ($input['state'] == 'Submitted') {
                //     $eId = $input['enrollmentId'];
                //     $en = DB::select("SELECT * FROM enrollment_details where enrollment_id = $eId");

                //     $admin_details = DB::SELECT("SELECT * from users where array_roles = '4'");
                //     $adminn_count = count($admin_details);
                //     if ($admin_details != []) {
                //         for ($j = 0; $j < $adminn_count; $j++) {

                //             DB::table('notifications')->insertGetId([
                //                 'user_id' =>  $admin_details[$j]->id,
                //                 'notification_type' => 'activity',
                //                 'notification_status' => 'Report Create',
                //                 'notification_url' => 'report/assessmentreport/edit/' . encrypt($page_header),
                //                 'megcontent' => "Assessment Report for " . $en[0]->child_name . " (" . $en[0]->enrollment_child_num . " ) has been Submitted",
                //                 'alert_meg' => "Assessment Report for " . $en[0]->child_name . " (" . $en[0]->enrollment_child_num . " ) has been Submitted",
                //                 'created_by' => auth()->user()->id,
                //                 'created_at' => NOW()
                //             ]);
                //         }
                //     }
                // }

                return $report_id;
            });

            $serviceResponse = array();
            $serviceResponse['Code'] = config('setting.status_code.success');
            $serviceResponse['Message'] = config('setting.status_message.success');
            $serviceResponse['Data'] = '1';
            if ($input['state'] == 'Submitted') {
                $serviceResponse['check'] = '0';
            } else {
                $serviceResponse['check'] = '1';
            }
            $serviceResponse['enrollmentId'] = $input['enrollmentId'];
            $serviceResponse['reports_id'] = $report_id;
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

    public function send_report(Request $request)
    {
        try {
            $method = 'Method => assessmentreportController => send_report';
            $inputArray = $this->decryptData($request->requestData);
            $id = $inputArray['enrollmentId'];
            $ovm_report = $inputArray['ovm_report'];
            $email_content = $inputArray['email_content'];

            $getmail = DB::select("select * from enrollment_details WHERE enrollment_id='$id'");

            $data = array(
                'enrollmentId' => $id,
                'ovm_report' => $ovm_report,
                'child_name' => $getmail[0]->child_name,
                'email_content' => $email_content
            );

            $mail = $getmail[0]->child_contact_email;
            $idd = $getmail[0]->enrollment_id;
            Mail::to($mail)->send(new SendReferralReport($data));

            $getreport = DB::select("SELECT * FROM referral_report WHERE enrollment_id = $idd");

            DB::table('referral_report')
                ->where('id', $getreport[0]->id)
                ->update([
                    'status' => 'Published',
                ]);

            DB::table('notifications')->insertGetId([
                'user_id' => $getmail[0]->user_id,
                'notification_type' => 'activity',
                'notification_status' => 'Sail',
                'notification_url' =>  $inputArray['notification'],
                'megcontent' => "Dear " . $getmail[0]->child_name . " Referral Report has been Generated.",
                'alert_meg' => "Dear " . $getmail[0]->child_name . " Referral Report has been Generated.",
                'created_by' => auth()->user()->id,
                'created_at' => NOW()
            ]);

            $this->sail_status_log('reports_copy', $getreport[0]->id, 'Referral Report Sent', 'Sail Status', auth()->user()->id, NOW(), $getmail[0]->enrollment_child_num);

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

    public function referral_accept(Request $request, $id)
    {

        $inputArray = $this->decryptData($request->requestData);

        $id = $inputArray['user_id'];
        $action = $inputArray['action'];
       
        $enrollment = DB::select("SELECT * FROM enrollment_details WHERE child_contact_email = '$id'");
        $enrollment_child_num = $enrollment[0]->enrollment_child_num;
        $sail = DB::select("SELECT JSON_EXTRACT(is_coordinator1, '$.id') AS coID ,JSON_EXTRACT(is_coordinator1, '$.name') AS coordinator_name1, JSON_EXTRACT(is_coordinator1, '$.email') AS coordinator_email1,JSON_EXTRACT(is_coordinator2, '$.id') AS coID2 ,JSON_EXTRACT(is_coordinator2, '$.name') AS coordinator_name2, JSON_EXTRACT(is_coordinator2, '$.email') AS coordinator_email2, id FROM sail_details WHERE enrollment_id = '$enrollment_child_num'");
       
        if ($action == 'Denial') {
            $actionNotification = 'denied';
            $satusLog = 'Denied';
        } else {
            $actionNotification = 'requested';
            $satusLog = 'Requested';
        }
       
        DB::table('notifications')->insertGetId([
            'user_id' =>  $sail[0]->coID,
            'notification_type' => 'activity',
            'notification_status' => 'Updated',
            'notification_url' => 'referralreport',
            'megcontent' => 'Parent ' . $enrollment[0]->child_name . " (" . $enrollment[0]->enrollment_child_num . ") has " . $actionNotification . " for Referral Report",
            'alert_meg' => 'Parent ' . $enrollment[0]->child_name . " (" . $enrollment[0]->enrollment_child_num . ") has " . $actionNotification . " for Referral Report",
            'created_by' => $enrollment[0]->user_id,
            'created_at' => NOW()
        ]);
       
        
  
    $c1=$sail[0]->coID;
  
  $co1=DB::select("SELECT email,name FROM users WHERE id ='$c1'");
  $coordinator1Data = $co1[0]->name;
       
    
        $childName = $enrollment[0]->child_name;
        
        $currentDate = now()->toDateString();
        
        $data = array(
            'coordinatorName' => $coordinator1Data,
            'childName' => $childName,
            'date' => $currentDate
        );
        $this->WriteFileLog($data);
      
        // Mail to Coordinator 1
        Mail::to($co1[0]->email)->send(new ReferralRespondMail([$data]));
      
        $c2=$sail[0]->coID2;
        $co2=DB::select("SELECT email,name FROM users WHERE id ='$c2'");
        $coordinator2Data = $co2[0]->name;
        $data1 = array(
            'coordinatorName1' => $coordinator2Data,
            'childName' => $childName,
            'date' => $currentDate
        );    
       
        // Mail to Coordinator 2
      
       
        Mail::to($co2[0]->email)->send(new ReferralRespondMail2([$data1]));
        
        DB::table('notifications')->insertGetId([
            'user_id' =>  $sail[0]->coID2,
            'notification_type' => 'activity',
            'notification_status' => 'Updated',
            'notification_url' => 'referralreport',
            'megcontent' => 'Parent ' . $enrollment[0]->child_name . " (" . $enrollment[0]->enrollment_child_num . ") has " . $actionNotification . " for Referral Report",
            'alert_meg' => 'Parent ' . $enrollment[0]->child_name . " (" . $enrollment[0]->enrollment_child_num . ") has " . $actionNotification . " for Referral Report",
            'created_by' => $enrollment[0]->user_id,
            'created_at' => NOW()
        ]);

        $admin_details = DB::SELECT("SELECT * from users where array_roles = '4'");
        $adminn_count = count($admin_details);
        if ($admin_details != []) {
            for ($j = 0; $j < $adminn_count; $j++) {
                DB::table('notifications')->insertGetId([
                    'user_id' =>  $admin_details[$j]->id,
                    'notification_type' => 'activity',
                    'notification_status' => 'Updated',
                    'notification_url' => 'referralreport',
                    'megcontent' => 'Parent ' . $enrollment[0]->child_name . " (" . $enrollment[0]->enrollment_child_num . ") has " . $actionNotification . " for Referral Report",
                    'alert_meg' => 'Parent ' . $enrollment[0]->child_name . " (" . $enrollment[0]->enrollment_child_num . ") has " . $actionNotification . " for Referral Report",
                    'created_by' => $enrollment[0]->user_id,
                    'created_at' => NOW()
                ]);
            }
        }
        $this->WriteFileLog($data1);
        $this->sail_status_log('sail_details', $sail[0]->id, $satusLog . ' for Referral Report', 'Sail Status', $enrollment[0]->user_id, NOW(), $enrollment[0]->enrollment_child_num);
        $this->WriteFileLog($satusLog);
        $serviceResponse = array();
        $serviceResponse['Code'] = config('setting.status_code.success');
        $serviceResponse['Message'] = config('setting.status_message.success');
        $serviceResponse['Data'] = 1;
        $serviceResponse = json_encode($serviceResponse, JSON_FORCE_OBJECT);
        $sendServiceResponse = $this->SendServiceResponse($serviceResponse, config('setting.status_code.success'), true);
        return $sendServiceResponse;
    }
}
