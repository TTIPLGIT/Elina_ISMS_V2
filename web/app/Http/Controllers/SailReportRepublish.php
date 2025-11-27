<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\URL;

class SailReportRepublish extends BaseController
{
    public function index()
    {
        $permission_data = $this->FillScreensByUser();
        $screen_permission = $permission_data[0];
        if (strpos($screen_permission['permissions'], 'View') !== false) {
            try {
                $id = null;
                $method = 'Method => SailReportRepublish => index';
                $gatewayURL = config('setting.api_gateway_url') . '/report/republish/get_data/' . $this->encryptData($id);
                $response = $this->serviceRequest($gatewayURL, 'GET', '', $method);
                $response = json_decode($response);
                // 
                $directory = storage_path();

                $files = File::allFiles($directory);
                $directories = File::directories($directory);

                foreach ($directories as $dir) {
                    echo "Directory: " . basename($dir) . '<br>';
                }

                foreach ($files as $file) {
                    echo "File: " . $file->getFilename() . '<br>';
                }
                dd('asd');
                exit;
                // 
                if ($response->Status == 200 && $response->Success) {
                    $objData = json_decode($this->decryptData($response->Data));
                    if ($objData->Code == 200) {
                        $rows = json_decode(json_encode($objData->Data), true);

                        $menus = $this->FillMenu();
                        $screens = $menus['screens'];
                        $modules = $menus['modules'];

                        $permission = $this->FillScreensByUser();
                        $screen_permission = $permission[0];

                        return view('assessmentreport.index', compact('rows', 'screens', 'modules', 'screen_permission'));
                    }
                } else {
                    $objData = json_decode($this->decryptData($response->Data));
                    return Redirect::back()->with('fail', $objData->Message);
                    echo json_encode($objData->Message);
                    exit;
                }
            } catch (\Exception $exc) {
                return $this->sendLog($method, $exc->getCode(), $exc->getMessage(), $exc->getLine(), $exc->getTrace()[0]['args'][2]);
            }
        } else {
            return redirect()->route('not_allow');
        }
    }
}
