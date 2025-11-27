<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Filesystem;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Config;
use Illuminate\Http\RedirectResponse;
use NumberFormatter;


class BaseController extends Controller
{
    /**
     * Author: Anbukani
     * Date: 16/09/2019
     * Description: API service request.
     */
    public function serviceRequest($gatewayURL, $action, $body, $method)
    {
        // echo json_encode($body);exit; 
        try {
            $client = new Client();
            $authorization = 'Bearer ' . session('accessToken');
            // echo json_encode($authorization);exit;

            $serviceResponse = $client->request($action, $gatewayURL, [
                'headers' => [
                    'Authorization' => $authorization,
                    'Content-Type' => 'application/json',
                    'Accept' => 'application/json',
                    'Cache-Control' => 'no-cache',
                    'x-custome-cookie' => request()->cookie('elina_uuid'),
                ],
                'body' => $body
            ])->getBody()->getContents();
            $objServiceResponse = json_decode($serviceResponse);

            if ($objServiceResponse->Status == 401) {
                return redirect()->route('unauthenticated')->send();
                return $serviceResponse;
            } else if ($objServiceResponse->Status == 500) {
                return redirect()->route('internal_redirect')->send();
            } else if (!($objServiceResponse->Success)) {
                return redirect()->route('internal_redirect')->send();
            } else {
                return $serviceResponse;
            }
        } catch (\Exception $exc) {
            $exceptionResponse = array();
            $exceptionResponse['ServiceMethod'] = 'Method => BaseController => serviceRequest';
            $exceptionResponse['Exception'] = $exc->getMessage();
            $exceptionResponse = json_encode($exceptionResponse, JSON_FORCE_OBJECT);
            $this->WriteFileLog($exceptionResponse);
            $statusCode = $exc->getCode();
            if ($statusCode == 403) {
                return redirect()->route('multipledevice')->send();
            }
            return 'Failure';
        }
    }

    /**
     * Author: Anbukani
     * Date: 16/09/2019
     * Description: API token request based on username and password.
     */
    public function tokenRequest($userName, $password, $browserUuid)
    {
        try {

            $client = new Client();
            $serviceURL = Config::get('setting.api_gateway_url') . '/service/token';
            // echo $serviceURL;exit;


            $serviceRequest = array();
            $serviceRequest['email'] = $userName;
            $serviceRequest['password'] = $password;
            $serviceRequest['browserUuid'] = $browserUuid;
            $serviceRequest = json_encode($serviceRequest, JSON_FORCE_OBJECT);


            $serviceResponse = $client->request('POST', $serviceURL, [
                'headers' => [
                    'Content-Type' => 'application/json',
                    'Cache-Control' => 'no-cache',
                    'Accept' => 'application/json'
                ],
                'body' => $serviceRequest
            ])->getBody()->getContents();

            //return $response->getBody()->getContents();
            return $serviceResponse;
        } catch (\Exception $exc) {


            $exceptionResponse = array();
            $exceptionResponse['ServiceMethod'] = 'Method => BaseController => tokenRequest';
            $exceptionResponse['Exception'] = $exc->getMessage();
            $exceptionResponse = json_encode($exceptionResponse, JSON_FORCE_OBJECT);
            $this->WriteFileLog($exceptionResponse);
            return 'Failure';
        }
    }

