<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Jobs\sendmailjob;
use Illuminate\Support\Facades\Mail;
use App\Mail\senddemomail;
use App\Googl;
use DateTime;
use App\Mail\SailEmailAccept;
use DateTimeZone;

class ovm2Controller extends BaseController

{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index(Request $request , Googl $googl)
    {
        // $this->WriteFileLog($request);

        try {

            $method = 'Method => ovm2Controller => index';


            $authID = auth()->user()->id;
            $this->updateGoogleEvent($googl);
            $role_name = DB::select("SELECT role_name FROM uam_roles AS ur
            INNER JOIN users us ON (us.array_roles=ur.role_id) WHERE us.id=" . auth()->user()->id);
            $role_name_fetch = $role_name[0]->role_name;
            $saveAlert = DB::select("SELECT * FROM ovm_meeting_2_details WHERE meeting_status = 'Saved' AND created_date <= NOW() - INTERVAL 1 DAY AND created_by = $authID");
            $log = DB::select("SELECT * FROM ovm_status_logs");

            $log = DB::select("SELECT * FROM ovm_meeting_2_details AS sd
            INNER JOIN ovm_status_logs AS b ON sd.enrollment_id = b.enrollment_id
            where b.audit_table_name = 'ovm_meeting_2_details'
            ORDER BY b.id DESC ");

            if ($role_name_fetch == 'IS Coordinator') {
                $rows = [];
                $fieldOptions1 = DB::select('SELECT a.ovm_meeting_id,a.ovm_meeting_unique,b.name AS user_id,a.is_coordinator1,a.is_coordinator2,a.enrollment_id,a.child_id,a.child_name,
                a.meeting_to,a.meeting_subject,a.meeting_startdate,a.meeting_enddate,a.meeting_location,
                a.meeting_status,a.meeting_description,a.created_by,a.created_date,a.last_modified_by,a.event_id,
                a.last_modified_date,a.active_flag,a.meeting_starttime,a.meeting_endtime
                from ovm_meeting_2_details as a inner JOIN users b ON a.user_id = b.id
                WHERE JSON_EXTRACT(is_coordinator1, "$.id") = ' . $authID . ' ORDER BY a.ovm_meeting_id DESC');

                $fieldOptions2 = DB::select('SELECT a.ovm_meeting_id,a.ovm_meeting_unique,b.name AS user_id,a.is_coordinator1,a.is_coordinator2,a.enrollment_id,a.child_id,a.child_name,
                a.meeting_to,a.meeting_subject,a.meeting_startdate,a.meeting_enddate,a.meeting_location,
                a.meeting_status,a.meeting_description,a.created_by,a.created_date,a.last_modified_by,a.event_id,
                a.last_modified_date,a.active_flag,a.meeting_starttime,a.meeting_endtime
                from ovm_meeting_2_details as a inner JOIN users b ON a.user_id = b.id
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
                $rows = DB::table('ovm_meeting_2_details')
                    ->select('*')
                    // ->where('active_flag', 0)
                    ->orderByDesc('ovm_meeting_id')
                    ->get();
            }
            $attendeeStatus = DB::select("select * from ovm_attendees where ovm_type = '2' and attendee =" . auth()->user()->id);
            $attendee = DB::select("SELECT ovm_id FROM ovm_attendees where ovm_type = '2' and attendee =" . auth()->user()->id);

            $response = [
                'rows' => $rows,
                'log' => $log,
                'saveAlert' => $saveAlert,
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
            $method = 'Method => ovm2Controller => create';

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
            $method = 'Method => ovm2Controller => store';
            $userID =  auth()->user()->id;
            $email_users = array();
            $inputArray = $this->decryptData($request->requestData);
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
            }
            $enrollment_id = $inputArray['enrollment_child_num'];
            $email_users = [$authuser, $is_coordinator1, $is_coordinator2];

            // // Date - MM/DD/YYYY
            // $startTime = $inputArray['meeting_startdate'] . 'T' . $inputArray['meeting_starttime'] . ':00';
            // $endTime = $inputArray['meeting_enddate'] . 'T' . $inputArray['meeting_endtime'] . ':00';

            // Date - DD/MM/YYYY
            $date_str = $inputArray['meeting_startdate'] . $inputArray['meeting_starttime'];
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

            $date_str = $inputArray['meeting_enddate'] . $inputArray['meeting_endtime'];
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
                'imagename' => $inputArray['imagename'],
                'storagePath' => $inputArray['storagePath'],
                'filepath' => $inputArray['filepath'],
                'mail_cc' => $inputArray['mail_cc'],
            ];




            $user_id = $input['user_id'];
            // $this->WriteFileLog($user_id);
            $type = $input['type'];
            $eventId = '';
            $eventLink = '';
            if ($type == "Sent") {
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
                        dispatch(new sendmailjob($data))->delay(now()->addSeconds(1));
                    }
                }

                //  $this->WriteFileLog("df");


                $client = $googl->client();
                $service = new \Google_Service_Calendar($client);
                // $this->WriteFileLog(json_decode(json_encode($service), true));
                // $this->WriteFileLog("ere");
                // $this->WriteFileLog($inputArray);
                // $this->WriteFileLog($startTime);
                // $this->WriteFileLog($endTime);
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
                // $updatedEvent = $service->events->patch('primary', $eventId, $event1, $opts);
                // 
                $emailTo = $inputArray['meeting_to'];
                $doc = $inputArray['imagename'];
                if ($doc != '') {
                    $data = array(
                        'child_name' => $inputArray['child_name'],
                        'imagename' => $inputArray['filepath'],
                    );
                    Mail::to($emailTo)->send(new senddemomail($data));
                }
            }
            $user_check = DB::select("select * from ovm_meeting_2_details where enrollment_id = '$enrollment_id' and active_flag = 0 ");

            if ($user_check == []) {



                DB::transaction(function () use ($input, $is_coordinator1, $is_coordinator2, $eventId, $eventLink) {
                    $inputArraycount = count($input);
                    $claimdetails = DB::table('ovm_meeting_2_details')->orderBy('ovm_meeting_unique', 'desc')->first();

                    if ($claimdetails == null) {
                        $claimnoticenoNew =  'OVM-2/' . date("Y") . '/' . date("m") . '/001';
                        // $this->WriteFileLog($claimnoticenoNew);
                        // echo ($claimnoticenoNew);exit;
                    } else {
                        $claimnoticeno = $claimdetails->ovm_meeting_unique;
                        $claimnoticenoNew =  ++$claimnoticeno;  // AAA004  
                        // $this->WriteFileLog($claimnoticenoNew);
                    }
                    $ovm_meeting = DB::table('ovm_meeting_2_details')
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
                            'user_id' => $input['user_id'],
                            'event_id' => ($input['type'] == 'Sent') ? $eventId : null,
                            'event_link' => ($input['type'] == 'Sent') ? $eventLink : null,
                            'attachment' => ($input['imagename'] != '') ? $input['filepath'] : null,
                            'created_by' => auth()->user()->id,
                            'created_date' => now(),
                            'mail_cc' => ($input['mail_cc'] != '') ? implode(",", $input['mail_cc']) : null,
                        ]);

                    // $id = $this->elina_assessment($input['enrollment_id'], 'OVM-2 meeting store', 'OVM-2', 'create new ovm-2 meeting details', auth()->user()->id, NOW());
                    // $this->elina_assessment_process($id, 'OVM_meeting_store', 'OVM-2 meeting store', 'OVM-2', 'create new ovm-2 meeting details', auth()->user()->id, NOW());
                    $this->auditLog('ovm_meeting_details', $ovm_meeting, 'OVM', 'created new ovm meeting details', auth()->user()->id, NOW(), ' $role_name_fetch');
                    $this->ovm_status_logs('ovm_meeting_2_details', $ovm_meeting, 'OVM Meeting ' . $input['meeting_status'], 'OVM Status', auth()->user()->id, NOW(), $input['enrollment_child_num'], auth()->user()->name);
                    // $notifications = DB::table('notifications')->insertGetId([
                    //     'user_id' => auth()->user()->id,
                    //     'notification_type' => 'OVM Meeting Scheduled',
                    //     'notification_status' => 'OVM Meeting',  
                    //     'notification_url' => 'ovm2/'. $ovm_meeting,    
                    //     'megcontent' => "Dear ".$input['child_name']." OVM Meeting has been Scheduled Successfully and mail sent.",
                    //     'alert_meg' => "Dear ".$input['child_name']." OVM Meeting has been Scheduled Successfully and mail sent.", 
                    //     'created_by' => auth()->user()->id,
                    //     'created_at' => NOW()
                    // ]);

                    $admin_details = DB::SELECT("SELECT * from users where array_roles = '4' or array_roles = '5' ");
                    $adminn_count = count($admin_details);
                    // if ($admin_details != [] ) {
                    //     for ($j=0; $j < $adminn_count; $j++) { 

                    //         $notifications = DB::table('notifications')->insertGetId([
                    //             'user_id' =>  $admin_details[$j]->id,

                    //             'notification_type' => 'OVM Meeting Scheduled',
                    //             'notification_status' => 'OVM Meeting',  
                    //             'notification_url' => 'ovm2/'. encrypt($ovm_meeting),    
                    //             'megcontent' => "User ".$input['child_name']." OVM Meeting has been Scheduled Successfully and mail sent.",
                    //             'alert_meg' => "User ".$input['child_name']." OVM Meeting has been Scheduled Successfully and mail sent.", 
                    //             'created_by' => auth()->user()->id,
                    //             'created_at' => NOW()
                    //         ]);


                    //     }}    

                    $type1 = $input['type'];
                    if ($type1 == "Sent") {

                        DB::table('notifications')->insertGetId([
                            'user_id' =>  $is_coordinator1[0]->id,
                            'notification_type' => 'OVM Meeting Scheduled',
                            'notification_status' => 'OVM Meeting',
                            'notification_url' => 'ovmsent2/' . encrypt($ovm_meeting),
                            'megcontent' => "OVM-2 Invite Sent for you to attend for child-" . $input['child_name'] . " (" . $input['enrollment_child_num'] . ")",
                            'alert_meg' => "OVM-2 Invite Sent for you to attend for child-" . $input['child_name'] . " (" . $input['enrollment_child_num'] . ")",
                            'created_by' => auth()->user()->id,
                            'created_at' => NOW()
                        ]);
                        if ($is_coordinator2 != '') {
                            DB::table('notifications')->insertGetId([
                                'user_id' =>  $is_coordinator2[0]->id,
                                'notification_type' => 'OVM Meeting Scheduled',
                                'notification_status' => 'OVM Meeting',
                                'notification_url' => 'ovmsent2/' . encrypt($ovm_meeting),
                                'megcontent' => "OVM-2 Invite Sent for you to attend for child-" . $input['child_name'] . " (" . $input['enrollment_child_num'] . ")",
                                'alert_meg' => "OVM-2 Invite Sent for you to attend for child-" . $input['child_name'] . " (" . $input['enrollment_child_num'] . ")",
                                'created_by' => auth()->user()->id,
                                'created_at' => NOW()
                            ]);
                        }

                        $admin_details = DB::SELECT("SELECT * from users where array_roles = '4'");
                        $adminn_count = count($admin_details);
                        if ($admin_details != []) {
                            for ($j = 0; $j < $adminn_count; $j++) {

                                $notifications = DB::table('notifications')->insertGetId([
                                    'user_id' =>  $admin_details[$j]->id,
                                    'notification_type' => 'OVM Meeting Scheduled',
                                    'notification_status' => 'OVM Meeting',
                                    'notification_url' => 'ovmsent2/' . encrypt($ovm_meeting),
                                    'megcontent' => "OVM-2 Meeting for child-" . $input['child_name'] . " (" . $input['enrollment_child_num'] . " ) has been Scheduled",
                                    'alert_meg' => "OVM-2 Meeting for child-" . $input['child_name'] . " (" . $input['enrollment_child_num'] . " ) has been Scheduled",
                                    'created_by' => auth()->user()->id,
                                    'created_at' => NOW()
                                ]);
                            }
                        }

                        $en = $input['enrollment_id']; //$this->WriteFileLog($en);
                        $ee = DB::select("SELECT * FROM enrollment_details WHERE enrollment_id = '$en'"); //$this->WriteFileLog($ee);
                        DB::table('notifications')->insertGetId([
                            'user_id' => $ee[0]->user_id,
                            'notification_type' => 'OVM Meeting Scheduled',
                            'notification_status' => 'OVM Meeting',
                            'notification_url' => 'ovm2/' . encrypt($ovm_meeting),
                            'megcontent' => "OVM-2 Meeting for child-" . $input['child_name'] . " (" . $input['enrollment_child_num'] . " ) has been Scheduled",
                            'alert_meg' => "OVM-2 Meeting for child-" . $input['child_name'] . " (" . $input['enrollment_child_num'] . " ) has been Scheduled",
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


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function data_edit($id)
    {
        try {

            $method = 'Method => ovm2Controller => data_edit';
            // $this->WriteFileLog($method);

            $id = $this->DecryptData($id);


            $rows = DB::table('ovm_meeting_2_details as a')
                ->select('a.*')
                ->where('a.ovm_meeting_id', $id)
                ->get();

            $attendee = DB::select("SELECT a.*,b.name from ovm_attendees AS a
                INNER JOIN users AS b ON a.attendee=b.id where ovm_id = $id and ovm_type=2");
            // $this->WriteFileLog($id);
            // $this->WriteFileLog($rows);

            $iscoordinators = DB::select("SELECT * from users
            right JOIN uam_user_roles ON uam_user_roles.user_id=users.id
            right JOIN uam_roles on uam_roles.role_id = uam_user_roles.role_id
            WHERE uam_roles.role_name='IS Coordinator' AND users.active_flag=0");
            $attachment = DB::select("SELECT b.enrollment_id , b.user_id as parentID FROM ovm_meeting_2_details AS a
            INNER JOIN enrollment_details AS b ON a.enrollment_id=b.enrollment_child_num
            WHERE a.ovm_meeting_id = $id");
            $users = DB::select("SELECT * FROM users WHERE array_roles != 3");
            $response = [
                'rows' => $rows,
                'iscoordinators' => $iscoordinators,
                'attachment' => $attachment[0]->enrollment_id,
                'parentID' => $attachment[0]->parentID,
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

        try {
            // $this->WriteFileLog($request);
            $userID =  auth()->user()->id;
            $method = 'Method =>  ovm2Controller => updatedata';
            // $this->WriteFileLog($method);
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

            // $startTime = $inputArray['meeting_startdate'] . 'T' . $inputArray['meeting_starttime'] . ':00';
            // $endTime = $inputArray['meeting_enddate'] . 'T' . $inputArray['meeting_endtime'] . ':00';
            // Date - DD/MM/YYYY
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
                'attachment' => $inputArray['attachment'],
                'notes' => $inputArray['notes'],
                'mail_cc' => $inputArray['mail_cc'],
                'url' => $inputArray['url'],
            ];
            // $this->WriteFileLog('1');
            $type = $input['type'];
            $meeting_status = $input['meeting_status'];

            // if ($request->meeting_status === "Completed") {
            //     $input = [
            //     'ovmattachpath' => $inputArray['ovmattachpath'],
            //     'ovmattachname' => $inputArray['ovmattachname'],
            //     'storagepathshort' => $inputArray['storagepathshort'],
            //     ];
            // }
            // $this->WriteFileLog($input);
            if ($type == "Sent") {
                DB::table('ovm_meeting_2_details')
                    ->where('ovm_meeting_id', $input['id'])
                    ->update([
                        'created_by' => auth()->user()->id,

                    ]);
                // $this->WriteFileLog('sent');
                $admin_details = DB::SELECT("SELECT * from users where array_roles = '4' or array_roles = '5'");
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

                // $this->WriteFileLog('2');

                //  $this->WriteFileLog("df");


                $client = $googl->client();
                $service = new \Google_Service_Calendar($client);
                // $this->WriteFileLog(json_decode(json_encode($service), true));
                // $this->WriteFileLog("ere");
                // $this->WriteFileLog($inputArray);
                // $this->WriteFileLog($startTime);
                // $this->WriteFileLog($endTime);

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
                    $admin_details = DB::SELECT("SELECT * FROM ovm_meeting_2_details WHERE ovm_meeting_id=$rrrr ");
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
                    //   $summaryAdmin = "You Have beed invited to attend the OVM-1 Meeting for " . $inputArray['child_name'];
                    //   $event1 = new \Google_Service_Calendar_Event(array(
                    //       'summary' => $inputArray['meeting_subject'],
                    //       'location' => $inputArray['meeting_location'],
                    //       'description' => $summaryAdmin,
                    //       'start' => array('dateTime' => $startTime, 'timeZone' => 'Asia/Kolkata',),
                    //       'end' => array('dateTime' => $endTime, 'timeZone' => 'Asia/Kolkata',),
                    //       'attendees' => array_merge($attendees1, $a),
                    //       'reminders' => array('useDefault' => FALSE, 'overrides' => array(array('method' => 'email', 'minutes' => 24 * 60), array('method' => 'popup', 'minutes' => 10),),),
                    //       "conferenceData" => array("createRequest" => array("conferenceSolutionKey" => array("type" => "hangoutsMeet"), "requestId" => "123"))
                    //   ));
                    //   $opts = array('sendNotifications' => true, 'conferenceDataVersion' => 1);
                    //   $AddEvent = $service->events->patch('primary', $eventId, $event1, $opts);
                    // 
                    DB::table('ovm_meeting_2_details')
                        ->where('ovm_meeting_id', $input['id'])
                        ->update([
                            'event_id' => $eventId,
                            'event_link' => $eventLink,
                        ]);

                    $emailTo = $inputArray['meeting_to'];
                    $doc = $inputArray['attachment'];
                    if ($doc != '') {
                        $data = array(
                            'child_name' => $inputArray['child_name'],
                            'imagename' => $inputArray['attachment'],
                        );
                        Mail::to($emailTo)->send(new senddemomail($data));
                    }
                }
                // $this->WriteFileLog('3');


            }
            if ($type == "Reschedule Request") {
                // $this->WriteFileLog('Reschedule');

                // $rrrr = $input['id'];
                // $admin_details = DB::SELECT("SELECT * FROM ovm_meeting_details WHERE ovm_meeting_id=$rrrr ");
                // DB::table('notifications')->insertGetId([
                //     'user_id' =>  $admin_details[0]->created_by,
                //     'notification_type' => 'OVM Meeting Scheduled',
                //     'notification_status' => 'OVM Meeting',
                //     'notification_url' => 'ovm2/' . encrypt($input['id']),
                //     'megcontent' => "OVM-2 Meeting for " . $input['child_name'] . "(" . $input['enrollment_child_num'] . ") has been Requested for Rescheduled by " . auth()->user()->name,
                //     'alert_meg' => "OVM-2 Meeting for " . $input['child_name'] . "(" . $input['enrollment_child_num'] . ") has been Requested for Rescheduled by " . auth()->user()->name,
                //     'created_by' => auth()->user()->id,
                //     'created_at' => NOW()
                // ]);

                $admin_details = DB::SELECT("SELECT * from users where array_roles = '4'");
                $adminn_count = count($admin_details);
                if ($admin_details != []) {
                    for ($j = 0; $j < $adminn_count; $j++) {

                        DB::table('notifications')->insertGetId([
                            'user_id' =>  $admin_details[$j]->id,
                            'notification_type' => 'OVM Meeting Scheduled',
                            'notification_status' => 'OVM Meeting',
                            'notification_url' => 'ovmsent2/' . encrypt($input['id']),
                            'megcontent' => "OVM-2 Meeting for child-" . $input['child_name'] . "(" . $input['enrollment_child_num'] . ") has Requested for Rescheduled by " . auth()->user()->name,
                            'alert_meg' => "OVM-2 Meeting for child-" . $input['child_name'] . "(" . $input['enrollment_child_num'] . ") has Requested for Rescheduled by " . auth()->user()->name,
                            'created_by' => auth()->user()->id,
                            'created_at' => NOW()
                        ]);
                    }
                }
            }
            DB::transaction(function () use ($input, $is_coordinator1, $is_coordinator2) {

                $c = DB::select("select * from ovm_meeting_2_details where ovm_meeting_id=" . $input['id']);
                $cre = $c[0]->created_by;
                $au = auth()->user()->id;
                $mid = $input['id'];
                $status =  $input['meeting_status'];
                if ($status != 'Accepted' || $status != 'Completed') {
                    if ($au == $cre) {
                        $meSt = $input['meeting_status'];
                        $this->ovm_status_logs('ovm_meeting_2_details', $input['id'], 'OVM Meeting ' . $input['meeting_status'], 'OVM Status', auth()->user()->id, NOW(), $input['enrollment_child_num'], auth()->user()->name);
                        DB::table('ovm_attendees')
                            ->where('ovm_id', $input['id'])
                            ->update([
                                'overall_status' => $input['meeting_status']
                            ]);
                    } else {
                        $meSt = $c[0]->meeting_status;
                        DB::select("Delete FROM ovm_attendees WHERE ovm_id = $mid AND created_by = $au");
                        DB::table('ovm_attendees')->insertGetId([
                            'ovm_type' =>  '2',
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
                        $this->ovm_status_logs('ovm_meeting_2_details', $input['id'], 'OVM Meeting ' . $osl, 'OVM Status', auth()->user()->id, NOW(), $input['enrollment_child_num'], auth()->user()->name);
                    }
                } else {
                    $meSt = $input['meeting_status'];
                    $this->ovm_status_logs('ovm_meeting_2_details', $input['id'], 'OVM Meeting ' . $input['meeting_status'], 'OVM Status', auth()->user()->id, NOW(), $input['enrollment_child_num'], auth()->user()->name);
                }
                if ($status == 'Completed') {
                    $meSt = $input['meeting_status'];
                }
                DB::table('ovm_meeting_2_details')
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
                        'attachment' => $input['attachment'],
                        'mail_cc' => ($input['mail_cc'] != '') ? implode(",", $input['mail_cc']) : null,
                        // 'created_by' => auth()->user()->id,
                        'created_date' => NOW()

                    ]);
                // $this->WriteFileLog('4');

                $this->auditLog('ovm_meeting_2_details', $input['id'], 'Update', 'OVM Meeting', auth()->user()->id, NOW(), 'Rescheduled');
                if ($input['meeting_status'] === "Sent" || $input['meeting_status'] === "Rescheduled") {
                    $admin_details = DB::SELECT("SELECT * from users where array_roles = '4' or array_roles = '5' ");
                    $adminn_count = count($admin_details);
                    if ($admin_details != []) {
                        for ($j = 0; $j < $adminn_count; $j++) {

                            // $notifications = DB::table('notifications')->insertGetId([
                            //     'user_id' =>  $admin_details[$j]->id,

                            //     'notification_type' => 'OVM Meeting Scheduled',
                            //     'notification_status' => 'OVM Meeting',  
                            //     'notification_url' => 'ovm2/'. encrypt($input['id']),    
                            //     'megcontent' => "User ".$input['child_name']." OVM Meeting has been Scheduled Successfully and mail sent.",
                            //     'alert_meg' => "User ".$input['child_name']." OVM Meeting has been Scheduled Successfully and mail sent.", 
                            //     'created_by' => auth()->user()->id,
                            //     'created_at' => NOW()
                            // ]);


                        }
                    }
                    // $this->WriteFileLog('5');

                    if ($input['meeting_status'] === "Sent") {

                        DB::table('notifications')->insertGetId([
                            'user_id' =>  $is_coordinator1[0]->id,
                            'notification_type' => 'OVM Meeting Scheduled',
                            'notification_status' => 'OVM Meeting',
                            'notification_url' => 'ovmsent2/' . encrypt($input['id']),
                            'megcontent' => "OVM-2 Invite Sent for you to attend for child-" . $input['child_name'] . " (" . $input['enrollment_child_num'] . ")",
                            'alert_meg' => "OVM-2 Invite Sent for you to attend for child-" . $input['child_name'] . " (" . $input['enrollment_child_num'] . ")",
                            'created_by' => auth()->user()->id,
                            'created_at' => NOW()
                        ]);
                        // $this->WriteFileLog($is_coordinator2);
                        if ($is_coordinator2 != '') {
                            DB::table('notifications')->insertGetId([
                                'user_id' =>  $is_coordinator2[0]->id,
                                'notification_type' => 'OVM Meeting Scheduled',
                                'notification_status' => 'OVM Meeting',
                                'notification_url' => 'ovmsent2/' . encrypt($input['id']),
                                'megcontent' => "OVM-2 Invite Sent for you to attend for child-" . $input['child_name'] . " (" . $input['enrollment_child_num'] . ")",
                                'alert_meg' => "OVM-2 Invite Sent for you to attend for child-" . $input['child_name'] . " (" . $input['enrollment_child_num'] . ")",
                                'created_by' => auth()->user()->id,
                                'created_at' => NOW()
                            ]);
                        }
                        // $this->WriteFileLog('6');
                        $en = $input['enrollment_id']; //$this->WriteFileLog($en);
                        $ee = DB::select("SELECT * FROM enrollment_details WHERE enrollment_child_num = '$en'"); //$this->WriteFileLog($ee);
                        DB::table('notifications')->insertGetId([
                            'user_id' => $ee[0]->user_id,
                            'notification_type' => 'OVM Meeting Scheduled',
                            'notification_status' => 'OVM Meeting',
                            'notification_url' => 'ovm2/' . encrypt($input['id']),
                            'megcontent' => "OVM-2 Meeting for child-" . $input['child_name'] . " (" . $input['enrollment_child_num'] . " ) has been Scheduled",
                            'alert_meg' => "OVM-2 Meeting for child-" . $input['child_name'] . " (" . $input['enrollment_child_num'] . " ) has been Scheduled",
                            'created_by' => auth()->user()->id,
                            'created_at' => NOW()
                        ]);
                    }

                    if ($input['meeting_status'] === "Rescheduled") {

                        DB::table('notifications')->insertGetId([
                            'user_id' =>  $is_coordinator1[0]->id,
                            'notification_type' => 'OVM Meeting Scheduled',
                            'notification_status' => 'OVM Meeting',
                            'notification_url' => 'ovmsent2/' . encrypt($input['id']),
                            'megcontent' => "OVM-2 Meeting has been Rescheduled for child-" . $input['child_name'] . " (" . $input['enrollment_child_num'] . ")",
                            'alert_meg' => "OVM-2 Meeting has been Rescheduled for child-" . $input['child_name'] . " (" . $input['enrollment_child_num'] . ")",
                            'created_by' => auth()->user()->id,
                            'created_at' => NOW()
                        ]);
                        // $this->WriteFileLog('7');
                        if ($is_coordinator2 != '') {
                            DB::table('notifications')->insertGetId([
                                'user_id' =>  $is_coordinator2[0]->id,
                                'notification_type' => 'OVM Meeting Scheduled',
                                'notification_status' => 'OVM Meeting',
                                'notification_url' => 'ovmsent2/' . encrypt($input['id']),
                                'megcontent' => "OVM-2 Meeting has been Rescheduled for child-" . $input['child_name'] . " (" . $input['enrollment_child_num'] . ")",
                                'alert_meg' => "OVM-2 Meeting has been Rescheduled for child-" . $input['child_name'] . " (" . $input['enrollment_child_num'] . ")",
                                'created_by' => auth()->user()->id,
                                'created_at' => NOW()
                            ]);
                        }

                        $en = $input['enrollment_id'];
                        $ee = DB::select("SELECT * FROM enrollment_details WHERE enrollment_child_num = '$en'");

                        DB::table('notifications')->insertGetId([
                            'user_id' => $ee[0]->user_id,
                            'notification_type' => 'OVM Meeting Scheduled',
                            'notification_status' => 'OVM Meeting',
                            'notification_url' => 'ovm2/' . encrypt($input['id']),
                            'megcontent' => "OVM-2 Meeting for child-" . $input['child_name'] . " (" . $input['enrollment_child_num'] . " ) has been Rescheduled",
                            'alert_meg' => "OVM-2 Meeting for child-" . $input['child_name'] . " (" . $input['enrollment_child_num'] . " ) has been Rescheduled",
                            'created_by' => auth()->user()->id,
                            'created_at' => NOW()
                        ]);
                    }
                }
            });

            if ($status == 'Completed') {
                DB::table('notifications')->insertGetId([
                    'user_id' =>  $is_coordinator1[0]->id,
                    'notification_type' => 'OVM Meeting Scheduled',
                    'notification_status' => 'OVM Meeting',
                    'notification_url' => 'ovm2/' . encrypt($input['id']),
                    'megcontent' => "OVM-2 Meeting has been " . $status . " for child-" . $input['child_name'] . " (" . $input['enrollment_child_num'] . ")",
                    'alert_meg' => "OVM-2 Meeting has been " . $status . " for child- " . $input['child_name'] . " (" . $input['enrollment_child_num'] . ")",
                    'created_by' => auth()->user()->id,
                    'created_at' => NOW()
                ]);
                if ($is_coordinator2 != '') {
                    DB::table('notifications')->insertGetId([
                        'user_id' =>  $is_coordinator2[0]->id,
                        'notification_type' => 'OVM Meeting Scheduled',
                        'notification_status' => 'OVM Meeting',
                        'notification_url' => 'ovm2/' . encrypt($input['id']),
                        'megcontent' => "OVM-2 Meeting has been " . $status . " for child- " . $input['child_name'] . " (" . $input['enrollment_child_num'] . ")",
                        'alert_meg' => "OVM-2 Meeting has been " . $status . " for child- " . $input['child_name'] . " (" . $input['enrollment_child_num'] . ")",
                        'created_by' => auth()->user()->id,
                        'created_at' => NOW()
                    ]);
                }

                $admin_details = DB::SELECT("SELECT * from users where array_roles = '4'");
                $adminn_count = count($admin_details);
                if ($admin_details != []) {
                    for ($j = 0; $j < $adminn_count; $j++) {

                        DB::table('notifications')->insertGetId([
                            'user_id' =>  $admin_details[$j]->id,
                            'notification_type' => 'OVM Meeting Scheduled',
                            'notification_status' => 'OVM Meeting',
                            'notification_url' => 'ovm2/' . encrypt($input['id']),
                            'megcontent' => "OVM-2 Meeting for child-" . $input['child_name'] . " (" . $input['enrollment_child_num'] . " ) has been completed",
                            'alert_meg' => "OVM-2 Meeting for child-" . $input['child_name'] . " (" . $input['enrollment_child_num'] . " ) has been completed",
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
                    'notification_url' => 'ovm2/' . encrypt($input['id']),
                    'megcontent' => "OVM-2 Meeting for child-" . $input['child_name'] . " (" . $input['enrollment_child_num'] . " ) has been completed",
                    'alert_meg' => "OVM-2 Meeting for child-" . $input['child_name'] . " (" . $input['enrollment_child_num'] . " ) has been completed",
                    'created_by' => auth()->user()->id,
                    'created_at' => NOW()
                ]);

                // OVMCompleteMail
                $data = array(
                    'child_name' => $ee[0]->child_name,
                    'child_contact_email' => $ee[0]->child_contact_email,
                    'meeting_date' => $input['meeting_startdate'],
                    'url' => $inputArray['url'],
                    'userID' => encrypt($ee[0]->user_id),
                );
                $cce = $ee[0]->child_contact_email;
                Mail::to($cce)->send(new SailEmailAccept($data));
                // Mail::to($ee[0]->child_contact_email)->send(new OVMCompleteMail($data));
            }

            if ($status == 'Accepted' || $status == 'Declined' || $status == 'Hold') {

                DB::transaction(function () use ($input, $status, $is_coordinator1, $is_coordinator2) {
                    $c = DB::select("select * from ovm_meeting_2_details where ovm_meeting_id=" . $input['id']);
                    $cre = $c[0]->created_by;
                    $au = auth()->user()->id;
                    if ($cre == $au) {
                        $megcontent = "OVM-2 Meeting for child-" . $input['child_name'] . " (" . $input['enrollment_id'] . ") " . " has been " . $status . " by " . auth()->user()->name;
                    } else {
                        $megcontent = "OVM-2 Meeting for child-" . $input['child_name'] . " (" . $input['enrollment_id'] . ") " . " has been requested for " . $status . " by " . auth()->user()->name;
                    }
                    if ($status == 'Accepted') {
                        $megcontent = "OVM-2 Meeting for child-" . $input['child_name'] . " (" . $input['enrollment_id'] . ") " . " has been " . $status . " by " . auth()->user()->name;
                    }
                    DB::table('notifications')->insertGetId([
                        'user_id' => $is_coordinator1[0]->id,
                        'notification_type' => 'OVM Meeting Scheduled',
                        'notification_status' => 'OVM Meeting',
                        'notification_url' => 'ovm2/' . encrypt($input['id']),
                        'megcontent' => $megcontent,
                        'alert_meg' => $megcontent,
                        'created_by' => auth()->user()->id,
                        'created_at' => NOW()
                    ]);

                    if ($is_coordinator2 != '') {
                        DB::table('notifications')->insertGetId([
                            'user_id' => $is_coordinator2[0]->id,
                            'notification_type' => 'OVM Meeting Scheduled',
                            'notification_status' => 'OVM Meeting',
                            'notification_url' => 'ovm2/' . encrypt($input['id']),
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
                                'notification_url' => 'ovm2/' . encrypt($input['id']),
                                'megcontent' => $megcontent,
                                'alert_meg' => $megcontent,
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
                                'notification_url' => 'ovm2/' . encrypt($input['id']),
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


            $method = 'Method =>ovm2Controller => data_delete';
            // $this->WriteFileLog($method);
            $id = $this->decryptData($id);
            // $this->WriteFileLog($id);



            $check = DB::select("select * from ovm_meeting_2_details where enrollment_id = '$id' and active_flag = '0' ");
            // $this->WriteFileLog($check);
            if ($check !== []) {

                // $this->WriteFileLog($check);
                DB::table('ovm_meeting_details')
                    ->where('enrollment_id', $id)
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
    public function updateGoogleEvent (Googl $googl){
        $detail = DB::select("SELECT b.user_id as parentId , a.* , JSON_EXTRACT(a.is_coordinator1, '$.id') AS isc1, JSON_EXTRACT(a.is_coordinator2, '$.id') AS isc2, CONCAT(a.created_by , ',' , JSON_EXTRACT(a.is_coordinator1, '$.id') , ',' , COALESCE(JSON_EXTRACT(a.is_coordinator2, '$.id'),'') ) AS stakeholders FROM ovm_meeting_2_details AS a
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
            $service = new \Google_Service_Calendar($googl->client());
            $event = $service->events->get('primary', $event_id);

            $eventDetails = json_decode(json_encode($event), true);
            $attendees = $eventDetails['attendees'];

            foreach ($attendees as $attendee) {
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
                        $check = DB::select("Select * FROM ovm_attendees WHERE ovm_id = $ovm_meeting_id AND ovm_type = '2' AND created_by = $userID");
                        if ($check != []) {
                            $currentStatus = $check[0]->status;
                        } else {
                            $currentStatus = '';
                        }
                        if ($currentStatus != $responseStatus) {
                            DB::select("Delete FROM ovm_attendees WHERE ovm_id = $ovm_meeting_id AND ovm_type = '2' and created_by = $userID");
                            DB::table('ovm_attendees')->insertGetId([
                                'ovm_type' =>  '2',
                                'ovm_id' => $ovm_meeting_id,
                                'notes' => $attendee['comment'],
                                'attendee' => $userID,
                                'status' => $responseStatus,
                                'overall_status' => $meeting_status,
                                'created_by' => $userID,
                                'created_at' => NOW()
                            ]);
                            DB::table('ovm_status_logs')->insert([
                                'audit_table_name' => 'ovm_meeting_2_details',
                                'audit_table_id' => $ovm_meeting_id,
                                'audit_action' => 'OVM Meeting ' . $responseStatus,
                                'description' => $responseStatus,
                                'user_id' => $userID,
                                'action_date_time' => now(),
                                'enrollment_id' => $enrollment_id,
                                'role_name' => $name
                            ]);
                            $msgcontent = "OVM-2 Meeting for " . $child_name . " (" . $enrollment_id . " ) has been " . $responseStatus . " by " . $name;
                            if ($parentId == $userID) {
                                DB::table('ovm_meeting_2_details')
                                    ->where('ovm_meeting_id', $ovm_meeting_id)
                                    ->update([
                                        'meeting_status' => $responseStatus,
                                        'created_date' => NOW()
                                    ]);
                                $msgcontent = "OVM-2 Meeting for " . $child_name . " (" . $enrollment_id . " ) has been " . $responseStatus . " by Parent ";
                            }
                            foreach ($inarr as $val) {
                                // Log::error($val);
                                DB::table('notifications')->insertGetId([
                                    'user_id' => $val,
                                    'notification_type' => 'OVM Meeting Scheduled',
                                    'notification_status' => 'OVM Meeting',
                                    'notification_url' => 'ovmsent2/' . encrypt($ovm_meeting_id),
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
