<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class MasterPaymentController extends BaseController
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
            $method = 'Method => MasterPaymentController => index';

            $request =  array();
            $request['user_id'] = $user_id;

            $gatewayURL = config('setting.api_gateway_url') . '/payment_master/index';
            $response = $this->serviceRequest($gatewayURL, 'GET',  json_encode($request), $method);

            $response = json_decode($response);
            if ($response->Status == 200 && $response->Success) {
                $objData = json_decode($this->decryptData($response->Data));
                if ($objData->Code == 200) {
                    $parant_data = json_decode(json_encode($objData->Data), true);
                    $rows = $parant_data['rows'];
                    $logs = $parant_data['logs'];
                    $schools = $parant_data['school'];
                    // dd($parant_data);
                    $menus = $this->FillMenu();
                    $screens = $menus['screens'];
                    $modules = $menus['modules'];
                    return view('paymentmaster.index', compact('user_id', 'modules', 'screens', 'rows', 'logs','schools'));
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
        try {
            $method = 'Method => MasterPaymentController => create';
            $gatewayURL = config('setting.api_gateway_url') . '/payment_master/create';
            $response = $this->serviceRequest($gatewayURL, 'GET', '', $method);

            $response = json_decode($response);

            if ($response->Status == 200 && $response->Success) {
                $objData = json_decode($this->decryptData($response->Data));

                if ($objData->Code == 200) {
                    $parant_data = json_decode(json_encode($objData->Data), true);
                    $rows =  $parant_data['rows'];
                    $serviceMaster = $parant_data['serviceMaster'];

                    $menus = $this->FillMenu();
                    $screens = $menus['screens'];
                    $modules = $menus['modules'];
                    return view('paymentmaster.create', compact('rows', 'screens', 'modules', 'rows', 'serviceMaster'));
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
    public function store_data(Request $request)
    {
        $method = 'Method => MasterPaymentController => store_data';
        // dd($request);
        $data = array();
        $data['category_id']  = $request->Category;
        $data['fees_type_id'] =  $request->fees_type;
        $data['school_enrollment_id'] = $request->school;
        $data['status'] = $request->payment_status;
        // 
        $data['serviceBriefing'] = $request->serviceBriefing;
        $data['qty'] = $request->qty;
        $data['rate'] = $request->rate;
        $data['amount'] = $request->amount;
        $data['base_amount'] = $request->adjustedBaseAmount;
        // 
        $data['gstRate'] = $request->gstRate;
        // 
        $data['taxNames'] = $request->taxNames;
        $data['additionalTaxes'] = $request->additionalTaxes;
        // 
        $data['finalAmount'] = $request->finalAmount;

        $encryptArray = $this->encryptData($data);
        $request = array();
        $request['requestData'] = $encryptArray;
        // dd($data);
        $gatewayURL = config('setting.api_gateway_url') . '/payment_master/storedata';

        $response = $this->serviceRequest($gatewayURL, 'POST', json_encode($request), $method);
        $response1 = json_decode($response);
        if ($response1->Status == 200 && $response1->Success) {
            $objData = json_decode($this->decryptData($response1->Data));

            if ($objData->Code == 200) {
                return redirect(url('payment_master'))->with('success', 'Payment Master Added Successfully');
            }

            if ($objData->Code == 400) {
                return redirect(url('payment_master'))->with('fail', 'Payment Master Failed');
            }
        } else {
            $objData = json_decode($this->decryptData($response1->Data));
            echo json_encode($objData->Code);
            exit;
        }

        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        try {

            $method = 'Method => MasterQuestionCreationController => validationType';
            $data = array();
            $data['id'] = $request->id;
            $data['school_id'] = $request->school_id;

            $encryptArray = $this->encryptData($data);
            $request = array();
            $request['requestData'] = $encryptArray;
            $gatewayURL = config('setting.api_gateway_url') . '/payment_master/show';
            $response = $this->serviceRequest($gatewayURL, 'GET', json_encode($request), $method);
            $response1 = json_decode($response);

            if ($response1->Status == 200 && $response1->Success) {
                $objData = json_decode($this->decryptData($response1->Data));
                $data = json_decode(json_encode($objData->Data), true);
                return $data;
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
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit_data(Request $request, $id)
    {

        try {
            $method = 'Method => MasterQuestionCreationController => edit';
            $data = array();
            $data['id'] = $this->decryptData($id);

            $encryptArray = $this->encryptData($data);
            $request = array();
            $request['requestData'] = $encryptArray;
            $gatewayURL = config('setting.api_gateway_url') . '/payment_master/show';
            $response = $this->serviceRequest($gatewayURL, 'GET', json_encode($request), $method);
            $response1 = json_decode($response);
            if ($response1->Status == 200 && $response1->Success) {
                $objData = json_decode($this->decryptData($response1->Data));
                if ($objData->Code == 200) {
                    $parant_data = json_decode(json_encode($objData->Data), true);
                    // dd($parant_data );
                    $rows =  $parant_data['rows'];
                    // dd($rows);
                    $schoolists = $parant_data['schoolists'];
                    $serviceList = $parant_data['serviceList'];
                    $taxList = $parant_data['taxList'];
                    $serviceMaster = $parant_data['serviceMaster'];

                    $menus = $this->FillMenu();
                    $screens = $menus['screens'];
                    $modules = $menus['modules'];
                    return view('paymentmaster.edit', compact('rows', 'screens', 'modules', 'schoolists', 'serviceList', 'taxList', 'serviceMaster'));
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
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $method = 'Method => MasterPaymentController => update';

        $user_id = $request->session()->get("userID");
        if ($user_id == null) {
            return view('auth.login');
        }
        $data = array();
        $data['id']  = $request->id;
        $data['category_id']  = $request->Category;
        $data['fees_type_id'] =  $request->fees_type;
        $data['school_enrollment_id'] = $request->school;
        $data['status'] = $request->payment_status;
        // 
        $data['serviceBriefing'] = $request->serviceBriefing;
        $data['qty'] = $request->qty;
        $data['rate'] = $request->rate;
        $data['amount'] = $request->amount;
        $data['base_amount'] = $request->adjustedBaseAmount;
        // 
        $data['gstRate'] = $request->gstRate;
        // 
        $data['taxNames'] = $request->taxNames;
        $data['additionalTaxes'] = $request->additionalTaxes;
        // 
        $data['finalAmount'] = $request->finalAmount;

        $encryptArray = $this->encryptData($data);
        $request = array();
        $request['requestData'] = $encryptArray;

        $gatewayURL = config('setting.api_gateway_url') . '/payment_master/updatedata';

        $response = $this->serviceRequest($gatewayURL, 'POST', json_encode($request), $method);
        $response1 = json_decode($response);
        if ($response1->Status == 200 && $response1->Success) {
            $objData = json_decode($this->decryptData($response1->Data));

            if ($objData->Code == 200) {
                return redirect()->route('payment_master.index')->with('success', 'Payment Updated Successfully');
            }

            if ($objData->Code == 400) {
                return redirect()->route('payment_master.index')->with('fail', 'Payment Failed');
            }
        } else {
            $objData = json_decode($this->decryptData($response1->Data));
            echo json_encode($objData->Code);
            exit;
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function toggle(Request $request)
    {
        $this->WriteFileLog($request);
        try {

            $method = 'Method => MasterPaymentController => toggle';
            $data = array();
            $data['id'] = $request->paymentId;
            $data['selectedDate'] = $request->date;
            $this->WriteFileLog($data);
            $encryptArray = $this->encryptData($data);
            $request = array();
            $request['requestData'] = $encryptArray;
            $gatewayURL = config('setting.api_gateway_url') . '/payment/master/toggle_data';
            $response = $this->serviceRequest($gatewayURL, 'POST', json_encode($request), $method);
            $response1 = json_decode($response);
            //$this->WriteFileLog($response1);

            if ($response1->Status == 200 && $response1->Success) {
                $objData = json_decode($this->decryptData($response1->Data));
                $data = json_decode(json_encode($objData->Data), true);
                return $data;
            } else {
                $objData = json_decode($this->decryptData($response1->Data));
                echo json_encode($objData->Code);
                exit;
            }
        } catch (\Exception $exc) {

            return $this->sendLog($method, $exc->getCode(), $exc->getMessage(), $exc->getLine(), $exc->getTrace()[0]['args'][2]);
        }
    }
    public function hold(Request $request)
    {
        $this->WriteFileLog($request);
        try {

            $method = 'Method => MasterPaymentController => hold';
            $data = array();
            $data['id'] = $request->paymentId;
            $data['selectedDate'] = $request->date;
            $this->WriteFileLog($data);
            $encryptArray = $this->encryptData($data);
            $request = array();
            $request['requestData'] = $encryptArray;
            $gatewayURL = config('setting.api_gateway_url') . '/payment/master/hold_data';
            $response = $this->serviceRequest($gatewayURL, 'POST', json_encode($request), $method);
            $response1 = json_decode($response);
            // $this->WriteFileLog($response1);

            if ($response1->Status == 200 && $response1->Success) {
                $objData = json_decode($this->decryptData($response1->Data));
                $data = json_decode(json_encode($objData->Data), true);
                return $data;
            } else {
                $objData = json_decode($this->decryptData($response1->Data));
                echo json_encode($objData->Code);
                exit;
            }
        } catch (\Exception $exc) {

            return $this->sendLog($method, $exc->getCode(), $exc->getMessage(), $exc->getLine(), $exc->getTrace()[0]['args'][2]);
        }
    }
    public function cancel(Request $request)
    {
        $this->WriteFileLog($request);
        try {

            $method = 'Method => MasterPaymentController => cancel';
            $data = array();
            $data['id'] = $request->paymentId;

            $this->WriteFileLog($data);
            $encryptArray = $this->encryptData($data);
            $request = array();
            $request['requestData'] = $encryptArray;
            $gatewayURL = config('setting.api_gateway_url') . '/payment/master/cancel';
            $response = $this->serviceRequest($gatewayURL, 'POST', json_encode($request), $method);
            $response1 = json_decode($response);
            // $this->WriteFileLog($response1);

            if ($response1->Status == 200 && $response1->Success) {
                $objData = json_decode($this->decryptData($response1->Data));
                $data = json_decode(json_encode($objData->Data), true);
                return $data;
            } else {
                $objData = json_decode($this->decryptData($response1->Data));
                echo json_encode($objData->Code);
                exit;
            }
        } catch (\Exception $exc) {

            return $this->sendLog($method, $exc->getCode(), $exc->getMessage(), $exc->getLine(), $exc->getTrace()[0]['args'][2]);
        }
    }
}