    /**
     * Author: Anbukani
     * Date: 16/09/2019
     * Description: Save token and refresh token into session variable for testing purpose only.
     */
    public function setToken($user, $password, $browserUuid)
    {
        try {
            $serviceResponse = $this->tokenRequest($user, $password, $browserUuid);
            $objServiceResponse = json_decode($serviceResponse);

            // echo json_encode($objServiceResponse);exit;

            if ($objServiceResponse->Status == 200 && $objServiceResponse->Success) {
                $tokenResponse = $this->decryptData($objServiceResponse->Data);
                $objTokenResponse = json_decode($tokenResponse);
                $tokenType = $objTokenResponse->token_type;
                $accessToken = $objTokenResponse->access_token;
                //  dd($objTokenResponse);
                session(['accessToken' => $accessToken]);
                return 'Success';
            } else if ($objServiceResponse->Status == 500) {
                return 'Disabled';
            } else if ($objServiceResponse->Status == 406) {
                return 'Active';
            } else {
                return  'Failure';
            }

            $tokenResponse = $this->decryptData($objServiceResponse->Data);
            $exceptionResponse = array();
            $exceptionResponse['ServiceMethod'] = 'Method => BaseController => setToken';
            $exceptionResponse['Message'] = $tokenResponse;
            $exceptionResponse = json_encode($exceptionResponse, JSON_FORCE_OBJECT);
            $this->WriteFileLog($exceptionResponse);
            if ($objServiceResponse->Status == 401) {
                //echo "dgdgdfg";exit;


                //return redirect()->route('unauthenticated')->send();
            }
            return 'Failure';
        } catch (\Exception $exc) {
            $exceptionResponse = array();
            $exceptionResponse['ServiceMethod'] = 'Method => BaseController => setToken';
            $exceptionResponse['Exception'] = $exc->getMessage();
            $exceptionResponse = json_encode($exceptionResponse, JSON_FORCE_OBJECT);
            $this->WriteFileLog($exceptionResponse);
            return 'Failure';
        }
    }

    /**
     * Author: Anbukani
     * Date: 16/09/2019
     * Description: Encrypt data.
     */
    public function encryptData($data)
    {
        try {

            $d = Crypt::encrypt($data);
            return $d;
        } catch (\Exception $exc) {
            Log::error('Method => BaseController => encryptData => Encrypt data error =>: [' . $exc->getCode() . '] ' . $exc->getMessage());
            return 'Failure';
        }
    }

    /**
     * Author: Anbukani
     * Date: 16/09/2019
     * Description: Decrypt data.
     */
    public function decryptData($data)
    {
        try {
            return Crypt::decrypt($data);
        } catch (\Exception $exc) {
            Log::error('Method => BaseController => decryptData => Decrypt data error =>: [' . $exc->getCode() . '] ' . $exc->getMessage());
            return 'Failure';
        }
    }

    /**
     * Author: Anbukani
     * Date: 04/06/2021
     * Description: Write error in text file.
     **/
    public function WriteFileLog($request)
    {
        try {
            Log::error($request);
        } catch (\Exception $exc) {
            Log::error('Method => BaseController => WriteFileLog => Write log file error =>: [' . $exc->getCode() . '] ' . $exc->getMessage());
        }
    }

    /**
     * Author: Anbukani
     * Date: 16/09/2019
     * Description: Write log file.
     */
    public function sendLog($method, $code, $message, $line, $file)
    {
        try {
            Log::error($method . ': [' . $code . '] "' . $message . '" on line ' . $line . ' of file ' . $file);
            return $this->sendError('Exception Error.', '[' . $code . '] "' . $message . '" on line ' . $line . ' of file ' . $file, 400);
        } catch (\Exception $exc) {
            Log::error('[Decrypt data error => ' . $exc->getCode() . '] "' . $exc->getMessage() . '" on line ' . $exc->getTrace()[0]['line'] . ' of file ' . $exc->getTrace()[0]['file']);
        }
    }

    /**
     * Author: Anbukani
     * Date: 18/08/2021
     * Description: Date display format.
     */
    public function getFormat($df)
    {
        $str = '';
        $str .= ($df->invert == 1) ? ' - ' : '';
        if ($df->y > 0) {
            // years
            $str .= ($df->y > 1) ? $df->y . ' Years ' : $df->y . ' Year ';
        }
        if ($df->m > 0) {
            // month
            $str .= ($df->m > 1) ? $df->m . ' Months ' : $df->m . ' Month ';
        }
        if ($df->d > 0) {
            // days
            $str .= ($df->d > 1) ? $df->d . ' Days ' : $df->d . ' Day ';
        }
        if ($df->h > 0) {
            // hours
            $str .= ($df->h > 1) ? $df->h . ' Hours ' : $df->h . ' Hour ';
        }
        if ($df->i > 0) {
            // minutes
            $str .= ($df->i > 1) ? $df->i . ' Minutes ' : $df->i . ' Minute ';
        }
        if ($df->s > 0) {
            // seconds
            $str .= ($df->s > 1) ? $df->s . ' Seconds ' : $df->s . ' Second ';
        }

        return $str;
    }

