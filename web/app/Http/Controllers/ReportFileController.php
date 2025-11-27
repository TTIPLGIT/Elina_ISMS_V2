<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class ReportFileController extends BaseController
{
    public function index()
    {
        $directory = public_path('assessment_report');//dd($directory); 
        $files = File::allFiles($directory);
        $directories = File::directories($directory);

        return view('ReportFiles.index', compact('files', 'directories'));
    }

    public function show($filename)
    {        
        $path = public_path('assessment_report' . $filename);
        if (!File::exists($path)) {
            abort(404);
        }

        return response()->file($path);
    }

    public function download($filename)
    {
        $path = public_path('assessment_report' . $filename);
        if (!File::exists($path)) {
            abort(404);
        }

        return response()->download($path);
    }
}
