<?php

namespace App\Jobs;

use App\Mail\sendovmmail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use App\Googl;

class CheckRemainder implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(Googl $googl)
    {
        Log::error('Google');
        $detail = DB::select("SELECT * , CONCAT(created_by , ',' , JSON_EXTRACT(is_coordinator1, '$.id') , ',' , COALESCE(JSON_EXTRACT(is_coordinator2, '$.id'),'') ) AS stakeholders FROM ovm_meeting_details WHERE meeting_status != 'Completed' AND meeting_status != 'Hold'");
        foreach ($detail as $row) {
            $event_id = $row->event_id;
            $meeting_status = $row->meeting_status;
            $ovm_meeting_id = $row->ovm_meeting_id;
            $child_name = $row->child_name;
            $enrollment_id = $row->enrollment_id;
            $stakeholders = $row->stakeholders;$inarr = explode(',', $stakeholders);Log::error($inarr);
            // $created_by = $row->created_by;
            // $co_1 = $row->c1;
            // $co_2 = $row->c2;

            $service = new \Google_Service_Calendar($googl->client());
            $event = $service->events->get('primary', $event_id);

            $eventDetails = json_decode(json_encode($event), true);
            $attendees = $eventDetails['attendees'];
            
            foreach ($attendees as $attendee) {
                // Log::error( $attendee['email'] . " :: " . $attendee['responseStatus'] );
                $email = $attendee['email'];
                $responseStatus = $attendee['responseStatus'];
                if($responseStatus == 'tentative'){
                    $responseStatus = 'Reschedule Request';
                }elseif($responseStatus == 'accepted'){
                    $responseStatus = 'Accepted';
                }elseif($responseStatus == 'declined'){
                    $responseStatus = 'Declined';
                }
                $user = DB::select("SELECT * FROM users WHERE email = '$email'");
                if ($user != []){
                    $userID = $user[0]->id;
                    $name = $user[0]->name;
                    $check = DB::select("Select * FROM ovm_attendees WHERE ovm_id = $ovm_meeting_id AND created_by = $userID");
                    if ($check != []){
                        $currentStatus = $check[0]->status;
                    }else{
                        $currentStatus = '';
                    }
                    Log::error($currentStatus);Log::error($responseStatus);
                    if($currentStatus != $responseStatus){
                        DB::select("Delete FROM ovm_attendees WHERE ovm_id = $ovm_meeting_id AND created_by = $userID");
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
    
                        foreach($inarr as $val){Log::error($val);
                            DB::table('notifications')->insertGetId([
                                'user_id' => $val,
                                'notification_type' => 'OVM Meeting Scheduled',
                                'notification_status' => 'OVM Meeting',
                                'notification_url' => 'ovm1/' . encrypt($ovm_meeting_id),
                                'megcontent' => "OVM-1 Meeting for " . $child_name . " (" . $enrollment_id . " ) has been " . $responseStatus . " by " . $name,
                                'alert_meg' => "OVM-1 Meeting for " . $child_name . " (" . $enrollment_id . " ) has been " . $responseStatus . " by " . $name,
                                // 'created_by' => auth()->user()->id,
                                'created_at' => NOW()
                            ]);
                        }
                        
                    }
                }
            }
        }     
        dispatch(new CheckRemainder(1));
    }
}
