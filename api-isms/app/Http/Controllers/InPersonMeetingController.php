<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Googl;
use Illuminate\Support\Facades\DB;
use DateTime;
use DateTimeZone;

class InPersonMeetingController extends BaseController
{
    public function index(Request $request , Googl $googl)
    {

        try {

            $method = 'Method => InPersonMeetingController => index';
            $authID = auth()->user()->id;
            $saveAlert = DB::select("SELECT * FROM in_person_meeting WHERE meeting_status = 'Saved' AND created_date <= NOW() - INTERVAL 1 DAY AND created_by = $authID");
            $this->updateGoogleEvent($googl);
            $log = DB::select("SELECT * FROM in_person_meeting AS sd
            INNER JOIN ovm_status_logs AS b ON sd.enrollment_id = b.enrollment_id
            where b.audit_table_name = 'in_person_meeting'
            ORDER BY b.id DESC ");

            $role_name = DB::select("SELECT role_name FROM uam_roles AS ur
            INNER JOIN users us ON (us.array_roles=ur.role_id) WHERE us.id=" . auth()->user()->id);
            $role_name_fetch = $role_name[0]->role_name;
            if ($role_name_fetch == 'IS Coordinator') {
                $rows = [];
                $fieldOptions1 =DB::select('
                SELECT
                    a.meeting_id, a.meeting_unique, b.name AS user_id, a.is_coordinator1, a.is_coordinator2,
                    a.enrollment_id, a.child_id, a.child_name, a.meeting_to, a.meeting_subject,
                    a.meeting_startdate, a.meeting_enddate, a.meeting_location, a.meeting_status,
                    a.meeting_description, a.created_by, a.created_date, a.last_modified_by,
                    a.last_modified_date, a.active_flag, a.meeting_starttime, a.meeting_endtime
                FROM
                    in_person_meeting AS a
                INNER JOIN
                    users b ON a.user_id = b.id
                WHERE
                    JSON_EXTRACT(is_coordinator1, "$.id") = ' . $authID . ' OR
                    JSON_EXTRACT(is_coordinator2, "$.id") = ' . $authID . '
                ORDER BY
                    a.meeting_id DESC');

                foreach ($fieldOptions1 as $field_detail1) {
                    array_push($rows, $field_detail1);
                }

                usort($rows, function ($first, $second) {
                    return $first->meeting_id < $second->meeting_id;
                });
            } else {
                $rows = DB::select("SELECT a.meeting_id,a.meeting_unique,b.name AS user_id,a.is_coordinator1,a.enrollment_id,a.child_id,a.child_name,a.is_coordinator2,
                a.meeting_to,a.meeting_subject,a.meeting_startdate,a.meeting_enddate,a.meeting_location,
                a.meeting_status,a.meeting_description,a.created_by,a.created_date,a.last_modified_by,
                a.last_modified_date,a.active_flag,a.meeting_starttime,a.meeting_endtime
                from in_person_meeting as a inner JOIN users b ON a.user_id = b.id
                ORDER BY a.meeting_id DESC ");
            }
            $attendeeStatus = DB::select("select * from ovm_attendees where ovm_type = '3' and attendee =" . auth()->user()->id);
            $attendee = DB::select("SELECT ovm_id FROM ovm_attendees where ovm_type = '3' and attendee =" . auth()->user()->id);

            $response = [
                'rows' => $rows,
                'saveAlert' => $saveAlert,
                'log' => $log,
                'attendeeStatus' => $attendeeStatus,
                'attendee' => $attendee
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
            $method = 'Method => InPersonMeetingController => create';
            
            $authID = auth()->user()->id;

            $role_name = DB::select("SELECT role_name FROM uam_roles AS ur INNER JOIN users us ON (us.array_roles=ur.role_id) WHERE us.id= $authID");
            $role_name_fetch = $role_name[0]->role_name;
                        
            $rows = array();
            if ($role_name_fetch == 'IS Coordinator') {
                $rows['enrollment_details'] = DB::select("SELECT a.* FROM enrollment_details AS a INNER JOIN sail_details AS b ON b.enrollment_id=a.enrollment_child_num
                WHERE a.Enrollment_id IN (SELECT Enrollment_id FROM activity_initiation) AND (JSON_EXTRACT(is_coordinator1, '$.id') = $authID or JSON_EXTRACT(is_coordinator2, '$.id') = $authID) AND a.Enrollment_id NOT IN (SELECT enrollment_id FROM in_person_meeting )
                ORDER BY a.Enrollment_id DESC");
            } else {
                $rows['enrollment_details'] = DB::select("SELECT * FROM enrollment_details WHERE Enrollment_id IN (SELECT Enrollment_id FROM activity_initiation) AND Enrollment_id NOT IN (SELECT enrollment_id FROM in_person_meeting )
                ORDER BY Enrollment_id DESC ");
            }

            $rows['iscoordinators'] = DB::select("SELECT * from users
                right JOIN uam_user_roles ON uam_user_roles.user_id=users.id
                right JOIN uam_roles on uam_roles.role_id = uam_user_roles.role_id
                WHERE uam_roles.role_name='IS Coordinator' AND users.active_flag=0");

            $email = DB::select("SELECT * FROM email_preview WHERE screen = 'F2F' AND active_flag = 0");
            $users = DB::select("SELECT * FROM users WHERE (array_roles = 4 OR array_roles = 5) AND active_flag = 0");

            $response = [
                'rows' => $rows,
                'email' => $email,
                'users' => $users,
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
    public function GetSailDetails(Request $request)
    {
        try {
            $logMethod = 'Method => InPersonMeetingController => GetSailDetails';
            $id = $request->requestData;

            $enrollment = DB::select("select * from enrollment_details where enrollment_id = '$id'");
            $enrollment_child_num = $enrollment[0]->enrollment_child_num;
            $sail = DB::select("SELECT JSON_EXTRACT(is_coordinator1, '$.id') AS coordinator , JSON_EXTRACT(is_coordinator2, '$.id') AS coordinator2 FROM sail_details WHERE enrollment_id = '$enrollment_child_num'");

            $response = [
                'enrollment' => $enrollment,
                'sail' => $sail,
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

    public function store(Request $request, Googl $googl)
    {
        try {
            $method = 'Method => InPersonMeetingController => store';
            $userID =  auth()->user()->id;
            $inputArray = $this->decryptData($request->requestData);

            $is_coordinator1 = $inputArray['is_coordinator1'];
            $is_coordinator1 = DB::select('Select id,email,name from users where id=' . $is_coordinator1);
            $authuser = DB::select('Select id,email,name from users where id=' . $userID);
            $is_coordinator1json = json_encode($is_coordinator1[0], JSON_FORCE_OBJECT);

            $is_coordinator2 = $inputArray['is_coordinator2'];
            $is_coordinator2 = DB::select('Select id,email,name from users where id=' . $is_coordinator2);
            $is_coordinator2json = json_encode($is_coordinator2[0], JSON_FORCE_OBJECT);

            $mail_cc = $inputArray['mail_cc'];
            $carbon_copy = array();
            if ($mail_cc != '') {
                foreach ($mail_cc as $cc) {
                    array_push($carbon_copy, array('email' => $cc));
                }
            }

            $attendees = array(
                array('email' => $inputArray['meeting_to']),
                array('email' => $is_coordinator1[0]->email),
                array('email' => $is_coordinator2[0]->email),
            );

            $enrollment_id = $inputArray['enrollment_child_num'];
            $email_users = [$authuser, $is_coordinator1 , $is_coordinator2];

            $date_str = $inputArray['meeting_startdate'] . $inputArray['meeting_starttime'] . ':00';
            $date_obj = DateTime::createFromFormat('d/m/Y H:i:s', $date_str , new DateTimeZone('Asia/Kolkata'));

            if ($date_obj instanceof DateTime) {
                $date_obj->setTimezone(new DateTimeZone('UTC'));
                $startTime = $date_obj->format('c');
            } else {
                $date_str = $inputArray['meeting_startdate'] . $inputArray['meeting_starttime'];
                $date_obj = DateTime::createFromFormat('d/m/Y H:i:s', $date_str , new DateTimeZone('Asia/Kolkata'));
                $date_obj->setTimezone(new DateTimeZone('UTC'));
                $startTime = $date_obj->format('c');
            }

            $date_str = $inputArray['meeting_enddate'] . $inputArray['meeting_endtime'] . ':00';
            $date_obj = DateTime::createFromFormat('d/m/Y H:i:s', $date_str, new DateTimeZone('Asia/Kolkata'));

            if ($date_obj instanceof DateTime) {
                $date_obj->setTimezone(new DateTimeZone('UTC'));
                $endTime = $date_obj->format('c');
            } else {
                $date_str = $inputArray['meeting_enddate'] . $inputArray['meeting_endtime'];
                $date_obj = DateTime::createFromFormat('d/m/Y H:i:s', $date_str, new DateTimeZone('Asia/Kolkata'));
                $date_obj->setTimezone(new DateTimeZone('UTC'));
                $endTime = $date_obj->format('c');
            }

            $input = [
                'enrollment_child_num' => $inputArray['enrollment_child_num'],
                'enrollment_id' => $inputArray['enrollment_id'],
                'child_id' => $inputArray['child_id'],
                'is_coordinator1' => $is_coordinator1json,
                'is_coordinator2' => $is_coordinator2json,
                'child_name' => $inputArray['child_name'],
                'meeting_to' => $inputArray['meeting_to'],
                'meeting_subject' => $inputArray['meeting_subject'],
                'meeting_startdate' => $inputArray['meeting_startdate'],
                'meeting_enddate' => $inputArray['meeting_enddate'],
                'meeting_starttime' => $inputArray['meeting_starttime'],
                'meeting_endtime' => $inputArray['meeting_endtime'],
                'meeting_location' => $inputArray['meeting_location'],
                'meeting_description' => $inputArray['meeting_description'],
                'meeting_status' => $inputArray['meeting_status'],
                'type' => $inputArray['type'],
                'user_id' => $inputArray['user_id'],
                'mail_cc' => $inputArray['mail_cc'],
                'mode_of_meeting' => $inputArray['meeting_mode'],
            ];
            $type = $input['type'];
            $mail_cc = $input['mail_cc'];
            $eventId = '';
            $eventLink = '';
            if ($type == "Sent") {
                $client = $googl->client();
                $service = new \Google_Service_Calendar($client);
                $event = new \Google_Service_Calendar_Event(array(
                    'summary' => $inputArray['meeting_subject'],
                    'location' => $inputArray['meeting_location'],
                    'description' => $inputArray['meeting_description'],
                    'start' => array('dateTime' => $startTime, 'timeZone' => 'Asia/Kolkata',),
                    'end' => array('dateTime' => $endTime, 'timeZone' => 'Asia/Kolkata',),
                    'attendees' => array_merge($carbon_copy, $attendees),
                    'reminders' => array('useDefault' => FALSE, 'overrides' => array(array('method' => 'email', 'minutes' => 24 * 60), array('method' => 'popup', 'minutes' => 10),),),
                    "conferenceData" => array("createRequest" => array("conferenceSolutionKey" => array("type" => "hangoutsMeet"), "requestId" => "123"))
                ));
                $includeMeetLink = $inputArray['meeting_mode'];
                if($includeMeetLink == 1){
                    $opts = array('sendNotifications' => true, 'conferenceDataVersion' => 1);
                }else{
                    $opts = array('sendNotifications' => true);
                }
                
                $event = $service->events->insert('primary', $event, $opts);
                $eventDetails = json_decode(json_encode($event), true);
                $eventLink = $eventDetails['hangoutLink'];
                $eventId = $event->getId();

                $admin_details = DB::SELECT("SELECT * from users where array_roles = '4'");
                $adminn_count = count($admin_details);
                if ($admin_details != []) {
                    for ($j = 0; $j < $adminn_count; $j++) {
                        $data = [
                            'enrollment_child_num' => $inputArray['enrollment_child_num'],
                            'child_id' => $inputArray['child_id'],
                            'child_name' => $inputArray['child_name'],
                            'meeting_startdate' => $inputArray['meeting_startdate'],
                            'meeting_enddate' => $inputArray['meeting_enddate'],
                            'child_name' => $inputArray['child_name'],
                            'startTime' => $startTime,
                            'endTime' => $endTime,
                            'email' => $admin_details[$j]->email,
                            'name' => $admin_details[$j]->name,
                        ];
                        // dispatch(new sendmailjob($data))->delay(now()->addSeconds(1));
                    }
                }
            }
            $user_check = DB::select("select * from in_person_meeting where enrollment_id = '$enrollment_id' and active_flag = 0");

            if ($user_check == []) {

                DB::transaction(function () use ($input, $is_coordinator1, $eventId, $eventLink , $is_coordinator2) {
                    $claimdetails = DB::table('in_person_meeting')->orderBy('meeting_unique', 'desc')->first();
                    if ($claimdetails == null) {
                        $claimnoticenoNew =  'F2F/' . date("Y") . '/' . date("m") . '/001';
                    } else {
                        $claimnoticeno = $claimdetails->meeting_unique;
                        $claimnoticenoNew =  ++$claimnoticeno;
                    }

                    $meeting = DB::table('in_person_meeting')
                        ->insertGetId([
                            'meeting_unique' => $claimnoticenoNew,
                            'enrollment_id' => $input['enrollment_id'],
                            'child_id' => $input['child_id'],
                            'is_coordinator1' => $input['is_coordinator1'],
                            'is_coordinator2' => $input['is_coordinator2'],
                            'child_name' => $input['child_name'],
                            'meeting_to' => $input['meeting_to'],
                            'meeting_subject' => $input['meeting_subject'],
                            'meeting_startdate' => $input['meeting_startdate'],
                            'meeting_enddate' => $input['meeting_enddate'],
                            'meeting_starttime' => $input['meeting_starttime'],
                            'meeting_endtime' => $input['meeting_endtime'],
                            'meeting_location' => $input['meeting_location'],
                            'meeting_description' => $input['meeting_description'],
                            'meeting_status' => $input['meeting_status'],
                            'remainder_flag' => ($input['meeting_status'] === 'Sent') ? 0 : null,
                            'user_id' => $input['user_id'],
                            'event_id' => ($input['type'] == 'Sent') ? $eventId : null,
                            'event_link' => ($input['type'] == 'Sent') ? $eventLink : null,
                            'created_by' => auth()->user()->id,
                            'created_date' => now(),
                            'mode_of_meeting' => $input['mode_of_meeting'],
                            'mail_cc' => ($input['mail_cc'] != '') ? implode(",", $input['mail_cc']) : null,
                        ]);

                    $this->auditLog('in_person_meeting', $meeting, 'F2F', 'create new F2F meeting details', auth()->user()->id, NOW(), ' $role_name_fetch');

                    $type = $input['type'];
                    if ($type == "Sent") {
                        $admin_details = DB::SELECT("SELECT * from users where array_roles = '4'");
                        $adminn_count = count($admin_details);
                        if ($admin_details != []) {
                            for ($j = 0; $j < $adminn_count; $j++) {

                                DB::table('notifications')->insertGetId([
                                    'user_id' =>  $admin_details[$j]->id,
                                    'notification_type' => 'activity',
                                    'notification_status' => 'F2F Meeting Scheduled',
                                    'notification_url' => 'inperson/edit/meeting/' . encrypt($meeting),
                                    'megcontent' => "F2F Meeting has been Scheduled Successfully for " . $input['child_name'] . " (" . $input['enrollment_child_num'] . " )",
                                    'alert_meg' => "F2F Meeting has been Scheduled Successfully for " . $input['child_name'] . " (" . $input['enrollment_child_num'] . " )",
                                    'created_by' => auth()->user()->id,
                                    'created_at' => NOW()
                                ]);
                            }
                        }

                        $en = $input['enrollment_id'];
                        $ee = DB::select("SELECT * FROM enrollment_details WHERE enrollment_id = '$en'");
                        DB::table('notifications')->insertGetId([
                            'user_id' => $ee[0]->user_id,
                            'notification_type' => 'activity',
                            'notification_status' => 'F2F Meeting Scheduled',
                            'notification_url' => 'inperson_meeting/' . encrypt($meeting),
                            'megcontent' => "F2F Meeting has been Scheduled Successfully for " . $input['child_name'] . "(" . $input['enrollment_child_num'] . ")",
                            'alert_meg' => "F2F Meeting has been Scheduled Successfully for " . $input['child_name'] . "(" . $input['enrollment_child_num'] . ")",
                            'created_by' => auth()->user()->id,
                            'created_at' => NOW()
                        ]);

                        DB::table('notifications')->insertGetId([
                            'user_id' =>  $is_coordinator1[0]->id,
                            'notification_type' => 'activity',
                            'notification_status' => 'F2F Meeting Scheduled',
                            'notification_url' => 'inperson/edit/meeting/' . encrypt($meeting),
                            'megcontent' => "F2f meeting invite for " . $input['child_name'] . " has been sent to you",
                            'alert_meg' => "F2f meeting invite for " . $input['child_name'] . " has been sent to you",
                            'created_by' => auth()->user()->id,
                            'created_at' => NOW()
                        ]);
                        DB::table('notifications')->insertGetId([
                            'user_id' =>  $is_coordinator2[0]->id,
                            'notification_type' => 'activity',
                            'notification_status' => 'F2F Meeting Scheduled',
                            'notification_url' => 'inperson/edit/meeting/' . encrypt($meeting),
                            'megcontent' => "F2f meeting invite for " . $input['child_name'] . " has been sent to you",
                            'alert_meg' => "F2f meeting invite for " . $input['child_name'] . " has been sent to you",
                            'created_by' => auth()->user()->id,
                            'created_at' => NOW()
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
            $method = 'Method => ovm1Controller => data_edit';
            $id = $this->DecryptData($id);
            $rows = DB::table('in_person_meeting as a')
                ->select('a.*', 'enrollment_details.enrollment_child_num')
                ->join('enrollment_details', 'enrollment_details.enrollment_id', '=', 'a.enrollment_id')
                ->where('a.meeting_id', $id)
                ->get();
            $attendee = DB::select("SELECT a.*,b.name from ovm_attendees AS a
                INNER JOIN users AS b ON a.attendee=b.id where ovm_id = $id and ovm_type=3");
            $iscoordinators = DB::select("SELECT * from users
            right JOIN uam_user_roles ON uam_user_roles.user_id=users.id
            right JOIN uam_roles on uam_roles.role_id = uam_user_roles.role_id
            WHERE uam_roles.role_name='IS Coordinator' AND users.active_flag=0");
            $users = DB::select("SELECT * FROM users WHERE array_roles != 3");
            $response = [
                'rows' => $rows,
                'iscoordinators' => $iscoordinators,
                'attendee' => $attendee,
                'users' => $users,
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
    public function updatedata(Request $request, Googl $googl)
    {
        try {
            $userID =  auth()->user()->id;
            $method = 'Method =>  InPersonMeetingController => updatedata';
            $inputArray = $this->decryptData($request->requestData);
            $status = $inputArray['meeting_status'];
            $is_coordinator1 = $inputArray['is_coordinator1'];
            $is_coordinator1 = DB::select('Select id,email,name from users where id=' . $is_coordinator1);
            $is_coordinator1json = json_encode($is_coordinator1[0], JSON_FORCE_OBJECT);

            $is_coordinator2 = $inputArray['is_coordinator2'];
            $is_coordinator2 = DB::select('Select id,email,name from users where id=' . $is_coordinator2);
            $is_coordinator2json = json_encode($is_coordinator2[0], JSON_FORCE_OBJECT);

            $mail_cc = $inputArray['mail_cc'];
            $a = array();
            if ($mail_cc != '') {
                $c = count($mail_cc);

                for ($k = 0; $k < $c; $k++) {
                    array_push($a, array('email' => $mail_cc[$k]));
                }
            }

            $attendees = array(
                array('email' => $inputArray['meeting_to']),
            );
            $attendees1 = array(
                array('email' => $is_coordinator1[0]->email),
                array('email' => $is_coordinator2[0]->email),
            );
            
            $date_str = $inputArray['meeting_startdate'] . $inputArray['meeting_starttime'] . ':00';
            $date_obj = DateTime::createFromFormat('d/m/Y H:i:s', $date_str , new DateTimeZone('Asia/Kolkata'));

            if ($date_obj instanceof DateTime) {
                $date_obj->setTimezone(new DateTimeZone('UTC'));
                $startTime = $date_obj->format('c');
            } else {
                $date_str = $inputArray['meeting_startdate'] . $inputArray['meeting_starttime'];
                $date_obj = DateTime::createFromFormat('d/m/Y H:i:s', $date_str , new DateTimeZone('Asia/Kolkata'));
                $date_obj->setTimezone(new DateTimeZone('UTC'));
                $startTime = $date_obj->format('c');
            }
            
            $date_str = $inputArray['meeting_enddate'] . $inputArray['meeting_endtime'] . ':00';
            $date_obj = DateTime::createFromFormat('d/m/Y H:i:s', $date_str, new DateTimeZone('Asia/Kolkata'));

            if ($date_obj instanceof DateTime) {
                $date_obj->setTimezone(new DateTimeZone('UTC'));
                $endTime = $date_obj->format('c');
            } else {
                $date_str = $inputArray['meeting_enddate'] . $inputArray['meeting_endtime'];
                $date_obj = DateTime::createFromFormat('d/m/Y H:i:s', $date_str, new DateTimeZone('Asia/Kolkata'));
                $date_obj->setTimezone(new DateTimeZone('UTC'));
                $endTime = $date_obj->format('c');
            }
            
            $input = [
                'id' => $inputArray['id'],
                'enrollment_child_num' => $inputArray['enrollment_child_num'],
                'enrollment_id' => $inputArray['enrollment_id'],
                'meeting_unique' => $inputArray['meeting_unique'],
                'child_id' => $inputArray['child_id'],
                'child_name' => $inputArray['child_name'],
                'meeting_to' => $inputArray['meeting_to'],
                'is_coordinator1' => $is_coordinator1json,
                'is_coordinator1u' => $inputArray['is_coordinator1'],
                'is_coordinator2' => $is_coordinator2json,
                'is_coordinator2u' => $inputArray['is_coordinator2'],
                'meeting_subject' => $inputArray['meeting_subject'],
                'meeting_startdate' => $inputArray['meeting_startdate'],
                'meeting_enddate' => $inputArray['meeting_enddate'],
                'meeting_starttime' => $inputArray['meeting_starttime'],
                'meeting_endtime' => $inputArray['meeting_endtime'],
                'meeting_location' => $inputArray['meeting_location'],
                'meeting_description' => $inputArray['meeting_description'],
                'meeting_status' => $inputArray['meeting_status'],
                'user_id' => $inputArray['user_id'],
                'type' => $inputArray['type'],
                'video_link' => $inputArray['video_link'],
                'notes' => $inputArray['notes'],
                'mail_cc' => $inputArray['mail_cc'],
                'mode_of_meeting' => $inputArray['meeting_mode'],
            ];
            
            $type = $input['type'];
            $meeting_status = $input['meeting_status'];
            if ($type == "Sent") {
                DB::table('in_person_meeting')
                    ->where('meeting_id', $input['id'])
                    ->update([
                        'created_by' => auth()->user()->id,
                        'remainder_flag' => 0,

                    ]);
                    
                $client = $googl->client();
                $service = new \Google_Service_Calendar($client);
                $event = new \Google_Service_Calendar_Event(array(
                    'summary' => $inputArray['meeting_subject'],
                    'location' => $inputArray['meeting_location'],
                    'description' => $inputArray['meeting_description'],
                    'start' => array('dateTime' => $startTime, 'timeZone' => 'Asia/Kolkata',),
                    'end' => array('dateTime' => $endTime, 'timeZone' => 'Asia/Kolkata',),
                    'attendees' => array_merge($attendees1, $a, $attendees),
                    'reminders' => array('useDefault' => FALSE, 'overrides' => array(array('method' => 'email', 'minutes' => 24 * 60), array('method' => 'popup', 'minutes' => 10),),),
                    "conferenceData" => array("createRequest" => array("conferenceSolutionKey" => array("type" => "hangoutsMeet"), "requestId" => "123"))
                ));
                
                if ($meeting_status == 'Rescheduled') {
                    $rrrr = $input['id'];
                    $admin_details = DB::SELECT("SELECT * FROM in_person_meeting WHERE meeting_id=$rrrr ");
                    $event->setSummary('Meeting Rescheduled');
                    $opts = array('sendNotifications' => true, 'conferenceDataVersion' => 1);
                    $updatedEvent = $service->events->update('primary', $admin_details[0]->event_id, $event, $opts);
                } else {
                    $opts = array('sendNotifications' => true, 'conferenceDataVersion' => 1);
                    $event = $service->events->insert('primary', $event, $opts);
                    $eventDetails = json_decode(json_encode($event), true);
                    $eventLink = $eventDetails['hangoutLink'];
                    $eventId = $event->getId();
                    DB::table('in_person_meeting')
                        ->where('meeting_id', $input['id'])
                        ->update([
                            'event_id' => $eventId,
                            'event_link' => $eventLink,
                        ]);
                }

                

                if ($meeting_status == 'Rescheduled') {

                    $admin_details = DB::SELECT("SELECT * from users where array_roles = '4'");
                    $adminn_count = count($admin_details);
                    if ($admin_details != []) {
                        for ($j = 0; $j < $adminn_count; $j++) {

                            DB::table('notifications')->insertGetId([
                                'user_id' =>  $admin_details[$j]->id,
                                'notification_type' => 'activity',
                                'notification_status' => 'F2F Meeting Scheduled',
                                'notification_url' => 'inperson/edit/meeting/' . encrypt($input['id']),
                                'megcontent' => "F2F Meeting for " . $input['child_name'] . "(" . $input['enrollment_child_num'] . ") has been Rescheduled",
                                'alert_meg' => "F2F Meeting for " . $input['child_name'] . "(" . $input['enrollment_child_num'] . ") has been Rescheduled",
                                'created_by' => auth()->user()->id,
                                'created_at' => NOW()
                            ]);
                        }
                    }
                    
                    $en = $input['enrollment_id'];
                    $ee = DB::select("SELECT * FROM enrollment_details WHERE enrollment_id = '$en'");

                    DB::table('notifications')->insertGetId([
                        'user_id' => $ee[0]->user_id,
                        'notification_type' => 'activity',
                        'notification_status' => 'F2F Meeting Scheduled',
                        'notification_url' => 'inperson/edit/meeting/' . encrypt($input['id']),
                        'megcontent' => "F2F Meeting for " . $input['child_name'] . "(" . $input['enrollment_child_num'] . ") has been Rescheduled",
                        'alert_meg' => "F2F Meeting for " . $input['child_name'] . "(" . $input['enrollment_child_num'] . ") has been Rescheduled",
                        'created_by' => auth()->user()->id,
                        'created_at' => NOW()
                    ]);
                    
                    DB::table('notifications')->insertGetId([
                        'user_id' =>  $input['is_coordinator1u'],
                        'notification_type' => 'activity',
                        'notification_status' => 'F2F Meeting Scheduled',
                        'notification_url' => 'inperson/edit/meeting/' . encrypt($input['id']),
                        'megcontent' => "F2F Meeting for " . $input['child_name'] . "(" . $input['enrollment_child_num'] . ") has been Rescheduled",
                        'alert_meg' => "F2F Meeting for " . $input['child_name'] . "(" . $input['enrollment_child_num'] . ") has been Rescheduled",
                        'created_by' => auth()->user()->id,
                        'created_at' => NOW()
                    ]);

                    DB::table('notifications')->insertGetId([
                        'user_id' =>  $input['is_coordinator2u'],
                        'notification_type' => 'activity',
                        'notification_status' => 'F2F Meeting Scheduled',
                        'notification_url' => 'inperson/edit/meeting/' . encrypt($input['id']),
                        'megcontent' => "F2F Meeting for " . $input['child_name'] . "(" . $input['enrollment_child_num'] . ") has been Rescheduled",
                        'alert_meg' => "F2F Meeting for " . $input['child_name'] . "(" . $input['enrollment_child_num'] . ") has been Rescheduled",
                        'created_by' => auth()->user()->id,
                        'created_at' => NOW()
                    ]);

                   
                } else {
                    
                    $admin_details = DB::SELECT("SELECT * from users where array_roles = '4'");
                    $adminn_count = count($admin_details);
                    if ($admin_details != []) {
                        for ($j = 0; $j < $adminn_count; $j++) {

                            DB::table('notifications')->insertGetId([
                                'user_id' =>  $admin_details[$j]->id,
                                'notification_type' => 'activity',
                                'notification_status' => 'F2F Meeting Scheduled',
                                'notification_url' => 'inperson/edit/meeting/' . encrypt($input['id']),
                                'megcontent' => "F2F Meeting has been Scheduled Successfully for " . $input['child_name'] . "(" . $input['enrollment_child_num'] . ")",
                                'alert_meg' => "F2F Meeting has been Scheduled Successfully for " . $input['child_name'] . "(" . $input['enrollment_child_num'] . ")",
                                'created_by' => auth()->user()->id,
                                'created_at' => NOW()
                            ]);
                        }
                    }
                    
                    $en = $input['enrollment_id'];
                    $ee = DB::select("SELECT * FROM enrollment_details WHERE enrollment_id = '$en'");
                    
                    DB::table('notifications')->insertGetId([
                        'user_id' => $ee[0]->user_id,
                        'notification_type' => 'activity',
                        'notification_status' => 'F2F Meeting Scheduled',
                        'notification_url' => 'inperson/edit/meeting/' . encrypt($input['id']),
                        'megcontent' => "F2F Meeting has been Scheduled Successfully for " . $input['child_name'] . "(" . $input['enrollment_child_num'] . ")",
                        'alert_meg' => "F2F Meeting has been Scheduled Successfully for " . $input['child_name'] . "(" . $input['enrollment_child_num'] . ")",
                        'created_by' => auth()->user()->id,
                        'created_at' => NOW()
                    ]);
                    
                    DB::table('notifications')->insertGetId([
                        'user_id' =>  $input['is_coordinator1u'],
                        'notification_type' => 'activity',
                        'notification_status' => 'F2F Meeting Scheduled',
                        'notification_url' => 'inperson/edit/meeting/' . encrypt($input['id']),
                        'megcontent' => "F2F Meeting Sent for you to attend " . $input['child_name'] . "(" . $input['enrollment_child_num'] . ")",
                        'alert_meg' => "F2F Meeting Sent for you to attend " . $input['child_name'] . "(" . $input['enrollment_child_num'] . ")",
                        'created_by' => auth()->user()->id,
                        'created_at' => NOW()
                    ]);
                    DB::table('notifications')->insertGetId([
                        'user_id' =>  $input['is_coordinator2u'],
                        'notification_type' => 'activity',
                        'notification_status' => 'F2F Meeting Scheduled',
                        'notification_url' => 'inperson/edit/meeting/' . encrypt($input['id']),
                        'megcontent' => "F2F Meeting Sent for you to attend " . $input['child_name'] . "(" . $input['enrollment_child_num'] . ")",
                        'alert_meg' => "F2F Meeting Sent for you to attend " . $input['child_name'] . "(" . $input['enrollment_child_num'] . ")",
                        'created_by' => auth()->user()->id,
                        'created_at' => NOW()
                    ]);
                  
                }
            }
            
            if ($type == "Reschedule Request") {

                $admin_details = DB::SELECT("SELECT * from users where array_roles = '4'");
                $adminn_count = count($admin_details);
                if ($admin_details != []) {
                    for ($j = 0; $j < $adminn_count; $j++) {

                        DB::table('notifications')->insertGetId([
                            'user_id' =>  $admin_details[$j]->id,
                            'notification_type' => 'activity',
                            'notification_status' => 'F2F Meeting Scheduled',
                            'notification_url' => 'inperson/edit/meeting/' . encrypt($input['id']),
                            'megcontent' => "F2F Meeting for " . $input['child_name'] . "(" . $input['enrollment_child_num'] . ") has Requested for Rescheduled by " . auth()->user()->name,
                            'alert_meg' => "F2F Meeting for " . $input['child_name'] . "(" . $input['enrollment_child_num'] . ") has Requested for Rescheduled by " . auth()->user()->name,
                            'created_by' => auth()->user()->id,
                            'created_at' => NOW()
                        ]);
                    }
                }
                $ReReqId = auth()->user()->id;
                $is_one = $input['is_coordinator1u'];
                if ($ReReqId != $is_one) {
                    DB::table('notifications')->insertGetId([
                        'user_id' =>  $input['is_coordinator1u'],
                        'notification_type' => 'activity',
                        'notification_status' => 'F2F Meeting Scheduled',
                        'notification_url' => 'inperson/edit/meeting/' . encrypt($input['id']),
                        'megcontent' => "F2F Meeting for " . $input['child_name'] . "(" . $input['enrollment_child_num'] . ") has Requested for Rescheduled by " . auth()->user()->name,
                        'alert_meg' => "F2F Meeting for " . $input['child_name'] . "(" . $input['enrollment_child_num'] . ") has Requested for Rescheduled by " . auth()->user()->name,
                        'created_by' => auth()->user()->id,
                        'created_at' => NOW()
                    ]);
                    DB::table('notifications')->insertGetId([
                        'user_id' =>  $input['is_coordinator2u'],
                        'notification_type' => 'activity',
                        'notification_status' => 'F2F Meeting Scheduled',
                        'notification_url' => 'inperson/edit/meeting/' . encrypt($input['id']),
                        'megcontent' => "F2F Meeting for " . $input['child_name'] . "(" . $input['enrollment_child_num'] . ") has Requested for Rescheduled by " . auth()->user()->name,
                        'alert_meg' => "F2F Meeting for " . $input['child_name'] . "(" . $input['enrollment_child_num'] . ") has Requested for Rescheduled by " . auth()->user()->name,
                        'created_by' => auth()->user()->id,
                        'created_at' => NOW()
                    ]);
                }
               
            }
            
            DB::transaction(function () use ($input, $status) {

                $c = DB::select("select * from in_person_meeting where meeting_id=" . $input['id']);
                $cre = $c[0]->created_by;
                $au = auth()->user()->id;
                $mid = $input['id'];

                if ($status != 'Accepted' || $status != 'Completed') {
                    if ($au == $cre) {
                        $meSt = $input['meeting_status'];

                        DB::table('ovm_attendees')
                            ->where('ovm_id', $input['id'])
                            ->update([
                                'overall_status' => $input['meeting_status']
                            ]);
                        $this->ovm_status_logs('in_person_meeting', $input['id'], 'F2F Meeting ' . $input['meeting_status'], 'OVM Status', auth()->user()->id, NOW(), $input['enrollment_child_num'], auth()->user()->name);
                    } else {
                        $meSt = $c[0]->meeting_status;
                        DB::select("Delete FROM ovm_attendees WHERE ovm_id = $mid AND created_by = $au");
                        DB::table('ovm_attendees')->insertGetId([
                            'ovm_type' =>  '3',
                            'ovm_id' => $input['id'],
                            'notes' => $input['notes'],
                            'attendee' => auth()->user()->id,
                            'status' => $input['meeting_status'],
                            'overall_status' => $input['meeting_status'],
                            'created_by' => auth()->user()->id,
                            'created_at' => NOW()
                        ]);
                        if ($input['meeting_status'] == 'Reschedule Request') {
                            $osl = 'Reschedule';
                        } else {
                            $osl = $input['meeting_status'];
                        }
                        $this->ovm_status_logs('in_person_meeting', $input['id'], 'F2F Meeting ' . $osl, 'OVM Status', auth()->user()->id, NOW(), $input['enrollment_child_num'], auth()->user()->name);
                    }
                } else {

                    $meSt = $c[0]->meeting_status;
                    $this->ovm_status_logs('in_person_meeting', $input['id'], 'F2F Meeting ' . $input['meeting_status'], 'OVM Status', auth()->user()->id, NOW(), $input['enrollment_child_num'], auth()->user()->name);
                }
                
                
                if ($status == 'Completed') {
                    $meSt = $input['meeting_status'];
                }

                DB::table('in_person_meeting')
                    ->where('meeting_id', $input['id'])
                    ->update([

                        'enrollment_id' => $input['enrollment_child_num'],
                        'meeting_unique' => $input['meeting_unique'],
                        'child_id' => $input['child_id'],
                        'is_coordinator1' => $input['is_coordinator1'],
                        'is_coordinator2' => $input['is_coordinator2'],
                        'child_name' => $input['child_name'],
                        'meeting_to' => $input['meeting_to'],
                        'meeting_subject' => $input['meeting_subject'],
                        'meeting_startdate' => $input['meeting_startdate'],
                        'meeting_enddate' => $input['meeting_enddate'],
                        'meeting_starttime' => $input['meeting_starttime'],
                        'meeting_endtime' => $input['meeting_endtime'],
                        'meeting_location' => $input['meeting_location'],
                        'meeting_description' => $input['meeting_description'],
                        'meeting_status' => $meSt,
                        'user_id' => $input['user_id'],
                        'mode_of_meeting' => $input['mode_of_meeting'],
                        'mail_cc' => ($input['mail_cc'] != '') ? implode(",", $input['mail_cc']) : null,
                        // 'created_by' => auth()->user()->id,
                        'created_date' => NOW()

                    ]);

                    
                $id = $this->elina_assessment_process($input['enrollment_id'], 'F2F meeting Update', 'OVM', 'create new f2f meeting details', auth()->user()->id, NOW());

                $ids = $this->elina_assessment($id, $input['enrollment_id'], 'F2F meeting Update', 'OVM', 'create new f2f meeting details', auth()->user()->id, NOW());

                $this->auditLog('in_person_meeting', $input['id'], 'Update', 'F2F Meeting', auth()->user()->id, NOW(), 'Rescheduled');
            });

            if ($status == 'Completed') {
                DB::transaction(function () use ($input) {
                    DB::table('notifications')->insertGetId([
                        'user_id' =>   $input['is_coordinator1u'],
                        'notification_type' => 'activity',
                        'notification_status' => 'F2F Meeting Completed',
                        'notification_url' => 'ovmcompleted/' . encrypt($input['id']),
                        'megcontent' => "F2F Meeting " . $input['child_name'] . " (" . $input['enrollment_child_num'] . ") " . " has been Completed",
                        'alert_meg' => "F2F Meeting " . $input['child_name'] . " (" . $input['enrollment_child_num'] . ") " . " has been Completed",
                        'created_by' => auth()->user()->id,
                        'created_at' => NOW()
                    ]);
                    DB::table('notifications')->insertGetId([
                        'user_id' =>   $input['is_coordinator2u'],
                        'notification_type' => 'activity',
                        'notification_status' => 'F2F Meeting Completed',
                        'notification_url' => 'ovmcompleted/' . encrypt($input['id']),
                        'megcontent' => "F2F Meeting " . $input['child_name'] . " (" . $input['enrollment_child_num'] . ") " . " has been Completed",
                        'alert_meg' => "F2F Meeting " . $input['child_name'] . " (" . $input['enrollment_child_num'] . ") " . " has been Completed",
                        'created_by' => auth()->user()->id,
                        'created_at' => NOW()
                    ]);
                
                });
                
                $admin_details = DB::SELECT("SELECT * from users where array_roles = '4'");
                $adminn_count = count($admin_details);
                if ($admin_details != []) {
                    for ($j = 0; $j < $adminn_count; $j++) {

                        DB::table('notifications')->insertGetId([
                            'user_id' =>  $admin_details[$j]->id,
                            'notification_type' => 'activity',
                            'notification_status' => 'F2F Meeting Scheduled',
                            'notification_url' => 'inperson/edit/meeting/' . encrypt($input['id']),
                            'megcontent' => "F2F Meeting for " . $input['child_name'] . " (" . $input['enrollment_child_num'] . " ) has been completed",
                            'alert_meg' => "F2F Meeting for " . $input['child_name'] . " (" . $input['enrollment_child_num'] . " ) has been completed",
                            'created_by' => auth()->user()->id,
                            'created_at' => NOW()
                        ]);
                    }
                }
                
                $en = $input['enrollment_id'];
                $ee = DB::select("SELECT * FROM enrollment_details WHERE enrollment_id = '$en'");

                DB::table('notifications')->insertGetId([
                    'user_id' => $ee[0]->user_id,
                    'notification_type' => 'activity',
                    'notification_status' => 'F2F Meeting Scheduled',
                    'notification_url' => 'inperson/edit/meeting/' . encrypt($input['id']),
                    'megcontent' => "F2F Meeting for " . $input['child_name'] . " (" . $input['enrollment_child_num'] . " ) has been completed",
                    'alert_meg' => "F2F Meeting for " . $input['child_name'] . " (" . $input['enrollment_child_num'] . " ) has been completed",
                    'created_by' => auth()->user()->id,
                    'created_at' => NOW()
                ]);

                DB::table('in_person_meeting')
                    ->where('meeting_id', $input['id'])
                    ->update([
                        'video_link' => $input['video_link']
                    ]);
                $id = $this->elina_assessment_process($input['enrollment_id'], 'F2F meeting Completed', 'OVM', 'create new f2f meeting details', auth()->user()->id, NOW());

                $id = $this->elina_assessment($id, $input['enrollment_id'], 'F2F meeting Completed', 'OVM', 'create new f2f meeting details', auth()->user()->id, NOW());
            }
            

            if ($status == 'Accepted' || $status == 'Declined' || $status == 'Completed') {
                DB::transaction(function () use ($input) {
                    DB::table('in_person_meeting')
                        ->where('meeting_id', $input['id'])
                        ->update([
                            'remainder_flag' => 1,
                        ]);
                });
            }
            if ($status == 'Accepted' || $status == 'Declined' || $status == 'Hold') {

                DB::transaction(function () use ($input, $status, $googl) {
                    $c = DB::select("select * from in_person_meeting where meeting_id=" . $input['id']);
                    $cre = $c[0]->created_by;
                    $au = auth()->user()->id;
                    if ($cre == $au) {
                        $megcontent = "F2F Meeting " . $input['child_name'] . " (" . $input['enrollment_child_num'] . ") " . " has been " . $status . " by " . auth()->user()->name;
                    } else {
                        $megcontent = "F2F Meeting " . $input['child_name'] . " (" . $input['enrollment_child_num'] . ") " . " has been requested for " . $status . " by " . auth()->user()->name;
                    }
                    if ($status == 'Accepted') {
                        $megcontent = "F2F Meeting " . $input['child_name'] . " (" . $input['enrollment_child_num'] . ") " . " has been " . $status . " by " . auth()->user()->name;
                    }
                    DB::table('notifications')->insertGetId([
                        'user_id' =>   $input['is_coordinator1u'],
                        'notification_type' => 'activity',
                        'notification_status' => 'F2F Meeting Scheduled',
                        'notification_url' => 'inperson/edit/meeting/' . encrypt($input['id']),
                        'megcontent' => $megcontent,
                        'alert_meg' => $megcontent,
                        'created_by' => auth()->user()->id,
                        'created_at' => NOW()
                    ]);
                    DB::table('notifications')->insertGetId([
                        'user_id' =>   $input['is_coordinator2u'],
                        'notification_type' => 'activity',
                        'notification_status' => 'F2F Meeting Scheduled',
                        'notification_url' => 'inperson/edit/meeting/' . encrypt($input['id']),
                        'megcontent' => $megcontent,
                        'alert_meg' => $megcontent,
                        'created_by' => auth()->user()->id,
                        'created_at' => NOW()
                    ]);
                    
                    if ($cre == $au) {
                        if ($status != 'Accepted') {
                            $en = $input['enrollment_id'];
                            $ee = DB::select("SELECT * FROM enrollment_details WHERE enrollment_id = '$en'");
                            DB::table('notifications')->insertGetId([
                                'user_id' => $ee[0]->user_id,
                                'notification_type' => 'activity',
                                'notification_status' => 'F2F Meeting Scheduled',
                                'notification_url' => 'inperson/edit/meeting/' . encrypt($input['id']),
                                'megcontent' => "F2F Meeting for " . $input['child_name'] . " (" . $input['enrollment_child_num'] . " ) has been " . $status . " by " . auth()->user()->name,
                                'alert_meg' => "F2F Meeting for " . $input['child_name'] . " (" . $input['enrollment_child_num'] . " ) has been " . $status . " by " . auth()->user()->name,
                                'created_by' => auth()->user()->id,
                                'created_at' => NOW()
                            ]);
                        }
                    }
                    $admin_details = DB::SELECT("SELECT * from users where array_roles = '4'");
                    $adminn_count = count($admin_details);
                    if ($admin_details != []) {
                        for ($j = 0; $j < $adminn_count; $j++) {
                            DB::table('notifications')->insertGetId([
                                'user_id' =>  $admin_details[$j]->id,
                                'notification_type' => 'activity',
                                'notification_status' => 'F2F Meeting Scheduled',
                                'notification_url' => 'inperson/edit/meeting/' . encrypt($input['id']),
                                'megcontent' => $megcontent,
                                'alert_meg' => $megcontent,
                                'created_by' => auth()->user()->id,
                                'created_at' => NOW()
                            ]);
                        }
                    }
                });
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

    public function updateGoogleEvent(Googl $googl){
        $f2f = DB::select("SELECT b.user_id as parentId , a.* , JSON_EXTRACT(a.is_coordinator1, '$.id') AS isc1 , 
        CONCAT(a.created_by , ',' , JSON_EXTRACT(a.is_coordinator1, '$.id') ) AS stakeholders 
        FROM in_person_meeting AS a
        INNER JOIN enrollment_details AS b ON b.enrollment_id = a.enrollment_id 
        WHERE a.meeting_status != 'Completed' AND a.meeting_status != 'Hold' 
        AND a.meeting_status != 'Saved' and a.active_flag = 0");
        foreach ($f2f as $row) {
            $event_id = $row->event_id;
            $meeting_status = $row->meeting_status;
            $ovm_meeting_id = $row->meeting_id;
            $child_name = $row->child_name;
            $child_id = $row->child_id;
            $ovm_meeting_unique = $row->meeting_unique;
            $enrollment_id = $row->enrollment_id;
            $stakeholders = $row->stakeholders;
            $inarr = explode(',', $stakeholders);
            $inarr = array_unique($inarr);
            $parentId = $row->parentId;
            $isc1 = $row->isc1;
            $service = new \Google_Service_Calendar($googl->client());
            $event = $service->events->get('primary', $event_id);

            $eventDetails = json_decode(json_encode($event), true);
            $attendees = $eventDetails['attendees'];

            foreach ($attendees as $attendee) {
                // Log::error( $attendee['email'] . " :: " . $attendee['responseStatus'] );
                $email = $attendee['email'];
                $responseStatus = $attendee['responseStatus'];
                if ($responseStatus == 'tentative') {
                    $responseStatus = 'Reschedule Request';
                } elseif ($responseStatus == 'accepted') {
                    $responseStatus = 'Accepted';
                } elseif ($responseStatus == 'declined') {
                    $responseStatus = 'Declined';
                }
                if ($responseStatus != 'needsAction') {
                    $user = DB::select("SELECT * FROM users WHERE email = '$email'");
                    if ($user != []) {
                        $userID = $user[0]->id;
                        $name = $user[0]->name;
                        $check = DB::select("Select * FROM ovm_attendees WHERE ovm_id = $ovm_meeting_id AND ovm_type = '3' AND created_by = $userID");
                        if ($check != []) {
                            $currentStatus = $check[0]->status;
                        } else {
                            $currentStatus = '';
                        }
                        if ($currentStatus != $responseStatus) {
                            DB::select("Delete FROM ovm_attendees WHERE ovm_id = $ovm_meeting_id AND ovm_type = '3' and created_by = $userID");
                            DB::table('ovm_attendees')->insertGetId([
                                'ovm_type' =>  '3',
                                'ovm_id' => $ovm_meeting_id,
                                'notes' => $attendee['comment'],
                                'attendee' => $userID,
                                'status' => $responseStatus,
                                'overall_status' => $meeting_status,
                                'created_by' => $userID,
                                'created_at' => NOW()
                            ]);
                            DB::table('ovm_status_logs')->insert([
                                'audit_table_name' => 'in_person_meeting',
                                'audit_table_id' => $ovm_meeting_id,
                                'audit_action' => 'F2F Meeting ' . $responseStatus,
                                'description' => $responseStatus,
                                'user_id' => $userID,
                                'action_date_time' => now(),
                                'enrollment_id' => $enrollment_id,
                                'role_name' => $name
                            ]);
                            $msgcontent = "F2F Meeting for " . $child_name . " (" . $enrollment_id . " ) has been " . $responseStatus . " by " . $name;
                            if ($parentId == $userID) {
                                DB::table('in_person_meeting')
                                    ->where('meeting_id', $ovm_meeting_id)
                                    ->update([
                                        'meeting_status' => $responseStatus,
                                        'created_date' => NOW()
                                    ]);
                                $msgcontent = "F2f Meeting for " . $child_name . " (" . $enrollment_id . " ) has been " . $responseStatus . " by Parent ";
                            }
                            foreach ($inarr as $val) {
                                // Log::error($val);
                                DB::table('notifications')->insertGetId([
                                    'user_id' => $val,
                                    'notification_type' => 'activity',
                                    'notification_status' => 'F2F Meeting Scheduled',
                                    'notification_url' => 'inperson/edit/meeting/' . encrypt($ovm_meeting_id),
                                    'megcontent' => $msgcontent,
                                    'alert_meg' => $msgcontent,
                                    // 'created_by' => auth()->user()->id,
                                    'created_at' => NOW()
                                ]);
                            }
                        }else{
                            $existingNote = $check[0]->notes;
                            if($existingNote == null || $existingNote == '' || $existingNote != $attendee['comment']){
                                DB::table('ovm_attendees')
                                    ->where('id', $check[0]->id)
                                    ->update([
                                        'notes' => $attendee['comment'],
                                    ]);
                            }
                        }
                    }
                }
            }
        }
    }
}
