<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use PHPJasper\PHPJasper;
use Illuminate\Support\Facades\File;
use PDF;
use Dompdf;
use Illuminate\Support\Facades\URL;

class ovm1Controller extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index(Request $request)
    {
        

        $user_id = $request->session()->get("userID");
        $method = 'Method => LoginController => Register_screen';

        $request =  array();
        $request['user_id'] = $user_id;

        $gatewayURL = config('setting.api_gateway_url') . '/ovm1/index';
        $response = $this->serviceRequest($gatewayURL, 'GET',  json_encode($request), $method);
        $response = json_decode($response);
        // dd($response);
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
        $menus = $this->FillMenu();
        $count = count($rows);
        for ($i = 0; $i < $count; $i++) {
            $rows[$i]['is_coordinator1'] = json_decode($rows[$i]['is_coordinator1'], true);
            $rows[$i]['is_coordinator2'] = json_decode($rows[$i]['is_coordinator2'], true);
        }
        $screens = $menus['screens'];
        $modules = $menus['modules'];

        return view('ovm1.index', compact('arr', 'attendee', 'attendeeStatus', 'log', 'saveAlert', 'menus', 'screens', 'modules', 'rows', 'user_id'));



        //
    }

    public function getchilddetails(Request $request)
    {
        try {

            $id = $request->id;
            $method = 'Method => ovm1 => getchilddetails';
            $gatewayURL = config('setting.api_gateway_url') . '/ovm1/getchilddetails/' . $this->encryptData($id);
            $response = $this->serviceRequest($gatewayURL, 'GET', json_encode($request), $method);
            $response = json_decode($response);
            if ($response->Status == 200 && $response->Success) {
                $objData = json_decode($this->decryptData($response->Data));
                if ($objData->Code == 200) {
                    $parant_data = json_decode(json_encode($objData->Data), true);
                    $rows =  $parant_data['rows'];
                    return $rows;
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

    public function Newmeetinginvite(request $request)
    {

        try {
            $method = 'Method => ovm1Controller => Newmeetinginvite';
            $user_id = $request->session()->get("userID");
            $method = 'Method => ovm1Controller => meetinginvite';


            $request =  array();
            $request['user_id'] = $user_id;

            $gatewayURL = config('setting.api_gateway_url') . '/ovm1/meetinginvite';
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
                    $email = $parant_data['email'];
                   
                    $rows =  $parant_data['rows'];
                    $iscoordinators = $rows['iscoordinators'];
                    $users = $parant_data['users'];
                    $default_cc = $parant_data['default_cc'];


                    $screens = $menus['screens'];
                    $modules = $menus['modules'];

                    return view('ovm1.newmeetinginvite', compact('default_cc','user_id', 'users', 'email', 'rows', 'screens', 'modules', 'iscoordinators'));
                }
            }
        } catch (\Exception $exc) {

            return $this->sendLog($method, $exc->getCode(), $exc->getMessage(), $exc->getLine(), $exc->getTrace()[0]['args'][2]);
        }


        //
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {


        try {
            $method = 'Method => ovm1Controller => create';
            $gatewayURL = config('setting.api_gateway_url') . '/ovm1/create';
            $response = $this->serviceRequest($gatewayURL, 'GET', '', $method);

            $response = json_decode($response);

            if ($response->Status == 200 && $response->Success) {
                $objData = json_decode($this->decryptData($response->Data));

                if ($objData->Code == 200) {
                    $parant_data = json_decode(json_encode($objData->Data), true);
                    $rows =  $parant_data['rows'];

                    $menus = $this->FillMenu();
                    $screens = $menus['screens'];
                    $modules = $menus['modules'];
                    return view('ovm1.create', compact('rows', 'screens', 'modules', 'rows'));
                }
            } else {
                $objData = json_decode($this->decryptData($response->Data));
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


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            // dd($request);
            $user_id = $request->session()->get("userID");
            $originalTime = $request->meeting_starttime;
            $originalTime = date('h:i A', strtotime($originalTime));
            $alert = $request->child_name . ' on ' . $request->meeting_startdate . ' at ' . $originalTime;
            $type = $request->meeting_status;
            $method = 'Method => ovm1Controller => store';
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
            $data['user_id'] = $user_id;
            $data['mail_cc'] = $request->mail_cc;

            $data['g2form_url'] = URL::signedRoute('g2form.signed', ['id' => encrypt($request->user_id)]);
            //    dd($data);
            $encryptArray = $this->encryptData($data);
            $request = array();
            $request['requestData'] = $encryptArray;
            $gatewayURL = config('setting.api_gateway_url') . '/ovm1/store';
            $response = $this->serviceRequest($gatewayURL, 'POST', json_encode($request), $method);
            // dd($response);
            $response1 = json_decode($response);
            if ($response1->Status == 200 && $response1->Success) {
                $objData = json_decode($this->decryptData($response1->Data));


                if ($objData->Code == 200) {
                    if ($type == 'Sent') {
                        return redirect(route('ovm1.index'))->with('success', 'OVM-1 Meeting Scheduled Successfully for ' . $alert);
                    } elseif ($type == 'Reschedule') {
                        return redirect(route('ovm1.index'))->with('success', 'OVM-1 Meeting has been Rescheduled for ' . $alert);
                    } elseif ($type == 'Completed') {
                        return redirect(route('ovm1.index'))->with('success', 'OVM-1 Meeting has been Completed for ' . $alert);
                    } elseif ($type == 'Declined') {
                        return redirect(route('ovm1.index'))->with('success', 'OVM-1 Meeting ' . $alert . ' has been declined');
                    } else {
                        return redirect(route('ovm1.index'))->with('success', 'OVM-1 Meeting has been Updated for ' . $alert);
                    }
                }

                if ($objData->Code == 400) {
                    return redirect(route('ovm1.index'))->with('fail', 'OVM Meeting Already Scheduled');
                }
            } else {
                $objData = json_decode($this->decryptData($response1->Data));
                // echo json_encode($objData->Code);exit;;
                if ($objData->Code == 401) {

                    return redirect(route('/'))->with('error', 'User Session Expired');
                }
            }
        } catch (\Exception $exc) {

            return $this->sendLog($method, $exc->getCode(), $exc->getMessage(), $exc->getLine(), $exc->getTrace()[0]['args'][2]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function show($id)
    { {

            try {
                $method = 'Method => ovm1Controller => show';

                // echo json_encode($id);exit;
                $gatewayURL = config('setting.api_gateway_url') . '/ovm1/data_edit/' . $id;

                $response = $this->serviceRequest($gatewayURL, 'GET', '', $method);

                $response = json_decode($response);

                if ($response->Status == 200 && $response->Success) {
                    $objData = json_decode($this->decryptData($response->Data));
                    if ($objData->Code == 200) {
                        $parant_data = json_decode(json_encode($objData->Data), true);
                        $users = $parant_data['users'];
                        $rows = $parant_data['rows'];
                        $cc = explode(",", $rows[0]['mail_cc']);
                        $rows[0]['is_coordinator1'] = json_decode($rows[0]['is_coordinator1'], true);
                        $rows[0]['is_coordinator2'] = json_decode($rows[0]['is_coordinator2'], true);

                        $menus = $this->FillMenu();
                        $screens = $menus['screens'];
                        $modules = $menus['modules'];
                        return view('ovm1.show', compact('cc', 'rows', 'users', 'screens', 'modules'));
                    }
                } else {
                    $objData = json_decode($this->decryptData($response->Data));
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

        //

    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        try {

            $method = 'Method => ovm1Controller => edit';

            $gatewayURL = config('setting.api_gateway_url') . '/ovm1/data_edit/' . $id;

            $response = $this->serviceRequest($gatewayURL, 'GET', '', $method);
            $response = json_decode($response);

            if ($response->Status == 200 && $response->Success) {
                $objData = json_decode($this->decryptData($response->Data));
                if ($objData->Code == 200) {
                    $parant_data = json_decode(json_encode($objData->Data), true);
                    $users = $parant_data['users'];
                    $rows = $parant_data['rows'];
                    $cc = explode(",", $rows[0]['mail_cc']);
                    $iscoordinators = $parant_data['iscoordinators'];

                    $rows[0]['is_coordinator1'] = json_decode($rows[0]['is_coordinator1'], true);
                    $rows[0]['is_coordinator2'] = json_decode($rows[0]['is_coordinator2'], true);
                    $enrollment_user = $parant_data['enrollment_user'];
                    // $work_flow_row =  $parant_data['work_flow_row'];
                    $menus = $this->FillMenu();
                    $screens = $menus['screens'];
                    $modules = $menus['modules'];
                    return view('ovm1.edit', compact('cc', 'users', 'rows', 'screens', 'modules', 'iscoordinators','enrollment_user'));
                }
            } else {
                $objData = json_decode($this->decryptData($response->Data));
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

    public function ovmsent($id)
    {
        try {
            $method = 'Method => ovm1Controller => edit';

            $gatewayURL = config('setting.api_gateway_url') . '/ovm1/data_edit/' . $id;

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
                    $rows = $parant_data['rows']; //dd(explode("," , $rows[0]['mail_cc']));
                    $cc = explode(",", $rows[0]['mail_cc']);
                    $authID = session()->get("userID"); //dd($authID , $rows);

                    $rows[0]['is_coordinator1'] = json_decode($rows[0]['is_coordinator1'], true);
                    $rows[0]['is_coordinator2'] = json_decode($rows[0]['is_coordinator2'], true);
                    // $work_flow_row =  $parant_data['work_flow_row'];
                    $menus = $this->FillMenu();
                    $screens = $menus['screens'];
                    $modules = $menus['modules'];
                    if($rows[0]['meeting_status'] == "Completed")
                    {
                        return view('ovm1.show', compact('cc', 'rows', 'users', 'screens', 'modules'));

                    }
                    else
                    {
                        return view('ovm1.ovmsent', compact('attendeeID', 'cc', 'users', 'attendee', 'rows', 'authID', 'screens', 'modules'));

                    }
                }
            } else {
                $objData = json_decode($this->decryptData($response->Data));
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
    public function ovmcompleted(Request $request, $id)
    {
        try {
            $method = 'Method => ovm1Controller => ovmcompleted';

            $user_id = $request->session()->get("userID");
            $role = $request->role;
            $request =  array();
            $request['user_id'] = $user_id;
            $request['is_coordinator_id'] = $id;
            $gatewayURL = config('setting.api_gateway_url') . '/ovm1/completed_data_edit/' . $id;

            $response = $this->serviceRequest($gatewayURL, 'GET', json_encode($request), $method);
            $response = json_decode($response);

            if ($response->Status == 200 && $response->Success) {
                $objData = json_decode($this->decryptData($response->Data));
                if ($objData->Code == 200) {
                    $parant_data = json_decode(json_encode($objData->Data), true);
                    $rows = $parant_data['rows'];
                    // 
                    $rolename = $parant_data['role'];
                    $enrollment_details = $parant_data['enrollment_details'];
                    $primary_caretaker = $enrollment_details[0]['child_mother_caretaker_name'];
                    // dd($enrollment_details);
                    $group = $parant_data['group'];
                    $questions = $parant_data['questions'];
                    $fetchdata = $parant_data['fetchdata'];
                    $fetchdata1 = $parant_data['fetchdata1'];
                    $fetchdata2 = $parant_data['fetchdata2'];

                    $menus = $this->FillMenu();
                    $screens = $menus['screens'];
                    $modules = $menus['modules'];
                    $editusername = 'IS Coordinator';
                    return view('ovm1.ovmcompleted_new', compact('fetchdata2', 'fetchdata1', 'fetchdata', 'enrollment_details', 'questions', 'group', 'primary_caretaker', 'rows', 'screens', 'modules', 'editusername', 'role', 'rolename'));
                }
            } else {
                $objData = json_decode($this->decryptData($response->Data));
                if ($objData->Code == "401") {
                    return redirect(route('/'))->with('danger', 'User session Exipired');
                }
                echo json_encode($objData->Code);
                exit;
            }
        } catch (\Exception $exc) {

            return $this->sendLog($method, $exc->getCode(), $exc->getMessage(), $exc->getLine(), $exc->getTrace()[0]['args'][2]);
        }
        // // old Function

        // try {
        //     $method = 'Method => ovm1Controller => ovmcompleted';

        //     $user_id = $request->session()->get("userID");
        //     $role = $request->role;
        //     $request =  array();
        //     $request['user_id'] = $user_id;
        //     $request['is_coordinator_id'] = $id;
        //     $gatewayURL = config('setting.api_gateway_url') . '/ovm1/completed_data_edit/' . $id;

        //     $response = $this->serviceRequest($gatewayURL, 'GET', json_encode($request), $method);
        //     $response = json_decode($response);

        //     if ($response->Status == 200 && $response->Success) {
        //         $objData = json_decode($this->decryptData($response->Data));
        //         if ($objData->Code == 200) {
        //             $parant_data = json_decode(json_encode($objData->Data), true);
        //             $rows = $parant_data['rows'];
        //             $rolename = $parant_data['role'];
        //             $primary_caretaker = $parant_data['primary_caretaker'];


        //             // $work_flow_row =  $parant_data['work_flow_row'];
        //             $menus = $this->FillMenu();
        //             $screens = $menus['screens'];
        //             $modules = $menus['modules'];
        //             $editusername = 'IS Coordinator';
        //             return view('ovm1.ovmcompleted', compact('primary_caretaker', 'rows', 'screens', 'modules', 'editusername', 'role', 'rolename'));
        //         }
        //     } else {
        //         $objData = json_decode($this->decryptData($response->Data));
        //         if ($objData->Code == "401") {
        //             return redirect(route('/'))->with('danger', 'User session Exipired');
        //         }
        //         echo json_encode($objData->Code);
        //         exit;
        //     }
        // } catch (\Exception $exc) {

        //     return $this->sendLog($method, $exc->getCode(), $exc->getMessage(), $exc->getLine(), $exc->getTrace()[0]['args'][2]);
        // }
    }
    public function ovmcompletedisedit(Request $request, $id)
    {
        try {

            $method = 'Method => ovm1Controller => ovmcompletedisedit';

            $user_id = $request->session()->get("userID");
            $role = $request->role;
            $request =  array();
            $request['user_id'] = $user_id;
            $request['is_coordinator_id'] = $id;
            // dd($request);
            $gatewayURL = config('setting.api_gateway_url') . '/ovm1/completedisedit_data_edit/' . $id;

            $response = $this->serviceRequest($gatewayURL, 'GET', json_encode($request), $method);
            $response = json_decode($response);

            if ($response->Status == 200 && $response->Success) {
                $objData = json_decode($this->decryptData($response->Data));
                if ($objData->Code == 200) {
                    $parant_data = json_decode(json_encode($objData->Data), true);
                    $rows = $parant_data['rows'];
                    $rolename = $parant_data['role'];
                    $group = $parant_data['group'];
                    $questions = $parant_data['questions'];
                    $fetchdata = $parant_data['fetchdata'];
                    $fetchdata1 = $parant_data['fetchdata1'];

                    $menus = $this->FillMenu();
                    $screens = $menus['screens'];
                    $modules = $menus['modules'];
                    $editusername = 'IS Head';
                    return view('ovm1.ovmcompletededit', compact('rows', 'screens', 'modules', 'editusername', 'role', 'rolename', 'fetchdata1', 'fetchdata', 'questions', 'group'));
                }
            } else {
                $objData = json_decode($this->decryptData($response->Data));
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
    public function ovmcompleted_isedit(Request $request, $id, $meet)
    {
        //dd($request);
        try {

            $method = 'Method => ovm1Controller => ovmcompleted_isedit';

            $user_id = $request->session()->get("userID");
            $role = $request->role;
            $meet = $request->meet;
            $request =  array();
            $request['user_id'] = $user_id;
            // $request['is_coordinator_id'] = $id;

            $gatewayURL = config('setting.api_gateway_url') . '/ovm1/completed_isedit_data_edit/' . $id . '/' . $meet;

            $response = $this->serviceRequest($gatewayURL, 'GET', json_encode($request), $method);
            $response = json_decode($response);

            if ($response->Status == 200 && $response->Success) {
                $objData = json_decode($this->decryptData($response->Data));
                if ($objData->Code == 200) {
                    $parant_data = json_decode(json_encode($objData->Data), true);
                    $rows = $parant_data['rows'];
                    $rolename = $parant_data['role'];
                    $group = $parant_data['group'];
                    $questions = $parant_data['questions'];
                    $fetchdata1 = $parant_data['fetchdata1'];
                    $fetchdata = $parant_data['fetchdata'];
                    $rows1 = $parant_data['rows1'];
                    $menus = $this->FillMenu();
                    $screens = $menus['screens'];
                    $modules = $menus['modules'];
                    $editusername = 'IS Head';
                    return view('ovm1.ovmcompleted_edit', compact('rows', 'screens', 'modules', 'editusername', 'role', 'rolename', 'fetchdata1', 'fetchdata', 'questions', 'group','rows1'));
                }
            } else {
                $objData = json_decode($this->decryptData($response->Data));
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
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try {
            $user_id = $request->session()->get("userID");
            $method = 'Method =>  ovm1Controller => update_data';
            $originalTime = $request->meeting_starttime;
            $originalTime = date('h:i A', strtotime($originalTime));
            $alert = $request->child_name . ' on ' . $request->meeting_startdate . ' ' . $originalTime;
            $type = $request->meeting_status;
            $data = array();
            $data['id'] = $id;
            $data['enrollment_id'] = $request->enrollment_id;
            $data['enrollment_child_num'] = $request->enrollment_id;
            $data['ovm_meeting_unique'] = $request->ovm_meeting_unique;
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
            // $data['meeting_status'] =  ($request->type == 'Sent') ? $request->type : $request->meeting_status;
            // $data['type'] =  ($request->type == 'Sent') ? $request->type : $request->meeting_status;
            $data['type'] = $request->type;
            $data['user_id'] = $user_id;
            $data['notes'] = $request->notes;
            $data['mail_cc'] = $request->mail_cc;
            $data['g2form_url'] = URL::signedRoute('g2form.signed', ['id' => encrypt($request->en_user)]);
          
            $encryptArray = $this->encryptData($data);
            $request = array();
            $request['requestData'] = $encryptArray;
            $gatewayURL = config('setting.api_gateway_url') . '/ovm1/updatedata';
            $response = $this->serviceRequest($gatewayURL, 'POST', json_encode($request), $method);
            $response1 = json_decode($response);

            if ($response1->Status == 200 && $response1->Success) {

                $objData = json_decode($this->decryptData($response1->Data));

                if ($objData->Code == 200) {
                    if ($type == 'Sent') {
                        return redirect(route('ovm1.index'))->with('success', 'OVM-1 Meeting Scheduled Successfully for ' . $alert);
                    } elseif ($type == 'Reschedule') {
                        return redirect(route('ovm1.index'))->with('success', 'OVM-1 Meeting has been Rescheduled for ' . $alert);
                    } elseif ($type == 'Completed') {
                        return redirect(route('ovm1.index'))->with('success', 'OVM-1 Meeting has been Completed for ' . $alert);
                    } elseif ($type == 'Declined') {
                        return redirect(route('ovm1.index'))->with('success', 'OVM-1 Meeting ' . $alert . ' has been declined');
                    } else {
                        return redirect(route('ovm1.index'))->with('success', 'OVM-1 Meeting has been Updated for ' . $alert);
                    }
                }
                if ($objData->Code == 400) {
                    return Redirect::back()
                        ->with('fail', 'Meeting Invite Already Updated');
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

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {

        try {
            $method = 'Method => ovm1Controller => delete';
            //  $id = $this->decryptData($id);
            $gatewayURL = config('setting.api_gateway_url') . '/ovm1/data_delete/' . $id;
            $response = $this->serviceRequest($gatewayURL, 'GET', '', $method);
            $response1 = json_decode($response);


            if ($response1->Status == 200 && $response1->Success) {
                $objData = json_decode($this->decryptData($response1->Data));
                if ($objData->Code == 200) {
                    return redirect(route('ovm1.index'))
                        ->with('success', 'new meeting Screen Deleted Successfully');
                }
                if ($objData->Code == 400) {
                    return redirect(route('ovm1.index'))
                        ->with('fail', 'new meeting Screen Allocated One Role');
                }
            }
        } catch (\Exception $exc) {

            return $this->sendLog($method, $exc->getCode(), $exc->getMessage(), $exc->getLine(), $exc->getTrace()[0]['args'][2]);
        }
    }
    public function ovmiscfeedbackstore(Request $request, $id)
    {
        try {
          
            $user_id = $request->session()->get("userID");
            $t = $request->type;
            $currentPage = $request->currentPage; //dd($currentPage);
            $ovm_meeting_id = $request->ovm_meeting_id;
            $method = 'Method => ovm1Controller => store';
            $data = array();
            $data['ovm_isc_report_id'] = $id;
            $data['ovm_meeting_unique'] = $request->ovm_meeting_unique;
            $data['enrollment_id'] = $request->enrollment_id;
            $data['child_id'] = $request->child_id;
            $data['child_name'] = $request->child_name;
            $data['primary_caretaker'] = $request->primary_caretaker;
            $data['family_type'] = $request->family_type;
            $data['siblings'] = $request->siblings;
            $data['profession_of_the_parents'] = $request->profession_of_the_parents;
            $data['academics'] = $request->academics;
            $data['developmental_milestones_motor_lang_speech'] = $request->developmental_milestones_motor_lang_speech;
            $data['schools_attended_school_currently_grade'] = $request->schools_attended_school_currently_grade;
            $data['previous_interventions_given_current_intervention'] = $request->previous_interventions_given_current_intervention;
            $data['any_assessment_done'] = $request->any_assessment_done;
            $data['food_sleep_pattern_any_medication'] = $request->food_sleep_pattern_any_medication;
            $data['socialization_emotional_communication_sensory'] = $request->socialization_emotional_communication_sensory;
            $data['adls_general_routine'] = $request->adls_general_routine;
            $data['birth_history'] = $request->birth_history;
            $data['strength_interests'] = $request->strength_interests;
            $data['current_challenges_concerns'] = $request->current_challenges_concerns;
            $data['other_information'] = $request->other_information;
            $data['introspection'] = $request->introspection;
            $data['expectation_from_school'] = $request->expectation_from_school;
            $data['expectation_from_elina'] = $request->expectation_from_elina;
            $data['notes'] = $request->notes;
            $data['type'] = $request->type;

            $data['g2form_filled'] = $request->g2form_filled;

            $data['user_id'] = $user_id;
            $data['que'] = $request->que;
            $data['note'] = $request->note;
            $editusername = $request->editusername;
            $encryptArray = $this->encryptData($data);
            $request = array();
            $request['requestData'] = $encryptArray;
            $gatewayURL = config('setting.api_gateway_url') . '/ovmiscfeedback/store';
            $response = $this->serviceRequest($gatewayURL, 'POST', json_encode($request), $method);
            $response1 = json_decode($response);


            if ($response1->Status == 200 && $response1->Success) {
                $objData = json_decode($this->decryptData($response1->Data));
                if ($objData->Code == 200) {
                    $parant_data = json_decode(json_encode($objData->Data), true);
                    $check = $parant_data['check'];
                    if ($check == 0) {
                        $this->ovm_report_download($parant_data);
                    }
                    if ($editusername == "IS Coordinator") {
                        if ($t == 'Submitted') {
                            return redirect(route('ovmmeetingcompleted'))->with('success', 'Conservation Summary Submitted Successfully');
                        } else {
                            return Redirect::back()->with('success', 'Conservation Summary Saved Successfully')->with('page', $currentPage);
                        }
                    } else {
                        return redirect(route('ovmreportview', $this->encryptData($ovm_meeting_id)))->with('success', 'Conservation Summary Updated Successfully');
                    }
                }

                if ($objData->Code == 400) {
                    return redirect(route('ovmmeetingcompleted'))->with('fail', 'Conservation Summary - Failed');
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
    public function ovmiscfeedback_update(Request $request, $id)
    {
       
        try {

            $user_id = $request->session()->get("userID");


            $ovm_meeting_id = $request->ovm_meeting_id;
            $method = 'Method => ovm1Controller => store';
            $data = array();
            $data['coordinator'] = $request->coordinator;
            $data['coordinator1'] = $request->coordinator1;
            $data['que'] = $request->que;
            $data['enrollment_id'] = $request->enrollment_id;
            $data['child_id'] = $request->child_id;
            $data['child_name'] = $request->child_name;
            $data['user_id'] = $user_id;
            $data['type'] = $request->type;
            $data['meet_id']= $request->ovm_meeting_id;
            $editusername = $request->editusername;

            $encryptArray = $this->encryptData($data);
            $request = array();

            $request['requestData'] = $encryptArray;
            $gatewayURL = config('setting.api_gateway_url') . '/ovmisc_feedback/update';
            $response = $this->serviceRequest($gatewayURL, 'POST', json_encode($request), $method);
            $response1 = json_decode($response);

            if ($response1->Status == 200 && $response1->Success) {
                $objData = json_decode($this->decryptData($response1->Data));

                if ($objData->Code == 200) {

                    $parant_data = json_decode(json_encode($objData->Data), true);
                    $check = $parant_data['check'];

                    if ($check == 0) {
                        $this->ovm_report_download($parant_data);
                    }

                    if ($editusername == "IS Coordinator") {
                        if ($data['type'] == 'Submitted') {
                            return redirect(route('ovmreportview', $this->encryptData($ovm_meeting_id)))->with('success', 'Conservation Summary Updated Successfully');
                        } else {
                            return Redirect::back()->with('success', 'Conservation Summary Saved Successfully');
                        }
                    } else {
                        return redirect(route('ovmreportview', $this->encryptData($ovm_meeting_id)))->with('success', 'Conservation Summary Updated Successfully');
                    }
                }

                if ($objData->Code == 400) {
                    return redirect(route('ovmmeetingcompleted'))->with('fail', 'Conservation Summary - Failed');
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
    public function ovmmeetingcompleted(Request $request)
    {
        try {

            $user_id = $request->session()->get("userID");
            $method = 'Method => LoginController => Register_screen';

            $request =  array();
            $request['user_id'] = $user_id;
            $request['is_coordinator_id'] = $user_id;
            $gatewayURL = config('setting.api_gateway_url') . '/ovm1/ovmmeetingcompleted';

            $response = $this->serviceRequest($gatewayURL, 'GET',  json_encode($request), $method);


            $response = json_decode($response);

            if ($response->Status == 200 && $response->Success) {
                $objData = json_decode($this->decryptData($response->Data));
                if ($objData->Code == 200) {
                    $parant_data = json_decode(json_encode($objData->Data), true);
                    $rows = $parant_data['rows'];


                    // $work_flow_row =  $parant_data['work_flow_row'];
                    $menus = $this->FillMenu();
                    $screens = $menus['screens'];
                    $modules = $menus['modules'];
                    return view('ovm1.ovmmeetingcompletedlist', compact('rows', 'screens', 'modules'));
                }
            } else {
                $objData = json_decode($this->decryptData($response->Data));
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
    public function ovmreport(Request $request)
    {
        try {

            $user_id = $request->session()->get("userID");
            $method = 'Method => LoginController => Register_screen';

            $request =  array();
            $request['user_id'] = $user_id;
            $gatewayURL = config('setting.api_gateway_url') . '/ovm1/ovmreport';
            $response = $this->serviceRequest($gatewayURL, 'GET',  json_encode($request), $method);


            $response = json_decode($response);

            if ($response->Status == 200 && $response->Success) {
                $objData = json_decode($this->decryptData($response->Data));
                if ($objData->Code == 200) {
                    $parant_data = json_decode(json_encode($objData->Data), true);
                    $rows = $parant_data['rows'];
                    $completed = $parant_data['completed'];

                    // $work_flow_row =  $parant_data['work_flow_row'];
                    $menus = $this->FillMenu();
                    $screens = $menus['screens'];
                    $modules = $menus['modules'];
                    $permission = $this->FillScreensByUser();
                    $screen_permission = $permission[0];
                    return view('ovm1.ovmreportlist', compact('completed', 'rows', 'screens', 'modules', 'screen_permission'));
                }
            } else {
                $objData = json_decode($this->decryptData($response->Data));
                if ($objData->Code == "401") {
                    return redirect(route('/'))->with('danger', 'User session Exipired');
                }
                echo json_encode($objData->Code);
                exit;
            }
        } catch (\Exception $exc) {
            // 
            return $this->sendLog($method, $exc->getCode(), $exc->getMessage(), $exc->getLine(), $exc->getTrace()[0]['args'][2]);
        }
    }
    public function ovmreportview(Request $request, $id)
    {

        try {
            $user_id = $request->session()->get("userID");
            $method = 'Method => LoginController => Register_screen';

            $request =  array();
            $request['user_id'] = $user_id;
            $request['ovm_meeting_id'] = $id;

            $gatewayURL = config('setting.api_gateway_url') . '/ovm1/ovmreportview';
            $response = $this->serviceRequest($gatewayURL, 'GET',  json_encode($request), $method);


            $response = json_decode($response);

            if ($response->Status == 200 && $response->Success) {
                $objData = json_decode($this->decryptData($response->Data));
                if ($objData->Code == 200) {
                    $parant_data = json_decode(json_encode($objData->Data), true);
                    // dd($parant_data);
                    $rows = $parant_data['rows'];
                    // dd($rows);
                    $role = $parant_data['role'];
                    $email = $parant_data['email'];
                    $coordinator = $parant_data['coordinator'];

                    $fetch = $parant_data['fetch'];
                    $group = $parant_data['group'];
                    // dd($fetch , $fetch['question']);

                    $menus = $this->FillMenu();
                    $screens = $menus['screens'];
                    $modules = $menus['modules'];

                    if ($role == 'IS Head') {
                        return view('ovm1.reportview_v2', compact('coordinator', 'user_id', 'fetch', 'email', 'rows', 'screens', 'modules'));
                    } else {
                        return view('ovm1.reportviewISCo_v2', compact('coordinator', 'user_id', 'group', 'fetch', 'email', 'rows', 'screens', 'modules'));
                    }
                }
            } else {
                $objData = json_decode($this->decryptData($response->Data));
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
    public function questionnaire(Request $request)
    {

        $user_id = $request->session()->get("userID");
        $method = 'Method => ovm1Controller => questionnaire';

        $request =  array();
        $request['user_id'] = $user_id;

        $gatewayURL = config('setting.api_gateway_url') . '/ovm_questionnaire/index';
        $response = $this->serviceRequest($gatewayURL, 'GET',  json_encode($request), $method);

        $response = json_decode($response);

        $objData = json_decode($this->decryptData($response->Data));
        $response_data = json_decode(json_encode($objData->Data), true);
        $rows = $response_data['rows'];


        $menus = $this->FillMenu();
        $screens = $menus['screens'];
        $modules = $menus['modules'];
        return view('sail.index', compact('user_id', 'rows', 'modules', 'screens'));
        //
    }

    public function GetEventData(Request $request)
    {
        $logMethod = 'Method => ovm1Controller => GetEventData';
        try {
            $gatewayURL = config('setting.api_gateway_url') . '/calendar/event/getdata';
            $serviceResponse = array();
            $serviceResponse['fieldID'] = $request['fieldID'];
            $serviceResponse = json_encode($serviceResponse, JSON_FORCE_OBJECT);
            $serviceResponse = $this->serviceRequest($gatewayURL, 'GET', $serviceResponse, $logMethod);
            $serviceResponse = json_decode($serviceResponse);
            if ($serviceResponse->Status == 200 && $serviceResponse->Success) {
                $objData = json_decode($this->decryptData($serviceResponse->Data));
                if ($objData->Code == 200) {
                    $rows = json_decode(json_encode($objData->Data), true);
                    echo json_encode($rows);
                }
            }
        } catch (\Exception $exc) {
            $exceptionResponse = array();
            $exceptionResponse['ServiceMethod'] = $logMethod;
            $exceptionResponse['Exception'] = $exc->getMessage();
            $exceptionResponse = json_encode($exceptionResponse, JSON_FORCE_OBJECT);
            $this->WriteFileLog($exceptionResponse);
        }
    }

    public function ovm_questionnaire(Request $request)
    {

        $user_id = $request->session()->get("userID");
        $method = 'Method => SaildocumentController => index';

        $request =  array();
        $request['user_id'] = $user_id;

        $gatewayURL = config('setting.api_gateway_url') . '/sail/index';
        $response = $this->serviceRequest($gatewayURL, 'GET',  json_encode($request), $method);

        $response = json_decode($response);

        $objData = json_decode($this->decryptData($response->Data));
        $response_data = json_decode(json_encode($objData->Data), true);
        $rows = $response_data['rows'];
        $submitted = $response_data['submitted'];

        $menus = $this->FillMenu();
        $screens = $menus['screens'];
        $modules = $menus['modules'];
        return view('ovm1.QuestionnaireIndex', compact('user_id', 'rows', 'submitted', 'modules', 'screens'));
        //
    }
    public function report_download(Request $request)
    {

        $method = 'Method => ovm1Controller => report_download';
        $folderPath = $request->child_id;
        //$folderPath = str_replace(' ', '-', $folderPath);
        $findString = array(' ', '&');
        $replaceString = array('-', '-');
        $folderPath = str_replace($findString, $replaceString, $folderPath);
        $storagePath = public_path() . '/ovm_assessment/' . $folderPath;

        if (!File::exists($storagePath)) {
            $storagePath = public_path() . '/ovm_assessment/';

            $arrFolder = explode('/', $folderPath);
            foreach ($arrFolder as $key => $value) {
                $storagePath .= '/' . $value;

                if (!File::exists($storagePath)) {
                    File::makeDirectory($storagePath);
                }
            }
        }


        $documentName = 'ovm_assessment_report.pdf';
        $document_name = 'ovm_assessment_report';
        $input = base_path() . '/reports/ovm_assessment_report.jasper';


        //$input = 'C:\xampp\htdocs\jasperreport\storage\app\public\reports/userreport.jasper';
        $output = $storagePath . '/' . $documentName;
        $output_1 = $storagePath . '/' . $document_name;
        $storagePath = public_path() . '/ovm_assessment/';
        $report_path = public_path() . '/ovm_assessment/' . $folderPath;



        $options = [
            'format' => ['pdf'],
            'locale' => 'en',
            'params' => [
                'child_id' => $request->child_id,

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
        //  echo json_encode($options); exit;
        $jasper->process(
            $input,
            $output_1,
            $options
        )->execute();

        $documentName = 'ovm_assessment_report.pdf';
        $headers = array(
            'Content-Type: application/pdf',
        );

        $data = array();
        $data['child_name'] = $request['child_name'];
        $data['child_id'] = $request['child_id'];
        $data['ovm_assessment'] = $output;
        $downloadPath = '/ovm_assessment/' . $folderPath . '/' . $documentName;
        return $downloadPath;
        $encryptArray = $this->encryptData($data);



        $request = array();
        $request['requestData'] = $encryptArray;
        $gatewayURL = config('setting.api_gateway_url') . '/report/assessment';

        $response = $this->serviceRequest($gatewayURL, 'POST', json_encode($request), $method);

        $response1 = json_decode($response);

        if ($response1->Status == 200 && $response1->Success) {
            $objData = json_decode($this->decryptData($response1->Data));
            return redirect(route('ovmreport'))->with('success', 'OVM Assessment Report Sent Successfully');
        } else {
            $objData = json_decode($this->decryptData($response1->Data));
            echo json_encode($objData->Code);
            exit;
        }
    }

    public function send_report(Request $request)
    {

        $method = 'Method => ovm1Controller => report_download';
        $folderPath = $request->child_id;
        //$folderPath = str_replace(' ', '-', $folderPath);
        $findString = array(' ', '&');
        $replaceString = array('-', '-');
        $folderPath = str_replace($findString, $replaceString, $folderPath);
        $storagePath = public_path() . '/ovm_assessment/' . $folderPath;

        if (!File::exists($storagePath)) {
            $storagePath = public_path() . '/ovm_assessment/';

            $arrFolder = explode('/', $folderPath);
            foreach ($arrFolder as $key => $value) {
                $storagePath .= '/' . $value;

                if (!File::exists($storagePath)) {
                    File::makeDirectory($storagePath);
                }
            }
        }


        $documentName = 'ovm_assessment_report.pdf';
        $document_name = 'ovm_assessment_report';
        $input = base_path() . '/reports/ovm_assessment_report.jasper';


        //$input = 'C:\xampp\htdocs\jasperreport\storage\app\public\reports/userreport.jasper';
        $output = $storagePath . '/' . $documentName;
        $output_1 = $storagePath . '/' . $document_name;
        $storagePath = public_path() . '/ovm_assessment/';
        $report_path = public_path() . '/ovm_assessment/' . $folderPath;



        $options = [
            'format' => ['pdf'],
            'locale' => 'en',
            'params' => [
                'child_id' => $request->child_id,

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
        //  echo json_encode($options); exit;
        $jasper->process(
            $input,
            $output_1,
            $options
        )->execute();

        $documentName = 'ovm_assessment_report.pdf';
        $headers = array(
            'Content-Type: application/pdf',
        );

        $data = array();
        $data['child_name'] = $request['child_name'];
        $data['child_id'] = $request['child_id'];
        $data['ovm_assessment'] = $output;
        $data['email_draft'] = $request->email_draft;
        $data['notification'] = 'ovm_assessment/' . $folderPath;

        $encryptArray = $this->encryptData($data);



        $request = array();
        $request['requestData'] = $encryptArray;
        $gatewayURL = config('setting.api_gateway_url') . '/report/assessment';

        $response = $this->serviceRequest($gatewayURL, 'POST', json_encode($request), $method);

        $response1 = json_decode($response);

        if ($response1->Status == 200 && $response1->Success) {
            $objData = json_decode($this->decryptData($response1->Data));
            return redirect(route('ovmreport'))->with('success', 'OVM Assessment Report Sent Successfully');
        } else {
            return redirect(route('ovmreport'))->with('fail', 'OVM Assessment Already Sent');
        }
    }

    public function ovm_report_download($request)
    {
        $method = 'Method => ovm1Controller => ovm_report_download';
        $folderPath = $request['child_contact_email'];
        //$folderPath = str_replace(' ', '-', $folderPath);
        $findString = array(' ', '&');
        $replaceString = array('-', '-');
        $folderPath = str_replace($findString, $replaceString, $folderPath);
        $storagePath = public_path() . '/ovm_report/' . $folderPath;

        if (!File::exists($storagePath)) {
            $storagePath = public_path() . '/ovm_report/';

            $arrFolder = explode('/', $folderPath);
            foreach ($arrFolder as $key => $value) {
                $storagePath .= '/' . $value;

                if (!File::exists($storagePath)) {
                    File::makeDirectory($storagePath);
                }
            }
        }


        $documentName = 'ovm_report.pdf';
        $document_name = 'ovm_report';
        $input = base_path() . '/reports/ovm_report.jasper';


        //$input = 'C:\xampp\htdocs\jasperreport\storage\app\public\reports/userreport.jasper';
        $output = $storagePath . '/' . $documentName;
        $output_1 = $storagePath . '/' . $document_name;
        $storagePath = public_path() . '/ovm_report/';
        $report_path = public_path() . '/ovm_report/' . $folderPath;



        // $options = [
        //     'format' => ['pdf'],
        //     'locale' => 'en',
        //     'params' => [
        //         'is_coordinator_1' => $request['is_coordinator_1_id'],
        //         'is_coordinator_2' => $request['is_coordinator_2_id'],
        //         'name_1' => $request['is_coordinator_1_name'],
        //         'name_2' => $request['is_coordinator_2_name'],
        //         'dob' => $request['child_dob'],
        //         'age' => $request['child_age'],
        //         'area' => $request['child_contact_address'],
        //         'enrollment_id' => $request['enrollment_id'],

        //     ],


        //     'db_connection' => [
        //         'driver' => 'mysql',
        //         'username' => config('setting.db_username'),
        //         'password' => config('setting.db_password'),
        //         'host' => '127.0.0.1',
        //         'database' => config('setting.db_database'),
        //         'port' => config('setting.db_port'),
        //     ]
        // ];
        // dd($options);
        // $jasper = new PHPJasper;
        //echo json_encode($output); exit;
        //echo json_encode($options); exit;
        // $jasper->process(
        //     $input,
        //     $output_1,
        //     $options
        // )->execute();

        $documentName = 'ovm_report.pdf';
        $headers = array(
            'Content-Type: application/pdf',
        );

        $rows = $request['pdf'];
        $questions = $request['questions'];
        $fetchdata1 = $request['fetchdata1'];
        $fetchdata = $request['fetchdata'];
        $group = $request['group'];
        // dd($rows , $questions , $fetchdata1 , $fetchdata , $group);

        $pdf = PDF::loadView('pdfTemplates.in', compact('rows', 'questions', 'fetchdata', 'fetchdata1', 'group'));
        $pdf->save($output);

        $data = array();
        $data['child_contact_email'] = $request['child_contact_email'];
        $data['ovm_report'] = $output;
        $data['child_name'] = $request['child_name'];
        $data['child_id'] = $request['child_id'];

        $encryptArray = $this->encryptData($data);



        $request = array();
        $request['requestData'] = $encryptArray;
        $gatewayURL = config('setting.api_gateway_url') . '/report/ovm/report';

        $response = $this->serviceRequest($gatewayURL, 'POST', json_encode($request), $method);

        $response1 = json_decode($response);

        if ($response1->Status == 200 && $response1->Success) {
            return true;
        } else {
            $objData = json_decode($this->decryptData($response1->Data));
            echo json_encode($objData->Code);
            exit;
        }
    }

    public function feedbacksubmit(Request $request, $id)
    {
        try {

            $method = 'Method => ovm1Controller => feedbacksubmit';

            $gatewayURL = config('setting.api_gateway_url') . '/ovm1/feedbacksubmit/' . $id;

            $response = $this->serviceRequest($gatewayURL, 'GET', '', $method);
            $response = json_decode($response);

            if ($response->Status == 200 && $response->Success) {
                $objData = json_decode($this->decryptData($response->Data));
                if ($objData->Code == 200) {
                    $parant_data = json_decode(json_encode($objData->Data), true);
                    $id = $this->EncryptData($parant_data);
                    return redirect(route('ovmreportview', $id))->with('success', 'Conservation Summary successfully submitted');
                }
            } else {
                $objData = json_decode($this->decryptData($response->Data));
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

    public function preview($id)
    {
        try {
            $method = 'Method => LoginController => Register_screen';
            $gatewayURL = config('setting.api_gateway_url') . '/ovm/template/getdata/' . $id;
            $response = $this->serviceRequest($gatewayURL, 'GET', '', $method);
            $response = json_decode($response);
            $objData = json_decode($this->decryptData($response->Data));
            $parant_data = json_decode(json_encode($objData->Data), true);
            
            $rows = $parant_data['rows'];
            $report = $parant_data['report'];
            $email = $parant_data['email'];
            $ccEmails = explode(',', $rows[0]["mail_cc"]);
            $users = $parant_data['users'];
            $menus = $this->FillMenu();
            $screens = $menus['screens'];
            $modules = $menus['modules'];
            return view('ovm1.preview', compact('modules', 'screens', 'report', 'email', 'rows', 'users','ccEmails'));
        } catch (\Exception $exc) {
            return $this->sendLog($method, $exc->getCode(), $exc->getMessage(), $exc->getLine(), $exc->getTrace()[0]['args'][2]);
        }
    }

    public function previewstore(Request $request)
    {
        try {
            $method = 'Method => ovm1Controller => previewstore';
            $data = array();
            $data['page'] = $request->mce_0;
            // dd($request->mce_0);
            $encryptArray = $this->encryptData($data);
            $request = array();
            $request['requestData'] = $encryptArray;
            $gatewayURL = config('setting.api_gateway_url') . '/ovm/template/store';
            $response = $this->serviceRequest($gatewayURL, 'POST', json_encode($request), $method);
            $response1 = json_decode($response);

            if ($response1->Status == 200 && $response1->Success) {
                $objData = json_decode($this->decryptData($response1->Data));
                if ($objData->Code == 200) {
                    $parant_data = json_decode(json_encode($objData->Data), true);
                    return Redirect::back();
                }
                if ($objData->Code == 400) {
                    return Redirect::back();
                    return redirect(route('ovmmeetingcompleted'))->with('fail', 'Conservation Summary updated Failed');
                }
            } else {
                $objData = json_decode($this->decryptData($response1->Data));
                echo json_encode($objData->Code);
                exit;
            }
        } catch (\Exception $exc) {

            return $this->sendLog($method, $exc->getCode(), $exc->getMessage(), $exc->getLine(), $exc->getTrace()[0]['args'][2]);
        }
    }

    public function generatePDF(Request $request)
    {

        $method = 'Method => assessmentreportController => Recommendation_report';
        $folderPath = $request->child_email;
        $page = $request->entirePage;

        $findString = array(' ', '&');
        $replaceString = array('-', '-');
        $folderPath = str_replace($findString, $replaceString, $folderPath);
        $storagePath = public_path() . '/ovm_assessment/' . $folderPath;

        if (!File::exists($storagePath)) {
            $storagePath = public_path() . '/ovm_assessment/';

            $arrFolder = explode('/', $folderPath);
            foreach ($arrFolder as $key => $value) {
                $storagePath .= '/' . $value;
                if (!File::exists($storagePath)) {
                    File::makeDirectory($storagePath);
                }
            }
        }

        $data = [
            'data' => $page,
        ];
        // dd( $data['data'] );

        $output = $storagePath . '/sail_guide.pdf';
        $pdf = PDF::loadView('pdfTemplates.sailguide', $data);
        $pdf->save($output);

        $data = array();
        $data['ovm_assessment'] = $output;
        $data['child_name'] = $request->child_name;
        $data['child_id'] = $request->child_id;
        $data['email_draft'] = $request->email_content;
        $data['notification'] = 'ovm_assessment/' . $folderPath;
        $data['mail_cc'] = $request->mail_cc;
        // dd($data);

        $encryptArray = $this->encryptData($data);
        $request = array();
        $request['requestData'] = $encryptArray;
        $gatewayURL = config('setting.api_gateway_url') . '/report/assessment';

        $response = $this->serviceRequest($gatewayURL, 'POST', json_encode($request), $method);

        $response1 = json_decode($response);

        if ($response1->Status == 200 && $response1->Success) {
            return true;
        } else {
            $objData = json_decode($this->decryptData($response1->Data));
            echo json_encode($objData->Code);
            exit;
        }

        return true;
    }

    public function generatePDFPreview(Request $request)
    {

        $method = 'Method => assessmentreportController => Recommendation_report';
        $folderPath = $request->child_email;
        $page = $request->entirePage;

        $findString = array(' ', '&');
        $replaceString = array('-', '-');
        $folderPath = str_replace($findString, $replaceString, $folderPath);
        $storagePath = public_path() . '/ovm_assessment/' . $folderPath;

        if (!File::exists($storagePath)) {
            $storagePath = public_path() . '/ovm_assessment/';

            $arrFolder = explode('/', $folderPath);
            foreach ($arrFolder as $key => $value) {
                $storagePath .= '/' . $value;
                if (!File::exists($storagePath)) {
                    File::makeDirectory($storagePath);
                }
            }
        }

        $data = [
            'data' => $page,
        ];
        // dd( $data['data'] );

        $output = $storagePath . '/sail_guide.pdf';
        $pdf = PDF::loadView('pdfTemplates.sailguide', $data);
        $pdf->save($output);

        $viewPDF = config('setting.base_url') . '/ovm_assessment/' . $folderPath . '/sail_guide.pdf';
        return $viewPDF;
    }

    public function sailguideSave(Request $request)
    {
        try {
            $method = 'Method => ovm1Controller => sailguideSave';
            $data = array(); 
            // dd($request);
            $data['page'] = $request->section;
            $data['enrollment_id'] = $request->enrollment_id;
            $data['status'] = $request->status;
            $data['email_draft']=$request->email_content;
            $data['mail_cc']=$request->mail_cc;
           
            $encryptArray = $this->encryptData($data);
            $request = array();
            $request['requestData'] = $encryptArray;
            $gatewayURL = config('setting.api_gateway_url') . '/sail/guide/save';
            $response = $this->serviceRequest($gatewayURL, 'POST', json_encode($request), $method);
            $response1 = json_decode($response);
        
            if ($response1->Status == 200 && $response1->Success) {
                $objData = json_decode($this->decryptData($response1->Data));
                if ($objData->Code == 200) {
                    if( $data['status'] == 'Save')
                    {
                        $parant_data = json_decode(json_encode($objData->Data), true);
                        return Redirect::back()->with('success', 'Saved Successfully');
                    }
                    else if( $data['status'] == 'Submitted')
                    {
                        $parant_data = json_decode(json_encode($objData->Data), true);
                        //return redirect(route('ovm.generatePDFPreview'))->with('success', 'Submitted Successfully');

                        return Redirect::back()->with('success', 'Submitted Successfully');
                    }

                  
                }
                if ($objData->Code == 400) {
                    return Redirect::back();
                    return redirect(route('ovmmeetingcompleted'))->with('fail', 'Conservation Summary updated Failed');
                }
            } else {
                $objData = json_decode($this->decryptData($response1->Data));
                echo json_encode($objData->Code);
                exit;
            }
        } catch (\Exception $exc) {
            return $this->sendLog($method, $exc->getCode(), $exc->getMessage(), $exc->getLine(), $exc->getTrace()[0]['args'][2]);
        }
    }

    public function SignedLogin($id)
    {

        try {
            $method = 'Method => OVM1Controller => SignedLogin';
            $ids = $this->DecryptData($id);

            $input = [
                'id' => $ids,
            ];

            $gatewayURL = config('setting.api_gateway_url') . '/signedLogin';
            $encryptArray = $this->encryptData($input);
            $request = array();
            $request['requestData'] = $encryptArray;
            $response1 = $this->serviceRequest($gatewayURL, 'POST', json_encode($request), $method);
            $response = json_decode($response1);

            if ($response->Status == 401) {
                return back()->withErrors(['recaptcha' => ['Invalid user name or password']]);
            }

            if ($response->Status == 200 && $response->Success) {
                $objData = json_decode($this->decryptData($response->Data));
                $objRows = $objData;
                $row = json_decode(json_encode($objRows), true);
                session(['accessToken' => $row['access_token']]);
                session(['userType' => $row['user']['user_type']]);
                session(['userID' => $row['user']['id']]);
                session(['sessionTimer' => $objData->formattedDateTime]);
                return redirect(route('g2form.new', $this->encryptData($ids)));
            }
        } catch (\Exception $exc) {

            return $this->sendLog($method, $exc->getCode(), $exc->getMessage(), $exc->getLine(), $exc->getTrace()[0]['args'][2]);
        }
    }


    public function g2form_new($id)
    {
        try {
            $method = 'Method => ovm1Controller => g2form_new';

            // $id = 1;
            $gatewayURL = config('setting.api_gateway_url') . '/g2form/getdata/' . $id;
            $response = $this->serviceRequest($gatewayURL, 'GET', '', $method);

            $response = json_decode($response);
            if ($response->Status == 200 && $response->Success) {
                $objData = json_decode($this->decryptData($response->Data));

                if ($objData->Code == 200) {
                    $parant_data = json_decode(json_encode($objData->Data), true);
                    $questions = $parant_data['questions'];
                    $answers = $parant_data['answers'];
                    $enrollId = $parant_data['enrollId'];
                    $child_name = $parant_data['child_name'];
                    // dd($parant_data);
                    $role = $parant_data['role'];
                    $menus = $this->FillMenu();
                    $screens = $menus['screens'];
                    $modules = $menus['modules'];
                    $user_role = $modules['user_role'];

                    if ($user_role == 'Parent') {
                        return view('ovm1.g2form', compact('child_name', 'screens', 'modules', 'questions', 'answers', 'enrollId','role'));
                    }
                    else {
                        return view('ovm1.g2form_head', compact('child_name', 'screens', 'modules', 'questions', 'answers', 'enrollId','role'));
                    }
                   // return view('ovm1.g2form', compact('child_name', 'screens', 'modules', 'questions', 'answers', 'enrollId','role'));
                }
            }
        } catch (\Exception $exc) {

            return $this->sendLog($method, $exc->getCode(), $exc->getMessage(), $exc->getLine(), $exc->getTrace()[0]['args'][2]);
        }
    }
    public function g2form_storedata(Request $request)
    {
        try {
            // dd($request);
            $method = 'Method => ovm1Controller => g2form_storedata';
            $data = array();
            $data['answer'] = $request->answer;
            $data['type'] = $request->type;
            $data['id'] = $request->enrollment_id;
            $status = $data['type'];
            $encryptArray = $this->encryptData($data);
            $request = array();
            $request['requestData'] = $encryptArray;
            $gatewayURL = config('setting.api_gateway_url') . '/g2form/storedata';
            $response = $this->serviceRequest($gatewayURL, 'POST', json_encode($request), $method);
            $response1 = json_decode($response);
            if ($response1->Status == 200 && $response1->Success) {
                $objData = json_decode($this->decryptData($response1->Data));

                if ($objData->Code == 200) {
                    return Redirect::back()->with('success', $status . ' Successfully');
                }

                if ($objData->Code == 400) {
                    return redirect(route('ovm1.index'))->with('fail', 'OVM Meeting Already Scheduled');
                }
            } else {
                $objData = json_decode($this->decryptData($response1->Data));
                if ($objData->Code == 401) {
                    return redirect(route('/'))->with('error', 'User Session Expired');
                }
            }
        } catch (\Exception $exc) {
            return $this->sendLog($method, $exc->getCode(), $exc->getMessage(), $exc->getLine(), $exc->getTrace()[0]['args'][2]);
        }
    }
    public function g2form_list(Request $request)
    {
        $method = 'Method => ovm1Controller => g2form_list';
        $user_id = $request->session()->get("userID");
        $request['user_id'] = $user_id;
        $gatewayURL = config('setting.api_gateway_url') . '/g2form/list/view';
        $response = $this->serviceRequest($gatewayURL, 'GET', '', $method);

        $response = json_decode($response);

        $objData = json_decode($this->decryptData($response->Data));
        $rows = json_decode(json_encode($objData->Data), true);
        // dd($rows);
        // $submitted = $response_data['submitted'];
       
    
        $menus = $this->FillMenu();
        $screens = $menus['screens'];
        $modules = $menus['modules'];
        $user_role = $modules['user_role'];

        if ($user_role == 'Parent') {
            return view('ovm1.g2formlist', compact('rows', 'modules', 'screens','user_id'));
        }
        else {
            return view('ovm1.g2formlist_head', compact('rows', 'modules', 'screens','user_id'));
        }
        //
    }
    public function autosave(Request $request, $id)
    {
        try {
            // $this->WriteFileLog($request);
            $user_id = $request->session()->get("userID");
            //$t = $request->type;
            // $currentPage = $request->currentPage; //dd($currentPage);
            // $ovm_meeting_id = $request->ovm_meeting_id;
            $method = 'Method => ovm1Controller => autosave';
            $data = array();
            $data['ovm_isc_report_id'] = $id;
            $data['ovm_meeting_unique'] = $request->ovm_meeting_unique;
            $data['enrollment_id'] = $request->enrollment_id;
            $data['child_id'] = $request->child_id;
            $data['child_name'] = $request->child_name;
            $data['user_id'] = $user_id;
            $data['que'] = $request->que;
            $data['note'] = $request->note;
            $data['type'] = $request->type;
            $this->WriteFileLog($data);
            $editusername = $request->editusername;
            $encryptArray = $this->encryptData($data);
            $request = array();
            $request['requestData'] = $encryptArray;
            $gatewayURL = config('setting.api_gateway_url') . '/autosave/store';
            $response = $this->serviceRequest($gatewayURL, 'POST', json_encode($request), $method);
            $response1 = json_decode($response);


            if ($response1->Status == 200 && $response1->Success) {
                $objData = json_decode($this->decryptData($response1->Data));
                if ($objData->Code == 200) {
                    $parant_data = json_decode(json_encode($objData->Data), true);
                    return $parant_data;
                }
            }
        } catch (\Exception $exc) {

            return $this->sendLog($method, $exc->getCode(), $exc->getMessage(), $exc->getLine(), $exc->getTrace()[0]['args'][2]);
        }
    }
    public function resend(Request $request,$a,$id)
    {
        try {
            $method = 'Method => ovm1Controller => resend';
            $eventId = decrypt($id);
            $ovm = $a;
            // dd($eventId);
            $user_id = $request->session()->get("userID");

            $data = array();
            $data['event_id']=$eventId;
            $data['ovm']=$a;
            
            $encryptArray = $this->encryptData($data);
            $request = array();
            $request['requestData'] = $encryptArray;
            $gatewayURL = config('setting.api_gateway_url') . '/ovm1/resend';
            $response = $this->serviceRequest($gatewayURL, 'GET', json_encode($request), $method);
            $response1 = json_decode($response);
         
            if ($response1->Status == 200 && $response1->Success) {
                $objData = json_decode($this->decryptData($response1->Data));
             

                if ($objData->Code == 200) {
                    if($a == 'ovm1')
                    {
                        return redirect(route('ovm1.index'))->with('success', 'OVM-1 Meeting Resended ');

                    }
                    else
                    {
                        return redirect(route('ovm2.index'))->with('success', 'OVM-2 Meeting Resended ');
 
                    }
                }

                if ($objData->Code == 400) {
                    return redirect(route('ovm1.index'))->with('fail', 'OVM Meeting Already Scheduled');
                }
            } else {
                $objData = json_decode($this->decryptData($response1->Data));
                // echo json_encode($objData->Code);exit;;
                if ($objData->Code == 401) {

                    return redirect(route('/'))->with('error', 'User Session Expired');
                }
            }
        } catch (\Exception $exc) {

            return $this->sendLog($method, $exc->getCode(), $exc->getMessage(), $exc->getLine(), $exc->getTrace()[0]['args'][2]);
        }
    }
}
