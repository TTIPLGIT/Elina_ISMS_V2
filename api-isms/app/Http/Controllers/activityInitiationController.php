<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;
use App\Mail\ActivityMail;
use App\Mail\ActivityRequiredMail;
use App\Mail\NewActivityMail;
use App\Jobs\ActivityJobAdmin;
use App\Mail\RejectionActivityMail;

class activityInitiationController extends BaseController
{
    public function index(Request $request)
    {
        try {

            $method = 'Method => activityInitiationController => index';

            $authID = auth()->user()->id;
            $role_name = DB::select("SELECT role_name FROM uam_roles AS ur INNER JOIN users us ON (us.array_roles=ur.role_id) WHERE us.id=" . auth()->user()->id);
            $role_name_fetch = $role_name[0]->role_name;
            $rolesArray = array_merge(array(auth()->user()->array_roles), array(auth()->user()->roles));
            if (in_array(4, $rolesArray)) {
                $rows = DB::select("SELECT que.status , en.enrollment_id , en.enrollment_child_num , en.child_name , qud.activity_name , que.activity_initiation_id , que.activity_id
                FROM activity_initiation AS que 
                INNER JOIN activity AS qud ON que.activity_id = qud.activity_id
                INNER JOIN enrollment_details AS en on en.enrollment_id=que.enrollment_id
                WHERE (que.action_flag != 1 OR que.action_flag IS NULL) AND que.activity_initiation_id IN (SELECT MAX(activity_initiation_id) FROM activity_initiation WHERE (action_flag != 1 OR action_flag IS NULL) GROUP BY enrollment_id)
                ORDER BY que.activity_initiation_id DESC");
            } else {
                $rows = DB::select("SELECT que.status , en.enrollment_id , en.enrollment_child_num , en.child_name , qud.activity_name , que.activity_initiation_id , que.activity_id
                FROM activity_initiation AS que 
                INNER JOIN activity AS qud ON que.activity_id = qud.activity_id
                INNER JOIN enrollment_details AS en on en.enrollment_id=que.enrollment_id
                INNER JOIN sail_details AS sd ON sd.enrollment_id = en.enrollment_child_num
                WHERE (que.action_flag != 1 OR que.action_flag IS NULL) AND que.activity_initiation_id IN (SELECT MAX(activity_initiation_id) FROM activity_initiation WHERE (action_flag != 1 OR action_flag IS NULL) GROUP BY enrollment_id)
                AND (JSON_EXTRACT(sd.is_coordinator1, '$.id') = $authID or JSON_EXTRACT(sd.is_coordinator2, '$.id') = $authID)
                ORDER BY que.activity_initiation_id DESC");
            }

            $com = DB::select("SELECT COUNT(*) AS complete , activity_initiation_id , activity_id FROM parent_video_upload WHERE STATUS = 'Complete' 
            GROUP BY activity_initiation_id");

            $total = DB::select("SELECT COUNT(*) AS total , activity_id from parent_video_upload GROUP BY activity_initiation_id");
            $observation = DB::select("SELECT GROUP_CONCAT(enrollment_id) as id FROM parent_video_upload WHERE f2f_flag = 1");

            $response = [
                'rows' => $rows,
                'com' => $com,
                'total' => $total,
                'observation' => $observation

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
        try {
            $method = 'Method => activityInitiationController => createdata';

            $id = auth()->user()->id;
            $role_name = DB::select("SELECT role_name FROM uam_roles AS ur INNER JOIN users us ON (us.array_roles=ur.role_id) WHERE us.id=" . auth()->user()->id);
            $role_name_fetch = $role_name[0]->role_name;
            $rolesArray = array_merge(array(auth()->user()->array_roles), array(auth()->user()->roles));
            if (in_array(4, $rolesArray)) {
                $rows = DB::select("SELECT * FROM enrollment_details WHERE enrollment_child_num IN 
                (SELECT enrollment_child_num FROM payment_status_details WHERE payment_for = 'SAIL Register Fee' AND payment_status = 'SUCCESS')
                AND enrollment_id NOT IN (SELECT enrollment_id FROM reports_copy WHERE report_type = 7) ORDER BY enrollment_id DESC");
            } else {
                $rows = DB::select("SELECT a.* FROM enrollment_details AS a INNER JOIN sail_details AS b ON a.enrollment_child_num= b.enrollment_id
                WHERE a.enrollment_child_num IN (SELECT enrollment_child_num FROM payment_status_details WHERE payment_for = 'SAIL Register Fee' AND payment_status = 'SUCCESS')
                AND (JSON_EXTRACT(b.is_coordinator1, '$.id') = $id OR JSON_EXTRACT(b.is_coordinator2, '$.id') = $id) AND a.enrollment_id NOT IN (SELECT enrollment_id FROM reports_copy WHERE report_type = 7) ORDER BY a.enrollment_id DESC");
            }

            $activity = DB::select("SELECT COUNT(*) as total FROM activity WHERE active_flag = 0 and category='3'");
            $total = $activity[0]->total;

            foreach ($rows as $key => $row) {
                $enrollment_id = $row->enrollment_id;
                $activity_initiated = DB::select("SELECT COUNT(*) as total FROM activity_initiation WHERE enrollment_id = $enrollment_id and action_flag = 0");
                $total_initiated = $activity_initiated[0]->total;
                if ($total == $total_initiated) {
                    unset($rows[$key]);
                }
            }

            $email = DB::select("select * from users where id = $id");
            $activity = DB::select("SELECT * from activity where active_flag=0 and category='3'");
            $response = [
                'rows' => $rows,
                'email' => $email,
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

    public function storedata(Request $request)
    {
        try {
            $method = 'Method => activityInitiationController => storedata';
            $inputArray = $this->DecryptData($request->requestData);
            $input = [
                'enrollment_id' => $inputArray['enrollment_id'],
                'activity_id' => $inputArray['activity_id'],
                'descriptionID' => $inputArray['descriptionID'],
                'instructions' => $inputArray['instructions'],
                'actionBtn' => $inputArray['actionBtn'],
            ];

            DB::transaction(function () use ($input) {

                $data1 = $input['descriptionID'];
                $variable = $input['activity_id'];
                $instructions = $input['instructions'];
                $selectedID = implode(',', $variable);
                $enID =  $input['enrollment_id'];
                $desID = $input['descriptionID'];
                $en = DB::select("SELECT * FROM enrollment_details WHERE enrollment_id=$enID");
                $inarr = explode(',', $data1);
                $isSave = ($input['actionBtn'] == 'Save');
                $child_name = $en[0]->child_name;
                $enrollment_child_num = $en[0]->enrollment_child_num;
                foreach ($variable as $key => $value) {
                    $checkactivitysave = DB::select("SELECT * FROM activity_initiation where activity_id=$value and enrollment_id=" . $input['enrollment_id']);
                    if ($checkactivitysave == []) {

                        $videocreation = DB::table('activity_initiation')->insertGetId([
                            'user_id' =>  auth()->user()->id,
                            'enrollment_id' => $input['enrollment_id'],
                            'activity_id' => $value,
                            'status' => 'initiated',
                            'created_by' => auth()->user()->id,
                            'created_date' => NOW(),
                            'last_modified_by' => auth()->user()->id,
                            'last_modified_date' => NOW(),
                            'action_flag' => ($isSave ? '1' : '0'),
                        ]);
                    } else {

                        DB::table('activity_initiation')->updateOrInsert(
                            ['activity_id' => $value, 'enrollment_id' => $input['enrollment_id']], // Where clause
                            [
                                'user_id' =>  auth()->user()->id,
                                'enrollment_id' => $input['enrollment_id'],
                                'activity_id' => $value,
                                'status' => 'initiated',
                                'created_by' => auth()->user()->id,
                                'created_date' => NOW(),
                                'last_modified_by' => auth()->user()->id,
                                'last_modified_date' => NOW(),
                                'action_flag' => ($isSave ? '1' : '0'),
                            ]
                        );
                        $videocreation = $checkactivitysave[0]->activity_initiation_id;
                    }
                    // 

                    // 

                    // $option = DB::select("SELECT * FROM activity_description WHERE activity_id = $value and activity_description_id not in ($data1)");
                    $option = DB::select("SELECT * FROM activity_description WHERE activity_id = $value");
                    for ($i = 0; $i < count($option); $i++) {
                        DB::table('parent_video_upload')->where(['activity_id' => $option[$i]->activity_id, 'enrollment_id' => $input['enrollment_id']])->delete();
                    }
                    if (!empty($option)) {
                        $optioncount = count($option);
                        for ($i = 0; $i < $optioncount; $i++) {
                            $activity_description_id = $option[$i]->activity_description_id;
                            $enableFlag = in_array($activity_description_id, $inarr) ? 1 : 0;

                            // $checkactivitysave = DB::select("SELECT * FROM activity_initiation where activity_id=$value and enrollment_id=" . $input['enrollment_id']);
                            DB::table('parent_video_upload')->insertGetId([
                                'activity_id' => $option[$i]->activity_id,
                                'enrollment_id' => $input['enrollment_id'],
                                'activity_initiation_id' => $videocreation,
                                'instruction' => isset($instructions[$option[$i]->activity_description_id]) ? str_replace("%27", "'", urldecode($instructions[$option[$i]->activity_description_id])) : $option[$i]->instruction,
                                'status' => 'New',
                                'enableflag' => $enableFlag,
                                'activity_description_id' => $option[$i]->activity_description_id,
                                'created_by' => auth()->user()->id,
                                'created_date' => NOW(),
                                'action_flag' => ($isSave ? '1' : '0'),
                            ]);


                            // DB::table('parent_video_upload')->updateOrInsert(
                            //     ['activity_id' => $option[$i]->activity_id, 'enrollment_id' => $input['enrollment_id'], 'activity_description_id' => $option[$i]->activity_description_id], // Where clause
                            //     [
                            //         'activity_id' => $option[$i]->activity_id,
                            //         'enrollment_id' => $input['enrollment_id'],
                            //         'activity_initiation_id' => $videocreation,
                            //         'instruction' => isset($instructions[$option[$i]->activity_description_id]) ? $instructions[$option[$i]->activity_description_id] : null,
                            //         'status' => 'New',
                            //         'enableflag' => $enableFlag,
                            //         'activity_description_id' => $option[$i]->activity_description_id,
                            //         'created_by' => auth()->user()->id,
                            //         'created_date' => NOW(),
                            //     ]
                            // );
                            // 
                        }
                    }

                    DB::table('activity_complete')->insertGetId([
                        'activity_id' => $value,
                        'enrollment_id' => $enID,
                        'user_id' => $en[0]->user_id,
                        'activity_initiation_id' => $videocreation,
                        'created_by' => auth()->user()->id,
                        'created_at' => NOW()
                    ]);
                }

                $data = array(
                    'status' => 'Initiated',
                    'des' => '',
                    'child_name' => $child_name,
                    'en_no' => $enrollment_child_num,
                    'isms_base' => config('setting.isms_base'),
                );
                // ($isSave ? '1' : '0'),
                if (!$isSave) {
                    Mail::to($en[0]->child_contact_email)->send(new ActivityMail($data));

                    $this->auditLog('activity_initiation', $videocreation, 'Initiate', 'Activity Initiated', auth()->user()->id, NOW(), 'Initiated');
                    $this->sail_status_log('activity_initiation', $videocreation, 'Activity Initiated', 'Sail Status', auth()->user()->id, NOW(), $en[0]->enrollment_child_num);

                    DB::table('notifications')->insertGetId([
                        'user_id' => $en[0]->user_id,
                        'notification_type' => 'activity',
                        'notification_status' => 'Initiated',
                        'notification_url' => 'parent_video_upload/parentindex',
                        'megcontent' => "SAIL Activity Set has been initiated.",
                        'alert_meg' => "SAIL Activity Set has been initiated.",
                        'created_by' => auth()->user()->id,
                        'created_at' => NOW()
                    ]);

                    $admin_details = DB::SELECT("SELECT *from users where array_roles = '4'");
                    $adminn_count = count($admin_details);
                    if ($admin_details != []) {
                        for ($j = 0; $j < $adminn_count; $j++) {

                            DB::table('notifications')->insertGetId([
                                'user_id' =>  $admin_details[$j]->id,
                                'notification_type' => 'activity',
                                'notification_status' => 'Initiated',
                                'notification_url' => 'activity_initiate',
                                'megcontent' => "SAIL Activity Set has been initiated for " . $en[0]->child_name . " (" . $en[0]->enrollment_child_num . ")",
                                'alert_meg' => "SAIL Activity Set has been initiated for " . $en[0]->child_name . " (" . $en[0]->enrollment_child_num . ")",
                                'created_by' => auth()->user()->id,
                                'created_at' => NOW()
                            ]);

                            $data = array(
                                'status' => 'Initiated',
                                'des' => '',
                                'name' => $en[0]->child_name,
                                'enrollment' => $en[0]->enrollment_child_num,
                                'user_name' => $admin_details[$j]->name,
                                'email' => $admin_details[$j]->email
                            );

                            dispatch(new ActivityJobAdmin($data))->delay(now()->addSeconds(60));
                        }
                    }
                } else {
                    $this->auditLog('activity_initiation', $videocreation, 'Initiate', 'Activity Initiation Saved', auth()->user()->id, NOW(), 'Initiated');
                    $this->sail_status_log('activity_initiation', $videocreation, 'Activity Initiation Saved', 'Sail Status', auth()->user()->id, NOW(), $en[0]->enrollment_child_num);
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

    public function activityajax(Request $request)

    {
        $logMethod = 'Method => activityInitiationController => activityajax';

        try {

            $inputArray = $request->requestData;
            // $this->WriteFileLog($inputArray);
            $enrollmentID = DB::select("select * from enrollment_details where enrollment_id = '$inputArray'");
            $activity = DB::select("SELECT * FROM activity WHERE category='3' and activity_id NOT IN (SELECT b.activity_id FROM activity AS a
            INNER JOIN activity_initiation AS b ON a.activity_id = b.activity_id
            WHERE b.enrollment_id=$inputArray AND (b.action_flag != 1 OR b.action_flag IS NULL)) AND active_flag = 0");
            $savedActivity = DB::select("SELECT GROUP_CONCAT(activity_id) as savedActivity FROM activity_initiation WHERE enrollment_id = '$inputArray' AND action_flag = 1");
            $response = [
                'enrollmentID' => $enrollmentID,
                'activity' => $activity,
                'savedActivity' => $savedActivity,
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

    public function data_edit($id)
    {
        try {

            $method = 'Method => activityInitiationController => data_edit';
            $id = $this->DecryptData($id);

            $rows = DB::table('activity_initiation as ques')
                ->join('enrollment_details as qud', 'ques.enrollment_id', '=', 'qud.enrollment_id')
                ->join('activity as question', 'question.activity_id', '=', 'ques.activity_id')
                ->join('users as us', 'us.id', '=', 'ques.user_id')
                ->where('ques.activity_initiation_id', $id)
                ->select(
                    'ques.enrollment_id',
                    'ques.activity_initiation_id',
                    'qud.user_id as userID',
                    'qud.enrollment_child_num',
                    'qud.child_id',
                    'qud.child_name',
                    'question.activity_name',
                    'ques.status',
                    'ques.last_modified_date'
                )
                ->get();

            $enNum = $rows[0]->enrollment_id ?? null;
            $activity = DB::table('activity_initiation as a')
                ->join('activity as aa', 'aa.activity_id', '=', 'a.activity_id')
                ->where('a.enrollment_id', $enNum)
                ->where(function ($query) {
                    $query->where('action_flag', '!=', 1)
                        ->orWhereNull('action_flag');
                })
                ->select('aa.activity_id', 'aa.activity_name', 'a.activity_initiation_id')
                ->get();

            $activityshow = DB::table('activity_initiation as ques')
                ->join('activity_description as qud', 'ques.activity_id', '=', 'qud.activity_id')
                ->where('ques.activity_initiation_id', $id)
                ->select('ques.*', 'qud.*')
                ->get();

            $userID = $rows[0]->userID ?? null;

            $lastactivity = DB::table('activity_initiation as a')
                ->join('activity as ac', 'ac.activity_id', '=', 'a.activity_id')
                ->join('enrollment_details as b', 'a.enrollment_id', '=', 'b.enrollment_id')
                ->join('parent_video_upload as c', 'c.activity_initiation_id', '=', 'a.activity_initiation_id')
                ->join('activity_description as ad', 'ad.activity_description_id', '=', 'c.activity_description_id')
                ->leftJoin('face_to_face_observation as ff', 'ff.parent_video_id', '=', 'c.parent_video_upload_id')
                ->where('b.user_id', $userID)
                ->select(
                    'a.activity_id',
                    'c.f2f_flag',
                    'ff.*',
                    'c.enableflag',
                    'c.comments',
                    'a.activity_initiation_id',
                    'ac.activity_name',
                    'ad.description',
                    'a.last_modified_date',
                    'c.status',
                    'c.parent_video_upload_id',
                    'ad.activity_description_id',
                    'c.coordinator_observation',
                    'c.head_observation',
                    'c.physical_observation_name',
                    'c.physical_observation_result',
                    'c.required',
                    'c.save_status',
                    'c.instruction'
                )
                ->distinct()
                ->orderBy('c.parent_video_upload_id')
                ->orderBy('c.enableflag')
                ->orderBy('ac.activity_id')
                ->orderBy('ad.activity_description_id')
                ->get();

            $currentactivity = DB::table('activity_initiation as a')
                ->join('activity as ac', 'ac.activity_id', '=', 'a.activity_id')
                ->join('enrollment_details as b', 'a.enrollment_id', '=', 'b.enrollment_id')
                ->join('parent_video_upload as c', 'c.activity_initiation_id', '=', 'a.activity_initiation_id')
                ->join('activity_description as ad', 'ad.activity_description_id', '=', 'c.activity_description_id')
                ->leftJoin('face_to_face_observation as ff', 'ff.parent_video_id', '=', 'c.parent_video_upload_id')
                ->where('b.user_id', $userID)
                ->whereIn('c.status', ['Submitted', 'Re-Sent'])
                ->where('c.enableflag', 0)
                ->select(
                    'save_status1',
                    'a.activity_id',
                    'c.f2f_flag',
                    'ff.*',
                    'c.enableflag',
                    'c.save_status',
                    'c.comments',
                    'a.activity_initiation_id',
                    'ac.activity_name',
                    'ad.description',
                    'a.last_modified_date',
                    'c.status',
                    'c.parent_video_upload_id',
                    'ad.activity_description_id',
                    'c.instruction',
                    'c.coordinator_observation',
                    'c.head_observation',
                    'c.physical_observation_name',
                    'c.physical_observation_result'
                )
                ->distinct()
                ->orderBy('c.enableflag')
                ->orderBy('ac.activity_id')
                ->orderBy('ad.activity_description_id')
                ->get();

            $active = $lastactivity[0]->activity_id ?? null;

            $comments = DB::table('latest_video_comments as lvc')
                ->join('activity_initiation as ai', 'lvc.activity_initiation_id', '=', 'ai.activity_initiation_id')
                ->where('ai.enrollment_id', $enNum)
                ->where('lvc.active_status', '!=', 'New')
                ->select('lvc.parent_video_upload_id', 'lvc.*')
                ->distinct()
                ->get();

            $video_link = DB::table('activity_parent_video_upload')
                ->whereIn('parent_video_upload_id', function ($query) use ($userID) {
                    $query->select('a.parent_video_upload_id')
                        ->from('parent_video_upload as a')
                        ->join('activity_parent_video_upload as b', 'a.parent_video_upload_id', '=', 'b.parent_video_upload_id')
                        ->join('enrollment_details as c', 'a.Enrollment_id', '=', 'c.enrollment_id')
                        ->where('c.user_id', $userID)
                        ->distinct();
                })
                ->get();

            $activity_materials = DB::table('activity_materials')->get();

            $activity_materials_mapping = DB::table('activity_materials_mapping')->get();

            $f2f_observation = DB::table('face_to_face_observation')->get();

            $lastactivity1 = DB::select("SELECT DISTINCT  a.activity_id, c.f2f_flag , ff.* , c.enableflag , c.comments, a.activity_initiation_id, ac.activity_name , ad.description , a.last_modified_date ,c.status, c.parent_video_upload_id , ad.activity_description_id ,c.instruction,
            c.coordinator_observation,c.head_observation,c.physical_observation_name,c.physical_observation_result FROM activity_initiation AS a
            INNER JOIN activity AS ac ON ac.activity_id=a.activity_id
            INNER JOIN enrollment_details AS b ON a.enrollment_id=b.enrollment_id
            INNER JOIN parent_video_upload AS c ON c.activity_initiation_id=a.activity_initiation_id
            INNER JOIN activity_description AS ad ON ad.activity_description_id=c.activity_description_id
            LEFT JOIN face_to_face_observation AS ff ON ff.parent_video_id = c.parent_video_upload_id
            WHERE b.user_id='$userID' and c.status='Complete' ORDER BY c.parent_video_upload_id,c.enableflag ASC , ac.activity_id ASC , ad.activity_description_id");
            $activity_set = DB::select("SELECT aa.activity_id , aa.activity_name FROM activity AS aa");
            $datalist = DB::select("SELECT DISTINCT  a.activity_id, c.f2f_flag , ff.* , c.enableflag , c.save_status , c.comments, a.activity_initiation_id, ac.activity_name , ad.description , a.last_modified_date ,c.status, c.parent_video_upload_id , ad.activity_description_id ,
            lv.comments as parent_comment,av.video_link,c.coordinator_observation,c.head_observation,c.physical_observation_name,c.physical_observation_result FROM activity_initiation AS a
            INNER JOIN activity AS ac ON ac.activity_id=a.activity_id
            INNER JOIN enrollment_details AS b ON a.enrollment_id=b.enrollment_id
            INNER JOIN parent_video_upload AS c ON c.activity_initiation_id=a.activity_initiation_id
            INNER JOIN activity_description AS ad ON ad.activity_description_id=c.activity_description_id
            LEFT JOIN face_to_face_observation AS ff ON ff.parent_video_id = c.parent_video_upload_id
            INNER JOIN activity_parent_video_upload as av ON av.parent_video_upload_id = c.parent_video_upload_id
            LEFT JOIN latest_video_comments as lv on lv.parent_video_upload_id=c.parent_video_upload_id
            WHERE a.enrollment_id=$enNum and c.enableflag=0  GROUP BY ad.activity_description_id ORDER BY ac.activity_id ASC ");
            // Initialize an empty array to store the transformed data
            // Iterate through the query result
            $transformedData = [];
            foreach ($datalist as $data) {
                $activityName = $data->activity_name;
                unset($data->activityName);
                if (!isset($transformedData[$activityName])) {
                    $transformedData[$activityName] = [];
                }
                $transformedData[$activityName][] = (array)$data;
            }

            // Convert the transformed data to JSON format
            $jsonOutput = json_encode($transformedData, JSON_PRETTY_PRINT);
            // Remove newline characters from the JSON output
            $cleanedJsonString = str_replace("\n", "", $jsonOutput);


            $response = [
                'rows' => $rows,
                'activity' => $activity,
                'activityshow' => $activityshow,
                'lastactivity' => $lastactivity,
                'comments' => $comments,
                'video_link' => $video_link,
                'currentactivity' => $currentactivity,
                'activity_materials_mapping' => $activity_materials_mapping,
                'activity_materials' => $activity_materials,
                'f2f_observation' => $f2f_observation,
                'lastactivity1' => $lastactivity1,
                'datalist' => $cleanedJsonString,
                'activity_set' => $activity_set,
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
            $method = 'Method =>  activityInitiationController => updatedata';
            $inputArray = $this->decryptData($request->requestData);
            $input = [
                'activity_initiation_id' => $inputArray['activity_initiation_id'],
                'approval_status' => $inputArray['approval_status'],
                'comments' => $inputArray['comments'],
                'activity_description_id' => $inputArray['activity_description_id'],
                'check_video' => $inputArray['check_video'],
                'observation' => $inputArray['observation'],
            ];

            $activityID = DB::transaction(function () use ($input) {
                $initiateID = $input['activity_initiation_id'];
                $authID = Auth::id();
                $pvu = DB::select("SELECT * FROM parent_video_upload WHERE parent_video_upload_id = $initiateID");
                DB::table('parent_video_upload')
                    ->where('parent_video_upload_id', $initiateID)
                    ->update([
                        // 'status' => $input['approval_status'],
                        'last_modified_by' => $authID,
                        'last_modified_date' => NOW(),
                        'comments' => $input['observation']
                    ]);

                $role_name = DB::select("SELECT role_name FROM uam_roles AS ur INNER JOIN users us ON (us.array_roles=ur.role_id) WHERE us.id=$authID");

                if ($input['comments'] != '' && $input['comments'] != null) {

                    DB::table('latest_video_comments')->insertGetId([
                        'activity_initiation_id' => $pvu[0]->activity_initiation_id,
                        'parent_video_upload_id' => $initiateID,
                        'user_name' => auth()->user()->name,
                        // 'active_status' => $input['approval_status'],
                        'created_by' => $authID,
                        'created_at' => NOW(),
                        'comments' => $input['comments'],
                        'role' => $role_name[0]->role_name
                    ]);
                }
                if ($input['observation'] != null) {
                    // Retrieve activity_description_id and activity_id
                    $activity_data = DB::table('parent_video_upload')
                        ->select('activity_id')
                        ->where('parent_video_upload_id', $initiateID)
                        ->first();

                    $en_id = $pvu[0]->Enrollment_id;

                    DB::table('sail_activity_vlog_comments')->insertGetId([
                        'activity_id' =>  $activity_data->activity_id,
                        'activity_description_id' => $input['activity_description_id'],
                        'observation' => $input['observation'],
                        'enrollment_id' => $en_id,
                        'created_at' => NOW(),
                        'created_by' => $authID,
                        'parent_video_upload_id' => $initiateID
                    ]);

                    return $activity_data->activity_id;
                }
            });

            $serviceResponse = array();
            $serviceResponse['Code'] = config('setting.status_code.success');
            $serviceResponse['Message'] = config('setting.status_message.success');
            $serviceResponse['Data'] = $activityID;
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


    public function observationrecord(Request $request)
    {

        try {

            $method = 'Method =>  activityInitiationController => updatedata';

            $inputArray = $this->decryptData($request->requestData);
            $input = [
                'activity_initiation_id' => $inputArray['activity_initiation_id'],
                'observation_result' => $inputArray['observation_result'],
                // 'coordinator_observation' => $inputArray['coordinator_observation'],
                // 'head_observation' => $inputArray['head_observation'],
                // 'physical_observation_name' => $inputArray['physical_observation_name'],
                // 'physical_observation_result' => $inputArray['physical_observation_result']
            ];

            DB::transaction(function () use ($input) {

                $observation_result = $input['observation_result'];
                foreach ($observation_result as $key => $value) {
                    DB::table('parent_video_upload')
                        ->where('parent_video_upload_id', $key)
                        ->update([
                            'comments' => $value
                        ]);
                }

                // $role_name = DB::select("SELECT role_name FROM uam_roles AS ur INNER JOIN users us ON (us.array_roles=ur.role_id) WHERE us.id=$authID");
                // $role_name=DB::select("SELECT role_name FROM uam_roles AS ur INNER JOIN users us ON (us.array_roles=ur.role_id) WHERE us.id=".auth()->user()->id);
                // $role_name_fetch=$role_name[0]->role_name;
                // $this->auditLog('activity_initiation', $input, 'Update', 'update a Activity', auth()->user()->id, NOW(), ' Updated');

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

    public function activeStatus(Request $request)
    {

        try {

            $method = 'Method =>  activityInitiationController => updatedata';

            $inputArray = $this->decryptData($request->requestData);
            $input = [
                'activity_initiation_id' => $inputArray['activity_initiation_id'],
                'approval_status' => $inputArray['approval_status'],
            ];

            DB::transaction(function () use ($input) {

                $authID = auth()->user()->id;
                DB::table('activity_initiation')
                    ->where('activity_initiation_id', $input['activity_initiation_id'])
                    ->update([
                        'status' => $input['approval_status'],
                        'last_modified_by' => $authID,
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
    public function bulk_update(Request $request)
    {

        try {

            $method = 'Method =>  activityInitiationController => bulk_update';

            $inputArray = $this->decryptData($request->requestData);
            $input = [
                'approval' => $inputArray['approval'],
                'pvID' => $inputArray['pvID'],
                'aID' => $inputArray['aID'],
                'comment' => $inputArray['comment'],
            ];

            DB::transaction(function () use ($input) {

                $authID = Auth::id();
                $pvID = $input['pvID'];
                $comment = $input['comment'];
                // $this->WriteFileLog($pvID);
                $fpVid = array_keys($pvID);
                $pvCount = count($fpVid);
                // $this->WriteFileLog($pvCount);
                $role_name = DB::select("SELECT role_name FROM uam_roles AS ur INNER JOIN users us ON (us.array_roles=ur.role_id) WHERE us.id=$authID");

                for ($k = 0; $k < $pvCount; $k++) {
                    $pId = $fpVid[$k];
                    $pVal = $pvID[$pId];
                    $cVal = $comment[$pId];
                    DB::table('parent_video_upload')
                        ->where('parent_video_upload_id', $pId)
                        ->update([
                            'status' => $input['approval'],
                            'last_modified_by' => $authID,
                            'comments' => $pVal,
                            'last_modified_date' => NOW()
                        ]);

                    $pvu = DB::select("SELECT * FROM parent_video_upload WHERE parent_video_upload_id = $pId");
                    DB::table('latest_video_comments')->insertGetId([
                        'activity_initiation_id' => $pvu[0]->activity_initiation_id,
                        'parent_video_upload_id' => $pId,
                        'user_name' => auth()->user()->name,
                        'active_status' => $input['approval'],
                        'created_by' => $authID,
                        'created_at' => NOW(),
                        'comments' => $cVal,
                        'role' => $role_name[0]->role_name
                    ]);
                }
                // $role_name_fetch=$role_name[0]->role_name;
                // $this->auditLog('activity_initiation', $input, 'Update', 'update a Activity', auth()->user()->id, NOW(), ' Updated');
            });

            $serviceResponse = array();
            $serviceResponse['Code'] = config('setting.status_code.success');
            $serviceResponse['Message'] = config('setting.status_message.success');
            $serviceResponse['Data'] = 200;
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

    public function update_toggle(Request $request)
    {
        try {

            $method = 'Method => activityInitiationController => update_toggle';
            $inputArray = $this->decryptData($request->requestData);
            // $this->WriteFileLog($inputArray);
            $input = [
                'is_active' => $inputArray['is_active'],
                'f_id' => $inputArray['f_id'],
            ];

            DB::table('parent_video_upload')
                ->where([['parent_video_upload_id', '=', $input['f_id']]])
                ->update(['enableflag' => $input['is_active']]);


            $authID = Auth::id();
            $details = DB::select("SELECT c.activity_name , d.description , b.child_contact_email ,b.enrollment_id,b.user_id FROM parent_video_upload AS a 
            INNER JOIN enrollment_details AS b ON a.Enrollment_id = b.enrollment_id
            INNER JOIN activity AS c ON c.activity_id = a.activity_id
            INNER JOIN activity_description AS d ON d.activity_description_id = a.activity_description_id
            WHERE parent_video_upload_id = " . $input['f_id']);

            $activity_name = $details[0]->activity_name;
            $description = $details[0]->description;
            $child_contact_email = $details[0]->child_contact_email;
            $user_id = $details[0]->user_id;

            if ($input['f_id'] == 0) {
                $approval_status_des = 'Closed';
            } else {
                $approval_status_des = 'Initiated';
            }
            $data = array(
                'activity_name' => $activity_name,
                'description' => $description,
                'approval_status' => $approval_status_des
            );

            Mail::to($child_contact_email)->send(new NewActivityMail($data));

            DB::table('notifications')->insertGetId([
                'user_id' => $user_id,
                'notification_type' => 'activity',
                'notification_status' => 'Initiated',
                'notification_url' => 'parent_video_upload/parentindex',
                'megcontent' => "Activity " . $description . " has been " . $approval_status_des,
                'alert_meg' => "Activity " . $description . " has been " . $approval_status_des,
                'created_by' => auth()->user()->id,
                'created_at' => NOW()
            ]);

            $serviceResponse = array();
            $serviceResponse['Code'] = config('setting.status_code.success');
            $serviceResponse['Message'] = config('setting.status_message.success');
            $serviceResponse['Data'] = $input['is_active'];
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

    public function update_video(Request $request)
    {

        try {

            $method = 'Method =>  activityInitiationController => update_video';

            $inputArray = $this->decryptData($request->requestData);
            $input = [
                'activity_initiation' => $inputArray['activity_initiation'],
                'approval_status' => $inputArray['approval_status'],
                'comments' => $inputArray['comments'],
                // 'activity_description_id' => $inputArray['activity_description_id'],
                'check_video' => $inputArray['check_video'],
                'observation' => $inputArray['observation'],
                'parent_video_upload' => $inputArray['parent_video_upload'],
                'enrollment_id' => $inputArray['enrollment_id'],
                'description' => $inputArray['description'],
                'materials_required' => $inputArray['materials_required'],
                'to_observe' => $inputArray['to_observe'],
                'to_ask_parents' => $inputArray['to_ask_parents'],
                'enablef2f' => $inputArray['enablef2f'],
            ];
            // $this->WriteFileLog($input);

            DB::transaction(function () use ($input) {

                // New
                $authID = Auth::id();
                $enrollment_id = $input['enrollment_id'];

                $role_name = DB::select("SELECT role_name FROM uam_roles AS ur INNER JOIN users us ON (us.array_roles=ur.role_id) WHERE us.id=$authID");
                $enrollment_details = DB::select("SELECT * FROM enrollment_details WHERE enrollment_id = $enrollment_id");
                $enrollment_user_id = $enrollment_details[0]->user_id;
                $child_contact_email = $enrollment_details[0]->child_contact_email;
                $child_name = $enrollment_details[0]->child_name;
                $enrollment_child_num = $enrollment_details[0]->enrollment_child_num;

                $parent_video_upload = $input['parent_video_upload'];
                $observation = $input['observation'];
                $approval_status = $input['approval_status'];
                $comments = $input['comments'];
                $activity_initiation = $input['activity_initiation'];
                $description = $input['description'];

                $materials_required = $input['materials_required'];
                $to_observe = $input['to_observe'];
                $to_ask_parents = $input['to_ask_parents'];
                $enablef2f = $input['enablef2f'];

                foreach ($parent_video_upload as $video) {
                    $approval_status_check = $approval_status[$video];
                    $f2f_flag = isset($enablef2f[$video]);
                    // $this->WriteFileLog($approval_status_check );
                    if ($approval_status_check != null) {
                        // $this->WriteFileLog('if');
                        // $this->WriteFileLog($approval_status_check );
                        DB::table('parent_video_upload')
                            ->where('parent_video_upload_id', $video)
                            ->update([
                                'status' => $approval_status[$video],
                                'save_status' => $approval_status[$video],
                                'save_status1' => $approval_status[$video],
                                'last_modified_by' => $authID,
                                'last_modified_date' => NOW(),
                                'comments' => $observation[$video],
                            ]);
                        // Retrieve activity_description_id and activity_id
                        $activity_data = DB::table('parent_video_upload')
                            ->select('activity_description_id', 'activity_id')
                            ->where('parent_video_upload_id', $video)
                            ->first();

                        if ($observation[$video] != null) {
                            DB::table('sail_activity_vlog_comments')->insertGetId([
                                'activity_id' =>  $activity_data->activity_id,
                                'activity_description_id' => $activity_data->activity_description_id,
                                'observation' => $observation[$video],
                                'enrollment_id' => $enrollment_id,
                                'created_at' => NOW(),
                                'created_by' => $authID,
                                'parent_video_upload_id' => $video,
                            ]);
                        }


                        if ($comments[$video] != null) {
                            // DB::table('latest_video_comments')->insertGetId([
                            //     'activity_initiation_id' => $activity_initiation[$video],
                            //     'parent_video_upload_id' => $video,
                            //     'user_name' => auth()->user()->name,
                            //     'active_status' => $approval_status[$video],
                            //     'created_by' => $authID,
                            //     'created_at' => NOW(),
                            //     'comments' => $comments[$video],
                            //     'role' => $role_name[0]->role_name
                            // ]);
                            if ($comments[$video] != null) {
                                DB::table('latest_video_comments')->updateOrInsert(
                                    [
                                        'parent_video_upload_id' => $video,
                                        'created_by' => $authID,
                                        'active_status' => $approval_status[$video],
                                    ],
                                    [
                                        'activity_initiation_id' => $activity_initiation[$video],
                                        'user_name' => auth()->user()->name,
                                        'created_at' => NOW(),
                                        'comments' => $comments[$video],
                                        'role' => $role_name[0]->role_name
                                    ]
                                );
                            }

                            DB::table('sail_activity_vlog_comments')->insertGetId([
                                'activity_id' =>  $activity_data->activity_id,
                                'activity_description_id' => $activity_data->activity_description_id,
                                'observation' => $observation[$video],
                                'enrollment_id' => $enrollment_id,
                                'created_at' => NOW(),
                                'created_by' => $authID,
                                'parent_video_upload_id' => $video,
                            ]);
                        }

                        $approval_status_des = $approval_status[$video];
                        if ($approval_status_des == 'Complete') {
                            DB::table('activity_complete')->where('parent_video_id', $video)->update(['completed' => '1']);
                            DB::table('notifications')->insertGetId([
                                'user_id' => $enrollment_user_id,
                                'notification_type' => 'activity',
                                'notification_status' => 'Initiated',
                                'notification_url' => 'parent_video_upload/parent_create/' . encrypt($activity_initiation[$video]),
                                'megcontent' => "Activity " . $description[$video] . " has been Approved.",
                                'alert_meg' => "Activity " . $description[$video] . " has been Approved.",
                                'created_by' => auth()->user()->id,
                                'created_at' => NOW()
                            ]);
                            // $data = array(
                            //     'status' => $approval_status_des,
                            //     'des' => $description[$video],
                            //     'child_name'=>$child_name,
                            //     'en_no'=>$enrollment_child_num,
                            // );
                            // Mail::to($child_contact_email)->send(new ActivityMail($data));
                        } else {
                            $check_video = explode(",", $input['check_video']);
                            foreach ($check_video as $row) {
                                DB::table('activity_parent_video_upload')->where('video_link_id', $row)->update(['status' => '1']);
                            }
                            DB::table('notifications')->insertGetId([
                                'user_id' => $enrollment_user_id,
                                'notification_type' => 'activity',
                                'notification_status' => 'Initiated',
                                'notification_url' => 'parent_video_upload/parent_create/' . encrypt($activity_initiation[$video]),
                                'megcontent' => "Activity " . $description[$video] . " has been " . $approval_status_des,
                                'alert_meg' => "Activity " . $description[$video] . " has been " . $approval_status_des,
                                'created_by' => auth()->user()->id,
                                'created_at' => NOW()
                            ]);
                            $data = array(
                                'status' => $approval_status_des,
                                'des' => $description[$video],
                                'child_name' => $child_name,
                                'en_no' => $enrollment_child_num,
                                'isms_base' => config('setting.isms_base'),
                            );
                            Mail::to($child_contact_email)->send(new RejectionActivityMail($data));
                        }
                    }
                    if ($f2f_flag) {
                        DB::table('parent_video_upload')
                            ->where('parent_video_upload_id', $video)
                            ->update([
                                'last_modified_by' => $authID,
                                'last_modified_date' => NOW(),
                                'f2f_flag' => $f2f_flag,
                            ]);

                        DB::table('face_to_face_observation')->updateOrInsert(
                            ['parent_video_id' => $video],
                            [
                                'materials_required' => (isset($materials_required[$video]) ? implode(',', $materials_required[$video]) : ''),
                                'to_observe' => (isset($to_observe[$video]) ? $to_observe[$video] : ''),
                                'to_ask_parents' => (isset($to_ask_parents[$video]) ? $to_ask_parents[$video] : ''),
                                'parent_video_id' => $video
                            ]
                        );
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

    public function save_video(Request $request)
    {
        try {
            $method = 'Method =>  activityInitiationController => save_video';

            $inputArray = $this->decryptData($request->requestData);
            $input = [
                'activity_initiation' => $inputArray['activity_initiation'],
                'approval_status' => $inputArray['approval_status'],
                'comments' => $inputArray['comments'],
                'check_video' => $inputArray['check_video'],
                'observation' => $inputArray['observation'],
                'parent_video_upload' => $inputArray['parent_video_upload'],
                'enrollment_id' => $inputArray['enrollment_id'],
                'description' => $inputArray['description'],
                'materials_required' => $inputArray['materials_required'],
                'to_observe' => $inputArray['to_observe'],
                'to_ask_parents' => $inputArray['to_ask_parents'],
                'enablef2f' => $inputArray['enablef2f'],
                'pvID' => $inputArray['pvID'],
            ];

            DB::transaction(function () use ($input) {

                // New
                $authID = Auth::id();
                $enrollment_id = $input['enrollment_id'];

                $role_name = DB::select("SELECT role_name FROM uam_roles AS ur INNER JOIN users us ON (us.array_roles=ur.role_id) WHERE us.id=$authID");
                $enrollment_details = DB::select("SELECT * FROM enrollment_details WHERE enrollment_id = $enrollment_id");
                $enrollment_user_id = $enrollment_details[0]->user_id;
                $child_contact_email = $enrollment_details[0]->child_contact_email;
                $child_name = $enrollment_details[0]->child_name;
                $enrollment_child_num = $enrollment_details[0]->enrollment_child_num;

                $parent_video_upload = $input['parent_video_upload'];
                $observation = $input['observation'];
                $approval_status = $input['approval_status'];
                $comments = $input['comments'];
                $activity_initiation = $input['activity_initiation'];
                $description = $input['description'];

                // F2F
                $materials_required = $input['materials_required'];
                $to_observe = $input['to_observe'];
                $to_ask_parents = $input['to_ask_parents'];
                $enablef2f = $input['enablef2f'];
                // DB::table('parent_video_upload')->where('enrollment_id', $enrollment_id)->update(['f2f_flag' => '0']);
                DB::table('parent_video_upload')->where('enrollment_id', $enrollment_id)->whereNotIn('status', ['Complete', 'Rejected'])->update(['f2f_flag' => '0']);
                foreach ($parent_video_upload as $video) {
                    $approval_status_check = $approval_status[$video];
                    $f2f_flag = isset($enablef2f[$video]);

                    $updateData = [
                        'last_modified_by'  => $authID,
                        'last_modified_date' => NOW(),
                        'comments'          => $observation[$video],
                        'save_status1'      => $approval_status[$video],
                    ];

                    if ($input['pvID'] == $video) {
                        $updateData['save_status'] = 'Saved';
                    }

                    DB::table('parent_video_upload')
                        ->where('parent_video_upload_id', $video)
                        ->update($updateData);


                    if ($comments[$video] != null) {
                        DB::table('latest_video_comments')->updateOrInsert(
                            [
                                'parent_video_upload_id' => $video,
                                'created_by' => $authID,
                                'active_status' => $approval_status[$video],
                            ],
                            [
                                'activity_initiation_id' => $activity_initiation[$video],
                                'user_name' => auth()->user()->name,
                                'active_status' => $approval_status[$video],
                                'created_at' => NOW(),
                                'comments' => $comments[$video],
                                'role' => $role_name[0]->role_name
                            ]
                        );
                    }

                    if ($f2f_flag) {
                        DB::table('parent_video_upload')
                            ->where('parent_video_upload_id', $video)
                            ->update([
                                'last_modified_by' => $authID,
                                'last_modified_date' => NOW(),
                                'f2f_flag' => $f2f_flag,
                            ]);

                        DB::table('face_to_face_observation')->updateOrInsert(
                            ['parent_video_id' => $video],
                            [
                                'materials_required' => (isset($materials_required[$video]) ? implode(',', $materials_required[$video]) : ''),
                                'to_observe' => (isset($to_observe[$video]) ? $to_observe[$video] : ''),
                                'to_ask_parents' => (isset($to_ask_parents[$video]) ? $to_ask_parents[$video] : ''),
                                'parent_video_id' => $video
                            ]
                        );
                    }
                    $approval_status_des = $approval_status[$video];
                    if ($approval_status_des == 'Complete') {

                        DB::table('activity_complete')->where('parent_video_id', $video)->update(['completed' => '1']);
                    } else {
                        $check_video = explode(",", $input['check_video']);

                        foreach ($check_video as $row) {
                            DB::table('activity_parent_video_upload')->where('video_link_id', $row)->update(['status' => '1']);
                        }
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

    public function send_required(Request $request)
    {
        try {
            $method = 'Method =>  activityInitiationController => send_required';
            $inputArray = $this->decryptData($request->requestData);
            $input = [
                'activityids' => $inputArray['activityids'],
                'emaildraft' => $inputArray['emaildraft'],
                'enrollment_id' => $inputArray['enrollment_id'],
            ];

            DB::transaction(function () use ($input) {
                $activityids = $input['activityids'];
                foreach ($activityids as $activity) {
                    DB::table('parent_video_upload')
                        ->where('parent_video_upload_id', $activity)
                        ->update([
                            'required' => 1,
                        ]);
                }
                $enrollment_child_num = $input['enrollment_id'];
                $enrollment = DB::select("SELECT * FROM enrollment_details WHERE enrollment_child_num='$enrollment_child_num'");

                $data = array(
                    'emaildraft' => $input['emaildraft'],
                );

                Mail::to($enrollment[0]->child_contact_email)->send(new ActivityRequiredMail($data));
            });

            $serviceResponse = array();
            $serviceResponse['Code'] = config('setting.status_code.success');
            $serviceResponse['Message'] = config('setting.status_message.success');
            $serviceResponse['Data'] = 200;
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
    public function activity_f2fstore(Request $request)
    {
        // $this->WriteFileLog("activity_f2fstore");
        try {
            $method = 'Method =>  activityInitiationController => activity_f2fstore';

            $inputArray = $this->decryptData($request->requestData);
            $input = [
                'enrollment_id' => $inputArray['enrollment_id'],
                'activity_id' => $inputArray['activity_id'],
                'descriptionID' => $inputArray['descriptionID'],
                'to_observe' => $inputArray['to_observe'],
                'ask_parent' => $inputArray['ask_parent'],
                'Observation' => $inputArray['Observation'],
                'materials' => $inputArray['materials'],
                'actionf2f' => $inputArray['actionf2f']
            ];

            DB::transaction(function () use ($input) {

                // New
                $authID = Auth::id();
                $enrollment_id = $input['enrollment_id'];
                $observation = $input['Observation'];
                $description = $input['descriptionID'];
                $activity_id = $input['activity_id'];

                // F2F
                $materials_required = $input['materials'];
                $to_observe = $input['to_observe'];
                $to_ask_parents = $input['ask_parent'];

                $enrollment = DB::table('enrollment_details')
                    ->where('enrollment_child_num', $enrollment_id)
                    ->first();

                $enrollmentID = $enrollment->enrollment_id ?? null; // 310

                $currentF2fFlag = DB::table('parent_video_upload')
                    ->where('activity_description_id', $description)
                    ->where('Enrollment_id', $enrollmentID)
                    ->where('activity_id', $activity_id)
                    ->value('f2f_flag');

                $updateValues = [
                    'comments' => isset($observation) ? $observation : '',
                    'activity_description_id' => $description,
                    'Enrollment_id' => $enrollmentID,
                    'activity_id' => $activity_id,
                ];

                if ($currentF2fFlag !== 1) {
                    $updateValues['f2f_flag'] = ($input['actionf2f'] == 'Save') ? 2 : 1;
                }

                DB::table('parent_video_upload')->updateOrInsert(
                    [
                        'activity_description_id' => $description,
                        'Enrollment_id' => $enrollmentID,
                        'activity_id' => $activity_id
                    ],
                    $updateValues
                );

                $id = DB::table('parent_video_upload')
                    ->where('Enrollment_id', $enrollmentID)
                    ->where('activity_id', $activity_id)
                    ->where('activity_description_id', $description)
                    ->value('parent_video_upload_id');

                DB::table('face_to_face_observation')->updateOrInsert(
                    ['parent_video_id' => $id],
                    [
                        'materials_required' => (isset($materials_required) ? implode(',', $materials_required) : ''),
                        'to_observe' => (isset($to_observe) ? $to_observe : ''),
                        'to_ask_parents' => (isset($to_ask_parents) ? $to_ask_parents : ''),
                        'parent_video_id' => $id
                    ]
                );
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

    public function activity_f2fedit($id)
    {
        try {
            $method = 'Method => activityInitiationController => activity_f2fedit';
            $id = $this->DecryptData($id);
            // $this->WriteFileLog($id);
            $area_edit = DB::table('face_to_face_observation')
                ->select('*')
                ->where('parent_video_id', $id)
                ->get();
            $area_comments = DB::table('parent_video_upload')
                ->select('*')
                ->where('parent_video_id', $id)
                ->get();

            $response = [
                'area_edit' =>  $area_edit,
                'area_comments' => $area_comments
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

    public function activity_f2fupdate(Request $request)
    {

        try {
            $method = 'Method => activityInitiationController => activity_f2fupdate';
            $inputArray = $this->decryptData($request->requestData);
            $input = [
                'enrollment_id' => $inputArray['enrollment_id'],
                'activity_id' => $inputArray['activity_id'],
                'descriptionID' => $inputArray['descriptionID'],
                'to_observe' => $inputArray['to_observe'],
                'ask_parent' => $inputArray['ask_parent'],
                'materials' => $inputArray['materials'],
                'Observation' => $inputArray['Observation'],
                'parent_video_id' => $inputArray['parent_video_id'],

            ];
            DB::transaction(function () use ($input) {

                // New
                $authID = Auth::id();
                $enrollment_id = $input['enrollment_id'];
                // $this->WriteFileLog($enrollment_id);
                $observation = $input['Observation'];

                $description = $input['descriptionID'];
                $activity_id = $input['activity_id'];

                // F2F
                $materials_required = $input['materials'];
                $to_observe = $input['to_observe'];
                $to_ask_parents = $input['ask_parent'];
                $parent_video_id = $input['parent_video_id'];
                $enrollment = DB::select("SELECT * FROM enrollment_details WHERE enrollment_child_num ='$enrollment_id'");
                $en_id = $enrollment[0]->enrollment_id;
                DB::table('parent_video_upload')
                    ->where('parent_video_upload_id', $parent_video_id)
                    ->where('Enrollment_id', $en_id)
                    ->update([
                        'comments' => (isset($observation) ? $observation : ''), // Add the 'comments' field
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
    public function activity_f2fdelete(Request $request)
    {
        try {
            // $this->WriteFileLog($request);
            $method = 'Method => activityInitiationController => activity_f2fdelete';
            $inputArray = $this->decryptData($request->requestData);
            $input = [
                'id' => $inputArray['id'],
            ];
            // $this->WriteFileLog($input);
            $area_edit = DB::table('face_to_face_observation')
                ->where('parent_video_id', $input['id'])
                ->delete();
            $area_comments = DB::table('parent_video_upload')
                ->select('parent_video_upload.*', 'activity.*', 'activity_description.*')
                ->join('activity', 'parent_video_upload.activity_id', '=', 'activity.activity_id')
                ->join('activity_description', 'parent_video_upload.activity_description_id', '=', 'activity_description.activity_description_id')
                ->where('parent_video_upload_id', $input['id'])
                ->update(['f2f_flag' => 0]); // Update 'f2f' flag to 0



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

    public function fetch(Request $request)
    {
        // $this->WriteFileLog($request);

        try {
            $method = 'Method => activityInitiationController =>fetch';
            $userID = auth()->user()->id;
            // $rows = DB::select("SELECT role_id from uam_roles  where user_id=$userID");
            // $role_id=$rows[0]->role_id;
            $inputArray = $this->decryptData($request->requestData);
            $input = [
                'id' => $inputArray['id'],
            ];
            $id = $input['id'];
            // $this->WriteFileLog($id);
            $area_edit = DB::table('face_to_face_observation')
                ->select('*')
                ->where('parent_video_id', $id)
                ->get();
            $area_comments = DB::table('parent_video_upload')
                ->select('parent_video_upload.*', 'activity.*', 'activity_description.*')
                ->join('activity', 'parent_video_upload.activity_id', '=', 'activity.activity_id')
                ->join('activity_description', 'parent_video_upload.activity_description_id', '=', 'activity_description.activity_description_id')
                ->where('parent_video_upload_id', $id)
                ->get();


            $response = [
                'rows' => $area_edit,
                'rows1' => $area_comments
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
