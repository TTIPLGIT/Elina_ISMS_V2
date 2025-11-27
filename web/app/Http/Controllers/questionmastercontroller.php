<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
class questionmastercontroller extends BaseController
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
            if ($user_id == null) {
                return view('auth.login');
            }
            $method = 'Method => LoginController => Register_screen';

            $request =  array();
            $request['user_id'] = $user_id;

            $gatewayURL = config('setting.api_gateway_url') . '/Questionmaster/index';
            $response = $this->serviceRequest($gatewayURL, 'GET',  json_encode($request), $method);

            $response = json_decode($response);
            if ($response->Status == 200 && $response->Success) {
                $objData = json_decode($this->decryptData($response->Data));
                if ($objData->Code == 200) {
                    $parant_data = json_decode(json_encode($objData->Data), true);
                    $rows = $parant_data['rows'];
                    $menus = $this->FillMenu();
                      if ($menus == "401") {
                        return back()->withErrors(['recaptcha' => ['Invalid user name or password']]);
                    }
                    $screens = $menus['screens'];
                    $modules = $menus['modules'];
                    return view('tokenmaster.index', compact('user_id', 'modules', 'screens', 'rows'));
                    //
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
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    { {

            $user_id = $request->session()->get("userID");
            if ($user_id == null) {
                return view('auth.login');
            }
            $data = array();
            $token_expire_time = $request->token_expire_time;
            $expire_type = $request->expire_type;
            $token_expire_time = ($expire_type === "Days") ?  $token_expire_time * 24 * 60 :  $token_expire_time * 60;
            $data['token_expire_time'] = $token_expire_time;
            $data['token_process'] =  $request->token_process;
            $data['token_expire_type'] = $expire_type;
            $data['user_id'] = $user_id;
            $method = 'Method => Questionmaster => store';
            $encryptArray = $data;
            $request = array();
            $request['requestData'] = $encryptArray;
            $gatewayURL = config('setting.api_gateway_url') . '/master/storequestion';

            $response = $this->serviceRequest($gatewayURL, 'POST', json_encode($request), $method);
            $response1 = json_decode($response);
            if ($response1->Status == 200 && $response1->Success) {
                $objData = json_decode($this->decryptData($response1->Data));

                if ($objData->Code == 200) {
                    return redirect(url('tokenmaster'))->with('success', 'Token Expire Time Added Successfully');
                }

                if ($objData->Code == 400) {
                    return redirect(url('tokenmaster'))->with('fail', 'Token Expire Time Already Exists');
                }
            } else {
                $objData = json_decode($this->decryptData($response1->Data));
                echo json_encode($objData->Code);
                exit;
            }
        }
        //
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
                $method = 'Method => questionmastercontroller => show';
                $id = $this->decryptData($id);
                // echo json_encode($id);exit;
                $gatewayURL = config('setting.api_gateway_url') . '/Questionmaster/data_edit/' . $this->encryptData($id);
                $response = $this->serviceRequest($gatewayURL, 'GET', '', $method);
                $response = json_decode($response);
                if ($response->Status == 200 && $response->Success) {
                    $objData = json_decode($this->decryptData($response->Data));
                    if ($objData->Code == 200) {
                        $parant_data = json_decode(json_encode($objData->Data), true);
                        $rows =  $parant_data['rows'];
                        $one_row =  $parant_data['one_rows'];
                        $menus = $this->FillMenu();
                        $screens = $menus['screens'];
                        $modules = $menus['modules'];
                        return view('Questionmaster.show', compact('rows', 'one_row', 'screens', 'modules'));
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
            $method = 'Method => questionmastercontroller => edit';
            $id = $this->decryptData($id);
            $gatewayURL = config('setting.api_gateway_url') . '/Questionmaster/data_edit/' . $this->encryptData($id);
            $response = $this->serviceRequest($gatewayURL, 'GET', '', $method);
            $response = json_decode($response);
            if ($response->Status == 200 && $response->Success) {
                $objData = json_decode($this->decryptData($response->Data));
                if ($objData->Code == 200) {
                    $parant_data = json_decode(json_encode($objData->Data), true);
                    $rows =  $parant_data['rows'];
                    // $work_flow_row =  $parant_data['work_flow_row'];
                    $menus = $this->FillMenu();
                    $screens = $menus['screens'];
                    $modules = $menus['modules'];

                    return view('Questionmaster.edit', compact('rows', 'screens', 'modules'));
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
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        try {
            $method = 'Method =>  questionmastercontroller => update_data';
            $user_id = $request->session()->get("userID");
            if ($user_id == null) {
                return view('auth.login');
            }

            $data = array();
            $token_expire_time = $request->token_expire_time;
            $expire_type = $request->expire_type;
            $token_expire_time = ($expire_type === "Days") ?  $token_expire_time * 24 * 60 :  $token_expire_time * 60;
            $data['token_expire_time'] = $token_expire_time;
            $data['token_process'] = $request->token_process;
            $data['token_expire_type'] = $expire_type;
            $data['user_id'] = $user_id;
            $data['token_parameterisation_id'] = $id;
            $encryptArray = $this->encryptData($data);
            $request = array();
            $request['requestData'] = $encryptArray;
            $gatewayURL = config('setting.api_gateway_url') . '/Questionmaster/updatedata';
            $response = $this->serviceRequest($gatewayURL, 'POST', json_encode($request), $method);
            $response1 = json_decode($response);

            if ($response1->Status == 200 && $response1->Success) {

                $objData = json_decode($this->decryptData($response1->Data));

                if ($objData->Code == 200) {
                    return redirect(route('tokenmaster.index'))->with('success', 'Question Master Updated Successfully');
                }
                if ($objData->Code == 400) {
                    return Redirect::back()->with('fail', 'tokenmaster Name Already Exists');
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
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {


        try {
            $method = 'Method => questionmastercontroller => delete';
            $id = $this->decryptData($id);
            $gatewayURL = config('setting.api_gateway_url') . '/master/data_delete/' . $this->encryptData($id);
            $response = $this->serviceRequest($gatewayURL, 'GET', '', $method);
            $response1 = json_decode($response);
            if ($response1->Status == 200 && $response1->Success) {
                $objData = json_decode($this->decryptData($response1->Data));
                if ($objData->Code == 200) {
                    return redirect(route('tokenmaster.index'))->with('success', 'tokenmaster Screen Deleted Successfully');
                }
                if ($objData->Code == 400) {
                    return redirect(route('tokenmaster.index'))->with('fail', 'tokenmaster Screen Allocated One Role');
                }
            }
        } catch (\Exception $exc) {
            
            return $this->sendLog($method, $exc->getCode(), $exc->getMessage(), $exc->getLine(), $exc->getTrace()[0]['args'][2]);
        }
    }
}
