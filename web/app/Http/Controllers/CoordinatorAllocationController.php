<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;

class CoordinatorAllocationController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        try {
             
            $user_id = $request->session()->get("userID");
            $method = 'Method => CoordinatorAllocationController => Index';
            $is_ajax = 0;
            if (isset($request->is_ajax)) {
                $is_ajax = 1;
            }
            $request =  array();
            $request['user_id'] = $user_id;
            $gatewayURL = config('setting.api_gateway_url') . '/coordinator_allocation/index';
            $response = $this->serviceRequest($gatewayURL, 'GET',  json_encode($request), $method);
            $response = json_decode($response);

            $objData = json_decode($this->decryptData($response->Data));

            $rows = json_decode(json_encode($objData->Data), true);
            $rows1 = $rows['rows'];
            $rows2 = $rows['rows1'];

            if ($is_ajax == 1) {
                return $rows1;
            }

            $menus = $this->FillMenu();
            $screens = $menus['screens'];
            $modules = $menus['modules'];
            return view('ovm_allocation.gridlist', compact('user_id', 'modules', 'screens', 'rows1', 'rows2'));
        } catch (\Exception $exc) {
            return $this->sendLog($method, $exc->getCode(), $exc->getMessage(), $exc->getLine(), $exc->getTrace()[0]['args'][2]);
        }
    }
    public function list(Request $request)
    {
        //dd($request);
        $user_id = $request->session()->get("userID");
        if ($user_id == null) {
            return view('auth.login');
        }
        $method = 'Method => CoordinatorAllocationController => list';
        try {
            $request =  array();

            $gatewayURL = config('setting.api_gateway_url') . '/coordinator/list/view';
            $response = $this->serviceRequest($gatewayURL, 'GET',  json_encode($request), $method);
            $response = json_decode($response);


            $objData = json_decode($this->decryptData($response->Data));
            //dd($objData);
            $code = $objData->Code;

            if ($code == "401") {

                return redirect()->route('unauthenticated')->send();
            }
            $rows = json_decode(json_encode($objData->Data), true);
            //dd($rows);
            $menus = $this->FillMenu();
            if ($menus == "401") {
                return redirect(url('/'))->with('danger', 'User session Exipired');
            }
            $screens = $menus['screens'];
            $modules = $menus['modules'];
            return view('ovm_allocation.allocationlist', compact('user_id', 'rows', 'menus', 'screens', 'modules'));
        } catch (\Exception $exc) {
            return $this->sendLog($method, $exc->getCode(), $exc->getMessage(), $exc->getLine(), $exc->getTrace()[0]['args'][2]);
        }
    }
    public function show($id)
    {
        $decryptedId = Crypt::decrypt($id);
        try {

            $method = 'Method => CoordinatorAllocationController =>show';

            $request =  array();

            $gatewayURL = config('setting.api_gateway_url') . '/coordinator/allocation/show/' . $decryptedId;
            //dd($gatewayURL);
            $response = $this->serviceRequest($gatewayURL, 'GET', '', $method);
            $response = json_decode($response);
            //dd($response);
            $objData = json_decode($this->decryptData($response->Data));
            $code = $objData->Code;
            //dd($objData);
            if ($code == "401") {

                return redirect(url('/'))->with('danger', 'User session Exipired');
            }
            $rows = json_decode(json_encode($objData->Data), true);

            $rows = $rows['rows'];

            $menus = $this->FillMenu();
            $screens = $menus['screens'];
            $modules = $menus['modules'];
            return view('ovm_allocation.allocationshow', compact('rows', 'menus', 'screens', 'modules'));
        } catch (\Exception $exc) {

            return $this->sendLog($method, $exc->getCode(), $exc->getMessage(), $exc->getTrace()[0]['line'], $exc->getTrace()[0]['file']);
        }
    }
    public function edit($id)
    {
        // dd($id);
        $decryptedId = Crypt::decrypt($id);
        try {

            $method = 'Method => CoordinatorAllocationController =>edit';

            $request =  array();

            $gatewayURL = config('setting.api_gateway_url') . '/coordinator/allocation/edit/' . $decryptedId;
            //dd($gatewayURL);
            $response = $this->serviceRequest($gatewayURL, 'GET', '', $method);
            $response = json_decode($response);
            //dd($response);
            $objData = json_decode($this->decryptData($response->Data));
            $code = $objData->Code;
            //dd($objData);
            if ($code == "401") {

                return redirect(url('/'))->with('danger', 'User session Exipired');
            }
            $rows = json_decode(json_encode($objData->Data), true);
            //dd($rows);
            $rows = $rows['rows'];
            // $rows1 = $rows['rows2'];

            $menus = $this->FillMenu();
            $screens = $menus['screens'];
            $modules = $menus['modules'];
            return view('ovm_allocation.reallocation', compact('rows', 'menus', 'screens', 'modules'));
        } catch (\Exception $exc) {

            return $this->sendLog($method, $exc->getCode(), $exc->getMessage(), $exc->getTrace()[0]['line'], $exc->getTrace()[0]['file']);
        }
    }
    public function child_list(Request $request)
    {
        $user_id = $request->session()->get("userID");
        if ($user_id == null) {
            return view('auth.login');
        }
        $method = 'Method => CoordinatorAllocationController => child_list';
        try {
            $request =  array();

            $gatewayURL = config('setting.api_gateway_url') . '/allocation/list/view';
            $response = $this->serviceRequest($gatewayURL, 'GET',  json_encode($request), $method);
            $response = json_decode($response);


            $objData = json_decode($this->decryptData($response->Data));
            //dd($objData);
            $code = $objData->Code;

            if ($code == "401") {

                return redirect()->route('unauthenticated')->send();
            }
            $rows = json_decode(json_encode($objData->Data), true);
            //dd($rows);
            $menus = $this->FillMenu();
            if ($menus == "401") {
                return redirect(url('/'))->with('danger', 'User session Exipired');
            }
            $screens = $menus['screens'];
            $modules = $menus['modules'];
            return view('ovm_allocation.childlist', compact('user_id', 'rows', 'menus', 'screens', 'modules'));
        } catch (\Exception $exc) {
            return $this->sendLog($method, $exc->getCode(), $exc->getMessage(), $exc->getLine(), $exc->getTrace()[0]['args'][2]);
        }
    }
    public function allocate_store(Request $request)
    {

        $user_id = $request->session()->get("userID");
        if ($user_id == null) {
            return view('auth.login');
        }
        $method = 'Method => CoordinatorAllocationController => allocate_store';
        try {
            $data = array();
            $data['enrollment_id'] = $request->enrollment_id;
            $data['child_id'] = $request->child_id;
            $data['child_name'] = $request->child_name;
            $data['coordinator1_id'] = $request->coordinator1_id;
            $data['coordinator2_id'] = $request->coordinator2_id;
            $data['month'] = $request->selected_month;
            $data['weekDropdown'] = $request->selected_week;
            $data['is_coordinator1'] = $request->is_coordinator1;
            $data['is_coordinator2'] = $request->is_coordinator2;



            $encryptArray = $this->encryptData($data);
            $request = array();

            $request['requestData'] = $encryptArray;

            $gatewayURL = config('setting.api_gateway_url') . '/coordinator/allocation/store';

            $response = $this->serviceRequest($gatewayURL, 'POST', json_encode($request), $method);

            $response1 = json_decode($response);

            if ($response1->Status == 200 && $response1->Success) {
                $objData = json_decode($this->decryptData($response1->Data));


                if ($objData->Code == 200) {
                    return redirect(route('coordinator.list'))->with('success', 'IS-Coordinator Allocated Successfully');
                }

                if ($objData->Code == 400) {
                    return redirect(route('coordinator.list'))->with('fail', 'IS-Coordinator Failed');
                }
            }
        } catch (\Exception $exc) {
            return $this->sendLog($method, $exc->getCode(), $exc->getMessage(), $exc->getTrace()[0]['line'], $exc->getTrace()[0]['file']);
        }
    }
    public function reallocation(Request $request)
    {
        $user_id = $request->session()->get("userID");
        if ($user_id == null) {
            return view('auth.login');
        }
        $method = 'Method => CoordinatorAllocationController => reallocation';
        try {
            $data = array();
            $data['enrollment_id'] = $request->enrollment_id;
            $data['child_id'] = $request->child_id;
            $data['child_name'] = $request->child_name;
            $data['coordinator1_id'] = $request->coordinator1_id;
            $data['coordinator2_id'] = $request->coordinator2_id;
            $data['month'] = $request->selected_month;
            $data['weekDropdown'] = $request->selected_week;
            $data['is_coordinator1'] = $request->is_coordinator1;
            $data['is_coordinator2'] = $request->is_coordinator2;
            $data['description'] = $request->description;

            $encryptArray = $this->encryptData($data);
            $request = array();

            $request['requestData'] = $encryptArray;

            $gatewayURL = config('setting.api_gateway_url') . '/coordinator/reallocation/update';

            $response = $this->serviceRequest($gatewayURL, 'POST', json_encode($request), $method);

            $response1 = json_decode($response);

            if ($response1->Status == 200 && $response1->Success) {
                $objData = json_decode($this->decryptData($response1->Data));


                if ($objData->Code == 200) {
                    return redirect(route('coordinator.list'))->with('success', 'IS-Coordinator Reallocated Successfully');
                }

                if ($objData->Code == 400) {
                    return redirect(route('coordinator.list'))->with('fail', 'IS-Coordinator Reallocated Failed');
                }
            }
        } catch (\Exception $exc) {
            return $this->sendLog($method, $exc->getCode(), $exc->getMessage(), $exc->getTrace()[0]['line'], $exc->getTrace()[0]['file']);
        }
    }
    public function cancellation($id)
    {


        try {

            $method = 'Method => CoordinatorAllocationController =>edit';

            $request =  array();

            $gatewayURL = config('setting.api_gateway_url') . '/coordinator/cancellation/' . $id;
            //dd($gatewayURL);
            $response = $this->serviceRequest($gatewayURL, 'GET', '', $method);
            $response = json_decode($response);
            //dd($response);
            $objData = json_decode($this->decryptData($response->Data));
            $code = $objData->Code;
            //dd($objData);
            if ($code == "401") {

                return redirect(url('/'))->with('danger', 'User session Exipired');
            }
            $rows = json_decode(json_encode($objData->Data), true);
            //dd($rows);
            $rows = $rows['rows'];
            // $rows1 = $rows['rows2'];

            $menus = $this->FillMenu();
            $screens = $menus['screens'];
            $modules = $menus['modules'];
            return view('ovm_allocation.cancellation', compact('rows', 'menus', 'screens', 'modules'));
        } catch (\Exception $exc) {

            return $this->sendLog($method, $exc->getCode(), $exc->getMessage(), $exc->getTrace()[0]['line'], $exc->getTrace()[0]['file']);
        }
    }
    public function cancellation_store(Request $request)
    {
        // dd($request);
        $user_id = $request->session()->get("userID");
        if ($user_id == null) {
            return view('auth.login');
        }
        $method = 'Method => CoordinatorAllocationController => cancellation_store';
        try {
            $data = array();
            $data['enrollment_id'] = $request->enrollment_id;
            $data['child_id'] = $request->child_id;
            $data['child_name'] = $request->child_name;
            $data['coordinator1_id'] = $request->coordinator1_id;
            $data['coordinator2_id'] = $request->coordinator2_id;
            $data['month'] = $request->selected_month;
            $data['weekDropdown'] = $request->selected_week;
            $data['is_coordinator1'] = $request->is_coordinator1;
            $data['is_coordinator2'] = $request->is_coordinator2;
            $data['description'] = $request->description;


            $encryptArray = $this->encryptData($data);
            $request = array();

            $request['requestData'] = $encryptArray;

            $gatewayURL = config('setting.api_gateway_url') . '/coordinator/cancellation/store';

            $response = $this->serviceRequest($gatewayURL, 'POST', json_encode($request), $method);

            $response1 = json_decode($response);

            if ($response1->Status == 200 && $response1->Success) {
                $objData = json_decode($this->decryptData($response1->Data));


                if ($objData->Code == 200) {
                    return redirect(route('coordinator.list'))->with('success', 'IS-Coordinator Cancelled Successfully');
                }

                if ($objData->Code == 400) {
                    return redirect(route('coordinator.list'))->with('fail', 'IS-Coordinator Cancelled Failed');
                }
            }
        } catch (\Exception $exc) {
            return $this->sendLog($method, $exc->getCode(), $exc->getMessage(), $exc->getTrace()[0]['line'], $exc->getTrace()[0]['file']);
        }
    }
    public function ovm_create(Request $request, $id)
    {
        $decryptedId = Crypt::decrypt($id);
        try {
            $method = 'Method => CoordinatorAllocationController => ovm_create';

            $user_id = $request->session()->get("userID");


            $request =  array();

            $request['user_id'] = $user_id;
            $request['id'] = $decryptedId;


            $encryptArray = $this->encryptData($request);

            $request['requestData'] = $encryptArray;

            $gatewayURL = config('setting.api_gateway_url') . '/ovm_allocation/meetinginvite';
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
                    $allocation_details = $parant_data['allocation_details'];
                    $this->WriteFileLog($allocation_details);
                    $screens = $menus['screens'];
                    $modules = $menus['modules'];                   
                    return view('ovm_allocation.ovmcreate', compact('email_allocation', 'users', 'email', 'rows', 'screens', 'modules', 'iscoordinators', 'allocation_details'));
                }
            }
        } catch (\Exception $exc) {

            return $this->sendLog($method, $exc->getCode(), $exc->getMessage(), $exc->getLine(), $exc->getTrace()[0]['args'][2]);
        }
    }
    public function ovm_store(Request $request)
    {
        try {
            $alert = $request->child_name;
            $type = $request->meeting_status;
            $method = 'Method => CoordinatorAllocationController => ovm_store';
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
            
            $data['is_coordinator1'] = $request->is_coordinator1id;
            $data['is_coordinator2'] = $request->is_coordinator2id;

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
            $gatewayURL = config('setting.api_gateway_url') . '/ovm/allocation/store';
            $response = $this->serviceRequest($gatewayURL, 'POST', json_encode($request), $method);
            $response1 = json_decode($response);
            if ($response1->Status == 200 && $response1->Success) {
                $objData = json_decode($this->decryptData($response1->Data));


                if ($objData->Code == 200) {
                    if ($type == 'Sent') {
                        return redirect(route('ovm_allocation.index'))->with('success', 'OVM Meeting Scheduled Successfully for ' . $alert);
                    } else {
                        return redirect(route('ovm_allocation.index'))->with('success', 'OVM Meeting Saved Successfully for ' . $alert);
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
    public function date_validation(Request $request)
    {
        $this->WriteFileLog($request);
        try {
            $this->WriteFileLog("feef");
            $method = 'Method => CoordinatorAllocationController => date_validation';
            $user_id = $request->session()->get("userID");

            $data['meeting_startdate1'] = $request->meeting_startdate1;
            $data['meeting_starttime1'] = $request->meeting_starttime1;
            $data['meeting_endtime1'] = $request->meeting_endtime1;
            $data['meeting_startdate2'] = $request->meeting_startdate2;
            $data['meeting_starttime2'] = $request->meeting_starttime2;
            $data['meeting_endtime2'] = $request->meeting_endtime2;
            $data['is_coo1'] = $request->is_coo1;
            $data['is_coo2'] = $request->is_coo2;
            $data['enrollment_id'] = $request->enrollment_id;
            $this->WriteFileLog($data);

            //$encryptArray = $this->encryptData($data);
            $request = array();
            $request['requestData'] = $data;
            $this->WriteFileLog($data);
            $gatewayURL = config('setting.api_gateway_url') . '/meeting/date/validation';
            $response = $this->serviceRequest($gatewayURL, 'GET', json_encode($request), $method);
            $this->WriteFileLog($response);
            $response1 = json_decode($response);
            $objData = json_decode($this->decryptData($response1->Data));
            $rows = json_decode(json_encode($objData->Data), true);
            return $rows;
        } catch (\Exception $exc) {
            //echo $exc;
            return $this->sendLog($method, $exc->getCode(), $exc->getMessage(), $exc->getTrace()[0]['line'], $exc->getTrace()[0]['file']);
        }
    }
    public function ovm_accept(Request $request, $id)
    {
        // dd($id);
        $method = 'Method => CoordinatorAllocationController => ovm_accept';
        $gatewayURL = config('setting.api_gateway_url') . '/ovm_allocation/getdetail/' . $id;

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
    public function calendar_list(Request $request)
    {

        try {
            $user_id = $request->session()->get("userID");
            $method = 'Method => CoordinatorAllocationController => calendar_list';
            $request =  array();
            $request['user_id'] = $user_id;
            $gatewayURL = config('setting.api_gateway_url') . '/ovmmeetingview';
            $response = $this->serviceRequest($gatewayURL, 'GET',  json_encode($request), $method);
            $response = json_decode($response);
            $objData = json_decode($this->decryptData($response->Data));
            $rows = json_decode(json_encode($objData->Data), true);
            //dd($rows);
            $menus = $this->FillMenu();
            $screens = $menus['screens'];
            $modules = $menus['modules'];
            return view('ovm_allocation.calendarview', compact('user_id', 'modules', 'screens', 'rows'));
        } catch (\Exception $exc) {
            return $this->sendLog($method, $exc->getCode(), $exc->getMessage(), $exc->getLine(), $exc->getTrace()[0]['args'][2]);
        }
    }
}
