<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Log;
use Redirect;
use PHPJasper\PHPJasper;
use Session;



class ReportController extends BaseController
{
    //
    public function index()
{
        $permission_data = $this->FillScreensByUserScreen();
    $screen_permission = $permission_data[0];
    if(strpos($screen_permission['permissions'], 'View') !== false){
try{ 

        $user_id = '';
        $receipt_no = '';
        $received_for = '';
        $source_type = '';
        $uam_action = '';
        $workflow_action = '';
        $form_action = '';
        $department_action = '';
      
$method = 'Method => ReportController => index'; 
$gatewayURL = config('setting.api_gateway_url').'/auditlog/activity';
$response = $this->serviceRequest($gatewayURL, 'GET', '', $method); 
$response = json_decode($response);
if($response->Status == 200 && $response->Success){
$objData = json_decode($this->decryptData($response->Data));
if ($objData->Code == 200) {
$data2 = json_decode(json_encode($objData->Data), true);

$menus = $this->FillMenu();
$screens = $menus['screens'];
$modules = $menus['modules'];
return view('auditlog.login.activity_details', compact('modules','screens','receipt_no','user_id','received_for','source_type','uam_action','workflow_action','form_action','data2','department_action'));
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




    public function login_index()
    {
        try {

            $user_id = '';
            $from_date = '';
            $to_date = '';
            $method = 'Method => ReportController => index';
            $gatewayURL = config('setting.api_gateway_url') . '/auditlog/login_report';
            $response = $this->serviceRequest($gatewayURL, 'GET', '', $method);
            $response = json_decode($response);
            if ($response->Status == 200 && $response->Success) {
                $objData = json_decode($this->decryptData($response->Data));
                $rows = json_decode(json_encode($objData->Data), true); 
               
                if ($objData->Code == 200) {
                    $data2 = json_decode(json_encode($objData->Data), true);
                    $menus = $this->FillMenu();
                    $screens = $menus['screens'];
                    $modules = $menus['modules'];
                    return view('auditlog/login.index', compact('modules','rows', 'screens', 'from_date', 'user_id', 'to_date', 'data2'));
                }
            } else {
                $objData = json_decode($this->decryptData($response->Data));
                echo json_encode($objData->Code);
                exit;
            }
        } catch (\Exception $exc) {
            
            return $this->sendLog($method, $exc->getCode(), $exc->getMessage(), $exc->getLine(), $exc->getTrace()[0]['args'][2]);
        }
    }
    public function search(Request $request)
    {
        
		$logMethod = 'Method => ReportController => search';
        try { 
                 
            $user_id = $request->user_id;
           
            $receipt_no = $request->receipt_no;
              // echo json_encode($receipt_no);exit;
            $received_for = $request->received_for;
            $source_type = $request->source_type;
            $uam_action = $request->uam_action;
            $workflow_action = $request->workflow_action;
            $form_action = $request->form_action;
            $department_action = $request->department_action;


           
            if (empty($user_id) && empty($receipt_no)  && empty($received_for) && empty($source_type) && empty($uam_action) && empty($workflow_action) && empty($form_action) && empty($department_action)) {

            	// echo "kjh";exit;
            	
				return redirect(route('auditlog.login.activity_details1'))->with('error', 'No Input for Search');
            }
            $gatewayURL = config('setting.api_gateway_url').'/auditlog/activity';
            // echo $gatewayURL;exit;
            $data = array();
            $data['user_id'] = $user_id;
            $data['receipt_no'] = $receipt_no;
            $data['received_for'] = $received_for;
            $data['source_type'] = $source_type;
            $data['uam_action'] = $uam_action;
            $data['workflow_action'] = $workflow_action;
            $data['form_action'] = $form_action;
            $data['department_action'] = $department_action;


           
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
                	return view('auditlog.login.activity_details', compact('modules','screens','receipt_no','user_id','received_for','source_type','uam_action','workflow_action','form_action','data2','department_action'));
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


public function login_search(Request $request)
    {   
        $logMethod = 'Method => ReportController => login_search';
        try { 
                 
            $user_id = $request->user_id;

            $from_date = $request->from_date;
              // echo json_encode($receipt_no);exit;
            $to_date = $request->to_date;
           
           
           
            if (empty($user_id) && empty($from_date)  && empty($to_date)) {

                // echo "kjh";exit;
                
                return redirect(route('auditlog.login_report'))->with('error', 'No Input for Search');
            }
            $gatewayURL = config('setting.api_gateway_url').'/auditlog/login_report';
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
                    return view('reports.login_details', compact('modules','screens','from_date','user_id','to_date','data2'));
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


    public function report1($id)
    {

      $user_id=json_encode(Session::get('userID'));
      // $user_id=json_encode(Session::get('userID'));
      // echo $user_id;exit;
        //echo "string";exit();
        //echo json_encode($id); exit;

        $documentName = 'report1';
        $input = base_path().'/reports/report1.jasper';
        //$input = 'C:\xampp\htdocs\jasperreport\storage\app\public\reports/userreport.jasper';
        $output = storage_path().'/app/output/'.$documentName;
        $storage_path = storage_path().'/app/output/';
        $report_path = base_path().'/reports';

       

        $options = [ 
            'format' => ['pdf'] ,
            'locale' => 'en',
            'params' => [
              
                  'id' => $id,
                  'user_id'=>$user_id,
                
            ],
            'db_connection' => [
                'driver' => 'mysql',
                'username' => config('setting.db_username'),
                'password' => config('setting.db_password'),
                'host' => '127.0.0.1',
                'database' => config('setting.db_database'),
                'port' => config('setting.db_port'),
            ]
        ];
         
        $jasper = new PHPJasper;
        //echo json_encode($output); exit;
         //echo json_encode($options); exit;
        $jasper->process(
            $input,
            $output,
            $options
        )->execute();
        
        $documentName = 'report1.pdf';
        $headers = array(
          'Content-Type: application/pdf',
      );
        return response()->download($storage_path.'/'.$documentName, $documentName, $headers);

            
        
    }

    public function get_Consent_form_child($id)
    {

      $user_id=json_encode(Session::get('userID'));
      // $user_id=json_encode(Session::get('userID'));
      // echo $user_id;exit;
        //echo "string";exit();
        //echo json_encode($id); exit;

        $documentName = 'get_Consent_form_child';
        $input = base_path().'/reports/Consent_form_child.jasper';
        //$input = 'C:\xampp\htdocs\jasperreport\storage\app\public\reports/userreport.jasper';
        $output = storage_path().'/app/output/'.$documentName;
        $storage_path = storage_path().'/app/output/';
        $report_path = base_path().'/reports';

       

        $options = [ 
            'format' => ['pdf'] ,
            'locale' => 'en',
        

            'db_connection' => [
                'driver' => 'mysql',
                'username' => config('setting.db_username'),
                'password' => config('setting.db_password'),
                'host' => '127.0.0.1',
                'database' => config('setting.db_database'),
                'port' => config('setting.db_port'),
            ]
        ];
         
        $jasper = new PHPJasper;
        //echo json_encode($output); exit;
         //echo json_encode($options); exit;
        $jasper->process(
            $input,
            $output,
            $options
        )->execute();
        
        $documentName = 'Consent_form_child.pdf';
        $headers = array(
          'Content-Type: application/pdf',
      );
        return response()->download($storage_path.'/'.$documentName, $documentName, $headers);

            
        
    }



}


