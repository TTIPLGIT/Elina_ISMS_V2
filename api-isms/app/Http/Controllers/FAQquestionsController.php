<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use Validator;
use Illuminate\Support\Facades\DB;
use File;
use Illuminate\Support\Str;



class FAQquestionsController extends BaseController
{

   public function get_data(Request $request)
   {        
    try {$userID = auth()->user()->id;
        $this->WriteFileLog($userID);
        $method = 'Method => FAQquestionsController => get_data';
        // $rows = DB::table('faq_ans as a')
        // ->join('faq_module_name as b', 'b.id', '=', 'a.module_id')
        // ->select('b.module_name','a.module_id','a.question','a.answer','a.id as que_id','a.status')
           
        // ->toSql();
      
        $rows=DB::select('select * from faq_module_name inner join faq_ans on faq_module_name.id = faq_ans.module_id');
        
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

public function get_FAQ_questions()
{
    try {
        $method = 'Method => FAQquestionsController => get_FAQ_questions';
        $rows = DB::table('faq_module_name')
        ->select('*')
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


public function storedata(Request $request)
{
    $userID = auth()->user()->id;
    try {
        $method = 'Method => FAQquestionsController => storedata';
        $inputArray = $this->decryptData($request->requestData);
        $input = [
            'module_id' => $inputArray['module_id'],
            'question' => $inputArray['question'],
            'answer' => $inputArray['answer'],
        ];
                   //return auth()->user()->id;

        DB::transaction(function() use($input) {
            $manage_faq_id = DB::table('faq_ans')
            ->insertGetId([
                'module_id' => $input['module_id'],
                'question' => $input['question'],
                'answer' => $input['answer'],
                'user_id' => auth()->user()->id,

            ]);
    //          $role_name=DB::select("SELECT role_name FROM uam_roles AS ur
    //                 INNER JOIN users us ON (us.array_roles=ur.role_id) WHERE us.id=".auth()->user()->id);
    // $role_name_fetch=$role_name[0]->role_name;
    //         $this->auditLog('faq_questions', $manage_faq_id, 'Create', 'Create new manage FAQ', auth()->user()->id, NOW(),$role_name_fetch);
        });

// return $this->sendResponse('Success', 'Uam module update successfully.');

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



public function updatedata(Request $request)
{

  try {
    $method = 'Method => FAQquestionsController => updatedata';
    $inputArray = $this->decryptData($request->requestData);
    $input = [
            'module_id' => $inputArray['module_id'],
            'question' => $inputArray['question'],
            'answer' => $inputArray['answer'],
            'que_id' => $inputArray['que_id'],
        ];

    DB::transaction(function() use($input) {
        DB::table('faq_ans')
        ->where('id', $input['que_id'])
        ->update([
            'module_id' => $input['module_id'],
            'question' => $input['question'],
            'answer' => $input['answer'],
            'user_id' => auth()->user()->id,
            'last_modified_by' => auth()->user()->id,
            'updated_at' => NOW()
        ]);
        $role_name=DB::select("SELECT role_name FROM uam_roles AS ur
                    INNER JOIN users us ON (us.array_roles=ur.role_id) WHERE us.id=".auth()->user()->id);

    $role_name_fetch=$role_name[0]->role_name;
        $this->auditLog('faq_questions', $input['que_id'] , 'Update', 'Update Manage FAQ', auth()->user()->id, NOW(),$role_name_fetch);
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



public function data_edit($id)
{
    try{

        $method = 'Method => FAQquestionsController => data_edit';

        $id = $this->decryptData($id);
        $one_rows = DB::table('faq_ans')
        ->select('*')
        ->where('id', $id)
        ->get();

        $rows = DB::table('faq_module_name')
        ->select('*')
        ->get();


        $response = [
            'rows' => $rows,
            'one_rows' => $one_rows
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




public function data_delete($id)
{
    try{

        $method = 'Method => FAQquestionsController => data_delete';
        $id = $this->decryptData($id);

     

        

             DB::transaction(function() use($id){
               $uam_modules_id =  DB::table('faq_ans')
               ->where('id', $id)
               ->delete();                  
           });

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
}

public function update_toggle(Request $request)
{
    try{

        $method = 'Method => FAQquestionsController => update_toggle';
        $inputArray = $this->decryptData($request->requestData);
       $input = [
            'is_active' => $inputArray['is_active'],
            'f_id' => $inputArray['f_id'],
            
        ];

        
        DB::table('faq_ans')
                            
            ->where([['id', '=', $input['f_id']]])  
            ->update(['status'=> $input['is_active']]);




        $serviceResponse = array();
        $serviceResponse['Code'] = config('setting.status_code.success');
        $serviceResponse['Message'] = config('setting.status_message.success');
        $serviceResponse['Data'] = $input['is_active'];
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

}
