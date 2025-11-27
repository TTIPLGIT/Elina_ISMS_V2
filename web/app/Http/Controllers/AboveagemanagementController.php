<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Google\Service\CloudSearch\UserId;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;

class AboveagemanagementController extends BaseController
{

    public function index(Request $request)
    {

      

        $menus = $this->FillMenu();
        $screens = $menus['screens'];
        $modules = $menus['modules'];
        return view('compassobservation.index', compact( 'modules', 'screens'));
        //
    }

    public function sourcestrengthindex(Request $request)
    {

        
        $menus = $this->FillMenu();
        $screens = $menus['screens'];
        $modules = $menus['modules'];
            return view('compassobservation.monthlyindex', compact('modules', 'screens'));
        
    }

    public function environmentstrengthindex(Request $request)
    {

    //dd("bjsc");
        
        $menus = $this->FillMenu();
        $screens = $menus['screens'];
        $modules = $menus['modules'];
            return view('compassobservation.tabview', compact('modules', 'screens'));
        
    }


}