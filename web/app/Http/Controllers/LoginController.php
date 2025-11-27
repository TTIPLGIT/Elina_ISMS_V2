<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\File;
use Dompdf\Dompdf;
use PDF;
use \Mpdf\Mpdf as MPDF;
use Illuminate\Support\Facades\Storage;
use Google_Client;
use Google\Service\Docs;
use Dompdf\Options;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Cookie;
use DB;

class LoginController extends BaseController
{
  // public function index()
  // {
  //   return view('auth.login');
  // }

  public function index()
  {
    // echo "cjvh";exit;

    try {
      $method = 'Method => LoginController => login_screen';

      $gatewayURL = config('setting.api_gateway_url') . '/login/background';
      $response = $this->serviceRequest($gatewayURL, 'GET', '', $method);
      $response = json_decode($response);

      if ($response->Status == 200 && $response->Success) {
        $objData = json_decode($this->decryptData($response->Data));
        if ($objData->Code == 200) {
          $parant_data = json_decode(json_encode($objData->Data), true);
          $rows =  $parant_data['rows'];
          // echo json_encode($rows);exit;
          // $one_row =  $parant_data['one_rows'];


          return view('auth.login', compact('rows'));
        }
      } else {
        $objData = json_decode($this->decryptData($response->Data));
      }
    } catch (\Exception $exc) {

      return $this->sendLog($method, $exc->getCode(), $exc->getMessage(), $exc->getLine(), $exc->getTrace()[0]['args'][2]);
    }
  }

