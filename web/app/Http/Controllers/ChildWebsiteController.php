<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Google\Service\CloudSearch\UserId;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;

class ChildWebsiteController extends BaseController
{

    public function index(Request $request)
    {

      
        $user_id = $request->session()->get("userID");
        if ($user_id == null) {
            return view('auth.login');
        }
        $method = 'Method => LoginController => Register_screen';
        $request =  array();
        $request['user_id'] = $user_id;

        $gatewayURL = config('setting.api_gateway_url') . '/user/dashboard';
        $response = $this->serviceRequest($gatewayURL, 'GET', json_encode($request), $method);

        $response = json_decode($response);

        if ($response->Status == 200 && $response->Success) {
            $objData = json_decode($this->decryptData($response->Data));

            if ($objData->Code == 200) {
                $parant_data = json_decode(json_encode($objData->Data), true);
                $rows =  $parant_data;
                $request =  array();
                $request['user_id'] = $user_id;
                $menus = $this->FillMenu($request);
                if ($menus == "401") {
                    return redirect(route('/'))->with('errors', 'User session Exipired');
                }
                $screens = $menus['screens'];
                $modules = $menus['modules'];
                $user_role = $modules['user_role'];

                if($user_role == 'Parent'){
                    return redirect(route('newenrollment.create'));
                }
                return view('childwebsite.home', compact('screens', 'modules','rows'));
            }
        }
        elseif($response->Status == 401){

            return redirect(route('/'))->with('errors', 'User session Exipired');

        }
        //
    }

    


}