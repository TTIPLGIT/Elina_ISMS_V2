<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use Validator;
use Illuminate\Support\Facades\DB;
use File;
use Illuminate\Support\Str;
use Symfony\Component\VarDumper\Cloner\Data;
use App\Classes\EmailSch;
use PhpParser\Node\Expr\New_;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendOVMMail;
use App\Mail\senddemomail;
use App\Mail\elinademoemail;
use App\Classes\EmailScheduling;






class ElinademoforparentsController extends BaseController

{
    public function index(Request $request)
    {
        try {

            $method = 'Method => ElinademoforparentsController => index';
            
            $userID = auth()->user()->id;
            

            $rows = DB::table('demo_parent_details')

                ->select('*')
                ->where('active_flag', 0)
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

    
    public function create()

    {
        // $this->WriteFileLog($request);

        try {


            $method = 'Method => ElinademoforparentsController => meetinginvite';
            // $this->WriteFileLog($method);

            $rows = array();
            $rows['demo_parent_details'] = DB::select("select * from enrollment_details AS a inner join payment_status_details AS b ON a.enrollment_child_num = b.enrollment_child_num WHERE payment_status ='SUCCESS'");
                
                
            $rows['iscoordinators'] = DB::table('users')
                ->select('users.name', 'users.email', 'users.id')
                ->rightjoin('uam_user_roles', 'uam_user_roles.user_id', '=', 'users.id')
                ->rightjoin('uam_roles', 'uam_roles.role_id', '=', 'uam_user_roles.role_id')
                ->where('uam_roles.role_name', 'IS Coordinator')
                ->get();
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
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            $method = 'Method => ElinademoforparentsController => store';


            $userID =  auth()->user()->id ;
            $this->WriteFileLog($userID);
           
            
            $inputArray = $this->decryptData($request->requestData);
            $is_coordinator1 = $inputArray['is_coordinator1'];
            $is_coordinator1 = DB::select('Select id,email,name from users where id=' .$is_coordinator1);
     
            $is_coordinator1json = json_encode($is_coordinator1,JSON_FORCE_OBJECT); 
            // $is_coordinator2 = $inputArray['is_coordinator2'];
            // $is_coordinator2 = DB::select('Select id,email,name from users where id='.$is_coordinator2);
            // $is_coordinator2json = json_encode($is_coordinator2,JSON_FORCE_OBJECT); 
            $enrollment_id = $inputArray['enrollment_id'];
            $input = [

                'enrollment_id' => $inputArray['enrollment_id'],
                'child_id' => $inputArray['child_id'],
                'is_coordinator1' => $is_coordinator1json,
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
                'attached_file_path' => $inputArray['attached_file_path'],
                'imagename'=> $inputArray['imagename'],
                'type' => $inputArray['type'],
                'user_id' => $inputArray['user_id'],


            ];
        
            $startTime = $inputArray['meeting_startdate'].'T'.$inputArray['meeting_starttime'].':00';
            $endTime = $inputArray['meeting_enddate'].'T'.$inputArray['meeting_endtime'].':00';
            $type = $input['type'];
            // if ($type == "sent") {
            //     $service = new \Google_Service_Calendar($this->client);
            //     $this->WriteFileLog(json_decode(json_encode($service),true));
            //     $this->WriteFileLog("ere");
               
            //     $event = new \Google_Service_Calendar_Event(array(
            //         'summary' => $inputArray['meeting_subject'],
            //         'location' => $inputArray['meeting_location'],
            //         'description' => $inputArray['meeting_description'],
            //         'start' => array('dateTime' => $startTime,'timeZone' => 'Asia/Kolkata',),
            //         'end' => array('dateTime' => $endTime,'timeZone' => 'Asia/Kolkata',),
            //         'attendees' => array( array('email' => $inputArray['meeting_to']),),
            //         'reminders' => array('useDefault' => FALSE,'overrides' => array(array('method' => 'email', 'minutes' => 24 * 60),array('method' => 'popup', 'minutes' => 10),),),
            //         "conferenceData" => array("createRequest" => array("conferenceSolutionKey" => array("type" => "hangoutsMeet"),"requestId" => "123"))
            //     ));
            //     $opts = array('sendNotifications' => true, 'conferenceDataVersion' => 1);
            //     $event = $service->events->insert('primary', $event, $opts);
            // }


            $user_id = $input['user_id'];

            $user_check = DB::select("select * from demo_parent_details where enrollment_id = '$enrollment_id' and active_flag = 0");

            if ($user_check == []) {



                DB::transaction(function () use ($input) {
                    $claimdetails = DB::table('demo_parent_details')->orderBy('demo_unique', 'desc')->first();

                    if ($claimdetails == null) {
                        $claimnoticenoNew =  'DEMO-1/' . date("Y") . '/' . date("M") . '/001';

                        // echo ($claimnoticenoNew);exit;
                    } else {
                        $claimnoticeno = $claimdetails->demo_unique;
                        $claimnoticenoNew =  ++$claimnoticeno;  // AAA004 
                    }



                    $inputArraycount = count($input);

                    $ovm_meeting = DB::table('demo_parent_details')
                        ->insertGetId([
                            'demo_unique' => $claimnoticenoNew,
                            'enrollment_id' => $input['enrollment_id'],
                            'child_id' => $input['child_id'],
                            'is_coordinator1' => $input['is_coordinator1'],
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
                            'created_date' => now(),
                            'created_by' =>auth()->user()->id,
                            'attached_file_path' => $input['attached_file_path'],
                            'imagename'=>$input['imagename'],
                            'user_id' => $input['user_id'],

                             'active_flag' => '0',


                        ]);
                    $this->auditLog('demo_parent_details', $ovm_meeting, 'Create', 'create new Elina Demo meeting details', auth()->user()->id, NOW(), ' Elina demo');

                    // $this->notificationstable(auth()->user()->id, 'saved', ' Create a new Elina Demo meeting', auth()->user()->id, 'enrolled');
                    

                    $notifications = DB::table('notifications')->insertGetId([
                        'user_id' => auth()->user()->id,
                        'notification_type' => 'create a Link',
                        'notification_status' => 'Elina demo',  
                        'notification_url' => 'elinademo'. $ovm_meeting,    
                        'megcontent' => "User ".$input['child_name']." Elina Demo link mail send Successfully.",
                        'alert_meg' => "User ".$input['child_name']." Elina Demo link mail send Successfully.", 
                        'created_by' => auth()->user()->id,
                        'created_at' => NOW()
                    ]);

                    $admin_details = DB::SELECT("SELECT *from users where array_roles = '1'");
                    $adminn_count = count( $admin_details);
                    if ($admin_details != [] ) {
                        for ($j=0; $j < $adminn_count; $j++) { 
    
                            $notifications = DB::table('notifications')->insertGetId([
                                'user_id' =>  $admin_details[$j]->id,
                                
                                'notification_type' => 'create a Link',
                                'notification_status' => 'Elina Demo',  
                                'notification_url' => 'elinademo/'. $ovm_meeting,    
                                'megcontent' => "User ".$input['child_name']." Elina Demo link mail send Successfully.",
                                'alert_meg' => "User ".$input['child_name']." Elina Demo link mail send Successfully.", 
                                'created_by' => auth()->user()->id,
                                'created_at' => NOW()
                            ]);
    
    
    
                        }}
                });
               
              

               

                if($request->hasFile('file'))     
                    {
                        
                        $storagePath = config("document_storage_path").'\demo_document';
                        $imageFile = $request->file('file');
                        $imageName = $imageFile->getClientOriginalName();
                        // $storagePath = storage_path().'\app\uploads\images';
                        
                        $imageFile->move($storagePath, $imageName);
                        
                    }
                    $email = $inputArray['meeting_to'];

           
                    $data = array(
                        'child_name' => $inputArray['child_name'],
                        'imagename' => $inputArray['imagename'],
                    );
                    
                    Mail::to($email)->send(new senddemomail($data));

                    $users = DB::select("SELECT email, name from users where array_roles='3' ");
					$this->WriteFileLog($users);
					$email = $users[0]->email;
				   
					
					
					$admin_email = count( $users);
					if ($email != [] ) {
						for ($j=0; $j < $admin_email; $j++) { 
		
							$name = $users[$j]->name;
							$data = array(
								'admin' => $name,
								'name' => $request['name'],
								
								
				
							);
							Mail::to($users[$j]->email)->send(new elinademoemail($data));
		
		
						}}
		
		

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
                
            $method = 'Method => ElinademoforparentsController => data_edit';
            

            $id = $this->DecryptData($id);


            $rows = DB::table('demo_parent_details as a')
                ->select('a.*')
                ->where('a.demo_parent_details_id', $id)
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
    public function completed_data_edit(Request $request, $id)
    {
        try {

            $method = 'Method => ElinademoforparentsController => completed_data_edit';
            $this->WriteFileLog($request['user_id']);
            $user_id = $request['user_id'];
            $id = $this->DecryptData($id);


            $rows = DB::table('ovm_meeting_isc_feedback as a')
                ->select('a.*')
                ->where([['a.ovm_meeting_id', $id], ['a.is_coordinator_id', $user_id]])
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
    public function updatedata(Request $request)
    {
        

        try {
           
            $method = 'Method =>  ElinademoforparentsController => updatedata';
           
            $inputArray = $this->decryptData($request->requestData);
            $status = $inputArray['meeting_status'];
            $input = [
                'id' => $inputArray['id'],
                'enrollment_id' => $inputArray['enrollment_id'],
                
                'meeting_to' => $inputArray['meeting_to'],
                'meeting_subject' => $inputArray['meeting_subject'],
                'meeting_startdate' => $inputArray['meeting_startdate'],
                'meeting_enddate' => $inputArray['meeting_enddate'],
                'meeting_starttime' => $inputArray['meeting_starttime'],
                'meeting_endtime' => $inputArray['meeting_endtime'],
                'meeting_location' => $inputArray['meeting_location'],
                'meeting_description' => $inputArray['meeting_description'],
                'meeting_status' => $inputArray['meeting_status'],
                
                'user_id' => $inputArray['user_id'],

            ];



            // $question  =  $input['question'];
            //   $id = $input['id'];
            //   $this->WriteFileLog($id ); 






            DB::transaction(function () use ($input) {

                DB::table('demo_parent_details')
                    ->where('demo_parent_details_id', $input['id'])
                    ->update([

                        'enrollment_id' => $input['enrollment_id'],
                        // 'demo_unique' => $input['demo_unique'],
                        
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
                        'user_id' => auth()->user()->id,
                        'created_by' => auth()->user()->id,
                        'created_date' => NOW()

                    ]);

                $this->auditLog('demo_parent_details', $input['id'], 'Update', 'Update new demo meeting', auth()->user()->id, NOW(), '');
            });

            if ($status == 'Completed') {
                DB::transaction(function () use ($input) {

                    DB::table('ovm_meeting_isc_feedback')
                    ->insertGetId([
                        'enrollment_id' => $input['enrollment_id'],
                        'demo_unique' => $input['demo_unique'],
                        'child_id' => $input['child_id'],
                        'is_coordinator_id' => $input['is_coordinator1'],
                        'child_name' => $input['child_name'],
                        'status' => 'New',
                        'user_id' => $input['user_id'],
                    ]);
                });
                DB::transaction(function () use ($input) {

                    DB::table('ovm_meeting_isc_feedback')
                    ->insertGetId([
                        'enrollment_id' => $input['enrollment_id'],
                        'demo_unique' => $input['demo_unique'],
                        'child_id' => $input['child_id'],
                        'is_coordinator_id' => $input['is_coordinator2'],
                        'child_name' => $input['child_name'],
                        'status' => 'New',
                        'user_id' => $input['user_id'],
                    ]);
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
        
        try {


            $method = 'Method =>ElinademoforparentsController => data_delete';
            $this->WriteFileLog($method);
            $id = $this->decryptData($id);
            $this->WriteFileLog($id);



            $check = DB::select("select * from demo_parent_details where demo_parent_details_id = '$id' and active_flag = '0' ");
            $this->WriteFileLog($check);
            if ($check !== []) {

                $this->WriteFileLog($check);
                DB::table('demo_parent_details')
                    ->where('demo_parent_details_id', $id)
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
            $this->WriteFileLog($method);

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
        // $this->WriteFileLog($request);

        try {


            $method = 'Method => ElinademoforparentsController => meetinginvite';
            // $this->WriteFileLog($method);

            $rows = array();
            $rows['demo_parent_details'] = DB::select("select * from enrollment_details AS a inner join payment_status_details AS b ON a.enrollment_child_num = b.enrollment_child_num");
                
                
            $rows['iscoordinators'] = DB::table('users')
                ->select('users.name', 'users.email', 'users.id')
                ->rightjoin('uam_user_roles', 'uam_user_roles.user_id', '=', 'users.id')
                ->rightjoin('uam_roles', 'uam_roles.role_id', '=', 'uam_user_roles.role_id')
                ->where('uam_roles.role_name', 'IS Coordinator')
                ->get();
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
    public function ovmmeetingcompleted(Request $request)
    {
        // $this->WriteFileLog($request);

        try {

            $method = 'Method => ovm1Controller => index';

            $user_id = auth()->user()->id;

            $user_id =  $request['user_id'];
            // $this->WriteFileLog($user_id);
            $rows = array();
    
            $rows = DB::table('ovm_meeting_isc_feedback')
                ->select('*')
                ->where('is_coordinator_id', $user_id)
                ->get();
            // $this->WriteFileLog($rows);
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
        $this->WriteFileLog($request);

        try {

            $method = 'Method => ovm1Controller => index';

            $user_id = auth()->user()->id;

            $user_id =  $request['user_id'];
            $this->WriteFileLog($user_id);
            $rows = array();
    
            $rows = DB::Select("SELECT ovm_meeting_id, ovm_meeting_unique, enrollment_id, child_id, child_name, status FROM ovm_meeting_isc_feedback WHERE STATUS = 'Submitted' GROUP BY ovm_meeting_unique");

            $this->WriteFileLog($rows);
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
    public function ovmreportview(Request $request)
    {
        $this->WriteFileLog($request);

        try {

            $method = 'Method => ovm1Controller => index';

            $user_id = auth()->user()->id;

            $user_id =  $request['user_id'];
            $ovm_meeting_id =  $request['ovm_meeting_id'];
            $this->WriteFileLog($user_id);
            $rows = array();
    
            $rows = DB::Select("SELECT a.*,b.name,b.email,b.id  FROM ovm_meeting_isc_feedback AS a 
            right join users AS b ON b.id = a.is_coordinator_id
            WHERE a.status = 'Submitted' AND a.ovm_meeting_id='".$ovm_meeting_id."'");

            $this->WriteFileLog($rows);
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
    public function ovmiscfeedbackstore(Request $request)
    {





        try {
            $method = 'Method => ovm1Controller => store';


            $this->WriteFileLog("ashj");
            $inputArray = $this->decryptData($request->requestData);
            $enrollment_id =  $inputArray['enrollment_id'];

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

            ];

            $this->WriteFileLog($input);
            $type = $input['type'];



            $user_id = $input['user_id'];
            // $this->WriteFileLog($user_id);

            // $ovm_meeting_isc_feedback = DB::select("SELECT * from ovm_meeting_isc_feedback where enrollment_id = '$enrollment_id'");
            // $this->WriteFileLog($ovm_meeting_isc_feedback);
            // $this->WriteFileLog(count($ovm_meeting_isc_feedback));
            // $ovm_meeting_isc_feedback_check = count($ovm_meeting_isc_feedback);
            if ($input['ovm_isc_report_id'] != null) {



                DB::transaction(function () use ($input) {
                    DB::table('ovm_meeting_isc_feedback')
                    ->where('ovm_isc_report_id', $input['ovm_isc_report_id'])
                    ->update([
                   
                            'enrollment_id' => $input['enrollment_id'],
                            'child_id' => $input['child_id'],
                            'child_name' => $input['child_name'],
                            'is_coordinator_id' => $input['user_id'],
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
                            'status' => $input['type'],
                            'created_at' => NOW(),




                        ]);
                    $this->auditLog('ovm_meeting_isc_feedback', $input['ovm_isc_report_id'], 'Create', 'FeedBack of OVM-1 is Saved', auth()->user()->id, NOW(), ' $role_name_fetch');

                    $this->notificationstable(auth()->user()->id, 'saved', ' FeedBack of OVM-1 is Saved', auth()->user()->id, 'enrolled');
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
    
}
