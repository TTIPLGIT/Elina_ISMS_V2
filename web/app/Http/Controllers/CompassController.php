<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Google\Service\CloudSearch\UserId;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\DB;

class CompassController extends BaseController
{

    public function index(Request $request)
    {
    
        $permission = $this->FillScreensByUser();
        $screen_permission = $permission[0];
               
        $menus = $this->FillMenu();

       
        $screens = $menus['screens'];
        $modules = $menus['modules'];

        return view('compass.index', compact( 'modules', 'screens','screen_permission'));
        //
    }

    public function CompassInitiate(Request $request)
    {

        
        $user_id = $request->session()->get("userID");

        if ($user_id == null) {
            return view('auth.login');
        }
        $method = 'Method => CompassController =>CompassInitiate';

        $request =  array();
        $request['user_id'] = $user_id;

        $gatewayURL = config('setting.api_gateway_url') . '/compass/initiate/new';
        $response = $this->serviceRequest($gatewayURL, 'GET',  json_encode($request), $method);
        $response = json_decode($response);
        
        if ($response->Status == "401") {
            return redirect(url('/'))->with('danger', 'User session Exipired');
        }
        $objData = json_decode($this->decryptData($response->Data));

        $rows = json_decode(json_encode($objData->Data), true);
        $rows = $rows['rows'];
       

       
        $menus = $this->FillMenu();

        if ($menus == "401") {
            return redirect(url('/'))->with('danger', 'User session Exipired');
        }
        $screens = $menus['screens'];
        $modules = $menus['modules'];

            return view('compass.CompassInitiate', compact('modules', 'screens','rows'));
        
    }
   
    public function store(Request $request)
    {
    return redirect(route('compassstatus'))->with('success', 'CoMPASS Initiated Successfully');
    }


}