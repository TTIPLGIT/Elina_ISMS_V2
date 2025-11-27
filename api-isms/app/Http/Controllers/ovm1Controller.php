<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Jobs\sendmailjob;
use App\Mail\ovmassessment;
use App\Mail\G2FormMail;
use App\Mail\ovmreportmail;
use App\Googl;
use DateTime;
use DateTimeZone;
use Google\Service\Calendar;
use Google\Service\Calendar\Event as Google_Service_Calendar_Event;
use Log;



class ovm1Controller extends BaseController

{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index(Request $request, Googl $googl)
    {

        try {

            $method = 'Method => ovm1Controller => index';
            $authID = auth()->user()->id;
            $saveAlert = DB::select("SELECT * FROM ovm_meeting_details WHERE meeting_status = 'Saved' AND created_date <= NOW() - INTERVAL 1 DAY AND created_by = $authID");
            $log = DB::select("SELECT * FROM ovm_status_logs");
            $this->updateGoogleEvent($googl);
            $log = DB::select("SELECT * FROM ovm_meeting_details AS sd
            INNER JOIN ovm_status_logs AS b ON sd.enrollment_id = b.enrollment_id
            where b.audit_table_name = 'ovm_meeting_details'
            ORDER BY b.id ASC ");

            $role_name = DB::select("SELECT role_name FROM uam_roles AS ur
            INNER JOIN users us ON (us.array_roles=ur.role_id) WHERE us.id=" . auth()->user()->id);
            $role_name_fetch = $role_name[0]->role_name;
            if ($role_name_fetch == 'IS Coordinator') {
                $rows = [];
                $fieldOptions1 = DB::select('SELECT a.ovm_meeting_id,a.ovm_meeting_unique,b.name AS user_id,a.is_coordinator1,a.is_coordinator2,a.enrollment_id,a.child_id,a.child_name,
                a.meeting_to,a.meeting_subject,a.meeting_startdate,a.meeting_enddate,a.meeting_location,
                a.meeting_status,a.meeting_description,a.created_by,a.created_date,a.last_modified_by,a.event_id,
                a.last_modified_date,a.active_flag,a.meeting_starttime,a.meeting_endtime
                from ovm_meeting_details as a inner JOIN users b ON a.user_id = b.id
                WHERE JSON_EXTRACT(is_coordinator1, "$.id") = ' . $authID . ' ORDER BY a.ovm_meeting_id DESC');

                $fieldOptions2 = DB::select('SELECT a.ovm_meeting_id,a.ovm_meeting_unique,b.name AS user_id,a.is_coordinator1,a.is_coordinator2,a.enrollment_id,a.child_id,a.child_name,
                a.meeting_to,a.meeting_subject,a.meeting_startdate,a.meeting_enddate,a.meeting_location,
                a.meeting_status,a.meeting_description,a.created_by,a.created_date,a.last_modified_by,a.event_id,
                a.last_modified_date,a.active_flag,a.meeting_starttime,a.meeting_endtime
                from ovm_meeting_details as a inner JOIN users b ON a.user_id = b.id
                WHERE JSON_EXTRACT(is_coordinator2, "$.id") = ' . $authID . ' ORDER BY a.ovm_meeting_id DESC');

                foreach ($fieldOptions1 as $field_detail1) {
                    array_push($rows, $field_detail1);
                }
                foreach ($fieldOptions2 as $field_detail2) {
                    array_push($rows, $field_detail2);
                }
                usort($rows, function ($first, $second) {
                    return $first->ovm_meeting_id < $second->ovm_meeting_id;
                });
            } else {
                $rows = DB::select("SELECT a.ovm_meeting_id,a.ovm_meeting_unique,b.name AS user_id,a.is_coordinator1,a.is_coordinator2,a.enrollment_id,a.child_id,a.child_name,
                a.meeting_to,a.meeting_subject,a.meeting_startdate,a.meeting_enddate,a.meeting_location,
                a.meeting_status,a.meeting_description,a.created_by,a.created_date,a.last_modified_by,a.event_id,
                a.last_modified_date,a.active_flag,a.meeting_starttime,a.meeting_endtime
                from ovm_meeting_details as a inner JOIN users b ON a.user_id = b.id
                ORDER BY a.ovm_meeting_id DESC ");
            }
            $attendeeStatus = DB::select("select * from ovm_attendees where ovm_type = '1' and attendee =" . auth()->user()->id);
            $attendee = DB::select("SELECT ovm_id FROM ovm_attendees where ovm_type = '1' and attendee =" . auth()->user()->id);

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

    //


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()

    {

        try {
            $method = 'Method => ovm1Controller => create';

            $rows = DB::table('ovm_meeting_details')

                ->get();

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




    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Googl $googl)
    {
        try {
            $method = 'Method => ovm1Controller => store';
            $userID =  auth()->user()->id;
            $email_users = array();
            $inputArray = $this->decryptData($request->requestData);

            $is_coordinator1 = $inputArray['is_coordinator1'];
            $is_coordinator1 = DB::select('Select id,email,name from users where id=' . $is_coordinator1);
            // $this->WriteFileLog($is_coordinator1);
            $authuser = DB::select('Select id,email,name from users where id=' . $userID);

            $is_coordinator1json = json_encode($is_coordinator1[0], JSON_FORCE_OBJECT);
            $is_coordinator2 = $inputArray['is_coordinator2'];
            // $this->WriteFileLog($is_coordinator2);
            $mail_cc = $inputArray['mail_cc'];
            // $this->WriteFileLog($inputArray['meeting_startdate']);
            // $this->WriteFileLog($inputArray['meeting_enddate']);

            $a = array();
            if ($mail_cc != '') {
                $c = count($mail_cc);

                for ($k = 0; $k < $c; $k++) {
                    array_push($a, array('email' => $mail_cc[$k]));
                }
            }
            if ($is_coordinator2 == 'Select-IS-Coordinator-2') {
                $is_coordinator2 = '';
                $is_coordinator2json = '{}';
                $attendees = array(
                    array('email' => $inputArray['meeting_to']),
                );
                $attendees1 = array(
                    array('email' => $is_coordinator1[0]->email),
                );
            } else {
                $is_coordinator2 = DB::select('Select id,email,name from users where id=' . $is_coordinator2);
                $is_coordinator2json = json_encode($is_coordinator2[0], JSON_FORCE_OBJECT);
                $attendees = array(
                    array('email' => $inputArray['meeting_to']),
                );
                $attendees1 = array(
                    array('email' => $is_coordinator1[0]->email),
                    array('email' => $is_coordinator2[0]->email),
                );
                // $this->WriteFileLog($attendees1);
            }

            $enrollment_id = $inputArray['enrollment_child_num'];
            $email_users = [$authuser, $is_coordinator1, $is_coordinator2];
            // $this->WriteFileLog($enrollment_id);
            // // Date - MM/DD/YYYY
            // $startTime = $inputArray['meeting_startdate'] . 'T' . $inputArray['meeting_starttime'] . ':00';
            // $endTime = $inputArray['meeting_enddate'] . 'T' . $inputArray['meeting_endtime'] . ':00';

            // Date - DD/MM/YYYY
            $date_str = $inputArray['meeting_startdate'] . $inputArray['meeting_starttime'];
            $date_obj = DateTime::createFromFormat('d/m/Y H:i:s', $date_str, new DateTimeZone('Asia/Kolkata'));
            // $this->WriteFileLog('start_date', $date_str);
            // $this->WriteFileLog($date_str);
            // $this->WriteFileLog($date_obj);
            if ($date_obj instanceof DateTime) {
                // $this->WriteFileLog("YES");
                $date_obj->setTimezone(new DateTimeZone('UTC'));
                $startTime = $date_obj->format('c');
                // $this->WriteFileLog($startTime,"starttime");
            } else {
                // $this->WriteFileLog("NO");
                $date_str = $inputArray['meeting_startdate'] . $inputArray['meeting_starttime'];
                $date_obj = DateTime::createFromFormat('d/m/Y H:i:s', $date_str, new DateTimeZone('Asia/Kolkata'));
                $date_obj->setTimezone(new DateTimeZone('UTC'));
                $startTime = $date_obj->format('c');
                // $this->WriteFileLog($startTime);
            }
            // $this->WriteFileLog($startTime,"starttime");

            $date_str = $inputArray['meeting_enddate'] . $inputArray['meeting_endtime'];
            $date_obj = DateTime::createFromFormat('d/m/Y H:i:s', $date_str, new DateTimeZone('Asia/Kolkata'));
            // $this->WriteFileLog($date_obj instanceof DateTime);
            if ($date_obj instanceof DateTime) {
                $date_obj->setTimezone(new DateTimeZone('UTC'));
                $endTime = $date_obj->format('c');
            } else {


                $date_str = $inputArray['meeting_enddate'] . $inputArray['meeting_endtime'];
                $date_obj = DateTime::createFromFormat('d/m/Y H:i:s', $date_str, new DateTimeZone('Asia/Kolkata'));
                $date_obj->setTimezone(new DateTimeZone('UTC'));
                $endTime = $date_obj->format('c');
            }
            // $this->WriteFileLog($endTime);


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
                'g2form_url' => $inputArray['g2form_url'],
            ];
            // $this->WriteFileLog($input);
            $type = $input['type'];
            $mail_cc = $input['mail_cc'];
            $eventId = '';
            $eventLink = '';
            if ($type == "Sent") {

                // $this->WriteFileLog("df");

                $client = $googl->client();
                $service = new \Google_Service_Calendar($client);
                // $this->WriteFileLog(json_decode(json_encode($service), true));
                // $this->WriteFileLog($inputArray['meeting_subject']);
                // $this->WriteFileLog($attendees1);
                // $this->WriteFileLog($a);
                // $this->WriteFileLog($attendees);
                // $this->WriteFileLog(array_merge($attendees1, $a, $attendees))
                $event = new \Google_Service_Calendar_Event(array(
                    'summary' => $inputArray['meeting_subject'],
                    'location' => $inputArray['meeting_location'],
                    'description' => $inputArray['meeting_description'],
                    'start' => array('dateTime' => $startTime, 'timeZone' => 'Asia/Kolkata',),
                    'end' => array('dateTime' => $endTime, 'timeZone' => 'Asia/Kolkata',),
                    'attendees' =>  array_merge($attendees1, $a, $attendees),
                    'reminders' => array('useDefault' => FALSE, 'overrides' => array(array('method' => 'email', 'minutes' => 24 * 60), array('method' => 'popup', 'minutes' => 10),),),
                    "conferenceData" => array("createRequest" => array("conferenceSolutionKey" => array("type" => "hangoutsMeet"), "requestId" => "123"))
                ));
                // $this->WriteFileLog(json_encode($event));
                $opts = array('sendNotifications' => true, 'conferenceDataVersion' => 1);
                $event = $service->events->insert('primary', $event, $opts);
                $eventDetails = json_decode(json_encode($event), true);
                // $this->WriteFileLog($eventDetails);
                $eventLink = $eventDetails['hangoutLink'];
                $eventId = $event->getId();
                // 
                // $summaryAdmin = "You Have beed invited to attend the OVM-1 Meeting for " . $inputArray['child_name'];
                // $event1 = new \Google_Service_Calendar_Event(array(
                //     'summary' => $inputArray['meeting_subject'],
                //     'location' => $inputArray['meeting_location'],
                //     'description' => $summaryAdmin,
                //     'start' => array('dateTime' => $startTime, 'timeZone' => 'Asia/Kolkata',),
                //     'end' => array('dateTime' => $endTime, 'timeZone' => 'Asia/Kolkata',),
                //     'attendees' => array_merge($attendees1, $a),
                //     'reminders' => array('useDefault' => FALSE, 'overrides' => array(array('method' => 'email', 'minutes' => 24 * 60), array('method' => 'popup', 'minutes' => 10),),),
                //     "conferenceData" => array("createRequest" => array("conferenceSolutionKey" => array("type" => "hangoutsMeet"), "requestId" => "123"))
                // ));
                // $opts = array('sendNotifications' => true, 'conferenceDataVersion' => 1);
                // $updatedEvent = $service->events->patch('primary', $eventId, $event1, $opts);
                // 
                // $this->WriteFileLog($inputArray['meeting_startdate']);
                // $this->WriteFileLog($inputArray['meeting_enddate']);
                // $this->WriteFileLog($input['meeting_starttime']);
                // $this->WriteFileLog($input['meeting_endtime']);
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
                            'startTime' => $input['meeting_starttime'],
                            'endTime' => $input['meeting_endtime'],
                            'email' => $admin_details[$j]->email,
                            'name' => $admin_details[$j]->name,
                        ];
                        // $this->WriteFileLog($data);
                        // Mail::to('robert.b@talentakeaways.com')->send(new sendovmmail());
                        //  sendmailjob::dispatch($data)->onQueue($data['email']);
                        dispatch(new sendmailjob($data))->delay(now()->addSeconds(1));
                    }
                }
                $this->g2form_initiate($input);
            }


            $user_id = $input['user_id'];
            // $this->WriteFileLog($user_id);

            $user_check = DB::select("select * from ovm_meeting_details where enrollment_id = '$enrollment_id' and active_flag = 0");

            if ($user_check == []) {

                DB::transaction(function () use ($input, $is_coordinator1, $is_coordinator2, $eventId, $eventLink) {
                    $claimdetails = DB::table('ovm_meeting_details')->orderBy('ovm_meeting_unique', 'desc')->first();

                    if ($claimdetails == null) {
                        $claimnoticenoNew =  'OVM-1/' . date("Y") . '/' . date("m") . '/001';
                        // $this->WriteFileLog($claimnoticenoNew);
                        // echo ($claimnoticenoNew);exit;
                    } else {
                        $claimnoticeno = $claimdetails->ovm_meeting_unique;
                        $claimnoticenoNew =  ++$claimnoticeno;  // AAA004  
                        // $this->WriteFileLog($claimnoticenoNew);
                    }

                    $ovm_meeting = DB::table('ovm_meeting_details')
                        ->insertGetId([
                            'ovm_meeting_unique' => $claimnoticenoNew,
                            'enrollment_id' => $input['enrollment_child_num'],
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
                            'mail_cc' => ($input['mail_cc'] != '') ? implode(",", $input['mail_cc']) : null,
                        ]);
                    // $this->WriteFileLog("df");
                    $id = $this->elina_assessment_process($input['enrollment_id'], 'OVM meeting store', 'OVM', 'create new ovm meeting details', auth()->user()->id, NOW());

                    $id = $this->elina_assessment($id, $input['enrollment_id'], 'OVM meeting store', 'OVM', 'create new ovm meeting details', auth()->user()->id, NOW());

                    $this->auditLog('ovm_meeting_details', $ovm_meeting, 'OVM', 'create new ovm meeting details', auth()->user()->id, NOW(), ' $role_name_fetch');
                    if ($input['meeting_status'] == 'Sent') {
                        $ovm_status_logs = 'Scheduled';
                    } else {
                        $ovm_status_logs = $input['meeting_status'];
                    }

                    $this->ovm_status_logs('ovm_meeting_details', $ovm_meeting, 'OVM Meeting ' . $ovm_status_logs, 'OVM Status', auth()->user()->id, NOW(), $input['enrollment_child_num'], auth()->user()->name);

                    $type = $input['type'];
                    if ($type == "Sent") {
                        $admin_details = DB::SELECT("SELECT * from users where array_roles = '4'");
                        $adminn_count = count($admin_details);
                        if ($admin_details != []) {
                            for ($j = 0; $j < $adminn_count; $j++) {

                                DB::table('notifications')->insertGetId([
                                    'user_id' =>  $admin_details[$j]->id,
                                    'notification_type' => 'OVM Meeting Scheduled',
                                    'notification_status' => 'OVM Meeting',
                                    'notification_url' => 'ovmsent/' . encrypt($ovm_meeting),
                                    'megcontent' => "OVM-1 Meeting has been Scheduled Successfully for child-" . $input['child_name'] . " (" . $input['enrollment_child_num'] . " )",
                                    'alert_meg' => "OVM-1 Meeting has been Scheduled Successfully for child-" . $input['child_name'] . " (" . $input['enrollment_child_num'] . " )",
                                    'created_by' => auth()->user()->id,
                                    'created_at' => NOW()
                                ]);
                            }
                        }

                        $en = $input['enrollment_id'];
                        $ee = DB::select("SELECT * FROM enrollment_details WHERE enrollment_id = '$en'");
                        DB::table('notifications')->insertGetId([
                            'user_id' => $ee[0]->user_id,
                            'notification_type' => 'OVM Meeting Scheduled',
                            'notification_status' => 'OVM Meeting',
                            'notification_url' => 'ovm1/' . encrypt($ovm_meeting),
                            'megcontent' => "OVM-1 Meeting has been Scheduled Successfully for child-" . $input['child_name'] . "(" . $input['enrollment_child_num'] . ")",
                            'alert_meg' => "OVM-1 Meeting has been Scheduled Successfully for child-" . $input['child_name'] . "(" . $input['enrollment_child_num'] . ")",
                            'created_by' => auth()->user()->id,
                            'created_at' => NOW()
                        ]);

                        DB::table('notifications')->insertGetId([
                            'user_id' =>  $is_coordinator1[0]->id,
                            'notification_type' => 'OVM Meeting Scheduled',
                            'notification_status' => 'OVM Meeting',
                            'notification_url' => 'ovmsent/' . encrypt($ovm_meeting),
                            'megcontent' => "OVM-1 Invite Sent for you to attend for child-" . $input['child_name'] . " (" . $input['enrollment_child_num'] . " )",
                            'alert_meg' => "OVM-1 Invite Sent for you to attend for child-" . $input['child_name'] . " (" . $input['enrollment_child_num'] . " )",
                            'created_by' => auth()->user()->id,
                            'created_at' => NOW()
                        ]);

                        if ($is_coordinator2 != '') {
                            DB::table('notifications')->insertGetId([
                                'user_id' =>  $is_coordinator2[0]->id,
                                'notification_type' => 'OVM Meeting Scheduled',
                                'notification_status' => 'OVM Meeting',
                                'notification_url' => 'ovmsent/' . encrypt($ovm_meeting),
                                'megcontent' => "OVM-1 Invite Sent for you to attend for child-" . $input['child_name'] . " (" . $input['enrollment_child_num'] . " )",
                                'alert_meg' => "OVM-1 Invite Sent for you to attend for child-" . $input['child_name'] . " (" . $input['enrollment_child_num'] . " )",
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


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function data_edit($id)
    {
        try {

            $method = 'Method => ovm1Controller => data_edit';
            // $this->WriteFileLog($method);

            $id = $this->DecryptData($id);


            $rows = DB::table('ovm_meeting_details as a')
                ->select('a.*')
                ->where('a.ovm_meeting_id', $id)
                ->get();
            $attendee = DB::select("SELECT a.*,b.name from ovm_attendees AS a
                INNER JOIN users AS b ON a.attendee=b.id where ovm_id = $id and ovm_type=1");
            // $this->WriteFileLog($rows);
            $iscoordinators = DB::select("SELECT * from users
            right JOIN uam_user_roles ON uam_user_roles.user_id=users.id
            right JOIN uam_roles on uam_roles.role_id = uam_user_roles.role_id
            WHERE uam_roles.role_name='IS Coordinator' AND users.active_flag=0");
            $users = DB::select("SELECT * FROM users WHERE array_roles != 3");
            $en_num = $rows[0]->enrollment_id;
            $enrollment_user = DB::select("SELECT user_id from enrollment_details where enrollment_child_num = '$en_num'");

            $response = [
                'rows' => $rows,
                'iscoordinators' => $iscoordinators,
                'attendee' => $attendee,
                'users' => $users,
                'enrollment_user' => $enrollment_user[0]->user_id
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
    public function completed_data_edit(Request $request, $id)
    {
        try {

            $method = 'Method => ovm1Controller => completed_data_edit';
            $user_id = $request['user_id'];
            $id = $this->DecryptData($id);
            $authID = auth()->user()->id;

            $rows = DB::select("SELECT b.video_link as video_link1 , a.* FROM ovm_meeting_isc_feedback AS a INNER JOIN ovm_meeting_details AS b ON a.ovm_meeting_id = b.ovm_meeting_id
            where a.ovm_meeting_id = $id and a.is_coordinator_id = $user_id");

            $enrollment_id = $rows[0]->enrollment_id;
            $ovm_isc_report_id = $rows[0]->ovm_isc_report_id;

            $fetchdata = DB::select("SELECT * FROM ovm_conversation_feedback WHERE ovm_isc_report_id = $ovm_isc_report_id");
            $fetchdata1 = DB::select("SELECT * FROM ovm_conversation_note WHERE ovm_isc_report_id = $ovm_isc_report_id");

            $enrollment_details = DB::select("SELECT child_school_name_address , enrollment_id , child_name , child_mother_caretaker_name , child_father_guardian_name , child_dob , child_contact_address FROM enrollment_details WHERE enrollment_child_num = '$enrollment_id'");
            $roleGet = DB::select("SELECT b.role_name FROM users AS a INNER JOIN uam_roles AS b ON b.role_id=a.array_roles where a.id = $authID");

            $group = DB::select("SELECT * FROM conversation_summery_groups WHERE active_flag = 1");
            $questions = DB::select("SELECT * FROM conversation_questions WHERE type_id = 2 ORDER BY order_id ASC ");
            $enID = $enrollment_details[0]->enrollment_id;
            $fetchdata2 = DB::select("SELECT * FROM ovm_g2form_feedback WHERE enrollment_id = $enID");
            $response = [
                'rows' => $rows,
                'role' => $roleGet[0]->role_name,
                // 'primary_caretaker' => $enrollment_details[0]->child_mother_caretaker_name,
                'enrollment_details' => $enrollment_details,
                'group' => $group,
                'questions' => $questions,
                'fetchdata' => $fetchdata,
                'fetchdata1' => $fetchdata1,
                'fetchdata2' => $fetchdata2
            ];

            // // Old Function
            // // $this->WriteFileLog($request['user_id']);
            // $user_id = $request['user_id'];
            // $id = $this->DecryptData($id);
            // $authID = auth()->user()->id;

            // // $rows = DB::table('ovm_meeting_isc_feedback as a')
            // //     ->select('a.*')
            // //     ->where([['a.ovm_meeting_id', $id], ['a.is_coordinator_id', $user_id]])
            // //     ->get();
            // $rows = DB::select("SELECT b.video_link as video_link1 , a.* FROM ovm_meeting_isc_feedback AS a 
            // INNER JOIN ovm_meeting_details AS b ON a.ovm_meeting_id = b.ovm_meeting_id
            // where a.ovm_meeting_id = $id and a.is_coordinator_id = $user_id");
            // // $this->WriteFileLog($id);
            // $enrollment_id = $rows[0]->enrollment_id;
            // $enrollment_details = DB::select("SELECT * FROM enrollment_details WHERE enrollment_child_num = '$enrollment_id'");
            // $roleGet = DB::select("SELECT b.role_name FROM users AS a 
            // INNER JOIN uam_roles AS b ON b.role_id=a.array_roles where a.id = $authID");
            // // $this->WriteFileLog($roleGet);


            // $response = [
            //     'rows' => $rows,
            //     'role' => $roleGet[0]->role_name,
            //     'primary_caretaker' => $enrollment_details[0]->child_mother_caretaker_name,
            // ];

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
    public function completedisedit_data_edit(Request $request, $id)
    {
        try {

            $method = 'Method => ovm1Controller => completed_data_edit';

            $id = $this->DecryptData($id);
            $authID = auth()->user()->id;

            $rows = DB::table('ovm_meeting_isc_feedback')->select('*')->where([['ovm_isc_report_id', $id], ['ishead_save', '1']])->get();

            if ($rows->isEmpty()) {
                $rows = DB::table('ovm_meeting_isc_feedback')->select('*')->where([['ovm_isc_report_id', $id]])->get();
            }

            $saveflag = $rows[0]->ishead_save;

            $roleGet = DB::select("SELECT b.role_name FROM users AS a INNER JOIN uam_roles AS b ON b.role_id=a.array_roles where a.id = $authID");

            if ($saveflag == 1) {
                $fetchdata = DB::select("SELECT * FROM ovm_conversation_feedback WHERE ovm_isc_report_id = $id AND ishead_save = 1");
                $fetchdata1 = DB::select("SELECT * FROM ovm_conversation_note WHERE ovm_isc_report_id = $id AND ishead_save = 1");
            } else {
                $fetchdata = DB::select("SELECT * FROM ovm_conversation_feedback WHERE ovm_isc_report_id = $id");
                $fetchdata1 = DB::select("SELECT * FROM ovm_conversation_note WHERE ovm_isc_report_id = $id");
            }

            $questions = DB::select("SELECT * FROM conversation_questions WHERE type_id = 2");
            $group = DB::select("SELECT * FROM conversation_summery_groups WHERE active_flag = 1");

            $response = [
                'rows' => $rows,
                'role' => $roleGet[0]->role_name,
                'questions' => $questions,
                'fetchdata1' => $fetchdata1,
                'fetchdata' => $fetchdata,
                'group' => $group,
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
    public function completed_isedit_data_edit(Request $request, $id, $meet)
    {

        try {

            $method = 'Method => ovm1Controller => completed_isedit_data_edit';

            $id = $this->DecryptData($id);
            $meet = $this->DecryptData($meet);
            // $this->WriteFileLog($id);
            // $this->WriteFileLog($meet);

            $authID = auth()->user()->id;

            $rows = DB::table('ovm_conversation_feedback')->select('*')->where([['ovm_isc_report_id', $id], ['ishead_save', '1']])->get();

            if ($rows->isEmpty()) {
                $rows = DB::table('ovm_meeting_isc_feedback')->select('*')->where([['ovm_isc_report_id', $id]])->get();
                $rows1 = DB::table('ovm_meeting_isc_feedback')->select('*')->where([['ovm_isc_report_id', $meet]])->get();
            }

            $saveflag = $rows[0]->ishead_save;

            $roleGet = DB::select("SELECT b.role_name FROM users AS a INNER JOIN uam_roles AS b ON b.role_id=a.array_roles where a.id = $authID");

            if ($saveflag == 1) {

                // $this->WriteFileLog($id);
                $fetchdata = DB::select("SELECT * FROM ovm_conversation_feedback WHERE ovm_isc_report_id = $id AND ishead_save = 1");
                // $this->WriteFileLog(json_encode($fetchdata));
                $fetchdata1 = DB::select("SELECT * FROM ovm_conversation_feedback WHERE ovm_isc_report_id = $meet AND ishead_save = 1");
                // $this->WriteFileLog(json_encode($fetchdata1));
            } else {


                $fetchdata = DB::select("SELECT * FROM ovm_conversation_feedback WHERE ovm_isc_report_id = $id");

                $fetchdata1 = DB::select("SELECT * FROM ovm_conversation_feedback WHERE ovm_isc_report_id = $meet");
            }

            $questions = DB::select("SELECT * FROM conversation_questions WHERE type_id = 2 and group_id !='1' ORDER BY order_id ASC");
            // $this->WriteFileLog($questions);
            $group = DB::select("SELECT * FROM conversation_summery_groups WHERE active_flag = 1");
            // $this->WriteFileLog($group);
            // $this->WriteFileLog($fetchdata);
            // $this->WriteFileLog($fetchdata1);
            $response = [
                'rows' => $rows,
                'role' => $roleGet[0]->role_name,
                'questions' => $questions,
                'fetchdata1' => $fetchdata1,
                'fetchdata' => $fetchdata,
                'group' => $group,
                'rows1' => $rows1,

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
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updatedata(Request $request, Googl $googl)
    {
        // $this->WriteFileLog("asdas");
        try {
            $userID =  auth()->user()->id;
            $method = 'Method =>  ovm1Controller => updatedata';
            $inputArray = $this->decryptData($request->requestData);
            $status = $inputArray['meeting_status'];
            $is_coordinator1 = $inputArray['is_coordinator1'];
            $is_coordinator1 = DB::select('Select id,email,name from users where id=' . $is_coordinator1);

            $authuser = DB::select('Select id,email,name from users where id=' . $userID);

            $is_coordinator1json = json_encode($is_coordinator1[0], JSON_FORCE_OBJECT);
            $is_coordinator2 = $inputArray['is_coordinator2'];
            $mail_cc = $inputArray['mail_cc'];
            $a = array();
            if ($mail_cc != '') {
                $c = count($mail_cc);

                for ($k = 0; $k < $c; $k++) {
                    array_push($a, array('email' => $mail_cc[$k]));
                }
            }
            if ($is_coordinator2 == 'Select-IS-Coordinator-2' || $is_coordinator2 == '') {
                $is_coordinator2 = '';
                $is_coordinator2json = '{}';
                $attendees = array(
                    array('email' => $inputArray['meeting_to']),
                );
                $attendees1 = array(
                    array('email' => $is_coordinator1[0]->email),
                );
            } else {
                $is_coordinator2 = DB::select('Select id,email,name from users where id=' . $is_coordinator2);
                $is_coordinator2json = json_encode($is_coordinator2[0], JSON_FORCE_OBJECT);
                $attendees = array(
                    array('email' => $inputArray['meeting_to']),
                );
                $attendees1 = array(
                    array('email' => $is_coordinator1[0]->email),
                    array('email' => $is_coordinator2[0]->email),
                );
            }

            $enrollment_id = $inputArray['enrollment_child_num'];
            $email_users = [$authuser, $is_coordinator1, $is_coordinator2];
            // // Date - MM/DD/YYYY
            // $startTime = $inputArray['meeting_startdate'] . 'T' . $inputArray['meeting_starttime'] . ':00';
            // $endTime = $inputArray['meeting_enddate'] . 'T' . $inputArray['meeting_endtime'] . ':00';

            // Date - DD/MM/YYYY
            $date_str = $inputArray['meeting_startdate'] . $inputArray['meeting_starttime'] . ':00';

            $date_obj = DateTime::createFromFormat('d/m/Y H:i:s', $date_str, new DateTimeZone('Asia/Kolkata'));

            if ($date_obj instanceof DateTime) {
                $date_obj->setTimezone(new DateTimeZone('UTC'));
                $startTime = $date_obj->format('c');
            } else {
                $date_str = $inputArray['meeting_startdate'] . $inputArray['meeting_starttime'];
                $date_obj = DateTime::createFromFormat('d/m/Y H:i:s', $date_str, new DateTimeZone('Asia/Kolkata'));
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
            $en_num = $inputArray['enrollment_id'];

            $en_id = DB::select("SELECT * FROM enrollment_details WHERE enrollment_child_num = '$en_num'");



            $input = [
                'id' => $inputArray['id'],
                'enrollment_child_num' => $inputArray['enrollment_child_num'],
                'enrollment_id' => $en_id[0]->enrollment_id,
                'ovm_meeting_unique' => $inputArray['ovm_meeting_unique'],
                'child_id' => $inputArray['child_id'],
                'child_name' => $inputArray['child_name'],
                'meeting_to' => $inputArray['meeting_to'],
                'is_coordinator1' => $is_coordinator1json,
                'is_coordinator2' => $is_coordinator2json,
                'is_coordinator1u' => $inputArray['is_coordinator1'],
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
                'g2form_url' => $inputArray['g2form_url'],
            ];
            $type = $input['type'];
            $meeting_status = $input['meeting_status'];
            if ($type == "Sent") {

                DB::table('ovm_meeting_details')
                    ->where('ovm_meeting_id', $input['id'])
                    ->update([
                        'created_by' => auth()->user()->id,
                        'remainder_flag' => 0,

                    ]);
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
                            'startTime' => $input['meeting_starttime'],
                            'endTime' => $input['meeting_endtime'],
                            'email' => $admin_details[$j]->email,
                            'name' => $admin_details[$j]->name,
                        ];
                        // $this->WriteFileLog($data);
                        // Mail::to('robert.b@talentakeaways.com')->send(new sendovmmail());
                        // sendmailjob::dispatch($data)->onQueue('emails');
                        // dispatch(new sendmailjob($data))->delay(now()->addSeconds(1));
                    }
                }

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
                    // $this->WriteFileLog('enter');
                    $rrrr = $input['id'];
                    $admin_details = DB::SELECT("SELECT * FROM ovm_meeting_details WHERE ovm_meeting_id=$rrrr ");
                    $event->setSummary('Meeting Rescheduled');
                    $opts = array('sendNotifications' => true, 'conferenceDataVersion' => 1);
                    $updatedEvent = $service->events->update('primary', $admin_details[0]->event_id, $event, $opts);
                } else {
                    $opts = array('sendNotifications' => true, 'conferenceDataVersion' => 1);
                    $event = $service->events->insert('primary', $event, $opts);
                    $eventDetails = json_decode(json_encode($event), true);
                    $eventLink = $eventDetails['hangoutLink'];
                    $eventId = $event->getId();
                    // 
                    // $summaryAdmin = "You Have beed invited to attend the OVM-1 Meeting for " . $inputArray['child_name'];
                    // $event1 = new \Google_Service_Calendar_Event(array(
                    //     'summary' => $inputArray['meeting_subject'],
                    //     'location' => $inputArray['meeting_location'],
                    //     'description' => $summaryAdmin,
                    //     'start' => array('dateTime' => $startTime, 'timeZone' => 'Asia/Kolkata',),
                    //     'end' => array('dateTime' => $endTime, 'timeZone' => 'Asia/Kolkata',),
                    //     'attendees' => array_merge($attendees1, $a),
                    //     'reminders' => array('useDefault' => FALSE, 'overrides' => array(array('method' => 'email', 'minutes' => 24 * 60), array('method' => 'popup', 'minutes' => 10),),),
                    //     "conferenceData" => array("createRequest" => array("conferenceSolutionKey" => array("type" => "hangoutsMeet"), "requestId" => "123"))
                    // ));
                    // $opts = array('sendNotifications' => true, 'conferenceDataVersion' => 1);
                    // $AddEvent = $service->events->patch('primary', $eventId, $event1, $opts);
                    // 
                    DB::table('ovm_meeting_details')
                        ->where('ovm_meeting_id', $input['id'])
                        ->update([
                            'event_id' => $eventId,
                            'event_link' => $eventLink,
                        ]);
                    $this->g2form_initiate($input);
                }


                $input['enrollment_id'] = $input['enrollment_child_num'];
                if ($meeting_status == 'Rescheduled') {

                    $admin_details = DB::SELECT("SELECT * from users where array_roles = '4'");
                    $adminn_count = count($admin_details);
                    if ($admin_details != []) {
                        for ($j = 0; $j < $adminn_count; $j++) {

                            DB::table('notifications')->insertGetId([
                                'user_id' =>  $admin_details[$j]->id,
                                'notification_type' => 'OVM Meeting Scheduled',
                                'notification_status' => 'OVM Meeting',
                                'notification_url' => 'ovm1/' . encrypt($input['id']),
                                'megcontent' => "OVM-1 Meeting for child-" . $input['child_name'] . "(" . $input['enrollment_child_num'] . ") has been Rescheduled",
                                'alert_meg' => "OVM-1 Meeting for child-" . $input['child_name'] . "(" . $input['enrollment_child_num'] . ") has been Rescheduled",
                                'created_by' => auth()->user()->id,
                                'created_at' => NOW()
                            ]);
                        }
                    }

                    $en = $input['enrollment_id'];
                    $ee = DB::select("SELECT * FROM enrollment_details WHERE enrollment_child_num = '$en'");

                    DB::table('notifications')->insertGetId([
                        'user_id' => $ee[0]->user_id,
                        'notification_type' => 'OVM Meeting Scheduled',
                        'notification_status' => 'OVM Meeting',
                        'notification_url' => 'ovm1/' . encrypt($input['id']),
                        'megcontent' => "OVM-1 Meeting for child-" . $input['child_name'] . "(" . $input['enrollment_child_num'] . ") has been Rescheduled",
                        'alert_meg' => "OVM-1 Meeting for child-" . $input['child_name'] . "(" . $input['enrollment_child_num'] . ") has been Rescheduled",
                        'created_by' => auth()->user()->id,
                        'created_at' => NOW()
                    ]);

                    DB::table('notifications')->insertGetId([
                        'user_id' =>  $input['is_coordinator1u'],
                        'notification_type' => 'OVM Meeting Scheduled',
                        'notification_status' => 'OVM Meeting',
                        'notification_url' => 'ovmsent/' . encrypt($input['id']),
                        'megcontent' => "OVM-1 Meeting for child-" . $input['child_name'] . "(" . $input['enrollment_child_num'] . ") has been Rescheduled",
                        'alert_meg' => "OVM-1 Meeting for child-" . $input['child_name'] . "(" . $input['enrollment_child_num'] . ") has been Rescheduled",
                        'created_by' => auth()->user()->id,
                        'created_at' => NOW()
                    ]);

                    DB::table('notifications')->insertGetId([
                        'user_id' =>  $input['is_coordinator2u'],
                        'notification_type' => 'OVM Meeting Scheduled',
                        'notification_status' => 'OVM Meeting',
                        'notification_url' => 'ovmsent/' . encrypt($input['id']),
                        'megcontent' => "OVM-1 Meeting for child-" . $input['child_name'] . "(" . $input['enrollment_child_num'] . ") has been Rescheduled",
                        'alert_meg' => "OVM-1 Meeting for child-" . $input['child_name'] . "(" . $input['enrollment_child_num'] . ") has been Rescheduled",
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
                                'notification_type' => 'OVM Meeting Scheduled',
                                'notification_status' => 'OVM Meeting',
                                'notification_url' => 'ovmsent/' . encrypt($input['id']),
                                'megcontent' => "OVM-1 Meeting has been Scheduled Successfully for child-" . $input['child_name'] . "(" . $input['enrollment_child_num'] . ")",
                                'alert_meg' => "OVM-1 Meeting has been Scheduled Successfully for child-" . $input['child_name'] . "(" . $input['enrollment_child_num'] . ")",
                                'created_by' => auth()->user()->id,
                                'created_at' => NOW()
                            ]);
                        }
                    }
                    $en = $input['enrollment_id'];
                    $ee = DB::select("SELECT * FROM enrollment_details WHERE enrollment_child_num = '$en'");

                    DB::table('notifications')->insertGetId([
                        'user_id' => $ee[0]->user_id,
                        'notification_type' => 'OVM Meeting Scheduled',
                        'notification_status' => 'OVM Meeting',
                        'notification_url' => 'ovm1/' . encrypt($input['id']),
                        'megcontent' => "OVM-1 Meeting has been Scheduled Successfully for child-" . $input['child_name'] . "(" . $input['enrollment_child_num'] . ")",
                        'alert_meg' => "OVM-1 Meeting has been Scheduled Successfully for child-" . $input['child_name'] . "(" . $input['enrollment_child_num'] . ")",
                        'created_by' => auth()->user()->id,
                        'created_at' => NOW()
                    ]);

                    DB::table('notifications')->insertGetId([
                        'user_id' =>  $input['is_coordinator1u'],
                        'notification_type' => 'OVM Meeting Scheduled',
                        'notification_status' => 'OVM Meeting',
                        'notification_url' => 'ovmsent/' . encrypt($input['id']),
                        'megcontent' => "OVM-1 Meeting Sent for you to attend child-" . $input['child_name'] . "(" . $input['enrollment_child_num'] . ")",
                        'alert_meg' => "OVM-1 Meeting Sent for you to attend child-" . $input['child_name'] . "(" . $input['enrollment_child_num'] . ")",
                        'created_by' => auth()->user()->id,
                        'created_at' => NOW()
                    ]);

                    DB::table('notifications')->insertGetId([
                        'user_id' =>  $input['is_coordinator2u'],
                        'notification_type' => 'OVM Meeting Scheduled',
                        'notification_status' => 'OVM Meeting',
                        'notification_url' => 'ovmsent/' . encrypt($input['id']),
                        'megcontent' => "OVM-1 Meeting Sent for you to attend child-" . $input['child_name'] . "(" . $input['enrollment_child_num'] . ")",
                        'alert_meg' => "OVM-1 Meeting Sent for you to attend child-" . $input['child_name'] . "(" . $input['enrollment_child_num'] . ")",
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
                            'notification_type' => 'OVM Meeting Scheduled',
                            'notification_status' => 'OVM Meeting',
                            'notification_url' => 'ovm1/' . encrypt($input['id']),
                            'megcontent' => "OVM-1 Meeting for child-" . $input['child_name'] . "(" . $input['enrollment_child_num'] . ") has Requested for Rescheduled by " . auth()->user()->name,
                            'alert_meg' => "OVM-1 Meeting for child-" . $input['child_name'] . "(" . $input['enrollment_child_num'] . ") has Requested for Rescheduled by " . auth()->user()->name,
                            'created_by' => auth()->user()->id,
                            'created_at' => NOW()
                        ]);
                    }
                }
                $ReReqId = auth()->user()->id;
                $is_one = $input['is_coordinator1u'];
                $is_two = $input['is_coordinator2u'];
                if ($ReReqId != $is_one) {
                    DB::table('notifications')->insertGetId([
                        'user_id' =>  $input['is_coordinator1u'],
                        'notification_type' => 'OVM Meeting Scheduled',
                        'notification_status' => 'OVM Meeting',
                        'notification_url' => 'ovmsent/' . encrypt($input['id']),
                        'megcontent' => "OVM-1 Meeting for child-" . $input['child_name'] . "(" . $input['enrollment_child_num'] . ") has Requested for Rescheduled by " . auth()->user()->name,
                        'alert_meg' => "OVM-1 Meeting for child-" . $input['child_name'] . "(" . $input['enrollment_child_num'] . ") has Requested for Rescheduled by " . auth()->user()->name,
                        'created_by' => auth()->user()->id,
                        'created_at' => NOW()
                    ]);
                }
                if ($is_two != "" && $ReReqId != $is_two) {
                    DB::table('notifications')->insertGetId([
                        'user_id' =>  $input['is_coordinator2u'],
                        'notification_type' => 'OVM Meeting Scheduled',
                        'notification_status' => 'OVM Meeting',
                        'notification_url' => 'ovmsent/' . encrypt($input['id']),
                        'megcontent' => "OVM-1 Meeting for child-" . $input['child_name'] . "(" . $input['enrollment_child_num'] . ") has Requested for Rescheduled by " . auth()->user()->name,
                        'alert_meg' => "OVM-1 Meeting for child-" . $input['child_name'] . "(" . $input['enrollment_child_num'] . ") has Requested for Rescheduled by " . auth()->user()->name,
                        'created_by' => auth()->user()->id,
                        'created_at' => NOW()
                    ]);
                }
            }

            DB::transaction(function () use ($input, $status) {

                $c = DB::select("select * from ovm_meeting_details where ovm_meeting_id=" . $input['id']);
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
                        $this->ovm_status_logs('ovm_meeting_details', $input['id'], 'OVM Meeting has ' . $input['meeting_status'], 'OVM Status', auth()->user()->id, NOW(), $input['enrollment_child_num'], auth()->user()->name);
                    } else {
                        $meSt = $c[0]->meeting_status;
                        DB::select("Delete FROM ovm_attendees WHERE ovm_id = $mid AND created_by = $au");
                        DB::table('ovm_attendees')->insertGetId([
                            'ovm_type' =>  '1',
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
                        $this->ovm_status_logs('ovm_meeting_details', $input['id'], 'OVM Meeting ' . $osl, 'OVM Status', auth()->user()->id, NOW(), $input['enrollment_child_num'], auth()->user()->name);
                    }
                } else {

                    $meSt = $c[0]->meeting_status;
                    $this->ovm_status_logs('ovm_meeting_details', $input['id'], 'OVM Meeting ' . $input['meeting_status'], 'OVM Status', auth()->user()->id, NOW(), $input['enrollment_child_num'], auth()->user()->name);
                }
                $input['enrollment_id'] = $input['enrollment_child_num'];
                $feeden = $input['enrollment_id'];
                $feed = DB::select("SELECT COUNT(*) AS count FROM ovm_meeting_isc_feedback WHERE enrollment_id = '$feeden'");
                $feedc = $feed[0]->count;
                if ($feedc == 0) {
                    DB::transaction(function () use ($input) {
                        $isc1 =   DB::table('ovm_meeting_isc_feedback')
                            ->insertGetId([
                                'enrollment_id' => $input['enrollment_id'],
                                'ovm_meeting_id' => $input['id'],
                                'ovm_meeting_unique' => $input['ovm_meeting_unique'],
                                'child_id' => $input['child_id'],
                                'is_coordinator_id' => $input['is_coordinator1u'],
                                'child_name' => $input['child_name'],
                                'status' => 'New',
                                'user_id' => $input['user_id'],
                                'video_link' => $input['video_link']

                            ]);


                        $isc2 =  DB::table('ovm_meeting_isc_feedback')
                            ->insertGetId([
                                'enrollment_id' => $input['enrollment_id'],
                                'ovm_meeting_id' => $input['id'],
                                'ovm_meeting_unique' => $input['ovm_meeting_unique'],
                                'child_id' => $input['child_id'],
                                'is_coordinator_id' => $input['is_coordinator2u'],
                                'child_name' => $input['child_name'],
                                'status' => 'New',
                                'user_id' => $input['user_id'],
                                'video_link' => $input['video_link']

                            ]);
                    });
                }
                if ($status == 'Completed') {
                    $meSt = $input['meeting_status'];
                }

                DB::table('ovm_meeting_details')
                    ->where('ovm_meeting_id', $input['id'])
                    ->update([

                        'enrollment_id' => $input['enrollment_child_num'],
                        'ovm_meeting_unique' => $input['ovm_meeting_unique'],
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
                        'mail_cc' => ($input['mail_cc'] != '') ? implode(",", $input['mail_cc']) : null,
                        // 'created_by' => auth()->user()->id,
                        'created_date' => NOW()

                    ]);


                $id = $this->elina_assessment_process($input['enrollment_id'], 'OVM meeting Update', 'OVM', 'create new ovm meeting details', auth()->user()->id, NOW());

                $ids = $this->elina_assessment($id, $input['enrollment_id'], 'OVM meeting Update', 'OVM', 'create new ovm meeting details', auth()->user()->id, NOW());

                $this->auditLog('ovm_meeting_details', $input['id'], 'Update', 'OVM Meeting', auth()->user()->id, NOW(), 'Rescheduled');
            });

            if ($status == 'Completed') {
                DB::transaction(function () use ($input) {
                    // $isc1 =   DB::table('ovm_meeting_isc_feedback')
                    //     ->insertGetId([
                    //         'enrollment_id' => $input['enrollment_id'],
                    //         'ovm_meeting_id' => $input['id'],
                    //         'ovm_meeting_unique' => $input['ovm_meeting_unique'],
                    //         'child_id' => $input['child_id'],
                    //         'is_coordinator_id' => $input['is_coordinator1u'],
                    //         'child_name' => $input['child_name'],
                    //         'status' => 'New',
                    //         'user_id' => $input['user_id'],
                    //         'video_link' => $input['video_link']

                    //     ]);
                    $notifications = DB::table('notifications')->insertGetId([
                        'user_id' =>   $input['is_coordinator1u'],
                        'notification_type' => 'OVM Meeting Scheduled',
                        'notification_status' => 'OVM Meeting',
                        'notification_url' => 'ovmcompleted/' . encrypt($input['id']),
                        'megcontent' => "OVM 1 Meeting child-" . $input['child_name'] . " (" . $input['enrollment_id'] . ") " . " has been Completed",
                        'alert_meg' => "OVM 1 Meeting child-" . $input['child_name'] . " (" . $input['enrollment_id'] . ") " . " has been Completed",
                        'created_by' => auth()->user()->id,
                        'created_at' => NOW()
                    ]);
                    if ($input['is_coordinator2u'] != '') {
                        $notifications = DB::table('notifications')->insertGetId([
                            'user_id' =>   $input['is_coordinator2u'],
                            'notification_type' => 'OVM Meeting Scheduled',
                            'notification_status' => 'OVM Meeting',
                            'notification_url' => 'ovmcompleted/' . encrypt($input['id']),
                            'megcontent' => "OVM 1 Meeting child-" . $input['child_name'] . " (" . $input['enrollment_id'] . ") " . " has been Completed",
                            'alert_meg' => "OVM 1 Meeting child-" . $input['child_name'] . " (" . $input['enrollment_id'] . ") " . " has been Completed",
                            'created_by' => auth()->user()->id,
                            'created_at' => NOW()
                        ]);
                    }

                    // $isc2 =  DB::table('ovm_meeting_isc_feedback')
                    //     ->insertGetId([
                    //         'enrollment_id' => $input['enrollment_id'],
                    //         'ovm_meeting_id' => $input['id'],
                    //         'ovm_meeting_unique' => $input['ovm_meeting_unique'],
                    //         'child_id' => $input['child_id'],
                    //         'is_coordinator_id' => $input['is_coordinator2u'],
                    //         'child_name' => $input['child_name'],
                    //         'status' => 'New',
                    //         'user_id' => $input['user_id'],
                    //         'video_link' => $input['video_link']

                    //     ]);
                });

                $admin_details = DB::SELECT("SELECT * from users where array_roles = '4'");
                $adminn_count = count($admin_details);
                if ($admin_details != []) {
                    for ($j = 0; $j < $adminn_count; $j++) {

                        DB::table('notifications')->insertGetId([
                            'user_id' =>  $admin_details[$j]->id,
                            'notification_type' => 'OVM Meeting Scheduled',
                            'notification_status' => 'OVM Meeting',
                            'notification_url' => 'ovm1/' . encrypt($input['id']),
                            'megcontent' => "OVM-1 Meeting for child-" . $input['child_name'] . " (" . $input['enrollment_child_num'] . " ) has been completed",
                            'alert_meg' => "OVM-1 Meeting for child-" . $input['child_name'] . " (" . $input['enrollment_child_num'] . " ) has been completed",
                            'created_by' => auth()->user()->id,
                            'created_at' => NOW()
                        ]);
                    }
                }

                $input['enrollment_id'] = $input['enrollment_child_num'];
                $en = $input['enrollment_id'];
                $ee = DB::select("SELECT * FROM enrollment_details WHERE enrollment_child_num = '$en'");

                DB::table('notifications')->insertGetId([
                    'user_id' => $ee[0]->user_id,
                    'notification_type' => 'OVM Meeting Scheduled',
                    'notification_status' => 'OVM Meeting',
                    'notification_url' => 'ovm1/' . encrypt($input['id']),
                    'megcontent' => "OVM-1 Meeting for child-" . $input['child_name'] . " (" . $input['enrollment_child_num'] . " ) has been completed",
                    'alert_meg' => "OVM-1 Meeting for child-" . $input['child_name'] . " (" . $input['enrollment_child_num'] . " ) has been completed",
                    'created_by' => auth()->user()->id,
                    'created_at' => NOW()
                ]);

                DB::table('ovm_meeting_details')
                    ->where('ovm_meeting_id', $input['id'])
                    ->update([
                        'video_link' => $input['video_link']
                    ]);
                $id = $this->elina_assessment_process($input['enrollment_id'], 'OVM meeting Completed', 'OVM', 'create new ovm meeting details', auth()->user()->id, NOW());

                $id = $this->elina_assessment($id, $input['enrollment_id'], 'OVM meeting Completed', 'OVM', 'create new ovm meeting details', auth()->user()->id, NOW());
            }

            if ($status == 'Accepted' || $status == 'Declined' || $status == 'Completed') {
                DB::transaction(function () use ($input) {
                    DB::table('ovm_meeting_details')
                        ->where('ovm_meeting_id', $input['id'])
                        ->update([
                            'remainder_flag' => 1,
                        ]);
                });
            }
            if ($status == 'Accepted' || $status == 'Declined' || $status == 'Hold') {

                DB::transaction(function () use ($input, $status, $googl) {
                    $c = DB::select("select * from ovm_meeting_details where ovm_meeting_id=" . $input['id']);
                    $cre = $c[0]->created_by;
                    $au = auth()->user()->id;
                    if ($cre == $au) {
                        $megcontent = "OVM-1 Meeting for child-" . $input['child_name'] . " (" . $input['enrollment_id'] . ") " . " has been " . $status . " by " . auth()->user()->name;
                    } else {
                        $megcontent = "OVM-1 Meeting for child-" . $input['child_name'] . " (" . $input['enrollment_id'] . ") " . " has been requested for " . $status . " by " . auth()->user()->name;
                    }
                    if ($status == 'Accepted') {
                        $megcontent = "OVM-1 Meeting for child-" . $input['child_name'] . " (" . $input['enrollment_id'] . ") " . " has been " . $status . " by " . auth()->user()->name;
                    }
                    DB::table('notifications')->insertGetId([
                        'user_id' =>   $input['is_coordinator1u'],
                        'notification_type' => 'OVM Meeting Scheduled',
                        'notification_status' => 'OVM Meeting',
                        'notification_url' => 'ovm1/' . encrypt($input['id']),
                        'megcontent' => $megcontent,
                        'alert_meg' => $megcontent,
                        'created_by' => auth()->user()->id,
                        'created_at' => NOW()
                    ]);

                    if ($input['is_coordinator2u'] != '') {
                        DB::table('notifications')->insertGetId([
                            'user_id' =>   $input['is_coordinator2u'],
                            'notification_type' => 'OVM Meeting Scheduled',
                            'notification_status' => 'OVM Meeting',
                            'notification_url' => 'ovm1/' . encrypt($input['id']),
                            'megcontent' => $megcontent,
                            'alert_meg' => $megcontent,
                            'created_by' => auth()->user()->id,
                            'created_at' => NOW()
                        ]);
                    }

                    if ($cre == $au) {
                        if ($status != 'Accepted') {
                            $en = $input['enrollment_id'];
                            $ee = DB::select("SELECT * FROM enrollment_details WHERE enrollment_child_num = '$en'");
                            DB::table('notifications')->insertGetId([
                                'user_id' => $ee[0]->user_id,
                                'notification_type' => 'OVM Meeting Scheduled',
                                'notification_status' => 'OVM Meeting',
                                'notification_url' => 'ovm1/' . encrypt($input['id']),
                                'megcontent' => "OVM-1 Meeting for child-" . $input['child_name'] . " (" . $input['enrollment_child_num'] . " ) has been " . $status . " by " . auth()->user()->name,
                                'alert_meg' => "OVM-1 Meeting for child-" . $input['child_name'] . " (" . $input['enrollment_child_num'] . " ) has been " . $status . " by " . auth()->user()->name,
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
                                'notification_type' => 'OVM Meeting Scheduled',
                                'notification_status' => 'OVM Meeting',
                                'notification_url' => 'ovm1/' . encrypt($input['id']),
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



    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function data_delete($id)
    {
        // $this->WriteFileLog("hjgjf");
        try {


            $method = 'Method =>ovm1Controller => data_delete';
            // $this->WriteFileLog($method);
            $id = $this->decryptData($id);
            // $this->WriteFileLog($id);



            $check = DB::select("select * from ovm_meeting_details where ovm_meeting_id = '$id' and active_flag = '0' ");
            // $this->WriteFileLog($check);
            if ($check !== []) {


                DB::table('ovm_meeting_details')
                    ->where('ovm_meeting_id', $id)
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

    public function getchilddetails($id)
    {
        try {

            $method = 'Method => ovm1Controller => getchilddetails';
            // $this->WriteFileLog($method);

            $id = $this->DecryptData($id);


            $rows = DB::table('enrollment_details as a')

                ->select('a.*')
                ->where('a.enrollment_id', $id)
                ->get();
            // $this->WriteFileLog($id);


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






    public function meetinginvite(Request $request)
    {
        try {
            $method = 'Method => ovm1Controller => meetinginvite';
            $rows = array();
            $authID = auth()->user()->id;
            $role_name = DB::select("SELECT role_name FROM uam_roles AS ur INNER JOIN users us ON (us.array_roles=ur.role_id) WHERE us.id=$authID");
            $role_name_fetch = $role_name[0]->role_name;

            if ($role_name_fetch == 'IS Coordinator') {
                $rows['enrollment_details'] = DB::select("SELECT d.id,a.enrollment_child_num , a.enrollment_id,a.child_name, c.enrollment_id from enrollment_details as a
                right join payment_status_details AS b on b.enrollment_child_num = a.enrollment_child_num
                left join ovm_meeting_details AS c on c.enrollment_id = a.enrollment_child_num
                INNER JOIN ovm_allocation AS d ON d.enrollment_id = a.enrollment_id
                where b.payment_status = 'SUCCESS' AND d.rsvp1 = 'Accept' AND c.enrollment_id  IS NULL AND a.enrollment_id IN (SELECT oa.enrollment_id FROM ovm_allocation AS oa WHERE oa.rsvp1 = 'Accept') AND (d.is_coordinator1 = $authID OR d.is_coordinator2 =  $authID) ORDER BY a.enrollment_id DESC");
            } else {
                $rows['enrollment_details'] = DB::select("Select a.enrollment_child_num , a.enrollment_id,a.child_name, ovm_meeting_details.enrollment_id from enrollment_details as a
                right join payment_status_details on payment_status_details.enrollment_child_num = a.enrollment_child_num
                left join ovm_meeting_details on ovm_meeting_details.enrollment_id = a.enrollment_child_num
                INNER JOIN ovm_allocation AS d ON d.enrollment_id = a.enrollment_id
                where payment_status_details.payment_status = 'SUCCESS' AND d.rsvp1 = 'Accept'
                AND a.enrollment_id IN (SELECT oa.enrollment_id FROM ovm_allocation AS oa WHERE ((oa.rsvp1 = 'Accept')))
                AND ovm_meeting_details.enrollment_id  IS null ORDER BY a.enrollment_id DESC");
            }

            $rows['iscoordinators'] = DB::select("SELECT * from users
                right JOIN uam_user_roles ON uam_user_roles.user_id=users.id
                right JOIN uam_roles on uam_roles.role_id = uam_user_roles.role_id
                WHERE uam_roles.role_name='IS Coordinator' AND users.active_flag=0");

            $email = DB::select("SELECT * FROM email_preview WHERE screen = 'OVM Initiate' AND active_flag = 0");
            $email_allocation = DB::select("SELECT * FROM email_preview WHERE screen = 'OVM Allocation' AND active_flag = 0");
            $users = DB::select("SELECT * FROM users WHERE (array_roles = 4 OR array_roles = 5) AND active_flag = 0");

            $response = [
                'rows' => $rows,
                'email' => $email,
                'users' => $users,
                'email_allocation' => $email_allocation,
                'default_cc' => config('setting.ovm_default'),
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
    public function meetinginvite2(Request $request)
    {
        try {
            $method = 'Method => ovm1Controller => meetinginvite';

            $rows = array();

            $authID = auth()->user()->id;
            $role_name = DB::select("SELECT role_name FROM uam_roles AS ur INNER JOIN users us ON (us.array_roles=ur.role_id) WHERE us.id=$authID");
            $role_name_fetch = $role_name[0]->role_name;
            if ($role_name_fetch == 'IS Coordinator') {
                $rows['enrollment_details'] = DB::select("SELECT a.* FROM enrollment_details AS a 
                INNER JOIN ovm_meeting_details AS b ON b.enrollment_id = a.enrollment_child_num
                INNER JOIN ovm_allocation AS d ON d.enrollment_id = a.enrollment_id
                WHERE b.meeting_status='Completed' AND b.enrollment_id NOT IN (SELECT enrollment_id FROM ovm_meeting_2_details) 
                AND (d.is_coordinator1 = $authID OR d.is_coordinator2 = $authID) ORDER BY  b.ovm_meeting_id DESC");
            } else {
                $rows['enrollment_details'] = DB::select("SELECT a.* FROM enrollment_details AS a 
                INNER JOIN ovm_meeting_details AS b ON b.enrollment_id=a.enrollment_child_num
                WHERE b.meeting_status='Completed' AND b.enrollment_id NOT IN (SELECT enrollment_id FROM ovm_meeting_2_details) ORDER BY  b.ovm_meeting_id DESC");
            }

            $rows['iscoordinators'] = DB::select("SELECT * from users
                right JOIN uam_user_roles ON uam_user_roles.user_id=users.id
                right JOIN uam_roles on uam_roles.role_id = uam_user_roles.role_id
                WHERE uam_roles.role_name='IS Coordinator' AND users.active_flag=0");

            $email = DB::select("SELECT * FROM email_preview WHERE screen = 'OVM Initiate 2' AND active_flag = 0");
            $users = DB::select("SELECT * FROM users WHERE (array_roles = 4 OR array_roles = 5) AND active_flag = 0");

            $response = [
                'rows' => $rows,
                'email' => $email,
                'users' => $users,
                'default_cc' => config('setting.ovm_default'),
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
    public function ovmmeetingcompleted(Request $request)
    {
        try {
            $method = 'Method => ovm1Controller => index';
            $is_coordinator_id =  $request['is_coordinator_id'];

            $rows = array();

            // $rows = DB::select("SELECT * FROM ovm_meeting_isc_feedback WHERE is_coordinator_id = $is_coordinator_id ORDER BY ovm_meeting_id DESC ");
            $rows = DB::Select("SELECT * FROM ovm_meeting_isc_feedback WHERE is_coordinator_id = $is_coordinator_id AND enrollment_id IN (SELECT enrollment_id FROM ovm_meeting_details WHERE meeting_status != 'Sent' AND meeting_status != 'Declined') ORDER BY ovm_meeting_id DESC");

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
    public function ovmreport(Request $request)
    {

        try {

            $method = 'Method => ovm1Controller => index';

            $authID = auth()->user()->id;

            $roleGet = DB::select("SELECT b.role_name FROM users AS a INNER JOIN uam_roles AS b ON b.role_id=a.array_roles where a.id = $authID");
            $role = $roleGet[0]->role_name;

            $user_id =  $request['user_id'];
            // $this->WriteFileLog($user_id);
            $rows = array();
            $rolesArray = array_merge(array(auth()->user()->array_roles), array(auth()->user()->roles));
            if (in_array(4, $rolesArray)) {
                $rows = DB::Select("SELECT a.is_coordinator_id,a.ovm_meeting_id, a.ovm_meeting_unique, a.enrollment_id, a.child_id, a.child_name,  a.status, b.child_contact_email,a.report_flag FROM ovm_meeting_isc_feedback AS a INNER JOIN enrollment_details AS b ON  a.enrollment_id= b.enrollment_child_num 
                WHERE a.ovm_isc_report_id IN (SELECT ovm_isc_report_id FROM ovm_meeting_isc_feedback WHERE STATUS = 'Submitted' OR STATUS = 'Completed') 
                GROUP BY ovm_meeting_unique 
                ORDER BY ovm_meeting_id desc");
                $completed = DB::select("SELECT GROUP_CONCAT(ovm_meeting_id) as com FROM ovm_meeting_isc_feedback WHERE STATUS = 'Completed'");
            } else {
                $rows = DB::select("SELECT a.is_coordinator_id,a.ovm_meeting_id, a.ovm_meeting_unique, a.enrollment_id, a.child_id, a.child_name,  a.status, b.child_contact_email,a.report_flag FROM ovm_meeting_isc_feedback AS a INNER JOIN enrollment_details AS b ON  a.enrollment_id= b.enrollment_child_num 
                WHERE a.ovm_isc_report_id IN (SELECT ovm_isc_report_id FROM ovm_meeting_isc_feedback WHERE STATUS = 'Submitted' OR STATUS = 'Completed') and a.is_coordinator_id=$authID ORDER BY ovm_meeting_id desc");
                $completed = DB::select("SELECT GROUP_CONCAT(ovm_meeting_id) as com FROM ovm_meeting_isc_feedback WHERE STATUS = 'Completed'");
            }



            // $this->WriteFileLog($rows);
            $response = [
                'rows' => $rows,
                'completed' => $completed[0]
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
    public function ovmreportview(Request $request)
    {
        try {

            $method = 'Method => ovm1Controller => ovmreportview';

            $authID = auth()->user()->id;

            $roleGet = DB::select("SELECT b.role_name FROM users AS a INNER JOIN uam_roles AS b ON b.role_id=a.array_roles where a.id = $authID");
            $role = $roleGet[0]->role_name;

            $ovm_meeting_id =  $request['ovm_meeting_id'];
            $ovm_meeting_id = decrypt($ovm_meeting_id);

            $rows = array();
            $email = DB::select("SELECT * FROM email_preview WHERE screen = 'OVM Report' AND active_flag = 0");

            // if ($role == 'IS Head') {
            $rows = DB::Select("SELECT a.*,b.name,b.email,b.id as is_coordinator_id FROM ovm_meeting_isc_feedback AS a right join users AS b ON b.id = a.is_coordinator_id
                WHERE a.ovm_meeting_id='" . $ovm_meeting_id . "' ORDER BY a.ovm_isc_report_id ASC");
            // } else {
            //     $rows = DB::Select("SELECT a.*,b.name,b.email,b.id as is_coordinator_id FROM ovm_meeting_isc_feedback AS a right join users AS b ON b.id = a.is_coordinator_id
            //     WHERE a.ovm_isc_report_id NOT IN (SELECT ovm_isc_report_id FROM ovm_meeting_isc_feedback WHERE status = 'Saved' OR status = 'New')
            //     AND a.ovm_meeting_id='" . $ovm_meeting_id . "' AND is_coordinator_id=$authID");
            // }

            $fetch = [
                'question' => DB::select("SELECT * FROM conversation_questions WHERE type_id = 2 and group_id != 1 ORDER BY order_id ASC "),
                'feedback' => DB::select("SELECT * FROM ovm_conversation_feedback WHERE ovm_meeting_id = $ovm_meeting_id AND (ishead_save IS NULL OR ishead_save = 0)AND conversation_008 IS NOT NULL"),
                'notes' => DB::select("SELECT * FROM ovm_conversation_note WHERE ovm_meeting_id = $ovm_meeting_id AND (ishead_save IS NULL OR ishead_save = 0)"),
            ];
            $group = DB::select("SELECT * FROM conversation_summery_groups WHERE active_flag = 1");

            $enrollmentNum = $rows[0]->enrollment_id;
            $coordinator = DB::select("SELECT a.is_coordinator1 , a.is_coordinator2 FROM ovm_allocation AS a INNER JOIN enrollment_details AS b ON a.enrollment_id = b.enrollment_id
            WHERE b.enrollment_child_num = '$enrollmentNum'");

            $response = [
                'rows' => $rows,
                'role' => $role,
                'email' => $email,
                'fetch' => $fetch,
                'group' => $group,
                'coordinator' => $coordinator,
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
    public function ovmiscfeedbackstore(Request $request)
    {
        try {
            $method = 'Method => ovm1Controller => ovmiscfeedbackstore';
            $inputArray = $this->decryptData($request->requestData);
            $input = [
                'ovm_isc_report_id' => $inputArray['ovm_isc_report_id'],
                'ovm_meeting_unique' => $inputArray['ovm_meeting_unique'],
                'enrollment_id' => $inputArray['enrollment_id'],
                'child_id' => $inputArray['child_id'],
                'child_name' => $inputArray['child_name'],
                'primary_caretaker' => $inputArray['primary_caretaker'],
                'family_type' => $inputArray['family_type'],
                'siblings' => $inputArray['siblings'],
                'profession_of_the_parents' => $inputArray['profession_of_the_parents'],
                'academics' => $inputArray['academics'],
                'developmental_milestones_motor_lang_speech' => $inputArray['developmental_milestones_motor_lang_speech'],
                'schools_attended_school_currently_grade' => $inputArray['schools_attended_school_currently_grade'],
                'previous_interventions_given_current_intervention' => $inputArray['previous_interventions_given_current_intervention'],
                'any_assessment_done' => $inputArray['any_assessment_done'],
                'food_sleep_pattern_any_medication' => $inputArray['food_sleep_pattern_any_medication'],
                'socialization_emotional_communication_sensory' => $inputArray['socialization_emotional_communication_sensory'],
                'adls_general_routine' => $inputArray['adls_general_routine'],
                'birth_history' => $inputArray['birth_history'],
                'strength_interests' => $inputArray['strength_interests'],
                'current_challenges_concerns' => $inputArray['current_challenges_concerns'],
                'other_information' => $inputArray['other_information'],
                'introspection' => $inputArray['introspection'],
                'expectation_from_school' => $inputArray['expectation_from_school'],
                'expectation_from_elina' => $inputArray['expectation_from_elina'],
                'notes' => $inputArray['notes'],
                'type' => $inputArray['type'],
                'user_id' => $inputArray['user_id'],
                'g2form_filled' => $inputArray['g2form_filled'],
            ];

            if ($input['ovm_isc_report_id'] != null) {
                if ($inputArray['type'] == 'Saved_Ishead') {
                    $response = DB::transaction(function () use ($input, $inputArray) {

                        DB::table('ovm_meeting_isc_feedback')->updateOrInsert(
                            ['ovm_isc_report_id' => $input['ovm_isc_report_id']], // Where clause
                            ['ishead_save' => '1']
                        );

                        $que = $inputArray['que'];
                        $note = $inputArray['note'];

                        $reportID = $input['ovm_isc_report_id'];

                        $noti = DB::select("SELECT * FROM ovm_meeting_isc_feedback WHERE ovm_isc_report_id ='$reportID'");

                        DB::table('ovm_conversation_feedback')->updateOrInsert(
                            ['ovm_isc_report_id' => $input['ovm_isc_report_id'], 'ishead_save' => 1], // Where clause
                            array_merge(['user_id' => auth()->user()->id], $que, ['ovm_meeting_id' => $noti[0]->ovm_meeting_id])
                        );

                        DB::table('ovm_conversation_note')->updateOrInsert(
                            ['ovm_isc_report_id' => $input['ovm_isc_report_id'], 'ishead_save' => 1], // Where clause
                            array_merge(['user_id' => auth()->user()->id], $note, ['ovm_meeting_id' => $noti[0]->ovm_meeting_id])
                        );

                        // $this->auditLog('ovm_meeting_isc_feedback', $input['ovm_isc_report_id'], 'Create', 'FeedBack of OVM-1 is Saved', auth()->user()->id, NOW(), ' $role_name_fetch');
                        // $this->ovm_status_logs('ovm_isc_report_id', $input['ovm_isc_report_id'], 'OVM Report Summary ' . $input['type'], 'OVM Status', auth()->user()->id, NOW(), $input['enrollment_id'], auth()->user()->name);

                        $response = [
                            'check' => 1
                        ];
                        return $response;
                    });
                } else {
                    $response = DB::transaction(function () use ($input, $inputArray) {

                        $typeStatus1 = $input['type'];
                        if ($typeStatus1 == 'Completed') {
                            $typeStatus1 = 'Submitted';
                        }
                        DB::table('ovm_meeting_isc_feedback')
                            ->where('ovm_isc_report_id', $input['ovm_isc_report_id'])
                            ->update([
                                'enrollment_id' => $input['enrollment_id'],
                                'child_id' => $input['child_id'],
                                'child_name' => $input['child_name'],
                                'primary_caretaker' => $input['primary_caretaker'],
                                'family_type' => $input['family_type'],
                                'siblings' => $input['siblings'],
                                'profession_of_the_parents' => $input['profession_of_the_parents'],
                                'academics' => $input['academics'],
                                'developmental_milestones_motor_lang_speech' => $input['developmental_milestones_motor_lang_speech'],
                                'schools_attended_school_currently_grade' => $input['schools_attended_school_currently_grade'],
                                'previous_interventions_given_current_intervention' => $input['previous_interventions_given_current_intervention'],
                                'any_assessment_done' => $input['any_assessment_done'],
                                'food_sleep_pattern_any_medication' => $input['food_sleep_pattern_any_medication'],
                                'socialization_emotional_communication_sensory' => $input['socialization_emotional_communication_sensory'],
                                'adls_general_routine' => $input['adls_general_routine'],
                                'birth_history' => $input['birth_history'],
                                'strength_interests' => $input['strength_interests'],
                                'current_challenges_concerns' => $input['current_challenges_concerns'],
                                'other_information' => $input['other_information'],
                                'introspection' => $input['introspection'],
                                'expectation_from_school' => $input['expectation_from_school'],
                                'expectation_from_elina' => $input['expectation_from_elina'],
                                'notes' => $input['notes'],
                                'status' => $typeStatus1,
                                'created_at' => NOW(),
                                'last_modified_by' => auth()->user()->id,
                                'ishead_save' => '0',
                            ]);

                        $que = $inputArray['que'];
                        $note = $inputArray['note'];

                        $reportID = $input['ovm_isc_report_id'];
                        $noti = DB::select("SELECT * FROM ovm_meeting_isc_feedback WHERE ovm_isc_report_id ='$reportID'");

                        DB::table('ovm_conversation_feedback')->where([['ovm_isc_report_id', $input['ovm_isc_report_id']], ['ishead_save', '1']])->delete();
                        DB::table('ovm_conversation_note')->where([['ovm_isc_report_id', $input['ovm_isc_report_id']], ['ishead_save', '1']])->delete();

                        DB::table('ovm_conversation_feedback')->updateOrInsert(
                            ['ovm_isc_report_id' => $input['ovm_isc_report_id']], // Where clause
                            array_merge(['user_id' => auth()->user()->id], $que, ['ovm_meeting_id' => $noti[0]->ovm_meeting_id])
                        );

                        DB::table('ovm_conversation_note')->updateOrInsert(
                            ['ovm_isc_report_id' => $input['ovm_isc_report_id']], // Where clause
                            array_merge(['user_id' => auth()->user()->id], $note, ['ovm_meeting_id' => $noti[0]->ovm_meeting_id])
                        );

                        if ($input['g2form_filled'] == 1) {
                            $ed = DB::select("Select * from enrollment_details where enrollment_child_num = '" . $input['enrollment_id'] . "'");
                            DB::table('ovm_g2form_feedback')->updateOrInsert(
                                ['enrollment_id' => $ed[0]->enrollment_id], // Where clause
                                ['g2form_filled' => 1,]
                            );
                        }

                        $this->auditLog('ovm_meeting_isc_feedback', $input['ovm_isc_report_id'], 'Create', 'FeedBack of OVM-1 is Saved', auth()->user()->id, NOW(), ' $role_name_fetch');
                        $this->ovm_status_logs('ovm_isc_report_id', $input['ovm_isc_report_id'], 'OVM Report Summary ' . $input['type'], 'OVM Status', auth()->user()->id, NOW(), $input['enrollment_id'], auth()->user()->name);


                        // $reportID = $input['ovm_isc_report_id'];
                        $authID = auth()->user()->id;
                        $roleGet = DB::select("SELECT b.role_name FROM users AS a INNER JOIN uam_roles AS b ON b.role_id=a.array_roles where a.id = $authID");
                        $role = $roleGet[0]->role_name;
                        // $noti = DB::select("SELECT * FROM ovm_meeting_isc_feedback WHERE ovm_isc_report_id ='$reportID'");


                        $en = $input['enrollment_id'];

                        $isc = DB::select("SELECT * FROM ovm_meeting_isc_feedback WHERE enrollment_id ='$en'");
                        $email = DB::select("SELECT TIMESTAMPDIFF(YEAR, a.child_dob , CURDATE()) AS age , a.* FROM enrollment_details AS a WHERE a.enrollment_child_num = '$en'");
                        $isc_1 = $isc[0]->is_coordinator_id;

                        $isc_2 = (count($email) > 1) ? $isc[1]->is_coordinator_id : '';

                        $user_id_1 = DB::select("select * from users where id='$isc_1'");
                        $user_id_2 = DB::select("select * from users where id='$isc_2'");

                        if ($input['type'] == 'Submitted') {
                            if ($role == 'IS Head') {
                                DB::table('notifications')->insertGetId([
                                    'user_id' =>  $noti[0]->is_coordinator_id,
                                    'notification_type' => 'OVM Meeting',
                                    'notification_status' => 'OVM Meeting',
                                    'notification_url' => 'ovmcompleted/' . encrypt($noti[0]->ovm_meeting_id),
                                    'megcontent' => "OVM-1 for child-" . $noti[0]->child_name . " ( " . $noti[0]->enrollment_id . " ) " . " Conversation Report Edited by IS Head",
                                    'alert_meg' => "OVM-1 for child-" . $noti[0]->child_name .  " ( " . $noti[0]->enrollment_id . " ) " . " Conversation Report Edited by IS Head",
                                    'created_by' => auth()->user()->id,
                                    'created_at' => NOW()
                                ]);
                            } else {
                                $admin_details = DB::SELECT("SELECT * from users where array_roles = '4'");
                                $coID1 = $noti[0]->is_coordinator_id;
                                $Co_details = DB::SELECT("SELECT * from users where id =$coID1");
                                for ($i = 0; $i < count($admin_details); $i++) {
                                    DB::table('notifications')->insertGetId([
                                        'user_id' =>  $admin_details[$i]->id,
                                        'notification_type' => 'OVM Meeting',
                                        'notification_status' => 'OVM Meeting',
                                        'notification_url' => 'ovmreportview/' . encrypt($noti[0]->ovm_meeting_id),
                                        'megcontent' => "OVM-1 for child-" . $noti[0]->child_name .  " ( " . $noti[0]->enrollment_id . " ) " . " Conversation Report Submitted by IS Coordinator " . $Co_details[0]->name,
                                        'alert_meg' => "OVM-1 for child-" . $noti[0]->child_name .  " ( " . $noti[0]->enrollment_id . " ) " . " Conversation Report Submitted by IS Coordinator " . $Co_details[0]->name,
                                        'created_by' => auth()->user()->id,
                                        'created_at' => NOW()
                                    ]);
                                }
                            }

                            $col2ID = (!is_null($isc_2) && $isc_2 !== '') ? $user_id_2[0]->id : 0;
                            $col2Name = (!is_null($isc_2) && $isc_2 !== '') ? $user_id_2[0]->name : '';

                            $e = $noti[0]->enrollment_id;
                            $pdf = DB::select("SELECT a.* , b.* , c.* , a.created_at as doc FROM ovm_meeting_isc_feedback AS a
                        INNER JOIN enrollment_details AS b ON a.enrollment_id = b.enrollment_child_num
                        INNER JOIN users AS c ON a.is_coordinator_id = c.id
                        WHERE a.enrollment_id = '$e' ORDER BY CASE is_coordinator_id  WHEN $coID1 THEN 1  WHEN $col2ID THEN 2 ELSE 3 END");
                            $ovc_id = $noti[0]->ovm_meeting_id;


                            $fetchdata = DB::select("SELECT * FROM ovm_conversation_feedback WHERE ovm_meeting_id = $ovc_id ORDER BY CASE user_id  WHEN $coID1 THEN 1  WHEN $col2ID THEN 2 ELSE 3 END");
                            $fetchdata1 = DB::select("SELECT * FROM ovm_conversation_note WHERE ovm_meeting_id = $ovc_id ORDER BY CASE user_id  WHEN $coID1 THEN 1  WHEN $col2ID THEN 2 ELSE 3 END");
                            $questions = DB::select("SELECT * FROM conversation_questions WHERE type_id = 2 ORDER BY order_id ASC ");
                            $group = DB::select("SELECT * FROM conversation_summery_groups WHERE active_flag = 1");
                            // $this->WriteFileLog($fetchdata1 , $fetchdata);


                            $response = [
                                'is_coordinator_1_name' => $user_id_1[0]->name,
                                'is_coordinator_2_name' => $col2Name,
                                'is_coordinator_1_id' => $user_id_1[0]->id,
                                'is_coordinator_2_id' => $col2ID,
                                'user_id' => $isc[0]->user_id,
                                'child_contact_email' => $email[0]->child_contact_email,
                                'child_dob' => $email[0]->child_dob,
                                'child_id' => $email[0]->child_id,
                                'enrollment_id' => $input['enrollment_id'],
                                'child_contact_address' => $email[0]->child_contact_address,
                                'child_name' => $email[0]->child_name,
                                'child_age' => $email[0]->age,
                                'pdf' => $pdf,
                                'questions' => $questions,
                                'fetchdata1' => $fetchdata1,
                                'fetchdata' => $fetchdata,
                                'group' => $group,
                                'check' => 0
                            ];
                        } else {
                            $response = [
                                'check' => 1
                            ];
                        }

                        return $response;
                    });
                }
                $serviceResponse = array();
                $serviceResponse['Code'] = config('setting.status_code.success');
                $serviceResponse['Message'] = config('setting.status_message.success');
                $serviceResponse['Data'] = $response;
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
    public function ovmiscfeedback_update(Request $request)
    {
        // $this->WriteFileLog("start");
        try {
            $method = 'Method => ovm1Controller => ovmiscfeedback_update';
            $inputArray = $this->decryptData($request->requestData);
            // $this->WriteFileLog($inputArray);
            $input = [
                'que' => $inputArray['que'],
                'enrollment_id' => $inputArray['enrollment_id'],
                'child_id' => $inputArray['child_id'],
                'child_name' => $inputArray['child_name'],
                'type' => $inputArray['type'],
                'user_id' => $inputArray['user_id'],
                'meet_id' => $inputArray['meet_id'],
            ];
            // $this->WriteFileLog($input);
            foreach ($input['que'] as $key => $row) {

                if ($key != null) {
                    if ($inputArray['type'] == 'Saved_Ishead') {
                        $response = DB::transaction(function () use ($input, $inputArray, $key) {

                            // DB::table('ovm_meeting_isc_feedback')->updateOrInsert(
                            //     ['ovm_isc_report_id' => $key], // Where clause
                            //     ['ishead_save' => '1']
                            // );

                            $que = $inputArray['que'];


                            $reportID = $key;

                            $noti = DB::select("SELECT * FROM ovm_meeting_isc_feedback WHERE ovm_isc_report_id ='$reportID'");
                            foreach ($input['que'] as $key => $row) {
                                DB::table('ovm_conversation_feedback')->updateOrInsert(
                                    [
                                        'ovm_isc_report_id' => $key,
                                        'ishead_save' => 1,
                                    ],

                                    $row

                                );
                            }
                            $noti = DB::select("SELECT * FROM ovm_meeting_isc_feedback WHERE ovm_isc_report_id ='$reportID'");

                            // DB::table('ovm_conversation_feedback')->updateOrInsert(
                            //     ['ovm_isc_report_id' => $key, 'ishead_save' => 1], // Where clause
                            //     array_merge(['user_id' => auth()->user()->id], $que, ['ovm_meeting_id' => $noti[0]->ovm_meeting_id])
                            // );


                            // $this->auditLog('ovm_meeting_isc_feedback', $input['ovm_isc_report_id'], 'Create', 'FeedBack of OVM-1 is Saved', auth()->user()->id, NOW(), ' $role_name_fetch');
                            // $this->ovm_status_logs('ovm_isc_report_id', $input['ovm_isc_report_id'], 'OVM Report Summary ' . $input['type'], 'OVM Status', auth()->user()->id, NOW(), $input['enrollment_id'], auth()->user()->name);

                            $response = [
                                'check' => 1
                            ];
                            return $response;
                        });
                    } else {
                        $response = DB::transaction(function () use ($input, $inputArray, $key) {
                            // $this->WriteFileLog("dscds");
                            $typeStatus1 = $input['type'];
                            if ($typeStatus1 == 'Completed') {
                                $typeStatus1 = 'Submitted';
                            }
                            DB::table('ovm_meeting_isc_feedback')
                                ->where('ovm_isc_report_id', $key)
                                ->update([
                                    'enrollment_id' => $input['enrollment_id'],
                                    'child_id' => $input['child_id'],
                                    'child_name' => $input['child_name'],
                                    'status' => $typeStatus1,
                                    'created_at' => NOW(),
                                    'last_modified_by' => auth()->user()->id,
                                    'ishead_save' => '0',
                                ]);
                            // $this->WriteFileLog("dscds1");

                            $que = $input['que'];
                            // $this->WriteFileLog($que);


                            $reportID = $key;
                            // $this->WriteFileLog($reportID);
                            $noti = DB::select("SELECT * FROM ovm_meeting_isc_feedback WHERE ovm_isc_report_id ='$reportID'");
                            // $this->WriteFileLog($noti);
                            // $this->WriteFileLog($reportID);

                            DB::table('ovm_conversation_feedback')->where([['ovm_isc_report_id', $key], ['ishead_save', '1']])->delete();
                            DB::table('ovm_conversation_note')->where([['ovm_isc_report_id', $key], ['ishead_save', '1']])->delete();

                            // $this->WriteFileLog("sdcsd");

                            foreach ($que as $key => $row1) {
                                // $this->WriteFileLog($row1);
                                // Merge the additional columns from $inputArray into $row1
                                $row1 = array_merge($row1, [
                                    'ovm_meeting_id' => $inputArray['meet_id'],

                                    // 'user_id'=>
                                    // Add other columns from $inputArray here if needed
                                    // For example: 'other_column_name' => $inputArray['other_column_name'],
                                ]);
                                DB::table('ovm_conversation_feedback')->updateOrInsert(
                                    [
                                        'ovm_isc_report_id' => $key,


                                    ],

                                    $row1

                                );
                            }
                            // $this->WriteFileLog("sadasd");

                            // $this->auditLog('ovm_meeting_isc_feedback', $input['ovm_isc_report_id'], 'Create', 'FeedBack of OVM-1 is Saved', auth()->user()->id, NOW(), ' $role_name_fetch');
                            // $this->ovm_status_logs('ovm_isc_report_id', $input['ovm_isc_report_id'], 'OVM Report Summary ' . $input['type'], 'OVM Status', auth()->user()->id, NOW(), $input['enrollment_id'], auth()->user()->name);

                            $authID = auth()->user()->id;
                            // $this->WriteFileLog($authID);
                            $roleGet = DB::select("SELECT b.role_name FROM users AS a INNER JOIN uam_roles AS b ON b.role_id=a.array_roles where a.id = $authID");
                            $role = $roleGet[0]->role_name;
                            // $noti = DB::select("SELECT * FROM ovm_meeting_isc_feedback WHERE ovm_isc_report_id ='$reportID'");
                            // $this->WriteFileLog("sadasd1");


                            $en = $input['enrollment_id'];

                            $isc = DB::select("SELECT * FROM ovm_meeting_isc_feedback WHERE enrollment_id ='$en'");
                            $email = DB::select("SELECT TIMESTAMPDIFF(YEAR, a.child_dob , CURDATE()) AS age , a.* FROM enrollment_details AS a WHERE a.enrollment_child_num = '$en'");
                            // $this->WriteFileLog($email);
                            $isc_1 = $isc[0]->is_coordinator_id;
                            // $this->WriteFileLog($isc[1]->is_coordinator_id);
                            $isc_2 =  $isc[1]->is_coordinator_id;
                            // $this->WriteFileLog($isc_2);
                            $user_id_1 = DB::select("select * from users where id='$isc_1'");
                            $user_id_2 = DB::select("select * from users where id='$isc_2'");
                            // $this->WriteFileLog($user_id_2);
                            if ($input['type'] == 'Completed') {
                                if ($role == 'IS Head') {
                                    DB::table('notifications')->insertGetId([
                                        'user_id' =>  $noti[0]->is_coordinator_id,
                                        'notification_type' => 'OVM Meeting',
                                        'notification_status' => 'OVM Meeting',
                                        'notification_url' => 'ovmcompleted/' . encrypt($noti[0]->ovm_meeting_id),
                                        'megcontent' => "OVM-1 for child-" . $noti[0]->child_name . " ( " . $noti[0]->enrollment_id . " ) " . " Conversation Report Edited by IS Head",
                                        'alert_meg' => "OVM-1 for child-" . $noti[0]->child_name .  " ( " . $noti[0]->enrollment_id . " ) " . " Conversation Report Edited by IS Head",
                                        'created_by' => auth()->user()->id,
                                        'created_at' => NOW()
                                    ]);
                                } else {
                                    $admin_details = DB::SELECT("SELECT * from users where array_roles = '4'");
                                    $coID1 = $noti[0]->is_coordinator_id;
                                    $Co_details = DB::SELECT("SELECT * from users where id =$coID1");
                                    for ($i = 0; $i < count($admin_details); $i++) {
                                        DB::table('notifications')->insertGetId([
                                            'user_id' =>  $admin_details[$i]->id,
                                            'notification_type' => 'OVM Meeting',
                                            'notification_status' => 'OVM Meeting',
                                            'notification_url' => 'ovmreportview/' . encrypt($noti[0]->ovm_meeting_id),
                                            'megcontent' => "OVM-1 for child-" . $noti[0]->child_name .  " ( " . $noti[0]->enrollment_id . " ) " . " Conversation Report Submitted by IS Coordinator " . $Co_details[0]->name,
                                            'alert_meg' => "OVM-1 for child-" . $noti[0]->child_name .  " ( " . $noti[0]->enrollment_id . " ) " . " Conversation Report Submitted by IS Coordinator " . $Co_details[0]->name,
                                            'created_by' => auth()->user()->id,
                                            'created_at' => NOW()
                                        ]);
                                    }
                                }

                                $col2ID = (!is_null($isc_2) && $isc_2 !== '') ? $user_id_2[0]->id : 0;
                                $col2Name = (!is_null($isc_2) && $isc_2 !== '') ? $user_id_2[0]->name : '';
                                // $this->WriteFileLog($col2ID);
                                $e = $noti[0]->enrollment_id;
                                $pdf = DB::select("SELECT a.* , b.* , c.* , a.created_at as doc FROM ovm_meeting_isc_feedback AS a
                                INNER JOIN enrollment_details AS b ON a.enrollment_id = b.enrollment_child_num
                               INNER JOIN users AS c ON a.is_coordinator_id = c.id
                               WHERE a.enrollment_id = '$e'");
                                $ovc_id = $noti[0]->ovm_meeting_id;

                                $fetchdata = DB::select("SELECT * FROM ovm_conversation_feedback WHERE ovm_meeting_id = $ovc_id");
                                $fetchdata1 = DB::select("SELECT * FROM ovm_conversation_note WHERE ovm_meeting_id = $ovc_id");

                                $questions = DB::select("SELECT * FROM conversation_questions WHERE type_id = 2 ORDER BY order_id ASC");
                                $group = DB::select("SELECT * FROM conversation_summery_groups WHERE active_flag = 1");


                                $response = [
                                    'is_coordinator_1_name' => $user_id_1[0]->name,
                                    'is_coordinator_2_name' => $col2Name,
                                    'is_coordinator_1_id' => $user_id_1[0]->id,
                                    'is_coordinator_2_id' => $col2ID,
                                    'user_id' => $isc[0]->user_id,
                                    'child_contact_email' => $email[0]->child_contact_email,
                                    'child_dob' => $email[0]->child_dob,
                                    'child_id' => $email[0]->child_id,
                                    'enrollment_id' => $input['enrollment_id'],
                                    'child_contact_address' => $email[0]->child_contact_address,
                                    'child_name' => $email[0]->child_name,
                                    'child_age' => $email[0]->age,
                                    'pdf' => $pdf,
                                    'fetchdata1' => $fetchdata1,
                                    'fetchdata' => $fetchdata,
                                    'questions' => $questions,
                                    'group' => $group,
                                    'check' => 0
                                ];
                            } else {
                                $response = [
                                    'check' => 1
                                ];
                            }

                            return $response;
                        });
                    }
                    $serviceResponse = array();
                    $serviceResponse['Code'] = config('setting.status_code.success');
                    $serviceResponse['Message'] = config('setting.status_message.success');
                    $serviceResponse['Data'] = $response;
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

    public function GetEventData(Request $request)
    {
        $logMethod = 'Method => ovm1Controller => GetEventData';
        try {
            $fieldID = $request->fieldID;
            // $this->WriteFileLog($fieldID);
            $field_allocated = [];
            $fieldOptions1 = DB::select('SELECT CONCAT(meeting_subject," : ",TIME_FORMAT(meeting_starttime, "%r")," - ",TIME_FORMAT(meeting_endtime, "%r")) AS eventName, meeting_starttime,meeting_endtime,
            "Work" as calendar , "orange" as color, meeting_startdate AS "date" ,  meeting_startdate AS idate FROM ovm_meeting_details 
            WHERE JSON_EXTRACT(is_coordinator1, "$.id") = ' . $fieldID . ' AND meeting_status != "Saved" AND meeting_status != "Completed";');
            $fieldOptions2 = DB::select('SELECT CONCAT(meeting_subject," : ",TIME_FORMAT(meeting_starttime, "%r")," - ",TIME_FORMAT(meeting_endtime, "%r")) AS eventName, meeting_starttime,meeting_endtime,
            "Work" as calendar , "orange" as color, meeting_startdate AS "date" ,  meeting_startdate AS idate FROM ovm_meeting_details 
            WHERE JSON_EXTRACT(is_coordinator2, "$.id") = ' . $fieldID . ' AND meeting_status != "Saved" AND meeting_status != "Completed";');
            $fieldOptions21 = DB::select('SELECT CONCAT("OVM Allocated : ",TIME_FORMAT(meeting_starttime, "%r")," - ",
          TIME_FORMAT(meeting_endtime, "%r")) AS eventName, meeting_starttime,meeting_endtime, "Work" as calendar , "orange" as color, meeting_startdate AS "date" ,  
          meeting_startdate AS idate FROM ovm_allocation WHERE (is_coordinator1 = ' . $fieldID . ' OR is_coordinator2 = ' . $fieldID . ') AND meeting_status != "Saved" AND meeting_status = "Accept" AND meeting_starttime !="00:00:00"
          AND child_id NOT IN (SELECT child_id FROM ovm_meeting_details)');




            foreach ($fieldOptions1 as $field_detail1) {
                array_push($field_allocated, $field_detail1);
            }
            foreach ($fieldOptions2 as $field_detail2) {
                array_push($field_allocated, $field_detail2);
            }
            foreach ($fieldOptions21 as $field_detail21) {
                array_push($field_allocated, $field_detail21);
            }

            $fieldOptions3 = DB::select('SELECT CONCAT(meeting_subject," : ",TIME_FORMAT(meeting_starttime, "%r")," - ",TIME_FORMAT(meeting_endtime, "%r")) AS eventName, meeting_starttime,meeting_endtime,
            "Work" as calendar , "orange" as color, meeting_startdate AS "date" ,  meeting_startdate AS idate FROM ovm_meeting_2_details 
            WHERE JSON_EXTRACT(is_coordinator1, "$.id") = ' . $fieldID . ' AND meeting_status != "Saved" AND meeting_status != "Completed";');
            $fieldOptions4 = DB::select('SELECT CONCAT(meeting_subject," : ",TIME_FORMAT(meeting_starttime, "%r")," - ",TIME_FORMAT(meeting_endtime, "%r")) AS eventName, meeting_starttime,meeting_endtime,
            "Work" as calendar , "orange" as color, meeting_startdate AS "date" ,  meeting_startdate AS idate FROM ovm_meeting_2_details 
            WHERE JSON_EXTRACT(is_coordinator2, "$.id") = ' . $fieldID . ' AND meeting_status != "Saved" AND meeting_status != "Completed";');
            foreach ($fieldOptions3 as $field_detail3) {
                array_push($field_allocated, $field_detail3);
            }
            foreach ($fieldOptions4 as $field_detail4) {
                array_push($field_allocated, $field_detail4);
            }

            $serviceResponse = array();
            $serviceResponse['Code'] = config('setting.status_code.success');
            $serviceResponse['Message'] = config('setting.status_message.success');
            $serviceResponse['Data'] = $field_allocated;
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

    public function report_sent(Request $request)
    {

        $inputArray = $this->decryptData($request->requestData);

        // $this->WriteFileLog($inputArray);
        $id = $inputArray['child_id'];
        $email_draft = $inputArray['email_draft'];
        $report_id =   DB::select("select child_name,child_contact_email,user_id,enrollment_child_num from enrollment_details WHERE child_id='$id'");
        $data = array(
            'child_name' => $report_id[0]->child_name,
            'ovm_assessment' => $inputArray['ovm_assessment'],
            'email_draft' => $inputArray['email_draft']

        );

        // Mail::to($report_id[0]->child_contact_email)->send(new ovmassessment($data));

        // Mail::to($report_id[0]->child_contact_email)
        //     ->cc($inputArray['mail_cc'])
        //     ->send(new ovmassessment($data));

        $ccEmails = array_filter($inputArray['mail_cc'] ?? [], function ($value) {
            return !is_null($value);
        });

        Mail::to($report_id[0]->child_contact_email)
            ->cc($ccEmails ?: [])
            ->send(new ovmassessment($data));

        DB::table('ovm_meeting_isc_feedback')
            ->where('child_id', $id)
            ->update([
                'report_flag' => 1,
                'status' => 'Completed',
            ]);

        DB::table('notifications')->insertGetId([
            'user_id' =>  $report_id[0]->user_id,
            'notification_type' => 'OVM Meeting',
            'notification_status' => 'OVM Meeting',
            'notification_url' => $inputArray['notification'] . "/sail_guide.pdf",
            'megcontent' => "Sail Guide For Child-" . $report_id[0]->child_name .  " ( " . $report_id[0]->enrollment_child_num . " ) " . " has been Generated",
            'alert_meg' => "Sail Guide For Child-" . $report_id[0]->child_name .  " ( " . $report_id[0]->enrollment_child_num . " ) " . " has been Generated",
            'created_by' => auth()->user()->id,
            'created_at' => NOW()
        ]);

        $serviceResponse = array();
        $serviceResponse['Code'] = config('setting.status_code.success');
        $serviceResponse['Message'] = config('setting.status_message.success');
        $serviceResponse['Data'] = 1;
        $serviceResponse = json_encode($serviceResponse, JSON_FORCE_OBJECT);
        $sendServiceResponse = $this->SendServiceResponse($serviceResponse, config('setting.status_code.success'), true);
        return $sendServiceResponse;
    }
    public function ovm_report_download(Request $request)
    {
        try {
            $method = 'Method => ovm1Controller => ovm_report_download';
            $inputArray = $this->decryptData($request->requestData);
            $id = $inputArray['child_id'];
            $report_id =   DB::select("select * from enrollment_details WHERE child_id='$id'");
            $ovm_report = $inputArray['ovm_report'];
            $child_name = $inputArray['child_name'];

            $data = array(
                'child_name' => $child_name,
                'ovm_report' => $ovm_report,
                'child_contact_email' => $report_id[0]->child_contact_email,
            );

            $getmail = DB::select("select * from users where array_roles='4'");
            $c = count($getmail);
            for ($i = 0; $i < $c; $i++) {
                $mail = $getmail[0]->email;
                Mail::to($mail)->send(new ovmreportmail($data));
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

    public function feedbacksubmit(Request $request, $id)
    {
        try {

            $method = 'Method => ovm1Controller => feedbacksubmit';
            // $this->WriteFileLog($request['user_id']);

            $id = $this->DecryptData($id);
            $authID = auth()->user()->id;


            DB::table('ovm_meeting_isc_feedback')
                ->where('ovm_isc_report_id', $id)
                ->update([
                    'status' => 'Completed',
                    'created_at' => NOW(),
                    'last_modified_by' => auth()->user()->id
                ]);

            $row = DB::select("SELECT ovm_meeting_id FROM ovm_meeting_isc_feedback WHERE ovm_isc_report_id = $id");
            $ovm_meeting_id = $row[0]->ovm_meeting_id;

            $serviceResponse = array();
            $serviceResponse['Code'] = config('setting.status_code.success');
            $serviceResponse['Message'] = config('setting.status_message.success');
            $serviceResponse['Data'] = $ovm_meeting_id;
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

    public function ovm_template_store(Request $request)
    {
        try {
            $method = 'Method => ovm1Controller => ovm_template_store';
            $inputArray = $this->DecryptData($request->requestData);

            $input = [
                'page' => $inputArray['page'],
            ];

            DB::table('report_details')->insertGetId([
                'reports_id' => 12,
                'page' => 1,
                'page_description' => $input['page'],
                'created_by' => auth()->user()->id,
                'created_date' => NOW()
            ]);

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

    public function SailguideSave(Request $request)
    {
        try {
            $method = 'Method => ovm1Controller => SailguideSave';
            $inputArray = $this->DecryptData($request->requestData);

            DB::transaction(function () use ($inputArray) {

                $page = $inputArray['page'];

                $page_header =  DB::table('reports_copy')
                    ->insertGetId([
                        'enrollment_id' => $inputArray['enrollment_id'],
                        'report_type' => 12,
                        'status' =>  $inputArray['status'],
                    ]);

                foreach ($page as $index => $value) {

                    DB::table('report_details_copy')->insertGetId([
                        'reports_id' => $page_header,
                        'page' => $index,
                        'page_description' => $value,
                        'created_by' => auth()->user()->id,
                        'created_date' => NOW()
                    ]);
                }

                $ovm = DB::select("SELECT ovm_meeting_id FROM ovm_meeting_isc_feedback AS a
                INNER JOIN enrollment_details AS b ON a.enrollment_id = b.enrollment_child_num
                WHERE b.enrollment_id =" . $inputArray['enrollment_id']);

                $meetingID = $ovm[0]->ovm_meeting_id;

                if ($inputArray['status'] == 'Saved') {
                    DB::table('ovm_meeting_isc_feedback')
                        ->where('ovm_meeting_id', $meetingID)
                        ->update([
                            'report_flag' => 2,
                            'email_draft' => $inputArray['email_draft'],
                            'mail_cc' => $inputArray['mail_cc'],
                        ]);
                }
                if ($inputArray['status'] == 'Save') {
                    DB::table('ovm_meeting_isc_feedback')
                        ->where('ovm_meeting_id', $meetingID)
                        ->update([
                            'report_flag' => 2,
                            'email_draft' => $inputArray['email_draft'],
                            'mail_cc' => $inputArray['mail_cc'],
                        ]);
                }
                if ($inputArray['status'] == 'Submitted') {
                    DB::table('ovm_meeting_isc_feedback')
                        ->where('ovm_meeting_id', $meetingID)
                        ->update([
                            'report_flag' => 3,
                            'email_draft' => $inputArray['email_draft'],
                            'mail_cc' => $inputArray['mail_cc'],
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

    public function ovm_template_getdata($id)
    {
        try {

            $method = 'Method => ovm1Controller => ovm_template_getdata';
            $ids = $this->DecryptData($id);

            $rows = DB::table('ovm_meeting_isc_feedback as a')
                ->join('ovm_meeting_details as b', 'b.ovm_meeting_id', '=', 'a.ovm_meeting_id')
                ->join('enrollment_details as c', 'c.enrollment_child_num', '=', 'a.enrollment_id')
                ->join('ovm_conversation_feedback as ocf', 'a.ovm_isc_report_id', '=', 'ocf.ovm_isc_report_id')
                ->where('a.ovm_meeting_id', $ids)
                ->where('a.status', 'Submitted')
                ->whereNotNull('ocf.conversation_001')
                ->orderBy('a.ovm_isc_report_id', 'asc')
                ->select([
                    'a.email_draft as c1',
                    'a.mail_cc as mail_cc',
                    'a.report_flag as finalstatus',
                    'c.services_from_elina',
                    'c.enrollment_id as enID',
                    'current_challenges_concerns',
                    'expectation_from_school',
                    'b.meeting_startdate',
                    'c.child_name',
                    'c.child_id',
                    'c.child_dob',
                    'c.child_gender',
                    'c.child_contact_email',
                    'previous_interventions_given_current_intervention',
                    'academics',
                    'any_assessment_done',
                    'strength_interests',
                    'developmental_milestones_motor_lang_speech',
                    'introspection',
                    'expectation_from_elina',
                    'child_contact_address',
                    'meeting_startdate',
                    'ocf.*'
                ])->get();

            $enrollmentID = $rows[0]->enID ?? null;

            $datacheck = DB::table('reports_copy')->where('enrollment_id', $enrollmentID)->where('report_type', 12)->orderByDesc('report_id')->first();

            if (empty($datacheck)) {
                $report = DB::table('report_details')->where('reports_id', 12)->select('page_description', 'page')->get();
            } else {
                $reportID = $datacheck->report_id;
                $report = DB::table('report_details_copy')->where('reports_id', $reportID)->select('page_description', 'page')->get();
            }

            $email_contents = $rows[0]->c1 ?? '';
            if (empty($email_contents)) {
                $email = DB::table('email_preview')->where('screen', 'OVM Report')->where('active_flag', 0)->value('email_body') ?? '';
            } else {
                $email = DB::table('ovm_meeting_isc_feedback')->where('ovm_meeting_id', $ids)->value('email_draft') ?? '';
            }

            $users = DB::table('users')->whereIn('array_roles', [4, 5])->where('active_flag', 0)->get();

            $response = [
                'rows' => $rows,
                'report' => $report,
                'email' => $email,
                'users' => $users
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

    public function updateGoogleEvent(Googl $googl)
    {
        $detail = DB::select("SELECT b.user_id as parentId , a.* , JSON_EXTRACT(a.is_coordinator1, '$.id') AS isc1, JSON_EXTRACT(a.is_coordinator2, '$.id') AS isc2, CONCAT(a.created_by , ',' , JSON_EXTRACT(a.is_coordinator1, '$.id') , ',' , COALESCE(JSON_EXTRACT(a.is_coordinator2, '$.id'),'') ) AS stakeholders FROM ovm_meeting_details AS a
        INNER JOIN enrollment_details AS b ON b.enrollment_child_num = a.enrollment_id 
        WHERE a.meeting_status != 'Completed' AND a.meeting_status != 'Hold' AND a.meeting_status != 'Saved' AND a.active_flag = 0");

        foreach ($detail as $row) {
            $event_id = $row->event_id;
            $meeting_status = $row->meeting_status;
            $ovm_meeting_id = $row->ovm_meeting_id;
            $child_name = $row->child_name;
            $child_id = $row->child_id;
            $ovm_meeting_unique = $row->ovm_meeting_unique;
            $enrollment_id = $row->enrollment_id;
            $stakeholders = $row->stakeholders;
            $inarr = explode(',', $stakeholders);
            $inarr = array_unique($inarr);
            $parentId = $row->parentId;
            $isc1 = $row->isc1;
            $isc2 = $row->isc2;
            $video_link = $row->video_link;

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
                    $user = DB::select("SELECT * FROM users WHERE email = '$email'"); //Log::info($user);
                    if ($user != []) {
                        $userID = $user[0]->id;
                        $name = $user[0]->name;
                        $check = DB::select("Select * FROM ovm_attendees WHERE ovm_id = $ovm_meeting_id AND ovm_type = '1' AND created_by = $userID");
                        if ($check != []) {
                            $currentStatus = $check[0]->status;
                        } else {
                            $currentStatus = '';
                        }
                        if ($currentStatus != $responseStatus) {
                            DB::select("Delete FROM ovm_attendees WHERE ovm_id = $ovm_meeting_id AND ovm_type = '1' AND created_by = $userID");
                            DB::table('ovm_attendees')->insertGetId([
                                'ovm_type' =>  '1',
                                'ovm_id' => $ovm_meeting_id,
                                'notes' => $attendee['comment'],
                                'attendee' => $userID,
                                'status' => $responseStatus,
                                'overall_status' => $meeting_status,
                                'created_by' => $userID,
                                'created_at' => NOW()
                            ]);
                            DB::table('ovm_status_logs')->insert([
                                'audit_table_name' => 'ovm_meeting_details',
                                'audit_table_id' => $ovm_meeting_id,
                                'audit_action' => 'OVM Meeting ' . $responseStatus,
                                'description' => $responseStatus,
                                'user_id' => $userID,
                                'action_date_time' => now(),
                                'enrollment_id' => $enrollment_id,
                                'role_name' => $name
                            ]);
                            $msgcontent = "OVM-1 Meeting for " . $child_name . " (" . $enrollment_id . " ) has been " . $responseStatus . " by " . $name;
                            // Log::info($parentId);Log::info($userID);
                            if ($parentId == $userID) {
                                $feeden = $enrollment_id;
                                $feed = DB::select("SELECT COUNT(*) AS count FROM ovm_meeting_isc_feedback WHERE enrollment_id = '$feeden'");
                                $feedc = $feed[0]->count;
                                if ($feedc == 0) {
                                    DB::table('ovm_meeting_isc_feedback')
                                        ->insertGetId([
                                            'enrollment_id' => $enrollment_id,
                                            'ovm_meeting_id' => $ovm_meeting_id,
                                            'ovm_meeting_unique' => $ovm_meeting_unique,
                                            'child_id' => $child_id,
                                            'is_coordinator_id' => $isc1,
                                            'child_name' => $child_name,
                                            'status' => 'New',
                                            'user_id' => $userID,
                                            'video_link' => $video_link
                                        ]);

                                    DB::table('ovm_meeting_isc_feedback')
                                        ->insertGetId([
                                            'enrollment_id' => $enrollment_id,
                                            'ovm_meeting_id' => $ovm_meeting_id,
                                            'ovm_meeting_unique' => $ovm_meeting_unique,
                                            'child_id' => $child_id,
                                            'is_coordinator_id' => ($isc2 != '') ? $isc2 : null,
                                            'child_name' => $child_name,
                                            'status' => 'New',
                                            'user_id' => $userID,
                                            'video_link' => $video_link
                                        ]);
                                }
                                DB::table('ovm_meeting_details')
                                    ->where('ovm_meeting_id', $ovm_meeting_id)
                                    ->update([
                                        'meeting_status' => $responseStatus,
                                        'created_date' => NOW()
                                    ]);
                                $msgcontent = "OVM-1 Meeting for child-" . $child_name . " (" . $enrollment_id . " ) has been " . $responseStatus . " by Parent ";
                            }
                            foreach ($inarr as $val) {
                                // Log::error($val);
                                DB::table('notifications')->insertGetId([
                                    'user_id' => $val,
                                    'notification_type' => 'OVM Meeting Scheduled',
                                    'notification_status' => 'OVM Meeting',
                                    'notification_url' => 'ovmsent/' . encrypt($ovm_meeting_id),
                                    'megcontent' => $msgcontent,
                                    'alert_meg' => $msgcontent,
                                    // 'created_by' => auth()->user()->id,
                                    'created_at' => NOW()
                                ]);
                            }
                        } else {
                            $existingNote = $check[0]->notes;
                            DB::table('ovm_meeting_details')
                                ->where('ovm_meeting_id', $ovm_meeting_id)
                                ->update([
                                    'meeting_status' => $responseStatus,
                                    // 'created_date' => NOW()
                                ]);
                            if ($existingNote == null || $existingNote == '' || $existingNote != $attendee['comment']) {
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

    public function g2form_data($id)
    {
        try {
            $method = 'Method => ovm1Controller => g2form_data';
            $id = $this->DecryptData($id);
            $user = DB::select("Select * from enrollment_details where user_id = $id");

            $enrollId = $user[0]->enrollment_id;
            $child_name = $user[0]->child_name;
            // $this->WriteFileLog($enrollId);
            $answers = DB::table('ovm_g2form_feedback')->where('enrollment_id', $enrollId)->get();
            if (isset($answers[0]->version) && $answers[0]->version == 2) {
                $questions = DB::table('conversation_questions')->where('type_id', '1')->where('version', $answers[0]->version)->get();
            } else {
                $questions = DB::table('conversation_questions')->where('type_id', '1')->get();
            }

            $role_name = DB::select("SELECT role_name FROM uam_roles AS ur INNER JOIN users us ON (us.array_roles=ur.role_id) WHERE us.id=" . auth()->user()->id);
            $role = $role_name[0]->role_name;

            $qi = DB::Select("select viewed_users from ovm_g2form_feedback where enrollment_id = $enrollId");
            $viewed = $qi[0]->viewed_users;
            $authId = auth()->user()->id;

            if ($viewed == '') {
                $stringuser_id = $authId;
            } else {
                $che = array($viewed);
                if (in_array($authId, $che)) {
                    $stringuser_id = $viewed;
                } else {
                    $stringuser_id = $viewed . ',' . $authId;
                }
            }


            if (auth()->user()->array_roles != 3) {
                DB::table('ovm_g2form_feedback')
                    ->where('enrollment_id', $enrollId)
                    ->update([
                        'viewed_users' => $stringuser_id,
                    ]);
            }
            $response = [
                'questions' => $questions,
                'answers' => $answers,
                'enrollId' => $enrollId,
                'child_name' => $child_name,
                'role' => $role,
            ];

            // $this->WriteFileLog($response);

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

    public function g2form_list()
    {
        try {
            $method = 'Method => ovm1Controller => g2form_list';

            $authID = auth()->user()->id;

            $roleGet = DB::select("SELECT b.role_name FROM users AS a INNER JOIN uam_roles AS b ON b.role_id=a.array_roles where a.id = $authID");
            $role = $roleGet[0]->role_name;
            if ($role == 'Parent') {
                $rows = DB::select("SELECT b.user_id , b.enrollment_child_num , a.id , a.enrollment_id , a.`status` , b.child_name,a.viewed_users from ovm_g2form_feedback AS a
            INNER JOIN enrollment_details AS b ON a.enrollment_id = b.enrollment_id WHERE b.user_id = $authID");
            } else {
                $rows = DB::select("SELECT b.user_id , b.enrollment_child_num , a.id , a.enrollment_id , a.`status` , b.child_name,a.viewed_users from ovm_g2form_feedback AS a
            INNER JOIN enrollment_details AS b ON a.enrollment_id = b.enrollment_id WHERE a.`status` = 'Submitted' ORDER BY a.enrollment_id DESC ");
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
            $this->WriteFileLog($exceptionResponse);
            $serviceResponse = array();
            $serviceResponse['Code'] = config('setting.status_code.exception');
            $serviceResponse['Message'] = $exc->getMessage();
            $serviceResponse = json_encode($serviceResponse, JSON_FORCE_OBJECT);
            $sendServiceResponse = $this->SendServiceResponse($serviceResponse, config('setting.status_code.exception'), false);
            return $sendServiceResponse;
        }
    }

    public function g2form_storedata(Request $request)
    {
        try {
            $method = 'Method => ovm1Controller => g2form_storedata';

            $inputArray = $this->DecryptData($request->requestData);
            DB::transaction(function () use ($inputArray) {
                $answer = $inputArray['answer'];

                DB::table('ovm_g2form_feedback')->updateOrInsert(
                    ['enrollment_id' => $inputArray['id']], // Where clause
                    array_merge(['status' => $inputArray['type']], $answer)
                );

                // $enrollment = DB::select("Select * from enrollment_details where enrollment_id =" . $inputArray['id']);
                $enrollment = DB::select("Select * from enrollment_details where enrollment_id =" . $inputArray['id']);

                $admin_details = DB::SELECT("SELECT * from users where array_roles = '4'");
                if ($inputArray['type'] == 'Submitted') {
                    foreach ($admin_details as $admin) {
                        DB::table('notifications')->insertGetId([
                            'user_id' => $admin->id,
                            'notification_type' => 'OVM Meeting Scheduled',
                            'notification_status' => 'OVM Meeting',
                            'notification_url' => 'g2form/' . encrypt($enrollment[0]->user_id),
                            'megcontent' => 'Parent Reflection form has been submitted by ' . $enrollment[0]->child_name . ' (' . $enrollment[0]->enrollment_child_num . ')',
                            'alert_meg' => 'Parent Reflection form  has been submitted by ' . $enrollment[0]->child_name . ' (' . $enrollment[0]->enrollment_child_num . ')',
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

    public function g2form_initiate($dataSet)
    {
        // $this->WriteFileLog($dataSet['enrollment_id']);
        $enrollment = DB::select("Select * from enrollment_details where enrollment_id = " . $dataSet['enrollment_id']);

        Mail::to($dataSet['meeting_to'])->send(new G2FormMail($dataSet));

        $ovm_meeting = DB::table('ovm_g2form_feedback')
            ->insertGetId([
                'version' => '2',
                'enrollment_id' => $dataSet['enrollment_id'],
                'status' => 'New',
            ]);
    }
    public function autosave(Request $request)
    {
        try {
            $method = 'Method => ovm1Controller => autosave';
            $inputArray = $this->decryptData($request->requestData);
            $input = [
                'ovm_isc_report_id' => $inputArray['ovm_isc_report_id'],
                'ovm_meeting_unique' => $inputArray['ovm_meeting_unique'],
                'enrollment_id' => $inputArray['enrollment_id'],
                'child_id' => $inputArray['child_id'],
                'child_name' => $inputArray['child_name'],
                'notes' => $inputArray['note'],
                'user_id' => $inputArray['user_id'],

            ];


            if ($input['ovm_isc_report_id'] != null) {

                $response = DB::transaction(function () use ($input, $inputArray) {
                    $status = $inputArray['type'];
                    // $this->WriteFileLog($status);
                    DB::table('ovm_meeting_isc_feedback')->updateOrInsert(
                        ['ovm_isc_report_id' => $input['ovm_isc_report_id']], // Where clause
                        ['status' => $status], // Values to update or insert

                    );

                    $que = $inputArray['que'];
                    // $this->WriteFileLog($que);
                    $note = $inputArray['note'];
                    // $this->WriteFileLog($note);
                    $reportID = $input['ovm_isc_report_id'];
                    $noti = DB::select("SELECT * FROM ovm_meeting_isc_feedback WHERE ovm_isc_report_id ='$reportID'");
                    // Filter out null values from the $que array
                    $filteredQue = array_filter($que, function ($value) {
                        return $value !== null;
                    });
                    // $this->WriteFileLog($filteredQue);

                    $filteredQue1 = array_filter($note, function ($value1) {
                        return $value1 !== null;
                    });

                    // Merge the filteredQue array with other arrays
                    $dataToInsert = array_merge(['user_id' => auth()->user()->id], $filteredQue, ['ovm_meeting_id' => $noti[0]->ovm_meeting_id]);

                    // Update or insert into the table
                    DB::table('ovm_conversation_feedback')->updateOrInsert(
                        ['ovm_isc_report_id' => $input['ovm_isc_report_id']], // Where clause
                        array_merge(['flag' => 1], $dataToInsert),
                    );
                    // DB::table('ovm_conversation_feedback')->updateOrInsert(
                    //     ['ovm_isc_report_id' => $input['ovm_isc_report_id']], // Where clause
                    //     array_merge(['user_id' => auth()->user()->id], $que, ['ovm_meeting_id' => $noti[0]->ovm_meeting_id])
                    // );
                    $dataToInsert1 = array_merge(['user_id' => auth()->user()->id], $filteredQue1, ['ovm_meeting_id' => $noti[0]->ovm_meeting_id]);

                    DB::table('ovm_conversation_note')->updateOrInsert(
                        ['ovm_isc_report_id' => $input['ovm_isc_report_id']], // Where clause
                        $dataToInsert1
                    );
                    $enrollment = DB::select("SELECT enrollment_id FROM enrollment_details WHERE enrollment_child_num = ?", [$inputArray['enrollment_id']]);
                    $en_id = $enrollment[0]->enrollment_id;
                    DB::table('ovm_g2form_feedback')->updateOrInsert(
                        ['enrollment_id' => $en_id], // Where clause
                        ['flag' => 1], // Values to update or insert

                    );
                    // $this->auditLog('ovm_meeting_isc_feedback', $input['ovm_isc_report_id'], 'Create', 'FeedBack of OVM-1 is Saved', auth()->user()->id, NOW(), ' $role_name_fetch');
                    // $this->ovm_status_logs('ovm_isc_report_id', $input['ovm_isc_report_id'], 'OVM Report Summary ' . $input['type'], 'OVM Status', auth()->user()->id, NOW(), $input['enrollment_id'], auth()->user()->name);
                    $response_status = 200;
                    $response = [
                        'response_status' => $response_status
                    ];
                    return $response;
                });
                // $this->WriteFileLog($response);
                $serviceResponse = array();
                $serviceResponse['Code'] = config('setting.status_code.success');
                $serviceResponse['Message'] = config('setting.status_message.success');
                $serviceResponse['Data'] = $response;
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

    public function resend(Request $request, Googl $googl)
    {
        try {
            $method = 'Method => ovm1Controller => resend';
            $userID = auth()->user()->id;
            $inputArray = $this->decryptData($request->requestData);

            $event_id = $inputArray['event_id'];
            $type = $inputArray['ovm'];

            if ($event_id) {
                if ($type == 'ovm1') {
                    $eventDetails = DB::select("SELECT * FROM ovm_meeting_details WHERE event_id = ?", [$event_id]);
                    $ovmType = 'OVM 1';
                } else {
                    $eventDetails = DB::select("SELECT * FROM ovm_meeting_2_details WHERE event_id = ?", [$event_id]);
                    $ovmType = 'OVM 2';
                }

                if (!empty($eventDetails)) {
                    $eventDetails = $eventDetails[0];
                    $this->incrementResendCount($event_id, $type);
                    $resendCount = $this->getCurrentResendCount($event_id, $type);
                    $is_coordinator1 = $eventDetails->is_coordinator1;
                    $is_coordinator1_data = json_decode($is_coordinator1, true);
                    $is_coordinator1_id = $is_coordinator1_data['id'];
                    $is_coordinator1 = DB::select('Select id,email,name from users where id=' . $is_coordinator1_id);
                    $is_coordinator2 = $eventDetails->is_coordinator2;
                    $is_coordinator2_data = json_decode($is_coordinator2, true);
                    $is_coordinator2_id = $is_coordinator2_data['id'];
                    $mail_cc = $eventDetails->mail_cc;
                    $mail_cc = $eventDetails->mail_cc;
                    $a = [];
                    if ($mail_cc != '') {
                        $mail_cc_array = explode(',', $mail_cc);
                        foreach ($mail_cc_array as $email) {
                            $a[] = ['email' => trim($email)];
                        }
                    }
                    if ($is_coordinator2 == 'Select-IS-Coordinator-2') {
                        $is_coordinator2 = '';
                        $is_coordinator2json = '{}';
                        $attendees = array(
                            array('email' => $eventDetails->meeting_to),
                        );
                        $attendees1 = array(
                            array('email' => $is_coordinator1[0]->email),
                        );
                    } else {
                        $is_coordinator2 = DB::select('Select id,email,name from users where id=' . $is_coordinator2_id);
                        $attendees = array(
                            array('email' => $eventDetails->meeting_to),
                        );
                        $attendees1 = array(
                            array('email' => $is_coordinator1[0]->email),
                            array('email' => $is_coordinator2[0]->email),
                        );
                    }

                    $date_str = $eventDetails->meeting_startdate . $eventDetails->meeting_starttime;
                    $date_obj = DateTime::createFromFormat('d/m/Y H:i:s', $date_str, new DateTimeZone('Asia/Kolkata'));

                    if ($date_obj instanceof DateTime) {
                        $date_obj->setTimezone(new DateTimeZone('UTC'));
                        $startTime = $date_obj->format('c');
                    } else {
                        $date_str = $date_str = $eventDetails->meeting_startdate . $eventDetails->meeting_starttime;
                        $date_obj = DateTime::createFromFormat('d/m/Y H:i:s', $date_str, new DateTimeZone('Asia/Kolkata'));
                        $date_obj->setTimezone(new DateTimeZone('UTC'));
                        $startTime = $date_obj->format('c');
                    }

                    $date_str = $date_str = $eventDetails->meeting_startdate . $eventDetails->meeting_endtime;
                    $date_obj = DateTime::createFromFormat('d/m/Y H:i:s', $date_str, new DateTimeZone('Asia/Kolkata'));
                    if ($date_obj instanceof DateTime) {
                        $date_obj->setTimezone(new DateTimeZone('UTC'));
                        $endTime = $date_obj->format('c');
                    } else {
                        $date_str = $date_str = $eventDetails->meeting_startdate . $eventDetails->meeting_endtime;;
                        $date_obj = DateTime::createFromFormat('d/m/Y H:i:s', $date_str, new DateTimeZone('Asia/Kolkata'));
                        $date_obj->setTimezone(new DateTimeZone('UTC'));
                        $endTime = $date_obj->format('c');
                    }

                    $client = $googl->client();
                    $service = new \Google_Service_Calendar($client);
                    if ($type == 'ovm1') {
                        $summaryAdmin = "You have been reinvited(" . $resendCount . ") times to attend the OVM-1 Meeting for " . $eventDetails->child_name;
                    } else {
                        $summaryAdmin = "You have been reinvited(" . $resendCount . ") times to attend the OVM-2 Meeting for " . $eventDetails->child_name;
                    }

                    $event1 = new \Google_Service_Calendar_Event(array(
                        // 'id' => $eventDetails->event_id,
                        'summary' => 'Copy of ' . $ovmType . ' ' . $eventDetails->meeting_subject,
                        'location' => $eventDetails->meeting_location,
                        'description' => $summaryAdmin,
                        'start' => array('dateTime' => $startTime, 'timeZone' => 'Asia/Kolkata',),
                        'end' => array('dateTime' => $endTime, 'timeZone' => 'Asia/Kolkata',),
                        'attendees' =>   array_merge($attendees1, $a, $attendees),
                        'reminders' => array('useDefault' => FALSE, 'overrides' => array(array('method' => 'email', 'minutes' => 24 * 60), array('method' => 'popup', 'minutes' => 10),),),
                        "conferenceData" => array("createRequest" => array("conferenceSolutionKey" => array("type" => "hangoutsMeet"), "requestId" => "123"))
                    ));

                    $opts = array('sendNotifications' => true, 'conferenceDataVersion' => 1);
                    $updatedEvent = $service->events->update('primary', $event_id, $event1, $opts);

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
    protected function incrementResendCount($event_id, $type)
    {
        if ($type == 'ovm1') {
            DB::update("UPDATE ovm_meeting_details SET resend_count = resend_count + 1 WHERE event_id = ?", [$event_id]);
        } else {
            DB::update("UPDATE ovm_meeting_2_details SET resend_count = resend_count + 1 WHERE event_id = ?", [$event_id]);
        }
    }
    protected function getCurrentResendCount($event_id, $type)
    {
        // You need to implement the logic to retrieve the current resend count from your database
        // For example, you can execute a select query to get the count
        if ($type == 'ovm1') {
            $resendCount = DB::select("SELECT resend_count FROM ovm_meeting_details WHERE event_id = ?", [$event_id]);
            // return $resendCount[0]->resend_count;
        } else {
            $resendCount = DB::select("SELECT resend_count FROM ovm_meeting_2_details WHERE event_id = ?", [$event_id]);
            //return $resendCount[0]->resend_count;
        }
        // Check if $resendCount is not empty before accessing its value
        if (!empty($resendCount)) {
            return $resendCount[0]->resend_count;
        } else {
            // Handle the case where resend count is not found
            return 0;
        }
    }
}
