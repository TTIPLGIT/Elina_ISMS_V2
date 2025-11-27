<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Mail\OVMAllocationMail;
use App\Mail\OVMAllocationMail_IS;
use App\Mail\OVMAllocationMailUpdate;
use App\Mail\OVMDeclinedMailUpdate;
use App\Mail\OVMDeclinedMail_IS;
use App\Mail\OVMAcceptedMailUpdate;
use App\Mail\OVMAcceptedMail_IS;
use App\Mail\OVMClosureMail_IS;
use App\Mail\OVMClosureMailUpdate;
use App\Mail\OVMRescheduleMail_IS;



class OVMAllocationController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $method = 'Method => OVMAllocationController => index';
            $authID = auth()->user()->id;
            // $this->WriteFileLog($authID);
            $role_name = DB::select("SELECT role_name FROM uam_roles AS ur INNER JOIN users us ON (us.array_roles=ur.role_id) WHERE us.id=$authID");
            $role_name_fetch = $role_name[0]->role_name;
            $rolesArray = array_merge(array(auth()->user()->array_roles) , array(auth()->user()->roles));
            if(in_array(4,$rolesArray))
            {
                $rows = DB::select("SELECT * FROM ovm_allocation where  meeting_startdate !='' ORDER BY id DESC ");

            }
            else {
                $rows = DB::select("SELECT * FROM ovm_allocation WHERE (is_coordinator1 = $authID OR is_coordinator2 = $authID) and meeting_startdate !='' ORDER BY id DESC ");
                //$this->WriteFileLog($rows); 
            } 
            // $this->WriteFileLog($rows);
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

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }
    public function meetinginvite(Request $request)
    {
        try {
            $method = 'Method => OVMAllocationController => meetinginvite';
            $rows = array();

            $authID = auth()->user()->id;

            $role_name = DB::select("SELECT role_name FROM uam_roles AS ur INNER JOIN users us ON (us.array_roles=ur.role_id) WHERE us.id=$authID");
            $role_name_fetch = $role_name[0]->role_name;
            $rolesArray = array_merge(array(auth()->user()->array_roles) , array(auth()->user()->roles));

            if (in_array(4,$rolesArray)) {
                $rows['enrollment_details'] = DB::select("SELECT o.*, e.enrollment_child_num, u1.name AS is_coordinator1_name, u2.name AS is_coordinator2_name 
            FROM ovm_allocation AS o INNER JOIN enrollment_details AS e ON o.enrollment_id = e.enrollment_id INNER JOIN users AS u1 ON u1.id = o.is_coordinator1 INNER JOIN users AS u2 ON u2.id = o.is_coordinator2 WHERE o.meeting_startdate='' ORDER BY o.id DESC");

                $rows['iscoordinators'] = DB::select("SELECT * from users
                right JOIN uam_user_roles ON uam_user_roles.user_id=users.id
                right JOIN uam_roles on uam_roles.role_id = uam_user_roles.role_id
                WHERE uam_roles.role_name='IS Coordinator' AND users.active_flag=0");
                // $this->WriteFileLog($rows);
                $email = DB::select("SELECT * FROM email_preview WHERE screen = 'OVM Initiate' AND active_flag = 0");
                $email_allocation = DB::select("SELECT * FROM email_preview WHERE screen = 'OVM Allocation' AND active_flag = 0");
                $users = DB::select("SELECT * FROM users WHERE array_roles != 3");

                $response = [
                    'rows' => $rows,
                    'email' => $email,
                    'users' => $users,
                    'email_allocation' => $email_allocation
                ];
            } else {
                $rows['enrollment_details'] = DB::select("Select a.enrollment_child_num , a.enrollment_id,a.child_name from enrollment_details as a
                right join payment_status_details on payment_status_details.enrollment_child_num = a.enrollment_child_num
                left join ovm_meeting_details on ovm_meeting_details.enrollment_id = a.enrollment_child_num
                where payment_status_details.payment_status = 'SUCCESS' 
                AND ovm_meeting_details.enrollment_id  IS null 
                AND a.enrollment_id NOT IN (SELECT oa.enrollment_id FROM ovm_allocation AS oa) ORDER BY a.enrollment_id DESC");

                $rows['iscoordinators'] = DB::select("SELECT * from users
                    right JOIN uam_user_roles ON uam_user_roles.user_id=users.id
                    right JOIN uam_roles on uam_roles.role_id = uam_user_roles.role_id
                    WHERE uam_roles.role_name='IS Coordinator' AND users.active_flag=0");
                // $this->WriteFileLog($rows);
                $email = DB::select("SELECT * FROM email_preview WHERE screen = 'OVM Initiate' AND active_flag = 0");
                $email_allocation = DB::select("SELECT * FROM email_preview WHERE screen = 'OVM Allocation' AND active_flag = 0");
                $users = DB::select("SELECT * FROM users WHERE array_roles != 3");
                
                // $id = $input['id'];
                // $allocation_details = DB::select("SELECT o.*,e.user_id from ovm_allocation as o inner join enrollment_details AS e ON o.enrollment_id=e.enrollment_id WHERE o.id =$id");
                $response = [
                    'rows' => $rows,
                    'email' => $email,
                    'users' => $users,
                    'email_allocation' => $email_allocation,
                    'allocation_details' => []
                ];
            }
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
    public function store(Request $request)
    {
        try {
            $method = 'Method => OVMAllocationController => store';
            $inputArray = $this->decryptData($request->requestData);
            // $this->WriteFileLog($inputArray);
            $input = [
                'enrollment_child_num' => $inputArray['enrollment_child_num'],
                'enrollment_id' => $inputArray['enrollment_id'],
                'child_id' => $inputArray['child_id'],
                'child_name' => $inputArray['child_name'],
                'is_coordinator1' => $inputArray['is_coordinator1'],
                'is_coordinator2' => $inputArray['is_coordinator2'],
                'is_coordinator1id' => $inputArray['is_coordinator1id'],
                'is_coordinator2id' => $inputArray['is_coordinator2id'],
                'meeting_startdate' => $inputArray['meeting_startdate'],
                'meeting_enddate' => $inputArray['meeting_enddate'],
                'meeting_starttime' => $inputArray['meeting_starttime'],
                'meeting_endtime' => $inputArray['meeting_endtime'],
                'meeting_location' => $inputArray['meeting_location'],

                'meeting_startdate2' => $inputArray['meeting_startdate2'],
                'meeting_enddate2' => $inputArray['meeting_enddate2'],
                'meeting_starttime2' => $inputArray['meeting_starttime2'],
                'meeting_endtime2' => $inputArray['meeting_endtime2'],
                'meeting_location2' => $inputArray['meeting_location2'],
                'url' => $inputArray['url'],
                'meeting_description' => $inputArray['meeting_description'],

                'meeting_status' => $inputArray['meeting_status'],
            ];
            // $this->WriteFileLog($input);
            DB::transaction(function () use ($input) {
                $ovm_meeting = DB::table('ovm_allocation')
                    ->where('enrollment_id', $input['enrollment_id'])
                    ->update([
                        'meeting_startdate' => $input['meeting_startdate'],
                        'meeting_enddate' => $input['meeting_enddate'],
                        'meeting_starttime' => $input['meeting_starttime'],
                        'meeting_endtime' => $input['meeting_endtime'],
                        'meeting_location' => $input['meeting_location'],
                        'meeting_startdate2' => $input['meeting_startdate2'],
                        'meeting_enddate2' => $input['meeting_enddate2'],
                        'meeting_starttime2' => $input['meeting_starttime2'],
                        'meeting_endtime2' => $input['meeting_endtime2'],
                        'meeting_location2' => $input['meeting_location2'],
                        'meeting_status' => $input['meeting_status'],
                        'meeting_description' => $input['meeting_description']

                    ]);
                // $this->WriteFileLog($ovm_meeting);
                $updatedMeeting = DB::table('ovm_allocation')
                    ->where('enrollment_id', $input['enrollment_id'])
                    ->first();
                $ovm_meeting = $updatedMeeting->id;
                // $this->WriteFileLog($ovm_meeting);
                $meeting_status = $input['meeting_status'];
                if ($meeting_status == 'Sent') {
                    // $this->WriteFileLog("asde");
                    $this->auditLog('ovm_meeting_details', $ovm_meeting, 'OVM', 'create new ovm meeting details', auth()->user()->id, NOW(), ' $role_name_fetch');
                    // $this->WriteFileLog($ovm_meeting);
                    $enrollment_id = $input['enrollment_id'];
                    $enrollment = DB::select("SELECT * FROM enrollment_details WHERE enrollment_id = '$enrollment_id'");
                    DB::table('notifications')->insertGetId([
                        'user_id' => $enrollment[0]->user_id,
                        'notification_type' => 'OVM Meeting Scheduled',
                        'notification_status' => 'OVM Meeting',
                        'notification_url' => 'ovm_allocation/accept/' . encrypt($ovm_meeting),
                        'megcontent' => "OVM Meeting has been Scheduled for child-" . $input['child_name'] . " (" . $input['enrollment_child_num'] . "). Click here to confirm the Availabity",
                        'alert_meg' => "OVM Meeting has been Scheduled for child-" . $input['child_name'] . " (" . $input['enrollment_child_num'] . "). Click here to confirm the Availabity",
                        'created_by' => auth()->user()->id,
                        'created_at' => NOW()
                    ]);
                    // $this->WriteFileLog("asde1");
                    $data = [
                        'url' => $input['url'],
                        'meeting_description' => $input['meeting_description'],
                        'mailSubject' => 'Overview Meeting Schedule and Confirmation',
                        'child_name' => $input['child_name'],

                        'meeting_startdate' => $input['meeting_startdate'],
                        'meeting_startdate2' => $input['meeting_startdate2'],
                        'meeting_starttime' => date('h:i a', strtotime($input['meeting_starttime'])),
                        'meeting_endtime' => date('h:i a', strtotime($input['meeting_endtime'])),
                        'meeting_starttime2' => date('h:i a', strtotime($input['meeting_starttime2'])),
                        'meeting_endtime2' => date('h:i a', strtotime($input['meeting_endtime2'])),

                    ];

                    Mail::to($enrollment[0]->child_contact_email)->send(new OVMAllocationMail($data));

                    $isco1 = DB::select("Select * from users where id=" . $input['is_coordinator1id']);
                    DB::table('notifications')->insertGetId([
                        'user_id' => $input['is_coordinator1id'],
                        'notification_type' => 'OVM Meeting Scheduled',
                        'notification_status' => 'OVM Meeting',
                        'notification_url' => 'ovm_allocation/' . encrypt($ovm_meeting) . '/edit',
                        'megcontent' => "OVM Meeting has been Scheduled for child-" . $enrollment[0]->child_name . " (" . $enrollment[0]->enrollment_child_num . ")",
                        'alert_meg' => "OVM Meeting has been Scheduled for child-" . $enrollment[0]->child_name . " (" . $enrollment[0]->enrollment_child_num . ")",
                        'created_by' => auth()->user()->id,
                        'created_at' => NOW()
                    ]);
                    //$bccRecipients = ['aadhi5669@gmail.com', 'aathish.mani@talentakeaways.com'];
                    Mail::to($isco1[0]->email)->send(new OVMAllocationMail_IS($data));
                    $is2 = $input['is_coordinator2id'];
                    if ($is2 != 'Select-IS-Coordinator-2') {
                        DB::table('notifications')->insertGetId([
                            'user_id' => $input['is_coordinator2id'],
                            'notification_type' => 'OVM Meeting Scheduled',
                            'notification_status' => 'OVM Meeting',
                            'notification_url' => 'ovm_allocation/' . encrypt($ovm_meeting) . '/edit',
                            'megcontent' => "OVM Meeting has been Scheduled for child-" . $enrollment[0]->child_name . " (" . $enrollment[0]->enrollment_child_num . ")",
                            'alert_meg' => "OVM Meeting has been Scheduled for child-" . $enrollment[0]->child_name . " (" . $enrollment[0]->enrollment_child_num . ")",
                            'created_by' => auth()->user()->id,
                            'created_at' => NOW()
                        ]);
                        $isco2 = DB::select("Select * from users where id=" . $input['is_coordinator2id']);
                        Mail::to($isco2[0]->email)->send(new OVMAllocationMail_IS($data));
                    }
                }
            });

            // $this->WriteFileLog("coo2");
            // DB::transaction(function () use ($input) {

            //     $ovm_meeting = DB::table('ovm_allocation')
            //         ->insertGetId([
            //             'enrollment_id' => $input['enrollment_id'],
            //             'child_id' => $input['child_id'],
            //             'is_coordinator1' => $input['is_coordinator1id'],
            //             'is_coordinator2' => $input['is_coordinator2id'],
            //             'child_name' => $input['child_name'],
            //             'meeting_startdate' => $input['meeting_startdate'],
            //             'meeting_enddate' => $input['meeting_enddate'],
            //             'meeting_starttime' => $input['meeting_starttime'],
            //             'meeting_endtime' => $input['meeting_endtime'],
            //             'meeting_location' => $input['meeting_location'],

            //             'meeting_startdate2' => $input['meeting_startdate2'],
            //             'meeting_enddate2' => $input['meeting_enddate2'],
            //             'meeting_starttime2' => $input['meeting_starttime2'],
            //             'meeting_endtime2' => $input['meeting_endtime2'],
            //             'meeting_location2' => $input['meeting_location2'],

            //             'meeting_status' => $input['meeting_status'],

            //             'created_by' => auth()->user()->id,
            //             'created_date' => now(),
            //         ]);

            //     $meeting_status = $input['meeting_status'];
            //     if ($meeting_status == 'Sent') {
            //         $this->auditLog('ovm_meeting_details', $ovm_meeting, 'OVM', 'create new ovm meeting details', auth()->user()->id, NOW(), ' $role_name_fetch');

            //         $enrollment_id = $input['enrollment_id'];
            //         $enrollment = DB::select("SELECT * FROM enrollment_details WHERE enrollment_id = '$enrollment_id'");
            //         DB::table('notifications')->insertGetId([
            //             'user_id' => $enrollment[0]->user_id,
            //             'notification_type' => 'OVM Meeting Scheduled',
            //             'notification_status' => 'OVM Meeting',
            //             'notification_url' => 'ovm_allocation/accept/' . encrypt($ovm_meeting),
            //             'megcontent' => "OVM Meeting has been Allocated for " . $input['child_name'] . " (" . $input['enrollment_child_num'] . "). Click here to confirm the Availabity",
            //             'alert_meg' => "OVM Meeting has been Allocated for " . $input['child_name'] . " (" . $input['enrollment_child_num'] . "). Click here to confirm the Availabity",
            //             'created_by' => auth()->user()->id,
            //             'created_at' => NOW()
            //         ]);
            //         $data = [
            //             'url' => $input['url'],
            //             'meeting_description' => $input['meeting_description'],
            //             'mailSubject' => 'Overview Meeting Schedule and Confirmation',
            //             'child_name' => $input['child_name'],

            //             'meeting_startdate' => $input['meeting_startdate'],
            //             'meeting_startdate2' => $input['meeting_startdate2'],
            //             'meeting_starttime' => date('h:i a', strtotime($input['meeting_starttime'])),
            //             'meeting_endtime' => date('h:i a', strtotime($input['meeting_endtime'])),
            //             'meeting_starttime2' => date('h:i a', strtotime($input['meeting_starttime2'])),
            //             'meeting_endtime2' => date('h:i a', strtotime($input['meeting_endtime2'])),

            //         ];

            //         Mail::to($enrollment[0]->child_contact_email)->send(new OVMAllocationMail($data));

            //         $isco1 = DB::select("Select * from users where id=".$input['is_coordinator1id']);
            //         DB::table('notifications')->insertGetId([
            //             'user_id' => $input['is_coordinator1id'],
            //             'notification_type' => 'OVM Meeting Scheduled',
            //             'notification_status' => 'OVM Meeting',
            //             'notification_url' => 'ovm_allocation/' . encrypt($ovm_meeting) . '/edit',
            //             'megcontent' => "OVM Meeting has been Allocated for " . $enrollment[0]->child_name . " (" . $enrollment[0]->enrollment_child_num . ")",
            //             'alert_meg' => "OVM Meeting has been Allocated for " . $enrollment[0]->child_name . " (" . $enrollment[0]->enrollment_child_num . ")",
            //             'created_by' => auth()->user()->id,
            //             'created_at' => NOW()
            //         ]);
            //         //$bccRecipients = ['aadhi5669@gmail.com', 'aathish.mani@talentakeaways.com'];
            //         Mail::to($isco1[0]->email)->send(new OVMAllocationMail_IS($data));
            //         $is2 = $input['is_coordinator2id'];
            //         if ($is2 != 'Select-IS-Coordinator-2') {
            //             DB::table('notifications')->insertGetId([
            //                 'user_id' => $input['is_coordinator2id'],
            //                 'notification_type' => 'OVM Meeting Scheduled',
            //                 'notification_status' => 'OVM Meeting',
            //                 'notification_url' => 'ovm_allocation/' . encrypt($ovm_meeting) . '/edit',
            //                 'megcontent' => "OVM Meeting has been Allocated for " . $enrollment[0]->child_name . " (" . $enrollment[0]->enrollment_child_num . ")",
            //                 'alert_meg' => "OVM Meeting has been Allocated for " . $enrollment[0]->child_name . " (" . $enrollment[0]->enrollment_child_num . ")",
            //                 'created_by' => auth()->user()->id,
            //                 'created_at' => NOW()
            //             ]);
            //             $isco2 = DB::select("Select * from users where id=".$input['is_coordinator2id']);
            //             Mail::to($isco2[0]->email)->send(new OVMAllocationMail_IS($data));
            //         }
            //     }
            // });

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

    public function getdetails($id)
    {
        try {
            $method = 'Method => OVMAllocationController => getdetails';
            // $this->WriteFileLog($method);
            $id = $this->DecryptData($id);

            $enrollment = DB::select("SELECT * FROM enrollment_details WHERE user_id = $id ");
            $enrollment_id = $enrollment[0]->enrollment_id;

            $rows = DB::select("SELECT * FROM ovm_allocation WHERE enrollment_id = $enrollment_id ");

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

    public function user_update(Request $request)
    {
        try {
            $method = 'Method => OVMAllocationController => user_update';
            $inputArray = $this->decryptData($request->requestData);

            $input = [
                'rsvp_1' => $inputArray['rsvp_1'],
                'rsvp_2' => $inputArray['rsvp_2'],
                'notes_1' => $inputArray['notes_1'],
                'notes_2' => $inputArray['notes_2'],
                'allocation_id' => $inputArray['allocation_id'],
            ];


            DB::transaction(function () use ($input) {

                DB::table('ovm_allocation')
                    ->where('id', $input['allocation_id'])
                    ->update([
                        'rsvp1' => $input['rsvp_1'],
                        'rsvp2' => $input['rsvp_2'],
                        'notes1' => $input['notes_1'],
                        'notes2' => $input['notes_2'],
                        'active_flag' => 1,
                    ]);

                $this->auditLog('ovm_allocation', $input['allocation_id'], 'OVM', 'create new ovm meeting details', auth()->user()->id, NOW(), ' $role_name_fetch');

                $details = DB::select("SELECT CONCAT (is_coordinator1 ,',', is_coordinator2 ,',', created_by) AS users , enrollment_id FROM ovm_allocation WHERE id =" . $input['allocation_id']);
                $users = $details[0]->users;
                $arr = explode(',', $users);
                $arr = array_filter($arr, function ($value) {
                    return trim($value) !== '0';
                });
                $arr = array_unique($arr);

                $enrollment = DB::select("SELECT * FROM enrollment_details WHERE enrollment_id = " . $details[0]->enrollment_id);
                // Parent/Child Kaviya has been Updated her availability status for ovm-1 & 2 Meeting.PLease tap on Notification to view the Status update by parent
                $rsvp_1 = $input['rsvp_1'];
                $rsvp_2 = $input['rsvp_2'];

                if ($rsvp_1 == 'Accept' && $rsvp_2 == 'Accept') {
                    foreach ($arr as $id) {
                        DB::table('notifications')->insertGetId([
                            'user_id' =>  $id,
                            'notification_type' => 'OVM Meeting Accepted',
                            'notification_status' => 'OVM Meeting',
                            'notification_url' => 'ovm_allocation/' . encrypt($input['allocation_id']) . '/edit',
                            'megcontent' => "OVM Meetings for child-" . $enrollment[0]->child_name . " (" . $enrollment[0]->enrollment_child_num . " ) has been Accepted",
                            'alert_meg' => "OVM Meetings for child-" . $enrollment[0]->child_name . " (" . $enrollment[0]->enrollment_child_num . " ) has been Accepted",
                            'created_by' => auth()->user()->id,
                            'created_at' => NOW()
                        ]);
                    }
                }
                if ($rsvp_1 == 'Accept' && $rsvp_2 == 'Reschedule') {
                    foreach ($arr as $id) {
                        DB::table('notifications')->insertGetId([
                            'user_id' =>  $id,
                            'notification_type' => 'OVM Meeting Reschedule',
                            'notification_status' => 'OVM Meeting',
                            'notification_url' => 'ovm_allocation/' . encrypt($input['allocation_id']) . '/edit',
                            'megcontent' => "OVM-2 for child-" . $enrollment[0]->child_name . " (" . $enrollment[0]->enrollment_child_num . " ) has been Rescheduled",
                            'alert_meg' => "OVM-2 for child-" . $enrollment[0]->child_name . " (" . $enrollment[0]->enrollment_child_num . " ) has been Rescheduled",
                            'created_by' => auth()->user()->id,
                            'created_at' => NOW()
                        ]);
                    }
                }
                if ($rsvp_1 == 'Reschedule' && $rsvp_2 == 'Reschedule') {
                    foreach ($arr as $id) {
                        DB::table('notifications')->insertGetId([
                            'user_id' =>  $id,
                            'notification_type' => 'OVM Meeting Reschedule',
                            'notification_status' => 'OVM Meeting',
                            'notification_url' => 'ovm_allocation/' . encrypt($input['allocation_id']) . '/edit',
                            'megcontent' => "OVM Meetings for child-" . $enrollment[0]->child_name . " (" . $enrollment[0]->enrollment_child_num . " ) has been Rescheduled",
                            'alert_meg' => "OVM Meetings for child-" . $enrollment[0]->child_name . " (" . $enrollment[0]->enrollment_child_num . " ) has been Rescheduled",
                            'created_by' => auth()->user()->id,
                            'created_at' => NOW()
                        ]);
                    }
                }
                if ($rsvp_1 == 'Reschedule' && $rsvp_2 == 'Accept') {
                    foreach ($arr as $id) {
                        DB::table('notifications')->insertGetId([
                            'user_id' =>  $id,
                            'notification_type' => 'OVM Meeting Reschedule',
                            'notification_status' => 'OVM Meeting',
                            'notification_url' => 'ovm_allocation/' . encrypt($input['allocation_id']) . '/edit',
                            'megcontent' => "OVM-1 for child-" . $enrollment[0]->child_name . " (" . $enrollment[0]->enrollment_child_num . " ) has been Rescheduled",
                            'alert_meg' => "OVM-1 for child-" . $enrollment[0]->child_name . " (" . $enrollment[0]->enrollment_child_num . " ) has been Rescheduled",
                            'created_by' => auth()->user()->id,
                            'created_at' => NOW()
                        ]);
                    }
                }
                // foreach ($arr as $id) {
                //     DB::table('notifications')->insertGetId([
                //         'user_id' =>  $id,
                //         'notification_type' => 'OVM Meeting Scheduled',
                //         'notification_status' => 'OVM Meeting',
                //         'notification_url' => 'ovm_allocation/' . encrypt($input['allocation_id']) . '/edit',
                //         'megcontent' => "OVM Meeting for " . $enrollment[0]->child_name . " (" . $enrollment[0]->enrollment_child_num . " ) has been Updated their availability status for OVM Meetings",
                //         'alert_meg' => "OVM Meeting for " . $enrollment[0]->child_name . " (" . $enrollment[0]->enrollment_child_num . " ) has been Updated their availability status for OVM Meetings",
                //         'created_by' => auth()->user()->id,
                //         'created_at' => NOW()
                //     ]);
                // }
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
            $method = 'Method => OVMAllocationController => data_edit';
            $id = $this->DecryptData($id);

            $rows = DB::select("SELECT a.* , b.enrollment_child_num , b.user_id FROM ovm_allocation AS a
            INNER JOIN enrollment_details AS b ON a.enrollment_id = b.enrollment_id WHERE a.id = $id ");
            $email = DB::select("SELECT * FROM email_preview WHERE screen = 'OVM Allocation' AND active_flag = 0");
            if (isset($rows[0]->meeting_description) && !empty($rows[0]->meeting_description) && $rows[0]->meeting_description !== '') {
                $email[0]->email_body = $rows[0]->meeting_description;
            } 
            $email_allocation = DB::select("SELECT * FROM email_preview WHERE screen = 'OVM Allocation Update' AND active_flag = 0");

            $iscoordinators = DB::select("SELECT * from users
            right JOIN uam_user_roles ON uam_user_roles.user_id=users.id
            right JOIN uam_roles on uam_roles.role_id = uam_user_roles.role_id
            WHERE uam_roles.role_name='IS Coordinator' AND users.active_flag=0");


            $response = [
                'rows' => $rows,
                'iscoordinators' => $iscoordinators,
                'email' => $email,
                'email_allocation' => $email_allocation,
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
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
    public function update_data(Request $request)
    {

        // $this->WriteFileLog("updation");
        try {
            $method = 'Method => OVMAllocationController => update_data';

            $inputArray = $this->decryptData($request->requestData);

            $input = [
                'is_coordinator1' => $inputArray['is_coordinator1'],
                'is_coordinator2' => $inputArray['is_coordinator2'],

                'meeting_startdate' => $inputArray['meeting_startdate'],
                'meeting_enddate' => $inputArray['meeting_enddate'],
                'meeting_starttime' => $inputArray['meeting_starttime'],
                'meeting_endtime' => $inputArray['meeting_endtime'],

                'meeting_startdate2' => $inputArray['meeting_startdate2'],
                'meeting_enddate2' => $inputArray['meeting_enddate2'],
                'meeting_starttime2' => $inputArray['meeting_starttime2'],
                'meeting_endtime2' => $inputArray['meeting_endtime2'],

                'url' => $inputArray['url'],
                'allocation_id' => $inputArray['allocation_id'],
                'user_id' => $inputArray['user_id'],
                'meeting_description' => $inputArray['meeting_description'],
                'meeting_status' => $inputArray['meeting_status'],
                'child_name' => $inputArray['child_name'],
                'status' => $inputArray['status'],
                'coord_notes' => $inputArray['coord_notes'],
                'rsvp1' => $inputArray['rsvp1'],
                'rsvp2' => $inputArray['rsvp2'],
                'reschedule_count' => $inputArray['reschedule_count'],

            ];
            // $this->WriteFileLog($input);



            DB::transaction(function () use ($input) {
                $rescdule = $input['status'];
                $rsvp1 = $input['rsvp1'];
                $rsvp2 = $input['rsvp2'];
                // Update rsvp1 based on status
                if ($rescdule == 'Accept' || $rescdule == 'Declined') {
                    $rsvp1 = $rescdule;
                    $rsvp2 = $rescdule;
                }

                if ($rsvp1 == 'Accept' || $rsvp2 == 'Reschedule' || $rsvp1 == 'Reschedule') {
                    DB::table('ovm_allocation')
                        ->where('id', $input['allocation_id'])
                        ->update([
                            'is_coordinator1' => $input['is_coordinator1'],
                            'is_coordinator2' => $input['is_coordinator2'],

                            'meeting_startdate' => $input['meeting_startdate'],
                            'meeting_enddate' => $input['meeting_enddate'],
                            'meeting_starttime' => $input['meeting_starttime'],
                            'meeting_endtime' => $input['meeting_endtime'],

                            'meeting_startdate2' => $input['meeting_startdate2'],
                            'meeting_enddate2' => $input['meeting_enddate2'],
                            'meeting_starttime2' => $input['meeting_starttime2'],
                            'meeting_endtime2' => $input['meeting_endtime2'],

                            'last_modified_by' => auth()->user()->id,
                            'last_modified_date' => now(),

                            'meeting_status' => $input['meeting_status'],
                            'rsvp1' => $rsvp1,
                            'rsvp2' => $rsvp2,
                            'active_flag' => ($input['meeting_status'] == 'update' ? 2 : ''),
                            'cnotes' => $input['coord_notes'],
                            'meeting_description' => $input['meeting_description']

                        ]);
                }
                else
                {
                    DB::table('ovm_allocation')
                    ->where('id', $input['allocation_id'])
                    ->update([
                        'is_coordinator1' => $input['is_coordinator1'],
                        'is_coordinator2' => $input['is_coordinator2'],

                        'meeting_startdate' => $input['meeting_startdate'],
                        'meeting_enddate' => $input['meeting_enddate'],
                        'meeting_starttime' => $input['meeting_starttime'],
                        'meeting_endtime' => $input['meeting_endtime'],

                        'meeting_startdate2' => $input['meeting_startdate2'],
                        'meeting_enddate2' => $input['meeting_enddate2'],
                        'meeting_starttime2' => $input['meeting_starttime2'],
                        'meeting_endtime2' => $input['meeting_endtime2'],

                        'last_modified_by' => auth()->user()->id,
                        'last_modified_date' => now(),

                        'meeting_status' => $input['meeting_status'],
                        'rsvp1' => $input['status'],
                        'rsvp2' => $input['status'],
                        'active_flag' => ($input['meeting_status'] == 'update' ? 2 : ''),
                        'cnotes' => $input['coord_notes'],
                        'meeting_description' => $input['meeting_description']
                    ]);
                }

                $rescdule = $input['status'];


                // if ($rescdule === 'Reschedule') {
                //     DB::table('ovm_allocation')
                //         ->where('id', $input['allocation_id'])
                //         ->increment('reschedule_count', 1);
                // }
                // $this->WriteFileLog($rescdule);
                $rsvp1 = $input['rsvp1'];
                $rsvp2 = $input['rsvp2'];
               // $this->WriteFileLog($rsvp1);
               // $this->WriteFileLog($rsvp2);
                if ($rsvp1 == 'Reschedule' || $rsvp2  == 'Reschedule' || $rescdule == 'Reschedule') {
                    DB::table('ovm_allocation')
                        ->where('id', $input['allocation_id'])
                        ->increment('reschedule_count', 1);
                }
                // $this->WriteFileLog($rsvp1);
                $meeting_status = $input['meeting_status'];
                $user_id = $input['user_id'];
                // $this->WriteFileLog($user_id);
                $co1 = $input['is_coordinator1'];
                // $this->WriteFileLog($co1);
                $co2 = $input['is_coordinator2'];
                // $this->WriteFileLog($co2);
                if ($meeting_status == 'Sent') {
                    // $this->WriteFileLog("zxas1");
                    $ovm_meeting = $input['allocation_id'];
                    $this->auditLog('ovm_meeting_details', $ovm_meeting, 'OVM', 'create new ovm meeting details', auth()->user()->id, NOW(), ' $role_name_fetch');

                    $enrollment = DB::select("SELECT * FROM enrollment_details WHERE user_id = '$user_id'");
                    // $this->WriteFileLog($enrollment);
                    //$user_detailid= $enrollment[0]->user_id;
                    DB::table('notifications')->insertGetId([
                        'user_id' => $enrollment[0]->user_id,
                        'notification_type' => 'OVM Meeting Scheduled',
                        'notification_status' => 'OVM Meeting',
                        'notification_url' => 'ovm_allocation/accept/' . encrypt($ovm_meeting),
                        'megcontent' => "OVM Meeting has been Scheduled for child-" . $enrollment[0]->child_name . " (" . $enrollment[0]->enrollment_child_num . "). Click here to confirm the Availabity",
                        'alert_meg' => "OVM Meeting has been Scheduled for child-" . $enrollment[0]->child_name . " (" . $enrollment[0]->enrollment_child_num . "). Click here to confirm the Availabity",
                        'created_by' => auth()->user()->id,
                        'created_at' => NOW()
                    ]);
                    // $this->WriteFileLog("zxas2");
                    $data = [
                        'url' => $input['url'],
                        'meeting_description' => $input['meeting_description'],
                        'mailSubject' => 'Overview Meeting Schedule and Confirmation',
                        'child_name' => $input['child_name'],

                        'meeting_startdate' => $input['meeting_startdate'],
                        'meeting_startdate2' => $input['meeting_startdate2'],
                        'meeting_starttime' => date('h:i a', strtotime($input['meeting_starttime'])),
                        'meeting_endtime' => date('h:i a', strtotime($input['meeting_endtime'])),
                        'meeting_starttime2' => date('h:i a', strtotime($input['meeting_starttime2'])),
                        'meeting_endtime2' => date('h:i a', strtotime($input['meeting_endtime2'])),
                        'c_notes' => $input['coord_notes'],
                    ];
                    // $this->WriteFileLog("zxas3");

                    Mail::to($enrollment[0]->child_contact_email)->send(new OVMAllocationMail($data));
                    // $this->WriteFileLog("zxas4");
                    DB::table('notifications')->insertGetId([
                        'user_id' => $co1,
                        'notification_type' => 'OVM Meeting Scheduled',
                        'notification_status' => 'OVM Meeting',
                        'notification_url' => 'ovm_allocation/' . encrypt($ovm_meeting) . '/edit',
                        'megcontent' => "OVM Meeting has been Scheduled for child-" . $enrollment[0]->child_name . " (" . $enrollment[0]->enrollment_child_num . ")",
                        'alert_meg' => "OVM Meeting has been Scheduled for child-" . $enrollment[0]->child_name . " (" . $enrollment[0]->enrollment_child_num . ")",
                        'created_by' => auth()->user()->id,
                        'created_at' => NOW()
                    ]);
                    // $this->WriteFileLog("zxas5");
                    //$bccRecipients = ['aadhi5669@gmail.com', 'aathish.mani@talentakeaways.com'];
                    // $this->WriteFileLog($co2);
                    // $is1 = $input['is_coordinator1'];

                    $isco1 = DB::select("Select * from users where id='$co1'");
                    // $this->WriteFileLog("zxas62");
                    // $this->WriteFileLog($isco1);
                    Mail::to($isco1[0]->email)->send(new OVMAllocationMail_IS($data));
                    // $this->WriteFileLog("zxas63");
                    $is2 = $input['is_coordinator2'];
                    if ($is2 != 'Select-IS-Coordinator-2') {
                        // $this->WriteFileLog("zxas61");
                        DB::table('notifications')->insertGetId([
                            'user_id' => $input['is_coordinator2'],
                            'notification_type' => 'OVM Meeting Scheduled',
                            'notification_status' => 'OVM Meeting',
                            'notification_url' => 'ovm_allocation/' . encrypt($ovm_meeting) . '/edit',
                            'megcontent' => "OVM Meeting has been Scheduled for child-" . $enrollment[0]->child_name . " (" . $enrollment[0]->enrollment_child_num . ")",
                            'alert_meg' => "OVM Meeting has been Scheduled for child-" . $enrollment[0]->child_name . " (" . $enrollment[0]->enrollment_child_num . ")",
                            'created_by' => auth()->user()->id,
                            'created_at' => NOW()
                        ]);
                        // $this->WriteFileLog("zxas6");
                        $isco2 = DB::select("Select * from users where id='$co2'");
                        // $this->WriteFileLog("zxas7");
                        Mail::to($isco2[0]->email)->send(new OVMAllocationMail_IS($data));
                    }
                    // $this->WriteFileLog("asdcas");
                } else if ($rescdule == "Declined") {
                    // $this->WriteFileLog("asdcas1");
                    $this->auditLog('ovm_meeting_details', $input['allocation_id'], 'OVM', 'declined ovm meeting details', auth()->user()->id, NOW(), ' $role_name_fetch');

                    $enrollment = DB::select("SELECT * FROM enrollment_details WHERE user_id = '$user_id'");
                    DB::table('notifications')->insertGetId([
                        'user_id' => $enrollment[0]->user_id,
                        'notification_type' => 'OVM Meeting Declined',
                        'notification_status' => 'OVM Meeting',
                        'notification_url' => 'ovm_allocation/accept/' . encrypt($input['allocation_id']),
                        'megcontent' => "OVM Meeting has been Declined for child-" . $enrollment[0]->child_name . " (" . $enrollment[0]->enrollment_child_num . ")",
                        'alert_meg' => "OVM Meeting has been Declined for child-" . $enrollment[0]->child_name . " (" . $enrollment[0]->enrollment_child_num . ")",
                        'created_by' => auth()->user()->id,
                        'created_at' => NOW()
                    ]);
                    $data = [
                        'url' => $input['url'],
                        'meeting_description' => $input['meeting_description'],
                        'mailSubject' => 'OVM Meeting Declined',
                        'child_name' => $input['child_name'],

                        'meeting_startdate' => $input['meeting_startdate'],
                        'meeting_startdate2' => $input['meeting_startdate2'],
                        'meeting_starttime' => date('h:i a', strtotime($input['meeting_starttime'])),
                        'meeting_endtime' => date('h:i a', strtotime($input['meeting_endtime'])),
                        'meeting_starttime2' => date('h:i a', strtotime($input['meeting_starttime2'])),
                        'meeting_endtime2' => date('h:i a', strtotime($input['meeting_endtime2'])),
                        'c_notes' => $input['coord_notes'],
                    ];

                    Mail::to($enrollment[0]->child_contact_email)->send(new OVMDeclinedMailUpdate($data));

                    DB::table('notifications')->insertGetId([
                        'user_id' => $input['is_coordinator1'],
                        'notification_type' => 'OVM Meeting Declined',
                        'notification_status' => 'OVM Meeting',
                        'notification_url' => 'ovm_allocation/' . encrypt($input['allocation_id']) . '/edit',
                        'megcontent' => "OVM Meeting has been Declined for child-" . $enrollment[0]->child_name . " (" . $enrollment[0]->enrollment_child_num . ")",
                        'alert_meg' => "OVM Meeting has been Declined for child-" . $enrollment[0]->child_name . " (" . $enrollment[0]->enrollment_child_num . ")",
                        'created_by' => auth()->user()->id,
                        'created_at' => NOW()
                    ]);
                    //$bccRecipients = ['aadhi5669@gmail.com', 'aathish.mani@talentakeaways.com'];
                    // $is1 = $input['is_coordinator1'];
                    $isco1 = DB::select("Select * from users where id='$co1'");
                    Mail::to($isco1[0]->email)->send(new OVMDeclinedMail_IS($data));
                    $is2 = $input['is_coordinator2'];
                    if ($is2 != 'Select-IS-Coordinator-2') {
                        DB::table('notifications')->insertGetId([
                            'user_id' => $co2,
                            'notification_type' => 'OVM Meeting Declined',
                            'notification_status' => 'OVM Meeting',
                            'notification_url' => 'ovm_allocation/' . encrypt($input['allocation_id']) . '/edit',
                            'megcontent' => "OVM Meeting has been Declined for child-" . $enrollment[0]->child_name . " (" . $enrollment[0]->enrollment_child_num . ")",
                            'alert_meg' => "OVM Meeting has been Declined for child-" . $enrollment[0]->child_name . " (" . $enrollment[0]->enrollment_child_num . ")",
                            'created_by' => auth()->user()->id,
                            'created_at' => NOW()
                        ]);
                        $isco2 = DB::select("Select * from users where id='$co2'");
                        Mail::to($isco2[0]->email)->send(new OVMDeclinedMail_IS($data));
                    }
                } else if ($rescdule == "Accept") {
                    // $this->WriteFileLog("asdcas1");
                    $this->auditLog('ovm_meeting_details', $input['allocation_id'], 'OVM', 'Accept ovm meeting details', auth()->user()->id, NOW(), ' $role_name_fetch');

                    $enrollment = DB::select("SELECT * FROM enrollment_details WHERE user_id = '$user_id'");
                    DB::table('notifications')->insertGetId([
                        'user_id' => $enrollment[0]->user_id,
                        'notification_type' => 'OVM Meeting Accepted',
                        'notification_status' => 'OVM Meeting',
                        'notification_url' => 'ovm_allocation/accept/' . encrypt($input['allocation_id']),
                        'megcontent' => "OVM Meeting has been Accepted for child-" . $enrollment[0]->child_name . " (" . $enrollment[0]->enrollment_child_num . ")",
                        'alert_meg' => "OVM Meeting has been Accepted for child-" . $enrollment[0]->child_name . " (" . $enrollment[0]->enrollment_child_num . ")",
                        'created_by' => auth()->user()->id,
                        'created_at' => NOW()
                    ]);
                    $data = [
                        'url' => $input['url'],
                        'meeting_description' => $input['meeting_description'],
                        'mailSubject' => 'OVM Meeting Accepted',
                        'child_name' => $input['child_name'],

                        'meeting_startdate' => $input['meeting_startdate'],
                        'meeting_startdate2' => $input['meeting_startdate2'],
                        'meeting_starttime' => date('h:i a', strtotime($input['meeting_starttime'])),
                        'meeting_endtime' => date('h:i a', strtotime($input['meeting_endtime'])),
                        'meeting_starttime2' => date('h:i a', strtotime($input['meeting_starttime2'])),
                        'meeting_endtime2' => date('h:i a', strtotime($input['meeting_endtime2'])),
                        'c_notes' => $input['coord_notes'],
                    ];

                    Mail::to($enrollment[0]->child_contact_email)->send(new OVMAcceptedMailUpdate($data));

                    DB::table('notifications')->insertGetId([
                        'user_id' => $input['is_coordinator1'],
                        'notification_type' => 'OVM Meeting Accepted',
                        'notification_status' => 'OVM Meeting',
                        'notification_url' => 'ovm_allocation/' . encrypt($input['allocation_id']) . '/edit',
                        'megcontent' => "OVM Meeting has been Accepted for child-" . $enrollment[0]->child_name . " (" . $enrollment[0]->enrollment_child_num . ")",
                        'alert_meg' => "OVM Meeting has been Accepted for child-" . $enrollment[0]->child_name . " (" . $enrollment[0]->enrollment_child_num . ")",
                        'created_by' => auth()->user()->id,
                        'created_at' => NOW()
                    ]);
                    //$bccRecipients = ['aadhi5669@gmail.com', 'aathish.mani@talentakeaways.com'];
                    // $is1 = $input['is_coordinator1'];
                    $isco1 = DB::select("Select * from users where id='$co1'");
                    Mail::to($isco1[0]->email)->send(new OVMAcceptedMail_IS($data));
                    $is2 = $input['is_coordinator2'];
                    if ($is2 != 'Select-IS-Coordinator-2') {
                        DB::table('notifications')->insertGetId([
                            'user_id' => $co2,
                            'notification_type' => 'OVM Meeting Accepted',
                            'notification_status' => 'OVM Meeting',
                            'notification_url' => 'ovm_allocation/' . encrypt($input['allocation_id']) . '/edit',
                            'megcontent' => "OVM Meeting has been Accepted for child-" . $enrollment[0]->child_name . " (" . $enrollment[0]->enrollment_child_num . ")",
                            'alert_meg' => "OVM Meeting has been Accepted for child-" . $enrollment[0]->child_name . " (" . $enrollment[0]->enrollment_child_num . ")",
                            'created_by' => auth()->user()->id,
                            'created_at' => NOW()
                        ]);
                        $isco2 = DB::select("Select * from users where id='$co2'");
                        Mail::to($isco2[0]->email)->send(new OVMAcceptedMail_IS($data));
                    }
                } else if ($rescdule == "Forced Closure") {
                    // $this->WriteFileLog("asdcas1");
                    $this->auditLog('ovm_meeting_details', $input['allocation_id'], 'OVM', 'Accept ovm meeting details', auth()->user()->id, NOW(), ' $role_name_fetch');

                    $enrollment = DB::select("SELECT * FROM enrollment_details WHERE user_id = '$user_id'");
                    DB::table('notifications')->insertGetId([
                        'user_id' => $enrollment[0]->user_id,
                        'notification_type' => 'OVM Meetings Forced Closure',
                        'notification_status' => 'OVM Meeting',
                        'notification_url' => 'ovm_allocation/accept/' . encrypt($input['allocation_id']),
                        'megcontent' => "OVM Meetings has been Forced Closure for child-" . $enrollment[0]->child_name . " (" . $enrollment[0]->enrollment_child_num . ")",
                        'alert_meg' => "OVM Meetings has been Forced Closure for child-" . $enrollment[0]->child_name . " (" . $enrollment[0]->enrollment_child_num . ")",
                        'created_by' => auth()->user()->id,
                        'created_at' => NOW()
                    ]);
                    $data = [
                        'url' => $input['url'],
                        'meeting_description' => $input['meeting_description'],
                        'mailSubject' => 'OVM Meetings Forced Closure',
                        'child_name' => $input['child_name'],

                        'meeting_startdate' => $input['meeting_startdate'],
                        'meeting_startdate2' => $input['meeting_startdate2'],
                        'meeting_starttime' => date('h:i a', strtotime($input['meeting_starttime'])),
                        'meeting_endtime' => date('h:i a', strtotime($input['meeting_endtime'])),
                        'meeting_starttime2' => date('h:i a', strtotime($input['meeting_starttime2'])),
                        'meeting_endtime2' => date('h:i a', strtotime($input['meeting_endtime2'])),
                        'c_notes' => $input['coord_notes'],
                    ];

                    Mail::to($enrollment[0]->child_contact_email)->send(new OVMClosureMailUpdate($data));

                    DB::table('notifications')->insertGetId([
                        'user_id' => $input['is_coordinator1'],
                        'notification_type' => 'OVM Meetings Forced Closure',
                        'notification_status' => 'OVM Meeting',
                        'notification_url' => 'ovm_allocation/' . encrypt($input['allocation_id']) . '/edit',
                        'megcontent' => "OVM Meetings has been Forced Closure for child-" . $enrollment[0]->child_name . " (" . $enrollment[0]->enrollment_child_num . ")",
                        'alert_meg' => "OVM Meetings has been Forced Closure for child-" . $enrollment[0]->child_name . " (" . $enrollment[0]->enrollment_child_num . ")",
                        'created_by' => auth()->user()->id,
                        'created_at' => NOW()
                    ]);
                    //$bccRecipients = ['aadhi5669@gmail.com', 'aathish.mani@talentakeaways.com'];
                    // $is1 = $input['is_coordinator1'];
                    $isco1 = DB::select("Select * from users where id='$co1'");
                    Mail::to($isco1[0]->email)->send(new OVMClosureMail_IS($data));
                    $is2 = $input['is_coordinator2'];
                    if ($is2 != 'Select-IS-Coordinator-2') {
                        DB::table('notifications')->insertGetId([
                            'user_id' => $co2,
                            'notification_type' => 'OVM Meetings Forced Closure',
                            'notification_status' => 'OVM Meeting',
                            'notification_url' => 'ovm_allocation/' . encrypt($input['allocation_id']) . '/edit',
                            'megcontent' => "OVM Meetings has been Forced Closure for child-" . $enrollment[0]->child_name . " (" . $enrollment[0]->enrollment_child_num . ")",
                            'alert_meg' => "OVM Meetings has been Forced Closure for child-" . $enrollment[0]->child_name . " (" . $enrollment[0]->enrollment_child_num . ")",
                            'created_by' => auth()->user()->id,
                            'created_at' => NOW()
                        ]);
                        $isco2 = DB::select("Select * from users where id='$co2'");
                        Mail::to($isco2[0]->email)->send(new OVMClosureMail_IS($data));
                    }
                } else {
                    // $this->WriteFileLog("asdcas1");
                    $this->auditLog('ovm_meeting_details', $input['allocation_id'], 'OVM', 'create new ovm meeting details', auth()->user()->id, NOW(), ' $role_name_fetch');

                    $enrollment = DB::select("SELECT * FROM enrollment_details WHERE user_id = '$user_id'");
                    DB::table('notifications')->insertGetId([
                        'user_id' => $enrollment[0]->user_id,
                        'notification_type' => 'OVM Meeting Rescheduled',
                        'notification_status' => 'OVM Meeting',
                        'notification_url' => 'ovm_allocation/accept/' . encrypt($input['allocation_id']),
                        'megcontent' => "OVM Meeting has been Rescheduled for child-" . $enrollment[0]->child_name . " (" . $enrollment[0]->enrollment_child_num . ")",
                        'alert_meg' => "OVM Meeting has been Rescheduled for child-" . $enrollment[0]->child_name . " (" . $enrollment[0]->enrollment_child_num . ")",
                        'created_by' => auth()->user()->id,
                        'created_at' => NOW()
                    ]);
                    
                     $mail_sub="";
                    // $this->WriteFileLog($co1);
                    $allocationId = $input['allocation_id'];
                    $res_count = DB::table('ovm_allocation')
                        ->where('id', $allocationId)
                        ->value('reschedule_count');

                    if ($res_count == 1) {
                        $mail_sub = "OVM Meeting Reschedule-1";
                    } else if ($res_count == 2) {
                        $mail_sub = "OVM Meeting Reschedule-2";
                    }
                    // } else  if ($rsvp1 == 'Reschedule' && $rsvp2 == 'Reschedule') {
                    //     $mail_sub = "OVM Meetings Reschedule";
                    // }
                    $data = [
                        'url' => $input['url'],
                        'meeting_description' => $input['meeting_description'],
                        'mailSubject' => $mail_sub,
                        'child_name' => $input['child_name'],

                        'meeting_startdate' => $input['meeting_startdate'],
                        'meeting_startdate2' => $input['meeting_startdate2'],
                        'meeting_starttime' => date('h:i a', strtotime($input['meeting_starttime'])),
                        'meeting_endtime' => date('h:i a', strtotime($input['meeting_endtime'])),
                        'meeting_starttime2' => date('h:i a', strtotime($input['meeting_starttime2'])),
                        'meeting_endtime2' => date('h:i a', strtotime($input['meeting_endtime2'])),
                        'c_notes' => $input['coord_notes'],


                    ];
                    if($input['meeting_status'] !='Saved')
                    {
                        Mail::to($enrollment[0]->child_contact_email)->send(new OVMAllocationMailUpdate($data));

                    DB::table('notifications')->insertGetId([
                        'user_id' => $input['is_coordinator1'],
                        'notification_type' => 'OVM Meeting Rescheduled',
                        'notification_status' => 'OVM Meeting',
                        'notification_url' => 'ovm_allocation/' . encrypt($input['allocation_id']) . '/edit',
                        'megcontent' => "OVM Meeting has been Rescheduled for child-" . $enrollment[0]->child_name . " (" . $enrollment[0]->enrollment_child_num . ")",
                        'alert_meg' => "OVM Meeting has been Rescheduled for child-" . $enrollment[0]->child_name . " (" . $enrollment[0]->enrollment_child_num . ")",
                        'created_by' => auth()->user()->id,
                        'created_at' => NOW()
                    ]);
                    ////$bccRecipients = ['aadhi5669@gmail.com', 'aathish.mani@talentakeaways.com'];
                    // $is1 = $input['is_coordinator1'];
                    $isco1 = DB::select("Select * from users where id='$co1'");
                    Mail::to($isco1[0]->email)->send(new OVMRescheduleMail_IS($data));
                    $is2 = $input['is_coordinator2'];
                    if ($is2 != 'Select-IS-Coordinator-2') {
                        DB::table('notifications')->insertGetId([
                            'user_id' => $co2,
                            'notification_type' => 'OVM Meeting Rescheduled',
                            'notification_status' => 'OVM Meeting',
                            'notification_url' => 'ovm_allocation/' . encrypt($input['allocation_id']) . '/edit',
                            'megcontent' => "OVM Meeting has been Rescheduled for child-" . $enrollment[0]->child_name . " (" . $enrollment[0]->enrollment_child_num . ")",
                            'alert_meg' => "OVM Meeting has been Rescheduled for child-" . $enrollment[0]->child_name . " (" . $enrollment[0]->enrollment_child_num . ")",
                            'created_by' => auth()->user()->id,
                            'created_at' => NOW()
                        ]);
                        $isco2 = DB::select("Select * from users where id='$co2'");
                        Mail::to($isco2[0]->email)->send(new OVMRescheduleMail_IS($data));
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

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
