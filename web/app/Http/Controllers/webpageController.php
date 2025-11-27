<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class webpageController extends BaseController
{
    public function newsletters(Request $request)
    {
        dd($request->all());
        $method = 'Method => MasterPaymentController => store_data';
        dd($request);
        $user_id = $request->session()->get("userID");
        if ($user_id == null) {
            return view('auth.login');
        }
        $data = array();
        $data['emailid']  = $request->emailid;
        
        $encryptArray = $this->encryptData($data);
        $request = array();
        $request['requestData'] = $encryptArray;

        $gatewayURL = config('setting.api_gateway_url') . '/newsletters/storedata';

        $response = $this->serviceRequest($gatewayURL, 'POST', json_encode($request), $method);
        $response1 = json_decode($response);
        return $response1;
        
    }
}