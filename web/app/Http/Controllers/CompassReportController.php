<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Google\Service\CloudSearch\UserId;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;

class CompassReportController extends BaseController
{

    public function index(Request $request)
    {

      

        $menus = $this->FillMenu();
        $screens = $menus['screens'];
        $modules = $menus['modules'];
        return view('compass.index', compact( 'modules', 'screens'));
        //
    }

    public function CompassNewmeetinginvite(Request $request)
    {

        
        $menus = $this->FillMenu();
        $screens = $menus['screens'];
        $modules = $menus['modules'];
            return view('compass.CompassInitiate', compact('modules', 'screens'));
        
    }


}