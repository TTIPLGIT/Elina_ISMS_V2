<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\URL;

class ovm2Controller extends BaseController
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

        $gatewayURL = config('setting.api_gateway_url') . '/ovm2/index';
        $response = $this->serviceRequest($gatewayURL, 'GET',  json_encode($request), $method);
        $response = json_decode($response);
        if ($response->Status == "401") {
            return redirect(route('/'))->with('danger', 'User session Exipired');
        }
        $objData = json_decode($this->decryptData($response->Data));

        $rows = json_decode(json_encode($objData->Data), true);
        $saveAlert = $rows['saveAlert'];
        $attendee = $rows['attendee'];//dd($attendee);
      
        $attendeecount = count($attendee);
        $arr = array();
        for($i = 0; $i < $attendeecount; $i++){
            array_push($arr, $attendee[$i]['ovm_id']);
        }
        
        $attendeeStatus = $rows['attendeeStatus'];
        $log = $rows['log'];
        $rows = $rows['rows'];
        $count = count($rows);

        for ($i = 0; $i < $count; $i++) {
            $rows[$i]['is_coordinator1'] = json_decode($rows[$i]['is_coordinator1'], true);
            $rows[$i]['is_coordinator2'] = json_decode($rows[$i]['is_coordinator2'], true);
        }
        $menus = $this->FillMenu();

        if ($menus == "401") {
            return redirect(route('/'))->with('danger', 'User session Exipired');
        }
        $screens = $menus['screens'];
        $modules = $menus['modules'];

        return view('ovm2.index', compact('arr','attendee','attendeeStatus','log','saveAlert','menus', 'screens', 'modules', 'rows', 'user_id'));



        //
    }

    public function Newmeetinginvite2(request $request)
    {
        try {
            $method = 'Method => ovm1Controller => create';
            $user_id = $request->session()->get("userID");
            if ($user_id == null) {
                return view('auth.login');
            }

            $method = 'Method => ovm1Controller => meetinginvite';


            $request =  array();
            $request['user_id'] = $user_id;

            $gatewayURL = config('setting.api_gateway_url') . '/ovm2/meetinginvite';
            $response = $this->serviceRequest($gatewayURL, 'GET', json_encode($request), $method);

            $response = json_decode($response);
            $menus = $this->FillMenu();

            if ($menus == "401") {
                return redirect(route('/'))->with('danger', 'User session Exipired');
            }
            if ($response->Status == 200 && $response->Success) {
                $objData = json_decode($this->decryptData($response->Data));

                if ($objData->Code == 200) {
                    $parant_data = json_decode(json_encode($objData->Data), true);
                    $rows =  $parant_data['rows'];
                    $email = $parant_data['email'];
                    $iscoordinators = $rows['iscoordinators'];
                    $screens = $menus['screens'];
                    $modules = $menus['modules'];
                    $users = $parant_data['users'];
                    $default_cc = $parant_data['default_cc'];
                    return view('ovm2.Newmeetinginvite2', compact('users','rows','email', 'screens', 'modules', 'iscoordinators', 'default_cc'));
                }
            }
        } catch (\Exception $exc) {
            
            return $this->sendLog($method, $exc->getCode(), $exc->getMessage(), $exc->getLine(), $exc->getTrace()[0]['args'][2]);
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
            $method = 'Method => ovm2Controller => create';
            $gatewayURL = config('setting.api_gateway_url') . '/ovm2/create';
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
                    return view('ovm2.create', compact('rows', 'screens', 'modules', 'rows'));
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
            $method = 'Method => ovm2Controller => store';
            $foldername = $request->enrollment_id;
            $originalTime = $request->meeting_starttime;
            $originalTime = date('h:i A', strtotime($originalTime));
            $alert = $request->child_name.' on '.$request->meeting_startdate.' '.$originalTime;
            $type = $request->meeting_status;
            $storagePath = public_path() . '/ovm2_attachments/' . $foldername;
            $storagePath1 = 'ovm2_attachments/' . $foldername;
            // dd($storagePath);
            if ($request->hasFile('file')) {
                if (!File::exists($storagePath)) {
                    File::makeDirectory($storagePath);
                }
                $imageFile = $request->file('file');
                //    
                $findString = array(' ', '&','(',')',"'");
                $replaceString = array('_', '_','_','','');
                $imageName = str_replace($findString, $replaceString, $imageFile->getClientOriginalName());
                // 
                // $imageName = $imageFile->getClientOriginalName();
                $imageFile->move($storagePath, $imageName);
            }else{
                $imageName = '';
            }

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
            $data['imagename'] = $imageName;
            $data['storagePath'] = $storagePath;
            $data['filepath'] = $storagePath1 . '/' . $imageName;
            $data['mail_cc'] = $request->mail_cc;
            // dd($data);
            $encryptArray = $this->encryptData($data);
            $request = array();
            $request['requestData'] = $encryptArray;
            $gatewayURL = config('setting.api_gateway_url') . '/ovm2/store';
            $response = $this->serviceRequest($gatewayURL, 'POST', json_encode($request), $method);
            $response1 = json_decode($response);
            if ($response1->Status == 200 && $response1->Success) {
                $objData = json_decode($this->decryptData($response1->Data));
                if ($objData->Code == 200) {
                    if($type == 'Sent'){
                        return redirect(route('ovm2.index'))->with('success', 'OVM-2 Meeting Scheduled Successfully for '.$alert);
                    }elseif($type == 'Reschedule'){
                        return redirect(route('ovm2.index'))->with('success', 'OVM-2 Meeting has been Rescheduled for '.$alert);
                    }elseif($type == 'Completed'){
                        return redirect(route('ovm2.index'))->with('success', 'OVM-2 Meeting has been Completed for '.$alert);
                    }elseif($type == 'Declined'){
                        return redirect(route('ovm2.index'))->with('success', 'OVM-2 Meeting '.$alert.' has been declined');
                    }else{
                        return redirect(route('ovm2.index'))->with('success', 'OVM-2 Meeting has been Updated for '.$alert);
                    }
                    // return redirect(route('ovm2.index'))->with('success', 'OVM-2 Meeting Scheduled Successfully');
                }

                if ($objData->Code == 400) {
                    return redirect(route('ovm2.index'))->with('fail', 'OVM Meeting Already Scheduled');
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

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function show($id)
    {

        try {
            $method = 'Method => ovm2Controller => show';


            $gatewayURL = config('setting.api_gateway_url') . '/ovm2/data_edit/' . $id;

            $response = $this->serviceRequest($gatewayURL, 'GET', '', $method);

            $response = json_decode($response);

            if ($response->Status == 200 && $response->Success) {
                $objData = json_decode($this->decryptData($response->Data));
                if ($objData->Code == 200) {
                    $parant_data = json_decode(json_encode($objData->Data), true);
                    $users = $parant_data['users'];

                    $rows = $parant_data['rows'];
                    $cc = explode("," , $rows[0]['mail_cc']);
                    $rows[0]['is_coordinator1'] = json_decode($rows[0]['is_coordinator1'], true);
                    $rows[0]['is_coordinator2'] = json_decode($rows[0]['is_coordinator2'], true);



                    $menus = $this->FillMenu();
                    $screens = $menus['screens'];
                    $modules = $menus['modules'];
                    return view('ovm2.show', compact('cc','users','rows', 'screens', 'modules'));
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
            $method = 'Method => ovm2Controller => edit';

            $gatewayURL = config('setting.api_gateway_url') . '/ovm2/data_edit/' . $id;

            $response = $this->serviceRequest($gatewayURL, 'GET', '', $method);
            $response = json_decode($response);

            if ($response->Status == 200 && $response->Success) {
                $objData = json_decode($this->decryptData($response->Data));
                if ($objData->Code == 200) {
                    $parant_data = json_decode(json_encode($objData->Data), true);
                    $users = $parant_data['users'];
                    $rows = $parant_data['rows'];
                    $cc = explode("," , $rows[0]['mail_cc']);
                    $attachment = $parant_data['attachment'];
                    $parentID = $parant_data['parentID'];
                    $iscoordinators = $parant_data['iscoordinators'];
                    $rows[0]['is_coordinator1'] = json_decode($rows[0]['is_coordinator1'], true);
                    $rows[0]['is_coordinator2'] = json_decode($rows[0]['is_coordinator2'], true);

                    $menus = $this->FillMenu();
                    $screens = $menus['screens'];
                    $modules = $menus['modules'];

                    return view('ovm2.edit', compact('parentID','cc','users','iscoordinators', 'rows', 'screens', 'modules', 'attachment'));
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
            // dd($request);
            $method = 'Method =>  ovm2Controller => update_data';
            $originalTime = $request->meeting_starttime;
            $originalTime = date('h:i A', strtotime($originalTime));
            $foldername = $request->attachmentID;
            $alert = $request->child_name.' on '.$request->meeting_startdate.' '.$originalTime;
            $type = $request->meeting_status;
            $storagePath = public_path() . '/ovm2_attachments/' . $foldername;
            $doc_storagePath = 'ovm2_attachments/' . $foldername;
            // dd($storagePath);
            if ($request->hasFile('file')) {
                if (!File::exists($storagePath)) {
                    File::makeDirectory($storagePath);
                }
                $imageFile = $request->file('file');
                //    
                $findString = array(' ', '&','(',')',"'");
                $replaceString = array('_', '_','_','','');
                $imageName = str_replace($findString, $replaceString, $imageFile->getClientOriginalName());
                // 
                // $imageName = $imageFile->getClientOriginalName();
                $imageFile->move($storagePath, $imageName);
                $attachmentPath = $doc_storagePath . '/' . $imageName;
            } else {
                $attachmentPath = $request->attachment;
            }
            // dd($attachmentPath);
            $url = URL::signedRoute('signed.sail.initiate', ['user_id' => $this->encryptData($request->parentID)]);
            $data = array();
            $data['url'] = $url;
            $data['id'] = decrypt($id);
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
            $data['meeting_status'] = $request->meeting_status;
            $data['type'] = $request->type;
            $data['user_id'] = $user_id;
            $data['attachment'] = $attachmentPath;
            $data['notes'] = $request->notes;
            $data['mail_cc']= $request->mail_cc;
            // if ($request->meeting_status === "Completed") {
            //     if ($request->hasFile('ovmattach')) {
            //         $storagePath = public_path() . '/ovmattach';
            //         $storagepathshort = '/ovmattach';
            //         $imageFile = $request->file('ovmattach');
            //         $imageName = $imageFile->getClientOriginalName();
            //         $imageFile->move($storagePath, $imageName);
            //     }
            //       $data['ovmattachpath'] = $storagePath;
            //       $data['ovmattachname'] = $imageName;
            //       $data['storagepathshort'] = $storagepathshort;
            // }
            $encryptArray = $this->encryptData($data);
            $request = array();

            $request['requestData'] = $encryptArray;
            $gatewayURL = config('setting.api_gateway_url') . '/ovm2/updatedata';
            $response = $this->serviceRequest($gatewayURL, 'POST', json_encode($request), $method);
            $response1 = json_decode($response);

            if ($response1->Status == 200 && $response1->Success) {

                $objData = json_decode($this->decryptData($response1->Data));

                if ($objData->Code == 200) {
                    if($type == 'Sent'){
                        return redirect(route('ovm2.index'))->with('success', 'OVM-2 Meeting Scheduled Successfully for '.$alert);
                    }elseif($type == 'Reschedule'){
                        return redirect(route('ovm2.index'))->with('success', 'OVM-2 Meeting has been Rescheduled for '.$alert);
                    }elseif($type == 'Completed'){
                        return redirect(route('ovm2.index'))->with('success', 'OVM-2 Meeting has been Completed for '.$alert);
                    }elseif($type == 'Declined'){
                        return redirect(route('ovm2.index'))->with('success', 'OVM-2 Meeting '.$alert.' has been declined');
                    }else{
                        return redirect(route('ovm2.index'))->with('success', 'OVM-2 Meeting has been Updated for '.$alert);
                    }
                    // return redirect(route('ovm2.index'))->with('success', 'Meeting Invite Updated Successfully');
                }
                if ($objData->Code == 400) {
                    return Redirect::back()->with('fail', 'Meeting Invite Already Sent');
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


    public function ovmsent2($id)
    {
        try {
            $method = 'Method => ovm1Controller => edit';
            $gatewayURL = config('setting.api_gateway_url') . '/ovm2/data_edit/' . $id;

            $response = $this->serviceRequest($gatewayURL, 'GET', '', $method);
            $response = json_decode($response);

            if ($response->Status == 200 && $response->Success) {
                $objData = json_decode($this->decryptData($response->Data));
                if ($objData->Code == 200) {
                    $parant_data = json_decode(json_encode($objData->Data), true);
                    $rows = $parant_data['rows'];
                    $cc = explode("," , $rows[0]['mail_cc']);
                    $users = $parant_data['users'];
                    $attachment = $parant_data['attachment'];
                    $parentID = $parant_data['parentID'];
                    $attendee = $parant_data['attendee'];
                    $attendeeID = [];
                    foreach($attendee as $attendees){
                        array_push($attendeeID, $attendees['attendee']);
                    }
                    $authID = session()->get("userID"); //dd($authID , $rows);

                    $rows[0]['is_coordinator1'] = json_decode($rows[0]['is_coordinator1'], true);
                    $rows[0]['is_coordinator2'] = json_decode($rows[0]['is_coordinator2'], true);
                    // $work_flow_row =  $parant_data['work_flow_row'];
                    $menus = $this->FillMenu();
                    $screens = $menus['screens'];
                    $modules = $menus['modules'];
                    if($rows[0]['meeting_status'] == "Completed")
                    {
                        return view('ovm2.show', compact('cc','users','rows', 'screens', 'modules'));

                    }
                    else
                    {
                        return view('ovm2.ovmsent2', compact('parentID','attendeeID','cc','users','attachment','attendee','rows', 'authID', 'screens', 'modules'));
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


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {


        try {
            // dd("sa");
            $method = 'Method => ovm2Controller => delete';
            //  $id = $this->decryptData($id);
            $gatewayURL = config('setting.api_gateway_url') . '/ovm2/data_delete/' . $id;
            $response = $this->serviceRequest($gatewayURL, 'GET', '', $method);
            $response1 = json_decode($response);

            if ($response1->Status == 200 && $response1->Success) {
                $objData = json_decode($this->decryptData($response1->Data));
                if ($objData->Code == 200) {
                    return redirect(route('ovm2.index'))
                        ->with('success', 'New Meeting Deleted Successfully');
                }
                if ($objData->Code == 400) {
                    return redirect(route('ovm2.index'))
                        ->with('fail', 'New Meeting Allocated One Role');
                }
            }
        } catch (\Exception $exc) {
            
            return $this->sendLog($method, $exc->getCode(), $exc->getMessage(), $exc->getLine(), $exc->getTrace()[0]['args'][2]);
        }
    }
    public function view_proposal_documents(Request $request)
    {

        $path = $request->id;
        $storagepath = public_path() . '/' . $path;
        // $this->WriteFileLog($storagepath);
        $converter = new OfficeConverterController($storagepath);
        $converter->convertTo('document-view.pdf');

        $documentViewPath = '/documents/pdfview' . '/document-view.pdf';
        return $documentViewPath;
    }
}
