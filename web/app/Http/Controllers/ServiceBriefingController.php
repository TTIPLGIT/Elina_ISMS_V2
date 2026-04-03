<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class ServiceBriefingController extends BaseController
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
            $method = 'Method => ServiceBriefingController => index';

            $request =  array();
            $request['user_id'] = $user_id;

            $gatewayURL = config('setting.api_gateway_url') . '/service_briefing_master/index';
            $response = $this->serviceRequest($gatewayURL, 'GET',  json_encode($request), $method);

            $response = json_decode($response);
            if ($response->Status == 200 && $response->Success) {
                $objData = json_decode($this->decryptData($response->Data));
                if ($objData->Code == 200) {
                    $parant_data = json_decode(json_encode($objData->Data), true);

                    $serviceList = $parant_data['serviceList'];
                    $menus = $this->FillMenu();
                    $screens = $menus['screens'];
                    $modules = $menus['modules'];
                    return view('service_briefing.index', compact('user_id', 'modules', 'screens', 'serviceList'));
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
    public function create(Request $request)
    {
        try {
            $user_id = $request->session()->get("userID");
            if ($user_id == null) {
                return view('auth.login');
            }
            $method = 'Method => ServiceBriefingController => create';

            $request =  array();
            $request['user_id'] = $user_id;

            $gatewayURL = config('setting.api_gateway_url') . '/service_briefing_master/create';
            $response = $this->serviceRequest($gatewayURL, 'GET',  json_encode($request), $method);

            $response = json_decode($response);
            if ($response->Status == 200 && $response->Success) {
                $objData = json_decode($this->decryptData($response->Data));
                if ($objData->Code == 200) {
                    $parant_data = json_decode(json_encode($objData->Data), true);

                    $serviceList = $parant_data['serviceList'];
                    $menus = $this->FillMenu();
                    $screens = $menus['screens'];
                    $modules = $menus['modules']; 
                    return view('service_briefing.create', compact('user_id', 'modules', 'screens', 'serviceList'));
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
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $method = 'Method => ServiceBriefingController => store';
        // dd($request);
        $data = array();
        $data['service_briefing']  = $request->service_briefing;
        $data['amount'] =  $request->amount;
        $encryptArray = $this->encryptData($data);
        $request = array();
        $request['requestData'] = $encryptArray;
        // dd($data);
        $gatewayURL = config('setting.api_gateway_url') . '/service_briefing_master/storedata';

        $response = $this->serviceRequest($gatewayURL, 'POST', json_encode($request), $method);
        $response1 = json_decode($response);
        if ($response1->Status == 200 && $response1->Success) {
            $objData = json_decode($this->decryptData($response1->Data));
            if ($objData->Code == 200) {
                return redirect()->route('service_briefing.index')
                    ->with('success', 'Service Briefing Added Successfully');
            }

            if ($objData->Code == 400) {
                return redirect()->route('service_briefing.index')
                    ->with('fail', 'Service Briefing  Failed');
            }
        } else {
            $objData = json_decode($this->decryptData($response1->Data));
            echo json_encode($objData->Code);
            exit;
        }

        //
    }

    public function delete($id)
    {
        try {
            $method = 'Method => ServiceBriefingController => delete';

            // 🔓 Decrypt incoming ID
            $id = $this->decryptData($id);
            // dd($id);
            // 🔐 Encrypt again for API
            $gatewayURL = config('setting.api_gateway_url')
                . '/service_briefing_master/delete/'
                . $this->encryptData($id);

            $response = $this->serviceRequest($gatewayURL, 'GET', '', $method);

            $response1 = json_decode($response);

            if ($response1->Status == 200 && $response1->Success) {

                $objData = json_decode($this->decryptData($response1->Data));

                if ($objData->Code == 200) {
                    return redirect()
                        ->route('service_briefing.index')
                        ->with('success', 'Service Deleted Successfully');
                }

                if ($objData->Code == 400) {
                    return redirect()
                        ->route('service_briefing.index')
                        ->with('fail', 'Something Went Wrong');
                }
            }
        } catch (\Exception $exc) {
            return $this->sendLog(
                $method,
                $exc->getCode(),
                $exc->getMessage(),
                $exc->getLine(),
                $exc->getTrace()[0]['args'][2]
            );
        }
    }

    function show($id)
    {
        try {

            $method = 'Method => ServiceBriefingController => show';
            $data = array();
            $id = decrypt($id);

            // Encrypt the request data
            $encryptArray = $this->encryptData($data);

            $requestPayload = array();
            $requestPayload['requestData'] = $encryptArray;

            // Service URL for service_briefing
            $gatewayURL = config('setting.api_gateway_url') . '/service_briefing/show/' . $this->encryptData($id);

            // Make the service request
            $response = $this->serviceRequest($gatewayURL, 'GET', json_encode($requestPayload), $method);

            $responseObj = json_decode($response);

            if ($responseObj->Status == 200 && $responseObj->Success) {
                // Decrypt response data
                $objData = json_decode($this->decryptData($responseObj->Data));
                $data = json_decode(json_encode($objData->Data), true);


                $menus = $this->FillMenu();
                $screens = $menus['screens'];
                $modules = $menus['modules'];
                return view('service_briefing.show', compact('modules', 'screens', 'data'));
            } else {
                $objData = json_decode($this->decryptData($responseObj->Data));
                echo json_encode($objData->Code);
                exit;
            }
        } catch (\Exception $exc) {

            return $this->sendLog($method, $exc->getCode(), $exc->getMessage(), $exc->getLine(), $exc->getTrace()[0]['args'][2]);
        }
    }
    public function edit($id)
    {


        try {
            $method = 'Method => ServiceBriefingController => edit';

            // Decrypt ID from URL
            $id = decrypt($id);

            // Gateway URL
            $gatewayURL = config('setting.api_gateway_url') . '/service_briefing/edit/' . $this->encryptData($id);

            $response = $this->serviceRequest($gatewayURL, 'GET', '', $method);
            $responseObj = json_decode($response);

            if ($responseObj->Status == 200 && $responseObj->Success) {

                $objData = json_decode($this->decryptData($responseObj->Data));

                if ($objData->Code == 200) {

                    $data = json_decode(json_encode($objData->Data), true);

                    $menus = $this->FillMenu();
                    $screens = $menus['screens'];
                    $modules = $menus['modules'];

                    return view(
                        'service_briefing.edit',
                        compact('modules', 'screens', 'data')
                    );
                }
            }

            $objData = json_decode($this->decryptData($responseObj->Data));
            echo json_encode($objData->Code);
            exit;
        } catch (\Exception $exc) {
            return $this->sendLog(
                $method,
                $exc->getCode(),
                $exc->getMessage(),
                $exc->getLine(),
                $exc->getTrace()[0]['args'][2] ?? null
            );
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $method = 'Method => ServiceBriefingController => update';

            $id = decrypt($id);

            $data = [];
            $data['id'] = $id;
            $data['service_briefing'] = $request->service_briefing;
            $data['amount'] = $request->amount;
            $encryptArray = $this->encryptData($data);

            $requestPayload = [];
            $requestPayload['requestData'] = $encryptArray;

            $gatewayURL = config('setting.api_gateway_url')
                . '/service_briefing_master/updatedata';

            $response = $this->serviceRequest(
                $gatewayURL,
                'POST',
                json_encode($requestPayload),
                $method
            );

            $responseObj = json_decode($response);

            if ($responseObj->Status == 200 && $responseObj->Success) {

                $objData = json_decode($this->decryptData($responseObj->Data));

                if ($objData->Code == 200) {
                    return redirect()->route('service_briefing.index')
                        ->with('success', 'Service Briefing Updated Successfully');
                }

                if ($objData->Code == 400) {
                    return redirect()->route('service_briefing.index')
                        ->with('fail', 'Service Briefing Update Failed');
                }
            }

            $objData = json_decode($this->decryptData($responseObj->Data));
            echo json_encode($objData->Code);
            exit;
        } catch (\Exception $exc) {
            return $this->sendLog(
                $method,
                $exc->getCode(),
                $exc->getMessage(),
                $exc->getLine(),
                $exc->getTrace()[0]['args'][2] ?? null
            );
        }
    }
}
