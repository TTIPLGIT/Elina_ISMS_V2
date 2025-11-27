<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Google\Service\CloudSearch\UserId;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;

class HomeTrackerController extends BaseController
{

    public function index(Request $request)
    {

        
      
        $permission = $this->FillScreensByUser();
        $screen_permission = $permission[0];
        // dd($screen_permission);
        
        $menus = $this->FillMenu();
        $screens = $menus['screens'];
        $modules = $menus['modules'];
        return view('hometracker.index', compact( 'modules', 'screens','screen_permission'));
        //
    }

    public function hometrackerInit(Request $request)
    {
        try {
            $method = 'Method => HomeTrackerController => hometrackerInit';
            $user_id = $request->session()->get("userID");
            if ($user_id == null) {
                return view('auth.login');
            }

            $method = 'Method => HomeTrackerController => hometrackerInit';


            $request =  array();
            $request['user_id'] = $user_id;

            $gatewayURL = config('setting.api_gateway_url') . '/hometrackerInit';
            $response = $this->serviceRequest($gatewayURL, 'GET', json_encode($request), $method);

            $response = json_decode($response);


            $menus = $this->FillMenu();

            if ($menus == "401") {
                return redirect(route('/'))->with('errors', 'User session Exipired');
            }

            if ($response->Status == 200 && $response->Success) {
                $objData = json_decode($this->decryptData($response->Data));

                if ($objData->Code == 200) {
                    $parant_data = json_decode(json_encode($objData->Data), true);
                    $rows =  $parant_data['rows'];
                  

                    
                    $screens = $menus['screens'];
                    $modules = $menus['modules'];

                    return view('hometracker.homeinitiate', compact('rows', 'screens', 'modules'));
                }
            }

       }   catch (\Exception $exc) {
            
            return $this->sendLog($method, $exc->getCode(), $exc->getMessage(), $exc->getLine(), $exc->getTrace()[0]['args'][2]);
        }

       
        //
    }

    public function ExternalAllocation(Request $request)
    {

        
        $menus = $this->FillMenu();
        $screens = $menus['screens'];
        $modules = $menus['modules'];
            return view('compass.CompassInitiate', compact('modules', 'screens'));
        
    }
    public function store(Request $request)
    {
    $status=$request->meeting_status;
           
    if($status=="sent")
    {
     
     return redirect(route('hometracker'))->with('success', 'HomeTracker Sent Successfully');

    }
    else
    { 
     // dd($status);
     return redirect(route('hometracker'))->with('success', 'HomeTracker Saved Successfully');

    }
}
    public function show($id){
    
        $menus = $this->FillMenu();
        $screens = $menus['screens'];
        $modules = $menus['modules'];
        return view('hometracker.calendar', compact('modules', 'screens'));
    }

    public function homeshow($id){
    
        $menus = $this->FillMenu();
        $screens = $menus['screens'];
        $modules = $menus['modules'];
        return view('hometracker.homeshow', compact('modules', 'screens'));
    }

    
    public function edit($id)
    {
        
        $menus = $this->FillMenu();
        $screens = $menus['screens'];
        $modules = $menus['modules'];
        return view('hometracker.homeedit', compact('modules', 'screens'));
    }
    
    public function homesentshow($id){
    
        $menus = $this->FillMenu();
        $screens = $menus['screens'];
        $modules = $menus['modules'];
        return view('hometracker.homesentshow', compact('modules', 'screens'));
    }

    public function homesentedit($id)
    {
        
        $menus = $this->FillMenu();
        $screens = $menus['screens'];
        $modules = $menus['modules'];
        return view('hometracker.homesentedit', compact('modules', 'screens'));
    }

    public function viewform($id)
    { 
        // dd("gugxjs");
        try {
            $id=$this->EncryptData($id);
            $method = 'Method => QuestionCreationController => show';
            $gatewayURL = config('setting.api_gateway_url') . '/question_creation/viewdata/' . $id;
            $response = $this->serviceRequest($gatewayURL, 'GET', '', $method);
            $response = json_decode($response);
            if ($response->Status == 200 && $response->Success) {
                $objData = json_decode($this->decryptData($response->Data));
                if ($objData->Code == 200) {
                    $parant_data = json_decode(json_encode($objData->Data), true);
                    $question =  $parant_data['question'];
                    $questionnaire_name = $parant_data['questionnaire_name'];
                    $menus = $this->FillMenu();
                    $screens = $menus['screens'];
                    $modules = $menus['modules'];
                    return view('hometracker.view', compact('questionnaire_name','screens', 'modules', 'question'));
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

    public function viewcalendar(Request $request)
    {

        $menus = $this->FillMenu();
        $screens = $menus['screens'];
        $modules = $menus['modules'];
        return view('hometracker.calendar', compact('modules', 'screens'));
        
    }
    

}