    /**
     * Author: Anbukani
     * Date: 16/09/2019
     * Description: Send error message.
     */
    public function sendError($error, $errorMessages = [], $code = 400)
    {
        $response = [
            'Success' => false,
            'Message' => $error,
            'Status' => 400
        ];

        if (!empty($errorMessages)) {
            $response['data'] = $errorMessages;
        }
        return redirect()->route('internal_redirect')->send();
        return response()->json($response, $code);
    }


    public function FillMenu()
    {
        try {
            $method = 'uam => BaseController => FillMenu';
            $gatewayURL = config('setting.api_gateway_url') . '/uam_data/menu_data';
            $response = $this->serviceRequest($gatewayURL, 'GET', '', $method);
            $response = json_decode($response);

            if ($response->Status == 200 && $response->Success) {
                $objData = json_decode($this->decryptData($response->Data));
                if ($objData->Code == 200) {
                    $menu_data = json_decode(json_encode($objData->Data), true);
                    return $menu_data;
                }
            } else {
                $objData = json_decode($this->decryptData($response->Data));
                if (json_encode($objData->Code) == 401) {
                    return json_encode($objData->Code);
                }
                echo json_encode($objData->Code);
                exit;
            }
        } catch (\Exception $exc) {

            return $this->sendLog($method, $exc->getCode(), $exc->getMessage(), $exc->getLine(), $exc->getTrace()[0]['args'][2]);
        }
    }


