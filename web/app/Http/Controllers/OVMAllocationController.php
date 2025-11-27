<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;

class OVMAllocationController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $permission_data = $this->FillScreensByUser();
        $screen_permission = $permission_data[0];

        if (strpos($screen_permission['permissions'], 'View') !== false) {
            try {
                $method = 'Method => OVMAllocationController => Index';
                $gatewayURL = config('setting.api_gateway_url') . '/ovm_allocation/index';

                $response = $this->serviceRequest($gatewayURL, 'GET',  '', $method);
                $response = json_decode($response);
                $objData = json_decode($this->decryptData($response->Data));
                $rows = json_decode(json_encode($objData->Data), true);

                $rows = $rows['rows'];

                $menus = $this->FillMenu();
                $screens = $menus['screens'];
                $modules = $menus['modules'];
             

                return view('ovm_allocation.index', compact('screens', 'modules', 'rows','screen_permission'));
            } catch (\Exception $exc) {

                return $this->sendLog($method, $exc->getCode(), $exc->getMessage(), $exc->getLine(), $exc->getTrace()[0]['args'][2]);
            }
        }
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {

        try {
            $method = 'Method => OVMAllocationController => create';
            $user_id = $request->session()->get("userID");
            $request =  array();
            $request['user_id'] = $user_id;
            $gatewayURL = config('setting.api_gateway_url') . '/ovmallocation/meetinginvite';
            $response = $this->serviceRequest($gatewayURL, 'GET', json_encode($request), $method);
            $response = json_decode($response);
            $menus = $this->FillMenu();
            if ($response->Status == 200 && $response->Success) {
                $objData = json_decode($this->decryptData($response->Data));
                if ($objData->Code == 200) {
                    $parant_data = json_decode(json_encode($objData->Data), true);
                    $email = $parant_data['email'];
                    $rows =  $parant_data['rows'];
                    $iscoordinators = $rows['iscoordinators'];
                    $email_allocation = $parant_data['email_allocation'];
                    $users = $parant_data['users'];
                    $screens = $menus['screens'];
                    $modules = $menus['modules'];
                    return view('ovm_allocation.create', compact('email_allocation', 'users', 'email', 'rows', 'screens', 'modules', 'iscoordinators'));
                }
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
            $alert = $request->child_name;
            $type = $request->meeting_status;
            $method = 'Method => OVMAllocationController => store';
            $data = array();
            $data['enrollment_child_num'] = $request->enrollment_child_num;
            $data['enrollment_id'] = $request->enrollment_id;
            $data['child_id'] = $request->child_id;
            $data['child_name'] = $request->child_name;
            $data['meeting_startdate'] = $request->meeting_startdate;
            $data['meeting_enddate'] = $request->meeting_enddate;
            $data['meeting_starttime'] = $request->meeting_starttime;
            $data['meeting_endtime'] = $request->meeting_endtime;
            $data['meeting_startdate2'] = $request->meeting_startdate2;
            $data['meeting_enddate2'] = $request->meeting_enddate2;
            $data['meeting_starttime2'] = $request->meeting_starttime2;
            $data['meeting_endtime2'] = $request->meeting_endtime2;
            $data['is_coordinator1'] = $request->is_coordinator1;
            $data['is_coordinator2'] = $request->is_coordinator2;
            $data['is_coordinator1id'] = $request->is_coordinator1id;
            $data['is_coordinator2id'] = $request->is_coordinator2id;
            $data['user_id'] = $request->user_id;
            $data['meeting_location'] = $request->meeting_location;
            $data['meeting_location2'] = $request->meeting_location2;
            $data['meeting_description'] = $request->meeting_description;
            $data['meeting_status'] = $request->meeting_status;
          
            $url = URL::signedRoute('ovm.allocation.signed', ['id' => encrypt($request->user_id)]);
            $data['url'] = $url;
            $encryptArray = $this->encryptData($data);
            $request = array();
            $request['requestData'] = $encryptArray;
            $gatewayURL = config('setting.api_gateway_url') . '/ovm_allocation/store';
            $response = $this->serviceRequest($gatewayURL, 'POST', json_encode($request), $method);
            $response1 = json_decode($response);
            
            if ($response1->Status == 200 && $response1->Success) {
                $objData = json_decode($this->decryptData($response1->Data));


                if ($objData->Code == 200) {
                    if ($type == 'Sent') {
                        return redirect(route('ovm_allocation.index'))->with('success', 'OVM Meeting Scheduled Successfully for ' . $alert);
                    } elseif ($type == 'Declined') {
                        return redirect(route('ovm_allocation.index'))->with('success', 'OVM Meeting Declined for ' . $alert);
                    } elseif ($type == 'Accept') {
                        return redirect(route('ovm_allocation.index'))->with('success', 'OVM Meeting Accepted Successfully for ' . $alert);
                    } else {
                        return redirect(route('ovm_allocation.index'))->with('success', 'OVM Meeting Saved Successfully for ' . $alert);
                    }
                    // if ($type == 'Sent') {
                    //     return redirect(route('ovm_allocation.index'))->with('success', 'OVM-1 Meeting Scheduled Successfully for ' . $alert);
                    // } elseif ($type == 'Reschedule') {
                    //     return redirect(route('ovm_allocation.index'))->with('success', 'OVM-1 Meeting has been Rescheduled for ' . $alert);
                    // } elseif ($type == 'Completed') {
                    //     return redirect(route('ovm_allocation.index'))->with('success', 'OVM-1 Meeting has been Completed for ' . $alert);
                    // } elseif ($type == 'Declined') {
                    //     return redirect(route('ovm_allocation.index'))->with('success', 'OVM-1 Meeting ' . $alert . ' has been declined');
                    // } else {
                    //     return redirect(route('ovm_allocation.index'))->with('success', 'OVM-1 Meeting has been Updated for ' . $alert);
                    // }
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

    public function SignedLogin($id)
    {

        try {
            $method = 'Method => OVMAllocationController => SignedLogin';
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
                return redirect(route('ovm.allocation.details', $this->encryptData($ids)));
            }
        } catch (\Exception $exc) {

            return $this->sendLog($method, $exc->getCode(), $exc->getMessage(), $exc->getLine(), $exc->getTrace()[0]['args'][2]);
        }
    }

    public function user_update(Request $request)
    {
        try {
            //dd($request);
            $enrollment_id = $request->enrollment_id;
            $method = 'Method => OVMAllocationController => user_update';
            $data = array();
            $data['rsvp_1'] = $request->rsvp_1;
            $data['rsvp_2'] = $request->rsvp_2;
            $data['notes_1'] = $request->notes_1;
            $data['notes_2'] = $request->notes_2;
            $data['allocation_id'] = $request->allocation_id;

            $encryptArray = $this->encryptData($data);
            $request = array();
            $request['requestData'] = $encryptArray;

            $gatewayURL = config('setting.api_gateway_url') . '/ovm_allocation/user_update';

            $response = $this->serviceRequest($gatewayURL, 'POST', json_encode($request), $method);
            $response1 = json_decode($response);

            if ($response1->Status == 200 && $response1->Success) {
                $objData = json_decode($this->decryptData($response1->Data));
                return redirect(route('newenrollment.show', $this->encryptData($enrollment_id)))->with('success', 'Your OVM Availability Status has been updated');
                // return redirect(route('home'))->with('success', 'Your OVM Availability has been updated');
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


    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        //dd($id);
        $method = 'Method => OVMAllocationController => ovm_accept';
        $gatewayURL = config('setting.api_gateway_url') . '/ovm_allocation/data_edit/' . $id;

        $response = $this->serviceRequest($gatewayURL, 'GET',  '', $method);
        $response = json_decode($response);
        $objData = json_decode($this->decryptData($response->Data));
        $responseData = json_decode(json_encode($objData->Data), true);
        $rows = $responseData['rows'];
        $iscoordinators = $responseData['iscoordinators'];
        $email_allocation = $responseData['email_allocation'];

        $menus = $this->FillMenu();
        $screens = $menus['screens'];
        $modules = $menus['modules'];
        return view('ovm_allocation.edit', compact('screens', 'modules', 'rows', 'iscoordinators', 'email_allocation'));
    }

    public function saved($id)
    {
        // dd($id);
        $method = 'Method => OVMAllocationController => saved';
        $gatewayURL = config('setting.api_gateway_url') . '/ovm_allocation/data_edit/' . $id;
        $response = $this->serviceRequest($gatewayURL, 'GET',  '', $method);
        $response = json_decode($response);
        $objData = json_decode($this->decryptData($response->Data));
        $responseData = json_decode(json_encode($objData->Data), true);
        $rows = $responseData['rows'];
        $iscoordinators = $responseData['iscoordinators'];
        $email = $responseData['email'];
        $email_allocation = $responseData['email_allocation'];
        // dd($rows);

        $menus = $this->FillMenu();
        $screens = $menus['screens'];
        $modules = $menus['modules'];
        return view('ovm_allocation.saved', compact('email', 'screens', 'modules', 'rows', 'iscoordinators', 'email_allocation'));
    }

    public function update(Request $request, $id)
    {

        try {

            $alert = $request->child_name;
            $type = $request->meeting_status;

            $method = 'Method => OVMAllocationController => update';

            $data = array();
            $data['meeting_startdate'] = $request->meeting_startdate;
            $data['meeting_enddate'] = $request->meeting_enddate;
            $data['meeting_starttime'] = $request->meeting_starttime;
            $data['meeting_endtime'] = $request->meeting_endtime;

            $data['meeting_startdate2'] = $request->meeting_startdate2;
            $data['meeting_enddate2'] = $request->meeting_enddate2;
            $data['meeting_starttime2'] = $request->meeting_starttime2;
            $data['meeting_endtime2'] = $request->meeting_endtime2;

            $data['is_coordinator1'] = $request->is_coordinator1;
            $data['is_coordinator2'] = $request->is_coordinator2;

            $data['user_id'] = $request->user_id;
            $data['allocation_id'] = $id;

            $data['meeting_description'] = $request->meeting_description;
            $data['meeting_status'] = $request->meeting_status;

            $data['child_name'] = $request->child_name;

            $data['status'] = $request->status;

            $data['coord_notes'] = $request->coord_notes;

            $data['rsvp1'] = $request->rsvp1;
            $data['rsvp2'] = $request->rsvp2;
            $data['reschedule_count'] = $request->reschedule_count;

            $url = URL::signedRoute('ovm.allocation.signed', ['id' => encrypt($request->user_id)]);
            $data['url'] = $url;

            $encryptArray = $this->encryptData($data);
            $request = array();
            $request['requestData'] = $encryptArray;
            $gatewayURL = config('setting.api_gateway_url') . '/ovm_allocation/update_data';
            $response = $this->serviceRequest($gatewayURL, 'POST', json_encode($request), $method);

            $response1 = json_decode($response);
            if ($response1->Status == 200 && $response1->Success) {
                $objData = json_decode($this->decryptData($response1->Data));


                if ($objData->Code == 200) {
                    if ($type == 'Sent') {
                        return redirect(route('ovm_allocation.index'))->with('success', 'OVM Meeting Scheduled Successfully for ' . $alert);
                    } elseif ($type == 'Saved') {
                        return redirect(route('ovm_allocation.index'))->with('success', 'OVM Meeting Saved Successfully for ' . $alert);
                    } elseif ($type == 'Reschedule') {
                        return redirect(route('ovm_allocation.index'))->with('success', 'OVM Meeting Rescheduled Successfully for ' . $alert);
                    } elseif ($type == 'Forced Closure') {
                        return redirect(route('ovm_allocation.index'))->with('success', 'OVM Meeting Forced Closed Successfully for ' . $alert);
                    } elseif ($type == 'Declined') {
                        return redirect(route('ovm_allocation.index'))->with('success', 'OVM Meeting Declined Successfully for ' . $alert);
                    } elseif ($type == 'Accept') {
                        return redirect(route('ovm_allocation.index'))->with('success', 'OVM Meeting Forced Accepted Successfully for ' . $alert);
                    } else {
                        return redirect(route('ovm_allocation.index'))->with('success', 'OVM Meeting Scheduling has been Successfully Updated for ' . $alert);
                    }
                    // if ($type == 'Sent') {
                    //     return redirect(route('ovm_allocation.index'))->with('success', 'OVM-1 Meeting Scheduled Successfully for ' . $alert);
                    // } elseif ($type == 'Reschedule') {
                    //     return redirect(route('ovm_allocation.index'))->with('success', 'OVM-1 Meeting has been Rescheduled for ' . $alert);
                    // } elseif ($type == 'Completed') {
                    //     return redirect(route('ovm_allocation.index'))->with('success', 'OVM-1 Meeting has been Completed for ' . $alert);
                    // } elseif ($type == 'Declined') {
                    //     return redirect(route('ovm_allocation.index'))->with('success', 'OVM-1 Meeting ' . $alert . ' has been declined');
                    // } else {
                    //     return redirect(route('ovm_allocation.index'))->with('success', 'OVM-1 Meeting has been Updated for ' . $alert);
                    // }
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

    public function destroy($id)
    {
        //
    }

    public function ovm_accept(Request $request, $id)
    {
        // dd("ASd");

        $method = 'Method => OVMAllocationController => ovm_accept';
        $gatewayURL = config('setting.api_gateway_url') . '/ovm_allocation/getdetail/' . $id;

        $response = $this->serviceRequest($gatewayURL, 'GET',  '', $method);
        $response = json_decode($response);
        $objData = json_decode($this->decryptData($response->Data));
        $responseData = json_decode(json_encode($objData->Data), true);
        $rows = $responseData['rows'];
        // dd($rows);

        $menus = $this->FillMenu();
        $screens = $menus['screens'];
        $modules = $menus['modules'];
        return view('ovm_allocation.user_edit', compact('screens', 'modules', 'rows'));
    }

    public function user_edit($id)
    {
       
// dd($id);
        $method = 'Method => OVMAllocationController => ovm_accept';
        $gatewayURL = config('setting.api_gateway_url') . '/ovm_allocation/data_edit/' . $id;

        $response = $this->serviceRequest($gatewayURL, 'GET',  '', $method);
        $response = json_decode($response);
        $objData = json_decode($this->decryptData($response->Data));
        $responseData = json_decode(json_encode($objData->Data), true);
        $rows = $responseData['rows'];
        
        $menus = $this->FillMenu();
        $screens = $menus['screens'];
        $modules = $menus['modules'];
        return view('ovm_allocation.user_edit', compact('screens', 'modules', 'rows'));
    }
}
