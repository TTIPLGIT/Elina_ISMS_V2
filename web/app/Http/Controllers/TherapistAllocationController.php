<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Google\Service\CloudSearch\UserId;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;

class TherapistAllocationController extends BaseController
{

    public function index(Request $request)
    {

      

        $menus = $this->FillMenu();
        $screens = $menus['screens'];
        $modules = $menus['modules'];
        return view('therapist.index', compact( 'modules', 'screens'));
        //
    }
    public function weeeklycal(Request $request)
    {
        try {
            $method = 'Method => TherapistAllocationController => weeeklycal';
            $user_id = $request->session()->get("userID");
            if ($user_id == null) {
                return view('auth.login');
            }

            $method = 'Method => TherapistAllocationController => weeeklycal';


            $request =  array();
            $request['user_id'] = $user_id;

            $gatewayURL = config('setting.api_gateway_url') . '/therapist/weeklycal';
            $response = $this->serviceRequest($gatewayURL, 'GET', json_encode($request), $method);

            $response = json_decode($response);


            $menus = $this->FillMenu();

            if ($menus == "401") {
                return redirect(url('/'))->with('errors', 'User session Exipired');
            }

            if ($response->Status == 200 && $response->Success) {
                $objData = json_decode($this->decryptData($response->Data));

                if ($objData->Code == 200) {
                    $parant_data = json_decode(json_encode($objData->Data), true);
                    $rows =  $parant_data['rows'];
                  

                    
                    $screens = $menus['screens'];
                    $modules = $menus['modules'];

                    return view('therapist.weeklycal', compact('rows', 'screens', 'modules'));
                }
            }

       }   catch (\Exception $exc) {
            
            return $this->sendLog($method, $exc->getCode(), $exc->getMessage(), $exc->getLine(), $exc->getTrace()[0]['args'][2]);
        }
 
    }
    public function TherapistInit(Request $request)
    {
        try {
            $method = 'Method => TherapistAllocationController => TherapistInit';
            $user_id = $request->session()->get("userID");
            if ($user_id == null) {
                return view('auth.login');
            }

            
            $request =  array();
            $request['user_id'] = $user_id;

            $gatewayURL = config('setting.api_gateway_url') . '/therapist/initation';
            $response = $this->serviceRequest($gatewayURL, 'GET', json_encode($request), $method);

            $response = json_decode($response);


            $menus = $this->FillMenu();

            if ($menus == "401") {
                return redirect(url('/'))->with('errors', 'User session Exipired');
            }

            if ($response->Status == 200 && $response->Success) {
                $objData = json_decode($this->decryptData($response->Data));

                if ($objData->Code == 200) {
                    $parant_data = json_decode(json_encode($objData->Data), true);
                    $rows =  $parant_data['rows'];
                  

                    
                    $screens = $menus['screens'];
                    $modules = $menus['modules'];

                    return view('therapist.therapistinitate', compact('rows', 'screens', 'modules'))->with('success', 'Session Sent Successfully');
                }
            }

       }   catch (\Exception $exc) {
            
            return $this->sendLog($method, $exc->getCode(), $exc->getMessage(), $exc->getLine(), $exc->getTrace()[0]['args'][2]);
        }

       
        //
    }