    public function FillScreensByUser()
    {

        $url =  request()->segment(1); // This doesnot work on the two segments
        //  $url = request()->segment(2) == '' ? request()->segment(1) : request()->segment(1) . '/' . request()->segment(2);

        try {
            $screenurl = $this->encryptData($url);

            $method = 'Method => BaseController => FillScreensByUser';

            $gatewayURL = config('setting.api_gateway_url') . '/uam_data/fillscreensbasedonuser/' . $screenurl;
            $response = $this->serviceRequest($gatewayURL, 'GET', '', $method);
            $response = json_decode($response);

            if ($response->Status == 200 && $response->Success) {
                $objData = json_decode($this->decryptData($response->Data));
                if ($objData->Code == 200) {
                    $menu_data = json_decode(json_encode($objData->Data), true);
                    $screen_permission = $menu_data['screen_permission'];
                    return $screen_permission;
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

    public function FillDyanamiclist()
    {
        $url =  request()->segment(1);
        try {
            $screenurl = $this->encryptData($url);

            $method = 'Method => BaseController => FillScreensByUser';
            $gatewayURL = config('setting.api_gateway_url') . '/uam_data/filldynamiclist/' . $screenurl;
            $response = $this->serviceRequest($gatewayURL, 'GET', '', $method);
            $response = json_decode($response);

            if ($response->Status == 200 && $response->Success) {
                $objData = json_decode($this->decryptData($response->Data));
                if ($objData->Code == 200) {
                    $menu_data = json_decode(json_encode($objData->Data), true);

                    return $menu_data;
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

    public function FillDyanamiclistdocument()
    {
        $seg1 = request()->segment(1);
        $seg2 = request()->segment(2);
        // $seg3 = request()->segment(3);

        $url = $seg1 . '/' . $seg2;

        // $this->WriteFileLog($url);

        try {
            $screenurl = $this->encryptData($url);
            $method = 'Method => BaseController => FillScreensByUser';
            $gatewayURL = config('setting.api_gateway_url') . '/uam_data/filldynamiclist/' . $screenurl;
            $response = $this->serviceRequest($gatewayURL, 'GET', '', $method);
            $response = json_decode($response);

            if ($response->Status == 200 && $response->Success) {
                $objData = json_decode($this->decryptData($response->Data));
                if ($objData->Code == 200) {
                    $menu_data = json_decode(json_encode($objData->Data), true);

                    return $menu_data;
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




    public function FillScreensByDash()
    {
        $url =  request()->segment(1);
        try {
            $screenurl = $this->encryptData($url);
            $method = 'Method => BaseController => FillScreensByDash';
            $gatewayURL = config('setting.api_gateway_url') . '/uam_data/fillscreensbasedondash/' . $screenurl;
            $response = $this->serviceRequest($gatewayURL, 'GET', '', $method);
            $response = json_decode($response);

            if ($response->Status == 200 && $response->Success) {
                $objData = json_decode($this->decryptData($response->Data));
                if ($objData->Code == 200) {
                    $menu_data = json_decode(json_encode($objData->Data), true);
                    $screen_permission = $menu_data['screen_permission'];
                    return $screen_permission;
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



    public function FillScreensByUserScreen()
    {

        $seg1 = request()->segment(1);
        $seg2 = request()->segment(2);
        // $seg3 = request()->segment(3);

        $url = $seg1 . '/' . $seg2;


        //$url =  request()->segment(1);
        try {
            $screenurl = $this->encryptData($url);
            $method = 'Method => BaseController => FillScreensByUserScreen';
            $gatewayURL = config('setting.api_gateway_url') . '/uam_data/fillscreensbasedonuser/' . $screenurl;
            $response = $this->serviceRequest($gatewayURL, 'GET', '', $method);
            $response = json_decode($response);

            if ($response->Status == 200 && $response->Success) {
                $objData = json_decode($this->decryptData($response->Data));
                if ($objData->Code == 200) {
                    $menu_data = json_decode(json_encode($objData->Data), true);
                    $screen_permission = $menu_data['screen_permission'];
                    return $screen_permission;
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



    public function FillScreensByDocument()
    {

        $seg1 = request()->segment(1);
        $seg2 = request()->segment(2);
        $seg3 = request()->segment(3);

        $url = $seg1 . '/' . $seg2 . '/' . $seg3;


        //$url =  request()->segment(1);
        try {
            $screenurl = $this->encryptData($url);
            $method = 'Method => BaseController => FillScreensByDocument';
            $gatewayURL = config('setting.api_gateway_url') . '/uam_data/fillscreensbasedondocument/' . $screenurl;
            $response = $this->serviceRequest($gatewayURL, 'GET', '', $method);
            $response = json_decode($response);

            if ($response->Status == 200 && $response->Success) {
                $objData = json_decode($this->decryptData($response->Data));
                if ($objData->Code == 200) {
                    $menu_data = json_decode(json_encode($objData->Data), true);
                    $screen_permission = $menu_data['screen_permission'];
                    return $screen_permission;
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


    public function FillScreensByDocument_file()
    {

        // $seg1 = request()->segment(1);
        // $seg2 = request()->segment(2);
        // $seg3 = request()->segment(3);

        $url = "folder/file/index";


        //$url =  request()->segment(1);
        try {
            $screenurl = $this->encryptData($url);
            $method = 'Method => BaseController => FillScreensByDocument';
            $gatewayURL = config('setting.api_gateway_url') . '/uam_data/fillscreensbasedondocument/' . $screenurl;
            $response = $this->serviceRequest($gatewayURL, 'GET', '', $method);
            $response = json_decode($response);

            if ($response->Status == 200 && $response->Success) {
                $objData = json_decode($this->decryptData($response->Data));
                if ($objData->Code == 200) {
                    $menu_data = json_decode(json_encode($objData->Data), true);
                    $screen_permission = $menu_data['screen_permission'];
                    return $screen_permission;
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


    public function numberToWords($number)
    {
        $formatter = new NumberFormatter('en', NumberFormatter::SPELLOUT);
        $words = $formatter->format($number);
        return ucwords($words);
    }
}
