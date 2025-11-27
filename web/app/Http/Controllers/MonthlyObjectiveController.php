<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Google\Service\CloudSearch\UserId;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;

class MonthlyObjectiveController extends BaseController
{

    public function index(Request $request)
    {

        $menus = $this->FillMenu();
        $screens = $menus['screens'];
        $modules = $menus['modules'];
        return view('monthlyobjective.index', compact( 'modules', 'screens'));
        //
    }

    public function listcalendar(Request $request)
    {   

        try {
            $method = 'Method => MonthlyObjectiveController => listcalendar';
            $user_id = $request->session()->get("userID");
            if ($user_id == null) {
                return view('auth.login');
            }

            $method = 'Method => MonthlyObjectiveController => listcalendar';


            $request =  array();
            $request['user_id'] = $user_id;

            $gatewayURL = config('setting.api_gateway_url') . '/monthly/viewcal';
            $response = $this->serviceRequest($gatewayURL, 'GET', json_encode($request), $method);

            $response = json_decode($response);


            $menus = $this->FillMenu();

            if ($menus == "401") {
                return redirect(url('/'))->with('errors', 'User session Exipired');
            }

            if ($response->Status == 200 && $response->Success) {
                $objData = json_decode($this->decryptData($response->Data));

                if ($objData->Code == 200) {
                    $parant_data = json_decode(json_encode($objData->Data), true);
                    $rows =  $parant_data['rows'];
                  

                    
                    $screens = $menus['screens'];
                    $modules = $menus['modules'];

                    return view('monthlyobjective.calendar', compact('rows', 'screens', 'modules'));
                }
            }

       }   catch (\Exception $exc) {
            
            return $this->sendLog($method, $exc->getCode(), $exc->getMessage(), $exc->getLine(), $exc->getTrace()[0]['args'][2]);
        }
        
    }

    public function viewform($id)
    { 
        // dd("gugxjs");
        try {
            $id=$this->EncryptData($id);
            $method = 'Method => QuestionCreationController => show';
            $gatewayURL = config('setting.api_gateway_url') . '/question_creation/viewdata/' . $id;
            $response = $this->serviceRequest($gatewayURL, 'GET', '', $method);
            $response = json_decode($response);
            if ($response->Status == 200 && $response->Success) {
                $objData = json_decode($this->decryptData($response->Data));
                if ($objData->Code == 200) {
                    $parant_data = json_decode(json_encode($objData->Data), true);
                    $question =  $parant_data['question'];
                    $questionnaire_name = $parant_data['questionnaire_name'];
                    $menus = $this->FillMenu();
                    $screens = $menus['screens'];
                    $modules = $menus['modules'];
                    return view('monthlyobjective.view', compact('questionnaire_name','screens', 'modules', 'question'));
                }
            } else {
                $objData = json_decode($this->decryptData($response->Data));
                echo json_encode($objData->Code);
                exit;
            }
        } catch (\Exception $exc) {
            return $this->sendLog($method, $exc->getCode(), $exc->getMessage(), $exc->getLine(), $exc->getTrace()[0]['args'][2]);
        }
    }



}