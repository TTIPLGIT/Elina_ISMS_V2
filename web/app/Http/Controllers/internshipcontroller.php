<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Validator;
use Redirect;
use App\Rules\NoUrls;

class internshipcontroller extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
            $method = 'Method => ovm1Controller => store';
            $validator = Validator::make($request->all(), [
                // 'file' => 'mimes:pdf,doc,docx|max:5000',
                // 'email_address' => 'email:rfc,dns',
                'input_field' => [new NoUrls],
                'g-recaptcha-response' => 'required|captcha',
            ]);
            $react_web = isset($request->react_web)?$request->react_web:FALSE;
            if ($validator->fails()) {
                if ($react_web) {
                    return response()->json([
                        'message' => 'Recaptcha Failed.',
                        'code' => 400
                    ], 400);
                } else {
                    return back()->with('error', 'Recaptcha Failed');
                }
                // dd($validator->errors());
               
            }
            // dd($validator->errors());
            $email_address =  $request->email_address;
    
            $data = array();
            $data['name'] = $request->name;
            $data['date_of_birth'] = $request->date_of_birth;
            $data['contact_number'] = $request->contact_number;
            $data['parent_guardian_contact_number'] = $request->parent_guardian_contact_number;
            $data['start_date_with_elina'] = $request->start_date_with_elina;
            $data['hours_intern_elina_per_week'] = $request->hours_intern_elina_per_week;
            $data['email_address'] = $request->email_address;

            $data['agreement'] = $request->agreement;

            $rules = [
                'short_introduction' => 'required',
                'about_elina' => 'required',
                'intern_with_elina' => 'required',
            ];
            $messages = [
                'short_introduction.required' => 'required|file|max:2048',
                'about_elina.required' => 'required|file|max:2048',
                'intern_with_elina.required' => 'required|file|max:2048',
            ];
            $validator = Validator::make($request->all(), $rules, $messages);
            if($validator->fails()){
               return Redirect::back()->withErrors($validator);
            }
            $storagepath_shortintrof = public_path() . '/userdocuments/registration/internship/shortintro/'. $email_address ;
            $storagepath_shortintrof1 = '/userdocuments/registration/internship/shortintro/'. $email_address ;
            if (!File::exists($storagepath_shortintrof)) {
                File::makeDirectory($storagepath_shortintrof);
            }
            $documentsf =  $request['short_introduction'];
               
            $files = $documentsf->getClientOriginalName();
           
            $findspace = array(' ', '&',"'",'"');
            $replacewith = array('-', '-');
            $proposal_files = str_replace($findspace, $replacewith, $files);
            $documentsf->move($storagepath_shortintrof, $proposal_files);
            $data['short_introduction_fn'] = $proposal_files;  
            $data['short_introduction_fp'] = $storagepath_shortintrof1;  
            $storagepath_about_elina = public_path() . '/userdocuments/registration/internship/aboutelina/'. $email_address ;
            $storagepath_about_elina1 = '/userdocuments/registration/internship/aboutelina/'. $email_address ;
            if (!File::exists($storagepath_about_elina)) {
                File::makeDirectory($storagepath_about_elina);
            }
            $documentsf =  $request['about_elina'];
               
            $files = $documentsf->getClientOriginalName();
           
            $findspace = array(' ', '&',"'",'"');
            $replacewith = array('-', '-');
            $proposal_files = str_replace($findspace, $replacewith, $files);
            $documentsf->move($storagepath_about_elina, $proposal_files);
            $data['about_elina_fn'] = $proposal_files;  
            $data['about_elina_fp'] = $storagepath_about_elina1;  
            //
            $storagepath_intern_with_elina = public_path() . '/userdocuments/registration/internship/internwithelina/'. $email_address ;
            $storagepath_intern_with_elina1 = '/userdocuments/registration/internship/internwithelina/'. $email_address ;
            if (!File::exists($storagepath_intern_with_elina)) {
                File::makeDirectory($storagepath_intern_with_elina);
            }
            $documentsf =  $request['intern_with_elina'];
               
            $files = $documentsf->getClientOriginalName();
           
            $findspace = array(' ', '&',"'",'"');
            $replacewith = array('-', '-');
            $proposal_files = str_replace($findspace, $replacewith, $files);
            $documentsf->move($storagepath_intern_with_elina, $proposal_files);
            $data['intern_with_elina_fn'] = $proposal_files;  
            $data['intern_with_elina_fp'] = $storagepath_intern_with_elina1;
            // $data['user_id'] = $user_id;
            $encryptArray = $this->encryptData($data);
            $request = array();
            $request['requestData'] = $encryptArray;
            $gatewayURL = config('setting.api_gateway_url') . '/internship/storedata';

            $response = $this->serviceRequest($gatewayURL, 'POST', json_encode($request), $method);
           
            $response1 = json_decode($response);
            if ($response1->Status == 200 && $response1->Success) {
                $objData = json_decode($this->decryptData($response1->Data));
                if ($objData->Code == 200) {
                    if ($react_web) {
                        return response()->json([
                            'message' => 'Successsfully Submitted your form.',
                            'code' => 200
                        ], 200);
                    }  
                    return redirect(route('intern'))->with('success', 'Successsfully Submitted your form');
                    // return view('enrollement.internsubmit');
                }
              
            } else {
                $objData = json_decode($this->decryptData($response1->Data));
                // echo json_encode($objData->Code);exit;;
                if ($objData->Code == 401) {
        
                            return redirect(route('/'))->with('error', 'User Session Expired');
                        }
                if ($objData->Code == 400) {
                    if ($react_web) {
                        return response()->json([
                            'message' => 'The provided email address has already been registered.',
                            'code' => 400
                        ], 400);
                    } else {
                        return redirect(route('/'))->with('error', 'The provided email address has already been registered. Please log in using this email or register with a different email address.');
                    }
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
        {
            try {
                $method = 'Method => NewenrollementController => show';
                // echo json_encode($id);exit;
                $gatewayURL = config('setting.api_gateway_url') . '/internview/data_edit/' . $id;
    
                $response = $this->serviceRequest($gatewayURL, 'GET', '', $method);
    
                $response = json_decode($response);
    
                if ($response->Status == 200 && $response->Success) {
                    $objData = json_decode($this->decryptData($response->Data));
                    if ($objData->Code == 200) {
                        $parant_data = json_decode(json_encode($objData->Data), true);
    
                        $rows = $parant_data['rows'];
    
                        // $services_from_elina = $rows[0]['services_from_elina'];
                        // $subparant_data = json_decode($services_from_elina, true);
    
    
                        // $knmabtelina_data = json_decode($rows[0]['how_knowabt_elina'], true);
    
                        $menus = $this->FillMenu();
                        if ($menus == "401") {
                            return redirect(route('/'))->with('danger', 'User session Exipired');
                        }
                        $screens = $menus['screens'];
                        $modules = $menus['modules'];
                        return view('newenrollement.internview', compact('rows', 'screens', 'modules'));
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
        {
            try {
                $method = 'Method => NewenrollementController => show';
    
                 // echo json_encode($id);exit;
                $gatewayURL = config('setting.api_gateway_url') . '/internview/data_edit/' . $id;
    
                $response = $this->serviceRequest($gatewayURL, 'GET', '', $method);
    
                $response = json_decode($response);
    
                if ($response->Status == 200 && $response->Success) {
                    $objData = json_decode($this->decryptData($response->Data));
                    if ($objData->Code == 200) {
                        $parant_data = json_decode(json_encode($objData->Data), true);
    
                        $rows = $parant_data['rows'];
    
                        // $services_from_elina = $rows[0]['services_from_elina'];
                        // $subparant_data = json_decode($services_from_elina, true);
    
    
                        // $knmabtelina_data = json_decode($rows[0]['how_knowabt_elina'], true);
    
                        $menus = $this->FillMenu();
                        if ($menus == "401") {
                            return redirect(route('/'))->with('danger', 'User session Exipired');
                        }
                        $screens = $menus['screens'];
                        $modules = $menus['modules'];
                        return view('newenrollement.internview', compact('rows', 'screens', 'modules'));
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
