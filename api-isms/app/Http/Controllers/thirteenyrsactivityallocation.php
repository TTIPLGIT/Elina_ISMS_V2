<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class thirteenyrsactivityallocation extends BaseController
{
    public function index(Request $request)
    {
        try {

            $method = 'Method => thirteenyrsactivityallocation => index';

            $rows = DB::table('activity')
                ->select('*')
                ->where('active_flag', 0)
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

    public function createdata()
    {
        //echo "naa";exit;
        try {
            $method = 'Method => thirteenyrsactivityallocation => createdata';


            $rows = DB::select('select * from activity');


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

    public function storedata(Request $request)
    {
        try {
            $method = 'Method => thirteenyrsactivityallocation => storedata';

            $inputArray = $this->DecryptData($request->requestData);
            $input = [
                'activity_name' => $inputArray['activity_name'],
                'description' => $inputArray['description'],
                // 'attached_file_path' => $inputArray['attached_file_path'],
                // 'imagename' => $inputArray['imagename'],
                // 'filepath' => $inputArray['filepath'],
                'instruction' => $inputArray['instruction'],
                'group' => $inputArray['group'],
                'type' => $inputArray['type'],
            ];
            DB::transaction(function () use ($input) {
                $videocreation = DB::table('activity')->insertGetId([
                    'group'=>$input['group'],
                    'category'=>$input['type'],
                    'activity_name' => $input['activity_name'],
                    // 'attached_file_path' => $input['attached_file_path'],
                    // 'filepath' => $input['filepath'],
                    'created_by' => auth()->user()->id,
                    'created_date' => NOW()
                ]);

                $option = $input['description'];
                // $file_attachement = $input['imagename'];
                $instruction_array = $input['instruction'];
                foreach ($option as $i => $description) {
                    // $file = $file_attachement[$i] ?? '';
                    $instruction = $instruction_array[$i] ?? '';

                    DB::table('activity_description')->insertGetId([
                        'activity_id' => $videocreation,
                        'description' => $description,
                        // 'file_attachment' => $file,
                        'instruction' => $instruction,
                        'created_by' => auth()->user()->id,
                        'created_date' => NOW()
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


    public function data_edit($id)
    {

        try {

            $method = 'Method => thirteenyrsactivityallocation => data_edit';

            $descriptionID = $this->DecryptData($id);

            $rows = DB::select("SELECT a.* ,b.*,act.*,us.* from parent_video_upload AS a 
             INNER JOIN enrollment_details AS b ON  b.enrollment_id=a.enrollment_id 
             INNER JOIN activity AS act ON act.activity_id=a.activity_id 
             INNER JOIN activity_description AS us ON us.activity_description_id=a.activity_description_id WHERE activity_initiation_id=$descriptionID");


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

    public function data_edit_1($id)
    {
        try {

            $method = 'Method => thirteenyrsactivityallocation => data_edit_1';
            $id = $this->DecryptData($id);
            $rows = DB::select(" select * from activity AS qd 
            INNER JOIN activity_description AS ques ON ques.activity_id=qd.activity_id WHERE qd.activity_id = $id");
            $activity = DB::select(" select * from activity_description AS qd 
            INNER JOIN activity AS ques ON ques.activity_id=qd.activity_id and activity_description_id =$id");
            $video = DB::select("select * from activity Where activity_id=$id");
            $activity_materials = DB::select("SELECT * FROM activity_materials");
            $activity_materials_mapping = DB::select("SELECT * FROM activity_materials_mapping");

            $response = [
                'rows' => $rows,
                'video' => $video,
                'activity' => $activity,
                'activity_materials' => $activity_materials,
                'activity_materials_mapping' => $activity_materials_mapping
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
    public function indexdata(Request $request)
    {
        try {

            $method = 'Method => thirteenyrsactivityallocation => index';

            $id = Auth::id();
            // $rows = DB::select("SELECT pvu.status as videoState, a.* ,b.*,act.*,us.* from activity_initiation AS a 
            // INNER JOIN enrollment_details AS b ON  b.enrollment_id=a.enrollment_id 
            // INNER JOIN activity AS act ON act.activity_id=a.activity_id 
            // INNER JOIN users AS us ON us.id=b.user_id
            // INNER JOIN parent_video_upload AS pvu ON pvu.activity_initiation_id=a.activity_initiation_id
            // where us.id='$id' GROUP BY a.activity_id");

            $rows = DB::select("SELECT a.enrollment_id,(SELECT ad.description FROM activity_description ad WHERE ad.activity_id = a.activity_id LIMIT 1) AS description,a.activity_id,a.status AS currentStatus,
            b.activity_name,a.activity_initiation_id,(SELECT COUNT(*) FROM parent_video_upload AS pv WHERE pv.activity_id = a.activity_id AND pv.Enrollment_id = c.enrollment_id AND pv.`status` = 'Rejected') AS isReject
        FROM activity_initiation AS a INNER JOIN activity AS b ON b.activity_id = a.activity_id INNER JOIN enrollment_details AS c ON a.enrollment_id = c.enrollment_id INNER JOIN users AS d ON d.id = c.user_id WHERE
            d.id = '$id' AND a.action_flag = 0 ORDER BY a.activity_initiation_id ASC;");

            $state  = DB::select("SELECT pvu.status as videoState, a.* ,b.*,act.*,us.* from activity_initiation AS a 
            INNER JOIN enrollment_details AS b ON  b.enrollment_id=a.enrollment_id 
            INNER JOIN activity AS act ON act.activity_id=a.activity_id 
            INNER JOIN users AS us ON us.id=b.user_id
            INNER JOIN parent_video_upload AS pvu ON pvu.activity_initiation_id=a.activity_initiation_id
            where us.id='$id'  ORDER BY a.activity_initiation_id DESC ");

            $com = DB::select("SELECT COUNT(*) AS complete , a.activity_initiation_id , a.activity_id FROM parent_video_upload AS a
            INNER JOIN enrollment_details AS b ON a.Enrollment_id=b.enrollment_id 
            WHERE (a.STATUS = 'Submitted' OR a.status = 'Re-Sent' OR a.status = 'Complete') AND b.user_id='$id' GROUP BY activity_id");

            $total = DB::select("SELECT COUNT(*) AS total , activity_id from parent_video_upload AS a
            INNER JOIN enrollment_details AS b ON b.enrollment_id=a.Enrollment_id
            WHERE user_id = $id AND a.enableflag = 0 GROUP BY activity_id");

            $policy = DB::select("SELECT * FROM policy_publish WHERE id=2");
            $privacy_status = DB::select("SELECT * FROM activity_initiation AS a 
            INNER JOIN enrollment_details AS b ON a.enrollment_id=b.enrollment_id
            WHERE b.user_id=$id AND a.privacy_status = 1");

            $response = [
                'rows' => $rows,
                'com' => $com,
                'state' => $state,
                'total' => $total,
                'policy' => $policy,
                'privacy_status' => $privacy_status,
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

    public function parent_createdata($id)
    {
        //echo "naa";exit;
        try {
            $method = 'Method => thirteenyrsactivityallocation => createdata';

            $descriptionID = $this->DecryptData($id);
            $id = auth()->user()->id;
            $email = DB::select("SELECT * from enrollment_details where user_id=$id");

            $enroll = $email[0]->enrollment_id;
            $rows = DB::select("SELECT a.instruction , a.activity_id , a.activity_description_id ,act.activity_name , a.enrollment_id from parent_video_upload AS a 
            INNER JOIN enrollment_details AS b ON  b.enrollment_id=a.enrollment_id 
            INNER JOIN activity AS act ON act.activity_id=a.activity_id 
            INNER JOIN activity_description AS us ON us.activity_description_id=a.activity_description_id WHERE activity_initiation_id=$descriptionID");
            $activityID = $rows[0]->activity_id;
            $activitylist = DB::select("SELECT save_flag , required , parent_video_upload_id , a.status , a.activity_description_id, a.status AS current_status , a.instruction , us.description , a.f2f_flag from parent_video_upload AS a 
            INNER JOIN enrollment_details AS b ON  b.enrollment_id=a.enrollment_id 
            INNER JOIN activity AS act ON act.activity_id=a.activity_id 
            INNER JOIN activity_description AS us ON us.activity_description_id=a.activity_description_id
            WHERE a.enableflag = 0 and a.activity_id=$activityID and b.user_id=$id ORDER BY a.activity_id,a.activity_description_id");

            $activitylist_nav = DB::select("SELECT save_flag , required , parent_video_upload_id , a.status , a.activity_description_id, a.status AS current_status , a.instruction,us.activity_description_id, us.description,act.activity_name,a.f2f_flag from parent_video_upload AS a 
                 INNER JOIN enrollment_details AS b ON  b.enrollment_id=a.enrollment_id 
                           INNER JOIN activity AS act ON act.activity_id=a.activity_id 
                         INNER JOIN activity_description AS us ON us.activity_description_id=a.activity_description_id
                        WHERE a.enableflag = 0 and a.status='New' and b.user_id=$id ORDER BY a.activity_id,a.activity_description_id");
            $activitylist_rejection = DB::select("SELECT save_flag , required , parent_video_upload_id,act.activity_name , a.status , a.activity_description_id, a.status AS current_status , a.instruction , us.description , a.f2f_flag from parent_video_upload AS a 
             INNER JOIN enrollment_details AS b ON  b.enrollment_id=a.enrollment_id 
             INNER JOIN activity AS act ON act.activity_id=a.activity_id 
             INNER JOIN activity_description AS us ON us.activity_description_id=a.activity_description_id
             WHERE a.enableflag = 0 and a.status='Rejected'and b.user_id=$id ORDER BY a.activity_id,a.activity_description_id");

            $comments = DB::select("SELECT * FROM latest_video_comments WHERE activity_initiation_id=$descriptionID ORDER BY id DESC ");
            $video_link = DB::select("SELECT * FROM activity_parent_video_upload WHERE parent_video_upload_id IN(SELECT distinct a.parent_video_upload_id  FROM parent_video_upload AS a
            INNER JOIN activity_parent_video_upload AS b ON a.parent_video_upload_id=b.parent_video_upload_id
            INNER JOIN enrollment_details AS c ON  a.Enrollment_id=c.enrollment_id
            WHERE c.user_id='$id')");

            $general_instruction = DB::select("select * from policy_publish where id='4'");
            $activities_list = DB::select("SELECT activity_initiation_id FROM activity_initiation WHERE enrollment_id = $enroll AND action_flag = 0 ORDER BY activity_id ASC ");
            // $this->WriteFileLog($activities_list);

            $response = [
                'rows' => $rows,
                'activitylist' => $activitylist,
                'comments' => $comments,
                'video_link' => $video_link,
                'general_instruction' => $general_instruction[0]->policy_content,
                'activities_list' => $activities_list,
                'activitylist_nav' => $activitylist_nav,
                'activitylist_rejection'=>$activitylist_rejection ,

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

    public function Getdescription(Request $request)

    {
        $logMethod = 'Method => thirteenyrsactivityallocation => Getdescription';

        try {

            $inputArray = $request->requestData;
            $enrollment_id = $request->enrollment_id;
            $selectedID = implode(',', $inputArray);
            $id = [];
            foreach ($inputArray as $key => $value) {
                $id[$key] = DB::select("SELECT b.activity_id,b.group, a.activity_description_id , a.description , a.instruction , b.activity_name from activity_description AS a
                INNER JOIN activity AS b ON b.activity_id = a.activity_id 
                WHERE b.activity_id = $value");
            }

            $active = DB::select("select * from activity_description AS a
            INNER JOIN parent_video_upload AS b ON a.activity_description_id=b.activity_description_id
            WHERE Enrollment_id=$enrollment_id");

            $initiated = DB::select("select GROUP_CONCAT(concat(b.activity_description_id) SEPARATOR ',') AS initiated  from activity_description AS a
            INNER JOIN parent_video_upload AS b ON a.activity_description_id=b.activity_description_id
            WHERE Enrollment_id=$enrollment_id");

            $prevData = DB::select("SELECT count(*) as co from activity_initiation WHERE activity_initiation_id NOT IN (SELECT activity_initiation_id from activity_initiation WHERE 
            STATUS = 'Complete' OR STATUS = 'Close') AND enrollment_id = $enrollment_id ");

            $desc = DB::select("SELECT * FROM parent_video_upload AS a
            INNER JOIN activity AS b ON a.activity_id=b.activity_id
            INNER JOIN activity_description AS c ON a.activity_description_id=c.activity_description_id
            WHERE enrollment_id = $enrollment_id AND a.activity_id in ($selectedID) AND STATUS = 'Complete'");

            $savedDescription = DB::select("SELECT GROUP_CONCAT(activity_description_id) AS savedDescription FROM parent_video_upload WHERE enrollment_id = $enrollment_id AND enableflag = 0");

            $response = [
                'id' => $id,
                'active' => $active,
                'initiated' => $initiated,
                'prevData' => $prevData,
                'desc' => $desc,
                'savedDescription' => $savedDescription
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



    public function parent_storedata(Request $request)
    {
        try {
            $method = 'Method => thirteenyrsactivityallocation => parent_storedata';
            $inputArray = $this->DecryptData($request->requestData);
            $input = [
                'video_link' => $inputArray['video_link'],
                'parent_video_upload_id' => $inputArray['parent_video_upload_id'],
                'comments' => $inputArray['comments'],
                'activity_description_id' => $inputArray['activity_description_id'],
                'current_status' => $inputArray['current_status'],
                'unable_flag' => $inputArray['unable_flag'],
            ];

            $reid = DB::transaction(function () use ($input) {
                $current_status = $input['current_status'];
                if ($current_status == 'Rejected') {
                    $state = 'Re-Sent';
                } else {
                    $state = 'Submitted';
                }

                $last_id = DB::table('parent_video_upload')

                    ->where('parent_video_upload_id', $input['parent_video_upload_id'])
                    ->update([
                        'status' => $state,
                        // 'f2f_flag' => ($input['unable_flag'] == 1 ? '1' : '0'),
                        'last_modified_by' => auth()->user()->id,
                        'last_modified_date' => NOW()
                    ]);
                DB::select("Delete from activity_parent_video_upload where parent_video_upload_id =" . $input['parent_video_upload_id']);
                foreach ($input['video_link'] as $video_link) {
                    DB::table('activity_parent_video_upload')
                        ->where('video_link_id', $input['video_link'])
                        ->insert([
                            'video_link' => $video_link,
                            'parent_video_upload_id' => $input['parent_video_upload_id'],
                            'status' => '0',
                            'created_by' => auth()->user()->id,
                            'created_at' => NOW()
                        ]);
                }

                $initiateID = $input['parent_video_upload_id'];
                $pvu = DB::select("SELECT * FROM parent_video_upload WHERE parent_video_upload_id = $initiateID");
                $enID = $pvu[0]->Enrollment_id;
                $enrol = DB::select("SELECT * FROM enrollment_details WHERE Enrollment_id = $enID");

                $role_name = DB::select("SELECT role_name FROM uam_roles AS ur INNER JOIN users us ON (us.array_roles=ur.role_id) WHERE us.id=" . auth()->user()->id);

                DB::table('latest_video_comments')->insertGetId([
                    'parent_video_upload_id' => $input['parent_video_upload_id'],
                    'activity_initiation_id' => $pvu[0]->activity_initiation_id,
                    'user_name' => auth()->user()->name,
                    'active_status' => $state,
                    'created_by' => auth()->user()->id,
                    'created_at' => NOW(),
                    'comments' => $input['comments'],
                    'role' => $role_name[0]->role_name
                ]);

                $activity_description_id = $input['activity_description_id'];
                $active_des = DB::select("SELECT * FROM activity_description AS ad INNER JOIN activity AS a ON a.activity_id=ad.activity_id
                WHERE ad.activity_description_id=$activity_description_id");
                $idIn = $pvu[0]->activity_initiation_id;
                $rr = DB::select("SELECT * FROM parent_video_upload WHERE activity_initiation_id = $idIn AND STATUS = 'New'");

                $enChi = $enrol[0]->enrollment_child_num;
                $sail = DB::select("SELECT JSON_EXTRACT(is_coordinator1, '$.id') AS coID FROM sail_details WHERE enrollment_id = '$enChi'");

                DB::table('notifications')->insertGetId([
                    'user_id' =>  $sail[0]->coID,
                    'notification_type' => 'activity',
                    'notification_status' => 'Updated',
                    'notification_url' => 'activity_initiate/' . encrypt($pvu[0]->activity_initiation_id) . '/edit',
                    'megcontent' => $active_des[0]->activity_name . " has been " . $state . " by " . $enrol[0]->child_name . " (" . $enrol[0]->enrollment_child_num . ")",
                    'alert_meg' => $active_des[0]->activity_name . " has been " . $state . " by " . $enrol[0]->child_name . " (" . $enrol[0]->enrollment_child_num . ")",
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
                            'notification_status' => 'Updated',
                            'notification_url' => 'activity_initiate/' . encrypt($pvu[0]->activity_initiation_id) . '/edit',
                            'megcontent' => $active_des[0]->activity_name . " has been " . $state . " by " . $enrol[0]->child_name . " (" . $enrol[0]->enrollment_child_num . ")",
                            'alert_meg' => $active_des[0]->activity_name . " has been " . $state . " by " . $enrol[0]->child_name . " (" . $enrol[0]->enrollment_child_num . ")",
                            'created_by' => auth()->user()->id,
                            'created_at' => NOW()
                        ]);
                    }
                }
                $re = $pvu[0]->activity_initiation_id;
                return $re;
            });

            $serviceResponse = array();
            $serviceResponse['Code'] = config('setting.status_code.success');
            $serviceResponse['Message'] = config('setting.status_message.success');
            $serviceResponse['Data'] = $reid;
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
    public function parent_storedata_bulk(Request $request)
    {
        try {
            $method = 'Method => thirteenyrsactivityallocation => parent_storedata';
            $inputArray = $this->DecryptData($request->requestData);
            $input = [
                'video_link' => $inputArray['video_link'],
                'parent_video_upload_id' => $inputArray['parent_video_upload_id'],
                'comments' => $inputArray['comments'],
                'activity_description_id' => $inputArray['activity_description_id'],
                'current_status' => $inputArray['current_status'],
                'activity_name' => $inputArray['activity_name'],
                'submit_type' => $inputArray['submit_type'],
                'save_flag' => $inputArray['save_flag'],
            ];

            $reid = DB::transaction(function () use ($input) {
                // New
                $activity_description = $input['activity_description_id'];
                $comments = $input['comments'];
                $current_status = $input['current_status'];
                $video_link = $input['video_link'];
                $save_flag = $input['save_flag'];

                $fpVid = array_keys($activity_description);
                $pvCount = count($fpVid);

                $role_name = DB::select("SELECT role_name FROM uam_roles AS ur INNER JOIN users us ON (us.array_roles=ur.role_id) WHERE us.id=" . auth()->user()->id);

                for ($k = 0; $k < $pvCount; $k++) {
                    $pId = $fpVid[$k];
                    // if ($video_link[$pId][0]) {

                    if ($current_status[$pId] == 'Rejected') {
                        $state = 'Re-Sent';
                    } else {
                        if ($comments[$pId] == null && $video_link[$pId][0] == null) {
                            $state = 'New';
                        } else {
                            $state = 'Submitted';
                        }
                    }

                    if ($input['submit_type'] == 'Save') {
                        $state = 'New';
                    }

                    DB::table('parent_video_upload')
                        ->where('parent_video_upload_id', $pId)
                        ->update([
                            // 'comments' => $comments[$pId],
                            'status' => $state,
                            'save_flag' => ($input['submit_type'] == 'Save' && $video_link[$pId][0] != null ? '1' : '0'),
                            'last_modified_by' => auth()->user()->id,
                            'last_modified_date' => NOW()
                        ]);

                    DB::select("Delete from activity_parent_video_upload where parent_video_upload_id =" . $pId);
                    foreach ($video_link[$pId] as $video) {
                        if ($video != '' || $video != null) {
                            DB::table('activity_parent_video_upload')
                                ->where('video_link_id', $input['video_link'])
                                ->insert([
                                    'video_link' => $video,
                                    'parent_video_upload_id' => $pId,
                                    'status' => '0',
                                    'created_by' => auth()->user()->id,
                                    'created_at' => NOW()
                                ]);
                        }
                    }
                    if ($comments[$pId] != null) {
                        $pvu = DB::select("SELECT * FROM parent_video_upload WHERE parent_video_upload_id = $pId");
                        if ($save_flag[$pId] == 0) {
                            DB::table('latest_video_comments')->insertGetId([
                                'parent_video_upload_id' => $pId,
                                'activity_initiation_id' => $pvu[0]->activity_initiation_id,
                                'user_name' => auth()->user()->name,
                                'active_status' => $state,
                                'created_by' => auth()->user()->id,
                                'created_at' => NOW(),
                                'comments' => $comments[$pId],
                                'role' => $role_name[0]->role_name
                            ]);
                        } else {
                            $lvc = DB::select("SELECT * FROM latest_video_comments WHERE parent_video_upload_id = $pId and created_by = " . auth()->user()->id . " ORDER BY id DESC");
                            DB::table('latest_video_comments')
                                ->where('id', $lvc[0]->id)
                                ->update([
                                    'parent_video_upload_id' => $pId,
                                    'activity_initiation_id' => $pvu[0]->activity_initiation_id,
                                    'user_name' => auth()->user()->name,
                                    'active_status' => $state,
                                    'created_by' => auth()->user()->id,
                                    'created_at' => NOW(),
                                    'comments' => $comments[$pId],
                                    'role' => $role_name[0]->role_name
                                ]);
                        }
                    }
                }
                // }

                $pvu = DB::select("SELECT * FROM parent_video_upload WHERE parent_video_upload_id = $fpVid[0]");
                $enID = $pvu[0]->Enrollment_id;
                $enrol = DB::select("SELECT * FROM enrollment_details WHERE Enrollment_id = $enID");
                $enChi = $enrol[0]->enrollment_child_num;
                $sail = DB::select("SELECT JSON_EXTRACT(is_coordinator1, '$.id') AS coID FROM sail_details WHERE enrollment_id = '$enChi'");
                // $state = 'Submitted';
                DB::table('notifications')->insertGetId([
                    'user_id' =>  $sail[0]->coID,
                    'notification_type' => 'activity',
                    'notification_status' => 'Updated',
                    'notification_url' => 'activity_initiate/' . encrypt($pvu[0]->activity_initiation_id) . '/edit',
                    'megcontent' => $input['activity_name'] . " has been " . $state . " by " . $enrol[0]->child_name . " (" . $enrol[0]->enrollment_child_num . ")",
                    'alert_meg' => $input['activity_name'] . " has been " . $state . " by " . $enrol[0]->child_name . " (" . $enrol[0]->enrollment_child_num . ")",
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
                            'notification_status' => 'Updated',
                            'notification_url' => 'activity_initiate/' . encrypt($pvu[0]->activity_initiation_id) . '/edit',
                            'megcontent' => $input['activity_name'] . " has been " . $state . " by " . $enrol[0]->child_name . " (" . $enrol[0]->enrollment_child_num . ")",
                            'alert_meg' => $input['activity_name'] . " has been " . $state . " by " . $enrol[0]->child_name . " (" . $enrol[0]->enrollment_child_num . ")",
                            'created_by' => auth()->user()->id,
                            'created_at' => NOW()
                        ]);
                    }
                }
                // Activity set 1 has been submitted by Kaviya -> Activity set 1 has been submitted by Kaviya
                // End New
                $re = $pvu[0]->activity_initiation_id;
                return $re;
            });

            $serviceResponse = array();
            $serviceResponse['Code'] = config('setting.status_code.success');
            $serviceResponse['Message'] = config('setting.status_message.success');
            $serviceResponse['Data'] = $reid;
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

            $method = 'Method =>  thirteenyrsactivityallocation => updatedata';

            $inputArray = $this->decryptData($request->requestData);

            $input = [
                'id' => $inputArray['id'],
                'activity_name' => $inputArray['activity_name'],
                'description' => $inputArray['description'],
                'attached_file_path' => $inputArray['attached_file_path'],
                'imagename' => $inputArray['imagename'],
                // 'filepath'=> $inputArray['filepath'],
                'instruction' => $inputArray['instruction'],
                'newdescription' => $inputArray['newdescription'],
                'newinstruction' => $inputArray['newinstruction'],
            ];


            $id = $input['id'];
            $activity = DB::select("SELECT activity_id FROM activity_description WHERE activity_description_id ='$id'");
            $activity_id = $activity[0]->activity_id;

            // DB::table('activity_description')->where('activity_id', $activity_id)->delete();

            DB::transaction(function () use ($input, $activity_id) {

                DB::table('activity')
                    ->where('activity_id', $activity_id)
                    ->update([
                        'activity_name' => $input['activity_name'],
                        'last_modified_by' => auth()->user()->id,
                        'last_modified_date' => NOW()
                    ]);

                $option = $input['description'];
                $file_attachement = $input['imagename'];
                $instruction_array = $input['instruction'];

                foreach ($option as $i => $description) {
                    $file = $file_attachement[$i] ?? '';
                    $instruction = $instruction_array[$i] ?? '';

                    DB::table('activity_description')
                        ->where('activity_description_id', $i)
                        ->update([
                            'activity_id' => $activity_id,
                            'description' => $description,
                            'file_attachment' => $file,
                            'instruction' => $instruction,
                            'created_by' => auth()->user()->id,
                            'created_date' => NOW()
                        ]);
                }

                // New Start
                $option = $input['newdescription'];
                // $file_attachement = $input['imagename'];
                if ($option != '') {
                    $instruction_array = $input['newinstruction'];
                    foreach ($option as $i => $description) {
                        // $file = $file_attachement[$i] ?? '';
                        $instruction = $instruction_array[$i] ?? '';

                        DB::table('activity_description')->insertGetId([
                            'activity_id' => $activity_id,
                            'description' => $description,
                            // 'file_attachment' => $file,
                            'instruction' => $instruction,
                            'created_by' => auth()->user()->id,
                            'created_date' => NOW()
                        ]);
                    }
                }
                // New End
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
    public function mapping_update(Request $request)
    {
        try {

            $method = 'Method =>  thirteenyrsactivityallocation => mapping_update';

            $inputArray = $this->decryptData($request->requestData);

            $input = [
                'id' => $inputArray['id'],
                'activity_name' => $inputArray['activity_name'],
                'description' => $inputArray['description'],
                'material' => $inputArray['material'],
            ];

            DB::transaction(function () use ($input) {
                $material = $input['material'];
                if ($material != '') {

                    foreach ($material as $key => $value) {
                        foreach ($value as $key1 => $value2) {
                            if (is_numeric($value2)) {
                            } else {
                                $materialsID = DB::table('activity_materials')->insertGetId([
                                    'materials' => $value2,
                                ]);
                                $material[$key][$key1] = $materialsID;
                            }
                        }
                    }

                    foreach ($material as $key => $value) {
                        DB::table('activity_materials_mapping')->where('activity_description_id', $key)->delete();
                        DB::table('activity_materials_mapping')->insertGetId([
                            'activity_description_id' => $key,
                            'activity_materials_id' => implode(',', $value),
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
    //     public function updatedata(Request $request)
    // {$this->WriteFileLog("hiii");

    //     try {

    //         $method = 'Method =>  UserregisterfeeController => updatedata';

    //         $inputArray = $this->decryptData($request->requestData);
    //         $input = [
    //             'id' => $inputArray['id'],
    //             'activity_name' => $inputArray['activity_name'],
    //             'description' => $inputArray['description'],
    //             // 'attached_file_path' => $inputArray['attached_file_path'],
    //             // 'imagename'=> $inputArray['imagename'],
    //             // 'filepath'=> $inputArray['filepath'],
    //         ];


    //     DB::transaction(function () use ($input) {

    //                 DB::table('activity_description')
    //                 ->where('activity_description_id' ,$input['id'])
    //                 ->update([

    //                     'description' => $input['description'],

    //                     'created_by' => auth()->user()->id,
    //                     'created_date' => NOW()

    //                 ]);
    //                 $this->WriteFileLog($input);
    //             //   $role_name=DB::select("SELECT role_name FROM uam_roles AS ur
    //             //       INNER JOIN users us ON (us.array_roles=ur.role_id) WHERE us.id=".auth()->user()->id);

    //             //   $role_name_fetch=$role_name[0]->role_name;
    //             // $this->auditLog('activity_description', $input, 'Update', 'Update a description', auth()->user()->id, NOW(), 'Activity Updated');
    //         });

    //         $serviceResponse = array();
    //         $serviceResponse['Code'] = config('setting.status_code.success');
    //         $serviceResponse['Message'] = config('setting.status_message.success');
    //         $serviceResponse['Data'] = 1;
    //         $serviceResponse = json_encode($serviceResponse, JSON_FORCE_OBJECT);
    //         $sendServiceResponse = $this->SendServiceResponse($serviceResponse, config('setting.status_code.success'), true);
    //         return $sendServiceResponse;
    //     } catch (\Exception $exc) {
    //         $exceptionResponse = array();
    //         $exceptionResponse['ServiceMethod'] = $method;
    //         $exceptionResponse['Exception'] = $exc->getMessage();
    //         $exceptionResponse = json_encode($exceptionResponse, JSON_FORCE_OBJECT);
    //         $this->WriteFileLog($exceptionResponse);
    //         $serviceResponse = array();
    //         $serviceResponse['Code'] = config('setting.status_code.exception');
    //         $serviceResponse['Message'] = $exc->getMessage();
    //         $serviceResponse = json_encode($serviceResponse, JSON_FORCE_OBJECT);
    //         $sendServiceResponse = $this->SendServiceResponse($serviceResponse, config('setting.status_code.exception'), false);
    //         return $sendServiceResponse;
    //     }
    // }

    public function delete($id)
    {
        try {

            $method = 'Method => thirteenyrsactivityallocation => delete';
            $id = $this->decryptData($id);

            DB::transaction(function () use ($id) {
                $uam_modules_id =  DB::table('activity')
                    ->where('activity_id', $id)
                    ->update([
                        'active_flag' => 1
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

    public function policyaggrement(Request $request)
    {
        try {
            $method = 'Method => thirteenyrsactivityallocation => policyaggrement';
            // $this->WriteFileLog($method);
            $inputArray = $this->DecryptData($request->requestData);
            $input = [
                'enrollment_id' => $inputArray['enrollment_id'],
                'activity_initiation_id' => $inputArray['activity_initiation_id'],
            ];

            DB::transaction(function () use ($input) {


                DB::table('activity_initiation')
                    ->where('enrollment_id', $input['enrollment_id'])
                    ->update([
                        'privacy_status' => 1,
                    ]);

                // $admin_details = DB::SELECT("SELECT * from users where array_roles = '4' or array_roles = '5' ");
                // $adminn_count = count($admin_details);
                // if ($admin_details != []) {
                //     for ($j = 0; $j < $adminn_count; $j++) {

                //         DB::table('notifications')->insertGetId([
                //             'user_id' =>  $admin_details[$j]->id,
                //             'notification_type' => 'activity',
                //             'notification_status' => 'Updated',
                //             'notification_url' => 'activity_initiate/' . encrypt($pvu[0]->activity_initiation_id) . '/edit',
                //             'megcontent' => '" '.$active_des[0]->activity_name." - ".$active_des[0]->description.' "'." Activity has been Submitted by " . $enrol[0]->child_name . " (" . $enrol[0]->enrollment_child_num . ")",
                //             'alert_meg' => '" '.$active_des[0]->activity_name." - ".$active_des[0]->description.' "'. " Activity has been Submitted by " . $enrol[0]->child_name . " (" . $enrol[0]->enrollment_child_num . ")",
                //             'created_by' => auth()->user()->id,
                //             'created_at' => NOW()
                //         ]);
                //     }
                // }
                // }

            });

            $serviceResponse = array();
            $serviceResponse['Code'] = config('setting.status_code.success');
            $serviceResponse['Message'] = config('setting.status_message.success');
            $serviceResponse['Data'] = $inputArray['activity_initiation_id'];
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
