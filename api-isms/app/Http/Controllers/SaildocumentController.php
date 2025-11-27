<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Mail\QuestionnaireMail;
use App\Mail\PF_QuestionnaireMail;
use App\Mail\sailconsentmail;
use App\Mail\sailconsentAdmin;
use App\Mail\SailAdminUpdate;
use App\Mail\SailEmailAccept;
use Illuminate\Support\Carbon;

class SaildocumentController extends BaseController
{

    public function index(Request $request)
    {
        try {


            $method = 'Method => SaildocumentController => index';
            $authID = auth()->user()->id;

            $role_name = DB::select("SELECT role_name FROM uam_roles AS ur INNER JOIN users us ON (us.array_roles=ur.role_id) WHERE us.id=" . auth()->user()->id);
            $role_name_fetch = $role_name[0]->role_name;
            $rolesArray = array_merge(array(auth()->user()->array_roles), array(auth()->user()->roles));
            if (in_array(4, $rolesArray)) {
                $rows = DB::select("SELECT que.status AS questatus, en.enrollment_child_num , en.child_name , qud.questionnaire_name , viewed_users , questionnaire_initiation_id FROM questionnaire_initiation AS que 
                INNER JOIN questionnaire AS qud ON que.questionnaire_id = qud.questionnaire_id
                INNER JOIN enrollment_details AS en on en.enrollment_id=que.enrollment_id WHERE que.activeflag=0 AND qud.questionnaire_type = 'OVM' ORDER BY que.questionnaire_initiation_id DESC");
            } else {
                $rows = DB::select("SELECT que.status AS questatus, en.enrollment_child_num , en.child_name , qud.questionnaire_name , viewed_users , questionnaire_initiation_id FROM questionnaire_initiation AS que 
                INNER JOIN questionnaire AS qud ON que.questionnaire_id = qud.questionnaire_id
                INNER JOIN enrollment_details AS en on en.enrollment_id=que.enrollment_id 
                INNER JOIN ovm_allocation AS oa ON oa.enrollment_id = en.enrollment_id
                WHERE que.activeflag=0 AND qud.questionnaire_type = 'OVM' 
                AND (oa.is_coordinator1 = $authID OR oa.is_coordinator2 = $authID)
                ORDER BY que.questionnaire_initiation_id DESC");
            }
            $submitted = DB::select("SELECT * FROM questionnaire_initiation AS qi
            INNER JOIN question_process AS qp ON qp.questionnaire_initiation_id=qi.questionnaire_initiation_id
            WHERE qp.progress_status='submit'");

            $response = [
                'rows' => $rows,
                'submitted' => $submitted
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

    public function sailstatus(Request $request)
    {
        try {
            $method = 'Method => SaildocumentController => sailstatus';
            $authID = auth()->user()->id;
            $role_name = DB::select("SELECT role_name FROM uam_roles AS ur INNER JOIN users us ON (us.array_roles=ur.role_id) WHERE us.id=" . auth()->user()->id);
            $role_name_fetch = $role_name[0]->role_name;
            $rolesArray = array_merge(array(auth()->user()->array_roles), array(auth()->user()->roles));
            if (in_array(4, $rolesArray)) {
                $rows = DB::select("SELECT * FROM sail_details AS a
                INNER JOIN enrollment_details AS b ON a.enrollment_id=b.enrollment_child_num
                WHERE a.active_flag=0 ORDER BY a.last_modified_date DESC ");
                $actions = DB::select("SELECT * FROM sail_details AS sd
                INNER JOIN sail_status_logs AS b ON sd.enrollment_id = b.enrollment_id
                ORDER BY b.id DESC ");
            } else {
                $rows = DB::select("SELECT * FROM sail_details AS a
                INNER JOIN enrollment_details AS b ON a.enrollment_id=b.enrollment_child_num
                WHERE a.active_flag=0 AND (JSON_EXTRACT(is_coordinator1, '$.id') = $authID or JSON_EXTRACT(is_coordinator2, '$.id') = $authID) ORDER BY a.id DESC ");
                $actions = DB::select("SELECT * FROM sail_details AS sd
                INNER JOIN sail_status_logs AS b ON sd.enrollment_id = b.enrollment_id WHERE (JSON_EXTRACT(is_coordinator1, '$.id') = $authID or JSON_EXTRACT(is_coordinator2, '$.id') = $authID)
                ORDER BY b.id DESC ");
            }


            $response = [
                'rows' => $rows,
                'actions' => $actions
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

    public function questionnaireinitiate(Request $request)
    {
        try {


            $method = 'Method => SaildocumentController => questionnaireinitiate';

            $authID = auth()->user()->id;
            $rows = array();

            $role_name = DB::select("SELECT role_name FROM uam_roles AS ur INNER JOIN users us ON (us.array_roles=ur.role_id) WHERE us.id=" . auth()->user()->id);
            $role_name_fetch = $role_name[0]->role_name;

            if ($role_name_fetch == 'IS Coordinator') {
                $rows['questionnaire_initiation'] = DB::select("SELECT a.enrollment_id , a.enrollment_child_num , a.child_name from enrollment_details AS a
                INNER JOIN ovm_allocation AS b ON a.enrollment_id=b.enrollment_id
                WHERE a.enrollment_child_num IN 
                (SELECT ovm2.enrollment_id FROM ovm_meeting_details AS ovm1 
                INNER JOIN ovm_meeting_2_details AS ovm2 ON ovm1.enrollment_id=ovm2.enrollment_id
                WHERE ovm2.meeting_status = 'Completed') 
                AND a.enrollment_id NOT IN (SELECT enrollment_id FROM questionnaire_initiation)
                AND (b.is_coordinator1 = $authID OR b.is_coordinator2 = $authID)
                ORDER BY a.enrollment_id DESC");
            } else {
                $rows['questionnaire_initiation'] = DB::select("select enrollment_id , enrollment_child_num , child_name from enrollment_details
                WHERE enrollment_child_num IN 
                (SELECT ovm2.enrollment_id FROM ovm_meeting_details AS ovm1 
                INNER JOIN ovm_meeting_2_details AS ovm2 ON ovm1.enrollment_id=ovm2.enrollment_id
                WHERE ovm2.meeting_status = 'Completed') 
                AND enrollment_id NOT IN (SELECT enrollment_id FROM questionnaire_initiation)
                ORDER BY enrollment_id DESC");
            }

            $rows['questionnaire'] = DB::select("SELECT * FROM questionnaire WHERE questionnaire_id NOT IN (SELECT ques.questionnaire_id  FROM questionnaire AS ques inner JOIN questionnaire_details AS qud ON ques.questionnaire_id= qud.questionnaire_id
            INNER JOIN questionnaire_initiation AS qi ON qud.questionnaire_id = qi.questionnaire_id)");
            $paymenttokentime = DB::Select("select token_expire_time from token_paremeterisation where token_process='Payment'");



            $response = [
                'rows' => $rows,
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
    public function sailquestionnaireinitiate(Request $request)
    {
        try {


            $method = 'Method => SaildocumentController => questionnaireinitiate';

            $authId = auth()->user()->id;
            $rows = array();
            $rows['rows'] = DB::select("SELECT que.status AS questatus, que.*,qud.*,en.* FROM questionnaire_initiation AS que 
            INNER JOIN questionnaire AS qud ON que.questionnaire_id = qud.questionnaire_id
            INNER JOIN enrollment_details AS en on en.enrollment_id=que.enrollment_id WHERE que.activeflag='2' ORDER BY que.questionnaire_initiation_id DESC");

            $role_name = DB::select("SELECT role_name FROM uam_roles AS ur INNER JOIN users us ON (us.array_roles=ur.role_id) WHERE us.id=" . auth()->user()->id);
            $role_name_fetch = $role_name[0]->role_name;

            if ($role_name_fetch == 'IS Coordinator') {
                $rows['questionnaire_initiation'] = DB::select("SELECT a.* FROM enrollment_details AS a INNER JOIN sail_details AS b ON b.enrollment_id=a.enrollment_child_num
                WHERE a.Enrollment_id IN (SELECT Enrollment_id FROM activity_initiation) 
                AND a.Enrollment_id NOT IN (SELECT enrollment_id FROM reports_copy where report_type = 7) 
                AND (JSON_EXTRACT(is_coordinator1, '$.id') = $authId OR JSON_EXTRACT(is_coordinator2, '$.id') = $authId)
                ORDER BY a.Enrollment_id DESC");
            } else {
                $rows['questionnaire_initiation'] = DB::select("SELECT * FROM enrollment_details WHERE Enrollment_id IN (SELECT Enrollment_id FROM activity_initiation)
                AND Enrollment_id NOT IN (SELECT enrollment_id FROM reports_copy where report_type = 7) ORDER BY Enrollment_id DESC ");
            }

            $rows['questionnaire'] = DB::select("SELECT * FROM questionnaire order by `order_id` ");
            $paymenttokentime = DB::Select("select token_expire_time from token_paremeterisation where token_process='Payment'");
            $activity = DB::select('select * from activity WHERE activity_id IN (SELECT activity_id FROM activity_initiation)
            and active_flag=0');


            $response = [
                'rows' => $rows,
                'paymenttokentime' => $paymenttokentime,
                'activity' => $activity,
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
    public function questionnaireindex(Request $request)
    {
        try {
            $method = 'Method => SaildocumentController => questionnaireindex';

            $authID = auth()->user()->id;
            $role_name = DB::select("SELECT role_name FROM uam_roles AS ur INNER JOIN users us ON (us.array_roles=ur.role_id) WHERE us.id=" . auth()->user()->id);
            $role_name_fetch = $role_name[0]->role_name;
            $rolesArray = array_merge(array(auth()->user()->array_roles), array(auth()->user()->roles));
            if (in_array(4, $rolesArray)) {
                $rows = DB::select("SELECT que.status AS questatus, en.enrollment_child_num , en.child_name , questionnaire_name , viewed_users , questionnaire_initiation_id , que.questionnaire_id FROM questionnaire_initiation AS que 
                INNER JOIN questionnaire AS qud ON que.questionnaire_id = qud.questionnaire_id
                INNER JOIN enrollment_details AS en on en.enrollment_id=que.enrollment_id WHERE que.activeflag=0 AND qud.questionnaire_type = 'SAIL' ORDER BY que.questionnaire_initiation_id DESC");
            } else {
                $rows = DB::select("SELECT que.status AS questatus , en.enrollment_child_num , en.child_name , questionnaire_name , viewed_users , questionnaire_initiation_id , que.questionnaire_id FROM questionnaire_initiation AS que 
                INNER JOIN questionnaire AS qud ON que.questionnaire_id = qud.questionnaire_id INNER JOIN enrollment_details AS en on en.enrollment_id=que.enrollment_id 
                INNER JOIN sail_details AS sd ON sd.enrollment_id=en.enrollment_child_num WHERE que.activeflag=0 AND qud.questionnaire_type = 'SAIL' 
                AND (JSON_EXTRACT(sd.is_coordinator1, '$.id') = $authID or JSON_EXTRACT(sd.is_coordinator2, '$.id') = $authID) ORDER BY que.questionnaire_initiation_id DESC");
            }

            $response = [
                'rows' => $rows,
                // 'submitted' => $submitted
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
            $method = 'Method => SaildocumentController => storedata';
            $inputArray = $this->decryptData($request->requestData);

            $input = [
                'enrollment_id' => $inputArray['enrollment_id'],
                'child_id' => $inputArray['child_id'],
                'child_name' => $inputArray['child_name'],
                'questionnaire_id' => $inputArray['questionnaire_id'],
                'status' => $inputArray['status'],
                'type' => $inputArray['type'],
                'initiatedTo' => $inputArray['initiatedTo'],
                'stage' => $inputArray['stage'],
                // 'url' => $inputArray['url']
            ];


            $sail_meeting = DB::table('questionnaire_initiation')
                ->insertGetId([
                    'enrollment_id' => $input['enrollment_id'],
                    'questionnaire_id' => $input['questionnaire_id'],
                    'status' => $input['type'],
                    'created_date' => now(),
                    'created_by' => auth()->user()->id,
                    'activeflag' => '0',
                ]);

            $sail_meeting1 = array();
            $sail_meeting1[] = $sail_meeting;

            $currentStatus = $input['type'];
            $role_name = DB::select("SELECT role_name FROM uam_roles AS ur INNER JOIN users us ON (us.array_roles=ur.role_id) WHERE us.id=" . auth()->user()->id);
            $role_name_fetch = $role_name[0]->role_name;

            $this->auditLog('questionnaire_initiation', $sail_meeting, $currentStatus, 'New Questionnaire Initiation', auth()->user()->id, NOW(), $role_name_fetch);

            if ($currentStatus == 'Sent') {
                DB::table('notifications')->insertGetId([
                    'user_id' => $input['initiatedTo'],
                    'notification_type' => 'Questionnaire',
                    'notification_status' => 'Questionnaire Initiation',
                    'notification_url' => 'questionnaire/form/editdata/' . encrypt($sail_meeting),
                    'megcontent' => " Parent Feedback Form sent to you",
                    'alert_meg' => "Parent Feedback Form sent to you",
                    'created_by' => auth()->user()->id,
                    'created_at' => NOW()
                ]);
            }

            $ff = $input['enrollment_id'];
            $en = DB::select("SELECT enrollment_child_num FROM enrollment_details WHERE enrollment_id=$ff");
            $en_ch_id = $en[0]->enrollment_child_num;
            $alloc = DB::select("SELECT JSON_EXTRACT(is_coordinator1, '$.id') AS co1 , JSON_EXTRACT(is_coordinator2, '$.id') AS co2 FROM ovm_meeting_details WHERE enrollment_id = '$en_ch_id'");

            $quesDetails = DB::select("SELECT * FROM questionnaire AS a INNER JOIN questionnaire_initiation AS b ON b.questionnaire_id=a.questionnaire_id
			WHERE b.questionnaire_initiation_id = $sail_meeting");

            $admin_details = DB::SELECT("SELECT * from users where array_roles = '4'");
            $adminn_count = count($admin_details);
            $stage = $input['stage'];
            if ($stage == 'ovm') {
                $redirect = 'ovm/questionnaire';
            } else {
                $redirect = 'sailquestionnairelistview';
            }

            if ($admin_details != []) {
                for ($j = 0; $j < $adminn_count; $j++) {

                    DB::table('notifications')->insertGetId([
                        'user_id' =>  $admin_details[$j]->id,
                        'notification_type' => 'Questionnaire',
                        'notification_status' => 'Questionnaire Initiation',
                        'notification_url' => $redirect,
                        'megcontent' => $quesDetails[0]->questionnaire_name . " has been Initiated for " . $input['child_name'] . " (" . $en[0]->enrollment_child_num . ")",
                        'alert_meg' => $quesDetails[0]->questionnaire_name . " has been Initiated for " . $input['child_name'] . " (" . $en[0]->enrollment_child_num . ")",
                        'created_by' => auth()->user()->id,
                        'created_at' => NOW()
                    ]);
                }
            }

            DB::table('notifications')->insertGetId([
                'user_id' =>  $alloc[0]->co1,
                'notification_type' => 'Questionnaire',
                'notification_status' => 'Questionnaire Initiation',
                'notification_url' => $redirect,
                'megcontent' => $quesDetails[0]->questionnaire_name . " has been Initiated for " . $input['child_name'] . " (" . $en[0]->enrollment_child_num . ")",
                'alert_meg' => $quesDetails[0]->questionnaire_name . " has been Initiated for " . $input['child_name'] . " (" . $en[0]->enrollment_child_num . ")",
                'created_by' => auth()->user()->id,
                'created_at' => NOW()
            ]);
            DB::table('notifications')->insertGetId([
                'user_id' =>  $alloc[0]->co2,
                'notification_type' => 'Questionnaire',
                'notification_status' => 'Questionnaire Initiation',
                'notification_url' => $redirect,
                'megcontent' => $quesDetails[0]->questionnaire_name . " has been Initiated for " . $input['child_name'] . " (" . $en[0]->enrollment_child_num . ")",
                'alert_meg' => $quesDetails[0]->questionnaire_name . " has been Initiated for " . $input['child_name'] . " (" . $en[0]->enrollment_child_num . ")",
                'created_by' => auth()->user()->id,
                'created_at' => NOW()
            ]);
            $response = [
                'initiatedTo' =>  $input['initiatedTo'],
                'questionnaireID' => $sail_meeting1
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

    public function sail_storedata(Request $request)
    {

        try {
            $method = 'Method => SaildocumentController => sail_storedata';
            $inputArray = $this->decryptData($request->requestData);

            $input = [
                'enrollment_id' => $inputArray['enrollment_id'],
                'child_id' => $inputArray['child_id'],
                'child_name' => $inputArray['child_name'],
                'questionnaire_id' => $inputArray['questionnaire_id'],
                'status' => $inputArray['status'],
                'type' => $inputArray['type'],
                'initiatedTo' => $inputArray['initiatedTo'],
                'activity_id' => $inputArray['activity_id'],
                'activity_discription' => $inputArray['activity_discription'],
                // 'url' => $inputArray['url']
            ];
            // $this->WriteFileLog($input);
            $ques_Initialization = array();
            $questionnaire_id = $input['questionnaire_id'];
            $que_count = count($questionnaire_id);
            // $this->WriteFileLog($que_count);
            for ($jj = 0; $jj < $que_count; $jj++) {
                $sail_meeting = DB::table('questionnaire_initiation')
                    ->insertGetId([
                        'enrollment_id' => $input['enrollment_id'],
                        'questionnaire_id' => $questionnaire_id[$jj],
                        'status' => $input['type'],
                        'activity' => $input['activity_id'],
                        'activity_discription' => $input['activity_discription'],
                        'created_date' => now(),
                        'created_by' => auth()->user()->id,
                        'activeflag' => '0',
                    ]);
                $ques_Initialization[$jj] = $sail_meeting;

                $currentStatus = $input['type'];
                $role_name = DB::select("SELECT role_name FROM uam_roles AS ur INNER JOIN users us ON (us.array_roles=ur.role_id) WHERE us.id=" . auth()->user()->id);
                $role_name_fetch = $role_name[0]->role_name;

                $this->auditLog('questionnaire_initiation', $sail_meeting, $currentStatus, 'New Questionnaire Initiation', auth()->user()->id, NOW(), $role_name_fetch);
                $initiationID = $questionnaire_id[$jj];
                $quesDetails = DB::select("SELECT * FROM questionnaire AS a
                INNER JOIN questionnaire_initiation AS b ON b.questionnaire_id=a.questionnaire_id
                WHERE a.questionnaire_id = $initiationID");

                $ff = $input['enrollment_id'];
                $en = DB::select("SELECT enrollment_child_num FROM enrollment_details WHERE enrollment_id=$ff");

                if ($currentStatus == 'Sent') {
                    DB::table('notifications')->insertGetId([
                        'user_id' => $input['initiatedTo'],
                        'notification_type' => 'Questionnaire',
                        'notification_status' => 'Questionnaire Initiation',
                        'notification_url' => 'questionnaire/form/editdata/' . encrypt($sail_meeting),
                        'megcontent' => $quesDetails[0]->questionnaire_name . " Questionnaire has been Initiated for " . $input['child_name'] . " (" . $en[0]->enrollment_child_num . ")",
                        'alert_meg' => $quesDetails[0]->questionnaire_name . " Questionnaire has been Initiated for " . $input['child_name'] . " (" . $en[0]->enrollment_child_num . ")",
                        'created_by' => auth()->user()->id,
                        'created_at' => NOW()
                    ]);
                }


                $admin_details = DB::SELECT("SELECT * from users where array_roles = '4' or array_roles = '5'");
                $adminn_count = count($admin_details);
                if ($admin_details != []) {
                    for ($j = 0; $j < $adminn_count; $j++) {

                        // DB::table('notifications')->insertGetId([
                        //     'user_id' =>  $admin_details[$j]->id,
                        //     'notification_type' => 'Questionnaire',
                        //     'notification_status' => 'Questionnaire Initiation',
                        //     'notification_url' => 'questionnaire/form/editdata/' . encrypt($sail_meeting),
                        //     'megcontent' => "User " . $input['child_name'] . " Questionnaire has been Initiated",
                        //     'alert_meg' => "User " . $input['child_name'] . " Questionnaire has been Initiated",
                        //     'created_by' => auth()->user()->id,
                        //     'created_at' => NOW()
                        // ]);

                        DB::table('notifications')->insertGetId([
                            'user_id' =>  $admin_details[$j]->id,
                            'notification_type' => 'Questionnaire',
                            'notification_status' => 'Questionnaire Initiation',
                            'notification_url' => 'questionnaire/form/editdata/' . encrypt($sail_meeting),
                            'megcontent' => $quesDetails[0]->questionnaire_name . " Questionnaire has been Initiated for " . $input['child_name'] . " (" . $en[0]->enrollment_child_num . ")",
                            'alert_meg' => $quesDetails[0]->questionnaire_name . " Questionnaire has been Initiated for " . $input['child_name'] . " (" . $en[0]->enrollment_child_num . ")",
                            'created_by' => auth()->user()->id,
                            'created_at' => NOW()
                        ]);
                    }
                }
            }
            $response = [
                'initiatedTo' =>  $input['initiatedTo'],
                'questionnaireID' => $ques_Initialization
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

            $method = 'Method => SaildocumentController => data_edit';


            $id = $this->DecryptData($id);


            $rows = DB::select("SELECT * FROM questionnaire_initiation AS ques INNER JOIN enrollment_details AS qud ON ques.enrollment_id=qud.enrollment_id INNER JOIN 
            questionnaire AS question ON question.questionnaire_id=ques.questionnaire_id WHERE ques.questionnaire_initiation_id=$id");


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

            $method = 'Method =>  SaildocumentController => updatedata';

            $inputArray = $this->decryptData($request->requestData);

            $input = [
                'id' => $inputArray['id'],
                'questionnaire_id' => $inputArray['questionnaire_id'],
                'status' => $inputArray['status'],
                'user_id' => $inputArray['user_id'],
            ];
            DB::transaction(function () use ($input) {

                DB::table('questionnaire_initiation')
                    ->where('questionnaire_initiation_id', $input['id'])
                    ->update([

                        'questionnaire_id' => $input['questionnaire_id'],
                        'status' => $input['status'],
                        'created_by' => auth()->user()->id,
                        'created_date' => NOW()

                    ]);

                $role_name = DB::select("SELECT role_name FROM uam_roles AS ur INNER JOIN users us ON (us.array_roles=ur.role_id) WHERE us.id=" . auth()->user()->id);
                $role_name_fetch = $role_name[0]->role_name;

                $this->auditLog('questionnaire_initiation', $input['questionnaire_id'], $input['status'], 'Questionnaire Initiation Updated', auth()->user()->id, NOW(), $role_name_fetch);
            });

            $currentStatus = $input['status'];
            $idd = $input['user_id'];
            $QI = DB::select("SELECT * FROM enrollment_details WHERE user_id=$idd");
            $ch = $QI[0]->child_name;
            if ($currentStatus == 'Submitted') {
                DB::table('notifications')->insertGetId([
                    'user_id' => $input['user_id'],
                    'notification_type' => 'Questionnaire',
                    'notification_status' => 'Questionnaire Initiation',
                    'notification_url' => 'questionnaire/form/editdata/' . encrypt($input['questionnaire_id']),
                    'megcontent' => "Feedback Form received from the Parent" . $QI[0]->child_name . "(" . $QI[0]->child_id . ")",
                    'alert_meg' => "Feedback Form received from the Parent" . $QI[0]->child_name . "(" . $QI[0]->child_id . ")",
                    'created_by' => auth()->user()->id,
                    'created_at' => NOW()
                ]);
            }

            $response = [
                'initiatedTo' =>  $idd,
                'questionnaireID' => $input['questionnaire_id']
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

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function data_delete($id)
    {

        try {


            $method = 'Method =>SaildocumentController => data_delete';

            $id = $this->decryptData($id);




            $check = DB::select("select * from questionnaire_initiation where questionnaire_initiation_id = '$id' and activeflag = '0'");

            if ($check !== []) {

                // $this->WriteFileLog($check);
                DB::table('questionnaire_initiation')
                    ->where('questionnaire_initiation_id', $id)
                    ->update([
                        'activeflag' => 1,

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
        $logMethod = 'Method => SaildocumentController => GetAllDepartmentsByDirectorate';
        try {
            // $this->WriteFileLog('GetAllDepartmentsByDirectorate');
            $inputArray = $request->requestData;
            // $this->WriteFileLog($inputArray);

            // $input = [
            // 	'enrollment_child_num' => $inputArray['enrollment_child_num'],

            // ];


            // $this->WriteFileLog($input);
            $enrollmentID = DB::select("select * from enrollment_details where enrollment_id = '$inputArray'");

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

    public function CreatSignedURL(Request $request)
    {
        try {
            $method = 'Method => SaildocumentController => CreatSignedURL';

            $tokentime = DB::Select("select token_expire_time from token_paremeterisation where token_process='Payment'");
            $response = [
                'tokentime' => $tokentime
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

            $rows = DB::select('select child_contact_email from enrollment_details');

            $emails = DB::select('select email from users where id=' . $id);

            $email = $emails[0]->email;

            // $email = DB::select("select email from users where email='$email'");
            // $this->WriteFileLog($id);
            // $en = $email->child_contact_email;

            $enrollment = DB::select("select * from payment_status_details INNER JOIN 
                  users ON payment_status_details.initiated_to = users.email
                  where users.id ='$id'");
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

    public function CreatSignedEmail(Request $request)
    {
        try {
            $method = 'Method => SaildocumentController => CreatSignedEmail';
            $decryArray = $request->requestData;
            $url = $decryArray['url'];
            $id = $decryArray['id'];
            $queArray = $decryArray['queArray'];
            $emailArray = DB::select("SELECT * FROM users WHERE id = $id");
            $email = $emailArray[0]->email;
            $urlcount = count($url);

            $senddata = array();

            for ($i = 0; $i < $urlcount; $i++) {
                $qID = $queArray[$i];
                $name = DB::select("SELECT que.questionnaire_id , que.questionnaire_name FROM questionnaire_initiation AS qi 
                INNER JOIN questionnaire AS que ON que.questionnaire_id=qi.questionnaire_id WHERE qi.questionnaire_initiation_id = $qID");
                if ($name[0]->questionnaire_id == 1) {
                    $pfUrl = $url[$i];
                    Mail::to($email)->send(new PF_QuestionnaireMail($pfUrl));
                } else {
                    $n = $name[0]->questionnaire_name;
                    $senddata[$n] = $url[$i];
                }
            }
            if (!empty($senddata)) {
                Mail::to($email)->send(new QuestionnaireMail($senddata));
            }

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

    public function SailInitiate(Request $request)
    {
        try {
            $method = 'Method => SaildocumentController => SailInitiate';
            // $this->WriteFileLog($method);
            $rows = DB::select("SELECT ed.* from enrollment_details AS ed 
            INNER JOIN ovm_meeting_details AS omd ON omd.enrollment_id=ed.enrollment_child_num
            INNER JOIN ovm_meeting_2_details AS omd2 ON omd2.enrollment_id=omd.enrollment_id
            WHERE omd2.meeting_status='Completed' AND omd.meeting_status='Completed' AND ed.enrollment_child_num 
			IN (SELECT enrollment_id FROM sail_details WHERE active_flag=0 AND consent_aggrement = 'Rejected') ORDER BY ed.Enrollment_id DESC");

            $iscoordinators = DB::select("SELECT * from users
                right JOIN uam_user_roles ON uam_user_roles.user_id=users.id
                right JOIN uam_roles on uam_roles.role_id = uam_user_roles.role_id
                WHERE uam_roles.role_name='IS Coordinator' AND users.active_flag=0");

            $response = [
                'rows' => $rows,
                'iscoordinators' => $iscoordinators
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

    public function SailInitiateStore(Request $request)
    {
        try {
            $method = 'Method => SaildocumentController => SailInitiateStore';
            $inputArray = $this->decryptData($request->requestData);

            $is_coordinator1 = $inputArray['is_coordinator1'];
            $is_coordinator1 = DB::select("Select id,email,name from users where id= $is_coordinator1");

            $is_coordinator2 = $inputArray['is_coordinator2'];
            $is_coordinator2 = DB::select("Select id,email,name from users where id= $is_coordinator2");

            $is_coordinator1name = $is_coordinator1[0]->name;
            $is_coordinator1email = $is_coordinator1[0]->email;

            $is_coordinator2name = $is_coordinator2[0]->name;
            $is_coordinator2email = $is_coordinator2[0]->email;

            $enNum = $inputArray['enrollment_child_num'];
            $co = DB::Select("SELECT * FROM ovm_meeting_details WHERE enrollment_id='$enNum'");

            $is_coordinator1json = json_encode($is_coordinator1[0], JSON_FORCE_OBJECT);
            $is_coordinator2json = json_encode($is_coordinator2[0], JSON_FORCE_OBJECT);

            $enrollment_id = $inputArray['enrollment_child_num'];

            $input = [
                'enrollment_child_num' => $inputArray['enrollment_child_num'],
                'enrollment_id' => $inputArray['enrollment_id'],
                'child_id' => $inputArray['child_id'],
                'is_coordinator1' => $is_coordinator1json,
                'is_coordinator2' => $is_coordinator2json,
                'child_name' => $inputArray['child_name'],
                'user_id' => $inputArray['user_id'],
                'consent_form' => $inputArray['consent_form'],
                'notification' => $inputArray['notification']
            ];



            // $user_id = $input['user_id'];

            $user_check = DB::select("select * from sail_details where enrollment_id = '$enrollment_id' and active_flag = 0");

            // if ($user_check == []) {

            $response1 = DB::transaction(function () use ($input, $inputArray, $is_coordinator1email, $is_coordinator2email, $user_check) {

                // $ovm_meeting = DB::table('sail_details')
                //     ->insertGetId([
                //         'enrollment_id' => $input['enrollment_child_num'],
                //         'child_id' => $input['child_id'],
                //         'is_coordinator1' => $input['is_coordinator1'],
                //         'child_name' => $input['child_name'],
                //         'current_status' => 'Initiated',
                //         'user_id' => $input['user_id'],
                //         'created_by' => auth()->user()->id,
                //         'created_date' => now(),
                //         'last_modified_by' => auth()->user()->id,
                //         'last_modified_date' => now()
                //     ]);

                // 
                $countD = count($user_check);
                $id = $input['enrollment_child_num'];
                $report = DB::select("SELECT * FROM enrollment_details where enrollment_child_num ='$id'");
                if ($countD == 0) {
                    $ovm_meeting = DB::table('sail_details')
                        ->insertGetId([
                            'enrollment_id' => $input['enrollment_child_num'],
                            'child_id' => $input['child_id'],
                            'is_coordinator1' => $input['is_coordinator1'],
                            'is_coordinator2' => $input['is_coordinator2'],
                            'child_name' => $input['child_name'],
                            'current_status' => 'Initiated',
                            'user_id' => $input['user_id'],
                            'created_by' => auth()->user()->id,
                            'created_date' => now(),
                            'last_modified_by' => auth()->user()->id,
                            'last_modified_date' => now()
                        ]);
                    // DB::table('notifications')->insertGetId([
                    //     'user_id' => $input['user_id'],
                    //     'notification_type' => 'activity',
                    //     'notification_status' => 'Sail',
                    //     'notification_url' =>  $input['notification'],
                    //     'megcontent' => "Dear " . $input['child_name'] . " Your SAIL Program has been Initiated.",
                    //     'alert_meg' => "Dear " . $input['child_name'] . " Your SAIL Program has been Initiated.",
                    //     'created_by' => auth()->user()->id,
                    //     'created_at' => NOW()
                    // ]);

                    DB::table('notifications')->insertGetId([
                        'user_id' => $inputArray['is_coordinator1'],
                        'notification_type' => 'activity',
                        'notification_status' => 'Sail',
                        'notification_url' =>  'sailstatus',
                        'megcontent' => "SAIL Program has been Initiated for " . $input['child_name'] . " (" . $input['enrollment_child_num'] . ")",
                        'alert_meg' => "SAIL Program has been Initiated for " . $input['child_name'] . " (" . $input['enrollment_child_num'] . ")",
                        'created_by' => auth()->user()->id,
                        'created_at' => NOW()
                    ]);
                    DB::table('notifications')->insertGetId([
                        'user_id' => $inputArray['is_coordinator2'],
                        'notification_type' => 'activity',
                        'notification_status' => 'Sail',
                        'notification_url' =>  'sailstatus',
                        'megcontent' => "SAIL Program has been Initiated for " . $input['child_name'] . " (" . $input['enrollment_child_num'] . ")",
                        'alert_meg' => "SAIL Program has been Initiated for " . $input['child_name'] . " (" . $input['enrollment_child_num'] . ")",
                        'created_by' => auth()->user()->id,
                        'created_at' => NOW()
                    ]);
                    $admin_details = DB::SELECT("SELECT * from users where array_roles = '4'");
                    $adminn_count = count($admin_details);
                    if ($admin_details != []) {
                        for ($j = 0; $j < $adminn_count; $j++) {

                            DB::table('notifications')->insertGetId([
                                'user_id' =>  $admin_details[$j]->id,
                                'notification_type' => 'activity',
                                'notification_status' => 'Sail',
                                'notification_url' => 'sailstatus',
                                'megcontent' => "SAIL Program has been Initiated for " . $input['child_name'] . " (" . $input['enrollment_child_num'] . ")",
                                'alert_meg' => "SAIL Program has been Initiated for " . $input['child_name'] . " (" . $input['enrollment_child_num'] . ")",
                                'created_by' => auth()->user()->id,
                                'created_at' => NOW()
                            ]);
                        }
                    }

                    $data1 = array(
                        'child_name' => $input['child_name'],
                        'consent_form' => $input['consent_form']
                    );

                    // Mail::to($report[0]->child_contact_email)->send(new sailconsentmail($data1));
                    // Mail::to($is_coordinator1email)->send(new sailconsentAdmin($data1));
                    // Mail::to($is_coordinator2email)->send(new sailconsentAdmin($data1));

                    $this->auditLog('sail_details', $ovm_meeting, 'Sail Initiated', 'Sail Initiated', auth()->user()->id, NOW(), '');
                    $enCh = $input['enrollment_child_num'];
                    $this->sail_status_log('sail_details', $ovm_meeting, 'Sail Accepted', 'Sail Status', auth()->user()->id, NOW(), $enCh);
                    $this->sail_status_log('sail_details', $ovm_meeting, 'Consent Sent', 'Sail Status', auth()->user()->id, NOW(), $enCh);
                }
                // else {
                //     DB::table('sail_details')
                //         ->where('enrollment_id', $input['enrollment_child_num'])
                //         ->update([
                //             'current_status' => 'Initiated',
                //         ]);

                //     $ovm_meeting = $user_check[0]->id;
                // }
                // 
                $this->updateGoogleEvent();

                $payment = DB::select("select * from payment_structure where fees_type='sail' and status='Active' ");

                $response = [
                    'enrollment_child_num' => $input['enrollment_child_num'],
                    'child_id' => $input['child_id'],
                    'child_name' => $input['child_name'],
                    'initiated_by' => auth()->user()->email,
                    'initiated_by' => config('setting.email_id'),
                    'initiated_to' => $report[0]->child_contact_email,
                    'payment_amount' => $payment[0]->amount,
                    'user_id' => $input['user_id'],
                    'payment_for' => 'SAIL Register Fee',
                    'payment_status' => 'New',
                    'payment_process_description' => 'Kindly Pay Rs.' . $payment[0]->amount . ' for your Registration',
                    'paymenttokentime' => '2800',
                    'enrollment_id' => $report[0]->enrollment_id,
                ];
                return $response;
            });

            $serviceResponse = array();
            $serviceResponse['Code'] = config('setting.status_code.success');
            $serviceResponse['Message'] = config('setting.status_message.success');
            $serviceResponse['Data'] = $response1;
            $serviceResponse['consent_aggrement'] = empty($user_check) ? '' : $user_check[0]->consent_aggrement;
            $serviceResponse = json_encode($serviceResponse, JSON_FORCE_OBJECT);
            $sendServiceResponse = $this->SendServiceResponse($serviceResponse, config('setting.status_code.success'), true);
            return $sendServiceResponse;
            // } else {
            //     $serviceResponse = array();
            //     $serviceResponse['Code'] = 400;
            //     $serviceResponse['Message'] = config('setting.status_message.success');
            //     $serviceResponse['Data'] = 1;
            //     $serviceResponse = json_encode($serviceResponse, JSON_FORCE_OBJECT);
            //     $sendServiceResponse = $this->SendServiceResponse($serviceResponse, config('setting.status_code.success'), true);
            //     return $sendServiceResponse;
            // }
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

    public function edit_data($id)
    {
        try {

            $method = 'Method => SaildocumentController => edit_data';


            $id = $this->DecryptData($id);


            $rows = DB::select("SELECT * FROM sail_details AS a
            INNER JOIN enrollment_details AS b ON a.user_id=b.user_id
            WHERE b.enrollment_id=$id");

            $video = DB::Select("SELECT * FROM parent_video_upload AS a
            INNER JOIN activity_description AS b ON a.activity_description_id=b.activity_description_id
            INNER JOIN activity AS c ON c.activity_id=a.activity_id
            INNER JOIN activity_parent_video_upload AS apvu ON apvu.parent_video_upload_id = a.parent_video_upload_id
            WHERE enrollment_id = $id AND a.STATUS = 'Complete'");

            $questionnaire = DB::select("SELECT * FROM questionnaire_initiation AS qi
			INNER JOIN questionnaire_details AS qd ON qd.questionnaire_id=qi.questionnaire_id
			INNER JOIN questionnaire AS Q ON Q.questionnaire_id=qd.questionnaire_id
			INNER JOIN enrollment_details AS ed ON ed.enrollment_id=qi.enrollment_id
			WHERE qi.activeflag = 0 and ed.enrollment_id=$id AND qi.status = 'Submitted' ORDER BY qi.questionnaire_initiation_id DESC");

            $payment = DB::select("SELECT * FROM payment_status_details AS a
            INNER JOIN enrollment_details AS b ON a.enrollment_child_num=b.enrollment_child_num
            WHERE payment_for = 'SAIL Register Fee' AND b.enrollment_id=$id");

            $iscoordinators = DB::select("SELECT id,name,email from users
            right JOIN uam_user_roles ON uam_user_roles.user_id=users.id
            right JOIN uam_roles on uam_roles.role_id = uam_user_roles.role_id
            WHERE uam_roles.role_name='IS Coordinator' AND users.active_flag=0");

            $response = [
                'rows' => $rows,
                'video' => $video,
                'questionnaire' => $questionnaire,
                'payment' => $payment,
                'iscoordinators' => $iscoordinators,
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

    public function sailcomplete(Request $request)
    {
        try {
            $method = 'Method => SaildocumentController => sailcomplete';
            $inputArray = $this->decryptData($request->requestData);

            $input = [
                'enrollment_child_num' => $inputArray['enrollment_child_num'],
                'enrollment_id' => $inputArray['enrollment_id'],
                'user_id' => $inputArray['user_id'],
                'child_id' => $inputArray['child_id'],
                'child_name' => $inputArray['child_name'],
                'payment_status' => $inputArray['payment_status'],
                'current_status' => $inputArray['current_status'],
                'is_coordinator1' => $inputArray['is_1'],
                'is_coordinator2' => $inputArray['is_2'],
            ];
            // $this->WriteFileLog($input);

            if ($input['current_status'] == 'Completed') {
                DB::table('sail_details')
                    ->where('enrollment_id', $input['enrollment_child_num'])
                    ->update([
                        'current_status' => $input['current_status'],
                    ]);

                $admin_details = DB::SELECT("SELECT * from users where array_roles = '4'");
                $adminn_count = count($admin_details);
                if ($admin_details != []) {
                    for ($j = 0; $j < $adminn_count; $j++) {
                        DB::table('notifications')->insertGetId([
                            'user_id' =>  $admin_details[$j]->id,
                            'notification_type' => 'activity',
                            'notification_status' => 'Sail Complete',
                            'notification_url' => 'sail/edit/status/' . encrypt($input['enrollment_id']),
                            'megcontent' => "SAIL Program for " . $input['child_name'] . " (" . $input['enrollment_child_num'] . ") has been Completed",
                            'alert_meg' => "SAIL Program for " . $input['child_name'] . " (" . $input['enrollment_child_num'] . ") has been Completed",
                            'created_by' => auth()->user()->id,
                            'created_at' => NOW()
                        ]);
                    }
                }
            } else {
                // JSON_EXTRACT(is_coordinator1, '$.id')
                $eID = $input['enrollment_child_num'];
                $sail = DB::select("select JSON_EXTRACT(is_coordinator1, '$.id') as co1 , JSON_EXTRACT(is_coordinator2, '$.id') as co2 from sail_details where enrollment_id = '$eID'");
                $co1 = $sail[0]->co1;
                $co2 = $sail[0]->co2;

                $is_coordinator1 = $input['is_coordinator1'];
                $is_coordinator1_D = DB::select('Select id,email,name from users where id=' . $is_coordinator1);
                $is_coordinator1json = json_encode($is_coordinator1_D[0], JSON_FORCE_OBJECT);
                $is_coordinator2 = $input['is_coordinator2'];
                if ($is_coordinator2 != null) {
                    $is_coordinator2_D = DB::select('Select id,email,name from users where id=' . $is_coordinator2);
                    $is_coordinator2json = json_encode($is_coordinator2_D[0], JSON_FORCE_OBJECT);
                } else {
                    $is_coordinator2json = null;
                }

                DB::table('sail_details')
                    ->where('enrollment_id', $input['enrollment_child_num'])
                    ->update([
                        'is_coordinator1' => $is_coordinator1json,
                        'is_coordinator2' => $is_coordinator2json,
                    ]);

                if ($co1 != $is_coordinator1) {
                    $data = array(
                        'child_name' => $input['child_name'],
                    );
                    DB::table('notifications')->insertGetId([
                        'user_id' => $co1,
                        'notification_type' => 'activity',
                        'notification_status' => 'Sail',
                        'notification_url' =>  'sailstatus',
                        'megcontent' => "SAIL Program has been Assigned for " . $input['child_name'] . " (" . $input['enrollment_child_num'] . ")",
                        'alert_meg' => "SAIL Program has been Assigned for " . $input['child_name'] . " (" . $input['enrollment_child_num'] . ")",
                        'created_by' => auth()->user()->id,
                        'created_at' => NOW()
                    ]);
                    Mail::to($is_coordinator1_D[0]->email)->send(new SailAdminUpdate($data));
                }
                if ($co2 != $is_coordinator2) {
                    $data = array(
                        'child_name' => $input['child_name'],
                    );
                    DB::table('notifications')->insertGetId([
                        'user_id' => $co2,
                        'notification_type' => 'activity',
                        'notification_status' => 'Sail',
                        'notification_url' =>  'sailstatus',
                        'megcontent' => "SAIL Program has been Assigned for " . $input['child_name'] . " (" . $input['enrollment_child_num'] . ")",
                        'alert_meg' => "SAIL Program has been Assigned for " . $input['child_name'] . " (" . $input['enrollment_child_num'] . ")",
                        'created_by' => auth()->user()->id,
                        'created_at' => NOW()
                    ]);
                    Mail::to($is_coordinator2_D[0]->email)->send(new SailAdminUpdate($data));
                }
            }




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
    public function submitDenial(Request $request)
    {
        try {

            $method = 'Method => SaildocumentController => submitDenial';
            $inputArray = $this->decryptData($request->requestData);
            $input = [
                'denialOption' => $inputArray['denialOption'],
                'weekSelect' => $inputArray['weekSelect'],
                'userID' => $inputArray['userID'],
            ];

            $enrollment = DB::select("SELECT a.* , b.* , a.enrollment_id as enrollmentID , JSON_EXTRACT(is_coordinator1, '$.id') AS co1 , JSON_EXTRACT(is_coordinator2, '$.id') AS co2 FROM enrollment_details AS a
            INNER JOIN ovm_meeting_details AS b ON a.enrollment_child_num = b.enrollment_id WHERE a.user_id = " . $input['userID']);

            $enrollmentID = $enrollment[0]->enrollmentID;

            $enrollment_child_num = $enrollment[0]->enrollment_child_num;
            $sail = DB::select("SELECT * FROM sail_details WHERE enrollment_id = '$enrollment_child_num'");
            $count = count($sail);
            if ($count == 0) {
                DB::table('sail_details')
                    ->insertGetId([
                        'enrollment_id' => $enrollment[0]->enrollment_child_num,
                        'child_id' => $enrollment[0]->child_id,
                        'is_coordinator1' => $enrollment[0]->is_coordinator1,
                        'is_coordinator2' => $enrollment[0]->is_coordinator2,
                        'child_name' => $enrollment[0]->child_name,
                        'current_status' => $input['denialOption'] . ' ' . $input['weekSelect'],
                        'user_id' => $enrollment[0]->user_id,
                        'consent_aggrement' => 'Rejected',
                    ]);
            } else {
                DB::table('sail_details')
                    ->where('enrollment_id', $enrollment[0]->enrollment_child_num)
                    ->update([
                        'current_status' => $input['denialOption'] . ' ' .  $input['weekSelect'],
                        'consent_aggrement' => 'Rejected',
                    ]);
            }

            $admin_details = DB::SELECT("SELECT * from users where array_roles = '4'");
            $adminn_count = count($admin_details);
            if ($admin_details != []) {
                for ($j = 0; $j < $adminn_count; $j++) {

                    DB::table('notifications')->insertGetId([
                        'user_id' =>  $admin_details[$j]->id,
                        'notification_type' => 'activity',
                        'notification_status' => 'Sail',
                        'notification_url' =>  'sailstatus',
                        'megcontent' => "SAIL Program for " . $enrollment[0]->child_name . " (" . $enrollment[0]->enrollment_child_num . ") has responded with " . $input['denialOption'] . $input['weekSelect'],
                        'alert_meg' => "SAIL Program for " . $enrollment[0]->child_name . " (" . $enrollment[0]->enrollment_child_num . ") has responded with " . $input['denialOption'] . $input['weekSelect'],
                        // 'created_by' => auth()->user()->id,
                        'created_at' => NOW()
                    ]);
                }
            }

            DB::table('notifications')->insertGetId([
                'user_id' =>  $enrollment[0]->co1,
                'notification_type' => 'activity',
                'notification_status' => 'Sail',
                'notification_url' =>  'sailstatus',
                'megcontent' => "SAIL Program for " . $enrollment[0]->child_name . " (" . $enrollment[0]->enrollment_child_num . ") has responded with " . $input['denialOption'] . ' ' . $input['weekSelect'],
                'alert_meg' => "SAIL Program for " . $enrollment[0]->child_name . " (" . $enrollment[0]->enrollment_child_num . ") has responded with " . $input['denialOption'] . ' ' . $input['weekSelect'],
                // 'created_by' => auth()->user()->id,
                'created_at' => NOW()
            ]);
            DB::table('notifications')->insertGetId([
                'user_id' =>  $enrollment[0]->co2,
                'notification_type' => 'activity',
                'notification_status' => 'Sail',
                'notification_url' =>  'sailstatus',
                'megcontent' => "SAIL Program for " . $enrollment[0]->child_name . " (" . $enrollment[0]->enrollment_child_num . ") has responded with " . $input['denialOption'] . ' ' . $input['weekSelect'],
                'alert_meg' => "SAIL Program for " . $enrollment[0]->child_name . " (" . $enrollment[0]->enrollment_child_num . ") has responded with " . $input['denialOption'] . ' ' . $input['weekSelect'],
                // 'created_by' => auth()->user()->id,
                'created_at' => NOW()
            ]);

            $this->sail_status_log('sail_details', '', 'Sail Decline - ' . $input['denialOption'] . ' ' . $input['weekSelect'], 'Sail Status', auth()->user()->id, NOW(), $enrollment[0]->enrollment_child_num);

            $serviceResponse = array();
            $serviceResponse['Code'] = config('setting.status_code.success');
            $serviceResponse['Message'] = config('setting.status_message.success');
            $serviceResponse['Data'] = $enrollmentID;
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

    public function getConsentDetails(Request $request)
    {
        try {
            $method = 'Method => SaildocumentController => getConsentDetails';

            $id = $this->decryptData($request[0]);

            $rows = DB::select("SELECT * FROM enrollment_details WHERE enrollment_child_num = '$id'");
            $enrollmentID = $rows[0]->enrollment_id;

            $feeType = 2;
            $paymentCategory = $rows[0]->category_id;
            $paymentDetails = DB::select("SELECT * FROM payment_process_customized WHERE enrollment_id = $enrollmentID");
            $schoolID = $rows[0]->school_id;

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
            $paymentID = $activePayment->id;
            $payableAmount = $activePayment->final_amount;
            $baseAmount = $activePayment->base_amount;
            $gstAmount = ($baseAmount / 100) * $activePayment->gst_rate;

            if (!empty($paymentDetails)) {
                $serviceList = DB::select("SELECT * FROM payment_process_services_customized WHERE payment_process_master_id = $paymentID");
            } else {
                $serviceList = DB::select("SELECT * FROM payment_process_services WHERE payment_process_master_id = $paymentID");
            }

            $payment = DB::select("select * from payment_structure where fees_type='sail' and status='Active' ");

            // $consentData = str_replace(
            //     "%SAIL_FEE%",
            //     $payableAmount,
            //     DB::table('policy_publish')->where('id', 5)->value('policy_content')
            // );

            $policyContent = DB::table('policy_publish')->where('id', 5)->value('policy_content');

            $parentName = $rows[0]->child_father_guardian_name;
            $sailDate = Carbon::now()->format('d-m-Y');
            $consentData = str_replace(
                ['%SAIL_FEE%', '%SAIL_PARENT_NAME%', '%SAIL_DATE%'],
                [$payableAmount, $parentName, $sailDate],
                $policyContent
            );


            $response = [
                'serviceList' => $serviceList
            ];
            $data = [
                'enrollment_child_num' => $rows[0]->enrollment_child_num,
                'child_id' => $rows[0]->child_id,
                'child_name' => $rows[0]->child_name,
                'initiated_by' => config('setting.email_id'),
                'initiated_to' => $rows[0]->child_contact_email,
                'payment_amount' => $payableAmount,
                'user_id' => $rows[0]->user_id,
                'payment_for' => 'SAIL Register Fee',
                'payment_status' => 'New',
                'payment_process_description' => 'Kindly Pay Rs.' . $payableAmount . ' for your Registration',
                'paymenttokentime' => '2800',
                'parentname' => $rows[0]->child_father_guardian_name,
                'enrollmentID' => $rows[0]->enrollment_id,
                'baseAmount' => $baseAmount,
                'gstAmount' => $gstAmount,
                'masterData' => $this->EncryptData($response),
            ];
            $enrollment_id = $rows[0]->enrollment_id;


            $agreed = DB::select("SELECT sa.* FROM sail_details AS sa INNER JOIN enrollment_details AS e ON sa.enrollment_id=e.enrollment_child_num WHERE e.enrollment_id=$enrollment_id AND sa.consent_aggrement=''");
            // $this->WriteFileLog($agreed);


            $response = [
                'data' => $data,
                'consentData' => $consentData,
                'agreed' => $agreed,
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
    public function SailConsentDecline(Request $request)
    {
        try {
            $method = 'Method => UserregisterfeeController => sailstoredata';
            $inputArray = $this->decryptData($request->requestData);
            $input = [
                'enrollment_child_num' => $inputArray['enrollment_child_num'],
                'child_id' => $inputArray['child_id'],
                'child_name' => $inputArray['child_name'],
                'initiated_to' => $inputArray['initiated_to'],
                'user_id' => $inputArray['user_id'],
                'consent_aggrement' => $inputArray['consent_aggrement'],
            ];


            DB::transaction(function () use ($input) {
                $authID = auth()->user()->id;

                $sail_details = DB::table('sail_details')
                    ->where('enrollment_id', $input['enrollment_child_num'])
                    ->update([
                        'consent_aggrement' => $input['consent_aggrement'],
                    ]);

                $enCh = $input['enrollment_child_num'];
                $this->sail_status_log('sail_details', $sail_details, 'Consent Declined', 'Sail Status', $authID, NOW(), $enCh);
                $admin_details = DB::SELECT("SELECT * from users where array_roles = '4'");
                $adminn_count = count($admin_details);
                if ($admin_details != []) {
                    for ($j = 0; $j < $adminn_count; $j++) {
                        DB::table('notifications')->insertGetId([
                            'user_id' =>  $admin_details[$j]->id,
                            'notification_type' => 'activity',
                            'notification_status' => 'Sail',
                            'notification_url' =>  'sailstatus',
                            'megcontent' => "User " . $input['child_name'] . " (" . $input['enrollment_child_num'] . ") has Declined the SAIL Concent",
                            'alert_meg' => "User " . $input['child_name'] . " (" . $input['enrollment_child_num'] . ") has Declined the SAIL Concent",
                            'created_by' => auth()->user()->id,
                            'created_at' => NOW()
                        ]);
                    }
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

    public function SailReInitiateStore(Request $request)
    {
        try {
            $method = 'Method => SaildocumentController => SailInitiateStore';
            $inputArray = $this->decryptData($request->requestData);

            $is_coordinator1 = $inputArray['is_coordinator1'];
            $is_coordinator2 = $inputArray['is_coordinator2'];

            $is_coordinator1 = DB::select("Select id,email,name from users where id= $is_coordinator1");
            $is_coordinator2 = DB::select("Select id,email,name from users where id= $is_coordinator2");

            $is_coordinator1json = json_encode($is_coordinator1[0], JSON_FORCE_OBJECT);
            $is_coordinator2json = json_encode($is_coordinator2[0], JSON_FORCE_OBJECT);

            $input = [
                'enrollment_child_num' => $inputArray['enrollment_child_num'],
                'enrollment_id' => $inputArray['enrollment_id'],
                'child_id' => $inputArray['child_id'],
                'is_coordinator1' => $is_coordinator1json,
                'is_coordinator2' => $is_coordinator2json,
                'child_name' => $inputArray['child_name'],
                'user_id' => $inputArray['user_id'],
                'url' => $inputArray['url'],
            ];

            DB::transaction(function () use ($input, $is_coordinator1, $is_coordinator2, $inputArray) {

                $is_coordinator1email = $is_coordinator1[0]->email;
                $is_coordinator2email = $is_coordinator2[0]->email;
                $enrollment_number = $inputArray['enrollment_child_num'];
                // $this->WriteFileLog($enrollment_number);
                $enrollment_id = $inputArray['enrollment_id'];
                // $this->WriteFileLog($enrollment_id);
                // $this->WriteFileLog($input['is_coordinator1']);
                $sail_details = DB::table('sail_details')
                    ->where('enrollment_id', $input['enrollment_child_num'])
                    ->update([
                        'consent_aggrement' => null,
                        'is_coordinator1' => $input['is_coordinator1'],
                        'is_coordinator2' => $input['is_coordinator2'],
                    ]);

                DB::table('notifications')->insertGetId([
                    'user_id' => $input['user_id'],
                    'notification_type' => 'activity',
                    'notification_status' => 'Sail',
                    'notification_url' => 'home',
                    'megcontent' => "Dear " . $input['child_name'] . " Your SAIL Program has been Initiated.",
                    'alert_meg' => "Dear " . $input['child_name'] . " Your SAIL Program has been Initiated.",
                    'created_by' => auth()->user()->id,
                    'created_at' => NOW()
                ]);

                DB::table('notifications')->insertGetId([
                    'user_id' => $inputArray['is_coordinator1'],
                    'notification_type' => 'activity',
                    'notification_status' => 'Sail',
                    'notification_url' =>  'sailstatus',
                    'megcontent' => "SAIL Program has been Initiated for " . $input['child_name'] . " (" . $input['enrollment_child_num'] . ")",
                    'alert_meg' => "SAIL Program has been Initiated for " . $input['child_name'] . " (" . $input['enrollment_child_num'] . ")",
                    'created_by' => auth()->user()->id,
                    'created_at' => NOW()
                ]);

                DB::table('notifications')->insertGetId([
                    'user_id' => $inputArray['is_coordinator2'],
                    'notification_type' => 'activity',
                    'notification_status' => 'Sail',
                    'notification_url' =>  'sailstatus',
                    'megcontent' => "SAIL Program has been Initiated for " . $input['child_name'] . " (" . $input['enrollment_child_num'] . ")",
                    'alert_meg' => "SAIL Program has been Initiated for " . $input['child_name'] . " (" . $input['enrollment_child_num'] . ")",
                    'created_by' => auth()->user()->id,
                    'created_at' => NOW()
                ]);
                // $this->WriteFileLog("ewdwd");
                $data1 = array(
                    'child_name' => $input['child_name'],
                );

                Mail::to($is_coordinator1email)->send(new sailconsentAdmin($data1));
                Mail::to($is_coordinator2email)->send(new sailconsentAdmin($data1));
                $enrollment_id = $inputArray['enrollment_id'];
                // $this->WriteFileLog($enrollment_id);
                // OVMCompleteMail
                $enrollment_details = DB::select("Select * from enrollment_details where enrollment_id=$enrollment_id");
                // $this->WriteFileLog($enrollment_details);
                $ovm2 = DB::select("Select * from ovm_meeting_2_details where enrollment_id='$enrollment_number'");
                // $this->WriteFileLog($ovm2);
                // $this->WriteFileLog($inputArray['url']);
                $data = array(
                    'child_name' => $enrollment_details[0]->child_name,
                    'child_contact_email' => $enrollment_details[0]->child_contact_email,
                    'meeting_date' => $ovm2[0]->meeting_startdate,
                    'url' => $inputArray['url'],
                    'userID' => encrypt($enrollment_details[0]->user_id),
                );
                // $this->WriteFileLog($data);
                $cce = $enrollment_details[0]->child_contact_email;
                // $this->WriteFileLog($cce);
                Mail::to($cce)->send(new SailEmailAccept($data));


                $this->auditLog('sail_details', $sail_details, 'Sail Initiated', 'Sail Initiated', auth()->user()->id, NOW(), '');
                $this->sail_status_log('sail_details', $sail_details, 'Sail Reinitiated', 'Sail Status', auth()->user()->id, NOW(), $enrollment_number);
            });

            $serviceResponse = array();
            $serviceResponse['Code'] = config('setting.status_code.success');
            $serviceResponse['Message'] = config('setting.status_message.success');
            $serviceResponse['Data'] = 1;
            $serviceResponse['consent_aggrement'] = empty($user_check) ? '' : $user_check[0]->consent_aggrement;
            $serviceResponse = json_encode($serviceResponse, JSON_FORCE_OBJECT);
            $sendServiceResponse = $this->SendServiceResponse($serviceResponse, config('setting.status_code.success'), true);
            return $sendServiceResponse;
            // } else {
            //     $serviceResponse = array();
            //     $serviceResponse['Code'] = 400;
            //     $serviceResponse['Message'] = config('setting.status_message.success');
            //     $serviceResponse['Data'] = 1;
            //     $serviceResponse = json_encode($serviceResponse, JSON_FORCE_OBJECT);
            //     $sendServiceResponse = $this->SendServiceResponse($serviceResponse, config('setting.status_code.success'), true);
            //     return $sendServiceResponse;
            // }
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
        // $this->WriteFileLog("ASdae");
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
