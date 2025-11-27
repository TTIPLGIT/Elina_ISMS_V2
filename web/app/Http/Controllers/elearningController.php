<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class elearningController extends Controller
{
    public function dashboard() {
        return view('elearning.dashboard');
    }


    public function allCourses() {
        return view('elearning.allCourses');
    }

    public function wishlist() {
        return view('elearning.wishlist');
    }
    

}