  public function index1()
  {
    return redirect(route('/'));
  }
  public function intern()
  {
    // echo "cjvh";exit;

    try {
      $method = 'Method => LoginController => login_screen';

      $gatewayURL = config('setting.api_gateway_url') . '/login/background';
      $response = $this->serviceRequest($gatewayURL, 'GET', '', $method);
      return view('intern');
    } catch (\Exception $exc) {

      return $this->sendLog($method, $exc->getCode(), $exc->getMessage(), $exc->getLine(), $exc->getTrace()[0]['args'][2]);
    }
  }
  public function serviceprovider()
  {
    try {
      $method = 'Method => LoginController => login_screen';

      $gatewayURL = config('setting.api_gateway_url') . '/service/provider/createdata';
      $response = $this->serviceRequest($gatewayURL, 'POST', '', $method);
      $response = json_decode($response);
      if ($response->Status == 200 && $response->Success) {
        $objData = json_decode($this->decryptData($response->Data));

        if ($objData->Code == 200) {
          $parant_data = json_decode(json_encode($objData->Data), true);
          $specialization = $parant_data['specialization'];
          return view('serviceprovider', compact('specialization'));
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
  public function register()
  {
    $method = 'Method => LoginController => Register_screen';

    // $gatewayURL = config('setting.api_gateway_url') . '/Register/screen';
    // $response = $this->serviceRequest($gatewayURL, 'GET', '', $method);

    return view('auth.register');
  }
  public function otp()
  {
    $method = 'Method => LoginController => otp_screen';

    $gatewayURL = config('setting.api_gateway_url') . '/otp/screen';
    $response = $this->serviceRequest($gatewayURL, 'GET', '', $method);

    return view('auth.otp');
  }

  public function registerstore(Request $request)
  {
    try {
      $method = 'Method => LoginController => Register_screen';
      $data = array();
      $data['name'] = $request->name;
      $data['email'] = $request->email;
      $data['password'] = bcrypt($request->password);
      $data['password_confirmation'] = $request->password_confirmation;
      $data['Mobile_no'] = $request->Mobile_no;
      $data['dor'] = $request->dor;

      $encryptArray = $this->encryptData($data);

      $request = array();
      $request['requestData'] = $encryptArray;

      $gatewayURL = config('setting.api_gateway_url') . '/Register/store';

      $response = $this->serviceRequest($gatewayURL, 'POST', json_encode($request), $method);
      $response1 = json_decode($response);

      if ($response1->Status == 200 && $response1->Success) {
        $objData = json_decode($this->decryptData($response1->Data));
        if ($objData->Code == 200) {
          return redirect(route('/'))->with('success', 'Registration is successful. Welcome to Elina Services');
        }

        if ($objData->Code == 400) {
          return Redirect::back()->with('error', 'E-Mail Already Exist , Please use an alternative E-Mail to proceed further');
        }
      } else {
        $objData = json_decode($this->decryptData($response1->Data));
        echo json_encode($objData->Code);
        exit;
      }
    } catch (\Exception $exc) {
      // dd($exc);
      if ($exc->status === 422) {
        //   dd($exc);
        return redirect(url('/register'))->with('success', ' Registered Successfully');
      }
      return $this->sendLog($method, $exc->getCode(), $exc->getMessage(), $exc->getLine(), $exc->getTrace()[0]['args'][2]);
    }
  }

  public function forgot()
  {
    // echo "cjvh";exit;

    try {
      $method = 'Method => LoginController => login_screen';
      return view('auth.passwords.forgot');
      $gatewayURL = config('setting.api_gateway_url') . '/login/background';
      $response = $this->serviceRequest($gatewayURL, 'GET', '', $method);
      $response = json_decode($response);
      if ($response->Status == 200 && $response->Success) {
        $objData = json_decode($this->decryptData($response->Data));
        if ($objData->Code == 200) {
          $parant_data = json_decode(json_encode($objData->Data), true);
          $rows =  $parant_data['rows'];
          // echo json_encode($rows);exit;
          // $one_row =  $parant_data['one_rows'];


          return view('auth.passwords.forgot', compact('rows'));
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

  //  public function forgot()
  //  {

  //   return view('auth.forgot'); 
  // }



  public function login(Request $request)

  {

    // $remember_me = $request->has('remember_me') ? true : false; 


    //  echo "hihui";exit;


    try {
      $method = 'Method => LoginController => login';
      $input = [
        'email' => $request->email,
        'password' => $request->password,
        // 'recaptcha' => $request->input('g-recaptcha-response')
      ];

      $rules = [
        'email' => 'required',
        'password' => 'required',
        //'recaptcha' => 'required|captcha'
      ];

      $messages = [
        'email.required' => 'Email is required',
        'password.required' => 'Password is required',

      ];

      $remember_me = $request->has('remember_me') ? true : false;

      $validator = Validator::make($input, $rules, $messages);
      if ($validator->fails()) {
        $gatewayURL = config('setting.api_gateway_url') . '/user/require_captcha';

        $input = array();
        $input['email'] = $request->email;
        $input['password'] = $request->password;
        $input['remember_me'] = $request->has('remember_me');

        $encryptArray = $this->encryptData($input);
        $request = array();
        $request['requestData'] = $encryptArray;
        $method = 'Method => LoginController => index';
        $response = $this->serviceRequest($gatewayURL, 'POST', json_encode($request), $method);


        $response = json_decode($response);
        if ($response->Status == 200 && $response->Success) {

          $modules = '';
          $screens = '';
          echo $validator->errors();
        }

        return back()->withErrors(['recaptcha' => ['Captcha is required']]);
      } else {

        if (!request()->cookie('elina_uuid')) {
          $browserUuid = Str::uuid()->toString();
        } else {
          $browserUuid = request()->cookie('elina_uuid');
        }
        Cookie::queue('elina_uuid', $browserUuid);
        // dd($browserUuid);
        $tokenResponse = $this->setToken($input['email'], $input['password'], $browserUuid);
        if ($tokenResponse == 'Failure') {
          // $customerInfo ="failure";
          // dd(back()->with(['error_message' => 'Failed to update profile'])->with('customerInfo',$customerInfo));
          // dd('successful_message' => 'Profile updated successfully',);
          // return back()->with(['error_message' => 'Failed to update profile'])->with('customerInfo',$customerInfo);
          // dd('sakj');
          // dd(Session::put('failure', 'failure'));

          // return redirect()->back()->with('failure', 'File uploaded failed!');
          // dd( redirect()->back()->with('failure', 'File uploaded failed!'));
          // function add_error($error_msg, $key = 'default') {
          //   $errors = Session::get('errors', new ViewErrorBag);
          //   dd($error_msg);

          //   if (! $errors instanceof ViewErrorBag) {
          //       $errors = new ViewErrorBag;
          //   }

          //   $bag = $errors->getBags()['default'] ?? new MessageBag;
          //   $bag->add($key, $error_msg);

          //   Session::flash(
          //       'errors', $errors->put('default', $bag)
          //   );

          // }
          // dd(Redirect::back()->withErrors(['msg' => 'Invalid user name or password'])   );
          // return Redirect::back()->withErrors(['msg' => 'Invalid user name or password']);   
          return back()->withErrors(['recaptcha' => ['Invalid user name or password']]);
          // return redirect()->route('/')->withErrors(['recaptcha' => ['Invalid user name or password']]);
        } else if ($tokenResponse == 'Disabled') {
          return back()->withErrors(['recaptcha' => ['User disabled contact ISMS Administrator']]);
        } else if ($tokenResponse == 'Active') {
          return back()->withErrors(['recaptcha' => ['Multiple Sessions Detected. For security reasons, you can only be logged in from one device at a time.']]);
        }

        $gatewayURL = config('setting.api_gateway_url') . '/login/user';
        // return redirect()->route('home');

        $response = $this->serviceRequest($gatewayURL, 'GET', '', $method);

        $response = json_decode($response);

        if ($response->Status == 401) {
          // echo "fjhg";exit;
          return back()->withErrors(['recaptcha' => ['Invalid user name or password']]);
        }




        if ($response->Status == 200 && $response->Success) {
          $objData = json_decode($this->decryptData($response->Data));

          if ($objData->Code == 200) {

            $objRows = $objData->Data;
            $row = json_decode(json_encode($objRows), true);
            session(['userType' => $row[0]['user_type']]);
            session(['userID' => $row[0]['id']]);
            session(['sessionTimer' => $objData->formattedDateTime]);
            session(['multipleDevice' => $objData->multipleDevice]);
            // $menus = $this->FillMenu();
            // $screens = $menus['screens'];
            // $modules = $menus['modules'];
            return redirect()->route('home');
          }
        }
      }
    } catch (\Exception $exc) {
      echo $exc->getMessage();
      exit;
      return $this->sendLog($method, $exc->getCode(), $exc->getMessage(), $exc->getLine(), $exc->getTrace()[0]['args'][2]);
    }
  }

  public function loginotp(Request $request)

  {

    // $remember_me = $request->has('remember_me') ? true : false; 


    //  echo "hihui";exit;

    $request = json_decode(json_encode($request[0]), true);

    $request = $this->DecryptData($request['Data']);

    $request = json_decode($request, true);
    $request = $request['Data'];

    try {
      $method = 'Method => LoginController => login';
      $input = [
        'id' => $request[0]['id'],
      ];


      $gatewayURL = config('setting.api_gateway_url') . '/signedLogin';
      $encryptArray = $this->encryptData($input);
      $request = array();
      $request['requestData'] = $encryptArray;
      $response1 = $this->serviceRequest($gatewayURL, 'POST', json_encode($request), $method);
      $response = json_decode($response1);



      if ($response->Status == 401) {
        // echo "fjhg";exit;
        return back()->withErrors(['recaptcha' => ['Invalid user name or password']]);
      }




      if ($response->Status == 200 && $response->Success) {

        $objData = json_decode($this->decryptData($response->Data));

        $objRows = $objData;
        $row = json_decode(json_encode($objRows), true);
        session(['accessToken' => $row['access_token']]);
        session(['userType' => $row['user']['user_type']]);
        session(['userID' => $row['user']['id']]);
        session(['sessionTimer' => $objData->formattedDateTime]);
        $menus = $this->FillMenu();
        $screens = $menus['screens'];
        $modules = $menus['modules'];


        return $response;
      }
    } catch (\Exception $exc) {
      echo $exc->getMessage();
      exit;
      return $this->sendLog($method, $exc->getCode(), $exc->getMessage(), $exc->getLine(), $exc->getTrace()[0]['args'][2]);
    }
  }
  public function logout(Request $request)
  {
    try {
      $method = 'Method => LoginController => logout';


      $gatewayURL = config('setting.api_gateway_url') . '/user/logout';

      $response = $this->serviceRequest($gatewayURL, 'GET', '', $method);

      // echo json_encode($response);exit;
      $response = json_decode($response);



      $request->session()->invalidate();
      return redirect(route('/'));
    } catch (\Exception $exc) {
      return $this->sendLog($method, $exc->getCode(), $exc->getMessage(), $exc->getLine(), $exc->getTrace()[0]['args'][2]);
    }
  }

  public function sessionexpire(Request $request)
  {
    try {
      $method = 'Method => LoginController => sessionexpire';
      $id = $request->userID;
      // $this->WriteFileLog($id);
      $gatewayURL = config('setting.api_gateway_url') . '/user/unauthenticated/' . $this->encryptData($id);
      $response = $this->serviceRequest($gatewayURL, 'GET', '', $method);
      $response = json_decode($response);
      // $request->session()->invalidate();
      return true;
    } catch (\Exception $exc) {
      return $this->sendLog($method, $exc->getCode(), $exc->getMessage(), $exc->getLine(), $exc->getTrace()[0]['args'][2]);
    }
  }

  public function faqpage()
  {
    $menus = $this->FillMenu();
    $screens = $menus['screens'];
    $modules = $menus['modules'];

    return view('faq', compact('modules', 'screens'));
  }

  public function profilepage()
  {
    try {
      $method = 'Method => LoginController => profilepage';

      $userRow = array();
      $userRow['email'] = "sdsfs";

      $gatewayURL = config('setting.api_gateway_url') . '/user/profilepage';
      $encryptArray = $this->encryptData($userRow);
      $request = array();
      $request['requestData'] = $encryptArray;

      $response1 = $this->serviceRequest($gatewayURL, 'POST', json_encode($request), $method);
      $response = json_decode($response1);
      if ($response->Status == 200 && $response->Success) {
        $objData = json_decode($this->decryptData($response->Data));
        if ($objData->Code == 200) {
          $parant_data = json_decode(json_encode($objData->Data), true);
          $one_row =  $parant_data['user'];
// dd($one_row);
          //echo json_encode($one_row);exit;

          $menus = $this->FillMenu();
          $screens = $menus['screens'];
          $modules = $menus['modules'];
          return view('profilepage', compact('one_row', 'modules', 'screens'));
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


  public function settingspage()
  {
    $menus = $this->FillMenu();
    $screens = $menus['screens'];
    $modules = $menus['modules'];


    return view('faq', compact('modules', 'screens'));
  }

  public function privacypage()
  {

    try {
      $method = 'Method => PrivacyPolicyController => policy_screen';

      $gatewayURL = config('setting.api_gateway_url') . '/privacy/policy_screen';
      $response = $this->serviceRequest($gatewayURL, 'GET', '', $method);
      $response = json_decode($response);
      if ($response->Status == 200 && $response->Success) {
        $objData = json_decode($this->decryptData($response->Data));
        if ($objData->Code == 200) {
          $parant_data = json_decode(json_encode($objData->Data), true);
          $rows =  $parant_data['rows'];

          $gatewayURL = config('setting.api_gateway_url') . '/login/background';
          $response = $this->serviceRequest($gatewayURL, 'GET', '', $method);
          $response = json_decode($response);
          if ($response->Status == 200 && $response->Success) {
            $objData = json_decode($this->decryptData($response->Data));
            if ($objData->Code == 200) {
              $parant_data = json_decode(json_encode($objData->Data), true);
              $rows1 =  $parant_data['rows'];
              // $one_row =  $parant_data['one_rows'];


              return view('auth/passwords.privacy', compact('rows', 'rows1'));
            }
          }
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


  public function reset($id)
  {



    try {
      $method = 'Method => LoginController => reset';

      $gatewayURL = config('setting.api_gateway_url') . '/user/reset/' . $id;
      $response = $this->serviceRequest($gatewayURL, 'GET', '', $method);
      $response = json_decode($response);

      if ($response->Status == 200 && $response->Success) {
        $objData = json_decode($this->decryptData($response->Data));
        if ($objData->Code == 200) {
          $email = $this->decryptData($id);
          return view('auth.passwords.reset2', compact('email'));
        }

        if ($objData->Code == 400) {
          return redirect()->route('tokenexpire');
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

  public function reset_password(Request $request)
  {

    //return $request;

    try {
      $method = 'Method => LoginController => reset_password';
      $input = [
        'password' => $request->password,
        'c_password' => $request->c_password,
      ];
      $rules = [
        'password' => 'required|string|min:8|regex:/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{8,}$/',
        'c_password' => 'required|same:password',
      ];

      $messages = [
        'password.required' => 'Password is required',
        'c_password.required' => 'Please enter same password'
      ];

      $validator = Validator::make($request->all(), $rules, $messages);

      if ($validator->fails()) {
        return Redirect::back()->withErrors($validator);
      } else {

        $gatewayURL = config('setting.api_gateway_url') . '/user/reset_password';

        //echo $gatewayURL;exit;

        $userRow = array();
        $userRow['password'] = $request->password;
        $userRow['email'] = $request->email;

        $encryptArray = $this->encryptData($userRow);
        $request = array();
        $request['requestData'] = $encryptArray;

        ///  echo json_encode($request);exit;

        $response = $this->serviceRequest($gatewayURL, 'POST', json_encode($request), $method);
        $response = json_decode($response);

        //  echo json_encode($response);exit;
        if ($response->Status == 200 && $response->Success) {
          $objData = json_decode($this->decryptData($response->Data));
          if ($objData->Code == 200) {

            return redirect(route('login'))->with('success', 'Password Changed Successfully');
          }

          if ($objData->Code == 400) {
            return Redirect::back()->with('fail', 'Should not use the Previous Password');
          }
        }
      }
    } catch (\Exception $exc) {
      return $this->sendLog($method, $exc->getCode(), $exc->getMessage(), $exc->getLine(), $exc->getTrace()[0]['args'][2]);
    }
  }

  public function forgot_password(Request $request)
  {

    try {

      $method = 'Method => LoginController => forgot_password';
      $input = [
        'email' => $request->email,
      ];
      $rules = [
        'email' => 'required',
      ];
      $messages = [
        'email.required' => 'Email is required',
      ];
      $validator = Validator::make($request->all(), $rules, $messages);
      if ($validator->fails()) {
        return Redirect::back()->withErrors($validator);
      } else {

        $userRow = array();
        $userRow['email'] = $request->email;
        $gatewayURL = config('setting.api_gateway_url') . '/user/forget_password';
        $encryptArray = $this->encryptData($userRow);
        $request = array();
        $request['requestData'] = $encryptArray;
        $response = $this->serviceRequest($gatewayURL, 'POST', json_encode($request), $method);
        $response = json_decode($response);
        if ($response->Status == 200 && $response->Success) {
          $objData = json_decode($this->decryptData($response->Data));
          if ($objData->Code == 200) {
            $parant_data = json_decode(json_encode($objData->Data), true);
            $response_status =  $parant_data['response_status'];
            if ($response_status == "200") {
              return redirect(route('forgot'))->with('success', 'Reset password link sent your mail id');
            }
            if ($response_status == "300") {
              return redirect(route('forgot'))->with('success', 'User Mail id not found please check');
            }
          }
        }
      }
    } catch (\Exception $exc) {
      return $this->sendLog($method, $exc->getCode(), $exc->getMessage(), $exc->getLine(), $exc->getTrace()[0]['args'][2]);
    }
  }


  public function profile_update(Request $request)
  {

    try {
      $method = 'Method => LoginController => profile_update';


      if ($request->file('signature_attachment')) {

        $galleryId =  $request->user_id;
        $path = public_path() . '/user_signature/' . $galleryId;
        File::makeDirectory($path, $mode = 0777, true, true);
        $storagePath = $path;
        $imageFile = $request->file('signature_attachment');
        $imageName = base64_encode($request->file('signature_attachment')->getClientOriginalName()) . '.' . $request->file('signature_attachment')->extension();
        $imageNamecheck = str_replace(' ', '_', $imageName);
        $imageFile->move($storagePath, $imageNamecheck);
        $galleryId =  $request->user_id;
        $path1 = '/user_signature/' . $galleryId;
        $imageorgname = $path1 . '/' . $imageNamecheck;
        $userRow = array();
        $userRow['signature_attachment'] = $imageorgname;
        $userRow['profile_path'] = $storagePath;
      } else {
        $userRow['signature_attachment'] = " ";
        $userRow['signature'] = $request->signature;
        $userRow['profile_path'] = " ";
      }
      $userRow['phone_number'] = $request->phone_number;
      $userRow['user_id'] = $request->user_id;
      $userRow['name'] = $request->name;
      $userRow['email'] = $request->email;
      $gatewayURL = config('setting.api_gateway_url') . '/user/profile_update';
      $encryptArray = $this->encryptData($userRow);
      $request = array();
      $request['requestData'] = $encryptArray;
      $response = $this->serviceRequest($gatewayURL, 'POST', json_encode($request), $method);
      $response = json_decode($response);
      if ($response->Status == 200 && $response->Success) {
        $objData = json_decode($this->decryptData($response->Data));
        if ($objData->Code == 200) {
          $parant_data = json_decode(json_encode($objData->Data), true);
          $response_status =  $parant_data['response_status'];
          echo json_encode($response_status);
        }
        if ($response_status == "300") {
          return redirect(route('forgot'))->with('success', 'User Mail id not found please check');
        }
      }





      // }

    } catch (\Exception $exc) {
      return $this->sendLog($method, $exc->getCode(), $exc->getMessage(), $exc->getLine(), $exc->getTrace()[0]['args'][2]);
    }
  }



  public function onetimepassword(Request $request)
  {

    try {

      $method = 'Method => LoginController => onetimepassword';
      $userRow = array();
      $userRow['mobile_no'] = $request->mobile_no;
      $userRow['email_otp'] = $request->email_otp;
      // $this->WriteFileLog($userRow);
      $encryptArray = $this->encryptData($userRow);
      // Log::error($userRow);

      $request = array();
      $request['requestData'] = $encryptArray;
      // Log::error($request);

      $gatewayURL = config('setting.api_gateway_url') . '/user/generatedotp';
      $response = $this->serviceRequest($gatewayURL, 'POST', json_encode($request), $method);
      // Log::error($response);


      $response = json_decode($response);
      if ($response->Status == 200 && $response->Success) {
        $objData = json_decode($this->decryptData($response->Data));
        return $objData->Code;
        if ($objData->Code == 200) {
          $parant_data = json_decode(json_encode($objData->Data), true);
        }
        if ($objData->Code == 404) {
          return redirect(route('/'))->with('error', 'No Record Found');
        }
        return redirect(route('/'))->with('success', 'OTP generated successfully');
      }

      // }
    } catch (\Exception $exc) {
      return $this->sendLog($method, $exc->getCode(), $exc->getMessage(), $exc->getLine(), $exc->getTrace()[0]['args'][2]);
    }
  }



  public function VerifyOTP(Request $request)
  {
    try {
      $method = 'Method => LoginController => VerifyOTP';
      $userRow = array();
      $userRow['mobile_no'] = $request->mobile_no;
      $userRow['otp'] = $request->otp;
      $userRow['email_otp'] = $request->email_otp;

      $gatewayURL = config('setting.api_gateway_url') . '/user/VerifyOTP';
      $encryptArray = $this->encryptData($userRow);
      // $this->WriteFileLog($userRow);
      $request = array();
      $request['requestData'] = $encryptArray;
      $response = $this->serviceRequest($gatewayURL, 'GET', json_encode($request), $method);



      $response = json_decode($response);
      if (json_decode(decrypt($response->Data), true)['Code'] === 400) {
        // $this->WriteFileLog("s");

        return response()->json(['success' => "Failure"]);
      }

      $request = $response;
      // $login->login($Verify_otp);
      $objetoRequest = new \Illuminate\Http\Request();
      $objetoRequest->setMethod('POST');
      $objetoRequest->request->add([
        $request
      ]);

      $response = $this->loginotp($objetoRequest);
      if ($response->Status == 401) {
        // echo "fjhg";exit;
        // return back()->with('error', 'Email Already Found');
        return response()->json(['success' => "Failure"]);
      }




      if ($response->Status == 200 && $response->Success) {

        $objData = json_decode($this->decryptData($response->Data));


        $objRows = $objData;

        $row = json_decode(json_encode($objRows), true);

        session(['accessToken' => $row['access_token']]);
        session(['userType' => $row['user']['user_type']]);
        session(['userID' => $row['user']['id']]);
        session(['sessionTimer' => $objData->formattedDateTime]);
        $menus = $this->FillMenu();
        $screens = $menus['screens'];
        $modules = $menus['modules'];
        // dd($menus);

        return response()->json(['success' => "Success"]);
      }






      // }
    } catch (\Exception $exc) {
      return $this->sendLog($method, $exc->getCode(), $exc->getMessage(), $exc->getLine(), $exc->getTrace()[0]['args'][2]);
    }
  }
  public function dompdf()
  {
    try {
      $method = 'Method => EnrollementController => RegisterFeeInitiate';

      $child_name = 'S Thanushri';
      $register_fee = '14000';
      $parent_name = 'Suriya Mohan';
      $folderPath = 'suriyamohan.sekaran@gmail.com';
      $findString = array(' ', '&');
      $replaceString = array('-', '-');
      $folderPath = str_replace($findString, $replaceString, $folderPath);
      // $storagePath = public_path() . '/invoice_document/' . $folderPath;
      $storagePath = public_path() . '/sail_invoice_document/' . $folderPath;

      if (!File::exists($storagePath)) {
        $storagePath = public_path() . '/invoice_document/';
        $arrFolder = explode('/', $folderPath);
        foreach ($arrFolder as $key => $value) {
          $storagePath .= '/' . $value;
          if (!File::exists($storagePath)) {
            File::makeDirectory($storagePath);
          }
        }
      }


      $documentName = 'Registration_invoice_receipt.pdf';
      $document_name = 'Registration_invoice_receipt';
      $input = base_path() . '/reports/Registration_invoice_receipt.jasper';


      //$input = 'C:\xampp\htdocs\jasperreport\storage\app\public\reports/userreport.jasper';
      $output = $storagePath . '/' . $documentName;
      $output_1 = $storagePath . '/' . $document_name;
      // $storagePath = public_path() . '/invoice_document/';
      // $report_path = public_path() . '/invoice_document/' . $folderPath;

      $storagePath = public_path() . '/sail_invoice_document/';
      $report_path = public_path() . '/sail_invoice_document/' . $folderPath;

      // $documentName = 'Registration_invoice_receipt.pdf';
      $documentName = 'PAYMENT_INVOICE_RECEIPT.pdf';
      
      $invoice = 375;
      
      $amount_text = $this->numberToWords($register_fee);
      $data = [
        'father_name' => $parent_name,
        'child_name' => $child_name,
        'register_fee' => $register_fee,
        'in_words' => $amount_text,
        'id' => $invoice,
      ];
      $pdf = PDF::loadView('pdfTemplates.test', compact('data'));
      $pdf->save($output);
    } catch (\Exception $exc) {

      return $this->sendLog($method, $exc->getCode(), $exc->getMessage(), $exc->getLine(), $exc->getTrace()[0]['args'][2]);
    }
  }
  public function pdfdownload(Request $request) {}
  public function mpdf()
  {

    // Get the HTML content of the document.
    $html_content = view('pdfTemplates.test');

    // Create a PDF document from the HTML content.
    $pdf = new \Mpdf\Mpdf();
    $pdf->SetDefaultFontSize(60);
    $pdf->SetAutoPageBreak(true, 10);
    $pdf->writeHTML($html_content);

    // Output the PDF document.
    $pdf->output('output.pdf', 'F');

    return response()->download('output.pdf');

    // mPdf
    $documentFileName = "fun.pdf";
    $document = new MPDF([
      'mode' => 'utf-8',
      'format' => 'A4',
      'margin_header' => '3',
      'margin_top' => '20',
      'margin_bottom' => '20',
      'margin_footer' => '2',
    ]);
    $header = [
      'Content-Type' => 'application/pdf',
      'Content-Disposition' => 'inline; filename="' . $documentFileName . '"'
    ];
    $document->WriteHTML('<h1 style="color:blue">TheCodingJack</h1>');
    $document->WriteHTML('<p>Write something, just for fun!</p>');
    Storage::disk('public')->put($documentFileName, $document->Output($documentFileName, "S"));
    return Storage::disk('public')->download($documentFileName, 'Request', $header);
    // 
  }

  public function checkSession()
  {
    // $this->WriteFileLog("checkSession");
    $method = 'Method => LoginController => checkSession';
    $gatewayURL = config('setting.api_gateway_url') . '/check/user/session';
    $response = $this->serviceRequest($gatewayURL, 'GET',  '', $method);
    $response = json_decode($response);
    return true;
    if ($response->Status == 200 && $response->Success) {
      return $response->Status;
      $objData = json_decode($this->decryptData($response->Data));
      if ($objData->Code == 200) {
        return $response;
      }
    }
    return $response;
    //dd($response);
  }
  public function googledoc()
  {

    // 
    $jsonKey = storage_path('docs.json');
    $client = new Google_Client();
    $client->setApplicationName('Test Doc');
    $client->setScopes([Docs::DOCUMENTS]);
    // $client->setAuthConfig(config('google.credentials_path'));
    $client->setAuthConfig($jsonKey);
    $service = new Docs($client);
    // 
    exit;
    $client = new Google_Client();
    // $jsonKey = storage_path('docs.json');
    // $client->setAuthConfig($jsonKey);
    $client->useApplicationDefaultCredentials();
    $client->addScope('https://www.googleapis.com/auth/documents');

    $service = new Google_Service_Docs($client);
    $document = new Google_Service_Docs_Document();
    $response = $service->documents->create($document);
  }

  // Controller Method
  public function myMethod(Request $request)
  {
    if ($request->isMethod('post')) {
      // This is a POST request, process the data
      $value = $request->input('key');
      $this->WriteFileLog($request->val);
      $htmlContent = $request->input('val');
      $fileName = 'generated_file_' . time() . '.html';
      Storage::disk('local')->put($fileName, $htmlContent);
      $storagePath = public_path();
      // 
      $dompdf = new Dompdf();
      $dompdf->loadHtml($htmlContent);
      $dompdf->render();
      $pdfContent = $dompdf->output();
      $filePath = $storagePath . '/testpdf.pdf';
      file_put_contents($filePath, $pdfContent);
      $buttonHTML = '<a target="_blank" href="' . config('setting.base_url') . '/testpdf.pdf"><button>View</button></a>';
      return $buttonHTML;
      $pdf = PDF::loadView('assessmentreport.assessmentReportTemp', compact('data'))->setPaper('legal', 'potrait');
      $pdf->save($storagePath . '/Assessment_Executive_Report.pdf');

      //dd($request->val);

      // Process the value as needed
      return redirect()->route('original.route.name');
    }

    // This is a GET request, load the initial view
    $data = [
      'father_name' => 'Father',
      'child_name' => 'Sanjay',
      'register_fee' => '8100',
      'in_words' => 'Two Thousand'
    ];
    return view('pdfTemplates.returntest', compact('data'));
  }

  public function gcap()
  {
    return view('gcap');
  }
}
