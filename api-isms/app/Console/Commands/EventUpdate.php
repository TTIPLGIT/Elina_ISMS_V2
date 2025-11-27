<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Jobs\CheckRemainder;
use App\Googl;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class EventUpdate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'eventupdate:cron';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle(Googl $googl)
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
                                $msgcontent = "OVM-1 Meeting for " . $child_name . " (" . $enrollment_id . " ) has been " . $responseStatus . " by Parent ";
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

        $f2f = DB::select("SELECT b.user_id as parentId , a.* , JSON_EXTRACT(a.is_coordinator1, '$.id') AS isc1 , 
        CONCAT(a.created_by , ',' , JSON_EXTRACT(a.is_coordinator1, '$.id') ) AS stakeholders 
        FROM in_person_meeting AS a
        INNER JOIN enrollment_details AS b ON b.enrollment_id = a.enrollment_id 
        WHERE a.meeting_status != 'Completed' AND a.meeting_status != 'Hold' 
        AND a.meeting_status != 'Saved'");
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
                                'audit_action' => 'OVM Meeting ' . $responseStatus,
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
        // \Log::info("Event End!");
        $this->handle($googl);
        // dispatch(new CheckRemainder(1));\Log::info("Event Update2!");
    }
}
