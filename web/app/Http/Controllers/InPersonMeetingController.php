<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class InPersonMeetingController extends BaseController
{
    public function index(Request $request)
    {
        $method = 'Method => InPersonMeetingController => index';
        $gatewayURL = config('setting.api_gateway_url') . '/inperson/meeting/index';
        $response = $this->serviceRequest($gatewayURL, 'GET',  '', $method);
        $response = json_decode($response);

        $objData = json_decode($this->decryptData($response->Data));

        $rows = json_decode(json_encode($objData->Data), true);
        $saveAlert = $rows['saveAlert'];
        $attendee = $rows['attendee']; //dd($attendee);

        $attendeecount = count($attendee);
        $arr = array();
        for ($i = 0; $i < $attendeecount; $i++) {
            array_push($arr, $attendee[$i]['ovm_id']);
        }

        $attendeeStatus = $rows['attendeeStatus'];
        $log = $rows['log'];
        $rows = $rows['rows'];

        $count = count($rows);
        for ($i = 0; $i < $count; $i++) {
            $rows[$i]['is_coordinator1'] = json_decode($rows[$i]['is_coordinator1'], true);
        }

        $menus = $this->FillMenu();
        $screens = $menus['screens'];
        $modules = $menus['modules'];
        $user_id = $request->session()->get("userID");

        return view('inperson_meeting.index', compact('arr', 'attendee', 'attendeeStatus', 'log', 'saveAlert', 'menus', 'screens', 'modules', 'rows', 'user_id'));
    }

    public function create()
    {
        try {
            $method = 'Method => InPersonMeetingController => create';

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
            return $this->sendlog($method, $exc->getcode(), $exc->getmessage(), $exc->getline(), $exc->gettrace()[0]['args'][2]);
            return $this->sendLog($method, $exc->getCode(), $exc->getMessage(), $exc->getLine(), $exc->getTrace()[0]['args'][2]);
        }
    }

    public function store(Request $request)
    {
        try {
            // dd($request);
            $method = 'Method => InPersonMeetingController => store';
            $alert = $request->child_name;
            $alert1 = $request->meeting_startdate . ' at ' . $request->meeting_starttime;
            $type = $request->meeting_status;
            $data = array();
            $data['enrollment_child_num'] = $request->enrollment_child_num;
            $data['enrollment_id'] = $request->enrollment_id;
            $data['child_id'] = $request->child_id;
            $data['child_name'] = $request->child_name;
            $data['meeting_to'] = $request->meeting_to;
            $data['meeting_subject'] = $request->meeting_subject;
            $data['meeting_startdate'] = $request->meeting_startdate;
            $data['meeting_enddate'] = $request->meeting_enddate;
            $data['meeting_starttime'] = $request->meeting_starttime;
            $data['meeting_endtime'] = $request->meeting_endtime;
            $data['meeting_location'] = $request->meeting_location;
            $data['meeting_description'] = $request->meeting_description;
            $data['is_coordinator1'] = $request->is_coordinator1;
            $data['is_coordinator2'] = $request->is_coordinator2;
            $data['meeting_status'] = $request->meeting_status;
            $data['type'] = $request->meeting_status;
            $data['mail_cc'] = $request->mail_cc;
            $data['user_id'] = $request->user_id;
            $data['meeting_mode'] = $request->meeting_mode;
            // dd($data);
            $encryptArray = $this->encryptData($data);
            $request = array();
            $request['requestData'] = $encryptArray;
            $gatewayURL = config('setting.api_gateway_url') . '/inperson/meeting/store';
            $response = $this->serviceRequest($gatewayURL, 'POST', json_encode($request), $method);
            $response1 = json_decode($response);
            if ($response1->Status == 200 && $response1->Success) {
                $objData = json_decode($this->decryptData($response1->Data));


                if ($objData->Code == 200) {
                    if ($type == 'Sent') {
                        return redirect(route('inperson_meeting.index'))->with('success', 'F2F Meeting Scheduled Successfully');
                    } elseif ($type == 'Reschedule') {
                        return redirect(route('inperson_meeting.index'))->with('success', 'F2F Meeting has been Rescheduled on ' . $alert1);
                    } elseif ($type == 'Completed') {
                        return redirect(route('inperson_meeting.index'))->with('success', 'F2F Meeting has been Completed for ' . $alert);
                    } elseif ($type == 'Declined') {
                        return redirect(route('inperson_meeting.index'))->with('success', 'F2F Meeting ' . $alert . ' has been declined');
                    } else {
                        return redirect(route('inperson_meeting.index'))->with('success', 'F2F Meeting has been Updated for ' . $alert);
                    }
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
            return $this->sendlog($method, $exc->getcode(), $exc->getmessage(), $exc->getline(), $exc->gettrace()[0]['args'][2]);
            return $this->sendLog($method, $exc->getCode(), $exc->getMessage(), $exc->getLine(), $exc->getTrace()[0]['args'][2]);
        }
    }

    public function GetSailDetails(Request $request)
    {
        $method = 'Method => InPersonMeetingController => GetSailDetails';
        try {
            $enrollment_id = $request->enrollment_id;
            $request = array();
            $request['requestData'] = $enrollment_id;
            $gatewayURL = config('setting.api_gateway_url') . '/get/sail/details';
            $serviceResponse = $this->serviceRequest($gatewayURL, 'POST', json_encode($request), $method);

            $serviceResponse = json_decode($serviceResponse);
            if ($serviceResponse->Status == 200 && $serviceResponse->Success) {
                $objData = json_decode($this->decryptData($serviceResponse->Data));
                if ($objData->Code == 200) {
                    $rows = json_decode(json_encode($objData->Data), true);
                    return $rows;
                    echo json_encode($rows);
                }
            }
        } catch (\Exception $exc) {
            $exceptionResponse = array();
            $exceptionResponse['ServiceMethod'] = $method;
            $exceptionResponse['Exception'] = $exc->getMessage();
            $exceptionResponse = json_encode($exceptionResponse, JSON_FORCE_OBJECT);
            $this->WriteFileLog($exceptionResponse);
        }
    }

    public function SentMeeting($id)
    {
        try {
            $method = 'Method => InPersonMeetingController => SentMeeting';

            $gatewayURL = config('setting.api_gateway_url') . '/inperson/meeting/data_edit/' . $id;

            $response = $this->serviceRequest($gatewayURL, 'GET', '', $method);
            $response = json_decode($response);

            if ($response->Status == 200 && $response->Success) {
                $objData = json_decode($this->decryptData($response->Data));
                if ($objData->Code == 200) {
                    $parant_data = json_decode(json_encode($objData->Data), true);
                    $attendee = $parant_data['attendee'];
                    $attendeeID = [];
                    foreach ($attendee as $attendees) {
                        array_push($attendeeID, $attendees['attendee']);
                    }
                    $users = $parant_data['users'];
                    $rows = $parant_data['rows'];
                    $cc = explode(",", $rows[0]['mail_cc']);
                    $authID = session()->get("userID");
                    $rows[0]['is_coordinator1'] = json_decode($rows[0]['is_coordinator1'], true);
                    $rows[0]['is_coordinator2'] = json_decode($rows[0]['is_coordinator2'], true);
                    $menus = $this->FillMenu();
                    $screens = $menus['screens'];
                    $modules = $menus['modules'];
                    return view('inperson_meeting.SentMeeting', compact('attendeeID', 'cc', 'users', 'attendee', 'rows', 'authID', 'screens', 'modules'));
                }
            } else {
                $objData = json_decode($this->decryptData($response->Data));
                if ($objData->Code == "401") {
                    return redirect(url('/'))->with('danger', 'User session Exipired');
                }
                echo json_encode($objData->Code);
                exit;
            }
        } catch (\Exception $exc) {
            return $this->sendlog($method, $exc->getcode(), $exc->getmessage(), $exc->getline(), $exc->gettrace()[0]['args'][2]);
            return $this->sendLog($method, $exc->getCode(), $exc->getMessage(), $exc->getLine(), $exc->getTrace()[0]['args'][2]);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $user_id = $request->session()->get("userID");
            $method = 'Method =>  inperson_meetingController => update_data';
            $alert = $request->child_name;
            $alert1 = $request->meeting_startdate . ' at ' . $request->meeting_starttime;
            $type = $request->meeting_status;
            $data = array();
            $data['id'] = $id;
            $data['enrollment_id'] = $request->enrollment_id;
            $data['enrollment_child_num'] = $request->enrollment_id;
            $data['meeting_unique'] = $request->meeting_unique;
            $data['child_id'] = $request->child_id;
            $data['child_name'] = $request->child_name;
            $data['meeting_to'] = $request->meeting_to;
            $data['meeting_subject'] = $request->meeting_subject;
            $data['meeting_startdate'] = $request->meeting_startdate;
            $data['meeting_enddate'] = $request->meeting_enddate;
            $data['meeting_location'] = $request->meeting_location;
            $data['meeting_description'] = $request->meeting_description;
            $data['meeting_status'] = $request->meeting_status;
            $data['meeting_starttime'] = $request->meeting_starttime;
            $data['meeting_endtime'] = $request->meeting_endtime;
            $data['is_coordinator1'] = $request->is_coordinator1;
            $data['is_coordinator2'] = $request->is_coordinator2;
            $data['video_link'] = $request->video_link;
            $data['meeting_mode'] = $request->meeting_mode;
            // $data['meeting_status'] =  ($request->type == 'Sent') ? $request->type : $request->meeting_status;
            // $data['type'] =  ($request->type == 'Sent') ? $request->type : $request->meeting_status;
            $data['type'] = $request->type;
            $data['user_id'] = $user_id;
            $data['notes'] = $request->notes;
            $data['mail_cc'] = $request->mail_cc;
            // dd($data);
            $encryptArray = $this->encryptData($data);
            $request = array();
            $request['requestData'] = $encryptArray;
            $gatewayURL = config('setting.api_gateway_url') . '/inperson/meeting/updatedata';
            $response = $this->serviceRequest($gatewayURL, 'POST', json_encode($request), $method);
            $response1 = json_decode($response);

            if ($response1->Status == 200 && $response1->Success) {

                $objData = json_decode($this->decryptData($response1->Data));

                if ($objData->Code == 200) {
                    if ($type == 'Sent') {
                        return redirect(route('inperson_meeting.index'))->with('success', 'F2F Meeting Scheduled Successfully');
                    } elseif ($type == 'Reschedule') {
                        return redirect(route('inperson_meeting.index'))->with('success', 'F2F Meeting has been Rescheduled on ' . $alert1);
                    } elseif ($type == 'Completed') {
                        return redirect(route('inperson_meeting.index'))->with('success', 'F2F Meeting has been Completed for ' . $alert);
                    } elseif ($type == 'Declined') {
                        return redirect(route('inperson_meeting.index'))->with('success', 'F2F Meeting ' . $alert . ' has been declined');
                    } else {
                        return redirect(route('inperson_meeting.index'))->with('success', 'F2F Meeting has been Updated for ' . $alert);
                    }
                }
                if ($objData->Code == 400) {
                    return Redirect::back()->with('fail', 'Meeting Invite Already Updated');
                }
            } else {
                $objData = json_decode($this->decryptData($response1->Data));
                if ($objData->Code == "401") {
                    return redirect(route('/'))->with('danger', 'User session Exipired');
                }
                echo json_encode($objData->Code);
                exit;
            }
        } catch (\Exception $exc) {
            return $this->sendLog($method, $exc->getCode(), $exc->getMessage(), $exc->getLine(), $exc->getTrace()[0]['args'][2]);
        }
    }

    public function show($id)
    {
        try {
            $method = 'Method => InPersonMeetingController => SentMeeting';

            $gatewayURL = config('setting.api_gateway_url') . '/inperson/meeting/data_edit/' . $id;

            $response = $this->serviceRequest($gatewayURL, 'GET', '', $method);
            $response = json_decode($response);

            if ($response->Status == 200 && $response->Success) {
                $objData = json_decode($this->decryptData($response->Data));
                if ($objData->Code == 200) {
                    $parant_data = json_decode(json_encode($objData->Data), true);
                    $attendee = $parant_data['attendee'];
                    $attendeeID = [];
                    foreach ($attendee as $attendees) {
                        array_push($attendeeID, $attendees['attendee']);
                    }
                    $users = $parant_data['users'];
                    $rows = $parant_data['rows'];
                    $cc = explode(",", $rows[0]['mail_cc']);
                    $authID = session()->get("userID");
                    $rows[0]['is_coordinator1'] = json_decode($rows[0]['is_coordinator1'], true);
                    $rows[0]['is_coordinator2'] = json_decode($rows[0]['is_coordinator2'], true);
                    $menus = $this->FillMenu();
                    $screens = $menus['screens'];
                    $modules = $menus['modules'];
                    return view('inperson_meeting.show', compact('attendeeID', 'cc', 'users', 'attendee', 'rows', 'authID', 'screens', 'modules'));
                }
            } else {
                $objData = json_decode($this->decryptData($response->Data));
                if ($objData->Code == "401") {
                    return redirect(url('/'))->with('danger', 'User session Exipired');
                }
                echo json_encode($objData->Code);
                exit;
            }
        } catch (\Exception $exc) {
            return $this->sendlog($method, $exc->getcode(), $exc->getmessage(), $exc->getline(), $exc->gettrace()[0]['args'][2]);
            return $this->sendLog($method, $exc->getCode(), $exc->getMessage(), $exc->getLine(), $exc->getTrace()[0]['args'][2]);
        }
    }
}
