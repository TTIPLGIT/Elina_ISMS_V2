<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use WpOrg\Requests\Session;
use Validator;
use App\Rules\NoUrls;

class serviceprovidercontroller extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return redirect(route('serviceprovider'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        try {
            // $user_id = $request->session()->get("userID");
            // if ($user_id == null) {
            //     return view('auth.login');
            // }
            $validator = Validator::make($request->all(), [
                'input_field' => [new NoUrls],
                'g-recaptcha-response' => 'required|captcha',
            ]);
            
            if ($validator->fails()) {
                return back()->with('error', 'Recaptcha Failed');
            }
            $method = 'Method => serviceprovidercontroller => store';
            $typesofservice =  $request->type_of_service;
            $data = array();
            $data['name'] = $request->name;
            $data['gender'] = $request->gender;
            $data['phone_number'] = $request->phone_number;
            $data['email_address'] = $request->email_address;
            $data['area_of_specializtion'] = $request->area_of_specializtion;
            $data['type_of_service'] = $request->type_of_service;
            $data['providing_home_service'] = $request->providing_home_service;
            $data['mode_of_service'] = $request->mode_of_service;
            $data['profession_charges_per_session'] = $request->profession_charges_per_session;
            $data['universtiy_name'] = $request->universtiy_name;
            $data['profession_qualification'] = $request->profession_qualification;
            $data['year_of_completion'] = $request->year_of_completion;
            $data['specialist_in'] = $request->specialist_in;
            $data['work_experience'] = $request->work_experience;
            $data['agree_of_acknowledgement'] = $request->agree_of_acknowledgement;
            if($typesofservice == "Organisation"){
                $data['organisation_name'] = $request->organisation_name;
                $data['organisation_head_name'] = $request->organisation_head_name;
                $data['organisation_email_address'] = $request->organisation_email_address;
                $data['organisation_website_info'] = $request->organisation_website_info;
                $data['specification_limitation_constraint'] = $request->specification_limitation_constraint;
            }
            else{
                $data['organisation_name'] = null;
                $data['organisation_head_name'] = null;
                $data['organisation_email_address'] = null;
                $data['organisation_website_info'] = null;
                $data['specification_limitation_constraint'] = null;
            }
                                    
            // $data['user_id'] = $user_id;
            $encryptArray = $this->encryptData($data);
            $request = array();
            $request['requestData'] = $encryptArray;
            $gatewayURL = config('setting.api_gateway_url') . '/serviveprovider/storedata';

            $response = $this->serviceRequest($gatewayURL, 'POST', json_encode($request), $method);
           

            $response1 = json_decode($response);

            if ($response1->Status == 200 && $response1->Success) {
                $objData = json_decode($this->decryptData($response1->Data));
                if ($objData->Code == 200) {
                    return redirect(route('serviceprovider'))->with('success', 'Successsfully Submitted your form');
                    // return view('enrollement.serviceprovidersubmit');
                        
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
    {
        //
        {
            try {
                $method = 'Method => NewenrollementController => show';
    
                // echo json_encode($id);exit;
                $gatewayURL = config('setting.api_gateway_url') . '/serviceproviderview/data_edit/' . $id;
    
                $response = $this->serviceRequest($gatewayURL, 'GET', '', $method);
    
                $response = json_decode($response);
    
                if ($response->Status == 200 && $response->Success) {
                    $objData = json_decode($this->decryptData($response->Data));
                    if ($objData->Code == 200) {
                        $parant_data = json_decode(json_encode($objData->Data), true);
                        $rows = $parant_data['rows'];
                        $mode_of_service = $rows[0]['mode_of_service'];
                        $mode_of_service = json_decode($mode_of_service, true);
                        $area_of_specializtion = json_decode($rows[0]['area_of_specializtion'], true);
                        $menus = $this->FillMenu();
                        if ($menus == "401") {
                            return redirect(route('/'))->with('danger', 'User session Exipired');
                        }
                        $screens = $menus['screens'];
                        $modules = $menus['modules'];
                        return view('newenrollement.serviceproviderview', compact('rows', 'screens', 'modules', 'mode_of_service', 'area_of_specializtion'));
                    }
                } else {
                    $objData = json_decode($this->decryptData($response->Data));
                    echo json_encode($objData->Code);
                    exit;
                }
            } catch (\Exception $exc) {
                return $this->sendLog($method, $exc->getCode(), $exc->getMessage(), $exc->getLine(), $exc->getTrace()[0]['args'][2]);
            }
    
            //
    
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
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
