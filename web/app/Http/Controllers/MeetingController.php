<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Google\Service\CloudSearch\UserId;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;

class MeetingController extends BaseController
{

    public function index(Request $request)
    {

      

        
        //
    }
    
    public function Show($id)
    {        
        $menus = $this->FillMenu();
        $screens = $menus['screens'];
        $modules = $menus['modules'];
        // dd($id);
        return view('therapistweeklysent.show', compact('modules', 'screens'));
        
    }
    public function Edit($id)
    {

        
        $menus = $this->FillMenu();
        $screens = $menus['screens'];
        $modules = $menus['modules'];
       return view('therapistweeklysent.edit', compact('modules', 'screens'));
        
    }
    public function TherapistWeeklySentupdate(Request $request, $id)
    {
        return redirect(route('compassmeeting'))
                        ->with('success', 'Session Allocated Updated Successfully');

    }

    public function Parentsreviewshow($id)
    {

        
        $menus = $this->FillMenu();
        $screens = $menus['screens'];
        $modules = $menus['modules'];
         return view('therapist.parentsreviewshow', compact('modules', 'screens'));
        
    }
    
    public function Parentsreviewedit($id)
    {

        
        $menus = $this->FillMenu();
        $screens = $menus['screens'];
        $modules = $menus['modules'];
         return view('therapist.parentsreviewedit', compact('modules', 'screens'));
        
    }

    public function Parentsreviewsentshow($id)
    {

        
        $menus = $this->FillMenu();
        $screens = $menus['screens'];
        $modules = $menus['modules'];
         return view('therapist.parentreviewsentshow', compact('modules', 'screens'));
        
    }
    
    public function Parentsreviewsentedit($id)
    {

        
        $menus = $this->FillMenu();
        $screens = $menus['screens'];
        $modules = $menus['modules'];
         return view('therapist.parentreviewsentedit', compact('modules', 'screens'));
        
    }

    public function therapistreviewshow($id)
    {

        
        $menus = $this->FillMenu();
        $screens = $menus['screens'];
        $modules = $menus['modules'];
         return view('therapist.therapistreviewshow', compact('modules', 'screens'));
        
    }

    public function therapistreviewedit($id)
    {

        
        $menus = $this->FillMenu();
        $screens = $menus['screens'];
        $modules = $menus['modules'];
         return view('therapist.therapistreviewedit', compact('modules', 'screens'));
        
    }

    public function therapistreviewsentshow($id)
    {

        
        $menus = $this->FillMenu();
        $screens = $menus['screens'];
        $modules = $menus['modules'];
         return view('therapist.reviewsentshow', compact('modules', 'screens'));
        
    }

    public function therapistreviewsentedit($id)
    {

        
        $menus = $this->FillMenu();
        $screens = $menus['screens'];
        $modules = $menus['modules'];
         return view('therapist.reviewsentedit', compact('modules', 'screens'));
        
    }
    

}