    public function Therapistspecialization(Request $request)
    {
        try {
            $method = 'Method => TherapistAllocationController => Therapistspecialization';
            $user_id = $request->session()->get("userID");
            if ($user_id == null) {
                return view('auth.login');
            }
            $Specialization=$request->Specialization;
            
            $request =  array();
            $request['user_id'] = $user_id;
            $request['Specialization'] = $Specialization;
            $this->WriteFileLog( $Specialization);

            //$this->WriteFileLog("bjbx");
            $gatewayURL = config('setting.api_gateway_url') . '/therapist/specialization';
            $this->WriteFileLog($gatewayURL);
            $response = $this->serviceRequest($gatewayURL, 'POST', json_encode($request), $method);
            $this->WriteFileLog($response);
            $response = json_decode($response);
            $this->WriteFileLog(json_encode($response));


            
            
          
            $menus = $this->FillMenu();

            if ($menus == "401") {
                return redirect(url('/'))->with('errors', 'User session Exipired');
            }


            if ($response->Status == 200 && $response->Success) {
                $objData = json_decode($this->decryptData($response->Data));

                if ($objData->Code == 200) {
                    $parant_data = json_decode(json_encode($objData->Data), true);
                    $rows =  $parant_data['rows'];
                    $this->WriteFileLog( $rows);
                    return $rows;     
                   

                }
            }

       }  
        catch (\Exception $exc) {
            
            return $this->sendLog($method, $exc->getCode(), $exc->getMessage(), $exc->getLine(), $exc->getTrace()[0]['args'][2]);
        }
    
       
        //
    }
    public function TherapistWeeklyShow($id)
    {

        
        $menus = $this->FillMenu();
        $screens = $menus['screens'];
        $modules = $menus['modules'];
         return view('therapist.therapistweeklyshow', compact('modules', 'screens'));
        
    }
    public function TherapistWeeklyedit($id)
    {

        
        $menus = $this->FillMenu();
        $screens = $menus['screens'];
        $modules = $menus['modules'];
       return view('therapist.therapistweeklyedit', compact('modules', 'screens'));
        
    }
    public function TherapistWeeklyupdate(Request $request, $id)
    {
        return redirect(route('compassmeeting'))
                        ->with('success', 'Session Allocated Updated Successfully');

    }

    

    public function ExternalAllocation(Request $request)
    {

        
        $menus = $this->FillMenu();
        $screens = $menus['screens'];
        $modules = $menus['modules'];
            return view('compass.CompassInitiate', compact('modules', 'screens'));
        
    }

    public function TherapistList(Request $request)
    {
        $menus = $this->FillMenu();
        $screens = $menus['screens'];
        $modules = $menus['modules'];
        return view('therapist.therapistlist', compact( 'modules', 'screens'));
       
    
    }
   
    public function TherapistListShow($id)
    {

        
        $menus = $this->FillMenu();
        $screens = $menus['screens'];
        $modules = $menus['modules'];
         return view('therapist.therapistlistShow', compact('modules', 'screens'));
        
    }

    public function TherapistdetailsList(Request $request)
    {
        $menus = $this->FillMenu();
        $screens = $menus['screens'];
        $modules = $menus['modules'];
        return view('therapist.therapistdetailslist', compact( 'modules', 'screens'));
       
    
    }

