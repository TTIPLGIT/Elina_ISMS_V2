<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Google\Service\CloudSearch\UserId;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;

class TherapistAllocationViewController extends BaseController
{

    public function index(Request $request)
    {

        $menus = $this->FillMenu();
        $screens = $menus['screens'];
        $modules = $menus['modules'];
        return view('therapist.index', compact( 'modules', 'screens'));
        //
    }

}