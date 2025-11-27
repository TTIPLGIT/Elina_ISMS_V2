<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use League\CommonMark\Extension\Attributes\Node\Attributes;

class ElinademoforparentsController extends BaseController
{
    //
    public function index(Request $request)
    {
        $user_id=$request->session()->get("userID");
        if($user_id==null){
            return view('auth.login');
        }
        $method = 'Method => ElinademoforparentsController => index';

        $request =  array();
         $request['user_id'] = $user_id;

         $gatewayURL = config('setting.api_gateway_url').'/Elinademo/index';
        $response = $this->serviceRequest($gatewayURL, 'GET',  json_encode($request), $method); 
        
        $response = json_decode($response);
        
         $objData = json_decode($this->decryptData($response->Data)); 
         $response_data = json_decode(json_encode($objData->Data), true);  
         $rows = $response_data['rows'];  
       
        $menus = $this->FillMenu();
        $screens = $menus['screens'];
        $modules = $menus['modules'];
        return view('elinademo.index', compact('user_id','rows','modules','screens'));
        //
    }


    public function create(Request $request)
    {
            
        try {
            $method = 'Method => ElinademoforparentsController => create';
            $gatewayURL = config('setting.api_gateway_url') . '/Elinademo/create';
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
                    return view('elinademo.create', compact('rows', 'screens', 'modules'));
                }
            } else {
                $objData = json_decode($this->decryptData($response->Data));
                echo json_encode($objData->Code);
                exit;
            }
        } catch (\Exception $exc) {
            echo $exc;
            
        }
    }
    public function store(Request $request)
    {
        try {
            $method = 'Method => ElinademoforparentsController => index';

            $user_id = $request->session()->get("userID");
            if ($user_id == null) {
                return view('auth.login');
            }
            
            if($request->hasFile('file'))     
            {
                
                $storagePath = public_path().'/demo_document';

                $imageFile = $request->file('file');
                $imageName = $imageFile->getClientOriginalName();
                // $storagePath = storage_path().'\app\uploads\images';
                
                $imageFile->move($storagePath, $imageName);
                
                
            }

            $method = 'Method => ElinademoforparentsController => store';
            $data = array();
            $data['enrollment_id'] = $request->enrollment_child_num;
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
            $data['meeting_status'] = $request->type;
            $data['attached_file_path'] = $storagePath;
            $data['imagename'] = $imageName;
            $data['type'] = $request->type;
            $data['user_id'] = $user_id;
                
            $encryptArray = $this->encryptData($data);
            $request = array();
            $request['requestData'] = $encryptArray;
            $gatewayURL = config('setting.api_gateway_url') . '/Elinademo/store';
            $response = $this->serviceRequest($gatewayURL, 'POST', json_encode($request), $method);
            $response1 = json_decode($response);
            if ($response1->Status == 200 && $response1->Success) {
                $objData = json_decode($this->decryptData($response1->Data));


                if ($objData->Code == 200) {
                    return redirect(route('elinademo.index'))->with('success', 'Elinademo Created Successfully');
                }

                if ($objData->Code == 400) {
                    return redirect(route('elinademo.index'))->with('error', 'Elinademo Name Already Exists');
                }
                if ($objData->Code == 401) {
                    return redirect(route('/'))->with('error', 'User Session Expired');
                }
            } else {
                $objData = json_decode($this->decryptData($response1->Data));
                echo json_encode($objData->Code);
                exit;
            }
            
        } catch (\Exception $exc) {
            echo $exc;
            
        }
    }
    public function show($id)
    { 
        
            try {
                $method = 'Method => ElinademoforparentsController => show';
                    
                // echo json_encode($id);exit;
                $gatewayURL = config('setting.api_gateway_url') . '/Elinademo/data_edit/' . $this->encryptData($id);

                $response = $this->serviceRequest($gatewayURL, 'GET', '', $method);

                $response = json_decode($response);

                if ($response->Status == 200 && $response->Success) {
                    $objData = json_decode($this->decryptData($response->Data));
                    if ($objData->Code == 200) {
                        $parant_data = json_decode(json_encode($objData->Data), true);


                        $rows = $parant_data['rows'];



                        $menus = $this->FillMenu();
                        $screens = $menus['screens'];
                        $modules = $menus['modules'];
                        return view('elinademo.show', compact('rows', 'screens', 'modules'));
                    }
                } else {
                    $objData = json_decode($this->decryptData($response->Data));
                    echo json_encode($objData->Code);
                    exit;
                }
            } catch (\Exception $exc) {
                
            }
    

        

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
            $method = 'Method => ElinademoforparentsController => edit';

            $gatewayURL = config('setting.api_gateway_url') . '/Elinademo/data_edit/' . $this->encryptData($id);

            $response = $this->serviceRequest($gatewayURL, 'GET', '', $method);
            $response = json_decode($response);

            if ($response->Status == 200 && $response->Success) {
                $objData = json_decode($this->decryptData($response->Data));
                if ($objData->Code == 200) {
                    $parant_data = json_decode(json_encode($objData->Data), true);
                    $rows = $parant_data['rows'];

                    $rows[0]['is_coordinator1'] = json_decode($rows[0]['is_coordinator1'], true);
                    

                    // $work_flow_row =  $parant_data['work_flow_row'];
                    $menus = $this->FillMenu();
                    $screens = $menus['screens'];
                    $modules = $menus['modules'];
                    return view('elinademo.edit', compact('rows', 'screens', 'modules'));
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
            echo $exc;
            
        }
    }
    public function ovmsent($id)
    {
        try {
            $method = 'Method => ElinademoforparentsController  => edit';

            $gatewayURL = config('setting.api_gateway_url') . '/Elinademo/data_edit/' . $this->encryptData($id);

            $response = $this->serviceRequest($gatewayURL, 'GET', '', $method);
            $response = json_decode($response);

            if ($response->Status == 200 && $response->Success) {
                $objData = json_decode($this->decryptData($response->Data));
                if ($objData->Code == 200) {
                    $parant_data = json_decode(json_encode($objData->Data), true);
                    $rows = $parant_data['rows'];

                    $rows[0]['is_coordinator1'] = json_decode($rows[0]['is_coordinator1'], true);
                   
                    // $work_flow_row =  $parant_data['work_flow_row'];
                    $menus = $this->FillMenu();
                    $screens = $menus['screens'];
                    $modules = $menus['modules'];
                    return view('Elinademo.ovmsent', compact('rows', 'screens', 'modules'));
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
            echo $exc;
            
        }
    }

    public function update(Request $request, $id)
    {
        

        try {
            
            $user_id = $request->session()->get("userID");

            if ($user_id == null) {
                return view('auth.login');
            }
            
            
           
            $method = 'Method =>  ElinademoforparentsController => update_data';
            $data = array();
            $data['id'] = $id;
            $data['enrollment_id'] = $request->enrollment_id;
            $data['demo_unique'] = $request->demo_unique;
            
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
            // $data['meeting_status'] =  ($request->type =='sent')?$request->type:$request->meeting_status;
            
            $data['type'] = $request->type;
            $data['user_id'] = $user_id;
            
            $encryptArray = $this->encryptData($data);
            $request = array();
            $request['requestData'] = $encryptArray;
            $gatewayURL = config('setting.api_gateway_url') . '/Elinademo/updatedata';
            $response = $this->serviceRequest($gatewayURL, 'POST', json_encode($request), $method);
            $response1 = json_decode($response);

            if ($response1->Status == 200 && $response1->Success) {

                $objData = json_decode($this->decryptData($response1->Data));

                if ($objData->Code == 200) {
                    return redirect(route('elinademo.index'))
                        ->with('success', 'meeting invite Updated Successfully');
                }
                if ($objData->Code == 400) {
                    return Redirect::back()
                        ->with('fail', 'meeting invite Name Already Exists');
                }
            } else {
                $objData = json_decode($this->decryptData($response1->Data));
                echo json_encode($objData->Code);
                exit;
            }
        } catch (\Exception $exc) {
            
        }
    }
    public function delete($id)
    {

        try {
            $method = 'Method => ElinademoforparentsController => delete';
            //  $id = $this->decryptData($id);
            $gatewayURL = config('setting.api_gateway_url') . '/Elinademo/data_delete/' . $this->encryptData($id);
            $response = $this->serviceRequest($gatewayURL, 'GET', '', $method);
            $response1 = json_decode($response);


            if ($response1->Status == 200 && $response1->Success) {
                $objData = json_decode($this->decryptData($response1->Data));
                if ($objData->Code == 200) {
                    return redirect(route('elinademo.index'))
                        ->with('success', 'new meeting Screen Deleted Successfully');
                }
                if ($objData->Code == 400) {
                    return redirect(route('elinademo.index'))
                        ->with('fail', 'new meeting Screen Allocated One Role');
                }
            }
        } catch (\Exception $exc) {
            echo $exc;
            
        }
    }
}
