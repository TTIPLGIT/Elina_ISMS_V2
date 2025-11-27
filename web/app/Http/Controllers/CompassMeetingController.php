<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Google\Service\CloudSearch\UserId;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;


class CompassMeetingController extends BaseController
{

    public function index(Request $request)
    {

      

        $menus = $this->FillMenu();
        $screens = $menus['screens'];
        $modules = $menus['modules'];
        return view('compass.meetingindex', compact( 'modules', 'screens'));
        //
    }

    public function CompassNewmeetinginvite(Request $request)
    {

        try {
            $method = 'Method => CompassMeetingController => NewMeetingInvite';
            $user_id = $request->session()->get("userID");
            if ($user_id == null) {
                return view('auth.login');
            }

            $method = 'Method => CompassMeetingController => CompassNewmeetinginvite';


            $request =  array();
            $request['user_id'] = $user_id;

            $gatewayURL = config('setting.api_gateway_url') . '/CompassNewmeetinginvite';
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

                    return view('compass.Newmeetinginvite', compact( 'rows', 'screens', 'modules'));
                }
            }

       }   catch (\Exception $exc) {
            
            return $this->sendLog($method, $exc->getCode(), $exc->getMessage(), $exc->getLine(), $exc->getTrace()[0]['args'][2]);
        }
        
        
    }
    public function store(Request $request)
        {
           $status=$request->meeting_status;
           
           if($status=="sent")
           {
            
            return redirect(route('compassmeeting'))->with('success', 'Orientation Meeting Sent Successfully');

           }
           else
           { 
            // dd($status);
            return redirect(route('compassmeeting'))->with('success', 'Orientation Meeting Saved Successfully');

           }
    }

    public function show($id)
    {

        
        $menus = $this->FillMenu();
        $screens = $menus['screens'];
        $modules = $menus['modules'];
            return view('compass.meetingshow', compact('modules', 'screens'));
        
    }
    public function edit($id)
    {

        
        $menus = $this->FillMenu();
        $screens = $menus['screens'];
        $modules = $menus['modules'];
            return view('compass.meetingedit', compact('modules', 'screens'));
        
    }
    public function update(Request $request, $id)
    {
        return redirect(route('compassmeeting'))
                        ->with('success', 'Meeting Invite Updated Successfully');

    }

    public function Therapistspecialization(Request $request)
    {
        try {
            $method = 'Method => CompassMeetingController => Therapistspecialization';
            $user_id = $request->session()->get("userID");
            if ($user_id == null) {
                return view('auth.login');
            }
            $Specialization=$request->Specialization;
            
            $request =  array();
            $request['user_id'] = $user_id;
            $request['Specialization'] = $Specialization;
            $this->WriteFileLog("bjbx");
            $gatewayURL = config('setting.api_gateway_url') . '/compassmeeting/therapist/specialization';
           // $this->WriteFileLog($gatewayURL);
            $response = $this->serviceRequest($gatewayURL, 'POST', json_encode($request), $method);
           // $this->WriteFileLog($response);
            $response = json_decode($response);
           // $this->WriteFileLog(json_encode($response));


            
            
          
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



}