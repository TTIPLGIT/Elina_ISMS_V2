<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CalendarController extends BaseController
{
    public function index()
    {
    }

    public function AvailabilityUpdate()
    {
        try {
            $method = 'Method => CalendarController => AvailabilityUpdate';

            $menus = $this->FillMenu();
            $screens = $menus['screens'];
            $modules = $menus['modules'];

            return view('calendar.availability', compact('screens', 'modules'));
            // 
            $gatewayURL = config('setting.api_gateway_url') . '/inperson/meeting/invite';
            $response = $this->serviceRequest($gatewayURL, 'GET', '', $method);

            $response = json_decode($response);
            if ($response->Status == 200 && $response->Success) {
                $objData = json_decode($this->decryptData($response->Data));

                if ($objData->Code == 200) {
                    $parant_data = json_decode(json_encode($objData->Data), true);
                    $email = $parant_data['email'];
                    $rows =  $parant_data['rows'];
                    $iscoordinators = $rows['iscoordinators'];
                    $users = $parant_data['users'];

                    $menus = $this->FillMenu();
                    $screens = $menus['screens'];
                    $modules = $menus['modules'];

                    return view('inperson_meeting.newmeeting', compact('users', 'email', 'rows', 'screens', 'modules', 'iscoordinators'));
                }
            }
        } catch (\Exception $exc) {
            
            return $this->sendLog($method, $exc->getCode(), $exc->getMessage(), $exc->getLine(), $exc->getTrace()[0]['args'][2]);
        }
    }

    public function store(Request $request)
    {
        try {
            // $array = $request->date;
            // $datesWithNo = [];
            // foreach ($array as $date => $value) {
            //     if ($value === "no") {
            //         $datesWithNo[] = $date;
            //     }
            // }

            // // Outputting the dates with "no" value
            // $unavailable = array();
            // echo "Dates with 'no' value:" . PHP_EOL;
            // foreach ($datesWithNo as $date) {
            //     array_push($unavailable, $date);
            // }

            // dd(implode(',', $unavailable));
            // dd($request);

            $method = 'Method => CalendarController => store';
            $data = array();
            $data['date'] = $request->date;
            $encryptArray = $this->encryptData($data);
            $request = array();
            $request['requestData'] = $encryptArray;
            $gatewayURL = config('setting.api_gateway_url') . '/calendar/availability/store_data';
            $response = $this->serviceRequest($gatewayURL, 'POST', json_encode($request), $method);
            $response1 = json_decode($response);
            if ($response1->Status == 200 && $response1->Success) {
                $objData = json_decode($this->decryptData($response1->Data));


                if ($objData->Code == 200) {
                    return redirect(route('inperson_meeting.index'))->with('success', 'F2F Meeting Scheduled Successfully');
                }

                if ($objData->Code == 400) {
                    return redirect(route('inperson_meeting.index'))->with('fail', 'F2F Meeting Already Scheduled');
                }
            } else {
                $objData = json_decode($this->decryptData($response1->Data));
                // echo json_encode($objData->Code);exit;;
                if ($objData->Code == 401) {

                    return redirect(url('/'))->with('error', 'User Session Expired');
                }
            }
        } catch (\Exception $exc) {
            
            return $this->sendLog($method, $exc->getCode(), $exc->getMessage(), $exc->getLine(), $exc->getTrace()[0]['args'][2]);
        }
    }

    public function show($id){
        $menus = $this->FillMenu();
        $screens = $menus['screens'];
        $modules = $menus['modules'];

        return view('calendar.event_calendar', compact('screens', 'modules'));
    }
    public function CalendarEvent(Request $request)
    {
        $menus = $this->FillMenu();
        $screens = $menus['screens'];
        $modules = $menus['modules'];

        return view('calendar.event_calendar', compact('screens', 'modules'));
    }
}
