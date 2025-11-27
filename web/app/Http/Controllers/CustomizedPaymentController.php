<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class CustomizedPaymentController extends BaseController
{
    public function index(Request $request)
    {
        try {
            $method = 'Method => CustomizedPaymentController => index';

            // $menus = $this->FillMenu();
            // $screens = $menus['screens'];
            // $modules = $menus['modules'];
            // return view('paymentmaster.customized_payment.index', compact('modules', 'screens'));

            $gatewayURL = config('setting.api_gateway_url') . '/payment/customized/sail/index';
            $response = $this->serviceRequest($gatewayURL, 'GET', '', $method);

            $response = json_decode($response);
            if ($response->Status == 200 && $response->Success) {
                $objData = json_decode($this->decryptData($response->Data));
                if ($objData->Code == 200) {
                    $parant_data = json_decode(json_encode($objData->Data), true);
                    $rows = $parant_data['rows'];
                    // dd($parant_data);

                    $menus = $this->FillMenu();
                    $screens = $menus['screens'];
                    $modules = $menus['modules'];
                    return view('paymentmaster.customized_payment.index', compact('modules', 'screens', 'rows'));
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
            $method = 'Method => CustomizedPaymentController => create';
            $gatewayURL = config('setting.api_gateway_url') . '/payment/customized/sail/create';
            $response = $this->serviceRequest($gatewayURL, 'GET', '', $method);

            $response = json_decode($response);

            if ($response->Status == 200 && $response->Success) {
                $objData = json_decode($this->decryptData($response->Data));

                if ($objData->Code == 200) {
                    $parant_data = json_decode(json_encode($objData->Data), true);
                    // dd($parant_data );
                    $rows =  $parant_data['rows'];
                    // dd($rows);
                    $schoolists = $parant_data['schoolists'];
                    $serviceList = $parant_data['serviceList'];
                    $taxList = $parant_data['taxList'];
                    $childDetails = $parant_data['childDetails'];

                    $menus = $this->FillMenu();
                    $screens = $menus['screens'];
                    $modules = $menus['modules'];
                    return view('paymentmaster.customized_payment.create', compact('rows', 'screens', 'modules', 'schoolists', 'serviceList', 'taxList', 'childDetails'));
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


    public function store_data(Request $request)
    {
        $method = 'Method => CustomizedPaymentController => store_data';
        // dd($request);
        $data = array();
        // 
        $data['child_enrollment']  = $request->child_enrollment;
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
        $gatewayURL = config('setting.api_gateway_url') . '/payment/customized/sail/storedata';

        $response = $this->serviceRequest($gatewayURL, 'POST', json_encode($request), $method);
        $response1 = json_decode($response);
        if ($response1->Status == 200 && $response1->Success) {
            $objData = json_decode($this->decryptData($response1->Data));

            if ($objData->Code == 200) {
                return redirect(url('payment/customized/sail'))->with('success', 'Payment Master Added Successfully');
            }

            if ($objData->Code == 400) {
                return redirect(url('payment/customized/sail'))->with('fail', 'Payment Master Failed');
            }
        } else {
            $objData = json_decode($this->decryptData($response1->Data));
            echo json_encode($objData->Code);
            exit;
        }

        //
    }

    public function getdata(Request $request, $id)
    {
        try {

            $method = 'Method => MasterQuestionCreationController => getdata';

            $data = array();
            $data['id'] = $this->decryptData($id);

            $encryptArray = $this->encryptData($data);
            $request = array();
            $request['requestData'] = $encryptArray;
            $gatewayURL = config('setting.api_gateway_url') . '/payment/customized/sail/getdata';
            $response = $this->serviceRequest($gatewayURL, 'GET', json_encode($request), $method);
            $response1 = json_decode($response);

            if ($response1->Status == 200 && $response1->Success) {
                $objData = json_decode($this->decryptData($response1->Data));

                $parant_data = json_decode(json_encode($objData->Data), true);
                // dd($parant_data);
                $rows =  $parant_data['rows'];
                $schoolists = $parant_data['schoolists'];
                $serviceList = $parant_data['serviceList'];
                $taxList = $parant_data['taxList'];
                $childDetails = $parant_data['childDetails'];

                $menus = $this->FillMenu();
                $screens = $menus['screens'];
                $modules = $menus['modules'];
                return view('paymentmaster.customized_payment.edit', compact('rows', 'screens', 'modules', 'schoolists', 'serviceList', 'taxList', 'childDetails'));
            } else {
                $objData = json_decode($this->decryptData($response1->Data));
                echo json_encode($objData->Code);
                exit;
            }
        } catch (\Exception $exc) {

            return $this->sendLog($method, $exc->getCode(), $exc->getMessage(), $exc->getLine(), $exc->getTrace()[0]['args'][2]);
        }
    }

    public function update(Request $request)
    {
        $method = 'Method => MasterPaymentController => update';

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

        $gatewayURL = config('setting.api_gateway_url') . '/payment/customized/sail/updatedata';

        $response = $this->serviceRequest($gatewayURL, 'POST', json_encode($request), $method);
        $response1 = json_decode($response);
        if ($response1->Status == 200 && $response1->Success) {
            $objData = json_decode($this->decryptData($response1->Data));

            if ($objData->Code == 200) {
                return redirect(url('payment/customized/sail'))->with('success', 'Payment Updated Successfully');
            }

            if ($objData->Code == 400) {
                return redirect(url('payment/customized/sail'))->with('fail', 'Payment Failed');
            }
        } else {
            $objData = json_decode($this->decryptData($response1->Data));
            echo json_encode($objData->Code);
            exit;
        }
    }
}
