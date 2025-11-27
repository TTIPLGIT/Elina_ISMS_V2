<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuditlogController extends BaseController
{
    public function login_index()
{
          $permission_data = $this->FillScreensByUserScreen();
    $screen_permission = $permission_data[0];
    if(strpos($screen_permission['permissions'], 'View') !== false){
try{ 

        $user_id = '';
        $from_date = '';
        $to_date = '';
        
        


        
$method = 'Method => AuditlogController => index'; 
$gatewayURL = config('setting.api_gateway_url').'/auditlog/login';
$response = $this->serviceRequest($gatewayURL, 'GET', '', $method); 
$response = json_decode($response);
if($response->Status == 200 && $response->Success){
$objData = json_decode($this->decryptData($response->Data));
if ($objData->Code == 200) {
$data2 = json_decode(json_encode($objData->Data), true);

$menus = $this->FillMenu();
$screens = $menus['screens'];
$modules = $menus['modules'];
return view('auditlog.login.index', compact('modules','screens','from_date','user_id','to_date','data2'));
}
} 
else {
$objData = json_decode($this->decryptData($response->Data));
echo json_encode($objData->Code);exit;                            
}
}
catch(\Exception $exc){  
return $this->sendLog($method, $exc->getCode(), $exc->getMessage(), $exc->getLine(), $exc->getTrace()[0]['args'][2]);
}
}
else{
     return redirect()->route('not_allow');
}
}
public function login_search(Request $request)
    {

        $logMethod = 'Method => AuditlogController => login_search';
        try { 
                 
            $user_id = $request->user_id;

            $from_date = $request->from_date;
              // echo json_encode($receipt_no);exit;
            $to_date = $request->to_date;
           
           
            if (empty($user_id) && empty($from_date)  && empty($to_date)) {

                // echo "kjh";exit;
                
                return redirect(route('auditlog.login'))->with('error', 'No Input for Search');
            }
            $gatewayURL = config('setting.api_gateway_url').'/auditlog/login';
            // echo $gatewayURL;exit;
            $data = array();
            $data['user_id'] = $user_id;
            $data['from_date'] = $from_date;
            $data['to_date'] = $to_date;
            
           
            $encryptArray = $this->encryptData($data);
            $request = array();
            $request['requestData'] = $encryptArray;

            $response = $this->serviceRequest($gatewayURL, 'POST', json_encode($request), $logMethod);
            
            $response = json_decode($response);

            if($response->Status == 200 && $response->Success){
                $objData = json_decode($this->decryptData($response->Data));
                if ($objData->Code == 200) {
                    $data2 = json_decode(json_encode($objData->Data), true);
                    // print_r($data2['rows']);exit;
                    $menus = $this->FillMenu();
                    $screens = $menus['screens'];
                    $modules = $menus['modules'];
                    $permission = $this->FillScreensByUser();
                    $screen_permission = $permission[0];
                    return view('auditlog.login.index', compact('modules','screens','from_date','user_id','to_date','data2'));
                }                
            }
        } catch(\Exception $exc){            
            $exceptionResponse = array();
            $exceptionResponse['ServiceMethod'] = $logMethod;
            $exceptionResponse['Exception'] = $exc->getMessage();
            $exceptionResponse = json_encode($exceptionResponse, JSON_FORCE_OBJECT);
            $this->WriteFileLog($exceptionResponse);
        }
    }

}
