<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends BaseController
{

  /**
   * Create a new controller instance.
   *
   * @return void
   */


  /**
   * Show the application dashboard.
   *
   * @return \Illuminate\Contracts\Support\Renderable
   */
  public function index(Request $request)

  {
    $user_id = $request->session()->get("userID");
    $menus = $this->FillMenu($request);
    $screens = $menus['screens'];
    $modules = $menus['modules'];
    $user_role = $modules['user_role'];

    if ($user_role == 'Parent') {
      return redirect(route('newenrollment.create'));
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
        $parant_data = json_decode(json_encode($this->decryptData($objData->Data)), true);
        $rows =  $parant_data;
        $request =  array();
        $request['user_id'] = $user_id;
        // return view('test' , compact('screens', 'modules'));
        return view('home_new', compact('screens', 'modules', 'rows'));
        return view('home', compact('screens', 'modules', 'rows'));
      }
    } elseif ($response->Status == 401) {

      return redirect(route('/'))->with('errors', 'User session Exipired');
    }
  }
  public function elinaleadsearch(Request $request)

  {
    $method = 'Method => HomeController => elinaleadsearch';
    try {

      $searchkey = $request->searchkey;
      // $this->WriteFileLog($searchkey);  


      $request = array();

      $request['requestData'] = $searchkey;

      $gatewayURL = config('setting.api_gateway_url') . '/elinaleadsearch/dashboard';
      $serviceResponse = $this->serviceRequest($gatewayURL, 'POST', json_encode($request), $method);

      $serviceResponse = json_decode($serviceResponse);
      if ($serviceResponse->Status == 200 && $serviceResponse->Success) {
        $objData = json_decode($this->decryptData($serviceResponse->Data));
        if ($objData->Code == 200) {
          $rows = json_decode(json_encode($objData->Data), true);
          return $rows;
          echo json_encode($rows);
        }
      }
    } catch (\Exception $exc) {
      $exceptionResponse = array();
      $exceptionResponse['ServiceMethod'] = $method;
      $exceptionResponse['Exception'] = $exc->getMessage();
      $exceptionResponse = json_encode($exceptionResponse, JSON_FORCE_OBJECT);
      $this->WriteFileLog($exceptionResponse);
    }
  }
  public function index1($id2)
  {
    $id = $this->decryptData($this->encryptData($id2));



    if ($id == "Failure") {
      $id = $this->decryptData($this->encryptData($id2));
      if ($id == "Failure") {
        return abort(404);
      }
    }

    try {
      $method = 'Method => PrivacyPolicyController => edit';

      $gatewayURL = config('setting.api_gateway_url') . '/privacy/update/' . $id;
      $response = $this->serviceRequest($gatewayURL, 'GET', '', $method);
      $response = json_decode($response);
      if ($response->Status == 200 && $response->Success) {
        $objData = json_decode($this->decryptData($response->Data));
        if ($objData->Code == 200) {
          $parant_data = json_decode(json_encode($objData->Data), true);
          $rows =  $parant_data['rows'];
          // $one_row =  $parant_data['one_rows'];

          $menus = $this->FillMenu();
          $screens = $menus['screens'];
          $modules = $menus['modules'];
          return view('profile.publish', compact('rows', 'modules', 'screens'));
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
  public function publish(Request $request)
  {
    try {
      $method = 'Method => PrivacyPolicyController => publish';
      $data = array();
      $rules = [
        'policy_content' => 'required',
      ];

      $messages = [
        'policy_content.required' => 'Profile Content is required',
      ];


      $data['policy_content'] = $request->policy_content;
      $data['id'] = $request->id;
      $id2 = $this->encryptData($data['id']);

      $encryptArray = $this->encryptData($data);
      $request = array();
      $request['requestData'] = $encryptArray;
      $gatewayURL = config('setting.api_gateway_url') . '/privacy/publish';
      $response = $this->serviceRequest($gatewayURL, 'POST', json_encode($request), $method);
      $response1 = json_decode($response);

      if ($response1->Status == 200 && $response1->Success) {
        $objData = json_decode($this->decryptData($response1->Data));
      }
      if ($objData->Code == 200) {
        // echo $id2;exit;

        return redirect(route('home'))->with('success', 'Privacy Policy Updated Successfully');
      } else {
        $objData = json_decode($this->decryptData($response->Data));
        echo json_encode($objData->Code);
        exit;
      }
    } catch (\Exception $exc) {
      return $this->sendLog($method, $exc->getCode(), $exc->getMessage(), $exc->getLine(), $exc->getTrace()[0]['args'][2]);
    }
  }
  public function status_view(Request $request)
  {
    try {
      $method = 'Method => NewenrollementController => edit';

      $enrollment_id = $request->enrollment_id;
      $get_type = $request->get_type;
      $data = array();
      $data['enrollment_id'] = $enrollment_id;
      $data['get_type'] = $get_type;
      $gatewayURL = config('setting.api_gateway_url') . '/user/status/view';
      $response = $this->serviceRequest($gatewayURL, 'GET', json_encode($this->encryptData($data)), $method);
      $response = json_decode($response);

      if ($response->Status == 200 && $response->Success) {
        $objData = json_decode($this->decryptData($response->Data));
        if ($objData->Code == 200) {
          $parant_data = json_decode(json_encode($objData->Data), true);
          $rows = $parant_data['rows'];
          return $rows;
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

  public function searchCoordinators(Request $request)
  {
    try {
      $method = 'Method => NewenrollementController => edit';

      $searchCoordinators = $request->searchCoordinators;
      $gatewayURL = config('setting.api_gateway_url') . '/search/Coordinators/view';
      $response = $this->serviceRequest($gatewayURL, 'GET', json_encode($this->encryptData($searchCoordinators)), $method);
      $response = json_decode($response);

      if ($response->Status == 200 && $response->Success) {
        $objData = json_decode($this->decryptData($response->Data));
        if ($objData->Code == 200) {
          $parant_data = json_decode(json_encode($objData->Data), true);
          $rows = $parant_data['rows'];
          return $rows;
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

  public function lead_view(Request $request)
  {
    try {
      $method = 'Method => HomeController => lead_view';

      $typeID = $request->type_id;
      $viewid = $request->viewid;

      if ($typeID == 1) {
        return redirect(route('newenrollment.show', $this->encryptData($viewid)));
      } elseif ($typeID == 2) {
        $gatewayURL = config('setting.api_gateway_url') . '/lead/syj/view/' . $this->encryptData($viewid);
        $response = $this->serviceRequest($gatewayURL, 'GET', '', $method);
        $response = json_decode($response);

        if ($response->Status == 200 && $response->Success) {
          $objData = json_decode($this->decryptData($response->Data));
          if ($objData->Code == 200) {
            $parant_data = json_decode(json_encode($objData->Data), true);
            $rows = $parant_data['rows'];

            $menus = $this->FillMenu();
            $screens = $menus['screens'];
            $modules = $menus['modules'];
            return view('newenrollement.syj_show', compact('rows', 'screens', 'modules'));
          }
        } else {
          $objData = json_decode($this->decryptData($response->Data));
          echo json_encode($objData->Code);
          exit;
        }
      } else {
        return true;
      }
    } catch (\Exception $exc) {
      return $this->sendLog($method, $exc->getCode(), $exc->getMessage(), $exc->getLine(), $exc->getTrace()[0]['args'][2]);
    }
  }
}
