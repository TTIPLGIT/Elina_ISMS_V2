<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendResetMail;
use App\Mail\SendUserCreateMail;
use Illuminate\Support\Facades\Log;
use Illuminate\Auth;
use Illuminate\Support\Facades\Hash;


class questionmastercontroller extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
   {
    try {
        $userID = auth()->user()->id;
        $method = 'Method => questionmastercontroller => get_data';
        
        $rows = array();
        $rows['token_paremeterisation'] = DB::table('token_paremeterisation as a')
        ->select('a.token_expire_type','a.token_expire_time','a.token_process','a.token_parameterisation_id','a.active_flag')
        ->where('a.active_flag', 0)
        ->get();
        $rows['token_paremeterisation'] = json_decode($rows['token_paremeterisation'], true);
        for($i=0;$i<count($rows['token_paremeterisation']);$i++){
        $expire_type =  $rows['token_paremeterisation'][$i]['token_expire_type'] ;
        $token_expire_time =  $rows['token_paremeterisation'][$i]['token_expire_time'] ;
        $token_expire_time = ($expire_type==="Days") ?  $token_expire_time / 24 / 60 :  $token_expire_time / 60;
        $rows['token_paremeterisation'][$i]['token_expire_time'] = $token_expire_time ;
        }
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


    } catch(\Exception $exc){
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

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //

        try {
            $method = 'Method => General_registation => storedata';
            $inputArray = $request->requestData;
            $this->WriteFileLog( $inputArray);
  
            $input = [
                'token_expire_time' => $inputArray['token_expire_time'],
                'token_process' => $inputArray['token_process'],
                'token_expire_type' => $inputArray['token_expire_type'],
                'user_id' => $inputArray['user_id'],
               
            ];
            
            $email_check = DB::select("select * from token_paremeterisation where active_flag = '0' and token_process='".$inputArray['token_process']."'");
            // $this->WriteFileLog(json_encode($email_check) );
            if (json_encode($email_check) == '[]') { 
        
        
        
                DB::transaction(function() use($input) {
                    $role_id = DB::table('token_paremeterisation')
                    ->insertGetId([
                        'token_expire_time' => $input['token_expire_time'],
                        'token_process' => $input['token_process'],
                        'token_expire_type' => $input['token_expire_type'],
                        'active_flag' => 0,
                        'created_at' => NOW(),
                    ]);
     
                    $this->auditLog('token_expire', $role_id , 'Create', 'Create uam role', auth()->user()->id, NOW(),'');
        
                });
                $this->WriteFileLog('c');
                $serviceResponse = array();
                $serviceResponse['Code'] = config('setting.status_code.success');
                $serviceResponse['Message'] = config('setting.status_message.success');
                $serviceResponse['Data'] = 1;
                $serviceResponse = json_encode($serviceResponse, JSON_FORCE_OBJECT);
                $sendServiceResponse = $this->SendServiceResponse($serviceResponse, config('setting.status_code.success'), true);
                return $sendServiceResponse;
        
            }
        
            else{
              $this->WriteFileLog('a');
             $serviceResponse = array();
             $serviceResponse['Code'] = 400;
             $serviceResponse['Message'] = config('setting.status_message.success');
             $serviceResponse['Data'] = 1;
             $serviceResponse = json_encode($serviceResponse, JSON_FORCE_OBJECT);
             $sendServiceResponse = $this->SendServiceResponse($serviceResponse, config('setting.status_code.success'), true);
             return $sendServiceResponse;
        
         }
        
        } catch(\Exception $exc){
          $this->WriteFileLog('b');
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
        try{
    
            $method = 'Method => questionmastercontroller => data_edit';
            $this->WriteFileLog($method);
    
    
            $id = $this->decryptData($id);
    
            $rows = DB::table('token_paremeterisation as a')
            ->select('a.*')
            ->where('id', $id)
            ->get();
            $expire_type =  $rows['token_paremeterisation'][0]['expire_type'] ;
            $token_expire_time =  $expire_type['token_paremeterisation'][0]['token_expire_time'] ;
            $token_expire_time = ($expire_type==="Days") ?  $token_expire_time /24/60 :  $token_expire_time / 60;
    
            $expire_type['token_paremeterisation'][0]['token_expire_time'] = $token_expire_time ;
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
    
        }catch(\Exception $exc){
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
      $method = 'Method =>  questionmastercontroller => updatedata';
      $this->WriteFileLog($method);
      $inputArray = $this->decryptData($request->requestData);
      $input = [
        'token_expire_time' => $inputArray['token_expire_time'],
        'token_process' => $inputArray['token_process'],
        'token_expire_type' => $inputArray['token_expire_type'],
        'token_parameterisation_id' => $inputArray['token_parameterisation_id']
        // 'user_id' => $inputArray['user_id'],
      ];
              
                  
  
  
     
  
  
  
      DB::transaction(function() use($input) {
  
         
  
  
       
  
  
      DB::table('token_paremeterisation')
      ->where('token_parameterisation_id', $input['token_parameterisation_id'])
      ->update([
        'token_expire_time' => $input['token_expire_time'],
        'token_process' => $input['token_process'],
        'token_expire_type' => $input['token_expire_type'],
        'updated_at' => NOW(),
         
      ]);
   
     });
  
      $serviceResponse = array();
      $serviceResponse['Code'] = config('setting.status_code.success');
      $serviceResponse['Message'] = config('setting.status_message.success');
      $serviceResponse['Data'] = 1;
      $serviceResponse = json_encode($serviceResponse, JSON_FORCE_OBJECT);
      $sendServiceResponse = $this->SendServiceResponse($serviceResponse, config('setting.status_code.success'), true);
      return $sendServiceResponse;
  
  
  
  
 
  
  
  
  } catch(\Exception $exc){
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
        try{

            $method = 'Method =>questionmastercontroller => data_delete';
            $this->WriteFileLog($method);
            $id = $this->decryptData($id);
            $this->WriteFileLog($id);
    
            
    
           
    
                DB::table('token_paremeterisation')
                ->where('token_parameterisation_id', $id)
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
    
            
        }catch(\Exception $exc){
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
}