    public function TherapistdetailsListShow($id)
    {

        
        $menus = $this->FillMenu();
        $screens = $menus['screens'];
        $modules = $menus['modules'];
            return view('therapist.therapistdetailslistShow', compact('modules', 'screens'));
        
    }
    public function TherapistdetailsListedit($id)
    {

        
        $menus = $this->FillMenu();
        $screens = $menus['screens'];
        $modules = $menus['modules'];
            return view('therapist.therapistdetailsedit', compact('modules', 'screens'));
        
    }
    public function TherapistdetailsListupdate(Request $request)
    {
        
            return redirect(route('TherapistdetailsList'))->with('success', 'Therapist details Updated Successfully');

        

    }
    public function progressstatus(Request $request)
    {
        $menus = $this->FillMenu();
        $screens = $menus['screens'];
        $modules = $menus['modules'];
        $rows= [];
     return view('therapist.progressstatuslist', compact( 'modules', 'screens','rows'));
       
    
    }
    public function Parentsreviewinvite(Request $request)
    {
        try {
            $method = 'Method => TherapistAllocationController => Parentsreviewinvite';
            $user_id = $request->session()->get("userID");
            if ($user_id == null) {
                return view('auth.login');
            }
          

            $request =  array();
            $request['user_id'] = $user_id;

            $gatewayURL = config('setting.api_gateway_url') . '/parents/review/invite';
            $response = $this->serviceRequest($gatewayURL, 'GET', json_encode($request), $method);

            $response = json_decode($response);
            //dd( $response);

            $menus = $this->FillMenu();

            if ($menus == "401") {
                return redirect(url('/'))->with('errors', 'User session Exipired');
            }

            if ($response->Status == 200 && $response->Success) {
                $objData = json_decode($this->decryptData($response->Data));

                if ($objData->Code == 200) {
                    $parant_data = json_decode(json_encode($objData->Data), true);
                    $rows =  $parant_data['rows'];
                    //dd($rows);
                    

                    
                    $screens = $menus['screens'];
                    $modules = $menus['modules'];

                    return view('therapist.parentsreviewmeeting', compact( 'rows', 'screens', 'modules'));
                }
            }

       }   catch (\Exception $exc) {
            
            return $this->sendLog($method, $exc->getCode(), $exc->getMessage(), $exc->getLine(), $exc->getTrace()[0]['args'][2]);
        }
    
    }
    public function Therapistreviewinvite(Request $request)
    {
        try {
            $method = 'Method => TherapistAllocationController => Therapistreviewinvite';
            $user_id = $request->session()->get("userID");
            if ($user_id == null) {
                return view('auth.login');
            }

            $method = 'Method => TherapistAllocationController => Therapistreviewinvite';


            $request =  array();
            $request['user_id'] = $user_id;

            $gatewayURL = config('setting.api_gateway_url') . '/therapist/review/invite';
            $response = $this->serviceRequest($gatewayURL, 'GET', json_encode($request), $method);

            $response = json_decode($response);
            //dd( $response);

            $menus = $this->FillMenu();

            if ($menus == "401") {
                return redirect(url('/'))->with('errors', 'User session Exipired');
            }

            if ($response->Status == 200 && $response->Success) {
                $objData = json_decode($this->decryptData($response->Data));

                if ($objData->Code == 200) {
                    $parant_data = json_decode(json_encode($objData->Data), true);
                    $rows =  $parant_data['rows'];
                    //dd($rows);
                    

                    
                    $screens = $menus['screens'];
                    $modules = $menus['modules'];

                    return view('therapist.reviewmeetinginvite', compact( 'rows', 'screens', 'modules'));
                }
            }

       }   catch (\Exception $exc) {
            
            return $this->sendLog($method, $exc->getCode(), $exc->getMessage(), $exc->getLine(), $exc->getTrace()[0]['args'][2]);
        }
        
        
    
    }

    public function Therapistspecializationreview(Request $request)
    {
        try {
            $method = 'Method => TherapistAllocationController => Therapistspecializationreview';
            $user_id = $request->session()->get("userID");
            if ($user_id == null) {
                return view('auth.login');
            }
            $Specialization=$request->Specialization;
            
            $request =  array();
            $request['user_id'] = $user_id;
            $request['Specialization'] = $Specialization;
            $this->WriteFileLog( $Specialization);

            //$this->WriteFileLog("bjbx");
            $gatewayURL = config('setting.api_gateway_url') . '/therapist/specialization';
            $this->WriteFileLog($gatewayURL);
            $response = $this->serviceRequest($gatewayURL, 'POST', json_encode($request), $method);
            $this->WriteFileLog($response);
            $response = json_decode($response);
            $this->WriteFileLog(json_encode($response));


            
            
          
            $menus = $this->FillMenu();

            if ($menus == "401") {
                return redirect(url('/'))->with('errors', 'User session Exipired');
            }


            if ($response->Status == 200 && $response->Success) {
                $objData = json_decode($this->decryptData($response->Data));

                if ($objData->Code == 200) {
                    $parant_data = json_decode(json_encode($objData->Data), true);
                    $rows =  $parant_data['rows'];
                    $this->WriteFileLog( $rows);
                    return $rows;     
                   

                }
            }

       }  
        catch (\Exception $exc) {
            
            return $this->sendLog($method, $exc->getCode(), $exc->getMessage(), $exc->getLine(), $exc->getTrace()[0]['args'][2]);
        }
    
       
        //
    }

    public function store(Request $request)
        {
           $status=$request->meeting_status;
           
           if($status=="sent")
           {
            
            return redirect(route('therapist.index'))->with('success', 'Monthly Review Meeting Sent Successfully');

           }
           else
           { 
            // dd($status);
            return redirect(route('therapist.index'))->with('success', 'Monthly Review Meeting Saved Successfully');

           }
    }


}